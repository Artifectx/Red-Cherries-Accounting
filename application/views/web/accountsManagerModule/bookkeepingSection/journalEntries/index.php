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
								<span><?php echo $this->lang->line('Journal Entries') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
                <div class='msg_instant' align="center"></div>
				<div class='form'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background'>
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Journal Entries') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<form class='form form-horizontal validate-form save_form' id="journal_entry_form" method="post">
										<div id='journal_entry_detail_div'>
											<div class="form-group">
												<div class='col-sm-12 controls'>
													<input class='form-control' id='journal_entry_id' name='journal_entry_id' type='hidden'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'>
															<?php 
																echo $this->lang->line('Prime Entry Book');
																if (!isset($ACM_Bookkeeping_Add_Advanced_Journal_Entry_Permissions)) {
																	echo "*";
																}        
															?>
														</label>
													</div>
													<div class='col-sm-5 controls' id="prime_entry_book_name_div">
														<select id="prime_entry_book_name_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
														<!--Prime entry books drop down-->
														<div id="prime_entry_book_name_dropdown">
														</div>
														<!--End Prime entry books drop down-->
														<div id="prime_entry_book_idError" class="red"></div>
													</div>
													<div class='col-sm-2 controls' style="text-align:center">

													</div>
												</div>
											</div>
											<div class="form-group">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Date') ?> *</label>
													</div>
													<div class='col-sm-5 controls' id="journal_entry_date_div">
														<div class='datepicker-input input-group' id='datepicker_transaction_date'>
															<input class='form-control' id='transaction_date' name='transaction_date'
																   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="">
															  <span class="input-group-addon">
																	<span class="glyphicon glyphicon-calendar"/>
															  </span>
														</div>
														<div id="transaction_dateError" class="red"></div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Payee/Payer Type') ?></label>
													</div>
													<div class='col-sm-5 controls' id="payee_payer_type_div">
														<select class='form-control' name='payee_payer_type' id='payee_payer_type' onchange="getPeopleType(this.id);">
															<option value=''><?php echo $this->lang->line('-- Select --');?></option>
															<?php
															foreach($peopleType as $row){
																?>
																<option value='<?php echo $row['people_type'];?>'><?php echo $row['people_type'];?></option>
															<?php
															}
															?>
														</select>
														<div id="payee_payer_typeError" class="red"></div>
													</div>
												</div>
											</div>
											<div class="form-group" id="people_list_div">
												<div class='col-sm-12 controls' id="people_list">

												</div>
											</div>
											<div class="form-group">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Reference No') ?></label>
													</div>
													<div class='col-sm-5 controls' id="reference_no_div">
														<input class='form-control' id='reference_no' name='reference_no' 
															   type='text' value="" placeholder='<?php echo $this->lang->line('Reference No') ?>'>
														<div id='reference_noError' class='red'></div>
													</div>
													<div class='col-sm-2 controls' style="text-align:center">

													</div>
												</div>
											</div>
											<div class='form-group' id="reference_transaction_type_div">
												<div class='col-sm-12 controls'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Transaction Type') ?> *</label>
													<div class='col-sm-5 controls'>
														<select id="reference_transaction_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
														<!--Reference transaction type drop down-->
														<div id="reference_transaction_type_dropdown">
														</div>
														<!--End Reference transaction type drop down-->
														<div id="reference_transaction_type_idError" class="red"></div>
													</div>
												</div>
											</div>
											<div class='form-group' id="reference_transaction_div">
												<div class='col-sm-12 controls'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Transaction') ?> *</label>
													<div class='col-sm-5 controls'>
														<select id="reference_transaction_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
														<!--Reference transaction drop down-->
														<div id="reference_transaction_dropdown">
														</div>
														<!--End Reference transaction drop down-->
														<div id="reference_transaction_idError" class="red"></div>
													</div>
												</div>
											</div>
											<div class='form-group' id="reference_journal_entry_div">
												<div class='col-sm-12 controls'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference Journal Entry') ?> *</label>
													<div class='col-sm-5 controls'>
														<select id="reference_journal_entry_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
														<!--Reference journal entry drop down-->
														<div id="reference_journal_entry_dropdown">
														</div>
														<!--End reference journal entry drop down-->
														<div id="reference_journal_entry_idError" class="red"></div>
													</div>
												</div>
											</div>
											<?php 
											if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
												<div id="location_dropdown">
												</div>
											<?php 
											} ?>
											<div class="form-group">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Due Date') ?></label>
													</div>
													<div class='col-sm-5 controls' id="due_date_div">
														<div class='datepicker-input input-group' id='datepicker_due_date'>
															<input class='form-control' id='due_date' name='due_date'
																   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Due Date') ?>' type='text' value="">
															<span class="input-group-addon">
																 <span class="glyphicon glyphicon-calendar"/>
															</span>
														</div>
														<div id="due_dateError" class="red"></div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Description') ?></label>
													</div>
													<div class='col-sm-5 controls' id="journal_entry_description_div">
														<textarea class='form-control' id='description' name='description'
															   placeholder='<?php echo $this->lang->line('Description') ?>' type='text' value="<?php echo set_value('description'); ?>">
														</textarea>
														<div id="descriptionError" class="red"></div>
													</div>
													<div class='col-sm-2 controls' style="text-align:center">

													</div>
												</div>
											</div>
											<div class="form-group" id="add_as_a_prime_entry_div">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls'></div>
													<div class='col-sm-5 controls'>
														<input type="checkbox" name="add_prime_entry_book" id="add_prime_entry_book" style="vertical-align: text-bottom;"
															   onchange="handleAddPrimeEntryBookSelect();">
														<label for="add_prime_entry_book" ><?php echo $this->lang->line('Add as a Prime Entry Book') ?></label>
													</div>
												</div>
											</div>
											<div class="form-group" id="new_prime_entry_book_name_div">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Prime Entry Book Name') ?> *</label>
													</div>
													<div class='col-sm-5 controls' id="journal_entry_description_div">
														<input class='form-control' id='prime_entry_book_name' name='prime_entry_book_name' 
															   type='text' value="" placeholder='<?php echo $this->lang->line('Prime Entry Book Name') ?>'>
														<div id='prime_entry_book_nameError' class='red'></div>
													</div>
												</div>
											</div>
										</div>
										<p style="margin-bottom:0px">&nbsp;&nbsp;&nbsp;&nbsp;</p>
										<div class='box' id="journal_entry_values_for_prime_book_chart_of_accounts_div">
											<div class='box-header'>
												<div class='title'><?php echo $this->lang->line('Journal Entry Values') ?></div>
											</div>
											<div class='box-content light_color_background'>
												<div id='chart_of_accounts_headers'>
													<div class='col-sm-12 controls row'>
														<div class='col-sm-6 controls'>
															<div class='col-sm-3 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Account Code') ?></label>
															</div>
															<div class='col-sm-5 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Debit Chart of Account') ?></label>
															</div>
															<div class='col-sm-4 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Value') ?></label>
															</div>
															<br>
															<hr class="light">
														</div>
														<div class='col-sm-6 controls'>
															<div class='col-sm-3 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Account Code') ?></label>
															</div>
															<div class='col-sm-5 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Credit Chart of Account') ?></label>
															</div>
															<div class='col-sm-4 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Value') ?></label>
															</div>
															<br>
															<hr class="light">
														</div>
													</div>
												</div>
												<p style="margin-bottom:-10px">&nbsp;</p>
												<div id="chart_of_accounts_group">
													<div class='col-sm-12 controls row' id="chart_of_accounts_div_1">
														<div class='col-sm-6 controls' id="debit_chart_of_accounts_div_1">
															<div class='col-sm-3 controls' id='debit_chart_of_account_code_div_1' name='debit_chart_of_account_code_div_1' style="text-align:center; font-size: 9pt;">
																<label class='control-label' id="debit_chart_of_account_code_1"></label>
															</div>
															<div class='col-sm-5 controls' id='debit_chart_of_account_div_1' name='debit_chart_of_account_div_1' style="text-align:center; font-size: 9pt;">
																<label class='control-label' id="debit_chart_of_account_1"></label>
															</div>
															<div class='col-sm-4 controls' id='debit_transaction_value_div_1' style="text-align:center; font-size: 9pt;">
																<input id="debit_transaction_value_1" name="debit_transaction_value" class="form-control" type="text" 
																	   placeholder="<?php echo $this->lang->line('Debit Amount') ?>" onchange="handleDebitTransactionValueAddition(this.id);">
																<div id="debit_transaction_value_1Error" class="red"></div>
															</div>
														</div>
														<div class='col-sm-6 controls' id="credit_chart_of_accounts_div_1">
															<div class='col-sm-3 controls' id='credit_chart_of_account_code_div_1' name='credit_chart_of_account_code_div_1' style="text-align:center; font-size: 9pt;">
																<label class='control-label' id="credit_chart_of_account_code_1"></label>
															</div>
															<div class='col-sm-5 controls' id='credit_chart_of_account_div_1' name='credit_chart_of_account_div_1' style="text-align:center; font-size: 9pt;">
																<label class='control-label' id="credit_chart_of_account_1"></label>
															</div>
															<div class='col-sm-4 controls' id='credit_transaction_value_div_1' style="text-align:center; font-size: 9pt;">
																<input id="credit_transaction_value_1" name="credit_transaction_value" class="form-control" type="text" 
																	   placeholder="<?php echo $this->lang->line('Credit Amount') ?>" onchange="handleCreditTransactionValueAddition(this.id);">
																<div id="credit_transaction_value_1Error" class="red"></div>
															</div>
														</div>
													</div>
													<p id="row_space_1" style="margin-bottom:5px">&nbsp;</p>
												</div>
												<div id="chart_of_accounts_summary">
													<div class='col-sm-12 controls row' id="chart_of_accounts_summary_div">
														<div class='col-sm-6 controls' id="debit_chart_of_accounts_summary">
															<hr class="light">
															<div class='col-sm-8 controls' id='debit_chart_of_account_total_div' name='debit_chart_of_account_total_div' style="text-align:right">
																<label class='control-label' id="debit_chart_of_account_total"><?php echo $this->lang->line('Debit Total') ?></label>
															</div>
															<div class='col-sm-4 controls' id='debit_chart_of_account_total_value_div' style="text-align:center">
																<input id="debit_chart_of_account_total_value" name="debit_chart_of_account_total_value" class="form-control" 
																	   type="text" placeholder="<?php echo $this->lang->line('Debit Amount Total') ?>" disabled value="0.00">
															</div>
															<br>
															<hr class="light">
														</div>
														<div class='col-sm-6 controls' id="credit_chart_of_accounts_summary">
															<hr class="light">
															<div class='col-sm-8 controls' id='credit_chart_of_account_total_div' name='credit_chart_of_account_total_div' style="text-align:right">
																<label class='control-label' id="credit_chart_of_account_total"><?php echo $this->lang->line('Credit Total') ?></label>
															</div>
															<div class='col-sm-4 controls' id='credit_chart_of_account_total_value_div' style="text-align:center;">
																<input id="credit_chart_of_account_total_value" name="credit_chart_of_account_total_value" class="form-control" 
																	   type="text" placeholder="<?php echo $this->lang->line('Credit Amount Total') ?>" disabled value="0.00">
															</div>
															<br>
															<hr class="light">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class='box' id="journal_entry_values_for_chart_of_accounts_div">
											<div class='box-header'>
												<div class='title'><?php echo $this->lang->line('Journal Entry Values') ?></div>
											</div>
											<div class='box-content light_color_background'>
												<div id='je_chart_of_accounts_headers'>
													<div class='col-sm-12 controls row'>
														<div class='col-sm-6 controls'">
															<div class='col-sm-6 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Debit Chart of Account') ?></label>
															</div>
															<div class='col-sm-4 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Value') ?></label>
															</div>
															<div class='col-sm-2 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Delete') ?></label>
															</div>
														</div>
														<div class='col-sm-6 controls'>
															<div class='col-sm-6 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Credit Chart of Account') ?></label>
															</div>
															<div class='col-sm-4 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Value') ?></label>
															</div>
															<div class='col-sm-2 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Delete') ?></label>
															</div>
														</div>
													</div>
												</div>
												<p style="margin-bottom:-10px">&nbsp;</p>
												<div id="je_chart_of_accounts_group">
													<div class='col-sm-12 controls row' id="je_chart_of_accounts_div_1">
														<div class='col-sm-6 controls' id="je_debit_chart_of_accounts_div_1">
															<div class='col-sm-6 controls' id='je_debit_chart_of_account_div_1' name='je_debit_chart_of_account_div_1' style="text-align:center">
																<select class='select form-control' id='je_debit_chart_of_account_1' name='je_debit_chart_of_account'>
																	<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																</select>
																<div id='je_debit_chart_of_account_1Error' class='red'></div>
															</div>
															<div class='col-sm-4 controls' id='je_debit_transaction_value_div_1' style="text-align:center; font-size: 9pt;">
																<input id="je_debit_transaction_value_1" name="je_debit_transaction_value" class="form-control" type="text" 
																	   placeholder="<?php echo $this->lang->line('Debit Amount') ?>" onchange="handleJEDebitTransactionValueAddition(this.id);">
																<div id="je_debit_transaction_value_1Error" class="red"></div>
															</div>
															<div class='col-sm-2 controls' id='btnDeleteDebitAccount_div_1' style="text-align:center">
																<button class='btn btn-success' id="btnDeleteDebitAccount_1" type='button' onclick="deleteDebitAccount(this.id);" disabled <?php echo $menuFormatting; ?>>
																	<?php echo $this->lang->line('Delete') ?></button>
															</div>
														</div>
														<div class='col-sm-6 controls' id="je_credit_chart_of_accounts_div_1">
															<div class='col-sm-6 controls' id="je_credit_chart_of_account_div_1" style="text-align:center">
																<select class='select form-control' id='je_credit_chart_of_account_1' name='je_credit_chart_of_account'>
																	<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																</select>
																<div id='credit_chart_of_account_1Error' class='red'></div>
															</div>
															<div class='col-sm-4 controls' id='je_credit_transaction_value_div_1' style="text-align:center; font-size: 9pt;">
																<input id="je_credit_transaction_value_1" name="je_credit_transaction_value" class="form-control" type="text" 
																	   placeholder="<?php echo $this->lang->line('Credit Amount') ?>" onchange="handleJECreditTransactionValueAddition(this.id);">
																<div id="je_credit_transaction_value_1Error" class="red"></div>
															</div>
															<div class='col-sm-2 controls' id='btnDeleteCreditAccount_div_1' style="text-align:center">
																<button class='btn btn-success' id="btnDeleteCreditAccount_1" type='button' onclick="deleteCreditAccount(this.id);" disabled <?php echo $menuFormatting; ?>>
																	<?php echo $this->lang->line('Delete') ?></button>
															</div>
														</div>
													</div>
													<p id="row_space_1" style="margin-bottom:5px">&nbsp;</p>
												</div>
												<div id="je_chart_of_accounts_summary">
													<div class='col-sm-12 controls row' id="je_chart_of_accounts_summary_div">
														<div class='col-sm-6 controls' id="je_debit_chart_of_accounts_summary">
															<hr class="light">
															<div class='col-sm-6 controls' id='je_debit_chart_of_account_total_div' name='je_debit_chart_of_account_total_div' style="text-align:right">
																<label class='control-label' id="je_debit_chart_of_account_total"><?php echo $this->lang->line('Debit Total') ?></label>
															</div>
															<div class='col-sm-4 controls' id='je_debit_chart_of_account_total_value_div' style="text-align:center">
																<input id="je_debit_chart_of_account_total_value" name="je_debit_chart_of_account_total_value" class="form-control" 
																	   type="text" placeholder="<?php echo $this->lang->line('Debit Amount Total') ?>" disabled value="0.00">
															</div>
															<br>
															<hr class="light">
														</div>
														<div class='col-sm-6 controls' id="je_credit_chart_of_accounts_summary">
															<hr class="light">
															<div class='col-sm-6 controls' id='je_credit_chart_of_account_total_div' name='je_credit_chart_of_account_total_div' style="text-align:right">
																<label class='control-label' id="je_credit_chart_of_account_total"><?php echo $this->lang->line('Credit Total') ?></label>
															</div>
															<div class='col-sm-4 controls' id='je_credit_chart_of_account_total_value_div' style="text-align:center;">
																<input id="je_credit_chart_of_account_total_value" name="je_credit_chart_of_account_total_value" class="form-control" 
																	   type="text" placeholder="<?php echo $this->lang->line('Credit Amount Total') ?>" disabled value="0.00">
															</div>
															<br>
															<hr class="light">
														</div>
													</div>
												</div>
												<div class='form-group' id="add_shift_time_button">
													<div class='col-sm-12 controls'>
														<div class='col-sm-6 controls'>
															<button class='btn btn-success' id="btnAddAnotherDebitLedgerAccount"  type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Add Another Debit Ledger Account') ?></button>
														</div>
														<div class='col-sm-6 controls'>
															<button class='btn btn-success' id="btnAddAnotherCreditLedgerAccount"  type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Add Another Credit Ledger Account') ?></button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<?php
													if (isset($ACM_Bookkeeping_Add_Journal_Entry_Permissions)) {
														?>
														<button class='btn btn-success save' id="btnSaveJournalEntry"
																onclick='handleSaveEditData();' type='button' <?php echo $menuFormatting; ?>>
															<i class='icon-save'></i>
															<?php echo $this->lang->line('Save') ?>
														</button>
														<?php
													}
													?>
													<button class='btn btn-warning cancel' onclick='cancelData();'
															type='button' <?php echo $menuFormatting; ?>>
														<i class='icon-ban-circle'></i>
														<?php echo $this->lang->line('Close') ?>
													</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id='table'>
					<div class="msg_delete"></div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
                                <div class='box'>
                                    <div class='box-header'>
                                        <div class='title'><?php echo $this->lang->line('Search Journal Entries') ?></div>
                                    </div>
                                    <div class='box-content'>
                                        <div class='form-group'>
                                            <div class='col-sm-12 controls'>
                                                <label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('From Date') ?></label>
                                                <label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('To Date') ?></label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='form-group'>
                                            <div class='col-sm-12 controls'>
                                                <div class='col-sm-4 controls'>
                                                    <div class='input-group date' id="from_date_picker">
                                                        <input class='form-control' id='from_date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('From Date') ?>' type='text'>
                                                        <span class='input-group-addon'>
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                        <div id="from_dateError" class="red"></div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-4 controls'>
                                                    <div class='input-group date' id="to_date_picker">
                                                        <input class='form-control' id='to_date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('To Date') ?>' type='text'>
                                                        <span class='input-group-addon'>
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                        <div id="to_dateError" class="red"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='form-group'>
                                            <div class='col-sm-12 controls'>
                                                <label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('Prime Entry Book') ?></label>
                                                 <?php 
                                                    if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
                                                        <div class='form-group'>
                                                            <div class='col-sm-12 controls'>
                                                                <label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('Location') ?></label>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='form-group'>
                                            <div class='col-sm-12 controls'>
                                                <div class='col-sm-4 controls'>
                                                    <select id="prime_entry_book_name_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                    <!--Prime entry books drop down-->
                                                    <div id="prime_entry_book_name_search_dropdown">
                                                    </div>
                                                    <!--End Prime entry books drop down-->
                                                    <div id="prime_entry_book_search_idError" class="red"></div>
                                                </div>
                                                <?php 
                                                if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
                                                    <div class='col-sm-12 controls'>
                                                        <div class='col-sm-3 controls' id='journal_entry_location_div'>
                                                            <select class='form-control' id='location_search'>

                                                            </select>
                                                            <div id='location_searchError' class='red'></div>
                                                        </div>
                                                    </div>
                                                <?php 
                                                } ?>
                                                <div class='col-sm-1 controls'>
                                                    <button class='btn btn-success' id="btnSearch" type='button' onclick="searchJournalEntries();"><?php echo $this->lang->line('Search') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                                
								<?php
								if (isset($ACM_Bookkeeping_Add_Journal_Entry_Permissions)) { ?>
									<button class='btn btn-success btn-sm new'
											type='button' <?php echo $menuFormatting; ?>>
										<?php echo $this->lang->line('Add New Journal Entry') ?>
									</button>
								<?php
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

	var JournalEntryID = '';
	var PrimeEntryBookHasAReferenceTransactionJournalEntry = 'No';

	$(document).ready(function () {
        $(".msg_instant").hide();
        
        $("#from_date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
        
		$("#to_date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
        
		$("#datepicker_transaction_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$("#datepicker_due_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		var date = new Date();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		
		var monthName = moment.months(month - 1);
		$("#month_name").text(monthName + "  " + year);
		$("#current_month").val(month);
		$("#current_year").val(year);
		
		getTableData(year, month);
		JournalEntry.getChartOfAccounts();
		JournalEntry.getPrimeEntryBooks();
		JournalEntry.getLocationsList();
		JournalEntry.getReferenceTransactionTypesDropdown();
		JournalEntry.init();
	});

	$("#btnAddAnotherDebitLedgerAccount").click(function (e){
		var cloneCount = 1;

		var element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_1");

		while (element.length == 1) {
			cloneCount++;
			element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_" + cloneCount);
		}

		var count = 2;
		var addNewRow = true;
		while (count < cloneCount) {
			if ($("#je_debit_chart_of_account_div_" + count).is(":visible")) {
				if (count == cloneCount) {
					addNewRow = true;
				}
			} else {
				$("#je_debit_chart_of_account_div_" + count).show();
				$("#je_debit_transaction_value_div_" + count).show();
				$("#btnDeleteDebitAccount_div_" + count).show();
				$("#btnDeleteDebitAccount_" + count).removeAttr("disabled");
				addNewRow = false;
				break;
			}
			count++;
		}

		if (addNewRow) {
			var newClonePrimeEntryBookChartOfAccount = $("#je_chart_of_accounts_div_1").clone().prop({ id: "je_chart_of_accounts_div_" + cloneCount}).appendTo("#je_chart_of_accounts_group");
			newClonePrimeEntryBookChartOfAccount.find("#je_chart_of_accounts_div_1").prop({ id: "je_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_accounts_div_1").prop({ id: "je_debit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_div_1").prop({ id: "je_debit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_1").prop({ id: "je_debit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_1Error").prop({ id: "je_debit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_div_1").prop({ id: "je_debit_transaction_value_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_1").prop({ id: "je_debit_transaction_value_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_1Error").prop({ id: "je_debit_transaction_value_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_div_1").prop({ id: "btnDeleteDebitAccount_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_1").prop({ id: "btnDeleteDebitAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_accounts_div_1").prop({ id: "je_credit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_div_1").prop({ id: "je_credit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_1").prop({ id: "je_credit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_1Error").prop({ id: "je_credit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_div_1").prop({ id: "je_credit_transaction_value_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_1").prop({ id: "je_credit_transaction_value_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_1Error").prop({ id: "je_credit_transaction_value_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_div_1").prop({ id: "btnDeleteCreditAccount_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_1").prop({ id: "btnDeleteCreditAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_" + cloneCount).val("0");
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_" + cloneCount).val("");
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_" + cloneCount).val("0");
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_" + cloneCount).val("");

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_" + cloneCount).removeAttr("disabled");

			$("#je_credit_chart_of_account_div_" + cloneCount).hide();
			$("#je_credit_transaction_value_div_" + cloneCount).hide();
			$("#btnDeleteCreditAccount_div_" + cloneCount).hide();

			$('<p id="row_space_' + cloneCount + '" style="margin-bottom:5px">&nbsp;</p>').appendTo("#je_chart_of_accounts_group");
		}
	});

	$("#btnAddAnotherCreditLedgerAccount").click(function (e){
		var cloneCount = 1;

		var element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_1");

		while (element.length == 1) {
			cloneCount++;
			element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_" + cloneCount);
		}

		var count = 2;
		var addNewRow = true;
		while (count < cloneCount) {
			if ($("#je_credit_chart_of_account_div_" + count).is(":visible")) {
				if (count == cloneCount) {
					addNewRow = true;
				}
			} else {
				$("#je_credit_chart_of_account_div_" + count).show();
				$("#je_credit_transaction_value_div_" + count).show();
				$("#btnDeleteCreditAccount_div_" + count).show();
				$("#btnDeleteCreditAccount_" + count).removeAttr("disabled");
				addNewRow = false;
				break;
			}
			count++;
		}

		if (addNewRow) {
			var newClonePrimeEntryBookChartOfAccount = $("#je_chart_of_accounts_div_1").clone().prop({ id: "je_chart_of_accounts_div_" + cloneCount}).appendTo("#je_chart_of_accounts_group");
			newClonePrimeEntryBookChartOfAccount.find("#je_chart_of_accounts_div_1").prop({ id: "je_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_accounts_div_1").prop({ id: "je_debit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_div_1").prop({ id: "je_debit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_1").prop({ id: "je_debit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_1Error").prop({ id: "je_debit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_div_1").prop({ id: "je_debit_transaction_value_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_1").prop({ id: "je_debit_transaction_value_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_1Error").prop({ id: "je_debit_transaction_value_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_div_1").prop({ id: "btnDeleteDebitAccount_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_1").prop({ id: "btnDeleteDebitAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_accounts_div_1").prop({ id: "je_credit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_div_1").prop({ id: "je_credit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_1").prop({ id: "je_credit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_1Error").prop({ id: "je_credit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_div_1").prop({ id: "je_credit_transaction_value_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_1").prop({ id: "je_credit_transaction_value_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_1Error").prop({ id: "je_credit_transaction_value_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteAccountSet_div_1").prop({ id: "btnDeleteAccountSet_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_1").prop({ id: "btnDeleteCreditAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#je_debit_chart_of_account_" + cloneCount).val("0");
			newClonePrimeEntryBookChartOfAccount.find("#je_debit_transaction_value_" + cloneCount).val("");
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_chart_of_account_" + cloneCount).val("0");
			newClonePrimeEntryBookChartOfAccount.find("#je_credit_transaction_value_" + cloneCount).val("");

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_" + cloneCount).removeAttr("disabled");

			$("#je_debit_chart_of_account_div_" + cloneCount).hide();
			$("#je_debit_transaction_value_div_" + cloneCount).hide();
			$("#btnDeleteDebitAccount_div_" + cloneCount).hide();

			$('<p id="row_space_' + cloneCount + '" style="margin-bottom:5px">&nbsp;</p>').appendTo("#je_chart_of_accounts_group");
		}
	});

	function deleteDebitAccount(id) {
		var value = id.substring(22,24);

		if (value != 1) {
			if ($("#je_credit_chart_of_account_div_" + value).is(":visible")) {
				$("#je_debit_chart_of_account_div_" + value).hide();
				$("#btnDeleteDebitAccount_div_" + value).hide();
				$("#btnDeleteDebitAccount_" + value).prop( "disabled", true );
				$("#je_debit_chart_of_account_" + value).val("0");
			} else {
				$("#je_chart_of_accounts_div_" + value).remove();
				$("#row_space_" + value).remove();
			}
		}
	}

	function deleteCreditAccount(id) {
		var value = id.substring(23,25);

		if (value != 1) {
			if ($("#je_debit_chart_of_account_div_" + value).is(":visible")) {
				$("#je_credit_chart_of_account_div_" + value).hide();
				$("#btnDeleteCreditAccount_div_" + value).hide();
				$("#btnDeleteCreditAccount_" + value).prop( "disabled", true );
				$("#je_credit_chart_of_account_" + value).val("0");
			} else {
				$("#je_chart_of_accounts_div_" + value).remove();
				$("#row_space_" + value).remove();
			}
		}
	}

	$(".new").click(function () {
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		$(".form").show();
		$(".edit_form").hide();
		clearForm();
	});

	function cancelData() {
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		
		$("#reference_transaction_type_id").val('0');
		$("#reference_transaction_type_div").hide()
		
		$("#reference_transaction_id").val('0');
		$("#reference_transaction_div").hide()
		
		$("#reference_journal_entry_id").val('0');
		$("#reference_journal_entry_div").hide()

		JournalEntry.getPrimeEntryBooks();
		JournalEntry.cancelData();
		$("#journal_entry_id").val('');
		clearForm();
		window.scrollTo(0,0);
	}

	function handleSaveEditData() {
		
		if (JournalEntryID == '') {
			var primeEntryBookId = $("#prime_entry_book_id").val();

			if (primeEntryBookId != "0") {
				JournalEntry.checkWhetherPrimeEntryBookHasAReferenceTransactionJournalEntry(primeEntryBookId);
			}

			setTimeout(function(){
				saveData();
			}, 500);
		} else {
			var primeEntryBookId = $("#prime_entry_book_id_hidden").val();

			if (primeEntryBookId != "0") {
				JournalEntry.checkWhetherPrimeEntryBookHasAReferenceTransactionJournalEntry(primeEntryBookId);
			}

			setTimeout(function(){
				editData();
			}, 500);
		}
	}

	function saveData() {

		$(".msg_data").hide();
		$(".msg_delete").hide();

		if (validateJournalEntry_save()){

			var primeEntryBookId = $("#prime_entry_book_id").val();
			var journalEntryId = $("#journal_entry_id").val();

			if (primeEntryBookId != "0" || journalEntryId != '') {
				if (validateAddAsANewPrimeEntryBook_save() && validatePayeePayerSelect_save()) {
					if (validateDebitTotalAndCreditTotal_save(primeEntryBookId, journalEntryId)) {
						JournalEntry.saveData("save_with_chart_of_account_values");
					}
				}
			} else {
				if (validatePayeePayerSelect_save()) {
					JournalEntry.saveData("save_without_chart_of_account_values");
					
					if (journalEntryId == '') {
						$("#journal_entry_values_for_chart_of_accounts_div").show();
						$("#add_as_a_prime_entry_div").show();
					}
				}
			}   
		}
	}

	function editData() {
		if (validateJournalEntry_edit()) {
			if (validateDebitTotalAndCreditTotal_save()) {
				JournalEntry.editData();
                window.scrollTo(0,0);
			}
		}
	}

	function get(id){
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		clearForm();
		JournalEntry.getData(id);
	}

	function del(primeEntryTransactionId){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		JournalEntry.deleteData(primeEntryTransactionId);
        window.scrollTo(0,0);
	}

	function handlePrimeEntryBookSelect(id) {
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		$("#journal_entry_values_for_prime_book_chart_of_accounts_div").show();
		JournalEntry.handleIfThereIsAReferenceJournalEntry($("#" + id).val());
		
		setTimeout(function(){
			JournalEntry.getChartOfAccountsToAddTransaction($("#" + id).val());
		}, 500);
	}

	function handleDebitTransactionValueAddition(id) {
		var cloneCount = 1;

		var value = $('#' + id).val();

		if (value != "") {
			var valueData = value.split(".");
			var valueDataSize = valueData.length;

			if (valueDataSize == 1) {
				value = value + ".00";
				$('#' + id).val(value);
			}
		} else {
			$('#' + id).val("0.00");
		}

		if (validateTransactionValue(id)) {

			var element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_1");

			while (element.length == 1) {
				cloneCount++;
				element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_" + cloneCount);
			}

			var count = 1;
			var totalValue = '0.00';
			while (count <= (cloneCount - 1)) {

				if ($("#debit_chart_of_account_div_" + count).is(":visible")) {
					totalValue = parseFloat(totalValue) + parseFloat($("#debit_transaction_value_" + count).val());
				}

				count++;
			}

			$("#debit_chart_of_account_total_value").val(totalValue.toFixed(2));
			balanceDebitTotalAndCreditTotal();
		}
	}

	function handleCreditTransactionValueAddition(id) {
		var cloneCount = 1;

		var value = $('#' + id).val();

		if (value != "") {
			var valueData = value.split(".");
			var valueDataSize = valueData.length;

			if (valueDataSize == 1) {
				value = value + ".00";
				$('#' + id).val(value);
			}
		} else {
			$('#' + id).val("0.00");
		}

		if (validateTransactionValue(id)) {

			var element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_1");

			while (element.length == 1) {
				cloneCount++;
				element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_" + cloneCount);
			}

			var count = 1;
			var totalValue = '0.00';
			while (count <= (cloneCount - 1)) {

				if ($("#credit_chart_of_account_div_" + count).is(":visible")) {
					totalValue = parseFloat(totalValue) + parseFloat($("#credit_transaction_value_" + count).val());
				}

				count++;
			}

			$("#credit_chart_of_account_total_value").val(totalValue.toFixed(2));
			balanceDebitTotalAndCreditTotal();
		}
	}

	function handleJEDebitTransactionValueAddition(id) {
		var cloneCount = 1;

		var value = $('#' + id).val();

		if (value != "") {
			var valueData = value.split(".");
			var valueDataSize = valueData.length;

			if (valueDataSize == 1) {
				value = value + ".00";
				$('#' + id).val(value);
			}
		} else {
			$('#' + id).val("0.00");
		}

		if (validateTransactionValue(id)) {

			var element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_1");

			while (element.length == 1) {
				cloneCount++;
				element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_" + cloneCount);
			}

			var count = 1;
			var totalValue = '0.00';
			while (count <= (cloneCount - 1)) {

				if ($("#je_debit_chart_of_account_div_" + count).is(":visible")) {
					totalValue = parseFloat(totalValue) + parseFloat($("#je_debit_transaction_value_" + count).val());
				}

				count++;
			}

			$("#je_debit_chart_of_account_total_value").val(totalValue.toFixed(2));
			balanceJEDebitTotalAndCreditTotal();
		}
	}

	function handleJECreditTransactionValueAddition(id) {
		var cloneCount = 1;

		var value = $('#' + id).val();

		if (value != "") {
			var valueData = value.split(".");
			var valueDataSize = valueData.length;

			if (valueDataSize == 1) {
				value = value + ".00";
				$('#' + id).val(value);
			}
		} else {
			$('#' + id).val("0.00");
		}

		if (validateTransactionValue(id)) {

			var element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_1");

			while (element.length == 1) {
				cloneCount++;
				element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_" + cloneCount);
			}

			var count = 1;
			var totalValue = '0.00';
			while (count <= (cloneCount - 1)) {

				if ($("#je_credit_chart_of_account_div_" + count).is(":visible")) {
					totalValue = parseFloat(totalValue) + parseFloat($("#je_credit_transaction_value_" + count).val());
				}

				count++;
			}

			$("#je_credit_chart_of_account_total_value").val(totalValue.toFixed(2));
			balanceJEDebitTotalAndCreditTotal();
		}
	}

	function handleChartOfAccountSelect(id) {
		$(".msg_data").hide();
		JournalEntry.isLastNodeSelectedInChartOfAccountHierarchy(id);
	}

	function handleAddPrimeEntryBookSelect(id) {
		if ($("#add_prime_entry_book").prop("checked") == true) {
			$("#new_prime_entry_book_name_div").show();
		} else {
			$("#new_prime_entry_book_name_div").hide();
		}
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

		getTableData(currentYear, currentMonth);
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

		getTableData(currentYear, currentMonth);
	}
	
	function handleReferenceTransactionTypeSelect(id) {
        var date = $("#transaction_date").val();
		JournalEntry.getReferenceTransactionListForSelectedType($("#" + id).val(), date);
	}
	
	function handleReferenceTransactionSelect(id) {
		JournalEntry.getReferenceJournalEntryListForSelectedTransaction($("#reference_transaction_type_id").val(), $("#" + id).find('option:selected').text());
	}
	
	function getPeopleType(id) {
		var payeePayerType = $("#" + id).val();
		
		JournalEntry.getPayeePayerList(payeePayerType, "");
	}
    
    function searchJournalEntries() {
		$("#month_selector").hide();
		getTableData("", "");
	}
	
	var JournalEntry = {
		
		cancelData: function () {
			$(".form").hide();
		},

		saveData: function (saveOption) {

			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
        
            var msgError = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('Previous financial year is not closed! Please close the previous financal year before add transactions.')?>' +
				'</div>';

			var journalEntryChartOfAccountDataEnteredCorrectly = true;

			var primeEntryBookId = $("#prime_entry_book_id").val();
			var journalEntryId = $("#journal_entry_id").val();
			var payeePayerType = $("#payee_payer_type").val();
			
			var payeePayerId = '0';
			if (payeePayerType != '0' && payeePayerType != '') {
				payeePayerId = $("#people_id").val();
			}

			if (saveOption == "save_with_chart_of_account_values" && journalEntryId != '') {
				var count = 1;
				while ($("#je_chart_of_accounts_div_" + count).length > 0) {

					if ($("#je_debit_chart_of_account_div_" + count).is(":visible")) {
						if (!validateDebitAccount(count)) {
							journalEntryChartOfAccountDataEnteredCorrectly = false;
						}
					}

					if ($("#je_credit_chart_of_account_div_" + count).is(":visible")) {
						if (!validateCreditAccount(count)) {
							journalEntryChartOfAccountDataEnteredCorrectly = false;
						}
					}

					var debitChartOfAccountId = '';
					var creditChartOfAccountId = '';
					$("[name='je_debit_chart_of_account']").each(function() {
						debitChartOfAccountId = $(this).val();
						$("[name='je_credit_chart_of_account']").each(function() {
							creditChartOfAccountId = $(this).val();

							if (!isNotSameChartOfAccount(debitChartOfAccountId, creditChartOfAccountId)) {
								journalEntryChartOfAccountDataEnteredCorrectly = false;
								return false;
							}
						});

						if (!journalEntryChartOfAccountDataEnteredCorrectly) {
							return false;
						}
					});

					count++;
				}
			}
			//alert(journalEntryChartOfAccountDataEnteredCorrectly)
			if (journalEntryChartOfAccountDataEnteredCorrectly === true) {

				// send the formData
				var debitChartOfAccountIdList = new Array();
				var creditChartOfAccountIdList = new Array();

				var debitChartOfAccountValueList = new Array();
				var creditChartOfAccountValueList = new Array();

				var formData = new FormData($("#journal_entry_form")[0]);

				if (saveOption == "save_with_chart_of_account_values") {

					if (primeEntryBookId != "0" && journalEntryId == '') {
						formData.append('journal_entry_id', journalEntryId);
						formData.append('prime_entry_book_id', $("#prime_entry_book_id").val());
						formData.append('transaction_date', $("#transaction_date").val());
						formData.append('payee_payer_type', payeePayerType);
						formData.append('payee_payer_id', payeePayerId);
						formData.append('due_date', $("#due_date").val());
						formData.append('reference_no', $("#reference_no").val());
						<?php
						if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
							formData.append('location_id', $("#location").val());
						<?php 
						} else { ?>
							formData.append('location_id', '');
						<?php
						}
						?>
						formData.append('description', $("#description").val());
						formData.append('prime_entry_book_name', $("#prime_entry_book_name").val());
						
						if (PrimeEntryBookHasAReferenceTransactionJournalEntry == "Yes") {
							formData.append('reference_transaction_type_id', $("#reference_transaction_type_id").val());
							formData.append('reference_transaction_id', $("#reference_transaction_id").val());
							formData.append('reference_journal_entry_id', $("#reference_journal_entry_id").val());
						}

						var debitElementId = '';
						var creditElementId = '';
						var value = '';
						$("[name='debit_transaction_value']").each(function() {
							debitElementId = this.id;
							var value = debitElementId.substring(24,26);

							if ($("#debit_transaction_value_div_" + value).is(":visible")) {
								debitChartOfAccountIdList.push($("#debit_chart_of_account_id_" + value).val());
								debitChartOfAccountValueList.push($(this).val());
							}
						});

						$("[name='credit_transaction_value']").each(function() {
							creditElementId = this.id;
							var value = creditElementId.substring(25,27);

							if ($("#credit_transaction_value_div_" + value).is(":visible")) {
								creditChartOfAccountIdList.push($("#credit_chart_of_account_id_" + value).val());
								creditChartOfAccountValueList.push($(this).val());
							}
						});
					} else if (journalEntryId != '') {
						if (primeEntryBookId != "0") {
							formData.append('prime_entry_book_id', $("#prime_entry_book_id").val());
						} else {
							formData.append('prime_entry_book_id', "");
						}

						formData.append('journal_entry_id', journalEntryId);
						formData.append('transaction_date', $("#transaction_date").val());
						formData.append('payee_payer_type', payeePayerType);
						formData.append('payee_payer_id', payeePayerId);
						formData.append('due_date', $("#due_date").val());
						formData.append('reference_no', $("#reference_no").val());
						<?php
						if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
							formData.append('location_id', $("#location").val());
						<?php 
						} else { ?>
							formData.append('location_id', '');
						<?php
						}
						?>
						formData.append('description', $("#description").val());
						
						if (PrimeEntryBookHasAReferenceTransactionJournalEntry == "Yes") {
							formData.append('reference_transaction_type_id', $("#reference_transaction_type_id").val());
							formData.append('reference_transaction_id', $("#reference_transaction_id").val());
							formData.append('reference_journal_entry_id', $("#reference_journal_entry_id").val());
						}

						var debitElementId = '';
						var creditElementId = '';
						var value = '';
						$("[name='je_debit_transaction_value']").each(function() {
							debitElementId = this.id;
							var value = debitElementId.substring(27,29);

							if ($("#je_debit_transaction_value_div_" + value).is(":visible")) { 
								debitChartOfAccountIdList.push($("#je_debit_chart_of_account_" + value).val());
								debitChartOfAccountValueList.push($(this).val());
							}
						});

						$("[name='je_credit_transaction_value']").each(function() {
							creditElementId = this.id;
							var value = creditElementId.substring(28,30);

							if ($("#je_credit_transaction_value_div_" + value).is(":visible")) {
								creditChartOfAccountIdList.push($("#je_credit_chart_of_account_" + value).val());
								creditChartOfAccountValueList.push($(this).val());
							}
						});
					}

					formData.append('debit_chart_of_account_id', debitChartOfAccountIdList);
					formData.append('credit_chart_of_account_id', creditChartOfAccountIdList);
					formData.append('debit_chart_of_account_value', debitChartOfAccountValueList);
					formData.append('credit_chart_of_account_value', creditChartOfAccountValueList);

					formData.append('save_option', "save_with_chart_of_account_values");

				} else if (saveOption == "save_without_chart_of_account_values") {

					formData.append('transaction_date', $("#transaction_date").val());
					formData.append('payee_payer_type', payeePayerType);
					formData.append('payee_payer_id', payeePayerId);
					formData.append('due_date', $("#due_date").val());
					formData.append('reference_no', $("#reference_no").val());
					<?php
					if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
						formData.append('location_id', $("#location").val());
					<?php 
					} else { ?>
						formData.append('location_id', '');
					<?php
					}
					?>
					formData.append('description', $("#description").val());
					
					if (PrimeEntryBookHasAReferenceTransactionJournalEntry == "No") {
						formData.append('reference_transaction_type_id', '0');
						formData.append('reference_transaction_id', '0');
						formData.append('reference_journal_entry_id', '0');
					}

					formData.append('save_option', "save_without_chart_of_account_values");

				}

				formData.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>'),                    

                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');

                if (saveOption == "save_with_chart_of_account_values") {
                    window.scrollTo(0,0);
                }
                            
				$.ajax({
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/add",
					type : 'POST',
					data : formData,
					processData: false,
					contentType: false,
					dataType: 'json',
					beforeSend: function() {
						$("#btnSaveJournalEntry:input").attr('disabled', true);
					},
					success: function(response) {
                        
                        $(".msg_instant").hide();
                        
						if (response.result === "ok") {
							
							$("#journal_entry_id").val(response.journalEntryId);
							$("#btnSaveJournalEntry:input").attr('disabled', false);

							if (saveOption == "save_with_chart_of_account_values") {
								clearForm();
							} else {
								$("#people_id").select2();
							}

							var year = $("#current_year").val();
							var month = $("#current_month").val();
							getTableData(year, month);
                            
                            $(".validation").hide();
							$(".msg_data").show();
							$(".msg_data").html(msg);
						} else {
							$(".msg_data").show();
							$(".msg_data").html(msgError);
							$("#btnSaveJournalEntry:input").attr('disabled', false);
						}
					}
				});
			}
		},

		editData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
        
            var msgError = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('The financial year of the transaction you are trying to edit is already closed!')?>' +
				'</div>';

			// send the formData
			var debitChartOfAccountIdList = new Array();
			var creditChartOfAccountIdList = new Array();

			var debitChartOfAccountValueList = new Array();
			var creditChartOfAccountValueList = new Array();
			
			var payeePayerType = $("#payee_payer_type").val();
			
			var payeePayerId = '0';
			if (payeePayerType != '0' && payeePayerType != '') {
				payeePayerId = $("#people_id").val();
			}

			var formData = new FormData($("#journal_entry_form")[0]);
			formData.append('journal_entry_id', $("#journal_entry_id_hidden").val());
			formData.append('prime_entry_book_id', $("#prime_entry_book_id_hidden").val());
			formData.append('transaction_date', $("#transaction_date").val());
			formData.append('payee_payer_type', payeePayerType);
			formData.append('payee_payer_id', payeePayerId);
			formData.append('due_date', $("#due_date").val());
			formData.append('reference_no', $("#reference_no").val());
			<?php
			if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
				formData.append('location_id', $("#location").val());
			<?php 
			} else { ?>
				formData.append('location_id', '');
			<?php
			}
			?>
			formData.append('description', $("#description").val().trim());
			
			if (PrimeEntryBookHasAReferenceTransactionJournalEntry == "Yes") {
				formData.append('reference_transaction_type_id', $("#reference_transaction_type_id").val());
				formData.append('reference_transaction_id', $("#reference_transaction_id").val());
				formData.append('reference_journal_entry_id', $("#reference_journal_entry_id").val());
			}

			var debitElementId = '';
			var creditElementId = '';
			var value = '';
			$("[name='debit_transaction_value']").each(function() {
				debitElementId = this.id;
				var value = debitElementId.substring(24,26);

				if ($("#debit_transaction_value_div_" + value).is(":visible")) {
					debitChartOfAccountIdList.push($("#debit_chart_of_account_id_" + value).val());
					debitChartOfAccountValueList.push($(this).val());
				}
			});

			$("[name='credit_transaction_value']").each(function() {
				creditElementId = this.id;
				var value = creditElementId.substring(25,27);

				if ($("#credit_transaction_value_div_" + value).is(":visible")) {
					creditChartOfAccountIdList.push($("#credit_chart_of_account_id_" + value).val());
					creditChartOfAccountValueList.push($(this).val());
				}
			});

			formData.append('debit_chart_of_account_id', debitChartOfAccountIdList);
			formData.append('credit_chart_of_account_id', creditChartOfAccountIdList);
			formData.append('debit_chart_of_account_value', debitChartOfAccountValueList);
			formData.append('credit_chart_of_account_value', creditChartOfAccountValueList);
			formData.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>'),                    

            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
            
			$.ajax({
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/edit",
				type : 'POST',
				data : formData,
				processData: false,
				contentType: false,
				dataType: 'html',
				beforeSend: function() {
					$("#btnSaveJournalEntry:input").attr('disabled', true);
				},
				success: function(response) {
                    
                    $(".msg_instant").hide();
                    
					if (response === "ok") {
						
						$("#btnSaveJournalEntry:input").attr('disabled', false);
						
						clearForm();
						
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month);
                        
                        $(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
					} else {
						$(".msg_data").show();
						$(".msg_data").html(msgError);
						$("#btnSaveJournalEntry:input").attr('disabled', false);
					}
				}
			});
		},

		deleteData: function (primeEntryTransactionId) {
        
            var msgError = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('The financial year of the transaction you are trying to delete is already closed!')?>' +
				'</div>';
        
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('journal entry') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/delete",
					data: {
						'id': primeEntryTransactionId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'json',
					success: function (response) {
                        if (response.result == 'ok') {
                            clearForm();
                            $(".form").hide();
                            $(".edit_form").hide();

                            var year = $("#current_year").val();
                            var month = $("#current_month").val();
                            getTableData(year, month);

                            $(".msg_instant").hide();
                            $(".msg_delete").show();
                            $(".msg_delete").html(response);
                        } else {
                            $(".msg_instant").hide();
                            $(".msg_data").show();
                            $(".msg_data").html(msgError);
                        }
					}
				});
			}
		},

		getData: function (id) {
			JournalEntryID = id;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/get",
				data: {
					'journal_entry_id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
					success:
				function (response) {
					$(".form").show();
					$("#prime_entry_book_name_div").empty();
					$("#prime_entry_book_name_div").append(response.primeEntryBookName);
					$("#journal_entry_date_div").empty();
					$("#journal_entry_date_div").append(response.transactionDate);
					
					if (response.payeePayerType != '') {
						$("#payee_payer_type_div").empty();
						$("#payee_payer_type_div").append(response.payeePayerTypeData);
						
						JournalEntry.getPayeePayerList(response.payeePayerType);
						
						setTimeout(function(){
							$("#people_id").val(response.payeePayerId).trigger('change');
						}, 1000);
					}
				
					$("#reference_no_div").empty();
					$("#reference_no_div").append(response.referenceNo);
					
					if (response.referenceTransactionType != '') {
						$('#reference_transaction_type_div').show();
						$('#reference_transaction_type_init').hide();
						$("#reference_transaction_type_dropdown").html(response.referenceTransactionType);
					}
					
					if (response.referenceTransaction != '') {
						$('#reference_transaction_div').show();
						$('#reference_transaction_init').hide();
						$("#reference_transaction_dropdown").html(response.referenceTransaction);
						$("#reference_transaction_id").select2();
					}
					
					if (response.referenceJournalEntry != '') {
						$('#reference_journal_entry_div').show();
						$('#reference_journal_entry_init').hide();
						$("#reference_journal_entry_dropdown").html(response.referenceJournalEntry);
						$("#reference_journal_entry_id").select2();
					}
					
					$("#location_dropdown").empty();
					$("#location_dropdown").append(response.location);
					$("#journal_entry_description_div").empty();
					$("#due_date_div").empty();
					$("#due_date_div").append(response.dueDate);
					$("#journal_entry_description_div").append(response.description);
					$("#chart_of_accounts_group").empty();
					$("#chart_of_accounts_group").append(response.chartOfAccountsGroups);
					$("#debit_chart_of_account_total_value").val(response.debitAmountValueTotal);
					$("#credit_chart_of_account_total_value").val(response.creditAmountValueTotal);
					$("#journal_entry_values_for_prime_book_chart_of_accounts_div").show();
					$("#journal_entry_id").val(id);
					$(".loader").hide();
					window.scrollTo(0,0);

					$("#datepicker_transaction_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					$("#datepicker_due_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
				}
			});
		},

		//get prime entry books drop down
		getPrimeEntryBooks: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getAllPrimeEntryBooksToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
                    $('#prime_entry_book_name_init').hide();
                    $("#prime_entry_book_name_dropdown").html(response);
                    $("#prime_entry_book_id").select2();
                    
                    $('#prime_entry_book_name_search_init').hide();
                    $("#prime_entry_book_name_search_dropdown").html(response);
                    $("#prime_entry_book_name_search_dropdown").find("#prime_entry_book_id").prop({ id: "prime_entry_book_search_id"});
                    $("#prime_entry_book_search_id").select2();
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
					$("#je_debit_chart_of_account_div_1").empty();
					$("#je_credit_chart_of_account_div_1").empty();
					$("#je_debit_chart_of_account_div_1").append(chartOfAccountsDropDown);
					$('#chart_of_account').attr('name', 'je_debit_chart_of_account');
					$("#chart_of_account").prop({ id: "je_debit_chart_of_account_1"});
					$("#chart_of_accountError").prop({ id: "je_debit_chart_of_account_1Error"});
					$("#je_credit_chart_of_account_div_1").append(chartOfAccountsDropDown);
					$('#chart_of_account').attr('name', 'je_credit_chart_of_account');
					$("#chart_of_account").prop({ id: "je_credit_chart_of_account_1"});
					$("#chart_of_accountError").prop({ id: "je_credit_chart_of_account_1Error"});
				}
			});
		},

		handleIfThereIsAReferenceJournalEntry : function(id) {

			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/isThereAReferenceTransactionJournalEntry",
				data: {
					'prime_entry_book_id' : id,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(response) {
					if (response == '1') {
						$("#reference_transaction_type_div").show();
					} else {
						$("#reference_transaction_type_div").hide();
						$("#reference_transaction_type_id").val('0');
						$("#reference_transaction_div").hide();
						$("#reference_transaction_id").val('0');
						$("#reference_journal_entry_div").hide();
						$("#reference_journal_entry_id").val('0');
					}
				}
			});
		},
		
		getChartOfAccountsToAddTransaction : function(id) {

			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getChartOfAccountsToAddTransaction",
				data: {
					'prime_entry_book_id' : id,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(response) {
					if (response != '') {
						$("#chart_of_accounts_group").empty();
						$("#chart_of_accounts_group").append(response);
						$("#debit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});
						$("#credit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});
					}
				}
			});
		},

		isLastNodeSelectedInChartOfAccountHierarchy : function(id) {
			var msg = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('should_select_last_chart_of_account_in_hierarchy')?>' +
				'</div>';

			var chartOfAccountId = $("#" + id).val();

			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/hasChildren",
				data: {
					'chart_of_account_id' : chartOfAccountId,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(response) {
					if (response == "Yes") {
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$("#" + id).val("0");
					}
				}
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
			});
		},
		
		//get reference transaction list drop down
		getReferenceTransactionListForSelectedType: function (transactionTypeId, date) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceTransactionListForSelectedType",
				data: {
					'transaction_type_id' : transactionTypeId,
                    'transaction_date' : date,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					if (response != 'other') {
						$("#reference_transaction_div").show();
						$('#reference_transaction_init').hide();
						$("#reference_transaction_dropdown").html(response);
						$("#reference_transaction_id").select2();
					} else {
						$("#reference_transaction_div").hide();
						JournalEntry.getReferenceJournalEntryListForSelectedTransaction(transactionTypeId, '', date);
					}
				}
			});
		},
		
		//get reference journal entry list drop down
		getReferenceJournalEntryListForSelectedTransaction: function (transactionTypeId, transactionReferenceNo, date) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getReferenceJournalEntryListForSelectedTransaction",
				data: {
					'transaction_type_id' : transactionTypeId,
					'transaction_reference_no' : transactionReferenceNo,
                    'transaction_date' : date,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					$("#reference_journal_entry_div").show();
					$('#reference_journal_entry_init').hide();
					$("#reference_journal_entry_dropdown").html(response);
					$("#reference_journal_entry_id").select2();
				}
			});
		},
		
		checkWhetherPrimeEntryBookHasAReferenceTransactionJournalEntry: function (primeEntryBookId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/isThereAReferenceTransactionJournalEntry",
				data: {
					'prime_entry_book_id' : primeEntryBookId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					if (response == '1') {
						PrimeEntryBookHasAReferenceTransactionJournalEntry = "Yes";
					} else {
						PrimeEntryBookHasAReferenceTransactionJournalEntry = "No";
					}
				}
			});
		},
		
		getPayeePayerList: function (payeePayerType) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getPeopleListAccordingToTheCategory",
				data: {
					'people_category' : payeePayerType,
					'type' : "Add",
					'mandatory_field' : 'Yes',
					'get_with_all_option' : '',
					'get_with_label' : 'Yes',
					'label_col_position' : "3",
					'drop_down_col_position' : "5",
					'show_people_code' : true,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					$("#people_list_div").show();
					$("#people_list").empty();
					$("#people_list").append(response);
					$("#sales_rep_id").prop({id : "people_id"});
					$("#people_id").select2();
				}
			});
		},
		
		init : function () {
			$("#table").show();
			$(".form").hide();
			$(".edit_form").hide();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
			$("#description").text('');
			$("#journal_entry_values_for_prime_book_chart_of_accounts_div").hide();
			$("#journal_entry_values_for_chart_of_accounts_div").hide();
			$("#add_as_a_prime_entry_div").hide();
			$("#new_prime_entry_book_name_div").hide();
			$("#reference_transaction_type_div").hide();
			$("#reference_transaction_div").hide();
			$("#reference_journal_entry_div").hide();
			$("#people_list_div").hide();
		},

		getLocationsList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getLocationDropDown",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
					},
				dataType: 'html',
				success: function(locationList) {
					$("#location_dropdown").html(locationList);
				}
			});
		}
	}

	function validateDebitAccount(count) {
		return (isSelected("je_debit_chart_of_account_" + count, "<?php echo $this->lang->line('debit_chart_of_account_required')?>"));
	}

	function validateCreditAccount(count) {
		return (isSelected("je_credit_chart_of_account_" + count, "<?php echo $this->lang->line('credit_chart_of_account_required')?>"));
	}

	function isNotSameChartOfAccount(debitValue, creditValue) {
		if (debitValue != "0" || creditValue != "0") {
			if (debitValue != creditValue) {
				return true;
			} else {
				alert("<?php echo $this->lang->line('Debit chart of account and credit chart of account cannot be same')?>");
				return false;
			}
		}
	}

	function validateJournalEntry_save() {
		return (isPrimeEntryBookRequiredToSelect()
			 && isNotEmpty("transaction_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			 && validateLocation()
			 && validateReferenceTransactionType()
			 && validateReferenceTransaction()
			 && validateReferenceJournalEntry());
	}

	function isPrimeEntryBookRequiredToSelect() {

		var addAdvancedJournalEntryPermission = '<?php echo isset($ACM_Bookkeeping_Add_Advanced_Journal_Entry_Permissions); ?>';

		if (addAdvancedJournalEntryPermission == '') {
			if ($("#prime_entry_book_id").val() != '0') {
				return isSelected("prime_entry_book_id", "<?php echo $this->lang->line('Prime Entry Book').' '.$this->lang->line('field is required')?>");;
			} else {
				return isSelected("prime_entry_book_id", "<?php echo $this->lang->line('Prime Entry Book').' '.$this->lang->line('field is required')?>");
			}
		} else {
			return true;
		}
	}

	function validateJournalEntry_edit() {
		return (isNotEmpty("transaction_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			 && validateLocation()
			 && validateReferenceTransactionType()
			 && validateReferenceTransaction()
			 && validateReferenceJournalEntry());
	}

	function validateLocation() {
		<?php 
		if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
			return isSelected("location", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>");
		<?php 
		} else { ?>
			return true;
		<?php
		}
		?>
	}
	
	function validateReferenceTransactionType() {
		if ($("#reference_transaction_type_id").is(":visible")) {
			return isSelected("reference_transaction_type_id", "<?php echo $this->lang->line('Reference Transaction Type').' '.$this->lang->line('field is required')?>");
		} else {
			return true;
		}
	}
	
	function validateReferenceTransaction() {
		if ($("#reference_transaction_id").is(":visible")) {
			return isSelected("reference_transaction_id", "<?php echo $this->lang->line('Reference Transaction').' '.$this->lang->line('field is required')?>");
		} else {
			return true;
		}
	}
	
	function validateReferenceJournalEntry() {
		if ($("#reference_journal_entry_id").is(":visible")) {
			return isSelected("reference_journal_entry_id", "<?php echo $this->lang->line('Reference Journal Entry').' '.$this->lang->line('field is required')?>");
		} else {
			return true;
		}
	}

	function validateTransactionValue(id) {
		return isFloot(id, "<?php echo $this->lang->line('transaction_value').' '.$this->lang->line('is not valid')?>");
	}

	function balanceDebitTotalAndCreditTotal(){
		var debitTotal = $("#debit_chart_of_account_total_value").val();
		var creditTotal = $("#credit_chart_of_account_total_value").val();

		if (debitTotal != creditTotal) {
			$("#debit_chart_of_account_total_value").css({'background-color' : red});
			$("#credit_chart_of_account_total_value").css({'background-color' : red});
			$("#btnSaveJournalEntry:input").attr('disabled', true);

		} else {
			$("#debit_chart_of_account_total_value").css({'background-color' : '#aafaea'});
			$("#credit_chart_of_account_total_value").css({'background-color' : '#aafaea'});
			$("#btnSaveJournalEntry:input").attr('disabled', false);
		}
	}

	function balanceJEDebitTotalAndCreditTotal(){
		var debitTotal = $("#je_debit_chart_of_account_total_value").val();
		var creditTotal = $("#je_credit_chart_of_account_total_value").val();

		if (debitTotal != creditTotal) {
			$("#je_debit_chart_of_account_total_value").css({'background-color' : red});
			$("#je_credit_chart_of_account_total_value").css({'background-color' : red});
			$("#btnSaveJournalEntry:input").attr('disabled', true);

		} else {
			$("#je_debit_chart_of_account_total_value").css({'background-color' : '#aafaea'});
			$("#je_credit_chart_of_account_total_value").css({'background-color' : '#aafaea'});
			$("#btnSaveJournalEntry:input").attr('disabled', false);
		}
	}

	function validateDebitTotalAndCreditTotal_save(primeEntryBookId, journalEntryId) {

		var debitTotal = '';
		var creditTotal = '';

		if (primeEntryBookId != "0") {
			debitTotal = $("#debit_chart_of_account_total_value").val();
			creditTotal = $("#credit_chart_of_account_total_value").val();
		} else if (journalEntryId != '') {
			debitTotal = $("#je_debit_chart_of_account_total_value").val();
			creditTotal = $("#je_credit_chart_of_account_total_value").val();
		}

		if (debitTotal == '' && creditTotal == '') {
			alert("<?php echo $this->lang->line('Debit and credit amounts not added')?>");
			return false;
		} else {
			return true;
		}
	}

	function validateAddAsANewPrimeEntryBook_save() {
		if ($("#add_prime_entry_book").prop("checked") == true) {
			return (isNotEmpty("prime_entry_book_name", "<?php echo $this->lang->line('Prime Entry Book Name').' '.$this->lang->line('field is required')?>"));
		} else {
			return true;
		}
	}
	
	function validatePayeePayerSelect_save() {
		if ($("#payee_payer_type").val() != '') {
			return (isSelected("people_id", "<?php echo $this->lang->line('Payee/payer Name').' '.$this->lang->line('field is required')?>"));
		} else {
			return true;
		}
	}

	//get all data
	function getTableData(year, month) {
		$(".loader").show();
        
        var fromDate = '';
        var toDate = '';
        var primeEntryBookId = '';
		var locationId = '';
        
        fromDate = $("#from_date").val();
        toDate = $("#to_date").val();

		if ($("#prime_entry_book_search_id").val() != '0') {
			primeEntryBookId = $("#prime_entry_book_search_id").val()
		} else {
			primeEntryBookId = '';
		}

		if ($("#location").length) {
			locationId = $("#location").val();
		} else {
			locationId = '';
		}
        
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
                'from_date' : fromDate,
				'to_date' : toDate,
				'prime_entry_book_id' : primeEntryBookId,
				'location_id' : locationId,
				'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
			success:
			function (response) {
				$("#dataTable").html(response);
				$(".loader").hide();
				
				var monthName = moment.months(month - 1);
				$("#month_name").text(monthName + "  " + year);
				
				$('.table').dataTable({
					"aaSorting": [[ 0, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		});
	}

	function clearForm() {
		$("#prime_entry_book_id").val('0').trigger('change');
		$("#transaction_date").val('');
		$("#payee_payer_type").val('');
		$("#people_id").val('0');
		$("#people_list_div").hide();
		$("#reference_no").val('');
		$("#reference_transaction_type_id").val('0');
		$("#reference_transaction_type_div").hide();
		
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
		
		$("#location").val('0');
		$("#description").val('');
		$("#journal_entry_values_for_prime_book_chart_of_accounts_div").hide();
		$("#journal_entry_values_for_chart_of_accounts_div").hide();
		$("#add_as_a_prime_entry_div").hide();
		$("#new_prime_entry_book_name_div").hide();
		$("#journal_entry_id").val('');
		$("#je_debit_chart_of_account_1").val('0');
		$("#je_credit_chart_of_account_1").val('0');
		$("#je_debit_transaction_value_1").val('');
		$("#je_credit_transaction_value_1").val('');

		$("#add_prime_entry_book").prop('checked', false);
		$("#prime_entry_book_name").val('');

		$("#debit_chart_of_account_total_value").val('');
		$("#credit_chart_of_account_total_value").val('');
		$("#debit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});
		$("#credit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});

		$("#je_debit_chart_of_account_total_value").val('');
		$("#je_credit_chart_of_account_total_value").val('');
		$("#je_debit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});
		$("#je_credit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});

		var cloneCount = 2;

		var element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_2");

		while (element.length == 1) {
			$("#je_chart_of_accounts_div_" + cloneCount).remove();
			$("#row_space_" + cloneCount).remove();
			cloneCount++;
			element = $("#je_chart_of_accounts_group").find("#je_chart_of_accounts_div_" + cloneCount);
		}

		JournalEntryID = '';
	}

	</script>

	<style>

	.light_color_background {
		background: #eafaea;
	}

	hr.light {
		width:97%; 
		margin-left: 15px !important; 
		border:0px none white; 
		border-top:1px solid lightgrey; 
	}
</style>
