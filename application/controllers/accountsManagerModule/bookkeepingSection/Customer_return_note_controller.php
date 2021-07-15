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

class Customer_return_note_controller extends CI_Controller {

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
        $this->load->model('accountsManagerModule/adminSection/financial_year_ends_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/customer_return_note_model', '', TRUE);
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
		$data_cls['li_class_customer_return_note'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

        $referenceNo = $this->input->get('searchId');
		$data['search_reference_no'] = $referenceNo;
        
		$data['customer_return_note_no_auto_increment_status'] = $this->isCustomerReturnNoteNumberAutoIncrementEnabled();

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

		if(isset($this->data['ACM_Bookkeeping_View_Customer_Return_Note_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/customerReturnNote/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['ACM_Bookkeeping_Add_Customer_Return_Note_Permissions'])) {
			$customerReturnNoteId = '';
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
                
                $currentDate = date('Y-m-d');
                $year = date('Y', strtotime($currentDate));

                $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
                $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
                $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
                $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

                $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($currentDate)) {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                } else {
                    if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                        $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    } else {
                        $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    }
                }
            
                if ($this->financial_year_ends_model->isPreviousFinancialYearClosed($financialYearStartDate)) {
                
                    $referenceNo = $this->db->escape_str($this->input->post('reference_no'));
                    $customerReturnNoteDate = $this->db->escape_str($this->input->post('customer_return_note_date'));
                    $deliveryRouteId = $this->db->escape_str($this->input->post('delivery_route_id'));
                    $customerId = $this->db->escape_str($this->input->post('customer_id'));
                    $territoryId = $this->db->escape_str($this->input->post('territory_id'));
                    $locationId = $this->db->escape_str($this->input->post('location_id'));
                    $customerReturnAmount = $this->db->escape_str($this->input->post('customer_return_amount'));
                    $type = $this->db->escape_str($this->input->post('type'));
                    $remark = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('remark')));

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

                    $data = array(
                        'reference_no' => $referenceNo,
                        'date' => $customerReturnNoteDate,
                        'delivery_route_id' => $deliveryRouteId,
                        'customer_id' => $customerId,
                        'territory_id' => $territoryId,
                        'location_id' => $locationId,
                        'amount' => $customerReturnAmount,
                        'balance_payment' => $customerReturnAmount,
                        'type' => $type,
                        'remark' => $remark,
                        'actioned_user_id' => $this->user_id,
                        'added_date' => $this->date,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $customerReturnNoteId = $this->customer_return_note_model->add($data);

                    $correctChartOfAccountsFoundInPrimeEntryBooks = true;
                    $primeEntryBooksToUpdate = '';

                    if ($type == "saleable_return") {
                        $customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                        $customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

                        $primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction();

                        if ($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry && $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry) {
                            $primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry);
                        }
                    } else if ($type == "market_return") {
                        $customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
                        $customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '4');

                        $primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction();
                        $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction();

                        if ($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry && $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry) {
                            $primeEntryBooksToUpdate = array_merge($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry);
                        }
                    }

