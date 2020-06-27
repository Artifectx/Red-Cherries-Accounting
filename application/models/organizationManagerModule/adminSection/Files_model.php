<?php
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

