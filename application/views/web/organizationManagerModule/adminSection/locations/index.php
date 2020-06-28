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
								<span><?php echo $this->lang->line('Locations Details') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
                <div class='msg_instant' align="center"></div>
				<div class='form page_load' id='page_load'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background'>
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Locations Details') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<div class='msg_data'></div>
									<div class='validation'></div>
									<form class='form form-horizontal validate-form save_form'>
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Location Code') ?> *</label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='location_code'
													   name='location_code' placeholder='<?php echo $this->lang->line('Location Code') ?>' type='text'
													   value="<?php echo set_value('location_code'); ?>">
												<div id="location_codeError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Location Name') ?> *</label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='location_name'
													   name='location_name' placeholder='<?php echo $this->lang->line('Location Name') ?>' type='text'
													   value="<?php echo set_value('location_name'); ?>">
												<div id="location_nameError" class="red"></div>
											</div>
										</div>

										<div id="company_dropdown">
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Address') ?> </label>
											<div class='col-sm-4 controls'>
												<textarea class='form-control' id='address'
														  name='address' placeholder='<?php echo $this->lang->line('Address') ?>'><?php echo set_value('address'); ?></textarea>

												<div id="addressError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('City') ?> </label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='city'
													   name='city' placeholder='<?php echo $this->lang->line('City') ?>' type='text'
													   value="<?php echo set_value('city'); ?>">
												<div id="cityError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('State') ?> </label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='state'
													   name='state' placeholder='<?php echo $this->lang->line('State') ?>' type='text'
													   value="<?php echo set_value('state'); ?>">
												<div id="stateError" class="red"></div>
											</div>
										</div>

										<div id="country_dropdown">
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Time Zone') ?> </label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='time_zone'
													   name='time_zone' placeholder='<?php echo $this->lang->line('Time Zone') ?>' type='text'
													   value="<?php echo set_value('time_zone'); ?>">
												<div id="time_zoneError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Primary Phone No') ?> </label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='primary_phone'
													   name='primary_phone' placeholder='<?php echo $this->lang->line('Primary Phone No') ?>' type='text'
													   value="<?php echo set_value('primary_phone'); ?>">
												<div id="primary_phoneError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Secondary Phone No') ?> </label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='secondary_phone'
													   name='secondary_phone' placeholder='<?php echo $this->lang->line('Secondary Phone No') ?>' type='text'
													   value="<?php echo set_value('secondary_phone'); ?>">
												<div id="secondary_phoneError" class="red"></div>
											</div>
										</div>

										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<?php
													if (isset($OGM_Admin_Add_Locations_Permissions)){ ?>
													        <button class='btn btn-success save' onclick='saveData();'type='button' <?php echo $menuFormatting; ?>>
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

				<div id='table'>
					<div class="msg_delete"></div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
								<?php
								if (isset($OGM_Admin_Add_Locations_Permissions)){ ?>
									<button class='btn btn-success btn-sm new'
											type='button' <?php echo $menuFormatting; ?>>
										<?php echo $this->lang->line('Add New Location') ?>
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
	$(document).ready(function () {
        $(".msg_instant").hide();
		getTableData();
		locations.init();
		locations.getCompanyList();
		locations.getCountryList();
		$("#primary_phone").intlTelInput();
		$("#secondary_phone").intlTelInput();
	});

	$(".new").click(function () {
		$("#page_load").removeClass("page_load");
		$("#page_load").addClass("page_load_show");
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		$(".form").show();
		$(".edit_form").hide();

	});

	function cancelData() {
		locations.cancelData();
	}

	function saveData() {
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			locations.saveData();
            window.scrollTo(0,0);
		}
	}

	function editData() {
		if (validateForm_edit()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			locations.editData();
            window.scrollTo(0,0);
		}
	}

	function get(id){
		$("#page_load").removeClass("page_load");
		$("#page_load").addClass("page_load_show");
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		locations.getData(id);
	}

	function del(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		locations.deleteData(id);
	}

	function exportToExcel(){
		alert('export to excel');
	}

	function exportToPdf(){
		alert('export to pdf');
	}


	//start location object
	var locations = {
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
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/add",
					data: {
						'location_code': $("#location_code").val(),
						'location_name': $("#location_name").val(),
						'company_id': $("#company").val(),
						'address': $("#address").val(),
						'city': $("#city").val(),
						'state': $("#state").val(),
						'country_id': $("#country").val(),
						'time_zone': $("#time_zone").val(),
						'primary_telephone_number': $("#primary_phone").val(),
						'secondary_telephone_number': $("#secondary_phone").val(),
						<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
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

							$(".form").hide();
							$(".edit_form").hide();

							clearForm();
							getTableData();
						}
						else {
							$(".msg_data").hide();
							$(".validation").show();
							$(".validation").html(response);
							$(".save:input").attr('disabled', false);
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
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/edit",
					data: {
						'location_id': $("#location_id").val(),
						'location_code': $("#location_code_edit").val(),
						'location_name': $("#location_name_edit").val(),
						'company_id': $("#company_edit").val(),
						'address': $("#address_edit").val(),
						'city': $("#city_edit").val(),
						'state': $("#state_edit").val(),
						'country_id': $("#country_edit").val(),
						'time_zone': $("#time_zone_edit").val(),
						'primary_telephone_number': $("#primary_phone_edit").val(),
						'secondary_telephone_number': $("#secondary_phone_edit").val(),
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
						getTableData();
					}
					else {
						$(".msg_data").hide();
						$(".validation").show();
						$(".validation").html(response);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},

		deleteData: function (id) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Locations Details') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/delete",
					data: {'id': id,
						<?php echo $this->security->get_csrf_token_name(); ?>:
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
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
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/get",
				data: {
					'id': id,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					success:function (response) {
					$(".form").show();
					$(".save_form").hide();
					$(".edit_form").show();
					$(".edit_form").html(response);
					$("#primary_phone_edit").intlTelInput();
					$("#secondary_phone_edit").intlTelInput();
					$(".loader").hide();
				}
			})
		},

		init : function () {
			$("#table").show();
			$(".form").hide();
			$(".edit_form").hide();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		},

		getCompanyList: function(){
				$.ajax({
					type:"POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller/getAllToCompanyDropDown",
					data: {
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					dataType: 'html',
					success: function(companyList) {
						$("#company_dropdown").html(
								"<div class='form-group'>"+
									"<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Company') ?> </label>"+
									"<div class='col-sm-4 controls'>"+companyList+"</div>"+
								"</div>");
					}
				});
			},

		getCountryList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getCountryDropDown",
				data: {
					'label_col_position' : '3',
					'drop_down_col_position' : '4',
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(countryList) {
					$("#country_dropdown").html(countryList);
				}
			});
		}

	};//end location object

	function validateForm_save() {
		return (isNotEmpty("location_code", "<?php echo $this->lang->line('Location Code').' '.$this->lang->line('field is required')?>")
			&&  isNotEmpty("location_name", "<?php echo $this->lang->line('Location Name').' '.$this->lang->line('field is required')?>")
		);
	}

	function validateForm_edit() {
		return (isNotEmpty("location_code_edit", "<?php echo $this->lang->line('Location Code').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("location_name_edit", "<?php echo $this->lang->line('Location Name').' '.$this->lang->line('field is required')?>")
		);
	}

	//get all data
	function getTableData(){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getTableData",
			data: {
		<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
		},
		dataType: 'html',
			success:
		function (response) {
			$("#dataTable").html(response);
			$(".loader").hide();
			$('.table').DataTable();
		}
		})
	}

	function clearForm(){
		$("#location_code").val('');
		$("#location_name").val('');
		$("#company").val('');
		$("#address").val('');
		$("#city").val('');
		$("#state").val('');
		$("#country").val('')
		$("#time_zone").val('');
		$("#primary_phone").val('');
		$("#secondary_phone").val('');
	}

</script>
