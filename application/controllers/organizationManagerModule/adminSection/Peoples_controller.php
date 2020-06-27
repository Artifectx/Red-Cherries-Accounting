<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peoples_controller extends CI_Controller {

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
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/files_model', '', TRUE);
		$this->load->helper('download');
		$this->load->helper('url');
		$this->load->library('common_library/common_functions');

		$this->export = false;

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
		$data_cls['li_class_peoples'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$data['peopleType'] = $this->getPeopleType();
		$data['systemConfigData'] = $this->getSystemConfigData();

		if(isset($this->data['OGM_Admin_View_People_Permissions']))
			$this->load->view('web/organizationManagerModule/adminSection/people/index', $data);

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getPeopleType() {

		//get all system modules details

        $peopleType = array(
                        array(
                            'people_type'=>'Supplier'
                        ),
                        array(
                            'people_type'=>'Agent'
                        ),
                        array(
                            'people_type'=>'Customer'
                        ),
                        array(
                            'people_type'=>'Sales Rep'
                        ),
                        array(
                            'people_type'=>'Cashier'
                        ),
                        array(
                            'people_type'=>'Driver'
                        ),
                        array(
                            'people_type'=>'Member'
                        ),
                        array(
                            'people_type'=>'Employee'
                        )
                    );

		return $peopleType;
	}

	public function getCountryDropDown() {
		$data['country'] = $this->common_model->getCountryList('name', 'ase');
			$html = "<div class='form-group'>
						<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Country')} </label>
						   <div class='col-sm-4 controls'>
								<select class='form-control' id='country'>
									<option value=''>" . $this->lang->line('-- Select Country --') . "</option>";
									foreach ($data['country'] as $row) {
										$html .= "<option value='{$row->country_code}'>{$row->country_name}</option>";
									}
			$html .= " </select>
						<div id='countryError' class='red'></div>
							</div>
						</div>
					</div>";

		echo $html;
	}

	public function add() {
		if(isset($this->data['OGM_Admin_Add_People_Permissions'])){
			if($this->form_validation->run() == FALSE){
				$result = validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
                
                echo json_encode(array('result' => $result));
			} else {
				$primaryTPNumberCombined =  $this->input->post('primary_telephone_number');
				$tpArray = explode(' ', $primaryTPNumberCombined);
				$primaryTPNumberCountryCode = $tpArray[0];
				$primaryTPNumber = '';
				if (sizeof($tpArray) > 1) {
					$primaryTPNumber = $tpArray[1];
				}

				$secondaryTPNumberCombined = $this->input->post('secondary_telephone_number');
				$tpArray = explode(' ', $secondaryTPNumberCombined);
				$secondaryTPNumberCountryCode = $tpArray[0];
				$secondaryTPNumber = '';
				if (sizeof($tpArray) > 1) {
					$secondaryTPNumber = $tpArray[1];
				}

				$faxNumberCombined = $this->input->post('fax');
				$faxArray = explode(' ', $faxNumberCombined);
				$faxNumberCountryCode = $faxArray[0];
				$faxNumber = '';
				if (sizeof($faxArray) > 1) {
					$faxNumber = $faxArray[1];
				}

				$locationId = '';
				$peopleType = $this->db->escape_str($this->input->post('people_type'));
				$locationIds = $this->db->escape_str($this->input->post('location_ids'));

				$isAlsoASalesRep = $this->db->escape_str($this->input->post('is_also_a_sales_rep'));
				$isAlsoACashier = $this->db->escape_str($this->input->post('is_also_a_cashier'));

				if ($peopleType != "Agent" && $locationIds != '') {
					$locationIdList = explode(",", $locationIds);
					$locationId = $locationIdList[0];
				}

				$address = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('address')));
                
                $authorized = "No";
                $peopleAdditionAuthorizationFeatureEnabled = $this->system_configurations_model->isPeopleAdditionAuthorizationFeatureEnabled();
                $peopleAdditionAuthorizerId = $this->system_configurations_model->getCurrentPeopleAdditionAuthorizerData();
                $user = $this->user_model->getUserByPeopleId($peopleAdditionAuthorizerId);
                
                if ($peopleAdditionAuthorizationFeatureEnabled) {
                    if ($user && sizeof($user) > 0) {
                        if ($user[0]->user_id == $this->user_id) {
                            $authorized = "Yes";
                        }
                    }
                } else {
                    $authorized = "Yes";
                }
                
				$data = array(
					'people_type' => $peopleType,
					'people_category' => $this->db->escape_str($this->input->post('people_category')),
					'people_code' => $this->db->escape_str($this->input->post('people_code')),
					'people_name' => $this->db->escape_str($this->input->post('people_name')),
                    'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
					'is_also_a_sales_rep' => $isAlsoASalesRep,
					'is_also_a_cashier' => $isAlsoACashier,
					'nic' => $this->db->escape_str($this->input->post('nic')),
					'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
					'people_address' => $address,
					'country_id' => $this->db->escape_str($this->input->post('country_id')),
					'location_id' => $locationId,
					'people_ptn_country_code' => $primaryTPNumberCountryCode,
					'people_primary_telephone_number' => $primaryTPNumber,
					'people_stn_country_code' => $secondaryTPNumberCountryCode,
					'people_secondory_telephone_number' => $secondaryTPNumber,
					'people_email' => $this->db->escape_str($this->input->post('email')),
					'people_fax_country_code' => $faxNumberCountryCode,
					'people_fax_no' => $faxNumber,
					'login_status' => '0',
					'immediate_contact_person' => $this->db->escape_str($this->input->post('immediate_contact_person')),
					'immediate_contact_telephone_number' => $this->db->escape_str($this->input->post('immediate_contact_phone')),
                    'authorized' => $authorized,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$peopleId = $this->peoples_model->add($data);

				if ($peopleType == "Agent") {
					$locationIdList = explode(",", $locationIds);

					foreach ($locationIdList as $locationId) {
						$data = array(
							'people_id' => $peopleId,
							'location_id' => $locationId,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->peoples_model->addPeopleLocation($data);
					}
				}

				if ($peopleType == "Employee" && $isAlsoASalesRep == "Yes") {
					$data = array(
						'people_type' => "Sales Rep",
						'people_category' => $this->db->escape_str($this->input->post('people_category')),
						'people_code' => '',
						'people_name' => $this->db->escape_str($this->input->post('people_name')),
                        'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
						'nic' => $this->db->escape_str($this->input->post('nic')),
						'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
						'people_address' => $address,
						'country_id' => $this->db->escape_str($this->input->post('country_id')),
						'location_id' => $locationId,
						'people_ptn_country_code' => $primaryTPNumberCountryCode,
						'people_primary_telephone_number' => $primaryTPNumber,
						'people_stn_country_code' => $secondaryTPNumberCountryCode,
						'people_secondory_telephone_number' => $secondaryTPNumber,
						'people_email' => $this->db->escape_str($this->input->post('email')),
						'people_fax_country_code' => $faxNumberCountryCode,
						'people_fax_no' => $faxNumber,
						'login_status' => '0',
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);

					$salesRepId = $this->peoples_model->add($data);

					$salesRepData = array(
						'sales_rep_id' => $salesRepId
					);

					$this->peoples_model->edit($peopleId, $salesRepData);
				} else if ($peopleType == "Employee" && $isAlsoACashier == "Yes") {
					$data = array(
						'people_type' => "Cashier",
						'people_category' => $this->db->escape_str($this->input->post('people_category')),
						'people_code' => '',
						'people_name' => $this->db->escape_str($this->input->post('people_name')),
                        'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
						'nic' => $this->db->escape_str($this->input->post('nic')),
						'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
						'people_address' => $address,
						'country_id' => $this->db->escape_str($this->input->post('country_id')),
						'location_id' => $locationId,
						'people_ptn_country_code' => $primaryTPNumberCountryCode,
						'people_primary_telephone_number' => $primaryTPNumber,
						'people_stn_country_code' => $secondaryTPNumberCountryCode,
						'people_secondory_telephone_number' => $secondaryTPNumber,
						'people_email' => $this->db->escape_str($this->input->post('email')),
						'people_fax_country_code' => $faxNumberCountryCode,
						'people_fax_no' => $faxNumber,
						'login_status' => '0',
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);

					$cashierId = $this->peoples_model->add($data);

					$cashierData = array(
						'cashier_id' => $cashierId
					);

					$this->peoples_model->edit($peopleId, $cashierData);
				}
				
				$peopleIdSelected = $this->db->escape_str($this->input->post('people_id'));
				
				if ($peopleType == "Sales Rep" && $peopleIdSelected != "") {
					$salesRepData = array(
						'is_also_a_sales_rep' => "Yes",
						'sales_rep_id' => $peopleId
					);

					$this->peoples_model->edit($peopleIdSelected, $salesRepData);
				} else if ($peopleType == "Cashier" && $peopleIdSelected != "") {
					$salesRepData = array(
						'is_also_a_cashier' => "Yes",
						'cashier_id' => $peopleId
					);

					$this->peoples_model->edit($peopleIdSelected, $salesRepData);
				}

				echo json_encode(array('result' => 'ok', 'peopleId' => $peopleId));
			}
		}
	}

	public function edit() {
		if(isset($this->data['OGM_Admin_Edit_People_Permissions'])){
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$peopleId = $this->db->escape_str($this->input->post('people_id'));

				$people = $this->peoples_model->getById($peopleId);
				$alreadyASalesRep = $people[0]->is_also_a_sales_rep;
				$alreadyACashier = $people[0]->is_also_a_cashier;

				$primaryTPNumberCombined =  $this->input->post('primary_telephone_number');
				$tpArray = explode(' ', $primaryTPNumberCombined);
				$primaryTPNumberCountryCode = $tpArray[0];
				$primaryTPNumber = '';
				if (sizeof($tpArray) > 1) {
					$primaryTPNumber = $tpArray[1];
				}

				$secondaryTPNumberCombined = $this->input->post('secondary_telephone_number');
				$tpArray = explode(' ', $secondaryTPNumberCombined);
				$secondaryTPNumberCountryCode = $tpArray[0];
				$secondaryTPNumber = '';
				if (sizeof($tpArray) > 1) {
					$secondaryTPNumber = $tpArray[1];
				}

				$faxNumberCombined = $this->input->post('fax');
				$faxArray = explode(' ', $faxNumberCombined);
				$faxNumberCountryCode = $faxArray[0];
				$faxNumber = '';
				if (sizeof($faxArray) > 1) {
					$faxNumber = $faxArray[1];
				}

				$locationId = '';
				$peopleType = $this->db->escape_str($this->input->post('people_type'));
				$locationIds = $this->db->escape_str($this->input->post('location_ids'));

				if ($peopleType != "Agent") {
					$locationId = $locationIds;
				}

				$isAlsoASalesRep = $this->db->escape_str($this->input->post('is_also_a_sales_rep'));

				$updatedAsNotASalesRep = false;
				$updatedAsASalesRep = false;
				if ($alreadyASalesRep == "Yes" && $isAlsoASalesRep == "No") {
					$updatedAsNotASalesRep = true;
				} else if ($alreadyASalesRep == "No" && $isAlsoASalesRep == "Yes") {
					$updatedAsASalesRep = true;
				}

				$salesRepId = '';
				if ($updatedAsNotASalesRep) {
					$salesRepId = '0';
				} else {
					$salesRepId = $people[0]->sales_rep_id;
				}
				
				$isAlsoACashier = $this->db->escape_str($this->input->post('is_also_a_cashier'));

				$updatedAsNotACashier = false;
				$updatedAsACashier = false;
				if ($alreadyACashier == "Yes" && $isAlsoACashier == "No") {
					$updatedAsNotACashier = true;
				} else if ($alreadyACashier == "No" && $isAlsoACashier == "Yes") {
					$updatedAsACashier = true;
				}

				$cashierId = '';
				if ($updatedAsNotACashier) {
					$cashierId = '0';
				} else {
					$cashierId = $people[0]->cashier_id;
				}

				$address = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('address')));

				$data = array(
					'people_type' => $peopleType,
					'people_category' => $this->db->escape_str($this->input->post('people_category')),
					'people_code' => $this->db->escape_str($this->input->post('people_code')),
					'people_name' => $this->db->escape_str($this->input->post('people_name')),
                    'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
					'is_also_a_sales_rep' => $isAlsoASalesRep,
					'is_also_a_cashier' => $isAlsoACashier,
					'sales_rep_id' => $salesRepId,
					'nic' => $this->db->escape_str($this->input->post('nic')),
					'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
					'people_address' => $address,
					'country_id' => $this->db->escape_str($this->input->post('country_id')),
					'location_id' => $locationId,
					'people_ptn_country_code' => $primaryTPNumberCountryCode,
					'people_primary_telephone_number' => $primaryTPNumber,
					'people_stn_country_code' => $secondaryTPNumberCountryCode,
					'people_secondory_telephone_number' => $secondaryTPNumber,
					'people_email' => $this->db->escape_str($this->input->post('email')),
					'people_fax_country_code' => $faxNumberCountryCode,
					'people_fax_no' => $faxNumber,
					'login_status' => '0',
					'immediate_contact_person' => $this->db->escape_str($this->input->post('immediate_contact_person')),
					'immediate_contact_telephone_number' => $this->db->escape_str($this->input->post('immediate_contact_phone')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);

				$this->peoples_model->edit($peopleId, $data);

				if ($peopleType == "Agent") {

					$this->peoples_model->dropPeopleLocations($peopleId);
					$locationIdList = explode(",", $locationIds);

					foreach ($locationIdList as $locationId) {
						$data = array(
							'people_id' => $peopleId,
							'location_id' => $locationId,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->peoples_model->addPeopleLocation($data);
					}
				}

				if ($updatedAsNotASalesRep) {
					$this->delete($people[0]->sales_rep_id);
				}

				if ($updatedAsASalesRep) {
					if ($peopleType == "Employee" && $isAlsoASalesRep == "Yes") {
						$data = array(
							'people_type' => "Sales Rep",
							'people_category' => $this->db->escape_str($this->input->post('people_category')),
							'people_code' => '',
							'people_name' => $this->db->escape_str($this->input->post('people_name')),
                            'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
							'nic' => $this->db->escape_str($this->input->post('nic')),
							'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
							'people_address' => $address,
							'country_id' => $this->db->escape_str($this->input->post('country_id')),
							'location_id' => $locationId,
							'people_ptn_country_code' => $primaryTPNumberCountryCode,
							'people_primary_telephone_number' => $primaryTPNumber,
							'people_stn_country_code' => $secondaryTPNumberCountryCode,
							'people_secondory_telephone_number' => $secondaryTPNumber,
							'people_email' => $this->db->escape_str($this->input->post('email')),
							'people_fax_country_code' => $faxNumberCountryCode,
							'people_fax_no' => $faxNumber,
							'login_status' => '0',
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$salesRepId = $this->peoples_model->add($data);

						$salesRepData = array(
							'sales_rep_id' => $salesRepId
						);

						$this->peoples_model->edit($peopleId, $salesRepData);
					}
				} else if ($isAlsoASalesRep == "Yes") {
					$data = array(
						'people_name' => $this->db->escape_str($this->input->post('people_name')),
                        'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
						'nic' => $this->db->escape_str($this->input->post('nic')),
						'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
						'people_address' => $address,
						'country_id' => $this->db->escape_str($this->input->post('country_id')),
						'people_ptn_country_code' => $primaryTPNumberCountryCode,
						'people_primary_telephone_number' => $primaryTPNumber,
						'people_stn_country_code' => $secondaryTPNumberCountryCode,
						'people_secondory_telephone_number' => $secondaryTPNumber,
						'people_email' => $this->db->escape_str($this->input->post('email')),
						'people_fax_country_code' => $faxNumberCountryCode,
						'people_fax_no' => $faxNumber,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->peoples_model->edit($salesRepId, $data);
				}
				
				if ($updatedAsNotACashier) {
					$this->delete($people[0]->cashier_id);
				}

				if ($updatedAsACashier) {
					if ($peopleType == "Employee" && $isAlsoACashier == "Yes") {
						$data = array(
							'people_type' => "Cashier",
							'people_category' => $this->db->escape_str($this->input->post('people_category')),
							'people_code' => '',
							'people_name' => $this->db->escape_str($this->input->post('people_name')),
                            'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
							'nic' => $this->db->escape_str($this->input->post('nic')),
							'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
							'people_address' => $address,
							'country_id' => $this->db->escape_str($this->input->post('country_id')),
							'location_id' => $locationId,
							'people_ptn_country_code' => $primaryTPNumberCountryCode,
							'people_primary_telephone_number' => $primaryTPNumber,
							'people_stn_country_code' => $secondaryTPNumberCountryCode,
							'people_secondory_telephone_number' => $secondaryTPNumber,
							'people_email' => $this->db->escape_str($this->input->post('email')),
							'people_fax_country_code' => $faxNumberCountryCode,
							'people_fax_no' => $faxNumber,
							'login_status' => '0',
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$cashierId = $this->peoples_model->add($data);

						$cashierData = array(
							'cashier_id' => $cashierId
						);

						$this->peoples_model->edit($peopleId, $cashierData);
					}
				} else if ($isAlsoACashier == "Yes") {
					$data = array(
						'people_name' => $this->db->escape_str($this->input->post('people_name')),
                        'people_short_name' => $this->db->escape_str($this->input->post('people_short_name')),
						'nic' => $this->db->escape_str($this->input->post('nic')),
						'birth_day' => $this->db->escape_str($this->input->post('birth_day')),
						'people_address' => $address,
						'country_id' => $this->db->escape_str($this->input->post('country_id')),
						'people_ptn_country_code' => $primaryTPNumberCountryCode,
						'people_primary_telephone_number' => $primaryTPNumber,
						'people_stn_country_code' => $secondaryTPNumberCountryCode,
						'people_secondory_telephone_number' => $secondaryTPNumber,
						'people_email' => $this->db->escape_str($this->input->post('email')),
						'people_fax_country_code' => $faxNumberCountryCode,
						'people_fax_no' => $faxNumber,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->peoples_model->edit($cashierId, $data);
				}

				echo "ok";
			}
		}
	}

	public function delete($peopleId=null) {
		if(isset($this->data['OGM_Admin_Delete_People_Permissions'])){
			$status = 'deleted';
			$deleteSalesRepFromEmployee = false;
			$deleteCashierFromEmployee = false;
            
			if ($peopleId == '') {
				$peopleId = $this->db->escape_str($this->input->post('people_id'));
			} else {
				$deleteSalesRepFromEmployee = true;
				$deleteCashierFromEmployee = true;
			}
            
			if ($this->peoples_model->delete($peopleId, $status, $this->user_id)) {
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}

			if (!$deleteSalesRepFromEmployee && !$deleteCashierFromEmployee) {
				echo $html;
			}
		}
	}

	public function get() {
		if(isset($this->data['OGM_Admin_Edit_People_Permissions'])){
			$peopleId = $this->db->escape_str($this->input->post('people_id'));
			$data['people'] = $this->peoples_model->getById($peopleId);
			$agentLocations = $this->peoples_model->getPeopleLocationsByPeopleId($peopleId);

			$agentLocationIds = '';
			if ($agentLocations && sizeof($agentLocations) > 0) {
				foreach ($agentLocations as $agentLocation) {
					$agentLocationIds[] = $agentLocation->location_id;
				}
			}
			
			$peopleDocuments = $this->files_model->getPeopleDocuments($peopleId);
			
			$language = $this->userManagement->getUserLanguage($this->user_id);
		
			$menuFormatting = '';
			if ($language == "sinhala") {
				$menuFormatting = 'style="font-weight: bold;"';
			}

			$peopleDocumentList = '';
			if ($peopleDocuments && sizeof($peopleDocuments) > 0) {
				foreach ($peopleDocuments as $peopleDocument) {
					$documentId = $peopleDocument->id;
					$peopleId = $peopleDocument->people_id;
					$length = strlen($peopleId) + 10;
					$fileName = substr($peopleDocument->file_name, $length);
					$filePath = base_url() . "/fileUploads/peopleDocuments/" . $peopleDocument->file_name;
					$peopleDocumentList .= "<div class='form-group' id='people_document_" . $documentId . "'>
											<div class='col-sm-12 controls'>
												<label class='control-label col-sm-7'><a href = '" . $filePath . "' download>" . $fileName . "</a></label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_docement_" . $documentId . "'
														onclick='deleteDocument(this.id)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				}
			}

			//echo "<pre>";print_r($data['people']);die;
			$peopleType = $data['people'][0]->people_type;
			$html = "";
			if ($data['people'] && sizeof($data['people']) > 0) {
				foreach ($data['people'] as $row) {
					$html .= "<form class='form form-horizontal validate-form save_form'>
								<div class='row'>
									<div class='col-sm-7'>
									<input class='form-control' data-rule-required='true' id='people_id_edit' name='people_id_edit' type='hidden' value='{$row->people_id}'>
									<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('People Type')} *</label>
									   <div class='col-sm-7 controls'>
											<select class='form-control' name='people_type_edit' id='people_type_edit' onchange='getPeopleTypeEdit();'>";
							$data['peopleType']=$this->getPeopleType();
							foreach($data['peopleType'] as $rowPeopleType) {
								if($rowPeopleType['people_type'] == $row->people_type)
									$html .= "<option value='{$rowPeopleType['people_type']}' selected>{$rowPeopleType['people_type']}</option>";
								else
									$html .= "<option value='{$rowPeopleType['people_type']}'>{$rowPeopleType['people_type']}</option>";
							}
							$html .="</select>
										<div id='people_type_editError' class='red'></div>
										</div>
									</div>";

							if ($row->people_type == "Employee") {
								if ($row->is_also_a_sales_rep == "Yes") {
									$html .="<div class='form-group' id='is_also_sales_rep_div_edit'>
												<div class='col-sm-5 controls'></div>
												<div class='col-sm-7 controls'>
													<input type='checkbox' name='is_also_sales_rep_edit' id='is_also_sales_rep_edit' style='vertical-align: text-bottom;' checked>
													<label for='is_also_sales_rep_edit' >{$this->lang->line('Is Also a Sales Rep')}</label>
												</div>
											</div>";
								} else {
									$html .="<div class='form-group' id='is_also_sales_rep_div_edit'>
												<div class='col-sm-5 controls'></div>
												<div class='col-sm-7 controls'>
													<input type='checkbox' name='is_also_sales_rep_edit' id='is_also_sales_rep_edit' style='vertical-align: text-bottom;'>
													<label for='is_also_sales_rep_edit' >{$this->lang->line('Is Also a Sales Rep')}</label>
												</div>
											</div>";
								}
								
								if ($row->is_also_a_cashier == "Yes") {
									$html .="<div class='form-group' id='is_also_cashier_div_edit'>
												<div class='col-sm-5 controls'></div>
												<div class='col-sm-7 controls'>
													<input type='checkbox' name='is_also_cashier_edit' id='is_also_cashier_edit' style='vertical-align: text-bottom;' checked>
													<label for='is_also_cashier_edit' >{$this->lang->line('Is Also a Cashier')}</label>
												</div>
											</div>";
								} else {
									$html .="<div class='form-group' id='is_also_cashier_edit_div_edit'>
												<div class='col-sm-5 controls'></div>
												<div class='col-sm-7 controls'>
													<input type='checkbox' name='is_also_cashier_edit' id='is_also_cashier_edit' style='vertical-align: text-bottom;'>
													<label for='is_also_cashier_edit' >{$this->lang->line('Is Also a Cashier')}</label>
												</div>
											</div>";
								}
							} else {
								$html .="<div class='form-group' id='is_also_sales_rep_div_edit' style='display:none'>
											<div class='col-sm-5 controls'></div>
											<div class='col-sm-7 controls'>
												<input type='checkbox' name='is_also_sales_rep_edit' id='is_also_sales_rep_edit' style='vertical-align: text-bottom;'>
												<label for='is_also_sales_rep_edit' >{$this->lang->line('Is Also a Sales Rep')}</label>
											</div>
										</div>";
												
								$html .="<div class='form-group' id='is_also_cashier_div_edit' style='display:none'>
											<div class='col-sm-5 controls'></div>
											<div class='col-sm-7 controls'>
												<input type='checkbox' name='is_also_cashier_edit' id='is_also_cashier_edit' style='vertical-align: text-bottom;'>
												<label for='is_also_cashier_edit' >{$this->lang->line('Is Also a Cashier')}</label>
											</div>
										</div>";
							}

							$peopleType = $row->people_type;
							$screen = "edit_screen";
							if ($row->people_category != '') {
								if($row->people_type == "Agent") {
									if ($row->people_category != '' && $row->people_category != "Agent") {
										$data = explode("-", $row->people_category);
										$agentCategoriesOptions = $this->system_configurations_model->getAgentCategoriesAsOptionListWithSavedOption(trim($data[1]));
									} else {
										$this->system_configurations_model->getAgentCategoriesAsOptionList();
									}

									$html .= "  <div id='people_category_div_edit'>
													<div class='form-group'>
														<label class='control-label col-sm-5'>{$this->lang->line('Agent Category')}</label>
														<div class='col-sm-7 controls'>
															<select class='form-control' name='agent_category_edit' id='agent_category_edit' onchange='handlePeopleCategorySelect(/{$screen}/, /{$peopleType}/, this.id);'>
																{$agentCategoriesOptions}
															</select>
															<div id='agent_category_editError' class='red'></div>
														</div>
													</div>
												</div>";
								} else if ($row->people_type == "Customer") {
									if ($row->people_category != '' && $row->people_category != "Customer") {
										$data = explode("-", $row->people_category);
										$customerCategoriesOptions = $this->system_configurations_model->getCustomerCategoriesAsOptionListWithSavedOption(trim($data[1]));
									} else {
										$customerCategoriesOptions = $this->system_configurations_model->getCustomerCategoriesAsOptionList();
									}

									$html .= "  <div id='people_category_div_edit'>
													<div class='form-group'>
														<label class='control-label col-sm-5'>{$this->lang->line('Customer Category')}</label>
														<div class='col-sm-7 controls'>
															<select class='form-control' name='customer_category_edit' id='customer_category_edit' onchange='handlePeopleCategorySelect(/{$screen}/, /{$peopleType}/, this.id);'>
																{$customerCategoriesOptions}
															</select>
															<div id='customer_category_editError' class='red'></div>
														</div>
													</div>
												</div>";
								}
							} else {
								if($row->people_type == "Agent") {
									if ($this->system_configurations_model->getAgentCategories()) {
										$agentCategoriesOptions = $this->system_configurations_model->getAgentCategoriesAsOptionList();

										$html .= "  <div id='people_category_div_edit'>
														<div class='form-group'>
															<label class='control-label col-sm-5'>{$this->lang->line('Agent Category')}</label>
															<div class='col-sm-7 controls'>
																<select class='form-control' name='agent_category_edit' id='agent_category_edit' onchange='handlePeopleCategorySelect(/{$screen}/, /{$peopleType}/, this.id);'>
																	{$agentCategoriesOptions}
																</select>
																<div id='agent_category_editError' class='red'></div>
															</div>
														</div>
													</div>";
									}
								} else if ($row->people_type == "Customer") {
									if ($this->system_configurations_model->getCustomerCategories()) {
										$customerCategoriesOptions = $this->system_configurations_model->getCustomerCategoriesAsOptionList();

										$html .= "  <div id='people_category_div_edit'>
														<div class='form-group'>
															<label class='control-label col-sm-5'>{$this->lang->line('Customer Category')}</label>
															<div class='col-sm-7 controls'>
																<select class='form-control' name='customer_category_edit' id='customer_category_edit' onchange='handlePeopleCategorySelect(/{$screen}/, /{$peopleType}/, this.id);'>
																	{$customerCategoriesOptions}
																</select>
																<div id='customer_category_editError' class='red'></div>
															</div>
														</div>
													</div>";
									}
								}
							}

							$html .="<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('People Code')} *</label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='people_code_edit' name='people_code_edit' placeholder='{$this->lang->line('People Code')}' type='text'
															   value='{$row->people_code}'>
										<div id='people_code_editError' class='red'></div>
										</div>
									</div>";
									
								if ($row->people_type == "Sales Rep" || $row->people_type == "Cashier" || $row->people_type == "Driver") {
							$html .="<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('People Name')}</label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='people_name_edit' name='people_name_edit' placeholder='{$this->lang->line('People Name')}' type='text' value='{$row->people_name}' disabled>
											<div id='people_name_editError' class='red'></div>
										</div>
									</div>";
								} else {
							$html .="<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('People Name')} *</label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='people_name_edit' name='people_name_edit' placeholder='{$this->lang->line('People Name')}' type='text' value='{$row->people_name}'>
											<div id='people_name_editError' class='red'></div>
										</div>
									</div>";		
								}
                                
                            $html .="<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('People Short Name')}</label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='people_short_name_edit' name='people_short_name_edit' placeholder='{$this->lang->line('People Short Name')}' type='text' value='{$row->people_short_name}'>
											<div id='people_short_name_editError' class='red'></div>
										</div>
									</div>";

								if ($row->people_type == "Sales Rep" || $row->people_type == "Cashier" || $row->people_type == "Driver") {
							$html .="<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('NIC')}</label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='nic_edit' name='nic_edit' placeholder='{$this->lang->line('NIC')}' type='text'
															   value='{$row->nic}' disabled>
											<div id='nic_editError' class='red'></div>
										</div>
									</div>

									<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('Birthday')} </label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='birth_day_edit' name='birth_day_edit' placeholder='{$this->lang->line('Birthday')}' type='text' value='{$row->birth_day}' disabled>
											<div id='birth_day_editError' class='red'></div>
										</div>
									</div>
									";


							$country= $this->common_model->getSelectedCountryList($row->country_id);
							$html .= "  <div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('Country')} </label>
										<div class='col-sm-7 controls'>
											<select class='form-control' id='country_edit' readonly>
											   {$country}
											</select>
											<div id='country_editError' class='red'></div>
										</div>
									</div>";
								} else {
							$html .="<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('NIC')}</label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='nic_edit' name='nic_edit' placeholder='{$this->lang->line('NIC')}' type='text'
															   value='{$row->nic}'>
											<div id='nic_editError' class='red'></div>
										</div>
									</div>

									<div class='form-group'>
									   <label class='control-label col-sm-5'>{$this->lang->line('Birthday')} </label>
									   <div class='col-sm-7 controls'>
											<input class='form-control' id='birth_day_edit' name='birth_day_edit' placeholder='{$this->lang->line('Birthday')}' type='text'
															   value='{$row->birth_day}'>
											<div id='birth_day_editError' class='red'></div>
										</div>
									</div>
									";


							$country= $this->common_model->getSelectedCountryList($row->country_id);
							$html .= "  <div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('Country')} </label>
										<div class='col-sm-7 controls'>
											<select class='form-control' id='country_edit'>
											   {$country}
											</select>
											<div id='country_editError' class='red'></div>
										</div>
									</div>";
								}

							if($row->people_type == "Agent" || $row->people_type == "Customer") {
								if ($row->people_type == "Agent") {
									$locations = $this->locations_model->getAllLocationsAsOptionList("Location Name");
									$html .= " <div id='location_dropdown_edit'>
												<div class='form-group'>
													<label class='control-label col-sm-5'>{$this->lang->line('Location')} </label>
													<div class='col-sm-7 controls'>
														<select class='select2 form-control' multiple id='location_edit'>
														   {$locations}
														</select>
														<div id='location_editError' class='red'></div>
													</div>
												</div>
										   </div>";
								} else {
									$locations = $this->locations_model->getLocationsToDropDownWithSavedOption($row->location_id, "Location Name");
									$html .= " <div id='location_dropdown_edit'>
												<div class='form-group'>
													<label class='control-label col-sm-5'>{$this->lang->line('Location')} </label>
													<div class='col-sm-7 controls'>
														<select class='form-control' id='location_edit'>
														   {$locations}
														</select>
														<div id='location_editError' class='red'></div>
													</div>
												</div>
										   </div>";
								}
							} else {
								$html .= "<div id='location_dropdown_edit'></div>";
							}

							$address = preg_replace('~\\\r\\\n~',"<br>", $row->people_address);
							$address = str_ireplace("<br>", "\r\n", $address);

								if ($row->people_type == "Sales Rep" || $row->people_type == "Cashier" || $row->people_type == "Driver") {
							$html .= "<div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('Address')} </label>
										<div class='col-sm-7 controls'>
											<textarea class='form-control' id='address_edit' name='address_edit' placeholder='{$this->lang->line('Address')}' disabled>{$address}</textarea>
											<div id='address_editError' class='red'></div>
										</div>
									</div>";
								} else {
							$html .= "<div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('Address')} </label>
										<div class='col-sm-7 controls'>
											<textarea class='form-control' id='address_edit' name='address_edit' placeholder='{$this->lang->line('Address')}'>{$address}</textarea>
											<div id='address_editError' class='red'></div>
										</div>
									</div>";
								}
                            
							$html .= "<div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('Primary Phone No')} </label>
										<div class='col-sm-7 controls'>
											<input class='form-control' id='primary_phone_edit'
												   name='primary_phone_edit' placeholder='{$this->lang->line('Primary Phone No') }' type='text'
												   value='{$row->people_ptn_country_code} {$row->people_primary_telephone_number}'>
											<div id='primary_phone_editError' class='red'></div>
										</div>
									</div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('Secondary Phone No') } </label>
										<div class='col-sm-7 controls'>
											<input class='form-control' id='secondary_phone_edit'
												   name='secondary_phone_edit' placeholder='{$this->lang->line('Secondary Phone No') }' type='text'
												   value='{$row->people_stn_country_code} {$row->people_secondory_telephone_number}'>
											<div id='secondary_phone_editError' class='red'></div>
										</div>
									</div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('E-mail')} </label>
										<div class='col-sm-7 controls'>
											<input class='form-control' id='email_edit'
												   name='email_edit' placeholder='{$this->lang->line('E-mail') }' type='text'
												   value='{$row->people_email}'>
											<div id='email_editError' class='red'></div>
										</div>
									</div>

									<div class='form-group'>
										<label class='control-label col-sm-5'>{$this->lang->line('Fax')} </label>
										<div class='col-sm-7 controls'>
											<input class='form-control' id='fax_edit'
												   name='fax_edit' placeholder='{$this->lang->line('Fax') }' type='text'
												   value='{$row->people_fax_country_code} {$row->people_fax_no}'>
											<div id='fax_editError' class='red'></div>
										</div>
									</div>";
												   
								if($row->people_type == "Supplier" || $row->people_type == "Agent" || $row->people_type == "Customer" || $row->people_type == "Employee" || $row->people_type == "Member") {
					$html .= "		<div class='form-group'  id='immediate_contact_person_div_edit'>
										<label class='control-label col-sm-5'>{$this->lang->line('Immediate Contact Person')} </label>
										<div class='col-sm-7 controls'>
											<input class='form-control' id='immediate_contact_person_edit'
												   name='immediate_contact_person_edit' placeholder='{$this->lang->line('Immediate Contact Person') }' type='text'
												   value='{$row->immediate_contact_person}'>
											<div id='immediate_contact_person_editError' class='red'></div>
										</div>
									</div>
									
									<div class='form-group'  id='immediate_contact_phone_div_edit'>
										<label class='control-label col-sm-5'>{$this->lang->line('Immediate Contact Phone No')} </label>
										<div class='col-sm-7 controls'>
											<input class='form-control' id='immediate_contact_phone_edit'
												   name='immediate_contact_phone_edit' placeholder='{$this->lang->line('Immediate Contact Phone No') }' type='text'
												   value='{$row->immediate_contact_telephone_number}'>
											<div id='immediate_contact_phone_editError' class='red'></div>
										</div>
									</div>";
								}
							
					$html .= "	</div>
								<div class='col-sm-5'>
									<div class='form-group' id='document_upload_edit' style='text-align: center;'>
										<button class='btn btn-success save' onclick='openDocumentUploadDialog({$row->people_id});' type='button'" . $menuFormatting . ">
											<i class='icon-save'></i>
											{$this->lang->line('Upload A Document')}
										</button>			
									</div>
									<div class='form-group' id='document_list_edit'>";
							$html .=		$peopleDocumentList;
					$html .="		</div>";
					
								if($row->people_type == "Cashier") {
					$html .="		<div class='form-group' id='cashier_sales_performance_edit' style='text-align: center;'>
										<button class='btn btn-success save' onclick='openCashierSalesPerformanceDialog({$row->people_id});' type='button'" . $menuFormatting . ">
											<i class='icon-save'></i>
											{$this->lang->line('Cashier Sales Performance')}
										</button>			
									</div>";
								}		
											
					$html .="	</div>
							</div>
							<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
										if (isset($this->data['OGM_Admin_Edit_People_Permissions'])){
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

			echo json_encode(array('html' => $html, 'peopleType' => $peopleType, 'agentLocations' => $agentLocationIds));
		}
	}
	
	public function saveCashierSalesPerformanceData() {
		if(isset($this->data['OGM_Admin_Add_People_Permissions'])){
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$data = array(
					'people_id' => $this->db->escape_str($this->input->post('people_id')),
					'year' => $this->db->escape_str($this->input->post('sales_performance_year')),
					'month' => $this->db->escape_str($this->input->post('sales_performance_month')),
					'sales_target' => $this->db->escape_str($this->input->post('sales_target')),
					'last_action_status' => 'added'
				);

				$this->peoples_model->addCashierSalesPerformanceRecord($data);

				echo 'ok';
			}
		}
	}
	
	public function editCashierSalesPerformanceData() {
		if(isset($this->data['OGM_Admin_Edit_People_Permissions'])){
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$salesPerformanceId = $this->db->escape_str($this->input->post('sales_performance_id'));
				
				$data = array(
					'year' => $this->db->escape_str($this->input->post('sales_performance_year')),
					'month' => $this->db->escape_str($this->input->post('sales_performance_month')),
					'sales_target' => $this->db->escape_str($this->input->post('sales_target')),
					'last_action_status' => 'edited'
				);

				$this->peoples_model->editCashierSalesPerformanceRecord($salesPerformanceId, $data);

				echo 'ok';
			}
		}
	}

	public function check_existing($people_code) {

		$exist = false;
		$result = $this->peoples_model->checkExistingPeopleCode($people_code);
		$peopleID = $this->input->post('people_id');

		if ($peopleID != '' && $result) {
			if ($peopleID != $result[0]->people_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('People Code is already in use'));
			return false;
		} else {
			return true;
		}
	}

	//---------------------------------------------------------------------

	public function getAllToPeopleDropDown() {
		echo $this->peoples_model->getAllPeoplesToDropDown($type=null);
	}
	
	public function getAllToEmployeesDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllEmployeesDropDown($type=null, $checkAuthority);
	}
	
	public function getAllEmployeesDropDown($type, $checkAuthority) {
		return $this->peoples_model->getAllEmployeesToDropDown($type, $checkAuthority);
	}
	
	public function getAllToSuppliersDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllSuppliersDropDown($type=null, $checkAuthority);
	}

	public function getAllSuppliersDropDown($type, $checkAuthority, $disableSelection=null) {
		return $this->peoples_model->getAllSuppliersToDropDown($type, $checkAuthority, $disableSelection);
	}

	public function getAllToAgentsDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllAgentsDropDown($type=null, $checkAuthority);
	}

	public function getAllAgentsDropDown($type, $getWithAllOption, $checkAuthority, $disableSelection=null) {
		return $this->peoples_model->getAllAgentsToDropDown($type, $checkAuthority, $getWithAllOption, $disableSelection);
	}

	public function getAllToCustomersDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllCustomersDropDown("", $checkAuthority);
	}

	public function getAllCustomersDropDown($type, $checkAuthority=null, $getWithAllOption=null, $selectedIndex=null, $showPeopleCode=null, $disableSelection=null) {
		return $this->peoples_model->getAllCustomersToDropDown($type, $checkAuthority, $getWithAllOption, $selectedIndex, $showPeopleCode, $disableSelection);
	}
	
	public function getAllToCustomersDropDownWithCustomerCode() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllCustomersDropDownWithCustomerCode($checkAuthority);
	}
	
	public function getAllCustomersDropDownWithCustomerCode($checkAuthority) {
		return $this->peoples_model->getAllCustomersDropDownWithCustomerCode($checkAuthority);
	}
    
    public function getPOSSalesInvoiceCustomersDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->peoples_model->getPOSSalesInvoiceCustomersDropDown($checkAuthority);
	}
	
	public function getAllToPeopleDropDownWithPeopleCode() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllPeopleDropDownWithPeopleCode($checkAuthority);
	}
	
	public function getAllPeopleDropDownWithPeopleCode($checkAuthority) {
		return $this->peoples_model->getAllPeopleDropDownWithPeopleCode($checkAuthority);
	}

	public function getAllToSalesRepsDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllSalesRepsDropDown($type=null, $checkAuthority);
	}
    
    public function getAllToCashiersDropDown() {
		echo $this->getAllCashiersDropDown($type=null);
	}

	public function getAllSalesRepsDropDown($type, $checkAuthority, $disableSelection=null) {
		return $this->peoples_model->getAllSalesRepsToDropDown($type, $checkAuthority, $disableSelection);
	}
    
    public function getAllCashiersDropDown($type) {
        $checkAuthority = $this->input->post('check_authority');
		return $this->peoples_model->getAllCashiersToDropDown($type, $checkAuthority);
	}

	public function getAllToDriversDropDown() {
		$type = $this->db->escape_str($this->input->post('type'));
        $checkAuthority = $this->input->post('check_authority');
        
		echo $this->getAllDriversDropDown($type, $checkAuthority);
	}

	public function getAllDriversDropDown($type, $checkAuthority, $disableSelection=null) {
		return $this->peoples_model->getAllDriversToDropDown($type, $checkAuthority, $disableSelection);
	}

	public function getAllToEmployeeDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		echo $this->getAllEmployeeDropDown("", $checkAuthority);
	}

	public function getAllEmployeeDropDown($type, $checkAuthority, $disableSelection=null) {
		return $this->peoples_model->getAllEmployeeToDropDown($type, $checkAuthority, $disableSelection);
	}
	
	public function getAllToMembersDropDown() {
        $checkAuthority = $this->input->post('check_authority');
		$type = $this->db->escape_str($this->input->post('type', $checkAuthority));

		echo $this->getAllMembersDropDown($type, $checkAuthority);
	}

	public function getAllMembersDropDown($type, $checkAuthority, $disableSelection=null) {
		return $this->peoples_model->getAllMembersToDropDown($type, $checkAuthority, $disableSelection);
	}
	
	//---------------------------------------------------------------------

	public function getAgentSelectOptionSelectDropdownWithLabel($type, $mandatoryField, $labelColPosition, $dropDownColPosition, 
																$getWithAllOption, $disableSelection) {
		if ($type == "Add") {
			if ($mandatoryField == "Yes") {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='agent_dropdown'>";
					  $html .=      $this->getAllAgentsDropDown($type, $getWithAllOption, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";

				return $html;
			} else {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} </label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='agent_dropdown'>";
					  $html .=      $this->getAllAgentsDropDown($type, $getWithAllOption, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";

				return $html;
			}
		} else {
			if ($mandatoryField == "Yes") {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='agent_dropdown'>";
					  $html .=      $this->getAllAgentsDropDown($type, $getWithAllOption, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";

				return $html;
			} else {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} </label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='agent_dropdown'>";
					  $html .=      $this->getAllAgentsDropDown($type, $getWithAllOption, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";

				return $html;
			}
		}
	}

	public function getAgentSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition, $getWithAllOption, $disableSelection) {
		if ($type == "Add") {
			$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='agent_dropdown'>";
				  $html .=      $this->getAllAgentsDropDown($type, $getWithAllOption, "Yes", $disableSelection);
				  $html .= "</div>
							<div id='people_idError' class='red'></div>
						</div>";

			return $html;
		} else {
			$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='agent_dropdown'>";
				  $html .=      $this->getAllAgentsDropDown($type, $getWithAllOption, "Yes", $disableSelection);
				  $html .= "</div>
							<div id='people_id_editError' class='red'></div>
						</div>";

			return $html;
		}
	}

	public function getCustomerSelectOptionSelectDropdownWithLabel($type, $mandatoryField, $labelColPosition, $dropDownColPosition, 
																   $getWithAllOption, $selectedIndex=null, $showPeopleCode=null, $disableSelection=null) {
		if ($type == "Add") {
			if ($mandatoryField == "Yes") {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='customer_dropdown'>";
					  $html .=     $this->getAllCustomersDropDown($type, "Yes", $getWithAllOption, $selectedIndex, $showPeopleCode, $disableSelection);
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";

				return $html;
			} else {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} </label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='customer_dropdown'>";
					  $html .=     $this->getAllCustomersDropDown($type, "Yes", $getWithAllOption, $selectedIndex, $showPeopleCode, $disableSelection);
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";

				return $html;
			}
		} else {
			if ($mandatoryField == "Yes") {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='customer_dropdown'>";
					  $html .=     $this->getAllCustomersDropDown($type, "Yes", $getWithAllOption, $selectedIndex, $showPeopleCode, $disableSelection);
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";

				return $html;
			} else {
				$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} </label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='customer_dropdown'>";
					  $html .=     $this->getAllCustomersDropDown($type, "Yes", $getWithAllOption, $selectedIndex, $showPeopleCode, $disableSelection);
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";

				return $html;
			}
		}
	}

	public function getCustomerSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition, $getWithAllOption, $showPeopleCode, 
            $disableSelection) {
		if ($type == "Add") {
			$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='customer_dropdown'>";
				  $html .=     $this->getAllCustomersDropDown($type, "Yes", $getWithAllOption, "", $showPeopleCode, $disableSelection);
				  $html .= "</div>
							<div id='people_idError' class='red'></div>
						</div>";

			return $html;
		} else {
			$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='customer_dropdown'>";
				  $html .=     $this->getAllCustomersDropDown($type, "Yes", $getWithAllOption, "", $showPeopleCode, $disableSelection);
				  $html .= "</div>
							<div id='people_id_editError' class='red'></div>
						</div>";

			return $html;
		}
	}

	public function getAgentCustomerSelectOptionSelectDropdownWithLabel($categoryType, $category, $type, $mandatoryField, $labelColPosition, 
																		$dropDownColPosition, $getWithAllOption) {
		if ($categoryType == "Agent") {
			$dropdown =  $this->peoples_model->getAllAgentsByCategoriesToDropDown($category, $type, $getWithAllOption, "Yes");

			if ($type == "Add") {
				if ($mandatoryField == "Yes") {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} *</label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='agent_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_idError' class='red'></div>
								</div>";

					return $html;
				} else {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} </label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='agent_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_idError' class='red'></div>
								</div>";

					return $html;
				}
			} else {
				if ($mandatoryField == "Yes") {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} *</label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='agent_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_id_editError' class='red'></div>
								</div>";

					return $html;
				} else {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Agent')} </label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='agent_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_id_editError' class='red'></div>
								</div>";

					return $html;
				}
			}
		} else if ($categoryType == "Customer") {
			$dropdown =  $this->peoples_model->getAllCustomersByCategoriesToDropDown($category, $type, $getWithAllOption, "Yes");

			if ($type == "Add") {
				if ($mandatoryField == "Yes") {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} *</label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='customer_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_idError' class='red'></div>
								</div>";

					return $html;
				} else {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} </label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='customer_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_idError' class='red'></div>
								</div>";

					return $html;
				}
			} else {
				if ($mandatoryField == "Yes") {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} *</label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='customer_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_id_editError' class='red'></div>
								</div>";

					return $html;
				} else {
					$html = "   <label class='control-label col-sm-{$labelColPosition}' id='people_select_label'>{$this->lang->line('Customer')} </label>
								<div class='col-sm-{$dropDownColPosition} controls'>
									<div id='customer_dropdown'>";
						  $html .=     $dropdown;
						  $html .= "</div>
									<div id='people_id_editError' class='red'></div>
								</div>";

					return $html;
				}
			}
		}
	}

	public function getAgentCustomerSelectOptionSelectDropdownWithoutLabel($categoryType, $category, $type, 
																		   $dropDownColPosition, $getWithAllOption) {
		if ($categoryType == "Agent") {
			$dropdown =  $this->peoples_model->getAllAgentsByCategoriesToDropDown($category, $type, $getWithAllOption, "Yes");

			if ($type == "Add") {
				$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
								<div id='agent_dropdown'>";
					  $html .=     $dropdown;
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
							</div>";

				return $html;
			} else {
				$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
								<div id='agent_dropdown'>";
					  $html .=     $dropdown;
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";

				return $html;
			}
		} else if ($categoryType == "Customer") {
			$dropdown =  $this->peoples_model->getAllCustomersByCategoriesToDropDown($category, $type, $getWithAllOption, "Yes");

			if ($type == "Add") {
				$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
								<div id='customer_dropdown'>";
					  $html .=     $dropdown;
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
							</div>";

				return $html;
			} else {
				$html = "   <div class='col-sm-{$dropDownColPosition} controls'>
								<div id='customer_dropdown'>";
					  $html .=     $dropdown;
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";

				return $html;
			}
		}
	}

	public function getSupplierSelectOptionSelectDropdownWithLabel($type, $labelColPosition=null, $dropDownColPosition=null, $disableSelection=null) {
		if ($type == "Add") {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Supplier')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='supplier_dropdown'>";
					  $html .=     $this->getAllSuppliersDropDown($type, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Supplier')} *</label>
							<div class='col-sm-4 controls'>
								<div id='supplier_dropdown'>";
					  $html .=     $this->getAllSuppliersDropDown($type, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_idError' class='red'></div>
							</div>";
			}

			return $html;
		} else {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Supplier')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='supplier_dropdown'>";
					  $html .=     $this->getAllSuppliersDropDown($type, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Supplier')} *</label>
							<div class='col-sm-4 controls'>
								<div id='supplier_dropdown'>";
					  $html .=     $this->getAllSuppliersDropDown($type, "Yes", $disableSelection);
					  $html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";
			}

			return $html;
		}
	}
	
	public function getSupplierSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition=null, $disableSelection=null) {
		if ($type == "Add") {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='supplier_dropdown'>";
				  $html .=     $this->getAllSuppliersDropDown($type, "Yes", $disableSelection);
				  $html .= "</div>
							<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='supplier_dropdown'>";
				  $html .=     $this->getAllSuppliersDropDown($type, "Yes", $disableSelection);
				  $html .= "</div>
							<div id='people_idError' class='red'></div>
						</div>";
			}

			return $html;
		} else {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='supplier_dropdown'>";
				  $html .=     $this->getAllSuppliersDropDown($type, "Yes");
				  $html .= "</div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='supplier_dropdown'>";
				  $html .=     $this->getAllSuppliersDropDown($type, "Yes");
				  $html .= "</div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			}

			return $html;
		}
	}

	public function getEmployeeSelectOptionSelectDropdownWithLabel($type, $labelColPosition=null, $dropDownColPosition=null, $disableSelection=null){
		if ($type == "Add") {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Employee')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Employee')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
							</div>";
			}

			return $html;
		} else {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Employee')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Employee')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";
			}

			return $html;
		}
	}
	
	public function getEmployeeSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition=null, $disableSelection=null){
		if ($type == "Add") {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
			$html .= "</div>
							<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
			$html .= "</div>
							<div id='people_idError' class='red'></div>
						</div>";
			}

			return $html;
		} else {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllEmployeeDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			}

			return $html;
		}
	}
	
	public function getSalesRepSelectOptionSelectDropdownWithLabel($type, $labelColPosition=null, $dropDownColPosition=null, 
            $disableSelection=null){
		if ($type == "Add") {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Sales Rep')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Sales Rep')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
							</div>";
			}

			return $html;
		} else {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Sales Rep')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Sales Rep')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";
			}

			return $html;
		}
	}
	
	public function getSalesRepSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition=null, $disableSelection=null){
		if ($type == "Add") {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_idError' class='red'></div>
						</div>";
			}

			return $html;
		} else {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllSalesRepsDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			}

			return $html;
		}
	}
	
	public function getDriversSelectOptionSelectDropdownWithLabel($type, $labelColPosition=null, $dropDownColPosition=null,
             $disableSelection=null){
		if ($type == "Add") {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Driver')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Driver')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
							</div>";
			}

			return $html;
		} else {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Driver')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Driver')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";
			}

			return $html;
		}
	}
	
	public function getDriversSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition=null, $disableSelection=null){
		if ($type == "Add") {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_idError' class='red'></div>
						</div>";
			}

			return $html;
		} else {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllDriversDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			}

			return $html;
		}
	}
	
	public function getMembersSelectOptionSelectDropdownWithLabel($type, $labelColPosition=null, $dropDownColPosition=null
            , $disableSelection=null){
		if ($type == "Add") {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Member')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Member')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_idError' class='red'></div>
							</div>";
			}

			return $html;
		} else {
			if ($labelColPosition != '' && $dropDownColPosition != '') {
				$html = "   <label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Member')} *</label>
							<div class='col-sm-{$dropDownColPosition} controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "   <label class='control-label col-sm-3'>{$this->lang->line('Member')} *</label>
							<div class='col-sm-4 controls'>
								<div id='employee_dropdown'>";
				$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
				$html .= "</div>
								<div id='people_id_editError' class='red'></div>
							</div>";
			}

			return $html;
		}
	}
	
	public function getMembersSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition=null, $disableSelection=null){
		if ($type == "Add") {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_idError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_idError' class='red'></div>
						</div>";
			}

			return $html;
		} else {
			if ($dropDownColPosition != '') {
				$html = "  <div class='col-sm-{$dropDownColPosition} controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			} else {
				$html = "  <div class='col-sm-4 controls'>
							<div id='employee_dropdown'>";
			$html .=     $this->getAllMembersDropDown($type, "Yes", $disableSelection);
			$html .= "                   </div>
							<div id='people_id_editError' class='red'></div>
						</div>";
			}

			return $html;
		}
	}

	public function getTableData(){
		if(isset($this->data['OGM_Admin_View_People_Permissions'])){
            
            $peopleAdditionAuthorizationFeatureEnabled = $this->system_configurations_model->isPeopleAdditionAuthorizationFeatureEnabled();
            
			$peopleType = $this->db->escape_str($this->input->post('people_type'));
			$html = "";
			$html .="<p class='text-info'><strong>$peopleType {$this->lang->line('List')}</strong>
				<div class='box-content box-no-padding out-table'>
									<div class='table-responsive table_data'>
										<div class='scrollable-area1'>
											<table class='table table-striped table-bordered'
												   style='margin-bottom:0;'>
												<thead>";
									//------export button
									if ($this->export==true) {
										$html .= "
													<div class='export_btn'>
														Export to
														<button type='button' class='btn btn-default btn-xs' title='Excel' onclick='exportToExcel();'>
															<i class='icon-windows'></i>
														</button>
														<button type='button' class='btn btn-default btn-xs' title='PDF' onclick='exportToPdf();'>
															<i class='icon-qrcode '></i>
														</button>
													</div>";
									}
									//-------end export
										$html.="<tr>
													<th>{$this->lang->line('People Code') }</th>
													<th>{$this->lang->line('People Name') }</th>
													<th>{$this->lang->line('Primary Phone No') }</th>
													<th>{$this->lang->line('E-mail') }</th>";

									if ($peopleType == "Agent" || $peopleType == "Customer") {
										$html.="    <th>{$this->lang->line('Location') }</th>";
									}

										$html.="    <th>{$this->lang->line('People Type') }</th>";

                                    if ($peopleAdditionAuthorizationFeatureEnabled) {
                                        $html.="    <th>{$this->lang->line('Status') }</th>";
                                    }

										$html.="    <th>{$this->lang->line('Actions')}</th>
												</tr>
												</thead>
												<tbody>";
                                        
			$people = $this->peoples_model->getAll('people_name', 'asc', $peopleType);
            
            $authorizerLogin = false;
            $peopleAdditionAuthorizerId = $this->system_configurations_model->getCurrentPeopleAdditionAuthorizerData();
            $user = $this->user_model->getUserByPeopleId($peopleAdditionAuthorizerId);
            
            if ($user && sizeof($user) > 0) {
                if ($user[0]->user_id == $this->user_id) {
                    $authorizerLogin = true;
                }
            }
                
			if ($people != null) {
				foreach ($people as $row) {
					$html .= "<tr>";
					$html .= "<td>" . $row->people_code . "</td>";
					$html .= "<td>" . $row->people_name . "</td>";
					$html .= "<td>" . $row->people_ptn_country_code . " " . $row->people_primary_telephone_number . "</td>";
					$html .= "<td>" . $row->people_email . "</td>";

					if ($peopleType == "Agent" || $peopleType == "Customer") {
						if ($row->location_id != 0) {
							$location = $this->locations_model->getById($row->location_id);
							$html .= "<td>" . $location[0]->location_name . "</td>";
						} else {
							$html .= "<td></td>";
						}
					}

					$html .= "<td>" . $row->people_type . "</td>";

                    if ($peopleAdditionAuthorizationFeatureEnabled && $row->authorized == "No") {
                        $html .= "<td>{$this->lang->line('Authorization Pending')}</td>";
                    } else if ($peopleAdditionAuthorizationFeatureEnabled) {
                        $html .= "<td></td>";
                    }

					$html .= "<td><div class='text-left'>";
					if(isset($this->data['OGM_Admin_Edit_People_Permissions']))
						$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->people_id}' title='Edit' onclick='get($row->people_id);'>
									<i class='icon-wrench'></i>
								</a> ";
					if(isset($this->data['OGM_Admin_Delete_People_Permissions']))
						$html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->people_id}' title='Delete'>
									<i class='icon-remove' onclick='del($row->people_id);'></i>
								</a> ";
                                
                    if ($peopleAdditionAuthorizationFeatureEnabled && $authorizerLogin && $row->authorized == "No") {
                        $html.="<a class='btn btn-info btn-xs delete' data-id='{$row->people_id}' title='Authorize'>
									<i class='icon-check' onclick='authorize($row->people_id, /$peopleType/);'></i>
								</a> ";
                    }
                    
					$html .= "</div></td>
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
	
	public function getCashierSalesPerformanceList() {
		$peopleId = $this->db->escape_str($this->input->post('people_id'));
		
		//First update current month sales performance
		$currentMonthFromDate = date("Y") . "-" . date("m") . "-01";
		$currentMonthToDate = date("Y-m-d");
		
		$this->common_functions->processCashierMonthlySalesPerformance($peopleId, date("Y"), date("m"), $currentMonthFromDate, $currentMonthToDate);

		$cashierSalesPerformanceList = $this->peoples_model->getCashierSalesPerformanceListByPeopleId($peopleId);
		
		$monthArray = array(
			"1" => "January", "2" => "February", "3" => "March", "4" => "April",
			"5" => "May", "6" => "June", "7" => "July", "8" => "August",
			"9" => "September", "10" => "October", "11" => "November", "12" => "December",
		);

		$html = "";
		$html .= "  <div class='box-content box-no-padding out-table'>
						<div class='table-responsive table_data'>
							<div class='scrollable-area1'>
								<table class='table table-striped table-bordered cashierSalesPerformanceTable' style='margin-bottom:0;'>
									<thead>
										<tr>
											<th>{$this->lang->line('Year')}</th>
											<th>{$this->lang->line('Month')}</th>
											<th>{$this->lang->line('Sales Target')}</th>
											<th>{$this->lang->line('Sales Achivement')}</th>
											<th>{$this->lang->line('Achivement (%)')}</th>
											<th>{$this->lang->line('Actions')}</th>
										</tr>
									</thead>
									<tbody>";

		if ($cashierSalesPerformanceList && sizeof($cashierSalesPerformanceList) > 0) {
			foreach ($cashierSalesPerformanceList as $cashierSalesPerformance) {
				 $html .= "             <tr>";
						$html .= "          <td>" . $cashierSalesPerformance->year . "</td>";
						$html .= "          <td>" . $monthArray[$cashierSalesPerformance->month] . "</td>";
						$html .= "          <td>" . number_format($cashierSalesPerformance->sales_target, 2) . "</td>";
						$html .= "          <td>" . number_format($cashierSalesPerformance->sales_achivement, 2) . "</td>";
						$html .= "          <td>" . number_format($cashierSalesPerformance->sales_achivement_percentage, 2) . "</td>";
						$html .= "          <td>
												<div class='text-left'>";
						if(isset($this->data['OGM_Admin_Edit_People_Permissions'])) {
							$html.="            <a class='btn btn-warning btn-xs get' data-id='{$cashierSalesPerformance->sales_performance_id}'
													title='{$this->lang->line('Edit')}' onclick='getCashierSalesPerformanceData($cashierSalesPerformance->sales_performance_id);'>
													<i class='icon-wrench'></i>
												</a>";
						}

							$html.="            </div>
										   </td>";
						$html .= "      </tr>";
			}
		}

		$html .= "                  </tbody>
								</table>
							</div>
						</div>
					</div>";

		echo $html;
	}
	
	public function getCashierSalesPerformanceData() {
		$salesPerformanceId = $this->db->escape_str($this->input->post('sales_performance_id'));

		$cashierSalesPerformance = $this->peoples_model->getCashierSalesPerformanceById($salesPerformanceId);

		$date = '';
		$amount = '';
		if ($cashierSalesPerformance && sizeof($cashierSalesPerformance) > 0) {
			$year = $cashierSalesPerformance[0]->year;
			$month = $cashierSalesPerformance[0]->month;
			$salesTarget = str_replace(",", "", number_format($cashierSalesPerformance[0]->sales_target, 2));
		}

		echo json_encode(array('result' => "ok", 'year' => $year, 'month' => $month, 'salesTarget' => $salesTarget));
	}

	public function getAllIssuedToReturnedByOptionsToDropDown() {
		$type = $this->db->escape_str($this->input->post('type'));
		$transactionType = $this->db->escape_str($this->input->post('transaction_type'));

		$showOnlyCustomerListWithCategories = '';
		$showOnlyCustomerListWithoutCategories = '';
		
		$selectedIndexOfIssueCategory = '';
		$selectedIndexOfIssueAgentOrCustomer = '';

		if ($transactionType == "FGGIN") {
			$showOnlyCustomerListWithCategories = $this->system_configurations_model->isFGGINShowOnlyCustomerListWithCategoriesEnabled();
			$showOnlyCustomerListWithoutCategories = $this->system_configurations_model->isFGGINShowOnlyCustomerListWithoutCategoriesEnabled();
		} else if ($transactionType == "FGGRTN") {
			$showOnlyCustomerListWithCategories = $this->system_configurations_model->isFGGRTNShowOnlyCustomerListWithCategoriesEnabled();
			$showOnlyCustomerListWithoutCategories = $this->system_configurations_model->isFGGRTNShowOnlyCustomerListWithoutCategoriesEnabled();
		} else if ($transactionType == "RMGIN") {
			$showOnlyCustomerListWithCategories = $this->system_configurations_model->isRMGINShowOnlyCustomerListWithCategoriesEnabled();
			$showOnlyCustomerListWithoutCategories = $this->system_configurations_model->isRMGINShowOnlyCustomerListWithoutCategoriesEnabled();
		} else if ($transactionType == "RMGRTN") {
			$showOnlyCustomerListWithCategories = $this->system_configurations_model->isRMGRTNShowOnlyCustomerListWithCategoriesEnabled();
			$showOnlyCustomerListWithoutCategories = $this->system_configurations_model->isRMGRTNShowOnlyCustomerListWithoutCategoriesEnabled();
		} else if ($transactionType == "SalesINV") {
			$showOnlyCustomerListWithCategories = $this->system_configurations_model->isSalesINVShowOnlyCustomerListWithCategoriesEnabled();
			$showOnlyCustomerListWithoutCategories = $this->system_configurations_model->isSalesINVShowOnlyCustomerListWithoutCategoriesEnabled();
			$selectedIndexOfIssueCategory = $this->system_configurations_model->getDefaultSalesInvoiceIssueCategory();
			
			if ($showOnlyCustomerListWithoutCategories) {
				$selectedIndexOfIssueAgentOrCustomer = $this->system_configurations_model->getDefaultSalesInvoiceIssueCustomer();
			}
				
		} else if ($transactionType == "SalesRTN") {
			$showOnlyCustomerListWithCategories = $this->system_configurations_model->isSalesRTNShowOnlyCustomerListWithCategoriesEnabled();
			$showOnlyCustomerListWithoutCategories = $this->system_configurations_model->isSalesRTNShowOnlyCustomerListWithoutCategoriesEnabled();
		}

		if ($showOnlyCustomerListWithoutCategories) {
			if ($transactionType == "SalesINV") {
				$this->handleGoodIssueReturnTypeChange("Customer", $selectedIndexOfIssueAgentOrCustomer, $type, true, 5, 7, "Yes");
			} else if ($transactionType == "SalesRTN") {
				$this->handleGoodIssueReturnTypeChange("Customer", $selectedIndexOfIssueAgentOrCustomer, $type, true, 4, 8, "Yes");
			} else {
				$this->handleGoodIssueReturnTypeChange("Customer", $selectedIndexOfIssueAgentOrCustomer, $type, true, 3, 4, "Yes");
			}
		} else {
			echo $this->common_functions->getAllIssuedToOptionsToDropDown($type, $selectedIndexOfIssueCategory, null, $showOnlyCustomerListWithCategories);
		}
	}

	public function getAllAgentCustomerCategoryOptionsToDropDown() {
		$type = $this->db->escape_str($this->input->post('type'));
		echo $this->common_functions->getAllAgentCustomerCategoryOptionsToDropDown($type);
	}
    
	public function handleGoodIssueReturnTypeChange($selectedOption=null, $selectedIndex=null, $type=null, $showLabel=null, $labelColPosition=null,
													$dropDownColPosition=null, $mandatoryField=null, $getWithAllOption=null) {
		if ($selectedOption == '') {
			$selectedOption = $this->db->escape_str($this->input->post('option'));
			$selectedIndex = '';
			$type = $this->db->escape_str($this->input->post('type'));
			$showLabel = $this->db->escape_str($this->input->post('show_label'));
			$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
			$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));
			$mandatoryField = $this->db->escape_str($this->input->post('mandatory_field'));
			$getWithAllOption = $this->db->escape_str($this->input->post('get_with_all_option'));
		}

		$result = '';
		if ($selectedOption == "Agent") {
			if ($showLabel == 'true') { 
				$result = $this->getAgentSelectOptionSelectDropdownWithLabel($type, $mandatoryField, $labelColPosition, $dropDownColPosition, 
																			 $getWithAllOption);
			} else {
				$result = $this->getAgentSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition, $getWithAllOption);
			}
		} else if($selectedOption == "Customer") {
			if ($showLabel == 'true') {
				$result = $this->getCustomerSelectOptionSelectDropdownWithLabel($type, $mandatoryField, $labelColPosition, $dropDownColPosition, 
																				$getWithAllOption, $selectedIndex);
			} else {
				$result = $this->getCustomerSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition, $getWithAllOption, false);
			}
		}

		if ($selectedOption != "Agent" && $selectedOption != "Customer") {
			$data = explode("-", $selectedOption);
			if (sizeof($data) > 1) {
				if ($showLabel == 'true') {
					$result = $this->getAgentCustomerSelectOptionSelectDropdownWithLabel(trim($data[0]), trim($data[1]), $type, $mandatoryField, 
																					$labelColPosition, $dropDownColPosition, $getWithAllOption);
				} else {
					$result = $this->getAgentCustomerSelectOptionSelectDropdownWithoutLabel(trim($data[0]), trim($data[1]), $type, 
																					   $dropDownColPosition);
				}
			}
		}

		echo $result;
	}

	public function handleGoodIssueReturnTypeChangeOnSalesInvoice() {
		$selectedOption = $this->db->escape_str($this->input->post('option'));
		$type = $this->db->escape_str($this->input->post('type'));
		$showLabel = $this->db->escape_str($this->input->post('show_label'));
		$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
		$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));
		$mandatoryField = $this->db->escape_str($this->input->post('mandatory_field'));
		$getWithAllOption = $this->db->escape_str($this->input->post('get_with_all_option'));

		$result = '';
		if ($selectedOption == "Agent") {
			if ($showLabel == 'true') { 
				$result = $this->getAgentSelectOptionSelectDropdownWithLabel($type, $mandatoryField, $labelColPosition, $dropDownColPosition, 
																			 $getWithAllOption);
			} else {
				$result = $this->getAgentSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition, $getWithAllOption);
			}
		} else if($selectedOption == "Customer") {
			if ($showLabel == 'true') {
				$result = $this->getCustomerSelectOptionSelectDropdownWithLabel($type, $mandatoryField, $labelColPosition, $dropDownColPosition, 
																				$getWithAllOption);
			} else {
				$result = $this->getCustomerSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition, $getWithAllOption, false);
			}
		}

		if ($selectedOption != "Agent" && $selectedOption != "Customer") {
			$data = explode("-", $selectedOption);
			if (sizeof($data) > 1) {
				if ($showLabel == 'true') {
					$result = $this->getAgentCustomerSelectOptionSelectDropdownWithLabel(trim($data[0]), trim($data[1]), $type, $mandatoryField, 
														$labelColPosition, $dropDownColPosition, $getWithAllOption);
				} else {
					$result = $this->getAgentCustomerSelectOptionSelectDropdownWithoutLabel(trim($data[0]), trim($data[1]), $type, 
																		   $dropDownColPosition, $getWithAllOption);
				}
			}
		}

		echo $result;
	}
	
	public function getCustomerCategoryListDropDown($type=null, $selectedIndex=null, $disabled=null) {

		if ($type == '') {
			$type = $this->db->escape_str($this->input->post('type'));
			$selectedIndex = '0';
			$disabled = false;
		}

		echo $this->common_functions->getAllIssuedToOptionsToDropDown($type, $selectedIndex, $disabled, true, false);
	}
	
	public function getPeopleListAccordingToTheCategory() {
		$peopleCategory = $this->db->escape_str($this->input->post('people_category'));
		$type = $this->db->escape_str($this->input->post('type'));
		$mandatoryField = $this->db->escape_str($this->input->post('mandatory_field'));
		$getWithAllOption = $this->db->escape_str($this->input->post('get_with_all_option'));
		$getWithLabel = $this->db->escape_str($this->input->post('get_with_label'));
		$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
		$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));
		$showPeopleCode = $this->db->escape_str($this->input->post('show_people_code'));
        $disableSelection = $this->db->escape_str($this->input->post('disable_selection'));
		
		$peopleListDropdown = '';
		
		switch ($peopleCategory) {
			case "Agent" :

				if ($getWithLabel == "Yes") {
					$peopleListDropdown = $this->getAgentSelectOptionSelectDropdownWithLabel($type, $mandatoryField, $labelColPosition, 
                            $dropDownColPosition, $getWithAllOption, $disableSelection);
				} else {
					$peopleListDropdown = $this->getAgentSelectOptionSelectDropdownWithoutLabel($type, $dropDownColPosition, 
                            $getWithAllOption, $disableSelection);
				}

				break;

			case "Supplier" :

				if ($getWithLabel == "Yes") {
					$peopleListDropdown = $this->getSupplierSelectOptionSelectDropdownWithLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				} else {
					$peopleListDropdown = $this->getSupplierSelectOptionSelectDropdownWithoutLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				}

				break;
			
			case "Employee" :

				if ($getWithLabel == "Yes") {
					$peopleListDropdown = $this->getEmployeeSelectOptionSelectDropdownWithLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				} else {
					$peopleListDropdown = $this->getEmployeeSelectOptionSelectDropdownWithoutLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				}

				break;
			
			case "Sales Rep" :

				if ($getWithLabel == "Yes") {
					$peopleListDropdown = $this->getSalesRepSelectOptionSelectDropdownWithLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				} else {
					$peopleListDropdown = $this->getSalesRepSelectOptionSelectDropdownWithoutLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				}

				break;
			
			case "Customer" :

				if ($getWithLabel == "Yes") {
					$peopleListDropdown = $this->getCustomerSelectOptionSelectDropdownWithLabel($type, $mandatoryField, 
                            $labelColPosition, $dropDownColPosition, $getWithAllOption, '', $showPeopleCode, $disableSelection);
				} else {
					$peopleListDropdown = $this->getCustomerSelectOptionSelectDropdownWithoutLabel($type, $mandatoryField, 
                            $getWithAllOption, $showPeopleCode, $disableSelection);
				}

				break;
			
			case "Driver" :

				if ($getWithLabel == "Yes") {
					$peopleListDropdown = $this->getDriversSelectOptionSelectDropdownWithLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				} else {
					$peopleListDropdown = $this->getDriversSelectOptionSelectDropdownWithoutLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				}

				break;
			
			case "Member" :

				if ($getWithLabel == "Yes") {
					$peopleListDropdown = $this->getMembersSelectOptionSelectDropdownWithLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				} else {
					$peopleListDropdown = $this->getMembersSelectOptionSelectDropdownWithoutLabel($type, $labelColPosition, 
                            $dropDownColPosition, $disableSelection);
				}

				break;
		}
		
		echo $peopleListDropdown;
	}
	
	public function getAllEmployeesAndMembersToDropDown() {
		echo $this->peoples_model->getAllEmployeesAndMembersToDropDown("Add");
	}
	
	public function uploadDocument() {
		$status = "";
		$msg = "";
		$fileElementName = 'file_to_upload';
		$fileName = $this->db->escape_str($this->input->post('file_name'));
		$peopleId = $this->db->escape_str($this->input->post('people_id'));
		$uploadFileName = $peopleId . "_document_" . $fileName;

		$config['upload_path'] = 'fileUploads/peopleDocuments';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
		$config['max_size'] = 1024 * 8;
		$config['encrypt_name'] = FALSE;
		$config['file_name'] = $uploadFileName;
		$config['overwrite'] = 'TRUE';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($fileElementName)) {
			$status = 'error';
			$msg = $this->upload->display_errors('', '');
			$documentPath = '';
		} else {
			$data = $this->upload->data();
			move_uploaded_file('fileUploads/peopleDocuments' . $fileElementName, 'fileUploads/peopleDocuments' . $uploadFileName);
			$file_id = $this->files_model->insertPeopleDocument($peopleId, $data['file_name']);
			if($file_id) {
				$status = "success";
				$msg = "Document successfully uploaded";
				$documentPath = $data['file_name'];
			} else {
				unlink($data['full_path']);
				$status = "error";
				$msg = "Something went wrong when uploading the document, please try again.";
				$documentPath = '';
			}
		}
		@unlink($_FILES[$fileElementName]);

		echo json_encode(array('response' => $status, 'msg' => $msg, 'imagePath' => $documentPath));
	}
	
	public function getPeopleDocuments() {
		$peopleId = $this->db->escape_str($this->input->post('people_id'));
		
		$peopleDocuments = $this->files_model->getPeopleDocuments($peopleId);
		
		$html = '';
		if ($peopleDocuments && sizeof($peopleDocuments) > 0) {
			foreach ($peopleDocuments as $peopleDocument) {
				$documentId = $peopleDocument->id;
				$peopleId = $peopleDocument->people_id;
				$length = strlen($peopleId) + 10;
				$fileName = substr($peopleDocument->file_name, $length);
				$filePath = base_url() . "/fileUploads/peopleDocuments/" . $peopleDocument->file_name;
				$html .= "<div class='form-group' id='people_document_" . $documentId . "'>
							<div class='col-sm-12 controls'>
								<label class='control-label col-sm-7'><a href = '" . $filePath . "' download>" . $fileName . "</a></label>
								<div class='col-sm-2 controls'>
									<button class='btn btn-success' type='button' id='delete_docement_" . $documentId . "'
										onclick='deleteDocument(this.id)'>
										<i class='icon-save'></i>
										{$this->lang->line('Delete')}
									</button>
								</div>
							</div>
						</div>";
			}
		}
		
		echo $html;
	}
	
	public function deleteDocument() {
		$documentId = $this->db->escape_str($this->input->post('document_id'));
		
		$this->files_model->deletePeopleDocument($documentId);
		
		echo 'ok';
	}
	
	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
    
    public function getLastPeopleCode() {
        $peopleType = $this->db->escape_str($this->input->post('people_type'));
        
        $peopleCode = $this->peoples_model->getLastPeopleForPeopleType($peopleType);
		
		echo "Last People Code : " . $peopleCode;
    }
    
    public function authorize() {
        $peopleId = $this->db->escape_str($this->input->post('people_id'));
        
        $data = array(
            'authorized' => "Yes",
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->peoples_model->edit($peopleId, $data);
        
        echo 'ok';
    }
}