<div class='container'>
	<!--<div class='row' id='content-wrapper'>-->

	<div class='col-xs-12'>
		<div class='col-xs-3 home-left-margin'></div>
		<div class='col-xs-6 home-for-desktop'>
			<div id="systemModules_home" class="collapse_home">
				<!--licence message -->
				<div style="color: #ff3333; text-align: center; font-size: 14px;"><?php if($message != '') echo $message; ?></div>
				<h3 class="welcome-to-rc-accounting">Red Cherries Accounting</h3>
				<h4 class="system-modules" align="center"><?php echo $this->lang->line('System Modules') ?></h4>
				<ul class="dash" style="margin: auto 5% auto 6%;">
					<?php
					//get all system modules details
					if($system_modules != null){
						foreach($system_modules as $row) {
							switch ($row->system_module) {
								case "Organization":

									if (isset($OGM_View_module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
														alt=""/></i>
												<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								case "Service Manager":


									if (isset($SVM_View_module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
														alt=""/></i>
												<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								case "Accounts Manager":

									if (isset($ACM_View_Module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
														alt=""/></i>
												<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								case "User Role Manager":

									if (isset($URM_View_Module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
													alt=""/></i>
											<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								default:
									break;
							}
						}
					}
					?>
				</ul>
			</div>
		</div>
		<div class='col-xs-12 home-for-mobile'>
			<div id="systemModules_home" class="collapse_home">
				<!--licence message -->
				<div style="color: #ff3333; text-align: center; font-size: 14px;"><?php if($message != '') echo $message; ?></div>
				<h3 class="welcome-to-rc-accounting">Red Cherries Accounting</h3>
				<h4 class="system-modules" align="center"><?php echo $this->lang->line('System Modules') ?></h4>
				<ul class="dash" style="margin: auto -20% auto -8%;">
					<?php
					//get all system modules details
					if($system_modules != null){
						foreach($system_modules as $row) {
							switch ($row->system_module) {
								case "Organization":

									if (isset($OGM_View_module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
														alt=""/></i>
												<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								case "Service Manager":


									if (isset($SVM_View_module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
														alt=""/></i>
												<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								case "Accounts Manager":

									if (isset($ACM_View_Module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
														alt=""/></i>
												<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								case "User Role Manager":

									if (isset($URM_View_Module_Permissions)) {
										?>
										<li style="margin: 0.5% 0.5% 0.5% 0.5%;">
											<a class="tip"
												href="#"
												title="<?php echo $this->lang->line($row->system_module) ?>" onclick="setSystemModulesHeaderTitle('<?php echo $row->system_module ?>','<?php echo $row->dashboard_url; ?>')">
												<i><img src="<?php echo base_url(); ?>assets/images/system_modules/<?php echo $row->system_module_image_url ?> "
													alt=""/></i>
											<span><span><?php echo $this->lang->line($row->system_module) ?></span></span>
											</a>
										</li>
										<?php
									}

									break;

								default:
									break;
							}
						}
					}
					?>
				</ul>
			</div>
		</div>
		<div class='col-xs-3 home-right-margin'></div>
	</div>
	<!--</div>-->
</div>

<script>
    $(document).ready(function () {
        $(".btnHeaderMenu").addClass("page_load");
    });

    $(".tip").click(function () {
        $(".btnHeaderMenu").removeClass("page_load");
        $(".btnHeaderMenu").addClass("page_load_show");
    });

    function setSystemModulesHeaderTitle(systemModule, systemModuleUrl){
        var systemModule = systemModule;
        var systemModuleUrl = systemModuleUrl;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>home/setSystemModulesHeaderTitle",
            data: {
                'systemModule': systemModule,
                'systemModuleUrl': systemModuleUrl,
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'html',
                success:function (response) {
                window.location.href = response;
            }
        });
    }
</script>
