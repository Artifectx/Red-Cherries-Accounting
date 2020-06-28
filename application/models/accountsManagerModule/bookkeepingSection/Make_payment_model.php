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

class Make_payment_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_bookkeeping_make_payment', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function addMakePaymentReferenceTransaction($data) {
		$this->db->insert('acm_bookkeeping_make_payment_reference_transactions', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function addMakePaymentMethodRecord($data) {
		$this->db->insert('acm_bookkeeping_make_payment_method_records', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addMakePaymentDataToHistory($data) {
		$this->db->insert('acm_bookkeeping_make_payment_history', $data);
		$this->db->limit(1);
		return true;
	}
	
	public function addMakePaymentReferenceTransactionToHistory($data) {
		$this->db->insert('acm_bookkeeping_make_payment_reference_trans_histry', $data);
		$this->db->limit(1);
		return  true;
	}
	
	public function addMakePaymentMethodRecordToHistory($data) {
		$this->db->insert('acm_bookkeeping_make_payment_method_records_history', $data);
		$this->db->limit(1);
		return  true;
	}

	public function editMakePaymentData($makePaymentId, $data) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->update('acm_bookkeeping_make_payment', $data);
		$this->db->limit(1);
		return true;
	}

	public function deleteMakePayment($makePaymentId, $status,$user_id) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_make_payment');
		return true;
	}
	
	public function deleteMakePaymentReferenceTransactions($makePaymentId) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->limit(1000);
		$this->db->delete('acm_bookkeeping_make_payment_reference_transactions');
		return true;
	}
	
	public function deleteMakePaymentReferenceTransactionsSoftly($makePaymentId, $status,$user_id) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->update('acm_bookkeeping_make_payment_reference_transactions');
		return true;
	}
	
	public function deleteMakePaymentMethodRecords($makePaymentId) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->limit(1000);
		$this->db->delete('acm_bookkeeping_make_payment_method_records');
		return true;
	}
	
	public function deleteMakePaymentMethodRecordsSoftly($makePaymentId, $status,$user_id) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->update('acm_bookkeeping_make_payment_method_records');
		return true;
	}

	public function makePaymentInUse() {
		$query = $this->db->get('acm_bookkeeping_make_payment');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function checkExistingMakePayment($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_make_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMaxMakePaymentNo() {
		$this->db->select_max('make_payment_id');
		$query = $this->db->get('acm_bookkeeping_make_payment');
		if ($query->num_rows() > 0) {//echo $this->db->last_query(); die;
			return $query->result();
		} else {
			return '0';
		}
	}
	
	public function getMakePaymentByIdConsideringDeletedMakePayment($makePaymentId) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_make_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllForPeriod($fromDate, $toDate, $payeeId, $locationId, $order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->join('ogm_admin_people','ogm_admin_people.people_id=acm_bookkeeping_make_payment.payee_id');
		$this->db->join('ogm_admin_locations','ogm_admin_locations.location_id=acm_bookkeeping_make_payment.location_id');
		
		if ($fromDate != "" && $toDate != "") {
			$this->db->where('date >=', $fromDate);
			$this->db->where('date <=', $toDate);
		}
		
		if ($payeeId != "0" && $payeeId != "") {
			$this->db->where('payee_id', $payeeId);
		}
		
		if ($locationId != "0" && $locationId != "") {
			$this->db->where('acm_bookkeeping_make_payment.location_id', $locationId);
		}
	
		$this->db->where('acm_bookkeeping_make_payment.last_action_status !=','deleted');
		$this->db->limit(10000);
		$query = $this->db->get('acm_bookkeeping_make_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMakePaymentById($makePaymentId) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_make_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMakePaymentMethodRecordByChequeId($chequeId) {
		$this->db->where('cheque_id', $chequeId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_make_payment_method_records');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function addMakePaymentJournalEntry($data) {
		$this->db->insert('acm_bookkeeping_make_payment_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getMakePaymentJournalEntries($makePaymentId, $makePaymentMethodId=null, $primeEntryBookId=null) {
		$this->db->where('make_payment_id', $makePaymentId);
		
		if ($makePaymentMethodId != '') {
			$this->db->where('make_payment_method_id', $makePaymentMethodId);
		}
		
		if ($primeEntryBookId != '') {
			$this->db->where('prime_entry_book_id', $primeEntryBookId);
		}
		
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_make_payment_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMakePaymentReferenceTransactionList($makePaymentId) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_make_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMakePaymentMethodList($makePaymentId) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_make_payment_method_records');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getMakePaymentClaimAmountTotal($makePaymentId) {
		$this->db->where('make_payment_id', $makePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_make_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			$makePaymentReferenceTransactions = $query->result();
            
            $refundClaimAmountTotal = 0;
            if ($makePaymentReferenceTransactions && sizeof($makePaymentReferenceTransactions) > 0) {
                foreach($makePaymentReferenceTransactions as $makePaymentReferenceTransaction) {
                    $refundClaimAmountTotal = $refundClaimAmountTotal + $makePaymentReferenceTransaction->claim_amount;
                }
            }
            
            return $refundClaimAmountTotal;
		} else {
			return false;
		}
	}
	
	public function deleteMakePaymentJournalEntry($makePaymentJournalEntryId, $status, $user_id) {
		$this->db->where('make_payment_journal_entry_id', $makePaymentJournalEntryId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_make_payment_journal_entries');
		return true;
	}
    
    public function isReferenceTransactionUsedInMakePayments($referenceTransactionTypeId, $referenceTransactionId) {
        $this->db->where('reference_transaction_type_id', $referenceTransactionTypeId);
        $this->db->where('reference_transaction_id', $referenceTransactionId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_make_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
    }
}
