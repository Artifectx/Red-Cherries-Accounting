<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_day_types_controller extends CI_Controller {
	
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
		$data_cls['li_class_calendar_day_types'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$data['calendar_day_types'] = $this->calendar_day_types_model->getAll('day_type_name', 'asc');

		if (isset($this->data['OGM_Admin_View_Calendar_Day_Types_Permissions'])) {
			$this->load->view('web/organizationManagerModule/adminSection/calendarDayTypes/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if (isset($this->data['OGM_Admin_Add_Calendar_Day_Types_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$data = array(
					'day_type_code' => $this->db->escape_str($this->input->post('day_type_code')),
					'day_type_name' => $this->db->escape_str($this->input->post('day_type_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$this->calendar_day_types_model->add($data);
				echo "ok";
			}
		}
	}

	public function edit() {
		if (isset($this->data['OGM_Admin_Edit_Calendar_Day_Types_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$id = $this->db->escape_str($this->input->post('day_type_id'));

				$data = array(
					'day_type_code' => $this->db->escape_str($this->input->post('day_type_code')),
					'day_type_name' => $this->db->escape_str($this->input->post('day_type_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				
				$this->calendar_day_types_model->edit($id, $data);
				echo "ok";
			}
		}
	}

	public function delete() {
		if (isset($this->data['OGM_Admin_Delete_Calendar_Day_Types_Permissions'])) {
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->calendar_day_types_model->delete($id, $status,$this->user_id)) {
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}
			echo($html);
		}
	}

	public function get() {
		if (isset($this->data['OGM_Admin_Edit_Calendar_Day_Types_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$data['calendar_day_type'] = $this->calendar_day_types_model->getById($id);
			
			$language = $this->userManagement->getUserLanguage($this->user_id);
		
			$menuFormatting = '';
			if ($language == "sinhala") {
				$menuFormatting = 'style="font-weight: bold;"';
			}
		
			$html = "";
			if ($data['calendar_day_type'] != null) {
				foreach ($data['calendar_day_type'] as $row) {
					$html .= "<form class='form form-horizontal validate-form save_form'>
							<input class='form-control'  data-rule-required='true' id='day_type_id' name='day_type_id' type='hidden' value='{$row->day_type_id}'>

							<div class='form-group'>
							   <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Day Type Code')} *</label>
							   <div class='col-sm-4 controls'>
									<input class='form-control' id='day_type_code_edit' name='day_type_code_edit' placeholder='{$this->lang->line('DayType Code')}' type='text'
													   value='{$row->day_type_code}'>
								<div id='day_type_code_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
							   <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Day Type Name')} *</label>
							   <div class='col-sm-4 controls'>
									<input class='form-control' id='day_type_name_edit' name='day_type_name_edit' placeholder='{$this->lang->line('Day Type Name')}' type='text'
													   value='{$row->day_type_name}'>
								<div id='day_type_name_editError' class='red'></div>
								</div>
							</div>";

					$html .=   "<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
					if (isset($this->data['OGM_Admin_Edit_Calendar_Day_Types_Permissions'])){
						$html .="<button class='btn btn-success save' onclick='editData();' type='button'" . $menuFormatting . ">
											<i class='icon-save'></i>
											{$this->lang->line('Edit')}
										</button> ";
						}
						$html.="<button class='btn btn-primary' type='reset'" . $menuFormatting . ">
											<i class='icon-undo'></i>
											{$this->lang->line('Refresh')}
										</button>
										<button class='btn btn-warning cancel' onclick='cancelData();' type='button'" . $menuFormatting . ">
											<i class='icon-ban-circle'></i>
											{$this->lang->line('Close')}
										</button>
									</div>
								</div>
							</div>
						</form>";
				}
			}
			echo $html;
		}
	}

	public function check_existing($dayTypeCode) {

		$exist = false;
		$result = $this->calendar_day_types_model->checkExistingDayTypeCode($dayTypeCode);
		$dayTypeID = $this->input->post('day_type_id');

		if ($dayTypeID != '' && $result) {
			if ($dayTypeID != $result[0]->day_type_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Day Type Code is already in use'));
			return false;
		} else {
			return true;
		}
	}

	public function getTableData(){
		if (isset($this->data['OGM_Admin_View_Calendar_Day_Types_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
									<div class='table-responsive table_data'>
										<div class='scrollable-area1'>
											<table class='table table-striped table-bordered'
												   style='margin-bottom:0;'>
												<thead>";
			$html.="<tr>
													<th>{$this->lang->line('Day Type Code') }</th>
													<th>{$this->lang->line('Day Type Name') }</th>
													<th>{$this->lang->line('Actions')}</th>
												</tr>
												</thead>
												<tbody>";
			$dayTypes = $this->calendar_day_types_model->getAll('day_type_name', 'asc');
			if ($dayTypes != null) {
				foreach ($dayTypes as $row) {
					$html .= "<tr>";
					$html .= "<td>" . $row->day_type_code . "</td>";
					$html .= "<td>" . $row->day_type_name . "</td>";
					$html .= "<td><div class='text-left'>";
					if (isset($this->data['OGM_Admin_Edit_Calendar_Day_Types_Permissions']))
						$html .= "<a class='btn btn-warning btn-xs get' data-id='{$row->day_type_id}' title='Edit' onclick='get($row->day_type_id);'>
										<i class='icon-wrench'></i>
									  </a> ";
					if (isset($this->data['OGM_Admin_Delete_Calendar_Day_Types_Permissions']))
						$html .= "<a class='btn btn-danger btn-xs delete' data-id='{$row->day_type_id}' title='Delete'>
										<i class='icon-remove' onclick='del($row->day_type_id);'></i>
									  </a>";
					$html .="</div></td>";
					$html .= "</tr>";
				}
			}
			$html .="</tbody>
											</table>
										</div>
									</div>
								</div>";
			echo $html;
		}
	}

	public function getAllToCalendarDayTypesDropDown() {
		$options = $this->calendar_day_types_model->getAllCalendarDayTypesAsOptionList("Day Type Name");
			$html = "<div class='form-group'>
						<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Calendar Day Type')} </label>
						<div class='col-sm-4 controls'>
							<select class='form-control' id='calendar_day_type_id'>
								{$options}";
			$html .= "      </select>
						</div>
						<div id='calendar_day_type_idError' class='red'></div>
					</div>";

		echo $html;
	}

	public function getAllToCalendarDayTypesDropDownWithoutLabel() {
		$options = $this->calendar_day_types_model->getAllCalendarDayTypesAsOptionList("Day Type Name");
		$html  = "  <select class='form-control' id='calendar_day_type_id'>
						{$options}";
		$html .= "  </select>";

		echo $html;
	}
	
	public function getCalendarDayTypesToDropDownWithSavedOption($selectedIndex, $field) {
		echo $this->calendar_day_types_model->getCalendarDayTypesToDropDownWithSavedOption($selectedIndex, $field);
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