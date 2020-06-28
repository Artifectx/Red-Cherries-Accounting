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

class Customer_return_note_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_bookkeeping_customer_return_note', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addCustomerReturnNoteDataToHistory($data) {
		$this->db->insert('acm_bookkeeping_customer_return_note_history', $data);
		$this->db->limit(1);
		return true;
	}

	public function editCustomerReturnNoteData($customerReturnNoteId, $data) {
		$this->db->where('customer_return_note_id', $customerReturnNoteId);
		$this->db->update('acm_bookkeeping_customer_return_note', $data);
		$this->db->limit(1);
		return true;
	}

	public function deleteCustomerReturnNote($customerReturnNoteId, $status, $user_id) {
		$this->db->where('customer_return_note_id', $customerReturnNoteId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_customer_return_note');
		return true;
	}
	
	public function activateCustomerReturnNote($customerReturnNoteId, $status, $user_id) {
		$this->db->where('customer_return_note_id', $customerReturnNoteId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_customer_return_note');
		return true;
	}

	public function customerReturnNoteInUse() {
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function checkExistingCustomerReturnNote($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMaxCustomerReturnNoteNo() {
		$this->db->select_max('customer_return_note_id');
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() > 0) {//echo $this->db->last_query(); die;
			return $query->result();
		} else {
			return '0';
		}
	}
	
	public function getCustomerReturnNoteByIdConsideringDeletedCustomerReturnNote($customerReturnNoteId) {
		$this->db->where('customer_return_note_id', $customerReturnNoteId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getCustomerReturnNoteByReferenceNo($referenceNo) {
        $this->db->where('reference_no', $referenceNo);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
    }

    public function getAllForPeriod($fromDate, $toDate, $customerId, $territoryId, $order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		
		if ($fromDate != "" && $toDate != "") {
			$this->db->where('date >=', $fromDate);
			$this->db->where('date <=', $toDate);
		}
		
		if ($customerId != "0" && $customerId != "") {
			$this->db->where('customer_id', $customerId);
		}
		
		if ($territoryId != "0" && $territoryId != "") {
			$this->db->where('acm_bookkeeping_customer_return_note.territory_id', $territoryId);
		}
	
		$this->db->where('acm_bookkeeping_customer_return_note.last_action_status !=','deleted');
		$this->db->limit(10000);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getCustomerReturnNoteById($customerReturnNoteId) {
		$this->db->where('customer_return_note_id', $customerReturnNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getCustomerReturnNoteByIdConsideringDeleted($customerReturnNoteId) {
		$this->db->where('customer_return_note_id', $customerReturnNoteId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addCustomerReturnNoteJournalEntry($data) {
		$this->db->insert('acm_bookkeeping_customer_return_note_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getCustomerReturnNoteJournalEntries($customerReturnNoteId, $typeId) {
		$this->db->where('customer_return_note_id', $customerReturnNoteId);
		$this->db->where('transaction_type_id', $typeId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_customer_return_note_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllCustomerReturnNotes($order_field, $order_type) {
        $this->db->order_by($order_field, $order_type);
        $this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllCustomerReturnNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId) {
		$this->db->select('customer_return_note_id, reference_no');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_customer_return_note.customer_id',$peopleId);
		$this->db->where('acm_bookkeeping_customer_return_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllOpenCustomerReturnNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId, $locationId=null) {
		$this->db->select('customer_return_note_id, reference_no');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_customer_return_note.customer_id', $peopleId);
        
        if ($locationId != '') {
            $this->db->where('acm_bookkeeping_customer_return_note.location_id', $locationId);
        }
        
        $this->db->where('acm_bookkeeping_customer_return_note.status',"Open");
		$this->db->where('acm_bookkeeping_customer_return_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_customer_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllCustomerReturnNotesAsOptionList() {
		$data = $this->getAllCustomerReturnNotes('reference_no','asc');

		$customerReturnNoteList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$customerReturnNoteList[$dataElement->customer_return_note_id] = $dataElement->reference_no;
			}
		}

		$this->optionList = '';

		foreach($customerReturnNoteList as $key => $customerReturnNote) {
			$this->optionList .= '<option value=' . $key . '>' . $customerReturnNote . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}
}
