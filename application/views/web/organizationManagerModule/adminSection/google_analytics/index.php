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
							<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Google Analytics Settings') ?></div>
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
							<?php echo form_open('organizationManagerModule/adminSection/google_analytics_controller/editGoogleAnalytics', array('class' => 'form form-horizontal validate-form','id' => 'contactForm', 'style' => 'margin-bottom: 0;')) ?>
							<div class='form-group'>
								<label
									class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Google Analytics Code') ?> *
									</label>

								<div class='col-sm-4 controls'>
									<input class='form-control' id='analytic_code'
										   name='analytic_code' placeholder='<?php echo $this->lang->line('Google Analytics Code') ?>' type='text'
										   value="<?php echo $google_analytic['analytic_code']; ?>">
									<div id="analytic_codeError" class="red"></div>
								</div>
							</div>
							<div class='form-group'>
								<label
									class='control-label col-sm-3'><?php echo $this->lang->line('Enable in Login') ?>
									</label>
								<div class='col-sm-4 controls'>
									<?php
									if($google_analytic['enable_in_login'] == '1') {
										echo "<input class='form-control1' id='enable_in_login' name='enable_in_login' type='checkbox' checked>";
									} else {
										echo "<input class='form-control1' id='enable_in_login' name='enable_in_login' type='checkbox'>";
									}
									?>
									<div id="enable_in_loginError" class="red"></div>
								</div>
							</div>
							<div class='form-group'>
								<label
									class='control-label col-sm-3'><?php echo $this->lang->line('Enable in Dashboard') ?>
								</label>
								<div class='col-sm-4 controls'>
									<?php
									if($google_analytic['enable_in_dashboard'] == '1') {
										echo "<input class='form-control1' id='enable_in_dashboard' name='enable_in_dashboard' type='checkbox' checked>";
									} else {
										echo "<input class='form-control1' id='enable_in_dashboard' name='enable_in_dashboard' type='checkbox'>";
									}
									?>
									<div id="enable_in_dashboardError" class="red"></div>
								</div>
							</div>

							<div class='form-actions' style='margin-bottom:0'>
								<div class='row'>
									<div class='col-sm-9 col-sm-offset-3'>

										<?php
										if (isset($OGM_Admin_Edit_Google_Analytics_Permissions)){
											?>
											<button class='btn btn-success' type='submit' id="save_submit" onclick="save_submit();" <?php echo $menuFormatting; ?>>
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
	$("#save_submit").click(function () {
		// alert($("#daterange2_val").val());
		if (validateForm()){
			return true;
		} else {
			return false;
		}
	});

	//form validation
	function validateForm() {
		return (isNotEmpty("analytic_code", "<?php echo $this->lang->line('Google Analytics Code').' '.$this->lang->line('field is required')?>")
		);
	}
</script>