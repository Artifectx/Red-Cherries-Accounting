<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Donation Reports') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--get report & icons -->
				<div class='box'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='text-center'>
								<div class='box'>
									<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
										<ul class="dash">
											<h3 align="left"><?php echo $this->lang->line('Donation Reports') ?></h3>

											<p style="margin-bottom:0px">&nbsp;</p>
											<li>
												<a class="tip" href="#" title="<?php echo $this->lang->line('Donation Details') ?>" onclick="selectReport('DonationDetails');">
													<i><img src="<?php echo base_url(); ?>assets/images/icons/donation_details.png"
															alt=""/></i>
													<span><span><?php echo $this->lang->line('Donation Details') ?></span></span>
												</a>
											</li>
											
											<li>
												<a class="tip" href="#" title="<?php echo $this->lang->line('Program Details') ?>" onclick="selectReport('ProgramDetails');">
													<i><img src="<?php echo base_url(); ?>assets/images/icons/program_report.png"
															alt=""/></i>
													<span><span><?php echo $this->lang->line('Program Details') ?></span></span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<form class='form form-horizontal'>
					<div class='msg_data'></div>
					<!--search stock form & table -->
					<div class='box donationDetails'>
						<div class='box-header'>
							<div class='title' id="report_title"><?php echo $this->lang->line('Search Donation Details') ?></div>
						</div>
						<div class='box-content'>
							<div class='row' id="date_filters">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('From Date') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('To Date') ?></label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-4 controls'>
											<div class='input-group date' id="from_date_picker">
												<input class='form-control' id='from_date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('From Date') ?>' type='text'>
												<span class='input-group-addon'>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
										<div class='col-sm-4 controls'>
											<div class='input-group date' id="to_date_picker">
												<input class='form-control' id='to_date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('To Date') ?>' type='text'>
												<span class='input-group-addon'>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>
							<div class='row' id="program_location_filters">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label style="text-align: left;" class='control-label col-sm-4' ><?php echo $this->lang->line('Program') ?></label>
										<label style="text-align : left" class='control-label col-sm-3' ><?php echo $this->lang->line('Location') ?></label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-4 controls' id="vehicle_select">
											<select id="program_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<div id="program_dropdown"></div>
											<div id="program_idError" class="red"></div>
										</div>
										<div class='col-sm-4 controls' id="warehouse_normal_select">
											<select id="location_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<div id="location_dropdown"></div>
											<div id="location_idError" class="red"></div>
										</div>
										<p style="margin-bottom:-17px">&nbsp;</p>
										<div class='col-sm-2 controls' id="search_button">
											<button class='btn btn-success report_option' id="report_option" onclick='getDonationsData(this.id, "search");'
													type='button'>
												<i class='icon-ban-circle'></i>
												<?php echo $this->lang->line('Search') ?>
											</button>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>
						</div>
					</div>
					
					<div id='table'>
						<div class='row'>
							<div class='col-sm-12'>
								<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
									<!--<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>-->
									<!--showing tabale-->
									<div id="dataTable">
									</div>
									<!--end table -->
								</div>
							</div>
						</div>
					</div>

					<div class='box' id="donation_summary_details">
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Donation Summary Details') ?></div>
						</div>
						<div class='box-content'>
							<div class='row'>
								<div id="donation_grand_total_div">
									<div class='form-group' id="donation_grand_total_lable">
										<div class='col-sm-12 controls'>
											<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Donation Grand Total') ?></label>
										</div>
									</div>
									<div class='form-group' id="donation_grand_total_value">
										<div class='col-sm-12 controls'>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='donation_grand_total' name='donation_grand_total' type='text' readonly>
											</div>
										</div>
										<p style="margin-bottom:-10px">&nbsp;</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class='box' id="program_summary_details">
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Program Summary Details') ?></div>
						</div>
						<div class='box-content'>
							<div class='row'>
								<div class='form-group' id="program_summary_lables">
									<div class='col-sm-12 controls'>
										<label id="total_budget_available_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Fund Available') ?></label>
										<label id="total_budget_estimated_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Budget Estimated') ?></label>
										<label id="budget_deficiency_total_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Budget Deficiency Total') ?></label>
										<label id="activity_cost_total_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Activity Cost Total') ?></label>
										<label id="budget_varience_total_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Budget Varience Total') ?></label>
									</div>
								</div>
								<div class='form-group' id="program_summary_values">
									<div class='col-sm-12 controls'>
										<div id="total_budget_available_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='total_budget_available' name='total_budget_available' type='text' readonly>
										</div>
										<div id="total_budget_estimated_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='total_budget_estimated' name='total_budget_estimated' type='text' readonly>
										</div>
										<div id="budget_deficiency_total_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='budget_deficiency_total' name='budget_deficiency_total' type='text' readonly>
										</div>
										<div id="activity_cost_total_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='activity_cost_total' name='activity_cost_total' type='text' readonly>
										</div>
										<div id="budget_varience_total_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='budget_varience_total' name='budget_varience_total' type='text' readonly>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>
						</div>
					</div>
					
					<div class='box' id="program_details">
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Program Details') ?></div>
						</div>
						<div class='box-content'>
							<div class='row'>
								<div class='form-group' id="program_detail_lables">
									<div class='col-sm-12 controls'>
										<label id="budget_available_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Fund Available') ?></label>
										<label id="budget_estimated_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Budget Estimated') ?></label>
										<label id="budget_deficiency_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Budget Deficiency') ?></label>
										<label id="activity_cost_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Activity Cost') ?></label>
										<label id="budget_varience_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Budget Varience') ?></label>
									</div>
								</div>
								<div class='form-group' id="program_detail_values">
									<div class='col-sm-12 controls'>
										<div id="budget_available_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='budget_available' name='budget_available' type='text' readonly>
										</div>
										<div id="budget_estimated_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='budget_estimated' name='budget_estimated' type='text' readonly>
										</div>
										<div id="budget_deficiency_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='budget_deficiency' name='budget_deficiency' type='text' readonly>
										</div>
										<div id="activity_cost_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='activity_cost' name='activity_cost' type='text' readonly>
										</div>
										<div id="budget_varience_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='budget_varience' name='budget_varience' type='text' readonly>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>
							<div class='row'>
								<div class='form-group' id="program_progress_lables">
									<div class='col-sm-12 controls'>
										<label id="budget_progress_label" style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Program Progress in Terms of Budget') ?></label>
										<label id="activity_progress_label" style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Program Progress in Terms of Activity Completion') ?></label>
									</div>
								</div>
								<div class='form-group' id="program_detail_values">
									<div class='col-sm-12 controls'>
										<div id="budget_progress_value_div" class='col-sm-4 controls'>
											<input class='form-control' id='budget_progress' name='budget_progress' type='text' readonly>
										</div>
										<div id="activity_progress_value_div" class='col-sm-4 controls'>
											<input class='form-control' id='activity_progress' name='activity_progress' type='text' readonly>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>
						</div>
					</div>
				</form>

				

				<div id="printButton">
					<?php echo form_open('serviceManagerModule/donationManagerModule/reportsSection/donations_report_controller/printReport', array('target'=>'_blank', 'class' => 'form-horizontal')) ?>
					<input type='hidden' name='report' id='report' value=''>
					<input type='hidden' name='fromDate' id='fromDate' value=''>
					<input type='hidden' name='toDate' id='toDate' value=''>
					<input type='hidden' name='programId' id='programId' value=''>
					<input type='hidden' name='locationId' id='locationId' value=''>
					<button type='submit' name='action' id='save' class='btn btn-warning'>
						<i class='icon-ban-circle'></i>
						<?php echo$this->lang->line('Print')?>
					</button>
					</form>
				</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>
	$(document).ready(function () {
		//getTableData();
		$(".loader").hide();
		$("#donation_summary_details").hide();
		$("#program_summary_details").hide();
		$("#program_details").hide();
		$('#printButton').hide();
		DonationReport.init();
		DonationReport.getProgramData();
		DonationReport.getLocationData();

		$("#from_date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#to_date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
	});

	function selectReport(reportName) {
		$("#search_button").find(".report_option").prop({ id: "report_option"});
		$("#search_button").find("#report_option").prop({ id: reportName});
		
		$("#program_summary_details").hide();
		$("#program_details").hide();
		
		$("#program_id").val('0');
		$("#location").val('0');
		$("#location").removeAttr("disabled");
		
		getDonationsData(reportName, "default");
	}

	function getDonationsData(donationReportType, callOption){
		if(donationReportType == 'DonationDetails'){

			$("#report_title").text("<?php echo $this->lang->line('Donation Details')?>");

			$('.donationDetails').show();
			$("#program_summary_details").hide();
			$("#program_details").hide();
			$("#date_filters").show();
			$("#printButton").show();
			$("#table").hide();
			$(".msg_data").hide();
			
			clearForm();

			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var programId = $("#program_id").val();
			var locationId = $("#location").val();

			$("#report").val('DonationDetails');
			$("#fromDate").val(fromDate);
			$("#toDate").val(toDate);
			$("#programId").val(programId);
			$("#locationId").val(locationId);

			if (callOption == "search") {
				$("#donation_summary_details").show();
				
				DonationReport.geDonationDetails(fromDate, toDate, programId, locationId);
			}

		} else if(donationReportType == 'ProgramDetails'){

			$("#report_title").text("<?php echo $this->lang->line('Program Details')?>");

			$('.donationDetails').show();
			$("#donation_summary_details").hide();
			$("#date_filters").hide();
			$("#printButton").show();
			$("#table").hide();
			$(".msg_data").hide();
			
			clearForm();

			var programId = $("#program_id").val();
			var locationId = $("#location").val();
			
			$("#report").val('ProgramDetails');
			$("#programId").val(programId);
			$("#locationId").val(locationId);

			if (callOption == "search") {
				if (programId == "0") {
					$("#program_summary_details").show();
					$("#program_details").hide();
				} else {
					$("#program_summary_details").hide();
					$("#program_details").show();
				}
				
				DonationReport.geProgramDetails(programId, locationId);
			}

		}
	}
	
	function handleProgramSelect(id) {
		var programId = $("#" + id).val();
		
		if (programId != '0') {
			DonationReport.getLocationOfAProgram(programId);
		} else {
			$("#location").val('0');
			$("#location").removeAttr("disabled");
		}
	}

	var DonationReport = {

		//get program dropdown
		getProgramData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller/getAllProgramsToDropDown",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					success:function (response) {
					$('#program_init').hide();
					$("#program_dropdown").html(response);
				}
			})
		},
		
		//get locations drop down
		getLocationData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getAllToLocationsDropDownWithoutLabel",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#location_init').hide();
						$("#location_dropdown").html(response);
					}
			})
		},
		
		//get donation details
		geDonationDetails: function (fromDate, toDate, programId, locationId) {
			//alert(filterTpe)
			$('#printButton').show();
			$(".loader").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/reportsSection/donations_report_controller/getDonationDetailsDetailsTable",
				data: {
					'from_date' : fromDate,
					'to_date' : toDate,
					'program_id' : programId,
					'location_id':locationId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$("#table").show();
					$("#dataTable").html(response.html);
					$("#donation_grand_total").val(response.donationGrandTotal);
					$(".loader").hide();
					$('.donationDataTable').dataTable();
				}
			});
		},
		
		//get program details
		geProgramDetails: function (programId, locationId) {
			//alert(filterTpe)
			$('#printButton').show();
			$(".loader").show();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/reportsSection/donations_report_controller/getProgramDetailsTable",
				data: {
					'program_id' : programId,
					'location_id':locationId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$("#table").show();
					$("#dataTable").html(response.html);
					
					if (programId == "0") {
						$("#total_budget_available").val(response.budgetAvailableGrandTotal);
						$("#total_budget_estimated").val(response.budgetEstimatedGrandTotal);
						$("#budget_deficiency_total").val(response.budgetDeficiencyGrandTotal);
						$("#activity_cost_total").val(response.activityCostGrandTotal);
						$("#budget_varience_total").val(response.budgetVarienceGrandTotal);
					} else {
						$("#budget_available").val(response.budgetAvailable);
						$("#budget_estimated").val(response.budgetEstimated);
						$("#budget_deficiency").val(response.budgetDeficiency);
						$("#activity_cost").val(response.activityCost);
						$("#budget_varience").val(response.budgetVarience);
						
						$("#budget_progress").val(response.budgetProgress);
						$("#activity_progress").val(response.activityProgress);
					}
					
					$(".loader").hide();
					$('.programDataTable').dataTable();
				}
			});
		},
		
		//get program location
		getLocationOfAProgram: function (programId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/reportsSection/donations_report_controller/getLocationOfAProgram",
				data: {
					'program_id' : programId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$("#location").val(response);
						$("#location").attr("disabled", "disabled");
					}
			})
		},

		init : function () {
			$(".loader").hide();
			$("#table").hide();
			$(".msg_data").hide();
			$(".validation").hide();
			$('.donationDetails').hide();            
		}
	};
	
	function clearForm() {
		$("#total_budget_available").val("");
		$("#total_budget_estimated").val("");
		$("#budget_deficiency_total").val("");
		$("#activity_cost_total").val("");
		$("#budget_varience_total").val("");
		
		$("#budget_available").val("");
		$("#budget_estimated").val("");
		$("#budget_deficiency").val("");
		$("#activity_cost").val("");
		$("#budget_varience").val("");

		$("#budget_progress").val("");
		$("#activity_progress").val("");
	}
</script>