<?php

/**
 *  Red Cherries Accounting is a web based accounting software solution 
 *  for Small and Medium Enterprices (SME) to manage financial information. 
 *  Copyright (C) 2020  Artifectx Solutions (Pvt) Ltd
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_return_note_controller extends CI_Controller {

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
		$this->load->model('accountsManagerModule/bookkeepingSection/supplier_return_note_model', '', TRUE);
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
		$data_cls['li_class_supplier_return_note'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['supplier_return_note_no_auto_increment_status'] = $this->isSupplierReturnNoteNumberAutoIncrementEnabled();

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

		if(isset($this->data['ACM_Bookkeeping_View_Supplier_Return_Note_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/supplierReturnNote/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['ACM_Bookkeeping_Add_Supplier_Return_Note_Permissions'])) {
			$supplierReturnNoteId = '';
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$supplierReturnNoteDate = $this->db->escape_str($this->input->post('supplier_return_note_date'));
				$supplierId = $this->db->escape_str($this->input->post('supplier_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
				$supplierReturnAmount = $this->db->escape_str($this->input->post('supplier_return_amount'));
				$type = $this->db->escape_str($this->input->post('type'));
				$remark = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('remark')));
				
				$salesProfitMargin = $this->getSalesProfitMargin();
				$salesCost = $supplierReturnAmount - ($supplierReturnAmount/100) * $salesProfitMargin;

				$data = array(
					'reference_no' => $referenceNo,
					'date' => $supplierReturnNoteDate,
					'supplier_id' => $supplierId,
					'location_id' => $locationId,
					'amount' => $supplierReturnAmount,
                    'balance_payment' => $supplierReturnAmount,
					'type' => $type,
					'remark' => $remark,
					'actioned_user_id' => $this->user_id,
					'added_date' => $this->date,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$supplierReturnNoteId = $this->supplier_return_note_model->add($data);
				
				$correctChartOfAccountsFoundInPrimeEntryBooks = true;
				$primeEntryBooksToUpdate = '';
				
				if ($type == "saleable_return") {
					$supplierSaleableReturnNoteJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '1');
					
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForSupplierSaleableReturnNoteTransaction();
				} else if ($type == "market_return") {
					$supplierMarketReturnNoteSalesJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '2');
					
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForSupplierMarketReturnNoteTransaction();
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
					if ($type == "saleable_return") {
						$description = $this->lang->line('Journal entry for saleable return for Supplier Return Note number : ') . $referenceNo;
						$this->postJournalEntries($primeEntryBooksToUpdate, $supplierReturnNoteId, $supplierSaleableReturnNoteJournalEntries, '1', $supplierReturnNoteDate, $referenceNo, $locationId, $supplierId, $supplierReturnAmount, '0', $description);
					} else if ($type == "market_return") {
						$description = $this->lang->line('Journal entry for market return for Supplier Return Note number : ') . $referenceNo;
						$this->postJournalEntries($primeEntryBooksToUpdate, $supplierReturnNoteId, $supplierMarketReturnNoteSalesJournalEntries, '2', $supplierReturnNoteDate, $referenceNo, $locationId, $supplierId, $supplierReturnAmount, '0', $description);
					}
				}else {
					$result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
				}

				$result = 'ok';
			}

			echo json_encode(array('result' => $result));
		}
	}

	public function editSupplierReturnNoteData() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Supplier_Return_Note_Permissions'])) {
			$salesNoteId = '';
			if ($this->form_validation->run() == FALSE) {echo "Test";die;
				$result = validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNoChanged = false;
				$supplierChanged = false;
				$locationChanged = false;
				$supplierReturnNoteDateChanged = false;
				$typeChanged = false;
				$amountChanged = false;
				$typeChanged = false;
				$remarkChanged = false;

				//Read New Supplier Return Note Data
				$supplierReturnNoteId = $this->db->escape_str($this->input->post('id'));
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$supplierReturnNoteDate = $this->db->escape_str($this->input->post('supplier_return_note_date'));
				$supplierId = $this->db->escape_str($this->input->post('supplier_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
				$type = $this->db->escape_str($this->input->post('type'));
				$amount = $this->db->escape_str($this->input->post('supplier_return_amount'));
				$remark = $this->db->escape_str($this->input->post('remark'));
				$remark = preg_replace('~\\\n~',"\r\n", $remark);

				$supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($supplierReturnNoteId);
				$oldAmount = $supplierReturnNote[0]->amount;
				$costOldAmount = $oldAmount - ($oldAmount/100)*5;
				$oldType = $supplierReturnNote[0]->type;

				if ($supplierReturnNote[0]->reference_no != $referenceNo) {$referenceNoChanged = true;}
				if ($supplierReturnNote[0]->supplier_id != $supplierId) {$supplierChanged = true;}
				if ($supplierReturnNote[0]->location_id != $locationId) {$locationChanged = true;}
				if ($supplierReturnNote[0]->date != $supplierReturnNoteDate) {$supplierReturnNoteDateChanged = true;}
				if ($supplierReturnNote[0]->amount != $amount) {$amountChanged = true;}
				if ($supplierReturnNote[0]->type != $type) {$typeChanged = true;}
				if ($supplierReturnNote[0]->remark != $remark) {$remarkChanged = true;}

				if ($referenceNoChanged || $supplierChanged || $locationChanged || $supplierReturnNoteDateChanged || $typeChanged || $amountChanged || $remarkChanged) {

					$supplierReturnNoteDataHistory = array(
						'supplier_return_note_id' => $supplierReturnNote[0]->supplier_return_note_id,
						'reference_no' => $supplierReturnNote[0]->reference_no,
						'supplier_id' => $supplierReturnNote[0]->supplier_id,
						'location_id' => $supplierReturnNote[0]->location_id,
						'date' => $supplierReturnNote[0]->date,
						'amount' => $supplierReturnNote[0]->amount,
                        'cash_payment_amount' => $supplierReturnNote[0]->cash_payment_amount,
                        'cheque_payment_amount' => $supplierReturnNote[0]->cheque_payment_amount,
                        'credit_card_payment_amount' => $supplierReturnNote[0]->credit_card_payment_amount,
                        'balance_payment' => $supplierReturnNote[0]->balance_payment,
                        'purchase_note_claimed' => $supplierReturnNote[0]->purchase_note_claimed,
						'type' => $supplierReturnNote[0]->type,
						'remark' => $supplierReturnNote[0]->remark,
						'actioned_user_id' => $supplierReturnNote[0]->actioned_user_id,
						'added_date' => $supplierReturnNote[0]->added_date,
						'action_date' => $supplierReturnNote[0]->action_date,
						'last_action_status' => $supplierReturnNote[0]->last_action_status,
					);

					$this->supplier_return_note_model->addSupplierReturnNoteDataToHistory($supplierReturnNoteDataHistory);

                    $balancePayment = $supplierReturnNote[0]->balance_payment;
                    $supplierReturnNoteAmountChange = $amount - $supplierReturnNote[0]->amount;
                    $balancePayment = $balancePayment + $supplierReturnNoteAmountChange;
                    
					$supplierReturnNoteDatanew = array(
						'reference_no' => $referenceNo,
						'supplier_id' => $supplierId,
						'location_id' => $locationId,
						'date' => $supplierReturnNoteDate,
						'amount' => $amount,
                        'balance_payment' => $balancePayment,
						'type' => $type,
						'remark' => $remark,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNoteId, $supplierReturnNoteDatanew);
					
					if (!$typeChanged) {
						if ($type == "saleable_return") {
							$supplierSaleableReturnNoteJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '1');

							$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForSupplierSaleableReturnNoteTransaction();

							$description = $this->lang->line('Journal entry for saleable return for Supplier Return Note number : ') . $referenceNo;
							$this->postJournalEntries($primeEntryBooksToUpdate, $supplierReturnNoteId, $supplierSaleableReturnNoteJournalEntries, '1', $supplierReturnNoteDate, $referenceNo, $locationId, $supplierId, $amount, $oldAmount, $description);
						} else if ($type == "market_return") {
							$supplierMarketReturnNoteSalesJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '2');

							$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForSupplierMarketReturnNoteTransaction();

							$description = $this->lang->line('Journal entry for market return for Supplier Return Note number : ') . $referenceNo;
							$this->postJournalEntries($primeEntryBooksToUpdate, $supplierReturnNoteId, $supplierMarketReturnNoteSalesJournalEntries, '2', $supplierReturnNoteDate, $referenceNo, $locationId, $supplierId, $amount, $oldAmount, $description);
						}
					} else {
						if ($oldType == "saleable_return") {
							$supplierSaleableReturnNoteJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '1');

							$status = "deleted";
							if ($supplierSaleableReturnNoteJournalEntries && sizeof($supplierSaleableReturnNoteJournalEntries) > 0) {
								//Delete all journal entries of Supplier Return Note
								foreach($supplierSaleableReturnNoteJournalEntries as $supplierSaleableReturnNoteSalesEntryJournalEntry) {
									$supplierSaleableReturnNoteSalesEntryJournalEntryId = $supplierSaleableReturnNoteSalesEntryJournalEntry->journal_entry_id;
									$this->journal_entries_model->deleteJournalEntry($supplierSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
									$this->journal_entries_model->deleteGeneralLedgerTransactions($supplierSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
								}
							}

							$supplierMarketReturnNoteSalesJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '2');

							$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForSupplierMarketReturnNoteTransaction();

							$description = $this->lang->line('Journal entry for saleable return for Supplier Return Note number : ') . $referenceNo;
							$this->postJournalEntries($primeEntryBooksToUpdate, $supplierReturnNoteId, $supplierMarketReturnNoteSalesJournalEntries, '2', $supplierReturnNoteDate, $referenceNo, $locationId, $supplierId, $amount, $oldAmount, $description);
						} else if ($oldType == "market_return") {
							$supplierMarketReturnNoteSalesJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '2');

							$status = "deleted";
							if ($supplierMarketReturnNoteSalesJournalEntries && sizeof($supplierMarketReturnNoteSalesJournalEntries) > 0) {
								//Delete all journal entries of Supplier Return Note
								foreach($supplierMarketReturnNoteSalesJournalEntries as $supplierMarketReturnNoteSalesEntryJournalEntry) {
									$supplierMarketReturnNoteSalesEntryJournalEntryId = $supplierMarketReturnNoteSalesEntryJournalEntry->journal_entry_id;
									$this->journal_entries_model->deleteJournalEntry($supplierMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
									$this->journal_entries_model->deleteGeneralLedgerTransactions($supplierMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
								}
							}

							$supplierSaleableReturnNoteJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '1');

							$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForSupplierSaleableReturnNoteTransaction();

							$description = $this->lang->line('Journal entry for market return for Supplier Return Note number : ') . $referenceNo;
							$this->postJournalEntries($primeEntryBooksToUpdate, $supplierReturnNoteId, $supplierSaleableReturnNoteJournalEntries, '1', $supplierReturnNoteDate, $referenceNo, $locationId, $supplierId, $amount, $oldAmount, $description);
						}
					}

					$result = 'ok';
				} else {
					$result = 'no_changes_to_save';
				}
			}

			echo json_encode(array('result' => $result, 'salesNoteId' => $salesNoteId));
		}
	}

	//Delete Supplier Return Note
	public function deleteSupplierReturnNote() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Supplier_Return_Note_Permissions'])) {
			$supplierReturnNoteId = $this->db->escape_str($this->input->post('id'));
			$supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($supplierReturnNoteId);
			$type = $supplierReturnNote[0]->type;
            
            $isReferenceTransactionUsedInMakePayments = $this->make_payment_model->isReferenceTransactionUsedInMakePayments('3', $supplierReturnNoteId);
            $isReferenceTransactionUsedInReceivePayments = $this->receive_payment_model->isReferenceTransactionUsedInReceivePayments('3', $supplierReturnNoteId);
			
            if (!$isReferenceTransactionUsedInMakePayments && !$isReferenceTransactionUsedInReceivePayments) {
                
                if ($type == "saleable_return") {
                    $supplierSaleableReturnNoteJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '1');

                    $status = "deleted";
                    if ($supplierSaleableReturnNoteJournalEntries && sizeof($supplierSaleableReturnNoteJournalEntries) > 0) {
                        //Delete all journal entries of Supplier Return Note
                        foreach($supplierSaleableReturnNoteJournalEntries as $supplierSaleableReturnNoteSalesEntryJournalEntry) {
                            $supplierSaleableReturnNoteSalesEntryJournalEntryId = $supplierSaleableReturnNoteSalesEntryJournalEntry->journal_entry_id;
                            $this->journal_entries_model->deleteJournalEntry($supplierSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($supplierSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                        }
                    }
                } else if ($type == "market_return") {
                    $supplierMarketReturnNoteSalesJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '3');

                    $status = "deleted";
                    if ($supplierMarketReturnNoteSalesJournalEntries && sizeof($supplierMarketReturnNoteSalesJournalEntries) > 0) {
                        //Delete all journal entries of Supplier Return Note
                        foreach($supplierMarketReturnNoteSalesJournalEntries as $supplierMarketReturnNoteSalesEntryJournalEntry) {
                            $supplierMarketReturnNoteSalesEntryJournalEntryId = $supplierMarketReturnNoteSalesEntryJournalEntry->journal_entry_id;
                            $this->journal_entries_model->deleteJournalEntry($supplierMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($supplierMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                        }
                    }
                }

                if ($this->supplier_return_note_model->deleteSupplierReturnNote($supplierReturnNoteId, $status,$this->user_id)) {
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
                            $this->lang->line('Supplier Return Note already used in make payment and receive payment transactions and cannot be deleted!') .
                        '</div>';
            }
            
			echo $html;
		}
	}

	public function getSupplierReturnNoteData() {
		if(isset($this->data['ACM_Bookkeeping_View_Supplier_Return_Note_Permissions'])) {
			$supplierReturnNoteId = $this->db->escape_str($this->input->post('id'));
			$supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($supplierReturnNoteId);
			$html = "";
			if ($supplierReturnNote != null) {
				foreach ($supplierReturnNote as $row) {
					$html .="   <form class='form form-horizontal validate-form save_form'>
								<div class='form-group'>
									<input class='form-control'   id='supplier_return_note_id' name='supplier_return_note_id' type='hidden' value='{$row->supplier_return_note_id}'>
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
											<input class='form-control' id='supplier_return_note_date_edit' name='supplier_return_note_date_edit'
												data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$row->date}'>
											<span class='input-group-addon'>
												<span class='glyphicon glyphicon-calendar'/>
											</span>
										</div>
										<div id='supplier_return_note_date_editError' class='red'></div>
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
										<input type='checkbox' name='saleable_return_edit' id='saleable_return_edit' style='vertical-align: text-bottom;' onchange='handleSaleableReturnSelect(this.id);'";
								if ($row->type == "saleable_return") {
							$html .=" checked";		
								}
				$html .="			>
										<label for='saleable_return_edit' >{$this->lang->line('Saleable Return')}</label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-3 controls'></div>
									<div class='col-sm-5 controls'>
										<input type='checkbox' name='market_return_edit' id='market_return_edit' style='vertical-align: text-bottom;' onchange='handleMarketReturnSelect(this.id);'";
								if ($row->type == "market_return") {
							$html .=" checked";		
								}
				$html .="			>
										<label for='market_return_edit' >{$this->lang->line('Market Return')}</label>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Supplier Return Amount')} *</label>
									<div class='col-sm-4 controls'>
										<input class='form-control'  id='supplier_return_amount_edit' name='supplier_return_amount_edit'
											placeholder='{$this->lang->line('Supplier Return Amount')}' type='text' value='{$row->amount}' onblur='handleSupplierReturnAmountAddition()'>
										<div id='supplier_return_amount_editError' class='red'></div>
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
                                                if(isset($this->data['ACM_Bookkeeping_Edit_Supplier_Return_Note_Permissions'])) {
                                                    $html .= "<button class='btn btn-success save' onclick='editSupplierReturnNoteData({$row->supplier_return_note_id});' type='button'>
                                                                            <i class='icon-save'></i>
                                                                            {$this->lang->line('Edit')}
                                                                        </button> ";
                                                }
                                            }
								$html.="            <button class='btn btn-warning cancel' onclick='closeSupplierReturnNoteEditForm({$row->supplier_return_note_id});' type='button'>
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
		if(isset($this->data['ACM_Bookkeeping_View_Supplier_Return_Note_Permissions'])) {
			
			$hideMonthFilter = false;
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			$supplierId = $this->db->escape_str($this->input->post('supplier_id'));
			$territoryId = $this->db->escape_str($this->input->post('territory_id'));
			
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
							<table class='table table-striped table-bordered supplierReturnNoteDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Reference No')}</th>
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
			
			$salesNotes = $this->supplier_return_note_model->getAllForPeriod($fromDate, $toDate, $supplierId, $territoryId, 'date', 'desc');

			if ($salesNotes != null) {
				foreach ($salesNotes as $row) {
					
					$supplierName = "";
					$supplierId = $row->supplier_id;
					$supplier = $this->peoples_model->getById($supplierId);
					if ($supplier && sizeof($supplier) > 0) {
						$supplierName = $supplier[0]->people_name;
					}
                    
                    $locationName = "";
					$locationId = $row->location_id;
					$location = $this->locations_model->getById($locationId);
					if ($location && sizeof($location) > 0) {
						$locationName = $location[0]->location_name;
					}
                    
                    $status = "Open";
                    $backgroundColorClass = "default_color";
                    if ($row->status == "Claimed") {
                        $status = "Payment Received";
                        $backgroundColorClass = "green_color";
                    }
					
					$html .= "<tr>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->reference_no . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->date . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $supplierName . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . $locationName . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . number_format($row->amount, 2) . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . number_format($row->balance_payment, 2) . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . $status . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>
											<div class='text-left'>";
											if(isset($this->data['ACM_Bookkeeping_Edit_Supplier_Return_Note_Permissions'])) {
												$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->supplier_return_note_id}' title='{$this->lang->line('Edit')}' onclick='getSupplierReturnNoteData({$row->supplier_return_note_id});'>
																						<i class='icon-wrench'></i>
																					</a> ";
											}
                                            if ($row->status != "Claimed") {
                                                if(isset($this->data['ACM_Bookkeeping_Delete_Supplier_Return_Note_Permissions'])) {
                                                    $html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->supplier_return_note_id}' title='{$this->lang->line('Delete')}' onclick='del($row->supplier_return_note_id);'>
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
    
    public function getAllSupplierReturnNotesToDropDown() {
        $options = $this->supplier_return_note_model->getAllSupplierReturnNotesAsOptionList();
        
        $html  = "  <select class='form-control' id='supplier_return_note_id' onchange='handleSupplierReturnNoteSelect(this.id)'>
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
		$result = $this->supplier_return_note_model->checkExistingSupplierReturnNote($reference_no);
		$salesNoteId = $this->db->escape_str($this->input->post('id'));

		if ($salesNoteId != '' && $result) {
			if ($salesNoteId !=  $result[0]->supplier_return_note_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Supplier Return Note') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	public function getLastSupplierReturnNoteNumber() {
		$refNo = $this->supplier_return_note_model->getMaxSupplierReturnNoteNo();
		$lastSupplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteByIdConsideringDeletedSupplierReturnNote($refNo[0]->supplier_return_note_id);
		//echo "<pre>";print_r($lastSupplierReturnNote);die;
		if ($lastSupplierReturnNote && sizeof($lastSupplierReturnNote) > 0) {
			return $lastSupplierReturnNote[0]->reference_no;
		} else {
			return "Nill";
		}
	}

	public function isSupplierReturnNoteNumberAutoIncrementEnabled() {
		return $this->system_configurations_model->isBookkeepingSupplierReturnNoteNumberAutoIncrementEnabled();
	}

	public function getNextReferenceNo() {
		if ($this->isSupplierReturnNoteNumberAutoIncrementEnabled()) {
			$lastSupplierReturnNoteNo = $this->getLastSupplierReturnNoteNumber();
			$supplierReturnNoteReferenceNoCodeData = $this->system_configurations_model->getBookkeepingSupplierReturnNoteReferenceNoCode();
			$supplierReturnNoteReferenceNoCode = $supplierReturnNoteReferenceNoCodeData[0]->config_filed_value;
			$supplierReturnNoteReferenceNoSeparatorData = $this->system_configurations_model->getBookkeepingSupplierReturnNoteReferenceNoSeparator();
			$supplierReturnNoteReferenceNoSeparator = $supplierReturnNoteReferenceNoSeparatorData[0]->config_filed_value;
			$supplierReturnNoteReferenceNoStartNumberData = $this->system_configurations_model->getBookkeepingSupplierReturnNoteReferenceNoStartNumber();
			$supplierReturnNoteReferenceNoStartNumber = $supplierReturnNoteReferenceNoStartNumberData[0]->config_filed_value;

			if ($lastSupplierReturnNoteNo != 'Nill') {
				if ($supplierReturnNoteReferenceNoSeparator != '') {
					$lastSupplierReturnNoteNoElements = explode($supplierReturnNoteReferenceNoSeparator, $lastSupplierReturnNoteNo);
					$supplierReturnNoteNo = $lastSupplierReturnNoteNoElements[1];
					$result = $supplierReturnNoteReferenceNoCode . $supplierReturnNoteReferenceNoSeparator . ($supplierReturnNoteNo + 1);
				} else {
					$supplierReturnNoteReferenceNoCodeLength = strlen($supplierReturnNoteReferenceNoCode);
					$supplierReturnNoteNo = substr($lastSupplierReturnNoteNo, $supplierReturnNoteReferenceNoCodeLength);
					$result = $supplierReturnNoteReferenceNoCode . $supplierReturnNoteReferenceNoSeparator . ($supplierReturnNoteNo + 1);
				}
			} else {
				$result = $supplierReturnNoteReferenceNoCode . $supplierReturnNoteReferenceNoSeparator . $supplierReturnNoteReferenceNoStartNumber;
			}

			$status = "auto_increment";
		} else {
			$lastSupplierReturnNoteNo = $this->getLastSupplierReturnNoteNumber();
			$result = "<label class='control-label col-sm-3' id='last_reference_no_label' style='text-align:left; color: #2eb82e;'>"
					. "{$this->lang->line('Last Reference Number : ')}" . $lastSupplierReturnNoteNo . "</label>";
			$status = "manual_increment";
		}

		echo json_encode(array('status' => $status, 'result' => $result));
	}

	public function getPrimeEntryBooksToUpdateForSupplierSaleableReturnNoteTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getSupplierSaleableReturnNoteAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForSupplierMarketReturnNoteTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getSupplierMarketReturnNoteAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function postJournalEntries($primeEntryBooksToUpdate, $supplierReturnNoteId, $journalEntries, $transactionTypeId, $date, $referenceNo, $locationId, $payeePayerId, $amount, $oldAmount, $description) {
		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
			if (!$journalEntries) {
				//Add journal entry records

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
						$primeEntryBookId = $primeEntryBook->config_filed_value;
						$data = array(
							'prime_entry_book_id' => $primeEntryBookId,
							'transaction_date' => $date,
							'reference_no' => $referenceNo,
							'should_have_a_payment_journal_entry' => "Yes",
							'location_id' => $locationId,
							'payee_payer_type' => "Supplier",
							'payee_payer_id' => $payeePayerId,
							'description' => $description,
							'post_type' => "Indirect",
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$journalEntryId = $this->journal_entries_model->addJournalEntry($data);

						$data = array(
							'supplier_return_note_id' => $supplierReturnNoteId,
							'prime_entry_book_id' => $primeEntryBookId,
							'journal_entry_id' => $journalEntryId,
							'transaction_type_id' => $transactionTypeId,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->supplier_return_note_model->addSupplierReturnNoteJournalEntry($data);

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
			} else if ($journalEntries && sizeof($journalEntries) > 0) {
				//Get general ledger transactions to update new amount
				foreach($journalEntries as $journalEntry) {
					$salesNotePrimeEntryBookId = $journalEntry->prime_entry_book_id;
					$journalEntryId = $journalEntry->journal_entry_id;
					
					$data = array(
						'transaction_date' => $date,
						'location_id' => $locationId,
						'payee_payer_id' => $payeePayerId,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->journal_entries_model->editJournalEntry($journalEntryId, $data);

					$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($salesNotePrimeEntryBookId);
					$salesNoteGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($journalEntryId, $salesNotePrimeEntryBookId);
					$amount = str_replace(',', '', $amount);

					foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
						foreach($salesNoteGeneralLedgerTransactions as $salesNoteGeneralLedgerTransaction) {
							if ($salesNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
								$data = array(
									'debit_value' => ($salesNoteGeneralLedgerTransaction->debit_value - $oldAmount) + $amount,
									'actioned_user_id' => $this->user_id,
									'action_date' => $this->date,
									'last_action_status' => 'edited'
								);

								$this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $salesNoteGeneralLedgerTransaction->chart_of_account_id, $data);

								//Same time edit the data in previous years record table.
								$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $salesNoteGeneralLedgerTransaction->chart_of_account_id, $data);
							} else if ($salesNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
								$data = array(
									'credit_value' => ($salesNoteGeneralLedgerTransaction->credit_value - $oldAmount) + $amount,
									'actioned_user_id' => $this->user_id,
									'action_date' => $this->date,
									'last_action_status' => 'edited'
								);

								$this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $salesNoteGeneralLedgerTransaction->chart_of_account_id, $data);

								//Same time edit the data in previous years record table.
								$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $salesNoteGeneralLedgerTransaction->chart_of_account_id, $data);
							}
						}
					}
				}
			}
		}
	}
	
	public function getSalesProfitMargin() {
		return $this->system_configurations_model->getSalesProfitMargin();
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