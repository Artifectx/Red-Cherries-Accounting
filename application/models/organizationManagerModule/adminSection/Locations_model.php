<?php
class Locations_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('ogm_admin_locations', $data);
		$this->db->limit(1);
	}

	public function edit($id, $data) {
		$this->db->where('location_id', $id);
		$this->db->update('ogm_admin_locations', $data);
		$this->db->limit(1);
	}

	public function delete($id, $status,$user_id) {
		$this->db->where('location_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('ogm_admin_locations');
		$this->db->limit(1);
		return true;
	}

	public function getAll($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		//$this->db->join('company_structure','company_structure.company_id=locations.company_id');
		$this->db->join('system_country','system_country.country_code=ogm_admin_locations.country_id',"LEFT");
		$this->db->where('ogm_admin_locations.last_action_status !=','deleted');
		$query = $this->db->get('ogm_admin_locations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllByCompany($company_id, $order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('ogm_admin_locations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getById($id) {
		//$this->db->join('company_structure','company_structure.company_id=locations.company_id');
		$this->db->join('system_country','system_country.country_code=ogm_admin_locations.country_id',"LEFT");
		$this->db->where('ogm_admin_locations.last_action_status !=','deleted');
		$this->db->where('location_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_locations');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getLocationByName($locationName, $companyID) {
		$this->db->where('location_name', $locationName);
		$this->db->where('company_id', $companyID);
		$query = $this->db->get('ogm_admin_locations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getLocationByCode($locationCode, $companyID) {
		$this->db->where('location_code', $locationCode);
		$this->db->where('company_id', $companyID);
		$query = $this->db->get('ogm_admin_locations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function checkExisting($name) {
		$this->db->where('job_title', $name);
		$this->db->where('last_action_status !=','delete');
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_locations');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllToLocationsDropDown() {
		$optionList = $this->getAllLocationsAsOptionList("Location Name");

		$html = "<select class='select2 form-control' id='location_name'>
					{$optionList}
				 </select>";

		echo $html;
	}

	public function getAllLocationsAsOptionList($field) {
		$data = $this->getAll('location_name','asc');

		$locationList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Location Name') {
					$locationList[$dataElement->location_id] = $dataElement->location_name;
				} else if ($field == 'Location Code') {
					$locationList[$dataElement->location_id] = $dataElement->location_code;
				}
			}
		}

		$this->optionList = '';

		foreach($locationList as $key => $location) {
			$this->optionList .= '<option value=' . $key . '>' . $location . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getLocationsAsOptionList($field) {
		$data=$this->getAll('location_name','asc');

		$locationList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Location Name') {
					$locationList[$dataElement->location_id] = $dataElement->location_name;
				} else if ($field == 'Location Code') {
					$locationList[$dataElement->location_id] = $dataElement->location_code;
				}
			}
		}

		$this->optionList = '';

		foreach($locationList as $key => $location) {
			$this->optionList .= '<option value=' . $key . '>' . $location . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getLocationsOfACompanyToDropDown($company_id) {
		$html = $this->getLocationsAsOptionList("Location Name");

		echo $html;
	}

	public function getLocationsToDropDownWithSavedOption($selectedIndex, $field) {
		$data=$this->getAll('location_name','asc');

		$locationList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Location Name') {
					$locationList[$dataElement->location_id] = $dataElement->location_name;
				} else if ($field == 'Location Code') {
					$locationList[$dataElement->location_id] = $dataElement->location_code;
				}
			}
		}

		$this->optionList = '';

		foreach($locationList as $key => $location) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $location . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $location . '</option>';
			}
		}

		return $this->optionList;
	}

	public function getLocationsOfACompanyToDropDownWithSavedOption($company_id, $selectedIndex, $field) {
		$data=$this->getAllByCompany($company_id, 'location_name','asc');

		$locationList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				if ($field == 'Location Name') {
					$locationList[$dataElement->location_id] = $dataElement->location_name;
				} else if ($field == 'Location Code') {
					$locationList[$dataElement->location_id] = $dataElement->location_code;
				}
			}
		}

		$this->optionList = '';

		foreach($locationList as $key => $location) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $location . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $location . '</option>';
			}
		}

		return $this->optionList;
	}

	public function checkExistingLocationCode($code) {
		$this->db->where('location_code', $code);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('ogm_admin_locations');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllCountriesAsOptionList() {

		$this->optionList = '';

		$data = $this->common_model->getCountryList('name', 'ase');

		if ($data != '') {

			$countryList = array('0' => $this->lang->line('-- Select --'));

			foreach($data as $dataElement) {
				$countryList[$dataElement->country_code] = $dataElement->country_name;
			}



			foreach($countryList as $key => $country) {
				$this->optionList .= '<option value=' . $key . '>' . $country . '</option>';
			}
		}

		return $this->optionList;
	}
}
