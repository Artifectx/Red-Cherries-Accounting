<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_settings_controller extends CI_Controller {

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

		//load models
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function get() {
		//$id = $this->db->escape_str($this->input->post('id'));
		$id=$this->user_id;
		$data['web_settings'] = $this->common_model->getWebSettings($id);
		foreach($data['web_settings'] as $row){
			$navStatus=$row->main_nav_btn;
		}
		if($navStatus=="open")echo "main-nav-closed";
		else echo "main-nav-opened";
	}

	public function chanageNavOption() {
		//$id = $this->db->escape_str($this->input->post('id'));
		$id=$this->user_id;
		$data['web_settings'] = $this->common_model->getWebSettings($id);
		foreach($data['web_settings'] as $row){
			$navStatus=$row->main_nav_btn;
		}
		if($navStatus=="open"){
			$data="closed";
			$this->common_model->chanageNavOption($id, $data);
			echo "main-nav-closed";
		}
		else{
			$data="open";
			$this->common_model->chanageNavOption($id, $data);
			echo "main-nav-opened";
		}
	}

	public function extendUserSessionExpiration() {
		
		$userSessionExirationStatus = $this->system_configurations_model->isDisableUserSessionExpirationEnabled();
		
		if ($userSessionExirationStatus && $userSessionExirationStatus == "Yes"){
			$lastActivity = $this->session->userdata('last_activity');
			$configTimeout = $this->config->item("sess_expiration");
			$sessonExpireson = $lastActivity+$configTimeout;


			$threshold = $sessonExpireson - 300; //Five minutes before session time out

			$currentTime = time();

			if($currentTime>=$threshold){
				$this->session->set_userdata('last_activity', time());
				echo "Session Re-registered";
			}else{
				echo "Not yet time to re-register";
			}
		} else {
			echo "No need to extend session expiration";
		}
	}
}