                    if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 3) {
                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                }
                            }
                        }
                    }

                    if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                        if ($type == "saleable_return") {
                            $description = $this->lang->line('Journal entry for saleable return sales entry for Customer Return Note number : ') . $referenceNo;
                            $this->postJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $customerReturnNoteId, 
                                    $customerSaleableReturnNoteSalesEntryJournalEntries, '1', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $customerReturnAmount, '0', $description);
                            $description = $this->lang->line('Journal entry for saleable return cost entry for Customer Return Note number : ') . $referenceNo;
                            $this->postJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry, $customerReturnNoteId, 
                                    $customerSaleableReturnNoteCostEntryJournalEntries, '2', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $salesCost, '0', $description);
                        } else if ($type == "market_return") {
                            $description = $this->lang->line('Journal entry for market return sales entry for Customer Return Note number : ') . $referenceNo;
                            $this->postJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $customerReturnNoteId, 
                                    $customerMarketReturnNoteSalesEntryJournalEntries, '3', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $customerReturnAmount, '0', $description);
                            $description = $this->lang->line('Journal entry for market return cost entry for Customer Return Note number : ') . $referenceNo;
                            $this->postJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnCostEntry, $customerReturnNoteId, 
                                    $customerMarketReturnNoteCostEntryJournalEntries, '4', $customerReturnNoteDate, $referenceNo, 
                                    $locationId, $customerId, $salesCost, '0', $description, $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId, $profitPortion, '0');
                        }
                    } else {
                        $result = 'incorrect_prime_entry_book_selected_for_sales_note_transaction';
                    }

                    $result = 'ok';
                } else {
                    $result = "previous_financial_year_not_closed";
                }
			}

			echo json_encode(array('result' => $result));
		}
	}

	public function editCustomerReturnNoteData() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Customer_Return_Note_Permissions'])) {
            
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
				$customerReturnNoteDateChanged = false;
				$typeChanged = false;
				$amountChanged = false;
				$remarkChanged = false;

				//Read New Customer Return Note Data
				$customerReturnNoteId = $this->db->escape_str($this->input->post('id'));
                
                $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);
                $customerReturnNoteTransactionDate = $customerReturnNote[0]->date;
                
                $financialYear = $this->financial_year_ends_model->getFinancialYearOfSelectedTransaction($customerReturnNoteTransactionDate);
                
                if ($financialYear[0]->year_end_process_status != "Closed") {
                
                    $referenceNo = $this->db->escape_str($this->input->post('reference_no'));
                    $customerReturnNoteDate = $this->db->escape_str($this->input->post('customer_return_note_date'));
                    $deliveryRouteId = $this->db->escape_str($this->input->post('delivery_route_id'));
                    $customerId = $this->db->escape_str($this->input->post('customer_id'));
                    $territoryId = $this->db->escape_str($this->input->post('territory_id'));
                    $locationId = $this->db->escape_str($this->input->post('location_id'));
                    $type = $this->db->escape_str($this->input->post('type'));
                    $amount = $this->db->escape_str($this->input->post('customer_return_amount'));
                    $remark = $this->db->escape_str($this->input->post('remark'));
                    $remark = preg_replace('~\\\n~',"\r\n", $remark);

                    $salesProfitMargin = $this->getSalesProfitMargin();
                    $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId = $this->system_configurations_model->getCustomerMarketReturnCostEntryProfitMarginCreditChartOfAccount();

                    $oldAmount = $customerReturnNote[0]->amount;

                    $profitPortionOld = 0;

                    if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
                        $profitPortionOld = ($oldAmount/100) * $salesProfitMargin;
                        $costOldAmount = $oldAmount;
                    } else {
                        $costOldAmount = $oldAmount - ($oldAmount/100) * $salesProfitMargin;
                    }
                    $oldType = $customerReturnNote[0]->type;

                    if ($customerReturnNote[0]->reference_no != $referenceNo) {$referenceNoChanged = true;}
                    if ($customerReturnNote[0]->customer_id != $customerId) {$customerChanged = true;}
                    if ($customerReturnNote[0]->territory_id != $territoryId) {$territoryChanged = true;}
                    if ($customerReturnNote[0]->location_id != $locationId) {$locationChanged = true;}
                    if ($customerReturnNote[0]->date != $customerReturnNoteDate) {$customerReturnNoteDateChanged = true;}
                    if ($customerReturnNote[0]->amount != $amount) {$amountChanged = true;}
                    if ($customerReturnNote[0]->type != $type) {$typeChanged = true;}
                    if ($customerReturnNote[0]->remark != $remark) {$remarkChanged = true;}

                    if ($referenceNoChanged || $customerChanged || $territoryChanged || $locationChanged || $customerReturnNoteDateChanged || $typeChanged || $amountChanged || $remarkChanged) {

                        $customerReturnNoteDataHistory = array(
                            'customer_return_note_id' => $customerReturnNote[0]->customer_return_note_id,
                            'reference_no' => $customerReturnNote[0]->reference_no,
                            'delivery_route_id' => $customerReturnNote[0]->delivery_route_id,
                            'customer_id' => $customerReturnNote[0]->customer_id,
                            'territory_id' => $customerReturnNote[0]->territory_id,
                            'location_id' => $customerReturnNote[0]->location_id,
                            'date' => $customerReturnNote[0]->date,
                            'amount' => $customerReturnNote[0]->amount,
                            'cash_payment_amount' => $customerReturnNote[0]->cash_payment_amount,
                            'cheque_payment_amount' => $customerReturnNote[0]->cheque_payment_amount,
                            'credit_card_payment_amount' => $customerReturnNote[0]->credit_card_payment_amount,
                            'balance_payment' => $customerReturnNote[0]->balance_payment,
                            'sales_note_claimed' => $customerReturnNote[0]->sales_note_claimed,
                            'type' => $customerReturnNote[0]->type,
                            'remark' => $customerReturnNote[0]->remark,
                            'actioned_user_id' => $customerReturnNote[0]->actioned_user_id,
                            'added_date' => $customerReturnNote[0]->added_date,
                            'action_date' => $customerReturnNote[0]->action_date,
                            'last_action_status' => $customerReturnNote[0]->last_action_status,
                        );

                        $this->customer_return_note_model->addCustomerReturnNoteDataToHistory($customerReturnNoteDataHistory);

                        $balancePayment = $customerReturnNote[0]->balance_payment;
                        $customerReturnNoteAmountChange = $amount - $customerReturnNote[0]->amount;
                        $balancePayment = $balancePayment + $customerReturnNoteAmountChange;

                        $customerReturnNoteDatanew = array(
                            'reference_no' => $referenceNo,
                            'delivery_route_id' => $deliveryRouteId,
                            'customer_id' => $customerId,
                            'territory_id' => $territoryId,
                            'location_id' => $locationId,
                            'date' => $customerReturnNoteDate,
                            'amount' => $amount,
                            'balance_payment' => $balancePayment,
                            'type' => $type,
                            'remark' => $remark,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNoteId, $customerReturnNoteDatanew);

                        if (!$typeChanged) {
                            if ($type == "saleable_return") {
                                $customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                                $customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

                                $primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction();
                                $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction();

                                $description = $this->lang->line('Journal entry for saleable return sales entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $customerReturnNoteId, $customerSaleableReturnNoteSalesEntryJournalEntries, '1', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $amount, $oldAmount, $description);

                                $costAmount = $amount - ($amount/100) * $salesProfitMargin;

                                $description = $this->lang->line('Journal entry for saleable return cost entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry, $salesNoteId, $customerSaleableReturnNoteCostEntryJournalEntries, '2', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $costAmount, $costOldAmount, $description);
                            } else if ($type == "market_return") {
                                $customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
                                $customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '4');

                                $primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction();
                                $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction();

                                $description = $this->lang->line('Journal entry for market return sales entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $customerReturnNoteId, $customerMarketReturnNoteSalesEntryJournalEntries, '3', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $amount, $oldAmount, $description);

                                $profitPortion = 0;

                                if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
                                    $profitPortion = ($amount/100) * $salesProfitMargin;
                                    $costAmount = $amount;
                                } else {
                                    $costAmount = $amount - ($amount/100) * $salesProfitMargin;
                                }

                                $description = $this->lang->line('Journal entry for market return cost entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnCostEntry, $salesNoteId, $customerMarketReturnNoteCostEntryJournalEntries, '4', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $costAmount, $costOldAmount, $description, $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId, $profitPortion, $profitPortionOld);
                            }
                        } else {
                            if ($oldType == "saleable_return") {
                                $customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                                $customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

                                $status = "deleted";
                                if ($customerSaleableReturnNoteSalesEntryJournalEntries && sizeof($customerSaleableReturnNoteSalesEntryJournalEntries) > 0) {
                                    //Delete all journal entries of Customer Return Note
                                    foreach($customerSaleableReturnNoteSalesEntryJournalEntries as $customerSaleableReturnNoteSalesEntryJournalEntry) {
                                        $customerSaleableReturnNoteSalesEntryJournalEntryId = $customerSaleableReturnNoteSalesEntryJournalEntry->journal_entry_id;
                                        $this->journal_entries_model->deleteJournalEntry($customerSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                                        $this->journal_entries_model->deleteGeneralLedgerTransactions($customerSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                                    }
                                }

                                if ($customerSaleableReturnNoteCostEntryJournalEntries && sizeof($customerSaleableReturnNoteCostEntryJournalEntries) > 0) {
                                    //Delete all journal entries of Customer Return Note
                                    foreach($customerSaleableReturnNoteCostEntryJournalEntries as $customerSaleableReturnNoteCostEntryJournalEntry) {
                                        $customerSaleableReturnNoteCostEntryJournalEntryId = $customerSaleableReturnNoteCostEntryJournalEntry->journal_entry_id;
                                        $this->journal_entries_model->deleteJournalEntry($customerSaleableReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                                        $this->journal_entries_model->deleteGeneralLedgerTransactions($customerSaleableReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                                    }
                                }

                                $customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
                                $customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '4');

                                $primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteSalesEntryTransaction();
                                $primeEntryBooksToUpdateForCustomerMarketReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerMarketReturnNoteCostEntryTransaction();

                                $description = $this->lang->line('Journal entry for saleable return sales entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnSalesEntry, $customerReturnNoteId, $customerMarketReturnNoteSalesEntryJournalEntries, '3', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $amount, $oldAmount, $description);

                                $salesProfitMargin = $this->getSalesProfitMargin();
                                $costAmount = $amount - ($amount/100) * $salesProfitMargin;

                                $description = $this->lang->line('Journal entry for saleable return cost entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerMarketReturnCostEntry, $salesNoteId, $customerMarketReturnNoteCostEntryJournalEntries, '4', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $costAmount, $costOldAmount, $description);
                            } else if ($oldType == "market_return") {
                                $customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                                $customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

                                $status = "deleted";
                                if ($customerMarketReturnNoteSalesEntryJournalEntries && sizeof($customerMarketReturnNoteSalesEntryJournalEntries) > 0) {
                                    //Delete all journal entries of Customer Return Note
                                    foreach($customerMarketReturnNoteSalesEntryJournalEntries as $customerMarketReturnNoteSalesEntryJournalEntry) {
                                        $customerMarketReturnNoteSalesEntryJournalEntryId = $customerMarketReturnNoteSalesEntryJournalEntry->journal_entry_id;
                                        $this->journal_entries_model->deleteJournalEntry($customerMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                                        $this->journal_entries_model->deleteGeneralLedgerTransactions($customerMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                                    }
                                }

                                if ($customerMarketReturnNoteCostEntryJournalEntries && sizeof($customerMarketReturnNoteCostEntryJournalEntries) > 0) {
                                    //Delete all journal entries of Customer Return Note
                                    foreach($customerMarketReturnNoteCostEntryJournalEntries as $customerMarketReturnNoteCostEntryJournalEntry) {
                                        $customerMarketReturnNoteCostEntryJournalEntryId = $customerMarketReturnNoteCostEntryJournalEntry->journal_entry_id;
                                        $this->journal_entries_model->deleteJournalEntry($customerMarketReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                                        $this->journal_entries_model->deleteGeneralLedgerTransactions($customerMarketReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                                    }
                                }

                                $customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                                $customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

                                $primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteSalesEntryTransaction();
                                $primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry = $this->getPrimeEntryBooksToUpdateForCustomerSaleableReturnNoteCostEntryTransaction();

                                $description = $this->lang->line('Journal entry for market return sales entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnSalesEntry, $customerReturnNoteId, $customerSaleableReturnNoteSalesEntryJournalEntries, '1', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $amount, $oldAmount, $description);

                                $salesProfitMargin = $this->getSalesProfitMargin();

                                $profitPortion = 0;

                                if ($this->system_configurations_model->isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled()) {
                                    $profitPortion = ($amount/100) * $salesProfitMargin;
                                    $costAmount = $amount;
                                } else {
                                    $costAmount = $amount - ($amount/100) * $salesProfitMargin;
                                }

                                $description = $this->lang->line('Journal entry for market return cost entry for Customer Return Note number : ') . $referenceNo;
                                $this->postJournalEntries($primeEntryBooksToUpdateForCustomerSaleableReturnCostEntry, $salesNoteId, $customerSaleableReturnNoteCostEntryJournalEntries, '2', $customerReturnNoteDate, $referenceNo, $locationId, $customerId, $costAmount, $costOldAmount, $description, $CustomerMarketReturnCostEntryProfitMarginCreditChartOfAccountId, $profitPortion, $profitPortionOld);
                            }
                        }

                        $result = 'ok';
                    } else {
                        $result = 'no_changes_to_save';
                    }
                } else {
                    $result = "previous_financial_year_is_closed";
                }
			}

			echo json_encode(array('result' => $result, 'salesNoteId' => $salesNoteId));
		}
	}

	//Delete Customer Return Note
	public function deleteCustomerReturnNote() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Customer_Return_Note_Permissions'])) {
            
            $html = '';
			$customerReturnNoteId = $this->db->escape_str($this->input->post('id'));
            
			$customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);
            $customerReturnNoteTransactionDate = $customerReturnNote[0]->date;

            $financialYear = $this->financial_year_ends_model->getFinancialYearOfSelectedTransaction($customerReturnNoteTransactionDate);

            if ($financialYear[0]->year_end_process_status != "Closed") {
                
                $type = $customerReturnNote[0]->type;

                $isReferenceTransactionUsedInMakePayments = $this->make_payment_model->isReferenceTransactionUsedInMakePayments('4', $customerReturnNoteId);
                $isReferenceTransactionUsedInReceivePayments = $this->receive_payment_model->isReferenceTransactionUsedInReceivePayments('4', $customerReturnNoteId);

                if (!$isReferenceTransactionUsedInMakePayments && !$isReferenceTransactionUsedInReceivePayments) {

                    if ($type == "saleable_return") {
                        $customerSaleableReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                        $customerSaleableReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '2');

                        $status = "deleted";
                        if ($customerSaleableReturnNoteSalesEntryJournalEntries && sizeof($customerSaleableReturnNoteSalesEntryJournalEntries) > 0) {
                            //Delete all journal entries of Customer Return Note
                            foreach($customerSaleableReturnNoteSalesEntryJournalEntries as $customerSaleableReturnNoteSalesEntryJournalEntry) {
                                $customerSaleableReturnNoteSalesEntryJournalEntryId = $customerSaleableReturnNoteSalesEntryJournalEntry->journal_entry_id;
                                $this->journal_entries_model->deleteJournalEntry($customerSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                                $this->journal_entries_model->deleteGeneralLedgerTransactions($customerSaleableReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                            }
                        }

                        if ($customerSaleableReturnNoteCostEntryJournalEntries && sizeof($customerSaleableReturnNoteCostEntryJournalEntries) > 0) {
                            //Delete all journal entries of Customer Return Note
                            foreach($customerSaleableReturnNoteCostEntryJournalEntries as $customerSaleableReturnNoteCostEntryJournalEntry) {
                                $customerSaleableReturnNoteCostEntryJournalEntryId = $customerSaleableReturnNoteCostEntryJournalEntry->journal_entry_id;
                                $this->journal_entries_model->deleteJournalEntry($customerSaleableReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                                $this->journal_entries_model->deleteGeneralLedgerTransactions($customerSaleableReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                            }
                        }
                    } else if ($type == "market_return") {
                        $customerMarketReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
                        $customerMarketReturnNoteCostEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '4');

                        $status = "deleted";
                        if ($customerMarketReturnNoteSalesEntryJournalEntries && sizeof($customerMarketReturnNoteSalesEntryJournalEntries) > 0) {
                            //Delete all journal entries of Customer Return Note
                            foreach($customerMarketReturnNoteSalesEntryJournalEntries as $customerMarketReturnNoteSalesEntryJournalEntry) {
                                $customerMarketReturnNoteSalesEntryJournalEntryId = $customerMarketReturnNoteSalesEntryJournalEntry->journal_entry_id;
                                $this->journal_entries_model->deleteJournalEntry($customerMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                                $this->journal_entries_model->deleteGeneralLedgerTransactions($customerMarketReturnNoteSalesEntryJournalEntryId, $status, $this->user_id);
                            }
                        }

                        if ($customerMarketReturnNoteCostEntryJournalEntries && sizeof($customerMarketReturnNoteCostEntryJournalEntries) > 0) {
                            //Delete all journal entries of Customer Return Note
                            foreach($customerMarketReturnNoteCostEntryJournalEntries as $customerMarketReturnNoteCostEntryJournalEntry) {
                                $customerMarketReturnNoteCostEntryJournalEntryId = $customerMarketReturnNoteCostEntryJournalEntry->journal_entry_id;
                                $this->journal_entries_model->deleteJournalEntry($customerMarketReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                                $this->journal_entries_model->deleteGeneralLedgerTransactions($customerMarketReturnNoteCostEntryJournalEntryId, $status, $this->user_id);
                            }
                        }
                    }

                    if ($this->customer_return_note_model->deleteCustomerReturnNote($customerReturnNoteId, $status, $this->user_id)) {
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
                                $this->lang->line('Customer Return Note already used in make payment and receive payment transactions and cannot be deleted!') .
                            '</div>';
                }

                echo json_encode(array("result" => "ok", "html" => $html));
            } else {
                echo json_encode(array("result" => "previous_financial_year_is_closed", "html" => $html));
            }
		}
	}

	public function getCustomerReturnNoteData() {
		if(isset($this->data['ACM_Bookkeeping_View_Customer_Return_Note_Permissions'])) {
			$customerReturnNoteId = $this->db->escape_str($this->input->post('id'));
			$customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);
			$html = "";
			if ($customerReturnNote != null) {
				foreach ($customerReturnNote as $row) {
					$html .="   <form class='form form-horizontal validate-form save_form'>
								<div class='form-group'>
									<input class='form-control'   id='customer_return_note_id' name='customer_return_note_id' type='hidden' value='{$row->customer_return_note_id}'>
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
											<input class='form-control' id='customer_return_note_date_edit' name='customer_return_note_date_edit'
												data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$row->date}'>
											<span class='input-group-addon'>
												<span class='glyphicon glyphicon-calendar'/>
											</span>
										</div>
										<div id='customer_return_note_date_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Customer')} *</label>
									<div class='col-sm-4 controls' id='customer_dropdown_edit'>
										<select class='select2 form-control' id='customer_id_edit'>";
							if ($row->delivery_route_id != '0') {
					$html .=                   $this->peoples_model->getCustomersToDropDownWithSavedOption($row->customer_id, "People Name", "", $row->delivery_route_id);
							} else {
					$html .=                   $this->peoples_model->getCustomersToDropDownWithSavedOption($row->customer_id, "People Name");
							}
					$html .="               </select>
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
									<label class='control-label col-sm-3'>{$this->lang->line('Customer Return Amount')} *</label>
									<div class='col-sm-4 controls'>
										<input class='form-control'  id='customer_return_amount_edit' name='customer_return_amount_edit'
											placeholder='{$this->lang->line('Customer Return Amount')}' type='text' value='{$row->amount}' onblur='handleCustomerReturnAmountAddition()'>
										<div id='customer_return_amount_editError' class='red'></div>
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
                                                if(isset($this->data['ACM_Bookkeeping_Edit_Customer_Return_Note_Permissions'])) {
                                                    $html .= "<button class='btn btn-success save' onclick='editCustomerReturnNoteData({$row->customer_return_note_id});' type='button'>
                                                                            <i class='icon-save'></i>
                                                                            {$this->lang->line('Edit')}
                                                                        </button> ";
                                                }
                                            }
								$html.="            <button class='btn btn-warning cancel' onclick='closeCustomerReturnNoteEditForm({$row->customer_return_note_id});' type='button'>
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
		if(isset($this->data['ACM_Bookkeeping_View_Customer_Return_Note_Permissions'])) {
			
			$hideMonthFilter = false;
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			$customerId = $this->db->escape_str($this->input->post('customer_id'));
			$territoryId = $this->db->escape_str($this->input->post('territory_id'));
			$customerReturnNoteId = $this->db->escape_str($this->input->post('reference_no_link'));
            
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
							<table class='table table-striped table-bordered customerReturnNoteDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Reference No')}</th>
										<th>{$this->lang->line('Date')}</th>
										<th>{$this->lang->line('Customer')}</th>
										<th>{$this->lang->line('Territory')}</th>
                                        <th>{$this->lang->line('Location')}</th>
										<th>{$this->lang->line('Amount')}</th>
                                        <th>{$this->lang->line('Balance Amount')}</th>
                                        <th>{$this->lang->line('Status')}</th>
										<th>{$this->lang->line('Actions')}</th>
									</tr>
								</thead>
								<tbody>";
			
            if ($customerReturnNoteId == '') {
                $customerReturnNotes = $this->customer_return_note_model->getAllForPeriod($fromDate, $toDate, $customerId, $territoryId, 'date', 'desc');
            } else {
                $customerReturnNotes = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);
            }

			if ($customerReturnNotes != null) {
				foreach ($customerReturnNotes as $row) {
					
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
                    $backgroundColorClass = "default_color";
                    if ($row->status == "Claimed") {
                        $status = "Paid";
                        $backgroundColorClass = "green_color";
                    }
					
					$html .= "<tr>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->reference_no . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $row->date . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $customerName . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . $territoryName . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . $locationName . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>" . number_format($row->amount, 2) . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . number_format($row->balance_payment, 2) . "</td>";
                    $html .= "<td class='" . $backgroundColorClass . "'>" . $status . "</td>";
					$html .= "<td class='" . $backgroundColorClass . "'>
											<div class='text-left'>";
											if(isset($this->data['ACM_Bookkeeping_Edit_Customer_Return_Note_Permissions'])) {
												$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->customer_return_note_id}' title='{$this->lang->line('Edit')}' onclick='getCustomerReturnNoteData({$row->customer_return_note_id});'>
																						<i class='icon-wrench'></i>
																					</a> ";
											}
                                            if ($row->status != "Claimed") {
                                                if(isset($this->data['ACM_Bookkeeping_Delete_Customer_Return_Note_Permissions'])) {
                                                    $html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->customer_return_note_id}' title='{$this->lang->line('Delete')}' onclick='del($row->customer_return_note_id);'>
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
    
    public function getAllCustomerReturnNotesToDropDown() {
        $options = $this->customer_return_note_model->getAllCustomerReturnNotesAsOptionList();
        
        $html  = "  <select class='form-control' id='customer_return_note_id' onchange='handleCustomerReturnNoteSelect(this.id)'>
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
		$result = $this->customer_return_note_model->checkExistingCustomerReturnNote($reference_no);
		$salesNoteId = $this->db->escape_str($this->input->post('id'));

		if ($salesNoteId != '' && $result) {
			if ($salesNoteId !=  $result[0]->customer_return_note_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Customer Return Note') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
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

	public function getNextReferenceNo() {
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

			$status = "auto_increment";
		} else {
			$lastCustomerReturnNoteNo = $this->getLastCustomerReturnNoteNumber();
			$result = "<label class='control-label col-sm-3' id='last_reference_no_label' style='text-align:left; color: #2eb82e;'>"
					. "{$this->lang->line('Last Reference Number : ')}" . $lastCustomerReturnNoteNo . "</label>";
			$status = "manual_increment";
		}

		echo json_encode(array('status' => $status, 'result' => $result));
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
	
	public function postJournalEntries($primeEntryBooksToUpdate, $customerReturnNoteId, $journalEntries, $transactionTypeId, $date, 
            $referenceNo, $locationId, $payeePayerId, $amount, $oldAmount, $description, $specialChartOfAccountId=null, 
            $specialChartOfAccountAmount=null, $specialChartOfAccountOldAmount=null) {
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