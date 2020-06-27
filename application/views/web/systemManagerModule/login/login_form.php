
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
								<img width="233" height="233" src="<?php echo base_url(); ?>assets/images/logo_login.png"/>
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
									<?php //echo $this->lang->line('New to xStock')?>
									<strong>Red Cherries Accounting Version <?php echo $version_no ?><br>Copyright &copy; 2020 Red Cherries Accounting By Artifectx<?php //echo $this->lang->line('Sign up')?></strong>
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
							<h6><?php echo $this->lang->line('Enter the Email Address associated with your account and click "Submit" to receive a password.') ?></h6>
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

			<!--Sign Up popup-->
			<div id="sign_up" class="modal fade" aria-hidden="true" data-keyboard="true" data-backdrop="static" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 align="center"><?php echo $this->lang->line('Red Cherries Accounting Request Quote & Free Account Sign Up') ?></h4>
						</div>
						<div class="modal-body">
							<div class='col-sm-12'>
								<div class='box-content'>
									<div class='msg_data'></div>
									<div class='validation'></div>
									<form class='form form-horizontal validate-form save_form'>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('First Name') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='first_name' name='first_name'
													   placeholder='<?php echo $this->lang->line('First Name') ?>'
													   type='text' value="<?php echo set_value('first_name'); ?>">
												<div id="first_nameError" class="red"></div>
											</div>
										</div>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('Last Name') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='last_name' name='last_name'
													   placeholder='<?php echo $this->lang->line('Last Name') ?>'
													   type='text' value="<?php echo set_value('last_name'); ?>">
												<div id="last_nameError" class="red"></div>
											</div>
										</div>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('Comapany Name') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='comapany_name' name='comapany_name'
													   placeholder='<?php echo $this->lang->line('Comapany Name') ?>'
													   type='text' value="<?php echo set_value('comapany_name'); ?>">
												<div id="comapany_nameError" class="red"></div>
											</div>
										</div>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('Job Title') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='job_title' name='job_title'
													   placeholder='<?php echo $this->lang->line('Job Title') ?>'
													   type='text' value="<?php echo set_value('job_title'); ?>">
												<div id="job_titleError" class="red"></div>
											</div>
										</div>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('Contact Email') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='contact_email' name='contact_email'
													   placeholder='<?php echo $this->lang->line('Contact Email') ?>'
													   type='text' value="<?php echo set_value('contact_email'); ?>">
												<div id="contact_emailError" class="red"></div>
											</div>
										</div>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('Contact Phone') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='contact_phone' name='contact_phone'
													   placeholder='<?php echo $this->lang->line('Contact Phone') ?>'
													   type='text' value="<?php echo set_value('contact_phone'); ?>">
												<div id="contact_phoneError" class="red"></div>
											</div>
										</div>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('Country') ?> *</label>
											<div class='col-sm-6 controls'>
												<select name="country" id="country" class="form-control">
													<option value=''> <?php echo $this->lang->line('-- Select Country --') ?></option>
													<?php
													if ($country != null) {
														foreach($country as $raw){
																?>
																<option
																	value="<?php echo $raw->country_name; ?>"<?php echo set_select('country', $raw->country_name, FALSE) ?>><?php echo $raw->country_name; ?></option>
																<?php
														}
													}
													?>
												</select>
												<div id="countryError" class="red"></div>
											</div>
										</div>
										<div class='form-group'>
											<label
												class='control-label col-sm-4'><?php echo $this->lang->line('No of Employees') ?> *</label>
											<div class='col-sm-6 controls'>
												<input class='form-control' id='no_of_employees' name='no_of_employees'
													   placeholder='<?php echo $this->lang->line('No of Employees') ?>'
													   type='text' value="<?php echo set_value('no_of_employees'); ?>">
												<div id="no_of_employeesError" class="red"></div>
											</div>
										</div>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<button class='btn btn-success save' onclick='signUp();'
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
							<strong>For more info contact : </strong><br>
							Sam   : +94-77-9738068<br>
							Mike  : +94-77-9089655<br>
							web   : www.artifectx.com <br>
							Email : info@artifectx.com
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
		/*var delay=2500;
		setTimeout(function() {
			$("#sign_up").modal('show');
		}, delay);*/

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

	function signUp(){
		if($("#first_name").val() == '')validateFormSignUp();
		else if ($("#last_name").val() == '')validateFormSignUp();
		else if ($("#comapany_name").val() == '')validateFormSignUp();
		else if ($("#job_title").val() == '')validateFormSignUp();
		else if ($("#contact_email").val() == '')validateFormSignUp();
		else if ($("#contact_phone").val() == '')validateFormSignUp();
		else if ($("#country").val() == '')validateFormSignUp();
		else if ($("#no_of_employees").val() == '')validateFormSignUp();
		else {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_submit')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>login/signUp",
				data: {
					'first_name': $("#first_name").val(),
					'last_name': $("#last_name").val(),
					'comapany_name': $("#comapany_name").val(),
					'job_title': $("#job_title").val(),
					'contact_email': $("#contact_email").val(),
					'contact_phone': $("#contact_phone").val(),
					'country': $("#country").val(),
					'no_of_employees': $("#no_of_employees").val(),
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
						clearForm();
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

	//form sign up validation
	function validateFormSignUp() {
		return (isNotEmpty("first_name", "<?php echo $this->lang->line('first_name').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("last_name", "<?php echo $this->lang->line('last_name').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("comapany_name", "<?php echo $this->lang->line('comapany_name').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("job_title", "<?php echo $this->lang->line('job_title').' '.$this->lang->line('field is required')?>")
			&& isValidEmail("contact_email", "<?php echo $this->lang->line('contact_email').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("contact_phone", "<?php echo $this->lang->line('contact_phone').' '.$this->lang->line('field is required')?>")
			&& isSelected("country", "<?php echo $this->lang->line('country').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("no_of_employees", "<?php echo $this->lang->line('no_of_employees').' '.$this->lang->line('field is required')?>")
		);
	}

	function clearForm(){
		$("#first_name").val('');
		$("#last_name").val('');
		$("#comapany_name").val('');
		$("#job_title").val('');
		$("#contact_email").val('');
		$("#contact_phone").val('');
		$("#country").val('');
		$("#no_of_employees").val('');
	}
</script>


