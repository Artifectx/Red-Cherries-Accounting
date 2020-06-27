<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prime_entry_book_controller extends CI_Controller {
    
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
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		
		$this->load->library('common_library/common_functions');

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
		$data_cls['li_class_prime_entry_books'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		if(isset($this->data['ACM_Admin_View_Prime_Entry_Book_Permissions'])) {
			$this->load->view('web/accountsManagerModule/adminSection/primeEntryBook/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['ACM_Admin_Add_Prime_Entry_Book_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');

				echo $result;
			} else {
				$data = array(
					'prime_entry_book_name' => $this->db->escape_str($this->input->post('prime_entry_book_name')),
					'description' => $this->db->escape_str($this->input->post('description')),
					'has_a_reference_journal_entry' => $this->db->escape_str($this->input->post('has_a_reference_transaction_journal_entry')),
					'applicable_module_id' => $this->db->escape_str($this->input->post('applicable_module_id')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$primeEntryBookID = $this->prime_entry_book_model->addPrimeEntryBook($data);

				$debitChartOfAccounts = explode(",", $this->db->escape_str($this->input->post('debit_chart_of_account')));
				$creditChartOfAccounts = explode(",", $this->db->escape_str($this->input->post('credit_chart_of_account')));

				$debitChartOfAccountsCount = sizeof($debitChartOfAccounts);

				for ($i = 0; $i < $debitChartOfAccountsCount; $i++) {
					if ($debitChartOfAccounts[$i] != '0') {
						$data = array(
							'prime_entry_book_id' => $primeEntryBookID,
							'chart_of_account_id' => $debitChartOfAccounts[$i],
							'debit_or_credit' => 'debit',
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->prime_entry_book_model->addPrimeEntryBookChartOfAccount($data);
					}
				}

				$creditChartOfAccountsCount = sizeof($creditChartOfAccounts);

				for ($i = 0; $i < $creditChartOfAccountsCount; $i++) {
					if ($creditChartOfAccounts[$i] != '0') {
						$data = array(
							'prime_entry_book_id' => $primeEntryBookID,
							'chart_of_account_id' => $creditChartOfAccounts[$i],
							'debit_or_credit' => 'credit',
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->prime_entry_book_model->addPrimeEntryBookChartOfAccount($data);
					}
				}

				echo "ok";
			}
		}
	}

	public function edit() {
		if(isset($this->data['ACM_Admin_Edit_Prime_Entry_Book_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');

				echo $result;
			} else {
				$primeEntryBookId = $this->db->escape_str($this->input->post('prime_entry_book_id'));

				$primeEntryBookData = array(
					'prime_entry_book_name' => $this->db->escape_str($this->input->post('prime_entry_book_name')),
					'description' => $this->db->escape_str($this->input->post('description')),
					'has_a_reference_journal_entry' => $this->db->escape_str($this->input->post('has_a_reference_transaction_journal_entry')),
					'applicable_module_id' => $this->db->escape_str($this->input->post('applicable_module_id')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$this->prime_entry_book_model->editPrimeEntryBook($primeEntryBookId, $primeEntryBookData);

				$debitChartOfAccounts = explode(",", $this->db->escape_str($this->input->post('debit_chart_of_account')));
				$creditChartOfAccounts = explode(",", $this->db->escape_str($this->input->post('credit_chart_of_account')));

				$this->prime_entry_book_model->dropPrimeEntryBookChartOfAccounts($primeEntryBookId);

				$debitChartOfAccountsCount = sizeof($debitChartOfAccounts);

				for ($i = 0; $i < $debitChartOfAccountsCount; $i++) {
					if ($debitChartOfAccounts[$i] != '0') {
						$data = array(
							'prime_entry_book_id' => $primeEntryBookId,
							'chart_of_account_id' => $debitChartOfAccounts[$i],
							'debit_or_credit' => 'debit',
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->prime_entry_book_model->addPrimeEntryBookChartOfAccount($data);
					}
				}

				$creditChartOfAccountsCount = sizeof($creditChartOfAccounts);

				for ($i = 0; $i < $creditChartOfAccountsCount; $i++) {
					if ($creditChartOfAccounts[$i] != '0') {
						$data = array(
							'prime_entry_book_id' => $primeEntryBookId,
							'chart_of_account_id' => $creditChartOfAccounts[$i],
							'debit_or_credit' => 'credit',
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->prime_entry_book_model->addPrimeEntryBookChartOfAccount($data);
					}
				}

				echo "ok";
			}
		}
	}

	public function delete() {
		if(isset($this->data['ACM_Admin_Delete_Prime_Entry_Book_Permissions'])) {
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->prime_entry_book_model->deletePrimeEntryBook($id, $status, $this->user_id)) {
				$this->prime_entry_book_model->deletePrimeEntryBookChartOfAccounts($id, $status, $this->user_id);
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">× </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}
			echo($html);
		}
	}

	public function get() {
		if(isset($this->data['ACM_Admin_Edit_Prime_Entry_Book_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$primaryEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($id);

			$primaryEntryBookName = " <input class='form-control' id='prime_entry_book_id' name='prime_entry_book_id' type='hidden' value='{$primaryEntryBook[0]->prime_entry_book_id}'>
								<input class='form-control' id='prime_entry_book_name' name='prime_entry_book_name'
										type='text' value='{$primaryEntryBook[0]->prime_entry_book_name}' placeholder='{$this->lang->line('Prime Entry Book Name')}'>
								<div id='prime_entry_book_nameError' class='red'></div>";

			$description = " <input class='form-control' id='description' name='description'
										type='text' value='{$primaryEntryBook[0]->description}' placeholder='{$this->lang->line('Description')}'>
								<div id='descriptionError' class='red'></div>";
										
			$applicableModuleList = "<select class='form-control' id='applicable_module' name='applicable_module'>
									<option value='0'>{$this->lang->line('-- Select --')}</option>
									<option value='2'>{$this->lang->line('Stock Manager')}</option>
									<option value='3'>{$this->lang->line('Production Manager')}</option>
									<option value='4'>{$this->lang->line('HR Manager')}</option>
									<option value='5'>{$this->lang->line('Payroll Manager')}</option>
									<option value='6'>{$this->lang->line('Service Manager')}</option>
									<option value='7'>{$this->lang->line('Accounts Manager')}</option>
								</select>";
									
			$applicableModuleId = $primaryEntryBook[0]->applicable_module_id;

			$primaryEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($id);

			$chartOfAccountsRowsExists = false;
			if ($primaryEntryBookChartOfAccounts && sizeof($primaryEntryBookChartOfAccounts) > 0) {
				$chartOfAccountsRowsExists = true;

				$debitAccount = array();
				$creditAccount = array();
				foreach($primaryEntryBookChartOfAccounts as $primaryEntryBookChartOfAccount) {
					if ($primaryEntryBookChartOfAccount->debit_or_credit == "debit") {
						$debitAccount[] = $primaryEntryBookChartOfAccount->chart_of_account_id;
					} else if ($primaryEntryBookChartOfAccount->debit_or_credit == "credit") {
						$creditAccount[] = $primaryEntryBookChartOfAccount->chart_of_account_id;
					}
				}
			}

			$chartOfAccountsGroups = '';
			if ($chartOfAccountsRowsExists) {

				$debitAccountCount = sizeof($debitAccount);
				$creditAccountCount = sizeof($creditAccount);

				if ($debitAccountCount > $creditAccountCount) {
					$primaryEntryBookChartOfAccountRowCount = $debitAccountCount;
				} else {
					$primaryEntryBookChartOfAccountRowCount = $creditAccountCount;
				}

				$debitAccountDefaultOptions = $this->chart_of_accounts_model->getAllChartOfAccountsAsOptionList();
				$creditAccountDefaultOptions = $this->chart_of_accounts_model->getAllChartOfAccountsAsOptionList();

				$count = 1;
				for ($count = 1; $count <= $primaryEntryBookChartOfAccountRowCount; $count++) {
					if (array_key_exists($count - 1, $debitAccount)) {
						$debitAccountId = $debitAccount[$count - 1];
						$debitAccountOptions = $this->chart_of_accounts_model->getAllToChartOfAccountDropDownWithSavedOption($debitAccountId);
					} else {
						$debitAccountOptions = '';
					}

					if (array_key_exists($count - 1, $creditAccount)) {
						$creditAccountId = $creditAccount[$count - 1];
						$creditAccountOptions = $this->chart_of_accounts_model->getAllToChartOfAccountDropDownWithSavedOption($creditAccountId);
					} else {
						$creditAccountOptions = '';
					}

					$chartOfAccountsGroups .= "     <div class='col-sm-12 controls row' id='chart_of_accounts_div_" . $count . "'>
														<div class='col-sm-6 controls' id='debit_chart_of_accounts_div_" . $count . "'>";

														if ($debitAccountOptions != '') {
						$chartOfAccountsGroups .= "         <div class='col-sm-10 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:center'>
																<select class='select form-control' id='debit_chart_of_account_" . $count . "' name='debit_chart_of_account' onchange='handleChartOfAccountSelect(this.id);'>
																	{$debitAccountOptions}
																</select>
																<div id='debit_chart_of_account_" . $count . "Error' class='red'></div>
															</div>";
														} else {
						$chartOfAccountsGroups .= "         <div class='col-sm-10 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:center; display:none;'>
																<select class='select form-control' id='debit_chart_of_account_" . $count . "' name='debit_chart_of_account' onchange='handleChartOfAccountSelect(this.id);'>
																	{$debitAccountDefaultOptions}
																</select>
																<div id='debit_chart_of_account_" . $count . "Error' class='red'></div>
															</div>";                                    
														}

					if ($count == 1) {
						$chartOfAccountsGroups .= "             <div class='col-sm-2 controls' id='btnDeleteDebitAccount_div_" . $count . "' style='text-align:center'>
																<button class='btn btn-success' id='btnDeleteDebitAccount_" . $count . "' type='button' onclick='deleteDebitAccount(this.id);' disabled>
																	   {$this->lang->line('Delete')}</button>
															</div>";
					} else {
														if ($debitAccountOptions != '') {
						$chartOfAccountsGroups .= "             <div class='col-sm-2 controls' id='btnDeleteDebitAccount_div_" . $count . "' style='text-align:center'>
																<button class='btn btn-success' id='btnDeleteDebitAccount_" . $count . "' type='button' onclick='deleteDebitAccount(this.id);'>
																	   {$this->lang->line('Delete')}</button>
															</div>";
														} else {
						$chartOfAccountsGroups .= "             <div class='col-sm-2 controls' id='btnDeleteDebitAccount_div_" . $count . "' style='text-align:center; display:none'>
																<button class='btn btn-success' id='btnDeleteDebitAccount_" . $count . "' type='button' onclick='deleteDebitAccount(this.id);'>
																	   {$this->lang->line('Delete')}</button>
															</div>";                                    
														}

					}
						$chartOfAccountsGroups .= "     </div>
														<div class='col-sm-6 controls' id='credit_chart_of_accounts_div_" . $count . "'>";
														if ($creditAccountOptions != '') {
						$chartOfAccountsGroups .= "         <div class='col-sm-10 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:center'>
																<select class='select form-control' id='credit_chart_of_account_" . $count . "' name='credit_chart_of_account' onchange='handleChartOfAccountSelect(this.id);'>
																	{$creditAccountOptions}
																</select>
																<div id='credit_chart_of_account_" . $count . "Error' class='red'></div>
															</div>";
														} else {
						$chartOfAccountsGroups .= "         <div class='col-sm-10 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:center; display:none;'>
																<select class='select form-control' id='credit_chart_of_account_" . $count . "' name='credit_chart_of_account' onchange='handleChartOfAccountSelect(this.id);'>
																	{$creditAccountDefaultOptions}
																</select>
																<div id='credit_chart_of_account_" . $count . "Error' class='red'></div>
															</div>";                                    
														}

					if ($count == 1) {
						$chartOfAccountsGroups .= "             <div class='col-sm-2 controls' id='btnDeleteCreditAccount_div_" . $count . "' style='text-align:center'>
																<button class='btn btn-success' id='btnDeleteCreditAccount_" . $count . "' type='button' onclick='deleteCreditAccount(this.id);' disabled>
																	   {$this->lang->line('Delete')}</button>
															</div>";
					} else {
														if ($creditAccountOptions != '') {
						$chartOfAccountsGroups .= "             <div class='col-sm-2 controls' id='btnDeleteCreditAccount_div_" . $count . "' style='text-align:center'>
																<button class='btn btn-success' id='btnDeleteCreditAccount_" . $count . "' type='button' onclick='deleteCreditAccount(this.id);'>
																	   {$this->lang->line('Delete')}</button>
															</div>";
														} else {
						$chartOfAccountsGroups .= "             <div class='col-sm-2 controls' id='btnDeleteCreditAccount_div_" . $count . "' style='text-align:center; display:none;'>
																<button class='btn btn-success' id='btnDeleteCreditAccount_" . $count . "' type='button' onclick='deleteCreditAccount(this.id);'>
																	   {$this->lang->line('Delete')}</button>
															</div>";                                    
														}
					}

					$chartOfAccountsGroups .= "         </div>
													</div>

													<p id='row_space_" . $count . "' style='margin-bottom:5px'>&nbsp;</p>";
				}
			} else {
				$chartOfAccountOptions = $this->chart_of_accounts_model->getAllChartOfAccountsAsOptionList();

				$chartOfAccountsGroups .= "     <div class='col-sm-12 controls row' id='chart_of_accounts_div_1'>
													<div class='col-sm-6 controls' id='debit_chart_of_accounts_div_1'>
														<div class='col-sm-10 controls' id='debit_chart_of_account_div_1' style='text-align:center'>
															<select class='select form-control' id='debit_chart_of_account_1' name='debit_chart_of_account' onchange='handleChartOfAccountSelect(this.id);'>
																{$chartOfAccountOptions}
															</select>
															<div id='debit_chart_of_account_1Error' class='red'></div>
														</div>
														<div class='col-sm-2 controls' id='btnDeleteDebitAccount_div_1' style='text-align:center'>
															<button class='btn btn-success' id='btnDeleteDebitAccount_1' type='button' onclick='deleteDebitAccount(this.id);' disabled>
																   {$this->lang->line('Delete')}</button>
														</div>
													</div>
													<div class='col-sm-6 controls' id='credit_chart_of_accounts_div_1'>
														<div class='col-sm-10 controls' id='credit_chart_of_account_div_1' style='text-align:center'>
															<select class='select form-control' id='credit_chart_of_account_1' name='credit_chart_of_account' onchange='handleChartOfAccountSelect(this.id);'>
																{$chartOfAccountOptions}
															</select>
															<div id='credit_chart_of_account_1Error' class='red'></div>
														</div>
														<div class='col-sm-2 controls' id='btnDeleteCreditAccount_div_1' style='text-align:center'>
															<button class='btn btn-success' id='btnDeleteCreditAccount_1' type='button' onclick='deleteCreditAccount(this.id);' disabled>
																   {$this->lang->line('Delete')}</button>
														</div>
													</div>
												</div>

												<p id='row_space_1' style='margin-bottom:5px'>&nbsp;</p>";
			}

			echo json_encode(array('primaryEntryBookName' => $primaryEntryBookName, 'description' => $description,  'applicableModuleList' => $applicableModuleList, 'applicableModuleId' => $applicableModuleId, 'hasAReferenceTransactionJournalEntry' => $primaryEntryBook[0]->has_a_reference_journal_entry, 'chartOfAccountsGroups' => $chartOfAccountsGroups));
		}
	}

	public function check_existing($primeEntryBookName) {
		$exist = false;
		$result = $this->prime_entry_book_model->checkExisting($primeEntryBookName);
		$primeEntryBookId = $this->input->post('prime_entry_book_id');

		if ($primeEntryBookId != '' && $result) {
			if ($primeEntryBookId != $result[0]->prime_entry_book_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Prime Entry Book') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Admin_View_Prime_Entry_Book_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Prime Entry Book Name')}</th>
							<th>{$this->lang->line('Applicable Module')}</th>
							<th>{$this->lang->line('Actions')}</th>
						</tr>
					</thead>
					<tbody>";
			$primeEntryBooks = $this->prime_entry_book_model->getAllPrimeEntryBooks('prime_entry_book_name', 'asc');
			
            $moduleArray = array();
            array_push($moduleArray, "0");
            $allModules = $this->user_model->getAllSystemModules('system_module_id', 'asc');
            
            foreach($allModules as $module) {
                $moduleName = $module->system_module;
                
                switch ($moduleName) {
                    case "Stock Manager":
                        array_push($moduleArray, $module->system_module_id);
                        break;
                    case "Production Manager":
                        array_push($moduleArray, $module->system_module_id);
                        break;
                    case "HR Manager":
                        array_push($moduleArray, $module->system_module_id);
                        break;
                    case "Payroll Manager":
                        array_push($moduleArray, $module->system_module_id);
                        break;
                    case "Service Manager":
                        array_push($moduleArray, $module->system_module_id);
                        break;
                    case "Accounts Manager":
                        array_push($moduleArray, $module->system_module_id);
                        break;
                    default:
                        break;
                }
            }
			
			if ($primeEntryBooks != null) {
				foreach ($primeEntryBooks as $row) {
					
					$systemModuleId = $row->applicable_module_id;
					
					if (in_array($systemModuleId, $moduleArray)) {
						$systemModule = $this->common_model->getSystemModuleById($systemModuleId);

						$systemModuleName = '';
						if ($systemModule && sizeof($systemModule) > 0) {
							$systemModuleName = $systemModule[0]->system_module;
						}

						$html .= "<tr>";
						$html .= "<td>" . $row->prime_entry_book_name . "</td>";
						$html .= "<td>" . $systemModuleName . "</td>";
						$html .= "<td>
											<div class='text-left'>";
											if(isset($this->data['ACM_Admin_Edit_Prime_Entry_Book_Permissions']))
												$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->prime_entry_book_id}' title='{$this->lang->line('Edit')}' onclick='get($row->prime_entry_book_id);'>
													<i class='icon-wrench'></i>
												</a> ";
											if(isset($this->data['ACM_Admin_Delete_Prime_Entry_Book_Permissions']))
												$html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->prime_entry_book_id}' title='{$this->lang->line('Delete')}' onclick='del($row->prime_entry_book_id);'>
													<i class='icon-remove'></i>
												</a>
											</div>
										</td>";
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

	public function getAllPrimeEntryBookOptionsToDropDown() {
        
        $moduleArray = array();
        array_push($moduleArray, "0");

        $moduleList = $this->user_model->getAllSystemModules('system_module_id','asc');

        foreach ($moduleList as $module) {
            array_push($moduleArray, $module->system_module_id);
        }
        
		$this->prime_entry_book_model->getAllPrimeEntryBooksToDropDown($moduleArray);
	}
	
	public function isThereAReferenceTransactionJournalEntry() {
		$primeEntryBookId = $this->db->escape_str($this->input->post('prime_entry_book_id'));
		
		$primaryEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($primeEntryBookId);
		$thereIsAReferenceJournalEntry = $primaryEntryBook[0]->has_a_reference_journal_entry;
		
		echo $thereIsAReferenceJournalEntry;
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
