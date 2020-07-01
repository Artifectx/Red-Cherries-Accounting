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

class Sales_note_controller extends CI_Controller {

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
		$this->load->model('organizationManagerModule/adminSection/territories_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
        $this->load->model('accountsManagerModule/adminSection/bank_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/sales_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/customer_return_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/receive_payment_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/payments_model', '', TRUE);
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
		$data_cls['li_class_sales_note'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['sales_note_no_auto_increment_status'] = $this->isSalesNoteNumberAutoIncrementEnabled();

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

		if(isset($this->data['ACM_Bookkeeping_View_Sales_Note_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/salesNote/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['ACM_Bookkeeping_Add_Sales_Note_Permissions'])) {
			$salesNoteId = '';
			$salesJournalEntryId = '';
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$salesNoteDate = $this->db->escape_str($this->input->post('sales_note_date'));
				$customerId = $this->db->escape_str($this->input->post('customer_id'));
				$territoryId = $this->db->escape_str($this->input->post('territory_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
				$salesAmount = $this->db->escape_str($this->input->post('sales_amount'));
				$discount = $this->db->escape_str($this->input->post('discount'));
				$freeIssueAmount = $this->db->escape_str($this->input->post('free_issue_amount'));
				$amountPayable = $this->db->escape_str($this->input->post('amount_payable'));
				$remark = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('remark')));
				
				$salesProfitMargin = $this->getSalesProfitMargin();
				$salesCost = $salesAmount - ($salesAmount/100) * $salesProfitMargin;

				$data = array(
					'reference_no' => $referenceNo,
					'date' => $salesNoteDate,
					'customer_id' => $customerId,
					'territory_id' => $territoryId,
					'location_id' => $locationId,
					'sales_amount' => $salesAmount,
					'discount' => $discount,
					'free_issue_amount' => $freeIssueAmount,
					'amount_payable' => $amountPayable,
                    'balance_payment' => $amountPayable,
					'remark' => $remark,
					'actioned_user_id' => $this->user_id,
					'added_date' => $this->date,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$salesNoteId = $this->sales_note_model->add($data);
				
				$salesNoteSalesEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '1');
				$salesNoteCostEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '2');
				$salesNoteDiscountJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '3');
				$salesNoteFreeIssuesJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '4');
				
				$correctChartOfAccountsFoundInPrimeEntryBooks = true;

				$primeEntryBooksToUpdateForSaleSalesEntry = $this->getPrimeEntryBooksToUpdateForSalesNoteSalesEntryTransaction();
				$primeEntryBooksToUpdateForSaleCostEntry = $this->getPrimeEntryBooksToUpdateForSalesNoteCostEntryTransaction();
				$primeEntryBooksToUpdateForDiscount = $this->getPrimeEntryBooksToUpdateForSalesNoteDiscountTransaction();
				$primeEntryBooksToUpdateForForFreeIssueAmount = $this->getPrimeEntryBooksToUpdateForSalesNoteFreeIssuesTransaction();
				
				$primeEntryBooksToUpdate = '';
				
				if ($primeEntryBooksToUpdateForSaleSalesEntry && $primeEntryBooksToUpdateForSaleCostEntry) {
					$primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForSaleSalesEntry, $primeEntryBooksToUpdateForSaleCostEntry);
				}
				
				if ($primeEntryBooksToUpdate && $primeEntryBooksToUpdateForDiscount) {
					$primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdate, $primeEntryBooksToUpdateForDiscount);
				}
				
