<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Red Cherries Accounting</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta content='text/html' http-equiv='content-type'>
	<meta
		content='Red Cherries Accounting - Total Enterprise Resource Management Software Solution'
		name='description'>
	<link href='<?php echo base_url(); ?>assets/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
	<link href='<?php echo base_url(); ?>assets/images/meta_icons/apple-touch-icon.png'
		  rel='apple-touch-icon-precomposed'>
	<link href='<?php echo base_url(); ?>assets/images/meta_icons/apple-touch-icon-57x57.png'
		  rel='apple-touch-icon-precomposed' sizes='57x57'>
	<link href='<?php echo base_url(); ?>assets/images/meta_icons/apple-touch-icon-72x72.png'
		  rel='apple-touch-icon-precomposed' sizes='72x72'>
	<link href='<?php echo base_url(); ?>assets/images/meta_icons/apple-touch-icon-114x114.png'
		  rel='apple-touch-icon-precomposed' sizes='114x114'>
	<link href='<?php echo base_url(); ?>assets/images/meta_icons/apple-touch-icon-144x144.png'
		  rel='apple-touch-icon-precomposed' sizes='144x144'>
	<!-- / START - page related stylesheets [optional] -->
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/jquery/jquery-ui.css"
		media="all" rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.css"
		media="all" rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css"
		media="all" rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.css"
		media="all" rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/fullcalendar/fullcalendar.css"
		media="all" rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/fullcalendar/fullcalendar.print.css"
		media="print" rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/bootstrap_switch/bootstrap-switch.css" media="all"
		rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/common/bootstrap-wysihtml5.css"
		media="all" rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/circular_progress_bar/jQuery-plugin-progressbar.css"
		media="all" rel="stylesheet" type="text/css"/>
	<!-- / END - page related style sheets [optional] -->
	<!-- / bootstrap [required] -->
	<link
		href="<?php echo base_url(); ?>assets/stylesheets/bootstrap/bootstrap.css"
		media="all" rel="stylesheet" type="text/css"/>
	<!-- / theme file [required] -->

	<link
		href="<?php echo base_url(); ?>assets/stylesheets/plugins/tabdrop/tabdrop.css"
		media="all" rel="stylesheet" type="text/css"/>

	<?php
	if ($theme != null) {
		foreach ($theme as $row) {
			$theme_css = $row->theme;
			//echo $_SESSION['BOXHEADER']=$theme_css;
			define('BOXHEADER', $theme_css);
		}
	} ?>

	<link href="<?php echo base_url(); ?>assets/stylesheets/light-theme.css" media="all" id="color-settings-body-color"
		  rel="stylesheet" type="text/css"/>

	<link href="<?php echo base_url(); ?>assets/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet"
		  type="text/css"/>

	<link href="<?php echo base_url(); ?>assets/stylesheets/<?php echo $theme_css; ?>.css" media="all" rel="stylesheet"
		  type="text/css"/>

	<!-- / demo file [not required!] -->
	<link href="<?php echo base_url(); ?>assets/stylesheets/demo.css" media="all" rel="stylesheet" type="text/css"/>

	<link href="<?php echo base_url(); ?>assets/stylesheets/plugins/jstree/style.min.css" media="all" rel="stylesheet"
		  type="text/css"/>
	<!--[if lt IE 9]>
	<script src="assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
	<script src="assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
	<![endif]-->

	<!--validation css-->
	<link href="<?php echo base_url(); ?>assets/stylesheets/validate.css" media="all" id="color-settings-body-color"
		  rel="stylesheet" type="text/css"/>

	<link href="<?php echo base_url(); ?>assets/stylesheets/bootstrap-extend.css" media="all" id="color-settings-body-color"
		  rel="stylesheet" type="text/css"/>

	<!--language css-->
	<link href="<?php echo base_url(); ?>assets/stylesheets/languages.min.css" media="all"
		  id="color-settings-body-color" rel="stylesheet" type="text/css"/>

	<!--international phone no-->
	<link href="<?php echo base_url(); ?>assets/stylesheets/intlTelInput.css" media="all" id="color-settings-body-color"
		  rel="stylesheet" type="text/css"/>

	<link href="<?php echo base_url(); ?>assets/stylesheets/plugins/fuelux/wizard.css" media="all" rel="stylesheet"
		  type="text/css"/>
	
