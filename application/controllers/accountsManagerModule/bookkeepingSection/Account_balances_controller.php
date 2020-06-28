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

class Account_balances_controller extends CI_Controller {

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
		$data_cls['li_class_account_balances_list'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration
		
		if(isset($this->data['ACM_Bookkeeping_View_Account_Balance_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/accountBalances/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}
	
	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Account_Balance_Permissions'])) {
			
			$chartOfAccountId = $this->db->escape_str($this->input->post('chart_of_account_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
			
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered accountBalanceDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Chart of Account')}</th>
										<th>{$this->lang->line('Balance Amount')}</th>
									</tr>
								</thead>
								<tbody>";
					
			$currentDate = date('Y-m-d');
			$currentYear = date('Y'); 
			$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
			$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
			$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
			$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

			$currentFinancialYearEndDateToCompare = ($currentYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
			
			if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
				$currentFinancialYearStartDate = $currentYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
				$currentFinancialYearEndDate = ($currentYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
			} else {
				$currentFinancialYearStartDate = ($currentYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
				$currentFinancialYearEndDate = $currentYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
			}
            
            $specialChartOfAccountsToCheckCompletedTransactionsStatus = array();
        
            $chequeInHandChartOfAccount = $this->system_configurations_model->getCashAndCashEquivalentsReportChequeInHandChartOfAccount();

            if ($chequeInHandChartOfAccount[0]->config_filed_value != '0') {
                $specialChartOfAccountsToCheckCompletedTransactionsStatus[] = $chequeInHandChartOfAccount[0]->config_filed_value;
            }
			
			$accountBalanceList = '';
            $doNotUseGroupBy = "Yes";
            
			if ($chartOfAccountId == "0" && $locationId == "0") {
                $accountBalanceList = $this->journal_entries_model->getFilteredJournalEntriesOfParentChartOfAccount($currentFinancialYearStartDate, $currentFinancialYearEndDate, "", "", "", $specialChartOfAccountsToCheckCompletedTransactionsStatus);
				//$accountBalanceList = $this->journal_entries_model->getFilteredJournalEntries("Accrual", $currentFinancialYearStartDate, $currentFinancialYearEndDate, "", "", "", "", $specialChartOfAccountsToCheckCompletedTransactionsStatus, $doNotUseGroupBy);
			} else if ($chartOfAccountId == "0" && $locationId != "0") {
                $accountBalanceList = $this->journal_entries_model->getFilteredJournalEntriesOfParentChartOfAccount($currentFinancialYearStartDate, $currentFinancialYearEndDate, $locationId, "", "", $specialChartOfAccountsToCheckCompletedTransactionsStatus);
				//$accountBalanceList = $this->journal_entries_model->getFilteredJournalEntries("Accrual", $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', $locationId, "", "", $specialChartOfAccountsToCheckCompletedTransactionsStatus, $doNotUseGroupBy);		
			} else if ($chartOfAccountId != "0" && $locationId == "0") {
                $accountBalanceList = $this->journal_entries_model->getFilteredJournalEntriesOfParentChartOfAccount($currentFinancialYearStartDate, $currentFinancialYearEndDate, "", "", "", $specialChartOfAccountsToCheckCompletedTransactionsStatus, $chartOfAccountId);
				//$accountBalanceList = $this->journal_entries_model->getFilteredJournalEntries("Accrual", $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', '', $chartOfAccountId, "", $specialChartOfAccountsToCheckCompletedTransactionsStatus, $doNotUseGroupBy);		
			} else if ($chartOfAccountId != "0" && $locationId != "0") {
                $accountBalanceList = $this->journal_entries_model->getFilteredJournalEntriesOfParentChartOfAccount($currentFinancialYearStartDate, $currentFinancialYearEndDate, $locationId, "", "", $specialChartOfAccountsToCheckCompletedTransactionsStatus, $chartOfAccountId);
				//$accountBalanceList = $this->journal_entries_model->getFilteredJournalEntries("Accrual", $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', $locationId, $chartOfAccountId, "", $specialChartOfAccountsToCheckCompletedTransactionsStatus, $doNotUseGroupBy);		
			} 

			if ($accountBalanceList != null) {
					$trialBalanceConfigurations = $this->system_configurations_model->getReportsTrialBalanceConfigurationData();
					$levelOneChartOfAccounts = $this->chart_of_accounts_model->getLevelOneChartOfAccouts();

					$orderedLevelOneChartOfAccounts = array();
					if ($trialBalanceConfigurations) {
						if (sizeof($trialBalanceConfigurations) != sizeof($levelOneChartOfAccounts)) {
							foreach ($trialBalanceConfigurations as $trialBalanceConfiguration) {
								$chartOfAccount = $this->chart_of_accounts_model->get($trialBalanceConfiguration->config_filed_value);
								$orderedLevelOneChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
							}

							foreach ($levelOneChartOfAccounts as $levelOneChartOfAccount) {
								if (!in_array($levelOneChartOfAccount->chart_of_account_id, $orderedLevelOneChartOfAccounts)) {
									$orderedLevelOneChartOfAccounts[] = $levelOneChartOfAccount->chart_of_account_id;
								}
							}
						} else {
							foreach ($trialBalanceConfigurations as $trialBalanceConfiguration) {
								$chartOfAccount = $this->chart_of_accounts_model->get($trialBalanceConfiguration->config_filed_value);
								$orderedLevelOneChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
							}
						}
					}

					foreach ($orderedLevelOneChartOfAccounts as $orderedLevelOneChartOfAccount) {
						foreach ($accountBalanceList as $accountBalanceRow) {

							$chartOfAccountName = '';
							$levelOneChartOfAccountId = '';

							$chartOfAccount = $this->chart_of_accounts_model->get($accountBalanceRow['chart_of_account_id']);
							$parentId = $chartOfAccount[0]->parent_id;
							$chartOfAccountName = $chartOfAccount[0]->text;

							while($parentId != '1') {
								$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
								$parentId = $chartOfAccount[0]->parent_id;
								$levelOneChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
								$chartOfAccountName = $chartOfAccount[0]->text . " : " . $chartOfAccountName;
							}

							if ($orderedLevelOneChartOfAccount == $chartOfAccount[0]->chart_of_account_id) {
								$accountBalance = '';

								if ($levelOneChartOfAccountId == '2' || $levelOneChartOfAccountId == '5') {
									$accountBalance = $accountBalanceRow['debit_amount'] - $accountBalanceRow['credit_amount'];
								} else if ($levelOneChartOfAccountId == '3' || $levelOneChartOfAccountId == '4' || $levelOneChartOfAccountId == '6') {
									$accountBalance = $accountBalanceRow['credit_amount'] - $accountBalanceRow['debit_amount'];
								}

								$html .= '<tr>';
								$html .= '    <td style="text-align:left; width: 70%">' . $chartOfAccountName . '</td>';
								$html .= '    <td style="text-align:right; width: 30%">' . number_format($accountBalance, 2) . '</td>';
								$html .= "</tr>";
							}
						}
					}
			}
			$html .=    "</tbody>
							</table>
						</div>
					</div>
				</div>";
			
			echo json_encode(array('html' => $html));
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