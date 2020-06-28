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

class Organization_calendar_controller extends CI_Controller{

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
		$this->load->model('organizationManagerModule/adminSection/calendar_day_types_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/organization_calendar_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/organizationSection/company_structure_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);

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
		$data_cls['li_class_organization_calendar'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$data['country_list'] = $this->locations_model->getAllCountriesAsOptionList();
		$data['company_list'] = $this->company_structure_model->getAllCompaniesAsOptionList();
		if(isset($this->data['OGM_Admin_View_Calendar_Days_Permissions'])) {
			$this->load->view('web/organizationManagerModule/adminSection/organizationCalendar/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	//check user permission
	public function hasPermission($user_roles, $data) {
		foreach ($user_roles as $row) {
			$data[$row->permission] = $row->permission;
		}
		return $data;
	}
	
	public function initializeCalendar() {
		$draggableDayTypes = '';
		$dayTypes=$this->calendar_day_types_model->getAll('day_type_name','asc');
		//echo "<pre>";print_r($shifts);die;
		if ($dayTypes != '') {
			$count = 1;
			foreach ($dayTypes as $dayType) {
				if (($count%2) != 0) {
					$draggableDayTypes .= "<div title='{$this->lang->line('Drag and drop the day type to the calendar to prepare the organization calendar')}' class='label label-success fc-event'>{$dayType->day_type_name}</div><br>";
				} else {
					$draggableDayTypes .= "<div title='{$this->lang->line('Drag and drop the day type to the calendar to prepare the organization calendar')}' class='label label-warning fc-event'>{$dayType->day_type_name}</div><br>";
				}
				$count++;
			}
		}

		echo json_encode(array('draggableDayTypes' => $draggableDayTypes));
	}

	public function configureOrganizationCalendar() {
		$employeeID = $this->db->escape_str($this->input->post('employee_id'));

		$employeeList = '';
		$employeePersonalDetails = $this->personal_details_model->getById($employeeID);
		$employeeJobDetails = $this->job_details_model->getById($employeeID);
		$employee = $employeeJobDetails[0]->employee_code . " : " . $employeePersonalDetails[0]->first_name . " " . $employeePersonalDetails[0]->last_name;
		$employeeList .= "<div class='bulk-employee'>{$employee}</div><br>";

		$draggableShifts = '';
		$shifts=$this->working_shift_model->getAll('shift_name','asc');
		//echo "<pre>";print_r($shifts);die;
		if ($shifts != '') {
			$count = 1;
			foreach ($shifts as $shift) {
				if (($count%2) != 0) {
					$draggableShifts .= "<div title='{$this->lang->line('Drag and drop the shift to the calendar to prepare the roster')}' class='label label-success fc-event'>{$shift->shift_name}</div><br>";
				} else {
					$draggableShifts .= "<div title='{$this->lang->line('Drag and drop the shift to the calendar to prepare the roster')}' class='label label-warning fc-event'>{$shift->shift_name}</div><br>";
				}
				$count++;
			}
		}

		echo json_encode(array('employeeID' => $employeeID, 'draggableShifts' => $draggableShifts, 'employeeList' => $employeeList));
	}

	public function updateOrganizationCalendar() {
		$eventType = $this->db->escape_str($this->input->post('type'));

		if ($eventType == "new") {
			$countryCode = $this->db->escape_str($this->input->post('country_code'));
			$companyId = $this->db->escape_str($this->input->post('company_id'));
			$calendarDayTypeName = $this->db->escape_str($this->input->post('title'));
			$startDate = $this->db->escape_str($this->input->post('start_date'));

			$calendarDayType = $this->calendar_day_types_model->getCalendarDayTypesByName($calendarDayTypeName);
			$calendarDayTypeId = $calendarDayType[0]->day_type_id;

			$data = array(
				'country_code' => $countryCode,
				'company_id' => $companyId,
				'day_type_id' => $calendarDayTypeId,
				'calendar_date' => $startDate,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'added'
			);

			$this->organization_calendar_model->deleteOrganizationCalendarByCountryCodeCompanyIdAndDate($countryCode, $companyId, $startDate);
			$this->organization_calendar_model->add($data);
			
			echo json_encode(array('status'=>'success'));

		} else if ($eventType == "resetdate") {
			$countryCode = $this->db->escape_str($this->input->post('country_code'));
			$companyId = $this->db->escape_str($this->input->post('company_id'));
			$calendarDayTypeName = $this->db->escape_str($this->input->post('title'));
			$startDate = $this->db->escape_str($this->input->post('start_date'));
			$endDate = $this->db->escape_str($this->input->post('end_date'));

			$calendarDayType = $this->calendar_day_types_model->getCalendarDayTypesByName($calendarDayTypeName);
			$calendarDayTypeId = $calendarDayType[0]->day_type_id;
			//echo $startDate . " :: " . $endDate;die;
			if ($startDate == $endDate) {
				$data = array(
					'country_code' => $countryCode,
					'company_id' => $companyId,
					'day_type_id' => $calendarDayTypeId,
					'calendar_date' => $startDate,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$this->organization_calendar_model->deleteOrganizationCalendarByCountryCodeCompanyIdAndDate($countryCode, $companyId, $startDate);
				$this->organization_calendar_model->add($data);

				echo json_encode(array('status'=>'success'));

			} else {

				$startDateToFormat = new DateTime($startDate);
				$edDateToFormat = new DateTime($endDate);

				$startDateToFormated = $startDateToFormat->format('Y-m-d');
				$endDateToFormated = $edDateToFormat->format('Y-m-d');
				$timeStamp = abs(strtotime($endDateToFormated) - strtotime($startDateToFormated));
				$noOfDays = floor($timeStamp / (60*60*24));
				//Following correction is done due to a bug which could not identified.
				$noOfDays = $noOfDays - 2;

				$date = $startDateToFormated;
				for ($i = 1; $i <= $noOfDays; $i++) {

					$timeOriginal = strtotime($date);
					$timeAdd = $timeOriginal + (3600*24); //add seconds of one day
					$newDate = date("Y-m-d", $timeAdd);
					$date = $newDate;

					$data = array(
						'country_code' => $countryCode,
						'company_id' => $companyId,
						'day_type_id' => $calendarDayTypeId,
						'calendar_date' => $date,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);

					$this->organization_calendar_model->deleteOrganizationCalendarByCountryCodeCompanyIdAndDate($countryCode, $companyId, $date);
					$this->organization_calendar_model->add($data);
				}

				echo json_encode(array('status'=>'success'));

			}
		} else if ($eventType == "fetch") {
			$countryCode = $this->db->escape_str($this->input->post('country_code'));
			$companyId = $this->db->escape_str($this->input->post('company_id'));
			//echo $employeeID;die;
			$calendarDaysList = $this->organization_calendar_model->getOrganizationCalendarByCountryCodeAndCompanyId($countryCode, $companyId);
			//echo "<pre>";print_r($employeeRosters);die;

			if ($calendarDaysList != "") {
				$organizationCalendar = array();
				foreach ($calendarDaysList as $calendarDay) {
					$organizationCalendarDay = array();

					$dayType = $this->calendar_day_types_model->getById($calendarDay->day_type_id);
					$dayTypeName = $dayType[0]->day_type_name;

					$organizationCalendarDay['id'] = $calendarDay->calendar_day_id;
					$organizationCalendarDay['title'] = $dayTypeName;
					$organizationCalendarDay['start'] = $calendarDay->calendar_date;

					array_push($organizationCalendar, $organizationCalendarDay);
				}
				//echo "<pre>";print_r($rosters);die;
				echo json_encode($organizationCalendar);
			}

		} else if ($eventType == "remove") {
			$delta = "";
			$countryCode = $this->db->escape_str($this->input->post('country_code'));
			$companyId = $this->db->escape_str($this->input->post('company_id'));
			$startDate = $this->db->escape_str($this->input->post('start_date'));
			$delta = $this->db->escape_str($this->input->post('delta'));
			//echo "<pre>";print_r($employeeIDs) . " :: " . $date;die;
			//echo $delta;die;

			if ($delta != "") {
				$startDateToFormat = new DateTime($startDate);
				$startDateToFormated = $startDateToFormat->format('Y-m-d');
				$timeStamp = abs(strtotime($startDateToFormated) - ($delta * (60*60*24)));
				$date = date('Y-m-d', $timeStamp);
			} else {
				$date = $startDate;
			}
			//echo $date;die;
			$this->organization_calendar_model->deleteOrganizationCalendarByCountryCodeCompanyIdAndDate($countryCode, $companyId, $date);
			
			echo json_encode(array('status'=>'success'));
		}
	}
	
	public function populateCurrentYearCalendarWithSaturdaysAndSundays() {
		
		$saturdayCalendarDayTypeId = $this->system_configurations_model->getSaturdayCalendarDayType();
		$sundayCalendarDayTypeId = $this->system_configurations_model->getSundayCalendarDayType();
		
		$configData = $this->organization_calendar_model->getOrgCalendarDefaultCountryAndCompanyData();
		
		$year = date('Y'); 
		
		$now = strtotime($year . "-01-01");
		$endDate = strtotime($year . "-12-31");

		while (date("Y-m-d", $now) != date("Y-m-d", $endDate)) {
			$dayIndex = date("w", $now);
			
			if ($configData) {
				foreach($configData as $dataRow) {
					
					$countryCode = $dataRow->country_code;
					$companyId = $dataRow->company_id;
				
					if ($dayIndex == 0) {
						$data = array(
							'country_code' => $countryCode,
							'company_id' => $companyId,
							'day_type_id' => $sundayCalendarDayTypeId,
							'calendar_date' => date("Y-m-d", $now),
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->organization_calendar_model->deleteOrganizationCalendarByCountryCodeCompanyIdAndDate($countryCode, $companyId, date("Y-m-d", $now));
						$this->organization_calendar_model->add($data);
					} else if ($dayIndex == 6) {
						$data = array(
							'country_code' => $countryCode,
							'company_id' => $companyId,
							'day_type_id' => $saturdayCalendarDayTypeId,
							'calendar_date' =>  date("Y-m-d", $now),
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->organization_calendar_model->deleteOrganizationCalendarByCountryCodeCompanyIdAndDate($countryCode, $companyId, date("Y-m-d", $now));
						$this->organization_calendar_model->add($data);
					}
				}
			}
			
			$now = strtotime(date("Y-m-d", $now) . "+1 day");
		}
		
		echo 'ok';
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
