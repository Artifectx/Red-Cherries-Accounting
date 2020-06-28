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
								<span><?php echo $this->lang->line('General Ledger') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>

				<div id='table'>
					<form class='form form-horizontal'>
						<div class='row'>
							<div class='col-sm-12'>
								<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
									<div class='box'>
										<div class='box-header'>
											<div class='title'><?php echo $this->lang->line('Search General Ledger') ?></div>
										</div>
										<div class='box-content'>
											<div class='form-group'>
												<div class='col-sm-12 controls'>
													<label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('From Date') ?></label>
													<label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('To Date') ?></label>
												</div>
											</div>

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

											<div class='form-group'>
												<div class='col-sm-12 controls'>
													<label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('Prime Entry Book') ?></label>
													<label style="text-align: left;" class='control-label col-sm-6' ><?php echo $this->lang->line('Chart of Account') ?></label>
												</div>
											</div>

											<div class='form-group'>
												<div class='col-sm-12 controls'>
													<div class='col-sm-4 controls'>
														<select id="prime_entry_book_name_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
														<!--Prime entry books drop down-->
														<div id="prime_entry_book_name_dropdown">
														</div>
														<!--End Prime entry books drop down-->
														<div id="prime_entry_book_idError" class="red"></div>
													</div>
													<div class='col-sm-6 controls' id="chart_of_account_div">
														<select class='select form-control' id='chart_of_account' name='chart_of_account'>
															<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
														</select>
														<div id='chart_of_accountError' class='red'></div>
													</div>
													<?php 
													if ($systemConfigData['accounts_management_for_locations'] == "No") { ?>
														<div class='col-sm-1 controls'>
															<button class='btn btn-success' id="btnSearch" type='button' onclick="searchGeneralLedger();"><?php echo $this->lang->line('Search') ?></button>
														</div>
													<?php 
													} ?>
												</div>
											</div>

											<?php 
											if ($systemConfigData['accounts_management_for_locations'] == "Yes") { ?>
												<div class='form-group'>
													<div class='col-sm-12 controls'>
														<label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('Location') ?></label>
													</div>
												</div>

												<div class='form-group'>
													<div class='col-sm-12 controls'>
														<div class='col-sm-3 controls' id='journal_entry_location_div'>
															<select class='form-control' id='location'>

															</select>
															<div id='locationError' class='red'></div>
														</div>
													</div>
													<div class='col-sm-1 controls'>
														<button class='btn btn-success' id="btnSearch" type='button' onclick="searchGeneralLedger();" <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Search') ?></button>
													</div>
												</div>
											<?php 
											} ?>
										</div>
									</div>

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
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	$(document).ready(function () {
		$("#from_date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#to_date_picker").datetimepicker({
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
		GeneralLedger.getPrimeEntryBooks();
		GeneralLedger.getChartOfAccounts();
		GeneralLedger.getLocationsOptionList();
		GeneralLedger.init();
	});

	function cancelData() {
		//location.reload();
		GeneralLedger.cancelData();
		clearForm();
	}

	function searchGeneralLedger() {
		$("#month_selector").hide();
		getTableData("", "");
	}

	function handlePrimeEntryBookSelect(id) {

	}

	function handleChartOfAccountSelect() {

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

	var GeneralLedger = {
		cancelData: function () {
			$(".form").hide();
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
				success:
					function (response) {
						$('#prime_entry_book_name_init').hide();
						$("#prime_entry_book_name_dropdown").html(response);
						$("#prime_entry_book_id").select2();
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
					$("#chart_of_account_div").empty();
					$("#chart_of_account_div").append(chartOfAccountsDropDown);
					$("#chart_of_account").select2();
				}
			});
		},

		init : function () {
			$("#table").show();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		},

		getLocationsOptionList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/getLocationsAsOptionList",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
					},
				dataType: 'html',
				success: function(locationsOptionList) {
					$("#location").append(locationsOptionList);
				}
			});
		}
	}

	//get all data
	function getTableData(year, month) {
		$(".loader").show();
		var primeEntryBookId = '';
		var chartOfAccountId = '';
		var locationId = '';

		if ($("#prime_entry_book_id").val() != '0') {
			primeEntryBookId = $("#prime_entry_book_id").val()
		} else {
			primeEntryBookId = '';
		}

		if ($("#chart_of_account").val() != '0') {
			chartOfAccountId = $("#chart_of_account").val()
		} else {
			chartOfAccountId = '';
		}

		if ($("#location").length) {
			locationId = $("#location").val();
		} else {
			locationId = '';
		}

		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/general_ledger_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
				'from_date' : $("#from_date").val(),
				'to_date' : $("#to_date").val(),
				'prime_entry_book_id' : primeEntryBookId,
				'chart_of_account_id' : chartOfAccountId,
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
		})
	}

	function clearForm() {
		$("#prime_entry_book_id").val('0');
		$("#transaction_date").val('');
		$("#description").val('');

		$("#debit_chart_of_account_total_value").val('');
		$("#credit_chart_of_account_total_value").val('');
		$("#debit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});
		$("#credit_chart_of_account_total_value").css({'background-color' : '#e6f2ff'});
	}
</script>

<style>
	.light_color_background {
		background: #eafaea;
	}
</style>
