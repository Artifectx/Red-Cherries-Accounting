<?php

$moduleSections = $this->user_model->getAllModuleSectionsBySystemModuleName('User Role Manager', 'module_section_name', 'asc');
$moduleSectionStatus = array();
foreach($moduleSections as $row){
	$moduleSectionStatus[$row->module_section_name]=$row->module_section_status;
}

//Administration Section
if (isset($ul_class_administration_section)) $ul_class_administration = $ul_class_administration_section;
else $ul_class_administration = 'nav nav-stacked';

//User Roles Section
if (isset($ul_class_user_roles_section)) $ul_class_user_roles = $ul_class_user_roles_section;
else $ul_class_user_roles = 'nav nav-stacked';

?>
<div id='wrapper'>
	<div id='main-nav-bg'></div>
	<nav id='main-nav'>
		<div class='navigation'>
			<ul class='nav nav-stacked'>
				<li class='active'>
					<a class="menuBox" href='<?php echo base_url(); ?>systemManagerModule/dashboard_controller/dashboardUserRoleManager'>
						<i class='icon-dashboard' ></i>
						<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Dashboard - User Role Manager') ?></span>
					</a>
				</li>

				<?php
				if($moduleSectionStatus['User Roles']==1 && isset($URM_View_Module_Permissions)) {
					if (isset($URM_Product_Info_View_Module_Section_Permissions) || isset($URM_Product_Info_View_Module_Section_Feature_Permissions)) {
					?>
						<li class=''>
							<a class='dropdown-collapse menuBox' href='#'><i class='icon-search'></i>
								<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Product Information') ?></span>
								<i class='icon-angle-down angle-down'></i>
							</a>
							<ul class='<?php echo $ul_class_administration; ?>'>
								<?php
								if(isset($URM_Product_Info_View_Module_Section_Permissions)) {
									?>
									<li class='<?php if ($li_class_system_module_sections) echo $li_class_system_module_sections; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/System_module_sections_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('System Module Sections') ?></span>
										</a>
									</li>
									<?php
								}
								if(isset($URM_Product_Info_View_Module_Section_Feature_Permissions)) {
									?>
									<li class='<?php if ($li_class_system_module_section_features) echo $li_class_system_module_section_features; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_section_features_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('System Module Section Features') ?></span>
										</a>
									</li>
									<?php
								}
								if(isset($URM_Product_Info_View_Language_Pack_Permissions)) {
									?>
									<li class='<?php if ($li_class_system_language_pack) echo $li_class_system_language_pack; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_language_pack_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('System Language Pack') ?></span>
										</a>
									</li>
									<?php
								}
								?>
							</ul>
						</li>
					<?php
					}

					if (isset($URM_User_Roles_View_Default_User_Roles_Permissions) || isset($URM_User_Roles_View_Derive_User_Role_Permissions) ||
						isset($URM_User_Roles_View_Permissions) || isset($URM_User_Roles_View_Default_User_Roles_Permissions_Permissions) ||
						isset($URM_User_Roles_View_Derive_User_Roles_Permissions_Permissions) || isset($URM_User_Roles_View_Users_Permissions)) {
					?>
						<li class=''>
							<a class='dropdown-collapse menuBox' href='#'><i class='icon-user'></i>
								<span <?php echo $menuFormatting; ?>><?php echo $this->lang->line('User Roles') ?></span>
								<i class='icon-angle-down angle-down'></i>
							</a>
							<ul class='<?php echo $ul_class_user_roles; ?>'>
								<?php
								if(isset($URM_User_Roles_View_Default_User_Roles_Permissions)) {
									?>
									<li class='<?php if ($li_class_default_user_roles) echo $li_class_default_user_roles; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/default_user_roles_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Default User Roles') ?></span>
										</a>
									</li>
									<?php
								}
								if(isset($URM_User_Roles_View_Derive_User_Role_Permissions)) {
									?>
									<li class='<?php if ($li_class_derive_user_roles) echo $li_class_derive_user_roles; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Derive User Roles') ?></span>
										</a>
									</li>
									<?php
								}
								if(isset($URM_User_Roles_View_Permissions)) {
									?>
									<li class='<?php if ($li_class_permissions) echo $li_class_permissions; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/permissions_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Permissions') ?></span>
										</a>
									</li>
									<?php
								}
								if(isset($URM_User_Roles_View_Default_User_Roles_Permissions_Permissions)) {
									?>
									<li class='<?php if ($li_class_default_user_role_permissions) echo $li_class_default_user_role_permissions; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/default_user_roles_permissions_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Default User Role Permissions') ?></span>
										</a>
									</li>
									<?php
								}
								if(isset($URM_User_Roles_View_Derive_User_Roles_Permissions_Permissions)) {
									?>
									<li class='<?php if ($li_class_derive_user_role_permissions) echo $li_class_derive_user_role_permissions; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_permissions_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Derive User Role Permissions') ?></span>
										</a>
									</li>
									<?php
								}
								if(isset($URM_User_Roles_View_Users_Permissions)) {
									?>
									<li class='<?php if ($li_class_users) echo $li_class_users; else ''; ?>'>
										<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller'>
											<i class='icon-caret-right'></i>
											<span><?php echo $this->lang->line('Users') ?></span>
										</a>
									</li>
									<?php
								}
								?>

								<li class='<?php if ($li_class_user_roles_help) echo $li_class_user_roles_help; else ''; ?>'>
									<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/user_roles_help_controller'>
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