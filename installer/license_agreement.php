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

$licenseFileName = dirname(__FILE__) . "/../LICENSE";
$fh = fopen( $licenseFileName, 'r' ) or die( "License file not found!" );
$licenseFile = fread( $fh, filesize( $licenseFileName ) );
fclose( $fh );
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
		<h4 class="form_title">Step 2 : License Agreement</h4>
        <form id="welcome_form" action="" method="post" style="width: 600px;">
			<input class='form-control' id='version_no' name='version_no' type='hidden' value="<?php echo $_GET['version']; ?>">
			<div class='msg_data'></div>
			<fieldset class="account-info">
                <label style="font-size: 9pt;">
                    Please read the license agreement carefully before you proceed.<br><br>
                    Click "Agree" button when you ready to proceed.
				</label>
                <textarea cols="75" rows="25" readonly="">
                    <?php echo $licenseFile;?>
                </textarea>
			</fieldset>
			<fieldset class="account-action">
				<input class="btn" type="button" id="agree" value="Agree" style="margin-right: 40px">
                <input class="btn" type="button" id="back" value="Back" style="margin-right: 40px">
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
	});

	$("#agree").click(function() {
        var versionNo = $("#version_no").val();
		window.location.href = "web_installer_configure_database.php?type=install&version=" + versionNo;
	});
    
    $("#back").click(function() {
        var versionNo = $("#version_no").val();
		window.location.href = "welcome.php?type=install&version=" + versionNo;
	});

</script>
