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

class Territories_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('ogm_admin_territories', $data);
		$this->db->limit(1);
	}

	public function edit($id, $data) {
		$this->db->where('territory_id', $id);
		$this->db->update('ogm_admin_territories', $data);
		$this->db->limit(1);
	}

	public function delete($id, $status,$user_id) {
		$this->db->where('territory_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('ogm_admin_territories');
		$this->db->limit(1);
		return true;
	}

	public function getAll($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('ogm_admin_territories.last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_territories');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		$this->db->where('ogm_admin_territories.last_action_status !=','deleted');
		$this->db->where('territory_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_territories');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getTerritoryByName($territoryName) {
		$this->db->where('territory_name', $territoryName);
		$query = $this->db->get('ogm_admin_territories');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getTerritoryByCode($territoryCode) {
		$this->db->where('territory_code', $territoryCode);
		$query = $this->db->get('ogm_admin_territories');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function checkExisting($name) {
		$this->db->where('territory_name', $name);
		$this->db->where('last_action_status !=','delete');
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_territories');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllToTerritoriesDropDown() {
		$optionList = $this->getAllTerritoriesAsOptionList("Territory Name");

		$html = "<select class='select2 form-control' id='territory_name'>
					{$optionList}
				 </select>";

		echo $html;
	}

	public function getAllTerritoriesAsOptionList($field) {
		$data = $this->getAll('territory_name','asc');

		$territoryList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Territory Name') {
					$territoryList[$dataElement->territory_id] = $dataElement->territory_name;
				} else if ($field == 'Territory Code') {
					$territoryList[$dataElement->territory_id] = $dataElement->territory_code;
				}
			}
		}

		$this->optionList = '';

		foreach($territoryList as $key => $territory) {
			$this->optionList .= '<option value=' . $key . '>' . $territory . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getTerritoriesAsOptionList($field) {
		$data=$this->getAll('territory_name','asc');

		$territoryList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Territory Name') {
					$territoryList[$dataElement->territory_id] = $dataElement->territory_name;
				} else if ($field == 'Territory Code') {
					$territoryList[$dataElement->territory_id] = $dataElement->territory_code;
				}
			}
		}

		$this->optionList = '';

		foreach($territoryList as $key => $territory) {
			$this->optionList .= '<option value=' . $key . '>' . $territory . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getTerritoriesToDropDownWithSavedOption($selectedIndex, $field) {
		$data=$this->getAll('territory_name','asc');

		$territoryList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Territory Name') {
					$territoryList[$dataElement->territory_id] = $dataElement->territory_name;
				} else if ($field == 'Territory Code') {
					$territoryList[$dataElement->territory_id] = $dataElement->territory_code;
				}
			}
		}

		$this->optionList = '';

		foreach($territoryList as $key => $territory) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $territory . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $territory . '</option>';
			}
		}

		return $this->optionList;
	}

	public function checkExistingTerritoryCode($code) {
		$this->db->where('territory_code', $code);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_territories');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}
