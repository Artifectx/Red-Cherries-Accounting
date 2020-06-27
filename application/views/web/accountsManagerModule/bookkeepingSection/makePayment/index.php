<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Make Payment') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
				<div class="msg_delete"></div>
                <div class='msg_instant' align="center"></div>
				<div class='form' id="make_payment_details_form">
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-content'>
									<div class='validation'></div>
									<div class='box' id="add_make_payment_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div class='title'><?php echo $this->lang->line('Add Make Payment') ?></div>
											<div class='actions'>
												<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
												</a>
											</div>
										</div>
										<div class='box-content'>
											<form class='form form-horizontal validate-form save_form' method="post">
												<input class='form-control' id='make_payment_id' name='make_payment_id' type='hidden'>
												
												<div class='form-group'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference No') ?> *</label>
													<div class='col-sm-4 controls' id="reference_no_div">
														<input class='form-control' id='reference_no' name='reference_no'
															   placeholder='<?php echo $this->lang->line('Reference No') ?>' type='text' 
															   value="<?php echo set_value('reference_no'); ?>"
															   <?php if ($make_payment_no_auto_increment_status) { echo 'readonly';}?>>
														<div id="reference_noError" class="red"></div>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Date') ?> *</label>
													<div class='col-sm-4 controls'>
														<div class='datepicker-input input-group' id='datepicker_make_payment_date'>
															<input class='form-control' id='make_payment_date' name='make_payment_date'
																   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
															  <span class="input-group-addon">
																	<span class="glyphicon glyphicon-calendar"/>
															  </span>
														</div>
														<div id="make_payment_dateError" class="red"></div>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Payee Type') ?> *</label>
													<div class='col-sm-4 controls' id="payee_type_div">
														<select class='form-control' name='payee_type' id='payee_type' onchange="getPeopleType(this.id);">
															<option value=''><?php echo $this->lang->line('-- Select --');?></option>
															<?php
															foreach($peopleType as $row){
																?>
																<option value='<?php echo $row['people_type'];?>'><?php echo $row['people_type'];?></option>
															<?php
															}
															?>
														</select>
														<div id="payee_typeError" class="red"></div>
													</div>
												</div>
												<div class='form-group' id="payee_list_div">
																	
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
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Transaction Type') ?></label>
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
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Transaction') ?></label>
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
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Journal Entry') ?></label>
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
												
												<div id="make_payment_reference_list">
													<h4><?php echo $this->lang->line('Reference Transactions') ?></h4>
													<div class='box-content box-no-padding out-table'>
														<div class='table-responsive table_data'>
															<div class='scrollable-area1'>
																<table class='table table-striped table-bordered makePaymentReferenceDataTable' style='margin-bottom:0;'>
																	<thead>
																		<tr>
																			<th><?php echo $this->lang->line('Reference Transaction') ?></th>
																			<th><?php echo $this->lang->line('Reference Journal Entry') ?></th>
																			<th><?php echo $this->lang->line('Transaction Amount') ?></th>
																			<th><?php echo $this->lang->line('Actions') ?></th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr id="make_payment_reference_amount_total">		
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
												
												<div class='box' id="make_payment_method_list">
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
																	<a data-toggle='tab' class="tab-header" href='#second_party_cheque_payment'><?php echo $this->lang->line('Second Party Cheque Payment') ?></a>
																</li>
																<li class=''>
																	<a data-toggle='tab' class="tab-header" href='#third_party_cheque_payment'><?php echo $this->lang->line('Third Party Cheque Payment') ?></a>
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
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Payment Account') ?> *</label>
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
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount') ?> *</label>
																		<div class='col-sm-4 controls'>
																			<input class='form-control input-sm' id='cheque_payment_amount' name='cheque_payment_amount' placeholder='<?php echo $this->lang->line('Amount')?>' type='text'>
																			<div id="cheque_payment_amountError" class="red"></div>
																		</div>
																		<br><br>
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
																</div>
																<div id="second_party_cheque_payment" class="tab-pane">
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Second Party Cheque Number') ?> *</label>
																		<div class='col-sm-4 controls'>
																			<select id="second_party_cheque_number_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																			<!--Second party cheque number drop down-->
																			<div id="second_party_cheque_number_dropdown">
																			</div>
																			<!--End payment account drop down-->
																			<div id="second_party_cheque_idError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
                                                                        <input class='form-control' id='second_party_cheque_bank_id' name='second_party_cheque_bank_id' type='hidden'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Bank') ?></label>
																		<div class='col-sm-4 controls' id="bank_div">
																			<input class='form-control' id='second_party_cheque_bank' name='second_party_cheque_bank'
																				   placeholder='<?php echo $this->lang->line('Bank') ?>' type='text' 
																				   value="<?php echo set_value('bank'); ?>" disabled>
																			<div id="second_party_cheque_bankError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Cheque Date') ?></label>
																		<div class='col-sm-4 controls' id="second_party_cheque_date_div">
																			<div class='datepicker-input input-group' id='datepicker_second_party_cheque_date'>
																				<input class='form-control' id='second_party_cheque_date' name='second_party_cheque_date'
																					   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Cheque Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>" disabled>
																				  <span class="input-group-addon">
																						<span class="glyphicon glyphicon-calendar"/>
																				  </span>
																			</div>
																			<div id="second_party_cheque_dateError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount') ?></label>
																		<div class='col-sm-4 controls'>
																			<input class='form-control input-sm' id='second_party_cheque_payment_amount' name='second_party_cheque_payment_amount' placeholder='<?php echo $this->lang->line('Amount')?>' type='text' disabled>
																			<div id="second_party_cheque_payment_amountError" class="red"></div>
																		</div>
																		<br><br>
																		<div class='form-group'>
																			<div class='col-sm-9 col-sm-offset-4'>
																				<button class='btn btn-success save'
																						onclick='addSecondPartyChequePayment();' type='button'>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Add') ?>
																				</button>
																			</div>
																		</div>
																	</div>
																</div>
																<div id="third_party_cheque_payment" class="tab-pane">
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Third Party Cheque Number') ?> *</label>
																		<div class='col-sm-4 controls'>
																			<select id="third_party_cheque_number_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																			<!--Third party cheque number drop down-->
																			<div id="third_party_cheque_number_dropdown">
																			</div>
																			<!--End payment account drop down-->
																			<div id="third_party_cheque_idError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
                                                                        <input class='form-control' id='third_party_cheque_bank_id' name='third_party_cheque_bank_id' type='hidden'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Bank') ?></label>
																		<div class='col-sm-4 controls' id="bank_div">
																			<input class='form-control' id='third_party_cheque_bank' name='third_party_cheque_bank'
																				   placeholder='<?php echo $this->lang->line('Bank') ?>' type='text' 
																				   value="<?php echo set_value('bank'); ?>" disabled>
																			<div id="third_party_cheque_bankError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Cheque Date') ?></label>
																		<div class='col-sm-4 controls' id="third_party_cheque_date_div">
																			<div class='datepicker-input input-group' id='datepicker_third_party_cheque_date'>
																				<input class='form-control' id='third_party_cheque_date' name='third_party_cheque_date'
																					   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Cheque Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>" disabled>
																				  <span class="input-group-addon">
																						<span class="glyphicon glyphicon-calendar"/>
																				  </span>
																			</div>
																			<div id="third_party_cheque_dateError" class="red"></div>
																		</div>
																	</div>
																	<div class='form-group'>
																		<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount') ?></label>
																		<div class='col-sm-4 controls'>
																			<input class='form-control input-sm' id='third_party_cheque_payment_amount' name='third_party_cheque_payment_amount' placeholder='<?php echo $this->lang->line('Amount')?>' type='text' disabled>
																			<div id="third_party_cheque_payment_amountError" class="red"></div>
																		</div>
																		<br><br>
																		<div class='form-group'>
																			<div class='col-sm-9 col-sm-offset-4'>
																				<button class='btn btn-success save'
																						onclick='addThirdPartyChequePayment();' type='button'>
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
												
												<div id="make_payment_method_records">
													<h4><?php echo $this->lang->line('Payment Method List') ?></h4>
													<div class='box-content box-no-padding out-table'>
														<div class='table-responsive table_data'>
															<div class='scrollable-area1'>
																<table class='table table-striped table-bordered makePaymentMethodDataTable' style='margin-bottom:0;'>
																	<thead>
																		<tr>
																			<th><?php echo $this->lang->line('Payment Method') ?></th>
																			<th><?php echo $this->lang->line('Cheque Number') ?></th>
																			<th><?php echo $this->lang->line('Bank') ?></th>
																			<th><?php echo $this->lang->line('Cheque Date') ?></th>
																			<th><?php echo $this->lang->line('Amount') ?></th>
																			<th><?php echo $this->lang->line('Actions') ?></th>
																		</tr>
																	</thead>
																	<tbody id="make_payment_method_record_rows">
																		<tr id="make_payment_method_amount_total">		
																			<td><?php echo $this->lang->line('Total') ?></td>
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
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount') ?></label>
													<div class='col-sm-4 controls' id="amount_div">
														<input class='form-control' id='amount' name='amount'
															   placeholder='<?php echo $this->lang->line('Amount') ?>' type='text' 
															   value="<?php echo set_value('amount'); ?>" disabled>
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
															if (isset($ACM_Bookkeeping_Add_Make_Payment_Permissions)){
																?>
																<button class='btn btn-success save'
																		onclick='saveData();' type='button' id="make_payment_save_button">
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
									<div class='box' id="edit_make_payment_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div id ="make_payment_edit_box_title" class='title'><?php echo $this->lang->line('Edit Make Payment') ?></div>
											<div class='actions'>
												<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
												</a>
											</div>
										</div>
										<div class='box-content' id="edit_make_payment_form_content">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Product search form -->
				<div class='msg_data_make_payment_search'></div>
				<form class='form form-horizontal validate-form' id="search_make_payment_form">
					<div class='box'>
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Search Make Payments') ?></div>
						</div>
						<div class='box-content'>
							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<label class='control-label col-sm-3 col-sm-3' ><?php echo $this->lang->line('Payee') ?></label>
									<label class='control-label col-sm-3 col-sm-5' ><?php echo $this->lang->line('Location') ?></label>
								</div>
							</div>

							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<div class='col-sm-5 controls'>
										<select id="payee_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="payee_search_dropdown"></div>
										<div id="payee_search_idError" class="red"></div>
									</div>
									<div class='col-sm-5 controls'>
										<select id="location_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="location_search_dropdown"></div>
										<div id="location_search_idError" class="red"></div>
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
								if (isset($ACM_Bookkeeping_Add_Make_Payment_Permissions)){
									echo "<a class='btn btn-success btn-sm new'>{$this->lang->line('Add New Make Payment') }</a>";
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

	var MakePaymentScreenOperationStatus = 'Add';
	var TransactionAmountTotal = 0;
	var TransactionMethodAmountTotal = 0;
	var ReferenceTransactionRowCount = 0;
	var MakePaymentMethodRowCount = 0;
	var SelectedReferenceTransactionList = [];
	
	$(document).ready(function () {
		
        $(".msg_instant").hide();
        
		$("#datepicker_make_payment_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$("#datepicker_cheque_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});

		MakePayment.getPayeeData();
		MakePayment.getLocationData();
		MakePayment.getPaymentAccountData();
		MakePayment.getBankData();
		MakePayment.getSecondPartyChequeNumbersData();
		MakePayment.getThirdPartyChequeNumbersData();
		
		var date = new Date();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		
		var monthName = moment.months(month - 1);
		$("#month_name").text(monthName + "  " + year);
		$("#current_month").val(month);
		$("#current_year").val(year);
		
		getTableData(year, month, "", "");
		MakePayment.init();
	});

	$(".new").click(function () {
		clearForm();
		MakePaymentScreenOperationStatus = "Add";
		MakePayment.getNextReferenceNo();
		MakePayment.getSecondPartyChequeNumbersData();
		MakePayment.getThirdPartyChequeNumbersData();
		MakePayment.hideMessageDisplay();
		$("#cash_payment").prop("checked", true)
		$("#make_payment_details_form").show();
		$("#add_make_payment_form").show();
		$(".save_form").show();
		$("#edit_make_payment_form").hide();
		$("#search_make_payment_form").hide();
		$("#make_payment_save_button").attr('disabled', true);
		MakePayment.getReferenceTransactionTypesDropdown();
		
		<?php if ($force_to_select_a_reference_transaction_for_make_a_payment) { ?>
			$("#reference_transaction_section_div").show();
		<?php } ?>
			
		$('.makePaymentReferenceDataTable').dataTable();
		$('.makePaymentMethodDataTable').dataTable();
		$("#make_payment_reference_list").hide();
		$("#make_payment_method_list").hide();
		$("#make_payment_method_records").hide();
        
        var payeeType = '<?php echo $default_payee_type; ?>';
        
        if (payeeType != '' && payeeType != '0') {
            
            $("#payee_type").val(payeeType);
            
            MakePayment.getPayeeList(payeeType, "");
        }
        
        var html = '<tr id="make_payment_method_amount_total">'+		
                        '<td><?php echo $this->lang->line('Total') ?></td>'+
                        '<td></td>'+
                        '<td></td>'+
                        '<td></td>'+
                        '<td id="payment_method_amount_total"></td>'+
                        '<td></td>'+
                   '</tr>';
           
        $("#make_payment_method_record_rows").empty();
        $("#make_payment_method_record_rows").html(html);
	});

	function cancelData() {
		MakePayment.cancelData();
	}

	function closeMakePaymentEditForm() {
		MakePayment.closeMakePaymentEditForm();
		window.scrollTo(0,0);
	}

	function saveData() {
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			MakePayment.saveData();
			window.scrollTo(0,0);
		}
	}

	function editMakePaymentData(id) {
		if (validateForm_edit()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			MakePayment.editMakePaymentData(id);
			window.scrollTo(0,0);
		}
	}

	function getMakePaymentData(id){
		$(".loader").show();
		MakePaymentScreenOperationStatus = "View";
		MakePayment.hideMessageDisplay();
		MakePayment.getMakePaymentData(id);
		window.scrollTo(0,0);
	}

	function del(id){
		MakePayment.hideMessageDisplay();
		MakePayment.deleteData(id);
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
	
	function searchData() {
		var payeeId = $("#payee_search_id").val();
		var locationId = $("#location_search_id").val();
		getTableData("", "", payeeId, locationId);
	}
	
	function getPeopleType(id) {
		var payeeType = $("#" + id).val();
		
        if (payeeType != '') {
            MakePayment.getPayeeList(payeeType, "");
        } else {
            $("#payee_list_div").hide();
        }
	}
	
	function handleReferenceTransactionTypeSelect(id) {
		var peopleId = '';
        var locationId = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
			peopleId = $("#people_id").val();
            locationId = $("#location").val();
		} else if (MakePaymentScreenOperationStatus == "View") {
			peopleId = $("#people_id_edit").val();
            locationId = $("#location_edit").val();
		}
		
		MakePayment.getReferenceTransactionListForSelectedType($("#" + id).val(), peopleId, locationId);
	}
	
	function handleReferenceTransactionSelect(id) {
		if (MakePaymentScreenOperationStatus == "Add") {
            MakePayment.getReferenceJournalEntryListForSelectedTransaction($("#reference_transaction_type_id").val(), $("#" + id).find('option:selected').text());
		} else if (MakePaymentScreenOperationStatus == "View") {
			MakePayment.getReferenceJournalEntryListForSelectedTransaction($("#reference_transaction_type_id_edit").val(), $("#" + id).find('option:selected').text());
		}
	}
	
	function handleLocationSelect() {
		
	}
	
	function handleCustomerSelection() {
		
	}
	
	function handleSupplierSelect(id) {
		var supplierId = $("#" + id).val();
		var referenceTransactionTypeId = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
			referenceTransactionTypeId = $("#reference_transaction_type_id").val();
		} else if (MakePaymentScreenOperationStatus == "View") {
			referenceTransactionTypeId = $("#reference_transaction_type_id_edit").val();
		}
		
		if (referenceTransactionTypeId != '0') {
			MakePayment.getReferenceTransactionListForSelectedType(referenceTransactionTypeId, supplierId);
		}
        
        var referenceTransactionType = '<?php echo $default_reference_transaction_type; ?>';
       
        if (referenceTransactionType != '' && referenceTransactionType != '0') {
            
            $("#reference_transaction_type_id").val(referenceTransactionType);
            
            var peopleId = '';
		
            if (MakePaymentScreenOperationStatus == "Add") {
                peopleId = $("#people_id").val();
            } else if (MakePaymentScreenOperationStatus == "View") {
                peopleId = $("#people_id_edit").val();
            }

            MakePayment.getReferenceTransactionListForSelectedType(referenceTransactionType, peopleId);
        }
	}
	
	function addReferenceTransaction() {
		var referenceTransactionType = '';
		var referenceTransactionId = '';
		var referenceJournalEntryId = '';
		var referenceTransaction = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
			referenceTransactionType = $("#reference_transaction_type_id").val();
			referenceTransactionId = $("#reference_transaction_id").val();
			referenceJournalEntryId = $("#reference_journal_entry_id").val();
			referenceTransaction = $("#reference_transaction_id option:selected").text();
		} else if (MakePaymentScreenOperationStatus == "View") {
			referenceTransactionType = $("#reference_transaction_type_id_edit").val();
			referenceTransactionId = $("#reference_transaction_id_edit").val();
			referenceJournalEntryId = $("#reference_journal_entry_id_edit").val();
			referenceTransaction = $("#reference_transaction_id_edit option:selected").text();
		}
		
		if (!SelectedReferenceTransactionList.includes(referenceTransaction)) {
			MakePayment.selectReferenceJournalEntry(referenceTransactionType, referenceTransactionId, referenceJournalEntryId);
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
	
		if (MakePaymentScreenOperationStatus == "Add") {
			
			rowCount = id.substring(29,31);
			
			referenceTransactionType = $("#reference_transaction_type_" + rowCount).val();
			referenceTransaction = $("#reference_transaction_" + rowCount).html();
			referenceTrannsactionAmount = $("#reference_transaction_amount_" + rowCount).html().replace(",", "");
//			referenceTrannsactionAmount = referenceTrannsactionAmount.replace("(", "");
//			referenceTrannsactionAmount = referenceTrannsactionAmount.replace(")", "");
			
			if (referenceTransactionType == '1' || referenceTransactionType == '4' || referenceTransactionType == '5') {
				TransactionAmountTotal = TransactionAmountTotal - parseFloat(referenceTrannsactionAmount);
			} else if (referenceTransactionType == '2' || referenceTransactionType == '3') {
				TransactionAmountTotal = TransactionAmountTotal + parseFloat(referenceTrannsactionAmount);
			}
			
			ReferenceTransactionRowCount--;
			$("#row_" + rowCount).remove();
			$("#reference_amount_total").html(TransactionAmountTotal.toFixed(2));

			transactionAmountTotal = TransactionAmountTotal;
			//transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(TransactionMethodAmountTotal);
			$("#amount_to_add_payment_type").val(transactionAmountTotal.toFixed(2));
			
			rowCount++;
			var referenceTransactionElement = $("#make_payment_reference_list").find("#row_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (referenceTransactionElement.length == 1) {
					
					$("#make_payment_reference_list").find("#row_" + rowCount).prop({ id: "row_" + (rowCount - 1)});
					$("#make_payment_reference_list").find("#reference_transaction_type_" + rowCount).prop({ id: "reference_transaction_type_" + (rowCount - 1)});
					$("#make_payment_reference_list").find("#reference_transaction_id_" + rowCount).prop({ id: "reference_transaction_id_" + (rowCount - 1)});
					$("#make_payment_reference_list").find("#reference_journal_entry_id_" + rowCount).prop({ id: "reference_journal_entry_id_" + (rowCount - 1)});
					$("#make_payment_reference_list").find("#reference_transaction_" + rowCount).prop({ id: "reference_transaction_" + (rowCount - 1)});
					$("#make_payment_reference_list").find("#reference_transaction_amount_" + rowCount).prop({ id: "reference_transaction_amount_" + (rowCount - 1)});
					$("#make_payment_reference_list").find("#reference_transaction_balance_amount_" + rowCount).prop({ id: "reference_transaction_balance_amount_" + (rowCount - 1)});
                    $("#make_payment_reference_list").find("#delete_reference_transaction_" + rowCount).prop({ id: "delete_reference_transaction_" +  (rowCount - 1)});
					
					rowCount++;
					referenceTransactionElement = $("#make_payment_reference_list").find("#row_" + rowCount);
				} else {
					moreElement = false;
				}
			}
			
            if (TransactionMethodAmountTotal == 0 || TransactionAmountTotal <= 0) {
                $("#make_payment_save_button").attr('disabled', true);
            }
		} else if (MakePaymentScreenOperationStatus == "View") {
			
			rowCount = id.substring(34,36);
			
			referenceTransactionType = $("#reference_transaction_type_edit_" + rowCount).val();
			referenceTransaction = $("#reference_transaction_edit_" + rowCount).html();
			referenceTrannsactionAmount = $("#reference_transaction_amount_edit_" + rowCount).val().replace(",", "");
//			referenceTrannsactionAmount = referenceTrannsactionAmount.replace("(", "");
//			referenceTrannsactionAmount = referenceTrannsactionAmount.replace(")", "");
			
			if (referenceTransactionType == '1' || referenceTransactionType == '4' || referenceTransactionType == '5') {
				TransactionAmountTotal = TransactionAmountTotal - parseFloat(referenceTrannsactionAmount);
			} else if (referenceTransactionType == '2' || referenceTransactionType == '3') {
				TransactionAmountTotal = TransactionAmountTotal + parseFloat(referenceTrannsactionAmount);
			}
			
			ReferenceTransactionRowCount--;
			$("#row_edit_" + rowCount).remove();
			$("#reference_amount_total_edit").html(TransactionAmountTotal.toFixed(2));

			transactionAmountTotal = TransactionAmountTotal;
			//transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(TransactionMethodAmountTotal);
			$("#amount_to_add_payment_type_edit").val(transactionAmountTotal.toFixed(2));
			
			rowCount++;
			var referenceTransactionElement = $("#make_payment_reference_list_edit").find("#row_edit_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (referenceTransactionElement.length == 1) {
					
					$("#make_payment_reference_list_edit").find("#row_edit_" + rowCount).prop({ id: "row_edit_" + (rowCount - 1)});
					$("#make_payment_reference_list_edit").find("#reference_transaction_type_edit_" + rowCount).prop({ id: "reference_transaction_type_edit_" + (rowCount - 1)});
					$("#make_payment_reference_list_edit").find("#reference_transaction_id_edit_" + rowCount).prop({ id: "reference_transaction_id_edit_" + (rowCount - 1)});
					$("#make_payment_reference_list_edit").find("#reference_journal_entry_id_edit_" + rowCount).prop({ id: "reference_journal_entry_id_edit_" + (rowCount - 1)});
					$("#make_payment_reference_list_edit").find("#reference_transaction_edit_" + rowCount).prop({ id: "reference_transaction_edit_" + (rowCount - 1)});
					$("#make_payment_reference_list_edit").find("#reference_transaction_amount_edit_" + rowCount).prop({ id: "reference_transaction_amount_edit_" + (rowCount - 1)});
					$("#make_payment_reference_list_edit").find("#reference_transaction_balance_amount_edit_" + rowCount).prop({ id: "reference_transaction_balance_amount_edit_" + (rowCount - 1)});
                    $("#make_payment_reference_list_edit").find("#delete_reference_transaction_edit_" + rowCount).prop({ id: "delete_reference_transaction_edit_" +  (rowCount - 1)});
					
					rowCount++;
					referenceTransactionElement = $("#make_payment_reference_list_edit").find("#row_edit_" + rowCount);
				} else {
					moreElement = false;
				}
			}
			
            if (TransactionMethodAmountTotal == 0 || TransactionAmountTotal <= 0) {
                $("#make_payment_edit_button").attr('disabled', true);
            }
		}
		
		var index = SelectedReferenceTransactionList.indexOf(referenceTransaction);
		if (index > -1) {
			SelectedReferenceTransactionList.splice(index, 1);
		}
	}
	
	function handleReferenceJournalEntrySelect(id) {
		if ($("#" + id).val() != '0') {
			if (MakePaymentScreenOperationStatus == "Add") {
				$("#add_reference_transaction").attr('disabled', false);
			} else if (MakePaymentScreenOperationStatus == "View") {
				$("#add_reference_transaction_edit").attr('disabled', false);
			}
		} else {
            if (MakePaymentScreenOperationStatus == "Add") {
                $("#add_reference_transaction").attr('disabled', true);
            } else if (MakePaymentScreenOperationStatus == "View") {
                $("#add_reference_transaction_edit").attr('disabled', true);
            }
        }
	}
	
	function addCashPayment() {
		
		var referenceTransactionType = '';
		var cashPaymentAmount = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
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

			if (validateCashPaymentMethod_add()) {
				$("#cash_payment_amount").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, '', '', '', '', '', '', '', '', '', referenceTransactionType);
			}
		} else if (MakePaymentScreenOperationStatus == "View") {
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

			if (validateCashPaymentMethod_edit()) {
				$("#cash_payment_amount_edit").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, '', '', '', '', '', '', '', '', '', referenceTransactionType);
			}
		}
	}
	
	function addChequePayment() {
		
		var referenceTransactionType = '';
		var paymentAccountId = '';
		var chequeNumber = '';
		var bank = '';
		var bankName = '';
		var chequeDate = '';
		var chequePaymentAmount = '';
		var cashPaymentAmount = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
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
			paymentAccountId = $("#payment_account_id").val();
			chequeNumber = $("#cheque_number").val();
			bank = $("#bank_id").val();
			bankName = $("#bank_id option:selected").text();
			chequeDate = $("#cheque_date").val();
			chequePaymentAmount = $("#cheque_payment_amount").val();
			cashPaymentAmount = '0';

			if (validateChequePaymentMethod_add()) {
				$("#payment_account_id").val('0');
				$("#cheque_number").val('');
				$("#bank_id").val('0');
				$("#cheque_date").val('');
				$("#cheque_payment_amount").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, '', '', paymentAccountId, '', chequeNumber, bank, bankName, chequeDate, referenceTransactionType);
			}
		} else if (MakePaymentScreenOperationStatus == "View") {
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
			paymentAccountId = $("#payment_account_id_edit").val();
			chequeNumber = $("#cheque_number_edit").val();
			bank = $("#bank_id_edit").val();
			bankName = $("#bank_id_edit option:selected").text();
			chequeDate = $("#cheque_date_edit").val();
			chequePaymentAmount = $("#cheque_payment_amount_edit").val();
			cashPaymentAmount = '0';

			if (validateChequePaymentMethod_edit()) {
				$("#payment_account_id_edit").val('0');
				$("#cheque_number_edit").val('');
				$("#bank_id_edit").val('0');
				$("#cheque_date_edit").val('');
				$("#cheque_payment_amount_edit").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, chequePaymentAmount, '', '',paymentAccountId, '', chequeNumber, bank, bankName, chequeDate, referenceTransactionType);
			}
		}
	}
	
	function addSecondPartyChequePayment() {
		
		var referenceTransactionType = '';
		var chequeId = '';
		var chequeNumber = '';
		var bank = '';
        var bankName = '';
		var chequeDate = '';
		var chequePaymentAmount = '';
		var cashPaymentAmount = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
			referenceTransactionType = $("#reference_transaction_type_id").val();
			chequeId = $("#second_party_cheque_id").val();
			chequeNumber = $("#second_party_cheque_id option:selected").text();
			bank = $("#second_party_cheque_bank_id").val();
            bankName = $("#second_party_cheque_bank").val();
			chequeDate = $("#second_party_cheque_date").val();
			chequePaymentAmount = $("#second_party_cheque_payment_amount").val();
			cashPaymentAmount = '0';

			if (validateSecondPartyChequePaymentMethod_add()) {
				$("#second_party_cheque_id").val('0');
				$("#second_party_cheque_bank").val('');
				$("#second_party_cheque_date").val('');
				$("#second_party_cheque_payment_amount").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, '', chequePaymentAmount, '', '', chequeId, chequeNumber, bank, bankName, chequeDate, referenceTransactionType);
			}
		} else if (MakePaymentScreenOperationStatus == "View") {
			
			referenceTransactionType = $("#reference_transaction_type_id_edit").val();
			chequeId = $("#second_party_cheque_id_edit").val();
			chequeNumber = $("#second_party_cheque_id_edit option:selected").text();
			bank = $("#second_party_cheque_bank_id_edit").val();
            bankName = $("#second_party_cheque_bank_edit").val();
			chequeDate = $("#second_party_cheque_date_edit").val();
			chequePaymentAmount = $("#second_party_cheque_payment_amount_edit").val();
			cashPaymentAmount = '0';

			if (validateSecondPartyChequePaymentMethod_edit()) {
				$("#second_party_cheque_id_edit").val('0');
				$("#second_party_cheque_bank_edit").val('');
				$("#second_party_cheque_date_edit").val('');
				$("#second_party_cheque_payment_amount_edit").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, '', chequePaymentAmount, '', '', chequeId, chequeNumber, bank, bankName, chequeDate, referenceTransactionType);
			}
		}
	}
	
	function addThirdPartyChequePayment() {
		
		var referenceTransactionType = '';
		var chequeId = '';
		var chequeNumber = '';
		var bank = '';
        var bankName = '';
		var chequeDate = '';
		var chequePaymentAmount = '';
		var cashPaymentAmount = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
			referenceTransactionType = $("#reference_transaction_type_id").val();
			chequeId = $("#third_party_cheque_id").val();
			chequeNumber = $("#third_party_cheque_id option:selected").text();
			bank = $("#third_party_cheque_bank_id").val();
            bankName = $("#third_party_cheque_bank").val();
			chequeDate = $("#third_party_cheque_date").val();
			chequePaymentAmount = $("#third_party_cheque_payment_amount").val();
			cashPaymentAmount = '0';

			if (validateThirdPartyChequePaymentMethod_add()) {
				$("#third_party_cheque_id").val('0');
				$("#third_party_cheque_bank").val('');
				$("#third_party_cheque_date").val('');
				$("#third_party_cheque_payment_amount").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, '', '', chequePaymentAmount, '', chequeId, chequeNumber, bank, bankName, chequeDate, referenceTransactionType);
			}
		} else if (MakePaymentScreenOperationStatus == "View") {
			
			referenceTransactionType = $("#reference_transaction_type_id_edit").val();
			chequeId = $("#third_party_cheque_id_edit").val();
			chequeNumber = $("#third_party_cheque_id_edit option:selected").text();
			bank = $("#third_party_cheque_bank_id_edit").val();
            bankName = $("#third_party_cheque_bank_edit").val();
			chequeDate = $("#third_party_cheque_date_edit").val();
			chequePaymentAmount = $("#third_party_cheque_payment_amount_edit").val();
			cashPaymentAmount = '0';

			if (validateThirdPartyChequePaymentMethod_edit()) {
				$("#third_party_cheque_id_edit").val('0');
				$("#third_party_cheque_bank_edit").val('');
				$("#third_party_cheque_date_edit").val('');
				$("#third_party_cheque_payment_amount_edit").val('');
				MakePayment.addMakePaymentMethodRecord(cashPaymentAmount, '', '', chequePaymentAmount, '', chequeId, chequeNumber, bank, bankName, chequeDate, referenceTransactionType);
			}
		}
	}
	
	function deleteMakePaymentMethod(id) {
		
		var rowCount = '';
		
		var paymentMethodAmount = '';
		var transactionAmountTotal = '';
		
		if (MakePaymentScreenOperationStatus == "Add") {
			
			rowCount = id.substring(27,29);
			
			paymentMethodAmount = $("#amount_" + rowCount).html().replace(",", "");
			TransactionMethodAmountTotal = TransactionMethodAmountTotal - parseFloat(paymentMethodAmount);
			$("#payment_method_row_" + rowCount).remove();
			MakePaymentMethodRowCount--;

			transactionAmountTotal = TransactionAmountTotal;
			transactionAmountTotal = parseFloat(transactionAmountTotal) + parseFloat(paymentMethodAmount);
            TransactionAmountTotal = transactionAmountTotal;
			$("#amount_to_add_payment_type").val(transactionAmountTotal.toFixed(2));
			$("#payment_method_amount_total").html(TransactionMethodAmountTotal.toFixed(2));
			$("#amount").val(TransactionMethodAmountTotal.toFixed(2));
			
			rowCount++;
			var makePaymentMethodElement = $("#make_payment_method_records").find("#payment_method_row_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (makePaymentMethodElement.length == 1) {
					
					$("#make_payment_method_records").find("#payment_method_row_" + rowCount).prop({ id: "row_" + (rowCount - 1)});
					$("#make_payment_method_records").find("#payment_account_id_" + rowCount).prop({ id: "payment_account_id_" + (rowCount - 1)});
					$("#make_payment_method_records").find("#cheque_id_" + rowCount).prop({ id: "cheque_id_" + (rowCount - 1)});
					$("#make_payment_method_records").find("#bank_id_" + rowCount).prop({ id: "bank_id_" + (rowCount - 1)});
					$("#make_payment_method_records").find("#make_payment_method_" + rowCount).prop({ id: "make_payment_method_" + (rowCount - 1)});
					$("#make_payment_method_records").find("#cheque_number_" + rowCount).prop({ id: "cheque_number_" + (rowCount - 1)});
					$("#make_payment_method_records").find("#bank_" + rowCount).prop({ id: "bank_" +  (rowCount - 1)});
					$("#make_payment_method_records").find("#cheque_date_" + rowCount).prop({ id: "cheque_date_" +  (rowCount - 1)});
					$("#make_payment_method_records").find("#amount_" + rowCount).prop({ id: "amount_" +  (rowCount - 1)});
					$("#make_payment_method_records").find("#delete_make_payment_method_" + rowCount).prop({ id: "delete_make_payment_method_" +  (rowCount - 1)});
					
					rowCount++;
					makePaymentMethodElement = $("#make_payment_method_records").find("#payment_method_row_" + rowCount);
				} else {
                    rowCount--;
					moreElement = false;
				}
			}
			
            if (rowCount == 1) {
                $("#make_payment_save_button").attr('disabled', true);
            }
		} else if (MakePaymentScreenOperationStatus == "View") {
			
			rowCount = id.substring(32,34);
			
			paymentMethodAmount = $("#amount_edit_" + rowCount).html().replace(",", "");
			TransactionMethodAmountTotal = TransactionMethodAmountTotal - parseFloat(paymentMethodAmount);
			$("#payment_method_row_edit_" + rowCount).remove();
			MakePaymentMethodRowCount--;

			transactionAmountTotal = TransactionAmountTotal;
			transactionAmountTotal = parseFloat(transactionAmountTotal) + parseFloat(paymentMethodAmount);
            TransactionAmountTotal = transactionAmountTotal;
			$("#amount_to_add_payment_type_edit").val(transactionAmountTotal.toFixed(2));
			$("#payment_method_amount_total_edit").html(TransactionMethodAmountTotal.toFixed(2));
			$("#amount_edit").val(TransactionMethodAmountTotal.toFixed(2));
			
			rowCount++;
			var makePaymentMethodElement = $("#make_payment_method_records_edit").find("#payment_method_row_edit_" + rowCount);

			var moreElement = true;
			while (moreElement) {
				if (makePaymentMethodElement.length == 1) {
					
					$("#make_payment_method_records_edit").find("#payment_method_row_edit_" + rowCount).prop({ id: "payment_method_row_edit_" + (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#payment_account_id_edit_" + rowCount).prop({ id: "payment_account_id_edit_" + (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#cheque_id_edit_" + rowCount).prop({ id: "cheque_id_edit_" + (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#bank_id_edit_" + rowCount).prop({ id: "bank_id_edit_" + (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#make_payment_method_edit_" + rowCount).prop({ id: "make_payment_method_edit_" + (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#cheque_number_edit_" + rowCount).prop({ id: "cheque_number_edit_" + (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#bank_edit_" + rowCount).prop({ id: "bank_edit_" +  (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#cheque_date_edit_" + rowCount).prop({ id: "cheque_date_edit_" +  (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#amount_edit_" + rowCount).prop({ id: "amount_edit_" +  (rowCount - 1)});
					$("#make_payment_method_records_edit").find("#delete_make_payment_method_edit_" + rowCount).prop({ id: "delete_make_payment_method_edit_" +  (rowCount - 1)});
					
					rowCount++;
					makePaymentMethodElement = $("#make_payment_method_records").find("#payment_method_row_" + rowCount);
				} else {
                    rowCount--;
					moreElement = false;
				}
			}
			
            if (rowCount == 1) {
                $("#make_payment_edit_button").attr('disabled', true);
            }
		}
	}
	
	function handleSecondPartyChequeSelect(id) {
		var chequeId = $("#" + id).val();
		MakePayment.getSecondPartyChequeDetails(chequeId);
	}
	
	function handleThirdPartyChequeSelect(id) {
		var chequeId = $("#" + id).val();
		MakePayment.getThirdPartyChequeDetails(chequeId);
	}
	
	function handleBankSelect() {
		
	}
    
    function handleAgentSelection() {
        
    }
    
    function handleSalesRepSelect() {
        
    }
	
	var MakePayment = {
		cancelData: function () {
			$("#make_payment_details_form").hide();
			$("#search_make_payment_form").show();
			MakePayment.hideMessageDisplay();
			clearForm();
		},

		closeMakePaymentEditForm: function () {
			$("#make_payment_details_form").hide();
			$("#search_make_payment_form").show();
			MakePayment.hideMessageDisplay();
		},

		getNextReferenceNo : function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller/getNextReferenceNo",
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

		//save GRN data
		saveData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			//Gather Reference Transaction Details
			var referenceTransactionData = [];
			
			var referenceTransactionElement = $("#make_payment_reference_list").find("#reference_transaction_type_1");

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
					referenceTransactionElement = $("#make_payment_reference_list").find("#reference_transaction_type_" + referenceTransactionCount);
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
			
			var paymentMethodElement = $("#make_payment_method_records").find("#make_payment_method_1");

			var paymentMethodDataSet = [];
			var paymentMethods = {};
			var paymentAccountIds = {};
			var chequeIds = {};
			var bankIds = {};
			var chequeNumbers = {};
			var chequeDates = {};
			var amounts = {};

			var paymentMethodCount = 1;
			var moreElement = true;
			while (moreElement) {
				if (paymentMethodElement.length == 1) {
					paymentMethods[paymentMethodCount] = $("#make_payment_method_" + paymentMethodCount).html();
					paymentAccountIds[paymentMethodCount] = $("#payment_account_id_" + paymentMethodCount).val();
					chequeIds[paymentMethodCount] = $("#cheque_id_" + paymentMethodCount).val();
					bankIds[paymentMethodCount] = $("#bank_id_" + paymentMethodCount).val();
					chequeNumbers[paymentMethodCount] = $("#cheque_number_" + paymentMethodCount).html();
					chequeDates[paymentMethodCount] = $("#cheque_date_" + paymentMethodCount).html();
					amounts[paymentMethodCount] = $("#amount_" + paymentMethodCount).html();
					paymentMethodCount++;
					paymentMethodElement = $("#make_payment_method_records").find("#make_payment_method_" + paymentMethodCount);
				} else {
					moreElement = false;
				}
			}

			paymentMethodDataSet.push(paymentMethods);
			paymentMethodDataSet.push(paymentAccountIds);
			paymentMethodDataSet.push(chequeIds);
			paymentMethodDataSet.push(bankIds);
			paymentMethodDataSet.push(chequeNumbers);
			paymentMethodDataSet.push(chequeDates);
			paymentMethodDataSet.push(amounts);

			paymentMethodData.push(paymentMethodDataSet);

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller/add",
				data: {
					'reference_no' : $("#reference_no").val(),
					'make_payment_date' : $("#make_payment_date").val(),
					'payee_type' : $("#payee_type").val(),
					'payee_id' : $("#people_id").val(),
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
						MakePayment.getNextReferenceNo();
						MakePayment.getSecondPartyChequeNumbersData();
						MakePayment.getThirdPartyChequeNumbersData();
                        
                        var payeeType = '<?php echo $default_payee_type; ?>';
        
                        if (payeeType != '' && payeeType != '0') {

                            $("#payee_type").val(payeeType);

                            MakePayment.getPayeeList(payeeType, "");
                        }
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$(".save:input").attr('disabled', false);
					}
				}
			});
		},

		editMakePaymentData: function (id) {
        
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_updated')?>' +
				'</div>';

			//Gather Reference Transaction Details
			var referenceTransactionData = [];
			
			var referenceTransactionElement = $("#make_payment_reference_list_edit").find("#reference_transaction_type_edit_1");

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
					referenceTransactionElement = $("#make_payment_reference_list_edit").find("#reference_transaction_type_edit_" + referenceTransactionCount);
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
			
			var paymentMethodElement = $("#make_payment_method_records_edit").find("#make_payment_method_edit_1");

			var paymentMethodDataSet = [];
			var paymentMethods = {};
			var paymentAccountIds = {};
			var chequeIds = {};
			var bankIds = {};
			var chequeNumbers = {};
			var chequeDates = {};
			var amounts = {};

			var paymentMethodCount = 1;
			var moreElement = true;
			while (moreElement) {
				if (paymentMethodElement.length == 1) {
					paymentMethods[paymentMethodCount] = $("#make_payment_method_edit_" + paymentMethodCount).html();
					paymentAccountIds[paymentMethodCount] = $("#payment_account_id_edit_" + paymentMethodCount).val();
					chequeIds[paymentMethodCount] = $("#cheque_id_edit_" + paymentMethodCount).val();
					bankIds[paymentMethodCount] = $("#bank_id_edit_" + paymentMethodCount).val();
					chequeNumbers[paymentMethodCount] = $("#cheque_number_edit_" + paymentMethodCount).html();
					chequeDates[paymentMethodCount] = $("#cheque_date_edit_" + paymentMethodCount).html();
					
                    var amount = $("#amount_edit_" + paymentMethodCount).html().replace(",", "");
                    
					amounts[paymentMethodCount] = amount;
                    
					paymentMethodCount++;
					paymentMethodElement = $("#make_payment_method_records_edit").find("#make_payment_method_edit_" + paymentMethodCount);
				} else {
					moreElement = false;
				}
			}

			paymentMethodDataSet.push(paymentMethods);
			paymentMethodDataSet.push(paymentAccountIds);
			paymentMethodDataSet.push(chequeIds);
			paymentMethodDataSet.push(bankIds);
			paymentMethodDataSet.push(chequeNumbers);
			paymentMethodDataSet.push(chequeDates);
			paymentMethodDataSet.push(amounts);

			paymentMethodData.push(paymentMethodDataSet);
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller/editMakePaymentData",
				data: {
					'id': id,
					'reference_no' : $("#reference_no_edit").val(),
					'make_payment_date' : $("#make_payment_date_edit").val(),
					'remark': $("#remark_edit").val().trim(),
					'reference_transaction_data' : referenceTransactionData,
					'payment_method_data' : paymentMethodData,
					'reference_transaction_count' : referenceTransactionCount - 1,
					'payment_method_count' : paymentMethodCount - 1,
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
						$("#search_make_payment_form").show();
						$("#make_payment_details_form").hide();
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "");
						MakePayment.getSecondPartyChequeNumbersData();
						MakePayment.getThirdPartyChequeNumbersData();
					} else {
						$(".msg_data").show();
						$(".msg_data").html(response.result);
						$(".save:input").attr('disabled', false);
					}
				}
			});
		},

		deleteData: function (id) {

			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Make Payment') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller/deleteMakePayment",
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

		getMakePaymentData: function (id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller/getMakePaymentData",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					$("#make_payment_details_form").show();
					$("#search_make_payment_form").hide();
					$("#add_make_payment_form").hide();
					$("#edit_make_payment_form").show();
					$("#edit_make_payment_form_content").html(response.result);
					
					MakePayment.getPayeeList(response.payeeType);
					
					setTimeout(function(){
						$("#people_id_edit").val(response.payeeId).trigger('change');
					}, 800);
					
					if (response.referenceTransactionType != '') {
						$('#reference_transaction_type_init_edit').hide();
						$("#reference_transaction_type_dropdown_edit").html(response.referenceTransactionType);
						$("#reference_transaction_type_dropdown_edit").find("#reference_transaction_type_id").prop({ id: "reference_transaction_type_id_edit"});
					}
					
					$("#amount_to_add_payment_type_edit").val(response.amountToAddForPaymentType.toFixed(2));
					
					ReferenceTransactionRowCount = response.referenceTransactionRowCount;
					MakePaymentMethodRowCount = response.makePaymentMethodRowCount;
					TransactionAmountTotal = response.referenceTransactionTotalAmount;
					TransactionMethodAmountTotal = response.transactionMethodAmountTotal;
					
					jQuery.each(response.referenceTransactionList, function(index, referenceNo) {
						if (referenceNo != '') {
							SelectedReferenceTransactionList.push(referenceNo);
						}
					});

					$('.makePaymentReferenceDataEditTable').dataTable();
					$('.makePaymentMethodDataEditTable').dataTable();
		
					setTimeout(function(){
						$("#reference_transaction_div_edit").hide();
						$("#reference_journal_entry_div_edit").hide();
					}, 1000);
					
					$("#make_payment_edit_box_title").text('<?php echo $this->lang->line('Edit Make Payment') ?>');
					$(".loader").hide();
					
					$("#datepicker_make_payment_date_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});

					$("#datepicker_cheque_date_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					
					$("#add_reference_transaction_edit").attr('disabled', true);
				}
			}).done(function() {
				MakePayment.getPaymentAccountData();
				MakePayment.getBankData();
				MakePayment.getSecondPartyChequeNumbersData();
				MakePayment.getThirdPartyChequeNumbersData();
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
						if (MakePaymentScreenOperationStatus == "Add") {
							$("#reference_journal_entry_div").hide();
							$("#reference_transaction_div").show();
							$('#reference_transaction_init').hide();
							$("#reference_transaction_dropdown").html(response);
							$("#reference_transaction_id").select2();
						} else if (MakePaymentScreenOperationStatus == "View") {
							$("#reference_journal_entry_div_edit").hide();
							$("#reference_transaction_div_edit").show();
							$('#reference_transaction_init_edit').hide();
							$("#reference_transaction_dropdown_edit").html(response);
							$("#reference_transaction_dropdown_edit").find("#reference_transaction_id").prop({ id: "reference_transaction_id_edit"});
							$("#reference_transaction_id_edit").select2();
						}
					} else {
						if (MakePaymentScreenOperationStatus == "Add") {
							$("#reference_transaction_div").hide();
						} else if (MakePaymentScreenOperationStatus == "View") {
							$("#reference_transaction_div_edit").hide();
						}
						MakePayment.getReferenceJournalEntryListForSelectedTransaction(transactionTypeId, '')
					}
				}
			})
		},
		
		//get reference journal entry list drop down
		getReferenceJournalEntryListForSelectedTransaction: function (transactionTypeId, transactionReferenceNo) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceJournalEntryListForSelectedTransaction",
				data: {
					'transaction_type_id' : transactionTypeId,
					'transaction_reference_no' : transactionReferenceNo,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					if (MakePaymentScreenOperationStatus == "Add") {
						$("#reference_journal_entry_div").show();
						$("#add_reference_transaction").attr('disabled', true);
						$('#reference_journal_entry_init').hide();
						$("#reference_journal_entry_dropdown").html(response);
						$("#reference_journal_entry_id").select2();
					} else if (MakePaymentScreenOperationStatus == "View") {
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
                    if (MakePaymentScreenOperationStatus == "Add") {
                        options = document.getElementById('reference_journal_entry_id').options;
                    } else if (MakePaymentScreenOperationStatus == "View") {
                        options = document.getElementById('reference_journal_entry_id_edit').options;
                    }
                    
                    var i = 0;
                    jQuery.each(options, function() {
						if (i == 1) {
							options[1].selected = true;
                            
                            if (MakePaymentScreenOperationStatus == "Add") {
                                $("#reference_journal_entry_id").trigger("change");
                            } else if (MakePaymentScreenOperationStatus == "View") {
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
			
			if (MakePaymentScreenOperationStatus == "Add") {
				referenceTransaction = $("#reference_transaction_id option:selected").text();
				referenceJournalEntry = $("#reference_journal_entry_id option:selected").text();
			} else if (MakePaymentScreenOperationStatus == "View") {
				referenceTransaction = $("#reference_transaction_id_edit option:selected").text();
				referenceJournalEntry = $("#reference_journal_entry_id_edit option:selected").text();
			}
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceJournalEntryDetailsForMakePayment",
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
					var paymentMethodTotal = parseFloat(response.transactionAmountTotalNonFormatted) - parseFloat(TransactionMethodAmountTotal);
					var html = "";
					
					if (referenceTransactionType == '1' || referenceTransactionType == '4') {
						if (MakePaymentScreenOperationStatus == "Add") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_amount_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						} else if (MakePaymentScreenOperationStatus == "View") {
							html = "	<tr id='row_edit_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_edit_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_amount_edit_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_edit_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						}
					} else if (referenceTransactionType == '2' || referenceTransactionType == '3') {
						if (MakePaymentScreenOperationStatus == "Add") {
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
						} else if (MakePaymentScreenOperationStatus == "View") {
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
						if (MakePaymentScreenOperationStatus == "Add") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_amount_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						} else if (MakePaymentScreenOperationStatus == "View") {
							html = "	<tr id='row_" + ReferenceTransactionRowCount + "'> " +
										"      <input class='form-control' id='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_type_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionType + "'>" +
										"      <input class='form-control' id='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' name='reference_transaction_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceTransactionId + "'>" +
										"      <input class='form-control' id='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' name='reference_journal_entry_id_edit_" + ReferenceTransactionRowCount + "' type='hidden' value='" + referenceJournalEntryId + "'>" +
										"	<td id='reference_transaction_edit_" + ReferenceTransactionRowCount + "'>" + referenceTransaction + "</td>" +
										"	<td>" + referenceJournalEntry + "</td>" +
										"	<td id='reference_transaction_amount_edit_" + ReferenceTransactionRowCount + "'>" + response.transactionAmount + "</td>" +
										"	<td><a class='btn btn-danger btn-xs delete' id='delete_reference_transaction_edit_" + ReferenceTransactionRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteReferenceTransaction(this.id);'>" +
										"			<i class='icon-remove'></i>" +
										"		 </a></td>" +
										"	</tr>";
						}
					}
						
					if (MakePaymentScreenOperationStatus == "Add") {
						$("#make_payment_reference_amount_total").before(html);
						$("#reference_amount_total").html(response.transactionAmountTotal);
						$("#amount_to_add_payment_type").val(paymentMethodTotal.toFixed(2));
						$("#make_payment_reference_list").show();
						$("#make_payment_method_list").show();

						$("#reference_transaction_id").val('0').trigger("change");
						$("#reference_journal_entry_div").hide();
					} else if (MakePaymentScreenOperationStatus == "View") {
						$("#make_payment_reference_amount_total_edit").before(html);
						$("#reference_amount_total_edit").html(response.transactionAmountTotal);
						$("#amount_to_add_payment_type_edit").val(paymentMethodTotal.toFixed(2));

						$("#reference_transaction_id_edit").val('0').trigger("change");
						$("#reference_journal_entry_div_edit").hide();
					}
					
					SelectedReferenceTransactionList.push(referenceTransaction);
				}
			});
		},
		
		addMakePaymentMethodRecord: function (cashPaymentAmount, chequePaymentAmount, secondPartyChequePaymentAmount, thirdPartyChequePaymentAmount, paymentAccountId, chequeId, chequeNumber, bankId, bankName, chequeDate, referenceTransactionType) {
		
			var paymentMethod = '';
			var amount = '';
			if (cashPaymentAmount != '0') {
				paymentMethod = "Cash Payment";
				amount = cashPaymentAmount;
				TransactionMethodAmountTotal = parseFloat(TransactionMethodAmountTotal) + parseFloat(cashPaymentAmount);
			} else if (chequePaymentAmount != '') {
				paymentMethod = "Cheque Payment";
				amount = chequePaymentAmount;
				TransactionMethodAmountTotal = parseFloat(TransactionMethodAmountTotal) + parseFloat(chequePaymentAmount);
			} else if (secondPartyChequePaymentAmount != '') {
				paymentMethod = "Second Party Cheque Payment";
				amount = secondPartyChequePaymentAmount;
				TransactionMethodAmountTotal = parseFloat(TransactionMethodAmountTotal) + parseFloat(secondPartyChequePaymentAmount);
			} else if (thirdPartyChequePaymentAmount != '') {
				paymentMethod = "Third Party Cheque Payment";
				amount = thirdPartyChequePaymentAmount;
				TransactionMethodAmountTotal = parseFloat(TransactionMethodAmountTotal) + parseFloat(thirdPartyChequePaymentAmount);
			}
			
			MakePaymentMethodRowCount++;
			var html = "";
            
            var partialPaymentAllowed = '<?php echo $allow_partial_payment_for_reference_transactions ?>';
			
			if (MakePaymentScreenOperationStatus == "Add") {
				html = "	<tr id='payment_method_row_" + MakePaymentMethodRowCount + "'> " +
							"      <input class='form-control' id='payment_account_id_" + MakePaymentMethodRowCount + "' name='payment_account_id_" + MakePaymentMethodRowCount + "' type='hidden' value='" + paymentAccountId + "'>" +
							"      <input class='form-control' id='cheque_id_" + MakePaymentMethodRowCount + "' name='cheque_id_" + MakePaymentMethodRowCount + "' type='hidden' value='" + chequeId + "'>" +
							"      <input class='form-control' id='bank_id_" + MakePaymentMethodRowCount + "' name='bank_id_" + MakePaymentMethodRowCount + "' type='hidden' value='" + bankId + "'>" +
							"	<td id='make_payment_method_" + MakePaymentMethodRowCount + "'>" + paymentMethod + "</td>" +
							"	<td id='cheque_number_" + MakePaymentMethodRowCount + "'>" + chequeNumber + "</td>" +
							"	<td id='bank_" + MakePaymentMethodRowCount + "'>" + bankName + "</td>" +
							"	<td id='cheque_date_" + MakePaymentMethodRowCount + "'>" + chequeDate + "</td>" +
							"	<td id='amount_" + MakePaymentMethodRowCount + "'>" + amount + "</td>" +
							"	<td><a class='btn btn-danger btn-xs delete' id='delete_make_payment_method_" + MakePaymentMethodRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteMakePaymentMethod(this.id);'>" +
							"			<i class='icon-remove'></i>" +
							"		 </a></td>" +
							"	</tr>";

				$("#make_payment_method_amount_total").before(html);
				$("#payment_method_amount_total").html(TransactionMethodAmountTotal.toFixed(2));
				$("#amount").val(TransactionMethodAmountTotal.toFixed(2));
				$("#make_payment_method_records").show();

				var transactionAmountTotal = TransactionAmountTotal;
				transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(amount);
                TransactionAmountTotal = transactionAmountTotal;
				$("#amount_to_add_payment_type").val(transactionAmountTotal.toFixed(2));

				if (referenceTransactionType == '7') {
					if (TransactionMethodAmountTotal > 0) {
						$("#make_payment_save_button").attr('disabled', false);
					}
				} else {
					if (partialPaymentAllowed == "Yes" || transactionAmountTotal == 0) {
						$("#make_payment_save_button").attr('disabled', false);
					}
				}
			} else if (MakePaymentScreenOperationStatus == "View") {
				html = "	<tr id='payment_method_row_edit_" + MakePaymentMethodRowCount + "'> " +
							"      <input class='form-control' id='payment_account_id_edit_" + MakePaymentMethodRowCount + "' name='payment_account_id_edit_" + MakePaymentMethodRowCount + "' type='hidden' value='" + paymentAccountId + "'>" +
							"      <input class='form-control' id='cheque_id_edit_" + MakePaymentMethodRowCount + "' name='cheque_id_edit_" + MakePaymentMethodRowCount + "' type='hidden' value='" + chequeId + "'>" +
							"      <input class='form-control' id='bank_id_edit_" + MakePaymentMethodRowCount + "' name='bank_id_edit_" + MakePaymentMethodRowCount + "' type='hidden' value='" + bankId + "'>" +
							"	<td id='make_payment_method_edit_" + MakePaymentMethodRowCount + "'>" + paymentMethod + "</td>" +
							"	<td id='cheque_number_edit_" + MakePaymentMethodRowCount + "'>" + chequeNumber + "</td>" +
							"	<td id='bank_edit_" + MakePaymentMethodRowCount + "'>" + bankName + "</td>" +
							"	<td id='cheque_date_edit_" + MakePaymentMethodRowCount + "'>" + chequeDate + "</td>" +
							"	<td id='amount_edit_" + MakePaymentMethodRowCount + "'>" + amount + "</td>" +
							"	<td><a class='btn btn-danger btn-xs delete' id='delete_make_payment_method_edit_" + MakePaymentMethodRowCount + "' title='<?php echo $this->lang->line('Delete') ?>' onclick='deleteMakePaymentMethod(this.id);'>" +
							"			<i class='icon-remove'></i>" +
							"		 </a></td>" +
							"	</tr>";

				$("#make_payment_method_amount_total_edit").before(html);
				$("#payment_method_amount_total_edit").html(TransactionMethodAmountTotal.toFixed(2));
				$("#amount_edit").val(TransactionMethodAmountTotal.toFixed(2));
				
				var transactionAmountTotal = TransactionAmountTotal;
				transactionAmountTotal = parseFloat(transactionAmountTotal) - parseFloat(amount);
                TransactionAmountTotal = transactionAmountTotal;
				$("#amount_to_add_payment_type_edit").val(transactionAmountTotal.toFixed(2));

				if (referenceTransactionType == '7') {
					if (TransactionMethodAmountTotal > 0) {
						$("#make_payment_edit_button").attr('disabled', false);
					}
				} else {
					if (partialPaymentAllowed == "Yes" || transactionAmountTotal == 0) {
						$("#make_payment_edit_button").attr('disabled', false);
					}
				}
			}
		},

		//get payee drop down
		getPayeeData: function () {
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
					$('#payee_search_init').hide();
					$("#payee_search_dropdown").html(response);
					$("#payee_search_dropdown").find("#people_id").prop({ id: "payee_search_id"});
					$("#payee_search_id").select2();
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
		
		getPayeeList: function (payeeType) {
		
			var type = "";
            var disableSelection = "";
            
			if (MakePaymentScreenOperationStatus == "Add") {
				type = "Add";
                disableSelection = "No";
			} else if (MakePaymentScreenOperationStatus == "View") {
				type = "View";
                disableSelection = "No";
			}
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getPeopleListAccordingToTheCategory",
				data: {
					'people_category' : payeeType,
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
					if (MakePaymentScreenOperationStatus == "Add") {
						$("#payee_list_div").show();
						$("#payee_list_div").empty();
						$("#payee_list_div").append(response);
						$("#payee_list_div").find("#sales_rep_id").prop({ id: "people_id"});
						$("#people_id").select2();
					} else if (MakePaymentScreenOperationStatus == "View") {
						$("#payee_list_div_edit").empty();
						$("#payee_list_div_edit").append(response);
						$("#payee_list_div_edit").find("#customer_dropdown").prop({ id: "customer_dropdown_edit"});
						$("#people_id_edit").select2();
					}
				}
			})
		},
		
		//get payment account drop down
		getPaymentAccountData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getPaymentAccountData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					if (MakePaymentScreenOperationStatus == "Add") {
						$('#payment_account_init').hide();
						$("#payment_account_dropdown").empty();
						$("#payment_account_dropdown").html(response.paymentAccountList);
					} else if (MakePaymentScreenOperationStatus == "View") {
						$('#payment_account_init_edit').hide();
						$("#payment_account_dropdown_edit").empty();
						$("#payment_account_dropdown_edit").html(response.paymentAccountList);
						$("#payment_account_dropdown_edit").find("#payment_account_id").prop({ id: "payment_account_id_edit"});
					}
				}
			});
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
					if (MakePaymentScreenOperationStatus == "Add") {
						$('#bank_init').hide();
						$("#bank_dropdown").empty();
						$("#bank_dropdown").html(response);
					} else if (MakePaymentScreenOperationStatus == "View") {
						$('#bank_init_edit').hide();
						$("#bank_dropdown_edit").empty();
						$("#bank_dropdown_edit").html(response);
						$("#bank_dropdown_edit").find("#bank_id").prop({ id: "bank_id_edit"});
					}
				}
			})
		},
		
		getSecondPartyChequeNumbersData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/getSecondPartyChequesInHandToDropdown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					if (MakePaymentScreenOperationStatus == "Add") {
						$('#second_party_cheque_number_init').hide();
						$("#second_party_cheque_number_dropdown").empty();
						$("#second_party_cheque_number_dropdown").html(response);
					} else if (MakePaymentScreenOperationStatus == "View") {
						$('#second_party_cheque_number_init_edit').hide();
						$("#second_party_cheque_number_dropdown_edit").empty();
						$("#second_party_cheque_number_dropdown_edit").html(response);
						$("#second_party_cheque_number_dropdown_edit").find("#second_party_cheque_id").prop({ id: "second_party_cheque_id_edit"});
					}
				}
			});
		},
		
		getThirdPartyChequeNumbersData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/getThirdPartyChequesInHandToDropdown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					if (MakePaymentScreenOperationStatus == "Add") {
						$('#third_party_cheque_number_init').hide();
						$("#third_party_cheque_number_dropdown").empty();
						$("#third_party_cheque_number_dropdown").html(response);
					} else if (MakePaymentScreenOperationStatus == "View") {
						$('#third_party_cheque_number_init_edit').hide();
						$("#third_party_cheque_number_dropdown_edit").empty();
						$("#third_party_cheque_number_dropdown_edit").html(response);
						$("#third_party_cheque_number_dropdown_edit").find("#third_party_cheque_id").prop({ id: "third_party_cheque_id_edit"});
					}
				}
			});
		},
		
		//get payment account drop down
		getPaymentAccountDataWithSalvedOption: function (paymentAccountId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/system_configurations_controller/getPaymentAccountDataWithSavedOption",
				data: {
					'payment_account_id' : paymentAccountId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					$("#payment_account_dropdown_edit").empty();
					$("#payment_account_dropdown_edit").html(response.paymentAccountList);
				}
			});
		},
		
		getSecondPartyChequeDetails : function (chequeId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/getSecondPartyChequeData",
				data: {
					'cheque_id' : chequeId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					if (MakePaymentScreenOperationStatus == "Add") {
                        $("#second_party_cheque_bank_id").val(response.secondPartyChequeBankId);
						$("#second_party_cheque_bank").val(response.secondPartyChequeBankName);
						$("#second_party_cheque_date").val(response.secondPartyChequeDate);
						$("#second_party_cheque_payment_amount").val(response.secondPartyChequePaymentAmount);
					} else if (MakePaymentScreenOperationStatus == "View") {
                        $("#second_party_cheque_bank_id_edit").val(response.secondPartyChequeBankId);
						$("#second_party_cheque_bank_edit").val(response.secondPartyChequeBankName);
						$("#second_party_cheque_date_edit").val(response.secondPartyChequeDate);
						$("#second_party_cheque_payment_amount_edit").val(response.secondPartyChequePaymentAmount);
					}
				}
			});
		},
		
		getThirdPartyChequeDetails : function (chequeId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/getThirdPartyChequeData",
				data: {
					'cheque_id' : chequeId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					if (MakePaymentScreenOperationStatus == "Add") {
                        $("#third_party_cheque_bank_id").val(response.thirdPartyChequeBankId);
						$("#third_party_cheque_bank").val(response.thirdPartyChequeBankName);
						$("#third_party_cheque_date").val(response.thirdPartyChequeDate);
						$("#third_party_cheque_payment_amount").val(response.thirdPartyChequePaymentAmount);
					} else if (MakePaymentScreenOperationStatus == "View") {
                        $("#third_party_cheque_bank_id_edit").val(response.thirdPartyChequeBankId);
						$("#third_party_cheque_bank_edit").val(response.thirdPartyChequeBankName);
						$("#third_party_cheque_date_edit").val(response.thirdPartyChequeDate);
						$("#third_party_cheque_payment_amount_edit").val(response.thirdPartyChequePaymentAmount);
					}
				}
			});
		},

		init : function () {
			$("#table").show();
			$("#reference_transaction_section_div").hide();
			$("#reference_transaction_div").hide();
			$("#reference_journal_entry_div").hide();
			$("#make_payment_details_form").hide();
			MakePayment.hideMessageDisplay();
			$("#remark").val('');
		},

		hideMessageDisplay : function () {
			$(".msg_data").hide();
			$(".modal_msg_data").hide();
			$(".modal_msg_data").hide();
			$(".msg_data_make_payment_search").hide();
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
		return (isSelected("payment_account_id", "<?php echo $this->lang->line('Payment Account').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("cheque_number", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("bank_id", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("cheque_date", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("cheque_payment_amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//form validation edit
	function validateChequePaymentMethod_edit() {
		return (isSelected("payment_account_id_edit", "<?php echo $this->lang->line('Payment Account').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("cheque_number_edit", "<?php echo $this->lang->line('Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("bank_id_edit", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("cheque_date_edit", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("cheque_payment_amount_edit", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//form validation save
	function validateSecondPartyChequePaymentMethod_add() {
		return (isSelected("second_party_cheque_id", "<?php echo $this->lang->line('Second Party Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("second_party_cheque_bank", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("second_party_cheque_date", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("second_party_cheque_payment_amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//form validation edit
	function validateSecondPartyChequePaymentMethod_edit() {
		return (isSelected("second_party_cheque_id_edit", "<?php echo $this->lang->line('Second Party Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("second_party_cheque_bank_edit", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("second_party_cheque_date_edit", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("second_party_cheque_payment_amount_edit", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//form validation save
	function validateThirdPartyChequePaymentMethod_add() {
		return (isSelected("third_party_cheque_id", "<?php echo $this->lang->line('Third Party Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("third_party_cheque_bank", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("third_party_cheque_date", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("third_party_cheque_payment_amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//form validation edit
	function validateThirdPartyChequePaymentMethod_edit() {
		return (isSelected("third_party_cheque_id_edit", "<?php echo $this->lang->line('Third Party Cheque Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("third_party_cheque_bank_edit", "<?php echo $this->lang->line('Bank').' '.$this->lang->line('field is required')?>")
			&& isSelected("third_party_cheque_date_edit", "<?php echo $this->lang->line('Cheque Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("third_party_cheque_payment_amount_edit", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//form validation save
	function validateForm_save() {
		return (isNotEmpty("reference_no", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("make_payment_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("payee_type", "<?php echo $this->lang->line('Payee Type').' '.$this->lang->line('field is required')?>")
			&& isSelected("people_id", "<?php echo $this->lang->line('Payee').' '.$this->lang->line('field is required')?>")
			&& isSelected("location", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
		);
	}

	//form validation edit
	function validateForm_edit() {
		return (isNotEmpty("reference_no_edit", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("make_payment_date_edit", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("payee_type_edit", "<?php echo $this->lang->line('Payee Type').' '.$this->lang->line('field is required')?>")
			&& isSelected("people_id_edit", "<?php echo $this->lang->line('Payee').' '.$this->lang->line('field is required')?>")
			&& isSelected("location_edit", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
		);
	}
	
	//get all data
	function getTableData(year, month, payeeId, locationId){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/make_payment_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
				'payee_id' : payeeId,
				'location_id' : locationId,
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
				
				$('.makePaymentDataTable').dataTable({
					"aaSorting": [[ 1, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		})
	}

	function clearForm(){
		$("#reference_no").val('');
		$("#make_payment_date").val(moment().format('YYYY-MM-DD'));
		$("#payee_type").val('');
		$("#people_id").val('0').trigger('change');
		$("#payee_list_div").hide();
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
		
		var referenceTransactionElement = $("#make_payment_reference_list").find("#reference_transaction_type_1");

		var referenceTransactionCount = 1;
		var moreElement = true;
		while (moreElement) {
			if (referenceTransactionElement.length == 1) {
				$("#row_" + referenceTransactionCount).remove();
				referenceTransactionCount++;
				referenceTransactionElement = $("#make_payment_reference_list").find("#reference_transaction_type_" + referenceTransactionCount);
			} else {
				moreElement = false;
			}
		}
		
		var paymentMethodElement = $("#make_payment_method_records").find("#make_payment_method_1");

		var paymentMethodCount = 1;
		var moreElement = true;
		while (moreElement) {
			if (paymentMethodElement.length == 1) {
				$("#make_payment_method_" + paymentMethodCount).remove();
				paymentMethodCount++;
				paymentMethodElement = $("#make_payment_method_records").find("#make_payment_method_" + paymentMethodCount);
			} else {
				moreElement = false;
			}
		}
		
		$("#make_payment_reference_list").hide();
		$("#make_payment_method_list").hide();
		$("#make_payment_method_records").hide();
		
		TransactionAmountTotal = 0;
		TransactionMethodAmountTotal = 0;
		ReferenceTransactionRowCount = 0;
		MakePaymentMethodRowCount = 0;
		SelectedReferenceTransactionList = [];
		
		$("#amount").val('');
		$("#remark").val('');
	}
</script>
