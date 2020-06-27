<?php
class Calendar_day_types_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('ogm_admin_calendar_day_types', $data);
		$this->db->limit(1);
	}

	public function edit($id, $data) {
		$this->db->where('day_type_id', $id);
		$this->db->update('ogm_admin_calendar_day_types', $data);
		$this->db->limit(1);
	}

	public function delete($id, $status,$user_id) {
		$this->db->where('day_type_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('ogm_admin_calendar_day_types');
		$this->db->limit(1);
		return true;
	}

	public function getAll($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('ogm_admin_calendar_day_types.last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_calendar_day_types');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		$this->db->where('ogm_admin_calendar_day_types.last_action_status !=','deleted');
		$this->db->where('day_type_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_calendar_day_types');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCalendarDayTypesByName($dayTypeName) {
		$this->db->where('day_type_name', $dayTypeName);
		$query = $this->db->get('ogm_admin_calendar_day_types');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCalendarDayTypesByCode($dayTypeCode) {
		$this->db->where('day_type_code', $dayTypeCode);
		$query = $this->db->get('ogm_admin_calendar_day_types');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllToCalendarDayTypesDropDown() {
		$optionList = $this->getAllCalendarDayTypesAsOptionList("Day Type Name");

		$html = "<select class='select2 form-control' id='day_type_name'>
					{$optionList}
				 </select>";

		echo $html;
	}

	public function getAllCalendarDayTypesAsOptionList($field) {
		$data = $this->getAll('day_type_name','asc');

		$dayTypeList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Day Type Name') {
					$dayTypeList[$dataElement->day_type_id] = $dataElement->day_type_name;
				} else if ($field == 'Day Type Code') {
					$dayTypeList[$dataElement->day_type_id] = $dataElement->day_type_code;
				}
			}
		}

		$this->optionList = '';

		foreach($dayTypeList as $key => $dayType) {
			$this->optionList .= '<option value=' . $key . '>' . $dayType . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getCalendarDayTypesAsOptionList($field) {
		$data=$this->getAll('day_type_name','asc');

		$dayTypeList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Day Type Name') {
					$dayTypeList[$dataElement->day_type_id] = $dataElement->day_type_name;
				} else if ($field == 'Day Type Code') {
					$dayTypeList[$dataElement->day_type_id] = $dataElement->day_type_code;
				}
			}
		}

		$this->optionList = '';

		foreach($dayTypeList as $key => $dayType) {
			$this->optionList .= '<option value=' . $key . '>' . $dayType . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getCalendarDayTypesToDropDownWithSavedOption($selectedIndex, $field) {
		$data=$this->getAll('day_type_name','asc');

		$dayTypeList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Day Type Name') {
					$dayTypeList[$dataElement->day_type_id] = $dataElement->day_type_name;
				} else if ($field == 'Day Type Code') {
					$dayTypeList[$dataElement->day_type_id] = $dataElement->day_type_code;
				}
			}
		}

		$this->optionList = '';

		foreach($dayTypeList as $key => $dayType) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $dayType . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $dayType . '</option>';
			}
		}

		return $this->optionList;
	}

	public function checkExistingDayTypeCode($code) {
		$this->db->where('day_type_code', $code);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_calendar_day_types');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}
