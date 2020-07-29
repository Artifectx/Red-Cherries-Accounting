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
								<span><?php echo $this->lang->line('Prime Entry Books') ?></span>
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
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Prime Entry Books') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<form class='form form-horizontal validate-form save_form' id="prime_entry_book_form" method="post">
										<div id='unit_conversion'>
											<div class="row">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Prime Entry Book Name') ?> *</label>
													</div>
													<div class='col-sm-5 controls' id="prime_entry_book_name_div">
														<input class='form-control' id='prime_entry_book_name' name='prime_entry_book_name' 
															   type='text' value="" placeholder='<?php echo $this->lang->line('Prime Entry Book Name') ?>'>
														<div id='prime_entry_book_nameError' class='red'></div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Description') ?></label>
													</div>
													<div class='col-sm-5 controls' id="prime_entry_book_description_div">
														<textarea class='form-control' id='description' name='description'
															   placeholder='<?php echo $this->lang->line('Description') ?>' type='text' value="<?php echo set_value('description'); ?>">
														</textarea>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls' style="text-align:right">
														<label class='control-label'><?php echo $this->lang->line('Applicable Module') ?></label>
													</div>
													<div class='col-sm-5 controls' id="prime_entry_book_applicable_module_div">
														<select class="form-control" id="applicable_module" name="applicable_module">
															<option value="0"><?php echo $this->lang->line('-- Select --') ?></option>
															<option value="6"><?php echo $this->lang->line('Service Manager') ?></option>
															<option value="7"><?php echo $this->lang->line('Accounts Manager') ?></option>
														</select>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class='col-sm-12 controls'>
													<div class='col-sm-3 controls'></div>
													<div class='col-sm-5 controls'>
														<input type="checkbox" name="has_reference_transaction_journal_entry" id="has_reference_transaction_journal_entry" style="vertical-align: text-bottom;">
														<label for="has_reference_transaction_journal_entry" ><?php echo $this->lang->line('Has reference transaction journal entry') ?></label>
													</div>
												</div>
											</div>
										</div>
										<p style="margin-bottom:0px">&nbsp;&nbsp;&nbsp;&nbsp;</p>
										<div class='box'>
											<div class='box-header'>
												<div class='title'><?php echo $this->lang->line('Prime Entry Book Ledger Accounts') ?></div>
											</div>
											<div class='box-content light_color_background'>
												<div id='chart_of_accounts_headers'>
													<div class='col-sm-12 controls row'>
														<div class='col-sm-6 controls'">
															<div class='col-sm-10 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Debit Chart of Account') ?></label>
															</div>
															<div class='col-sm-2 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Delete') ?></label>
															</div>
														</div>
														<div class='col-sm-6 controls'>
															<div class='col-sm-10 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Credit Chart of Account') ?></label>
															</div>
															<div class='col-sm-2 controls' style="text-align:center">
																<label class='control-label'><?php echo $this->lang->line('Delete') ?></label>
															</div>
														</div>
													</div>
												</div>
												<p style="margin-bottom:-10px">&nbsp;</p>
												<div id="chart_of_accounts_group">
													<div class='col-sm-12 controls row' id="chart_of_accounts_div_1">
														<div class='col-sm-6 controls' id="debit_chart_of_accounts_div_1">
															<div class='col-sm-10 controls' id='debit_chart_of_account_div_1' name='debit_chart_of_account_div_1' style="text-align:center">
																<select class='select form-control' id='debit_chart_of_account_1' name='debit_chart_of_account'>
																	<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																</select>
																<div id='debit_chart_of_account_1Error' class='red'></div>
															</div>
															<div class='col-sm-2 controls' id='btnDeleteDebitAccount_div_1' style="text-align:center">
																<button class='btn btn-success' id="btnDeleteDebitAccount_1" type='button' onclick="deleteDebitAccount(this.id);" disabled <?php echo $menuFormatting; ?>>
																	<?php echo $this->lang->line('Delete') ?></button>
															</div>
														</div>
														<div class='col-sm-6 controls' id="credit_chart_of_accounts_div_1">
															<div class='col-sm-10 controls' id="credit_chart_of_account_div_1" style="text-align:center">
																<select class='select form-control' id='credit_chart_of_account_1' name='credit_chart_of_account'>
																	<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
																</select>
																<div id='credit_chart_of_account_1Error' class='red'></div>
															</div>
															<div class='col-sm-2 controls' id='btnDeleteCreditAccount_div_1' style="text-align:center">
																<button class='btn btn-success' id="btnDeleteCreditAccount_1" type='button' onclick="deleteCreditAccount(this.id);" disabled <?php echo $menuFormatting; ?>>
																	<?php echo $this->lang->line('Delete') ?></button>
															</div>
														</div>
													</div>
													<p id="row_space_1" style="margin-bottom:5px">&nbsp;</p>
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
													if (isset($ACM_Admin_Add_Prime_Entry_Book_Permissions)) {
														?>
														<button class='btn btn-success save' id="btnSavePrimeEntryBook"
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
								<?php
								if (isset($ACM_Admin_Add_Prime_Entry_Book_Permissions)) { ?>
									<button class='btn btn-success btn-sm new'
											type='button' <?php echo $menuFormatting; ?>>
										<?php echo $this->lang->line('Add New Prime Entry Book') ?>
									</button>
								<?php
								}
								?>
								<p>&nbsp;

								<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

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

	var PrimeEntryBookID = '';

	$(document).ready(function () {
        $(".msg_instant").hide();
		getTableData();
		PrieEntryBook.getChartOfAccounts();
		PrieEntryBook.init();
	});

	$("#btnAddAnotherDebitLedgerAccount").click(function (e){
		var cloneCount = 1;

		var element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_1");

		while (element.length == 1) {
			cloneCount++;
			element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_" + cloneCount);
		}

		var count = 2;
		var addNewRow = true;
		while (count < cloneCount) {
			if ($("#debit_chart_of_account_div_" + count).is(":visible")) {
				if (count == cloneCount) {
					addNewRow = true;
				}
			} else {
				$("#debit_chart_of_account_div_" + count).show();
				$("#btnDeleteDebitAccount_div_" + count).show();
				$("#btnDeleteDebitAccount_" + count).removeAttr("disabled");
				addNewRow = false;
				break;
			}
			count++;
		}

		if (addNewRow) {
			var newClonePrimeEntryBookChartOfAccount = $("#chart_of_accounts_div_1").clone().prop({ id: "chart_of_accounts_div_" + cloneCount}).appendTo("#chart_of_accounts_group");
			newClonePrimeEntryBookChartOfAccount.find("#chart_of_accounts_div_1").prop({ id: "chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_accounts_div_1").prop({ id: "debit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_div_1").prop({ id: "debit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_1").prop({ id: "debit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_1Error").prop({ id: "debit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_div_1").prop({ id: "btnDeleteDebitAccount_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_1").prop({ id: "btnDeleteDebitAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_accounts_div_1").prop({ id: "credit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_div_1").prop({ id: "credit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_1").prop({ id: "credit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_1Error").prop({ id: "credit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_div_1").prop({ id: "btnDeleteCreditAccount_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_1").prop({ id: "btnDeleteCreditAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_" + cloneCount).val("0");
			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_" + cloneCount).val("0");

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_" + cloneCount).removeAttr("disabled");

			$("#credit_chart_of_account_div_" + cloneCount).hide();
			$("#btnDeleteCreditAccount_div_" + cloneCount).hide();

			$('<p id="row_space_' + cloneCount + '" style="margin-bottom:5px">&nbsp;</p>').appendTo("#chart_of_accounts_group");
		}
	});

	$("#btnAddAnotherCreditLedgerAccount").click(function (e){
		var cloneCount = 1;

		var element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_1");

		while (element.length == 1) {
			cloneCount++;
			element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_" + cloneCount);
		}

		var count = 2;
		var addNewRow = true;
		while (count < cloneCount) {
			if ($("#credit_chart_of_account_div_" + count).is(":visible")) {
				if (count == cloneCount) {
					addNewRow = true;
				}
			} else {
				$("#credit_chart_of_account_div_" + count).show();
				$("#btnDeleteCreditAccount_div_" + count).show();
				$("#btnDeleteCreditAccount_" + count).removeAttr("disabled");
				addNewRow = false;
				break;
			}
			count++;
		}

		if (addNewRow) {
			var newClonePrimeEntryBookChartOfAccount = $("#chart_of_accounts_div_1").clone().prop({ id: "chart_of_accounts_div_" + cloneCount}).appendTo("#chart_of_accounts_group");
			newClonePrimeEntryBookChartOfAccount.find("#chart_of_accounts_div_1").prop({ id: "chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_accounts_div_1").prop({ id: "debit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_div_1").prop({ id: "debit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_1").prop({ id: "debit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_1Error").prop({ id: "debit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_div_1").prop({ id: "btnDeleteDebitAccount_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteDebitAccount_1").prop({ id: "btnDeleteDebitAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_accounts_div_1").prop({ id: "credit_chart_of_accounts_div_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_div_1").prop({ id: "credit_chart_of_account_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_1").prop({ id: "credit_chart_of_account_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_1Error").prop({ id: "credit_chart_of_account_" + cloneCount + "Error"});

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteAccountSet_div_1").prop({ id: "btnDeleteAccountSet_div_" + cloneCount});
			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_1").prop({ id: "btnDeleteCreditAccount_" + cloneCount});

			newClonePrimeEntryBookChartOfAccount.find("#debit_chart_of_account_" + cloneCount).val("0");
			newClonePrimeEntryBookChartOfAccount.find("#credit_chart_of_account_" + cloneCount).val("0");

			newClonePrimeEntryBookChartOfAccount.find("#btnDeleteCreditAccount_" + cloneCount).removeAttr("disabled");

			$("#debit_chart_of_account_div_" + cloneCount).hide();
			$("#btnDeleteDebitAccount_div_" + cloneCount).hide();

			$('<p id="row_space_' + cloneCount + '" style="margin-bottom:5px">&nbsp;</p>').appendTo("#chart_of_accounts_group");
		}
	});

	function deleteDebitAccount(id) {
		var value = id.substring(22,24);

		if (value != 1) {
			if ($("#credit_chart_of_account_div_" + value).is(":visible")) {
				$("#debit_chart_of_account_div_" + value).hide();
				$("#btnDeleteDebitAccount_div_" + value).hide();
				$("#btnDeleteDebitAccount_" + value).prop( "disabled", true );
				$("#debit_chart_of_account_" + value).val("0");
			} else {
				$("#chart_of_accounts_div_" + value).remove();
				$("#row_space_" + value).remove();
			}
		}
	}

	function deleteCreditAccount(id) {
		var value = id.substring(23,25);

		if (value != 1) {
			if ($("#debit_chart_of_account_div_" + value).is(":visible")) {
				$("#credit_chart_of_account_div_" + value).hide();
				$("#btnDeleteCreditAccount_div_" + value).hide();
				$("#btnDeleteCreditAccount_" + value).prop( "disabled", true );
				$("#credit_chart_of_account_" + value).val("0");
			} else {
				$("#chart_of_accounts_div_" + value).remove();
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

		PrieEntryBook.cancelData();
		clearForm();
	}

	function handleSaveEditData() {
		if (PrimeEntryBookID == '') {
			saveData();
		} else {
			editData();
		}
	}

	function saveData() {
		if (validateForm_save()){
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			PrieEntryBook.saveData();
            window.scrollTo(0,0);
		}
	}

	function editData() {
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			PrieEntryBook.editData();
            window.scrollTo(0,0);
		}
	}

	function get(id){
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		PrieEntryBook.getData(id);
	}

	function del(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		PrieEntryBook.deleteData(id);
	}

	function handleChartOfAccountSelect(id) {
		$(".msg_data").hide();
		PrieEntryBook.isLastNodeSelectedInChartOfAccountHierarchy(id);
	}
	
	var PrieEntryBook = {
		
		cancelData: function () {
			$(".form").hide();
		},

		saveData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			var PrimeEntryBookChartOfAccountDataEnteredCorrectly = true;

			var count = 1;
			while ($("#chart_of_accounts_div_" + count).length > 0) {

				if ($("#debit_chart_of_account_div_" + count).is(":visible")) {
					if (!validateDebitAccount(count)) {
						PrimeEntryBookChartOfAccountDataEnteredCorrectly = false;
					}
				}

				if ($("#credit_chart_of_account_div_" + count).is(":visible")) {
					if (!validateCreditAccount(count)) {
						PrimeEntryBookChartOfAccountDataEnteredCorrectly = false;
					}
				}

				var debitChartOfAccountId = '';
				var creditChartOfAccountId = '';
				$("[name='debit_chart_of_account']").each(function() {
					debitChartOfAccountId = $(this).val();
					$("[name='credit_chart_of_account']").each(function() {
						creditChartOfAccountId = $(this).val();

						if (!isNotSameChartOfAccount(debitChartOfAccountId, creditChartOfAccountId)) {
							PrimeEntryBookChartOfAccountDataEnteredCorrectly = false;
							return false;
						}
					});

					if (!PrimeEntryBookChartOfAccountDataEnteredCorrectly) {
						return false;
					}
				});

				count++;
			}

			if (PrimeEntryBookChartOfAccountDataEnteredCorrectly === true) {

				// send the formData
				var debitChartOfAccountList = new Array();
				var creditChartOfAccountList = new Array();
				var hasAReferenceTransactionJournalEntry = '0';

				var formData = new FormData($("#prime_entry_book_form")[0]);
				formData.append('prime_entry_book_name', $("#prime_entry_book_name").val());
				formData.append('description', $("#description").val());
				formData.append('applicable_module_id', $("#applicable_module").val());

				$("[name='debit_chart_of_account']").each(function() {
					debitChartOfAccountList.push($(this).val());
				});

				$("[name='credit_chart_of_account']").each(function() {
					creditChartOfAccountList.push($(this).val());
				});

				formData.append('debit_chart_of_account', debitChartOfAccountList);
				formData.append('credit_chart_of_account', creditChartOfAccountList);
					
				if ($("#has_reference_transaction_journal_entry").prop("checked") == true) {
					hasAReferenceTransactionJournalEntry = '1';
				}
				
				formData.append('has_a_reference_transaction_journal_entry', hasAReferenceTransactionJournalEntry);
				
				formData.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');   

				$.ajax({
					url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/add",
					type : 'POST',
					data : formData,
					processData: false,
					contentType: false,
					dataType: 'html',
					beforeSend: function() {
						$("#btnSavePrimeEntryBook:input").attr('disabled', true);
					},
					success: function(response) {
                        
                        $(".msg_instant").hide();
                        
						if (response === "ok") {
							$(".validation").hide();
							$(".msg_data").show();
							$(".msg_data").html(msg);
							$("#btnSavePrimeEntryBook:input").attr('disabled', false);
							//location.reload();
							clearForm();
							getTableData();
						} else {
							$(".msg_data").show();
							$(".msg_data").html(response);
							$("#btnSavePrimeEntryBook:input").attr('disabled', false);
						}
					}
				})
			}
		},

		editData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			var PrimeEntryBookChartOfAccountDataEnteredCorrectly = true;

			var count = 1;
			while ($("#chart_of_accounts_div_" + count).length > 0) {

				if ($("#debit_chart_of_account_div_" + count).is(":visible")) {
					if (!validateDebitAccount(count)) {
						PrimeEntryBookChartOfAccountDataEnteredCorrectly = false;
					}
				}

				if ($("#credit_chart_of_account_div_" + count).is(":visible")) {
					if (!validateCreditAccount(count)) {
						PrimeEntryBookChartOfAccountDataEnteredCorrectly = false;
					}
				}

				var debitChartOfAccountId = '';
				var creditChartOfAccountId = '';
				$("[name='debit_chart_of_account']").each(function() {
					debitChartOfAccountId = $(this).val();
					$("[name='credit_chart_of_account']").each(function() {
						creditChartOfAccountId = $(this).val();

						if (!isNotSameChartOfAccount(debitChartOfAccountId, creditChartOfAccountId)) {
							PrimeEntryBookChartOfAccountDataEnteredCorrectly = false;
							return false;
						}
					});

					if (!PrimeEntryBookChartOfAccountDataEnteredCorrectly) {
						return false;
					}
				});

				count++;
			}

			if (PrimeEntryBookChartOfAccountDataEnteredCorrectly === true) {

				// send the formData
				var debitChartOfAccountList = new Array();
				var creditChartOfAccountList = new Array();
				var hasAReferenceTransactionJournalEntry = '0';

				var formData = new FormData( $("#prime_entry_book_form")[0] );
				formData.append('prime_entry_book_name', $("#prime_entry_book_name").val());
				formData.append('description', $("#description").val());
				formData.append('applicable_module_id', $("#applicable_module").val());
				formData.append('prime_entry_book_id', $("#prime_entry_book_id").val());

				$("[name='debit_chart_of_account']").each(function() {
					debitChartOfAccountList.push($(this).val());
				});

				$("[name='credit_chart_of_account']").each(function() {
					creditChartOfAccountList.push($(this).val());
				});

				formData.append('debit_chart_of_account', debitChartOfAccountList);
				formData.append('credit_chart_of_account', creditChartOfAccountList);
				   		
				if ($("#has_reference_transaction_journal_entry").prop("checked") == true) {
					hasAReferenceTransactionJournalEntry = '1';
				}
				
				formData.append('has_a_reference_transaction_journal_entry', hasAReferenceTransactionJournalEntry);
				
				formData.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');

				$.ajax({
					url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/edit",
					type : 'POST',
					data : formData,
					processData: false,
					contentType: false,
					dataType: 'html',
					beforeSend: function() {
						$("#btnSavePrimeEntryBook:input").attr('disabled', true);
					},
					success: function(response) {
                        
                        $(".msg_instant").hide();
                        
						if (response === "ok") {
							$(".validation").hide();
							$(".msg_data").show();
							$(".msg_data").html(msg);
							$("#btnSavePrimeEntryBook:input").attr('disabled', false);
							//location.reload();
							clearForm();
							getTableData();
						} else {
							$(".msg_data").show();
							$(".msg_data").html(response);
							$("#btnSavePrimeEntryBook:input").attr('disabled', false);
						}
					}
				})
			}
		},

		deleteData: function (id) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('prime entry book') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/delete",
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
						$(".edit_form").hide();
						getTableData();
					}
				})
			}
		},

		getData: function (id) {
			PrimeEntryBookID = id;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/get",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
					success:
				function (response) {
					$(".form").show();
					$("#prime_entry_book_name_div").empty();
					$("#prime_entry_book_name_div").append(response.primaryEntryBookName);
					$("#prime_entry_book_description_div").empty();
					$("#prime_entry_book_description_div").append(response.description);
					$("#prime_entry_book_applicable_module_div").empty();
					$("#prime_entry_book_applicable_module_div").append(response.applicableModuleList);
					$("#applicable_module").val(response.applicableModuleId);
					
					if (response.hasAReferenceTransactionJournalEntry == '1') {
						$("#has_reference_transaction_journal_entry").prop('checked', true);
					} else {
						$("#has_reference_transaction_journal_entry").prop('checked', false);
					}
					
					$("#chart_of_accounts_group").empty();
					$("#chart_of_accounts_group").append(response.chartOfAccountsGroups);
					$(".loader").hide();
				}
			})
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
					$("#debit_chart_of_account_div_1").empty();
					$("#credit_chart_of_account_div_1").empty();
					$("#debit_chart_of_account_div_1").append(chartOfAccountsDropDown);
					$('#chart_of_account').attr('name', 'debit_chart_of_account');
					$("#chart_of_account").prop({ id: "debit_chart_of_account_1"});
					$("#chart_of_accountError").prop({ id: "debit_chart_of_account_1Error"});
					$("#credit_chart_of_account_div_1").append(chartOfAccountsDropDown);
					$('#chart_of_account').attr('name', 'credit_chart_of_account');
					$("#chart_of_account").prop({ id: "credit_chart_of_account_1"});
					$("#chart_of_accountError").prop({ id: "credit_chart_of_account_1Error"});
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
		
		init : function () {
			$("#table").show();
			$(".form").hide();
			$(".edit_form").hide();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
			$("#description").text('');
		}
	}

	function validateForm_save() {
		return (isNotEmpty("prime_entry_book_name", "<?php echo $this->lang->line('prime_entry_book_name').' '.$this->lang->line('field is required')?>"));
	}

	function validateDebitAccount(count) {
		return (isSelected("debit_chart_of_account_" + count, "<?php echo $this->lang->line('debit_chart_of_account_required')?>"));
	}

	function validateCreditAccount(count) {
		return (isSelected("credit_chart_of_account_" + count, "<?php echo $this->lang->line('credit_chart_of_account_required')?>"));
	}

	function isNotSameChartOfAccount(debitValue, creditValue) {
		if (debitValue != creditValue) {
			return true;
		} else {
			alert("<?php echo $this->lang->line('Debit chart of account and credit chart of account cannot be same')?>");
			return false;
		}
	}

	//get all data
	function getTableData() {
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getTableData",
			data: {
				'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
			success:
			function (response) {
				$("#dataTable").html(response);
				$(".loader").hide();
				$('.table').dataTable();
			}
		})
	}

	function clearForm() {
		$("#prime_entry_book_name").val('');
		$("#description").val('');
		$("#applicable_module").val('0');
        $("#has_reference_transaction_journal_entry").attr("checked", false);
		$("#debit_chart_of_account_1").val('0');
		$("#credit_chart_of_account_1").val('0');

		PrimeEntryBookID = '';

		var cloneCount = 2;

		var element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_2");

		while (element.length == 1) {
			$("#chart_of_accounts_div_" + cloneCount).remove();
			$("#row_space_" + cloneCount).remove();
			cloneCount++;
			element = $("#chart_of_accounts_group").find("#chart_of_accounts_div_" + cloneCount);
		}
	}

</script>

<style>

	.light_color_background {
		background: #eafaea;
	}
</style>
