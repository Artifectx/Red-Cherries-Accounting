<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collect_donations_controller extends CI_Controller {

	public function  __construct() {
		parent::__construct();
		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//current date time
		$this->date = date("Y-m-d H:i");

		//load language
		$language = $this->userManagement->getUserLanguage($this->user_id);

		$this->lang->load('form_lang', $language);
		$this->lang->load('message', $language);

		//get user theme
		$this->data['theme'] = $this->userManagement->getUserTheme($this->user_id);

		//get user permission
		$this->data = $this->userManagement->getUserPermissions($this->data);

		//Load version number
		$this->data['version_no'] = $this->userManagement->getSystemVersionNumber();

		$this->data['show_footer'] = true;

		//load models
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/donationSection/donations_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/adminSection/programs_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function index() {
		//set selected menu
		$data_cls['ul_class_donation_section'] = 'in nav nav-stacked';
		$data_cls['li_class_collect_donations'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_donation_manager', $data_cls);
		
		if(isset($this->data['SVM_DSM_Donation_View_Collect_Donations_Permissions'])) {
			$this->load->view('web/serviceManagerModule/donationManagerModule/donationSection/collectDonations/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['SVM_DSM_Donation_Add_Collect_Donations_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$programId = $this->db->escape_str($this->input->post('program_id'));
				$date = $this->db->escape_str($this->input->post('date'));
				$amount = $this->db->escape_str($this->input->post('amount'));
				
				$programData = $this->programs_model->getById($programId);
				$locationId = $programData[0]->location_id;
				$fundAvailable = $programData[0]->fund_available;
				
				$correctChartOfAccountsFoundInPrimeEntryBooks = true;

				if ($this->isDonationProgramWiseChartOfAccountInformationEnabled()) {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForCollectDonationForProgramTransaction($programId);
				} else {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForCollectDonationTransaction();
				}

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
						foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
							$primeEntryBookId = $primeEntryBook->config_filed_value;
							$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

							if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
								$correctChartOfAccountsFoundInPrimeEntryBooks = false;
							}
						}
					}
				}

				if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
					
					$data = array(
						'reference_no' => $referenceNo,
						'program_id' => $programId,
						'date' => $date,
						'donor_id' => $this->db->escape_str($this->input->post('donor_id')),
						'amount' => $amount,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);

					$donationId = $this->donations_model->add($data);
					
					$fundAvailable = $fundAvailable + $amount;
					
					$programDataNew = array(
						'fund_available' => $fundAvailable,
					);
					
					$this->programs_model->edit($programId, $programDataNew);
					
					if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
						//Add journal entry records

						if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
							foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
								$primeEntryBookId = $primeEntryBook->config_filed_value;
								$data = array(
									'prime_entry_book_id' => $primeEntryBookId,
									'transaction_date' => $date,
									'reference_no' => $referenceNo,
									'location_id' => $locationId,
									'description' => $this->lang->line('Journal entry for donation collection with reference number : ') . $referenceNo,
									'post_type' => "Indirect",
									'actioned_user_id' => $this->user_id,
									'action_date' => $this->date,
									'last_action_status' => 'added'
								);

								$journalEntryId = $this->journal_entries_model->addJournalEntry($data);
								
								$data = array(
									'donation_id' => $donationId,
									'prime_entry_book_id' => $primeEntryBookId,
									'journal_entry_id' => $journalEntryId,
									'actioned_user_id' => $this->user_id,
									'action_date' => $this->date,
									'last_action_status' => 'added'
								);

								$this->donations_model->addDonationJournalEntry($data);

								$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
								$amount = str_replace(',', '', $amount);

								foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
									if ($chartOfAccount->debit_or_credit == "debit") {
										$data = array(
											'journal_entry_id' => $journalEntryId,
											'prime_entry_book_id' => $primeEntryBookId,
											'transaction_date' => $date,
											'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
											'debit_value' => $amount,
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
									} else if ($chartOfAccount->debit_or_credit == "credit") {
										$data = array(
											'journal_entry_id' => $journalEntryId,
											'prime_entry_book_id' => $primeEntryBookId,
											'transaction_date' => $date,
											'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
											'credit_value' => $amount,
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
									}

									$this->journal_entries_model->addGeneralLedgerTransaction($data);

									//Same time add the data to previous years record table.
									$this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
								}
							}
						}
					}
					
					$result = 'ok';
				}  else {
					$result = 'incorrect_prime_entry_book_selected_for_collect_donation_transaction';
				}
				
				echo $result;
			}
		}
	}

	public function edit() {
		if(isset($this->data['SVM_DSM_Donation_Edit_Collect_Donations_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$referenceNoChanged = false;
				$programChanged = false;
				$dateChanged = false;
				$donorChanged = false;
				$amountChanged = false;
				
				$donationId = $this->db->escape_str($this->input->post('id'));
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$programId = $this->db->escape_str($this->input->post('program_id'));
				$donorId = $this->db->escape_str($this->input->post('donor_id'));
				$date = $this->db->escape_str($this->input->post('date'));
				$amount = $this->db->escape_str($this->input->post('amount'));
				
				$donationData = $this->donations_model->getById($donationId);
				
				$referenceNoOld = $donationData[0]->reference_no;
				$programIdOld = $donationData[0]->program_id;
				$dateOld = $donationData[0]->date;
				$donorIdOld = $donationData[0]->donor_id;
				$amountOld = $donationData[0]->amount;
				
				if ($referenceNo != $referenceNoOld) {$referenceNoChanged = true;}
				if ($programId != $programIdOld) {$programChanged = true;}
				if ($date != $dateOld) {$dateChanged = true;}
				if ($donorId != $donorIdOld) {$donorChanged = true;}
				if ($amount != $amountOld) {$amountChanged = true;}

				$correctChartOfAccountsFoundInPrimeEntryBooks = true;

				if ($this->isDonationProgramWiseChartOfAccountInformationEnabled()) {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForCollectDonationForProgramTransaction($programId);
				} else {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForCollectDonationTransaction();
				}

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
						foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
							$primeEntryBookId = $primeEntryBook->config_filed_value;
							$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

							if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
								$correctChartOfAccountsFoundInPrimeEntryBooks = false;
							}
						}
					}
				}

				if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {

					if ($referenceNoChanged || $programChanged || $dateChanged || $donorChanged || $amountChanged) {
						
						$dataHistory = array(
							'reference_no' => $referenceNoOld,
							'program_id' => $programIdOld,
							'date' => $dateOld,
							'donor_id' => $donorIdOld,
							'amount' => $amountOld,
							'actioned_user_id' => $donationData[0]->actioned_user_id,
							'action_date' => $donationData[0]->action_date,
							'last_action_status' => $donationData[0]->last_action_status
						);

						$this->donations_model->addDonationDataToHistory($dataHistory);
						
						$dataNew = array(
							'reference_no' => $referenceNo,
							'program_id' => $programId,
							'date' => $date,
							'donor_id' => $donorId,
							'amount' => $amount,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'edited'
						);

						$this->donations_model->edit($donationId, $dataNew);
						
						$programData = $this->programs_model->getById($programId);
						$fundAvailable = $programData[0]->fund_available;
				
						$fundAvailable = ($fundAvailable - $amountOld) + $amount;
					
						$programDataNew = array(
							'fund_available' => $fundAvailable,
						);

						$this->programs_model->edit($programId, $programDataNew);

						$donationJournalEntries = $this->donations_model->getDonationJournalEntries($donationId);

						if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
							if ($donationJournalEntries && sizeof($donationJournalEntries) > 0) {
								//Get general ledger transactions to update new amount
								foreach($donationJournalEntries as $donationJournalEntry) {
									$donationPrimeEntryBookId = $donationJournalEntry->prime_entry_book_id;
									$donationJournalEntryId = $donationJournalEntry->journal_entry_id;

									$donationGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($donationJournalEntryId, 
																								  $donationPrimeEntryBookId);
									$amount = str_replace(',', '', $amount);

									foreach($donationGeneralLedgerTransactions as $donationGeneralLedgerTransaction) {
										if ($donationGeneralLedgerTransaction->debit_value != '0.00') {
											$data = array(
												'debit_value' => $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($donationJournalEntryId, $donationGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($donationJournalEntryId, $donationGeneralLedgerTransaction->chart_of_account_id, $data);
										} else if ($donationGeneralLedgerTransaction->credit_value != '0.00') {
											$data = array(
												'credit_value' => $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($donationJournalEntryId, $donationGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($donationJournalEntryId, $donationGeneralLedgerTransaction->chart_of_account_id, $data);
										}
									}
								}
							}
						}

						$result = "ok";
					} else {
						$result = "no_changes_to_save";
					}
				}  else {
					$result = 'incorrect_prime_entry_book_selected_for_collect_donation_transaction';
				}
				
				echo $result;
			}
		}
	}

	public function delete() {
		if(isset($this->data['SVM_DSM_Donation_Delete_Collect_Donations_Permissions'])) {
			$status = 'deleted';
			$donationId = $this->db->escape_str($this->input->post('id'));
			
			$donationJournalEntries = $this->donations_model->getDonationJournalEntries($donationId);
			
			if ($donationJournalEntries && sizeof($donationJournalEntries) > 0) {
				//Delete all journal entries of GDN
				foreach($donationJournalEntries as $donationJournalEntry) {
					$donationJournalEntryId = $donationJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($donationJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($donationJournalEntryId, $status, $this->user_id);
				}
			}
			
			$donationData = $this->donations_model->getById($donationId);
				
			$programId = $donationData[0]->program_id;
			$amount = $donationData[0]->amount;
			$programData = $this->programs_model->getById($programId);
			$fundAvailable = $programData[0]->fund_available;

			$fundAvailable = $fundAvailable - $amount;

			$programDataNew = array(
				'fund_available' => $fundAvailable,
			);

			$this->programs_model->edit($programId, $programDataNew);
				
			if ($this->donations_model->delete($donationId, $status,$this->user_id)) {
					
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}
			
			echo($html);
		}

	}

	public function get() {
		if(isset($this->data['SVM_DSM_Donation_Edit_Collect_Donations_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$donationData = $this->donations_model->getById($id);
			$html = "";
			if ($donationData != null) {
				foreach ($donationData as $row) {
					
					$programList = $this->programs_model->getAllProgramsToDropDownWithSavedOption($row->program_id);
					
					$html .= "<form class='form form-horizontal validate-form save_form'>
							<input class='form-control'  data-rule-required='true' id='donation_id' name='donation_id' type='hidden' value='{$row->donation_id}'>

							<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Reference Number')} *</label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='reference_no_edit'
										name='amount_edit' placeholder='{$this->lang->line('Reference Number')}' value='{$row->reference_no}'>
									<div id='reference_no_editError' class='red'></div>
								</div>
							</div>
							<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Program Name')} *</label>
								<div class='col-sm-4 controls'>
									<select class='form-control' id='program_id_edit'>
										{$programList}
									</select>
									<div id='program_id_editError' class='red'></div>
								</div>
							</div>
							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Date')} *</label>
								<div class='col-sm-4 controls'>
									<div class='datepicker-input input-group' id='datepicker_edit'>
										<input class='form-control' id='date_edit' name='date_edit'
											data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$row->date}'>
										<span class='input-group-addon'>
											<span class='glyphicon glyphicon-calendar'/>
										</span>
									</div>
									<div id='date_editError' class='red'></div>
								</div>
							</div>";

					$people= $this->peoples_model->getEmployeesAndMembersToDropDownWithSavedOption($row->donor_id, "People Name");

					$html .= "  <div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Donor')} *</label>
								<div class='col-sm-4 controls'>
									<select class='form-control' id='donor_id_edit'>
										{$people}
									</select>
									<div id='donor_id_editError' class='red'></div>
								</div>
							</div>";
										
					$amount = str_replace(",", "", number_format($row->amount, 2));
							
			$html .= "			<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Amount')} *</label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='amount_edit'
										name='amount_edit' placeholder='{$this->lang->line('Amount')}' onblur='handleAmountAddition(this.id);' value='{$amount}'>
									<div id='amount_editError' class='red'></div>
								</div>
							</div>

							<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
					if(isset($this->data['SVM_DSM_Admin_Edit_Programs_Permissions'])) {
						$html .= "<button class='btn btn-success save' onclick='editData();' type='button'>
											<i class='icon-save'></i>
											{$this->lang->line('Edit')}
										</button> ";
					}
					$html.="<button class='btn btn-primary' type='reset'>
											<i class='icon-undo'></i>
											{$this->lang->line('Refresh')}
										</button>
										<button class='btn btn-warning cancel' onclick='cancelData();' type='button'>
											<i class='icon-ban-circle'></i>
											{$this->lang->line('Close')}
										</button>
									</div>
								</div>
							</div>
						</form>";
				}
			}
			
			echo $html;
		}
	}

	public function getTableData() {
		if(isset($this->data['SVM_DSM_Donation_View_Collect_Donations_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered donationsTable'
								   style='margin-bottom:0;'>
								<thead>";
						$html.="   <tr>
									<th>{$this->lang->line('Date') }</th>
									<th>{$this->lang->line('Reference No') }</th>
									<th>{$this->lang->line('Program Name') }</th>
									<th>{$this->lang->line('Program Coordinator') }</th>
									<th>{$this->lang->line('Donor') }</th>
									<th>{$this->lang->line('Amount') }</th>
									<th>{$this->lang->line('Actions')}</th>
								</tr>
								</thead>
								<tbody>";
									
			$donations = $this->donations_model->getAll('date', 'desc');
			
			if ($donations != null) {
				foreach ($donations as $row) {
					
					$coordinatorId = $row->coordinator_id;
					$coordinator = $this->peoples_model->getById($coordinatorId);
					$coordinatorName = $coordinator[0]->people_name;
					
					$donorId = $row->donor_id;
					$donor = $this->peoples_model->getById($donorId);
					$donorName = $donor[0]->people_name;
					
					$html .= "<tr>";
					$html .= "<td>" . $row->date . "</td>";
					$html .= "<td>" . $row->reference_no . "</td>";
					$html .= "<td>" . $row->program_name . "</td>";
					$html .= "<td>" . $coordinatorName . "</td>";
					$html .= "<td>" . $donorName . "</td>";
					$html .= "<td>" . number_format($row->amount, 2) . "</td>";
					$html .= "<td><div class='text-left'>";
					if(isset($this->data['SVM_DSM_Donation_Edit_Collect_Donations_Permissions'])) {
						$html .="<a class='btn btn-warning btn-xs get' data-id='{$row->donation_id}' title='Edit' onclick='get($row->donation_id);'>
								 <i class='icon-wrench'></i></a> ";
					}
					if(isset($this->data['SVM_DSM_Donation_Delete_Collect_Donations_Permissions'])) {
						$html .="<a class='btn btn-danger btn-xs delete' data-id='{$row->donation_id}' title='Delete' onclick='del($row->donation_id);'>
								 <i class='icon-remove'></i></a>";
					}
					$html .= "  </div>
						</td>
						</tr>";
				}
			}
			$html .="</tbody>
							</table>
						</div>
					</div>
				</div>";
			
			echo $html;
		}
	}
	
	public function isDonationProgramWiseChartOfAccountInformationEnabled() {
		return $this->system_configurations_model->isDonationProgramWiseChartOfAccountInformationEnabled();
	}
	
	public function getPrimeEntryBooksToUpdateForCollectDonationTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getCollectDonationAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForCollectDonationForProgramTransaction($programId) {
		$primeEntryBooks = $this->system_configurations_model->getPrimeEntryBooksToUpdateForCollectDonationForProgramTransaction($programId);

		return $primeEntryBooks;
	}
}