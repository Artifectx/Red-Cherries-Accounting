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

error_reporting(E_ERROR | E_PARSE);

if (!empty($_POST)) {
	$versionNo = $_POST["version_no"];
	$databaseHost = $_POST["database_source"];
	$database = $_POST["database_name"];
	$userName = $_POST["user_name"];
	$password = $_POST["password"];

	$mysqliConnection = mysqli_connect($databaseHost, $userName, $password);

	if (mysqli_connect_errno()) {
		echo "Please enter valid database connection information.";
	} else {

		$mysqli = mysqli_connect($databaseHost, $userName, $password, $database);

		if (mysqli_connect_errno()) {
			if (!mysqli_query($mysqliConnection, "CREATE DATABASE `{$database}`")) {
				echo "Couldn't create new '{$database}' database.";
			} else {
				createDatabaseConfig($databaseHost, $database, $userName, $password);

				echo "db_created";
			}
		} else {
			createDatabaseConfig($databaseHost, $database, $userName, $password);
			$result = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `config_filed_value` FROM `system_common_configurations` WHERE `config_filed_name` LIKE 'red_cherries_os_version_number'"));
			$currentVersionNo = $result['config_filed_value'];

			if ($currentVersionNo != $versionNo) {
				echo "upgrade_required";
			}
		}
	}
}

function createDatabaseConfig($databaseHost, $database, $userName, $password) {

	$databaseFile = fopen("../application/config/database.php", "w") or die("Unable to open file!");
	
	$content = "<?php \n"
			  ."$"."active_group = 'default'; \n"
			  ."$"."query_builder = TRUE; \n"
			  ."$"."db['default'] = array(
							'dsn'	=> '',
							'hostname' => '".$databaseHost."',
							'username' => '".$userName."',
							'password' => '".$password."',
							'database' => '".$database."',
							'dbdriver' => 'mysqli',
							'dbprefix' => '',
							'pconnect' => FALSE,
							'db_debug' => TRUE,
							'cache_on' => FALSE,
							'cachedir' => '',
							'char_set' => 'utf8',
							'dbcollat' => 'utf8_general_ci',
							'swap_pre' => '',
							'encrypt' => FALSE,
							'compress' => FALSE,
							'stricton' => FALSE,
							'failover' => array(),
							'save_queries' => TRUE
					);";
	
	fwrite($databaseFile, $content);
	chmod("../application/config/database.php",0644);
}
