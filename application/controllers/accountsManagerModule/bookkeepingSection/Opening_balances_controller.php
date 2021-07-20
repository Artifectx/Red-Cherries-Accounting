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

class Opening_balances_controller extends CI_Controller {

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
        $this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
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
		$data_cls['li_class_opening_balances'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

        $openingBalanceEquityChartOfAccount = $this->system_configurations_model->getOpeninngBalanceEquityChartOfAccountConfigurationData();
        
        $openingBalanceEquityChartOfAccountId = '';
        if($openingBalanceEquityChartOfAccount && sizeof($openingBalanceEquityChartOfAccount) > 0) {
            $openingBalanceEquityChartOfAccountId = $openingBalanceEquityChartOfAccount[0]->config_filed_value;
        }
        
		$data['default_row_count_for_table'] = '100'; //TO DO : Make this a system configuration
        
        if ($openingBalanceEquityChartOfAccountId != '' && $openingBalanceEquityChartOfAccountId != '0') {
            $data['is_opening_balance_equity_account_set_in_config_for_opening_balances'] = "Yes";
        } else {
            $data['is_opening_balance_equity_account_set_in_config_for_opening_balances'] = "No";
        }
        
		if(isset($this->data['ACM_Bookkeeping_View_Opening_Balances_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/openingBalances/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}
    
    public function saveOpeningBalances() {
        $locationId = $this->db->escape_str($this->input->post('location_id'));
        $openingBalancesDate = $this->db->escape_str($this->input->post('opening_balance_date'));
        $openingBalancesData = $this->db->escape_str($this->input->post('opening_balance_data'));
        $openingBalanceCount = $this->db->escape_str($this->input->post('opening_balance_count'));
        
        $openingBalanceEquityChartOfAccount = $this->system_configurations_model->getOpeninngBalanceEquityChartOfAccountConfigurationData();
        
        $openingBalanceEquityChartOfAccountId = '';
        if($openingBalanceEquityChartOfAccount && sizeof($openingBalanceEquityChartOfAccount) > 0) {
            $openingBalanceEquityChartOfAccountId = $openingBalanceEquityChartOfAccount[0]->config_filed_value;
        }
        
        $result = '';
        
        if ($openingBalanceCount > 0 && $openingBalancesData && sizeof($openingBalancesData) > 0) {
            for($x = 0; $x < $openingBalanceCount; $x++) {

                if (isset($openingBalancesData[$x])) {
                    $rowCount = sizeof($openingBalancesData[$x][0]);

                    for($y = 1; $y <= $rowCount; $y++) {
                        $glId = $openingBalancesData[$x][0][$y];
                        $chartOfAccountId = $openingBalancesData[$x][1][$y];
                        $payeePayerId = $openingBalancesData[$x][2][$y];
                        $drAmount = $openingBalancesData[$x][3][$y];
                        $crAmount = $openingBalancesData[$x][4][$y];
                        $description = $openingBalancesData[$x][5][$y];
                        
                        $shouldHaveAPaymentJournalEntry = "No";
                        
                        if ($payeePayerId != '' && $payeePayerId != '0') {
                            $shouldHaveAPaymentJournalEntry = "Yes";
                        }
                        
                        if ($glId == '0') {
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

                            if ($drAmount != '') {
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

                            if ($crAmount != '') {
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
                        } else {
                            
                            $glTransaction = $this->journal_entries_model->getGeneralLedgerTransactionsById($glId);
                            $journalEntryId = $glTransaction[0]->journal_entry_id;
                            
                            $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                            
                            $dataHistory = array(
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
                                'remark' => $journalEntry[0]->remark,
                                'post_type' => $journalEntry[0]->post_type,
                                'actioned_user_id' => $journalEntry[0]->actioned_user_id,
                                'action_date' => $journalEntry[0]->action_date,
                                'last_action_status' => $journalEntry[0]->last_action_status
                            );
                            
                            $this->journal_entries_model->addJournalEntryToHistory($dataHistory);
                            
                            $data = array(
                                'transaction_date' => $openingBalancesDate,
                                'payee_payer_id' => $payeePayerId,
                                'location_id' => $locationId,
                                'description' => $description,
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editJournalEntry($journalEntryId, $data);
                            
                            if ($drAmount != '') {
                                
                                $dataHistory = array(
                                    'gl_transaction_id' => $glTransaction[0]->gl_transaction_id,
                                    'transaction_date' => $glTransaction[0]->transaction_date,
                                    'journal_entry_id' => $glTransaction[0]->journal_entry_id,
                                    'prime_entry_book_id' => $glTransaction[0]->prime_entry_book_id,
                                    'chart_of_account_id' => $glTransaction[0]->chart_of_account_id,
                                    'debit_value' => $glTransaction[0]->debit_value,
                                    'credit_value' => $glTransaction[0]->credit_value,
                                    'transaction_complete' => $glTransaction[0]->transaction_complete,
                                    'actioned_user_id' => $glTransaction[0]->actioned_user_id,
                                    'action_date' => $glTransaction[0]->action_date,
                                    'last_action_status' => $glTransaction[0]->last_action_status
                                );

                                $this->journal_entries_model->addGeneralLedgerTransactionToHistory($dataHistory);
                                
                                $data = array(
                                    'transaction_date' => $openingBalancesDate,
                                    'debit_value' => $drAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->journal_entries_model->editGeneralLedgerTransactionById($glId, $data);

                                //Same time add the data to previous years record table.
                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYearById($glId, $data);

                                //Update coresponding credit gl transaction
                                $creditGlEntry = $this->journal_entries_model->getGeneralLedgerTransactionByJournalEntryIdAndChartOfAccountId($journalEntryId, $openingBalanceEquityChartOfAccountId);
                                $creditGlId = $creditGlEntry[0]->gl_transaction_id;
                                
                                $dataHistory = array(
                                    'gl_transaction_id' => $creditGlEntry[0]->gl_transaction_id,
                                    'transaction_date' => $creditGlEntry[0]->transaction_date,
                                    'journal_entry_id' => $creditGlEntry[0]->journal_entry_id,
                                    'prime_entry_book_id' => $creditGlEntry[0]->prime_entry_book_id,
                                    'chart_of_account_id' => $creditGlEntry[0]->chart_of_account_id,
                                    'debit_value' => $creditGlEntry[0]->debit_value,
                                    'credit_value' => $creditGlEntry[0]->credit_value,
                                    'transaction_complete' => $creditGlEntry[0]->transaction_complete,
                                    'actioned_user_id' => $creditGlEntry[0]->actioned_user_id,
                                    'action_date' => $creditGlEntry[0]->action_date,
                                    'last_action_status' => $creditGlEntry[0]->last_action_status
                                );

                                $this->journal_entries_model->addGeneralLedgerTransactionToHistory($dataHistory);
                                
                                $data = array(
                                    'transaction_date' => $openingBalancesDate,
                                    'credit_value' => $drAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->journal_entries_model->editGeneralLedgerTransactionById($creditGlId, $data);

                                //Same time add the data to previous years record table.
                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYearById($creditGlId, $data);
                            }

                            if ($crAmount != '') {
                                
                                $dataHistory = array(
                                    'gl_transaction_id' => $glTransaction[0]->gl_transaction_id,
                                    'transaction_date' => $glTransaction[0]->transaction_date,
                                    'journal_entry_id' => $glTransaction[0]->journal_entry_id,
                                    'prime_entry_book_id' => $glTransaction[0]->prime_entry_book_id,
                                    'chart_of_account_id' => $glTransaction[0]->chart_of_account_id,
                                    'debit_value' => $glTransaction[0]->debit_value,
                                    'credit_value' => $glTransaction[0]->credit_value,
                                    'transaction_complete' => $glTransaction[0]->transaction_complete,
                                    'actioned_user_id' => $glTransaction[0]->actioned_user_id,
                                    'action_date' => $glTransaction[0]->action_date,
                                    'last_action_status' => $glTransaction[0]->last_action_status
                                );

                                $this->journal_entries_model->addGeneralLedgerTransactionToHistory($dataHistory);
                                
                                $data = array(
                                    'transaction_date' => $openingBalancesDate,
                                    'credit_value' => $crAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->journal_entries_model->editGeneralLedgerTransactionById($glId, $data);

                                //Same time add the data to previous years record table.
                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYearById($glId, $data);

                                //Update coresponding credit gl transaction
                                $creditGlEntry = $this->journal_entries_model->getGeneralLedgerTransactionByJournalEntryIdAndChartOfAccountId($journalEntryId, $openingBalanceEquityChartOfAccountId);
                                $creditGlId = $creditGlEntry[0]->gl_transaction_id;
                                
                                $dataHistory = array(
                                    'gl_transaction_id' => $creditGlEntry[0]->gl_transaction_id,
                                    'transaction_date' => $creditGlEntry[0]->transaction_date,
                                    'journal_entry_id' => $creditGlEntry[0]->journal_entry_id,
                                    'prime_entry_book_id' => $creditGlEntry[0]->prime_entry_book_id,
                                    'chart_of_account_id' => $creditGlEntry[0]->chart_of_account_id,
                                    'debit_value' => $creditGlEntry[0]->debit_value,
                                    'credit_value' => $creditGlEntry[0]->credit_value,
                                    'transaction_complete' => $creditGlEntry[0]->transaction_complete,
                                    'actioned_user_id' => $creditGlEntry[0]->actioned_user_id,
                                    'action_date' => $creditGlEntry[0]->action_date,
                                    'last_action_status' => $creditGlEntry[0]->last_action_status
                                );

                                $this->journal_entries_model->addGeneralLedgerTransactionToHistory($dataHistory);
                                
                                $data = array(
                                    'transaction_date' => $openingBalancesDate,
                                    'debit_value' => $crAmount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->journal_entries_model->editGeneralLedgerTransactionById($creditGlId, $data);

                                //Same time add the data to previous years record table.
                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYearById($creditGlId, $data);
                            }
                        }
                    }
                }
            }
            
            $result = 'ok';
        } else {
            $result = 'no_data_to_save';
        }
        
        echo $result;
    }
	
    //get all data
	public function getTableData() {
        
		if(isset($this->data['ACM_Bookkeeping_View_Opening_Balances_Permissions'])) {
			
			$locationId = $this->db->escape_str($this->input->post('location_id'));
            $openingBalanceDate = $this->db->escape_str($this->input->post('opening_balance_date'));
            
            $availableOpeningBalancesList = '';
            $openingBalanceYearList = array();
            $openingBalanceDateList = array();
            
            if ($openingBalanceDate == '') {
                
                $availableOpeningBalancesList = $this->journal_entries_model->getAvailableOpeningBalancesDateList($locationId);

                if ($availableOpeningBalancesList && sizeof($availableOpeningBalancesList) > 0) {
                    
                    $openingBalanceYearCount = 1;
                    
                    foreach ($availableOpeningBalancesList as $availableOpeningBalance) {
                        $transactionDate = $availableOpeningBalance->transaction_date;

                        $year = date('Y', strtotime($transactionDate));

                        $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
                        $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
                        $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
                        $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

                        $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                        if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($transactionDate)) {
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
                        
                        $financialYearStartYear = date('Y', strtotime($financialYearStartDate));
                        $financialYearEndYear = date('Y', strtotime($financialYearEndDate));

                        $financialYear = '';

                        if ($financialYearStartYear == $financialYearEndYear) {
                            $financialYear = $financialYearStartYear;
                        } else {
                            $financialYear = $financialYearStartYear . "/" . $financialYearEndYear;
                        }
                        
                        $openingBalanceYearList[$openingBalanceYearCount] = $financialYear;
                        $openingBalanceDateList[$openingBalanceYearCount] = $transactionDate;
                        
                        $openingBalanceYearCount++;
                    }
                }
            }
            
            $rowCount = 1;
			
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered openingBalancesDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th style='width:25%;'>{$this->lang->line('Chart of Account')}</th>
                                        <th>{$this->lang->line('Payee or Payer')}</th>
										<th>{$this->lang->line('Dr')}</th>
										<th>{$this->lang->line('Cr')}</th>
                                        <th style='width:30%;'>{$this->lang->line('Description')}</th>
                                        <th>{$this->lang->line('Actions')}</th>
									</tr>
								</thead>
								<tbody id='opening_balance_rows'>";
			
            $openingBalancesList = '';
            
            if ($openingBalanceDate != '' || $availableOpeningBalancesList == '') {
                $openingBalancesList = $this->journal_entries_model->getAccountOpeningBalancesForLocation($locationId, $openingBalanceDate);
            }
            
            $drTotal = 0;
            $crTotal = 0;
            
			if ($openingBalancesList != '' && sizeof($openingBalancesList) > 0) {
                
                $openingBalanceEquityChartOfAccount = $this->system_configurations_model->getOpeninngBalanceEquityChartOfAccountConfigurationData();
                
                $openingBalanceEquityChartOfAccountId = '';
                if($openingBalanceEquityChartOfAccount && sizeof($openingBalanceEquityChartOfAccount) > 0) {
                    $openingBalanceEquityChartOfAccountId = $openingBalanceEquityChartOfAccount[0]->config_filed_value;
                }
                
                $openingBalanceDate = $openingBalancesList[0]->transaction_date;
        
                $x = 1;
                
				foreach ($openingBalancesList as $row) {
					
                    $journalEntryId = $row->journal_entry_id;
                    $payeePayerId = $row->payee_payer_id;
                    $glEntries = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);
                    
                    if (!$glEntries) {
                        $glEntries = $this->journal_entries_model->getPreviousYearsGeneralLedgerTransactionsByJournalEntryId($journalEntryId);
                    }
                    
                    if ($glEntries && sizeof($glEntries) > 0) {
                        
                        foreach($glEntries as $glEntry) {
                            if ($glEntry->chart_of_account_id != $openingBalanceEquityChartOfAccountId) {
                                
                                $chartOfAccountOptionList = $this->chart_of_accounts_model->getAllToChartOfAccountsAsDropdownOptionList($glEntry->chart_of_account_id);
                                $payeePayerList = $this->peoples_model->getAllPeoplesAsOptionList("People Name", '', $payeePayerId, false);
                
                                $html .= "<tr id='opening_balance_record_{$x}'>";
                                $html .= "<td>  <input class='form-control' id='gl_id_{$x}' name='gl_id_{$x}' type='hidden' value='{$glEntry->gl_transaction_id}'>
                                                <select class='select2 form-control' id='chart_of_account_id_{$x}' onchange='handleChartOfAccountSelect(this.id);'>
                                                    <option value='' selected='selected'>{$this->lang->line('-- Select --')}</option>";

                                $html .=            $chartOfAccountOptionList;

                                $html .= "      </select>
                                                <div id='chart_of_account_id_{$x}Error' class='red'></div></td>";

                                $html .= "<td>  <select class='select2 form-control' id='payee_payer_{$x}'>
                                                    <option value='' selected='selected'>{$this->lang->line('-- Select --')}</option>";

                                $html .=            $payeePayerList;

                                $html .= "      </select>
                                                <div id='payee_payer_{$x}Error' class='red'></div></td>";

                                if ($glEntry->debit_value != '0.00') {
                                    $html .= "<td>  <input class='form-control' id='dr_amount_{$x}' name='dr_amount_{$x}' type='hidden' value='{$glEntry->debit_value}'>
                                                    <input class='form-control' id='dr_{$x}' type='text' placeholder='Dr Amount' onblur='handleDrAmountAddition(this.id);' value='{$glEntry->debit_value}'>
                                                    <div id='dr_{$x}Error' class='red'></div></td>";
                                                    
                                    $drTotal = $drTotal + $glEntry->debit_value;
                                } else {
                                    $html .= "<td>  <input class='form-control' id='dr_amount_{$x}' name='dr_amount_{$x}' type='hidden'>
                                                    <input class='form-control' id='dr_{$x}' type='text' placeholder='Dr Amount' onblur='handleDrAmountAddition(this.id);'>
                                                    <div id='dr_{$x}Error' class='red'></div></td>";
                                }

                                if ($glEntry->credit_value != '0.00') {
                                    $html .= "<td>  <input class='form-control' id='cr_amount_{$x}' name='cr_amount_{$x}' type='hidden' value='{$glEntry->credit_value}'>
                                                    <input class='form-control' id='cr_{$x}' type='text' placeholder='Cr Amount' onblur='handleCrAmountAddition(this.id);' value='{$glEntry->credit_value}'>
                                                    <div id='cr_{$x}Error' class='red'></div></td>";
                                                    
                                    $crTotal = $crTotal + $glEntry->credit_value;
                                } else {
                                    $html .= "<td>  <input class='form-control' id='cr_amount_{$x}' name='cr_amount_{$x}' type='hidden'>
                                                    <input class='form-control' id='cr_{$x}' type='text' placeholder='Cr Amount' onblur='handleCrAmountAddition(this.id);'>
                                                    <div id='cr_{$x}Error' class='red'></div></td>";
                                }

                                $html .= "<td>  <input class='form-control' id='description_{$x}' type='text' placeholder='Description' value='{$row->description}'>
                                                <div id='description_{$x}Error' class='red'></div></td>";

                                $html .= "<td>  <button class='btn btn-danger save' id='delete_{$x}' onclick='deleteAccountOpeningBalance(this.id);' type='button'>
                                                    <i class='icon-remove'></i>
                                                    {$this->lang->line('Delete')}
                                                </button></td>";

                                $html .= "</tr>";
                                
                                $x++;
                            }
                        }
                    }
                    
                    $rowCount++;
				}
			} else {
                
                $chartOfAccountOptionList = $this->chart_of_accounts_model->getAllToChartOfAccountsAsDropdownOptionList();
                $payeePayerList = $this->peoples_model->getAllPeoplesAsOptionList("People Name", '', '', false);
                
                $x = '';
                
                for($x=1; $x<=24; $x++) {
                    $html .= "<tr id='opening_balance_record_{$x}'>";
					$html .= "<td>  <input class='form-control' id='gl_id_{$x}' name='gl_id_{$x}' type='hidden' value='0'>
                                    <select class='select2 form-control' id='chart_of_account_id_{$x}' onchange='handleChartOfAccountSelect(this.id);'>
                                        <option value='' selected='selected'>{$this->lang->line('-- Select --')}</option>";
                                        
                    $html .=            $chartOfAccountOptionList;
                    
                    $html .= "      </select>
                                    <div id='chart_of_account_id_{$x}Error' class='red'></div></td>";
                                    
                    $html .= "<td>  <select class='select2 form-control' id='payee_payer_{$x}'>
                                        <option value='' selected='selected'>{$this->lang->line('-- Select --')}</option>";
                                        
                    $html .=            $payeePayerList;
                    
                    $html .= "      </select>
                                    <div id='payee_payer_{$x}Error' class='red'></div></td>";
                                    
					$html .= "<td>  <input class='form-control' id='dr_amount_{$x}' name='dr_amount_{$x}' type='hidden'>
                                    <input class='form-control' id='dr_{$x}' type='text' placeholder='Dr Amount' onblur='handleDrAmountAddition(this.id);'>
                                    <div id='dr_{$x}Error' class='red'></div></td>";
                                    
					$html .= "<td>  <input class='form-control' id='cr_amount_{$x}' name='cr_amount_{$x}' type='hidden'>
                                    <input class='form-control' id='cr_{$x}' type='text' placeholder='Cr Amount' onblur='handleCrAmountAddition(this.id);'>
                                    <div id='cr_{$x}Error' class='red'></div></td>";
                                    
                    $html .= "<td>  <input class='form-control' id='description_{$x}' type='text' placeholder='Description'>
                                    <div id='description_{$x}Error' class='red'></div></td>";
                                    
                    $html .= "<td>  <button class='btn btn-danger save' id='delete_{$x}' onclick='deleteAccountOpeningBalance(this.id);' type='button'>
                                        <i class='icon-remove'></i>
                                        {$this->lang->line('Delete')}
                                    </button></td>";
                                        
					$html .= "</tr>";
                }
                
                $rowCount = $x;
            }
            
            $html .= "<tr id='opening_balance_totals'>";
            $html .= "<td style='font-weight:bold;'>{$this->lang->line('Total')}</td>";
            $html .= "<td></td>";
            $html .= "<td id='dr_total'>{$drTotal}</td>";
            $html .= "<td id='cr_total'>{$crTotal}</td>";
            $html .= "<td></td>";
            $html .= "<td></td>";
            $html .= "</tr>";
                
			$html .=    "</tbody>
							</table>
						</div>
					</div>
				</div>";
            
            if ($availableOpeningBalancesList && sizeof($availableOpeningBalancesList) > 0) {
                $result = 'multiple_opening_balance_years';
            } else {
                $result = 'ok';
            }
			
			echo json_encode (array('html' => $html, 'openingBalanceDate' => $openingBalanceDate, 'rowCount' => $rowCount,
                                    'drTotal' => $drTotal, 'crTotal' => $crTotal, 'result' => $result,
                                    'openingBalanceYearList' => $openingBalanceYearList, 'openingBalanceDateList' => $openingBalanceDateList));
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
}