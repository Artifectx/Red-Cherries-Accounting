<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_user_roles_permissions_controller extends CI_Controller {

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
		$data_cls['li_class_default_user_role_permissions'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		$data['user_roles'] = $this->user_model->getAllUserRoles('role_id', 'asc');

		if(isset($this->data['URM_User_Roles_View_Default_User_Roles_Permissions_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/userRolesSection/defaultUserRolePermissions/index', $data);
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
                
                if ($childPermissions && sizeof($childPermissions) > 0) {
                    $childPermissionsArray = array_merge($childPermissionsArray, $childPermissions);
                }
            }
        }

		$html = '';

		$count = 0;
		foreach ($childPermissionsArray as $childPermission) {
			$childPermissionId = $childPermission->child_permission_id;

			$permission = $this->user_model->getPermissionByPermissionId($childPermissionId);
			$permissionName = $permission[0]->permission_description;

			$userRolePermission = $this->user_model->getUserPermission($userRoleId, $childPermissionId);

			$html .= "  <div class='col-sm-5 controls'>
							<input type='checkbox' name='permission_id_" . $childPermissionId . "' id='permission_id_'" . $childPermissionId . "' style='vertical-align: text-bottom;'
								   onchange='handlePermissionChange(this.id, {$userRoleId});' disabled ";
								if ($userRolePermission) {
			$html .=               "checked";                        
								}   

			$html .=        ">
							<label for='permission_id_" . $childPermissionId . "' >{$permissionName}</label>
						</div>";

			$count++;
		}

		$html .= "<p style='margin-bottom:" . ($count/2)*20 . "px'>&nbsp;</p>";

		echo $html;
	}

	public function getTableData() {
		if(isset($this->data['URM_User_Roles_View_Default_User_Roles_Permissions_Permissions'])) {
			$role_id = '';
			$role_id = $this->db->escape_str($this->input->post('id'));
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

                                        foreach ($permissions as $rowPermission) {
                                            $userRolePermission = $this->user_model->getUserPermission($role_id, $rowPermission->permission_id);
                                            if($userRolePermission != null){

                                                foreach($userRolePermission as $rowUserRolePermission) {
                                                    if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "Add") {
                                                        $addPermissionFound = true;
                                                        $html .= "<td width='10%' align='center'> <input type='checkbox' name='derive_permission' "
                                                                . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' "
                                                                . "checked='checked' disabled ></td>";

                                                        $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowUserRolePermission->permission_id);
                                                        if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                            $advancedPermissionsAvailable = true;
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowUserRolePermission->permission_id;
                                                        }

                                                        break;
                                                    }
                                                }
                                            } else {
                                                if ($rowPermission->permission_type == "Add") {
                                                    $addPermissionFound = true;
                                                    $html .= "<td width='10%' align='center'><input type='checkbox'  name='derive_permission' "
                                                            . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'"
                                                            . "disabled ></td>";
                                                    break;
                                                }
                                            }
                                        }

                                        if (!$addPermissionFound) {
                                            $html .="<td width='10%'></td>";
                                        }

                                        foreach ($permissions as $rowPermission) {
                                            $userRolePermission = $this->user_model->getUserPermission($role_id, $rowPermission->permission_id);
                                            if($userRolePermission != null){

                                                foreach($userRolePermission as $rowUserRolePermission) {
                                                    if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "Edit") {
                                                        $editPermissionFound = true;
                                                        $html .= "<td width='10%' align='center'> <input type='checkbox' name='derive_permission' "
                                                                . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' "
                                                                . "checked='checked' disabled ></td>";

                                                        $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowUserRolePermission->permission_id);
                                                        if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                            $advancedPermissionsAvailable = true;
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowUserRolePermission->permission_id;
                                                        }

                                                        break;
                                                    }
                                                }
                                            } else {
                                                if ($rowPermission->permission_type == "Edit") {
                                                    $editPermissionFound = true;
                                                    $html .= "<td width='10%' align='center'><input type='checkbox'  name='derive_permission' "
                                                            . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'"
                                                            . "disabled ></td>";
                                                    break;
                                                }
                                            }
                                        }

                                        if (!$editPermissionFound) {
                                            $html .="<td width='10%'></td>";
                                        }

                                        foreach ($permissions as $rowPermission) {
                                            $userRolePermission = $this->user_model->getUserPermission($role_id, $rowPermission->permission_id);
                                            if($userRolePermission != null){

                                                foreach($userRolePermission as $rowUserRolePermission) {
                                                    if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "Delete") {
                                                        $deletePermissionFound = true;
                                                        $html .= "<td width='10%' align='center'> <input type='checkbox' name='derive_permission' "
                                                                . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' "
                                                                . "checked='checked' disabled ></td>";

                                                        $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowUserRolePermission->permission_id);
                                                        if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                            $advancedPermissionsAvailable = true;
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowUserRolePermission->permission_id;
                                                        }

                                                        break;
                                                    }
                                                }
                                            } else {
                                                if ($rowPermission->permission_type == "Delete") {
                                                    $deletePermissionFound = true;
                                                    $html .= "<td width='10%' align='center'><input type='checkbox'  name='derive_permission' "
                                                            . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'"
                                                            . "disabled ></td>";
                                                    break;
                                                }
                                            }
                                        }

                                        if (!$deletePermissionFound) {
                                            $html .="<td width='10%'></td>";
                                        }

                                        foreach ($permissions as $rowPermission) {
                                            $userRolePermission = $this->user_model->getUserPermission($role_id, $rowPermission->permission_id);
                                            if($userRolePermission != null){

                                                foreach($userRolePermission as $rowUserRolePermission) {
                                                    if ($rowPermission->permission == $rowUserRolePermission->permission && $rowPermission->permission_type == "View") {
                                                        $viewPermissionFound = true;
                                                        $html .= "<td width='10%' align='center'> <input type='checkbox' name='derive_permission' "
                                                                . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id' "
                                                                . "checked='checked' disabled ></td>";

                                                        $advancedPermissions = $this->user_model->getAdvancedPermissionsForAPermission($rowUserRolePermission->permission_id);
                                                        if ($advancedPermissions && sizeof($advancedPermissions) > 0) {
                                                            $advancedPermissionsAvailable = true;
                                                            $permissionIdWhichHasAdvancedPermissions[] = $rowUserRolePermission->permission_id;
                                                        }

                                                        break;
                                                    }
                                                }
                                            } else {
                                                if ($rowPermission->permission_type == "View") {
                                                    $viewPermissionFound = true;
                                                    $html .= "<td width='10%' align='center'><input type='checkbox'  name='derive_permission' "
                                                            . "id='permission_$rowPermission->permission_id' value='$rowPermission->permission_id'"
                                                            . "disabled ></td>";
                                                    break;
                                                }
                                            }
                                        }

                                        if (!$viewPermissionFound) {
                                            $html .="<td width='10%'></td>";
                                        }

                                        $permissionIdsWhichHasAdvancedPermissions = implode("-", $permissionIdWhichHasAdvancedPermissions);

                                        if ($advancedPermissionsAvailable) {
                                            $html .="<td width='10%'>
                                                        <div class='text-center'>";
                                            $html.="        <a class='btn btn-warning btn-xs get' data-id='get_advanced_permissions' title='{$this->lang->line('Advanced Permissions')}'
                                                                onclick='openAdvancedPermissions(/{$permissionIdsWhichHasAdvancedPermissions}/, {$role_id});'>
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
			echo $html;
		}
	}
}