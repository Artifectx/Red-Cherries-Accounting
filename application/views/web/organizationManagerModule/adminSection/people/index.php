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
								<span><?php echo $this->lang->line('People Details') ?></span>
							</h1>
							<div class='pull-right'></div>
						</div>
					</div>
				</div>
				<div class='msg_data'></div>
                <div class='validation'></div>
                <div class='msg_instant' align="center"></div>
				<div class='form'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background'>
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('People Details') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<form class='form form-horizontal validate-form save_form' enctype="multipart/form-data">
										<div class='row'>
											<div class='col-sm-7'>
												<div class='form-group' id="people_type_div">
													<input class='form-control' id='people_id' name='people_id' type='hidden'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('People Type') ?> *</label>
													<div class='col-sm-7 controls'>
														<select class='form-control' name='people_type' id='people_type' onchange="getPeopleType();">
															<option value=''><?php echo $this->lang->line('-- Select --');?></option>
															<?php
															foreach($peopleType as $row){
                                                                if (($row['people_type'] == "Agent" && isset($OGM_Admin_View_Agent_Advanced_List)) || 
                                                                    ($row['people_type'] == "Sales Rep" && isset($OGM_Admin_View_Sales_Rep_Advanced_List)) ||
                                                                    ($row['people_type'] == "Supplier" && isset($OGM_Admin_View_Supplier_Advanced_List)) || 
                                                                    ($row['people_type'] == "Customer" && isset($OGM_Admin_View_Customer_Advanced_List)) ||
                                                                    ($row['people_type'] == "Cashier" && isset($OGM_Admin_View_Cashier_Advanced_List)) ||
                                                                    ($row['people_type'] == "Driver" && isset($OGM_Admin_View_Driver_Advanced_List)) ||
                                                                    ($row['people_type'] == "Member" && isset($OGM_Admin_View_Member_Advanced_List)) ||
                                                                    ($row['people_type'] == "Employee" && isset($OGM_Admin_View_Employee_Advanced_List))) {
															?>
                                                                    <option value='<?php echo $row['people_type'];?>'><?php echo $row['people_type'];?></option>
															<?php
                                                                }
															}
															?>
														</select>
														<div id="people_typeError" class="red"></div>
													</div>
												</div>
												<div class='form-group' id="is_also_sales_rep_div">
													<div class='col-sm-5 controls'></div>
													<div class='col-sm-7 controls'>
														<input type="checkbox" name="is_also_sales_rep" id="is_also_sales_rep" style="vertical-align: text-bottom;">
														<label for="is_also_sales_rep" ><?php echo $this->lang->line('Is Also a Sales Rep') ?></label>
													</div>
												</div>
												<div class='form-group' id="is_also_cashier_div">
													<div class='col-sm-5 controls'></div>
													<div class='col-sm-7 controls'>
														<input type="checkbox" name="is_also_cashier" id="is_also_cashier" style="vertical-align: text-bottom;">
														<label for="is_also_cashier" ><?php echo $this->lang->line('Is Also a Cashier') ?></label>
													</div>
												</div>
												<div id="people_category_div">

												</div>
												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('People Code') ?> *</label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='people_code'
															   name='people_code' placeholder='<?php echo $this->lang->line('People Code') ?>' type='text'
															   value="<?php echo set_value('people_code'); ?>">
														<div id="people_codeError" class="red"></div>
													</div>
                                                    
												</div>

												<div class='form-group' id="people_name_div">
													<label class='control-label col-sm-5'><?php echo $this->lang->line('People Name') ?> *</label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='people_name'
															   name='people_name' placeholder='<?php echo $this->lang->line('People Name') ?>' type='text'
															   value="<?php echo set_value('people_name'); ?>">
														<div id="people_nameError" class="red"></div>
													</div>
												</div>
                                                
                                                <div class='form-group' id="people_short_name_div">
													<label class='control-label col-sm-5'><?php echo $this->lang->line('People Short Name') ?></label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='people_short_name'
															   name='people_short_name' placeholder='<?php echo $this->lang->line('People Short Name') ?>' type='text'
															   value="<?php echo set_value('people_short_name'); ?>">
														<div id="people_short_nameError" class="red"></div>
													</div>
												</div>
												
												<div class='form-group' id="employee_div">
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Employee') ?> *</label>
													<div class='col-sm-7 controls'>
														<select id="employee_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
														<!--Employee drop down-->
														<div id="employee_dropdown">
														</div>
														<!--End Employee drop down-->
														<div id="employee_idError" class="red"></div>
													</div>
												</div>
												
												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('NIC') ?></label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='nic'
															   name='nic' placeholder='<?php echo $this->lang->line('NIC') ?>' type='text'
															   value="<?php echo set_value('nic'); ?>">
														<div id="nicError" class="red"></div>
													</div>
												</div>

												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Birthday') ?> </label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='birth_day'
															   name='birth_day' placeholder='<?php echo $this->lang->line('Birthday') ?>' type='text'
															   value="<?php echo set_value('birth_day'); ?>">
														<div id="birth_dayError" class="red"></div>
													</div>
												</div>

												<div id="country_dropdown">
												</div>

												<div id="location_dropdown">
												</div>

												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Address') ?> </label>
													<div class='col-sm-7 controls'>
														<textarea class='form-control' id='address'
																  name='address' placeholder='<?php echo $this->lang->line('Address') ?>'><?php echo set_value('address'); ?></textarea>

														<div id="addressError" class="red"></div>
													</div>
												</div>
												
												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Primary Phone No') ?> </label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='primary_phone'
															   name='primary_phone' placeholder='<?php echo $this->lang->line('Primary Phone No') ?>' type='text'
															   value="<?php echo set_value('primary_phone'); ?>">
														<div id="primary_phoneError" class="red"></div>
													</div>
												</div>

												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Secondary Phone No') ?> </label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='secondary_phone'
															   name='secondary_phone' placeholder='<?php echo $this->lang->line('Secondary Phone No') ?>' type='text'
															   value="<?php echo set_value('secondary_phone'); ?>">
														<div id="secondary_phoneError" class="red"></div>
													</div>
												</div>

												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('E-mail') ?></label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='email' name='email'
															   placeholder='<?php echo $this->lang->line('E-mail') ?>' type='text'
															   value="<?php echo set_value('email'); ?>">
														<div id="emailError" class="red"></div>
													</div>
												</div>

												<div class='form-group'>
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Fax') ?></label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='fax' name='fax' 
															   placeholder='<?php echo $this->lang->line('Fax') ?>'type='text'
															   value="<?php echo set_value('fax'); ?>">
														<div id="faxError" class="red"></div>
													</div>
												</div>
												
												<div class='form-group' id="immediate_contact_person_div">
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Immediate Contact Person') ?></label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='immediate_contact_person'
															   name='immediate_contact_person' placeholder='<?php echo $this->lang->line('Immediate Contact Person') ?>' type='text' value="<?php echo set_value('immediate_contact_person'); ?>">
														<div id="immediate_contact_personError" class="red"></div>
													</div>
												</div>
												
												<div class='form-group' id="immediate_contact_phone_div">
													<label class='control-label col-sm-5'><?php echo $this->lang->line('Immediate Contact Phone No') ?></label>
													<div class='col-sm-7 controls'>
														<input class='form-control' id='immediate_contact_phone'
															   name='immediate_contact_phone' placeholder='<?php echo $this->lang->line('Immediate Contact Phone No') ?>' type='text' value="<?php echo set_value('immediate_contact_phone'); ?>">
														<div id="immediate_contact_phoneError" class="red"></div>
													</div>
												</div>
											</div>
											<div class='col-sm-5'>
												<div class='form-group' id="document_upload" style="text-align: center;">
													<button class='btn btn-success save' onclick='openDocumentUploadDialog("");'
															type='button' <?php echo $menuFormatting; ?>>
														<i class='icon-save'></i>
														<?php echo $this->lang->line('Upload A Document') ?>
													</button>			
												</div>
												<div class='form-group' id="document_list">
													
												</div>
												<div class='form-group' id="last_people_code_div" style="text-align:center;">
                                                    <label id='last_people_code' class='control-label' style="color:orange;"></label>
												</div>
											</div>
										</div>

										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<?php
													if (isset($OGM_Admin_Add_People_Permissions)){
														?>
														<button class='btn btn-success save' onclick='saveData();'
																type='button' <?php echo $menuFormatting; ?>>
															<i class='icon-save'></i>
															<?php echo $this->lang->line('Save') ?>
														</button>
														<?php
													}
													?>

													<button class='btn btn-primary' type='reset' <?php echo $menuFormatting; ?>>
														<i class='icon-undo'></i>
														<?php echo $this->lang->line('Refresh') ?>
													</button>
													<button class='btn btn-warning cancel' onclick='cancelData();'
															type='button' <?php echo $menuFormatting; ?>>
														<i class='icon-ban-circle'></i>
														<?php echo $this->lang->line('Close') ?>
													</button>
												</div>
											</div>
										</div>
									</form>
									<!--edit form-->
									<div class='edit_form'></div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--get people type & icons -->
				<div class='box'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='text-center'>
								<ul class="dash">
									<?php
									foreach($peopleType as $row){
                                        if (($row['people_type'] == "Agent" && isset($OGM_Admin_View_Agent_Advanced_List)) ||
                                            ($row['people_type'] == "Sales Rep" && isset($OGM_Admin_View_Sales_Rep_Advanced_List)) ||
                                            ($row['people_type'] == "Supplier" && isset($OGM_Admin_View_Supplier_Advanced_List)) || 
                                            ($row['people_type'] == "Customer" && isset($OGM_Admin_View_Customer_Advanced_List)) ||
                                            ($row['people_type'] == "Cashier" && isset($OGM_Admin_View_Cashier_Advanced_List)) ||
                                            ($row['people_type'] == "Driver" && isset($OGM_Admin_View_Driver_Advanced_List)) ||
                                            ($row['people_type'] == "Member" && isset($OGM_Admin_View_Member_Advanced_List)) ||
                                            ($row['people_type'] == "Employee" && isset($OGM_Admin_View_Employee_Advanced_List))) {
                                    ?>
                                            <li>
                                                <a class="tip" href="#" title="<?php echo $this->lang->line($row['people_type']); ?>" onclick="getPeopleList('<?php echo $row['people_type']?>');">
                                                    <i><img src="<?php echo base_url(); ?>assets/images/icons/suppliers.png"
                                                            alt=""/></i>
                                                    <span><span><?php echo $this->lang->line($row['people_type']); ?></span></span>
                                                </a>
                                            </li> 
                                    <?php   
                                        }
									}
									?>
								</ul>

							</div>
						</div>
					</div>
				</div>

				<div class="msg_delete"></div>

				<?php
				if (isset($OGM_Admin_Add_People_Permissions)){ ?>
					<button class='btn btn-success btn-sm new'
							type='button' <?php echo $menuFormatting; ?>>
						<?php echo $this->lang->line('Add New People') ?>
					</button>
				<?php
				}
				?>
				<div id='table'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>

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
							
			<div class='modal fade' id='modal-people_document' tabindex='-1'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='myModalLabel' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Document Upload') ?></h4>
						</div>
						<form enctype="multipart/form-data" accept-charset="utf-8" name="formname" id="formname"  method="post" action="">
							<div class='modal-body' style="height:60px;width:700px">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<input class='form-control' id='people_id_on_document_upload' name='people_id_on_document_upload' type='hidden'>
										<label class="control-label col-sm-3" for="inputText1"><?php echo $this->lang->line('Select Document To Upload') ?></label>
										<div class="col-sm-9 controls">
											<input type="file" name="file_to_upload" id="file_to_upload">
										</div>
									</div>
								</div>
							</div>
							<div class='modal-footer'>
								<button class='btn btn-primary' id="btnUploadDocument"  type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Upload Document') ?></button>
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

	var SelectedPeopleType = '';
	var PeopleAddEditScreenOperationStatus = "";

	$(document).ready(function () {
        $(".msg_instant").hide();
		People.init();
		People.getCountryList();
		People.getEmployeeData();
		$("#document_upload").hide();
        $("#last_people_code_div").hide();
		$("#primary_phone").intlTelInput();
		$("#secondary_phone").intlTelInput();
		$("#fax").intlTelInput();
		$("#birth_day").datetimepicker({
			format: 'YYYY-MM-DD'
		});
	});

	$(".new").click(function () {
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		$(".form").show();
		$(".edit_form").hide();
		clearForm();
		$("#employee_div").hide();
		$("#is_also_sales_rep_div").hide();
		$("#is_also_cashier_div").hide();
		$("#people_category_div").hide();
		$("#location_dropdown").hide();
		$("#immediate_contact_person_div").hide();
		$("#immediate_contact_phone_div").hide();
		$("#table").hide();
        $("#document_upload").hide();
        $("#document_list").empty();
		PeopleAddEditScreenOperationStatus = "Add";
	});

	function cancelData() {
		People.cancelData();
	}

	function saveData() {
		$("#table").hide();
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			People.saveData();
            window.scrollTo(0,0);
		}
	}

	function editData() {
		$("#table").hide();
		if (validateForm_edit()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			People.editData();
            window.scrollTo(0,0);
		}
	}

	function get(peopleId){
		People.hideMessageDisplay();
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		PeopleAddEditScreenOperationStatus = "Edit";
		People.getData(peopleId);
	}

	function del(peopleId){
		People.hideMessageDisplay();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		People.deleteData(peopleId);
	}


	function getPeopleType(){
		if ($("#people_type").val() == "Agent" || $("#people_type").val() == "Customer") {
			$("#is_also_sales_rep_div").hide();
			$("#is_also_cashier_div").hide();
			$("#people_category_div").show();
			$("#location_dropdown").show();
			$("#people_category_div").empty();
			$("#location_dropdown").empty();
			$("#people_name_div").show();
			$("#employee_div").hide();
			$("#immediate_contact_person_div").show();
			$("#immediate_contact_phone_div").show();
			
			People.getLocationList("save_screen", $("#people_type").val());
			People.loadPeopleCategory("save_screen", $("#people_type").val());
		} else if ($("#people_type").val() == "Employee") {
			$("#is_also_sales_rep_div").show();
			$("#is_also_cashier_div").show();
			$("#people_category_div").empty();
			$("#people_category_div").hide();
			$("#location_dropdown").empty();
			$("#location_dropdown").hide();
			$("#people_name_div").show();
			$("#employee_div").hide();
			$("#immediate_contact_person_div").show();
			$("#immediate_contact_phone_div").show();
		} else if ($("#people_type").val() == "Cashier") {
            $("#is_also_sales_rep_div").hide();
			$("#is_also_cashier_div").hide();
			$("#people_name_div").hide();
			$("#employee_div").show();
			$("#immediate_contact_person_div").hide();
			$("#immediate_contact_phone_div").hide();
		} else if ($("#people_type").val() == "Driver") {
            $("#is_also_sales_rep_div").hide();
			$("#is_also_cashier_div").hide();
            $("#people_name_div").hide();
			$("#employee_div").show();
			$("#immediate_contact_person_div").hide();
			$("#immediate_contact_phone_div").hide();
		} else if ($("#people_type").val() == "Sales Rep") {
			$("#is_also_sales_rep_div").hide();
			$("#is_also_cashier_div").hide();
			$("#people_category_div").empty();
			$("#people_category_div").hide();
			$("#location_dropdown").empty();
			$("#location_dropdown").hide();
			$("#people_name_div").show();
			$("#employee_div").hide();
			$("#immediate_contact_person_div").hide();
			$("#immediate_contact_phone_div").hide();
		} else {
			$("#is_also_sales_rep_div").hide();
			$("#is_also_cashier_div").hide();
			$("#people_category_div").empty();
			$("#people_category_div").hide();
			$("#location_dropdown").empty();
			$("#location_dropdown").hide();
			$("#people_name_div").show();
			$("#employee_div").hide();
			$("#immediate_contact_person_div").show();
			$("#immediate_contact_phone_div").show();
		}

		if($("#people_type").val() == "Sales Rep") {
			$("#people_name_div").hide();
			$("#employee_div").show();
		}
        
        People.getLastPeopleCode($("#people_type").val());
	}

	function getPeopleTypeEdit(){
		if($("#people_type_edit").val() == "Agent" || $("#people_type_edit").val() == "Customer") {
			$("#is_also_sales_rep_div_edit").hide();
			$("#is_also_cashier_div_edit").hide();
			$("#people_category_div_edit").show();
			$("#location_dropdown_edit").show();
			$("#people_category_div_edit").empty();
			$("#location_dropdown_edit").empty();
			$("#people_name_div_edit").show();
			$("#employee_div_edit").hide();
			
			People.getLocationList("edit_screen", $("#people_type_edit").val());
			People.loadPeopleCategory("edit_screen", $("#people_type_edit").val());
		} else if ($("#people_type_edit").val() == "Employee") {
			$("#is_also_sales_rep_div_edit").show();
			$("#is_also_cashier_div_edit").show();
			$("#people_category_div_edit").empty();
			$("#people_category_div_edit").hide();
			$("#location_dropdown_edit").empty();
			$("#location_dropdown_edit").hide();
			$("#people_name_div_edit").show();
			$("#employee_div_edit").hide();
		} else if ($("#people_type").val() == "Cashier") {
			$("#people_name_div_edit").hide();
			$("#employee_div_edit").show();
		} else if ($("#people_type").val() == "Driver") {
			$("#people_name_div_edit").hide();
			$("#employee_div_edit").show();
		} else {
			$("#is_also_sales_rep_div_edit").hide();
			$("#is_also_cashier_div_edit").hide();
			$("#people_category_div_edit").empty();
			$("#people_category_div_edit").hide();
			$("#location_dropdown_edit").empty();
			$("#location_dropdown_edit").hide();
			$("#people_name_div_edit").show();
			$("#employee_div_edit").hide();
		}

		if($("#people_type").val() == "Sales Rep") {
			$("#people_name_div_edit").hide();
			$("#employee_div_edit").show();
		}
	}

	function exportToExcel(){
		alert('export to excel');
	}

	function exportToPdf(){
		alert('export to pdf');
	}

	function handlePeopleCategorySelect(screen, peopleCategory, id) {
        screen = String(screen).replace("/", "");
        screen = String(screen).replace("/", "");
        
        var selectedCategory = $("#" + id).val();
        
	}

	$("#btnUploadDocument").click(function (e){ 

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Document Successfully Uploaded') ?>'+
				'</div>';
		
			var fileName = $("#file_to_upload").val();
			if (fileName.substring(3,11) == 'fakepath') {
				fileName = fileName.substring(12);
			}

		// send the formData
		var formData = new FormData( $("#formname")[0] );
		formData.append('file_name', fileName);
		formData.append('people_id', $("#people_id_on_document_upload").val());
		formData.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');

		$.ajax({
			url :"<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/uploadDocument",
			type : 'POST',
			data : formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success	: function (responseData){
				if (responseData.response === "success") {
					$(".validation").hide();
					$(".msg_data").show();
					$(".msg_data").html(msg);
				}
				People.getPeopleDocuments($("#people_id_on_document_upload").val());
				closeDocumentUploadDialog();
			}
		});
	});
	
	function deleteDocument(id) {
		var documentId = id.substring(16,35);
		People.deleteDocument(documentId);
	}
	
    function getPeopleList(peopleType) {
        People.init();
        getTableData(peopleType);
    }
    
    function authorize(peopleId, peopleType) {
        peopleType = String(peopleType).replace("/", "");
        peopleType = String(peopleType).replace("/", "");
        People.authorize(peopleId, peopleType);
    }
	
	var People = {
		cancelData: function () {
			$(".form").hide();
			$("#nic").val('');
			$("#birth_day").val('');
		},

		saveData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

				var PeopleCategory = '';
				var LocationMultiselect = false;
				var PeopleType = $("#people_type").val();
				var LocationIds = [];
				var LocationIdList = '';
				var TaxNumber = '';
				var peopleId = '';
				var peopleName = '';
                var peopleShortName = '';
				var immediateContactPerson = '';
				var immediateContactPhone = '';
				
				if (PeopleType == "Sales Rep" || PeopleType == "Cashier" || PeopleType == "Driver") {
					var employeeData = $("#employee_id").select2('data');
					peopleId = employeeData.id;
					peopleName = employeeData.text;
				} else {
					peopleName = $("#people_name").val();
				}
                
                peopleShortName = $("#people_short_name").val();

				//var peopleCategoryElement = $("#people_category_div").find("#agent_category");

				if ($("#people_category_div").is(":visible")) {
					PeopleCategory = $("#agent_category").val();
				}

				//var peopleCategoryElement = $("#people_category_div").find("#customer_category");

				if ($("#people_category_div").is(":visible")) {
					PeopleCategory = $("#customer_category").val();
				}

				if (PeopleCategory == "0") {
					PeopleCategory = '';
				}

				if (PeopleType == "Agent") {
					LocationMultiselect = true;
				}

				if (PeopleType == "Agent" || PeopleType == "Customer") {
					if (LocationMultiselect == true) {
						// 'data' brings the unordered list, while 'val' does not
						var data = $('#location').select2('data');

						// Push each item into an array
						for( item in $('#location').select2('data') ) {
							LocationIds.push(data[item].id);
						};

						// Display the result with a comma
						LocationIdList =  LocationIds.join(',');
					} else {
						LocationIdList = $("#location").val();
					}
				}
				
				var isAlsoASalesRep = "No";
				if (PeopleType == "Employee") {
					if ($("#is_also_sales_rep").prop("checked") == true) {
						isAlsoASalesRep = 'Yes';
					}
				}
				
				var isAlsoACashier = "No";
				if (PeopleType == "Employee") {
					if ($("#is_also_cashier").prop("checked") == true) {
						isAlsoACashier = 'Yes';
					}
				}

				//var immediateContactPersonElement = $("#immediate_contact_person_div").find("#immediate_contact_person");
				
				if ($("#immediate_contact_person_div").is(":visible")) {
					immediateContactPerson = $("#immediate_contact_person").val();
					immediateContactPhone = $("#immediate_contact_phone").val();
				}

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/add",
					data: {
						'people_type': PeopleType,
						'is_also_a_sales_rep' : isAlsoASalesRep,
						'is_also_a_cashier' : isAlsoACashier,
						'people_category' : PeopleCategory,
						'people_code': $("#people_code").val(),
						'people_id': peopleId,
						'people_name': peopleName,
                        'people_short_name': peopleShortName,
						'nic':$("#nic").val(),
						'birth_day':$("#birth_day").val(),
						'address': $("#address").val().trim(),
						'country_id': $("#country").val(),
						'location_ids': LocationIdList,
						'primary_telephone_number': $("#primary_phone").val(),
						'secondary_telephone_number': $("#secondary_phone").val(),
						'email': $("#email").val(),
						'fax': $("#fax").val(),
						'immediate_contact_person' : immediateContactPerson,
						'immediate_contact_phone' : immediateContactPhone,
						<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
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

							$("#people_id").val(response.peopleId);
							$("#document_upload").show();
                            $("#last_people_code_div").hide();
							
                            window.scrollTo(0,0);
						} else {
							$(".msg_data").hide();
							$(".validation").show();
							$(".validation").html(response.result);
							$(".save:input").attr('disabled', false);
                            window.scrollTo(0,0);
						}
					}
				})
		},

		editData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_updated')?>' +
				'</div>';

			var updateChanges = true;

			if (updateChanges == true) {
				var PeopleCategory = '';
				var LocationMultiselect = false;
				var PeopleType = $("#people_type_edit").val();
				var LocationIds = [];
				var LocationIdList = '';
				var TaxNumber = '';
				var isAlsoASalesRep = "No";
				var isAlsoACashier = "No";
				var immediateContactPerson = '';
				var immediateContactPhone = '';

				//var peopleCategoryElement = $("#people_category_div_edit").find("#agent_category_edit");

				if ($("#people_category_div_edit").is(":visible")) {
					PeopleCategory = $("#agent_category_edit").val();
				}

				//var peopleCategoryElement = $("#people_category_div_edit").find("#customer_category_edit");

				if ($("#people_category_div_edit").is(":visible")) {
					PeopleCategory = $("#customer_category_edit").val();
				}

				if (PeopleCategory == "0") {
					PeopleCategory = '';
				}

				if (PeopleType == "Agent") {
					LocationMultiselect = true;
				}

				if (PeopleType == "Agent" || PeopleType == "Customer") {
					if (LocationMultiselect == true) {
						// 'data' brings the unordered list, while 'val' does not
						var data = $('#location_edit').select2('data');

						// Push each item into an array
						for( item in $('#location_edit').select2('data') ) {
							LocationIds.push(data[item].id);
						};

						// Display the result with a comma
						LocationIdList =  LocationIds.join(',');
					} else {
						LocationIdList = $("#location_edit").val();
					}
				}
				
				if (PeopleType == "Employee") {
					if ($("#is_also_sales_rep_edit").prop("checked") == true) {
						isAlsoASalesRep = 'Yes';
					}
				}
				
				if (PeopleType == "Employee") {
					if ($("#is_also_cashier_edit").prop("checked") == true) {
						isAlsoACashier = 'Yes';
					}
				}

				//var immediateContactPersonElement = $("#immediate_contact_person_div_edit").find("#immediate_contact_person_edit");
				
				if ($("#immediate_contact_person_div_edit").is(":visible")) {
					immediateContactPerson = $("#immediate_contact_person_edit").val();
					immediateContactPhone = $("#immediate_contact_phone_edit").val();
				}

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/edit",
					data: {
							'people_id': $("#people_id_edit").val(),
							'people_type': PeopleType,
							'is_also_a_sales_rep' : isAlsoASalesRep,
							'is_also_a_cashier' : isAlsoACashier,
							'people_category' : PeopleCategory,
							'people_code': $("#people_code_edit").val(),
							'people_name': $("#people_name_edit").val(),
                            'people_short_name': $("#people_short_name_edit").val(),
							'nic':$("#nic_edit").val(),
							'birth_day':$("#birth_day_edit").val(),
							'country_id': $("#country_edit").val(),
							'location_ids': LocationIdList,
							'address': $("#address_edit").val().trim(),
							'primary_telephone_number': $("#primary_phone_edit").val(),
							'secondary_telephone_number': $("#secondary_phone_edit").val(),
							'email': $("#email_edit").val(),
							'fax': $("#fax_edit").val(),
							'immediate_contact_person' : immediateContactPerson,
							'immediate_contact_phone' : immediateContactPhone,
							<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					beforeSend:function () {
						$(".save:input").attr('disabled', true);
					},
					success: function (response) {
                        
                        $(".msg_instant").hide();
                        
						if (response == 'ok') {
							$(".validation").hide();
							$(".msg_data").show();
							$(".msg_data").html(msg);
							$(".save:input").attr('disabled', false);

							$(".form").hide();
							$(".edit_form").hide();
						}
						else {
							$(".msg_data").hide();
							$(".validation").show();
							$(".validation").html(response);
							$(".save:input").attr('disabled', false);
						}
					}
				})
			}
		},

		deleteData: function (peopleId) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete').$this->lang->line('People Details') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/delete",
					data: {
						'people_id': peopleId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
                        $(".msg_instant").hide();
						$(".msg_delete").show();
						$(".msg_delete").html(response);

						$(".form").hide();
						$(".edit_form").hide();
						getTableData(SelectedPeopleType);
					}
				})
			}
		},

		getData: function (peopleId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/get",
				data: {
					'people_id': peopleId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
					success:function (response) {
					$(".form").show();
					$(".save_form").hide();
					$(".edit_form").show();
					$(".edit_form").html(response.html);
					$("#primary_phone_edit").intlTelInput();
					$("#secondary_phone_edit").intlTelInput();
					$("#fax_edit").intlTelInput();
					$(".loader").hide();
					$("#birth_day_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					if (response.peopleType == "Agent") {

						$("#location_edit").val(response.agentLocations).trigger("change");
						$('#location_edit').select2();

						var fieldCount = response.agentLocations.length;
						// 'data' brings the unordered list, while 'val' does not
						var data = $('#location_edit').select2('data');

						// Push each item into an array
						var finalResult = [];

						var count = 0;
						while (count != fieldCount) {
							for( item in $('#location_edit').select2('data') ) {
								if (data[item].id == response.agentLocations[count]) {
									finalResult.push(data[item]);
								};
							};
							count++;
						};

						// Display the result with a comma
						var FieldList =  finalResult;
						$("#location_edit").val('').trigger("change");
						$('#location_edit').select2('data', FieldList);

						$("#location_edit option[value='0']").remove();
						$('#location_edit').select2();
					}
				}
			})
		},
		
		loadPeopleCategory : function(screen, category) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>stockManagerModule/adminSection/system_configurations_controller/getPeopleCategories",
				data: {
					'screen' : screen,
					'people_category' : category,
					'label_col_position' : '5',
					'drop_down_col_position' : '7',
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					if (response != '') {
						if (screen == "save_screen") {
							$("#people_category_div").append(response);
						} else if (screen == "edit_screen") {
							$("#people_category_div_edit").append(response);
						}
					}
				}
			})
		},

		getPeopleDocuments : function (peopleId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getPeopleDocuments",
				data: {
					'people_id' : peopleId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					if (response != '') {
						if (PeopleAddEditScreenOperationStatus == "Add") {
							$("#document_list").empty();
							$("#document_list").append(response);
						} else if (PeopleAddEditScreenOperationStatus == "Edit") {
							$("#document_list_edit").empty();
							$("#document_list_edit").append(response);
						}
					}
				}
			})
		},
		
		deleteDocument : function (documentId) {
			
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_deleted')?>' +
				'</div>';
		
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete').$this->lang->line('the document') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/deleteDocument",
					data: {
						'document_id' : documentId,
						<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
						if (response == 'ok') {
							$(".msg_data").show();
							$(".msg_data").html(msg);
							$("#people_document_" + documentId).remove();
						}
					}
				})
			}
		},
		
		init : function () {
			$("#table").hide();
			$(".form").hide();
			$(".edit_form").hide();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
			$("#location_dropdown").hide();
		},

		getCountryList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getCountryDropDown",
				data: {
					'label_col_position' : '5',
					'drop_down_col_position' : '7',
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(countryList) {
					$("#country_dropdown").html(countryList);
				}
			});
		},

		getLocationList: function(screen, category){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getAllToLocationsDropDownOnPeopleScreen",
				data: {
					'screen' : screen,
					'people_category' : category,
					'label_col_position' : '5',
					'drop_down_col_position' : '7',
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(locationList) {
					if (screen == "save_screen") {
						$("#location_dropdown").append(locationList);
						if (category == "Agent") {
							$("#location option[value='0']").remove();
							$('#location').val('');
							$('#location').select2();
						}
					} else if (screen == "edit_screen") {
						$("#location_dropdown_edit").append(locationList);
						if (category == "Agent") {
							$("#location_edit option[value='0']").remove();
							$('#location_edit').val('');
							$('#location_edit').select2();
						}
					}
				}
			});
		},
		
		//get employee drop down
		getEmployeeData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToEmployeeDropDown",
				data: {
                    'check_authority' : "Yes",
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#employee_init').hide();
						$("#employee_dropdown").html(response);
						$("#employee_div").find("#people_id").prop({ id: "employee_id"});
						$("#employee_id").select2();
					}
			});
		},
        
        //Authorize people addition
		authorize: function (peopleId, peopleType) {
        
            var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('Successfully authorized')?>' +
				'</div>';
        
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/authorize",
				data: {
                    'people_id' : peopleId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
                        if (response == 'ok') {
                            $(".msg_data").show();
                            $(".msg_data").html(msg);
                            getTableData(peopleType);
                        }
					}
			});
		},
        
        getLastPeopleCode: function(peopleType) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getLastPeopleCode",
				data: {
					'people_type': peopleType,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
                    $("#last_people_code_div").show();
					$("#last_people_code").text(response);
				}
			})
		},

		hideMessageDisplay : function () {
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		}

	};//end supplier object

	function validateForm_save() {
		return (isSelected("people_type", "<?php echo $this->lang->line('people_type').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("people_code", "<?php echo $this->lang->line('people_code').' '.$this->lang->line('field is required')?>")
			&& validatePeopleSelect_save()
		);
	}

	function validateForm_edit() {
		return (isSelected("people_type_edit", "<?php echo $this->lang->line('people_type').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("people_code_edit", "<?php echo $this->lang->line('people_code').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("people_name_edit", "<?php echo $this->lang->line('people_name').' '.$this->lang->line('field is required')?>")
		);
	}
	
	function validatePeopleSelect_save() {
		if ($("#people_type").val() == "Supplier" || $("#people_type").val() == "Agent" || $("#people_type").val() == "Customer" || $("#people_type").val() == "Member" || $("#people_type").val() == "Employee") {
			return isNotEmpty("people_name", "<?php echo $this->lang->line('people_name').' '.$this->lang->line('field is required')?>");
		} else {
			return isSelected("employee_id", "<?php echo $this->lang->line('employee_name').' '.$this->lang->line('field is required')?>");
		}
	}
	
	//get all data
	function getTableData(peopleType) {
        
		SelectedPeopleType = peopleType;
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getTableData",
			data: {
				'people_type':peopleType,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#table").show();
				$("#dataTable").html(response);
				$(".loader").hide();
				$('.table').DataTable();
			}
		})
	}

	function clearForm(){
		$("#people_type").val('');
		$("#people_code").val('');
		$("#people_name").val('');
		$("#address").val('');
		$("#country").val('');
		$("#location").val('0');
		$("#primary_phone").val('');
		$("#secondary_phone").val('');
		$("#email").val('');
		$("#fax").val('');
	}
	
	function openDocumentUploadDialog(peopleId) {
		$(".validation").hide();
		$(".msg_data").hide();
		$("#file_to_upload").val("");
		if (peopleId == "") {
			$("#people_id_on_document_upload").val($("#people_id").val());
		} else {
			$("#people_id_on_document_upload").val(peopleId);
		}
		$("#modal-people_document").modal('show');
	}

	function closeDocumentUploadDialog() {
		$("#modal-people_document").modal('hide');
	}
	
</script>