				if ($primeEntryBooksToUpdate && $primeEntryBooksToUpdateForForFreeIssueAmount) {
					$primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdate, $primeEntryBooksToUpdateForForFreeIssueAmount);
				}

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                        }
                    }
				}
				
				if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
					$salesJournalEntryId = $this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForSaleSalesEntry, $salesNoteId, $salesNoteSalesEntryJournalEntries, '1', $salesNoteDate, $referenceNo, $locationId, $customerId, $salesAmount, '0', "Yes", 'Sales Note');
					$this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForSaleCostEntry, $salesNoteId, $salesNoteCostEntryJournalEntries, '2', 
                            $salesNoteDate, $referenceNo, $locationId, $customerId, $salesCost, '0', "No");
					
					if ($discount > 0) {
					$this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForDiscount, $salesNoteId, $salesNoteDiscountJournalEntries, '3', 
                            $salesNoteDate, $referenceNo, $locationId, $customerId, $discount, '0', "No", '','', '', '', $salesJournalEntryId);
					}
					
					if ($freeIssueAmount > 0) {
						$this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForForFreeIssueAmount, $salesNoteId, $salesNoteFreeIssuesJournalEntries, '4', 
                                $salesNoteDate, $referenceNo, $locationId, $customerId, $freeIssueAmount, '0', "No");
					}
				}else {
					$result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
				}

				$result = 'ok';
			}

			echo json_encode(array('result' => $result, 'salesNoteId' => $salesNoteId, 'salesJournalEntryId' => $salesJournalEntryId));
		}
	}
	
	public function addSalesNotePaymentData() {
        
        $result = '';
        
		if(isset($this->data['ACM_Bookkeeping_Add_Sales_Note_Permissions'])) {
			$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
			$salesNoteDate = $this->db->escape_str($this->input->post('sales_note_date'));
			$customerId = $this->db->escape_str($this->input->post('customer_id'));
			$territoryId = $this->db->escape_str($this->input->post('territory_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
			$customerSaleableReturnAmount = $this->db->escape_str($this->input->post('customer_saleable_return_amount'));
			$customerMarketReturnAmount = $this->db->escape_str($this->input->post('customer_market_return_amount'));
            
            $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
            $salesNoteReferenceNo = $salesNote[0]->reference_no;
			
			$customerType = '';
			$customer = $this->peoples_model->getById($customerId);
			if ($customer && sizeof($customer) > 0) {
				$customerType = $customer[0]->people_type;
			}
			
			$salesProfitMargin = $this->getSalesProfitMargin();
            
            $primeEntryBookData = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();
        
            $primeEntryBookId = '';
            if ($primeEntryBookData && sizeof($primeEntryBookData) > 0) {
                $primeEntryBookId = $primeEntryBookData[0]->config_filed_value;
            }
            
            $referenceJournalEntry = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByPrimeEntryBookId($salesNoteReferenceNo, $primeEntryBookId);
        
            $salesNoteReferenceJournalEntryId = '';
            if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
                $salesNoteReferenceJournalEntryId = $referenceJournalEntry[0]->journal_entry_id;
            }
			
			//Add customer return data
			$customerSaleableReturnId = '0';
			if ($customerSaleableReturnAmount != '') {
				
				$referenceNo = $this->getNextCustomerReturnReferenceNo();
				
				$data = array(
					'reference_no' => $referenceNo,
					'date' => $salesNoteDate,
					'customer_id' => $customerId,
					'territory_id' => $territoryId,
					'location_id' => $locationId,
					'amount' => $customerSaleableReturnAmount,
					'type' => "saleable_return",
					'remark' => '',
                    'status' => 'Claimed',
					'actioned_user_id' => $this->user_id,
					'added_date' => $this->date,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$customerReturnNoteId = $this->customer_return_note_model->add($data);
				$customerSaleableReturnId = $customerReturnNoteId;
				
				$correctChartOfAccountsFoundInPrimeEntryBooks = true;
				$primeEntryBooksToUpdate = '';
				
				$customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
				$customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

				$primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction();
				$primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction();
                $primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                
				if ($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry && $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry) {
					$primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry);
				}
                
                if ($primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim && sizeof($primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim) > 0) {
                    $primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdate, $primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim);
                }
				
				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                        }
                    }
				}
				
				if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
					$description = $this->lang->line('Journal entry for saleable return sales entry for Customer Return Note number : ') . $referenceNo;
					$referenceJournalEntryId = $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $customerReturnNoteId, 
                            $customerSaleableReturnNoteSalesEntryJournalEntries, '1', $salesNoteDate, $referenceNo, $locationId, $customerId, 
                            $customerSaleableReturnAmount, '0', $description);
					$description = $this->lang->line('Journal entry for saleable return cost entry for Customer Return Note number : ') . $referenceNo;
					$salesCost = $customerSaleableReturnAmount - ($customerSaleableReturnAmount/100) * $salesProfitMargin;
					$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry, $customerReturnNoteId, 
                            $customerSaleableReturnNoteCostEntryJournalEntries, '2', $salesNoteDate, $referenceNo, $locationId, $customerId, 
                            $salesCost, '0', $description);
                    
                    //Post journal entry for customer return note claim for sales note
                    if ($salesNoteReferenceJournalEntryId != '') {
                        $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim, '', $salesNoteDate, 
                                $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $referenceNo, $locationId, $customerId, 
                                $customerSaleableReturnAmount);
                        
                        if ($claimReferenceJournalEntryId != '') {
                            $data = array(
                                'journal_entry_id' => $referenceJournalEntryId,
                                'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );
                            
                            $this->journal_entries_model->addJournalEntryClaimReference($data);
                        }
                    }
				} else {
					$result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
				}
			}
			
			$customerMarketReturnId = '0';
			if ($customerMarketReturnAmount != '') {
				
				$referenceNo = $this->getNextCustomerReturnReferenceNo();
				
				$data = array(
					'reference_no' => $referenceNo,
					'date' => $salesNoteDate,
					'customer_id' => $customerId,
					'territory_id' => $territoryId,
					'location_id' => $locationId,
					'amount' => $customerMarketReturnAmount,
					'type' => "market_return",
					'remark' => '',
                    'status' => 'Claimed',
					'actioned_user_id' => $this->user_id,
					'added_date' => $this->date,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$customerReturnNoteId = $this->customer_return_note_model->add($data);
				$customerMarketReturnId = $customerReturnNoteId;
				
				$correctChartOfAccountsFoundInPrimeEntryBooks = true;
				$primeEntryBooksToUpdate = '';
				
				$customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
				$customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '4');

				$primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction();
				$primeEntryBooksToUpdateForCustomerMarketReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction();
                $primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                
				if ($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry && $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry) {
					$primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry);
				}
                
                if ($primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim && sizeof($primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim) > 0) {
                    $primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdate, $primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim);
                }
				
				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 3) {
                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                        }
                    }
				}
				
				if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
					$description = $this->lang->line('Journal entry for market return sales entry for Customer Return Note number : ') . $referenceNo;
					$referenceJournalEntryId = $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $customerReturnNoteId, 
                            $customerMarketReturnNoteSalesEntryJournalEntries, '3', $salesNoteDate, $referenceNo, $locationId, $customerId, 
                            $customerMarketReturnAmount, '0', $description);
					$description = $this->lang->line('Journal entry for market return cost entry for Customer Return Note number : ') . $referenceNo;
					
					$profitPortion = "";
					$salesCost = "";
					$CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId = $this->system_configurations_model->getCustomerMarketReturnCostEntryProfitMarginCreditChartOfAccount();
					if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
						$profitPortion = ($customerMarketReturnAmount/100) * $salesProfitMargin;
						$salesCost = $customerMarketReturnAmount;
					} else {
						$salesCost = $customerMarketReturnAmount - ($customerMarketReturnAmount/100) * $salesProfitMargin;
					}
					
					$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnCostEntry, $customerReturnNoteId, 
                            $customerMarketReturnNoteCostEntryJournalEntries, '4', $salesNoteDate, $referenceNo, $locationId, $customerId, 
                            $salesCost, '0', $description, $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId, 
                            $profitPortion, '0');
                    
                    //Post journal entry for customer return note claim for sales note
                    if ($salesNoteReferenceJournalEntryId != '') {
                        $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim, '', $salesNoteDate, 
                                $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $referenceNo, $locationId, $customerId, 
                                $customerMarketReturnAmount);
                        
                        if ($claimReferenceJournalEntryId != '') {
                            $data = array(
                                'journal_entry_id' => $referenceJournalEntryId,
                                'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );
                            
                            $this->journal_entries_model->addJournalEntryClaimReference($data);
                        }
                    }
				} else {
					$result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
				}
			}
            
            $totalAmount = $salesNote[0]->sales_amount;
            $discount = $salesNote[0]->discount;
            $paidCashAmount = $salesNote[0]->cash_payment_amount;
            $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
            $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
            $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
            $totalPayable = $totalAmount - $discount;
            $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;

            $customerReturnAmountClaimed = $customerReturnAmountClaimed + ($customerSaleableReturnAmount + $customerMarketReturnAmount);
            $newBalancePayment = $totalPayable - ($totalPaid + $customerSaleableReturnAmount + $customerMarketReturnAmount);
            
            if ($newBalancePayment < 0) {
                $newBalancePayment = 0;
            }

            $status = "Open";
            if ($newBalancePayment == 0) {
                $status = "Claimed";
            }
			
			$salesNoteDatanew = array(
                'balance_payment' => $newBalancePayment,
                'customer_return_note_claimed' => $customerReturnAmountClaimed,
				'customer_saleable_return_id' => $customerSaleableReturnId,
				'customer_market_return_id' => $customerMarketReturnId,
                'status' => $status
			);

			$this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);
			
			if ($result == '') {
				$result = 'ok';
			}
		}
		
		echo $result;
	}

	public function editSalesNoteData() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Sales_Note_Permissions'])) {
			$salesNoteId = '';
			if ($this->form_validation->run() == FALSE) {echo "Test";die;
				$result = validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNoChanged = false;
				$customerChanged = false;
				$territoryChanged = false;
				$locationChanged = false;
				$salesNoteDateChanged = false;
				$typeChanged = false;
				$salesAmountChanged = false;
				$discountChanged = false;
				$freeIssueAmountChanged = false;
				$remarkChanged = false;

				//Read New Sales Note Data
				$salesNoteId = $this->db->escape_str($this->input->post('id'));
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$salesNoteDate = $this->db->escape_str($this->input->post('sales_note_date'));
				$customerId = $this->db->escape_str($this->input->post('customer_id'));
				$territoryId = $this->db->escape_str($this->input->post('territory_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
				$salesAmount = $this->db->escape_str($this->input->post('sales_amount'));
				$discount = $this->db->escape_str($this->input->post('discount'));
				$freeIssueAmount = $this->db->escape_str($this->input->post('free_issue_amount'));
				$remark = $this->db->escape_str($this->input->post('remark'));
				$remark = preg_replace('~\\\n~',"\r\n", $remark);

				$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
                
                $salesNoteReferenceNo = $salesNote[0]->reference_no;
				$salesOldAmount = $salesNote[0]->sales_amount;
				$salesCostOldAmount = $salesOldAmount - ($salesOldAmount/100)*5;
				$discountOldAmount = $salesNote[0]->discount;
				$freeIssueOldAmount = $salesNote[0]->free_issue_amount;
                $customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
                $customerMarketReturnId = $salesNote[0]->customer_market_return_id;
                
                $primeEntryBookData = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();
        
                $primeEntryBookId = '';
                if ($primeEntryBookData && sizeof($primeEntryBookData) > 0) {
                    $primeEntryBookId = $primeEntryBookData[0]->config_filed_value;
                }

                $referenceJournalEntry = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByPrimeEntryBookId($salesNoteReferenceNo, $primeEntryBookId);

                $salesNoteReferenceJournalEntryId = '';
                if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
                    $salesNoteReferenceJournalEntryId = $referenceJournalEntry[0]->journal_entry_id;
                }

				if ($salesNote[0]->reference_no != $referenceNo) {$referenceNoChanged = true;}
				if ($salesNote[0]->customer_id != $customerId) {$customerChanged = true;}
				if ($salesNote[0]->territory_id != $territoryId) {$territoryChanged = true;}
				if ($salesNote[0]->location_id != $locationId) {$locationChanged = true;}
				if ($salesNote[0]->date != $salesNoteDate) {$salesNoteDateChanged = true;}
				if ($salesNote[0]->sales_amount != $salesAmount) {$salesAmountChanged = true;}
				if ($salesNote[0]->discount != $discount) {$discountChanged = true;}
				if ($salesNote[0]->free_issue_amount != $freeIssueAmount) {$freeIssueAmountChanged = true;}
				if ($salesNote[0]->remark != $remark) {$remarkChanged = true;}

				if ($referenceNoChanged || $customerChanged || $locationChanged || $salesNoteDateChanged || $typeChanged || $salesAmountChanged || 
				    $discountChanged || $freeIssueAmountChanged || $remarkChanged) {

                    $salesNoteReceiveChequePaymentIds = array();
                    $salesNotesReceivePayments = array();
                    
                    //Update receive payment data
                    $salesNoteReceivePayments = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
                        
                    if ($salesNoteReceivePayments && sizeof($salesNoteReceivePayments) > 0) {
                        foreach($salesNoteReceivePayments as $salesNoteReceivePayment) {
                            
                            $receivePaymentId = '';
                            
                            if ($salesNoteReceivePayment->receive_cash_payment_method_id != '0') {
                                $receivePaymentId = $salesNoteReceivePayment->receive_cash_payment_method_id;
                                $salesNotesReceivePayments[] = $receivePaymentId;
                            
                                $receivePaymentDatanew = array(
                                    'payer_id' => $customerId,
                                    'location_id' => $locationId,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->receive_payment_model->editReceivePaymentData($receivePaymentId, $receivePaymentDatanew);
                            }
                            
                            if ($salesNoteReceivePayment->receive_cheque_payment_method_id != '0') {
                                $salesNoteReceiveChequePaymentIds[] = $salesNoteReceivePayment->receive_cheque_payment_method_id;
                                
                                $receivePaymentId = $salesNoteReceivePayment->receive_cheque_payment_method_id;
                                $salesNotesReceivePayments[] = $receivePaymentId;
                            
                                $receivePaymentDatanew = array(
                                    'payer_id' => $customerId,
                                    'location_id' => $locationId,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->receive_payment_model->editReceivePaymentData($receivePaymentId, $receivePaymentDatanew);
                            }
                            
                            $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

                            if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                                //Get general ledger transactions to update new location
                                foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {

                                    $receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

                                    if ($customerChanged || $locationChanged) {

                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($receivePaymentJournalEntryId);

                                        $journalEntryHistoryData = array(
                                            'journal_entry_id' => $journalEntry[0]->journal_entry_id,
                                            'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
                                            'location_id' => $journalEntry[0]->location_id,
                                            'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                                            'delivery_route_id' => $journalEntry[0]->delivery_route_id,
                                            'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                                            'due_date' => $journalEntry[0]->due_date,
                                            'transaction_date' => $journalEntry[0]->transaction_date,
                                            'reference_no' => $journalEntry[0]->reference_no,
                                            'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                                            'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                                            'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                                            'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
                                            'description' => $journalEntry[0]->description,
                                            'post_type' => $journalEntry[0]->post_type,
                                            'actioned_user_id' => $journalEntry[0]->actioned_user_id,
                                            'action_date' => $journalEntry[0]->action_date,
                                            'last_action_status' => $journalEntry[0]->last_action_status
                                        );

                                        $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);

                                        $data = array(
                                            'location_id' => $locationId,
                                            'payee_payer_id' => $customerId,
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->journal_entries_model->editJournalEntry($receivePaymentJournalEntryId, $data);
                                    }
                                }
                            }
                        }
                    }
                    
                    $receivePaymentReferenceTransactionsForSalesNote = $this->receive_payment_model->getReferenceTransactionsOfSalesNote($salesNoteId);
                    
                    if ($receivePaymentReferenceTransactionsForSalesNote && sizeof($receivePaymentReferenceTransactionsForSalesNote) > 0) {
                        foreach ($receivePaymentReferenceTransactionsForSalesNote as $receivePaymentReferenceTransaction) {
                            if (!in_array($receivePaymentReferenceTransaction, $salesNotesReceivePayments)) {
                                $receivePaymentDatanew = array(
                                    'payer_id' => $customerId,
                                    'location_id' => $locationId,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->receive_payment_model->editReceivePaymentData($receivePaymentReferenceTransaction, $receivePaymentDatanew);
                                
                                $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentReferenceTransaction);

                                if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                                    //Get general ledger transactions to update new location
                                    foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {

                                        $receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

                                        if ($customerChanged || $locationChanged) {

                                            $journalEntry = $this->journal_entries_model->getJournalEntryById($receivePaymentJournalEntryId);

                                            $journalEntryHistoryData = array(
                                                'journal_entry_id' => $journalEntry[0]->journal_entry_id,
                                                'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
                                                'location_id' => $journalEntry[0]->location_id,
                                                'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                                                'delivery_route_id' => $journalEntry[0]->delivery_route_id,
                                                'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                                                'due_date' => $journalEntry[0]->due_date,
                                                'transaction_date' => $journalEntry[0]->transaction_date,
                                                'reference_no' => $journalEntry[0]->reference_no,
                                                'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                                                'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                                                'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                                                'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
                                                'description' => $journalEntry[0]->description,
                                                'post_type' => $journalEntry[0]->post_type,
                                                'actioned_user_id' => $journalEntry[0]->actioned_user_id,
                                                'action_date' => $journalEntry[0]->action_date,
                                                'last_action_status' => $journalEntry[0]->last_action_status
                                            );

                                            $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);

                                            $data = array(
                                                'location_id' => $locationId,
                                                'payee_payer_id' => $customerId,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->journal_entries_model->editJournalEntry($receivePaymentJournalEntryId, $data);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    //Update customer return note data
                    $customerReturnNoteAmountToAdd = 0;
                    
                    $receivePaymentReferenceTransactionsOfSalesNotes = $this->receive_payment_model->getReceivePaymentReferenceTransactionsOfSalesNote($salesNoteId);
                    
                    if ($receivePaymentReferenceTransactionsOfSalesNotes && sizeof($receivePaymentReferenceTransactionsOfSalesNotes) > 0) {
                        foreach($receivePaymentReferenceTransactionsOfSalesNotes as $receivePaymentReferenceTransaction) {
                            $receivePaymentId = $receivePaymentReferenceTransaction->receive_payment_id;
                            $receivePaymentCustomerReturnNotes = $this->receive_payment_model->getReceivePaymentCustomerReturnNoteReferenceTransactions($receivePaymentId);
                            
                            if ($receivePaymentCustomerReturnNotes && sizeof($receivePaymentCustomerReturnNotes) > 0) {
                                foreach($receivePaymentCustomerReturnNotes as $customerReturnNoteId) {
                                    
                                    $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);
                                    
                                    $amount = $customerReturnNote[0]->amount;
                                    $customerReturnNoteType = $customerReturnNote[0]->type;
                                    $customerReturnNoteAmountToAdd = $customerReturnNoteAmountToAdd + $customerReturnNote[0]->amount;
                                    
                                    $customerReturnNoteDatanew = array(
                                        'balance_payment' => $amount,
                                        'status' => "Open",
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNoteId, $customerReturnNoteDatanew);
                                    
                                    $receivePaymentReferenceTransaction = $this->receive_payment_model->getReceivePaymentReferenceTransactionOfCustomerReturnNoteForReceivePayment($customerReturnNoteId, $receivePaymentId);
                                    
                                    if ($receivePaymentReferenceTransaction && sizeof($receivePaymentReferenceTransaction) > 0) {
                                        $receivePaymentReferenceTransactionId = $receivePaymentReferenceTransaction[0]->receive_payment_reference_transaction_id;
                                        $this->receive_payment_model->deleteReceivePaymentReferenceTransactionSoftly($receivePaymentReferenceTransactionId, "deleted", $this->user_id);
                                    }
                                    
                                    $customerReturnNoteJournalEntries = '';
                                    
                                    if ($customerReturnNoteType == "saleable_return") {
                                        $customerReturnNoteJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                                    } else if ($customerReturnNoteType == "market_return") {
                                        $customerReturnNoteJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
                                    }
                                        
                                    if ($customerReturnNoteJournalEntries && sizeof($customerReturnNoteJournalEntries) > 0) {
                                        foreach($customerReturnNoteJournalEntries as $customerReturnNoteJournalEntry) {
                                            $journalEntryId = $customerReturnNoteJournalEntry->journal_entry_id;

                                            $claimReferenceJournalEntries = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                                            if ($claimReferenceJournalEntries && sizeof($claimReferenceJournalEntries) > 0) {
                                                foreach($claimReferenceJournalEntries as $claimReferenceJournalEntry) {
                                                    $claimReferenceJournalEntryId = $claimReferenceJournalEntry->claim_reference_journal_entry_id;
                                                    $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, "deleted", $this->user_id);
                                                    $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, "deleted", $this->user_id);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    //Update customer saleable return note added from sales note
                    if ($customerSaleableReturnId != '0') {
                        $customerSaleableReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
                        $customerReturnNoteDate = $customerSaleableReturnNote[0]->date;
                        $customerReturnAmount = $customerSaleableReturnNote[0]->amount;
                        
                        $salesProfitMargin = $this->getSalesProfitMargin();
                        
                        $salesCost = "";
                        $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId = $this->system_configurations_model->getCustomerMarketReturnCostEntryProfitMarginCreditChartOfAccount();
                        if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
                            $salesCost = $customerReturnAmount;
                        } else {
                            $salesCost = $customerReturnAmount - ($customerReturnAmount/100) * $salesProfitMargin;
                        }

                        $customerSaleableReturnNoteDatanew = array(
                            'customer_id' => $customerId,
                            'location_id' => $locationId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->customer_return_note_model->editCustomerReturnNoteData($customerSaleableReturnId, $customerSaleableReturnNoteDatanew);

                        $correctChartOfAccountsFoundInPrimeEntryBooks = true;
                        $primeEntryBooksToUpdate = '';

                        $customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '1');
                        $customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '2');

                        $primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                        
                        if ($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry && $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry) {
                            $primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry);
                        }

                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 3) {
                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                }
                            }
                        }

                        if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                            $description = $this->lang->line('Journal entry for saleable return sales entry for Customer Return Note number : ') . $referenceNo;
                            $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $customerSaleableReturnId, 
                                    $customerSaleableReturnNoteSalesEntryJournalEntries, '1', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $customerReturnAmount, '0', $description, '', '', '', true);
                            $description = $this->lang->line('Journal entry for saleable return cost entry for Customer Return Note number : ') . $referenceNo;
                            $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry, $customerSaleableReturnId, 
                                    $customerSaleableReturnNoteCostEntryJournalEntries, '2', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $salesCost, '0', $description, '', '', '', true);
                            
                            //Update journal entry for customer return note claim for sales note
                            if ($customerSaleableReturnNoteSalesEntryJournalEntries && sizeof($customerSaleableReturnNoteSalesEntryJournalEntries) > 0) {
                                $transactionClaimJournalEntries = array();
                                foreach ($customerSaleableReturnNoteSalesEntryJournalEntries as $customerSaleableReturnNoteSalesEntryJournalEntry) {
                                    $journalEntryId = $customerSaleableReturnNoteSalesEntryJournalEntry->journal_entry_id;
                                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                            $journalEntry = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);
                                            $transactionClaimJournalEntries[] = $journalEntry;
                                        }
                                    }
                                }
                                
                                $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim, $transactionClaimJournalEntries, 
                                    $salesNoteDate, $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $referenceNo, $locationId, 
                                    $customerId, $customerReturnAmount, true);
                            }
                        } else {
                            $result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
                        }
                    }
                    
                    //Update customer market return note added from sales note
                    if ($customerMarketReturnId != '0') {
                        $customerMarketReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);
                        $customerReturnNoteDate = $customerMarketReturnNote[0]->date;
                        $customerReturnAmount = $customerMarketReturnNote[0]->amount;
                        
                        $salesProfitMargin = $this->getSalesProfitMargin();
                    
                        $profitPortion = "";
                        $salesCost = "";
                        $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId = $this->system_configurations_model->getCustomerMarketReturnCostEntryProfitMarginCreditChartOfAccount();
                        if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
                            $profitPortion = ($customerReturnAmount/100) * $salesProfitMargin;
                            $salesCost = $customerReturnAmount;
                        } else {
                            $salesCost = $customerReturnAmount - ($customerReturnAmount/100) * $salesProfitMargin;
                        }
                        
                        $customerMarketReturnNoteDatanew = array(
                            'customer_id' => $customerId,
                            'location_id' => $locationId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->customer_return_note_model->editCustomerReturnNoteData($customerMarketReturnId, $customerMarketReturnNoteDatanew);

                        $correctChartOfAccountsFoundInPrimeEntryBooks = true;
                        $primeEntryBooksToUpdate = '';

                        $customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '3');
                        $customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '4');

                        $primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                        
                        if ($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry && $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry) {
                            $primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry);
                        }

                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 3) {
                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                }
                            }
                        }

                        if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                            $description = $this->lang->line('Journal entry for market return sales entry for Customer Return Note number : ') . $referenceNo;
                            $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $customerMarketReturnId, 
                                    $customerMarketReturnNoteSalesEntryJournalEntries, '3', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $customerReturnAmount, '0', $description, '', '', '', true);
                            $description = $this->lang->line('Journal entry for market return cost entry for Customer Return Note number : ') . $referenceNo;
                            $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnCostEntry, $customerMarketReturnId, 
                                    $customerMarketReturnNoteCostEntryJournalEntries, '4', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $salesCost, '0', $description, $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId, $profitPortion, '0', true);
                            
                            //Update journal entry for customer return note claim for sales note
                            if ($customerMarketReturnNoteSalesEntryJournalEntries && sizeof($customerMarketReturnNoteSalesEntryJournalEntries) > 0) {
                                $transactionClaimJournalEntries = array();
                                foreach ($customerMarketReturnNoteSalesEntryJournalEntries as $customerMarketReturnNoteSalesEntryJournalEntry) {
                                    $journalEntryId = $customerMarketReturnNoteSalesEntryJournalEntry->journal_entry_id;
                                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                            $journalEntry = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);
                                            $transactionClaimJournalEntries[] = $journalEntry;
                                        }
                                    }
                                }
                        
                                $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim, $transactionClaimJournalEntries, 
                                    $salesNoteDate, $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $referenceNo, $locationId, 
                                    $customerId, $customerReturnAmount, true);
                            }
                        } else {
                            $result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
                        }
                    }
                    
                    //Update income cheque data
                    if ($salesNoteReceiveChequePaymentIds && sizeof($salesNoteReceiveChequePaymentIds) > 0) {
                        foreach($salesNoteReceiveChequePaymentIds as $salesNoteReceiveChequePaymentId) {
                            $receivePaymentMethodRecordsForChequePayments = $this->receive_payment_model->getReceivePaymentMethodList($salesNoteReceiveChequePaymentId, "Cheque Payment");
                            if ($receivePaymentMethodRecordsForChequePayments && sizeof($receivePaymentMethodRecordsForChequePayments) > 0) {
                                foreach($receivePaymentMethodRecordsForChequePayments as $receivePaymentMethodRecord) {
                                    $incomeChequeId = $receivePaymentMethodRecord->cheque_id;
                                    $receiveChequePaymentId = $receivePaymentMethodRecord->receive_payment_id;

                                    if ($incomeChequeId != '0') {
                                        $incomeChequeDatanew = array(
                                            'payer_id' => $customerId,
                                            'location_id' => $locationId,
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->payments_model->editIncomeCheque($incomeChequeId, $incomeChequeDatanew);
                                    }
                                }
                            }
                        }
                    }
                    
                    //Update sales note data
                    $salesNoteDataHistory = array(
						'sales_note_id' => $salesNote[0]->sales_note_id,
						'reference_no' => $salesNote[0]->reference_no,
						'customer_id' => $salesNote[0]->customer_id,
						'territory_id' => $salesNote[0]->territory_id,
						'location_id' => $salesNote[0]->location_id,
						'date' => $salesNote[0]->date,
						'sales_amount' => $salesNote[0]->sales_amount,
						'discount' => $salesNote[0]->discount,
						'amount_payable' => $salesNote[0]->amount_payable,
                        'cash_payment_amount' => $salesNote[0]->cash_payment_amount,
						'cheque_payment_amount' => $salesNote[0]->cheque_payment_amount,
                        'credit_card_payment_amount' => $salesNote[0]->credit_card_payment_amount,
                        'balance_payment' => $salesNote[0]->balance_payment,
                        'customer_return_note_claimed' => $salesNote[0]->customer_return_note_claimed,
						'customer_saleable_return_id' => $salesNote[0]->customer_saleable_return_id,
						'customer_market_return_id' => $salesNote[0]->customer_market_return_id,
						'free_issue_amount' => $salesNote[0]->free_issue_amount,
						'remark' => $salesNote[0]->remark,
						'actioned_user_id' => $salesNote[0]->actioned_user_id,
						'added_date' => $salesNote[0]->added_date,
						'action_date' => $salesNote[0]->action_date,
						'last_action_status' => $salesNote[0]->last_action_status,
					);

					$this->sales_note_model->addSalesNoteDataToHistory($salesNoteDataHistory);

                    $amountPayable = $salesNote[0]->amount_payable;
                    $balancePayment = $salesNote[0]->balance_payment;
                    $salesNoteAmountChange = $salesAmount - $salesNote[0]->sales_amount;
                    $discountChange = $discount - $salesNote[0]->discount;
                    $amountPayable = $amountPayable + $salesNoteAmountChange - $discountChange;
                    $balancePayment = $balancePayment + $salesNoteAmountChange + $customerReturnNoteAmountToAdd - $discountChange;
                    
					$salesNoteDatanew = array(
						'reference_no' => $referenceNo,
						'customer_id' => $customerId,
						'territory_id' => $territoryId,
						'location_id' => $locationId,
						'date' => $salesNoteDate,
						'sales_amount' => $salesAmount,
						'discount' => $discount,
						'free_issue_amount' => $freeIssueAmount,
						'amount_payable' => $amountPayable,
                        'balance_payment' => $balancePayment,
						'remark' => $remark,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);

					$salesNoteSalesEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '1');
					$salesNoteCostEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '2');
					$salesNoteDiscountJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '3');
					$salesNoteFreeIssuesJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '4');
				
					$primeEntryBooksToUpdateForSaleSalesEntry = $this->getPrimeEntryBooksToUpdateForSalesNoteSalesEntryTransaction();
					$primeEntryBooksToUpdateForSaleCostEntry = $this->getPrimeEntryBooksToUpdateForSalesNoteCostEntryTransaction();
					$primeEntryBooksToUpdateForDiscount = $this->getPrimeEntryBooksToUpdateForSalesNoteDiscountTransaction();
					$primeEntryBooksToUpdateForForFreeIssueAmount = $this->getPrimeEntryBooksToUpdateForSalesNoteFreeIssuesTransaction();
				
					if ($salesAmountChanged || $customerChanged || $locationChanged) {
						$this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForSaleSalesEntry, $salesNoteId, $salesNoteSalesEntryJournalEntries, 
                                '1', $salesNoteDate, $referenceNo, $locationId, $customerId, $salesAmount, $salesOldAmount, "Yes", 
                                '', '', '', true);
						
						$salesProfitMargin = $this->getSalesProfitMargin();
						$salesCost = $salesAmount - ($salesAmount/100) * $salesProfitMargin;
						
						$this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForSaleCostEntry, $salesNoteId, $salesNoteCostEntryJournalEntries, 
                                '2', $salesNoteDate, $referenceNo, $locationId, $customerId, $salesCost, $salesCostOldAmount, "No", 
                                '', '', '', true);
					}
					
					if ($discountChanged || $customerChanged || $locationChanged) {
						$this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForDiscount, $salesNoteId, $salesNoteDiscountJournalEntries, 
                                '3', $salesNoteDate, $referenceNo, $locationId, $customerId, $discount, $discountOldAmount, "No", 
                                '', '', '', true);
					}
					
					if ($freeIssueAmountChanged || $customerChanged || $locationChanged) {
						$this->postSalesNoteJournalEntries($primeEntryBooksToUpdateForForFreeIssueAmount, $salesNoteId, $salesNoteFreeIssuesJournalEntries, 
                                '4', $salesNoteDate, $referenceNo, $locationId, $customerId, $freeIssueAmount, $freeIssueOldAmount, "No", 
                                '', '', '', true);
					}
					
					$result = 'ok';
				} else {
					$result = 'no_changes_to_save';
				}
			}

			echo json_encode(array('result' => $result, 'salesNoteId' => $salesNoteId));
		}
	}
	
	public function editSalesNotePaymentData() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Sales_Note_Permissions'])) {
			
			$customerChanged = false;
			$territoryChanged = false;
			$locationChanged = false;
			$salesNoteDateChanged = false;
			$customerSaleableReturnAmountChanged = false;
			$customerMarketReturnAmountChanged = false;
            $customerSaleableReturnAmountChanged = 0;
            $customerMarketReturnAmountChanged = 0;
			
			$result = '';
			
			$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
			$salesNoteDate = $this->db->escape_str($this->input->post('sales_note_date'));
			$customerId = $this->db->escape_str($this->input->post('customer_id'));
			$territoryId = $this->db->escape_str($this->input->post('territory_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
			$customerReturnsAvailable = $this->db->escape_str($this->input->post('customer_returns_available'));
			$customerSaleableReturnAmount = $this->db->escape_str($this->input->post('customer_saleable_return_amount'));
			$customerMarketReturnAmount = $this->db->escape_str($this->input->post('customer_market_return_amount'));
			
			$salesProfitMargin = $this->getSalesProfitMargin();
			$CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId = $this->system_configurations_model->getCustomerMarketReturnCostEntryProfitMarginCreditChartOfAccount();
			
			$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
			
            $salesNoteReferenceNo = $salesNote[0]->reference_no;
			$customerIdOld = $salesNote[0]->customer_id;
			$territoryIdOld = $salesNote[0]->territory_id;
			$locationIdOld = $salesNote[0]->location_id;
			$salesNoteDateOld = $salesNote[0]->date;
			$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
			$customerMarketReturnId = $salesNote[0]->customer_market_return_id;
            
            $primeEntryBookData = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();
        
            $primeEntryBookId = '';
            if ($primeEntryBookData && sizeof($primeEntryBookData) > 0) {
                $primeEntryBookId = $primeEntryBookData[0]->config_filed_value;
            }
            
            $referenceJournalEntry = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByPrimeEntryBookId($salesNoteReferenceNo, $primeEntryBookId);
        
            $salesNoteReferenceJournalEntryId = '';
            if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
                $salesNoteReferenceJournalEntryId = $referenceJournalEntry[0]->journal_entry_id;
            }
			
			$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
			$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);
			
			$customerSaleableReturnReferenceNo = '';
			$customerSaleableReturnAmountOld = '';
			if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
				$customerSaleableReturnReferenceNo = $customerSaleableReturn[0]->reference_no;
				$customerSaleableReturnAmountOld = $customerSaleableReturn[0]->amount;
			}
			
			$customerMarketReturnReferenceNo = '';
			$customerMarketReturnAmountOld = '';
			if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
				$customerMarketReturnReferenceNo = $customerMarketReturn[0]->reference_no;
				$customerMarketReturnAmountOld = $customerMarketReturn[0]->amount;
			}
			
			if ($customerIdOld != $customerId) {$customerChanged = true;}
			if ($territoryIdOld != $territoryId) {$territoryChanged = true;}
			if ($locationIdOld != $locationId) {$locationChanged = true;}
			if ($salesNoteDateOld != $salesNoteDate) {$salesNoteDateChanged = true;}
			if ($customerSaleableReturnAmountOld != $customerSaleableReturnAmount) {
                $customerSaleableReturnAmountChanged = true;
                $customerSaleableReturnAmountChanged = $customerSaleableReturnAmountOld - $customerSaleableReturnAmount;
            }
			if ($customerMarketReturnAmountOld != $customerMarketReturnAmount) {
                $customerMarketReturnAmountChanged = true;
                $customerMarketReturnAmountChanged = $customerMarketReturnAmountOld - $customerMarketReturnAmount;
            }
			
			if ($customerChanged || $territoryChanged || $locationChanged || $salesNoteDateChanged || $customerSaleableReturnAmountChanged) {
				
				if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
					$customerReturnNoteDataHistory = array(
						'customer_return_note_id' => $customerSaleableReturn[0]->customer_return_note_id,
						'reference_no' => $customerSaleableReturn[0]->reference_no,
						'customer_id' => $customerSaleableReturn[0]->customer_id,
						'territory_id' => $customerSaleableReturn[0]->territory_id,
						'location_id' => $customerSaleableReturn[0]->location_id,
						'date' => $customerSaleableReturn[0]->date,
						'amount' => $customerSaleableReturn[0]->amount,
						'type' => $customerSaleableReturn[0]->type,
						'remark' => $customerSaleableReturn[0]->remark,
						'actioned_user_id' => $customerSaleableReturn[0]->actioned_user_id,
						'added_date' => $customerSaleableReturn[0]->added_date,
						'action_date' => $customerSaleableReturn[0]->action_date,
						'last_action_status' => $customerSaleableReturn[0]->last_action_status,
					);

					$this->customer_return_note_model->addCustomerReturnNoteDataToHistory($customerReturnNoteDataHistory);
					
					$customerReturnNoteDatanew = array(
						'customer_id' => $customerId,
						'territory_id' => $territoryId,
						'location_id' => $locationId,
						'date' => $salesNoteDate,
						'amount' => $customerSaleableReturnAmount,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->customer_return_note_model->editCustomerReturnNoteData($customerSaleableReturnId, $customerReturnNoteDatanew);

					$customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '1');
					$customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '2');

					$primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction();
					$primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction();
                    $primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                    
					$description = $this->lang->line('Journal entry for saleable return sales entry for Customer Return Note number : ') . $customerSaleableReturnReferenceNo;
                    
                    
                    $updateJournalEntryMasterData = false;
                    
                    if ($customerChanged || $locationChanged) {
                        $updateJournalEntryMasterData = true;
                    }
                    
					$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $customerSaleableReturnId, 
                                $customerSaleableReturnNoteSalesEntryJournalEntries, '1', $salesNoteDate, $customerSaleableReturnReferenceNo, 
                                $locationId, $customerId, $customerSaleableReturnAmount, $customerSaleableReturnAmountOld, $description, 
                                '', '', '', $updateJournalEntryMasterData);

					$costAmount = $customerSaleableReturnAmount - ($customerSaleableReturnAmount/100) * $salesProfitMargin;
					$costOldAmount = $customerSaleableReturnAmountOld - ($customerSaleableReturnAmountOld/100) * $salesProfitMargin;
					$description = $this->lang->line('Journal entry for saleable return cost entry for Customer Return Note number : ') . $customerSaleableReturnReferenceNo;
                    
					$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry, $salesNoteId, $customerSaleableReturnNoteCostEntryJournalEntries, 
                                '2', $salesNoteDate, $customerSaleableReturnReferenceNo, $locationId, $customerId, $costAmount, $costOldAmount, 
                                $description, '', '', '', $updateJournalEntryMasterData);
                    
                    //Update journal entry for customer return note claim for sales note
                    if ($customerSaleableReturnNoteSalesEntryJournalEntries && sizeof($customerSaleableReturnNoteSalesEntryJournalEntries) > 0) {
                        $transactionClaimJournalEntries = array();
                        foreach ($customerSaleableReturnNoteSalesEntryJournalEntries as $customerSaleableReturnNoteSalesEntryJournalEntry) {
                            $journalEntryId = $customerSaleableReturnNoteSalesEntryJournalEntry->journal_entry_id;
                            $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                            if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                    $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);
                                    $transactionClaimJournalEntries[] = $journalEntry;
                                }
                            }
                        }
                        
                        $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim, $transactionClaimJournalEntries, 
                            $salesNoteDate, $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $customerSaleableReturnReferenceNo, $locationId, 
                            $customerId, $customerSaleableReturnAmount);
                    }
				} else {
					if ($customerSaleableReturnAmount != '') {
				
						$referenceNo = $this->getNextCustomerReturnReferenceNo();

						$data = array(
							'reference_no' => $referenceNo,
							'date' => $salesNoteDate,
							'customer_id' => $customerId,
							'territory_id' => $territoryId,
							'location_id' => $locationId,
							'amount' => $customerSaleableReturnAmount,
							'type' => "saleable_return",
							'remark' => '',
                            'status' => "Claimed",
							'actioned_user_id' => $this->user_id,
							'added_date' => $this->date,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$customerReturnNoteId = $this->customer_return_note_model->add($data);
						$customerSaleableReturnId = $customerReturnNoteId;

						$correctChartOfAccountsFoundInPrimeEntryBooks = true;
						$primeEntryBooksToUpdate = '';

						$customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
						$customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

						$primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction();
						$primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                        
						if ($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry && $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry) {
							$primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry);
						}

						if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                }
                            }
						}

						if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
							$description = $this->lang->line('Journal entry for saleable return sales entry for Customer Return Note number : ') . $referenceNo;
                            
							$referenceJournalEntryId = $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, 
                                    $customerReturnNoteId, $customerSaleableReturnNoteSalesEntryJournalEntries, '1', $salesNoteDate, 
                                    $referenceNo, $locationId, $customerId, $customerSaleableReturnAmount, '0', $description);
                            
							$description = $this->lang->line('Journal entry for saleable return cost entry for Customer Return Note number : ') . $referenceNo;
							$salesCost = $customerSaleableReturnAmount - ($customerSaleableReturnAmount/100) * $salesProfitMargin;
                            
							$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry, 
                                    $customerReturnNoteId, $customerSaleableReturnNoteCostEntryJournalEntries, '2', $salesNoteDate, 
                                    $referenceNo, $locationId, $customerId, $salesCost, '0', $description);
                            
                            //Post journal entry for customer return note claim for sales note
                            if ($salesNoteReferenceJournalEntryId != '') {
                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnNoteClaim, '', $salesNoteDate, 
                                        $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $referenceNo, $locationId, $customerId, 
                                        $customerSaleableReturnAmount);

                                if ($claimReferenceJournalEntryId != '') {
                                    $data = array(
                                        'journal_entry_id' => $referenceJournalEntryId,
                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                }
                            }
						} else {
							$result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
						}
					}
				}
			}
			
			if ($customerChanged || $territoryChanged || $locationChanged || $salesNoteDateChanged || $customerMarketReturnAmountChanged) {
				
				if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
					$customerReturnNoteDataHistory = array(
						'customer_return_note_id' => $customerMarketReturn[0]->customer_return_note_id,
						'reference_no' => $customerMarketReturn[0]->reference_no,
						'customer_id' => $customerMarketReturn[0]->customer_id,
						'territory_id' => $customerMarketReturn[0]->territory_id,
						'location_id' => $customerMarketReturn[0]->location_id,
						'date' => $customerMarketReturn[0]->date,
						'amount' => $customerMarketReturn[0]->amount,
						'type' => $customerMarketReturn[0]->type,
						'remark' => $customerMarketReturn[0]->remark,
						'actioned_user_id' => $customerMarketReturn[0]->actioned_user_id,
						'added_date' => $customerMarketReturn[0]->added_date,
						'action_date' => $customerMarketReturn[0]->action_date,
						'last_action_status' => $customerMarketReturn[0]->last_action_status,
					);

					$this->customer_return_note_model->addCustomerReturnNoteDataToHistory($customerReturnNoteDataHistory);
					
					$customerReturnNoteDatanew = array(
						'customer_id' => $customerId,
						'territory_id' => $territoryId,
						'location_id' => $locationId,
						'date' => $salesNoteDate,
						'amount' => $customerMarketReturnAmount,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->customer_return_note_model->editCustomerReturnNoteData($customerMarketReturnId, $customerReturnNoteDatanew);

					$customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '3');
					$customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '4');

					$primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction();
					$primeEntryBooksToUpdateForCustomerMarketReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction();
                    $primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                    
					$description = $this->lang->line('Journal entry for market return sales entry for Customer Return Note number : ') . $customerMarketReturnReferenceNo;
                    
                    $updateJournalEntryMasterData = false;
                    
                    if ($customerChanged || $locationChanged) {
                        $updateJournalEntryMasterData = true;
                    }
                    
					$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $customerMarketReturnId, 
                            $customerMarketReturnNoteSalesEntryJournalEntries, '3', $salesNoteDate, $customerMarketReturnReferenceNo, 
                            $locationId, $customerId, $customerMarketReturnAmount, $customerMarketReturnAmountOld, $description, 
                            '', '', '', $updateJournalEntryMasterData);

                    $profitPortionOld = "";
                    $costOldAmount = "";
					if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
						$profitPortionOld = ($customerMarketReturnAmountOld/100) * $salesProfitMargin;
						$costOldAmount = $customerMarketReturnAmountOld;
					} else {
						$costOldAmount = $customerMarketReturnAmountOld - ($customerMarketReturnAmountOld/100) * $salesProfitMargin;
					}

                    $profitPortion = "";
                    $costAmount = "";
					if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
						$profitPortion = ($customerMarketReturnAmount/100) * $salesProfitMargin;
						$costAmount = $customerMarketReturnAmount;
					} else {
						$costAmount = $customerMarketReturnAmount - ($customerMarketReturnAmount/100) * $salesProfitMargin;
					}

					$description = $this->lang->line('Journal entry for market return cost entry for Customer Return Note number : ') . $customerMarketReturnReferenceNo;
                    
					$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnCostEntry, $salesNoteId, 
                                $customerMarketReturnNoteCostEntryJournalEntries, '4', $salesNoteDate, $customerMarketReturnReferenceNo, 
                                $locationId, $customerId, $costAmount, $costOldAmount, $description, '', 
                                $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId, $profitPortion, $profitPortionOld, $updateJournalEntryMasterData);
                    
                    //Update journal entry for customer return note claim for sales note
                    if ($customerMarketReturnNoteSalesEntryJournalEntries && sizeof($customerMarketReturnNoteSalesEntryJournalEntries) > 0) {
                        $transactionClaimJournalEntries = array();
                        foreach ($customerMarketReturnNoteSalesEntryJournalEntries as $customerMarketReturnNoteSalesEntryJournalEntry) {
                            $journalEntryId = $customerMarketReturnNoteSalesEntryJournalEntry->journal_entry_id;
                            $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                            if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                    $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);
                                    $transactionClaimJournalEntries[] = $journalEntry;
                                }
                            }
                        }
                        
                        $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim, $transactionClaimJournalEntries, 
                            $salesNoteDate, $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $customerMarketReturnReferenceNo, $locationId, 
                            $customerId, $customerMarketReturnAmount);
                    }
				} else {
					if ($customerMarketReturnAmount != '') {
				
						$referenceNo = $this->getNextCustomerReturnReferenceNo();

						$data = array(
							'reference_no' => $referenceNo,
							'date' => $salesNoteDate,
							'customer_id' => $customerId,
							'territory_id' => $territoryId,
							'location_id' => $locationId,
							'amount' => $customerMarketReturnAmount,
							'type' => "market_return",
							'remark' => '',
                            'status' => "Claimed",
							'actioned_user_id' => $this->user_id,
							'added_date' => $this->date,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$customerReturnNoteId = $this->customer_return_note_model->add($data);
						$customerMarketReturnId = $customerReturnNoteId;

						$correctChartOfAccountsFoundInPrimeEntryBooks = true;
						$primeEntryBooksToUpdate = '';

						$customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
						$customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '4');

						$primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction();
						$primeEntryBooksToUpdateForCustomerMarketReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();
                        
						if ($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry && $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry) {
							$primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry);
						}

						if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 3) {
                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                }
                            }
						}

						if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
							$description = $this->lang->line('Journal entry for market return sales entry for Customer Return Note number : ') . $referenceNo;
                            
							$referenceJournalEntryId = $this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $customerReturnNoteId, 
                                    $customerMarketReturnNoteSalesEntryJournalEntries, '3', $salesNoteDate, $referenceNo, $locationId, $customerId, 
                                    $customerMarketReturnAmount, '0', $description);
                            
							$description = $this->lang->line('Journal entry for market return cost entry for Customer Return Note number : ') . $referenceNo;

							$profitPortion = "";
							$salesCost = "";
							$CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId = $this->system_configurations_model->getCustomerMarketReturnCostEntryProfitMarginCreditChartOfAccount();
							if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
								$profitPortion = ($customerMarketReturnAmount/100) * $salesProfitMargin;
								$salesCost = $customerMarketReturnAmount;
							} else {
								$salesCost = $customerMarketReturnAmount - ($customerMarketReturnAmount/100) * $salesProfitMargin;
							}

							$this->postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnCostEntry, $customerReturnNoteId, 
                                    $customerMarketReturnNoteCostEntryJournalEntries, '4', $salesNoteDate, $referenceNo, $locationId, $customerId, 
                                    $salesCost, '0', $description, '', $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId, 
                                    $profitPortion, '0');
                            
                            //Post journal entry for customer return note claim for sales note
                            if ($salesNoteReferenceJournalEntryId != '') {
                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnNoteClaim, '', $salesNoteDate, 
                                        $salesNoteReferenceNo, '2', $salesNoteId, $salesNoteReferenceJournalEntryId, $referenceNo, $locationId, $customerId, 
                                        $customerMarketReturnAmount);

                                if ($claimReferenceJournalEntryId != '') {
                                    $data = array(
                                        'journal_entry_id' => $referenceJournalEntryId,
                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                }
                            }
						} else {
							$result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
						}
					}
				}
			}
			
            if ($customerReturnsAvailable == "Yes") {
                
                $totalAmount = $salesNote[0]->sales_amount;
                $discount = $salesNote[0]->discount;
                $paidCashAmount = $salesNote[0]->cash_payment_amount;
                $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
                $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
                $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
                $totalPayable = $totalAmount - $discount;
                $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;

                $customerReturnAmountClaimed = $customerReturnAmountClaimed - ($customerSaleableReturnAmountChanged + $customerMarketReturnAmountChanged);
                $newBalancePayment = $totalPayable - ($totalPaid - ($customerSaleableReturnAmountChanged + $customerMarketReturnAmountChanged));

                if ($newBalancePayment < 0) {
                    $newBalancePayment = 0;
                }

                $status = "Open";
                if ($newBalancePayment == 0) {
                    $status = "Claimed";
                }
                
                if (!$customerSaleableReturn || !$customerMarketReturn) {
					$salesNoteDatanew = array(
                        'balance_payment' => $newBalancePayment,
                        'customer_return_note_claimed' => $customerReturnAmountClaimed,
						'customer_saleable_return_id' => $customerSaleableReturnId,
						'customer_market_return_id' => $customerMarketReturnId,
                        'status' => $status
					);

					$this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);
				} else {
                    $salesNoteDatanew = array(
                        'balance_payment' => $newBalancePayment,
                        'customer_return_note_claimed' => $customerReturnAmountClaimed,
                        'status' => $status
					);

					$this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);
                }
            } else if ($customerReturnsAvailable == "No") {
				
                $totalAmount = $salesNote[0]->sales_amount;
                $discount = $salesNote[0]->discount;
                $paidCashAmount = $salesNote[0]->cash_payment_amount;
                $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
                $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
                $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
                $totalPayable = $totalAmount - $discount;
                $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;

                $customerReturnAmountClaimed = $customerReturnAmountClaimed - ($customerSaleableReturnAmountChanged + $customerMarketReturnAmountChanged);
                $newBalancePayment = $totalPayable - ($totalPaid - ($customerSaleableReturnAmountChanged + $customerMarketReturnAmountChanged));

                if ($newBalancePayment < 0) {
                    $newBalancePayment = 0;
                }

                $status = "Open";
                if ($newBalancePayment == 0) {
                    $status = "Claimed";
                }
                
                $salesNoteDatanew = array(
                    'balance_payment' => $newBalancePayment,
                    'customer_return_note_claimed' => $customerReturnAmountClaimed,
                    'customer_saleable_return_id' => $customerSaleableReturnId,
                    'customer_market_return_id' => $customerMarketReturnId,
                    'status' => $status
                );

                $this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);
                
				$status = "deleted";
				
				if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
					
					$customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '1');
					$customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '2');
					
					if ($customerSaleableReturnNoteSalesEntryJournalEntries && sizeof($customerSaleableReturnNoteSalesEntryJournalEntries) > 0) {
						//Delete all journal entries of Sales Note
						foreach($customerSaleableReturnNoteSalesEntryJournalEntries as $journalEntry) {
							$journalEntryId = $journalEntry->journal_entry_id;
							$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
							$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
						}
					}

					if ($customerSaleableReturnNoteCostEntryJournalEntries && sizeof($customerSaleableReturnNoteCostEntryJournalEntries) > 0) {
						//Delete all journal entries of Sales Note
						foreach($customerSaleableReturnNoteCostEntryJournalEntries as $journalEntry) {
							$journalEntryId = $journalEntry->journal_entry_id;
							$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
							$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
						}
					}
					
					$this->customer_return_note_model->deleteCustomerReturnNote($customerSaleableReturnId, $status, $this->user_id);
				}

				if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
					
					$customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '3');
					$customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '4');
					
					if ($customerMarketReturnNoteSalesEntryJournalEntries && sizeof($customerMarketReturnNoteSalesEntryJournalEntries) > 0) {
						//Delete all journal entries of Sales Note
						foreach($customerMarketReturnNoteSalesEntryJournalEntries as $journalEntry) {
							$journalEntryId = $journalEntry->journal_entry_id;
							$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
							$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
						}
					}

					if ($customerMarketReturnNoteCostEntryJournalEntries && sizeof($customerMarketReturnNoteCostEntryJournalEntries) > 0) {
						//Delete all journal entries of Sales Note
						foreach($customerMarketReturnNoteCostEntryJournalEntries as $journalEntry) {
							$journalEntryId = $journalEntry->journal_entry_id;
							$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
							$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
						}
					}
					
					$this->customer_return_note_model->deleteCustomerReturnNote($customerMarketReturnId, $status, $this->user_id);
				}
				
				$salesNoteDatanew = array(
					'customer_saleable_return_id' => '0',
					'customer_market_return_id' => '0',
				);

				$this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);
			}
			
			if ($result == '') {
				$result = 'ok';
			}
		}
		
		echo 'ok';
	}
    
    public function saveReceiveCashPaymentData() {
		
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$salesNoteJournalEntryId = $this->db->escape_str($this->input->post('sales_note_journal_entry_id'));
		$customerId = $this->db->escape_str($this->input->post('customer_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$date = $this->db->escape_str($this->input->post('date'));
		$amount = $this->db->escape_str($this->input->post('amount'));
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteReferenceNo = $salesNote[0]->reference_no;

		$customer = $this->peoples_model->getById($customerId);
		
		$customerType = "";
		if ($customer && sizeof($customer) > 0) {
			$customerType = $customer[0]->people_type;
		}
		
		$result = '';

        $totalAmount = $salesNote[0]->sales_amount;
        $discount = $salesNote[0]->discount;
        $paidCashAmount = $salesNote[0]->cash_payment_amount;
        $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
        $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
        $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
        $totalPayable = $totalAmount - $discount;
        $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;
        
        $newBalancePayment = $totalPayable - ($totalPaid + $amount);
        $cashPaymentAmount = $paidCashAmount + $amount;
        $chequePaymentAmount = $paidChequeAmount;
        $creditCardPaymentAmount = $paidCreditCardAmount;
        
        if ($newBalancePayment < 0) {
            $newBalancePayment = 0;
        }
        
        $status = "Open";
        if ($newBalancePayment == 0) {
            $status = "Claimed";
        }
                             
        //Update sales note for the cash payment
        $salesInvoiceData = array(
            'cash_payment_amount' => $paidCashAmount + $amount,
            'balance_payment' => $newBalancePayment,
            'status' => $status,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );
        
        $this->sales_note_model->editSalesNoteData($salesNoteId, $salesInvoiceData);

        //Add new receive payment entry
		$referenceNo = $this->getNextReceivePaymentReferenceNo();

		$data = array(
			'reference_no' => $referenceNo,
			'date' => $date,
			'payer_type' => $customerType,
			'payer_id' => $customerId,
			'location_id' => $locationId,
			'remark' => '',
			'actioned_user_id' => $this->user_id,
			'added_date' => $this->date,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);

		$receivePaymentId = $this->receive_payment_model->add($data);
        
        //Add the cash payment entry
        $cashPaymentData = array(
            'transaction_type' => 'Sales Note',
            'transaction_id' => $salesNoteId,
            'date' => $date,
            'amount' => $amount,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
        
        //Add receive payment reference transaction
        $primeEntryBookData = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();
        
        $primeEntryBookId = '';
        if ($primeEntryBookData && sizeof($primeEntryBookData) > 0) {
            $primeEntryBookId = $primeEntryBookData[0]->config_filed_value;
        }
        
        $referenceJournalEntry = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByPrimeEntryBookId($salesNoteReferenceNo, $primeEntryBookId);
        
        if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
            $referenceJournalEntryId = $referenceJournalEntry[0]->journal_entry_id;
        }
        
        $data = array(
            'receive_payment_id' => $receivePaymentId,
            'reference_transaction_type_id' => '2',
            'reference_transaction_id' => $salesNoteId,
            'reference_journal_entry_id' => $referenceJournalEntryId,
            'claim_amount' => $amount,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'added'
        );

        $this->receive_payment_model->addReceivePaymentReferenceTransaction($data);
                 
        //Add receive payment method record
        $receivePaymentMethodRecordData = array(
            'receive_payment_id' => $receivePaymentId,
            'payment_method' => "Cash Payment",
            'cash_payment_id' => $paymentId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'added'
        );

        $receivePaymentMethodId = $this->receive_payment_model->addReceivePaymentMethodRecord($receivePaymentMethodRecordData);
        
        //Add sales note cash payment entry
		$salesNoteCashPaymentEntry = array(
			'sales_note_id' => $salesNoteId,
			'receive_cash_payment_method_id' => $receivePaymentMethodId,
            'added_from' => "Sales Note",
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);
		
		$this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCashPaymentEntry);
		
		$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

		$correctChartOfAccountsFoundInPrimeEntryBooks = true;

		$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction();

		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                $primeEntryBookId = $primeEntryBook->config_filed_value;
                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                }
            }
		}

		if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
			if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
				if (!$receivePaymentJournalEntries) {
					//Add journal entry records

                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                        $data = array(
                            'prime_entry_book_id' => $primeEntryBookId,
                            'transaction_date' => $date,
                            'reference_no' => $referenceNo,
                            'should_have_a_payment_journal_entry' => "No",
                            'location_id' => $locationId,
                            'payee_payer_type' => $customerType,
                            'payee_payer_id' => $customerId,
                            'reference_transaction_type_id' => '2',
                            'reference_transaction_id' => $salesNoteId,
                            'reference_journal_entry_id' => $salesNoteJournalEntryId,
                            'description' => $this->lang->line('Journal entry for Receive Payment number : ') . $referenceNo,
                            'post_type' => "Indirect",
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                        $data = array(
                            'receive_payment_id' => $receivePaymentId,
                            'receive_payment_method_id' => $receivePaymentMethodId,
                            'prime_entry_book_id' => $primeEntryBookId,
                            'journal_entry_id' => $journalEntryId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->receive_payment_model->addReceivePaymentJournalEntry($data);

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
				} else if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
					//Get general ledger transactions to update new amount
					foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
						$receivePaymentPrimeEntryBookId = $receivePaymentJournalEntry->prime_entry_book_id;
						$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

						$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($receivePaymentPrimeEntryBookId);
						$receivePaymentGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($receivePaymentJournalEntryId, $receivePaymentPrimeEntryBookId);
						$amount = str_replace(',', '', $amount);

						foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
							foreach($receivePaymentGeneralLedgerTransactions as $receivePaymentGeneralLedgerTransaction) {
								if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
									$data = array(
										'debit_value' => $receivePaymentGeneralLedgerTransaction->debit_value + $amount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);

									$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

									//Same time edit the data in previous years record table.
									$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
								} else if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
									$data = array(
										'credit_value' => $receivePaymentGeneralLedgerTransaction->credit_value + $amount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);

									$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

									//Same time edit the data in previous years record table.
									$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
								}
							}
						}
					}
				}
			} 
		}else {
			$result = 'incorrect_prime_entry_book_selected_for_receive_payment_transaction';
		}
		
		if ($result == '') {
			$result = 'ok';
		}
		
		echo json_encode(array('result' => $result, 'cashPaymentAmount' => number_format($cashPaymentAmount, 2), 
                               'chequePaymentAmount' => number_format($chequePaymentAmount, 2), 
                               'creditCardPaymentAmount' => number_format($creditCardPaymentAmount, 2),
                               'balancePaymentAmount' => number_format($newBalancePayment, 2)));
	}
	
	public function saveReceiveChequePaymentData() {
		
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$salesNoteJournalEntryId = $this->db->escape_str($this->input->post('sales_note_journal_entry_id'));
		$customerId = $this->db->escape_str($this->input->post('customer_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$date = $this->db->escape_str($this->input->post('date'));
		$chequeNumber = $this->db->escape_str($this->input->post('cheque_number'));
		$bank = $this->db->escape_str($this->input->post('bank'));
		$chequeDate = $this->db->escape_str($this->input->post('cheque_date'));
        $thirdPartyCheque = $this->db->escape_str($this->input->post('third_party_cheque'));
		$amount = $this->db->escape_str($this->input->post('amount'));
        $crossedCheque = $this->db->escape_str($this->input->post('crossed_cheque'));
        $chequeDepositPrimeEntryBookId = $this->db->escape_str($this->input->post('cheque_deposit_prime_entry_book_id'));
        
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
		$salesNoteReferenceNo = $salesNote[0]->reference_no;
		
		$customer = $this->peoples_model->getById($customerId);
		
		$customerType = "";
		if ($customer && sizeof($customer) > 0) {
			$customerType = $customer[0]->people_type;
		}
		
		$result = '';
        
        $totalAmount = $salesNote[0]->sales_amount;
        $discount = $salesNote[0]->discount;
        $paidCashAmount = $salesNote[0]->cash_payment_amount;
        $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
        $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
        $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
        $totalPayable = $totalAmount - $discount;
        $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;
        
        $newBalancePayment = $totalPayable - ($totalPaid + $amount);
        $cashPaymentAmount = $paidCashAmount;
        $chequePaymentAmount = $paidChequeAmount + $amount;
        $creditCardPaymentAmount = $paidCreditCardAmount;
        
        if ($newBalancePayment < 0) {
            $newBalancePayment = 0;
        }
        
        $status = "Open";
        if ($newBalancePayment == 0) {
            $status = "Claimed";
        }
                             
        //Update sales note for the cheque payment
        $salesInvoiceData = array(
            'cheque_payment_amount' => $paidChequeAmount + $amount,
            'balance_payment' => $newBalancePayment,
            'status' => $status,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );
        
        $this->sales_note_model->editSalesNoteData($salesNoteId, $salesInvoiceData);
        
        //Add new receive payment entry
		$referenceNo = $this->getNextReceivePaymentReferenceNo();

		$data = array(
			'reference_no' => $referenceNo,
			'date' => $date,
			'payer_type' => $customerType,
			'payer_id' => $customerId,
			'location_id' => $locationId,
			'remark' => '',
			'actioned_user_id' => $this->user_id,
			'added_date' => $this->date,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);

		$receivePaymentId = $this->receive_payment_model->add($data);

        //Add the cheque payment entry
		$incomeChequeData = array(
			'transaction_type' => "Sales Note",
			'date' => $date,
			'payer_id' => $customerId,
			'location_id' => $locationId,
			'reference_no' => $salesNoteReferenceNo,
			'cheque_number' => $chequeNumber,
			'bank' => $bank,
			'cheque_date' => $chequeDate,
            'third_party_cheque' => $thirdPartyCheque,
			'amount' => $amount,
            'crossed_cheque' => $crossedCheque,
            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
			'status' => "In_Hand",
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);

		$chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);

        //Add receive payment reference transaction
        $primeEntryBookData = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();
        
        $primeEntryBookId = '';
        if ($primeEntryBookData && sizeof($primeEntryBookData) > 0) {
            $primeEntryBookId = $primeEntryBookData[0]->config_filed_value;
        }
        
        $referenceJournalEntry = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByPrimeEntryBookId($salesNoteReferenceNo, $primeEntryBookId);
        
        if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
            $referenceJournalEntryId = $referenceJournalEntry[0]->journal_entry_id;
        }
        
        $data = array(
            'receive_payment_id' => $receivePaymentId,
            'reference_transaction_type_id' => '2',
            'reference_transaction_id' => $salesNoteId,
            'reference_journal_entry_id' => $referenceJournalEntryId,
            'claim_amount' => $amount,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'added'
        );

        $this->receive_payment_model->addReceivePaymentReferenceTransaction($data);
                 
        //Add receive payment method record
        $receivePaymentMethodRecordData = array(
            'receive_payment_id' => $receivePaymentId,
            'payment_method' => "Cheque Payment",
            'cheque_id' => $chequeId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'added'
        );

        $receivePaymentMethodId = $this->receive_payment_model->addReceivePaymentMethodRecord($receivePaymentMethodRecordData);
        
        //Add sales note cheque payment entry
		$salesNoteChequePaymentEntry = array(
			'sales_note_id' => $salesNoteId,
			'receive_cheque_payment_method_id' => $receivePaymentMethodId,
            'added_from' => "Sales Note",
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);
		
		$this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteChequePaymentEntry);

		$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

		$correctChartOfAccountsFoundInPrimeEntryBooks = true;

		$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction();

		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                $primeEntryBookId = $primeEntryBook->config_filed_value;
                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                }
            }
		}

		if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
			if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
				if (!$receivePaymentJournalEntries) {
					//Add journal entry records

                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                        $data = array(
                            'prime_entry_book_id' => $primeEntryBookId,
                            'transaction_date' => $date,
                            'reference_no' => $referenceNo,
                            'should_have_a_payment_journal_entry' => "No",
                            'location_id' => $locationId,
                            'payee_payer_type' => $customerType,
                            'payee_payer_id' => $customerId,
                            'reference_transaction_type_id' => '2',
                            'reference_transaction_id' => $salesNoteId,
                            'reference_journal_entry_id' => $salesNoteJournalEntryId,
                            'description' => $this->lang->line('Journal entry for Receive Payment number : ') . $referenceNo,
                            'post_type' => "Indirect",
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                        $data = array(
                            'receive_payment_id' => $receivePaymentId,
                            'receive_payment_method_id' => $receivePaymentMethodId,
                            'prime_entry_book_id' => $primeEntryBookId,
                            'journal_entry_id' => $journalEntryId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->receive_payment_model->addReceivePaymentJournalEntry($data);

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
                                    'transaction_complete' => "No",
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
                                    'transaction_complete' => "No",
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            }

                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                            //Same time add the data to previous years record table.
                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                        }
                        
                        $incomeChequeData = array(
                            'cheque_reference_journal_entry_id' => $journalEntryId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                    }
				} else if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
					//Get general ledger transactions to update new amount
					foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
						$receivePaymentPrimeEntryBookId = $receivePaymentJournalEntry->prime_entry_book_id;
						$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

						$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($receivePaymentPrimeEntryBookId);
						$receivePaymentGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($receivePaymentJournalEntryId, $receivePaymentPrimeEntryBookId);
						$amount = str_replace(',', '', $amount);

						foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
							foreach($receivePaymentGeneralLedgerTransactions as $receivePaymentGeneralLedgerTransaction) {
								if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
									$data = array(
										'debit_value' => $receivePaymentGeneralLedgerTransaction->debit_value + $amount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);

									$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

									//Same time edit the data in previous years record table.
									$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
								} else if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
									$data = array(
										'credit_value' => $receivePaymentGeneralLedgerTransaction->credit_value + $amount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);

									$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

									//Same time edit the data in previous years record table.
									$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
								}
							}
						}
					}
				}
			} 
		}else {
			$result = 'incorrect_prime_entry_book_selected_for_receive_payment_transaction';
		}
		
		if ($result == '') {
			$result = 'ok';
		}
		
		echo json_encode(array('result' => $result, 'cashPaymentAmount' => number_format($cashPaymentAmount, 2), 
                               'chequePaymentAmount' => number_format($chequePaymentAmount, 2),
                               'creditCardPaymentAmount' => number_format($creditCardPaymentAmount, 2),
                               'balancePaymentAmount' => number_format($newBalancePayment, 2)));
	}
    
    public function saveReceiveCreditCardPaymentData() {
		
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$salesNoteJournalEntryId = $this->db->escape_str($this->input->post('sales_note_journal_entry_id'));
		$customerId = $this->db->escape_str($this->input->post('customer_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$date = $this->db->escape_str($this->input->post('date'));
        $cardType = $this->db->escape_str($this->input->post('card_type'));
		$amount = $this->db->escape_str($this->input->post('amount'));
        $paymentAccountId = $this->db->escape_str($this->input->post('payment_account_id'));
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteReferenceNo = $salesNote[0]->reference_no;

		$customer = $this->peoples_model->getById($customerId);
		
		$customerType = "";
		if ($customer && sizeof($customer) > 0) {
			$customerType = $customer[0]->people_type;
		}
		
		$result = '';

        $totalAmount = $salesNote[0]->sales_amount;
        $discount = $salesNote[0]->discount;
        $paidCashAmount = $salesNote[0]->cash_payment_amount;
        $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
        $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
        $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
        $totalPayable = $totalAmount - $discount;
        $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;
        
        $newBalancePayment = $totalPayable - ($totalPaid + $amount);
        $cashPaymentAmount = $paidCashAmount;
        $chequePaymentAmount = $paidChequeAmount;
        $creditCardPaymentAmount = $paidCreditCardAmount + $amount;
        
        if ($newBalancePayment < 0) {
            $newBalancePayment = 0;
        }
        
        $status = "Open";
        if ($newBalancePayment == 0) {
            $status = "Claimed";
        }
                             
        //Update sales note for the credit card payment
        $salesInvoiceData = array(
            'credit_card_payment_amount' => $paidCreditCardAmount + $amount,
            'balance_payment' => $newBalancePayment,
            'status' => $status,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );
        
        $this->sales_note_model->editSalesNoteData($salesNoteId, $salesInvoiceData);

        //Add new receive payment entry
		$referenceNo = $this->getNextReceivePaymentReferenceNo();

		$data = array(
			'reference_no' => $referenceNo,
			'date' => $date,
			'payer_type' => $customerType,
			'payer_id' => $customerId,
			'location_id' => $locationId,
			'remark' => '',
			'actioned_user_id' => $this->user_id,
			'added_date' => $this->date,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);

		$receivePaymentId = $this->receive_payment_model->add($data);
        
        //Add the credit card payment entry
        $creditCardPaymentData = array(
            'transaction_type' => 'Sales Note',
            'transaction_id' => $salesNoteId,
            'date' => $date,
            'card_type' => $cardType,
            'amount' => $amount,
            'card_payment_prime_entry_book_id' => $paymentAccountId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
        
        //Add receive payment reference transaction
        $primeEntryBookData = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();
        
        $primeEntryBookId = '';
        if ($primeEntryBookData && sizeof($primeEntryBookData) > 0) {
            $primeEntryBookId = $primeEntryBookData[0]->config_filed_value;
        }
        
        $referenceJournalEntry = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByPrimeEntryBookId($salesNoteReferenceNo, $primeEntryBookId);
        
        if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
            $referenceJournalEntryId = $referenceJournalEntry[0]->journal_entry_id;
        }
        
        $data = array(
            'receive_payment_id' => $receivePaymentId,
            'reference_transaction_type_id' => '2',
            'reference_transaction_id' => $salesNoteId,
            'reference_journal_entry_id' => $referenceJournalEntryId,
            'claim_amount' => $amount,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'added'
        );

        $this->receive_payment_model->addReceivePaymentReferenceTransaction($data);
                 
        //Add receive payment method record
        $receivePaymentMethodRecordData = array(
            'receive_payment_id' => $receivePaymentId,
            'payment_method' => "Card Payment",
            'credit_card_payment_id' => $paymentId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'added'
        );

        $receivePaymentMethodId = $this->receive_payment_model->addReceivePaymentMethodRecord($receivePaymentMethodRecordData);
        
        //Add sales note credit card payment entry
		$salesNoteCreditCardPaymentEntry = array(
			'sales_note_id' => $salesNoteId,
			'receive_credit_card_payment_method_id' => $receivePaymentMethodId,
            'added_from' => "Sales Note",
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);
		
		$this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCreditCardPaymentEntry);
		
		$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

		$correctChartOfAccountsFoundInPrimeEntryBooks = true;

		$primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($paymentAccountId);

		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                }
            }
		}

		if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
			if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
				if (!$receivePaymentJournalEntries) {
					//Add journal entry records

                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                        $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                        $data = array(
                            'prime_entry_book_id' => $primeEntryBookId,
                            'transaction_date' => $date,
                            'reference_no' => $referenceNo,
                            'should_have_a_payment_journal_entry' => "No",
                            'location_id' => $locationId,
                            'payee_payer_type' => $customerType,
                            'payee_payer_id' => $customerId,
                            'reference_transaction_type_id' => '2',
                            'reference_transaction_id' => $salesNoteId,
                            'reference_journal_entry_id' => $salesNoteJournalEntryId,
                            'description' => $this->lang->line('Journal entry for Receive Payment number : ') . $referenceNo,
                            'post_type' => "Indirect",
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                        $data = array(
                            'receive_payment_id' => $receivePaymentId,
                            'receive_payment_method_id' => $receivePaymentMethodId,
                            'prime_entry_book_id' => $primeEntryBookId,
                            'journal_entry_id' => $journalEntryId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->receive_payment_model->addReceivePaymentJournalEntry($data);

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
				} else if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
					//Get general ledger transactions to update new amount
					foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
						$receivePaymentPrimeEntryBookId = $receivePaymentJournalEntry->prime_entry_book_id;
						$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

						$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($receivePaymentPrimeEntryBookId);
						$receivePaymentGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($receivePaymentJournalEntryId, $receivePaymentPrimeEntryBookId);
						$amount = str_replace(',', '', $amount);

						foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
							foreach($receivePaymentGeneralLedgerTransactions as $receivePaymentGeneralLedgerTransaction) {
								if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
									$data = array(
										'debit_value' => $receivePaymentGeneralLedgerTransaction->debit_value + $amount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);

									$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

									//Same time edit the data in previous years record table.
									$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
								} else if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
									$data = array(
										'credit_value' => $receivePaymentGeneralLedgerTransaction->credit_value + $amount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);

									$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

									//Same time edit the data in previous years record table.
									$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
								}
							}
						}
					}
				}
			} 
		}else {
			$result = 'incorrect_prime_entry_book_selected_for_receive_payment_transaction';
		}
		
		if ($result == '') {
			$result = 'ok';
		}
		
		echo json_encode(array('result' => $result, 'cashPaymentAmount' => number_format($cashPaymentAmount, 2), 
                               'chequePaymentAmount' => number_format($chequePaymentAmount, 2), 
                               'creditCardPaymentAmount' => number_format($creditCardPaymentAmount, 2),
                               'balancePaymentAmount' => number_format($newBalancePayment, 2)));
	}
    
    public function editReceiveCashPaymentData() {
        
		$receivePaymentId = $this->db->escape_str($this->input->post('receive_payment_id'));
        $cashPaymentId = $this->db->escape_str($this->input->post('cash_payment_id'));
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$date = $this->db->escape_str($this->input->post('date'));
        $customerId = $this->db->escape_str($this->input->post('customer_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$amount = $this->db->escape_str($this->input->post('amount'));
		
		$result = '';
		
		$cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
		$dateOld = $cashPayment[0]->date;
		$cashPaymentOld = $cashPayment[0]->amount;
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
		$amountPayable = $salesNote[0]->amount_payable;
        $cashPaymentAmount = $salesNote[0]->cash_payment_amount;
        $chequePaymentAmount = $salesNote[0]->cheque_payment_amount;
        $creditCardPaymentAmount = $salesNote[0]->credit_card_payment_amount;
        $customerIdOld = $salesNote[0]->customer_id;
		$locationIdOld = $salesNote[0]->location_id;
		
		$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
		$customerMarketReturnId = $salesNote[0]->customer_market_return_id;

		$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
		$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);

		$customerSaleableReturnAmount = 0;
		if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
			$customerSaleableReturnAmount = $customerSaleableReturn[0]->amount;
		}

		$customerMarketReturnAmount = 0;
		if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
			$customerMarketReturnAmount = $customerMarketReturn[0]->amount;
		}
		
		$cashPaymentAmount = ($cashPaymentAmount - $cashPaymentOld) + $amount;
		$balancePaymentAmount = $amountPayable - ($customerSaleableReturnAmount + $customerMarketReturnAmount + $cashPaymentAmount + $chequePaymentAmount + $creditCardPaymentAmount);
		
		$dateChanged = false;
        $customerChanged = false;
        $locationChanged = false;
		$cashPaymentChanged = false;

		if ($dateOld != $date) {$dateChanged = true;}
        if ($customerIdOld != $customerId) {$customerChanged = true;}
		if ($locationIdOld != $locationId) {$locationChanged = true;}
		if ($cashPaymentOld != $amount) {$cashPaymentChanged = true;}
		
		if ($customerChanged || $locationChanged || $dateChanged || $cashPaymentChanged) {

            $cashPaymentHistory = array(
                'cash_payment_id' => $cashPayment[0]->cash_payment_id,
                'transaction_type' => $cashPayment[0]->transaction_type,
                'transaction_id' => $cashPayment[0]->transaction_id,
                'date' => $cashPayment[0]->date,
                'amount' => $cashPayment[0]->amount,
                'actioned_user_id' => $cashPayment[0]->actioned_user_id,
                'action_date' => $cashPayment[0]->action_date,
                'last_action_status' => $cashPayment[0]->last_action_status
            );
            
            $this->payments_model->addCashPaymentToHistory($cashPaymentHistory);
            
            $cashPaymentNew = array(
                'date' => $date,
                'amount' => $amount,
                'actioned_user_id' => $this->user_id,
                'action_date' => $this->date,
                'last_action_status' => 'added'
            );
            
            $this->payments_model->editCashPayment($cashPaymentId, $cashPaymentNew);
            
            //Update sales note for the cash payment
            $status = "Open";
            if ($balancePaymentAmount == '0.00') {
                $status = "Claimed";
            }
            
            $salesNoteData = array(
                'customer_id' => $customerId,
				'location_id' => $locationId,
                'cash_payment_amount' => $cashPaymentAmount,
                'balance_payment' => $balancePaymentAmount,
                'status' => $status,
                'actioned_user_id' => $this->user_id,
                'action_date' => $this->date,
                'last_action_status' => 'edited'
            );

            $this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteData);
            
            //Update receive payment data
            $receivePaymentDatanew = array(
				'date' => $date,
				'payer_id' => $customerId,
				'location_id' => $locationId,
                'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);
            
            $this->receive_payment_model->editReceivePaymentData($receivePaymentId, $receivePaymentDatanew);

			$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

			if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
				//Get general ledger transactions to update new location
				foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {

					$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;
                    
                    $journalEntry = $this->journal_entries_model->getJournalEntryById($receivePaymentJournalEntryId);

                    $journalEntryHistoryData = array(
                        'journal_entry_id' => $journalEntry[0]->journal_entry_id,
                        'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
                        'location_id' => $journalEntry[0]->location_id,
                        'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                        'delivery_route_id' => $journalEntry[0]->delivery_route_id,
                        'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                        'due_date' => $journalEntry[0]->due_date,
                        'transaction_date' => $journalEntry[0]->transaction_date,
                        'reference_no' => $journalEntry[0]->reference_no,
                        'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                        'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                        'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                        'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
                        'description' => $journalEntry[0]->description,
                        'post_type' => $journalEntry[0]->post_type,
                        'actioned_user_id' => $journalEntry[0]->actioned_user_id,
                        'action_date' => $journalEntry[0]->action_date,
                        'last_action_status' => $journalEntry[0]->last_action_status
                    );

                    $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);
                        
					$data = array(
						'transaction_date' => $date,
						'location_id' => $locationId,
						'payee_payer_id' => $customerId,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->journal_entries_model->editJournalEntry($receivePaymentJournalEntryId, $data);
				}

				$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction();

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
						//Get general ledger transactions to update new amount
						foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
							$receivePaymentPrimeEntryBookId = $receivePaymentJournalEntry->prime_entry_book_id;
							$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

							$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($receivePaymentPrimeEntryBookId);
							$receivePaymentGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($receivePaymentJournalEntryId, $receivePaymentPrimeEntryBookId);

							$amount = str_replace(',', '', $amount);
							$oldAmount = str_replace(',', '', $cashPaymentOld);

							if ($receivePaymentGeneralLedgerTransactions && sizeof($receivePaymentGeneralLedgerTransactions) > 0) {
								foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
									foreach($receivePaymentGeneralLedgerTransactions as $receivePaymentGeneralLedgerTransaction) {
										if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
											$data = array(
												'debit_value' => ($receivePaymentGeneralLedgerTransaction->debit_value - $oldAmount) + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
										} else if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
											$data = array(
												'credit_value' => ($receivePaymentGeneralLedgerTransaction->credit_value - $oldAmount) + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
										}
									}
								}
							} else {
								foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
									if ($chartOfAccount->debit_or_credit == "debit") {
										$data = array(
											'journal_entry_id' => $receivePaymentJournalEntryId,
											'prime_entry_book_id' => $receivePaymentPrimeEntryBookId,
											'transaction_date' => $date,
											'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
											'debit_value' => $amount,
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
									} else if ($chartOfAccount->debit_or_credit == "credit") {
										$data = array(
											'journal_entry_id' => $receivePaymentJournalEntryId,
											'prime_entry_book_id' => $receivePaymentPrimeEntryBookId,
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
				}
			}
			
			$result = 'ok';
		} else {
			$result = 'no_changes_to_save';
		}
		
		echo json_encode(array('result' => $result, 'cashPaymentAmount' => number_format($cashPaymentAmount, 2), 
                               'chequePaymentAmount' => number_format($chequePaymentAmount, 2), 
                               'creditCardPaymentAmount' => number_format($creditCardPaymentAmount, 2),
                               'balancePaymentAmount' => number_format($balancePaymentAmount, 2)));
	}
	
	public function editReceiveChequePaymentData() {
		
        $receiveChequePaymentId = $this->db->escape_str($this->input->post('receive_payment_id'));
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$chequeId = $this->db->escape_str($this->input->post('cheque_id'));
        $customerId = $this->db->escape_str($this->input->post('customer_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$date = $this->db->escape_str($this->input->post('date'));
		$chequeNumber = $this->db->escape_str($this->input->post('cheque_number'));
		$bank = $this->db->escape_str($this->input->post('bank'));
		$chequeDate = $this->db->escape_str($this->input->post('cheque_date'));
        $thirdPartyCheque = $this->db->escape_str($this->input->post('third_party_cheque'));
		$amount = $this->db->escape_str($this->input->post('amount'));
        $crossedCheque = $this->db->escape_str($this->input->post('crossed_cheque'));
        $chequeDepositPrimeEntryBookId = $this->db->escape_str($this->input->post('cheque_deposit_prime_entry_book_id'));
		
		$result = '';
		
		$incomeCheque = $this->payments_model->getIncomeChequeById($chequeId);
		$dateOld = $incomeCheque[0]->date;
        $chequeNumberOld = $incomeCheque[0]->cheque_number;
		$bankOld = $incomeCheque[0]->bank;
		$chequeDateOld = $incomeCheque[0]->cheque_date;
        $thirdPartyChequeOld = $incomeCheque[0]->third_party_cheque;
        $chequePaymentOld = $incomeCheque[0]->amount;
        $crossedChequeOld = $incomeCheque[0]->crossed_cheque;
        $chequeDepositPrimeEntryBookIdOld = $incomeCheque[0]->cheque_deposit_prime_entry_book_id;
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $customerIdOld = $salesNote[0]->customer_id;
		$locationIdOld = $salesNote[0]->location_id;
		$amountPayable = $salesNote[0]->amount_payable;
        $cashPaymentAmount = $salesNote[0]->cash_payment_amount;
        $chequePaymentAmount = $salesNote[0]->cheque_payment_amount;
        $creditCardPaymentAmount = $salesNote[0]->credit_card_payment_amount;
        $customerReturnNoteClaimed = $salesNote[0]->customer_return_note_claimed;
		
        $chequePaymentAmount = ($chequePaymentAmount - $chequePaymentOld) + $amount;
		$balancePaymentAmount = $amountPayable - ($customerReturnNoteClaimed + $cashPaymentAmount + $chequePaymentAmount + $creditCardPaymentAmount);
		
        $customerChanged = false;
        $locationChanged = false;
		$dateChanged = false;
		$chequeNumberChanged = false;
		$bankChanged = false;
		$chequeDateChanged = false;
        $thirdPartyChequeChanged = false;
		$chequePaymentChanged = false;
        $crossedChequeChanged = false;
        $chequeDepositPrimeEntryBookIdChanged = false;

        if ($customerIdOld != $customerId) {$customerChanged = true;}
		if ($locationIdOld != $locationId) {$locationChanged = true;}
		if ($dateOld != $date) {$dateChanged = true;}
		if ($chequeNumberOld != $chequeNumber) {$chequeNumberChanged = true;}
		if ($bankOld != $bank) {$bankChanged = true;}
		if ($chequeDateOld != $chequeDate) {$chequeDateChanged = true;}
        if ($thirdPartyChequeOld != $thirdPartyCheque) {$thirdPartyChequeChanged = true;}
		if ($chequePaymentOld != $amount) {$chequePaymentChanged = true;}
        if ($crossedChequeOld != $crossedCheque) {$crossedChequeChanged = true;}
        if ($chequeDepositPrimeEntryBookIdOld != $chequeDepositPrimeEntryBookId) {$chequeDepositPrimeEntryBookIdChanged = true;}
		
		if ($customerChanged || $locationChanged || $dateChanged || $chequeNumberChanged || $bankChanged || $chequeDateChanged || 
                $thirdPartyChequeChanged || $chequePaymentChanged || $crossedChequeChanged || $chequeDepositPrimeEntryBookIdChanged) {
				
            $incomeChequeDataHistory = array(
				'date' => $incomeCheque[0]->date,
                'payer_id' => $incomeCheque[0]->payer_id,
                'location_id' => $incomeCheque[0]->location_id,
				'cheque_number' => $incomeCheque[0]->cheque_number,
				'bank' => $incomeCheque[0]->bank,
				'cheque_date' => $incomeCheque[0]->cheque_date,
                'third_party_cheque' => $incomeCheque[0]->third_party_cheque,
				'amount' => $incomeCheque[0]->amount,
                'crossed_cheque' => $incomeCheque[0]->crossed_cheque,
                'cheque_deposit_prime_entry_book_id' => $incomeCheque[0]->cheque_deposit_prime_entry_book_id,
				'actioned_user_id' => $incomeCheque[0]->actioned_user_id,
				'action_date' => $incomeCheque[0]->action_date,
				'last_action_status' => $incomeCheque[0]->last_action_status
			);

			$this->payments_model->addIncomeChequeToHistory($incomeChequeDataHistory);
            
			$incomeChequeData = array(
				'date' => $date,
                'payer_id' => $customerId,
                'location_id' => $locationId,
				'cheque_number' => $chequeNumber,
				'bank' => $bank,
				'cheque_date' => $chequeDate,
                'third_party_cheque' => $thirdPartyCheque,
				'amount' => $amount,
                'crossed_cheque' => $crossedCheque,
                'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
            
            //Update sales note for the cheque payment
            $status = "Open";
            if ($balancePaymentAmount == '0.00') {
                $status = "Claimed";
            }
            
            $salesInvoiceData = array(
                'cheque_payment_amount' => $chequePaymentAmount,
                'balance_payment' => $balancePaymentAmount,
                'status' => $status,
                'actioned_user_id' => $this->user_id,
                'action_date' => $this->date,
                'last_action_status' => 'edited'
            );

            $this->sales_note_model->editSalesNoteData($salesNoteId, $salesInvoiceData);

			$receivePaymentDatanew = array(
				'date' => $date,
				'payer_id' => $customerId,
				'location_id' => $locationId,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->receive_payment_model->editReceivePaymentData($receiveChequePaymentId, $receivePaymentDatanew);

			$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receiveChequePaymentId);

			if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
				//Get general ledger transactions to update new location
				foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {

					$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

                    if ($customerChanged || $locationChanged || $dateChanged) {
                        
                        $journalEntry = $this->journal_entries_model->getJournalEntryById($receivePaymentJournalEntryId);

                        $journalEntryHistoryData = array(
                            'journal_entry_id' => $journalEntry[0]->journal_entry_id,
							'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
							'location_id' => $journalEntry[0]->location_id,
							'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                            'delivery_route_id' => $journalEntry[0]->delivery_route_id,
							'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                            'due_date' => $journalEntry[0]->due_date,
                            'transaction_date' => $journalEntry[0]->transaction_date,
                            'reference_no' => $journalEntry[0]->reference_no,
                            'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                            'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                            'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                            'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
							'description' => $journalEntry[0]->description,
							'post_type' => $journalEntry[0]->post_type,
							'actioned_user_id' => $journalEntry[0]->actioned_user_id,
							'action_date' => $journalEntry[0]->action_date,
							'last_action_status' => $journalEntry[0]->last_action_status
						);

                        $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);
                    
                        $data = array(
                            'transaction_date' => $date,
                            'location_id' => $locationId,
                            'payee_payer_id' => $customerId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->journal_entries_model->editJournalEntry($receivePaymentJournalEntryId, $data);
                    }
				}

				$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction();

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
						//Get general ledger transactions to update new amount
						foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
							$receivePaymentPrimeEntryBookId = $receivePaymentJournalEntry->prime_entry_book_id;
							$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

							$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($receivePaymentPrimeEntryBookId);
							$receivePaymentGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($receivePaymentJournalEntryId, $receivePaymentPrimeEntryBookId);

							$amount = str_replace(',', '', $amount);
							$oldAmount = str_replace(',', '', $chequePaymentOld);

							if ($receivePaymentGeneralLedgerTransactions && sizeof($receivePaymentGeneralLedgerTransactions) > 0) {
								foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
									foreach($receivePaymentGeneralLedgerTransactions as $receivePaymentGeneralLedgerTransaction) {
										if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
											$data = array(
												'debit_value' => ($receivePaymentGeneralLedgerTransaction->debit_value - $oldAmount) + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
										} else if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
											$data = array(
												'credit_value' => ($receivePaymentGeneralLedgerTransaction->credit_value - $oldAmount) + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
										}
									}
								}
							} else {
								foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
									if ($chartOfAccount->debit_or_credit == "debit") {
										$data = array(
											'journal_entry_id' => $receivePaymentJournalEntryId,
											'prime_entry_book_id' => $receivePaymentPrimeEntryBookId,
											'transaction_date' => $date,
											'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
											'debit_value' => $amount,
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
									} else if ($chartOfAccount->debit_or_credit == "credit") {
										$data = array(
											'journal_entry_id' => $receivePaymentJournalEntryId,
											'prime_entry_book_id' => $receivePaymentPrimeEntryBookId,
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
				}
			}
			
			$result = 'ok';
		} else {
			$result = 'no_changes_to_save';
		}
		
		echo json_encode(array('result' => $result, 'cashPaymentAmount' => $cashPaymentAmount, 
                               'chequePaymentAmount' => $chequePaymentAmount, 
                               'creditCardPaymentAmount' => number_format($creditCardPaymentAmount, 2),
                               'balancePaymentAmount' => $balancePaymentAmount));
	}
    
    public function editReceiveCreditCardPaymentData() {
        
		$receivePaymentId = $this->db->escape_str($this->input->post('receive_payment_id'));
        $creditCardPaymentId = $this->db->escape_str($this->input->post('credit_card_payment_id'));
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$date = $this->db->escape_str($this->input->post('date'));
        $customerId = $this->db->escape_str($this->input->post('customer_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
        $cardType = $this->db->escape_str($this->input->post('card_type'));
		$amount = $this->db->escape_str($this->input->post('amount'));
		
		$result = '';
		
		$creditCardPayment = $this->payments_model->getCardPaymentById($creditCardPaymentId);
		$dateOld = $creditCardPayment[0]->date;
        $cardTypeOld = $creditCardPayment[0]->card_type;
		$creditCardPaymentOld = $creditCardPayment[0]->amount;
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
		$amountPayable = $salesNote[0]->amount_payable;
        $cashPaymentAmount = $salesNote[0]->cash_payment_amount;
        $chequePaymentAmount = $salesNote[0]->cheque_payment_amount;
        $creditCardPaymentAmount = $salesNote[0]->credit_card_payment_amount;
        $customerIdOld = $salesNote[0]->customer_id;
		$locationIdOld = $salesNote[0]->location_id;
		
		$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
		$customerMarketReturnId = $salesNote[0]->customer_market_return_id;

		$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
		$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);

		$customerSaleableReturnAmount = 0;
		if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
			$customerSaleableReturnAmount = $customerSaleableReturn[0]->amount;
		}

		$customerMarketReturnAmount = 0;
		if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
			$customerMarketReturnAmount = $customerMarketReturn[0]->amount;
		}
		
		$creditCardPaymentAmount = ($creditCardPaymentAmount - $creditCardPaymentOld) + $amount;
		$balancePaymentAmount = $amountPayable - ($customerSaleableReturnAmount + $customerMarketReturnAmount + $cashPaymentAmount + $chequePaymentAmount + $creditCardPaymentAmount);
		
		$dateChanged = false;
        $customerChanged = false;
        $locationChanged = false;
        $cardTypeChanged = false;
		$creditCardPaymentChanged = false;

		if ($dateOld != $date) {$dateChanged = true;}
        if ($customerIdOld != $customerId) {$customerChanged = true;}
		if ($locationIdOld != $locationId) {$locationChanged = true;}
        if ($cardTypeOld != $cardType) {$cardTypeChanged = true;}
		if ($creditCardPaymentOld != $amount) {$creditCardPaymentChanged = true;}
		
		if ($customerChanged || $locationChanged || $dateChanged || $cardTypeChanged || $creditCardPaymentChanged) {

            $creditCardPaymentHistory = array(
                'credit_card_payment_id' => $creditCardPayment[0]->credit_card_payment_id,
                'transaction_type' => $creditCardPayment[0]->transaction_type,
                'transaction_id' => $creditCardPayment[0]->transaction_id,
                'date' => $creditCardPayment[0]->date,
                'card_type' => $creditCardPayment[0]->card_type,
                'amount' => $creditCardPayment[0]->amount,
                'card_payment_prime_entry_book_id' => $creditCardPayment[0]->card_payment_prime_entry_book_id,
                'actioned_user_id' => $creditCardPayment[0]->actioned_user_id,
                'action_date' => $creditCardPayment[0]->action_date,
                'last_action_status' => $creditCardPayment[0]->last_action_status
            );
            
            $this->payments_model->addCreditCardPaymentToHistory($creditCardPaymentHistory);
            
            $creditCardPaymentNew = array(
                'date' => $date,
                'card_type' => $cardType,
                'amount' => $amount,
                'actioned_user_id' => $this->user_id,
                'action_date' => $this->date,
                'last_action_status' => 'added'
            );
            
            $this->payments_model->editCreditCardPayment($creditCardPaymentId, $creditCardPaymentNew);
            
            //Update sales note for the cash payment
            $status = "Open";
            if ($balancePaymentAmount == '0.00') {
                $status = "Claimed";
            }
            
            $salesNoteData = array(
                'customer_id' => $customerId,
				'location_id' => $locationId,
                'credit_card_payment_amount' => $creditCardPaymentAmount,
                'balance_payment' => $balancePaymentAmount,
                'status' => $status,
                'actioned_user_id' => $this->user_id,
                'action_date' => $this->date,
                'last_action_status' => 'edited'
            );

            $this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteData);
            
            //Update receive payment data
            $receivePaymentDatanew = array(
				'date' => $date,
				'payer_id' => $customerId,
				'location_id' => $locationId,
                'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);
            
            $this->receive_payment_model->editReceivePaymentData($receivePaymentId, $receivePaymentDatanew);

			$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

			if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
				//Get general ledger transactions to update new location
				foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {

					$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;
                    
                    $journalEntry = $this->journal_entries_model->getJournalEntryById($receivePaymentJournalEntryId);

                    $journalEntryHistoryData = array(
                        'journal_entry_id' => $journalEntry[0]->journal_entry_id,
                        'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
                        'location_id' => $journalEntry[0]->location_id,
                        'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                        'delivery_route_id' => $journalEntry[0]->delivery_route_id,
                        'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                        'due_date' => $journalEntry[0]->due_date,
                        'transaction_date' => $journalEntry[0]->transaction_date,
                        'reference_no' => $journalEntry[0]->reference_no,
                        'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                        'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                        'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                        'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
                        'description' => $journalEntry[0]->description,
                        'post_type' => $journalEntry[0]->post_type,
                        'actioned_user_id' => $journalEntry[0]->actioned_user_id,
                        'action_date' => $journalEntry[0]->action_date,
                        'last_action_status' => $journalEntry[0]->last_action_status
                    );

                    $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);
                        
					$data = array(
						'transaction_date' => $date,
						'location_id' => $locationId,
						'payee_payer_id' => $customerId,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->journal_entries_model->editJournalEntry($receivePaymentJournalEntryId, $data);
				}

				$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction();

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
						//Get general ledger transactions to update new amount
						foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
							$receivePaymentPrimeEntryBookId = $receivePaymentJournalEntry->prime_entry_book_id;
							$receivePaymentJournalEntryId = $receivePaymentJournalEntry->journal_entry_id;

							$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($receivePaymentPrimeEntryBookId);
							$receivePaymentGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($receivePaymentJournalEntryId, $receivePaymentPrimeEntryBookId);

							$amount = str_replace(',', '', $amount);
							$oldAmount = str_replace(',', '', $creditCardPaymentOld);

							if ($receivePaymentGeneralLedgerTransactions && sizeof($receivePaymentGeneralLedgerTransactions) > 0) {
								foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
									foreach($receivePaymentGeneralLedgerTransactions as $receivePaymentGeneralLedgerTransaction) {
										if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
											$data = array(
												'debit_value' => ($receivePaymentGeneralLedgerTransaction->debit_value - $oldAmount) + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
										} else if ($receivePaymentGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
											$data = array(
												'credit_value' => ($receivePaymentGeneralLedgerTransaction->credit_value - $oldAmount) + $amount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'edited'
											);

											$this->journal_entries_model->editGeneralLedgerTransaction($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);

											//Same time edit the data in previous years record table.
											$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($receivePaymentJournalEntryId, $receivePaymentGeneralLedgerTransaction->chart_of_account_id, $data);
										}
									}
								}
							} else {
								foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
									if ($chartOfAccount->debit_or_credit == "debit") {
										$data = array(
											'journal_entry_id' => $receivePaymentJournalEntryId,
											'prime_entry_book_id' => $receivePaymentPrimeEntryBookId,
											'transaction_date' => $date,
											'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
											'debit_value' => $amount,
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
									} else if ($chartOfAccount->debit_or_credit == "credit") {
										$data = array(
											'journal_entry_id' => $receivePaymentJournalEntryId,
											'prime_entry_book_id' => $receivePaymentPrimeEntryBookId,
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
				}
			}
			
			$result = 'ok';
		} else {
			$result = 'no_changes_to_save';
		}
		
		echo json_encode(array('result' => $result, 'cashPaymentAmount' => number_format($cashPaymentAmount, 2), 
                               'chequePaymentAmount' => number_format($chequePaymentAmount, 2),
                               'creditCardPaymentAmount' => number_format($creditCardPaymentAmount, 2),
                               'balancePaymentAmount' => number_format($balancePaymentAmount, 2)));
	}
	
	//Cancel Sales Note
	public function cancelSalesNote() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Sales_Note_Permissions'])) {
			$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
			
			$salesNoteSalesEntryJournalEntryId = '0';
			$salesNoteCostEntryJournalEntryId = '0';
			$salesNoteDiscountJournalEntryId = '0';
			$salesNoteFreeIssuesJournalEntryId = '0';
			$customerSaleableReturnSalesEntryJournalEntryId = '0';
			$customerSaleableReturnCostEntryJournalEntryId = '0';
			$customerMarketReturnSalesEntryJournalEntryId = '0';
			$customerMarketReturnCostEntryJournalEntryId = '0';
			
			$salesNoteSalesEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '1');
			$salesNoteCostEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '2');
			$salesNoteDiscountJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '3');
			$salesNoteFreeIssuesJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '4');
			
			$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
			
			$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
			$customerMarketReturnId = $salesNote[0]->customer_market_return_id;
			
			$customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '1');
			$customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '2');
			$customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '3');
			$customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '4');
			
			$salesNoteReceivePaymentEntries = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
			
			$cashPaymentMethodIds = array();
			$chequePaymentMethodIds = array();
            $cardPaymentMethodIds = array();
			if ($salesNoteReceivePaymentEntries && sizeof($salesNoteReceivePaymentEntries) > 0) {
				foreach($salesNoteReceivePaymentEntries as $salesNoteReceivePaymentEntry) {
					if ($salesNoteReceivePaymentEntry->receive_cash_payment_method_id != '0') {
						$cashPaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_cash_payment_method_id;
					}
					
					if ($salesNoteReceivePaymentEntry->receive_cheque_payment_method_id != '0') {
						$chequePaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_cheque_payment_method_id;
					}
                    
                    if ($salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id != '0') {
						$cardPaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id;
					}
				}
			}
			
			$status = "deleted";
			if ($salesNoteSalesEntryJournalEntries && sizeof($salesNoteSalesEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteSalesEntryJournalEntries as $salesNoteSalesEntryJournalEntry) {
					$salesNoteSalesEntryJournalEntryId = $salesNoteSalesEntryJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteSalesEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteSalesEntryJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($salesNoteCostEntryJournalEntries && sizeof($salesNoteCostEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteCostEntryJournalEntries as $salesNoteCostEntryJournalEntry) {
					$salesNoteCostEntryJournalEntryId = $salesNoteCostEntryJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteCostEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteCostEntryJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($salesNoteDiscountJournalEntries && sizeof($salesNoteDiscountJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteDiscountJournalEntries as $salesNoteDiscountJournalEntry) {
					$salesNoteDiscountJournalEntryId = $salesNoteDiscountJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteDiscountJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteDiscountJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($salesNoteFreeIssuesJournalEntries && sizeof($salesNoteFreeIssuesJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteFreeIssuesJournalEntries as $salesNoteFreeIssuesJournalEntry) {
					$salesNoteFreeIssuesJournalEntryId = $salesNoteFreeIssuesJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteFreeIssuesJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteFreeIssuesJournalEntryId, $status, $this->user_id);
				}
			}
			
			$this->customer_return_note_model->deleteCustomerReturnNote($customerSaleableReturnId, $status, $this->user_id);
			
			if ($customerSaleableReturnNoteSalesEntryJournalEntries && sizeof($customerSaleableReturnNoteSalesEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerSaleableReturnNoteSalesEntryJournalEntries as $customerSaleableReturnNoteSalesEntryJournalEntry) {
					$customerSaleableReturnSalesEntryJournalEntryId = $customerSaleableReturnNoteSalesEntryJournalEntry->journal_entry_id;
                    $this->journal_entries_model->deleteJournalEntry($customerSaleableReturnSalesEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($customerSaleableReturnSalesEntryJournalEntryId, $status, $this->user_id);
                    
                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($customerSaleableReturnSalesEntryJournalEntryId);
                    
                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;

                            $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, $status, $this->user_id);
                        }
                    }
				}
			}
			
			if ($customerSaleableReturnNoteCostEntryJournalEntries && sizeof($customerSaleableReturnNoteCostEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerSaleableReturnNoteCostEntryJournalEntries as $journalEntry) {
					$customerSaleableReturnCostEntryJournalEntryId = $journalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($customerSaleableReturnCostEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($customerSaleableReturnCostEntryJournalEntryId, $status, $this->user_id);
				}
			}
			
			$this->customer_return_note_model->deleteCustomerReturnNote($customerMarketReturnId, $status, $this->user_id);
			
			if ($customerMarketReturnNoteSalesEntryJournalEntries && sizeof($customerMarketReturnNoteSalesEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerMarketReturnNoteSalesEntryJournalEntries as $customerMarketReturnNoteSalesEntryJournalEntry) {
					$customerMarketReturnSalesEntryJournalEntryId = $customerMarketReturnNoteSalesEntryJournalEntry->journal_entry_id;
                    $this->journal_entries_model->deleteJournalEntry($customerMarketReturnSalesEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($customerMarketReturnSalesEntryJournalEntryId, $status, $this->user_id);
                    
                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($customerMarketReturnSalesEntryJournalEntryId);
                    
                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;

                            $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, $status, $this->user_id);
                        }
                    }
				}
			}
			
			if ($customerMarketReturnNoteCostEntryJournalEntries && sizeof($customerMarketReturnNoteCostEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerMarketReturnNoteCostEntryJournalEntries as $journalEntry) {
					$customerMarketReturnCostEntryJournalEntryId = $journalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($customerMarketReturnCostEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($customerMarketReturnCostEntryJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($cashPaymentMethodIds && sizeof($cashPaymentMethodIds) > 0) {
				foreach ($cashPaymentMethodIds as $cashPaymentMethodId) {
					
                    $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($cashPaymentMethodId);
                    
					if ($receivePaymentMethod && sizeof($receivePaymentMethod) > 0) {
                        
                        $this->receive_payment_model->deleteReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                        
                        $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);
					
                        if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                            $journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
                            $this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                        }
					}
				}
			}
			
			if ($chequePaymentMethodIds && sizeof($chequePaymentMethodIds) > 0) {
				foreach ($chequePaymentMethodIds as $chequePaymentMethodId) {
					
                    $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($chequePaymentMethodId);
                    
					if ($receivePaymentMethod && sizeof($receivePaymentMethod) > 0) {
                        
                        $this->receive_payment_model->deleteReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                        $this->payments_model->deleteIncomeCheque($receivePaymentMethod[0]->cheque_id, $status, $this->user_id);
                        
                        $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);
					
                        if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                            $journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
                            $this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                        }
					}
				}
			}
            
            if ($cardPaymentMethodIds && sizeof($cardPaymentMethodIds) > 0) {
				foreach ($cardPaymentMethodIds as $cardPaymentMethodId) {
					
                    $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($cardPaymentMethodId);
                    
					if ($receivePaymentMethod && sizeof($receivePaymentMethod) > 0) {
                        
                        $this->receive_payment_model->deleteReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                        
                        $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);
					
                        if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                            $journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
                            $this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                        }
					}
				}
			}
			
			$salesNoteCancelledJournalEntries = array(
				'sales_note_id' => $salesNoteId,
				'sales_note_sales_entry_journal_entry_id' => $salesNoteSalesEntryJournalEntryId,
				'sales_note_cost_entry_journal_entry_id' => $salesNoteCostEntryJournalEntryId,
				'sales_note_discount_entry_journal_entry_id' => $salesNoteDiscountJournalEntryId,
				'sales_note_free_issue_entry_journal_entry_id' => $salesNoteFreeIssuesJournalEntryId,
				'customer_saleable_return_sales_entry_journal_entry_id' => $customerSaleableReturnSalesEntryJournalEntryId,
				'customer_saleable_return_cost_entry_journal_entry_id' => $customerSaleableReturnCostEntryJournalEntryId,
				'customer_market_return_sales_entry_journal_entry_id' => $customerMarketReturnSalesEntryJournalEntryId,
				'customer_market_return_cost_entry_journal_entry_id' => $customerMarketReturnCostEntryJournalEntryId,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'added'
			);

			$this->sales_note_model->addSalesNoteCancelledJournalEntryData($salesNoteCancelledJournalEntries);
			
			$salesNoteDatanew = array(
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'cancelled'
			);

			$this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);
			
			echo 'ok';
		}
	}
	
	//Activate Sales Note
	public function activateSalesNote() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Sales_Note_Permissions'])) {
			$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
			
			$salesNoteDatanew = array(
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->sales_note_model->editSalesNoteData($salesNoteId, $salesNoteDatanew);
			
			$salesNoteCancelledJournalEntries = $this->sales_note_model->getSalesNoteCancelledJournalEntryData($salesNoteId);
			
			if ($salesNoteCancelledJournalEntries && sizeof($salesNoteCancelledJournalEntries) > 0) {
				$salesNoteSalesEntryJournalEntryId = $salesNoteCancelledJournalEntries[0]->sales_note_sales_entry_journal_entry_id;
				$salesNoteCostEntryJournalEntryId = $salesNoteCancelledJournalEntries[0]->sales_note_cost_entry_journal_entry_id;
				$salesNoteDiscountJournalEntryId = $salesNoteCancelledJournalEntries[0]->sales_note_discount_entry_journal_entry_id;
				$salesNoteFreeIssuesJournalEntryId = $salesNoteCancelledJournalEntries[0]->sales_note_free_issue_entry_journal_entry_id;
				$customerSaleableReturnSalesEntryJournalEntryId = $salesNoteCancelledJournalEntries[0]->customer_saleable_return_sales_entry_journal_entry_id;
				$customerSaleableReturnCostEntryJournalEntryId = $salesNoteCancelledJournalEntries[0]->customer_saleable_return_cost_entry_journal_entry_id;
				$customerMarketReturnSalesEntryJournalEntryId = $salesNoteCancelledJournalEntries[0]->customer_market_return_sales_entry_journal_entry_id;
				$customerMarketReturnCostEntryJournalEntryId = $salesNoteCancelledJournalEntries[0]->customer_market_return_cost_entry_journal_entry_id;
				
				$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
				$salesNoteCustomerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
				$salesNoteCustomerMarketReturnId = $salesNote[0]->customer_market_return_id;
				$salesNoteReceivePaymentEntries = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
			
				$cashPaymentMethodIds = array();
				$chequePaymentMethodIds = array();
                $cardPaymentMethodIds = array();
				if ($salesNoteReceivePaymentEntries && sizeof($salesNoteReceivePaymentEntries) > 0) {
					foreach($salesNoteReceivePaymentEntries as $salesNoteReceivePaymentEntry) {
						if ($salesNoteReceivePaymentEntry->receive_cash_payment_method_id != '0') {
							$cashPaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_cash_payment_method_id;
						}

						if ($salesNoteReceivePaymentEntry->receive_cheque_payment_method_id != '0') {
							$chequePaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_cheque_payment_method_id;
						}
                        
                        if ($salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id != '0') {
							$cardPaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id;
						}
					}
				}
				
				$status = "edited";
				
				if ($salesNoteSalesEntryJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($salesNoteSalesEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($salesNoteSalesEntryJournalEntryId, $status, $this->user_id);
				}
				
				if ($salesNoteCostEntryJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($salesNoteCostEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($salesNoteCostEntryJournalEntryId, $status, $this->user_id);
				}
				
				if ($salesNoteDiscountJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($salesNoteDiscountJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($salesNoteDiscountJournalEntryId, $status, $this->user_id);
				}
				
				if ($salesNoteFreeIssuesJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($salesNoteFreeIssuesJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($salesNoteFreeIssuesJournalEntryId, $status, $this->user_id);
				}
				
				$this->customer_return_note_model->activateCustomerReturnNote($salesNoteCustomerSaleableReturnId, $status, $this->user_id);
				
				if ($customerSaleableReturnSalesEntryJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($customerSaleableReturnSalesEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($customerSaleableReturnSalesEntryJournalEntryId, $status, $this->user_id);
                    
                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($customerSaleableReturnSalesEntryJournalEntryId);
                    
                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                            
                            $this->journal_entries_model->activateJournalEntry($claimReferenceJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->activateGeneralLedgerTransactions($claimReferenceJournalEntryId, $status, $this->user_id);
                        }
                    }
				}
				
				if ($customerSaleableReturnCostEntryJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($customerSaleableReturnCostEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($customerSaleableReturnCostEntryJournalEntryId, $status, $this->user_id);
				}
				
				$this->customer_return_note_model->activateCustomerReturnNote($salesNoteCustomerMarketReturnId, $status, $this->user_id);
				
				if ($customerMarketReturnSalesEntryJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($customerMarketReturnSalesEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($customerMarketReturnSalesEntryJournalEntryId, $status, $this->user_id);
                    
                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($customerMarketReturnSalesEntryJournalEntryId);
                    
                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                            
                            $this->journal_entries_model->activateJournalEntry($claimReferenceJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->activateGeneralLedgerTransactions($claimReferenceJournalEntryId, $status, $this->user_id);
                        }
                    }
				}
				
				if ($customerMarketReturnCostEntryJournalEntryId != '0') {
					$this->journal_entries_model->activateJournalEntry($customerMarketReturnCostEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->activateGeneralLedgerTransactions($customerMarketReturnCostEntryJournalEntryId, $status, $this->user_id);
				}
				
				if ($cashPaymentMethodIds && sizeof($cashPaymentMethodIds) > 0) {
					foreach ($cashPaymentMethodIds as $cashPaymentMethodId) {
						
                        $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($cashPaymentMethodId);
                    
                        if ($receivePaymentMethod && sizeof($receivePaymentMethod) > 0) {
                            $this->receive_payment_model->activateReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                            $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);

                            if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                                $journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
                                $this->journal_entries_model->activateJournalEntry($journalEntryId, $status, $this->user_id);
                                $this->journal_entries_model->activateGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                            }
                        }
					}
				}

				if ($chequePaymentMethodIds && sizeof($chequePaymentMethodIds) > 0) {
					foreach ($chequePaymentMethodIds as $chequePaymentMethodId) {
						
                        $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($chequePaymentMethodId);
                        
                        if ($receivePaymentMethod && sizeof($receivePaymentMethod) > 0) {
                            $this->receive_payment_model->activateReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                            $this->payments_model->activateIncomeCheque($receivePaymentMethod[0]->cheque_id, $status, $this->user_id);
                            
                            $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);

                            if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                                $journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
                                $this->journal_entries_model->activateJournalEntry($journalEntryId, $status, $this->user_id);
                                $this->journal_entries_model->activateGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                            }
                        }
					}
				}
                
                if ($cardPaymentMethodIds && sizeof($cardPaymentMethodIds) > 0) {
					foreach ($cardPaymentMethodIds as $cardPaymentMethodId) {
						
                        $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($cardPaymentMethodId);
                        
                        if ($receivePaymentMethod && sizeof($receivePaymentMethod) > 0) {
                            $this->receive_payment_model->activateReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                            
                            $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);

                            if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                                $journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
                                $this->journal_entries_model->activateJournalEntry($journalEntryId, $status, $this->user_id);
                                $this->journal_entries_model->activateGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                            }
                        }
					}
				}
			}
			
			echo 'ok';
		}
	}

	//Delete Sales Note
	public function deleteSalesNote() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Sales_Note_Permissions'])) {
			$salesNoteId = $this->db->escape_str($this->input->post('id'));

			$salesNoteSalesEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '1');
			$salesNoteCostEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '2');
			$salesNoteDiscountJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '3');
			$salesNoteFreeIssuesJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '4');
			
			$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
			
			$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
			$customerMarketReturnId = $salesNote[0]->customer_market_return_id;
			
			$customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '1');
			$customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerSaleableReturnId, '2');
			$customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '3');
			$customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerMarketReturnId, '4');
			
			$salesNoteReceivePaymentEntries = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
			
			$cashPaymentMethodIds = array();
			$chequePaymentMethodIds = array();
            $creditCardPaymentMethodIds = array();
			if ($salesNoteReceivePaymentEntries && sizeof($salesNoteReceivePaymentEntries) > 0) {
				foreach($salesNoteReceivePaymentEntries as $salesNoteReceivePaymentEntry) {
					if ($salesNoteReceivePaymentEntry->receive_cash_payment_method_id != '0') {
						$cashPaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_cash_payment_method_id;
					}
					
					if ($salesNoteReceivePaymentEntry->receive_cheque_payment_method_id != '0') {
						$chequePaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_cheque_payment_method_id;
					}
                    
                    if ($salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id != '0') {
						$creditCardPaymentMethodIds[] = $salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id;
					}
				}
			}
			
			$status = "deleted";
			if ($salesNoteSalesEntryJournalEntries && sizeof($salesNoteSalesEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteSalesEntryJournalEntries as $salesNoteSalesEntryJournalEntry) {
					$salesNoteSalesEntryJournalEntryId = $salesNoteSalesEntryJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteSalesEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteSalesEntryJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($salesNoteCostEntryJournalEntries && sizeof($salesNoteCostEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteCostEntryJournalEntries as $salesNoteCostEntryJournalEntry) {
					$salesNoteCostEntryJournalEntryId = $salesNoteCostEntryJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteCostEntryJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteCostEntryJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($salesNoteDiscountJournalEntries && sizeof($salesNoteDiscountJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteDiscountJournalEntries as $salesNoteDiscountJournalEntry) {
					$salesNoteDiscountJournalEntryId = $salesNoteDiscountJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteDiscountJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteDiscountJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($salesNoteFreeIssuesJournalEntries && sizeof($salesNoteFreeIssuesJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($salesNoteFreeIssuesJournalEntries as $salesNoteFreeIssuesJournalEntry) {
					$salesNoteFreeIssuesJournalEntryId = $salesNoteFreeIssuesJournalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($salesNoteFreeIssuesJournalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($salesNoteFreeIssuesJournalEntryId, $status, $this->user_id);
				}
			}
			
			if ($customerSaleableReturnNoteSalesEntryJournalEntries && sizeof($customerSaleableReturnNoteSalesEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerSaleableReturnNoteSalesEntryJournalEntries as $journalEntry) {
					$journalEntryId = $journalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                    
                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);
                    
                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                            
                            $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, $status, $this->user_id);
                        }
                    }
				}
			}
			
			if ($customerSaleableReturnNoteCostEntryJournalEntries && sizeof($customerSaleableReturnNoteCostEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerSaleableReturnNoteCostEntryJournalEntries as $journalEntry) {
					$journalEntryId = $journalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
				}
			}
			
			if ($customerMarketReturnNoteSalesEntryJournalEntries && sizeof($customerMarketReturnNoteSalesEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerMarketReturnNoteSalesEntryJournalEntries as $journalEntry) {
					$journalEntryId = $journalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
                    
                    $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);
                    
                    if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                        foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                            $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                            
                            $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, $status, $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, $status, $this->user_id);
                        }
                    }
				}
			}
			
			if ($customerMarketReturnNoteCostEntryJournalEntries && sizeof($customerMarketReturnNoteCostEntryJournalEntries) > 0) {
				//Delete all journal entries of Sales Note
				foreach($customerMarketReturnNoteCostEntryJournalEntries as $journalEntry) {
					$journalEntryId = $journalEntry->journal_entry_id;
					$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
				}
			}
			
			if ($cashPaymentMethodIds && sizeof($cashPaymentMethodIds) > 0) {
				foreach ($cashPaymentMethodIds as $cashPaymentMethodId) {
                    
                    $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($cashPaymentMethodId);
                    $this->receive_payment_model->deleteReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                    
					$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);
					
					if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
						$journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
						$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
						$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
					}
				}
			}
			
			if ($chequePaymentMethodIds && sizeof($chequePaymentMethodIds) > 0) {
				foreach ($chequePaymentMethodIds as $chequePaymentMethodId) {
                    
                    $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($chequePaymentMethodId);
                    $this->receive_payment_model->deleteReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                    $this->payments_model->deleteIncomeCheque($receivePaymentMethod[0]->cheque_id, $status, $this->user_id);
                    
					$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);
					
					if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
						$journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
						$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
						$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
					}
				}
			}
            
            if ($creditCardPaymentMethodIds && sizeof($creditCardPaymentMethodIds) > 0) {
				foreach ($creditCardPaymentMethodIds as $creditCardPaymentMethodId) {
                    
                    $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($creditCardPaymentMethodId);
                    $this->receive_payment_model->deleteReceivePayment($receivePaymentMethod[0]->receive_payment_id, $status, $this->user_id);
                    
					$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentMethod[0]->receive_payment_id);
					
					if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
						$journalEntryId = $receivePaymentJournalEntries[0]->journal_entry_id;
						$this->journal_entries_model->deleteJournalEntry($journalEntryId, $status, $this->user_id);
						$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, $status, $this->user_id);
					}
				}
			}
			
			if ($this->sales_note_model->deleteSalesNote($salesNoteId, $status, $this->user_id)) {
				$this->customer_return_note_model->deleteCustomerReturnNote($customerSaleableReturnId, $status, $this->user_id);
				$this->customer_return_note_model->deleteCustomerReturnNote($customerMarketReturnId, $status, $this->user_id);
				
				$html = '<div class="alert alert-success alert-dismissable">
					<a class="close" href="#" data-dismiss="alert">x </a>
					<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}
			
			echo $html;
		}
	}
	
	public function deleteReceiveChequePayment() {
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$receiveChequePaymentMethodId = $this->db->escape_str($this->input->post('receive_cheque_payment_method_id'));

		$result = '';
		
		$receiveChequePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($receiveChequePaymentMethodId);
		$chequeId = $receiveChequePaymentMethod[0]->cheque_id;
        $receiveChequePaymentId = $receiveChequePaymentMethod[0]->receive_payment_id;
        
        $incomeCheque = $this->payments_model->getIncomeChequeById($chequeId);
        $chequePaymentOld = $incomeCheque[0]->amount;
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
		$amountPayable = $salesNote[0]->amount_payable;
		
		$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
		$customerMarketReturnId = $salesNote[0]->customer_market_return_id;

		$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
		$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);

		$customerSaleableReturnAmount = 0;
		if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
			$customerSaleableReturnAmount = $customerSaleableReturn[0]->amount;
		}

		$customerMarketReturnAmount = 0;
		if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
			$customerMarketReturnAmount = $customerMarketReturn[0]->amount;
		}
		
		$salesNoteReceivePaymentEntries = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
		
		$receiveCashPaymentMethodIdList = array();
		$receiveChequePaymentMethodIdList = array();
        $receiveCreditCardPaymentMethodIdList = array();
		
		if ($salesNoteReceivePaymentEntries && sizeof($salesNoteReceivePaymentEntries) > 0) {
			foreach ($salesNoteReceivePaymentEntries as $salesNoteReceivePaymentEntry) {
				if ($salesNoteReceivePaymentEntry->receive_cash_payment_method_id != '0') {
					$receiveCashPaymentMethodIdList[] = $salesNoteReceivePaymentEntry->receive_cash_payment_method_id;
				}
				
				if ($salesNoteReceivePaymentEntry->receive_cheque_payment_method_id != '0') {
					$receiveChequePaymentMethodIdList[] = $salesNoteReceivePaymentEntry->receive_cheque_payment_method_id;
				}
                
                if ($salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id != '0') {
					$receiveCreditCardPaymentMethodIdList[] = $salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id;
				}
			}
		}
		
		$cashPaymentAmount = 0;
		if ($receiveCashPaymentMethodIdList && sizeof($receiveCashPaymentMethodIdList) > 0) {
			foreach($receiveCashPaymentMethodIdList as $receiveCashPaymentMethodId) {
                $receiveCashPaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($receiveCashPaymentMethodId);
                $cashPaymentId = $receiveCashPaymentMethod[0]->cash_payment_id;
                $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
				$cashPaymentAmount = $cashPaymentAmount + $cashPayment[0]->amount;
			}
		}
		
		$chequePaymentAmount = 0;
		if ($receiveChequePaymentMethodIdList && sizeof($receiveChequePaymentMethodIdList) > 0) {
			foreach($receiveChequePaymentMethodIdList as $receiveChequePaymentMethodId) {
                $receiveChequePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($receiveChequePaymentMethodId);
                $chequeId = $receiveChequePaymentMethod[0]->cheque_id;
                $incomeCheque = $this->payments_model->getIncomeChequeById($chequeId);
				$chequePaymentAmount = $chequePaymentAmount + $incomeCheque[0]->amount;
			}
		}
        
        $creditCardPaymentAmount = 0;
		if ($receiveCreditCardPaymentMethodIdList && sizeof($receiveCreditCardPaymentMethodIdList) > 0) {
			foreach($receiveCreditCardPaymentMethodIdList as $receiveCreditCardPaymentMethodId) {
                $receiveCreditCardPaymentMethod = $this->receive_payment_model->getReceivePaymentMethodById($receiveCreditCardPaymentMethodId);
                $creditCardPaymentId = $receiveCreditCardPaymentMethod[0]->credit_card_payment_id;
                $creditCardPayment = $this->payments_model->getCardPaymentById($creditCardPaymentId);
				$creditCardPaymentAmount = $creditCardPaymentAmount + $creditCardPayment[0]->amount;
			}
		}
		
		$chequePaymentAmount = $chequePaymentAmount - $chequePaymentOld;
		$creditPaymentAmount = str_replace(',', '', number_format(($amountPayable - ($customerSaleableReturnAmount + $customerMarketReturnAmount + $cashPaymentAmount + $chequePaymentAmount + $creditCardPaymentAmount)), 2));
		$cashPaymentAmount = str_replace(',', '', number_format($cashPaymentAmount, 2));
		$chequePaymentAmount = str_replace(',', '', number_format($chequePaymentAmount, 2));
        $creditCardPaymentAmount = str_replace(',', '', number_format($creditCardPaymentAmount, 2));
        
        //Update sales note for the cheque payment
        
        $salesInvoiceData = array(
            'cheque_payment_amount' => $chequePaymentAmount,
            'balance_payment' => $creditPaymentAmount,
            'status' => "Open",
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->sales_note_model->editSalesNoteData($salesNoteId, $salesInvoiceData);
		
		$status  = "deleted";
		$this->receive_payment_model->deleteReceivePayment($receiveChequePaymentId, $status, $this->user_id);
		
		$this->payments_model->deleteIncomeCheque($chequeId, $status, $this->user_id);
        
        $this->receive_payment_model->deleteReceivePaymentMethodRecord($receiveChequePaymentMethod[0]->receive_payment_method_id);
        
        $salesNoteReceivePayment = $this->sales_note_model->getSalesNoteReceivePaymentBySalesNoteIdAndReceiveChequePaymentMethodId($salesNoteId, $receiveChequePaymentMethodId);
        
        if ($salesNoteReceivePayment && sizeof($salesNoteReceivePayment) > 0) {
            $salesNoteReceivePaymentId = $salesNoteReceivePayment[0]->sales_note_receive_payment_id;
            $this->sales_note_model->deleteSalesNoteReceivePaymentEntry($salesNoteReceivePaymentId, $status, $this->user_id);
        }

		$receiveChequePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receiveChequePaymentId);
		
		if ($receiveChequePaymentJournalEntries && sizeof($receiveChequePaymentJournalEntries) > 0) {
			//Delete all journal entries of GDN
			foreach($receiveChequePaymentJournalEntries as $receiveChequePaymentJournalEntry) {
				$receiveChequePaymentJournalEntryId = $receiveChequePaymentJournalEntry->journal_entry_id;
				$this->journal_entries_model->deleteJournalEntry($receiveChequePaymentJournalEntryId, $status, $this->user_id);
				$this->journal_entries_model->deleteGeneralLedgerTransactions($receiveChequePaymentJournalEntryId, $status, $this->user_id);
			}
		}

		echo json_encode(array('result' => $result, 'cashPaymentAmount' => $cashPaymentAmount, 'chequePaymentAmount' => $chequePaymentAmount, 
                               'creditCardPaymentAmount' => $creditCardPaymentAmount, 'creditPaymentAmount' => number_format($creditPaymentAmount, 2)));
	}
	
	public function deleteCashPayment() {
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$cashPaymentId = $this->db->escape_str($this->input->post('cash_payment_id'));

		$result = '';
		
		$cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
		$cashPaymentOld = $cashPayment[0]->amount;
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
		$amountPayable = $salesNote[0]->amount_payable;
        $cashPaymentAmount = $salesNote[0]->cash_payment_amount;
        $chequePaymentAmount = $salesNote[0]->cheque_payment_amount;
        $creditCardPaymentAmount = $salesNote[0]->credit_card_payment_amount;
		
		$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
		$customerMarketReturnId = $salesNote[0]->customer_market_return_id;

		$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
		$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);

		$customerSaleableReturnAmount = 0;
		if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
			$customerSaleableReturnAmount = $customerSaleableReturn[0]->amount;
		}

		$customerMarketReturnAmount = 0;
		if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
			$customerMarketReturnAmount = $customerMarketReturn[0]->amount;
		}
		
		$cashPaymentAmount = $cashPaymentAmount - $cashPaymentOld;
		$balancePaymentAmount = str_replace(',', '', number_format(($amountPayable - ($customerSaleableReturnAmount + $customerMarketReturnAmount + $cashPaymentAmount + $chequePaymentAmount)), 2));
		$cashPaymentAmount = str_replace(',', '', number_format($cashPaymentAmount, 2));
		$chequePaymentAmount = str_replace(',', '', number_format($chequePaymentAmount, 2));
        
        //Update sales note for the cash payment
        
        $salesInvoiceData = array(
            'cash_payment_amount' => $cashPaymentAmount,
            'balance_payment' => $balancePaymentAmount,
            'status' => "Open",
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->sales_note_model->editSalesNoteData($salesNoteId, $salesInvoiceData);
		
		$status  = "deleted";
		$this->payments_model->deleteCashPayment($cashPaymentId, $status, $this->user_id);
        
        $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodRecordForCashPayment($cashPaymentId);
        $this->receive_payment_model->deleteReceivePaymentMethodRecord($receivePaymentMethod[0]->receive_payment_method_id);
        
        $receivePaymentId = $receivePaymentMethod[0]->receive_payment_id;
        $receiveCashPaymentMethodId = $receivePaymentMethod[0]->receive_payment_method_id;
        $receivePaymentMethods = $this->receive_payment_model->getReceivePaymentMethodList($receivePaymentId);
        
        if ($receivePaymentMethods == false) {
            $this->receive_payment_model->deleteReceivePayment($receivePaymentId, $status, $this->user_id);
        }
        
        $salesNoteReceivePayment = $this->sales_note_model->getSalesNoteReceivePaymentBySalesNoteIdAndReceiveCashPaymentMethodId($salesNoteId, $receiveCashPaymentMethodId);
        
        if ($salesNoteReceivePayment && sizeof($salesNoteReceivePayment) > 0) {
            $salesNoteReceivePaymentId = $salesNoteReceivePayment[0]->sales_note_receive_payment_id;
            $this->sales_note_model->deleteSalesNoteReceivePaymentEntry($salesNoteReceivePaymentId, $status, $this->user_id);
        }

		$receiveCashPaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);
		
		if ($receiveCashPaymentJournalEntries && sizeof($receiveCashPaymentJournalEntries) > 0) {
			//Delete all journal entries of GDN
			foreach($receiveCashPaymentJournalEntries as $receiveCashPaymentJournalEntry) {
				$receiveCashPaymentJournalEntryId = $receiveCashPaymentJournalEntry->journal_entry_id;
				$this->journal_entries_model->deleteJournalEntry($receiveCashPaymentJournalEntryId, $status, $this->user_id);
				$this->journal_entries_model->deleteGeneralLedgerTransactions($receiveCashPaymentJournalEntryId, $status, $this->user_id);
			}
		}

		echo json_encode(array('result' => $result, 'cashPaymentAmount' => $cashPaymentAmount, 'chequePaymentAmount' => $chequePaymentAmount, 
                               'creditCardPaymentAmount' => $creditCardPaymentAmount, 'balancePaymentAmount' => number_format($balancePaymentAmount, 2)));
	}
    
    public function deleteCreditCardPayment() {
        
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$creditCardPaymentId = $this->db->escape_str($this->input->post('credit_card_payment_id'));

		$result = '';
		
		$cardPayment = $this->payments_model->getCardPaymentById($creditCardPaymentId);
		$cardPaymentOld = $cardPayment[0]->amount;
		
		$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
		$amountPayable = $salesNote[0]->amount_payable;
        $cashPaymentAmount = $salesNote[0]->cash_payment_amount;
        $chequePaymentAmount = $salesNote[0]->cheque_payment_amount;
        $creditCardPaymentAmount = $salesNote[0]->credit_card_payment_amount;
		
		$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
		$customerMarketReturnId = $salesNote[0]->customer_market_return_id;

		$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
		$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);

		$customerSaleableReturnAmount = 0;
		if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
			$customerSaleableReturnAmount = $customerSaleableReturn[0]->amount;
		}

		$customerMarketReturnAmount = 0;
		if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
			$customerMarketReturnAmount = $customerMarketReturn[0]->amount;
		}
		
		$creditCardPaymentAmount = $creditCardPaymentAmount - $cardPaymentOld;
		$balancePaymentAmount = str_replace(',', '', number_format(($amountPayable - ($customerSaleableReturnAmount + $customerMarketReturnAmount + $cashPaymentAmount + $chequePaymentAmount + $creditCardPaymentAmount)), 2));
		$cashPaymentAmount = str_replace(',', '', number_format($cashPaymentAmount, 2));
		$chequePaymentAmount = str_replace(',', '', number_format($chequePaymentAmount, 2));
        $creditCardPaymentAmount = str_replace(',', '', number_format($creditCardPaymentAmount, 2));
        
        //Update sales note for the cash payment
        
        $salesInvoiceData = array(
            'credit_card_payment_amount' => $creditCardPaymentAmount,
            'balance_payment' => $balancePaymentAmount,
            'status' => "Open",
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->sales_note_model->editSalesNoteData($salesNoteId, $salesInvoiceData);
		
		$status  = "deleted";
		$this->payments_model->deleteCardPayment($creditCardPaymentId, $status, $this->user_id);
        
        $receivePaymentMethod = $this->receive_payment_model->getReceivePaymentMethodRecordForCreditCardPayment($creditCardPaymentId);
        $this->receive_payment_model->deleteReceivePaymentMethodRecord($receivePaymentMethod[0]->receive_payment_method_id);
        
        $receivePaymentId = $receivePaymentMethod[0]->receive_payment_id;
        $receiveCardPaymentMethodId = $receivePaymentMethod[0]->receive_payment_method_id;
        $receivePaymentMethods = $this->receive_payment_model->getReceivePaymentMethodList($receivePaymentId);
        
        if ($receivePaymentMethods == false) {
            $this->receive_payment_model->deleteReceivePayment($receivePaymentId, $status, $this->user_id);
        }
        
        $salesNoteReceivePayment = $this->sales_note_model->getSalesNoteReceivePaymentBySalesNoteIdAndReceiveCardPaymentMethodId($salesNoteId, $receiveCardPaymentMethodId);
        
        if ($salesNoteReceivePayment && sizeof($salesNoteReceivePayment) > 0) {
            $salesNoteReceivePaymentId = $salesNoteReceivePayment[0]->sales_note_receive_payment_id;
            $this->sales_note_model->deleteSalesNoteReceivePaymentEntry($salesNoteReceivePaymentId, $status, $this->user_id);
        }

		$receiveCardPaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);
		
		if ($receiveCardPaymentJournalEntries && sizeof($receiveCardPaymentJournalEntries) > 0) {
			//Delete all journal entries of GDN
			foreach($receiveCardPaymentJournalEntries as $receiveCardPaymentJournalEntry) {
				$receiveCardPaymentJournalEntryId = $receiveCardPaymentJournalEntry->journal_entry_id;
				$this->journal_entries_model->deleteJournalEntry($receiveCardPaymentJournalEntryId, $status, $this->user_id);
				$this->journal_entries_model->deleteGeneralLedgerTransactions($receiveCardPaymentJournalEntryId, $status, $this->user_id);
			}
		}

		echo json_encode(array('result' => $result, 'cashPaymentAmount' => $cashPaymentAmount, 'chequePaymentAmount' => $chequePaymentAmount, 
                               'creditCardPaymentAmount' => $creditCardPaymentAmount, 'balancePaymentAmount' => number_format($balancePaymentAmount, 2)));
	}

	public function getSalesNoteData() {
		if(isset($this->data['ACM_Bookkeeping_View_Sales_Note_Permissions'])) {
			$salesNoteId = $this->db->escape_str($this->input->post('id'));
			$salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
			
			$customerReturnAvailable = "No";
			
			$amountPayable = $salesNote[0]->amount_payable;
			
			$customerSaleableReturnId = $salesNote[0]->customer_saleable_return_id;
			$customerMarketReturnId = $salesNote[0]->customer_market_return_id;
			
			$salesNoteStatus = $salesNote[0]->last_action_status;
			
			if ($salesNote && sizeof($salesNote) > 0) {
				if ($customerSaleableReturnId != '0' || $customerMarketReturnId != '0') {
					$customerReturnAvailable = "Yes";
				}
			}
			
			if ($salesNoteStatus == "cancelled") {
				$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteByIdConsideringDeleted($customerSaleableReturnId);
				$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteByIdConsideringDeleted($customerMarketReturnId);
			} else {
				$customerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerSaleableReturnId);
				$customerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($customerMarketReturnId);
			}
			
            $customerSaleableReturnNoteId = '';
            $customerSaleableReturnNoteReferenceNo = '';
			$customerSaleableReturnAmount = '';
            
			if ($customerSaleableReturn && sizeof($customerSaleableReturn) > 0) {
				$customerSaleableReturnAmount = $customerSaleableReturn[0]->amount;
                $customerSaleableReturnNoteId = $customerSaleableReturn[0]->customer_return_note_id;
                $customerSaleableReturnNoteReferenceNo = $customerSaleableReturn[0]->reference_no;
			}
			
			$customerMarketReturnAmount = '';
            $customerMarketReturnNoteId = '';
            $customerMarketReturnNoteReferenceNo = '';
            
			if ($customerMarketReturn && sizeof($customerMarketReturn) > 0) {
				$customerMarketReturnAmount = $customerMarketReturn[0]->amount;
                $customerMarketReturnNoteId = $customerMarketReturn[0]->customer_return_note_id;
                $customerMarketReturnNoteReferenceNo = $customerMarketReturn[0]->reference_no;
			}
            
            $customerSaleableReturnAmountClaimedInReceivePayment = '0';
            $customerMarketReturnAmountClaimedInReceivePayment = '0';
            
            $receivePaymentReferenceTransactionsOfSalesNote = $this->receive_payment_model->getReferenceTransactionsOfSalesNote($salesNoteId);
	
            $referenceTransactionIdList = array();
            if ($receivePaymentReferenceTransactionsOfSalesNote && sizeof($receivePaymentReferenceTransactionsOfSalesNote) > 0) {
                foreach ($receivePaymentReferenceTransactionsOfSalesNote as $receivePaymentId) {
                    $referenceTransactionIds = $this->receive_payment_model->getReceivePaymentCustomerReturnNoteReferenceTransactions($receivePaymentId);
                    
                    if ($referenceTransactionIds) {
                        foreach($referenceTransactionIds as $referenceTransactionId) {
                            $referenceTransactionIdList[] = $referenceTransactionId;
                        }
                    }
                }
            }
            
            if ($referenceTransactionIdList && sizeof($referenceTransactionIdList) > 0) {
                foreach($referenceTransactionIdList as $referenceTransactionId) {
                    $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($referenceTransactionId);
                    
                    if ($customerReturnNote && sizeof($customerReturnNote) > 0) {
                        if ($customerReturnNote[0]->type == "saleable_return") {
                            $customerSaleableReturnAmountClaimedInReceivePayment = $customerSaleableReturnAmountClaimedInReceivePayment + $customerReturnNote[0]->amount;
                        } else if ($customerReturnNote[0]->type == "market_return") {
                            $customerMarketReturnAmountClaimedInReceivePayment = $customerMarketReturnAmountClaimedInReceivePayment + $customerReturnNote[0]->amount;
                        }
                    }
                }
            }
            
            $customerSaleableReturnAmountClaimedInReceivePayment = number_format($customerSaleableReturnAmountClaimedInReceivePayment, 2);
            $customerMarketReturnAmountClaimedInReceivePayment = number_format($customerMarketReturnAmountClaimedInReceivePayment, 2);
            
			$salesNoteSalesEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId, '1');
			$salesJournalEntryId = '';
			if ($salesNoteSalesEntryJournalEntries && sizeof($salesNoteSalesEntryJournalEntries) > 0) {
				$salesJournalEntryId = $salesNoteSalesEntryJournalEntries[0]->journal_entry_id;
			}

			$html = "";
			if ($salesNote != null) {
				foreach ($salesNote as $row) {
                    
                    $amountPayable = number_format($row->amount_payable, 2);
                    $cashPaymentAmount = number_format($row->cash_payment_amount, 2);
                    $chequePaymentAmount = number_format($row->cheque_payment_amount, 2);
                    $creditCardPaymentAmount = number_format($row->credit_card_payment_amount, 2);
                    $balancePayment = number_format($row->balance_payment, 2);
                    
					$html .="   <form class='form form-horizontal validate-form save_form'>
								<div class='tabbable' style='margin-top: 20px'>
									<ul class='nav nav-responsive nav-tabs'>
										<li class='active'>
											<a data-toggle='tab' class='tab-header' href='#sales_note_details_edit'>{$this->lang->line('Sales Note Details')}</a>
										</li>
										<li class=''>
											<a data-toggle='tab' class='tab-header' href='#customer_returns_and_payment_details_edit'>{$this->lang->line('Customer Returns and Payment Details')}</a>
										</li>
									</ul>
									<div class='tab-content'>
										<div id='sales_note_details_edit' class='tab-pane active'>
											<div class='form-group'>
												<input class='form-control'   id='sales_note_id_edit' name='sales_note_id_edit' type='hidden' value='{$row->sales_note_id}'>
												<input class='form-control'   id='sales_journal_entry_id_edit' name='sales_journal_entry_id_edit' type='hidden' value='{$salesJournalEntryId}'>
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
														<input class='form-control' id='sales_note_date_edit' name='sales_note_date_edit'
															data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$row->date}'>
														<span class='input-group-addon'>
															<span class='glyphicon glyphicon-calendar'/>
														</span>
													</div>
													<div id='sales_note_date_editError' class='red'></div>
												</div>
											</div>
											<div class='form-group'>
												<label class='control-label col-sm-3'>{$this->lang->line('Customer')}</label>
												<div class='col-sm-4 controls' id='customer_dropdown_edit'>
													<select class='select2 form-control' id='customer_id_edit'>";
												
								$html .=                   $this->peoples_model->getCustomersToDropDownWithSavedOption($row->customer_id, "People Name", "", "", true);
										
								$html .="				</select>
												<div id='customer_id_editError' class='red'></div>
												</div>
											</div>
											<div class='form-group'>
												<label class='control-label col-sm-3'>{$this->lang->line('Territory')}</label>
												<div class='col-sm-4 controls'>
													<select class='select2 form-control' id='territory_edit'>";

								$html .=                   $this->territories_model->getTerritoriesToDropDownWithSavedOption($row->territory_id, 'Territory Name');
								$html .="               </select>
												<div id='territory_editError' class='red'></div>
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
												<label class='control-label col-sm-3'>{$this->lang->line('Sales Amount')} *</label>
												<div class='col-sm-4 controls'>
													<input class='form-control'  id='sales_amount_edit' name='sales_amount_edit'
														placeholder='{$this->lang->line('Sales Amount')}' type='text' value='{$row->sales_amount}' onblur='handleSalesAmountAddition()'>
													<div id='sales_amount_editError' class='red'></div>
												</div>
											</div>
											<div class='form-group'>
												<label class='control-label col-sm-3'>{$this->lang->line('Discount')}</label>
												<div class='col-sm-4 controls'>
													<input class='form-control'  id='discount_edit' name='discount_edit'
														placeholder='{$this->lang->line('Discount')}' type='text' value='{$row->discount}' onblur='handleDiscountAddition()'>
													<div id='discount_editError' class='red'></div>
												</div>
											</div>
											<div class='form-group'>
												<label class='control-label col-sm-3'>{$this->lang->line('Free Issue Amount')}</label>
												<div class='col-sm-4 controls'>
													<input class='form-control'  id='free_issue_amount_edit' name='free_issue_amount_edit'
														placeholder='{$this->lang->line('Free Issue Amount')}' type='text' value='{$row->free_issue_amount}' onblur='handleFreeIssueAmountAddition()'>
													<div id='free_issue_amount_editError' class='red'></div>
												</div>
											</div>
											<div class='form-group'>
												<label class='control-label col-sm-3'>{$this->lang->line('Amount Payable')}</label>
												<div class='col-sm-4 controls' id='sales_amount_payable_div_edit'>
													<input class='form-control' id='sales_amount_payable_edit' name='sales_amount_payable_edit' disabled
														   placeholder='{$this->lang->line('Amount Payable')}' type='text' 
														   value='{$amountPayable}'>
													<div id='sales_amount_payable_editError' class='red'></div>
												</div>
											</div>
                                            <div class='form-group'>
												<label class='control-label col-sm-3'>{$this->lang->line('Balance Amount')}</label>
												<div class='col-sm-4 controls' id='sales_balance_amount_div_edit'>
													<input class='form-control' id='sales_balance_amount_edit' name='sales_balance_amount_edit' disabled
														   placeholder='{$this->lang->line('Balance Amount')}' type='text' 
														   value='{$balancePayment}'>
													<div id='sales_balance_amount_editError' class='red'></div>
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
                                                            if(isset($this->data['ACM_Bookkeeping_Edit_Sales_Note_Permissions'])) {
                                                                $html .= "<button id='edit_button_on_sales_note_edit' class='btn btn-success save' onclick='editSalesNoteData({$row->sales_note_id});' type='button'>
                                                                            <i class='icon-save'></i>
                                                                            {$this->lang->line('Edit')}
                                                                        </button> ";
                                                            }

                                                        if ($row->last_action_status != "cancelled") {	
                                                $html.="            <button id='cancel_sales_note_button_on_sales_note_edit' class='btn btn-danger' type='button' id='cancel_sales_note_on_sales_note_save' onclick='cancelSalesNote();'>
                                                                <i class='icon-off'></i>
                                                                {$this->lang->line('Cancel Sales Note')}
                                                            </button>";
                                                        } else {
                                                $html.="            <button id='cancel_sales_note_button_on_sales_note_edit' class='btn btn-info' type='button' id='cancel_sales_note_on_sales_note_save' onclick='cancelSalesNote();'>
                                                                <i class='icon-ok'></i>
                                                                {$this->lang->line('Activate Sales Note')}
                                                            </button>";			
                                                        }
                                                        }
															
											$html.="			<button class='btn btn-warning cancel' onclick='closeSalesNoteEditForm({$row->sales_note_id});' type='button'>
															<i class='icon-remove'></i>
															{$this->lang->line('Close')}
														</button>
													</div>
												</div>
											</div>
										</div>
										<div id='customer_returns_and_payment_details_edit' class='tab-pane'>
											<div class='form-group'>
												<label class='control-label col-sm-4'>{$this->lang->line('Amount Payable')}</label>
												<div class='col-sm-4 controls' id='sales_amount_payable_on_payment_div'>
													<input class='form-control'  id='sales_amount_payable_on_payment_edit' name='sales_amount_payable_on_payment_edit' disabled
														placeholder='{$this->lang->line('Amount Payable')}' type='text' value='{$amountPayable}'>
													<div id='sales_amount_payable_on_payment_editError' class='red'></div>
												</div>
											</div>
											<div class='form-group'>
												<div class='col-sm-4 controls'></div>
												<div class='col-sm-5 controls'>
													<input type='checkbox' name='customer_returns_available_edit' id='customer_returns_available_edit' style='vertical-align: text-bottom;' onchange='handleCustomerReturnsAvailableSelect(this.id);'";
														
												if ($customerReturnAvailable == "Yes") {
									$html.="			checked";				
												}
									$html.="			>
													<label for='customer_returns_available_edit' >{$this->lang->line('Customer Returns Available')}</label>
												</div>
											</div>
											<div id='customer_return_details_div_edit'>
												<div class='form-group'>
													<label class='control-label col-sm-4'>{$this->lang->line('Customer Saleable Return Amount')}</label>
													<div class='col-sm-4 controls' id='customer_saleable_return_amount_div_edit'>
														<input class='form-control' id='customer_saleable_return_amount_edit' name='customer_saleable_return_amount_edit'
															   placeholder='{$this->lang->line('Customer Saleable Return Amount')}' type='text' 
															   value='{$customerSaleableReturnAmount}' onblur='handleCustomerSaleableReturnAmountAddition();'>
														<div id='customer_saleable_return_amount_editError' class='red'></div>
													</div>
                                                    <div class='col-sm-4 controls'>
                                                        <a href='../bookkeepingSection/customer_return_note_controller/?searchId=" . $customerSaleableReturnNoteId . "' target='_blank'>" . $customerSaleableReturnNoteReferenceNo . "</a>
                                                    </div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-4'>{$this->lang->line('Customer Market Return Amount')}</label>
													<div class='col-sm-4 controls' id='customer_market_return_amount_div_edit'>
														<input class='form-control' id='customer_market_return_amount_edit' name='customer_market_return_amount_edit'
															   placeholder='{$this->lang->line('Customer Market Return Amount')}' type='text' 
															   value='{$customerMarketReturnAmount}' onblur='handleCustomerMarketReturnAmountAddition();'>
														<div id='customer_market_return_amount_editError' class='red'></div>
													</div>
                                                    <div class='col-sm-4 controls'>
                                                        <a href='../bookkeepingSection/customer_return_note_controller/?searchId=" . $customerMarketReturnNoteId . "' target='_blank'>" . $customerMarketReturnNoteReferenceNo . "</a>
                                                    </div>
												</div>
											</div>
                                            <div id='customer_returns_claimed_in_receive_payment_div_edit'>
												<div class='form-group'>
													<label class='control-label col-sm-4'>{$this->lang->line('Customer Saleable Return Amount Claimed from Receive Payment')}</label>
													<div class='col-sm-4 controls' id='customer_saleable_return_amount_claimed_in_receive_payment_div_edit'>
														<input class='form-control' id='customer_saleable_return_amount_claimed_in_receive_payment_edit' name='customer_saleable_return_amount_claimed_in_receive_payment_edit'
															   placeholder='{$this->lang->line('Customer Saleable Return Amount Claimed from Receive Payment')}' type='text' disabled
															   value='{$customerSaleableReturnAmountClaimedInReceivePayment}'>
														<div id='customer_saleable_return_amount_claimed_in_receive_payment_editError' class='red'></div>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-4'>{$this->lang->line('Customer Market Return Amount Claimed from Receive Payment')}</label>
													<div class='col-sm-4 controls' id='customer_market_return_amount_claimed_in_receive_payment_div_edit'>
														<input class='form-control' id='customer_market_return_amount_claimed_in_receive_payment_edit' name='customer_market_return_amount_claimed_in_receive_payment_edit'
															   placeholder='{$this->lang->line('Customer Market Return Amount Claimed from Receive Payment')}' type='text' disabled
															   value='{$customerMarketReturnAmountClaimedInReceivePayment}'>
														<div id='customer_market_return_amount_claimed_in_receive_payment_editError' class='red'></div>
													</div>
												</div>
											</div>
											<div class='form-group'>
												<label class='control-label col-sm-4'>{$this->lang->line('Cash Payment')}</label>
												<div class='col-sm-4 controls'>
													<input class='form-control' id='cash_payment_edit' name='cash_payment_edit'
														   placeholder='{$this->lang->line('Cash Payment')}' type='text' disabled
														   value='{$cashPaymentAmount}'>
													<div id='cash_payment_editError' class='red'></div>
												</div>
												<div class='col-sm-4 controls'>
													<button class='btn btn-success save' id='add_cash_payment_edit'
															onclick='addCashPayment();' type='button'>
														<i class='icon-save'></i> {$this->lang->line('Cash Payments')}
													</button>	
												</div>
											</div>
											<div class='form-group'>
												<label class='control-label col-sm-4'>{$this->lang->line('Cheque Payment')}</label>
												<div class='col-sm-4 controls'>
													<input class='form-control' id='cheque_payment_edit' name='cheque_payment_edit'
														   placeholder='{$this->lang->line('Cheque Payment')}' type='text' disabled
														   value='{$chequePaymentAmount}'>
													<div id='cheque_payment_editError' class='red'></div>
												</div>
												<div class='col-sm-4 controls'>
													<button class='btn btn-success save' id='add_cheque_payment_edit'
															onclick='addChequePayment();' type='button'>
														<i class='icon-save'></i> {$this->lang->line('Cheque Payments')}
													</button>	
												</div>
											</div>
                                            <div class='form-group'>
												<label class='control-label col-sm-4'>{$this->lang->line('Credit Card Payment')}</label>
												<div class='col-sm-4 controls'>
													<input class='form-control' id='credit_card_payment_edit' name='credit_card_payment_edit'
														   placeholder='{$this->lang->line('Credit Card Payment')}' type='text' disabled
														   value='{$creditCardPaymentAmount}'>
													<div id='credit_card_payment_editError' class='red'></div>
												</div>
												<div class='col-sm-4 controls'>
													<button class='btn btn-success save' id='add_credit_card_payment_edit'
															onclick='addCreditCardPayment();' type='button'>
														<i class='icon-save'></i> {$this->lang->line('Credit Card Payments')}
													</button>	
												</div>
											</div>
                                            <div class='form-group'>
												<label class='control-label col-sm-4'>{$this->lang->line('Balance Amount')}</label>
												<div class='col-sm-4 controls' id='sales_balance_amount_div_edit'>
													<input class='form-control' id='sales_balance_amount_on_payment_edit' name='sales_balance_amount_on_payment_edit' disabled
														   placeholder='{$this->lang->line('Balance Amount')}' type='text' 
														   value='{$balancePayment}'>
													<div id='sales_balance_amount_on_payment_editError' class='red'></div>
												</div>
											</div>
											<div class='form-actions' style='margin-bottom:0'>
												<div class='row'>
													<div class='col-sm-9 col-sm-offset-3'>";
                                                        if ($row->status != "Claimed") {
                                                            if(isset($this->data['ACM_Bookkeeping_Edit_Sales_Note_Permissions'])) {
                                                                $html .= "<button id='edit_button_on_sales_note_payment_edit' class='btn btn-success save' onclick='editSalesNotePaymentData({$row->sales_note_id});' type='button'>
                                                                            <i class='icon-save'></i>
                                                                            {$this->lang->line('Edit')}
                                                                        </button> ";
                                                            }

                                                    if ($row->last_action_status != "cancelled") {
                                                $html.="            <button id='cancel_sales_note_button_on_sales_note_payment_edit' class='btn btn-danger' type='button' id='cancel_sales_note_on_sales_note_payment_save' onclick='cancelSalesNote();'>
                                                                <i class='icon-off'></i>
                                                                {$this->lang->line('Cancel Sales Note')}
                                                            </button>";
                                                    } else {
                                                $html.="            <button id='cancel_sales_note_button_on_sales_note_payment_edit' class='btn btn-info' type='button' id='cancel_sales_note_on_sales_note_payment_save' onclick='cancelSalesNote();'>
                                                                <i class='icon-ok'></i>
                                                                {$this->lang->line('Activate Sales Note')}
                                                            </button>";		
                                                    }
                                                        }
												
											$html.="		<button class='btn btn-warning cancel' onclick='closeSalesNoteEditForm({$row->sales_note_id});' type='button'>
															<i class='icon-remove'></i>
															{$this->lang->line('Close')}
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>";
				}
			}

			echo json_encode(array('result' => $html, 'customerReturnAvailable' => $customerReturnAvailable, 
                                   'salesNoteStatus' => $row->last_action_status, 'balancePayment' => $balancePayment));
		}
	}
	
	public function getReceiveChequePaymentData() {
        $salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$chequeId = $this->db->escape_str($this->input->post('cheque_id'));

        $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteStatus = $salesNote[0]->status;
        
		$incomeCheque = $this->payments_model->getIncomeChequeById($chequeId);
        $receivePayment = $this->receive_payment_model->getReceivePaymentMethodRecordForChequePayment($chequeId);
		
		$date = '';
        $chequeNumber = '';
        $bank = '';
        $chequeDate = '';
        $thirdPartyCheque = '';
		$amount = '';
        $crossedCheque = '';
        $chequeDepositPrimeEntryBookId = '';
        
		if ($incomeCheque && sizeof($incomeCheque) > 0) {
			$date = $incomeCheque[0]->date;
			$chequeNumber = $incomeCheque[0]->cheque_number;
			$bank = $incomeCheque[0]->bank;
			$chequeDate = $incomeCheque[0]->cheque_date;
            $thirdPartyCheque = $incomeCheque[0]->third_party_cheque;
			$amount = str_replace(",", "", number_format($incomeCheque[0]->amount, 2));
            $crossedCheque = $incomeCheque[0]->crossed_cheque;
            $chequeDepositPrimeEntryBookId = $incomeCheque[0]->cheque_deposit_prime_entry_book_id;
			$status = $this->payments_model->getIncomeChequeStatusDropdownWithSavedOption($incomeCheque[0]->status);
		} else {
			$status = $this->payments_model->getIncomeChequeStatusDropdown();
		}
        
        $receivePaymentId = '';
        if ($receivePayment && sizeof($receivePayment) > 0) {
            $receivePaymentId = $receivePayment[0]->receive_payment_id;
        }

		echo json_encode(array('result' => "ok", 'chequeId' => $chequeId, 'date' => $date, 'chequeNumber' => $chequeNumber, 'bank' => $bank, 
							'chequeDate' => $chequeDate, 'thirdPartyCheque' => $thirdPartyCheque, 'amount' => $amount, 
                            'crossedCheque' => $crossedCheque, 'chequeDepositPrimeEntryBookId' => $chequeDepositPrimeEntryBookId, 
                            'status' => $status, 'salesNoteStatus' => $salesNoteStatus, 'receivePaymentId' => $receivePaymentId));
	}
	
	public function getCashPaymentData() {
        $salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$cashPaymentId = $this->db->escape_str($this->input->post('cash_payment_id'));

        $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteStatus = $salesNote[0]->status;
        
		$cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
        $receivePayment = $this->receive_payment_model->getReceivePaymentMethodRecordForCashPayment($cashPaymentId);

		$date = '';
		$amount = '';
		if ($cashPayment && sizeof($cashPayment) > 0) {
			$date = $cashPayment[0]->date;
			$amount = str_replace(",", "", number_format($cashPayment[0]->amount, 2));
		}
        
        $receivePaymentId = '';
        if ($receivePayment && sizeof($receivePayment) > 0) {
            $receivePaymentId = $receivePayment[0]->receive_payment_id;
        }

		echo json_encode(array('result' => "ok", 'date' => $date, 'amount' => $amount, 'receivePaymentId' => $receivePaymentId,
            'salesNoteStatus' => $salesNoteStatus));
	}
    
    public function getCreditCardPaymentData() {
        $salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
		$creditCardPaymentId = $this->db->escape_str($this->input->post('credit_card_payment_id'));

        $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteStatus = $salesNote[0]->status;
        
		$creditCardPayment = $this->payments_model->getCardPaymentById($creditCardPaymentId);
        $receivePayment = $this->receive_payment_model->getReceivePaymentMethodRecordForCreditCardPayment($creditCardPaymentId);

		$date = '';
        $cardType = '';
		$amount = '';
        $paymentAccountId = '';
		if ($creditCardPayment && sizeof($creditCardPayment) > 0) {
			$date = $creditCardPayment[0]->date;
            $cardType = $creditCardPayment[0]->card_type;
			$amount = str_replace(",", "", number_format($creditCardPayment[0]->amount, 2));
            $paymentAccountId = $creditCardPayment[0]->card_payment_prime_entry_book_id;
		}
        
        $receivePaymentId = '';
        if ($receivePayment && sizeof($receivePayment) > 0) {
            $receivePaymentId = $receivePayment[0]->receive_payment_id;
        }

		echo json_encode(array('result' => "ok", 'date' => $date, 'cardType' => $cardType, 'amount' => $amount, 
                               'paymentAccountId' => $paymentAccountId, 'receivePaymentId' => $receivePaymentId, 
                               'salesNoteStatus' => $salesNoteStatus));
	}
	
	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Sales_Note_Permissions'])) {
			
			$hideMonthFilter = false;
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			$customerId = $this->db->escape_str($this->input->post('customer_id'));
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
							<table class='table table-striped table-bordered salesNoteDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Reference No')}</th>
										<th>{$this->lang->line('Date')}</th>
										<th>{$this->lang->line('Customer')}</th>
										<th>{$this->lang->line('Territory')}</th>
                                        <th>{$this->lang->line('Location')}</th>
										<th>{$this->lang->line('Sales Amount')}</th>
										<th>{$this->lang->line('Discount')}</th>
										<th>{$this->lang->line('Free Issue Amount')}</th>
                                        <th>{$this->lang->line('Balance Amount')}</th>
										<th>{$this->lang->line('Status')}</th>
										<th>{$this->lang->line('Actions')}</th>
									</tr>
								</thead>
								<tbody>";
			
			$salesNotes = $this->sales_note_model->getAllForPeriod($fromDate, $toDate, $customerId, $territoryId, 'date', 'desc');

			if ($salesNotes != null) {
				foreach ($salesNotes as $row) {
					
					$customerName = "";
					$customerId = $row->customer_id;
					$customer = $this->peoples_model->getById($customerId);
					if ($customer && sizeof($customer) > 0) {
						$customerName = $customer[0]->people_name;
					}
					
					$territoryName = "";
					$territoryId = $row->territory_id;
					$territory = $this->territories_model->getById($territoryId);
					if ($territory && sizeof($territory) > 0) {
						$territoryName = $territory[0]->territory_name;
					}
                    
                    $locationName = "";
					$locationId = $row->location_id;
					$location = $this->locations_model->getById($locationId);
					if ($location && sizeof($location) > 0) {
						$locationName = $location[0]->location_name;
					}
					
					$status = "Open";
					$backgroundColorClass = 'default_color';
					if ($row->last_action_status == "cancelled") {
						$status = "Cancelled";
						$backgroundColorClass = "yellow_color";
					} else {
                        if ($row->status == "Claimed") {
                            $status = "Payment Received";
                            $backgroundColorClass = "green_color";
                        }
					}
					
					$html .= "<tr>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $row->reference_no . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $row->date . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $customerName . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $territoryName . "</td>";
                    $html .= "<td  class='" . $backgroundColorClass . "'>" . $locationName . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . number_format($row->sales_amount, 2) . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . number_format($row->discount, 2) . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . number_format($row->free_issue_amount, 2) . "</td>";
                    $html .= "<td  class='" . $backgroundColorClass . "'>" . number_format($row->balance_payment, 2) . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $status . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>
											<div class='text-left'>";
											if(isset($this->data['ACM_Bookkeeping_Edit_Sales_Note_Permissions'])) {
												$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->sales_note_id}' title='{$this->lang->line('Edit')}' onclick='getSalesNoteData({$row->sales_note_id});'>
																						<i class='icon-wrench'></i>
																					</a> ";
											}
                                            if ($row->status != "Claimed") {
                                                if(isset($this->data['ACM_Bookkeeping_Delete_Sales_Note_Permissions'])) {
                                                    $html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->sales_note_id}' title='{$this->lang->line('Delete')}' onclick='del($row->sales_note_id);'>
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
	
	public function getReceiveChequePaymentList() {
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));

        $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteStatus = $salesNote[0]->status;
        
		$receiveChequePaymentMethodIdList = array();
        $salesNoteReceivePaymentAddedFromList = array();
		
        //Get cheque payments added from sales note
		$salesNoteReceivePaymentEntries = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
		
		if ($salesNoteReceivePaymentEntries && sizeof($salesNoteReceivePaymentEntries) > 0) {
			foreach ($salesNoteReceivePaymentEntries as $salesNoteReceivePaymentEntry) {
				if ($salesNoteReceivePaymentEntry->receive_cheque_payment_method_id != '0') {
					$receiveChequePaymentMethodIdList[] = $salesNoteReceivePaymentEntry->receive_cheque_payment_method_id;
                    $salesNoteReceivePaymentAddedFromList[$salesNoteReceivePaymentEntry->receive_cheque_payment_method_id] = $salesNoteReceivePaymentEntry->added_from;
				}
			}
		}
		
        $receiveChequePaymentMethodList = array();
        if ($receiveChequePaymentMethodIdList && sizeof($receiveChequePaymentMethodIdList) > 0) {
            foreach($receiveChequePaymentMethodIdList as $receiveChequePaymentMethodId) {
                $result = $this->receive_payment_model->getReceivePaymentMethodById($receiveChequePaymentMethodId);
                
                if ($result != false) {
                    $receiveChequePaymentMethodList[] = $result;
                }
            }
        }
        
        $chequePaymentList = array();
        $receivePaymentAddedFromList = array();
        if ($receiveChequePaymentMethodList && sizeof($receiveChequePaymentMethodList) > 0) {
            foreach($receiveChequePaymentMethodList as $receiveChequePaymentMethod) {
                $chequePaymentList[$receiveChequePaymentMethod[0]->receive_payment_method_id] = $this->payments_model->getIncomeChequeById($receiveChequePaymentMethod[0]->cheque_id);
                
                foreach($salesNoteReceivePaymentAddedFromList as $key => $salesNoteReceivePaymentAddedFrom) {
                    if ($key == $receiveChequePaymentMethod[0]->receive_payment_method_id) {
                        $receivePaymentAddedFromList[$receiveChequePaymentMethod[0]->cheque_id] = $salesNoteReceivePaymentAddedFrom;
                    }
                }
            }
        }

		$html = "";
		$html .= "  <div class='box-content box-no-padding out-table'>
						<div class='table-responsive table_data'>
							<div class='scrollable-area1'>
								<table class='table table-striped table-bordered chequePaymentTable' style='margin-bottom:0;'>
									<thead>
										<tr>
											<th>{$this->lang->line('Date')}</th>
											<th>{$this->lang->line('Cheque Number')}</th>
											<th>{$this->lang->line('Bank')}</th>
											<th>{$this->lang->line('Cheque Date')}</th>
											<th>{$this->lang->line('Amount')}</th>
											<th>{$this->lang->line('Status')}</th>
											<th>{$this->lang->line('Actions')}</th>
										</tr>
									</thead>
									<tbody>";

		if ($chequePaymentList && sizeof($chequePaymentList) > 0) {
			foreach ($chequePaymentList as $key => $chequePayment) {
				
                $bankId = $chequePayment[0]->bank;
                $bank = $this->bank_model->getById($bankId);
                
                $bankName = '';
                if ($bank && sizeof($bank) > 0) {
                    $bankName = $bank[0]->bank_name;
                }
                
				if ($chequePayment[0]->status == "In_Hand") {
					$chequeStatus = "In Hand";
				} else {
					$chequeStatus = $chequePayment[0]->status;
				}
				
				 $html .= "             <tr>";
						$html .= "          <td>" . $chequePayment[0]->date . "</td>";
						$html .= "          <td>" . $chequePayment[0]->cheque_number . "</td>";
						$html .= "          <td>" . $bankName . "</td>";
						$html .= "          <td>" . $chequePayment[0]->cheque_date . "</td>";
						$html .= "          <td>" . number_format($chequePayment[0]->amount, 2) . "</td>";
						$html .= "          <td>" . $chequeStatus . "</td>";
						$html .= "          <td>
												<div class='text-left'>";
                        
                        if ($receivePaymentAddedFromList[$chequePayment[0]->cheque_id] == "Sales Note") {
                            if(isset($this->data['STM_Sales_Edit_Sales_Invoice_Permissions'])) {
                                $html.="            <a class='btn btn-warning btn-xs get' data-id='{$chequePayment[0]->cheque_id}'
                                                        title='{$this->lang->line('Edit')}' onclick='getReceiveChequePaymentData({$chequePayment[0]->cheque_id});'>
                                                        <i class='icon-wrench'></i>
                                                    </a>";
                            }

                            if ($salesNoteStatus != "Claimed") {
                                if(isset($this->data['STM_Sales_Delete_Sales_Invoice_Permissions'])) {
                                    $html.="            <a class='btn btn-danger btn-xs delete' data-id='{$key}'
                                                            title='{$this->lang->line('Delete')}' onclick='deleteReceiveChequePayment({$key});'>
                                                            <i class='icon-remove'></i>
                                                        </a>";
                                }
                            }
                        }

							$html.="            </div>
										   </td>";
						$html .= "      </tr>";
			}
		}

		$html .= "                  </tbody>
								</table>
							</div>
						</div>
					</div>";

		echo $html;
	}
	
	public function getReceiveCashPaymentList() {
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));

        $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteStatus = $salesNote[0]->status;
        
		$receiveCashPaymentMethodIdList = array();
        $salesNoteReceivePaymentAddedFromList = array();
		
        //Get cash payments added from sales note
		$salesNoteReceivePaymentEntries = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
		
		if ($salesNoteReceivePaymentEntries && sizeof($salesNoteReceivePaymentEntries) > 0) {
			foreach ($salesNoteReceivePaymentEntries as $salesNoteReceivePaymentEntry) {
				if ($salesNoteReceivePaymentEntry->receive_cash_payment_method_id != '0') {
					$receiveCashPaymentMethodIdList[] = $salesNoteReceivePaymentEntry->receive_cash_payment_method_id;
                    $salesNoteReceivePaymentAddedFromList[$salesNoteReceivePaymentEntry->receive_cash_payment_method_id] = $salesNoteReceivePaymentEntry->added_from;
				}
			}
		}
		
        $receiveCashPaymentList = array();
        if ($receiveCashPaymentMethodIdList && sizeof($receiveCashPaymentMethodIdList) > 0) {
            foreach($receiveCashPaymentMethodIdList as $receiveCashPaymentMethodId) {
                $result = $this->receive_payment_model->getReceivePaymentMethodById($receiveCashPaymentMethodId);
                
                if ($result != false) {
                    $receiveCashPaymentList[] = $result;
                }
            }
        }
        
        $cashPaymentList = array();
        $receivePaymentAddedFromList = array();
        if ($receiveCashPaymentList && sizeof($receiveCashPaymentList) > 0) {
            foreach($receiveCashPaymentList as $receiveCashPayment) {
                $cashPaymentList[] = $this->payments_model->getCashPaymentById($receiveCashPayment[0]->cash_payment_id);
                
                foreach($salesNoteReceivePaymentAddedFromList as $key => $salesNoteReceivePaymentAddedFrom) {
                    if ($key == $receiveCashPayment[0]->receive_payment_method_id) {
                        $receivePaymentAddedFromList[$receiveCashPayment[0]->cash_payment_id] = $salesNoteReceivePaymentAddedFrom;
                    }
                }
            }
        }
        
		$html = "";
		$html .= "  <div class='box-content box-no-padding out-table'>
						<div class='table-responsive table_data'>
							<div class='scrollable-area1'>
								<table class='table table-striped table-bordered cashPaymentTable' style='margin-bottom:0;'>
									<thead>
										<tr>
											<th>{$this->lang->line('Date')}</th>
											<th>{$this->lang->line('Amount')}</th>
											<th>{$this->lang->line('Actions')}</th>
										</tr>
									</thead>
									<tbody>";

		if ($cashPaymentList && sizeof($cashPaymentList) > 0) {
			foreach ($cashPaymentList as $cashPayment) {
				 $html .= "             <tr>";
						$html .= "          <td>" . $cashPayment[0]->date . "</td>";
						$html .= "          <td>" . number_format($cashPayment[0]->amount, 2) . "</td>";
						$html .= "          <td>
												<div class='text-left'>";
                        
                        if ($receivePaymentAddedFromList[$cashPayment[0]->cash_payment_id] == "Sales Note") {
                            if(isset($this->data['STM_Sales_Edit_Sales_Invoice_Permissions'])) {
                                $html.="            <a class='btn btn-warning btn-xs get' data-id='{$cashPayment[0]->cash_payment_id}'
                                                        title='{$this->lang->line('Edit')}' onclick='getCashPaymentData({$cashPayment[0]->cash_payment_id});'>
                                                        <i class='icon-wrench'></i>
                                                    </a>";
                            }

                            if ($salesNoteStatus != "Claimed") {
                                if(isset($this->data['STM_Sales_Delete_Sales_Invoice_Permissions'])) {
                                    $html.="            <a class='btn btn-danger btn-xs delete' data-id='{$cashPayment[0]->cash_payment_id}'
                                                            title='{$this->lang->line('Delete')}' onclick='deleteCashPayment({$cashPayment[0]->cash_payment_id});'>
                                                            <i class='icon-remove'></i>
                                                        </a>";
                                }
                            }
                        }
                        
							$html.="            </div>
										   </td>";
						$html .= "      </tr>";
			}
		}
        
		$html .= "                  </tbody>
								</table>
							</div>
						</div>
					</div>";

		echo $html;
	}
    
    public function getReceiveCreditCardPaymentList() {
        
		$salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));

        $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);
        $salesNoteStatus = $salesNote[0]->status;
        
		$receiveCreditCardPaymentMethodIdList = array();
        $salesNoteReceivePaymentAddedFromList = array();
		
        //Get cash payments added from sales note
		$salesNoteReceivePaymentEntries = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
		
		if ($salesNoteReceivePaymentEntries && sizeof($salesNoteReceivePaymentEntries) > 0) {
			foreach ($salesNoteReceivePaymentEntries as $salesNoteReceivePaymentEntry) {
				if ($salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id != '0') {
					$receiveCreditCardPaymentMethodIdList[] = $salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id;
                    $salesNoteReceivePaymentAddedFromList[$salesNoteReceivePaymentEntry->receive_credit_card_payment_method_id] = $salesNoteReceivePaymentEntry->added_from;
				}
			}
		}
		
        $receiveCreditCardPaymentList = array();
        if ($receiveCreditCardPaymentMethodIdList && sizeof($receiveCreditCardPaymentMethodIdList) > 0) {
            foreach($receiveCreditCardPaymentMethodIdList as $receiveCreditCardPaymentMethodId) {
                $result = $this->receive_payment_model->getReceivePaymentMethodById($receiveCreditCardPaymentMethodId);
                
                if ($result != false) {
                    $receiveCreditCardPaymentList[] = $result;
                }
            }
        }
        
        $creditCardPaymentList = array();
        $receivePaymentAddedFromList = array();
        if ($receiveCreditCardPaymentList && sizeof($receiveCreditCardPaymentList) > 0) {
            foreach($receiveCreditCardPaymentList as $receiveCreditCardPayment) {
                $creditCardPaymentList[] = $this->payments_model->getCardPaymentById($receiveCreditCardPayment[0]->credit_card_payment_id);
                
                foreach($salesNoteReceivePaymentAddedFromList as $key => $salesNoteReceivePaymentAddedFrom) {
                    if ($key == $receiveCreditCardPayment[0]->receive_payment_method_id) {
                        $receivePaymentAddedFromList[$receiveCreditCardPayment[0]->credit_card_payment_id] = $salesNoteReceivePaymentAddedFrom;
                    }
                }
            }
        }
        
		$html = "";
		$html .= "  <div class='box-content box-no-padding out-table'>
						<div class='table-responsive table_data'>
							<div class='scrollable-area1'>
								<table class='table table-striped table-bordered creditCardPaymentTable' style='margin-bottom:0;'>
									<thead>
										<tr>
											<th>{$this->lang->line('Date')}</th>
                                            <th>{$this->lang->line('Card Type')}</th>
											<th>{$this->lang->line('Amount')}</th>
											<th>{$this->lang->line('Actions')}</th>
										</tr>
									</thead>
									<tbody>";

		if ($creditCardPaymentList && sizeof($creditCardPaymentList) > 0) {
			foreach ($creditCardPaymentList as $creditCardPayment) {
				 $html .= "             <tr>";
						$html .= "          <td>" . $creditCardPayment[0]->date . "</td>";
                        $html .= "          <td>" . $creditCardPayment[0]->card_type . "</td>";
						$html .= "          <td>" . number_format($creditCardPayment[0]->amount, 2) . "</td>";
						$html .= "          <td>
												<div class='text-left'>";
                        
                        if ($receivePaymentAddedFromList[$creditCardPayment[0]->credit_card_payment_id] == "Sales Note") {
                            if(isset($this->data['STM_Sales_Edit_Sales_Invoice_Permissions'])) {
                                $html.="            <a class='btn btn-warning btn-xs get' data-id='{$creditCardPayment[0]->credit_card_payment_id}'
                                                        title='{$this->lang->line('Edit')}' onclick='getCreditCardPaymentData({$creditCardPayment[0]->credit_card_payment_id});'>
                                                        <i class='icon-wrench'></i>
                                                    </a>";
                            }

                            if ($salesNoteStatus != "Claimed") {
                                if(isset($this->data['STM_Sales_Delete_Sales_Invoice_Permissions'])) {
                                    $html.="            <a class='btn btn-danger btn-xs delete' data-id='{$creditCardPayment[0]->credit_card_payment_id}'
                                                            title='{$this->lang->line('Delete')}' onclick='deleteCreditCardPayment({$creditCardPayment[0]->credit_card_payment_id});'>
                                                            <i class='icon-remove'></i>
                                                        </a>";
                                }
                            }
                        }
                        
							$html.="            </div>
										   </td>";
						$html .= "      </tr>";
			}
		}
        
		$html .= "                  </tbody>
								</table>
							</div>
						</div>
					</div>";

		echo $html;
	}
    
    public function getAllSalesNotesToDropDown() {
        $options = $this->sales_note_model->getAllSalesNotesAsOptionList();
        
        $html  = "  <select class='form-control' id='sales_note_id' onchange='handleSalesNoteSelect(this.id)'>
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
		$result = $this->sales_note_model->checkExistingSalesNote($reference_no);
		$salesNoteId = $this->db->escape_str($this->input->post('id'));

		if ($salesNoteId != '' && $result) {
			if ($salesNoteId !=  $result[0]->sales_note_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Sales Note') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	public function getLastSalesNoteNumber() {
		$refNo = $this->sales_note_model->getMaxSalesNoteNo();
		$lastSalesNote = $this->sales_note_model->getSalesNoteByIdConsideringDeletedSalesNote($refNo[0]->sales_note_id);
		//echo "<pre>";print_r($lastSalesNote);die;
		if ($lastSalesNote && sizeof($lastSalesNote) > 0) {
			return $lastSalesNote[0]->reference_no;
		} else {
			return "Nill";
		}
	}

	public function isSalesNoteNumberAutoIncrementEnabled() {
		return $this->system_configurations_model->isBookkeepingSalesNoteNumberAutoIncrementEnabled();
	}

	public function getNextReferenceNo() {
		if ($this->isSalesNoteNumberAutoIncrementEnabled()) {
			$lastSalesNoteNo = $this->getLastSalesNoteNumber();
			$salesNoteReferenceNoCodeData = $this->system_configurations_model->getBookkeepingSalesNoteReferenceNoCode();
			$salesNoteReferenceNoCode = $salesNoteReferenceNoCodeData[0]->config_filed_value;
			$salesNoteReferenceNoSeparatorData = $this->system_configurations_model->getBookkeepingSalesNoteReferenceNoSeparator();
			$salesNoteReferenceNoSeparator = $salesNoteReferenceNoSeparatorData[0]->config_filed_value;
			$salesNoteReferenceNoStartNumberData = $this->system_configurations_model->getBookkeepingSalesNoteReferenceNoStartNumber();
			$salesNoteReferenceNoStartNumber = $salesNoteReferenceNoStartNumberData[0]->config_filed_value;

			if ($lastSalesNoteNo != 'Nill') {
				if ($salesNoteReferenceNoSeparator != '') {
					$lastSalesNoteNoElements = explode($salesNoteReferenceNoSeparator, $lastSalesNoteNo);
					$salesNoteNo = $lastSalesNoteNoElements[1];
					$result = $salesNoteReferenceNoCode . $salesNoteReferenceNoSeparator . ($salesNoteNo + 1);
				} else {
					$salesNoteReferenceNoCodeLength = strlen($salesNoteReferenceNoCode);
					$salesNoteNo = substr($lastSalesNoteNo, $salesNoteReferenceNoCodeLength);
					$result = $salesNoteReferenceNoCode . $salesNoteReferenceNoSeparator . ($salesNoteNo + 1);
				}
			} else {
				$result = $salesNoteReferenceNoCode . $salesNoteReferenceNoSeparator . $salesNoteReferenceNoStartNumber;
			}

			$status = "auto_increment";
		} else {
			$lastSalesNoteNo = $this->getLastSalesNoteNumber();
			$result = "<label class='control-label col-sm-3' id='last_reference_no_label' style='text-align:left; color: #2eb82e;'>"
					. "{$this->lang->line('Last Reference Number : ')}" . $lastSalesNoteNo . "</label>";
			$status = "manual_increment";
		}

		echo json_encode(array('status' => $status, 'result' => $result));
	}

	public function getPrimeEntryBooksToUpdateForSalesNoteSalesEntryTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForSalesNoteCostEntryTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getSalesNoteCostEntryAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForSalesNoteDiscountTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getSalesNoteDiscountAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForSalesNoteFreeIssuesTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getSalesNoteFreeIssuesAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
    
	public function postSalesNoteJournalEntries($primeEntryBooksToUpdate, $transactionId, $journalEntries, $transactionTypeId, $date, 
            $referenceNo, $locationId, $payeePayerId, $amount, $oldAmount, $shouldHaveAPaymentJournalEntry, $specialChartOfAccountId=null, 
            $specialChartOfAccountAmount=null, $specialChartOfAccountOldAmount=null, $updateJournalEntry=null, $referenceJournalEntryId=null) {
		
		$journalEntryId = '';
		
		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
			if (!$journalEntries) {
				//Add journal entry records
				
				if ($transactionTypeId == '1') {
					$description = $this->lang->line('Journal entry for sales note sales entry for Sales Note number : ') . $referenceNo;
				} else if ($transactionTypeId == '2') {
					$description = $this->lang->line('Journal entry for sales note cost entry for Sales Note  number : ') . $referenceNo;
				} else if ($transactionTypeId == '3') {
					$description = $this->lang->line('Journal entry for sales note discount for Sales Note number : ') . $referenceNo;
				} else if ($transactionTypeId == '4') {
					$description = $this->lang->line('Journal entry for sales note free issue for Sales Note number : ') . $referenceNo;
                    $referenceNo = '';
				}
                
                if ($referenceJournalEntryId == '') {
                    $referenceJournalEntryId = 0;
                }

                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                    $primeEntryBookId = $primeEntryBook->config_filed_value;
                    $data = array(
                        'prime_entry_book_id' => $primeEntryBookId,
                        'transaction_date' => $date,
                        'reference_no' => $referenceNo,
                        'should_have_a_payment_journal_entry' => $shouldHaveAPaymentJournalEntry,
                        'location_id' => $locationId,
                        'payee_payer_type' => "Customer",
                        'payee_payer_id' => $payeePayerId,
                        'reference_journal_entry_id' => $referenceJournalEntryId,
                        'description' => $description,
                        'post_type' => "Indirect",
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                    $data = array(
                        'sales_note_id' => $transactionId,
                        'prime_entry_book_id' => $primeEntryBookId,
                        'journal_entry_id' => $journalEntryId,
                        'transaction_type_id' => $transactionTypeId,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $this->sales_note_model->addSalesNoteJournalEntry($data);

                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                    $amount = str_replace(',', '', $amount);

                    $specialAccountIsADebitAccount = false;
                    $specialAccountIsACreditAccount = false;
                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
                        if ($chartOfAccount->debit_or_credit == "debit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $specialAccountIsADebitAccount = true;
                            }
                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $specialAccountIsACreditAccount = true;
                            }
                        }
                    }

                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
                        if ($chartOfAccount->debit_or_credit == "debit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $specialChartOfAccountId,
                                    'debit_value' => $specialChartOfAccountAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            } else {

                                if ($specialAccountIsADebitAccount) {
                                    $debitValue = $amount - $specialChartOfAccountAmount;
                                } else {
                                    $debitValue = $amount;
                                }

                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                    'debit_value' => $debitValue,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            }
                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $specialChartOfAccountId,
                                    'credit_value' => $specialChartOfAccountAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            } else {

                                if ($specialAccountIsACreditAccount) {
                                    $creditValue = $amount - $specialChartOfAccountAmount;
                                } else {
                                    $creditValue = $amount;
                                }

                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                    'credit_value' => $creditValue,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            }
                        }

                        $this->journal_entries_model->addGeneralLedgerTransaction($data);

                        //Same time add the data to previous years record table.
                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                    }
                }
			} else if ($journalEntries && sizeof($journalEntries) > 0) {
				//Get general ledger transactions to update new amount
				foreach($journalEntries as $salesNoteJournalEntry) {
					$primeEntryBookId = $salesNoteJournalEntry->prime_entry_book_id;
					$journalEntryId = $salesNoteJournalEntry->journal_entry_id;
                    
                    if ($updateJournalEntry) {
                        
                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                        
                        $journalEntryHistoryData = array(
                            'journal_entry_id' => $journalEntry[0]->journal_entry_id,
							'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
							'location_id' => $journalEntry[0]->location_id,
							'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                            'delivery_route_id' => $journalEntry[0]->delivery_route_id,
							'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                            'due_date' => $journalEntry[0]->due_date,
                            'transaction_date' => $journalEntry[0]->transaction_date,
                            'reference_no' => $journalEntry[0]->reference_no,
                            'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                            'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                            'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                            'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
							'description' => $journalEntry[0]->description,
							'post_type' => $journalEntry[0]->post_type,
							'actioned_user_id' => $journalEntry[0]->actioned_user_id,
							'action_date' => $journalEntry[0]->action_date,
							'last_action_status' => $journalEntry[0]->last_action_status
						);
                        
                        $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);
                        
                        $data = array(
							'transaction_date' => $date,
							'location_id' => $locationId,
							'payee_payer_id' => $payeePayerId,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'edited'
						);

						$this->journal_entries_model->editJournalEntry($journalEntryId, $data);
                    }

					$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
					$generalLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($journalEntryId, $primeEntryBookId);
					$amount = str_replace(',', '', $amount);

					$specialAccountIsADebitAccount = false;
					$specialAccountIsACreditAccount = false;
					foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
						if ($primeEntryBookChartOfAccount->debit_or_credit == "debit") {
							if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
								$specialAccountIsADebitAccount = true;
							}
						} else if ($primeEntryBookChartOfAccount->debit_or_credit == "credit") {
							if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
								$specialAccountIsACreditAccount = true;
							}
						}
					}
					
					foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
						foreach($generalLedgerTransactions as $generalLedgerTransaction) {
							if ($generalLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
								if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
									$data = array(
										'debit_value' => ($generalLedgerTransaction->debit_value - $specialChartOfAccountOldAmount) + $specialChartOfAccountAmount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);
								} else {
									
									if ($specialAccountIsADebitAccount) {
										$debitValue = ($generalLedgerTransaction->debit_value - ($oldAmount - $specialChartOfAccountOldAmount)) + ($amount - $specialChartOfAccountAmount);
									} else {
										$debitValue = ($generalLedgerTransaction->debit_value - $oldAmount) + $amount;
									}
									
									$data = array(
										'debit_value' => $debitValue,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);
								}
								
								$this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);

								//Same time edit the data in previous years record table.
								$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);
							} else if ($generalLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
								if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
									$data = array(
										'credit_value' => ($generalLedgerTransaction->credit_value - $specialChartOfAccountOldAmount) + $specialChartOfAccountAmount,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);
								} else {
									
									if ($specialAccountIsACreditAccount) {
										$creditValue = ($generalLedgerTransaction->credit_value - ($oldAmount - $specialChartOfAccountOldAmount)) + ($amount - $specialChartOfAccountAmount);
									} else {
										$creditValue = ($generalLedgerTransaction->credit_value - $oldAmount) + $amount;
									}
									
									$data = array(
										'credit_value' => $creditValue,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'edited'
									);
								}
								
								$this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);

								//Same time edit the data in previous years record table.
								$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);
							}
						}
					}
				}
			}
		}
		
		return $journalEntryId;
	}
    
    public function postCustomerReturnNoteJournalEntries($primeEntryBooksToUpdate, $customerReturnNoteId, $journalEntries, 
            $transactionTypeId, $date, $referenceNo, $locationId, $payeePayerId, $amount, $oldAmount, $description, 
            $specialChartOfAccountId=null, $specialChartOfAccountAmount=null, $specialChartOfAccountOldAmount=null, $updateJournalEntry=null) {
        
        $journalEntryId = '';
        
		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
			if (!$journalEntries) {
				//Add journal entry records

                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                    $primeEntryBookId = $primeEntryBook->config_filed_value;
                    $data = array(
                        'prime_entry_book_id' => $primeEntryBookId,
                        'transaction_date' => $date,
                        'reference_no' => $referenceNo,
                        'should_have_a_payment_journal_entry' => "Yes",
                        'location_id' => $locationId,
                        'payee_payer_type' => "Customer",
                        'payee_payer_id' => $payeePayerId,
                        'description' => $description,
                        'post_type' => "Indirect",
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                    $data = array(
                        'customer_return_note_id' => $customerReturnNoteId,
                        'prime_entry_book_id' => $primeEntryBookId,
                        'journal_entry_id' => $journalEntryId,
                        'transaction_type_id' => $transactionTypeId,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $this->customer_return_note_model->addCustomerReturnNoteJournalEntry($data);

                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                    $amount = str_replace(',', '', $amount);

                    $specialAccountIsADebitAccount = false;
                    $specialAccountIsACreditAccount = false;
                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
                        if ($chartOfAccount->debit_or_credit == "debit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $specialAccountIsADebitAccount = true;
                            }
                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $specialAccountIsACreditAccount = true;
                            }
                        }
                    }

                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
                        if ($chartOfAccount->debit_or_credit == "debit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $specialChartOfAccountId,
                                    'debit_value' => $specialChartOfAccountAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            } else {

                                if ($specialAccountIsADebitAccount) {
                                    $debitValue = $amount - $specialChartOfAccountAmount;
                                } else {
                                    $debitValue = $amount;
                                }

                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                    'debit_value' => $debitValue,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            }
                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                            if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $chartOfAccount->chart_of_account_id) {
                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $specialChartOfAccountId,
                                    'credit_value' => $specialChartOfAccountAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            } else {

                                if ($specialAccountIsACreditAccount) {
                                    $creditValue = $amount - $specialChartOfAccountAmount;
                                } else {
                                    $creditValue = $amount;
                                }

                                $data = array(
                                    'journal_entry_id' => $journalEntryId,
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'transaction_date' => $date,
                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                    'credit_value' => $creditValue,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );
                            }
                        }

                        $this->journal_entries_model->addGeneralLedgerTransaction($data);

                        //Same time add the data to previous years record table.
                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                    }
                }
			} else if ($journalEntries && sizeof($journalEntries) > 0) {
				//Get general ledger transactions to update new amount
				foreach($journalEntries as $journalEntry) {
					$salesNotePrimeEntryBookId = $journalEntry->prime_entry_book_id;
					$journalEntryId = $journalEntry->journal_entry_id;
					
                    if ($updateJournalEntry) {
                        
                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                        
                        $journalEntryHistoryData = array(
                            'journal_entry_id' => $journalEntry[0]->journal_entry_id,
							'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
							'location_id' => $journalEntry[0]->location_id,
							'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                            'delivery_route_id' => $journalEntry[0]->delivery_route_id,
							'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                            'due_date' => $journalEntry[0]->due_date,
                            'transaction_date' => $journalEntry[0]->transaction_date,
                            'reference_no' => $journalEntry[0]->reference_no,
                            'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                            'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                            'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                            'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
							'description' => $journalEntry[0]->description,
							'post_type' => $journalEntry[0]->post_type,
							'actioned_user_id' => $journalEntry[0]->actioned_user_id,
							'action_date' => $journalEntry[0]->action_date,
							'last_action_status' => $journalEntry[0]->last_action_status
						);
                        
                        $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);
                        
                        $data = array(
							'transaction_date' => $date,
							'location_id' => $locationId,
							'payee_payer_id' => $payeePayerId,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'edited'
						);

						$this->journal_entries_model->editJournalEntry($journalEntryId, $data);
                    } else {
					
                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($salesNotePrimeEntryBookId);
                        $customerReturnNoteGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($journalEntryId, $salesNotePrimeEntryBookId);
                        $amount = str_replace(',', '', $amount);

                        $specialAccountIsADebitAccount = false;
                        $specialAccountIsACreditAccount = false;
                        foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
                            if ($primeEntryBookChartOfAccount->debit_or_credit == "debit") {
                                if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
                                    $specialAccountIsADebitAccount = true;
                                }
                            } else if ($primeEntryBookChartOfAccount->debit_or_credit == "credit") {
                                if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
                                    $specialAccountIsACreditAccount = true;
                                }
                            }
                        }

                        foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
                            foreach($customerReturnNoteGeneralLedgerTransactions as $customerReturnNoteGeneralLedgerTransaction) {
                                if ($customerReturnNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {
                                    if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
                                        $data = array(
                                            'debit_value' => ($customerReturnNoteGeneralLedgerTransaction->debit_value - $specialChartOfAccountOldAmount) + $specialChartOfAccountAmount,
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );
                                    } else {

                                        if ($specialAccountIsADebitAccount) {
                                            $debitValue = ($customerReturnNoteGeneralLedgerTransaction->debit_value - ($oldAmount - $specialChartOfAccountOldAmount)) + ($amount - $specialChartOfAccountAmount);
                                        } else {
                                            $debitValue = ($customerReturnNoteGeneralLedgerTransaction->debit_value - $oldAmount) + $amount;
                                        }

                                        $data = array(
                                            'debit_value' => $debitValue,
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );
                                    }

                                    $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $customerReturnNoteGeneralLedgerTransaction->chart_of_account_id, $data);

                                    //Same time edit the data in previous years record table.
                                    $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $customerReturnNoteGeneralLedgerTransaction->chart_of_account_id, $data);
                                } else if ($customerReturnNoteGeneralLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {
                                    if ($specialChartOfAccountId != '' && $specialChartOfAccountId == $primeEntryBookChartOfAccount->chart_of_account_id) {
                                        $data = array(
                                            'credit_value' => ($customerReturnNoteGeneralLedgerTransaction->credit_value - $specialChartOfAccountOldAmount) + $specialChartOfAccountAmount,
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );
                                    } else {

                                        if ($specialAccountIsACreditAccount) {
                                            $creditValue = ($customerReturnNoteGeneralLedgerTransaction->credit_value - ($oldAmount - $specialChartOfAccountOldAmount)) + ($amount - $specialChartOfAccountAmount);
                                        } else {
                                            $creditValue = ($customerReturnNoteGeneralLedgerTransaction->credit_value - $oldAmount) + $amount;
                                        }

                                        $data = array(
                                            'credit_value' => $creditValue,
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );
                                    }

                                    $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $customerReturnNoteGeneralLedgerTransaction->chart_of_account_id, $data);

                                    //Same time edit the data in previous years record table.
                                    $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $customerReturnNoteGeneralLedgerTransaction->chart_of_account_id, $data);
                                }
                            }
                        }
                    }
				}
			}
		}
        
        return $journalEntryId;
	}
    
    public function postReferenceJournalEntries($primeEntryBooksToUpdate, $journalEntries, $date, $referenceNo, $referenceTransactionTypeId, 
            $referenceTransactionEntryId, $referenceJournalEntryId, $claimReferenceNo, $locationId, $payeePayerId, $amount, $updateJournalEntry=null) {
		
		$journalEntryId = '';
		
		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
			if (!$journalEntries) {
				//Add journal entry records
				
				$description = $this->lang->line('Journal entry for sales note claim transaction for Sales Note number : ') . $referenceNo . $this->lang->line(' [Claim : ') . $claimReferenceNo . ']';
				
                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                    $primeEntryBookId = $primeEntryBook->config_filed_value;
                    $data = array(
                        'prime_entry_book_id' => $primeEntryBookId,
                        'transaction_date' => $date,
                        'reference_no' => $referenceNo,
                        'location_id' => $locationId,
                        'payee_payer_type' => "Customer",
                        'payee_payer_id' => $payeePayerId,
                        'reference_transaction_type_id' => $referenceTransactionTypeId,
                        'reference_transaction_id' => $referenceTransactionEntryId,
                        'reference_journal_entry_id' => $referenceJournalEntryId,
                        'description' => $description,
                        'post_type' => "Indirect",
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

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
			} else if ($journalEntries && sizeof($journalEntries) > 0) {
				//Get general ledger transactions to update new amount
				foreach($journalEntries as $salesNoteJournalEntry) {
					$primeEntryBookId = $salesNoteJournalEntry[0]->prime_entry_book_id;
					$journalEntryId = $salesNoteJournalEntry[0]->journal_entry_id;
                    
                    if ($updateJournalEntry) {
                        
                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                        
                        $journalEntryHistoryData = array(
                            'journal_entry_id' => $journalEntry[0]->journal_entry_id,
							'prime_entry_book_id' => $journalEntry[0]->prime_entry_book_id,
							'location_id' => $journalEntry[0]->location_id,
							'payee_payer_type' => $journalEntry[0]->payee_payer_type,
                            'delivery_route_id' => $journalEntry[0]->delivery_route_id,
							'payee_payer_id' => $journalEntry[0]->payee_payer_id,
                            'due_date' => $journalEntry[0]->due_date,
                            'transaction_date' => $journalEntry[0]->transaction_date,
                            'reference_no' => $journalEntry[0]->reference_no,
                            'should_have_a_payment_journal_entry' => $journalEntry[0]->should_have_a_payment_journal_entry,
                            'reference_transaction_type_id' => $journalEntry[0]->reference_transaction_type_id,
                            'reference_transaction_id' => $journalEntry[0]->reference_transaction_id,
                            'reference_journal_entry_id' => $journalEntry[0]->reference_journal_entry_id,
							'description' => $journalEntry[0]->description,
							'post_type' => $journalEntry[0]->post_type,
							'actioned_user_id' => $journalEntry[0]->actioned_user_id,
							'action_date' => $journalEntry[0]->action_date,
							'last_action_status' => $journalEntry[0]->last_action_status
						);
                        
                        $this->journal_entries_model->addJournalEntryToHistory($journalEntryHistoryData);
                        
                        $data = array(
							'transaction_date' => $date,
							'location_id' => $locationId,
							'payee_payer_id' => $payeePayerId,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'edited'
						);

						$this->journal_entries_model->editJournalEntry($journalEntryId, $data);
                    } else {
                        
                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                        $generalLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($journalEntryId, $primeEntryBookId);
                        $amount = str_replace(',', '', $amount);

                        foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
                            foreach($generalLedgerTransactions as $generalLedgerTransaction) {
                                if ($generalLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {

                                    $data = array(
                                        'debit_value' => $amount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);

                                    //Same time edit the data in previous years record table.
                                    $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);
                                } else if ($generalLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {

                                    $data = array(
                                        'credit_value' => $amount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);

                                    //Same time edit the data in previous years record table.
                                    $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);
                                }
                            }
                        }
                    }
				}
			}
		}
		
		return $journalEntryId;
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
	
	public function getLastCustomerReturnNoteNumber() {
		$refNo = $this->customer_return_note_model->getMaxCustomerReturnNoteNo();
		$lastCustomerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteByIdConsideringDeletedCustomerReturnNote($refNo[0]->customer_return_note_id);
		//echo "<pre>";print_r($lastCustomerReturnNote);die;
		if ($lastCustomerReturnNote && sizeof($lastCustomerReturnNote) > 0) {
			return $lastCustomerReturnNote[0]->reference_no;
		} else {
			return "Nill";
		}
	}
	
	public function isCustomerReturnNoteNumberAutoIncrementEnabled() {
		return $this->system_configurations_model->isBookkeepingCustomerReturnNoteNumberAutoIncrementEnabled();
	}

	public function getNextCustomerReturnReferenceNo() {
		if ($this->isCustomerReturnNoteNumberAutoIncrementEnabled()) {
			$lastCustomerReturnNoteNo = $this->getLastCustomerReturnNoteNumber();
			$customerReturnNoteReferenceNoCodeData = $this->system_configurations_model->getBookkeepingCustomerReturnNoteReferenceNoCode();
			$customerReturnNoteReferenceNoCode = $customerReturnNoteReferenceNoCodeData[0]->config_filed_value;
			$customerReturnNoteReferenceNoSeparatorData = $this->system_configurations_model->getBookkeepingCustomerReturnNoteReferenceNoSeparator();
			$customerReturnNoteReferenceNoSeparator = $customerReturnNoteReferenceNoSeparatorData[0]->config_filed_value;
			$customerReturnNoteReferenceNoStartNumberData = $this->system_configurations_model->getBookkeepingCustomerReturnNoteReferenceNoStartNumber();
			$customerReturnNoteReferenceNoStartNumber = $customerReturnNoteReferenceNoStartNumberData[0]->config_filed_value;

			if ($lastCustomerReturnNoteNo != 'Nill') {
				if ($customerReturnNoteReferenceNoSeparator != '') {
					$lastCustomerReturnNoteNoElements = explode($customerReturnNoteReferenceNoSeparator, $lastCustomerReturnNoteNo);
					$customerReturnNoteNo = $lastCustomerReturnNoteNoElements[1];
					$result = $customerReturnNoteReferenceNoCode . $customerReturnNoteReferenceNoSeparator . ($customerReturnNoteNo + 1);
				} else {
					$customerReturnNoteReferenceNoCodeLength = strlen($customerReturnNoteReferenceNoCode);
					$customerReturnNoteNo = substr($lastCustomerReturnNoteNo, $customerReturnNoteReferenceNoCodeLength);
					$result = $customerReturnNoteReferenceNoCode . $customerReturnNoteReferenceNoSeparator . ($customerReturnNoteNo + 1);
				}
			} else {
				$result = $customerReturnNoteReferenceNoCode . $customerReturnNoteReferenceNoSeparator . $customerReturnNoteReferenceNoStartNumber;
			}
		} else {
			$result = "";
		}

		return $result;
	}
	
	public function getLastReceivePaymentNumber() {
		$refNo = $this->receive_payment_model->getMaxReceivePaymentNo();
		$lastReceivePayment = $this->receive_payment_model->getReceivePaymentByIdConsideringDeletedReceivePayment($refNo[0]->receive_payment_id);
		//echo "<pre>";print_r($lastReceivePayment);die;
		if ($lastReceivePayment && sizeof($lastReceivePayment) > 0) {
			return $lastReceivePayment[0]->reference_no;
		} else {
			return "Nill";
		}
	}

	public function isReceivePaymentNumberAutoIncrementEnabled() {
		return $this->system_configurations_model->isBookkeepingReceivePaymentNumberAutoIncrementEnabled();
	}

	public function getNextReceivePaymentReferenceNo() {
		if ($this->isReceivePaymentNumberAutoIncrementEnabled()) {
			$lastReceivePaymentNo = $this->getLastReceivePaymentNumber();
			$receivePaymentReferenceNoCodeData = $this->system_configurations_model->getBookkeepingReceivePaymentReferenceNoCode();
			$receivePaymentReferenceNoCode = $receivePaymentReferenceNoCodeData[0]->config_filed_value;
			$receivePaymentReferenceNoSeparatorData = $this->system_configurations_model->getBookkeepingReceivePaymentReferenceNoSeparator();
			$receivePaymentReferenceNoSeparator = $receivePaymentReferenceNoSeparatorData[0]->config_filed_value;
			$receivePaymentReferenceNoStartNumberData = $this->system_configurations_model->getBookkeepingReceivePaymentReferenceNoStartNumber();
			$receivePaymentReferenceNoStartNumber = $receivePaymentReferenceNoStartNumberData[0]->config_filed_value;

			if ($lastReceivePaymentNo != 'Nill') {
				if ($receivePaymentReferenceNoSeparator != '') {
					$lastReceivePaymentNoElements = explode($receivePaymentReferenceNoSeparator, $lastReceivePaymentNo);
					$receivePaymentNo = $lastReceivePaymentNoElements[1];
					$result = $receivePaymentReferenceNoCode . $receivePaymentReferenceNoSeparator . ($receivePaymentNo + 1);
				} else {
					$receivePaymentReferenceNoCodeLength = strlen($receivePaymentReferenceNoCode);
					$receivePaymentNo = substr($lastReceivePaymentNo, $receivePaymentReferenceNoCodeLength);
					$result = $receivePaymentReferenceNoCode . $receivePaymentReferenceNoSeparator . ($receivePaymentNo + 1);
				}
			} else {
				$result = $receivePaymentReferenceNoCode . $receivePaymentReferenceNoSeparator . $receivePaymentReferenceNoStartNumber;
			}
		} else {
			$result = "";
		}

		return $result;
	}
	
	public function getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getCustomerSaleableReturnNoteSalesEntryAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getCustomerSaleableReturnNoteCostEntryAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getCustomerMarketReturnNoteSalesEntryAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getCustomerMarketReturnNoteCostEntryAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getReceivePaymentCashAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
    
    public function getPrimeEntryBooksToUpdateForReceivePaymentCreditCardTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getReceivePaymentCreditCardAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getReceivePaymentChequeAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
    
    public function getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim() {
        $primeEntryBooks = $this->system_configurations_model->getReceivePaymentTransactionClaimPrimeEntryBooks();

		return $primeEntryBooks;
    }

    public function getIncomeChequeStatusDropDown() {
		echo $this->payments_model->getIncomeChequeStatusDropdown();
	}
}