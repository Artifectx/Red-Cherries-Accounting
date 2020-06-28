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

//Administration Section
if (isset($ul_class_administration_section)) $ul_class_administration = $ul_class_administration_section;
else $ul_class_administration = 'nav nav-stacked';

//Donation Details Section
if (isset($ul_class_donation_section)) $ul_class_donation = $ul_class_donation_section;
else $ul_class_donation = 'nav nav-stacked';

//Reports Section
  if (isset($ul_class_report_section)) $ul_class_report = $ul_class_report_section;
  else $ul_class_report = 'nav nav-stacked';

?>
<div id='wrapper'>
	<div id='main-nav-bg'></div>
	<nav id='main-nav'>
		<div class='navigation'>
			<ul class='nav nav-stacked'>
				<li class='active'>
					<a class="menuBox" href='<?php echo base_url(); ?>systemManagerModule/dashboard_controller/dashboardDonationManager'>
						<i class='icon-dashboard' ></i>
						<span><?php echo $this->lang->line('Dashboard - Donation Manager') ?></span>
					</a>
				</li>
				<?php
				if($moduleSectionStatus['Administration'] == 1 && isset($SVM_DSM_View_Module_Permissions)) {
					if (isset($SVM_DSM_Admin_View_Programs_Permissions)) {
						?>
						<li class=''>
							<a class="dropdown-collapse menuBox" href="#"><i class='icon-briefcase'></i>
								<span><?php echo $this->lang->line('Administration') ?></span>
								<i class='icon-angle-down angle-down'></i>
							</a>

							<ul class='<?php echo $ul_class_administration; ?>'>
								<?php
								if(isset($SVM_DSM_Admin_View_Programs_Permissions)) {
									?>
									<li class='<?php if ($li_class_programs) echo $li_class_programs; else ''; ?>'>
										<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/programs_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Programs') ?></span>
										</a>
									</li>
									<?php
								}
								
								if(isset($SVM_DSM_Admin_View_System_Configurations_Permissions)) {
									?>
									<li class='<?php if ($li_class_system_config) echo $li_class_system_config; else ''; ?>'>
										<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/system_configurations_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('System Configurations') ?></span>
										</a>
									</li>
									<?php
								}
								?>
								<li class='<?php if ($li_class_admin_help) echo $li_class_admin_help; else ''; ?>'>
									<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/adminSection/admin_help_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Help') ?></span>
									</a>
								</li>
							</ul>
						</li>
						<?php
					}
				}

				if($moduleSectionStatus['Donation'] == 1 && isset($SVM_DSM_View_Module_Permissions)) {
					if (isset($SVM_DSM_Donation_View_Collect_Donations_Permissions) || isset($SVM_DSM_Donation_View_Program_Progress_Permissions)) {
						?>
						<li class=''>
							<a class='dropdown-collapse menuBox' href='#'><i class='icon-usd'></i>
								<span><?php echo $this->lang->line('Donation Details') ?></span>
								<i class='icon-angle-down angle-down'></i>
							</a>
							<ul class='<?php echo $ul_class_donation; ?>'>
								<?php
								if(isset($SVM_DSM_Donation_View_Collect_Donations_Permissions)) {
									?>
									<li class='<?php if ($li_class_collect_donations) echo $li_class_collect_donations; else ''; ?>'>
										<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/collect_donations_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Collect Donations') ?></span>
										</a>
									</li>
									<?php
								}
								
								if(isset($SVM_DSM_Donation_View_Program_Progress_Permissions)) {
									?>
									<li class='<?php if ($li_class_program_progress) echo $li_class_program_progress; else ''; ?>'>
										<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Program Progress') ?></span>
										</a>
									</li>
									<?php
								}
								?>
								<li class='<?php if ($li_class_donation_help) echo $li_class_donation_help; else ''; ?>'>
									<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/donation_help_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Help') ?></span>
									</a>
								</li>
							</ul>
						</li>
						<?php
					}
				}
				
				if($moduleSectionStatus['Reports'] == 1 && isset($SVM_DSM_View_Module_Permissions)) {
					if (isset($SVM_DSM_Reports_View_Donation_Report_Permissions)) {
						?>
						<li class=''>
							<a class='dropdown-collapse menuBox' href='#'><i class='icon-bar-chart'></i>
								<span><?php echo $this->lang->line('Reports') ?></span>
								<i class='icon-angle-down angle-down'></i>
							</a>
							<ul class='<?php echo $ul_class_report; ?>'>
								<?php
								if(isset($SVM_DSM_Reports_View_Donation_Report_Permissions)) {
									?>
									<li class='<?php if ($li_class_donation_report) echo $li_class_donation_report; else ''; ?>'>
										<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/reportsSection/donations_report_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Donation Reports') ?></span>
										</a>
									</li>
									<?php
								}
								?>
								<li class='<?php if ($li_class_donation_report_help) echo $li_class_donation_report_help; else ''; ?>'>
									<a href='<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/reportsSection/donation_reports_help_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Help') ?></span>
									</a>
								</li>
							</ul>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
	</nav>

    <style>
        .menuBox:hover {
            -moz-border-radius-topleft: 10px;
            -moz-border-radius-topright: 10px;
            -moz-border-radius-bottomright: 10px;
            -moz-border-radius-bottomleft: 10px;
            -webkit-border-radius: 10px 10px 10px 10px;
            border-radius: 10px 10px 10px 10px;
        }
    </style>