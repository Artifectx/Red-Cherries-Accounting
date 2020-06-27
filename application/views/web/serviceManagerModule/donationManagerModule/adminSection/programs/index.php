<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Program Details') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>

				<div class='form page_load' id='page_load'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background'>
									<div class='title'><?php echo $this->lang->line('Program Details') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<div class='validation'></div>
									<form class='form form-horizontal validate-form save_form'>
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Program Name') ?> *</label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='program_name'
													   name='program_name' placeholder='<?php echo $this->lang->line('Program Name') ?>' type='text'
													   value="<?php echo set_value('program_name'); ?>">
												<div id="program_nameError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Description') ?> </label>
											<div class='col-sm-4 controls'>
												<textarea class='form-control' id='description'
														  name='description' placeholder='<?php echo $this->lang->line('Description') ?>'><?php echo set_value('description'); ?></textarea>
												<div id="descriptionError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Coordinator Name') ?> *</label>
											<div class='col-sm-4 controls'>
												<div id="coordinator_dropdown">
												</div>
												<div id="coordinator_idError" class="red"></div>
											</div>
										</div>
														
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Location') ?> *</label>
											<div class='col-sm-4 controls'>
												<div id="location_dropdown">
												</div>
												<div id="locationError" class="red"></div>
											</div>
										</div>

										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<?php
													if (isset($SVM_DSM_Admin_Add_Programs_Permissions)){
														?>
														<button class='btn btn-success save' onclick='saveData();'
																type='button'>
															<i class='icon-save'></i>
															<?php echo $this->lang->line('Save') ?>
														</button>
														<?php
													}
													?>
													<button class='btn btn-primary' type='reset'>
														<i class='icon-undo'></i>
														<?php echo $this->lang->line('Refresh') ?>
													</button>
													<button class='btn btn-warning cancel' onclick='cancelData();'
															type='button'>
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
								if (isset($SVM_DSM_Admin_Add_Programs_Permissions)){
								?>
								<a class='btn btn-success btn-sm new'><?php echo $this->lang->line('Add New Program') ?></a>
								<p>&nbsp;
									<?php
									}
									?>

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
		getTableData();
		Programs.init();
		Programs.getLocationsList();
		Programs.getCoordinatorList();
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
		$(".msg_data").hide();
		$(".validation").hide();
		Programs.cancelData();
	}

	function saveData() {
		if (validateForm_save()) {
			Programs.saveData();
		}
	}

	function editData() {
		if (validateForm_edit()) {
			Programs.editData();
		}
	}

	function get(id){
		$("#page_load").removeClass("page_load");
		$("#page_load").addClass("page_load_show");
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Programs.getData(id);
	}

	function del(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Programs.deleteData(id);
	}

	//start Programs object
	var Programs = {
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
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller/add",
				data: {
					'program_name': $("#program_name").val(),
					'description': $("#description").val(),
					'coordinator_id': $("#coordinator_id").val(),
					'location_id' : $("#location").val(),
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
		
			var msg_no_changes_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('no_changes_to_save')?>' +
				'</div>';
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller/edit",
				data: {
					'id': $("#program_id").val(),
					'program_name': $("#program_name_edit").val(),
					'description': $("#description_edit").val(),
					'coordinator_id': $("#coordinator_id_edit").val(),
					'location_id' : $("#location_edit").val(),
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					beforeSend:function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);

						$(".form").hide();
						$(".edit_form").hide();
						getTableData();
					} else if (response == 'no_changes_to_save') {
						$(".msg_data").show();
						$(".msg_data").html(msg_no_changes_to_save);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},

		deleteData: function (id) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete').$this->lang->line('program details') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller/delete",
					data: {
						'id': id,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
							'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
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
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller/get",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$(".form").show();
					$(".save_form").hide();
					$(".edit_form").show();
					$(".edit_form").html(response);
					$("#primary_phone_edit").intlTelInput();
					$("#secondary_phone_edit").intlTelInput();
					$("#fax_edit").intlTelInput();
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

		getCoordinatorList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllEmployeesAndMembersToDropDown",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(response) {
					$("#coordinator_dropdown").html(response);
					$("#coordinator_dropdown").find("#people_id").prop({ id: "coordinator_id"});
				}
			});
		},
		
		getLocationsList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getAllToLocationsDropDownWithoutLabel",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
					},
				dataType: 'html',
				success: function(locationList) {
					$("#location_dropdown").html(locationList);
				}
			});
		},
	}

	function validateForm_save() {
		return (isNotEmpty("program_name", "<?php echo $this->lang->line('Program Name').' '.$this->lang->line('field is required')?>")
			&& isSelected("coordinator_id", "<?php echo $this->lang->line('Coordinator Name').' '.$this->lang->line('field is required')?>")
			&& isSelected("location", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
		);
	}

	function validateForm_edit() {
		return (isNotEmpty("program_name_edit", "<?php echo $this->lang->line('Program Name').' '.$this->lang->line('field is required')?>")
			&& isSelected("coordinator_id_edit", "<?php echo $this->lang->line('Coordinator Name').' '.$this->lang->line('field is required')?>")
			&& isSelected("location_edit", "<?php echo $this->lang->line('Location').' '.$this->lang->line('field is required')?>")
		);
	}

	//get all data
	function getTableData(){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller/getTableData",
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
		$("#program_name").val('');
		$("#description").val('');
		$("#coordinator_id").val('0');
	}

</script>
