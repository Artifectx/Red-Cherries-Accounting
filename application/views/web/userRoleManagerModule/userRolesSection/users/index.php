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
							<span><?php echo $this->lang->line('User Details') ?></span>
						</h1>

						<div class='pull-right'></div>
					</div>
				</div>
			</div>

			<!--Showing messages-->
			<div class='msg_data'></div>
            <div class='msg_instant' align="center"></div>
			<div class='form'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='box'>
							<div class='box-header <?php echo BOXHEADER; ?>-background'>
								<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('User Details') ?></div>
								<div class='actions'>
									<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
									</a>
								</div>
							</div>
							<div class='box-content'>
								<div class='validation'></div>
								<form class='form form-horizontal validate-form save_form'>
									<div class='form-group'>
										<label class='control-label col-sm-3'><?php echo $this->lang->line('Employee') ?> *</label>
										<div class='col-sm-4 controls'>
											<select id="employee_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<!--employee drop down-->
											<div id="employee_dropdown">
											</div>
											<!--End employee drop down-->
											<div id="people_idError" class="red"></div>
										</div>
									</div>

									<div class='form-group'>
										<label class='control-label col-sm-3'><?php echo $this->lang->line('User Name') ?> *</label>

										<div class='col-sm-4 controls'>
											<input class='form-control'  id='user_name'
												   name='user_name' placeholder='<?php echo $this->lang->line('User Name') ?>' type='text' value="<?php echo set_value('user_name'); ?>">
											<div id="user_nameError" class="red"><?php echo form_error('user_name'); ?></div>
										</div>
									</div>

									<div class='form-group'>
										<label class='control-label col-sm-3'><?php echo $this->lang->line('Password') ?> *</label>

										<div class='col-sm-4 controls'>
											<input class='pwstrength form-control'  id='new_password'
												   name='new_password' placeholder='<?php echo $this->lang->line('Password') ?>' type='password' value="<?php echo set_value('new_password'); ?>">
											<div id="new_passwordError" class="red"><?php echo form_error('new_password'); ?></div>
										</div>
									</div>
									<div class='form-group'>
										<label class='control-label col-sm-3'><?php echo $this->lang->line('Confirm Password') ?> *</label>

										<div class='col-sm-4 controls'>
											<input class='form-control'  id='confirm_password'
												   name='confirm_password' placeholder='<?php echo $this->lang->line('Confirm Password') ?>' type='password' value="<?php echo set_value('confirm_password'); ?>">
											<div id="confirm_passwordError" class="red"><?php echo form_error('confirm_password'); ?></div>
										</div>
									</div>

									<div class='form-group'>
										<label class='control-label col-sm-3'><?php echo $this->lang->line('Default User Roles') ?> </label>
										<div class='col-sm-4 controls'>
											<select name="role_id" id="role_id" class="form-control">
												<option value=''><?php echo $this->lang->line('-- Select --')?></option>
												<?php
												if ($user_roles != null) {
													foreach($user_roles as $raw){
														if($raw->role_id !=1) {
															?>
															<option
																value="<?php echo $raw->role_id; ?>"<?php echo set_select('role_id', $raw->role_id, FALSE) ?>><?php echo $raw->user_role_name; ?></option>
															<?php
														}
													}
												}
												?>
											</select>
											<div id="role_idError" class="red"></div>
										</div>
									</div>

									<div class='form-group'>
										<label class='control-label col-sm-3'><?php echo $this->lang->line('Derive User Roles') ?> </label>
										<div class='col-sm-4 controls'>
											<select name="derive_user_role_id" id="derive_user_role_id" class="form-control">
												<option value=''><?php echo $this->lang->line('-- Select --')?></option>
												<?php
												if ($derive_user_roles != null) {
													foreach($derive_user_roles as $raw){?>
															<option value="<?php echo $raw->derive_user_role_id; ?>"<?php echo set_select('derive_user_role_id', $raw->derive_user_role_id, FALSE) ?>><?php echo $raw->derive_user_role_name; ?></option>
													   <?php
													}
												}
												?>
											</select>
											<div id="derive_user_role_idError" class="red"></div>
										</div>
									</div>

									<div class='form-group'>
										<label class='control-label col-sm-3'><?php echo $this->lang->line('Status') ?> *</label>
										<div class='col-sm-4 controls'>
											<select name="status" id="status" class="form-control">
												<option value='0'><?php echo $this->lang->line('-- Select --')?></option>
												<option value="1"<?php echo set_select('status', $this->lang->line('Active'), FALSE) ?>><?php echo $this->lang->line('Active')?></option>
												<option value="2"<?php echo set_select('status', $this->lang->line('Inactive'), FALSE) ?>><?php echo $this->lang->line('Inactive')?></option>
											</select>
											<div id="statusError" class="red"></div>
										</div>
									</div>
										
									<div class='form-actions' style='margin-bottom:0'>
										<div class='row'>
											<div class='col-sm-9 col-sm-offset-3'>
												<?php
												if (isset($URM_User_Roles_Add_Users_Permissions)){
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

			<div id='table'>
				<div class="msg_delete"></div>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
							<?php
							if (isset($URM_User_Roles_Add_Users_Permissions)){ ?>
								<button class='btn btn-success btn-sm new'
										type='button' <?php echo $menuFormatting; ?>>
									<?php echo $this->lang->line('Add New User') ?>
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
	
	<div class='modal fade' id='modal-prime_entry_book_permissions' tabindex='-1'>
		<div class='modal-dialog' style="height:550px;width:1000px">
			<div class='modal-content'>
				<div class='modal-header'>
					<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
					<h4 class='modal-title' id='modal_title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Prime Entry Book Permissions') ?></h4>
				</div>

				<form enctype="text/plain" accept-charset="utf-8" name="formname" id="prime_entry_book_permissions_form"  method="post" action="">
					<div class='modal-body'>
						<div class='modal_msg_data'></div>
						<div class='col-sm-12'>
							<div class='form-group'>
								<input class='form-control' id='user_id' name='user_id' type='hidden'>
								<label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('Not Accessible Prime Entry Books') ?></label>
								<div class='col-sm-7 controls' id="prime_entry_book_multiple_select">
									<select id="prime_entry_book_multiple_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
									<div id="prime_entry_book_multiple_dropdown"></div>
									<div id="prime_entry_book_idError" class="red"></div>
								</div>
							</div>
						</div>
					</div>
					<p style="margin-bottom:380px">&nbsp;</p>
					<div class='form-actions' style='margin-bottom:0'>
						<div class='row'>
							<div class='col-sm-12 col-sm-offset-9'>
								<button class='btn btn-success save'
										onclick='savePrimeEntryBookAccesiblePermissions();' type='button'>
									<i class='icon-save'></i>
									<?php echo $this->lang->line('Save') ?>
								</button>
								<button class='btn btn-warning cancel' onclick='closePrimeEntryBookAccesiblePermissionsDialog();'
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
	</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>
	
	$(document).ready(function () {
        $(".msg_instant").hide();
		getTableData();
		
		Users.getPrimeEntryBooks();
		Users.init();
	});

	$(".new").click(function () {
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		$(".form").show();
		$(".edit_form").hide();
		Users.getEmployeeData();

	});

	function cancelData() {
		Users.cancelData();
	}

	function saveData() {
		if (validateForm_save()) {
			if($("#new_password").val() != $("#confirm_password").val()) {
				$('#confirm_passwordError').html('<?php echo $this->lang->line('veryfy_password')?>');
			} else {
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
				Users.saveData();
                window.scrollTo(0,0);
			}
		}
	}

	function editData() {
		if (validateForm_edit()) {
			if($("#new_password_edit").val() != $("#confirm_password_edit").val()) {
				$('#confirm_password_editError').html('<?php echo $this->lang->line('veryfy_password')?>');
			} else {
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
				Users.editData();
                window.scrollTo(0,0);
			}
		}
	}

	function get(id){
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Users.getData(id);
	}

	function del(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Users.deleteData(id);
	}
	
	function savePrimeEntryBookAccesiblePermissions() {
		Users.savePrimeEntryBookAccesiblePermissions();
	}

	//start users object
	var Users = {
		cancelData: function () {
			$(".form").hide();
		},

		saveData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller/add",
				data: {
					'people_id': $("#people_id").val(),
					'user_name': $("#user_name").val(),
					'user_password': $("#new_password").val(),
					'confirm_password': $("#confirm_password").val(),
					'role_id': $("#role_id").val(),
					'derive_user_role_id': $("#derive_user_role_id").val(),
					'status':$("#status").val(),
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
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_updated')?>' +
				'</div>';
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller/edit",
				data: {
					'id': $("#id").val(),
					'people_id_old': $("#people_id_hidden").val(),
					'people_id_new': $("#people_id_edit").val(),
					'user_name': $("#user_name_edit").val(),
					'user_password': $("#new_password_edit").val(),
					'confirm_password': $("#confirm_password_edit").val(),
					'role_id': $("#role_id_edit").val(),
					'derive_user_role_id': $("#derive_user_role_id_edit").val(),
					'status':$("#status_edit").val(),
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
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('User Details') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller/delete",
					data: {'id': id,
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
						getTableData();
					}
				})
			}
		},

		getData: function (id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller/get",
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
					$(".loader").hide();
				}
			})
		},
		
		savePrimeEntryBookAccesiblePermissions: function () {
		
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var data = $("#prime_entry_book_id").select2('data');

			// Push each item into an array
			var finalResult = [];
			for( item in $('#prime_entry_book_id').select2('data') ) {
				finalResult.push(data[item].id);
			};

			// Display the result with a comma
			var primeEntryBookIds =  finalResult.join(',');
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller/savePrimeEntryBookAccesiblePermissions",
				data: {
					'user_id': $("#user_id").val(),
					'prime_entry_book_ids' : primeEntryBookIds,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success:function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},
		
		getNotAccessiblePrimeEntryBookIdList : function (userId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller/getNotAccessiblePrimeEntryBookIdList",
				data: {
					'user_id' : userId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$("#prime_entry_book_id").val(response.primeEntryBookIdList).trigger("change");
				}
			})
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
				success:function (response) {
					$('#employee_init').hide();
					$("#employee_dropdown").html(response);
				}
			})
		},
		
		//get prime entry books drop down
		getPrimeEntryBooks: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entries_controller/getAllPrimeEntryBooksToMultipleDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#prime_entry_book_multiple_init').hide();
						$("#prime_entry_book_multiple_dropdown").html(response);
						$("#prime_entry_book_id").select2();
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

	};//end user object

	function validateForm_save() {
		return (isSelected("people_id", "<?php echo $this->lang->line('Employee').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("user_name", "<?php echo $this->lang->line('User Name').' '.$this->lang->line('field is required')?>")
			&& isLengthMinMax("new_password", "<?php echo $this->lang->line('Password').' '.$this->lang->line('field is required')?>","6","20")
			&& verifyPassword("new_password","confirm_password", "<?php echo $this->lang->line('veryfy_password')?>")
			&& isSelected("status", "<?php echo $this->lang->line('Status').' '.$this->lang->line('field is required')?>")
		);
	}

	function validateForm_edit() {
		return (isSelected("people_id_edit", "<?php echo $this->lang->line('Employee').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("user_name_edit", "<?php echo $this->lang->line('User Name').' '.$this->lang->line('field is required')?>")
			&& isLengthMinMax("new_password_edit", "<?php echo $this->lang->line('Password').' '.$this->lang->line('field is required')?>","6","20")
			&& verifyPassword("new_password_edit","confirm_password_edit", "<?php echo $this->lang->line('veryfy_password')?>")
			&& isSelected("status_edit", "<?php echo $this->lang->line('Status').' '.$this->lang->line('field is required')?>")
		);
	}

	//get all data
	function getTableData(){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller/getTableData",
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
	
	function openPrimeEntryBookAccesiblePermissionsDialog(userId) {
		$(".modal_msg_data").hide();
		$("#user_id").val(userId);
		Users.getNotAccessiblePrimeEntryBookIdList(userId);
		$("#modal-prime_entry_book_permissions").modal('show');
	}

	function closePrimeEntryBookAccesiblePermissionsDialog() {
		$("#modal-prime_entry_book_permissions").modal('hide');
	}

	function clearForm(){
		$("#people_id").val('');
		$("#user_name").val('');
		$("#new_password").val('');
		$("#confirm_password").val('');
		$("#role_id").val('');
		$("#derive_user_role_id").val('');
		$("#status").val('0');
		
		$("#accessible_warehouses_id").select2("destroy");
		$("#accessible_warehouses_id").val("a");
		$("#accessible_warehouses_id").select2();
	}
</script>
