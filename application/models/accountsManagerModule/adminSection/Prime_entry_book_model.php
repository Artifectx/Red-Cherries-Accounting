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

class Prime_entry_book_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function addPrimeEntryBook($data) {
		$this->db->insert('acm_admin_prime_entry_books', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}

	public function editPrimeEntryBook($id, $data) {
		$this->db->where('prime_entry_book_id', $id);
		$this->db->update('acm_admin_prime_entry_books', $data);
		$this->db->limit(1);
		return true;
	}

	public function addPrimeEntryBookChartOfAccount($data) {
		$this->db->insert('acm_admin_prime_entry_book_chart_of_accounts', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}

	public function dropPrimeEntryBookChartOfAccounts($id) {
		$this->db->where('prime_entry_book_id', $id);
		$this->db->limit(10000);
		$this->db->delete('acm_admin_prime_entry_book_chart_of_accounts');
		//echo $this->db->last_query();die;
	}

	public function deletePrimeEntryBook($id, $status, $user_id) {
		$this->db->where('prime_entry_book_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('acm_admin_prime_entry_books');
		$this->db->limit(1);
		return true;
	}

	public function deletePrimeEntryBookChartOfAccounts($id, $status, $user_id) {
		$this->db->where('prime_entry_book_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->update('acm_admin_prime_entry_book_chart_of_accounts');
		$this->db->limit(1000);
		return true;
	}

	public function getAllPrimeEntryBooks($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$this->db->where('last_action_status !=','deleted');
		$query = $this->db->get('acm_admin_prime_entry_books');
		
		if ($query->num_rows() > 0) {
			$primeEntryBooks = $query->result();

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

			$finalPrimeEntryBooks = array();
			
			if ($notAccessiblePrimeEntryBooks && sizeof($notAccessiblePrimeEntryBooks) > 0) {
				if ($primeEntryBooks && sizeof($primeEntryBooks) > 0) {
					foreach($primeEntryBooks as $primeEntryBook) {
						if (!in_array($primeEntryBook->prime_entry_book_id, $notAccessiblePrimeEntryBooks)) {
							$finalPrimeEntryBooks[] = $primeEntryBook;
						}
					}
				}
			} else {
				$finalPrimeEntryBooks = $primeEntryBooks;
			}
			
			return $finalPrimeEntryBooks;
		} else {
			return false;
		}
	}

	public function getPrimeEntryBookById($id) {
		$this->db->where('prime_entry_book_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('acm_admin_prime_entry_books');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($id) {
		$this->db->where('prime_entry_book_id', $id);
		$this->db->limit(100000);
		$query = $this->db->get('acm_admin_prime_entry_book_chart_of_accounts');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function checkExisting($name) {
		$this->db->where('prime_entry_book_name', $name);
		$this->db->where('last_action_status !=','deleted');
		$this->db->limit(1);
		$query = $this->db->get('acm_admin_prime_entry_books');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllPrimeEntryBooksToDropDown($moduleArray) {
		$data = $this->getAllPrimeEntryBooks('prime_entry_book_name','asc');

		$primeEntryBookList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
                if (in_array($dataElement->applicable_module_id, $moduleArray)) {
                    $primeEntryBookList[$dataElement->prime_entry_book_id] = $dataElement->prime_entry_book_name;
                }
			}
		}

		$this->optionList = '';

		foreach($primeEntryBookList as $key => $prime_entry_book_name) {
			$this->optionList .= '<option value=' . $key . '>' . $prime_entry_book_name . '</option>';
		}

		$html = "<select class='select2 form-control' id='prime_entry_book_id' onchange='handlePrimeEntryBookSelect(this.id)'>
					{$this->optionList}
				 </select>";

		echo $html;
	}

	public function getAllPrimeEntryBooksToDropDownWithSavedOption($selectedIndex) {
		$data=$this->getAllPrimeEntryBooks('prime_entry_book_name','asc');

		$primeEntryBookList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$primeEntryBookList[$dataElement->prime_entry_book_id] = $dataElement->prime_entry_book_name;
			}
		}

		$this->optionList = '';

		foreach($primeEntryBookList as $key => $prime_entry_book_name) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $prime_entry_book_name . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $prime_entry_book_name . '</option>';
			}
		}

		return $this->optionList;
	}
}
