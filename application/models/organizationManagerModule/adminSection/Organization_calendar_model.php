<?php
class Organization_calendar_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('ogm_admin_organization_calendar', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}

	public function deleteOrganizationCalendarByCountryCodeCompanyIdAndDate($countryCode, $companyId, $date) {
		$this->db->where('country_code', $countryCode);
		$this->db->where('company_id', $companyId);
		$this->db->where('calendar_date', $date);
		$this->db->delete('ogm_admin_organization_calendar');
		$this->db->limit(1);
		return true;
	}

	public function getOrganizationCalendarByCountryCodeAndCompanyId($countryCode, $companyId, $date=null) {
		$this->db->where('country_code', $countryCode);
		$this->db->where('company_id', $companyId);
		
		if ($date != '') {
			$this->db->where('calendar_date', $date);
		}
		
		$query = $this->db->get('ogm_admin_organization_calendar');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addOrgCalendarDefaultCountryAndCompanyData($data) {
		$this->db->insert('ogm_admin_default_calendar_populate_settings', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}
	
	public function deleteOrgCalendarDefaultCountryAndCompanyData() {
		$this->db->truncate('ogm_admin_default_calendar_populate_settings'); 
		return true;
	}
	
	public function getOrgCalendarDefaultCountryAndCompanyData() {
		$this->db->order_by("country_code", "asc");
		$query = $this->db->get('ogm_admin_default_calendar_populate_settings');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
