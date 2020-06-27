<?php

class Company_structure_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('ogm_organization_company_structure', $data);
		$this->db->limit(1);
	}

	public function edit($id, $data) {
		$this->db->where('company_id', $id);
		$this->db->update('ogm_organization_company_structure', $data);
		$this->db->limit(1);
	}

	public function editByCompanyName($companyName, $data) {
		$this->db->where('text', $companyName);
		$this->db->update('ogm_organization_company_structure', $data);
		$this->db->limit(1);
	}

	public function delete($id) {
		$this->db->where('company_id', $id);
		$this->db->delete('ogm_organization_company_structure');
		$this->db->limit(1);
		return true;
	}

	public function getAll() {
		$query = $this->db->get('ogm_organization_company_structure');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get($id) {
		$this->db->where('company_id', $id);
		$query = $this->db->get('ogm_organization_company_structure');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCompanyByName($companyName) {
		$this->db->where('text', $companyName);
		$query = $this->db->get('ogm_organization_company_structure');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCompanyNameById($company_id) {
		$condition = "SELECT text as company_name "
					."FROM `ogm_organization_company_structure` "
					."WHERE company_id = $company_id ";

		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getChildren($company_id) {
		//$query = $this->db->get('ogm_organization_company_structure',100);
		//$this->db->where('parent_id', $company_id);
		//$query = $this->db->get('ogm_organization_company_structure',100);

		/*echo $query->num_rows();
		if ($query->num_rows() > 0) {
			//return $query->result_array();
			return $query->result();
		} else {
			return false;
		}*/

		$condition = "SELECT * FROM `ogm_organization_company_structure` WHERE `parent_id` = $company_id";
		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function updateParent($company_id, $data) {
		$this->db->where('parent_id', $company_id);
		$this->db->update('ogm_organization_company_structure', $data);
		$this->db->limit(1);
	}

	public function move($company_id, $data) {
		$this->db->where('company_id', $company_id);
		$this->db->update('ogm_organization_company_structure', $data);
		$this->db->limit(1);
	}

	public function updateLevel($company_id, $data) {
		$this->db->where('company_id', $company_id);
		$this->db->update('ogm_organization_company_structure', $data);
		$this->db->limit(1);
	}

	public function getAllToCompanyDropDown() {

		$this->optionList = '';

		$data=$this->getAll();

		if ($data != '') {

			$companyData = $this->organizeCompanyStructure($data);
			$companyStructure = array('0' => $this->lang->line('-- Select --'));

			foreach($companyData as $dataElement) {
				$companyStructure[$dataElement->company_id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $dataElement->level) . $dataElement->text;
			}

			foreach($companyStructure as $key => $company) {
				$this->optionList .= '<option value=' . $key . '>' . $company . '</option>';
			}
		}
		$html = "<select class='select2 form-control' id='company'>
					{$this->optionList}
				 </select>
				 <div id='companyError' class='red'></div>";

		echo $html;
	}

	public function getAllCompaniesAsOptionList() {

		$this->optionList = '';

		$data=$this->getAll();

		if ($data != '') {

			$companyData = $this->organizeCompanyStructure($data);

			$companyStructure = array('0' => $this->lang->line('-- Select --'));

			foreach($companyData as $dataElement) {
				$companyStructure[$dataElement->company_id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $dataElement->level) . $dataElement->text;
			}



			foreach($companyStructure as $key => $company) {
				$this->optionList .= '<option value=' . $key . '>' . $company . '</option>';
			}
		}

		return $this->optionList;
	}

	public function getAllToCompanyDropDownWithSavedOption($selectedIndex) {
		$data=$this->getAll();

		$companyData = $this->organizeCompanyStructure($data);

		$companyStructure = array('0' => $this->lang->line('-- Select --'));

		foreach($companyData as $dataElement) {
			$companyStructure[$dataElement->company_id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $dataElement->level) . $dataElement->text;
		}

		$this->optionList = '';

		foreach($companyStructure as $key => $company) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $company . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $company . '</option>';
			}
		}

		return $this->optionList;
	}

	public function organizeCompanyStructure($data) {

		$size = sizeof($data);
		$parentID = 0;
		$elementCount = 0;
		$allArranged = false;
		$organizedCompanyArray = array();

		if ($data != null) {
			while(!$allArranged) {
				foreach($data as $dataElement) {
					if($dataElement->parent_id == $parentID) {
						$elementParentExit = $this->elementParentExit($dataElement, $organizedCompanyArray);

						if($elementParentExit > 0) {
							array_splice($organizedCompanyArray, $elementParentExit + 1, 0, array($dataElement));
							$elementParentExit = 0;
						} else {
							array_push($organizedCompanyArray, $dataElement);
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

		return $organizedCompanyArray;
	}

	public function elementParentExit($dataElement, $organizedCompanyArray) {
		$parentID = $dataElement->parent_id;
		$trackTheKey = 0;
		$trackingStarted = false;
		foreach($organizedCompanyArray as $key => $company) {
			if($company->company_id == $parentID) {
				$trackingStarted = true;
				$trackTheKey = $key;
			} else {
				if($parentID != $company->parent_id && $trackingStarted) {
						break;
				} else {
					$trackTheKey = $key;
				}
			}
		}

		return $trackTheKey;
	}
}
