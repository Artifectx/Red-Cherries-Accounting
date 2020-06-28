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

class Files_model extends CI_Model {
 
	public function insertPeopleDocument($peopleId, $filename) {
		$data = array(
			'people_id' => $peopleId,
			'file_name'      => $filename
		);
		$this->db->insert('ogm_admin_people_documents', $data);
		return $this->db->insert_id();
	}

	public function getPeopleDocuments($peopleId) {
		$this->db->where('people_id', $peopleId);
		$query = $this->db->get('ogm_admin_people_documents');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function deletePeopleDocument($documentId) {
		$this->db->where('id', $documentId);
		$this->db->delete('ogm_admin_people_documents');
		$this->db->limit(1);
		return true;
	}
}

