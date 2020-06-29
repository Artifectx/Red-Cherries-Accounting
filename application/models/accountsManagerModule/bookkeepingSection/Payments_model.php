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

class Payments_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function addIncomeCheque($data) {
		$this->db->insert('acm_bookkeeping_income_cheque', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function addExpenseCheque($data) {
		$this->db->insert('acm_bookkeeping_expense_cheque', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addIncomeChequeToHistory($data) {
		$this->db->insert('acm_bookkeeping_income_cheque_history', $data);
		$this->db->limit(1);
		$this->db->insert_id();
		return  true;
	}
	
	public function addExpenseChequeToHistory($data) {
		$this->db->insert('acm_bookkeeping_expense_cheque_history', $data);
		$this->db->limit(1);
		$this->db->insert_id();
		return  true;
	}

	public function editIncomeCheque($id, $data) {
		$this->db->where('cheque_id', $id);
		$this->db->update('acm_bookkeeping_income_cheque', $data);
		$this->db->limit(1);
		return  true;
	}
	
	public function editExpenseCheque($id, $data) {
		$this->db->where('cheque_id', $id);
		$this->db->update('acm_bookkeeping_expense_cheque', $data);
		$this->db->limit(1);
		return  true;
	}

	public function getIncomeChequeById($id) {
		$this->db->where('cheque_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getIncomeChequeByChequeNumber($chequeNumber) {
		$this->db->where('cheque_number', $chequeNumber);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getExpenseChequeById($id) {
		$this->db->where('cheque_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_expense_cheque');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getExpenseChequeByChequeNumber($chequeNumber) {
		$this->db->where('cheque_number', $chequeNumber);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_expense_cheque');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function deleteIncomeCheque($id, $status, $user_id) {
		$this->db->where('cheque_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_income_cheque');
		return true;
	}
	
	public function activateIncomeCheque($id, $status, $user_id) {
		$this->db->where('cheque_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_income_cheque');
		return true;
	}
	
	public function deleteExpenseCheque($id, $status,$user_id) {
		$this->db->where('cheque_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_expense_cheque');
		return true;
	}

	public function getIncomeChequeListByTransactionTypeTransactionIdAndReferenceNo($transactionType, $transactionId, $referenceNo) {
		$this->db->where('transaction_type', $transactionType);
		$this->db->where('transaction_id', $transactionId);
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getIncomeChequeStatusOptions() {
		$statusList = array('In_Hand' => $this->lang->line('In Hand'), 
					      'Deposited' => $this->lang->line('Deposited'),
					      'Cleared' => $this->lang->line('Cleared'),
					      'Returned' => $this->lang->line('Returned'));

		$this->optionList = '';

		$count = 1;
		foreach($statusList as $key => $option_name) {
			if ($count == 1) {
				$this->optionList .= '<option value="' . $key . '"' .  'selected="selected">' . $option_name . '</option>';
			} else {
				$this->optionList .= '<option value="' . $key . '">' . $option_name . '</option>';
			}
			$count++;
		}

		return $this->optionList;
	}

	public function getIncomeChequeStatusOptionsWithSavedOption($selectedIndex) {
		$statusList = array('In_Hand' => $this->lang->line('In Hand'), 
					      'Deposited' => $this->lang->line('Deposited'),
					      'Cleared' => $this->lang->line('Cleared'),
					      'Returned' => $this->lang->line('Returned'));

		$this->optionList = '';

		foreach($statusList as $key => $option_name) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $option_name . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $option_name . '</option>';
			}
		}

		return $this->optionList;
	}

	public function getIncomeChequeStatusDropdown() {

		$optionList = $this->getIncomeChequeStatusOptions();

		$html = "<select class='select2 form-control' id='cheque_status_id'>
					{$optionList}
				 </select>";

		return $html;
	}

	public function getIncomeChequeStatusDropdownWithSavedOption($status) {

		$optionList = $this->getIncomeChequeStatusOptionsWithSavedOption($status);

		$html = "<select class='select2 form-control' id='cheque_status_id'>
					{$optionList}
				 </select>";

		return $html;
	}

	public function addCashPayment($data) {
		$this->db->insert('acm_bookkeeping_cash_payment', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function addCashPaymentToHistory($data) {
		$this->db->insert('acm_bookkeeping_cash_payment_history', $data);
		$this->db->limit(1);
		$this->db->insert_id();
		return  true;
	}

	public function editCashPayment($id, $data) {
		$this->db->where('cash_payment_id', $id);
		$this->db->update('acm_bookkeeping_cash_payment', $data);
		$this->db->limit(1);
		return  true;
	}
    
    public function addCreditCardPayment($data) {
		$this->db->insert('acm_bookkeeping_credit_card_payment', $data);
		$this->db->limit(1);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
    
    public function addCreditCardPaymentToHistory($data) {
		$this->db->insert('acm_bookkeeping_credit_card_payment_history', $data);
		$this->db->limit(1);
		$this->db->insert_id();
		return  true;
	}
    
    public function editCreditCardPayment($id, $data) {
		$this->db->where('credit_card_payment_id', $id);
		$this->db->update('acm_bookkeeping_credit_card_payment', $data);
		$this->db->limit(1);
		return  true;
	}

	public function getCashPaymentById($id) {
		$this->db->where('cash_payment_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_cash_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getCashPaymentListForSalesNoteConsideringDeleted($cashPaymentId) {
		$this->db->where('cash_payment_id', $cashPaymentId);
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_cash_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getCashPaymentListForSalesNote($cashPaymentId) {
		$this->db->where('cash_payment_id', $cashPaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_cash_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getChequePaymentListForSalesNoteConsideringDeleted($cashPaymentId) {
		$this->db->where('cheque_id', $cashPaymentId);
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getChequePaymentListForSalesNote($cashPaymentId) {
		$this->db->where('cheque_id', $cashPaymentId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getCardPaymentById($id) {
		$this->db->where('credit_card_payment_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_credit_card_payment');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function deleteCashPayment($id, $status, $user_id) {
		$this->db->where('cash_payment_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_cash_payment');
		return true;
	}
    
    public function deleteCardPayment($id, $status,$user_id) {
		$this->db->where('credit_card_payment_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_credit_card_payment');
		return true;
	}

	public function getCashPaymentListBySalesInvoiceId($id) {
		$this->db->where('sales_invoice_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_cash_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getCardPaymentListBySalesInvoiceId($id) {
		$this->db->where('sales_invoice_id', $id);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_credit_card_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllExternalChequesForPeriod($fromDate, $toDate, $payerId, $locationId, $thirdPartyCheque, $order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);

		if ($fromDate != "" && $toDate != "") {
			$this->db->where('cheque_date >=', $fromDate);
			$this->db->where('cheque_date <=', $toDate);
		}
		
		if ($payerId != "0" && $payerId != "") {
			$this->db->where('payer_id', $payerId);
		}
		
		if ($locationId != "0" && $locationId != "") {
			$this->db->where('acm_bookkeeping_income_cheque.location_id', $locationId);
		}
		
		if ($thirdPartyCheque != '') {
			$this->db->where('acm_bookkeeping_income_cheque.third_party_cheque', $thirdPartyCheque);
		}
	
		$this->db->where('acm_bookkeeping_income_cheque.last_action_status !=','deleted');
		$this->db->limit(100000);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAllInternalChequesForPeriod($fromDate, $toDate, $payeeId, $locationId, $order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);

		if ($fromDate != "" && $toDate != "") {
			$this->db->where('cheque_date >=', $fromDate);
			$this->db->where('cheque_date <=', $toDate);
		}
		
		if ($payeeId != "0" && $payeeId != "") {
			$this->db->where('payee_id', $payeeId);
		}
		
		if ($locationId != "0" && $locationId != "") {
			$this->db->where('acm_bookkeeping_expense_cheque.location_id', $locationId);
		}
		
		$this->db->where('acm_bookkeeping_expense_cheque.last_action_status !=','deleted');
		$this->db->limit(100000);
		$query = $this->db->get('acm_bookkeeping_expense_cheque');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
	public function getCreditCardPaymentListBySalesInvoiceId($salesInvoiceId) {
		$this->db->where('sales_invoice_id', $salesInvoiceId);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_credit_card_payment');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSecondPartyChequesInHand() {
		$this->db->where('third_party_cheque', "No");
		$this->db->where('status','In_Hand');
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getThirdPartyChequesInHand() {
		$this->db->where('third_party_cheque', "Yes");
		$this->db->where('status','In_Hand');
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1000);
		$query = $this->db->get('acm_bookkeeping_income_cheque');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
