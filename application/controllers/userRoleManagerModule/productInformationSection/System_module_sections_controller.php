<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_module_sections_controller extends CI_Controller {

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
		$data_cls['li_class_system_module_sections'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		if(isset($this->data['URM_Product_Info_View_Module_Section_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/productInformationSection/systemModuleSections/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	//all derive user roles
	public function getTableData() {

		if(isset($this->data['URM_Product_Info_View_Module_Section_Permissions'])) {

			$lbl='';
			$btn='';
			$btnText='';
			$statusText='';
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
				   <div class='table-responsive table_data'>
					 <div class='scrollable-area1'>
						<table class='table table-striped table-bordered'style='margin-bottom:0;' id='example'>
						   <thead>
							  <tr>
								  <th>{$this->lang->line('System Module')}</th>
								  <th>{$this->lang->line('Module Section')}</th>
								  <th>{$this->lang->line('Status')}</th>
							  </tr>
						   </thead>
				   <tbody>";

			$moduleSections = $this->user_model->getAllModuleSections('module_section_name', 'asc');

            $moduleList = $this->user_model->getAllSystemModules('system_module_id','asc');

            foreach ($moduleList as $module) {
                $moduleArray[] = $module->system_module;
            }
                
			if ($moduleSections != null) {

				foreach ($moduleSections as $row) {
					if (in_array($row->system_module, $moduleArray)) {
						$html .= "<tr>";
						$html .= "<td>" . $row->system_module . "</td>";
						$html .= "<td>" . $row->module_section_name . "</td>";
                        $lbl='success';
                        $html .= "<td><span class='label label-$lbl'>{$this->lang->line('Enabled')}</span></td>";

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

	public function changeStatus() {

		if(isset($this->data['UR_Edit_Module_Section_Permissions'])) {

			$main_module_section_status='';
			$status = 'edited';
			$admin_main_module_section_id = $this->db->escape_str($this->input->post('admin_main_module_section_id'));
			$main_module_section_status = $this->db->escape_str($this->input->post('main_module_section_status'));

			if($main_module_section_status=='0') {
				$main_module_section_status=1;
			}

			else $main_module_section_status=0;
			if ($this->user_model->changeStatus($admin_main_module_section_id,$main_module_section_status,$status)) {

				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_updated') .
					'</div>';

				echo($html);
			}
		}
	}
}