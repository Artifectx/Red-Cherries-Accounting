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

class Financial_year_ends_controller extends CI_Controller {

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
		$this->load->model('accountsManagerModule/adminSection/financial_year_ends_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
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
		$data_cls['li_class_financial_year_ends'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();
        
        $financialYears = $this->financial_year_ends_model->getAll('financial_year_id', 'desc');
        
        if (!$financialYears) {
            $firstJournalEntry = $this->journal_entries_model->getTheVeryFirstJournalEntry();
            
            if ($firstJournalEntry && sizeof($firstJournalEntry) > 0) {
                $journalEntryDate = $firstJournalEntry[0]->transaction_date;
                
                $currentDate = date('Y-m-d');
                $year = date('Y', strtotime($journalEntryDate));
                
                $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
                $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
                $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
                $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

                $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($journalEntryDate)) {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                } else {
                    if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                        $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    } else {
                        $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    }
                }
                
                $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);
                
                if (!$financialYearEndData) {
                    $data = array(
                        'financial_year_start_date' => $financialYearStartDate,
                        'financial_year_end_date' => $financialYearEndDate,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $this->financial_year_ends_model->add($data);
                }
                
                while (!(strtotime($financialYearStartDate) < strtotime($currentDate) && strtotime($financialYearEndDate) > strtotime($currentDate))) {
                    
                    if (strtotime($financialYearEndDate) < strtotime($currentDate)) {
                        
                        $financialYearStartYear = date('Y', strtotime($financialYearStartDate));
                        $financialYearEndYear = date('Y', strtotime($financialYearEndDate));
                        
                        $financialYearStartYear++;
                        $financialYearEndYear++;
                        
                        $financialYearStartDate = $financialYearStartYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = $financialYearEndYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                        
                        $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);
                
                        if (!$financialYearEndData) {
                            $data = array(
                                'financial_year_start_date' => $financialYearStartDate,
                                'financial_year_end_date' => $financialYearEndDate,
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );

                            $this->financial_year_ends_model->add($data);
                        }
                    }
                }
                
            } else {
                $currentDate = date('Y-m-d');
                $year = date('Y', strtotime($currentDate));
                
                $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
                $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
                $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
                $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

                $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($currentDate)) {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                } else {
                    if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                        $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    } else {
                        $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                        $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                    }
                }
                
                $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);
                
                if (!$financialYearEndData) {
                    $data = array(
                        'financial_year_start_date' => $financialYearStartDate,
                        'financial_year_end_date' => $financialYearEndDate,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $this->financial_year_ends_model->add($data);
                }
            }
        } else {
            
            $currentDate = date('Y-m-d');
            $year = date('Y', strtotime($currentDate));

            $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
            $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
            $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
            $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

            $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

            if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($currentDate)) {
                $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
            } else {
                if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                    $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                } else {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                }
            }

            $financialYearEndData = $this->financial_year_ends_model->getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate);

            if (!$financialYearEndData) {
                $data = array(
                    'financial_year_start_date' => $financialYearStartDate,
                    'financial_year_end_date' => $financialYearEndDate,
                    'actioned_user_id' => $this->user_id,
                    'action_date' => $this->date,
                    'last_action_status' => 'added'
                );

                $this->financial_year_ends_model->add($data);
            }
        }

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		if(isset($this->data['ACM_Admin_View_Financial_Year_Ends_Permissions'])) {
			$this->load->view('web/accountsManagerModule/adminSection/financialYearEnds/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function edit() {
		if(isset($this->data['ACM_Admin_Edit_Financial_Year_Ends_Permissions'])) {
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

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Admin_View_Financial_Year_Ends_Permissions'])) {
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Financial Year')}</th>
							<th>{$this->lang->line('Financial Year Start Date')}</th>
                            <th>{$this->lang->line('Financial Year End Date')}</th>
							<th>{$this->lang->line('Year End Process Status')}</th>
                            <th>{$this->lang->line('Year End Processed By')}</th>
							<th>{$this->lang->line('Actions')}</th>
						</tr>
					</thead>
					<tbody>";
                            
			$financialYears = $this->financial_year_ends_model->getAll('financial_year_id', 'desc');
            
			if ($financialYears != null) {
                
                $currentDate = date('Y-m-d');
                
				foreach ($financialYears as $row) {
                    
                    $financialYearStartDate = $row->financial_year_start_date;
                    $financialYearEndDate = $row->financial_year_end_date;
                    $yearEndProcessStatus = $row->year_end_process_status;
                    
                    $financialYearStartYear = date('Y', strtotime($financialYearStartDate));
                    $financialYearEndYear = date('Y', strtotime($financialYearEndDate));
                    
                    $financialYear = '';
                    
                    if ($financialYearStartYear == $financialYearEndYear) {
                        $financialYear = $financialYearStartYear;
                    } else {
                        $financialYear = $financialYearStartYear . "/" . $financialYearEndYear;
                    }
                    
                    $yearEndProcessedUserId = $row->year_end_process_user_id;
                    
                    $yearEndProcessedUser = '';
                    
                    if ($yearEndProcessedUserId != '' && $yearEndProcessedUserId != '0') {
                        $user = $this->user_model->getUserById($yearEndProcessedUserId);
                    
                        $peopleId = 0;
                        if ($user && sizeof($user) > 0) {
                            $peopleId = $user[0]->people_id;
                        }

                        $employeeName = '';
                        if ($peopleId != '' && $peopleId != 0) {
                            $employee = $this->peoples_model->getById($peopleId);
                            $yearEndProcessedUser = $employee[0]->people_name;
                        }
                    }
                    
					$html .= "<tr>";
                    $html .= "<td>" . $financialYear . "</td>";
					$html .= "<td>" . $financialYearStartDate . "</td>";
					$html .= "<td>" . $financialYearEndDate . "</td>";
					$html .= "<td>" . $yearEndProcessStatus . "</td>";
                    $html .= "<td>" . $yearEndProcessedUser . "</td>";
					$html .= "<td>
										<div class='text-left'>";
										if(isset($this->data['ACM_Admin_Edit_Financial_Year_Ends_Permissions'])) {
                                            if ($yearEndProcessStatus == "Pending" && strtotime($currentDate) > strtotime($financialYearEndDate)) {
                                                $html.="<a class='btn btn-primary btn-xs get' data-id='{$row->financial_year_id}' title='{$this->lang->line('Process Year End')}' onclick='get($row->financial_year_id);'>
                                                    <i class='icon-off'></i>
                                                </a> ";
                                            }
                                        }
					$html .= "			</div>
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
    
    public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
}