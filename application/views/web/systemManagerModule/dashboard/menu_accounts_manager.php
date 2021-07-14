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

    $moduleSections = $this->user_model->getAllModuleSectionsBySystemModuleName('Accounts Manager', 'module_section_name', 'asc');
    $moduleSectionStatus = array();
    foreach($moduleSections as $row){
        $moduleSectionStatus[$row->module_section_name]=$row->module_section_status;
    }

    //Administration Section
    if (isset($ul_class_administration_section)) $ul_class_administration = $ul_class_administration_section;
    else $ul_class_administration = 'nav nav-stacked';
    
    //Bookkeeping Section
    if (isset($ul_class_bookkeeping_section)) $ul_class_bookkeeping = $ul_class_bookkeeping_section;
    else $ul_class_bookkeeping = 'nav nav-stacked';
    
    //Reports Section
    if (isset($ul_class_report_section)) $ul_class_report = $ul_class_report_section;
    else $ul_class_report = 'nav nav-stacked';

?>
<div id='wrapper'>
	<div id='main-nav-bg'></div>
	<nav id='main-nav'>
		<div class='navigation'>
			<ul class='nav nav-stacked'>
				<li class='active'>
					<a class="menuBox" href='<?php echo base_url(); ?>systemManagerModule/dashboard_controller/dashboardAccountsManager'>
						<i class='icon-dashboard' ></i>
						<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Dashboard - Accounts Manager') ?></span>
					</a>
				</li>
				<?php
				if($moduleSectionStatus['Administration']==1 && isset($ACM_View_Module_Permissions)) {
					if (isset($ACM_Admin_View_Chart_Of_Accounts_Permissions) || isset($ACM_Admin_View_Prime_Entry_Book_Permissions) || 
						isset($ACM_Admin_View_System_Configurations_Permissions)) {
				?>
						<li class=''>
							<a class='dropdown-collapse menuBox' href='#'><i class='icon-briefcase'></i>
								<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Administration') ?></span>
								<i class='icon-angle-down angle-down'></i>
							</a>

							<ul class='<?php echo $ul_class_administration; ?>'>
								<?php
								if(isset($ACM_Admin_View_Chart_Of_Accounts_Permissions)) {
									?>
									<li class='<?php if ($li_class_chart_of_accounts) echo $li_class_chart_of_accounts; else ''; ?>'>
										<a href='<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Chart of Accounts') ?></span>
										</a>
									</li>
									<?php
								}

								if(isset($ACM_Admin_View_Prime_Entry_Book_Permissions)) {
									?>
									<li class='<?php if ($li_class_prime_entry_books) echo $li_class_prime_entry_books; else ''; ?>'>
										<a href='<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Prime Entry Books') ?></span>
										</a>
									</li>
									<?php
								}
								
								if(isset($ACM_Admin_View_Bank_Permissions)) {
									?>
									<li class='<?php if ($li_class_bank) echo $li_class_bank; else ''; ?>'>
										<a href='<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Bank') ?></span>
										</a>
									</li>
									<?php
								}
                                
                                if(isset($ACM_Admin_View_Financial_Year_Ends_Permissions)) {
									?>
									<li class='<?php if ($li_class_financial_year_ends) echo $li_class_financial_year_ends; else ''; ?>'>
										<a href='<?php echo base_url(); ?>accountsManagerModule/adminSection/financial_year_ends_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Financial Year Ends') ?></span>
										</a>
									</li>
									<?php
								}

								if(isset($ACM_Admin_View_System_Configurations_Permissions)) {
									?>
									<li class='<?php if ($li_class_system_config) echo $li_class_system_config; else ''; ?>'>
										<a href='<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('System Configurations') ?></span>
										</a>
									</li>
									<?php
								}
								?>

								<li class='<?php if ($li_class_admin_help) echo $li_class_admin_help; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/adminSection/admin_help_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Help') ?></span>
									</a>
								</li>
							</ul>
						</li>
				<?php
					}

					if(isset($ACM_Bookkeeping_View_Journal_Entry_Permissions) || isset($ACM_Bookkeeping_View_General_Ledger_Permissions) || 
					   isset($ACM_Bookkeeping_View_Purchase_Note_Permissions) || isset($ACM_Bookkeeping_View_Sales_Note_Permissions) ||
					   isset($ACM_Bookkeeping_View_Customer_Return_Note_Permissions) || isset($ACM_Bookkeeping_View_Supplier_Return_Note_Permissions) ||
					   isset($ACM_Bookkeeping_View_Receive_Payment_Permissions) || isset($ACM_Bookkeeping_View_Make_Payment_Permissions) ||
					   isset($ACM_Bookkeeping_View_Cheques_Permissions) || isset($ACM_Bookkeeping_View_Account_Balance_Permissions) ||
					   isset($ACM_Bookkeeping_View_Stakeholder_Account_Balance_Permissions) || isset($ACM_Bookkeeping_View_Opening_Balances_Permissions)) {
				?>
					<li class=''>
						<a class='dropdown-collapse menuBox' href='#'><i class='icon-book'></i>
							<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Bookkeeping') ?></span>
							<i class='icon-angle-down angle-down'></i>
						</a>

						<ul class='<?php echo $ul_class_bookkeeping; ?>'>
							<?php
							if(isset($ACM_Bookkeeping_View_Journal_Entry_Permissions)) {
								?>
								<li class='<?php if ($li_class_journal_entry) echo $li_class_journal_entry; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Journal Entries') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($ACM_Bookkeeping_View_Purchase_Note_Permissions)) {
								if ($systemConfigData['bookkeeping_purchase_note'] == "Yes") {
								?>
								<li class='<?php if ($li_class_purchase_note) echo $li_class_purchase_note; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/purchase_note_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Purchase Note') ?></span>
									</a>
								</li>
								<?php
								}
							}
							if(isset($ACM_Bookkeeping_View_Sales_Note_Permissions)) {
								if ($systemConfigData['bookkeeping_sales_note'] == "Yes") {
								?>
								<li class='<?php if ($li_class_sales_note) echo $li_class_sales_note; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Sales Note') ?></span>
									</a>
								</li>
								<?php
								}
							}
							if(isset($ACM_Bookkeeping_View_Customer_Return_Note_Permissions)) {
								if ($systemConfigData['bookkeeping_customer_return_note'] == "Yes") {
								?>
								<li class='<?php if ($li_class_customer_return_note) echo $li_class_customer_return_note; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Customer Return Note') ?></span>
									</a>
								</li>
								<?php
								}
							}
							if(isset($ACM_Bookkeeping_View_Supplier_Return_Note_Permissions)) {
								if ($systemConfigData['bookkeeping_supplier_return_note'] == "Yes") {
								?>
								<li class='<?php if ($li_class_supplier_return_note) echo $li_class_supplier_return_note; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/supplier_return_note_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Supplier Return Note') ?></span>
									</a>
								</li>
								<?php
								}
							}
							if(isset($ACM_Bookkeeping_View_Receive_Payment_Permissions)) {
								?>
								<li class='<?php if ($li_class_receive_payment) echo $li_class_receive_payment; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Receive Payment') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($ACM_Bookkeeping_View_Make_Payment_Permissions)) {
								?>
								<li class='<?php if ($li_class_make_payment) echo $li_class_make_payment; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Make Payment') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($ACM_Bookkeeping_View_Cheques_Permissions)) {
								?>
								<li class='<?php if ($li_class_cheque_list) echo $li_class_cheque_list; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Cheque List') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($ACM_Bookkeeping_View_Account_Balance_Permissions)) {
								?>
								<li class='<?php if ($li_class_account_balances_list) echo $li_class_account_balances_list; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/account_balances_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Chart Of Account Balances') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($ACM_Bookkeeping_View_Stakeholder_Account_Balance_Permissions)) {
								?>
								<li class='<?php if ($li_class_stakeholder_account_balances_list) echo $li_class_stakeholder_account_balances_list; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/stakeholder_account_balances_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Stakeholder Account Balances') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($ACM_Bookkeeping_View_General_Ledger_Permissions)) {
								?>
								<li class='<?php if ($li_class_general_ledger) echo $li_class_general_ledger; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('General Ledger') ?></span>
									</a>
								</li>
								<?php
							}
                            if(isset($ACM_Bookkeeping_View_Opening_Balances_Permissions)) {
                                ?>
								<li class='<?php if ($li_class_opening_balances) echo $li_class_opening_balances; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/opening_balances_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Opening Balances') ?></span>
									</a>
								</li>
								<?php
                            }
							?>
							<li class='<?php if ($li_class_bookkeeping_help) echo $li_class_bookkeeping_help; else ''; ?>'>
								<a href='<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/bookkeeping_help_controller'>
									<i class='icon-caret-right'></i>
									<span><?php echo $this->lang->line('Help') ?></span>
								</a>
							</li>
						</ul>
					</li>
				<?php
					}

					if(isset($ACM_Reports_View_Bookkeeping_Report_Permissions)) {
				?>
					<li class=''>
						<a class='dropdown-collapse menuBox' href='#'><i class='icon-bar-chart'></i>
							<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Reports') ?></span>
							<i class='icon-angle-down angle-down'></i>
						</a>
						<ul class='<?php echo $ul_class_report; ?>'>
							<?php
							if(isset($ACM_Reports_View_Bookkeeping_Report_Permissions)) {
								?>
								<li class='<?php if ($li_class_bookkeeping_report) echo $li_class_bookkeeping_report; else ''; ?>'>
									<a href='<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Bookkeeping Reports') ?></span>
									</a>
								</li>
								<?php
							}
							?>
							<li class='<?php if ($li_class_account_report_help) echo $li_class_account_report_help; else ''; ?>'>
								<a href='<?php echo base_url(); ?>accountsManagerModule/reportsSection/accounts_report_help_controller'>
									<i class='icon-caret-right'></i>
									<span><?php echo $this->lang->line('Help') ?></span>
								</a>
							</li>
						</ul>
					</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
	</nav>
    
<style>
	.menuBox:hover {
		-moz-border-radius-topleft: 10px;
		-moz-border-radius-topright: 10px;
		-moz-border-radius-bottomright: 10px;
		-moz-border-radius-bottomleft: 10px;
		-webkit-border-radius: 10px 10px 10px 10px;
		border-radius: 10px 10px 10px 10px;
	}
</style>