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

defined('BASEPATH') OR exit('No direct script access allowed');

class Make_payment_controller extends CI_Controller {

	public function  __construct() {
		parent::__construct();
		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//get employee id
		$this->employee_id = $this->userManagement->getPeopleId();

		//get user name
		$this->user_name = $this->userManagement->getUserName();

		//current date time
		$this->date = date("Y-m-d H:i:s");

		//load language
		$language = $this->userManagement->getUserLanguage($this->user_id);

		$this->lang->load('form_lang', $language);
		$this->lang->load('message', $language);

		//get user theme
		$this->data['theme'] = $this->userManagement->getUserTheme($this->user_id);

		//get user permission
		$this->data = $this->userManagement->getUserPermissions($this->data);

		//Load version number
		$this->data['version_no'] = $this->userManagement->getSystemVersionNumber();

		$this->data['show_footer'] = true;

		//load models
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/bank_model', '', TRUE);
        $this->load->model('accountsManagerModule/adminSection/financial_year_ends_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/payments_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/sales_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/purchase_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/make_payment_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/customer_return_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/supplier_return_note_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);

		$this->load->library('common_library/common_functions');

		$this->load->library('Pdf_reports');

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
	}

	public function index() {
		//set selected menu
		$data_cls['ul_class_bookkeeping_section'] = 'in nav nav-stacked';
		$data_cls['li_class_make_payment'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['make_payment_no_auto_increment_status'] = $this->isMakePaymentNumberAutoIncrementEnabled();

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration
		
		$data['peopleType'] = $this->getPeopleType();
		$data['force_to_select_a_reference_transaction_for_make_a_payment'] = $this->forceToSelectAReferenceTransactionForMakeAPayment();
        $data['default_payee_type'] = $this->getMakeAPaymentDefaultPayeeType();
        $data['default_reference_transaction_type'] = $this->getMakeAPaymentDefaultReferenceTransactionType();
        $data['select_reference_journal_entry_automatically'] = $this->isSelectReferenceJournalEntryAutomaticallyEnabled();
        $data['allow_partial_payment_for_reference_transactions'] = $this->isAllowPartialPaymentForReferenceTransactionsEnabled();

		if(isset($this->data['ACM_Bookkeeping_View_Make_Payment_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/makePayment/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getPeopleType() {

		//get all system modules details
        
        $peopleType = array(
                        array(
                            'people_type'=>'Supplier'
                        ),
                        array(
                            'people_type'=>'Agent'
                        ),
                        array(
                            'people_type'=>'Customer'
                        ),
                        array(
                            'people_type'=>'Sales Rep'
                        ),
                        array(
                            'people_type'=>'Driver'
                        ),
                        array(
                            'people_type'=>'Member'
                        ),
                        array(
                            'people_type'=>'Employee'
                        )
                    );

		return $peopleType;
	}
	
	public function add() {
		if(isset($this->data['ACM_Bookkeeping_Add_Make_Payment_Permissions'])) {
			$makePaymentId = '';
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				
                $currentDate = date('Y-m-d');
                $year = date('Y', strtotime($currentDate));

                $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
                $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
                $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
                $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

                $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

                if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($currentDate)) {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                } else {
                    if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                        $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    } else {
                        $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    }
                }
            
                if ($this->financial_year_ends_model->isPreviousFinancialYearClosed($financialYearStartDate)) {
                
                    $makePaymentReferenceNo = $this->db->escape_str($this->input->post('reference_no'));
                    $makePaymentDate = $this->db->escape_str($this->input->post('make_payment_date'));
                    $payeeType = $this->db->escape_str($this->input->post('payee_type'));
                    $payeeId = $this->db->escape_str($this->input->post('payee_id'));
                    $locationId = $this->db->escape_str($this->input->post('location_id'));
                    $remark = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('remark')));
                    $referenceTransactionData = $this->db->escape_str($this->input->post('reference_transaction_data'));
                    $paymentMethodData = $this->db->escape_str($this->input->post('payment_method_data'));
                    $referenceTransactionCount = $this->db->escape_str($this->input->post('reference_transaction_count'));
                    $paymentMethodCount = $this->db->escape_str($this->input->post('payment_method_count'));

                    $data = array(
                        'reference_no' => $makePaymentReferenceNo,
                        'date' => $makePaymentDate,
                        'payee_type' => $payeeType,
                        'payee_id' => $payeeId,
                        'location_id' => $locationId,
                        'remark' => $remark,
                        'actioned_user_id' => $this->user_id,
                        'added_date' => $this->date,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $makePaymentId = $this->make_payment_model->add($data);

                    $makePaymentClaimAmountTotal = '0.00';
                    $salesNoteAmountTotal = '0.00';
                    $supplierReturnNoteAmountTotal = '0.00';
                    $otherReferenceTransactionDeductionAmountTotal = '0.00';

                    $claimTransactionList = array();

                    if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {

                        for($x = 0; $x < $referenceTransactionCount; $x++) {

                            if (isset($referenceTransactionData[$x])) {
                                $rowCount = sizeof($referenceTransactionData[$x][0]);

                                for($y = 1; $y <= $rowCount; $y++) {

                                    $claimAmount = 0;
                                    $referenceTransactionNote = '';

                                    if ($referenceTransactionData[$x][0][$y] == '2') {
                                        //Sales Note
                                        $journalEntryId = $referenceTransactionData[$x][2][$y];
                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                        $salesNoteReferenceNo = $journalEntry[0]->reference_no;
                                        $salesNote = $this->sales_note_model->getSalesNoteByReferenceNo($salesNoteReferenceNo);

                                        if ($salesNote && sizeof($salesNote) > 0) {

                                            $referenceNo = $salesNote[0]->reference_no;
                                            $salesNoteAmount = $salesNote[0]->balance_payment;
                                            $claimAmount = $salesNoteAmount;

                                            $data = array(
                                                'balance_payment' => '0.00',
                                                'status' => "Claimed",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);

                                            $salesNoteAmountTotal = $salesNoteAmountTotal + $salesNoteAmount;

                                            $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $referenceNo);
                                            $claimTransactionList[] = $claimTransaction;
                                        }
                                    } else if ($referenceTransactionData[$x][0][$y] == '3') {
                                        //Supplier Return Note
                                        $journalEntryId = $referenceTransactionData[$x][2][$y];
                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                        $supplierReturnNoteReferenceNo = $journalEntry[0]->reference_no;
                                        $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteByReferenceNo($supplierReturnNoteReferenceNo);

                                        if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {

                                            $referenceNo = $supplierReturnNote[0]->reference_no;
                                            $supplierReturnNoteAmount = $supplierReturnNote[0]->balance_payment;
                                            $claimAmount = $supplierReturnNoteAmount;

                                            $data = array(
                                                'balance_payment' => '0.00',
                                                'status' => "Claimed",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);

                                            $supplierReturnNoteAmountTotal = $supplierReturnNoteAmountTotal + $supplierReturnNoteAmount;

                                            $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $referenceNo);
                                            $claimTransactionList[] = $claimTransaction;
                                        }
                                    } else if ($referenceTransactionData[$x][0][$y] == '5') {
                                        if ($referenceTransactionData[$x][3][$y] == "Deduction") {
                                            $journalEntryId = $referenceTransactionData[$x][2][$y];
                                            $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                            $transactionAmount = 0;
                                            if ($glTransactions && sizeof($glTransactions) > 0) {
                                                if ($glTransactions[0]->debit_value > 0) {
                                                    $transactionAmount = $glTransactions[0]->debit_value;
                                                } else if ($glTransactions[0]->credit_value > 0) {
                                                    $transactionAmount = $glTransactions[0]->credit_value;
                                                }
                                            }

                                            $claimAmount = $transactionAmount;

                                            $data = array(
                                                'status' => "Closed",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->editJournalEntry($journalEntryId, $data);

                                            $otherReferenceTransactionDeductionAmountTotal = $otherReferenceTransactionDeductionAmountTotal + $transactionAmount;

                                            $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => '');
                                            $claimTransactionList[] = $claimTransaction;

                                            $referenceTransactionNote = "Deduction";
                                        }
                                    }

                                    $data = array(
                                        'make_payment_id' => $makePaymentId,
                                        'reference_transaction_type_id' => $referenceTransactionData[$x][0][$y],
                                        'reference_transaction_id' => $referenceTransactionData[$x][1][$y],
                                        'reference_transaction_note' => $referenceTransactionNote,
                                        'reference_journal_entry_id' => $referenceTransactionData[$x][2][$y],
                                        'claim_amount' => $claimAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->make_payment_model->addMakePaymentReferenceTransaction($data);
                                }
                            }
                        }
                    }

                    $makePaymentClaimAmountTotal = $salesNoteAmountTotal + $supplierReturnNoteAmountTotal + $otherReferenceTransactionDeductionAmountTotal;
                    $pendingClaimAmountTotalForPurchaseNotes = $supplierReturnNoteAmountTotal + $otherReferenceTransactionDeductionAmountTotal;
                    $pendingClaimAmountTotalForCustomerReturnNotes = $salesNoteAmountTotal + $otherReferenceTransactionDeductionAmountTotal;

                    if ($paymentMethodData && sizeof($paymentMethodData) > 0) {

                        $totalPaid = 0;

                        for($x = 0; $x < $paymentMethodCount; $x++) {

                            if (isset($paymentMethodData[$x])) {
                                $rowCount = sizeof($paymentMethodData[$x][0]);

                                $remainingPaymentAmount = 0;

                                for($y = 1; $y <= $rowCount; $y++) {
                                    $paymentMethod = $paymentMethodData[$x][0][$y];
                                    $paymentAccountId = $paymentMethodData[$x][1][$y];
                                    $chequeId = $paymentMethodData[$x][2][$y];
                                    $bankId = $paymentMethodData[$x][3][$y];
                                    $chequeNumber = $paymentMethodData[$x][4][$y];
                                    $chequeDate = $paymentMethodData[$x][5][$y];
                                    $amount = $paymentMethodData[$x][6][$y];

                                    $remainingPaymentAmount = $amount;

                                    $paymentId = 0;
                                    $chequeType = '';

                                    $referenceTransactionTypeId = '';
                                    $referenceTransactionId = '';
                                    $referenceJournalEntryId = '';

                                    if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {

                                        for($p = 0; $p < $referenceTransactionCount; $p++) {

                                            if (isset($referenceTransactionData[$p])) {
                                                $rowCountInner = sizeof($referenceTransactionData[$p][0]);

                                                for($q = 1; $q <= $rowCountInner; $q++) {

                                                    $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                                    $today = date("Y-m-d");

                                                    if ($referenceTransactionData[$p][0][$q] == '1') {
                                                        //Purchase Note
                                                        $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                                        $purchaseNoteReferenceNo = $journalEntry[0]->reference_no;
                                                        $purchaseNote = $this->purchase_note_model->getPurchaseNoteByReferenceNo($purchaseNoteReferenceNo, '');

                                                        if ($purchaseNote && sizeof($purchaseNote) > 0) {

                                                            $purchaseNoteId = $purchaseNote[0]->purchase_note_id;

                                                            $referenceTransactionTypeId = '1';
                                                            $referenceTransactionId = $purchaseNoteId;
                                                            $referenceJournalEntryId = $journalEntryId;

                                                            $totalAmount = $purchaseNote[0]->amount;
                                                            $paidCashAmount = $purchaseNote[0]->cash_payment_amount;
                                                            $paidChequeAmount = $purchaseNote[0]->cheque_payment_amount;
                                                            $paidCreditCardAmount = $purchaseNote[0]->credit_card_payment_amount;
                                                            $supplierReturnAmountClaimed = $purchaseNote[0]->supplier_return_note_claimed;
                                                            $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $supplierReturnAmountClaimed;

                                                            $currentBalancePayment = $totalAmount - $totalPaid;

                                                            if (round($currentBalancePayment) > 0) {

                                                                $amountToClaimFromPayment = 0;
                                                                $amountToClaimFromPurchaseNoteAmount = 0;

                                                                if ($pendingClaimAmountTotalForPurchaseNotes > 0) {

                                                                    if ($currentBalancePayment >= $pendingClaimAmountTotalForPurchaseNotes) {
                                                                        $amountToClaimFromPayment = $currentBalancePayment - $pendingClaimAmountTotalForPurchaseNotes;

                                                                        if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                            $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                        }

                                                                        $amountToClaimFromPurchaseNoteAmount = $pendingClaimAmountTotalForPurchaseNotes;
                                                                        $newBalancePayment = $totalAmount - ($totalPaid + $amountToClaimFromPayment + $pendingClaimAmountTotalForPurchaseNotes);
                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                        $pendingClaimAmountTotalForPurchaseNotes = 0;
                                                                    } else {
                                                                        $amountToClaimFromPurchaseNoteAmount = $currentBalancePayment;
                                                                        $newBalancePayment = $totalAmount - ($totalPaid + $amountToClaimFromPurchaseNoteAmount);
                                                                        $pendingClaimAmountTotalForPurchaseNotes = $pendingClaimAmountTotalForPurchaseNotes - $amountToClaimFromPurchaseNoteAmount;
                                                                    }
                                                                } else {
                                                                    $newBalancePayment = $totalAmount - ($totalPaid + $remainingPaymentAmount);
                                                                }

                                                                $paidAmount = 0;

                                                                if ($newBalancePayment < 0) {
                                                                    $newBalancePayment = 0;
                                                                }

                                                                $status = "Open";
                                                                $paymentMethodFullyConsumed = false;

                                                                if ($newBalancePayment == 0) {
                                                                    $status = "Claimed";
                                                                } else {
                                                                    $paymentMethodFullyConsumed = true;
                                                                } 

                                                                if ($amountToClaimFromPurchaseNoteAmount > 0) {
                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'supplier_return_note_claimed' => $amountToClaimFromPurchaseNoteAmount + $supplierReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Purchase Note',
                                                                            'transaction_id' => $purchaseNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                    } else if ($paymentMethod == 'Cheque Payment') {

                                                                        $chequeType = "Expense Cheque";
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'supplier_return_note_claimed' => $amountToClaimFromPurchaseNoteAmount + $supplierReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Purchase Note',
                                                                            'transaction_id' => $purchaseNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $purchaseNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                        $chequeType = "Expense Cheque";
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'supplier_return_note_claimed' => $amountToClaimFromPurchaseNoteAmount + $supplierReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        //Mark second party/third party cheque as paid

                                                                        $incomeChequeData = array(
                                                                            'status' => "Paid",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                        $primeEntryBooksToUpdate = '';
                                                                        if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                            $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                        }

                                                                        //Add a new expense cheque using party/third party cheque
                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Purchase Note',
                                                                            'transaction_id' => $purchaseNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $purchaseNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        }

                                                                        if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $today,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    $transactionStatus = "No";

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    $this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);
                                                                } else {
                                                                    if ($currentBalancePayment > $remainingPaymentAmount && $remainingPaymentAmount > 0) {

                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);

                                                                        $remainingPaymentAmount = 0;
                                                                    } else if ($currentBalancePayment > 0 && $currentBalancePayment <= $remainingPaymentAmount) {
                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);

                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                    }
                                                                }

                                                                $claimAmount = 0;

                                                                if ($makePaymentClaimAmountTotal >= $amountToClaimFromPurchaseNoteAmount) {
                                                                    $claimAmount = $amountToClaimFromPurchaseNoteAmount;
                                                                    $makePaymentClaimAmountTotal = $makePaymentClaimAmountTotal - $amountToClaimFromPurchaseNoteAmount;
                                                                } else if ($makePaymentClaimAmountTotal > 0) {
                                                                    $claimAmount = $makePaymentClaimAmountTotal;
                                                                    $makePaymentClaimAmountTotal = 0;
                                                                }

                                                                $primeEntryBooksToUpdateForSupplierReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForMakePaymentTransactionClaim();

                                                                //Post journal entry for supplier return note claim for purchase note
                                                                if ($claimAmount > 0 && $journalEntryId != '') {

                                                                    if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                        $count = 0;
                                                                        $arrayElementsToUnset = array();
                                                                        foreach($claimTransactionList as $claimTransactionRow) {
                                                                            if ($claimTransactionRow[1] <= $claimAmount) {

                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForSupplierReturnNoteClaim, '', $makePaymentDate, 
                                                                                        $purchaseNoteReferenceNo, '1', $purchaseNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payeeId, 
                                                                                        $claimTransactionRow[1]);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $arrayElementsToUnset[] = $count;
                                                                                $claimAmount = $claimAmount - $claimTransactionRow[1];
                                                                            } else {
                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForSupplierReturnNoteClaim, '', $makePaymentDate, 
                                                                                        $purchaseNoteReferenceNo, '1', $purchaseNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payeeId, 
                                                                                        $claimAmount);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $claimTransactionRow[1] = $claimTransactionRow[1] - $claimAmount;
                                                                                $claimAmount = 0;
                                                                            }

                                                                            $count++;
                                                                        }

                                                                        if ($arrayElementsToUnset && sizeof($arrayElementsToUnset) > 0) {
                                                                            foreach($arrayElementsToUnset as $row) {
                                                                                unset($claimTransactionList[$row]);
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if ($paidAmount > 0) {
                                                                    
                                                                    $cashPaymentId = 0;

                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $cashPaymentId = $paymentId;
                                                                    }

                                                                    $makePaymentMethodRecordData = array(
                                                                        'make_payment_id' => $makePaymentId,
                                                                        'payment_method' => $paymentMethod,
                                                                        'cash_payment_id' => $cashPaymentId,
                                                                        'payment_account_id' => $paymentAccountId,
                                                                        'cheque_type' => $chequeType,
                                                                        'cheque_id' => $chequeId,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $makePaymentMethodId = $this->make_payment_model->addMakePaymentMethodRecord($makePaymentMethodRecordData);

                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                    $primeEntryBookIds = '';
                                                                    if ($paymentMethod == "Cash Payment") {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentCashTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    } else if ($paymentMethod == "Cheque Payment") {

                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $paymentAccountId;
                                                                        }
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentSecondOrThirdPartyChequeTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                        if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                            foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                    'reference_transaction_id' => $referenceTransactionId,
                                                                                    'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                    'description' => $this->lang->line('Journal entry for Make Payment number : ') . $makePaymentReferenceNo,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $makePaymentJournalEntry = array(
                                                                                    'make_payment_id' => $makePaymentId,
                                                                                    'make_payment_method_id' => $makePaymentMethodId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->make_payment_model->addMakePaymentJournalEntry($makePaymentJournalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    if ($paymentMethod == "Cheque Payment") {
                                                                                        $transactionStatus = "No";
                                                                                    } else {
                                                                                        $transactionStatus = "Yes";
                                                                                    }

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        } 

                                                                        $result = 'ok';
                                                                    } else {
                                                                        $result = 'incorrect_prime_entry_book_selected_for_make_payment_transaction';
                                                                        break;
                                                                    }
                                                                }

                                                                if ($paymentMethodFullyConsumed == true) {
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    } else if ($referenceTransactionData[$p][0][$q] == '4') {
                                                        //Customer Return Note
                                                        $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                                        $customerReturnNoteReferenceNo = $journalEntry[0]->reference_no;
                                                        $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteByReferenceNo($customerReturnNoteReferenceNo);

                                                        if ($customerReturnNote && sizeof($customerReturnNote) > 0) {

                                                            $customerReturnNoteId = $customerReturnNote[0]->customer_return_note_id;

                                                            $referenceTransactionTypeId = '4';
                                                            $referenceTransactionId = $customerReturnNoteId;
                                                            $referenceJournalEntryId = $journalEntryId;

                                                            $totalAmount = $customerReturnNote[0]->amount;
                                                            $paidCashAmount = $customerReturnNote[0]->cash_payment_amount;
                                                            $paidChequeAmount = $customerReturnNote[0]->cheque_payment_amount;
                                                            $paidCreditCardAmount = $customerReturnNote[0]->credit_card_payment_amount;
                                                            $salesAmountClaimed = $customerReturnNote[0]->sales_note_claimed;
                                                            $totalReceivable = $totalAmount;
                                                            $totalReceived = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $salesAmountClaimed;

                                                            $currentBalancePayment = $totalReceivable - $totalReceived;

                                                            if (round($currentBalancePayment) > 0) {

                                                                $amountToClaimFromPayment = 0;
                                                                $amountToClaimFromCustomerReturnAmount = 0;

                                                                if ($pendingClaimAmountTotalForCustomerReturnNotes > 0) {

                                                                    if ($currentBalancePayment >= $pendingClaimAmountTotalForCustomerReturnNotes) {
                                                                        $amountToClaimFromPayment = $currentBalancePayment - $pendingClaimAmountTotalForCustomerReturnNotes;

                                                                        if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                            $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                        }

                                                                        $amountToClaimFromCustomerReturnAmount = $pendingClaimAmountTotalForCustomerReturnNotes;
                                                                        $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromPayment + $pendingClaimAmountTotalForCustomerReturnNotes);
                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                        $pendingClaimAmountTotalForCustomerReturnNotes = 0;
                                                                    } else {
                                                                        $amountToClaimFromCustomerReturnAmount = $currentBalancePayment;
                                                                        $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromCustomerReturnAmount);
                                                                        $pendingClaimAmountTotalForCustomerReturnNotes = $pendingClaimAmountTotalForCustomerReturnNotes - $amountToClaimFromCustomerReturnAmount;
                                                                    }
                                                                } else {
                                                                    $newBalancePayment = $totalReceivable - ($totalReceived + $remainingPaymentAmount);
                                                                }

                                                                $paidAmount = 0;

                                                                if ($newBalancePayment < 0) {
                                                                    $newBalancePayment = 0;
                                                                }

                                                                $status = "Open";
                                                                $paymentMethodFullyConsumed = false;

                                                                if ($newBalancePayment == 0) {
                                                                    $status = "Claimed";
                                                                } else {
                                                                    $paymentMethodFullyConsumed = true;
                                                                }

                                                                if ($amountToClaimFromCustomerReturnAmount > 0) {
                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'sales_note_claimed' => $amountToClaimFromCustomerReturnAmount + $salesAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Customer Return',
                                                                            'transaction_id' => $customerReturnNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                    } else if ($paymentMethod == 'Cheque Payment') {
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'sales_note_claimed' => $amountToClaimFromCustomerReturnAmount + $salesAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Customer Return Note',
                                                                            'transaction_id' => $customerReturnNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $customerReturnNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                        $chequeType = "Expense Cheque";
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'sales_note_claimed' => $amountToClaimFromCustomerReturnAmount + $salesAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        //Mark second party/third party cheque as paid

                                                                        $incomeChequeData = array(
                                                                            'status' => "Paid",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                        $primeEntryBooksToUpdate = '';
                                                                        if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                            $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                        }

                                                                        //Add a new expense cheque using party/third party cheque
                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Customer Return Note',
                                                                            'transaction_id' => $customerReturnNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $customerReturnNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        }

                                                                        if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $today,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    $transactionStatus = "No";

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);
                                                                } else {
                                                                    if ($currentBalancePayment > $remainingPaymentAmount && $remainingPaymentAmount > 0) {

                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);

                                                                        $remainingPaymentAmount = 0;
                                                                    } else if ($currentBalancePayment > 0 && $currentBalancePayment <= $remainingPaymentAmount) {
                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);

                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                    }
                                                                }

                                                                $claimAmount = 0;

                                                                if ($makePaymentClaimAmountTotal >= $amountToClaimFromCustomerReturnAmount) {
                                                                    $claimAmount = $amountToClaimFromCustomerReturnAmount;
                                                                    $makePaymentClaimAmountTotal = $makePaymentClaimAmountTotal - $amountToClaimFromCustomerReturnAmount;
                                                                } else if ($makePaymentClaimAmountTotal > 0) {
                                                                    $claimAmount = $makePaymentClaimAmountTotal;
                                                                    $makePaymentClaimAmountTotal = 0;
                                                                }

                                                                $primeEntryBooksToUpdateForCustomerSalesNoteClaim = $this->getPrimeEntryBooksToUpdateForMakePaymentTransactionClaim();

                                                                //Post journal entry for sales note claim for customer return note
                                                                if ($claimAmount > 0 && $journalEntryId != '') {

                                                                    if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                        $count = 0;
                                                                        $arrayElementsToUnset = array();
                                                                        foreach($claimTransactionList as $claimTransactionRow) {
                                                                            if ($claimTransactionRow[1] <= $claimAmount) {

                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSalesNoteClaim, '', $makePaymentDate, 
                                                                                        $customerReturnNoteReferenceNo, '4', $customerReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payeeId, 
                                                                                        $claimTransactionRow[1]);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $arrayElementsToUnset[] = $count;
                                                                                $claimAmount = $claimAmount - $claimTransactionRow[1];
                                                                            } else {
                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSalesNoteClaim, '', $makePaymentDate, 
                                                                                        $customerReturnNoteReferenceNo, '4', $customerReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payeeId, 
                                                                                        $claimAmount);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $claimTransactionRow[1] = $claimTransactionRow[1] - $claimAmount;
                                                                                $claimAmount = 0;
                                                                            }

                                                                            $count++;
                                                                        }

                                                                        if ($arrayElementsToUnset && sizeof($arrayElementsToUnset) > 0) {
                                                                            foreach($arrayElementsToUnset as $row) {
                                                                                unset($claimTransactionList[$row]);
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if ($paidAmount > 0) {
                                                                    
                                                                    $cashPaymentId = 0;

                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $cashPaymentId = $paymentId;
                                                                    }

                                                                    $makePaymentMethodRecordData = array(
                                                                        'make_payment_id' => $makePaymentId,
                                                                        'payment_method' => $paymentMethod,
                                                                        'cash_payment_id' => $cashPaymentId,
                                                                        'payment_account_id' => $paymentAccountId,
                                                                        'cheque_type' => $chequeType,
                                                                        'cheque_id' => $chequeId,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $makePaymentMethodId = $this->make_payment_model->addMakePaymentMethodRecord($makePaymentMethodRecordData);

                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                    $primeEntryBookIds = '';
                                                                    if ($paymentMethod == "Cash Payment") {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentCashTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    } else if ($paymentMethod == "Cheque Payment") {

                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $paymentAccountId;
                                                                        }
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentSecondOrThirdPartyChequeTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                        if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                            foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                    'reference_transaction_id' => $referenceTransactionId,
                                                                                    'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                    'description' => $this->lang->line('Journal entry for Make Payment number : ') . $makePaymentReferenceNo,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $makePaymentJournalEntry = array(
                                                                                    'make_payment_id' => $makePaymentId,
                                                                                    'make_payment_method_id' => $makePaymentMethodId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->make_payment_model->addMakePaymentJournalEntry($makePaymentJournalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    if ($paymentMethod == "Cheque Payment") {
                                                                                        $transactionStatus = "No";
                                                                                    } else {
                                                                                        $transactionStatus = "Yes";
                                                                                    }

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        } 

                                                                        $result = 'ok';
                                                                    } else {
                                                                        $result = 'incorrect_prime_entry_book_selected_for_make_payment_transaction';
                                                                        break;
                                                                    }
                                                                }

                                                                if ($paymentMethodFullyConsumed == true) {
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    } else if ($referenceTransactionData[$p][0][$q] == '5') {

                                                        $journalEntryId = $referenceTransactionData[$p][2][$q];

                                                        $referenceJournalEntryId = $journalEntryId;

                                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                                        $balanceAmount = $journalEntry[0]->balance_amount;

                                                        if ($balanceAmount == 0) {
                                                            $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId);

                                                            $transactionAmount = 0;
                                                            if ($glTransactions && sizeof($glTransactions) > 0) {
                                                                if ($glTransactions[0]->debit_value > 0) {
                                                                    $balanceAmount = $glTransactions[0]->debit_value;
                                                                } else if ($glTransactions[0]->credit_value > 0) {
                                                                    $balanceAmount = $glTransactions[0]->credit_value;
                                                                }
                                                            }
                                                        }

                                                        $journalEntryStatus = "Open";
                                                        $paymentMethodFullyConsumed = false;

                                                        if ($balanceAmount > $remainingPaymentAmount) {
                                                            $paidAmount = $remainingPaymentAmount;
                                                            $balanceAmount = $balanceAmount - $paidAmount;
                                                            $remainingPaymentAmount = 0;
                                                            $paymentMethodFullyConsumed = true;
                                                        } else {
                                                            $paidAmount = $balanceAmount;
                                                            $balanceAmount = 0;
                                                            $remainingPaymentAmount = $remainingPaymentAmount - $balanceAmount;

                                                            $journalEntryStatus = "Closed";
                                                        }

                                                        $journalEntryData = array(
                                                            'balance_amount' => $balanceAmount,
                                                            'status' => $journalEntryStatus,
                                                            'actioned_user_id' => $this->user_id,
                                                            'action_date' => $this->date,
                                                            'last_action_status' => 'edited'
                                                        );

                                                        $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);

                                                        if ($paymentMethod == 'Cash Payment') {

                                                            $cashPaymentData = array(
                                                                'date' => $makePaymentDate,
                                                                'amount' => $amount,
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'edited'
                                                            );

                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                        } else if ($paymentMethod == 'Cheque Payment') {

                                                            $expenseChequeData = array(
                                                                'date' => $makePaymentDate,
                                                                'payee_id' => $payeeId,
                                                                'location_id' => $locationId,
                                                                'cheque_number' => $chequeNumber,
                                                                'bank' => $bankId,
                                                                'cheque_date' => $chequeDate,
                                                                'amount' => $amount,
                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                'status' => "Open",
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'added'
                                                            );

                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                            $chequeType = "Expense Cheque";

                                                            //Mark second party/third party cheque as paid

                                                            $incomeChequeData = array(
                                                                'status' => "Paid",
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'edited'
                                                            );

                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                            $primeEntryBooksToUpdate = '';
                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                            }

                                                            //Add a new expense cheque using party/third party cheque
                                                            $expenseChequeData = array(
                                                                'date' => $makePaymentDate,
                                                                'payee_id' => $payeeId,
                                                                'location_id' => $locationId,
                                                                'cheque_number' => $chequeNumber,
                                                                'bank' => $bankId,
                                                                'cheque_date' => $chequeDate,
                                                                'amount' => $amount,
                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                'status' => "Open",
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'added'
                                                            );

                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                    }
                                                                }
                                                            } else {
                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                            }

                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                    $journalEntry = array(
                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                        'transaction_date' => $today,
                                                                        'reference_no' => $chequeNumber,
                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                        'location_id' => $locationId,
                                                                        'payee_payer_type' => $payeeType,
                                                                        'payee_payer_id' => $payeeId,
                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                        'post_type' => "Indirect",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                    $amount = str_replace(',', '', $amount);

                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                        $transactionStatus = "No";

                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                            $generalLedgerTransaction = array(
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $today,
                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                'debit_value' => $amount,
                                                                                'transaction_complete' => $transactionStatus,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );
                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                            $generalLedgerTransaction = array(
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $today,
                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                'credit_value' => $amount,
                                                                                'transaction_complete' => $transactionStatus,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );
                                                                        }

                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                        //Same time add the data to previous years record table.
                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        if ($paidAmount > 0) {
                                                            
                                                            $cashPaymentId = 0;

                                                            if ($paymentMethod == 'Cash Payment') {
                                                                $cashPaymentId = $paymentId;
                                                            }

                                                            $makePaymentMethodRecordData = array(
                                                                'make_payment_id' => $makePaymentId,
                                                                'payment_method' => $paymentMethod,
                                                                'cash_payment_id' => $cashPaymentId,
                                                                'payment_account_id' => $paymentAccountId,
                                                                'cheque_type' => $chequeType,
                                                                'cheque_id' => $chequeId,
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'added'
                                                            );

                                                            $makePaymentMethodId = $this->make_payment_model->addMakePaymentMethodRecord($makePaymentMethodRecordData);

                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                            $primeEntryBookIds = '';
                                                            if ($paymentMethod == "Cash Payment") {
                                                                $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentCashTransaction();

                                                                if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $primeEntryBookId;
                                                                        }
                                                                    }
                                                                }
                                                            } else if ($paymentMethod == "Cheque Payment") {

                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                } else {
                                                                    $primeEntryBookIds[] = $paymentAccountId;
                                                                }
                                                            } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                                                                $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentSecondOrThirdPartyChequeTransaction();

                                                                if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $primeEntryBookId;
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                    foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                        $journalEntry = array(
                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                            'transaction_date' => $makePaymentDate,
                                                                            'reference_no' => $makePaymentReferenceNo,
                                                                            'should_have_a_payment_journal_entry' => "No",
                                                                            'location_id' => $locationId,
                                                                            'payee_payer_type' => $payeeType,
                                                                            'payee_payer_id' => $payeeId,
                                                                            'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                            'description' => $this->lang->line('Journal entry for Make Payment number : ') . $makePaymentReferenceNo,
                                                                            'post_type' => "Indirect",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                        $makePaymentJournalEntry = array(
                                                                            'make_payment_id' => $makePaymentId,
                                                                            'make_payment_method_id' => $makePaymentMethodId,
                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                            'journal_entry_id' => $journalEntryId,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $this->make_payment_model->addMakePaymentJournalEntry($makePaymentJournalEntry);

                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                        $amount = str_replace(',', '', $amount);

                                                                        foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                            if ($paymentMethod == "Cheque Payment") {
                                                                                $transactionStatus = "No";
                                                                            } else {
                                                                                $transactionStatus = "Yes";
                                                                            }

                                                                            if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                $generalLedgerTransaction = array(
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                    'debit_value' => $paidAmount,
                                                                                    'transaction_complete' => $transactionStatus,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );
                                                                            } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                $generalLedgerTransaction = array(
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                    'credit_value' => $paidAmount,
                                                                                    'transaction_complete' => $transactionStatus,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );
                                                                            }

                                                                            $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                            //Same time add the data to previous years record table.
                                                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                        }
                                                                    }
                                                                } 

                                                                $result = 'ok';
                                                            } else {
                                                                $result = 'incorrect_prime_entry_book_selected_for_make_payment_transaction';
                                                                break;
                                                            }
                                                        }

                                                        if ($paymentMethodFullyConsumed == true) {
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $result = "previous_financial_year_not_closed";
                }
			}

			echo json_encode(array('result' => $result));
		}
	}

	public function editMakePaymentData() {
		
		if(isset($this->data['ACM_Bookkeeping_Edit_Make_Payment_Permissions'])) {
            
            $result = '';
			$makePaymentId = '';
			
			if ($this->form_validation->run() == FALSE) {
				$result = validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNoChanged = false;
				$makePaymentDateChanged = false;
				$remarkChanged = false;

				//Read New Make Payment Data
				$makePaymentId = $this->db->escape_str($this->input->post('id'));
                
                $makePayment = $this->make_payment_model->getMakePaymentById($makePaymentId);
                $makePaymentTransactionDate = $makePayment[0]->date;
                
                $financialYear = $this->financial_year_ends_model->getFinancialYearOfSelectedTransaction($makePaymentTransactionDate);
                
                if ($financialYear[0]->year_end_process_status != "Closed") {
                
                    $makePaymentReferenceNo = $this->db->escape_str($this->input->post('reference_no'));
                    $makePaymentDate = $this->db->escape_str($this->input->post('make_payment_date'));
                    $remark = $this->db->escape_str($this->input->post('remark'));
                    $remark = preg_replace('~\\\n~',"\r\n", $remark);
                    $referenceTransactionData = $this->db->escape_str($this->input->post('reference_transaction_data'));
                    $paymentMethodData = $this->db->escape_str($this->input->post('payment_method_data'));
                    $referenceTransactionCount = $this->db->escape_str($this->input->post('reference_transaction_count'));
                    $paymentMethodCount = $this->db->escape_str($this->input->post('payment_method_count'));



                    $payeeType = $makePayment[0]->payee_type;
                    $payeeId = $makePayment[0]->payee_id;
                    $locationId = $makePayment[0]->location_id;

                    if ($makePayment[0]->reference_no != $makePaymentReferenceNo) {$referenceNoChanged = true;}
                    if ($makePayment[0]->date != $makePaymentDate) {$makePaymentDateChanged = true;}
                    if ($makePayment[0]->remark != $remark) {$remarkChanged = true;}

                    if ($referenceNoChanged || $makePaymentDateChanged || $remarkChanged) {

                        $makePaymentDataHistory = array(
                            'make_payment_id' => $makePayment[0]->make_payment_id,
                            'reference_no' => $makePayment[0]->reference_no,
                            'date' => $makePayment[0]->date,
                            'payee_type' => $makePayment[0]->payee_type,
                            'payee_id' => $makePayment[0]->payee_id,
                            'location_id' => $makePayment[0]->location_id,
                            'remark' => $makePayment[0]->remark,
                            'actioned_user_id' => $makePayment[0]->actioned_user_id,
                            'added_date' => $makePayment[0]->added_date,
                            'action_date' => $makePayment[0]->action_date,
                            'last_action_status' => $makePayment[0]->last_action_status,
                        );

                        $this->make_payment_model->addMakePaymentDataToHistory($makePaymentDataHistory);

                        $makePaymentDatanew = array(
                            'reference_no' => $makePaymentReferenceNo,
                            'date' => $makePaymentDate,
                            'remark' => $remark,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->make_payment_model->editMakePaymentData($makePaymentId, $makePaymentDatanew);
                    }

                    $paymentReferenceList = $this->make_payment_model->getMakePaymentReferenceTransactionList($makePaymentId);
                    $paymentMethodList = $this->make_payment_model->getMakePaymentMethodList($makePaymentId);
                    $refundClaimAmountTotal = $this->make_payment_model->getMakePaymentClaimAmountTotal($makePaymentId);

                    if ($paymentMethodList && sizeof($paymentMethodList) > 0) {

                        foreach ($paymentMethodList as $paymentMethodRecord) {

                            $paymentMethod = $paymentMethodRecord->payment_method;
                            $cashPaymentId = $paymentMethodRecord->cash_payment_id;
                            $chequeId = $paymentMethodRecord->cheque_id;

                            $cashAmount = 0;
                            $chequeAmount = 0;
                            $status = "deleted";

                            if ($paymentMethod == "Cash Payment") {
                                $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
                                $cashAmount = $cashPayment[0]->amount;
                                $this->payments_model->deleteCashPayment($cashPaymentId, $status, $this->user_id);
                            } else if ($paymentMethod == "Cheque Payment") {
                                $expenseCheque = $this->payments_model->getExpenseChequeById($chequeId);
                                $chequeAmount = $expenseCheque[0]->amount;
                                $chequeNumber = $expenseCheque[0]->cheque_number;
                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $expenseCheque[0]->cheque_payment_prime_entry_book_id;

                                $makePaymentInSecondOrThirdPartyJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($makePaymentInSecondOrThirdPartyPrimeEntryBookId, $chequeNumber);

                                if ($makePaymentInSecondOrThirdPartyJournalEntries && sizeof($makePaymentInSecondOrThirdPartyJournalEntries) > 0) {
                                    foreach($makePaymentInSecondOrThirdPartyJournalEntries as $makePaymentInSecondOrThirdPartyJournalEntry) {
                                        $journalEntryId = $makePaymentInSecondOrThirdPartyJournalEntry->journal_entry_id;

                                        $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            foreach($glTransactions as $glTransaction) {
                                                $chartOfAccountId = $glTransaction->chart_of_account_id;

                                                $generalLedgerTransaction = array(
                                                    'transaction_complete' => "No",
                                                    'actioned_user_id' => $this->user_id,
                                                    'action_date' => $this->date,
                                                    'last_action_status' => 'deleted'
                                                );

                                                $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $generalLedgerTransaction);
                                            }
                                        }

                                        $journalEntry = array(
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'deleted'
                                        );

                                        $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntry);
                                    }
                                }

                                $this->payments_model->deleteExpenseCheque($chequeId, $status, $this->user_id);
                            } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                                $expenseCheque = $this->payments_model->getExpenseChequeById($chequeId);
                                $chequeAmount = $expenseCheque[0]->amount;
                                $chequeNumber = $expenseCheque[0]->cheque_number;
                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $expenseCheque[0]->cheque_payment_prime_entry_book_id;

                                $makePaymentInSecondOrThirdPartyJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($makePaymentInSecondOrThirdPartyPrimeEntryBookId, $chequeNumber);

                                if ($makePaymentInSecondOrThirdPartyJournalEntries && sizeof($makePaymentInSecondOrThirdPartyJournalEntries) > 0) {
                                    foreach($makePaymentInSecondOrThirdPartyJournalEntries as $makePaymentInSecondOrThirdPartyJournalEntry) {
                                        $journalEntryId = $makePaymentInSecondOrThirdPartyJournalEntry->journal_entry_id;

                                        $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            foreach($glTransactions as $glTransaction) {
                                                $chartOfAccountId = $glTransaction->chart_of_account_id;

                                                $generalLedgerTransaction = array(
                                                    'transaction_complete' => "No",
                                                    'actioned_user_id' => $this->user_id,
                                                    'action_date' => $this->date,
                                                    'last_action_status' => 'deleted'
                                                );

                                                $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $generalLedgerTransaction);
                                            }
                                        }

                                        $journalEntry = array(
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'deleted'
                                        );

                                        $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntry);
                                    }
                                }

                                $this->payments_model->deleteExpenseCheque($chequeId, $status, $this->user_id);

                                //Mark coresponding income cheque (if available) is In Hand
                                $incomeCheque = $this->payments_model->getIncomeChequeByChequeNumber($chequeNumber);
                                $chequeId = $incomeCheque[0]->cheque_id;

                                if ($incomeCheque && sizeof($incomeCheque) > 0) {
                                    $incomeChequeData = array(
                                        'status' => "In_Hand",
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                                }
                            }

                            //Reverse current reference transactions changes from the receive payment
                            if ($paymentReferenceList && sizeof($paymentReferenceList) > 0) {

                                foreach ($paymentReferenceList as $paymentReference) {

                                    $referenceTransactionTypeId = $paymentReference->reference_transaction_type_id;
                                    $referenceTransactionId = $paymentReference->reference_transaction_id;
                                    $referenceTransactionNote = $paymentReference->reference_transaction_note;
                                    $referenceTransactionClaimAmount = $paymentReference->claim_amount;

                                    if ($referenceTransactionTypeId == '1') {
                                        //Purchase Note
                                        $successfulTransaction = false;

                                        $purchaseNoteId = $referenceTransactionId;
                                        $purchaseNote = $this->purchase_note_model->getPurchaseNoteById($purchaseNoteId);

                                        $currentCashPayment = $purchaseNote[0]->cash_payment_amount;
                                        $currentChequePayment = $purchaseNote[0]->cheque_payment_amount;
                                        $currentBalancePayment = $purchaseNote[0]->balance_payment;
                                        $claimAmountTotal = $purchaseNote[0]->supplier_return_note_claimed;

                                        if ($refundClaimAmountTotal >= $claimAmountTotal) {
                                            $refundClaimAmountTotal = $refundClaimAmountTotal - $claimAmountTotal;
                                            $currentBalancePayment = $currentBalancePayment + $claimAmountTotal;
                                            $claimAmountTotal = 0;
                                        } else {
                                            $claimAmountTotal = $claimAmountTotal - $refundClaimAmountTotal;
                                            $currentBalancePayment = $currentBalancePayment + $refundClaimAmountTotal;
                                            $refundClaimAmountTotal = 0;
                                        }

                                        if ($currentCashPayment >= $cashAmount) {
                                            $currentCashPayment = $currentCashPayment - $cashAmount;
                                            $currentBalancePayment = $currentBalancePayment + $cashAmount;
                                            $cashAmount = 0;
                                            $successfulTransaction = true;
                                        } else if ($currentCashPayment < $cashAmount) {
                                            $cashAmount = $cashAmount - $currentCashPayment;
                                            $currentBalancePayment = $currentBalancePayment + $currentCashPayment;
                                            $currentCashPayment = 0;
                                            $successfulTransaction = true;
                                        }

                                        if ($currentChequePayment >= $chequeAmount) {
                                            $currentChequePayment = $currentChequePayment - $chequeAmount;
                                            $currentBalancePayment = $currentBalancePayment + $chequeAmount;
                                            $chequeAmount = 0;
                                            $successfulTransaction = true;
                                        } else if ($currentChequePayment < $chequeAmount) {
                                            $chequeAmount = $chequeAmount - $currentChequePayment;
                                            $currentBalancePayment = $currentBalancePayment + $currentChequePayment;
                                            $currentChequePayment = 0;
                                            $successfulTransaction = true;
                                        }

                                        if ($successfulTransaction) {

                                            $purchaseNoteData = array(
                                                'cash_payment_amount' => $currentCashPayment,
                                                'cheque_payment_amount' => $currentChequePayment,
                                                'balance_payment' => $currentBalancePayment,
                                                'supplier_return_note_claimed' => $claimAmountTotal,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->purchase_note_model->editPurchaseNoteData($referenceTransactionId, $purchaseNoteData);
                                        }
                                    } else if ($referenceTransactionTypeId == '2') {
                                        //Sales Note
                                        $salesNoteId = $referenceTransactionId;
                                        $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);

                                        $status = $salesNote[0]->status;
                                        //$amount = $salesNote[0]->sales_amount;
                                        $currentBalancePayment = $salesNote[0]->balance_payment;

                                        if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                            $salesNoteData = array(
                                                'balance_payment' => $referenceTransactionClaimAmount,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->sales_note_model->editSalesNoteData($referenceTransactionId, $salesNoteData);
                                        }

                                        $salesNoteSalesEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId);

                                        if ($salesNoteSalesEntryJournalEntries && sizeof($salesNoteSalesEntryJournalEntries) > 0) {
                                            //Delete sales note claim journal entries
                                            foreach($salesNoteSalesEntryJournalEntries as $journalEntry) {
                                                $journalEntryId = $journalEntry->journal_entry_id;

                                                $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                                                if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                                    foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                                        $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                                        $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                        $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                    }
                                                }
                                            }
                                        }
                                    } else if ($referenceTransactionTypeId == '3') {
                                        //Supplier Return Note
                                        $supplierReturnNoteId = $referenceTransactionId;
                                        $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($supplierReturnNoteId);

                                        $status = $supplierReturnNote[0]->status;
                                        //$amount = $supplierReturnNote[0]->amount;
                                        $currentBalancePayment = $supplierReturnNote[0]->balance_payment;
                                        $supplierReturnType = $supplierReturnNote[0]->type;

                                        if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                            $supplierReturnNoteData = array(
                                                'balance_payment' => $referenceTransactionClaimAmount,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->supplier_return_note_model->editSupplierReturnNoteData($referenceTransactionId, $supplierReturnNoteData);
                                        }

                                        if ($supplierReturnType == 'saleable_return') {
                                            $supplierReturnNoteSalesEntryJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '1');
                                        } else if ($supplierReturnType == 'market_return') {
                                            $supplierReturnNoteSalesEntryJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '2');
                                        }

                                        if ($supplierReturnNoteSalesEntryJournalEntries && sizeof($supplierReturnNoteSalesEntryJournalEntries) > 0) {
                                            //Delete supplier return claim journal entries
                                            foreach($supplierReturnNoteSalesEntryJournalEntries as $journalEntry) {
                                                $journalEntryId = $journalEntry->journal_entry_id;

                                                $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                                                if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                                    foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                                        $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                                        $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                        $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                    }
                                                }
                                            }
                                        }
                                    } else if ($referenceTransactionTypeId == '4') {
                                        //Customer Return Note
                                        $successfulTransaction = false;

                                        $customerReturnNoteId = $referenceTransactionId;
                                        $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);

                                        $currentCashPayment = $customerReturnNote[0]->cash_payment_amount;
                                        $currentChequePayment = $customerReturnNote[0]->cheque_payment_amount;
                                        $currentBalancePayment = $customerReturnNote[0]->balance_payment;
                                        $claimAmountTotal = $customerReturnNote[0]->sales_note_claimed;

                                        if ($refundClaimAmountTotal >= $claimAmountTotal) {
                                            $refundClaimAmountTotal = $refundClaimAmountTotal - $claimAmountTotal;
                                            $currentBalancePayment = $currentBalancePayment + $claimAmountTotal;
                                            $claimAmountTotal = 0;
                                        } else {
                                            $claimAmountTotal = $claimAmountTotal - $refundClaimAmountTotal;
                                            $currentBalancePayment = $currentBalancePayment + $refundClaimAmountTotal;
                                            $refundClaimAmountTotal = 0;
                                        }

                                        if ($currentCashPayment >= $cashAmount) {
                                            $currentCashPayment = $currentCashPayment - $cashAmount;
                                            $currentBalancePayment = $currentBalancePayment + $cashAmount;
                                            $cashAmount = 0;
                                            $successfulTransaction = true;
                                        } else if ($currentCashPayment < $cashAmount) {
                                            $cashAmount = $cashAmount - $currentCashPayment;
                                            $currentBalancePayment = $currentBalancePayment + $currentCashPayment;
                                            $currentCashPayment = 0;
                                            $successfulTransaction = true;
                                        }

                                        if ($currentChequePayment >= $chequeAmount) {
                                            $currentChequePayment = $currentChequePayment - $chequeAmount;
                                            $currentBalancePayment = $currentBalancePayment + $chequeAmount;
                                            $chequeAmount = 0;
                                            $successfulTransaction = true;
                                        } else if ($currentChequePayment < $chequeAmount) {
                                            $chequeAmount = $chequeAmount - $currentChequePayment;
                                            $currentBalancePayment = $currentBalancePayment + $currentChequePayment;
                                            $currentChequePayment = 0;
                                            $successfulTransaction = true;
                                        }

                                        if ($successfulTransaction) {

                                            $customerReturnNoteData = array(
                                                'cash_payment_amount' => $currentCashPayment,
                                                'cheque_payment_amount' => $currentChequePayment,
                                                'balance_payment' => $currentBalancePayment,
                                                'sales_note_claimed' => $claimAmountTotal,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->customer_return_note_model->editCustomerReturnNoteData($referenceTransactionId, $customerReturnNoteData);
                                        }
                                    } else if ($referenceTransactionTypeId == '5') {

                                        if ($referenceTransactionNote != "Deduction") {

                                            $journalEntryId = $paymentReference->reference_journal_entry_id;
                                            $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                            $balanceAmount = $journalEntry[0]->balance_amount;

                                            $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                            $transactionAmount = 0;
                                            if ($glTransactions && sizeof($glTransactions) > 0) {
                                                if ($glTransactions[0]->debit_value > 0) {
                                                    $transactionAmount = $glTransactions[0]->debit_value;
                                                } else if ($glTransactions[0]->credit_value > 0) {
                                                    $transactionAmount = $glTransactions[0]->credit_value;
                                                }
                                            }

                                            if ($cashAmount > 0) {
                                                if (($transactionAmount - $balanceAmount) >= $cashAmount) {

                                                    $balanceAmount = $balanceAmount + $cashAmount;
                                                    $cashAmount = 0;

                                                    $journalEntryData = array(
                                                        'balance_amount' => $balanceAmount,
                                                        'status' => "Open",
                                                        'actioned_user_id' => $this->user_id,
                                                        'action_date' => $this->date,
                                                        'last_action_status' => 'edited'
                                                    );

                                                    $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                                } else if (($transactionAmount - $balanceAmount) < $cashAmount) {
                                                    $balanceAmount = $balanceAmount + ($transactionAmount - $balanceAmount);
                                                    $cashAmount = $cashAmount - ($transactionAmount - $balanceAmount);

                                                    $journalEntryData = array(
                                                        'balance_amount' => $balanceAmount,
                                                        'status' => "Open",
                                                        'actioned_user_id' => $this->user_id,
                                                        'action_date' => $this->date,
                                                        'last_action_status' => 'edited'
                                                    );

                                                    $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                                }
                                            }

                                            if ($chequeAmount > 0) {
                                                if (($transactionAmount - $balanceAmount) >= $chequeAmount) {

                                                    $balanceAmount = $balanceAmount + $chequeAmount;
                                                    $chequeAmount = 0;

                                                    $journalEntryData = array(
                                                        'balance_amount' => $balanceAmount,
                                                        'status' => "Open",
                                                        'actioned_user_id' => $this->user_id,
                                                        'action_date' => $this->date,
                                                        'last_action_status' => 'edited'
                                                    );

                                                    $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                                } else if (($transactionAmount - $balanceAmount) < $chequeAmount) {
                                                    $balanceAmount = $balanceAmount + ($transactionAmount - $balanceAmount);
                                                    $chequeAmount = $chequeAmount - ($transactionAmount - $balanceAmount);

                                                    $journalEntryData = array(
                                                        'balance_amount' => $balanceAmount,
                                                        'status' => "Open",
                                                        'actioned_user_id' => $this->user_id,
                                                        'action_date' => $this->date,
                                                        'last_action_status' => 'edited'
                                                    );

                                                    $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                                }
                                            }
                                        } else {
                                            $journalEntryData = array(
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                        }
                                    }

                                    $makePaymentReferenceTransactionDataHistory = array(
                                        'make_payment_reference_transaction_id' => $paymentReference->make_payment_reference_transaction_id,
                                        'make_payment_id' => $paymentReference->make_payment_id,
                                        'reference_transaction_type_id' => $paymentReference->reference_transaction_type_id,
                                        'reference_transaction_id' => $paymentReference->reference_transaction_id,
                                        'reference_journal_entry_id' => $paymentReference->reference_journal_entry_id,
                                        'claim_amount' => $paymentReference->claim_amount,
                                        'actioned_user_id' => $paymentReference->actioned_user_id,
                                        'action_date' => $paymentReference->action_date,
                                        'last_action_status' => $paymentReference->last_action_status,
                                    );

                                    $this->make_payment_model->addMakePaymentReferenceTransactionToHistory($makePaymentReferenceTransactionDataHistory);
                                }
                            }

                            $this->make_payment_model->deleteMakePaymentReferenceTransactions($makePaymentId);

                            $makePaymentMethodDataHistory = array(
                                'make_payment_method_id' => $paymentMethodRecord->make_payment_method_id,
                                'make_payment_id' => $paymentMethodRecord->make_payment_id,
                                'payment_method' => $paymentMethodRecord->payment_method,
                                'cash_payment_id' => $paymentMethodRecord->cash_payment_id,
                                'payment_account_id' => $paymentMethodRecord->payment_account_id,
                                'cheque_type' => $paymentMethodRecord->cheque_type,
                                'cheque_id' => $paymentMethodRecord->cheque_id,
                                'actioned_user_id' => $paymentMethodRecord->actioned_user_id,
                                'action_date' => $paymentMethodRecord->action_date,
                                'last_action_status' => $paymentMethodRecord->last_action_status,
                            );

                            $this->make_payment_model->addMakePaymentMethodRecordToHistory($makePaymentMethodDataHistory);
                        }
                    }

                    $this->make_payment_model->deleteMakePaymentMethodRecords($makePaymentId);

                    $makePaymentJournalEntries = $this->make_payment_model->getMakePaymentJournalEntries($makePaymentId);

                    if ($makePaymentJournalEntries && sizeof($makePaymentJournalEntries) > 0) {
                        //Delete all journal entries of Make Payment
                        foreach($makePaymentJournalEntries as $makePaymentJournalEntry) {
                            $makePaymentJournalEntryId = $makePaymentJournalEntry->make_payment_journal_entry_id;
                            $journalEntryId = $makePaymentJournalEntry->journal_entry_id;
                            $this->make_payment_model->deleteMakePaymentJournalEntry($makePaymentJournalEntryId, "deleted", $this->user_id);
                            $this->journal_entries_model->deleteJournalEntry($journalEntryId, "deleted", $this->user_id);
                            $this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, "deleted", $this->user_id);
                        }
                    }

                    $makePaymentClaimAmountTotal = '0.00';
                    $salesNoteAmountTotal = '0.00';
                    $supplierReturnNoteAmountTotal = '0.00';
                    $otherReferenceTransactionDeductionAmountTotal = '0.00';

                    $claimTransactionList = array();

                    if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {

                        for($x = 0; $x < $referenceTransactionCount; $x++) {

                            if (isset($referenceTransactionData[$x])) {
                                $rowCount = sizeof($referenceTransactionData[$x][0]);

                                for($y = 1; $y <= $rowCount; $y++) {

                                    $claimAmount = 0;
                                    $referenceTransactionNote = '';

                                    if ($referenceTransactionData[$x][0][$y] == '2') {
                                        //Sales Note
                                        $journalEntryId = $referenceTransactionData[$x][2][$y];
                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                        $salesNoteReferenceNo = $journalEntry[0]->reference_no;
                                        $salesNote = $this->sales_note_model->getSalesNoteByReferenceNo($salesNoteReferenceNo);

                                        if ($salesNote && sizeof($salesNote) > 0) {

                                            $referenceNo = $salesNote[0]->reference_no;
                                            $salesNoteAmount = $salesNote[0]->balance_payment;
                                            $claimAmount = $salesNoteAmount;

                                            $data = array(
                                                'balance_payment' => '0.00',
                                                'status' => "Claimed",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);

                                            $salesNoteAmountTotal = $salesNoteAmountTotal + $salesNoteAmount;

                                            $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $referenceNo);
                                            $claimTransactionList[] = $claimTransaction;
                                        }
                                    } else if ($referenceTransactionData[$x][0][$y] == '3') {
                                        //Supplier Return Note
                                        $journalEntryId = $referenceTransactionData[$x][2][$y];
                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                        $supplierReturnNoteReferenceNo = $journalEntry[0]->reference_no;
                                        $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteByReferenceNo($supplierReturnNoteReferenceNo);

                                        if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {

                                            $referenceNo = $supplierReturnNote[0]->reference_no;
                                            $supplierReturnNoteAmount = $supplierReturnNote[0]->balance_payment;
                                            $claimAmount = $supplierReturnNoteAmount;

                                            $data = array(
                                                'balance_payment' => '0.00',
                                                'status' => "Claimed",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);

                                            $supplierReturnNoteAmountTotal = $supplierReturnNoteAmountTotal + $supplierReturnNoteAmount;

                                            $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $referenceNo);
                                            $claimTransactionList[] = $claimTransaction;
                                        }
                                    } else if ($referenceTransactionData[$x][0][$y] == '5') {
                                        if ($referenceTransactionData[$x][3][$y] == "Deduction") {
                                            $journalEntryId = $referenceTransactionData[$x][2][$y];
                                            $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                            $transactionAmount = 0;
                                            if ($glTransactions && sizeof($glTransactions) > 0) {
                                                if ($glTransactions[0]->debit_value > 0) {
                                                    $transactionAmount = $glTransactions[0]->debit_value;
                                                } else if ($glTransactions[0]->credit_value > 0) {
                                                    $transactionAmount = $glTransactions[0]->credit_value;
                                                }
                                            }

                                            $claimAmount = $transactionAmount;

                                            $data = array(
                                                'status' => "Closed",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'added'
                                            );

                                            $this->journal_entries_model->editJournalEntry($journalEntryId, $data);

                                            $otherReferenceTransactionDeductionAmountTotal = $otherReferenceTransactionDeductionAmountTotal + $transactionAmount;

                                            $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => '');
                                            $claimTransactionList[] = $claimTransaction;

                                            $referenceTransactionNote = "Deduction";
                                        }
                                    }

                                    $data = array(
                                        'make_payment_id' => $makePaymentId,
                                        'reference_transaction_type_id' => $referenceTransactionData[$x][0][$y],
                                        'reference_transaction_id' => $referenceTransactionData[$x][1][$y],
                                        'reference_transaction_note' => $referenceTransactionNote,
                                        'reference_journal_entry_id' => $referenceTransactionData[$x][2][$y],
                                        'claim_amount' => $claimAmount,
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'added'
                                    );

                                    $this->make_payment_model->addMakePaymentReferenceTransaction($data);
                                }
                            }
                        }
                    }

                    $makePaymentClaimAmountTotal = $salesNoteAmountTotal + $supplierReturnNoteAmountTotal + $otherReferenceTransactionDeductionAmountTotal;
                    $pendingClaimAmountTotalForPurchaseNotes = $supplierReturnNoteAmountTotal + $otherReferenceTransactionDeductionAmountTotal;
                    $pendingClaimAmountTotalForCustomerReturnNotes = $salesNoteAmountTotal + $otherReferenceTransactionDeductionAmountTotal;

                    if ($paymentMethodData && sizeof($paymentMethodData) > 0) {

                        $totalPaid = 0;

                        for($x = 0; $x < $paymentMethodCount; $x++) {

                            if (isset($paymentMethodData[$x])) {
                                $rowCount = sizeof($paymentMethodData[$x][0]);

                                $remainingPaymentAmount = 0;

                                for($y = 1; $y <= $rowCount; $y++) {

                                    $paymentMethod = $paymentMethodData[$x][0][$y];
                                    $paymentAccountId = $paymentMethodData[$x][1][$y];
                                    $chequeId = $paymentMethodData[$x][2][$y];
                                    $bankId = $paymentMethodData[$x][3][$y];
                                    $chequeNumber = $paymentMethodData[$x][4][$y];
                                    $chequeDate = $paymentMethodData[$x][5][$y];
                                    $amount = $paymentMethodData[$x][6][$y];

                                    $remainingPaymentAmount = $amount;

                                    $paymentId = 0;
                                    $chequeType = '';

                                    $referenceTransactionTypeId = '';
                                    $referenceTransactionId = '';
                                    $referenceJournalEntryId = '';

                                    if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {

                                        for($p = 0; $p < $referenceTransactionCount; $p++) {

                                            if (isset($referenceTransactionData[$p])) {
                                                $rowCountInner = sizeof($referenceTransactionData[$p][0]);

                                                for($q = 1; $q <= $rowCountInner; $q++) {

                                                    $today = date("Y-m-d");

                                                    if ($referenceTransactionData[$p][0][$q] == '1') {
                                                        //Purchase Note
                                                        $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                                        $purchaseNoteReferenceNo = $journalEntry[0]->reference_no;
                                                        $purchaseNote = $this->purchase_note_model->getPurchaseNoteByReferenceNo($purchaseNoteReferenceNo, '');

                                                        if ($purchaseNote && sizeof($purchaseNote) > 0) {

                                                            $purchaseNoteId = $purchaseNote[0]->purchase_note_id;

                                                            $referenceTransactionTypeId = '1';
                                                            $referenceTransactionId = $purchaseNoteId;
                                                            $referenceJournalEntryId = $journalEntryId;

                                                            $totalAmount = $purchaseNote[0]->amount;
                                                            $paidCashAmount = $purchaseNote[0]->cash_payment_amount;
                                                            $paidChequeAmount = $purchaseNote[0]->cheque_payment_amount;
                                                            $paidCreditCardAmount = $purchaseNote[0]->credit_card_payment_amount;
                                                            $supplierReturnAmountClaimed = $purchaseNote[0]->supplier_return_note_claimed;
                                                            $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $supplierReturnAmountClaimed;

                                                            $currentBalancePayment = $totalAmount - $totalPaid;

                                                            if (round($currentBalancePayment) > 0) {

                                                                $amountToClaimFromPayment = 0;
                                                                $amountToClaimFromPurchaseNoteAmount = 0;

                                                                if ($pendingClaimAmountTotalForPurchaseNotes > 0) {

                                                                    if ($currentBalancePayment >= $pendingClaimAmountTotalForPurchaseNotes) {
                                                                        $amountToClaimFromPayment = $currentBalancePayment - $pendingClaimAmountTotalForPurchaseNotes;

                                                                        if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                            $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                        }

                                                                        $amountToClaimFromPurchaseNoteAmount = $pendingClaimAmountTotalForPurchaseNotes;
                                                                        $newBalancePayment = $totalAmount - ($totalPaid + $amountToClaimFromPayment + $pendingClaimAmountTotalForPurchaseNotes);
                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                        $pendingClaimAmountTotalForPurchaseNotes = 0;
                                                                    } else {
                                                                        $amountToClaimFromPurchaseNoteAmount = $currentBalancePayment;
                                                                        $newBalancePayment = $totalAmount - ($totalPaid + $amountToClaimFromPurchaseNoteAmount);
                                                                        $pendingClaimAmountTotalForPurchaseNotes = $pendingClaimAmountTotalForPurchaseNotes - $amountToClaimFromPurchaseNoteAmount;
                                                                    }
                                                                } else {
                                                                    $newBalancePayment = $totalAmount - ($totalPaid + $remainingPaymentAmount);
                                                                }

                                                                $paidAmount = 0;

                                                                if ($newBalancePayment < 0) {
                                                                    $newBalancePayment = 0;
                                                                }

                                                                $status = "Open";
                                                                $paymentMethodFullyConsumed = false;

                                                                if ($newBalancePayment == 0) {
                                                                    $status = "Claimed";
                                                                } else {
                                                                    $paymentMethodFullyConsumed = true;
                                                                }

                                                                if ($amountToClaimFromPurchaseNoteAmount > 0) {
                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'supplier_return_note_claimed' => $amountToClaimFromPurchaseNoteAmount + $supplierReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Purchase Note',
                                                                            'transaction_id' => $purchaseNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                    } else if ($paymentMethod == 'Cheque Payment') {

                                                                        $chequeType = "Expense Cheque";
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'supplier_return_note_claimed' => $amountToClaimFromPurchaseNoteAmount + $supplierReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Purchase Note',
                                                                            'transaction_id' => $purchaseNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $purchaseNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                        $chequeType = "Expense Cheque";
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'supplier_return_note_claimed' => $amountToClaimFromPurchaseNoteAmount + $supplierReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        //Mark second party/third party cheque as paid

                                                                        $incomeChequeData = array(
                                                                            'status' => "Paid",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                        $primeEntryBooksToUpdate = '';
                                                                        if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                            $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                        }

                                                                        //Add a new expense cheque using party/third party cheque
                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Purchase Note',
                                                                            'transaction_id' => $purchaseNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $purchaseNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        }

                                                                        if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $today,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    $transactionStatus = "No";

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    $this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);
                                                                } else {
                                                                    if ($currentBalancePayment > $remainingPaymentAmount && $remainingPaymentAmount > 0) {

                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);

                                                                        $remainingPaymentAmount = 0;
                                                                    } else if ($currentBalancePayment > 0 && $currentBalancePayment <= $remainingPaymentAmount) {
                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Purchase Note',
                                                                                'transaction_id' => $purchaseNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $purchaseNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);

                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                    }
                                                                }

                                                                $claimAmount = 0;

                                                                if ($makePaymentClaimAmountTotal >= $amountToClaimFromPurchaseNoteAmount) {
                                                                    $claimAmount = $amountToClaimFromPurchaseNoteAmount;
                                                                    $makePaymentClaimAmountTotal = $makePaymentClaimAmountTotal - $amountToClaimFromPurchaseNoteAmount;
                                                                } else if ($makePaymentClaimAmountTotal > 0) {
                                                                    $claimAmount = $makePaymentClaimAmountTotal;
                                                                    $makePaymentClaimAmountTotal = 0;
                                                                }

                                                                $primeEntryBooksToUpdateForSupplierReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForMakePaymentTransactionClaim();

                                                                //Post journal entry for supplier return note claim for purchase note
                                                                if ($claimAmount > 0 && $journalEntryId != '') {

                                                                    if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                        $count = 0;
                                                                        $arrayElementsToUnset = array();
                                                                        foreach($claimTransactionList as $claimTransactionRow) {
                                                                            if ($claimTransactionRow[1] <= $claimAmount) {

                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForSupplierReturnNoteClaim, '', $makePaymentDate, 
                                                                                        $purchaseNoteReferenceNo, '1', $purchaseNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payeeId, 
                                                                                        $claimTransactionRow[1], true);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $arrayElementsToUnset[] = $count;
                                                                                $claimAmount = $claimAmount - $claimTransactionRow[1];
                                                                            } else {
                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForSupplierReturnNoteClaim, '', $makePaymentDate, 
                                                                                        $purchaseNoteReferenceNo, '1', $purchaseNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payeeId, 
                                                                                        $claimAmount, true);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $claimTransactionRow[1] = $claimTransactionRow[1] - $claimAmount;
                                                                                $claimAmount = 0;
                                                                            }

                                                                            $count++;
                                                                        }

                                                                        if ($arrayElementsToUnset && sizeof($arrayElementsToUnset) > 0) {
                                                                            foreach($arrayElementsToUnset as $row) {
                                                                                unset($claimTransactionList[$row]);
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if ($paidAmount > 0) {
                                                                    
                                                                    $cashPaymentId = 0;

                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $cashPaymentId = $paymentId;
                                                                    }

                                                                    $makePaymentMethodRecordData = array(
                                                                        'make_payment_id' => $makePaymentId,
                                                                        'payment_method' => $paymentMethod,
                                                                        'cash_payment_id' => $cashPaymentId,
                                                                        'payment_account_id' => $paymentAccountId,
                                                                        'cheque_type' => $chequeType,
                                                                        'cheque_id' => $chequeId,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $makePaymentMethodId = $this->make_payment_model->addMakePaymentMethodRecord($makePaymentMethodRecordData);

                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                    $primeEntryBookIds = '';
                                                                    if ($paymentMethod == "Cash Payment") {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentCashTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    } else if ($paymentMethod == "Cheque Payment") {

                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $paymentAccountId;
                                                                        }
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentSecondOrThirdPartyChequeTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                        if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                            foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                    'reference_transaction_id' => $referenceTransactionId,
                                                                                    'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                    'description' => $this->lang->line('Journal entry for Make Payment number : ') . $makePaymentReferenceNo,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $makePaymentJournalEntry = array(
                                                                                    'make_payment_id' => $makePaymentId,
                                                                                    'make_payment_method_id' => $makePaymentMethodId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->make_payment_model->addMakePaymentJournalEntry($makePaymentJournalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    if ($paymentMethod == "Cheque Payment") {
                                                                                        $transactionStatus = "No";
                                                                                    } else {
                                                                                        $transactionStatus = "Yes";
                                                                                    }

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        } 

                                                                        $result = 'ok';
                                                                    } else {
                                                                        $result = 'incorrect_prime_entry_book_selected_for_make_payment_transaction';
                                                                        break;
                                                                    }
                                                                }

                                                                if ($paymentMethodFullyConsumed == true) {
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    } else if ($referenceTransactionData[$p][0][$q] == '4') {
                                                        //Customer Return Note
                                                        $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                                        $customerReturnNoteReferenceNo = $journalEntry[0]->reference_no;
                                                        $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteByReferenceNo($customerReturnNoteReferenceNo);

                                                        if ($customerReturnNote && sizeof($customerReturnNote) > 0) {

                                                            $customerReturnNoteId = $customerReturnNote[0]->customer_return_note_id;

                                                            $referenceTransactionTypeId = '4';
                                                            $referenceTransactionId = $customerReturnNoteId;
                                                            $referenceJournalEntryId = $journalEntryId;

                                                            $totalAmount = $customerReturnNote[0]->amount;
                                                            $paidCashAmount = $customerReturnNote[0]->cash_payment_amount;
                                                            $paidChequeAmount = $customerReturnNote[0]->cheque_payment_amount;
                                                            $paidCreditCardAmount = $customerReturnNote[0]->credit_card_payment_amount;
                                                            $salesAmountClaimed = $customerReturnNote[0]->sales_note_claimed;
                                                            $totalReceivable = $totalAmount;
                                                            $totalReceived = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $salesAmountClaimed;

                                                            $currentBalancePayment = $totalReceivable - $totalReceived;

                                                            if (round($currentBalancePayment) > 0) {

                                                                $amountToClaimFromPayment = 0;
                                                                $amountToClaimFromCustomerReturnAmount = 0;

                                                                if ($pendingClaimAmountTotalForCustomerReturnNotes > 0) {

                                                                    if ($currentBalancePayment >= $pendingClaimAmountTotalForCustomerReturnNotes) {
                                                                        $amountToClaimFromPayment = $currentBalancePayment - $pendingClaimAmountTotalForCustomerReturnNotes;

                                                                        if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                            $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                        }

                                                                        $amountToClaimFromCustomerReturnAmount = $pendingClaimAmountTotalForCustomerReturnNotes;
                                                                        $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromPayment + $pendingClaimAmountTotalForCustomerReturnNotes);
                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                        $pendingClaimAmountTotalForCustomerReturnNotes = 0;
                                                                    } else {
                                                                        $amountToClaimFromCustomerReturnAmount = $currentBalancePayment;
                                                                        $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromCustomerReturnAmount);
                                                                        $pendingClaimAmountTotalForCustomerReturnNotes = $pendingClaimAmountTotalForCustomerReturnNotes - $amountToClaimFromCustomerReturnAmount;
                                                                    }
                                                                } else {
                                                                    $newBalancePayment = $totalReceivable - ($totalReceived + $remainingPaymentAmount);
                                                                }

                                                                $paidAmount = 0;

                                                                if ($newBalancePayment < 0) {
                                                                    $newBalancePayment = 0;
                                                                }

                                                                $status = "Open";
                                                                $paymentMethodFullyConsumed = false;

                                                                if ($newBalancePayment == 0) {
                                                                    $status = "Claimed";
                                                                } else {
                                                                    $paymentMethodFullyConsumed = true;
                                                                }

                                                                if ($amountToClaimFromCustomerReturnAmount > 0) {
                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'sales_note_claimed' => $amountToClaimFromCustomerReturnAmount + $salesAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Customer Return Note',
                                                                            'transaction_id' => $customerReturnNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                    } else if ($paymentMethod == 'Cheque Payment') {
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'sales_note_claimed' => $amountToClaimFromCustomerReturnAmount + $salesAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Customer Return Note',
                                                                            'transaction_id' => $customerReturnNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $customerReturnNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                        $chequeType = "Expense Cheque";
                                                                        $paidAmount = $amountToClaimFromPayment;

                                                                        $data = array(
                                                                            'cheque_payment_amount' => $paidChequeAmount + $amountToClaimFromPayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'sales_note_claimed' => $amountToClaimFromCustomerReturnAmount + $salesAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        //Mark second party/third party cheque as paid

                                                                        $incomeChequeData = array(
                                                                            'status' => "Paid",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                        $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                        $primeEntryBooksToUpdate = '';
                                                                        if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                            $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                        }

                                                                        //Add a new expense cheque using party/third party cheque
                                                                        $expenseChequeData = array(
                                                                            'transaction_type' => 'Customer Return Note',
                                                                            'transaction_id' => $customerReturnNoteId,
                                                                            'date' => $makePaymentDate,
                                                                            'payee_id' => $payeeId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $customerReturnNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'amount' => $amountToClaimFromPayment,
                                                                            'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                            'status' => "Open",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        }

                                                                        if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $today,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    $transactionStatus = "No";

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $today,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $amountToClaimFromPayment,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);
                                                                } else {
                                                                    if ($currentBalancePayment > $remainingPaymentAmount && $remainingPaymentAmount > 0) {

                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $remainingPaymentAmount;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $remainingPaymentAmount,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $remainingPaymentAmount,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $remainingPaymentAmount,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);

                                                                        $remainingPaymentAmount = 0;
                                                                    } else if ($currentBalancePayment > 0 && $currentBalancePayment <= $remainingPaymentAmount) {
                                                                        if ($paymentMethod == 'Cash Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cash_payment_amount' => $paidCashAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $cashPaymentData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                                        } else if ($paymentMethod == 'Cheque Payment') {
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                                            $chequeType = "Expense Cheque";
                                                                            $paidAmount = $currentBalancePayment;

                                                                            $data = array(
                                                                                'cheque_payment_amount' => $paidChequeAmount + $currentBalancePayment,
                                                                                'balance_payment' => $newBalancePayment,
                                                                                'status' => $status,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            //Mark second party/third party cheque as paid

                                                                            $incomeChequeData = array(
                                                                                'status' => "Paid",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'edited'
                                                                            );

                                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                                            $primeEntryBooksToUpdate = '';
                                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                                            }

                                                                            //Add a new expense cheque using party/third party cheque
                                                                            $expenseChequeData = array(
                                                                                'transaction_type' => 'Customer Return Note',
                                                                                'transaction_id' => $customerReturnNoteId,
                                                                                'date' => $makePaymentDate,
                                                                                'payee_id' => $payeeId,
                                                                                'location_id' => $locationId,
                                                                                'reference_no' => $customerReturnNoteReferenceNo,
                                                                                'cheque_number' => $chequeNumber,
                                                                                'bank' => $bankId,
                                                                                'cheque_date' => $chequeDate,
                                                                                'amount' => $currentBalancePayment,
                                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                                'status' => "Open",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                            }

                                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                                    $journalEntry = array(
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $today,
                                                                                        'reference_no' => $chequeNumber,
                                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                                        'location_id' => $locationId,
                                                                                        'payee_payer_type' => $payeeType,
                                                                                        'payee_payer_id' => $payeeId,
                                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                                        'post_type' => "Indirect",
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                    $amount = str_replace(',', '', $amount);

                                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                        $transactionStatus = "No";

                                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'debit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                            $generalLedgerTransaction = array(
                                                                                                'journal_entry_id' => $journalEntryId,
                                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                                'transaction_date' => $today,
                                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                                'credit_value' => $currentBalancePayment,
                                                                                                'transaction_complete' => $transactionStatus,
                                                                                                'actioned_user_id' => $this->user_id,
                                                                                                'action_date' => $this->date,
                                                                                                'last_action_status' => 'added'
                                                                                            );
                                                                                        }

                                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                        //Same time add the data to previous years record table.
                                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);

                                                                        $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                    }
                                                                }

                                                                $claimAmount = 0;

                                                                if ($makePaymentClaimAmountTotal >= $amountToClaimFromCustomerReturnAmount) {
                                                                    $claimAmount = $amountToClaimFromCustomerReturnAmount;
                                                                    $makePaymentClaimAmountTotal = $makePaymentClaimAmountTotal - $amountToClaimFromCustomerReturnAmount;
                                                                } else if ($makePaymentClaimAmountTotal > 0) {
                                                                    $claimAmount = $makePaymentClaimAmountTotal;
                                                                    $makePaymentClaimAmountTotal = 0;
                                                                }

                                                                $primeEntryBooksToUpdateForCustomerSalesNoteClaim = $this->getPrimeEntryBooksToUpdateForMakePaymentTransactionClaim();

                                                                //Post journal entry for sales note claim for customer return note
                                                                if ($claimAmount > 0 && $journalEntryId != '') {

                                                                    if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                        $count = 0;
                                                                        $arrayElementsToUnset = array();
                                                                        foreach($claimTransactionList as $claimTransactionRow) {
                                                                            if ($claimTransactionRow[1] <= $claimAmount) {

                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSalesNoteClaim, '', $makePaymentDate, 
                                                                                        $customerReturnNoteReferenceNo, '4', $customerReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payeeId, 
                                                                                        $claimTransactionRow[1], true);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $arrayElementsToUnset[] = $count;
                                                                                $claimAmount = $claimAmount - $claimTransactionRow[1];
                                                                            } else {
                                                                                $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerSalesNoteClaim, '', $makePaymentDate, 
                                                                                        $customerReturnNoteReferenceNo, '4', $customerReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payeeId, 
                                                                                        $claimAmount, true);

                                                                                if ($claimReferenceJournalEntryId != '') {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $claimTransactionRow[0],
                                                                                        'claim_reference_journal_entry_id' => $claimReferenceJournalEntryId,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );

                                                                                    $this->journal_entries_model->addJournalEntryClaimReference($data);
                                                                                }

                                                                                $claimTransactionRow[1] = $claimTransactionRow[1] - $claimAmount;
                                                                                $claimAmount = 0;
                                                                            }

                                                                            $count++;
                                                                        }

                                                                        if ($arrayElementsToUnset && sizeof($arrayElementsToUnset) > 0) {
                                                                            foreach($arrayElementsToUnset as $row) {
                                                                                unset($claimTransactionList[$row]);
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if ($paidAmount > 0) {
                                                                    
                                                                    $cashPaymentId = 0;

                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $cashPaymentId = $paymentId;
                                                                    }

                                                                    $makePaymentMethodRecordData = array(
                                                                        'make_payment_id' => $makePaymentId,
                                                                        'payment_method' => $paymentMethod,
                                                                        'cash_payment_id' => $cashPaymentId,
                                                                        'payment_account_id' => $paymentAccountId,
                                                                        'cheque_type' => $chequeType,
                                                                        'cheque_id' => $chequeId,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $makePaymentMethodId = $this->make_payment_model->addMakePaymentMethodRecord($makePaymentMethodRecordData);

                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                    $primeEntryBookIds = '';
                                                                    if ($paymentMethod == "Cash Payment") {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentCashTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    } else if ($paymentMethod == "Cheque Payment") {

                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $paymentAccountId;
                                                                        }
                                                                    } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                                                                        $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentSecondOrThirdPartyChequeTransaction();

                                                                        if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                            foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                                $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                                } else {
                                                                                    $primeEntryBookIds[] = $primeEntryBookId;
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                        if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                            foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                                $journalEntry = array(
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'reference_no' => $chequeNumber,
                                                                                    'should_have_a_payment_journal_entry' => "No",
                                                                                    'location_id' => $locationId,
                                                                                    'payee_payer_type' => $payeeType,
                                                                                    'payee_payer_id' => $payeeId,
                                                                                    'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                    'reference_transaction_id' => $referenceTransactionId,
                                                                                    'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                    'description' => $this->lang->line('Journal entry for Make Payment number : ') . $makePaymentReferenceNo,
                                                                                    'post_type' => "Indirect",
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                                $makePaymentJournalEntry = array(
                                                                                    'make_payment_id' => $makePaymentId,
                                                                                    'make_payment_method_id' => $makePaymentMethodId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->make_payment_model->addMakePaymentJournalEntry($makePaymentJournalEntry);

                                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                                $amount = str_replace(',', '', $amount);

                                                                                foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                    if ($paymentMethod == "Cheque Payment") {
                                                                                        $transactionStatus = "No";
                                                                                    } else {
                                                                                        $transactionStatus = "Yes";
                                                                                    }

                                                                                    if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'debit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                        $generalLedgerTransaction = array(
                                                                                            'journal_entry_id' => $journalEntryId,
                                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                                            'transaction_date' => $makePaymentDate,
                                                                                            'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                            'credit_value' => $paidAmount,
                                                                                            'transaction_complete' => $transactionStatus,
                                                                                            'actioned_user_id' => $this->user_id,
                                                                                            'action_date' => $this->date,
                                                                                            'last_action_status' => 'added'
                                                                                        );
                                                                                    }

                                                                                    $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                                    //Same time add the data to previous years record table.
                                                                                    $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                                }
                                                                            }
                                                                        } 

                                                                        $result = 'ok';
                                                                    } else {
                                                                        $result = 'incorrect_prime_entry_book_selected_for_make_payment_transaction';
                                                                        break;
                                                                    }
                                                                }

                                                                if ($paymentMethodFullyConsumed == true) {
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    } else if ($referenceTransactionData[$p][0][$q] == '5') {

                                                        $journalEntryId = $referenceTransactionData[$p][2][$q];

                                                        $referenceJournalEntryId = $journalEntryId;

                                                        $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                                        $balanceAmount = $journalEntry[0]->balance_amount;

                                                        if ($balanceAmount == 0) {
                                                            $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId);

                                                            $transactionAmount = 0;
                                                            if ($glTransactions && sizeof($glTransactions) > 0) {
                                                                if ($glTransactions[0]->debit_value > 0) {
                                                                    $balanceAmount = $glTransactions[0]->debit_value;
                                                                } else if ($glTransactions[0]->credit_value > 0) {
                                                                    $balanceAmount = $glTransactions[0]->credit_value;
                                                                }
                                                            }
                                                        }

                                                        $journalEntryStatus = "Open";
                                                        $paymentMethodFullyConsumed = false;

                                                        if ($balanceAmount > $remainingPaymentAmount) {
                                                            $paidAmount = $remainingPaymentAmount;
                                                            $balanceAmount = $balanceAmount - $paidAmount;
                                                            $remainingPaymentAmount = 0;
                                                            $paymentMethodFullyConsumed  =true;
                                                        } else {
                                                            $paidAmount = $balanceAmount;
                                                            $balanceAmount = 0;
                                                            $remainingPaymentAmount = $remainingPaymentAmount - $balanceAmount;

                                                            $journalEntryStatus = "Closed";
                                                        }

                                                        $journalEntryData = array(
                                                            'balance_amount' => $balanceAmount,
                                                            'status' => $journalEntryStatus,
                                                            'actioned_user_id' => $this->user_id,
                                                            'action_date' => $this->date,
                                                            'last_action_status' => 'edited'
                                                        );

                                                        $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);

                                                        if ($paymentMethod == 'Cash Payment') {

                                                            $cashPaymentData = array(
                                                                'date' => $makePaymentDate,
                                                                'amount' => $amount,
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'edited'
                                                            );

                                                            $paymentId = $this->payments_model->addCashPayment($cashPaymentData);
                                                        } else if ($paymentMethod == 'Cheque Payment') {

                                                            $expenseChequeData = array(
                                                                'date' => $makePaymentDate,
                                                                'payee_id' => $payeeId,
                                                                'location_id' => $locationId,
                                                                'cheque_number' => $chequeNumber,
                                                                'bank' => $bankId,
                                                                'cheque_date' => $chequeDate,
                                                                'amount' => $amount,
                                                                'cheque_payment_prime_entry_book_id' => $paymentAccountId,
                                                                'status' => "Open",
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'added'
                                                            );

                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);
                                                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {

                                                            $chequeType = "Expense Cheque";

                                                            //Mark second party/third party cheque as paid

                                                            $incomeChequeData = array(
                                                                'status' => "Paid",
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'edited'
                                                            );

                                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBook = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

                                                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = '';
                                                            $primeEntryBooksToUpdate = '';
                                                            if ($makePaymentInSecondOrThirdPartyPrimeEntryBook && sizeof($makePaymentInSecondOrThirdPartyPrimeEntryBook) > 0) {
                                                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $makePaymentInSecondOrThirdPartyPrimeEntryBook[0]->config_filed_value;
                                                                $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($makePaymentInSecondOrThirdPartyPrimeEntryBookId);
                                                            }

                                                            //Add a new expense cheque using party/third party cheque
                                                            $expenseChequeData = array(
                                                                'date' => $makePaymentDate,
                                                                'payee_id' => $payeeId,
                                                                'location_id' => $locationId,
                                                                'cheque_number' => $chequeNumber,
                                                                'bank' => $bankId,
                                                                'cheque_date' => $chequeDate,
                                                                'amount' => $amount,
                                                                'cheque_payment_prime_entry_book_id' => $makePaymentInSecondOrThirdPartyPrimeEntryBookId,
                                                                'status' => "Open",
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'added'
                                                            );

                                                            $chequeId = $this->payments_model->addExpenseCheque($expenseChequeData);

                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                            if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;
                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                    }
                                                                }
                                                            } else {
                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                            }

                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks) {
                                                                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                    $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                                                                    $journalEntry = array(
                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                        'transaction_date' => $today,
                                                                        'reference_no' => $chequeNumber,
                                                                        'should_have_a_payment_journal_entry' => "No",
                                                                        'location_id' => $locationId,
                                                                        'payee_payer_type' => $payeeType,
                                                                        'payee_payer_id' => $payeeId,
                                                                        'description' => $this->lang->line('Journal entry for second or third party cheque payment for Cheque number : ') . $chequeNumber,
                                                                        'post_type' => "Indirect",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                    $amount = str_replace(',', '', $amount);

                                                                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                        $transactionStatus = "No";

                                                                        if ($chartOfAccount->debit_or_credit == "debit") {
                                                                            $generalLedgerTransaction = array(
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $today,
                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                'debit_value' => $amount,
                                                                                'transaction_complete' => $transactionStatus,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );
                                                                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                            $generalLedgerTransaction = array(
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $today,
                                                                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                'credit_value' => $amount,
                                                                                'transaction_complete' => $transactionStatus,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );
                                                                        }

                                                                        $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                        //Same time add the data to previous years record table.
                                                                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        if ($paidAmount > 0) {
                                                            
                                                            $cashPaymentId = 0;

                                                            if ($paymentMethod == 'Cash Payment') {
                                                                $cashPaymentId = $paymentId;
                                                            }

                                                            $makePaymentMethodRecordData = array(
                                                                'make_payment_id' => $makePaymentId,
                                                                'payment_method' => $paymentMethod,
                                                                'cash_payment_id' => $cashPaymentId,
                                                                'payment_account_id' => $paymentAccountId,
                                                                'cheque_type' => $chequeType,
                                                                'cheque_id' => $chequeId,
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'added'
                                                            );

                                                            $makePaymentMethodId = $this->make_payment_model->addMakePaymentMethodRecord($makePaymentMethodRecordData);

                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                            $primeEntryBookIds = '';
                                                            if ($paymentMethod == "Cash Payment") {
                                                                $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentCashTransaction();

                                                                if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $primeEntryBookId;
                                                                        }
                                                                    }
                                                                }
                                                            } else if ($paymentMethod == "Cheque Payment") {

                                                                $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                    $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                } else {
                                                                    $primeEntryBookIds[] = $paymentAccountId;
                                                                }
                                                            } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                                                                $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForMakePaymentSecondOrThirdPartyChequeTransaction();

                                                                if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
                                                                    foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                                                                        $primeEntryBookId = $primeEntryBook->config_filed_value;
                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                        if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                            $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                        } else {
                                                                            $primeEntryBookIds[] = $primeEntryBookId;
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                    foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                        $journalEntry = array(
                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                            'transaction_date' => $makePaymentDate,
                                                                            'reference_no' => $makePaymentReferenceNo,
                                                                            'should_have_a_payment_journal_entry' => "No",
                                                                            'location_id' => $locationId,
                                                                            'payee_payer_type' => $payeeType,
                                                                            'payee_payer_id' => $payeeId,
                                                                            'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                            'description' => $this->lang->line('Journal entry for Make Payment number : ') . $makePaymentReferenceNo,
                                                                            'post_type' => "Indirect",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $journalEntryId = $this->journal_entries_model->addJournalEntry($journalEntry);

                                                                        $makePaymentJournalEntry = array(
                                                                            'make_payment_id' => $makePaymentId,
                                                                            'make_payment_method_id' => $makePaymentMethodId,
                                                                            'prime_entry_book_id' => $primeEntryBookId,
                                                                            'journal_entry_id' => $journalEntryId,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $this->make_payment_model->addMakePaymentJournalEntry($makePaymentJournalEntry);

                                                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                                                        $amount = str_replace(',', '', $amount);

                                                                        foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                            if ($paymentMethod == "Cheque Payment") {
                                                                                $transactionStatus = "No";
                                                                            } else {
                                                                                $transactionStatus = "Yes";
                                                                            }

                                                                            if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                $generalLedgerTransaction = array(
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                    'debit_value' => $paidAmount,
                                                                                    'transaction_complete' => $transactionStatus,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );
                                                                            } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                $generalLedgerTransaction = array(
                                                                                    'journal_entry_id' => $journalEntryId,
                                                                                    'prime_entry_book_id' => $primeEntryBookId,
                                                                                    'transaction_date' => $makePaymentDate,
                                                                                    'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                    'credit_value' => $paidAmount,
                                                                                    'transaction_complete' => $transactionStatus,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );
                                                                            }

                                                                            $this->journal_entries_model->addGeneralLedgerTransaction($generalLedgerTransaction);

                                                                            //Same time add the data to previous years record table.
                                                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($generalLedgerTransaction);
                                                                        }
                                                                    }
                                                                } 

                                                                $result = 'ok';
                                                            } else {
                                                                $result = 'incorrect_prime_entry_book_selected_for_make_payment_transaction';
                                                                break;
                                                            }
                                                        }

                                                        if ($paymentMethodFullyConsumed == true) {
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $result = "previous_financial_year_is_closed";
                }
			}
			
			if ($result == '') {
				$result = 'ok';
			}

			echo json_encode(array('result' => $result, 'makePaymentId' => $makePaymentId));
		}
	}

	//Delete Make Payment
	public function deleteMakePayment() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Make_Payment_Permissions'])) {
            
            $html = '';
			$makePaymentId = $this->db->escape_str($this->input->post('id'));
			
            $makePayment = $this->make_payment_model->getMakePaymentById($makePaymentId);
            $makePaymentTransactionDate = $makePayment[0]->date;

            $financialYear = $this->financial_year_ends_model->getFinancialYearOfSelectedTransaction($makePaymentTransactionDate);

            if ($financialYear[0]->year_end_process_status != "Closed") {
            
                $status = "deleted";

                $paymentReferenceList = $this->make_payment_model->getMakePaymentReferenceTransactionList($makePaymentId);
                $paymentMethodList = $this->make_payment_model->getMakePaymentMethodList($makePaymentId);
                $refundClaimAmountTotal = $this->make_payment_model->getMakePaymentClaimAmountTotal($makePaymentId);

                if ($paymentMethodList && sizeof($paymentMethodList) > 0) {

                    foreach ($paymentMethodList as $paymentMethodRecord) {

                        $paymentMethod = $paymentMethodRecord->payment_method;
                        $cashPaymentId = $paymentMethodRecord->cash_payment_id;
                        $chequeId = $paymentMethodRecord->cheque_id;

                        $cashAmount = 0;
                        $chequeAmount = 0;
                        $status = "deleted";

                        if ($paymentMethod == "Cash Payment") {
                            $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
                            $cashAmount = $cashPayment[0]->amount;
                            $this->payments_model->deleteCashPayment($cashPaymentId, $status, $this->user_id);
                        } else if ($paymentMethod == "Cheque Payment") {
                            $expenseCheque = $this->payments_model->getExpenseChequeById($chequeId);
                            $chequeAmount = $expenseCheque[0]->amount;
                            $chequeNumber = $expenseCheque[0]->cheque_number;
                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $expenseCheque[0]->cheque_payment_prime_entry_book_id;

                            $makePaymentInSecondOrThirdPartyJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($makePaymentInSecondOrThirdPartyPrimeEntryBookId, $chequeNumber);

                            if ($makePaymentInSecondOrThirdPartyJournalEntries && sizeof($makePaymentInSecondOrThirdPartyJournalEntries) > 0) {
                                foreach($makePaymentInSecondOrThirdPartyJournalEntries as $makePaymentInSecondOrThirdPartyJournalEntry) {
                                    $journalEntryId = $makePaymentInSecondOrThirdPartyJournalEntry->journal_entry_id;

                                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "Yes");

                                    if ($glTransactions && sizeof($glTransactions) > 0) {
                                        foreach($glTransactions as $glTransaction) {
                                            $chartOfAccountId = $glTransaction->chart_of_account_id;

                                            $generalLedgerTransaction = array(
                                                'transaction_complete' => "No",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'deleted'
                                            );

                                            $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $generalLedgerTransaction);
                                        }
                                    }

                                    $journalEntry = array(
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'deleted'
                                    );

                                    $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntry);
                                }
                            }

                            $this->payments_model->deleteExpenseCheque($chequeId, $status, $this->user_id);
                        } else if ($paymentMethod == 'Second Party Cheque Payment' || $paymentMethod == 'Third Party Cheque Payment') {
                            $expenseCheque = $this->payments_model->getExpenseChequeById($chequeId);
                            $chequeAmount = $expenseCheque[0]->amount;
                            $chequeNumber = $expenseCheque[0]->cheque_number;
                            $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $expenseCheque[0]->cheque_payment_prime_entry_book_id;

                            $makePaymentInSecondOrThirdPartyJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($makePaymentInSecondOrThirdPartyPrimeEntryBookId, $chequeNumber);

                            if ($makePaymentInSecondOrThirdPartyJournalEntries && sizeof($makePaymentInSecondOrThirdPartyJournalEntries) > 0) {
                                foreach($makePaymentInSecondOrThirdPartyJournalEntries as $makePaymentInSecondOrThirdPartyJournalEntry) {
                                    $journalEntryId = $makePaymentInSecondOrThirdPartyJournalEntry->journal_entry_id;

                                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "Yes");

                                    if ($glTransactions && sizeof($glTransactions) > 0) {
                                        foreach($glTransactions as $glTransaction) {
                                            $chartOfAccountId = $glTransaction->chart_of_account_id;

                                            $generalLedgerTransaction = array(
                                                'transaction_complete' => "No",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'deleted'
                                            );

                                            $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $generalLedgerTransaction);
                                        }
                                    }

                                    $journalEntry = array(
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'deleted'
                                    );

                                    $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntry);
                                }
                            }

                            $this->payments_model->deleteExpenseCheque($chequeId, $status, $this->user_id);

                            //Mark coresponding income cheque (if available) is In Hand
                            $incomeCheque = $this->payments_model->getIncomeChequeByChequeNumber($chequeNumber);
                            $chequeId = $incomeCheque[0]->cheque_id;

                            if ($incomeCheque && sizeof($incomeCheque) > 0) {
                                $incomeChequeData = array(
                                    'status' => "In_Hand",
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                            }
                        }

                        //Reverse current reference transactions changes from the receive payment
                        if ($paymentReferenceList && sizeof($paymentReferenceList) > 0) {

                            foreach ($paymentReferenceList as $paymentReference) {

                                $referenceTransactionTypeId = $paymentReference->reference_transaction_type_id;
                                $referenceTransactionId = $paymentReference->reference_transaction_id;

                                if ($referenceTransactionTypeId == '1') {
                                    //Purchase Note
                                    $successfulTransaction = false;

                                    $purchaseNoteId = $referenceTransactionId;
                                    $purchaseNote = $this->purchase_note_model->getPurchaseNoteById($purchaseNoteId);

                                    $currentCashPayment = $purchaseNote[0]->cash_payment_amount;
                                    $currentChequePayment = $purchaseNote[0]->cheque_payment_amount;
                                    $currentBalancePayment = $purchaseNote[0]->balance_payment;
                                    $claimAmountTotal = $purchaseNote[0]->supplier_return_note_claimed;

                                    $balancePaymentAdjustmentFromClaimAmount = 0;

                                    if ($refundClaimAmountTotal >= $claimAmountTotal) {
                                        $balancePaymentAdjustmentFromClaimAmount = $claimAmountTotal;
                                        $refundClaimAmountTotal = $refundClaimAmountTotal - $claimAmountTotal;
                                        $claimAmountTotal = 0;
                                    } else {
                                        $balancePaymentAdjustmentFromClaimAmount = $refundClaimAmountTotal;
                                        $claimAmountTotal = $claimAmountTotal - $refundClaimAmountTotal;
                                        $refundClaimAmountTotal = 0;
                                    }

                                    if ($currentCashPayment >= $cashAmount) {
                                        $currentCashPayment = $currentCashPayment - $cashAmount;
                                        $currentBalancePayment = $currentBalancePayment + $cashAmount;
                                        $cashAmount = 0;
                                        $successfulTransaction = true;
                                    } else if ($currentCashPayment < $cashAmount) {
                                        $cashAmount = $cashAmount - $currentCashPayment;
                                        $currentBalancePayment = $currentBalancePayment + $currentCashPayment;
                                        $currentCashPayment = 0;
                                        $successfulTransaction = true;
                                    }

                                    if ($currentChequePayment >= $chequeAmount) {
                                        $currentChequePayment = $currentChequePayment - $chequeAmount;
                                        $currentBalancePayment = $currentBalancePayment + $chequeAmount;
                                        $chequeAmount = 0;
                                        $successfulTransaction = true;
                                    } else if ($currentChequePayment < $chequeAmount) {
                                        $chequeAmount = $chequeAmount - $currentChequePayment;
                                        $currentBalancePayment = $currentBalancePayment + $currentChequePayment;
                                        $currentChequePayment = 0;
                                        $successfulTransaction = true;
                                    }

                                    if ($successfulTransaction) {

                                        $currentBalancePayment = $currentBalancePayment + $balancePaymentAdjustmentFromClaimAmount;

                                        $purchaseNoteData = array(
                                            'cash_payment_amount' => $currentCashPayment,
                                            'cheque_payment_amount' => $currentChequePayment,
                                            'balance_payment' => $currentBalancePayment,
                                            'supplier_return_note_claimed' => $claimAmountTotal,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->purchase_note_model->editPurchaseNoteData($referenceTransactionId, $purchaseNoteData);
                                    }
                                } else if ($referenceTransactionTypeId == '2') {
                                    //Sales Note
                                    $salesNoteId = $referenceTransactionId;
                                    $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);

                                    $status = $salesNote[0]->status;
                                    $amount = $salesNote[0]->amount;
                                    $currentBalancePayment = $salesNote[0]->balance_payment;

                                    if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                        $salesNoteData = array(
                                            'balance_payment' => $amount,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->sales_note_model->editSalesNoteData($referenceTransactionId, $salesNoteData);
                                    }

                                    $salesNoteSalesEntryJournalEntries = $this->sales_note_model->getSalesNoteJournalEntries($salesNoteId);

                                    if ($salesNoteSalesEntryJournalEntries && sizeof($salesNoteSalesEntryJournalEntries) > 0) {
                                        //Delete sales claim journal entries
                                        foreach($salesNoteSalesEntryJournalEntries as $journalEntry) {
                                            $journalEntryId = $journalEntry->journal_entry_id;

                                            $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                                            if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                                foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                                    $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                                    $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                    $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                }
                                            }
                                        }
                                    }
                                } else if ($referenceTransactionTypeId == '3') {
                                    //Supplier Return Note
                                    $supplierReturnNoteId = $referenceTransactionId;
                                    $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($supplierReturnNoteId);

                                    $status = $supplierReturnNote[0]->status;
                                    $amount = $supplierReturnNote[0]->amount;
                                    $currentBalancePayment = $supplierReturnNote[0]->balance_payment;
                                    $supplierReturnType = $supplierReturnNote[0]->type;

                                    if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                        $supplierReturnNoteData = array(
                                            'balance_payment' => $amount,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->supplier_return_note_model->editSupplierReturnNoteData($referenceTransactionId, $supplierReturnNoteData);
                                    }

                                    if ($supplierReturnType == 'saleable_return') {
                                        $supplierReturnNoteSalesEntryJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '1');
                                    } else if ($supplierReturnType == 'market_return') {
                                        $supplierReturnNoteSalesEntryJournalEntries = $this->supplier_return_note_model->getSupplierReturnNoteJournalEntries($supplierReturnNoteId, '2');
                                    }

                                    if ($supplierReturnNoteSalesEntryJournalEntries && sizeof($supplierReturnNoteSalesEntryJournalEntries) > 0) {
                                        //Delete supplier return claim journal entries
                                        foreach($supplierReturnNoteSalesEntryJournalEntries as $journalEntry) {
                                            $journalEntryId = $journalEntry->journal_entry_id;

                                            $journalEntryClaimReferences = $this->journal_entries_model->getJournalEntryClaimReferences($journalEntryId);

                                            if ($journalEntryClaimReferences && sizeof($journalEntryClaimReferences) > 0) {
                                                foreach($journalEntryClaimReferences as $journalEntryClaimReference) {
                                                    $claimReferenceJournalEntryId = $journalEntryClaimReference->claim_reference_journal_entry_id;
                                                    $this->journal_entries_model->deleteJournalEntry($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                    $this->journal_entries_model->deleteGeneralLedgerTransactions($claimReferenceJournalEntryId, 'deleted', $this->user_id);
                                                }
                                            }
                                        }
                                    }
                                } else if ($referenceTransactionTypeId == '4') {
                                    //Customer Return Note
                                    $successfulTransaction = false;

                                    $customerReturnNoteId = $referenceTransactionId;
                                    $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);

                                    $currentCashPayment = $customerReturnNote[0]->cash_payment_amount;
                                    $currentChequePayment = $customerReturnNote[0]->cheque_payment_amount;
                                    $currentBalancePayment = $customerReturnNote[0]->balance_payment;
                                    $claimAmountTotal = $customerReturnNote[0]->purchase_note_claimed;

                                    if ($refundClaimAmountTotal >= $claimAmountTotal) {
                                        $claimAmountTotal = $claimAmountTotal - $refundClaimAmountTotal;
                                        $refundClaimAmountTotal = 0;
                                    } else {
                                        $claimAmountTotal = 0;
                                        $refundClaimAmountTotal = $refundClaimAmountTotal - $claimAmountTotal;
                                    }

                                    if ($currentCashPayment >= $cashAmount) {
                                        $currentCashPayment = $currentCashPayment - $cashAmount;
                                        $currentBalancePayment = $currentBalancePayment + $cashAmount;
                                        $cashAmount = 0;
                                        $successfulTransaction = true;
                                    } else if ($currentCashPayment < $cashAmount) {
                                        $cashAmount = $cashAmount - $currentCashPayment;
                                        $currentBalancePayment = $currentBalancePayment + $currentCashPayment;
                                        $currentCashPayment = 0;
                                        $successfulTransaction = true;
                                    }

                                    if ($currentChequePayment >= $chequeAmount) {
                                        $currentChequePayment = $currentChequePayment - $chequeAmount;
                                        $currentBalancePayment = $currentBalancePayment + $chequeAmount;
                                        $chequeAmount = 0;
                                        $successfulTransaction = true;
                                    } else if ($currentChequePayment < $chequeAmount) {
                                        $chequeAmount = $chequeAmount - $currentChequePayment;
                                        $currentBalancePayment = $currentBalancePayment + $currentChequePayment;
                                        $currentChequePayment = 0;
                                        $successfulTransaction = true;
                                    }

                                    if ($successfulTransaction) {

                                        $customerReturnNoteData = array(
                                            'cash_payment_amount' => $currentCashPayment,
                                            'cheque_payment_amount' => $currentChequePayment,
                                            'balance_payment' => $currentBalancePayment,
                                            'purchase_note_claimed' => $claimAmountTotal,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->customer_return_note_model->editCustomerReturnNoteData($referenceTransactionId, $customerReturnNoteData);
                                    }
                                } else if ($referenceTransactionTypeId == '5') {
                                    $journalEntryId = $paymentReference->reference_journal_entry_id;
                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);

                                    $balanceAmount = $journalEntry[0]->balance_amount;

                                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                                    $transactionAmount = 0;
                                    if ($glTransactions && sizeof($glTransactions) > 0) {
                                        if ($glTransactions[0]->debit_value > 0) {
                                            $transactionAmount = $glTransactions[0]->debit_value;
                                        } else if ($glTransactions[0]->credit_value > 0) {
                                            $transactionAmount = $glTransactions[0]->credit_value;
                                        }
                                    }

                                    if ($cashAmount > 0) {
                                        if (($transactionAmount - $balanceAmount) >= $cashAmount) {

                                            $balanceAmount = $balanceAmount + $cashAmount;
                                            $cashAmount = 0;

                                            $journalEntryData = array(
                                                'balance_amount' => $balanceAmount,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                        } else if (($transactionAmount - $balanceAmount) < $cashAmount) {
                                            $balanceAmount = $balanceAmount + ($transactionAmount - $balanceAmount);
                                            $cashAmount = $cashAmount - ($transactionAmount - $balanceAmount);

                                            $journalEntryData = array(
                                                'balance_amount' => $balanceAmount,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                        }
                                    }

                                    if ($chequeAmount > 0) {
                                        if (($transactionAmount - $balanceAmount) >= $chequeAmount) {

                                            $balanceAmount = $balanceAmount + $chequeAmount;
                                            $chequeAmount = 0;

                                            $journalEntryData = array(
                                                'balance_amount' => $balanceAmount,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                        } else if (($transactionAmount - $balanceAmount) < $chequeAmount) {
                                            $balanceAmount = $balanceAmount + ($transactionAmount - $balanceAmount);
                                            $chequeAmount = $chequeAmount - ($transactionAmount - $balanceAmount);

                                            $journalEntryData = array(
                                                'balance_amount' => $balanceAmount,
                                                'status' => "Open",
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                                        }
                                    }
                                }
                            }
                        }

                        $this->make_payment_model->deleteMakePaymentReferenceTransactionsSoftly($makePaymentId, "deleted", $this->user_id);
                    }
                }

                $this->make_payment_model->deleteMakePaymentMethodRecordsSoftly($makePaymentId, "deleted", $this->user_id);

                $makePaymentJournalEntries = $this->make_payment_model->getMakePaymentJournalEntries($makePaymentId);

                if ($makePaymentJournalEntries && sizeof($makePaymentJournalEntries) > 0) {
                    //Delete all journal entries of Make Payment
                    foreach($makePaymentJournalEntries as $makePaymentJournalEntry) {
                        $makePaymentJournalEntryId = $makePaymentJournalEntry->make_payment_journal_entry_id;
                        $journalEntryId = $makePaymentJournalEntry->journal_entry_id;
                        $this->make_payment_model->deleteMakePaymentJournalEntry($makePaymentJournalEntryId, "deleted", $this->user_id);
                        $this->journal_entries_model->deleteJournalEntry($journalEntryId, "deleted", $this->user_id);
                        $this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, "deleted", $this->user_id);
                    }
                }

                if ($this->make_payment_model->deleteMakePayment($makePaymentId, "deleted", $this->user_id)) {
                    $html = '<div class="alert alert-success alert-dismissable">
                        <a class="close" href="#" data-dismiss="alert">x </a>
                        <h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
                        $this->lang->line('success_deleted') .
                        '</div>';
                }

                echo json_encode(array("result" => "ok", "html" => $html));
            } else {
                echo json_encode(array("result" => "previous_financial_year_is_closed", "html" => $html));
            }
		}
	}

	public function getMakePaymentData() {
		if(isset($this->data['ACM_Bookkeeping_View_Make_Payment_Permissions'])) {
			$makePaymentId = $this->db->escape_str($this->input->post('id'));
			$makePayment = $this->make_payment_model->getMakePaymentById($makePaymentId);
			$html = "";
			$referenceTransactionData = '';
			$makePaymentMethodData = '';
			if ($makePayment != null) {
				foreach ($makePayment as $row) {
					
					$html .="   <form class='form form-horizontal validate-form save_form'>
								<div class='form-group'>
									<input class='form-control'   id='make_payment_id' name='make_payment_id' type='hidden' value='{$row->make_payment_id}'>
									<label class='control-label col-sm-3'>{$this->lang->line('Reference No')} *</label>
									<div class='col-sm-4 controls'>
										<input class='form-control'  id='reference_no_edit' name='reference_no_edit'
											placeholder='{$this->lang->line('Reference No')}' type='text' value='{$row->reference_no}'>
										<div id='reference_no_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Date')} *</label>
									<div class='col-sm-4 controls'>
										<div class='datepicker-input input-group' id='datepicker_make_payment_date_edit'>
											<input class='form-control' id='make_payment_date_edit' name='make_payment_date_edit'
												data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$row->date}'>
											<span class='input-group-addon'>
												<span class='glyphicon glyphicon-calendar'/>
											</span>
										</div>
										<div id='make_payment_date_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Payee Type')} *</label>
									<div class='col-sm-4 controls'>
										<select class='form-control' name='payee_type_edit' id='payee_type_edit' onchange='getPeopleType(this.id);' disabled>
												<option value=''>" . $this->lang->line('-- Select --') . "</option>";

					$peopleTypes = $this->getPeopleType();
					$payeeType = $row->payee_type;
					$payeeId = $row->payee_id;

											foreach($peopleTypes as $peopleType){
												if ($peopleType['people_type'] == $payeeType) {
				$html .=   "							<option value='" . $peopleType['people_type'] . "' selected>" . $peopleType['people_type'] . "</option>";			
												} else {
				$html .=  	"							<option value='" . $peopleType['people_type'] . "'>" . $peopleType['people_type'] . "</option>";
												}
											}
	$html .=  	    "							</select>
										<div id='payee_type_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group' id='payee_list_div_edit'>
																	
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Location')} *</label>
									<div class='col-sm-4 controls'>
										<select class='select2 form-control' id='location_edit' disabled>";
							
					$html .=                   $this->locations_model->getLocationsToDropDownWithSavedOption($row->location_id, 'Location Name');
					$html .="               </select>
									<div id='location_editError' class='red'></div>
									</div>
								</div>
								<div id='reference_transaction_section_div_edit'>
									<div class='form-group' id='reference_transaction_type_div_edit''>
										<label class='control-label col-sm-3'>{$this->lang->line('Reference Transaction Type') }</label>
										<div class='col-sm-4 controls'>
											<select id='reference_transaction_type_init_edit'' class='form-control'><option>{$this->lang->line('-- Select --') }</option></select>
											<div id='reference_transaction_type_dropdown_edit''>
											</div>
											<div id='reference_transaction_type_id_edit'Error' class='red'></div>
										</div>
									</div>
									<div class='form-group' id='reference_transaction_div_edit''>
										<label class='control-label col-sm-3'>{$this->lang->line('Reference Transaction') }</label>
										<div class='col-sm-4 controls'>
											<select id='reference_transaction_init_edit'' class='form-control'><option>{$this->lang->line('-- Select --') }</option></select>
											<div id='reference_transaction_dropdown_edit''>
											</div>
											<div id='reference_transaction_id_edit'Error' class='red'></div>
										</div>
									</div>
									<div class='form-group' id='reference_journal_entry_div_edit''>
										<label class='control-label col-sm-3'>{$this->lang->line('Reference Journal Entry') }</label>
										<div class='col-sm-4 controls'>
											<select id='reference_journal_entry_init_edit'' class='form-control'><option>{$this->lang->line('-- Select --') }</option></select>
											<div id='reference_journal_entry_dropdown_edit''>
											</div>
											<div id='reference_journal_entry_id_edit'Error' class='red'></div>
										</div>
										<div class='col-sm-1 controls'>
											<button class='btn btn-success' type='button' id='add_reference_transaction_edit' onclick='addReferenceTransaction();'>
												<i class='icon-save'></i>
												{$this->lang->line('Add')}
											</button>
										</div>
									</div>
								</div>";
												
				$paymentReferenceList = $this->make_payment_model->getMakePaymentReferenceTransactionList($makePaymentId);
				$referenceTransactionTotalAmount = '0.00';
				$referenceTransactionRowCount = '1';
				$referenceTransactionList = array();

				if ($paymentReferenceList && sizeof($paymentReferenceList) > 0) {
					
					foreach ($paymentReferenceList as $paymentReference) {
						
						$referenceTransactionTypeId = $paymentReference->reference_transaction_type_id;
						
						$referenceJournalEntryId = $paymentReference->reference_journal_entry_id;
						$referenceJournalEntry = $this->journal_entries_model->getJournalEntryById($referenceJournalEntryId);
						$description = $referenceJournalEntry[0]->description;
						
						$referenceNo = '';
                        $transactionAmount = 0;
                        $transactionBalanceAmount = 0;
						
						$referenceTransactionId = $paymentReference->reference_transaction_id;
                        $transactionAmount = $paymentReference->claim_amount;
						
						if ($referenceTransactionTypeId == '1') {
							$purchaseNote = $this->purchase_note_model->getPurchaseNoteById($referenceTransactionId);
							
							if ($purchaseNote && sizeof($purchaseNote) > 0) {
								$referenceNo = $purchaseNote[0]->reference_no;
                                
                                if ($transactionAmount == '0.00') {
                                    $transactionAmount = $purchaseNote[0]->amount;
                                }
                                
                                $transactionBalanceAmount = $purchaseNote[0]->balance_payment;
							}
							
							$generalLedgerTransaction = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId);
							$referenceTransactionTotalAmount = $referenceTransactionTotalAmount + $transactionBalanceAmount;
						} else if ($referenceTransactionTypeId == '2') {
							$salesNote = $this->sales_note_model->getSalesNoteById($referenceTransactionId);
							
							if ($salesNote && sizeof($salesNote) > 0) {
								$referenceNo = $salesNote[0]->reference_no;
                                
                                if ($transactionAmount == '0.00') {
                                    $transactionAmount = $salesNote[0]->amount_payable;
                                }
                                
                                $transactionBalanceAmount = $salesNote[0]->balance_payment;
							}
							
							$generalLedgerTransaction = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId);
							$referenceTransactionTotalAmount = $referenceTransactionTotalAmount + $transactionBalanceAmount;
						} else if ($referenceTransactionTypeId == '3') {
							$supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($referenceTransactionId);
							
							if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {
								$referenceNo = $supplierReturnNote[0]->reference_no;
                                
                                if ($transactionAmount == '0.00') {
                                    $transactionAmount = $supplierReturnNote[0]->amount;
                                }
                                
                                $transactionBalanceAmount = $supplierReturnNote[0]->balance_payment;
							}
							
							$generalLedgerTransaction = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId);
							$referenceTransactionTotalAmount = $referenceTransactionTotalAmount + $transactionBalanceAmount;
						} else if ($referenceTransactionTypeId == '4') {
							$customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($referenceTransactionId);
							
							if ($customerReturnNote && sizeof($customerReturnNote) > 0) {
								$referenceNo = $customerReturnNote[0]->reference_no;
                                
                                if ($transactionAmount == '0.00') {
                                    $transactionAmount = $customerReturnNote[0]->amount;
                                }
                                
                                $transactionBalanceAmount = $customerReturnNote[0]->balance_payment;
							}
							
							$generalLedgerTransaction = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId);
							$referenceTransactionTotalAmount = $referenceTransactionTotalAmount + $transactionBalanceAmount;
						} else if ($referenceTransactionTypeId == '5') {
                            $journalEntry = $this->journal_entries_model->getJournalEntryById($referenceJournalEntryId);
                            $transactionBalanceAmount = $journalEntry[0]->balance_amount;
                            $referenceTransactionTotalAmount = $referenceTransactionTotalAmount + $transactionBalanceAmount;
						}
						
						$referenceTransactionList[] = $referenceNo;
						
				$referenceTransactionData .= "	<tr id='row_edit_" . $referenceTransactionRowCount . "'> 
								<input class='form-control' id='reference_transaction_type_edit_" . $referenceTransactionRowCount . "' name='reference_transaction_type_edit_" . $referenceTransactionRowCount . "' type='hidden' value='" . $referenceTransactionTypeId . "'>
								<input class='form-control' id='reference_transaction_id_edit_" . $referenceTransactionRowCount . "' name='reference_transaction_id_edit_" . $referenceTransactionRowCount . "' type='hidden' value='" . $referenceTransactionId . "'>
								<input class='form-control' id='reference_journal_entry_id_edit_" . $referenceTransactionRowCount . "' name='reference_journal_entry_id_edit_" . $referenceTransactionRowCount . "' type='hidden' value='" . $referenceJournalEntryId . "'>
								<input class='form-control' id='reference_transaction_amount_edit_" . $referenceTransactionRowCount . "' name='reference_transaction_amount_edit_" . $referenceTransactionRowCount . "' type='hidden' value='" . $transactionAmount . "'>
                                <td id='reference_transaction_edit_" . $referenceTransactionRowCount . "'>" . $referenceNo . "</td>
								<td>" . $description . "</td>
								<td id='reference_transaction_balance_amount_edit_" . $referenceTransactionRowCount . "'>" . $transactionBalanceAmount . "</td>
								<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_edit_" . $referenceTransactionRowCount . "' title='{$this->lang->line('Delete')}' onclick='deleteReferenceTransaction(this.id);'>
										<i class='icon-remove'></i>
									 </a>
								</td>
							</tr>";
				
						$referenceTransactionRowCount++;
					}
				}
											
				$html .="		<div id='make_payment_reference_list_edit'>
									<h4>{$this->lang->line('Reference Transactions')}</h4>
									<div class='box-content box-no-padding out-table'>
										<div class='table-responsive table_data'>
											<div class='scrollable-area1'>
												<table class='table table-striped table-bordered makePaymentReferenceDataEditTable' style='margin-bottom:0;'>
													<thead>
														<tr>
															<th>{$this->lang->line('Reference Transaction')}</th>
															<th>{$this->lang->line('Reference Journal Entry')}</th>
															<th>{$this->lang->line('Balance Transaction Amount')}</th>
															<th>{$this->lang->line('Actions')}</th>
														</tr>
													</thead>
													<tbody>"  
														. $referenceTransactionData .
														"<tr id='make_payment_reference_amount_total_edit'>
															<td>{$this->lang->line('Total')}</td>
															<td></td>
															<td id='reference_amount_total_edit'>" . number_format($referenceTransactionTotalAmount, 2) . "</td>
															<td></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div><br>
								</div>

								<div class='box' id='make_payment_method_list_edit'>
									<div class='box-content'>
										<div class='form-group'>
											<div class='col-sm-12 controls' style='text-align:center;'>
												<label class='control-label col-sm-5'>{$this->lang->line('Amount to Add for Payment Type')}</label>
												<div class='col-sm-4 controls'>
													<input class='form-control input-sm' id='amount_to_add_payment_type_edit' name='amount_to_add_payment_type_edit' type='text' disabled>
													<div id='amount_to_add_payment_typeError' class='red'></div>
												</div>
											</div>
										</div>
										<div class='tabbable' style='margin-top: 20px'>
											<ul class='nav nav-responsive nav-tabs'>
												<li class='active'>
													<a data-toggle='tab' class='tab-header' href='#cash_payment_edit'>{$this->lang->line('Cash Payment')}</a>
												</li>
												<li class=''>
													<a data-toggle='tab' class='tab-header' href='#cheque_payment_edit'>{$this->lang->line('Cheque Payment')}</a>
												</li>
												<li class=''>
													<a data-toggle='tab' class='tab-header' href='#second_party_cheque_payment_edit'>{$this->lang->line('Second Party Cheque Payment')}</a>
												</li>
												<li class=''>
													<a data-toggle='tab' class='tab-header' href='#third_party_cheque_payment_edit'>{$this->lang->line('Third Party Cheque Payment')}</a>
												</li>
											</ul>
											<div class='tab-content'>
												<div id='cash_payment_edit' class='tab-pane active'>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-2'>{$this->lang->line('Cash Payment')} *</label>
															<div class='col-sm-4 controls'>
																<input class='form-control input-sm' id='cash_payment_amount_edit' name='cash_payment_amount' placeholder='{$this->lang->line('Cash Payment')}' type='text'>
																<div id='cash_payment_amount_editError' class='red'></div>
															</div>
														</div>
														<br><br>
														<div class='form-group'>
															<div class='col-sm-9 col-sm-offset-3'>
																<button class='btn btn-success save'
																		onclick='addCashPayment();' type='button'>
																	<i class='icon-save'></i>
																	{$this->lang->line('Add')}
																</button>
															</div>
														</div>
													</div>
												</div>
												<div id='cheque_payment_edit' class='tab-pane'>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Payment Account')} *</label>
														<div class='col-sm-4 controls'>
															<select id='payment_account_init_edit' class='form-control'><option>{$this->lang->line('-- Select --')}</option></select>
															<!--Payment account drop down-->
															<div id='payment_account_dropdown_edit'>
															</div>
															<!--End payment account drop down-->
															<div id='payment_account_id_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Cheque Number')} *</label>
														<div class='col-sm-4 controls' id='cheque_number_div_edit'>
															<input class='form-control' id='cheque_number_edit' name='cheque_number_edit'
																   placeholder='{$this->lang->line('Cheque Number')}' type='text' value=''>
															<div id='cheque_number_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Bank')} *</label>
														<div class='col-sm-4 controls'>
															<select id='bank_init_edit' class='form-control'><option>{$this->lang->line('-- Select --')}</option></select>
															<!--Bank drop down-->
															<div id='bank_dropdown_edit'>
															</div>
															<!--End bank drop down-->
															<div id='bank_id_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Cheque Date')} *</label>
														<div class='col-sm-4 controls' id='cheque_date_div_edit'>
															<div class='datepicker-input input-group' id='datepicker_cheque_date_edit'>
																<input class='form-control' id='cheque_date_edit' name='cheque_date_edit'
																	   data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Cheque Date')}' type='text' value=''>
																  <span class='input-group-addon'>
																		<span class='glyphicon glyphicon-calendar'/>
																  </span>
															</div>
															<div id='cheque_date_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Amount')} *</label>
														<div class='col-sm-4 controls'>
															<input class='form-control input-sm' id='cheque_payment_amount_edit' name='cheque_payment_amount_edit' placeholder='{$this->lang->line('Amount')}' type='text'>
															<div id='cheque_payment_amount_editError' class='red'></div>
														</div>
														<br><br>
														<div class='form-group'>
															<div class='col-sm-9 col-sm-offset-4'>
																<button class='btn btn-success save'
																		onclick='addChequePayment();' type='button'>
																	<i class='icon-save'></i>
																	{$this->lang->line('Add')}
																</button>
															</div>
														</div>
													</div>
												</div>
												<div id='second_party_cheque_payment_edit' class='tab-pane'>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Second Party Cheque Number')} *</label>
														<div class='col-sm-4 controls'>
															<select id='second_party_cheque_number_init_edit' class='form-control'><option>{$this->lang->line('-- Select --')}</option></select>
															<!--Second party cheque number drop down-->
															<div id='second_party_cheque_number_dropdown_edit'>
															</div>
															<!--End payment account drop down-->
															<div id='second_party_cheque_id_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
                                                        <input class='form-control' id='second_party_cheque_bank_id_edit' name='second_party_cheque_bank_id_edit' type='hidden'>
														<label class='control-label col-sm-3'>{$this->lang->line('Bank')}</label>
														<div class='col-sm-4 controls' id='bank_div_edit'>
															<input class='form-control' id='second_party_cheque_bank_edit' name='second_party_cheque_bank_edit'
																   placeholder='{$this->lang->line('Bank')}' type='text' 
																   value='' disabled>
															<div id='second_party_cheque_bank_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Cheque Date')}</label>
														<div class='col-sm-4 controls' id='second_party_cheque_date_div_edit'>
															<div class='datepicker-input input-group' id='datepicker_second_party_cheque_date_edit'>
																<input class='form-control' id='second_party_cheque_date_edit' name='second_party_cheque_date_edit'
																	   data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Cheque Date')}' type='text' value='' disabled>
																  <span class='input-group-addon'>
																		<span class='glyphicon glyphicon-calendar'/>
																  </span>
															</div>
															<div id='second_party_cheque_date_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Amount')}</label>
														<div class='col-sm-4 controls'>
															<input class='form-control input-sm' id='second_party_cheque_payment_amount_edit' name='second_party_cheque_payment_amount_edit' placeholder='{$this->lang->line('Amount')}' type='text' disabled>
															<div id='second_party_cheque_payment_amount_editError' class='red'></div>
														</div>
														<br><br>
														<div class='form-group'>
															<div class='col-sm-9 col-sm-offset-4'>
																<button class='btn btn-success save'
																		onclick='addSecondPartyChequePayment();' type='button'>
																	<i class='icon-save'></i>
																	{$this->lang->line('Add')}
																</button>
															</div>
														</div>
													</div>
												</div>
												<div id='third_party_cheque_payment_edit' class='tab-pane'>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Third Party Cheque Number')} *</label>
														<div class='col-sm-4 controls'>
															<select id='third_party_cheque_number_init_edit' class='form-control'><option>{$this->lang->line('-- Select --')}</option></select>
															<!--Third party cheque number drop down-->
															<div id='third_party_cheque_number_dropdown_edit'>
															</div>
															<!--End payment account drop down-->
															<div id='third_party_cheque_id_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
                                                        <input class='form-control' id='third_party_cheque_bank_id_edit' name='third_party_cheque_bank_id_edit' type='hidden'>
														<label class='control-label col-sm-3'>{$this->lang->line('Bank')}</label>
														<div class='col-sm-4 controls' id='bank_div_edit'>
															<input class='form-control' id='third_party_cheque_bank_edit' name='third_party_cheque_bank_edit'
																   placeholder='{$this->lang->line('Bank')}' type='text' 
																   value='' disabled>
															<div id='third_party_cheque_bank_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Cheque Date')}</label>
														<div class='col-sm-4 controls' id='third_party_cheque_date_div_edit'>
															<div class='datepicker-input input-group' id='datepicker_third_party_cheque_date_edit'>
																<input class='form-control' id='third_party_cheque_date_edit' name='third_party_cheque_date_edit'
																	   data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Cheque Date')}' type='text' value='' disabled>
																  <span class='input-group-addon'>
																		<span class='glyphicon glyphicon-calendar'/>
																  </span>
															</div>
															<div id='third_party_cheque_date_editError' class='red'></div>
														</div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Amount')}</label>
														<div class='col-sm-4 controls'>
															<input class='form-control input-sm' id='third_party_cheque_payment_amount_edit' name='third_party_cheque_payment_amount_edit' placeholder='{$this->lang->line('Amount')}' type='text' disabled>
															<div id='third_party_cheque_payment_amount_editError' class='red'></div>
														</div>
														<br><br>
														<div class='form-group'>
															<div class='col-sm-9 col-sm-offset-4'>
																<button class='btn btn-success save'
																		onclick='addThirdPartyChequePayment();' type='button'>
																	<i class='icon-save'></i>
																	{$this->lang->line('Add')}
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>";
																	
					$paymentMethodList = $this->make_payment_model->getMakePaymentMethodList($makePaymentId);
					$makePaymentTotal = '0.00';
					$makePaymentMethodRowCount = '1';
					
					if ($paymentMethodList && sizeof($paymentMethodList) > 0) {
						
						foreach ($paymentMethodList as $paymentMethodRecord) {
							
							$paymentMethod = $paymentMethodRecord->payment_method;
                            $cashPaymentId = $paymentMethodRecord->cash_payment_id;
							$paymentAccountId = $paymentMethodRecord->payment_account_id;
							$chequeId = $paymentMethodRecord->cheque_id;
							
							$chequeNumber = '';
							$bankId = '';
							$chequeDate = '';
							$bankName = '';
                            $amount = '0.00';
                            
                            if ($cashPaymentId != '0') {
                                if ($paymentMethod == "Cash Payment") {
                                    $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
                                    
                                    if ($cashPayment && sizeof($cashPayment) > 0) {
                                        $amount = $cashPayment[0]->amount;
                                    }
                                }
                            }
							
							if ($chequeId != '0') {
								if ($paymentMethod == "Cheque Payment") {
									$cheque = $this->payments_model->getExpenseChequeById($chequeId);

									if ($cheque && sizeof($cheque) > 0) {
										$chequeNumber = $cheque[0]->cheque_number;
										$bankId = $cheque[0]->bank;
                                        
                                        if ($bankId != '') {
                                            $bank = $this->bank_model->getById($bankId);
                                            if ($bank && sizeof($bank) > 0) {
                                                $bankName = $bank[0]->bank_name;
                                            }
                                        }
                            
										$chequeDate = $cheque[0]->cheque_date;
                                        $amount = $cheque[0]->amount;
									}
								} else if ($paymentMethod == "Second Party Cheque Payment" || $paymentMethod == "Third Party Cheque Payment") {
									$cheque = $this->payments_model->getExpenseChequeById($chequeId);

									if ($cheque && sizeof($cheque) > 0) {
										$chequeNumber = $cheque[0]->cheque_number;
										$bankId = $cheque[0]->bank;
                                        
                                        if ($bankId != '') {
                                            $bank = $this->bank_model->getById($bankId);
                                            if ($bank && sizeof($bank) > 0) {
                                                $bankName = $bank[0]->bank_name;
                                            }
                                        }
                                        
										$chequeDate = $cheque[0]->cheque_date;
                                        $amount = $cheque[0]->amount;
									}
								}
							}
							
							$makePaymentTotal = $makePaymentTotal + $amount;
							
		$makePaymentMethodData .= "<tr id='payment_method_row_edit_" . $makePaymentMethodRowCount . "'>
							       <input class='form-control' id='payment_account_id_edit_" . $makePaymentMethodRowCount . "' name='payment_account_id_edit_" . $makePaymentMethodRowCount . "' type='hidden' value='" . $paymentAccountId . "'>
							       <input class='form-control' id='cheque_id_edit_" . $makePaymentMethodRowCount . "' name='cheque_id_edit_" . $makePaymentMethodRowCount . "' type='hidden' value='" . $chequeId . "'>
							       <input class='form-control' id='bank_id_edit_" . $makePaymentMethodRowCount . "' name='bank_id_edit_" . $makePaymentMethodRowCount . "' type='hidden' value='" . $bankId . "'>
								<td id='make_payment_method_edit_" . $makePaymentMethodRowCount . "'>" . $paymentMethod . "</td>
								<td id='cheque_number_edit_" . $makePaymentMethodRowCount . "'>" . $chequeNumber . "</td>
								<td id='bank_edit_" . $makePaymentMethodRowCount . "'>" . $bankName . "</td>
								<td id='cheque_date_edit_" . $makePaymentMethodRowCount . "'>" . $chequeDate . "</td>
								<td id='amount_edit_" . $makePaymentMethodRowCount . "'>" . number_format($amount, 2) . "</td>
								<td><a class='btn btn-danger btn-xs delete' id='delete_make_payment_method_edit_" . $makePaymentMethodRowCount . "' title='{$this->lang->line('Delete')}' onclick='deleteMakePaymentMethod(this.id);'>
										<i class='icon-remove'></i>
									 </a></td>
								</tr>";
								
							$makePaymentMethodRowCount++;
						}
					}

					$html .="	<div id='make_payment_method_records_edit'>
									<h4>{$this->lang->line('Payment Method List')}</h4>
									<div class='box-content box-no-padding out-table'>
										<div class='table-responsive table_data'>
											<div class='scrollable-area1'>
												<table class='table table-striped table-bordered makePaymentMethodDataEditTable' style='margin-bottom:0;'>
													<thead>
														<tr>
															<th>{$this->lang->line('Payment Method')}</th>
															<th>{$this->lang->line('Cheque Number')}</th>
															<th>{$this->lang->line('Bank')}</th>
															<th>{$this->lang->line('Cheque Date')}</th>
															<th>{$this->lang->line('Amount')}</th>
															<th>{$this->lang->line('Actions')}</th>
														</tr>
													</thead>
													<tbody>"
														. $makePaymentMethodData . 
														"<tr id='make_payment_method_amount_total_edit'>		
															<td>{$this->lang->line('Total')}</td>
															<td></td>
															<td></td>
															<td></td>
															<td id='payment_method_amount_total_edit'>" . number_format($makePaymentTotal, 2) . "</td>
															<td></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div><br>
								</div>";

								$referenceTransactionType = $this->getReferenceTransactionTypesDropdown();
								$amount = number_format($makePaymentTotal, 2);
				$html .="			<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Amount')}</label>
									<div class='col-sm-4 controls'>
										<input class='form-control'  id='amount_edit' name='amount_edit'
											placeholder='{$this->lang->line('Amount')}' type='text' value='{$amount}' onblur='handleAmountAddition()' disabled>
										<div id='amount_editError' class='red'></div>
									</div>
								</div>";
					$remark = preg_replace('~\\\r\\\n~',"<br>", $row->remark);
					$remark = str_ireplace("<br>", "\r\n", $remark);

					$html .="       <div class='form-group'  id='remark_group_edit'>
									<label class='control-label col-sm-3'>{$this->lang->line('Remark')}</label>
									<div class='col-sm-4 controls'>
										<textarea class='form-control' id='remark_edit' name='remark_edit'
											placeholder='{$this->lang->line('Remark')}'>{$remark}</textarea>
									</div>
								</div>
								<div class='form-actions' style='margin-bottom:0'>
									<div class='row'>
										<div class='col-sm-9 col-sm-offset-3'>";
											if(isset($this->data['ACM_Bookkeeping_Edit_Make_Payment_Permissions'])) {
												$html .= "<button class='btn btn-success save' onclick='editMakePaymentData({$row->make_payment_id});' type='button' id='make_payment_edit_button'>
															<i class='icon-save'></i>
															{$this->lang->line('Edit')}
														</button> ";
											}
								$html.="            <button class='btn btn-warning cancel' onclick='closeMakePaymentEditForm({$row->make_payment_id});' type='button'>
												<i class='icon-remove'></i>
												{$this->lang->line('Close')}
											</button>
										</div>
									</div>
								</div>
							</form>";
					                         
                    $amountToAddForPaymentType =  $referenceTransactionTotalAmount;
				}
			}

			echo json_encode(array('result' => $html, 'payeeType' => $payeeType, 'payeeId' => $payeeId, 'referenceTransactionType' => $referenceTransactionType, 'referenceTransactionList' => $referenceTransactionList, 'referenceTransactionRowCount' => $referenceTransactionRowCount - 1, 'makePaymentMethodRowCount' => $makePaymentMethodRowCount - 1, 'referenceTransactionTotalAmount' => $referenceTransactionTotalAmount, 'transactionMethodAmountTotal' => $makePaymentTotal,  'amountToAddForPaymentType' => $amountToAddForPaymentType));
		}
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Make_Payment_Permissions'])) {
			
			$hideMonthFilter = false;
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			$payeeId = $this->db->escape_str($this->input->post('payee_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
			
			if ($year != "" && $month != "") {
				$length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$fromDate = $year . '-' . $month . '-1';
				$toDate = $year . '-' . $month . '-' . $length;
			} else {
				$fromDate = "";
				$toDate = "";
				$hideMonthFilter = true;
			}
			
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
					<div class='table-responsive table_data'>
						<div class='scrollable-area1'>
							<table class='table table-striped table-bordered makePaymentDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Reference No')}</th>
										<th>{$this->lang->line('Date')}</th>
										<th>{$this->lang->line('Payee')}</th>
										<th>{$this->lang->line('Location')}</th>
										<th>{$this->lang->line('Actions')}</th>
									</tr>
								</thead>
								<tbody>";
			
			$makePayments = $this->make_payment_model->getAllForPeriod($fromDate, $toDate, $payeeId, $locationId, 'date', 'desc');

			if ($makePayments != null) {
				foreach ($makePayments as $row) {
					
					$html .= "<tr>";
					$html .= "<td>" . $row->reference_no . "</td>";
					$html .= "<td>" . $row->date . "</td>";
					$html .= "<td>" . $row->people_name . "</td>";
					$html .= "<td>" . $row->location_name . "</td>";
					$html .= "<td>
											<div class='text-left'>";
											if(isset($this->data['ACM_Bookkeeping_Edit_Make_Payment_Permissions'])) {
												$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->make_payment_id}' title='{$this->lang->line('Edit')}' onclick='getMakePaymentData({$row->make_payment_id});'>
																						<i class='icon-wrench'></i>
																					</a> ";
											}
											if(isset($this->data['ACM_Bookkeeping_Delete_Make_Payment_Permissions'])) {
												$html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->make_payment_id}' title='{$this->lang->line('Delete')}' onclick='del($row->make_payment_id);'>
													<i class='icon-remove'></i>
												</a>";
											}
								$html.="    </div>
										</td>";
					$html .= "</tr>";
				}
			}
			$html .=    "</tbody>
							</table>
						</div>
					</div>
				</div>";
			
			echo json_encode(array('html' => $html, 'hideMonthFilter' => $hideMonthFilter));
		}
	}
    
    public function postReferenceJournalEntries($primeEntryBooksToUpdate, $journalEntries, $date, $referenceNo, $referenceTransactionTypeId, 
            $referenceTransactionEntryId, $referenceJournalEntryId, $claimReferenceNo, $locationId, $payeePayerType, $payeePayerId, $amount) {
		
		$journalEntryId = '';
		
		if ($primeEntryBooksToUpdate && sizeof($primeEntryBooksToUpdate) > 0) {
			if (!$journalEntries) {
				//Add journal entry records
				
                if ($referenceTransactionTypeId == '1') {
                    $description = $this->lang->line('Journal entry for purchase note claim transaction for Purchase Note number : ') . $referenceNo . $this->lang->line(' [Claim : ') . $claimReferenceNo . ']';
                } else if ($referenceTransactionTypeId == '4') {
                    $description = $this->lang->line('Journal entry for customer return note claim transaction for Customer Return Note number : ') . $referenceNo . $this->lang->line(' [Claim : ') . $claimReferenceNo . ']';
                }
                
                foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                    $primeEntryBookId = $primeEntryBook->config_filed_value;
                    $data = array(
                        'prime_entry_book_id' => $primeEntryBookId,
                        'transaction_date' => $date,
                        'reference_no' => $referenceNo,
                        'location_id' => $locationId,
                        'payee_payer_type' => $payeePayerType,
                        'payee_payer_id' => $payeePayerId,
                        'reference_transaction_type_id' => $referenceTransactionTypeId,
                        'reference_transaction_id' => $referenceTransactionEntryId,
                        'reference_journal_entry_id' => $referenceJournalEntryId,
                        'description' => $description,
                        'post_type' => "Indirect",
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'added'
                    );

                    $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                    $amount = str_replace(',', '', $amount);

                    foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {
                        if ($chartOfAccount->debit_or_credit == "debit") {
                            $data = array(
                                'journal_entry_id' => $journalEntryId,
                                'prime_entry_book_id' => $primeEntryBookId,
                                'transaction_date' => $date,
                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                'debit_value' => $amount,
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );
                        } else if ($chartOfAccount->debit_or_credit == "credit") {
                            $data = array(
                                'journal_entry_id' => $journalEntryId,
                                'prime_entry_book_id' => $primeEntryBookId,
                                'transaction_date' => $date,
                                'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                'credit_value' => $amount,
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );
                        }

                        $this->journal_entries_model->addGeneralLedgerTransaction($data);

                        //Same time add the data to previous years record table.
                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                    }
                }
			} else if ($journalEntries && sizeof($journalEntries) > 0) {
				//Get general ledger transactions to update new amount
				foreach($journalEntries as $salesNoteJournalEntry) {
					$primeEntryBookId = $salesNoteJournalEntry[0]->prime_entry_book_id;
					$journalEntryId = $salesNoteJournalEntry[0]->journal_entry_id;
                    
                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                    $generalLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($journalEntryId, $primeEntryBookId);
                    $amount = str_replace(',', '', $amount);

                    foreach($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {
                        foreach($generalLedgerTransactions as $generalLedgerTransaction) {
                            if ($generalLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'debit') {

                                $data = array(
                                    'debit_value' => $amount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);

                                //Same time edit the data in previous years record table.
                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);
                            } else if ($generalLedgerTransaction->chart_of_account_id == $primeEntryBookChartOfAccount->chart_of_account_id && $primeEntryBookChartOfAccount->debit_or_credit == 'credit') {

                                $data = array(
                                    'credit_value' => $amount,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);

                                //Same time edit the data in previous years record table.
                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $generalLedgerTransaction->chart_of_account_id, $data);
                            }
                        }
                    }
				}
			}
		}
		
		return $journalEntryId;
	}

	//check user permission
	public function hasPermission($user_roles, $data) {
		foreach ($user_roles as $row) {
			$data[$row->permission] = $row->permission;
		}
		return $data;
	}

	public function check_existing($reference_no) {
		$exist = false;
		$result = $this->make_payment_model->checkExistingMakePayment($reference_no);
		$makePaymentId = $this->db->escape_str($this->input->post('id'));

		if ($makePaymentId != '' && $result) {
			if ($makePaymentId !=  $result[0]->make_payment_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Make Payment') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	public function getLastMakePaymentNumber() {
		$refNo = $this->make_payment_model->getMaxMakePaymentNo();
		$lastMakePayment = $this->make_payment_model->getMakePaymentByIdConsideringDeletedMakePayment($refNo[0]->make_payment_id);
		//echo "<pre>";print_r($lastMakePayment);die;
		if ($lastMakePayment && sizeof($lastMakePayment) > 0) {
			return $lastMakePayment[0]->reference_no;
		} else {
			return "Nill";
		}
	}

	public function isMakePaymentNumberAutoIncrementEnabled() {
		return $this->system_configurations_model->isBookkeepingMakePaymentNumberAutoIncrementEnabled();
	}

	public function getNextReferenceNo() {
		if ($this->isMakePaymentNumberAutoIncrementEnabled()) {
			$lastMakePaymentNo = $this->getLastMakePaymentNumber();
			$makePaymentReferenceNoCodeData = $this->system_configurations_model->getBookkeepingMakePaymentReferenceNoCode();
			$makePaymentReferenceNoCode = $makePaymentReferenceNoCodeData[0]->config_filed_value;
			$makePaymentReferenceNoSeparatorData = $this->system_configurations_model->getBookkeepingMakePaymentReferenceNoSeparator();
			$makePaymentReferenceNoSeparator = $makePaymentReferenceNoSeparatorData[0]->config_filed_value;
			$makePaymentReferenceNoStartNumberData = $this->system_configurations_model->getBookkeepingMakePaymentReferenceNoStartNumber();
			$makePaymentReferenceNoStartNumber = $makePaymentReferenceNoStartNumberData[0]->config_filed_value;

			if ($lastMakePaymentNo != 'Nill') {
				if ($makePaymentReferenceNoSeparator != '') {
					$lastMakePaymentNoElements = explode($makePaymentReferenceNoSeparator, $lastMakePaymentNo);
					$makePaymentNo = $lastMakePaymentNoElements[1];
					$result = $makePaymentReferenceNoCode . $makePaymentReferenceNoSeparator . ($makePaymentNo + 1);
				} else {
					$makePaymentReferenceNoCodeLength = strlen($makePaymentReferenceNoCode);
					$makePaymentNo = substr($lastMakePaymentNo, $makePaymentReferenceNoCodeLength);
					$result = $makePaymentReferenceNoCode . $makePaymentReferenceNoSeparator . ($makePaymentNo + 1);
				}
			} else {
				$result = $makePaymentReferenceNoCode . $makePaymentReferenceNoSeparator . $makePaymentReferenceNoStartNumber;
			}

			$status = "auto_increment";
		} else {
			$lastMakePaymentNo = $this->getLastMakePaymentNumber();
			$result = "<label class='control-label col-sm-3' id='last_reference_no_label' style='text-align:left; color: #2eb82e;'>"
					. "{$this->lang->line('Last Reference Number : ')}" . $lastMakePaymentNo . "</label>";
			$status = "manual_increment";
		}

		echo json_encode(array('status' => $status, 'result' => $result));
	}

	public function getPrimeEntryBooksToUpdateForMakePaymentCashTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getMakePaymentCashAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForMakePaymentChequeTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getMakePaymentChequeAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForMakePaymentSecondOrThirdPartyChequeTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function forceToSelectAReferenceTransactionForMakeAPayment() {
		return $this->system_configurations_model->forceToSelectAReferenceTransactionForMakeAPayment();
	}
    
    public function getMakeAPaymentDefaultPayeeType() {
		return $this->system_configurations_model->getMakeAPaymentDefaultPayeeType();
	}
    
    public function getMakeAPaymentDefaultReferenceTransactionType() {
        return $this->system_configurations_model->getMakeAPaymentDefaultReferenceTransactionType();
    }

    public function isSelectReferenceJournalEntryAutomaticallyEnabled() {
        return $this->system_configurations_model->isMakePaymentSelectReferenceJournalEntryAutomaticallyEnabled();
    }
    
    public function isAllowPartialPaymentForReferenceTransactionsEnabled() {
        return $this->system_configurations_model->isMakePaymentAllowPartialPaymentForReferenceTransactionsEnabled();
    }

    public function getReferenceTransactionTypesDropdown() {
		return $this->common_functions->getReferenceTransactionTypesToDropDown();
	}
	
	public function getReferenceTransactionTypesDropdownWithSavedOption($selectedIndex) {
		return $this->common_functions->getReferenceTransactionTypesToDropDownWithSavedOption($selectedIndex);
	}
	
	public function getReferenceTransactionListForSelectedType($transactionTypeId=null, $selectedIndex=null) {
		
		if ($transactionTypeId == '') {
			$transactionTypeId = $this->db->escape_str($this->input->post('transaction_type_id'));
		}
		
		$transactionTypeList = '';
		
		switch ($transactionTypeId) {
			//Finish Good Good Make Note
			case '1':

				$allGRNs = $this->good_receive_note_fg_model->getAllGRNIdsAndAllReferenceNumbers('reference_no', 'asc');
				$transactionTypeList = "   <select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allGRNs && sizeof($allGRNs) > 0) {
					foreach ($allGRNs as $grn) {
						if ($selectedIndex == '') {
							$transactionTypeList .=          "<option value='" . $grn->grn_id  . "' >" . $grn->reference_no . "</option>";
						} else {
							if ($selectedIndex == $grn->grn_id) {
								$transactionTypeList .=          "<option value='" . $grn->grn_id  . "' selected>" . $grn->reference_no . "</option>";
							} else {
								$transactionTypeList .=          "<option value='" . $grn->grn_id  . "' >" . $grn->reference_no . "</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
			
			//Finish Good Supplier Return
			case '2':

				$allSupplierReturns = $this->supplier_return_fg_model->getAllSupplierReturnIdsAndAllReferenceNumbers('reference_no', 'asc');
				$transactionTypeList = "   <select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allSupplierReturns && sizeof($allSupplierReturns) > 0) {
					foreach ($allSupplierReturns as $supplierReturn) {
						if ($selectedIndex == '') {
							$transactionTypeList .=          "<option value='" . $supplierReturn->supplier_return_id  . "' >" . $supplierReturn->reference_no . "</option>";
						} else {
							if ($selectedIndex == $supplierReturn->supplier_return_id) {
								$transactionTypeList .=          "<option value='" . $supplierReturn->supplier_return_id  . "' selected>" . $supplierReturn->reference_no . "</option>";
							} else {
								$transactionTypeList .=          "<option value='" . $supplierReturn->supplier_return_id  . "' >" . $supplierReturn->reference_no . "</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
			
			//Raw Material Good Make Note
			case '3':

				$allGRNs = $this->good_receive_note_rm_model->getAllGRNIdsAndAllReferenceNumbers('reference_no', 'asc');
				$transactionTypeList = "   <select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allGRNs && sizeof($allGRNs) > 0) {
					foreach ($allGRNs as $grn) {
						if ($selectedIndex == '') {
							$transactionTypeList .=          "<option value='" . $grn->grn_id  . "' >" . $grn->reference_no . "</option>";
						} else {
							if ($selectedIndex == $grn->grn_id) {
								$transactionTypeList .=          "<option value='" . $grn->grn_id  . "' selected>" . $grn->reference_no . "</option>";
							} else {
								$transactionTypeList .=          "<option value='" . $grn->grn_id  . "' >" . $grn->reference_no . "</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
			
			//Raw Material Supplier Return
			case '4':

				$allSupplierReturns = $this->supplier_return_rm_model->getAllSupplierReturnIdsAndAllReferenceNumbers('reference_no', 'asc');
				$transactionTypeList = "   <select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allSupplierReturns && sizeof($allSupplierReturns) > 0) {
					foreach ($allSupplierReturns as $supplierReturn) {
						if ($selectedIndex == '') {
							$transactionTypeList .=          "<option value='" . $supplierReturn->supplier_return_id  . "' >" . $supplierReturn->reference_no . "</option>";
						} else {
							if ($selectedIndex == $supplierReturn->supplier_return_id) {
								$transactionTypeList .=          "<option value='" . $supplierReturn->supplier_return_id  . "' selected>" . $supplierReturn->reference_no . "</option>";
							} else {
								$transactionTypeList .=          "<option value='" . $supplierReturn->supplier_return_id  . "' >" . $supplierReturn->reference_no . "</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
			
			//Sales Invoice
			case '5':

				$allSalesInvoices = $this->sales_invoice_model->getAllSalesInvoiceIdsAndAllReferenceNumbers('reference_no', 'asc');
				$transactionTypeList = "   <select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allSalesInvoices && sizeof($allSalesInvoices) > 0) {
					foreach ($allSalesInvoices as $salesInvoice) {
						if ($selectedIndex == '') {
							$transactionTypeList .=          "<option value='" . $salesInvoice->sales_invoice_id  . "' >" . $salesInvoice->reference_no . "</option>";
						} else {
							if ($selectedIndex == $salesInvoice->sales_invoice_id) {
								$transactionTypeList .=          "<option value='" . $salesInvoice->sales_invoice_id  . "' selected>" . $salesInvoice->reference_no . "</option>";
							} else {
								$transactionTypeList .=          "<option value='" . $salesInvoice->sales_invoice_id  . "' >" . $salesInvoice->reference_no . "</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
			
			//Sales Return
			case '6':

				$allSalesReturns = $this->sales_return_model->getAllSalesReturnIdsAndAllReferenceNumbers('reference_no', 'asc');
				$transactionTypeList = "   <select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allSalesReturns && sizeof($allSalesReturns) > 0) {
					foreach ($allSalesReturns as $salesReturns) {
						if ($selectedIndex == '') {
							$transactionTypeList .=          "<option value='" . $salesReturns->sales_return_id  . "' >" . $salesReturns->reference_no . "</option>";
						} else {
							if ($selectedIndex == $salesReturns->sales_return_id) {
								$transactionTypeList .=          "<option value='" . $salesReturns->sales_return_id  . "' selected>" . $salesReturns->reference_no . "</option>";
							} else {
								$transactionTypeList .=          "<option value='" . $salesReturns->sales_return_id  . "' >" . $salesReturns->reference_no . "</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
				
			//Other
			case '7':
				
				$transactionTypeList = 'other';

			default:
				break;
		}
		
		if ($selectedIndex == '') {
			echo $transactionTypeList;
		} else {
			return $transactionTypeList;
		}
	}
	
	public function getReferenceJournalEntryListForSelectedTransaction($transactionTypeId=null, $transactionReferenceId=null, $selectedIndex=null) {
		
		$transactionReferenceNo = '';
		if ($transactionTypeId == '') {
			$transactionTypeId = $this->db->escape_str($this->input->post('transaction_type_id'));
			$transactionReferenceNo = $this->db->escape_str($this->input->post('transaction_reference_no'));
		}
		
		$journalEntryList = '';
		
		switch ($transactionTypeId) {
			//Finish Good Good Make Note
			case '1':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'finish good');
				} else {
					$grn = $this->good_receive_note_fg_model->getGRNById($transactionReferenceId);
					if ($grn && sizeof($grn) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($grn[0]->reference_no, 'finish good');
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach ($journalEntries as $journalEntry) {
						if ($selectedIndex == '') {
							$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
						} else {
							if ($selectedIndex == $journalEntry->journal_entry_id) {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' selected>" . $journalEntry->description . "</option>";
							} else {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
							}
						}
					}
				}
				
				$journalEntryList .="   </select>";

				break;
			
			//Finish Good Supplier Return
			case '2':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'finish good');
				} else {
					$supplierReturn = $this->supplier_return_fg_model->getSupplierReturnById($transactionReferenceId);
					if ($supplierReturn && sizeof($supplierReturn) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($supplierReturn[0]->reference_no, 'finish good');
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach ($journalEntries as $journalEntry) {
						if ($selectedIndex == '') {
							$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
						} else {
							if ($selectedIndex == $journalEntry->journal_entry_id) {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' selected>" . $journalEntry->description . "</option>";
							} else {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
							}
						}
					}
				}
				
				$journalEntryList .="   </select>";

				break;
			
			//Raw Material Good Make Note
			case '3':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'raw material');
				} else {
					$grn = $this->good_receive_note_rm_model->getGRNById($transactionReferenceId);
					if ($grn && sizeof($grn) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($grn[0]->reference_no, 'raw material');
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach ($journalEntries as $journalEntry) {
						if ($selectedIndex == '') {
							$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
						} else {
							if ($selectedIndex == $journalEntry->journal_entry_id) {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' selected>" . $journalEntry->description . "</option>";
							} else {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
							}
						}
					}
				}
				
				$journalEntryList .="   </select>";

				break;
			
			//Raw Material Supplier Return
			case '4':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'raw material');
				} else {
					$supplierReturn = $this->supplier_return_rm_model->getSupplierReturnById($transactionReferenceId);
					if ($supplierReturn && sizeof($supplierReturn) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($supplierReturn[0]->reference_no, 'raw material');
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach ($journalEntries as $journalEntry) {
						if ($selectedIndex == '') {
							$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
						} else {
							if ($selectedIndex == $journalEntry->journal_entry_id) {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' selected>" . $journalEntry->description . "</option>";
							} else {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
							}
						}
					}
				}
				
				$journalEntryList .="   </select>";

				break;
			
			//Sales Invoice
			case '5':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'sales invoice');
				} else {
					$salesInvoice = $this->sales_invoice_model->getSalesInvoiceById($transactionReferenceId);
					if ($salesInvoice && sizeof($salesInvoice) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($salesInvoice[0]->reference_no, 'sales invoice');
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach ($journalEntries as $journalEntry) {
						if ($selectedIndex == '') {
							$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
						} else {
							if ($selectedIndex == $journalEntry->journal_entry_id) {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' selected>" . $journalEntry->description . "</option>";
							} else {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
							}
						}
					}
				}
				
				$journalEntryList .="   </select>";

				break;
			
			//Sales Return
			case '6':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'sales return');
				} else {
					$salesReturn = $this->sales_return_model->getSalesReturnById($transactionReferenceId);
					if ($salesReturn && sizeof($salesReturn) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($salesReturn[0]->reference_no, 'sales return');
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach ($journalEntries as $journalEntry) {
						if ($selectedIndex == '') {
							$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
						} else {
							if ($selectedIndex == $journalEntry->journal_entry_id) {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' selected>" . $journalEntry->description . "</option>";
							} else {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
							}
						}
					}
				}
				
				$journalEntryList .="   </select>";

				break;
				
			//Other
			case '7':
				
				$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType('');
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach ($journalEntries as $journalEntry) {
						if ($selectedIndex == '') {
							$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
						} else {
							if ($selectedIndex == $journalEntry->journal_entry_id) {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' selected>" . $journalEntry->description . "</option>";
							} else {
								$journalEntryList .=          "<option value='" . $journalEntry->journal_entry_id  . "' >" . $journalEntry->description . "</option>";
							}
						}
					}
				}
				
				$journalEntryList .="   </select>";

			default:
				break;
		}
		
		if ($selectedIndex == '') {
			echo $journalEntryList;
		} else {
			return $journalEntryList;
		}
	}
	
	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
    
    public function getPrimeEntryBooksToUpdateForMakePaymentTransactionClaim() {
        $primeEntryBooks = $this->system_configurations_model->getMakePaymentTransactionClaimPrimeEntryBooks();

		return $primeEntryBooks;
    }
}