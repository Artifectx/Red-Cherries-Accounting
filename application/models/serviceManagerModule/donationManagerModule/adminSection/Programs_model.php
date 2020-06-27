<?php
class Programs_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('svm_dsm_admin_programs', $data);
		$this->db->limit(1);
	}
	
	public function addProgramDataToHistory($data) {
		$this->db->insert('svm_dsm_admin_programs_history', $data);
		$this->db->limit(1);
	}

	public function edit($id, $data) {
		$this->db->where('program_id', $id);
		$this->db->update('svm_dsm_admin_programs', $data);
		$this->db->limit(1);
	}

	public function delete($id, $status,$user_id) {
		$this->db->where('program_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('svm_dsm_admin_programs');
		$this->db->limit(1);
		return true;
	}

	public function getAll($order_field,$order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->join('ogm_admin_people', 'ogm_admin_people.people_id = svm_dsm_admin_programs.coordinator_id','left');
		$this->db->join('ogm_admin_locations', 'ogm_admin_locations.location_id = svm_dsm_admin_programs.location_id','left');
		$this->db->where('svm_dsm_admin_programs.last_action_status !=','deleted');
		$query = $this->db->get('svm_dsm_admin_programs');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		$this->db->where('program_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('svm_dsm_admin_programs');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function checkExistingProgram($name) {
		$this->db->where('program_name', $name);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('svm_dsm_admin_programs');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllProgramsToDropDown() {
		$optionList = $this->getAllProgramsOptionList();

		$html = "	<select class='select2 form-control' id='program_id' onchange='handleProgramSelect(this.id)'>
					{$optionList}
				 </select>";

		echo $html;
	}
	
	public function getAllProgramsOptionList() {
		$data = $this->getAll('program_name','asc');

		$programList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$programList[$dataElement->program_id] = $dataElement->program_name;
			}
		}

		$this->optionList = '';

		foreach($programList as $key => $program_name) {
			$this->optionList .= '<option value=' . $key . '>' . $program_name . '</option>';
		}

		return $this->optionList;
	}
	
	public function getAllProgramsToDropDownWithSavedOption($selectedIndex) {
		$data = $this->getAll('program_name','asc');

		$programList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$programList[$dataElement->program_id] = $dataElement->program_name;
			}
		}

		$this->optionList = '';

		foreach($programList as $key => $program_name) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $program_name . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $program_name . '</option>';
			}
		}

		return $this->optionList;
	}
	
	public function getProgramsToDropDownWithSavedOption($selectedIndex) {
		echo $this->getAllProgramsToDropDownWithSavedOption($selectedIndex);
	}
}
