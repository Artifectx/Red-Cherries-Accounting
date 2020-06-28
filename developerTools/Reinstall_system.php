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

define("versionNo", "1.0 Beta 1");

class Reinstall_system {

	public function  __construct() {

		include('../application/config/database.php');

		$databaseHost = $db['default']['hostname'];
		$database = $db['default']['database'];
		$userName = $db['default']['username'];
		$password = $db['default']['password'];

		mysql_connect($databaseHost, $userName, $password);
		
		echo "\nSystem reinstallation started. Please be patient until the reinstallation gets completed. System will display the reinstallation successful message at the end....\n\n";

		if (mysql_query("DROP DATABASE `{$database}`")) {

			echo "\nExisting '{$database}' database was deleted.\n";

			if (mysql_query("CREATE DATABASE `{$database}`")) {
				echo "Created new '{$database}' database.\n";
				$mysqli = mysqli_connect($databaseHost, $userName, $password, $database);
				$this->executeDbQueries($mysqli);
			} else {
				echo "\nCouldn't create new '{$database}' database.\n";
			}
		} else {
			if (mysql_query("CREATE DATABASE `{$database}`")) {
				echo "Created new '{$database}' database.\n";
				$mysqli = mysqli_connect($databaseHost, $userName, $password, $database);
				$this->executeDbQueries($mysqli);
			} else {
				echo "\nCouldn't create new '{$database}' database.\n";
			}
		}
	}

