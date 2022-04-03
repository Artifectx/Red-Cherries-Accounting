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

class Cheque_list_controller extends CI_Controller {

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
		$this->load->model('accountsManagerModule/adminSection/bank_model', '', TRUE);
        $this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/payments_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/make_payment_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
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
		$data_cls['li_class_cheque_list'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration
		
		if(isset($this->data['ACM_Bookkeeping_View_Cheques_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/chequeList/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}
	
	public function saveIncomeChequeStatusChange() {
        
		$chequeId = $this->db->escape_str($this->input->post('cheque_id'));
		$status = $this->db->escape_str($this->input->post('status'));
        
        $result = '';
        $canUpdateChequeStatus = false;
        
        $incomeCheque = $this->payments_model->getIncomeChequeById($chequeId);
        $referenceNo = $incomeCheque[0]->cheque_number;
        $locationId = $incomeCheque[0]->location_id;
        $amount = $incomeCheque[0]->amount;
        $referenceJournalEntryId = $incomeCheque[0]->cheque_reference_journal_entry_id;
        $chequeDepositPrimeEntryBookId = $incomeCheque[0]->cheque_deposit_prime_entry_book_id;
        $currentChequeStatus = $incomeCheque[0]->status;
        
        $automaticallyClearReceivedChequesAfterDepositedToBank = $this->system_configurations_model->isAutomaticallyClearReceivedChequesAfterDepositedToBankEnabled();
        
        if ($status == "In_Hand" && $currentChequeStatus == "Cleared") {
            $result = 'cleared_cheques_cannot_mark_as_in_hand';
        } else if ($status == "In_Hand") {
            $canUpdateChequeStatus = true;
        } else if ($status == "Deposited" && $automaticallyClearReceivedChequesAfterDepositedToBank) {
            
            $canUpdateChequeStatus = true;
            
            $chequeDepositJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($chequeDepositPrimeEntryBookId, $referenceNo);
                                
            if ($chequeDepositJournalEntries && sizeof($chequeDepositJournalEntries) > 0) {
                
                $status = "Cleared";
                
                foreach($chequeDepositJournalEntries as $chequeDepositJournalEntry) {
                    $journalEntryId = $chequeDepositJournalEntry->journal_entry_id;
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "No");

                    if ($glTransactions && sizeof($glTransactions) > 0) {
                        foreach($glTransactions as $glTransaction) {
                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                            $data = array(
                                'transaction_complete' => "Yes",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                        }
                    }
                    
                    //Mark transaction complete status for income cheque journal entries.
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '', "No");

                    if ($glTransactions && sizeof($glTransactions) > 0) {
                        foreach($glTransactions as $glTransaction) {
                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                            $data = array(
                                'transaction_complete' => "Yes",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editGeneralLedgerTransaction($referenceJournalEntryId, $chartOfAccountId, $data);
                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($referenceJournalEntryId, $chartOfAccountId, $data);
                        }
                    }
                }
            }
            
            $result = 'ok';
        } else if ($status == "Deposited") {
            $canUpdateChequeStatus = true;
            
            $chequeDepositJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($chequeDepositPrimeEntryBookId, $referenceNo);
                                
            if ($chequeDepositJournalEntries && sizeof($chequeDepositJournalEntries) > 0) {
                foreach($chequeDepositJournalEntries as $chequeDepositJournalEntry) {
                    $journalEntryId = $chequeDepositJournalEntry->journal_entry_id;
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "Yes");

                    if ($glTransactions && sizeof($glTransactions) > 0) {
                        foreach($glTransactions as $glTransaction) {
                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                            $data = array(
                                'transaction_complete' => "No",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                        }
                    }
                }
            }
            
            $result = 'ok';
        } else if ($status == "Cleared") {
            $today = date("Y-m-d");
            
            $chequeDepositJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($chequeDepositPrimeEntryBookId, $referenceNo);
                                
            if ($chequeDepositJournalEntries && sizeof($chequeDepositJournalEntries) > 0) {
                
                $canUpdateChequeStatus = true;
                
                foreach($chequeDepositJournalEntries as $chequeDepositJournalEntry) {
                    $journalEntryId = $chequeDepositJournalEntry->journal_entry_id;
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "No");

                    if ($glTransactions && sizeof($glTransactions) > 0) {
                        foreach($glTransactions as $glTransaction) {
                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                            $data = array(
                                'transaction_complete' => "Yes",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                        }
                    }
                    
                    //Mark transaction complete status for income cheque journal entries.
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '', "No");

                    if ($glTransactions && sizeof($glTransactions) > 0) {
                        foreach($glTransactions as $glTransaction) {
                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                            $data = array(
                                'transaction_complete' => "Yes",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editGeneralLedgerTransaction($referenceJournalEntryId, $chartOfAccountId, $data);
                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($referenceJournalEntryId, $chartOfAccountId, $data);
                        }
                    }
                }
            } else {
                $primeEntryBooksToUpdate = '';
                if ($chequeDepositPrimeEntryBookId != '0') {
                    $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($chequeDepositPrimeEntryBookId);
                
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

                        $canUpdateChequeStatus = true;

                        foreach ($primeEntryBooksToUpdate as $primeEntryBook) {
                            $primeEntryBookId = $primeEntryBook->prime_entry_book_id;

                            $data = array(
                                'prime_entry_book_id' => $primeEntryBookId,
                                'transaction_date' => $today,
                                'reference_no' => $referenceNo,
                                'should_have_a_payment_journal_entry' => "No",
                                'location_id' => $locationId,
                                'description' => $this->lang->line('Journal entry for cheque deposit for Cheque number : ') . $referenceNo,
                                'post_type' => "Indirect",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );

                            $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                            $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                            $amount = str_replace(',', '', $amount);

                            foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                $transactionStatus = "Yes";

                                if ($chartOfAccount->debit_or_credit == "debit") {
                                    $data = array(
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
                                    $data = array(
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

                                $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                //Same time add the data to previous years record table.
                                $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                            }
                            
                            //Mark transaction complete status for income cheque journal entries.
                            $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '', "No");

                            if ($glTransactions && sizeof($glTransactions) > 0) {
                                foreach($glTransactions as $glTransaction) {
                                    $chartOfAccountId = $glTransaction->chart_of_account_id;
                                    $data = array(
                                        'transaction_complete' => "Yes",
                                        'actioned_user_id' => $this->user_id,
                                        'action_date' => $this->date,
                                        'last_action_status' => 'edited'
                                    );

                                    $this->journal_entries_model->editGeneralLedgerTransaction($referenceJournalEntryId, $chartOfAccountId, $data);
                                    $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($referenceJournalEntryId, $chartOfAccountId, $data);
                                }
                            }
                        }
                    }
                } else {
                    $result = "cheque_deposit_bank_account_not_specified_for_the_income_cheque";
                }
            }
        } else if ($status == "Returned") {
            $canUpdateChequeStatus = true;
            
            $chequeDepositJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($chequeDepositPrimeEntryBookId, $referenceNo);
                                
            if ($chequeDepositJournalEntries && sizeof($chequeDepositJournalEntries) > 0) {
                foreach($chequeDepositJournalEntries as $chequeDepositJournalEntry) {
                    $journalEntryId = $chequeDepositJournalEntry->journal_entry_id;
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "Yes");

                    if ($glTransactions && sizeof($glTransactions) > 0) {
                        foreach($glTransactions as $glTransaction) {
                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                            $data = array(
                                'transaction_complete' => "No",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                        }
                    }
                    
                    //Mark transaction complete status for income cheque journal entries.
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '', "Yes");

                    if ($glTransactions && sizeof($glTransactions) > 0) {
                        foreach($glTransactions as $glTransaction) {
                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                            $data = array(
                                'transaction_complete' => "No",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'edited'
                            );

                            $this->journal_entries_model->editGeneralLedgerTransaction($referenceJournalEntryId, $chartOfAccountId, $data);
                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($referenceJournalEntryId, $chartOfAccountId, $data);
                        }
                    }
                }
            }
            
            $expenseCheque = $this->payments_model->getExpenseChequeByChequeNumber($referenceNo);
            
            if ($expenseCheque && sizeof($expenseCheque) > 0) {
                $expenseChequeId = $expenseCheque[0]->cheque_id;
                
                $expenseChequeData = array(
                    'status' => $status,
                    'actioned_user_id' => $this->user_id,
                    'action_date' => $this->date,
                    'last_action_status' => 'edited'
                );

                $this->payments_model->editExpenseCheque($expenseChequeId, $expenseChequeData);
                
                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $expenseCheque[0]->cheque_payment_prime_entry_book_id;

                $makePaymentInSecondOrThirdPartyJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($makePaymentInSecondOrThirdPartyPrimeEntryBookId, $referenceNo);

                if ($makePaymentInSecondOrThirdPartyJournalEntries && sizeof($makePaymentInSecondOrThirdPartyJournalEntries) > 0) {
                    foreach($makePaymentInSecondOrThirdPartyJournalEntries as $makePaymentInSecondOrThirdPartyJournalEntry) {
                        $journalEntryId = $makePaymentInSecondOrThirdPartyJournalEntry->journal_entry_id;

                        $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "Yes");

                        if ($glTransactions && sizeof($glTransactions) > 0) {
                            foreach($glTransactions as $glTransaction) {
                                $chartOfAccountId = $glTransaction->chart_of_account_id;
                                $data = array(
                                    'transaction_complete' => "No",
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                            }
                        }
                    }
                }
            }
            
            $result = 'ok';
        } else if ($status == "Paid") {
            
            $expenseCheque = $this->payments_model->getExpenseChequeByChequeNumber($referenceNo);
            
            if ($expenseCheque && sizeof($expenseCheque) > 0) {
                $canUpdateChequeStatus = true;
                $expenseChequeId = $expenseCheque[0]->cheque_id;
                
                $expenseChequeData = array(
                    'status' => "Open",
                    'actioned_user_id' => $this->user_id,
                    'action_date' => $this->date,
                    'last_action_status' => 'edited'
                );

                $this->payments_model->editExpenseCheque($expenseChequeId, $expenseChequeData);
                
                $result = 'ok';
            } else {
                $result = "no_reference_expense_cheque_for_this_income_cheque";
            }
        }
		
        if ($canUpdateChequeStatus) {
            $incomeChequeData = array(
                'status' => $status,
                'actioned_user_id' => $this->user_id,
                'action_date' => $this->date,
                'last_action_status' => 'edited'
            );

            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
        }
        
		echo $result;
	}
	
	public function saveExpenseChequeStatusChange() {
        
		$chequeId = $this->db->escape_str($this->input->post('cheque_id'));
		$status = $this->db->escape_str($this->input->post('status'));
		
		$expenseChequeData = array(
			'status' => $status,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);
		
		$this->payments_model->editExpenseCheque($chequeId, $expenseChequeData);
        
        $expenseCheque = $this->payments_model->getExpenseChequeById($chequeId);
        $chequeNumber = $expenseCheque[0]->cheque_number;
        $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $expenseCheque[0]->cheque_payment_prime_entry_book_id;
		
        $makePaymentInSecondOrThirdPartyJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($makePaymentInSecondOrThirdPartyPrimeEntryBookId, $chequeNumber);
                                
        if ($makePaymentInSecondOrThirdPartyJournalEntries && sizeof($makePaymentInSecondOrThirdPartyJournalEntries) > 0) {
            foreach($makePaymentInSecondOrThirdPartyJournalEntries as $makePaymentInSecondOrThirdPartyJournalEntry) {
                $journalEntryId = $makePaymentInSecondOrThirdPartyJournalEntry->journal_entry_id;
                
                $transactionStatus = "No";
                if ($status == "Cleared") {
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "No");
                    $transactionStatus = "Yes";
                } else if ($status == "Open" || $status == "Returned") {
                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "Yes");
                }

                if ($glTransactions && sizeof($glTransactions) > 0) {
                    foreach($glTransactions as $glTransaction) {
                        $chartOfAccountId = $glTransaction->chart_of_account_id;
                        $data = array(
                            'transaction_complete' => $transactionStatus,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                        $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                    }
                }
            }
            
            if ($status == "Returned") {
                //Mark coresponding income cheque (if available) is also returned
                $incomeCheque = $this->payments_model->getIncomeChequeByChequeNumber($chequeNumber);
                $chequeId = $incomeCheque[0]->cheque_id;
                
                if ($incomeCheque && sizeof($incomeCheque) > 0) {
                    $incomeChequeData = array(
                        'status' => $status,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'edited'
                    );

                    $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                }
            } else {
                //Mark coresponding income cheque (if available) is paid
                $incomeCheque = $this->payments_model->getIncomeChequeByChequeNumber($chequeNumber);
                $chequeId = $incomeCheque[0]->cheque_id;
                
                if ($incomeCheque && sizeof($incomeCheque) > 0) {
                    $incomeChequeData = array(
                        'status' => "Paid",
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'edited'
                    );

                    $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                }
            }
        }
		
		echo 'ok';
	}
    
    public function addChequeDepositPrimeEntryBookIdForTheCheque() {
        $chequeId = $this->db->escape_str($this->input->post('cheque_id'));
		$chequeDepositPrimeEntryBookId = $this->db->escape_str($this->input->post('cheque_deposit_prime_entry_book_id'));
        
        $incomeChequeData = array(
            'cheque_deposit_prime_entry_book_id' => $chequeDepositPrimeEntryBookId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );
        
        $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
        
        echo 'ok';
    }

    //get all data
	public function getTableData() {
        
		if(isset($this->data['ACM_Bookkeeping_View_Cheques_Permissions'])) {
			
			$hideMonthFilter = false;
            
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			$peopleId = $this->db->escape_str($this->input->post('stakeholder_id'));
			$locationId = $this->db->escape_str($this->input->post('location_id'));
			$chequeType = $this->db->escape_str($this->input->post('cheque_type'));
			$thirdPartyCheque = $this->db->escape_str($this->input->post('third_party_cheque'));
			
			$today = date("Y-m-d");
			$tomorrow = date("Y-m-d", strtotime("+1 day"));
			$dayAfterTomorrow = date("Y-m-d", strtotime("+2 days"));
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
							<table class='table table-striped table-bordered chequeListDataTable' style='margin-bottom:0;'>
								<thead>
									<tr>
										<th>{$this->lang->line('Cheque Number')}</th>
										<th width='15%'>{$this->lang->line('Transaction Type')}</th>
										<th>{$this->lang->line('Reference No')}</th>
										<th>{$this->lang->line('Bank')}</th>
										<th>{$this->lang->line('Stakeholder')}</th>
										<th>{$this->lang->line('Location')}</th>
										<th>{$this->lang->line('Cheque Date')}</th>
										<th>{$this->lang->line('Amount')}</th>
										<th>{$this->lang->line('Status')}</th>
									</tr>
								</thead>
								<tbody>";
			
			$chequeList = '';
			if ($chequeType == "external_cheques") {
				$chequeList = $this->payments_model->getAllExternalChequesForPeriod($fromDate, $toDate, $peopleId, $locationId, $thirdPartyCheque, 'date', 'desc');
			} else if ($chequeType == "internal_cheques") {
				$chequeList = $this->payments_model->getAllInternalChequesForPeriod($fromDate, $toDate, $peopleId, $locationId, 'cheque_date', 'desc');		
			}

			if ($chequeList != null) {
				foreach ($chequeList as $row) {
					
					$chequeId = $row->cheque_id;
                    $referenceNo = $row->cheque_number;
                    $locationId = $row->location_id;
                    $amount = $row->amount;
                    
					if ($chequeType == "external_cheques") {
						$peopleId = $row->payer_id;
                        $referenceJournalEntryId = $row->cheque_reference_journal_entry_id;
                        $chequeDepositPrimeEntryBookId = $row->cheque_deposit_prime_entry_book_id;
					} else if ($chequeType == "internal_cheques") {
						$peopleId = $row->payee_id;
					}
					
					$people = $this->peoples_model->getById($peopleId);
					
					$peopleName = '';
					if ($people && sizeof($people) > 0) {
						$peopleName = $people[0]->people_name;
					}
                    
                    $bank = $this->bank_model->getById($row->bank);
                    
                    $bankName = '';
					if ($bank && sizeof($bank) > 0) {
						$bankName = $bank[0]->bank_name;
					}
					
					$location = $this->locations_model->getById($row->location_id);
					
					$locationName = '';
					if ($location && sizeof($location) > 0) {
						$locationName = $location[0]->location_name;
					}
					
					$chequeStatus = $row->status;
					
					$backgroundColorClass = 'default_color';
					if ($chequeStatus == "In_Hand") {
                        
                        $justNowChequeDeposited = false;
                        
                        if ($row->cheque_date <= $today) {
                            
                            $automaticallyMarkReceivedChequesAsDepositedOnChequeDate = $this->system_configurations_model->isAutomaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled();
        
                            if ($automaticallyMarkReceivedChequesAsDepositedOnChequeDate) {
                            
                                $justNowChequeDeposited = true;
                                $backgroundColorClass = "yellow_color";
                                $chequeStatus = "Deposited";

                                $incomeChequeData = array(
                                    'status' => $chequeStatus,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                                
                                $primeEntryBooksToUpdate = '';
                                if ($chequeDepositPrimeEntryBookId != '0') {
                                    $primeEntryBooksToUpdate = $this->prime_entry_book_model->getPrimeEntryBookById($chequeDepositPrimeEntryBookId);
                                }
                                
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
                                        
                                        $data = array(
                                            'prime_entry_book_id' => $primeEntryBookId,
                                            'transaction_date' => $today,
                                            'reference_no' => $referenceNo,
                                            'should_have_a_payment_journal_entry' => "No",
                                            'location_id' => $locationId,
                                            'description' => $this->lang->line('Journal entry for cheque deposit for Cheque number : ') . $referenceNo,
                                            'post_type' => "Indirect",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'added'
                                        );

                                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                                        $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookId);
                                        $amount = str_replace(',', '', $amount);

                                        foreach($primeEntryBookChartOfAccounts as $chartOfAccount) {

                                            $transactionStatus = "No";
                                            
                                            if ($chartOfAccount->debit_or_credit == "debit") {
                                                $data = array(
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
                                                $data = array(
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

                                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                                            //Same time add the data to previous years record table.
                                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                                        }
                                        
                                        $automaticallyClearReceivedChequesAfterDepositedToBank = $this->system_configurations_model->isAutomaticallyClearReceivedChequesAfterDepositedToBankEnabled();
        
                                        if ($automaticallyClearReceivedChequesAfterDepositedToBank && $chequeDepositPrimeEntryBookId != '0') {

                                            $backgroundColorClass = "blue_color";
                                            $chequeStatus = "Cleared";

                                            $incomeChequeData = array(
                                                'status' => $chequeStatus,
                                                'actioned_user_id' => $this->user_id,
                                                'action_date' => $this->date,
                                                'last_action_status' => 'edited'
                                            );

                                            $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);

                                            $chequeDepositJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($chequeDepositPrimeEntryBookId, $referenceNo);

                                            if ($chequeDepositJournalEntries && sizeof($chequeDepositJournalEntries) > 0) {
                                                foreach($chequeDepositJournalEntries as $chequeDepositJournalEntry) {
                                                    $journalEntryId = $chequeDepositJournalEntry->journal_entry_id;
                                                    $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "No");

                                                    if ($glTransactions && sizeof($glTransactions) > 0) {
                                                        foreach($glTransactions as $glTransaction) {
                                                            $chartOfAccountId = $glTransaction->chart_of_account_id;
                                                            $data = array(
                                                                'transaction_complete' => "Yes",
                                                                'actioned_user_id' => $this->user_id,
                                                                'action_date' => $this->date,
                                                                'last_action_status' => 'edited'
                                                            );

                                                            $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                                                            $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                                                        }
                                                    }
                                                }
                                            }

                                            //Mark transaction complete status for income cheque journal entries.
                                            $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '', "No");

                                            if ($glTransactions && sizeof($glTransactions) > 0) {
                                                foreach($glTransactions as $glTransaction) {
                                                    $chartOfAccountId = $glTransaction->chart_of_account_id;
                                                    $data = array(
                                                        'transaction_complete' => "Yes",
                                                        'actioned_user_id' => $this->user_id,
                                                        'action_date' => $this->date,
                                                        'last_action_status' => 'edited'
                                                    );

                                                    $this->journal_entries_model->editGeneralLedgerTransaction($referenceJournalEntryId, $chartOfAccountId, $data);
                                                    $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($referenceJournalEntryId, $chartOfAccountId, $data);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
						}
                        
                        if (!$justNowChequeDeposited) {
                            if ($row->cheque_date == $today) {
                                $backgroundColorClass = "dark_pink_color";
                            } else if ($row->cheque_date == $tomorrow) {
                                $backgroundColorClass = "normal_pink_color";
                            } else if ($row->cheque_date == $dayAfterTomorrow) {
                                $backgroundColorClass = "light_pink_color";
                            } else if ($row->cheque_date < $today) {
                                $backgroundColorClass = "brown_color";
                            }
                        }
					} else if ($chequeStatus == "Deposited") {
						if ($row->cheque_date <= $today) {
                            
                            $automaticallyClearReceivedChequesAfterDepositedToBank = $this->system_configurations_model->isAutomaticallyClearReceivedChequesAfterDepositedToBankEnabled();
        
                            if ($automaticallyClearReceivedChequesAfterDepositedToBank && $chequeDepositPrimeEntryBookId != '0') {
                            
                                $backgroundColorClass = "blue_color";
                                $chequeStatus = "Cleared";

                                $incomeChequeData = array(
                                    'status' => $chequeStatus,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->payments_model->editIncomeCheque($chequeId, $incomeChequeData);
                                
                                $chequeDepositJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($chequeDepositPrimeEntryBookId, $referenceNo);
                                
                                if ($chequeDepositJournalEntries && sizeof($chequeDepositJournalEntries) > 0) {
                                    foreach($chequeDepositJournalEntries as $chequeDepositJournalEntry) {
                                        $journalEntryId = $chequeDepositJournalEntry->journal_entry_id;
                                        $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "No");
                                        
                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            foreach($glTransactions as $glTransaction) {
                                                $chartOfAccountId = $glTransaction->chart_of_account_id;
                                                $data = array(
                                                    'transaction_complete' => "Yes",
                                                    'actioned_user_id' => $this->user_id,
                                                    'action_date' => $this->date,
                                                    'last_action_status' => 'edited'
                                                );
                                                
                                                $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                                            }
                                        }
                                    }
                                }
                                
                                //Mark transaction complete status for income cheque journal entries.
                                $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($referenceJournalEntryId, '', "No");
                                        
                                if ($glTransactions && sizeof($glTransactions) > 0) {
                                    foreach($glTransactions as $glTransaction) {
                                        $chartOfAccountId = $glTransaction->chart_of_account_id;
                                        $data = array(
                                            'transaction_complete' => "Yes",
                                            'actioned_user_id' => $this->user_id,
                                            'action_date' => $this->date,
                                            'last_action_status' => 'edited'
                                        );

                                        $this->journal_entries_model->editGeneralLedgerTransaction($referenceJournalEntryId, $chartOfAccountId, $data);
                                        $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($referenceJournalEntryId, $chartOfAccountId, $data);
                                    }
                                }
                            } else {
                                $backgroundColorClass = "yellow_color";
                            }
						} else {
							$backgroundColorClass = "yellow_color";
						}
					} else if ($chequeStatus == "Cleared") {
						$backgroundColorClass = "blue_color";
					} else if ($chequeStatus == "Returned") {
						$backgroundColorClass = "red_color";
					} else if ($chequeStatus == "Open") {
                        if ($row->cheque_date <= $today) {
                            
                            $automaticallyClearPaidChequesOnChequeDate = $this->system_configurations_model->isAutomaticallyClearPaidChequesOnChequeDateEnabled();
        
                            if ($automaticallyClearPaidChequesOnChequeDate) {
                            
                                $backgroundColorClass = "blue_color";
                                $chequeStatus = "Cleared";
                                
                                $expenseCheque = $this->payments_model->getExpenseChequeById($chequeId);
                                $chequeNumber = $expenseCheque[0]->cheque_number;
                                $makePaymentInSecondOrThirdPartyPrimeEntryBookId = $expenseCheque[0]->cheque_payment_prime_entry_book_id;

                                $externalChequeData = array(
                                    'status' => $chequeStatus,
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'edited'
                                );

                                $this->payments_model->editExpenseCheque($chequeId, $externalChequeData);
                                
                                $makePaymentInSecondOrThirdPartyJournalEntries = $this->journal_entries_model->getJournalEntryByPrimeEntryBookIdAndReferenceNo($makePaymentInSecondOrThirdPartyPrimeEntryBookId, $chequeNumber);

                                if ($makePaymentInSecondOrThirdPartyJournalEntries && sizeof($makePaymentInSecondOrThirdPartyJournalEntries) > 0) {
                                    foreach($makePaymentInSecondOrThirdPartyJournalEntries as $makePaymentInSecondOrThirdPartyJournalEntry) {
                                        $journalEntryId = $makePaymentInSecondOrThirdPartyJournalEntry->journal_entry_id;

                                        $glTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId, '', "No");
                                        
                                        if ($glTransactions && sizeof($glTransactions) > 0) {
                                            foreach($glTransactions as $glTransaction) {
                                                $chartOfAccountId = $glTransaction->chart_of_account_id;
                                                $data = array(
                                                    'transaction_complete' => "Yes",
                                                    'actioned_user_id' => $this->user_id,
                                                    'action_date' => $this->date,
                                                    'last_action_status' => 'edited'
                                                );

                                                $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data);
                                                $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else if ($chequeStatus == "Paid") {
						$backgroundColorClass = "orange_color";
					}
					
					$transactionReferenceLink = "";
					switch ($row->transaction_type) {
						case "Sales Invoice" :
							$transactionReferenceLink = "<a href='../../stockManagerModule/salesSection/sales_invoice_controller/?searchId=" . $row->reference_no . "' target='_blank'>" . $row->reference_no . "</a>";
							break;

						default:
							$transactionReferenceLink = $row->reference_no;
							break;
					}
					
					$html .= "<tr>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $row->cheque_number . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $row->transaction_type . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $transactionReferenceLink . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $bankName . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $peopleName . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $locationName . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $row->cheque_date . "</td>";
					$html .= "<td  class='" . $backgroundColorClass . "'>" . number_format($row->amount, 2) . "</td>";
					
					if ($chequeType == "external_cheques") {
						$chequeStatusList = $this->getChequeStatusListForIncomeCheques();
                        $chequeStatusDropDown = "<select class='select2 form-control' id='cheque_status_" . $row->cheque_id . "' onchange='saveIncomeChequeStatusChange(this.id, {$chequeDepositPrimeEntryBookId});'>";
					} else if ($chequeType == "internal_cheques") {
						$chequeStatusList = $this->getChequeStatusListForExpenseCheques();
						$chequeStatusDropDown = "<select class='select2 form-control' id='cheque_status_" . $row->cheque_id . "' onchange='saveExpenseChequeStatusChange(this.id);'>";
					}
					
					foreach($chequeStatusList as $key => $chequeStatusOption){
						if ($chequeStatus == $key) {
$chequeStatusDropDown .=   "	<option value='" . $key . "' selected>" . $chequeStatusOption . "</option>";			
						} else {
$chequeStatusDropDown .=  	"	<option value='" . $key . "'>" . $chequeStatusOption . "</option>";
						}
					}
					
					$chequeStatusDropDown .= "</select>";
											
					$html .= "<td  class='" . $backgroundColorClass . "'>" . $chequeStatusDropDown . "</td>";
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
	
	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
	
	public function getChequeStatusListForIncomeCheques() {
		return array("In_Hand" => "In Hand", "Deposited" => "Deposited", "Cleared" => "Cleared", "Returned" => "Returned", "Paid" => "Paid");
	}
	
	public function getChequeStatusListForExpenseCheques() {
		return array("Open" => "Open", "Cleared" => "Cleared", "Returned" => "Returned");
	}
	
	public function getSecondPartyChequesInHandToDropdown() {
		$secondPartyCheques = $this->payments_model->getSecondPartyChequesInHand('');
				
		$secondPartyChequeList = "   <select class='select2 form-control' id='second_party_cheque_id' onchange='handleSecondPartyChequeSelect(this.id);'>
								<option value='0' >{$this->lang->line('-- Select --')}</option>";

		if ($secondPartyCheques && sizeof($secondPartyCheques) > 0) {
			foreach ($secondPartyCheques as $secondPartyCheque) {
				$secondPartyChequeList .=          "<option value='" . $secondPartyCheque->cheque_id  . "' >" . $secondPartyCheque->cheque_number . "</option>";
			}
		}

		$secondPartyChequeList .="   </select>";
		
		echo $secondPartyChequeList;
	}
	
	public function getThirdPartyChequesInHandToDropdown() {
		$thirdPartyCheques = $this->payments_model->getThirdPartyChequesInHand('');
				
		$thirdPartyChequeList = "   <select class='select2 form-control' id='third_party_cheque_id' onchange='handleThirdPartyChequeSelect(this.id);'>
								<option value='0' >{$this->lang->line('-- Select --')}</option>";

		if ($thirdPartyCheques && sizeof($thirdPartyCheques) > 0) {
			foreach ($thirdPartyCheques as $thirdPartyCheque) {
				$thirdPartyChequeList .=          "<option value='" . $thirdPartyCheque->cheque_id  . "' >" . $thirdPartyCheque->cheque_number . "</option>";
			}
		}

		$thirdPartyChequeList .="   </select>";
		
		echo $thirdPartyChequeList;
	}
	
	public function getSecondPartyChequeData() {
		$chequeId = $this->db->escape_str($this->input->post('cheque_id'));
		
		$secondPartyChequeBankId = '';
		$secondPartyChequeBankName = '';
		$secondPartyChequeDate = '';
		$secondPartyChequePaymentAmount = '';
		
		$secondPartyCheque = $this->payments_model->getIncomeChequeById($chequeId);
		
		if ($secondPartyCheque && sizeof($secondPartyCheque) > 0) {
			$secondPartyChequeBankId = $secondPartyCheque[0]->bank;
			$secondPartyChequeDate = $secondPartyCheque[0]->cheque_date;
			$secondPartyChequePaymentAmount = str_replace(",", "", number_format($secondPartyCheque[0]->amount, 2));
			
			$bank = $this->bank_model->getById($secondPartyChequeBankId);
			if ($bank && sizeof($bank) > 0) {
				$secondPartyChequeBankName = $bank[0]->bank_name;
			}
		}
		
		echo json_encode(array('secondPartyChequeBankId' => $secondPartyChequeBankId, 'secondPartyChequeBankName' => $secondPartyChequeBankName, 'secondPartyChequeDate' => $secondPartyChequeDate, 'secondPartyChequePaymentAmount' => $secondPartyChequePaymentAmount));
	}
	
	public function getThirdPartyChequeData() {
		$chequeId = $this->db->escape_str($this->input->post('cheque_id'));
		
		$thirdPartyChequeBankId = '';
		$thirdPartyChequeBankName = '';
		$thirdPartyChequeDate = '';
		$thirdPartyChequePaymentAmount = '';
		
		$thirdPartyCheque = $this->payments_model->getIncomeChequeById($chequeId);
		
		if ($thirdPartyCheque && sizeof($thirdPartyCheque) > 0) {
			$thirdPartyChequeBankId = $thirdPartyCheque[0]->bank;
			$thirdPartyChequeDate = $thirdPartyCheque[0]->cheque_date;
			$thirdPartyChequePaymentAmount = str_replace(",", "", number_format($thirdPartyCheque[0]->amount, 2));
			
			$bank = $this->bank_model->getById($thirdPartyChequeBankId);
			if ($bank && sizeof($bank) > 0) {
				$thirdPartyChequeBankName = $bank[0]->bank_name;
			}
		}
		
		echo json_encode(array('thirdPartyChequeBankId' => $thirdPartyChequeBankId, 'thirdPartyChequeBankName' => $thirdPartyChequeBankName, 'thirdPartyChequeDate' => $thirdPartyChequeDate, 'thirdPartyChequePaymentAmount' => $thirdPartyChequePaymentAmount));
	}
}