<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_progress_controller extends CI_Controller {

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
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/donationSection/donations_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/donationSection/program_activities_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/adminSection/programs_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function index() {
		//set selected menu
		$data_cls['ul_class_donation_section'] = 'in nav nav-stacked';
		$data_cls['li_class_program_progress'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_donation_manager', $data_cls);
		
		$data['programs'] = $this->programs_model->getAll('program_name', 'asc');

		if(isset($this->data['SVM_DSM_Donation_View_Program_Progress_Permissions'])) {
			$this->load->view('web/serviceManagerModule/donationManagerModule/donationSection/programProgress/index',  $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function saveProgramActivityData() {
		if(isset($this->data['SVM_DSM_Donation_Add_Program_Progress_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$activityNameChanged = false;
				$startDateChanged = false;
				$finishDateChanged = false;
				$activityOwnerChanged = false;
				$activityBudgetChanged = false;
				$actualStartDateChanged = false;
				$actualFinishedDateChanged = false;
				
				$activityId = $this->db->escape_str($this->input->post('activity_id'));
				$programId = $this->db->escape_str($this->input->post('program_id'));
				$activityName = $this->db->escape_str($this->input->post('activity_name'));
				$startDate = $this->db->escape_str($this->input->post('start_date'));
				$finishDate = $this->db->escape_str($this->input->post('finish_date'));
				$activityOwnerId = $this->db->escape_str($this->input->post('activity_owner_id'));
				$activityBudget = $this->db->escape_str($this->input->post('activity_budget'));
				$actualStartDate = $this->db->escape_str($this->input->post('actual_start_date'));
				$actualFinishedDate = $this->db->escape_str($this->input->post('actual_finished_date'));
				
				$actionStatus = "";
				if ($activityId != '') {
					$actionStatus = "edited";
					$programActivityData = $this->program_activities_model->getById($activityId);
					
					$activityNameOld = $programActivityData[0]->activity_name;
					$startDateOld = $programActivityData[0]->start_date;
					$finishDateOld = $programActivityData[0]->finish_date;
					$activityOwnerIdOld = $programActivityData[0]->owner_id;
					$activityBudgetOld = $programActivityData[0]->activity_budget;
					$actualStartDateOld = $programActivityData[0]->actual_start_date;
					$actualFinishedDateOld = $programActivityData[0]->actual_finished_date;
					
					if ($activityName != $activityNameOld) {$activityNameChanged = true;}
					if ($startDate != $startDateOld) {$startDateChanged = true;}
					if ($finishDate != $finishDateOld) {$finishDateChanged = true;}
					if ($activityOwnerId != $activityOwnerIdOld) {$activityOwnerChanged = true;}
					if ($activityBudget != $activityBudgetOld) {$activityBudgetChanged = true;}
					if ($actualStartDate != "" && $actualStartDate != $actualStartDateOld) {$actualStartDateChanged = true;}
					if ($actualFinishedDate != "" && $actualFinishedDate != $actualFinishedDateOld) {$actualFinishedDateChanged = true;}
				} else {
					$actionStatus = "added";
				}
				
				$data = array(
					'program_id' => $programId,
					'activity_name' => $activityName,
					'start_date' => $startDate,
					'finish_date' => $finishDate,
					'owner_id' => $activityOwnerId,
					'activity_budget' => $activityBudget,
					'actual_start_date' => $actualStartDate,
					'actual_finished_date' => $actualFinishedDate,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => $actionStatus
				);

				if ($activityId == '') {
					$this->program_activities_model->addProgramActivityData($data);
					
					echo "ok";
				} else {
					if ($activityNameChanged || $startDateChanged || $finishDateChanged || $activityOwnerChanged || $activityBudgetChanged || $actualStartDateChanged || $actualFinishedDateChanged) {
						
						$dataHistory = array(
							'program_id' => $programId,
							'activity_name' => $activityNameOld,
							'start_date' => $startDateOld,
							'finish_date' => $finishDateOld,
							'owner_id' => $activityOwnerIdOld,
							'activity_budget' => $activityBudgetOld,
							'actual_start_date' => $actualStartDateOld,
							'actual_finished_date' => $actualFinishedDateOld,
							'actioned_user_id' => $programActivityData[0]->actioned_user_id,
							'action_date' => $programActivityData[0]->action_date,
							'last_action_status' => $programActivityData[0]->last_action_status
						);
						
						$this->program_activities_model->addProgramActivityDataToHistory($dataHistory);
						
						$this->program_activities_model->editProgramActivityData($activityId, $data);
						
						echo "ok";
					} else {
						echo "no_changes_to_save";
					}
				}
				
				
			}
		}
	}

	public function deleteProgramActivity() {
		if(isset($this->data['SVM_DSM_Donation_Delete_Program_Progress_Permissions'])) {
			$status = 'deleted';
			$programActivityId = $this->db->escape_str($this->input->post('id'));
				
			if ($this->program_activities_model->deleteProgramActivity($programActivityId, $status, $this->user_id)) {
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}
			
			echo $html;
		}

	}

	public function getProgramActivityData() {
		if(isset($this->data['SVM_DSM_Donation_Edit_Program_Progress_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$programActivityData = $this->program_activities_model->getById($id);
			
			$programActivitiesName = "";
			$startDate = "";
			$finishDate = "";
			$activityOwnerId = "0";
			$activityBudget = "";
			$actualStartDate = "";
			$actualFinishedDate = "";
			
			if ($programActivityData != null) {
				foreach ($programActivityData as $row) {
					$programActivitiesName = $row->activity_name;
					$startDate = $row->start_date;
					$finishDate = $row->finish_date;
					$activityOwnerId = $row->owner_id;
					$activityBudget = str_replace(",", "", number_format($row->activity_budget, 2));
					if ($row->actual_start_date != "0000-00-00") {
						$actualStartDate = $row->actual_start_date;
					}
					if ($row->actual_finished_date != "0000-00-00") {
						$actualFinishedDate = $row->actual_finished_date;
					}
				}
			}
			
			echo json_encode(array('programActivitiesName' => $programActivitiesName, 'startDate' => $startDate, 'finishDate' => $finishDate, 'activityOwnerId' => $activityOwnerId, 'activityBudget' => $activityBudget, 'actualStartDate' => $actualStartDate, 'actualFinishedDate' => $actualFinishedDate));
		}
	}

	public function getProgramActivityTableData() {
		if(isset($this->data['SVM_DSM_Donation_View_Program_Progress_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered programActivityTable'
								   style='margin-bottom:0;'>
								<thead>";
						$html.="   <tr>
									<th>{$this->lang->line('Activity Name') }</th>
									<th>{$this->lang->line('Start Date') }</th>
									<th>{$this->lang->line('Finish Date') }</th>
									<th>{$this->lang->line('Activity Owner') }</th>
									<th>{$this->lang->line('Activity Budget') }</th>
									<th>{$this->lang->line('Activity Completion') }</th>
									<th>{$this->lang->line('Actual Start Date') }</th>
									<th>{$this->lang->line('Actual Finished Date') }</th>
									<th>{$this->lang->line('Activity Cost') }</th>
									<th>{$this->lang->line('Budget Varience') }</th>
									<th width='13%'>{$this->lang->line('Actions')}</th>
								</tr>
								</thead>
								<tbody>";
									
			$programId = $this->db->escape_str($this->input->post('program_id'));
			$programActivities = $this->program_activities_model->getAllActivitiesForAProgram('program_activity_id', 'asc', $programId);
			
			if ($programActivities != null) {
				foreach ($programActivities as $row) {
					
					$activityOwnerId = $row->owner_id;
					$activityOwner = $this->peoples_model->getById($activityOwnerId);
					$activityOwnerName = $activityOwner[0]->people_name;
					
					if ($row->actual_start_date == "0000-00-00") {
						$actualStartDate = "";
					} else {
						$actualStartDate = $row->actual_start_date;
					}
					
					if ($row->actual_finished_date == "0000-00-00") {
						$actualFinishedDate = "";
					} else {
						$actualFinishedDate = $row->actual_finished_date;
					}
					
					$activityCompletion = number_format($row->activity_completion);
					
					$html .= "<tr>";
					$html .= "<td>" . $row->activity_name . "</td>";
					$html .= "<td>" . $row->start_date . "</td>";
					$html .= "<td>" . $row->finish_date . "</td>";
					$html .= "<td>" . $activityOwnerName . "</td>";
					$html .= "<td>" . number_format($row->activity_budget, 2) . "</td>";
					$html .= '<td style="text-align:center;">' . $activityCompletion . "%</td>";
					$html .= "<td>" . $actualStartDate . "</td>";
					$html .= "<td>" . $actualFinishedDate . "</td>";
					$html .= "<td>" . number_format($row->activity_cost, 2) . "</td>";
					$html .= "<td>" . number_format($row->budget_varience, 2) . "</td>";
					$html .= "<td width='13%'><div class='text-left'>";
					if(isset($this->data['SVM_DSM_Donation_Edit_Program_Progress_Permissions'])) {
						$html .="<a class='btn btn-warning btn-xs get' data-id='{$row->program_activity_id}' title='Edit' onclick='getProgramActivityData($row->program_activity_id);'>
								 <i class='icon-wrench'></i></a> ";
						$html .="<a class='btn btn-success btn-xs get' data-id='{$row->program_activity_id}' title='Issue Money From Budget' onclick='issueMoney($programId, $row->program_activity_id, /{$row->activity_name}/);'> <i class='icon-usd'></i></a> ";
						$html .="<a class='btn btn-info btn-xs get' data-id='{$row->program_activity_id}' title='Collect Budget Return' onclick='collectMoney($programId, $row->program_activity_id, /{$row->activity_name}/);'> <i class='icon-usd'></i></a> ";
						$html .="<a class='btn btn-info btn-xs get' data-id='{$row->program_activity_id}' title='Activity Progress' onclick='updateActivityProgress($programId, $row->program_activity_id, /{$row->activity_name}/, $activityCompletion);'> <i class='icon-signal'></i></a> ";
					}
					if(isset($this->data['SVM_DSM_Donation_Delete_Program_Progress_Permissions'])) {
						$html .="<a class='btn btn-danger btn-xs delete' data-id='{$row->program_activity_id}' title='Delete' onclick='deleteProgramActivityData($row->program_activity_id);'>
								 <i class='icon-remove'></i></a>";
					}
					$html .= "  </div>
						</td>
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
	
	public function getBudgetIssueTableData() {
		if(isset($this->data['SVM_DSM_Donation_View_Program_Progress_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered programActivityBudgetIssueTable'
								   style='margin-bottom:0;'>
								<thead>";
						$html.="   <tr>
									<th>{$this->lang->line('Reference Number') }</th>
									<th>{$this->lang->line('Date') }</th>
									<th>{$this->lang->line('Amount') }</th>
									<th>{$this->lang->line('Actions')}</th>
								</tr>
								</thead>
								<tbody>";
									
			$programActivityId = $this->db->escape_str($this->input->post('program_activity_id'));
			$budgetIssues = $this->program_activities_model->getAllBudgetIssuesForAProgramActivity('date', 'asc', $programActivityId);
			
			if ($budgetIssues != null) {
				foreach ($budgetIssues as $row) {
					
					$html .= "<tr>";
					$html .= "<td>" . $row->reference_no . "</td>";
					$html .= "<td>" . $row->date . "</td>";
					$html .= "<td>" . number_format($row->budget_issue_amount, 2) . "</td>";
					$html .= "<td><div class='text-left'>";
					if(isset($this->data['SVM_DSM_Donation_Edit_Program_Progress_Permissions'])) {
						$html .="<a class='btn btn-warning btn-xs get' data-id='{$row->budget_issue_id}' title='Edit' onclick='getBudgetIssueData($row->budget_issue_id);'>
								 <i class='icon-wrench'></i></a> ";
					}
					if(isset($this->data['SVM_DSM_Donation_Delete_Program_Progress_Permissions'])) {
						$html .="<a class='btn btn-danger btn-xs delete' data-id='{$row->budget_issue_id}' title='Delete' onclick='deleteBudgetIssueData($programActivityId, $row->budget_issue_id);'>
								 <i class='icon-remove'></i></a>";
					}
					$html .= "  </div>
						</td>
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
	
	public function getBudgetReturnTableData() {
		if(isset($this->data['SVM_DSM_Donation_View_Program_Progress_Permissions'])) {
			$html = "";
			$html .="<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered programActivityBudgetReturnTable'
								   style='margin-bottom:0;'>
								<thead>";
						$html.="   <tr>
									<th>{$this->lang->line('Reference Number') }</th>
									<th>{$this->lang->line('Date') }</th>
									<th>{$this->lang->line('Amount') }</th>
									<th>{$this->lang->line('Actions')}</th>
								</tr>
								</thead>
								<tbody>";
									
			$programActivityId = $this->db->escape_str($this->input->post('program_activity_id'));
			$budgetReturns = $this->program_activities_model->getAllBudgetReturnsForAProgramActivity('date', 'asc', $programActivityId);
			
			if ($budgetReturns != null) {
				foreach ($budgetReturns as $row) {
					
					$html .= "<tr>";
					$html .= "<td>" . $row->reference_no . "</td>";
					$html .= "<td>" . $row->date . "</td>";
					$html .= "<td>" . number_format($row->budget_return_amount, 2) . "</td>";
					$html .= "<td><div class='text-left'>";
					if(isset($this->data['SVM_DSM_Donation_Edit_Program_Progress_Permissions'])) {
						$html .="<a class='btn btn-warning btn-xs get' data-id='{$row->budget_return_id}' title='Edit' onclick='getBudgetReturnData($row->budget_return_id);'>
								 <i class='icon-wrench'></i></a> ";
					}
					if(isset($this->data['SVM_DSM_Donation_Delete_Program_Progress_Permissions'])) {
						$html .="<a class='btn btn-danger btn-xs delete' data-id='{$row->budget_return_id}' title='Delete' onclick='deleteBudgetReturnData($programActivityId, $row->budget_return_id);'>
								 <i class='icon-remove'></i></a>";
					}
					$html .= "  </div>
						</td>
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
	
	public function check_existing($activityName) {
		$exist = false;
		$results = $this->program_activities_model->checkExistingProgramActivity($activityName);
		$programId = $this->db->escape_str($this->input->post('program_id'));
		$activityId = $this->db->escape_str($this->input->post('activity_id'));

		if ($activityId != '' && $results) {
			foreach ($results as $result) {
				if ($activityId !=  $result->program_activity_id && $result->program_id == $programId) {
					$exist = true;
				}
			}
		} else {
			if ($results) {
				foreach ($results as $result) {
					if ($result->program_id == $programId) {
						$exist = true;
					}
				}
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Program Activity') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}
	
	public function isDonationProgramWiseChartOfAccountInformationEnabled() {
		return $this->system_configurations_model->isDonationProgramWiseChartOfAccountInformationEnabled();
	}
	
	public function getPrimeEntryBooksToUpdateForCollectDonationTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getCollectDonationAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForCollectDonationForProgramTransaction($programId) {
		$primeEntryBooks = $this->system_configurations_model->getPrimeEntryBooksToUpdateForCollectDonationForProgramTransaction($programId);

		return $primeEntryBooks;
	}
	
	public function isAccountsManagementForLocationsEnabled() {
		return $this->system_configurations_model->isAccountsManagementForLocationsEnabled();
	}
	
	public function getProgramActivityList() {
		$programId = $this->db->escape_str($this->input->post('program_id'));
		
		$programActivitiesExists = $this->program_activities_model->programActivitiesExists($programId);
		
		$budgetTotal = 0;
		$activityCostTotal = 0;
		$budgetProgress = '0';
		$activityCompletionProgress = '0';
		
		$programStartDate = '';
		$programFinishDate = '';
		$actualProgramStartDate = '';
		$actualProgramFinishedDate = '';
		$budgetAvailableTotal = '';
		$budgetDeficiency = '';
		$budgetVarience = '';
		
		if ($programActivitiesExists) {
			$programActivities = $this->program_activities_model->getAllActivitiesForAProgram('program_activity_id', 'asc', $programId);
			
			$activityCount = 0;
			$activityCompletionTotal = 0;
			
			$programActivityCount = sizeof($programActivities);
			
			if ($programActivities && sizeof($programActivities) > 0) {
				foreach ($programActivities as $programActivity) {
					$budgetTotal = $budgetTotal + $programActivity->activity_budget;
					$activityCostTotal = $activityCostTotal + $programActivity->activity_cost;
					$activityCompletionTotal = $activityCompletionTotal + ($programActivity->activity_completion/100);
					
					if ($activityCount == 0) {
						$programStartDate = $programActivity->start_date;
						
						if ($programActivity->actual_start_date != '0000-00-00') {
							$actualProgramStartDate = $programActivity->actual_start_date;
						} else {
							$actualProgramStartDate = '';
						}
					}
					
					if ($programActivityCount == ($activityCount + 1)) {
						$programFinishDate = $programActivity->finish_date;
						
						if ($programActivity->actual_finished_date != '0000-00-00') {
							$actualProgramFinishedDate = $programActivity->actual_finished_date;
						} else {
							$actualProgramFinishedDate = '';
						}
					}
					
					$activityCount++;
				}
			}
			
			if ($activityCostTotal > 0) {
				$budgetProgress = number_format(($activityCostTotal/$budgetTotal) * 100);
				
				if ($budgetProgress > 100) {
					$budgetProgress = 100;
				}
			} else {
				 $budgetProgress = 0;
			}
			 
			if ($activityCompletionTotal > 0) {
				$activityCompletionProgress = number_format(($activityCompletionTotal/$activityCount) * 100);
			} else {
				$activityCompletionProgress = 0;
			}
			 
			$budgetReceivedForProgram = $this->donations_model->getDonationsByProgram('date', 'asc', $programId);
			 
			$budgetAvailable = 0;
			if ($budgetReceivedForProgram && sizeof($budgetReceivedForProgram) > 0) {
				$budgetAvailable = 0;
				 foreach($budgetReceivedForProgram as $budgetReceived) {
					 $budgetAvailable = $budgetAvailable + $budgetReceived->amount;
				 }
			}
			
			$budgetAvailableTotal = number_format($budgetAvailable, 2);
			if (($budgetTotal - $budgetAvailable) > 0) {
				$budgetDeficiency = number_format(($budgetTotal - $budgetAvailable), 2);
			}
		}
		
		$budgetTotalFormatted = number_format($budgetTotal, 2);
		$activityCostTotalFormatted = number_format($activityCostTotal, 2);
		
		if ($activityCostTotal > $budgetTotal) {
			$budgetVarience = number_format(($activityCostTotal - $budgetTotal), 2);
		}
		
		echo json_encode(array('budgetAvailableTotal' => $budgetAvailableTotal, 'budgetDeficiency' => $budgetDeficiency,  'programActivitiesExists' => $programActivitiesExists, 'budgetProgress' => $budgetProgress, 'activityCompletionProgress' => $activityCompletionProgress, 'budgetTotal' => $budgetTotalFormatted, 'activityCostTotal' => $activityCostTotalFormatted, 'budgetVarience' => $budgetVarience, 'programStartDate' => $programStartDate, 'actualProgramStartDate' => $actualProgramStartDate, 'programFinishDate' => $programFinishDate, 'actualProgramFinishedDate' => $actualProgramFinishedDate));
	}
	
	public function saveProgramActivityBudgetIssue() {
		if(isset($this->data['SVM_DSM_Donation_Add_Program_Progress_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$referenceNoChanged = false;
				$issueDateChanged = false;
				$budgetIssueAmountChanged = false;
				
				$budgetIssueId = $this->db->escape_str($this->input->post('budget_issue_id'));
				$activityId = $this->db->escape_str($this->input->post('activity_id'));
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$issueDate = $this->db->escape_str($this->input->post('issue_date'));
				$budgetIssueAmount = $this->db->escape_str($this->input->post('budget_issue_amount'));
				
				$programActivity = $this->program_activities_model->getById($activityId);
				
				$programId = $programActivity[0]->program_id;
				
				$programData = $this->programs_model->getById($programId);
				$programName = $programData[0]->program_name;
				$locationId = $programData[0]->location_id;
				
				$budgetIssue = $this->program_activities_model->getBudgetIssueById($budgetIssueId);
				
				if ($budgetIssue && sizeof($budgetIssue) > 0) {
					$referenceNoOld = $budgetIssue[0]->reference_no;
					$issueDateOld = $budgetIssue[0]->date;
					$budgetIssueAmountOld = $budgetIssue[0]->budget_issue_amount;
					
					if ($referenceNo != $referenceNoOld) {$referenceNoChanged = true;}
					if ($issueDate != $issueDateOld) {$issueDateChanged = true;}
					if ($budgetIssueAmount != $budgetIssueAmountOld) {$budgetIssueAmountChanged = true;}
				}
				
				$actionStatus = "";
				if ($budgetIssueId != "") {
					$actionStatus = "edited";
				} else {
					$actionStatus = "added";
				}

				$correctChartOfAccountsFoundInPrimeEntryBooks = true;

				if ($this->isDonationProgramWiseChartOfAccountInformationEnabled()) {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForBudgetIssueForProgramTransaction($programId);
				} else {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForBudgetIssueTransaction();
				}

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
						foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
							$primeEntryBookId = $primeEntryBook->config_filed_value;
							$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

							if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
								$correctChartOfAccountsFoundInPrimeEntryBooks = false;
							}
						}
					}
				}
				
				if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
					
					$data = array(
						'program_activity_id' => $activityId,
						'reference_no' => $referenceNo,
						'date' => $issueDate,
						'budget_issue_amount' => $budgetIssueAmount,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' =>$actionStatus
					);

					$actionType = "";
					$actionStatus = "";
					if ($budgetIssueId == '') {
						$actionType = "Save";
						$actionStatus = "Sccessful";
						$this->program_activities_model->addProgramActivityBudgetIssueData($data);
						
						if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
							//Add journal entry records

							if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
								foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
									$primeEntryBookId = $primeEntryBook->config_filed_value;
									$data = array(
										'prime_entry_book_id' => $primeEntryBookId,
										'transaction_date' => $issueDate,
										'reference_no' => $referenceNo,
										'location_id' => $locationId,
										'description' => $this->lang->line('Journal entry for budget issue for program : ') . $programName,
										'post_type' => "Indirect",
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'added'
									);

									$journalEntryId = $this->journal_entries_model->addJournalEntry($data);

									$data = array(
										'program_activity_id' => $activityId,
										'prime_entry_book_id' => $primeEntryBookId,
										'journal_entry_id' => $journalEntryId,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'added'
									);

									$this->program_activities_model->addBudgetIssueJournalEntry($data);

									$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
									$budgetIssueAmount = str_replace(',', '', $budgetIssueAmount);

									foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
										if ($chartOfAccount->debit_or_credit == "debit") {
											$data = array(
												'journal_entry_id' => $journalEntryId,
												'prime_entry_book_id' => $primeEntryBookId,
												'transaction_date' => $issueDate,
												'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
												'debit_value' => $budgetIssueAmount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'added'
											);
										} else if ($chartOfAccount->debit_or_credit == "credit") {
											$data = array(
												'journal_entry_id' => $journalEntryId,
												'prime_entry_book_id' => $primeEntryBookId,
												'transaction_date' => $issueDate,
												'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
												'credit_value' => $budgetIssueAmount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'added'
											);
										}

										$this->journal_entries_model->addGeneralLedgerTransaction($data);

										//Same time add the data to previous years record table.
										$this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
									}
								}
							}
						}
					} else {
						$actionType = "Edit";
						if ($referenceNoChanged || $issueDateChanged || $budgetIssueAmountChanged) {
							$actionStatus = "Sccessful";
							$dataHistory = array(
								'program_activity_id' => $activityId,
								'reference_no' => $referenceNo,
								'date' => $issueDateOld,
								'budget_issue_amount' => $budgetIssueAmountOld,
								'actioned_user_id' => $budgetIssue[0]->actioned_user_id,
								'action_date' => $budgetIssue[0]->action_date,
								'last_action_status' => $budgetIssue[0]->last_action_status
							);

							$this->program_activities_model->addProgramActivityBudgetIssueDataToHistory($dataHistory);

							$this->program_activities_model->editProgramActivityBudgetIssueData($budgetIssueId, $data);
							
							$budgetIssueJournalEntries = $this->program_activities_model->getBudgetIssueJournalEntries($activityId);

							if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
								if ($budgetIssueJournalEntries && sizeof($budgetIssueJournalEntries) > 0) {
									//Get general ledger transactions to update new amount
									foreach($budgetIssueJournalEntries as $budgetIssueJournalEntry) {
										$budgetIssuePrimeEntryBookId = $budgetIssueJournalEntry->prime_entry_book_id;
										$budgetIssueJournalEntryId = $budgetIssueJournalEntry->journal_entry_id;

										$budgetIssueGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($budgetIssueJournalEntryId, $budgetIssuePrimeEntryBookId);
										$budgetIssueAmount = str_replace(',', '', $budgetIssueAmount);

										foreach($budgetIssueGeneralLedgerTransactions as $budgetIssueGeneralLedgerTransaction) {
											if ($budgetIssueGeneralLedgerTransaction->debit_value != '0.00') {
												$data = array(
													'debit_value' => $budgetIssueAmount,
													'actioned_user_id' => $this->user_id,
													'action_date' => $this->date,
													'last_action_status' => 'edited'
												);

												$this->journal_entries_model->editGeneralLedgerTransaction($budgetIssueJournalEntryId, $budgetIssueGeneralLedgerTransaction->chart_of_account_id, $data);

												//Same time edit the data in previous years record table.
												$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($budgetIssueJournalEntryId, $budgetIssueGeneralLedgerTransaction->chart_of_account_id, $data);
											} else if ($budgetIssueGeneralLedgerTransaction->credit_value != '0.00') {
												$data = array(
													'credit_value' => $budgetIssueAmount,
													'actioned_user_id' => $this->user_id,
													'action_date' => $this->date,
													'last_action_status' => 'edited'
												);

												$this->journal_entries_model->editGeneralLedgerTransaction($budgetIssueJournalEntryId, $budgetIssueGeneralLedgerTransaction->chart_of_account_id, $data);

												//Same time edit the data in previous years record table.
												$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($budgetIssueJournalEntryId, $budgetIssueGeneralLedgerTransaction->chart_of_account_id, $data);
											}
										}
									}
								}
							}
						} else {
							$actionStatus = "Unsccessful";
						}
					}

					$activityBudget = $programActivity[0]->activity_budget;
					$activityCost = $programActivity[0]->activity_cost;

					if ($budgetIssueId == '') {
						$activityCost = $activityCost + $budgetIssueAmount;
					} else {
						$activityCost = ($activityCost - $budgetIssueAmountOld) + $budgetIssueAmount;
					}

					$budgetVarience = '0';
					if ($activityCost > $activityBudget) {
						$budgetVarience = $activityCost - $activityBudget;
					}

					$data = array(
						'activity_cost' => $activityCost,
						'budget_varience' => $budgetVarience,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);

					$this->program_activities_model->editProgramActivityData($activityId, $data);

					if (($actionType == "Save" || $actionType == "Edit") && $actionStatus == "Sccessful") {
						echo "ok";
					} else if ($actionType == "Edit" && $actionStatus == "Unsccessful") {
						echo "no_changes_to_save";
					}
				}  else {
					echo 'incorrect_prime_entry_book_selected_for_collect_donation_transaction';
				}
			}
		}
	}
	
	public function saveProgramActivityBudgetReturn() {
		if(isset($this->data['SVM_DSM_Donation_Add_Program_Progress_Permissions'])) {
			if($this->form_validation->run() == FALSE){
				echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
				$referenceNoChanged = false;
				$returnDateChanged = false;
				$budgetReturnAmountChanged = false;
				
				$budgetReturnId = $this->db->escape_str($this->input->post('budget_return_id'));
				$activityId = $this->db->escape_str($this->input->post('activity_id'));
				$referenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$returnDate = $this->db->escape_str($this->input->post('return_date'));
				$budgetReturnAmount = $this->db->escape_str($this->input->post('budget_return_amount'));
				
				$programActivity = $this->program_activities_model->getById($activityId);
				
				$programId = $programActivity[0]->program_id;
				
				$programData = $this->programs_model->getById($programId);
				$programName = $programData[0]->program_name;
				$locationId = $programData[0]->location_id;
				
				$budgetReturn = $this->program_activities_model->getBudgetReturnById($budgetReturnId);
				
				if ($budgetReturn && sizeof($budgetReturn) > 0) {
					$referenceNoOld = $budgetReturn[0]->reference_no;
					$returnDateOld = $budgetReturn[0]->date;
					$budgetReturnAmountOld = $budgetReturn[0]->budget_return_amount;
					
					if ($referenceNo != $referenceNoOld) {$referenceNoChanged = true;}
					if ($returnDate != $returnDateOld) {$returnDateChanged = true;}
					if ($budgetReturnAmount != $budgetReturnAmountOld) {$budgetReturnAmountChanged = true;}
				}

				$actionStatus = "";
				if ($budgetReturnId != "") {
					$actionStatus = "edited";
				} else {
					$actionStatus = "added";
				}
				
				$correctChartOfAccountsFoundInPrimeEntryBooks = true;

				if ($this->isDonationProgramWiseChartOfAccountInformationEnabled()) {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForBudgetReturnForProgramTransaction($programId);
				} else {
					$primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForBudgetReturnTransaction();
				}

				if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
					if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
						foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
							$primeEntryBookId = $primeEntryBook->config_filed_value;
							$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

							if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
								$correctChartOfAccountsFoundInPrimeEntryBooks = false;
							}
						}
					}
				}
				
				if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
					
					$data = array(
						'program_activity_id' => $activityId,
						'reference_no' => $referenceNo,
						'date' => $returnDate,
						'budget_return_amount' => $budgetReturnAmount,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => $actionStatus
					);

					$actionType = "";
					$actionStatus = "";
					if ($budgetReturnId == '') {
						$actionType = "Save";
						$actionStatus = "Sccessful";
						$this->program_activities_model->addProgramActivityBudgetReturnData($data);
						
						if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
							//Add journal entry records

							if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
								foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
									$primeEntryBookId = $primeEntryBook->config_filed_value;
									$data = array(
										'prime_entry_book_id' => $primeEntryBookId,
										'transaction_date' => $returnDate,
										'reference_no' => $referenceNo,
										'location_id' => $locationId,
										'description' => $this->lang->line('Journal entry for budget return for program : ') . $programName,
										'post_type' => "Indirect",
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'added'
									);

									$journalEntryId = $this->journal_entries_model->addJournalEntry($data);

									$data = array(
										'program_activity_id' => $activityId,
										'prime_entry_book_id' => $primeEntryBookId,
										'journal_entry_id' => $journalEntryId,
										'actioned_user_id' => $this->user_id,
										'action_date' => $this->date,
										'last_action_status' => 'added'
									);

									$this->program_activities_model->addBudgetReturnJournalEntry($data);

									$primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
									$budgetReturnAmount = str_replace(',', '', $budgetReturnAmount);

									foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
										if ($chartOfAccount->debit_or_credit == "debit") {
											$data = array(
												'journal_entry_id' => $journalEntryId,
												'prime_entry_book_id' => $primeEntryBookId,
												'transaction_date' => $returnDate,
												'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
												'debit_value' => $budgetReturnAmount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'added'
											);
										} else if ($chartOfAccount->debit_or_credit == "credit") {
											$data = array(
												'journal_entry_id' => $journalEntryId,
												'prime_entry_book_id' => $primeEntryBookId,
												'transaction_date' => $returnDate,
												'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
												'credit_value' => $budgetReturnAmount,
												'actioned_user_id' => $this->user_id,
												'action_date' => $this->date,
												'last_action_status' => 'added'
											);
										}

										$this->journal_entries_model->addGeneralLedgerTransaction($data);

										//Same time add the data to previous years record table.
										$this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
									}
								}
							}
						}
					} else {
						$actionType = "Edit";
						if ($referenceNoChanged || $returnDateChanged || $budgetReturnAmountChanged) {
							$actionStatus = "Sccessful";
							$dataHistory = array(
								'program_activity_id' => $activityId,
								'reference_no' => $referenceNo,
								'date' => $returnDateOld,
								'budget_return_amount' => $budgetReturnAmountOld,
								'actioned_user_id' => $budgetReturn[0]->actioned_user_id,
								'action_date' => $budgetReturn[0]->action_date,
								'last_action_status' => $budgetReturn[0]->last_action_status
							);

							$this->program_activities_model->addProgramActivityBudgetReturnDataToHistory($dataHistory);

							$this->program_activities_model->editProgramActivityBudgetReturnData($budgetReturnId, $data);
							
							$budgetReturnJournalEntries = $this->program_activities_model->getBudgetReturnJournalEntries($activityId);

							if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
								if ($budgetReturnJournalEntries && sizeof($budgetReturnJournalEntries) > 0) {
									//Get general ledger transactions to update new amount
									foreach($budgetReturnJournalEntries as $budgetReturnJournalEntry) {
										$budgetReturnPrimeEntryBookId = $budgetReturnJournalEntry->prime_entry_book_id;
										$budgetReturnJournalEntryId = $budgetReturnJournalEntry->journal_entry_id;

										$budgetReturnGeneralLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($budgetReturnJournalEntryId, $budgetReturnPrimeEntryBookId);
										$budgetReturnAmount = str_replace(',', '', $budgetReturnAmount);

										foreach($budgetReturnGeneralLedgerTransactions as $budgetReturnGeneralLedgerTransaction) {
											if ($budgetReturnGeneralLedgerTransaction->debit_value != '0.00') {
												$data = array(
													'debit_value' => $budgetReturnAmount,
													'actioned_user_id' => $this->user_id,
													'action_date' => $this->date,
													'last_action_status' => 'edited'
												);

												$this->journal_entries_model->editGeneralLedgerTransaction($budgetReturnJournalEntryId, $budgetReturnGeneralLedgerTransaction->chart_of_account_id, $data);

												//Same time edit the data in previous years record table.
												$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($budgetReturnJournalEntryId, $budgetReturnGeneralLedgerTransaction->chart_of_account_id, $data);
											} else if ($budgetReturnGeneralLedgerTransaction->credit_value != '0.00') {
												$data = array(
													'credit_value' => $budgetReturnAmount,
													'actioned_user_id' => $this->user_id,
													'action_date' => $this->date,
													'last_action_status' => 'edited'
												);

												$this->journal_entries_model->editGeneralLedgerTransaction($budgetReturnJournalEntryId, $budgetReturnGeneralLedgerTransaction->chart_of_account_id, $data);

												//Same time edit the data in previous years record table.
												$this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($budgetReturnJournalEntryId, $budgetReturnGeneralLedgerTransaction->chart_of_account_id, $data);
											}
										}
									}
								}
							}
						} else {
							$actionStatus = "Unsccessful";
						}
					}

					$activityBudget = $programActivity[0]->activity_budget;
					$activityCost = $programActivity[0]->activity_cost;

					if ($budgetReturnId == '') {
						$activityCost = $activityCost - $budgetReturnAmount;
					} else {
						$activityCost = ($activityCost + $budgetReturnAmountOld) - $budgetReturnAmount;
					}

					$budgetVarience = '0';
					if ($activityCost > $activityBudget) {
						$budgetVarience = $activityCost - $activityBudget;
					}

					$data = array(
						'activity_cost' => $activityCost,
						'budget_varience' => $budgetVarience,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'added'
					);

					$this->program_activities_model->editProgramActivityData($activityId, $data);

					if (($actionType == "Save" || $actionType == "Edit") && $actionStatus == "Sccessful") {
						echo "ok";
					} else if ($actionType == "Edit" && $actionStatus == "Unsccessful") {
						echo "no_changes_to_save";
					}
				}  else {
					echo 'incorrect_prime_entry_book_selected_for_collect_donation_transaction';
				}
			}
		}
	}
	
	public function getBudgetIssueData() {
		if(isset($this->data['SVM_DSM_Donation_Edit_Program_Progress_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$budgetIssueData = $this->program_activities_model->getBudgetIssueById($id);
			
			$referenceNo = "";
			$issueDate = "";
			$budgetIssueAmount = "";
			
			if ($budgetIssueData != null) {
				foreach ($budgetIssueData as $row) {
					$referenceNo = $row->reference_no;
					$issueDate = $row->date;
					$budgetIssueAmount = str_replace(",", "", number_format($row->budget_issue_amount, 2));
				}
			}
			
			echo json_encode(array('referenceNo' => $referenceNo, 'issueDate' => $issueDate, 'budgetIssueAmount' => $budgetIssueAmount));
		}
	}
	
	public function getBudgetReturnData() {
		if(isset($this->data['SVM_DSM_Donation_Edit_Program_Progress_Permissions'])) {
			$id = $this->db->escape_str($this->input->post('id'));
			$budgetReturnData = $this->program_activities_model->getBudgetReturnById($id);
			
			$referenceNo = "";
			$issueDate = "";
			$budgetReturnAmount = "";
			
			if ($budgetReturnData != null) {
				foreach ($budgetReturnData as $row) {
					$referenceNo = $row->reference_no;
					$issueDate = $row->date;
					$budgetReturnAmount = str_replace(",", "", number_format($row->budget_return_amount, 2));
				}
			}
			
			echo json_encode(array('referenceNo' => $referenceNo, 'returnDate' => $issueDate, 'budgetReturnAmount' => $budgetReturnAmount));
		}
	}
	
	public function deleteBudgetIssue() {
		if(isset($this->data['SVM_DSM_Donation_Delete_Program_Progress_Permissions'])) {
			$status = 'deleted';
			$activityId = $this->db->escape_str($this->input->post('activity_id'));
			$budgetIssueId = $this->db->escape_str($this->input->post('budget_issue_id'));
			
			$budgetIssue = $this->program_activities_model->getBudgetIssueById($budgetIssueId);
			$budgetIssueAmount = $budgetIssue[0]->budget_issue_amount;
				
			if ($this->program_activities_model->deleteBudgetIssue($budgetIssueId, $status, $this->user_id)) {
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
				
				$programActivity = $this->program_activities_model->getById($activityId);
				$activityBudget = $programActivity[0]->activity_cost;
				$activityBudget = $activityBudget - $budgetIssueAmount;
				
				$data = array(
					'activity_cost' => $activityBudget,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$this->program_activities_model->editProgramActivityData($activityId, $data);
			}
			
			echo $html;
		}
	}
	
	public function deleteBudgetReturn() {
		if(isset($this->data['SVM_DSM_Donation_Delete_Program_Progress_Permissions'])) {
			$status = 'deleted';
			$activityId = $this->db->escape_str($this->input->post('activity_id'));
			$budgetReturnId = $this->db->escape_str($this->input->post('budget_return_id'));
			
			$budgetReturn = $this->program_activities_model->getBudgetReturnById($budgetReturnId);
			$budgetReturnAmount = $budgetReturn[0]->budget_return_amount;
				
			if ($this->program_activities_model->deleteBudgetReturn($budgetReturnId, $status, $this->user_id)) {
				$html = '<div class="alert alert-success alert-dismissable">
						<a class="close" href="#" data-dismiss="alert">x </a>
						<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
				
				$programActivity = $this->program_activities_model->getById($activityId);
				$activityBudget = $programActivity[0]->activity_cost;
				$activityBudget = $activityBudget - $budgetReturnAmount;
				
				$data = array(
					'activity_cost' => $activityBudget,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$this->program_activities_model->editProgramActivityData($activityId, $data);
			}
			
			echo $html;
		}
	}
	
	public function saveProgramActivityProgress() {
		if(isset($this->data['SVM_DSM_Donation_Add_Program_Progress_Permissions'])) {
			
			$activityProgressChanged = false;
			
			$activityId = $this->db->escape_str($this->input->post('activity_id'));
			$activityProgress = $this->db->escape_str($this->input->post('activity_progress'));
			
			$programActivity = $this->program_activities_model->getById($activityId);
			$activityProgressOld = $programActivity[0]->activity_completion;
			
			if ($activityProgress != $activityProgressOld) {$activityProgressChanged = true;}
			
			if ($activityProgressChanged) {
				
				$data = array(
					'activity_completion' => $activityProgress,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'edited'
				);

				$this->program_activities_model->addProgramActivityDataToHistory($programActivity[0]);
				
				$this->program_activities_model->editProgramActivityData($activityId, $data);

				echo "ok";
			} 
		}
	}
	
	public function getPrimeEntryBooksToUpdateForBudgetIssueTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getBudgetIssueAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForBudgetIssueForProgramTransaction($programId) {
		$primeEntryBooks = $this->system_configurations_model->getPrimeEntryBooksToUpdateForBudgetIssueForProgramTransaction($programId);

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForBudgetReturnTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getBudgetReturnAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForBudgetReturnForProgramTransaction($programId) {
		$primeEntryBooks = $this->system_configurations_model->getPrimeEntryBooksToUpdateForBudgetReturnForProgramTransaction($programId);

		return $primeEntryBooks;
	}
}