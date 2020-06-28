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

class Bank_controller extends CI_Controller {

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
		$this->load->model('accountsManagerModule/adminSection/bank_model', '', TRUE);
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
		$data_cls['li_class_bank'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		if(isset($this->data['ACM_Admin_View_Bank_Permissions'])) {
			$this->load->view('web/accountsManagerModule/adminSection/bank/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function add() {
		if(isset($this->data['ACM_Admin_Add_Bank_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$data = array(
					'bank_code' => $this->db->escape_str($this->input->post('bank_code')),
					'bank_name' => $this->db->escape_str($this->input->post('bank_name')),
					'branch_name' => $this->db->escape_str($this->input->post('branch_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$bankId = $this->bank_model->add($data);
				
				$branchName = $this->db->escape_str($this->input->post('branch_name'));
				$branchList = $this->db->escape_str($this->input->post('branch_list'));
				
				if (!empty($branchList)) {
					foreach ($branchList as $branch) {
						$data = array(
							'bank_id' => $bankId,
							'branch_name' => $branch,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->bank_model->addBranch($data);
					}
				} else {
					$data = array(
						'branch_name' => $branchName,
					);

					$this->bank_model->edit($bankId, $data);
				}
				
				echo "ok";
			}
		}
	}

	public function edit() {
		if(isset($this->data['ACM_Admin_Edit_Bank_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$id = $this->db->escape_str($this->input->post('id'));
				$data = array(
					'bank_code' => $this->db->escape_str($this->input->post('bank_code')),
					'bank_name' => $this->db->escape_str($this->input->post('bank_name')),
					'branch_name' => $this->db->escape_str($this->input->post('branch_name')),
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);
				
				$this->bank_model->edit($id, $data);
				
				$branchList = $this->db->escape_str($this->input->post('branch_list'));
				
				if (!empty($branchList)) {
							
					$this->bank_model->deleteBankBranches($id);

					foreach ($branchList as $branch) {
						$data = array(
							'bank_id' => $id,
							'branch_name' => $branch,
							'actioned_user_id' => $this->user_id,
							'action_date' => $this->date,
							'last_action_status' => 'added'
						);

						$this->bank_model->addBranch($data);
					}
				} else {
					$this->bank_model->deleteBankBranches($id);
				}
				
				echo "ok";
			}
		}
	}

	public function delete() {
		if(isset($this->data['ACM_Admin_Delete_Bank_Permissions'])) {
			$status = 'deleted';
			$id = $this->db->escape_str($this->input->post('id'));
			if ($this->bank_model->delete($id, $status, $this->user_id)) {
				
				$this->bank_model->deleteBankBranches($id);
				
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">× </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}
			echo($html);
		}
	}

	public function get() {
		if(isset($this->data['ACM_Admin_Edit_Bank_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$bank = $this->bank_model->getById($id);
			$html = "";
			if ($bank != null) {
				foreach ($bank as $row) {
					$html .= "<form class='form form-horizontal validate-form save_form'>
							<div class='form-group'>
							  <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Bank Code')}</label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='id' name='id' type='hidden' value='{$row->bank_id}'>
									<input class='form-control' id='bank_code_edit' name='bank_code_edit'
										placeholder='{$this->lang->line('Bank Code')}' type='text' value='{$row->bank_code}'>
									<div id='bank_code_editError' class='red'></div>
								</div>
							</div>
							<div class='form-group'>
							  <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Bank Name')} *</label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='bank_name_edit' name='bank_name_edit'
										placeholder='{$this->lang->line('Bank Name')}' type='text' value='{$row->bank_name}'>
									<div id='bank_name_editError' class='red'></div>
								</div>
							</div>
							<div class='form-group'>
							  <label class='control-label col-sm-3 col-sm-3'>{$this->lang->line('Branch Name')}</label>
								<div class='col-sm-4 controls'>
									<input class='form-control' id='branch_name_edit' name='branch_name_edit'
										placeholder='{$this->lang->line('Branch Name')}' type='text' value='{$row->branch_name}'>
									<div id='branch_name_editError' class='red'></div>
								</div>
								<div class='col-sm-2 controls'>
									<button class='btn btn-success' type='button' id='add_branch' onclick='handleBranchSelect(this.id, /Edit/);'>
										<i class='icon-save'></i>";
					$html .=					$this->lang->line("Add");
					$html .="			</button>
								</div>
							</div>";
					
					$branches = $this->bank_model->getBranchesOfABank($id);
					
					if ($branches && sizeof($branches) > 0) {
						$html .=" <div id='branch_data_group_edit'>";
						$cloneCount = 1;
						foreach ($branches as $branch) {
							$html .="  <div class='form-group' id='branch_edit_" . $cloneCount . "'>
										<input class='form-control' id='branch_data_edit_" . $cloneCount . "' type='hidden' value='" . $branch->branch_name . "'>
										<div class='col-sm-12 controls'>
											<div class='col-sm-3 controls'>
											</div>
											<label class='control-label col-sm-2 branch_data'>" . $branch->branch_name . "</label>
											<div class='col-sm-2 controls'>
												<button class='btn btn-success' type='button' id='delete_branch_edit_" . $cloneCount . "'
													onclick='removeBranch(this.id, /Edit/)'>
													<i class='icon-save'></i>
													{$this->lang->line('Delete')}
												</button>
											</div>
										</div>
									</div>";
													
							$cloneCount++;
						}
						
						$html .=" </div>";
					} else {
						$html .=" <div id='branch_data_group_edit'></div>";
					}
							
				$html .="	<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>";
									if(isset($this->data['ACM_Admin_Edit_Bank_Permissions'])) {
										$html .= "<button class='btn btn-success save' onclick='editData();' type='button'>
													<i class='icon-save'></i>
													{$this->lang->line('Edit')}
												  </button> ";
												}
										$html .="<button class='btn btn-primary' type='reset'>
													<i class='icon-undo'></i>
												   {$this->lang->line('Refresh')}
												</button>
												<button class='btn btn-warning cancel' onclick='cancelData();' type='button'>
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

	public function check_existing($bank_name) {
		$exist = false;
		$result = $this->bank_model->checkExisting($bank_name);
		$bankId = $this->input->post('id');

		if ($bankId != '' && $result) {
			if ($bankId != $result[0]->bank_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Bank') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Admin_View_Bank_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Bank Code')}</th>
							<th>{$this->lang->line('Bank Name')}</th>
							<th>{$this->lang->line('Branch Name')}</th>
							<th>{$this->lang->line('Actions')}</th>
						</tr>
					</thead>
					<tbody>";
			$banks = $this->bank_model->getAll('bank_name', 'asc');
			if ($banks != null) {
				foreach ($banks as $row) {
					$html .= "<tr>";
					$html .= "<td>" . $row->bank_code . "</td>";
					$html .= "<td>" . $row->bank_name . "</td>";
					$html .= "<td>" . $row->branch_name . "</td>";
					$html .= "<td>
										<div class='text-left'>";
										if(isset($this->data['ACM_Admin_Edit_Bank_Permissions']))
											$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->bank_id}' title='{$this->lang->line('Edit')}' onclick='get($row->bank_id);'>
												<i class='icon-wrench'></i>
											</a> ";
										if(isset($this->data['ACM_Admin_Delete_Bank_Permissions']))
											$html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->bank_id}' title='{$this->lang->line('Delete')}' onclick='del($row->bank_id);'>
												<i class='icon-remove'></i>
											</a>
										</div>
									</td>";
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
	
	public function getBanksDropdown() {
		echo $this->bank_model->getAllToBanksDropDown();
	}
	
	public function getBranchesDropdown() {
		$bankId = $this->db->escape_str($this->input->post('bank_id'));
        $branchId = $this->db->escape_str($this->input->post('branch_id'));
		
		echo $this->bank_model->getAllBranchesOfABankToBranchesDropDown($bankId, $branchId);
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