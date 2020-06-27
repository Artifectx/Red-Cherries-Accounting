<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions_controller extends CI_Controller {

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
		$data_cls['li_class_permissions'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		if(isset($this->data['URM_User_Roles_View_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/userRolesSection/permissions/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	//get all user roles data
	public function getTableData() {
		if(isset($this->data['URM_User_Roles_View_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
				   <div class='table-responsive table_data'>
					 <div class='scrollable-area1'>
						<table class='table table-striped table-bordered'style='margin-bottom:0;' id='permissionTable'>
						   <thead>
							  <tr>
								  <td  width='20%'><strong>{$this->lang->line('System Module')}<strong></td>
								  <td  width='20%'><strong>{$this->lang->line('Sub Module')}<strong></td>
								  <td  width='20%'><strong>{$this->lang->line('Module Section')}<strong></td>
								  <td width='60%'>
										<table class='table1 table-striped table-bordered1' style='margin-bottom:0;'>
										<tr>
											<td width='60%'>
												<strong>{$this->lang->line('Module Section Features')}</strong>
											</td>
											<td width='20%' align='center'><strong>{$this->lang->line('Permissions')}</strong></td>
										</tr>
										</table>
								  </td>
							  </tr>
						   </thead>
				   <tbody>";
			$moduleSections = $this->user_model->getAllModuleSections('module_section_name', 'asc');

            $allModules = $this->user_model->getAllSystemModules('system_module_id', 'asc');

            foreach($allModules as $module) {
                $moduleArray[$module->system_module_id] = $module->system_module;
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
                        $html .= "<td  width='20%'><strong>" . $rowModuleSection->system_module . "</strong></td>";
                        $html .= "<td  width='20%'><strong>" . $systemSubModuleName . "</strong></td>";
                        $html .= "<td  width='20%'><strong>" . $rowModuleSection->module_section_name . "</strong></td>";
                        $moduleSectionFeatures = $this->user_model->getModuleSectionFeaturesByModuleSectionId($rowModuleSection->module_section_id);
                        $html .= "<td width='60%'>";
                        if($moduleSectionFeatures != null){
                            foreach($moduleSectionFeatures as $rowModuleSectionFeature) {
                                if ($rowModuleSectionFeature->showing_status == "Yes") {
                                    $html .= "<table class='table table-striped table-bordered'style='margin-bottom:0;'>
                                                    <tr>
                                                    <td width='40%'>";
                                    $html .="<strong>". $rowModuleSectionFeature->module_section_feature_name . "</strong></td>";
                                    $html .="<td>
                                                    <table class='table table-striped table-bordered'style='margin-bottom:0;'>";
                                    $permissions = $this->user_model->getPermissionsByModuleSectionFeatureId($rowModuleSectionFeature->module_section_feature_id);
                                    if($permissions != null){
                                        foreach ($permissions as $rowPermissions) {
                                            $html.="<tr><td width='30%'>".$rowPermissions->permission_description."</td><tr>";
                                        }
                                    }

                                    $html .="</table>
                                                 </td>";
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