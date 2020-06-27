<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donation_help_controller extends CI_Controller {

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

		//Load models
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function index() {
		//set selected menu
		$data_cls['ul_class_donation_section'] = 'in nav nav-stacked';
		$data_cls['li_class_donation_help'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_donation_manager', $data_cls);

		$this->load->view('web/serviceManagerModule/donationManagerModule/donationSection/help/index');
		$this->load->view('web/systemManagerModule/footer/footer');
	}

	public function handleHelpActions() {
		if($this->input->post('download') == "download_user_guide") { 

			$this->downloadAdminHelpUserGuide();
		}
	}

	public function downloadAdminHelpUserGuide() {

		$data = file_get_contents(base_url() . "userGuides/serviceManagerModule/donationManagerModule/donationDetailsSection/Donation_Manager_Donation_Details_User_Guide.pdf"); // Read the file's contents
		$name = 'Donation_Manager_Donation_Details_User_Guide.pdf';

		force_download($name, $data);
	}
}