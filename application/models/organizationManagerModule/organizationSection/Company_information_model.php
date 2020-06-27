<?php
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
