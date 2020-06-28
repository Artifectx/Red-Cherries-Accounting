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

class Programs_controller extends CI_Controller {

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
		$this->load->model('serviceManagerModule/donationManagerModule/adminSection/programs_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function index() {
		//set selected menu
		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';
		$data_cls['li_class_programs'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_donation_manager', $data_cls);

		if(isset($this->data['SVM_DSM_Admin_View_Programs_Permissions'])) {
			$this->load->view('web/serviceManagerModule/donationManagerModule/adminSection/programs/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['SVM_DSM_Admin_Add_Programs_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$data = array(
					'program_name' => $this->db->escape_str($this->input->post('program_name')),
					'description' => $this->db->escape_str($this->input->post('description')),
					'coordinator_id' => $this->db->escape_str($this->input->post('coordinator_id')),
					'location_id' => $this->db->escape_str($this->input->post('location_id')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$this->programs_model->add($data);
				
				echo "ok";
			}
		}
	}

	public function edit() {
		if(isset($this->data['SVM_DSM_Admin_Edit_Programs_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$programNameChanged = false;
				$descriptionChanged = false;
				$coordinatorChanged = false;
				$locationChanged = false;
				
				$programId = $this->db->escape_str($this->input->post('id'));
				$programName = $this->db->escape_str($this->input->post('program_name'));
				$description = $this->db->escape_str($this->input->post('description'));
				$coordinatorId = $this->db->escape_str($this->input->post('coordinator_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
				
				$programData = $this->programs_model->getById($programId);
				$programNameOld = $programData[0]->program_name;
				$descriptionOld = $programData[0]->description;
				$coordinatorIdOld = $programData[0]->coordinator_id;
				$locationIdOld = $programData[0]->location_id;
				
				if ($programName != $programNameOld) {$programNameChanged = true;}
				if ($description != $descriptionOld) {$descriptionChanged = true;}
				if ($coordinatorId != $coordinatorIdOld) {$coordinatorChanged = true;}
				if ($locationId != $locationIdOld) {$locationChanged = true;}

				if ($programNameChanged || $descriptionChanged || $coordinatorChanged || $locationChanged) {
					
					$dataHistory = array(
						'program_id' => $programId,
						'program_name' => $programNameOld,
						'description' => $descriptionOld,
						'coordinator_id' => $coordinatorIdOld,
						'location_id' => $locationIdOld,
						'actioned_user_id' => $programData[0]->actioned_user_id,
						'action_date' => $programData[0]->action_date,
						'last_action_status' =>$programData[0]->last_action_status
					);

					$this->programs_model->addProgramDataToHistory($dataHistory);
					
					$dataNew = array(
						'program_name' => $programName,
						'description' => $description,
						'coordinator_id' => $coordinatorId,
						'location_id' => $locationId,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->programs_model->edit($programId, $dataNew);

					echo "ok";
				} else {
					echo "no_changes_to_save";
				}
			}
		}
	}

	public function delete() {
		if(isset($this->data['SVM_DSM_Admin_Delete_Programs_Permissions'])) {
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->programs_model->delete($id, $status,$this->user_id)) {
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
		if(isset($this->data['SVM_DSM_Admin_Edit_Programs_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$programData = $this->programs_model->getById($id);
			$html = "";
			if ($programData != null) {
				foreach ($programData as $row) {
					$html .= "	<form class='form form-horizontal validate-form save_form'>
							<input class='form-control'  data-rule-required='true' id='program_id' name='program_id' type='hidden' value='{$row->program_id}'>

							<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Program Name')} *</label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='program_name_edit' name='program_name_edit' placeholder='{$this->lang->line('Program Name')}' type='text' value='{$row->program_name}'>
									<div id='program_name_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Description')}</label>
								<div class='col-sm-4 controls'>
									<textarea class='form-control' id='description_edit'
										name='description_edit' placeholder='{$this->lang->line('Description')}'>{$row->description}</textarea>
									<div id='description_editError' class='red'></div>
								</div>
							</div>";

					$people= $this->peoples_model->getEmployeesAndMembersToDropDownWithSavedOption($row->coordinator_id, "People Name");

					$html .= "  <div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Program Coordinator')} *</label>
									<div class='col-sm-4 controls'>
										<select class='form-control' id='coordinator_id_edit'>
											{$people}
										</select>
										<div id='coordinator_id_editError' class='red'></div>
									</div>
								</div>
							</div>";
					
					$locations= $this->locations_model->getLocationsToDropDownWithSavedOption($row->location_id, "Location Name");

					$html .= "  <div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Location')} *</label>
								<div class='col-sm-4 controls'>
									<select class='form-control' id='location_edit'>
										{$locations}
									</select>
									<div id='location_editError' class='red'></div>
								</div>
							</div>

							<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
					if(isset($this->data['SVM_DSM_Admin_Edit_Programs_Permissions'])) {
						$html .= "<button class='btn btn-success save' onclick='editData();' type='button'>
											<i class='icon-save'></i>
											{$this->lang->line('Edit')}
										</button> ";
					}
					$html.="<button class='btn btn-primary' type='reset'>
											<i class='icon-undo'></i>
											{$this->lang->line('Refresh')}
										</button>
										<button class='btn btn-warning cancel' onclick='cancelData();' type='button'>
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

	public function check_existing($program_name) {

		$exist = false;
		$result = $this->programs_model->checkExistingProgram($program_name);
		$id = $this->input->post('id');

		if ($id != '' && $result) {
			if ($id != $result[0]->program_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Program') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	public function getTableData() {
		if(isset($this->data['SVM_DSM_Admin_View_Programs_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered'
								   style='margin-bottom:0;'>
								<thead>";
						$html.="   <tr>
									<th>{$this->lang->line('Program Name') }</th>
									<th>{$this->lang->line('Description') }</th>
									<th>{$this->lang->line('Program Coordinator') }</th>
									<th>{$this->lang->line('Location') }</th>
									<th>{$this->lang->line('Actions')}</th>
								</tr>
								</thead>
								<tbody>";
			$programs = $this->programs_model->getAll('program_name', 'asc');
			if ($programs != null) {
				foreach ($programs as $row) {
					
					$coordinatorId = $row->coordinator_id;
					$coordinator = $this->peoples_model->getById($coordinatorId);
					$coordinatorName = $coordinator[0]->people_name;
					
					$locationId = $row->location_id;
					$location = $this->locations_model->getById($locationId);
					
					$locationName = '';
					if ($location && sizeof($location) > 0) {
						$locationName = $location[0]->location_name;
					}
					
					$html .= "<tr>";
					$html .= "<td>" . $row->program_name . "</td>";
					$html .= "<td>" . $row->description . "</td>";
					$html .= "<td>" . $coordinatorName . "</td>";
					$html .= "<td>" . $locationName . "</td>";
					$html .= "<td><div class='text-left'>";
					if(isset($this->data['SVM_DSM_Admin_Edit_Programs_Permissions'])) {
						$html .="<a class='btn btn-warning btn-xs get' data-id='{$row->program_id}' title='Edit' onclick='get($row->program_id);'>
								 <i class='icon-wrench'></i></a> ";
					}
					if(isset($this->data['SVM_DSM_Admin_Delete_Programs_Permissions'])) {
						$html .="<a class='btn btn-danger btn-xs delete' data-id='{$row->program_id}' title='Delete' onclick='del($row->program_id);'>
								 <i class='icon-remove'></i></a>";
					}
					$html .= "  </div>
						</td>
						</tr>";
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
	
	public function getAllProgramsToDropDown() {
		echo $this->programs_model->getAllProgramsToDropDown();
	}
}