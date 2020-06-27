<?php
class Journal_entries_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function addJournalEntry($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_journal_entries', $data);
		return $this->db->insert_id();
	}

	public function addJournalEntryToHistory($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_journal_entries_history', $data);
		return $this->db->insert_id();
	}
    
    public function addJournalEntryClaimReference($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_journal_entry_claim_references', $data);
		return $this->db->insert_id();
	}

	public function editJournalEntry($id, $data) {
		$this->db->where('journal_entry_id', $id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_journal_entries', $data);
		return true;
	}

	public function addGeneralLedgerTransaction($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_gl_transactions', $data);
		return $this->db->insert_id();
	}

	public function addGeneralLedgerTransactionToPreviousYear($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_gl_transactions_for_previous_years', $data);
		return $this->db->insert_id();
	}

	public function addGeneralLedgerTransactionToHistory($data) {
		$this->db->limit(1);
		$this->db->insert('acm_bookkeeping_gl_transactions_history', $data);
		return $this->db->insert_id();
	}
    
    public function editGeneralLedgerTransactionById($id, $data) {
		$this->db->where('gl_transaction_id', $id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions', $data);
	}

	public function editGeneralLedgerTransaction($journalEntryId, $chartOfAccountId, $data) {
		$this->db->where('journal_entry_id', $journalEntryId);
		$this->db->where('chart_of_account_id', $chartOfAccountId);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions', $data);
	}

    public function editGeneralLedgerTransactionToPreviousYearById($id, $data) {
		$this->db->where('gl_transaction_id', $id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions_for_previous_years', $data);
	}
    
    public function editGeneralLedgerTransactionToPreviousYear($journalEntryId, $chartOfAccountId, $data) {
		$this->db->where('journal_entry_id', $journalEntryId);
		$this->db->where('chart_of_account_id', $chartOfAccountId);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions_for_previous_years', $data);
	}
    
	public function editCreditSideOfGeneralLedgerTransaction($journalEntryId, $data) {
		$this->db->where('journal_entry_id', $journalEntryId);
		$this->db->where('credit_value !=', "0.00");
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions', $data);
	}

	public function editCreditSideOfGeneralLedgerTransactionToPreviousYear($journalEntryId, $data) {
		$this->db->where('journal_entry_id', $journalEntryId);
		$this->db->where('credit_value !=', "0.00");
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions_for_previous_years', $data);
	}
	
	public function editDebitSideOfGeneralLedgerTransaction($journalEntryId, $data) {
		$this->db->where('journal_entry_id', $journalEntryId);
		$this->db->where('debit_value !=', "0.00");
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions', $data);
	}

	public function editDebitSideOfGeneralLedgerTransactionToPreviousYear($journalEntryId, $data) {
		$this->db->where('journal_entry_id', $journalEntryId);
		$this->db->where('debit_value !=', "0.00");
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_gl_transactions_for_previous_years', $data);
	}

	public function deleteJournalEntry($id, $status, $user_id) {
		$this->db->where('journal_entry_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_journal_entries');
		return true;
	}
	
	public function activateJournalEntry($id, $status, $user_id) {
		$this->db->where('journal_entry_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1);
		$this->db->update('acm_bookkeeping_journal_entries');
		return true;
	}

	public function deleteGeneralLedgerTransactions($id, $status, $user_id) {
		$this->db->where('journal_entry_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->update('acm_bookkeeping_gl_transactions');

		$this->db->where('journal_entry_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->update('acm_bookkeeping_gl_transactions_for_previous_years');

		return true;
	}
	
	public function activateGeneralLedgerTransactions($id, $status, $user_id) {
		$this->db->where('journal_entry_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(10);
		$this->db->update('acm_bookkeeping_gl_transactions');
		
		$this->db->where('journal_entry_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(10);
		$this->db->update('acm_bookkeeping_gl_transactions_for_previous_years');
		return true;
	}

	public function getAllJournalEntries($fromDate, $toDate, $orderField=null, $orderType=null, $locationId=null) {
        
        if ($orderField != '' && $orderType != '') {
            $this->db->order_by($orderField, $orderType);
        }
        
		$this->db->join('ogm_admin_locations', 'ogm_admin_locations.location_id=acm_bookkeeping_journal_entries.location_id','left');
		$this->db->where('transaction_date >=', $fromDate);
		$this->db->where('transaction_date <=', $toDate);
		$this->db->where('acm_bookkeeping_journal_entries.last_action_status !=','deleted');
        
        if ($locationId != '') {
            $this->db->where('acm_bookkeeping_journal_entries.location_id', $locationId);
        }
        
		$query = $this->db->get('acm_bookkeeping_journal_entries');
        
		if ($query->num_rows() > 0) {
			$journalEntries = $query->result();
			
			$userId = $this->user_id;
			$this->db->where('user_id', $userId);
			$query = $this->db->get('urm_user_roles_user_not_accessible_prime_entry_books');

			$notAccessiblePrimeEntryBooks = array();
			if ($query->num_rows() > 0) {
				$selectedPrimeEntryBooks = $query->result();

				foreach ($selectedPrimeEntryBooks as $selectedPrimeEntryBook) {
					$notAccessiblePrimeEntryBooks[] = $selectedPrimeEntryBook->prime_entry_book_id;
				}
			}

			$finalJournalEntries = array();
			
			if ($notAccessiblePrimeEntryBooks && sizeof($notAccessiblePrimeEntryBooks) > 0) {
				if ($journalEntries && sizeof($journalEntries) > 0) {
					foreach($journalEntries as $journalEntry) {
						if (!in_array($journalEntry->prime_entry_book_id, $notAccessiblePrimeEntryBooks)) {
							$finalJournalEntries[] = $journalEntry;
						}
					}
				}
			} else {
				$finalJournalEntries = $journalEntries;
			}
			
			return $finalJournalEntries;
		} else {
			return false;
		}
	}
	
	public function getJournalEntriesByReferenceNoAndByTransactionType($transactionReferenceNo=null, $descriptionContains=null) {
		if ($transactionReferenceNo != '') {
			$this->db->where('acm_bookkeeping_journal_entries.reference_no =', $transactionReferenceNo);
		}
		
		if ($descriptionContains != '') {
			$this->db->like('acm_bookkeeping_journal_entries.description', $descriptionContains);
		}
		
		$this->db->where('acm_bookkeeping_journal_entries.should_have_a_payment_journal_entry =', 'Yes');
		$this->db->where('acm_bookkeeping_journal_entries.last_action_status !=','deleted');
		$query = $this->db->get('acm_bookkeeping_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getJournalEntriesByReferenceNoAndByPrimeEntryBookId($transactionReferenceNo, $primeEntryBookId) {
		$this->db->where('acm_bookkeeping_journal_entries.reference_no =', $transactionReferenceNo);
		$this->db->like('acm_bookkeeping_journal_entries.prime_entry_book_id', $primeEntryBookId);
		$this->db->where('acm_bookkeeping_journal_entries.last_action_status !=','deleted');
		$query = $this->db->get('acm_bookkeeping_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getJournalEntryById($id) {
		$this->db->where('journal_entry_id', $id);
        $this->db->where('acm_bookkeeping_journal_entries.last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_journal_entries');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getJournalEntryByPrimeEntryBookIdAndReferenceNo($primeEntryBookId, $referenceNo) {
		$this->db->where('prime_entry_book_id', $primeEntryBookId);
        $this->db->where('reference_no', $referenceNo);
        $this->db->where('acm_bookkeeping_journal_entries.last_action_status !=','deleted');
		$this->db->limit(10000);
		$query = $this->db->get('acm_bookkeeping_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getGeneralLedgerTransactionsById($id) {
		$this->db->where('gl_transaction_id', $id);
		
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_gl_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getGeneralLedgerTransactionByJournalEntryIdAndChartOfAccountId($journalEntryId, $chartOfAccountId) {
		$this->db->where('journal_entry_id', $journalEntryId);
        $this->db->where('chart_of_account_id', $chartOfAccountId);
		
		$this->db->limit(1);
		$query = $this->db->get('acm_bookkeeping_gl_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getGeneralLedgerTransactionsByJournalEntryId($id, $chartOfAccountId=null, $transactionComplete=null) {
		$this->db->where('journal_entry_id', $id);
		
		if ($chartOfAccountId !='') {
			$this->db->where('chart_of_account_id', $chartOfAccountId);
		}
		
		if ($transactionComplete !='') {
			$this->db->where('transaction_complete', $transactionComplete);
		}
		
		$this->db->limit(100000);
		$query = $this->db->get('acm_bookkeeping_gl_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllGeneralLedgerEntries($defaultSearchFromDate, $defaultSearchToDate, $order_field, $order_type, $fromDate=null, $toDate=null, $primeEntryBookId=null, $chartOfAccountId=null, $locationId=null) {
		$this->db->order_by('acm_bookkeeping_gl_transactions.' . $order_field, $order_type);
		$this->db->join('acm_bookkeeping_journal_entries', 'acm_bookkeeping_journal_entries.journal_entry_id=acm_bookkeeping_gl_transactions.journal_entry_id','left');
		$this->db->join('ogm_admin_locations', 'ogm_admin_locations.location_id=acm_bookkeeping_journal_entries.location_id','left');

		if ($defaultSearchFromDate != '' && $defaultSearchToDate != '') {
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date >=', $defaultSearchFromDate);
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date <=', $defaultSearchToDate);
		}
		
		if($fromDate) {
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date >=', $fromDate);
		}

		if($toDate) {
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date <=', $toDate);
		}

		if($primeEntryBookId) {
			$this->db->where('acm_bookkeeping_journal_entries.prime_entry_book_id', $primeEntryBookId);
		}

		if($chartOfAccountId) {
			$this->db->where('acm_bookkeeping_gl_transactions.chart_of_account_id', $chartOfAccountId);
		}

		if($locationId) {
			$this->db->where_in('acm_bookkeeping_journal_entries.location_id', $locationId);
		}

		$this->db->where('acm_bookkeeping_gl_transactions.last_action_status !=','deleted');

		$this->db->limit(10000000);
		$query = $this->db->get('acm_bookkeeping_gl_transactions');
		
		if ($query->num_rows() > 0) {
			$glTransactions = $query->result();
			
			$userId = $this->user_id;
			$this->db->where('user_id', $userId);
			$query = $this->db->get('urm_user_roles_user_not_accessible_prime_entry_books');

			$notAccessiblePrimeEntryBooks = array();
			if ($query->num_rows() > 0) {
				$selectedPrimeEntryBooks = $query->result();

				foreach ($selectedPrimeEntryBooks as $selectedPrimeEntryBook) {
					$notAccessiblePrimeEntryBooks[] = $selectedPrimeEntryBook->prime_entry_book_id;
				}
			}

			$finalGLTransactions = array();
			
			if ($notAccessiblePrimeEntryBooks && sizeof($notAccessiblePrimeEntryBooks) > 0) {
				if ($glTransactions && sizeof($glTransactions) > 0) {
					foreach($glTransactions as $glTransaction) {
						if (!in_array($glTransaction->prime_entry_book_id, $notAccessiblePrimeEntryBooks)) {
							$finalGLTransactions[] = $glTransaction;
						}
					}
				}
			} else {
				$finalGLTransactions = $glTransactions;
			}
			
			return $finalGLTransactions;
		} else {
			return false;
		}
	}
	
	public function getAllGeneralLedgerEntriesOfMainJournalEntries($defaultSearchFromDate, $defaultSearchToDate, $order_field, $order_type, $fromDate=null, $toDate=null, $primeEntryBookId=null, $chartOfAccountId=null, $locationId=null, $payeePayerId=null, $retriveAllRecords=null) {
		$this->db->order_by('acm_bookkeeping_gl_transactions.' . $order_field, $order_type);
		$this->db->join('acm_bookkeeping_journal_entries', 'acm_bookkeeping_journal_entries.journal_entry_id=acm_bookkeeping_gl_transactions.journal_entry_id','left');
		$this->db->join('ogm_admin_locations', 'ogm_admin_locations.location_id=acm_bookkeeping_journal_entries.location_id','left');

		if ($defaultSearchFromDate != '' && $defaultSearchToDate != '') {
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date >=', $defaultSearchFromDate);
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date <=', $defaultSearchToDate);
		}
		
		if($fromDate) {
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date >=', $fromDate);
		}

		if($toDate) {
			$this->db->where('acm_bookkeeping_journal_entries.transaction_date <=', $toDate);
		}

		if($primeEntryBookId) {
			$this->db->where('acm_bookkeeping_journal_entries.prime_entry_book_id', $primeEntryBookId);
		}

		if($chartOfAccountId) {
			$this->db->where('acm_bookkeeping_gl_transactions.chart_of_account_id', $chartOfAccountId);
		}

		if($locationId) {
			$this->db->where_in('acm_bookkeeping_journal_entries.location_id', $locationId);
		}
		
		if($payeePayerId) {
			$this->db->where_in('acm_bookkeeping_journal_entries.payee_payer_id', $payeePayerId);
		}
		
		if($retriveAllRecords == '') {
			$this->db->where('acm_bookkeeping_journal_entries.reference_journal_entry_id =0');
		}
		
		if ($chartOfAccountId == '104') {
			$this->db->where('acm_bookkeeping_gl_transactions.transaction_complete =','Yes');
		}
		
		$this->db->where('acm_bookkeeping_gl_transactions.last_action_status !=','deleted');

		$this->db->limit(10000000);
		
		$query = $this->db->get('acm_bookkeeping_gl_transactions');
		
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function isLocationFieldUsed() {
		$this->db->where("location_id != ''");
		$query = $this->db->get('acm_bookkeeping_journal_entries');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getFilteredJournalEntries($accountingMethod, $fromDate=null, $toDate=null, $generateAs=null, $locationId=null, 
                    $chartOfAccountId=null, $onlyCompletedTransactions=null, $specialChartOfAccountsToCheckCompletedTransactionsStatus=null, $doNotUseGroupBy=null) {
		
		if ($accountingMethod == "Cash") {
			
            $journalEntries = $this->getAllJournalEntries($fromDate, $toDate, 'journal_entry_id', 'asc', $locationId);
            
            $finalArray = array();
            
            if ($journalEntries && sizeof($journalEntries) > 0) {
                
                $mustExcludeJournalEntryReferenceNo = array();
                
                foreach($journalEntries as $journalEntry) {
                    if ($journalEntry->remark == "OB") {
                        $conditionOB ="SELECT GLTransaction.gl_transaction_id, GLTransaction.chart_of_account_id, GLTransaction.journal_entry_id, GLTransaction.prime_entry_book_id, ChartOfAccount.parent_id, GLTransaction.debit_value AS debit_amount, "
                            ."GLTransaction.credit_value AS credit_amount, GLTransaction.transaction_complete AS transaction_complete "
                            ."FROM `acm_bookkeeping_gl_transactions` AS GLTransaction "
                            ."LEFT JOIN acm_admin_chart_of_accounts AS ChartOfAccount ON GLTransaction.chart_of_account_id = ChartOfAccount.chart_of_account_id "
                            ."LEFT JOIN acm_bookkeeping_journal_entries AS JournalEntry ON GLTransaction.journal_entry_id = JournalEntry.journal_entry_id "
                            ."WHERE GLTransaction.last_action_status != 'deleted' "
                            . "AND GLTransaction.journal_entry_id = " . $journalEntry->journal_entry_id;

                        $queryOB = $this->db->query($conditionOB);
                        if ($queryOB->num_rows() > 0) {
                            $resultOB = $queryOB->result_array();
                            
                            if ($resultOB && sizeof($resultOB) > 0) {
                                foreach($resultOB as $row) {
                                    if ($onlyCompletedTransactions != '' && $row['transaction_complete'] == $onlyCompletedTransactions) {
                                        if (array_key_exists($row['chart_of_account_id'], $finalArray)) {
                                            $finalArray[$row['chart_of_account_id']]['debit_amount'] = $finalArray[$row['chart_of_account_id']]['debit_amount'] + $row['debit_amount'];
                                            $finalArray[$row['chart_of_account_id']]['credit_amount'] = $finalArray[$row['chart_of_account_id']]['credit_amount'] + $row['credit_amount'];
                                        } else {
                                            $finalArray[$row['chart_of_account_id']] = $row;
                                        }
                                    } else {
                                        if (array_key_exists($row['chart_of_account_id'], $finalArray)) {
                                            $finalArray[$row['chart_of_account_id']]['debit_amount'] = $finalArray[$row['chart_of_account_id']]['debit_amount'] + $row['debit_amount'];
                                            $finalArray[$row['chart_of_account_id']]['credit_amount'] = $finalArray[$row['chart_of_account_id']]['credit_amount'] + $row['credit_amount'];
                                        } else {
                                            $finalArray[$row['chart_of_account_id']] = $row;
                                        }
                                    }
                                }
                            }
                        }
                    } else if ($journalEntry->should_have_a_payment_journal_entry == "Yes") {
                        $mustExcludeJournalEntryReferenceNo[] = $journalEntry->reference_no;
                        
                        $referenceJournalEntries = $this->getReferenceJournalEntriesOfAJournalEntry($journalEntry->journal_entry_id);
                        
                        $referenceDebitTotal = 0;
                        $referenceCreditTotal = 0;
                        
                        if ($referenceJournalEntries && sizeof($referenceJournalEntries) > 0) {
                            foreach($referenceJournalEntries as $referenceJournalEntry) {
                                $mustExcludeJournalEntryReferenceNo[] = $referenceJournalEntry->reference_no;
                                
                                $referenceCondition ="SELECT GLTransaction.gl_transaction_id, GLTransaction.chart_of_account_id, GLTransaction.journal_entry_id, GLTransaction.prime_entry_book_id, ChartOfAccount.parent_id, GLTransaction.debit_value AS debit_amount, "
                                    ."GLTransaction.credit_value AS credit_amount, GLTransaction.transaction_complete AS transaction_complete "
                                    ."FROM `acm_bookkeeping_gl_transactions` AS GLTransaction "
                                    ."LEFT JOIN acm_admin_chart_of_accounts AS ChartOfAccount ON GLTransaction.chart_of_account_id = ChartOfAccount.chart_of_account_id "
                                    ."LEFT JOIN acm_bookkeeping_journal_entries AS JournalEntry ON GLTransaction.journal_entry_id = JournalEntry.journal_entry_id "
                                    ."WHERE GLTransaction.last_action_status != 'deleted' "
                                    . "AND GLTransaction.journal_entry_id = " . $referenceJournalEntry->journal_entry_id;

                                $referenceQuery = $this->db->query($referenceCondition);
                                if ($referenceQuery->num_rows() > 0) {
                                    $referenceResult = $referenceQuery->result_array();

                                    if ($referenceResult && sizeof($referenceResult) > 0) {
                                        foreach($referenceResult as $row) {
                                            if ($onlyCompletedTransactions != '' && $row['transaction_complete'] == $onlyCompletedTransactions) {
                                                if (array_key_exists($row['chart_of_account_id'], $finalArray)) {
                                                    $referenceDebitTotal = $referenceDebitTotal + $row['debit_amount'];
                                                    $referenceCreditTotal = $referenceCreditTotal + $row['credit_amount'];

                                                    $finalArray[$row['chart_of_account_id']]['debit_amount'] = $finalArray[$row['chart_of_account_id']]['debit_amount'] + $row['debit_amount'];
                                                    $finalArray[$row['chart_of_account_id']]['credit_amount'] = $finalArray[$row['chart_of_account_id']]['credit_amount'] + $row['credit_amount'];
                                                } else {
                                                    $referenceDebitTotal = $referenceDebitTotal + $row['debit_amount'];
                                                    $referenceCreditTotal = $referenceCreditTotal + $row['credit_amount'];

                                                    $finalArray[$row['chart_of_account_id']] = $row;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                        $mainCondition ="SELECT GLTransaction.gl_transaction_id, GLTransaction.chart_of_account_id, GLTransaction.journal_entry_id, GLTransaction.prime_entry_book_id, ChartOfAccount.parent_id, GLTransaction.debit_value AS debit_amount, "
                            ."GLTransaction.credit_value AS credit_amount, GLTransaction.transaction_complete AS transaction_complete "
                            ."FROM `acm_bookkeeping_gl_transactions` AS GLTransaction "
                            ."LEFT JOIN acm_admin_chart_of_accounts AS ChartOfAccount ON GLTransaction.chart_of_account_id = ChartOfAccount.chart_of_account_id "
                            ."LEFT JOIN acm_bookkeeping_journal_entries AS JournalEntry ON GLTransaction.journal_entry_id = JournalEntry.journal_entry_id "
                            ."WHERE GLTransaction.last_action_status != 'deleted' "
                            . "AND GLTransaction.journal_entry_id = " . $journalEntry->journal_entry_id;

                        $mainQuery = $this->db->query($mainCondition);
                        if ($mainQuery->num_rows() > 0) {
                            $mainResult = $mainQuery->result_array();
                            
                            if ($mainResult && sizeof($mainResult) > 0) {
                                foreach($mainResult as $row) {
                                    if ($onlyCompletedTransactions != '' && $row['transaction_complete'] == $onlyCompletedTransactions) {
                                        if ($row['debit_amount'] != '0.00') {
                                            $row['debit_amount'] = $referenceDebitTotal;
                                        }

                                        if ($row['credit_amount'] != '0.00') {
                                            $row['credit_amount'] = $referenceCreditTotal;
                                        }

                                        if (array_key_exists($row['chart_of_account_id'], $finalArray)) {
                                            $finalArray[$row['chart_of_account_id']]['debit_amount'] = $finalArray[$row['chart_of_account_id']]['debit_amount'] + $row['debit_amount'];
                                            $finalArray[$row['chart_of_account_id']]['credit_amount'] = $finalArray[$row['chart_of_account_id']]['credit_amount'] + $row['credit_amount'];
                                        } else {
                                            $finalArray[$row['chart_of_account_id']] = $row;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if (!in_array($journalEntry->reference_no, $mustExcludeJournalEntryReferenceNo)) {
                            $otherCondition ="SELECT GLTransaction.gl_transaction_id, GLTransaction.chart_of_account_id, GLTransaction.journal_entry_id, GLTransaction.prime_entry_book_id, ChartOfAccount.parent_id, GLTransaction.debit_value AS debit_amount, "
                                ."GLTransaction.credit_value AS credit_amount, GLTransaction.transaction_complete AS transaction_complete "
                                ."FROM `acm_bookkeeping_gl_transactions` AS GLTransaction "
                                ."LEFT JOIN acm_admin_chart_of_accounts AS ChartOfAccount ON GLTransaction.chart_of_account_id = ChartOfAccount.chart_of_account_id "
                                ."LEFT JOIN acm_bookkeeping_journal_entries AS JournalEntry ON GLTransaction.journal_entry_id = JournalEntry.journal_entry_id "
                                ."WHERE GLTransaction.last_action_status != 'deleted' "
                                . "AND GLTransaction.journal_entry_id = " . $journalEntry->journal_entry_id;

                            $otherQuery = $this->db->query($otherCondition);
                            if ($otherQuery->num_rows() > 0) {
                                $otherResult = $otherQuery->result_array();

                                if ($otherResult && sizeof($otherResult) > 0) {
                                    foreach($otherResult as $row) {
                                        if ($onlyCompletedTransactions != '' && $row['transaction_complete'] == $onlyCompletedTransactions) {
                                            if (array_key_exists($row['chart_of_account_id'], $finalArray)) {
                                                $finalArray[$row['chart_of_account_id']]['debit_amount'] = $finalArray[$row['chart_of_account_id']]['debit_amount'] + $row['debit_amount'];
                                                $finalArray[$row['chart_of_account_id']]['credit_amount'] = $finalArray[$row['chart_of_account_id']]['credit_amount'] + $row['credit_amount'];
                                            } else {
                                                $finalArray[$row['chart_of_account_id']] = $row;
                                            }
                                        } else {
                                            if (array_key_exists($row['chart_of_account_id'], $finalArray)) {
                                                $finalArray[$row['chart_of_account_id']]['debit_amount'] = $finalArray[$row['chart_of_account_id']]['debit_amount'] + $row['debit_amount'];
                                                $finalArray[$row['chart_of_account_id']]['credit_amount'] = $finalArray[$row['chart_of_account_id']]['credit_amount'] + $row['credit_amount'];
                                            } else {
                                                $finalArray[$row['chart_of_account_id']] = $row;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            return $finalArray;
            
		} else {
            if ($doNotUseGroupBy == "No") {
                $condition = "SELECT GLTransaction.chart_of_account_id, ChartOfAccount.parent_id, SUM(GLTransaction.debit_value) AS debit_amount, "
                            ."SUM(GLTransaction.credit_value) AS credit_amount, GLTransaction.transaction_complete AS transaction_complete "
                            ."FROM `acm_bookkeeping_gl_transactions` AS GLTransaction "
                            ."LEFT JOIN acm_admin_chart_of_accounts AS ChartOfAccount ON GLTransaction.chart_of_account_id = ChartOfAccount.chart_of_account_id "
                            ."LEFT JOIN acm_bookkeeping_journal_entries AS JournalEntry ON GLTransaction.journal_entry_id = JournalEntry.journal_entry_id "
                            ."WHERE GLTransaction.last_action_status != 'deleted' ";
            } else {
                $condition = "SELECT GLTransaction.chart_of_account_id, ChartOfAccount.parent_id, GLTransaction.debit_value AS debit_amount, "
                            ."GLTransaction.credit_value AS credit_amount, GLTransaction.transaction_complete AS transaction_complete "
                            ."FROM `acm_bookkeeping_gl_transactions` AS GLTransaction "
                            ."LEFT JOIN acm_admin_chart_of_accounts AS ChartOfAccount ON GLTransaction.chart_of_account_id = ChartOfAccount.chart_of_account_id "
                            ."LEFT JOIN acm_bookkeeping_journal_entries AS JournalEntry ON GLTransaction.journal_entry_id = JournalEntry.journal_entry_id "
                            ."WHERE GLTransaction.last_action_status != 'deleted' ";
            }
			
			if ($onlyCompletedTransactions != "") {
				$condition .= " AND GLTransaction.transaction_complete = '" . $onlyCompletedTransactions . "'";
			}
            
            if ($locationId != '' && $fromDate != '' && $toDate != '') {
                $condition .= " AND GLTransaction.transaction_date >= '" . $fromDate . "' AND "
                             ."GLTransaction.transaction_date <= '" . $toDate . "' AND "
                             ."JournalEntry.location_id = '" . $locationId . "'";
            } else if ($fromDate != '' && $toDate != '') {
                $condition .= " AND GLTransaction.transaction_date >= '" . $fromDate . "' AND "
                             ."GLTransaction.transaction_date <= '" . $toDate . "'";
            } else if ($toDate != '') {
                $condition .= " AND GLTransaction.transaction_date <= '" . $toDate . "'";
            }

            if ($chartOfAccountId != '') {
                $condition .= " AND GLTransaction.chart_of_account_id = '" . $chartOfAccountId . "'";
            }

            if ($doNotUseGroupBy == "No") {
                $condition .=" GROUP BY GLTransaction.chart_of_account_id";
            }
            
            $query = $this->db->query($condition);
            //echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                
                $result = $query->result_array();
                
                $intermediateResult = array();
                if ($specialChartOfAccountsToCheckCompletedTransactionsStatus != '' && sizeof($specialChartOfAccountsToCheckCompletedTransactionsStatus) > 0) {
                    if ($result && sizeof($result) > 0) {
                        foreach($result as $row) {
                            if (in_array($row['chart_of_account_id'], $specialChartOfAccountsToCheckCompletedTransactionsStatus)) {
                                if ($row['transaction_complete'] == "No") {
                                    $intermediateResult[] = $row;
                                }
                            } else {
                                if ($row['transaction_complete'] == "Yes") {
                                    $intermediateResult[] = $row;
                                }
                            }
                        }
                    }
                } else {
                    $intermediateResult = $result;
                }
                
                return $intermediateResult;
            } else {
                return false;
            }
		}
	}
    
    public function getFilteredJournalEntriesOfParentChartOfAccount($fromDate=null, $toDate=null, $locationId=null, $parentChartOfAccountId=null, 
                        $onlyCompletedTransactions=null, $specialChartOfAccountsToCheckCompletedTransactionsStatus=null, $chartofAccountId=null) {
		
        $condition = "SELECT GLTransaction.gl_transaction_id, GLTransaction.chart_of_account_id, GLTransaction.journal_entry_id, GLTransaction.prime_entry_book_id, ChartOfAccount.parent_id, GLTransaction.debit_value AS debit_amount, "
                    ."GLTransaction.credit_value AS credit_amount, GLTransaction.transaction_complete AS transaction_complete "
                    ."FROM `acm_bookkeeping_gl_transactions` AS GLTransaction "
                    ."LEFT JOIN acm_admin_chart_of_accounts AS ChartOfAccount ON GLTransaction.chart_of_account_id = ChartOfAccount.chart_of_account_id "
                    ."LEFT JOIN acm_bookkeeping_journal_entries AS JournalEntry ON GLTransaction.journal_entry_id = JournalEntry.journal_entry_id "
                    ."WHERE GLTransaction.last_action_status != 'deleted'";

        if ($onlyCompletedTransactions != "") {
            $condition .= " AND GLTransaction.transaction_complete = '" . $onlyCompletedTransactions . "'";
        }
        
        if ($chartofAccountId != '') {
            $condition .= " AND GLTransaction.chart_of_account_id = '" . $chartofAccountId . "'";
        }

		if ($locationId != '' && $fromDate != '' && $toDate != '') {
			$condition .= " AND GLTransaction.transaction_date >= '" . $fromDate . "' AND "
						 ."GLTransaction.transaction_date <= '" . $toDate . "' AND "
						 ."JournalEntry.location_id = '" . $locationId . "'";
		} else if ($fromDate != '' && $toDate != '') {
			$condition .= " AND GLTransaction.transaction_date >= '" . $fromDate . "' AND "
						 ."GLTransaction.transaction_date <= '" . $toDate . "'";
		}
		
		//echo $condition;die;
		$query = $this->db->query($condition);
		if ($query->num_rows() > 0) {
            
            $result = $query->result_array();
            
            $intermediateResult = array();
            if ($specialChartOfAccountsToCheckCompletedTransactionsStatus != '' && sizeof($specialChartOfAccountsToCheckCompletedTransactionsStatus) > 0) {
                if ($result && sizeof($result) > 0) {
                    foreach($result as $row) {
                        if (in_array($row['chart_of_account_id'], $specialChartOfAccountsToCheckCompletedTransactionsStatus)) {
                            if ($row['transaction_complete'] == "No") {
                                $intermediateResult[] = $row;
                            }
                        } else {
                            if ($row['transaction_complete'] == "Yes") {
                                $intermediateResult[] = $row;
                            }
                        }
                    }
                }
            } else {
                $intermediateResult = $result;
            }

            if ($parentChartOfAccountId != '') {
                
                $childChartOfAccounts = $this->chart_of_accounts_model->getChildren($parentChartOfAccountId);

                $childChartOfAccountsArray = array();
                if ($childChartOfAccounts && sizeof($childChartOfAccounts) > 0) {
                    foreach ($childChartOfAccounts as $row) {

                        $newParentChartOfAccountId = $row['chart_of_account_id'];

                        $subChildChartOfAccounts = $this->chart_of_accounts_model->getChildren($newParentChartOfAccountId);

                        if ($subChildChartOfAccounts && sizeof($subChildChartOfAccounts) > 0) {
                            foreach ($subChildChartOfAccounts as $childRow) {

                                $childChartOfAccountsArray[] = $childRow['chart_of_account_id'];
                            }
                        } else {
                            $childChartOfAccountsArray[] = $newParentChartOfAccountId;
                        }
                    }
                }

                $intermediateArray = array();

                foreach ($intermediateResult as $record) {

                    if (in_array($record['chart_of_account_id'], $childChartOfAccountsArray)) {

                        $intermediateArray[] = $record;
                    }
                }
            } else {
                $intermediateArray = $intermediateResult;
            }

            $finalArray = array();

            foreach ($intermediateArray as $record) {

                if (array_key_exists($record['chart_of_account_id'], $finalArray)) {
                    $finalArray[$record['chart_of_account_id']]['debit_amount'] = $finalArray[$record['chart_of_account_id']]['debit_amount'] + $record['debit_amount'];
                    $finalArray[$record['chart_of_account_id']]['credit_amount'] = $finalArray[$record['chart_of_account_id']]['credit_amount'] + $record['credit_amount'];
                } else {
                    $finalArray[$record['chart_of_account_id']] = $record;
                }
            }

            return $finalArray;
		} else {
			return false;
		}
	}

	public function getGeneralLedgerTransactionsByJournalEntryIdAndPrimeEntryBookId($journalEntryId, $primeEntryBookId) {
		$this->db->where('journal_entry_id', $journalEntryId);
		$this->db->where('prime_entry_book_id', $primeEntryBookId);
		$this->db->limit(100000);
		$query = $this->db->get('acm_bookkeeping_gl_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReferenceJournalEntriesOfAJournalEntry($journalEntryId) {
		$this->db->where('reference_journal_entry_id', $journalEntryId);
        $this->db->where('acm_bookkeeping_journal_entries.last_action_status !=','deleted');
		$query = $this->db->get('acm_bookkeeping_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getGeneralLedgerTransactionCreditRecordByJournalEntryId($id) {
		$this->db->where('journal_entry_id', $id);
		$this->db->where('credit_value !=', '0');

		$this->db->limit(100000);
		$query = $this->db->get('acm_bookkeeping_gl_transactions');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getJournalEntryClaimReferences($journalEntryId) {
        $this->db->where('journal_entry_id', $journalEntryId);
        $this->db->where('acm_bookkeeping_journal_entry_claim_references.last_action_status !=','deleted');
		$query = $this->db->get('acm_bookkeeping_journal_entry_claim_references');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
    }
    
    public function getAccountOpeningBalancesForLocation($locationId) {
        $this->db->where('location_id', $locationId);
        $this->db->where('remark', "OB");
        $this->db->where('acm_bookkeeping_journal_entries.last_action_status !=','deleted');
		$query = $this->db->get('acm_bookkeeping_journal_entries');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
    }
}
