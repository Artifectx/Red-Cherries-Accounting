<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define("Version", "1.0 Beta 1");

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->data['message'] = '';
		
		if(file_exists("./application/config/database.php")) {
			$this->load->database();
		} else {
			redirect('./installer/web_installer_configure_database.php?version=' . Version, 'refresh');
		}

		$this->load->library('user_library/User_management');

		$this->userManagement=new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//get user name
		$this->data['username'] = $this->userManagement->getUserName();

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

		//load models
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		//Load version number
		$this->data['version_no'] = $this->userManagement->getSystemVersionNumber();

		$this->data['show_footer'] = true;

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function index() {
		if($this->userManagement->checkUserLogin()) {

			$this->data['system_modules'] = $this->user_model->getAllSystemModules('system_module_id','asc');
			
			$this->load->view('web/systemManagerModule/home/header', $this->data);
			$this->load->view('web/systemManagerModule/home/home', $this->data);
			$this->load->view('web/systemManagerModule/footer/footer', $this->data);
		}
	}

	public function logout() {
		$this->userManagement->logoutUser();
	}

	public function setUserTheme($theme) {
		$this->userManagement->setUserTheme($this->user_id,$theme);
	}

	public function setUserLanguage($language) {
		$this->userManagement->setUserLanguage($this->user_id,$language);
	}

	public function setSystemModulesHeaderTitle() {

		$dataSystemModule = $this->common_model->getSystemModulesHeaderTitle();

		if($dataSystemModule != null) {
			$systemModules = array(
				'system_module' =>  $this->db->escape_str($this->input->post('systemModule')),
				'dashboard_url' => $this->db->escape_str($this->input->post('systemModuleUrl'))
			);

			$this->common_model->setSystemModulesHeaderTitle($this->user_id, $systemModules);
		} else {
			$systemModules = array(
				'system_module' =>  $this->db->escape_str($this->input->post('systemModule')),
				'dashboard_url' => $this->db->escape_str($this->input->post('systemModuleUrl')),
				'user_id' => $this->user_id
			);

			$this->common_model->addSystemModulesHeaderTitle($systemModules);
		}

		echo base_url().$this->db->escape_str($this->input->post('systemModuleUrl'));
	}

	public function setAsDefaultSystemModule() {
		$defaultSystemModules = array(
			'default_system_module_status' =>  $this->db->escape_str($this->input->post('default_system_module_status')),
			'default_system_module' => str_replace("/", "", $this->db->escape_str($this->input->post('default_system_module'))),
			'dashboard_url' => $this->db->escape_str($this->input->post('dashboard_url'))
		);

		$this->userManagement->setUserDefaultSystemModule($this->user_id, $defaultSystemModules);

		echo "ok";
	}
}
