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
			Welcome to Red Cherries Accounting Open Source Version <?php echo $_GET['version']; ?>
		</h3>
		<h4 class="form_title">Step 1 : Welcome</h4>
		<form id="welcome_form" action="" method="post">
			<input class='form-control' id='version_no' name='version_no' type='hidden' value="<?php echo $_GET['version']; ?>">
			<div class='msg_data'></div>
			<fieldset class="account-info">
                <label style="font-size: 11pt;">
                    Welcome to Red Cherries Accounting Open Source! 
                </label>
                <label style="font-size: 9pt; font-weight: normal">
                    If you already use Red Cherries Accounting, you may consider upgrade 
                    to the new version. If you wish to upgrade, please provide your current database in Step 3 and system will 
                    proceed as an upgrade. <br><br>
                    
                    We hope you will find this solution very helpful for your accounts management and we welcome your valuable feedbacks.
                    If you encounter any issues, please feel free to forward us the information so that we can continuously improve the 
                    solution.<br><br>
                    
                    Further, this software solution has a service management module which can be linked with accounting module. Donation
                    Manager is currently available as the first service management solution. If you need more service management solutions,
                    you can request us to implement such requirements within a decent budget.<br><br>
                    
                    We invite you to use our cloud hosting service and formal user training sessions, so that you can use the system successfully.<br><br>
                    
                    Enjoy free and open source software solutions!
				</label>
			</fieldset>
			<fieldset class="account-action">
				<input class="btn" type="button" value="Next" style="margin-right: 40px">
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

	$("#welcome_form").click(function() {
        var versionNo = $("#version_no").val();
		window.location.href = "license_agreement.php?type=install&version=" + versionNo;
	});

</script>
