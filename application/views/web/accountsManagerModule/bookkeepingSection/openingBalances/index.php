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
								<span><?php echo $this->lang->line('Opening Balances') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
                <div class='msg_instant' align="center"></div>
                <?php
                if (isset ($message)) echo $message;
                echo validation_errors('<div class="alert alert-danger alert-dismissable">
                                  <a class="close" data-dismiss="alert" href="#">&times;</a><h4>
                                    <i class="icon-remove-sign"></i>
                                    Error
                                  </h4>', '</div>');
                ?>
				<!--Cheques search form -->
                <?php echo form_open('accountsManagerModule/bookkeepingSection/opening_balances_controller/handleDataImport', array('class' => 'form form-horizontal validate-form','id' => 'dataImportForm', 'style' => 'margin-bottom: 0;', 'enctype' => 'multipart/form-data')) ?>
				<!--<form class='form form-horizontal validate-form' id="search_receive_payment_form">-->
					<div class='box'>
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Search Account Opening Balances') ?></div>
						</div>
						<div class='box-content'>
							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<label class='control-label col-sm-2 col-sm-1' ><?php echo $this->lang->line('Location') ?></label>
								</div>
							</div>

							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<div class='col-sm-3 controls'>
										<select id="location_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="location_search_dropdown"></div>
										<div id="location_search_idError" class="red"></div>
									</div>
									<div class='col-sm-2 controls'>
										<button class='btn btn-success save' onclick='searchData();' type='button'>
											<i class='icon-search'></i>
											<?php echo $this->lang->line('Search') ?>
										</button>
									</div>
                                    <div class='col-sm-4 controls'>
                                        <label class='control-label col-sm-5' ><?php echo $this->lang->line('Opening Balance Date') ?></label>
                                        <div class='col-sm-7 controls'>
                                            <div class='input-group date' id="date_picker">
                                                <input class='form-control' id='opening_balance_date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Opening Balance Date') ?>' type='text'>
                                                <span class='input-group-addon'>
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <div id="opening_balance_dateError" class="red"></div>
                                        </div>
                                    </div>
                                    <div class='col-sm-2 controls'>
										<button class='btn btn-success save' onclick='saveOpeningBalances();' type='button'>
											<i class='icon-save'></i>
											<?php echo $this->lang->line('Save Opening Balances') ?>
										</button>
									</div>
								</div>
							</div>
                            <div class='form-group'>
                                <div class='col-sm-2 controls'>
                                    <button class='btn btn-success save' onclick='addMoreRows();' type='button'>
                                        <i class='icon-plus'></i>
                                        <?php echo $this->lang->line('Add Additional 10 Rows') ?>
                                    </button>
                                </div>
                                <div class='col-sm-2 col-sm-offset-1'>
                                    <button class='btn btn-success' type='submit' id="download" name='data_import' value='download_opening_balances_template' <?php echo $menuFormatting; ?>>
                                        <i class='icon-save'></i>
                                        <?php echo $this->lang->line('Download') ?>
                                    </button>
                                </div>
                                <div class='col-sm-2 controls'>
                                    <button class='btn btn-success save' onclick='importOpeningBalances();' type='button'>
                                        <i class='icon-plus'></i>
                                        <?php echo $this->lang->line('Import Opening Balances') ?>
                                    </button>
                                </div>
                                <div class='col-sm-3 controls'>
                                    <button class='btn btn-success' type='submit' id="download_data_validation_error_file" name='data_import' value='download_data_validation_error_file' <?php echo $menuFormatting; ?>>
                                        <i class='icon-save'></i>
                                        <?php echo $this->lang->line('Download Data Import Workbook Error Log File') ?>
                                    </button>
                                </div>
                            </div>
						</div>
					</div>
				</form>

				<div id='table'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>

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
            
            <div class='modal fade modal-opening_balance_year_select' id='modal-bookkeeping_opening_balance_year_select'>
				<div class='modal-dialog' style="height:100px;width:350px;">
					<div class='modal-content'>
						<div class='modal-body' style="background-color: #5882FA;">
							<div id='table'>
								<div class='row'>
									<div class='col-sm-12'>
										<div class='box'>
											<div class='box-header <?php echo BOXHEADER; ?>-background'>
												<div class='title'><?php echo $this->lang->line('Available Opening Balances') ?></div>
												<div class='actions'>
													<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
													</a>
												</div>
											</div>
											<div class='box-content' id="opening_balance_year_content">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            
            <div class='modal fade' id='modal-import_opening_balances' tabindex='-1'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='myModalLabel' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Import Opening Balances') ?></h4>
						</div>
						<form enctype="multipart/form-data" accept-charset="utf-8" name="formname" id="formname"  method="post" action="">
							<div class='modal-body' style="height:60px;width:1000px">
                                <div class='msg_modal_instant' style="margin-left:230px;"></div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label class="control-label col-sm-3" for="inputText1"><?php echo $this->lang->line('Select Opening Balance Excel File To Import Data') ?></label>
										<div class="col-sm-9 controls">
											<input type="file" name="file_to_upload" id="file_to_upload">
										</div>
									</div>
								</div>
							</div>
                            <p style="margin-top:10px">&nbsp;</p>
							<div class='modal-footer'>
								<button class='btn btn-primary' id="btnLoadData"  type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Load Data') ?></button>
								<button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Close') ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

    var OpeningBalanceRowCount = '';
    var DrAmountTotal = 0;
    var CrAmountTotal = 0;
    var OpeningBalanceDataImportInProgress = "No";
    
	$(document).ready(function () {

        $(".msg_instant").hide();
        
		OpeningBalances.getLocationData();

        $("#date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
        
		getTableData("", "");
	});
    
	function searchData() {
		var locationId = $("#location_search_id").val();
		
		getTableData(locationId, "");
	}
    
    function addMoreRows() {
        
        var x;
        for (x=1; x<=10; x++) {
            var rowCount = OpeningBalanceRowCount - 1;

            var newCloneOpeningBalanceRow = $("#opening_balance_record_" + rowCount).clone().prop({ id: "opening_balance_record_" + (rowCount + 1)}).insertBefore("#opening_balance_totals");
            newCloneOpeningBalanceRow.find("#chart_of_account_id_" + rowCount).prop({ id: "chart_of_account_id_" + (rowCount + 1)});
            newCloneOpeningBalanceRow.find("#chart_of_account_id_" + rowCount + "Error").prop({ id: "chart_of_account_id_" + (rowCount + 1) + "Error"});
            newCloneOpeningBalanceRow.find("#payee_payer_" + rowCount).prop({ id: "payee_payer_" + (rowCount + 1)});
            newCloneOpeningBalanceRow.find("#payee_payer_" + rowCount + "Error").prop({ id: "payee_payer_" + (rowCount + 1) + "Error"});
            newCloneOpeningBalanceRow.find("#dr_amount_" + rowCount).prop({ id: "dr_amount_" + (rowCount + 1)});
            newCloneOpeningBalanceRow.find("#dr_" + rowCount).prop({ id: "dr_" + (rowCount + 1)});
            newCloneOpeningBalanceRow.find("#dr_" + rowCount + "Error").prop({ id: "dr_" + (rowCount + 1) + "Error"});
            newCloneOpeningBalanceRow.find("#cr_amount_" + rowCount).prop({ id: "cr_amount_" + (rowCount + 1)});
            newCloneOpeningBalanceRow.find("#cr_" + rowCount).prop({ id: "cr_" + (rowCount + 1)});
            newCloneOpeningBalanceRow.find("#cr_" + rowCount + "Error").prop({ id: "cr_" + (rowCount + 1) + "Error"});
            newCloneOpeningBalanceRow.find("#description_" + rowCount).prop({ id: "description_" + (rowCount + 1)});
            newCloneOpeningBalanceRow.find("#description_" + rowCount + "Error").prop({ id: "description_" + (rowCount + 1) + "Error"});
            newCloneOpeningBalanceRow.find("#delete_" + rowCount).prop({ id: "delete_" +  (rowCount + 1)});

            $("#chart_of_account_id_" + (rowCount + 1)).val('0');
            $("#payee_payer_" + (rowCount + 1)).val('');
            $("#dr_amount_" + (rowCount + 1)).val('0');
            $("#dr_" + (rowCount + 1)).val('');
            $("#cr_amount_" + (rowCount + 1)).val('0');
            $("#cr_" + (rowCount + 1)).val('');
            $("#description_" + (rowCount + 1)).val('');

            OpeningBalanceRowCount++;
        }
    }
    
    function saveOpeningBalances() {
        
        if ("<?php echo $is_opening_balance_equity_account_set_in_config_for_opening_balances; ?>" == "No") {
            alert("<?php echo $this->lang->line('Opening balance equity account is not specified in opening balance configurations!') ?>");
        }
        
        if (validateOpeningBalanceMasterData()) {
            if (DrAmountTotal.toFixed(2) == CrAmountTotal.toFixed(2)) {
                var location = $("#location_search_id").val();
                var openingBalanceDate = $("#opening_balance_date").val();
                OpeningBalances.saveOpeningBalances(location, openingBalanceDate);
            } else {
                alert("<?php echo $this->lang->line('Debit amount total and Credit amount total not equal!') ?>");
            }
        }
    }
    
    function handleChartOfAccountSelect(id) {
    
        if ("<?php echo $is_opening_balance_equity_account_set_in_config_for_opening_balances; ?>" == "No") {
            alert("<?php echo $this->lang->line('Opening balance equity account is not specified in opening balance configurations!') ?>");
        }
        
        var rowCount = id.substring(20,23);
        
        if ($("#dr_" + rowCount).val() != '') {
            handleDrAmountAddition("dr_" + rowCount);
        }
        
        if ($("#cr_" + rowCount).val() != '') {
            handleCrAmountAddition("cr_" + rowCount);
        }
    }
    
    function handleDrAmountAddition(id) {
    
        if ("<?php echo $is_opening_balance_equity_account_set_in_config_for_opening_balances; ?>" == "No") {
            alert("<?php echo $this->lang->line('Opening balance equity account is not specified in opening balance configurations!') ?>");
        }
        
        var drAmount = $("#" + id).val();
        
        if (drAmount != '') {
            var drAmountData = drAmount.split(".");
            var drAmountDataSize = drAmountData.length;

            if (drAmountDataSize == 1) {
                drAmount = drAmount + ".00";
                $("#" + id).val(drAmount);
            } else {
                $("#" + id).val(drAmount);
            }
        }
        
        var rowCount = id.substring(3,10);
            
        if (drAmount != '' && validateDrAmount(rowCount)) {
            
            var drAmountOld = $("#dr_amount_" + rowCount).val();
            
            if (drAmountOld != '' && drAmountOld != '0.00') {
                DrAmountTotal = (parseFloat(DrAmountTotal) - parseFloat(drAmountOld)) + parseFloat(drAmount);
                $("#dr_amount_" + rowCount).val(drAmount);
            } else {
                DrAmountTotal = parseFloat(DrAmountTotal) + parseFloat(drAmount);
                $("#dr_amount_" + rowCount).val(drAmount);
            }
            
            $("#dr_total").empty();
            $("#dr_total").html(DrAmountTotal.toFixed(2));
            
            if (DrAmountTotal.toFixed(2) != CrAmountTotal.toFixed(2)) {
                document.getElementById('dr_total').style.backgroundColor = 'red';
                document.getElementById('cr_total').style.backgroundColor = 'red';
            } else {
                document.getElementById('dr_total').style.backgroundColor = 'white';
                document.getElementById('cr_total').style.backgroundColor = 'white';
            }
        }
    }
    
    function handleCrAmountAddition(id) {
    
        if ("<?php echo $is_opening_balance_equity_account_set_in_config_for_opening_balances; ?>" == "No") {
            alert("<?php echo $this->lang->line('Opening balance equity account is not specified in opening balance configurations!') ?>");
        }
        
        var crAmount = $("#" + id).val();
        
        if (crAmount != '') {
            var crAmountData = crAmount.split(".");
            var crAmountDataSize = crAmountData.length;

            if (crAmountDataSize == 1) {
                crAmount = crAmount + ".00";
                $("#" + id).val(crAmount);
            } else {
                $("#" + id).val(crAmount);
            }
        }
        
        var rowCount = id.substring(3,10);
        
        if (crAmount != '' && validateCrAmount(rowCount)) {
            
            var crAmountOld = $("#cr_amount_" + rowCount).val();
            
            if (crAmountOld != '' && crAmountOld != '0.00') {
                CrAmountTotal = (parseFloat(CrAmountTotal) - parseFloat(crAmountOld)) + parseFloat(crAmount);
                $("#cr_amount_" + rowCount).val(crAmount);
            } else {
                CrAmountTotal = parseFloat(CrAmountTotal) + parseFloat(crAmount);
                $("#cr_amount_" + rowCount).val(crAmount);
            }
            
            $("#cr_total").empty();
            $("#cr_total").html(CrAmountTotal.toFixed(2));
            
            if (DrAmountTotal.toFixed(2) != CrAmountTotal.toFixed(2)) {
                document.getElementById('dr_total').style.backgroundColor = 'red';
                document.getElementById('cr_total').style.backgroundColor = 'red';
            } else {
                document.getElementById('dr_total').style.backgroundColor = 'white';
                document.getElementById('cr_total').style.backgroundColor = 'white';
            }
        }
    }
    
    function deleteAccountOpeningBalance(id) {
        var rowCount = id.substring(7,10);
			
        var drAmount = $("#dr_" + rowCount).val();
        var crAmount = $("#cr_" + rowCount).val();
        
        if (drAmount != '' && drAmount != '0.00') {
            DrAmountTotal = parseFloat(DrAmountTotal) - parseFloat(drAmount);
            $("#dr_total").html(DrAmountTotal.toFixed(2));
            
            if (DrAmountTotal != DrAmountTotal) {
                document.getElementById('dr_total').style.backgroundColor = 'red';
                document.getElementById('cr_total').style.backgroundColor = 'red';
            } else {
                document.getElementById('dr_total').style.backgroundColor = 'white';
                document.getElementById('cr_total').style.backgroundColor = 'white';
            }
        }
        
        if (crAmount != '' && crAmount != '0.00') {
            CrAmountTotal = parseFloat(CrAmountTotal) - parseFloat(crAmount);
            $("#cr_total").html(CrAmountTotal.toFixed(2));
            
            if (DrAmountTotal != CrAmountTotal) {
                document.getElementById('dr_total').style.backgroundColor = 'red';
                document.getElementById('cr_total').style.backgroundColor = 'red';
            } else {
                document.getElementById('dr_total').style.backgroundColor = 'white';
                document.getElementById('cr_total').style.backgroundColor = 'white';
            }
        }
        
        $("#opening_balance_record_" + rowCount).remove();
        
        rowCount++;
        var openingBalanceElement = $("#opening_balance_rows").find("#opening_balance_record_" + rowCount);

        var moreElement = true;
        while (moreElement) {
            if (openingBalanceElement.length == 1) {

                $("#opening_balance_rows").find("#opening_balance_record_" + rowCount).prop({ id: "opening_balance_record_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#chart_of_account_id_" + rowCount).prop({ id: "chart_of_account_id_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#chart_of_account_id_" + rowCount + "Error").prop({ id: "chart_of_account_id_" + (rowCount - 1) + "Error"});
                $("#opening_balance_rows").find("#payee_payer_" + rowCount).prop({ id: "payee_payer_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#payee_payer_" + rowCount + "Error").prop({ id: "payee_payer_" + (rowCount - 1) + "Error"});
                $("#opening_balance_rows").find("#dr_amount_" + rowCount).prop({ id: "dr_amount_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#dr_" + rowCount).prop({ id: "dr_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#dr_" + rowCount + "Error").prop({ id: "dr_" + (rowCount - 1) + "Error"});
                $("#opening_balance_rows").find("#cr_amount_" + rowCount).prop({ id: "cr_amount_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#cr_" + rowCount).prop({ id: "cr_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#cr_" + rowCount + "Error").prop({ id: "cr_" + (rowCount - 1) + "Error"});
                $("#opening_balance_rows").find("#description_" + rowCount).prop({ id: "description_" + (rowCount - 1)});
                $("#opening_balance_rows").find("#description_" + rowCount + "Error").prop({ id: "description_" + (rowCount - 1) + "Error"});
                $("#opening_balance_rows").find("#delete_" + rowCount).prop({ id: "delete_" +  (rowCount - 1)});

                rowCount++;
                openingBalanceElement = $("#opening_balance_rows").find("#opening_balance_record_" + rowCount);
            } else {
                rowCount--;
                moreElement = false;
            }
        }
        
        var newCloneOpeningBalanceRow = $("#opening_balance_record_" + (rowCount - 1)).clone().prop({ id: "opening_balance_record_" + rowCount}).insertBefore("#opening_balance_totals");
        newCloneOpeningBalanceRow.find("#chart_of_account_id_" + (rowCount - 1)).prop({ id: "chart_of_account_id_" + rowCount});
        newCloneOpeningBalanceRow.find("#chart_of_account_id_" + (rowCount - 1) + "Error").prop({ id: "chart_of_account_id_" + rowCount + "Error"});
        newCloneOpeningBalanceRow.find("#payee_payer_" + (rowCount - 1)).prop({ id: "payee_payer_" + rowCount});
        newCloneOpeningBalanceRow.find("#payee_payer_" + (rowCount - 1) + "Error").prop({ id: "payee_payer_" + rowCount + "Error"});
        newCloneOpeningBalanceRow.find("#dr_amount_" + (rowCount - 1)).prop({ id: "dr_amount_" + rowCount});
        newCloneOpeningBalanceRow.find("#dr_" + (rowCount - 1)).prop({ id: "dr_" + rowCount});
        newCloneOpeningBalanceRow.find("#dr_" + (rowCount - 1) + "Error").prop({ id: "dr_" + rowCount + "Error"});
        newCloneOpeningBalanceRow.find("#cr_amount_" + (rowCount - 1)).prop({ id: "cr_amount_" + rowCount});
        newCloneOpeningBalanceRow.find("#cr_" + (rowCount - 1)).prop({ id: "cr_" + rowCount});
        newCloneOpeningBalanceRow.find("#cr_" + (rowCount - 1) + "Error").prop({ id: "cr_" + rowCount + "Error"});
        newCloneOpeningBalanceRow.find("#description_" + (rowCount - 1)).prop({ id: "description_" + rowCount});
        newCloneOpeningBalanceRow.find("#description_" + (rowCount - 1) + "Error").prop({ id: "description_" + rowCount + "Error"});
        newCloneOpeningBalanceRow.find("#delete_" + (rowCount - 1)).prop({ id: "delete_" +  rowCount});
        
        $("#chart_of_account_id_" + rowCount).val('0');
        $("#payee_payer_" + rowCount).val('');
        $("#dr_amount_" + rowCount).val('0');
        $("#dr_" + rowCount).val('');
        $("#cr_amount_" + rowCount).val('0');
        $("#cr_" + rowCount).val('');
        $("#description_" + rowCount).val('');
    }
    
    function openOpeningBalanceYearSelectDialog(locationId, openingBalanceYearList, openingBalanceDateList) {
		
		var openingBalanceYearCount = 0;
		var openingBalanceYearContent = '';
		
		$("#opening_balance_year_content").empty();
		
		jQuery.each(openingBalanceYearList, function(id, year) {
			if (year != '') {
				var openingBalanceDate = openingBalanceDateList[id];
				openingBalanceYearCount = parseInt(openingBalanceYearCount) + 1;
				openingBalanceYearContent =  "<div>"+
                                        "<input class='form-control' id='location_id_" + openingBalanceYearCount + "' name='location_id_" + openingBalanceYearCount + "' type='hidden' value='" + locationId + "'>"+
										"<input class='form-control' id='opening_balance_date_" + openingBalanceYearCount + "' name='opening_balance_date_" + openingBalanceYearCount + "' type='hidden' value='" + openingBalanceDate + "'>"+
										"<input class='opening_balance_year_check_box' type='checkbox' name='opening_balance_year_group' id='opening_balance_year_" + openingBalanceYearCount + "' style='vertical-align: text-bottom;'";
						
				if (openingBalanceYearCount == 1) {
					openingBalanceYearContent = openingBalanceYearContent + " checked";
				}
				
				openingBalanceYearContent = openingBalanceYearContent + ">  <label for='opening_balance_year_" + openingBalanceYearCount + "' style='color: white;'> " + year + "</label>"+
									"</div>";

				$("#opening_balance_year_content").append(openingBalanceYearContent);
			}
		});
							   
		$('#modal-bookkeeping_opening_balance_year_select').modal({backdrop: 'static', keyboard: false});
	}
    
    $(document).keydown(function(e) {
        
        if ($("#modal-bookkeeping_opening_balance_year_select").hasClass('in')) {
			if (e.keyCode == "40" || e.which == "40") {
				//Down arrow key is pressed
				var id = e.target.id;
				var openingBalanceYearCount = id.substring(21,50);
				var oldOpeningBalanceYearCount = openingBalanceYearCount;
				
				openingBalanceYearCount = parseInt(openingBalanceYearCount) + 1;
				
				if ($("#opening_balance_year_" + openingBalanceYearCount).length) {
					$("#opening_balance_year_" + oldOpeningBalanceYearCount).prop('checked', false);
					$("#opening_balance_year_" + openingBalanceYearCount).prop('checked', true);
					$("#opening_balance_year_" + openingBalanceYearCount).focus();
				}
			} else if (e.keyCode == "38" || e.which == "38") {
				//Up arrow key is pressed
				var id = e.target.id;
				var openingBalanceYearCount = id.substring(21,50);
				var oldOpeningBalanceYearCount = openingBalanceYearCount;
				
				openingBalanceYearCount = parseInt(openingBalanceYearCount) - 1;
				
				if (openingBalanceYearCount > 0) {
					$("#opening_balance_year_" + oldOpeningBalanceYearCount).prop('checked', false);
					$("#opening_balance_year_" + openingBalanceYearCount).prop('checked', true);
					$("#opening_balance_year_" + openingBalanceYearCount).focus();
				}
			} else if (e.keyCode == "13" || e.which == "13") {
				var id = $('input[name=opening_balance_year_group]:checked')[0].id;
				var openingBalanceYearCount = id.substring(21,50);
                
                var locationId = $("#location_id_" + openingBalanceYearCount).val();
                var openingBalanceDate = $("#opening_balance_date_" + openingBalanceYearCount).val();
                
                getTableData(locationId, openingBalanceDate);
				
				$("#modal-bookkeeping_opening_balance_year_select").modal('hide');
			}
		}
    });
    
    function handleLocationSelect() {
        
    }
    
    function importOpeningBalances() {
        openImportOpeningBalancesDialog();
    }
    
    function downloadDataImportWorkbookErrorLogFile() {
        $.ajax({
			url :"<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/opening_balances_controller/downloadDataValidationErrorFile",
			type : 'GET',
			dataType: 'html',
			success	: function (response){
				
			}
		});
    }
    
    $("#btnLoadData").click(function (e){ 

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Data successfully loaded to import opening balances. Reveiw the balance details and then save opening balances.') ?>'+
				'</div>';
        
        var msgError='<div class="alert alert-danger alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-remove-sign"></i>'+
				'<?php echo $this->lang->line('error') ?></h4>'+
				'<?php echo $this->lang->line('Data_import_workbook_errors') ?>'+
				'</div>';
		
        var fileName = $("#file_to_upload").val();
        if (fileName.substring(3,11) == 'fakepath') {
            fileName = fileName.substring(12);
        }

		// send the formData
		var formData = new FormData( $("#formname")[0] );
		formData.append('file_name', fileName);
		formData.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');

        $(".msg_modal_instant").show();
        $(".msg_modal_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Loading data...');
        
		$.ajax({
			url :"<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/opening_balances_controller/loadOpeningBalances",
			type : 'POST',
			data : formData,
			processData: false,
			contentType: false,
			dataType: 'json',
            beforeSend: function () {
                $("#btnLoadData").attr('disabled', true);
            },
			success	: function (responseData){
                
                $(".msg_modal_instant").hide();
                
				if (responseData.response === "success") {
					$(".validation").hide();
					$(".msg_data").show();
					$(".msg_data").html(msg);
                    
                    $("#dataTable").empty();
                    $("#dataTable").html(responseData.html);
                    
                    OpeningBalanceDataImportInProgress = "Yes";
                    OpeningBalanceRowCount = responseData.rowCount;
                    DrAmountTotal = responseData.drTotal;
                    CrAmountTotal = responseData.crTotal;

                    $('.openingBalancesDataTable').dataTable({
                        "iDisplayLength":responseData.rowCount
                    });
				} else {
                    $(".validation").hide();
					$(".msg_data").show();
					$(".msg_data").html(msgError);
                }
                
                $("#btnLoadData").attr('disabled', false);
				closeImportOpeningBalancesDialog();
			}
		});
	});
	
	var OpeningBalances = {
		
		saveOpeningBalances : function (locationId, openingBalanceDate) {
            
            var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
        
            var msg_no_data_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('There is no data to save.')?>' +
				'</div>';
        
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
        
            //Gather Account Opening Balances Details
			var openingBalancesData = [];
            var openingBalanceCount = '';
            
            if (OpeningBalanceDataImportInProgress == "No") {
			
                var openingBalanceElement = $("#opening_balance_rows").find("#chart_of_account_id_1");

                var openingBalancesDataSet = [];
                var glIds = {};
                var chartOfAccounts = {};
                var payeePayerIds = {};
                var drAmounts = {};
                var crAmounts = {};
                var descriptions = {};

                var rowCount = 1;
                openingBalanceCount = 1;
                var moreElement = true;
                while (moreElement) {
                    if (openingBalanceElement.length == 1) {

                        var chartOfAccountId = $("#chart_of_account_id_" + rowCount).val();

                        if (chartOfAccountId != '' && chartOfAccountId != '0') {
                            glIds[openingBalanceCount] = $("#gl_id_" + rowCount).val();
                            chartOfAccounts[openingBalanceCount] = chartOfAccountId;
                            payeePayerIds[openingBalanceCount] = $("#payee_payer_" + rowCount).val();
                            drAmounts[openingBalanceCount] = $("#dr_" + rowCount).val();
                            crAmounts[openingBalanceCount] = $("#cr_" + rowCount).val();
                            descriptions[openingBalanceCount] = $("#description_" + rowCount).val();

                            openingBalanceCount++;
                        }

                        rowCount++;
                        openingBalanceElement = $("#opening_balance_rows").find("#chart_of_account_id_" + rowCount);
                    } else {
                        openingBalanceCount--;
                        moreElement = false;
                    }
                }

                openingBalancesDataSet.push(glIds);
                openingBalancesDataSet.push(chartOfAccounts);
                openingBalancesDataSet.push(payeePayerIds);
                openingBalancesDataSet.push(drAmounts);
                openingBalancesDataSet.push(crAmounts);
                openingBalancesDataSet.push(descriptions);

                openingBalancesData.push(openingBalancesDataSet);
            }
            
            var saveAborted = "No";
            
            if (openingBalanceCount > 50) {
                saveAborted = "Yes";
                $(".msg_instant").hide();
                openingBalancesData = [];
                alert("<?php echo $this->lang->line('Too much data to save! Please use opening balance import feature to update changes.') ?>");
            }
            
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/opening_balances_controller/saveOpeningBalances",
				data: {
                    'opening_balance_data_import' : OpeningBalanceDataImportInProgress,
					'location_id' : locationId,
                    'opening_balance_date' : openingBalanceDate,
                    'opening_balance_data' : openingBalancesData,
                    'opening_balance_count' : openingBalanceCount--,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
                    if (response == "ok") {
                        OpeningBalanceDataImportInProgress = "No";
                        $(".msg_data").show();
                        $(".msg_data").html(msg);
                    } else if (response == "no_data_to_save") {
                        if (saveAborted == "No") {
                            $(".msg_data").show();
                            $(".msg_data").html(msg_no_data_to_save);
                        }
                    }
				}
			});
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
			});
		},
        
		init : function () {
			$("#table").show();
			OpeningBalances.hideMessageDisplay();
		},

		hideMessageDisplay : function () {
			$(".msg_data").hide();
		}
	};

    function openImportOpeningBalancesDialog() {
		$(".validation").hide();
		$(".msg_data").hide();
		$("#file_to_upload").val("");
		$("#modal-import_opening_balances").modal('show');
	}

	function closeImportOpeningBalancesDialog() {
		$("#modal-import_opening_balances").modal('hide');
	}
    
	//get all data
	function getTableData(locationId, openingBalanceDate){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/opening_balances_controller/getTableData",
			data: {
				'location_id' : locationId,
                'opening_balance_date' : openingBalanceDate,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'json',
			success: function (response) {
                if (response.result == 'ok') {
                    $("#dataTable").empty();
                    $("#dataTable").html(response.html);
                    $(".loader").hide();

                    if (response.openingBalanceDate != '') {
                        $("#opening_balance_date").val(response.openingBalanceDate);
                    }

                    OpeningBalanceRowCount = response.rowCount;
                    DrAmountTotal = response.drTotal;
                    CrAmountTotal = response.crTotal;

                    $('.openingBalancesDataTable').dataTable({
                        "iDisplayLength":response.rowCount
                    });
                } else if (response.result == 'multiple_opening_balance_years') {
                    $(".loader").hide();
                    openOpeningBalanceYearSelectDialog(locationId, response.openingBalanceYearList, response.openingBalanceDateList);
                    
                    setTimeout(function(){
                        $("#opening_balance_year_1").focus();	
                    }, 500);
                }
			}
		});
	}
    
    //form validation Dr amount
	function validateDrAmount(rowCount) {
		return (isSelected("chart_of_account_id_" + rowCount, "<?php echo $this->lang->line('Chart of Account').' '.$this->lang->line('field is required')?>")
            && isFlootPositive("dr_" + rowCount, "<?php echo $this->lang->line('Dr Amount').' '.$this->lang->line('is not valid')?>")
        );
	}
    
    //form validation Cr amount
	function validateCrAmount(rowCount) {
		return (isSelected("chart_of_account_id_" + rowCount, "<?php echo $this->lang->line('Chart of Account').' '.$this->lang->line('field is required')?>")
            && isFlootPositive("cr_" + rowCount, "<?php echo $this->lang->line('Cr Amount').' '.$this->lang->line('is not valid')?>")
        );
	}
    
    function validateOpeningBalanceMasterData() {
        return (isSelected("location_search_id", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
            && isNotEmpty("opening_balance_date", "<?php echo $this->lang->line('Opening Balance Date').' '.$this->lang->line('field is required')?>"));
    }
    
</script>