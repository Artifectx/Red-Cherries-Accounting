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

class Common_functions {
    
	public function  __construct() {
		
		$this->CI =& get_instance();
        
        //get database
		$session_data = $this->CI->session->userdata('logged_in_stock');
		$this->database = $session_data['database'];
        
        $params = array('databaseName' => $this->database);
		$this->CI->load->library('user_library/User_management', $params);

		$this->userManagement = new User_management($params);
		
		//get user permission
		$this->CI->data = $this->CI->userManagement->getUserPermissions($this->CI->data);

		$this->CI->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->CI->load->model('systemManagerModule/system_configurations_model', '', TRUE);

		$this->CI->load->helper('language');
	}

	public function getSuppliersToDropDownWithSavedOption($selectedIndex, $field) {
		$optionList = $this->CI->peoples_model->getSuppliersToDropDownWithSavedOption($selectedIndex, $field);

		return $optionList;
	}

	public function getAgentsToDropDownWithSavedOption($selectedIndex, $field, $category, $deliveryRouteId=null) {
		$optionList = $this->CI->peoples_model->getAgentsToDropDownWithSavedOption($selectedIndex, $field, $category, $deliveryRouteId);

		return $optionList;
	}

	public function getCustomersToDropDownWithSavedOption($selectedIndex, $field, $category, $deliveryRouteId=null) {
		$optionList = $this->CI->peoples_model->getCustomersToDropDownWithSavedOption($selectedIndex, $field, $category, $deliveryRouteId);

		return $optionList;
	}

	public function getDriversToDropDownWithSavedOption($selectedIndex, $field) {
		$optionList = $this->CI->peoples_model->getDriversToDropDownWithSavedOption($selectedIndex, $field);

		return $optionList;
	}

	public function compareUsortElements ($a, $b) {
		return strcmp($a->action_date, $b->action_date);
	}
	
	public function getNotAccessiblePrimeEntryBooksOfAUser() {
		
		$notAccessiblePrimeEntryBooks = $this->CI->user_model->getNotAccessiblePrimeEntryBooksOfAUser($this->CI->user_id);
		
		return $notAccessiblePrimeEntryBooks;
	}
    
    public function getReferenceTransactionTypesToDropDown() {
		$html = "  <select class='form-control' name='reference_transaction_type_id' id='reference_transaction_type_id' onchange='handleReferenceTransactionTypeSelect(this.id);'>
					<option value='0'>{$this->CI->lang->line('-- Select --')}</option>";
				
            if ($this->CI->system_configurations_model->isBookkeepingPurchaseNoteEnabled()) {
		$html .= "		<option value='1'>{$this->CI->lang->line('Purchase Note')}</option>";
			}
                    
			if ($this->CI->system_configurations_model->isBookkeepingSalesNoteEnabled()) {
		$html .= "		<option value='2'>{$this->CI->lang->line('Sales Note')}</option>";
			}
            
            if ($this->CI->system_configurations_model->isBookkeepingSupplierReturnNoteEnabled()) {
		$html .= "		<option value='3'>{$this->CI->lang->line('Supplier Return Note')}</option>";
			}
            
            if ($this->CI->system_configurations_model->isBookkeepingCustomerReturnNoteEnabled()) {
		$html .= "		<option value='4'>{$this->CI->lang->line('Customer Return Note')}</option>";
			}
					
		$html .= "		<option value='5'>{$this->CI->lang->line('Other')}</option>
				</select>"; 
					
		return $html;
	}
	
	public function getReferenceTransactionTypesToDropDownWithSavedOption($selectedIndex) {
		$html = "  <select class='form-control' name='reference_transaction_type_id' id='reference_transaction_type_id' onchange='handleReferenceTransactionTypeSelect(this.id);'>
					<option value='0'>{$this->CI->lang->line('-- Select --')}</option>";
				
            if ($this->CI->system_configurations_model->isBookkeepingPurchaseNoteEnabled()) {
					if ($selectedIndex == "1") {
			$html .= "		<option value='1' selected>{$this->CI->lang->line('Purchase Note')}</option>";
					} else {
			$html .= "		<option value='1'>{$this->CI->lang->line('Purchase Note')}</option>";			
					}
			}
                    
			if ($this->CI->system_configurations_model->isBookkeepingSalesNoteEnabled()) {
					if ($selectedIndex == "2") {
			$html .= "		<option value='2' selected>{$this->CI->lang->line('Sales Note')}</option>";
					} else {
			$html .= "		<option value='2'>{$this->CI->lang->line('Sales Note')}</option>";			
					}
			}
            
            if ($this->CI->system_configurations_model->isBookkeepingSupplierReturnNoteEnabled()) {
					if ($selectedIndex == "3") {
			$html .= "		<option value='3' selected>{$this->CI->lang->line('Supplier Return Note')}</option>";
					} else {
			$html .= "		<option value='3'>{$this->CI->lang->line('Supplier Return Note')}</option>";			
					}
			}
            
            if ($this->CI->system_configurations_model->isBookkeepingCustomerReturnNoteEnabled()) {
					if ($selectedIndex == "4") {
			$html .= "		<option value='4' selected>{$this->CI->lang->line('Customer Return Note')}</option>";
					} else {
			$html .= "		<option value='4'>{$this->CI->lang->line('Customer Return Note')}</option>";			
					}
			}
					
					if ($selectedIndex == "5") {
			$html .= "		<option value='5' selected>{$this->CI->lang->line('Other')}</option>";
					} else {
			$html .= "		<option value='5'>{$this->CI->lang->line('Other')}</option>";			
					}
	$html .= "		</select>"; 
					
		return $html;
	}
}