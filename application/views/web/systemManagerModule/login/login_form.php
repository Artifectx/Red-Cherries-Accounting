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

<body class='contrast-red login contrast-background'>
<div class='middle-container'>
	<div class='middle-row'>
		<div class='middle-wrapper'>
			<div class='login-container-header'>
				<div class='container'>
					<div class='row'>
						<p>&nbsp;</p>
						<div class='col-sm-12'>
							<div class='text-center'>
								<img width="320" height="230" src="<?php echo base_url(); ?>assets/images/logo_login.png"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='login-container'>
				<div class='container'>
					<div class='row'>
						<div class='col-sm-4 col-sm-offset-4'>
							<h1 class='text-center title'><?php echo $this->lang->line('Sign In'); ?></h1>
							<!--<form name="login_form" id="login_form" >-->
							<?php echo form_open('login', array('class' => 'validate-form')) ?>
							<div class="form-group">
								<div class='controls with-icon-over-input'>
									<h2><?php echo validation_errors('<div class="red">', '</div>'); ?></h2>
									<!--<div class="loading"><img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif"> Login...</div>-->
								</div>
							</div>
							<div class='form-group'>
								<div class='controls with-icon-over-input'>
									<input placeholder="<?php echo $this->lang->line('Username')?>" class="form-control"
										   type="text" name="username" id="username"
										   value="<?php echo set_value('username'); ?>"/>
									<i class='icon-user text-muted'></i>
									<div id="usernameError" class="red"></div>
								</div>
							</div>
							<div class='form-group'>
								<div class='controls with-icon-over-input'>
									<input value="" placeholder="<?php echo $this->lang->line('Password')?>" class="form-control"
											type="password" name="password" id="password"
										   value="<?php echo set_value('password'); ?>"/>
									<i class='icon-lock text-muted'></i>
									<div id="passwordError" class="red"></div>
								</div>
							</div>
							<button type="submit" class='btn btn-block' id="login"><?php echo $this->lang->line('Login')?></button>
							</form>
							<div class='text-center'>
								<hr class='hr-normal'>
								<a href='#forgot_password' role="button" data-toggle="modal"><?php echo $this->lang->line('Forgot your password?')?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='login-container-footer'>
				<div class='container'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='text-center'>
								<a href='#' role="button" data-toggle="modal">
									<i class='icon-user1'></i>
									<strong>Red Cherries Accounting Version <?php echo $version_no ?><br>Copyright &copy; 2021 Red Cherries Accounting By Artifectx<?php //echo $this->lang->line('Sign up')?></strong>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Forgot password popup -->
			<div id="forgot_password" class="modal fade" aria-hidden="true" data-keyboard="true" data-backdrop="static" >
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 align="center"><?php echo $this->lang->line('Forgot your password?') ?></h4>
							<h6><?php echo $this->lang->line('Enter the Email Address associated with your account and click Submit to receive a password.') ?></h6>
						</div>
						<div class="modal-body">
							<div class='col-sm-12'>
								<div class='box-content'>
									<div class='msg_data'></div>
									<div class='validation'></div>
									<form class='form form-horizontal validate-form save_form'>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('E-mail') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='email' name='email'
													   placeholder='<?php echo $this->lang->line('E-mail') ?>'
													   type='text' value="<?php echo set_value('email'); ?>">
												<div id="emailError" class="red"></div>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-12 col-sm-offset-4'>
												<button class='btn btn-success save' onclick='forgotPassword();'
														type='button'>
													<i class='icon-save'></i>
													<?php echo $this->lang->line('Submit') ?>
												</button>
												<button class='btn btn-warning cancel'
												type='button' aria-hidden='true' data-dismiss='modal'>
												<i class='icon-ban-circle'></i>
												<?php echo $this->lang->line('Close') ?>
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal-footer">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>
<script src="<?php echo base_url();?>assets/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>

<script>
	$(document).ready(function () {

		$(".msg_data").hide();
		$(".validation").hide();
	});

	$("#login").click(function () {
		if ($("#username").val() == ''){
			validateForm();
			return false;
		}
		else if ($("#password").val() == ''){
			validateForm();
			return false;
		}
		else {
			setSystemModulesHeaderTitle();
			return true;
		}
	});

	function forgotPassword(){
		if($("#email").val() == '')validateFormForgotPassword();
		else{
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_submit')?> to ' + $("#email").val()
				'</div>';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>login/resetPassword",
				data: {
					'email': $("#email").val(),
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (responce) {
					if (responce == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						$("#email").val('');
					}
					else {
						$(".msg_data").hide();
						$(".validation").show();
						$(".validation").html(responce);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		}
	}

	function setSystemModulesHeaderTitle() {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>login/setSystemModulesHeaderTitle",
			data: {
				'user_name' : $("#username").val(),
				'systemModule' : '',
				'systemModuleUrl' : '',
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
			success:function (response) {
			}
		});
	}

	function validateFormForgotPassword(){
		return (isNotEmpty("email", "<?php echo $this->lang->line('email').' '.$this->lang->line('field is required')?>")
			&& isValidEmail("email", "<?php echo $this->lang->line('valid email').' '.$this->lang->line('field is required')?>")
		);
	}
	//form validation
	function validateForm() {
		return (isNotEmpty("username", "<?php echo $this->lang->line('error_user').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("password", "<?php echo $this->lang->line('error_password').' '.$this->lang->line('field is required')?>")
		);
	}
</script>


