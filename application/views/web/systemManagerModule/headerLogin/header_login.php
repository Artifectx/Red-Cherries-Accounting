<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard | Red Cherries Accounting</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<meta content='text/html' http-equiv='content-type'>
		<meta content='Red Cherries Accounting - Total Enterprise Resource Management Software Solution' name='description'>
		<link href='<?php echo base_url();?>assets/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
		<link href='<?php echo base_url();?>assets/images/meta_icons/apple-touch-icon.png' rel='apple-touch-icon-precomposed'>
		<link href='<?php echo base_url();?>assets/images/meta_icons/apple-touch-icon-57x57.png' rel='apple-touch-icon-precomposed' sizes='57x57'>
		<link href='<?php echo base_url();?>assets/images/meta_icons/apple-touch-icon-72x72.png' rel='apple-touch-icon-precomposed' sizes='72x72'>
		<link href='<?php echo base_url();?>assets/images/meta_icons/apple-touch-icon-114x114.png' rel='apple-touch-icon-precomposed' sizes='114x114'>
		<link href='<?php echo base_url();?>assets/images/meta_icons/apple-touch-icon-144x144.png' rel='apple-touch-icon-precomposed' sizes='144x144'>
		<!-- / START - page related stylesheets [optional] -->
		<link href="<?php echo base_url();?>assets/stylesheets/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>assets/stylesheets/plugins/fullcalendar/fullcalendar.css" media="all" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>assets/stylesheets/plugins/common/bootstrap-wysihtml5.css" media="all" rel="stylesheet" type="text/css" />
		<!-- / END - page related stylesheets [optional] -->
		<!-- / bootstrap [required] -->
		<link href="<?php echo base_url();?>assets/stylesheets/bootstrap/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
		<!-- / theme file [required] -->
		<link href="<?php echo base_url();?>assets/stylesheets/light-theme.css" media="all" id="color-settings-body-color" rel="stylesheet" type="text/css" />
		<!-- / coloring file [optional] (if you are going to use custom contrast color) -->
		<link href="<?php //echo base_url();?>assets/stylesheets/theme-colors.css" media="all" rel="stylesheet" type="text/css" />

		<!--[if lt IE 9]>
		  <script src="assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
		  <script src="assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
		<![endif]-->

		<link href="<?php echo base_url();?>assets/stylesheets/validate.css" media="all" rel="stylesheet" type="text/css" />
	</head>

	<?php
	$dataGoogleAnalytics = $this->google_analytics_model->getAll();
	if($dataGoogleAnalytics != null) {
		if($dataGoogleAnalytics[0]->enable_in_login == '1') {
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
  