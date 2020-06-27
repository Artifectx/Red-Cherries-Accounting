<?php
class Receive_payment_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_bookkeeping_receive_payment', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
    
    public function addReceivePaymentReferenceTransaction($data) {
		$this->db->insert('acm_bookkeeping_receive_payment_reference_transactions', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function addReceivePaymentMethodRecord($data) {
		$this->db->insert('acm_bookkeeping_receive_payment_method_records', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addReceivePaymentDataToHistory($data) {
		$this->db->insert('acm_bookkeeping_receive_payment_history', $data);
		$this->db->limit(1);
		return true;
	}
    
    public function addReceivePaymentReferenceTransactionToHistory($data) {
		$this->db->insert('acm_bookkeeping_receive_payment_reference_trans_histry', $data);
		$this->db->limit(1);
		return  true;
	}
	
	public function addReceivePaymentMethodRecordToHistory($data) {
		$this->db->insert('acm_bookkeeping_receive_payment_method_records_history', $data);
		$this->db->limit(1);
		return  true;
	}
    
    

	public function editReceivePaymentData($receivePaymentId, $data) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->update('acm_bookkeeping_receive_payment', $data);
		$this->db->limit(1);
		return true;
	}

	public function deleteReceivePayment($receivePaymentId, $status, $user_id) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_receive_payment');
		return true;
	}
	
	public function activateReceivePayment($receivePaymentId, $status, $user_id) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_receive_payment');
		return true;
	}
    
    public function deleteReceivePaymentReferenceTransaction($receivePaymentReferenceTransactionId) {
		$this->db->where('receive_payment_reference_transaction_id', $receivePaymentReferenceTransactionId);
		$this->db->limit(1);
		$this->db->delete('acm_bookkeeping_receive_payment_reference_transactions');
		return true;
	}
    
    public function deleteReceivePaymentReferenceTransactionSoftly($receivePaymentReferenceTransactionId, $status,$user_id) {
		$this->db->where('receive_payment_reference_transaction_id', $receivePaymentReferenceTransactionId);
        $this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_receive_payment_reference_transactions');
		return true;
	}
    
    public function deleteReceivePaymentReferenceTransactions($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->limit(1000);
		$this->db->delete('acm_bookkeeping_receive_payment_reference_transactions');
		return true;
	}
    
    public function deleteReceivePaymentReferenceTransactionsSoftly($receivePaymentId, $status,$user_id) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->update('acm_bookkeeping_receive_payment_reference_transactions');
		return true;
	}
    
    public function deleteReceivePaymentMethodRecord($receivePaymentMethodId) {
		$this->db->where('receive_payment_method_id', $receivePaymentMethodId);
		$this->db->limit(1);
		$this->db->delete('acm_bookkeeping_receive_payment_method_records');
		return true;
	}
    
    public function deleteReceivePaymentMethodRecordSoftly($receivePaymentMethodId, $status, $user_id) {
		$this->db->where('receive_payment_method_id', $receivePaymentMethodId);
        $this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->delete('acm_bookkeeping_receive_payment_method_records');
		return true;
	}
	
	public function deleteReceivePaymentMethodRecords($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->limit(1000);
		$this->db->delete('acm_bookkeeping_receive_payment_method_records');
		return true;
	}
    
    public function deleteReceivePaymentMethodRecordsSoftly($receivePaymentId, $status, $user_id) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->update('acm_bookkeeping_receive_payment_method_records');
		return true;
	}

	public function receivePaymentInUse() {
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function checkExistingReceivePayment($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMaxReceivePaymentNo() {
		$this->db->select_max('receive_payment_id');
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() > 0) {//echo $this->db->last_query(); die;
			return $query->result();
		} else {
			return '0';
		}
	}
	
	public function getReceivePaymentByIdConsideringDeletedReceivePayment($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllForPeriod($fromDate, $toDate, $payerId, $locationId, $purchaseNoteId, $salesNoteId, $customerReturnId, $supplierReturnId, $order_field, $order_type) {
		$this->db->select('DISTINCT(acm_bookkeeping_receive_payment.receive_payment_id), acm_bookkeeping_receive_payment.reference_no,'
                . 'acm_bookkeeping_receive_payment.date, ogm_admin_people.people_name, ogm_admin_locations.location_name');
        $this->db->order_by($order_field, $order_type);
		$this->db->join('ogm_admin_people','ogm_admin_people.people_id=acm_bookkeeping_receive_payment.payer_id');
		$this->db->join('ogm_admin_locations','ogm_admin_locations.location_id=acm_bookkeeping_receive_payment.location_id');
        $this->db->join('acm_bookkeeping_receive_payment_reference_transactions','acm_bookkeeping_receive_payment_reference_transactions.receive_payment_id=acm_bookkeeping_receive_payment.receive_payment_id');
		
		if ($fromDate != "" && $toDate != "") {
			$this->db->where('date >=', $fromDate);
			$this->db->where('date <=', $toDate);
		}
		
		if ($payerId != "0" && $payerId != "") {
			$this->db->where('payer_id', $payerId);
		}
		
		if ($locationId != "0" && $locationId != "") {
			$this->db->where('acm_bookkeeping_receive_payment.location_id', $locationId);
		}
        
        if ($purchaseNoteId != "0" && $purchaseNoteId != "") {
            $this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_type_id', "1");
			$this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_id', $purchaseNoteId);
		}
        
        if ($salesNoteId != "0" && $salesNoteId != "") {
            $this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_type_id', "2");
			$this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_id', $salesNoteId);
		}
        
        if ($supplierReturnId != "0" && $supplierReturnId != "") {
            $this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_type_id', "3");
			$this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_id', $supplierReturnId);
		}
        
        if ($customerReturnId != "0" && $customerReturnId != "") {
            $this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_type_id', "4");
			$this->db->where('acm_bookkeeping_receive_payment_reference_transactions.reference_transaction_id', $customerReturnId);
		}
        
		$this->db->where('acm_bookkeeping_receive_payment.last_action_status !=','deleted');
        
		$this->db->limit(10000);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReceivePaymentById($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentMethodRecordForCashPayment($cashPaymentId) {
		$this->db->where('cash_payment_id', $cashPaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_receive_payment_method_records');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentByIdConsideringDeleted($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addReceivePaymentJournalEntry($data) {
		$this->db->insert('acm_bookkeeping_receive_payment_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getReceivePaymentJournalEntries($receivePaymentId, $receivePaymentMethodId=null, $primeEntryBookId=null) {
		$this->db->where('receive_payment_id', $receivePaymentId);
        
        if ($receivePaymentMethodId != '') {
			$this->db->where('receive_payment_method_id', $receivePaymentMethodId);
		}
        
        if ($primeEntryBookId != '') {
            $this->db->where('prime_entry_book_id', $primeEntryBookId);
        }
        
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentReferenceTransactionList($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentReferenceTransactionsOfSalesNote($salesNoteId) {
        $this->db->where('reference_transaction_type_id', '2');
		$this->db->where('reference_transaction_id', $salesNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReceivePaymentListForSalesNote($receiveCashPaymentIdList) {
		$this->db->where_in('receive_payment_id', $receiveCashPaymentIdList);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReceivePaymentListForSalesNoteConsideringDeleted($receiveCashPaymentIdList) {
		$this->db->where_in('receive_payment_id', $receiveCashPaymentIdList);
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReceiveCashPaymentById($id) {
		$this->db->where('receive_payment_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_receive_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentMethodList($receivePaymentId, $paymentMethod=null) {
		$this->db->where('receive_payment_id', $receivePaymentId);
        
        if ($paymentMethod != null) {
            $this->db->where('payment_method', $paymentMethod);
        }
        
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_method_records');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentClaimAmountTotal($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			$receivePaymentReferenceTransactions = $query->result();
            
            $refundClaimAmountTotal = 0;
            if ($receivePaymentReferenceTransactions && sizeof($receivePaymentReferenceTransactions) > 0) {
                foreach($receivePaymentReferenceTransactions as $receivePaymentReferenceTransaction) {
                    $refundClaimAmountTotal = $refundClaimAmountTotal + $receivePaymentReferenceTransaction->claim_amount;
                }
            }
            
            return $refundClaimAmountTotal;
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentCustomerReturnNoteReferenceTransactions($receivePaymentId) {
		$this->db->where('receive_payment_id', $receivePaymentId);
        $this->db->where('reference_transaction_type_id', "4");
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			$receivePaymentReferenceTransactions = $query->result();
            
            $referenceTransactionIdList = array();
            if ($receivePaymentReferenceTransactions && sizeof($receivePaymentReferenceTransactions) > 0) {
                foreach($receivePaymentReferenceTransactions as $receivePaymentReferenceTransaction) {
                    $referenceTransactionIdList[] = $receivePaymentReferenceTransaction->reference_transaction_id;
                }
            }
            
            return $referenceTransactionIdList;
		} else {
			return false;
		}
	}
    
    public function getReferenceTransactionsOfSalesNote($salesNoteId) {
        $this->db->where('reference_transaction_type_id', "2");
        $this->db->where('reference_transaction_id', $salesNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			$receivePaymentReferenceTransactions = $query->result();
            
            $receivePaymentIdList = array();
            if ($receivePaymentReferenceTransactions && sizeof($receivePaymentReferenceTransactions) > 0) {
                foreach($receivePaymentReferenceTransactions as $receivePaymentReferenceTransaction) {
                    $receivePaymentIdList[] = $receivePaymentReferenceTransaction->receive_payment_id;
                }
            }
            
            return $receivePaymentIdList;
		} else {
			return false;
		}
    }

    public function deleteReceivePaymentJournalEntry($receivePaymentJournalEntryId, $status, $user_id) {
		$this->db->where('receive_payment_journal_entry_id', $receivePaymentJournalEntryId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_receive_payment_journal_entries');
		return true;
	}
    
    public function getReceivePaymentReferenceTransactionOfCustomerReturnNoteForReceivePayment($customerReturnNoteId, $receivePaymentId) {
        $this->db->where('reference_transaction_type_id', "4");
        $this->db->where('reference_transaction_id', $customerReturnNoteId);
        $this->db->where('receive_payment_id', $receivePaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_receive_payment_reference_transactions');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
    }
    
    public function isReferenceTransactionUsedInReceivePayments($referenceTransactionTypeId, $referenceTransactionId) {
        $this->db->where('reference_transaction_type_id', $referenceTransactionTypeId);
        $this->db->where('reference_transaction_id', $referenceTransactionId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_receive_payment_reference_transactions');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
    }
}
