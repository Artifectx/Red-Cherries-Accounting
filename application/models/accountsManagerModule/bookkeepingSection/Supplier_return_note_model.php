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

class Supplier_return_note_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_bookkeeping_supplier_return_note', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addSupplierReturnNoteDataToHistory($data) {
		$this->db->insert('acm_bookkeeping_supplier_return_note_history', $data);
		$this->db->limit(1);
		return true;
	}

	public function editSupplierReturnNoteData($supplierReturnNoteId, $data) {
		$this->db->where('supplier_return_note_id', $supplierReturnNoteId);
		$this->db->update('acm_bookkeeping_supplier_return_note', $data);
		$this->db->limit(1);
		return true;
	}

	public function deleteSupplierReturnNote($salesNoteId, $status,$user_id) {
		$this->db->where('supplier_return_note_id', $salesNoteId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_supplier_return_note');
		return true;
	}

	public function supplierReturnNoteInUse() {
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function checkExistingSupplierReturnNote($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMaxSupplierReturnNoteNo() {
		$this->db->select_max('supplier_return_note_id');
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() > 0) {//echo $this->db->last_query(); die;
			return $query->result();
		} else {
			return '0';
		}
	}
	
	public function getSupplierReturnNoteByIdConsideringDeletedSupplierReturnNote($salesNoteId) {
		$this->db->where('supplier_return_note_id', $salesNoteId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
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
			$this->db->where('supplier_id', $customerId);
		}
		
		if ($territoryId != "0" && $territoryId != "") {
			$this->db->where('acm_bookkeeping_supplier_return_note.territory_id', $territoryId);
		}
	
		$this->db->where('acm_bookkeeping_supplier_return_note.last_action_status !=','deleted');
		$this->db->limit(10000);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSupplierReturnNoteById($salesNoteId) {
		$this->db->where('supplier_return_note_id', $salesNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getSupplierReturnNoteByReferenceNo($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addSupplierReturnNoteJournalEntry($data) {
		$this->db->insert('acm_bookkeeping_supplier_return_note_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getSupplierReturnNoteJournalEntries($salesNoteId, $typeId) {
		$this->db->where('supplier_return_note_id', $salesNoteId);
		$this->db->where('transaction_type_id', $typeId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllSupplierReturnNotes($order_field, $order_type) {
        $this->db->order_by($order_field, $order_type);
        $this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllSupplierReturnNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId) {
		$this->db->select('supplier_return_note_id, reference_no');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_supplier_return_note.supplier_id',$peopleId);
		$this->db->where('acm_bookkeeping_supplier_return_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllOpenSupplierReturnNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId, $locationId=null) {
		$this->db->select('supplier_return_note_id, reference_no, balance_payment');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_supplier_return_note.supplier_id', $peopleId);
        
        if ($locationId != '') {
            $this->db->where('acm_bookkeeping_supplier_return_note.location_id', $locationId);
        }
        
        $this->db->where('acm_bookkeeping_supplier_return_note.status',"Open");
		$this->db->where('acm_bookkeeping_supplier_return_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_supplier_return_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllSupplierReturnNotesAsOptionList() {
		$data = $this->getAllSupplierReturnNotes('reference_no','asc');

		$supplierReturnNoteList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$supplierReturnNoteList[$dataElement->supplier_return_note_id] = $dataElement->reference_no;
			}
		}

		$this->optionList = '';

		foreach($supplierReturnNoteList as $key => $supplierReturnNote) {
			$this->optionList .= '<option value=' . $key . '>' . $supplierReturnNote . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}
}
