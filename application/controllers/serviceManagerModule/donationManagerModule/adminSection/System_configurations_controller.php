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

class System_configurations_controller extends CI_Controller {

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
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/adminSection/programs_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		$this->load->library('common_library/common_functions');

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function index() {
		//set selected menu

		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';
		$data_cls['li_class_system_config'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_donation_manager', $data_cls);

		$data['systemConfigData'] = $this->getSystemConfigData();

		if(isset($this->data['SVM_DSM_Admin_View_System_Configurations_Permissions'])) {
			$this->load->view('web/serviceManagerModule/donationManagerModule/adminSection/systemConfigurations/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}

		return $configData;
	}

	public function saveCollectDonationConfigData () {
		$accountsPrimeEntryBookList = $this->db->escape_str($this->input->post('dod_cod_accounts_prime_entry_book_list'));

		if ($this->isDonationProgramWiseChartOfAccountInformationEnabled()) {
			
			$this->system_configurations_model->deleteConfigurationFieldWithLike("dod_cod_accounts_prime_entry_book_for_program_id_", $this->user_id);
			
			if ($accountsPrimeEntryBookList && sizeof($accountsPrimeEntryBookList) > 0) {
				foreach ($accountsPrimeEntryBookList as $programId => $accountsPrimeEntryBook) {
					$data = array(
						'config_filed_name' => 'dod_cod_accounts_prime_entry_book_for_program_id_' . $programId,
						'config_filed_value' => $accountsPrimeEntryBook,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);
					$this->system_configurations_model->saveConfigurationField($data);
				}
			}
		} else {
			
			$this->system_configurations_model->deleteConfigurationField("dod_cod_accounts_prime_entry_book", $this->user_id);
			
			if ($accountsPrimeEntryBookList && sizeof($accountsPrimeEntryBookList) > 0) {
				foreach ($accountsPrimeEntryBookList as $accountsPrimeEntryBook) {
					$data = array(
						'config_filed_name' => 'dod_cod_accounts_prime_entry_book',
						'config_filed_value' => $accountsPrimeEntryBook,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);
					$this->system_configurations_model->saveConfigurationField($data);
				}
			}
		}

		echo 'ok';
	}
	
	public function saveBudgetIssueConfigData () {
		$accountsPrimeEntryBookList = $this->db->escape_str($this->input->post('dod_bis_accounts_prime_entry_book_list'));

		if ($this->isDonationProgramWiseChartOfAccountInformationEnabled()) {
			
			$this->system_configurations_model->deleteConfigurationFieldWithLike("dod_bis_accounts_prime_entry_book_for_program_id_", $this->user_id);
			
			if ($accountsPrimeEntryBookList && sizeof($accountsPrimeEntryBookList) > 0) {
				foreach ($accountsPrimeEntryBookList as $programId => $accountsPrimeEntryBook) {
					$data = array(
						'config_filed_name' => 'dod_bis_accounts_prime_entry_book_for_program_id_' . $programId,
						'config_filed_value' => $accountsPrimeEntryBook,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);
					$this->system_configurations_model->saveConfigurationField($data);
				}
			}
		} else {
			
			$this->system_configurations_model->deleteConfigurationField("dod_bis_accounts_prime_entry_book", $this->user_id);
			
			if ($accountsPrimeEntryBookList && sizeof($accountsPrimeEntryBookList) > 0) {
				foreach ($accountsPrimeEntryBookList as $accountsPrimeEntryBook) {
					$data = array(
						'config_filed_name' => 'dod_bis_accounts_prime_entry_book',
						'config_filed_value' => $accountsPrimeEntryBook,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);
					$this->system_configurations_model->saveConfigurationField($data);
				}
			}
		}

		echo 'ok';
	}
	
	public function saveBudgetReturnConfigData () {
		$accountsPrimeEntryBookList = $this->db->escape_str($this->input->post('dod_brt_accounts_prime_entry_book_list'));

		if ($this->isDonationProgramWiseChartOfAccountInformationEnabled()) {
			
			$this->system_configurations_model->deleteConfigurationFieldWithLike("dod_brt_accounts_prime_entry_book_for_program_id_", $this->user_id);
			
			if ($accountsPrimeEntryBookList && sizeof($accountsPrimeEntryBookList) > 0) {
				foreach ($accountsPrimeEntryBookList as $programId => $accountsPrimeEntryBook) {
					$data = array(
						'config_filed_name' => 'dod_brt_accounts_prime_entry_book_for_program_id_' . $programId,
						'config_filed_value' => $accountsPrimeEntryBook,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);
					$this->system_configurations_model->saveConfigurationField($data);
				}
			}
		} else {
			
			$this->system_configurations_model->deleteConfigurationField("dod_brt_accounts_prime_entry_book", $this->user_id);
			
			if ($accountsPrimeEntryBookList && sizeof($accountsPrimeEntryBookList) > 0) {
				foreach ($accountsPrimeEntryBookList as $accountsPrimeEntryBook) {
					$data = array(
						'config_filed_name' => 'dod_brt_accounts_prime_entry_book',
						'config_filed_value' => $accountsPrimeEntryBook,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);
					$this->system_configurations_model->saveConfigurationField($data);
				}
			}
		}

		echo 'ok';
	}
	
	public function saveProgramConfigData() {
		$dodProgramWiseChartOfAccountInformation = $this->db->escape_str($this->input->post('dod_program_wise_chart_of_account_information'));
		
		if ($dodProgramWiseChartOfAccountInformation == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("dod_program_wise_chart_of_account_information", $data);
			
			$this->system_configurations_model->deleteConfigurationField("dod_cod_accounts_prime_entry_book", $this->user_id);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("dod_program_wise_chart_of_account_information", $data);
			
			$this->system_configurations_model->deleteConfigurationFieldWithLike("dod_cod_accounts_prime_entry_book_for_program_id_", $this->user_id);
		}
		
		echo 'ok';
	}

	public function getCollectDonationAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getCollectDonationAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='dod_cod_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_cod_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='dod_cod_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getBudgetIssueAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getBudgetIssueAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='dod_bis_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_bis_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='dod_bis_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getBudgetReturnAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getBudgetReturnAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='dod_brt_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_brt_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='dod_brt_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getProgramWiseCollectDonationAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBookConfigurations = $this->system_configurations_model->getProgramWiseCollectDonationAccountsPrimeEntryBooks();
		
		$accountsPrimeEntryBooks = array();
		
		if ($accountsPrimeEntryBookConfigurations && sizeof($accountsPrimeEntryBookConfigurations) > 0) {
			foreach ($accountsPrimeEntryBookConfigurations as $configuration) {
				$configurationName = $configuration->config_filed_name;
				$programIdNumber = substr($configurationName, 49, 2);
				$accountsPrimeEntryBooks[$programIdNumber] = $configuration->config_filed_value;
			}
		}

		$programData = '';
		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $programId => $accountsPrimeEntryBookId) {
				$program = $this->programs_model->getById($programId);
				$programName = $program[0]->program_name;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;
				
				$programData .= "<div class='form-group' id='dod_cod_program_for_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_cod_program_for_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $programId . "'>
											<div class='col-sm-12 controls'>
												<label class='control-label col-sm-11 program_data'>" . $programName . "</label>
												<div class='col-sm-1 controls'>
													<button class='btn btn-success' type='button' id='dod_cod_delete_program_for_accounts_prime_entry_book_" . $cloneCount . "' style='visibility : hidden'
														onclick='removeProgram(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";

				$accountsPrimeEntryBookData .= "<div class='form-group' id='dod_cod_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_cod_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-12 controls'>
												<label class='control-label col-sm-9 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='dod_cod_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('programData' => $programData, 'accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getProgramWiseBudgetIssueAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBookConfigurations = $this->system_configurations_model->getProgramWiseBudgetIssueAccountsPrimeEntryBooks();
		
		$accountsPrimeEntryBooks = array();
		
		if ($accountsPrimeEntryBookConfigurations && sizeof($accountsPrimeEntryBookConfigurations) > 0) {
			foreach ($accountsPrimeEntryBookConfigurations as $configuration) {
				$configurationName = $configuration->config_filed_name;
				$programIdNumber = substr($configurationName, 49, 2);
				$accountsPrimeEntryBooks[$programIdNumber] = $configuration->config_filed_value;
			}
		}

		$programData = '';
		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $programId => $accountsPrimeEntryBookId) {
				$program = $this->programs_model->getById($programId);
				$programName = $program[0]->program_name;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;
				
				$programData .= "<div class='form-group' id='dod_bis_program_for_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_bis_program_for_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $programId . "'>
											<div class='col-sm-12 controls'>
												<label class='control-label col-sm-11 program_data'>" . $programName . "</label>
												<div class='col-sm-1 controls'>
													<button class='btn btn-success' type='button' id='dod_bis_delete_program_for_accounts_prime_entry_book_" . $cloneCount . "' style='visibility : hidden'
														onclick='removeProgram(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";

				$accountsPrimeEntryBookData .= "<div class='form-group' id='dod_bis_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_bis_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-12 controls'>
												<label class='control-label col-sm-9 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='dod_bis_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('programData' => $programData, 'accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getProgramWiseBudgetReturnAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBookConfigurations = $this->system_configurations_model->getProgramWiseBudgetReturnAccountsPrimeEntryBooks();
		
		$accountsPrimeEntryBooks = array();
		
		if ($accountsPrimeEntryBookConfigurations && sizeof($accountsPrimeEntryBookConfigurations) > 0) {
			foreach ($accountsPrimeEntryBookConfigurations as $configuration) {
				$configurationName = $configuration->config_filed_name;
				$programIdNumber = substr($configurationName, 49, 2);
				$accountsPrimeEntryBooks[$programIdNumber] = $configuration->config_filed_value;
			}
		}

		$programData = '';
		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $programId => $accountsPrimeEntryBookId) {
				$program = $this->programs_model->getById($programId);
				$programName = $program[0]->program_name;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;
				
				$programData .= "<div class='form-group' id='dod_brt_program_for_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_brt_program_for_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $programId . "'>
											<div class='col-sm-12 controls'>
												<label class='control-label col-sm-11 program_data'>" . $programName . "</label>
												<div class='col-sm-1 controls'>
													<button class='btn btn-success' type='button' id='dod_brt_delete_program_for_accounts_prime_entry_book_" . $cloneCount . "' style='visibility : hidden'
														onclick='removeProgram(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";

				$accountsPrimeEntryBookData .= "<div class='form-group' id='dod_brt_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='dod_brt_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-12 controls'>
												<label class='control-label col-sm-9 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='dod_brt_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('programData' => $programData, 'accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function isDonationProgramWiseChartOfAccountInformationEnabled() {
		return $this->system_configurations_model->isDonationProgramWiseChartOfAccountInformationEnabled();
	}
}
