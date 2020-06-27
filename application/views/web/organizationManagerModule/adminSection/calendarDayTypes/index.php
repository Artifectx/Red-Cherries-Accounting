<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Calendar Day Types') ?></span>
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
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Calendar Day Type Details') ?></div>
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
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Day Type Code') ?> *</label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='day_type_code'
													   name='day_type_code' placeholder='<?php echo $this->lang->line('Day Type Code') ?>' type='text'
													   value="<?php echo set_value('day_type_code'); ?>">
												<div id="day_type_codeError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Day Type Name') ?> *</label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='day_type_name'
													   name='day_type_name' placeholder='<?php echo $this->lang->line('Day Type Name') ?>' type='text'
													   value="<?php echo set_value('day_type_name'); ?>">
												<div id="day_type_nameError" class="red"></div>
											</div>
										</div>

										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<?php
													if (isset($OGM_Admin_Add_Calendar_Day_Types_Permissions)){ ?>
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
								if (isset($OGM_Admin_Add_Calendar_Day_Types_Permissions)){ ?>
									<button class='btn btn-success btn-sm new'
											type='button' <?php echo $menuFormatting; ?>>
										<?php echo $this->lang->line('Add New Calendar Day Type') ?>
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
		CalendarDayType.init();
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
		CalendarDayType.cancelData();
	}

	function saveData() {
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			CalendarDayType.saveData();
            window.scrollTo(0,0);
		}
	}

	function editData() {
		if (validateForm_edit()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			CalendarDayType.editData();
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
		CalendarDayType.getData(id);
	}

	function del(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		CalendarDayType.deleteData(id);
	}

	//start location object
	var CalendarDayType = {
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
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller/add",
					data: {
						'day_type_code': $("#day_type_code").val(),
						'day_type_name': $("#day_type_name").val(),
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
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller/edit",
					data: {
						'day_type_id': $("#day_type_id").val(),
						'day_type_code': $("#day_type_code_edit").val(),
						'day_type_name': $("#day_type_name_edit").val(),
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
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('Calendar Day Type Details') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller/delete",
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
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller/get",
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

		init : function () {
			$("#table").show();
			$(".form").hide();
			$(".edit_form").hide();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		}
		
	};//end location object

	function validateForm_save() {
		return (isNotEmpty("day_type_code", "<?php echo $this->lang->line('Day Type Code').' '.$this->lang->line('field is required')?>")
			&&  isNotEmpty("day_type_name", "<?php echo $this->lang->line('Day Type Name').' '.$this->lang->line('field is required')?>")
		);
	}

	function validateForm_edit() {
		return (isNotEmpty("day_type_code_edit", "<?php echo $this->lang->line('Day Type Code').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("day_type_name_edit", "<?php echo $this->lang->line('Day Type Name').' '.$this->lang->line('field is required')?>")
		);
	}

	//get all data
	function getTableData(){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller/getTableData",
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
		$("#day_type_code").val('');
		$("#day_type_name").val('');
	}

</script>
