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

class Company_information_model extends CI_Model{

	public function __construct() {
		parent::__construct();
	}

	public function edit($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('ogm_organization_company_information', $data);
		$this->db->limit(1);
		return true;
	}

	public function add($data) {
		$this->db->insert('ogm_organization_company_information', $data);
		$this->db->limit(1);
	}

	public function getAll() {
		$query = $this->db->get('ogm_organization_company_information');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
