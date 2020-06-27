<?php

error_reporting(E_ERROR | E_PARSE);

include('../application/config/database.php');

$taskType = $_POST["task_type"];
$newVersionNo = $_POST["version_no"];

$databaseHost = $db['default']['hostname'];
$database = $db['default']['database'];
$userName = $db['default']['username'];
$password = $db['default']['password'];

$mysqli = mysqli_connect($databaseHost, $userName, $password, $database);

if ($taskType == 'install') {
	install($newVersionNo, $mysqli);
} else if ($taskType == 'upgrade') {
	if (mysqli_query($mysqli, "SELECT * FROM `common_configurations`")) {
		$result = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `config_filed_value` FROM `common_configurations` WHERE `config_filed_name` LIKE 'e_stock_manager_version_number'"));
	} else if (mysqli_query($mysqli, "SELECT * FROM `system_common_configurations`")) {
		$result = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `config_filed_value` FROM `system_common_configurations` WHERE `config_filed_name` LIKE 'e_stock_manager_version_number'"));
	}

	$currentVersionNo = $result['config_filed_value'];
	upgrade($currentVersionNo, $newVersionNo, $mysqli);
}

function install($newVersionNo, $mysqli) {

	$newVersionNoElements = explode(".", $newVersionNo);
	$newVersionNoMajor = $newVersionNoElements[0];
	$newVersionNoMinor = $newVersionNoElements[1];

	$newVersionNoElements = explode(" ", $newVersionNoMinor);
	$newVersionNoMinor = $newVersionNoElements[0];
	$newVersionNoBetaVersionNo = $newVersionNoElements[2];

	$endFolderNameWithBetaVersion = "version_" . $newVersionNoMajor . "_" . $newVersionNoMinor . "_beta_" . $newVersionNoBetaVersionNo;
	$endFolderNameWithoutBetaVersion = "version_" . $newVersionNoMajor . "_" . $newVersionNoMinor;

	$moduleFolderNames = array("systemManagerModule", "organizationManagerModule", "accountsManagerModule", 
							   "userRoleManagerModule", "serviceManagerModule");
	
	$serviceManagerSubModuleFolderNames = array("reservationManagerModule", "donationManagerModule");
	
	$subModulesExists = array("systemManagerModule" => false, "organizationManagerModule" => false, "accountsManagerModule" => false, "userRoleManagerModule" => false, "serviceManagerModule" => true);

	$systemManagerSectionNames = array("adminSection");
	$organizationManagerSectionNames = array("adminSection", "organizationSection");
	$accountsManagerSectionNames = array("adminSection", "bookkeepingSection");
	$userRoleManagerSectionNames = array("userRolesSection");
	$reservationManagerSectionNames = array("adminSection");
	$donationManagerSectionNames = array("adminSection", "donationSection");
	
	$versionNoMajor = 1;
	$versionNoMinor = 0;
	$versionNoBetaVersionNo = 1;

	$newVersionFolderReached = false;
	$newVersionChangesExecuted = false;

	$errorsFound = false;
	$result = '';
	$message = '';
	while (true) {

		$systemBetaVersionExists = false;
		$systemMinorVersionExists = false;

		$folderNameWithBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor . "_beta_" . $versionNoBetaVersionNo;
		$folderNameWithoutBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor;

		if (!$newVersionChangesExecuted) {
			foreach ($moduleFolderNames as $moduleFolderName) {

				switch ($moduleFolderName) {

					case "systemManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($systemManagerSectionNames as $systemManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $systemManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $systemManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($systemManagerSectionName) {

									case "adminSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "system_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "system_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;

					case "organizationManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($organizationManagerSectionNames as $organizationManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $organizationManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $organizationManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($organizationManagerSectionName) {

									case "adminSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "admin_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "admin_data.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										$path = $originalPath;

										break;

									case "organizationSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "organization_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "organization_data.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;
					
					case "accountsManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($accountsManagerSectionNames as $accountsManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $accountsManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $accountsManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($accountsManagerSectionName) {

									case "adminSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "admin_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "admin_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									case "bookkeepingSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "bookkeeping_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "bookkeeping_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;

					case "userRoleManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($userRoleManagerSectionNames as $userRoleManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $userRoleManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $userRoleManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($userRoleManagerSectionName) {

									case "userRolesSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "user_role_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "user_role_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;

					case "serviceManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						if ($subModulesExists["serviceManagerModule"]) {
							
							foreach ($serviceManagerSubModuleFolderNames as $serviceManagerSubModuleFolderName) {

								switch ($serviceManagerSubModuleFolderName) {
									
									case "reservationManagerModule" :

										foreach ($reservationManagerSectionNames as $reservationManagerSectionName) {
										
											$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $reservationManagerSectionName . "/" . $folderNameWithBetaVersion;
											$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $reservationManagerSectionName . "/" . $folderNameWithoutBetaVersion;

											if (is_dir($pathWithBetaVersion)) {
												$path = $pathWithBetaVersion;
												$moduleBetaVersionExists = true;
												$systemBetaVersionExists = true;

												if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else if (is_dir($pathWithoutBetaVersion)) {
												$path = $pathWithoutBetaVersion;
												$moduleMinorVersionExists = true;
												$systemMinorVersionExists = true;

												if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else {
												$moduleBetaVersionExists = false;
												$moduleMinorVersionExists = false;
											}

											if ($newVersionFolderReached) {
												$newVersionChangesExecuted = true;
											}

											if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

												$originalPath = $path;

												switch ($reservationManagerSectionName) {

													case "adminSection":

														/*Creating structure tables*/
														/*=========================*/

														$path = $path . "/" . "admin_structure.sql";

														if (file_exists($path)) {
															$queryList = getQueries($path);
															$i = 1;

															if (!$errorsFound) {
																foreach ($queryList as $q) {
																	mysqli_query($mysqli, $q);
																	if (mysqli_errno($mysqli)) {
																		$errorsFound = true;
																		$result = 'error';
																		$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																		break;
																	}
																	$i++;
																}
															}
														}

														/*Populating tables*/
														/*=================*/

														$path = $originalPath;

														$path = $path . "/" . "admin_data.sql";

															if (file_exists($path)) {
																$queryList = getQueries($path);
																$i = 1;

																if (!$errorsFound) {
																	foreach ($queryList as $q) {
																		mysqli_query($mysqli, $q);
																		if (mysqli_errno($mysqli)) {
																			$errorsFound = true;
																			$result = 'error';
																			$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																			break;
																		}
																		$i++;
																	}
																}
															}

															$path = $originalPath;

														break;

													default:
														break;
												}
											}
										}
										
										break;
									
									case "donationManagerModule" :

										foreach ($donationManagerSectionNames as $donationManagerSectionName) {
										
											$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $donationManagerSectionName . "/" . $folderNameWithBetaVersion;
											$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $donationManagerSectionName . "/" . $folderNameWithoutBetaVersion;

											if (is_dir($pathWithBetaVersion)) {
												$path = $pathWithBetaVersion;
												$moduleBetaVersionExists = true;
												$systemBetaVersionExists = true;

												if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else if (is_dir($pathWithoutBetaVersion)) {
												$path = $pathWithoutBetaVersion;
												$moduleMinorVersionExists = true;
												$systemMinorVersionExists = true;

												if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else {
												$moduleBetaVersionExists = false;
												$moduleMinorVersionExists = false;
											}

											if ($newVersionFolderReached) {
												$newVersionChangesExecuted = true;
											}

											if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

												$originalPath = $path;

												switch ($donationManagerSectionName) {

													case "adminSection":

														/*Creating structure tables*/
														/*=========================*/

														$path = $path . "/" . "admin_structure.sql";

														if (file_exists($path)) {
															$queryList = getQueries($path);
															$i = 1;

															if (!$errorsFound) {
																foreach ($queryList as $q) {
																	mysqli_query($mysqli, $q);
																	if (mysqli_errno($mysqli)) {
																		$errorsFound = true;
																		$result = 'error';
																		$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																		break;
																	}
																	$i++;
																}
															}
														}

														/*Populating tables*/
														/*=================*/

														$path = $originalPath;

														$path = $path . "/" . "admin_data.sql";

															if (file_exists($path)) {
																$queryList = getQueries($path);
																$i = 1;

																if (!$errorsFound) {
																	foreach ($queryList as $q) {
																		mysqli_query($mysqli, $q);
																		if (mysqli_errno($mysqli)) {
																			$errorsFound = true;
																			$result = 'error';
																			$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																			break;
																		}
																		$i++;
																	}
																}
															}

															$path = $originalPath;

														break;

													case "donationSection":

														/*Creating structure tables*/
														/*=========================*/

														$path = $path . "/" . "donation_structure.sql";

														if (file_exists($path)) {
															$queryList = getQueries($path);
															$i = 1;

															if (!$errorsFound) {
																foreach ($queryList as $q) {
																	mysqli_query($mysqli, $q);
																	if (mysqli_errno($mysqli)) {
																		$errorsFound = true;
																		$result = 'error';
																		$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																		break;
																	}
																	$i++;
																}
															}
														}

														/*Populating tables*/
														/*=================*/

														$path = $originalPath;

														$path = $path . "/" . "donation_data.sql";

															if (file_exists($path)) {
																$queryList = getQueries($path);
																$i = 1;

																if (!$errorsFound) {
																	foreach ($queryList as $q) {
																		mysqli_query($mysqli, $q);
																		if (mysqli_errno($mysqli)) {
																			$errorsFound = true;
																			$result = 'error';
																			$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																			break;
																		}
																		$i++;
																	}
																}
															}

															$path = $originalPath;

														break;
														
													default:
														break;
												}
											}
										}
										
										break;

									default:
										break;
								}
							}
						}
						
						break;
					
					default:
						break;
				} 
			}
		}

		if ($newVersionChangesExecuted) {
			break;
		}

		if ($systemBetaVersionExists) {
			$versionNoBetaVersionNo++;
		} else if ($systemMinorVersionExists) {
			$versionNoMinor++;
			$versionNoBetaVersionNo = 1;
		} else if (!$systemBetaVersionExists && !$systemMinorVersionExists) {
			$versionNoMajor++;
			$versionNoMinor = 0;
			$versionNoBetaVersionNo = 1;
		}
	}

	if (!$errorsFound) {
		$result = 'ok';
		$message = 'System installed successfully. Click on "Next" button to login to the system.';
	}

	echo json_encode(array('result' => $result, 'message' => $message));
}

function upgrade($currentVersionNo, $newVersionNo, $mysqli) {

	$newVersionNoElements = explode(".", $newVersionNo);
	$newVersionNoMajor = $newVersionNoElements[0];
	$newVersionNoMinor = $newVersionNoElements[1];

	$newVersionNoElements = explode(" ", $newVersionNoMinor);
	$newVersionNoMinor = $newVersionNoElements[0];
	$newVersionNoBetaVersionNo = $newVersionNoElements[2];

	$endFolderNameWithBetaVersion = "version_" . $newVersionNoMajor . "_" . $newVersionNoMinor . "_beta_" . $newVersionNoBetaVersionNo;
	$endFolderNameWithoutBetaVersion = "version_" . $newVersionNoMajor . "_" . $newVersionNoMinor;

	$moduleFolderNames = array("systemManagerModule", "organizationManagerModule", "accountsManagerModule", 
							   "userRoleManagerModule", "serviceManagerModule");

	$serviceManagerSubModuleFolderNames = array("reservationManagerModule", "donationManagerModule");
	
	$subModulesExists = array("systemManagerModule" => false, "organizationManagerModule" => false, "accountsManagerModule" => false, "userRoleManagerModule" => false, "serviceManagerModule" => true);
	
	$systemManagerSectionNames = array("adminSection");
	$organizationManagerSectionNames = array("adminSection", "organizationSection");
	$accountsManagerSectionNames = array("adminSection", "bookkeepingSection");
	$userRoleManagerSectionNames = array("userRolesSection");
	$reservationManagerSectionNames = array("adminSection");
	$donationManagerSectionNames = array("adminSection", "donationSection");
	
	$currentVersionNoElements = explode(".", $currentVersionNo);
	$currentVersionNoMajor = $currentVersionNoElements[0];
	$currentVersionNoMinor = $currentVersionNoElements[1];

	$currentVersionNoElements = explode(" ", $currentVersionNoMinor);
	$currentVersionNoMinor = $currentVersionNoElements[0];
	$currentVersionNoBetaVersionNo = $currentVersionNoElements[2];

	$versionNoMajor = (int)$currentVersionNoMajor;
	$versionNoMinor = (int)$currentVersionNoMinor;
	$versionNoBetaVersionNo = (int)$currentVersionNoBetaVersionNo + 1;

	$newVersionFolderReached = false;
	$newVersionChangesExecuted = false;

	$errorsFound = false;
	while (true) {

		$systemBetaVersionExists = false;
		$systemMinorVersionExists = false;

		$folderNameWithBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor . "_beta_" . $versionNoBetaVersionNo;
		$folderNameWithoutBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor;

		if (!$newVersionChangesExecuted) {
			foreach ($moduleFolderNames as $moduleFolderName) {

				switch ($moduleFolderName) {

					case "systemManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($systemManagerSectionNames as $systemManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $systemManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $systemManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($systemManagerSectionName) {

									case "adminSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "system_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "system_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;

					case "organizationManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($organizationManagerSectionNames as $organizationManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $organizationManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $organizationManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($organizationManagerSectionName) {

									case "adminSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "admin_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "admin_data.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										$path = $originalPath;

										break;

									case "organizationSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "organization_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "organization_data.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;

					case "accountsManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($accountsManagerSectionNames as $accountsManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $accountsManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $accountsManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($accountsManagerSectionName) {

									case "adminSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "admin_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "admin_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									case "bookkeepingSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "bookkeeping_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "bookkeeping_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;

					case "userRoleManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						foreach ($userRoleManagerSectionNames as $userRoleManagerSectionName) {

							$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $userRoleManagerSectionName . "/" . $folderNameWithBetaVersion;
							$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $userRoleManagerSectionName . "/" . $folderNameWithoutBetaVersion;

							if (is_dir($pathWithBetaVersion)) {
								$path = $pathWithBetaVersion;
								$moduleBetaVersionExists = true;
								$systemBetaVersionExists = true;

								if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else if (is_dir($pathWithoutBetaVersion)) {
								$path = $pathWithoutBetaVersion;
								$moduleMinorVersionExists = true;
								$systemMinorVersionExists = true;

								if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
									$newVersionFolderReached = true;
								}
							} else {
								$moduleBetaVersionExists = false;
								$moduleMinorVersionExists = false;
							}

							if ($newVersionFolderReached) {
								$newVersionChangesExecuted = true;
							}

							if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

								$originalPath = $path;

								switch ($userRoleManagerSectionName) {

									case "userRolesSection":

										/*Creating structure tables*/
										/*=========================*/

										$path = $path . "/" . "user_role_structure.sql";

										if (file_exists($path)) {
											$queryList = getQueries($path);
											$i = 1;

											if (!$errorsFound) {
												foreach ($queryList as $q) {
													mysqli_query($mysqli, $q);
													if (mysqli_errno($mysqli)) {
														$errorsFound = true;
														$result = 'error';
														$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
														break;
													}
													$i++;
												}
											}
										}

										/*Populating tables*/
										/*=================*/

										$path = $originalPath;

										$path = $path . "/" . "user_role_data.sql";

											if (file_exists($path)) {
												$queryList = getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

										break;

									default:
										break;
								}
							}
						}

						break;

					case "serviceManagerModule":

						$moduleBetaVersionExists = false;
						$moduleMinorVersionExists = false;
						if ($subModulesExists["serviceManagerModule"]) {
							
							foreach ($serviceManagerSubModuleFolderNames as $serviceManagerSubModuleFolderName) {

								switch ($serviceManagerSubModuleFolderName) {
									
									case "reservationManagerModule" :

										foreach ($reservationManagerSectionNames as $reservationManagerSectionName) {
										
											$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $reservationManagerSectionName . "/" . $folderNameWithBetaVersion;
											$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $reservationManagerSectionName . "/" . $folderNameWithoutBetaVersion;

											if (is_dir($pathWithBetaVersion)) {
												$path = $pathWithBetaVersion;
												$moduleBetaVersionExists = true;
												$systemBetaVersionExists = true;

												if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else if (is_dir($pathWithoutBetaVersion)) {
												$path = $pathWithoutBetaVersion;
												$moduleMinorVersionExists = true;
												$systemMinorVersionExists = true;

												if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else {
												$moduleBetaVersionExists = false;
												$moduleMinorVersionExists = false;
											}

											if ($newVersionFolderReached) {
												$newVersionChangesExecuted = true;
											}

											if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

												$originalPath = $path;

												switch ($reservationManagerSectionName) {

													case "adminSection":

														/*Creating structure tables*/
														/*=========================*/

														$path = $path . "/" . "admin_structure.sql";

														if (file_exists($path)) {
															$queryList = getQueries($path);
															$i = 1;

															if (!$errorsFound) {
																foreach ($queryList as $q) {
																	mysqli_query($mysqli, $q);
																	if (mysqli_errno($mysqli)) {
																		$errorsFound = true;
																		$result = 'error';
																		$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																		break;
																	}
																	$i++;
																}
															}
														}

														/*Populating tables*/
														/*=================*/

														$path = $originalPath;

														$path = $path . "/" . "admin_data.sql";

															if (file_exists($path)) {
																$queryList = getQueries($path);
																$i = 1;

																if (!$errorsFound) {
																	foreach ($queryList as $q) {
																		mysqli_query($mysqli, $q);
																		if (mysqli_errno($mysqli)) {
																			$errorsFound = true;
																			$result = 'error';
																			$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																			break;
																		}
																		$i++;
																	}
																}
															}

															$path = $originalPath;

														break;

													default:
														break;
												}
											}
										}
										
										break;
									
									case "donationManagerModule" :

										foreach ($donationManagerSectionNames as $donationManagerSectionName) {
										
											$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $donationManagerSectionName . "/" . $folderNameWithBetaVersion;
											$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $serviceManagerSubModuleFolderName . "/" . $donationManagerSectionName . "/" . $folderNameWithoutBetaVersion;

											if (is_dir($pathWithBetaVersion)) {
												$path = $pathWithBetaVersion;
												$moduleBetaVersionExists = true;
												$systemBetaVersionExists = true;

												if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else if (is_dir($pathWithoutBetaVersion)) {
												$path = $pathWithoutBetaVersion;
												$moduleMinorVersionExists = true;
												$systemMinorVersionExists = true;

												if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
													$newVersionFolderReached = true;
												}
											} else {
												$moduleBetaVersionExists = false;
												$moduleMinorVersionExists = false;
											}

											if ($newVersionFolderReached) {
												$newVersionChangesExecuted = true;
											}

											if ($moduleBetaVersionExists || $moduleMinorVersionExists) {

												$originalPath = $path;

												switch ($donationManagerSectionName) {

													case "adminSection":

														/*Creating structure tables*/
														/*=========================*/

														$path = $path . "/" . "admin_structure.sql";

														if (file_exists($path)) {
															$queryList = getQueries($path);
															$i = 1;

															if (!$errorsFound) {
																foreach ($queryList as $q) {
																	mysqli_query($mysqli, $q);
																	if (mysqli_errno($mysqli)) {
																		$errorsFound = true;
																		$result = 'error';
																		$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																		break;
																	}
																	$i++;
																}
															}
														}

														/*Populating tables*/
														/*=================*/

														$path = $originalPath;

														$path = $path . "/" . "admin_data.sql";

															if (file_exists($path)) {
																$queryList = getQueries($path);
																$i = 1;

																if (!$errorsFound) {
																	foreach ($queryList as $q) {
																		mysqli_query($mysqli, $q);
																		if (mysqli_errno($mysqli)) {
																			$errorsFound = true;
																			$result = 'error';
																			$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																			break;
																		}
																		$i++;
																	}
																}
															}

															$path = $originalPath;

														break;
														
													case "donationSection":

														/*Creating structure tables*/
														/*=========================*/

														$path = $path . "/" . "donation_structure.sql";

														if (file_exists($path)) {
															$queryList = getQueries($path);
															$i = 1;

															if (!$errorsFound) {
																foreach ($queryList as $q) {
																	mysqli_query($mysqli, $q);
																	if (mysqli_errno($mysqli)) {
																		$errorsFound = true;
																		$result = 'error';
																		$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																		break;
																	}
																	$i++;
																}
															}
														}

														/*Populating tables*/
														/*=================*/

														$path = $originalPath;

														$path = $path . "/" . "donation_data.sql";

															if (file_exists($path)) {
																$queryList = getQueries($path);
																$i = 1;

																if (!$errorsFound) {
																	foreach ($queryList as $q) {
																		mysqli_query($mysqli, $q);
																		if (mysqli_errno($mysqli)) {
																			$errorsFound = true;
																			$result = 'error';
																			$message = "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n".'<br>';
																			break;
																		}
																		$i++;
																	}
																}
															}

															$path = $originalPath;

														break;

													default:
														break;
												}
											}
										}
										
										break;

									default:
										break;
								}
							}
						}
						
						break;
					
					default:
						break;
				} 
			}
		}

		if ($newVersionChangesExecuted) {
			break;
		}

		if ($systemBetaVersionExists) {
			$versionNoBetaVersionNo++;
		} else if ($systemMinorVersionExists) {
			$versionNoMinor++;
			$versionNoBetaVersionNo = 1;
		} else if (!$systemBetaVersionExists && !$systemMinorVersionExists) {
			$versionNoMajor++;
			$versionNoMinor = 0;
			$versionNoBetaVersionNo = 1;
		}
	}

	if (!$errorsFound) {
		$result = 'ok';
		$message = 'System upgraded successfully. Click on "Next" button to login to the system.';
	}

	echo json_encode(array('result' => $result, 'message' => $message));
}

function getQueries($path) {

	$queryString    = trim(file_get_contents($path));
	$rawQueryList   = preg_split('/;\s*$/m', $queryString);
	$queryList      = array();

	foreach ($rawQueryList as $query) {
		$query = trim($query);
		if (!empty($query)) {

			$queryList[] = $query;
		}
	}
	return $queryList;
}
