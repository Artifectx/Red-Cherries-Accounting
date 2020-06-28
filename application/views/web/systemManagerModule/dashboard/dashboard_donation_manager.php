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

$moduleSections = $this->user_model->getAllSubModuleSectionsBySystemModuleName('Service Manager', 'Donation Manager', 'module_section_name', 'asc');
$moduleSectionStatus = array();
foreach($moduleSections as $row){
    $moduleSectionStatus[$row->module_section_name] = $row->module_section_status;
}
?>
<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>

				<div class='page-header page-header-with-buttons'>
					<h1 class='pull-left'>
						<i class='icon-dashboard'></i>
						<span><?php echo $this->lang->line('Donation Manager Dashboard') ?></span>
					</h1>
				</div>
				<?php
				if($moduleSectionStatus['Administration']==1 && isset($SVM_DSM_View_Module_Permissions)) {
					if (isset($SVM_DSM_Admin_View_Programs_Permissions)) {
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
													if (isset($SVM_DSM_Admin_View_Programs_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller"
															   title="<?php echo $this->lang->line('Programs') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/programs.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Programs') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($SVM_DSM_Admin_View_System_Configurations_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller"
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
														   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/admin_help_controller"
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

				if($moduleSectionStatus['Donation']==1 && isset($SVM_DSM_View_Module_Permissions)) {
					if (isset($SVM_DSM_Donation_View_Collect_Donations_Permissions) || isset($SVM_DSM_Donation_View_Program_Progress_Permissions)) {
					?>
					<div class='box'>
						<div class='row'>
							<div class='col-sm-12'>
								<div class='text-center'>
									<div class='box'>
										<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
											<ul class="dash">
												<h3 align="left"><?php echo $this->lang->line('Donation Details') ?></h3>

												<p style="margin-bottom:0px">&nbsp;</p>
												<?php
												if (isset($SVM_DSM_Donation_View_Collect_Donations_Permissions)) {
													?>
													<li>
														<a class="tip"
														   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/collect_donations_controller"
														   title="<?php echo $this->lang->line('Collect Donations') ?>">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/collect_donations.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Collect Donations') ?></span></span>
														</a>
													</li>
													<?php
												}
												
												if (isset($SVM_DSM_Donation_View_Program_Progress_Permissions)) {
													?>
													<li>
														<a class="tip"
														   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller"
														   title="<?php echo $this->lang->line('Program Progress') ?>">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/program_progress.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Program Progress') ?></span></span>
														</a>
													</li>
													<?php
												}
												?>
												<li>
													<a class="tip"
													   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/donation_help_controller"
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
				
				if($moduleSectionStatus['Reports']==1 && isset($SVM_DSM_View_Module_Permissions)) {
					if (isset($SVM_DSM_Reports_View_Donation_Report_Permissions)) {
					?>
					<div class='box'>
						<div class='row'>
							<div class='col-sm-12'>
								<div class='text-center'>
									<div class='box'>
										<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
											<ul class="dash">
												<h3 align="left"><?php echo $this->lang->line('Reports') ?></h3>

												<p style="margin-bottom:0px">&nbsp;</p>
												<?php
												if (isset($SVM_DSM_Reports_View_Donation_Report_Permissions)) {
													
													?>
													<li>
														<a class="tip"
														   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/reportsSection/donations_report_controller"
														   title="<?php echo $this->lang->line('Donation Reports') ?>">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/donation_reports.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Donation Reports') ?></span></span>
														</a>
													</li>
													<?php
												}
												?>
												<li>
													<a class="tip"
													   href="<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/reportsSection/donation_reports_help_controller"
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