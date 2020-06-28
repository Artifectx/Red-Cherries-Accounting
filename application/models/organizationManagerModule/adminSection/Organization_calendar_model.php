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
