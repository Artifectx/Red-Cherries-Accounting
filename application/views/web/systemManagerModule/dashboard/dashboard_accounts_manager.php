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
?>

<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>

				<div class='page-header page-header-with-buttons'>
					<h1 class='pull-left'>
						<i class='icon-dashboard'></i>
						<span><?php echo $this->lang->line('Accounts Manager Dashboard') ?></span>
					</h1>
				</div>
								
				<div class='box-content'>
					<div class='tabbable' style='margin-top: 20px'>
						<ul class='nav nav-responsive nav-tabs'>
							<?php
								if(isset($ACM_View_Module_Permissions)) {
									?>
									<?php
									if (isset($ACM_Admin_View_Dashboard_Permissions)) { ?>
										<li class='active'>
											<a data-toggle='tab' class="tab-header" href='#statistics'><?php echo $this->lang->line('Statistics') ?></a>
										</li>
							<?php
									}
								}
							?>
							<li class=' <?php if (isset($ACM_Admin_View_Dashboard_Permissions) == false) {echo 'active';} ?>'>
								<a data-toggle='tab' class="tab-header" href='#quick_links'><?php echo $this->lang->line('Quick Links') ?></a>
							</li>
						</ul>
						<div class='tab-content'>
							<?php
							if(isset($ACM_View_Module_Permissions)) {
								?>
								<?php
								if (isset($ACM_Admin_View_Dashboard_Permissions)) { ?>
									<div id="statistics" class="tab-pane active">
										<div class='box'>
											<div class='row'>
												<div class='col-sm-6'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content'>
																<form class='form form-horizontal validate-form save_form' method="post">
																	<div class='form-group'>
																		<label class='control-label col-sm-8' style="font-size:16px; color:blue;"><?php echo $this->lang->line('Income Vs Expense') ?></label>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group'>
																			<div class='col-sm-7' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Analytical Period') ?></label>
																			</div>
																			<div class='col-sm-5' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Location') ?></label>
																			</div>
																		</div>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group col-sm-7'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select class="form-control" id="income_vs_expense_analytical_period" name="income_vs_expense_analytical_period" onchange="handleIncomeVsExpenseAnalyticalPeriodSelect(this.id);">
																					<option value="1" Selected><?php echo $this->lang->line('This Financial Year') ?></option>
																					<option value="2"><?php echo $this->lang->line('Last Financial Year') ?></option>
																					<option value="3"><?php echo $this->lang->line('Compare With Last Financial Year') ?></option>
																					<option value="4"><?php echo $this->lang->line('Current Month Weekly Status') ?></option>
																					<option value="5"><?php echo $this->lang->line('Last Month Weekly Status') ?></option>
																					<option value="6"><?php echo $this->lang->line('First Quarter of This Financial Year') ?></option>
																					<option value="7"><?php echo $this->lang->line('Second Quarter of This Financial Year') ?></option>
																					<option value="8"><?php echo $this->lang->line('Third Quarter of This Financial Year') ?></option>
																					<option value="9"><?php echo $this->lang->line('Fourth Quarter of This Financial Year') ?></option>
																				</select>
																			</div>			
																		</div>
																		<div class='form-group col-sm-5'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select id="location_init_in_income_vs_expense" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="location_dropdown_in_income_vs_expense"></div>
																			</div>			
																		</div>		
																	</div>
																</form>
																<div class='box-content light_color_background_for_graph' id="income_vs_expense_graph_result" style="text-align: center;">
																	<div class='loader_income_vs_expense' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loaders/4.gif"/> Loading the graph...</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class='col-sm-6'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content'>
																<form class='form form-horizontal validate-form save_form' method="post">
																	<div class='form-group'>
																		<label class='control-label col-sm-8' style="font-size:16px; color:blue;"><?php echo $this->lang->line('Summary of Assets') ?></label>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group'>
																			<div class='col-sm-7' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Graph Type') ?></label>
																			</div>
																			<div class='col-sm-5' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Location') ?></label>
																			</div>
																		</div>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group col-sm-7'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select class="form-control" id="assets_graph_type" name="assets_graph_type" onchange="handleAssetsGraphTypeSelect(this.id);">
																					<option value="1" Selected><?php echo $this->lang->line('Assets Percentage Summary') ?></option>
																					<option value="2"><?php echo $this->lang->line('Assets Value Summary') ?></option>
																				</select>
																			</div>			
																		</div>	
																		<div class='form-group col-sm-5'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select id="location_init_in_summary_of_assets" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="location_dropdown_in_summary_of_assets"></div>
																			</div>			
																		</div>
																	</div>
																</form>
																<div class='box-content light_color_background_for_graph' id="assets_graph_result" style="text-align: center;">
																	<div class='loader_assets' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loaders/4.gif"/> Loading the graph...</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
															
											<div class='row'>
												<div class='col-sm-6'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content'>
																<form class='form form-horizontal validate-form save_form' method="post">
																	<div class='form-group'>
																		<label class='control-label col-sm-8' style="font-size:16px; color:blue;"><?php echo $this->lang->line('Summary of Liabilities') ?></label>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group'>
																			<div class='col-sm-7' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Graph Type') ?></label>
																			</div>
																			<div class='col-sm-5' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Location') ?></label>
																			</div>
																		</div>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group col-sm-7'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select class="form-control" id="liabilities_graph_type" name="liabilities_graph_type" onchange="handleLiabilitiesGraphTypeSelect(this.id);">
																					<option value="1" Selected><?php echo $this->lang->line('Liabilities Percentage Summary') ?></option>
																					<option value="2"><?php echo $this->lang->line('Liabilities Value Summary') ?></option>
																				</select>
																			</div>			
																		</div>
																		<div class='form-group col-sm-5'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select id="location_init_in_summary_of_liabilities" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="location_dropdown_in_summary_of_liabilities"></div>
																			</div>			
																		</div>
																	</div>
																</form>
																<div class='box-content light_color_background_for_graph' id="liabilities_graph_result" style="text-align: center;">
																	<div class='loader_liabilities' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loaders/4.gif"/> Loading the graph...</div>
																</div>
															</div>
														</div>
													</div>
												</div>	
												<div class='col-sm-6'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content'>
																<form class='form form-horizontal validate-form save_form' method="post">
																	<div class='form-group'>
																		<label class='control-label col-sm-9' style="font-size:16px; color:blue;"><?php echo $this->lang->line('Top Ten Expense Accounts') ?></label>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group'>
																			<div class='col-sm-7' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Graph Type') ?></label>
																			</div>
																			<div class='col-sm-5' style="width: 50%; margin: 0 auto;">
																				<label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Location') ?></label>
																			</div>
																		</div>
																	</div>
																	<div class="row" style="width: 100%; margin: 0 auto;">
																		<div class='form-group col-sm-7'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select class="form-control" id="top_expense_graph_type" name="top_expense_graph_type" onchange="handleTopExpenseGraphTypeSelect(this.id);">
																					<option value="1" Selected><?php echo $this->lang->line('Top Ten Expense Accounts Percentage Summary') ?></option>
																					<option value="2"><?php echo $this->lang->line('Top Ten Expense Accounts Value Summary') ?></option>
																				</select>
																			</div>			
																		</div>
																		<div class='form-group col-sm-5'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select id="location_init_in_expense_accounts" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="location_dropdown_in_expense_accounts"></div>
																			</div>			
																		</div>
																	</div>
																</form>
																<div class='box-content light_color_background_for_graph' id="top_expense_graph_result" style="text-align: center;">
																	<div class='loader_top_expense' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loaders/4.gif"/> Loading the graph...</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
															
											<div class='row'>
												<div class='col-sm-6'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content'>
																<form class='form form-horizontal validate-form save_form' method="post">
																	<div class='form-group'>
																		<label class='control-label col-sm-7' style="font-size:16px; color:blue;"><?php echo $this->lang->line('Debtor List') ?></label>
																	</div>
																	<div class='form-group'>
                                                                        <div class='col-sm-7' style="width: 50%; margin: 0 auto;">
                                                                            <label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Debtor Total') ?></label>
                                                                        </div>
                                                                        <div class='col-sm-5' style="width: 50%; margin: 0 auto;">
                                                                            <label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Location') ?></label>
                                                                        </div>
																	</div>
                                                                    <div class='form-group'>
                                                                        <div class='form-group col-sm-7'>
                                                                            <div class='col-sm-12 controls'>
                                                                                <input class='form-control' id='debtor_total' name='debtor_total'
                                                                                       placeholder='<?php echo $this->lang->line('Debtor Total') ?>' type='text' value="">
                                                                            </div>
                                                                        </div>
                                                                        <div class='form-group col-sm-5'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select id="location_init_in_debtor_list" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="location_dropdown_in_debtor_list"></div>
																			</div>			
																		</div>
																	</div>
																</form>
																<div class='loader_debtor_list' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loaders/4.gif"/> Loading data...</div>
																<div id="debtorDataTable">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class='col-sm-6'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content'>
																<form class='form form-horizontal validate-form save_form' method="post">
																	<div class='form-group'>
																		<label class='control-label col-sm-7' style="font-size:16px; color:blue;"><?php echo $this->lang->line('Creditor List') ?></label>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-7' style="width: 50%; margin: 0 auto;">
                                                                            <label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Creditor Total') ?></label>
                                                                        </div>
                                                                        <div class='col-sm-5' style="width: 50%; margin: 0 auto;">
                                                                            <label class='control-label col-sm-12' style="text-align:left"><?php echo $this->lang->line('Location') ?></label>
                                                                        </div>
																	</div>
                                                                    <div class='form-group'>
                                                                        <div class='form-group col-sm-7'>
                                                                            <div class='col-sm-12 controls'>
                                                                                <input class='form-control' id='creditor_total' name='creditor_total'
                                                                                       placeholder='<?php echo $this->lang->line('Creditor Total') ?>' type='text' value="">
                                                                            </div>
                                                                        </div>
                                                                        <div class='form-group col-sm-5'>
																			<div class='col-sm-12 controls' style="width: 100%; margin: 0 auto;">
																				<select id="location_init_in_creditor_list" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="location_dropdown_in_creditor_list"></div>
																			</div>			
																		</div>
																	</div>
																</form>
																<div class='loader_creditor_list' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loaders/4.gif"/> Loading data...</div>
																<div id="creditorDataTable">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							}
							?>
											
							<div id="quick_links" class="tab-pane <?php if (isset($ACM_Admin_View_Dashboard_Permissions) == false) {echo 'active';} ?>">
								<?php
								if(isset($ACM_View_Module_Permissions)) {
									if(isset($ACM_Admin_View_Chart_Of_Accounts_Permissions) || isset($ACM_Admin_View_Prime_Entry_Book_Permissions) ||
									   isset($ACM_Admin_View_Bank_Permissions) || isset($ACM_Admin_View_System_Configurations_Permissions)) {
									?>
										<div class='box'>
											<div class='row'>
												<div class='col-sm-12'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
																<ul class="dash">
																	<h3 align="left"><?php echo $this->lang->line('Administration') ?></h3>

																	<p style="margin-bottom:0px">&nbsp;</p>
																	<?php
																	if(isset($ACM_Admin_View_Chart_Of_Accounts_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller"
																			   title="<?php echo $this->lang->line('Chart of Accounts') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/chart_of_accounts.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Chart of Accounts') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Admin_View_Prime_Entry_Book_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller"
																			   title="<?php echo $this->lang->line('Prime Entry Books') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/prime_entry_book.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Prime Entry Books') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Admin_View_Bank_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller"
																			   title="<?php echo $this->lang->line('Bank') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/bank.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Bank') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if (isset($ACM_Admin_View_System_Configurations_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller"
																			   title="<?php echo $this->lang->line('System Configurations') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/configurations.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('System Configurations') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	?>
																	<li>
																		<a class="tip"
																		   href="<?php echo base_url(); ?>accountsManagerModule/adminSection/admin_help_controller"
																		   title="<?php echo $this->lang->line('Help') ?>">
																			<i><img src="<?php echo base_url(); ?>assets/images/icons/help.png"
																					alt=""/></i>
																			<span><span><?php echo $this->lang->line('Help') ?></span></span>
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
								<?php
									}

									if(isset($ACM_Bookkeeping_View_Journal_Entry_Permissions) || isset($ACM_Bookkeeping_View_General_Ledger_Permissions) ||
									   isset($ACM_Bookkeeping_View_Purchase_Note_Permissions) || isset($ACM_Bookkeeping_View_Sales_Note_Permissions) ||
								       isset($ACM_Bookkeeping_View_Customer_Return_Note_Permissions) || isset($ACM_Bookkeeping_View_Supplier_Return_Note_Permissions) || 
								       isset($ACM_Bookkeeping_View_Receive_Payment_Permissions) || isset($ACM_Bookkeeping_View_Make_Payment_Permissions) || 
                                       isset($ACM_Bookkeeping_View_Cheques_Permissions) || isset($ACM_Bookkeeping_View_Account_Balance_Permissions) ||
									   isset($ACM_Bookkeeping_View_Stakeholder_Account_Balance_Permissions) || isset($ACM_Bookkeeping_View_Opening_Balances_Permissions)) {
									?>
										<div class='box'>
											<div class='row'>
												<div class='col-sm-12'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
																<ul class="dash">
																	<h3 align="left"><?php echo $this->lang->line('Bookkeeping') ?></h3>

																	<p style="margin-bottom:0px">&nbsp;</p>
																	<?php
																	if(isset($ACM_Bookkeeping_View_Journal_Entry_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller"
																			   title="<?php echo $this->lang->line('Journal Entries') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/journal_entry.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Journal Entries') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Bookkeeping_View_Purchase_Note_Permissions)) {
																		if ($systemConfigData['bookkeeping_purchase_note'] == "Yes") {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/purchase_note_controller"
																			   title="<?php echo $this->lang->line('Purchase Note') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/purchase_note.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Purchase Note') ?></span></span>
																			</a>
																		</li>
																		<?php
																		}
																	}
																	if(isset($ACM_Bookkeeping_View_Sales_Note_Permissions)) {
																		if ($systemConfigData['bookkeeping_sales_note'] == "Yes") {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller"
																			   title="<?php echo $this->lang->line('Sales Note') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/sales_note.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Sales Note') ?></span></span>
																			</a>
																		</li>
																		<?php
																		}
																	}
																	if(isset($ACM_Bookkeeping_View_Customer_Return_Note_Permissions)) {
																		if ($systemConfigData['bookkeeping_customer_return_note'] == "Yes") {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller"
																			   title="<?php echo $this->lang->line('Customer Return Note') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/customer_return_note.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Customer Return Note') ?></span></span>
																			</a>
																		</li>
																		<?php
																		}
																	}
																	if(isset($ACM_Bookkeeping_View_Supplier_Return_Note_Permissions)) {
																		if ($systemConfigData['bookkeeping_supplier_return_note'] == "Yes") {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/supplier_return_note_controller"
																			   title="<?php echo $this->lang->line('Supplier Return Note') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/supplier_return_note.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Supplier Return Note') ?></span></span>
																			</a>
																		</li>
																		<?php
																		}
																	}
																	if(isset($ACM_Bookkeeping_View_Receive_Payment_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller"
																			   title="<?php echo $this->lang->line('Receive Payment') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/receive_payment.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Receive Payment') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Bookkeeping_View_Make_Payment_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller"
																			   title="<?php echo $this->lang->line('Make Payment') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/make_payment.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Make Payment') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Bookkeeping_View_Cheques_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller"
																			   title="<?php echo $this->lang->line('Cheque List') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/cheque_list.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Cheque List') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Bookkeeping_View_Account_Balance_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/account_balances_controller"
																			   title="<?php echo $this->lang->line('Chart Of Account Balances') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/account_balances.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Chart Of Account Balances') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Bookkeeping_View_Stakeholder_Account_Balance_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/stakeholder_account_balances_controller"
																			   title="<?php echo $this->lang->line('Stakeholder Account Balances') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/stakeholder_acc_balance.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Stakeholder Account Balances') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	if(isset($ACM_Bookkeeping_View_General_Ledger_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller"
																			   title="<?php echo $this->lang->line('General Ledger') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/general_ledger.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('General Ledger') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
                                                                    if($ACM_Bookkeeping_View_Opening_Balances_Permissions) {
                                                                        ?>
                                                                        <li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/opening_balances_controller"
																			   title="<?php echo $this->lang->line('Opening Balances') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/opening_balances.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Opening Balances') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
                                                                    ?>
																	<li>
																		<a class="tip"
																		   href="<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/bookkeeping_help_controller"
																		   title="<?php echo $this->lang->line('Help') ?>">
																			<i><img src="<?php echo base_url(); ?>assets/images/icons/help.png"
																					alt=""/></i>
																			<span><span><?php echo $this->lang->line('Help') ?></span></span>
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
								<?php
									}

									if(isset($ACM_Reports_View_Bookkeeping_Report_Permissions)) {
									?>
										<div class='box'>
											<div class='row'>
												<div class='col-sm-12'>
													<div class='text-center'>
														<div class='box'>
															<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
																<ul class="dash">
																	<h3 align="left"><?php echo $this->lang->line('Reports') ?></h3>

																	<p style="margin-bottom:0px">&nbsp;</p>
																	<?php
																	if(isset($ACM_Reports_View_Bookkeeping_Report_Permissions)) {
																		?>
																		<li>
																			<a class="tip"
																			   href="<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller"
																			   title="<?php echo $this->lang->line('Bookkeeping Repors') ?>">
																				<i><img src="<?php echo base_url(); ?>assets/images/icons/book_keeping.png"
																						alt=""/></i>
																				<span><span><?php echo $this->lang->line('Bookkeeping Reports') ?></span></span>
																			</a>
																		</li>
																		<?php
																	}
																	?>
																	<li>
																		<a class="tip"
																		   href="<?php echo base_url(); ?>accountsManagerModule/reportsSection/accounts_report_help_controller"
																		   title="<?php echo $this->lang->line('Help') ?>">
																			<i><img src="<?php echo base_url(); ?>assets/images/icons/help.png"
																					alt=""/></i>
																			<span><span><?php echo $this->lang->line('Help') ?></span></span>
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
								<?php
									}
								}
								?>	
							</div>
						</div>
					</div>
				</div>
								
<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>
	
	var CurrentFinancialYearStartDate = '';
	var CurrentFinancialYearEndDate = '';
	var LastFinancialYearStartDate = '';
	var LastFinancialYearEndDate = '';
	var FirstQuarterStartDate = '';
	var FirstQuarterEndDate = '';
	var SecondQuarterStartDate = '';
	var SecondQuarterEndDate = '';
	var ThirdQuarterStartDate = '';
	var ThirdQuarterEndDate = '';
	var FourthQuarterStartDate = '';
	var FourthQuarterEndDate = '';
		
	$(document).ready(function () {
		
		Dashboard.getFinancialYearData();
		Dashboard.getLocationData();

		//Draw Income Vs Expense Graphs
		setTimeout(function(){
			Dashboard.getTopTenExpenseAccountsComparisonDetails(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate, 'SemiDonutGraph');
			Dashboard.getDebtorList(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate);
			Dashboard.getCreditorList(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate);
			Dashboard.getLiabilitiesComparisonDetails('SemiDonutGraph');
		}, 2000);
		
		setTimeout(function(){
			Dashboard.getAssetsComparisonDetails('SemiDonutGraph');
		}, 12000);
		
		setTimeout(function(){
			Dashboard.getIncomeAndExpenseComparisonDetails(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '');
		}, 16000);
	});
	
	function handleIncomeVsExpenseAnalyticalPeriodSelect(id) {
		var option = $("#" + id).val();
		
		var fromDate = '';
		var toDate = '';
		
		var currentTime = new Date();
		var year = currentTime.getFullYear();
		var month = currentTime.getMonth() + 1
		var days = daysInMonth(month, year);
		
		var locationId = $("#location_id_in_income_vs_expense").val();

		if (option == "1") {
			//This financial year
			Dashboard.getIncomeAndExpenseComparisonDetails(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		} else if (option == "2") {
			//Last financial year
			Dashboard.getIncomeAndExpenseComparisonDetails(LastFinancialYearStartDate, LastFinancialYearEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		} else if (option == "3") {
			//Compare with last financial year
			Dashboard.getIncomeAndExpenseComparisonDetails(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', 'Yes', LastFinancialYearStartDate, LastFinancialYearEndDate, locationId);
		} else if (option == "4") {
			//Current month weekly status
			fromDate = year + '-' + month + '-01';
			toDate = year + '-' + month + '-' + days;
			Dashboard.getIncomeAndExpenseComparisonDetails(fromDate, toDate, month, 'WeeklyGraph', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		} else if (option == "5") {
			//Last month weekly status
			month = month - 1;
			fromDate = year + '-' + month + '-01';
			toDate = year + '-' + month + '-' + days;
			Dashboard.getIncomeAndExpenseComparisonDetails(fromDate, toDate, month, 'WeeklyGraph', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		} else if (option == "6") {
			//First quarter of the financial year
			Dashboard.getIncomeAndExpenseComparisonDetails(FirstQuarterStartDate, FirstQuarterEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		} else if (option == "7") {
			//Second quarter of the financial year
			Dashboard.getIncomeAndExpenseComparisonDetails(SecondQuarterStartDate, SecondQuarterEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		} else if (option == "8") {
			//Third quarter of the financial year
			Dashboard.getIncomeAndExpenseComparisonDetails(ThirdQuarterStartDate, ThirdQuarterEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		} else if (option == "9") {
			//Fourth quarter of the financial year
			Dashboard.getIncomeAndExpenseComparisonDetails(FourthQuarterStartDate, FourthQuarterEndDate, '', '', 'BarGraph', 'Income Vs Expense', 'Income & Expense', 'Amount', '470', '300', '', '', '', locationId);
		}
	}
	
	function handleAssetsGraphTypeSelect(id) {
		var option = $("#" + id).val();
		var chartType = '';
		
		var locationId = $("#location_id_in_summary_of_assets").val();
		
		if (option == '1') {
			chartType = "SemiDonutGraph";
		} else if (option == '2') {
			chartType = "Bar3DGraph";
		}
		
		Dashboard.getAssetsComparisonDetails(chartType, locationId);
	}
	
	function handleLiabilitiesGraphTypeSelect(id) {
		var option = $("#" + id).val();
		var chartType = '';
		
		var locationId = $("#location_id_in_summary_of_liabilities").val();
		
		if (option == '1') {
			chartType = "SemiDonutGraph";
		} else if (option == '2') {
			chartType = "Bar3DGraph";
		}
		
		Dashboard.getLiabilitiesComparisonDetails(chartType, locationId);
	}
	
	function handleTopExpenseGraphTypeSelect(id) {
		var option = $("#" + id).val();
		var chartType = '';
		
		var locationId = $("#location_id_in_expense_accounts").val();
		
		if (option == '1') {
			chartType = "SemiDonutGraph";
		} else if (option == '2') {
			chartType = "Bar3DGraph";
		}
		
		Dashboard.getTopTenExpenseAccountsComparisonDetails(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate, chartType, locationId);
	}
	
	function handleLocationSelect (id) {
		if (id == "location_id_in_income_vs_expense") {
			handleIncomeVsExpenseAnalyticalPeriodSelect("income_vs_expense_analytical_period", '');
		} else if (id == "location_id_in_summary_of_assets") {
			handleAssetsGraphTypeSelect("assets_graph_type", '');
		} else if (id == "location_id_in_summary_of_liabilities") {
			handleLiabilitiesGraphTypeSelect("liabilities_graph_type", '');
		} else if (id == "location_id_in_expense_accounts") {
			handleTopExpenseGraphTypeSelect("top_expense_graph_type", '');
		} else if (id == "location_id_in_debtor_list") {
			Dashboard.getDebtorList(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate);
		} else if (id == "location_id_in_creditor_list") {
			Dashboard.getCreditorList(CurrentFinancialYearStartDate, CurrentFinancialYearEndDate);
		}
	}
	
	function daysInMonth (month, year) {
		return new Date(year, month, 0).getDate();
	}
	
	var Dashboard = {
		
		//Get income and expense comparision details
		getIncomeAndExpenseComparisonDetails: function (fromDate, toDate, month, weeklyGraph, chartType, displayGraphTitle, xAxisTitle, yAxisTitle, graphHeight, graphWidth, compareWithLastFinancialYear, lastFinancialYearStartDate, lastFinancialYearEndDate, locationId){
			
			$("#income_vs_expense_graph_result").empty();
			$("#income_vs_expense_graph_result").append("<div class='loader_income_vs_expense' align='center'><img src='<?php echo base_url();?>assets/images/ajax-loaders/4.gif'/> Loading the graph...</div>");
			$(".loader_income_vs_expense").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/getIncomeAndExpenseComparisonDetails",
				data: {
					'from_date' : fromDate,
					'to_date' : toDate,
					'month' : month,
					'weekly_graph' : weeklyGraph,
					'chart_type' : chartType,
					'display_graph_title' : displayGraphTitle,
					'x_axix_title' : xAxisTitle,
					'y_axix_title' : yAxisTitle,
					'graph_height' : graphHeight,
					'graph_width' : graphWidth,
					'compare_with_last_financial_year' : compareWithLastFinancialYear,
					'last_financial_year_start_date' : lastFinancialYearStartDate,
					'last_financial_year_end_date' : lastFinancialYearEndDate,
					'location_id' : locationId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$(".loader_income_vs_expense").hide();
					if (response == "report_not_generated") {
						$("#income_vs_expense_graph_result").width(470).height(305);
						$("#income_vs_expense_graph_result").html('<?php echo $this->lang->line("Data not available"); ?>');
					} else {
						$("#income_vs_expense_graph_result").html(response);
					}
				}
			});
		},
		
		//Get assets comparision details
		getAssetsComparisonDetails: function (chartType, locationId){
			
			$("#assets_graph_result").empty();
			$("#assets_graph_result").append("<div class='loader_assets' align='center'><img src='<?php echo base_url();?>assets/images/ajax-loaders/4.gif'/> Loading the graph...</div>");
			$(".loader_assets").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/getAssetsComparisonDetails",
				data: {
					'chart_type' : chartType,
					'location_id' : locationId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$(".loader_assets").hide();
					if (response == "report_not_generated") {
						$("#assets_graph_result").width(470).height(305);
						$("#assets_graph_result").html('<?php echo $this->lang->line("Data not available"); ?>');
					} else {
						$("#assets_graph_result").html(response);
					}
				}
			});
		},
		
		//Get liabilities comparision details
		getLiabilitiesComparisonDetails: function (chartType, locationId){
			
			$("#liabilities_graph_result").empty();
			$("#liabilities_graph_result").append("<div class='loader_liabilities' align='center'><img src='<?php echo base_url();?>assets/images/ajax-loaders/4.gif'/> Loading the graph...</div>");
			$(".loader_liabilities").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/getLiabilitiesComparisonDetails",
				data: {
					'chart_type' : chartType,
					'location_id' : locationId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$(".loader_liabilities").hide();
					if (response == "report_not_generated") {
						$("#liabilities_graph_result").width(470).height(305);
						$("#liabilities_graph_result").html('<?php echo $this->lang->line("Data not available"); ?>');
					} else {
						$("#liabilities_graph_result").html(response);
					}
				}
			});
		},
		
		//Get top ten expense accounts comparision details
		getTopTenExpenseAccountsComparisonDetails: function (fromDate, toDate, chartType, locationId){
			
			$("#top_expense_graph_result").empty();
			$("#top_expense_graph_result").append("<div class='loader_top_expense' align='center'><img src='<?php echo base_url();?>assets/images/ajax-loaders/4.gif'/> Loading the graph...</div>");
			$(".loader_top_expense").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/getTopTenExpenseAccountsComparisonDetails",
				data: {
					'from_date' : fromDate,
					'to_date' : toDate,
					'chart_type' : chartType,
					'location_id' : locationId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$(".loader_top_expense").hide();
					if (response == "report_not_generated") {
						$("#top_expense_graph_result").width(470).height(305);
						$("#top_expense_graph_result").html('<?php echo $this->lang->line("Data not available"); ?>');
					} else {
						$("#top_expense_graph_result").html(response);
					}
				}
			});
		},
		
		//Get debtor list
		getDebtorList: function (fromDate, toDate){
        
            var locationId = $("#location_id_in_debtor_list").val();
			
			$(".loader_debtor_list").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/debtorDataTable",
				data: {
					'from_date' : fromDate,
					'to_date' : toDate,
                    'location_id' : locationId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$("#debtor_total").val(response.debtorTotal);
					$(".loader_debtor_list").hide();
					$("#debtorDataTable").html(response.html);
					$('.debtorList').dataTable();
				}
			});
		},
		
		//Get creditor list
		getCreditorList: function (fromDate, toDate){
            
            var locationId = $("#location_id_in_creditor_list").val();
			
			$(".loader_creditor_list").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/creditorDataTable",
				data: {
					'from_date' : fromDate,
					'to_date' : toDate,
                    'location_id' : locationId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$("#creditor_total").val(response.creditorTotal);
					$(".loader_creditor_list").hide();
					$("#creditorDataTable").html(response.html);
					$('.creditorList').dataTable();
				}
			});
		},
		
		//get financial year data
		getFinancialYearData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getFinancialYearData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
					function (response) {
						CurrentFinancialYearStartDate = response.currentFinancialYearStartDate;
						CurrentFinancialYearEndDate = response.currentFinancialYearEndDate;
						LastFinancialYearStartDate = response.lastFinancialYearStartDate;
						LastFinancialYearEndDate = response.lastFinancialYearEndDate;
						FirstQuarterStartDate = response.firstQuarterStartDate;
						FirstQuarterEndDate = response.firstQuarterEndDate;
						SecondQuarterStartDate = response.secondQuarterStartDate;
						SecondQuarterEndDate = response.secondQuarterEndDate;
						ThirdQuarterStartDate = response.thirdQuarterStartDate;
						ThirdQuarterEndDate = response.thirdQuarterEndDate;
						FourthQuarterStartDate = response.fourthQuarterStartDate;
						FourthQuarterEndDate = response.fourthQuarterEndDate;
					}
			})
		},
		
		//get locations drop down
		getLocationData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getAllToLocationsDropDownWithoutLabel",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#location_init_in_income_vs_expense').hide();
						$("#location_dropdown_in_income_vs_expense").html(response);
						$("#location").prop({id : "location_id_in_income_vs_expense"});
						
						$('#location_init_in_summary_of_assets').hide();
						$("#location_dropdown_in_summary_of_assets").html(response);
						$("#location").prop({id : "location_id_in_summary_of_assets"});
						
						$('#location_init_in_summary_of_liabilities').hide();
						$("#location_dropdown_in_summary_of_liabilities").html(response);
						$("#location").prop({id : "location_id_in_summary_of_liabilities"});
						
						$('#location_init_in_expense_accounts').hide();
						$("#location_dropdown_in_expense_accounts").html(response);
						$("#location").prop({id : "location_id_in_expense_accounts"});
                        
                        $('#location_init_in_debtor_list').hide();
						$("#location_dropdown_in_debtor_list").html(response);
						$("#location").prop({id : "location_id_in_debtor_list"});
                        
                        $('#location_init_in_creditor_list').hide();
						$("#location_dropdown_in_creditor_list").html(response);
						$("#location").prop({id : "location_id_in_creditor_list"});
					}
			})
		},
	}
</script>
				
<style>
	.light_color_background_for_graph {
		background: #14ace1  ;
	}
</style>