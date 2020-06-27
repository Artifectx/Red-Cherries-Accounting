<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_management {
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('userRoleManagerModule/user_model', '', TRUE);

		//Load Google Analytics model
		$this->CI->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
	}

	//check user login
	public function checkUserLogin() {
		if (!$this->CI->session->logged_in_stock)
			redirect('login', 'refresh');
		else
			return true;
	}

	//get user id
	public function getUserId() {
		$session_data = $this->CI->session->userdata('logged_in_stock');
		return $this->user_id = $session_data['user_id'];
	}

	//get employee id
	public function getPeopleId() {
		$session_data = $this->CI->session->userdata('logged_in_stock');
		$userId = $session_data['user_id'];
		$user = $this->CI->user_model->getById($userId);
		return $user[0]->people_id;
	}

	//get user name
	public function getUserName() {
		$session_data = $this->CI->session->userdata('logged_in_stock');
		return $userName = $session_data['username'];
	}

	public function isSuperAdmin () {
		$session_data = $this->CI->session->userdata('logged_in_stock');
		if ($session_data['username'] == "Super_Admin") {
			return true;
		} else {
			return false;
		}
	}

	//get user language
	public function getUserLanguage($userId){
		$language='';
		if ($this->CI->session->logged_in_stock) {
			$data['language'] = $this->CI->user_model->getUserLanguage($userId);
			if ($data['language'] != null) {
				foreach ($data['language'] as $row) {
					$language = $row->language;
				}
			}
		} else {
			if($this->CI->session->logged_in_stock_language){
				$session_language_data = $this->CI->session->userdata('logged_in_stock_language');
				$language=$session_language_data['language'];
			}else{
				$language = 'english';
			}
		}
		return $language;
	}

	//get user theme
	public function getUserTheme($userId){
		return $data=$this->CI->user_model->getUserTheme($userId);
	}

	//get user permission
	public function getUserPermissions($data, $userId=null){
		$this->getUserRoleId($userId);

		if($this->derive_user_role_id) {
			$user_roles = $this->CI->user_model->getDeriveUserRolePermissions($this->derive_user_role_id);
		} else {
			$user_roles = $this->CI->user_model->getUserPermission($this->role_id);
		}

		if($user_roles)
			$data = $this->hasPermission($user_roles, $data);
		return $data;
	}

	//get user role id
	public function getUserRoleId($userId){
		
		if ($userId != '') {
			$data['role_id'] = $this->CI->user_model->getUserRole($userId);
		} else {
			$data['role_id'] = $this->CI->user_model->getUserRole($this->user_id);
		}
		if ($data['role_id'] != null) {
			foreach ($data['role_id'] as $row) {
				$this->role_id = $row->role_id;
				$this->derive_user_role_id = $row->derive_user_role_id;
			}
		}
	}

	//check user has permission
	public function hasPermission($user_roles, $data) {
		foreach ($user_roles as $row) {
			$data[$row->permission] = $row->permission;
		}
		return $data;
	}

	//logout user
	public function logoutUser(){
		$this->CI->session->unset_userdata('logged_in_stock');
		$this->CI->session->unset_userdata('logged_in_stock_language');
		$this->CI->session->unset_userdata('system_modules_header');
		session_destroy();
		redirect('login', 'refresh');
	}

	//set user theme
	public function setUserTheme($userId,$theme){
		$this->CI->user_model->setUserTheme($userId, $theme);
		redirect('home', 'refresh');
	}

	//set user language
	public function setUserLanguage($userId,$language){
		$this->CI->user_model->setUserLanguage($userId, $language);
	}

	public function getSystemVersionNumber() {
		$verionConfiguration = $this->CI->user_model->getSystemVersionNumber();
		return $verionConfiguration[0]->config_filed_value;
	}

	//set default system module
	public function setUserDefaultSystemModule($userId, $defaultSystemModules){
		$this->CI->user_model->setUserDefaultSystemModule($userId, $defaultSystemModules);
	}

	//set default system module
	public function getUserDefaultSystemModule($userId){
		return $this->CI->user_model->getUserDefaultSystemModule($userId);
	}
}