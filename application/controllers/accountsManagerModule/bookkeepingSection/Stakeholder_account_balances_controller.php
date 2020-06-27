<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stakeholder_account_balances_controller extends CI_Controller {

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
		$data_cls['li_class_stakeholder_account_balances_list'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration
		
		if(isset($this->data['ACM_Bookkeeping_View_Stakeholder_Account_Balance_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/stakeholderAccountBalances/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}
	
	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Stakeholder_Account_Balance_Permissions'])) {
			
			$peopleId = $this->db->escape_str($this->input->post('stakeholder_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
			
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered stakeholderAccountBalanceListDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Stakeholder')}</th>
										<th>{$this->lang->line('Debt Amount')}</th>
										<th>{$this->lang->line('Credit Amount')}</th>
										<th>{$this->lang->line('Payable Amount')}</th>
										<th>{$this->lang->line('Receivable Amount')}</th>
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
			
			$debtorsRecords = '';
			$creditorRecords = '';
			if ($peopleId == "0" && $locationId == "0") {
				$debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '102', '' , '', 'Yes');
				$creditorRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '104', '' , '', 'Yes');
			} else if ($peopleId == "0" && $locationId != "0") {
				$debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '102', $locationId, '', 'Yes');
				$creditorRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '104', $locationId, '', 'Yes');		
			} else if ($peopleId != "0" && $locationId == "0") {
				$debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '102', '' , $peopleId, 'Yes');
				$creditorRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '104', '' , $peopleId, 'Yes');		
			} else if ($peopleId != "0" && $locationId != "0") {
				$debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '102', $locationId , $peopleId, 'Yes');
				$creditorRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($currentFinancialYearStartDate, $currentFinancialYearEndDate, 'transaction_date', 'asc', '', '', '', '104', $locationId, $peopleId, 'Yes');		
			}
			
			$peopleIdList = array();
			
			$debtorList = array();
			if ($debtorsRecords != null) {
				foreach ($debtorsRecords as $debtorRecord) {

					$journalEntryId = $debtorRecord->journal_entry_id;
					$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
					$payeePayerId = $journalEntry[0]->payee_payer_id;
					$debitAmount = $debtorRecord->debit_value;
					$creditAmount = $debtorRecord->credit_value;
					
					if (!in_array($payeePayerId, $peopleIdList)) {
						$peopleIdList[] = $payeePayerId;
					}

					if ($debitAmount > 0) {
						if (!array_key_exists($payeePayerId, $debtorList)) {
							$debtorList[$payeePayerId] = (float)$debitAmount;
						} else {
							$debtorList[$payeePayerId] = (float)$debtorList[$payeePayerId] + (float)$debitAmount;
						}
					} else if ($creditAmount > 0) {
						if (!array_key_exists($payeePayerId, $debtorList)) {
							$debtorList[$payeePayerId] = -(float)$creditAmount;
						} else {
							$debtorList[$payeePayerId] = (float)$debtorList[$payeePayerId] - (float)$creditAmount;
						}
					}
				}
			}
			
			$creditorList = array();
			if ($creditorRecords != null) {
				foreach ($creditorRecords as $creditorRecord) {

					$journalEntryId = $creditorRecord->journal_entry_id;
					$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
					$payeePayerId = $journalEntry[0]->payee_payer_id;
					$creditAmount = $creditorRecord->credit_value;
					$debitAmount = $creditorRecord->debit_value;
					
					if (!in_array($payeePayerId, $peopleIdList)) {
						$peopleIdList[] = $payeePayerId;
					}

					if ($creditAmount > 0) {
						if (!array_key_exists($payeePayerId, $creditorList)) {
							$creditorList[$payeePayerId] = (float)$creditAmount;
						} else {
							$creditorList[$payeePayerId] = (float)$creditorList[$payeePayerId] + (float)$creditAmount;
						}
					} else if ($debitAmount > 0) {
						if (!array_key_exists($payeePayerId, $creditorList)) {
							$creditorList[$payeePayerId] = -(float)$debitAmount;
						} else {
							$creditorList[$payeePayerId] = (float)$creditorList[$payeePayerId] - (float)$debitAmount;
						}
					}
				}
			}

			if ($peopleIdList && sizeof($peopleIdList) > 0) {
				foreach ($peopleIdList as $peopleIdValue) {
					
					$people = $this->peoples_model->getById($peopleIdValue);
					
					$peopleName = '';
					if ($people && sizeof($people) > 0) {
						$peopleName = $people[0]->people_name;
					}
					
					$creditValue = '0';
					$debitValue = '0';
					$payableBalance = '';
					$receivableBalance = '';
					if (array_key_exists($peopleIdValue, $creditorList)) {
                        
                        if ($creditorList[$peopleIdValue] < 0) {
                            $debitValue = -($creditorList[$peopleIdValue]);
                        } else {
                            $creditValue = $creditorList[$peopleIdValue];
                        }
						
					}
					
					if (array_key_exists($peopleIdValue, $debtorList)) {
						$debitValue = $debtorList[$peopleIdValue];
					}
					
				if ($creditValue != '0' || $debitValue != '0') {
						if ($creditValue > $debitValue) {
							$payableBalance = number_format($creditValue - $debitValue, 2);
						}

						if ($debitValue > $creditValue) {
							$receivableBalance = number_format($debitValue - $creditValue, 2);
						}

						$html .= "<tr>";
						$html .= "<td>" . $peopleName . "</td>";
						$html .= "<td style='text-align:right;'>" . number_format($debitValue, 2) . "</td>";
						$html .= "<td style='text-align:right;'>" . number_format($creditValue, 2) . "</td>";
						$html .= "<td style='text-align:right;'>" . $payableBalance . "</td>";
						$html .= "<td style='text-align:right;'>" . $receivableBalance . "</td>";
						$html .= "</tr>";
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