</head>
<?php
$dataGoogleAnalytics = $this->google_analytics_model->getAll();
if($dataGoogleAnalytics != null) {
	if($dataGoogleAnalytics[0]->enable_in_dashboard == '1') {
		$analyticCode = $dataGoogleAnalytics[0]->analytic_code;
	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $analyticCode;?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', '<?php echo $analyticCode;?>');
	</script>
<?php
	}
}
?>
<body class='contrast-red'>
<header>
	<nav class='navbar navbar-default'>
		<a class='navbar-brand' href='<?php echo base_url(); ?>'>
			<img width="55px" height="55px" class="logo1" alt="Red Cherries Accounting" style="margin-top: 3%"
				 src="<?php echo base_url(); ?>assets/images/logo.png"/>
		</a>

		<a class='toggle-nav btn btn-success pull-left btnHeaderMenu btnSize' href='#' id="navBtn" title="<?php echo $this->lang->line('Toggle Left Menu') ?>">
			<i class='icon-reorder'></i>
		</a>
		<a>&nbsp;</a>

		<a class='btn btn-success btnHeaderMenu btnSize' href='<?php echo base_url(); ?>' id="openDashboard"
			title="<?php echo $this->lang->line('System Dashboard') ?>">
			<i class='icon-dashboard'></i>
		</a>

		<a class='btn btn-success systemModules btnHeaderMenu btnSize' data-toggle="collapse" data-target="#systemModules"
		   title="<?php echo $this->lang->line('Open System Modules') ?>">
			<i class='icon icon-double-angle-down'></i>
		</a>

		<?php
		$html = '';
		$systemModule = null;
		$systemModuleName = '';
		$url = base_url();
		if($dataSystemModules != null) {
			$systemModule = $dataSystemModules[0]->system_module;
			$systemModuleUrl = $dataSystemModules[0]->dashboard_url;

			$defaultSystemModuleName = $defaultSystemModule[0]->default_system_module;
			$defaultSystemModuleUrl = $defaultSystemModule[0]->dashboard_url;

			if($systemModule != null) {
				$html.= "<a class='btnHeaderMenu systemModulesHeader hide-for-tab-mobile' href='{$url}{$systemModuleUrl}' id='systemModulesHeader'
							title='{$systemModule} Dashboard'>";
					$html.=	$this->lang->line($systemModule);
					$html.=	"</a>";

				$html.= "&nbsp;&nbsp;&nbsp;
					<input type='checkbox' class='btnHeaderMenu defaultModuleCheckbox hide-for-tab-mobile' name='defaultSystemModule' id='defaultSystemModule' 
					title='{$this->lang->line('Default Module')}' value='{$systemModuleUrl}' onclick='setAsDefaultSystemModule(/{$systemModule}/)'";

				$systemModuleName = $systemModule;

			} else if ($defaultSystemModuleUrl != '') {
				$html.= "<a class='btnHeaderMenu systemModulesHeader hide-for-tab-mobile' href='{$url}{$defaultSystemModuleUrl}' id='systemModulesHeader'
							title='{$defaultSystemModuleName} Dashboard'>
							{$defaultSystemModuleName}
						</a>";

				$html.= "&nbsp;&nbsp;&nbsp;
					<input type='checkbox' class='btnHeaderMenu defaultModuleCheckbox hide-for-tab-mobile' name='defaultSystemModule' id='defaultSystemModule' 
					title='{$this->lang->line('Default Module')}' value='{$systemModuleUrl}' onclick='setAsDefaultSystemModule(/{$defaultSystemModuleName}/)'";

				$systemModuleName = $defaultSystemModuleName;
			}

			switch ($systemModuleName) {
				case "Organization":
					if ($systemModule == $defaultSystemModuleName) {
						$html.= "checked";
					} else if ($systemModule == '' && $systemModuleName == $defaultSystemModuleName && $defaultSystemModuleUrl != '') {
						$html.= "checked";
					}
					break;

				case "Service Manager":
					if ($systemModule == $defaultSystemModuleName) {
						$html.= "checked";
					} else if ($systemModule == '' && $systemModuleName == $defaultSystemModuleName && $defaultSystemModuleUrl != '') {
						$html.= "checked";
					}
					break;

				case "Accounts Manager":
					if ($systemModule == $defaultSystemModuleName) {
						$html.= "checked";
					} else if ($systemModule == '' && $systemModuleName == $defaultSystemModuleName && $defaultSystemModuleUrl != '') {
						$html.= "checked";
					}
					break;

				case "User Role Manager":
					if ($systemModule == $defaultSystemModuleName) {
						$html.= "checked";
					} else if ($systemModule == '' && $systemModuleName == $defaultSystemModuleName && $defaultSystemModuleUrl != '') {
						$html.= "checked";
					}
					break;

				default:
					break;
			}

			if ($systemModule != null || $defaultSystemModuleUrl != '') {
				$html.= "><label for='defaultSystemModule' class='btnHeaderMenu hide-for-tab-mobile' style='vertical-align: middle; color: #ffffff; margin-left: 0.5%;'>
						{$this->lang->line('Default Module')}
						</label>";
			}
		}

		echo $html;
		?>
		
		<input type="hidden" id="systemModulesStatus" value="0">

		<ul class='nav header-left-nav'>
			<li class='dropdown dark only-icon'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                    <i class='icon-cog'></i>
                </a>
                <ul class='dropdown-menu color-settings'>

                    <li class='divider'></li>
                    <li class='color-settings-contrast-color'>
                        <div class='color-title'><?php echo $this->lang->line('Change Theme Color') ?></div>
                        <a data-change-to="contrast-red" href="<?php echo base_url();?>home/setUserTheme/red"><i class='icon-cog text-red'></i>
                            Red
                        </a>

                        <a data-change-to="contrast-blue" href="<?php echo base_url();?>home/setUserTheme/blue"><i class='icon-cog text-blue'></i>
                            Blue
                        </a>

                        <a data-change-to="contrast-orange" href="<?php echo base_url();?>home/setUserTheme/orange"><i class='icon-cog text-orange'></i>
                            Orange
                        </a>

                        <a data-change-to="contrast-purple" href="<?php echo base_url();?>home/setUserTheme/purple"><i class='icon-cog text-purple'></i>
                            Purple
                        </a>

                        <a data-change-to="contrast-green" href="<?php echo base_url();?>home/setUserTheme/green"><i class='icon-cog text-green'></i>
                            Green
                        </a>

                        <a data-change-to="contrast-muted" href="<?php echo base_url();?>home/setUserTheme/muted"><i class='icon-cog text-muted'></i>
                            Muted
                        </a>

                        <a data-change-to="contrast-fb" href="<?php echo base_url();?>home/setUserTheme/fb"><i class='icon-cog text-fb'></i>
                            Facebook
                        </a>

                        <a data-change-to="contrast-dark" href="<?php echo base_url();?>home/setUserTheme/dark"><i class='icon-cog text-dark'></i>
                            Dark
                        </a>

                        <a data-change-to="contrast-pink" href="<?php echo base_url();?>home/setUserTheme/pink"><i class='icon-cog text-pink'></i>
                            Pink
                        </a>

                        <a data-change-to="contrast-grass-green" href="<?php echo base_url();?>home/setUserTheme/grass-green"><i class='icon-cog text-grass-green'></i>
                            Grass Green
                        </a>

                        <a data-change-to="contrast-sea-blue" href="<?php echo base_url();?>home/setUserTheme/sea-blue"><i class='icon-cog text-sea-blue'></i>
                            Sea Blue
                        </a>

                        <a data-change-to="contrast-banana" href="<?php echo base_url();?>home/setUserTheme/banana"><i class='icon-cog text-banana'></i>
                            Banana
                        </a>

                        <a data-change-to="contrast-dark-orange" href="<?php echo base_url();?>home/setUserTheme/dark-orange"><i class='icon-cog text-dark-orange'></i>
                            Dark Orange
                        </a>

                        <a data-change-to="contrast-brown" href="<?php echo base_url();?>home/setUserTheme/brown"><i class='icon-cog text-brown'></i>
                            Brown
                        </a>

                    </li>
                </ul>
            </li>
			
			<li class='dropdown dark user-menu'>
				<a class='dropdown-toggle' data-toggle='dropdown' href='#'>
					<span class='user-name hide-for-tab-mobile'>
					  <?php
						  $session_data = $this->session->userdata('logged_in_stock');
						  echo $session_data['username'];
					  ?>
					</span>
					<b class='caret'></b>
				</a>
				<ul class='dropdown-menu'>
                    <li>
                        <a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/profile_controller/password'>
                            <i class='icon-random'></i>
                            <?php echo $this->lang->line('Change Password') ?>
                        </a>
                    </li>
					<li>
						<a href='<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/profile_controller/language'>
							<i class='icon-globe'></i>
							<?php echo $this->lang->line('My Language') ?>
						</a>
					</li>
					<li>
						<a href='<?php echo base_url(); ?>organizationManagerModule/organizationSection/about_system_controller'>
							<i class='icon-list'></i>
							<?php echo $this->lang->line('About System') ?>
						</a>
					</li>
					<li class='divider'></li>
					<li>
						<a href="<?php echo base_url(); ?>home/logout">
							<i class="icon-signout"></i>
							<?php echo $this->lang->line('Logout') ?>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<!--<form action='' class='navbar-form navbar-right hidden-xs' method='get'>
			<button class='btn btn-link icon-search' name='button' type='submit'></button>
		</form>-->
	</nav>
