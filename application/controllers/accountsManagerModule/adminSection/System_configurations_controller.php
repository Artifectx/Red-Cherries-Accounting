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

class System_configurations_controller extends CI_Controller {

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
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/purchase_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/sales_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/customer_return_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/supplier_return_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/receive_payment_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/make_payment_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

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

		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';
		$data_cls['li_class_system_config'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$data['systemConfigData'] = $this->getSystemConfigData();

		if(isset($this->data['ACM_Admin_View_System_Configurations_Permissions'])) {
			$this->load->view('web/accountsManagerModule/adminSection/systemConfigurations/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}

		$configData['purchase_note_in_use'] = $this->purchase_note_model->purchaseNoteInUse();
		$configData['sales_note_in_use'] = $this->sales_note_model->salesNoteInUse();
		$configData['customer_return_note_in_use'] = $this->customer_return_note_model->customerReturnNoteInUse();
		$configData['supplier_return_note_in_use'] = $this->supplier_return_note_model->supplierReturnNoteInUse();
		$configData['accounts_management_for_locations_use_status'] = $this->journal_entries_model->isLocationFieldUsed();
		$configData['receive_payment_in_use'] = $this->receive_payment_model->receivePaymentInUse();
		$configData['make_payment_in_use'] = $this->make_payment_model->makePaymentInUse();

		return $configData;
	}

	public function saveAdminGeneralConfigData () {
		$fyStartMonthNo = $this->db->escape_str($this->input->post('fy_start_month_no'));
		$fyStartDayNo = $this->db->escape_str($this->input->post('fy_start_day_no'));
		$fyEndMonthNo = $this->db->escape_str($this->input->post('fy_end_month_no'));
		$fyEndDayNo = $this->db->escape_str($this->input->post('fy_end_day_no'));
		$accountsManagementForLocations = $this->db->escape_str($this->input->post('accounts_management_for_locations'));
		$bookkeepingPurchaseNote = $this->db->escape_str($this->input->post('bookkeeping_purchase_note'));
		$bookkeepingSalesNote = $this->db->escape_str($this->input->post('bookkeeping_sales_note'));
		$bookkeepingCustomerReturnNote = $this->db->escape_str($this->input->post('bookkeeping_customer_return_note'));
		$bookkeepingSupplierReturnNote = $this->db->escape_str($this->input->post('bookkeeping_supplier_return_note'));
		$bookkeepingForceToSelectReferenceTransactionForReceivePayment = $this->db->escape_str($this->input->post('bookkeeping_force_to_select_reference_transaction_for_receive_payment'));
		$bookkeepingForceToSelectReferenceTransactionForMakePayment = $this->db->escape_str($this->input->post('bookkeeping_force_to_select_reference_transaction_for_make_payment'));

		$data = array(
			'config_filed_value' => $fyStartMonthNo,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("financial_year_start_month_no", $data);

		$data = array(
			'config_filed_value' => $fyStartDayNo,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("financial_year_start_day_no", $data);

		$data = array(
			'config_filed_value' => $fyEndMonthNo,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("financial_year_end_month_no", $data);

		$data = array(
			'config_filed_value' => $fyEndDayNo,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("financial_year_end_day_no", $data);

		if ($accountsManagementForLocations == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("accounts_management_for_locations", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("accounts_management_for_locations", $data);
		}
		
		if ($bookkeepingPurchaseNote == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_purchase_note", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_purchase_note", $data);
		}
		
		if ($bookkeepingSalesNote == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_sales_note", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_sales_note", $data);
		}
		
		if ($bookkeepingCustomerReturnNote == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_customer_return_note", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_customer_return_note", $data);
		}
		
		if ($bookkeepingSupplierReturnNote == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_supplier_return_note", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_supplier_return_note", $data);
		}
		
		if ($bookkeepingForceToSelectReferenceTransactionForReceivePayment == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_force_to_select_reference_transaction_for_receive_payment", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_force_to_select_reference_transaction_for_receive_payment", $data);
		}
		
		if ($bookkeepingForceToSelectReferenceTransactionForMakePayment == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_force_to_select_reference_transaction_for_make_payment", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("bookkeeping_force_to_select_reference_transaction_for_make_payment", $data);
		}
		
		echo 'ok';
	}
    
    public function saveFinancialYearEndsConfigData () {
		$parentLiabilitiesChartOfAccountId = $this->db->escape_str($this->input->post('parent_liabilities_chart_of_account'));
        $parentAssetsChartOfAccountId = $this->db->escape_str($this->input->post('parent_assets_chart_of_account'));
        $reatainedEarningsChartOfAccountId = $this->db->escape_str($this->input->post('retained_earnings_chart_of_account'));

        $data = array(
            'config_filed_value' => $parentLiabilitiesChartOfAccountId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("parent_liabilities_chart_of_account", $data);
        
        $data = array(
            'config_filed_value' => $parentAssetsChartOfAccountId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("parent_assets_chart_of_account", $data);
        
        $data = array(
            'config_filed_value' => $reatainedEarningsChartOfAccountId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("retained_earnings_chart_of_account", $data);
		
		echo 'ok';
	}
    
    public function saveOpeningBalancesConfigData () {
		$chartOfAccountId = $this->db->escape_str($this->input->post('opening_balance_equity_chart_of_account'));

        $data = array(
            'config_filed_value' => $chartOfAccountId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("opening_balance_equity_chart_of_account", $data);
		
		echo 'ok';
	}

	public function saveReportsTrialBalanceConfigData () {
		$chartOfAccountCategoryList = $this->db->escape_str($this->input->post('chart_of_account_category_id_list'));

		$this->system_configurations_model->deleteConfigurationField("accounts_trial_balance_account_display_order", $this->user_id);

		if ($chartOfAccountCategoryList && sizeof($chartOfAccountCategoryList) > 0) {
			foreach ($chartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_trial_balance_account_display_order',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		echo 'ok';
	}
    
    public function saveReportsCashAndCashEquivalentsConfigData () {
		$cashAndCashEquivalentsChartOfAccountId = $this->db->escape_str($this->input->post('acm_cash_and_cash_equivalents_report_main_chart_of_account'));
        $chequeInHandChartOfAccountId = $this->db->escape_str($this->input->post('acm_cash_and_cash_equivalents_report_cheque_in_hand_chart_of_account'));

        $data = array(
            'config_filed_value' => $cashAndCashEquivalentsChartOfAccountId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("acm_cash_and_cash_equivalents_report_main_chart_of_account", $data);
        
        $data = array(
            'config_filed_value' => $chequeInHandChartOfAccountId,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("acm_cash_and_cash_equivalents_report_cheque_in_hand_chart_of_account", $data);
		
		echo 'ok';
	}
	
	public function saveReportsBalanceSheetConfigData () {
		$nonCurrentAssetsChartOfAccountCategoryList = $this->db->escape_str($this->input->post('non_current_assets_chart_of_account_category_list'));
		$currentAssetsChartOfAccountCategoryList = $this->db->escape_str($this->input->post('current_assets_chart_of_account_category_list'));
		$equityChartOfAccountCategoryList = $this->db->escape_str($this->input->post('equity_chart_of_account_category_list'));
		$nonCurrentLiabilitiesChartOfAccountCategoryList = $this->db->escape_str($this->input->post('non_current_liabilities_chart_of_account_category_list'));
		$currentLiabilitiesChartOfAccountCategoryList = $this->db->escape_str($this->input->post('current_liabilities_chart_of_account_category_list'));

		$this->system_configurations_model->deleteConfigurationField("accounts_balance_sheet_non_current_assets_accounts_list", $this->user_id);

		if ($nonCurrentAssetsChartOfAccountCategoryList && sizeof($nonCurrentAssetsChartOfAccountCategoryList) > 0) {
			foreach ($nonCurrentAssetsChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_balance_sheet_non_current_assets_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_balance_sheet_current_assets_accounts_list", $this->user_id);

		if ($currentAssetsChartOfAccountCategoryList && sizeof($currentAssetsChartOfAccountCategoryList) > 0) {
			foreach ($currentAssetsChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_balance_sheet_current_assets_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_balance_sheet_equity_accounts_list", $this->user_id);

		if ($equityChartOfAccountCategoryList && sizeof($equityChartOfAccountCategoryList) > 0) {
			foreach ($equityChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_balance_sheet_equity_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_balance_sheet_non_current_liabilities_accounts_list", $this->user_id);

		if ($nonCurrentLiabilitiesChartOfAccountCategoryList && sizeof($nonCurrentLiabilitiesChartOfAccountCategoryList) > 0) {
			foreach ($nonCurrentLiabilitiesChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_balance_sheet_non_current_liabilities_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_balance_sheet_current_liabilities_accounts_list", $this->user_id);

		if ($currentLiabilitiesChartOfAccountCategoryList && sizeof($currentLiabilitiesChartOfAccountCategoryList) > 0) {
			foreach ($currentLiabilitiesChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_balance_sheet_current_liabilities_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		echo 'ok';
	}
	
	public function saveReportsProfitAndLossConfigData () {
		$revenueCalculatingChartOfAccountCategoryList = $this->db->escape_str($this->input->post('revenue_calculating_chart_of_account_category_list'));
		$grossProfitCalculatingChartOfAccountCategoryList = $this->db->escape_str($this->input->post('gross_profit_calculating_chart_of_account_category_list'));
		$operatingActivitiesCalculatingChartOfAccountCategoryList = $this->db->escape_str($this->input->post('operating_activities_calculating_chart_of_account_category_list'));
		$profitCalculatingChartOfAccountCategoryList = $this->db->escape_str($this->input->post('profit_calculating_chart_of_account_category_list'));
		$netProfitCalculatingChartOfAccountCategoryList = $this->db->escape_str($this->input->post('net_profit_calculating_chart_of_account_category_list'));


		$this->system_configurations_model->deleteConfigurationField("accounts_profit_and_loss_revenue_calculating_chart_of_accounts_list", $this->user_id);

		if ($revenueCalculatingChartOfAccountCategoryList && sizeof($revenueCalculatingChartOfAccountCategoryList) > 0) {
			foreach ($revenueCalculatingChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_profit_and_loss_revenue_calculating_chart_of_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_profit_and_loss_gross_profit_calculating_chart_of_accounts_list", $this->user_id);

		if ($grossProfitCalculatingChartOfAccountCategoryList && sizeof($grossProfitCalculatingChartOfAccountCategoryList) > 0) {
			foreach ($grossProfitCalculatingChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_profit_and_loss_gross_profit_calculating_chart_of_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_profit_and_loss_operating_activities_calculating_chart_of_accounts_list", $this->user_id);

		if ($operatingActivitiesCalculatingChartOfAccountCategoryList && sizeof($operatingActivitiesCalculatingChartOfAccountCategoryList) > 0) {
			foreach ($operatingActivitiesCalculatingChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_profit_and_loss_operating_activities_calculating_chart_of_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_profit_and_loss_profit_calculating_chart_of_accounts_list", $this->user_id);

		if ($profitCalculatingChartOfAccountCategoryList && sizeof($profitCalculatingChartOfAccountCategoryList) > 0) {
			foreach ($profitCalculatingChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_profit_and_loss_profit_calculating_chart_of_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("accounts_profit_and_loss_net_profit_calculating_chart_of_accounts_list", $this->user_id);

		if ($netProfitCalculatingChartOfAccountCategoryList && sizeof($netProfitCalculatingChartOfAccountCategoryList) > 0) {
			foreach ($netProfitCalculatingChartOfAccountCategoryList as $chartOfAccountCategory) {
				$data = array(
					'config_filed_name' => 'accounts_profit_and_loss_net_profit_calculating_chart_of_accounts_list',
					'config_filed_value' => $chartOfAccountCategory,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		echo 'ok';
	}
	
	public function savePurchaseNoteConfigData () {
		$purchaseNoteProductsAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('purchase_note_products_accounts_prime_entry_book_list'));
		$purchaseNoteFreeIssuesAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('purchase_note_free_issues_accounts_prime_entry_book_list'));
		$purchaseNoteReferenceNoAutoIncrement = $this->db->escape_str($this->input->post('purchase_note_reference_no_auto_increment'));
		$purchaseNoteReferenceNoCode = $this->db->escape_str($this->input->post('purchase_note_reference_no_code'));
		$purchaseNoteReferenceNoSeparator = $this->db->escape_str($this->input->post('purchase_note_reference_no_separator'));
		$purchaseNoteReferenceNoStartNumber = $this->db->escape_str($this->input->post('purchase_note_reference_no_start_number'));

		$this->system_configurations_model->deleteConfigurationField("purchase_note_products_accounts_prime_entry_book", $this->user_id);

		if ($purchaseNoteProductsAccountsPrimeEntryBookList && sizeof($purchaseNoteProductsAccountsPrimeEntryBookList) > 0) {
			foreach ($purchaseNoteProductsAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'purchase_note_products_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("purchase_note_free_issues_accounts_prime_entry_book", $this->user_id);

		if ($purchaseNoteFreeIssuesAccountsPrimeEntryBookList && sizeof($purchaseNoteFreeIssuesAccountsPrimeEntryBookList) > 0) {
			foreach ($purchaseNoteFreeIssuesAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'purchase_note_free_issues_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}

		if ($purchaseNoteReferenceNoAutoIncrement == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => $purchaseNoteReferenceNoCode,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => $purchaseNoteReferenceNoSeparator,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => $purchaseNoteReferenceNoStartNumber,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_starting_number", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("purchase_note_reference_no_starting_number", $data);
		}
		
		echo 'ok';
	}
	
	public function saveSalesNoteConfigData () {
		$salesNoteSalesEntryAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('sales_note_sales_entry_accounts_prime_entry_book_list'));
		$salesNoteCostEntryAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('sales_note_cost_entry_accounts_prime_entry_book_list'));
		$salesNoteFreeIssuesAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('sales_note_free_issues_accounts_prime_entry_book_list'));
		$salesNoteDiscountAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('sales_note_discount_accounts_prime_entry_book_list'));
		$salesNoteReferenceNoAutoIncrement = $this->db->escape_str($this->input->post('sales_note_reference_no_auto_increment'));
		$salesNoteReferenceNoCode = $this->db->escape_str($this->input->post('sales_note_reference_no_code'));
		$salesNoteReferenceNoSeparator = $this->db->escape_str($this->input->post('sales_note_reference_no_separator'));
		$salesNoteReferenceNoStartNumber = $this->db->escape_str($this->input->post('sales_note_reference_no_start_number'));
		$salesProfitMarginPercentage = $this->db->escape_str($this->input->post('sales_profit_margin'));

		$this->system_configurations_model->deleteConfigurationField("sales_note_sales_entry_accounts_prime_entry_book", $this->user_id);

		if ($salesNoteSalesEntryAccountsPrimeEntryBookList && sizeof($salesNoteSalesEntryAccountsPrimeEntryBookList) > 0) {
			foreach ($salesNoteSalesEntryAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'sales_note_sales_entry_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("sales_note_cost_entry_accounts_prime_entry_book", $this->user_id);

		if ($salesNoteCostEntryAccountsPrimeEntryBookList && sizeof($salesNoteCostEntryAccountsPrimeEntryBookList) > 0) {
			foreach ($salesNoteCostEntryAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'sales_note_cost_entry_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("sales_note_free_issues_accounts_prime_entry_book", $this->user_id);

		if ($salesNoteFreeIssuesAccountsPrimeEntryBookList && sizeof($salesNoteFreeIssuesAccountsPrimeEntryBookList) > 0) {
			foreach ($salesNoteFreeIssuesAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'sales_note_free_issues_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("sales_note_discount_accounts_prime_entry_book", $this->user_id);

		if ($salesNoteDiscountAccountsPrimeEntryBookList && sizeof($salesNoteDiscountAccountsPrimeEntryBookList) > 0) {
			foreach ($salesNoteDiscountAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'sales_note_discount_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}

		if ($salesNoteReferenceNoAutoIncrement == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => $salesNoteReferenceNoCode,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => $salesNoteReferenceNoSeparator,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => $salesNoteReferenceNoStartNumber,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_starting_number", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("sales_note_reference_no_starting_number", $data);
		}
		
		$data = array(
			'config_filed_value' => $salesProfitMarginPercentage,
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'edited'
		);

		$this->system_configurations_model->updateConfigurationField("sales_profit_margin_percentage", $data);
		
		echo 'ok';
	}
	
	public function saveCustomerReturnNoteConfigData () {
		$customerSaleableReturnSalesEntryAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('customer_saleable_return_note_sales_entry_accounts_prime_entry_book_list'));
		$customerSaleableReturnCostEntryAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('customer_saleable_return_note_cost_entry_accounts_prime_entry_book_list'));
		$customerMarketReturnSalesEntryAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('customer_market_return_note_sales_entry_accounts_prime_entry_book_list'));
		$customerMarketReturnCostEntryAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('customer_market_return_note_cost_entry_accounts_prime_entry_book_list'));
		$customerReturnReferenceNoAutoIncrement = $this->db->escape_str($this->input->post('customer_return_note_reference_no_auto_increment'));
		$addCustomerMarketReturnCostEntryWithProfitMargin = $this->db->escape_str($this->input->post('add_customer_market_return_cost_entry_with_profit_margin'));
		$customerReturnReferenceNoCode = $this->db->escape_str($this->input->post('customer_return_note_reference_no_code'));
		$customerReturnReferenceNoSeparator = $this->db->escape_str($this->input->post('customer_return_note_reference_no_separator'));
		$customerReturnReferenceNoStartNumber = $this->db->escape_str($this->input->post('customer_return_note_reference_no_start_number'));
		$customerReturnCreditProfitMarginChartOfAccount = $this->db->escape_str($this->input->post('customer_return_credit_profit_margin_chart_of_account'));

		$this->system_configurations_model->deleteConfigurationField("customer_saleable_return_note_sales_entry_accounts_prime_entry_book", $this->user_id);

		if ($customerSaleableReturnSalesEntryAccountsPrimeEntryBookList && sizeof($customerSaleableReturnSalesEntryAccountsPrimeEntryBookList) > 0) {
			foreach ($customerSaleableReturnSalesEntryAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'customer_saleable_return_note_sales_entry_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("customer_saleable_return_note_cost_entry_accounts_prime_entry_book", $this->user_id);

		if ($customerSaleableReturnCostEntryAccountsPrimeEntryBookList && sizeof($customerSaleableReturnCostEntryAccountsPrimeEntryBookList) > 0) {
			foreach ($customerSaleableReturnCostEntryAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'customer_saleable_return_note_cost_entry_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("customer_market_return_note_sales_entry_accounts_prime_entry_book", $this->user_id);

		if ($customerMarketReturnSalesEntryAccountsPrimeEntryBookList && sizeof($customerMarketReturnSalesEntryAccountsPrimeEntryBookList) > 0) {
			foreach ($customerMarketReturnSalesEntryAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'customer_market_return_note_sales_entry_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("customer_market_return_note_cost_entry_accounts_prime_entry_book", $this->user_id);

		if ($customerMarketReturnCostEntryAccountsPrimeEntryBookList && sizeof($customerMarketReturnCostEntryAccountsPrimeEntryBookList) > 0) {
			foreach ($customerMarketReturnCostEntryAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'customer_market_return_note_cost_entry_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}

		if ($customerReturnReferenceNoAutoIncrement == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => $customerReturnReferenceNoCode,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => $customerReturnReferenceNoSeparator,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => $customerReturnReferenceNoStartNumber,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_starting_number", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_return_note_reference_no_starting_number", $data);
		}
		
		if ($addCustomerMarketReturnCostEntryWithProfitMargin == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("add_customer_market_return_cost_entry_with_profit_margin", $data);
			
			$data = array(
				'config_filed_value' => $customerReturnCreditProfitMarginChartOfAccount,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_market_return_cost_entry_profit_margin_credit_account_id", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("add_customer_market_return_cost_entry_with_profit_margin", $data);
			
			$data = array(
				'config_filed_value' => '0',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("customer_market_return_cost_entry_profit_margin_credit_account_id", $data);
		}
		
		echo 'ok';
	}
	
	public function saveSupplierReturnNoteConfigData () {
		$supplierSaleableReturnAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('supplier_saleable_return_note_accounts_prime_entry_book_list'));
		$supplierMarketReturnAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('supplier_market_return_note_accounts_prime_entry_book_list'));
		$supplierReturnReferenceNoAutoIncrement = $this->db->escape_str($this->input->post('supplier_return_note_reference_no_auto_increment'));
		$supplierReturnReferenceNoCode = $this->db->escape_str($this->input->post('supplier_return_note_reference_no_code'));
		$supplierReturnReferenceNoSeparator = $this->db->escape_str($this->input->post('supplier_return_note_reference_no_separator'));
		$supplierReturnReferenceNoStartNumber = $this->db->escape_str($this->input->post('supplier_return_note_reference_no_start_number'));

		$this->system_configurations_model->deleteConfigurationField("supplier_saleable_return_note_accounts_prime_entry_book", $this->user_id);

		if ($supplierSaleableReturnAccountsPrimeEntryBookList && sizeof($supplierSaleableReturnAccountsPrimeEntryBookList) > 0) {
			foreach ($supplierSaleableReturnAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'supplier_saleable_return_note_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("supplier_market_return_note_accounts_prime_entry_book", $this->user_id);

		if ($supplierMarketReturnAccountsPrimeEntryBookList && sizeof($supplierMarketReturnAccountsPrimeEntryBookList) > 0) {
			foreach ($supplierMarketReturnAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'supplier_market_return_note_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		if ($supplierReturnReferenceNoAutoIncrement == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => $supplierReturnReferenceNoCode,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => $supplierReturnReferenceNoSeparator,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => $supplierReturnReferenceNoStartNumber,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_starting_number", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("supplier_return_note_reference_no_starting_number", $data);
		}
		
		echo 'ok';
	}
	
	public function saveReceivePaymentConfigData () {
		$receivePaymentCashAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('receive_payment_cash_accounts_prime_entry_book_list'));
		$receivePaymentChequeAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('receive_payment_cheque_accounts_prime_entry_book_list'));
        $receivePaymentChequeDepositAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('receive_payment_cheque_deposit_accounts_prime_entry_book_list'));
        $receivePaymentCreditCardAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('receive_payment_credit_card_accounts_prime_entry_book_list'));
        $receivePaymentTransactionClaimAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('receive_payment_transaction_claim_accounts_prime_entry_book_list'));
		$receivePaymentReferenceNoAutoIncrement = $this->db->escape_str($this->input->post('receive_payment_reference_no_auto_increment'));
		$receivePaymentReferenceNoCode = $this->db->escape_str($this->input->post('receive_payment_reference_no_code'));
		$receivePaymentReferenceNoSeparator = $this->db->escape_str($this->input->post('receive_payment_reference_no_separator'));
		$receivePaymentReferenceNoStartNumber = $this->db->escape_str($this->input->post('receive_payment_reference_no_start_number'));
        $receivePaymentDefaultPayerType = $this->db->escape_str($this->input->post('receive_payment_default_payer_type'));
        $receivePaymentDefaultReferenceTransactionType = $this->db->escape_str($this->input->post('receive_payment_default_reference_transaction_type'));
        $receivePaymentSelectReferenceJournalEntryAutomatically = $this->db->escape_str($this->input->post('receive_payment_select_reference_journal_entry_automatically'));
        $receivePaymentAllowPartialPaymentForReferenceTransactions = $this->db->escape_str($this->input->post('receive_payment_allow_partial_payment_for_reference_transactions'));
        
		$this->system_configurations_model->deleteConfigurationField("receive_payment_cash_accounts_prime_entry_book", $this->user_id);

		if ($receivePaymentCashAccountsPrimeEntryBookList && sizeof($receivePaymentCashAccountsPrimeEntryBookList) > 0) {
			foreach ($receivePaymentCashAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'receive_payment_cash_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("receive_payment_cheque_accounts_prime_entry_book", $this->user_id);

		if ($receivePaymentChequeAccountsPrimeEntryBookList && sizeof($receivePaymentChequeAccountsPrimeEntryBookList) > 0) {
			foreach ($receivePaymentChequeAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'receive_payment_cheque_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
        
        $this->system_configurations_model->deleteConfigurationField("receive_payment_cheque_deposit_accounts_prime_entry_book", $this->user_id);

		if ($receivePaymentChequeDepositAccountsPrimeEntryBookList && sizeof($receivePaymentChequeDepositAccountsPrimeEntryBookList) > 0) {
			foreach ($receivePaymentChequeDepositAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'receive_payment_cheque_deposit_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
        
        $this->system_configurations_model->deleteConfigurationField("receive_payment_credit_card_accounts_prime_entry_book", $this->user_id);

		if ($receivePaymentCreditCardAccountsPrimeEntryBookList && sizeof($receivePaymentCreditCardAccountsPrimeEntryBookList) > 0) {
			foreach ($receivePaymentCreditCardAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'receive_payment_credit_card_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
        
        $this->system_configurations_model->deleteConfigurationField("receive_payment_transaction_claim_accounts_prime_entry_book", $this->user_id);

		if ($receivePaymentTransactionClaimAccountsPrimeEntryBookList && sizeof($receivePaymentTransactionClaimAccountsPrimeEntryBookList) > 0) {
			foreach ($receivePaymentTransactionClaimAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'receive_payment_transaction_claim_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		if ($receivePaymentReferenceNoAutoIncrement == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => $receivePaymentReferenceNoCode,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => $receivePaymentReferenceNoSeparator,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => $receivePaymentReferenceNoStartNumber,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_starting_number", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_reference_no_starting_number", $data);
		}
        
        $data = array(
            'config_filed_value' => $receivePaymentDefaultPayerType,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("receive_payment_default_payer_type", $data);
        
        $data = array(
            'config_filed_value' => $receivePaymentDefaultReferenceTransactionType,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("receive_payment_default_reference_transaction_type", $data);
        
        if ($receivePaymentSelectReferenceJournalEntryAutomatically == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_select_reference_journal_entry_automatically", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_select_reference_journal_entry_automatically", $data);
		}
        
        if ($receivePaymentAllowPartialPaymentForReferenceTransactions == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_allow_partial_payment_for_reference_transactions", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("receive_payment_allow_partial_payment_for_reference_transactions", $data);
		}
		
		echo 'ok';
	}
	
	public function saveMakePaymentConfigData () {
		$makePaymentCashAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('make_payment_cash_accounts_prime_entry_book_list'));
		$makePaymentChequeAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('make_payment_cheque_accounts_prime_entry_book_list'));
		$makePaymentThirdPartyChequeAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('make_payment_second_or_third_party_cheque_accounts_prime_entry_book_list'));
        $makePaymentTransactionClaimAccountsPrimeEntryBookList = $this->db->escape_str($this->input->post('make_payment_transaction_claim_accounts_prime_entry_book_list'));
		$makePaymentReferenceNoAutoIncrement = $this->db->escape_str($this->input->post('make_payment_reference_no_auto_increment'));
		$makePaymentReferenceNoCode = $this->db->escape_str($this->input->post('make_payment_reference_no_code'));
		$makePaymentReferenceNoSeparator = $this->db->escape_str($this->input->post('make_payment_reference_no_separator'));
		$makePaymentReferenceNoStartNumber = $this->db->escape_str($this->input->post('make_payment_reference_no_start_number'));
        $makePaymentDefaultPayeeType = $this->db->escape_str($this->input->post('make_payment_default_payee_type'));
        $makePaymentDefaultReferenceTransactionType = $this->db->escape_str($this->input->post('make_payment_default_reference_transaction_type'));
        $makePaymentSelectReferenceJournalEntryAutomatically = $this->db->escape_str($this->input->post('make_payment_select_reference_journal_entry_automatically'));
        $makePaymentAllowPartialPaymentForReferenceTransactions = $this->db->escape_str($this->input->post('make_payment_allow_partial_payment_for_reference_transactions'));
        
		$this->system_configurations_model->deleteConfigurationField("make_payment_cash_accounts_prime_entry_book", $this->user_id);

		if ($makePaymentCashAccountsPrimeEntryBookList && sizeof($makePaymentCashAccountsPrimeEntryBookList) > 0) {
			foreach ($makePaymentCashAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'make_payment_cash_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("make_payment_cheque_accounts_prime_entry_book", $this->user_id);

		if ($makePaymentChequeAccountsPrimeEntryBookList && sizeof($makePaymentChequeAccountsPrimeEntryBookList) > 0) {
			foreach ($makePaymentChequeAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'make_payment_cheque_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		$this->system_configurations_model->deleteConfigurationField("make_payment_second_or_third_party_cheque_accounts_prime_entry_book", $this->user_id);

		if ($makePaymentThirdPartyChequeAccountsPrimeEntryBookList && sizeof($makePaymentThirdPartyChequeAccountsPrimeEntryBookList) > 0) {
			foreach ($makePaymentThirdPartyChequeAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'make_payment_second_or_third_party_cheque_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
        
        $this->system_configurations_model->deleteConfigurationField("make_payment_transaction_claim_accounts_prime_entry_book", $this->user_id);

		if ($makePaymentTransactionClaimAccountsPrimeEntryBookList && sizeof($makePaymentTransactionClaimAccountsPrimeEntryBookList) > 0) {
			foreach ($makePaymentTransactionClaimAccountsPrimeEntryBookList as $accountsPrimeEntryBook) {
				$data = array(
					'config_filed_name' => 'make_payment_transaction_claim_accounts_prime_entry_book',
					'config_filed_value' => $accountsPrimeEntryBook,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				$this->system_configurations_model->saveConfigurationField($data);
			}
		}
		
		if ($makePaymentReferenceNoAutoIncrement == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => $makePaymentReferenceNoCode,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => $makePaymentReferenceNoSeparator,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => $makePaymentReferenceNoStartNumber,
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_starting_number", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_auto_increment", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_starting_code", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_separator", $data);

			$data = array(
				'config_filed_value' => '',
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_reference_no_starting_number", $data);
		}
        
        $data = array(
            'config_filed_value' => $makePaymentDefaultPayeeType,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("make_payment_default_payee_type", $data);
        
        $data = array(
            'config_filed_value' => $makePaymentDefaultReferenceTransactionType,
            'actioned_user_id' => $this->user_id,
            'action_date' => $this->date,
            'last_action_status' => 'edited'
        );

        $this->system_configurations_model->updateConfigurationField("make_payment_default_reference_transaction_type", $data);
        
        if ($makePaymentSelectReferenceJournalEntryAutomatically == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_select_reference_journal_entry_automatically", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_select_reference_journal_entry_automatically", $data);
		}
        
        if ($makePaymentAllowPartialPaymentForReferenceTransactions == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_allow_partial_payment_for_reference_transactions", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("make_payment_allow_partial_payment_for_reference_transactions", $data);
		}
        
        echo 'ok';
	}
    
    public function saveChequeListConfigData () {
        
        $automaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled = $this->db->escape_str($this->input->post('automatically_mark_received_cheques_as_deposited_on_cheque_date'));
        $automaticallyClearReceivedChequesAfterDepositedToBankEnabled = $this->db->escape_str($this->input->post('automatically_clear_received_cheques_after_deposited_to_bank'));
        $automaticallyClearPaidChequesOnChequeDateEnabled = $this->db->escape_str($this->input->post('automatically_clear_paid_cheques_on_cheque_date'));
        
        if ($automaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("automatically_mark_received_cheques_as_deposited_on_cheque_date", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("automatically_mark_received_cheques_as_deposited_on_cheque_date", $data);
		}
        
        if ($automaticallyClearReceivedChequesAfterDepositedToBankEnabled == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("automatically_clear_received_cheques_after_deposited_to_bank", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("automatically_clear_received_cheques_after_deposited_to_bank", $data);
		}
        
        if ($automaticallyClearPaidChequesOnChequeDateEnabled == "Yes") {
			$data = array(
				'config_filed_value' => "Yes",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("automatically_clear_paid_cheques_on_cheque_date", $data);
		} else {
			$data = array(
				'config_filed_value' => "No",
				'actioned_user_id' => $this->user_id,
				'action_date' => $this->date,
				'last_action_status' => 'edited'
			);

			$this->system_configurations_model->updateConfigurationField("automatically_clear_paid_cheques_on_cheque_date", $data);
		}
		
		echo 'ok';
    }
	
	public function getGeneralConfigurationData() {
		$cashRelatedChartOfAccountCategoryListForCashAccountingMethod = $this->system_configurations_model->getCashRelatedChartOfAccountForCashAccountingMethodConfigurationData();

		$cashRelatedChartOfAccountCategoryListForCashAccountingMethodCategoryData = '';
		
		$language = $this->userManagement->getUserLanguage($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$cloneCount = 1;
		if ($cashRelatedChartOfAccountCategoryListForCashAccountingMethod && sizeof($cashRelatedChartOfAccountCategoryListForCashAccountingMethod) > 0) {
			foreach ($cashRelatedChartOfAccountCategoryListForCashAccountingMethod as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$cashRelatedChartOfAccountCategoryListForCashAccountingMethodCategoryData .= "<div class='form-group' id='cash_related_chart_of_account_for_cash_accounting_method_category_row_" . $cloneCount . "'>
											<input class='form-control' id='cash_related_chart_of_account_for_cash_accounting_method_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='cash_related_chart_of_account_for_cash_accounting_method_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_cash_related_chart_of_account_for_cash_accounting_method_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /CRCHCA/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		echo json_encode(array('cashRelatedChartOfAccountCategoryListForCashAccountingMethodCategoryData' => $cashRelatedChartOfAccountCategoryListForCashAccountingMethodCategoryData));
	}
	
	public function getReportsTrialBalanceConfigurationData() {
		$chartOfAccountCategories = $this->system_configurations_model->getReportsTrialBalanceConfigurationData();

		$chartOfAccountCategoryData = '';
		
		$language = $this->userManagement->getUserLanguage($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$cloneCount = 1;
		if ($chartOfAccountCategories && sizeof($chartOfAccountCategories) > 0) {
			foreach ($chartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$chartOfAccountCategoryData .= "<div class='form-group' id='trial_balance_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='trial_balance_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='trial_balance_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_trial_balance_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /TBRS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('chartOfAccountCategoryData' => $chartOfAccountCategoryData));
	}
	
	public function getReportsBalanceSheetConfigurationData() {
		$nonCurrentAssetsChartOfAccountCategories = $this->system_configurations_model->getReportsBalanceSheetNonCurrentAssetsConfigurationData();
		$currentAssetsChartOfAccountCategories = $this->system_configurations_model->getReportsBalanceSheetCurrentAssetsConfigurationData();
		$equityChartOfAccountCategories = $this->system_configurations_model->getReportsBalanceSheetEquityConfigurationData();
		$nonCurrentLiabilitiesChartOfAccountCategories = $this->system_configurations_model->getReportsBalanceSheetNonCurrentLiabilitiesConfigurationData();
		$currentLiabilitiesChartOfAccountCategories = $this->system_configurations_model->getReportsBalanceSheetCurrentLiabilitiesConfigurationData();

		$nonCurrentAssetsChartOfAccountCategoryData = '';
		$currentAssetsChartOfAccountCategoryData = '';
		$equityChartOfAccountCategoryData = '';
		$nonCurrentLiabilitiesChartOfAccountCategoryData = '';
		$currentLiabilitiesChartOfAccountCategoryData = '';
		
		$language = $this->userManagement->getUserLanguage($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$cloneCount = 1;
		if ($nonCurrentAssetsChartOfAccountCategories && sizeof($nonCurrentAssetsChartOfAccountCategories) > 0) {
			foreach ($nonCurrentAssetsChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$nonCurrentAssetsChartOfAccountCategoryData .= "<div class='form-group' id='non_current_assets_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='non_current_assets_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='non_current_assets_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_non_current_assets_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /NCAS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($currentAssetsChartOfAccountCategories && sizeof($currentAssetsChartOfAccountCategories) > 0) {
			foreach ($currentAssetsChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$currentAssetsChartOfAccountCategoryData .= "<div class='form-group' id='current_assets_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='current_assets_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='current_assets_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_current_assets_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /CAS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($equityChartOfAccountCategories && sizeof($equityChartOfAccountCategories) > 0) {
			foreach ($equityChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$equityChartOfAccountCategoryData .= "<div class='form-group' id='equity_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='equity_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='equity_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_equity_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /ES/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($nonCurrentLiabilitiesChartOfAccountCategories && sizeof($nonCurrentLiabilitiesChartOfAccountCategories) > 0) {
			foreach ($nonCurrentLiabilitiesChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$nonCurrentLiabilitiesChartOfAccountCategoryData .= "<div class='form-group' id='non_current_liabilities_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='non_current_liabilities_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='non_current_liabilities_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_non_current_liabilities_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /NCLS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($currentLiabilitiesChartOfAccountCategories && sizeof($currentLiabilitiesChartOfAccountCategories) > 0) {
			foreach ($currentLiabilitiesChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$currentLiabilitiesChartOfAccountCategoryData .= "<div class='form-group' id='current_liabilities_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='current_liabilities_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='current_liabilities_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_current_liabilities_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /CLS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('nonCurrentAssetsChartOfAccountCategoryData' => $nonCurrentAssetsChartOfAccountCategoryData, 'currentAssetsChartOfAccountCategoryData' => $currentAssetsChartOfAccountCategoryData, 'equityChartOfAccountCategoryData' => $equityChartOfAccountCategoryData, 'nonCurrentLiabilitiesChartOfAccountCategoryData' => $nonCurrentLiabilitiesChartOfAccountCategoryData, 'currentLiabilitiesChartOfAccountCategoryData' => $currentLiabilitiesChartOfAccountCategoryData));
	}
	
	public function getReportsProfitAndLossConfigurationData() {
		$revenueCalculatingChartOfAccountCategories = $this->system_configurations_model->getReportsProfitAndLossRevenueCalculatingConfigurationData();
		$grossProfitCalculatingChartOfAccountCategories = $this->system_configurations_model->getReportsProfitAndLossGrossProfitCalculatingConfigurationData();
		$operatingActivitiesCalculatingChartOfAccountCategories = $this->system_configurations_model->getReportsProfitAndLossOperatingActivitiesCalculatingConfigurationData();
		$profitCalculatingChartOfAccountCategories = $this->system_configurations_model->getReportsProfitAndLossProfitCalculatingConfigurationData();
		$netProfitCalculatingChartOfAccountCategories = $this->system_configurations_model->getReportsProfitAndLossNetProfitCalculatingConfigurationData();

		$revenueCalculatingChartOfAccountCategoryData = '';
		$grossProfitCalculatingChartOfAccountCategoryData = '';
		$operatingActivitiesCalculatingChartOfAccountCategoryData = '';
		$profitCalculatingChartOfAccountCategoryData = '';
		$netProfitCalculatingChartOfAccountCategoryData = '';
		
		$language = $this->userManagement->getUserLanguage($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$cloneCount = 1;
		if ($revenueCalculatingChartOfAccountCategories && sizeof($revenueCalculatingChartOfAccountCategories) > 0) {
			foreach ($revenueCalculatingChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$revenueCalculatingChartOfAccountCategoryData .= "<div class='form-group' id='revenue_calculating_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='revenue_calculating_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='revenue_calculating_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_revenue_calculating_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /REVS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($grossProfitCalculatingChartOfAccountCategories && sizeof($grossProfitCalculatingChartOfAccountCategories) > 0) {
			foreach ($grossProfitCalculatingChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$grossProfitCalculatingChartOfAccountCategoryData .= "<div class='form-group' id='gross_profit_calculating_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='gross_profit_calculating_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='gross_profit_calculating_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_gross_profit_calculating_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /GRPS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($operatingActivitiesCalculatingChartOfAccountCategories && sizeof($operatingActivitiesCalculatingChartOfAccountCategories) > 0) {
			foreach ($operatingActivitiesCalculatingChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$operatingActivitiesCalculatingChartOfAccountCategoryData .= "<div class='form-group' id='operating_activities_calculating_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='operating_activities_calculating_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='operating_activities_calculating_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_operating_activities_calculating_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /OPAS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($profitCalculatingChartOfAccountCategories && sizeof($profitCalculatingChartOfAccountCategories) > 0) {
			foreach ($profitCalculatingChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$profitCalculatingChartOfAccountCategoryData .= "<div class='form-group' id='profit_calculating_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='profit_calculating_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='profit_calculating_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_profit_calculating_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /PRFS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}
		
		$cloneCount = 1;
		if ($netProfitCalculatingChartOfAccountCategories && sizeof($netProfitCalculatingChartOfAccountCategories) > 0) {
			foreach ($netProfitCalculatingChartOfAccountCategories as $chartOfAccountCategory) {
				$chartOfAccountId = $chartOfAccountCategory->config_filed_value;
				$chartOfAccount = $this->chart_of_accounts_model->get($chartOfAccountId);
				$chartOfAccountName = $chartOfAccount[0]->text;
				$netProfitCalculatingChartOfAccountCategoryData .= "<div class='form-group' id='net_profit_calculating_chart_of_account_category_row_" . $cloneCount . "'>
											<input class='form-control' id='net_profit_calculating_chart_of_account_category_id_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountId . "'>
											<input class='form-control' id='net_profit_calculating_chart_of_account_category_" . $cloneCount . "' type='hidden' value='" . $chartOfAccountName . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 category_data'>" . $chartOfAccountName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='delete_net_profit_calculating_chart_of_account_category_" . $cloneCount . "'
														onclick='removeChartOfAccountCategory(this.id, /NPRFS/)'" . $menuFormatting . ">
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('revenueCalculatingChartOfAccountCategoryData' => $revenueCalculatingChartOfAccountCategoryData, 'grossProfitCalculatingChartOfAccountCategoryData' => $grossProfitCalculatingChartOfAccountCategoryData, 'operatingActivitiesCalculatingChartOfAccountCategoryData' => $operatingActivitiesCalculatingChartOfAccountCategoryData, 'profitCalculatingChartOfAccountCategoryData' => $profitCalculatingChartOfAccountCategoryData, 'netProfitCalculatingChartOfAccountCategoryData' => $netProfitCalculatingChartOfAccountCategoryData));
	}

	public function getMonthDropdownData() {
		
		$formattedMonthArray = array(
						"1" => "January", "2" => "February", "3" => "March", "4" => "April",
						"5" => "May", "6" => "June", "7" => "July", "8" => "August",
						"9" => "September", "10" => "October", "11" => "November", "12" => "December",
					);
		
		$html = "<select id='month' class='form-control' onchange='handleMonthChange(this.id)'>";
		$html .= "<option value='0'>" . $this->lang->line('-- Select --') . "</option>";
		$current_month = date('m');
		for ($m=1; $m<=12; $m++) {
			if($current_month == $m) {
				$html .= "<option value='" . $m . "' selected='selected'>" . $formattedMonthArray[$m] . "</option>";
			} else {
				$html .= "<option value='" . $m . "'>" . $formattedMonthArray[$m] . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}
	
	public function getFinancialYearData() {
		$currentDate = date('Y-m-d'); 
		$currentYear = date('Y'); 
		$financialYearStartMonth = $this->system_configurations_model->getFinancialYearStartMonthNo();
		$financialYearStartDay = $this->system_configurations_model->getFinancialYearStartDayNo();
		$financialYearEndMonth = $this->system_configurations_model->getFinancialYearEndMonthNo();
		$financialYearEndDay = $this->system_configurations_model->getFinancialYearEndDayNo();
		
		$currentFinancialYearEndDateToCompare = ($currentYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		
		if (($financialYearStartMonth > 1 || $financialYearStartDay > 1) && strtotime($currentFinancialYearEndDateToCompare) < strtotime($currentDate)) {
			$currentFinancialYearStartDate = $currentYear . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = ($currentYear + 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
			$currentYear = $currentYear - 1;
		} else {
			$currentFinancialYearStartDate = ($currentYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
			$currentFinancialYearEndDate = $currentYear . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
			$currentYear = $currentYear - 2;
		}
		
		$lastFinancialYearStartDate = ($currentYear - 1) . "-" . $financialYearStartMonth . "-" . $financialYearStartDay;
		if ($financialYearStartMonth > 1 || $financialYearStartDay > 1) {
			$lastFinancialYearEndDate = ($currentYear) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		} else {
			$lastFinancialYearEndDate = ($currentYear - 1) . "-" . $financialYearEndMonth . "-" . $financialYearEndDay;
		}
		
		$firstQuarterStartDate = $currentFinancialYearStartDate;
		$firstQuarterEndDate = date('Y-m-d', strtotime("+3 months", strtotime($firstQuarterStartDate)));
		$firstQuarterEndDate = date('Y-m-d', strtotime("-1 day", strtotime($firstQuarterEndDate)));
		
		$secondQuarterStartDate = date('Y-m-d', strtotime("+1 day", strtotime($firstQuarterEndDate)));
		$secondQuarterEndDate = date('Y-m-d', strtotime("+3 months", strtotime($secondQuarterStartDate)));
		$secondQuarterEndDate = date('Y-m-d', strtotime("-1 day", strtotime($secondQuarterEndDate)));
		
		$thirdQuarterStartDate = date('Y-m-d', strtotime("+1 day", strtotime($secondQuarterEndDate)));
		$thirdQuarterEndDate = date('Y-m-d', strtotime("+3 months", strtotime($thirdQuarterStartDate)));
		$thirdQuarterEndDate = date('Y-m-d', strtotime("-1 day", strtotime($thirdQuarterEndDate)));
		
		$fourthQuarterStartDate = date('Y-m-d', strtotime("+1 day", strtotime($thirdQuarterEndDate)));
		$fourthQuarterEndDate = date('Y-m-d', strtotime("+3 months", strtotime($fourthQuarterStartDate)));
		$fourthQuarterEndDate = date('Y-m-d', strtotime("-1 day", strtotime($fourthQuarterEndDate)));
		
		echo json_encode(array('currentFinancialYearStartDate' => $currentFinancialYearStartDate, 'currentFinancialYearEndDate' => $currentFinancialYearEndDate, 'lastFinancialYearStartDate' => $lastFinancialYearStartDate, 'lastFinancialYearEndDate' => $lastFinancialYearEndDate, 'firstQuarterStartDate' => $firstQuarterStartDate, 'firstQuarterEndDate' => $firstQuarterEndDate, 'secondQuarterStartDate' => $secondQuarterStartDate, 'secondQuarterEndDate' => $secondQuarterEndDate, 'thirdQuarterStartDate' => $thirdQuarterStartDate, 'thirdQuarterEndDate' => $thirdQuarterEndDate, 'fourthQuarterStartDate' => $fourthQuarterStartDate, 'fourthQuarterEndDate' => $fourthQuarterEndDate));
	}
	
	public function getPurchaseNoteProductsAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getPurchaseNoteProductsAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='pnp_purchase_note_products_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='pnp_purchase_note_products_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='pnp_purchase_note_products_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getPurchaseNoteFreeIssuesAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getPurchaseNoteFreeIssuesAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='pnf_purchase_note_free_issues_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='pnf_purchase_note_free_issues_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='pnf_purchase_note_free_issues_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getSalesNoteSalesEntryAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getSalesNoteSalesEntryAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='sns_sales_note_sales_entry_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='sns_sales_note_sales_entry_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='sns_sales_note_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getSalesNoteCostEntryAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getSalesNoteCostEntryAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='snc_sales_note_cost_entry_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='snc_sales_note_cost_entry_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='snc_sales_note_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getSalesNoteFreeIssuesAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getSalesNoteFreeIssuesAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='snf_sales_note_free_issues_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='snf_sales_note_free_issues_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='snf_sales_note_free_issues_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getSalesNoteDiscountAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getSalesNoteDiscountAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='snd_sales_note_discount_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='snd_sales_note_discount_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='snd_sales_note_discount_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getCustomerSaleableReturnSalesEntryAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getCustomerSaleableReturnNoteSalesEntryAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='css_customer_saleable_return_note_sales_entry_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getCustomerSaleableReturnCostEntryAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getCustomerSaleableReturnNoteCostEntryAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='csc_customer_saleable_return_note_cost_entry_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getCustomerMarketReturnSalesEntryAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getCustomerMarketReturnNoteSalesEntryAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='cms_customer_market_return_note_sales_entry_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getCustomerMarketReturnCostEntryAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getCustomerMarketReturnNoteCostEntryAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='cmc_customer_market_return_note_cost_entry_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getSupplierSaleableReturnAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getSupplierSaleableReturnNoteAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='ssr_supplier_saleable_return_note_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='ssr_supplier_saleable_return_note_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='ssr_supplier_saleable_return_note_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getSupplierMarketReturnAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getSupplierMarketReturnNoteAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='smr_supplier_market_return_note_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='smr_supplier_market_return_note_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='smr_supplier_market_return_note_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getReceivePaymentCashAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentCashAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='rca_receive_payment_cash_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='rca_receive_payment_cash_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='rca_receive_payment_cash_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getReceivePaymentChequeAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentChequeAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='rcq_receive_payment_cheque_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='rcq_receive_payment_cheque_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='rcq_receive_payment_cheque_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
    
    public function getReceivePaymentChequeDepositAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentChequeDepositAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='rcd_receive_payment_cheque_deposit_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
    
    public function getReceivePaymentCreditCardAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentCreditCardAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='rcc_receive_payment_credit_card_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='rcc_receive_payment_credit_card_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='rcc_receive_payment_credit_card_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
    
    public function getReceivePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentTransactionClaimAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='rtc_receive_payment_transaction_claim_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='rtc_receive_payment_transaction_claim_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='rtc_receive_payment_transaction_claim_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getMakePaymentCashAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getMakePaymentCashAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='pca_make_payment_cash_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='pca_make_payment_cash_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='pca_make_payment_cash_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getMakePaymentChequeAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getMakePaymentChequeAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='pcq_make_payment_cheque_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='pcq_make_payment_cheque_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='pcq_make_payment_cheque_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getMakePaymentThirdPartyChequeAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getMakePaymentSecondOrThirdPartyChequeAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='ptc_make_payment_second_or_third_party_cheque_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
    
    public function getMakePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getMakePaymentTransactionClaimAccountsPrimeEntryBooks();

		$accountsPrimeEntryBookData = '';

		$cloneCount = 1;
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$accountsPrimeEntryBookData .= "<div class='form-group' id='pcl_make_payment_transaction_claim_accounts_prime_entry_book_row_" . $cloneCount . "'>
											<input class='form-control' id='pcl_make_payment_transaction_claim_accounts_prime_entry_book_" . $cloneCount . "' type='hidden' value='" . $accountsPrimeEntryBookId . "'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6 prime_entry_book_data'>" . $accountsPrimeEntryBookName . "</label>
												<div class='col-sm-2 controls'>
													<button class='btn btn-success' type='button' id='pcl_make_payment_transaction_claim_delete_accounts_prime_entry_book_" . $cloneCount . "'
														onclick='removeAccountsPrimeEntryBook(this.id)'>
														<i class='icon-save'></i>
														{$this->lang->line('Delete')}
													</button>
												</div>
											</div>
										</div>";
				$cloneCount++;
			}
		}

		echo json_encode(array('accountsPrimeEntryBookData' => $accountsPrimeEntryBookData));
	}
	
	public function getPaymentAccountData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getMakePaymentChequeAccountsPrimeEntryBooks();

		$paymentAccountList = "   <select class='select2 form-control' id='payment_account_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$paymentAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
			}
		}
		
		$paymentAccountList .="   </select>";

		echo json_encode(array('paymentAccountList' => $paymentAccountList));
	}
	
	public function getPaymentAccountDataWithSavedOption() {
		$selectedIndex = $this->db->escape_str($this->input->post('payment_account_id'));
		$accountsPrimeEntryBooks = $this->system_configurations_model->getMakePaymentChequeAccountsPrimeEntryBooks();

		$paymentAccountList = " <select class='select2 form-control' id='payment_account_id_edit'>
								<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				if ($selectedIndex == '') {
					$paymentAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
				} else {
					if ($selectedIndex == $accountsPrimeEntryBookId) {
						$paymentAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' selected>" . $accountsPrimeEntryBookName . "</option>";
					} else {
						$paymentAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
					}
				}
			}
		}
		
		$paymentAccountList .="   </select>";

		echo json_encode(array('paymentAccountList' => $paymentAccountList));
	}
    
    public function getChequeDepositAccountData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentChequeDepositAccountsPrimeEntryBooks();

		$chequeDepositAccountList = "   <select class='select2 form-control' id='cheque_deposit_account_id' onchange='handleChequeDepositAccountSelect(this.id)'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				$chequeDepositAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
			}
		}
		
		$chequeDepositAccountList .="   </select>";

		echo json_encode(array('chequeDepositAccountList' => $chequeDepositAccountList));
	}
	
	public function getChequeDepositAccountDataWithSavedOption() {
		$selectedIndex = $this->db->escape_str($this->input->post('cheque_deposit_account_id'));
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentChequeDepositAccountsPrimeEntryBooks();

		$chequeDepositAccountList = " <select class='select2 form-control' id='cheque_deposit_account_id_edit'>
								<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

				if ($selectedIndex == '') {
					$chequeDepositAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
				} else {
					if ($selectedIndex == $accountsPrimeEntryBookId) {
						$chequeDepositAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' selected>" . $accountsPrimeEntryBookName . "</option>";
					} else {
						$chequeDepositAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
					}
				}
			}
		}
		
		$chequeDepositAccountList .="   </select>";

		echo json_encode(array('chequeDepositAccountList' => $chequeDepositAccountList));
	}
    
    public function getCardPaymentAccountData() {
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentCreditCardAccountsPrimeEntryBooks();

		$paymentAccountList = "   <select class='select2 form-control' id='payment_account_id'>
										<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

                $paymentAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
            }
        }
		
		$paymentAccountList .="   </select>";

		echo json_encode(array('paymentAccountList' => $paymentAccountList));
	}
    
    public function getCardPaymentAccountDataWithSavedOption() {
        $selectedIndex = $this->db->escape_str($this->input->post('payment_account_id'));
        $disableForEdit = $this->db->escape_str($this->input->post('disable_for_edit'));
        
		$accountsPrimeEntryBooks = $this->system_configurations_model->getReceivePaymentCreditCardAccountsPrimeEntryBooks();

        if ($disableForEdit == "Yes") {
            $paymentAccountList  = "   <select class='select2 form-control' id='payment_account_id' disabled>";
        } else {
            $paymentAccountList  = "   <select class='select2 form-control' id='payment_account_id'>";
        }
        
		$paymentAccountList .= "        <option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($accountsPrimeEntryBooks && sizeof($accountsPrimeEntryBooks) > 0) {
			foreach ($accountsPrimeEntryBooks as $accountsPrimeEntryBook) {
				$accountsPrimeEntryBookId = $accountsPrimeEntryBook->config_filed_value;

				$accountsPrimeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($accountsPrimeEntryBookId);
				$accountsPrimeEntryBookName = $accountsPrimeEntryBook[0]->prime_entry_book_name;

                if ($selectedIndex != '') {
                    $paymentAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' selected>" . $accountsPrimeEntryBookName . "</option>";
                } else {
                    $paymentAccountList .=          "<option value='" . $accountsPrimeEntryBookId  . "' >" . $accountsPrimeEntryBookName . "</option>";
                }
			}
		}
		
		$paymentAccountList .="   </select>";

		echo json_encode(array('paymentAccountList' => $paymentAccountList));
	}
    
    public function getMakePaymentDefaultPayeeTypeDropDown() {
        $defaultPayeeType = $this->system_configurations_model->getMakePaymentDefaultPayeeType();
        
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

		$makePaymentDefaultPayeeTypeDropDown = " <select class='select2 form-control' id='make_payment_default_payee_type_id'>
								<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($peopleType && sizeof($peopleType) > 0) {
			foreach ($peopleType as $row) {
				
				if ($defaultPayeeType[0]->config_filed_value == '0') {
					$makePaymentDefaultPayeeTypeDropDown .=          "<option value='" . $row['people_type']  . "' >" . $row['people_type'] . "</option>";
				} else {
					if ($defaultPayeeType[0]->config_filed_value == $row['people_type']) {
						$makePaymentDefaultPayeeTypeDropDown .=          "<option value='" . $row['people_type']  . "' selected>" . $row['people_type'] . "</option>";
					} else {
						$makePaymentDefaultPayeeTypeDropDown .=          "<option value='" . $row['people_type']  . "' >" . $row['people_type'] . "</option>";
					}
				}
			}
		}
		
		$makePaymentDefaultPayeeTypeDropDown .="   </select>";
        
        echo $makePaymentDefaultPayeeTypeDropDown;
    }
    
    public function getMakePaymentDefaultReferenceTransactionTypeDropDown() {
        $selectedReferenceTransactionType = $this->system_configurations_model->getMakePaymentDefaultReferenceTransactionType();
        $selectedIndex = $selectedReferenceTransactionType[0]->config_filed_value;
        $referenceTransactionTypeDropdown = $this->getReferenceTransactionTypesToDropDownWithSavedOption($selectedIndex);
        
        echo $referenceTransactionTypeDropdown;
    }
    
    public function getReceivePaymentDefaultPayerTypeDropDown() {
        $defaultPayeeType = $this->system_configurations_model->getReceivePaymentDefaultPayerType();
        
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
		
		$receivePaymentDefaultPayerTypeDropDown = " <select class='select2 form-control' id='receive_payment_default_payer_type_id'>
								<option value='0' >{$this->lang->line('-- Select --')}</option>";
										
		if ($peopleType && sizeof($peopleType) > 0) {
			foreach ($peopleType as $row) {
				
				if ($defaultPayeeType[0]->config_filed_value == '0') {
					$receivePaymentDefaultPayerTypeDropDown .=          "<option value='" . $row['people_type']  . "' >" . $row['people_type'] . "</option>";
				} else {
					if ($defaultPayeeType[0]->config_filed_value == $row['people_type']) {
						$receivePaymentDefaultPayerTypeDropDown .=          "<option value='" . $row['people_type']  . "' selected>" . $row['people_type'] . "</option>";
					} else {
						$receivePaymentDefaultPayerTypeDropDown .=          "<option value='" . $row['people_type']  . "' >" . $row['people_type'] . "</option>";
					}
				}
			}
		}
		
		$receivePaymentDefaultPayerTypeDropDown .="   </select>";
        
        echo $receivePaymentDefaultPayerTypeDropDown;
    }
    
    public function getReceivePaymentDefaultReferenceTransactionTypeDropDown() {
        $selectedReferenceTransactionType = $this->system_configurations_model->getReceivePaymentDefaultReferenceTransactionType();
        $selectedIndex = $selectedReferenceTransactionType[0]->config_filed_value;
        $referenceTransactionTypeDropdown = $this->getReferenceTransactionTypesToDropDownWithSavedOption($selectedIndex);
        
        echo $referenceTransactionTypeDropdown;
    }
    
    public function getReferenceTransactionTypesToDropDownWithSavedOption($selectedIndex) {
		return $this->common_functions->getReferenceTransactionTypesToDropDownWithSavedOption($selectedIndex);
	}
}
