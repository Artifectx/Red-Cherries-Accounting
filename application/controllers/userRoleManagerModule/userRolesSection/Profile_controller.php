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

class Profile_controller extends CI_Controller {

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
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		$this->setSystemModulesHeaderTitle();

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();
		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
		$this->data['userLanguage'] = $language;

		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
		
		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager');
	}

	public function index() {
		//get theme

	}

	public function password() {
		$this->load->view('web/userRoleManagerModule/userRolesSection/profile/index');
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}
	
	public function language() {
		$this->load->view('web/userRoleManagerModule/userRolesSection/language/index');
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function changePassword() {
		if ($this->form_validation->run() == FALSE) {
			$this->password();
		} else {
            
			$c_password = $this->db->escape_str($this->input->post('current_password'));
			//get user's password according to user name
			$pass = $this->user_model->get_pass($this->userManagement->getUserName());
            
			if ($pass) {
                
				foreach ($pass as $pass) {
					$hash = array($pass->user_password);
				}
                
				$hash = $hash[0];
                
				if (password_verify($c_password, $hash)) {
					
					$options = [
						'cost' => 12,
						'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
					];

					$new_password = password_hash($this->db->escape_str($this->input->post('new_password')), PASSWORD_BCRYPT, $options);

					$salt=$options['salt'];
					$this->user_model->changePassword($this->user_id, $new_password,$salt);
					$this->session->set_flashdata('flashSuccess', $this->lang->line('Password Sucessfully Changed'));
					redirect('userRoleManagerModule/userRolesSection/profile_controller/password');
				} else {
					$this->session->set_flashdata('flashError', $this->lang->line('Incorrect Current Password'));
					redirect('userRoleManagerModule/userRolesSection/profile_controller/password');
				}
			}
		}
	}
	
	public function changeLanguage() {
		if ($this->form_validation->run() == FALSE) {
			$this->language();
		} else {
			$language = $this->db->escape_str($this->input->post('new_language'));
			$this->user_model->setUserLanguage($this->user_id, $language);
			$this->session->set_flashdata('flashSuccess', $this->lang->line('Language Sucessfully Changed'));
			redirect('userRoleManagerModule/userRolesSection/profile_controller/language');
		}
	}
	
	public function setSystemModulesHeaderTitle() {

		$dataSystemModule = $this->common_model->getSystemModulesHeaderTitle();

		if($dataSystemModule != null) {
			$systemModules = array(
				'system_module' =>  "User Role Manager",
				'dashboard_url' => "systemManagerModule/dashboard_controller/dashboardUserRoleManager"
			);

			$this->common_model->setSystemModulesHeaderTitle($this->user_id, $systemModules);
		} else {
			$systemModules = array(
				'system_module' => "Organization",
				'dashboard_url' => "systemManagerModule/dashboard_controller/organizationManager",
				'user_id' => $this->user_id
			);

			$this->common_model->addSystemModulesHeaderTitle($systemModules);
		}
	}
}