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

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if ($this->session->logged_in_stock) redirect('home', 'refresh');

		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//get user name
		$this->data['username'] = $this->userManagement->getUserName();

		//load language
		$language=$this->userManagement->getUserLanguage($this->user_id);

		//Load version number
		$this->data['version_no'] = $this->userManagement->getSystemVersionNumber();

		$this->data['show_footer'] = false;

		$this->lang->load('form_lang', $language);
		$this->lang->load('message', $language);

		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('organizationManagerModule/organizationSection/company_information_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
	}

	public function index() {
		$data['country'] = $this->common_model->getCountryList('name', 'ase');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('web/systemManagerModule/headerLogin/header_login');
			$this->load->view('web/systemManagerModule/login/login_form',$this->data);
			$this->load->view('web/systemManagerModule/footer/footer', $this->data);
		} else {
			$this->load->view('web/systemManagerModule/header/header', $this->data);

			$username = $this->db->escape_str($this->input->post('username', TRUE));
			$user = $this->user_model->getUserByUserName($username);

			$defaultSystemModule = $this->userManagement->getUserDefaultSystemModule($user[0]->user_id);
			if ($defaultSystemModule[0]->default_system_module_status == '1') {
				redirect($defaultSystemModule[0]->dashboard_url);
			} else {
				$this->load->view('web/systemManagerModule/home/home');
			}

			$this->load->view('web/systemManagerModule/footer/footer', $this->data);

			//get user's default system module

			redirect('home', 'refresh');
		}
	}

	public function check_user($password) {
		$language='';
		$username = $this->db->escape_str($this->input->post('username', TRUE));

		$user = $this->user_model->getUserByUserName($username);

		if ($user) {
			$data['language'] = $this->user_model->getUserLanguageUsername($username);
			if ($data['language'] != null) {
				foreach ($data['language'] as $row) {
					$language = $row->language;
				}
			}
			$sess_language_array = array(
				'language' => $language
			);
			$this->session->set_userdata('logged_in_stock_language', $sess_language_array);

			$pass = $this->user_model->get_pass($username);
			if ($pass) {
				foreach ($pass as $pass) {
					$hash = array($pass->user_password);
				}
				$hash = $hash[0];
				if (password_verify($password, $hash)) {
					$result = $this->user_model->login($username);
					if ($result) {
						foreach ($result as $row) {

							$sess_array = array(
								'user_id' => $row->user_id,
								'username' => $row->user_name
							);
							$this->session->set_userdata('logged_in_stock', $sess_array);
						}
						return true;
					} else {
						$this->form_validation->set_message('check_user', $this->lang->line('error_check_user'));
						return false;
					}
				} else {
					$this->form_validation->set_message('check_user', $this->lang->line('error_check_user'));
					return false;
				}
			} else {
				$this->form_validation->set_message('check_user', $this->lang->line('error_check_user'));
				return false;
			}
		} else {
			$this->form_validation->set_message('check_user', $this->lang->line('error_check_user'));
			return false; 
		}
	}

	//password forgot
	public function resetPassword() {
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
				'</div>');
		} else {
			$email = $this->db->escape_str($this->input->post('email'));
			$data = $this->user_model->check_email($email);
			if ($data != null) {
				foreach ($data as $raw) {
					$user_id = $raw->user_id;
					$email = $raw->email;
					$user_name = $raw->user_name;
					$nameOfUser = $raw->first_name.' '.$raw->last_name;
				}

				//password processing
				$pass = substr(md5(microtime()), rand(0, 26), 6);
				$options = [
					'cost' => 12,
					'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
				];
				$new_password = password_hash($pass, PASSWORD_BCRYPT,$options);
				$salt=$options['salt'];

				//get company details
				$result = $this->company_information_model->getAll();

				$from = $result[0]->email;
				$name = "eStock Manager";
				$sub = $this->lang->line('Forgotten your password for Red Cherries Accounting');
				$msg = "".$this->lang->line('Forgot your password?')."<br><br>Dear " . $nameOfUser . "<br>".$this->lang->line('Your account password has been reset and you can now login to your account area using the details below')."<br><br>".$this->lang->line('User Name')." : " . $user_name . "<br>".$this->lang->line('Password')." : " . $pass . "<br><br>".$this->lang->line('Password')." http://demo-estock.artifectx.com/";
				$this->load->library('email');
				$this->email->clear();
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($from, $name);
				$this->email->to($email);
				$this->email->subject($sub);
				$this->email->message($msg);
				//$this->email->attach('/uploads/bre.jpg');
				if($this->email->send()){
					//change password
					$this->user_model->changePassword($user_id, $new_password,$salt);
					echo "ok";
				}else{
					$html = '<div class="alert alert-warning alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('warning') . '</h4>' .
						$this->lang->line('Sorry, Email sending fail.') .
						'</div>';
					echo ($html);
				}
			} else {
				$html = '<div class="alert alert-warning alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('warning') . '</h4>' .
					$this->lang->line('Sorry, we could not send your password. No account was found with the email address you entered') .
					'</div>';
				echo ($html);
			}
		}
	}

	public function setSystemModulesHeaderTitle() {

		$userName = $this->db->escape_str($this->input->post('user_name'));
		$user = $this->user_model->getUserByUserName($userName);
		$userId = $user[0]->user_id;

		$dataSystemModule = $this->common_model->getSystemModulesHeaderTitle($userId);

		if($dataSystemModule != null) {
			$systemModules = array(
				'system_module' =>  $this->db->escape_str($this->input->post('systemModule')),
				'dashboard_url' => $this->db->escape_str($this->input->post('systemModuleUrl'))
			);

			$this->common_model->setSystemModulesHeaderTitle($userId, $systemModules);
		}else {
			$systemModules = array(
				'system_module' =>  $this->db->escape_str($this->input->post('systemModule')),
				'dashboard_url' => $this->db->escape_str($this->input->post('systemModuleUrl')),
				'user_id' => $userId
			);

			$this->common_model->addSystemModulesHeaderTitle($systemModules);
		}

		echo "ok";
	}
}
