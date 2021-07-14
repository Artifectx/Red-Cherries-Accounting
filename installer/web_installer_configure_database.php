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
		<h3 class="page_title">Configure Red Cherries Accounting Version <?php echo $_GET['version']; ?> Installation/Upgrade</h3>
		<h4 class="form_title">Step 3 : Configure Database</h4>
		<form id="configure_db_form" action="" method="post">
			<input class='form-control' id='version_no' name='version_no' type='hidden' value="<?php echo $_GET['version']; ?>">
			<div class='msg_data'></div>
			<fieldset class="account-info">
				<label>Database Source
					<input type="text" id="database_source" name="database_source">
				</label>
				<label>Database Name
					<input type="text" id="database_name" name="database_name">
				</label>
				<label>Database User Name
					<input type="text" id="user_name" name="user_name">
				</label>
				<label>Database Password
					<input type="password" id="password" name="password">
				</label>
				<div class='loader' align="center"><img src="../assets/images/ajax-loader.gif"/> Configuring the system...</div>
			</fieldset>
			<fieldset class="account-action">
				<input class="btn" type="submit" name="submit" value="Next" style="margin-right: 40px">
                <input class="btn" type="button" id="back" value="Back" style="margin-right: 40px">
			</fieldset>
		</form>
		<div class="copy_right">
			Copyright © 2021 Red Cherries Accounting Version <?php echo $_GET['version']; ?> By Artifectx
		</div>
	</body>
</html>

<script src="../ajax/jquery.js"></script>

<script type="text/javascript">
    
	$(document).ready(function () {
		$(".loader").hide();
		$(".msg_data").hide();
	});

	$("#configure_db_form").submit(function() {
		$(".loader").show();
		$(".msg_data").hide();
		var versionNo = $("#version_no").val();
		$.ajax({
			type: "POST",
			url: "create_database.php",
			data: {
				'version_no' : versionNo,
				'database_source' : $("#database_source").val(),
				'database_name' : $("#database_name").val(),
				'user_name' : $("#user_name").val(),
				'password' : $("#password").val()
			}, 
			dataType: 'html',
			success: function(response) {
				if (response == "db_created") {
					$(".loader").hide();
					window.location.href = "web_installer_run_install.php?type=install&version=" + versionNo;
				} else if (response == "upgrade_required") {
					$(".loader").hide();
					window.location.href = "web_installer_run_install.php?type=upgrade&version=" + versionNo;
				} else {
					$(".loader").hide();
					$(".msg_data").show();
					$(".msg_data").html(response);
				}
			}
		});
		return false;
	});
    
    $("#back").click(function() {
        var versionNo = $("#version_no").val();
		window.location.href = "license_agreement.php?type=install&version=" + versionNo;
	});

</script>
