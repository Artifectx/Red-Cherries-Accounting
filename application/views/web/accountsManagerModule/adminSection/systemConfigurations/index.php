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
				<div class='row'>
					<br>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='box'>
							<div class='box-header <?php echo BOXHEADER; ?>-background'>
								<div class='title'><?php echo $this->lang->line('System Configurations') ?></div>
								<div class='actions'>
									<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
									</a>
								</div>
							</div>

							<div class='box-content'>
								<div class='msg_data'></div>
								<form class='form form-horizontal validate-form'>
									<div class='tabbable' style='margin-top: 20px'>
										<ul class='nav nav-responsive nav-tabs'>
											<li class='active'>
												<a data-toggle='tab' class="tab-header" href='#admin_section_configurations'><?php echo $this->lang->line('Administration') ?></a>
											</li>
											<li class=''>
												<a data-toggle='tab' class="tab-header" href='#bookkeeping_section_configurations'><?php echo $this->lang->line('Bookkeeping') ?></a>
											</li>
											<li class=''>
												<a data-toggle='tab' class="tab-header" href='#reports_section_configurations'><?php echo $this->lang->line('Reports') ?></a>
											</li>
										</ul>
										<div class='tab-content'>
											<div id="admin_section_configurations" class="tab-pane active">
												<div class='tabbable' style='margin-top: 20px'>
													<ul class='nav nav-responsive nav-tabs'>
														<li class='active'>
															<a data-toggle='tab' class="tab-header" href='#admin_general_configurations'><?php echo $this->lang->line('General') ?></a>
														</li>
                                                        <li class=''>
															<a data-toggle='tab' class="tab-header" href='#admin_financial_year_ends_configurations'><?php echo $this->lang->line('Financial Year Ends') ?></a>
														</li>
													</ul>
													<div class='tab-content'>
														<div id="admin_general_configurations" class="tab-pane active">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('') ?></label>
																			<label style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Month') ?></label>
																			<label style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Day') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<div class='col-sm-2 controls'>
																				<label style="text-align : left" class='control-label col-sm-12' ><?php echo $this->lang->line('Financial Year Start') ?></label>
																			</div>
																			<div class='col-sm-2 controls'>
																				<select id="fy_start_month_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="fy_start_month_dropdown"></div>
																				<div id="fy_start_monthError" class="red"></div>
																			</div>
																			<div class='col-sm-2 controls'>
																				<select id="fy_start_day_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="fy_start_day_dropdown"></div>
																				<div id="fy_start_dayError" class="red"></div>
																			</div>
																		</div>
																		<p style="margin-bottom:-10px">&nbsp;</p>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<div class='col-sm-2 controls'>
																				<label style="text-align : left" class='control-label col-sm-12' ><?php echo $this->lang->line('Financial Year End') ?></label>
																			</div>
																			<div class='col-sm-2 controls'>
																				<select id="fy_end_month_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="fy_end_month_dropdown"></div>
																				<div id="fy_end_monthError" class="red"></div>
																			</div>
																			<div class='col-sm-2 controls'>
																				<select id="fy_end_day_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<div id="fy_end_day_dropdown"></div>
																				<div id="fy_end_dayError" class="red"></div>
																			</div>
																		</div>
																		<p style="margin-bottom:-10px">&nbsp;</p>
																		<br>
																		<hr class="light">
																	</div>
																	<div class='form-group' id="accounts_management_for_locations_use_status" 
																		<?php if ($systemConfigData['accounts_management_for_locations_use_status'] == "true" && $systemConfigData['accounts_management_for_locations'] == "Yes"){?> style="display:true; text-align:center;"<?php } 
																		else {?>style="display:none; text-align:center;"<?php } ?>>
																		<div class='col-sm-12 controls' style="display: block;">
																			<label class='control-label col-sm-12 config_use_status' style="text-align:center">
																				<?php echo $this->lang->line('Location is already used in journal entries. '
																						. 'Therefore, the configuration option is disabled.') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-4 controls'>
																			<input class="config_checkboxes" type="checkbox" name="accounts_management_for_locations" 
																				   id="accounts_management_for_locations"
																				   <?php if ($systemConfigData['accounts_management_for_locations'] == "Yes") { echo 'checked ';}
																						 if ($systemConfigData['accounts_management_for_locations_use_status'] && $systemConfigData['accounts_management_for_locations'] == "Yes") {echo 'disabled ';}?>>
																			<label for="accounts_management_for_locations" ><?php echo $this->lang->line('Enable Accounts Management For Locations') ?></label>
																		</div>
																	</div>
																					
																	<div class='form-group'>
																		<div class='col-sm-3 controls'>
																			<input class="config_checkboxes" type="checkbox" name="bookkeeping_purchase_note" id="bookkeeping_purchase_note"
																				   <?php if ($systemConfigData['bookkeeping_purchase_note'] == "Yes") { echo 'checked ';}?>>
																			<label for="bookkeeping_purchase_note" ><?php echo $this->lang->line('Enable Purchase Note') ?></label>
																		</div>
																		<div class='col-sm-3 controls'>
																			<input class="config_checkboxes" type="checkbox" name="bookkeeping_sales_note" id="bookkeeping_sales_note"
																				   <?php if ($systemConfigData['bookkeeping_sales_note'] == "Yes") { echo 'checked ';}?>>
																			<label for="bookkeeping_sales_note" ><?php echo $this->lang->line('Enable Sales Note') ?></label>
																		</div>
																		<div class='col-sm-3 controls'>
																			<input class="config_checkboxes" type="checkbox" name="bookkeeping_customer_return_note" id="bookkeeping_customer_return_note"
																				   <?php if ($systemConfigData['bookkeeping_customer_return_note'] == "Yes") { echo 'checked ';}?>>
																			<label for="bookkeeping_customer_return_note" ><?php echo $this->lang->line('Enable Customer Return Note') ?></label>
																		</div>
																		<div class='col-sm-3 controls'>
																			<input class="config_checkboxes" type="checkbox" name="bookkeeping_supplier_return_note" id="bookkeeping_supplier_return_note"
																				   <?php if ($systemConfigData['bookkeeping_supplier_return_note'] == "Yes") { echo 'checked ';}?>>
																			<label for="bookkeeping_supplier_return_note" ><?php echo $this->lang->line('Enable Supplier Return Note') ?></label>
																		</div>
																	</div>	
																					
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<input class="config_checkboxes" type="checkbox" name="bookkeeping_force_to_select_reference_transaction_for_receive_payment" id="bookkeeping_force_to_select_reference_transaction_for_receive_payment"
																				   <?php if ($systemConfigData['bookkeeping_force_to_select_reference_transaction_for_receive_payment'] == "Yes") { echo 'checked ';}?>>
																			<label for="bookkeeping_force_to_select_reference_transaction_for_receive_payment" ><?php echo $this->lang->line('Force To Select A Reference Transaction For Receive A Payment') ?></label>
																		</div>
																		<div class='col-sm-6 controls'>
																			<input class="config_checkboxes" type="checkbox" name="bookkeeping_force_to_select_reference_transaction_for_make_payment" id="bookkeeping_force_to_select_reference_transaction_for_make_payment"
																				   <?php if ($systemConfigData['bookkeeping_force_to_select_reference_transaction_for_make_payment'] == "Yes") { echo 'checked ';}?>>
																			<label for="bookkeeping_force_to_select_reference_transaction_for_make_payment" ><?php echo $this->lang->line('Force To Select A Reference Transaction For Make A Payment') ?></label>
																		</div>
																	</div>
																		
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="admin_save_general_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
                                                        <div id="admin_financial_year_ends_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
                                                                    <div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select parent liabilities chart of account') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="parent_liabilities_chart_of_account_div">
																				<select class='select form-control' id='parent_liabilities_chart_of_account' name='chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='parent_liabilities_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>
                                                                    
                                                                    <div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select parent assets chart of account') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="parent_assets_chart_of_account_div">
																				<select class='select form-control' id='parent_assets_chart_of_account' name='chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='parent_assets_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>
                                                                    
                                                                    <div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select retained earnings chart of account') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="retained_earnings_chart_of_account_div">
																				<select class='select form-control' id='retained_earnings_chart_of_account' name='chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='retained_earnings_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>
                                                                    
                                                                    <div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="admin_save_financial_year_ends_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
                                                        </div>
													</div>
												</div>
											</div>
											<div id="bookkeeping_section_configurations" class="tab-pane">
												<div class='tabbable' style='margin-top: 20px'>
													<ul class='nav nav-responsive nav-tabs'>
														<?php if ($systemConfigData['bookkeeping_purchase_note'] == "Yes") { ?>
															<li class='active'>
																<a data-toggle='tab' class="tab-header" href='#purchase_note_configurations'><?php echo $this->lang->line('Purchase Note') ?></a>
															</li>
														<?php } ?>

														<?php if ($systemConfigData['bookkeeping_sales_note'] == "Yes") { ?>
															<?php if ($systemConfigData['bookkeeping_purchase_note'] == "No") { ?>
																<li class='active'>
															<?php } else { ?>
																<li class=''>		
															<?php } ?>
																<a data-toggle='tab' class="tab-header" href='#sales_note_configurations'><?php echo $this->lang->line('Sales Note') ?></a>
															</li>
														<?php } ?>

														<?php if ($systemConfigData['bookkeeping_customer_return_note'] == "Yes") { ?>
															<li class=''>
																<a data-toggle='tab' class="tab-header" href='#customer_return_note_configurations'><?php echo $this->lang->line('Customer Return Note') ?></a>
															</li>
														<?php } ?>

														<?php if ($systemConfigData['bookkeeping_supplier_return_note'] == "Yes") { ?>
															<li class=''>
																<a data-toggle='tab' class="tab-header" href='#supplier_return_note_configurations'><?php echo $this->lang->line('Supplier Return Note') ?></a>
															</li>
														<?php } ?>
														<?php if ($systemConfigData['bookkeeping_sales_note'] == "No" && $systemConfigData['bookkeeping_purchase_note'] == "No") { ?>
															<li class='active'>
																<a data-toggle='tab' class="tab-header" href='#receive_payment_configurations'><?php echo $this->lang->line('Receive Payment') ?></a>
															</li>
														<?php } else {?>
															<li class=''>
																<a data-toggle='tab' class="tab-header" href='#receive_payment_configurations'><?php echo $this->lang->line('Receive Payment') ?></a>
															</li>
														<?php } ?>
														
														<li class=''>
															<a data-toggle='tab' class="tab-header" href='#make_payment_configurations'><?php echo $this->lang->line('Make Payment') ?></a>
														</li>
                                                        <li class=''>
															<a data-toggle='tab' class="tab-header" href='#cheque_list_configurations'><?php echo $this->lang->line('Cheque List') ?></a>
														</li>
                                                        <li class=''>
															<a data-toggle='tab' class="tab-header" href='#opening_balances_configurations'><?php echo $this->lang->line('Opening Balances') ?></a>
														</li>
													</ul>
													<div class='tab-content'>
														<?php if ($systemConfigData['bookkeeping_purchase_note'] == "Yes") { ?>
															<div id="purchase_note_configurations" class="tab-pane active">
																<div class='box'>
																	<div class='box-content light_color_background'>
																		<div class='form-group' id="purchase_note_use_status" 
																			<?php if ($systemConfigData['purchase_note_in_use'] == "true"){?> style="display:true; text-align:center;"<?php } 
																			else {?>style="display:none; text-align:center;"<?php } ?>>
																			<div class='col-sm-12 controls' style="display: block;">
																				<label class='control-label col-sm-12 config_use_status' style="text-align:center">
																					<?php echo $this->lang->line('Purchase note already in use. ' . 'Therefore, the configuration option is disabled.') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-5 controls'>
																				<input class="config_checkboxes" type="checkbox" name="purchase_note_reference_no_auto_increment" 
																					   id="purchase_note_reference_no_auto_increment" onchange="handlePurchaseNoteAutoIncrement(this.id)"
																					   <?php if ($systemConfigData['purchase_note_reference_no_auto_increment'] == "Yes") { echo 'checked ';} 
																							 if ($systemConfigData['purchase_note_in_use']) {echo 'disabled ';}?>>
																				<label for="purchase_note_reference_no_auto_increment" ><?php echo $this->lang->line('Auto Increment Purchase Note Reference Number') ?></label>
																			</div>
																		</div>

																		<div class='form-group' id="purchase_note_reference_no_config" <?php if ($systemConfigData['purchase_note_reference_no_auto_increment'] == "No"){?>style="display:none"<?php } ?>>
																			<div class='col-sm-4 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Code') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='purchase_note_reference_no_code' name='purchase_note_reference_no_code'
																						   placeholder='<?php echo $this->lang->line('Reference No Code') ?>' type='text' 
																						   value="<?php echo $systemConfigData['purchase_note_reference_no_starting_code']; ?>"
																						   <?php if ($systemConfigData['purchase_note_in_use']) {echo 'readonly ';}?>>
																					<div id="purchase_note_reference_no_codeError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-2 controls' style="text-align:right">
																				<div class='col-sm-12 controls'>
																					<input class='form-control' id='purchase_note_reference_no_separator' name='purchase_note_reference_no_separator'
																						   placeholder='<?php echo $this->lang->line('Separator') ?>' type='text' 
																						   value="<?php echo $systemConfigData['purchase_note_reference_no_separator']; ?>"
																						   <?php if ($systemConfigData['purchase_note_in_use']) {echo 'readonly ';}?>>
																					<div id="purchase_note_reference_no_separatorError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-5 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Start Number') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='purchase_note_reference_no_start_number' name='purchase_note_reference_no_start_number'
																						   placeholder='<?php echo $this->lang->line('Reference No Start Number') ?>' type='text' 
																						   value="<?php echo $systemConfigData['purchase_note_reference_no_starting_number']; ?>"
																						   <?php if ($systemConfigData['purchase_note_in_use']) {echo 'readonly ';}?>>
																					<div id="purchase_note_reference_no_start_numberError" class="red"></div>
																				</div>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<hr class="light">
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select purchase note prime entry book/s for account transactions for purchasing products') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="purchase_note_products_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="purchase_note_products_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="pnp_purchase_note_products_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="pnp_purchase_note_products_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select purchase note prime entry book/s for account transactions for products free issues') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="purchase_note_free_issues_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="purchase_note_free_issues_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="pnf_purchase_note_free_issues_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="pnf_purchase_note_free_issues_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<hr class="light">
																			<div class='col-sm-5'>
																				<?php
																				if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																					?>
																					<button class='btn btn-success' type='button' id="bookkeeping_save_purchase_note_config_data" <?php echo $menuFormatting; ?>>
																						<i class='icon-save'></i>
																						<?php echo $this->lang->line('Save') ?>
																					</button>
																					<?php
																				}
																				?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>

														<?php if ($systemConfigData['bookkeeping_sales_note'] == "Yes") { ?>
															<?php if ($systemConfigData['bookkeeping_purchase_note'] == "No") { ?>
																<div id="sales_note_configurations" class="tab-pane active">
															<?php } else { ?>
																<div id="sales_note_configurations" class="tab-pane">	
															<?php } ?>
																<div class='box'>
																	<div class='box-content light_color_background'>
																		<div class='form-group' id="sales_note_use_status" 
																			<?php if ($systemConfigData['sales_note_in_use'] == "true"){?> style="display:true; text-align:center;"<?php } 
																			else {?>style="display:none; text-align:center;"<?php } ?>>
																			<div class='col-sm-12 controls' style="display: block;">
																				<label class='control-label col-sm-12 config_use_status' style="text-align:center">
																					<?php echo $this->lang->line('Sales note already in use. ' . 'Therefore, the configuration option is disabled.') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-5 controls'>
																				<input class="config_checkboxes" type="checkbox" name="sales_note_reference_no_auto_increment" 
																					   id="sales_note_reference_no_auto_increment" onchange="handleSalesNoteAutoIncrement(this.id)"
																					   <?php if ($systemConfigData['sales_note_reference_no_auto_increment'] == "Yes") { echo 'checked ';} 
																							 if ($systemConfigData['sales_note_in_use']) {echo 'disabled ';}?>>
																				<label for="sales_note_reference_no_auto_increment" ><?php echo $this->lang->line('Auto Increment Sales Note Reference Number') ?></label>
																			</div>
																		</div>

																		<div class='form-group' id="sales_note_reference_no_config" <?php if ($systemConfigData['sales_note_reference_no_auto_increment'] == "No"){?>style="display:none"<?php } ?>>
																			<div class='col-sm-4 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Code') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='sales_note_reference_no_code' name='sales_note_reference_no_code'
																						   placeholder='<?php echo $this->lang->line('Reference No Code') ?>' type='text' 
																						   value="<?php echo $systemConfigData['sales_note_reference_no_starting_code']; ?>"
																						   <?php if ($systemConfigData['sales_note_in_use']) {echo 'readonly ';}?>>
																					<div id="sales_note_reference_no_codeError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-2 controls' style="text-align:right">
																				<div class='col-sm-12 controls'>
																					<input class='form-control' id='sales_note_reference_no_separator' name='sales_note_reference_no_separator'
																						   placeholder='<?php echo $this->lang->line('Separator') ?>' type='text' 
																						   value="<?php echo $systemConfigData['sales_note_reference_no_separator']; ?>"
																						   <?php if ($systemConfigData['sales_note_in_use']) {echo 'readonly ';}?>>
																					<div id="sales_note_reference_no_separatorError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-5 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Start Number') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='sales_note_reference_no_start_number' name='sales_note_reference_no_start_number'
																						   placeholder='<?php echo $this->lang->line('Reference No Start Number') ?>' type='text' 
																						   value="<?php echo $systemConfigData['sales_note_reference_no_starting_number']; ?>"
																						   <?php if ($systemConfigData['sales_note_in_use']) {echo 'readonly ';}?>>
																					<div id="sales_note_reference_no_start_numberError" class="red"></div>
																				</div>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<hr class="light">
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-5 controls'>
																				<label class='control-label col-sm-5'><?php echo $this->lang->line('Sales Profit Margin (%)') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='sales_profit_margin_percentage' name='sales_profit_margin_percentage' type='text' value="<?php echo $systemConfigData['sales_profit_margin_percentage']; ?>">
																					<div id="sales_profit_margin_percentageError" class="red"></div>
																				</div>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<hr class="light">
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select sales note prime entry book/s for account transactions for sales entry') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="sales_note_sales_entry_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="sales_note_sales_entry_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="sns_sales_note_sales_entry_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="sns_sales_note_sales_entry_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select sales note prime entry book/s for account transactions for cost entry') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="sales_note_cost_entry_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="sales_note_cost_entry_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="snc_sales_note_cost_entry_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="snc_sales_note_cost_entry_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select sales note prime entry book/s for account transactions for free issues') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="sales_note_free_issues_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="sales_note_free_issues_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="snf_sales_note_free_issues_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="snf_sales_note_free_issues_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select sales note prime entry book/s for account transactions for discount') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="sales_note_discount_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="sales_note_discount_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="snd_sales_note_discount_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="snd_sales_note_discount_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<hr class="light">
																			<div class='col-sm-5'>
																				<?php
																				if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																					?>
																					<button class='btn btn-success' type='button' id="bookkeeping_save_sales_note_config_data" <?php echo $menuFormatting; ?>>
																						<i class='icon-save'></i>
																						<?php echo $this->lang->line('Save') ?>
																					</button>
																					<?php
																				}
																				?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>

														<?php if ($systemConfigData['bookkeeping_customer_return_note'] == "Yes") { ?>
															<div id="customer_return_note_configurations" class="tab-pane">
																<div class='box'>
																	<div class='box-content light_color_background'>
																		<div class='form-group' id="customer_return_note_use_status" 
																			<?php if ($systemConfigData['customer_return_note_in_use'] == "true"){?> style="display:true; text-align:center;"<?php } 
																			else {?>style="display:none; text-align:center;"<?php } ?>>
																			<div class='col-sm-12 controls' style="display: block;">
																				<label class='control-label col-sm-12 config_use_status' style="text-align:center">
																					<?php echo $this->lang->line('Customer return note already in use. ' . 'Therefore, the configuration option is disabled.') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-5 controls'>
																				<input class="config_checkboxes" type="checkbox" name="customer_return_note_reference_no_auto_increment" 
																					   id="customer_return_note_reference_no_auto_increment" onchange="handleCustomerReturnAutoIncrement(this.id)"
																					   <?php if ($systemConfigData['customer_return_note_reference_no_auto_increment'] == "Yes") { echo 'checked ';} 
																							 if ($systemConfigData['customer_return_note_in_use']) {echo 'disabled ';}?>>
																				<label for="customer_return_note_reference_no_auto_increment" ><?php echo $this->lang->line('Auto Increment Customer Return Note Reference Number') ?></label>
																			</div>
																		</div>

																		<div class='form-group' id="customer_return_note_reference_no_config" <?php if ($systemConfigData['customer_return_note_reference_no_auto_increment'] == "No"){?>style="display:none"<?php } ?>>
																			<div class='col-sm-4 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Code') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='customer_return_note_reference_no_code' name='customer_return_note_reference_no_code'
																						   placeholder='<?php echo $this->lang->line('Reference No Code') ?>' type='text' 
																						   value="<?php echo $systemConfigData['customer_return_note_reference_no_starting_code']; ?>"
																						   <?php if ($systemConfigData['customer_return_note_in_use']) {echo 'readonly ';}?>>
																					<div id="customer_return_note_reference_no_codeError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-2 controls' style="text-align:right">
																				<div class='col-sm-12 controls'>
																					<input class='form-control' id='customer_return_note_reference_no_separator' name='customer_return_note_reference_no_separator'
																						   placeholder='<?php echo $this->lang->line('Separator') ?>' type='text' 
																						   value="<?php echo $systemConfigData['customer_return_note_reference_no_separator']; ?>"
																						   <?php if ($systemConfigData['customer_return_note_in_use']) {echo 'readonly ';}?>>
																					<div id="customer_return_note_reference_no_separatorError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-5 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Start Number') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='customer_return_note_reference_no_start_number' name='customer_return_note_reference_no_start_number'
																						   placeholder='<?php echo $this->lang->line('Reference No Start Number') ?>' type='text' 
																						   value="<?php echo $systemConfigData['customer_return_note_reference_no_starting_number']; ?>"
																						   <?php if ($systemConfigData['customer_return_note_in_use']) {echo 'readonly ';}?>>
																					<div id="customer_return_note_reference_no_start_numberError" class="red"></div>
																				</div>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<hr class="light">
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-5 controls'>
																				<input class="config_checkboxes" type="checkbox" name="add_customer_market_return_cost_entry_with_profit_margin" id="add_customer_market_return_cost_entry_with_profit_margin" onchange="handleCustomerMarketReturnCostEntrySelect(this.id)"
																		<?php if ($systemConfigData['add_customer_market_return_cost_entry_with_profit_margin'] == "Yes") { echo 'checked ';}?>>
																				<label for="add_customer_market_return_cost_entry_with_profit_margin" ><?php echo $this->lang->line('Add Customer Market Return Cost Entry with Profit Margin') ?></label>
																			</div>
																		</div>
																		<div class='form-group' id="customer_return_credit_profit_margin_portion_div" <?php if ($systemConfigData['add_customer_market_return_cost_entry_with_profit_margin'] == "No"){?>style="display:none"<?php } ?>>
																			<div class='col-sm-12 controls'>
																				<label class='control-label col-sm-4'><?php echo $this->lang->line('Chart of Account to Credit Profit Margin Portion') ?></label>
																				<div class='col-sm-5 controls'  id="customer_return_credit_profit_margin_chart_of_account_div">
																					<select class='select form-control' id='customer_return_credit_profit_margin_chart_of_account' name='chart_of_account'>
																						<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																					</select>
																					<div id='customer_return_credit_profit_margin_chart_of_accountError' class='red'></div>
																				</div>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<hr class="light">
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select customer saleable return note prime entry book/s for account transactions for sales entry') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="customer_saleable_return_note_sales_entry_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="customer_saleable_return_note_sales_entry_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select customer saleable return note prime entry book/s for account transactions for cost entry') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="customer_saleable_return_note_cost_entry_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="customer_saleable_return_note_cost_entry_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<hr class="light">
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select customer market return note prime entry book/s for account transactions for sales entry') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="customer_market_return_note_sales_entry_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="customer_market_return_note_sales_entry_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select customer market return note prime entry book/s for account transactions for cost entry') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="customer_market_return_note_cost_entry_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="customer_market_return_note_cost_entry_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<hr class="light">
																			<div class='col-sm-5'>
																				<?php
																				if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																					?>
																					<button class='btn btn-success' type='button' id="bookkeeping_save_customer_return_note_config_data" <?php echo $menuFormatting; ?>>
																						<i class='icon-save'></i>
																						<?php echo $this->lang->line('Save') ?>
																					</button>
																					<?php
																				}
																				?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>

														<?php if ($systemConfigData['bookkeeping_supplier_return_note'] == "Yes") { ?>		
															<div id="supplier_return_note_configurations" class="tab-pane">
																<div class='box'>
																	<div class='box-content light_color_background'>
																		<div class='form-group' id="supplier_return_note_use_status" 
																			<?php if ($systemConfigData['supplier_return_note_in_use'] == "true"){?> style="display:true; text-align:center;"<?php } 
																			else {?>style="display:none; text-align:center;"<?php } ?>>
																			<div class='col-sm-12 controls' style="display: block;">
																				<label class='control-label col-sm-12 config_use_status' style="text-align:center">
																					<?php echo $this->lang->line('Supplier return note already in use. ' . 'Therefore, the configuration option is disabled.') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-5 controls'>
																				<input class="config_checkboxes" type="checkbox" name="supplier_return_note_reference_no_auto_increment" 
																					   id="supplier_return_note_reference_no_auto_increment" onchange="handleSupplierReturnAutoIncrement(this.id)"
																					   <?php if ($systemConfigData['supplier_return_note_reference_no_auto_increment'] == "Yes") { echo 'checked ';} 
																							 if ($systemConfigData['supplier_return_note_in_use']) {echo 'disabled ';}?>>
																				<label for="supplier_return_note_reference_no_auto_increment" ><?php echo $this->lang->line('Auto Increment Supplier Return Note Reference Number') ?></label>
																			</div>
																		</div>

																		<div class='form-group' id="supplier_return_note_reference_no_config" <?php if ($systemConfigData['supplier_return_note_reference_no_auto_increment'] == "No"){?>style="display:none"<?php } ?>>
																			<div class='col-sm-4 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Code') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='supplier_return_note_reference_no_code' name='supplier_return_note_reference_no_code'
																						   placeholder='<?php echo $this->lang->line('Reference No Code') ?>' type='text' 
																						   value="<?php echo $systemConfigData['supplier_return_note_reference_no_starting_code']; ?>"
																						   <?php if ($systemConfigData['supplier_return_note_in_use']) {echo 'readonly ';}?>>
																					<div id="supplier_return_note_reference_no_codeError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-2 controls' style="text-align:right">
																				<div class='col-sm-12 controls'>
																					<input class='form-control' id='supplier_return_note_reference_no_separator' name='supplier_return_note_reference_no_separator'
																						   placeholder='<?php echo $this->lang->line('Separator') ?>' type='text' 
																						   value="<?php echo $systemConfigData['supplier_return_note_reference_no_separator']; ?>"
																						   <?php if ($systemConfigData['supplier_return_note_in_use']) {echo 'readonly ';}?>>
																					<div id="supplier_return_note_reference_no_separatorError" class="red"></div>
																				</div>
																			</div>
																			<div class='col-sm-5 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Start Number') ?></label>
																				<div class='col-sm-6 controls'>
																					<input class='form-control' id='supplier_return_note_reference_no_start_number' name='supplier_return_note_reference_no_start_number'
																						   placeholder='<?php echo $this->lang->line('Reference No Start Number') ?>' type='text' 
																						   value="<?php echo $systemConfigData['supplier_return_note_reference_no_starting_number']; ?>"
																						   <?php if ($systemConfigData['supplier_return_note_in_use']) {echo 'readonly ';}?>>
																					<div id="supplier_return_note_reference_no_start_numberError" class="red"></div>
																				</div>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<hr class="light">
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select supplier saleable return note prime entry book/s for account transactions') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="supplier_saleable_return_note_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="supplier_saleable_return_note_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="ssr_supplier_saleable_return_note_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="ssr_supplier_saleable_return_note_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<div class='col-sm-12 controls'>
																				<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select supplier market return note prime entry book/s for account transactions') ?></label>
																			</div>
																		</div>
																		<div class='form-group'>
																			<div class='col-sm-6 controls'>
																				<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																				<div class='col-sm-5 controls'>
																					<select id="supplier_market_return_note_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Accounts Prime Entry Book drop down-->
																					<div id="supplier_market_return_note_accounts_prime_entry_book_dropdown">
																					</div>
																					<!--End Accounts Prime Entry Book drop down-->
																					<div id="smr_supplier_market_return_note_accounts_prime_entry_book_idError" class="red"></div>
																				</div>
																			</div>
																		</div>

																		<div id="smr_supplier_market_return_note_accounts_prime_entry_book_group">

																		</div>

																		<div class='form-group'>
																			<hr class="light">
																			<div class='col-sm-5'>
																				<?php
																				if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																					?>
																					<button class='btn btn-success' type='button' id="bookkeeping_save_supplier_return_note_config_data" <?php echo $menuFormatting; ?>>
																						<i class='icon-save'></i>
																						<?php echo $this->lang->line('Save') ?>
																					</button>
																					<?php
																				}
																				?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														<?php } ?>
														<?php if ($systemConfigData['bookkeeping_sales_note'] == "No" && $systemConfigData['bookkeeping_purchase_note'] == "No") { ?>
														<div id="receive_payment_configurations" class="tab-pane active">
														<?php } else { ?>
														<div id="receive_payment_configurations" class="tab-pane">	
														<?php } ?>
														
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group' id="receive_payment_use_status" 
																		<?php if ($systemConfigData['receive_payment_in_use'] == "true"){?> style="display:true; text-align:center;"<?php } 
																		else {?>style="display:none; text-align:center;"<?php } ?>>
																		<div class='col-sm-12 controls' style="display: block;">
																			<label class='control-label col-sm-12 config_use_status' style="text-align:center">
																				<?php echo $this->lang->line('Receive payment already in use. ' . 'Therefore, the configuration option is disabled.') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-5 controls'>
																			<input class="config_checkboxes" type="checkbox" name="receive_payment_reference_no_auto_increment" 
																				   id="receive_payment_reference_no_auto_increment" onchange="handleReceivePaymentAutoIncrement(this.id)"
																				   <?php if ($systemConfigData['receive_payment_reference_no_auto_increment'] == "Yes") { echo 'checked ';} 
																						 if ($systemConfigData['receive_payment_in_use']) {echo 'disabled ';}?>>
																			<label for="receive_payment_reference_no_auto_increment" ><?php echo $this->lang->line('Auto Increment Receive Payment Reference Number') ?></label>
																		</div>
																	</div>

																	<div class='form-group' id="receive_payment_reference_no_config" <?php if ($systemConfigData['receive_payment_reference_no_auto_increment'] == "No"){?>style="display:none"<?php } ?>>
																		<div class='col-sm-4 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Code') ?></label>
																			<div class='col-sm-6 controls'>
																				<input class='form-control' id='receive_payment_reference_no_code' name='receive_payment_reference_no_code'
																					   placeholder='<?php echo $this->lang->line('Reference No Code') ?>' type='text' 
																					   value="<?php echo $systemConfigData['receive_payment_reference_no_starting_code']; ?>"
																					   <?php if ($systemConfigData['receive_payment_in_use']) {echo 'readonly ';}?>>
																				<div id="receive_payment_reference_no_codeError" class="red"></div>
																			</div>
																		</div>
																		<div class='col-sm-2 controls' style="text-align:right">
																			<div class='col-sm-12 controls'>
																				<input class='form-control' id='receive_payment_reference_no_separator' name='receive_payment_reference_no_separator'
																					   placeholder='<?php echo $this->lang->line('Separator') ?>' type='text' 
																					   value="<?php echo $systemConfigData['receive_payment_reference_no_separator']; ?>"
																					   <?php if ($systemConfigData['receive_payment_in_use']) {echo 'readonly ';}?>>
																				<div id="receive_payment_reference_no_separatorError" class="red"></div>
																			</div>
																		</div>
																		<div class='col-sm-5 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Start Number') ?></label>
																			<div class='col-sm-6 controls'>
																				<input class='form-control' id='receive_payment_reference_no_start_number' name='receive_payment_reference_no_start_number'
																					   placeholder='<?php echo $this->lang->line('Reference No Start Number') ?>' type='text' 
																					   value="<?php echo $systemConfigData['receive_payment_reference_no_starting_number']; ?>"
																					   <?php if ($systemConfigData['receive_payment_in_use']) {echo 'readonly ';}?>>
																				<div id="receive_payment_reference_no_start_numberError" class="red"></div>
																			</div>
																		</div>
																	</div>
                                                                    <div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<hr class="light">
																		</div>
																	</div>
																	<div class='form-group'>
                                                                        <div class='col-sm-6 controls'>
                                                                            <label class='control-label col-sm-4'><?php echo $this->lang->line('Default Payer Type') ?></label>
                                                                            <div class='col-sm-6 controls'>
                                                                                <select id="receive_payment_default_payer_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                <!--Receive Payment Default Payer Type drop down-->
                                                                                <div id="receive_payment_default_payer_type_dropdown">
                                                                                </div>
                                                                                <!--End Receive Payment Default Payer Type drop down-->
                                                                                <div id="receive_payment_default_payer_type_idError" class="red"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class='col-sm-6 controls'>
                                                                            <label class='control-label col-sm-5'><?php echo $this->lang->line('Default Reference Transaction Type') ?></label>
                                                                            <div class='col-sm-6 controls'>
                                                                                <select id="receive_payment_default_reference_transaction_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                <!--Receive Payment Default Reference Transaction Type drop down-->
                                                                                <div id="receive_payment_default_reference_transaction_type_dropdown">
                                                                                </div>
                                                                                <!--End Receive Payment Default Reference Transaction Type drop down-->
                                                                                <div id="receive_payment_default_reference_transaction_type_idError" class="red"></div>
                                                                            </div>
                                                                        </div>
																	</div>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-4 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="receive_payment_select_reference_journal_entry_automatically" 
                                                                               id="receive_payment_select_reference_journal_entry_automatically"
                                                                               <?php if ($systemConfigData['receive_payment_select_reference_journal_entry_automatically'] == "Yes") { echo 'checked ';}?>>
                                                                            <label for="receive_payment_select_reference_journal_entry_automatically" ><?php echo $this->lang->line('Select Reference Journal Entry Automatically') ?></label>
                                                                        </div>
                                                                        <div class='col-sm-4 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="receive_payment_allow_partial_payment_for_reference_transactions" 
                                                                               id="receive_payment_allow_partial_payment_for_reference_transactions"
                                                                               <?php if ($systemConfigData['receive_payment_allow_partial_payment_for_reference_transactions'] == "Yes") { echo 'checked ';}?>>
                                                                            <label for="receive_payment_allow_partial_payment_for_reference_transactions" ><?php echo $this->lang->line('Allow Partial Receive Payments for Reference Transactions') ?></label>
                                                                        </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<hr class="light">
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select receive payment prime entry book/s for account transactions for cash payment') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="receive_payment_cash_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="receive_payment_cash_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="rca_receive_payment_cash_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="rca_receive_payment_cash_accounts_prime_entry_book_group">

																	</div>
																					
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select receive payment prime entry book/s for account transactions for cheque payment') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="receive_payment_cheque_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="receive_payment_cheque_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="rcq_receive_payment_cheque_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="rcq_receive_payment_cheque_accounts_prime_entry_book_group">

																	</div>
                                                                    
                                                                    <div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select receive payment prime entry book/s for cheque deposits') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="receive_payment_cheque_deposit_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="receive_payment_cheque_deposit_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group">

																	</div>
                                                                    
                                                                    <div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select receive payment prime entry book/s for account transactions for credit card payment') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="receive_payment_credit_card_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="receive_payment_credit_card_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="rcc_receive_payment_credit_card_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="rcc_receive_payment_credit_card_accounts_prime_entry_book_group">

																	</div>
                                                                    
                                                                    <div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select claim payment prime entry book/s for account transactions for receive payment transaction claim') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="receive_payment_transaction_claim_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="receive_payment_transaction_claim_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="rtc_receive_payment_transaction_claim_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group">

																	</div>

																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="bookkeeping_save_receive_payment_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div id="make_payment_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group' id="make_payment_use_status" 
																		<?php if ($systemConfigData['make_payment_in_use'] == "true"){?> style="display:true; text-align:center;"<?php } 
																		else {?>style="display:none; text-align:center;"<?php } ?>>
																		<div class='col-sm-12 controls' style="display: block;">
																			<label class='control-label col-sm-12 config_use_status' style="text-align:center">
																				<?php echo $this->lang->line('Make payment already in use. ' . 'Therefore, the configuration option is disabled.') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-5 controls'>
																			<input class="config_checkboxes" type="checkbox" name="make_payment_reference_no_auto_increment" 
																				   id="make_payment_reference_no_auto_increment" onchange="handleMakePaymentAutoIncrement(this.id)"
																				   <?php if ($systemConfigData['make_payment_reference_no_auto_increment'] == "Yes") { echo 'checked ';} 
																						 if ($systemConfigData['make_payment_in_use']) {echo 'disabled ';}?>>
																			<label for="make_payment_reference_no_auto_increment" ><?php echo $this->lang->line('Auto Increment Make Payment Reference Number') ?></label>
																		</div>
																	</div>

																	<div class='form-group' id="make_payment_reference_no_config" <?php if ($systemConfigData['make_payment_reference_no_auto_increment'] == "No"){?>style="display:none"<?php } ?>>
																		<div class='col-sm-4 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Code') ?></label>
																			<div class='col-sm-6 controls'>
																				<input class='form-control' id='make_payment_reference_no_code' name='make_payment_reference_no_code'
																					   placeholder='<?php echo $this->lang->line('Reference No Code') ?>' type='text' 
																					   value="<?php echo $systemConfigData['make_payment_reference_no_starting_code']; ?>"
																					   <?php if ($systemConfigData['make_payment_in_use']) {echo 'readonly ';}?>>
																				<div id="make_payment_reference_no_codeError" class="red"></div>
																			</div>
																		</div>
																		<div class='col-sm-2 controls' style="text-align:right">
																			<div class='col-sm-12 controls'>
																				<input class='form-control' id='make_payment_reference_no_separator' name='make_payment_reference_no_separator'
																					   placeholder='<?php echo $this->lang->line('Separator') ?>' type='text' 
																					   value="<?php echo $systemConfigData['make_payment_reference_no_separator']; ?>"
																					   <?php if ($systemConfigData['make_payment_in_use']) {echo 'readonly ';}?>>
																				<div id="make_payment_reference_no_separatorError" class="red"></div>
																			</div>
																		</div>
																		<div class='col-sm-5 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Reference No Start Number') ?></label>
																			<div class='col-sm-6 controls'>
																				<input class='form-control' id='make_payment_reference_no_start_number' name='make_payment_reference_no_start_number'
																					   placeholder='<?php echo $this->lang->line('Reference No Start Number') ?>' type='text' 
																					   value="<?php echo $systemConfigData['make_payment_reference_no_starting_number']; ?>"
																					   <?php if ($systemConfigData['make_payment_in_use']) {echo 'readonly ';}?>>
																				<div id="make_payment_reference_no_start_numberError" class="red"></div>
																			</div>
																		</div>
																	</div>
                                                                    <div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<hr class="light">
																		</div>
																	</div>
																	<div class='form-group'>
                                                                        <div class='col-sm-6 controls'>
                                                                            <label class='control-label col-sm-4'><?php echo $this->lang->line('Default Payee Type') ?></label>
                                                                            <div class='col-sm-6 controls'>
                                                                                <select id="make_payment_default_payee_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                <!--Make Payment Default Payee Type drop down-->
                                                                                <div id="make_payment_default_payee_type_dropdown">
                                                                                </div>
                                                                                <!--End Make Payment Default Payee Type drop down-->
                                                                                <div id="make_payment_default_payee_type_idError" class="red"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class='col-sm-6 controls'>
                                                                            <label class='control-label col-sm-5'><?php echo $this->lang->line('Default Reference Transaction Type') ?></label>
                                                                            <div class='col-sm-6 controls'>
                                                                                <select id="make_payment_default_reference_transaction_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                <!--Make Payment Default Reference Transaction Type drop down-->
                                                                                <div id="make_payment_default_reference_transaction_type_dropdown">
                                                                                </div>
                                                                                <!--End Make Payment Default Reference Transaction Type drop down-->
                                                                                <div id="make_payment_default_reference_transaction_type_idError" class="red"></div>
                                                                            </div>
                                                                        </div>
																	</div>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-4 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="make_payment_select_reference_journal_entry_automatically" 
                                                                               id="make_payment_select_reference_journal_entry_automatically"
                                                                               <?php if ($systemConfigData['make_payment_select_reference_journal_entry_automatically'] == "Yes") { echo 'checked ';}?>>
                                                                            <label for="make_payment_select_reference_journal_entry_automatically" ><?php echo $this->lang->line('Select Reference Journal Entry Automatically') ?></label>
                                                                        </div>
                                                                        <div class='col-sm-4 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="make_payment_allow_partial_payment_for_reference_transactions" 
                                                                               id="make_payment_allow_partial_payment_for_reference_transactions" onchange="handleMakePaymentAutoIncrement(this.id)"
                                                                               <?php if ($systemConfigData['make_payment_allow_partial_payment_for_reference_transactions'] == "Yes") { echo 'checked ';}?>>
                                                                            <label for="make_payment_allow_partial_payment_for_reference_transactions" ><?php echo $this->lang->line('Allow Partial Payments for Reference Transactions') ?></label>
                                                                        </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<hr class="light">
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select make payment prime entry book/s for account transactions for cash payment') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="make_payment_cash_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="make_payment_cash_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="pca_make_payment_cash_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="pca_make_payment_cash_accounts_prime_entry_book_group">

																	</div>
																					
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select make payment prime entry book/s for account transactions for cheque payment') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="make_payment_cheque_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="make_payment_cheque_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="pcq_make_payment_cheque_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="pcq_make_payment_cheque_accounts_prime_entry_book_group">

																	</div>
																	
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select make payment prime entry book/s for account transactions for second/third party cheque payment') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="make_payment_second_or_third_party_cheque_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="make_payment_second_or_third_party_cheque_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group">

																	</div>
                                                                    
                                                                    <div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align: left;" class='control-label col-sm-8'><?php echo $this->lang->line('Select claim payment prime entry book/s for account transactions for make payment transaction claim') ?></label>
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-6 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
																			<div class='col-sm-5 controls'>
																				<select id="make_payment_transaction_claim_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--Accounts Prime Entry Book drop down-->
																				<div id="make_payment_transaction_claim_accounts_prime_entry_book_dropdown">
																				</div>
																				<!--End Accounts Prime Entry Book drop down-->
																				<div id="pcl_make_payment_transaction_claim_accounts_prime_entry_book_idError" class="red"></div>
																			</div>
																		</div>
																	</div>

																	<div id="pcl_make_payment_transaction_claim_accounts_prime_entry_book_group">

																	</div>

																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="bookkeeping_save_make_payment_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
                                                        <div id="cheque_list_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-6 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="automatically_mark_received_cheques_as_deposited_on_cheque_date" 
                                                                               id="automatically_mark_received_cheques_as_deposited_on_cheque_date"
                                                                               <?php if ($systemConfigData['automatically_mark_received_cheques_as_deposited_on_cheque_date'] == "Yes") { echo 'checked ';}?>>
                                                                            <label for="automatically_mark_received_cheques_as_deposited_on_cheque_date" ><?php echo $this->lang->line('Automatically Mark Received Cheques As Deposited On Cheque Date') ?></label>
                                                                        </div>
                                                                        <div class='col-sm-6 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="automatically_clear_received_cheques_after_deposited_to_bank" 
                                                                               id="automatically_clear_received_cheques_after_deposited_to_bank"
                                                                               <?php if ($systemConfigData['automatically_clear_received_cheques_after_deposited_to_bank'] == "Yes") { echo 'checked ';}?>>
                                                                            <label for="automatically_clear_received_cheques_after_deposited_to_bank" ><?php echo $this->lang->line('Automatically Clear Received Cheques After Deposited to Bank') ?></label>
                                                                        </div>
																	</div>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-6 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="automatically_clear_paid_cheques_on_cheque_date" 
                                                                               id="automatically_clear_paid_cheques_on_cheque_date"
                                                                               <?php if ($systemConfigData['automatically_clear_paid_cheques_on_cheque_date'] == "Yes") { echo 'checked ';}?>>
                                                                            <label for="automatically_clear_paid_cheques_on_cheque_date" ><?php echo $this->lang->line('Automatically Clear Paid Cheques on Cheque Date') ?></label>
                                                                        </div>
																	</div>
																	
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="bookkeeping_save_cheque_list_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
                                                        <div id="opening_balances_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
                                                                    <div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select opening balance equity chart of account') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="opening_balance_equity_chart_of_account_div">
																				<select class='select form-control' id='opening_balance_equity_chart_of_account' name='chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='opening_balance_equity_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>
																	
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="bookkeeping_save_opening_balances_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="reports_section_configurations" class="tab-pane">
												<div class='tabbable' style='margin-top: 20px'>
													<ul class='nav nav-responsive nav-tabs'>
														<li class='active'>
															<a data-toggle='tab' class="tab-header" href='#reports_trial_balance_configurations'><?php echo $this->lang->line('Trial Balance') ?></a>
														</li>
                                                        <li class=''>
															<a data-toggle='tab' class="tab-header" href='#reports_cash_and_cash_equivalents_configurations'><?php echo $this->lang->line('Cash & Cash Equivalents') ?></a>
														</li>
														<li class=''>
															<a data-toggle='tab' class="tab-header" href='#reports_balance_sheet_configurations'><?php echo $this->lang->line('Balance Sheet') ?></a>
														</li>
														<li class=''>
															<a data-toggle='tab' class="tab-header" href='#reports_profit_and_loss_configurations'><?php echo $this->lang->line('Profit & Loss') ?></a>
														</li>
													</ul>
													<div class='tab-content'>
														<div id="reports_trial_balance_configurations" class="tab-pane active">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select first level chart of account categories in order to display on trial balance') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="trial_balance_chart_of_account_div">
																				<select class='select form-control' id='trial_balance_chart_of_account' name='chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='trial_balance_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="trial_balance_chart_of_account_category_group">

																	</div>

																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="reports_save_trial_balance_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
                                                        <div id="reports_cash_and_cash_equivalents_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select main cash and cash equivalent chart of account') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="cash_and_cash_equivalents_chart_of_account_div">
																				<select class='select form-control' id='cash_and_cash_equivalents_chart_of_account' name='chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='cash_and_cash_equivalents_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>
                                                                    <div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select cheque in hand chart of account') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="cheque_in_hand_chart_of_account_div">
																				<select class='select form-control' id='cheque_in_hand_chart_of_account' name='chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='cheque_in_hand_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>
																	
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="reports_save_cash_and_cash_equivalents_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div id="reports_balance_sheet_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Non-current Assets Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="non_current_assets_chart_of_account_div">
																				<select class='select form-control' id='non_current_assets_chart_of_account' name='non_current_assets_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='non_current_assets_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="non_current_assets_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Current Assets Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="current_assets_chart_of_account_div">
																				<select class='select form-control' id='current_assets_chart_of_account' name='non_current_assets_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='current_assets_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="current_assets_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Equity Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="equity_chart_of_account_div">
																				<select class='select form-control' id='equity_chart_of_account' name='non_current_assets_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='equity_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="equity_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Non-current Liabilities Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="non_current_liabilities_chart_of_account_div">
																				<select class='select form-control' id='non_current_liabilities_chart_of_account' name='non_current_assets_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='non_current_liabilities_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="non_current_liabilities_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Current Liabilities Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="current_liabilities_chart_of_account_div">
																				<select class='select form-control' id='current_liabilities_chart_of_account' name='non_current_assets_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='current_liabilities_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="current_liabilities_chart_of_account_category_group">

																	</div>

																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="reports_save_balance_sheet_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div id="reports_profit_and_loss_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Revenue Calculating Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="revenue_calculating_chart_of_account_div">
																				<select class='select form-control' id='revenue_calculating_chart_of_account' name='revenue_calculating_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='revenue_calculating_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="revenue_calculating_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Gross Profit Calculating Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="gross_profit_calculating_chart_of_account_div">
																				<select class='select form-control' id='gross_profit_calculating_chart_of_account' name='gross_profit_calculating_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='gross_profit_calculating_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="gross_profit_calculating_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Operating Activities Calculating Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="operating_activities_calculating_chart_of_account_div">
																				<select class='select form-control' id='operating_activities_calculating_chart_of_account' name='operating_activities_calculating_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='operating_activities_calculating_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="operating_activities_calculating_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Profit Calculating Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="profit_calculating_chart_of_account_div">
																				<select class='select form-control' id='profit_calculating_chart_of_account' name='profit_calculating_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='profit_calculating_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="profit_calculating_chart_of_account_category_group">

																	</div>
																					
																	<div class='form-group'>
																		 <div class='col-sm-12 controls'>
																		   <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Net Profit Calculating Chart of Account Entries') ?></label>
																		 </div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Chart of Account') ?></label>
																			<div class='col-sm-5 controls'  id="net_profit_calculating_chart_of_account_div">
																				<select class='select form-control' id='net_profit_calculating_chart_of_account' name='net_profit_calculating_chart_of_account'>
																					<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																				</select>
																				<div id='net_profit_calculating_chart_of_accountError' class='red'></div>
																			</div>
																		</div>
																	</div>

																	<div id="net_profit_calculating_chart_of_account_category_group">

																	</div>

																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($ACM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="reports_save_profit_and_loss_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	var FYStartMonthNo = "";
	var FYStartDayNo = "";
	var FYEndMonthNo = "";
	var FYEndDayNo = "";
	var LevelOneChartOfAccount = "No";
	
	var BookkeepingPurchaseNote = "No";
	var BookkeepingSalesNote = "No";
	var BookkeepingCustomerReturnNote = "No";
	var BookkeepingSupplierReturnNote = "No";
	
	var PurchaseNoteAutoIncrementEnabled = "No";
	var SalesNoteAutoIncrementEnabled = "No";
	var CustomerReturnAutoIncrementEnabled = "No";
	var SupplierReturnAutoIncrementEnabled = "No";
	var ReceivePaymentAutoIncrementEnabled = "No";
	var MakePaymentAutoIncrementEnabled = "No";
    var MakePaymentSelectReferenceJournalEntryAutomaticallyEnabled = "No";
    var MakePaymentAllowPartialPaymentForReferenceTransactionsEnabled = "No";
    var ReceivePaymentSelectReferenceJournalEntryAutomaticallyEnabled = "No";
    var ReceivePaymentAllowPartialPaymentForReferenceTransactionsEnabled = "No";
    var AutomaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled = "No";
    var AutomaticallyClearReceivedChequesAfterDepositedToBankEnabled = "No";
    var AutomaticallyClearPaidChequesOnChequeDateEnabled = "No";
    
	var AddCustomerMarketReturnCostEntryWithProfitMargin = "No";
	
	var BookkeepingForceToSelectReferenceTransactionForReceivePayment = "No";
	var BookkeepingForceToSelectReferenceTransactionForMakePayment = "No";

	$(document).ready(function() {
		SysConfig.getReportsTrialBalanceConfigurationData();
		SysConfig.getReportsBalanceSheetConfigurationData();
		SysConfig.getReportsProfitAndLossConfigurationData();
		SysConfig.getMonthDropdownData();
		SysConfig.getChartOfAccounts();
		
		SysConfig.getPurchaseNoteProductsAccountsPrimeEntryBookData();
		SysConfig.getPurchaseNoteProductsAccountsPrimeEntryBookConfigurationData();
		SysConfig.getPurchaseNoteFreeIssuesAccountsPrimeEntryBookData();
		SysConfig.getPurchaseNoteFreeIssuesAccountsPrimeEntryBookConfigurationData();
		
		SysConfig.getSalesNoteSalesEntryAccountsPrimeEntryBookData();
		SysConfig.getSalesNoteSalesEntryAccountsPrimeEntryBookConfigurationData();
		SysConfig.getSalesNoteCostEntryAccountsPrimeEntryBookData();
		SysConfig.getSalesNoteCostEntryAccountsPrimeEntryBookConfigurationData();
		SysConfig.getSalesNoteFreeIssuesAccountsPrimeEntryBookData();
		SysConfig.getSalesNoteFreeIssuesAccountsPrimeEntryBookConfigurationData();
		SysConfig.getSalesNoteDiscountAccountsPrimeEntryBookData();
		SysConfig.getSalesNoteDiscountAccountsPrimeEntryBookConfigurationData();
		
		SysConfig.getCustomerSaleableReturnSalesEntryAccountsPrimeEntryBookData();
		SysConfig.getCustomerSaleableReturnSalesEntryAccountsPrimeEntryBookConfigurationData();
		SysConfig.getCustomerSaleableReturnCostEntryAccountsPrimeEntryBookData();
		SysConfig.getCustomerSaleableReturnCostEntryAccountsPrimeEntryBookConfigurationData();
		
		SysConfig.getCustomerMarketReturnSalesEntryAccountsPrimeEntryBookData();
		SysConfig.getCustomerMarketReturnSalesEntryAccountsPrimeEntryBookConfigurationData();
		SysConfig.getCustomerMarketReturnCostEntryAccountsPrimeEntryBookData();
		SysConfig.getCustomerMarketReturnCostEntryAccountsPrimeEntryBookConfigurationData();
		
		SysConfig.getSupplierSaleableReturnAccountsPrimeEntryBookData();
		SysConfig.getSupplierSaleableReturnAccountsPrimeEntryBookConfigurationData();
		
		SysConfig.getSupplierMarketReturnAccountsPrimeEntryBookData();
		SysConfig.getSupplierMarketReturnAccountsPrimeEntryBookConfigurationData();
		
		SysConfig.getReceivePaymentCashAccountsPrimeEntryBookData();
		SysConfig.getReceivePaymentCashAccountsPrimeEntryBookConfigurationData();
		SysConfig.getReceivePaymentChequeAccountsPrimeEntryBookData();
		SysConfig.getReceivePaymentChequeAccountsPrimeEntryBookConfigurationData();
        SysConfig.getReceivePaymentChequeDepositAccountsPrimeEntryBookData();
		SysConfig.getReceivePaymentChequeDepositAccountsPrimeEntryBookConfigurationData();
        SysConfig.getReceivePaymentCreditCardAccountsPrimeEntryBookData();
		SysConfig.getReceivePaymentCreditCardAccountsPrimeEntryBookConfigurationData();
        SysConfig.getReceivePaymentTransactionClaimAccountsPrimeEntryBookData();
		SysConfig.getReceivePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData();
		
		SysConfig.getMakePaymentCashAccountsPrimeEntryBookData();
		SysConfig.getMakePaymentCashAccountsPrimeEntryBookConfigurationData();
		SysConfig.getMakePaymentChequeAccountsPrimeEntryBookData();
		SysConfig.getMakePaymentChequeAccountsPrimeEntryBookConfigurationData();
		SysConfig.getMakePaymentThirdPartyChequeAccountsPrimeEntryBookData();
		SysConfig.getMakePaymentThirdPartyChequeAccountsPrimeEntryBookConfigurationData();
        SysConfig.getMakePaymentTransactionClaimAccountsPrimeEntryBookData();
		SysConfig.getMakePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData();
        
        SysConfig.getMakePaymentDefaultPayeeTypeData();
        SysConfig.getMakePaymentDefaultReferenceTransactionTypeData();
        
        SysConfig.getReceivePaymentDefaultPayerTypeData();
        SysConfig.getReceivePaymentDefaultReferenceTransactionTypeData();
	});
	
	function handlePrimeEntryBookSelect(id) {

		var idParts = id.split("_");

		clearForm();
		var cloneCount = 1;
		var PrimeEntryBookAlreadySelected = false;

		if (idParts[0] == 'pnp') {
			var SelectedPrimeEntryBookId = $("#pnp_purchase_note_products_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#pnp_purchase_note_products_accounts_prime_entry_book_id option:selected").text();

			var element = $("#pnp_purchase_note_products_accounts_prime_entry_book_group").find("#pnp_purchase_note_products_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#pnp_purchase_note_products_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#pnp_purchase_note_products_accounts_prime_entry_book_group").find("#pnp_purchase_note_products_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="pnp_purchase_note_products_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="pnp_purchase_note_products_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="pnp_purchase_note_products_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#pnp_purchase_note_products_accounts_prime_entry_book_id").val('0');
				$("#pnp_purchase_note_products_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#pnp_purchase_note_products_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'pnf') {
			var SelectedPrimeEntryBookId = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_id option:selected").text();

			var element = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").find("#pnf_purchase_note_free_issues_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#pnf_purchase_note_free_issues_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").find("#pnf_purchase_note_free_issues_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="pnf_purchase_note_free_issues_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="pnf_purchase_note_free_issues_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="pnf_purchase_note_free_issues_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#pnf_purchase_note_free_issues_accounts_prime_entry_book_id").val('0');
				$("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#pnf_purchase_note_free_issues_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'sns') {
			var SelectedPrimeEntryBookId = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_id option:selected").text();

			var element = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").find("#sns_sales_note_sales_entry_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#sns_sales_note_sales_entry_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").find("#sns_sales_note_sales_entry_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="sns_sales_note_sales_entry_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="sns_sales_note_sales_entry_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="sns_sales_note_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#sns_sales_note_sales_entry_accounts_prime_entry_book_id").val('0');
				$("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#sns_sales_note_sales_entry_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'snc') {
			var SelectedPrimeEntryBookId = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_id option:selected").text();

			var element = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").find("#snc_sales_note_cost_entry_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#snc_sales_note_cost_entry_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").find("#snc_sales_note_cost_entry_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="snc_sales_note_cost_entry_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="snc_sales_note_cost_entry_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="snc_sales_note_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#snc_sales_note_cost_entry_accounts_prime_entry_book_id").val('0');
				$("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#snc_sales_note_cost_entry_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'snf') {
			var SelectedPrimeEntryBookId = $("#snf_sales_note_free_issues_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#snf_sales_note_free_issues_accounts_prime_entry_book_id option:selected").text();

			var element = $("#snf_sales_note_free_issues_accounts_prime_entry_book_group").find("#snf_sales_note_free_issues_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#snf_sales_note_free_issues_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#snf_sales_note_free_issues_accounts_prime_entry_book_group").find("#snf_sales_note_free_issues_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="snf_sales_note_free_issues_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="snf_sales_note_free_issues_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="snf_sales_note_free_issues_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#snf_sales_note_free_issues_accounts_prime_entry_book_id").val('0');
				$("#snf_sales_note_free_issues_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#snf_sales_note_free_issues_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'snd') {
			var SelectedPrimeEntryBookId = $("#snd_sales_note_discount_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#snd_sales_note_discount_accounts_prime_entry_book_id option:selected").text();

			var element = $("#snd_sales_note_discount_accounts_prime_entry_book_group").find("#snd_sales_note_discount_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#snd_sales_note_discount_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#snd_sales_note_discount_accounts_prime_entry_book_group").find("#snd_sales_note_discount_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="snd_sales_note_discount_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="snd_sales_note_discount_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="snd_sales_note_discount_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#snd_sales_note_discount_accounts_prime_entry_book_id").val('0');
				$("#snd_sales_note_discount_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#snd_sales_note_discount_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'css') {
			var SelectedPrimeEntryBookId = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_id option:selected").text();

			var element = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").find("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").find("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="css_customer_saleable_return_note_sales_entry_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_id").val('0');
				$("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'csc') {
			var SelectedPrimeEntryBookId = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_id option:selected").text();

			var element = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").find("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").find("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="csc_customer_saleable_return_note_cost_entry_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_id").val('0');
				$("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'cms') {
			var SelectedPrimeEntryBookId = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_id option:selected").text();

			var element = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").find("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").find("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="cms_customer_market_return_note_sales_entry_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_id").val('0');
				$("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'cmc') {
			var SelectedPrimeEntryBookId = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_id option:selected").text();

			var element = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").find("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").find("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="cmc_customer_market_return_note_cost_entry_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_id").val('0');
				$("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'ssr') {
			var SelectedPrimeEntryBookId = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_id option:selected").text();

			var element = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").find("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").find("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="ssr_supplier_saleable_return_note_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="ssr_supplier_saleable_return_note_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="ssr_supplier_saleable_return_note_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_id").val('0');
				$("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'smr') {
			var SelectedPrimeEntryBookId = $("#smr_supplier_market_return_note_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#smr_supplier_market_return_note_accounts_prime_entry_book_id option:selected").text();

			var element = $("#smr_supplier_market_return_note_accounts_prime_entry_book_group").find("#smr_supplier_market_return_note_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#smr_supplier_market_return_note_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#smr_supplier_market_return_note_accounts_prime_entry_book_group").find("#smr_supplier_market_return_note_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="smr_supplier_market_return_note_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="smr_supplier_market_return_note_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="smr_supplier_market_return_note_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#smr_supplier_market_return_note_accounts_prime_entry_book_id").val('0');
				$("#smr_supplier_market_return_note_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#smr_supplier_market_return_note_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'rca') {
			var SelectedPrimeEntryBookId = $("#rca_receive_payment_cash_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#rca_receive_payment_cash_accounts_prime_entry_book_id option:selected").text();

			var element = $("#rca_receive_payment_cash_accounts_prime_entry_book_group").find("#rca_receive_payment_cash_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#rca_receive_payment_cash_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#rca_receive_payment_cash_accounts_prime_entry_book_group").find("#rca_receive_payment_cash_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="rca_receive_payment_cash_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="rca_receive_payment_cash_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="rca_receive_payment_cash_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#rca_receive_payment_cash_accounts_prime_entry_book_id").val('0');
				$("#rca_receive_payment_cash_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#rca_receive_payment_cash_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'rcq') {
			var SelectedPrimeEntryBookId = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_id option:selected").text();

			var element = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").find("#rcq_receive_payment_cheque_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#rcq_receive_payment_cheque_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").find("#rcq_receive_payment_cheque_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="rcq_receive_payment_cheque_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="rcq_receive_payment_cheque_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="rcq_receive_payment_cheque_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#rcq_receive_payment_cheque_accounts_prime_entry_book_id").val('0');
				$("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#rcq_receive_payment_cheque_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'rcd') {
			var SelectedPrimeEntryBookId = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_id option:selected").text();

			var element = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").find("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").find("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="rcd_receive_payment_cheque_deposit_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_id").val('0');
				$("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'rcc') {
			var SelectedPrimeEntryBookId = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_id option:selected").text();

			var element = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").find("#rcc_receive_payment_credit_card_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#rcc_receive_payment_credit_card_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").find("#rcc_receive_payment_credit_card_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="rcc_receive_payment_credit_card_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="rcc_receive_payment_credit_card_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="rcc_receive_payment_credit_card_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#rcc_receive_payment_credit_card_accounts_prime_entry_book_id").val('0');
				$("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#rcc_receive_payment_credit_card_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'rtc') {
			var SelectedPrimeEntryBookId = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_id option:selected").text();

			var element = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").find("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").find("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="rtc_receive_payment_transaction_claim_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="rtc_receive_payment_transaction_claim_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="rtc_receive_payment_transaction_claim_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_id").val('0');
				$("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'pca') {
			var SelectedPrimeEntryBookId = $("#pca_make_payment_cash_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#pca_make_payment_cash_accounts_prime_entry_book_id option:selected").text();

			var element = $("#pca_make_payment_cash_accounts_prime_entry_book_group").find("#pca_make_payment_cash_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#pca_make_payment_cash_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#pca_make_payment_cash_accounts_prime_entry_book_group").find("#pca_make_payment_cash_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="pca_make_payment_cash_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="pca_make_payment_cash_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="pca_make_payment_cash_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#pca_make_payment_cash_accounts_prime_entry_book_id").val('0');
				$("#pca_make_payment_cash_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#pca_make_payment_cash_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'pcq') {
			var SelectedPrimeEntryBookId = $("#pcq_make_payment_cheque_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#pcq_make_payment_cheque_accounts_prime_entry_book_id option:selected").text();

			var element = $("#pcq_make_payment_cheque_accounts_prime_entry_book_group").find("#pcq_make_payment_cheque_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#pcq_make_payment_cheque_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#pcq_make_payment_cheque_accounts_prime_entry_book_group").find("#pcq_make_payment_cheque_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="pcq_make_payment_cheque_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="pcq_make_payment_cheque_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="pcq_make_payment_cheque_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#pcq_make_payment_cheque_accounts_prime_entry_book_id").val('0');
				$("#pcq_make_payment_cheque_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#pcq_make_payment_cheque_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'ptc') {
			var SelectedPrimeEntryBookId = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_id option:selected").text();

			var element = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").find("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").find("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="ptc_make_payment_second_or_third_party_cheque_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_id").val('0');
				$("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_id").val('0');
				}
			}
		} else if (idParts[0] == 'pcl') {
			var SelectedPrimeEntryBookId = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_id").val();
			var SelectedPrimeEntryBookName = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_id option:selected").text();

			var element = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").find("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_1");

			while (element.length == 1) {
				if ($("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
					PrimeEntryBookAlreadySelected = true;
				}
				cloneCount++;
				element = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").find("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_" + cloneCount);
			}

			if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
				var NewCategoryhtml = ' <div class="form-group" id="pcl_make_payment_transaction_claim_accounts_prime_entry_book_row_'+cloneCount+'">'+
											'<input class="form-control" id="pcl_make_payment_transaction_claim_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
											'<div class="col-sm-6 controls">'+
												'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
												'<div class="col-sm-2 controls">'+
													'<button class="btn btn-success" type="button" id="pcl_make_payment_transaction_claim_delete_accounts_prime_entry_book_'+cloneCount+'"'+
														'onclick="removeAccountsPrimeEntryBook(this.id)">'+
														'<i class="icon-save"></i> '+
														'<?php echo $this->lang->line('Delete') ?>'+
													'</button>'+
												'</div>'+
											'</div>'+
										'</div>';

				$("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_id").val('0');
				$("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").append(NewCategoryhtml);
			} else {
				if (SelectedPrimeEntryBookId != 0) {
					alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
					$("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_id").val('0');
				}
			}
		}
	}
	
	function removeAccountsPrimeEntryBook(id) {
		var idParts = id.split("_");

		if (idParts[0] == 'pnp') {
			var value = id.substring(60,62);

			$("#pnp_purchase_note_products_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#pnp_purchase_note_products_accounts_prime_entry_book_group").find("#pnp_purchase_note_products_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#pnp_purchase_note_products_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "pnp_purchase_note_products_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#pnp_purchase_note_products_accounts_prime_entry_book_"+cloneCount).prop({ id: "pnp_purchase_note_products_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#pnp_purchase_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "pnp_purchase_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#pnp_purchase_note_products_accounts_prime_entry_book_group").find("#pnp_purchase_note_products_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'pnf') {
			var value = id.substring(63,65);

			$("#pnf_purchase_note_free_issues_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").find("#pnf_purchase_note_free_issues_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#pnf_purchase_note_free_issues_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "pnf_purchase_note_free_issues_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#pnf_purchase_note_free_issues_accounts_prime_entry_book_"+cloneCount).prop({ id: "pnf_purchase_note_free_issues_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#pnp_purchase_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "pnp_purchase_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").find("#pnf_purchase_note_free_issues_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'sns') {
			var value = id.substring(48,50);

			$("#sns_sales_note_sales_entry_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").find("#sns_sales_note_sales_entry_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#sns_sales_note_sales_entry_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "sns_sales_note_sales_entry_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#sns_sales_note_sales_entry_accounts_prime_entry_book_"+cloneCount).prop({ id: "sns_sales_note_sales_entry_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#sns_sales_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "sns_sales_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").find("#sns_sales_note_sales_entry_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'snc') {
			var value = id.substring(48,50);

			$("#snc_sales_note_cost_entry_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").find("#snc_sales_note_cost_entry_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#snc_sales_note_cost_entry_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "snc_sales_note_cost_entry_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#snc_sales_note_cost_entry_accounts_prime_entry_book_"+cloneCount).prop({ id: "snc_sales_note_cost_entry_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#snc_sales_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "snc_sales_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").find("#snc_sales_note_cost_entry_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'snf') {
			var value = id.substring(60,62);

			$("#snf_sales_note_free_issues_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#snf_sales_note_free_issues_accounts_prime_entry_book_group").find("#snf_sales_note_free_issues_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#snf_sales_note_free_issues_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "snf_sales_note_free_issues_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#snf_sales_note_free_issues_accounts_prime_entry_book_"+cloneCount).prop({ id: "snf_sales_note_free_issues_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#pnp_purchase_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "pnp_purchase_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#snf_sales_note_free_issues_accounts_prime_entry_book_group").find("#snf_sales_note_free_issues_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'snd') {
			var value = id.substring(57,59);

			$("#snd_sales_note_discount_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#snd_sales_note_discount_accounts_prime_entry_book_group").find("#snd_sales_note_discount_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#snd_sales_note_discount_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "snd_sales_note_discount_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#snd_sales_note_discount_accounts_prime_entry_book_"+cloneCount).prop({ id: "snd_sales_note_discount_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#pnp_purchase_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "pnp_purchase_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#snd_sales_note_discount_accounts_prime_entry_book_group").find("#snd_sales_note_discount_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'css') {
			var value = id.substring(79,81);

			$("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").find("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_"+cloneCount).prop({ id: "css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#css_customer_saleable_return_note_sales_entry_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "css_customer_saleable_return_note_sales_entry_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").find("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'csc') {
			var value = id.substring(78,80);

			$("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").find("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_"+cloneCount).prop({ id: "csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#csc_customer_saleable_return_note_cost_entry_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "csc_customer_saleable_return_note_cost_entry_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").find("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'cms') {
			var value = id.substring(77,79);

			$("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").find("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_"+cloneCount).prop({ id: "cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#cms_customer_market_return_note_sales_entry_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "cms_customer_market_return_note_sales_entry_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").find("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'cmc') {
			var value = id.substring(76,78);

			$("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").find("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_"+cloneCount).prop({ id: "cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#cmc_customer_market_return_note_cost_entry_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "cmc_customer_market_return_note_cost_entry_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").find("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'ssr') {
			var value = id.substring(67,69);

			$("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").find("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "ssr_supplier_saleable_return_note_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_"+cloneCount).prop({ id: "ssr_supplier_saleable_return_note_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#ssr_supplier_saleable_return_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "ssr_supplier_saleable_return_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").find("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'smr') {
			var value = id.substring(65,67);

			$("#smr_supplier_market_return_note_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#smr_supplier_market_return_note_accounts_prime_entry_book_group").find("#smr_supplier_market_return_note_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#smr_supplier_market_return_note_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "smr_supplier_market_return_note_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#smr_supplier_market_return_note_accounts_prime_entry_book_"+cloneCount).prop({ id: "smr_supplier_market_return_note_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#smr_supplier_market_return_note_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "smr_supplier_market_return_note_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#smr_supplier_market_return_note_accounts_prime_entry_book_group").find("#smr_supplier_market_return_note_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'rca') {
			var value = id.substring(58,60);

			$("#rca_receive_payment_cash_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#rca_receive_payment_cash_accounts_prime_entry_book_group").find("#rca_receive_payment_cash_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#rca_receive_payment_cash_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "rca_receive_payment_cash_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#rca_receive_payment_cash_accounts_prime_entry_book_"+cloneCount).prop({ id: "rca_receive_payment_cash_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#rca_receive_payment_cash_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "rca_receive_payment_cash_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#rca_receive_payment_cash_accounts_prime_entry_book_group").find("#rca_receive_payment_cash_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'rcq') {
			var value = id.substring(60,62);

			$("#rcq_receive_payment_cheque_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").find("#rcq_receive_payment_cheque_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#rcq_receive_payment_cheque_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "rcq_receive_payment_cheque_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#rcq_receive_payment_cheque_accounts_prime_entry_book_"+cloneCount).prop({ id: "rcq_receive_payment_cheque_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#rcq_receive_payment_cheque_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "rcq_receive_payment_cheque_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").find("#rcq_receive_payment_cheque_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'rcd') {
			var value = id.substring(68,70);

			$("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").find("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_"+cloneCount).prop({ id: "rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#rcd_receive_payment_cheque_deposit_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "rcd_receive_payment_cheque_deposit_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").find("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'rcc') {
			var value = id.substring(65,67);

			$("#rcc_receive_payment_credit_card_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").find("#rcc_receive_payment_credit_card_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#rcc_receive_payment_credit_card_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "rcc_receive_payment_credit_card_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#rcc_receive_payment_credit_card_accounts_prime_entry_book_"+cloneCount).prop({ id: "rcc_receive_payment_credit_card_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#rcc_receive_payment_credit_card_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "rcc_receive_payment_credit_card_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").find("#rcc_receive_payment_credit_card_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'rtc') {
			var value = id.substring(71,73);

			$("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").find("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "rtc_receive_payment_transaction_claim_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_"+cloneCount).prop({ id: "rtc_receive_payment_transaction_claim_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#rtc_receive_payment_transaction_claim_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "rtc_receive_payment_transaction_claim_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").find("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'pca') {
			var value = id.substring(55,57);

			$("#pca_make_payment_cash_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#pca_make_payment_cash_accounts_prime_entry_book_group").find("#pca_make_payment_cash_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#pca_make_payment_cash_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "pca_make_payment_cash_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#pca_make_payment_cash_accounts_prime_entry_book_"+cloneCount).prop({ id: "pca_make_payment_cash_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#pca_make_payment_cash_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "pca_make_payment_cash_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#pca_make_payment_cash_accounts_prime_entry_book_group").find("#pca_make_payment_cash_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'pcq') {
			var value = id.substring(57,59);

			$("#pcq_make_payment_cheque_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#pcq_make_payment_cheque_accounts_prime_entry_book_group").find("#pcq_make_payment_cheque_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#pcq_make_payment_cheque_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "pcq_make_payment_cheque_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#pcq_make_payment_cheque_accounts_prime_entry_book_"+cloneCount).prop({ id: "pcq_make_payment_cheque_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#pcq_make_payment_cheque_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "pcq_make_payment_cheque_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#pcq_make_payment_cheque_accounts_prime_entry_book_group").find("#pcq_make_payment_cheque_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'ptc') {
			var value = id.substring(79,81);

			$("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").find("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_"+cloneCount).prop({ id: "ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#ptc_make_payment_second_or_third_party_cheque_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "ptc_make_payment_second_or_third_party_cheque_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").find("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_row_" + cloneCount);
			}
		} else if (idParts[0] == 'pcl') {
			var value = id.substring(68,70);

			$("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").find("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_row_"+cloneCount);

			while (element.length == 1) {
				$("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "pcl_make_payment_transaction_claim_accounts_prime_entry_book_row_" + (cloneCount - 1)});
				$("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_"+cloneCount).prop({ id: "pcl_make_payment_transaction_claim_accounts_prime_entry_book_" + (cloneCount - 1)});
				$("#pcl_make_payment_transaction_claim_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "pcl_make_payment_transaction_claim_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").find("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_row_" + cloneCount);
			}
		}
	}

	$("#admin_save_general_config_data").click(function () {
		
		if ($("#bookkeeping_purchase_note").prop("checked") == true) {
			BookkeepingPurchaseNote = "Yes";
		} else {
			BookkeepingPurchaseNote = "No";
		}
		
		if ($("#bookkeeping_sales_note").prop("checked") == true) {
			BookkeepingSalesNote = "Yes";
		} else {
			BookkeepingSalesNote = "No";
		}
		
		if ($("#bookkeeping_customer_return_note").prop("checked") == true) {
			BookkeepingCustomerReturnNote = "Yes";
		} else {
			BookkeepingCustomerReturnNote = "No";
		}
		
		if ($("#bookkeeping_supplier_return_note").prop("checked") == true) {
			BookkeepingSupplierReturnNote = "Yes";
		} else {
			BookkeepingSupplierReturnNote = "No";
		}
		
		if ($("#bookkeeping_force_to_select_reference_transaction_for_receive_payment").prop("checked") == true) {
			BookkeepingForceToSelectReferenceTransactionForReceivePayment = "Yes";
		} else {
			BookkeepingForceToSelectReferenceTransactionForReceivePayment = "No";
		}
		
		if ($("#bookkeeping_force_to_select_reference_transaction_for_make_payment").prop("checked") == true) {
			BookkeepingForceToSelectReferenceTransactionForMakePayment = "Yes";
		} else {
			BookkeepingForceToSelectReferenceTransactionForMakePayment = "No";
		}
		
		SysConfig.saveAdminGeneralConfigData();
	});
    
    $("#admin_save_financial_year_ends_config_data").click(function () {
        
        var parentLiabilitiesChartOfAccountId = $("#parent_liabilities_chart_of_account").val();
        var parentAssetsChartOfAccountId = $("#parent_assets_chart_of_account").val();
        var reatainedEarningsChartOfAccountId = $("#retained_earnings_chart_of_account").val();
        
		SysConfig.saveFinancialYearEndsConfigData(parentLiabilitiesChartOfAccountId, parentAssetsChartOfAccountId, reatainedEarningsChartOfAccountId);
    });
    
    $("#bookkeeping_save_opening_balances_config_data").click(function () {
        
        var chartOfAccountId = $("#opening_balance_equity_chart_of_account").val();
        
		SysConfig.saveOpeningBalancesConfigData(chartOfAccountId);
    });

	$("#reports_save_trial_balance_config_data").click(function () {
		var TrialBalanceChartOfAccountCategoryList = new Array();

		var cloneCount = 1;
		var element = $("#trial_balance_chart_of_account_category_group").find("#trial_balance_chart_of_account_category_1");

		while (element.length == 1) {
			TrialBalanceChartOfAccountCategoryList.push($("#trial_balance_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#trial_balance_chart_of_account_category_group").find("#trial_balance_chart_of_account_category_" + cloneCount);
		}

		SysConfig.saveReportsTrialBalanceConfigData(TrialBalanceChartOfAccountCategoryList);
	});
    
    $("#reports_save_cash_and_cash_equivalents_config_data").click(function () {
        
        var cashAndCashEquivalentsChartOfAccountId = $("#cash_and_cash_equivalents_chart_of_account").val();
        var chequeInHandChartOfAccountId = $("#cheque_in_hand_chart_of_account").val();
        
		SysConfig.saveReportsCashAndCashEquivalentsConfigData(cashAndCashEquivalentsChartOfAccountId, chequeInHandChartOfAccountId);
    });
	
	$("#reports_save_balance_sheet_config_data").click(function () {
		var NonCurrentAssetsChartOfAccountCategoryList = new Array();
		var CurrentAssetsChartOfAccountCategoryList = new Array();
		var EquityChartOfAccountCategoryList = new Array();
		var NonCurrentLiabilitiesChartOfAccountCategoryList = new Array();
		var CurrentLiabilitiesChartOfAccountCategoryList = new Array();

		var cloneCount = 1;
		var element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_1");

		while (element.length == 1) {
			NonCurrentAssetsChartOfAccountCategoryList.push($("#non_current_assets_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_" + cloneCount);
		}
		
		cloneCount = 1;
		var element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_1");

		while (element.length == 1) {
			CurrentAssetsChartOfAccountCategoryList.push($("#current_assets_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_" + cloneCount);
		}
		
		cloneCount = 1;
		var element = $("#equity_chart_of_account_category_group").find("#equity_chart_of_account_category_1");

		while (element.length == 1) {
			EquityChartOfAccountCategoryList.push($("#equity_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#equity_chart_of_account_category_group").find("#equity_chart_of_account_category_" + cloneCount);
		}
		
		cloneCount = 1;
		var element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_1");

		while (element.length == 1) {
			NonCurrentLiabilitiesChartOfAccountCategoryList.push($("#non_current_liabilities_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_" + cloneCount);
		}
		
		cloneCount = 1;
		var element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_1");

		while (element.length == 1) {
			CurrentLiabilitiesChartOfAccountCategoryList.push($("#current_liabilities_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_" + cloneCount);
		}

		SysConfig.saveReportsBalanceSheetConfigData(NonCurrentAssetsChartOfAccountCategoryList, CurrentAssetsChartOfAccountCategoryList, EquityChartOfAccountCategoryList, NonCurrentLiabilitiesChartOfAccountCategoryList, CurrentLiabilitiesChartOfAccountCategoryList);
	});
	
	$("#reports_save_profit_and_loss_config_data").click(function () {
		var RevenueCalculatingChartOfAccountCategoryList = new Array();
		var GrossProfitCalculatingChartOfAccountCategoryList = new Array();
		var OperatingActivitiesCalculatingChartOfAccountCategoryList = new Array();
		var ProfitCalculatingChartOfAccountCategoryList = new Array();
		var NetProfitCalculatingChartOfAccountCategoryList = new Array();

		var cloneCount = 1;
		var element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_1");

		while (element.length == 1) {
			RevenueCalculatingChartOfAccountCategoryList.push($("#revenue_calculating_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_" + cloneCount);
		}
		
		cloneCount = 1;
		var element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_1");

		while (element.length == 1) {
			GrossProfitCalculatingChartOfAccountCategoryList.push($("#gross_profit_calculating_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_" + cloneCount);
		}
		
		cloneCount = 1;
		var element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_1");

		while (element.length == 1) {
			OperatingActivitiesCalculatingChartOfAccountCategoryList.push($("#operating_activities_calculating_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_1");

		while (element.length == 1) {
			ProfitCalculatingChartOfAccountCategoryList.push($("#profit_calculating_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_1");

		while (element.length == 1) {
			NetProfitCalculatingChartOfAccountCategoryList.push($("#net_profit_calculating_chart_of_account_category_id_"+cloneCount).val());
			cloneCount++;
			element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_" + cloneCount);
		}

		SysConfig.saveReportsProfitAndLossConfigData(RevenueCalculatingChartOfAccountCategoryList, GrossProfitCalculatingChartOfAccountCategoryList, OperatingActivitiesCalculatingChartOfAccountCategoryList, ProfitCalculatingChartOfAccountCategoryList, NetProfitCalculatingChartOfAccountCategoryList);
	});

	function handleMonthChange(id) {
		var currentYear = new Date().getFullYear();
		var nextYear = currentYear + 1;
		var daysInMonth = '';
		var monthNo = $("#" + id).val();
		var html = '';
		if (id == 'fy_start_month') {
			daysInMonth = getDaysInMonth(monthNo, currentYear);
			FYStartMonthNo = monthNo;

			html = "<select id='fy_start_day' class='form-control' onchange='handleDayChange(this.id)'>";
			html += "<option value='0'><?php echo $this->lang->line('-- Select --'); ?></option>";
			var currentDay = new Date().getDate();
			for (d=1; d<=daysInMonth; d++) {
				if(currentDay == d)
					html += "<option value='" + d + "' selected='selected'>" + d + "</option>";
				else   
					html += "<option value='" + d + "'>" + d + "</option>";
			}
			html += "</select>";

			$('#fy_start_day_init').hide();
			$("#fy_start_day_dropdown").html(html);
		} else if (id == 'fy_end_month') {
			daysInMonth = getDaysInMonth(monthNo, nextYear);
			FYEndMonthNo = monthNo;

			html = "<select id='fy_end_day' class='form-control' onchange='handleDayChange(this.id)'>";
			html += "<option value='0'><?php echo $this->lang->line('-- Select --'); ?></option>";
			var currentDay = new Date().getDate();
			for (d=1; d<=daysInMonth; d++) {
				if(currentDay == d)
					html += "<option value='" + d + "' selected='selected'>" + d + "</option>";
				else   
					html += "<option value='" + d + "'>" + d + "</option>";
			}
			html += "</select>";

			$('#fy_end_day_init').hide();
			$("#fy_end_day_dropdown").html(html);
		}
	}

	function getDaysInMonth(month,year) {
		return new Date(year, month, 0).getDate();
	}

	function handleDayChange(id) {
		var dayNo = $("#" + id).val();

		if (id == "fy_start_day") {
			FYStartDayNo = dayNo;
		} else if (id == "fy_end_day") {
			FYEndDayNo = dayNo;
		}
	}

	function handleChartOfAccountSelect(id) {
		
		if (id == "cash_related_chart_of_account_for_cash_accounting_method") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#cash_related_chart_of_account_for_cash_accounting_method").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#cash_related_chart_of_account_for_cash_accounting_method_category_group").find("#cash_related_chart_of_account_for_cash_accounting_method_category_1");

				while (element.length == 1) {
					if ($("#cash_related_chart_of_account_for_cash_accounting_method_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#cash_related_chart_of_account_for_cash_accounting_method_category_group").find("#cash_related_chart_of_account_for_cash_accounting_method_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="cash_related_chart_of_account_for_cash_accounting_method_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="cash_related_chart_of_account_for_cash_accounting_method_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="cash_related_chart_of_account_for_cash_accounting_method_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_cash_related_chart_of_account_for_cash_accounting_method_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /CRCHCA/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#cash_related_chart_of_account_for_cash_accounting_method").val('0');
					$("#cash_related_chart_of_account_for_cash_accounting_method_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#cash_related_chart_of_account_for_cash_accounting_method").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#cash_related_chart_of_account_for_cash_accounting_method").val('0');
			}
		} else if (id == "trial_balance_chart_of_account") {
			var cloneCount = 1;
			var ChartOfAccountAlreadySelected = false;

			var SelectedChartOfAccountId = $("#trial_balance_chart_of_account").val();
			var result = SysConfig.isLevelOneChartOfAccount(SelectedChartOfAccountId);
			var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

			if (result == "Yes") {
				var element = $("#trial_balance_chart_of_account_category_group").find("#trial_balance_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#trial_balance_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#trial_balance_chart_of_account_category_group").find("#trial_balance_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="trial_balance_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="trial_balance_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="trial_balance_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_trial_balance_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /TBRS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#trial_balance_chart_of_account").val('0');
					$("#trial_balance_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#trial_balance_chart_of_account").val('0');
				}
			}
		} else if (id == "non_current_assets_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#non_current_assets_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#non_current_assets_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="non_current_assets_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="non_current_assets_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="non_current_assets_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_non_current_assets_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /NCAS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#non_current_assets_chart_of_account").val('0');
					$("#non_current_assets_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#non_current_assets_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#non_current_assets_chart_of_account").val('0');
			}
		} else if (id == "current_assets_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#current_assets_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#current_assets_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="current_assets_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="current_assets_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="current_assets_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_current_assets_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /CAS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#current_assets_chart_of_account").val('0');
					$("#current_assets_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#current_assets_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#current_assets_chart_of_account").val('0');
			}
		} else if (id == "equity_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#equity_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#equity_chart_of_account_category_group").find("#equity_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#equity_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#equity_chart_of_account_category_group").find("#equity_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="equity_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="equity_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="equity_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_equity_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /ES/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#equity_chart_of_account").val('0');
					$("#equity_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#equity_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#equity_chart_of_account").val('0');
			}
		} else if (id == "non_current_liabilities_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#non_current_liabilities_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#non_current_liabilities_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="non_current_liabilities_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="non_current_liabilities_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="non_current_liabilities_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_non_current_liabilities_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /NCLS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#non_current_liabilities_chart_of_account").val('0');
					$("#non_current_liabilities_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#non_current_liabilities_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#non_current_liabilities_chart_of_account").val('0');
			}
		} else if (id == "current_liabilities_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#current_liabilities_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#current_liabilities_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="current_liabilities_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="current_liabilities_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="current_liabilities_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_current_liabilities_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /CLS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#current_liabilities_chart_of_account").val('0');
					$("#current_liabilities_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#current_liabilities_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#current_liabilities_chart_of_account").val('0');
			}
		} else if (id == "revenue_calculating_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#revenue_calculating_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#revenue_calculating_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="revenue_calculating_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="revenue_calculating_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="revenue_calculating_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_revenue_calculating_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /REVS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#revenue_calculating_chart_of_account").val('0');
					$("#revenue_calculating_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#revenue_calculating_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#revenue_calculating_chart_of_account").val('0');
			}
			
		} else if (id == "gross_profit_calculating_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#gross_profit_calculating_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#gross_profit_calculating_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="gross_profit_calculating_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="gross_profit_calculating_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="gross_profit_calculating_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_gross_profit_calculating_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /GRPS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#gross_profit_calculating_chart_of_account").val('0');
					$("#gross_profit_calculating_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#gross_profit_calculating_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#gross_profit_calculating_chart_of_account").val('0');
			}
		} else if (id == "operating_activities_calculating_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#operating_activities_calculating_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#operating_activities_calculating_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="operating_activities_calculating_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="operating_activities_calculating_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="operating_activities_calculating_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_operating_activities_calculating_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /OPAS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#operating_activities_calculating_chart_of_account").val('0');
					$("#operating_activities_calculating_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#operating_activities_calculating_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#operating_activities_calculating_chart_of_account").val('0');
			}
		} else if (id == "profit_calculating_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#profit_calculating_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#profit_calculating_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="profit_calculating_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="profit_calculating_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="profit_calculating_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_profit_calculating_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /PRFS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#profit_calculating_chart_of_account").val('0');
					$("#profit_calculating_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#profit_calculating_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#profit_calculating_chart_of_account").val('0');
			}
			
		} else if (id == "net_profit_calculating_chart_of_account") {
			if (!isParentChartOfAccountAlreadySelected(id)) {
				var cloneCount = 1;
				var ChartOfAccountAlreadySelected = false;

				var SelectedChartOfAccountId = $("#net_profit_calculating_chart_of_account").val();
				var chartOfAccountName = SysConfig.getChartOfAccountName(SelectedChartOfAccountId);

				var element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_1");

				while (element.length == 1) {
					if ($("#net_profit_calculating_chart_of_account_category_" + cloneCount).val() == chartOfAccountName) {
						ChartOfAccountAlreadySelected = true;
					}
					cloneCount++;
					element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_" + cloneCount);
				}

				if (ChartOfAccountAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="net_profit_calculating_chart_of_account_category_row_'+cloneCount+'">'+
												'<input class="form-control" id="net_profit_calculating_chart_of_account_category_id_'+cloneCount+'" type="hidden" value="'+SelectedChartOfAccountId+'">'+
												'<input class="form-control" id="net_profit_calculating_chart_of_account_category_'+cloneCount+'" type="hidden" value="'+chartOfAccountName+'">'+
												'<div class="col-sm-6 controls">'+
													'<label class="control-label col-sm-6 category_data">'+chartOfAccountName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_net_profit_calculating_chart_of_account_category_'+cloneCount+'"'+
															'onclick="removeChartOfAccountCategory(this.id, /NPRFS/)" <?php echo $menuFormatting; ?>>'+
															'<i class="icon-save"></i> '+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#net_profit_calculating_chart_of_account").val('0');
					$("#net_profit_calculating_chart_of_account_category_group").append(NewCategoryhtml);
				} else {
					alert("<?php echo $this->lang->line('Chart of Account already selected') ?>");
					$("#net_profit_calculating_chart_of_account").val('0');
				}
			} else {
				alert("<?php echo $this->lang->line('Chart of Account selected is a child account of already selected chart of account') ?>");
				$("#net_profit_calculating_chart_of_account").val('0');
			}
			
		} 
	}

	function removeChartOfAccountCategory(id, dropdownIn) {
	
		if (dropdownIn == "/CRCHCA/") {
			var value = id.substring(73,75);

			$("#cash_related_chart_of_account_for_cash_accounting_method_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#cash_related_chart_of_account_for_cash_accounting_method_category_group").find("#cash_related_chart_of_account_for_cash_accounting_method_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#cash_related_chart_of_account_for_cash_accounting_method_category_row_"+cloneCount).prop({ id: "cash_related_chart_of_account_for_cash_accounting_method_category_row_" + (cloneCount - 1)});
				$("#cash_related_chart_of_account_for_cash_accounting_method_category_"+cloneCount).prop({ id: "cash_related_chart_of_account_for_cash_accounting_method_category_" + (cloneCount - 1)});
				$("#delete_cash_related_chart_of_account_for_cash_accounting_method_category_"+cloneCount).prop({ id: "delete_cash_related_chart_of_account_for_cash_accounting_method_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#cash_related_chart_of_account_for_cash_accounting_method_category_group").find("#cash_related_chart_of_account_for_cash_accounting_method_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/TBRS/") {
			var value = id.substring(47,49);

			$("#trial_balance_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#trial_balance_chart_of_account_category_group").find("#trial_balance_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#trial_balance_chart_of_account_category_row_"+cloneCount).prop({ id: "trial_balance_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#trial_balance_chart_of_account_category_"+cloneCount).prop({ id: "trial_balance_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_trial_balance_chart_of_account_category_"+cloneCount).prop({ id: "delete_trial_balance_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#trial_balance_chart_of_account_category_group").find("#trial_balance_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/NCAS/") {
			var value = id.substring(52,54);

			$("#non_current_assets_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#non_current_assets_chart_of_account_category_row_"+cloneCount).prop({ id: "non_current_assets_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#non_current_assets_chart_of_account_category_"+cloneCount).prop({ id: "non_current_assets_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_non_current_assets_chart_of_account_category_"+cloneCount).prop({ id: "delete_non_current_assets_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/CAS/") {
			var value = id.substring(48,50);

			$("#current_assets_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#current_assets_chart_of_account_category_row_"+cloneCount).prop({ id: "current_assets_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#current_assets_chart_of_account_category_"+cloneCount).prop({ id: "current_assets_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_current_assets_chart_of_account_category_"+cloneCount).prop({ id: "delete_current_assets_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/ES/") {
			var value = id.substring(40,42);

			$("#equity_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#current_assets_chart_of_account_category_row_"+cloneCount).prop({ id: "current_assets_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#current_assets_chart_of_account_category_"+cloneCount).prop({ id: "current_assets_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_current_assets_chart_of_account_category_"+cloneCount).prop({ id: "delete_current_assets_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/NCLS/") {
			var value = id.substring(57,59);

			$("#non_current_liabilities_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#non_current_liabilities_chart_of_account_category_row_"+cloneCount).prop({ id: "non_current_liabilities_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#non_current_liabilities_chart_of_account_category_"+cloneCount).prop({ id: "non_current_liabilities_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_non_current_liabilities_chart_of_account_category_"+cloneCount).prop({ id: "delete_non_current_liabilities_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/CLS/") {
			var value = id.substring(53,55);

			$("#current_liabilities_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#current_liabilities_chart_of_account_category_row_"+cloneCount).prop({ id: "current_liabilities_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#current_liabilities_chart_of_account_category_"+cloneCount).prop({ id: "current_liabilities_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_current_liabilities_chart_of_account_category_"+cloneCount).prop({ id: "delete_current_liabilities_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/REVS/") {
			var value = id.substring(53,55);

			$("#revenue_calculating_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#revenue_calculating_chart_of_account_category_row_"+cloneCount).prop({ id: "revenue_calculating_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#revenue_calculating_chart_of_account_category_"+cloneCount).prop({ id: "revenue_calculating_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_revenue_calculating_chart_of_account_category_"+cloneCount).prop({ id: "delete_revenue_calculating_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/GRPS/") {
			var value = id.substring(58,60);

			$("#gross_profit_calculating_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#gross_profit_calculating_chart_of_account_category_row_"+cloneCount).prop({ id: "gross_profit_calculating_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#gross_profit_calculating_chart_of_account_category_"+cloneCount).prop({ id: "gross_profit_calculating_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_gross_profit_calculating_chart_of_account_category_"+cloneCount).prop({ id: "delete_gross_profit_calculating_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/OPAS/") {
			var value = id.substring(66,68);

			$("#operating_activities_calculating_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#operating_activities_calculating_chart_of_account_category_row_"+cloneCount).prop({ id: "operating_activities_calculating_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#operating_activities_calculating_chart_of_account_category_"+cloneCount).prop({ id: "operating_activities_calculating_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_operating_activities_calculating_chart_of_account_category_"+cloneCount).prop({ id: "delete_operating_activities_calculating_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/PRFS/") {
			var value = id.substring(52,54);

			$("#profit_calculating_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#profit_calculating_chart_of_account_category_row_"+cloneCount).prop({ id: "profit_calculating_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#profit_calculating_chart_of_account_category_"+cloneCount).prop({ id: "profit_calculating_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_profit_calculating_chart_of_account_category_"+cloneCount).prop({ id: "delete_profit_calculating_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_row_" + cloneCount);
			}
		} else if (dropdownIn == "/NPRFS/") {
			var value = id.substring(56,58);

			$("#net_profit_calculating_chart_of_account_category_row_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_row_"+cloneCount);

			while (element.length == 1) {
				$("#net_profit_calculating_chart_of_account_category_row_"+cloneCount).prop({ id: "net_profit_calculating_chart_of_account_category_row_" + (cloneCount - 1)});
				$("#net_profit_calculating_chart_of_account_category_"+cloneCount).prop({ id: "net_profit_calculating_chart_of_account_category_" + (cloneCount - 1)});
				$("#delete_net_profit_calculating_chart_of_account_category_"+cloneCount).prop({ id: "delete_net_profit_calculating_chart_of_account_category_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_row_" + cloneCount);
			}
		}
	}
	
	function handlePurchaseNoteAutoIncrement(id) {
		clearForm();
		if ($("#purchase_note_reference_no_auto_increment").prop("checked") == true) {
			$("#purchase_note_reference_no_config").show();
		} else {
			$("#purchase_note_reference_no_config").hide();
		}
	}
	
	function handleSalesNoteAutoIncrement(id) {
		clearForm();
		if ($("#sales_note_reference_no_auto_increment").prop("checked") == true) {
			$("#sales_note_reference_no_config").show();
		} else {
			$("#sales_note_reference_no_config").hide();
		}
	}
	
	function handleCustomerReturnAutoIncrement(id) {
		clearForm();
		if ($("#customer_return_note_reference_no_auto_increment").prop("checked") == true) {
			$("#customer_return_note_reference_no_config").show();
		} else {
			$("#customer_return_note_reference_no_config").hide();
		}
	}
	
	function handleCustomerMarketReturnCostEntrySelect() {
		if ($("#add_customer_market_return_cost_entry_with_profit_margin").prop("checked") == true) {
			$("#customer_return_credit_profit_margin_portion_div").show();
		} else {
			$("#customer_return_credit_profit_margin_portion_div").hide();
		}
	}
	
	function handleSupplierReturnAutoIncrement(id) {
		clearForm();
		if ($("#supplier_return_note_reference_no_auto_increment").prop("checked") == true) {
			$("#supplier_return_note_reference_no_config").show();
		} else {
			$("#supplier_return_note_reference_no_config").hide();
		}
	}
	
	function handleReceivePaymentAutoIncrement(id) {
		clearForm();
		if ($("#receive_payment_reference_no_auto_increment").prop("checked") == true) {
			$("#receive_payment_reference_no_config").show();
		} else {
			$("#receive_payment_reference_no_config").hide();
		}
	}
	
	function handleMakePaymentAutoIncrement(id) {
		clearForm();
		if ($("#make_payment_reference_no_auto_increment").prop("checked") == true) {
			$("#make_payment_reference_no_config").show();
		} else {
			$("#make_payment_reference_no_config").hide();
		}
	}
	
	$("#bookkeeping_save_purchase_note_config_data").click(function () {
		var PurchaseNoteProductsAccountsPrimeEntryBookList = new Array();
		var PurchaseNoteFreeIssuesAccountsPrimeEntryBookList = new Array();

		var cloneCount = 1;
		var element = $("#pnp_purchase_note_products_accounts_prime_entry_book_group").find("#pnp_purchase_note_products_accounts_prime_entry_book_1");

		while (element.length == 1) {
			PurchaseNoteProductsAccountsPrimeEntryBookList.push($("#pnp_purchase_note_products_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#pnp_purchase_note_products_accounts_prime_entry_book_group").find("#pnp_purchase_note_products_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").find("#pnf_purchase_note_free_issues_accounts_prime_entry_book_1");

		while (element.length == 1) {
			PurchaseNoteFreeIssuesAccountsPrimeEntryBookList.push($("#pnf_purchase_note_free_issues_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").find("#pnf_purchase_note_free_issues_accounts_prime_entry_book_" + cloneCount);
		}

		if ($("#purchase_note_reference_no_auto_increment").prop("checked") == true) {
			PurchaseNoteAutoIncrementEnabled = "Yes";
			if (validatePurchaseNoteReferenceNoConfig()) {
				SysConfig.savePurchaseNoteConfigData(PurchaseNoteProductsAccountsPrimeEntryBookList, PurchaseNoteFreeIssuesAccountsPrimeEntryBookList);
			}
		} else {
			PurchaseNoteAutoIncrementEnabled = "No";
			SysConfig.savePurchaseNoteConfigData(PurchaseNoteProductsAccountsPrimeEntryBookList, PurchaseNoteFreeIssuesAccountsPrimeEntryBookList);
		}
	});
	
	$("#bookkeeping_save_sales_note_config_data").click(function () {
		var SalesNoteSalesEntryAccountsPrimeEntryBookList = new Array();
		var SalesNoteCostEntryAccountsPrimeEntryBookList = new Array();
		var SalesNoteFreeIssuesAccountsPrimeEntryBookList = new Array();
		var SalesNoteDiscountAccountsPrimeEntryBookList = new Array();

		var cloneCount = 1;
		var element = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").find("#sns_sales_note_sales_entry_accounts_prime_entry_book_1");

		while (element.length == 1) {
			SalesNoteSalesEntryAccountsPrimeEntryBookList.push($("#sns_sales_note_sales_entry_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").find("#sns_sales_note_sales_entry_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").find("#snc_sales_note_cost_entry_accounts_prime_entry_book_1");

		while (element.length == 1) {
			SalesNoteCostEntryAccountsPrimeEntryBookList.push($("#snc_sales_note_cost_entry_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").find("#snc_sales_note_cost_entry_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#snf_sales_note_free_issues_accounts_prime_entry_book_group").find("#snf_sales_note_free_issues_accounts_prime_entry_book_1");

		while (element.length == 1) {
			SalesNoteFreeIssuesAccountsPrimeEntryBookList.push($("#snf_sales_note_free_issues_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#snf_sales_note_free_issues_accounts_prime_entry_book_group").find("#snf_sales_note_free_issues_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#snd_sales_note_discount_accounts_prime_entry_book_group").find("#snd_sales_note_discount_accounts_prime_entry_book_1");

		while (element.length == 1) {
			SalesNoteDiscountAccountsPrimeEntryBookList.push($("#snd_sales_note_discount_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#snd_sales_note_discount_accounts_prime_entry_book_group").find("#snd_sales_note_discount_accounts_prime_entry_book_" + cloneCount);
		}

		if ($("#sales_note_reference_no_auto_increment").prop("checked") == true) {
			SalesNoteAutoIncrementEnabled = "Yes";
			if (validateSalesNoteReferenceNoConfig() && validateSalesNoteSalesProfitMarginConfig()) {
				SysConfig.saveSalesNoteConfigData(SalesNoteSalesEntryAccountsPrimeEntryBookList, SalesNoteCostEntryAccountsPrimeEntryBookList, SalesNoteFreeIssuesAccountsPrimeEntryBookList, SalesNoteDiscountAccountsPrimeEntryBookList);
			}
		} else {
			SalesNoteAutoIncrementEnabled = "No";
			if (validateSalesNoteSalesProfitMarginConfig()) {
				SysConfig.saveSalesNoteConfigData(SalesNoteSalesEntryAccountsPrimeEntryBookList, SalesNoteCostEntryAccountsPrimeEntryBookList, SalesNoteFreeIssuesAccountsPrimeEntryBookList, SalesNoteDiscountAccountsPrimeEntryBookList);
			}
		}
	});
	
	$("#bookkeeping_save_customer_return_note_config_data").click(function () {
		var CustomerSaleableReturnSalesEntryAccountsPrimeEntryBookList = new Array();
		var CustomerSaleableReturnCostEntryAccountsPrimeEntryBookList = new Array();
		var CustomerMarketReturnSalesEntryAccountsPrimeEntryBookList = new Array();
		var CustomerMarketReturnCostEntryAccountsPrimeEntryBookList = new Array();

		var cloneCount = 1;
		var element = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").find("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_1");

		while (element.length == 1) {
			CustomerSaleableReturnSalesEntryAccountsPrimeEntryBookList.push($("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").find("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").find("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_1");

		while (element.length == 1) {
			CustomerSaleableReturnCostEntryAccountsPrimeEntryBookList.push($("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").find("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").find("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_1");

		while (element.length == 1) {
			CustomerMarketReturnSalesEntryAccountsPrimeEntryBookList.push($("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").find("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").find("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_1");

		while (element.length == 1) {
			CustomerMarketReturnCostEntryAccountsPrimeEntryBookList.push($("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").find("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_" + cloneCount);
		}

		if ($("#add_customer_market_return_cost_entry_with_profit_margin").prop("checked") == true) {
			AddCustomerMarketReturnCostEntryWithProfitMargin = "Yes";
		} else {
			AddCustomerMarketReturnCostEntryWithProfitMargin = "No";
		}

		if ($("#customer_return_note_reference_no_auto_increment").prop("checked") == true) {
			CustomerReturnAutoIncrementEnabled = "Yes";
			if (validateCustomerReturnReferenceNoConfig()) {
				SysConfig.saveCustomerReturnConfigData(CustomerSaleableReturnSalesEntryAccountsPrimeEntryBookList, CustomerSaleableReturnCostEntryAccountsPrimeEntryBookList, CustomerMarketReturnSalesEntryAccountsPrimeEntryBookList, CustomerMarketReturnCostEntryAccountsPrimeEntryBookList);
			}
		} else {
			CustomerReturnAutoIncrementEnabled = "No";
			SysConfig.saveCustomerReturnConfigData(CustomerSaleableReturnSalesEntryAccountsPrimeEntryBookList, CustomerSaleableReturnCostEntryAccountsPrimeEntryBookList, CustomerMarketReturnSalesEntryAccountsPrimeEntryBookList, CustomerMarketReturnCostEntryAccountsPrimeEntryBookList);
		}
	});
	
	$("#bookkeeping_save_supplier_return_note_config_data").click(function () {
		var SupplierSaleableReturnAccountsPrimeEntryBookList = new Array();
		var SupplierMarketReturnAccountsPrimeEntryBookList = new Array();

		var cloneCount = 1;
		var element = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").find("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_1");

		while (element.length == 1) {
			SupplierSaleableReturnAccountsPrimeEntryBookList.push($("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").find("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#smr_supplier_market_return_note_accounts_prime_entry_book_group").find("#smr_supplier_market_return_note_accounts_prime_entry_book_1");

		while (element.length == 1) {
			SupplierMarketReturnAccountsPrimeEntryBookList.push($("#smr_supplier_market_return_note_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#smr_supplier_market_return_note_accounts_prime_entry_book_group").find("#smr_supplier_market_return_note_accounts_prime_entry_book_" + cloneCount);
		}
		
		if ($("#supplier_return_note_reference_no_auto_increment").prop("checked") == true) {
			SupplierReturnAutoIncrementEnabled = "Yes";
			if (validateSupplierReturnReferenceNoConfig()) {
				SysConfig.saveSupplierReturnConfigData(SupplierSaleableReturnAccountsPrimeEntryBookList, SupplierMarketReturnAccountsPrimeEntryBookList);
			}
		} else {
			SupplierReturnAutoIncrementEnabled = "No";
			SysConfig.saveSupplierReturnConfigData(SupplierSaleableReturnAccountsPrimeEntryBookList, SupplierMarketReturnAccountsPrimeEntryBookList);
		}
	});
	
	$("#bookkeeping_save_receive_payment_config_data").click(function () {
		var ReceivePaymentCashAccountsPrimeEntryBookList = new Array();
		var ReceivePaymentChequeAccountsPrimeEntryBookList = new Array();
        var ReceivePaymentChequeDepositAccountsPrimeEntryBookList = new Array();
        var ReceivePaymentCreditCardAccountsPrimeEntryBookList = new Array();
        var ReceivePaymentTransactionClaimAccountsPrimeEntryBookList = new Array();

		var cloneCount = 1;
		var element = $("#rca_receive_payment_cash_accounts_prime_entry_book_group").find("#rca_receive_payment_cash_accounts_prime_entry_book_1");

		while (element.length == 1) {
			ReceivePaymentCashAccountsPrimeEntryBookList.push($("#rca_receive_payment_cash_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#rca_receive_payment_cash_accounts_prime_entry_book_group").find("#rca_receive_payment_cash_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").find("#rcq_receive_payment_cheque_accounts_prime_entry_book_1");

		while (element.length == 1) {
			ReceivePaymentChequeAccountsPrimeEntryBookList.push($("#rcq_receive_payment_cheque_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").find("#rcq_receive_payment_cheque_accounts_prime_entry_book_" + cloneCount);
		}
        
        var cloneCount = 1;
		var element = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").find("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_1");

		while (element.length == 1) {
			ReceivePaymentChequeDepositAccountsPrimeEntryBookList.push($("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").find("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_" + cloneCount);
		}
        
        var cloneCount = 1;
		var element = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").find("#rcc_receive_payment_credit_card_accounts_prime_entry_book_1");

		while (element.length == 1) {
			ReceivePaymentCreditCardAccountsPrimeEntryBookList.push($("#rcc_receive_payment_credit_card_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").find("#rcc_receive_payment_credit_card_accounts_prime_entry_book_" + cloneCount);
		}
        
        var cloneCount = 1;
		var element = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").find("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_1");

		while (element.length == 1) {
			ReceivePaymentTransactionClaimAccountsPrimeEntryBookList.push($("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").find("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_" + cloneCount);
		}
        
        if ($("#receive_payment_select_reference_journal_entry_automatically").prop("checked") == true) {
			ReceivePaymentSelectReferenceJournalEntryAutomaticallyEnabled = "Yes";
		} else {
			ReceivePaymentSelectReferenceJournalEntryAutomaticallyEnabled = "No";
		}
        
        if ($("#receive_payment_allow_partial_payment_for_reference_transactions").prop("checked") == true) {
			ReceivePaymentAllowPartialPaymentForReferenceTransactionsEnabled = "Yes";
		} else {
			ReceivePaymentAllowPartialPaymentForReferenceTransactionsEnabled = "No";
		}
		
		if ($("#receive_payment_reference_no_auto_increment").prop("checked") == true) {
			ReceivePaymentAutoIncrementEnabled = "Yes";
			if (validateReceivePaymentReferenceNoConfig()) {
				SysConfig.saveReceivePaymentConfigData(ReceivePaymentCashAccountsPrimeEntryBookList, ReceivePaymentChequeAccountsPrimeEntryBookList, 
                ReceivePaymentChequeDepositAccountsPrimeEntryBookList, ReceivePaymentCreditCardAccountsPrimeEntryBookList, ReceivePaymentTransactionClaimAccountsPrimeEntryBookList);
			}
		} else {
			ReceivePaymentAutoIncrementEnabled = "No";
			SysConfig.saveReceivePaymentConfigData(ReceivePaymentCashAccountsPrimeEntryBookList, ReceivePaymentChequeAccountsPrimeEntryBookList, 
                ReceivePaymentChequeDepositAccountsPrimeEntryBookList, ReceivePaymentCreditCardAccountsPrimeEntryBookList, ReceivePaymentTransactionClaimAccountsPrimeEntryBookList);
		}
	});
	
	$("#bookkeeping_save_make_payment_config_data").click(function () {
		var MakePaymentCashAccountsPrimeEntryBookList = new Array();
		var MakePaymentChequeAccountsPrimeEntryBookList = new Array();
		var MakePaymentThirdPartyChequeAccountsPrimeEntryBookList = new Array();
        var MakePaymentTransactionClaimAccountsPrimeEntryBookList = new Array();

		var cloneCount = 1;
		var element = $("#pca_make_payment_cash_accounts_prime_entry_book_group").find("#pca_make_payment_cash_accounts_prime_entry_book_1");

		while (element.length == 1) {
			MakePaymentCashAccountsPrimeEntryBookList.push($("#pca_make_payment_cash_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#pca_make_payment_cash_accounts_prime_entry_book_group").find("#pca_make_payment_cash_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#pcq_make_payment_cheque_accounts_prime_entry_book_group").find("#pcq_make_payment_cheque_accounts_prime_entry_book_1");

		while (element.length == 1) {
			MakePaymentChequeAccountsPrimeEntryBookList.push($("#pcq_make_payment_cheque_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#pcq_make_payment_cheque_accounts_prime_entry_book_group").find("#pcq_make_payment_cheque_accounts_prime_entry_book_" + cloneCount);
		}
		
		var cloneCount = 1;
		var element = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").find("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_1");

		while (element.length == 1) {
			MakePaymentThirdPartyChequeAccountsPrimeEntryBookList.push($("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").find("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_" + cloneCount);
		}
        
        var cloneCount = 1;
		var element = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").find("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_1");

		while (element.length == 1) {
			MakePaymentTransactionClaimAccountsPrimeEntryBookList.push($("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_"+cloneCount).val());
			cloneCount++;
			element = $("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").find("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_" + cloneCount);
		}
        
        if ($("#make_payment_select_reference_journal_entry_automatically").prop("checked") == true) {
			MakePaymentSelectReferenceJournalEntryAutomaticallyEnabled = "Yes";
		} else {
			MakePaymentSelectReferenceJournalEntryAutomaticallyEnabled = "No";
		}
        
        if ($("#make_payment_allow_partial_payment_for_reference_transactions").prop("checked") == true) {
			MakePaymentAllowPartialPaymentForReferenceTransactionsEnabled = "Yes";
		} else {
			MakePaymentAllowPartialPaymentForReferenceTransactionsEnabled = "No";
		}
        
		if ($("#make_payment_reference_no_auto_increment").prop("checked") == true) {
			MakePaymentAutoIncrementEnabled = "Yes";
			if (validateMakePaymentReferenceNoConfig()) {
				SysConfig.saveMakePaymentConfigData(MakePaymentCashAccountsPrimeEntryBookList, MakePaymentChequeAccountsPrimeEntryBookList, MakePaymentThirdPartyChequeAccountsPrimeEntryBookList, MakePaymentTransactionClaimAccountsPrimeEntryBookList);
			}
		} else {
			MakePaymentAutoIncrementEnabled = "No";
			SysConfig.saveMakePaymentConfigData(MakePaymentCashAccountsPrimeEntryBookList, MakePaymentChequeAccountsPrimeEntryBookList, MakePaymentThirdPartyChequeAccountsPrimeEntryBookList, MakePaymentTransactionClaimAccountsPrimeEntryBookList);
		}
	});
    
    $("#bookkeeping_save_cheque_list_config_data").click(function () {
        
        if ($("#automatically_mark_received_cheques_as_deposited_on_cheque_date").prop("checked") == true) {
			AutomaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled = "Yes";
		} else {
			AutomaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled = "No";
		}
        
        if ($("#automatically_clear_received_cheques_after_deposited_to_bank").prop("checked") == true) {
			AutomaticallyClearReceivedChequesAfterDepositedToBankEnabled = "Yes";
		} else {
			AutomaticallyClearReceivedChequesAfterDepositedToBankEnabled = "No";
		}
        
        if ($("#automatically_clear_paid_cheques_on_cheque_date").prop("checked") == true) {
			AutomaticallyClearPaidChequesOnChequeDateEnabled = "Yes";
		} else {
			AutomaticallyClearPaidChequesOnChequeDateEnabled = "No";
		}
        
		SysConfig.saveChequeListConfigData();
	});
	
	var SysConfig = {

		//save general config data
		saveAdminGeneralConfigData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var accountsManagementForLocations = '';
			if ($("#accounts_management_for_locations").prop("checked") == true) {
				accountsManagementForLocations = "Yes";
			} else {
				accountsManagementForLocations = "No";
			}

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveAdminGeneralConfigData",
				data: {
					'fy_start_month_no': FYStartMonthNo,
					'fy_start_day_no' : FYStartDayNo,
					'fy_end_month_no': FYEndMonthNo,
					'fy_end_day_no' : FYEndDayNo,
					'accounts_management_for_locations' : accountsManagementForLocations,
					'bookkeeping_purchase_note' : BookkeepingPurchaseNote,
					'bookkeeping_sales_note' : BookkeepingSalesNote,
					'bookkeeping_customer_return_note' : BookkeepingCustomerReturnNote,
					'bookkeeping_supplier_return_note' : BookkeepingSupplierReturnNote,
					'bookkeeping_force_to_select_reference_transaction_for_receive_payment' : BookkeepingForceToSelectReferenceTransactionForReceivePayment,
					'bookkeeping_force_to_select_reference_transaction_for_make_payment' : BookkeepingForceToSelectReferenceTransactionForMakePayment,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
        
        saveFinancialYearEndsConfigData: function (parentLiabilitiesChartOfAccountId, parentAssetsChartOfAccountId, reatainedEarningsChartOfAccountId) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveFinancialYearEndsConfigData",
				data: {
					'parent_liabilities_chart_of_account': parentLiabilitiesChartOfAccountId,
                    'parent_assets_chart_of_account': parentAssetsChartOfAccountId,
                    'retained_earnings_chart_of_account': reatainedEarningsChartOfAccountId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
        
        saveOpeningBalancesConfigData: function (chartOfAccountId) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveOpeningBalancesConfigData",
				data: {
					'opening_balance_equity_chart_of_account': chartOfAccountId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},

		//save trial balance config data
		saveReportsTrialBalanceConfigData: function (ChartOfAccountCategoryList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveReportsTrialBalanceConfigData",
				data: {
					'chart_of_account_category_id_list': ChartOfAccountCategoryList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
        
        //save debtors config data
		saveReportsCashAndCashEquivalentsConfigData: function (cashAndCashEquivalentsChartOfAccountId, chequeInHandChartOfAccountId) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveReportsCashAndCashEquivalentsConfigData",
				data: {
					'acm_cash_and_cash_equivalents_report_main_chart_of_account': cashAndCashEquivalentsChartOfAccountId,
                    'acm_cash_and_cash_equivalents_report_cheque_in_hand_chart_of_account': chequeInHandChartOfAccountId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save balance sheet config data
		saveReportsBalanceSheetConfigData: function (NonCurrentAssetsChartOfAccountCategoryList, CurrentAssetsChartOfAccountCategoryList, EquityChartOfAccountCategoryList, NonCurrentLiabilitiesChartOfAccountCategoryList, CurrentLiabilitiesChartOfAccountCategoryList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveReportsBalanceSheetConfigData",
				data: {
					'non_current_assets_chart_of_account_category_list': NonCurrentAssetsChartOfAccountCategoryList,
					'current_assets_chart_of_account_category_list': CurrentAssetsChartOfAccountCategoryList,
					'equity_chart_of_account_category_list': EquityChartOfAccountCategoryList,
					'non_current_liabilities_chart_of_account_category_list': NonCurrentLiabilitiesChartOfAccountCategoryList,
					'current_liabilities_chart_of_account_category_list': CurrentLiabilitiesChartOfAccountCategoryList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save profit and loss config data
		saveReportsProfitAndLossConfigData: function (IncomeChartOfAccountCategoryList, CostOfSalesChartOfAccountCategoryList, ExpenseChartOfAccountCategoryList, ProfitCalculatingChartOfAccountCategoryList, NetProfitCalculatingChartOfAccountCategoryList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveReportsProfitAndLossConfigData",
				data: {
					'revenue_calculating_chart_of_account_category_list': IncomeChartOfAccountCategoryList,
					'gross_profit_calculating_chart_of_account_category_list': CostOfSalesChartOfAccountCategoryList,
					'operating_activities_calculating_chart_of_account_category_list': ExpenseChartOfAccountCategoryList,
					'profit_calculating_chart_of_account_category_list': ProfitCalculatingChartOfAccountCategoryList,
					'net_profit_calculating_chart_of_account_category_list': NetProfitCalculatingChartOfAccountCategoryList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save purchase note config data
		savePurchaseNoteConfigData: function (PurchaseNoteProductsAccountsPrimeEntryBookList, PurchaseNoteFreeIssuesAccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/savePurchaseNoteConfigData",
				data: {
					'purchase_note_products_accounts_prime_entry_book_list': PurchaseNoteProductsAccountsPrimeEntryBookList,
					'purchase_note_free_issues_accounts_prime_entry_book_list': PurchaseNoteFreeIssuesAccountsPrimeEntryBookList,
					'purchase_note_reference_no_auto_increment': PurchaseNoteAutoIncrementEnabled,
					'purchase_note_reference_no_code': $("#purchase_note_reference_no_code").val(),
					'purchase_note_reference_no_separator': $("#purchase_note_reference_no_separator").val(),
					'purchase_note_reference_no_start_number' : $("#purchase_note_reference_no_start_number").val(),
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save sales note config data
		saveSalesNoteConfigData: function (SalesNoteSalesEntryAccountsPrimeEntryBookList, SalesNoteCostEntryAccountsPrimeEntryBookList, SalesNoteFreeIssuesAccountsPrimeEntryBookList, SalesNoteDiscountAccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveSalesNoteConfigData",
				data: {
					'sales_note_sales_entry_accounts_prime_entry_book_list': SalesNoteSalesEntryAccountsPrimeEntryBookList,
					'sales_note_cost_entry_accounts_prime_entry_book_list': SalesNoteCostEntryAccountsPrimeEntryBookList,
					'sales_note_free_issues_accounts_prime_entry_book_list': SalesNoteFreeIssuesAccountsPrimeEntryBookList,
					'sales_note_discount_accounts_prime_entry_book_list': SalesNoteDiscountAccountsPrimeEntryBookList,
					'sales_note_reference_no_auto_increment': SalesNoteAutoIncrementEnabled,
					'sales_note_reference_no_code': $("#sales_note_reference_no_code").val(),
					'sales_note_reference_no_separator': $("#sales_note_reference_no_separator").val(),
					'sales_note_reference_no_start_number' : $("#sales_note_reference_no_start_number").val(),
					'sales_profit_margin' : $("#sales_profit_margin_percentage").val(),
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save customer return config data
		saveCustomerReturnConfigData: function (CustomerSaleableReturnSalesEntryAccountsPrimeEntryBookList, CustomerSaleableReturnCostEntryAccountsPrimeEntryBookList, CustomerMarketReturnSalesEntryAccountsPrimeEntryBookList, CustomerMarketReturnCostEntryAccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveCustomerReturnNoteConfigData",
				data: {
					'customer_saleable_return_note_sales_entry_accounts_prime_entry_book_list': CustomerSaleableReturnSalesEntryAccountsPrimeEntryBookList,
					'customer_saleable_return_note_cost_entry_accounts_prime_entry_book_list': CustomerSaleableReturnCostEntryAccountsPrimeEntryBookList,
					'customer_market_return_note_sales_entry_accounts_prime_entry_book_list': CustomerMarketReturnSalesEntryAccountsPrimeEntryBookList,
					'customer_market_return_note_cost_entry_accounts_prime_entry_book_list': CustomerMarketReturnCostEntryAccountsPrimeEntryBookList,
					'customer_return_note_reference_no_auto_increment': CustomerReturnAutoIncrementEnabled,
					'add_customer_market_return_cost_entry_with_profit_margin' : AddCustomerMarketReturnCostEntryWithProfitMargin,
					'customer_return_note_reference_no_code': $("#customer_return_note_reference_no_code").val(),
					'customer_return_note_reference_no_separator': $("#customer_return_note_reference_no_separator").val(),
					'customer_return_note_reference_no_start_number' : $("#customer_return_note_reference_no_start_number").val(),
					'customer_return_credit_profit_margin_chart_of_account' : $("#customer_return_credit_profit_margin_chart_of_account").val(),
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save supplier return config data
		saveSupplierReturnConfigData: function (SupplierSaleableReturnAccountsPrimeEntryBookList, SupplierMarketReturnAccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveSupplierReturnNoteConfigData",
				data: {
					'supplier_saleable_return_note_accounts_prime_entry_book_list': SupplierSaleableReturnAccountsPrimeEntryBookList,
					'supplier_market_return_note_accounts_prime_entry_book_list': SupplierMarketReturnAccountsPrimeEntryBookList,
					'supplier_return_note_reference_no_auto_increment': SupplierReturnAutoIncrementEnabled,
					'supplier_return_note_reference_no_code': $("#supplier_return_note_reference_no_code").val(),
					'supplier_return_note_reference_no_separator': $("#supplier_return_note_reference_no_separator").val(),
					'supplier_return_note_reference_no_start_number' : $("#supplier_return_note_reference_no_start_number").val(),
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save receive payment config data
		saveReceivePaymentConfigData: function (ReceivePaymentCashAccountsPrimeEntryBookList, ReceivePaymentChequeAccountsPrimeEntryBookList, 
            ReceivePaymentChequeDepositAccountsPrimeEntryBookList, ReceivePaymentCreditCardAccountsPrimeEntryBookList, ReceivePaymentTransactionClaimAccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveReceivePaymentConfigData",
				data: {
					'receive_payment_cash_accounts_prime_entry_book_list': ReceivePaymentCashAccountsPrimeEntryBookList,
					'receive_payment_cheque_accounts_prime_entry_book_list': ReceivePaymentChequeAccountsPrimeEntryBookList,
                    'receive_payment_cheque_deposit_accounts_prime_entry_book_list' : ReceivePaymentChequeDepositAccountsPrimeEntryBookList,
                    'receive_payment_credit_card_accounts_prime_entry_book_list' : ReceivePaymentCreditCardAccountsPrimeEntryBookList,
                    'receive_payment_transaction_claim_accounts_prime_entry_book_list' : ReceivePaymentTransactionClaimAccountsPrimeEntryBookList,
					'receive_payment_reference_no_auto_increment': ReceivePaymentAutoIncrementEnabled,
					'receive_payment_reference_no_code': $("#receive_payment_reference_no_code").val(),
					'receive_payment_reference_no_separator': $("#receive_payment_reference_no_separator").val(),
					'receive_payment_reference_no_start_number' : $("#receive_payment_reference_no_start_number").val(),
                    'receive_payment_default_payer_type' : $("#receive_payment_default_payer_type_id").val(),
                    'receive_payment_default_reference_transaction_type' : $("#receive_payment_default_reference_transaction_type_id").val(),
                    'receive_payment_select_reference_journal_entry_automatically' : ReceivePaymentSelectReferenceJournalEntryAutomaticallyEnabled,
                    'receive_payment_allow_partial_payment_for_reference_transactions' : ReceivePaymentAllowPartialPaymentForReferenceTransactionsEnabled,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save make payment config data
		saveMakePaymentConfigData: function (MakePaymentCashAccountsPrimeEntryBookList, MakePaymentChequeAccountsPrimeEntryBookList, MakePaymentThirdPartyChequeAccountsPrimeEntryBookList, MakePaymentTransactionClaimAccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveMakePaymentConfigData",
				data: {
					'make_payment_cash_accounts_prime_entry_book_list': MakePaymentCashAccountsPrimeEntryBookList,
					'make_payment_cheque_accounts_prime_entry_book_list': MakePaymentChequeAccountsPrimeEntryBookList,
					'make_payment_second_or_third_party_cheque_accounts_prime_entry_book_list' : MakePaymentThirdPartyChequeAccountsPrimeEntryBookList,
                    'make_payment_transaction_claim_accounts_prime_entry_book_list' : MakePaymentTransactionClaimAccountsPrimeEntryBookList,
					'make_payment_reference_no_auto_increment': MakePaymentAutoIncrementEnabled,
					'make_payment_reference_no_code': $("#make_payment_reference_no_code").val(),
					'make_payment_reference_no_separator': $("#make_payment_reference_no_separator").val(),
					'make_payment_reference_no_start_number' : $("#make_payment_reference_no_start_number").val(),
                    'make_payment_default_payee_type' : $("#make_payment_default_payee_type_id").val(),
                    'make_payment_default_reference_transaction_type' : $("#make_payment_default_reference_transaction_type_id").val(),
                    'make_payment_select_reference_journal_entry_automatically' : MakePaymentSelectReferenceJournalEntryAutomaticallyEnabled,
                    'make_payment_allow_partial_payment_for_reference_transactions' : MakePaymentAllowPartialPaymentForReferenceTransactionsEnabled,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
        
        //save cheque list config data
		saveChequeListConfigData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/saveChequeListConfigData",
				data: {
                    'automatically_mark_received_cheques_as_deposited_on_cheque_date' : AutomaticallyMarkReceivedChequesAsDepositedOnChequeDateEnabled,
                    'automatically_clear_received_cheques_after_deposited_to_bank' : AutomaticallyClearReceivedChequesAfterDepositedToBankEnabled,
                    'automatically_clear_paid_cheques_on_cheque_date' : AutomaticallyClearPaidChequesOnChequeDateEnabled,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		getReportsTrialBalanceConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReportsTrialBalanceConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#trial_balance_chart_of_account_category_group").append(response.chartOfAccountCategoryData);
				}
			});
		},
		
		getReportsBalanceSheetConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReportsBalanceSheetConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#non_current_assets_chart_of_account_category_group").append(response.nonCurrentAssetsChartOfAccountCategoryData);
					$("#current_assets_chart_of_account_category_group").append(response.currentAssetsChartOfAccountCategoryData);
					$("#equity_chart_of_account_category_group").append(response.equityChartOfAccountCategoryData);
					$("#non_current_liabilities_chart_of_account_category_group").append(response.nonCurrentLiabilitiesChartOfAccountCategoryData);
					$("#current_liabilities_chart_of_account_category_group").append(response.currentLiabilitiesChartOfAccountCategoryData);
				}
			});
		},
		
		getReportsProfitAndLossConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReportsProfitAndLossConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#revenue_calculating_chart_of_account_category_group").append(response.revenueCalculatingChartOfAccountCategoryData);
					$("#gross_profit_calculating_chart_of_account_category_group").append(response.grossProfitCalculatingChartOfAccountCategoryData);
					$("#operating_activities_calculating_chart_of_account_category_group").append(response.operatingActivitiesCalculatingChartOfAccountCategoryData);
					$("#profit_calculating_chart_of_account_category_group").append(response.profitCalculatingChartOfAccountCategoryData);
					$("#net_profit_calculating_chart_of_account_category_group").append(response.netProfitCalculatingChartOfAccountCategoryData);
				}
			});
		},

		//get month dropdown
		getMonthDropdownData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getMonthDropdownData",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$('#fy_start_month_init').hide();
					$("#fy_start_month_dropdown").html(response);
					$("#month").prop({ id: "fy_start_month"});
					
					<?php 
					if ($systemConfigData['financial_year_start_month_no'] != "") { ?>
							$("#fy_start_month").val(<?php echo $systemConfigData['financial_year_start_month_no']; ?>);
							FYStartMonthNo = $("#fy_start_month").val();
					<?php
					}
					?>
										
					handleMonthChange('fy_start_month');

					<?php 
					if ($systemConfigData['financial_year_start_day_no'] != "") { ?>
							$("#fy_start_day").val(<?php echo $systemConfigData['financial_year_start_day_no']; ?>);
							FYStartDayNo = $("#fy_start_day").val();
					<?php
					}
					?>
										
					$('#fy_end_month_init').hide();
					$("#fy_end_month_dropdown").html(response);
					$("#month").prop({ id: "fy_end_month"});
					
					<?php 
					if ($systemConfigData['financial_year_end_month_no'] != "") { ?>
							$("#fy_end_month").val(<?php echo $systemConfigData['financial_year_end_month_no']; ?>);
							FYEndMonthNo = $("#fy_end_month").val();
					<?php
					}
					?>
										
					handleMonthChange('fy_end_month');

					<?php 
					if ($systemConfigData['financial_year_end_day_no'] != "") { ?>
							$("#fy_end_day").val(<?php echo $systemConfigData['financial_year_end_day_no']; ?>);
							FYEndDayNo = $("#fy_end_day").val();
					<?php
					}
					?>
				}
			});
		},

		getChartOfAccounts: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/getAllToChartOfAccountsDropDown",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(chartOfAccountsDropDown) {
					
                    $("#parent_liabilities_chart_of_account_div").empty();
					$("#parent_liabilities_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#parent_liabilities_chart_of_account_div").find("#chart_of_account").prop({ id: "parent_liabilities_chart_of_account"});
					$("#parent_liabilities_chart_of_account_div").find("#chart_of_accountError").prop({ id: "parent_liabilities_chart_of_accountError"});
                    $("#parent_liabilities_chart_of_account").val(<?php echo $systemConfigData['parent_liabilities_chart_of_account']; ?>);
                    
                    $("#parent_assets_chart_of_account_div").empty();
					$("#parent_assets_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#parent_assets_chart_of_account_div").find("#chart_of_account").prop({ id: "parent_assets_chart_of_account"});
					$("#parent_assets_chart_of_account_div").find("#chart_of_accountError").prop({ id: "parent_assets_chart_of_accountError"});
                    $("#parent_assets_chart_of_account").val(<?php echo $systemConfigData['parent_assets_chart_of_account']; ?>);
                    
                    $("#retained_earnings_chart_of_account_div").empty();
					$("#retained_earnings_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#retained_earnings_chart_of_account_div").find("#chart_of_account").prop({ id: "retained_earnings_chart_of_account"});
					$("#retained_earnings_chart_of_account_div").find("#chart_of_accountError").prop({ id: "retained_earnings_chart_of_accountError"});
                    $("#retained_earnings_chart_of_account").val(<?php echo $systemConfigData['retained_earnings_chart_of_account']; ?>);
                    
					$("#cash_related_chart_of_account_for_cash_accounting_method_div").empty();
					$("#cash_related_chart_of_account_for_cash_accounting_method_div").append(chartOfAccountsDropDown);
					$("#cash_related_chart_of_account_for_cash_accounting_method_div").find("#chart_of_account").prop({ id: "cash_related_chart_of_account_for_cash_accounting_method"});
					$("#cash_related_chart_of_account_for_cash_accounting_method_div").find("#chart_of_accountError").prop({ id: "cash_related_chart_of_account_for_cash_accounting_methodError"});
					
					$("#customer_return_credit_profit_margin_chart_of_account_div").empty();
					$("#customer_return_credit_profit_margin_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#customer_return_credit_profit_margin_chart_of_account_div").find("#chart_of_account").prop({ id: "customer_return_credit_profit_margin_chart_of_account"});
					$("#customer_return_credit_profit_margin_chart_of_account_div").find("#chart_of_accountError").prop({ id: "customer_return_credit_profit_margin_chart_of_accountError"});
					
					$("#customer_return_credit_profit_margin_chart_of_account").val(<?php echo $systemConfigData['customer_market_return_cost_entry_profit_margin_credit_account_id'] ?>);
					
                    $("#opening_balance_equity_chart_of_account_div").empty();
					$("#opening_balance_equity_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#opening_balance_equity_chart_of_account_div").find("#chart_of_account").prop({ id: "opening_balance_equity_chart_of_account"});
					$("#opening_balance_equity_chart_of_account_div").find("#chart_of_accountError").prop({ id: "opening_balance_equity_chart_of_accountError"});
                    $("#opening_balance_equity_chart_of_account").val(<?php echo $systemConfigData['opening_balance_equity_chart_of_account']; ?>);
                    
					$("#trial_balance_chart_of_account_div").empty();
					$("#trial_balance_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#trial_balance_chart_of_account_div").find("#chart_of_account").prop({ id: "trial_balance_chart_of_account"});
					$("#trial_balance_chart_of_account_div").find("#chart_of_accountError").prop({ id: "trial_balance_chart_of_accountError"});
                    
                    $("#cash_and_cash_equivalents_chart_of_account_div").empty();
					$("#cash_and_cash_equivalents_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#cash_and_cash_equivalents_chart_of_account_div").find("#chart_of_account").prop({ id: "cash_and_cash_equivalents_chart_of_account"});
					$("#cash_and_cash_equivalents_chart_of_account_div").find("#chart_of_accountError").prop({ id: "cash_and_cash_equivalents_chart_of_accountError"});
                    $("#cash_and_cash_equivalents_chart_of_account").val(<?php echo $systemConfigData['acm_cash_and_cash_equivalents_report_main_chart_of_account']; ?>);
                    
                    $("#cheque_in_hand_chart_of_account_div").empty();
					$("#cheque_in_hand_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#cheque_in_hand_chart_of_account_div").find("#chart_of_account").prop({ id: "cheque_in_hand_chart_of_account"});
					$("#cheque_in_hand_chart_of_account_div").find("#chart_of_accountError").prop({ id: "cheque_in_hand_chart_of_accountError"});
                    $("#cheque_in_hand_chart_of_account").val(<?php echo $systemConfigData['acm_cash_and_cash_equivalents_report_cheque_in_hand_chart_of_account']; ?>);
					
					$("#non_current_assets_chart_of_account_div").empty();
					$("#non_current_assets_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#non_current_assets_chart_of_account_div").find("#chart_of_account").prop({ id: "non_current_assets_chart_of_account"});
					$("#non_current_assets_chart_of_account_div").find("#chart_of_accountError").prop({ id: "non_current_assets_chart_of_accountError"});
					
					$("#current_assets_chart_of_account_div").empty();
					$("#current_assets_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#current_assets_chart_of_account_div").find("#chart_of_account").prop({ id: "current_assets_chart_of_account"});
					$("#current_assets_chart_of_account_div").find("#chart_of_accountError").prop({ id: "current_assets_chart_of_accountError"});
					
					$("#equity_chart_of_account_div").empty();
					$("#equity_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#equity_chart_of_account_div").find("#chart_of_account").prop({ id: "equity_chart_of_account"});
					$("#equity_chart_of_account_div").find("#chart_of_accountError").prop({ id: "equity_chart_of_accountError"});
					
					$("#non_current_liabilities_chart_of_account_div").empty();
					$("#non_current_liabilities_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#non_current_liabilities_chart_of_account_div").find("#chart_of_account").prop({ id: "non_current_liabilities_chart_of_account"});
					$("#non_current_liabilities_chart_of_account_div").find("#chart_of_accountError").prop({ id: "non_current_liabilities_chart_of_accountError"});
					
					$("#current_liabilities_chart_of_account_div").empty();
					$("#current_liabilities_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#current_liabilities_chart_of_account_div").find("#chart_of_account").prop({ id: "current_liabilities_chart_of_account"});
					$("#current_liabilities_chart_of_account_div").find("#chart_of_accountError").prop({ id: "current_liabilities_chart_of_accountError"});
					
					$("#revenue_calculating_chart_of_account_div").empty();
					$("#revenue_calculating_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#revenue_calculating_chart_of_account_div").find("#chart_of_account").prop({ id: "revenue_calculating_chart_of_account"});
					$("#revenue_calculating_chart_of_account_div").find("#chart_of_accountError").prop({ id: "revenue_calculating_chart_of_accountError"});
					
					$("#gross_profit_calculating_chart_of_account_div").empty();
					$("#gross_profit_calculating_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#gross_profit_calculating_chart_of_account_div").find("#chart_of_account").prop({ id: "gross_profit_calculating_chart_of_account"});
					$("#gross_profit_calculating_chart_of_account_div").find("#chart_of_accountError").prop({ id: "gross_profit_calculating_chart_of_accountError"});
					
					$("#operating_activities_calculating_chart_of_account_div").empty();
					$("#operating_activities_calculating_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#operating_activities_calculating_chart_of_account_div").find("#chart_of_account").prop({ id: "operating_activities_calculating_chart_of_account"});
					$("#operating_activities_calculating_chart_of_account_div").find("#chart_of_accountError").prop({ id: "operating_activities_calculating_chart_of_accountError"});
					
					$("#profit_calculating_chart_of_account_div").empty();
					$("#profit_calculating_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#profit_calculating_chart_of_account_div").find("#chart_of_account").prop({ id: "profit_calculating_chart_of_account"});
					$("#profit_calculating_chart_of_account_div").find("#chart_of_accountError").prop({ id: "profit_calculating_chart_of_accountError"});
					
					$("#net_profit_calculating_chart_of_account_div").empty();
					$("#net_profit_calculating_chart_of_account_div").append(chartOfAccountsDropDown);
					$("#net_profit_calculating_chart_of_account_div").find("#chart_of_account").prop({ id: "net_profit_calculating_chart_of_account"});
					$("#net_profit_calculating_chart_of_account_div").find("#chart_of_accountError").prop({ id: "net_profit_calculating_chart_of_accountError"});
				}
			});
		},

		isLevelOneChartOfAccount : function(chartOfAccountId) {

			var result = '';

			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/isLevelOneChartOfAccount",
				data: {
					'chart_of_account_id' : chartOfAccountId,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				async: false,
				success: function(levelOneChartOfAccount) {
					if (levelOneChartOfAccount === "Yes") {
						result =  "Yes";
					} else {
						result = "No";
					}
				}
			});

			return result;
		},

		getChartOfAccountName : function(chartOfAccountId) {

			var result = '';

			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/getChartOfAccountName",
				data: {
					'chart_of_account_id' : chartOfAccountId,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				async: false,
				success: function(chartOfAccountName) {
					result =  chartOfAccountName;
				}
			});

			return result;
		},
		
		//get accounts prime entry books drop down
		getPurchaseNoteProductsAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#purchase_note_products_accounts_prime_entry_book_init').hide();
						$("#purchase_note_products_accounts_prime_entry_book_dropdown").empty();
						$("#purchase_note_products_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "pnp_purchase_note_products_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getPurchaseNoteProductsAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getPurchaseNoteProductsAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#pnp_purchase_note_products_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getPurchaseNoteFreeIssuesAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#purchase_note_free_issues_accounts_prime_entry_book_init').hide();
						$("#purchase_note_free_issues_accounts_prime_entry_book_dropdown").empty();
						$("#purchase_note_free_issues_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "pnf_purchase_note_free_issues_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getPurchaseNoteFreeIssuesAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getPurchaseNoteFreeIssuesAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#pnf_purchase_note_free_issues_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getSalesNoteSalesEntryAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#sales_note_sales_entry_accounts_prime_entry_book_init').hide();
						$("#sales_note_sales_entry_accounts_prime_entry_book_dropdown").empty();
						$("#sales_note_sales_entry_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "sns_sales_note_sales_entry_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getSalesNoteSalesEntryAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getSalesNoteSalesEntryAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#sns_sales_note_sales_entry_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getSalesNoteCostEntryAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#sales_note_cost_entry_accounts_prime_entry_book_init').hide();
						$("#sales_note_cost_entry_accounts_prime_entry_book_dropdown").empty();
						$("#sales_note_cost_entry_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "snc_sales_note_cost_entry_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getSalesNoteCostEntryAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getSalesNoteCostEntryAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#snc_sales_note_cost_entry_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getSalesNoteFreeIssuesAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#sales_note_free_issues_accounts_prime_entry_book_init').hide();
						$("#sales_note_free_issues_accounts_prime_entry_book_dropdown").empty();
						$("#sales_note_free_issues_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "snf_sales_note_free_issues_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getSalesNoteFreeIssuesAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getSalesNoteFreeIssuesAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#snf_sales_note_free_issues_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getSalesNoteDiscountAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#sales_note_discount_accounts_prime_entry_book_init').hide();
						$("#sales_note_discount_accounts_prime_entry_book_dropdown").empty();
						$("#sales_note_discount_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "snd_sales_note_discount_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getSalesNoteDiscountAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getSalesNoteDiscountAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#snd_sales_note_discount_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getCustomerSaleableReturnSalesEntryAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$("#customer_saleable_return_note_sales_entry_accounts_prime_entry_book_init").hide();
						$("#customer_saleable_return_note_sales_entry_accounts_prime_entry_book_dropdown").empty();
						$("#customer_saleable_return_note_sales_entry_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_id"});
					}
			});
		},
		
		getCustomerSaleableReturnSalesEntryAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getCustomerSaleableReturnSalesEntryAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#css_customer_saleable_return_note_sales_entry_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getCustomerSaleableReturnCostEntryAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$("#customer_saleable_return_note_cost_entry_accounts_prime_entry_book_init").hide();
						$("#customer_saleable_return_note_cost_entry_accounts_prime_entry_book_dropdown").empty();
						$("#customer_saleable_return_note_cost_entry_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getCustomerSaleableReturnCostEntryAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getCustomerSaleableReturnCostEntryAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#csc_customer_saleable_return_note_cost_entry_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getCustomerMarketReturnSalesEntryAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$("#customer_market_return_note_sales_entry_accounts_prime_entry_book_init").hide();
						$("#customer_market_return_note_sales_entry_accounts_prime_entry_book_dropdown").empty();
						$("#customer_market_return_note_sales_entry_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_id"});
					}
			});
		},
		
		getCustomerMarketReturnSalesEntryAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getCustomerMarketReturnSalesEntryAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#cms_customer_market_return_note_sales_entry_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getCustomerMarketReturnCostEntryAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$("#customer_market_return_note_cost_entry_accounts_prime_entry_book_init").hide();
						$("#customer_market_return_note_cost_entry_accounts_prime_entry_book_dropdown").empty();
						$("#customer_market_return_note_cost_entry_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getCustomerMarketReturnCostEntryAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getCustomerMarketReturnCostEntryAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#cmc_customer_market_return_note_cost_entry_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getSupplierSaleableReturnAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#supplier_saleable_return_note_accounts_prime_entry_book_init').hide();
						$("#supplier_saleable_return_note_accounts_prime_entry_book_dropdown").empty();
						$("#supplier_saleable_return_note_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "ssr_supplier_saleable_return_note_accounts_prime_entry_book_id"});
					}
			});
		},
		
		getSupplierSaleableReturnAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getSupplierSaleableReturnAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#ssr_supplier_saleable_return_note_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getSupplierMarketReturnAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#supplier_market_return_note_accounts_prime_entry_book_init').hide();
						$("#supplier_market_return_note_accounts_prime_entry_book_dropdown").empty();
						$("#supplier_market_return_note_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "smr_supplier_market_return_note_accounts_prime_entry_book_id"});
					}
			});
		},
		
		getSupplierMarketReturnAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getSupplierMarketReturnAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#smr_supplier_market_return_note_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getReceivePaymentCashAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#receive_payment_cash_accounts_prime_entry_book_init').hide();
						$("#receive_payment_cash_accounts_prime_entry_book_dropdown").empty();
						$("#receive_payment_cash_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "rca_receive_payment_cash_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getReceivePaymentCashAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReceivePaymentCashAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#rca_receive_payment_cash_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getReceivePaymentChequeAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#receive_payment_cheque_accounts_prime_entry_book_init').hide();
						$("#receive_payment_cheque_accounts_prime_entry_book_dropdown").empty();
						$("#receive_payment_cheque_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "rcq_receive_payment_cheque_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getReceivePaymentChequeAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReceivePaymentChequeAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#rcq_receive_payment_cheque_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
        
        //get accounts prime entry books drop down
		getReceivePaymentChequeDepositAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#receive_payment_cheque_deposit_accounts_prime_entry_book_init').hide();
						$("#receive_payment_cheque_deposit_accounts_prime_entry_book_dropdown").empty();
						$("#receive_payment_cheque_deposit_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getReceivePaymentChequeDepositAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReceivePaymentChequeDepositAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#rcd_receive_payment_cheque_deposit_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
        //get accounts prime entry books drop down
		getReceivePaymentCreditCardAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#receive_payment_credit_card_accounts_prime_entry_book_init').hide();
						$("#receive_payment_credit_card_accounts_prime_entry_book_dropdown").empty();
						$("#receive_payment_credit_card_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "rcc_receive_payment_credit_card_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getReceivePaymentCreditCardAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReceivePaymentCreditCardAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#rcc_receive_payment_credit_card_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
        
        //get accounts prime entry books drop down
		getReceivePaymentTransactionClaimAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#receive_payment_transaction_claim_accounts_prime_entry_book_init').hide();
						$("#receive_payment_transaction_claim_accounts_prime_entry_book_dropdown").empty();
						$("#receive_payment_transaction_claim_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "rtc_receive_payment_transaction_claim_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getReceivePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReceivePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#rtc_receive_payment_transaction_claim_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
        
		//get accounts prime entry books drop down
		getMakePaymentCashAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#make_payment_cash_accounts_prime_entry_book_init').hide();
						$("#make_payment_cash_accounts_prime_entry_book_dropdown").empty();
						$("#make_payment_cash_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "pca_make_payment_cash_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getMakePaymentCashAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getMakePaymentCashAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#pca_make_payment_cash_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getMakePaymentChequeAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#make_payment_cheque_accounts_prime_entry_book_init').hide();
						$("#make_payment_cheque_accounts_prime_entry_book_dropdown").empty();
						$("#make_payment_cheque_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "pcq_make_payment_cheque_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getMakePaymentChequeAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getMakePaymentChequeAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#pcq_make_payment_cheque_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		//get accounts prime entry books drop down
		getMakePaymentThirdPartyChequeAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#make_payment_second_or_third_party_cheque_accounts_prime_entry_book_init').hide();
						$("#make_payment_second_or_third_party_cheque_accounts_prime_entry_book_dropdown").empty();
						$("#make_payment_second_or_third_party_cheque_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getMakePaymentThirdPartyChequeAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getMakePaymentThirdPartyChequeAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#ptc_make_payment_second_or_third_party_cheque_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
        
        //get accounts prime entry books drop down
		getMakePaymentTransactionClaimAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#make_payment_transaction_claim_accounts_prime_entry_book_init').hide();
						$("#make_payment_transaction_claim_accounts_prime_entry_book_dropdown").empty();
						$("#make_payment_transaction_claim_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "pcl_make_payment_transaction_claim_accounts_prime_entry_book_id"});

					}
			});
		},
		
		getMakePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getMakePaymentTransactionClaimAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#pcl_make_payment_transaction_claim_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
        
        //get make payment default payee type drop down
		getMakePaymentDefaultPayeeTypeData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getMakePaymentDefaultPayeeTypeDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#make_payment_default_payee_type_init').hide();
						$("#make_payment_default_payee_type_dropdown").empty();
						$("#make_payment_default_payee_type_dropdown").html(response);
					}
			});
		},
        
        //get make payment default reference transaction type drop down
		getMakePaymentDefaultReferenceTransactionTypeData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getMakePaymentDefaultReferenceTransactionTypeDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#make_payment_default_reference_transaction_type_init').hide();
						$("#make_payment_default_reference_transaction_type_dropdown").empty();
						$("#make_payment_default_reference_transaction_type_dropdown").html(response);
                        $("#reference_transaction_type_id").prop({ id: "make_payment_default_reference_transaction_type_id"});
					}
			});
		},
        
        //get receive payment default payer type drop down
		getReceivePaymentDefaultPayerTypeData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReceivePaymentDefaultPayerTypeDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#receive_payment_default_payer_type_init').hide();
						$("#receive_payment_default_payer_type_dropdown").empty();
						$("#receive_payment_default_payer_type_dropdown").html(response);
					}
			});
		},
        
        //get receive payment default reference transaction type drop down
		getReceivePaymentDefaultReferenceTransactionTypeData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getReceivePaymentDefaultReferenceTransactionTypeDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#receive_payment_default_reference_transaction_type_init').hide();
						$("#receive_payment_default_reference_transaction_type_dropdown").empty();
						$("#receive_payment_default_reference_transaction_type_dropdown").html(response);
                        $("#reference_transaction_type_id").prop({ id: "receive_payment_default_reference_transaction_type_id"});
					}
			});
		}
	}
	
	function isParentChartOfAccountAlreadySelected(id) {
		var cloneCount = 1;
		var SelectedChartOfAccountId = '';
		var alreadySelectedChartOfAccountIds = [];
		var element = '';
		var result = false;
		
		if (id == "cash_related_chart_of_account_for_cash_accounting_method") {
			SelectedChartOfAccountId = $("#cash_related_chart_of_account_for_cash_accounting_method").val();

			element = $("#cash_related_chart_of_account_for_cash_accounting_method_category_group").find("#cash_related_chart_of_account_for_cash_accounting_method_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#cash_related_chart_of_account_for_cash_accounting_method_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#cash_related_chart_of_account_for_cash_accounting_method_category_group").find("#cash_related_chart_of_account_for_cash_accounting_method_category_" + cloneCount);
			}
		} else if (id == "non_current_assets_chart_of_account") {
			SelectedChartOfAccountId = $("#non_current_assets_chart_of_account").val();

			element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#non_current_assets_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#non_current_assets_chart_of_account_category_group").find("#non_current_assets_chart_of_account_category_" + cloneCount);
			}
		} else if (id == "current_assets_chart_of_account") {
			SelectedChartOfAccountId = $("#current_assets_chart_of_account").val();

			element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#current_assets_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#current_assets_chart_of_account_category_group").find("#current_assets_chart_of_account_category_" + cloneCount);
			}
		} if (id == "equity_chart_of_account") {
			SelectedChartOfAccountId = $("#equity_chart_of_account").val();

			element = $("#equity_chart_of_account_category_group").find("#equity_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#equity_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#equity_chart_of_account_category_group").find("#equity_chart_of_account_category_" + cloneCount);
			}
		} if (id == "non_current_liabilities_chart_of_account") {
			SelectedChartOfAccountId = $("#non_current_liabilities_chart_of_account").val();

			element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#non_current_liabilities_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#non_current_liabilities_chart_of_account_category_group").find("#non_current_liabilities_chart_of_account_category_" + cloneCount);
			}
		} if (id == "current_liabilities_chart_of_account") {
			SelectedChartOfAccountId = $("#current_liabilities_chart_of_account").val();

			element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#current_liabilities_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#current_liabilities_chart_of_account_category_group").find("#current_liabilities_chart_of_account_category_" + cloneCount);
			}
		} else if (id == "revenue_calculating_chart_of_account") {
			SelectedChartOfAccountId = $("#revenue_calculating_chart_of_account").val();

			element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#revenue_calculating_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#revenue_calculating_chart_of_account_category_group").find("#revenue_calculating_chart_of_account_category_" + cloneCount);
			}
		} else if (id == "gross_profit_calculating_chart_of_account") {
			SelectedChartOfAccountId = $("#gross_profit_calculating_chart_of_account").val();

			element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#gross_profit_calculating_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#gross_profit_calculating_chart_of_account_category_group").find("#gross_profit_calculating_chart_of_account_category_" + cloneCount);
			}
		} else if (id == "operating_activities_calculating_chart_of_account") {
			SelectedChartOfAccountId = $("#operating_activities_calculating_chart_of_account").val();

			element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#operating_activities_calculating_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#operating_activities_calculating_chart_of_account_category_group").find("#operating_activities_calculating_chart_of_account_category_" + cloneCount);
			}
		} else if (id == "profit_calculating_chart_of_account") {
			SelectedChartOfAccountId = $("#profit_calculating_chart_of_account").val();

			element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#profit_calculating_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_" + cloneCount);
			}
		} else if (id == "profit_calculating_chart_of_account") {
			SelectedChartOfAccountId = $("#profit_calculating_chart_of_account").val();

			element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#profit_calculating_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#profit_calculating_chart_of_account_category_group").find("#profit_calculating_chart_of_account_category_" + cloneCount);
			}
		} else if (id == "net_profit_calculating_chart_of_account") {
			SelectedChartOfAccountId = $("#net_profit_calculating_chart_of_account").val();

			element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_1");

			while (element.length == 1) {
				alreadySelectedChartOfAccountIds.push($("#net_profit_calculating_chart_of_account_category_id_" + cloneCount).val());
				cloneCount++;
				element = $("#net_profit_calculating_chart_of_account_category_group").find("#net_profit_calculating_chart_of_account_category_" + cloneCount);
			}
		}
		
		$.ajax({
			type:"POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/checkWhetherParentChartOfAccountAlreadySelected",
			data: {
				'selected_chart_of_account_id' : SelectedChartOfAccountId,
				'already_selected_chart_of_acount_ids' : alreadySelectedChartOfAccountIds,
				<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
			async: false,
			success: function(response) {
				result =  response;
			}
		});
		
		return result;
	}
	
	function validatePurchaseNoteReferenceNoConfig() {
		return (isNotEmpty("purchase_note_reference_no_code", "<?php echo $this->lang->line('purchase_note_reference_no_code_required')?>")
			&& isNotEmpty("purchase_note_reference_no_start_number", "<?php echo $this->lang->line('purchase_note_reference_no_start_number_required')?>")
			&& isNumeric("purchase_note_reference_no_start_number", "<?php echo $this->lang->line('purchase_note_reference_no_start_number_should_be_a_number')?>")
		);
	}
	
	function validateSalesNoteReferenceNoConfig() {
		return (isNotEmpty("sales_note_reference_no_code", "<?php echo $this->lang->line('sales_note_reference_no_code_required')?>")
			&& isNotEmpty("sales_note_reference_no_start_number", "<?php echo $this->lang->line('sales_note_reference_no_start_number_required')?>")
			&& isNumeric("sales_note_reference_no_start_number", "<?php echo $this->lang->line('sales_note_reference_no_start_number_should_be_a_number')?>")
		);
	}
	
	function validateCustomerReturnReferenceNoConfig() {
		return (isNotEmpty("customer_return_note_reference_no_code", "<?php echo $this->lang->line('customer_return_note_reference_no_code_required')?>")
			&& isNotEmpty("customer_return_note_reference_no_start_number", "<?php echo $this->lang->line('customer_return_note_reference_no_start_number_required')?>")
			&& isNumeric("customer_return_note_reference_no_start_number", "<?php echo $this->lang->line('customer_return_note_reference_no_start_number_should_be_a_number')?>")
		);
	}
	
	function validateSupplierReturnReferenceNoConfig() {
		return (isNotEmpty("supplier_return_note_reference_no_code", "<?php echo $this->lang->line('supplier_return_note_reference_no_code_required')?>")
			&& isNotEmpty("supplier_return_note_reference_no_start_number", "<?php echo $this->lang->line('supplier_return_note_reference_no_start_number_required')?>")
			&& isNumeric("supplier_return_note_reference_no_start_number", "<?php echo $this->lang->line('supplier_return_note_reference_no_start_number_should_be_a_number')?>")
		);
	}
	
	function validateReceivePaymentReferenceNoConfig() {
		return (isNotEmpty("receive_payment_reference_no_code", "<?php echo $this->lang->line('receive_payment_reference_no_code_required')?>")
			&& isNotEmpty("receive_payment_reference_no_start_number", "<?php echo $this->lang->line('receive_payment_reference_no_start_number_required')?>")
			&& isNumeric("receive_payment_reference_no_start_number", "<?php echo $this->lang->line('receive_payment_reference_no_start_number_should_be_a_number')?>")
		);
	}
	
	function validateMakePaymentReferenceNoConfig() {
		return (isNotEmpty("make_payment_reference_no_code", "<?php echo $this->lang->line('make_payment_reference_no_code_required')?>")
			&& isNotEmpty("make_payment_reference_no_start_number", "<?php echo $this->lang->line('make_payment_reference_no_start_number_required')?>")
			&& isNumeric("make_payment_reference_no_start_number", "<?php echo $this->lang->line('make_payment_reference_no_start_number_should_be_a_number')?>")
		);
	}
	
	function validateSalesNoteSalesProfitMarginConfig() {
		if ($("#sales_profit_margin_percentage").val() != '') {
			return (isFlootPositive("sales_profit_margin_percentage", "<?php echo $this->lang->line('sales_profit_margin_is_not_valid')?>"));
		} else {
			return true;
		}
	}

	function clearForm() {
		$(".validation").hide();
		$(".msg_data").hide();
	}
</script>

<style>
	.config_checkboxes {
		vertical-align: text-bottom;
		margin-right:8px !important;
	}

	.light_color_background {
		background: #eafaea;
	}

	.config_use_status {
		color: #ff4d4d !important;
	}

	hr.light {
		width:97%; 
		margin-left: 15px !important; 
		border:0px none white; 
		border-top:1px solid lightgrey; 
	}

	.category_data {
		color: #e68a00 !important;
	}
	
	.prime_entry_book_data {
		color: #e68a00 !important;
	}
</style>