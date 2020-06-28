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
								<form class='form form-horizontal validate-form'>
									<div class='tabbable' style='margin-top: 20px'>
										<ul class='nav nav-responsive nav-tabs'>
											<li class='active'>
												<a data-toggle='tab' class="tab-header" href='#administration_section_configurations'><?php echo $this->lang->line('Administration') ?></a>
											</li>
											<li class=''>
												<a data-toggle='tab' class="tab-header" href='#donation_section_configurations'><?php echo $this->lang->line('Donation Details') ?></a>
											</li>
										</ul>
										<div class='tab-content'>
											<div id="administration_section_configurations" class="tab-pane active">
												<div class='tabbable' style='margin-top: 20px'>
													<ul class='nav nav-responsive nav-tabs'>
														<li class='active'>
															<a data-toggle='tab' class="tab-header" href='#programs_configurations'><?php echo $this->lang->line('Programs') ?></a>
														</li>
													</ul>
													<div class='tab-content'>	
														<div id="programs_configurations" class="tab-pane active">
															<div class='box'>
																<div class='box-content light_color_background'>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-6 controls'>
                                                                            <input class="config_checkboxes" type="checkbox" name="dod_program_wise_chart_of_account_information" 
                                                                               id="dod_program_wise_chart_of_account_information"
                                                                               <?php if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { echo 'checked ';}?>>
                                                                        <label for="dod_program_wise_chart_of_account_information" ><?php echo $this->lang->line('Enable Program Wise Chart of Account Information Monitoring') ?></label>
                                                                        </div>
                                                                    </div>
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($SVM_DSM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="dod_save_program_config_data">
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
											<div id="donation_section_configurations" class="tab-pane">
												<div class='tabbable' style='margin-top: 20px'>
													<ul class='nav nav-responsive nav-tabs'>
														<li class='active'>
															<a data-toggle='tab' class="tab-header" href='#collect_donations_configurations'><?php echo $this->lang->line('Collect Donations') ?></a>
														</li>
														<li class=''>
															<a data-toggle='tab' class="tab-header" href='#program_progress_configurations'><?php echo $this->lang->line('Program Progress') ?></a>
														</li>
													</ul>
													<div class='tab-content'>	
														<div id="collect_donations_configurations" class="tab-pane active">
															<div class='box'>
																<div class='box-content light_color_background'>

                                                                    <div class='form-group'>
                                                                         <div class='col-sm-12 controls'>
                                                                    <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                                <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select prime entry book/s for account transactions for each program') ?></label>
                                                                <?php		} else { ?>
                                                                                <label style="text-align: left;" class='control-label col-sm-6'><?php echo $this->lang->line('Select prime entry book/s for account transactions') ?></label>
                                                                <?php		} ?>
                                                                         </div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-5'><?php echo $this->lang->line('Program Name') ?></label>
                                                                                <div class='col-sm-7 controls'>
                                                                                    <div id="program_cod_dropdown">
                                                                                    </div>
                                                                                    <div id="program_idError" class="red"></div>
                                                                                </div>			
                                                                            </div>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-5'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
                                                                                <div class='col-sm-7 controls'>
                                                                                    <select id="dod_cod_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                    <!--Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_cod_accounts_prime_entry_book_dropdown">
                                                                                    </div>
                                                                                    <!--End Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_cod_accounts_prime_entry_book_idError" class="red"></div>
                                                                                </div>
                                                                            </div>
                                                            <?php		} else { ?>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
                                                                                <div class='col-sm-5 controls'>
                                                                                    <select id="dod_cod_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                    <!--Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_cod_accounts_prime_entry_book_dropdown">
                                                                                    </div>
                                                                                    <!--End Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_cod_accounts_prime_entry_book_idError" class="red"></div>
                                                                                </div>
                                                                            </div>
                                                            <?php		} ?>
                                                                    </div>

                                                        <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-6 controls' id="dod_cod_program_for_accounts_prime_entry_book_group">

                                                                        </div>
                                                                        <div class='col-sm-6 controls' id="dod_cod_accounts_prime_entry_book_group">

                                                                        </div>
                                                                    </div>
                                                        <?php	} else { ?>
                                                                    <div id="dod_cod_accounts_prime_entry_book_group">

                                                                    </div>		
                                                        <?php	} ?>

																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($SVM_DSM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="dod_save_cod_config_data">
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
														<div id="program_progress_configurations" class="tab-pane">
															<div class='box'>
																<div class='box-content light_color_background'>

                                                                    <!--Budget Issue-->
                                                                    <div class='form-group'>
                                                                         <div class='col-sm-12 controls'>
                                                                    <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                                <label style="text-align: left;" class='control-label col-sm-7'><?php echo $this->lang->line('Select prime entry book/s for account transactions for each program for budget issue') ?></label>
                                                                <?php		} else { ?>
                                                                                <label style="text-align: left;" class='control-label col-sm-7'><?php echo $this->lang->line('Select prime entry book/s for account transactions for program budget issue') ?></label>
                                                                <?php		} ?>
                                                                         </div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-5'><?php echo $this->lang->line('Program Name') ?></label>
                                                                                <div class='col-sm-7 controls'>
                                                                                    <div id="program_bis_dropdown">
                                                                                    </div>
                                                                                    <div id="program_idError" class="red"></div>
                                                                                </div>			
                                                                            </div>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-5'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
                                                                                <div class='col-sm-7 controls'>
                                                                                    <select id="dod_bis_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                    <!--Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_bis_accounts_prime_entry_book_dropdown">
                                                                                    </div>
                                                                                    <!--End Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_bis_accounts_prime_entry_book_idError" class="red"></div>
                                                                                </div>
                                                                            </div>
                                                            <?php		} else { ?>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
                                                                                <div class='col-sm-5 controls'>
                                                                                    <select id="dod_bis_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                    <!--Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_bis_accounts_prime_entry_book_dropdown">
                                                                                    </div>
                                                                                    <!--End Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_bis_accounts_prime_entry_book_idError" class="red"></div>
                                                                                </div>
                                                                            </div>
                                                            <?php		} ?>
                                                                    </div>

                                                        <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                    <div class='form-group'>
                                                                        <div class='col-sm-6 controls' id="dod_bis_program_for_accounts_prime_entry_book_group">

                                                                        </div>
                                                                        <div class='col-sm-6 controls' id="dod_bis_accounts_prime_entry_book_group">

                                                                        </div>
                                                                    </div>
                                                        <?php	} else { ?>
                                                                    <div id="dod_bis_accounts_prime_entry_book_group">

                                                                    </div>		
                                                        <?php	} ?>

                                                                    <!--Budget Return-->
                                                                    <div class='form-group'>
                                                                         <div class='col-sm-12 controls'>
                                                                    <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                                <label style="text-align: left;" class='control-label col-sm-7'><?php echo $this->lang->line('Select prime entry book/s for account transactions for each program for budget return') ?></label>
                                                                <?php		} else { ?>
                                                                                <label style="text-align: left;" class='control-label col-sm-7'><?php echo $this->lang->line('Select prime entry book/s for account transactions for program budget return') ?></label>
                                                                <?php		} ?>
                                                                         </div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                <?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-5'><?php echo $this->lang->line('Program Name') ?></label>
                                                                                <div class='col-sm-7 controls'>
                                                                                    <div id="program_brt_dropdown">
                                                                                    </div>
                                                                                    <div id="program_idError" class="red"></div>
                                                                                </div>			
                                                                            </div>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-5'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
                                                                                <div class='col-sm-7 controls'>
                                                                                    <select id="dod_brt_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                    <!--Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_brt_accounts_prime_entry_book_dropdown">
                                                                                    </div>
                                                                                    <!--End Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_brt_accounts_prime_entry_book_idError" class="red"></div>
                                                                                </div>
                                                                            </div>
                                                            <?php		} else { ?>
                                                                            <div class='col-sm-6 controls'>
                                                                                <label class='control-label col-sm-6'><?php echo $this->lang->line('Accounts Prime Entry Book') ?></label>
                                                                                <div class='col-sm-5 controls'>
                                                                                    <select id="dod_brt_accounts_prime_entry_book_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
                                                                                    <!--Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_brt_accounts_prime_entry_book_dropdown">
                                                                                    </div>
                                                                                    <!--End Accounts Prime Entry Book drop down-->
                                                                                    <div id="dod_brt_accounts_prime_entry_book_idError" class="red"></div>
                                                                                </div>
                                                                            </div>
                                                            <?php		} ?>
                                                                    </div>

															<?php	if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
																		<div class='form-group'>
																			<div class='col-sm-6 controls' id="dod_brt_program_for_accounts_prime_entry_book_group">

																			</div>
																			<div class='col-sm-6 controls' id="dod_brt_accounts_prime_entry_book_group">

																			</div>
																		</div>
															<?php	} else { ?>
																		<div id="dod_brt_accounts_prime_entry_book_group">

																		</div>		
															<?php	} ?>
																		
																	<div class='form-group'>
																		<hr class="light">
																		<div class='col-sm-5'>
																			<?php
																			if (isset($SVM_DSM_Admin_Edit_System_Configurations_Permissions)) {
																				?>
																				<button class='btn btn-success' type='button' id="dod_save_dom_config_data">
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

	var DODProgramWiseChartOfAccountInformation = "No";
	var ValidationErrorsFoundInCurrentActivity = false;
	
	$(document).ready(function() {
		SysConfig.getProgramList();
		SysConfig.getCollectDonationAccountsPrimeEntryBookData();
		
		<?php 
		if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
			SysConfig.getProgramWiseCollectDonationAccountsPrimeEntryBookConfigurationData();
			SysConfig.getProgramWiseBudgetIssueAccountsPrimeEntryBookConfigurationData();
			SysConfig.getProgramWiseBudgetReturnAccountsPrimeEntryBookConfigurationData();
		<?php 
		} else { ?>
			SysConfig.getCollectDonationAccountsPrimeEntryBookConfigurationData();
			SysConfig.getBudgetIssueAccountsPrimeEntryBookConfigurationData();
			SysConfig.getBudgetReturnAccountsPrimeEntryBookConfigurationData();
		<?php 
		} ?>
	});

	$("#dod_save_program_config_data").click(function () {
		if ($("#dod_program_wise_chart_of_account_information").prop("checked") == true) {
			DODProgramWiseChartOfAccountInformation = "Yes";
		} else {
			DODProgramWiseChartOfAccountInformation = "No";
		}
		
		SysConfig.saveProgramConfigData();
	});
	
	$("#dod_save_cod_config_data").click(function () {
		
		<?php  
		if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
			var validationErrorsExists = false;
			var AccountsPrimeEntryBookList = {};

			var cloneCount = 1;
			var element = $("#dod_cod_program_for_accounts_prime_entry_book_group").find("#dod_cod_program_for_accounts_prime_entry_book_1");

			while (element.length == 1) {
				
				if (validateForm_savePrimeEntryBookDataForCollectDonation(cloneCount)) {
					AccountsPrimeEntryBookList[$("#dod_cod_program_for_accounts_prime_entry_book_"+cloneCount).val()] = $("#dod_cod_accounts_prime_entry_book_"+cloneCount).val();
				} else {
					validationErrorsExists = true;
					ValidationErrorsFoundInCurrentActivity = true;
					break;
				}
				
				cloneCount++;
				element = $("#dod_cod_program_for_accounts_prime_entry_book_group").find("#dod_cod_program_for_accounts_prime_entry_book_" + cloneCount);
			}

			if (validationErrorsExists == false) {
				if (validateForm_selectPrimeEntryBook()) {
					$("#dod_cod_accounts_prime_entry_book_id").val('0');
					SysConfig.saveCollectDonationConfigData(AccountsPrimeEntryBookList);
				}
			}
		<?php 
		} else { ?>
			var AccountsPrimeEntryBookList = {};

			var cloneCount = 1;
			var element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_1");

			while (element.length == 1) {
				//AccountsPrimeEntryBookList.push($("#dod_cod_accounts_prime_entry_book_"+cloneCount).val());
				AccountsPrimeEntryBookList[cloneCount] = $("#dod_cod_accounts_prime_entry_book_"+cloneCount).val();
				cloneCount++;
				element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_" + cloneCount);
			}

			SysConfig.saveCollectDonationConfigData(AccountsPrimeEntryBookList);
		<?php 
		} ?>
	});
	
	$("#dod_save_dom_config_data").click(function () {
		
		<?php  
		if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
			//Budget Issue
			var validationErrorsExists = false;
			var AccountsPrimeEntryBookList = {};

			var cloneCount = 1;
			var element = $("#dod_bis_program_for_accounts_prime_entry_book_group").find("#dod_bis_program_for_accounts_prime_entry_book_1");

			while (element.length == 1) {
				
				if (validateForm_savePrimeEntryBookDataForBudgetIssue(cloneCount)) {
					AccountsPrimeEntryBookList[$("#dod_bis_program_for_accounts_prime_entry_book_"+cloneCount).val()] = $("#dod_bis_accounts_prime_entry_book_"+cloneCount).val();
				} else {
					validationErrorsExists = true;
					ValidationErrorsFoundInCurrentActivity = true;
					break;
				}
				
				cloneCount++;
				element = $("#dod_bis_program_for_accounts_prime_entry_book_group").find("#dod_bis_program_for_accounts_prime_entry_book_" + cloneCount);
			}

			if (validationErrorsExists == false) {
				if (validateForm_selectPrimeEntryBook()) {
					$("#dod_bis_accounts_prime_entry_book_id").val('0');
					SysConfig.saveBudgetIssueConfigData(AccountsPrimeEntryBookList);
				}
			}
			
			//Budget Return
			var validationErrorsExists = false;
			var AccountsPrimeEntryBookList = {};

			var cloneCount = 1;
			var element = $("#dod_brt_program_for_accounts_prime_entry_book_group").find("#dod_brt_program_for_accounts_prime_entry_book_1");

			while (element.length == 1) {
				
				if (validateForm_savePrimeEntryBookDataForBudgetReturn(cloneCount)) {
					AccountsPrimeEntryBookList[$("#dod_brt_program_for_accounts_prime_entry_book_"+cloneCount).val()] = $("#dod_brt_accounts_prime_entry_book_"+cloneCount).val();
				} else {
					validationErrorsExists = true;
					ValidationErrorsFoundInCurrentActivity = true;
					break;
				}
				
				cloneCount++;
				element = $("#dod_brt_program_for_accounts_prime_entry_book_group").find("#dod_brt_program_for_accounts_prime_entry_book_" + cloneCount);
			}

			if (validationErrorsExists == false) {
				if (validateForm_selectPrimeEntryBook()) {
					$("#dod_brt_accounts_prime_entry_book_id").val('0');
					SysConfig.saveBudgetReturnConfigData(AccountsPrimeEntryBookList);
				}
			}
		<?php 
		} else { ?>
			//Budget Issue
			var AccountsPrimeEntryBookList = {};

			var cloneCount = 1;
			var element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_1");

			while (element.length == 1) {
				//AccountsPrimeEntryBookList.push($("#dod_bis_accounts_prime_entry_book_"+cloneCount).val());
				AccountsPrimeEntryBookList[cloneCount] = $("#dod_bis_accounts_prime_entry_book_"+cloneCount).val();
				cloneCount++;
				element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_" + cloneCount);
			}

			SysConfig.saveBudgetIssueConfigData(AccountsPrimeEntryBookList);
			
			//Budget Return
			var AccountsPrimeEntryBookList = {};

			var cloneCount = 1;
			var element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_1");

			while (element.length == 1) {
				//AccountsPrimeEntryBookList.push($("#dod_brt_accounts_prime_entry_book_"+cloneCount).val());
				AccountsPrimeEntryBookList[cloneCount] = $("#dod_brt_accounts_prime_entry_book_"+cloneCount).val();
				cloneCount++;
				element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_" + cloneCount);
			}

			SysConfig.saveBudgetReturnConfigData(AccountsPrimeEntryBookList);
		<?php 
		} ?>
	});
	
	function handlePrimeEntryBookSelect(id) {

		var idParts = id.split("_");

		clearForm();
		var cloneCount = 1;
		var PrimeEntryBookAlreadySelected = false;
		
		<?php  
		if ($systemConfigData['dod_program_wise_chart_of_account_information'] == "Yes") { ?>
			if (idParts[0] == 'dod') {
				if (idParts[1] == 'cod') {
					var SelectedPrimeEntryBookId = $("#dod_cod_accounts_prime_entry_book_id").val();
					var SelectedPrimeEntryBookName = $("#dod_cod_accounts_prime_entry_book_id option:selected").text();

					var element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_1");

					while (element.length == 1) {
						if ($("#dod_cod_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
							PrimeEntryBookAlreadySelected = true;
						}
						cloneCount++;
						element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_" + cloneCount);
					}

					if (validateForm_selectPrimeEntryBookForProgramForCollectDonation(cloneCount) && SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
						var NewCategoryhtml = ' <div class="form-group" id="dod_cod_accounts_prime_entry_book_row_'+cloneCount+'">'+
													'<input class="form-control" id="dod_cod_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
													'<div class="col-sm-12 controls">'+
														'<label class="control-label col-sm-9 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
														'<div class="col-sm-2 controls">'+
															'<button class="btn btn-success" type="button" id="dod_cod_delete_accounts_prime_entry_book_'+cloneCount+'"'+
																'onclick="removeAccountsPrimeEntryBook(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
													'</div>'+
												'</div>';

						//$("#dod_cod_accounts_prime_entry_book_id").val('0');
						$("#dod_cod_program_for_accounts_prime_entry_book_id").val('0');
						$("#dod_cod_accounts_prime_entry_book_group").append(NewCategoryhtml);
					} else {
						if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected) {
							alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
							$("#dod_cod_accounts_prime_entry_book_id").val('0');
						}
					}
				} else if (idParts[1] == 'bis') {
					var SelectedPrimeEntryBookId = $("#dod_bis_accounts_prime_entry_book_id").val();
					var SelectedPrimeEntryBookName = $("#dod_bis_accounts_prime_entry_book_id option:selected").text();

					var element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_1");

					while (element.length == 1) {
						if ($("#dod_bis_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
							PrimeEntryBookAlreadySelected = true;
						}
						cloneCount++;
						element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_" + cloneCount);
					}

					if (validateForm_selectPrimeEntryBookForProgramForBudgetIssue(cloneCount) && SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
						var NewCategoryhtml = ' <div class="form-group" id="dod_bis_accounts_prime_entry_book_row_'+cloneCount+'">'+
													'<input class="form-control" id="dod_bis_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
													'<div class="col-sm-12 controls">'+
														'<label class="control-label col-sm-9 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
														'<div class="col-sm-2 controls">'+
															'<button class="btn btn-success" type="button" id="dod_bis_delete_accounts_prime_entry_book_'+cloneCount+'"'+
																'onclick="removeAccountsPrimeEntryBook(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
													'</div>'+
												'</div>';

						//$("#dod_bis_accounts_prime_entry_book_id").val('0');
						$("#dod_bis_program_for_accounts_prime_entry_book_id").val('0');
						$("#dod_bis_accounts_prime_entry_book_group").append(NewCategoryhtml);
					} else {
						if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected) {
							alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
							$("#dod_bis_accounts_prime_entry_book_id").val('0');
						}
					}
				} else if (idParts[1] == 'brt') {
					var SelectedPrimeEntryBookId = $("#dod_brt_accounts_prime_entry_book_id").val();
					var SelectedPrimeEntryBookName = $("#dod_brt_accounts_prime_entry_book_id option:selected").text();

					var element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_1");

					while (element.length == 1) {
						if ($("#dod_brt_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
							PrimeEntryBookAlreadySelected = true;
						}
						cloneCount++;
						element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_" + cloneCount);
					}

					if (validateForm_selectPrimeEntryBookForProgramForBudgetReturn(cloneCount) && SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
						var NewCategoryhtml = ' <div class="form-group" id="dod_brt_accounts_prime_entry_book_row_'+cloneCount+'">'+
													'<input class="form-control" id="dod_brt_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
													'<div class="col-sm-12 controls">'+
														'<label class="control-label col-sm-9 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
														'<div class="col-sm-2 controls">'+
															'<button class="btn btn-success" type="button" id="dod_brt_delete_accounts_prime_entry_book_'+cloneCount+'"'+
																'onclick="removeAccountsPrimeEntryBook(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
													'</div>'+
												'</div>';

						//$("#dod_brt_accounts_prime_entry_book_id").val('0');
						$("#dod_brt_program_for_accounts_prime_entry_book_id").val('0');
						$("#dod_brt_accounts_prime_entry_book_group").append(NewCategoryhtml);
					} else {
						if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected) {
							alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
							$("#dod_brt_accounts_prime_entry_book_id").val('0');
						}
					}
				}
			}
		<?php 
		} else { ?>
			if (idParts[0] == 'dod') {
				if (idParts[1] == 'cod') {
					var SelectedPrimeEntryBookId = $("#dod_cod_accounts_prime_entry_book_id").val();
					var SelectedPrimeEntryBookName = $("#dod_cod_accounts_prime_entry_book_id option:selected").text();

					var element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_1");

					while (element.length == 1) {
						if ($("#dod_cod_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
							PrimeEntryBookAlreadySelected = true;
						}
						cloneCount++;
						element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_" + cloneCount);
					}

					if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
						var NewCategoryhtml = ' <div class="form-group" id="dod_cod_accounts_prime_entry_book_row_'+cloneCount+'">'+
													'<input class="form-control" id="dod_cod_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
													'<div class="col-sm-6 controls">'+
														'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
														'<div class="col-sm-2 controls">'+
															'<button class="btn btn-success" type="button" id="dod_cod_delete_accounts_prime_entry_book_'+cloneCount+'"'+
																'onclick="removeAccountsPrimeEntryBook(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
													'</div>'+
												'</div>';

						$("#dod_cod_accounts_prime_entry_book_id").val('0');
						$("#dod_cod_accounts_prime_entry_book_group").append(NewCategoryhtml);
					} else {
						if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected) {
							alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
							$("#dod_cod_accounts_prime_entry_book_id").val('0');
						}
					}
				} else if (idParts[1] == 'bis') {
					var SelectedPrimeEntryBookId = $("#dod_bis_accounts_prime_entry_book_id").val();
					var SelectedPrimeEntryBookName = $("#dod_bis_accounts_prime_entry_book_id option:selected").text();

					var element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_1");

					while (element.length == 1) {
						if ($("#dod_bis_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
							PrimeEntryBookAlreadySelected = true;
						}
						cloneCount++;
						element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_" + cloneCount);
					}

					if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
						var NewCategoryhtml = ' <div class="form-group" id="dod_bis_accounts_prime_entry_book_row_'+cloneCount+'">'+
													'<input class="form-control" id="dod_bis_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
													'<div class="col-sm-6 controls">'+
														'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
														'<div class="col-sm-2 controls">'+
															'<button class="btn btn-success" type="button" id="dod_bis_delete_accounts_prime_entry_book_'+cloneCount+'"'+
																'onclick="removeAccountsPrimeEntryBook(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
													'</div>'+
												'</div>';

						$("#dod_bis_accounts_prime_entry_book_id").val('0');
						$("#dod_bis_accounts_prime_entry_book_group").append(NewCategoryhtml);
					} else {
						if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected) {
							alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
							$("#dod_bis_accounts_prime_entry_book_id").val('0');
						}
					}
				} else if (idParts[1] == 'brt') {
					var SelectedPrimeEntryBookId = $("#dod_brt_accounts_prime_entry_book_id").val();
					var SelectedPrimeEntryBookName = $("#dod_brt_accounts_prime_entry_book_id option:selected").text();

					var element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_1");

					while (element.length == 1) {
						if ($("#dod_brt_accounts_prime_entry_book_" + cloneCount).val() == SelectedPrimeEntryBookId) {
							PrimeEntryBookAlreadySelected = true;
						}
						cloneCount++;
						element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_" + cloneCount);
					}

					if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected == false) {
						var NewCategoryhtml = ' <div class="form-group" id="dod_brt_accounts_prime_entry_book_row_'+cloneCount+'">'+
													'<input class="form-control" id="dod_brt_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedPrimeEntryBookId+'">'+
													'<div class="col-sm-6 controls">'+
														'<label class="control-label col-sm-6 prime_entry_book_data">'+SelectedPrimeEntryBookName+'</label>'+
														'<div class="col-sm-2 controls">'+
															'<button class="btn btn-success" type="button" id="dod_brt_delete_accounts_prime_entry_book_'+cloneCount+'"'+
																'onclick="removeAccountsPrimeEntryBook(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
													'</div>'+
												'</div>';

						$("#dod_brt_accounts_prime_entry_book_id").val('0');
						$("#dod_brt_accounts_prime_entry_book_group").append(NewCategoryhtml);
					} else {
						if (SelectedPrimeEntryBookId != 0 && PrimeEntryBookAlreadySelected) {
							alert("<?php echo $this->lang->line('Prime entry book already selected') ?>");
							$("#dod_brt_accounts_prime_entry_book_id").val('0');
						}
					}
				}
			}
		<?php 
		} ?>
	}
	
	function handleProgramSelect(id) {
		
		var idParts = id.split("_");

		clearForm();
		var cloneCount = 1;
		var ProgramAlreadySelected = false;
		
		if (idParts[0] == 'dod') {
			if (idParts[1] == 'cod') {
				var SelectedProgramId = $("#dod_cod_program_for_accounts_prime_entry_book_id").val();
				var SelectedProgramName = $("#dod_cod_program_for_accounts_prime_entry_book_id option:selected").text();

				var element = $("#dod_cod_program_for_accounts_prime_entry_book_group").find("#dod_cod_program_for_accounts_prime_entry_book_1");

				while (element.length == 1) {
					if ($("#dod_cod_program_for_accounts_prime_entry_book_" + cloneCount).val() == SelectedProgramId) {
						ProgramAlreadySelected = true;
					}
					cloneCount++;
					element = $("#dod_cod_program_for_accounts_prime_entry_book_group").find("#dod_cod_program_for_accounts_prime_entry_book_" + cloneCount);
				}

				if (validateForm_selectProgramForCollectDonation() && SelectedProgramId != 0 && ProgramAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="dod_cod_program_for_accounts_prime_entry_book_row_'+cloneCount+'">'+
												'<input class="form-control" id="dod_cod_program_for_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedProgramId+'">'+
												'<div class="col-sm-12 controls">'+
													'<label class="control-label col-sm-11 program_data">'+SelectedProgramName+'</label>'+
													'<div class="col-sm-1 controls">'+
															'<button class="btn btn-success" type="button" id="dod_cod_delete_program_for_accounts_prime_entry_book_'+cloneCount+'" style="visibility : hidden"'+
																'onclick="removeProgram(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
												'</div>'+
											'</div>';

					$("#dod_cod_accounts_prime_entry_book_id").val('0');
					$("#dod_cod_program_for_accounts_prime_entry_book_group").append(NewCategoryhtml);
				} else {
					if (SelectedProgramId != 0 && ProgramAlreadySelected) {
						alert("<?php echo $this->lang->line('Program already selected') ?>");
						$("#dod_cod_program_for_accounts_prime_entry_book_id").val('0');
					}
				}
			} else if (idParts[1] == 'bis') {
				var SelectedProgramId = $("#dod_bis_program_for_accounts_prime_entry_book_id").val();
				var SelectedProgramName = $("#dod_bis_program_for_accounts_prime_entry_book_id option:selected").text();

				var element = $("#dod_bis_program_for_accounts_prime_entry_book_group").find("#dod_bis_program_for_accounts_prime_entry_book_1");

				while (element.length == 1) {
					if ($("#dod_bis_program_for_accounts_prime_entry_book_" + cloneCount).val() == SelectedProgramId) {
						ProgramAlreadySelected = true;
					}
					cloneCount++;
					element = $("#dod_bis_program_for_accounts_prime_entry_book_group").find("#dod_bis_program_for_accounts_prime_entry_book_" + cloneCount);
				}

				if (validateForm_selectProgramForBudgetIssue() && SelectedProgramId != 0 && ProgramAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="dod_bis_program_for_accounts_prime_entry_book_row_'+cloneCount+'">'+
												'<input class="form-control" id="dod_bis_program_for_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedProgramId+'">'+
												'<div class="col-sm-12 controls">'+
													'<label class="control-label col-sm-11 program_data">'+SelectedProgramName+'</label>'+
													'<div class="col-sm-1 controls">'+
															'<button class="btn btn-success" type="button" id="dod_bis_delete_program_for_accounts_prime_entry_book_'+cloneCount+'" style="visibility : hidden"'+
																'onclick="removeProgram(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
												'</div>'+
											'</div>';

					$("#dod_bis_accounts_prime_entry_book_id").val('0');
					$("#dod_bis_program_for_accounts_prime_entry_book_group").append(NewCategoryhtml);
				} else {
					if (SelectedProgramId != 0 && ProgramAlreadySelected) {
						alert("<?php echo $this->lang->line('Program already selected') ?>");
						$("#dod_bis_program_for_accounts_prime_entry_book_id").val('0');
					}
				}
			} else if (idParts[1] == 'brt') {
				var SelectedProgramId = $("#dod_brt_program_for_accounts_prime_entry_book_id").val();
				var SelectedProgramName = $("#dod_brt_program_for_accounts_prime_entry_book_id option:selected").text();

				var element = $("#dod_brt_program_for_accounts_prime_entry_book_group").find("#dod_brt_program_for_accounts_prime_entry_book_1");

				while (element.length == 1) {
					if ($("#dod_brt_program_for_accounts_prime_entry_book_" + cloneCount).val() == SelectedProgramId) {
						ProgramAlreadySelected = true;
					}
					cloneCount++;
					element = $("#dod_brt_program_for_accounts_prime_entry_book_group").find("#dod_brt_program_for_accounts_prime_entry_book_" + cloneCount);
				}

				if (validateForm_selectProgramForBudgetReturn() && SelectedProgramId != 0 && ProgramAlreadySelected == false) {
					var NewCategoryhtml = ' <div class="form-group" id="dod_brt_program_for_accounts_prime_entry_book_row_'+cloneCount+'">'+
												'<input class="form-control" id="dod_brt_program_for_accounts_prime_entry_book_'+cloneCount+'" type="hidden" value="'+SelectedProgramId+'">'+
												'<div class="col-sm-12 controls">'+
													'<label class="control-label col-sm-11 program_data">'+SelectedProgramName+'</label>'+
													'<div class="col-sm-1 controls">'+
															'<button class="btn btn-success" type="button" id="dod_brt_delete_program_for_accounts_prime_entry_book_'+cloneCount+'" style="visibility : hidden"'+
																'onclick="removeProgram(this.id)">'+
																'<i class="icon-save"></i>'+
																'<?php echo $this->lang->line('Delete') ?>'+
															'</button>'+
														'</div>'+
												'</div>'+
											'</div>';

					$("#dod_brt_accounts_prime_entry_book_id").val('0');
					$("#dod_brt_program_for_accounts_prime_entry_book_group").append(NewCategoryhtml);
				} else {
					if (SelectedProgramId != 0 && ProgramAlreadySelected) {
						alert("<?php echo $this->lang->line('Program already selected') ?>");
						$("#dod_brt_program_for_accounts_prime_entry_book_id").val('0');
					}
				}
			}
		}
	}

	function removeAccountsPrimeEntryBook(id) {
		var idParts = id.split("_");

		if (idParts[0] == 'dod') {
			if (idParts[1] == 'cod') {
				var value = id.substring(41,43);

				//Remove the prime entry book
				$("#dod_cod_accounts_prime_entry_book_row_"+value).remove();

				var cloneCount = '';
				var element = '';

				cloneCount = parseInt(value) + 1;
				element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_row_"+cloneCount);

				while (element.length == 1) {
					$("#dod_cod_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "dod_cod_accounts_prime_entry_book_row_" + (cloneCount - 1)});
					$("#dod_cod_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_cod_accounts_prime_entry_book_" + (cloneCount - 1)});
					$("#dod_cod_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_cod_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
					cloneCount++;
					element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_row_" + cloneCount);
				}
				
				//Remove the program
				$("#dod_cod_program_for_accounts_prime_entry_book_row_"+value).remove();

				var cloneCount = '';
				var element = '';

				cloneCount = parseInt(value) + 1;
				element = $("#dod_cod_program_for_accounts_prime_entry_book_group").find("#dod_cod_program_for_accounts_prime_entry_book_row_"+cloneCount);

				while (element.length == 1) {
					$("#dod_cod_program_for_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "dod_cod_program_for_accounts_prime_entry_book_row_" + (cloneCount - 1)});
					$("#dod_cod_program_for_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_cod_program_for_accounts_prime_entry_book_" + (cloneCount - 1)});
					$("#dod_cod_program_for_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_cod_program_for_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
					cloneCount++;
					element = $("#dod_cod_program_for_accounts_prime_entry_book_group").find("#dod_cod_program_for_accounts_prime_entry_book_row_" + cloneCount);
				}
			} else if (idParts[1] == 'bis') {
				var value = id.substring(41,43);

				//Remove the prime entry book
				$("#dod_bis_accounts_prime_entry_book_row_"+value).remove();

				var cloneCount = '';
				var element = '';

				cloneCount = parseInt(value) + 1;
				element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_row_"+cloneCount);

				while (element.length == 1) {
					$("#dod_bis_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "dod_bis_accounts_prime_entry_book_row_" + (cloneCount - 1)});
					$("#dod_bis_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_bis_accounts_prime_entry_book_" + (cloneCount - 1)});
					$("#dod_bis_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_bis_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
					cloneCount++;
					element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_row_" + cloneCount);
				}
				
				//Remove the program
				$("#dod_bis_program_for_accounts_prime_entry_book_row_"+value).remove();

				var cloneCount = '';
				var element = '';

				cloneCount = parseInt(value) + 1;
				element = $("#dod_bis_program_for_accounts_prime_entry_book_group").find("#dod_bis_program_for_accounts_prime_entry_book_row_"+cloneCount);

				while (element.length == 1) {
					$("#dod_bis_program_for_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "dod_bis_program_for_accounts_prime_entry_book_row_" + (cloneCount - 1)});
					$("#dod_bis_program_for_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_bis_program_for_accounts_prime_entry_book_" + (cloneCount - 1)});
					$("#dod_bis_program_for_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_bis_program_for_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
					cloneCount++;
					element = $("#dod_bis_program_for_accounts_prime_entry_book_group").find("#dod_bis_program_for_accounts_prime_entry_book_row_" + cloneCount);
				}
			} else if (idParts[1] == 'brt') {
				var value = id.substring(41,43);

				//Remove the prime entry book
				$("#dod_brt_accounts_prime_entry_book_row_"+value).remove();

				var cloneCount = '';
				var element = '';

				cloneCount = parseInt(value) + 1;
				element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_row_"+cloneCount);

				while (element.length == 1) {
					$("#dod_brt_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "dod_brt_accounts_prime_entry_book_row_" + (cloneCount - 1)});
					$("#dod_brt_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_brt_accounts_prime_entry_book_" + (cloneCount - 1)});
					$("#dod_brt_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_brt_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
					cloneCount++;
					element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_row_" + cloneCount);
				}
				
				//Remove the program
				$("#dod_brt_program_for_accounts_prime_entry_book_row_"+value).remove();

				var cloneCount = '';
				var element = '';

				cloneCount = parseInt(value) + 1;
				element = $("#dod_brt_program_for_accounts_prime_entry_book_group").find("#dod_brt_program_for_accounts_prime_entry_book_row_"+cloneCount);

				while (element.length == 1) {
					$("#dod_brt_program_for_accounts_prime_entry_book_row_"+cloneCount).prop({ id: "dod_brt_program_for_accounts_prime_entry_book_row_" + (cloneCount - 1)});
					$("#dod_brt_program_for_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_brt_program_for_accounts_prime_entry_book_" + (cloneCount - 1)});
					$("#dod_brt_program_for_delete_accounts_prime_entry_book_"+cloneCount).prop({ id: "dod_brt_program_for_delete_accounts_prime_entry_book_" + (cloneCount - 1)});
					cloneCount++;
					element = $("#dod_brt_program_for_accounts_prime_entry_book_group").find("#dod_brt_program_for_accounts_prime_entry_book_row_" + cloneCount);
				}
			}
		}
	}

	var SysConfig = {

		//save finish good opening stock config data
		saveCollectDonationConfigData: function (AccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/saveCollectDonationConfigData",
				data: {
					'dod_cod_accounts_prime_entry_book_list': AccountsPrimeEntryBookList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
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
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		saveBudgetIssueConfigData: function (AccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/saveBudgetIssueConfigData",
				data: {
					'dod_bis_accounts_prime_entry_book_list': AccountsPrimeEntryBookList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
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
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		saveBudgetReturnConfigData: function (AccountsPrimeEntryBookList) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/saveBudgetReturnConfigData",
				data: {
					'dod_brt_accounts_prime_entry_book_list': AccountsPrimeEntryBookList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
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
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//save program config data
		saveProgramConfigData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/saveProgramConfigData",
				data: {
					'dod_program_wise_chart_of_account_information' : DODProgramWiseChartOfAccountInformation,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
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
						window.scrollTo(0,0);
					}
				}
			});
		},
		
		//get accounts prime entry books drop down
		getCollectDonationAccountsPrimeEntryBookData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/prime_entry_book_controller/getAllPrimeEntryBookOptionsToDropDown",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#dod_cod_accounts_prime_entry_book_init').hide();
						$("#dod_cod_accounts_prime_entry_book_dropdown").empty();
						$("#dod_cod_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "dod_cod_accounts_prime_entry_book_id"});

						$('#dod_bis_accounts_prime_entry_book_init').hide();
						$("#dod_bis_accounts_prime_entry_book_dropdown").empty();
						$("#dod_bis_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "dod_bis_accounts_prime_entry_book_id"});
						
						$('#dod_brt_accounts_prime_entry_book_init').hide();
						$("#dod_brt_accounts_prime_entry_book_dropdown").empty();
						$("#dod_brt_accounts_prime_entry_book_dropdown").html(response);
						$("#prime_entry_book_id").prop({ id: "dod_brt_accounts_prime_entry_book_id"});
					}
			});
		},
		
		getProgramWiseCollectDonationAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/getProgramWiseCollectDonationAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#dod_cod_program_for_accounts_prime_entry_book_group").append(response.programData);
					$("#dod_cod_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		getProgramWiseBudgetIssueAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/getProgramWiseBudgetIssueAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#dod_bis_program_for_accounts_prime_entry_book_group").append(response.programData);
					$("#dod_bis_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		getProgramWiseBudgetReturnAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/getProgramWiseBudgetReturnAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#dod_brt_program_for_accounts_prime_entry_book_group").append(response.programData);
					$("#dod_brt_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		getCollectDonationAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/getCollectDonationAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#dod_cod_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
		},
		
		getBudgetIssueAccountsPrimeEntryBookConfigurationData : function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller/getBudgetIssueAccountsPrimeEntryBookConfigurationData",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					$("#dod_bis_accounts_prime_entry_book_group").append(response.accountsPrimeEntryBookData);
				}
			});
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
					$("#program_cod_dropdown").html(response);
					$("#program_id").prop({ id: "dod_cod_program_for_accounts_prime_entry_book_id"});
					$("#program_idError").prop({ id: "dod_cod_program_for_accounts_prime_entry_book_idError"});
					
					$("#program_bis_dropdown").html(response);
					$("#program_id").prop({ id: "dod_bis_program_for_accounts_prime_entry_book_id"});
					$("#program_idError").prop({ id: "dod_bis_program_for_accounts_prime_entry_book_idError"});
					
					$("#program_brt_dropdown").html(response);
					$("#program_id").prop({ id: "dod_brt_program_for_accounts_prime_entry_book_id"});
					$("#program_idError").prop({ id: "dod_brt_program_for_accounts_prime_entry_book_idError"});
				}
			});
		}
	}
	
	//form validation save
	function validateForm_selectPrimeEntryBookForProgramForCollectDonation(count) {
		var element = $("#dod_cod_program_for_accounts_prime_entry_book_group").find("#dod_cod_program_for_accounts_prime_entry_book_" + count);
		
		if (element.length == '0') {
			$("#dod_cod_accounts_prime_entry_book_id").val('0');
			return (isSelected("dod_cod_program_for_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a program')?>"));
		} else {
			return true;
		}
	}
	
	//form validation save
	function validateForm_selectPrimeEntryBookForProgramForBudgetIssue(count) {
		var element = $("#dod_bis_program_for_accounts_prime_entry_book_group").find("#dod_bis_program_for_accounts_prime_entry_book_" + count);
		
		if (element.length == '0') {
			$("#dod_bis_accounts_prime_entry_book_id").val('0');
			return (isSelected("dod_bis_program_for_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a program')?>"));
		} else {
			return true;
		}
	}
	
	//form validation save
	function validateForm_selectPrimeEntryBookForProgramForBudgetReturn(count) {
		var element = $("#dod_brt_program_for_accounts_prime_entry_book_group").find("#dod_brt_program_for_accounts_prime_entry_book_" + count);
		
		if (element.length == '0') {
			$("#dod_brt_accounts_prime_entry_book_id").val('0');
			return (isSelected("dod_brt_program_for_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a program')?>"));
		} else {
			return true;
		}
	}
	
	//form validation save
	function validateForm_savePrimeEntryBookDataForCollectDonation(count) {
		var element = $("#dod_cod_accounts_prime_entry_book_group").find("#dod_cod_accounts_prime_entry_book_" + count);
		
		if (element.length == '0') {
			return (isSelected("dod_cod_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a prime entry book')?>"));
		} else {
			return true;
		}
	}
	
	//form validation save
	function validateForm_savePrimeEntryBookDataForBudgetIssue(count) {
		var element = $("#dod_bis_accounts_prime_entry_book_group").find("#dod_bis_accounts_prime_entry_book_" + count);
		
		if (element.length == '0') {
			return (isSelected("dod_bis_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a prime entry book')?>"));
		} else {
			return true;
		}
	}
	
	//form validation save
	function validateForm_savePrimeEntryBookDataForBudgetReturn(count) {
		var element = $("#dod_brt_accounts_prime_entry_book_group").find("#dod_brt_accounts_prime_entry_book_" + count);
		
		if (element.length == '0') {
			return (isSelected("dod_brt_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a prime entry book')?>"));
		} else {
			return true;
		}
	}
	
	//form validation save
	function validateForm_selectProgramForCollectDonation() {
		return (isSelected("dod_cod_program_for_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a program')?>"));
	}
	
	//form validation save
	function validateForm_selectProgramForBudgetIssue() {
		return (isSelected("dod_bis_program_for_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a program')?>"));
	}
	
	//form validation save
	function validateForm_selectProgramForBudgetReturn() {
		return (isSelected("dod_brt_program_for_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a program')?>"));
	}
	
	//form validation save
	function validateForm_selectPrimeEntryBook() {
		if (ValidationErrorsFoundInCurrentActivity == true) {
			return (isSelected("dod_cod_accounts_prime_entry_book_id", "<?php echo $this->lang->line('Please select a prime entry book')?>"));
		} else {
			return true;
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

	hr.light {
		width:97%; 
		margin-left: 15px !important; 
		border:0px none white; 
		border-top:1px solid lightgrey; 
	}

	.prime_entry_book_data, .program_data {
		color: #e68a00 !important;
	}
</style>