	function executeDbQueries($mysqli) {

		$versionNoElements = explode(".", versionNo);
		$versionNoMajor = $versionNoElements[0];
		$versionNoMinor = $versionNoElements[1];

		$versionNoElements = explode(" ", $versionNoMinor);
		$versionNoMinor = $versionNoElements[0];
		$versionNoBetaVersionNo = $versionNoElements[2];

		$endFolderNameWithBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor . "_beta_" . $versionNoBetaVersionNo;
		$endFolderNameWithoutBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor;

		$moduleFolderNames = array("systemManagerModule", "organizationManagerModule", "accountsManagerModule",
			"userRoleManagerModule", "serviceManagerModule");

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
		echo '';
		while (true) {

			$betaVersionExists = false;
			$minorVersionExists = false;

			$folderNameWithBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor . "_beta_" . $versionNoBetaVersionNo;
			$folderNameWithoutBetaVersion = "version_" . $versionNoMajor . "_" . $versionNoMinor;

			if (!$newVersionChangesExecuted) {
				foreach ($moduleFolderNames as $moduleFolderName) {

					switch ($moduleFolderName) {

						case "systemManagerModule":

							$foundScriptsToExecute = false;
							foreach ($systemManagerSectionNames as $systemManagerSectionName) {

								$betaVersionExistsForSection = false;
								$minorVersionExistsForSection = false;
								
								$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $systemManagerSectionName . "/" . $folderNameWithBetaVersion;
								$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $systemManagerSectionName . "/" . $folderNameWithoutBetaVersion;

								if (is_dir($pathWithBetaVersion)) {
									$path = $pathWithBetaVersion;
									$betaVersionExists = true;
									$betaVersionExistsForSection = true;

									if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
										$newVersionFolderReached = true;
									}
								} else if (is_dir($pathWithoutBetaVersion)) {
									$path = $pathWithoutBetaVersion;
									$minorVersionExists = true;
									$minorVersionExistsForSection = true;

									if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
										$newVersionFolderReached = true;
									}
								} 

								if ($newVersionFolderReached) {
									$newVersionChangesExecuted = true;
								}

								if ($betaVersionExistsForSection || $minorVersionExistsForSection) {

									$originalPath = $path;
									
									switch ($systemManagerSectionName) {

										case "adminSection":

											/* Creating structure tables */
											/* ========================= */

											$path = $path . "/" . "system_structure.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											/* Populating tables */
											/* ================= */

											$path = $originalPath;

											$path = $path . "/" . "system_data.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
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
							
							if ($foundScriptsToExecute) {
								echo "\nSystem Manager Module table structure created and data populated successfully for version " . $versionNoMajor . "." . $versionNoMinor . " beta " . $versionNoBetaVersionNo . ".\n";
							}

							break;

						case "organizationManagerModule":

							$foundScriptsToExecute = false;
							foreach ($organizationManagerSectionNames as $organizationManagerSectionName) {

								$betaVersionExistsForSection = false;
								$minorVersionExistsForSection = false;
								
								$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $organizationManagerSectionName . "/" . $folderNameWithBetaVersion;
								$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $organizationManagerSectionName . "/" . $folderNameWithoutBetaVersion;

								if (is_dir($pathWithBetaVersion)) {
									$path = $pathWithBetaVersion;
									$betaVersionExists = true;
									$betaVersionExistsForSection = true;

									if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
										$newVersionFolderReached = true;
									}
								} else if (is_dir($pathWithoutBetaVersion)) {
									$path = $pathWithoutBetaVersion;
									$minorVersionExists = true;
									$minorVersionExistsForSection = true;

									if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
										$newVersionFolderReached = true;
									}
								}

								if ($newVersionFolderReached) {
									$newVersionChangesExecuted = true;
								}

								if ($betaVersionExistsForSection || $minorVersionExistsForSection) {

									$originalPath = $path;
									
									switch ($organizationManagerSectionName) {

										case "adminSection":

											/* Creating structure tables */
											/* ========================= */

											$path = $path . "/" . "admin_structure.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											/* Populating tables */
											/* ================= */

											$path = $originalPath;

											$path = $path . "/" . "admin_data.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

											break;

										case "organizationSection":

											/* Creating structure tables */
											/* ========================= */

											$path = $path . "/" . "organization_structure.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											/* Populating tables */
											/* ================= */

											$path = $originalPath;

											$path = $path . "/" . "organization_data.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
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
							
							if ($foundScriptsToExecute) {
								echo "\nOrganization Manager Module table structure created and data populated successfully for version " . $versionNoMajor . "." . $versionNoMinor . " beta " . $versionNoBetaVersionNo . ".\n";
							}

							break;

						case "accountsManagerModule":

							$foundScriptsToExecute = false;
							foreach ($accountsManagerSectionNames as $accountsManagerSectionName) {

								$betaVersionExistsForSection = false;
								$minorVersionExistsForSection = false;
								
								$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $accountsManagerSectionName . "/" . $folderNameWithBetaVersion;
								$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $accountsManagerSectionName . "/" . $folderNameWithoutBetaVersion;

								if (is_dir($pathWithBetaVersion)) {
									$path = $pathWithBetaVersion;
									$betaVersionExists = true;
									$betaVersionExistsForSection = true;

									if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
										$newVersionFolderReached = true;
									}
								} else if (is_dir($pathWithoutBetaVersion)) {
									$path = $pathWithoutBetaVersion;
									$minorVersionExists = true;
									$minorVersionExistsForSection = true;

									if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
										$newVersionFolderReached = true;
									}
								}

								if ($newVersionFolderReached) {
									$newVersionChangesExecuted = true;
								}

								if ($betaVersionExistsForSection || $minorVersionExistsForSection) {

									$originalPath = $path;
									
									switch ($accountsManagerSectionName) {

										case "adminSection":

											/* Creating structure tables */
											/* ========================= */

											$path = $path . "/" . "admin_structure.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											/* Populating tables */
											/* ================= */

											$path = $originalPath;

											$path = $path . "/" . "admin_data.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											$path = $originalPath;

											break;

										case "bookkeepingSection":

											/* Creating structure tables */
											/* ========================= */

											$path = $path . "/" . "bookkeeping_structure.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											/* Populating tables */
											/* ================= */

											$path = $originalPath;

											$path = $path . "/" . "bookkeeping_data.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
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

							if ($foundScriptsToExecute) {
								echo "\nAccounts Manager Module table structure created and data populated successfully for version " . $versionNoMajor . "." . $versionNoMinor . " beta " . $versionNoBetaVersionNo . ".\n";
							}
							
							break;

						case "userRoleManagerModule":

							$foundScriptsToExecute = false;
							foreach ($userRoleManagerSectionNames as $userRoleManagerSectionName) {

								$betaVersionExistsForSection = false;
								$minorVersionExistsForSection = false;
								
								$pathWithBetaVersion = "../database/" . $moduleFolderName . "/" . $userRoleManagerSectionName . "/" . $folderNameWithBetaVersion;
								$pathWithoutBetaVersion = "../database/" . $moduleFolderName . "/" . $userRoleManagerSectionName . "/" . $folderNameWithoutBetaVersion;

								if (is_dir($pathWithBetaVersion)) {
									$path = $pathWithBetaVersion;
									$betaVersionExists = true;
									$betaVersionExistsForSection = true;

									if ($folderNameWithBetaVersion == $endFolderNameWithBetaVersion) {
										$newVersionFolderReached = true;
									}
								} else if (is_dir($pathWithoutBetaVersion)) {
									$path = $pathWithoutBetaVersion;
									$minorVersionExists = true;
									$minorVersionExistsForSection = true;

									if ($folderNameWithoutBetaVersion == $endFolderNameWithoutBetaVersion) {
										$newVersionFolderReached = true;
									}
								}

								if ($newVersionFolderReached) {
									$newVersionChangesExecuted = true;
								}

								if ($betaVersionExistsForSection || $minorVersionExistsForSection) {

									$originalPath = $path;
									
									switch ($userRoleManagerSectionName) {

										case "userRolesSection":

											/* Creating structure tables */
											/* ========================= */

											$path = $path . "/" . "user_role_structure.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
															break;
														}
														$i++;
													}
												}
											}

											/* Populating tables */
											/* ================= */

											$path = $originalPath;

											$path = $path . "/" . "user_role_data.sql";

											if (file_exists($path)) {
												
												$foundScriptsToExecute = true;
												$queryList = $this->getQueries($path);
												$i = 1;

												if (!$errorsFound) {
													foreach ($queryList as $q) {
														mysqli_query($mysqli, $q);
														if (mysqli_errno($mysqli)) {
															$errorsFound = true;
															$result = 'error';
															echo "Error with create query $i in script $path : $q. Error details: " . mysqli_error($mysqli) . ".<br>\n" . '<br>';
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

							if ($foundScriptsToExecute) {
								echo "\nUser Role Manager Module table structure created and data populated successfully for version " . $versionNoMajor . "." . $versionNoMinor . " beta " . $versionNoBetaVersionNo . ".\n";
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

			if ($betaVersionExists) {
				$versionNoBetaVersionNo++;
			} else if ($minorVersionExists) {
				$versionNoMinor++;
				$versionNoBetaVersionNo = 1;
			} else if (!$betaVersionExists && !$minorVersionExists) {
				$versionNoMajor++;
				$versionNoMinor = 0;
				$versionNoBetaVersionNo = 1;
			}
		}

		if (!$errorsFound) {
			echo "\nSystem reinstalled successfully.\n\n";
		}
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
}