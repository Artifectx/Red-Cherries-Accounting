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

class Google_analytics_controller extends CI_Controller {

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
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);

		//set selected menu
		$data_cls['ul_class_administration_section']='in nav nav-stacked';
		$data_cls['li_class_google_analytics']='active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager',$data_cls);
	}

	public function index() {
		if(isset($this->data['OGM_Admin_View_Google_Analytics_Permissions'])) {
			$dataGoogleAnalytics = $this->google_analytics_model->getAll();
			if ($dataGoogleAnalytics) {
				foreach ($dataGoogleAnalytics as $row) {
					$data['google_analytic'] = array(
						'analytic_code' => $row->analytic_code,
						'enable_in_login' => $row->enable_in_login,
						'enable_in_dashboard' => $row->enable_in_dashboard
					);
				}
				$this->load->view('web/organizationManagerModule/adminSection/google_analytics/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer');
			} else {
				$data['google_analytic'] = array(
					'analytic_code' => '',
					'enable_in_login' => '0',
					'enable_in_dashboard' => '0'
				);
				$this->load->view('web/organizationManagerModule/adminSection/google_analytics/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer', $data);
			}
		}
	}

	public function editGoogleAnalytics() {
		if(isset($this->data['OGM_Admin_Edit_Google_Analytics_Permissions'])){
			$id = 1;
			if($this->input->post('enable_in_login') == 'on') {
				$enable_in_login = 1;
			} else {
				$enable_in_login = 0;
			}

			if($this->input->post('enable_in_dashboard') == 'on') {
				$enable_in_dashboard = 1;
			} else {
				$enable_in_dashboard = 0;
			}

			$dataGoogleAnalytics = $this->google_analytics_model->getAll();

			if ($dataGoogleAnalytics != null) {
				$data = array(
					'analytic_code' => $this->input->post('analytic_code'),
					'enable_in_login' => $enable_in_login,
					'enable_in_dashboard' => $enable_in_dashboard,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				$this->google_analytics_model->edit($id, $data);
			} else {
				$data = array(
					'analytic_id' => 1,
					'analytic_code' => $this->input->post('analytic_code'),
					'enable_in_login' => $enable_in_login,
					'enable_in_dashboard' => $enable_in_dashboard,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->google_analytics_model->add($data);
			}

			$data['massage'] = '<div class="alert alert-success alert-dismissable">
									<a class="close" href="#" data-dismiss="alert">x </a>
									<h4><i class="icon-ok-sign"></i>'.
				$this->lang->line('success').'</h4>'.
				$this->lang->line('success_saved').
				'</div>';

			$data['google_analytic'] = array(
				'analytic_code' => $this->input->post('analytic_code'),
				'enable_in_login' => $enable_in_login,
				'enable_in_dashboard' => $enable_in_dashboard
			);
			$this->load->view('web/organizationManagerModule/adminSection/google_analytics/index', $data);
			$this->load->view('web/systemManagerModule/footer/footer');
		}
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