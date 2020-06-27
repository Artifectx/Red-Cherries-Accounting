<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/../../../libraries/SVGGraph/SVGGraph.php';

class General_ledger_controller extends CI_Controller {
    
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
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);

		//Get system module header
		$id = '1';
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle($id);

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
		$data_cls['li_class_general_ledger'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$this->data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

		$this->data['systemConfigData'] = $this->getSystemConfigData();

		if(isset($this->data['ACM_Bookkeeping_View_General_Ledger_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/generalLedger/index', $this->data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}

		$configData['accounts_management_for_locations_use_status'] = $this->journal_entries_model->isLocationFieldUsed();

		return $configData;
	}

	public function getAllPrimeEntryBooksToDropDown() {
		$primeEntryBooks = $this->prime_entry_book_model->getAllPrimeEntryBooksToDropDown();

		echo $primeEntryBooks;
	}

	//get all data
	public function getTableData() {
		
		$year = $this->db->escape_str($this->input->post('year'));
		$month = $this->db->escape_str($this->input->post('month'));
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$primeEntryBookId = $this->db->escape_str($this->input->post('prime_entry_book_id'));
		$chartOfAccountId = $this->db->escape_str($this->input->post('chart_of_account_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		
		if ($year != '' && $month != '') {
			$length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$defaultSearchFromDate = $year . '-' . $month . '-1';
			$defaultSearchToDate = $year . '-' . $month . '-' . $length;
		} else {
			$defaultSearchFromDate = '';
			$defaultSearchToDate = '';
		}

		if(isset($this->data['ACM_Bookkeeping_View_General_Ledger_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Date')}</th>
							<th>{$this->lang->line('Journal Entry Reference No')}</th>";
							if ($this->isAccountsManagementForLocationsEnabled()) {
				$html .= "      <th>{$this->lang->line('Location')}</th>";
							}
				$html .= "  <th>{$this->lang->line('Prime Entry Book Name')}</th>
							<th>{$this->lang->line('Chart of Account')}</th>
							<th>{$this->lang->line('Debit Amount')}</th>
							<th>{$this->lang->line('Credit Amount')}</th>
						</tr>
					</thead>
					<tbody>";

	//            if ($fromDate != '' && $toDate != '' && $primeEntryBookId != '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId != '' && $chartOfAccountId != '' && $locationId == '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId != '' && $chartOfAccountId == '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId == '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate == '' && $primeEntryBookId != '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate == '' && $toDate != '' && $primeEntryBookId != '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId != '' && $chartOfAccountId == '' && $locationId == '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId == '' && $chartOfAccountId == '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate == '' && $primeEntryBookId == '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate == '' && $toDate == '' && $primeEntryBookId != '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId == '' && $chartOfAccountId == '' && $locationId == '') {
	//                
	//            } else if ($fromDate != '' && $toDate == '' && $primeEntryBookId == '' && $chartOfAccountId == '' && $locationId != '') {
	//                
	//            } else if ($fromDate == '' && $toDate == '' && $primeEntryBookId == '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate == '' && $primeEntryBookId == '' && $chartOfAccountId == '' && $locationId == '') {
	//                
	//            } else if ($fromDate == '' && $toDate == '' && $primeEntryBookId == '' && $chartOfAccountId == '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId == '' && $chartOfAccountId != '' && $locationId == '') {
	//                
	//            } else if ($fromDate != '' && $toDate == '' && $primeEntryBookId != '' && $chartOfAccountId == '' && $locationId != '') {
	//                
	//            } else if ($fromDate == '' && $toDate != '' && $primeEntryBookId == '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate != '' && $primeEntryBookId == '' && $chartOfAccountId != '' && $locationId != '') {
	//                
	//            } else if ($fromDate != '' && $toDate == '' && $primeEntryBookId != '' && $chartOfAccountId != '' && $locationId == '') {
	//                
	//            } else if ($fromDate == '' && $toDate != '' && $primeEntryBookId != '' && $chartOfAccountId == '' && $locationId != '') {
	//                
	//            } else if () {
	//                
	//            } else if () {
	//                
	//            }

			$primeEntryTransactions = $this->journal_entries_model->getAllGeneralLedgerEntries($defaultSearchFromDate, $defaultSearchToDate, 'transaction_date', 'desc', $fromDate, $toDate, $primeEntryBookId, $chartOfAccountId, $locationId);
			
			if ($primeEntryTransactions != null) {
				foreach ($primeEntryTransactions as $row) {
					if ($row->debit_value != "0.00" || $row->credit_value != "0.00") {
						$primeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($row->prime_entry_book_id);
						$journalEntry = $this->journal_entries_model->getJournalEntryById($row->journal_entry_id);

						if ($primeEntryBook && sizeof($primeEntryBook) > 0) {
							$primeEntryBookName = $primeEntryBook[0]->prime_entry_book_name;
						} else {
							$primeEntryBookName = '';
						}

						$chartOfAccount = $this->chart_of_accounts_model->get($row->chart_of_account_id);
						$chartOfAccountName = $chartOfAccount[0]->text;
						$html .= "<tr>";
						$html .= "<td>" . $row->transaction_date . "</td>";
						$html .= "<td>" . $journalEntry[0]->reference_no . "</td>";
					if ($this->isAccountsManagementForLocationsEnabled()) {
						$html .= "<td>" . $row->location_name . "</td>";
					}
						$html .= "<td>" . $primeEntryBookName . "</td>";
						$html .= "<td>" . $chartOfAccountName . "</td>";
						$html .= "<td>" . $row->debit_value . "</td>";
						$html .= "<td>" . $row->credit_value . "</td>";
						$html .= "</tr>";
					}
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

	public function isAccountsManagementForLocationsEnabled() {
		return $this->system_configurations_model->isAccountsManagementForLocationsEnabled();
	}

	public function getLocationsAsOptionList() {
		echo $this->locations_model->getLocationsAsOptionList("Location Name");
	}
	
	public function getIncomeAndExpenseComparisonDetails() {
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$month = $this->db->escape_str($this->input->post('month'));
		$weeklyGraph = $this->db->escape_str($this->input->post('weekly_graph'));
		$chartType = $this->db->escape_str($this->input->post('chart_type'));
		$customGraphTitle = $this->db->escape_str($this->input->post('display_graph_title'));
		$xAxisTitle = $this->db->escape_str($this->input->post('x_axix_title'));
		$yAxisTitle = $this->db->escape_str($this->input->post('y_axix_title'));
		$graphHeight = $this->db->escape_str($this->input->post('graph_height'));
		$graphWidth = $this->db->escape_str($this->input->post('graph_width'));
		$compareWithLastFinancialYear = $this->db->escape_str($this->input->post('compare_with_last_financial_year'));
		$lastFinancialYearStartDate = $this->db->escape_str($this->input->post('last_financial_year_start_date'));
		$lastFinancialYearEndDate = $this->db->escape_str($this->input->post('last_financial_year_end_date'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		
		$values = array();
		$structureDataAvailable = false;
		
		if ($month == '' && $weeklyGraph == '' && $compareWithLastFinancialYear == '') {
			$structureDataAvailable = true;
			$incomeAccountsTotal = $this->getAccountsTotal($fromDate, $toDate, "Income", "Both", $locationId);
			$incomeCreditTotal = $incomeAccountsTotal["Credit"];
			$incomeDebitTotal = $incomeAccountsTotal["Debit"];

			$income = (float)$incomeCreditTotal - (float)$incomeDebitTotal;

			$expenseAccountsTotal = $this->getAccountsTotal($fromDate, $toDate, "Expense", "Both", $locationId);
			$expenseCreditTotal = $expenseAccountsTotal["Credit"];
			$expenseDebitTotal = $expenseAccountsTotal["Debit"];

			$expense = (float)$expenseDebitTotal - (float)$expenseCreditTotal;

			$incomeInnerArray = array();
			$expenseInnerArray = array();

			if ($income > 0) {
				$incomeInnerArray['type'] = "Income";
				$incomeInnerArray['amount'] = str_replace(",", "", number_format($income));
				$incomeInnerArray['dlbg'] = array('#99f','#fff','#99f','h');
				$legendEntries[] = "Income";
				$values[] = $incomeInnerArray;
			}

			if ($expense != 0) {

				if ($income == 0) {
					$incomeInnerArray['type'] = "Income";
					$incomeInnerArray['amount'] = str_replace(",", "", number_format($income));
					$incomeInnerArray['dlbg'] = array('#99f','#fff','#99f','h');
					$legendEntries[] = "Income";
					$values[] = $incomeInnerArray;
				}

				$expenseInnerArray['type'] = "Expense";
				$expenseInnerArray['amount'] = str_replace(",", "", number_format($expense));
				$expenseInnerArray['dlbg'] = array('#99f','#fff','#99f','h');
				$legendEntries[] = "Expense";
				$values[] = $expenseInnerArray;
			}
		} else if ($month == '' && $weeklyGraph == '' && $compareWithLastFinancialYear == 'Yes') {
			$chartType = "GroupedBar3DGraph";
			$incomeInnerArray = array();
			$expenseInnerArray = array();
			$year = date("Y");
			$lastYear = $year - 1;
			
			$incomeAccountsTotal = $this->getAccountsTotal($lastFinancialYearStartDate, $lastFinancialYearEndDate, "Income", "Both", $locationId);
			$incomeCreditTotal = $incomeAccountsTotal["Credit"];
			$incomeDebitTotal = $incomeAccountsTotal["Debit"];

			$income = (float)$incomeCreditTotal - (float)$incomeDebitTotal;

			$expenseAccountsTotal = $this->getAccountsTotal($lastFinancialYearStartDate, $lastFinancialYearEndDate, "Expense", "Both", $locationId);
			$expenseCreditTotal = $expenseAccountsTotal["Credit"];
			$expenseDebitTotal = $expenseAccountsTotal["Debit"];

			$expense = (float)$expenseDebitTotal - (float)$expenseCreditTotal;
			
			$incomeInnerArray["Year - " . $lastYear] = $income;
			$expenseInnerArray["Year - " . $lastYear] = $expense;
			
			$incomeAccountsTotal = $this->getAccountsTotal($fromDate, $toDate, "Income", "Both", $locationId);
			$incomeCreditTotal = $incomeAccountsTotal["Credit"];
			$incomeDebitTotal = $incomeAccountsTotal["Debit"];

			$income = (float)$incomeCreditTotal - (float)$incomeDebitTotal;

			$expenseAccountsTotal = $this->getAccountsTotal($fromDate, $toDate, "Expense", "Both", $locationId);
			$expenseCreditTotal = $expenseAccountsTotal["Credit"];
			$expenseDebitTotal = $expenseAccountsTotal["Debit"];

			$expense = (float)$expenseDebitTotal - (float)$expenseCreditTotal;
			
			$incomeInnerArray["Year - " . $year] = $income;
			$expenseInnerArray["Year - " . $year] = $expense;
			
			$values[] = $incomeInnerArray;
			$values[] = $expenseInnerArray;
		} else {
			$chartType = "GroupedBarGraph";
			$weeksArray = array();
			$year = date("Y");
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
			
			$incomeInnerArray = array();
			$expenseInnerArray = array();
			$dataIsFound = false;
				
			foreach ($weeksArray as $weekRow) {
				$startDate = $weekRow['weekStartDate'];
				$endDate = $weekRow['weekEndDate'];

				$startDateFormatted = date('Y-m-d', strtotime($startDate));
				$endDateFormatted = date('Y-m-d', strtotime($endDate));

				$incomeAccountsTotal = $this->getAccountsTotal($startDateFormatted, $endDateFormatted, "Income", "Both", $locationId);
				$incomeCreditTotal = $incomeAccountsTotal["Credit"];
				$incomeDebitTotal = $incomeAccountsTotal["Debit"];

				$income = (float)$incomeCreditTotal - (float)$incomeDebitTotal;

				$expenseAccountsTotal = $this->getAccountsTotal($startDateFormatted, $endDateFormatted, "Expense", "Both", $locationId);
				$expenseCreditTotal = $expenseAccountsTotal["Credit"];
				$expenseDebitTotal = $expenseAccountsTotal["Debit"];

				$expense = (float)$expenseDebitTotal - (float)$expenseCreditTotal;
			
				$dataRecordIncomeWeek = $startDate . "\n -  \n" . $endDate;
				
				if ($income != 0 || $expense != 0) {
					$dataIsFound = true;
				}

				if ($income != 0) {
					$incomeInnerArray[$dataRecordIncomeWeek] = $income;
				}
				
				if ($expense != 0) {
					if ($income == 0) {
						$incomeInnerArray[$dataRecordIncomeWeek] = $income;
					}
					$expenseInnerArray[$dataRecordIncomeWeek] = $expense;
				} else if ($income != 0) {
					$expenseInnerArray[$dataRecordIncomeWeek] = $expense;
				}
			}

			if ($dataIsFound) {
				$values[] = $incomeInnerArray;
				$values[] = $expenseInnerArray;
			}
		}
		
		if ($chartType == 'BarGraph' || $chartType == 'BarAndLineGraph' || $chartType == 'Bar3DGraph' || $chartType == 'StackedBarGraph' || 
			$chartType == 'StackedBar3DGraph' || $chartType == 'GroupedBarGraph' || $chartType == 'GroupedBar3DGraph' || 
			$chartType == 'Histogram') {

			$settings = array(
				'graph_title' => $this->lang->line($customGraphTitle),
				'graph_title_font_size' => 15,
				'graph_title_font_weight' => 'bold',
				'graph_title_space' => 50,
				'graph_title_colour' => "#ghdgs",
				'label_h' => $this->lang->line($xAxisTitle),
				'label_v' => $this->lang->line($yAxisTitle),
				'label_font_colour' => "#900",
				'label_font' => "serif",
				'label_font_size' => 15,
				'label_font_weight' => 'bold',
				'label_font_space' => 50,
				'show_data_labels' => true,
				'data_label_type' => 'bubble',
				'data_label_space' => 5,
				'data_label_padding' => 5,
				'data_label_round' => 5,
				'data_label_tail_length' => 5,
				'data_label_tail_width' => 5,
				'data_label_font_size' => 12,
				'data_label_shadow_opacity' => 0.3,
				'data_label_outline_thickness' => 2,
				'data_label_position' => 'above',
				'axis_text_angle_h' => -45,
				'legend_entries' => array('Income', 'Expense'),
				'legend_entry_height' => 10,
				'legend_title' => "Legend",
				'legend_draggable' => TRUE,
				'legend_autohide' => FALSE,
				'legend_text_side' =>  "left",
				'legend_position' => '270 -80',
				'data_label_fade_in_speed' => 40,
				'data_label_fade_out_speed' => 5,
				'data_label_click' => array("hide","show"),
				'data_label_popfront' => true,
				'data_label_click' => "hide"
			);
			
			if ($structureDataAvailable) {
				$settings['structured_data'] = true;
				$settings['structure'] = array(
									'key' => 'type',
									'value' => 'amount',
									'data_label_fill' => 'dlbg',
								 );
			}

			$colours = array(array('yellow','white'), array('#01DF01','white'));

		}

		if ($chartType != "" && sizeof($values) > 0) {
			$settings['id_prefix'] = 'a';
			$graphFG = new SVGGraph($graphHeight, $graphWidth, $settings);
			$graphFG->colours = $colours;

			$graphFG->Values($values);

			echo $graphFG->Render($chartType, false);
		} else {
			echo 'report_not_generated';
		}
	}
	
	public function getAssetsComparisonDetails() {
		$chartType = $this->db->escape_str($this->input->post('chart_type'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$assetsAccountLevelForGraph = 3;
		
		$generalLedgerTransactions = $this->journal_entries_model->getAllGeneralLedgerEntries('', '', 'transaction_date', 'asc', '', '', '', '', $locationId);
		
		$accountTotal = array();
		$values = array();
		$legendEntries = array();
		if ($generalLedgerTransactions && sizeof($generalLedgerTransactions) > 0) {
			foreach($generalLedgerTransactions as $generalLedgerTransaction) {
				$chartOfAccount = $this->chart_of_accounts_model->get($generalLedgerTransaction->chart_of_account_id);
				$parentId = $chartOfAccount[0]->parent_id;
				$accountTypeIdRow = $chartOfAccount[0]->account_type;

				if ($accountTypeIdRow == "2") {
					$requiredParentChartOfAccountFound = false;
					$secondLevelChartOfAccountId = '';
					$thirdLevelChartOfAccountId = '';
					$count = 1;
					while($parentId != '2') {

						if ($parentId == '1') {
							break;
						}

						if ($count == 1) {
							$thirdLevelChartOfAccountId = $generalLedgerTransaction->chart_of_account_id;
							$secondLevelChartOfAccountId = $parentId;
						} else {
							$thirdLevelChartOfAccountId = $secondLevelChartOfAccountId;
							$secondLevelChartOfAccountId = $parentId;
						}

						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$count++;
					}

					if ($parentId == '2') {
						if ($generalLedgerTransaction->debit_value > 0) {
							if (!array_key_exists($thirdLevelChartOfAccountId, $accountTotal)) {
								$accountTotal[$thirdLevelChartOfAccountId] = (float)$generalLedgerTransaction->debit_value;
							} else {
								$accountTotal[$thirdLevelChartOfAccountId] = (float)$accountTotal[$thirdLevelChartOfAccountId] + (float)$generalLedgerTransaction->debit_value;
							}
						} else if ($generalLedgerTransaction->credit_value > 0) {
							if (!array_key_exists($thirdLevelChartOfAccountId, $accountTotal)) {
								$accountTotal[$thirdLevelChartOfAccountId] = -(float)($generalLedgerTransaction->credit_value);
							} else {
								$accountTotal[$thirdLevelChartOfAccountId] = (float)$accountTotal[$thirdLevelChartOfAccountId] - (float)$generalLedgerTransaction->credit_value;
							}
						}
					}
				}
			}
		}
		
		if ($accountTotal && sizeof($accountTotal) > 0) {
			$count = 1;
			foreach($accountTotal as $key => $accountValue) {
				
				if ($accountValue > 0) {
					if ($chartType == 'Bar3DGraph') {
						$chartOfAccount = $this->chart_of_accounts_model->get($key);
						$chartOfAccountName = $chartOfAccount[0]->text;
						$innerArray['key'] = "Asset-" . $count;
						$innerArray['amount'] = str_replace(",", "", number_format($accountValue));
						$innerArray['dlbg'] = array('#99f','#fff','#99f','h');
						$legendEntries[] =$chartOfAccountName;
						$values[] = $innerArray;
					} else if ($chartType == 'SemiDonutGraph') {
						$chartOfAccount = $this->chart_of_accounts_model->get($key);
						$chartOfAccountName = $chartOfAccount[0]->text;
						$innerArray['key'] = $chartOfAccountName;
						$innerArray['amount'] = str_replace(",", "", number_format($accountValue));
						$innerArray['dlbg'] = array('#99f','#fff','#99f','h');
						$values[] = $innerArray;
					}
				}
				
				$count++;
			}
		}
		
		if ($chartType == 'Bar3DGraph') {
			$settings = array(
				'graph_title' => $this->lang->line("Assets Value Summary"),
				'graph_title_font_size' => 15,
				'graph_title_font_weight' => 'bold',
				'graph_title_space' => 50,
				'graph_title_colour' => "#ghdgs",
				'label_h' => $this->lang->line("Assets"),
				'label_v' => $this->lang->line("Value"),
				'label_font_colour' => "#900",
				'label_font' => "serif",
				'label_font_size' => 15,
				'label_font_weight' => 'bold',
				'label_font_space' => 50,
				'show_data_labels' => true,
				'data_label_type' => 'bubble',
				'data_label_space' => 5,
				'data_label_padding' => 5,
				'data_label_round' => 5,
				'data_label_tail_length' => 5,
				'data_label_tail_width' => 5,
				'data_label_font_size' => 12,
				'data_label_shadow_opacity' => 0.3,
				'data_label_outline_thickness' => 2,
				'data_label_position' => 'above',
				'axis_text_angle_h' => -45,
				'legend_entries' => $legendEntries,
				'legend_entry_height' => 10,
				'legend_title' => "Legend",
				'legend_draggable' => TRUE,
				'legend_autohide' => FALSE,
				'legend_text_side' =>  "left",
				'legend_position' => '270 -80',
				'data_label_fade_in_speed' => 40,
				'data_label_fade_out_speed' => 5,
				'data_label_click' => array("hide","show"),
				'data_label_popfront' => true,
				'data_label_click' => "hide"
			);
			
			$settings['structured_data'] = true;
			$settings['structure'] = array(
								'key' => 'key',
								'value' => 'amount',
								'data_label_fill' => 'dlbg',
							 );
			
			$colours = array(array('#b3e0ff', '#0039e6'), array('#99ff99', '#008000'), array('#f2ccff', '#8600b3'), array('#e6ccb3', '#86592d'),
							 array('#ffff00', '#808000'), array('#99ffff', '#00b3b3'), array('#d9b3ff', '#6600cc'), array('#ecc6d9', '#862d59'));
		} else if ($chartType == 'SemiDonutGraph') {
			$settings = array(
				'graph_title' => $this->lang->line("Assets Percentage Summary"),
				'graph_title_font_size' => 15,
				'graph_title_font_weight' => 'bold',
				'graph_title_space' => 50,
				'graph_title_colour' => "#ghdgs",
				'back_colour' => '#eee',   
				'stroke_colour' => '#000',
				'back_stroke_width' => 0, 
				'back_stroke_colour' => '#eee',
				'pad_right' => 20,         
				'pad_left' => 20,
				'link_base' => '/',        
				'link_target' => '_top',
				'show_data_labels' => true,     
				'show_label_amount' => false,
				'label_font' => 'Georgia', 
				'label_font_size' => '11',
				'label_colour' => '#585858',
				'label_font_weight' => 'bold',
				'label_font_space' => 50,
				'show_label_percent' => true,
				'label_position' => 0.72,
				'sort' => true,
				'start_angle' => -90
			);

			$settings['structured_data'] = true;
			$settings['structure'] = array(
								'key' => 'key',
								'value' => 'amount',
								'data_label_fill' => 'dlbg',
							 );
			
			$colours = array('#3366ff', '#00cc00', '#bf00ff', '#bf8040','#cccc00','#00e6e6','#8c1aff','#c6538c');
		}
		
		if ($chartType != "" && sizeof($values) > 0) {
			$settings['id_prefix'] = 'b';
			$graphFG = new SVGGraph(470, 300, $settings);
			$graphFG->colours = $colours;

			$graphFG->Values($values);

			echo $graphFG->Render($chartType, false);
		} else {
			echo 'report_not_generated';
		}
	}
	
	public function getLiabilitiesComparisonDetails() {
		$chartType = $this->db->escape_str($this->input->post('chart_type'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$liabilitiesAccountLevelForGraph = 3;
		
		$generalLedgerTransactions = $this->journal_entries_model->getAllGeneralLedgerEntries('', '', 'transaction_date', 'asc', '', '', '', '', $locationId);
		
		$accountTotal = array();
		$values = array();
		$legendEntries = array();
		if ($generalLedgerTransactions && sizeof($generalLedgerTransactions) > 0) {
			foreach($generalLedgerTransactions as $generalLedgerTransaction) {
				$chartOfAccount = $this->chart_of_accounts_model->get($generalLedgerTransaction->chart_of_account_id);
				$parentId = $chartOfAccount[0]->parent_id;
				$accountTypeIdRow = $chartOfAccount[0]->account_type;

				if ($accountTypeIdRow == "6") {
					$requiredParentChartOfAccountFound = false;
					$secondLevelChartOfAccountId = '';
					$thirdLevelChartOfAccountId = '';
					$count = 1;
					while($parentId != '6') {

						if ($parentId == '1') {
							break;
						}

						if ($count == 1) {
							$thirdLevelChartOfAccountId = $generalLedgerTransaction->chart_of_account_id;
							$secondLevelChartOfAccountId = $parentId;
						} else {
							$thirdLevelChartOfAccountId = $secondLevelChartOfAccountId;
							$secondLevelChartOfAccountId = $parentId;
						}

						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$count++;
					}

					if ($parentId == '6') {
						if ($generalLedgerTransaction->credit_value > 0) {
							if (!array_key_exists($thirdLevelChartOfAccountId, $accountTotal)) {
								$accountTotal[$thirdLevelChartOfAccountId] = (float)$generalLedgerTransaction->credit_value;
							} else {
								$accountTotal[$thirdLevelChartOfAccountId] = (float)$accountTotal[$thirdLevelChartOfAccountId] + (float)$generalLedgerTransaction->credit_value;
							}
						} else if ($generalLedgerTransaction->debit_value > 0) {
							if (!array_key_exists($thirdLevelChartOfAccountId, $accountTotal)) {
								$accountTotal[$thirdLevelChartOfAccountId] = -(float)($generalLedgerTransaction->debit_value);
							} else {
								$accountTotal[$thirdLevelChartOfAccountId] = (float)$accountTotal[$thirdLevelChartOfAccountId] - (float)$generalLedgerTransaction->debit_value;
							}
						}
					}
				}
			}
		}
		
		if ($accountTotal && sizeof($accountTotal) > 0) {
			$count = 1;
			foreach($accountTotal as $key => $accountValue) {
				
				if ($accountValue > 0) {
					if ($chartType == 'Bar3DGraph') {
						$chartOfAccount = $this->chart_of_accounts_model->get($key);
						$chartOfAccountName = $chartOfAccount[0]->text;
						$innerArray['key'] = "Liability-" . $count;
						$innerArray['amount'] = str_replace(",", "", number_format($accountValue));
						$innerArray['dlbg'] = array('#99f','#fff','#99f','h');
						$legendEntries[] =$chartOfAccountName;
						$values[] = $innerArray;
					} else if ($chartType == 'SemiDonutGraph') {
						$chartOfAccount = $this->chart_of_accounts_model->get($key);
						$chartOfAccountName = $chartOfAccount[0]->text;
						$innerArray['key'] = $chartOfAccountName;
						$innerArray['amount'] = str_replace(",", "", number_format($accountValue));
						$innerArray['dlbg'] = array('#99f','#fff','#99f','h');
						$values[] = $innerArray;
					}
				}
				
				$count++;
			}
		}
		
		if ($chartType == 'Bar3DGraph') {
			$settings = array(
				'graph_title' =>$this->lang->line("Liabilities Value Summary"),
				'graph_title_font_size' => 15,
				'graph_title_font_weight' => 'bold',
				'graph_title_space' => 50,
				'graph_title_colour' => "#ghdgs",
				'label_h' => $this->lang->line("Liabilities"),
				'label_v' => $this->lang->line("Value"),
				'label_font_colour' => "#900",
				'label_font' => "serif",
				'label_font_size' => 15,
				'label_font_weight' => 'bold',
				'label_font_space' => 50,
				'show_data_labels' => true,
				'data_label_type' => 'bubble',
				'data_label_space' => 5,
				'data_label_padding' => 5,
				'data_label_round' => 5,
				'data_label_tail_length' => 5,
				'data_label_tail_width' => 5,
				'data_label_font_size' => 12,
				'data_label_shadow_opacity' => 0.3,
				'data_label_outline_thickness' => 2,
				'data_label_position' => 'above',
				'axis_text_angle_h' => -45,
				'legend_entries' => $legendEntries,
				'legend_entry_height' => 10,
				'legend_title' => "Legend",
				'legend_draggable' => TRUE,
				'legend_autohide' => FALSE,
				'legend_text_side' =>  "left",
				'legend_position' => '270 -80',
				'data_label_fade_in_speed' => 40,
				'data_label_fade_out_speed' => 5,
				'data_label_click' => array("hide","show"),
				'data_label_popfront' => true,
				'data_label_click' => "hide"
			);
			
			$settings['structured_data'] = true;
			$settings['structure'] = array(
								'key' => 'key',
								'value' => 'amount',
								'data_label_fill' => 'dlbg',
							 );
			
			$colours = array(array('#f2ccff', '#8600b3'), array('#e6ccb3', '#86592d'), array('#ffff00', '#808000'), array('#99ffff', '#00b3b3'), array('#d9b3ff', '#6600cc'), array('#ecc6d9', '#862d59'), array('#b3e0ff', '#0039e6'), array('#99ff99', '#008000'));
		} else if ($chartType == 'SemiDonutGraph') {
			$settings = array(
				'graph_title' => $this->lang->line("Liabilities Percentage Summary"),
				'graph_title_font_size' => 15,
				'graph_title_font_weight' => 'bold',
				'graph_title_space' => 50,
				'graph_title_colour' => "#ghdgs",
				'back_colour' => '#eee',   
				'stroke_colour' => '#000',
				'back_stroke_width' => 0, 
				'back_stroke_colour' => '#eee',
				'pad_right' => 20,         
				'pad_left' => 20,
				'link_base' => '/',        
				'link_target' => '_top',
				'show_data_labels' => true,     
				'show_label_amount' => false,
				'label_font' => 'Georgia', 
				'label_font_size' => '11',
				'label_colour' => '#585858',
				'label_font_weight' => 'bold',
				'label_font_space' => 50,
				'show_label_percent' => true,
				'label_position' => 0.72,
				'sort' => true,
				'start_angle' => -90
			);

			$settings['structured_data'] = true;
			$settings['structure'] = array(
								'key' => 'key',
								'value' => 'amount',
								'data_label_fill' => 'dlbg',
							 );
			
			$colours = array('#c6538c', '#bf8040', '#cccc00', '#00e6e6', '#8c1aff', '#3366ff', '#00cc00', '#bf00ff');
		}
		
		if ($chartType != "" && sizeof($values) > 0) {
			$settings['id_prefix'] = 'c';
			$graphFG = new SVGGraph(470, 300, $settings);
			$graphFG->colours = $colours;

			$graphFG->Values($values);

			echo $graphFG->Render($chartType, false);
		} else {
			echo 'report_not_generated';
		}
	}
	
	public function getTopTenExpenseAccountsComparisonDetails() {
		$chartType = $this->db->escape_str($this->input->post('chart_type'));
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));
		$expenseAccountLevelForGraph = 2;
		
		$generalLedgerTransactions = $this->journal_entries_model->getAllGeneralLedgerEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '', $locationId);
		
		$accountTotal = array();
		$values = array();
		$legendEntries = array();
		if ($generalLedgerTransactions && sizeof($generalLedgerTransactions) > 0) {
			foreach($generalLedgerTransactions as $generalLedgerTransaction) {
				$chartOfAccount = $this->chart_of_accounts_model->get($generalLedgerTransaction->chart_of_account_id);
				$parentId = $chartOfAccount[0]->parent_id;
				$accountTypeIdRow = $chartOfAccount[0]->account_type;

				if ($accountTypeIdRow == "5") {
					$requiredParentChartOfAccountFound = false;
					$secondLevelChartOfAccountId = '';
					$count = 1;
					while($parentId != '5') {

						if ($parentId == '1') {
							break;
						}

						$secondLevelChartOfAccountId = $parentId;

						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
						$count++;
					}

					if ($secondLevelChartOfAccountId == '') {
						$secondLevelChartOfAccountId = $generalLedgerTransaction->chart_of_account_id;
					}

					if ($parentId == '5') {
						if ($generalLedgerTransaction->debit_value > 0) {
							if (!array_key_exists($secondLevelChartOfAccountId, $accountTotal)) {
								$accountTotal[$secondLevelChartOfAccountId] = (float)$generalLedgerTransaction->debit_value;
							} else {
								$accountTotal[$secondLevelChartOfAccountId] = (float)$accountTotal[$secondLevelChartOfAccountId] + (float)$generalLedgerTransaction->debit_value;
							}
						} else if ($generalLedgerTransaction->credit_value > 0) {
							if (!array_key_exists($secondLevelChartOfAccountId, $accountTotal)) {
								$accountTotal[$secondLevelChartOfAccountId] = -(float)($generalLedgerTransaction->credit_value);
							} else {
								$accountTotal[$secondLevelChartOfAccountId] = (float)$accountTotal[$secondLevelChartOfAccountId] - (float)$generalLedgerTransaction->credit_value;
							}
						}
					}
				}
			}
		}
		
		if ($accountTotal && sizeof($accountTotal) > 0) {
			arsort($accountTotal);
			$count = 1;
			foreach($accountTotal as $key => $accountValue) {
				
				if ($count > 10) {
					break;
				}
				
				if ($accountValue > 0) {
					if ($chartType == 'Bar3DGraph') {
						$chartOfAccount = $this->chart_of_accounts_model->get($key);
						$chartOfAccountName = $chartOfAccount[0]->text;
						$innerArray['key'] = "Expense-" . $count;
						$innerArray['amount'] = str_replace(",", "", number_format($accountValue));
						$innerArray['dlbg'] = array('#99f','#fff','#99f','h');
						$legendEntries[] =$chartOfAccountName;
						$values[] = $innerArray;
					} else if ($chartType == 'SemiDonutGraph') {
						$chartOfAccount = $this->chart_of_accounts_model->get($key);
						$chartOfAccountName = $chartOfAccount[0]->text;
						$innerArray['key'] = $chartOfAccountName;
						$innerArray['amount'] = str_replace(",", "", number_format($accountValue));
						$innerArray['dlbg'] = array('#99f','#fff','#99f','h');
						$values[] = $innerArray;
					}
				}
				
				$count++;
			}
		}
		
		if ($chartType == 'Bar3DGraph') {
			$settings = array(
				'graph_title' => $this->lang->line("Expense Account Value Summary"),
				'graph_title_font_size' => 15,
				'graph_title_font_weight' => 'bold',
				'graph_title_space' => 50,
				'graph_title_colour' => "#ghdgs",
				'label_h' => $this->lang->line("Expense"),
				'label_v' => $this->lang->line("Value"),
				'label_font_colour' => "#900",
				'label_font' => "serif",
				'label_font_size' => 15,
				'label_font_weight' => 'bold',
				'label_font_space' => 50,
				'show_data_labels' => true,
				'data_label_type' => 'bubble',
				'data_label_space' => 5,
				'data_label_padding' => 5,
				'data_label_round' => 5,
				'data_label_tail_length' => 5,
				'data_label_tail_width' => 5,
				'data_label_font_size' => 12,
				'data_label_shadow_opacity' => 0.3,
				'data_label_outline_thickness' => 2,
				'data_label_position' => 'above',
				'axis_text_angle_h' => -45,
				'legend_entries' => $legendEntries,
				'legend_entry_height' => 10,
				'legend_title' => "Legend",
				'legend_draggable' => TRUE,
				'legend_autohide' => FALSE,
				'legend_text_side' =>  "left",
				'legend_position' => '270 -80',
				'data_label_fade_in_speed' => 40,
				'data_label_fade_out_speed' => 5,
				'data_label_click' => array("hide","show"),
				'data_label_popfront' => true,
				'data_label_click' => "hide"
			);
			
			$settings['structured_data'] = true;
			$settings['structure'] = array(
								'key' => 'key',
								'value' => 'amount',
								'data_label_fill' => 'dlbg',
							 );
			
			$colours = array(array('#99ffff', '#00b3b3'), array('#d9b3ff', '#6600cc'), array('#f2ccff', '#8600b3'), array('#e6ccb3', '#86592d'), array('#ffff00', '#808000'), array('#ecc6d9', '#862d59'), array('#b3e0ff', '#0039e6'), array('#99ff99', '#008000'));
		} else if ($chartType == 'SemiDonutGraph') {
			$settings = array(
				'graph_title' => $this->lang->line("Expense Account Percentage Summary"),
				'graph_title_font_size' => 15,
				'graph_title_font_weight' => 'bold',
				'graph_title_space' => 50,
				'graph_title_colour' => "#ghdgs",
				'back_colour' => '#eee',   
				'stroke_colour' => '#000',
				'back_stroke_width' => 0, 
				'back_stroke_colour' => '#eee',
				'pad_right' => 20,         
				'pad_left' => 20,
				'link_base' => '/',        
				'link_target' => '_top',
				'show_data_labels' => true,     
				'show_label_amount' => false,
				'label_font' => 'Georgia', 
				'label_font_size' => '11',
				'label_colour' => '#585858',
				'label_font_weight' => 'bold',
				'label_font_space' => 50,
				'show_label_percent' => true,
				'label_position' => 0.72,
				'sort' => true,
				'start_angle' => -90
			);

			$settings['structured_data'] = true;
			$settings['structure'] = array(
								'key' => 'key',
								'value' => 'amount',
								'data_label_fill' => 'dlbg',
							 );
			
			$colours = array('#00e6e6', '#8c1aff', '#3366ff', '#00cc00', '#bf00ff', '#c6538c', '#bf8040', '#cccc00');
		}
		
		if ($chartType != "" && sizeof($values) > 0) {
			$settings['id_prefix'] = 'd';
			$graphFG = new SVGGraph(470, 300, $settings);
			$graphFG->colours = $colours;

			$graphFG->Values($values);

			echo $graphFG->Render($chartType, false);
		} else {
			echo 'report_not_generated';
		}
	}
	
	public function getAccountsTotal($fromDate, $toDate, $accountType, $creditOrDebit, $locationId) {
		$generalLedgerTransactions = $this->journal_entries_model->getAllGeneralLedgerEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '', $locationId);
		
		switch ($accountType) {
			case "Income":
				$accountTypeId = "4";
				break;
			case "Expense":
				$accountTypeId = "5";
				break;
			default:
				break;
		}
		
		$accountTotal = array();
		$accountTotal["Credit"] = 0;
		$accountTotal["Debit"] = 0;
		if ($generalLedgerTransactions && sizeof($generalLedgerTransactions) > 0) {
			foreach($generalLedgerTransactions as $generalLedgerTransaction) {
				$chartOfAccount = $this->chart_of_accounts_model->get($generalLedgerTransaction->chart_of_account_id);
				$accountTypeIdRow = $chartOfAccount[0]->account_type;

				if ($accountTypeIdRow == $accountTypeId) {
					if ($creditOrDebit == "Credit") {
						$accountTotal["Credit"] = $accountTotal["Credit"] + $generalLedgerTransaction->credit_value;
					} else if ($creditOrDebit == "Debit") {
						$accountTotal["Debit"] = $accountTotal["Debit"] + $generalLedgerTransaction->debit_value;
					} else if ($creditOrDebit == "Both") {
						$accountTotal["Credit"] = $accountTotal["Credit"] + $generalLedgerTransaction->credit_value;
						$accountTotal["Debit"] = $accountTotal["Debit"] + $generalLedgerTransaction->debit_value;
					}
				}
			}
		}
		
		return $accountTotal;
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
	
	public function debtorDataTable() {
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
        $locationId = $this->db->escape_str($this->input->post('location_id'));
		
		$debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '102', $locationId , '', 'Yes');
		$creditorRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries('', '', 'transaction_date', 'asc', '', '', '', '104', $locationId , '', 'Yes');
		
		$debtorList = array();
		if ($debtorsRecords != null) {
			foreach ($debtorsRecords as $debtorRecord) {

				$journalEntryId = $debtorRecord->journal_entry_id;
				$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
				$payeePayerId = $journalEntry[0]->payee_payer_id;
				$debitAmount = $debtorRecord->debit_value;
				$creditAmount = $debtorRecord->credit_value;
				
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
		
		$html = "";
		$debtorTotal = '0';
		$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered debtorList'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Debtor')}</th>
							<th>{$this->lang->line('Balance Amount')}</th>
						</tr>
					</thead>
					<tbody>";
							
			if ($debtorList != null) {
				foreach ($debtorList as $key => $value) {
					if (array_key_exists($key, $creditorList)) {
						$debtValue = $value;
						$creditValue = $creditorList[$key];
						
						$finalDebitValue = '0.00';
						if ($debtValue > $creditValue) {
							$finalDebitValue = $debtValue - $creditValue;
						}
						
						if ($finalDebitValue != "0.00"  && $finalDebitValue > "0.009") {
							$debtor = $this->peoples_model->getById($key);

							$debtorName = '';
							if ($debtor && sizeof($debtor) > 0) {
								$debtorName = $debtor[0]->people_name;
							}

							$html .= "<tr>";
							$html .= "<td style='text-align:left;'>" . $debtorName . "</td>";
							$html .= "<td style='text-align:right;'>" . number_format($finalDebitValue, 2) . "</td>";
							$html .= "</tr>";

							$debtorTotal = $debtorTotal + $finalDebitValue;
						}
					} else {
						if ($value != "0.00" ) {
							$debtor = $this->peoples_model->getById($key);

							$debtorName = '';
							if ($debtor && sizeof($debtor) > 0) {
								$debtorName = $debtor[0]->people_name;
							}

							$html .= "<tr>";
							$html .= "<td style='text-align:left;'>" . $debtorName . "</td>";
							$html .= "<td style='text-align:right;'>" . number_format($value, 2) . "</td>";
							$html .= "</tr>";

							$debtorTotal = $debtorTotal + $value;
						}
					}
				}
			}
			$html .= "</tbody>
					</table>
				</div>
			</div>
		</div>";
			
		echo json_encode(array('html' => $html, 'debtorTotal' => number_format($debtorTotal, 2)));
	}
	
	public function creditorDataTable() {
		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
        $locationId = $this->db->escape_str($this->input->post('location_id'));
		
		$debtorsRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries($fromDate, $toDate, 'transaction_date', 'asc', '', '', '', '102', $locationId , '', 'Yes');
		$creditorRecords = $this->journal_entries_model->getAllGeneralLedgerEntriesOfMainJournalEntries('', '', 'transaction_date', 'asc', '', '', '', '104', $locationId , '', 'Yes');
		
		$debtorList = array();
		if ($debtorsRecords != null) {
			foreach ($debtorsRecords as $debtorRecord) {

				$journalEntryId = $debtorRecord->journal_entry_id;
				$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
				$payeePayerId = $journalEntry[0]->payee_payer_id;
				$debitAmount = $debtorRecord->debit_value;
				$creditAmount = $debtorRecord->credit_value;
				
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
		
		$html = "";
		$creditorTotal = '0';
		$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered creditorList'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Creditor')}</th>
							<th>{$this->lang->line('Balance Amount')}</th>
						</tr>
					</thead>
					<tbody>";
							
			if ($creditorList != null) {
				foreach ($creditorList as $key => $value) {
					if (array_key_exists($key, $debtorList)) {
						$creditValue = $value;
						$debitValue = $debtorList[$key];
						
						$finalCreditValue = '0.00';
						if ($creditValue > $debitValue) {
							$finalCreditValue = $creditValue - $debitValue;
						}
						
						if ($finalCreditValue != "0.00" && $finalCreditValue > "0.009") {
							$creditor = $this->peoples_model->getById($key);

							$creditorName = '';
							if ($creditor && sizeof($creditor) > 0) {
								$creditorName = $creditor[0]->people_name;
							}

							$html .= "<tr>";
							$html .= "<td style='text-align:left;'>" . $creditorName . "</td>";
							$html .= "<td style='text-align:right;'>" . number_format($finalCreditValue, 2) . "</td>";
							$html .= "</tr>";

							$creditorTotal = $creditorTotal + $finalCreditValue;
						}
					} else {
						if ($value != "0.00" ) {
							$creditor = $this->peoples_model->getById($key);

							$creditorName = '';
							if ($creditor && sizeof($creditor) > 0) {
								$creditorName = $creditor[0]->people_name;
							}

							$html .= "<tr>";
							$html .= "<td style='text-align:left;'>" . $creditorName . "</td>";
							$html .= "<td style='text-align:right;'>" . number_format($value, 2) . "</td>";
							$html .= "</tr>";

							$creditorTotal = $creditorTotal + $value;
						}
					}
				}
			}
			$html .= "</tbody>
					</table>
				</div>
			</div>
		</div>";
			
		echo json_encode(array('html' => $html, 'creditorTotal' => number_format($creditorTotal, 2)));
	}
}
