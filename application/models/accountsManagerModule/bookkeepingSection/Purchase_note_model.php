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

class Purchase_note_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_bookkeeping_purchase_note', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addPurchaseNoteDataToHistory($data) {
		$this->db->insert('acm_bookkeeping_purchase_note_history', $data);
		$this->db->limit(1);
		return true;
	}

	public function editPurchaseNoteData($purchaseNoteId, $data) {
		$this->db->where('purchase_note_id', $purchaseNoteId);
		$this->db->update('acm_bookkeeping_purchase_note', $data);
		$this->db->limit(1);
		return true;
	}

	public function deletePurchaseNote($purchaseNoteId, $status,$user_id) {
		$this->db->where('purchase_note_id', $purchaseNoteId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_purchase_note');
		return true;
	}

	public function purchaseNoteInUse() {
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function checkExistingPurchaseNote($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMaxPurchaseNoteNo() {
		$this->db->select_max('purchase_note_id');
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() > 0) {//echo $this->db->last_query(); die;
			return $query->result();
		} else {
			return '0';
		}
	}
	
	public function getPurchaseNoteByIdConsideringDeletedPurchaseNote($purchaseNoteId) {
		$this->db->where('purchase_note_id', $purchaseNoteId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getPurchaseNoteByReferenceNo($referenceNo) {
        $this->db->where('reference_no', $referenceNo);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
    }

	public function getAllForPeriod($fromDate, $toDate, $supplierId, $locationId, $order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->join('ogm_admin_people','ogm_admin_people.people_id=acm_bookkeeping_purchase_note.supplier_id');
		$this->db->join('ogm_admin_locations','ogm_admin_locations.location_id=acm_bookkeeping_purchase_note.location_id');
		
		if ($fromDate != "" && $toDate != "") {
			$this->db->where('date >=', $fromDate);
			$this->db->where('date <=', $toDate);
		}
		
		if ($supplierId != "0" && $supplierId != "") {
			$this->db->where('supplier_id', $supplierId);
		}
		
		if ($locationId != "0" && $locationId != "") {
			$this->db->where('acm_bookkeeping_purchase_note.location_id', $locationId);
		}
	
		$this->db->where('acm_bookkeeping_purchase_note.last_action_status !=','deleted');
		$this->db->limit(10000);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getPurchaseNoteById($purchaseNoteId) {
		$this->db->where('purchase_note_id', $purchaseNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addPurchaseNoteJournalEntry($data) {
		$this->db->insert('acm_bookkeeping_purchase_note_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getPurchaseNoteJournalEntries($purchaseNoteId) {
		$this->db->where('purchase_note_id', $purchaseNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_purchase_note_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllPurchaseNotes($order_field, $order_type) {
        $this->db->order_by($order_field, $order_type);
        $this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllPurchaseNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId) {
		$this->db->select('purchase_note_id, reference_no');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_purchase_note.supplier_id',$peopleId);
		$this->db->where('acm_bookkeeping_purchase_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllOpenPurchaseNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId, $locationId=null) {
		$this->db->select('purchase_note_id, reference_no');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_purchase_note.supplier_id', $peopleId);
        
        if ($locationId != '') {
            $this->db->where('acm_bookkeeping_purchase_note.location_id', $locationId);
        }
        
        $this->db->where('acm_bookkeeping_purchase_note.status',"Open");
		$this->db->where('acm_bookkeeping_purchase_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllOpenProductPurchasingPurchaseNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId, $locationId=null) {
		$this->db->select('purchase_note_id, reference_no, balance_payment');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_purchase_note.supplier_id', $peopleId);
        
        if ($locationId != '') {
            $this->db->where('acm_bookkeeping_purchase_note.location_id', $locationId);
        }
        
        $this->db->where('acm_bookkeeping_purchase_note.type',"product_purchase");
        $this->db->where('acm_bookkeeping_purchase_note.status',"Open");
		$this->db->where('acm_bookkeeping_purchase_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_purchase_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllPurchaseNotesAsOptionList() {
		$data = $this->getAllPurchaseNotes('reference_no','asc');

		$purchaseNoteList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$purchaseNoteList[$dataElement->purchase_note_id] = $dataElement->reference_no;
			}
		}

		$this->optionList = '';

		foreach($purchaseNoteList as $key => $purchaseNote) {
			$this->optionList .= '<option value=' . $key . '>' . $purchaseNote . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}
}
