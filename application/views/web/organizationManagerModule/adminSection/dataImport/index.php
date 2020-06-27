<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<br>
				</div>

				<div class='row'>
					<div class='col-sm-12'>
						<div class='box'>
							<div class='box-header <?php echo BOXHEADER; ?>-background'>
								<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Data Import') ?></div>
								<div class='actions'>
									<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
									</a>
								</div>
							</div>

							<div class='box-content'>
								<div class='msg_data'></div>
								<?php
								if (isset ($message)) echo $message;
								echo validation_errors('<div class="alert alert-danger alert-dismissable">
												  <a class="close" data-dismiss="alert" href="#">&times;</a><h4>
													<i class="icon-remove-sign"></i>
													Error
												  </h4>', '</div>');
								?>
								<?php echo form_open('organizationManagerModule/adminSection/data_import_controller/handleDataImport', array('class' => 'form form-horizontal validate-form','id' => 'dataImportForm', 'style' => 'margin-bottom: 0;', 'enctype' => 'multipart/form-data')) ?>
								<!--<form class='form form-horizontal validate-form save_form' action='data_import_controller/handleDataImport'>-->
									<div class="box-header">
										<div class='title'><?php echo $this->lang->line('Download Organization Master Data Import Excel Workbook') ?></div>
									</div>
									<div class='box-content'>
										<div class='form-group'>
											<div class='col-sm-2 col-sm-offset-1'>
												<button class='btn btn-success' type='submit' id="download" name='data_import' value='download_people_data_template' <?php echo $menuFormatting; ?>>
													<i class='icon-save'></i>
													<?php echo $this->lang->line('Download') ?>
												</button>
											</div>
											<div class='col-sm-3 col-sm-offset-1'>
												<button class='btn btn-success' type='submit' id="download" name='data_import' value='download_user_guide' <?php echo $menuFormatting; ?>>
													<i class='icon-save'></i>
													<?php echo $this->lang->line('Download Data Import Workbook User Guide') ?>
												</button>
											</div>
										</div>  
									</div>   
									<div class="box-header">
										<div class='title'><?php echo $this->lang->line('Upload Organization Master Data Import Excel Workbook') ?></div>
									</div>

									<div class='box-content'>
										<div class='form-group'>
											<div class='col-sm-3 col-sm-offset-1'>
												<input type="file" name="file_to_upload" id="file_to_upload">
											</div>
											<div class='col-sm-2 controls'>
												<?php
													if (isset($OGM_Admin_Add_Data_Import_Permissions)){
													?>
													<button class='btn btn-success' type='submit' id="upload" name='data_import' value='upload' <?php echo $menuFormatting; ?>>
														<i class='icon-save'></i>
														<?php echo $this->lang->line('Upload') ?>
													</button>
													<?php
												}
												?>
											</div>
											<div class='col-sm-3 controls'>
												<button class='btn btn-success' type='submit' id="download_data_validation_error_file" name='data_import' value='download_data_validation_error_file' <?php echo $menuFormatting; ?>>
													<i class='icon-save'></i>
													<?php echo $this->lang->line('Download Data Import Workbook Error Log File') ?>
												</button>
											</div>
										</div>  
									</div>

									<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

									<div class="box-header">
										<div class='title'><?php echo $this->lang->line('Import Data') ?></div>
									</div>
									<div class='box-content'>
										<div class='form-group'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6'><?php echo $this->lang->line('Import Supplier Information') ?> </label>
												<div class='col-sm-6 controls'>
													<div class="switch1 switch1-blue">
														<input type="radio" class="switch1-input" name="supplier_info" value="supplier_info" id="supplier_info_yes">
														<label for="supplier_info_yes" class="switch1-label switch1-label-off">Yes</label>
														<input type="radio" class="switch1-input" name="supplier_info" value="0" id="supplier_info_no" checked>
														<label for="supplier_info" class="switch1-label switch1-label-on">No</label>
														<span class="switch1-selection"></span>
													</div>
												</div>
											</div>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6'><?php echo $this->lang->line('Import Agent Information') ?> </label>
												<div class='col-sm-6 controls'>
													<div class="switch1 switch1-blue">
														<input type="radio" class="switch1-input" name="agent_info" value="agent_info" id="agent_info_yes">
														<label for="agent_info_yes" class="switch1-label switch1-label-off">Yes</label>
														<input type="radio" class="switch1-input" name="agent_info" value="0" id="agent_info_no" checked>
														<label for="agent_info" class="switch1-label switch1-label-on">No</label>
														<span class="switch1-selection"></span>
													</div>
												</div>
											</div>
										</div>
										<div class='form-group'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6'><?php echo $this->lang->line('Import Customer Information') ?> </label>
												<div class='col-sm-6 controls'>
													<div class="switch1 switch1-blue">
														<input type="radio" class="switch1-input" name="customer_info" value="customer_info" id="customer_info_yes">
														<label for="customer_info_yes" class="switch1-label switch1-label-off">Yes</label>
														<input type="radio" class="switch1-input" name="customer_info" value="0" id="customer_info_no" checked>
														<label for="customer_info" class="switch1-label switch1-label-on">No</label>
														<span class="switch1-selection"></span>
													</div>
												</div>
											</div>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6'><?php echo $this->lang->line('Import Sales Rep Information') ?> </label>
												<div class='col-sm-6 controls'>
													<div class="switch1 switch1-blue">
														<input type="radio" class="switch1-input" name="sales_rep_info" value="sales_rep_info" id="sales_rep_info_yes">
														<label for="sales_rep_info_yes" class="switch1-label switch1-label-off">Yes</label>
														<input type="radio" class="switch1-input" name="sales_rep_info" value="0" id="sales_rep_info_no" checked>
														<label for="sales_rep_info" class="switch1-label switch1-label-on">No</label>
														<span class="switch1-selection"></span>
													</div>
												</div>
											</div>
										</div>
										<div class='form-group'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6'><?php echo $this->lang->line('Import Driver Information') ?> </label>
												<div class='col-sm-6 controls'>
													<div class="switch1 switch1-blue">
														<input type="radio" class="switch1-input" name="driver_info" value="driver_info" id="driver_info_yes">
														<label for="driver_info_yes" class="switch1-label switch1-label-off">Yes</label>
														<input type="radio" class="switch1-input" name="driver_info" value="0" id="driver_info_no" checked>
														<label for="driver_info" class="switch1-label switch1-label-on">No</label>
														<span class="switch1-selection"></span>
													</div>
												</div>
											</div>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6'><?php echo $this->lang->line('Import Employee Information') ?> </label>
												<div class='col-sm-6 controls'>
													<div class="switch1 switch1-blue">
														<input type="radio" class="switch1-input" name="employee_info" value="employee_info" id="employee_info_yes">
														<label for="employee_info_yes" class="switch1-label switch1-label-off">Yes</label>
														<input type="radio" class="switch1-input" name="employee_info" value="0" id="employee_info_no" checked>
														<label for="employee_info" class="switch1-label switch1-label-on">No</label>
														<span class="switch1-selection"></span>
													</div>
												</div>
											</div>
										</div>
										<div class='form-group'>
											<div class='col-sm-6 controls'>
												<label class='control-label col-sm-6'> </label>
												<div class='col-sm-6 controls'>
													<?php
														if (isset($OGM_Admin_Add_Data_Import_Permissions)){
														?>
														<button class='btn btn-success' type='submit' id="import"  name='data_import' value='import' <?php echo $menuFormatting; ?>>
															<i class='icon-save'></i>
															<?php echo $this->lang->line('Import') ?>
														</button>
														<?php
													}
													?>
												</div>
											</div>
											<div class='col-sm-6 controls'>
												<div class='col-sm-4 controls'>
													<button class='btn btn-success' type='submit' id="download_data_import_error_file" name='data_import' value='download_data_import_error_file' <?php echo $menuFormatting; ?>>
														<i class='icon-save'></i>
														<?php echo $this->lang->line('Download Data Import Error Log File') ?>
													</button>
												</div>
											</div>
										</div>
									</div>
								<!--</form>-->
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
		$(".loader").hide();
		var submitButton;

		$('button[type="submit"]').click(function(e){
			submitButton = $(this).val();
		 });

		$("#dataImportForm").submit(function(e){

			if (submitButton === 'import') {
				if(!checkImportOptions()) {
					e.preventDefault(e);
				}
			}
		});
	});

	$("#upload").click(function () {
		$(".loader").show();
	});

	$("#import").click(function () {
		$(".loader").show();
	});

	function checkImportOptions() {
		var selectedImportOptions  = new Array();
		var selectedOption = '';

		selectedOption = $('input[name=supplier_info]:checked').val();
		if(selectedOption != 0) {
			selectedImportOptions.push(selectedOption);
		}
		
		selectedOption = $('input[name=agent_info]:checked').val();
		if(selectedOption != 0) {
			selectedImportOptions.push(selectedOption);
		}
		
		selectedOption = $('input[name=customer_info]:checked').val();
		if(selectedOption != 0) {
			selectedImportOptions.push(selectedOption);
		}
		
		selectedOption = $('input[name=sales_rep_info]:checked').val();
		if(selectedOption != 0) {
			selectedImportOptions.push(selectedOption);
		}
		
		selectedOption = $('input[name=driver_info]:checked').val();
		if(selectedOption != 0) {
			selectedImportOptions.push(selectedOption);
		}
		
		selectedOption = $('input[name=employee_info]:checked').val();
		if(selectedOption != 0) {
			selectedImportOptions.push(selectedOption);
		}

		if (selectedImportOptions.length === 0) {
			var msg='<div class="alert alert-danger alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-remove-sign"></i>'+
				'<?php echo $this->lang->line('error') ?></h4>'+
				'<?php echo $this->lang->line('Select a data import option to proceed') ?>'+
				'</div>';

			$(".msg_data").show();
			$(".msg_data").html(msg);
			$(".loader").hide();
			return false;
		} else if (selectedImportOptions.length > 1) {
			var msg='<div class="alert alert-danger alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-remove-sign"></i>'+
				'<?php echo $this->lang->line('error') ?></h4>'+
				'<?php echo $this->lang->line('Select only one import option') ?>'+
				'</div>';

			$(".msg_data").show();
			$(".msg_data").html(msg);
			return false;
		} else {
			return true;
		}
	}

</script>