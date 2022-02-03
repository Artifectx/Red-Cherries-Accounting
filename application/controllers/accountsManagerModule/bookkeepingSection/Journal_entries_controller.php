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

class Journal_entries_controller extends CI_Controller {
    
	public function  __construct() {

		parent::__construct();
		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//current date time
		$this->date = date("Y-m-d H:i");

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
        $this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
        $this->load->model('accountsManagerModule/adminSection/financial_year_ends_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/purchase_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/sales_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/supplier_return_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/customer_return_note_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		
		$this->load->library('common_library/common_functions');

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
		$data_cls['li_class_journal_entry'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$this->data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

		$this->data['systemConfigData'] = $this->getSystemConfigData();
		
		$this->data['peopleType'] = $this->getPeopleType();

		if(isset($this->data['ACM_Bookkeeping_View_Journal_Entry_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/journalEntries/index', $this->data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}

		return $configData;
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
		if(isset($this->data['ACM_Bookkeeping_Add_Journal_Entry_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');

				echo $result;
			} else {
                
                $journalEntryId = '';
                
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
                
                    $journalEntryId = $this->db->escape_str($this->input->post('journal_entry_id'));
                    $primeEntryBookId = $this->db->escape_str($this->input->post('prime_entry_book_id'));
                    $transactionDate = $this->db->escape_str($this->input->post('transaction_date'));
                    $payeePayerType = $this->db->escape_str($this->input->post('payee_payer_type'));
                    $payeePayerId = $this->db->escape_str($this->input->post('payee_payer_id'));
                    $dueDate = $this->db->escape_str($this->input->post('due_date'));
                    $referenceNo = $this->db->escape_str($this->input->post('reference_no'));
                    $saveOption = $this->db->escape_str($this->input->post('save_option'));
                    $primeEntrybookName = $this->db->escape_str($this->input->post('prime_entry_book_name'));
                    $referenceTransactionTypeId = $this->db->escape_str($this->input->post('reference_transaction_type_id'));
                    $referenceTransactionId = $this->db->escape_str($this->input->post('reference_transaction_id'));
                    $referenceJournalEntryId = $this->db->escape_str($this->input->post('reference_journal_entry_id'));

                    $description = $this->db->escape_str($this->input->post('description'));

                    if ($description == '' && $primeEntryBookId != '0' && $primeEntryBookId != '') {
                        $primaryEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($primeEntryBookId);
                        $description = "Journal entry for " . strtolower($primaryEntryBook[0]->prime_entry_book_name);
                    }

                    if ($saveOption == "save_with_chart_of_account_values") {

                        if ($journalEntryId == '') {
                            
                            $shouldHaveAPaymentJournalEntry = "Yes";
                            
                            if ($referenceJournalEntryId != '' && $referenceJournalEntryId != '0') {
                                
                                $shouldHaveAPaymentJournalEntry = "No";
                                
                                if ($payeePayerId == '' || $payeePayerId == '0') {
                                    $referenceJournalEntry = $this->journal_entries_model->getJournalEntryById($referenceJournalEntryId);
                                    
                                    if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
                                        $payeePayerType = $referenceJournalEntry[0]->payee_payer_type;
                                        $payeePayerId = $referenceJournalEntry[0]->payee_payer_id;
                                        
                                        if ($payeePayerType == '') {
                                            $people = $this->peoples_model->getById($payeePayerId);
                                            $payeePayerType = $people[0]->people_type;
                                        }
                                    }
                                }
                            }
                            
                            $data = array(
                                'prime_entry_book_id' => $primeEntryBookId,
                                'transaction_date' => $transactionDate,
                                'payee_payer_type' => $payeePayerType,
                                'payee_payer_id' => $payeePayerId,
                                'due_date' => $dueDate,
                                'reference_no' => $referenceNo,
                                'should_have_a_payment_journal_entry' => $shouldHaveAPaymentJournalEntry,
                                'reference_transaction_type_id' => $referenceTransactionTypeId,
                                'reference_transaction_id' => $referenceTransactionId,
                                'reference_journal_entry_id' => $referenceJournalEntryId,
                                'location_id' => $this->db->escape_str($this->input->post('location_id')),
                                'description' => $description,
                                'post_type' => "Direct",
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );

                            $journalEntryId = $this->journal_entries_model->addJournalEntry($data);
                        }

                        $debitChartOfAccountIds = explode(",", $this->db->escape_str($this->input->post('debit_chart_of_account_id')));
                        $creditChartOfAccountIds = explode(",", $this->db->escape_str($this->input->post('credit_chart_of_account_id')));

                        $debitChartOfAccountValues = explode(",", $this->db->escape_str($this->input->post('debit_chart_of_account_value')));
                        $creditChartOfAccountValues = explode(",", $this->db->escape_str($this->input->post('credit_chart_of_account_value')));

                        $debitChartOfAccountValueCount = sizeof($debitChartOfAccountValues);

                        for ($i = 0; $i < $debitChartOfAccountValueCount; $i++) {
                            $data = array(
                                'journal_entry_id' => $journalEntryId,
                                'prime_entry_book_id' => $primeEntryBookId,
                                'transaction_date' => $transactionDate,
                                'chart_of_account_id' => $debitChartOfAccountIds[$i],
                                'debit_value' => $debitChartOfAccountValues[$i],
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );

                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                            //Same time add the data to previous years record table.
                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                        }

                        $creditChartOfAccountValueCount = sizeof($creditChartOfAccountValues);

                        for ($i = 0; $i < $creditChartOfAccountValueCount; $i++) {
                            $data = array(
                                'journal_entry_id' => $journalEntryId,
                                'prime_entry_book_id' => $primeEntryBookId,
                                'transaction_date' => $transactionDate,
                                'chart_of_account_id' => $creditChartOfAccountIds[$i],
                                'credit_value' => $creditChartOfAccountValues[$i],
                                'actioned_user_id' => $this->user_id,
                                'action_date' => $this->date,
                                'last_action_status' => 'added'
                            );

                            $this->journal_entries_model->addGeneralLedgerTransaction($data);

                            //Same time add the data to previous years record table.
                            $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                        }
                    } else if ($saveOption == "save_without_chart_of_account_values") {

                        if ($payeePayerId != '0') {
                            $shouldHaveAPaymentJournalEntry = "Yes";
                        } else {
                            $shouldHaveAPaymentJournalEntry = "No";
                        }

                        $data = array(
                            'transaction_date' => $transactionDate,
                            'payee_payer_type' => $payeePayerType,
                            'payee_payer_id' => $payeePayerId,
                            'due_date' => $dueDate,
                            'reference_no' => $referenceNo,
                            'should_have_a_payment_journal_entry' => $shouldHaveAPaymentJournalEntry,
                            'location_id' => $this->db->escape_str($this->input->post('location_id')),
                            'description' => $this->db->escape_str($this->input->post('description')),
                            'post_type' => "Direct",
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);
                    }

                    if ($primeEntrybookName != '') {

                        $data = array(
                            'prime_entry_book_name' => $primeEntrybookName,
                            'description' => $this->db->escape_str($this->input->post('description')),
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $primeEntryBookId = $this->prime_entry_book_model->addPrimeEntryBook($data);

                        $debitChartOfAccounts = explode(",", $this->db->escape_str($this->input->post('debit_chart_of_account_id')));
                        $creditChartOfAccounts = explode(",", $this->db->escape_str($this->input->post('credit_chart_of_account_id')));

                        $debitChartOfAccountsCount = sizeof($debitChartOfAccounts);

                        for ($i = 0; $i < $debitChartOfAccountsCount; $i++) {
                            if ($debitChartOfAccounts[$i] != '0') {
                                $data = array(
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'chart_of_account_id' => $debitChartOfAccounts[$i],
                                    'debit_or_credit' => 'debit',
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );

                                $this->prime_entry_book_model->addPrimeEntryBookChartOfAccount($data);
                            }
                        }

                        $creditChartOfAccountsCount = sizeof($creditChartOfAccounts);

                        for ($i = 0; $i < $creditChartOfAccountsCount; $i++) {
                            if ($creditChartOfAccounts[$i] != '0') {
                                $data = array(
                                    'prime_entry_book_id' => $primeEntryBookId,
                                    'chart_of_account_id' => $creditChartOfAccounts[$i],
                                    'debit_or_credit' => 'credit',
                                    'actioned_user_id' => $this->user_id,
                                    'action_date' => $this->date,
                                    'last_action_status' => 'added'
                                );

                                $this->prime_entry_book_model->addPrimeEntryBookChartOfAccount($data);
                            }
                        }

                        $journalEntryData = array(
                            'prime_entry_book_id' => $primeEntryBookId,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);
                    }
                    
                    $result = "ok";
                } else {
                    $result = "previous_financial_year_not_closed";
                }

				echo json_encode(array('result' => $result, 'journalEntryId' => $journalEntryId));
			}
		}
	}

	public function edit() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Journal_Entry_Permissions'])) {
			if ($this->form_validation->run() == FALSE) {
				$result =  validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
					'</div>');

				echo $result;
			} else {
				$journalEntryId = $this->db->escape_str($this->input->post('journal_entry_id'));
                
                $journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
                $journalEntryTransactionDate = $journalEntry[0]->transaction_date;
                
                $financialYear = $this->financial_year_ends_model->getFinancialYearOfSelectedTransaction($journalEntryTransactionDate);
                
                if ($financialYear[0]->year_end_process_status != "Closed") {
                
                    $primeEntryBookId = $this->db->escape_str($this->input->post('prime_entry_book_id'));
                    $payeePayerType = $this->db->escape_str($this->input->post('payee_payer_type'));
                    $payeePayerId = $this->db->escape_str($this->input->post('payee_payer_id'));
                    $transactionDate = $this->db->escape_str($this->input->post('transaction_date'));
                    $dueDate = $this->db->escape_str($this->input->post('due_date'));
                    $referenceNo = $this->db->escape_str($this->input->post('reference_no'));
                    $referenceTransactionTypeId = $this->db->escape_str($this->input->post('reference_transaction_type_id'));
                    $referenceTransactionId = $this->db->escape_str($this->input->post('reference_transaction_id'));
                    $referenceJournalEntryId = $this->db->escape_str($this->input->post('reference_journal_entry_id'));
                    $description = trim($this->db->escape_str($this->input->post('description')));
                    $description = preg_replace('~\\\n~',"\r\n", $description);

                    //Save journal entry and general ledger transactions to history
                    $this->journal_entries_model->addJournalEntryToHistory($journalEntry[0]);

                    $generalLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);

                    foreach ($generalLedgerTransactions as $generalLedgerTransaction) {
                        $this->journal_entries_model->addGeneralLedgerTransactionToHistory($generalLedgerTransaction);
                    }

                    //Update new journal entry and general ledger transactions
                    $journalEntryData = array(
                        'transaction_date' => $transactionDate,
                        'payee_payer_type' => $payeePayerType,
                        'payee_payer_id' => $payeePayerId,
                        'due_date' => $dueDate,
                        'reference_no' => $referenceNo,
                        'reference_transaction_type_id' => $referenceTransactionTypeId,
                        'reference_transaction_id' => $referenceTransactionId,
                        'reference_journal_entry_id' => $referenceJournalEntryId,
                        'location_id' => $this->db->escape_str($this->input->post('location_id')),
                        'description' => $description,
                        'actioned_user_id' => $this->user_id,
                        'action_date' => $this->date,
                        'last_action_status' => 'edited'
                    );

                    $this->journal_entries_model->editJournalEntry($journalEntryId, $journalEntryData);

                    $debitChartOfAccountIds = explode(",", $this->db->escape_str($this->input->post('debit_chart_of_account_id')));
                    $creditChartOfAccountIds = explode(",", $this->db->escape_str($this->input->post('credit_chart_of_account_id')));

                    $debitChartOfAccountValues = explode(",", $this->db->escape_str($this->input->post('debit_chart_of_account_value')));
                    $creditChartOfAccountValues = explode(",", $this->db->escape_str($this->input->post('credit_chart_of_account_value')));

                    $debitChartOfAccountValueCount = sizeof($debitChartOfAccountValues);

                    for ($i = 0; $i < $debitChartOfAccountValueCount; $i++) {
                        $data = array(
                            'transaction_date' => $transactionDate,
                            'chart_of_account_id' => $debitChartOfAccountIds[$i],
                            'debit_value' => $debitChartOfAccountValues[$i],
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $debitChartOfAccountIds[$i], $data);

                        //Same time edit the data in previous years record table.
                        $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $debitChartOfAccountIds[$i], $data);
                    }

                    $creditChartOfAccountValueCount = sizeof($creditChartOfAccountValues);

                    for ($i = 0; $i < $creditChartOfAccountValueCount; $i++) {
                        $data = array(
                            'transaction_date' => $transactionDate,
                            'chart_of_account_id' => $creditChartOfAccountIds[$i],
                            'credit_value' => $creditChartOfAccountValues[$i],
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'edited'
                        );

                        $this->journal_entries_model->editGeneralLedgerTransaction($journalEntryId, $creditChartOfAccountIds[$i], $data);

                        //Same time edit the data in previous years record table.
                        $this->journal_entries_model->editGeneralLedgerTransactionToPreviousYear($journalEntryId, $creditChartOfAccountIds[$i], $data);
                    }

                    echo "ok";
                } else {
                    echo "previous_financial_year_is_closed";
                }
			}
		}
	}

	public function delete() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Journal_Entry_Permissions'])) {
            
			$status = 'deleted';
            $html = '';
            
			$id = $this->db->escape_str($this->input->post('id'));
            
            $journalEntry = $this->journal_entries_model->getJournalEntryById($id);
            $journalEntryTransactionDate = $journalEntry[0]->transaction_date;

            $financialYear = $this->financial_year_ends_model->getFinancialYearOfSelectedTransaction($journalEntryTransactionDate);

            if ($financialYear[0]->year_end_process_status != "Closed") {
                
                if ($this->journal_entries_model->deleteJournalEntry($id, $status, $this->user_id)) {
                    $this->journal_entries_model->deleteGeneralLedgerTransactions($id, $status, $this->user_id);
                    $html = '<div class="alert alert-success alert-dismissable">
                            <a class="close" href="#" data-dismiss="alert">× </a>
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

	public function get() {
		if(isset($this->data['ACM_Bookkeeping_Edit_Journal_Entry_Permissions'])) {
			$journalEntryId = $this->db->escape_str($this->input->post('journal_entry_id'));

            $generalLedgerTransactions = '';
            
            if ($journalEntryId != '' && $journalEntryId != '0') {
                $generalLedgerTransactions = $this->journal_entries_model->getGeneralLedgerTransactionsByJournalEntryId($journalEntryId);
            }
            
            if ($generalLedgerTransactions == '') {
                $generalLedgerTransactions = $this->journal_entries_model->getPreviousYearsGeneralLedgerTransactionsByJournalEntryId($journalEntryId);
            }
            
			$journalEntry = $this->journal_entries_model->getJournalEntryById($journalEntryId);
			$primeEntryBookId = $journalEntry[0]->prime_entry_book_id;

			$primeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($primeEntryBookId);

			if ($primeEntryBook && sizeof($primeEntryBook) > 0) {
				$primeEntryBookName = $primeEntryBook[0]->prime_entry_book_name;
			} else {
				$primeEntryBookName = '';
			}

		$primeEntryBookName = "        <input class='form-control' id='prime_entry_book_id_hidden' name='prime_entry_book_id_hidden' type='hidden' value='{$journalEntry[0]->prime_entry_book_id}'>
				                                    <input class='form-control' id='journal_entry_id_hidden' name='journal_entry_id_hidden' type='hidden' value='{$journalEntry[0]->journal_entry_id}'>
								<div id='prime_entry_book_name_dropdown'>
									<input class='form-control' id='prime_entry_book_name' name='prime_entry_book_name' readonly
										type='text' value='{$primeEntryBookName}' placeholder='{$this->lang->line('Prime Entry Book Name')}'>
								</div>
								<div id='prime_entry_book_idError' class='red'></div>";

			$transactionDate =  "   <div class='datepicker-input input-group' id='datepicker_transaction_date'>
									<input class='form-control' id='transaction_date' name='transaction_date'
										data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Date')}' type='text' value='{$journalEntry[0]->transaction_date}'>
									<span class='input-group-addon'>
										 <span class='glyphicon glyphicon-calendar'/>
									</span>
								</div>
								<div id='transaction_dateError' class='red'></div>";  
											
			$payeePayerTypeData =  	    "			<select class='form-control' name='payee_payer_type' id='payee_payer_type' onchange='getPeopleType(this.id);'>
												<option value=''>" . $this->lang->line('-- Select --') . "</option>";

					$peopleType = $this->getPeopleType();
					$payeePayerType = $journalEntry[0]->payee_payer_type;
					$payeePayerId = $journalEntry[0]->payee_payer_id;
                    $locationId = $journalEntry[0]->location_id;

											foreach($peopleType as $row){
												if ($row['people_type'] == $payeePayerType) {
				$payeePayerTypeData .=  	    "                                        <option value='" . $row['people_type'] . "' selected>" . $row['people_type'] . "</option>";			
												} else {
				$payeePayerTypeData .=  	    "				<option value='" . $row['people_type'] . "'>" . $row['people_type'] . "</option>";
												}
											}
	$payeePayerTypeData .=  	    "					</select>
										<div id='payee_payer_typeError' class='red'></div>";
					
			$referenceNo = "<input class='form-control' id='reference_no' name='reference_no'
								type='text' value='{$journalEntry[0]->reference_no}' placeholder='{$this->lang->line('Reference No')}'>
							<div id='reference_noError' class='red'></div>";
								
			$thereIsAReferenceTransactionJournalEntry = $this->referenceTransactionJournalEntryIsSelected($primeEntryBookId);
			
			$referenceTransactionType = '';
			$referenceTransaction = '';
			$referenceJournalEntry = '';
			$referenceJournalEntryId = '';
			if ($thereIsAReferenceTransactionJournalEntry) {
				$referenceTransactionTypeId = $journalEntry[0]->reference_transaction_type_id;
				$referenceTransactionType = $this->getReferenceTransactionTypesDropdownWithSavedOption($referenceTransactionTypeId);
				
				$referenceTransactionId = '';
				if ($journalEntry[0]->reference_transaction_id != '0') {
					$referenceTransactionId = $journalEntry[0]->reference_transaction_id;
					$referenceTransaction = $this->getReferenceTransactionListForSelectedType($referenceTransactionTypeId, $referenceTransactionId, $payeePayerId, $locationId);
				}
				
				$referenceJournalEntryId = $journalEntry[0]->reference_journal_entry_id;
				$referenceJournalEntry = $this->getReferenceJournalEntryListForSelectedTransaction($referenceTransactionTypeId, $referenceTransactionId, $referenceJournalEntryId);
			}

			$location = "";
			if ($this->isAccountsManagementForLocationsEnabled()) {
				$locationList = $this->locations_model->getLocationsToDropDownWithSavedOption($journalEntry[0]->location_id, "Location Name");

				$location = "  <div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-3 controls' style='text-align:right'>
											<label class='control-label'>{$this->lang->line('Location')} *</label>
										</div>
										<div class='col-sm-5 controls' id='journal_entry_location_div'>
											<select class='form-control' id='location'>
												{$locationList}
											</select>
											<div id='locationError' class='red'></div>
										</div>
										<div class='col-sm-2 controls' style='text-align:center'>

										</div>
									</div>
								</div>";
			}

			$dueDate = "<div class='datepicker-input input-group' id='datepicker_due_date'>
								<input class='form-control' id='due_date' name='due_date'
									data-format='YYYY-MM-DD' placeholder='{$this->lang->line('Due Date')}' type='text' value='{$journalEntry[0]->due_date}'>
								<span class='input-group-addon'>
									 <span class='glyphicon glyphicon-calendar'/>
								</span>
							</div>
							<div id='due_dateError' class='red'></div>";
			
			$remark = preg_replace('~\\\r\\\n~',"<br>", $journalEntry[0]->description);
			$remark = str_ireplace("<br>", "\r\n", $remark);
									
			$description = "        <textarea class='form-control' id='description' name='description'
								type='text' placeholder='{$this->lang->line('Description')}'>{$remark}
							</textarea>
							<div id='descriptionError' class='red'></div>";

			$chartOfAccountsRowsExists = false;

			$debitAmountValueTotal = 0.00;
			$creditAmountValueTotal = 0.00;

			if ($generalLedgerTransactions && sizeof($generalLedgerTransactions) > 0) {
				$chartOfAccountsRowsExists = true;

				$debitAccounts = array();
				$creditAccounts = array();
				foreach ($generalLedgerTransactions as $generalLedgerTransaction) {
					if ($generalLedgerTransaction->debit_value != "0.00") {
						$debitAccounts[] = $generalLedgerTransaction->chart_of_account_id;
					} else if ($generalLedgerTransaction->credit_value != "0.00") {
						$creditAccounts[] = $generalLedgerTransaction->chart_of_account_id;
					}
				}
			}

			$chartOfAccountsGroups = '';
			if ($chartOfAccountsRowsExists) {

				$debitAccountCount = sizeof($debitAccounts);
				$creditAccountCount = sizeof($creditAccounts);

				if ($debitAccountCount > $creditAccountCount) {
					$primaryEntryBookChartOfAccountRowCount = $debitAccountCount;
				} else {
					$primaryEntryBookChartOfAccountRowCount = $creditAccountCount;
				}

				$count = 1;
				$debitAmountValueTotal = 0.00;
				$creditAmountValueTotal = 0.00;

				for ($count = 1; $count <= $primaryEntryBookChartOfAccountRowCount; $count++) {
					if (array_key_exists($count - 1, $debitAccounts)) {
						$debitAccountId = $debitAccounts[$count - 1];
						$debitAccount = $this->chart_of_accounts_model->get($debitAccountId);
						$debitAccountCode = $debitAccount[0]->chart_of_account_code;
						$debitAccountName = $debitAccount[0]->text;

						foreach ($generalLedgerTransactions as $transaction) {
							if ($transaction->chart_of_account_id == $debitAccountId) {
								$debitAccountValue = $transaction->debit_value;
								$debitAmountValueTotal = $debitAmountValueTotal + $debitAccountValue;
							}
						}
					} else {
						$debitAccountCode = '';
						$debitAccountName = '';
						$debitAccountValue = '';
					}

					if (array_key_exists($count - 1, $creditAccounts)) {
						$creditAccountId = $creditAccounts[$count - 1];
						$creditAccount = $this->chart_of_accounts_model->get($creditAccountId);
						$creditAccountCode = $creditAccount[0]->chart_of_account_code;
						$creditAccountName = $creditAccount[0]->text;

						foreach ($generalLedgerTransactions as $transaction) {
							if ($transaction->chart_of_account_id == $creditAccountId) {
								$creditAccountValue = $transaction->credit_value;
								$creditAmountValueTotal = $creditAmountValueTotal + $creditAccountValue;
							}
						}
					} else {
						$creditAccountCode = '';
						$creditAccountName = '';
						$creditAccountValue = '';
					}

					$chartOfAccountsGroups .= "     <div class='col-sm-12 controls row' id='chart_of_accounts_div_" . $count . "'>
														<div class='col-sm-6 controls' id='debit_chart_of_accounts_div_" . $count . "'>
															<input class='form-control' id='debit_chart_of_account_id_" . $count . "' name='debit_chart_of_account_id_" . $count . "' type='hidden' value='{$debitAccountId}'>";
														if ($debitAccountName != '') {
						$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='debit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
																<label class='control-label' id='debit_chart_of_account_code_" . $count . "'>" . $debitAccountCode . "</label>
															</div>
															<div class='col-sm-5 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
																<label class='control-label' id='debit_chart_of_account_" . $count . "'>" . $debitAccountName . "</label>
															</div>";
														} else {
						$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='debit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
																<label class='control-label' id='debit_chart_of_account_code_" . $count . "'></label>
															</div>
															<div class='col-sm-5 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
																<label class='control-label' id='debit_chart_of_account_" . $count . "'></label>
															</div>"; 
														}

														if ($debitAccountName != '') {
						$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='debit_transaction_value_div_" . $count . "' style='text-align:center;'>
																<input id='debit_transaction_value_" . $count . "' name='debit_transaction_value' class='form-control' "
								. "                                 type='text' placeholder='{$this->lang->line('Debit Amount')}' onchange='handleDebitTransactionValueAddition(this.id);' value='{$debitAccountValue}'>
																<div id='debit_transaction_value_" . $count . "Error' class='red'></div>
															</div>";
														} else {
						$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='debit_transaction_value_div_" . $count . "' style='text-align:center; display:none'>
																<input id='debit_transaction_value_" . $count . "' name='debit_transaction_value' class='form-control' "
								. "                                 type='text' placeholder='{$this->lang->line('Debit Amount')}' onchange='handleDebitTransactionValueAddition(this.id);' value='0.00'>
																<div id='debit_transaction_value_" . $count . "Error' class='red'></div>
															</div>";                                    
														}

						$chartOfAccountsGroups .= "     </div>
														<div class='col-sm-6 controls' id='credit_chart_of_accounts_div_" . $count . "'>
															<input class='form-control' id='credit_chart_of_account_id_" . $count . "' name='credit_chart_of_account_id_" . $count . "' type='hidden' value='{$creditAccountId}'>";
														if ($creditAccountName != '') {
						$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='credit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
																<label class='control-label' id='credit_chart_of_account_code_" . $count . "'>" . $creditAccountCode . "</label>
															</div>
															<div class='col-sm-5 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
																<label class='control-label' id='credit_chart_of_account_" . $count . "'>" . $creditAccountName . "</label>
															</div>";
														} else {
						$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='credit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
																<label class='control-label' id='credit_chart_of_account_code_" . $count . "'></label>
															</div>
															<div class='col-sm-5 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
																<label class='control-label' id='credit_chart_of_account_" . $count . "'></label>
															</div>"; 
														}

														if ($creditAccountName != '') {
						$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='credit_transaction_value_div_" . $count . "' style='text-align:center'>
																<input id='credit_transaction_value_" . $count . "' name='credit_transaction_value' class='form-control' "
								. "                                 type='text' placeholder='{$this->lang->line('Credit Amount')}' onchange='handleCreditTransactionValueAddition(this.id);' value='{$creditAccountValue}'>
																<div id='credit_transaction_value_" . $count . "Error' class='red'></div>
															</div>";
														} else {
						$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='credit_transaction_value_div_" . $count . "' style='text-align:center; display:none'>
																<input id='credit_transaction_value_" . $count . "' name='credit_transaction_value' class='form-control' "
								. "                                 type='text' placeholder='{$this->lang->line('Credit Amount')}' onchange='handleCreditTransactionValueAddition(this.id);' value='0.00'>
																<div id='credit_transaction_value_" . $count . "Error' class='red'></div>
															</div>";                                    
														}

					$chartOfAccountsGroups .= "         </div>
													</div>

													<p id='row_space_" . $count . "' style='margin-bottom:5px'>&nbsp;</p>";
				}
			}

			echo json_encode(array('primeEntryBookName' => $primeEntryBookName, 'transactionDate' => $transactionDate, 
							       'payeePayerType' => $payeePayerType, 'payeePayerTypeData' => $payeePayerTypeData, 
							       'payeePayerId' => $payeePayerId, 'referenceNo' => $referenceNo, 
							       'referenceTransactionType' => $referenceTransactionType, 'referenceTransaction' => $referenceTransaction, 
							       'referenceJournalEntryId' => $referenceJournalEntryId, 'referenceJournalEntry' => $referenceJournalEntry, 'location' => $location, 
							       'dueDate' => $dueDate, 'description' => $description, 'chartOfAccountsGroups' => $chartOfAccountsGroups, 
							       'debitAmountValueTotal' => number_format($debitAmountValueTotal, 2), 
							       'creditAmountValueTotal' => number_format($creditAmountValueTotal, 2)));
		}
	}

	public function getChartOfAccountsToAddTransaction() {
		$primeEntryBookid = $this->db->escape_str($this->input->post('prime_entry_book_id'));

		$primaryEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookid);

		$chartOfAccountsRowsExists = false;
		if ($primaryEntryBookChartOfAccounts && sizeof($primaryEntryBookChartOfAccounts) > 0) {
			$chartOfAccountsRowsExists = true;

			$debitAccounts = array();
			$creditAccounts = array();
			foreach($primaryEntryBookChartOfAccounts as $primaryEntryBookChartOfAccount) {
				if ($primaryEntryBookChartOfAccount->debit_or_credit == "debit") {
					$debitAccounts[] = $primaryEntryBookChartOfAccount->chart_of_account_id;
				} else if ($primaryEntryBookChartOfAccount->debit_or_credit == "credit") {
					$creditAccounts[] = $primaryEntryBookChartOfAccount->chart_of_account_id;
				}
			}
		}

		$chartOfAccountsGroups = '';
		if ($chartOfAccountsRowsExists) {

			$debitAccountCount = sizeof($debitAccounts);
			$creditAccountCount = sizeof($creditAccounts);

			if ($debitAccountCount > $creditAccountCount) {
				$primaryEntryBookChartOfAccountRowCount = $debitAccountCount;
			} else {
				$primaryEntryBookChartOfAccountRowCount = $creditAccountCount;
			}

			$count = 1;
			for ($count = 1; $count <= $primaryEntryBookChartOfAccountRowCount; $count++) {
				if (array_key_exists($count - 1, $debitAccounts)) {
					$debitAccountId = $debitAccounts[$count - 1];
					$debitAccount = $this->chart_of_accounts_model->get($debitAccountId);
					$debitAccountCode = $debitAccount[0]->chart_of_account_code;
					$debitAccountName = $debitAccount[0]->text;
				} else {
					$debitAccountCode = '';
					$debitAccountName = '';
				}

				if (array_key_exists($count - 1, $creditAccounts)) {
					$creditAccountId = $creditAccounts[$count - 1];
					$creditAccount = $this->chart_of_accounts_model->get($creditAccountId);
					$creditAccountCode = $creditAccount[0]->chart_of_account_code;
					$creditAccountName = $creditAccount[0]->text;
				} else {
					$creditAccountCode = '';
					$creditAccountName = '';
				}

				$chartOfAccountsGroups .= "     <div class='col-sm-12 controls row' id='chart_of_accounts_div_" . $count . "'>
													<div class='col-sm-6 controls' id='debit_chart_of_accounts_div_" . $count . "'>
														<input class='form-control' id='debit_chart_of_account_id_" . $count . "' name='debit_chart_of_account_id_" . $count . "' type='hidden' value='{$debitAccountId}'>";
													if ($debitAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='debit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='debit_chart_of_account_code_" . $count . "'>" . $debitAccountCode . "</label>
														</div>
														<div class='col-sm-5 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='debit_chart_of_account_" . $count . "'>" . $debitAccountName . "</label>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='debit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='debit_chart_of_account_code_" . $count . "'></label>
														</div>
														<div class='col-sm-5 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='debit_chart_of_account_" . $count . "'></label>
														</div>"; 
													}

													if ($debitAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='debit_transaction_value_div_" . $count . "' style='text-align:center;'>
															<input id='debit_transaction_value_" . $count . "' name='debit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Debit Amount')}' onchange='handleDebitTransactionValueAddition(this.id);' value='0.00'>
															<div id='debit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='debit_transaction_value_div_" . $count . "' style='text-align:center; display:none'>
															<input id='debit_transaction_value_" . $count . "' name='debit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Debit Amount')}' onchange='handleDebitTransactionValueAddition(this.id);' value='0.00'>
															<div id='debit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";                                    
													}

					$chartOfAccountsGroups .= "     </div>
													<div class='col-sm-6 controls' id='credit_chart_of_accounts_div_" . $count . "'>
														<input class='form-control' id='credit_chart_of_account_id_" . $count . "' name='credit_chart_of_account_id_" . $count . "' type='hidden' value='{$creditAccountId}'>";
													if ($creditAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='credit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='credit_chart_of_account_code_" . $count . "'>" . $creditAccountCode . "</label>
														</div>
														<div class='col-sm-5 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='credit_chart_of_account_" . $count . "'>" . $creditAccountName . "</label>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='credit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='credit_chart_of_account_code_" . $count . "'></label>
														</div>
														<div class='col-sm-5 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='credit_chart_of_account_" . $count . "'></label>
														</div>"; 
													}

													if ($creditAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='credit_transaction_value_div_" . $count . "' style='text-align:center'>
															<input id='credit_transaction_value_" . $count . "' name='credit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Credit Amount')}' onchange='handleCreditTransactionValueAddition(this.id);' value='0.00'>
															<div id='credit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='credit_transaction_value_div_" . $count . "' style='text-align:center; display:none'>
															<input id='credit_transaction_value_" . $count . "' name='credit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Credit Amount')}' onchange='handleCreditTransactionValueAddition(this.id);' value='0.00'>
															<div id='credit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";                                    
													}

				$chartOfAccountsGroups .= "         </div>
												</div>

												<p id='row_space_" . $count . "' style='margin-bottom:5px'>&nbsp;</p>";
			}
		}

		echo $chartOfAccountsGroups;
	}

	public function getAllPrimeEntryBooksToDropDown() {
		
		$moduleArray = array();

        array_push($moduleArray, "0");

        $moduleList = $this->user_model->getAllSystemModules('system_module_id','asc');

        foreach ($moduleList as $module) {
            $moduleName = $module->system_module;

            switch ($moduleName) {
                case "Service Manager":
                    array_push($moduleArray, "6");
                    break;
                case "Accounts Manager":
                    array_push($moduleArray, "7");
                    break;
                default:
                    break;
            }
        }
		
		$data = $this->prime_entry_book_model->getAllPrimeEntryBooks('prime_entry_book_name','asc');
        
		$primeEntryBookList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$systemModuleId = $dataElement->applicable_module_id;
				if (in_array($systemModuleId, $moduleArray)) {
					$primeEntryBookList[$dataElement->prime_entry_book_id] = $dataElement->prime_entry_book_name;
				}
			}
		}

		$this->optionList = '';

		foreach($primeEntryBookList as $key => $prime_entry_book_name) {
			$this->optionList .= '<option value=' . $key . '>' . $prime_entry_book_name . '</option>';
		}

		$primeEntryBooks = "<select class='select2 form-control' id='prime_entry_book_id' onchange='handlePrimeEntryBookSelect(this.id)'>
					{$this->optionList}
				 </select>";

		echo $primeEntryBooks;
	}
	
	public function getAllPrimeEntryBooksToMultipleDropDown() {
		
		$moduleArray = array();

        array_push($moduleArray, "0");

        $moduleList = $this->user_model->getAllSystemModules('system_module_id','asc');

        foreach ($moduleList as $module) {
            $moduleName = $module->system_module;

            switch ($moduleName) {
                case "Service Manager":
                    array_push($moduleArray, "6");
                    break;
                case "Accounts Manager":
                    array_push($moduleArray, "7");
                    break;
                default:
                    break;
            }
        }
			
		$data = $this->prime_entry_book_model->getAllPrimeEntryBooks('prime_entry_book_name','asc');
        
		$primeEntryBookList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$systemModuleId = $dataElement->applicable_module_id;
				if (in_array($systemModuleId, $moduleArray)) {
					$primeEntryBookList[$dataElement->prime_entry_book_id] = $dataElement->prime_entry_book_name;
				}
			}
		}

		$this->optionList = '';

		foreach($primeEntryBookList as $key => $prime_entry_book_name) {
			$this->optionList .= '<option value=' . $key . '>' . $prime_entry_book_name . '</option>';
		}

		$primeEntryBooks = "<select class='select2 form-control' id='prime_entry_book_id' multiple onchange='handlePrimeEntryBookSelect(this.id)'>
					{$this->optionList}
				 </select>";

		echo $primeEntryBooks;
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Journal_Entry_Permissions'])) {
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
            $fromDateSearch = $this->db->escape_str($this->input->post('from_date'));
            $toDateSearch = $this->db->escape_str($this->input->post('to_date'));
            $primeEntryBookId = $this->db->escape_str($this->input->post('prime_entry_book_id'));
            $locationId = $this->db->escape_str($this->input->post('location_id'));
			
			if ($fromDateSearch == '' && $toDateSearch == '') {
                if ($year == '' && $month == '') {
                    $year = date("Y");
                    $month = date('m');
                }
                
                $length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $fromDate = $year . '-' . $month . '-1';
                $toDate = $year . '-' . $month . '-' . $length;
                
            } else {
                $fromDate = $fromDateSearch;
                $toDate = $toDateSearch;
            }
			
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Date')}</th>
							<th>{$this->lang->line('Reference No')}</th>";
						if ($this->isAccountsManagementForLocationsEnabled()) {
				$html .= "		 <th>{$this->lang->line('Location')}</th>";
						}
				$html .= "		<th>{$this->lang->line('Due Date')}</th>
					.		<th>{$this->lang->line('Prime Entry Book Name')}</th>
							<th>{$this->lang->line('Description')}</th>
							<th>{$this->lang->line('Actions')}</th>
						</tr>
					</thead>
					<tbody>";

			$journalEntries = $this->journal_entries_model->getAllJournalEntries($fromDate, $toDate, 'transaction_date', 'desc', $locationId, $primeEntryBookId);

			if ($journalEntries != null) {
				foreach ($journalEntries as $row) {

					if ($row->prime_entry_book_id != '0' && $row->prime_entry_book_id != '') {
						$primeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($row->prime_entry_book_id);
						$primeEntryBookName = $primeEntryBook[0]->prime_entry_book_name;
					} else {
						$primeEntryBookName = "";
					}
					
					if ($row->due_date == '0000-00-00') {
						$dueDate = '';
					} else {
						$dueDate = $row->due_date;
					}

					$html .= "<tr>";
					$html .= "<td>" . $row->transaction_date . "</td>";
					$html .= "<td>" . $row->reference_no . "</td>";
					if ($this->isAccountsManagementForLocationsEnabled()) {
						$html .= "<td>" . $row->location_name . "</td>";
					}
					$html .= "<td>" . $dueDate . "</td>";
					$html .= "<td>" . $primeEntryBookName . "</td>";
					$html .= "<td>" . $row->description . "</td>";
					$html .= "<td style='width:7%'>
										<div class='text-left'>";
										if(isset($this->data['ACM_Bookkeeping_Edit_Journal_Entry_Permissions']))
											$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->journal_entry_id}' title='{$this->lang->line('Edit')}' onclick='get($row->journal_entry_id);'>
												<i class='icon-wrench'></i>
											</a> ";
										if ($row->post_type == "Direct") {
											if(isset($this->data['ACM_Bookkeeping_Delete_Journal_Entry_Permissions']))
												$html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->journal_entry_id}' title='{$this->lang->line('Delete')}' "
														 . "onclick='del($row->journal_entry_id);'>
													<i class='icon-remove'></i>
												</a>";
										}
						$html .= "      </div>
									</td>";
					$html .= "</tr>";
				}
			}
			$html .= "</tbody>
					</table>
				</div>
			</div>
		</div>";
			echo $html;
		}
	}

	public function getLocationDropDown() {
		$locations = $this->locations_model->getAllLocationsAsOptionList("Location Name");

		$html = "<div class='form-group'>
					<div class='col-sm-12 controls'>
						<div class='col-sm-3 controls' style='text-align:right'>
							<label class='control-label'>{$this->lang->line('Location')} *</label>
						</div>
						<div class='col-sm-5 controls' id='journal_entry_location_div'>
							<select class='form-control' id='location'>
								{$locations}
							</select>
							<div id='locationError' class='red'></div>
						</div>
						<div class='col-sm-2 controls' style='text-align:center'>

						</div>
					</div>
				</div>";

		echo $html;
	}

	public function isAccountsManagementForLocationsEnabled() {
		return $this->system_configurations_model->isAccountsManagementForLocationsEnabled();
	}
	
	public function getReferenceTransactionTypesDropdown() {
		echo $this->common_functions->getReferenceTransactionTypesToDropDown();
	}
	
	public function getReferenceTransactionTypesDropdownWithSavedOption($selectedIndex) {
		return $this->common_functions->getReferenceTransactionTypesToDropDownWithSavedOption($selectedIndex);
	}
	
	public function getReferenceTransactionListForSelectedType($transactionTypeId=null, $selectedIndex=null, $peopleId=null, $locationId=null,
                                                               $financialYearStartDate=null, $financialYearEndDate=null) {
		
		if ($transactionTypeId == '') {
			$transactionTypeId = $this->db->escape_str($this->input->post('transaction_type_id'));
			$peopleId = $this->db->escape_str($this->input->post('people_id'));
            $locationId = $this->db->escape_str($this->input->post('location_id'));
            $transactionDate = $this->db->escape_str($this->input->post('transaction_date'));
            
            if ($transactionDate == '') {
                $transactionDate = date('Y-m-d');
            }
            
            $year = date('Y', strtotime($transactionDate));

            $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
            $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
            $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
            $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

            $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

            if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($transactionDate)) {
                $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
            } else {
                if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                    $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                } else {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                }
            }
		}
		
		$transactionTypeList = '';
		
		switch ($transactionTypeId) {
			
            //Purchase Note
			case '1':

				$allPurchaseNotes = $this->purchase_note_model->getAllOpenProductPurchasingPurchaseNoteIdsAndAllReferenceNumbers('reference_no', 'asc', $peopleId, $locationId, $financialYearStartDate, $financialYearEndDate);
				$transactionTypeList = "<select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allPurchaseNotes && sizeof($allPurchaseNotes) > 0) {
					foreach ($allPurchaseNotes as $purchaseNotes) {
						if ($selectedIndex == '') {
							$transactionTypeList .= "<option value='" . $purchaseNotes->purchase_note_id  . "' >" . $purchaseNotes->reference_no . " : [" . number_format($purchaseNotes->balance_payment, 2) . "]</option>";
						} else {
							if ($selectedIndex == $purchaseNotes->purchase_note_id) {
								$transactionTypeList .= "<option value='" . $purchaseNotes->purchase_note_id  . "' selected>" . $purchaseNotes->reference_no . " : [" . number_format($purchaseNotes->balance_payment, 2) . "]</option>";
							} else {
								$transactionTypeList .= "<option value='" . $purchaseNotes->purchase_note_id  . "' >" . $purchaseNotes->reference_no . " : [" . number_format($purchaseNotes->balance_payment, 2) . "]</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
                
			//Sales Note
			case '2':

				$allSalesNotes = $this->sales_note_model->getAllOpenSalesNoteIdsAndAllReferenceNumbers('reference_no', 'asc', $peopleId, $locationId, $financialYearStartDate, $financialYearEndDate);
				$transactionTypeList = "<select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allSalesNotes && sizeof($allSalesNotes) > 0) {
					foreach ($allSalesNotes as $salesNotes) {
						if ($selectedIndex == '') {
							$transactionTypeList .= "<option value='" . $salesNotes->sales_note_id  . "' >" . $salesNotes->reference_no . " : [" . number_format($salesNotes->balance_payment, 2) . "]</option>";
						} else {
							if ($selectedIndex == $salesNotes->sales_note_id) {
								$transactionTypeList .= "<option value='" . $salesNotes->sales_note_id  . "' selected>" . $salesNotes->reference_no . " : [" . number_format($salesNotes->balance_payment, 2) . "]</option>";
							} else {
								$transactionTypeList .= "<option value='" . $salesNotes->sales_note_id  . "' >" . $salesNotes->reference_no . " : [" . number_format($salesNotes->balance_payment, 2) . "]</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
				
            //Supplier Return Note
			case '3':

				$allSupplierReturnNotes = $this->supplier_return_note_model->getAllOpenSupplierReturnNoteIdsAndAllReferenceNumbers('reference_no', 'asc', $peopleId, $locationId, $financialYearStartDate, $financialYearEndDate);
				$transactionTypeList = "<select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allSupplierReturnNotes && sizeof($allSupplierReturnNotes) > 0) {
					foreach ($allSupplierReturnNotes as $supplierReturnNote) {
						if ($selectedIndex == '') {
							$transactionTypeList .= "<option value='" . $supplierReturnNote->supplier_return_note_id  . "' >" . $supplierReturnNote->reference_no . " : [" . number_format($supplierReturnNote->balance_payment, 2) . "]</option>";
						} else {
							if ($selectedIndex == $salesNotes->sales_note_id) {
								$transactionTypeList .= "<option value='" . $supplierReturnNote->supplier_return_note_id  . "' selected>" . $supplierReturnNote->reference_no . " : [" . number_format($supplierReturnNote->balance_payment, 2) . "]</option>";
							} else {
								$transactionTypeList .= "<option value='" . $supplierReturnNote->supplier_return_note_id  . "' >" . $supplierReturnNote->reference_no . " : [" . number_format($supplierReturnNote->balance_payment, 2) . "]</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
                
            //Customer Return Note
			case '4':

				$allCustomerReturnNotes = $this->customer_return_note_model->getAllOpenCustomerReturnNoteIdsAndAllReferenceNumbers('reference_no', 'asc', $peopleId, $locationId, $financialYearStartDate, $financialYearEndDate);
				$transactionTypeList = "<select class='select2 form-control' id='reference_transaction_id' onchange='handleReferenceTransactionSelect(this.id);' >
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
				if ($allCustomerReturnNotes && sizeof($allCustomerReturnNotes) > 0) {
					foreach ($allCustomerReturnNotes as $customerReturnNote) {
						if ($selectedIndex == '') {
							$transactionTypeList .= "<option value='" . $customerReturnNote->customer_return_note_id  . "' >" . $customerReturnNote->reference_no . " : [" . number_format($customerReturnNote->balance_payment, 2) . "]</option>";
						} else {
							if ($selectedIndex == $salesNotes->sales_note_id) {
								$transactionTypeList .= "<option value='" . $customerReturnNote->customer_return_note_id  . "' selected>" . $customerReturnNote->reference_no . " : [" . number_format($customerReturnNote->balance_payment, 2) . "]</option>";
							} else {
								$transactionTypeList .= "<option value='" . $customerReturnNote->customer_return_note_id  . "' >" . $customerReturnNote->reference_no . " : [" . number_format($customerReturnNote->balance_payment, 2) . "]</option>";
							}
						}
					}
				}
				
				$transactionTypeList .="   </select>";

				break;
                
			//Other
			case '5':
				
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
	
	public function getReferenceJournalEntryListForSelectedTransaction($transactionTypeId=null, $transactionReferenceId=null, 
        $selectedIndex=null, $status=null, $peopleId=null, $locationId=null, $financialYearStartDate=null, $financialYearEndDate=null) {
		
		$transactionReferenceNo = '';
        $transactionReferenceNoData = '';
		if ($transactionTypeId == '') {
			$transactionTypeId = $this->db->escape_str($this->input->post('transaction_type_id'));
			$transactionReferenceNoData = $this->db->escape_str($this->input->post('transaction_reference_no'));
            $status = $this->db->escape_str($this->input->post('status'));
            $peopleId = $this->db->escape_str($this->input->post('people_id'));
            $locationId = $this->db->escape_str($this->input->post('location_id'));
            $transactionDate = $this->db->escape_str($this->input->post('transaction_date'));
            
            if ($transactionDate == '') {
                $transactionDate = date('Y-m-d');
            }
            
            $year = date('Y', strtotime($transactionDate));

            $financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
            $financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
            $financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
            $financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();

            $financialYearEndDateToCompare = ($year) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;

            if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($financialYearEndDateToCompare) < strtotime($transactionDate)) {
                $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                $financialYearEndDate = ($year + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
            } else {
                if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
                    $financialYearStartDate = ($year - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                } else {
                    $financialYearStartDate = $year . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
                    $financialYearEndDate = $year . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
                }
            }
		}
		
		$journalEntries = '';
		$journalEntryList = '';
        
        $transactionReferenceNoDataList = explode(":", $transactionReferenceNoData);
        $transactionReferenceNo = trim($transactionReferenceNoDataList[0]);
		
		switch ($transactionTypeId) {
			
            //Purchase Note
			case '1':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'Purchase Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
				} else {
					$purchaseNote = $this->purchase_note_model->getPurchaseNoteById($transactionReferenceId);
					if ($purchaseNote && sizeof($purchaseNote) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($purchaseNote[0]->reference_no, 'Purchase Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id' onchange='handleReferenceJournalEntrySelect(this.id);'>
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
                
			//Sales Note
			case '2':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'Sales Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
				} else {
					$salesNote = $this->sales_note_model->getSalesNoteById($transactionReferenceId);
					if ($salesNote && sizeof($salesNote) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($salesNote[0]->reference_no, 'Sales Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id' onchange='handleReferenceJournalEntrySelect(this.id);'>
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
                
            //Supplier Return Note
			case '3':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'Supplier Return Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
				} else {
					$supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($transactionReferenceId);
					if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($supplierReturnNote[0]->reference_no, 'Supplier Return Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id' onchange='handleReferenceJournalEntrySelect(this.id);'>
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
                
            //Customer Return Note
			case '4':

				if ($transactionReferenceNo != '') {
					$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo, 'Customer Return Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
				} else {
					$customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($transactionReferenceId);
					if ($customerReturnNote && sizeof($customerReturnNote) > 0) {
						$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType($customerReturnNote[0]->reference_no, 'Customer Return Note', '', '', '', $financialYearStartDate, $financialYearEndDate);
					}
				}
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id' onchange='handleReferenceJournalEntrySelect(this.id);'>
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
			case '5':
				
				$journalEntries = $this->journal_entries_model->getJournalEntriesByReferenceNoAndByTransactionType('', '', $status, $peopleId, $locationId, $financialYearStartDate, $financialYearEndDate);
				
				$journalEntryList = "   <select class='select2 form-control' id='reference_journal_entry_id' onchange='handleReferenceJournalEntrySelect(this.id);'>
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
	
	public function isThereAReferenceTransactionJournalEntry() {
		
		$primeEntryBookId = $this->db->escape_str($this->input->post('prime_entry_book_id'));
		
		$primaryEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($primeEntryBookId);
		$thereIsAReferenceJournalEntry = $primaryEntryBook[0]->has_a_reference_journal_entry;
		
		echo $thereIsAReferenceJournalEntry;
	}
	
	public function referenceTransactionJournalEntryIsSelected($primeEntryBookId) {
		$thereIsAReferenceJournalEntry = '0';
		
		if ($primeEntryBookId != '0' && $primeEntryBookId != '') {
			$primaryEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($primeEntryBookId);
			$thereIsAReferenceJournalEntry = $primaryEntryBook[0]->has_a_reference_journal_entry;
		}
		
		return $thereIsAReferenceJournalEntry;
	}
	
	public function getReferenceJournalEntryDetailsForMakePayment() {
		$referenceTransactionType = $this->db->escape_str($this->input->post('reference_transaction_type'));
		$referenceTransactionId = $this->db->escape_str($this->input->post('reference_transaction_id'));
		$referenceJournalEntryId = $this->db->escape_str($this->input->post('reference_journal_entry_id'));
		$transactionAmountTotal = $this->db->escape_str($this->input->post('transaction_amount_total'));
        
        $referenceJournalEntry = $this->journal_entries_model->getJournalEntryById($referenceJournalEntryId);
		$generalLedgerCreditRecord = $this->journal_entries_model->getGeneralLedgerTransactionCreditRecordByJournalEntryId($referenceJournalEntryId);
		
        $transactionAmount = 0;
        
		if ($referenceTransactionType == '2' || $referenceTransactionType == '3') {
			
            if ($referenceTransactionType == '2') {
                $salesNote = $this->sales_note_model->getSalesNoteById($referenceTransactionId);
							
                if ($salesNote && sizeof($salesNote) > 0) {
                    $transactionAmount = $salesNote[0]->balance_payment;
                }
            } else if ($referenceTransactionType == '3') {
                $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($referenceTransactionId);
							
                if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {
                    $transactionAmount = $supplierReturnNote[0]->balance_payment;
                }
            }
            
			$transactionAmountTotal = $transactionAmountTotal - $transactionAmount;
		} else if ($referenceTransactionType == '1' || $referenceTransactionType == '4') {
            
            if ($referenceTransactionType == '1') {
                $purchaseNote = $this->purchase_note_model->getPurchaseNoteById($referenceTransactionId);
							
                if ($purchaseNote && sizeof($purchaseNote) > 0) {
                    $transactionAmount = $purchaseNote[0]->balance_payment;
                }
            } else if ($referenceTransactionType == '4') {
                $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($referenceTransactionId);
							
                if ($customerReturnNote && sizeof($customerReturnNote) > 0) {
                    $transactionAmount = $customerReturnNote[0]->balance_payment;
                }
            }
            
            $transactionAmountTotal = $transactionAmountTotal + $transactionAmount;
        } else if ($referenceTransactionType == '5') {
            
            if ($referenceJournalEntry[0]->balance_amount != '0.00') {
                $transactionAmount = $referenceJournalEntry[0]->balance_amount;
                $transactionAmountTotal = $transactionAmountTotal + $transactionAmount;
            } else {
                if ($generalLedgerCreditRecord[0]->credit_value > 0) {
                    $transactionAmount = $generalLedgerCreditRecord[0]->credit_value;
                } else if ($generalLedgerCreditRecord[0]->debit_value > 0) {
                    $transactionAmount = $generalLedgerCreditRecord[0]->debit_value;
                }
                
                $transactionAmountTotal = $transactionAmountTotal + $transactionAmount;
            }
		}
		
		echo json_encode(array('transactionAmount' => number_format($transactionAmount, 2), 'transactionAmountTotal' => number_format($transactionAmountTotal, 2), 'transactionAmountTotalNonFormatted' => $transactionAmountTotal));
	}
    
    public function getReferenceJournalEntryDetailsForReceivePayment() {
		$referenceTransactionType = $this->db->escape_str($this->input->post('reference_transaction_type'));
		$referenceTransactionId = $this->db->escape_str($this->input->post('reference_transaction_id'));
		$referenceJournalEntryId = $this->db->escape_str($this->input->post('reference_journal_entry_id'));
		$transactionAmountTotal = $this->db->escape_str($this->input->post('transaction_amount_total'));
        
        $referenceJournalEntry = $this->journal_entries_model->getJournalEntryById($referenceJournalEntryId);
		$generalLedgerCreditRecord = $this->journal_entries_model->getGeneralLedgerTransactionCreditRecordByJournalEntryId($referenceJournalEntryId);
		
        $transactionAmount = 0;
        
		if ($referenceTransactionType == '2' || $referenceTransactionType == '3') {
			
            if ($referenceTransactionType == '2') {
                $salesNote = $this->sales_note_model->getSalesNoteById($referenceTransactionId);
							
                if ($salesNote && sizeof($salesNote) > 0) {
                    $transactionAmount = $salesNote[0]->balance_payment;
                }
            } else if ($referenceTransactionType == '3') {
                $supplierReturnNote = $this->supplier_return_note_model->getSupplierReturnNoteById($referenceTransactionId);
							
                if ($supplierReturnNote && sizeof($supplierReturnNote) > 0) {
                    $transactionAmount = $supplierReturnNote[0]->balance_payment;
                }
            }
            
			$transactionAmountTotal = $transactionAmountTotal + $transactionAmount;
		} else if ($referenceTransactionType == '1' || $referenceTransactionType == '4') {
            
            if ($referenceTransactionType == '1') {
                $purchaseNote = $this->purchase_note_model->getPurchaseNoteById($referenceTransactionId);
							
                if ($purchaseNote && sizeof($purchaseNote) > 0) {
                    $transactionAmount = $purchaseNote[0]->balance_payment;
                }
            } else if ($referenceTransactionType == '4') {
                $customerReturnNote = $this->customer_return_note_model->getCustomerReturnNoteById($referenceTransactionId);
							
                if ($customerReturnNote && sizeof($customerReturnNote) > 0) {
                    $transactionAmount = $customerReturnNote[0]->balance_payment;
                }
            }
            
            $transactionAmountTotal = $transactionAmountTotal - $transactionAmount;
        } else if ($referenceTransactionType == '5') {
            if ($referenceJournalEntry[0]->balance_amount != '0.00') {
                $transactionAmount = $referenceJournalEntry[0]->balance_amount;
                $transactionAmountTotal = $transactionAmountTotal + $transactionAmount;
            } else {
                if ($generalLedgerCreditRecord[0]->credit_value > 0) {
                    $transactionAmount = $generalLedgerCreditRecord[0]->credit_value;
                } else if ($generalLedgerCreditRecord[0]->debit_value > 0) {
                    $transactionAmount = $generalLedgerCreditRecord[0]->debit_value;
                }
                
                $transactionAmountTotal = $transactionAmountTotal + $transactionAmount;
            }
		}
		
		echo json_encode(array('transactionAmount' => number_format($transactionAmount, 2), 'transactionAmountTotal' => number_format($transactionAmountTotal, 2), 'transactionAmountTotalNonFormatted' => $transactionAmountTotal));
	}
}
