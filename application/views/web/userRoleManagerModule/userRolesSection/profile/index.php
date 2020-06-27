<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Change Password') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background'>
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Change Password') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<?php
									if($this->session->flashdata('flashSuccess')){
										echo '<div class="alert alert-success fade in"><a class="close" title="close" aria-label="close" data-dismiss="alert" href="#">×</a>';
										echo $this->session->flashdata('flashSuccess');
										echo '<br></div>';
									}
									if ($this->session->flashdata('flashError')) {
										echo '<div class="alert alert-danger fade in"><a class="close" title="close" aria-label="close" data-dismiss="alert" href="#">×</a>';
										echo $this->session->flashdata('flashError');
										echo '<br></div>';
									}
									?>
									<?php echo form_open('userRoleManagerModule/userRolesSection/profile_controller/changePassword', array('class' => 'form form-horizontal validate-form','id' => 'changePasswordForm', 'style' => 'margin-bottom: 0;')) ?>
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Current Password') ?> *</label>

											<div class='col-sm-4 controls'>
												<input class='form-control'  id='current_password'
													   name='current_password' placeholder='<?php echo $this->lang->line('Current Password') ?>' type='password' value="<?php echo set_value('current_password'); ?>">
												<div id="current_passwordError" class="red"><?php echo form_error('current_password'); ?></div>
											</div>
										</div>
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('New Password') ?> *</label>

											<div class='col-sm-4 controls'>
												<input class='form-control'  id='new_password'
													   name='new_password' placeholder='<?php echo $this->lang->line('New Password') ?>' type='password' value="<?php echo set_value('new_password'); ?>">
												<div id="new_passwordError" class="red"><?php echo form_error('new_password'); ?></div>
											</div>
										</div>
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Confirm Password') ?> *</label>

											<div class='col-sm-4 controls'>
												<input class='form-control'  id='confirm_password'
													   name='confirm_password' placeholder='<?php echo $this->lang->line('Confirm Password') ?>' type='password' value="<?php echo set_value('confirm_password'); ?>">
												<div id="confirm_passwordError" class="red"><?php echo form_error('confirm_password'); ?></div>
											</div>
										</div>

										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<button class='btn btn-success save' type='submit' id="save_submit" <?php echo $menuFormatting; ?>>
														<i class='icon-save'></i>
														<?php echo $this->lang->line('Save') ?>
													</button>


													<button class='btn btn-primary' type='reset' <?php echo $menuFormatting; ?>>
														<i class='icon-undo'></i>
														<?php echo $this->lang->line('Refresh') ?>
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
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>
	$("#save_submit").click(function () {
		if ($("#current_password").val() == ''){
			validateForm();
			return false;
		} else if ($("#new_password").val() == ''){
			validateForm();
			return false;
		} else if ($("#confirm_password").val() == ''){
			validateForm();
			return false;
		} else {
			return true;
		}
	});

	//form validation
	function validateForm() {
		return (isNotEmpty("current_password", "<?php echo $this->lang->line('current_password')?>")
			&& isLengthMinMax("new_password", "<?php echo $this->lang->line('new_password_length')?>","6","12")
			&& isNotEmpty("confirm_password", "<?php echo $this->lang->line('confirm_password')?>")
		);
	}
</script>
