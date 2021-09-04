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

class Financial_year_ends_controller extends CI_Controller {

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
        $this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/financial_year_ends_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
        $this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
        $this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

        $this->load->library('charOfAccountStructureLibrary/chart_of_accounts_processor');
        
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
		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';
		$data_cls['li_class_financial_year_ends'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();
        
        $financialYears = $this->financial_year_ends_model->getAll('financial_year_id', 'desc');
        
        if (!$financialYears) {
            $firstJournalEntry = $this->journal_entries_model->getTheVeryFirstJournalEntry();
            
            if ($firstJournalEntry && sizeof($firstJournalEntry) > 0) {
                $journalEntryDate = $firstJournalEntry[0]->transaction_date;
                
                $currentDate = date('Y-m-d');
                $year = date('Y', strtotime($journalEntryDate));
                
                $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
                $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
                $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
                $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

                if ($financialYearStartMonth != '' && $financialYearStartDay != '' && $financialYearEndMonth != '' && $financialYearEndDay != '') {
                    
                    $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                    if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($journalEntryDate)) {
                        $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    } else {
                        if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                            $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                            $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                        } else {
                            $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                            $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                        }
                    }

                    $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);

                    if (!$financialYearEndData) {
                        $data = array(
                            'financial_year_start_date' => $financialYearStartDate,
                            'financial_year_end_date' => $financialYearEndDate,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->financial_year_ends_model->add($data);
                    }

                    while (!(strtotime($financialYearStartDate) < strtotime($currentDate) && strtotime($financialYearEndDate) > strtotime($currentDate))) {

                        if (strtotime($financialYearEndDate) < strtotime($currentDate)) {

                            $financialYearStartYear = date('Y', strtotime($financialYearStartDate));
                            $financialYearEndYear = date('Y', strtotime($financialYearEndDate));

                            $financialYearStartYear++;
                            $financialYearEndYear++;

                            $financialYearStartDate = $financialYearStartYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                            $financialYearEndDate = $financialYearEndYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                            $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);

                            if (!$financialYearEndData) {
                                $data = array(
                                    'financial_year_start_date' => $financialYearStartDate,
                                    'financial_year_end_date' => $financialYearEndDate,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );

                                $this->financial_year_ends_model->add($data);
                            }
                        }
                    }
                }
            } else {
                $currentDate = date('Y-m-d');
                $year = date('Y', strtotime($currentDate));
                
                $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
                $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
                $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
                $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

                if ($financialYearStartMonth != '' && $financialYearStartDay != '' && $financialYearEndMonth != '' && $financialYearEndDay != '') {
                    
                    $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                    if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($currentDate)) {
                        $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    } else {
                        if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                            $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                            $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                        } else {
                            $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                            $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                        }
                    }

                    $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);

                    if (!$financialYearEndData) {
                        $data = array(
                            'financial_year_start_date' => $financialYearStartDate,
                            'financial_year_end_date' => $financialYearEndDate,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->financial_year_ends_model->add($data);
                    }
                }
            }
        } else {
            
            $currentDate = date('Y-m-d');
            $year = date('Y', strtotime($currentDate));

            $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
            $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
            $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
            $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

            if ($financialYearStartMonth != '' && $financialYearStartDay != '' && $financialYearEndMonth != '' && $financialYearEndDay != '') {
                
                $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($currentDate)) {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                } else {
                    if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                        $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    } else {
                        $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    }
                }

                $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);

                if (!$financialYearEndData) {
                    $data = array(
                        'financial_year_start_date' => $financialYearStartDate,
                        'financial_year_end_date' => $financialYearEndDate,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $this->financial_year_ends_model->add($data);
                }
            }
        }

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		if(isset($this->data['ACM_Admin_View_Financial_Year_Ends_Permissions'])) {
			$this->load->view('web/accountsManagerModule/adminSection/financialYearEnds/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function processYearEndData() {
		if(isset($this->data['ACM_Admin_Edit_Financial_Year_Ends_Permissions'])) {
            
            $parentLiabilitiesChartOfAccountId = $this->system_configurations_model->getParentLiabilitiesChartOfAccountConfigurationData();
            $parentAssetsChartOfAccountId = $this->system_configurations_model->getParentAssetsChartOfAccountConfigurationData();
            $retainedEarningsChartOfAccountId = $this->system_configurations_model->getRetainedEarningsChartOfAccountConfigurationData();
			$tradeDebtorChartOfAccountId = $this->system_configurations_model->getTradeDebtorChartOfAccountConfigurationData();
            $parentExpenseChartOfAccountId = $this->system_configurations_model->getParentExpenseChartOfAccountConfigurationData();
            
            if ($parentLiabilitiesChartOfAccountId != '' && $parentAssetsChartOfAccountId != '' && $retainedEarningsChartOfAccountId != '' &&
                $parentLiabilitiesChartOfAccountId != '0' && $parentAssetsChartOfAccountId != '0' && $retainedEarningsChartOfAccountId != '0') {
                
                $financialYearEndId = $this->db->escape_str($this->input->post('financial_year_id'));

                $financialYear = $this->financial_year_ends_model->getFinancialYearEndById($financialYearEndId);

                $financialYearStartDate = $financialYear[0]->financial_year_start_date;
                $financialYearEndDate = $financialYear[0]->financial_year_end_date;

                $year = date('Y', strtotime($financialYearStartDate));
                $openingBalancesDate = date('Y-m-d', strtotime($financialYearEndDate . ' +1 day'));

                $specialChartOfAccountsToCheckCompletedTransactionsStatus = array();

                $chequeInHandChartOfAccount = $this->system_configurations_model->getCashAndCashEquivalentsReportChequeInHandChartOfAccount();

                if ($chequeInHandChartOfAccount[0]->config_filed_value != '0') {
                    $specialChartOfAccountsToCheckCompletedTransactionsStatus[] = $chequeInHandChartOfAccount[0]->config_filed_value;
                }

                $openingBalanceEquityChartOfAccount = $this->system_configurations_model->getOpeninngBalanceEquityChartOfAccountConfigurationData();

                $openingBalanceEquityChartOfAccountId = '';
                if($openingBalanceEquityChartOfAccount && sizeof($openingBalanceEquityChartOfAccount) > 0) {
                    $openingBalanceEquityChartOfAccountId = $openingBalanceEquityChartOfAccount[0]->config_filed_value;
                }

                $locations = $this->locations_model->getAll('location_name','asc');

                if ($locations && sizeof($locations) > 0) {
                    
                    foreach ($locations as $location) {
                        
                        $locationId = $location->location_id;

                        $payeePayerId = '0';

                        $accountBalanceList = $this->journal_entries_model->getFilteredJournalEntriesOfParentChartOfAccount($financialYearStartDate, $financialYearEndDate, $locationId, "", "", $specialChartOfAccountsToCheckCompletedTransactionsStatus, "", "Yes");

                        if ($accountBalanceList && sizeof($accountBalanceList) > 0) {
                            
                            //Assets Accounts Balance Details
                            $completeAssetsAccountBalanceList = $accountBalanceList;

                            $assetsAccountBalanceList = array();

                            $chartOfAccountsProcessorForLiabilityAccounts = new Chart_of_accounts_processor();

                            $chartOfAccountMultiwayTreeForLiabilityAccounts = $chartOfAccountsProcessorForLiabilityAccounts->prepareChartOfAccountsMultiwayTree($parentLiabilitiesChartOfAccountId);
                            $leafChartOfAccountIdsForLiabilityAccounts = $chartOfAccountsProcessorForLiabilityAccounts->depthFirstTraversalAndFindLeafChartOfAccounts($chartOfAccountMultiwayTreeForLiabilityAccounts);

                            $chartOfAccountsProcessorForAssetAccounts = new Chart_of_accounts_processor();

                            $chartOfAccountMultiwayTreeForAssetAccounts = $chartOfAccountsProcessorForAssetAccounts->prepareChartOfAccountsMultiwayTree($parentAssetsChartOfAccountId);
                            $leafChartOfAccountIdsForAssetAccounts = $chartOfAccountsProcessorForAssetAccounts->depthFirstTraversalAndFindLeafChartOfAccounts($chartOfAccountMultiwayTreeForAssetAccounts);
                            
                            $chartOfAccountsProcessorForDebtorAccounts = new Chart_of_accounts_processor();

                            $chartOfAccountMultiwayTreeForDebtorAccounts = $chartOfAccountsProcessorForDebtorAccounts->prepareChartOfAccountsMultiwayTree($tradeDebtorChartOfAccountId);
                            $leafChartOfAccountIdsForDebtorAccounts = $chartOfAccountsProcessorForDebtorAccounts->depthFirstTraversalAndFindLeafChartOfAccounts($chartOfAccountMultiwayTreeForDebtorAccounts);
                            
                            $chartOfAccountsProcessorForExpenseAccounts = new Chart_of_accounts_processor();

                            $chartOfAccountMultiwayTreeForExpenseAccounts = $chartOfAccountsProcessorForExpenseAccounts->prepareChartOfAccountsMultiwayTree($parentExpenseChartOfAccountId);
                            $leafChartOfAccountIdsForExpenseAccounts = $chartOfAccountsProcessorForExpenseAccounts->depthFirstTraversalAndFindLeafChartOfAccounts($chartOfAccountMultiwayTreeForExpenseAccounts);
                            //print_r($leafChartOfAccountIdsForLiabilityAccounts);die;
                            foreach ($completeAssetsAccountBalanceList as $record) {
                                if (array_key_exists($record['chart_of_account_id'], $assetsAccountBalanceList)) {

                                    $payeePayerId = $record['payee_payer_id'];
                                    $journalEntryId = $record['journal_entry_id'];
                                    $glTransactionId = $record['gl_transaction_id'];
                                    $processingJournalEntryChartOfAccountIsAnAssetAccount = "No";
                                    $processingJournalEntryChartOfAccountIsADebtorAccount = "No";
                                    
                                    if ($glTransactionId == '117' || $glTransactionId == '118') {
                                        $x = 1;
                                    }

                                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                    //For some gl transactions, payee or payer is not required to consider when get account
                                    //balances to the next financial year. Remove such payee or payer as necessary.
                                    if ($payeePayerId != '0') {
                                        
                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            
                                            foreach ($leafChartOfAccountIdsForAssetAccounts as $leafChartOfAccountId) {
                                                if ($leafChartOfAccountId == $record['chart_of_account_id']) {
                                                    $processingJournalEntryChartOfAccountIsAnAssetAccount = "Yes";
                                                }
                                            }
                                            
                                            foreach ($leafChartOfAccountIdsForDebtorAccounts as $leafChartOfAccountId) {
                                                if ($leafChartOfAccountId == $record['chart_of_account_id']) {
                                                    $processingJournalEntryChartOfAccountIsADebtorAccount = "Yes";
                                                }
                                            }
                                                
                                            foreach ($glTransactions as $glTransaction) {
                                                 
                                                if ($glTransaction->gl_transaction_id != $glTransactionId) {
                                                    $consideringChartOfAccountId = $glTransaction->chart_of_account_id;

                                                    foreach ($leafChartOfAccountIdsForLiabilityAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "No"
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {   
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $glTransaction->debit_value == "0.00" && $glTransaction->credit_value != "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }

                                                    foreach ($leafChartOfAccountIdsForExpenseAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "No" 
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {   
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $glTransaction->debit_value == "0.00" && $glTransaction->credit_value != "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }
                                                } else {
//                                                    foreach ($leafChartOfAccountIdsForAssetAccounts as $leafChartOfAccountId) {
//                                                        if ($leafChartOfAccountId == $record['chart_of_account_id']) {
//                                                            $processingJournalEntryChartOfAccountIsAnAssetAccount = "Yes";
//                                                        }
//                                                    }
                                                }
                                            }
                                        }
                                    }

                                    //For some gl transactions, payee or payer is not required to consider when get account
                                    //balances to the next financial year. Remove such payee or payer as necessary.
                                    if ($payeePayerId != '0') {
                                        
                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            foreach ($glTransactions as $glTransaction) {
                                                if ($glTransaction->gl_transaction_id != $glTransactionId) {
                                                    $consideringChartOfAccountId = $glTransaction->chart_of_account_id;

                                                    foreach ($leafChartOfAccountIdsForLiabilityAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                            && $processingJournalEntryChartOfAccountIsADebtorAccount == "No" 
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {   
                                                            $payeePayerId = '0';
                                                        }
                                                    }
                                                    
                                                    foreach ($leafChartOfAccountIdsForAssetAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsADebtorAccount == "No" 
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $processingJournalEntryChartOfAccountIsADebtorAccount == "No" 
                                                                   && $glTransaction->debit_value == "0.00" && $glTransaction->credit_value != "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }

                                                    foreach ($leafChartOfAccountIdsForExpenseAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "No"
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {   
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $processingJournalEntryChartOfAccountIsADebtorAccount == "No" 
                                                                   && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $intermediateFinalArray = array();

                                    foreach ($assetsAccountBalanceList as $key => $temporaryRecord) {
                                        if ($key == $record['chart_of_account_id']) {
                                            foreach ($temporaryRecord as $subKey => $subTemporaryRecord) {
                                                $intermediateFinalArray[$subKey] = $subTemporaryRecord;
                                            }
                                        }
                                    }

                                    if (array_key_exists($payeePayerId, $intermediateFinalArray)) {
                                        $assetsAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['debit_amount'] = $assetsAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['debit_amount'] + $record['debit_amount'];
                                        $assetsAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['credit_amount'] = $assetsAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['credit_amount'] + $record['credit_amount'];
                                    } else {
                                        $assetsAccountBalanceList[$record['chart_of_account_id']][$payeePayerId] = $record;
                                    }
                                } else {

                                    $payeePayerId = $record['payee_payer_id'];
                                    $journalEntryId = $record['journal_entry_id'];
                                    $glTransactionId = $record['gl_transaction_id'];
                                    $processingJournalEntryChartOfAccountIsAnAssetAccount = "No";
                                    $processingJournalEntryChartOfAccountIsADebtorAccount = "No";

                                    if ($glTransactionId == '117' || $glTransactionId == '118') {
                                        $x = 1;
                                    }
                                    
                                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                    //For some gl transactions, payee or payer is not required to consider when get account
                                    //balances to the next financial year. Remove such payee or payer as necessary.
                                    if ($payeePayerId != '0') {
                                        
                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            
                                            foreach ($leafChartOfAccountIdsForAssetAccounts as $leafChartOfAccountId) {
                                                if ($leafChartOfAccountId == $record['chart_of_account_id']) {
                                                    $processingJournalEntryChartOfAccountIsAnAssetAccount = "Yes";
                                                }
                                            }
                                            
                                            foreach ($leafChartOfAccountIdsForDebtorAccounts as $leafChartOfAccountId) {
                                                if ($leafChartOfAccountId == $record['chart_of_account_id']) {
                                                    $processingJournalEntryChartOfAccountIsADebtorAccount = "Yes";
                                                }
                                            }
                                                
                                            foreach ($glTransactions as $glTransaction) {
                                                
                                                if ($glTransaction->gl_transaction_id != $glTransactionId) {
                                                    $consideringChartOfAccountId = $glTransaction->chart_of_account_id;

                                                    foreach ($leafChartOfAccountIdsForLiabilityAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "No"
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $glTransaction->debit_value == "0.00" && $glTransaction->credit_value != "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }

                                                    foreach ($leafChartOfAccountIdsForExpenseAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "No"
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {   
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $glTransaction->debit_value == "0.00" && $glTransaction->credit_value != "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }
                                                } else {
//                                                    foreach ($leafChartOfAccountIdsForAssetAccounts as $leafChartOfAccountId) {
//                                                        if ($leafChartOfAccountId == $record['chart_of_account_id']) {
//                                                            $processingJournalEntryChartOfAccountIsAnAssetAccount = "Yes";
//                                                        }
//                                                    }
                                                }
                                            }
                                        }
                                    }

                                    //For some gl transactions, payee or payer is not required to consider when get account
                                    //balances to the next financial year. Remove such payee or payer as necessary.
                                    if ($payeePayerId != '0') {
                                        
                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            foreach ($glTransactions as $glTransaction) {
                                                if ($glTransaction->gl_transaction_id != $glTransactionId) {
                                                    $consideringChartOfAccountId = $glTransaction->chart_of_account_id;

                                                    foreach ($leafChartOfAccountIdsForLiabilityAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                            && $processingJournalEntryChartOfAccountIsADebtorAccount == "No" 
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {   
                                                            $payeePayerId = '0';
                                                        }
                                                    }
                                                    
                                                    foreach ($leafChartOfAccountIdsForAssetAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsADebtorAccount == "No"
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $processingJournalEntryChartOfAccountIsADebtorAccount == "No" 
                                                                   && $glTransaction->debit_value == "0.00" && $glTransaction->credit_value != "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }

                                                    foreach ($leafChartOfAccountIdsForExpenseAccounts as $leafChartOfAccountId) {

                                                        if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "No" 
                                                            && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId && $record['debit_amount'] != "0.00" && $record['credit_amount'] == "0.00") {
                                                        //if ($leafChartOfAccountId == $consideringChartOfAccountId) {   
                                                            $payeePayerId = '0';
                                                        } else if ($leafChartOfAccountId == $consideringChartOfAccountId && $processingJournalEntryChartOfAccountIsAnAssetAccount == "Yes"
                                                                   && $processingJournalEntryChartOfAccountIsADebtorAccount == "No" 
                                                                   && $glTransaction->debit_value != "0.00" && $glTransaction->credit_value == "0.00") {
                                                            $payeePayerId = '0';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $assetsAccountBalanceList[$record['chart_of_account_id']][$payeePayerId] = $record;
                                }
                            }

                            $assetsChartOfAccountsProcessor = new Chart_of_accounts_processor();

                            $assetsChartOfAccountMultiwayTree = $assetsChartOfAccountsProcessor->prepareChartOfAccountsMultiwayTree($parentAssetsChartOfAccountId);

                            $assetsLeafChartOfAccountIds = $assetsChartOfAccountsProcessor->depthFirstTraversalAndFindLeafChartOfAccounts($assetsChartOfAccountMultiwayTree);
                            //print_r($leafChartOfAccountIds);die;
                            $assetsAccountBalanceListFinal = array();

                            foreach ($assetsAccountBalanceList as $key => $record) {

                                if (in_array($key, $assetsLeafChartOfAccountIds)) {
                                    $assetsAccountBalanceListFinal[$key] = $record;
                                }
                            }

                            if ($assetsAccountBalanceListFinal && sizeof($assetsAccountBalanceListFinal) > 0) {
                                foreach ($assetsAccountBalanceListFinal as $chartOfAccountId => $accountBalanceRows) {

                                    foreach ($accountBalanceRows as $payeePayerId => $accountBalanceRow) {

                                        $chartOfAccount = $this->chart_of_accounts_model->get($accountBalanceRow['chart_of_account_id']);
                                        $chartOfAccountName = $chartOfAccount[0]->text;

                                        $accountBalance = $accountBalanceRow['debit_amount'] - $accountBalanceRow['credit_amount'];

                                        $drAmount = '0.00';
                                        $crAmount = '0.00';

                                        if ($accountBalance > 0) {
                                            $drAmount = $accountBalance;
                                        } else if ($accountBalance < 0) {
                                            $crAmount = -($accountBalance);
                                        }

                                        $shouldHaveAPaymentJournalEntry = "No";

                                        $payeePayerName = '';

                                        if ($payeePayerId != '' && $payeePayerId != '0') {
                                            $shouldHaveAPaymentJournalEntry = "Yes";

                                            $payeePayer = $this->peoples_model->getById($payeePayerId);
                                            $payeePayerName = $payeePayer[0]->people_name;

                                            $description = 'Opening balance for chart of account : ' . $chartOfAccountName . " : " . $payeePayerName;
                                        } else {
                                            $description = 'Opening balance for chart of account : ' . $chartOfAccountName;
                                        }

                                        $data = array(
                                            'transaction_date' => $openingBalancesDate,
                                            'payee_payer_id' => $payeePayerId,
                                            'should_have_a_payment_journal_entry' => $shouldHaveAPaymentJournalEntry,
                                            'location_id' => $locationId,
                                            'description' => $description,
                                            'remark' => 'OB',
                                            'post_type' => "Direct",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'added'
                                        );

                                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                        if ($drAmount != '0.00') {
                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $chartOfAccountId,
                                                'debit_value' => $drAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                                'credit_value' => $drAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                        }

                                        if ($crAmount != '0.00') {
                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                                'debit_value' => $crAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $chartOfAccountId,
                                                'credit_value' => $crAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                        }
                                    }
                                }
                            }

                            //Liabilities Accounts Balance Details
                            $completeLiabilitiesAccountBalanceList = $accountBalanceList;

                            $liabilitiesAccountBalanceList = array();

                            foreach ($completeLiabilitiesAccountBalanceList as $record) {
                                if (array_key_exists($record['chart_of_account_id'], $liabilitiesAccountBalanceList)) {

                                    $payeePayerId = $record['payee_payer_id'];

                                    $intermediateFinalArray = array();
                                    foreach ($liabilitiesAccountBalanceList as $key => $temporaryRecord) {
                                        if ($key == $record['chart_of_account_id']) {
                                            foreach ($temporaryRecord as $subKey => $subTemporaryRecord) {
                                                $intermediateFinalArray[$subKey] = $subTemporaryRecord;
                                            }
                                        }
                                    }

                                    if (array_key_exists($payeePayerId, $intermediateFinalArray)) {
                                        $liabilitiesAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['debit_amount'] = $liabilitiesAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['debit_amount'] + $record['debit_amount'];
                                        $liabilitiesAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['credit_amount'] = $liabilitiesAccountBalanceList[$record['chart_of_account_id']][$payeePayerId]['credit_amount'] + $record['credit_amount'];
                                    } else {
                                        $liabilitiesAccountBalanceList[$record['chart_of_account_id']][$payeePayerId] = $record;
                                    }
                                } else {

                                    $payeePayerId = $record['payee_payer_id'];

                                    $liabilitiesAccountBalanceList[$record['chart_of_account_id']][$payeePayerId] = $record;
                                }
                            }

                            $liabilitiesChartOfAccountsProcessor = new Chart_of_accounts_processor();

                            $liabilitiesChartOfAccountMultiwayTree = $liabilitiesChartOfAccountsProcessor->prepareChartOfAccountsMultiwayTree($parentLiabilitiesChartOfAccountId);

                            $liabilitiesLeafChartOfAccountIds = $liabilitiesChartOfAccountsProcessor->depthFirstTraversalAndFindLeafChartOfAccounts($liabilitiesChartOfAccountMultiwayTree);
                            //print_r($leafChartOfAccountIds);die;
                            $liabilitiesAccountBalanceListFinal = array();

                            foreach ($liabilitiesAccountBalanceList as $key => $record) {

                                if (in_array($key, $liabilitiesLeafChartOfAccountIds)) {
                                    $liabilitiesAccountBalanceListFinal[$key] = $record;
                                }
                            }

                            if ($liabilitiesAccountBalanceListFinal && sizeof($liabilitiesAccountBalanceListFinal) > 0) {
                                foreach ($liabilitiesAccountBalanceListFinal as $chartOfAccountId => $accountBalanceRows) {

                                    foreach ($accountBalanceRows as $payeePayerId => $accountBalanceRow) {

                                        $chartOfAccount = $this->chart_of_accounts_model->get($accountBalanceRow['chart_of_account_id']);
                                        $chartOfAccountName = $chartOfAccount[0]->text;

                                        $accountBalance = $accountBalanceRow['credit_amount'] - $accountBalanceRow['debit_amount'];

                                        $drAmount = '0.00';
                                        $crAmount = '0.00';

                                        if ($accountBalance > 0) {
                                            $crAmount = $accountBalance;
                                        } else if ($accountBalance < 0) {
                                            $drAmount = -($accountBalance);
                                        }

                                        $shouldHaveAPaymentJournalEntry = "No";

                                        $payeePayerName = '';

                                        if ($payeePayerId != '' && $payeePayerId != '0') {
                                            $shouldHaveAPaymentJournalEntry = "Yes";

                                            $payeePayer = $this->peoples_model->getById($payeePayerId);
                                            $payeePayerName = $payeePayer[0]->people_name;

                                            $description = 'Opening balance for chart of account : ' . $chartOfAccountName . " : " . $payeePayerName;
                                        } else {
                                            $description = 'Opening balance for chart of account : ' . $chartOfAccountName;
                                        }

                                        $data = array(
                                            'transaction_date' => $openingBalancesDate,
                                            'payee_payer_id' => $payeePayerId,
                                            'should_have_a_payment_journal_entry' => $shouldHaveAPaymentJournalEntry,
                                            'location_id' => $locationId,
                                            'description' => $description,
                                            'remark' => 'OB',
                                            'post_type' => "Direct",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'added'
                                        );

                                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                        if ($drAmount != '0.00') {
                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $chartOfAccountId,
                                                'debit_value' => $drAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                                'credit_value' => $drAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                        }

                                        if ($crAmount != '0.00') {
                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                                'debit_value' => $crAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                            $data = array(
                                                'journal_entry_id' => $journalEntryId,
                                                'transaction_date' => $openingBalancesDate,
                                                'chart_of_account_id' => $chartOfAccountId,
                                                'credit_value' => $crAmount,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                        }
                                    }
                                }
                            }

                            //Calculate Net Profit and Move That to Retained Earnings Account
                            $netProfit = $this->calculateProfitAndLoss('', $financialYearStartDate, $financialYearEndDate, $year, '0', '-- Select --', '', $locationId, "Accrual");

                            $retainedEarningsAccountBalanceList = $accountBalanceList;

                            $netProfitChartOfAccountsProcessor = new Chart_of_accounts_processor();

                            $retainedEarningsChartOfAccountMultiwayTree = $netProfitChartOfAccountsProcessor->prepareChartOfAccountsMultiwayTree($retainedEarningsChartOfAccountId);

                            $retainedEarningsLeafChartOfAccountIds = $netProfitChartOfAccountsProcessor->depthFirstTraversalAndFindLeafChartOfAccounts($retainedEarningsChartOfAccountMultiwayTree);
                            //print_r($leafChartOfAccountIds);die;
                            $retainedEarningsAccountBalanceListFinal = array();

                            foreach ($retainedEarningsAccountBalanceList as $record) {

                                if (in_array($record['chart_of_account_id'], $retainedEarningsLeafChartOfAccountIds)) {

                                    $retainedEarningsAccountBalanceListFinal[] = $record;
                                }
                            }

                            if ($retainedEarningsAccountBalanceListFinal && sizeof($retainedEarningsAccountBalanceListFinal) > 0) {
                                
                                $accountBalance = '0.00';
                                
                                foreach ($retainedEarningsAccountBalanceListFinal as $accountBalanceRow) {

                                    if ($accountBalanceRow['credit_amount'] != '0.00') {
                                        $accountBalance = $accountBalance + $accountBalanceRow['credit_amount'];
                                    } else if ($accountBalanceRow['debit_amount'] != '0.00') {
                                        $accountBalance = $accountBalance - $accountBalanceRow['debit_amount'];
                                    }
                                }
                                
                                $chartOfAccount = $this->chart_of_accounts_model->get($retainedEarningsChartOfAccountId);
                                $chartOfAccountName = $chartOfAccount[0]->text;
                                
                                $drAmount = '0.00';
                                $crAmount = '0.00';

                                if ($accountBalance > 0) {
                                    $crAmount = $accountBalance;
                                } else if ($accountBalance < 0) {
                                    $drAmount = -($accountBalance);
                                }

                                if ($netProfit > 0) {
                                    if ($crAmount != '0.00') {
                                        $crAmount = $crAmount + $netProfit;
                                    } else if ($drAmount != '0.00') {
                                        $drAmount = $drAmount - $netProfit;
                                    }
                                } else if ($netProfit < 0) {
                                    if ($crAmount != '0.00') {
                                        $crAmount = $crAmount + $netProfit;
                                    } else if ($drAmount != '0.00') {
                                        $drAmount = $drAmount - $netProfit;
                                    }
                                }
                                
                                if ($crAmount < 0) {
                                    $drAmount = -($crAmount);
                                    $crAmount = '0.00';
                                }
                                
                                if ($drAmount < 0) {
                                    $crAmount = -($drAmount);
                                    $drAmount = '0.00';
                                }
                                
                                $description = 'Opening balance for chart of account : ' . $chartOfAccountName;

                                $data = array(
                                    'transaction_date' => $openingBalancesDate,
                                    'location_id' => $locationId,
                                    'description' => $description,
                                    'remark' => 'OB',
                                    'post_type' => "Direct",
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );

                                $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                if ($drAmount != '0.00') {
                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $retainedEarningsChartOfAccountId,
                                        'debit_value' => $drAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                        'credit_value' => $drAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                }

                                if ($crAmount != '0.00') {
                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                        'debit_value' => $crAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $retainedEarningsChartOfAccountId,
                                        'credit_value' => $crAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                }
                            } else {
                                $chartOfAccountId = $retainedEarningsChartOfAccountId;

                                $chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
                                $chartOfAccountName = $chartOfAccount[0]->text;

                                $drAmount = '0.00';
                                $crAmount = '0.00';

                                if ($netProfit > 0) {
                                    $crAmount = $netProfit;
                                } else if ($netProfit < 0) {
                                    $drAmount = -($netProfit);
                                }

                                $description = 'Opening balance for chart of account : ' . $chartOfAccountName;

                                $data = array(
                                    'transaction_date' => $openingBalancesDate,
                                    'location_id' => $locationId,
                                    'description' => $description,
                                    'remark' => 'OB',
                                    'post_type' => "Direct",
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );

                                $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                if ($drAmount != '0.00') {
                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $chartOfAccountId,
                                        'debit_value' => $drAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                        'credit_value' => $drAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                }

                                if ($crAmount != '0.00') {
                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $openingBalanceEquityChartOfAccountId,
                                        'debit_value' => $crAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                                    $data = array(
                                        'journal_entry_id' => $journalEntryId,
                                        'transaction_date' => $openingBalancesDate,
                                        'chart_of_account_id' => $chartOfAccountId,
                                        'credit_value' => $crAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                    //Same time add the data to previous years record table.
                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                }
                            }
                        }
                    }
                    
                    $this->journal_entries_model->clearGeneralLedgerByYearEndProcess($openingBalancesDate);
                    
                    $data = array(
                        'year_end_process_status' => "Completed",
                        'year_end_process_user_id' => $this->user_id,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'edited'
                    );

                    $this->financial_year_ends_model->edit($financialYearEndId, $data);
                }
                
                echo 'ok';
            } else {
                echo 'chart_of_accounts_not_configured';
            }
		}
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Admin_View_Financial_Year_Ends_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Financial Year')}</th>
							<th>{$this->lang->line('Financial Year Start Date')}</th>
                            <th>{$this->lang->line('Financial Year End Date')}</th>
							<th>{$this->lang->line('Year End Process Status')}</th>
                            <th>{$this->lang->line('Year End Processed By')}</th>
							<th>{$this->lang->line('Actions')}</th>
						</tr>
					</thead>
					<tbody>";
                            
			$financialYears = $this->financial_year_ends_model->getAll('financial_year_id', 'desc');
            
			if ($financialYears != null) {
                
                $currentDate = date('Y-m-d');
                
				foreach ($financialYears as $row) {
                    
                    $financialYearStartDate = $row->financial_year_start_date;
                    $financialYearEndDate = $row->financial_year_end_date;
                    $yearEndProcessStatus = $row->year_end_process_status;
                    
                    $financialYearStartYear = date('Y', strtotime($financialYearStartDate));
                    $financialYearEndYear = date('Y', strtotime($financialYearEndDate));
                    
                    $financialYear = '';
                    
                    if ($financialYearStartYear == $financialYearEndYear) {
                        $financialYear = $financialYearStartYear;
                    } else {
                        $financialYear = $financialYearStartYear . "/" . $financialYearEndYear;
                    }
                    
                    $yearEndProcessedUserId = $row->year_end_process_user_id;
                    
                    $yearEndProcessedUser = '';
                    
                    if ($yearEndProcessedUserId != '' && $yearEndProcessedUserId != '0') {
                        $user = $this->user_model->getUserById($yearEndProcessedUserId);
                    
                        $peopleId = 0;
                        if ($user && sizeof($user) > 0) {
                            $peopleId = $user[0]->people_id;
                        }

                        $employeeName = '';
                        if ($peopleId != '' && $peopleId != 0) {
                            $employee = $this->peoples_model->getById($peopleId);
                            $yearEndProcessedUser = $employee[0]->people_name;
                        }
                    }
                    
					$html .= "<tr>";
                    $html .= "<td>" . $financialYear . "</td>";
					$html .= "<td>" . $financialYearStartDate . "</td>";
					$html .= "<td>" . $financialYearEndDate . "</td>";
					$html .= "<td>" . $yearEndProcessStatus . "</td>";
                    $html .= "<td>" . $yearEndProcessedUser . "</td>";
					$html .= "<td>
										<div class='text-left'>";
										if(isset($this->data['ACM_Admin_Edit_Financial_Year_Ends_Permissions'])) {
                                            if ($yearEndProcessStatus == "Pending" && $currentDate >= $financialYearEndDate) {
                                                $html.="<a class='btn btn-primary btn-xs get' data-id='{$row->financial_year_id}' title='{$this->lang->line('Process Year End')}' onclick='processYearEndData($row->financial_year_id);'>
                                                    <i class='icon-off'></i>
                                                </a> ";
                                            }
                                        }
					$html .= "			</div>
									</td>";
					$html .= "</tr>";
				}
			}
			$html .= "</tbody>
					</table>
				</div>
			</div>
		</div>";
			echo $html;
		}
	}
    
    public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
    
    public function getChartOfAccountType($chartOfAccountId) {
		
		$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
		$level = $chartOfAccount[0]->level;
		$parentId = $chartOfAccount[0]->parent_id;
			
		while ($level != '1') {
					
			$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
			$level = $chartOfAccount[0]->level;
			$parentId = $chartOfAccount[0]->parent_id;
		}
		
		$chartOfAccountName = $chartOfAccount[0]->text;
		
		return $chartOfAccountName;
	}
    
    public function calculateProfitAndLoss($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod) {
		$profitAndLossRecords = '';
		
		$currentDate = date('Y-m-d');
		
		if ($year == '' || $year == '0') {
			$year = date('Y'); 
		}
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                $currentFinancialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                $currentFinancialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
            } else {
                $currentFinancialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                $currentFinancialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
            }
		}
		
		if ($locationId != '0' && $fromDate != '' && $toDate != '') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, '', $locationId, '', 'Yes', '', 'No');
		} else if ($fromDate != '' && $toDate != '') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, '', '', '', 'Yes', '', 'No');
		}

		if ($locationId != '0' && $reportDate != '' && $year != '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, '', $locationId, '', 'Yes', '', 'No');
		} else if ($locationId == '0' && $reportDate != '' && $year != '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, '', '', '', 'Yes', '', 'No');
		} else if ($locationId != '0' && $year != '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', $locationId, '', 'Yes', '', 'No');
		} else if ($locationId == '0' && $year != '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', '', '', 'Yes', '', 'No');
		} else if ($locationId != '0' && $reportDate != '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, '', $locationId, '', 'Yes', '', 'No');
		}

		if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, trim($weekBreakdown[0]), trim($weekBreakdown[1]), '', $locationId, '', 'Yes', '', 'No');
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, trim($weekBreakdown[0]), trim($weekBreakdown[1]), '', '', '', 'Yes', '', 'No');
		} else if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, '', $locationId, '', 'Yes', '', 'No');
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, '', '', '', 'Yes', '', 'No');
		}

		if ($locationId == '0' && $reportDate != '' && $year == '0' && $month == '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, '', $reportDate, '', '', '', 'Yes', '', 'No');
		}

		if ($profitAndLossRecords != null) {
			
			$profitAndLossRevenueCalculatingConfigurations = $this->system_configurations_model->getReportsProfitAndLossRevenueCalculatingConfigurationData();
			$profitAndLossGrossProfitCalculatingConfigurations = $this->system_configurations_model->getReportsProfitAndLossGrossProfitCalculatingConfigurationData();
			$profitAndLossOperatingActivitiesCalculatingConfigurations = $this->system_configurations_model->getReportsProfitAndLossOperatingActivitiesCalculatingConfigurationData();
			$profitAndLossProfitCalculatingConfigurations = $this->system_configurations_model->getReportsProfitAndLossProfitCalculatingConfigurationData();
			$profitAndLossNetProfitCalculatingConfigurations = $this->system_configurations_model->getReportsProfitAndLossNetProfitCalculatingConfigurationData();
			
			$revenueCalculatingChartOfAccounts =array();
			$grossProfitCalculatingChartOfAccounts =array();
			$operatingActivitiesCalculatingChartOfAccounts =array();
			$profitCalculatingChartOfAccounts =array();
			$netProfitCalculatingChartOfAccounts =array();
			
			$otherCategoriesChartOfAccountsExceptGrossProfitCategory = array();
			$otherCategoriesChartOfAccountsExceptOperatingActivitiesCategory = array();
			$otherCategoriesChartOfAccountsExceptProfitCategory = array();
			$otherCategoriesChartOfAccountsExceptNetProfitCategory = array();
			
			if ($profitAndLossRevenueCalculatingConfigurations) {
				foreach ($profitAndLossRevenueCalculatingConfigurations as $profitAndLossRevenueCalculatingConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRevenueCalculatingConfiguration->config_filed_value);
					$revenueCalculatingChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
			}
			
			if ($profitAndLossGrossProfitCalculatingConfigurations) {
				foreach ($profitAndLossGrossProfitCalculatingConfigurations as $profitAndLossGrossProfitCalculatingConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossGrossProfitCalculatingConfiguration->config_filed_value);
					$grossProfitCalculatingChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
				
				if ($profitAndLossRevenueCalculatingConfigurations) {
					foreach ($profitAndLossRevenueCalculatingConfigurations as $profitAndLossRevenueCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRevenueCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptGrossProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
			}
			
			if ($profitAndLossOperatingActivitiesCalculatingConfigurations) {
				foreach ($profitAndLossOperatingActivitiesCalculatingConfigurations as $profitAndLossOperatingActivitiesCalculatingConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossOperatingActivitiesCalculatingConfiguration->config_filed_value);
					$operatingActivitiesCalculatingChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
				
				if ($profitAndLossRevenueCalculatingConfigurations) {
					foreach ($profitAndLossRevenueCalculatingConfigurations as $profitAndLossRevenueCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRevenueCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptOperatingActivitiesCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
				
				if ($profitAndLossGrossProfitCalculatingConfigurations) {
					foreach ($profitAndLossGrossProfitCalculatingConfigurations as $profitAndLossGrossProfitCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossGrossProfitCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptOperatingActivitiesCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
			}
			
			if ($profitAndLossProfitCalculatingConfigurations) {
				foreach ($profitAndLossProfitCalculatingConfigurations as $profitAndLossProfitCalculatingConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossProfitCalculatingConfiguration->config_filed_value);
					$profitCalculatingChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
				
				if ($profitAndLossRevenueCalculatingConfigurations) {
					foreach ($profitAndLossRevenueCalculatingConfigurations as $profitAndLossRevenueCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRevenueCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
				
				if ($profitAndLossGrossProfitCalculatingConfigurations) {
					foreach ($profitAndLossGrossProfitCalculatingConfigurations as $profitAndLossGrossProfitCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossGrossProfitCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
				
				if ($profitAndLossOperatingActivitiesCalculatingConfigurations) {
					foreach ($profitAndLossOperatingActivitiesCalculatingConfigurations as $profitAndLossOperatingActivitiesCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossOperatingActivitiesCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
			}
			
			if ($profitAndLossNetProfitCalculatingConfigurations) {
				foreach ($profitAndLossNetProfitCalculatingConfigurations as $profitAndLossNetProfitCalculatingConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossNetProfitCalculatingConfiguration->config_filed_value);
					$netProfitCalculatingChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
				
				if ($profitAndLossRevenueCalculatingConfigurations) {
					foreach ($profitAndLossRevenueCalculatingConfigurations as $profitAndLossRevenueCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRevenueCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptNetProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
				
				if ($profitAndLossGrossProfitCalculatingConfigurations) {
					foreach ($profitAndLossGrossProfitCalculatingConfigurations as $profitAndLossGrossProfitCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossGrossProfitCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptNetProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
				
				if ($profitAndLossOperatingActivitiesCalculatingConfigurations) {
					foreach ($profitAndLossOperatingActivitiesCalculatingConfigurations as $profitAndLossOperatingActivitiesCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossOperatingActivitiesCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptNetProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
				
				if ($profitAndLossProfitCalculatingConfigurations) {
					foreach ($profitAndLossProfitCalculatingConfigurations as $profitAndLossProfitCalculatingConfiguration) {
						$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossProfitCalculatingConfiguration->config_filed_value);
						$otherCategoriesChartOfAccountsExceptNetProfitCategory[] = $chartOfAccount[0]->chart_of_account_id;
					}
				}
			}

			$revenueChartOfAccountsTotal = '0';
			$grossProfitChartOfAccountsTotal = '0';
			$operatingActivitiesChartOfAccountsTotal = '0';
			$profitChartOfAccountTotal = '0';
			$netProfitChartOfAccountTotal = '0';
			
			$netProfitCalculatingChartOfAccountDetailExists = false;
			
			//Revenue Details
			foreach ($revenueCalculatingChartOfAccounts as $revenueCalculatingChartOfAccount) {

				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($profitAndLossRecords as $profitAndLossRecord) {

					$revenueChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					$finalChartOfAccountId = '';

					while ($parentId != '1') {
						
						if ($revenueCalculatingChartOfAccount == $profitAndLossRecord['chart_of_account_id'] || $revenueCalculatingChartOfAccount == $parentId) {
							$revenueChartOfAccountFound = true;
							$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
					}

					if ($revenueChartOfAccountFound) {

						$chartOfAccountType = $this->getChartOfAccountType($finalChartOfAccountId);
						
						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['credit_amount'];
								}
							}

							if (!array_key_exists($finalChartOfAccountId, $resultChartOfAccountValues)) {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['debit_amount']);
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['debit_amount']);
									}
								}
							} else {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
									}
								}
							}
						} else {
							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['credit_amount'];
								}
							}

							if ($profitAndLossRecord['debit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
								}
							}
						}
					}
				}

				if (!empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$revenueChartOfAccountsTotal = $revenueChartOfAccountsTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}
			
			//Gross Profit Details
			foreach ($grossProfitCalculatingChartOfAccounts as $grossProfitCalculatingChartOfAccount) {
				
				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($profitAndLossRecords as $profitAndLossRecord) {

					$grossProfitCalculatingChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
					
					while($parentId != '1') {
						
						if (in_array($parentId, $otherCategoriesChartOfAccountsExceptGrossProfitCategory) || in_array($finalChartOfAccountId, $otherCategoriesChartOfAccountsExceptGrossProfitCategory)) {
							break;
						}
						
						if ($grossProfitCalculatingChartOfAccount == $profitAndLossRecord['chart_of_account_id'] || $grossProfitCalculatingChartOfAccount == $parentId) {
							$grossProfitCalculatingChartOfAccountFound = true;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
					}

					if ($grossProfitCalculatingChartOfAccountFound) {
						
						$chartOfAccountType = $this->getChartOfAccountType($finalChartOfAccountId);
						
						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['credit_amount']);
								}
							}

							if (!array_key_exists($finalChartOfAccountId, $resultChartOfAccountValues)) {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['debit_amount']);
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['debit_amount'];
									}
								}
							} else {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
									}
								}
							}
						} else {
							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['credit_amount'];
								}
							}

							if ($profitAndLossRecord['debit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
								}
							}
						}
					}
				}
				
				if (!empty($resultChartOfAccountIds)) {
					$grossProfitCalculatingChartOfAccountDetailExists = true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$grossProfitChartOfAccountsTotal = $grossProfitChartOfAccountsTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			//Operating Activities Details
			foreach ($operatingActivitiesCalculatingChartOfAccounts as $operatingActivitiesCalculatingChartOfAccount) {
				
				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($profitAndLossRecords as $profitAndLossRecord) {

					$operatingActivitiesCalculatingChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
					
					while($parentId != '1') {
						
						if (in_array($parentId, $otherCategoriesChartOfAccountsExceptOperatingActivitiesCategory) || in_array($finalChartOfAccountId, $otherCategoriesChartOfAccountsExceptOperatingActivitiesCategory)) {
							break;
						}
						
						if ($operatingActivitiesCalculatingChartOfAccount == $profitAndLossRecord['chart_of_account_id'] || $operatingActivitiesCalculatingChartOfAccount == $parentId) {
							$operatingActivitiesCalculatingChartOfAccountFound = true;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
					}

					if ($operatingActivitiesCalculatingChartOfAccountFound) {
						
						$chartOfAccountType = $this->getChartOfAccountType($finalChartOfAccountId);

						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['credit_amount'];
								} else {
                                    //Change introduced on 26/11/2020 to fix a bug
									//$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['credit_amount']);
                                    $resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['credit_amount'];
								}
							}

							if (!array_key_exists($finalChartOfAccountId, $resultChartOfAccountValues)) {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['debit_amount'];
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['debit_amount']);
									}
								}
							} else {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
									}
								}
							}
						} else {
							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['credit_amount'];
								}
							}

							if ($profitAndLossRecord['debit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
								}
							}
						}
					}
				}
				
				if (!empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$operatingActivitiesChartOfAccountsTotal = $operatingActivitiesChartOfAccountsTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			//Profit Details
			foreach ($profitCalculatingChartOfAccounts as $profitCalculatingChartOfAccount) {

				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($profitAndLossRecords as $profitAndLossRecord) {

					$profitCalculatingChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;

					while ($parentId != '1') {
						
						if (in_array($parentId, $otherCategoriesChartOfAccountsExceptProfitCategory) || in_array($finalChartOfAccountId, $otherCategoriesChartOfAccountsExceptProfitCategory)) {
							break;
						}
						
						if ($profitCalculatingChartOfAccount == $profitAndLossRecord['chart_of_account_id'] || $profitCalculatingChartOfAccount == $parentId) {
							$profitCalculatingChartOfAccountFound = true;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
					}

					if ($profitCalculatingChartOfAccountFound) {

						$chartOfAccountType = $this->getChartOfAccountType($finalChartOfAccountId);
						
						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['credit_amount']);
								}
							}

							if (!array_key_exists($finalChartOfAccountId, $resultChartOfAccountValues)) {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['debit_amount']);
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['debit_amount'];
									}
								}
							} else {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
									}
								}
							}
						} else {
							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['credit_amount'];
								}
							}

							if ($profitAndLossRecord['debit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
								}
							}
						}
					}
				}

				if (!empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$profitChartOfAccountTotal = $profitChartOfAccountTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			//Net Profit Details
			foreach ($netProfitCalculatingChartOfAccounts as $netProfitCalculatingChartOfAccount) {

				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($profitAndLossRecords as $profitAndLossRecord) {

					$netProfitCalculatingChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($profitAndLossRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;

					while ($parentId != '1') {
						
						if (in_array($parentId, $otherCategoriesChartOfAccountsExceptNetProfitCategory) || in_array($finalChartOfAccountId, $otherCategoriesChartOfAccountsExceptNetProfitCategory)) {
							break;
						}
						
						if ($netProfitCalculatingChartOfAccount == $profitAndLossRecord['chart_of_account_id'] || $netProfitCalculatingChartOfAccount == $parentId) {
							$netProfitCalculatingChartOfAccountFound = true;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
					}

					if ($netProfitCalculatingChartOfAccountFound) {

						$chartOfAccountType = $this->getChartOfAccountType($finalChartOfAccountId);
						
						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['credit_amount']);
								}
							}

							if (!array_key_exists($finalChartOfAccountId, $resultChartOfAccountValues)) {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = -($profitAndLossRecord['debit_amount']);
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $profitAndLossRecord['debit_amount'];
									}
								}
							} else {
								if ($profitAndLossRecord['debit_amount'] > 0) {
									if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
									} else {
										$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
									}
								}
							}
						} else {
							if ($profitAndLossRecord['credit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['credit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['credit_amount'];
								}
							}

							if ($profitAndLossRecord['debit_amount'] > 0) {
								if ($chartOfAccountType == 'Liabilities' || $chartOfAccountType == 'Equity' || $chartOfAccountType == 'Income') {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $profitAndLossRecord['debit_amount'];
								} else {
									$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $profitAndLossRecord['debit_amount'];
								}
							}
						}
					}
				}

				if (!empty($resultChartOfAccountIds)) {
					$netProfitCalculatingChartOfAccountDetailExists = true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$netProfitChartOfAccountTotal = $netProfitChartOfAccountTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($netProfitCalculatingChartOfAccountDetailExists) {
				$netProfit =  $revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal + $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal - $netProfitChartOfAccountTotal;
			} else {
				$netProfit = $revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal + $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal;
			}
		}

		return $netProfit;
	}
}