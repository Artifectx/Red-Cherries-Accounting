<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Stakeholder Account Balances') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>

				<!--Cheques search form -->
				<form class='form form-horizontal validate-form' id="search_receive_payment_form">
					<div class='box'>
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Search Stakeholder Account Balances') ?></div>
						</div>
						<div class='box-content'>
							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<label class='control-label col-sm-4 col-sm-1' ><?php echo $this->lang->line('Stakeholder') ?></label>
									<label class='control-label col-sm-4 col-sm-1' ><?php echo $this->lang->line('Location') ?></label>
								</div>
							</div>

							<div class='form-group'>
								<div class='col-sm-12 controls'>
									<div class='col-sm-4 controls'>
										<select id="stakeholder_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="stakeholder_search_dropdown"></div>
										<div id="stakeholder_search_idError" class="red"></div>
									</div>
									<div class='col-sm-4 controls'>
										<select id="location_search_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
										<div id="location_search_dropdown"></div>
										<div id="location_search_idError" class="red"></div>
									</div>
									<div class='col-sm-2 controls'>
										<button class='btn btn-success save' onclick='searchData();' type='button'>
											<i class='icon-save'></i>
											<?php echo $this->lang->line('Search') ?>
										</button>
									</div>
								</div>
								<p style="margin-bottom:-10px">&nbsp;</p>
							</div>
						</div>
					</div>
				</form>

				<div id='table'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>

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

		StakeholderAccountBalance.getStakeholderData();
		StakeholderAccountBalance.getLocationData();

		getTableData("0", "0");
	});
	
	function searchData() {
		var stakeholderId = $("#stakeholder_search_id").val();
		var locationId = $("#location_search_id").val();
		getTableData(stakeholderId, locationId);
	}
	
	var StakeholderAccountBalance = {
		
		//get stakeholder drop down
		getStakeholderData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToPeopleDropDownWithPeopleCode",
				data: {
                    'check_authority' : "Yes",
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
				function (response) {
					$('#stakeholder_search_init').hide();
					$("#stakeholder_search_dropdown").html(response);
					$("#stakeholder_search_dropdown").find("#people_id").prop({ id: "stakeholder_search_id"});
					$("#stakeholder_search_id").select2();
				}
			})
		},

		//get unit conversions drop down
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
					$('#location_search_init').hide();
					$("#location_search_dropdown").html(response);
					$("#location_search_dropdown").find("#location").prop({ id: "location_search_id"});
				}
			})
		}
	}

	//get all data
	function getTableData(stakeholderId, locationId){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/stakeholder_account_balances_controller/getTableData",
			data: {
				'stakeholder_id' : stakeholderId,
				'location_id' : locationId,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'json',
				success:
			function (response) {
				$("#dataTable").html(response.html);
				$(".loader").hide();
				
				$('.stakeholderAccountBalanceListDataTable').dataTable({
					"aaSorting": [[ 0, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		})
	}
</script>