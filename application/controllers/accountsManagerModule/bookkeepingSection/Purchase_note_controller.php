<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_note_controller extends CI_Controller {

	public function  __construct() {
		parent::__construct();
		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//get employee id
		$this->employee_id = $this->userManagement->getPeopleId();

		//get user name
		$this->user_name = $this->userManagement->getUserName();

		//current date time
		$this->date = date("Y-m-d H:i:s");

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
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/purchase_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/make_payment_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/receive_payment_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);

		$this->load->library('common_library/common_functions');

		$this->load->library('Pdf_reports');

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
	}

	public function index() {
		//set selected menu
		$data_cls['ul_class_bookkeeping_section'] = 'in nav nav-stacked';
		$data_cls['li_class_purchase_note'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['purchase_note_no_auto_increment_status'] = $this->isPurchaseNoteNumberAutoIncrementEnabled();

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

		if(isset($this->data['ACM_Bookkeeping_View_Purchase_Note_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/purchaseNote/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['ACM_Bookkeeping_Add_Purchase_Note_Permissions'])) {
			$purchaseNoteId = '';
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$purchaseNoteDate = $this->db->escape_str($this->input->post('purchase_note_date'));
				$supplierId = $this->db->escape_str($this->input->post('supplier_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
				$amount = $this->db->escape_str($this->input->post('amount'));
				$type = $this->db->escape_str($this->input->post('type'));
				$remark = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('remark')));

				$data = array(
					'reference_no' => $referenceNo,
					'date' => $purchaseNoteDate,
					'supplier_id' => $supplierId,
					'location_id' => $locationId,
					'amount' => $amount,
                    'balance_payment' => $amount,
					'type' => $type,
					'remark' => $remark,
					'actioned_user_id' => $this->user_id,
					'added_date' => $this->date,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$purchaseNoteId = $this->purchase_note_model->add($data);
				
				$purchaseNoteJournalEntries = $this->purchase_note_model->getPurchaseNoteJournalEntries($purchaseNoteId);
				
				$correctChartOfAccountsFoundInPrimeEntryBooks = true;

				$description = "";
				if ($type == "product_purchase") {
					$description = $this->lang->line('Journal entry for receiving sales items for Purchase Note number : ') . $referenceNo;
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForPurchaseNoteTransaction();
				} else if ($type == "receive_free_issues") {
					$description = $this->lang->line('Journal entry for receiving free items for Purchase Note number : ') . $referenceNo;
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForPurchaseNoteFreeIssuesTransaction();
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
					if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
						if (!$purchaseNoteJournalEntries) {
							//Add journal entry records
                            
                            $shouldHaveAPaymentJournalEntry = "Yes";
                            
                            if ($type == "receive_free_issues") {
                                $shouldHaveAPaymentJournalEntry = "No";
                            }

							if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
								foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
									$primeEntryBookId = $primeEntryBook->config_filed_value;
									$data = array(
										'prime_entry_book_id' => $primeEntryBookId,
										'transaction_date' => $purchaseNoteDate,
										'reference_no' => $referenceNo,
										'should_have_a_payment_journal_entry' => $shouldHaveAPaymentJournalEntry,
										'location_id' => $locationId,
										'payee_payer_type' => "Supplier",
										'payee_payer_id' => $supplierId,
										'description' => $description,
										'post_type' => "Indirect",
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'added'
									);

									$journalEntryId = $this->journal_entries_model->addJournalEntry($data);

									$data = array(
										'purchase_note_id' => $purchaseNoteId,
										'prime_entry_book_id' => $primeEntryBookId,
										'journal_entry_id' => $journalEntryId,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'added'
									);

									$this->purchase_note_model->addPurchaseNoteJournalEntry($data);

									$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
									$amount = str_replace(',', '', $amount);

									foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
										if ($chartOfAccount->debit_or_credit == "debit") {
											$data = array(
												'journal_entry_id' => $journalEntryId,
												'prime_entry_book_id' => $primeEntryBookId,
												'transaction_date' => $purchaseNoteDate,
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
												'transaction_date' => $purchaseNoteDate,
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
						} else if ($purchaseNoteJournalEntries && sizeof($purchaseNoteJournalEntries) > 0) {
							//Get general ledger transactions to update new amount
							foreach($purchaseNoteJournalEntries as $purchaseNoteJournalEntry) {
								$purchaseNotePrimeEntryBookId = $purchaseNoteJournalEntry->prime_entry_book_id;
								$purchaseNoteJournalEntryId = $purchaseNoteJournalEntry->journal_entry_id;

								$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($purchaseNotePrimeEntryBookId);
								$purchaseNoteGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($purchaseNoteJournalEntryId, $purchaseNotePrimeEntryBookId);
								$amount = str_replace(',', '', $amount);

								foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
									foreach($purchaseNoteGeneralLedgerTransactions as $purchaseNoteGeneralLedgerTransaction) {
										if ($purchaseNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
											$data = array(
												'debit_value' => $purchaseNoteGeneralLedgerTransaction->debit_value + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);
										} else if ($purchaseNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
											$data = array(
												'credit_value' => $purchaseNoteGeneralLedgerTransaction->credit_value + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);
										}
									}
								}
							}
						}
					} 
				}else {
					$result = 'incorrect_prime_entry_book_selected_for_purchase_note_transaction';
				}

				$result = 'ok';
			}

			echo json_encode(array('result' => $result));
		}
	}

	public function editPurchaseNoteData() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Purchase_Note_Permissions'])) {
			$purchaseNoteId = '';
			if ($this->form_validation->run() == FALSE) {
				$result = validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNoChanged = false;
				$supplierChanged = false;
				$locationChanged = false;
				$purchaseNoteDateChanged = false;
				$typeChanged = false;
				$amountChanged = false;
				$remarkChanged = false;

				//Read New Purchase Note Data
				$purchaseNoteId = $this->db->escape_str($this->input->post('id'));
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$purchaseNoteDate = $this->db->escape_str($this->input->post('purchase_note_date'));
				$supplierId = $this->db->escape_str($this->input->post('supplier_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
				$type = $this->db->escape_str($this->input->post('type'));
				$amount = $this->db->escape_str($this->input->post('amount'));
				$remark = $this->db->escape_str($this->input->post('remark'));
				$remark = preg_replace('~\\\n~',"\r\n", $remark);

				$purchaseNote = $this->purchase_note_model->getPurchaseNoteById($purchaseNoteId);
				$oldAmount = $purchaseNote[0]->amount;

				if ($purchaseNote[0]->reference_no != $referenceNo) {$referenceNoChanged = true;}
				if ($purchaseNote[0]->supplier_id != $supplierId) {$supplierChanged = true;}
				if ($purchaseNote[0]->location_id != $locationId) {$locationChanged = true;}
				if ($purchaseNote[0]->date != $purchaseNoteDate) {$purchaseNoteDateChanged = true;}
				if ($purchaseNote[0]->type != $type) {$typeChanged = true;}
				if ($purchaseNote[0]->amount != $amount) {$amountChanged = true;}
				if ($purchaseNote[0]->remark != $remark) {$remarkChanged = true;}

				if ($referenceNoChanged || $supplierChanged || $locationChanged || $purchaseNoteDateChanged || $typeChanged || $amountChanged || 
				    $remarkChanged) {

					$purchaseNoteDataHistory = array(
						'purchase_note_id' => $purchaseNote[0]->purchase_note_id,
						'reference_no' => $purchaseNote[0]->reference_no,
						'supplier_id' => $purchaseNote[0]->supplier_id,
						'location_id' => $purchaseNote[0]->location_id,
						'date' => $purchaseNote[0]->date,
						'type' => $purchaseNote[0]->type,
						'amount' => $purchaseNote[0]->amount,
                        'cash_payment_amount' => $purchaseNote[0]->cash_payment_amount,
                        'cheque_payment_amount' => $purchaseNote[0]->cheque_payment_amount,
                        'credit_card_payment_amount' => $purchaseNote[0]->credit_card_payment_amount,
                        'balance_payment' => $purchaseNote[0]->balance_payment,
                        'supplier_return_note_claimed' => $purchaseNote[0]->supplier_return_note_claimed,
						'remark' => $purchaseNote[0]->remark,
						'actioned_user_id' => $purchaseNote[0]->actioned_user_id,
						'added_date' => $purchaseNote[0]->added_date,
						'action_date' => $purchaseNote[0]->action_date,
						'last_action_status' => $purchaseNote[0]->last_action_status,
					);

					$this->purchase_note_model->addPurchaseNoteDataToHistory($purchaseNoteDataHistory);

                    $balancePayment = $purchaseNote[0]->balance_payment;
                    $purchaseNoteAmountChange = $amount - $purchaseNote[0]->amount;
                    $balancePayment = $balancePayment + $purchaseNoteAmountChange;
                    
					$purchaseNoteDatanew = array(
						'reference_no' => $referenceNo,
						'supplier_id' => $supplierId,
						'location_id' => $locationId,
						'date' => $purchaseNoteDate,
						'type' => $type,
						'amount' => $amount,
                        'balance_payment' => $balancePayment,
						'remark' => $remark,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->purchase_note_model->editPurchaseNoteData($purchaseNoteId, $purchaseNoteDatanew);

					$result = 'ok';
					
					if (!$typeChanged) {
						$purchaseNoteJournalEntries = $this->purchase_note_model->getPurchaseNoteJournalEntries($purchaseNoteId);

						if ($purchaseNoteJournalEntries && sizeof($purchaseNoteJournalEntries) > 0) {
							//Get general ledger transactions to update new location
							foreach($purchaseNoteJournalEntries as $purchaseNoteJournalEntry) {

								$purchaseNoteJournalEntryId = $purchaseNoteJournalEntry->journal_entry_id;

								$data = array(
									'transaction_date' => $purchaseNoteDate,
									'location_id' => $locationId,
									'payee_payer_id' => $supplierId,
									'actioned_user_id' => $this->user_id,
									'action_date' => $this->date,
									'last_action_status' => 'edited'
								);

								$this->journal_entries_model->editJournalEntry($purchaseNoteJournalEntryId, $data);
							}

							if ($type == "product_purchase") {
								$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForPurchaseNoteTransaction();
							} else if ($type == "receive_free_issues") {
								$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForPurchaseNoteFreeIssuesTransaction();
							}

							if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
								if ($purchaseNoteJournalEntries && sizeof($purchaseNoteJournalEntries) > 0) {
									//Get general ledger transactions to update new amount
									foreach($purchaseNoteJournalEntries as $purchaseNoteJournalEntry) {
										$purchaseNotePrimeEntryBookId = $purchaseNoteJournalEntry->prime_entry_book_id;
										$purchaseNoteJournalEntryId = $purchaseNoteJournalEntry->journal_entry_id;

										$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($purchaseNotePrimeEntryBookId);
										$purchaseNoteGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($purchaseNoteJournalEntryId, $purchaseNotePrimeEntryBookId);
										$amount = str_replace(',', '', $amount);

										if ($purchaseNoteGeneralLedgerTransactions && sizeof($purchaseNoteGeneralLedgerTransactions) > 0) {
											foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
												foreach($purchaseNoteGeneralLedgerTransactions as $purchaseNoteGeneralLedgerTransaction) {
													if ($purchaseNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
														$data = array(
															'debit_value' => ($purchaseNoteGeneralLedgerTransaction->debit_value - $oldAmount) + $amount,
															'actioned_user_id' => $this->user_id,
															'action_date' => $this->date,
															'last_action_status' => 'edited'
														);

														$this->journal_entries_model->editGeneralLedgerTransaction($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);

														//Same time edit the data in previous years record table.
														$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);
													} else if ($purchaseNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
														$data = array(
															'credit_value' => ($purchaseNoteGeneralLedgerTransaction->credit_value - $oldAmount) + $amount,
															'actioned_user_id' => $this->user_id,
															'action_date' => $this->date,
															'last_action_status' => 'edited'
														);

														$this->journal_entries_model->editGeneralLedgerTransaction($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);

														//Same time edit the data in previous years record table.
														$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($purchaseNoteJournalEntryId, $purchaseNoteGeneralLedgerTransaction->chart_of_account_id, $data);
													}
												}
											}
										} else {
											foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
												if ($chartOfAccount->debit_or_credit == "debit") {
													$data = array(
														'journal_entry_id' => $purchaseNoteJournalEntryId,
														'prime_entry_book_id' => $purchaseNotePrimeEntryBookId,
														'transaction_date' => $purchaseNoteDate,
														'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
														'debit_value' => $amount,
														'actioned_user_id' => $this->user_id,
														'action_date' => $this->date,
														'last_action_status' => 'added'
													);
												} else if ($chartOfAccount->debit_or_credit == "credit") {
													$data = array(
														'journal_entry_id' => $purchaseNoteJournalEntryId,
														'prime_entry_book_id' => $purchaseNotePrimeEntryBookId,
														'transaction_date' => $purchaseNoteDate,
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
							}
						}
					} else {
						$purchaseNoteJournalEntries = $this->purchase_note_model->getPurchaseNoteJournalEntries($purchaseNoteId);

						$status = "deleted";
						if ($purchaseNoteJournalEntries && sizeof($purchaseNoteJournalEntries) > 0) {
							//Delete all journal entries of Purchase Note
							foreach($purchaseNoteJournalEntries as $purchaseNoteJournalEntry) {
								$purchaseNoteJournalEntryId = $purchaseNoteJournalEntry->journal_entry_id;
								$this->journal_entries_model->deleteJournalEntry($purchaseNoteJournalEntryId, $status, $this->user_id);
								$this->journal_entries_model->deleteGeneralLedgerTransactions($purchaseNoteJournalEntryId, $status, $this->user_id);
							}
						}
						
						$correctChartOfAccountsFoundInPrimeEntryBooks = true;

						if ($type == "product_purchase") {
							$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForPurchaseNoteTransaction();
						} else if ($type == "receive_free_issues") {
							$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForPurchaseNoteFreeIssuesTransaction();
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
							if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
								
								if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
									foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
										$primeEntryBookId = $primeEntryBook->config_filed_value;
										$data = array(
											'prime_entry_book_id' => $primeEntryBookId,
											'transaction_date' => $purchaseNoteDate,
											'reference_no' => $referenceNo,
											'should_have_a_payment_journal_entry' => "Yes",
											'location_id' => $locationId,
											'payee_payer_type' => "Supplier",
											'payee_payer_id' => $supplierId,
											'description' => $this->lang->line('Journal entry for Purchase Note number : ') . $referenceNo,
											'post_type' => "Indirect",
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);

										$journalEntryId = $this->journal_entries_model->addJournalEntry($data);

										$data = array(
											'purchase_note_id' => $purchaseNoteId,
											'prime_entry_book_id' => $primeEntryBookId,
											'journal_entry_id' => $journalEntryId,
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);

										$this->purchase_note_model->addPurchaseNoteJournalEntry($data);

										$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
										$amount = str_replace(',', '', $amount);

										foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
											if ($chartOfAccount->debit_or_credit == "debit") {
												$data = array(
													'journal_entry_id' => $journalEntryId,
													'prime_entry_book_id' => $primeEntryBookId,
													'transaction_date' => $purchaseNoteDate,
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
													'transaction_date' => $purchaseNoteDate,
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
						}else {
							$result = 'incorrect_prime_entry_book_selected_for_purchase_note_transaction';
						}
					}
				} else {
					$result = 'no_changes_to_save';
				}
			}

			echo json_encode(array('result' => $result, 'purchaseNoteId' => $purchaseNoteId));
		}
	}

	//Delete Purchase Note
	public function deletePurchaseNote() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Purchase_Note_Permissions'])) {
			$purchaseNoteId = $this->db->escape_str($this->input->post('id'));
            
            $isReferenceTransactionUsedInMakePayments = $this->make_payment_model->isReferenceTransactionUsedInMakePayments('1', $purchaseNoteId);
            $isReferenceTransactionUsedInReceivePayments = $this->receive_payment_model->isReferenceTransactionUsedInReceivePayments('1', $purchaseNoteId);

            $html = '';
            
            if (!$isReferenceTransactionUsedInMakePayments && !$isReferenceTransactionUsedInReceivePayments) {
                
                $purchaseNoteJournalEntries = $this->purchase_note_model->getPurchaseNoteJournalEntries($purchaseNoteId);

                $status = "deleted";
                if ($purchaseNoteJournalEntries && sizeof($purchaseNoteJournalEntries) > 0) {
                    //Delete all journal entries of Purchase Note
                    foreach($purchaseNoteJournalEntries as $purchaseNoteJournalEntry) {
                        $purchaseNoteJournalEntryId = $purchaseNoteJournalEntry->journal_entry_id;
                        $this->journal_entries_model->deleteJournalEntry($purchaseNoteJournalEntryId, $status, $this->user_id);
                        $this->journal_entries_model->deleteGeneralLedgerTransactions($purchaseNoteJournalEntryId, $status, $this->user_id);
                    }
                }

                if ($this->purchase_note_model->deletePurchaseNote($purchaseNoteId, $status,$this->user_id)) {
                    $html = '<div class="alert alert-success alert-dismissable">
                        <a class="close" href="#" data-dismiss="alert">x </a>
                        <h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
                        $this->lang->line('success_deleted') .
                        '</div>';
                }
            } else {
                $html = '<div class="alert alert-warning alert-dismissable">
                            <a class="close" href="#" data-dismiss="alert">x </a>
                            <h4><i class="icon-ok-sign"></i>' . $this->lang->line('warning') . '</h4>' .
                            $this->lang->line('Purchase Note already used in make payment and receive payment transactions and cannot be deleted!') .
                        '</div>';
            }
            
			echo $html;
		}
	}

	public function getPurchaseNoteData() {
		if(isset($this->data['ACM_Bookkeeping_View_Purchase_Note_Permissions'])) {
			$purchaseNoteId = $this->db->escape_str($this->input->post('id'));
			$purchaseNote = $this->purchase_note_model->getPurchaseNoteById($purchaseNoteId);
			$html = "";
			if ($purchaseNote != null) {
				foreach ($purchaseNote as $row) {
					$html .="   <form class='form form-horizontal validate-form save_form'>
								<div class='form-group'>
									<input class='form-control'   id='purchase_note_id' name='purchase_note_id' type='hidden' value='{$row->purchase_note_id}'>
									<label class='control-label col-sm-3'>{$this->lang->line('Reference No')} *</label>
									<div class='col-sm-4 controls'>
										<input class='form-control'  id='reference_no_edit' name='reference_no_edit'
											placeholder='{$this->lang->line('Reference No')}' type='text' value='{$row->reference_no}'>
										<div id='reference_no_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Date')} *</label>
									<div class='col-sm-4 controls'>
										<div class='datepicker-input input-group' id='datepicker_edit'>
											<input class='form-control' id='purchase_note_date_edit' name='purchase_note_date_edit'
												data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$row->date}'>
											<span class='input-group-addon'>
												<span class='glyphicon glyphicon-calendar'/>
											</span>
										</div>
										<div id='purchase_note_date_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Supplier')} *</label>
									<div class='col-sm-4 controls'>
										<select class='select2 form-control' id='supplier_id_edit'>";
					$html .=                   $this->peoples_model->getSuppliersToDropDownWithSavedOption($row->supplier_id, "People Name");
					$html .="               </select>
									<div id='supplier_id_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Location')} *</label>
									<div class='col-sm-4 controls'>
										<select class='select2 form-control' id='location_edit'>";
							
					$html .=                   $this->locations_model->getLocationsToDropDownWithSavedOption($row->location_id, 'Location Name');
					$html .="               </select>
									<div id='location_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-3 controls'></div>
									<div class='col-sm-5 controls'>
										<input type='checkbox' name='purchase_products_edit' id='purchase_products_edit' style='vertical-align: text-bottom;' onchange='handlePurchaseProductsSelect(this.id);'";
								if ($row->type == "product_purchase") {
							$html .=" checked";		
								}
				$html .="			>
										<label for='purchase_products_edit' >{$this->lang->line('Purchase Products')}</label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-3 controls'></div>
									<div class='col-sm-5 controls'>
										<input type='checkbox' name='receive_free_issue_products_edit' id='receive_free_issue_products_edit' style='vertical-align: text-bottom;' onchange='handleReceiveFreeIssueProductsSelect(this.id);'";
								if ($row->type == "receive_free_issues") {
							$html .=" checked";		
								}
				$html .="			>
										<label for='receive_free_issue_products_edit' >{$this->lang->line('Receive Free Issue Products')}</label>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Amount')} *</label>
									<div class='col-sm-4 controls'>
										<input class='form-control'  id='amount_edit' name='amount_edit'
											placeholder='{$this->lang->line('Amount')}' type='text' value='{$row->amount}' onblur='handleAmountAddition()'>
										<div id='amount_editError' class='red'></div>
									</div>
								</div>";
					$remark = preg_replace('~\\\r\\\n~',"<br>", $row->remark);
					$remark = str_ireplace("<br>", "\r\n", $remark);

					$html .="       <div class='form-group'  id='remark_group_edit'>
									<label class='control-label col-sm-3'>{$this->lang->line('Remark')}</label>
									<div class='col-sm-4 controls'>
										<textarea class='form-control' id='remark_edit' name='remark_edit'
											placeholder='{$this->lang->line('Remark')}'>{$remark}</textarea>
									</div>
								</div>
								<div class='form-actions' style='margin-bottom:0'>
									<div class='row'>
										<div class='col-sm-9 col-sm-offset-3'>";
                                            if ($row->status != "Claimed") {
                                                if(isset($this->data['ACM_Bookkeeping_Edit_Purchase_Note_Permissions'])) {
                                                    $html .= "<button class='btn btn-success save' onclick='editPurchaseNoteData({$row->purchase_note_id});' type='button'>
                                                                            <i class='icon-save'></i>
                                                                            {$this->lang->line('Edit')}
                                                                        </button> ";
                                                }
                                            }
								$html.="            <button class='btn btn-warning cancel' onclick='closePurchaseNoteEditForm({$row->purchase_note_id});' type='button'>
												<i class='icon-remove'></i>
												{$this->lang->line('Close')}
											</button>
										</div>
									</div>
								</div>
							</form>";
				}
			}

			echo json_encode(array('result' => $html));
		}
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Purchase_Note_Permissions'])) {
			
			$hideMonthFilter = false;
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			$supplierId = $this->db->escape_str($this->input->post('supplier_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
			
			if ($year != "" && $month != "") {
				$length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$fromDate = $year . '-' . $month . '-1';
				$toDate = $year . '-' . $month . '-' . $length;
			} else {
				$fromDate = "";
				$toDate = "";
				$hideMonthFilter = true;
			}
			
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered purchaseNoteDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Reference No')}</th>
                                        <th>{$this->lang->line('Category')}</th>
										<th>{$this->lang->line('Date')}</th>
										<th>{$this->lang->line('Supplier')}</th>
										<th>{$this->lang->line('Location')}</th>
										<th>{$this->lang->line('Amount')}</th>
                                        <th>{$this->lang->line('Balance Amount')}</th>
                                        <th>{$this->lang->line('Status')}</th>
										<th>{$this->lang->line('Actions')}</th>
									</tr>
								</thead>
								<tbody>";
			
			$purchaseNotes = $this->purchase_note_model->getAllForPeriod($fromDate, $toDate, $supplierId, $locationId, 'date', 'desc');

			if ($purchaseNotes != null) {
				foreach ($purchaseNotes as $row) {
					
                    $status = "Open";
                    $backgroundColorClass = "default_color";
                    if ($row->status == "Claimed") {
                        $status = "Paid";
                        $backgroundColorClass = "green_color";
                    }
                    
                    $purchaseNoteType = '';
                    if ($row->type == 'product_purchase') {
                        $purchaseNoteType = $this->lang->line("Purchase Products");
                    } else if ($row->type == 'receive_free_issues') {
                        $purchaseNoteType = $this->lang->line("Receive Free Issue Products");
                    }
                    
					$html .= "<tr>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->reference_no . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . $purchaseNoteType . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->date . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->people_name . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->location_name . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . number_format($row->amount, 2) . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . number_format($row->balance_payment, 2) . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . $status . "</td>";
					$html .= "<td>
											<div class='text-left'>";
											if(isset($this->data['ACM_Bookkeeping_Edit_Purchase_Note_Permissions'])) {
												$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->purchase_note_id}' title='{$this->lang->line('Edit')}' onclick='getPurchaseNoteData({$row->purchase_note_id});'>
																						<i class='icon-wrench'></i>
																					</a> ";
											}
                                            if ($row->status != "Claimed") {
                                                if(isset($this->data['ACM_Bookkeeping_Delete_Purchase_Note_Permissions'])) {
                                                    $html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->purchase_note_id}' title='{$this->lang->line('Delete')}' onclick='del($row->purchase_note_id);'>
                                                        <i class='icon-remove'></i>
                                                    </a>";
                                                }
                                            }
								$html.="    </div>
										</td>";
					$html .= "</tr>";
				}
			}
			$html .=    "</tbody>
							</table>
						</div>
					</div>
				</div>";
			
			echo json_encode(array('html' => $html, 'hideMonthFilter' => $hideMonthFilter));
		}
	}
    
    public function getAllPurchaseNotesToDropDown() {
        $options = $this->purchase_note_model->getAllPurchaseNotesAsOptionList();
        
        $html  = "  <select class='form-control' id='purchase_note_id' onchange='handlePurchaseNoteSelect(this.id)'>
						{$options}";
		$html .= "  </select>";

		echo $html;
    }

	//check user permission
	public function hasPermission($user_roles, $data) {
		foreach ($user_roles as $row) {
			$data[$row->permission] = $row->permission;
		}
		return $data;
	}

	public function check_existing($reference_no) {
		$exist = false;
		$result = $this->purchase_note_model->checkExistingPurchaseNote($reference_no);
		$purchaseNoteId = $this->db->escape_str($this->input->post('id'));

		if ($purchaseNoteId != '' && $result) {
			if ($purchaseNoteId !=  $result[0]->purchase_note_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Purchase Note') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	public function getLastPurchaseNoteNumber() {
		$refNo = $this->purchase_note_model->getMaxPurchaseNoteNo();
		$lastPurchaseNote = $this->purchase_note_model->getPurchaseNoteByIdConsideringDeletedPurchaseNote($refNo[0]->purchase_note_id);
		//echo "<pre>";print_r($lastPurchaseNote);die;
		if ($lastPurchaseNote && sizeof($lastPurchaseNote) > 0) {
			return $lastPurchaseNote[0]->reference_no;
		} else {
			return "Nill";
		}
	}

	public function isPurchaseNoteNumberAutoIncrementEnabled() {
		return $this->system_configurations_model->isBookkeepingPurchaseNoteNumberAutoIncrementEnabled();
	}

	public function getNextReferenceNo() {
		if ($this->isPurchaseNoteNumberAutoIncrementEnabled()) {
			$lastPurchaseNoteNo = $this->getLastPurchaseNoteNumber();
			$purchaseNoteReferenceNoCodeData = $this->system_configurations_model->getBookkeepingPurchaseNoteReferenceNoCode();
			$purchaseNoteReferenceNoCode = $purchaseNoteReferenceNoCodeData[0]->config_filed_value;
			$purchaseNoteReferenceNoSeparatorData = $this->system_configurations_model->getBookkeepingPurchaseNoteReferenceNoSeparator();
			$purchaseNoteReferenceNoSeparator = $purchaseNoteReferenceNoSeparatorData[0]->config_filed_value;
			$purchaseNoteReferenceNoStartNumberData = $this->system_configurations_model->getBookkeepingPurchaseNoteReferenceNoStartNumber();
			$purchaseNoteReferenceNoStartNumber = $purchaseNoteReferenceNoStartNumberData[0]->config_filed_value;

			if ($lastPurchaseNoteNo != 'Nill') {
				if ($purchaseNoteReferenceNoSeparator != '') {
					$lastPurchaseNoteNoElements = explode($purchaseNoteReferenceNoSeparator, $lastPurchaseNoteNo);
					$purchaseNoteNo = $lastPurchaseNoteNoElements[1];
					$result = $purchaseNoteReferenceNoCode . $purchaseNoteReferenceNoSeparator . ($purchaseNoteNo + 1);
				} else {
					$purchaseNoteReferenceNoCodeLength = strlen($purchaseNoteReferenceNoCode);
					$purchaseNoteNo = substr($lastPurchaseNoteNo, $purchaseNoteReferenceNoCodeLength);
					$result = $purchaseNoteReferenceNoCode . $purchaseNoteReferenceNoSeparator . ($purchaseNoteNo + 1);
				}
			} else {
				$result = $purchaseNoteReferenceNoCode . $purchaseNoteReferenceNoSeparator . $purchaseNoteReferenceNoStartNumber;
			}

			$status = "auto_increment";
		} else {
			$lastPurchaseNoteNo = $this->getLastPurchaseNoteNumber();
			$result = "<label class='control-label col-sm-3' id='last_reference_no_label' style='text-align:left; color: #2eb82e;'>"
					. "{$this->lang->line('Last Reference Number : ')}" . $lastPurchaseNoteNo . "</label>";
			$status = "manual_increment";
		}

		echo json_encode(array('status' => $status, 'result' => $result));
	}

	public function getPrimeEntryBooksToUpdateForPurchaseNoteTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getPurchaseNoteProductsAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForPurchaseNoteFreeIssuesTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getPurchaseNoteFreeIssuesAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
}