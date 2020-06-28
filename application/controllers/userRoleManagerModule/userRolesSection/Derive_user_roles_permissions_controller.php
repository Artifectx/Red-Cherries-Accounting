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

class Derive_user_roles_permissions_controller extends CI_Controller {

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
		$data_cls['li_class_derive_user_role_permissions'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		$data['user_roles'] = $this->user_model->getAllDeriveUserRolesData('role_id', 'asc');

		if(isset($this->data['URM_User_Roles_View_Derive_User_Roles_Permissions_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/userRolesSection/deriveUserRolePermissions/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getAdvancedPermissionList() {
		$permissionIds = $this->db->escape_str($this->input->post('permission_ids'));
		$userRoleId = $this->db->escape_str($this->input->post('user_role_id'));
        
        $permissionIds = str_replace("/", "", $permissionIds);
        
        $permissionIdList = explode("-", $permissionIds);

        $childPermissionsArray = array();
        
        if ($permissionIdList && sizeof($permissionIdList) > 0) {
            foreach($permissionIdList as $permissionId) {
                $childPermissions = $this->user_model->getAdvancedPermissionsForAPermission($permissionId);
                $childPermissionsArray = array_merge($childPermissionsArray, $childPermissions);
            }
        }

		$html = '';

		$count = 0;
		foreach ($childPermissionsArray as $childPermission) {
			$childPermissionId = $childPermission->child_permission_id;

			$permission = $this->user_model->getPermissionByPermissionId($childPermissionId);
			$permissionName = $permission[0]->permission_description;

			$userRolePermission = $this->user_model->getDeriveUserRolePermission($userRoleId, $childPermissionId);

			$html .= "  <div class='col-sm-6 controls'>
							<input type='checkbox' name='permission_id_" . $childPermissionId . "' id='permission_id_" . $childPermissionId . "' style='vertical-align: text-bottom;'
								   onchange='handlePermissionChange(this.id, {$userRoleId});' ";
								if ($userRolePermission) {
			$html .=               "checked";                        
								}   

			$html .=        ">
							<label for='permission_id_" . $childPermissionId . "' >{$permissionName}</label>
						</div>";

			$count++;
		}

		$html .= "<p style='margin-bottom:" . ($count/2)*15 . "px'>&nbsp;</p>";

		echo $html;
	}

	public function editAdvancedPermission() {
		$deriveUserRoleId  = $this->db->escape_str($this->input->post('derive_user_role_id'));
		$permissionId  = $this->db->escape_str($this->input->post('permission_id'));
		$operation  = $this->db->escape_str($this->input->post('operation'));

		if ($operation == "remove") {
			$this->user_model->deleteDeriveUserRoleSinglePermission($deriveUserRoleId, $permissionId);
		} else if ($operation == "add") {

			$data = array(
				'derive_user_role_id' => $deriveUserRoleId,
				'permission_id' => $permissionId,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'added'
			);

			$this->user_model->addDeriveUserRolePermission($data);
		}

		echo 'ok';
	}

	public function getTableData() {
		if(isset($this->data['URM_User_Roles_View_Derive_User_Roles_Permissions_Permissions'])) {
			$roleId = '';
			$deriveRoleId  = $this->db->escape_str($this->input->post('id'));
			$dataDeriveUserRoles = $this->user_model->getByIdDeriveUserRoles($deriveRoleId);
			$roleId = $dataDeriveUserRoles[0]->role_id;
			
			$language = $this->userManagement->getUserLanguage($this->user_id);
		
			$menuFormatting = '';
			if ($language == "sinhala") {
				$menuFormatting = 'style="font-weight: bold;"';
			}

			$deriveUserRolePermissions = $this->user_model->getDeriveUserRolePermissions($deriveRoleId);
			if($deriveUserRolePermissions) {
				$html = "";
				$html .= "<div class='box-content box-no-padding out-table'>
				   <div class='table-responsive table_data'>
					 <div class='scrollable-area1'>
						<table class='table table-striped table-bordered'style='margin-bottom:0;' id='rolePermissionTable'>
						   <thead>
							  <tr>
								  <td  width='12%'><strong>{$this->lang->line('System Module')}<strong></td>
								  <td  width='12%'><strong>{$this->lang->line('Sub Module')}<strong></td>
								  <td  width='16%'><strong>{$this->lang->line('Module Section')}<strong></td>
								  <td width='60%'>

										<table class='table table-striped table-bordered1' style='margin-bottom:0;'>
										<tr>
											<td width='25%'>
												<strong>{$this->lang->line('Module Section Features')}</strong>
											</td>
											<td width='10%' align='center'><strong>{$this->lang->line('Add Permission')}</strong></td>
											<td width='10%' align='center'><strong>{$this->lang->line('Edit Permission')}</strong></td>
											<td width='10%' align='center' ><strong>{$this->lang->line('Delete Permission')}</strong></td>
											<td width='10%' align='center'><strong>{$this->lang->line('View Permission')}</strong></td>
											<td width='10%' align='center'><strong>{$this->lang->line('Advanced')}</strong></td>
										</tr>
										</table>
								  </td>
							  </tr>
						   </thead>
				   <tbody>";
				$moduleSections = $this->user_model->getAllModuleSections('module_section_name', 'asc');

				$moduleArray = array();

                $moduleList = $this->user_model->getAllSystemModules('system_module_id','asc');

                foreach ($moduleList as $module) {
                    $moduleArray[] = $module->system_module;
                }

				if ($moduleSections && sizeof($moduleSections) > 0) {
					foreach ($moduleSections as $rowModuleSection) {
						if (in_array($rowModuleSection->system_module, $moduleArray)) {
							
							$systemSubModuleName = '';
							if ($rowModuleSection->system_sub_module_id != '0' && $rowModuleSection->system_sub_module_id != '') {
								$systemSubModule = $this->common_model->getSystemSubModule($rowModuleSection->system_sub_module_id);
								$systemSubModuleName = $systemSubModule[0]->system_sub_module;
							}
						
                            $html .= "<tr>";
                            $html .= "<td width='12%'><strong>" . $rowModuleSection->system_module . "</strong></td>";
                            $html .= "<td  width='12%'><strong>" . $systemSubModuleName . "</strong></td>";
                            $html .= "<td width='16%'><strong>" . $rowModuleSection->module_section_name . "</strong></td>";
                            $moduleSectionFeatures = $this->user_model->getModuleSectionFeaturesByModuleSectionId($rowModuleSection->module_section_id);
                            $html .= "<td width='60%'>";
                            if ($moduleSectionFeatures && sizeof($moduleSectionFeatures) > 0) {
                                foreach($moduleSectionFeatures as $rowModuleSectionFeature){
                                    if ($rowModuleSectionFeature->showing_status == "Yes") {
                                        $html .= "<table class='table table-striped table-bordered'style='margin-bottom:0;'><tr><td width='25%'>";
                                        $html .= $rowModuleSectionFeature->module_section_feature_name . "</td>";
                                        $permissions = $this->user_model->getPermissionsByModuleSectionFeatureId($rowModuleSectionFeature->module_section_feature_id);
                                        if ($permissions != null) {

                                            $addPermissionFound = false;
                                            $editPermissionFound = false;
                                            $deletePermissionFound = false;
                                            $viewPermissionFound = false;

                                            $advancedPermissionsAvailable = false;
                                            $permissionIdWhichHasAdvancedPermissions = array();

                                            foreach ($permissions as $rowPermissions) {
                                                $deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveRoleId, $rowPermissions->permission_id);
                                                if($deriveUserRolePermission != null && $rowPermissions->permission_type == "Add") {
                                                    $addPermissionFound = true;

                                                    $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowPermissions->permission_id);
                                                    if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                        $advancedPermissionsAvailable = true;

                                                        if (!in_array($rowPermissions->permission_id, $permissionIdWhichHasAdvancedPermissions)) {
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowPermissions->permission_id;
                                                        }
                                                    }

                                                    $html .="<td width='10%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id' checked='checked' ></td>";
                                                    break;
                                                } else if ($rowPermissions->permission_type == "Add") {
                                                    $addPermissionFound = true;
                                                    $html .="<td width='10%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id'></td>";
                                                    break;
                                                }
                                            }

                                            if (!$addPermissionFound) {
                                                $html .="<td width='10%'></td>";
                                            }

                                            foreach ($permissions as $rowPermissions) {
                                                $deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveRoleId, $rowPermissions->permission_id);
                                                if($deriveUserRolePermission != null && $rowPermissions->permission_type == "Edit") {
                                                    $editPermissionFound = true;

                                                    $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowPermissions->permission_id);
                                                    if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                        $advancedPermissionsAvailable = true;

                                                        if (!in_array($rowPermissions->permission_id, $permissionIdWhichHasAdvancedPermissions)) {
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowPermissions->permission_id;
                                                        }
                                                    }

                                                    $html .="<td width='10%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id' checked='checked' ></td>";
                                                    break;
                                                } else if ($rowPermissions->permission_type == "Edit") {
                                                    $editPermissionFound = true;
                                                    $html .="<td width='10%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id'></td>";
                                                    break;
                                                }
                                            }

                                            if (!$editPermissionFound) {
                                                $html .="<td width='10%'></td>";
                                            }

                                            foreach ($permissions as $rowPermissions) {
                                                $deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveRoleId, $rowPermissions->permission_id);
                                                if($deriveUserRolePermission != null && $rowPermissions->permission_type == "Delete") {
                                                    $deletePermissionFound = true;

                                                    $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowPermissions->permission_id);
                                                    if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                        $advancedPermissionsAvailable = true;

                                                        if (!in_array($rowPermissions->permission_id, $permissionIdWhichHasAdvancedPermissions)) {
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowPermissions->permission_id;
                                                        }
                                                    }

                                                    $html .="<td width='10%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id' checked='checked' ></td>";
                                                    break;
                                                } else if ($rowPermissions->permission_type == "Delete") {
                                                    $deletePermissionFound = true;
                                                    $html .="<td width='10%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id'></td>";
                                                    break;
                                                }
                                            }

                                            if (!$deletePermissionFound) {
                                                $html .="<td width='10%'></td>";
                                            }

                                            foreach ($permissions as $rowPermissions) {
                                                $deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveRoleId, $rowPermissions->permission_id);
                                                if($deriveUserRolePermission != null && $rowPermissions->permission_type == "View") {
                                                    $viewPermissionFound = true;

                                                    $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowPermissions->permission_id);
                                                    if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                        $advancedPermissionsAvailable = true;

                                                        if (!in_array($rowPermissions->permission_id, $permissionIdWhichHasAdvancedPermissions)) {
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowPermissions->permission_id;
                                                        }
                                                    }

                                                    $html .="<td width='10%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id' checked='checked' ></td>";
                                                    break;
                                                } else if ($rowPermissions->permission_type == "View") {
                                                    $viewPermissionFound = true;
                                                    $html .="<td width='10%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermissions->permission_id' value='$rowPermissions->permission_id'></td>";
                                                    break;
                                                }
                                            }

                                            if (!$viewPermissionFound) {
                                                $html .="<td width='10%'></td>";
                                            }

                                            $permissionIdsWhichHasAdvancedPermissions = implode("-", $permissionIdWhichHasAdvancedPermissions);

                                            if ($advancedPermissionsAvailable) {
                                                $html .="<td width='10%'>
                                                            <div class='text-center'>";
                                                $html.="        <a class='btn btn-warning btn-xs get' data-id='get_advanced_permissions' 
                                                                    title='{$this->lang->line('Advanced Permissions')}' 
                                                                    onclick='openAdvancedPermissions(/{$permissionIdsWhichHasAdvancedPermissions}/, {$deriveRoleId});'>
                                                                    <i class='icon-wrench'></i>
                                                                </a> ";
                                                $html.="    </div>
                                                        </td>";
                                            } else {
                                                $html .="<td width='10%'></td>";
                                            }
                                        }

