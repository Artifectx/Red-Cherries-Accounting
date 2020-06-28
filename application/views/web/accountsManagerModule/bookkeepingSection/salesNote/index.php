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
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Sales Note') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
				<div class="msg_delete"></div>
                <div class='msg_instant' align="center"></div>
				<div class='form' id="sales_note_details_form">
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-content'>
									<div class='validation'></div>
									<div class='box' id="add_sales_note_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div class='title'><?php echo $this->lang->line('Add Sales Note') ?></div>
											<div class='actions'>
												<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
												</a>
											</div>
										</div>
										<div class='box-content'>
											<form class='form form-horizontal validate-form save_form' method="post">
												<div class='tabbable' style='margin-top: 20px'>
													<ul class='nav nav-responsive nav-tabs'>
														<li class='active'>
															<a data-toggle='tab' class="tab-header" href='#sales_note_details'><?php echo $this->lang->line('Sales Note Details') ?></a>
														</li>
														<li class=''>
															<a data-toggle='tab' class="tab-header" href='#customer_returns_and_payment_details'><?php echo $this->lang->line('Customer Returns and Payment Details') ?></a>
														</li>
													</ul>
													<div class='tab-content'>
														<div id="sales_note_details" class="tab-pane active">
															<input class='form-control' id='sales_note_id' name='sales_note_id' type='hidden'>
															<input class='form-control' id='sales_journal_entry_id' name='sales_journal_entry_id' type='hidden'>

															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference No') ?> *</label>
																<div class='col-sm-4 controls' id="reference_no_div">
																	<input class='form-control' id='reference_no' name='reference_no'
																		   placeholder='<?php echo $this->lang->line('Reference No') ?>' type='text' 
																		   value="<?php echo set_value('reference_no'); ?>"
																		   <?php if ($sales_note_no_auto_increment_status) { echo 'readonly';}?>>
																	<div id="reference_noError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Date') ?> *</label>
																<div class='col-sm-4 controls'>
																	<div class='datepicker-input input-group' id='datepicker_sales_note_date'>
																		<input class='form-control' id='sales_note_date' name='sales_note_date'
																			   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																		  <span class="input-group-addon">
																				<span class="glyphicon glyphicon-calendar"/>
																		  </span>
																	</div>
																	<div id="sales_note_dateError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Customer') ?></label>
																<div class='col-sm-4 controls'>
																	<select id="customer_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																	<!--Supplier drop down-->
																	<div id="customer_dropdown">
																	</div>
																	<!--End Supplier drop down-->
																	<div id="customer_idError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Territory') ?></label>
																<div class='col-sm-4 controls'>
																	<select id="teritory_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																	<!--Location drop down-->
																	<div id="teritory_dropdown">
																	</div>
																	<!--End location drop down-->
																	<div id="teritory_idError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Location') ?> *</label>
																<div class='col-sm-4 controls'>
																	<select id="location_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																	<!--Location drop down-->
																	<div id="location_dropdown">
																	</div>
																	<!--End location drop down-->
																	<div id="locationError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Sales Amount') ?> *</label>
																<div class='col-sm-4 controls' id="sales_amount_div">
																	<input class='form-control' id='sales_amount' name='sales_amount'
																		   placeholder='<?php echo $this->lang->line('Sales Amount') ?>' type='text' 
																		   value="<?php echo set_value('sales_amount'); ?>" onblur="handleSalesAmountAddition();">
																	<div id="sales_amountError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Discount') ?></label>
																<div class='col-sm-4 controls' id="discount_div">
																	<input class='form-control' id='discount' name='discount'
																		   placeholder='<?php echo $this->lang->line('Discount') ?>' type='text' 
																		   value="<?php echo set_value('discount'); ?>" onblur="handleDiscountAddition();">
																	<div id="discountError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Free Issue Amount') ?></label>
																<div class='col-sm-4 controls' id="free_issue_amount_div">
																	<input class='form-control' id='free_issue_amount' name='free_issue_amount'
																		   placeholder='<?php echo $this->lang->line('Free Issue Amount') ?>' type='text' 
																		   value="<?php echo set_value('free_issue_amount'); ?>" onblur="handleFreeIssueAmountAddition();">
																	<div id="free_issue_amountError" class="red"></div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount Payable') ?></label>
																<div class='col-sm-4 controls' id="sales_amount_payable_div">
																	<input class='form-control' id='sales_amount_payable' name='sales_amount_payable' disabled
																		   placeholder='<?php echo $this->lang->line('Amount Payable') ?>' type='text' 
																		   value="<?php echo set_value('sales_amount_payable'); ?>">
																	<div id="sales_amount_payableError" class="red"></div>
																</div>
															</div>
                                                            <div class='form-group'>
                                                                <label class='control-label col-sm-3'><?php echo $this->lang->line('Balance Amount') ?></label>
                                                                <div class='col-sm-4 controls' id='sales_balance_amount_div'>
                                                                    <input class='form-control' id='sales_balance_amount' name='sales_balance_amount' disabled
                                                                           placeholder='<?php echo $this->lang->line('Balance Amount') ?>' type='text' 
                                                                           value='<?php echo set_value('balance_payment'); ?>'>
                                                                    <div id='sales_balance_amountError' class='red'></div>
                                                                </div>
                                                            </div>
															<div class='form-group' id="remark_group">
																<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Remark') ?> </label>
																<div class='col-sm-4 controls'>
																	<textarea class='form-control' id='remark' name='remark'
																		   placeholder='<?php echo $this->lang->line('Remark') ?>'><?php echo set_value('remark'); ?>
																	</textarea>
																	<div id="memoError" class="red"></div>
																</div>
															</div>
															<div class='form-actions' style='margin-bottom:0'>
																<div class='row'>
																	<div class='col-sm-9 col-sm-offset-3'>
																		<?php
																		if (isset($ACM_Bookkeeping_Add_Sales_Note_Permissions)){
																			?>
																			<button class='btn btn-success save' id="sales_note_save"
																					onclick='saveSalesNoteData();' type='button'>
																				<i class='icon-save'></i>
																				<?php echo $this->lang->line('Save') ?>
																			</button>
																			<?php
																		}
																		?>
																		<button id='refresh_button_on_sales_note_save' class='btn btn-primary' type='reset' onclick='clearData();'>
																			<i class='icon-undo'></i>
																			<?php echo $this->lang->line('Refresh') ?>
																		</button>
																		<button id='cancel_sales_note_button_on_sales_note_save' class='btn btn-danger' type='button' id="cancel_sales_note_on_sales_note_save" onclick='cancelSalesNote();'>
																			<i class='icon-off'></i>
																			<?php echo $this->lang->line('Cancel Sales Note') ?>
																		</button>
																		<button class='btn btn-warning cancel' onclick='cancelData();'
																				type='button'>
																			<i class='icon-ban-circle'></i>
																			<?php echo $this->lang->line('Close') ?>
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div id="customer_returns_and_payment_details" class="tab-pane">
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount Payable') ?></label>
																<div class='col-sm-4 controls' id="sales_amount_payable_on_payment_div">
																	<input class='form-control' id='sales_amount_payable_on_payment' name='sales_amount_payable_on_payment' disabled
																		   placeholder='<?php echo $this->lang->line('Amount Payable') ?>' type='text' 
																		   value="<?php echo set_value('sales_amount_payable_on_payment'); ?>">
																	<div id="sales_amount_payable_on_paymentError" class="red"></div>
																</div>
															</div>
															<div class="form-group">
																<div class='col-sm-3 controls'></div>
																<div class='col-sm-5 controls'>
																	<input type="checkbox" name="customer_returns_available" id="customer_returns_available" style="vertical-align: text-bottom;" onchange="handleCustomerReturnsAvailableSelect(this.id);">
																	<label for="customer_returns_available" ><?php echo $this->lang->line('Customer Returns Available') ?></label>
																</div>
															</div>
															<div id="customer_return_details_div">
																<div class='form-group'>
																	<label class='control-label col-sm-3'><?php echo $this->lang->line('Customer Saleable Return Amount') ?></label>
																	<div class='col-sm-4 controls' id="customer_saleable_return_amount_div">
																		<input class='form-control' id='customer_saleable_return_amount' name='customer_saleable_return_amount'
																			   placeholder='<?php echo $this->lang->line('Customer Saleable Return Amount') ?>' type='text' 
																			   value="<?php echo set_value('customer_saleable_return_amount'); ?>" onblur="handleCustomerSaleableReturnAmountAddition();">
																		<div id="customer_saleable_return_amountError" class="red"></div>
																	</div>
																</div>
																<div class='form-group'>
																	<label class='control-label col-sm-3'><?php echo $this->lang->line('Customer Market Return Amount') ?></label>
																	<div class='col-sm-4 controls' id="customer_market_return_amount_div">
																		<input class='form-control' id='customer_market_return_amount' name='customer_market_return_amount'
																			   placeholder='<?php echo $this->lang->line('Customer Market Return Amount') ?>' type='text' 
																			   value="<?php echo set_value('customer_market_return_amount'); ?>" onblur="handleCustomerMarketReturnAmountAddition();">
																		<div id="customer_market_return_amountError" class="red"></div>
																	</div>
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Cash Payment') ?></label>
																<div class='col-sm-4 controls'>
																	<input class='form-control' id='cash_payment' name='cash_payment' disabled
																		   placeholder='<?php echo $this->lang->line('Cash Payment') ?>' type='text' 
																		   value="<?php echo set_value('cash_payment'); ?>">
																	<div id="cash_paymentError" class="red"></div>
																</div>
																<div class='col-sm-4 controls'>
																	<button class='btn btn-success save' id="add_cash_payment"
																			onclick='addCashPayment();' type='button'>
																		<i class='icon-save'></i>
																		<?php echo $this->lang->line('Cash Payments') ?>
																	</button>	
																</div>
															</div>
															<div class='form-group'>
																<label class='control-label col-sm-3'><?php echo $this->lang->line('Cheque Payment') ?></label>
																<div class='col-sm-4 controls' id="cheque_payment_div">
																	<input class='form-control' id='cheque_payment' name='cheque_payment'
																		   placeholder='<?php echo $this->lang->line('Cheque Payment') ?>' type='text' disabled
																		   value="<?php echo set_value('cheque_payment'); ?>">
																	<div id="cheque_paymentError" class="red"></div>
																</div>
																<div class='col-sm-4 controls'>
																	<button class='btn btn-success save' id="add_cheque_payment"
																			onclick='addChequePayment();' type='button'>
																		<i class='icon-save'></i>
																		<?php echo $this->lang->line('Cheque Payments') ?>
																	</button>	
																</div>
															</div>
                                                            <div class='form-group'>
                                                                <label class='control-label col-sm-3'><?php echo $this->lang->line('Balance Amount') ?></label>
                                                                <div class='col-sm-4 controls' id='sales_balance_amount_div'>
                                                                    <input class='form-control' id='sales_balance_amount_on_payment' name='sales_balance_amount_on_payment' disabled
                                                                           placeholder='<?php echo $this->lang->line('Balance Amount') ?>' type='text' 
                                                                           value='<?php echo set_value('balance_payment'); ?>'>
                                                                    <div id='sales_balance_amount_on_paymentError' class='red'></div>
                                                                </div>
                                                            </div>
															<div class='form-actions' style='margin-bottom:0'>
																<div class='row'>
																	<div class='col-sm-9 col-sm-offset-3'>
																		<?php
																		if (isset($ACM_Bookkeeping_Add_Sales_Note_Permissions)){
																			?>
																			<button class='btn btn-success save' id="sales_note_payment_save"
																					onclick='saveSalesNotePaymentData();' type='button'>
																				<i class='icon-save'></i>
																				<?php echo $this->lang->line('Save') ?>
																			</button>
																			<?php
																		}
																		?>
																		<button id='refresh_button_on_sales_note_payment_save' class='btn btn-primary' type='reset' onclick='clearData();'>
																			<i class='icon-undo'></i>
																			<?php echo $this->lang->line('Refresh') ?>
																		</button>
																		<button id='cancel_sales_note_button_on_sales_note_payment_save' class='btn btn-danger' type='button' id="cancel_sales_note_on_sales_note_payment_save" onclick='cancelSalesNote();'>
																			<i class='icon-off'></i>
																			<?php echo $this->lang->line('Cancel Sales Note') ?>
																		</button>
																		<button class='btn btn-warning cancel' onclick='cancelData();'
																				type='button'>
																			<i class='icon-ban-circle'></i>
																			<?php echo $this->lang->line('Close') ?>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
									<!--edit form-->
									<div class='box' id="edit_sales_note_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div id ="sales_note_edit_box_title" class='title'><?php echo $this->lang->line('Edit Sales Note') ?></div>
											<div class='actions'>
												<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
												</a>
											</div>
										</div>
										<div class='box-content' id="edit_sales_note_form_content">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Product search form -->
				<div class='msg_data_sales_note_search'></div>
				<form class='form form-horizontal validate-form' id="search_sales_note_form">
					<div class='box'>
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Search Sales Notes') ?></div>
						</div>
						<div class='box-content'>
							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<label class='control-label col-sm-3 col-sm-3' ><?php echo $this->lang->line('Customer') ?></label>
									<label class='control-label col-sm-3 col-sm-5' ><?php echo $this->lang->line('Territory') ?></label>
								</div>
							</div>

							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<div class='col-sm-5 controls'>
										<select id="customer_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="customer_search_dropdown"></div>
										<div id="customer_search_idError" class="red"></div>
									</div>
									<div class='col-sm-5 controls'>
										<select id="teritory_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="teritory_search_dropdown"></div>
										<div id="teritory_search_idError" class="red"></div>
									</div>
									<div class='col-sm-2 controls'>
										<button class='btn btn-success save' onclick='searchData();' type='button'>
											<i class='icon-save'></i>
											<?php echo $this->lang->line('Search') ?>
										</button>
									</div>
								</div>
								<p style="margin-bottom:-10px">&nbsp;</p>
							</div>
						</div>
					</div>
				</form>

				<div id='table'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
								<?php
								if (isset($ACM_Bookkeeping_Add_Sales_Note_Permissions)){
									echo "<a class='btn btn-success btn-sm new'>{$this->lang->line('Add New Sales Note') }</a>";
								}
								?>
								<p>&nbsp;

								<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

								<div id='month_selector' class='col-sm-12' align="center">
									<input class='form-control' id='current_month' name='current_month' type='hidden'>
									<input class='form-control' id='current_year' name='current_year' type='hidden'>
									<i><img src="<?php echo base_url(); ?>assets/images/icons/previous_arrow.png" alt="" title="Previuos Month" onclick="loadPreviousMonthTransactionDetails();" style="cursor:pointer"/></i>
									&nbsp;<label id="month_name" style="text-align:center"></label>&nbsp;
									<i><img src="<?php echo base_url(); ?>assets/images/icons/next_arrow.png" alt=""  title="Next Month" onclick="loadNextMonthTransactionDetails();" style="cursor:pointer"/></i>
									<br><br>
								</div>
								
								<!--showing tabale-->
								<div id="dataTable">
								</div>
								<!--end table -->

							</div>
						</div>
					</div>
				</div>
			</div>
							
			<div class='modal fade' id='modal-sales_note_cheques' tabindex='-1'>
				<div class='modal-dialog' style="height:550px;width:800px">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='modal_title'><?php echo $this->lang->line('Payment Cheques') ?></h4>
						</div>

						<form enctype="text/plain" accept-charset="utf-8" name="formname" id="cheque_form"  method="post" action="">
							<div class='modal-body'>
								<div class='modal_msg_data'></div>
								<div id='table'>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='box' id="add_edit_cheque">
												<div class='box-header <?php echo BOXHEADER; ?>-background'>
													<div class='title'><?php echo $this->lang->line('Cheque Details') ?></div>
													<div class='actions'>
														<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
														</a>
													</div>
												</div>
												<div class='box-content'>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<input class='form-control' id='cheque_id' name='cheque_id' type='hidden'>
															<input class='form-control' id='sales_note_id_in_cheque_payment' name='sales_note_id_in_cheque_payment' type='hidden'>
															<input class='form-control' id='sales_journal_entry_id_in_cheque_payment' name='sales_journal_entry_id_in_cheque_payment' type='hidden'>
															<input class='form-control' id='customer_id_in_cheque_payment' name='customer_id_in_cheque_payment' type='hidden'>
															<input class='form-control' id='location_id_in_cheque_payment' name='location_id_in_cheque_payment' type='hidden'>
															
															<label class='control-label col-sm-8'><?php echo $this->lang->line('Date') ?> *</label>
															<div class='col-sm-6 controls'>
																<div class='datepicker-input input-group' id='cheque_payment_datepicker'>
																	<input class='form-control' id='cheque_payment_date' name='cheque_payment_date'
																		   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																	  <span class="input-group-addon">
																			<span class="glyphicon glyphicon-calendar"/>
																	  </span>
																</div>
																<div id="cheque_payment_dateError" class="red"></div>
															</div>
														</div>
													</div>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-8'><?php echo $this->lang->line('Cheque Number') ?> *</label>
															<div class='col-sm-6 controls'>
																<input class='form-control' id='cheque_number' name='cheque_number'
																	   placeholder='<?php echo $this->lang->line('Cheque Number')?>' type='text'
																	   value="<?php echo set_value('cheque_number'); ?>">
																<div id="cheque_numberError" class="red"></div>
															</div>
														</div>
													</div>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-8'><?php echo $this->lang->line('Bank') ?> *</label>
															<div class='col-sm-6 controls'>
																<select id="bank_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                <!--Bank drop down-->
                                                                <div id="bank_dropdown">
                                                                </div>
                                                                <!--End bank drop down-->
                                                                <div id="bank_idError" class="red"></div>
															</div>
														</div>
													</div>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-8'><?php echo $this->lang->line('Cheque Date') ?> *</label>
															<div class='col-sm-6 controls'>
																<div class='datepicker-input input-group' id='datepicker_cheque_date'>
																	<input class='form-control' id='cheque_date' name='cheque_date'
																		   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																	  <span class="input-group-addon">
																			<span class="glyphicon glyphicon-calendar"/>
																	  </span>
																</div>
																<div id="cheque_dateError" class="red"></div>
															</div>
                                                            <div class='col-sm-3 controls'>
                                                                <input type='checkbox' name='third_party_cheque' id='third_party_cheque' style='vertical-align: text-bottom;'>
                                                                <label for='third_party_cheque'><?php echo $this->lang->line('Third Party Cheque') ?></label>
                                                            </div>
                                                            <div class='col-sm-3 controls'>
                                                                <input type='checkbox' name='crossed_cheque' id='crossed_cheque' style='vertical-align: text-bottom;' onchange="handCrossedChequeSelect(this.id)">
                                                                <label for='crossed_cheque'><?php echo $this->lang->line('Crossed Cheque') ?></label>
                                                            </div>
														</div>
													</div>
                                                    <div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-8'><?php echo $this->lang->line('Amount') ?> *</label>
															<div class='col-sm-6 controls'>
																<input class='form-control' id='cheque_amount' name='cheque_amount'
																	   placeholder='<?php echo $this->lang->line('Amount')?>' type='text'
																	   value="<?php echo set_value('cheque_payment'); ?>">
																<div id="cheque_amountError" class="red"></div>
															</div>
															<div class='col-sm-6 controls'>
																<label class='control-label col-sm-5'><?php echo $this->lang->line('Credit Balance') ?></label>
																<div class='col-sm-6 controls'>
																	<input class='form-control' id='cheque_credit_balance' name='cheque_credit_balance'
																		   type='text' disabled value="">
																</div>
															</div>
														</div>
													</div>
                                                    <div class='form-group' id="cheque_deposit_account_div">
                                                        <div class='col-sm-12 controls'>
                                                            <label class='control-label col-sm-8'><?php echo $this->lang->line('Cheque Deposit Account') ?></label>
                                                            <div class='col-sm-6 controls'>
																<select id="cheque_deposit_account_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                <!--Cheque deposit account drop down-->
                                                                <div id="cheque_deposit_account_dropdown">
                                                                </div>
                                                                <!--End cheque deposit account drop down-->
                                                                <div id="cheque_deposit_account_idError" class="red"></div>
															</div>
                                                        </div>
                                                    </div>
													<br><br><br><br><br>
													<p style="margin-bottom:130px">&nbsp;</p>
													<div class='form-actions' style='margin-bottom:0'>
														<div class='row'>
															<div class='col-sm-9 col-sm-offset-3'>
																<?php
																if (isset($ACM_Bookkeeping_Add_Sales_Note_Permissions)) {
																	?>
																	<button class='btn btn-success save' id="save_receive_cheque_payment_data"
																			onclick='saveReceiveChequePaymentData();' type='button'>
																		<i class='icon-save'></i>
																		<?php echo $this->lang->line('Save') ?>
																	</button>
																	<?php
																}
																?>

																<button class='btn btn-primary' type='reset' onclick="clearChequeForm();">
																	<i class='icon-undo'></i>
																	<?php echo $this->lang->line('Refresh') ?>
																</button>
																<button class='btn btn-warning cancel' onclick='cancelChequePaymentData();'
																		type='button'>
																	<i class='icon-ban-circle'></i>
																	<?php echo $this->lang->line('Close') ?>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div id='table'>
												<div class='row'>
													<div class='col-sm-12'>
														<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
															<a class='btn btn-success btn-sm' type='button' onclick="showAddEditChequeForm(this.id);"><?php echo $this->lang->line('Add New Cheque') ?></a>
															<p>&nbsp;
															<!--showing table-->
															<div id="chequePaymentDataTable">
															</div>
															<!--end table -->
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
						<div class='modal-footer'>
							<button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button'><?php echo $this->lang->line('Close') ?></button>
						</div>
					</div>
				</div>
			</div>

			<div class='modal fade' id='modal-sales_note_cash_payments' tabindex='-1'>
				<div class='modal-dialog' style="height:550px;width:800px">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='modal_title'><?php echo $this->lang->line('Cash Payments') ?></h4>
						</div>

						<form enctype="text/plain" accept-charset="utf-8" name="formname" id="cash_payment_form"  method="post" action="">
							<div class='modal-body'>
								<div class='modal_msg_data'></div>
								<div id='table'>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='box' id="add_edit_cash_payment">
												<div class='box-header <?php echo BOXHEADER; ?>-background'>
													<div class='title'><?php echo $this->lang->line('Cash Details') ?></div>
													<div class='actions'>
														<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
														</a>
													</div>
												</div>
												<div class='box-content'>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
                                                            <input class='form-control' id='receive_payment_id' name='receive_payment_id' type='hidden'>
															<input class='form-control' id='cash_payment_id' name='cash_payment_id' type='hidden'>
															<input class='form-control' id='sales_note_id_in_cash_payment' name='sales_note_id_in_cash_payment' type='hidden'>
															<input class='form-control' id='sales_journal_entry_id_in_cash_payment' name='sales_journal_entry_id_in_cash_payment' type='hidden'>
															<input class='form-control' id='customer_id_in_cash_payment' name='customer_id_in_cash_payment' type='hidden'>
															<input class='form-control' id='location_id_in_cash_payment' name='location_id_in_cash_payment' type='hidden'>
															
															<label class='control-label col-sm-8'><?php echo $this->lang->line('Date') ?> *</label>
															<div class='col-sm-6 controls'>
																<div class='datepicker-input input-group' id='cash_payment_datepicker'>
																	<input class='form-control' id='cash_payment_date' name='cash_payment_date'
																		   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																	  <span class="input-group-addon">
																			<span class="glyphicon glyphicon-calendar"/>
																	  </span>
																</div>
																<div id="cash_payment_dateError" class="red"></div>
															</div>
														</div>
													</div>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-8'><?php echo $this->lang->line('Amount') ?> *</label>
															<div class='col-sm-6 controls'>
																<input class='form-control' id='cash_amount' name='cash_amount'
																	   placeholder='<?php echo $this->lang->line('Amount')?>' type='text'
																	   value="<?php echo set_value('cash_amount'); ?>">
																<div id="cash_amountError" class="red"></div>
															</div>
															<div class='col-sm-6 controls'>
																<label class='control-label col-sm-5'><?php echo $this->lang->line('Credit Balance') ?></label>
																<div class='col-sm-6 controls'>
																	<input class='form-control' id='cash_credit_balance' name='cash_credit_balance'
																		   type='text' disabled value="">
																</div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:100px">&nbsp;</p>
													<div class='form-actions' style='margin-bottom:0'>
														<div class='row'>
															<div class='col-sm-9 col-sm-offset-3'>
																<?php
																if (isset($ACM_Bookkeeping_Add_Sales_Note_Permissions)) {
																	?>
																	<button class='btn btn-success save' id="save_receive_cash_payment_data"
																			onclick='saveReceiveCashPaymentData();' type='button'>
																		<i class='icon-save'></i>
																		<?php echo $this->lang->line('Save') ?>
																	</button>
																	<?php
																}
																?>

																<button class='btn btn-primary' type='reset' onclick="clearCashPaymentForm();">
																	<i class='icon-undo'></i>
																	<?php echo $this->lang->line('Refresh') ?>
																</button>
																<button class='btn btn-warning cancel' onclick='cancelCashPaymentData();'
																		type='button'>
																	<i class='icon-ban-circle'></i>
																	<?php echo $this->lang->line('Close') ?>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div id='table'>
												<div class='row'>
													<div class='col-sm-12'>
														<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
															<a class='btn btn-success btn-sm' type='button' onclick="showAddEditCashPaymentForm(this.id);"><?php echo $this->lang->line('Add New Cash Payment') ?></a>
															<p>&nbsp;
															<!--showing table-->
															<div id="cashPaymentDataTable">
															</div>
															<!--end table -->
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
						<div class='modal-footer'>
							<button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button'><?php echo $this->lang->line('Close') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	var SalesNoteScreenOperationStatus = '';
	var SalesNoteIncomeChequeScreenOperationStatus = 'Add';
	var SalesNoteCashPaymentScreenOperationStatus = 'Add';
	
	var SalesNotePaymentDataSaved = false;
	var SalesNoteCancelled = false;
	
	$(document).ready(function () {
        
        $(".msg_instant").hide();
		
		$("#datepicker_sales_note_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$("#cheque_payment_datepicker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$("#cash_payment_datepicker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$("#datepicker_cheque_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});

		SalesNote.getCustomerData();
		SalesNote.getCustomerSearchData();
		SalesNote.getTerritoryData();
		SalesNote.getLocationData();
        SalesNote.getBankData();
		
		var date = new Date();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		
		var monthName = moment.months(month - 1);
		$("#month_name").text(monthName + "  " + year);
		$("#current_month").val(month);
		$("#current_year").val(year);
		
		getTableData(year, month, "", "");
		SalesNote.init();
	});

	$(".new").click(function () {
		clearForm();
		SalesNoteScreenOperationStatus = "Add";
		SalesNote.getNextReferenceNo();
		SalesNote.hideMessageDisplay();
		$("#sales_note_details_form").show();
		$("#add_sales_note_form").show();
		$(".save_form").show();
		$("#edit_sales_note_form").hide();
		$("#search_sales_note_form").hide();

	});
	
	function clearData() {
		clearForm();
	}
	
	function cancelSalesNote() {
		
		if (SalesNoteCancelled == false) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Cancelling the sales note...');
			SalesNote.cancelSalesNote();
            window.scrollTo(0,0);
		} else {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Activating the sales note...');
			SalesNote.activateSalesNote();
            window.scrollTo(0,0);
		}
	}

	function cancelData() {
		SalesNote.cancelData();
	}

	function closeSalesNoteEditForm() {
		SalesNote.closeSalesNoteEditForm();
		window.scrollTo(0,0);
	}

	function saveSalesNoteData() {
		if (validateSalesNoteForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			SalesNote.saveSalesNoteData();
			window.scrollTo(0,0);
		}
	}
	
	function saveSalesNotePaymentData() {
		if (validateSalesNotePaymentForm()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			SalesNote.saveSalesNotePaymentData();
			window.scrollTo(0,0);
		}
	}

	function editSalesNoteData(id) {
		if (validateSalesNoteForm_edit()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			SalesNote.editSalesNoteData(id);
			window.scrollTo(0,0);
		}
	}
	
	function editSalesNotePaymentData() {
		if (validateSalesNotePaymentForm()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			SalesNote.editSalesNotePaymentData();
			window.scrollTo(0,0);
		}
	}

	function getSalesNoteData(id){
		$(".loader").show();
		SalesNoteScreenOperationStatus = "View";
		SalesNote.hideMessageDisplay();
		SalesNote.getSalesNoteData(id);
		window.scrollTo(0,0);
	}

	function del(id){
		SalesNote.hideMessageDisplay();
		SalesNote.deleteData(id);
		window.scrollTo(0,0);
	}
	
	function addCashPayment() {
		
		var salesNoteId = '';
		if (SalesNoteScreenOperationStatus == "Add") {
			salesNoteId = $("#sales_note_id").val();
			$("#sales_note_id_in_cash_payment").val(salesNoteId);
			$("#sales_journal_entry_id_in_cash_payment").val($("#sales_journal_entry_id").val());
			$("#customer_id_in_cash_payment").val($("#customer_id").val());
			$("#location_id_in_cash_payment").val($("#location").val());
		} else if (SalesNoteScreenOperationStatus == "View") {
			salesNoteId = $("#sales_note_id_edit").val();
			$("#sales_note_id_in_cash_payment").val(salesNoteId);
			$("#sales_journal_entry_id_in_cash_payment").val($("#sales_journal_entry_id_edit").val());
			$("#customer_id_in_cash_payment").val($("#customer_id_edit").val());
			$("#location_id_in_cash_payment").val($("#location_edit").val());
		}
		
		SalesNote.getReceiveCashPaymentList(salesNoteId);
		openSalesNoteCashPaymentDialog();
	}
	
	function addChequePayment() {
		
		var salesNoteId = '';
		if (SalesNoteScreenOperationStatus == "Add") {
			salesNoteId = $("#sales_note_id").val();
			$("#sales_note_id_in_cheque_payment").val(salesNoteId);
			$("#sales_journal_entry_id_in_cheque_payment").val($("#sales_journal_entry_id").val());
			$("#customer_id_in_cheque_payment").val($("#customer_id").val());
			$("#location_id_in_cheque_payment").val($("#location").val());
		} else if (SalesNoteScreenOperationStatus == "View") {
			salesNoteId = $("#sales_note_id_edit").val();
			$("#sales_note_id_in_cheque_payment").val(salesNoteId);
			$("#sales_journal_entry_id_in_cheque_payment").val($("#sales_journal_entry_id_edit").val());
			$("#customer_id_in_cheque_payment").val($("#customer_id_edit").val());
			$("#location_id_in_cheque_payment").val($("#location_edit").val());
		}
		
		SalesNote.getIncomeChequeStatusDropDown();
		SalesNote.getReceiveChequePaymentList(salesNoteId);
		openSalesNoteChequePaymentDialog();
	}

	function loadPreviousMonthTransactionDetails() {
		var currentMonth = $("#current_month").val();
		var currentYear = $("#current_year").val();

		if (currentMonth != '1') {
			currentMonth = parseInt(currentMonth) - 1;
		} else {
			currentMonth = '12';
			currentYear = parseInt(currentYear) - 1;
		}
		
		$("#current_month").val(currentMonth);
		$("#current_year").val(currentYear);

		getTableData(currentYear, currentMonth, "", "");
	}

	function loadNextMonthTransactionDetails() {
		var currentMonth = $("#current_month").val();
		var currentYear = $("#current_year").val();

		if (currentMonth != '12') {
			currentMonth = parseInt(currentMonth) + 1;
		} else {
			currentMonth = '1';
			currentYear = parseInt(currentYear) + 1;
		}
		
		$("#current_month").val(currentMonth);
		$("#current_year").val(currentYear);

		getTableData(currentYear, currentMonth, "", "");
	}
	
	function handleSalesAmountAddition() {
		var amount = "";
		if (SalesNoteScreenOperationStatus == "Add") {
			amount = $("#sales_amount").val();
		} else if (SalesNoteScreenOperationStatus == "View") {
			amount = $("#sales_amount_edit").val();
		}
		
		if (amount != "") {
			var amountData = amount.split(".");
			var amountDataSize = amountData.length;

			if (amountDataSize == 1) {
				amount = amount + ".00";
				if (SalesNoteScreenOperationStatus == "Add") {
					$("#sales_amount").val(amount);
				} else if (SalesNoteScreenOperationStatus == "View") {
					$("#sales_amount_edit").val(amount);
				}
			}
		} else {
			amount = "0.00";
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#sales_amount").val("0.00");
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#sales_amount_edit").val("0.00");
			}
		}
			
		if (validateSalesAmount()) {
			
			var discount = "";
			var amountPayable = "";
			var customerSaleableReturnAmount = "";
			var customerMarketReturnAmount = "";
			var balancePayment = "";
			var cashPayment = "";
			var chequePayment = "";
            
            amount = parseFloat(amount);

			if (SalesNoteScreenOperationStatus == "Add") {
				discount = $("#discount").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount").val();
				customerMarketReturnAmount = $("#customer_market_return_amount").val();
				cashPayment = $("#cash_payment").val();
				chequePayment = $("#cheque_payment").val();
			} else if (SalesNoteScreenOperationStatus == "View") {
				discount = $("#discount_edit").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount_edit").val();
				customerMarketReturnAmount = $("#customer_market_return_amount_edit").val();
				cashPayment = $("#cash_payment_edit").val();
				chequePayment = $("#cheque_payment_edit").val();
			}

			if (amount != "") {
				if (validateDiscount() && validateCustomerSaleableReturnAmount() && validateCustomerMarketReturnAmount()) {
					if (discount != "") {
						amountPayable = amount - discount;
						if (SalesNoteScreenOperationStatus == "Add") {
							$("#sales_amount_payable").val(amountPayable.toFixed(2));
							$("#sales_amount_payable_on_payment").val(amountPayable.toFixed(2));
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#sales_amount_payable_edit").val(amountPayable.toFixed(2));
							$("#sales_amount_payable_on_payment_edit").val(amountPayable.toFixed(2));
						}
					} else {
						amountPayable = amount;
						balancePayment = amountPayable;
						if (SalesNoteScreenOperationStatus == "Add") {
							$("#sales_amount_payable").val(amount.toFixed(2));
							$("#sales_amount_payable_on_payment").val(amount.toFixed(2));
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#sales_amount_payable_edit").val(amount.toFixed(2));
							$("#sales_amount_payable_on_payment_edit").val(amount.toFixed(2));
						}
					}

					if (customerSaleableReturnAmount != '' && customerMarketReturnAmount != '') {
						balancePayment = amountPayable - customerSaleableReturnAmount;
						balancePayment = balancePayment - customerMarketReturnAmount;
					} else if (customerSaleableReturnAmount == '' && customerMarketReturnAmount != '') {
						balancePayment = amountPayable - customerMarketReturnAmount;
					} else if (customerSaleableReturnAmount != '' && customerMarketReturnAmount == '') {
						balancePayment = amountPayable - customerSaleableReturnAmount;
					} else {
						balancePayment = amountPayable;
					}

					if (cashPayment != '' && chequePayment != '') {
						balancePayment = balancePayment - cashPayment;
						balancePayment = balancePayment - chequePayment;
					} else if (cashPayment != '' && chequePayment == '') {
						balancePayment = balancePayment - cashPayment;
					} else if (cashPayment == '' && chequePayment != '') {
						balancePayment = balancePayment - chequePayment;
					}

					if (SalesNoteScreenOperationStatus == "Add") {
						$("#sales_balance_amount").val(balancePayment.toFixed(2));
                        $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
						$("#cash_credit_balance").val(balancePayment.toFixed(2));
						$("#cheque_credit_balance").val(balancePayment.toFixed(2));
					} else if (SalesNoteScreenOperationStatus == "View") {
                        $("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
						$("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
						$("#cash_credit_balance").val(balancePayment.toFixed(2));
						$("#cheque_credit_balance").val(balancePayment.toFixed(2));
					}
				} else {
					if (SalesNoteScreenOperationStatus == "Add") {
						$("#sales_balance_amount").val(balancePayment.toFixed(2));
                        $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
					} else if (SalesNoteScreenOperationStatus == "View") {
						$("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
						$("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
					}
				}
			}
		}
	}
	
	function handleDiscountAddition() {
		var discount = "";
		if (SalesNoteScreenOperationStatus == "Add") {
			discount = $("#discount").val();
		} else if (SalesNoteScreenOperationStatus == "View") {
			discount = $("#discount_edit").val();
		}
		
		if (discount != "") {
			var discountData = discount.split(".");
			var discountDataSize = discountData.length;

			if (discountDataSize == 1) {
				discount = discount + ".00";
				if (SalesNoteScreenOperationStatus == "Add") {
					$("#discount").val(discount);
				} else if (SalesNoteScreenOperationStatus == "View") {
					$("#discount_edit").val(discount);
				}
			}
		} else {
			discount = "0.00";
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#discount").val("0.00");
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#discount_edit").val("0.00");
			}
		}
			
		if (validateDiscount()) {
			var amount = "";
			var amountPayable = "";
			var customerSaleableReturnAmount = "";
			var customerMarketReturnAmount = "";
			var balancePayment = "";
			var cashPayment = "";
			var chequePayment = "";

			if (SalesNoteScreenOperationStatus == "Add") {
				amount = $("#sales_amount").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount").val();
				customerMarketReturnAmount = $("#customer_market_return_amount").val();
				cashPayment = $("#cash_payment").val();
				chequePayment = $("#cheque_payment").val();
			} else if (SalesNoteScreenOperationStatus == "View") {
				amount = $("#sales_amount_edit").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount_edit").val();
				customerMarketReturnAmount = $("#customer_market_return_amount_edit").val();
				cashPayment = $("#cash_payment_edit").val();
				chequePayment = $("#cheque_payment_edit").val();
			}

			if (discount != "") {
				
				if (amount != "") {
					if (validateSalesAmount() && validateCustomerSaleableReturnAmount() && validateCustomerMarketReturnAmount()) {
						amountPayable = amount - discount;
						
						if (SalesNoteScreenOperationStatus == "Add") {
							$("#sales_amount_payable").val(amountPayable.toFixed(2));
							$("#sales_amount_payable_on_payment").val(amountPayable.toFixed(2));
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#sales_amount_payable_edit").val(amountPayable.toFixed(2));
							$("#sales_amount_payable_on_payment_edit").val(amountPayable.toFixed(2));
						}

						if (customerSaleableReturnAmount != '' && customerMarketReturnAmount != '') {
							balancePayment = amountPayable - customerSaleableReturnAmount;
							balancePayment = balancePayment - customerMarketReturnAmount;
						} else if (customerSaleableReturnAmount == '' && customerMarketReturnAmount != '') {
							balancePayment = amountPayable - customerMarketReturnAmount;
						} else if (customerSaleableReturnAmount != '' && customerMarketReturnAmount == '') {
							balancePayment = amountPayable - customerSaleableReturnAmount;
						} else {
							balancePayment = amountPayable;
						}

						if (cashPayment != '' && chequePayment != '') {
							balancePayment = balancePayment - cashPayment;
							balancePayment = balancePayment - chequePayment;
						} else if (cashPayment != '' && chequePayment == '') {
							balancePayment = balancePayment - cashPayment;
						} else if (cashPayment == '' && chequePayment != '') {
							balancePayment = balancePayment - chequePayment;
						}

						if (SalesNoteScreenOperationStatus == "Add") {
							$("#sales_balance_amount").val(balancePayment.toFixed(2));
                            $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
							$("#cash_credit_balance").val(balancePayment.toFixed(2));
							$("#cheque_credit_balance").val(balancePayment.toFixed(2));
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
                            $("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
							$("#cash_credit_balance").val(balancePayment.toFixed(2));
							$("#cheque_credit_balance").val(balancePayment.toFixed(2));
						}
					}
				}
			}
		}
	}
	
	function handleFreeIssueAmountAddition() {
		var freeIssueAmount = "";
		if (SalesNoteScreenOperationStatus == "Add") {
			freeIssueAmount = $("#free_issue_amount").val();
		} else if (SalesNoteScreenOperationStatus == "View") {
			freeIssueAmount = $("#free_issue_amount_edit").val();
		}

		if (freeIssueAmount != "") {
			var freeIssueAmountData = freeIssueAmount.split(".");
			var freeIssueAmountDataSize = freeIssueAmountData.length;

			if (freeIssueAmountDataSize == 1) {
				freeIssueAmount = freeIssueAmount + ".00";
				if (SalesNoteScreenOperationStatus == "Add") {
					$("#free_issue_amount").val(freeIssueAmount);
				} else if (SalesNoteScreenOperationStatus == "View") {
					$("#free_issue_amount_edit").val(freeIssueAmount);
				}
			}
		} else {
			freeIssueAmount = "0.00";
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#free_issue_amount").val("0.00");
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#free_issue_amount_edit").val("0.00");
			}
		}
		
		validateFreeIssueAmount();
	}
	
	function handleCustomerReturnsAvailableSelect(id) {
		var amount = "0";
        var discount = "0";
		var amountPayable = "0";
		var balancePayment = "0";
		var cashPayment = "0";
		var chequePayment = "0";
		
		if ($("#" + id).prop("checked") == true) {
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#customer_return_details_div").show();
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#customer_return_details_div_edit").show();
			}
		} else {
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#customer_return_details_div").hide();
				
				amount = $("#sales_amount").val();
                discount = $("#discount").val();
				//amountPayable = $("#sales_amount_payable").val();
				cashPayment = $("#cash_payment").val();
				chequePayment = $("#cheque_payment").val();
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#customer_return_details_div_edit").hide();
				
				amount = $("#sales_amount_edit").val();
                discount = $("#discount_edit").val();
				//amountPayable = $("#sales_amount_payable_edit").val();
				cashPayment = $("#cash_payment_edit").val();
				chequePayment = $("#cheque_payment_edit").val();
			}
			
			if (amount != "") {
                cashPayment = cashPayment.replace(",", "");
                chequePayment = chequePayment.replace(",", "");
                
                amountPayable = amount - discount;
                
                if (cashPayment != '' && chequePayment != '') {
                    balancePayment = amountPayable - cashPayment;
                    balancePayment = balancePayment - chequePayment;
                } else if (cashPayment != '' && chequePayment == '') {
                    balancePayment = balancePayment - cashPayment;
                } else if (cashPayment == '' && chequePayment != '') {
                    balancePayment = balancePayment - chequePayment;
                }

                if (SalesNoteScreenOperationStatus == "Add") {
                    $("#sales_balance_amount").val(balancePayment.toFixed(2));
                    $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
                    $("#cash_credit_balance").val(balancePayment.toFixed(2));
                    $("#cheque_credit_balance").val(balancePayment.toFixed(2));
                } else if (SalesNoteScreenOperationStatus == "View") {
                    $("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
                    $("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
                    $("#cash_credit_balance").val(balancePayment.toFixed(2));
                    $("#cheque_credit_balance").val(balancePayment.toFixed(2));
                }
			}
			
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#customer_saleable_return_amount").val('');
				$("#customer_market_return_amount").val('');
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#customer_saleable_return_amount_edit").val('');
				$("#customer_market_return_amount_edit").val('');
			}
		}
	}
	
	function handleCustomerSaleableReturnAmountAddition(id) {
		var customerSaleableReturnAmount = "";
		if (SalesNoteScreenOperationStatus == "Add") {
			customerSaleableReturnAmount = $("#customer_saleable_return_amount").val();
		} else if (SalesNoteScreenOperationStatus == "View") {
			customerSaleableReturnAmount = $("#customer_saleable_return_amount_edit").val();
		}
		
		if (customerSaleableReturnAmount != "") {
			var customerSaleableReturnAmountData = customerSaleableReturnAmount.split(".");
			var customerSaleableReturnAmountDataSize = customerSaleableReturnAmountData.length;

			if (customerSaleableReturnAmountDataSize == 1) {
				customerSaleableReturnAmount = customerSaleableReturnAmount + ".00";
				if (SalesNoteScreenOperationStatus == "Add") {
					$("#customer_saleable_return_amount").val(customerSaleableReturnAmount);
				} else if (SalesNoteScreenOperationStatus == "View") {
					$("#customer_saleable_return_amount_edit").val(customerSaleableReturnAmount);
				}
			}
		} else {
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#customer_saleable_return_amount").val("0.00");
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#customer_saleable_return_amount_edit").val("0.00");
			}
		}
			
		if (validateCustomerSaleableReturnAmount()) {
			var amount = "";
			var amountPayable = "";
			var customerMarketReturnAmount = "";
			var balancePayment = "";
			var cashPayment = "";
			var chequePayment = "";

			if (SalesNoteScreenOperationStatus == "Add") {
				amount = $("#sales_amount").val();
				amountPayable = $("#sales_amount_payable").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount").val();
				customerMarketReturnAmount = $("#customer_market_return_amount").val();
				cashPayment = $("#cash_payment").val();
				chequePayment = $("#cheque_payment").val();
			} else if (SalesNoteScreenOperationStatus == "View") {
				amount = $("#sales_amount_edit").val();
				amountPayable = $("#sales_amount_payable_edit").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount_edit").val();
				customerMarketReturnAmount = $("#customer_market_return_amount_edit").val();
				cashPayment = $("#cash_payment_edit").val();
				chequePayment = $("#cheque_payment_edit").val();
			}
            
            amountPayable = amountPayable.replace(",", "");
            cashPayment = cashPayment.replace(",", "");
            chequePayment = chequePayment.replace(",", "");

			if (customerSaleableReturnAmount != "") {
				if (amount != "") {
					if (validateCustomerMarketReturnAmount()) {
						if (customerSaleableReturnAmount != '' && customerMarketReturnAmount != '') {
							balancePayment = amountPayable - customerSaleableReturnAmount;
							balancePayment = balancePayment - customerMarketReturnAmount;
						} else if (customerSaleableReturnAmount == '' && customerMarketReturnAmount != '') {
							balancePayment = amountPayable - customerMarketReturnAmount;
						} else if (customerSaleableReturnAmount != '' && customerMarketReturnAmount == '') {
							balancePayment = amountPayable - customerSaleableReturnAmount;
						} else {
							balancePayment = amountPayable;
						}

						if (cashPayment != '' && chequePayment != '') {
							balancePayment = balancePayment - cashPayment;
							balancePayment = balancePayment - chequePayment;
						} else if (cashPayment != '' && chequePayment == '') {
							balancePayment = balancePayment - cashPayment;
						} else if (cashPayment == '' && chequePayment != '') {
							balancePayment = balancePayment - chequePayment;
						}

						if (SalesNoteScreenOperationStatus == "Add") {
							$("#sales_balance_amount").val(balancePayment.toFixed(2));
                            $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
							$("#cash_credit_balance").val(balancePayment.toFixed(2));
							$("#cheque_credit_balance").val(balancePayment.toFixed(2));
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
                            $("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
							$("#cash_credit_balance").val(balancePayment.toFixed(2));
							$("#cheque_credit_balance").val(balancePayment.toFixed(2));
						}
					}
				}
			} else {
				if (validateCustomerMarketReturnAmount()) {
					if (customerMarketReturnAmount != '') {
						balancePayment = amountPayable - customerMarketReturnAmount;
					} else {
						balancePayment = amountPayable;
					}

					if (cashPayment != '' && chequePayment != '') {
						balancePayment = balancePayment - cashPayment;
						balancePayment = balancePayment - chequePayment;
					} else if (cashPayment != '' && chequePayment == '') {
						balancePayment = balancePayment - cashPayment;
					} else if (cashPayment == '' && chequePayment != '') {
						balancePayment = balancePayment - chequePayment;
					}

					if (SalesNoteScreenOperationStatus == "Add") {
						$("#sales_balance_amount").val(balancePayment.toFixed(2));
                        $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
						$("#cash_credit_balance").val(balancePayment.toFixed(2));
						$("#cheque_credit_balance").val(balancePayment.toFixed(2));
					} else if (SalesNoteScreenOperationStatus == "View") {
						$("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
                        $("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
						$("#cash_credit_balance").val(balancePayment.toFixed(2));
						$("#cheque_credit_balance").val(balancePayment.toFixed(2));
					}
				}
			}
		}
	}
	
	function handleCustomerMarketReturnAmountAddition(id) {
		var customerMarketReturnAmount = "";
		if (SalesNoteScreenOperationStatus == "Add") {
			customerMarketReturnAmount = $("#customer_market_return_amount").val();
		} else if (SalesNoteScreenOperationStatus == "View") {
			customerMarketReturnAmount = $("#customer_market_return_amount_edit").val();
		}
		
		if (customerMarketReturnAmount != "") {
			var customerMarketReturnAmountData = customerMarketReturnAmount.split(".");
			var customerMarketReturnAmountDataSize = customerMarketReturnAmountData.length;

			if (customerMarketReturnAmountDataSize == 1) {
				customerMarketReturnAmount = customerMarketReturnAmount + ".00";
				if (SalesNoteScreenOperationStatus == "Add") {
					$("#customer_market_return_amount").val(customerMarketReturnAmount);
				} else if (SalesNoteScreenOperationStatus == "View") {
					$("#customer_market_return_amount_edit").val(customerMarketReturnAmount);
				}
			}
		} else {
			if (SalesNoteScreenOperationStatus == "Add") {
				$("#customer_market_return_amount").val("0.00");
			} else if (SalesNoteScreenOperationStatus == "View") {
				$("#customer_market_return_amount_edit").val("0.00");
			}
		}
			
		if (validateCustomerMarketReturnAmount()) {
			var amount = "";
			var amountPayable = "";
			var customerSaleableReturnAmount = "";
			var balancePayment = "";
			var cashPayment = "";
			var chequePayment = "";

			if (SalesNoteScreenOperationStatus == "Add") {
				amount = $("#sales_amount").val();
				amountPayable = $("#sales_amount_payable").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount").val();
				customerMarketReturnAmount = $("#customer_market_return_amount").val();
				cashPayment = $("#cash_payment").val();
				chequePayment = $("#cheque_payment").val();
			} else if (SalesNoteScreenOperationStatus == "View") {
				amount = $("#sales_amount_edit").val();
				amountPayable = $("#sales_amount_payable_edit").val();
				customerSaleableReturnAmount = $("#customer_saleable_return_amount_edit").val();
				customerMarketReturnAmount = $("#customer_market_return_amount_edit").val();
				cashPayment = $("#cash_payment_edit").val();
				chequePayment = $("#cheque_payment_edit").val();
			}
            
            amountPayable = amountPayable.replace(",", "");
            cashPayment = cashPayment.replace(",", "");
            chequePayment = chequePayment.replace(",", "");

			if (customerMarketReturnAmount != "") {
				if (amount != "") {
					if (validateCustomerSaleableReturnAmount()) {
						if (customerSaleableReturnAmount != '' && customerMarketReturnAmount != '') {
							balancePayment = amountPayable - customerSaleableReturnAmount;
							balancePayment = balancePayment - customerMarketReturnAmount;
						} else if (customerSaleableReturnAmount == '' && customerMarketReturnAmount != '') {
							balancePayment = amountPayable - customerMarketReturnAmount;
						} else if (customerSaleableReturnAmount != '' && customerMarketReturnAmount == '') {
							balancePayment = amountPayable - customerSaleableReturnAmount;
						} else {
							balancePayment = amountPayable;
						}

						if (cashPayment != '' && chequePayment != '') {
							balancePayment = balancePayment - cashPayment;
							balancePayment = balancePayment - chequePayment;
						} else if (cashPayment != '' && chequePayment == '') {
							balancePayment = balancePayment - cashPayment;
						} else if (cashPayment == '' && chequePayment != '') {
							balancePayment = balancePayment - chequePayment;
						}

						if (SalesNoteScreenOperationStatus == "Add") {
							$("#sales_balance_amount").val(balancePayment.toFixed(2));
                            $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
							$("#cash_credit_balance").val(balancePayment.toFixed(2));
							$("#cheque_credit_balance").val(balancePayment.toFixed(2));
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
                            $("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
							$("#cash_credit_balance").val(balancePayment.toFixed(2));
							$("#cheque_credit_balance").val(balancePayment.toFixed(2));
						}
					}
				}
			} else {
				if (validateCustomerSaleableReturnAmount()) {
					if (customerSaleableReturnAmount != '') {
						balancePayment = amountPayable - customerSaleableReturnAmount;
					} else {
						balancePayment = amountPayable;
					}

					if (cashPayment != '' && chequePayment != '') {
						balancePayment = balancePayment - cashPayment;
						balancePayment = balancePayment - chequePayment;
					} else if (cashPayment != '' && chequePayment == '') {
						balancePayment = balancePayment - cashPayment;
					} else if (cashPayment == '' && chequePayment != '') {
						balancePayment = balancePayment - chequePayment;
					}

					if (SalesNoteScreenOperationStatus == "Add") {
						$("#sales_balance_amount").val(balancePayment.toFixed(2));
                        $("#sales_balance_amount_on_payment").val(balancePayment.toFixed(2));
						$("#cash_credit_balance").val(balancePayment.toFixed(2));
						$("#cheque_credit_balance").val(balancePayment.toFixed(2));
					} else if (SalesNoteScreenOperationStatus == "View") {
						$("#sales_balance_amount_edit").val(balancePayment.toFixed(2));
                        $("#sales_balance_amount_on_payment_edit").val(balancePayment.toFixed(2));
						$("#cash_credit_balance").val(balancePayment.toFixed(2));
						$("#cheque_credit_balance").val(balancePayment.toFixed(2));
					}
				}
			}
		}
	}
	
	function searchData() {
		var customerId = $("#customer_search_id").val();
		var territoryId = $("#territory_search_id").val();
		getTableData("", "", customerId, territoryId);
	}
	
	function showAddEditChequeForm() {
		SalesNote.hideMessageDisplay();
		SalesNoteIncomeChequeScreenOperationStatus = "Add";
		$("#cheque_id").val('');
		clearChequeForm();
		$("#add_edit_cheque").show();
	}

	function showAddEditCashPaymentForm() {
		SalesNote.hideMessageDisplay();
		SalesNoteCashPaymentScreenOperationStatus = "Add";
		$("#cash_payment_id").val('');
		clearCashPaymentForm();
		$("#add_edit_cash_payment").show();
	}

	function cancelChequePaymentData() {
		 SalesNote.hideMessageDisplay();
		$("#add_edit_cheque").hide();
	}

	function cancelCashPaymentData() {
		 SalesNote.hideMessageDisplay();
		$("#add_edit_cash_payment").hide();
	}

	function saveReceiveChequePaymentData() {

		var salesNoteId = '';
        var thirdPartyCheque = '';
        var crossedCheque = '';

		salesNoteId = $("#sales_note_id_in_cheque_payment").val();
		
		var chequeId = $("#cheque_id").val();
		var salesNoteJournalEntryId = $("#sales_journal_entry_id_in_cheque_payment").val();
		var customerId = $("#customer_id_in_cheque_payment").val();
		var locationId = $("#location_id_in_cheque_payment").val();
		var date = $("#cheque_payment_date").val();
		var chequeNumber = $("#cheque_number").val();
		var bank = $("#bank_id").val();
		var chequeDate = $("#cheque_date").val();
		var amount = $("#cheque_amount").val();
        var chequeDepositPrimeEntryBookId = $("#cheque_deposit_account_id").val();
        
        if ($("#third_party_cheque").prop("checked") == true) {
            thirdPartyCheque = "Yes";
        } else {
            thirdPartyCheque = "No";
        }
        
        if ($("#crossed_cheque").prop("checked") == true) {
            crossedCheque = "Yes";
        } else {
            crossedCheque = "No";
        }
		
		if (amount != "") {
			var chequeAmountData = amount.split(".");
			var chequeAmountDataSize = chequeAmountData.length;

			if (chequeAmountDataSize == 1) {
				amount = amount + ".00";
				$("#cheque_amount").val(amount);
			}
		} else {
			$("#cheque_amount").val("0.00");
		}

		if (validateForm_saveSalesInvoiceIncomeChequeData()) {
			SalesNote.saveReceiveChequePaymentData(salesNoteId, chequeId, salesNoteJournalEntryId, customerId, locationId, date, 
            chequeNumber, bank, chequeDate, thirdPartyCheque, amount, crossedCheque, chequeDepositPrimeEntryBookId);
		}
	}

	function saveReceiveCashPaymentData() {

		var salesNoteId = '';

		salesNoteId = $("#sales_note_id_in_cash_payment").val();
		
		var receiveCashPaymentId = $("#receive_payment_id").val();
        var cashPaymentId = $("#cash_payment_id").val();
		var salesNoteJournalEntryId = $("#sales_journal_entry_id_in_cash_payment").val();
		var customerId = $("#customer_id_in_cash_payment").val();
		var locationId = $("#location_id_in_cash_payment").val();
		var date = $("#cash_payment_date").val();
		var amount = $("#cash_amount").val();

		if (amount != "") {
			var cashAmountData = amount.split(".");
			var cashAmountDataSize = cashAmountData.length;

			if (cashAmountDataSize == 1) {
				amount = amount + ".00";
				$("#cash_amount").val(amount);
			}
		} else {
			$("#cash_amount").val("0.00");
		}

		if (validateForm_saveSalesInvoiceCashPaymentFormData() && $("#cash_amount").val() != "0.00") {
			SalesNote.saveReceiveCashPaymentData(salesNoteId, receiveCashPaymentId, cashPaymentId, salesNoteJournalEntryId, customerId, locationId, date, amount);
		}
	}

	function getReceiveChequePaymentData(chequeId) {
        var salesNoteId = '';

		if (SalesNoteScreenOperationStatus == "Add") {
			salesNoteId = $("#sales_note_id").val();
		} else {
			salesNoteId = $("#sales_note_id_edit").val();
		}
        
		SalesNoteIncomeChequeScreenOperationStatus = "View";

		SalesNote.getReceiveChequePaymentData(salesNoteId, chequeId);
	}

	function getCashPaymentData(cashPaymentId) {
        var salesNoteId = '';

		if (SalesNoteScreenOperationStatus == "Add") {
			salesNoteId = $("#sales_note_id").val();
		} else {
			salesNoteId = $("#sales_note_id_edit").val();
		}
        
		SalesNoteCashPaymentScreenOperationStatus = "View";
        SalesNote.hideMessageDisplay();
		SalesNote.getCashPaymentData(salesNoteId, cashPaymentId);
	}

	function deleteReceiveChequePayment(receiveChequePaymentId) {
		var salesNoteId = '';

		if (SalesNoteScreenOperationStatus == "Add") {
			salesNoteId = $("#sales_note_id").val();
		} else {
			salesNoteId = $("#sales_note_id_edit").val();
		}

		SalesNote.hideMessageDisplay();
		SalesNote.deleteReceiveChequePayment(salesNoteId, receiveChequePaymentId);
	}

	function deleteCashPayment(receiveCashPaymentId) {
		var salesNoteId = '';

		if (SalesNoteScreenOperationStatus == "Add") {
			salesNoteId = $("#sales_note_id").val();
		} else {
			salesNoteId = $("#sales_note_id_edit").val();
		}

		SalesNote.hideMessageDisplay();
		SalesNote.deleteCashPayment(salesNoteId, receiveCashPaymentId);
	}
	
	function handleCustomerSelection() {
		
	}
    
    function handleLocationSelect() {
        
    }
    
    function handCrossedChequeSelect(id) {
        if($("#" + id).prop("checked") == true) {
            $("#cheque_deposit_account_div").show();
        } else {
            $("#cheque_deposit_account_div").hide();
        }
        
        SalesNote.getChequeDepositAccountData();
    }
	
	var SalesNote = {
		
		cancelSalesNote : function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('sales_note_successfully_canceled')?>' +
				'</div>';
		
			var salesNoteId = '';
			if (SalesNoteScreenOperationStatus == "Add") {
				salesNoteId = $("#sales_note_id").val();
			} else if (SalesNoteScreenOperationStatus == "View") {
				salesNoteId = $("#sales_note_id_edit").val();
			}
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/cancelSalesNote",
				data: {
					'sales_note_id' : salesNoteId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					if (SalesNoteScreenOperationStatus == "Add") {
						$("#cancel_sales_note_button_on_sales_note_save").attr('disabled', true);
					} else if (SalesNoteScreenOperationStatus == "View") {
						$("#cancel_sales_note_button_on_sales_note_edit").attr('disabled', true);
					}
				},
				success:
				function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						SalesNoteCancelled = true;
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "");
						window.scrollTo(0,0);
						
						if (SalesNoteScreenOperationStatus == "Add") {
							
							$("#sales_note_save").attr('disabled', true);
							$("#sales_note_payment_save").attr('disabled', true);
							$("#add_cash_payment").attr('disabled', true);
							$("#add_cheque_payment").attr('disabled', true);
							
							$("#cancel_sales_note_button_on_sales_note_save").remove();
							$("#cancel_sales_note_button_on_sales_note_payment_save").remove();
							
							$("#refresh_button_on_sales_note_save").after('	<button id="cancel_sales_note_button_on_sales_note_save" class="btn btn-info" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-ok"></i> ' +
																	'<?php echo $this->lang->line('Activate Sales Note') ?>' +
																'</button>');
							$("#refresh_button_on_sales_note_payment_save").after('	<button id="cancel_sales_note_button_on_sales_note_payment_save" class="btn btn-info" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-ok"></i> ' +
																	'<?php echo $this->lang->line('Activate Sales Note') ?>' +
																'</button>');
						} else if (SalesNoteScreenOperationStatus == "View") {
							
							$("#edit_button_on_sales_note_edit").attr('disabled', true);
							$("#edit_button_on_sales_note_payment_edit").attr('disabled', true);
							$("#add_cash_payment_edit").attr('disabled', true);
							$("#add_cheque_payment_edit").attr('disabled', true);
							
							$("#cancel_sales_note_button_on_sales_note_edit").remove();
							$("#cancel_sales_note_button_on_sales_note_payment_edit").remove();
							
							$("#edit_button_on_sales_note_edit").after('	<button id="cancel_sales_note_button_on_sales_note_edit" class="btn btn-info" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-ok"></i> ' +
																	'<?php echo $this->lang->line('Activate Sales Note') ?>' +
																'</button>');
							$("#edit_button_on_sales_note_payment_edit").after('	<button id="cancel_sales_note_button_on_sales_note_payment_edit" class="btn btn-info" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-ok"></i> ' +
																	'<?php echo $this->lang->line('Activate Sales Note') ?>' +
																'</button>');
						}
					}
				}
			})
		},
		
		activateSalesNote : function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('sales_note_successfully_activated')?>' +
				'</div>';
		
			var salesNoteId = '';
			if (SalesNoteScreenOperationStatus == "Add") {
				salesNoteId = $("#sales_note_id").val();
			} else if (SalesNoteScreenOperationStatus == "View") {
				salesNoteId = $("#sales_note_id_edit").val();
			}
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/activateSalesNote",
				data: {
					'sales_note_id' : salesNoteId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					if (SalesNoteScreenOperationStatus == "Add") {
						$("#cancel_sales_note_button_on_sales_note_save").attr('disabled', true);
					} else if (SalesNoteScreenOperationStatus == "View") {
						$("#cancel_sales_note_button_on_sales_note_edit").attr('disabled', true);
					}
				},
				success:
				function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$("#sales_note_save").attr('disabled', false);
						SalesNoteCancelled = false;
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "");
						window.scrollTo(0,0);
						
						if (SalesNoteScreenOperationStatus == "Add") {
							
							$("#sales_note_save").attr('disabled', false);
							$("#sales_note_payment_save").attr('disabled', false);
							$("#add_cash_payment").attr('disabled', false);
							$("#add_cheque_payment").attr('disabled', false);
							
							$("#cancel_sales_note_button_on_sales_note_save").remove();
							$("#cancel_sales_note_button_on_sales_note_payment_save").remove();
							
							$("#refresh_button_on_sales_note_save").after('	<button id="cancel_sales_note_button_on_sales_note_save" class="btn btn-danger" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-off"></i> ' +
																	'<?php echo $this->lang->line('Cancel Sales Note') ?>' +
																'</button>');
							$("#refresh_button_on_sales_note_payment_save").after('	<button id="cancel_sales_note_button_on_sales_note_payment_save" class="btn btn-danger" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-off"></i> ' +
																	'<?php echo $this->lang->line('Cancel Sales Note') ?>' +
																'</button>');
						} else if (SalesNoteScreenOperationStatus == "View") {
							
							$("#edit_button_on_sales_note_edit").attr('disabled', false);
							$("#edit_button_on_sales_note_payment_edit").attr('disabled', false);
							$("#add_cash_payment_edit").attr('disabled', false);
							$("#add_cheque_payment_edit").attr('disabled', false);
						
							$("#cancel_sales_note_button_on_sales_note_edit").remove();
							$("#cancel_sales_note_button_on_sales_note_payment_edit").remove();
							
							$("#edit_button_on_sales_note_edit").after('	<button id="cancel_sales_note_button_on_sales_note_edit" class="btn btn-danger" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-off"></i> ' +
																	'<?php echo $this->lang->line('Cancel Sales Note') ?>' +
																'</button>');
							$("#edit_button_on_sales_note_payment_edit").after('	<button id="cancel_sales_note_button_on_sales_note_payment_edit" class="btn btn-danger" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
																	'<i class="icon-off"></i> ' +
																	'<?php echo $this->lang->line('Cancel Sales Note') ?>' +
																'</button>');
						}
					}
				}
			})
		},
		
		cancelData: function () {
			$("#sales_note_details_form").hide();
			$("#search_sales_note_form").show();
			SalesNote.hideMessageDisplay();
			clearForm();
		},

		closeSalesNoteEditForm: function () {
			$("#sales_note_details_form").hide();
			$("#search_sales_note_form").show();
			SalesNote.hideMessageDisplay();
		},

		getNextReferenceNo : function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getNextReferenceNo",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					if (response.status == 'auto_increment') {
						$("#reference_no").val(response.result);
					} else {
						$("#last_reference_no_label").remove();
						$("#reference_no_div").after(response.result);
					}
				}
			})
		},

		//Save Sales Note Data
		saveSalesNoteData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/add",
				data: {
					'reference_no' : $("#reference_no").val(),
					'sales_note_date' : $("#sales_note_date").val(),
					'customer_id' : $("#customer_id").val(),
					'territory_id' : $("#territory").val(),
					'location_id' : $("#location").val(),
					'sales_amount' : $("#sales_amount").val(),
					'discount' : $("#discount").val(),
					'free_issue_amount' : $("#free_issue_amount").val(),
					'amount_payable' : $("#sales_amount_payable").val(),
					'remark': $("#remark").val().trim(),
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$("#sales_note_save").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response.result == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$("#sales_note_save").attr('disabled', false);
						$("#sales_note_payment_save").attr('disabled', false);
						$("#cancel_sales_note_button_on_sales_note_save").attr('disabled', false);
						$("#cancel_sales_note_button_on_sales_note_payment_save").attr('disabled', false);
						$("#add_cash_payment").attr('disabled', false);
						$("#add_cheque_payment").attr('disabled', false);
						$("#sales_note_id").val(response.salesNoteId)
						$("#sales_journal_entry_id").val(response.salesJournalEntryId);
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "");
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},
		
		//Save Sales Note Payment Data
		saveSalesNotePaymentData: function () {
		
			$(".validation").hide();
			$(".msg_data").hide();
						
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var customerSaleableReturnAmount = '';
			var customerMarketReturnAmount = '';
			
			if ($("#customer_returns_available").prop("checked") == true) {
				customerSaleableReturnAmount = $("#customer_saleable_return_amount").val();
				customerMarketReturnAmount = $("#customer_market_return_amount").val();
			}
			
			var salesNotePaymentActionType = "";
			if (SalesNotePaymentDataSaved == false) {
				salesNotePaymentActionType = "addSalesNotePaymentData";
			} else {
				salesNotePaymentActionType = "editSalesNotePaymentData";
			}
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/" + salesNotePaymentActionType,
				data: {
					'sales_note_id' : $("#sales_note_id").val(),
					'sales_journal_entry_id' : $("#sales_journal_entry_id").val(),
					'sales_note_date' : $("#sales_note_date").val(),
					'customer_id' : $("#customer_id").val(),
					'territory_id' : $("#territory").val(),
					'location_id' : $("#location").val(),
					'customer_saleable_return_amount' : customerSaleableReturnAmount,
					'customer_market_return_amount' : customerMarketReturnAmount,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$("#sales_note_payment_save").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$("#sales_note_payment_save").attr('disabled', false);
						SalesNotePaymentDataSaved = true;
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$("#sales_note_payment_save").attr('disabled', false);
					}
				}
			})
		},

		editSalesNoteData: function (id) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_updated')?>' +
				'</div>';

			var msg_no_changes_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('no_changes_to_save')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/editSalesNoteData",
				data: {
					'id': id,
					'reference_no' : $("#reference_no_edit").val(),
					'sales_note_date' : $("#sales_note_date_edit").val(),
					'customer_id' : $("#customer_id_edit").val(),
					'territory_id' : $("#territory_edit").val(),
					'location_id' : $("#location_edit").val(),
					'sales_amount' : $("#sales_amount_edit").val(),
					'discount' : $("#discount_edit").val(),
					'free_issue_amount' : $("#free_issue_amount_edit").val(),
					'remark': $("#remark_edit").val().trim(),
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend :
				function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response.result == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "");
					} else if (response.result == 'no_changes_to_save') {
						$(".msg_data").show();
						$(".msg_data").html(msg_no_changes_to_save);
						$(".save:input").attr('disabled', false);
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},
		
		//Edit Sales Note Payment Data
		editSalesNotePaymentData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var customerReturnsAvailable = "No";
			var customerSaleableReturnAmount = '';
			var customerMarketReturnAmount = '';
			
			if ($("#customer_returns_available_edit").prop("checked") == true) {
				customerReturnsAvailable = "Yes";
				customerSaleableReturnAmount = $("#customer_saleable_return_amount_edit").val();
				customerMarketReturnAmount = $("#customer_market_return_amount_edit").val();
			}
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/editSalesNotePaymentData",
				data: {
					'sales_note_id' : $("#sales_note_id_edit").val(),
					'sales_journal_entry_id' : $("#sales_journal_entry_id_edit").val(),
					'sales_note_date' : $("#sales_note_date_edit").val(),
					'customer_id' : $("#customer_id_edit").val(),
					'territory_id' : $("#territory_edit").val(),
					'location_id' : $("#location_edit").val(),
					'customer_returns_available' : customerReturnsAvailable,
					'customer_saleable_return_amount' : customerSaleableReturnAmount,
					'customer_market_return_amount' : customerMarketReturnAmount,
					'amount_payable' : $("#sales_amount_payable_on_payment_edit").val(),
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},
		
		saveReceiveChequePaymentData: function (salesNoteId, chequeId, salesNoteJournalEntryId, customerId, locationId, date, 
            chequeNumber, bank, chequeDate, thirdPartyCheque, amount, crossedCheque, chequeDepositPrimeEntryBookId) {

			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			var msg_incorrect_prime_entry_book_selected_for_sales_invoice_transaction = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('incorrect_prime_entry_book_selected_for_sales_invoice_transaction')?>' +
				'</div>';
		
			var msg_no_changes_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('no_changes_to_save')?>' +
				'</div>';

			if (SalesNoteIncomeChequeScreenOperationStatus == "Add") {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/saveReceiveChequePaymentData",
					data: {
						'sales_note_id' : salesNoteId,
						'sales_note_journal_entry_id' : salesNoteJournalEntryId,
						'customer_id' : customerId,
						'location_id' : locationId,
						'date' : date,
						'cheque_number' : chequeNumber,
						'bank' : bank,
						'cheque_date' : chequeDate,
                        'third_party_cheque' : thirdPartyCheque,
						'amount' : amount,
                        'crossed_cheque' : crossedCheque,
                        'cheque_deposit_prime_entry_book_id' : chequeDepositPrimeEntryBookId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'json',
					success:
					function (response) {
						if (response.result == "ok") {
							if (SalesNoteScreenOperationStatus == "Add") {
								$("#cash_payment").val(response.cashPaymentAmount);
								$("#cheque_payment").val(response.chequePaymentAmount);
								$("#sales_balance_amount").val(response.balancePaymentAmount);
                                $("#sales_balance_amount_on_payment").val(response.balancePaymentAmount);
								$("#cash_credit_balance").val(response.balancePaymentAmount);
								$("#cheque_credit_balance").val(response.balancePaymentAmount);
							} else if (SalesNoteScreenOperationStatus == "View") {
								$("#cash_payment_edit").val(response.cashPaymentAmount);
								$("#cheque_payment_edit").val(response.chequePaymentAmount);
								$("#sales_balance_amount_edit").val(response.balancePaymentAmount);
                                $("#sales_balance_amount_on_payment_edit").val(response.balancePaymentAmount);
								$("#cash_credit_balance").val(response.balancePaymentAmount);
								$("#cheque_credit_balance").val(response.balancePaymentAmount);
							}
							
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg);
							SalesNote.getReceiveChequePaymentList(salesNoteId);
							clearChequeForm();
						} else if (response.result == 'incorrect_prime_entry_book_selected_for_sales_invoice_transaction') {
							$(".validation").hide();
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg_incorrect_prime_entry_book_selected_for_sales_invoice_transaction);
						}
					}
				})
			} else if (SalesNoteIncomeChequeScreenOperationStatus == "View") {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/editReceiveChequePaymentData",
					data: {
						'sales_note_id' : salesNoteId,
						'cheque_id' : chequeId,
						'customer_id' : customerId,
						'location_id' : locationId,
						'date' : date,
						'cheque_number' : chequeNumber,
						'bank' : bank,
						'cheque_date' : chequeDate,
                        'third_party_cheque' : thirdPartyCheque,
						'amount' : amount,
                        'crossed_cheque' : crossedCheque,
                        'cheque_deposit_prime_entry_book_id' : chequeDepositPrimeEntryBookId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'json',
					success:
					function (response) {
						if (response.result == "ok") {
							if (SalesNoteScreenOperationStatus == "Add") {
								$("#cash_payment").val(response.cashPaymentAmount);
								$("#cheque_payment").val(response.chequePaymentAmount);
								$("#sales_balance_amount").val(response.balancePaymentAmount);
                                $("#sales_balance_amount_on_payment").val(response.balancePaymentAmount);
								$("#cash_credit_balance").val(response.balancePaymentAmount);
								$("#cheque_credit_balance").val(response.balancePaymentAmount);
							} else if (SalesNoteScreenOperationStatus == "View") {
								$("#cash_payment_edit").val(response.cashPaymentAmount);
								$("#cheque_payment_edit").val(response.chequePaymentAmount);
								$("#sales_balance_amount_edit").val(response.balancePaymentAmount);
                                $("#sales_balance_amount_on_payment_edit").val(response.balancePaymentAmount);
								$("#cash_credit_balance").val(response.balancePaymentAmount);
								$("#cheque_credit_balance").val(response.balancePaymentAmount);
							}
							
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg);
							SalesNote.getReceiveChequePaymentList(salesNoteId);
							clearChequeForm();
						} else if (response.result == 'incorrect_prime_entry_book_selected_for_sales_invoice_transaction') {
							$(".validation").hide();
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg_incorrect_prime_entry_book_selected_for_sales_invoice_transaction);
						} else if (response.result == 'no_changes_to_save') {
							$(".validation").hide();
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg_no_changes_to_save);
						}
					}
				})
			}
		},
		
		saveReceiveCashPaymentData: function (salesNoteId, receiveCashPaymentId, cashPaymentId, salesNoteJournalEntryId, customerId, locationId, date, amount) {

			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			var msg_incorrect_prime_entry_book_selected_for_sales_invoice_transaction = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('incorrect_prime_entry_book_selected_for_sales_invoice_transaction')?>' +
				'</div>';

			var msg_no_changes_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('no_changes_to_save')?>' +
				'</div>';

			if (SalesNoteCashPaymentScreenOperationStatus == "Add") {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/saveReceiveCashPaymentData",
					data: {
						'sales_note_id' : salesNoteId,
						'sales_note_journal_entry_id' : salesNoteJournalEntryId,
						'customer_id' : customerId,
						'location_id' : locationId,
						'date' : date,
						'amount' : amount,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
                    beforeSend: function () {
                        $(".save").attr('disabled', true);
                    },
					dataType: 'json',
					success:
					function (response) {
						if (response.result == "ok") {
                            if (SalesNoteScreenOperationStatus == "Add" && SalesNoteCashPaymentScreenOperationStatus == "Add") {
                                $("#cash_payment").val(response.cashPaymentAmount);
                                $("#cheque_payment").val(response.chequePaymentAmount);
                                $("#sales_balance_amount").val(response.balancePaymentAmount);
                                $("#sales_balance_amount_on_payment").val(response.balancePaymentAmount);
                                $("#cash_credit_balance").val(response.balancePaymentAmount);
                                $("#cheque_credit_balance").val(response.balancePaymentAmount);
                            } else if (SalesNoteScreenOperationStatus == "View") {
                                $("#cash_payment_edit").val(response.cashPaymentAmount);
                                $("#cheque_payment_edit").val(response.chequePaymentAmount);
                                $("#sales_balance_amount_edit").val(response.balancePaymentAmount);
                                $("#sales_balance_amount_on_payment_edit").val(response.balancePaymentAmount);
                                $("#cash_credit_balance").val(response.balancePaymentAmount);
                                $("#cheque_credit_balance").val(response.balancePaymentAmount);
                            }

							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg);
							SalesNote.getReceiveCashPaymentList(salesNoteId);
							clearCashPaymentForm();
                            $("#add_edit_cash_payment").hide();
                            $(".save").attr('disabled', false);
						} else if (response.result == 'incorrect_prime_entry_book_selected_for_sales_invoice_transaction') {
							$(".validation").hide();
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg_incorrect_prime_entry_book_selected_for_sales_invoice_transaction);
                            $(".save").attr('disabled', false);
						}
					}
				})
			} else if (SalesNoteCashPaymentScreenOperationStatus == "View") {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/editReceiveCashPaymentData",
					data: {
                        'receive_payment_id' : receiveCashPaymentId,
                        'cash_payment_id' : cashPaymentId,
						'sales_note_id' : salesNoteId,
						'customer_id' : customerId,
						'location_id' : locationId,
						'date' : date,
						'amount' : amount,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
                    beforeSend: function () {
                        $(".save").attr('disabled', true);
                    },
					dataType: 'json',
					success:
					function (response) {
						if (response.result == "ok") {
                            $("#cash_payment_edit").val(response.cashPaymentAmount);
                            $("#cheque_payment_edit").val(response.chequePaymentAmount);
                            $("#sales_balance_amount_edit").val(response.balancePaymentAmount);
                            $("#sales_balance_amount_on_payment_edit").val(response.balancePaymentAmount);
                            $("#cash_credit_balance").val(response.balancePaymentAmount);
                            $("#cheque_credit_balance").val(response.balancePaymentAmount);
							
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg);
							SalesNote.getReceiveCashPaymentList(salesNoteId);
							clearCashPaymentForm();
                            $("#add_edit_cash_payment").hide();
                            $(".save").attr('disabled', false);
						} else if (response.result == 'incorrect_prime_entry_book_selected_for_sales_invoice_transaction') {
							$(".validation").hide();
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg_incorrect_prime_entry_book_selected_for_sales_invoice_transaction);
                            $(".save").attr('disabled', false);
						} else if (response.result == 'no_changes_to_save') {
							$(".validation").hide();
							$(".modal_msg_data").show();
							$(".modal_msg_data").html(msg_no_changes_to_save);
                            $(".save").attr('disabled', false);
						}
					}
				})
			}
		},

		deleteData: function (id) {

			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Sales Note') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/deleteSalesNote",
					data: {
						'id': id,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:
					function (response) {
                        $(".msg_instant").hide();
						$(".msg_delete").show();
						$(".msg_delete").html(response);
						$(".form").hide();
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "");
					}
				})
			}
		},

		deleteReceiveChequePayment: function (salesNoteId, receiveChequePaymentId) {

			var msg = ' <div class="alert alert-success alert-dismissable">' +
							'<a class="close" href="#" data-dismiss="alert">x </a>' +
							'<h4><i class="icon-ok-sign"></i>' + 
							'<?php echo $this->lang->line('success') ?></h4>' +
							'<?php echo $this->lang->line('success_deleted') ?>' +
						'</div>';

			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Cheque Payment') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/deleteReceiveChequePayment",
					data: {
						'sales_note_id' : salesNoteId,
						'cheque_id': receiveChequePaymentId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'json',
					success:
					function (response) {
						if (SalesNoteScreenOperationStatus == "Add") {
							$("#cash_payment").val(response.cashPaymentAmount);
							$("#cheque_payment").val(response.chequePaymentAmount);
							$("#credit_payment").val(response.creditPaymentAmount);
							$("#cash_credit_balance").val(response.creditPaymentAmount);
							$("#cheque_credit_balance").val(response.creditPaymentAmount);
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#cash_payment_edit").val(response.cashPaymentAmount);
							$("#cheque_payment_edit").val(response.chequePaymentAmount);
							$("#credit_payment_edit").val(response.creditPaymentAmount);
							$("#cash_credit_balance").val(response.creditPaymentAmount);
							$("#cheque_credit_balance").val(response.creditPaymentAmount);
						}

						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg);
						SalesNote.getReceiveChequePaymentList(salesNoteId);
					}
				})
			}
		},
		
		deleteCashPayment: function (salesNoteId, receiveCashPaymentId) {

			var msg = ' <div class="alert alert-success alert-dismissable">' +
							'<a class="close" href="#" data-dismiss="alert">x </a>' +
							'<h4><i class="icon-ok-sign"></i>' + 
							'<?php echo $this->lang->line('success') ?></h4>' +
							'<?php echo $this->lang->line('success_deleted') ?>' +
						'</div>';

			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Cash Payment') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/deleteCashPayment",
					data: {
						'sales_note_id' : salesNoteId,
						'cash_payment_id': receiveCashPaymentId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'json',
					success:
					function (response) {
						if (SalesNoteScreenOperationStatus == "Add" && SalesNoteCashPaymentScreenOperationStatus == "Add") {
							$("#cash_payment").val(response.cashPaymentAmount);
							$("#cheque_payment").val(response.chequePaymentAmount);
							$("#sales_balance_amount").val(response.balancePaymentAmount);
                            $("#sales_balance_amount_on_payment").val(response.balancePaymentAmount);
							$("#cash_credit_balance").val(response.balancePaymentAmount);
							$("#cheque_credit_balance").val(response.balancePaymentAmount);
						} else if (SalesNoteScreenOperationStatus == "View") {
							$("#cash_payment_edit").val(response.cashPaymentAmount);
							$("#cheque_payment_edit").val(response.chequePaymentAmount);
							$("#sales_balance_amount_edit").val(response.balancePaymentAmount);
                            $("#sales_balance_amount_on_payment_edit").val(response.balancePaymentAmount);
							$("#cash_credit_balance").val(response.balancePaymentAmount);
							$("#cheque_credit_balance").val(response.balancePaymentAmount);
						}

						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg);
						SalesNote.getReceiveCashPaymentList(salesNoteId);
					}
				})
			}
		},
		
		getSalesNoteData: function (id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getSalesNoteData",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					$("#sales_note_details_form").show();
					$("#search_sales_note_form").hide();
					$("#add_sales_note_form").hide();
					$("#edit_sales_note_form").show();
					$("#edit_sales_note_form_content").html(response.result);
					$("#cash_credit_balance").val(response.balancePayment);
					$("#cheque_credit_balance").val(response.balancePayment);
					$("#sales_note_edit_box_title").text('<?php echo $this->lang->line('Edit Sales Note') ?>');
					$(".loader").hide();
					$("#datepicker_sales_note_date_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					
					if (response.customerReturnAvailable == "No") {
						$("#customer_return_details_div_edit").hide();
					}
					
					$("#datepicker_cheque_date_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					
					if (response.salesNoteStatus == "cancelled") {
						SalesNoteCancelled = true;
						$("#add_cash_payment_edit").attr('disabled', true);
						$("#add_cheque_payment_edit").attr('disabled', true);
						$("#edit_button_on_sales_note_edit").attr('disabled', true);
						$("#edit_button_on_sales_note_payment_edit").attr('disabled', true);
					} else {
						SalesNoteCancelled = false;
					}
					
					$("#customer_id_edit").select2();
				}
			})
		},
		
		getReceiveChequePaymentList: function(salesNoteId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getReceiveChequePaymentList",
				data: {
					'sales_note_id': salesNoteId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$("#chequePaymentDataTable").empty();
					$("#chequePaymentDataTable").html(response);
					$(".chequePaymentTable").dataTable();
				}
			})
		},
		
		getReceiveCashPaymentList: function(salesNoteId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getReceiveCashPaymentList",
				data: {
					'sales_note_id': salesNoteId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$("#cashPaymentDataTable").empty();
					$("#cashPaymentDataTable").html(response);
					$(".cashPaymentTable").dataTable();
				}
			})
		},
		
		getReceiveChequePaymentData: function (salesNoteId, chequeId) {

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getReceiveChequePaymentData",
				data: {
                    'sales_note_id' : salesNoteId,
					'cheque_id' : chequeId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					if (response.result == "ok") {
						$("#add_edit_cheque").show();
						$("#cheque_id").val(chequeId);
						$("#cheque_payment_date").val(response.date);
						$("#cheque_number").val(response.chequeNumber);
						$("#bank_id").val(response.bank);
						$("#cheque_id").val(response.chequeId);
						$("#cheque_date").val(response.chequeDate);
                        
                        if (response.thirdPartyCheque == "Yes") {
                            $("#third_party_cheque").prop('checked', true);
                        } else {
                            $("#third_party_cheque").prop('checked', false);
                        }
                        
						$("#cheque_amount").val(response.amount);
                        
                        if (response.crossedCheque == "Yes") {
                            $("#crossed_cheque").prop('checked', true);
                            $("#cheque_deposit_account_div").show();
                        } else {
                            $("#crossed_cheque").prop('checked', false);
                            $("#cheque_deposit_account_div").hide();
                        }
                        
                        $("#cheque_deposit_account_id").val(response.chequeDepositPrimeEntryBookId);
                        
                        if (response.salesNoteStatus == "Claimed") {
                            $("#save_receive_cheque_payment_data").prop('disabled', true);
                        } else {
                            $("#save_receive_cheque_payment_data").prop('disabled', false);
                        }
					}
				}
			})
		},
		
		getCashPaymentData: function (salesNoteId, cashPaymentId) {

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getCashPaymentData",
				data: {
                    'sales_note_id' : salesNoteId,
					'cash_payment_id' : cashPaymentId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					if (response.result == "ok") {
						$("#add_edit_cash_payment").show();
                        $("#receive_payment_id").val(response.receiveCashPaymentId);
						$("#cash_payment_id").val(cashPaymentId);
						$("#cash_payment_date").val(response.date);
						$("#cash_amount").val(response.amount);
                        
                        if (response.salesNoteStatus == "Claimed") {
                            $("#save_receive_cash_payment_data").prop('disabled', true);
                        } else {
                            $("#save_receive_cash_payment_data").prop('disabled', false);
                        }
					}
				}
			})
		},
		
		//get customer drop down
		getCustomerData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getPeopleListAccordingToTheCategory",
				data: {
					'people_category' : "Customer",
					'type' : "Add",
					'mandatory_field' : 'No',
					'get_with_all_option' : '',
					'get_with_label' : 'No',
					'label_col_position' : "3",
					'drop_down_col_position' : "5",
					'show_people_code' : true,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$('#customer_init').hide();
					$("#customer_dropdown").html(response);
					$("#customer_dropdown").find("#people_id").prop({ id: "customer_id"});
					$("#customer_dropdown").find("#people_idError").prop({ id: "customer_idError"});
					$("#customer_id").select2();
				}
			})
		},
		
		//get customer search drop down
		getCustomerSearchData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToCustomersDropDownWithCustomerCode",
				data: {
                    'check_authority' : 'Yes',
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$('#customer_search_init').hide();
					$("#customer_search_dropdown").html(response);
					$("#customer_search_dropdown").find("#people_id").prop({ id: "customer_search_id"});
					$("#customer_search_id").select2();
				}
			})
		},
		
		//get territories drop down
		getTerritoryData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/territories_controller/getAllToTerritoriesDropDownWithoutLabel",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$('#teritory_init').hide();
					$("#teritory_dropdown").html(response);
					
					$('#teritory_search_init').hide();
					$("#teritory_search_dropdown").html(response);
					$("#teritory_search_dropdown").find("#territory").prop({ id: "territory_search_id"});
					$("#teritory_search_dropdown").find("#territoryError").prop({ id: "territory_search_idError"});
				}
			})
		},
		
		//get unit conversions drop down
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
					$('#location_init').hide();
					$("#location_dropdown").html(response);
				}
			})
		},
        
        //get bank drop down
		getBankData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller/getBanksDropdown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
                    $('#bank_init').hide();
                    $("#bank_dropdown").empty();
                    $("#bank_dropdown").html(response);
				}
			})
		},
        
        //get payment account drop down
		getChequeDepositAccountData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getChequeDepositAccountData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
                    $('#cheque_deposit_account_init').hide();
                    $("#cheque_deposit_account_dropdown").empty();
                    $("#cheque_deposit_account_dropdown").html(response.chequeDepositAccountList);
				}
			});
		},
        
        //get payment account drop down
		getChequeDepositAccountDataWithSalvedOption: function (chequeDepositAccountId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getChequeDepositAccountDataWithSavedOption",
				data: {
					'cheque_deposit_account_id' : chequeDepositAccountId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					$("#cheque_deposit_account_dropdown_edit").empty();
					$("#cheque_deposit_account_dropdown_edit").html(response.chequeDepositAccountList);
				}
			});
		},
		
		//get income cheque status drop down
		getIncomeChequeStatusDropDown: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getIncomeChequeStatusDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#cheque_status_init').hide();
						$("#cheque_status_dropdown").html(response);
					}
			})
		},

		init : function () {
			$("#table").show();
			$("#sales_note_details_form").hide();
			SalesNote.hideMessageDisplay();
			$("#remark").val('');
			$("#customer_returns_available").prop("checked", false);
			$("#customer_return_details_div").hide();
			$("#sales_note_payment_save").attr('disabled', true);
			$("#cancel_sales_note_button_on_sales_note_save").attr('disabled', true);
			$("#cancel_sales_note_button_on_sales_note_payment_save").attr('disabled', true);
			$("#add_cash_payment").attr('disabled', true);
			$("#add_cheque_payment").attr('disabled', true);
		},

		hideMessageDisplay : function () {
			$(".msg_data").hide();
			$(".modal_msg_data").hide();
			$(".msg_data_sales_note_search").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		}
	}

	//form validation save
	function validateSalesNoteForm_save() {
		return (isNotEmpty("reference_no", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("sales_note_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("location", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
			&& validateSalesAmount()
			&& validateDiscount()
			&& validateFreeIssueAmount()
		);
	}
	
	function validateSalesNotePaymentForm() {
		return (validateCustomerSaleableReturnAmount()
			&& validateCustomerMarketReturnAmount()
			&& validateChequePaymentData()
		);
	}

	//form validation edit
	function validateSalesNoteForm_edit() {
		return (isNotEmpty("reference_no_edit", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("sales_note_date_edit", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("location_edit", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
		);
	}
	
	function validateSalesAmount() {
		if (SalesNoteScreenOperationStatus == "Add") {
			return (isFlootPositive("sales_amount", "<?php echo $this->lang->line('Sales Amount').' '.$this->lang->line('is not valid')?>"));
		} else if (SalesNoteScreenOperationStatus == "View") {
			return (isFlootPositive("sales_amount_edit", "<?php echo $this->lang->line('Sales Amount').' '.$this->lang->line('is not valid')?>"));
		}
	}
	
	function validateDiscount() {
		if (SalesNoteScreenOperationStatus == "Add") {
			if ($("#discount").val() != '') {
				return (isFlootPositive("discount", "<?php echo $this->lang->line('Discount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		} else if (SalesNoteScreenOperationStatus == "View") {
			if ($("#discount_edit").val() != '') {
				return (isFlootPositive("discount_edit", "<?php echo $this->lang->line('Discount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		}
	}
	
	function validateFreeIssueAmount() {
		if (SalesNoteScreenOperationStatus == "Add") {
			if ($("#free_issue_amount").val() != '') {
				return (isFlootPositive("free_issue_amount", "<?php echo $this->lang->line('Free Issue Amount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		} else if (SalesNoteScreenOperationStatus == "View") {
			if ($("#free_issue_amount_edit").val() != '') {
				return (isFlootPositive("free_issue_amount_edit", "<?php echo $this->lang->line('Free Issue Amount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		}
	}
	
	function validateCustomerSaleableReturnAmount() {
		if (SalesNoteScreenOperationStatus == "Add") {
			if ($("#customer_saleable_return_amount").val() != '') {
				return (isFlootPositive("customer_saleable_return_amount", "<?php echo $this->lang->line('Customer Saleable Return Amount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		} else if (SalesNoteScreenOperationStatus == "View") {
			if ($("#customer_saleable_return_amount_edit").val() != '') {
				return (isFlootPositive("customer_saleable_return_amount_edit", "<?php echo $this->lang->line('Customer Saleable Return Amount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		}
	}
	
	function validateCustomerMarketReturnAmount() {
		if (SalesNoteScreenOperationStatus == "Add") {
			if ($("#customer_market_return_amount").val() != '') {
				return (isFlootPositive("customer_market_return_amount", "<?php echo $this->lang->line('Customer Market Return Amount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		} else if (SalesNoteScreenOperationStatus == "View") {
			if ($("#customer_market_return_amount_edit").val() != '') {
				return (isFlootPositive("customer_market_return_amount_edit", "<?php echo $this->lang->line('Customer Market Return Amount').' '.$this->lang->line('is not valid')?>"));
			} else {
				return true;
			}
		}
	}
	
	function validateChequePaymentData() {
		if (SalesNoteScreenOperationStatus == "Add") {
			if ($("#enable_cheque_payment").prop("checked") == true) {
				return (isNotEmpty("cheque_number", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
					   && isNotEmpty("bank", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
					   && isNotEmpty("cheque_date", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
					   && isNotEmpty("cheque_payment", "<?php echo $this->lang->line('Cheque Payment').' '.$this->lang->line('field is required')?>")
				);
			} else {
				return true;
			}
		} else if (SalesNoteScreenOperationStatus == "View") {
			if ($("#enable_cheque_payment").prop("checked") == true) {
				return (isNotEmpty("cheque_number_edit", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
					   && isNotEmpty("bank_edit", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
					   && isNotEmpty("cheque_date_edit", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
					   && isNotEmpty("cheque_payment_edit", "<?php echo $this->lang->line('Cheque Payment').' '.$this->lang->line('field is required')?>")
				);
			} else {
				return true;
			}
		}
	}
	
	//form validation edit 
	function validateForm_saveSalesInvoiceIncomeChequeData() {
		return (isNotEmpty("cheque_payment_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			 && isNotEmpty("cheque_number", "<?php echo $this->lang->line('cheque_number').' '.$this->lang->line('field is required')?>")
			 && isNotEmpty("bank_id", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			 && isNotEmpty("cheque_date", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			 && isFlootPositive("cheque_amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>"));
	}

	//form validation edit 
	function validateForm_saveSalesInvoiceCashPaymentFormData() {
		return (isNotEmpty("cash_payment_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			 && isFlootPositive("cash_amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>"));
	}

	//get all data
	function getTableData(year, month, customerId, territoryId){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
				'customer_id' : customerId,
				'territory_id' : territoryId,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'json',
				success:
			function (response) {
				$("#dataTable").html(response.html);
				$(".loader").hide();
				
				if (response.hideMonthFilter == false) {
					var monthName = moment.months(month - 1);
					$("#month_name").text(monthName + "  " + year);
				} else {
					$("#month_selector").hide();
				}
				
				$('.salesNoteDataTable').dataTable({
					"aaSorting": [[ 1, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		})
	}

	function clearForm(){
		$("#reference_no").val('');
		SalesNote.getNextReferenceNo();
		SalesNoteCancelled = false;
		$("#sales_note_date").val(moment().format('YYYY-MM-DD'));
		$("#customer_id").val('0').trigger('change');
		$("#location").val('0');
		$("#territory").val('0');
		$("#sales_amount").val('');
		$("#discount").val('');
		$("#free_issue_amount").val('');
		$("#remark").val('');
		$("#sales_amount_payable").val('');
		$("#sales_amount_payable_on_payment").val('');
		$("#credit_payment").val('');
		$("#customer_saleable_return_amount").val('');
		$("#customer_market_return_amount").val('');
		$("#cash_payment").val('');
		$("#cheque_number").val('');
		$("#bank").val('');
		$("#cheque_date").val(moment().format('YYYY-MM-DD'));
		$("#cheque_payment").val('');
		$("#customer_returns_available").prop("checked", false);
		$("#customer_return_details_div").hide();
		$("#sales_note_save").attr('disabled', false);
		$("#sales_note_payment_save").attr('disabled', true);
		$("#add_cash_payment").attr('disabled', true);
		$("#add_cheque_payment").attr('disabled', true);
		$("#cancel_sales_note_button_on_sales_note_save").remove();
		$("#cancel_sales_note_button_on_sales_note_payment_save").remove();

		$("#refresh_button_on_sales_note_save").after('	<button id="cancel_sales_note_button_on_sales_note_save" class="btn btn-danger" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
												'<i class="icon-off"></i> ' +
												'<?php echo $this->lang->line('Cancel Sales Note') ?>' +
											'</button>');
		$("#refresh_button_on_sales_note_payment_save").after('	<button id="cancel_sales_note_button_on_sales_note_payment_save" class="btn btn-danger" type="button" id="cancel_sales_note_on_sales_note_payment_save" onclick="cancelSalesNote();">' +
												'<i class="icon-off"></i> ' +
												'<?php echo $this->lang->line('Cancel Sales Note') ?>' +
											'</button>');
		$("#cancel_sales_note_button_on_sales_note_save").attr('disabled', true);
		$("#cancel_sales_note_button_on_sales_note_payment_save").attr('disabled', true);
	}
	
	function openSalesNoteChequePaymentDialog() {
		$(".validation").hide();
		$(".msg_data").hide();
        $(".modal_msg_data").hide();
		$("#modal-sales_note_cheques").modal('show');
		$("#add_edit_cheque").hide();
	}

	function closeSalesNoteChequePaymentDialog() {
		$("#modal-sales_note_cheques").modal('hide');
	}

	function openSalesNoteCashPaymentDialog() {
		$(".validation").hide();
		$(".msg_data").hide();
        $(".modal_msg_data").hide();
		$("#modal-sales_note_cash_payments").modal('show');
		$("#add_edit_cash_payment").hide();
	}

	function closeSalesNoteChequePaymentDialog() {
		$("#modal-sales_note_cash_payments").modal('hide');
	}
	
	function clearChequeForm() {
		$("#cheque_number").val('');
		$("#bank_id").val('0');
		$("#cheque_date").val(moment().format('YYYY-MM-DD'));
        $("#third_party_cheque").prop('checked', false);
		$("#cheque_amount").val('');
		$("#cheque_status_id").val('In Hand');
        $("#crossed_cheque").prop('checked', false);
        $("#cheque_deposit_account_div").hide();
	}

	function clearCashPaymentForm() {
		$("#cash_payment_date").val(moment().format('YYYY-MM-DD'));
		$("#cash_amount").val('');
	}
</script>

<style>
	.yellow_color {
		background-color: yellow !important;
	}
    
    .green_color {
		background-color: #66ff33 !important;			
	}
	
	.default_color {
		background-color: white !important;
	}
</style>
