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

class Sales_note_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('acm_bookkeeping_sales_note', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function addSalesNoteReceivePaymentEntry($data) {
		$this->db->insert('acm_bookkeeping_sales_note_receive_payment', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addSalesNoteDataToHistory($data) {
		$this->db->insert('acm_bookkeeping_sales_note_history', $data);
		$this->db->limit(1);
		return true;
	}

	public function editSalesNoteData($salesNoteId, $data) {
		$this->db->where('sales_note_id', $salesNoteId);
		$this->db->update('acm_bookkeeping_sales_note', $data);
		$this->db->limit(1);
		return true;
	}
	
	public function addSalesNoteCancelledJournalEntryData($data) {
		$this->db->insert('acm_bookkeeping_sales_note_cancelled_journal_entries', $data);
		$this->db->limit(1);
		return true;
	}

	public function deleteSalesNote($salesNoteId, $status,$user_id) {
		$this->db->where('sales_note_id', $salesNoteId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_sales_note');
		return true;
	}
    
    public function deleteSalesNoteReceivePaymentEntry($salesNoteReceivePaymentId, $status, $user_id) {
        $this->db->where('sales_note_receive_payment_id', $salesNoteReceivePaymentId);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_sales_note_receive_payment');
		return true;
    }

    public function salesNoteInUse() {
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function checkExistingSalesNote($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMaxSalesNoteNo() {
		$this->db->select_max('sales_note_id');
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() > 0) {//echo $this->db->last_query(); die;
			return $query->result();
		} else {
			return '0';
		}
	}
	
	public function getSalesNoteByIdConsideringDeletedSalesNote($salesNoteId) {
		$this->db->where('sales_note_id', $salesNoteId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_sales_note');
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
			$this->db->where('acm_bookkeeping_sales_note.territory_id', $territoryId);
		}
	
		$this->db->where('acm_bookkeeping_sales_note.last_action_status !=','deleted');
		$this->db->limit(10000);
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSalesNoteById($salesNoteId) {
		$this->db->where('sales_note_id', $salesNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getSalesNoteByReferenceNo($referenceNo) {
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function addSalesNoteJournalEntry($data) {
		$this->db->insert('acm_bookkeeping_sales_note_journal_entries', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function getSalesNoteJournalEntries($salesNoteId, $typeId=null) {
		$this->db->where('sales_note_id', $salesNoteId);
        
        if ($typeId != '') {
            $this->db->where('transaction_type_id', $typeId);
        }
        
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_sales_note_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllSalesNotes($order_field, $order_type) {
        $this->db->order_by($order_field, $order_type);
        $this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSalesNoteCancelledJournalEntryData($salesNoteId) {
		$this->db->where('sales_note_id', $salesNoteId);
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_sales_note_cancelled_journal_entries');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getSalesNoteReceivePaymentBySalesNoteIdAndReceiveCashPaymentMethodId($salesNoteId, $receiveCashPaymentMethodId) {
        $this->db->where('sales_note_id', $salesNoteId);
        $this->db->where('receive_cash_payment_method_id', $receiveCashPaymentMethodId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_sales_note_receive_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
    }
    
    public function getSalesNoteReceivePaymentBySalesNoteIdAndReceiveChequePaymentMethodId($salesNoteId, $receiveChequePaymentMethodId) {
        $this->db->where('sales_note_id', $salesNoteId);
        $this->db->where('receive_cheque_payment_method_id', $receiveChequePaymentMethodId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_sales_note_receive_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
    }
    
    public function getSalesNoteReceivePaymentBySalesNoteIdAndReceiveCardPaymentMethodId($salesNoteId, $receiveCardPaymentMethodId) {
        $this->db->where('sales_note_id', $salesNoteId);
        $this->db->where('receive_credit_card_payment_method_id', $receiveCardPaymentMethodId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_sales_note_receive_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
    }

    public function getSalesNoteReceivePaymentEntries($salesNoteId) {
		$this->db->where('sales_note_id', $salesNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_sales_note_receive_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getCashPaymentListForSalesNote($salesNoteId) {
        $this->db->where('transaction_type', "Sales Note");
		$this->db->where('transaction_id', $salesNoteId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(100);
		$query = $this->db->get('acm_bookkeeping_cash_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllSalesNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId) {
		$this->db->select('sales_note_id, reference_no');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_sales_note.customer_id',$peopleId);
		$this->db->where('acm_bookkeeping_sales_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getAllOpenSalesNoteIdsAndAllReferenceNumbers($order_field, $order_type, $peopleId, $locationId=null) {
		$this->db->select('sales_note_id, reference_no, balance_payment');
		$this->db->order_by($order_field, $order_type);
        $this->db->where('acm_bookkeeping_sales_note.customer_id', $peopleId);
        
        if ($locationId != '') {
            $this->db->where('acm_bookkeeping_sales_note.location_id', $locationId);
        }
        
        $this->db->where('acm_bookkeeping_sales_note.status',"Open");
		$this->db->where('acm_bookkeeping_sales_note.last_action_status !=','deleted');
		$this->db->limit(1000000);
		$query = $this->db->get('acm_bookkeeping_sales_note');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllSalesPaymentDetailForDateRange($fromDate, $toDate, $locationId, $territoryId, $showCancelledSalesNotes) {
		
		$condition = "SELECT SalesNote.sales_note_id, SalesNote.reference_no, SalesNote.date, SalesNote.sales_amount AS sales_amount, "
						."SalesNote.discount AS discount, SalesNote.free_issue_amount AS free_issue_amount, "
						."SalesNote.amount_payable AS amount_payable, SalesNote.cash_payment_amount AS cash_amount, "
						."SalesNote.cheque_payment_amount AS cheque_amount, SalesNote.credit_card_payment_amount AS credit_card_amount, "
                        ."SalesNote.customer_return_note_claimed AS claimed_customer_returns, "
						."SalesNote.customer_saleable_return_id, SalesNote.customer_market_return_id, SalesNote.last_action_status AS sales_note_status "
						."FROM `acm_bookkeeping_sales_note` AS SalesNote ";
		
		if ($showCancelledSalesNotes == "Yes") {
			$condition .=" WHERE SalesNote.last_action_status = 'cancelled'";
		} else {
			$condition .=" WHERE SalesNote.last_action_status != 'deleted' AND SalesNote.last_action_status != 'cancelled'";
		}
		
		if ($fromDate != '' && $toDate != '') {
			$condition .= " AND SalesNote.date >= '" . $fromDate . "' AND "
						  ."SalesNote.date <= '" . $toDate . "'";

			if ($locationId != '0') {
				$condition .=" AND SalesNote.location_id = '" . $locationId ."'";
				
				if ($territoryId != '0') {
					$condition .=" AND SalesNote.territory_id = '" . $territoryId ."'";
				}
			} else if ($territoryId != '0') {
				$condition .=" AND SalesNote.territory_id = '" . $territoryId ."'";
			}
		} else if ($locationId != '0') {
			$condition .=" AND SalesNote.location_id = '" . $locationId ."'";
			
			if ($territoryId != '0') {
				$condition .=" AND SalesNote.territory_id = '" . $territoryId ."'";
			}
		} else if ($territoryId != '0') {
			$condition .=" AND SalesNote.territory_id = '" . $territoryId ."'";
		}
		
		//echo $condition;die;
		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
    
    public function getAllSalesNotesAsOptionList() {
		$data = $this->getAllSalesNotes('reference_no','asc');

		$salesNoteList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$salesNoteList[$dataElement->sales_note_id] = $dataElement->reference_no;
			}
		}

		$this->optionList = '';

		foreach($salesNoteList as $key => $salesNote) {
			$this->optionList .= '<option value=' . $key . '>' . $salesNote . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}
}
