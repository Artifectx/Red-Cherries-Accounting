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

	$moduleSections = $this->user_model->getAllModuleSectionsBySystemModuleName('Organization', 'module_section_name', 'asc');
	$moduleSectionStatus = array();
	foreach($moduleSections as $row){
		$moduleSectionStatus[$row->module_section_name] = $row->module_section_status;
	}

	//Administration Section
	if (isset($ul_class_administration_section)) $ul_class_administration = $ul_class_administration_section;
	else $ul_class_administration = 'nav nav-stacked';

	//Organization Module
	if (isset($ul_class_organization_section)) $ul_class_organization = $ul_class_organization_section;
	else $ul_class_organization = 'nav nav-stacked';

?>
<div id='wrapper'>
	<div id='main-nav-bg'></div>
	<nav id='main-nav'>
		<div class='navigation'>
			<ul class='nav nav-stacked'>
				<li class='active'>
					<a class="menuBox" href='<?php echo base_url(); ?>systemManagerModule/dashboard_controller/organizationManager'>
						<i class='icon-dashboard' ></i>
						<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Dashboard - Organization') ?></span>
					</a>
				</li>
				<?php
				if($moduleSectionStatus['Organization']==1 && isset($OGM_View_module_Permissions)) {
					if (isset($OGM_Admin_View_Calendar_Day_Types_Permissions) || isset($OGM_Admin_View_Calendar_Days_Permissions) ||
					      isset($OGM_Admin_View_Locations_Permissions) || isset($OGM_Admin_View_Territories_Permissions) || 
					      isset($OGM_Admin_View_People_Permissions)) {
					?>
					<li class=''>
						<a class="dropdown-collapse menuBox" href="#"><i class='icon-briefcase'></i>
							<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Administration') ?></span>
							<i class='icon-angle-down angle-down'></i>
						</a>

						<ul class='<?php echo $ul_class_administration; ?>'>
							<?php
							if(isset($OGM_Admin_View_Calendar_Day_Types_Permissions)){
								?>
								<li class='<?php if ($li_class_calendar_day_types) echo $li_class_calendar_day_types; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/calendar_day_types_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Calendar Day Types') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($OGM_Admin_View_Calendar_Days_Permissions)){
								?>
								<li class='<?php if ($li_class_organization_calendar) echo $li_class_organization_calendar; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Organization Calendar') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($OGM_Admin_View_Locations_Permissions)){
								?>
								<li class='<?php if ($li_class_locations) echo $li_class_locations; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Locations') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($OGM_Admin_View_Territories_Permissions)){
								?>
								<li class='<?php if ($li_class_territories) echo $li_class_territories; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/territories_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Territories') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($OGM_Admin_View_People_Permissions)) {
								?>
								<li class='<?php if ($li_class_peoples) echo $li_class_peoples; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('People') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($OGM_Admin_View_Data_Import_Permissions)) {
								?>
								<li class='<?php if ($li_class_data_import) echo $li_class_data_import; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/data_import_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Data Import') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($OGM_Admin_View_Google_Analytics_Permissions)) {
								?>
								<li class='<?php if ($li_class_google_analytics) echo $li_class_google_analytics; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/google_analytics_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Google Analytics Settings') ?></span>
									</a>
								</li>
								<?php
							}
							if(isset($OGM_Admin_View_System_Configurations_Permissions)) {
									?>
									<li class='<?php if ($li_class_system_config) echo $li_class_system_config; else ''; ?>'>
										<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/system_configurations_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('System Configurations') ?></span>
										</a>
									</li>
									<?php
							}
							?>
							<li class='<?php if ($li_class_admin_help) echo $li_class_admin_help; else ''; ?>'>
								<a href='<?php echo base_url(); ?>organizationManagerModule/adminSection/admin_help_controller'>
									<i class='icon-caret-right'></i>
									<span><?php echo $this->lang->line('Help') ?></span>
								</a>
							</li>
						</ul>
					</li>
				<?php
					}

					if (isset($OGM_Organization_View_Company_Information_Permissions) || isset($OGM_Organization_View_Company_Structure_Permissions)) {
					?>
					<li class=''>
						<a class="dropdown-collapse menuBox" href="#"><i class='icon-home'></i>
							<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Organization') ?></span>
							<i class='icon-angle-down angle-down'></i>
						</a>

						<ul class='<?php echo $ul_class_organization; ?>'>
							<?php
							if(isset($OGM_Organization_View_Company_Information_Permissions)) {
								?>
								<li class='<?php if ($li_class_company_information) echo $li_class_company_information; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_information_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Company Information') ?></span>
									</a>
								</li>
								<?php
							}
							if (isset($OGM_Organization_View_Company_Structure_Permissions)) {
								?>
								<li class='<?php if ($li_class_company_structure) echo $li_class_company_structure; else ''; ?>'>
									<a href='<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller'>
										<i class='icon-caret-right'></i>
										<span><?php echo $this->lang->line('Company Structure') ?> </span>
									</a>
								</li>
								<?php
							}
							?>
							<li class='<?php if ($li_class_organization_help) echo $li_class_organization_help; else ''; ?>'>
								<a href='<?php echo base_url(); ?>organizationManagerModule/organizationSection/organization_help_controller'>
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