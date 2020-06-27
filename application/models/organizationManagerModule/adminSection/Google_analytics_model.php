<?php
class Google_analytics_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        $this->db->insert('ogm_admin_google_analytic', $data);
        $this->db->limit(1);
        return true;
    }

    public function edit($id, $data) {
        $this->db->where('analytic_id', $id);
        $this->db->update('ogm_admin_google_analytic', $data);
        $this->db->limit(1);
        return true;
    }

    public function getAll() {
        $query = $this->db->get('ogm_admin_google_analytic');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}
