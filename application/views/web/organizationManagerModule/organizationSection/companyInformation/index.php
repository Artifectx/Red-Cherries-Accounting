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
					<br>
				</div>
                
				<div class='row'>
					<div class='col-sm-12'>
						<div class='box'>
							<div class='box-header <?php echo BOXHEADER; ?>-background'>
								<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Company Information') ?></div>
								<div class='actions'>
									<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
									</a>
								</div>
							</div>
                            
							<div class='box-content'>
								<?php
								if (isset ($massage)) echo $massage;
								echo validation_errors('<div class="alert alert-danger alert-dismissable">
												  <a class="close" data-dismiss="alert" href="#">&times;</a><h4>
													<i class="icon-remove-sign"></i>
													Error
												  </h4>', '</div>');
								?>
								<?php echo form_open('organizationManagerModule/organizationSection/company_information_controller/editCompany', array('class' => 'form form-horizontal validate-form','id' => 'contactForm', 'style' => 'margin-bottom: 0;')) ?>
								<!--<form class='form form-horizontal validate-form'>-->
								<div class='form-group'>
									<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Company Name') ?> *</label>

									<div class='col-sm-4 controls'>
										<input class='form-control'
											   id='company_name' name='company_name'
											   placeholder='<?php echo $this->lang->line('Company Name') ?>'
											   type='text' value="<?php echo $company_info['company_name']; ?>">
										<div id="company_nameError" class="red"></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Company Short Name') ?></label>

									<div class='col-sm-4 controls'>
										<input class='form-control'
											   id='company_name' name='company_short_name'
											   placeholder='<?php echo $this->lang->line('Company Short Name') ?>'
											   type='text' value="<?php echo $company_info['company_short_name']; ?>">
										<div id="company_short_nameError" class="red"></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'><?php echo $this->lang->line('E-mail') ?> *</label>

									<div class='col-sm-4 controls'>
										<input class='form-control'
											   id='email' name='email'
											   placeholder='<?php echo $this->lang->line('E-mail') ?>' type='text'
											   value="<?php echo $company_info['email']; ?>">
										<div id="emailError" class="red"></div>
									</div>
								</div>
								<div class='form-group'>
									<div class='control-label col-sm-3'>
										<label><?php echo $this->lang->line('Web') ?> </label>
										<small class='help-block'>http://</small>
									</div>
									<div class='col-sm-4 controls'>
										<input class='form-control' data-rule-url="true"
											   id='web' name='web' placeholder='<?php echo $this->lang->line('Web') ?>'
											   type='text'
											   value="<?php echo $company_info['web']; ?>">
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'><?php echo $this->lang->line('Primary Phone Number') ?> *</label>

									<div class='col-sm-4 controls'>
										<input class='form-control'
											   id='primary_telephone_number' name='primary_telephone_number'
											   placeholder='<?php echo $this->lang->line('Primary Phone Number') ?>'
											   type='tel'
											   value="<?php echo $company_info['primary_telephone_number']; ?>">
										<div id="primary_telephone_numberError" class="red"></div>

										<!--<input class="form-control" data-rule-phoneus="true" data-rule-required="true" id="validation_phone" name="vadation_phone_number" placeholder="US phone number" type="text">
										<span for="validation_phone" class="help-block has-error">This field is required.</span>-->
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'><?php echo $this->lang->line('Secondary Phone Number') ?></label>

									<div class='col-sm-4 controls'>
										<input class='form-control'
											   id='secondary_telephone_number' name='secondary_telephone_number'
											   placeholder='<?php echo $this->lang->line('Secondary Phone Number') ?>'
											   type='text'
											   value="<?php echo $company_info['secondary_telephone_number']; ?>">
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'><?php echo $this->lang->line('Fax') ?></label>

									<div class='col-sm-4 controls'>
										<input class='form-control'
											   id='fax' name='fax' placeholder='<?php echo $this->lang->line('Fax') ?>'
											   type='text'
											   value="<?php echo $company_info['fax']; ?>">
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'><?php echo $this->lang->line('Address') ?> *</label>

									<div class='col-sm-4 controls'>
										<input class='form-control' id='address'
											   name='address' placeholder='<?php echo $this->lang->line('Address') ?>'
											   type='text'
											   value="<?php echo $company_info['address']; ?>">
										<div id="addressError" class="red"></div>
									</div>
								</div>
								<div class='form-group'>
									<label class='control-label col-sm-3'><?php echo $this->lang->line('Short Address') ?></label>

									<div class='col-sm-4 controls'>
										<input class='form-control' id='short_address'
											   name='short_address' placeholder='<?php echo $this->lang->line('Short Address') ?>'
											   type='text'
											   value="<?php echo $company_info['short_address']; ?>">
										<div id="short_addressError" class="red"></div>
									</div>
								</div>

								<div class='form-actions' style='margin-bottom:0'>
									<div class='row'>
										<div class='col-sm-9 col-sm-offset-3'>

											<?php
											if (isset($OGM_Organization_Edit_Company_Information_Permissions)){
												?>
												<button class='btn btn-success' type='submit' id="save_submit" <?php echo $menuFormatting; ?>>
													<i class='icon-save'></i>
													<?php echo $this->lang->line('Save') ?>
												</button>
												<?php
											}
											?>
											<button class='btn btn-primary' type='reset' <?php echo $menuFormatting; ?>>
												<i class=' icon-undo'></i>
												<?php echo $this->lang->line('Refresh') ?>
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
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>
<script>
	$(document).ready(function() {
		$("#primary_telephone_number").intlTelInput();
		$("#secondary_telephone_number").intlTelInput();
		$("#fax").intlTelInput();
	});
    
	$("#save_submit").click(function () {
	   
        if ($("#company_name").val() == ''){
			validateForm();
			return false;
		} else if ($("#email").val() == ''){
			validateForm();
			return false;
		} else if ($("#primary_telephone_number").val() == ''){
			validateForm();
			return false;
		} else if ($("#address").val() == ''){
			validateForm();
			return false;
		} else {
			return true;
		}
	});

	//form validation
	function validateForm() {
		return (isNotEmpty("company_name", "<?php echo $this->lang->line('company_name')?>")
            && isValidEmail("email", "<?php echo $this->lang->line('email')?>")
            && isNotEmpty("primary_telephone_number", "<?php echo $this->lang->line('primary_telephone_number')?>")
            && isNotEmpty("address", "<?php echo $this->lang->line('company_address')?>")
		);
	}
</script>