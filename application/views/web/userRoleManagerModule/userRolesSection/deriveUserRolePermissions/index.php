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
								<span><?php echo $this->lang->line('Derive User Role Permissions Details') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>

				<div class='form'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-content'>
									<div class='validation'></div>
									<form class='form form-horizontal validate-form save_form'>
										<div class='form-group'>
											<label class='control-label col-sm-3'><?php echo $this->lang->line('Derive User Roles') ?> *</label>

											<div class='col-sm-4 controls'>
												<select name="derive_user_role_id" id="derive_user_role_id" class="form-control" onchange="getUserRolePermission();">
													<option value=''><?php echo $this->lang->line('-- Select --')?></option>
													<?php
													if ($user_roles != null) {
														foreach($user_roles as $raw){
														   // if($raw->derive_user_role_id !=1) {
																?>
																<option
																	value="<?php echo $raw->derive_user_role_id; ?>"<?php echo set_select('derive_user_role_id', $raw->derive_user_role_id, FALSE) ?>><?php echo $raw->derive_user_role_name; ?></option>
																<?php
														   // }
														}
													}
													?>
												</select>
												<div id="derive_user_role_idError" class="red"></div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id='table'>
					<div class="msg_delete"></div>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php //echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
								<p>&nbsp;
								<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

								<!--showing tabale-->
								<div id="dataTable">
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class='modal fade' id='modal-advanced_permissions' tabindex='-1'>
			<div class='modal-dialog' style="height:550px;width:850px">
				<div class='modal-content'>
					<div class='modal-header'>
						<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
						<h4 class='modal-title' id='modal_title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Advanced Permissions') ?></h4>
					</div>

					<form enctype="text/plain" accept-charset="utf-8" name="formname" id="advanced_permissions_form"  method="post" action="">
						<div class='modal-body'>
							<div class='modal_msg_data'></div>
							<div class='col-sm-12'>
								<input class='form-control' id='user_role_id' name='user_role_id' type='hidden'>
								<div class='box' id="advanced_permission_list">

								</div>
							</div>
						</div>
					</form>
					<div class='modal-footer'>
						<button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Close') ?></button>
					</div>
				</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	$(document).ready(function () {
		$(".form").show();
		DeriveUserRolePermission.init();
	});

	function getUserRolePermission(){
		if($('#derive_user_role_id').val() == ''){
			validateForm_select();
			$("#table").hide();
		}
		else{
			$('#derive_user_role_idError').html('');
			getTableData($('#derive_user_role_id').val());
		}
	}

	function openAdvancedPermissions(permissionIds, userRoleId) {
		DeriveUserRolePermission.getAdvancedPermissionsList(permissionIds, userRoleId);
		openAdvancedPermissionsDialog(userRoleId);
	}

	function openAdvancedPermissionsDialog(userRoleId) {
		$(".modal_msg_data").hide();
		$("#user_role_id").val(userRoleId);
		$("#modal-advanced_permissions").modal('show');
	}

	function closeAdvancedPermissionsDialog() {
		$("#modal-advanced_permissions").modal('hide');
	}

	function saveDeriveUserRolePermission(deriveRoleId,permissionId){
		if($('#permission_'+permissionId).is(":checked")){
			alert("Checkbox is checked."+permissionId);
		}
		else if($('#permission_'+permissionId).is(":not(:checked)")){
			alert("Checkbox is unchecked.");
		}

		/*if($('#permission_'+permissionId).prop( "checked", true ))
			alert("Checkbox is checked by."+permissionId);
		else if ($('#permission_'+permissionId).prop( "checked", false ))
			alert("Checkbox is unchecked by");*/
	}

	function handlePermissionChange(id, userRoleId) {
		$(".modal_msg_data").hide();
		var permissionId = id.substring(14,20);
		if ($("#" + id).prop("checked") == true) {
			DeriveUserRolePermission.editAdvancedPermission(userRoleId, permissionId, "add");
		} else {
			DeriveUserRolePermission.editAdvancedPermission(userRoleId, permissionId, "remove");
		}
	}

	function cancelData() {
		DeriveUserRolePermission.cancelData();
	}

	function saveData(deriveRoleId) {
		$(".loader").show();
		var deriveUserRolePermission = [];
		$.each($("input[name='derive_permission']:checked"), function(){
			deriveUserRolePermission.push($(this).val());
		});
		//alert("Permission are : " + deriveUserRolePermission.join(", "));
		//alert("Permission are : " + deriveUserRolePermission);
		//alert(deriveRoleId)

		DeriveUserRolePermission.saveData(deriveRoleId,deriveUserRolePermission);

	}

	var DeriveUserRolePermission = {

		cancelData: function () {
			//$(".form").hide();
			$("#table").hide();
		},

		saveData: function (deriveRoleId, deriveUserRolePermission) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_permissions_controller/edit",
				data: {
					'derive_user_role_id': deriveRoleId,
					'permission_id': deriveUserRolePermission,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						getTableData(deriveRoleId);
						window.scrollTo(0,0);
					}
					else {
						$(".loader").hide();
						$(".msg_data").hide();
						$(".validation").show();
						$(".validation").html(response);
						$(".save:input").attr('disabled', false);
						getTableData(deriveRoleId);
					}
				}
			})
		},

		getAdvancedPermissionsList : function(permissionIds, userRoleId)  {
			$("#table").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_permissions_controller/getAdvancedPermissionList",
				data: {
					'permission_ids' : permissionIds,
					'user_role_id' : userRoleId,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					success:
				function (response) {
					$("#advanced_permission_list").html(response);
				}
			})
		},

		editAdvancedPermission : function(userRoleId, permissionId, operation) {

			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_permissions_controller/editAdvancedPermission",
				data: {
					'derive_user_role_id' : userRoleId,
					'permission_id' : permissionId,
					'operation' : operation,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					success:
				function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").hide();
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg);
					}
				}
			})
		},

		init : function () {
			$("#table").show();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
			$(".loader").hide();
		}
	}


	//form validation save
	function validateForm_select() {
		return (isSelected("derive_user_role_id", "<?php echo $this->lang->line('user_role').' '.$this->lang->line('field is required')?>")
		);
	}

	//get all data
	function getTableData(id) {
		$("#table").show();
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_permissions_controller/getTableData",
			data: {
				'id':id,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#dataTable").html(response);
				$(".loader").hide();
				//$('.table').dataTable();
				$('#rolePermissionTable').DataTable( {
					"iDisplayLength": 50
				} );
			}
		})
	}
</script>
