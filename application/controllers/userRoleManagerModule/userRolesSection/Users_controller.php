<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_controller extends CI_Controller {
	
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
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);

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
		$data_cls['li_class_users'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		$data['user_roles'] = $this->user_model->getAllUserRoles('role_id', 'asc');
		$data['derive_user_roles'] = $this->user_model->getAllDeriveUserRolesData('role_id', 'asc');
		
		$data['multiple_locations_available'] = $this->areMultipleLocationsAvailable();

		if(isset($this->data['URM_User_Roles_View_Users_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/userRolesSection/users/index',$data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if (isset($this->data['URM_User_Roles_Add_Users_Permissions'])) {
			if($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$peopleId = $this->db->escape_str($this->input->post('people_id'));
				$user = $this->peoples_model->getById($peopleId);
				$email = $user[0]->people_email;
				$options = [
					'cost' => 12,
					'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
				];
				$UserPassword = password_hash($this->db->escape_str($this->input->post('user_password')), PASSWORD_BCRYPT,$options);
				$salt = $options['salt'];

				if($this->db->escape_str($this->input->post('role_id')) == '') {
					$roleId = '3';
				} else {
					$roleId = $this->db->escape_str($this->input->post('role_id'));
				}
				
				$data = array(
					'people_id' => $peopleId,
					'user_name' => $this->db->escape_str($this->input->post('user_name')),
					'user_password' => $UserPassword,
					'salt' => $salt,
					'status' => $this->db->escape_str($this->input->post('status')),
					'theme' => 'red',
					'language' => 'english',
					'main_nav_btn' => 'close',
					'role_id' => $roleId,
					'derive_user_role_id' => $this->db->escape_str($this->input->post('derive_user_role_id')),
					'email' => $email,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$userId = $this->user_model->add($data);
				
				echo "ok";
			}
		}
	}

	public function edit() {
		if (isset($this->data['URM_User_Roles_Edit_Users_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$id = $this->db->escape_str($this->input->post('id'));

				$peopleId = $this->db->escape_str($this->input->post('people_id_new'));
				$user = $this->peoples_model->getById($peopleId);
				$email = $user[0]->people_email;
				$options = [
					'cost' => 12,
					'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
				];
				$UserPassword = password_hash($this->db->escape_str($this->input->post('user_password')), PASSWORD_BCRYPT,$options);
				$salt = $options['salt'];
				if($this->db->escape_str($this->input->post('role_id')) =='')
					$roleId = '3';
				else
					$roleId = $this->db->escape_str($this->input->post('role_id'));
				
				$data = array(
					'people_id' => $peopleId,
					'user_name' => $this->db->escape_str($this->input->post('user_name')),
					'user_password' => $UserPassword,
					'salt' => $salt,
					'status' => $this->db->escape_str($this->input->post('status')),
					'theme' => 'green',
					'language' => 'english',
					'main_nav_btn' => 'close',
					'role_id' => $roleId,
					'derive_user_role_id' => $this->db->escape_str($this->input->post('derive_user_role_id')),
					'email' => $email,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'Edited'
				);
				
				$this->user_model->edit($id, $data);
				
				echo "ok";
			}
		}
	}

	public function delete() {
		if (isset($this->data['URM_User_Roles_Delete_Users_Permissions'])) {
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->user_model->delete($id, $status)) {
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
		if (isset($this->data['URM_User_Roles_Edit_Users_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$users = $this->user_model->getById($id);
			
			$userPermissions = array();
			$userPermissions = $this->userManagement->getUserPermissions($userPermissions, $id);
			
			$derive_user_roles = $this->user_model->getAllDeriveUserRolesData('derive_user_role_id','asc');
			$user_roles = $this->user_model->getAllUserRoles('role_id', 'asc');
			
			$language = $this->userManagement->getUserLanguage($this->user_id);
		
			$menuFormatting = '';
			if ($language == "sinhala") {
				$menuFormatting = 'style="font-weight: bold;"';
			}
			
			$html = "";
			if ($users != null) {
				foreach ($users as $row) {
					$html .= "<form class='form form-horizontal validate-form save_form'>
							<input class='form-control'  data-rule-required='true' id='id' name='id' type='hidden' value='{$row->user_id}'>
							<input class='form-control'  data-rule-required='true' id='people_id_hidden' name='people_id_hidden' type='hidden' value='{$row->people_id}'>

							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Employee')} *</label>
								<div class='col-sm-4 controls'>
									<select class='select2 form-control' id='people_id_edit'>";
				$html .=                $this->peoples_model->getEmployeeToDropDownWithSavedOption($row->people_id, "People Name");
				$html .="           </select>
								<div id='people_id_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('User Name')} *</label>
								<div class='col-sm-4 controls'>
									<input class='form-control'  id='user_name_edit'
									 name='user_name_edit' placeholder='{$this->lang->line('User Name')}' type='text' value='{$row->user_name}''>
									<div id='user_name_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Password') } *</label>
								<div class='col-sm-4 controls'>
									<input class='pwstrength form-control'  id='new_password_edit'
												   name='new_password_edit' placeholder='{$this->lang->line('Password')}' type='password' value=''>
									<div id='new_password_editError' class='red'></div>
								</div>
							 </div>
							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Confirm Password')} *</label>
								<div class='col-sm-4 controls'>
									<input class='form-control'  id='confirm_password_edit'
										   name='confirm_password_edit' placeholder='{$this->lang->line('Confirm Password') }' type='password' value=''>
									<div id='confirm_password_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Default User Roles')} </label>
								<div class='col-sm-4 controls'>
									<select name='role_id_edit' id='role_id_edit' class='form-control'>";
									if ($user_roles != null) {
										foreach ($user_roles as $rawUserRoles) {
											if ($rawUserRoles->role_id != 1) {
												if ($rawUserRoles->role_id == $row->role_id) {
													$html .= "<option value='$rawUserRoles->role_id' selected>$rawUserRoles->user_role_name</option>";
												} else {
													$html .= "<option value='$rawUserRoles->role_id'>$rawUserRoles->user_role_name</option>";
												}
											}
										}
									}
									$html.="</select>
									<div id='role_id_editError' class='red'></div>
								</div>
							</div>
							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Derive User Roles')} </label>
								<div class='col-sm-4 controls'>
									<select name='derive_user_role_id_edit' id='derive_user_role_id_edit' class='form-control'>";
									if ($derive_user_roles != null) {
										$html .= " <option value=''>{$this->lang->line('-- Select --')}</option>";
										foreach ($derive_user_roles as $rawDeriveUserRoles) {
											if ($rawDeriveUserRoles->derive_user_role_id == $row->derive_user_role_id) {
												$html .= "<option value='$rawDeriveUserRoles->derive_user_role_id' selected>$rawDeriveUserRoles->derive_user_role_name</option>";
											} else {
												$html .= " <option value='$rawDeriveUserRoles->derive_user_role_id'>$rawDeriveUserRoles->derive_user_role_name</option>";
											}
										}
									}
									$html.="</select>
									<div id='derive_user_role_id_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
								<label class='control-label col-sm-3'>{$this->lang->line('Status')} </label>
								<div class='col-sm-4 controls'>
									<select name='status_edit' id='status_edit' class='form-control'>";
							if ($row->status =='1') {
								$html .= "<option value='1' selected>{$this->lang->line('Active')}</option>
								<option value='2'>{$this->lang->line('Inactive')}</option>";
							}else{
								$html .= "<option value='1'>{$this->lang->line('Active')}</option>
								<option value='2' selected>{$this->lang->line('Inactive')}</option>";
							}

					$html.="</select>
									<div id='status_editError' class='red'></div>
								</div>
							</div>
							";
					
							if (isset($userPermissions['ACM_Admin_View_Prime_Entry_Book_Permissions'])) {
				$html .= "		<div class='form-group'>
                                <div class='col-sm-3 controls'></div>
                                <div class='col-sm-4 controls'>
									<button class='btn btn-success save' onclick='openPrimeEntryBookAccesiblePermissionsDialog({$id});'
											type='button'" .  $menuFormatting . ">
										<i class='icon-ban-circle'></i>
										{$this->lang->line('Set Not Accessible Prime Entry Books')}
									</button>
								</div>";
							}
							
				$html .= "	</div>";

					$html .=   "<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
									if (isset($this->data['URM_User_Roles_Edit_Users_Permissions'])) {
										$html .="<button class='btn btn-success save' onclick='editData();' type='button'" . $menuFormatting . ">
															<i class='icon-save'></i>
															{$this->lang->line('Edit')}
														</button> ";
									}
					$html .="<button class='btn btn-primary' type='reset'" . $menuFormatting . ">
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

	public function check_existing($people_id) {
		$exist = false;
		$result = $this->user_model->checkExisting($people_id);
		$peopleId = $this->db->escape_str($this->input->post('people_id_old'));

		if ($result != '') {
			if ($peopleId != $result[0]->people_id) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('User account') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	public function getTableData() {
		
		$status = '';
		if(isset($this->data['URM_User_Roles_View_Users_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
									<div class='table-responsive table_data'>
										<div class='scrollable-area1'>
											<table class='table table-striped table-bordered'
												   style='margin-bottom:0;'>
												<thead>";
			$html.="<tr>
													<th>{$this->lang->line('Name') }</th>
													<th>{$this->lang->line('User Name') }</th>
													<th>{$this->lang->line('Role') }</th>
													<th>{$this->lang->line('Derive Role') }</th>
													<th>{$this->lang->line('Status') }</th>
													<th>{$this->lang->line('Actions')}</th>
												</tr>
												</thead>
												<tbody>";
			$users = $this->user_model->getAll('user_id', 'asc');
			if ($users != null) {
				foreach ($users as $row) {
					if($row->user_name != 'Super_Admin'){
						$html .= "<tr>";
						$html .= "<td>" . $row->people_name . "</td>";
						$html .= "<td>" . $row->user_name . "</td>";
						$html .= "<td>" . $row->user_role_name . "</td>";
						$html .= "<td>" . $row->derive_user_role_name . "</td>";
						if($row->status == 1){
							$status = 'Active';
							$cls = 'label label-success';
						}else{
							$status = 'Inactive';
							$cls='label label-important';
						}

						$html .= "<td><span class='$cls'>" . $status. "</span></td>";
						$html .= "<td><div class='text-left'>";
						
                        if(isset($this->data['URM_User_Roles_Edit_Users_Permissions']))
                            $html .= "<a class='btn btn-warning btn-xs get' data-id='{$row->user_id}' title='Edit' onclick='get($row->user_id);'>
                                        <i class='icon-wrench'></i>
                                      </a> ";
                        if(isset($this->data['URM_User_Roles_Delete_Users_Permissions']))
                            $html .= "<a class='btn btn-danger btn-xs delete' data-id='{$row->user_id}' title='Delete'>
                                        <i class='icon-remove' onclick='del($row->user_id);'></i>
                                      </a>";

						$html .="</div></td>";
						$html .= "</tr>";
					}
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
	
	public function areMultipleLocationsAvailable() {
		$locations = $this->locations_model->getAll("location_name", "asc");
		
		if ($locations && sizeof($locations) > 1) {
			return true;
		} else {
			return false;
		}
	}
	
	public function savePrimeEntryBookAccesiblePermissions() {
		$userId = $this->db->escape_str($this->input->post('user_id'));
		$primeEntryBookIds = $this->db->escape_str($this->input->post('prime_entry_book_ids'));
		
		$finalPrimeEntryBookIds = array();
		$primeEntryBookIdList = explode(',', $primeEntryBookIds);
		foreach ($primeEntryBookIdList as $primeEntryBookId) {
			if ($primeEntryBookId != '') {
				$finalPrimeEntryBookIds[] = $primeEntryBookId;
			}
		}
		
		$this->user_model->deleteNotAccessiblePrimeEntryBook($userId);
		
		if ($finalPrimeEntryBookIds && sizeof($finalPrimeEntryBookIds) > 0) {
			foreach ($finalPrimeEntryBookIds as $finalPrimeEntryBookId) {
				$data = array(
					'user_id' => $userId,
					'prime_entry_book_id' => $finalPrimeEntryBookId,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$this->user_model->addNotAccessiblePrimeEntryBook($data);
			}
		}
		
		echo 'ok';
	}
	
	function getNotAccessiblePrimeEntryBookIdList() {
		$userId = $this->db->escape_str($this->input->post('user_id'));
		
		$primeEntryBookIds = $this->user_model->getNotAccessiblePrimeEntryBooksOfAUser($userId);
		
		$primeEntryBookIdList = '';
		foreach ($primeEntryBookIds as $primeEntryBookId) {
			$primeEntryBookIdList[] = $primeEntryBookId;
		}
		
		echo json_encode(array('primeEntryBookIdList' => $primeEntryBookIdList));
	}
}