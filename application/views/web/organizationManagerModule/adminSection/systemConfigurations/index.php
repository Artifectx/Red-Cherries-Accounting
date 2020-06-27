<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<br>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='box'>
							<div class='box-header <?php echo BOXHEADER; ?>-background'>
								<div class='title'><?php echo $this->lang->line('System Configurations') ?></div>
								<div class='actions'>
									<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
									</a>
								</div>
							</div>

							<div class='box-content'>
								<div class='msg_data'></div>
                                <div class='msg_instant' align="center"></div>
								<form class='form form-horizontal validate-form'>
									<div class='tabbable' style='margin-top: 20px'>
										<ul class='nav nav-responsive nav-tabs'>
											<li class='active'>
												<a data-toggle='tab' class="tab-header" href='#administration_configurations'><?php echo $this->lang->line('Administration') ?></a>
											</li>
										</ul>
										<div class='tab-content'>
											<div id="administration_configurations" class="tab-pane active">
												<div class='tabbable' style='margin-top: 20px'>
													<ul class='nav nav-responsive nav-tabs'>
														<li class='active'>
															<a data-toggle='tab' class="tab-header" href='#admin_people'><?php echo $this->lang->line('People') ?></a>
														</li>
														<li class=''>
															<a data-toggle='tab' class="tab-header" href='#organization_calendar_configurations'><?php echo $this->lang->line('Organization Calendar') ?></a>
														</li>
													</ul>
													<div class='tab-content'>
														<div id="admin_people" class="tab-pane active">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group'>
																		<div class='col-sm-4 controls'>
																			<input class="config_checkboxes" type="checkbox" name="ogm_people_addition_need_authorization" id="ogm_people_addition_need_authorization" onchange="handlePeopleAdditionOrthorizationEnableSelect(this.id);"
                                                                            <?php if ($systemConfigData['ogm_people_addition_need_authorization'] == "Yes") { echo 'checked ';}?>>
																			<label for="ogm_people_addition_need_authorization" ><?php echo $this->lang->line('People Addition Need Authorizer Approval') ?></label>
																		</div>
																	</div>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-5 controls'>
																			<label class='control-label col-sm-6'><?php echo $this->lang->line('People Addition Authorizer') ?></label>
																			<div class='col-sm-6 controls'>
																				<select id="ogm_people_addition_authorizer_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																				<!--People Addition Authorizer drop down-->
																				<div id="ogm_people_addition_authorizer_dropdown">
																				</div>
																				<!--End People Addition Authorizer drop down-->
																				<div id="ogm_people_addition_authorizer_idError" class="red"></div>
																			</div>
																		</div>
                                                                    </div>
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($OGM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="admin_save_people_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div id="organization_calendar_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<label style="text-align : left" class='control-label col-sm-12' ><?php echo $this->lang->line('Organization Calendar Default Settings') ?></label>			
																		</div>
																	</div>
																	<div class='form-group'>
																		<div class='col-sm-12 controls'>
																			<div class='col-sm-3 controls'>
																				<label style="text-align : left" class='control-label col-sm-12' ><?php echo $this->lang->line('Saturday Calendar Day Type') ?></label>
																			</div>
																			<div class='col-sm-3 controls'>
																				<select id="saturday_calendar_day_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Saturday Calendar Day Type drop down-->
																					<div id="saturday_calendar_day_type_dropdown">
																					</div>
																					<!--End of Saturday Calendar Day Type drop down-->
																				</select>
																			</div>
																			<div class='col-sm-3 controls'>
																				<label style="text-align : left" class='control-label col-sm-12' ><?php echo $this->lang->line('Sunday Calendar Day Type') ?></label>
																			</div>
																			<div class='col-sm-3 controls'>
																				<select id="sunday_calendar_day_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
																					<!--Sunday Calendar Day Type drop down-->
																					<div id="sunday_calendar_day_type_dropdown">
																					</div>
																					<!--End of Sunday Calendar Day Type drop down-->
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-12 controls'>
																			<div class='col-sm-3 controls'>
																				
																			</div>
																			<div class='col-sm-5 controls'>
																				<button class='btn btn-success' type='button' id="populate_current_year_calendar_with_saturdays_and_sundays" <?php echo $menuFormatting; ?> onclick="populateCurrentYearCalendarWithSaturdaysAndSundays();">
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Populate Current Year Calendar With Saturdays and Sundays for Following Countries and Companies') ?>
																				</button>
																			</div>
																		</div>
																	</div>
																	<div class='form-group' id="country_and_company_select_div_1">
																		<div class='col-sm-5 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Country') ?></label>
																			<div class='col-sm-8 controls'>
																				<select class='select form-control' id='country_1' name='country_1' onchange='onChangeCountry(this.id);'>
																					<?php echo $country_list; ?>
																				</select>
																			</div>
																		</div>
																		<div class='col-sm-5 controls'>
																			<label class='control-label col-sm-2'><?php echo $this->lang->line('Company') ?></label>
																			<div class='col-sm-8 controls'>
																				<select class='select form-control' id='company_1' name='company_1' onchange='onChangeCompany(this.id);' disabled>
																					<?php echo $company_list; ?>
																				</select>
																			</div>
																		</div>
																		<div class='col-sm-2 controls'>
																			<button class='btn btn-success' type='button' id="add_country_and_company_1" <?php echo $menuFormatting; ?> onclick="addAnotherCountrySelectAndCompanySelect(this.id, '');">
																				<i class='icon-save'></i>
																				<?php echo $this->lang->line('Add') ?>
																			</button>
																			<button class='btn btn-danger' type='button' id="delete_country_and_company_1" <?php echo $menuFormatting; ?> onclick="deleteCountrySelectAndCompanySelect(this.id);">
																				<i class='icon-save'></i>
																				<?php echo $this->lang->line('Delete') ?>
																			</button>
																		</div>
																	</div>
																	<div class='form-group' id="country_and_company_data_div_1">
																		
																	</div>
																	
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($OGM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="admin_save_organization_calendar_config_data" <?php echo $menuFormatting; ?>>
																					<i class='icon-save'></i>
																					<?php echo $this->lang->line('Save') ?>
																				</button>
																				<?php
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

    var PeopleAdditionAuthorizerFeatureEnabled = '';
	var OrgCalendarDefaultCountryCompanyCount = 0;
    
	$(document).ready(function() {
        $(".msg_instant").hide();
		$("#excel_file_configurations").hide();
		$("#punch_type_value_div").hide();
		
		SysConfig.getCalendarDayTypeData();
		$("#country_1").select2();
		
		$("#delete_country_and_company_1").attr("disabled", true);
		
		SysConfig.getOrgCalendarDefaultCountryCompanyData();
        SysConfig.getWelfareShopCustomerCategoryData();
        SysConfig.getActionAuthorizerData();
        
        setTimeout(function() {
			SysConfig.getCurrentPeopleAdditionAuthorizerData();
		}, 300);
	});
	
    $("#admin_save_people_config_data").click(function () {
		
		if ($("#ogm_people_addition_need_authorization").prop("checked") == true) {
			PeopleAdditionAuthorizerFeatureEnabled = "Yes";
		} else {
			PeopleAdditionAuthorizerFeatureEnabled = "No";
		}
        
        var peopleAdditionAuthorizerId = $("#ogm_people_addition_authorizer_id").val();
		
		SysConfig.savePeopleConfigData(PeopleAdditionAuthorizerFeatureEnabled, peopleAdditionAuthorizerId);
	});
	
	$("#admin_save_organization_calendar_config_data").click(function () {
		
		var OrgCalendarDefaultCountryList = new Array();
		var OrgCalendarDefaultCompanyList = new Array();

		var groupCloneCount = 1;
		var rowCloneCount = 1;
		var element = $("#country_and_company_data_row_div_" + groupCloneCount).find("#country_id_value_" + rowCloneCount);

		while (element.length == 1) {
			OrgCalendarDefaultCountryList.push($("#country_id_value_"+rowCloneCount).val());
			OrgCalendarDefaultCompanyList.push($("#company_id_value_"+rowCloneCount).val());
			groupCloneCount++;
			rowCloneCount++;
			element = $("#country_and_company_data_row_div_" + groupCloneCount).find("#country_id_value_" + rowCloneCount);
		}
		
		SysConfig.saveOrganizationCalendarConfigData(OrgCalendarDefaultCountryList, OrgCalendarDefaultCompanyList);
	});
	
	function populateCurrentYearCalendarWithSaturdaysAndSundays() {
		SysConfig.populateCurrentYearCalendarWithSaturdaysAndSundays();
	}
	
	function addAnotherCountrySelectAndCompanySelect(id, cloneCount) {
		
		if (cloneCount == '') {
			cloneCount = id.substring(24,26);
		}
	
		var newCloneCount = parseInt(cloneCount) + 1;
		
		$("#country_" + cloneCount).select2("destroy");
		
		var newSelectCloneRow = $("#country_and_company_select_div_" + cloneCount).clone().prop({ id: "country_and_company_select_div_" + newCloneCount}).insertAfter("#country_and_company_data_div_" + cloneCount);
		
		$("#country_" + cloneCount).select2();
		
		newSelectCloneRow.find("#country_" + cloneCount).select2();
		newSelectCloneRow.find("#country_" + cloneCount).prop({ id: "country_" + newCloneCount});
		$("#country_" + newCloneCount).select2();
		newSelectCloneRow.find("#company_" + cloneCount).prop({ id: "company_" + newCloneCount});
		newSelectCloneRow.find("#add_country_and_company_" + cloneCount).prop({ id: "add_country_and_company_" + newCloneCount});
		newSelectCloneRow.find("#delete_country_and_company_" + cloneCount).prop({ id: "delete_country_and_company_" + newCloneCount});
		
		$("#add_country_and_company_" + cloneCount).attr("disabled", true);
		$("#delete_country_and_company_" + newCloneCount).attr("disabled", false);
		
		$("#country_and_company_data_div_" + cloneCount).clone().prop({ id: "country_and_company_data_div_" + newCloneCount}).insertAfter("#country_and_company_select_div_" + newCloneCount);
		$("#country_and_company_data_div_" + newCloneCount).empty();
		
		$("#country_" + newCloneCount).select2("enable", true);
		$("#company_" + newCloneCount).attr("disabled", true);
	}
	
	function deleteCountrySelectAndCompanySelect(id) {
		var cloneCount = id.substring(27,29);
		$("#country_and_company_select_div_" + cloneCount).remove();
		$("#country_and_company_data_div_" + cloneCount).remove();
		
		var previousCloneCount = parseInt(cloneCount) - 1;
		var nextCloneCount = parseInt(cloneCount) + 1;
		
		if ($("#country_and_company_select_div_" + nextCloneCount).length == '0') {
			$("#add_country_and_company_" + previousCloneCount).attr("disabled", false);
		} else {
			
			var currentCloneCount = cloneCount;
			
			while ($("#country_and_company_select_div_" + nextCloneCount).length == 1) {
				
				$("#country_and_company_select_div_" + nextCloneCount).prop({ id: "country_and_company_select_div_" + currentCloneCount});
				$("#country_" + nextCloneCount).prop({ id: "country_" + currentCloneCount});
				$("#company_" + nextCloneCount).prop({ id: "company_" + currentCloneCount});
				$("#add_country_and_company_" + nextCloneCount).prop({ id: "add_country_and_company_" + currentCloneCount});
				$("#delete_country_and_company_" + nextCloneCount).prop({ id: "delete_country_and_company_" + currentCloneCount});
				
				$("#country_and_company_data_div_" + nextCloneCount).prop({ id: "country_and_company_data_div_" + currentCloneCount});
				
				currentCloneCount++;
				nextCloneCount++;
			}
		}
	}
	
	function onChangeCountry(id) {
		
		var cloneCount = id.substring(8,10);
		
		if ($("#" + id).val() != '0') {
			$("#company_" + cloneCount).attr("disabled", false);
		} else {
			$("#company_" + cloneCount).attr("disabled", true);
		}
	}
	
	function onChangeCompany(id) {
		var html = "";
		var cloneCount = id.substring(8,10);
		
		OrgCalendarDefaultCountryCompanyCount++;
		
		var countryId = $("#country_" + cloneCount).val();
		var companyId = $("#company_" + cloneCount).val();
		
		var country = $("#country_" + cloneCount + " option:selected").text();
		var company = $("#company_" + cloneCount + " option:selected").text();
		
		if (company != '0') {
			html =	"<div id='country_and_company_data_row_div_" + OrgCalendarDefaultCountryCompanyCount + "'>" +
					"	<div class='col-sm-5 controls'>" +
					"		<input class='form-control' id='country_id_value_" + OrgCalendarDefaultCountryCompanyCount + "' type='hidden' value='" + countryId + "'>" +
					"		<label class='control-label col-sm-8 category_data'>" + country + "</label>" +
					"	</div>" +
					"	<div class='col-sm-5 controls'>" +
					"		<input class='form-control' id='company_id_value_" + OrgCalendarDefaultCountryCompanyCount + "' type='hidden' value='" + companyId + "'>" +
					"		<label class='control-label col-sm-8 category_data'>" + company + "</label>" +
					"	</div>" +
					"	<div class='col-sm-2 controls'>" +
					"		<button class='btn btn-warning' type='button' id='delete_selected_country_and_company_" + OrgCalendarDefaultCountryCompanyCount + "' <?php echo $menuFormatting; ?> onclick='deleteSelectedCountryAndCompany(this.id);'>" +
					"			<i class='icon-save'></i>" +
					"			<?php echo $this->lang->line('Delete') ?>" +
					"		</button>" +
					"	</div>" +
					"	<p style='margin-bottom:-12px'>&nbsp;</p>" +
					"</div>";
			
			$("#country_and_company_data_div_" + cloneCount).append(html);
		}
		
		$("#country_" + cloneCount).select2("enable", false);
		$("#company_" + cloneCount).val('0');
	}
	
	function deleteSelectedCountryAndCompany(id) {
	
		var cloneCount = id.substring(36,38);
		
		$("#country_and_company_data_row_div_" + cloneCount).remove();
		
		var nextCloneCount = parseInt(cloneCount) + 1;
		var currentCloneCount = cloneCount;
			
		while ($("#country_and_company_data_row_div_" + nextCloneCount).length == 1) {

			$("#country_and_company_data_row_div_" + nextCloneCount).prop({ id: "country_and_company_data_row_div_" + currentCloneCount});
			$("#country_id_value_" + nextCloneCount).prop({ id: "country_id_value_" + currentCloneCount});
			$("#company_id_value_" + nextCloneCount).prop({ id: "company_id_value_" + currentCloneCount});
			$("#delete_selected_country_and_company_" + nextCloneCount).prop({ id: "delete_selected_country_and_company_" + currentCloneCount});
			
			currentCloneCount++;
			nextCloneCount++;
		}
		
		OrgCalendarDefaultCountryCompanyCount--;
	}
    
    function handlePeopleAdditionOrthorizationEnableSelect(id) {
		if ($("#ogm_people_addition_need_authorization").prop("checked") == true) {
			$("#ogm_people_addition_authorizer_id").prop("disabled", false);
		} else {
            $("#ogm_people_addition_authorizer_id").val('0');
			$("#ogm_people_addition_authorizer_id").prop("disabled", true);
		}
	}
		
	var SysConfig = {
		
        savePeopleConfigData : function (PeopleAdditionAuthorizerFeatureEnabled, peopleAdditionAuthorizerId) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
        
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller/savePeopleConfigData",
				data: {
					'people_addition_need_authorization_feature_enabled' : PeopleAdditionAuthorizerFeatureEnabled,
                    'people_addition_authorizer_id' : peopleAdditionAuthorizerId,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    window.scrollTo(0,0);
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
					}
				}
			});
		},
		
		//save organization calendar config data
		saveOrganizationCalendarConfigData: function (OrgCalendarDefaultCountryList, OrgCalendarDefaultCompanyList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
        
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller/saveOrganizationCalendarConfigData",
				data: {
					'saturday_calendar_day_type_id': $("#saturday_calendar_day_type_id").val(),
					'sunday_calendar_day_type_id' : $("#sunday_calendar_day_type_id").val(),
					'org_calendar_default_country_list': OrgCalendarDefaultCountryList,
					'org_calendar_default_company_list': OrgCalendarDefaultCompanyList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    window.scrollTo(0,0);
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);
					}
				}
			});
		},
		
		//get organization calendar config data
		getOrganizationCalendarConfigData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller/getOrganizationCalendarConfigData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#saturday_calendar_day_type_id").val(response.saturdayCalendarDayTypeId);
					$("#sunday_calendar_day_type_id").val(response.sundayCalendarDayTypeId);
					$(".validation").hide();
					$(".msg_data").hide();
				}
			});
		},
		
		getOrgCalendarDefaultCountryCompanyData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller/getOrgCalendarDefaultCountryCompanyData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response.countryCount > 0) {
						
						for (count = 1; count <= response.countryCount; count++) {
							
							if (count > 1) {
								addAnotherCountrySelectAndCompanySelect("", (count - 1));
							}
							
							$("#country_and_company_data_div_" + count).append(response.html[count]);
						}
						
						OrgCalendarDefaultCountryCompanyCount = response.rowCount;
					}
				}
			});
		},
		
		//get calendar day type drop down
		getCalendarDayTypeData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller/getAllToCalendarDayTypesDropDownWithoutLabel",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					$('#saturday_calendar_day_type_init').hide();
					$("#saturday_calendar_day_type_dropdown").html(response);
					$("#saturday_calendar_day_type_dropdown").find("#calendar_day_type_id").prop({ id: "saturday_calendar_day_type_id"});

					$('#sunday_calendar_day_type_init').hide();
					$("#sunday_calendar_day_type_dropdown").html(response);
					$("#sunday_calendar_day_type_dropdown").find("#calendar_day_type_id").prop({ id: "sunday_calendar_day_type_id"});
				}
			}).done(function() {
				SysConfig.getOrganizationCalendarConfigData();
			});
		},
		
		//populate organization calendar with current year saturdays and sundays
		populateCurrentYearCalendarWithSaturdaysAndSundays: function () {
		
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
        
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/populateCurrentYearCalendarWithSaturdaysAndSundays",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$("#populate_current_year_calendar_with_saturdays_and_sundays").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    window.scrollTo(0,0);
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$("#populate_current_year_calendar_with_saturdays_and_sundays").attr('disabled', false);
					}
				}
			});
		},
        
        //get welfare shop customer drop down
		getWelfareShopCustomerCategoryData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller/getWelfareShopCustomerCategoryListDropDown",
				data: {
					'type' : 'Add',
                    'show_selected_index' : 'Yes',
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#welfare_shop_customer_category_init').hide();
						$("#welfare_shop_customer_category_dropdown").empty();
						$("#welfare_shop_customer_category_dropdown").html(response);
					}
			});
		},
        
        //get action authorizer drop down
		getActionAuthorizerData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToEmployeeDropDown",
				data: {
                    'check_authority' : "Yes",
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#ogm_people_addition_authorizer_init').hide();
						$("#ogm_people_addition_authorizer_dropdown").empty();
						$("#ogm_people_addition_authorizer_dropdown").html(response);
						$("#people_id").prop({ id: "ogm_people_addition_authorizer_id"});
						$("#ogm_people_addition_authorizer_id").val('0');
					}
			});
		},
        
        //get current people addition authorizer data
		getCurrentPeopleAdditionAuthorizerData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller/getCurrentPeopleAdditionAuthorizerData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						if (response != '0') {
							$("#ogm_people_addition_authorizer_id").val(response);
						} else {
							$("#ogm_people_addition_authorizer_id").val('0');
							$("#ogm_people_addition_authorizer_id").prop("disabled", true);
						}
					}
			});
		}
	}

	function clearForm() {
		$(".validation").hide();
		$(".msg_data").hide();
	}
</script>

<style>
	.config_checkboxes {
		vertical-align: text-bottom;
		margin-right:8px !important;
	}

	.light_color_background {
		background: #eafaea;
	}

	.config_use_status {
		color: #ff4d4d !important;
	}

	hr.light {
		width:97%; 
		margin-left: 15px !important; 
		border:0px none white; 
		border-top:1px solid lightgrey; 
	}
	
	.category_data {
		color: #e68a00 !important;
	}
</style>