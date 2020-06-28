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
								<span><?php echo $this->lang->line('Cheque List') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>

				<!--Cheques search form -->
				<form class='form form-horizontal validate-form' id="search_receive_payment_form">
					<div class='box'>
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Search Cheques') ?></div>
						</div>
						<div class='box-content'>
							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<label class='control-label col-sm-3 col-sm-1' ><?php echo $this->lang->line('Stakeholder') ?></label>
									<label class='control-label col-sm-3 col-sm-1' ><?php echo $this->lang->line('Location') ?></label>
									<label class='control-label col-sm-2 col-sm-1' ><?php echo $this->lang->line('Cheques') ?></label>
								</div>
							</div>

							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<div class='col-sm-3 controls'>
										<select id="stakeholder_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="stakeholder_search_dropdown"></div>
										<div id="stakeholder_search_idError" class="red"></div>
									</div>
									<div class='col-sm-3 controls'>
										<select id="location_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="location_search_dropdown"></div>
										<div id="location_search_idError" class="red"></div>
									</div>
									<div class='col-sm-2 controls'>
										<select class="form-control" id="cheque_type" name="cheque_type">
											<option value="external_cheques"><?php echo $this->lang->line('Received') ?></option>
											<option value="internal_cheques"><?php echo $this->lang->line('Paid') ?></option>
										</select>
									</div>
									<div class='col-sm-2 controls'>
										<input type='checkbox' name='third_party_cheque' id='third_party_cheque' style='vertical-align: text-bottom;'>
										<label for='third_party_cheque'><?php echo $this->lang->line('Third Party Cheque') ?></label>
									</div>
									<div class='col-sm-1 controls'>
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
            
            <div class='modal fade modal-cheque_list_select_cheque_deposit_prime_entry_book' id='modal-select_cheque_deposit_prime_entry_book'>
				<div class='modal-dialog' style="height:450px;width:475px">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='modal_title'><?php echo $this->lang->line('Select Cheque Deposited Bank Account') ?></h4>
						</div>

						<form enctype="text/plain" accept-charset="utf-8" name="formname" id="select_cheque_deposit_prime_entry_book_form"  method="post" action="">
							<div class='modal-body'>
								<!--<div class='modal_msg_data'></div>-->
								<div class='box-content'>
									<div class='row'>
										<div class='form-group'>
											<div class='col-sm-12 controls'>
                                                <input class='form-control' id='cheque_id' name='cheque_id' type='hidden'>
                                                <input class='form-control' id='new_status' name='new_status' type='hidden'>
                                                
												<label class='control-label col-sm-5'><?php echo $this->lang->line('Cheque Deposited Bank Account') ?></label>
												<div class='col-sm-7 controls'>
                                                    <select id="cheque_deposit_account_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                    <!--Cheque deposit account drop down-->
                                                    <div id="cheque_deposit_account_dropdown">
                                                    </div>
                                                    <!--End cheque deposit account drop down-->
                                                    <div id="cheque_deposit_account_idError" class="red"></div>
												</div>
											</div>
                                            <p style="margin-bottom:30px">&nbsp;</p>
                                            <div class='col-sm-12 col-sm-offset-8'>
                                                <button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button' onclick="closeChequeDepositPrimeEntryBookSelectScreen();"><?php echo $this->lang->line('Close') ?></button>
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

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	$(document).ready(function () {

		ChequeList.getStakeholderData();
		ChequeList.getLocationData();

		var date = new Date();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		
		var monthName = moment.months(month - 1);
		$("#month_name").text(monthName + "  " + year);
		$("#current_month").val(month);
		$("#current_year").val(year);
		
		getTableData(year, month, "", "", "");
	});
	
	function searchData() {
		var stakeholderId = $("#stakeholder_search_id").val();
		var locationId = $("#location_search_id").val();
		
		var thirdPartyChequeSelect = "";
		if ($("#third_party_cheque").prop("checked") == true) {
			thirdPartyChequeSelect = "Yes";
		}
		
		getTableData("", "", stakeholderId, locationId, thirdPartyChequeSelect);
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

		getTableData(currentYear, currentMonth, "", "", "");
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

		getTableData(currentYear, currentMonth, "", "", "");
	}
	
	function saveIncomeChequeStatusChange(id, chequeDepositPrimeEntryBookId) {
		var chequeId = id.substring(14,50);
		var status = $("#" + id).val();
        var cheque
        
        if (status == "Cleared" && chequeDepositPrimeEntryBookId == '0') {
            openChequeDepositPrimeEntryBookSelectScreen(chequeId, status);
        } else {
            ChequeList.saveIncomeChequeStatusChange(status, chequeId);
        }
	}
    
    function handleChequeDepositAccountSelect(id) {
        var chequeDepositPrimeEntryBookId = $("#" + id).val();
        var chequeId = $("#cheque_id").val();
        var status = $("#new_status").val();
        
        ChequeList.addChequeDepositPrimeEntryBookIdForTheCheque(chequeId, chequeDepositPrimeEntryBookId, status);
    }
	
	function saveExpenseChequeStatusChange(id) {
		var chequeId = id.substring(14,50);
		var status = $("#" + id).val()
		ChequeList.saveExpenseChequeStatusChange(status, chequeId);
	}

	var ChequeList = {
		
		saveIncomeChequeStatusChange: function (status, chequeId) {
            
            var clearedChequesCannotMarkAsInHand = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('Cleared cheques cannot mark as in hand!')?>' +
				'</div>';
        
            var chequeDepositBankAccountNotSpecified = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('Cheque deposit bank account is not specified for the income cheque!')?>' +
				'</div>';
        
            var thereIsNoReferenceExpenseCheque = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('There is no reference expense cheque for this income cheque!')?>' +
				'</div>';
        
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/saveIncomeChequeStatusChange",
				data: {
					'cheque_id' : chequeId,
					'status' : status,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					var currentMonth = $("#current_month").val();
					var currentYear = $("#current_year").val();
					var stakeholderId = $("#stakeholder_search_id").val();
					var locationId = $("#location_search_id").val();
                    
                    if (response == "cleared_cheques_cannot_mark_as_in_hand") {
                        $(".msg_data").show();
						$(".msg_data").html(clearedChequesCannotMarkAsInHand);
                    } else if (response == "cheque_deposit_bank_account_not_specified_for_the_income_cheque") {
                        $(".msg_data").show();
						$(".msg_data").html(chequeDepositBankAccountNotSpecified);
                    } else if (response == "no_reference_expense_cheque_for_this_income_cheque") {
                        $(".msg_data").show();
						$(".msg_data").html(thereIsNoReferenceExpenseCheque);
                    }
                    
					getTableData(currentYear, currentMonth, stakeholderId, locationId, "");
				}
			})
		},
		
		saveExpenseChequeStatusChange: function (status, chequeId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/saveExpenseChequeStatusChange",
				data: {
					'cheque_id' : chequeId,
					'status' : status,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					var currentMonth = $("#current_month").val();
					var currentYear = $("#current_year").val();
					var stakeholderId = $("#stakeholder_search_id").val();
					var locationId = $("#location_search_id").val();
					getTableData(currentYear, currentMonth, stakeholderId, locationId, "");
				}
			})
		},
		
		//get stakeholder drop down
		getStakeholderData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToPeopleDropDownWithPeopleCodeAndDeliveryRouteName",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$('#stakeholder_search_init').hide();
					$("#stakeholder_search_dropdown").html(response);
					$("#stakeholder_search_dropdown").find("#people_id").prop({ id: "stakeholder_search_id"});
					$("#stakeholder_search_id").select2();
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
					$("#location_search_dropdown").find("#location").prop({ id: "location_search_id"});
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
        
        addChequeDepositPrimeEntryBookIdForTheCheque: function (chequeId, chequeDepositPrimeEntryBookId, status) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/addChequeDepositPrimeEntryBookIdForTheCheque",
				data: {
					'cheque_id' : chequeId,
                    'cheque_deposit_prime_entry_book_id' : chequeDepositPrimeEntryBookId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					closeChequeDepositPrimeEntryBookSelectScreen();
				}
			}).done(function() {
                ChequeList.saveIncomeChequeStatusChange(status, chequeId);
            });
		},
		
		init : function () {
			$("#table").show();
			ChequeList.hideMessageDisplay();
		},

		hideMessageDisplay : function () {
			$(".msg_data").hide();
		}
	}

	//get all data
	function getTableData(year, month, stakeholderId, locationId, thirdPartyChequeSelect){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/cheque_list_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
				'stakeholder_id' : stakeholderId,
				'location_id' : locationId,
				'cheque_type' : $("#cheque_type").val(),
				'third_party_cheque' : thirdPartyChequeSelect,
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
				
				$('.chequeListDataTable').dataTable({
					"aaSorting": [[ 6, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		})
	}
    
    function openChequeDepositPrimeEntryBookSelectScreen(chequeId, status) {
		$('#modal-select_cheque_deposit_prime_entry_book').modal({backdrop: 'static', keyboard: false});
        $("#cheque_id").val(chequeId);
        $("#new_status").val(status);
        ChequeList.getChequeDepositAccountData();
	}
	
	function closeChequeDepositPrimeEntryBookSelectScreen() {
		$('#modal-select_cheque_deposit_prime_entry_book').modal('hide');
	}
</script>

<style>

	.dark_pink_color {
		background-color: #DF01D7 !important;
	}
	
	.normal_pink_color {
		background-color: #F781F3 !important;
	}
	
	.light_pink_color {
		background-color: #F6CEF5 !important;
	}
					
	.yellow_color {
		background-color: yellow !important;
	}
					
	.blue_color {
		background-color: #58D3F7 !important;
	}
	
	.red_color {
		background-color: #FA5858 !important;
	}
	
	.brown_color {
		background-color: #DF7401 !important;			
	}
    
    .orange_color {
		background-color: #FACC2E !important;			
	}
	
	.default_color {
		background-color: white !important;
	}
    
    .modal-cheque_list_select_cheque_deposit_prime_entry_book {
		top:25%;
		z-index: 2015;
	}
</style>
