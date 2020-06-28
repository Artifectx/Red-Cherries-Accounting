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

class System_configurations_model extends CI_Model {

	public function updateConfigurationField($key, $data) {
		$this->db->where('config_filed_name', $key);
		$this->db->limit(1);
		$this->db->update('system_common_configurations', $data);
		return true;
	}

	public function saveConfigurationField($data) {
		$this->db->limit(1);
		$this->db->insert('system_common_configurations', $data);
		return true;
	}

	public function deleteConfigurationField($key, $user_id) {
		$this->db->where('config_filed_name', $key);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->delete('system_common_configurations');
		return true;
	}
	
	public function deleteConfigurationFieldWithLike($key, $user_id) {
		$this->db->like('config_filed_name', $key);
		$this->db->set('actioned_user_id', $user_id);
		$this->db->limit(1000);
		$this->db->delete('system_common_configurations');
		return true;
	}

	public function getSystemConfigData() {
		$this->db->limit(10000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getByFieldAndValue($field, $value) {
		$this->db->where('config_filed_name', $field);
		$this->db->where('config_filed_value', $value);
		$this->db->limit(1);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAgentCategories() {
		$this->db->where('config_filed_name', 'ppl_agent_category');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAgentCategory($agentCategory) {
		$this->db->where('config_filed_name', 'ppl_agent_category');
		$this->db->where('config_filed_value', $agentCategory);
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCustomerCategories() {
		$this->db->where('config_filed_name', 'ppl_customer_category');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCustomerCategory($customerCategory) {
		$this->db->where('config_filed_name', 'ppl_agent_category');
		$this->db->where('config_filed_value', $customerCategory);
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAgentCategoriesAsOptionList() {
		$data = $this->getAgentCategories();

		$agentCategoryList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$agentCategoryList['Agent - ' . $dataElement->config_filed_value] = $dataElement->config_filed_value;
			}
		}

		$this->optionList = '';

		foreach($agentCategoryList as $key => $agentCategory) {
			$this->optionList .= '<option value="' . $key . '">' . $agentCategory . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getAgentCategoriesAsOptionListWithSavedOption($selectedOption) {
		$data = $this->getAgentCategories();

		$agentCategoryList = array("" => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$agentCategoryList["Agent - " . trim($dataElement->config_filed_value)] = $dataElement->config_filed_value;
			}
		}

		$this->optionList = '';

		foreach($agentCategoryList as $key => $agentCategory) {
			if($key == "Agent - " . trim($selectedOption)) {
				$this->optionList .= '<option value="' . $key . '" selected="selected">' . $agentCategory . '</option>';
			} else {
				 if ($key == '') {
					$this->optionList .= '<option value=0>' . $agentCategory . '</option>';
				 } else {
					  $this->optionList .= '<option value="' . $key . '">' . $agentCategory . '</option>';
				 }
			}
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getCustomerCategoriesAsOptionList() {
		$data = $this->getCustomerCategories();

		$customerCategoryList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$customerCategoryList['Customer - ' . $dataElement->config_filed_value] = $dataElement->config_filed_value;
			}
		}

		$this->optionList = '';

		foreach($customerCategoryList as $key => $customerCategory) {
			$this->optionList .= '<option value="' . $key . '">' . $customerCategory . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getCustomerCategoriesAsOptionListWithSavedOption($selectedOption) {
		$data = $this->getCustomerCategories();

		$customerCategoryList = array('' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$customerCategoryList["Customer - " . $dataElement->config_filed_value] = $dataElement->config_filed_value;
			}
		}

		$this->optionList = '';

		foreach($customerCategoryList as $key => $customerCategory) {
			if($key == "Customer - " . $selectedOption) {
				$this->optionList .= '<option value="' . $key . '" selected="selected">' . $customerCategory . '</option>';
			} else {
				if ($key == '') {
					$this->optionList .= '<option value=0>' . $customerCategory . '</option>';
				 } else {
					  $this->optionList .= '<option value="' . $key . '">' . $customerCategory . '</option>';
				 }
			}
		}

		$optionList = $this->optionList;

		return $optionList;
	}

	public function getDefaultCustomerCategoryToAddNewCustomer() {
		$this->db->where('config_filed_name', 'ppl_default_customer_category_to_add_new_customer');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
	public function isAccountsManagementForLocationsEnabled() {
		$this->db->where('config_filed_name', 'accounts_management_for_locations');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

    public function getOpeninngBalanceEquityChartOfAccountConfigurationData() {
		$this->db->where('config_filed_name', 'opening_balance_equity_chart_of_account');
		$this->db->limit(1);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getCashAndCashEquivalentsChartOfAccountConfigurationData() {
		$this->db->where('config_filed_name', 'acm_cash_and_cash_equivalents_report_main_chart_of_account');
		$this->db->limit(1);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsTrialBalanceConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_trial_balance_account_display_order');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsBalanceSheetNonCurrentAssetsConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_balance_sheet_non_current_assets_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsBalanceSheetCurrentAssetsConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_balance_sheet_current_assets_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsBalanceSheetEquityConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_balance_sheet_equity_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsBalanceSheetNonCurrentLiabilitiesConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_balance_sheet_non_current_liabilities_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsBalanceSheetCurrentLiabilitiesConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_balance_sheet_current_liabilities_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsProfitAndLossRevenueCalculatingConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_profit_and_loss_revenue_calculating_chart_of_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsProfitAndLossGrossProfitCalculatingConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_profit_and_loss_gross_profit_calculating_chart_of_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsProfitAndLossOperatingActivitiesCalculatingConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_profit_and_loss_operating_activities_calculating_chart_of_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsProfitAndLossProfitCalculatingConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_profit_and_loss_profit_calculating_chart_of_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReportsProfitAndLossNetProfitCalculatingConfigurationData() {
		$this->db->where('config_filed_name', 'accounts_profit_and_loss_net_profit_calculating_chart_of_accounts_list');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getTaxTypeAccountsPrimeEntryBooks($taxType) {
		$this->db->where('config_filed_name', 'ad_txtp_' . $taxType . '_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSystemVersionNumber() {
		$this->db->where('config_filed_name', 'red_cherries_os_version_number');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$versionNumber = $result[0]->config_filed_value;
			$versionNumber = str_replace(".", "_", $versionNumber);
			$versionNumber = str_replace(" ", "_", $versionNumber);
			$versionNumber = strtolower($versionNumber);
			
			return $versionNumber;
		} else {
			return false;
		}
	}
	
	public function getFinancialYearStartMonthNo() {
		$this->db->where('config_filed_name', 'financial_year_start_month_no');
		$this->db->where('config_filed_value != ', '0');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$financialYearStartMonthNo = $result[0]->config_filed_value;
			return $financialYearStartMonthNo;
		} else {
			return false;
		}
	}
	
	public function getFinancialYearStartDayNo() {
		$this->db->where('config_filed_name', 'financial_year_start_day_no');
		$this->db->where('config_filed_value != ', '0');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$financialYearStartDayNo = $result[0]->config_filed_value;
			return $financialYearStartDayNo;
		} else {
			return false;
		}
	}
	
	public function getFinancialYearEndMonthNo() {
		$this->db->where('config_filed_name', 'financial_year_end_month_no');
		$this->db->where('config_filed_value != ', '0');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$financialYearStartMonthNo = $result[0]->config_filed_value;
			return $financialYearStartMonthNo;
		} else {
			return false;
		}
	}
	
	public function getFinancialYearEndDayNo() {
		$this->db->where('config_filed_name', 'financial_year_end_day_no');
		$this->db->where('config_filed_value != ', '0');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$financialYearStartDayNo = $result[0]->config_filed_value;
			return $financialYearStartDayNo;
		} else {
			return false;
		}
	}
	
	public function getCollectDonationAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'dod_cod_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBudgetIssueAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'dod_bis_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBudgetReturnAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'dod_brt_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getPrimeEntryBooksToUpdateForCollectDonationForProgramTransaction($programId) {
		$this->db->where('config_filed_name', 'dod_cod_accounts_prime_entry_book_for_program_id_' . $programId);
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getPrimeEntryBooksToUpdateForBudgetIssueForProgramTransaction($programId) {
		$this->db->where('config_filed_name', 'dod_bis_accounts_prime_entry_book_for_program_id_' . $programId);
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getPrimeEntryBooksToUpdateForBudgetReturnForProgramTransaction($programId) {
		$this->db->where('config_filed_name', 'dod_brt_accounts_prime_entry_book_for_program_id_' . $programId);
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getProgramWiseCollectDonationAccountsPrimeEntryBooks() {
		$this->db->like('config_filed_name', 'dod_cod_accounts_prime_entry_book_for_program_id_');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getProgramWiseBudgetIssueAccountsPrimeEntryBooks() {
		$this->db->like('config_filed_name', 'dod_bis_accounts_prime_entry_book_for_program_id_');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getProgramWiseBudgetReturnAccountsPrimeEntryBooks() {
		$this->db->like('config_filed_name', 'dod_brt_accounts_prime_entry_book_for_program_id_');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function isDonationProgramWiseChartOfAccountInformationEnabled() {
		$this->db->where('config_filed_name', 'dod_program_wise_chart_of_account_information');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getPurchaseNoteProductsAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'purchase_note_products_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getPurchaseNoteFreeIssuesAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'purchase_note_free_issues_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSalesNoteSalesEntryAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'sales_note_sales_entry_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSalesNoteCostEntryAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'sales_note_cost_entry_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSalesNoteFreeIssuesAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'sales_note_free_issues_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSalesNoteDiscountAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'sales_note_discount_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getCustomerSaleableReturnNoteSalesEntryAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'customer_saleable_return_note_sales_entry_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getCustomerSaleableReturnNoteCostEntryAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'customer_saleable_return_note_cost_entry_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getCustomerMarketReturnNoteSalesEntryAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'customer_market_return_note_sales_entry_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getCustomerMarketReturnNoteCostEntryAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'customer_market_return_note_cost_entry_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSupplierSaleableReturnNoteAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'supplier_saleable_return_note_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSupplierMarketReturnNoteAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'supplier_market_return_note_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReceivePaymentCashAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'receive_payment_cash_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getReceivePaymentChequeAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'receive_payment_cheque_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentChequeDepositAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'receive_payment_cheque_deposit_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentTransactionClaimPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'receive_payment_transaction_claim_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getMakePaymentTransactionClaimPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'make_payment_transaction_claim_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentCreditCardAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'receive_payment_credit_card_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentTransactionClaimAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'receive_payment_transaction_claim_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMakePaymentCashAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'make_payment_cash_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMakePaymentChequeAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'make_payment_cheque_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'make_payment_second_or_third_party_cheque_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getMakePaymentTransactionClaimAccountsPrimeEntryBooks() {
		$this->db->where('config_filed_name', 'make_payment_transaction_claim_accounts_prime_entry_book');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function isBookkeepingPurchaseNoteNumberAutoIncrementEnabled() {
		$this->db->where('config_filed_name', 'purchase_note_reference_no_auto_increment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingPurchaseNoteReferenceNoCode() {
		$this->db->where('config_filed_name', 'purchase_note_reference_no_starting_code');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingPurchaseNoteReferenceNoSeparator() {
		$this->db->where('config_filed_name', 'purchase_note_reference_no_separator');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingPurchaseNoteReferenceNoStartNumber() {
		$this->db->where('config_filed_name', 'purchase_note_reference_no_starting_number');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function isBookkeepingSalesNoteNumberAutoIncrementEnabled() {
		$this->db->where('config_filed_name', 'sales_note_reference_no_auto_increment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingSalesNoteReferenceNoCode() {
		$this->db->where('config_filed_name', 'sales_note_reference_no_starting_code');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingSalesNoteReferenceNoSeparator() {
		$this->db->where('config_filed_name', 'sales_note_reference_no_separator');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingSalesNoteReferenceNoStartNumber() {
		$this->db->where('config_filed_name', 'sales_note_reference_no_starting_number');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSalesProfitMargin() {
		$this->db->where('config_filed_name', 'sales_profit_margin_percentage');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return '0';
		}
	}
	
	public function isBookkeepingCustomerReturnNoteNumberAutoIncrementEnabled() {
		$this->db->where('config_filed_name', 'customer_return_note_reference_no_auto_increment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingCustomerReturnNoteReferenceNoCode() {
		$this->db->where('config_filed_name', 'customer_return_note_reference_no_starting_code');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingCustomerReturnNoteReferenceNoSeparator() {
		$this->db->where('config_filed_name', 'customer_return_note_reference_no_separator');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingCustomerReturnNoteReferenceNoStartNumber() {
		$this->db->where('config_filed_name', 'customer_return_note_reference_no_starting_number');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	
	
	
	public function isBookkeepingSupplierReturnNoteNumberAutoIncrementEnabled() {
		$this->db->where('config_filed_name', 'supplier_return_note_reference_no_auto_increment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingSupplierReturnNoteReferenceNoCode() {
		$this->db->where('config_filed_name', 'supplier_return_note_reference_no_starting_code');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingSupplierReturnNoteReferenceNoSeparator() {
		$this->db->where('config_filed_name', 'supplier_return_note_reference_no_separator');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingSupplierReturnNoteReferenceNoStartNumber() {
		$this->db->where('config_filed_name', 'supplier_return_note_reference_no_starting_number');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function isBookkeepingReceivePaymentNumberAutoIncrementEnabled() {
		$this->db->where('config_filed_name', 'receive_payment_reference_no_auto_increment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingReceivePaymentReferenceNoCode() {
		$this->db->where('config_filed_name', 'receive_payment_reference_no_starting_code');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingReceivePaymentReferenceNoSeparator() {
		$this->db->where('config_filed_name', 'receive_payment_reference_no_separator');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingReceivePaymentReferenceNoStartNumber() {
		$this->db->where('config_filed_name', 'receive_payment_reference_no_starting_number');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function forceToSelectAReferenceTransactionForReceiveAPayment() {
		$this->db->where('config_filed_name', 'bookkeeping_force_to_select_reference_transaction_for_receive_payment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function forceToSelectAReferenceTransactionForMakeAPayment() {
		$this->db->where('config_filed_name', 'bookkeeping_force_to_select_reference_transaction_for_make_payment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getMakeAPaymentDefaultPayeeType() {
		$this->db->where('config_filed_name', 'make_payment_default_payee_type');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return '';
		}
	}
    
    public function getMakeAPaymentDefaultReferenceTransactionType() {
		$this->db->where('config_filed_name', 'make_payment_default_reference_transaction_type');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return '';
		}
	}
    
    public function getReceiveAPaymentDefaultPayerType() {
		$this->db->where('config_filed_name', 'receive_payment_default_payer_type');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return '';
		}
	}
    
    public function getReceiveAPaymentDefaultReferenceTransactionType() {
		$this->db->where('config_filed_name', 'receive_payment_default_reference_transaction_type');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return '';
		}
	}
	
	public function isBookkeepingMakePaymentNumberAutoIncrementEnabled() {
		$this->db->where('config_filed_name', 'make_payment_reference_no_auto_increment');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function isMakePaymentSelectReferenceJournalEntryAutomaticallyEnabled() {
        $this->db->where('config_filed_name', 'make_payment_select_reference_journal_entry_automatically');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return "Yes";
		} else {
			return "No";
		}
    }
    
    public function isMakePaymentAllowPartialPaymentForReferenceTransactionsEnabled() {
        $this->db->where('config_filed_name', 'make_payment_allow_partial_payment_for_reference_transactions');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return "Yes";
		} else {
			return "No";
		}
    }
    
    public function isReceivePaymentSelectReferenceJournalEntryAutomaticallyEnabled() {
        $this->db->where('config_filed_name', 'receive_payment_select_reference_journal_entry_automatically');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return "Yes";
		} else {
			return "No";
		}
    }
    
    public function isReceivePaymentAllowPartialPaymentForReferenceTransactionsEnabled() {
        $this->db->where('config_filed_name', 'receive_payment_allow_partial_payment_for_reference_transactions');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return "Yes";
		} else {
			return "No";
		}
    }

    public function getBookkeepingMakePaymentReferenceNoCode() {
		$this->db->where('config_filed_name', 'make_payment_reference_no_starting_code');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingMakePaymentReferenceNoSeparator() {
		$this->db->where('config_filed_name', 'make_payment_reference_no_separator');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getBookkeepingMakePaymentReferenceNoStartNumber() {
		$this->db->where('config_filed_name', 'make_payment_reference_no_starting_number');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
    public function isBookkeepingPurchaseNoteEnabled() {
		$this->db->where('config_filed_name', 'bookkeeping_purchase_note');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
	public function isBookkeepingSalesNoteEnabled() {
		$this->db->where('config_filed_name', 'bookkeeping_sales_note');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
    public function isBookkeepingSupplierReturnNoteEnabled() {
		$this->db->where('config_filed_name', 'bookkeeping_supplier_return_note');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function isBookkeepingCustomerReturnNoteEnabled() {
		$this->db->where('config_filed_name', 'bookkeeping_customer_return_note');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
	public function isAddCustomerMarketReturnCostEntryWithProfitMarginEnabled() {
		$this->db->where('config_filed_name', 'add_customer_market_return_cost_entry_with_profit_margin');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getCustomerMarketReturnCostEntryProfitMarginCreditChartOfAccount() {
		$this->db->where('config_filed_name', 'customer_market_return_cost_entry_profit_margin_credit_account_id');
		$this->db->limit(1);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return false;
		}
	}
	
	public function getSaturdayCalendarDayType() {
		$this->db->where('config_filed_name', 'saturday_calendar_day_type_id');
		$this->db->limit(1);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return '0';
		}
	}
	
	public function getSundayCalendarDayType() {
		$this->db->where('config_filed_name', 'sunday_calendar_day_type_id');
		$this->db->limit(1);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return '0';
		}
	}

	public function isDisableUserSessionExpirationEnabled() {
		$this->db->where('config_filed_name', 'disable_user_session_expiration');
		$this->db->limit(1);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() == 1) {
			$result = $query->result();
			return $result[0]->config_filed_value;
		} else {
			return false;
		}
	}
	
    public function getMakePaymentDefaultPayeeType() {
		$this->db->where('config_filed_name', 'make_payment_default_payee_type');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getMakePaymentDefaultReferenceTransactionType() {
		$this->db->where('config_filed_name', 'make_payment_default_reference_transaction_type');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentDefaultPayerType() {
		$this->db->where('config_filed_name', 'receive_payment_default_payer_type');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function getReceivePaymentDefaultReferenceTransactionType() {
		$this->db->where('config_filed_name', 'receive_payment_default_reference_transaction_type');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function isAutomaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled() {
		$this->db->where('config_filed_name', 'automatically_mark_received_cheques_as_deposited_on_cheque_date');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function isAutomaticallyClearReceivedChequesAfterDepositedToBankEnabled() {
		$this->db->where('config_filed_name', 'automatically_clear_received_cheques_after_deposited_to_bank');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function isAutomaticallyClearPaidChequesOnChequeDateEnabled() {
		$this->db->where('config_filed_name', 'automatically_clear_paid_cheques_on_cheque_date');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function isPeopleAdditionAuthorizationFeatureEnabled() {
		$this->db->where('config_filed_name', 'ogm_people_addition_need_authorization');
		$this->db->where('config_filed_value', 'Yes');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function getCurrentPeopleAdditionAuthorizerData() {
		$this->db->where('config_filed_name', 'ogm_people_addition_authorizer_id');
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$peopleAdditionAuthorizerId = $result[0]->config_filed_value;
			return $peopleAdditionAuthorizerId;
		} else {
			return false;
		}
	}
    
    public function getCashAndCashEquivalentsReportChequeInHandChartOfAccount() {
		$this->db->where('config_filed_name', 'acm_cash_and_cash_equivalents_report_cheque_in_hand_chart_of_account');
		$this->db->limit(1000);
		$query = $this->db->get('system_common_configurations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}