                                        $html .="</tr></table>";
                                    }
                                }
                            }
                            $html .= "</td>";
                            $html .= "</tr>";
						}
					}
				}
				$html .= "</tbody>
						</table>
						</div>
						</div>
						</div>";

				$url='';
				$url=base_url();
				$html.="
				<div class='loader' align='center'><img src='{$url}assets/images/ajax-loader.gif'> Saving data...</div>
				<form class='form-horizontal'>
					<div class='form-actions' style='margin-bottom:0'>
						<div class='row'>
							<div class='col-sm-12 col-sm-offset-5'>
								<button class='btn btn-success save' onclick='saveData($deriveRoleId);' type='button'" . $menuFormatting . ">
									<i class='icon-save'></i>
									{$this->lang->line('Save')}
								</button>
								<button class='btn btn-warning cancel' onclick='cancelData();' type='button'" . $menuFormatting . ">
									<i class='icon-ban-circle'></i>
									{$this->lang->line('Close')}
								</button>
							</div>
						</div>
					</div>
				</form>";
				echo $html;
			} else {
				$html = "";
				$html .= "<div class='box-content box-no-padding out-table'>
				   <div class='table-responsive table_data'>
					 <div class='scrollable-area1'>
						<table class='table table-striped table-bordered'style='margin-bottom:0;' id='rolePermissionTable'>
						   <thead>
							  <tr>
								  <td  width='12%'><strong>{$this->lang->line('System Module')}<strong></td>
								  <td  width='12%'><strong>{$this->lang->line('Sub Module')}<strong></td>
								  <td  width='16%'><strong>{$this->lang->line('Module Section')}<strong></td>
								  <td width='60%'>

										<table class='table table-striped table-bordered1' style='margin-bottom:0;'>
										<tr>
											<td width='40%'>
												<strong>{$this->lang->line('Module Section Features')}</strong>
											</td>
											<td width='15%' align='center'><strong>{$this->lang->line('Add Permission')}</strong></td>
											<td width='15%' align='center'><strong>{$this->lang->line('Edit Permission')}</strong></td>
											<td width='15%' align='center' ><strong>{$this->lang->line('Delete Permission')}</strong></td>
											<td width='15%' align='center'><strong>{$this->lang->line('View Permission')}</strong></td>
										</tr>
										</table>
								  </td>
							  </tr>
						   </thead>
				   <tbody>";
                                            
				$moduleSections = $this->user_model->getAllModuleSections('module_section_name', 'asc');

				$moduleArray = array();
				
                $moduleList = $this->user_model->getAllSystemModules('system_module_id','asc');

                foreach ($moduleList as $module) {
                    $moduleArray[] = $module->system_module;
                }

				if ($moduleSections != null) {
					foreach ($moduleSections as $rowModuleSection) {
						if (in_array($rowModuleSection->system_module, $moduleArray)) {
							
							$systemSubModuleName = '';
							if ($rowModuleSection->system_sub_module_id != '0' && $rowModuleSection->system_sub_module_id != '') {
								$systemSubModule = $this->common_model->getSystemSubModule($rowModuleSection->system_sub_module_id);
								$systemSubModuleName = $systemSubModule[0]->system_sub_module;
							}
							
                            $html .= "<tr>";
                            $html .= "<td width='12%'><strong>" . $rowModuleSection->system_module . "</strong></td>";
                            $html .= "<td  width='12%'><strong>" . $systemSubModuleName . "</strong></td>";
                            $html .= "<td width='16%'><strong>" . $rowModuleSection->module_section_name . "</strong></td>";
                            $moduleSectionFeatures = $this->user_model->getModuleSectionFeaturesByModuleSectionId($rowModuleSection->module_section_id);
                            $html .= "<td width='60%'>";
                            if ($moduleSectionFeatures != null) {
                                foreach($moduleSectionFeatures as $rowModuleSectionFeature) {
                                    if ($rowModuleSectionFeature->showing_status == "Yes") {
                                        $html .= "<table class='table table-striped table-bordered'style='margin-bottom:0;'><tr><td width='40%'>";
                                        $html .= $rowModuleSectionFeature->module_section_feature_name . "</td>";
                                        $permissions = $this->user_model->getPermissionsByModuleSectionFeatureId($rowModuleSectionFeature->module_section_feature_id);
                                        if ($permissions != null) {

                                            $addPermissionFound = false;
                                            $editPermissionFound = false;
                                            $deletePermissionFound = false;
                                            $viewPermissionFound = false;

                                            foreach ($permissions as $rowPermission) {
                                                $userRolePermission = $this->user_model->getUserPermission($roleId, $rowPermission->permission_id);
                                                if($userRolePermission != null){

                                                    foreach($userRolePermission as $rowUserRolePermission) {
                                                        if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "Add") {
                                                            $addPermissionFound = true;
                                                            $html .= "<td width='15%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' checked='checked' ></td>";
                                                            break;
                                                        }
                                                    }
                                                } else {
                                                    if ($rowPermission->permission_type == "Add") {
                                                        $addPermissionFound = true;
                                                        $html .= "<td width='15%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'></td>";
                                                        break;
                                                    }
                                                }
                                            }

                                            if (!$addPermissionFound) {
                                                $html .="<td width='15%'></td>";
                                            }

                                            foreach ($permissions as $rowPermission) {
                                                $userRolePermission = $this->user_model->getUserPermission($roleId, $rowPermission->permission_id);
                                                if($userRolePermission != null){

                                                    foreach($userRolePermission as $rowUserRolePermission) {
                                                        if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "Edit") {
                                                            $editPermissionFound = true;
                                                            $html .= "<td width='15%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' checked='checked' ></td>";
                                                            break;
                                                        }
                                                    }
                                                } else {
                                                    if ($rowPermission->permission_type == "Edit") {
                                                        $editPermissionFound = true;
                                                        $html .= "<td width='15%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'></td>";
                                                        break;
                                                    }
                                                }
                                            }

                                            if (!$editPermissionFound) {
                                                $html .="<td width='15%'></td>";
                                            }

                                            foreach ($permissions as $rowPermission) {
                                                $userRolePermission = $this->user_model->getUserPermission($roleId, $rowPermission->permission_id);
                                                if($userRolePermission != null){

                                                    foreach($userRolePermission as $rowUserRolePermission) {
                                                        if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "Delete") {
                                                            $deletePermissionFound = true;
                                                            $html .= "<td width='15%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' checked='checked' ></td>";
                                                            break;
                                                        }
                                                    }
                                                } else {
                                                    if ($rowPermission->permission_type == "Delete") {
                                                        $deletePermissionFound = true;
                                                        $html .= "<td width='15%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'></td>";
                                                        break;
                                                    }
                                                }
                                            }

                                            if (!$deletePermissionFound) {
                                                $html .="<td width='15%'></td>";
                                            }

                                            foreach ($permissions as $rowPermission) {
                                                $userRolePermission = $this->user_model->getUserPermission($roleId, $rowPermission->permission_id);
                                                if($userRolePermission != null){

                                                    foreach($userRolePermission as $rowUserRolePermission) {
                                                        if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "View") {
                                                            $viewPermissionFound = true;
                                                            $html .= "<td width='15%' align='center'> <input type='checkbox' name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' checked='checked' ></td>";
                                                            break;
                                                        }
                                                    }
                                                } else {
                                                    if ($rowPermission->permission_type == "View") {
                                                        $viewPermissionFound = true;
                                                        $html .= "<td width='15%' align='center'><input type='checkbox'  name='derive_permission' id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'></td>";
                                                        break;
                                                    }
                                                }
                                            }

                                            if (!$viewPermissionFound) {
                                                $html .="<td width='15%'></td>";
                                            }
                                        }
                                        $html .="</tr></table>";
                                    }
                                }
                            }
                            $html .= "</td>";
                            $html .= "</tr>";
						}
					}
				}
				$html .= "</tbody>
						</table>
						</div>
						</div>
						</div>";

				$url='';
				$url=base_url();
				$html.="
				<div class='loader' align='center'><img src='{$url}assets/images/ajax-loader.gif'> Saving data...</div>
				<form class='form-horizontal'>
				<div class='form-actions' style='margin-bottom:0'>
						<div class='row'>
							<div class='col-sm-12 col-sm-offset-5'>";
						if(isset($this->data['URM_User_Roles_Edit_Derive_User_Roles_Permissions_Permissions'])) {
							$html .= "<button class='btn btn-success save' onclick='saveData($deriveRoleId);' type='button'" . $menuFormatting . ">
										  <i class='icon-save'></i>
										  {$this->lang->line('Save')}
									  </button> ";
						}
						$html.="<button class='btn btn-warning cancel' onclick='cancelData();' type='button'" . $menuFormatting . ">
									<i class='icon-ban-circle'></i>
									{$this->lang->line('Close')}
								</button>
							</div>
						</div>
					</div>
				</form>";
				echo $html;
			}
		}
	}

	public function edit() {
		if(isset($this->data['URM_User_Roles_Edit_Derive_User_Roles_Permissions_Permissions'])) {
			$deriveUserRoleId = $this->db->escape_str($this->input->post('derive_user_role_id'));
			$permissionId = $this->db->escape_str($this->input->post('permission_id'));

			$this->user_model->deleteDeriveUserRolePermission($deriveUserRoleId);

			foreach ($permissionId as $row) {
				$data = array(
					'derive_user_role_id' => $deriveUserRoleId,
					'permission_id' => $row,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$this->user_model->addDeriveUserRolePermission($data);
			}

			$systemModules = $this->user_model->getAllSystemModules('system_module_id','asc');
			
			foreach ($systemModules as $systemModule) {
				$systemModuleId = $systemModule->system_module_id;
				$systemModuleName = $systemModule->system_module;
				$moduleSections = $this->user_model->getAllModuleSectionsBySystemModuleName($systemModuleName, 'module_section_name', 'asc');
				if ($moduleSections != null) {
					foreach ($moduleSections as $rowModuleSection) {
						$moduleSectionId = $rowModuleSection->module_section_id;
						$deriveUserRolePermissions = $this->user_model->getDeriveUserRolePermissionsByModuleSectionId($deriveUserRoleId, $moduleSectionId);

						if ($deriveUserRolePermissions) {
							switch ($systemModuleName) {
								case "Organization" :
									$deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveUserRoleId, '40');
									if ($deriveUserRolePermission == false) {
										$data = array(
											'derive_user_role_id' => $deriveUserRoleId,
											'permission_id' => '40',
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);

										$this->user_model->addDeriveUserRolePermission($data);
									}
									
									break;
								case "Service Manager" :
									$deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveUserRoleId, '187');
									if ($deriveUserRolePermission == false) {
										$data = array(
											'derive_user_role_id' => $deriveUserRoleId,
											'permission_id' => '187',
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);

										$this->user_model->addDeriveUserRolePermission($data);
									}
									
									$systemSubModules = $this->user_model->getAllSystemSubModules('system_sub_module_id', 'asc', $systemModuleId);
									
									foreach ($systemSubModules as $systemSubModule) {
										$systemSubModuleName = $systemSubModule->system_sub_module;
										$subModuleSections = $this->user_model->getAllSubModuleSectionsBySystemModuleName($systemModuleName, $systemSubModuleName, 'module_section_name', 'asc');
										if ($subModuleSections != null) {
											foreach ($subModuleSections as $rowSubModuleSection) {
												$moduleSectionId = $rowSubModuleSection->module_section_id;
												$deriveUserRolePermissions = $this->user_model->getDeriveUserRolePermissionsByModuleSectionId($deriveUserRoleId, $moduleSectionId);

												if ($deriveUserRolePermissions) {
													switch ($systemSubModuleName) {
									
														case "Donation Manager" :
															$deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveUserRoleId, '297');
															if ($deriveUserRolePermission == false) {
																$data = array(
																	'derive_user_role_id' => $deriveUserRoleId,
																	'permission_id' => '297',
																	'actioned_user_id' => $this->user_id,
																	'action_date' => $this->date,
																	'last_action_status' => 'added'
																);

																$this->user_model->addDeriveUserRolePermission($data);
															}
															
															break;
															
														
													}
												}
											}
										}
									}
									
									break;
								case "Accounts Manager" :
									$deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveUserRoleId, '196');
									if ($deriveUserRolePermission == false) {
										$data = array(
											'derive_user_role_id' => $deriveUserRoleId,
											'permission_id' => '196',
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);

										$this->user_model->addDeriveUserRolePermission($data);
									}
									
									break;
								case "User Role Manager" :
									$deriveUserRolePermission = $this->user_model->getDeriveUserRolePermissions($deriveUserRoleId, '16');
									if ($deriveUserRolePermission == false) {
										$data = array(
											'derive_user_role_id' => $deriveUserRoleId,
											'permission_id' => '16',
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);

										$this->user_model->addDeriveUserRolePermission($data);
									}
									
									break;
							}
						}
					}
				}
			}

			echo'ok';
		} else {
			$html = '<div class="alert alert-warning alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('warning') . '</h4>' .
				$this->lang->line('Sorry, You have no permission') .
				'</div>';
			echo $html;
		}
	}
}