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

class Receive_payment_controller extends CI_Controller {

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
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
        $this->load->model('accountsManagerModule/adminSection/bank_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/receive_payment_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/payments_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/sales_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/purchase_note_model', '', TRUE);
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
		$data_cls['li_class_receive_payment'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['receive_payment_no_auto_increment_status'] = $this->isReceivePaymentNumberAutoIncrementEnabled();

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration
		
		$data['peopleType'] = $this->getPeopleType();
		$data['force_to_select_a_reference_transaction_for_receive_a_payment'] = $this->forceToSelectAReferenceTransactionForReceiveAPayment();
        $data['default_payer_type'] = $this->getReceiveAPaymentDefaultPayerType();
        $data['default_reference_transaction_type'] = $this->getReceiveAPaymentDefaultReferenceTransactionType();
        $data['select_reference_journal_entry_automatically'] = $this->isSelectReferenceJournalEntryAutomaticallyEnabled();
        $data['allow_partial_payment_for_reference_transactions'] = $this->isAllowPartialPaymentForReferenceTransactionsEnabled();
        
		if(isset($this->data['ACM_Bookkeeping_View_Receive_Payment_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/receivePayment/index', $data);
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
		if(isset($this->data['ACM_Bookkeeping_Add_Receive_Payment_Permissions'])) {
            
            $result = '';
			$receivePaymentId = '';
            
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
                
				$makePaymentReferenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$receivePaymentDate = $this->db->escape_str($this->input->post('receive_payment_date'));
				$payerType = $this->db->escape_str($this->input->post('payer_type'));
				$payerId = $this->db->escape_str($this->input->post('payer_id'));
				$locationId = $this->db->escape_str($this->input->post('location_id'));
                $remark = preg_replace('~\\\n~',"\r\n", $this->db->escape_str($this->input->post('remark')));
                $referenceTransactionData = $this->db->escape_str($this->input->post('reference_transaction_data'));
				$paymentMethodData = $this->db->escape_str($this->input->post('payment_method_data'));
				$referenceTransactionCount = $this->db->escape_str($this->input->post('reference_transaction_count'));
				$paymentMethodCount = $this->db->escape_str($this->input->post('payment_method_count'));
                
                $data = array(
					'reference_no' => $makePaymentReferenceNo,
					'date' => $receivePaymentDate,
					'payer_type' => $payerType,
					'payer_id' => $payerId,
					'location_id' => $locationId,
					'remark' => $remark,
					'actioned_user_id' => $this->user_id,
					'added_date' => $this->date,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);

				$receivePaymentId = $this->receive_payment_model->add($data);
                
                $receivePaymentClaimAmountTotal = '0.00';
                $purchaseNoteAmountTotal = '0.00';
                $customerReturnNoteAmountTotal = '0.00';
                
                $claimTransactionList = array();
                
                if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {

					for($x = 0; $x < $referenceTransactionCount; $x++) {

						if (isset($referenceTransactionData[$x])) {
							$rowCount = sizeof($referenceTransactionData[$x][0]);

							for($y = 1; $y <= $rowCount; $y++) {
								
                                $claimAmount = 0;
								
								if ($referenceTransactionData[$x][0][$y] == '1') {
                                    //Purchase Note
									$journalEntryId = $referenceTransactionData[$x][2][$y];
									$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
									$purchaseNoteReferenceNo = $journalEntry[0]->reference_no;
									$purchaseNote = $this->purchase_note_model->getPurchaseNoteByReferenceNo($purchaseNoteReferenceNo);
									
									if ($purchaseNote && sizeof($purchaseNote) > 0) {
                                        
                                        $purchaseNoteReferenceNo = $purchaseNote[0]->reference_no;
                                        $purchaseNoteAmount = $purchaseNote[0]->balance_payment;
                                        $claimAmount = $purchaseNoteAmount;
                                        
										$data = array(
                                            'balance_payment' => '0.00',
											'status' => "Claimed",
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
										
										$this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);
                                        
                                        $purchaseNoteAmountTotal = $purchaseNoteAmountTotal + $purchaseNoteAmount;
                                        
                                        $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $purchaseNoteReferenceNo);
                                        $claimTransactionList[] = $claimTransaction;
									}
								} else if ($referenceTransactionData[$x][0][$y] == '4') {
                                    //Customer Return Note
									$journalEntryId = $referenceTransactionData[$x][2][$y];
									$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
									$customerReturnNoteReferenceNo = $journalEntry[0]->reference_no;
									$customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteByReferenceNo($customerReturnNoteReferenceNo);
									
									if ($customerReturnNote && sizeof($customerReturnNote) > 0) {
                                        
                                        $customerReturnNoteReferenceNo = $customerReturnNote[0]->reference_no;
                                        $customerReturnNoteAmount = $customerReturnNote[0]->balance_payment;
                                        $claimAmount = $customerReturnNoteAmount;
                                        
										$data = array(
                                            'balance_payment' => '0.00',
											'status' => "Claimed",
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
										
										$this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);
                                        
                                        $customerReturnNoteAmountTotal = $customerReturnNoteAmountTotal + $customerReturnNoteAmount;
                                        
                                        $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $customerReturnNoteReferenceNo);
                                        $claimTransactionList[] = $claimTransaction;
									}
								}
                                
                                $data = array(
									'receive_payment_id' => $receivePaymentId,
									'reference_transaction_type_id' => $referenceTransactionData[$x][0][$y],
									'reference_transaction_id' => $referenceTransactionData[$x][1][$y],
									'reference_journal_entry_id' => $referenceTransactionData[$x][2][$y],
                                    'claim_amount' => $claimAmount,
									'actioned_user_id' => $this->user_id,
									'action_date' => $this->date,
									'last_action_status' => 'added'
								);

								$this->receive_payment_model->addReceivePaymentReferenceTransaction($data);
							}
						}
					}
				}
                
                $receivePaymentClaimAmountTotal = $purchaseNoteAmountTotal + $customerReturnNoteAmountTotal;
                
                if ($paymentMethodData && sizeof($paymentMethodData) > 0) {

                    $totalPaid = 0;
                    
					for($x = 0; $x < $paymentMethodCount; $x++) {

						if (isset($paymentMethodData[$x])) {
							$rowCount = sizeof($paymentMethodData[$x][0]);

                            $remainingPaymentAmount = 0;
                            
							for($y = 1; $y <= $rowCount; $y++) {
                                
								$paymentMethod = $paymentMethodData[$x][0][$y];
                                $paymentAccountId = $paymentMethodData[$x][1][$y];
								$bankId = $paymentMethodData[$x][2][$y];
								$chequeNumber = $paymentMethodData[$x][3][$y];
								$chequeDate = $paymentMethodData[$x][4][$y];
                                $thirdPartyCheque = $paymentMethodData[$x][5][$y];
                                $crossedCheque = $paymentMethodData[$x][6][$y];
                                $chequeDepositPrimeEntryBookId = $paymentMethodData[$x][7][$y];
                                $cardType = $paymentMethodData[$x][8][$y];
								$amount = $paymentMethodData[$x][9][$y];
                                
                                $remainingPaymentAmount = $amount;
                                
                                $chequeId = '';
                                
                                $referenceTransactionTypeId = '';
                                $referenceTransactionId = '';
                                $referenceJournalEntryId = '';
                                
                                if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {
                                    
                                    for($p = 0; $p < $referenceTransactionCount; $p++) {

                                        if (isset($referenceTransactionData[$p])) {
                                            $rowCountInner = sizeof($referenceTransactionData[$p][0]);

                                            for($q = 1; $q <= $rowCountInner; $q++) {
                                                
                                                if ($referenceTransactionData[$p][0][$q] == '2') {
                                                    //Sales Note
                                                    $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                                    
                                                    $salesNoteReferenceNo = $journalEntry[0]->reference_no;
                                                    $salesNote = $this->sales_note_model->getSalesNoteByReferenceNo($salesNoteReferenceNo);

                                                    if ($salesNote && sizeof($salesNote) > 0) {

                                                        $salesNoteId = $salesNote[0]->sales_note_id;
                                                        
                                                        $referenceTransactionTypeId = '2';
                                                        $referenceTransactionId = $salesNoteId;
                                                        $referenceJournalEntryId = $journalEntryId;
                                                        
                                                        $totalAmount = $salesNote[0]->sales_amount;
                                                        $discount = $salesNote[0]->discount;
                                                        $paidCashAmount = $salesNote[0]->cash_payment_amount;
                                                        $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
                                                        $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
                                                        $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
                                                        $totalPayable = $totalAmount - $discount;
                                                        $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;
                                                        
                                                        $currentBalancePayment = $totalPayable - $totalPaid;
                                                        
                                                        if (round($currentBalancePayment) > 0) {
                                                        
                                                            $amountToClaimFromPayment = 0;
                                                            $amountToClaimFromSalesNoteAmount = 0;

                                                            if ($customerReturnNoteAmountTotal > 0) {

                                                                if ($currentBalancePayment >= $customerReturnNoteAmountTotal) {
                                                                    $amountToClaimFromPayment = $currentBalancePayment - $customerReturnNoteAmountTotal;

                                                                    if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                        $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                    }

                                                                    $amountToClaimFromSalesNoteAmount = $customerReturnNoteAmountTotal;
                                                                    $newBalancePayment = $totalPayable - ($totalPaid + $amountToClaimFromPayment + $customerReturnNoteAmountTotal);
                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                    $customerReturnNoteAmountTotal = 0;
                                                                } else {
                                                                    $amountToClaimFromSalesNoteAmount = $currentBalancePayment;
                                                                    $newBalancePayment = $totalPayable - ($totalPaid + $amountToClaimFromSalesNoteAmount);
                                                                    $customerReturnNoteAmountTotal = $customerReturnNoteAmountTotal - $amountToClaimFromSalesNoteAmount;
                                                                }
                                                            } else {
                                                                $newBalancePayment = $totalPayable - ($totalPaid + $remainingPaymentAmount);
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

                                                            if ($amountToClaimFromSalesNoteAmount > 0) {
                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'customer_return_note_claimed' => $amountToClaimFromSalesNoteAmount + $customerReturnAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $cashPaymentData = array(
                                                                        'transaction_type' => 'Sales Note',
                                                                        'transaction_id' => $salesNoteId,
                                                                        'date' => $receivePaymentDate,
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
                                                                        'customer_return_note_claimed' => $amountToClaimFromSalesNoteAmount + $customerReturnAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $incomeChequeData = array(
                                                                        'transaction_type' => 'Sales Note',
                                                                        'transaction_id' => $salesNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'payer_id' => $payerId,
                                                                        'location_id' => $locationId,
                                                                        'reference_no' => $salesNoteReferenceNo,
                                                                        'cheque_number' => $chequeNumber,
                                                                        'bank' => $bankId,
                                                                        'cheque_date' => $chequeDate,
                                                                        'third_party_cheque' => $thirdPartyCheque,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'crossed_cheque' => $crossedCheque,
                                                                        'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                        'status' => "In_Hand",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'credit_card_payment_amount' => $paidCreditCardAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'customer_return_note_claimed' => $amountToClaimFromSalesNoteAmount + $customerReturnAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $creditCardPaymentData = array(
                                                                        'transaction_type' => 'Sales Note',
                                                                        'transaction_id' => $salesNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'card_type' => $cardType,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                }

                                                                $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);
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
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
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

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $salesNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $remainingPaymentAmount;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $remainingPaymentAmount,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);

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
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
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

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $salesNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $currentBalancePayment,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $currentBalancePayment;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $currentBalancePayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $currentBalancePayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);

                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                }
                                                            }
                                                            
                                                            $claimAmount = 0;

                                                            if ($receivePaymentClaimAmountTotal >= $amountToClaimFromSalesNoteAmount) {
                                                                $claimAmount = $amountToClaimFromSalesNoteAmount;
                                                                $receivePaymentClaimAmountTotal = $receivePaymentClaimAmountTotal - $amountToClaimFromSalesNoteAmount;
                                                            } else if ($receivePaymentClaimAmountTotal > 0) {
                                                                $claimAmount = $receivePaymentClaimAmountTotal;
                                                                $receivePaymentClaimAmountTotal = 0;
                                                            }

                                                            $primeEntryBooksToUpdateForCustomerReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();

                                                            //Post journal entry for customer return note claim for sales note
                                                            if ($claimAmount > 0 && $journalEntryId != '') {

                                                                if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                    $count = 0;
                                                                    $arrayElementsToUnset = array();
                                                                    foreach($claimTransactionList as $claimTransactionRow) {
                                                                        if ($claimTransactionRow[1] <= $claimAmount) {

                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerReturnNoteClaim, '', $receivePaymentDate, 
                                                                                    $salesNoteReferenceNo, '2', $salesNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payerId, 
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
                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerReturnNoteClaim, '', $receivePaymentDate, 
                                                                                    $salesNoteReferenceNo, '2', $salesNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payerId, 
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
                                                                $creditCardPaymentId = 0;

                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $cashPaymentId = $paymentId;
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $creditCardPaymentId = $paymentId;
                                                                }

                                                                $receivePaymentMethodRecordData = array(
                                                                    'receive_payment_id' => $receivePaymentId,
                                                                    'payment_method' => $paymentMethod,
                                                                    'card_type' => $cardType,
                                                                    'cash_payment_id' => $cashPaymentId,
                                                                    'cheque_id' => $chequeId,
                                                                    'credit_card_payment_id' => $creditCardPaymentId,
                                                                    'actioned_user_id' => $this->user_id,
                                                                    'action_date' => $this->date,
                                                                    'last_action_status' => 'added'
                                                                );

                                                                $receivePaymentMethodId = $this->receive_payment_model->addReceivePaymentMethodRecord($receivePaymentMethodRecordData);

                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    //Add sales note cash payment entry
                                                                    $salesNoteCashPaymentEntry = array(
                                                                        'sales_note_id' => $salesNoteId,
                                                                        'receive_cash_payment_method_id' => $receivePaymentMethodId,
                                                                        'added_from' => "Receive Payment",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCashPaymentEntry);
                                                                } else if ($paymentMethod == 'Cheque Payment') {
                                                                    //Add sales note cash payment entry
                                                                    $salesNoteCashPaymentEntry = array(
                                                                        'sales_note_id' => $salesNoteId,
                                                                        'receive_cheque_payment_method_id' => $receivePaymentMethodId,
                                                                        'added_from' => "Receive Payment",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCashPaymentEntry);
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    //Add sales note cash payment entry
                                                                    $salesNoteCashPaymentEntry = array(
                                                                        'sales_note_id' => $salesNoteId,
                                                                        'receive_credit_card_payment_method_id' => $receivePaymentMethodId,
                                                                        'added_from' => "Receive Payment",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCashPaymentEntry);
                                                                }
                                                            
                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                $primeEntryBookIds = '';
                                                                if ($paymentMethod == "Cash Payment") {
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction();

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
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction();


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
                                                                } else if ($paymentMethod == "Card Payment") {
                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                    } else {
                                                                        $primeEntryBookIds[] = $paymentAccountId;
                                                                    }
                                                                }

                                                                if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                    if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                        foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                            $data = array(
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $receivePaymentDate,
                                                                                'reference_no' => $makePaymentReferenceNo,
                                                                                'should_have_a_payment_journal_entry' => "No",
                                                                                'location_id' => $locationId,
                                                                                'payee_payer_type' => $payerType,
                                                                                'payee_payer_id' => $payerId,
                                                                                'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                'reference_transaction_id' => $referenceTransactionId,
                                                                                'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                'description' => $this->lang->line('Journal entry for Receive Payment number : ') . $makePaymentReferenceNo,
                                                                                'post_type' => "Indirect",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                                                            $data = array(
                                                                                'receive_payment_id' => $receivePaymentId,
                                                                                'receive_payment_method_id' => $receivePaymentMethodId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $this->receive_payment_model->addReceivePaymentJournalEntry($data);

                                                                            $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                            foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                if ($paymentMethod == "Cheque Payment") {
                                                                                    $transactionStatus = "No";
                                                                                } else {
                                                                                    $transactionStatus = "Yes";
                                                                                }

                                                                                if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'debit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'credit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                }

                                                                                $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                                                                //Same time add the data to previous years record table.
                                                                                $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                                                            }

                                                                            if ($chequeId != '' && $chequeId != '0') {
                                                                                $incomeChequeData = array(
                                                                                    'cheque_reference_journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                                                                            }
                                                                        }
                                                                    } 

                                                                    $result = 'ok';
                                                                } else {
                                                                    $result = 'incorrect_prime_entry_book_selected_for_receive_payment_transaction';
                                                                    break;
                                                                }
                                                            }

                                                            if ($paymentMethodFullyConsumed == true) {
                                                                break;
                                                            }
                                                        }
                                                    }
                                                } else if ($referenceTransactionData[$p][0][$q] == '3') {
                                                    //Supplier Return Note
                                                    $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                                    
                                                    $supplierReturnNoteReferenceNo = $journalEntry[0]->reference_no;
                                                    $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteByReferenceNo($supplierReturnNoteReferenceNo);

                                                    if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {

                                                        $supplierReturnNoteId = $supplierReturnNote[0]->supplier_return_note_id;
                                                        
                                                        $referenceTransactionTypeId = '3';
                                                        $referenceTransactionId = $supplierReturnNoteId;
                                                        $referenceJournalEntryId = $journalEntryId;
                                                        
                                                        $totalAmount = $supplierReturnNote[0]->amount;
                                                        $paidCashAmount = $supplierReturnNote[0]->cash_payment_amount;
                                                        $paidChequeAmount = $supplierReturnNote[0]->cheque_payment_amount;
                                                        $paidCreditCardAmount = $supplierReturnNote[0]->credit_card_payment_amount;
                                                        $purchaseAmountClaimed = $supplierReturnNote[0]->purchase_note_claimed;
                                                        $totalReceivable = $totalAmount;
                                                        $totalReceived = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $purchaseAmountClaimed;
                                                        
                                                        $currentBalancePayment = $totalReceivable - $totalReceived;
                                                        
                                                        if (round($currentBalancePayment) > 0) {
                                                         
                                                            $amountToClaimFromPayment = 0;
                                                            $amountToClaimFromSupplierReturnAmount = 0;

                                                            if ($purchaseNoteAmountTotal > 0) {

                                                                if ($currentBalancePayment >= $purchaseNoteAmountTotal) {
                                                                    $amountToClaimFromPayment = $currentBalancePayment - $purchaseNoteAmountTotal;

                                                                    if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                        $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                    }

                                                                    $amountToClaimFromSupplierReturnAmount = $purchaseNoteAmountTotal;
                                                                    $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromPayment + $purchaseNoteAmountTotal);
                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                    $purchaseNoteAmountTotal = 0;
                                                                } else {
                                                                    $amountToClaimFromSupplierReturnAmount = $currentBalancePayment;
                                                                    $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromSupplierReturnAmount);
                                                                    $purchaseNoteAmountTotal = $purchaseNoteAmountTotal - $amountToClaimFromSupplierReturnAmount;
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

                                                            if ($amountToClaimFromSupplierReturnAmount > 0) {
                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'purchase_note_claimed' => $amountToClaimFromSupplierReturnAmount + $purchaseAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $cashPaymentData = array(
                                                                        'transaction_type' => 'Supplier Return',
                                                                        'transaction_id' => $supplierReturnNoteId,
                                                                        'date' => $receivePaymentDate,
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
                                                                        'purchase_note_claimed' => $amountToClaimFromSupplierReturnAmount + $purchaseAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $incomeChequeData = array(
                                                                        'transaction_type' => 'Supplier Return',
                                                                        'transaction_id' => $supplierReturnNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'payer_id' => $payerId,
                                                                        'location_id' => $locationId,
                                                                        'reference_no' => $supplierReturnNoteReferenceNo,
                                                                        'cheque_number' => $chequeNumber,
                                                                        'bank' => $bankId,
                                                                        'cheque_date' => $chequeDate,
                                                                        'third_party_cheque' => $thirdPartyCheque,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'crossed_cheque' => $crossedCheque,
                                                                        'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                        'status' => "In_Hand",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'credit_card_payment_amount' => $paidCreditCardAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'purchase_note_claimed' => $amountToClaimFromSupplierReturnAmount + $purchaseAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $creditCardPaymentData = array(
                                                                        'transaction_type' => 'Supplier Return',
                                                                        'transaction_id' => $supplierReturnNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'card_type' => $cardType,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                }

                                                                $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);
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
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
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

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $supplierReturnNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $remainingPaymentAmount;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $remainingPaymentAmount,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);

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
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
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

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $supplierReturnNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $currentBalancePayment,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $currentBalancePayment;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $currentBalancePayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Supplier Return Note',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $currentBalancePayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);

                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                }
                                                            }

                                                            $claimAmount = 0;

                                                            if ($receivePaymentClaimAmountTotal >= $amountToClaimFromSupplierReturnAmount) {
                                                                $claimAmount = $amountToClaimFromSupplierReturnAmount;
                                                                $receivePaymentClaimAmountTotal = $receivePaymentClaimAmountTotal - $amountToClaimFromSupplierReturnAmount;
                                                            } else if ($receivePaymentClaimAmountTotal > 0) {
                                                                $claimAmount = $receivePaymentClaimAmountTotal;
                                                                $receivePaymentClaimAmountTotal = 0;
                                                            }

                                                            $primeEntryBooksToUpdateForPurchaseNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();

                                                            //Post journal entry for purchase note claim for supplier return note
                                                            if ($claimAmount > 0 && $journalEntryId != '') {

                                                                if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                    $count = 0;
                                                                    $arrayElementsToUnset = array();
                                                                    foreach($claimTransactionList as $claimTransactionRow) {
                                                                        if ($claimTransactionRow[1] <= $claimAmount) {

                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForPurchaseNoteClaim, '', $receivePaymentDate, 
                                                                                    $supplierReturnNoteReferenceNo, '3', $supplierReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payerId, 
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
                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForPurchaseNoteClaim, '', $receivePaymentDate, 
                                                                                    $supplierReturnNoteReferenceNo, '3', $supplierReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payerId, 
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
                                                                $creditCardPaymentId = 0;

                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $cashPaymentId = $paymentId;
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $creditCardPaymentId = $paymentId;
                                                                }

                                                                $receivePaymentMethodRecordData = array(
                                                                    'receive_payment_id' => $receivePaymentId,
                                                                    'payment_method' => $paymentMethod,
                                                                    'card_type' => $cardType,
                                                                    'cash_payment_id' => $cashPaymentId,
                                                                    'cheque_id' => $chequeId,
                                                                    'credit_card_payment_id' => $creditCardPaymentId,
                                                                    'actioned_user_id' => $this->user_id,
                                                                    'action_date' => $this->date,
                                                                    'last_action_status' => 'added'
                                                                );

                                                                $receivePaymentMethodId = $this->receive_payment_model->addReceivePaymentMethodRecord($receivePaymentMethodRecordData);

                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                $primeEntryBookIds = '';
                                                                if ($paymentMethod == "Cash Payment") {
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction();

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
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction();


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
                                                                } else if ($paymentMethod == "Card Payment") {
                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                    } else {
                                                                        $primeEntryBookIds[] = $paymentAccountId;
                                                                    }
                                                                }

                                                                if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                    if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                        foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                            $data = array(
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $receivePaymentDate,
                                                                                'reference_no' => $makePaymentReferenceNo,
                                                                                'should_have_a_payment_journal_entry' => "No",
                                                                                'location_id' => $locationId,
                                                                                'payee_payer_type' => $payerType,
                                                                                'payee_payer_id' => $payerId,
                                                                                'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                'reference_transaction_id' => $referenceTransactionId,
                                                                                'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                'description' => $this->lang->line('Journal entry for Receive Payment number : ') . $makePaymentReferenceNo,
                                                                                'post_type' => "Indirect",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                                                            $data = array(
                                                                                'receive_payment_id' => $receivePaymentId,
                                                                                'receive_payment_method_id' => $receivePaymentMethodId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $this->receive_payment_model->addReceivePaymentJournalEntry($data);

                                                                            $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                            foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                if ($paymentMethod == "Cheque Payment") {
                                                                                    $transactionStatus = "No";
                                                                                } else {
                                                                                    $transactionStatus = "Yes";
                                                                                }

                                                                                if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'debit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'credit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                }

                                                                                $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                                                                //Same time add the data to previous years record table.
                                                                                $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                                                            }

                                                                            if ($chequeId != '' && $chequeId != '0') {
                                                                                $incomeChequeData = array(
                                                                                    'cheque_reference_journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                                                                            }
                                                                        }
                                                                    } 

                                                                    $result = 'ok';
                                                                } else {
                                                                    $result = 'incorrect_prime_entry_book_selected_for_receive_payment_transaction';
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
					}
				}
			}

			echo json_encode(array('result' => $result));
		}
	}

	public function editReceivePaymentData() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Receive_Payment_Permissions'])) {
            
            $result = '';
			$receivePaymentId = '';
            
			if ($this->form_validation->run() == FALSE) {
				$result = validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');
			} else {
				$referenceNoChanged = false;
				$receivePaymentDateChanged = false;
				$remarkChanged = false;

				//Read New Receive Payment Data
				$receivePaymentId = $this->db->escape_str($this->input->post('id'));
				$receivePaymentReferenceNo = $this->db->escape_str($this->input->post('reference_no'));
				$receivePaymentDate = $this->db->escape_str($this->input->post('receive_payment_date'));
				$remark = $this->db->escape_str($this->input->post('remark'));
				$remark = preg_replace('~\\\n~',"\r\n", $remark);
                $referenceTransactionData = $this->db->escape_str($this->input->post('reference_transaction_data'));
				$paymentMethodData = $this->db->escape_str($this->input->post('payment_method_data'));
				$referenceTransactionCount = $this->db->escape_str($this->input->post('reference_transaction_count'));
				$paymentMethodCount = $this->db->escape_str($this->input->post('payment_method_count'));

				$receivePayment = $this->receive_payment_model->getReceivePaymentById($receivePaymentId);
                
                $payerType = $receivePayment[0]->payer_type;
                $payerId = $receivePayment[0]->payer_id;
                $locationId = $receivePayment[0]->location_id;
				
                $date = date("Y-m-d");
				
				$receivePaymentJournalEntry = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);
				$journalEntry = $this->journal_entries_model->getJournalEntryById($receivePaymentJournalEntry[0]->journal_entry_id);

				if ($receivePayment[0]->reference_no != $receivePaymentReferenceNo) {$referenceNoChanged = true;}
				if ($receivePayment[0]->date != $receivePaymentDate) {$receivePaymentDateChanged = true;}
				if ($receivePayment[0]->remark != $remark) {$remarkChanged = true;}

				if ($referenceNoChanged || $receivePaymentDateChanged || $remarkChanged) {

					$receivePaymentDataHistory = array(
						'receive_payment_id' => $receivePayment[0]->receive_payment_id,
						'reference_no' => $receivePayment[0]->reference_no,
						'date' => $receivePayment[0]->date,
						'payer_type' => $receivePayment[0]->payer_type,
						'payer_id' => $receivePayment[0]->payer_id,
						'location_id' => $receivePayment[0]->location_id,
						'remark' => $receivePayment[0]->remark,
						'actioned_user_id' => $receivePayment[0]->actioned_user_id,
						'added_date' => $receivePayment[0]->added_date,
						'action_date' => $receivePayment[0]->action_date,
						'last_action_status' => $receivePayment[0]->last_action_status,
					);

					$this->receive_payment_model->addReceivePaymentDataToHistory($receivePaymentDataHistory);
                    
                    $receivePaymentDatanew = array(
						'reference_no' => $receivePaymentReferenceNo,
						'date' => $receivePaymentDate,
						'remark' => $remark,
						'actioned_user_id' => $this->user_id,
						'action_date' => $this->date,
						'last_action_status' => 'edited'
					);

					$this->receive_payment_model->editReceivePaymentData($receivePaymentId, $receivePaymentDatanew);
                }
					
                $paymentReferenceList = $this->receive_payment_model->getReceivePaymentReferenceTransactionList($receivePaymentId);
                $paymentMethodList = $this->receive_payment_model->getReceivePaymentMethodList($receivePaymentId);
                $refundClaimAmountTotal = $this->receive_payment_model->getReceivePaymentClaimAmountTotal($receivePaymentId);
                
                if ($paymentMethodList && sizeof($paymentMethodList) > 0) {

                    foreach ($paymentMethodList as $paymentMethodRecord) {

                        $paymentMethod = $paymentMethodRecord->payment_method;
                        $cashPaymentId = $paymentMethodRecord->cash_payment_id;
                        $chequeId = $paymentMethodRecord->cheque_id;
                        $creditCardPaymentId = $paymentMethodRecord->credit_card_payment_id;
                        
                        $cashAmount = 0;
                        $chequeAmount = 0;
                        $creditCardAmount = 0;
                        $status = "deleted";

                        if ($paymentMethod == "Cash Payment") {
                            $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
                            $cashAmount = $cashPayment[0]->amount;
                            $this->payments_model->deleteCashPayment($cashPaymentId, $status, $this->user_id);
                        } else if ($paymentMethod == "Cheque Payment") {
                            $chequePayment = $this->payments_model->getIncomeChequeById($chequeId);
                            $chequeAmount = $chequePayment[0]->amount;
                            $this->payments_model->deleteIncomeCheque($chequeId, $status, $this->user_id);
                        } else if ($paymentMethod == "Card Payment") {
                            $creditCardPayment = $this->payments_model->getCardPaymentById($creditCardPaymentId);
                            $creditCardAmount = $creditCardPayment[0]->amount;
                            $this->payments_model->deleteCardPayment($creditCardPaymentId, $status, $this->user_id);
                        }

                        //Reverse current reference transactions changes from the receive payment
                        if ($paymentReferenceList && sizeof($paymentReferenceList) > 0) {

                            foreach ($paymentReferenceList as $paymentReference) {

                                $referenceTransactionTypeId = $paymentReference->reference_transaction_type_id;
                                $referenceTransactionId = $paymentReference->reference_transaction_id;
                                $referenceTransactionClaimAmount = $paymentReference->claim_amount;
                                
                                if ($referenceTransactionTypeId == '1') {
                                    //Purchase Note
                                    $purchaseNoteId = $referenceTransactionId;
                                    $purchaseNote = $this->purchase_note_model->getPurchaseNoteById($purchaseNoteId);

                                    $status = $purchaseNote[0]->status;
                                    //$amount = $purchaseNote[0]->amount;
                                    $currentBalancePayment = $purchaseNote[0]->balance_payment;
                                    
                                    if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                        $purchaseNoteData = array(
                                            'balance_payment' => $referenceTransactionClaimAmount,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->purchase_note_model->editPurchaseNoteData($referenceTransactionId, $purchaseNoteData);
                                    }
                                    
                                    //$claimReturnAmount = $claimReturnAmount + $amount;
                                    $purchaseNoteSalesEntryJournalEntries = $this->purchase_note_model->getPurchaseNoteJournalEntries($purchaseNoteId);
                                    
                                    if ($purchaseNoteSalesEntryJournalEntries && sizeof($purchaseNoteSalesEntryJournalEntries) > 0) {
                                        //Delete purchase claim journal entries
                                        foreach($purchaseNoteSalesEntryJournalEntries as $journalEntry) {
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
                                } else if ($referenceTransactionTypeId == '2') {
                                    //Sales Note
                                    $successfulTransaction = false;

                                    $salesNoteId = $referenceTransactionId;
                                    $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);

                                    $currentCashPayment = $salesNote[0]->cash_payment_amount;
                                    $currentChequePayment = $salesNote[0]->cheque_payment_amount;
                                    $currentCreditCardPayment = $salesNote[0]->credit_card_payment_amount;
                                    $currentBalancePayment = $salesNote[0]->balance_payment;
                                    $claimAmountTotal = $salesNote[0]->customer_return_note_claimed;
                                    
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

                                    if ($currentCreditCardPayment >= $creditCardAmount) {
                                        $currentCreditCardPayment = $currentCreditCardPayment - $creditCardAmount;
                                        $currentBalancePayment = $currentBalancePayment + $creditCardAmount;
                                        $creditCardAmount = 0;
                                        $successfulTransaction = true;
                                    } else if ($currentCreditCardPayment < $creditCardAmount) {
                                        $creditCardAmount = $creditCardAmount - $currentCreditCardPayment;
                                        $currentBalancePayment = $currentBalancePayment + $currentCreditCardPayment;
                                        $currentCreditCardPayment = 0;
                                        $successfulTransaction = true;
                                    }

                                    if ($successfulTransaction) {

                                        $salesNoteData = array(
                                            'cash_payment_amount' => $currentCashPayment,
                                            'cheque_payment_amount' => $currentChequePayment,
                                            'credit_card_payment_amount' => $currentCreditCardPayment,
                                            'balance_payment' => $currentBalancePayment,
                                            'customer_return_note_claimed' => $claimAmountTotal,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->sales_note_model->editSalesNoteData($referenceTransactionId, $salesNoteData);
                                    }
                                } else if ($referenceTransactionTypeId == '3') {
                                    //Supplier Return Note
                                    $successfulTransaction = false;

                                    $supplierReturnNoteId = $referenceTransactionId;
                                    $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($supplierReturnNoteId);

                                    $currentCashPayment = $supplierReturnNote[0]->cash_payment_amount;
                                    $currentChequePayment = $supplierReturnNote[0]->cheque_payment_amount;
                                    $currentCreditCardPayment = $supplierReturnNote[0]->credit_card_payment_amount;
                                    $currentBalancePayment = $supplierReturnNote[0]->balance_payment;
                                    $claimAmountTotal = $supplierReturnNote[0]->purchase_note_claimed;
                                    
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

                                    if ($currentCreditCardPayment >= $creditCardAmount) {
                                        $currentCreditCardPayment = $currentCreditCardPayment - $creditCardAmount;
                                        $currentBalancePayment = $currentBalancePayment + $creditCardAmount;
                                        $creditCardAmount = 0;
                                        $successfulTransaction = true;
                                    } else if ($currentCreditCardPayment < $creditCardAmount) {
                                        $creditCardAmount = $creditCardAmount - $currentCreditCardPayment;
                                        $currentBalancePayment = $currentBalancePayment + $currentCreditCardPayment;
                                        $currentCreditCardPayment = 0;
                                        $successfulTransaction = true;
                                    }

                                    if ($successfulTransaction) {

                                        $supplierReturnNoteData = array(
                                            'cash_payment_amount' => $currentCashPayment,
                                            'cheque_payment_amount' => $currentChequePayment,
                                            'credit_card_payment_amount' => $currentCreditCardPayment,
                                            'balance_payment' => $currentBalancePayment,
                                            'purchase_note_claimed' => $claimAmountTotal,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->supplier_return_note_model->editSupplierReturnNoteData($referenceTransactionId, $supplierReturnNoteData);
                                    }
                                } else if ($referenceTransactionTypeId == '4') {
                                    //Customer Return Note
                                    $customerReturnNoteId = $referenceTransactionId;
                                    $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);

                                    $status = $customerReturnNote[0]->status;
                                    //$amount = $customerReturnNote[0]->amount;
                                    $currentBalancePayment = $customerReturnNote[0]->balance_payment;
                                    $customerReturnType = $customerReturnNote[0]->type;
                                    
                                    if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                        $customerReturnNoteData = array(
                                            'balance_payment' => $referenceTransactionClaimAmount,
                                            'status' => "Open",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->customer_return_note_model->editCustomerReturnNoteData($referenceTransactionId, $customerReturnNoteData);
                                    }
                                    
                                    //$claimReturnAmount = $claimReturnAmount + $amount;
                                    if ($customerReturnType == 'saleable_return') {
                                        $customerReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                                    } else if ($customerReturnType == 'market_return') {
                                        $customerReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
                                    }
                                    
                                    if ($customerReturnNoteSalesEntryJournalEntries && sizeof($customerReturnNoteSalesEntryJournalEntries) > 0) {
                                        //Delete customer return claim journal entries
                                        foreach($customerReturnNoteSalesEntryJournalEntries as $journalEntry) {
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
                                }
                                
                                $receivePaymentReferenceTransactionDataHistory = array(
                                    'receive_payment_reference_transaction_id' => $paymentReference->receive_payment_reference_transaction_id,
                                    'receive_payment_id' => $paymentReference->receive_payment_id,
                                    'reference_transaction_type_id' => $paymentReference->reference_transaction_type_id,
                                    'reference_transaction_id' => $paymentReference->reference_transaction_id,
                                    'reference_journal_entry_id' => $paymentReference->reference_journal_entry_id,
                                    'claim_amount' => $paymentReference->claim_amount,
                                    'actioned_user_id' => $paymentReference->actioned_user_id,
                                    'action_date' => $paymentReference->action_date,
                                    'last_action_status' => $paymentReference->last_action_status,
                                );

                                $this->receive_payment_model->addReceivePaymentReferenceTransactionToHistory($receivePaymentReferenceTransactionDataHistory);
                            }
                        }

                        $this->receive_payment_model->deleteReceivePaymentReferenceTransactions($receivePaymentId);
                        
                        $receivePaymentMethodDataHistory = array(
							'receive_payment_method_id' => $paymentMethodRecord->receive_payment_method_id,
							'receive_payment_id' => $paymentMethodRecord->receive_payment_id,
							'payment_method' => $paymentMethodRecord->payment_method,
                            'card_type' => $paymentMethodRecord->card_type,
                            'cash_payment_id' => $paymentMethodRecord->cash_payment_id,
							'cheque_id' => $paymentMethodRecord->cheque_id,
							'credit_card_payment_id' => $paymentMethodRecord->credit_card_payment_id,
							'actioned_user_id' => $paymentMethodRecord->actioned_user_id,
							'action_date' => $paymentMethodRecord->action_date,
							'last_action_status' => $paymentMethodRecord->last_action_status,
						);

						$this->receive_payment_model->addReceivePaymentMethodRecordToHistory($receivePaymentMethodDataHistory);
                    }
                }

                $this->receive_payment_model->deleteReceivePaymentMethodRecords($receivePaymentId);

                $receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

                if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
                    //Delete all journal entries of Receive Payment
                    foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
                        $receivePaymentJournalEntryId = $receivePaymentJournalEntry->receive_payment_journal_entry_id;
                        $journalEntryId = $receivePaymentJournalEntry->journal_entry_id;
                        $this->receive_payment_model->deleteReceivePaymentJournalEntry($receivePaymentJournalEntryId, "deleted", $this->user_id);
                        $this->journal_entries_model->deleteJournalEntry($journalEntryId, "deleted", $this->user_id);
                        $this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, "deleted", $this->user_id);
                    }
                }

                $receivePaymentClaimAmountTotal = '0.00';
                $purchaseNoteAmountTotal = '0.00';
                $customerReturnNoteAmountTotal = '0.00';
                
                $claimTransactionList = array();
                
                if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {

					for($x = 0; $x < $referenceTransactionCount; $x++) {

						if (isset($referenceTransactionData[$x])) {
							$rowCount = sizeof($referenceTransactionData[$x][0]);

							for($y = 1; $y <= $rowCount; $y++) {
									
                                $claimAmount = 0;
                                
								if ($referenceTransactionData[$x][0][$y] == '1') {
                                    //Purchase Note
									$journalEntryId = $referenceTransactionData[$x][2][$y];
									$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
									$purchaseNoteReferenceNo = $journalEntry[0]->reference_no;
									$purchaseNote = $this->purchase_note_model->getPurchaseNoteByReferenceNo($purchaseNoteReferenceNo);
									
									if ($purchaseNote && sizeof($purchaseNote) > 0) {
                                        
                                        $purchaseNoteReferenceNo = $purchaseNote[0]->reference_no;
                                        $purchaseNoteAmount = $purchaseNote[0]->balance_payment;
                                        $claimAmount = $purchaseNoteAmount;
                                        
										$data = array(
                                            'balance_payment' => '0.00',
											'status' => "Claimed",
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
										
										$this->purchase_note_model->editPurchaseNoteData($purchaseNote[0]->purchase_note_id, $data);
                                        
                                        $purchaseNoteAmountTotal = $purchaseNoteAmountTotal + $purchaseNoteAmount;
                                        
                                        $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $purchaseNoteReferenceNo);
                                        $claimTransactionList[] = $claimTransaction;
									}
								} else if ($referenceTransactionData[$x][0][$y] == '4') {
                                    //Customer Return Note
									$journalEntryId = $referenceTransactionData[$x][2][$y];
									$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
									$customerReturnNoteReferenceNo = $journalEntry[0]->reference_no;
									$customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteByReferenceNo($customerReturnNoteReferenceNo);
									
									if ($customerReturnNote && sizeof($customerReturnNote) > 0) {
                                        
                                        $customerReturnNoteReferenceNo = $customerReturnNote[0]->reference_no;
                                        $customerReturnNoteAmount = $customerReturnNote[0]->balance_payment;
                                        $claimAmount = $customerReturnNoteAmount;
                                        
										$data = array(
                                            'balance_payment' => '0.00',
											'status' => "Claimed",
											'actioned_user_id' => $this->user_id,
											'action_date' => $this->date,
											'last_action_status' => 'added'
										);
										
										$this->customer_return_note_model->editCustomerReturnNoteData($customerReturnNote[0]->customer_return_note_id, $data);
                                        
                                        $customerReturnNoteAmountTotal = $customerReturnNoteAmountTotal + $customerReturnNoteAmount;
                                        
                                        $claimTransaction = array('0' => $journalEntryId, '1' => $claimAmount, '2' => $customerReturnNoteReferenceNo);
                                        $claimTransactionList[] = $claimTransaction;
									}
								}
                                
                                $data = array(
									'receive_payment_id' => $receivePaymentId,
									'reference_transaction_type_id' => $referenceTransactionData[$x][0][$y],
									'reference_transaction_id' => $referenceTransactionData[$x][1][$y],
									'reference_journal_entry_id' => $referenceTransactionData[$x][2][$y],
                                    'claim_amount' => $claimAmount,
									'actioned_user_id' => $this->user_id,
									'action_date' => $this->date,
									'last_action_status' => 'added'
								);

								$this->receive_payment_model->addReceivePaymentReferenceTransaction($data);
							}
						}
					}
				}
                
                $receivePaymentClaimAmountTotal = $purchaseNoteAmountTotal + $customerReturnNoteAmountTotal;
                
                if ($paymentMethodData && sizeof($paymentMethodData) > 0) {

                    $totalPaid = 0;
                    
					for($x = 0; $x < $paymentMethodCount; $x++) {

						if (isset($paymentMethodData[$x])) {
							$rowCount = sizeof($paymentMethodData[$x][0]);

                            $remainingPaymentAmount = 0;
                            
							for($y = 1; $y <= $rowCount; $y++) {
                                
								$paymentMethod = $paymentMethodData[$x][0][$y];
                                $paymentAccountId = $paymentMethodData[$x][1][$y];
								$bankId = $paymentMethodData[$x][2][$y];
								$chequeNumber = $paymentMethodData[$x][3][$y];
								$chequeDate = $paymentMethodData[$x][4][$y];
                                $thirdPartyCheque = $paymentMethodData[$x][5][$y];
                                $crossedCheque = $paymentMethodData[$x][6][$y];
                                $chequeDepositPrimeEntryBookId = $paymentMethodData[$x][7][$y];
                                $cardType = $paymentMethodData[$x][8][$y];
								$amount = $paymentMethodData[$x][9][$y];
                                
                                $remainingPaymentAmount = $amount;
                                
                                $chequeId = '';
                                
                                $referenceTransactionTypeId = '';
                                $referenceTransactionId = '';
                                $referenceJournalEntryId = '';
                                
                                if ($referenceTransactionData && sizeof($referenceTransactionData) > 0) {
                                    
                                    for($p = 0; $p < $referenceTransactionCount; $p++) {

                                        if (isset($referenceTransactionData[$p])) {
                                            $rowCountInner = sizeof($referenceTransactionData[$p][0]);

                                            for($q = 1; $q <= $rowCountInner; $q++) {
                                                
                                                if ($referenceTransactionData[$p][0][$q] == '2') {
                                                    //Sales Note
                                                    $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                                    
                                                    $salesNoteReferenceNo = $journalEntry[0]->reference_no;
                                                    $salesNote = $this->sales_note_model->getSalesNoteByReferenceNo($salesNoteReferenceNo);

                                                    if ($salesNote && sizeof($salesNote) > 0) {

                                                        $salesNoteId = $salesNote[0]->sales_note_id;
                                                        
                                                        $referenceTransactionTypeId = '2';
                                                        $referenceTransactionId = $salesNoteId;
                                                        $referenceJournalEntryId = $journalEntryId;
                                                    
                                                        $totalAmount = $salesNote[0]->sales_amount;
                                                        $discount = $salesNote[0]->discount;
                                                        $paidCashAmount = $salesNote[0]->cash_payment_amount;
                                                        $paidChequeAmount = $salesNote[0]->cheque_payment_amount;
                                                        $paidCreditCardAmount = $salesNote[0]->credit_card_payment_amount;
                                                        $customerReturnAmountClaimed = $salesNote[0]->customer_return_note_claimed;
                                                        $totalPayable = $totalAmount - $discount;
                                                        //$totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + ($customerReturnAmountClaimed - $claimReturnAmount);
                                                        $totalPaid = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $customerReturnAmountClaimed;
                                                        
                                                        $currentBalancePayment = $totalPayable - $totalPaid;
                                                        
                                                        if (round($currentBalancePayment) > 0) {
                                                        
                                                            $newBalancePayment = 0;
                                                            $amountToClaimFromPayment = 0;
                                                            $amountToClaimFromSalesNoteAmount = 0;

                                                            if ($customerReturnNoteAmountTotal > 0) {

                                                                if ($currentBalancePayment >= $customerReturnNoteAmountTotal) {
                                                                    $amountToClaimFromPayment = $currentBalancePayment - $customerReturnNoteAmountTotal;

                                                                    if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                        $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                    }

                                                                    $amountToClaimFromSalesNoteAmount = $customerReturnNoteAmountTotal;
                                                                    $newBalancePayment = $totalPayable - ($totalPaid + $amountToClaimFromPayment + $customerReturnNoteAmountTotal);
                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                    $customerReturnNoteAmountTotal = 0;
                                                                } else {
                                                                    $amountToClaimFromSalesNoteAmount = $currentBalancePayment;
                                                                    $newBalancePayment = $totalPayable - ($totalPaid + $amountToClaimFromSalesNoteAmount);
                                                                    $customerReturnNoteAmountTotal = $customerReturnNoteAmountTotal - $amountToClaimFromSalesNoteAmount;
                                                                }
                                                            } else {
                                                                $newBalancePayment = $totalPayable - ($totalPaid + $remainingPaymentAmount);
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

                                                            if ($amountToClaimFromSalesNoteAmount > 0) {
                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'customer_return_note_claimed' => $amountToClaimFromSalesNoteAmount + $customerReturnAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $cashPaymentData = array(
                                                                        'transaction_type' => 'Sales Note',
                                                                        'transaction_id' => $salesNoteId,
                                                                        'date' => $receivePaymentDate,
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
                                                                        'customer_return_note_claimed' => $amountToClaimFromSalesNoteAmount + $customerReturnAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $incomeChequeData = array(
                                                                        'transaction_type' => 'Sales Note',
                                                                        'transaction_id' => $salesNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'payer_id' => $payerId,
                                                                        'location_id' => $locationId,
                                                                        'reference_no' => $salesNoteReferenceNo,
                                                                        'cheque_number' => $chequeNumber,
                                                                        'bank' => $bankId,
                                                                        'cheque_date' => $chequeDate,
                                                                        'third_party_cheque' => $thirdPartyCheque,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'crossed_cheque' => $crossedCheque,
                                                                        'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                        'status' => "In_Hand",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'credit_card_payment_amount' => $paidCreditCardAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'customer_return_note_claimed' => $amountToClaimFromSalesNoteAmount + $customerReturnAmountClaimed,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $creditCardPaymentData = array(
                                                                        'transaction_type' => 'Sales Note',
                                                                        'transaction_id' => $salesNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'card_type' => $cardType,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                }

                                                                $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);
                                                            } else {
                                                                if ($currentBalancePayment > $remainingPaymentAmount && $remainingPaymentAmount > 0) {

                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $remainingPaymentAmount;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $remainingPaymentAmount,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'customer_return_note_claimed' => $customerReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
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
                                                                            'customer_return_note_claimed' => $customerReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $salesNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $remainingPaymentAmount;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $remainingPaymentAmount,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'customer_return_note_claimed' => $customerReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);

                                                                    $remainingPaymentAmount = 0;
                                                                } else if ($currentBalancePayment > 0 && $currentBalancePayment <= $remainingPaymentAmount) {
                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $currentBalancePayment;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $currentBalancePayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'customer_return_note_claimed' => $customerReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
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
                                                                            'customer_return_note_claimed' => $customerReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $salesNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $currentBalancePayment,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $currentBalancePayment;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $currentBalancePayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'customer_return_note_claimed' => $customerReturnAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Sales Note',
                                                                            'transaction_id' => $salesNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $currentBalancePayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->sales_note_model->editSalesNoteData($salesNote[0]->sales_note_id, $data);

                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                }
                                                            }
                                                            
                                                            $claimAmount = 0;

                                                            if ($receivePaymentClaimAmountTotal >= $amountToClaimFromSalesNoteAmount) {
                                                                $claimAmount = $amountToClaimFromSalesNoteAmount;
                                                                $receivePaymentClaimAmountTotal = $receivePaymentClaimAmountTotal - $amountToClaimFromSalesNoteAmount;
                                                            } else if ($receivePaymentClaimAmountTotal > 0) {
                                                                $claimAmount = $receivePaymentClaimAmountTotal;
                                                                $receivePaymentClaimAmountTotal = 0;
                                                            }

                                                            $primeEntryBooksToUpdateForCustomerReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();

                                                            //Post journal entry for customer return note claim for sales note
                                                            if ($claimAmount > 0 && $journalEntryId != '') {

                                                                if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                    $count = 0;
                                                                    $arrayElementsToUnset = array();
                                                                    foreach($claimTransactionList as $claimTransactionRow) {
                                                                        if ($claimTransactionRow[1] <= $claimAmount) {

                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerReturnNoteClaim, '', $receivePaymentDate, 
                                                                                    $salesNoteReferenceNo, '2', $salesNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payerId, 
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
                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerReturnNoteClaim, '', $receivePaymentDate, 
                                                                                    $salesNoteReferenceNo, '2', $salesNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Customer", $payerId, 
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
                                                                $creditCardPaymentId = 0;

                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $cashPaymentId = $paymentId;
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $creditCardPaymentId = $paymentId;
                                                                }

                                                                $receivePaymentMethodRecordData = array(
                                                                    'receive_payment_id' => $receivePaymentId,
                                                                    'payment_method' => $paymentMethod,
                                                                    'card_type' => $cardType,
                                                                    'cash_payment_id' => $cashPaymentId,
                                                                    'cheque_id' => $chequeId,
                                                                    'credit_card_payment_id' => $creditCardPaymentId,
                                                                    'actioned_user_id' => $this->user_id,
                                                                    'action_date' => $this->date,
                                                                    'last_action_status' => 'added'
                                                                );

                                                                $receivePaymentMethodId = $this->receive_payment_model->addReceivePaymentMethodRecord($receivePaymentMethodRecordData);

                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    //Add sales note cash payment entry
                                                                    $salesNoteCashPaymentEntry = array(
                                                                        'sales_note_id' => $salesNoteId,
                                                                        'receive_cash_payment_method_id' => $receivePaymentId,
                                                                        'added_from' => "Receive Payment",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCashPaymentEntry);
                                                                } else if ($paymentMethod == 'Cheque Payment') {
                                                                    //Add sales note cash payment entry
                                                                    $salesNoteCashPaymentEntry = array(
                                                                        'sales_note_id' => $salesNoteId,
                                                                        'receive_cheque_payment_method_id' => $receivePaymentId,
                                                                        'added_from' => "Receive Payment",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCashPaymentEntry);
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    //Add sales note cash payment entry
                                                                    $salesNoteCashPaymentEntry = array(
                                                                        'sales_note_id' => $salesNoteId,
                                                                        'receive_credit_card_payment_method_id' => $receivePaymentId,
                                                                        'added_from' => "Receive Payment",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $this->sales_note_model->addSalesNoteReceivePaymentEntry($salesNoteCashPaymentEntry);
                                                                }
                                                            
                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                $primeEntryBookIds = '';
                                                                if ($paymentMethod == "Cash Payment") {
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction();

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
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction();


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
                                                                } else if ($paymentMethod == "Card Payment") {
                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                    } else {
                                                                        $primeEntryBookIds[] = $paymentAccountId;
                                                                    }
                                                                }

                                                                if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                    if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                        foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                            $data = array(
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $receivePaymentDate,
                                                                                'reference_no' => $receivePaymentReferenceNo,
                                                                                'should_have_a_payment_journal_entry' => "No",
                                                                                'location_id' => $locationId,
                                                                                'payee_payer_type' => $payerType,
                                                                                'payee_payer_id' => $payerId,
                                                                                'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                'reference_transaction_id' => $referenceTransactionId,
                                                                                'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                'description' => $this->lang->line('Journal entry for Receive Payment number : ') . $receivePaymentReferenceNo,
                                                                                'post_type' => "Indirect",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                                                            $data = array(
                                                                                'receive_payment_id' => $receivePaymentId,
                                                                                'receive_payment_method_id' => $receivePaymentMethodId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $this->receive_payment_model->addReceivePaymentJournalEntry($data);

                                                                            $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                            foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                if ($paymentMethod == "Cheque Payment") {
                                                                                    $transactionStatus = "No";
                                                                                } else {
                                                                                    $transactionStatus = "Yes";
                                                                                }

                                                                                if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'debit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'credit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                }

                                                                                $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                                                                //Same time add the data to previous years record table.
                                                                                $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                                                            }

                                                                            if ($chequeId != '' && $chequeId != '0') {
                                                                                $incomeChequeData = array(
                                                                                    'cheque_reference_journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                                                                            }
                                                                        }
                                                                    } 

                                                                    $result = 'ok';
                                                                } else {
                                                                    $result = 'incorrect_prime_entry_book_selected_for_receive_payment_transaction';
                                                                    break;
                                                                }
                                                            }

                                                            if ($paymentMethodFullyConsumed == true) {
                                                                break;
                                                            }
                                                        }
                                                    }
                                                } else if ($referenceTransactionData[$p][0][$q] == '3') {
                                                    //Supplier Return Note
                                                    $journalEntryId = $referenceTransactionData[$p][2][$q];
                                                    $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                                                    
                                                    $supplierReturnNoteReferenceNo = $journalEntry[0]->reference_no;
                                                    $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteByReferenceNo($supplierReturnNoteReferenceNo, '');

                                                    if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {

                                                        $supplierReturnNoteId = $supplierReturnNote[0]->supplier_return_note_id;
                                                        
                                                        $referenceTransactionTypeId = '3';
                                                        $referenceTransactionId = $supplierReturnNoteId;
                                                        $referenceJournalEntryId = $journalEntryId;
                                                        
                                                        $totalAmount = $supplierReturnNote[0]->amount;
                                                        $paidCashAmount = $supplierReturnNote[0]->cash_payment_amount;
                                                        $paidChequeAmount = $supplierReturnNote[0]->cheque_payment_amount;
                                                        $paidCreditCardAmount = $supplierReturnNote[0]->credit_card_payment_amount;
                                                        $purchaseAmountClaimed = $supplierReturnNote[0]->purchase_note_claimed;
                                                        $totalReceivable = $totalAmount;
                                                        //$totalReceived = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + ($purchaseAmountClaimed - $claimReturnAmount);
                                                        $totalReceived = $paidCashAmount + $paidChequeAmount + $paidCreditCardAmount + $purchaseAmountClaimed;
                                                        
                                                        $currentBalancePayment = $totalReceivable - $totalReceived;
                                                        
                                                        if (round($currentBalancePayment) > 0) {
                                                        
                                                            $newBalancePayment = 0;
                                                            $amountToClaimFromPayment = 0;
                                                            $amountToClaimFromSupplierReturnAmount = 0;

                                                            if ($purchaseNoteAmountTotal > 0) {

                                                                if ($currentBalancePayment >= $purchaseNoteAmountTotal) {
                                                                    $amountToClaimFromPayment = $currentBalancePayment - $purchaseNoteAmountTotal;

                                                                    if ($amountToClaimFromPayment > $remainingPaymentAmount) {
                                                                        $amountToClaimFromPayment = $remainingPaymentAmount;
                                                                    }

                                                                    $amountToClaimFromSupplierReturnAmount = $purchaseNoteAmountTotal;
                                                                    $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromPayment + $purchaseNoteAmountTotal);
                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $amountToClaimFromPayment;
                                                                    $purchaseNoteAmountTotal = 0;
                                                                } else {
                                                                    $amountToClaimFromSupplierReturnAmount = $currentBalancePayment;
                                                                    $newBalancePayment = $totalReceivable - ($totalReceived + $amountToClaimFromSupplierReturnAmount);
                                                                    $purchaseNoteAmountTotal = $purchaseNoteAmountTotal - $amountToClaimFromSupplierReturnAmount;
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

                                                            if ($amountToClaimFromSupplierReturnAmount > 0) {
                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'cash_payment_amount' => $paidCashAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'purchase_note_claimed' => $amountToClaimFromSupplierReturnAmount,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $cashPaymentData = array(
                                                                        'transaction_type' => 'Supplier Return',
                                                                        'transaction_id' => $supplierReturnNoteId,
                                                                        'date' => $receivePaymentDate,
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
                                                                        'purchase_note_claimed' => $amountToClaimFromSupplierReturnAmount,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $incomeChequeData = array(
                                                                        'transaction_type' => 'Supplier Return',
                                                                        'transaction_id' => $supplierReturnNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'payer_id' => $payerId,
                                                                        'location_id' => $locationId,
                                                                        'reference_no' => $salesNoteReferenceNo,
                                                                        'cheque_number' => $chequeNumber,
                                                                        'bank' => $bankId,
                                                                        'cheque_date' => $chequeDate,
                                                                        'third_party_cheque' => $thirdPartyCheque,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'crossed_cheque' => $crossedCheque,
                                                                        'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                        'status' => "In_Hand",
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'added'
                                                                    );

                                                                    $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $paidAmount = $amountToClaimFromPayment;

                                                                    $data = array(
                                                                        'credit_card_payment_amount' => $paidCreditCardAmount + $amountToClaimFromPayment,
                                                                        'balance_payment' => $newBalancePayment,
                                                                        'purchase_note_claimed' => $amountToClaimFromSupplierReturnAmount,
                                                                        'status' => $status,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $creditCardPaymentData = array(
                                                                        'transaction_type' => 'Supplier Return',
                                                                        'transaction_id' => $supplierReturnNoteId,
                                                                        'date' => $receivePaymentDate,
                                                                        'card_type' => $cardType,
                                                                        'amount' => $amountToClaimFromPayment,
                                                                        'actioned_user_id' => $this->user_id,
                                                                        'action_date' => $this->date,
                                                                        'last_action_status' => 'edited'
                                                                    );

                                                                    $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                }

                                                                $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);
                                                            } else {
                                                                if ($currentBalancePayment > $remainingPaymentAmount && $remainingPaymentAmount > 0) {

                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $remainingPaymentAmount;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $remainingPaymentAmount,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'purchase_note_claimed' => $purchaseAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
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
                                                                            'purchase_note_claimed' => $purchaseAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $salesNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $remainingPaymentAmount;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $remainingPaymentAmount,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'purchase_note_claimed' => $purchaseAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $remainingPaymentAmount,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);

                                                                    $remainingPaymentAmount = 0;
                                                                } else if ($currentBalancePayment > 0 && $currentBalancePayment <= $remainingPaymentAmount) {
                                                                    if ($paymentMethod == 'Cash Payment') {
                                                                        $paidAmount = $currentBalancePayment;

                                                                        $data = array(
                                                                            'cash_payment_amount' => $paidCashAmount + $currentBalancePayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'purchase_note_claimed' => $purchaseAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $cashPaymentData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
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
                                                                            'purchase_note_claimed' => $purchaseAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $incomeChequeData = array(
                                                                            'transaction_type' => 'Supplier Return',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'payer_id' => $payerId,
                                                                            'location_id' => $locationId,
                                                                            'reference_no' => $salesNoteReferenceNo,
                                                                            'cheque_number' => $chequeNumber,
                                                                            'bank' => $bankId,
                                                                            'cheque_date' => $chequeDate,
                                                                            'third_party_cheque' => $thirdPartyCheque,
                                                                            'amount' => $currentBalancePayment,
                                                                            'crossed_cheque' => $crossedCheque,
                                                                            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
                                                                            'status' => "In_Hand",
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'added'
                                                                        );

                                                                        $chequeId = $this->payments_model->addIncomeCheque($incomeChequeData);
                                                                    } else if ($paymentMethod == 'Card Payment') {
                                                                        $paidAmount = $currentBalancePayment;

                                                                        $data = array(
                                                                            'credit_card_payment_amount' => $paidCreditCardAmount + $currentBalancePayment,
                                                                            'balance_payment' => $newBalancePayment,
                                                                            'purchase_note_claimed' => $purchaseAmountClaimed,
                                                                            'status' => $status,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $creditCardPaymentData = array(
                                                                            'transaction_type' => 'Supplier Return Note',
                                                                            'transaction_id' => $supplierReturnNoteId,
                                                                            'date' => $receivePaymentDate,
                                                                            'card_type' => $cardType,
                                                                            'amount' => $currentBalancePayment,
                                                                            'actioned_user_id' => $this->user_id,
                                                                            'action_date' => $this->date,
                                                                            'last_action_status' => 'edited'
                                                                        );

                                                                        $paymentId = $this->payments_model->addCreditCardPayment($creditCardPaymentData);
                                                                    }

                                                                    $this->supplier_return_note_model->editSupplierReturnNoteData($supplierReturnNote[0]->supplier_return_note_id, $data);

                                                                    $remainingPaymentAmount = $remainingPaymentAmount - $currentBalancePayment;
                                                                }
                                                            }

                                                            $claimAmount = 0;

                                                            if ($receivePaymentClaimAmountTotal >= $amountToClaimFromSupplierReturnAmount) {
                                                                $claimAmount = $amountToClaimFromSupplierReturnAmount;
                                                                $receivePaymentClaimAmountTotal = $receivePaymentClaimAmountTotal - $amountToClaimFromSupplierReturnAmount;
                                                            } else if ($receivePaymentClaimAmountTotal > 0) {
                                                                $claimAmount = $receivePaymentClaimAmountTotal;
                                                                $receivePaymentClaimAmountTotal = 0;
                                                            }

                                                            $primeEntryBooksToUpdateForCustomerReturnNoteClaim = $this->getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim();

                                                            //Post journal entry for customer return note claim for sales note
                                                            if ($claimAmount > 0 && $journalEntryId != '') {

                                                                if ($claimTransactionList && sizeof($claimTransactionList) > 0) {
                                                                    $count = 0;
                                                                    $arrayElementsToUnset = array();
                                                                    foreach($claimTransactionList as $claimTransactionRow) {
                                                                        if ($claimTransactionRow[1] <= $claimAmount) {

                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerReturnNoteClaim, '', $receivePaymentDate, 
                                                                                    $supplierReturnNoteReferenceNo, '3', $supplierReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payerId, 
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
                                                                            $claimReferenceJournalEntryId = $this->postReferenceJournalEntries($primeEntryBooksToUpdateForCustomerReturnNoteClaim, '', $receivePaymentDate, 
                                                                                    $supplierReturnNoteReferenceNo, '3', $supplierReturnNoteId, $journalEntryId, $claimTransactionRow[2], $locationId, "Supplier", $payerId, 
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
                                                                $creditCardPaymentId = 0;

                                                                if ($paymentMethod == 'Cash Payment') {
                                                                    $cashPaymentId = $paymentId;
                                                                } else if ($paymentMethod == 'Card Payment') {
                                                                    $creditCardPaymentId = $paymentId;
                                                                }

                                                                $receivePaymentMethodRecordData = array(
                                                                    'receive_payment_id' => $receivePaymentId,
                                                                    'payment_method' => $paymentMethod,
                                                                    'card_type' => $cardType,
                                                                    'cash_payment_id' => $cashPaymentId,
                                                                    'cheque_id' => $chequeId,
                                                                    'credit_card_payment_id' => $creditCardPaymentId,
                                                                    'actioned_user_id' => $this->user_id,
                                                                    'action_date' => $this->date,
                                                                    'last_action_status' => 'added'
                                                                );

                                                                $receivePaymentMethodId = $this->receive_payment_model->addReceivePaymentMethodRecord($receivePaymentMethodRecordData);

                                                                $correctChartOfAccountsFoundInPrimeEntryBooks = true;

                                                                $primeEntryBookIds = '';
                                                                if ($paymentMethod == "Cash Payment") {
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction();

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
                                                                    $primeEntryBooksToUpdate = $this->getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction();


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
                                                                } else if ($paymentMethod == "Card Payment") {
                                                                    $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($paymentAccountId);

                                                                    if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 2) {
                                                                        $correctChartOfAccountsFoundInPrimeEntryBooks = false;
                                                                    } else {
                                                                        $primeEntryBookIds[] = $paymentAccountId;
                                                                    }
                                                                }

                                                                if ($correctChartOfAccountsFoundInPrimeEntryBooks == true) {
                                                                    if ($primeEntryBookIds && sizeof($primeEntryBookIds) > 0) {

                                                                        foreach ($primeEntryBookIds as $primeEntryBookId) {

                                                                            $data = array(
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'transaction_date' => $receivePaymentDate,
                                                                                'reference_no' => $receivePaymentReferenceNo,
                                                                                'should_have_a_payment_journal_entry' => "No",
                                                                                'location_id' => $locationId,
                                                                                'payee_payer_type' => $payerType,
                                                                                'payee_payer_id' => $payerId,
                                                                                'reference_transaction_type_id' => $referenceTransactionTypeId,
                                                                                'reference_transaction_id' => $referenceTransactionId,
                                                                                'reference_journal_entry_id' => $referenceJournalEntryId,
                                                                                'description' => $this->lang->line('Journal entry for Receive Payment number : ') . $receivePaymentReferenceNo,
                                                                                'post_type' => "Indirect",
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                                                            $data = array(
                                                                                'receive_payment_id' => $receivePaymentId,
                                                                                'receive_payment_method_id' => $receivePaymentMethodId,
                                                                                'prime_entry_book_id' => $primeEntryBookId,
                                                                                'journal_entry_id' => $journalEntryId,
                                                                                'actioned_user_id' => $this->user_id,
                                                                                'action_date' => $this->date,
                                                                                'last_action_status' => 'added'
                                                                            );

                                                                            $this->receive_payment_model->addReceivePaymentJournalEntry($data);

                                                                            $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);

                                                                            foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                                                                if ($paymentMethod == "Cheque Payment") {
                                                                                    $transactionStatus = "No";
                                                                                } else {
                                                                                    $transactionStatus = "Yes";
                                                                                }

                                                                                if ($chartOfAccount->debit_or_credit == "debit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'debit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                } else if ($chartOfAccount->debit_or_credit == "credit") {
                                                                                    $data = array(
                                                                                        'journal_entry_id' => $journalEntryId,
                                                                                        'prime_entry_book_id' => $primeEntryBookId,
                                                                                        'transaction_date' => $receivePaymentDate,
                                                                                        'chart_of_account_id' => $chartOfAccount->chart_of_account_id,
                                                                                        'credit_value' => $paidAmount,
                                                                                        'transaction_complete' => $transactionStatus,
                                                                                        'actioned_user_id' => $this->user_id,
                                                                                        'action_date' => $this->date,
                                                                                        'last_action_status' => 'added'
                                                                                    );
                                                                                }

                                                                                $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                                                                //Same time add the data to previous years record table.
                                                                                $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                                                            }

                                                                            if ($chequeId != '' && $chequeId != '0') {
                                                                                $incomeChequeData = array(
                                                                                    'cheque_reference_journal_entry_id' => $journalEntryId,
                                                                                    'actioned_user_id' => $this->user_id,
                                                                                    'action_date' => $this->date,
                                                                                    'last_action_status' => 'added'
                                                                                );

                                                                                $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                                                                            }
                                                                        }
                                                                    } 

                                                                    $result = 'ok';
                                                                } else {
                                                                    $result = 'incorrect_prime_entry_book_selected_for_receive_payment_transaction';
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
					}
				}
			}

            if ($result == '') {
				$result = 'ok';
			}
            
			echo json_encode(array('result' => $result, 'receivePaymentId' => $receivePaymentId));
		}
	}

	//Delete Receive Payment
	public function deleteReceivePayment() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Receive_Payment_Permissions'])) {

            $receivePaymentId = $this->db->escape_str($this->input->post('id'));
			
			$status = "deleted";
            
            $paymentReferenceList = $this->receive_payment_model->getReceivePaymentReferenceTransactionList($receivePaymentId);
            $paymentMethodList = $this->receive_payment_model->getReceivePaymentMethodList($receivePaymentId);
            $refundClaimAmountTotal = $this->receive_payment_model->getReceivePaymentClaimAmountTotal($receivePaymentId);
			
            if ($paymentMethodList && sizeof($paymentMethodList) > 0) {

                foreach ($paymentMethodList as $paymentMethodRecord) {

                    $paymentMethod = $paymentMethodRecord->payment_method;
                    $cashPaymentId = $paymentMethodRecord->cash_payment_id;
                    $chequeId = $paymentMethodRecord->cheque_id;
                    $creditCardPaymentId = $paymentMethodRecord->credit_card_payment_id;
                    
                    $cashAmount = 0;
                    $chequeAmount = 0;
                    $creditCardAmount = 0;
                    $status = "deleted";

                    if ($paymentMethod == "Cash Payment") {
                        $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
                        $cashAmount = $cashPayment[0]->amount;
                        $this->payments_model->deleteCashPayment($cashPaymentId, $status, $this->user_id);
                    } else if ($paymentMethod == "Cheque Payment") {
                        $incomeCheque = $this->payments_model->getIncomeChequeById($chequeId);
                        $chequeAmount = $incomeCheque[0]->amount;
                        $this->payments_model->deleteIncomeCheque($chequeId, $status, $this->user_id);
                    } else if ($paymentMethod == "Card Payment") {
                        $creditCardPayment = $this->payments_model->getCardPaymentById($creditCardPaymentId);
                        $creditCardAmount = $creditCardPayment[0]->amount;
                        $this->payments_model->deleteCardPayment($creditCardPaymentId, $status, $this->user_id);
                    }

                    //Reverse current reference transactions changes from the receive payment
                    if ($paymentReferenceList && sizeof($paymentReferenceList) > 0) {

                        foreach ($paymentReferenceList as $paymentReference) {

                            $referenceTransactionTypeId = $paymentReference->reference_transaction_type_id;
                            $referenceTransactionId = $paymentReference->reference_transaction_id;

                            if ($referenceTransactionTypeId == '1') {
                                //Purchase Note
                                $purchaseNoteId = $referenceTransactionId;
                                $purchaseNote = $this->purchase_note_model->getPurchaseNoteById($purchaseNoteId);

                                $status = $purchaseNote[0]->status;
                                $amount = $purchaseNote[0]->amount;
                                $currentBalancePayment = $purchaseNote[0]->balance_payment;

                                if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                    $purchaseNoteData = array(
                                        'balance_payment' => $amount,
                                        'status' => "Open",
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->purchase_note_model->editPurchaseNoteData($referenceTransactionId, $purchaseNoteData);
                                }
                                
                                $purchaseNoteSalesEntryJournalEntries = $this->purchase_note_model->getPurchaseNoteJournalEntries($purchaseNoteId);
                                    
                                if ($purchaseNoteSalesEntryJournalEntries && sizeof($purchaseNoteSalesEntryJournalEntries) > 0) {
                                    //Delete purchase claim journal entries
                                    foreach($purchaseNoteSalesEntryJournalEntries as $journalEntry) {
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
                            } else if ($referenceTransactionTypeId == '2') {
                                //Sales Note
                                $successfulTransaction = false;

                                $salesNoteId = $referenceTransactionId;
                                $salesNote = $this->sales_note_model->getSalesNoteById($salesNoteId);

                                $currentCashPayment = $salesNote[0]->cash_payment_amount;
                                $currentChequePayment = $salesNote[0]->cheque_payment_amount;
                                $currentCreditCardPayment = $salesNote[0]->credit_card_payment_amount;
                                $currentBalancePayment = $salesNote[0]->balance_payment;
                                $claimAmountTotal = $salesNote[0]->customer_return_note_claimed;

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

                                if ($currentCreditCardPayment >= $creditCardAmount) {
                                    $currentCreditCardPayment = $currentCreditCardPayment - $creditCardAmount;
                                    $currentBalancePayment = $currentBalancePayment + $creditCardAmount;
                                    $creditCardAmount = 0;
                                    $successfulTransaction = true;
                                } else if ($currentCreditCardPayment < $creditCardAmount) {
                                    $creditCardAmount = $creditCardAmount - $currentCreditCardPayment;
                                    $currentBalancePayment = $currentBalancePayment + $currentCreditCardPayment;
                                    $currentCreditCardPayment = 0;
                                    $successfulTransaction = true;
                                }

                                if ($successfulTransaction) {
                                    
                                    $currentBalancePayment = $currentBalancePayment + $balancePaymentAdjustmentFromClaimAmount;

                                    $salesNoteData = array(
                                        'cash_payment_amount' => $currentCashPayment,
                                        'cheque_payment_amount' => $currentChequePayment,
                                        'credit_card_payment_amount' => $currentCreditCardPayment,
                                        'balance_payment' => $currentBalancePayment,
                                        'customer_return_note_claimed' => $claimAmountTotal,
                                        'status' => "Open",
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->sales_note_model->editSalesNoteData($referenceTransactionId, $salesNoteData);
                                }
                            } else if ($referenceTransactionTypeId == '3') {
                                //Supplier Return Note
                                $successfulTransaction = false;

                                $supplierReturnNoteId = $referenceTransactionId;
                                $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($supplierReturnNoteId);

                                $currentCashPayment = $supplierReturnNote[0]->cash_payment_amount;
                                $currentChequePayment = $supplierReturnNote[0]->cheque_payment_amount;
                                $currentCreditCardPayment = $supplierReturnNote[0]->credit_card_payment_amount;
                                $currentBalancePayment = $supplierReturnNote[0]->balance_payment;
                                $claimAmountTotal = $supplierReturnNote[0]->purchase_note_claimed;

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

                                if ($currentCreditCardPayment >= $creditCardAmount) {
                                    $currentCreditCardPayment = $currentCreditCardPayment - $creditCardAmount;
                                    $currentBalancePayment = $currentBalancePayment + $creditCardAmount;
                                    $creditCardAmount = 0;
                                    $successfulTransaction = true;
                                } else if ($currentCreditCardPayment < $creditCardAmount) {
                                    $creditCardAmount = $creditCardAmount - $currentCreditCardPayment;
                                    $currentBalancePayment = $currentBalancePayment + $currentCreditCardPayment;
                                    $currentCreditCardPayment = 0;
                                    $successfulTransaction = true;
                                }

                                if ($successfulTransaction) {

                                    $supplierReturnNoteData = array(
                                        'cash_payment_amount' => $currentCashPayment,
                                        'cheque_payment_amount' => $currentChequePayment,
                                        'credit_card_payment_amount' => $currentCreditCardPayment,
                                        'balance_payment' => $currentBalancePayment,
                                        'purchase_note_claimed' => $claimAmountTotal,
                                        'status' => "Open",
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->supplier_return_note_model->editSupplierReturnNoteData($referenceTransactionId, $supplierReturnNoteData);
                                }
                            } else if ($referenceTransactionTypeId == '4') {
                                //Customer Return Note
                                $customerReturnNoteId = $referenceTransactionId;
                                $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($customerReturnNoteId);

                                $status = $customerReturnNote[0]->status;
                                $amount = $customerReturnNote[0]->amount;
                                $currentBalancePayment = $customerReturnNote[0]->balance_payment;
                                $customerReturnType = $customerReturnNote[0]->type;

                                if ($status == "Claimed" && $currentBalancePayment == "0.00") {
                                    $customerReturnNoteData = array(
                                        'balance_payment' => $amount,
                                        'status' => "Open",
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->customer_return_note_model->editCustomerReturnNoteData($referenceTransactionId, $customerReturnNoteData);
                                }
                                
                                if ($customerReturnType == 'saleable_return') {
                                    $customerReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '1');
                                } else if ($customerReturnType == 'market_return') {
                                    $customerReturnNoteSalesEntryJournalEntries = $this->customer_return_note_model->getCustomerReturnNoteJournalEntries($customerReturnNoteId, '3');
                                }

                                if ($customerReturnNoteSalesEntryJournalEntries && sizeof($customerReturnNoteSalesEntryJournalEntries) > 0) {
                                    //Delete customer return claim journal entries
                                    foreach($customerReturnNoteSalesEntryJournalEntries as $journalEntry) {
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
                            }
                        }
                    }

                    $this->receive_payment_model->deleteReceivePaymentReferenceTransactionsSoftly($receivePaymentId, "deleted", $this->user_id);
                }
            }
            
            $this->receive_payment_model->deleteReceivePaymentMethodRecordsSoftly($receivePaymentId, "deleted", $this->user_id);
                
			$receivePaymentJournalEntries = $this->receive_payment_model->getReceivePaymentJournalEntries($receivePaymentId);

			if ($receivePaymentJournalEntries && sizeof($receivePaymentJournalEntries) > 0) {
				//Delete all journal entries of Receive Payment
				foreach($receivePaymentJournalEntries as $receivePaymentJournalEntry) {
					$receivePaymentJournalEntryId = $receivePaymentJournalEntry->receive_payment_journal_entry_id;
					$journalEntryId = $receivePaymentJournalEntry->journal_entry_id;
					$this->receive_payment_model->deleteReceivePaymentJournalEntry($receivePaymentJournalEntryId, "deleted", $this->user_id);
					$this->journal_entries_model->deleteJournalEntry($journalEntryId, "deleted", $this->user_id);
					$this->journal_entries_model->deleteGeneralLedgerTransactions($journalEntryId, "deleted", $this->user_id);
				}
			}

			if ($this->receive_payment_model->deleteReceivePayment($receivePaymentId, "deleted",$this->user_id)) {
				$html = '<div class="alert alert-success alert-dismissable">
					<a class="close" href="#" data-dismiss="alert">x </a>
					<h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
					$this->lang->line('success_deleted') .
					'</div>';
			}
			
			echo $html;
		}
	}

	public function getReceivePaymentData() {
		if(isset($this->data['ACM_Bookkeeping_View_Receive_Payment_Permissions'])) {
            $receivePaymentId = $this->db->escape_str($this->input->post('id'));
			$receivePayment = $this->receive_payment_model->getReceivePaymentById($receivePaymentId);
			$html = "";
			$referenceTransactionData = '';
			$receivePaymentMethodData = '';
			if ($receivePayment != null) {
				foreach ($receivePayment as $row) {
					
					$html .="   <form class='form form-horizontal validate-form save_form'>
								<div class='form-group'>
									<input class='form-control'   id='receive_payment_id' name='receive_payment_id' type='hidden' value='{$row->receive_payment_id}'>
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
										<div class='datepicker-input input-group' id='datepicker_receive_payment_date_edit'>
											<input class='form-control' id='receive_payment_date_edit' name='receive_payment_date_edit'
												data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$row->date}'>
											<span class='input-group-addon'>
												<span class='glyphicon glyphicon-calendar'/>
											</span>
										</div>
										<div id='receive_payment_date_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'>{$this->lang->line('Payer Type')} *</label>
									<div class='col-sm-4 controls'>
										<select class='form-control' name='payer_type_edit' id='payer_type_edit' onchange='getPeopleType(this.id);' disabled>
												<option value=''>" . $this->lang->line('-- Select --') . "</option>";

					$peopleTypes = $this->getPeopleType();
					$payerType = $row->payer_type;
					$payerId = $row->payer_id;

											foreach($peopleTypes as $peopleType){
												if ($peopleType['people_type'] == $payerType) {
				$html .=   "							<option value='" . $peopleType['people_type'] . "' selected>" . $peopleType['people_type'] . "</option>";			
												} else {
				$html .=  	"							<option value='" . $peopleType['people_type'] . "'>" . $peopleType['people_type'] . "</option>";
												}
											}
	$html .=  	    "							</select>
										<div id='payer_type_editError' class='red'></div>
									</div>
								</div>
								<div class='form-group' id='payer_list_div_edit'>
																	
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
												
				$paymentReferenceList = $this->receive_payment_model->getReceivePaymentReferenceTransactionList($receivePaymentId);
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
							$generalLedgerTransaction = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId);
							$transactionBalanceAmount = number_format($generalLedgerTransaction[0]->debit_value, 2);
							$referenceTransactionTotalAmount = $referenceTransactionTotalAmount + $generalLedgerTransaction[0]->debit_value;
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
											
				$html .="		<div id='receive_payment_reference_list_edit'>
									<h4>{$this->lang->line('Reference Transactions')}</h4>
									<div class='box-content box-no-padding out-table'>
										<div class='table-responsive table_data'>
											<div class='scrollable-area1'>
												<table class='table table-striped table-bordered receivePaymentReferenceDataEditTable' style='margin-bottom:0;'>
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
														"<tr id='receive_payment_reference_amount_total_edit'>
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

								<div class='box' id='receive_payment_method_list_edit'>
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
                                                    <a data-toggle='tab' class='tab-header' href='#credit_card_payment_edit'>{$this->lang->line('Credit Card Payment')}</a>
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
                                                        <div class='col-sm-2 controls'>
                                                            <input type='checkbox' name='third_party_cheque_edit' id='third_party_cheque_edit' style='vertical-align: text-bottom;'>
                                                            <label for='third_party_cheque_edit'>{$this->lang->line('Third Party Cheque')}</label>
                                                        </div>
                                                        <div class='col-sm-2 controls'>
                                                            <input type='checkbox' name='crossed_cheque_edit' id='crossed_cheque_edit' style='vertical-align: text-bottom;' onchange='handCrossedChequeSelect(this.id)'>
                                                            <label for='crossed_cheque_edit'>{$this->lang->line('Crossed Cheque')}</label>
                                                        </div>
													</div>
													<div class='form-group'>
														<label class='control-label col-sm-3'>{$this->lang->line('Amount')} *</label>
														<div class='col-sm-4 controls'>
															<input class='form-control input-sm' id='cheque_payment_amount_edit' name='cheque_payment_amount_edit' placeholder='{$this->lang->line('Amount')}' type='text'>
															<div id='cheque_payment_amount_editError' class='red'></div>
														</div>
													</div>
                                                    <div class='form-group' id='cheque_deposit_account_div_edit'>
                                                        <label class='control-label col-sm-3'>{$this->lang->line('Cheque Deposit Account')}</label>
                                                        <div class='col-sm-4 controls'>
                                                            <select id='cheque_deposit_account_init_edit' class='form-control'><option>{$this->lang->line('-- Select --')}</option></select>
                                                            <div id='cheque_deposit_account_dropdown_edit'>
                                                            </div>
                                                            <div id='cheque_deposit_account_id_editError' class='red'></div>
                                                        </div>
                                                    </div>
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
												<div id='credit_card_payment_edit' class='tab-pane'>
                                                    <div class='form-group'>
                                                        <label class='control-label col-sm-3'>{$this->lang->line("Card Type")}</label>
                                                        <div class='col-sm-4 controls'>
                                                            <select id='credit_card_type_init_edit' class='form-control'>
                                                                <option value=''>{$this->lang->line('-- Select --')}</option>
                                                                <option value='Visa'>{$this->lang->line('Visa')}</option>
                                                                <option value='Master'>{$this->lang->line('Master')}</option>
                                                            </select>
                                                            <div id='credit_card_type_id_editError' class='red'></div>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='control-label col-sm-3'>{$this->lang->line("Card Payment")} *</label>
                                                        <div class='col-sm-4 controls'>
                                                            <input class='form-control pos-screen-two-text-field' id='credit_card_payment_amount_edit' name='credit_card_payment_amount_edit' placeholder='{$this->lang->line('Card Payment')}' type='text' value=''>
                                                            <div id='credit_card_payment_amount_editError' class='red'></div>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <div class='col-sm-3 controls'></div>
                                                        <div class='col-sm-4 controls'>
                                                            <input type='checkbox' name='include_bank_charge_edit' id='include_bank_charge_edit' style='vertical-align: text-bottom;' onchange='handleIncludeBankChargeSelect(this.id);'>
                                                            <label for='include_bank_charge_edit'>{$this->lang->line('Include Bank Charge')}</label>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='control-label col-sm-3'>{$this->lang->line("Total Card Payment")}</label>
                                                        <div class='col-sm-4 controls'>
                                                            <input class='form-control pos-screen-two-text-field' id='total_card_payment_edit' name='total_card_payment_edit' placeholder='{$this->lang->line('Total Card Payment')}' type='text' disabled value=''>
                                                            <div id='total_card_payment_editError' class='red'></div>
                                                        </div>
                                                        <br><br>
                                                        <div class='form-group'>
                                                            <div class='col-sm-9 col-sm-offset-4'>
                                                                <button class='btn btn-success save'
                                                                        onclick='addCreditCardPayment();' type='button'>
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
																	
					$paymentMethodList = $this->receive_payment_model->getReceivePaymentMethodList($receivePaymentId);
					$receivePaymentTotal = '0.00';
					$receivePaymentMethodRowCount = '1';
					
					if ($paymentMethodList && sizeof($paymentMethodList) > 0) {
						
						foreach ($paymentMethodList as $paymentMethodRecord) {
							
							$paymentMethod = $paymentMethodRecord->payment_method;
                            $cashPaymentId = $paymentMethodRecord->cash_payment_id;
							$chequeId = $paymentMethodRecord->cheque_id;
                            $creditCardPaymentId = $paymentMethodRecord->credit_card_payment_id;
                            $cardType = $paymentMethodRecord->card_type;
							
							$chequeNumber = '';
							$bankId = '';
							$chequeDate = '';
                            $thirdPartyCheque = '';
							$bankName = '';
                            $amount = '';
                            $crossedCheque = '';
                            $chequeDepositAccountId = '';
                            
                            if ($cashPaymentId != '0') {
                                if ($paymentMethod == "Cash Payment") {
                                    $cashPayment = $this->payments_model->getCashPaymentById($cashPaymentId);
                                    $amount = $cashPayment[0]->amount;
                                }
                            }
							
							if ($chequeId != '0') {
								if ($paymentMethod == "Cheque Payment") {
									$cheque = $this->payments_model->getIncomeChequeById($chequeId);

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
                                        $thirdPartyCheque = $cheque[0]->third_party_cheque;
                                        $amount = $cheque[0]->amount;
                                        $crossedCheque = $cheque[0]->crossed_cheque;
                                        $chequeDepositAccountId = $cheque[0]->cheque_deposit_prime_entry_book_id;
									}
								}
							}
                            
                            if($creditCardPaymentId != '0') {
                                $cardPayment = $this->payments_model->getCardPaymentById($creditCardPaymentId);
                                $amount = $cardPayment[0]->amount;
                            }
							
							$receivePaymentTotal = $receivePaymentTotal + $amount;
							
		$receivePaymentMethodData .= "<tr id='payment_method_row_edit_" . $receivePaymentMethodRowCount . "'>
							    <input class='form-control' id='cheque_id_edit_" . $receivePaymentMethodRowCount . "' name='cheque_id_edit_" . $receivePaymentMethodRowCount . "' type='hidden' value='" . $chequeId . "'>
							    <input class='form-control' id='bank_id_edit_" . $receivePaymentMethodRowCount . "' name='bank_id_edit_" . $receivePaymentMethodRowCount . "' type='hidden' value='" . $bankId . "'>
                                <input class='form-control' id='third_party_cheque_edit_" . $receivePaymentMethodRowCount . "' name='third_party_cheque_edit_" . $receivePaymentMethodRowCount . "' type='hidden' value='" . $thirdPartyCheque . "'>
                                <input class='form-control' id='crossed_cheque_edit_" . $receivePaymentMethodRowCount . "' name='crossed_cheque_edit_" . $receivePaymentMethodRowCount . "' type='hidden' value='" . $crossedCheque . "'>
                                <input class='form-control' id='cheque_deposit_account_id_edit_" . $receivePaymentMethodRowCount . "' name='cheque_deposit_account_id_edit_" . $receivePaymentMethodRowCount . "' type='hidden' value='" . $chequeDepositAccountId . "'>
								<td id='receive_payment_method_edit_" . $receivePaymentMethodRowCount . "'>" . $paymentMethod . "</td>
								<td id='cheque_number_edit_" . $receivePaymentMethodRowCount . "'>" . $chequeNumber . "</td>
								<td id='bank_edit_" . $receivePaymentMethodRowCount . "'>" . $bankName . "</td>
								<td id='cheque_date_edit_" . $receivePaymentMethodRowCount . "'>" . $chequeDate . "</td>
                                <td id='card_type_edit_" . $receivePaymentMethodRowCount . "'>" . $cardType . "</td>
								<td id='amount_edit_" . $receivePaymentMethodRowCount . "'>" . number_format($amount, 2) . "</td>
								<td><a class='btn btn-danger btn-xs delete' id='delete_receive_payment_method_edit_" . $receivePaymentMethodRowCount . "' title='{$this->lang->line('Delete')}' onclick='deleteReceivePaymentMethod(this.id);'>
										<i class='icon-remove'></i>
									 </a></td>
								</tr>";
								
							$receivePaymentMethodRowCount++;
						}
					}

					$html .="	<div id='receive_payment_method_records_edit'>
									<h4>{$this->lang->line('Payment Method List')}</h4>
									<div class='box-content box-no-padding out-table'>
										<div class='table-responsive table_data'>
											<div class='scrollable-area1'>
												<table class='table table-striped table-bordered receivePaymentMethodDataEditTable' style='margin-bottom:0;'>
													<thead>
														<tr>
															<th>{$this->lang->line('Payment Method')}</th>
															<th>{$this->lang->line('Cheque Number')}</th>
															<th>{$this->lang->line('Bank')}</th>
															<th>{$this->lang->line('Cheque Date')}</th>
                                                            <th>{$this->lang->line('Card Type')}</th>
															<th>{$this->lang->line('Amount')}</th>
															<th>{$this->lang->line('Actions')}</th>
														</tr>
													</thead>
													<tbody>"
														. $receivePaymentMethodData . 
														"<tr id='receive_payment_method_amount_total_edit'>		
															<td>{$this->lang->line('Total')}</td>
															<td></td>
															<td></td>
															<td></td>
                                                            <td></td>
															<td id='payment_method_amount_total_edit'>" . number_format($receivePaymentTotal, 2) . "</td>
															<td></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div><br>
								</div>";

								$referenceTransactionType = $this->getReferenceTransactionTypesDropdown();
								$amount = number_format($receivePaymentTotal, 2);
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
											if(isset($this->data['ACM_Bookkeeping_Edit_Receive_Payment_Permissions'])) {
												$html .= "<button class='btn btn-success save' onclick='editReceivePaymentData({$row->receive_payment_id});' type='button' id='receive_payment_edit_button'>
															<i class='icon-save'></i>
															{$this->lang->line('Edit')}
														</button> ";
											}
								$html.="            <button class='btn btn-warning cancel' onclick='closeReceivePaymentEditForm({$row->receive_payment_id});' type='button'>
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

			echo json_encode(array('result' => $html, 'payerType' => $payerType, 'payerId' => $payerId, 'referenceTransactionType' => $referenceTransactionType, 'referenceTransactionList' => $referenceTransactionList, 'referenceTransactionRowCount' => $referenceTransactionRowCount - 1, 'receivePaymentMethodRowCount' => $receivePaymentMethodRowCount - 1, 'referenceTransactionTotalAmount' => $referenceTransactionTotalAmount, 'transactionMethodAmountTotal' => $receivePaymentTotal,  'amountToAddForPaymentType' => $amountToAddForPaymentType));
		}
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Receive_Payment_Permissions'])) {
			
			$hideMonthFilter = false;
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			$payerId = $this->db->escape_str($this->input->post('payer_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
            $purchaseNoteId = $this->db->escape_str($this->input->post('purchase_note_id'));
            $salesNoteId = $this->db->escape_str($this->input->post('sales_note_id'));
            $customerReturnId = $this->db->escape_str($this->input->post('customer_return_note_id'));
            $supplierReturnId = $this->db->escape_str($this->input->post('supplier_return_note_id'));
			
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
							<table class='table table-striped table-bordered receivePaymentDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Reference No')}</th>
										<th>{$this->lang->line('Date')}</th>
										<th>{$this->lang->line('Payer')}</th>
										<th>{$this->lang->line('Location')}</th>
										<th>{$this->lang->line('Actions')}</th>
									</tr>
								</thead>
								<tbody>";
			
			$receivePayments = $this->receive_payment_model->getAllForPeriod($fromDate, $toDate, $payerId, $locationId, 
                                    $purchaseNoteId, $salesNoteId, $customerReturnId, $supplierReturnId, 'date', 'desc');

			if ($receivePayments != null) {
				foreach ($receivePayments as $row) {
					
					$html .= "<tr>";
					$html .= "<td>" . $row->reference_no . "</td>";
					$html .= "<td>" . $row->date . "</td>";
					$html .= "<td>" . $row->people_name . "</td>";
					$html .= "<td>" . $row->location_name . "</td>";
					$html .= "<td>
											<div class='text-left'>";
											if(isset($this->data['ACM_Bookkeeping_Edit_Receive_Payment_Permissions'])) {
												$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->receive_payment_id}' title='{$this->lang->line('Edit')}' onclick='getReceivePaymentData({$row->receive_payment_id});'>
																						<i class='icon-wrench'></i>
																					</a> ";
											}
											if(isset($this->data['ACM_Bookkeeping_Delete_Receive_Payment_Permissions'])) {
												$html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->receive_payment_id}' title='{$this->lang->line('Delete')}' onclick='del($row->receive_payment_id);'>
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
				
                if ($referenceTransactionTypeId == '2') {
                    $description = $this->lang->line('Journal entry for sales note claim transaction for Sales Note number : ') . $referenceNo . $this->lang->line(' [Claim : ') . $claimReferenceNo . ']';
                } else if ($referenceTransactionTypeId == '3') {
                    $description = $this->lang->line('Journal entry for supplier return note claim transaction for Supplier Return Note number : ') . $referenceNo . $this->lang->line(' [Claim : ') . $claimReferenceNo . ']';
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
		$result = $this->receive_payment_model->checkExistingReceivePayment($reference_no);
		$receivePaymentId = $this->db->escape_str($this->input->post('id'));

		if ($receivePaymentId != '' && $result) {
			if ($receivePaymentId !=  $result[0]->receive_payment_id) {
				$exist = true;
			}
		} else {
			if ($result) {
				$exist = true;
			}
		}

		if ($exist) {
			$this->form_validation->set_message('check_existing', $this->lang->line('Receive Payment') . $this->lang->line('already added'));
			return false;
		} else {
			return true;
		}
	}

	public function getLastReceivePaymentNumber() {
		$refNo = $this->receive_payment_model->getMaxReceivePaymentNo();
		$lastReceivePayment = $this->receive_payment_model->getReceivePaymentByIdConsideringDeletedReceivePayment($refNo[0]->receive_payment_id);
		//echo "<pre>";print_r($lastReceivePayment);die;
		if ($lastReceivePayment && sizeof($lastReceivePayment) > 0) {
			return $lastReceivePayment[0]->reference_no;
		} else {
			return "Nill";
		}
	}

	public function isReceivePaymentNumberAutoIncrementEnabled() {
		return $this->system_configurations_model->isBookkeepingReceivePaymentNumberAutoIncrementEnabled();
	}

	public function getNextReferenceNo() {
		if ($this->isReceivePaymentNumberAutoIncrementEnabled()) {
			$lastReceivePaymentNo = $this->getLastReceivePaymentNumber();
			$receivePaymentReferenceNoCodeData = $this->system_configurations_model->getBookkeepingReceivePaymentReferenceNoCode();
			$receivePaymentReferenceNoCode = $receivePaymentReferenceNoCodeData[0]->config_filed_value;
			$receivePaymentReferenceNoSeparatorData = $this->system_configurations_model->getBookkeepingReceivePaymentReferenceNoSeparator();
			$receivePaymentReferenceNoSeparator = $receivePaymentReferenceNoSeparatorData[0]->config_filed_value;
			$receivePaymentReferenceNoStartNumberData = $this->system_configurations_model->getBookkeepingReceivePaymentReferenceNoStartNumber();
			$receivePaymentReferenceNoStartNumber = $receivePaymentReferenceNoStartNumberData[0]->config_filed_value;

			if ($lastReceivePaymentNo != 'Nill') {
				if ($receivePaymentReferenceNoSeparator != '') {
					$lastReceivePaymentNoElements = explode($receivePaymentReferenceNoSeparator, $lastReceivePaymentNo);
					$receivePaymentNo = $lastReceivePaymentNoElements[1];
					$result = $receivePaymentReferenceNoCode . $receivePaymentReferenceNoSeparator . ($receivePaymentNo + 1);
				} else {
					$receivePaymentReferenceNoCodeLength = strlen($receivePaymentReferenceNoCode);
					$receivePaymentNo = substr($lastReceivePaymentNo, $receivePaymentReferenceNoCodeLength);
					$result = $receivePaymentReferenceNoCode . $receivePaymentReferenceNoSeparator . ($receivePaymentNo + 1);
				}
			} else {
				$result = $receivePaymentReferenceNoCode . $receivePaymentReferenceNoSeparator . $receivePaymentReferenceNoStartNumber;
			}

			$status = "auto_increment";
		} else {
			$lastReceivePaymentNo = $this->getLastReceivePaymentNumber();
			$result = "<label class='control-label col-sm-3' id='last_reference_no_label' style='text-align:left; color: #2eb82e;'>"
					. "{$this->lang->line('Last Reference Number : ')}" . $lastReceivePaymentNo . "</label>";
			$status = "manual_increment";
		}

		echo json_encode(array('status' => $status, 'result' => $result));
	}

	public function getPrimeEntryBooksToUpdateForReceivePaymentCashTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getReceivePaymentCashAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function getPrimeEntryBooksToUpdateForReceivePaymentChequeTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getReceivePaymentChequeAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
    
    public function getPrimeEntryBooksToUpdateForReceivePaymentCreditCardTransaction() {
		$primeEntryBooks = $this->system_configurations_model->getReceivePaymentCreditCardAccountsPrimeEntryBooks();

		return $primeEntryBooks;
	}
	
	public function forceToSelectAReferenceTransactionForReceiveAPayment() {
		return $this->system_configurations_model->forceToSelectAReferenceTransactionForReceiveAPayment();
	}
    
    public function getReceiveAPaymentDefaultPayerType() {
		return $this->system_configurations_model->getReceiveAPaymentDefaultPayerType();
	}
    
    public function getReceiveAPaymentDefaultReferenceTransactionType() {
        return $this->system_configurations_model->getReceiveAPaymentDefaultReferenceTransactionType();
    }

    public function isSelectReferenceJournalEntryAutomaticallyEnabled() {
        return $this->system_configurations_model->isReceivePaymentSelectReferenceJournalEntryAutomaticallyEnabled();
    }
    
    public function isAllowPartialPaymentForReferenceTransactionsEnabled() {
        return $this->system_configurations_model->isReceivePaymentAllowPartialPaymentForReferenceTransactionsEnabled();
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
			
			//Sales Note
			case '2':

				$allSalesNotes = $this->sales_note_model->getAllSalesNoteIdsAndAllReferenceNumbers('reference_no', 'asc');
				$transactionTypeList = "   <select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allSalesNotes && sizeof($allSalesNotes) > 0) {
					foreach ($allSalesNotes as $salesNotes) {
						if ($selectedIndex == '') {
							$transactionTypeList .=          "<option value='" . $salesNotes->sales_note_id  . "' >" . $salesNotes->reference_no . "</option>";
						} else {
							if ($selectedIndex == $salesNotes->sales_note_id) {
								$transactionTypeList .=          "<option value='" . $salesNotes->sales_note_id  . "' selected>" . $salesNotes->reference_no . "</option>";
							} else {
								$transactionTypeList .=          "<option value='" . $salesNotes->sales_note_id  . "' >" . $salesNotes->reference_no . "</option>";
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
			
			//Sales Note
			case '2':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'sales note');
				} else {
					$salesNote = $this->sales_note_model->getSalesNoteById($transactionReferenceId);
					if ($salesNote && sizeof($salesNote) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($salesNote[0]->reference_no, 'sales note');
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
    
    public function handleIncludeBankChargeSelect() {
		$creditCardPaymentAmount = $this->db->escape_str($this->input->post('credit_card_payment_amount'));
		$selected = $this->db->escape_str($this->input->post('selected'));
		
		$bankChargePercentageForCreditAndDebitCardPayments = $this->system_configurations_model->getBankChargePercentageForCreditAndDebitCardPayments();
		
		if ($selected == "Yes") {
			$totalCreditCardPayment = (float)$creditCardPaymentAmount + ((float)$creditCardPaymentAmount/100) * (float)$bankChargePercentageForCreditAndDebitCardPayments;
		} else {
			$totalCreditCardPayment = $creditCardPaymentAmount;
		}
		
		echo number_format($totalCreditCardPayment, 2);
	}
    
    public function getReferenceTransactionTypesDropdown() {
		return $this->common_functions->getReferenceTransactionTypesToDropDown();
	}
    
    public function getPrimeEntryBooksToUpdateForReceivePaymentTransactionClaim() {
        $primeEntryBooks = $this->system_configurations_model->getReceivePaymentTransactionClaimPrimeEntryBooks();

		return $primeEntryBooks;
    }
}