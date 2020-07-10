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
								<span><?php echo $this->lang->line('Receive Payment') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
				<div class="msg_delete"></div>
                <div class='msg_instant' align="center"></div>
				<div class='form' id="receive_payment_details_form">
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-content'>
									<div class='validation'></div>
									<div class='box' id="add_receive_payment_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div class='title'><?php echo $this->lang->line('Add Receive Payment') ?></div>
											<div class='actions'>
												<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
												</a>
											</div>
										</div>
										<div class='box-content'>
											<form class='form form-horizontal validate-form save_form' method="post">
												<input class='form-control' id='receive_payment_id' name='receive_payment_id' type='hidden'>
												
												<div class='form-group'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference No') ?> *</label>
													<div class='col-sm-4 controls' id="reference_no_div">
														<input class='form-control' id='reference_no' name='reference_no'
															   placeholder='<?php echo $this->lang->line('Reference No') ?>' type='text' 
															   value="<?php echo set_value('reference_no'); ?>"
															   <?php if ($receive_payment_no_auto_increment_status) { echo 'readonly';}?>>
														<div id="reference_noError" class="red"></div>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Date') ?> *</label>
													<div class='col-sm-4 controls'>
														<div class='datepicker-input input-group' id='datepicker_receive_payment_date'>
															<input class='form-control' id='receive_payment_date' name='receive_payment_date'
																   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
															  <span class="input-group-addon">
																	<span class="glyphicon glyphicon-calendar"/>
															  </span>
														</div>
														<div id="receive_payment_dateError" class="red"></div>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Payer Type') ?> *</label>
													<div class='col-sm-4 controls' id="payer_type_div">
														<select class='form-control' name='payer_type' id='payer_type' onchange="getPeopleType(this.id);">
															<option value=''><?php echo $this->lang->line('-- Select --');?></option>
															<?php
															foreach($peopleType as $row){
																?>
																<option value='<?php echo $row['people_type'];?>'><?php echo $row['people_type'];?></option>
															<?php
															}
															?>
														</select>
														<div id="payer_typeError" class="red"></div>
													</div>
												</div>
                                                <div class='form-group' id='payer_list_div'>
                                                    
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
												<div id="reference_transaction_section_div">
													<div class='form-group' id="reference_transaction_type_div">
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Transaction Type') ?> *</label>
														<div class='col-sm-4 controls'>
															<select id="reference_transaction_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
															<!--Reference transaction type drop down-->
															<div id="reference_transaction_type_dropdown">
															</div>
															<!--End Reference transaction type drop down-->
															<div id="reference_transaction_type_idError" class="red"></div>
														</div>
													</div>
													<div class='form-group' id="reference_transaction_div">
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Transaction') ?> *</label>
														<div class='col-sm-4 controls'>
															<select id="reference_transaction_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
															<!--Reference transaction drop down-->
															<div id="reference_transaction_dropdown">
															</div>
															<!--End Reference transaction drop down-->
															<div id="reference_transaction_idError" class="red"></div>
														</div>
													</div>
													<div class='form-group' id="reference_journal_entry_div">
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Journal Entry') ?> *</label>
														<div class='col-sm-4 controls'>
															<select id="reference_journal_entry_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
															<!--Reference journal entry drop down-->
															<div id="reference_journal_entry_dropdown">
															</div>
															<!--End reference journal entry drop down-->
															<div id="reference_journal_entry_idError" class="red"></div>
														</div>
                                                        <div class='col-sm-1 controls'>
															<button class='btn btn-success' type='button' id="add_reference_transaction" onclick="addReferenceTransaction();">
																<i class='icon-save'></i>
																<?php echo $this->lang->line('Add') ?>
															</button>
														</div>
													</div>
												</div>
                                                
												<div id="receive_payment_reference_list">
													<h4><?php echo $this->lang->line('Reference Transactions') ?></h4>
													<div class='box-content box-no-padding out-table'>
														<div class='table-responsive table_data'>
															<div class='scrollable-area1'>
																<table class='table table-striped table-bordered receivePaymentReferenceDataTable' style='margin-bottom:0;'>
																	<thead>
																		<tr>
																			<th><?php echo $this->lang->line('Reference Transaction') ?></th>
																			<th><?php echo $this->lang->line('Reference Journal Entry') ?></th>
																			<th><?php echo $this->lang->line('Transaction Amount') ?></th>
																			<th><?php echo $this->lang->line('Actions') ?></th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr id="receive_payment_reference_amount_total">		
																			<td><?php echo $this->lang->line('Total') ?></td>
																			<td></td>
																			<td id="reference_amount_total"></td>
																			<td></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div><br>
												</div>
												
												<div class='box' id="receive_payment_method_list">
													<div class='box-content'>
														<div class='form-group'>
															<div class='col-sm-12 controls' style="text-align:center;">
																<label class='control-label col-sm-5'><?php echo $this->lang->line('Amount to Add for Payment Type') ?></label>
																<div class='col-sm-4 controls'>
																	<input class='form-control input-sm' id='amount_to_add_payment_type' name='amount_to_add_payment_type' type='text' disabled>
																	<div id="amount_to_add_payment_typeError" class="red"></div>
																</div>
															</div>
														</div>
														<div class='tabbable' style='margin-top: 20px'>
															<ul class='nav nav-responsive nav-tabs'>
																<li class='active'>
																	<a data-toggle='tab' class="tab-header" href='#cash_payment'><?php echo $this->lang->line('Cash Payment') ?></a>
																</li>
																<li class=''>
																	<a data-toggle='tab' class="tab-header" href='#cheque_payment'><?php echo $this->lang->line('Cheque Payment') ?></a>
																</li>
																<li class=''>
																	<a data-toggle='tab' class="tab-header" href='#credit_card_payment'><?php echo $this->lang->line('Credit Card Payment') ?></a>
																</li>
															</ul>
															<div class='tab-content'>
																<div id="cash_payment" class="tab-pane active">
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Cash Payment') ?> *</label>
																			<div class='col-sm-4 controls'>
																				<input class='form-control input-sm' id='cash_payment_amount' name='cash_payment_amount' placeholder='<?php echo $this->lang->line('Cash Payment')?>' type='text'>
																				<div id="cash_payment_amountError" class="red"></div>
																			</div>
																		</div>
																		<br><br>
																		<div class='form-group'>
																			<div class='col-sm-9 col-sm-offset-3'>
																				<button class='btn btn-success save'
																						onclick='addCashPayment();' type='button'>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Add') ?>
																				</button>
																			</div>
																		</div>
																	</div>
																</div>
																<div id="cheque_payment" class="tab-pane">
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Cheque Number') ?> *</label>
																		<div class='col-sm-4 controls' id="cheque_number_div">
																			<input class='form-control' id='cheque_number' name='cheque_number'
																				   placeholder='<?php echo $this->lang->line('Cheque Number') ?>' type='text' 
																				   value="<?php echo set_value('cheque_number'); ?>">
																			<div id="cheque_numberError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Bank') ?> *</label>
																		<div class='col-sm-4 controls'>
																			<select id="bank_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																			<!--Bank drop down-->
																			<div id="bank_dropdown">
																			</div>
																			<!--End bank drop down-->
																			<div id="bank_idError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Cheque Date') ?> *</label>
																		<div class='col-sm-4 controls' id="cheque_date_div">
																			<div class='datepicker-input input-group' id='datepicker_cheque_date'>
																				<input class='form-control' id='cheque_date' name='cheque_date'
																					   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Cheque Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																				  <span class="input-group-addon">
																						<span class="glyphicon glyphicon-calendar"/>
																				  </span>
																			</div>
																			<div id="cheque_dateError" class="red"></div>
																		</div>
                                                                        <div class='col-sm-2 controls'>
                                                                            <input type='checkbox' name='third_party_cheque' id='third_party_cheque' style='vertical-align: text-bottom;'>
                                                                            <label for='third_party_cheque'><?php echo $this->lang->line('Third Party Cheque') ?></label>
                                                                        </div>
                                                                        <div class='col-sm-2 controls'>
                                                                            <input type='checkbox' name='crossed_cheque' id='crossed_cheque' style='vertical-align: text-bottom;' onchange="handCrossedChequeSelect(this.id)">
                                                                            <label for='crossed_cheque'><?php echo $this->lang->line('Crossed Cheque') ?></label>
                                                                        </div>
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount') ?> *</label>
																		<div class='col-sm-4 controls'>
																			<input class='form-control input-sm' id='cheque_payment_amount' name='cheque_payment_amount' placeholder='<?php echo $this->lang->line('Amount')?>' type='text'>
																			<div id="cheque_payment_amountError" class="red"></div>
																		</div>
																	</div>
                                                                    <div class='form-group' id="cheque_deposit_account_div">
                                                                        <label class='control-label col-sm-3'><?php echo $this->lang->line('Cheque Deposit Account') ?></label>
                                                                        <div class='col-sm-4 controls'>
                                                                            <select id="cheque_deposit_account_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                            <!--Cheque deposit account drop down-->
                                                                            <div id="cheque_deposit_account_dropdown">
                                                                            </div>
                                                                            <!--End cheque deposit account drop down-->
                                                                            <div id="cheque_deposit_account_idError" class="red"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-9 col-sm-offset-4'>
                                                                            <button class='btn btn-success save'
                                                                                    onclick='addChequePayment();' type='button'>
                                                                                <i class='icon-save'></i>
                                                                                <?php echo $this->lang->line('Add') ?>
                                                                            </button>
                                                                        </div>
                                                                    </div>
																</div>
																<div id="credit_card_payment" class="tab-pane">
                                                                    <div class='form-group'>
                                                                        <label class='control-label col-sm-3'><?php echo $this->lang->line("Payment Account") ?> *</label>
                                                                        <div class='col-sm-4 controls'>
                                                                            <select id="payment_account_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																			<!--Payment account drop down-->
																			<div id="payment_account_dropdown">
																			</div>
																			<!--End payment account drop down-->
																			<div id="payment_account_idError" class="red"></div>
                                                                        </div>
                                                                    </div>
																	<div class='form-group'>
                                                                        <label class='control-label col-sm-3'><?php echo $this->lang->line("Card Type") ?></label>
                                                                        <div class='col-sm-4 controls'>
                                                                            <select id='credit_card_type_init' class='form-control'>
                                                                                <option value=''><?php echo $this->lang->line('-- Select --') ?></option>
                                                                                <option value='Visa'><?php echo $this->lang->line('Visa') ?></option>
                                                                                <option value='Master'><?php echo $this->lang->line('Master') ?></option>
                                                                            </select>
                                                                            <div id='credit_card_type_idError' class='red'></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label class='control-label col-sm-3'><?php echo $this->lang->line("Card Payment") ?> *</label>
                                                                        <div class='col-sm-4 controls'>
                                                                            <input class='form-control pos-screen-two-text-field' id='credit_card_payment_amount' name='credit_card_payment_amount' placeholder='<?php echo $this->lang->line('Card Payment') ?>' type='text' value=''>
                                                                            <div id='credit_card_payment_amountError' class='red'></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-3 controls'></div>
                                                                        <div class='col-sm-4 controls'>
                                                                            <input type='checkbox' name='include_bank_charge' id='include_bank_charge' style='vertical-align: text-bottom;' onchange='handleIncludeBankChargeSelect(this.id);'>
                                                                            <label for='include_bank_charge'><?php echo $this->lang->line('Include Bank Charge') ?></label>
                                                                        </div>
                                                                    </div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line("Total Card Payment") ?></label>
                                                                        <div class='col-sm-4 controls'>
                                                                            <input class='form-control pos-screen-two-text-field' id='total_card_payment' name='total_card_payment' placeholder='<?php echo $this->lang->line('Total Card Payment') ?>' type='text' disabled value=''>
                                                                            <div id='total_card_paymentError' class='red'></div>
                                                                        </div>
																		<br><br>
																		<div class='form-group'>
																			<div class='col-sm-9 col-sm-offset-4'>
																				<button class='btn btn-success save'
																						onclick='addCreditCardPayment();' type='button'>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Add') ?>
																				</button>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<div id="receive_payment_method_records">
													<h4><?php echo $this->lang->line('Payment Method List') ?></h4>
													<div class='box-content box-no-padding out-table'>
														<div class='table-responsive table_data'>
															<div class='scrollable-area1'>
																<table class='table table-striped table-bordered receivePaymentMethodDataTable' style='margin-bottom:0;'>
																	<thead>
																		<tr>
																			<th><?php echo $this->lang->line('Payment Method') ?></th>
																			<th><?php echo $this->lang->line('Cheque Number') ?></th>
																			<th><?php echo $this->lang->line('Bank') ?></th>
																			<th><?php echo $this->lang->line('Cheque Date') ?></th>
                                                                            <th><?php echo $this->lang->line('Card Type') ?></th>
																			<th><?php echo $this->lang->line('Amount') ?></th>
																			<th><?php echo $this->lang->line('Actions') ?></th>
																		</tr>
																	</thead>
																	<tbody id="receive_payment_method_record_rows">
																		<tr id="receive_payment_method_amount_total">		
																			<td><?php echo $this->lang->line('Total') ?></td>
																			<td></td>
																			<td></td>
																			<td></td>
                                                                            <td></td>
																			<td id="payment_method_amount_total"></td>
																			<td></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div><br>
												</div>
                                                
												<div class='form-group'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount') ?> *</label>
													<div class='col-sm-4 controls' id="amount_div">
														<input class='form-control' id='amount' name='amount'
															   placeholder='<?php echo $this->lang->line('Amount') ?>' type='text' 
															   value="<?php echo set_value('amount'); ?>" onblur="handleAmountAddition();">
														<div id="amountError" class="red"></div>
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
															if (isset($ACM_Bookkeeping_Add_Receive_Payment_Permissions)){
																?>
																<button class='btn btn-success save'
																		onclick='saveData();' type='button' id="receive_payment_save_button">
																	<i class='icon-save'></i>
																	<?php echo $this->lang->line('Save') ?>
																</button>
																<?php
															}
															?>
															<button class='btn btn-primary' type='reset'>
																<i class='icon-undo'></i>
																<?php echo $this->lang->line('Refresh') ?>
															</button>
															<button class='btn btn-warning cancel' onclick='cancelData();'
																	type='button'>
																<i class='icon-ban-circle'></i>
																<?php echo $this->lang->line('Close') ?>
															</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
									<!--edit form-->
									<div class='box' id="edit_receive_payment_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div id ="receive_payment_edit_box_title" class='title'><?php echo $this->lang->line('Edit Receive Payment') ?></div>
											<div class='actions'>
												<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
												</a>
											</div>
										</div>
										<div class='box-content' id="edit_receive_payment_form_content">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Product search form -->
				<div class='msg_data_receive_payment_search'></div>
				<form class='form form-horizontal validate-form' id="search_receive_payment_form">
					<div class='box'>
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Search Receive Payments') ?></div>
						</div>
						<div class='box-content'>
							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<label class='control-label col-sm-2 col-sm-1' ><?php echo $this->lang->line('Payer') ?></label>
									<label class='control-label col-sm-2 col-sm-4' ><?php echo $this->lang->line('Location') ?></label>
								</div>
							</div>
							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<div class='col-sm-4 controls'>
										<select id="payer_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="payer_search_dropdown"></div>
										<div id="payer_search_idError" class="red"></div>
									</div>
									<div class='col-sm-4 controls'>
										<select id="location_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="location_search_dropdown"></div>
										<div id="location_search_idError" class="red"></div>
									</div>
								</div>
								<p style="margin-bottom:-10px">&nbsp;</p>
							</div>
                            <div class='form-group'>
								<div class='col-sm-12 controls'>
									<label class='control-label col-sm-2' ><?php echo $this->lang->line('Purchase Note') ?></label>
									<label class='control-label col-sm-2' ><?php echo $this->lang->line('Sales Note') ?></label>
                                    <label class='control-label col-sm-2' ><?php echo $this->lang->line('Customer Return Note') ?></label>
                                    <label class='control-label col-sm-2' ><?php echo $this->lang->line('Supplier Return Note') ?></label>
								</div>
							</div>
                            <div class='form-group'>
								<div class='col-sm-12 controls'>
									<div class='col-sm-2 controls'>
										<select id="purchase_note_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="purchase_note_dropdown"></div>
										<div id="purchase_note_idError" class="red"></div>
									</div>
									<div class='col-sm-2 controls'>
										<select id="sales_note_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="sales_note_dropdown"></div>
										<div id="sales_note_idError" class="red"></div>
									</div>
                                    <div class='col-sm-2 controls'>
										<select id="customer_return_note_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="customer_return_note_dropdown"></div>
										<div id="customer_return_note_idError" class="red"></div>
									</div>
									<div class='col-sm-2 controls'>
										<select id="supplier_return_note_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="supplier_return_note_dropdown"></div>
										<div id="supplier_return_note_idError" class="red"></div>
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
								if (isset($ACM_Bookkeeping_Add_Receive_Payment_Permissions)){
									echo "<a class='btn btn-success btn-sm new'>{$this->lang->line('Add New Receive Payment') }</a>";
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
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	var ReceivePaymentScreenOperationStatus = '';
    var TransactionAmountTotal = 0;
	var TransactionMethodAmountTotal = 0;
	var ReferenceTransactionRowCount = 0;
	var ReceivePaymentMethodRowCount = 0;
    var SelectedReferenceTransactionList = [];
	
	$(document).ready(function () {
		
        $(".msg_instant").hide();
        
		$("#datepicker_receive_payment_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$("#datepicker_cheque_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});

		ReceivePayment.getPayerData();
		ReceivePayment.getLocationData();
        ReceivePayment.getPurchaseNotesDropDown();
        ReceivePayment.getSalesNotesDropDown();
        ReceivePayment.getCustomerReturnNotesDropDown();
        ReceivePayment.getSupplierReturnNotesDropDown();
        
		var date = new Date();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		
		var monthName = moment.months(month - 1);
		$("#month_name").text(monthName + "  " + year);
		$("#current_month").val(month);
		$("#current_year").val(year);
		
		getTableData(year, month, "", "");
		ReceivePayment.init();
	});

	$(".new").click(function () {
		clearForm();
		ReceivePaymentScreenOperationStatus = "Add";
		ReceivePayment.getNextReferenceNo();
		ReceivePayment.hideMessageDisplay();
		$("#cash_payment").prop("checked", true)
		$("#receive_payment_details_form").show();
		$("#add_receive_payment_form").show();
		$(".save_form").show();
		$("#edit_receive_payment_form").hide();
		$("#search_receive_payment_form").hide();
        $("#receive_payment_save_button").attr('disabled', true);
		ReceivePayment.getReferenceTransactionTypesDropdown();
        ReceivePayment.getBankData();
        ReceivePayment.getCardPaymentAccountData();
		
		<?php if ($force_to_select_a_reference_transaction_for_receive_a_payment) { ?>
			$("#reference_transaction_section_div").show();
		<?php } ?>
            
        $('.receivePaymentReferenceDataTable').dataTable();
		$('.receivePaymentMethodDataTable').dataTable();
		$("#receive_payment_reference_list").hide();
		$("#receive_payment_method_list").hide();
		$("#receive_payment_method_records").hide();
            
        var payerType = '<?php echo $default_payer_type; ?>';
        
        if (payerType != '' && payerType != '0') {
            
            $("#payer_type").val(payerType);
            
            ReceivePayment.getPayerList(payerType, "");
        }
	});

	function cancelData() {
		ReceivePayment.cancelData();
	}

	function closeReceivePaymentEditForm() {
		ReceivePayment.closeReceivePaymentEditForm();
		window.scrollTo(0,0);
	}

	function saveData() {
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			ReceivePayment.saveData();
			window.scrollTo(0,0);
		}
	}

	function editReceivePaymentData(id) {
		if (validateForm_edit()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			ReceivePayment.editReceivePaymentData(id);
			window.scrollTo(0,0);
		}
	}

	function getReceivePaymentData(id){
		$(".loader").show();
		ReceivePaymentScreenOperationStatus = "View";
		ReceivePayment.hideMessageDisplay();
		ReceivePayment.getReceivePaymentData(id);
		window.scrollTo(0,0);
	}

	function del(id){
		ReceivePayment.hideMessageDisplay();
		ReceivePayment.deleteData(id);
		window.scrollTo(0,0);
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
	
	function handleCashPaymentSelect(id) {
		if ($("#" + id).prop("checked") == true) {
			if (ReceivePaymentScreenOperationStatus == "Add") {
				$("#cheque_details_div").hide();
				$("#cheque_payment").prop("checked", false);
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				$("#cheque_details_div_edit").hide();
				$("#cheque_payment_edit").prop("checked", false);
			}
		} else {
			if (ReceivePaymentScreenOperationStatus == "Add") {
				$("#cheque_details_div").show();
				$("#cheque_payment").prop("checked", true);
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				$("#cheque_details_div_edit").show();
				$("#cheque_payment_edit").prop("checked", true);
			}
		}
	}
	
	function handleChequePaymentSelect(id) {
		if ($("#" + id).prop("checked") == true) {
			if (ReceivePaymentScreenOperationStatus == "Add") {
				$("#cheque_details_div").show();
				$("#cash_payment").prop("checked", false);
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				$("#cheque_details_div_edit").show();
				$("#cash_payment_edit").prop("checked", false);
			}
		} else {
			if (ReceivePaymentScreenOperationStatus == "Add") {
				$("#cheque_details_div").hide();
				$("#cash_payment").prop("checked", true);
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				$("#cheque_details_div_edit").hide();
				$("#cash_payment_edit").prop("checked", true);
			}
		}
	}
	
	function handleAmountAddition() {
		var amount = "";
		if (ReceivePaymentScreenOperationStatus == "Add") {
			amount = $("#amount").val();
		} else if (ReceivePaymentScreenOperationStatus == "View") {
			amount = $("#amount_edit").val();
		}

		if (amount != "") {
			var amountData = amount.split(".");
			var amountDataSize = amountData.length;

			if (amountDataSize == 1) {
				amount = amount + ".00";
				if (ReceivePaymentScreenOperationStatus == "Add") {
					$("#amount").val(amount);
				} else if (ReceivePaymentScreenOperationStatus == "View") {
					$("#amount_edit").val(amount);
				}
			}
		} else {
			amount = "0.00";
			if (ReceivePaymentScreenOperationStatus == "Add") {
				$("#amount").val("0.00");
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				$("#amount_edit").val("0.00");
			}
		}
	}
	
	function searchData() {
		var payerId = $("#payer_search_id").val();
		var locationId = $("#location_search_id").val();
        var purchaseNoteId = $("#purchase_note_id").val();
        var salesNoteId = $("#sales_note_id").val();
        var customerReturnNoteId = $("#customer_return_note_id").val();
        var supplierReturnNoteId = $("#supplier_return_note_id").val();
		getTableData("", "", payerId, locationId, purchaseNoteId, salesNoteId, customerReturnNoteId, supplierReturnNoteId);
	}
	
	function getPeopleType(id) {
		var payerType = $("#" + id).val();
		
        if (payerType != '') {
            ReceivePayment.getPayerList(payerType, "");
        } else {
            $("#payer_list_div").hide();
        }
	}
	
	function handleReferenceTransactionTypeSelect(id) {
        
        var peopleId = '';
        var locationId = '';
        
        if (ReceivePaymentScreenOperationStatus == "Add") {
            peopleId = $("#people_id").val();
            locationId = $("#location").val();
        } else if (ReceivePaymentScreenOperationStatus == "View") {
            peopleId = $("#people_id_edit").val();
            locationId = $("#location_edit").val();
        }
            
		ReceivePayment.getReferenceTransactionListForSelectedType($("#" + id).val(), peopleId, locationId);
		
	}
	
	function handleReferenceTransactionSelect(id) {
		if (ReceivePaymentScreenOperationStatus == "Add") {
            var transactionTypeId = $("#reference_transaction_type_id").val();
            var transactionId = $("#" + id).find('option:selected').text();
            var peopleId = $("#people_id").val();
            var locationId = $("#location").val();
			ReceivePayment.getReferenceJournalEntryListForSelectedTransaction(transactionTypeId, transactionId, peopleId, locationId);
		} else if (ReceivePaymentScreenOperationStatus == "View") {
            var transactionTypeId = $("#reference_transaction_type_id_edit").val();
            var transactionId = $("#" + id).find('option:selected').text();
            var peopleId = $("#people_id_edit").val();
            var locationId = $("#location_edit").val();
			ReceivePayment.getReferenceJournalEntryListForSelectedTransaction(transactionTypeId, transactionId, peopleId, locationId);
		}
	}
	
	function handleLocationSelect() {
		
	}
	
	function handleCustomerSelection() {
		var referenceTransactionType = '<?php echo $default_reference_transaction_type; ?>';
        
        if (referenceTransactionType != '' && referenceTransactionType != '0') {
            
            $("#reference_transaction_type_id").val(referenceTransactionType);
            
            var peopleId = '';
		
            if (ReceivePaymentScreenOperationStatus == "Add") {
                peopleId = $("#people_id").val();
            } else if (ReceivePaymentScreenOperationStatus == "View") {
                peopleId = $("#people_id_edit").val();
            }

            ReceivePayment.getReferenceTransactionListForSelectedType(referenceTransactionType, peopleId);
        }
	}
	
    function addReferenceTransaction() {
		var referenceTransactionType = '';
		var referenceTransactionId = '';
		var referenceJournalEntryId = '';
		var referenceTransaction = '';
		
		if (ReceivePaymentScreenOperationStatus == "Add") {
			referenceTransactionType = $("#reference_transaction_type_id").val();
			referenceTransactionId = $("#reference_transaction_id").val();
			referenceJournalEntryId = $("#reference_journal_entry_id").val();
			referenceTransaction = $("#reference_transaction_id option:selected").text();
            $("#cheque_deposit_account_div").hide();
		} else if (ReceivePaymentScreenOperationStatus == "View") {
			referenceTransactionType = $("#reference_transaction_type_id_edit").val();
			referenceTransactionId = $("#reference_transaction_id_edit").val();
			referenceJournalEntryId = $("#reference_journal_entry_id_edit").val();
			referenceTransaction = $("#reference_transaction_id_edit option:selected").text();
		}
		
		if (!SelectedReferenceTransactionList.includes(referenceTransaction)) {
			ReceivePayment.selectReferenceJournalEntry(referenceTransactionType, referenceTransactionId, referenceJournalEntryId);
		} else {
			alert('<?php echo $this->lang->line("Reference transaction is already selected.") ?>');
		}
	}
	
	function deleteReferenceTransaction(id) {
	
		var rowCount = '';
	
		var referenceTransactionType = '';
		var referenceTransaction = '';
		var referenceTrannsactionAmount = '';
		var transactionAmountTotal = '';
	
		if (ReceivePaymentScreenOperationStatus == "Add") {
			
			rowCount = id.substring(29,31);
			
			referenceTransactionType = $("#reference_transaction_type_" + rowCount).val();
			referenceTransaction = $("#reference_transaction_" + rowCount).html();
			referenceTrannsactionAmount = $("#reference_transaction_balance_amount_" + rowCount).html().replace(",", "");
			referenceTrannsactionAmount = referenceTrannsactionAmount.replace("(", "");
			referenceTrannsactionAmount = referenceTrannsactionAmount.replace(")", "");
			
			if (referenceTransactionType == '1' || referenceTransactionType == '4' || referenceTransactionType == '5') {
				TransactionAmountTotal = TransactionAmountTotal + parseFloat(referenceTrannsactionAmount);
			} else if (referenceTransactionType == '2' || referenceTransactionType == '3') {
				TransactionAmountTotal = TransactionAmountTotal - parseFloat(referenceTrannsactionAmount);
			}
			
			ReferenceTransactionRowCount--;
			$("#row_" + rowCount).remove();
			$("#reference_amount_total").html(TransactionAmountTotal.toFixed(2));

			transactionAmountTotal = TransactionAmountTotal;
			//transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(TransactionMethodAmountTotal);
			$("#amount_to_add_payment_type").val(transactionAmountTotal.toFixed(2));
			
			rowCount++;
			var referenceTransactionElement = $("#receive_payment_reference_list").find("#row_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (referenceTransactionElement.length == 1) {
					
					$("#receive_payment_reference_list").find("#row_" + rowCount).prop({ id: "row_" + (rowCount - 1)});
					$("#receive_payment_reference_list").find("#reference_transaction_type_" + rowCount).prop({ id: "reference_transaction_type_" + (rowCount - 1)});
					$("#receive_payment_reference_list").find("#reference_transaction_id_" + rowCount).prop({ id: "reference_transaction_id_" + (rowCount - 1)});
					$("#receive_payment_reference_list").find("#reference_journal_entry_id_" + rowCount).prop({ id: "reference_journal_entry_id_" + (rowCount - 1)});
                    $("#receive_payment_reference_list").find("#reference_transaction_" + rowCount).prop({ id: "reference_transaction_" + (rowCount - 1)});
					$("#receive_payment_reference_list").find("#reference_transaction_amount_" + rowCount).prop({ id: "reference_transaction_amount_" + (rowCount - 1)});
					$("#receive_payment_reference_list").find("#reference_transaction_balance_amount_" + rowCount).prop({ id: "reference_transaction_balance_amount_" + (rowCount - 1)});
					$("#receive_payment_reference_list").find("#delete_reference_transaction_" + rowCount).prop({ id: "delete_reference_transaction_" +  (rowCount - 1)});
					
					rowCount++;
					referenceTransactionElement = $("#receive_payment_reference_list").find("#row_" + rowCount);
				} else {
					moreElement = false;
				}
			}
			
            if (TransactionMethodAmountTotal == 0 || TransactionAmountTotal <= 0) {
                $("#receive_payment_save_button").attr('disabled', true);
            }
		} else if (ReceivePaymentScreenOperationStatus == "View") {
			
			rowCount = id.substring(34,36);
			
			referenceTransactionType = $("#reference_transaction_type_edit_" + rowCount).val();
			referenceTransaction = $("#reference_transaction_edit_" + rowCount).html();
			referenceTrannsactionAmount = $("#reference_transaction_amount_edit_" + rowCount).val().replace(",", "");
//			referenceTrannsactionAmount = referenceTrannsactionAmount.replace("(", "");
//			referenceTrannsactionAmount = referenceTrannsactionAmount.replace(")", "");
			
			if (referenceTransactionType == '1' || referenceTransactionType == '4' || referenceTransactionType == '5') {
				TransactionAmountTotal = TransactionAmountTotal + parseFloat(referenceTrannsactionAmount);
			} else if (referenceTransactionType == '2' || referenceTransactionType == '3') {
				TransactionAmountTotal = TransactionAmountTotal - parseFloat(referenceTrannsactionAmount);
			}
			
			ReferenceTransactionRowCount--;
			$("#row_edit_" + rowCount).remove();
			$("#reference_amount_total_edit").html(TransactionAmountTotal.toFixed(2));

			transactionAmountTotal = TransactionAmountTotal;
//			transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(TransactionMethodAmountTotal);
			$("#amount_to_add_payment_type_edit").val(transactionAmountTotal.toFixed(2));
			
			rowCount++;
			var referenceTransactionElement = $("#receive_payment_reference_list_edit").find("#row_edit_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (referenceTransactionElement.length == 1) {
					
					$("#receive_payment_reference_list_edit").find("#row_edit_" + rowCount).prop({ id: "row_edit_" + (rowCount - 1)});
					$("#receive_payment_reference_list_edit").find("#reference_transaction_type_edit_" + rowCount).prop({ id: "reference_transaction_type_edit_" + (rowCount - 1)});
					$("#receive_payment_reference_list_edit").find("#reference_transaction_id_edit_" + rowCount).prop({ id: "reference_transaction_id_edit_" + (rowCount - 1)});
					$("#receive_payment_reference_list_edit").find("#reference_journal_entry_id_edit_" + rowCount).prop({ id: "reference_journal_entry_id_edit_" + (rowCount - 1)});
                    $("#receive_payment_reference_list_edit").find("#reference_transaction_edit_" + rowCount).prop({ id: "reference_transaction_edit_" + (rowCount - 1)});
					$("#receive_payment_reference_list_edit").find("#reference_transaction_amount_edit_" + rowCount).prop({ id: "reference_transaction_amount_edit_" + (rowCount - 1)});
					$("#receive_payment_reference_list_edit").find("#reference_transaction_balance_amount_edit_" + rowCount).prop({ id: "reference_transaction_balance_amount_edit_" + (rowCount - 1)});
					$("#receive_payment_reference_list_edit").find("#delete_reference_transaction_edit_" + rowCount).prop({ id: "delete_reference_transaction_edit_" +  (rowCount - 1)});
					
					rowCount++;
					referenceTransactionElement = $("#receive_payment_reference_list_edit").find("#row_edit_" + rowCount);
				} else {
					moreElement = false;
				}
			}
			
            if (TransactionMethodAmountTotal == 0 || TransactionAmountTotal <= 0) {
                $("#receive_payment_edit_button").attr('disabled', true);
            }
		}
		
		var index = SelectedReferenceTransactionList.indexOf(referenceTransaction);
		if (index > -1) {
			SelectedReferenceTransactionList.splice(index, 1);
		}
	}
    
    function handleReferenceJournalEntrySelect(id) {
		if ($("#" + id).val() != '0') {
			if (ReceivePaymentScreenOperationStatus == "Add") {
				$("#add_reference_transaction").attr('disabled', false);
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				$("#add_reference_transaction_edit").attr('disabled', false);
			}
		} else {
            if (ReceivePaymentScreenOperationStatus == "Add") {
                $("#add_reference_transaction").attr('disabled', true);
            } else if (ReceivePaymentScreenOperationStatus == "View") {
                $("#add_reference_transaction_edit").attr('disabled', true);
            }
        }
	}
    
    function addCashPayment() {
		
		var referenceTransactionType = '';
		var cashPaymentAmount = '';
        var chequePaymentAmount = '';
        var cardPaymentAmount = '';
		
		if (ReceivePaymentScreenOperationStatus == "Add") {
			if ($("#cash_payment_amount").val() != '') {
				var cashPayment = $("#cash_payment_amount").val();
				var cashPaymentData = cashPayment.split(".");
				var cashPaymentDataSize = cashPaymentData.length;

				if (cashPaymentDataSize == 1) {
					cashPayment = cashPayment + ".00";
					$("#cash_payment_amount").val(cashPayment);
				} else {
					$("#cash_payment_amount").val(cashPayment);
				}
			}

			referenceTransactionType = $("#reference_transaction_type_id").val();
			cashPaymentAmount = $("#cash_payment_amount").val();
            chequePaymentAmount = '';
            cardPaymentAmount = '';

			if (validateCashPaymentMethod_add()) {
				$("#cash_payment_amount").val('');
				ReceivePayment.addReceivePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, cardPaymentAmount, '', '', '', '', '', '', '', '', '', referenceTransactionType);
			}
		} else if (ReceivePaymentScreenOperationStatus == "View") {
			if ($("#cash_payment_amount_edit").val() != '') {
				var cashPayment = $("#cash_payment_amount_edit").val();
				var cashPaymentData = cashPayment.split(".");
				var cashPaymentDataSize = cashPaymentData.length;

				if (cashPaymentDataSize == 1) {
					cashPayment = cashPayment + ".00";
					$("#cash_payment_amount_edit").val(cashPayment);
				} else {
					$("#cash_payment_amount_edit").val(cashPayment);
				}
			}

			referenceTransactionType = $("#reference_transaction_type_id_edit").val();
			cashPaymentAmount = $("#cash_payment_amount_edit").val();
            chequePaymentAmount = '';
            cardPaymentAmount = '';

			if (validateCashPaymentMethod_edit()) {
				$("#cash_payment_amount_edit").val('');
				ReceivePayment.addReceivePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, cardPaymentAmount, '', '', '', '', '', '', '', '', '', referenceTransactionType);
			}
		}
	}
	
	function addChequePayment() {
		
		var referenceTransactionType = '';
		var chequeNumber = '';
		var bank = '';
		var bankName = '';
		var chequeDate = '';
		var chequePaymentAmount = '';
        var thirdPartyCheque = '';
        var crossedCheque = '';
        var chequeDepositPrimeEntryBookId = '';
        var cardPaymentAmount = '';
		var cashPaymentAmount = '';
		
		if (ReceivePaymentScreenOperationStatus == "Add") {
			if ($("#cheque_payment_amount").val() != '') {
				var chequePayment = $("#cheque_payment_amount").val();
				var chequePaymentData = chequePayment.split(".");
				var chequePaymentDataSize = chequePaymentData.length;

				if (chequePaymentDataSize == 1) {
					chequePayment = chequePayment + ".00";
					$("#cheque_payment_amount").val(chequePayment);
				} else {
					$("#cheque_payment_amount").val(chequePayment);
				}
			}

			referenceTransactionType = $("#reference_transaction_type_id").val();
			chequeNumber = $("#cheque_number").val();
			bank = $("#bank_id").val();
			bankName = $("#bank_id option:selected").text();
			chequeDate = $("#cheque_date").val();
			chequePaymentAmount = $("#cheque_payment_amount").val();
            
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
            
            chequeDepositPrimeEntryBookId = $("#cheque_deposit_account_id").val();
                    
            cardPaymentAmount = '';
			cashPaymentAmount = '';

			if (validateChequePaymentMethod_add()) {
				$("#cheque_number").val('');
				$("#bank_id").val('0');
				$("#cheque_date").val('');
				$("#cheque_payment_amount").val('');
                $("#third_party_cheque").prop("checked", false);
                $("#crossed_cheque").prop("checked", false);
                $("#cheque_deposit_account_id").val('0');
                $("#cheque_deposit_account_div").hide();
                
				ReceivePayment.addReceivePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, cardPaymentAmount, chequeNumber, 
                bank, bankName, chequeDate, thirdPartyCheque, crossedCheque, chequeDepositPrimeEntryBookId, '', '', referenceTransactionType);
			}
		} else if (ReceivePaymentScreenOperationStatus == "View") {
			if ($("#cheque_payment_amount_edit").val() != '') {
				var chequePayment = $("#cheque_payment_amount_edit").val();
				var chequePaymentData = chequePayment.split(".");
				var chequePaymentDataSize = chequePaymentData.length;

				if (chequePaymentDataSize == 1) {
					chequePayment = chequePayment + ".00";
					$("#cheque_payment_amount_edit").val(chequePayment);
				} else {
					$("#cheque_payment_amount_edit").val(chequePayment);
				}
			}

			referenceTransactionType = $("#reference_transaction_type_id_edit").val();
			chequeNumber = $("#cheque_number_edit").val();
			bank = $("#bank_id_edit").val();
			bankName = $("#bank_id_edit option:selected").text();
			chequeDate = $("#cheque_date_edit").val();
			chequePaymentAmount = $("#cheque_payment_amount_edit").val();
            
            if ($("#third_party_cheque_edit").prop("checked") == true) {
                thirdPartyCheque = "Yes";
            } else {
                thirdPartyCheque = "No";
            }  
            
            if ($("#crossed_cheque_edit").prop("checked") == true) {
                crossedCheque = "Yes";
            } else {
                crossedCheque = "No";
            }  
            
            chequeDepositPrimeEntryBookId = $("#cheque_deposit_account_id_edit").val();
            
            cardPaymentAmount = '';
			cashPaymentAmount = '';

			if (validateChequePaymentMethod_edit()) {
				$("#cheque_number_edit").val('');
				$("#bank_id_edit").val('0');
				$("#cheque_date_edit").val('');
				$("#cheque_payment_amount_edit").val('');
                $("#third_party_cheque_edit").prop("checked", false);
                $("#crossed_cheque_edit").prop("checked", false);
                $("#cheque_deposit_account_id_edit").val('0');
                $("#cheque_deposit_account_div_edit").hide();
                
				ReceivePayment.addReceivePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, cardPaymentAmount, chequeNumber, 
                bank, bankName, chequeDate, thirdPartyCheque, crossedCheque, chequeDepositPrimeEntryBookId, '', '', referenceTransactionType);
			}
		}
	}
    
    function addCreditCardPayment() {
		
        var referenceTransactionType = '';
        var paymentAccountId = '';
		var cardType = '';
        var cardPaymentAmount = '';
        var chequePaymentAmount = '';
        var cashPaymentAmount = '';
		
		if (ReceivePaymentScreenOperationStatus == "Add") {
			if ($("#credit_card_payment_amount").val() != '') {
				var cardPayment = $("#credit_card_payment_amount").val();
				var cardPaymentData = cardPayment.split(".");
				var cardPaymentDataSize = cardPaymentData.length;

				if (cardPaymentDataSize == 1) {
					cardPayment = cardPayment + ".00";
					$("#credit_card_payment_amount").val(cardPayment);
				} else {
					$("#credit_card_payment_amount").val(cardPayment);
				}
			}

			referenceTransactionType = $("#reference_transaction_type_id").val();
            paymentAccountId = $("#payment_account_id").val();
			cardType = $("#credit_card_type_init").val();
            cardPaymentAmount = $("#credit_card_payment_amount").val();
            
            chequePaymentAmount = '';
			cashPaymentAmount = '';

			if (validateCardPaymentMethod_add()) {
                $("#payment_account_id").val('0');
				$("#credit_card_type_init").val('');
				$("#credit_card_payment_amount").val('');
                $("#total_card_payment").val('');
				ReceivePayment.addReceivePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, cardPaymentAmount, '', '', '', '', '', '', '', paymentAccountId, cardType, referenceTransactionType);
			}
		} else if (ReceivePaymentScreenOperationStatus == "View") {
			if ($("#credit_card_payment_amount_edit").val() != '') {
				var cardPayment = $("#credit_card_payment_amount_edit").val();
				var cardPaymentData = cardPayment.split(".");
				var cardPaymentDataSize = cardPaymentData.length;

				if (cardPaymentDataSize == 1) {
					cardPayment = cardPayment + ".00";
					$("#credit_card_payment_amount_edit").val(cardPayment);
				} else {
					$("#credit_card_payment_amount_edit").val(cardPayment);
				}
			}

			referenceTransactionType = $("#reference_transaction_type_id_edit").val();
            paymentAccountId = $("#payment_account_id_edit").val();
			cardType = $("#credit_card_type_init").val();
            cardPaymentAmount = $("#credit_card_payment_amount_edit").val();
            
            chequePaymentAmount = '';
			cashPaymentAmount = '';

			if (validateCardPaymentMethod_edit()) {
                $("#payment_account_id_edit").val('0');
				$("#credit_card_type_init_edit").val('');
				$("#credit_card_payment_amount_edit").val('');
                $("#total_card_payment_edit").val('');
				ReceivePayment.addReceivePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, cardPaymentAmount, '', '', '', '', '', '', '', paymentAccountId, cardType, referenceTransactionType);
			}
		}
	}
    
    function deleteReceivePaymentMethod(id) {
		
		var rowCount = '';
		
		var paymentMethodAmount = '';
		var transactionAmountTotal = '';
		
		if (ReceivePaymentScreenOperationStatus == "Add") {
			
			rowCount = id.substring(30,32);
			
			paymentMethodAmount = $("#amount_" + rowCount).html().replace(",", "");
			TransactionMethodAmountTotal = TransactionMethodAmountTotal - parseFloat(paymentMethodAmount);
			$("#payment_method_row_" + rowCount).remove();
			ReceivePaymentMethodRowCount--;

			transactionAmountTotal = TransactionAmountTotal;
			transactionAmountTotal = parseFloat(transactionAmountTotal) + parseFloat(paymentMethodAmount);
            TransactionAmountTotal = transactionAmountTotal;
			$("#amount_to_add_payment_type").val(transactionAmountTotal.toFixed(2));
			$("#payment_method_amount_total").html(TransactionMethodAmountTotal.toFixed(2));
			$("#amount").val(TransactionMethodAmountTotal.toFixed(2));
			
			rowCount++;
			var receivePaymentMethodElement = $("#receive_payment_method_records").find("#payment_method_row_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (receivePaymentMethodElement.length == 1) {
					
					$("#receive_payment_method_records").find("#payment_method_row_" + rowCount).prop({ id: "row_" + (rowCount - 1)});
                    $("#receive_payment_method_records").find("#payment_account_id_" + rowCount).prop({ id: "payment_account_id_" + (rowCount - 1)});
					$("#receive_payment_method_records").find("#bank_id_" + rowCount).prop({ id: "bank_id_" + (rowCount - 1)});
                    $("#receive_payment_method_records").find("#crossed_cheque_" + rowCount).prop({ id: "crossed_cheque_" + (rowCount - 1)});
                    $("#receive_payment_method_records").find("#cheque_deposit_account_id_" + rowCount).prop({ id: "cheque_deposit_account_id_" + (rowCount - 1)});
					$("#receive_payment_method_records").find("#receive_payment_method_" + rowCount).prop({ id: "receive_payment_method_" + (rowCount - 1)});
					$("#receive_payment_method_records").find("#cheque_number_" + rowCount).prop({ id: "cheque_number_" + (rowCount - 1)});
					$("#receive_payment_method_records").find("#bank_" + rowCount).prop({ id: "bank_" +  (rowCount - 1)});
					$("#receive_payment_method_records").find("#cheque_date_" + rowCount).prop({ id: "cheque_date_" +  (rowCount - 1)});
                    $("#receive_payment_method_records").find("#card_type_" + rowCount).prop({ id: "card_type_" +  (rowCount - 1)});
					$("#receive_payment_method_records").find("#amount_" + rowCount).prop({ id: "amount_" +  (rowCount - 1)});
					$("#receive_payment_method_records").find("#delete_receive_payment_method_" + rowCount).prop({ id: "delete_receive_payment_method_" +  (rowCount - 1)});
					
					rowCount++;
					receivePaymentMethodElement = $("#receive_payment_method_records").find("#payment_method_row_" + rowCount);
				} else {
                    rowCount--;
					moreElement = false;
				}
			}
			
            if (rowCount == 1) {
                $("#receive_payment_save_button").attr('disabled', true);
            }
		} else if (ReceivePaymentScreenOperationStatus == "View") {
			
			rowCount = id.substring(35,37);
			
			paymentMethodAmount = $("#amount_edit_" + rowCount).html().replace(",", "");
			TransactionMethodAmountTotal = TransactionMethodAmountTotal - parseFloat(paymentMethodAmount);
			$("#payment_method_row_edit_" + rowCount).remove();
			ReceivePaymentMethodRowCount--;

			transactionAmountTotal = TransactionAmountTotal;
			transactionAmountTotal = parseFloat(transactionAmountTotal) + parseFloat(paymentMethodAmount);
            TransactionAmountTotal = transactionAmountTotal;
			$("#amount_to_add_payment_type_edit").val(transactionAmountTotal.toFixed(2));
			$("#payment_method_amount_total_edit").html(TransactionMethodAmountTotal.toFixed(2));
			$("#amount_edit").val(TransactionMethodAmountTotal.toFixed(2));
			
			rowCount++;
			var receivePaymentMethodElement = $("#receive_payment_method_records_edit").find("#payment_method_row_edit_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (receivePaymentMethodElement.length == 1) {
					
					$("#receive_payment_method_records_edit").find("#payment_method_row_edit_" + rowCount).prop({ id: "payment_method_row_edit_" + (rowCount - 1)});
                    $("#receive_payment_method_records_edit").find("#payment_account_id_edit_" + rowCount).prop({ id: "payment_account_id_edit_" + (rowCount - 1)});
					$("#receive_payment_method_records_edit").find("#bank_id_edit_" + rowCount).prop({ id: "bank_id_edit_" + (rowCount - 1)});
                    $("#receive_payment_method_records_edit").find("#crossed_cheque_edit_" + rowCount).prop({ id: "crossed_cheque_edit_" + (rowCount - 1)});
                    $("#receive_payment_method_records_edit").find("#cheque_deposit_account_id_edit_" + rowCount).prop({ id: "cheque_deposit_account_id_edit_" + (rowCount - 1)});
					$("#receive_payment_method_records_edit").find("#receive_payment_method_edit_" + rowCount).prop({ id: "receive_payment_method_edit_" + (rowCount - 1)});
					$("#receive_payment_method_records_edit").find("#cheque_number_edit_" + rowCount).prop({ id: "cheque_number_edit_" + (rowCount - 1)});
					$("#receive_payment_method_records_edit").find("#bank_edit_" + rowCount).prop({ id: "bank_edit_" +  (rowCount - 1)});
					$("#receive_payment_method_records_edit").find("#cheque_date_edit_" + rowCount).prop({ id: "cheque_date_edit_" +  (rowCount - 1)});
                    $("#receive_payment_method_records_edit").find("#card_type_edit_" + rowCount).prop({ id: "card_type_edit_" +  (rowCount - 1)});
					$("#receive_payment_method_records_edit").find("#amount_edit_" + rowCount).prop({ id: "amount_edit_" +  (rowCount - 1)});
					$("#receive_payment_method_records_edit").find("#delete_receive_payment_method_edit_" + rowCount).prop({ id: "delete_receive_payment_method_edit_" +  (rowCount - 1)});
					
					rowCount++;
					receivePaymentMethodElement = $("#receive_payment_method_records").find("#payment_method_row_" + rowCount);
				} else {
                    rowCount--;
					moreElement = false;
				}
			}
			
            if (rowCount == 1) {
                $("#receive_payment_edit_button").attr('disabled', true);
            }
		}
	}
    
    function handleBankSelect() {
		
	}
    
    function handleIncludeBankChargeSelect(id) {
        var selected = 'No';
		
		if ($("#" + id).prop("checked") == true) {
			selected = 'Yes';
		}
		
		ReceivePayment.handleIncludeBankChargeSelect(selected, id);
    }
    
    function handleSupplierSelect() {
        
    }
    
    function handleAgentSelection() {
        
    }
    
    function handleSalesRepSelect() {
        
    }
    
    function handlePurchaseNoteSelect(id) {
        var selectedId = $("#" + id).val();
        
        if (selectedId != '0') {
            $("#sales_note_id").val('0').trigger("change");
            $("#customer_return_note_id").val('0').trigger("change");
            $("#supplier_return_note_id").val('0').trigger("change");
        }
    }
    
    function handleSalesNoteSelect(id) {
        var selectedId = $("#" + id).val();
        
        if (selectedId != '0') {
            $("#purchase_note_id").val('0').trigger("change");
            $("#customer_return_note_id").val('0').trigger("change");
            $("#supplier_return_note_id").val('0').trigger("change");
        }
    }
    
    function handleCustomerReturnNoteSelect(id) {
        var selectedId = $("#" + id).val();
        
        if (selectedId != '0') {
            $("#purchase_note_id").val('0').trigger("change");
            $("#sales_note_id").val('0').trigger("change");
            $("#supplier_return_note_id").val('0').trigger("change");
        }
    }
    
    function handleSupplierReturnNoteSelect(id) {
        var selectedId = $("#" + id).val();
        
        if (selectedId != '0') {
            $("#purchase_note_id").val('0').trigger("change");
            $("#sales_note_id").val('0').trigger("change");
            $("#customer_return_note_id").val('0').trigger("change");
        }
    }
    
    function handCrossedChequeSelect(id) {
        if($("#" + id).prop("checked") == true) {
            if (ReceivePaymentScreenOperationStatus == "Add") {
                $("#cheque_deposit_account_div").show();
            } else if (ReceivePaymentScreenOperationStatus == "View") {
                $("#cheque_deposit_account_div_edit").show();
            }
        } else {
            if (ReceivePaymentScreenOperationStatus == "Add") {
                $("#cheque_deposit_account_div").hide();
            } else if (ReceivePaymentScreenOperationStatus == "View") {
                $("#cheque_deposit_account_div_edit").hide();
            }
        }
        
        ReceivePayment.getChequeDepositAccountData();
    }
	
	var ReceivePayment = {
        
		cancelData: function () {
			$("#receive_payment_details_form").hide();
			$("#search_receive_payment_form").show();
			ReceivePayment.hideMessageDisplay();
			clearForm();
		},

		closeReceivePaymentEditForm: function () {
			$("#receive_payment_details_form").hide();
			$("#search_receive_payment_form").show();
			ReceivePayment.hideMessageDisplay();
		},

		getNextReferenceNo : function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller/getNextReferenceNo",
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

		//Save receive payment data
		saveData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

            //Gather Reference Transaction Details
			var referenceTransactionData = [];
			
			var referenceTransactionElement = $("#receive_payment_reference_list").find("#reference_transaction_type_1");

			var referenceTransactionDataSet = [];
			var referenceTransactionTypes = {};
			var referenceTransactionIds = {};
			var referenceJournalEntryIds = {};

			var referenceTransactionCount = 1;
			var moreElement = true;
			while (moreElement) {
				if (referenceTransactionElement.length == 1) {

					referenceTransactionTypes[referenceTransactionCount] = $("#reference_transaction_type_" + referenceTransactionCount).val();
					referenceTransactionIds[referenceTransactionCount] = $("#reference_transaction_id_" + referenceTransactionCount).val();
					referenceJournalEntryIds[referenceTransactionCount] = $("#reference_journal_entry_id_" + referenceTransactionCount).val();
					referenceTransactionCount++;
					referenceTransactionElement = $("#receive_payment_reference_list").find("#reference_transaction_type_" + referenceTransactionCount);
				} else {
					moreElement = false;
				}
			}

			referenceTransactionDataSet.push(referenceTransactionTypes);
			referenceTransactionDataSet.push(referenceTransactionIds);
			referenceTransactionDataSet.push(referenceJournalEntryIds);

			referenceTransactionData.push(referenceTransactionDataSet);
			
			//Gather Payment Method Details
			var paymentMethodData = [];
			
			var paymentMethodElement = $("#receive_payment_method_records").find("#receive_payment_method_1");

			var paymentMethodDataSet = [];
			var paymentMethods = {};
            var paymentAccountIds = {};
			var bankIds = {};
			var chequeNumbers = {};
			var chequeDates = {};
            var thirdPartyCheques = {};
            var crossedCheques = {};
            var chequeDepositPrimeEntryBookIds = {};
            var cardTypes = {};
			var amounts = {};

			var paymentMethodCount = 1;
			var moreElement = true;
			while (moreElement) {
				if (paymentMethodElement.length == 1) {
					paymentMethods[paymentMethodCount] = $("#receive_payment_method_" + paymentMethodCount).html();
                    paymentAccountIds[paymentMethodCount] = $("#payment_account_id_" + paymentMethodCount).val();
					bankIds[paymentMethodCount] = $("#bank_id_" + paymentMethodCount).val();
					chequeNumbers[paymentMethodCount] = $("#cheque_number_" + paymentMethodCount).html();
					chequeDates[paymentMethodCount] = $("#cheque_date_" + paymentMethodCount).html();
                    thirdPartyCheques[paymentMethodCount] = $("#third_party_cheque_" + paymentMethodCount).val();
                    crossedCheques[paymentMethodCount] = $("#crossed_cheque_" + paymentMethodCount).val();
                    chequeDepositPrimeEntryBookIds[paymentMethodCount] = $("#cheque_deposit_account_id_" + paymentMethodCount).val();
                    cardTypes[paymentMethodCount] = $("#card_type_" + paymentMethodCount).html();
					amounts[paymentMethodCount] = $("#amount_" + paymentMethodCount).html();
					paymentMethodCount++;
					paymentMethodElement = $("#receive_payment_method_records").find("#receive_payment_method_" + paymentMethodCount);
				} else {
					moreElement = false;
				}
			}

			paymentMethodDataSet.push(paymentMethods);
            paymentMethodDataSet.push(paymentAccountIds);
			paymentMethodDataSet.push(bankIds);
			paymentMethodDataSet.push(chequeNumbers);
			paymentMethodDataSet.push(chequeDates);
            paymentMethodDataSet.push(thirdPartyCheques);
            paymentMethodDataSet.push(crossedCheques);
            paymentMethodDataSet.push(chequeDepositPrimeEntryBookIds);
            paymentMethodDataSet.push(cardTypes);
			paymentMethodDataSet.push(amounts);

			paymentMethodData.push(paymentMethodDataSet);

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller/add",
				data: {
					'reference_no' : $("#reference_no").val(),
					'receive_payment_date' : $("#receive_payment_date").val(),
					'payer_type' : $("#payer_type").val(),
					'payer_id' : $("#people_id").val(),
					'location_id' : $("#location").val(),
                    'remark': $("#remark").val().trim(),
                    'reference_transaction_data' : referenceTransactionData,
					'payment_method_data' : paymentMethodData,
					'reference_transaction_count' : referenceTransactionCount - 1,
					'payment_method_count' : paymentMethodCount - 1,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
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
						clearForm();
						ReceivePayment.getNextReferenceNo();
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},
        
        //Edit receive payment data
		editReceivePaymentData: function (id) {
        
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

            //Gather Reference Transaction Details
			var referenceTransactionData = [];
			
			var referenceTransactionElement = $("#receive_payment_reference_list_edit").find("#reference_transaction_type_edit_1");

			var referenceTransactionDataSet = [];
			var referenceTransactionTypes = {};
			var referenceTransactionIds = {};
			var referenceJournalEntryIds = {};

			var referenceTransactionCount = 1;
			var moreElement = true;
			while (moreElement) {
				if (referenceTransactionElement.length == 1) {

					referenceTransactionTypes[referenceTransactionCount] = $("#reference_transaction_type_edit_" + referenceTransactionCount).val();
					referenceTransactionIds[referenceTransactionCount] = $("#reference_transaction_id_edit_" + referenceTransactionCount).val();
					referenceJournalEntryIds[referenceTransactionCount] = $("#reference_journal_entry_id_edit_" + referenceTransactionCount).val();
					referenceTransactionCount++;
					referenceTransactionElement = $("#receive_payment_reference_list_edit").find("#reference_transaction_type_edit_" + referenceTransactionCount);
				} else {
					moreElement = false;
				}
			}

			referenceTransactionDataSet.push(referenceTransactionTypes);
			referenceTransactionDataSet.push(referenceTransactionIds);
			referenceTransactionDataSet.push(referenceJournalEntryIds);

			referenceTransactionData.push(referenceTransactionDataSet);
			
			//Gather Payment Method Details
			var paymentMethodData = [];
			
			var paymentMethodElement = $("#receive_payment_method_records_edit").find("#receive_payment_method_edit_1");

			var paymentMethodDataSet = [];
			var paymentMethods = {};
            var paymentAccountIds = {};
			var bankIds = {};
			var chequeNumbers = {};
			var chequeDates = {};
            var thirdPartyCheques = {};
            var crossedCheques = {};
            var chequeDepositPrimeEntryBookIds = {};
            var cardTypes = {};
			var amounts = {};

			var paymentMethodCount = 1;
			var moreElement = true;
			while (moreElement) {
				if (paymentMethodElement.length == 1) {
					paymentMethods[paymentMethodCount] = $("#receive_payment_method_edit_" + paymentMethodCount).html();
                    paymentAccountIds[paymentMethodCount] = $("#payment_account_id_edit_" + paymentMethodCount).val();
					bankIds[paymentMethodCount] = $("#bank_id_edit_" + paymentMethodCount).val();
					chequeNumbers[paymentMethodCount] = $("#cheque_number_edit_" + paymentMethodCount).html();
					chequeDates[paymentMethodCount] = $("#cheque_date_edit_" + paymentMethodCount).html();
                    thirdPartyCheques[paymentMethodCount] = $("#third_party_cheque_edit_" + paymentMethodCount).val();
                    crossedCheques[paymentMethodCount] = $("#crossed_cheque_edit_" + paymentMethodCount).val();
                    chequeDepositPrimeEntryBookIds[paymentMethodCount] = $("#cheque_deposit_account_id_edit_" + paymentMethodCount).val();
                    cardTypes[paymentMethodCount] = $("#card_type_edit_" + paymentMethodCount).html();
                    
                    var amount = $("#amount_edit_" + paymentMethodCount).html().replace(",", "");
                    
					amounts[paymentMethodCount] = amount;
					paymentMethodCount++;
					paymentMethodElement = $("#receive_payment_method_records_edit").find("#receive_payment_method_edit_" + paymentMethodCount);
				} else {
					moreElement = false;
				}
			}

			paymentMethodDataSet.push(paymentMethods);
            paymentMethodDataSet.push(paymentAccountIds);
			paymentMethodDataSet.push(bankIds);
			paymentMethodDataSet.push(chequeNumbers);
			paymentMethodDataSet.push(chequeDates);
            paymentMethodDataSet.push(thirdPartyCheques);
            paymentMethodDataSet.push(crossedCheques);
            paymentMethodDataSet.push(chequeDepositPrimeEntryBookIds);
            paymentMethodDataSet.push(cardTypes);
			paymentMethodDataSet.push(amounts);
            
			paymentMethodData.push(paymentMethodDataSet);

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller/editReceivePaymentData",
				data: {
                    'id': id,
					'reference_no' : $("#reference_no_edit").val(),
					'receive_payment_date' : $("#receive_payment_date_edit").val(),
					'remark': $("#remark_edit").val().trim(),
                    'reference_transaction_data' : referenceTransactionData,
					'payment_method_data' : paymentMethodData,
					'reference_transaction_count' : referenceTransactionCount - 1,
					'payment_method_count' : paymentMethodCount - 1,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response.result == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
                        $("#search_receive_payment_form").show();
						$("#receive_payment_details_form").hide();
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "");
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$(".save:input").attr('disabled', false);
					}
				}
			});
		},

		deleteData: function (id) {

			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Receive Payment') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller/deleteReceivePayment",
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

		getReceivePaymentData: function (id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller/getReceivePaymentData",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					$("#receive_payment_details_form").show();
					$("#search_receive_payment_form").hide();
					$("#add_receive_payment_form").hide();
					$("#edit_receive_payment_form").show();
					$("#edit_receive_payment_form_content").html(response.result);
                    $("#cheque_deposit_account_div_edit").hide();
					
					ReceivePayment.getPayerList(response.payerType);
					
					setTimeout(function(){
						$("#people_id_edit").val(response.payerId).trigger('change');
					}, 800);
					
					if (response.referenceTransactionType != '') {
						$('#reference_transaction_type_init_edit').hide();
						$("#reference_transaction_type_dropdown_edit").html(response.referenceTransactionType);
						$("#reference_transaction_type_dropdown_edit").find("#reference_transaction_type_id").prop({ id: "reference_transaction_type_id_edit"});
					}
					
					$("#amount_to_add_payment_type_edit").val(response.amountToAddForPaymentType.toFixed(2));
					
					ReferenceTransactionRowCount = response.referenceTransactionRowCount;
					ReceivePaymentMethodRowCount = response.receivePaymentMethodRowCount;
					TransactionAmountTotal = response.referenceTransactionTotalAmount;
					TransactionMethodAmountTotal = response.transactionMethodAmountTotal;
					
					jQuery.each(response.referenceTransactionList, function(index, referenceNo) {
						if (referenceNo != '') {
							SelectedReferenceTransactionList.push(referenceNo);
						}
					});

					$('.receivePaymentReferenceDataEditTable').dataTable();
					$('.receivePaymentMethodDataEditTable').dataTable();
		
					setTimeout(function(){
						$("#reference_transaction_div_edit").hide();
						$("#reference_journal_entry_div_edit").hide();
					}, 1000);
					
					$("#receive_payment_edit_box_title").text('<?php echo $this->lang->line('Edit Receive Payment') ?>');
					$(".loader").hide();
					
					$("#datepicker_receive_payment_date_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});

					$("#datepicker_cheque_date_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					
					$("#add_reference_transaction_edit").attr('disabled', true);
				}
			}).done(function() {
				ReceivePayment.getBankData();
			});
		},
		//get reference transaction type drop down
		getReferenceTransactionTypesDropdown: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceTransactionTypesDropdown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					$('#reference_transaction_type_init').hide();
					$("#reference_transaction_type_dropdown").html(response);
				}
			})
		},
		
		//get reference transaction list drop down
		getReferenceTransactionListForSelectedType: function (transactionTypeId, peopleId, locationId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceTransactionListForSelectedType",
				data: {
					'transaction_type_id' : transactionTypeId,
                    'people_id' : peopleId,
                    'location_id' : locationId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					if (response != 'other') {
						if (ReceivePaymentScreenOperationStatus == "Add") {
							$("#reference_journal_entry_div").hide();
							$("#reference_transaction_div").show();
							$('#reference_transaction_init').hide();
							$("#reference_transaction_dropdown").html(response);
							$("#reference_transaction_id").select2();
						} else if (ReceivePaymentScreenOperationStatus == "View") {
							$("#reference_journal_entry_div_edit").hide();
							$("#reference_transaction_div_edit").show();
							$('#reference_transaction_init_edit').hide();
							$("#reference_transaction_dropdown_edit").html(response);
							$("#reference_transaction_dropdown_edit").find("#reference_transaction_id").prop({ id: "reference_transaction_id_edit"});
							$("#reference_transaction_id_edit").select2();
						}
					} else {
						if (ReceivePaymentScreenOperationStatus == "Add") {
							$("#reference_transaction_div").hide();
						} else if (ReceivePaymentScreenOperationStatus == "View") {
							$("#reference_transaction_div_edit").hide();
						}
						ReceivePayment.getReferenceJournalEntryListForSelectedTransaction(transactionTypeId, '', peopleId, locationId);
					}
				}
			})
		},
		
		//get reference journal entry list drop down
		getReferenceJournalEntryListForSelectedTransaction: function (transactionTypeId, transactionReferenceNo, peopleId, locationId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceJournalEntryListForSelectedTransaction",
				data: {
					'transaction_type_id' : transactionTypeId,
					'transaction_reference_no' : transactionReferenceNo,
                    'status' : "Open",
                    'people_id' : peopleId,
                    'location_id' : locationId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					if (ReceivePaymentScreenOperationStatus == "Add") {
						$("#reference_journal_entry_div").show();
						$('#reference_journal_entry_init').hide();
						$("#reference_journal_entry_dropdown").html(response);
						$("#reference_journal_entry_id").select2();
					} else if (ReceivePaymentScreenOperationStatus == "View") {
						$("#reference_journal_entry_div_edit").show();
						$('#reference_journal_entry_init_edit').hide();
						$("#reference_journal_entry_dropdown_edit").html(response);
						$("#reference_journal_entry_dropdown_edit").find("#reference_journal_entry_id").prop({ id: "reference_journal_entry_id_edit"});
						$("#reference_journal_entry_id_edit").select2();
					}
				}
			}).done(function() {
                var selectReferenceJournalEntryAutomatically = '<?php echo $select_reference_journal_entry_automatically; ?>';
        
                if (selectReferenceJournalEntryAutomatically == 'Yes') {
                    var options = '';
                    if (ReceivePaymentScreenOperationStatus == "Add") {
                        options = document.getElementById('reference_journal_entry_id').options;
                    } else if (ReceivePaymentScreenOperationStatus == "View") {
                        options = document.getElementById('reference_journal_entry_id_edit').options;
                    }
                    
                    var i = 0;
                    jQuery.each(options, function() {
						if (i == 1) {
							options[1].selected = true;
                            
                            if (ReceivePaymentScreenOperationStatus == "Add") {
                                $("#reference_journal_entry_id").trigger("change");
                            } else if (ReceivePaymentScreenOperationStatus == "View") {
                                $("#reference_journal_entry_id_edit").trigger("change");
                            }
						}
                        
                        i++;
					});
                }
            });
		},
        
        selectReferenceJournalEntry: function (referenceTransactionType, referenceTransactionId, referenceJournalEntryId) {
		
			var referenceTransaction = '';
			var referenceJournalEntry = '';
			
			if (ReceivePaymentScreenOperationStatus == "Add") {
				referenceTransaction = $("#reference_transaction_id option:selected").text();
				referenceJournalEntry = $("#reference_journal_entry_id option:selected").text();
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				referenceTransaction = $("#reference_transaction_id_edit option:selected").text();
				referenceJournalEntry = $("#reference_journal_entry_id_edit option:selected").text();
			}
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceJournalEntryDetailsForReceivePayment",
				data: {
					'reference_transaction_type' : referenceTransactionType,
					'reference_transaction_id' : referenceTransactionId,
					'reference_journal_entry_id' : referenceJournalEntryId,
					'transaction_amount_total' : TransactionAmountTotal,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success: function (response) {
					ReferenceTransactionRowCount++;
					TransactionAmountTotal = parseFloat(response.transactionAmountTotalNonFormatted);
                    var paymentMethodTotal = parseFloat(response.transactionAmountTotalNonFormatted);
					var html = "";
					
					if (referenceTransactionType == '2' || referenceTransactionType == '3') {
						if (ReceivePaymentScreenOperationStatus == "Add") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_balance_amount_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						} else if (ReceivePaymentScreenOperationStatus == "View") {
							html = "	<tr id='row_edit_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_edit_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_balance_amount_edit_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_edit_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						}
					} else if (referenceTransactionType == '1' || referenceTransactionType == '4') {
						if (ReceivePaymentScreenOperationStatus == "Add") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_balance_amount_" + ReferenceTransactionRowCount + "'>(" + response.transactionAmount + ")</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						} else if (ReceivePaymentScreenOperationStatus == "View") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_edit_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_balance_amount_edit_" + ReferenceTransactionRowCount + "'>(" + response.transactionAmount + ")</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_edit_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						}
					} else if (referenceTransactionType == '5') {
						if (ReceivePaymentScreenOperationStatus == "Add") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_balance_amount_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						} else if (ReceivePaymentScreenOperationStatus == "View") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_edit_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_balance_amount_edit_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_edit_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						}
					}
						
					if (ReceivePaymentScreenOperationStatus == "Add") {
						$("#receive_payment_reference_amount_total").before(html);
						$("#reference_amount_total").html(response.transactionAmountTotal);
						$("#amount_to_add_payment_type").val(paymentMethodTotal.toFixed(2));
						$("#receive_payment_reference_list").show();
						$("#receive_payment_method_list").show();

						$("#reference_transaction_id").val('0').trigger("change");
						$("#reference_journal_entry_div").hide();
                        
                        if (TransactionMethodAmountTotal > 0 && TransactionAmountTotal > 0) {
                            $("#receive_payment_save_button").attr('disabled', false);
                        }
					} else if (ReceivePaymentScreenOperationStatus == "View") {
						$("#receive_payment_reference_amount_total_edit").before(html);
						$("#reference_amount_total_edit").html(response.transactionAmountTotal);
						$("#amount_to_add_payment_type_edit").val(paymentMethodTotal.toFixed(2));

						$("#reference_transaction_id_edit").val('0').trigger("change");
						$("#reference_journal_entry_div_edit").hide();
                        
                        if (TransactionMethodAmountTotal > 0 && TransactionAmountTotal > 0) {
                            $("#receive_payment_edit_button").attr('disabled', false);
                        }
					}
					
					SelectedReferenceTransactionList.push(referenceTransaction);
				}
			});
		},
        
        addReceivePaymentMethodRecord: function (cashPaymentAmount, chequePaymentAmount, cardPaymentAmount, chequeNumber, bank, bankName, 
            chequeDate, thirdPartyCheque, crossedCheque, chequeDepositPrimeEntryBookId, paymentAccountId, cardType, referenceTransactionType) {
		
			var paymentMethod = '';
			var amount = '';
			if (cashPaymentAmount != '') {
				paymentMethod = "Cash Payment";
				amount = cashPaymentAmount;
				TransactionMethodAmountTotal = parseFloat(TransactionMethodAmountTotal) + parseFloat(cashPaymentAmount);
			} else if (chequePaymentAmount != '') {
				paymentMethod = "Cheque Payment";
				amount = chequePaymentAmount;
				TransactionMethodAmountTotal = parseFloat(TransactionMethodAmountTotal) + parseFloat(chequePaymentAmount);
			} else if (cardPaymentAmount != '') {
				paymentMethod = "Card Payment";
				amount = cardPaymentAmount;
				TransactionMethodAmountTotal = parseFloat(TransactionMethodAmountTotal) + parseFloat(cardPaymentAmount);
			}
			
			ReceivePaymentMethodRowCount++;
			var html = "";
            
            var partialPaymentAllowed = '<?php echo $allow_partial_payment_for_reference_transactions ?>';
			
			if (ReceivePaymentScreenOperationStatus == "Add") {
				html = "	<tr id='payment_method_row_" + ReceivePaymentMethodRowCount + "'> " +
                            "   <input class='form-control' id='payment_account_id_" + ReceivePaymentMethodRowCount + "' name='payment_account_id_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + paymentAccountId + "'>" +
							"   <input class='form-control' id='bank_id_" + ReceivePaymentMethodRowCount + "' name='bank_id_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + bank + "'>" +
                            "   <input class='form-control' id='third_party_cheque_" + ReceivePaymentMethodRowCount + "' name='third_party_cheque_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + thirdPartyCheque + "'>" +
                            "   <input class='form-control' id='crossed_cheque_" + ReceivePaymentMethodRowCount + "' name='crossed_cheque_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + crossedCheque + "'>" +
                            "   <input class='form-control' id='cheque_deposit_account_id_" + ReceivePaymentMethodRowCount + "' name='cheque_deposit_account_id_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + chequeDepositPrimeEntryBookId + "'>" +
							"	<td id='receive_payment_method_" + ReceivePaymentMethodRowCount + "'>" + paymentMethod + "</td>" +
							"	<td id='cheque_number_" + ReceivePaymentMethodRowCount + "'>" + chequeNumber + "</td>" +
							"	<td id='bank_" + ReceivePaymentMethodRowCount + "'>" + bankName + "</td>" +
							"	<td id='cheque_date_" + ReceivePaymentMethodRowCount + "'>" + chequeDate + "</td>" +
                            "	<td id='card_type_" + ReceivePaymentMethodRowCount + "'>" + cardType + "</td>" +
							"	<td id='amount_" + ReceivePaymentMethodRowCount + "'>" + amount + "</td>" +
							"	<td><a class='btn btn-danger btn-xs delete' id='delete_receive_payment_method_" + ReceivePaymentMethodRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReceivePaymentMethod(this.id);'>" +
							"			<i class='icon-remove'></i>" +
							"		 </a></td>" +
							"	</tr>";

				$("#receive_payment_method_amount_total").before(html);
				$("#payment_method_amount_total").html(TransactionMethodAmountTotal.toFixed(2));
				$("#amount").val(TransactionMethodAmountTotal.toFixed(2));
				$("#receive_payment_method_records").show();

				var transactionAmountTotal = TransactionAmountTotal;
				transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(amount);
                TransactionAmountTotal = transactionAmountTotal;
				$("#amount_to_add_payment_type").val(transactionAmountTotal.toFixed(2));

				if (referenceTransactionType == '7') {
					if (TransactionMethodAmountTotal > 0) {
						$("#receive_payment_save_button").attr('disabled', false);
					}
				} else {
					if (partialPaymentAllowed == "Yes" || transactionAmountTotal == 0) {
						$("#receive_payment_save_button").attr('disabled', false);
					}
				}
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				html = "	<tr id='payment_method_row_edit_" + ReceivePaymentMethodRowCount + "'> " +
                            "   <input class='form-control' id='payment_account_id_edit_" + ReceivePaymentMethodRowCount + "' name='payment_account_id_edit_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + paymentAccountId + "'>" +
							"   <input class='form-control' id='bank_id_edit_" + ReceivePaymentMethodRowCount + "' name='bank_id_edit_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + bank + "'>" +
                            "   <input class='form-control' id='third_party_cheque_edit_" + ReceivePaymentMethodRowCount + "' name='third_party_cheque_edit_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + thirdPartyCheque + "'>" +
                            "   <input class='form-control' id='crossed_cheque_edit_" + ReceivePaymentMethodRowCount + "' name='crossed_cheque_edit_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + crossedCheque + "'>" +
                            "   <input class='form-control' id='cheque_deposit_account_id_edit_" + ReceivePaymentMethodRowCount + "' name='cheque_deposit_account_id_edit_" + ReceivePaymentMethodRowCount + "' type='hidden' value='" + chequeDepositPrimeEntryBookId + "'>" +
							"	<td id='receive_payment_method_edit_" + ReceivePaymentMethodRowCount + "'>" + paymentMethod + "</td>" +
							"	<td id='cheque_number_edit_" + ReceivePaymentMethodRowCount + "'>" + chequeNumber + "</td>" +
							"	<td id='bank_edit_" + ReceivePaymentMethodRowCount + "'>" + bankName + "</td>" +
							"	<td id='cheque_date_edit_" + ReceivePaymentMethodRowCount + "'>" + chequeDate + "</td>" +
                            "	<td id='card_type_edit_" + ReceivePaymentMethodRowCount + "'>" + cardType + "</td>" +
							"	<td id='amount_edit_" + ReceivePaymentMethodRowCount + "'>" + amount + "</td>" +
							"	<td><a class='btn btn-danger btn-xs delete' id='delete_receive_payment_method_edit_" + ReceivePaymentMethodRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReceivePaymentMethod(this.id);'>" +
							"			<i class='icon-remove'></i>" +
							"		 </a></td>" +
							"	</tr>";

				$("#receive_payment_method_amount_total_edit").before(html);
				$("#payment_method_amount_total_edit").html(TransactionMethodAmountTotal.toFixed(2));
				$("#amount_edit").val(TransactionMethodAmountTotal.toFixed(2));
				
				var transactionAmountTotal = TransactionAmountTotal;
				transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(amount);
                TransactionAmountTotal = transactionAmountTotal;
				$("#amount_to_add_payment_type_edit").val(transactionAmountTotal.toFixed(2));

				if (referenceTransactionType == '7') {
					if (TransactionMethodAmountTotal > 0) {
						$("#receive_payment_edit_button").attr('disabled', false);
					}
				} else {
					if (partialPaymentAllowed == "Yes" || transactionAmountTotal == 0) {
						$("#receive_payment_edit_button").attr('disabled', false);
					}
				}
			}
		},

		//get payer drop down
		getPayerData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToPeopleDropDownWithPeopleCode",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$('#payer_search_init').hide();
					$("#payer_search_dropdown").html(response);
					$("#payer_search_dropdown").find("#people_id").prop({ id: "payer_search_id"});
					$("#payer_search_id").select2();
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
					
					$('#location_search_init').hide();
					$("#location_search_dropdown").html(response);
					$("#location_search_dropdown").find("#people_id").prop({ id: "location_search_id"});
					$("#location_search_dropdown").find("#people_idError").prop({ id: "location_search_idError"});
				}
			})
		},
		
		getPayerList: function (payerType) {
		
			var type = "";
            var disableSelection = "";
            
			if (ReceivePaymentScreenOperationStatus == "Add") {
				type = "Add";
                disableSelection = "No";
			} else if (ReceivePaymentScreenOperationStatus == "View") {
				type = "View";
                disableSelection = "Yes";
			}
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getPeopleListAccordingToTheCategory",
				data: {
					'people_category' : payerType,
					'type' : type,
					'mandatory_field' : 'Yes',
					'get_with_all_option' : '',
					'get_with_label' : 'Yes',
					'label_col_position' : "3",
					'drop_down_col_position' : "4",
                    'disable_selection' : disableSelection,

					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					if (ReceivePaymentScreenOperationStatus == "Add") {
						$("#payer_list_div").show();
						$("#payer_list_div").empty();
						$("#payer_list_div").append(response);
						$("#payer_list_div").find("#sales_rep_id").prop({ id: "people_id"});
						$("#people_id").select2();
					} else if (ReceivePaymentScreenOperationStatus == "View") {
						$("#payer_list_div_edit").empty();
						$("#payer_list_div_edit").append(response);
						$("#payer_list_div_edit").find("#customer_dropdown").prop({ id: "customer_dropdown_edit"});
						$("#people_id_edit").select2();
					}
				}
			})
		},
        
        getPurchaseNotesDropDown : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/purchase_note_controller/getAllPurchaseNotesToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
                    $('#purchase_note_init').hide();
                    $("#purchase_note_dropdown").empty();
                    $("#purchase_note_dropdown").html(response);
                    $("#purchase_note_id").select2();
				}
			})
		},
        
        getSalesNotesDropDown : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/sales_note_controller/getAllSalesNotesToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
                    $('#sales_note_init').hide();
                    $("#sales_note_dropdown").empty();
                    $("#sales_note_dropdown").html(response);
                    $("#sales_note_id").select2();
				}
			})
		},
        
        getCustomerReturnNotesDropDown : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller/getAllCustomerReturnNotesToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
                    $('#customer_return_note_init').hide();
                    $("#customer_return_note_dropdown").empty();
                    $("#customer_return_note_dropdown").html(response);
                    $("#customer_return_note_id").select2();
				}
			})
		},
        
        getSupplierReturnNotesDropDown : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/supplier_return_note_controller/getAllSupplierReturnNotesToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
                    $('#supplier_return_note_init').hide();
                    $("#supplier_return_note_dropdown").empty();
                    $("#supplier_return_note_dropdown").html(response);
                    $("#supplier_return_note_id").select2();
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
					if (ReceivePaymentScreenOperationStatus == "Add") {
						$('#bank_init').hide();
						$("#bank_dropdown").empty();
						$("#bank_dropdown").html(response);
					} else if (ReceivePaymentScreenOperationStatus == "View") {
						$('#bank_init_edit').hide();
						$("#bank_dropdown_edit").empty();
						$("#bank_dropdown_edit").html(response);
						$("#bank_dropdown_edit").find("#bank_id").prop({ id: "bank_id_edit"});
					}
				}
			})
		},
        
        handleIncludeBankChargeSelect : function (selected, id) {
		
            var creditCardPaymentAmount = '0';
            
            if (ReceivePaymentScreenOperationStatus == "Add") {
                creditCardPaymentAmount = $("#credit_card_payment_amount").val();
            } else if (ReceivePaymentScreenOperationStatus == "View") {
                creditCardPaymentAmount = $("#credit_card_payment_amount_edit").val();
            }
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller/handleIncludeBankChargeSelect",
				data: {
					'credit_card_payment_amount' : creditCardPaymentAmount,
					'selected' : selected,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
                    if (ReceivePaymentScreenOperationStatus == "Add") {
                        $('#total_card_payment').val(response);
                    } else if (ReceivePaymentScreenOperationStatus == "View") {
                        $('#total_card_payment_edit').val(response);
                    }
				}
			});
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
                    if (ReceivePaymentScreenOperationStatus =="Add") {
                        $('#cheque_deposit_account_init').hide();
                        $("#cheque_deposit_account_dropdown").empty();
                        $("#cheque_deposit_account_dropdown").html(response.chequeDepositAccountList);
                    } else if (ReceivePaymentScreenOperationStatus == "View") {
                        $('#cheque_deposit_account_init_edit').hide();
                        $("#cheque_deposit_account_dropdown_edit").empty();
                        $("#cheque_deposit_account_dropdown_edit").html(response.chequeDepositAccountList);
                        $("#cheque_deposit_account_dropdown_edit").find("#cheque_deposit_account_id").prop({ id: "cheque_deposit_account_id_edit"});
                    }
				}
			});
		},
        
        //get card payment account drop down
		getCardPaymentAccountData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getCardPaymentAccountData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					if (ReceivePaymentScreenOperationStatus == "Add") {
						$('#payment_account_init').hide();
						$("#payment_account_dropdown").empty();
						$("#payment_account_dropdown").html(response.paymentAccountList);
					} else if (ReceivePaymentScreenOperationStatus == "View") {
						$('#payment_account_init_edit').hide();
						$("#payment_account_dropdown_edit").empty();
						$("#payment_account_dropdown_edit").html(response.paymentAccountList);
						$("#payment_account_dropdown_edit").find("#payment_account_id").prop({ id: "payment_account_id_edit"});
					}
				}
			});
		},

		init : function () {
			$("#table").show();
			$("#cheque_details_div").hide();
			$("#reference_transaction_section_div").hide();
			$("#reference_transaction_div").hide();
			$("#reference_journal_entry_div").hide();
			$("#receive_payment_details_form").hide();
			ReceivePayment.hideMessageDisplay();
			$("#remark").val('');
		},

		hideMessageDisplay : function () {
			$(".msg_data").hide();
			$(".modal_msg_data").hide();
			$(".modal_msg_data").hide();
			$(".msg_data_receive_payment_search").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		}
	}
    
    //form validation save
	function validateCashPaymentMethod_add() {
		return (isNotEmpty("cash_payment_amount", "<?php echo $this->lang->line('Cash Payment').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("cash_payment_amount", "<?php echo $this->lang->line('Cash Payment').' '.$this->lang->line('is not valid')?>")
		);
	}
    
    //form validation edit
	function validateCashPaymentMethod_edit() {
		return (isNotEmpty("cash_payment_amount_edit", "<?php echo $this->lang->line('Cash Payment').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("cash_payment_amount_edit", "<?php echo $this->lang->line('Cash Payment').' '.$this->lang->line('is not valid')?>")
		);
	}
    
    //form validation save
	function validateChequePaymentMethod_add() {
		return (isNotEmpty("cheque_number", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("bank_id", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("cheque_date", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("cheque_payment_amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//form validation edit
	function validateChequePaymentMethod_edit() {
		return (isNotEmpty("cheque_number_edit", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("bank_id_edit", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("cheque_date_edit", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("cheque_payment_amount_edit", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
    
    //form validation save
    function validateCardPaymentMethod_add() {
        return (isSelected("payment_account_id", "<?php echo $this->lang->line('Payment Account').' '.$this->lang->line('field is required')?>")
            && isFlootPositive("credit_card_payment_amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
    }
    
    //form validation edit
    function validateCardPaymentMethod_edit() {
        return (isSelected("payment_account_id_edit", "<?php echo $this->lang->line('Payment Account').' '.$this->lang->line('field is required')?>")
            && isFlootPositive("credit_card_payment_amount_edit", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
    }

	//form validation save
	function validateForm_save() {
		return (isNotEmpty("reference_no", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("receive_payment_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("payer_type", "<?php echo $this->lang->line('Payer Type').' '.$this->lang->line('field is required')?>")
			&& isSelected("people_id", "<?php echo $this->lang->line('Payer').' '.$this->lang->line('field is required')?>")
			&& isSelected("location", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
		);
	}

	//form validation edit
	function validateForm_edit() {
		return (isNotEmpty("reference_no_edit", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("receive_payment_date_edit", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("payer_type_edit", "<?php echo $this->lang->line('Payer Type').' '.$this->lang->line('field is required')?>")
			&& isSelected("people_id_edit", "<?php echo $this->lang->line('Payer').' '.$this->lang->line('field is required')?>")
			&& isSelected("location_edit", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
		);
	}
	
	function validateReferenceTransaction_save() {
		<?php if ($force_to_select_a_reference_transaction_for_receive_a_payment) { ?>
				if ($("#reference_transaction_type_id").val() != "7") {
					return (isSelected("reference_transaction_type_id", "<?php echo $this->lang->line('Reference Transaction Type').' '.$this->lang->line('field is required')?>")
						&& isSelected("reference_transaction_id", "<?php echo $this->lang->line('Reference Transaction').' '.$this->lang->line('field is required')?>")
						&& isSelected("reference_journal_entry_id", "<?php echo $this->lang->line('Reference Journal Entry').' '.$this->lang->line('field is required')?>")
					);
				} else {
					return (isSelected("reference_transaction_type_id", "<?php echo $this->lang->line('Reference Transaction Type').' '.$this->lang->line('field is required')?>")
						&& isSelected("reference_journal_entry_id", "<?php echo $this->lang->line('Reference Journal Entry').' '.$this->lang->line('field is required')?>")
					);
				}
		<?php } else { ?>
				return true;
		<?php } ?>
	}
	
	function validateReferenceTransaction_edit() {
		<?php if ($force_to_select_a_reference_transaction_for_receive_a_payment) { ?>
				if ($("#reference_transaction_type_id_edit").val() != "7") {
					return (isSelected("reference_transaction_type_id_edit", "<?php echo $this->lang->line('Reference Transaction Type').' '.$this->lang->line('field is required')?>")
						&& isSelected("reference_transaction_id_edit", "<?php echo $this->lang->line('Reference Transaction').' '.$this->lang->line('field is required')?>")
						&& isSelected("reference_journal_entry_id_edit", "<?php echo $this->lang->line('Reference Journal Entry').' '.$this->lang->line('field is required')?>")
					);
				} else {
					return (isSelected("reference_transaction_type_id_edit", "<?php echo $this->lang->line('Reference Transaction Type').' '.$this->lang->line('field is required')?>")
						&& isSelected("reference_journal_entry_id_edit", "<?php echo $this->lang->line('Reference Journal Entry').' '.$this->lang->line('field is required')?>")
					);
				}
		<?php } else { ?>
				return true;
		<?php } ?>
	}
	
	function validateCheque_save() {
		if ($("#cheque_payment").prop("checked") == true) {
			return (isNotEmpty("cheque_number", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
				&& isNotEmpty("bank", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
				&& isSelected("cheque_date", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			);
		} else {
			return true;
		}
	}
	
	function validateCheque_edit() {
		if ($("#cheque_payment_edit").prop("checked") == true) {
			return (isNotEmpty("cheque_number_edit", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
				&& isNotEmpty("bank_edit", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
				&& isSelected("cheque_date_edit", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			);
		} else {
			return true;
		}
	}

	//get all data
	function getTableData(year, month, payerId, locationId, purchaseNoteId, salesNoteId, customerReturnNoteId, supplierReturnNoteId){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/receive_payment_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
				'payer_id' : payerId,
				'location_id' : locationId,
                'purchase_note_id' : purchaseNoteId,
                'sales_note_id' : salesNoteId,
                'customer_return_note_id' : customerReturnNoteId,
                'supplier_return_note_id' : supplierReturnNoteId,
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
				
				$('.receivePaymentDataTable').dataTable({
					"aaSorting": [[ 1, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		})
	}

	function clearForm(){
		$("#reference_no").val('');
		$("#receive_payment_date").val(moment().format('YYYY-MM-DD'));
		$("#payer_type").val('');
		$("#people_id").val('0').trigger('change');
        $("#payer_list_div").hide();
		$("#location").val('0');
		
		$("#reference_transaction_type_id").val('0');
		
		$("#reference_transaction_id").select2("destroy");
		$("#reference_transaction_id").empty();
		$("#reference_transaction_id").val('0');
		$("#reference_transaction_id").select2();
		$("#reference_transaction_div").hide();
		
		$("#reference_journal_entry_id").select2("destroy");
		$("#reference_journal_entry_id").empty();
		$("#reference_journal_entry_id").val('0');
		$("#reference_journal_entry_id").select2();
		$("#reference_journal_entry_div").hide();
		
        var referenceTransactionElement = $("#receive_payment_reference_list").find("#reference_transaction_type_1");

		var referenceTransactionCount = 1;
		var moreElement = true;
		while (moreElement) {
			if (referenceTransactionElement.length == 1) {
				$("#row_" + referenceTransactionCount).remove();
				referenceTransactionCount++;
				referenceTransactionElement = $("#receive_payment_reference_list").find("#reference_transaction_type_" + referenceTransactionCount);
			} else {
				moreElement = false;
			}
		}
		
        var rowCount = 1;
        var receivePaymentMethodElement = $("#receive_payment_method_records").find("#payment_method_row_" + rowCount);

        var moreElement = true;
        while (moreElement) {
            if (receivePaymentMethodElement.length == 1) {
                $("#payment_method_row_" + rowCount).remove();
                rowCount++;
                receivePaymentMethodElement = $("#receive_payment_method_records").find("#payment_method_row_" + rowCount);
            } else {
                moreElement = false;
            }
        }
		
		$("#receive_payment_reference_list").hide();
		$("#receive_payment_method_list").hide();
		$("#receive_payment_method_records").hide();
		
		TransactionAmountTotal = 0;
		TransactionMethodAmountTotal = 0;
		ReferenceTransactionRowCount = 0;
		ReceivePaymentMethodRowCount = 0;
		SelectedReferenceTransactionList = [];
		
		$("#amount").val('');
		$("#remark").val('');
	}
</script>
