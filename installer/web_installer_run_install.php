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

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Red Cherries Accounting Web Installer</title>
		<link href="../assets/stylesheets/installer.css"
			media="all" rel="stylesheet" type="text/css"/>
	</head>

	<body>
		<h1></h1>
		<h3 class="page_title">
			Run Red Cherries Accounting Version <?php echo $_GET['version']; ?> <?php if ($_GET['type'] == 'upgrade') { 
													echo ucfirst($_GET['type']);} 
												 else if ($_GET['type'] == 'install') { 
													 echo 'Installation'; 

												 }  ?>
		</h3>
		<h4 class="form_title">Step 4 : <?php echo ucfirst($_GET['type']);  ?> System</h4>
		<form id="install_system_form" action="" method="post">
			<input class='form-control' id='task_type' name='task_type' type='hidden' value="<?php echo $_GET['type']; ?>">
			<input class='form-control' id='version_no' name='version_no' type='hidden' value="<?php echo $_GET['version']; ?>">
			<div class='msg_data'></div>
			<div class='msg_data_success'></div>
			<fieldset class="account-info">
				<label id="lable_content">System is ready to <?php echo $_GET['type']; ?>. Click on "<?php echo ucfirst($_GET['type']);  ?>" button to proceed.</label>
				<div class='loader' align="center"><img src="../assets/images/ajax-loader.gif"/>
					<?php   if ($_GET['type'] == 'upgrade') { 
								echo 'Upgrading';} 
							else if ($_GET['type'] == 'install') { 
								 echo 'Installing'; 

							}  ?> the system...
				</div>
			</fieldset>
			<fieldset class="account-action">
				<input class="btn" id="install_button" type="button" name="install_button" style="margin-right: 40px" value="<?php echo ucfirst($_GET['type']);  ?>">
				<input class="btn" id="login_button" type="button" name="login_button" value="Next" style="margin-right: 40px">
			</fieldset>
		</form>
		<div class="copy_right">
			Copyright © 2022 Red Cherries Accounting Version <?php echo $_GET['version']; ?> By Artifectx
		</div>
	</body>
</html>

<script src="../ajax/jquery.js"></script>

<script type="text/javascript">
    
	$(document).ready(function () {
		$(".loader").hide();
		$(".msg_data").hide();
		$(".msg_data_success").hide();
		$("#login_button").hide();
	});

	$("#install_button").click(function() {
		$(".loader").show();
		$(".msg_data").hide();
		$.ajax({
			type: "POST",
			url: "install_system.php",
			data: {
				'version_no' : $("#version_no").val(),
				'task_type' : $("#task_type").val(),
			}, 
			dataType: 'json',
            beforeSend :
            function () {
                $("#install_button").attr('disabled', true);
            },
			success: function(response) {
				if (response.result == "ok") {
					$(".loader").hide();
					$("#lable_content").hide();
					$(".msg_data_success").show();
					$(".msg_data_success").html(response.message);
					$("#install_button").hide();
					$("#login_button").show();
				} else {
					$(".loader").hide();
					$(".msg_data").show();
					$(".msg_data").html(response.message);
				}
			}
		});
		return false;
	});

	$("#login_button").click(function() {
		window.location.href = "../index.php";
	});

</script>
