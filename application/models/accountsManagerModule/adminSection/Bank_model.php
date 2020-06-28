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

class Bank_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_admin_bank', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	public function addBranch($data) {
		$this->db->insert('acm_admin_bank_branch', $data);
		$this->db->limit(1);
		return true;
	}

	public function edit($id, $data) {
		$this->db->where('bank_id', $id);
		$this->db->update('acm_admin_bank', $data);
		$this->db->limit(1);
		return true;
	}

	public function delete($id, $status, $user_id) {
		$this->db->where('bank_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('acm_admin_bank');
		$this->db->limit(1);
		return true;
	}
	
	public function deleteBankBranches($id) {
		$this->db->where('bank_id', $id);
		$this->db->limit(1000);
		$this->db->delete('acm_admin_bank_branch');
		return true;
	}

	public function getAll($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('acm_admin_bank');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		$this->db->where('bank_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('acm_admin_bank');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getByName($unitName) {
		$this->db->where('bank_name', $unitName);
		$this->db->limit(1);
		$query = $this->db->get('acm_admin_bank');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBranchesOfABank($bankId) {
		$this->db->where('bank_id', $bankId);
		$this->db->limit(1000);
		$query = $this->db->get('acm_admin_bank_branch');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function checkExisting($name) {
		$this->db->where('bank_name', $name);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_admin_bank');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllToBanksDropDown() {
		$data=$this->getAll('bank_name','asc');

		$bankList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$bankList[$dataElement->bank_id] = $dataElement->bank_name;
			}
		}

		$this->optionList = '';

		foreach($bankList as $key => $bankName) {
			$this->optionList .= '<option value=' . $key . '>' . $bankName . '</option>';
		}

		$html = "<select class='select2 form-control' id='bank_id' onchange='handleBankSelect(this.id);'  onkeypress='handleBankSelectEnter(event);'>
					{$this->optionList}
				 </select>";

		return $html;
	}
	
	public function getAllBranchesOfABankToBranchesDropDown($bankId, $branchId) {
		$data=$this->getBranchesOfABank($bankId);
		$bank = $this->getById($bankId);

		$branchList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$branchList[$dataElement->branch_id] = $dataElement->branch_name;
			}
		}

		$this->optionList = '';

		foreach($branchList as $key => $branchName) {
            if($key == $branchId) {
                $this->optionList .= '<option value=' . $key . ' selected="selected">' . $branchName . '</option>';
            } else {
                $this->optionList .= '<option value=' . $key . '>' . $branchName . '</option>';
            }
		}
		
		if ($bank[0]->branch_name != '') {
			$this->optionList .= '<option value="1">' . $bank[0]->branch_name . '</option>';
		}

		$html = "<select class='select2 form-control' id='branch_id' onchange='handleBankBranchSelect(this.id);' onkeypress='handleBankBranchSelectEnter(event);'>
					{$this->optionList}
				 </select>";

		return $html;
	}
}
