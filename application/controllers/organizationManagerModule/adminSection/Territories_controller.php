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

class Territories_controller extends CI_Controller {
	
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
		$this->load->model('organizationManagerModule/adminSection/territories_model', '', TRUE);
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
		$data_cls['li_class_territories'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$data['territories'] = $this->territories_model->getAll('territory_name', 'asc');

		if (isset($this->data['OGM_Admin_View_Territories_Permissions'])) {
			$this->load->view('web/organizationManagerModule/adminSection/territories/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}


	public function getCountryDropDown() {
		$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
		$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));
		
		$data['country'] = $this->common_model->getCountryList('name', 'ase');
			$html = "<div class='form-group'>
						<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Country')} </label>
						<div class='col-sm-{$dropDownColPosition} controls'>
							<select class='form-control' id='country'>
								<option value=''>" . $this->lang->line('-- Select Country --') . "</option>";
								foreach ($data['country'] as $row) {
									$html .= "<option value='{$row->country_code}'>{$row->country_name}</option>";
								}
			$html .= "      </select>
							<div id='countryError' class='red'></div>
						</div>
					</div>";

		echo $html;
	}

	public function add() {
		if (isset($this->data['OGM_Admin_Add_Territories_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$data = array(
					'territory_code' => $this->db->escape_str($this->input->post('territory_code')),
					'territory_name' => $this->db->escape_str($this->input->post('territory_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->territories_model->add($data);
				
				echo "ok";
			}
		}
	}

	public function edit() {
		if (isset($this->data['OGM_Admin_Edit_Territories_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$id = $this->db->escape_str($this->input->post('territory_id'));

				$data = array(
					'territory_code' => $this->db->escape_str($this->input->post('territory_code')),
					'territory_name' => $this->db->escape_str($this->input->post('territory_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				$this->territories_model->edit($id, $data);
				
				echo "ok";
			}
		}
	}

	public function delete() {
		if (isset($this->data['OGM_Admin_Delete_Territories_Permissions'])) {
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->territories_model->delete($id, $status,$this->user_id)) {
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
		if (isset($this->data['OGM_Admin_Edit_Territories_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$data['territory'] = $this->territories_model->getById($id);
			
			$language = $this->userManagement->getUserLanguage($this->user_id);
		
			$menuFormatting = '';
			if ($language == "sinhala") {
				$menuFormatting = 'style="font-weight: bold;"';
			}
		
			$html = "";
			if ($data['territory'] != null) {
				foreach ($data['territory'] as $row) {
					$html .= "<form class='form form-horizontal validate-form save_form'>
							<input class='form-control'  data-rule-required='true' id='territory_id' name='territory_id' type='hidden' value='{$row->territory_id}'>

							<div class='form-group'>
							   <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Territory Code')} *</label>
							   <div class='col-sm-4 controls'>
									<input class='form-control' id='territory_code_edit' name='territory_code_edit' placeholder='{$this->lang->line('Territory Code')}' type='text'
													   value='{$row->territory_code}'>
								<div id='territory_code_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
							   <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Territory Name')} *</label>
							   <div class='col-sm-4 controls'>
									<input class='form-control' id='territory_name_edit' name='territory_name_edit' placeholder='{$this->lang->line('Territory Name')}' type='text'
													   value='{$row->territory_name}'>
								<div id='territory_name_editError' class='red'></div>
								</div>
							</div>";

					$html .=   "<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
					if (isset($this->data['OGM_Admin_Edit_Territories_Permissions'])){
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

	public function check_existing($territory_code) {

		$exist = false;
		$result = $this->territories_model->checkExistingTerritoryCode($territory_code);
		$territoryID = $this->input->post('territory_id');

		if ($territoryID != '' && $result) {
			if ($territoryID != $result[0]->territory_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Territory code is already in use'));
			return false;
		} else {
			return true;
		}
	}

	public function getTableData(){
		if (isset($this->data['OGM_Admin_View_Territories_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
									<div class='table-responsive table_data'>
										<div class='scrollable-area1'>
											<table class='table table-striped table-bordered'
												   style='margin-bottom:0;'>
												<thead>";
			$html.="<tr>
													<th>{$this->lang->line('Territory Code') }</th>
													<th>{$this->lang->line('Territory Name') }</th>
													<th>{$this->lang->line('Actions') }</th>
												</tr>
												</thead>
												<tbody>";
			$territories = $this->territories_model->getAll('territory_name', 'asc');
			if ($territories != null) {
				foreach ($territories as $row) {
					$html .= "<tr>";
					$html .= "<td>" . $row->territory_code . "</td>";
					$html .= "<td>" . $row->territory_name . "</td>";
					$html .= "<td><div class='text-left'>";
					if (isset($this->data['OGM_Admin_Edit_Territories_Permissions']))
						$html .= "<a class='btn btn-warning btn-xs get' data-id='{$row->territory_id}' title='Edit' onclick='get($row->territory_id);'>
										<i class='icon-wrench'></i>
									  </a> ";
					if (isset($this->data['OGM_Admin_Delete_Territories_Permissions']))
						$html .= "<a class='btn btn-danger btn-xs delete' data-id='{$row->territory_id}' title='Delete'>
										<i class='icon-remove' onclick='del($row->territory_id);'></i>
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

	public function getAllToTerritoriesDropDown() {
		$options = $this->territories_model->getAllTerritoriesAsOptionList("Territory Name");
			$html = "<div class='form-group'>
						<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Territory')} </label>
						<div class='col-sm-4 controls'>
							<select class='form-control' id='territory'>
								{$options}";
			$html .= "      </select>
						</div>
						<div id='territoryError' class='red'></div>
					</div>";

		echo $html;
	}

	public function getAllToTerritoriesDropDownWithoutLabel() {
		$options = $this->territories_model->getAllTerritoriesAsOptionList("Territory Name");
		$html  = "  <select class='form-control' id='territory' onchange='handleTerritorySelect(this.id);'>
						{$options}";
		$html .= "  </select>";

		echo $html;
	}
	
	public function getTerritoriesToDropDownWithSavedOption($selectedIndex, $field) {
		echo $this->territories_model->getTerritoriesToDropDownWithSavedOption($selectedIndex, $field);
	}

	public function getAllToTerritoriesDropDownOnPeopleScreen() {
		$screen = $this->db->escape_str($this->input->post('screen'));
		$peopleCategory = $this->db->escape_str($this->input->post('people_category'));
		$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
		$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));

		$territoryOptions = $this->territories_model->getAllTerritoriesAsOptionList("Territory Name");

		$territoryDropdown = '';
		if ($peopleCategory == 'Agent') {
			if ($screen == "save_screen") {
				$territoryDropdown = " <div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Territory')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='select2 form-control' id='territory' multiple name='territory'>
											{$territoryOptions}
										</select>
										<div id='territoryError' class='red'></div>
									</div>";
			} else if ($screen == "edit_screen") {
				$territoryDropdown = " <div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Territory')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='select2 form-control' id='territory_edit' multiple name='territory_edit'>
											{$territoryOptions}
										</select>
										<div id='territory_editError' class='red'></div>
									</div>";
			}
		} else if ($peopleCategory == 'Customer') {
			if ($screen == "save_screen") {
				$territoryDropdown .= "<div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Territory')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='form-control' name='territory' id='territory'>
											{$territoryOptions}
										</select>
										<div id='territoryError' class='red'></div>
									</div>";
			} else if ($screen == "edit_screen") {
				$territoryDropdown .= "<div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Territory')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='form-control' name='territory_edit' id='territory_edit'>
											{$territoryOptions}
										</select>
										<div id='territory_editError' class='red'></div>
									</div>";
			}
		}

		echo $territoryDropdown;
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