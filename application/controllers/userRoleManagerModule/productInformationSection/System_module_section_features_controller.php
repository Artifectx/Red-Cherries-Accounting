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

class System_module_section_features_controller extends CI_Controller {

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
		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';
		$data_cls['li_class_system_module_section_features'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		$data['modules'] = $this->user_model->getAllModuleSectionFeatures('module_section_feature_name', 'asc');

		if(isset($this->data['URM_Product_Info_View_Module_Section_Feature_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/productInformationSection/systemModuleSectionFeatures/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	//all derive user roles
	public function getTableData() {

		if(isset($this->data['URM_Product_Info_View_Module_Section_Feature_Permissions'])){
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
				   <div class='table-responsive table_data'>
					 <div class='scrollable-area1'>
						<table class='table table-striped table-bordered'style='margin-bottom:0;' id='moduleTable'>
						   <thead>
							  <tr>
								  <td width='30%'><strong>{$this->lang->line('System Module')}</strong></td>
								  <td width='70%'>
										<table class='table1 table-striped table-bordered1' style='margin-bottom:0;' width='100%'>
											<tr>
												<td width='35%'>
													<strong>{$this->lang->line('Module Section')}</strong>
												</td>
												<td width='35%' align='left'>
													<strong>{$this->lang->line('Module Section Features')}</strong>
												</td>
											</tr>
										</table>
								  </td>
							  </tr>
						   </thead>
				   <tbody>";
						$systemModules=$this->user_model->getAllSystemModules('system_module','asc');

						$moduleArray = array();
						$rawMaterialSectionPurchased = false;
						$salesSectionPurchased = false;

                        $moduleList = $this->user_model->getAllSystemModules('system_module_id','asc');

                        foreach ($moduleList as $module) {
                            $moduleArray[] = $module->system_module;
                        }

						if ($systemModules != null) {
							foreach ($systemModules as $rowSystemModule) {
								if (in_array($rowSystemModule->system_module, $moduleArray)) {
									$html .= "<tr>";
									$html .= "<td width='30%'><strong>" . $rowSystemModule->system_module . "</strong></td>";
									//get system_module_sections by system_module_id
									$moduleSections = $this->user_model->getModuleSectionBySystemModuleId($rowSystemModule->system_module_id);
									$html .= "<td>";
									if ($moduleSections != null) {
										foreach ($moduleSections as $rowModuleSection) {
                                            $html .= "<table class='table table-striped table-bordered'style='margin-bottom:0;'>";
                                            $html .= "<tr>
                                                      <td width='35%'>";
                                            $html .= "    <strong>".$rowModuleSection->module_section_name . "</strong>";
                                            $html .= "</td>";

                                            //get module feature by module_section_id
                                            $moduleFeatures = $this->user_model->getModuleSectionFeaturesByModuleSectionId($rowModuleSection->module_section_id);
                                            $html .= "<td width='35%'>";
                                            if($moduleFeatures != null){
                                                foreach($moduleFeatures as $rowModuleSectionFeature){
                                                    if ($rowModuleSectionFeature->showing_status == "Yes") {
                                                        $html .= "<table class='table table-striped table-bordered'style='margin-bottom:0;'><tr><td>";
                                                        $html .= $rowModuleSectionFeature->module_section_feature_name . "</td>";
                                                        $html .="</tr></table>";
                                                    }
                                                }
                                            }
                                            $html .= "</td>";
                                            $html .= "</tr>
                                                      </table>";
										}
										$html .="</td>";
									}
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