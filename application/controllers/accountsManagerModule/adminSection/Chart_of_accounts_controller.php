<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_of_accounts_controller extends CI_Controller{

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
		$this->load->model('userRoleManagerModule/user_model','',TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
	}

	public function index(){
		//set selected menu
		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';//to set Administrational Model active in menu
		$data_cls['li_class_chart_of_accounts'] = 'active';//to active chart of account structure link in menu
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);//pass theme data to headader.php
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);//pass menu active to menu.php

		if(isset($this->data['ACM_Admin_View_Chart_Of_Accounts_Permissions']))
			$this->load->view('web/accountsManagerModule/adminSection/chartOfAccounts/index');

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getAllToShow() {
		if(isset($this->data['ACM_Admin_View_Chart_Of_Accounts_Permissions'])){
			$data = $this->chart_of_accounts_model->getAll();
			//echo '<pre>';print_r($data);die;
			$itemsByReference = array();

			if ($data != null) {
				// Build array of item references:
				foreach($data as $key => &$item) {
					$item = get_object_vars($item);

					if ($item['chart_of_account_code'] != "") {
						$item['text'] = $item['chart_of_account_code'] . " - " . $item['text'];
					}

					$itemsByReference[$item['chart_of_account_id']] = &$item;
					// Children array:
					$itemsByReference[$item['chart_of_account_id']]['children'] = array();
					// Empty data class (so that json_encode adds "data: {}" )
					$itemsByReference[$item['chart_of_account_id']]['data'] = new StdClass();
				}

				// Set items as children of the relevant parent item.
				foreach ($data as $key => &$item) {
					if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
						$itemsByReference [$item['parent_id']]['children'][] = &$item;
					}
				}

				// Remove items that were added to parents elsewhere:
				foreach($data as $key => &$item) {
					if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) {
						unset($data[$key]);
					}
				}//echo '<pre>';print_r($data);die;
				echo json_encode($data);
			}else{
				$data[]='No data available';
				echo json_encode($data);
			}
		}
	}

	public function add() {
		if(isset($this->data['ACM_Admin_Add_Chart_Of_Accounts_Permissions'])){
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			}
			else{
				$accountType = $this->db->escape_str($this->input->post('account_type'));
				$chartOfAccountCode = $this->db->escape_str($this->input->post('chart_of_account_code'));
				$chartOfAccountName = $this->db->escape_str($this->input->post('chart_of_account_name'));
				$parentId = $this->db->escape_str($this->input->post('parent_id'));
				$level = $this->db->escape_str($this->input->post('level'));

				$data = array(
					'chart_of_account_code' => $chartOfAccountCode,
					'text' => $chartOfAccountName,
					'account_type' => $accountType,
					'parent_id' => $parentId,
					'level' => $level,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->chart_of_accounts_model->add($data);
				echo "ok";
			}
		}
	}

	public function edit() {
		if(isset($this->data['ACM_Admin_Edit_Chart_Of_Accounts_Permissions'])){
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			}
			else{
				$accountType = $this->db->escape_str($this->input->post('account_type'));
				$chartOfAccountId = $this->db->escape_str($this->input->post('chart_of_account_id'));
				$data = array(
					'chart_of_account_code' => $this->db->escape_str($this->input->post('chart_of_account_code')),
					'text' => $this->db->escape_str($this->input->post('chart_of_account_name')),
					'account_type' => $accountType,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				$this->chart_of_accounts_model->edit($chartOfAccountId, $data);
				echo "ok";
			}
		}
	}

	public function delete() {
		if(isset($this->data['ACM_Admin_Delete_Chart_Of_Accounts_Permissions'])){
			$chart_of_account_id=$this->db->escape_str($this->input->post('chart_of_account_id'));
			$this->chart_of_accounts_model->delete($chart_of_account_id);
			$this->updateParent($chart_of_account_id);
			$this->updateLevel($chart_of_account_id, 0);
			echo "ok";
		}else {
			$html = '<div class="alert alert-warning alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('warning') . '</h4>' .
				$this->lang->line('Sorry, You have no permission') .
				'</div>';
			echo $html;
		}
	}

	public function updateParent($chartOfAccountId) {
		$records = $this->chart_of_accounts_model->getChildren($chartOfAccountId);
		foreach((array)$records as $record) {
			$data = array(
				'parent_id' => 1
			);
			$this->chart_of_accounts_model->updateParent($chartOfAccountId, $data);
		}
	}

	public function move() {
		$chartOfAccountId = $this->db->escape_str($this->input->post('chart_of_account_id'));
		$parentId = $this->db->escape_str($this->input->post('parent_id'));
		$level = $this->db->escape_str($this->input->post('level'));
		$data = array(
				'parent_id' => $parentId,
				'level' => $level
			);
		$this->chart_of_accounts_model->move($chartOfAccountId, $data);
		$this->updateLevel($chartOfAccountId, $level + 1);
		echo "ok";
	}

	public function updateLevel($chartOfAccountId, $level) {
		$records = $this->chart_of_accounts_model->getChildren($chartOfAccountId);
		foreach((array)$records as $record) {
			$childCompany_id = $record['chart_of_account_id'];
			$data = array(
				'level' => $level
			);
			$this->chart_of_accounts_model->updateLevel($childCompany_id, $data);
		}
	}

	public function getAllToChartOfAccountsDropDown() {
		$html = $this->chart_of_accounts_model->getAllToChartOfAccountsDropDown();

		echo $html;
	}

	public function hasChildren() {
		$chartOfAccountId = $this->db->escape_str($this->input->post('chart_of_account_id'));
		$records = $this->chart_of_accounts_model->getChildren($chartOfAccountId);

		if ($records) {
			echo "Yes";
		} else {
			echo "No";
		}
	}

	public function isLevelOneChartOfAccount() {
		$chartOfAccountId = $this->db->escape_str($this->input->post('chart_of_account_id'));
		$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
		$levelOneChartOfAccount = "No";

		if ($chartOfAccount[0]->level == "1") {
			$levelOneChartOfAccount = "Yes";
		}

		echo $levelOneChartOfAccount;
	}

	public function getChartOfAccountName() {
		$chartOfAccountId = $this->db->escape_str($this->input->post('chart_of_account_id'));
		$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);

		echo $chartOfAccount[0]->text;
	}
	
	public function checkWhetherParentChartOfAccountAlreadySelected() {
		$selectedChartOfAccountId = $this->db->escape_str($this->input->post('selected_chart_of_account_id'));
		$alreadySelectedChartOfAccountIds = $this->db->escape_str($this->input->post('already_selected_chart_of_acount_ids'));
		
		$chartOfAccount = $this->chart_of_accounts_model->get($selectedChartOfAccountId);
		$parentId = $chartOfAccount[0]->parent_id;
		
		$parentIdFoundInSelectedChartOfAccounts = false;
		
		if ($alreadySelectedChartOfAccountIds && sizeof($alreadySelectedChartOfAccountIds) > 0) {
			foreach ($alreadySelectedChartOfAccountIds as $chartOfAccountId) {

				while ($parentId != '1') {
					if ($chartOfAccountId == $parentId) {
						$parentIdFoundInSelectedChartOfAccounts = true;
						break;
					} else {
						$chartOfAccount = $this->chart_of_accounts_model->get($parentId);
						$parentId = $chartOfAccount[0]->parent_id;
					}
				}

				if ($parentIdFoundInSelectedChartOfAccounts) {
					break;
				}

				$chartOfAccount = $this->chart_of_accounts_model->get($selectedChartOfAccountId);
				$parentId = $chartOfAccount[0]->parent_id;
			}
		}
		
 		echo $parentIdFoundInSelectedChartOfAccounts;
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