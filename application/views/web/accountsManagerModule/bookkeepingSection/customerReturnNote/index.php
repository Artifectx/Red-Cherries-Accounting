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
								<span><?php echo $this->lang->line('Customer Return Note') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
				<div class="msg_delete"></div>
                <div class='msg_instant' align="center"></div>
				<div class='form' id="customer_return_note_details_form">
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-content'>
									<div class='validation'></div>
									<div class='box' id="add_customer_return_note_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div class='title'><?php echo $this->lang->line('Add Customer Return Note') ?></div>
											<div class='actions'>
												<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
												</a>
											</div>
										</div>
										<div class='box-content'>
											<form class='form form-horizontal validate-form save_form' method="post">
												<input class='form-control' id='customer_return_note_id' name='customer_return_note_id' type='hidden'>
												<input class='form-control' id ="reference_no_link" value="<?php echo $search_reference_no; ?>" type="hidden" >
												<div class='form-group'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Reference No') ?> *</label>
													<div class='col-sm-4 controls' id="reference_no_div">
														<input class='form-control' id='reference_no' name='reference_no'
															   placeholder='<?php echo $this->lang->line('Reference No') ?>' type='text' 
															   value="<?php echo set_value('reference_no'); ?>"
															   <?php if ($customer_return_note_no_auto_increment_status) { echo 'readonly';}?>>
														<div id="reference_noError" class="red"></div>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Date') ?> *</label>
													<div class='col-sm-4 controls'>
														<div class='datepicker-input input-group' id='datepicker'>
															<input class='form-control' id='customer_return_note_date' name='customer_return_note_date'
																   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
															  <span class="input-group-addon">
																	<span class="glyphicon glyphicon-calendar"/>
															  </span>
														</div>
														<div id="customer_return_note_dateError" class="red"></div>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Customer') ?> *</label>
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
												<div class="form-group">
													<div class='col-sm-3 controls'></div>
													<div class='col-sm-5 controls'>
														<input type="checkbox" name="saleable_return" id="saleable_return" style="vertical-align: text-bottom;" onchange="handleSaleableReturnSelect(this.id);">
														<label for="saleable_return" ><?php echo $this->lang->line('Saleable Return') ?></label>
													</div>
												</div>
												<div class="form-group">
													<div class='col-sm-3 controls'></div>
													<div class='col-sm-5 controls'>
														<input type="checkbox" name="market_return" id="market_return" style="vertical-align: text-bottom;" onchange="handleMarketReturnSelect(this.id);">
														<label for="market_return" ><?php echo $this->lang->line('Market Return') ?></label>
													</div>
												</div>
												<div class='form-group'>
													<label class='control-label col-sm-3'><?php echo $this->lang->line('Customer Return Amount') ?> *</label>
													<div class='col-sm-4 controls' id="customer_return_amount_div">
														<input class='form-control' id='customer_return_amount' name='customer_return_amount'
															   placeholder='<?php echo $this->lang->line('Customer Return Amount') ?>' type='text' 
															   value="<?php echo set_value('customer_return_amount'); ?>" onblur="handleCustomerReturnAmountAddition();">
														<div id="customer_return_amountError" class="red"></div>
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
															if (isset($ACM_Bookkeeping_Add_Customer_Return_Note_Permissions)){
																?>
																<button class='btn btn-success save'
																		onclick='saveData();' type='button'>
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
									<div class='box' id="edit_customer_return_note_form">
										<div class='box-header <?php echo BOXHEADER; ?>-background'>
											<div id ="customer_return_note_edit_box_title" class='title'><?php echo $this->lang->line('Edit Customer Return Note') ?></div>
											<div class='actions'>
												<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
												</a>
											</div>
										</div>
										<div class='box-content' id="edit_customer_return_note_form_content">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--Product search form -->
				<div class='msg_data_customer_return_note_search'></div>
				<form class='form form-horizontal validate-form' id="search_customer_return_note_form">
					<div class='box'>
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Search Customer Return Notes') ?></div>
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
								if (isset($ACM_Bookkeeping_Add_Customer_Return_Note_Permissions)){
									echo "<a class='btn btn-success btn-sm new'>{$this->lang->line('Add New Customer Return Note') }</a>";
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

	var CustomerReturnNoteScreenOperationStatus = '';
	
	$(document).ready(function () {
		
        $(".msg_instant").hide();
        
		$("#datepicker").datetimepicker({
			format: 'YYYY-MM-DD'
		});

		CustomerReturnNote.getCustomerData();
		CustomerReturnNote.getCustomerSearchData();
		CustomerReturnNote.getTerritoryData();
		CustomerReturnNote.getLocationData();
		
		var date = new Date();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		
		var monthName = moment.months(month - 1);
		$("#month_name").text(monthName + "  " + year);
		$("#current_month").val(month);
		$("#current_year").val(year);
		
		getTableData(year, month, "", "", $("#reference_no_link").val());
		CustomerReturnNote.init();
	});

	$(".new").click(function () {
		clearForm();
		CustomerReturnNoteScreenOperationStatus = "Add";
		CustomerReturnNote.getNextReferenceNo();
		CustomerReturnNote.hideMessageDisplay();
		$("#customer_return_note_details_form").show();
		$("#add_customer_return_note_form").show();
		$(".save_form").show();
		$("#edit_customer_return_note_form").hide();
		$("#search_customer_return_note_form").hide();

	});

	function cancelData() {
		CustomerReturnNote.cancelData();
	}

	function closeCustomerReturnNoteEditForm() {
		CustomerReturnNote.closeCustomerReturnNoteEditForm();
		window.scrollTo(0,0);
	}

	function saveData() {
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
            
            $("#customer_id").select2('destroy');
            $("#customer_id").select2();
            
			CustomerReturnNote.saveData();
			window.scrollTo(0,0);
		} else {
            $("#customer_id").select2('destroy');
            $("#customer_id").select2();
        }
	}

	function editCustomerReturnNoteData(id) {
		if (validateForm_edit()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
            
            $("#customer_id_edit").select2('destroy');
            $("#customer_id_edit").select2();
            
			CustomerReturnNote.editCustomerReturnNoteData(id);
			window.scrollTo(0,0);
		} else {
            $("#customer_id_edit").select2('destroy');
            $("#customer_id_edit").select2();
        }
	}

	function getCustomerReturnNoteData(id){
		$(".loader").show();
		CustomerReturnNoteScreenOperationStatus = "View";
		CustomerReturnNote.hideMessageDisplay();
		CustomerReturnNote.getCustomerReturnNoteData(id);
		window.scrollTo(0,0);
	}

	function del(id){
		CustomerReturnNote.hideMessageDisplay();
		CustomerReturnNote.deleteData(id);
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

		getTableData(currentYear, currentMonth, "", "", $("#reference_no_link").val());
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

		getTableData(currentYear, currentMonth, "", "", $("#reference_no_link").val());
	}
	
	function handleCustomerReturnAmountAddition() {
		var amount = "";
		if (CustomerReturnNoteScreenOperationStatus == "Add") {
			amount = $("#customer_return_amount").val();
		} else if (CustomerReturnNoteScreenOperationStatus == "View") {
			amount = $("#customer_return_amount_edit").val();
		}

		if (amount != "") {
			var amountData = amount.split(".");
			var amountDataSize = amountData.length;

			if (amountDataSize == 1) {
				amount = amount + ".00";
				if (CustomerReturnNoteScreenOperationStatus == "Add") {
					$("#customer_return_amount").val(amount);
				} else if (CustomerReturnNoteScreenOperationStatus == "View") {
					$("#customer_return_amount_edit").val(amount);
				}
			}
		} else {
			amount = "0.00";
			if (CustomerReturnNoteScreenOperationStatus == "Add") {
				$("#customer_return_amount").val("0.00");
			} else if (CustomerReturnNoteScreenOperationStatus == "View") {
				$("#customer_return_amount_edit").val("0.00");
			}
		}
	}
	
	function handleSaleableReturnSelect(id) {
		if ($("#" + id).prop("checked") == true) {
			if (CustomerReturnNoteScreenOperationStatus == "Add") {
				$("#market_return").prop("checked", false);
			} else if (CustomerReturnNoteScreenOperationStatus == "View") {
				$("#market_return_edit").prop("checked", false);
			}
		} else {
			if (CustomerReturnNoteScreenOperationStatus == "Add") {
				$("#market_return").prop("checked", true);
			} else if (CustomerReturnNoteScreenOperationStatus == "View") {
				$("#market_return_edit").prop("checked", true);
			}
		}
	}
	
	function handleMarketReturnSelect(id) {
		if ($("#" + id).prop("checked") == true) {
			if (CustomerReturnNoteScreenOperationStatus == "Add") {
				$("#saleable_return").prop("checked", false);
			} else if (CustomerReturnNoteScreenOperationStatus == "View") {
				$("#saleable_return_edit").prop("checked", false);
			}
		} else {
			if (CustomerReturnNoteScreenOperationStatus == "Add") {
				$("#saleable_return").prop("checked", true);
			} else if (CustomerReturnNoteScreenOperationStatus == "View") {
				$("#saleable_return_edit").prop("checked", true);
			}
		}
	}
	
	function searchData() {
		var customerId = $("#customer_search_id").val();
		var territoryId = $("#territory_search_id").val();
		getTableData("", "", customerId, territoryId, $("#reference_no_link").val());
	}
	
	function handleCustomerSelection() {
		
	}
	
	function handleLocationSelect() {
		
	}
	
	var CustomerReturnNote = {
		cancelData: function () {
			$("#customer_return_note_details_form").hide();
			$("#search_customer_return_note_form").show();
			CustomerReturnNote.hideMessageDisplay();
			clearForm();
		},

		closeCustomerReturnNoteEditForm: function () {
			$("#customer_return_note_details_form").hide();
			$("#search_customer_return_note_form").show();
			CustomerReturnNote.hideMessageDisplay();
		},

		getNextReferenceNo : function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller/getNextReferenceNo",
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
        
            var msgError = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('Previous financial year is not closed! Please close the previous financal year before add transactions.')?>' +
				'</div>';
		
			var type = "";
			if ($("#saleable_return").prop("checked") == true) {
				type = "saleable_return";
			} else if ($("#market_return").prop("checked") == true) {
				type = "market_return";
			}

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller/add",
				data: {
					'reference_no' : $("#reference_no").val(),
					'customer_return_note_date' : $("#customer_return_note_date").val(),
					'customer_id' : $("#customer_id").val(),
					'territory_id' : $("#territory").val(),
					'location_id' : $("#location").val(),
					'customer_return_amount' : $("#customer_return_amount").val(),
					'type' : type,
					'remark': $("#remark").val().trim(),
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
						getTableData(year, month, "", "", $("#reference_no_link").val());
						clearForm();
						CustomerReturnNote.getNextReferenceNo();
					} else {
						$(".msg_data").show();
						$(".msg_data").html(msgError);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},

		editCustomerReturnNoteData: function (id) {
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

			var type = "";
			if ($("#saleable_return_edit").prop("checked") == true) {
				type = "saleable_return";
			} else if ($("#market_return_edit").prop("checked") == true) {
				type = "market_return";
			}

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller/editCustomerReturnNoteData",
				data: {
					'id': id,
					'reference_no' : $("#reference_no_edit").val(),
					'customer_return_note_date' : $("#customer_return_note_date_edit").val(),
					'customer_id' : $("#customer_id_edit").val(),
					'territory_id' : $("#territory_edit").val(),
					'location_id' : $("#location_edit").val(),
					'customer_return_amount' : $("#customer_return_amount_edit").val(),
					'type' : type,
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
						$("#search_customer_return_note_form").show();
						$("#customer_return_note_details_form").hide();
						var year = $("#current_year").val();
						var month = $("#current_month").val();
						getTableData(year, month, "", "", $("#reference_no_link").val());
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

		deleteData: function (id) {

			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Customer Return Note') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller/deleteCustomerReturnNote",
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
						getTableData(year, month, "", "", $("#reference_no_link").val());
					}
				})
			}
		},

		getCustomerReturnNoteData: function (id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller/getCustomerReturnNoteData",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:
				function (response) {
					$("#customer_return_note_details_form").show();
					$("#search_customer_return_note_form").hide();
					$("#add_customer_return_note_form").hide();
					$("#edit_customer_return_note_form").show();
					$("#edit_customer_return_note_form_content").html(response.result);
					$("#customer_return_note_edit_box_title").text('<?php echo $this->lang->line('Edit Customer Return Note') ?>');
					$(".loader").hide();
					$("#datepicker_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					
					$("#customer_id_edit").select2();
				}
			})
		},

		//get customer drop down
		getCustomerData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToCustomersDropDown",
				data: {
                    'check_authority' : 'Yes',
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

		init : function () {
			$("#table").show();
			$("#customer_return_note_details_form").hide();
			CustomerReturnNote.hideMessageDisplay();
			$("#remark").val('');
		},

		hideMessageDisplay : function () {
			$(".msg_data").hide();
			$(".modal_msg_data").hide();
			$(".modal_msg_data").hide();
			$(".msg_data_customer_return_note_search").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		}
	}

	//form validation save
	function validateForm_save() {
		return (isNotEmpty("reference_no", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("customer_return_note_date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("customer_id", "<?php echo $this->lang->line('Customer').' '.$this->lang->line('field is required')?>")
			&& isSelected("location", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("customer_return_amount", "<?php echo $this->lang->line('Customer Return Amount').' '.$this->lang->line('is not valid')?>")
		);
	}

	//form validation edit
	function validateForm_edit() {
		return (isNotEmpty("reference_no_edit", "<?php echo $this->lang->line('reference_no').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("customer_return_note_date_edit", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("customer_id_edit", "<?php echo $this->lang->line('Customer').' '.$this->lang->line('field is required')?>")
			&& isSelected("location_edit", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("customer_return_amount_edit", "<?php echo $this->lang->line('Customer Return Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//get all data
	function getTableData(year, month, customerId, territoryId, ReferenceNo){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/customer_return_note_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
				'customer_id' : customerId,
				'territory_id' : territoryId,
                'reference_no_link' : ReferenceNo,
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
				
				$('.customerReturnNoteDataTable').dataTable({
					"aaSorting": [[ 1, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		})
	}

	function clearForm(){
		$("#reference_no").val('');
		$("#customer_return_note_date").val(moment().format('YYYY-MM-DD'));
		$("#customer_id").select2('destroy');
		$("#customer_id").val('0');
        $("#customer_id").select2();
		$("#location").val('0');
		$("#territory").val('0');
		$("#customer_return_amount").val('');
		$("#discount").val('');
		$("#free_issue_amount").val('');
		$("#remark").val('');
		$("#saleable_return").prop("checked", true);
		$("#market_return").prop("checked", false);
	}
</script>

<style>

    .green_color {
		background-color: #66ff33 !important;			
	}
	
	.default_color {
		background-color: white !important;
	}
</style>
