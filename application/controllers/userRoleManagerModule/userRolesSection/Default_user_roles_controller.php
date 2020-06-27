<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_user_roles_controller extends CI_Controller {

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
		$data_cls['li_class_default_user_roles'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		if (isset($this->data['URM_User_Roles_View_Default_User_Roles_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/userRolesSection/defaultUserRoles/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	//get all user roles data
	public function getTableData() {
		if (isset($this->data['URM_User_Roles_View_Default_User_Roles_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
				   <div class='table-responsive table_data'>
					 <div class='scrollable-area1'>
						<table class='table table-striped table-bordered'style='margin-bottom:0;'>
						   <thead>
							  <tr>
								  <th>{$this->lang->line('Role')}</th>
								  <th>{$this->lang->line('Description')}</th>
							  </tr>
						   </thead>
				   <tbody>";
			$user_roles = $this->user_model->getAllUserRoles('role_id', 'asc');
			if ($user_roles != null) {
				foreach ($user_roles as $row) {
					$html .= "<tr>";
					$html .= "<td>" . $row->user_role_name . "</td>";
					$html .= "<td>" . $row->description . "</td>";
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
}