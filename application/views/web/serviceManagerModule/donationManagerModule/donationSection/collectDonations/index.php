<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Collect Donations') ?></span>
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
									<div class='title'><?php echo $this->lang->line('Donation Details') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<div class='validation'></div>
									<form class='form form-horizontal validate-form save_form'>
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Reference Number') ?> *</label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='reference_no' name='reference_no'
													   placeholder='<?php echo $this->lang->line('Reference Number') ?>' type='text' 
													   value="">
												<div id="reference_noError" class="red"></div>
											</div>
										</div>
														
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Program Name') ?> *</label>
											<div class='col-sm-4 controls'>
												<div id="program_dropdown">
												</div>
												<div id="program_idError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Date') ?> *</label>
											<div class='col-sm-4 controls'>
												<div class='datepicker-input input-group' id='datepicker'>
													<input class='form-control' id='date' name='date'
														   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
													  <span class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"/>
													  </span>
												</div>
												<div id="dateError" class="red"></div>
											</div>
										</div>

										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Donor') ?> *</label>
											<div class='col-sm-4 controls'>
												<div id="donor_dropdown">
												</div>
												<div id="donor_idError" class="red"></div>
											</div>
										</div>
														
										<div class='form-group'>
											<label class='control-label col-sm-3'><?php echo $this->lang->line('Amount') ?> *</label>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='amount' name='amount'
													   placeholder='<?php echo $this->lang->line('Amount') ?>' type='text' 
													   value="" onblur="handleAmountAddition(this.id);">
												<div id="amountError" class="red"></div>
											</div>
										</div>
											
										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<?php
													if (isset($SVM_DSM_Donation_Add_Collect_Donations_Permissions)){
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
								if (isset($SVM_DSM_Donation_Add_Collect_Donations_Permissions)){
								?>
									<a class='btn btn-success btn-sm new'><?php echo $this->lang->line('Add New Donation') ?></a>
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
		Donations.init();
		Donations.getProgramList();
		Donations.getDonorList();
		
		$("#datepicker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
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
		Donations.cancelData();
	}

	function saveData() {
		if (validateForm_save()) {
			Donations.saveData();
		}
	}

	function editData() {
		if (validateForm_edit()) {
			Donations.editData();
		}
	}

	function get(id){
		$("#page_load").removeClass("page_load");
		$("#page_load").addClass("page_load_show");
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Donations.getData(id);
	}

	function del(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Donations.deleteData(id);
	}
	
	function handleAmountAddition(id) {
		var amount = $("#" + id).val();
		if (amount != "") {
			var amountData = amount.split(".");
			var amountDataSize = amountData.length;

			if (amountDataSize == 1) {
				amount = amount + ".00";
				$("#" + id).val(amount);
			} else {
				$("#" + id).val(parseFloat(amount).toFixed(2));
			}
		}
	}

	//start Donations object
	var Donations = {
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
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/collect_donations_controller/add",
				data: {
					'reference_no' : $("#reference_no").val(),
					'program_id' : $("#program_id").val(),
					'date' : $("#date").val(),
					'donor_id' : $("#donor_id").val(),
					'amount' : $("#amount").val(),
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
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/collect_donations_controller/edit",
				data: {
					'id': $("#donation_id").val(),
					'reference_no' : $("#reference_no_edit").val(),
					'program_id': $("#program_id_edit").val(),
					'date': $("#date_edit").val(),
					'donor_id': $("#donor_id_edit").val(),
					'amount': $("#amount_edit").val(),
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
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete').$this->lang->line('donation details') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/collect_donations_controller/delete",
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
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/collect_donations_controller/get",
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
					$(".loader").hide();
					$("#datepicker_edit").datetimepicker({
						format: 'YYYY-MM-DD'
					});
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

		getProgramList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller/getAllProgramsToDropDown",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(response) {
					$("#program_dropdown").html(response);
				}
			});
		},
		
		getDonorList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllEmployeesAndMembersToDropDown",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(response) {
					$("#donor_dropdown").html(response);
					$("#donor_dropdown").find("#people_id").prop({ id: "donor_id"});
				}
			});
		}
	}

	function validateForm_save() {
		return (isNotEmpty("reference_no", "<?php echo $this->lang->line('Reference Number').' '.$this->lang->line('field is required')?>")
			&& isSelected("program_id", "<?php echo $this->lang->line('Program Name').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("date", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("donor_id", "<?php echo $this->lang->line('Donor').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("amount", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}

	function validateForm_edit() {
		return (isNotEmpty("reference_no_edit", "<?php echo $this->lang->line('Reference Number').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("program_id_edit", "<?php echo $this->lang->line('Program Name').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("date_edit", "<?php echo $this->lang->line('Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("donor_id_edit", "<?php echo $this->lang->line('Donor').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("amount_edit", "<?php echo $this->lang->line('Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	//get all data
	function getTableData(){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/collect_donations_controller/getTableData",
			data: {
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#dataTable").html(response);
				$(".loader").hide();
				$('.donationsTable').dataTable({
					"aaSorting": [[ 0, "desc" ]]
				});
			}
		})
	}

	function clearForm(){
		$("#reference_no").val('');
		$("#program_id").val('0');
		$("#date").val(moment().format('YYYY-MM-DD'));
		$("#donor_id").val('0');
		$("#amount").val('');
		$("#location").val('0');
	}

</script>
