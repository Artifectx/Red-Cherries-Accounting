<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>

				<div class='page-header page-header-with-buttons'>
					<h1 class='pull-left'>
						<i class='icon-dashboard'></i>
						<span><?php echo $this->lang->line('User Roles Manager Dashboard') ?></span>
					</h1>
				</div>
				<?php
				if(isset($URM_View_Module_Permissions)) {
					if (isset($URM_Product_Info_View_Module_Section_Permissions) || isset($URM_Product_Info_View_Module_Section_Feature_Permissions)) {
				?>
						<div class='box'>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='text-center'>
										<div class='box'>
											<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
												<ul class="dash">
													<h3 align="left"><?php echo $this->lang->line('Product Information') ?></h3>
													<p style="margin-bottom:0px">&nbsp;</p>
													<?php
													if(isset($URM_Product_Info_View_Module_Section_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_sections_controller"
															   title="<?php echo $this->lang->line('System Module Sections') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/modules.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('System Module Sections') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($URM_Product_Info_View_Module_Section_Feature_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_section_features_controller"
															   title="<?php echo $this->lang->line('System Module Section Features') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/module_features.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('System Module Section Features') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($URM_Product_Info_View_Language_Pack_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_language_pack_controller"
															   title="<?php echo $this->lang->line('System Language Pack') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/language_pack.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('System Language Pack') ?></span></span>
															</a>
														</li>
														<?php
													}
													?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php
					}

					if (isset($URM_User_Roles_View_Default_User_Roles_Permissions) || isset($URM_User_Roles_View_Derive_User_Role_Permissions) ||
						isset($URM_User_Roles_View_Permissions) || isset($URM_User_Roles_View_Default_User_Roles_Permissions_Permissions) ||
						isset($URM_User_Roles_View_Derive_User_Roles_Permissions_Permissions) || isset($URM_User_Roles_View_Users_Permissions)) {
					?>
						<div class='box'>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='text-center'>
										<div class='box'>
											<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
												<ul class="dash">
													<h3 align="left"><?php echo $this->lang->line('User Roles') ?></h3>
													<p style="margin-bottom:0px">&nbsp;</p>
													<?php
													if (isset($URM_User_Roles_View_Default_User_Roles_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/default_user_roles_controller"
															   title="<?php echo $this->lang->line('Default User Roles') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/user_edit.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Default User Roles') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($URM_User_Roles_View_Derive_User_Role_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_controller"
															   title="<?php echo $this->lang->line('Derive User Roles') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/billers.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Derive User Roles') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($URM_User_Roles_View_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/permissions_controller"
															   title="<?php echo $this->lang->line('Permissions') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/signout.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Permissions') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($URM_User_Roles_View_Default_User_Roles_Permissions_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/default_user_roles_permissions_controller"
															   title="<?php echo $this->lang->line('Default User Role Permissions') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/lock.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Default User Role Permissions') ?></span></span>
															</a>
														</li>
														<?php
													}
													if(isset($URM_User_Roles_View_Derive_User_Roles_Permissions_Permissions)) {
														?>
														<li>
															<a class="tip"
															   href="<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/derive_user_roles_permissions_controller"
															   title="<?php echo $this->lang->line('Derive User Role Permissions') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/users_add.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Derive User Role Permissions') ?></span></span>
															</a>
														</li>
														<?php
													}
													if (isset($URM_User_Roles_View_Users_Permissions)) {
														?>
														<li>
															<a class="tip" href="<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/users_controller" title="<?php echo $this->lang->line('Users') ?>">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/user_add.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Users') ?></span></span>
															</a>
														</li>
														<?php
													}
													?>
													<li>
														<a class="tip"
														   href="<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/user_roles_help_controller"
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