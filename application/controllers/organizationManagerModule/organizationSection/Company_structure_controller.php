<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_structure_controller extends CI_Controller{

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
		$this->load->model('organizationManagerModule/organizationSection/company_structure_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model','',TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);

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
		$data_cls['ul_class_organization_section'] = 'in nav nav-stacked';//to set Administrational Model active in menu
		$data_cls['li_class_company_structure'] = 'active';//to active company structure link in menu
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);//pass theme data to headader.php
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);//pass menu active to menu.php

		if(isset($this->data['OGM_Organization_View_Company_Structure_Permissions']))
			$this->load->view('web/organizationManagerModule/organizationSection/companyStructure/index');

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getAllToShow() {
		if(isset($this->data['OGM_Organization_View_Company_Structure_Permissions'])){
			$data=$this->company_structure_model->getAll();
			//echo '<pre>';print_r($data);die;
			$itemsByReference = array();

			if ($data != null) {
				// Build array of item references:
				foreach($data as $key => &$item) {
					$item = get_object_vars($item);//echo '<pre>';print_r($item);die;
					$itemsByReference[$item['company_id']] = &$item;
					// Children array:
					$itemsByReference[$item['company_id']]['children'] = array();
					// Empty data class (so that json_encode adds "data: {}" )
					$itemsByReference[$item['company_id']]['data'] = new StdClass();
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
				}
				echo json_encode($data);
			}else{
				$data[]='No data available';
				echo json_encode($data);
			}
		}
	}

	public function add() {
		if(isset($this->data['OGM_Organization_Add_Company_Structure_Permissions'])){
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			}
			else{
				$company_name = $this->db->escape_str($this->input->post('company_name'));
				$parent_id = $this->db->escape_str($this->input->post('parent_id'));
				$level = $this->db->escape_str($this->input->post('level'));

				$data = array(
					'text' => $company_name,
					'parent_id' => $parent_id,
					'level' => $level,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->company_structure_model->add($data);
				echo "ok";
			}
		}
	}

	public function edit() {
		if(isset($this->data['OGM_Organization_Edit_Company_Structure_Permissions'])){
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			}
			else{
				$company_id=$this->db->escape_str($this->input->post('company_id'));
				$data = array(
					'text' => $this->db->escape_str($this->input->post('company_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				$this->company_structure_model->edit($company_id,$data);
				echo "ok";
			}
		}
	}

	public function delete() {
		if(isset($this->data['OGM_Organization_Delete_Company_Structure_Permissions'])){
			$company_id=$this->db->escape_str($this->input->post('company_id'));
			$this->company_structure_model->delete($company_id);
			$this->updateParent($company_id);
			$this->updateLevel(1, 2);
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

	public function updateParent($company_id) {
		$records = $this->company_structure_model->getChildren($company_id);
		foreach((array)$records as $record) {
			$data = array(
				'parent_id' => 1
			);
			$this->company_structure_model->updateParent($company_id, $data);
		}
	}

	public function move() {
		$company_id=$this->db->escape_str($this->input->post('company_id'));
		$parent_id=$this->db->escape_str($this->input->post('parent_id'));
		$level=$this->db->escape_str($this->input->post('level'));
		$data = array(
				'parent_id' => $parent_id,
				'level' => $level
			);
		$this->company_structure_model->move($company_id, $data);
		$this->updateLevel($company_id, $level + 1);
		echo "ok";
	}

	public function updateLevel($company_id, $level) {
		$records = $this->company_structure_model->getChildren($company_id);
		foreach((array)$records as $record) {
			$childCompany_id = $record['company_id'];
			$data = array(
				'level' => $level
			);
			$this->company_structure_model->updateLevel($childCompany_id, $data);
		}
	}

	public function getAllToCompanyDropDown() {
		$html = $this->company_structure_model->getAllToCompanyDropDown();

		echo $html;
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