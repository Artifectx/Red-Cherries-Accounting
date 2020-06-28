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

class Program_activities_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function addProgramActivityData($data) {
		$this->db->insert('svm_dsm_donation_program_activities', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	public function addProgramActivityDataToHistory($data) {
		$this->db->insert('svm_dsm_donation_program_activities_history', $data);
		$this->db->limit(1);
	}

	public function editProgramActivityData($id, $data) {
		$this->db->where('program_activity_id', $id);
		$this->db->update('svm_dsm_donation_program_activities', $data);
		$this->db->limit(1);
	}
	
	public function addProgramActivityBudgetIssueData($data) {
		$this->db->insert('svm_dsm_donation_program_activity_budget_issue', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	public function addProgramActivityBudgetIssueDataToHistory($data) {
		$this->db->insert('svm_dsm_donation_program_activity_budget_issue_history', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	public function addProgramActivityBudgetReturnData($data) {
		$this->db->insert('svm_dsm_donation_program_activity_budget_return', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	public function addProgramActivityBudgetReturnDataToHistory($data) {
		$this->db->insert('svm_dsm_donation_program_activity_budget_return_history', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function editProgramActivityBudgetIssueData($id, $data) {
		$this->db->where('budget_issue_id', $id);
		$this->db->update('svm_dsm_donation_program_activity_budget_issue', $data);
		$this->db->limit(1);
	}
	
	public function editProgramActivityBudgetReturnData($id, $data) {
		$this->db->where('budget_return_id', $id);
		$this->db->update('svm_dsm_donation_program_activity_budget_return', $data);
		$this->db->limit(1);
	}

	public function deleteProgramActivity($id, $status, $user_id) {
		$this->db->where('program_activity_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('svm_dsm_donation_program_activities');
		$this->db->limit(1);
		return true;
	}
	
	public function deleteBudgetIssue($id, $status, $user_id) {
		$this->db->where('budget_issue_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('svm_dsm_donation_program_activity_budget_issue');
		$this->db->limit(1);
		return true;
	}

	public function getAll($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->join('svm_dsm_admin_programs', 'svm_dsm_admin_programs.program_id = svm_dsm_donation_program_activities.program_id','left');
		$this->db->where('svm_dsm_donation_program_activities.last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_donation_program_activities');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllActivitiesForAProgram($order_field, $order_type, $programId) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('program_id', $programId);
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_donation_program_activities');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		$this->db->where('program_activity_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('svm_dsm_donation_program_activities');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBudgetIssueById($id) {
		$this->db->where('budget_issue_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('svm_dsm_donation_program_activity_budget_issue');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBudgetReturnById($id) {
		$this->db->where('budget_return_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('svm_dsm_donation_program_activity_budget_return');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function programActivitiesExists($programId) {
		$this->db->where('program_id', $programId);
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_donation_program_activities');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function checkExistingProgramActivity($activityName) {
		$this->db->where('activity_name', $activityName);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('svm_dsm_donation_program_activities');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllBudgetIssuesForAProgramActivity($order_field, $order_type, $programActivityId) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('program_activity_id', $programActivityId);
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_donation_program_activity_budget_issue');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllBudgetReturnsForAProgramActivity($order_field, $order_type, $programActivityId) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('program_activity_id', $programActivityId);
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_donation_program_activity_budget_return');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function addBudgetIssueJournalEntry($data) {
		$this->db->insert('svm_dsm_donation_program_budget_issue_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getBudgetIssueJournalEntries($activityId) {
		$this->db->where('program_activity_id', $activityId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('svm_dsm_donation_program_budget_issue_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addBudgetReturnJournalEntry($data) {
		$this->db->insert('svm_dsm_donation_program_budget_return_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getBudgetReturnJournalEntries($activityId) {
		$this->db->where('program_activity_id', $activityId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('svm_dsm_donation_program_budget_return_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllProgramsDetailForProgramAndLocation($programId, $locationId) {

		$condition = "SELECT Program.program_name, Location.location_name, Program.fund_available AS budget_available, "
					. "SUM(ProgramActivities.activity_budget) AS budget_estimated, SUM(ProgramActivities.activity_cost) AS activity_cost_total "
					."FROM `svm_dsm_donation_program_activities` AS ProgramActivities "
					."LEFT JOIN svm_dsm_admin_programs AS Program ON ProgramActivities.program_id = Program.program_id "
					."LEFT JOIN ogm_admin_locations AS Location ON Program.location_id = Location.location_id "
					."WHERE ProgramActivities.last_action_status != 'deleted' && Program.last_action_status != 'deleted'";

		if ($programId != '0') {
			$condition .=" AND Program.program_id = '" . $programId . "'";

			if ($locationId != '0') {
				$condition .=" AND Location.location_id = '" . $locationId ."'";
			}
		} else if ($locationId != '0') {
			$condition .=" AND Location.location_id = '" . $locationId ."'";
		}
		
		$condition .=" GROUP BY ProgramActivities.program_id";
		
	//echo $condition;die;
		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}
