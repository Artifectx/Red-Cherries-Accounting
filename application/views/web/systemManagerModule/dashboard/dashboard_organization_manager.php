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

				<div class='page-header page-header-with-buttons'>
					<h1 class='pull-left'>
						<i class='icon-dashboard'></i>
						<span><?php echo $this->lang->line('Organization Dashboard') ?></span>
					</h1>
				</div>
				<?php
				if(isset($OGM_View_module_Permissions)) {
					if (isset($OGM_Admin_View_Calendar_Day_Types_Permissions) || isset($OGM_Admin_View_Calendar_Days_Permissions) ||
						isset($OGM_Admin_View_Locations_Permissions) || isset($OGM_Admin_View_Territories_Permissions) || 
						isset($OGM_Admin_View_People_Permissions)) {
					?>
						<div class='box'>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='text-center'>
										<div class='box'>
											<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
												<ul class="dash">
													<h3 align="left"><?php echo $this->lang->line('Administration') ?></h3>

													<p style="margin-bottom:0px">&nbsp;</p>
													<?php
													if (isset($OGM_Admin_View_Calendar_Day_Types_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller"
															   title="<?php echo $this->lang->line('Calendar Day Types') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/calendar_day_types.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Calendar Day Types') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($OGM_Admin_View_Calendar_Days_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller"
															   title="<?php echo $this->lang->line('Organization Calendar') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/organization_calendar.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Organization Calendar') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($OGM_Admin_View_Locations_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller"
															   title="<?php echo $this->lang->line('Locations') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/location.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Locations') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($OGM_Admin_View_Territories_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/territories_controller"
															   title="<?php echo $this->lang->line('Territories') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/territory.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Territories') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($OGM_Admin_View_People_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller"
															   title="<?php echo $this->lang->line('Peoples') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/suppliers.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('People') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($OGM_Admin_View_Data_Import_Permissions)) {
														?>
														<li class='<?php if ($li_class_data_import) echo $li_class_data_import; else ''; ?>'>			
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/data_import_controller"
															   title="<?php echo $this->lang->line('Data Import') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/data_import.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Data Import') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($OGM_Admin_View_Google_Analytics_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/google_analytics_controller"
															   title="<?php echo $this->lang->line('Google Analytics Settings') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/analytics.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Google Analytics Settings') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($OGM_Admin_View_System_Configurations_Permissions)) {
															?>
															<li>
																<a class="tip"
																   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller"
																   title="<?php echo $this->lang->line('System Configurations') ?>">
																	<i><img src="<?php echo base_url(); ?>assets/images/icons/configurations.png"
																			alt=""/></i>
																	<span><span><?php echo $this->lang->line('System Configurations') ?></span></span>
																</a>
															</li>
															<?php
													}
													?>
													<li>
														<a class="tip"
														   href="<?php echo base_url(); ?>organizationManagerModule/adminSection/admin_help_controller"
														   title="<?php echo $this->lang->line('Help') ?>">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/help.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Help') ?></span></span>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				<?php
					}

					if (isset($OGM_Organization_View_Company_Information_Permissions) || isset($OGM_Organization_View_Company_Structure_Permissions)) {
					?>
						<div class='box'>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='text-center'>
										<div class='box'>
											<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
												<ul class="dash">
													<h3 align="left"><?php echo $this->lang->line('Organization') ?></h3>

													<p style="margin-bottom:0px">&nbsp;</p>
													<?php
													if(isset($OGM_Organization_View_Company_Information_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_information_controller"
															   title="<?php echo $this->lang->line('Company Information') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/company.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Company Information') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($OGM_Organization_View_Company_Structure_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller"
															   title="<?php echo $this->lang->line('Company Structure') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/company_structure.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Company Structure') ?></span></span>
															</a>
														</li>
														<?php
													}
													?>
													<li>
														<a class="tip"
														   href="<?php echo base_url(); ?>organizationManagerModule/organizationSection/organization_help_controller"
														   title="<?php echo $this->lang->line('Help') ?>">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/help.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Help') ?></span></span>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				<?php
					}
				}
				?>