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

class Dashboard_controller extends CI_Controller {
    
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
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
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

	public function organizationManager() {
		$this->data['systemConfigData'] = $this->getSystemConfigData();
		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/dashboard_organization_manager', $this->data);
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function dashboardAccountsManager() {
		$this->data['systemConfigData'] = $this->getSystemConfigData();

        $this->load->view('web/systemManagerModule/header/header', $this->data);
        $this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $this->data);
        $this->load->view('web/systemManagerModule/dashboard/dashboard_accounts_manager', $this->data);
        $this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function dashboardUserRoleManager() {
		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/dashboard_user_roles_manager', $this->data);
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function dashboardServiceManager() {
		$system_modules = $this->user_model->getAllSystemModules('system_module_id','asc');
		if ($system_modules != null) {
			foreach ($system_modules as $row) {
				if ($row->system_module == 'Service Manager') {
					$this->data['system_sub_modules'] = $this->user_model->getAllSystemSubModules('system_sub_module_id','asc',$row->system_module_id);
				}
			}
		}

        $this->load->view('web/systemManagerModule/home/header', $this->data);
        $this->load->view('web/systemManagerModule/dashboard/dashboard_service_manager', $this->data);
        $this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function dashboardReservationManager() {
        $this->load->view('web/systemManagerModule/header/header', $this->data);
        $this->load->view('web/systemManagerModule/dashboard/menu_reservation_manager', $this->data);
        $this->load->view('web/systemManagerModule/dashboard/dashboard_reservation_manager', $this->data);
        $this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}
	
	public function dashboardDonationManager() {
        $this->load->view('web/systemManagerModule/header/header', $this->data);
        $this->load->view('web/systemManagerModule/dashboard/menu_donation_manager', $this->data);
        $this->load->view('web/systemManagerModule/dashboard/dashboard_donation_manager', $this->data);
        $this->load->view('web/systemManagerModule/footer/footer', $this->data);
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