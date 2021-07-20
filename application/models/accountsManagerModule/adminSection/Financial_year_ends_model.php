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

class Financial_year_ends_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_admin_financial_year_ends', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	public function edit($id, $data) {
		$this->db->where('financial_year_id', $id);
		$this->db->update('acm_admin_financial_year_ends', $data);
		$this->db->limit(1);
		return true;
	}
    
    public function getAll($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('acm_admin_financial_year_ends');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getFinancialYearEndById($financialYearId) {
		$this->db->where('financial_year_id', $financialYearId);
		$this->db->where('last_action_status !=','deleted');
        $this->db->limit(1);
		$query = $this->db->get('acm_admin_financial_year_ends');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getFinancialYearEndByFinancialYearStartAndEndDates($financialYearStartDate, $financialYearEndDate) {
		$this->db->where('financial_year_start_date', $financialYearStartDate);
        $this->db->where('financial_year_end_date', $financialYearEndDate);
		$this->db->where('last_action_status !=','deleted');
        $this->db->limit(1);
		$query = $this->db->get('acm_admin_financial_year_ends');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function isPreviousFinancialYearClosed($date) {
        $this->db->where('financial_year_end_date < ', $date);
        $this->db->where('year_end_process_status','Pending');
		$this->db->where('last_action_status !=','deleted');
        $this->db->limit(10000);
		$query = $this->db->get('acm_admin_financial_year_ends');
		if ($query->num_rows() > 0) {
			return false;
		} else {
			return true;
		}
    }
    
    public function getFinancialYearOfSelectedTransaction($date) {
        $this->db->where('financial_year_start_date <= ', $date);
        $this->db->where('financial_year_end_date >= ', $date);
		$this->db->where('last_action_status !=','deleted');
        $this->db->limit(1);
		$query = $this->db->get('acm_admin_financial_year_ends');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
    }
}
