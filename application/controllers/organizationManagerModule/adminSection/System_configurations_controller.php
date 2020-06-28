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

class System_configurations_controller extends CI_Controller {

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
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/organization_calendar_model', '', TRUE);
		$this->load->model('organizationManagerModule/organizationSection/company_structure_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		$this->load->library('common_library/common_functions');

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

		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';
		$data_cls['li_class_system_config'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();
		
		$this->data['country_list'] = $this->locations_model->getAllCountriesAsOptionList();
		$this->data['company_list'] = $this->company_structure_model->getAllCompaniesAsOptionList();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$data['systemConfigData'] = $this->getSystemConfigData();
		
		if(isset($this->data['OGM_Admin_View_System_Configurations_Permissions'])) {
			$this->load->view('web/organizationManagerModule/adminSection/systemConfigurations/index', $data);
		}

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
	
    public function savePeopleConfigData () {
		$PeopleAdditionAuthorizerFeatureEnabled = $this->db->escape_str($this->input->post('people_addition_need_authorization_feature_enabled'));
        $peopleAdditionAuthorizerId = $this->db->escape_str($this->input->post('people_addition_authorizer_id'));
		
		if ($PeopleAdditionAuthorizerFeatureEnabled == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("ogm_people_addition_need_authorization", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("ogm_people_addition_need_authorization", $data);
		}
        
        $data = array(
			'config_filed_value' => $peopleAdditionAuthorizerId,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("ogm_people_addition_authorizer_id", $data);
		
		echo 'ok';
	}

	public function saveOrganizationCalendarConfigData () {
		$saturdayCalendarDayTypeId = $this->db->escape_str($this->input->post('saturday_calendar_day_type_id'));
		$sundayCalendarDayTypeId = $this->db->escape_str($this->input->post('sunday_calendar_day_type_id'));
		$orgCalendarDefaultCountryList = $this->db->escape_str($this->input->post('org_calendar_default_country_list'));
		$orgCalendarDefaultCompanyList = $this->db->escape_str($this->input->post('org_calendar_default_company_list'));

		$data = array(
			'config_filed_value' => $saturdayCalendarDayTypeId,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("saturday_calendar_day_type_id", $data);

		$data = array(
			'config_filed_value' => $sundayCalendarDayTypeId,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("sunday_calendar_day_type_id", $data);
		
		$this->organization_calendar_model->deleteOrgCalendarDefaultCountryAndCompanyData();
		
		if ($orgCalendarDefaultCountryList && sizeof($orgCalendarDefaultCountryList) > 0) {
			
			$currentCountryCode = '';
			
			foreach ($orgCalendarDefaultCountryList as $key => $orgCalendarDefaultCountry) {
				
				$data = array(
					'country_code' => $orgCalendarDefaultCountry,
					'company_id' => $orgCalendarDefaultCompanyList[$key],
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$this->organization_calendar_model->addOrgCalendarDefaultCountryAndCompanyData($data);
			}
		}

		echo 'ok';
	}
	
	public function getOrganizationCalendarConfigData() {
		$saturdayCalendarDayTypeId = $this->system_configurations_model->getSaturdayCalendarDayType();
		$sundayCalendarDayTypeId = $this->system_configurations_model->getSundayCalendarDayType();
        
        if ($saturdayCalendarDayTypeId == '') {
            $saturdayCalendarDayTypeId = '0';
        }
        
        if ($sundayCalendarDayTypeId == '') {
            $sundayCalendarDayTypeId = '0';
        }
		
		echo json_encode(array('saturdayCalendarDayTypeId' => $saturdayCalendarDayTypeId, 'sundayCalendarDayTypeId' => $sundayCalendarDayTypeId));
	}
	
	public function getOrgCalendarDefaultCountryCompanyData() {
		$configData = $this->organization_calendar_model->getOrgCalendarDefaultCountryAndCompanyData();
		
		$countryCount = 0;
		$rowCount = 0;
		$html = '';
		$tempHtml = '';
		$currentCountryCode = '';
		
		if ($configData) {
			
			$countryCount = 1;
			
			foreach($configData as $dataRow) {
				
				$rowCount++;
				
				$countryCode = $dataRow->country_code;
				$companyId = $dataRow->company_id;
				
				$country = $this->common_model->getCountryByCode($countryCode);
				$countryName = $country[0]->country_name;
				
				$company = $this->company_structure_model->get($companyId);
				$companyName = $company[0]->text;
						
				if ($currentCountryCode != '' && $currentCountryCode != $dataRow->country_code) {
					$html[$countryCount] = $tempHtml;
					$tempHtml = '';
					
					$tempHtml .= "<div id='country_and_company_data_row_div_{$rowCount}'>
									<div class='col-sm-5 controls'>
										<input class='form-control' id='country_id_value_{$rowCount}' type='hidden' value='{$countryCode}'>
										<label class='control-label col-sm-8 category_data'>{$countryName}</label>
									</div>
									<div class='col-sm-5 controls'>
										<input class='form-control' id='company_id_value_{$rowCount}' type='hidden' value='{$companyId}'>
										<label class='control-label col-sm-8 category_data'>{$companyName}</label>
									</div>
									<div class='col-sm-2 controls'>
										<button class='btn btn-warning' type='button' id='delete_selected_country_and_company_{$rowCount}' {$this->data['menuFormatting']} onclick='deleteSelectedCountryAndCompany(this.id);'>
											<i class='icon-save'></i>
											{$this->lang->line('Delete')}
										</button>
									</div>
									<p style='margin-bottom:-12px'>&nbsp;</p>
								</div>";
										
					$currentCountryCode = $dataRow->country_code;
					$countryCount++;
				} else {
					$currentCountryCode = $dataRow->country_code;
					
					$tempHtml .= "<div id='country_and_company_data_row_div_{$rowCount}'>
									<div class='col-sm-5 controls'>
										<input class='form-control' id='country_id_value_{$rowCount}' type='hidden' value='{$countryCode}'>
										<label class='control-label col-sm-8 category_data'>{$countryName}</label>
									</div>
									<div class='col-sm-5 controls'>
										<input class='form-control' id='company_id_value_{$rowCount}' type='hidden' value='{$companyId}'>
										<label class='control-label col-sm-8 category_data'>{$companyName}</label>
									</div>
									<div class='col-sm-2 controls'>
										<button class='btn btn-warning' type='button' id='delete_selected_country_and_company_{$rowCount}' {$this->data['menuFormatting']} onclick='deleteSelectedCountryAndCompany(this.id);'>
											<i class='icon-save'></i>
											{$this->lang->line('Delete')}
										</button>
									</div>
									<p style='margin-bottom:-12px'>&nbsp;</p>
								</div>";
				}
			}
			
			$html[$countryCount] = $tempHtml;
		}
		
		echo json_encode(array('rowCount' => $rowCount, 'countryCount' => $countryCount, 'html' => $html));
	}
    
    public function getWelfareShopCustomerCategoryListDropDown($type=null, $disabled=null, $showSelectedIndex=null) {

		if ($type == '') {
			$type = $this->db->escape_str($this->input->post('type'));
            $showSelectedIndex = $this->db->escape_str($this->input->post('show_selected_index'));
			$disabled = false;
		}

        $selectedIndexValue = '';
        
        if ($showSelectedIndex == "Yes") {
            $selectedIndex = $this->system_configurations_model->getWelfareShopCustomerCategory();
            $selectedIndexValue = $selectedIndex[0]->config_filed_value;
        }
        
        $customerCategories = $this->system_configurations_model->getCustomerCategories();

		$peopleCategoryArray = array();

        $peopleCategoryArray['Customer'] = 'Customer';

        if ($customerCategories && sizeof($customerCategories) > 0) {
            foreach ($customerCategories as $customerCategory) {
                $peopleCategoryArray["Customer - ". trim($customerCategory->config_filed_value)] = "&nbsp;&nbsp;&nbsp;&nbsp;" . $customerCategory->config_filed_value;
            }
        }
        
        $html = "<select class='form-control' name='welfare_shop_customer_category' id='welfare_shop_customer_category_id'>
							<option value='0'>{$this->lang->line('-- Select --')}</option>";
                foreach($peopleCategoryArray as $key => $rowPeopleType) {
                    if($key == $selectedIndexValue)
                        $html .= "<option value='{$key}' selected>{$rowPeopleType}</option>";
                    else
                        $html .= "<option value='{$key}'>{$rowPeopleType}</option>";
            }
        $html .="</select>";

		echo $html;
	}
    
    public function getCurrentPeopleAdditionAuthorizerData() {
		echo $this->system_configurations_model->getCurrentPeopleAdditionAuthorizerData();
	}
}
