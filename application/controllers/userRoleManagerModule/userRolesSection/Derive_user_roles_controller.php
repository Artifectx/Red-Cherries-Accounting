<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Derive_user_roles_controller extends CI_Controller {

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
		$data_cls['ul_class_user_roles_section'] = 'in nav nav-stacked';
		$data_cls['li_class_derive_user_roles'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		$data['user_roles'] = $this->user_model->getAllUserRoles('role_id', 'asc');

		if(isset($this->data['URM_User_Roles_View_Derive_User_Role_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/userRolesSection/deriveUserRoles/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	//all derive user roles
	public function getTableData() {
		if(isset($this->data['URM_User_Roles_View_Derive_User_Role_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
				   <div class='table-responsive table_data'>
					 <div class='scrollable-area1'>
						<table class='table table-striped table-bordered'style='margin-bottom:0;'>
						   <thead>
							  <tr>
								  <th>{$this->lang->line('Role ID')}</th>
								  <th>{$this->lang->line('Role')}</th>
								  <th>{$this->lang->line('Derive User Role')}</th>
								  <th>{$this->lang->line('Actions') }</th>
							  </tr>
						   </thead>
				   <tbody>";
			$derive_user_roles = $this->user_model->getAllDeriveUserRolesData('role_id', 'asc');
			if ($derive_user_roles != null) {
				foreach ($derive_user_roles as $row) {
					$html .= "<tr>";
					$html .= "<td>" . $row->derive_user_role_id . "</td>";
					$html .= "<td>" . $row->user_role_name . "</td>";
					$html .= "<td>" . $row->derive_user_role_name . "</td>";
					$html .= "<td><div class='text-left'>";
					if(isset($this->data['URM_User_Roles_Edit_Derive_User_Role_Permissions']))
						$html .= "<a class='btn btn-warning btn-xs get' data-id='{$row->derive_user_role_id}' title='{$this->lang->line('Edit')}' onclick='get($row->derive_user_role_id);' >
								<i class='icon-wrench'></i>
							</a> ";
					if(isset($this->data['URM_User_Roles_Delete_Derive_User_Role_Permissions']))
						$html .="<a class='btn btn-danger btn-xs delete' data-id='{$row->derive_user_role_id}' title='{$this->lang->line('Delete')}' onclick='del($row->derive_user_role_id);'>
								<i class='icon-remove'></i>
							</a>";
					$html .="</div></td>";
					$html .= "</tr>";
				}
			}
			$html .= "</tbody>
					</table>
					</div>
					</div>
					</div>";
			echo $html;
		}
	}

	public function add() {
		if(isset($this->data['URM_User_Roles_Add_Derive_User_Role_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$data = array(
					'role_id' => $this->db->escape_str($this->input->post('role_id')),
					'derive_user_role_name' => $this->db->escape_str($this->input->post('derive_user_role_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				if($this->user_model->addDeriveUserRoles($data)) {
					echo "ok";
				}
			}
		}
	}

	public function edit() {
		if(isset($this->data['URM_User_Roles_Edit_Derive_User_Role_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$id = $this->db->escape_str($this->input->post('id'));
				$data = array(
					'role_id' => $this->db->escape_str($this->input->post('role_id')),
					'derive_user_role_name' => $this->db->escape_str($this->input->post('derive_user_role_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				if($this->user_model->editDeriveUserRoles($id, $data)) {
					echo "ok";
				}
			}
		}
	}

	public function delete() {
		if(isset($this->data['URM_User_Roles_Delete_Derive_User_Role_Permissions'])){
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->user_model->deleteDeriveUserRoles($id, $status)) {
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
		if(isset($this->data['URM_User_Roles_Edit_Derive_User_Role_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$data['derive_user_roles'] = $this->user_model->getByIdDeriveUserRoles($id);
			$data['user_roles'] = $this->user_model->getAllUserRoles('role_id', 'asc');
			
			$language = $this->userManagement->getUserLanguage($this->user_id);
		
			$menuFormatting = '';
			if ($language == "sinhala") {
				$menuFormatting = 'style="font-weight: bold;"';
			}
		
			$html = "";
			if ($data['derive_user_roles'] != null) {
				foreach ($data['derive_user_roles'] as $row) {
					$html .= "<form class='form form-horizontal validate-form save_form'>
							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Role')} *</label>
								<div class='col-sm-4 controls'>
									<select name='role_id_edit' id='role_id_edit' class='form-control'>";
					if ($data['user_roles'] != null) {
						foreach ($data['user_roles'] as $rawUserRoles) {
							if ($rawUserRoles->role_id != 1) {
								if ($rawUserRoles->role_id == $row->role_id)
									$html .= "<option value='$row->role_id' selected>$row->user_role_name</option>";
								else
									$html .= "<option value='$rawUserRoles->role_id'>$rawUserRoles->user_role_name</option>";
							}
						}
					}
					$html.="</select>
									<div id='role_id_editError' class='red'></div>
								</div>
							</div>
							<div class='form-group'>
							  <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Derive User Role')} *</label>
								<div class='col-sm-4 controls'>
									<input class='form-control'  id='id' name='id' type='hidden' value='{$row->derive_user_role_id}'>
									<input class='form-control'  id='derive_user_role_name_edit' name='derive_user_role_name_edit' placeholder='{$this->lang->line('Derive User Role')}' type='text' value='{$row->derive_user_role_name}'>
									<div id='derive_user_role_name_editError' class='red'></div>
								</div>
							</div>
							<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
										if (isset($this->data['URM_User_Roles_Edit_Derive_User_Role_Permissions'])){
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
}