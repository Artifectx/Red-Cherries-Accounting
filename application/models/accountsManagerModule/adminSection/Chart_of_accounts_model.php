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

class Chart_of_accounts_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_admin_chart_of_accounts', $data);
		$this->db->limit(1);
	}

	public function edit($id, $data) {
		$this->db->where('chart_of_account_id', $id);
		$this->db->update('acm_admin_chart_of_accounts', $data);
		$this->db->limit(1);
	}

	public function editByChartOfAccountName($chartOfAccountName, $data) {
		$this->db->where('text', $chartOfAccountName);
		$this->db->update('acm_admin_chart_of_accounts', $data);
		$this->db->limit(1);
	}

	public function delete($id) {
		$this->db->where('chart_of_account_id', $id);
		$this->db->delete('acm_admin_chart_of_accounts');
		$this->db->limit(1);
		return true;
	}

	public function getAll() {
		$query = $this->db->get('acm_admin_chart_of_accounts');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get($id) {
		$this->db->where('chart_of_account_id', $id);
		$query = $this->db->get('acm_admin_chart_of_accounts');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getChartOfAccountByName($chartOfAccountName) {
		$this->db->where('text', $chartOfAccountName);
		$query = $this->db->get('acm_admin_chart_of_accounts');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getChartOfAccountNameById($chartOfAccountId) {
		$condition = "SELECT text as chart_of_account_name "
					."FROM `acm_admin_chart_of_accounts` "
					."WHERE chart_of_account_id = $chartOfAccountId ";

		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getChildren($chartOfAccountId) {
		$condition = "SELECT * FROM `acm_admin_chart_of_accounts` WHERE `parent_id` = $chartOfAccountId";
		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function updateParent($chartOfAccountId, $data) {
		$this->db->where('parent_id', $chartOfAccountId);
		$this->db->update('acm_admin_chart_of_accounts', $data);
		$this->db->limit(1);
	}

	public function move($chartOfAccountId, $data) {
		$this->db->where('chart_of_account_id', $chartOfAccountId);
		$this->db->update('acm_admin_chart_of_accounts', $data);
		$this->db->limit(1);
	}

	public function updateLevel($chartOfAccountId, $data) {
		$this->db->where('chart_of_account_id', $chartOfAccountId);
		$this->db->update('acm_admin_chart_of_accounts', $data);
		$this->db->limit(1);
	}

	public function getAllToChartOfAccountsDropDown() {

		$this->optionList = '';

		$data=$this->getAll();

		if ($data != '') {

			$chartOfAccountData = $this->organizeChartOfAccountStructure($data);
			$chartOfAccountStructure = array('0' => $this->lang->line('-- Select --'));

			foreach($chartOfAccountData as $dataElement) {
				$chartOfAccountStructure[$dataElement->chart_of_account_id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $dataElement->level) . $dataElement->text;
			}

			foreach($chartOfAccountStructure as $key => $chartOfAccount) {
				$this->optionList .= '<option value=' . $key . '>' . $chartOfAccount . '</option>';
			}
		}
		$html = "<select class='select2 form-control' id='chart_of_account' onchange='handleChartOfAccountSelect(this.id);'>
					{$this->optionList}
				 </select>
				 <div id='chart_of_accountError' class='red'></div>";

		echo $html;
	}
    
    public function getAllToChartOfAccountsAsDropdownOptionList($selectedOption=null) {

		$this->optionList = '';

		$data=$this->getAll();

		if ($data != '') {

			$chartOfAccountData = $this->organizeChartOfAccountStructure($data);
			$chartOfAccountStructure = array('0' => $this->lang->line('-- Select --'));

			foreach($chartOfAccountData as $dataElement) {
				$chartOfAccountStructure[$dataElement->chart_of_account_id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $dataElement->level) . $dataElement->text;
			}

			foreach($chartOfAccountStructure as $key => $chartOfAccount) {
                if ($selectedOption != '' && $selectedOption == $key) {
                    $this->optionList .= '<option value=' . $key . ' selected>' . $chartOfAccount . '</option>';
                } else {
                    $this->optionList .= '<option value=' . $key . '>' . $chartOfAccount . '</option>';
                }
			}
		}
		
		return $this->optionList;
	}

	public function getAllChartOfAccountsAsOptionList() {

		$this->optionList = '';

		$data=$this->getAll();

		if ($data != '') {

			$chartOfAccountData = $this->organizeChartOfAccountStructure($data);

			$chartOfAccountStructure = array('0' => $this->lang->line('-- Select --'));

			foreach($chartOfAccountData as $dataElement) {
				$chartOfAccountStructure[$dataElement->chart_of_account_id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $dataElement->level) . $dataElement->text;
			}



			foreach($chartOfAccountStructure as $key => $chartOfAccount) {
				$this->optionList .= '<option value=' . $key . '>' . $chartOfAccount . '</option>';
			}
		}

		return $this->optionList;
	}

	public function getAllToChartOfAccountDropDownWithSavedOption($selectedIndex) {
		$data=$this->getAll();

		$chartOfAccountData = $this->organizeChartOfAccountStructure($data);

		$chartOfAccountStructure = array('0' => $this->lang->line('-- Select --'));

		foreach($chartOfAccountData as $dataElement) {
			$chartOfAccountStructure[$dataElement->chart_of_account_id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $dataElement->level) . $dataElement->text;
		}

		$this->optionList = '';

		foreach($chartOfAccountStructure as $key => $chartOfAccount) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $chartOfAccount . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $chartOfAccount . '</option>';
			}
		}

		return $this->optionList;
	}

	public function organizeChartOfAccountStructure($data) {

		$size = sizeof($data);
		$parentID = 0;
		$elementCount = 0;
		$allArranged = false;
		$organizedChartOfAccountArray = array();

		if ($data != null) {
			while(!$allArranged) {
				foreach($data as $dataElement) {
					if($dataElement->parent_id == $parentID) {
						$elementParentExit = $this->elementParentExit($dataElement, $organizedChartOfAccountArray);

						if($elementParentExit > 0) {
							array_splice($organizedChartOfAccountArray, $elementParentExit + 1, 0, array($dataElement));
							$elementParentExit = 0;
						} else {
							array_push($organizedChartOfAccountArray, $dataElement);
						}
						$elementCount++;
					}
				}
				$parentID++;
				if($elementCount == $size) {
					$allArranged = true;
				}
			}
		}

		return $organizedChartOfAccountArray;
	}

	public function elementParentExit($dataElement, $organizedChartOfAccountArray) {
		$parentID = $dataElement->parent_id;
		$trackTheKey = 0;
		$trackingStarted = false;
		foreach($organizedChartOfAccountArray as $key => $chartOfAccount) {
			if($chartOfAccount->chart_of_account_id == $parentID) {
				$trackingStarted = true;
				$trackTheKey = $key;
			} else {
				if($parentID != $chartOfAccount->parent_id && $trackingStarted) {
						break;
				} else {
					$trackTheKey = $key;
				}
			}
		}

		return $trackTheKey;
	}

	public function getLevelOneChartOfAccouts() {
		$this->db->where('parent_id', '1');
		$query = $this->db->get('acm_admin_chart_of_accounts');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getLevelTwoChartOfAccouts() {
		$this->db->where('parent_id', '2');
		$query = $this->db->get('acm_admin_chart_of_accounts');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
