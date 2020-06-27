<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_roles_help_controller extends CI_Controller {

	public function  __construct() {
		parent::__construct();

		$this->load->helper('download');
		$this->load->helper('url');

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

	public function index() {
		//set selected menu
		$data_cls['ul_class_user_roles_section'] = 'in nav nav-stacked';
		$data_cls['li_class_user_roles_help'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		$this->load->view('web/userRoleManagerModule/userRolesSection/help/index');
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function handleHelpActions() {
		if($this->input->post('download') == "download_user_guide") { 

			$this->downloadAdminHelpUserGuide();
		}
	}

	public function downloadAdminHelpUserGuide() {

		$data = file_get_contents(base_url() . "userGuides/userRoleManagerModule/userRolesSection/User_Role_Manager_User_Guide.pdf"); // Read the file's contents
		$name = 'User_Role_Manager_User_Guide.pdf';

		force_download($name, $data);
	}
}