</header>

<!-- System Modules -->

	<div class='container'>
		<div id="systemModules" class='col-xs-12 collapse'>
			<div class='col-xs-3 home-left-margin'></div>
			<div class='col-xs-6 home-for-desktop'>
				<h1 class="system-modules" align="center"><?php echo $this->lang->line('System Modules') ?></h1>
				<ul class="dash" style="margin: auto 5% auto 6%;">
					<?php
					//get all system modules details
					$system_modules = $this->user_model->getAllSystemModules('system_module_id','asc');

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
											<a class="tip" style="margin:0 0 10px 0;"
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
			<div class='col-xs-12 home-for-mobile'>
				<h1 class="system-modules" align="center"><?php echo $this->lang->line('System Modules') ?></h1>
				<ul class="dash" style="margin: auto -20% auto -8%;">
					<?php
					$system_modules = $this->user_model->getAllSystemModules('system_module_id','asc');

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
											<a class="tip" style="margin:0 0 10px 0;"
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
			<div class='col-xs-3 home-right-margin'></div>
			</div>
		</div>

<div id="content-body">

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>

<script>
	
	var sessionTimer = setInterval(function(){
		checkAndResetUserSessionTimeout();
	},120000);

	$(document).ready(function () {
		id = 1;
		var body;
		body = $("body");
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>systemManagerModule/web_settings_controller/get",
			data: {
				'id': id,
				<?php echo $this->security->get_csrf_token_name(); ?>:
				'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			success:function (response) {
				if (response == "main-nav-closed")
				{
					body.removeClass("main-nav-opened").addClass(response);
				}
				else
				{
					body.removeClass("main-nav-closed").addClass(response);
				}
			}
		});
	});

	$("#navBtn").click(function () {
		id = 1;
		var body;
		body = $("body");
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>systemManagerModule/web_settings_controller/chanageNavOption",
			data: {
				'id': id,
				<?php echo $this->security->get_csrf_token_name(); ?>:
				'<?php echo $this->security->get_csrf_hash(); ?>'
			 },
			success:function (response) {
				//location.reload();
			}
		});
	});

	$('.systemModules').on('click', function () {
		//alert('clk')
		if($('#systemModulesStatus').val() == 0){
			$(".icon").removeClass("icon-double-angle-down").addClass("icon-double-angle-up");
			$('#content-body').hide();
			$('.systemModules').attr('title', '<?php echo $this->lang->line('Retract System Modules') ?>');
			$('#systemModulesStatus').val('1');
		}else{
			$(".icon").removeClass("icon-double-angle-up").addClass("icon-double-angle-down");
			$('#content-body').show();
			$('.systemModules').attr('title', '<?php echo $this->lang->line('Open System Modules') ?>');
			$('#systemModulesStatus').val('0')
		}
	})

	function setSystemModulesHeaderTitle(systemModule,systemModuleUrl) {
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

	function setAsDefaultSystemModule(systemModule) {
		var status = '';
		var systemModuleName = '';
		var dashboardUrl = '';
		if ($('#defaultSystemModule').is(':checked')){
			status='1';
			systemModuleName = systemModule;
			dashboardUrl = $('#defaultSystemModule').val();
		}else{
			status='0';
			systemModuleName = '';
			dashboardUrl = '';
		}
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>home/setAsDefaultSystemModule",
			data: {
				'default_system_module_status': status,
				'default_system_module': systemModuleName,
				'dashboard_url': dashboardUrl,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:function (response) {
			}
		});
	}

	function checkAndResetUserSessionTimeout() {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>systemManagerModule/web_settings_controller/extendUserSessionExpiration",
			data: {
				<?php echo $this->security->get_csrf_token_name(); ?>:
				'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
			success:function (response) {
				console.info(response);
			}
		});
	}

	//dissable browser refresh & inspect element
	function disableBrowserEvents(e) {
		if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 123 || (e.which || e.keyCode) == 114 || (e.which || e.keyCode) == 117) {
			e.preventDefault();
		}
	};
	
	$(document).on("keydown", disableBrowserEvents);
</script>