<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations_controller extends CI_Controller {
	
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
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/organizationSection/company_structure_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);

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
		$data_cls['li_class_locations'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$data['locations'] = $this->locations_model->getAll('location_name', 'asc');

		if (isset($this->data['OGM_Admin_View_Locations_Permissions'])) {
			$this->load->view('web/organizationManagerModule/adminSection/locations/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}


	public function getCountryDropDown() {
		$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
		$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));
		
		$data['country'] = $this->common_model->getCountryList('name', 'ase');
		
		$html = "<div class='form-group'>
					<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Country')} </label>
					<div class='col-sm-{$dropDownColPosition} controls'>
						<select class='form-control' id='country'>
							<option value=''>" . $this->lang->line('-- Select Country --') . "</option>";
							foreach ($data['country'] as $row) {
								$html .= "<option value='{$row->country_code}'>{$row->country_name}</option>";
							}
		$html .= "      </select>
						<div id='countryError' class='red'></div>
					</div>
				</div>";

		echo $html;
	}
	
	public function getCountryDropDownWithoutLabel() {
		$data['country'] = $this->common_model->getCountryList('name', 'ase');
		
		$html = "	<select class='form-control' id='country'>
						<option value=''>" . $this->lang->line('-- Select Country --') . "</option>";
						foreach ($data['country'] as $row) {
							$html .= "<option value='{$row->country_code}'>{$row->country_name}</option>";
						}
		$html .= "      </select>";

		echo $html;
	}


	public function add() {
		if (isset($this->data['OGM_Admin_Add_Locations_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$primaryTPNumberCombined =  $this->input->post('primary_telephone_number');
				$tpArray = explode(' ', $primaryTPNumberCombined);
				$primaryTPNumberCountryCode = $tpArray[0];
				$primaryTPNumber = '';
				if (sizeof($tpArray) > 1) {
					$primaryTPNumber = $tpArray[1];
				}
				$secondaryTPNumberCombined = $this->input->post('secendary_telephone_number');
				$tpArray = explode(' ', $secondaryTPNumberCombined);
				$secondaryTPNumberCountryCode = $tpArray[0];
				$secondaryTPNumber = '';
				if (sizeof($tpArray) > 1) {
					$secondaryTPNumber = $tpArray[1];
				}

				$address = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('address')));

				$data = array(
					'location_code' => $this->db->escape_str($this->input->post('location_code')),
					'location_name' => $this->db->escape_str($this->input->post('location_name')),
					'company_id' => $this->db->escape_str($this->input->post('company_id')),
					'address' => $address,
					'city' => $this->db->escape_str($this->input->post('city')),
					'state' => $this->db->escape_str($this->input->post('state')),
					'country_id' => $this->db->escape_str($this->input->post('country_id')),
					'time_zone' => $this->db->escape_str($this->input->post('time_zone')),
					'ptn_country_code' => $primaryTPNumberCountryCode,
					'primary_telephone_number' => $primaryTPNumber,
					'stn_country_code' => $secondaryTPNumberCountryCode,
					'secondary_telephone_number' => $secondaryTPNumber,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->locations_model->add($data);
				echo "ok";
			}
		}
	}

	public function edit() {
		if (isset($this->data['OGM_Admin_Edit_Locations_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$id = $this->db->escape_str($this->input->post('location_id'));

				$primaryTPNumberCombined =  $this->input->post('primary_telephone_number');
				$tpArray = explode(' ', $primaryTPNumberCombined);
				$primaryTPNumberCountryCode = $tpArray[0];
				$primaryTPNumber = $primaryTPNumberCountryCode;
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

				$address = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('address')));

				$data = array(
					'location_code' => $this->db->escape_str($this->input->post('location_code')),
					'location_name' => $this->db->escape_str($this->input->post('location_name')),
					'company_id' => $this->db->escape_str($this->input->post('company_id')),
					'country_id' => $this->db->escape_str($this->input->post('country_id')),
					'time_zone' => $this->db->escape_str($this->input->post('time_zone')),
					'state' => $this->db->escape_str($this->input->post('state')),
					'city' => $this->db->escape_str($this->input->post('city')),
					'address' => $address,
					'ptn_country_code' => $primaryTPNumberCountryCode,
					'primary_telephone_number' => $primaryTPNumber,
					'stn_country_code' => $secondaryTPNumberCountryCode,
					'secondary_telephone_number' => $secondaryTPNumber,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				$this->locations_model->edit($id, $data);
				echo "ok";
			}
		}
	}

	public function delete() {
		if (isset($this->data['OGM_Admin_Delete_Locations_Permissions'])) {
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->locations_model->delete($id, $status,$this->user_id)) {
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
		if (isset($this->data['OGM_Admin_Edit_Locations_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$data['location'] = $this->locations_model->getById($id);
			
			$language = $this->userManagement->getUserLanguage($this->user_id);
		
			$menuFormatting = '';
			if ($language == "sinhala") {
				$menuFormatting = 'style="font-weight: bold;"';
			}
		
			$html = "";
			if ($data['location'] != null) {
				foreach ($data['location'] as $row) {
					$html .= "<form class='form form-horizontal validate-form save_form'>
							<input class='form-control'  data-rule-required='true' id='location_id' name='location_id' type='hidden' value='{$row->location_id}'>

							<div class='form-group'>
							   <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Location Code')} *</label>
							   <div class='col-sm-4 controls'>
									<input class='form-control' id='location_code_edit' name='location_code_edit' placeholder='{$this->lang->line('Location Code')}' type='text'
													   value='{$row->location_code}'>
								<div id='location_code_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
							   <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Location Name')} *</label>
							   <div class='col-sm-4 controls'>
									<input class='form-control' id='location_name_edit' name='location_name_edit' placeholder='{$this->lang->line('Location Name')}' type='text'
													   value='{$row->location_name}'>
								<div id='location_name_editError' class='red'></div>
								</div>
							</div>";

							$company= $this->company_structure_model->getAllToCompanyDropDownWithSavedOption($row->company_id);
					$html .="<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Company')}</label>
								<div class='col-sm-4 controls'>
									<select class='form-control' id='company_edit'>
									  {$company}
									</select>
									<div id='company_editError' class='red'></div>
								</div>
							</div>";

					$address = preg_replace('~\\\r\\\n~',"<br>", $row->address);
					$address = str_ireplace("<br>", "\r\n", $address);

					$html .="<div class='form-group'>
							<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Address')} </label>
								<div class='col-sm-4 controls'>
									<textarea class='form-control' id='address_edit' name='address_edit' placeholder='{$this->lang->line('Address')}'>{$address}</textarea>
										<div id='address_editError' class='red'></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('City')} </label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='city_edit'
													   name='city_edit' placeholder='{$this->lang->line('City')}' type='text'
													   value='{$row->city}'>
										<div id='city_editError' class='red'></div>
										</div>
										</div>

									<div class='form-group'>
										<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('State')} </label>
										<div class='col-sm-4 controls'>
											<input class='form-control' id='state_edit'
												   name='state_edit' placeholder='{$this->lang->line('State')}' type='text'
												   value='{$row->state}'>
											<div id='state_editError' class='red'></div>
										</div>
									</div>";

					$country= $this->common_model->getSelectedCountryList($row->country_id);
					$html .= "	<div class='form-group'>
									<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Country')} </label>
									<div class='col-sm-4 controls'>
										<select class='form-control' id='country_edit'>
											{$country}
										</select>
										<div id='country_editError' class='red'></div>
									</div>
								</div>";

					$html .= "<div class='form-group'>
							<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Time Zone')} </label>
								 <div class='col-sm-4 controls'>
									 <input class='form-control' id='time_zone_edit'
										 name='time_zone_edit' placeholder='{$this->lang->line('Time Zone')}' type='text'
											 value='{$row->time_zone}'>
							<div id='time_zone_editError' class='red'></div>
							</div>
							</div>

							<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Primary Phone No')} </label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='primary_phone_edit'
										   name='primary_phone_edit' placeholder='{$this->lang->line('Primary Phone No') }' type='text'
										   value='{$row->ptn_country_code} {$row->primary_telephone_number}'>
									<div id='primary_phone_editError' class='red'></div>
								</div>
							</div>

							<div class='form-group'>
								<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Secondary Phone No') } </label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='secondary_phone_edit'
										   name='secondary_phone_edit' placeholder='{$this->lang->line('Secondary Phone No') }' type='text'
										   value='{$row->stn_country_code} {$row->secondary_telephone_number}'>
									<div id='secondary_phone_editError' class='red'></div>
								</div>
							</div>";

					$html .=   "<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
					if (isset($this->data['OGM_Admin_Edit_Locations_Permissions'])){
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

	public function check_existing($location_code) {

		$exist = false;
		$result = $this->locations_model->checkExistingLocationCode($location_code);
		$locationID = $this->input->post('location_id');

		if ($locationID != '' && $result) {
			if ($locationID != $result[0]->location_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Location code is already in use'));
			return false;
		} else {
			return true;
		}
	}

	public function getTableData(){
		if (isset($this->data['OGM_Admin_View_Locations_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
									<div class='table-responsive table_data'>
										<div class='scrollable-area1'>
											<table class='table table-striped table-bordered'
												   style='margin-bottom:0;'>
												<thead>";
			$html.="<tr>
													<th>{$this->lang->line('Location Code') }</th>
													<th>{$this->lang->line('Location Name') }</th>
													<th>{$this->lang->line('Country') }</th>
													<th>{$this->lang->line('City') }</th>
													<th>{$this->lang->line('State') }</th>
													<th>{$this->lang->line('Phone No') }</th>
													<th>{$this->lang->line('Actions')}</th>
												</tr>
												</thead>
												<tbody>";
			$locations = $this->locations_model->getAll('location_name', 'asc');
			if ($locations != null) {
				foreach ($locations as $row) {
					$html .= "<tr>";
					$html .= "<td>" . $row->location_code . "</td>";
					$html .= "<td>" . $row->location_name . "</td>";
					$html .= "<td>" . $row->country_name . "</td>";
					$html .= "<td>" . $row->city . "</td>";
					$html .= "<td>" . $row->state. "</td>";
					$html .= "<td>" . $row->ptn_country_code . "</td>";
					$html .= "<td><div class='text-left'>";
					if (isset($this->data['OGM_Admin_Edit_Locations_Permissions']))
						$html .= "<a class='btn btn-warning btn-xs get' data-id='{$row->location_id}' title='Edit' onclick='get($row->location_id);'>
										<i class='icon-wrench'></i>
									  </a> ";
					if (isset($this->data['OGM_Admin_Delete_Locations_Permissions']))
						$html .= "<a class='btn btn-danger btn-xs delete' data-id='{$row->location_id}' title='Delete'>
										<i class='icon-remove' onclick='del($row->location_id);'></i>
									  </a>";
					$html .="</div></td>";
					$html .= "</tr>";
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

	public function getAllToLocationsDropDown() {
		$options = $this->locations_model->getAllLocationsAsOptionList("Location Name");
			$html = "<div class='form-group'>
						<label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Location')} </label>
						<div class='col-sm-4 controls'>
							<select class='form-control' id='location'>
								{$options}";
			$html .= "      </select>
						</div>
						<div id='locationError' class='red'></div>
					</div>";

		echo $html;
	}

	public function getAllToLocationsDropDownWithoutLabel() {
		$options = $this->locations_model->getAllLocationsAsOptionList("Location Name");
		$html  = "  <select class='form-control' id='location' onchange='handleLocationSelect(this.id);'>
						{$options}";
		$html .= "  </select>";

		echo $html;
	}
	
	public function getLocationsToDropDownWithSavedOption($selectedIndex, $field) {
		echo $this->locations_model->getLocationsToDropDownWithSavedOption($selectedIndex, $field);
	}

	public function getAllToLocationsDropDownOnPeopleScreen() {
		$screen = $this->db->escape_str($this->input->post('screen'));
		$peopleCategory = $this->db->escape_str($this->input->post('people_category'));
		$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
		$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));

		$locationOptions = $this->locations_model->getAllLocationsAsOptionList("Location Name");

		$locationDropdown = '';
		if ($peopleCategory == 'Agent') {
			if ($screen == "save_screen") {
				$locationDropdown = " <div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='select2 form-control' id='location' multiple name='location'>
											{$locationOptions}
										</select>
										<div id='locationError' class='red'></div>
									</div>";
			} else if ($screen == "edit_screen") {
				$locationDropdown = " <div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='select2 form-control' id='location_edit' multiple name='location_edit'>
											{$locationOptions}
										</select>
										<div id='location_editError' class='red'></div>
									</div>";
			}
		} else if ($peopleCategory == 'Customer') {
			if ($screen == "save_screen") {
				$locationDropdown .= "<div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='form-control' name='location' id='location'>
											{$locationOptions}
										</select>
										<div id='locationError' class='red'></div>
									</div>";
			} else if ($screen == "edit_screen") {
				$locationDropdown .= "<div class='form-group'>
										<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')}</label>
										<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='form-control' name='location_edit' id='location_edit'>
											{$locationOptions}
										</select>
										<div id='location_editError' class='red'></div>
									</div>";
			}
		}

		echo $locationDropdown;
	}
	
	public function getAllToLocationsDropDownWithColoumPositions() {
		$screen = $this->db->escape_str($this->input->post('screen'));
		$mandatoryField = $this->db->escape_str($this->input->post('mandatory_field'));
		$labelColPosition = $this->db->escape_str($this->input->post('label_col_position'));
		$dropDownColPosition = $this->db->escape_str($this->input->post('drop_down_col_position'));

		$locationOptions = $this->locations_model->getAllLocationsAsOptionList("Location Name");

		$locationDropdown = '';
		if ($screen == "save_screen") {
			$locationDropdown = " <div class='form-group'>";
								
								if ($mandatoryField == "Yes") {
			$locationDropdown .= "		<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')} *</label>";			
								} else {
			$locationDropdown .= "		<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')}</label>";			
								}
									
			$locationDropdown .= "		<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='select2 form-control' id='location' name='location' onchange='handleLocationChange(this.id);'>
											{$locationOptions}
										</select>
										<div id='locationError' class='red'></div>
									</div>
								</div>";
		} else if ($screen == "edit_screen") {
			$locationDropdown = " <div class='form-group'>";
			
								if ($mandatoryField == "Yes") {
			$locationDropdown .= "		<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')} *</label>";			
								} else {
			$locationDropdown .= "		<label class='control-label col-sm-{$labelColPosition}'>{$this->lang->line('Location')}</label>";			
								}
								
			$locationDropdown .= "		<div class='col-sm-{$dropDownColPosition} controls'>
										<select class='select2 form-control' id='location_edit' name='location_edit' onchange='handleLocationChange(this.id);'>
											{$locationOptions}
										</select>
										<div id='location_editError' class='red'></div>
									</div>
								</div>";
		}
			
		echo $locationDropdown;
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