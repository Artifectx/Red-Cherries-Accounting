<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_information_controller extends CI_Controller {

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
		$this->load->model('organizationManagerModule/organizationSection/company_information_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);

		//set selected menu
		$data_cls['ul_class_organization_section']='in nav nav-stacked';
		$data_cls['li_class_company_information']='active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager',$data_cls);
	}

	public function index() {
		if(isset($this->data['OGM_Organization_View_Company_Information_Permissions'])) {
			$result = $this->company_information_model->getAll();
			if ($result) {
				foreach ($result as $row) {
					$data['company_info'] = array(
						'company_name' => $row->company_name,
						'company_short_name' => $row->company_short_name,
						'email' => $row->email,
						'web' => $row->web,
						'primary_telephone_number' => $row->ptn_country_code . ' ' . $row->primary_telephone_number,
						'secendory_telephone_number' => $row->stn_country_code . ' ' . $row->secendory_telephone_number,
						'fax' => $row->fax_country_code . ' ' . $row->fax_number,
						'address' => $row->address,
						'short_address' => $row->short_address
					);
				}
				$this->load->view('web/organizationManagerModule/organizationSection/companyInformation/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer');
			} else {
				$data['company_info'] = array(
					'company_name' => '',
					'company_short_name' => '',
					'email' => '',
					'web' => '',
					'primary_telephone_number' => '',
					'secendory_telephone_number' => '',
					'fax' => '',
					'address' => '',
					'short_address' => ''
				);
				$this->load->view('web/organizationManagerModule/organizationSection/companyInformation/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer', $data);
			}
		}
	}

	public function editCompany() {
		if(isset($this->data['OGM_Organization_Edit_Company_Information_Permissions'])){
			$id = 1;

			$primaryTPNumberCombined =  $this->input->post('primary_telephone_number');
			$tpArray = explode(' ', $primaryTPNumberCombined);
			$primaryTPNumberCountryCode = $tpArray[0];
			$primaryTPNumber = '';
			if (sizeof($tpArray) > 1) {
				$primaryTPNumber = $tpArray[1];
			}

			$secondaryTPNumberCombined = $this->input->post('secendory_telephone_number');
			$tpArray = explode(' ', $secondaryTPNumberCombined);
			$secondaryTPNumberCountryCode = $tpArray[0];
			$secondaryTPNumber = '';
			if (sizeof($tpArray) > 1) {
				$secondaryTPNumber = $tpArray[1];
			}

			$faxNumberCombined = $this->input->post('fax');
			$tpArray = explode(' ', $faxNumberCombined);
			$faxCountryCode = $tpArray[0];
			$faxNumber = '';
			if (sizeof($tpArray) > 1) {
				$faxNumber = $tpArray[1];
			}

			if ($this->form_validation->run() == FALSE) {
				$data['company_info'] = array(
					'company_name' => $this->input->post('company_name'),
					'company_short_name' => $this->input->post('company_short_name'),
					'email' => $this->input->post('email'),
					'web' => $this->input->post('web'),
					'primary_telephone_number' => $primaryTPNumberCountryCode . ' ' . $primaryTPNumber,
					'secendory_telephone_number' => $secondaryTPNumberCountryCode . ' ' . $secondaryTPNumber,
					'fax' => $faxCountryCode . ' ' . $faxNumber,
					'address' => $this->input->post('address'),
					'short_address' => $this->input->post('short_address')
				);
				$this->load->view('web/organizationManagerModule/organizationSection/companyInformation/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer');
			} else {
				$data = array(
					'company_name' => $this->input->post('company_name'),
					'company_short_name' => $this->input->post('company_short_name'),
					'web' => $this->input->post('web'),
					'email' => $this->input->post('email'),
					'ptn_country_code' => $primaryTPNumberCountryCode,
					'primary_telephone_number' => $primaryTPNumber,
					'stn_country_code' => $secondaryTPNumberCountryCode,
					'secendory_telephone_number' => $secondaryTPNumber,
					'fax_country_code' => $faxCountryCode,
					'fax_number' => $faxNumber,
					'address' => $this->input->post('address'),
					'short_address' => $this->input->post('short_address')
				);

				$result = $this->company_information_model->getAll();

				if ($result) {
					$this->company_information_model->edit($result[0]->id, $data);
				} else {
					$this->company_information_model->add($data);
				}

				$data['massage'] = '<div class="alert alert-success alert-dismissable">
									<a class="close" href="#" data-dismiss="alert">× </a>
									<h4><i class="icon-ok-sign"></i>'.
					$this->lang->line('success').'</h4>'.
					$this->lang->line('success_saved').
					'</div>';

				$data['company_info'] = array(
					'company_name' => $this->input->post('company_name'),
					'company_short_name' => $this->input->post('company_short_name'),
					'email' => $this->input->post('email'),
					'web' => $this->input->post('web'),
					'primary_telephone_number' => $primaryTPNumberCountryCode . ' ' . $primaryTPNumber,
					'secendory_telephone_number' => $secondaryTPNumberCountryCode . ' ' . $secondaryTPNumber,
					'fax' => $faxCountryCode . ' ' . $faxNumber,
					'address' => $this->input->post('address'),
					'short_address' => $this->input->post('short_address')
				);
				$this->load->view('web/organizationManagerModule/organizationSection/companyInformation/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer');
			}
		}
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