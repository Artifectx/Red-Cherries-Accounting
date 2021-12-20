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

require_once dirname(__FILE__) . '/../../../libraries/SVGGraph/SVGGraph.php';
require_once dirname(__FILE__) . '/../../../../application/libraries/PHPExcelLibrary/PHPExcel.php';

class Bookkeeping_report_controller extends CI_Controller {
    
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
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/sales_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/customer_return_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/receive_payment_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/payments_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/territories_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->helper('download');

		$this->load->library('common_library/common_functions');

		$this->load->library('Pdf_reports');
		
		$this->export = true;

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);

		$this->monthList = array(1 => 'January', 2=> 'Fenruary', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
								 7 => 'July', 8 => 'August', 9 => 'september', 10 => 'October', 11 => 'November', 12 => 'December');
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
	}

	public function index() {
		//set selected menu

		$data_cls['ul_class_report_section'] = 'in nav nav-stacked';
		$data_cls['li_class_bookkeeping_report'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		if(isset($this->data['ACM_Reports_View_Bookkeeping_Report_Permissions'])) {
			$this->load->view('web/accountsManagerModule/reportsSection/bookkeepingReports/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}
	
	public function printReport() {
		$report = $this->db->escape_str($this->input->post('report'));
		$fromDate = $this->db->escape_str($this->input->post('fromDate'));
		$toDate = $this->db->escape_str($this->input->post('toDate'));
		$year = $this->db->escape_str($this->input->post('yearValue'));
		$month = $this->db->escape_str($this->input->post('monthValue'));
		$week = $this->db->escape_str($this->input->post('weekValue'));
		$generateAs = $this->db->escape_str($this->input->post('generateAs'));
		$locationId = $this->db->escape_str($this->input->post('locationId'));
		$territoryId = $this->db->escape_str($this->input->post('territoryId'));
		$showCancelledSalesNotes = $this->db->escape_str($this->input->post('showCancelledSalesNotes'));
		$detailReport = $this->db->escape_str($this->input->post('detailReport'));

		if ($report == "SalesPaymentDetails") {
			$this->printSalesPaymentDetailsReport($fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $territoryId, $showCancelledSalesNotes, $detailReport);
		}
	}

	// Trial Balance Details Report  //////////////////////////////////////////////////////////////////////////////////////
	public function getTrialBalanceDetailsReport() {
		$html = "";

		$reportDate = $this->db->escape_str($this->input->post('date'));
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$accountingMethod = $this->db->escape_str($this->input->post('accounting_method'));
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));
		$week = $this->db->escape_str($this->input->post('week'));
		$generateAs = $this->db->escape_str($this->input->post('generate_as'));

		$this->generateTrialBalanceReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod);
	}

	public function generateTrialBalanceReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod) {
		$pdf = new Pdf_reports(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(25);
		$pdf->SetPrintHeader(true);

		$html = '';
		$date = '';
		$locationName = '';

		if ($reportDate != '') {
			$date = "As Of " . date_format(date_create($reportDate), "Y-m-d h:i:sa");
		}

		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = "{$this->lang->line('For ')} : {$location[0]->location_name } ";
			}
		}

		if ($locationId != '0' && $fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		} else if ($fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line('For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		}

		if ($locationId != '0' && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if ($locationId == '0' && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if ($locationId != '0' && $year != '0') {
			$date = "{$this->lang->line(' And For Year ')} : {$year} ";
		} else if ($locationId == '0' && $year != '0') {
			$date = "{$this->lang->line('For Year ')} : {$year} ";
		}

		if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$date = "{$this->lang->line(' And For Date Range From ')} : " . trim($weekBreakdown[0]) . " {$this->lang->line(' To ')} : " . trim($weekBreakdown[1]);
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$date = "{$this->lang->line('For Date Range From ')} : " . trim($weekBreakdown[0]) . " {$this->lang->line(' To ')} : " . trim($weekBreakdown[1]);
		} else if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		}

		if ($locationId == '0' && $reportDate != '' && $year == '0' && $month == '0' && $week == '-- Select --') {

		}

		$html .= "<br><p class='text-info'><strong>Trial Balance : </strong>{$locationName} {$date}<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';
			$html.='<th style="text-align:left; width: 70%"><span style="font-weight:bold; font-size:9px">Chart of Account</span></th>';
			$html.='<th style="text-align:center; width: 15%"><span style="font-weight:bold; font-size:9px">Debit Amount</span></th>';
			$html.='<th style="text-align:center; width: 15%"><span style="font-weight:bold; font-size:9px">Credit Amount</span></th>';
		$html.="</tr>
				</thead>";

		$html .= $this->getTrialBalanceDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod);

		$html.="</table>";
		$pdf->writeHTML($html, true, false, true, false, '');

		if (file_exists(dirname(__FILE__) . '/../../../../temporaryFiles/Trial_Balance.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../temporaryFiles/Trial_Balance.pdf');
		}

		$pdf->lastPage();
		$pdf_file_name = dirname(__FILE__) . '/../../../../temporaryFiles/Trial_Balance.pdf';
		$pdf->Output($pdf_file_name, 'FD');
	}

	public function getTrialBalanceDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod){
		$trialBalanceRecords = '';
		$html='';
		
		$currentDate = date('Y-m-d');
		
		if ($year == '' || $year == '0') {
			$currentFinancialYear = date('Y'); 
		}
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($currentFinancialYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $currentFinancialYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($currentFinancialYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			$currentFinancialYearStartDate = ($currentFinancialYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = $currentFinancialYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		}
        
        $onlyCompletedTransactions = '';
        
        if ($accountingMethod == "Cash") {
            $onlyCompletedTransactions = "Yes";
        }

		if ($locationId != '0' && $fromDate != '' && $toDate != '') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, '', $locationId, '', $onlyCompletedTransactions, '', 'No');
		} else if ($fromDate != '' && $toDate != '') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, '', '', '', $onlyCompletedTransactions, '', 'No');
		}

		if ($locationId != '0' && $reportDate != '' && $year != '0') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, '', $locationId, '', $onlyCompletedTransactions, '', 'No');
		} else if ($locationId == '0' && $reportDate != '' && $year != '0') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, '', '', '', $onlyCompletedTransactions, '', 'No');
		} else if ($locationId != '0' && $year != '0') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', $locationId, '', $onlyCompletedTransactions, '', 'No');
		} else if ($locationId == '0' && $year != '0') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', '', '', $onlyCompletedTransactions, '', 'No');
		} else if ($locationId != '0' && $reportDate != '') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, '', $locationId, '', $onlyCompletedTransactions, '', 'No');
		}

		if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries(trim($accountingMethod, $weekBreakdown[0]), trim($weekBreakdown[1]), '', '', $locationId, '', $onlyCompletedTransactions, '', 'No');
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries(trim($accountingMethod, $weekBreakdown[0]), trim($weekBreakdown[1]), '', '', '', '', $onlyCompletedTransactions, '', 'No');
		} else if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, '', $locationId, '', $onlyCompletedTransactions, '', 'No');
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, '', '', '', $onlyCompletedTransactions, '', 'No');
		}

		if ($locationId == '0' && $reportDate != '' && $year == '0' && $month == '0') {
			$trialBalanceRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, '', $reportDate, '', '', '', $onlyCompletedTransactions, '', 'No');
		}

		$debitTotal = 0;
		$creditTotal = 0;
		if ($trialBalanceRecords != null) {
			$html .= '<tbody>';

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
				foreach ($trialBalanceRecords as $trialBalanceRecord) {

					$chartOfAccountName = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($trialBalanceRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					$chartOfAccountName = $chartOfAccount[0]->text;

					while($parentId != '1') {
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$chartOfAccountName = $chartOfAccount[0]->text . " : " . $chartOfAccountName;
					}

					if ($orderedLevelOneChartOfAccount == $chartOfAccount[0]->chart_of_account_id) {
						$debitBalance = '';
						$creditBalance = '';
						
						if ($trialBalanceRecord['debit_amount'] > $trialBalanceRecord['credit_amount']) {
							$debitDifference = $trialBalanceRecord['debit_amount'] - $trialBalanceRecord['credit_amount'];
							$debitBalance = number_format($debitDifference, 2);
							$debitTotal = $debitTotal + $debitDifference;
						} else {
							$creditDifference = $trialBalanceRecord['credit_amount'] - $trialBalanceRecord['debit_amount'];
							$creditBalance = number_format($creditDifference, 2);
							$creditTotal = $creditTotal + $creditDifference;
						}

						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $chartOfAccountName . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . $debitBalance . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . $creditBalance . '</span></td>';
						$html .= "</tr>";
					}
				}
			}

			$html .= '<tr style="line-height:15px;">';
			$html .= '    <td style="text-align:right; width: 70%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total") . '</span></td>';
			$html .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($debitTotal, 2) . '</span></td>';
			$html .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($creditTotal, 2) . '</span></td>';
			$html .= "</tr>";

			$html .= "</tbody>";
		}

		return $html;
	}
	//  End of Trial Balance Details Report  ///////////////////////////////////////////////////////////////////////////////////
	
	// Sales Payment Details Report  //////////////////////////////////////////////////////////////////////////////////////
	public function getSalesPaymentDetailsReport() {
		$html = "";

		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));
		$week = $this->db->escape_str($this->input->post('week'));
		$generateAs = $this->db->escape_str($this->input->post('generate_as'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$territoryId = $this->db->escape_str($this->input->post('territory_id'));
		$showCancelledSalesNotes = $this->db->escape_str($this->input->post('show_cancelled_sales_notes'));
		$detailReport = $this->db->escape_str($this->input->post('details_report'));

		$displayString = "";
		
		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = $location[0]->location_name;
			}
		}
		
		if($territoryId != '0'){
			$territory = $this->territories_model->getById($territoryId);
			if ($territory && sizeof($territory) > 0) {
				$territoryName = $territory[0]->territory_name;
			}
		}
		
		if ($showCancelledSalesNotes == "Yes") {
			$displayString .= $this->lang->line('For Cancelled Sales Notes ');
		}

		if ($fromDate != "" && $toDate != "" && $locationId == '0') {
			$displayString .= $this->lang->line('For Date Range From ') . $fromDate . $this->lang->line(' To ') . $toDate;
			
			if ($territoryId != '0') {
				$displayString .= $this->lang->line(' And For Territory : ') . $territoryName;
			}
		} else if ($fromDate != "" && $toDate != "" && $locationId != '0') {
			$displayString .= $this->lang->line('For Date Range From ') . $fromDate . $this->lang->line(' To ') . $toDate . $this->lang->line(' And For Location : ') . $locationName;
			if ($territoryId != '0') {
				$displayString .= $this->lang->line(' And For Territory : ') . $territoryName;
			}
		}
		
		if ($fromDate == "" && $toDate == "") {
			if ($month != 0) {
				if ($week != "-- Select --") {
					$weekBreakdown = explode(" : ", $week);
					$fromDate = $weekBreakdown[0];
					$toDate = $weekBreakdown[1];
				} else {
					$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

					$fromDate = $year . "-" . $month . "-01";
					$toDate = $year . "-" . $month . "-" . $days;
				}
			} else {
				$fromDate = $year . "-01-01";
				$toDate = $year . "-12-31";
			}

			if ($locationId != '0' && $year != '0' && $month != '0' && $week != '-- Select --') {
				$displayString = "{$this->lang->line('For Date Range From ')} : " . $fromDate . " {$this->lang->line(' To ')} : " . $toDate . $this->lang->line(' And For Location : ') . $locationName;
			} else if ($locationId != '0' && $year != '0' && $month != '0' && $week == '-- Select --') {
				$displayString = "{$this->lang->line('For Date Range From ')} : " . $fromDate . " {$this->lang->line(' To ')} : " . $toDate . $this->lang->line(' And For Location : ') . $locationName;
			} else if ($locationId != '0' && $year != '0' && $month == '0' && $week == '-- Select --') {
				$displayString = "{$this->lang->line('For Date Range From ')} : " . $fromDate . " {$this->lang->line(' To ')} : " . $toDate . $this->lang->line(' And For Location : ') . $locationName;
			} else if ($locationId == '0' && $year != '0' && $month != '0' && $week != '-- Select --') {
				$displayString = "{$this->lang->line('For Date Range From ')} : " . $fromDate . " {$this->lang->line(' To ')} : " . $toDate;
			} else if ($locationId == '0' && $year != '0' && $month != '0' && $week == '-- Select --') {
				$displayString = "{$this->lang->line('For Date Range From ')} : " . $fromDate . " {$this->lang->line(' To ')} : " . $toDate;
			} else if ($locationId == '0' && $year != '0' && $month == '0' && $week == '-- Select --') {
				$displayString = "{$this->lang->line('For Date Range From ')} : " . $fromDate . " {$this->lang->line(' To ')} : " . $toDate;
			}
			
			if ($territoryId != '0') {
				$displayString .= $this->lang->line(' And For Territory : ') . $territoryName;
			}
		}

		if ($detailReport == "Yes") {
			$html .= "<br><p class='text-info'><strong>{$this->lang->line('Sales Note Payment Details ')} : </strong>{$displayString}</p>";
		} else if ($detailReport == "No") {
			$html .= "<br><p class='text-info'><strong>{$this->lang->line('Sales Note Payment Summary ')} : </strong>{$displayString}</p>";
		}

		$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered salesPaymentDetailsDataTable' style='margin-bottom:0;'>
					<thead>";
						if ($this->export==true) {
				$html .= "  <div class='export_btn'>
								Export to
								<button id='download_excel' type='submit' class='btn btn-default btn-xs' title='Excel' name='report_download' 
									value='salesPaymentDetails'>
									<i class='icon-windows'></i>
								</button>
							</div>";
						}
				$html.="<tr>";
							
					$html.="<th>{$this->lang->line('Sales Note No')}</th>";
					$html.="<th>{$this->lang->line('Date')}</th>";
					$html.="<th>{$this->lang->line('Sales Total Amount')}</th>";
					$html.="<th>{$this->lang->line('Discount')}</th>";
					$html.="<th>{$this->lang->line('Free Issue Amount')}</th>";
					$html.="<th>{$this->lang->line('Customer Saleable Return Amount')}</th>";
					$html.="<th>{$this->lang->line('Customer Market Return Amount')}</th>";
					$html.="<th>{$this->lang->line('Total Payable')}</th>";
					
					if ($detailReport == "Yes") {
						$html.="<th>{$this->lang->line('Payment Date')}</th>";
					}
					
					$html.="<th>{$this->lang->line('Cash Payment')}</th>";
					$html.="<th>{$this->lang->line('Cheque Payment')}</th>";
                    $html.="<th>{$this->lang->line('Credit Card Payment')}</th>";
                    $html.="<th>{$this->lang->line('Claimed Customer Returns')}</th>";
					$html.="<th>{$this->lang->line('Credit Payment')}</th>";

				$html.="</tr>
					</thead>
					<tbody>";

		$salesPaymentDetails =  $this->getSalesPaymentDataFromDB($fromDate, $toDate, $locationId, $territoryId, $showCancelledSalesNotes, $detailReport);

		$html.= $salesPaymentDetails[0];

		$html .= "</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
		";

		echo json_encode(array('html' => $html, 'salesNoteGrandTotal' => $salesPaymentDetails['1'],
			 'salesNoteDiscountGrandTotal' => $salesPaymentDetails['2'], 'salesNoteFreeIssueGrandTotal' => $salesPaymentDetails['3'],
			 'salesNoteCashPaymentGrandTotal' => $salesPaymentDetails['4'], 'salesNoteChequePaymentGrandTotal' => $salesPaymentDetails['5'],
             'salesNoteCreditCardPaymentGrandTotal' => $salesPaymentDetails['6'], 'salesNoteClaimedCustomerReturnsGrandTotal' => $salesPaymentDetails['7'],
			 'salesNoteCreditPaymentGrandTotal' => $salesPaymentDetails['8'], 'salesNoteCustomerSaleableReturnGrandTotal' => $salesPaymentDetails['9'],
			 'salesNoteCustomerMarketReturnGrandTotal' => $salesPaymentDetails['10'], 'salesNotePayableGrandTotal' => $salesPaymentDetails['11']));
	}

	public function printSalesPaymentDetailsReport($fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $territoryId, $showCancelledSalesNotes, $detailReport) {
		$pdf = new Pdf_reports("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(30);
		$pdf->SetPrintHeader(true);

		$date = date("Y-m-d h:i:sa");

		$html = "";
		$displayString = "";
		
		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = $location[0]->location_name;
			}
		}
		
		if($territoryId != '0'){
			$territory = $this->territories_model->getById($territoryId);
			if ($territory && sizeof($territory) > 0) {
				$territoryName = $territory[0]->territory_name;
			}
		}
		
		$pdf->SetFont('Helvetica', 'B', 11);
		
		if ($detailReport == "Yes") {
			$html .= "<u><strong>{$this->lang->line('Sales Note Payment Details')}</strong></u><br><br>";
		} else if ($detailReport == "No") {
			$html .= "<u><strong>{$this->lang->line('Sales Note Payment Summary')}</strong></u><br><br>";
		}
		
		if ($showCancelledSalesNotes == "Yes") {
			$displayString .= "<strong>{$this->lang->line('For Cancelled Sales Notes ')}</strong>";
		}

		if ($fromDate != "" && $toDate != "" && $locationId == '0') {
			$displayString .= "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . "<strong>{$this->lang->line(' To ')}</strong>" . $toDate;
			
			if ($territoryId != '0') {
				$displayString .= "<strong>{$this->lang->line(' And For Territory : ')}</strong>" . $territoryName;
			}
		} else if ($fromDate != "" && $toDate != "" && $locationId != '0') {
			$displayString .= "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . "<strong>{$this->lang->line(' To ')}</strong>" . $toDate . "<strong>{$this->lang->line(' And For Location ')}</strong>" . $locationName;
			
			if ($territoryId != '0') {
				$displayString .= "<strong>{$this->lang->line(' And For Territory : ')}</strong>" . $territoryName;
			}
		}
		
		if ($fromDate == "" && $toDate == "") {
			if ($month != 0) {
				if ($week != "-- Select --") {
					$weekBreakdown = explode(" : ", $week);
					$fromDate = $weekBreakdown[0];
					$toDate = $weekBreakdown[1];
				} else {
					$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

					$fromDate = $year . "-" . $month . "-01";
					$toDate = $year . "-" . $month . "-" . $days;
				}
			} else {
				$fromDate = $year . "-01-01";
				$toDate = $year . "-12-31";
			}

			if ($locationId != '0' && $year != '0' && $month != '0' && $week != '-- Select --') {
				$displayString = "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . " <strong>{$this->lang->line(' To ')}</strong>" . $toDate . "<strong>{$this->lang->line(' And For Location ')}</strong>" . $locationName;
			} else if ($locationId != '0' && $year != '0' && $month != '0' && $week == '-- Select --') {
				$displayString = "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . " <strong>{$this->lang->line(' To ')}</strong>" . $toDate  . "<strong>{$this->lang->line(' And For Location ')}</strong>" . $locationName;
			} else if ($locationId != '0' && $year != '0' && $month == '0' && $week == '-- Select --') {
				$displayString = "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . " <strong>{$this->lang->line(' To ')}</strong>" . $toDate  . "<strong>{$this->lang->line(' And For Location ')}</strong>" . $locationName;
			} else if ($locationId == '0' && $year != '0' && $month != '0' && $week != '-- Select --') {
				$displayString = "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . " <strong>{$this->lang->line(' To ')}</strong>" . $toDate;
			} else if ($locationId == '0' && $year != '0' && $month != '0' && $week == '-- Select --') {
				$displayString = "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . " <strong>{$this->lang->line(' To ')}</strong>" . $toDate;
			} else if ($locationId == '0' && $year != '0' && $month == '0' && $week == '-- Select --') {
				$displayString = "<strong>{$this->lang->line('For Date Range From ')}</strong>" . $fromDate . " <strong>{$this->lang->line(' To ')}</strong>" . $toDate;
			}
			
			if ($territoryId != '0') {
				$displayString .= "<strong>{$this->lang->line(' And For Territory : ')}</strong>" . $territoryName;
			}
		}

		$html .= $displayString . "<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table border="0.5" style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Sales Note No").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Date").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Sales Total Amount").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Discount").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Free Issue Amount").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Customer Saleable Return Amount").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Customer Market Return Amount").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Total Payable").'</span></th>';
			
			if ($detailReport == "Yes") {
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
						.$this->lang->line("Payment Date").'</span></th>';
			}
			
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Cash Payment").'</span></th>';
			$html.='<th style="text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Cheque Payment").'</span></th>';
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Credit Card Payment").'</span></th>';
            $html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Claimed Customer Returns").'</span></th>';
            $html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Credit Payment").'</span></th>';
			
		$html.="	</tr>
				</thead>";

		$salesPaymentDetails =  $this->getSalesPaymentDataFromDB($fromDate, $toDate, $locationId, $territoryId, $showCancelledSalesNotes, $detailReport, true);

		$html.= $salesPaymentDetails[0];

		$html.="</table>";
		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->lastPage();
		$pdf_file_name = 'SalesPaymentDetailsReport.pdf';
		$pdf->Output($pdf_file_name, 'I');
	}

	public function getSalesPaymentDataFromDB($fromDate, $toDate, $locationId, $territoryId, $showCancelledSalesNotes, $detailReport, $print=null){
		$html='';

		$salesPayments = $this->sales_note_model->getAllSalesPaymentDetailForDateRange($fromDate, $toDate, $locationId, $territoryId, $showCancelledSalesNotes);

		$salesNoteGrandTotal = "0.00";
		$salesNoteDiscountGrandTotal = "0.00";
		$salesNoteFreeIssueGrandTotal = "0.00";
		$salesNoteCustomerSaleableReturnGrandTotal = "0.00";
		$salesNoteCustomerMarketReturnGrandTotal = "0.00";
		$salesNotePayableGrandTotal = "0.00";
		$salesNoteCashPaymentGrandTotal = "0.00";
		$salesNoteChequePaymentGrandTotal = "0.00";
        $salesNoteCreditCardPaymentGrandTotal = "0.00";
        $salesNoteClaimedCustomerReturnsGrandTotal = "0.00";
        $salesNoteCreditPaymentGrandTotal = "0.00";
		
		$fieldList[] = "Reference No";
		$fieldList[] = "Date";
		$fieldList[] = "Sales Note Total";
		$fieldList[] = "Sales Note Discount Amount";
		$fieldList[] = "Sales Note Free Issue Amount";
		$fieldList[] = "Sales Note Customer Saleable Return Amount";
		$fieldList[] = "Sales Note Customer Market Return Amount";
		$fieldList[] = "Sales Note Total Payable";
		
		if ($detailReport == "Yes") {
			$fieldList[] = "Sales Note Payment Date";
		}
		
		$fieldList[] = "Sales Note Cash Payment Amount";
		$fieldList[] = "Sales Note Cheque Payment Amount";
        $fieldList[] = "Credit Card Payment";
        $fieldList[] = "Claimed Customer Returns";
		$fieldList[] = "Sales Note Credit Payment Amount";
		
		if ($salesPayments != null) {

			$rowCount = 1;
			$colspan = 0;
			$dataForExcelExport = array();
			
			$salesNoteCreditPaymentAmount = 0;
			
			foreach ($salesPayments as $row) {
				
				$paymentDate = "";
				$salesNoteCreditPaymentAmount = $row['amount_payable'];
				
				$salesNoteTotal = $row['sales_amount'];
				$salesNoteDiscount = $row['discount'];
				$salesNoteFreeIssueTotal = $row['free_issue_amount'];
				$salesNoteTotalPayable = $row['amount_payable'];
                $salesNoteStatus = $row['sales_note_status'];
				
				if ($row['cash_amount'] != "") {
					$salesNoteCashPayment = $row['cash_amount'];
				} else {
					$salesNoteCashPayment = "";
				}
				
				if ($row['cheque_amount'] != "") {
					$salesNoteChequePayment = $row['cheque_amount'];
				} else {
					$salesNoteChequePayment = "";
				}
                
                if ($row['credit_card_amount'] != "") {
					$salesNoteCreditCardPayment = $row['credit_card_amount'];
				} else {
					$salesNoteCreditCardPayment = "";
				}
                
                if ($row['claimed_customer_returns'] != "") {
					$salesNoteClaimedCustomerReturns = $row['claimed_customer_returns'];
				} else {
					$salesNoteClaimedCustomerReturns = "";
				}
				
				if ($row['cash_amount'] != "") {
					$salesNoteCreditPaymentAmount = $salesNoteCreditPaymentAmount - $row['cash_amount'];
				} 
				
				if ($row['cheque_amount'] != "") {
					$salesNoteCreditPaymentAmount = $salesNoteCreditPaymentAmount - $row['cheque_amount'];
				}
                
                if ($row['credit_card_amount'] != "") {
					$salesNoteCreditPaymentAmount = $salesNoteCreditPaymentAmount - $row['credit_card_amount'];
				}
                
                $salesNoteCustomerSaleableReturnId = $row['customer_saleable_return_id'];
				$salesNoteCustomerMarketReturnId = $row['customer_market_return_id'];
				
				$salesNoteCustomerSaleableReturn = $this->customer_return_note_model->getCustomerReturnNoteById($salesNoteCustomerSaleableReturnId);
				
				$salesNoteCustomerSaleableReturnAmount = 0;
                if ($salesNoteCustomerSaleableReturn && sizeof($salesNoteCustomerSaleableReturn) > 0) {
                    $salesNoteCustomerSaleableReturnAmount = number_format($salesNoteCustomerSaleableReturn[0]->amount, 2);

                    if ($salesNoteCustomerSaleableReturn[0]->amount != "") {
                        $salesNoteCreditPaymentAmount = $salesNoteCreditPaymentAmount - $salesNoteCustomerSaleableReturn[0]->amount;
                        $salesNoteTotalPayable = $salesNoteTotalPayable - $salesNoteCustomerSaleableReturn[0]->amount;
                    }
                }
				
				$salesNoteCustomerMarketReturn = $this->customer_return_note_model->getCustomerReturnNoteById($salesNoteCustomerMarketReturnId);
				
				$salesNoteCustomerMarketReturnAmount = 0;
                if ($salesNoteCustomerMarketReturn && sizeof($salesNoteCustomerMarketReturn) > 0) {
                    $salesNoteCustomerMarketReturnAmount = number_format($salesNoteCustomerMarketReturn[0]->amount, 2);

                    if ($salesNoteCustomerMarketReturn[0]->amount != "") {
                        $salesNoteCreditPaymentAmount = $salesNoteCreditPaymentAmount - $salesNoteCustomerMarketReturn[0]->amount;
                        $salesNoteTotalPayable = $salesNoteTotalPayable - $salesNoteCustomerMarketReturn[0]->amount;
                    }
                }
                
                if ($row['claimed_customer_returns'] != "") {
                    $salesNoteClaimedCustomerReturns = $salesNoteClaimedCustomerReturns - ($salesNoteCustomerSaleableReturnAmount + $salesNoteCustomerMarketReturnAmount);
					$salesNoteCreditPaymentAmount = $salesNoteCreditPaymentAmount - $salesNoteClaimedCustomerReturns;
				}
				
                if ($salesNoteCreditPaymentAmount < 0.5) {
                    $salesNoteCreditPaymentAmount = "0";
                }
				
				$dataSet = array();

				$html .= '<tr style="line-height:15px;">';

				if ($rowCount == 1) {
					$colspan++;
				}

				if ($print) {
					$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['reference_no'] . '</span></td>';
					$dataSet['reference_no'] = $row['reference_no'];
				} else {
					$html .= '<td><a href="../bookkeepingSection/sales_note_controller/?searchId=' . $row['reference_no'] . '" target="_blank">' . $row['reference_no'] . '</a></td>';
					$dataSet['reference_no'] = $row['reference_no'];
				}
				
				if ($rowCount == 1) {
					$colspan++;
				}

				if ($print) {
					$html .= '<td style="text-align:center;"><span style="font-size:8px">'. $row['date']  .'</span></td>';
					$dataSet['date'] = $row['date'];
				} else {
					$html .= '<td>'. $row['date']  .'</td>';
					$dataSet['date'] = $row['date'];
				}

				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteTotal, 2) . '</span></td>';
					$dataSet['sales_note_total'] = $salesNoteTotal;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteTotal, 2) . '</td>';
					$dataSet['sales_note_total'] = $salesNoteTotal;
				}

				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteDiscount, 2) . '</span></td>';
					$dataSet['sales_note_discount_amount'] = $salesNoteDiscount;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteDiscount, 2) . '</td>';
					$dataSet['sales_note_discount_amount'] = $salesNoteDiscount;
				}

				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteFreeIssueTotal, 2) . '</span></td>';
					$dataSet['sales_note_free_issue_amount'] = $salesNoteFreeIssueTotal;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteFreeIssueTotal, 2) . '</td>';
					$dataSet['sales_note_free_issue_amount'] = $salesNoteFreeIssueTotal;
				}
				
				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $salesNoteCustomerSaleableReturnAmount . '</span></td>';
					$dataSet['sales_note_customer_saleable_return_amount'] = $salesNoteCustomerSaleableReturnAmount;
				} else {
					$html .= '<td style="text-align:right;">' . $salesNoteCustomerSaleableReturnAmount . '</td>';
					$dataSet['sales_note_customer_saleable_return_amount'] = $salesNoteCustomerSaleableReturnAmount;
				}
				
				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $salesNoteCustomerMarketReturnAmount . '</span></td>';
					$dataSet['sales_note_customer_market_return_amount'] = $salesNoteCustomerMarketReturnAmount;
				} else {
					$html .= '<td style="text-align:right;">' . $salesNoteCustomerMarketReturnAmount . '</td>';
					$dataSet['sales_note_customer_market_return_amount'] = $salesNoteCustomerMarketReturnAmount;
				}

				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteTotalPayable, 2) . '</span></td>';
					$dataSet['sales_note_total_payable'] = $salesNoteTotalPayable;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteTotalPayable, 2) . '</td>';
					$dataSet['sales_note_total_payable'] = $salesNoteTotalPayable;
				}

				if ($detailReport == "Yes") {
					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $paymentDate . '</span></td>';
						$dataSet['sales_note_payment_date'] = $paymentDate;
					} else {
						$html .= '<td style="text-align:right;">' . $paymentDate . '</td>';
						$dataSet['sales_note_payment_date'] = $paymentDate;
					}
				}
				
				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteCashPayment, 2) . '</span></td>';
					$dataSet['sales_note_cash_payment_amount'] = $salesNoteCashPayment;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteCashPayment, 2) . '</td>';
					$dataSet['sales_note_cash_payment_amount'] = $salesNoteCashPayment;
				}

				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteChequePayment, 2) . '</span></td>';
					$dataSet['sales_note_cheque_payment_amount'] = $salesNoteChequePayment;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteChequePayment, 2) . '</td>';
					$dataSet['sales_note_cheque_payment_amount'] = $salesNoteChequePayment;
				}
                
                if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteCreditCardPayment, 2) . '</span></td>';
					$dataSet['sales_note_credit_card_payment_amount'] = $salesNoteCreditCardPayment;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteCreditCardPayment, 2) . '</td>';
					$dataSet['sales_note_credit_card_payment_amount'] = $salesNoteCreditCardPayment;
				}
                
                if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteClaimedCustomerReturns, 2) . '</span></td>';
					$dataSet['sales_note_claimed_customer_returns'] = $salesNoteClaimedCustomerReturns;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteClaimedCustomerReturns, 2) . '</td>';
					$dataSet['sales_note_claimed_customer_returns'] = $salesNoteClaimedCustomerReturns;
				}

				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($salesNoteCreditPaymentAmount, 2) . '</span></td>';
					$dataSet['sales_note_credit_payment_amount'] = $salesNoteCreditPaymentAmount;
				} else {
					$html .= '<td style="text-align:right;">' . number_format($salesNoteCreditPaymentAmount, 2) . '</td>';
					$dataSet['sales_note_credit_payment_amount'] = $salesNoteCreditPaymentAmount;
				}

				$html .= "</tr>";

				$dataForExcelExport[] = $dataSet;
                
                if ($detailReport == "Yes") {
                    $salesNoteId = $row['sales_note_id'];
                    $salesNoteReceivePayments = $this->sales_note_model->getSalesNoteReceivePaymentEntries($salesNoteId);
                    
                    if ($salesNoteReceivePayments && sizeof($salesNoteReceivePayments) > 0) {
                        foreach($salesNoteReceivePayments as $salesNoteReceivePayment) {
                            if ($salesNoteReceivePayment->receive_cash_payment_method_id != '0') {
                                $receiveCashPaymentId = $salesNoteReceivePayment->receive_cash_payment_method_id;
                                $receivePaymentMethods = $this->receive_payment_model->getReceivePaymentMethodById($receiveCashPaymentId);
                                
                                if ($receivePaymentMethods && sizeof($receivePaymentMethods) > 0) {
                                    foreach($receivePaymentMethods as $receivePaymentMethod) {
                                        $cashPaymentId = $receivePaymentMethod->cash_payment_id;
                                        
                                        $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
                                        $paymentDate = $cashPayment[0]->date;
                                        $cashPaymentAmount = $cashPayment[0]->amount;
                                        
                                        $dataSet = array();

                                        $html .= '<tr style="line-height:15px;">';

                                        if ($print) {
                                            $html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['reference_no'] . '</span></td>';
                                            $dataSet['reference_no'] = $row['reference_no'];
                                        } else {
                                            $html .= '<td><a href="../bookkeepingSection/sales_note_controller/?searchId=' . $row['reference_no'] . '" target="_blank" style="color: blue;">' . $row['reference_no'] . '</a></td>';
                                            $dataSet['reference_no'] = $row['reference_no'];
                                        }

                                        if ($rowCount == 1) {
                                            $colspan++;
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['date'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['date'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_discount_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_discount_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_free_issue_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_free_issue_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_saleable_return_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_saleable_return_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_market_return_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_market_return_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total_payable'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total_payable'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td style="text-align:right;"><span style="font-size:8px">' . $paymentDate . '</span></td>';
                                            $dataSet['sales_note_payment_date'] = $paymentDate;
                                        } else {
                                            $html .= '<td style="text-align:right; color: blue;">' . $paymentDate . '</td>';
                                            $dataSet['sales_note_payment_date'] = $paymentDate;
                                        }

                                        if ($print) {
                                            $html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($cashPaymentAmount, 2) . '</span></td>';
                                            $dataSet['sales_note_cash_payment_amount'] = $cashPaymentAmount;
                                        } else {
                                            $html .= '<td style="text-align:right; color: blue;">' . number_format($cashPaymentAmount, 2) . '</td>';
                                            $dataSet['sales_note_cash_payment_amount'] = $cashPaymentAmount;
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cheque_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cheque_payment_amount'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_card_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_card_payment_amount'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_claimed_customer_returns'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_claimed_customer_returns'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_payment_amount'] = "";
                                        }

                                        $html .= "</tr>";
                                        
                                        $dataForExcelExport[] = $dataSet;
                                    }
                                }
                            } else if ($salesNoteReceivePayment->receive_cheque_payment_method_id != '0') {
                                $receiveChequePaymentId = $salesNoteReceivePayment->receive_cheque_payment_method_id;
                                $receivePaymentMethods = $this->receive_payment_model->getReceivePaymentMethodById($receiveChequePaymentId);
                                
                                if ($receivePaymentMethods && sizeof($receivePaymentMethods) > 0) {
                                    foreach($receivePaymentMethods as $receivePaymentMethod) {
                                        $chequeId = $receivePaymentMethod->cheque_id;
                                        
                                        if ($salesNoteStatus == "cancelled") {
                                            $incomeCheque = $this->payments_model->getDeletedIncomeChequeById($chequeId);
                                        } else {
                                            $incomeCheque = $this->payments_model->getIncomeChequeById($chequeId);
                                        }
                                        
                                        $paymentDate = $incomeCheque[0]->cheque_date;
                                        $chequePaymentAmount = $incomeCheque[0]->amount;
                                        
                                        $dataSet = array();

                                        $html .= '<tr style="line-height:15px;">';

                                        if ($print) {
                                            $html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['reference_no'] . '</span></td>';
                                            $dataSet['reference_no'] = $row['reference_no'];
                                        } else {
                                            $html .= '<td><a href="../bookkeepingSection/sales_note_controller/?searchId=' . $row['reference_no'] . '" target="_blank" style="color: blue;">' . $row['reference_no'] . '</a></td>';
                                            $dataSet['reference_no'] = $row['reference_no'];
                                        }

                                        if ($rowCount == 1) {
                                            $colspan++;
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['date'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['date'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_discount_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_discount_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_free_issue_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_free_issue_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_saleable_return_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_saleable_return_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_market_return_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_market_return_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total_payable'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total_payable'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td style="text-align:right;"><span style="font-size:8px">' . $paymentDate . '</span></td>';
                                            $dataSet['sales_note_payment_date'] = $paymentDate;
                                        } else {
                                            $html .= '<td style="text-align:right; color: blue;">' . $paymentDate . '</td>';
                                            $dataSet['sales_note_payment_date'] = $paymentDate;
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cash_payment_amount'] = $chequePaymentAmount;
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cash_payment_amount'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($chequePaymentAmount, 2) . '</span></td>';
                                            $dataSet['sales_note_cheque_payment_amount'] = $chequePaymentAmount;
                                        } else {
                                            $html .= '<td style="text-align:right; color: blue;">' . number_format($chequePaymentAmount, 2) . '</td>';
                                            $dataSet['sales_note_cheque_payment_amount'] = $chequePaymentAmount;
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_card_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_card_payment_amount'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_claimed_customer_returns'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_claimed_customer_returns'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_payment_amount'] = "";
                                        }

                                        $html .= "</tr>";
                                        
                                        $dataForExcelExport[] = $dataSet;
                                    }
                                }
                            } else if ($salesNoteReceivePayment->receive_credit_card_payment_method_id != '0') {
                                $receiveCardPaymentId = $salesNoteReceivePayment->receive_credit_card_payment_method_id;
                                $receivePaymentMethods = $this->receive_payment_model->getReceivePaymentMethodById($receiveCardPaymentId);
                                
                                if ($receivePaymentMethods && sizeof($receivePaymentMethods) > 0) {
                                    foreach($receivePaymentMethods as $receivePaymentMethod) {
                                        $cardPaymentId = $receivePaymentMethod->credit_card_payment_id;
                                        
                                        $cardPayment = $this->payments_model->getCardPaymentById($cardPaymentId);
                                        $paymentDate = $cardPayment[0]->date;
                                        $cardPaymentAmount = $cardPayment[0]->amount;
                                        
                                        $dataSet = array();

                                        $html .= '<tr style="line-height:15px;">';

                                        if ($print) {
                                            $html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['reference_no'] . '</span></td>';
                                            $dataSet['reference_no'] = $row['reference_no'];
                                        } else {
                                            $html .= '<td><a href="../bookkeepingSection/sales_note_controller/?searchId=' . $row['reference_no'] . '" target="_blank" style="color: blue;">' . $row['reference_no'] . '</a></td>';
                                            $dataSet['reference_no'] = $row['reference_no'];
                                        }

                                        if ($rowCount == 1) {
                                            $colspan++;
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['date'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['date'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_discount_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_discount_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_free_issue_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_free_issue_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_saleable_return_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_saleable_return_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_market_return_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_customer_market_return_amount'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total_payable'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_total_payable'] = "";
                                        }
                                        
                                        if ($print) {
                                            $html .= '<td style="text-align:right;"><span style="font-size:8px">' . $paymentDate . '</span></td>';
                                            $dataSet['sales_note_payment_date'] = $paymentDate;
                                        } else {
                                            $html .= '<td style="text-align:right; color: blue;">' . $paymentDate . '</td>';
                                            $dataSet['sales_note_payment_date'] = $paymentDate;
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cash_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cash_payment_amount'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cheque_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_cheque_payment_amount'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($cardPaymentAmount, 2) . '</span></td>';
                                            $dataSet['sales_note_credit_card_payment_amount'] = $cardPaymentAmount;
                                        } else {
                                            $html .= '<td style="text-align:right; color: blue;">' . number_format($cardPaymentAmount, 2) . '</td>';
                                            $dataSet['sales_note_credit_card_payment_amount'] = $cardPaymentAmount;
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_claimed_customer_returns'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_claimed_customer_returns'] = "";
                                        }

                                        if ($print) {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_payment_amount'] = "";
                                        } else {
                                            $html .= '<td></td>';
                                            $dataSet['sales_note_credit_payment_amount'] = "";
                                        }

                                        $html .= "</tr>";
                                        
                                        $dataForExcelExport[] = $dataSet;
                                    }
                                }
                            }
                        }
                    }
                }

				$rowCount++;
				
                $salesNoteGrandTotal = $salesNoteGrandTotal + $row['sales_amount'];
                $salesNoteDiscountGrandTotal = $salesNoteDiscountGrandTotal + $row['discount'];
                $salesNoteFreeIssueGrandTotal = $salesNoteFreeIssueGrandTotal + $row['free_issue_amount'];
                $salesNotePayableGrandTotal = $salesNotePayableGrandTotal + $row['amount_payable'];

                if ($salesNoteCustomerSaleableReturn && sizeof($salesNoteCustomerSaleableReturn) > 0) {
                    $salesNotePayableGrandTotal = $salesNotePayableGrandTotal  - $salesNoteCustomerSaleableReturn[0]->amount;
                }

                if ($salesNoteCustomerMarketReturn && sizeof($salesNoteCustomerMarketReturn) > 0) {
                    $salesNotePayableGrandTotal = $salesNotePayableGrandTotal  - $salesNoteCustomerMarketReturn[0]->amount;
                }
				
				if ($row['cash_amount'] != "") {
					$salesNoteCashPaymentGrandTotal = $salesNoteCashPaymentGrandTotal + $row['cash_amount'];
				}
				
				
				if ($row['cheque_amount'] != "") {
					$salesNoteChequePaymentGrandTotal = $salesNoteChequePaymentGrandTotal + $row['cheque_amount'];
				}
                
                if ($row['credit_card_amount'] != "") {
                    $salesNoteCreditCardPaymentGrandTotal = $salesNoteCreditCardPaymentGrandTotal + $row['credit_card_amount'];
                }
                
                if ($row['claimed_customer_returns'] != "") {
                    $salesNoteClaimedCustomerReturnsGrandTotal = $salesNoteClaimedCustomerReturnsGrandTotal + $row['claimed_customer_returns'];
                }
				
				$salesNoteCreditPaymentGrandTotal = $salesNoteCreditPaymentGrandTotal + $salesNoteCreditPaymentAmount;
				
                if ($salesNoteCustomerSaleableReturn && sizeof($salesNoteCustomerSaleableReturn) > 0) {
                    $salesNoteCustomerSaleableReturnGrandTotal = $salesNoteCustomerSaleableReturnGrandTotal + $salesNoteCustomerSaleableReturn[0]->amount;
                }

                if ($salesNoteCustomerMarketReturn && sizeof($salesNoteCustomerMarketReturn) > 0) {
                    $salesNoteCustomerMarketReturnGrandTotal = $salesNoteCustomerMarketReturnGrandTotal + $salesNoteCustomerMarketReturn[0]->amount;
                }
			}

			$salesNoteGrandTotal = number_format($salesNoteGrandTotal, 2);
			$salesNoteDiscountGrandTotal = number_format($salesNoteDiscountGrandTotal, 2);
			$salesNoteFreeIssueGrandTotal = number_format($salesNoteFreeIssueGrandTotal, 2);
			$salesNoteCustomerSaleableReturnGrandTotal = number_format($salesNoteCustomerSaleableReturnGrandTotal, 2);
			$salesNoteCustomerMarketReturnGrandTotal = number_format($salesNoteCustomerMarketReturnGrandTotal, 2);
			$salesNotePayableGrandTotal = number_format($salesNotePayableGrandTotal, 2);
			$salesNoteCashPaymentGrandTotal = number_format($salesNoteCashPaymentGrandTotal, 2);
			$salesNoteChequePaymentGrandTotal = number_format($salesNoteChequePaymentGrandTotal, 2);
            $salesNoteCreditCardPaymentGrandTotal = number_format($salesNoteCreditCardPaymentGrandTotal, 2);
            $salesNoteClaimedCustomerReturnsGrandTotal = number_format($salesNoteClaimedCustomerReturnsGrandTotal, 2);
			$salesNoteCreditPaymentGrandTotal = number_format($salesNoteCreditPaymentGrandTotal, 2);
			
			//echo $colspan;die;
			if ($print) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:right;" colspan="' . $colspan . '"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Grand Total") . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteGrandTotal . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteDiscountGrandTotal . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteFreeIssueGrandTotal . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteCustomerSaleableReturnGrandTotal . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteCustomerMarketReturnGrandTotal . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNotePayableGrandTotal . '</span></td>';
				
				if ($detailReport == "Yes") {
					$html .= '    <td style="text-align:right;"></td>';
				}
				
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteCashPaymentGrandTotal . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteChequePaymentGrandTotal . '</span></td>';
                $html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteCreditCardPaymentGrandTotal . '</span></td>';
                $html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteClaimedCustomerReturnsGrandTotal . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . $salesNoteCreditPaymentGrandTotal . '</span></td>';
				$html .= "</tr>";
			}

			$excelExportData = array('reportHeaders' => $fieldList, 'reportData' => $dataForExcelExport);
			
			if ($showCancelledSalesNotes == "Yes") {
				if ($detailReport == "Yes") {
					$this->exportReportDataToExcel($excelExportData, "Sales_Payment_Details", "Cancelled Sales Note Payment Details Report");
				} else if ($detailReport == "No") {
					$this->exportReportDataToExcel($excelExportData, "Sales_Payment_Details", "Cancelled Sales Note Payment Summary Report");
				}
			} else {
				if ($detailReport == "Yes") {
					$this->exportReportDataToExcel($excelExportData, "Sales_Payment_Details", "Sales Note Payment Details Report");
				} else if ($detailReport == "No") {
					$this->exportReportDataToExcel($excelExportData, "Sales_Payment_Details", "Sales Note Payment Summary Report");
				}
			}
		}

		return array($html, $salesNoteGrandTotal, $salesNoteDiscountGrandTotal, $salesNoteFreeIssueGrandTotal, 
                     $salesNoteCashPaymentGrandTotal, $salesNoteChequePaymentGrandTotal, $salesNoteCreditCardPaymentGrandTotal,
                     $salesNoteClaimedCustomerReturnsGrandTotal, $salesNoteCreditPaymentGrandTotal, 
                     $salesNoteCustomerSaleableReturnGrandTotal, $salesNoteCustomerMarketReturnGrandTotal, $salesNotePayableGrandTotal);
	}
	//  End of Sales Payment Details Report  ////////////////////////////////////////////////////////////////////////////
	
	// Balance Sheet Details Report  //////////////////////////////////////////////////////////////////////////////////////
	public function getBalanceSheetDetailsReport() {
		$html = "";

		$reportDate = $this->db->escape_str($this->input->post('date'));
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$accountingMethod = $this->db->escape_str($this->input->post('accounting_method'));
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));
		$week = $this->db->escape_str($this->input->post('week'));
		$generateAs = $this->db->escape_str($this->input->post('generate_as'));

		$this->generateBalanceSheetReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod);
	}

	public function generateBalanceSheetReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod) {
		$pdf = new Pdf_reports(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(25);
		$pdf->SetPrintHeader(true);

		$html = '';
		$date = '';
		$locationName = '';

		if ($reportDate != '') {
			$date = "As Of " . date_format(date_create($reportDate), "Y-m-d h:i:sa");
		}

		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = "{$this->lang->line('For ')} : {$location[0]->location_name } ";
			}
		}

		if ($locationId != '0' && $fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		} else if ($fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line('For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		}

		if ($locationId != '0' && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if ($locationId == '0' && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if ($locationId != '0' && $year != '0') {
			$date = "{$this->lang->line(' And For Year ')} : {$year} ";
		} else if ($locationId == '0' && $year != '0') {
			$date = "{$this->lang->line('For Year ')} : {$year} ";
		}

		if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$date = "{$this->lang->line(' And For Date Range From ')} : " . trim($weekBreakdown[0]) . " {$this->lang->line(' To ')} : " . trim($weekBreakdown[1]);
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$date = "{$this->lang->line('For Date Range From ')} : " . trim($weekBreakdown[0]) . " {$this->lang->line(' To ')} : " . trim($weekBreakdown[1]);
		} else if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		}

		$html .= "<br><p class='text-info'><strong>{$this->lang->line('Statement of Financial Position')} : </strong>{$locationName} {$date}<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';
			$html.='<th style="text-align:left; width: 70%"><span style="font-weight:bold; font-size:9px">Chart of Account</span></th>';
			$html.='<th style="text-align:center; width: 15%"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Total").'</span></th>';
		$html.="</tr>
				</thead>";

		$html .= $this->getBalanceSheetDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod);

		$html.="</table>";
		$pdf->writeHTML($html, true, false, true, false, '');

		if (file_exists(dirname(__FILE__) . '/../../../../temporaryFiles/Balance_Sheet.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../temporaryFiles/Balance_Sheet.pdf');
		}

		$pdf->lastPage();
		$pdf_file_name = dirname(__FILE__) . '/../../../../temporaryFiles/Balance_Sheet.pdf';
		$pdf->Output($pdf_file_name, 'FD');
	}

	public function getBalanceSheetDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod){
		$balanceSheetRecords = '';
		$html='';
		
		$currentDate = date('Y-m-d');
		
		if ($year == '' || $year == '0') {
			$currentFinancialYear = date('Y'); 
		}
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($currentFinancialYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $currentFinancialYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($currentFinancialYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
            if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                $currentFinancialYearStartDate = ($currentFinancialYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                $currentFinancialYearEndDate = $currentFinancialYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
            } else {
                $currentFinancialYearStartDate = $currentFinancialYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                $currentFinancialYearEndDate = $currentFinancialYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
            }
		}
		
		if ($locationId != '0' && $fromDate != '' && $toDate != '') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, '', $locationId, "", "Yes", "", "No");
		} else if ($fromDate != '' && $toDate != '') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, "", "", "", "Yes", "", "No");
		}

		if ($locationId != '0' && $reportDate != '' && $year != '0') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, '', $locationId,"", "Yes", "", "No");
		} else if ($locationId == '0' && $reportDate != '' && $year != '0') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate,"", "", "", "Yes", "", "No");
		} else if ($locationId != '0' && $year != '0') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $currentFinancialYearEndDate, '', $locationId, "", "Yes", "", "No");
		} else if ($locationId == '0' && $year != '0') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $currentFinancialYearEndDate, "", "", "", "Yes", "", "No");
		} else if ($locationId != '0' && $reportDate != '') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, "", $locationId, "", "Yes", "", "No");
		}

		if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries(trim($accountingMethod, $weekBreakdown[0]), trim($weekBreakdown[1]), "", "", $locationId, "", "", "", "No");
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries(trim($accountingMethod, $weekBreakdown[0]), trim($weekBreakdown[1]), "", "", "", "", "", "", "No");
		} else if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, "", $locationId, "", "", "", "No");
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, "", "", "", "", "", "No");
		}

		if ($locationId == '0' && $reportDate != '' && $year == '0' && $month == '0') {
			$balanceSheetRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, '', $reportDate, "", "", "", "Yes", "", "No");
		}

		if ($balanceSheetRecords != null) {
			$html .= '<tbody>';

			$balanceSheetNonCurrentAssetsConfigurations = $this->system_configurations_model->getReportsBalanceSheetNonCurrentAssetsConfigurationData();
			$balanceSheetCurrentAssetsConfigurations = $this->system_configurations_model->getReportsBalanceSheetCurrentAssetsConfigurationData();
			$balanceSheetEquityConfigurations = $this->system_configurations_model->getReportsBalanceSheetEquityConfigurationData();
			$balanceSheetNonCurrentLiabilitiesConfigurations = $this->system_configurations_model->getReportsBalanceSheetNonCurrentLiabilitiesConfigurationData();
			$balanceSheetCurrentLiabilitiesConfigurations = $this->system_configurations_model->getReportsBalanceSheetCurrentLiabilitiesConfigurationData();
			
			$nonCurrentAssetsChartOfAccounts =array();
			$currentAssetsChartOfAccounts =array();
			$equityChartOfAccounts =array();
			$nonCurrentLiabilitiesChartOfAccounts =array();
			$currentLiabilitiesChartOfAccounts =array();
			
			if ($balanceSheetNonCurrentAssetsConfigurations) {
				foreach ($balanceSheetNonCurrentAssetsConfigurations as $balanceSheetNonCurrentAssetsConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetNonCurrentAssetsConfiguration->config_filed_value);
					$nonCurrentAssetsChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
			}
			
			if ($balanceSheetCurrentAssetsConfigurations) {
				foreach ($balanceSheetCurrentAssetsConfigurations as $balanceSheetCurrentAssetsConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetCurrentAssetsConfiguration->config_filed_value);
					$currentAssetsChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
			}
			
			if ($balanceSheetEquityConfigurations) {
				foreach ($balanceSheetEquityConfigurations as $balanceSheetEquityConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetEquityConfiguration->config_filed_value);
					$equityChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
			}
			
			if ($balanceSheetNonCurrentLiabilitiesConfigurations) {
				foreach ($balanceSheetNonCurrentLiabilitiesConfigurations as $balanceSheetNonCurrentLiabilitiesConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetNonCurrentLiabilitiesConfiguration->config_filed_value);
					$nonCurrentLiabilitiesChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
			}
			
			if ($balanceSheetCurrentLiabilitiesConfigurations) {
				foreach ($balanceSheetCurrentLiabilitiesConfigurations as $balanceSheetCurrentLiabilitiesConfiguration) {
					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetCurrentLiabilitiesConfiguration->config_filed_value);
					$currentLiabilitiesChartOfAccounts[] = $chartOfAccount[0]->chart_of_account_id;
				}
			}

			$nonCurrentAssetsChartOfAccountTotal = '0';
			$currentAssetsChartOfAccountTotal = '0';
			$equityChartOfAccountTotal = '0';
			$nonCurrentLiabilitiesChartOfAccountTotal = '0';
			$currentLiabilitiesChartOfAccountTotal = '0';
			$assetsDetailExists = false;
			$equityAndLiabilitiesDetailExists = false;
			
			$nonCurrentAssetsChartOfAccountDetailExists = false;
			$currentAssetsChartOfAccountDetailExists = false;
			$equityChartOfAccountDetailExists = false;
			$nonCurrentLiabilitiesChartOfAccountDetailExists = false;
			$currentLiabilitiesChartOfAccountDetailExists = false;
			
			//Non-current Assets Details
			foreach ($nonCurrentAssetsChartOfAccounts as $nonCurrentAssetsChartOfAccount) {

				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($balanceSheetRecords as $balanceSheetRecord) {

					$nonCurrentAssetsChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;

					while ($parentId != '1') {
						if ($nonCurrentAssetsChartOfAccount == $parentId) {
							$nonCurrentAssetsChartOfAccountFound = true;
							$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
					}

					if ($nonCurrentAssetsChartOfAccountFound) {

						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $balanceSheetRecord['debit_amount'];
							}

							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['credit_amount'];
							}
						} else {
							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $balanceSheetRecord['debit_amount'];
							}

							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['credit_amount'];
							}
						}
					}
				}

				if (!$nonCurrentAssetsChartOfAccountDetailExists) {
					if (!empty($resultChartOfAccountIds)) {
						$assetsDetailExists = true;
						$nonCurrentAssetsChartOfAccountDetailExists = true;
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("ASSETS") . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Non-current Assets") . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
					}
				}

				if ($nonCurrentAssetsChartOfAccountDetailExists && !empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						$html .= "</tr>";

						$nonCurrentAssetsChartOfAccountTotal = $nonCurrentAssetsChartOfAccountTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($nonCurrentAssetsChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Non-current Assets Total") . '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($nonCurrentAssetsChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			}

			//Current Assets Details
			foreach ($currentAssetsChartOfAccounts as $currentAssetsChartOfAccount) {
				
				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($balanceSheetRecords as $balanceSheetRecord) {

					$currentAssetsChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					
					while($parentId != '1') {
						if ($currentAssetsChartOfAccount == $parentId) {
							$currentAssetsChartOfAccountFound = true;
							$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
					}

					if ($currentAssetsChartOfAccountFound) {
						
						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;
							
							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $balanceSheetRecord['debit_amount'];
							}
							
							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['credit_amount'];
							}
						} else {
							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $balanceSheetRecord['debit_amount'];
							}
							
							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['credit_amount'];
							}
						}
					}
				}
				
				if (!$currentAssetsChartOfAccountDetailExists) {
					if (!empty($resultChartOfAccountIds)) {
						$currentAssetsChartOfAccountDetailExists = true;
						
						if (!$assetsDetailExists) {
							$assetsDetailExists = true;
							
							$html .= '<tr style="line-height:15px;">';
							$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("ASSETS") . '</span></td>';
							$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
							$html .= "</tr>";
						}
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Current Assets") .  '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
					}
				}
				
				if ($currentAssetsChartOfAccountDetailExists && !empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						$html .= "</tr>";

						$currentAssetsChartOfAccountTotal = $currentAssetsChartOfAccountTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($currentAssetsChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Current Assets Total") .  '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($currentAssetsChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			}
			
			if ($nonCurrentAssetsChartOfAccountDetailExists || $currentAssetsChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 1px solid #999; border-bottom: 1px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Assets Total") .  '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 1px solid #999; border-bottom: 1px solid #999;"><span style="font-size:8px">' . number_format($nonCurrentAssetsChartOfAccountTotal + $currentAssetsChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			}

			//Equity Details
			$netProfit = $this->calculateProfitAndLoss($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod);
			$netProfitAddedToReport = false;
			
			foreach ($equityChartOfAccounts as $equityChartOfAccount) {
				
				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($balanceSheetRecords as $balanceSheetRecord) {

					$equityChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;
					
					while($parentId != '1') {
						if ($equityChartOfAccount == $parentId) {
							$equityChartOfAccountFound = true;
							$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
					}

					if ($equityChartOfAccountFound) {
						
						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;
							
							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $balanceSheetRecord['credit_amount'];
							}
							
							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['debit_amount'];
							}
						} else {
							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $balanceSheetRecord['credit_amount'];
							}
							
							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['debit_amount'];
							}
						}
					}
				}
				
				if (!$equityChartOfAccountDetailExists) {
					if (!empty($resultChartOfAccountIds)) {
						$equityAndLiabilitiesDetailExists = true;
						$equityChartOfAccountDetailExists = true;
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("EQUITY AND LIABILITIES") . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Equity") .  '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
					}
				}
				
				if ($equityChartOfAccountDetailExists && !empty($resultChartOfAccountIds)) {
					
					if (!$netProfitAddedToReport) {
						$netProfitAddedToReport = true;
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $this->lang->line("Net Profit") . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($netProfit, 2) . '</span></td>';
						$html .= "</tr>";
						
						$equityChartOfAccountTotal = $equityChartOfAccountTotal + $netProfit;
					}
					
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						$html .= "</tr>";

						$equityChartOfAccountTotal = $equityChartOfAccountTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($equityChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Equity Total") .  '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($equityChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			} else if ($netProfit != '0' && $netProfit != '') {
				$equityAndLiabilitiesDetailExists = true;
						
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("EQUITY AND LIABILITIES") . '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
				$html .= "</tr>";

				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Equity") .  '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
				$html .= "</tr>";
				
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $this->lang->line("Net Profit") . '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($netProfit, 2) . '</span></td>';
				$html .= "</tr>";

				$equityChartOfAccountTotal = $equityChartOfAccountTotal + $netProfit;
				
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Equity Total") .  '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($equityChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			}
			
			//Non-current Liabilities Details
			foreach ($nonCurrentLiabilitiesChartOfAccounts as $nonCurrentLiabilitiesChartOfAccount) {

				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($balanceSheetRecords as $balanceSheetRecord) {

					$nonCurrentLiabilitiesChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;

					while ($parentId != '1') {
						if ($nonCurrentLiabilitiesChartOfAccount == $parentId) {
							$nonCurrentLiabilitiesChartOfAccountFound = true;
							$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
					}

					if ($nonCurrentLiabilitiesChartOfAccountFound) {

						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $balanceSheetRecord['credit_amount'];
							}

							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['debit_amount'];
							}
						} else {
							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $balanceSheetRecord['credit_amount'];
							}

							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['debit_amount'];
							}
						}
					}
				}

				if (!$nonCurrentLiabilitiesChartOfAccountDetailExists) {
					if (!empty($resultChartOfAccountIds)) {
						$nonCurrentLiabilitiesChartOfAccountDetailExists = true;
						
						if (!$equityAndLiabilitiesDetailExists) {
							$equityAndLiabilitiesDetailExists = true;
							$html .= '<tr style="line-height:15px;">';
							$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("EQUITY AND LIABILITIES") . '</span></td>';
							$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
							$html .= "</tr>";
						}
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Non-current Liabilities") . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
					}
				}

				if ($nonCurrentLiabilitiesChartOfAccountDetailExists && !empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						$html .= "</tr>";

						$nonCurrentLiabilitiesChartOfAccountTotal = $nonCurrentLiabilitiesChartOfAccountTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($nonCurrentLiabilitiesChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Non-current Liabilities Total") . '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($nonCurrentLiabilitiesChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			}
			
			//Current Liabilities Details
			foreach ($currentLiabilitiesChartOfAccounts as $currentLiabilitiesChartOfAccount) {

				$resultChartOfAccountIds = array();
				$resultChartOfAccountNames = array();
				$resultChartOfAccountValues = array();
				
				foreach ($balanceSheetRecords as $balanceSheetRecord) {

					$currentLiabilitiesChartOfAccountFound = false;
					$finalChartOfAccount = '';

					$chartOfAccount = $this->chart_of_accounts_model->get($balanceSheetRecord['chart_of_account_id']);
					$parentId = $chartOfAccount[0]->parent_id;

					while ($parentId != '1') {
						if ($currentLiabilitiesChartOfAccount == $parentId) {
							$currentLiabilitiesChartOfAccountFound = true;
							$finalChartOfAccountId = $chartOfAccount[0]->chart_of_account_id;
							$finalChartOfAccount = $this->chart_of_accounts_model->get($finalChartOfAccountId);
							break;
						}
						
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
					}

					if ($currentLiabilitiesChartOfAccountFound) {

						if (!in_array($finalChartOfAccountId, $resultChartOfAccountIds)) {
							$resultChartOfAccountIds[] = $finalChartOfAccountId;
							$resultChartOfAccountNames[$finalChartOfAccountId] = $finalChartOfAccount[0]->text;

							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $balanceSheetRecord['credit_amount'];
							}

							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['debit_amount'];
							}
						} else {
							if ($balanceSheetRecord['credit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] + $balanceSheetRecord['credit_amount'];
							}

							if ($balanceSheetRecord['debit_amount'] > 0) {
								$resultChartOfAccountValues[$finalChartOfAccountId] = $resultChartOfAccountValues[$finalChartOfAccountId] - $balanceSheetRecord['debit_amount'];
							}
						}
					}
				}

				if (!$currentLiabilitiesChartOfAccountDetailExists) {
					if (!empty($resultChartOfAccountIds)) {
						$currentLiabilitiesChartOfAccountDetailExists = true;
						
						if (!$equityAndLiabilitiesDetailExists) {
							$equityAndLiabilitiesDetailExists = true;
							$html .= '<tr style="line-height:15px;">';
							$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("EQUITY AND LIABILITIES") . '</span></td>';
							$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
							$html .= "</tr>";
						}
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Current Liabilities") . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
					}
				}

				if ($currentLiabilitiesChartOfAccountDetailExists && !empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						$html .= "</tr>";

						$currentLiabilitiesChartOfAccountTotal = $currentLiabilitiesChartOfAccountTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($currentLiabilitiesChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Current Liabilities Total") . '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($currentLiabilitiesChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			}
			
			if ($equityChartOfAccountTotal || $nonCurrentLiabilitiesChartOfAccountTotal || $currentLiabilitiesChartOfAccountTotal) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 1px solid #999; border-bottom: 1px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Equity and Liabilities Total") .  '</span></td>';
				$html .= '    <td style="text-align:center; width: 15%; border-top: 1px solid #999; border-bottom: 1px solid #999;"><span style="font-size:8px">' . number_format($equityChartOfAccountTotal + $nonCurrentLiabilitiesChartOfAccountTotal + $currentLiabilitiesChartOfAccountTotal, 2) . '</span></td>';
				$html .= "</tr><br>";
			}
			
			$html .= "</tbody>";
		}

		return $html;
	}
	//  End of Balance sheet Details Report  ///////////////////////////////////////////////////////////////////////////////////

	// Profit and Loss Details Report  //////////////////////////////////////////////////////////////////////////////////////
	public function getProfitAndLossDetailsReport() {
		$html = "";

		$reportDate = $this->db->escape_str($this->input->post('date'));
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$accountingMethod = $this->db->escape_str($this->input->post('accounting_method'));
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));
		$week = $this->db->escape_str($this->input->post('week'));
		$generateAs = $this->db->escape_str($this->input->post('generate_as'));

		$this->generateProfitAndLossReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod);
	}

	public function generateProfitAndLossReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod) {
		$pdf = new Pdf_reports(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(25);
		$pdf->SetPrintHeader(true);

		$html = '';
		$date = '';
		$locationName = '';

		if ($reportDate != '') {
			$date = "As Of " . date_format(date_create($reportDate), "Y-m-d h:i:sa");
		}

		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = "{$this->lang->line('For ')} : {$location[0]->location_name } ";
			}
		}

		if ($locationId != '0' && $fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		} else if ($fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line('For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		}

		if ($locationId != '0' && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if ($locationId == '0' && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if ($locationId != '0' && $year != '0') {
			$date = "{$this->lang->line(' And For Year ')} : {$year} ";
		} else if ($locationId == '0' && $year != '0') {
			$date = "{$this->lang->line('For Year ')} : {$year} ";
		}

		if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$date = "{$this->lang->line(' And For Date Range From ')} : " . trim($weekBreakdown[0]) . " {$this->lang->line(' To ')} : " . trim($weekBreakdown[1]);
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$date = "{$this->lang->line('For Date Range From ')} : " . trim($weekBreakdown[0]) . " {$this->lang->line(' To ')} : " . trim($weekBreakdown[1]);
		} else if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		}

		if ($locationId == '0' && $reportDate != '' && $year == '0' && $month == '0' && $week == '-- Select --') {

		}

		$html .= "<br><p class='text-info'><strong>{$this->lang->line('Income Statement')} : </strong>{$locationName} {$date}<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';
			$html.='<th style="text-align:left; width: 70%"><span style="font-weight:bold; font-size:9px">Chart of Account</span></th>';
			$html.='<th style="text-align:center; width: 15%"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Total").'</span></th>';
		$html.="</tr>
				</thead>";

		$html .= $this->getProfitAndLossDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod);

		$html.="</table>";
		$pdf->writeHTML($html, true, false, true, false, '');

		if (file_exists(dirname(__FILE__) . '/../../../../temporaryFiles/Profit_And_Loss.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../temporaryFiles/Profit_And_Loss.pdf');
		}

		$pdf->lastPage();
		$pdf_file_name = dirname(__FILE__) . '/../../../../temporaryFiles/Profit_And_Loss.pdf';
		$pdf->Output($pdf_file_name, 'FD');
	}

	public function getProfitAndLossDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $week, $generateAs, $locationId, $accountingMethod){
		$profitAndLossRecords = '';
		$html='';
		
		$currentDate = date('Y-m-d');
		
		if ($year == '' || $year == '0') {
			$currentFinancialYear = date('Y'); 
		}
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($currentFinancialYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $currentFinancialYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($currentFinancialYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			$currentFinancialYearStartDate = ($currentFinancialYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = $currentFinancialYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		}

		if ($locationId != '0' && $fromDate != '' && $toDate != '') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, "", $locationId, "", "Yes", "", "No");
		} else if ($fromDate != '' && $toDate != '') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $fromDate, $toDate, "", "", "", "Yes", "", "No");
		}

		if ($locationId != '0' && $reportDate != '' && $year != '0' && $month == '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, "", $locationId, "", "Yes", "", "No");
		} else if ($locationId == '0' && $reportDate != '' && $year != '0' && $month == '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, "", "", "", "Yes", "", "No");
		} else if ($locationId != '0' && $year != '0' && $month == '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $currentFinancialYearEndDate, "", $locationId, "", "Yes", "", "No");
		} else if ($locationId == '0' && $year != '0' && $month == '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $year . $currentFinancialYearEndDate, "", "", "", "Yes", "", "No");
		} else if ($locationId != '0' && $reportDate != '') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $currentFinancialYearStartDate, $reportDate, "", $locationId, "", "Yes", "", "No");
		}

		if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries(trim($accountingMethod, $weekBreakdown[0]), trim($weekBreakdown[1]), "", $locationId, "", "Yes", "", "No");
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week != '-- Select --') {
			$weekBreakdown = explode(":", $week);
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries(trim($accountingMethod, $weekBreakdown[0]), trim($weekBreakdown[1]), "", "", "", "Yes", "", "No");
		} else if ($locationId != '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, "", $locationId, "", "Yes", "", "No");
		} else if ($locationId == '0' && $reportDate == '' && $year != '0' && $month != '0' && $week == '-- Select --') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, $year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, "", "", "", "Yes", "", "No");
		}

		if ($locationId == '0' && $reportDate != '' && $year == '0' && $month == '0') {
			$profitAndLossRecords = $this->journal_entries_model->getFilteredJournalEntries($accountingMethod, "", $reportDate, "", "", "", "Yes", "", "No");
		}

		if ($profitAndLossRecords != null) {
			$html .= '<tbody>';

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
			
            //Following array list help to avoid unnecessary traversing of $profitAndLossRecords
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
			
			$revenueCalculatingChartOfAccountDetailExists = false;
			$grossProfitCalculatingChartOfAccountDetailExists = false;
			$operatingActivitiesCalculatingChartOfAccountDetailExists = false;
			$profitCalculatingChartOfAccountDetailExists = false;
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

				if (!$revenueCalculatingChartOfAccountDetailExists) {
					if (!empty($resultChartOfAccountIds)) {
						$revenueCalculatingChartOfAccountDetailExists = true;
						
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Continuing Operations") . '</span></td>';
						$html .= '    <td style="text-align:center; width: 15%;"><span style="font-size:8px"></span></td>';
						$html .= "</tr>";
					}
				}

				if ($revenueCalculatingChartOfAccountDetailExists && !empty($resultChartOfAccountIds)) {
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						
						if ($resultChartOfAccountValues[$resultChartOfAccountId] < 0) {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">(' . number_format(-($resultChartOfAccountValues[$resultChartOfAccountId]), 2) . ')</span></td>';
						} else {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						}
						
						$html .= "</tr>";

						$revenueChartOfAccountsTotal = $revenueChartOfAccountsTotal + $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($revenueCalculatingChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Revenue") . '</span></td>';
				
				if ($revenueChartOfAccountsTotal < 0) {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">(' . number_format(-($revenueChartOfAccountsTotal), 2) . ')</span></td>';
				} else {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($revenueChartOfAccountsTotal, 2) . '</span></td>';
				}
				
				$html .= "</tr><br>";
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
					$grossProfitCalculatingChartOfAccountDetailExists = true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
                        
                        if (array_key_exists($resultChartOfAccountId, $resultChartOfAccountValues)) {
                            
                            $html .= '<tr style="line-height:15px;">';
                            $html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';

                            if ($resultChartOfAccountValues[$resultChartOfAccountId] < 0) {
                                $html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">(' . number_format(-($resultChartOfAccountValues[$resultChartOfAccountId]), 2) . ')</span></td>';
                            } else {
                                $html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
                            }

                            $html .= "</tr>";

                            $grossProfitChartOfAccountsTotal = $grossProfitChartOfAccountsTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
                        }
					}
				}
			}

			if ($grossProfitCalculatingChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Gross Profit") .  '</span></td>';
				
				if (($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal) < 0) {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">(' . number_format(-($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal), 2) . ')</span></td>';
				} else {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal, 2) . '</span></td>';
				}
				
				$html .= "</tr><br>";
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
					$operatingActivitiesCalculatingChartOfAccountDetailExists =true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						
						if ($resultChartOfAccountValues[$resultChartOfAccountId] < 0) {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">(' . number_format(-($resultChartOfAccountValues[$resultChartOfAccountId]), 2) . ')</span></td>';
						} else {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						}
						$html .= "</tr>";

						$operatingActivitiesChartOfAccountsTotal = $operatingActivitiesChartOfAccountsTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($operatingActivitiesCalculatingChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Results from Operating Activities") .  '</span></td>';
				
				if (($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal) < 0) {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">(' . number_format(-($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal), 2) . ')</span></td>';
				} else {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal, 2) . '</span></td>';
				}
				
				$html .= "</tr><br>";
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
					$profitCalculatingChartOfAccountDetailExists = true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						
						if ($resultChartOfAccountValues[$resultChartOfAccountId] < 0) {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">(' . number_format(-($resultChartOfAccountValues[$resultChartOfAccountId]), 2) . ')</span></td>';
						} else {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						}
						$html .= "</tr>";

						$profitChartOfAccountTotal = $profitChartOfAccountTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($profitCalculatingChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Profit Before Tax") . '</span></td>';
				
				if (($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal) < 0) {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">(' . number_format(-($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal), 2) . ')</span></td>';
				} else {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal, 2) . '</span></td>';
				}
				
				$html .= "</tr><br>";
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
					$netProfitCalculatingChartOfAccountDetailExists = true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$html .= '<tr style="line-height:15px;">';
						$html .= '    <td style="text-align:left; width: 70%"><span style="font-size:8px">' . $resultChartOfAccountNames[$resultChartOfAccountId] . '</span></td>';
						
						if ($resultChartOfAccountValues[$resultChartOfAccountId] < 0) {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format(-($resultChartOfAccountValues[$resultChartOfAccountId]), 2) . '</span></td>';
						} else {
							$html .= '    <td style="text-align:center; width: 15%"><span style="font-size:8px">' . number_format($resultChartOfAccountValues[$resultChartOfAccountId], 2) . '</span></td>';
						}
						
						$html .= "</tr>";

						$netProfitChartOfAccountTotal = $netProfitChartOfAccountTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($netProfitCalculatingChartOfAccountDetailExists) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Net Profit") . '</span></td>';
				
				if (($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal - $netProfitChartOfAccountTotal) < 0) {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">(' . number_format(-($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal - $netProfitChartOfAccountTotal), 2) . ')</span></td>';
				} else {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal - $netProfitChartOfAccountTotal, 2) . '</span></td>';
				}
				
				$html .= "</tr><br>";
			} else {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:left; width: 70%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Net Profit") . '</span></td>';
				
				if (($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal) < 0) {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">(' . number_format(-($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal), 2) . ')</span></td>';
				} else {
					$html .= '    <td style="text-align:center; width: 15%; border-top: 0.5px solid #999; border-bottom: 0.5px solid #999;"><span style="font-size:8px">' . number_format($revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal, 2) . '</span></td>';
				}
				
				$html .= "</tr><br>";
				
				$html .= "<br><br>" . $this->lang->line("Figures in brackets indicates deductions or negative values") . ".";
			}
			
			$html .= "</tbody>";
		}

		return $html;
	}
	//  End of Profit and Loss Details Report  ///////////////////////////////////////////////////////////////////////////////////
	
	// Debtors Details Report  //////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getDebtorsDetailsReport() {
		$html = "";

		$reportDate = $this->db->escape_str($this->input->post('date'));
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));
		$debtorId = $this->db->escape_str($this->input->post('debtor_id'));
        $summaryReport = $this->db->escape_str($this->input->post('summary_report'));
        $salesInvoiceCategory = $this->db->escape_str($this->input->post('sales_invoice_category'));

		$this->generateDebtorsReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $locationId, $debtorId, $summaryReport, $salesInvoiceCategory);
	}

	public function generateDebtorsReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $locationId, $debtorId, $summaryReport, $salesInvoiceCategory) {
		$pdf = new Pdf_reports("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(25);
		$pdf->SetPrintHeader(true);
		$pdf->SetPrintFooter(true);

		$html = '';
		$date = '';
		$locationName = '';
		$debtorName = '';

		if ($reportDate != '') {
			$date = "As Of " . date_format(date_create($reportDate), "Y-m-d h:i:sa");
		}
		
		$debtor = $this->peoples_model->getById($debtorId);
		
		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = "{$this->lang->line('For ')} : {$location[0]->location_name } ";
			}
			
			if ($debtorId != '0') {
				if ($debtor && sizeof($debtor) > 0) {
					$debtorName =  "{$this->lang->line(' And For ')} : {$debtor[0]->people_name } ";
				}
			}
		} else if ($debtorId != '0') {
			if ($debtor && sizeof($debtor) > 0) {
				$debtorName =  "{$this->lang->line('For ')} : {$debtor[0]->people_name } ";
			}
		}
		
		if (($locationId != '0' || $debtorId != '0') && $fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		} else if ($fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line('For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		}

		if (($locationId != '0' || $debtorId != '0') && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if (($locationId == '0' || $debtorId == '0') && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if (($locationId != '0' || $debtorId != '0') && $year != '0') {
			$date = "{$this->lang->line(' And For Year ')} : {$year} ";
		} else if (($locationId == '0' || $debtorId == '0') && $year != '0') {
			$date = "{$this->lang->line('For Year ')} : {$year} ";
		}

		 if (($locationId != '0' || $debtorId != '0') && $reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		} else if (($locationId == '0' || $debtorId == '0') && $reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		}

		$html .= "<br><p class='text-info'><strong>Debtors : </strong>{$locationName} {$debtorName} {$date}<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table border="0.5" style="margin-bottom:0;">';
		$html .="<thead>";
        
		$html .='<tr style="color:#000000; line-height:15px;">';
        
        if ($summaryReport == "No") {
			$html.='<th style="text-align:left; width: 8%"><span style="font-weight:bold; font-size:9px">Date</span></th>';
			$html.='<th style="text-align:left; width: 10%"><span style="font-weight:bold; font-size:9px">Reference Number</span></th>';
			$html.='<th style="text-align:center; width: 14%"><span style="font-weight:bold; font-size:9px">Debtor</span></th>';
			$html.='<th style="text-align:center; width: 18%"><span style="font-weight:bold; font-size:9px">Description</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Amount</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Due Date</span></th>';
			$html.='<th style="text-align:center; width: 18%"><span style="font-weight:bold; font-size:9px">Reference Transaction</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Amount</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Balance</span></th>';
        } else {
            $html.='<th style="text-align:center; width: 60%"><span style="font-weight:bold; font-size:9px">Debtor</span></th>';
            $html.='<th style="text-align:center; width: 40%"><span style="font-weight:bold; font-size:9px">Balance</span></th>';
        }
        
		$html.="</tr>
				</thead>";

		$result = $this->getDebtorsDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $locationId, $debtorId, $summaryReport, $salesInvoiceCategory);
		
		$html .= $result[0];

		$html.="</table>";
		
		$html.= $result[1];
		$pdf->writeHTML($html, true, false, true, false, '');

		if (file_exists(dirname(__FILE__) . '/../../../../temporaryFiles/Debtors.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../temporaryFiles/Debtors.pdf');
		}

		$pdf->lastPage();
		$pdf_file_name = dirname(__FILE__) . '/../../../../temporaryFiles/Debtors.pdf';
		$pdf->Output($pdf_file_name, 'FD');
	}

	public function getDebtorsDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $locationId, $debtorId, $summaryReport, $salesInvoiceCategory) {
		$debtorsRecords = '';
		$html='';
		$htmlSummary = '';
		
		$currentDate = date('Y-m-d');
		
		if ($year == '' || $year == '0') {
			$currentFinancialYear = date('Y'); 
		}
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($currentFinancialYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $currentFinancialYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($currentFinancialYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			$currentFinancialYearStartDate = ($currentFinancialYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = $currentFinancialYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		}

        if ($locationId != '0' && $debtorId != '0' && $fromDate != '' && $toDate != '') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '102', $locationId, $debtorId);
        } else if ($locationId != '0' && $debtorId == '0' && $fromDate != '' && $toDate != '') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '102', $locationId);
        } else if ($locationId == '0' && $debtorId != '0' && $fromDate != '' && $toDate != '') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '102', '', $debtorId);
        } else if ($fromDate != '' && $toDate != '') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '102');
        }

        if ($locationId != '0'  && $debtorId != '0' && $reportDate != '' && $year != '0') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '102', $locationId, $debtorId);
        } else if ($locationId == '0' && $debtorId != '0' && $reportDate != '' && $year != '0') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '102', '', $debtorId);
        } else if ($locationId != '0' && $debtorId == '0' && $reportDate != '' && $year != '0') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '102', $locationId);
        } else if ($locationId != '0' && $debtorId != '0' && $year != '0') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '102', $locationId, $debtorId);
        } else if ($locationId == '0' && $debtorId != '0' && $year != '0') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '102', '', $debtorId);
        } else if ($locationId != '0' && $debtorId == '0' && $year != '0') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '102', $locationId);
        } else if ($locationId != '0' && $debtorId != '0' && $reportDate != '') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '102', $locationId, $debtorId);
        } else if ($locationId == '0' && $debtorId != '0' && $reportDate != '') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '102', '', $debtorId);
        } else if ($locationId != '0' && $debtorId == '0' && $reportDate != '') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '102', $locationId);
        }

        if ($locationId != '0' && $debtorId != '0' && $reportDate == '' && $year != '0' && $month != '0') {
            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '102', $locationId, $debtorId);
        } else if ($locationId == '0' && $debtorId != '0' && $reportDate == '' && $year != '0' && $month != '0') {
            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '102', '', $debtorId);
        } else if ($locationId != '0' && $debtorId == '0' && $reportDate == '' && $year != '0' && $month != '0') {
            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '102', $locationId);
        } else if ($reportDate == '' && $year != '0' && $month != '0') {
            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '102', $locationId);
        }

        if ($locationId == '0' && $debtorId == '0' && $reportDate != '' && $year == '0' && $month == '0') {
            $debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries('', '', 'transaction_date', 'asc', '', $reportDate, '', '102');
        }

		$debtTotal = 0;
		$totalAmountPaid = 0;
		$totalBalanceAmount = 0;
		if ($debtorsRecords != null) {
			$html .= '<tbody>';

            if ($summaryReport == "No") {
                
                foreach ($debtorsRecords as $debtorRecord) {

                    $includeDebtorRecord = false;
                    $journalEntryId = $debtorRecord->journal_entry_id;
                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                    
                    if ($salesInvoiceCategory != '0' && $salesInvoiceCategory != 'a') {
                        $referenceTransactionTypeId = $journalEntry[0]->reference_transaction_type_id;
                        
                        if ($referenceTransactionTypeId == '2') {
                            $referenceTransactionId = $journalEntry[0]->reference_transaction_id;
                            
                            $salesInvoice = $this->sales_invoice_model->getSalesInvoiceById($referenceTransactionId);
                            
                            if ($salesInvoice && sizeof($salesInvoice) >0 && $salesInvoice[0]->sales_invoice_category == $salesInvoiceCategory) {
                                $includeDebtorRecord = true;
                            }
                        }
                    } else {
                        $includeDebtorRecord = true;
                    }
                    
                    if ($includeDebtorRecord) {
                        
                        $chartOfAccountName = '';

                        $payeePayerId = $journalEntry[0]->payee_payer_id;
                        $payeePayer = $this->peoples_model->getById($payeePayerId);

                        $payeePayerName = '';
                        if ($payeePayer && sizeof($payeePayer) > 0) {
                            $payeePayerName = $payeePayer[0]->people_name;
                        }

                        $referenceNumber = $journalEntry[0]->reference_no;
                        $description = $journalEntry[0]->description;
                        $debitAmount = $debtorRecord->debit_value;

                        $dueDate = $journalEntry[0]->due_date;

                        if ($dueDate == '0000-00-00') {
                            $dueDate = '';
                        }

                        if ($debitAmount > 0) {
                            $html .= '<tr style="line-height:15px;">';
                            $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px">' . $debtorRecord->transaction_date . '</span></td>';
                            $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px">' . $referenceNumber . '</span></td>';
                            $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px">' . $payeePayerName . '</span></td>';
                            $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $description . '</span></td>';
                            $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px">' . number_format($debitAmount, 2) . '</span></td>';
                            $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . $dueDate . '</span></td>';

                            $debtTotal = $debtTotal + $debitAmount;

                            $referenceTransactionsList = $this->journal_entries_model->getReferenceJournalEntriesOfAJournalEntry($journalEntryId);

                            $claimReferenceTransactionsList = array();
                        
                            $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                            if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {

                                $journalEntryClaimReferencesAvailable = true;

                                foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                    $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                    $referenceTransaction = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);

                                    if ($referenceTransaction & sizeof($referenceTransaction) > 0) {
                                        $claimReferenceTransactionsList[] = $referenceTransaction[0];
                                    }
                                }
                            }
                            
                            $count = 1;
                            $creditAmountTotal = 0;
                            $balanceAmount = 0;
                            $referenceTransactionsCount = 0;
                            $claimReferenceTransactionsCount = 0;
                            $referenceTransactions = false;
                            $claimReferenceTransactions = false;

                            if ($referenceTransactionsList && sizeof($referenceTransactionsList) > 0) {
                                foreach ($referenceTransactionsList as $referenceTransaction) {
                                    $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                    $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");
                                    
                                    if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                        $referenceTransactions[] = $referenceTransaction;
                                        $referenceTransactionsCount++;
                                    }
                                }
                            }

                            if ($claimReferenceTransactionsList && sizeof($claimReferenceTransactionsList) > 0) {
                                foreach ($claimReferenceTransactionsList as $referenceTransaction) {
                                    $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                    $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");
                                    
                                    if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                        $claimReferenceTransactions[] = $referenceTransaction;
                                        $claimReferenceTransactionsCount++;
                                    }
                                }
                            }

                            $referenceTransactionsCountTotal = $referenceTransactionsCount + $claimReferenceTransactionsCount;
                                
                            $referenceTransactionListed = false;
                            
                            if ($referenceTransactions && sizeof($referenceTransactions) > 0) {
                                
                                foreach ($referenceTransactions as $referenceTransaction) {
                                    
                                    $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                    $referenceTransactionDate = $referenceTransaction->transaction_date;
                                    $referenceTransactionDescription = $referenceTransaction->description;
                                    
                                    $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");
                                    
                                    if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                        
                                        $referenceTransactionListed = true;
                                        
                                        if ($count == 1) {
                                            $balanceAmount = round((float)$debitAmount - (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                            $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->credit_value;

                                            $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                            $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->credit_value, 2) . '</span></td>';

                                            if ($referenceTransactionsCountTotal == $count) {
                                                $html .= '    <td style="text-align:center; width: 8%;" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                            } else {
                                                $html .= '    <td style="text-align:center; width: 8%;"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                            }

                                            $html .= "</tr>";
                                            $creditAmountTotal = (float)$referenceGeneralLedgerEntry[0]->credit_value;
                                        } else {
                                            $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                            $balanceAmount = round($debitAmount - $creditAmountTotal);
                                            $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->credit_value;

                                            $html .= '<tr style="line-height:15px;">';
                                            $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px">' . $referenceTransactionDate . '</span></td>';
                                            $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px"></span></td>';
                                            $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px"></span></td>';
                                            $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                            $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px"></span></td>';
                                            $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                            $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                            $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->credit_value, 2) . '</span></td>';

                                            if ($referenceTransactionsCountTotal == $count) {
                                                $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                            } else {
                                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                            }

                                            $html .= "</tr>";
                                        }

                                        $count++;
                                    }
                                }

                                if ($claimReferenceTransactions && sizeof($claimReferenceTransactions) > 0) {
                                    
                                    foreach ($claimReferenceTransactions as $referenceTransaction) {
                                    
                                        $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                        $referenceTransactionDate = $referenceTransaction->transaction_date;
                                        $referenceTransactionDescription = $referenceTransaction->description;

                                        $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");
                                            
                                        if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                            
                                            $referenceTransactionListed = true;
                                            
                                            if ($count == 1) {

                                                $balanceAmount = round((float)$debitAmount - (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                                $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->credit_value;

                                                $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->credit_value, 2) . '</span></td>';

                                                if ($referenceTransactionsCountTotal == $count) {
                                                    $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                } else {
                                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                }

                                                $html .= "</tr>";
                                            } else {

                                                $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                                $balanceAmount = round($debitAmount - $creditAmountTotal);
                                                $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->credit_value;

                                                $html .= '<tr style="line-height:15px;">';
                                                $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px">' . $referenceTransactionDate . '</span></td>';
                                                $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->credit_value, 2) . '</span></td>';

                                                if ($referenceTransactionsCountTotal == $count) {
                                                    $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                } else {
                                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                }

                                                $html .= "</tr>";
                                            }

                                            $count++;
                                        }
                                    }
                                    
                                    if ($referenceTransactionListed == false) {
                                        $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px;">' . number_format($debitAmount, 2) . '</span></td>';
                                        $html .= "</tr>";
                                    }
                                    
                                    $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                                } else {
                                    
                                    if ($referenceTransactionListed == false) {
                                        $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px;">' . number_format($debitAmount, 2) . '</span></td>';
                                        $html .= "</tr>";
                                    }
                                    
                                    $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                                }
                            } else {
                                
                                if ($claimReferenceTransactions && sizeof($claimReferenceTransactions) > 0) {
                                    
                                    foreach ($claimReferenceTransactions as $referenceTransaction) {
                                    
                                        $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                        $referenceTransactionDate = $referenceTransaction->transaction_date;
                                        $referenceTransactionDescription = $referenceTransaction->description;

                                        $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");
                                        
                                        if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                            
                                            $referenceTransactionListed = true;
                                            
                                            if ($count == 1) {
                                                $balanceAmount = round((float)$debitAmount - (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                                $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->credit_value;

                                                $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->credit_value, 2) . '</span></td>';

                                                if ($referenceTransactionsCountTotal == $count) {
                                                    $html .= '    <td style="text-align:center; width: 8%;" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                } else {
                                                    $html .= '    <td style="text-align:center; width: 8%;"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                }

                                                $html .= "</tr>";
                                                $creditAmountTotal = (float)$referenceGeneralLedgerEntry[0]->credit_value;
                                            } else {
                                                $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                                $balanceAmount = round($debitAmount - $creditAmountTotal);
                                                $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->credit_value;

                                                $html .= '<tr style="line-height:15px;">';
                                                $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px">' . $referenceTransactionDate . '</span></td>';
                                                $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                                $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->credit_value, 2) . '</span></td>';

                                                if ($referenceTransactionsCountTotal == $count) {
                                                    $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                } else {
                                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                                }

                                                $html .= "</tr>";
                                            }

                                            $count++;
                                        }
                                    }
                                    
                                    if ($referenceTransactionListed == false) {
                                        $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px;">' . number_format($debitAmount, 2) . '</span></td>';
                                        $html .= "</tr>";
                                    }
                                    
                                    $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                                } else {
                                    $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px;">' . number_format($debitAmount, 2) . '</span></td>';
                                    $html .= "</tr>";

                                    $totalBalanceAmount = $totalBalanceAmount + $debitAmount;
                                }
                            }
                        }
                    }
                }

                $html .= "</tbody>";

                $htmlSummary .= '<br><br>';
                $htmlSummary .= '<table border="0.5" style="margin-bottom:0;">';
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Debt Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($debtTotal, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Amount Paid") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($totalAmountPaid, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Balance Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($totalBalanceAmount, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<table>';
            } else {
                
                $debtorBalances = array();
                
                foreach ($debtorsRecords as $debtorRecord) {

                    $includeDebtorRecord = false;
                    $journalEntryId = $debtorRecord->journal_entry_id;
                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                    
                    if ($salesInvoiceCategory != '0' && $salesInvoiceCategory != 'a') {
                        $referenceTransactionTypeId = $journalEntry[0]->reference_transaction_type_id;
                        
                        if ($referenceTransactionTypeId == '5') {
                            $referenceTransactionId = $journalEntry[0]->reference_transaction_id;
                            
                            $salesInvoice = $this->sales_invoice_model->getSalesInvoiceById($referenceTransactionId);
                            
                            if ($salesInvoice && sizeof($salesInvoice) >0 && $salesInvoice[0]->sales_invoice_category == $salesInvoiceCategory) {
                                $includeDebtorRecord = true;
                            }
                        }
                    } else {
                        $includeDebtorRecord = true;
                    }
                    
                    if ($includeDebtorRecord) {
                        
                        $chartOfAccountName = '';
                        $payeePayerId = $journalEntry[0]->payee_payer_id;

                        $debitAmount = $debtorRecord->debit_value;

                        if ($debitAmount > 0) {

                            $debtTotal = $debtTotal + $debitAmount;

                            $referenceTransactions = $this->journal_entries_model->getReferenceJournalEntriesOfAJournalEntry($journalEntryId);

                            $claimReferenceTransactions = false;
                        
                            $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                            if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {

                                $journalEntryClaimReferencesAvailable = true;

                                foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                    $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                    $referenceTransaction = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);

                                    if ($referenceTransaction && sizeof($referenceTransaction) > 0) {
                                        $claimReferenceTransactions[] = $referenceTransaction[0];
                                    }
                                }
                            }
                            
                            if ($referenceTransactions && sizeof($referenceTransactions) > 0) {
                                $count = 1;
                                $creditAmountTotal = 0;
                                $balanceAmount = 0;
                                $referenceTransactionConsidered = false;

                                foreach ($referenceTransactions as $referenceTransaction) {
                                    $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                    $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");
                                    
                                    if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                        
                                        $referenceTransactionConsidered = true;
                                        
                                        if ($count == 1) {
                                            $balanceAmount = round((float)$debitAmount - (float)$referenceGeneralLedgerEntry[0]->credit_value);

                                            $creditAmountTotal = (float)$referenceGeneralLedgerEntry[0]->credit_value;
                                        } else {
                                            $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                            $balanceAmount = round($debitAmount - $creditAmountTotal);
                                        }
                                        
                                        $count++;
                                    }
                                }
                                
                                if ($claimReferenceTransactions && sizeof($claimReferenceTransactions) > 0) {
                                    foreach ($claimReferenceTransactions as $referenceTransaction) {
                                        $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                        $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");

                                        if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                            
                                            $referenceTransactionConsidered = true;
                                            
                                            $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                            $balanceAmount = round($balanceAmount - $creditAmountTotal);
                                        }
                                    }
                                }
                                
                                if ($referenceTransactionConsidered == false) {
                                    $balanceAmount = $debitAmount;
                                }

                                if (array_key_exists($payeePayerId, $debtorBalances)) {
                                    $debtorBalances[$payeePayerId] = $debtorBalances[$payeePayerId] + $balanceAmount;
                                } else {
                                    $debtorBalances[$payeePayerId] = $balanceAmount;
                                }

                                $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                            } else {

                                if ($claimReferenceTransactions && sizeof($claimReferenceTransactions) > 0) {
                                    
                                    $creditAmountTotal = 0;
                                    $balanceAmount = 0;
                                    $referenceTransactionConsidered = false;
                                    
                                    foreach ($claimReferenceTransactions as $referenceTransaction) {
                                        $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                        $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '102', "Yes");

                                        if ($referenceGeneralLedgerEntry && sizeof($referenceGeneralLedgerEntry) > 0) {
                                            
                                            $referenceTransactionConsidered = true;
                                            
                                            if ($count == 1) {
                                                $balanceAmount = round((float)$debitAmount - (float)$referenceGeneralLedgerEntry[0]->credit_value);

                                                $creditAmountTotal = (float)$referenceGeneralLedgerEntry[0]->credit_value;
                                            } else {
                                                $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->credit_value);
                                                $balanceAmount = round($debitAmount - $creditAmountTotal);
                                            }

                                            $count++;
                                        }
                                    }
                                    
                                    if ($referenceTransactionConsidered == false) {
                                        $balanceAmount = $debitAmount;
                                        
                                        if (array_key_exists($payeePayerId, $debtorBalances)) {
                                            $debtorBalances[$payeePayerId] = $debtorBalances[$payeePayerId] + $balanceAmount;
                                        } else {
                                            $debtorBalances[$payeePayerId] = $balanceAmount;
                                        }
                                    } else {
                                        if (array_key_exists($payeePayerId, $debtorBalances)) {
                                            $debtorBalances[$payeePayerId] = $debtorBalances[$payeePayerId] + $balanceAmount;
                                        } else {
                                            $debtorBalances[$payeePayerId] = $balanceAmount;
                                        }
                                    }
                                } else {
                                    $balanceAmount = $debitAmount;
                                    
                                    if (array_key_exists($payeePayerId, $debtorBalances)) {
                                        $debtorBalances[$payeePayerId] = $debtorBalances[$payeePayerId] + $debitAmount;
                                    } else {
                                        $debtorBalances[$payeePayerId] = $debitAmount;
                                    }
                                }

                                $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                            }
                        }
                    }
                }
                
                foreach($debtorBalances as $key => $balance) {
                    
                    if ($balance > 0) {
                        $payeePayer = $this->peoples_model->getById($key);

                        $payeePayerName = '';
                        if ($payeePayer && sizeof($payeePayer) > 0) {
                            $payeePayerName = $payeePayer[0]->people_name;
                        }

                        $html .= '<tr style="line-height:15px;">';
                        $html .= '    <td style="text-align:left; width: 60%"><span style="font-size:8px">' . $payeePayerName . '</span></td>';
                        $html .= '    <td style="text-align:center; width: 40%;" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balance, 2) . '</span></td>';
                        $html .= "</tr>";
                    }
                }

                $html .= "</tbody>";

                $htmlSummary .= '<br><br>';
                $htmlSummary .= '<table border="0.5" style="margin-bottom:0;">';
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Balance Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($totalBalanceAmount, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<table>';
            }
		}

		return array($html, $htmlSummary);
	}
	//  End of Debtors Details Report  ///////////////////////////////////////////////////////////////////////////////////
	
	// Creditors Details Report  //////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getCreditorsDetailsReport() {
		$html = "";

		$reportDate = $this->db->escape_str($this->input->post('date'));
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));
		$creditorId = $this->db->escape_str($this->input->post('creditor_id'));
        $summaryReport = $this->db->escape_str($this->input->post('summary_report'));

		$this->generateCreditorsReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $locationId, $creditorId, $summaryReport);
	}

	public function generateCreditorsReportAsPDF($reportDate, $fromDate, $toDate, $year, $month, $locationId, $creditorId, $summaryReport) {
		$pdf = new Pdf_reports("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(25);
		$pdf->SetPrintHeader(true);
		$pdf->SetPrintFooter(true);

		$html = '';
		$date = '';
		$locationName = '';
		$creditorName = '';

		if ($reportDate != '') {
			$date = "As Of " . date_format(date_create($reportDate), "Y-m-d h:i:sa");
		}
		
		$creditor = $this->peoples_model->getById($creditorId);
		
		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = "{$this->lang->line('For ')} : {$location[0]->location_name } ";
			}
			
			if ($creditorId != '0') {
				if ($creditor && sizeof($creditor) > 0) {
					$creditorName =  "{$this->lang->line(' And For ')} : {$creditor[0]->people_name } ";
				}
			}
		} else if ($creditorId != '0') {
			if ($creditor && sizeof($creditor) > 0) {
				$creditorName =  "{$this->lang->line('For ')} : {$creditor[0]->people_name } ";
			}
		}
		
		if (($locationId != '0' || $creditorId != '0') && $fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		} else if ($fromDate != '' && $toDate != '') {
			$date = "{$this->lang->line('For Date Range From ')} : {$fromDate} {$this->lang->line(' To ')} : {$toDate} ";
		}

		if (($locationId != '0' || $creditorId != '0') && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if (($locationId == '0' || $creditorId == '0') && $reportDate != '' && $year != '0') {
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-01-01 {$this->lang->line(' To ')} : {$reportDate} ";
		} else if (($locationId != '0' || $creditorId != '0') && $year != '0') {
			$date = "{$this->lang->line(' And For Year ')} : {$year} ";
		} else if (($locationId == '0' || $creditorId == '0') && $year != '0') {
			$date = "{$this->lang->line('For Year ')} : {$year} ";
		}

		 if (($locationId != '0' || $creditorId != '0') && $reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line(' And For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		} else if (($locationId == '0' || $creditorId == '0') && $reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$date = "{$this->lang->line('For Date Range From ')} : {$year}-{$month}-01 {$this->lang->line(' To ')} : {$year}-{$month}-{$numberOfDays}";
		}

		$html .= "<br><p class='text-info'><strong>Creditors : </strong>{$locationName} {$creditorName} {$date}<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table border="0.5" style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';
        
        if ($summaryReport == "No") {
			$html.='<th style="text-align:left; width: 8%"><span style="font-weight:bold; font-size:9px">Date</span></th>';
			$html.='<th style="text-align:left; width: 10%"><span style="font-weight:bold; font-size:9px">Reference Number</span></th>';
			$html.='<th style="text-align:center; width: 14%"><span style="font-weight:bold; font-size:9px">Creditor</span></th>';
			$html.='<th style="text-align:center; width: 18%"><span style="font-weight:bold; font-size:9px">Description</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Amount</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Due Date</span></th>';
			$html.='<th style="text-align:center; width: 18%"><span style="font-weight:bold; font-size:9px">Reference Transaction</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Amount</span></th>';
			$html.='<th style="text-align:center; width: 8%"><span style="font-weight:bold; font-size:9px">Balance</span></th>';
        } else {
            $html.='<th style="text-align:center; width: 60%"><span style="font-weight:bold; font-size:9px">Creditor</span></th>';
            $html.='<th style="text-align:center; width: 40%"><span style="font-weight:bold; font-size:9px">Balance</span></th>';
        }
        
		$html.="</tr>
				</thead>";

		$result = $this->getCreditorsDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $locationId, $creditorId, $summaryReport);
		
		$html .= $result[0];

		$html.="</table>";
		
		$html.= $result[1];
		$pdf->writeHTML($html, true, false, true, false, '');

		if (file_exists(dirname(__FILE__) . '/../../../../temporaryFiles/Creditors.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../temporaryFiles/Creditors.pdf');
		}

		$pdf->lastPage();
		$pdf_file_name = dirname(__FILE__) . '/../../../../temporaryFiles/Creditors.pdf';
		$pdf->Output($pdf_file_name, 'FD');
	}

	public function getCreditorsDataFromDB($reportDate, $fromDate, $toDate, $year, $month, $locationId, $creditorId, $summaryReport){
		$creditorsRecords = '';
		$html = '';
		$htmlSummary = '';
		
		$currentDate = date('Y-m-d');
		
		if ($year == '' || $year == '0') {
			$currentFinancialYear = date('Y'); 
		}
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($currentFinancialYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $currentFinancialYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($currentFinancialYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			$currentFinancialYearStartDate = ($currentFinancialYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = $currentFinancialYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		}

		if ($locationId != '0' && $creditorId != '0' && $fromDate != '' && $toDate != '') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '104', $locationId, $creditorId);
		} else if ($locationId != '0' && $creditorId == '0' && $fromDate != '' && $toDate != '') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '104', $locationId);
		} else if ($locationId == '0' && $creditorId != '0' && $fromDate != '' && $toDate != '') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '104', '', $creditorId);
		} else if ($fromDate != '' && $toDate != '') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '104');
		}

		if ($locationId != '0'  && $creditorId != '0' && $reportDate != '' && $year != '0') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '104', $locationId, $creditorId);
		} else if ($locationId == '0' && $creditorId != '0' && $reportDate != '' && $year != '0') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '104', '', $creditorId);
		} else if ($locationId != '0' && $creditorId == '0' && $reportDate != '' && $year != '0') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '104', $locationId);
		} else if ($locationId != '0' && $creditorId != '0' && $year != '0') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '104', $locationId, $creditorId);
		} else if ($locationId == '0' && $creditorId != '0' && $year != '0') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '104', '', $creditorId);
		} else if ($locationId != '0' && $creditorId == '0' && $year != '0') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '104', $locationId);
		} else if ($locationId != '0' && $creditorId != '0' && $reportDate != '') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '104', $locationId, $creditorId);
		} else if ($locationId == '0' && $creditorId != '0' && $reportDate != '') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '104', '', $creditorId);
		} else if ($locationId != '0' && $creditorId == '0' && $reportDate != '') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $reportDate, 'transaction_date', 'asc', '', '', '', '104', $locationId);
		}

		if ($locationId != '0' && $creditorId != '0' && $reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '104', $locationId, $creditorId);
		} else if ($locationId == '0' && $creditorId != '0' && $reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '104', '', $creditorId);
		} else if ($locationId != '0' && $creditorId == '0' && $reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '104', $locationId);
		} else if ($reportDate == '' && $year != '0' && $month != '0') {
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($year . "-" . $month ."-01", $year . "-" . $month ."-" . $numberOfDays, 'transaction_date', 'asc', '', '', '', '104');
		}

		if ($locationId == '0' && $creditorId == '0' && $reportDate != '' && $year == '0' && $month == '0') {
			$creditorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries('', '', 'transaction_date', 'asc', '', $reportDate, '', '104');
		}

		$creditTotal = 0;
		$debitTotal = 0;
		$totalAmountPaid = 0;
		$totalBalanceAmount = 0;
		if ($creditorsRecords != null) {
			$html .= '<tbody>';
            
            if ($summaryReport == "No") {

                foreach ($creditorsRecords as $creditorRecord) {

                    $chartOfAccountName = '';

                    $journalEntryId = $creditorRecord->journal_entry_id;
                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                    $payeePayerId = $journalEntry[0]->payee_payer_id;
                    $payeePayer = $this->peoples_model->getById($payeePayerId);

                    $payeePayerName = '';
                    if ($payeePayer && sizeof($payeePayer) > 0) {
                        $payeePayerName = $payeePayer[0]->people_name;
                    }

                    $referenceNumber = $journalEntry[0]->reference_no;
                    $description = $journalEntry[0]->description;
                    $creditAmount = $creditorRecord->credit_value;
                    $debitAmount = $creditorRecord->debit_value;
                    
                    $dueDate = $journalEntry[0]->due_date;

                    if ($dueDate == '0000-00-00') {
                        $dueDate = '';
                    }

                    //if ($creditAmount > 0 && ($creditorRecord->prime_entry_book_id == '106' || $creditorRecord->prime_entry_book_id == '1')) {
                    if ($creditAmount > 0) {
                        $html .= '<tr style="line-height:15px;">';
                        $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px">' . $creditorRecord->transaction_date . '</span></td>';
                        $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px">' . $referenceNumber . '</span></td>';
                        $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px">' . $payeePayerName . '</span></td>';
                        $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $description . '</span></td>';
                        $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px">' . number_format($creditAmount, 2) . '</span></td>';
                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . $dueDate . '</span></td>';

                        $creditTotal = $creditTotal + $creditAmount;

                        $referenceTransactions = $this->journal_entries_model->getReferenceJournalEntriesOfAJournalEntry($journalEntryId);
                        
                        $claimReferenceTransactions = false;
                        
                        $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);
                            
                        if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {

                            foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                $referenceTransaction = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);

                                if ($referenceTransaction) {
                                    $claimReferenceTransactions[] = $referenceTransaction;
                                }
                            }
                        }

                        $count = 1;
                        $creditAmountTotal = 0;
                        $balanceAmount = 0;
                        $referenceTransactionsCount = 0;
                        $claimReferenceTransactionsCount = 0;
                        
                        if ($referenceTransactions) {
                            $referenceTransactionsCount = sizeof($referenceTransactions);
                        }
                        
                        if ($claimReferenceTransactions) {
                            $claimReferenceTransactionsCount = sizeof($claimReferenceTransactions);
                        }
                        
                        $referenceTransactionsCountTotal = $referenceTransactionsCount + $claimReferenceTransactionsCount;
                            
                        if ($referenceTransactions && sizeof($referenceTransactions) > 0) {
                            
                            foreach ($referenceTransactions as $referenceTransaction) {
                                
                                $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                $referenceTransactionDescription = $referenceTransaction->description;
                                
                                $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '104', "Yes");
                                
                                if ($count == 1) {
                                    $balanceAmount = round((float)$creditAmount - (float)$referenceGeneralLedgerEntry[0]->debit_value);
                                    $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->debit_value;

                                    $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->debit_value, 2) . '</span></td>';

                                    if ($referenceTransactionsCountTotal == $count) {
                                        $html .= '    <td style="text-align:center; width: 8%;" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                    } else {
                                        $html .= '    <td style="text-align:center; width: 8%;"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                    }

                                    $html .= "</tr>";
                                    $creditAmountTotal = (float)$referenceGeneralLedgerEntry[0]->debit_value;
                                } else {
                                    $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->debit_value);
                                    $balanceAmount = round($creditAmount - $creditAmountTotal);
                                    $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->debit_value;

                                    $html .= '<tr style="line-height:15px;">';
                                    $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->debit_value, 2) . '</span></td>';

                                    if ($referenceTransactionsCountTotal == $count) {
                                        $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                    } else {
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                    }

                                    $html .= "</tr>";
                                }
                                
                                $count++;
                            }

                            if ($claimReferenceTransactions && sizeof($claimReferenceTransactions) > 0) {
                                foreach ($claimReferenceTransactions as $referenceTransaction) {
                                
                                    $referenceJournalEntryId = $referenceTransaction[0]->journal_entry_id;
                                    $referenceTransactionDescription = $referenceTransaction[0]->description;

                                    $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '104', "Yes");
                                    
                                    
                                    $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->debit_value);
                                    $balanceAmount = round($creditAmount - $creditAmountTotal);
                                    $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->debit_value;

                                    $html .= '<tr style="line-height:15px;">';
                                    $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                    $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                    $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->debit_value, 2) . '</span></td>';

                                    if ($referenceTransactionsCountTotal == $count) {
                                        $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                    } else {
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                    }

                                    $html .= "</tr>";
                                    
                                    $count++;
                                }
                                
                                $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                            } else {
                                $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                            }
                        } else {
                            
                            if ($claimReferenceTransactions && sizeof($claimReferenceTransactions) > 0) {
                                foreach ($claimReferenceTransactions as $referenceTransaction) {
                                
                                    $referenceJournalEntryId = $referenceTransaction[0]->journal_entry_id;
                                    $referenceTransactionDescription = $referenceTransaction[0]->description;

                                    $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '104', "Yes");

                                    if ($count == 1) {
                                        $balanceAmount = round((float)$creditAmount - (float)$referenceGeneralLedgerEntry[0]->debit_value);
                                        $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->debit_value;

                                        $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->debit_value, 2) . '</span></td>';

                                        if ($referenceTransactionsCountTotal == $count) {
                                            $html .= '    <td style="text-align:center; width: 8%;" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                        } else {
                                            $html .= '    <td style="text-align:center; width: 8%;"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                        }

                                        $html .= "</tr>";
                                        $creditAmountTotal = (float)$referenceGeneralLedgerEntry[0]->debit_value;
                                    } else {
                                        $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->debit_value);
                                        $balanceAmount = round($creditAmount - $creditAmountTotal);
                                        $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->debit_value;

                                        $html .= '<tr style="line-height:15px;">';
                                        $html .= '    <td style="text-align:left; width: 8%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:left; width: 10%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:left; width: 14%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:right; width: 8%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                        $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px">' . $referenceTransactionDescription . '</span></td>';
                                        $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($referenceGeneralLedgerEntry[0]->debit_value, 2) . '</span></td>';

                                        if ($referenceTransactionsCountTotal == $count) {
                                            $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                        } else {
                                            $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px">' . number_format($balanceAmount, 2) . '</span></td>';
                                        }

                                        $html .= "</tr>";
                                    }

                                    $count++;
                                }

                                $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                            } else {
                                $html .= '    <td style="text-align:left; width: 18%"><span style="font-size:8px"></span></td>';
                                $html .= '    <td style="text-align:center; width: 8%"><span style="font-size:8px"></span></td>';
                                $html .= '    <td style="text-align:center; width: 8%" bgcolor="#eaecec"><span style="font-size:8px;">' . number_format($creditAmount, 2) . '</span></td>';
                                $html .= "</tr>";

                                $totalBalanceAmount = $totalBalanceAmount + $creditAmount;
                            }
                        }
                    }
                }

                $totalBalanceAmount = $totalBalanceAmount - $debitTotal;

                $html .= "</tbody>";

                $htmlSummary .= '<br><br>';
                $htmlSummary .= '<table border="0.5" style="margin-bottom:0;">';
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Credit Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($creditTotal, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Amount Paid") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($totalAmountPaid, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Debit Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($debitTotal, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Balance Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($totalBalanceAmount, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<table>';
            } else {
                
                $creditorBalances = array();
                
                foreach ($creditorsRecords as $creditorRecord) {

                    $chartOfAccountName = '';

                    $journalEntryId = $creditorRecord->journal_entry_id;
                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                    $payeePayerId = $journalEntry[0]->payee_payer_id;
                    
                    $creditAmount = $creditorRecord->credit_value;
                    $debitAmount = $creditorRecord->debit_value;

                    if ($creditAmount > 0) {
                        
                        $creditTotal = $creditTotal + $creditAmount;

                        $referenceTransactions = $this->journal_entries_model->getReferenceJournalEntriesOfAJournalEntry($journalEntryId);

                        $journalEntryClaimReferencesAvailable = false;
                        
                        if (!$referenceTransactions) {
                            $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);
                            
                            if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                
                                $journalEntryClaimReferencesAvailable = true;
                                
                                foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                    $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                    $referenceTransaction = $this->journal_entries_model->getJournalEntryById($claimReferenceJournalEntryId);
                                    
                                    if ($referenceTransaction) {
                                        $referenceTransactions[] = $referenceTransaction;
                                    }
                                }
                            }
                        }
                        
                        if ($referenceTransactions && sizeof($referenceTransactions) > 0) {
                            $count = 1;
                            $creditAmountTotal = 0;
                            $balanceAmount = 0;

                            $referenceTransactionsCount = sizeof($referenceTransactions);

                            foreach ($referenceTransactions as $referenceTransaction) {
                                
                                if ($journalEntryClaimReferencesAvailable) {
                                    $referenceJournalEntryId = $referenceTransaction[0]->journal_entry_id;
                                } else {
                                    $referenceJournalEntryId = $referenceTransaction->journal_entry_id;
                                }
                                
                                $referenceGeneralLedgerEntry = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '104', "Yes");
                                if ($count == 1) {
                                    $balanceAmount = round((float)$creditAmount - (float)$referenceGeneralLedgerEntry[0]->debit_value);
                                    $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->debit_value;

                                    $creditAmountTotal = (float)$referenceGeneralLedgerEntry[0]->debit_value;
                                } else {
                                    $creditAmountTotal = round((float)$creditAmountTotal + (float)$referenceGeneralLedgerEntry[0]->debit_value);
                                    $balanceAmount = round($creditAmount - $creditAmountTotal);
                                    $totalAmountPaid = $totalAmountPaid + (float)$referenceGeneralLedgerEntry[0]->debit_value;

                                }
                                $count++;
                            }
                            
                            if (array_key_exists($payeePayerId, $creditorBalances)) {
                                $creditorBalances[$payeePayerId] = $creditorBalances[$payeePayerId] + $balanceAmount;
                            } else {
                                $creditorBalances[$payeePayerId] = $balanceAmount;
                            }

                            $totalBalanceAmount = $totalBalanceAmount + $balanceAmount;
                        } else {
                            
                            if (array_key_exists($payeePayerId, $creditorBalances)) {
                                $creditorBalances[$payeePayerId] = $creditorBalances[$payeePayerId] + $creditAmount;
                            } else {
                                $creditorBalances[$payeePayerId] = $creditAmount;
                            }
                            
                            $totalBalanceAmount = $totalBalanceAmount + $creditAmount;
                        }
                    }

                    if ($debitAmount > 0) {
                        
                        if (array_key_exists($payeePayerId, $creditorBalances)) {
                            $creditorBalances[$payeePayerId] = $creditorBalances[$payeePayerId] - $debitAmount;
                        } else {
                            $creditorBalances[$payeePayerId] = $debitAmount;
                        }
                        
                        $debitTotal = $debitTotal + $debitAmount;
                    }
                }
                
                foreach($creditorBalances as $key => $balance) {
                    
                    if ($balance > 0) {
                        $payeePayer = $this->peoples_model->getById($key);

                        $payeePayerName = '';
                        if ($payeePayer && sizeof($payeePayer) > 0) {
                            $payeePayerName = $payeePayer[0]->people_name;
                        }

                        $html .= '<tr style="line-height:15px;">';
                        $html .= '    <td style="text-align:left; width: 60%"><span style="font-size:8px">' . $payeePayerName . '</span></td>';
                        $html .= '    <td style="text-align:center; width: 40%;" bgcolor="#eaecec"><span style="font-size:8px">' . number_format($balance, 2) . '</span></td>';
                        $html .= "</tr>";
                    }
                }

                $totalBalanceAmount = $totalBalanceAmount - $debitTotal;

                $html .= "</tbody>";

                $htmlSummary .= '<br><br>';
                $htmlSummary .= '<table border="0.5" style="margin-bottom:0;">';
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Credit Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($creditTotal, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Amount Paid") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($totalAmountPaid, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Debit Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($debitTotal, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tr style="line-height:15px;">';
                $htmlSummary .= '    <td style="text-align:right; width: 90%"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Total Balance Amount") . '</span></td>';
                $htmlSummary .= '    <td style="text-align:center; width: 15%; border-top: 2px solid #999; border-bottom: 2px solid #999;"><span style="font-size:8px">' . number_format($totalBalanceAmount, 2) . '</span></td>';
                $htmlSummary .= "</tr>";
                $htmlSummary .= '<tbody>';
                $htmlSummary .= '<table>';
            }
		}

		return array($html, $htmlSummary);
	}
	//  End of Creditors Details Report  ///////////////////////////////////////////////////////////////////////////////////
    
    // Cash And Cash Equivalent Details Report  //////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getCashAndCashEquivalentDetails() {
		$html = "";

		$locationId = $this->db->escape_str($this->input->post('location_id'));

		$this->generateCashAndCashEquivalentsReportAsPDF($locationId);
	}

	public function generateCashAndCashEquivalentsReportAsPDF($locationId) {
		$pdf = new Pdf_reports("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(25);
		$pdf->SetPrintHeader(true);
		$pdf->SetPrintFooter(true);

		$html = '';
		$locationName = '';
        $reportDate = date("Y-m-d");

		$date = "As Of " . date_format(date_create($reportDate), "Y-m-d h:i:sa");
		
		if($locationId != '0'){
			$location = $this->locations_model->getById($locationId);
			if ($location && sizeof($location) > 0) {
				$locationName = "{$this->lang->line('For ')} : {$location[0]->location_name } ";
			}
		}
		
		$html .= "<br><p class='text-info'><strong>Cash And Cash Equivalents : </strong>{$locationName} {$date}<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table border="0.5" style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';
        
        $html.='<th style="text-align:center; width: 60%"><span style="font-weight:bold; font-size:9px">Account</span></th>';
        $html.='<th style="text-align:center; width: 40%"><span style="font-weight:bold; font-size:9px">Balance</span></th>';
        
		$html.="</tr>
				</thead>";

		$result = $this->getCashAndCashEquivalentsDataFromDB($reportDate, $locationId);
		
		$html .= $result;

		$html.="</table>";
		
		$pdf->writeHTML($html, true, false, true, false, '');

		if (file_exists(dirname(__FILE__) . '/../../../../temporaryFiles/Cash_And_Cash_Equivalents.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../temporaryFiles/Cash_And_Cash_Equivalents.pdf');
		}

		$pdf->lastPage();
		$pdf_file_name = dirname(__FILE__) . '/../../../../temporaryFiles/Cash_And_Cash_Equivalents.pdf';
		$pdf->Output($pdf_file_name, 'FD');
	}

	public function getCashAndCashEquivalentsDataFromDB($reportDate, $locationId) {
        
		$creditorsRecords = '';
		$html = '';
		$htmlSummary = '';
        
        $cashAndCashEquivalentsChartOfAccount = $this->system_configurations_model->getCashAndCashEquivalentsChartOfAccountConfigurationData();
		$cashAndCashEquivalentsChartOfAccountId = $cashAndCashEquivalentsChartOfAccount[0]->config_filed_value;
        
		$currentDate = date('Y-m-d');
		
        $year = date('Y');
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			$currentFinancialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		}

        $specialChartOfAccountsToCheckCompletedTransactionsStatus = array();
        
        $chequeInHandChartOfAccount = $this->system_configurations_model->getCashAndCashEquivalentsReportChequeInHandChartOfAccount();
        
        if ($chequeInHandChartOfAccount[0]->config_filed_value != '0') {
            $specialChartOfAccountsToCheckCompletedTransactionsStatus[] = $chequeInHandChartOfAccount[0]->config_filed_value;
        }
        
		$accountBalanceList = '';
        if ($locationId == "0") {
            $accountBalanceList = $this->journal_entries_model->getFilteredJournalEntriesOfParentChartOfAccount($currentFinancialYearStartDate, 
                                    $currentFinancialYearEndDate, "", $cashAndCashEquivalentsChartOfAccountId, "", $specialChartOfAccountsToCheckCompletedTransactionsStatus);
        } else if ($locationId != "0") {
            $accountBalanceList = $this->journal_entries_model->getFilteredJournalEntriesOfParentChartOfAccount($currentFinancialYearStartDate, 
                                    $currentFinancialYearEndDate, $locationId, $cashAndCashEquivalentsChartOfAccountId, "", $specialChartOfAccountsToCheckCompletedTransactionsStatus);		
        }
        
        $html .=    "<tbody>";

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
                        $html .= '    <td style="text-align:left; width: 60%">' . $chartOfAccountName . '</td>';
                        $html .= '    <td style="text-align:right; width: 40%">' . number_format($accountBalance, 2) . '</td>';
                        $html .= "</tr>";
                    }
                }
            }
        }
        
        $html .=    "</tbody>";

        return $html;
	}
	//  End of Cash And Cash Equivalent Details Report  ///////////////////////////////////////////////////////////////////////////////////
	
	public function getYearDropdownData() {
		$html = "<select id='year' class='form-control' onchange='handleYearChange(this.id)'>";
		$startingYear  =date('Y', strtotime('-20 years'));
		$date = date("Y-m-d");
		$date = strtotime(date("Y-m-d", strtotime($date)) . " +132 month");
		$endingYear = date("Y", $date);
		$currentYear = date('Y');
		$html .= "<option value='0'>" . $this->lang->line('-- Select --') . "</option>";
		for($startingYear; $startingYear <= $endingYear; $startingYear++) {
			if ($currentYear == $startingYear) {
				$html .= "<option value='" . $startingYear . "' selected>" . $startingYear . "</option>";
			} else {
				$html .= "<option value='" . $startingYear . "'>" . $startingYear . "</option>";
			}
		}               
		$html .= "<select>";

		echo $html;
	}

	public function getMonthDropdownData() {
		
		$formattedMonthArray = array(
						"1" => "January", "2" => "February", "3" => "March", "4" => "April",
						"5" => "May", "6" => "June", "7" => "July", "8" => "August",
						"9" => "September", "10" => "October", "11" => "November", "12" => "December",
					);
		
		$html = "<select id='month' class='form-control' onchange='handleMonthChange(this.id)'>";
		$html .= "<option value='0'>" . $this->lang->line('-- Select --') . "</option>";
		$current_month = date('m');
		for ($m=1; $m<=12; $m++) {
			$html .= "<option value='" . $m . "'>" . $formattedMonthArray[$m] . "</option>";
		}
		$html .= "</select>";

		echo $html;
	}

	public function getWeeksOfAMonthDropdownData() {
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));

		$weeksArray = array();

		if ($year != 0 && $month != 0) {
			$startDate = date($year . "-" . $month . "-01") ;
			$noOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$lastDate = $year . '-' .$month . '-' . $noOfDays;
			$startDate = date('Y-m-d', strtotime($startDate));
			$endDate = date('Y-m-d', strtotime($lastDate));

			$dayIncrement = 0;
			$monthEndIsReached = false;
			for($date = $startDate; $date <= $endDate; $date = date('Y-m-d', strtotime($date. ' + ' . $dayIncrement . ' days'))) {

				if (!$monthEndIsReached) {
					$getarray = $this->getStartAndEndDateOfAWeek($date, $startDate, $endDate);
					$weeksArray[] = $getarray;
				}

				$calculatedEndDate = $getarray['weekEndDate'];

				if (strtotime($calculatedEndDate) == strtotime($endDate)) {
					$monthEndIsReached = true;
				}

				$dateDiff = (strtotime($endDate) - strtotime($date)) / (24*60*60);
				if ($dateDiff == 0) {
					$dayIncrement = 1;
				} else if ($dateDiff >= 7) {
					$dayIncrement = 7;
				} else {
					$dayIncrement = $dateDiff;
				}
			}
		}

		$weekList = array('0' => $this->lang->line('-- Select --'));

		$weekCount = 1;
		if ($weeksArray && sizeof($weeksArray) > 0) {
			foreach($weeksArray as $weekData) {
				$weekList[$weekCount] = $weekData['weekStartDate'] . " : " . $weekData['weekEndDate'];
				$weekCount++;
			}
		}

		$this->optionList = '';

		foreach($weekList as $key => $week) {
			$this->optionList .= '<option value=' . $key . '>' . $week . '</option>';
		}

		$optionList = $this->optionList;

		$html = "<select class='select2 form-control' id='week'>
					{$optionList}
				 </select>";

		echo $html;
	}

	function getStartAndEndDateOfAWeek($date, $start_date, $end_date) {
		$monthNumber = date("m", strtotime($date));
		$week =  date('W', strtotime($date));
		$year =  date('Y', strtotime($date));
		// Adding leading zeros for weeks 1 - 9.
		if ($monthNumber == 1 && $week > 5) {
			$date_string = ($year - 1). 'W' . sprintf('%02d', $week);
		} else {
			$date_string = $year . 'W' . sprintf('%02d', $week);
		}

		$fromDateCalculated = date('Y-n-j', strtotime($date_string));
		if(strtotime($fromDateCalculated) < strtotime($start_date)) {
			$fromDate = $start_date;
		} else {
			$fromDate = $fromDateCalculated;
		}

		$toDateCalculated = date('Y-n-j', strtotime($date_string . '7'));
		if(strtotime($toDateCalculated) > strtotime($end_date)) {
			$toDate = $end_date;
		} else {
			$toDate = $toDateCalculated;
		}

		$weekDates = array(
			"weekStartDate" => date_format(date_create($fromDate), 'Y-m-d'),
			"weekEndDate" => date_format(date_create($toDate), 'Y-m-d'),
		);

		return $weekDates;
	}

	public function getChartTypeDropdownData() {
		$html = "<select id='chart_type' class='form-control'>";
		$html .= "<option value=''>" . $this->lang->line('-- Select --') . "</option>";
		$html .= "<option value='BarGraph'>" . $this->lang->line('Bar Chart') . "</option>";
		$html .= "<option value='BarAndLineGraph'>" . $this->lang->line('Bar And Line Chart') . "</option>";
		$html .= "<option value='Bar3DGraph'>" . $this->lang->line('3D Bar Chart') . "</option>";
		$html .= "<option value='StackedBarGraph'>" . $this->lang->line('Stacked Bar Chart') . "</option>";
		$html .= "<option value='StackedBar3DGraph'>" . $this->lang->line('3D Stacked Bar Chart') . "</option>";
		$html .= "<option value='GroupedBarGraph'>" . $this->lang->line('Grouped Bar Chart') . "</option>";
		$html .= "<option value='GroupedBar3DGraph'>" . $this->lang->line('3D Grouped Bar Chart') . "</option>";
		$html .= "<option value='Histogram'>" . $this->lang->line('Histogram Chart') . "</option>";
		$html .= "<option value='LineGraph'>" . $this->lang->line('Line Chart') . "</option>";
		$html .= "<option value='PieGraph'>" . $this->lang->line('Pie Chart') . "</option>";
		$html .= "<option value='Pie3DGraph'>" . $this->lang->line('3D Pie Chart') . "</option>";
		$html .= "<option value='DonutGraph'>" . $this->lang->line('Donut Chart') . "</option>";
		$html .= "<option value='PolarAreaGraph'>" . $this->lang->line('Polar Area Chart') . "</option>";
		$html .= "<option value='ExplodedPieGraph'>" . $this->lang->line('Exploded Pie Chart') . "</option>";
		$html .= "</select>";

		echo $html;
	}

	function arraySortByColumn(&$array, $column, $direction = SORT_DESC) {
		$sort_col = array();
		foreach ($array as $key=> $row) {
			$sort_col[$key] = $row[$column];
		}

		array_multisort($sort_col, $direction, $array);
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
			$currentFinancialYear = date('Y'); 
		}
		
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

		$currentFinancialYearEndDateToCompare = ($currentFinancialYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $currentFinancialYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($currentFinancialYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			$currentFinancialYearStartDate = ($currentFinancialYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = $currentFinancialYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
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
		} else if ($locationId != '0' && $reportDate != '') {
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
					$grossProfitCalculatingChartOfAccountDetailExists = true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$grossProfitChartOfAccountsTotal = $grossProfitChartOfAccountsTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
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
						$operatingActivitiesChartOfAccountsTotal = $operatingActivitiesChartOfAccountsTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
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
						$profitChartOfAccountTotal = $profitChartOfAccountTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
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
					$netProfitCalculatingChartOfAccountDetailExists = true;
					foreach ($resultChartOfAccountIds as $resultChartOfAccountId) {
						$netProfitChartOfAccountTotal = $netProfitChartOfAccountTotal - $resultChartOfAccountValues[$resultChartOfAccountId];
					}
				}
			}

			if ($netProfitCalculatingChartOfAccountDetailExists) {
				$netProfit =  $revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal - $netProfitChartOfAccountTotal;
			} else {
				$netProfit = $revenueChartOfAccountsTotal - $grossProfitChartOfAccountsTotal - $operatingActivitiesChartOfAccountsTotal - $profitChartOfAccountTotal;
			}
		}

		return $netProfit;
	}
	
	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
	
	public function getExcelColumnLetters($reportHeaderCount) {
		$columnLettersAvailable = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
			'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		//echo "<pre>";print_r($columnLettersAvailable);die;

		$columnLetters = array();
		$innerCountFirstLetter = 1;
		$innerCountSecondtLetter = 1;
		for ($count = 1; $count <= $reportHeaderCount; $count++) {
			if ($count <= 26 && $reportHeaderCount <= 26) {
				$columnLetters[$count] = $columnLettersAvailable[$count-1];
			} else if ($count > 26 && $reportHeaderCount > 26) {
				$columnLetters[$count] = $columnLettersAvailable[$innerCountFirstLetter-1] . $columnLettersAvailable[$innerCountSecondtLetter-1];
				$innerCountSecondtLetter++;
				if ($innerCountSecondtLetter > 26) {
					$innerCountSecondtLetter = 1;
					$innerCountFirstLetter++;
				}
			}
		}

		return $columnLetters;
	}

	public function exportReportDataToExcel($results, $reportName, $reportNameHeader) {

		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
			),
		);

		$reportHeaders = $results['reportHeaders'];
		$reportHeaderCount = sizeof($reportHeaders);
		$reportData = $results['reportData'];
		//echo '<pre>';print_r($reportData);die;

		if (file_exists(dirname(__FILE__) . '/../../../../reportExports/accountsManagerReports/' . $reportName . '_Report.xlsx')) {
			unlink(dirname(__FILE__) . '/../../../../reportExports/accountsManagerReports/' . $reportName . '_Report.xlsx');
		}

		$columnLetters = $this->getExcelColumnLetters($reportHeaderCount);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Results');
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		if ($reportHeaderCount <= 4) {
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		} else if ($reportHeaderCount <= 8) {
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		} else if ($reportHeaderCount <= 12) {
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_TABLOID);
		} else if ($reportHeaderCount <= 16) {
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_D);
		} else if ($reportHeaderCount > 16) {
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_E);
		}

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('FF00BFFF');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:' . end($columnLetters) . '1');
		$objPHPExcel->getActiveSheet()->mergeCells('A2:' . end($columnLetters) . '2');

		$objPHPExcel->getActiveSheet()->setCellValue('A1', $reportNameHeader);

		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getStyle($columnLetters[1] . "3:" . end($columnLetters) . "3")->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle($columnLetters[1] . "3:" . end($columnLetters) . "3")->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
		$objPHPExcel->getActiveSheet()->getStyle($columnLetters[1] . "3:" . end($columnLetters) . "3")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($columnLetters[1] . "3:" . end($columnLetters) . "3")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle($columnLetters[1] . "3:" . end($columnLetters) . "3")->getFill()->getStartColor()->setARGB('FF00BFFF');
		$objPHPExcel->getActiveSheet()->getStyle($columnLetters[1] . "3:" . end($columnLetters) . "3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle($columnLetters[1] . "3:" . end($columnLetters) . "3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->fromArray($reportHeaders, null, 'A3');

		$count = 4;
		if ($reportData) {
			foreach ($reportData as $data) {
				$objPHPExcel->getActiveSheet()->fromArray($data, null, 'A' . $count);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $count . ':' . end($columnLetters) . $count)->applyFromArray($styleThinBlackBorderOutline);
				$count++;
			}
		}

		foreach ($columnLetters as $letter) {
			$objPHPExcel->getActiveSheet()->getStyle($letter . '4:' . $letter . ($count-1))->applyFromArray($styleThinBlackBorderOutline);
		}

		// Do your stuff here
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filePath = dirname(__FILE__) . '/../../../../reportExports/accountsManagerReports/' . $reportName . '_Report.xlsx';

		$writer->save($filePath);
		chmod($filePath,0777); // CHMOD file

		return $reportName . '_Report';
	}

	public function downloadReportResuls() {
		$reportName = $this->input->post('report_download');

		if ($reportName == "salesPaymentDetails") {
			$this->downloadSalesPaymentDetailsToExcel();
		}
	}

	public function downloadSalesPaymentDetailsToExcel() {
		$data = file_get_contents(base_url() . "reportExports/accountsManagerReports/Sales_Payment_Details_Report.xlsx"); // Read the file's contents
		$name = 'Sales_Payment_Details_Report.xlsx';

		force_download($name, $data);
	}
}

