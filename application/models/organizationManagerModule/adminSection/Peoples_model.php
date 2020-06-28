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

class Peoples_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('ogm_admin_people', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function addPeopleLocation($data) {
		$this->db->insert('ogm_admin_people_locations', $data);
		$this->db->limit(1);
	}
	
	public function dropPeopleLocations($peopleId) {
		$this->db->where('people_id', $peopleId);
		$this->db->limit(10000);
		$this->db->delete('ogm_admin_people_locations');
		//echo $this->db->last_query();die;
	}

	public function edit($id, $data) {
		$this->db->where('people_id', $id);
		$this->db->update('ogm_admin_people', $data);
		$this->db->limit(1);
	}

	public function editByEmployeeId($id, $data) {
		$this->db->where('employee_id', $id);
		$this->db->update('ogm_admin_people', $data);
		$this->db->limit(1);
	}
	
	public function delete($id, $status,$user_id) {
		$this->db->where('people_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('ogm_admin_people');
		$this->db->limit(1);
		return true;
	}

	public function getAll($order_field, $order_type, $peopleType=null, $checkAuthority=null) {
		$this->db->order_by($order_field, $order_type);
        
		if ($peopleType != '') {
			$this->db->where('people_type', $peopleType);
		}
        
        if ($checkAuthority == 'Yes') {
            $this->db->where('authorized', 'Yes');
        }
        
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllByCategory($order_field, $order_type, $peopleType=null, $category=null, $checkAuthority=null) {
		$this->db->order_by($order_field, $order_type);
        
		if ($peopleType != '') {
            $this->db->where('people_type', $peopleType);
            $this->db->where('people_category', $peopleType . " - " . $category);
		}
        
        if ($checkAuthority != '') {
            $this->db->where('authorized', $checkAuthority);
        }
        
		$this->db->where('last_action_status !=', 'deleted');
		$query = $this->db->get('ogm_admin_people');
        
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		$this->db->where('people_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_people');
        
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getByEmployeeId($id) {
		$this->db->where('employee_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getPeopleByName($peopleName) {
		$this->db->where('people_name', $peopleName);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getPeopleByCode($peopleCode) {
		$this->db->where('people_code', $peopleCode);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getPeopleLocationsByPeopleId($peopleId) {
		$this->db->where('people_id', $peopleId);
		$query = $this->db->get('ogm_admin_people_locations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function checkExistingPeopleCode($peopleCode) {
		$this->db->where('people_code', $peopleCode);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllPeoplesToDropDown() {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "", "", "", true, true, "Yes");

		$html = "<select class='select2 form-control' id='people_id'>
					{$optionList}
				 </select>";

		echo $html;
	}

	public function getSuppliersToDropDownWithSavedOption($selectedIndex, $field) {
		$optionList = $this->getPeoplesToDropDownWithSavedOption($selectedIndex, $field, "Supplier", "", "", false);

		return $optionList;
	}

	public function getAgentsToDropDownWithSavedOption($selectedIndex, $field, $category) {
		$optionList = $this->getPeoplesToDropDownWithSavedOption($selectedIndex, $field, "Agent", $category, false);

		return $optionList;
	}

	public function getCustomersToDropDownWithSavedOption($selectedIndex, $field, $category=null, $showPeopleCode=null) {
		$optionList = $this->getPeoplesToDropDownWithSavedOption($selectedIndex, $field, "Customer", $category, $showPeopleCode);

		return $optionList;
	}

	public function getSalesRepsToDropDownWithSavedOption($selectedIndex, $field) {
		$optionList = $this->getPeoplesToDropDownWithSavedOption($selectedIndex, $field, "Sales Rep", "", "", false);

		return $optionList;
	}

	public function getDriversToDropDownWithSavedOption($selectedIndex, $field) {
		$optionList = $this->getPeoplesToDropDownWithSavedOption($selectedIndex, $field, "Driver", "", "", false);

		return $optionList;
	}

	public function getEmployeeToDropDownWithSavedOption($selectedIndex, $field) {
		$optionList = $this->getPeoplesToDropDownWithSavedOption($selectedIndex, $field, "Employee", "", "", false);

		return $optionList;
	}
	
	public function getAllEmployeesToDropDown($type=null, $checkAuthority=null) {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "Employee", "", "", true, true, $checkAuthority);

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id' onchange='handleEmployeeSelect(this.id);'>
						{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit' onchange='handleEmployeeSelect(this.id);'>
						{$optionList}
					</select>";
		}

		return $html;
	}

	public function getAllSuppliersToDropDown($type=null, $checkAuthority=null, $disableSelection=null) {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "Supplier", "", true, true, true, $checkAuthority);

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id' onchange='handleSupplierSelect(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit' onchange='handleSupplierSelect(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					</select>";
		}

		return $html;
	}

	public function getAllAgentsToDropDown($type=null, $checkAuthority=null, $getWithAllOption=null, $disableSelection=null) {

		if ($getWithAllOption == "Yes") {
			$optionList = $this->getAllPeoplesAsOptionListWithAllOption("People Name", "Agent", '', $checkAuthority);
		} else {
			$optionList = $this->getAllPeoplesAsOptionList("People Name", "Agent", '', true, false, $checkAuthority);
		}

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id' onchange='handleAgentSelection(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit' onchange='handleAgentSelection(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					</select>";
		}

		return $html;
	}

	public function getAllAgentsByCategoriesToDropDown($category, $type=null, $getWithAllOption=null, $checkAuthority=null) {

		if ($getWithAllOption == "Yes") {
			$optionList = $this->getPeopleByCategoryAsOptionListWithAllOption("Agent", $category, $checkAuthority);
		} else {
			$optionList = $this->getPeopleByCategoryAsOptionList("Agent", $category);
		}

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id' onchange='handleAgentSelection(this.id);'>
						{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit' onchange='handleAgentSelection(this.id);'>
						{$optionList}
					</select>";
		}

		return $html;
	}

	public function getAllCustomersToDropDown($type=null, $checkAuthority=null, $getWithAllOption=null, $selectedIndex=null, 
            $showPeopleCode=null, $disableSelection=null) {

		if ($getWithAllOption == "Yes") {
			$optionList = $this->getAllPeoplesAsOptionListWithAllOption("People Name", "Customer", $selectedIndex, $checkAuthority);
		} else {
			$optionList = $this->getAllPeoplesAsOptionList("People Name", "Customer", $selectedIndex, true, $showPeopleCode, $checkAuthority);
		}

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id' onchange='handleCustomerSelection(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit' onchange='handleCustomerSelection(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		}

		return $html;
	}
	
	public function getAllCustomersDropDownWithCustomerCode($checkAuthority) {

		$optionList = $this->getAllPeoplesAsOptionListWithCustomerCode("People Name", "Customer", $checkAuthority);
		
		$html = "<select class='select2 form-control' id='people_id''>
					{$optionList}
				 </select>";
						
		return $html;
	}
	
	public function getAllPeopleDropDownWithPeopleCode($checkAuthority) {

		$optionList = $this->getAllPeoplesAsOptionListWithCustomerCode("People Name", '', $checkAuthority);
		
		$html = "<select class='select2 form-control' id='people_id''>
					{$optionList}
				 </select>";
						
		return $html;
	}
    
	public function getAllCustomersByCategoriesToDropDown($category, $type=null, $getWithAllOption=null, $checkAuthority=null) {

		if ($getWithAllOption == "Yes") {
			$optionList = $this->getPeopleByCategoryAsOptionListWithAllOption("Customer", $category, $checkAuthority);
		} else {
			$optionList = $this->getPeopleByCategoryAsOptionList("Customer", $category, $checkAuthority);
		}

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id' onchange='handleCustomerSelection(this.id);'>
						{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit' onchange='handleCustomerSelection(this.id);'>
						{$optionList}
					</select>";
		}

		return $html;
	}

	public function getAllSalesRepsToDropDown($type=null, $checkAuthority=null, $disableSelection=null) {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "Sales Rep", "", true, true, true, $checkAuthority);

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='sales_rep_id' onchange='handleSalesRepSelect(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='sales_rep_id_edit' onchange='handleSalesRepSelect(this.id);'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		}

		return $html;
	}
    
    public function getAllCashiersToDropDown($type=null, $checkAuthority=null) {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "Cashier", "", "", true, true, $checkAuthority);

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='cashier_id' onchange='handleCashierSelect(this.id);'>
						{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='cashier_id_edit' onchange='handleCashierSelect(this.id);'>
						{$optionList}
					 </select>";
		}

		return $html;
	}

	public function getAllDriversToDropDown($type=null, $checkAuthority=null, $disableSelection=null) {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "Driver", "", true, true, true, $checkAuthority);

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		}

		return $html;
	}
	
	public function getAllMembersToDropDown($type=null, $checkAuthority=null, $disableSelection=null) {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "Member", "", true, true, true, $checkAuthority);

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
			
            $html .= "{$optionList}
					 </select>";
		}

		return $html;
	}

	public function getAllEmployeeToDropDown($type=null, $checkAuthority=null, $disableSelection=null) {
		$optionList = $this->getAllPeoplesAsOptionList("People Name", "Employee", "", true, true, true, $checkAuthority);

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit'";
            
            if ($disableSelection == "Yes") {
                $html .= "   disabled >";
            } else {
                $html .= "    >";
            }
            
			$html .= "			{$optionList}
					</select>";
		}

		return $html;
	}

	public function getAllPeoplesAsOptionList($field, $peopleType=null, $selectedIndex=null, $defaultSelect=null, $showPeopleCode=null, $checkAuthority=null) {
		$data = $this->getAll('people_name', 'asc', $peopleType, $checkAuthority);

		$peopleList = '';
		
		if ($defaultSelect) {
			$peopleList = array('0' => $this->lang->line('-- Select --'));
		}

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'People Name') {
					if ($showPeopleCode) {
						if ($dataElement->people_code != '') {
							$peopleList[$dataElement->people_id] = $dataElement->people_code . " - " . $dataElement->people_name;
						} else {
							$peopleList[$dataElement->people_id] = $dataElement->people_name;
						}
					} else {
						$peopleList[$dataElement->people_id] = $dataElement->people_name;
					}
				} else if ($field == 'People Code') {
					$peopleList[$dataElement->people_id] = $dataElement->people_code;
				}
			}
		}

		$this->optionList = '';

		if ($peopleList && sizeof($peopleList) > 0) {
			foreach($peopleList as $key => $people) {
				if ($selectedIndex != '' && $selectedIndex == $key) {
					$this->optionList .= '<option value=' . $key . ' selected>' . $people . '</option>';
				} else {
					$this->optionList .= '<option value=' . $key . '>' . $people . '</option>';
				}
			}
		}

		$optionList = $this->optionList;

		return $optionList;
	}
	
	public function getAllPeoplesAsOptionListWithCustomerCode($field, $peopleType=null, $checkAuthority=null) {
		$data = $this->getAll('people_name', 'asc', $peopleType, "", $checkAuthority);

		$peopleList = '';
		
		$peopleList = array('0' => $this->lang->line('-- Select --'));
		
		if ($data != null) {
			foreach($data as $dataElement) {
				
				if ($field == 'People Name') {
					$peopleList[$dataElement->people_id] = $dataElement->people_code . " - " . $dataElement->people_name;
				} else if ($field == 'People Code') {
					$peopleList[$dataElement->people_id] = $dataElement->people_code;
				}
			}
		}

		$this->optionList = '';

		if ($peopleList && sizeof($peopleList) > 0) {
			foreach($peopleList as $key => $people) {
				$this->optionList .= '<option value=' . $key . '>' . $people . '</option>';
			}
		}

		$optionList = $this->optionList;

		return $optionList;
	}
    
	public function getAllPeoplesAsOptionListWithAllOption($field, $peopleType=null, $selectedIndex=null, $checkAuthority=null) {
		$data = $this->getAll('people_name', 'asc', $peopleType, $checkAuthority);

		$peopleList = array('0' => $this->lang->line('All'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'People Name') {
					$peopleList[$dataElement->people_id] = $dataElement->people_name;
				} else if ($field == 'People Code') {
					$peopleList[$dataElement->people_id] = $dataElement->people_name;
				}
			}
		}

		$this->optionList = '';

		foreach($peopleList as $key => $people) {
			if ($selectedIndex != '' && $selectedIndex == $key) {
				$this->optionList .= '<option value=' . $key . ' selected>' . $people . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $people . '</option>';
			}
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getPeopleByCategoryAsOptionList($peopleType, $category, $checkAuthority) {
		$data = $this->getAllByCategory('people_name', 'asc', $peopleType, $category, $checkAuthority);

		$peopleList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$peopleList[$dataElement->people_id] = $dataElement->people_name;
			}
		}

		$this->optionList = '';

		foreach($peopleList as $key => $people) {
			$this->optionList .= '<option value=' . $key . '>' . $people . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getPeopleByCategoryAsOptionListWithAllOption($peopleType, $category, $checkAuthority) {
		$data = $this->getAllByCategory('people_name', 'asc', $peopleType, $category, $checkAuthority);

		$peopleList = array('0' => $this->lang->line('All'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$peopleList[$dataElement->people_id] = $dataElement->people_name;
			}
		}

		$this->optionList = '';

		foreach($peopleList as $key => $people) {
			$this->optionList .= '<option value=' . $key . '>' . $people . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getPeoplesToDropDownWithSavedOption($selectedIndex, $field, $peopleType=null, $category=null, $showPeopleCode) {
		if ($category != '') {
			$data = $this->getAllByCategory('people_name','asc', $peopleType, $category, "Yes");
		} else  {
			$data = $this->getAll('people_name','asc', $peopleType, "Yes");
		}

		$peopleList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'People Name') {
					if ($showPeopleCode) {
						$peopleList[$dataElement->people_id] = $dataElement->people_code . " - " . $dataElement->people_name;
					} else {
						$peopleList[$dataElement->people_id] = $dataElement->people_name;
					}
				} else if ($field == 'People Code') {
					$peopleList[$dataElement->people_id] = $dataElement->people_code;
				}
			}
		}

		$this->optionList = '';

		foreach($peopleList as $key => $people) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $people . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $people . '</option>';
			}
		}

		return $this->optionList;
	}

	public function getAgentLocations($order_field, $order_type, $agentId) {
		$this->db->join('ogm_admin_locations','ogm_admin_locations.location_id=ogm_admin_people_locations.location_id');
		$this->db->order_by($order_field, $order_type);
		$this->db->where('people_id',$agentId);
		$query = $this->db->get('ogm_admin_people_locations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAgentLocationsDropdown($agentId, $type) {
		$optionList = $this->getAgentLocationsOptionList($agentId);

		if ($type == "Add") {
			$html = "<select class='select2 form-control' id='location_id'>
						{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='location_id_edit'>
						{$optionList}
					 </select>";
		}

		return $html;
	}

	public function getAgentLocationsOptionList($agentId) {
		$data = $this->getAgentLocations('location_name', 'asc', $agentId);

		$locationList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$locationList[$dataElement->location_id] = $dataElement->location_name;
			}
		}

		$this->optionList = '';

		foreach($locationList as $key => $location) {
			$this->optionList .= '<option value=' . $key . '>' . $location . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getAgentLocationsDropdownWithSavedOption($agentId, $selectedIndex) {
		$optionList = $this->getAgentLocationsOptionListWithSavedOption($agentId, $selectedIndex);

		$html = "<select class='select2 form-control' id='location_id'>
						{$optionList}
					 </select>";

		return $html;
	}

	public function getAgentLocationsOptionListWithSavedOption($agentId, $selectedIndex) {
		$data = $this->getAgentLocations('location_name', 'asc', $agentId);

		$locationList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$locationList[$dataElement->location_id] = $dataElement->location_name;
			}
		}

		$this->optionList = '';

		foreach($locationList as $key => $location) {
			if ($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' .$location . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $location . '</option>';
			}
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function isVehicleAssignedToASalesRep($vehicleId, $peopleId) {
		$this->db->where('vehicle_id', $vehicleId);
		$this->db->where('people_id !=', $peopleId);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getCustomerAutoCodes() {
		$this->db->where('people_code LIKE', '%CUS_AUTO%');
		$this->db->limit(100000);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getEmployeeAutoCodes() {
		$this->db->where('people_code LIKE', '%EMP_AUTO%');
		$this->db->limit(100000);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function verifyCustomerName($customerName) {
		$this->db->where('people_name', $customerName);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getSalesRepByVehicleId($vehicleId) {
		$this->db->where('vehicle_id', $vehicleId);
		$this->db->where('people_type', "Sales Rep");
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllEmployeesAndMembersToDropDown($type=null) {
		$employeeOptionList = $this->getAllPeoplesAsOptionList("People Name", "Employee", "", "", false, false, "Yes");
		$memberOptionList = $this->getAllPeoplesAsOptionList("People Name", "Member", "", "", false, false, "Yes");
		
		$optionList = "<option value='0'>" . $this->lang->line('-- Select --') . "</option>";
		
		$optionList .= $employeeOptionList . $memberOptionList;

		if ($type == "Add" || $type == "") {
			$html = "<select class='select2 form-control' id='people_id'>
						{$optionList}
					 </select>";
		} else {
			$html = "<select class='select2 form-control' id='people_id_edit'>
						{$optionList}
					</select>";
		}

		return $html;
	}
	
	public function getEmployeesAndMembersToDropDownWithSavedOption($selectedIndex, $field) {
		$optionList = $this->getAllEmployeesAndMembersToDropDownWithSavedOption($selectedIndex, $field);

		return $optionList;
	}
	
	public function getAllEmployeesAndMembersToDropDownWithSavedOption($selectedIndex, $field) {
		
		$employeeData = $this->getAll('people_name','asc', "Employee", "", "Yes");
		$memberData = $this->getAll('people_name','asc', "Member", "", "Yes");
		
		$peopleList = array('0' => $this->lang->line('-- Select --'));

		if ($employeeData != null) {
			foreach($employeeData as $dataElement) {
				if ($field == 'People Name') {
					$peopleList[$dataElement->people_id] = $dataElement->people_name;
				} else if ($field == 'People Code') {
					$peopleList[$dataElement->people_id] = $dataElement->people_code;
				}
			}
		}
		
		if ($memberData != null) {
			foreach($memberData as $dataElement) {
				if ($field == 'People Name') {
					$peopleList[$dataElement->people_id] = $dataElement->people_name;
				} else if ($field == 'People Code') {
					$peopleList[$dataElement->people_id] = $dataElement->people_code;
				}
			}
		}

		$this->optionList = '';

		foreach($peopleList as $key => $people) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $people . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $people . '</option>';
			}
		}

		return $this->optionList;
	}
    
    public function getLastPeopleForPeopleType($peopleType) {
		$this->db->order_by('people_id', 'asc');
		$this->db->where('people_type', $peopleType);
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
			$peopleList = $query->result();
            $lastPerson = end($peopleList);
            return $lastPerson->people_code;
		} else {
			return 'null';
		}
	}
    
    public function getAllCustomersOfWelfareCompany($welfareCompanyId) {
		$this->db->order_by('people_id', 'asc');
		$this->db->where('welfare_company_id', $welfareCompanyId);
        $this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
            return $query->result();
		} else {
			return false;
		}
	}
    
    public function getFilteredCustomersOfWelfareCompany($welfareCompanyId, $departmentId, $jobCategoryId) {
		$this->db->order_by('people_id', 'asc');
		$this->db->where('welfare_company_id', $welfareCompanyId);
        
        if ($departmentId != '0') {
            $this->db->where('welfare_company_department_id', $departmentId);
        }
        
        if ($jobCategoryId != '0') {
            $this->db->where('welfare_company_job_category_id', $jobCategoryId);
        }
        
        $this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
            return $query->result();
		} else {
			return false;
		}
	}
    
    public function isWelfareShopCustomer($customerId) {
		$this->db->where('people_id', $customerId);
        $this->db->where('welfare_company_id !=', '0');
        $this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
            $customer = $query->result();
            return $customer[0]->welfare_company_id;
		} else {
			return false;
		}
    }
    
    public function getCustomerByCustomerCode($customerCode) {
        $this->db->where('people_code', $customerCode);
        $this->db->where('people_type', 'Customer');
        $this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_people');
		if ($query->num_rows() > 0) {
            return $query->result();
		} else {
			return false;
		}
    }
}
