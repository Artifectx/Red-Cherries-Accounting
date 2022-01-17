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

defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/../../../libraries/PHPExcelLibrary/PHPExcel.php';

class Journal_entry_bulk_upload_controller extends CI_Controller {
    
	public function  __construct() {

		parent::__construct();
        
        //get database
		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//current date time
		$this->date = date("Y-m-d H:i");

		//load language
		$language = $this->userManagement->getUserLanguage($this->user_id);

		$this->lang->load('form_lang', $language);
		$this->lang->load('message', $language);

		//get user theme
		$this->data['theme'] = $this->userManagement->getUserTheme($this->user_id);

		//get user permission
		$this->data = $this->userManagement->getUserPermissions($this->data);

		//Load version number
		$this->data['version_no'] = $this->userManagement->getSystemVersionNumber();

		$this->data['show_footer'] = true;

		//load models
        $this->load->model('accountsManagerModule/adminSection/prime_entry_book_model', '', TRUE);
		$this->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);
        $this->load->model('accountsManagerModule/adminSection/financial_year_ends_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/journal_entries_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/purchase_note_model', '', TRUE);
		$this->load->model('accountsManagerModule/bookkeepingSection/sales_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/supplier_return_note_model', '', TRUE);
        $this->load->model('accountsManagerModule/bookkeepingSection/customer_return_note_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
        $this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
        $this->load->helper('download');
		$this->load->helper('url');
		
		$this->load->library('common_library/common_functions');

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
	}

	public function index() {
		//set selected menu
		$data_cls['ul_class_bookkeeping_section'] = 'in nav nav-stacked';
		$data_cls['li_class_journal_entry_bulk_upload'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

		$this->data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

		$this->data['systemConfigData'] = $this->getSystemConfigData();
		
		if(isset($this->data['ACM_Bookkeeping_View_Journal_Entry_Bulk_Upload_Permissions'])) {
			$this->load->view('web/accountsManagerModule/bookkeepingSection/journalEntryBulkUpload/index', $this->data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}

		return $configData;
	}
	
    public function handleDataImport() {
		//set selected menu
		if($this->input->post('data_import') == "download_journal_entry_import_template") { 

			$this->downloadOpeningBalancesDataImportWorkbook();
		} else if ($this->input->post('data_import') == "download_data_validation_error_file") {

			$this->downloadDataValidationErrorFile();
		}
	}
    
    public function downloadOpeningBalancesDataImportWorkbook() {

		$data = file_get_contents(base_url() . "/dataUpload/dataTemplates/Templates/Journal_Entry_Bulk_Upload.xlsx"); // Read the file's contents
		$name = 'Journal_Entry_Bulk_Upload.xlsx';

		force_download($name, $data);
	}
    
    public function downloadDataValidationErrorFile() {
		//set selected menu
		$data_cls['ul_class_bookkeeping_section'] = 'in nav nav-stacked';
		$data_cls['li_class_journal_entry_bulk_upload'] = 'active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf')) {
			$data = file_get_contents(base_url() . "/dataUpload/importData/Data_Import_Validation_Errors.pdf"); // Read the file's contents
			$name = 'Data_Import_Validation_Errors.pdf';

			force_download($name, $data);
		} else {
			$msg = "There are no workbook errors";
			$this->data['message'] = '<div class="alert alert-warning alert-dismissable">
							<a class="close" href="#" data-dismiss="alert">× </a>
							<h4><i class="icon-ok-sign"></i>'.
							$this->lang->line('warning').'</h4>'.
							$this->lang->line($msg).
							'</div>';
            
            $language = $this->userManagement->getUserLanguage($this->user_id);
            
            $menuFormatting = '';
            if ($language == "sinhala") {
                $menuFormatting = 'style="font-weight: bold;"';
            }

            $this->data['menuFormatting'] = $menuFormatting;

            $this->data['default_row_count_for_table'] = '25'; //TO DO : Make this a system configuration

            $this->load->view('web/systemManagerModule/header/header', $this->data);
            $this->load->view('web/systemManagerModule/dashboard/menu_accounts_manager', $data_cls);

            if(isset($this->data['ACM_Bookkeeping_View_Journal_Entry_Bulk_Upload_Permissions'])) {
                $this->load->view('web/accountsManagerModule/bookkeepingSection/journalEntryBulkUpload/index', $this->data);
            }

            $this->load->view('web/systemManagerModule/footer/footer', $this->data);
		}
	}

	public function add() {
		if(isset($this->data['ACM_Bookkeeping_Add_Journal_Entry_Bulk_Upload_Permissions'])) {
			
            $status = "";
            $msg = "";
            $fileElementName = 'file_to_upload';
            $fileName = $this->db->escape_str($this->input->post('file_name'));
            $uploadFileName = "Journal_Entry_Bulk_Upload_List";

            $config['upload_path'] = 'dataUpload/importData';
            $config['allowed_types'] = 'xlsx';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = FALSE;
            $config['file_name'] = $uploadFileName;
            $config['overwrite'] = 'TRUE';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($fileElementName)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                move_uploaded_file('dataUpload/importData' . $fileElementName, 'dataUpload/importData' . $uploadFileName);
                $status = "success";
                $msg = "Document successfully uploaded";
            }
            @unlink($_FILES[$fileElementName]);

            //Validate data import Excell file and load data to the screen

            if ($status == "success") {
                
                $validateResult = $this->validateDataImportWorkbook();

                if ($validateResult['status'] == true) {
                    $status = $this->saveJournalEntriesForBulkPost($validateResult['result']);
                } else {
                    $status = "error";
                }
            }

            echo $status;
		}
	}
    
    public function validateDataImportWorkbook() {

		$noWorkbookErrors = true;
		$inputFileType = 'Excel2007';
		$inputFileName = '';

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Journal_Entry_Bulk_Upload_List.xlsx')) {
			$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/Journal_Entry_Bulk_Upload_List.xlsx';
		}

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);

		$workbookResult['Journal_Entry_List'] = $this->validateJournalEntryBulkUploadInformation($objPHPExcel->setActiveSheetIndexbyName('Journal_Entry_List'));
        
		$dataWorkbookErrors = FALSE;

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx');
		}

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf');
		}

		$this->createDataImportValidationErrorExcelFile();

		//Handle journal entry list.
		if ($workbookResult['Journal_Entry_List']['Journal_Entry_List_Errors'] != '') {
			$dataWorkbookErrors = TRUE;
			$this->writeDataImportValidationErrorsToAFile('Journal_Entry_List_Errors', $workbookResult['Journal_Entry_List']['Journal_Entry_List_Errors']);
		}
        
		//Create data error PDF document.
		if ($dataWorkbookErrors) {
			$noWorkbookErrors = false;
			$this->createDataWorkbookErrorPDF();
		}
        
        return array('status' => $noWorkbookErrors, 'result' => $workbookResult);
	}
    
    public function validateJournalEntryBulkUploadInformation($JournalEntriesWorksheet) {
		
        $locationList = $this->locations_model->getAll('location_name', 'asc');
        $primeEntryBookList = $this->prime_entry_book_model->getAllPrimeEntryBooks('prime_entry_book_name', 'asc');
		$chartOfAccountList = $this->chart_of_accounts_model->getAll();
        $peopleList = $this->peoples_model->getAll('people_code', 'asc');
        
		$count = 2;
		$journalEntryDates = '';
		while ($JournalEntriesWorksheet->getCell('A' . $count)->getValue() != '') {
			$journalEntryDates[$count] = $JournalEntriesWorksheet->getCell('A' . $count)->getValue();
			$locations[$count] = $JournalEntriesWorksheet->getCell('B' . $count)->getValue();
            $primeEntryBooks[$count] = $JournalEntriesWorksheet->getCell('C' . $count)->getValue();
            $stakeholderCodes[$count] = $JournalEntriesWorksheet->getCell('D' . $count)->getValue();
            $referenceNos[$count] = $JournalEntriesWorksheet->getCell('E' . $count)->getValue();
            $descriptions[$count] = $JournalEntriesWorksheet->getCell('F' . $count)->getValue();
            $debitChartOfAccounts[$count] = $JournalEntriesWorksheet->getCell('G' . $count)->getValue();
            $creditChartOfAccounts[$count] = $JournalEntriesWorksheet->getCell('H' . $count)->getValue();
            $amounts[$count] = $JournalEntriesWorksheet->getCell('I' . $count)->getValue();
            $referenceTransactionReferenceNos[$count] = $JournalEntriesWorksheet->getCell('J' . $count)->getValue();
			$count++;
		}
		
		$count = 2;
		$errorsFound = false;
		$journalEntryBulkUploadErrors = null;
		$journalEntryBulkUploadList = '';
        $locationIds = array();
        $primeEntryBookIds = array();
        $stakeholderIds = array();
        $newReferenceNos = array();
        $debitChartOfAccountIds = array();
        $creditChartOfAccountIds = array();
        
		if ($journalEntryDates != '') {
            
            $errorCount = 1;
            
			foreach ($journalEntryDates as $journalEntryDate) {
                
                if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $journalEntryDate)) {
                    $journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Journal Entry Date" ' . $journalEntryDate . ' should be in yyyy-mm-dd format';
                    $errorsFound = true;
                    $errorCount++;
                }
                
                if ($this->isAccountsManagementForLocationsEnabled() && $locations[$count] == '') {
                    $journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Location" cannot be empty';
                    $errorsFound = true;
                    $errorCount++;
                }
                
                $locationFound = false;
                
                if ($locationList && sizeof($locationList) > 0) {
					foreach ($locationList as $location) {
						if ($location->location_name == $locations[$count]) {
							$locationFound = true;
							$locationIds[$count] = $location->location_id;
							break;
						} else {
                            $locationIds[$count] = '';
                        }
					}

					if ($locations[$count] != '' && !$locationFound) {
						$journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Location" ' . $locations[$count] . ' is not found in the system';
                        $errorsFound = true;
                        $errorCount++;
					}
				} else {
                    $locationIds[$count] = '';
                }
                
                $primeEntryBookFound = false;
                
                if ($primeEntryBookList && sizeof($primeEntryBookList) > 0) {
					foreach ($primeEntryBookList as $primeEntryBook) {
						if ($primeEntryBook->prime_entry_book_name == $primeEntryBooks[$count]) {
							$primeEntryBookFound = true;
							$primeEntryBookIds[$count] = $primeEntryBook->prime_entry_book_id;
							break;
						} else {
                            $primeEntryBookIds[$count] = '';
                        }
					}

					if ($primeEntryBooks[$count] != '' && !$primeEntryBookFound) {
						$journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Prime Entry Book" ' . $primeEntryBooks[$count] . ' is not found in the system';
                        $errorsFound = true;
                        $errorCount++;
					}
				}
				
                $stakeholderFound = false;
				
				if ($peopleList && sizeof($peopleList) > 0) {
					foreach ($peopleList as $people) {
						if ($people->people_code == $stakeholderCodes[$count]) {
							$stakeholderFound = true;
							$stakeholderIds[$count] = $people->people_id;
							break;
						} else {
                            $stakeholderIds[$count] = '';
                        }
					}

					if ($stakeholderCodes[$count] != '' && !$stakeholderFound) {
						$journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Stakeholder Code" ' . $stakeholderCodes[$count] . ' is invalid';
                        $errorsFound = true;
                        $errorCount++;
					}
				}
                
                if ($referenceNos[$count] != '') {
                    $newReferenceNos[$count] = $referenceNos[$count];
                }
                
                if ($debitChartOfAccounts[$count] != '') {
                    
                    $debitChartOfAccountFound = false;

                    if ($chartOfAccountList && sizeof($chartOfAccountList) > 0) {
                        foreach ($chartOfAccountList as $chartOfAccount) {
                            if ($chartOfAccount->text == $debitChartOfAccounts[$count]) {
                                $debitChartOfAccountFound = true;
                                $debitChartOfAccountIds[$count] = $chartOfAccount->chart_of_account_id;
                                break;
                            }
                        }

                        if (!$debitChartOfAccountFound) {
                            $journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Debit Chart of Account" ' . $debitChartOfAccounts[$count] . ' given is not found in the system';
                            $errorsFound = true;
                            $errorCount++;
                        }
                    }
                } else {
                    $debitChartOfAccountIds[$count] = '';
                }
                
                if ($creditChartOfAccounts[$count] != '') {
                    
                    $creditChartOfAccountFound = false;

                    if ($chartOfAccountList && sizeof($chartOfAccountList) > 0) {
                        foreach ($chartOfAccountList as $chartOfAccount) {
                            if ($chartOfAccount->text == $creditChartOfAccounts[$count]) {
                                $creditChartOfAccountFound = true;
                                $creditChartOfAccountIds[$count] = $chartOfAccount->chart_of_account_id;
                                break;
                            }
                        }

                        if (!$creditChartOfAccountFound) {
                            $journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Credit Chart of Account" ' . $creditChartOfAccounts[$count] . ' given is not found in the system';
                            $errorsFound = true;
                            $errorCount++;
                        }
                    }
                } else {
                    $creditChartOfAccountIds[$count] = '';
                }
                
                if ($primeEntryBookFound == false && $debitChartOfAccountFound == false && $creditChartOfAccountFound == false) {
                    $journalEntryBulkUploadErrors[$errorCount . "-" . $count] = 'Either a prime entry book or debit and credit chart of accounts should be specified.';
                    $errorsFound = true;
                    $errorCount++;
                }
                
                if ($amounts[$count] != '') {
					if (!filter_var($amounts[$count], FILTER_VALIDATE_FLOAT)) {
						$journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Amount" given is not a double value';
						$errorsFound = true;
                        $errorCount++;
					}
				} else {
                    $journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Amount" cannot be empty';
                    $errorsFound = true;
                    $errorCount++;
                }
                
                if ($referenceTransactionReferenceNos[$count] != '') {
                    $journalEntry = $this->journal_entries_model->getJournalEntryByReferenceNo($referenceTransactionReferenceNos[$count]);
                    
                    if (!$journalEntry) {
                        if (!in_array($referenceTransactionReferenceNos[$count], $newReferenceNos)) {
                            $journalEntryBulkUploadErrors[$errorCount . "-" . $count] = '"Reference Transaction Journal Entry Reference No" ' . $referenceTransactionReferenceNos[$count] . ' given is not found';
                            $errorsFound = true;
                            $errorCount++;
                        }
                    }
                }
				
				if (!$errorsFound) {
					
					$journalEntryBulkUploadList[] = array($journalEntryDate, $locationIds[$count], $primeEntryBookIds[$count],
                                $stakeholderIds[$count], $referenceNos[$count], $descriptions[$count], $debitChartOfAccountIds[$count],
                                $creditChartOfAccountIds[$count], $amounts[$count], $referenceTransactionReferenceNos[$count]);
				}

				$count++;
			}
		}

		return array('Journal_Entry_List_Errors' => $journalEntryBulkUploadErrors, 'Journal_Entry_List' => $journalEntryBulkUploadList);
	}
    
    public function createDataImportValidationErrorExcelFile() {

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Data Import Validation Errors');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(110);
		$objPHPExcel->getActiveSheet()->setShowGridlines(false);

		$styleThinBlackBorderOutline = array(
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => 'FF000000'),
						),
				),
		);

		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setItalic(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleThinBlackBorderOutline);

		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data import Excel work book has the following data errors. '
															 . 'Please correct the errors and re-upload.');

		// Do your stuff here
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx';

		$writer->save($filePath);
		chmod($filePath,0755); // CHMOD file
	}
    
    public function writeDataImportValidationErrorsToAFile($errorPage, $errorList) {

		$styleThinBlackBorderOutline = array(
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => 'FF000000'),
						),
				),
		);

		if ($errorPage == 'Journal_Entry_List_Errors') {

			$inputFileType = 'Excel2007';
			$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx';
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);

			$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
			$objPHPExcel->getActiveSheet()->getRowDimension($highestRow + 1)->setRowHeight(20);
			$count = $highestRow + 2;

			$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(30);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFont()->setSize(15);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFill()->getStartColor()->setARGB('FF00BFFF');
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->applyFromArray($styleThinBlackBorderOutline);

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, '"Journal Entry List" Sheet Errors');

			$errorCount = 0;

			foreach($errorList as $key => $error) {

                $rowCountData = explode("-", $key);
                $rowCount = $rowCountData[1];
				$count++;
				$errorCount++;
				$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, ' ' . $errorCount . '. [Row Number - ' . $rowCount . '] ' . $error);
			}

			$objPHPExcel->getActiveSheet()->getStyle('A' . $highestRow . ':A' . $count)->applyFromArray($styleThinBlackBorderOutline);

			// Do your stuff here
			$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx';

			$writer->save($filePath);
			chmod($filePath,0755); // CHMOD file
		}  
	}
    
    public function createDataWorkbookErrorPDF() {

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf');
		}

		$inputFileType = 'Excel2007';
		$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx';
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);

		$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
		$rendererLibrary = 'domPDF60B3';
		$rendererLibraryPath = dirname(__FILE__).'/../../../libraries/' . $rendererLibrary;
		if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
			die('Please set the $rendererName and $rendererLibraryPath values' .
				 PHP_EOL . ' as appropriate for your directory structure'
			);
		}

		$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
		$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf';

		$objWriter->save($filePath);
		chmod($filePath,0755); // CHMOD file
	}
    
    public function saveJournalEntriesForBulkPost($journalEntriesList) {
        
        $journalEntryData = $journalEntriesList['Journal_Entry_List']['Journal_Entry_List'];
        
        if ($journalEntryData && sizeof($journalEntryData) > 0) {
            
            $data = array(
                'date' => date("Y-m-d"),
                'uploaded_user_id' => $this->user_id,
                'uploaded_date' => $this->date,
                'action_date' => $this->date,
                'last_action_status' => 'added'
            );

            $bulkUploadId = $this->journal_entry_bulk_upload_model->addJournalEntryBulkUpload($data);
            
            foreach ($journalEntryData as $journalEntry) {
                
                $data = array(
                    'bulk_upload_id' => $bulkUploadId,
                    'date' => $journalEntry[0],
                    'location_id' => $journalEntry[1],
                    'prime_entry_book_id' => $journalEntry[2],
                    'stakeholder_id' => $journalEntry[3],
                    'reference_no' => $journalEntry[4],
                    'description' => $journalEntry[5],
                    'debit_chart_of_account' => $journalEntry[6],
                    'credit_chart_of_account' => $journalEntry[7],
                    'amount' => $journalEntry[8],
                    'referetnce_transaction_reference_no' => $journalEntry[9],
                    'actioned_user_id' => $this->user_id,
                    'action_date' => $this->date,
                    'last_action_status' => 'added'
                );

                $this->journal_entry_bulk_upload_model->addJournalEntryBulkUploadEntry($data);
            }
        }
        
        return 'success';
    }

	public function deleteJournalEntryBulkUpload() {
		if(isset($this->data['ACM_Bookkeeping_Delete_Journal_Entry_Bulk_Upload_Permissions'])) {
            
			$status = 'deleted';
            $html = '';
            
			$bulkUploadId = $this->db->escape_str($this->input->post('bulk_upload_id'));
             
            $journalEntryBulkUpload = $this->journal_entry_bulk_upload_model->getJournalEntryBulkUploadById($bulkUploadId);
            
            if ($journalEntryBulkUpload[0]->status == "Pending") {
                
                if ($this->journal_entry_bulk_upload_model->deleteJournalEntryBulkUpload($bulkUploadId, $status, $this->user_id)) {
                    $html = '<div class="alert alert-success alert-dismissable">
                            <a class="close" href="#" data-dismiss="alert">× </a>
                            <h4><i class="icon-ok-sign"></i>' . $this->lang->line('success') . '</h4>' .
                        $this->lang->line('success_deleted') .
                        '</div>';
                }
                
                echo json_encode(array("result" => "ok", "html" => $html));
            } else {
                echo json_encode(array("result" => "rollback_required", "html" => $html));
            }
		}
	}

	public function getChartOfAccountsToAddTransaction() {
		$primeEntryBookid = $this->db->escape_str($this->input->post('prime_entry_book_id'));

		$primaryEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($primeEntryBookid);

		$chartOfAccountsRowsExists = false;
		if ($primaryEntryBookChartOfAccounts && sizeof($primaryEntryBookChartOfAccounts) > 0) {
			$chartOfAccountsRowsExists = true;

			$debitAccounts = array();
			$creditAccounts = array();
			foreach($primaryEntryBookChartOfAccounts as $primaryEntryBookChartOfAccount) {
				if ($primaryEntryBookChartOfAccount->debit_or_credit == "debit") {
					$debitAccounts[] = $primaryEntryBookChartOfAccount->chart_of_account_id;
				} else if ($primaryEntryBookChartOfAccount->debit_or_credit == "credit") {
					$creditAccounts[] = $primaryEntryBookChartOfAccount->chart_of_account_id;
				}
			}
		}

		$chartOfAccountsGroups = '';
		if ($chartOfAccountsRowsExists) {

			$debitAccountCount = sizeof($debitAccounts);
			$creditAccountCount = sizeof($creditAccounts);

			if ($debitAccountCount > $creditAccountCount) {
				$primaryEntryBookChartOfAccountRowCount = $debitAccountCount;
			} else {
				$primaryEntryBookChartOfAccountRowCount = $creditAccountCount;
			}

			$count = 1;
			for ($count = 1; $count <= $primaryEntryBookChartOfAccountRowCount; $count++) {
				if (array_key_exists($count - 1, $debitAccounts)) {
					$debitAccountId = $debitAccounts[$count - 1];
					$debitAccount = $this->chart_of_accounts_model->get($debitAccountId);
					$debitAccountCode = $debitAccount[0]->chart_of_account_code;
					$debitAccountName = $debitAccount[0]->text;
				} else {
					$debitAccountCode = '';
					$debitAccountName = '';
				}

				if (array_key_exists($count - 1, $creditAccounts)) {
					$creditAccountId = $creditAccounts[$count - 1];
					$creditAccount = $this->chart_of_accounts_model->get($creditAccountId);
					$creditAccountCode = $creditAccount[0]->chart_of_account_code;
					$creditAccountName = $creditAccount[0]->text;
				} else {
					$creditAccountCode = '';
					$creditAccountName = '';
				}

				$chartOfAccountsGroups .= "     <div class='col-sm-12 controls row' id='chart_of_accounts_div_" . $count . "'>
													<div class='col-sm-6 controls' id='debit_chart_of_accounts_div_" . $count . "'>
														<input class='form-control' id='debit_chart_of_account_id_" . $count . "' name='debit_chart_of_account_id_" . $count . "' type='hidden' value='{$debitAccountId}'>";
													if ($debitAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='debit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='debit_chart_of_account_code_" . $count . "'>" . $debitAccountCode . "</label>
														</div>
														<div class='col-sm-5 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='debit_chart_of_account_" . $count . "'>" . $debitAccountName . "</label>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='debit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='debit_chart_of_account_code_" . $count . "'></label>
														</div>
														<div class='col-sm-5 controls' id='debit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='debit_chart_of_account_" . $count . "'></label>
														</div>"; 
													}

													if ($debitAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='debit_transaction_value_div_" . $count . "' style='text-align:center;'>
															<input id='debit_transaction_value_" . $count . "' name='debit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Debit Amount')}' onchange='handleDebitTransactionValueAddition(this.id);' value='0.00'>
															<div id='debit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='debit_transaction_value_div_" . $count . "' style='text-align:center; display:none'>
															<input id='debit_transaction_value_" . $count . "' name='debit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Debit Amount')}' onchange='handleDebitTransactionValueAddition(this.id);' value='0.00'>
															<div id='debit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";                                    
													}

					$chartOfAccountsGroups .= "     </div>
													<div class='col-sm-6 controls' id='credit_chart_of_accounts_div_" . $count . "'>
														<input class='form-control' id='credit_chart_of_account_id_" . $count . "' name='credit_chart_of_account_id_" . $count . "' type='hidden' value='{$creditAccountId}'>";
													if ($creditAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='credit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='credit_chart_of_account_code_" . $count . "'>" . $creditAccountCode . "</label>
														</div>
														<div class='col-sm-5 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal;'>
															<label class='control-label' id='credit_chart_of_account_" . $count . "'>" . $creditAccountName . "</label>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-3 controls' id='credit_chart_of_account_code_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='credit_chart_of_account_code_" . $count . "'></label>
														</div>
														<div class='col-sm-5 controls' id='credit_chart_of_account_div_" . $count . "' style='text-align:left; font-size: 9pt; font-weight: normal; display:none;'>
															<label class='control-label' id='credit_chart_of_account_" . $count . "'></label>
														</div>"; 
													}

													if ($creditAccountName != '') {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='credit_transaction_value_div_" . $count . "' style='text-align:center'>
															<input id='credit_transaction_value_" . $count . "' name='credit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Credit Amount')}' onchange='handleCreditTransactionValueAddition(this.id);' value='0.00'>
															<div id='credit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";
													} else {
					$chartOfAccountsGroups .= "         <div class='col-sm-4 controls' id='credit_transaction_value_div_" . $count . "' style='text-align:center; display:none'>
															<input id='credit_transaction_value_" . $count . "' name='credit_transaction_value' class='form-control' "
							. "                                 type='text' placeholder='{$this->lang->line('Credit Amount')}' onchange='handleCreditTransactionValueAddition(this.id);' value='0.00'>
															<div id='credit_transaction_value_" . $count . "Error' class='red'></div>
														</div>";                                    
													}

				$chartOfAccountsGroups .= "         </div>
												</div>

												<p id='row_space_" . $count . "' style='margin-bottom:5px'>&nbsp;</p>";
			}
		}

		echo $chartOfAccountsGroups;
	}

	//get all data
	public function getTableData() {
		if(isset($this->data['ACM_Bookkeeping_View_Journal_Entry_Bulk_Upload_Permissions'])) {
			
			$year = $this->db->escape_str($this->input->post('year'));
			$month = $this->db->escape_str($this->input->post('month'));
			
            $length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $fromDate = $year . '-' . $month . '-1';
            $toDate = $year . '-' . $month . '-' . $length;
                
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered journalEntryBulkUploadTable'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Date')}</th>
							<th>{$this->lang->line('Uploaded User')}</th>
							<th>{$this->lang->line('Uploaded Date')}</th>
							<th>{$this->lang->line('Posted User')}</th>
                            <th>{$this->lang->line('Posted Date')}</th>
                            <th>{$this->lang->line('Status')}</th>
							<th>{$this->lang->line('Actions')}</th>
						</tr>
					</thead>
					<tbody>";

			$journalEntryBulkUploads = $this->journal_entry_bulk_upload_model->getAllJournalEntryBulkUploads($fromDate, $toDate);

			if ($journalEntryBulkUploads && sizeof($journalEntryBulkUploads) > 0) {
				foreach ($journalEntryBulkUploads as $row) {

					if ($row->uploaded_user_id != '0' && $row->uploaded_user_id != '') {
                        $user = $this->user_model->getUserById($row->uploaded_user_id);
						$people = $this->peoples_model->getById($user[0]->people_id);
                        
                        if ($people && sizeof($people) > 0) {
                            $uploadedUser = $people[0]->people_name;
                        } else {
                            $uploadedUser = "";
                        }
					} else {
						$uploadedUser = "";
					}
                    
                    if ($row->posted_user_id != '0' && $row->posted_user_id != '') {
                        $user = $this->user_model->getUserById($row->posted_user_id);
						$people = $this->peoples_model->getById($user[0]->people_id);
                        
                        if ($people && sizeof($people) > 0) {
                            $postedUser = $people[0]->people_name;
                        } else {
                            $postedUser = "";
                        }
					} else {
						$postedUser = "";
					}
					
					if ($row->posted_date == '0000-00-00 00:00:00') {
						$postedDate = '';
					} else {
						$postedDate = $row->posted_date;
					}

					$html .= "<tr>";
					$html .= "<td>" . $row->date . "</td>";
					$html .= "<td>" . $uploadedUser . "</td>";
					$html .= "<td>" . $row->uploaded_date . "</td>";
					$html .= "<td>" . $postedUser . "</td>";
					$html .= "<td>" . $postedDate . "</td>";
                    $html .= "<td>" . $row->status . "</td>";
					$html .= "<td style='width:15%'>
										<div class='text-left'>";
										if(isset($this->data['ACM_Bookkeeping_View_Journal_Entry_Bulk_Upload_Permissions'])) {
											$html.="<a class='btn btn-warning btn-xs get' data-id='{$row->bulk_upload_id}' title='{$this->lang->line('View')}' onclick='previewJournalEntryBulkUpload($row->bulk_upload_id);'>
												<i class='icon-search'></i>
											</a> ";
                                        }
                                        if(isset($this->data['ACM_Bookkeeping_Edit_Journal_Entry_Bulk_Upload_Permissions'])) {
											$html.="<a class='btn btn-primary btn-xs get' data-id='{$row->bulk_upload_id}' title='{$this->lang->line('Pre-post')}' onclick='prePostJournalEntryBulkUpload($row->bulk_upload_id);'";
                                            
                                            if ($row->status == "Completed") {
                                                $html.=" disabled >";
                                            } else {
                                                $html.=">";
                                            }
                                            
											$html.="	<i class='icon-forward'></i>
											</a> ";
                                            $html.="<a class='btn btn-info btn-xs get' data-id='{$row->bulk_upload_id}' title='{$this->lang->line('Rollback')}' onclick='rollbackJournalEntryBulkUpload($row->bulk_upload_id);'";
                                            
                                            if ($row->status == "Completed" || $row->status == "Pending") {
                                                $html.=" disabled >";
                                            } else {
                                                $html.=">";
                                            }
                                            
											$html.="	<i class='icon-backward'></i>
											</a> ";
                                            $html.="<a class='btn btn-warning btn-xs get' data-id='{$row->bulk_upload_id}' title='{$this->lang->line('Post')}' onclick='postJournalEntryBulkUpload($row->bulk_upload_id);'";
                                            
                                            if ($row->status == "Completed" || $row->status == "Pending") {
                                                $html.=" disabled >";
                                            } else {
                                                $html.=">";
                                            }
                                            
											$html.="	<i class='icon-ok'></i>
											</a> ";
                                        }
                                        if(isset($this->data['ACM_Bookkeeping_Delete_Journal_Entry_Bulk_Upload_Permissions'])) {
                                            $html.="<a class='btn btn-danger btn-xs delete' data-id='{$row->bulk_upload_id}' title='{$this->lang->line('Delete')}' "
                                                     . "onclick='deleteJournalEntryBulkUpload($row->bulk_upload_id);'";
                                            
                                            if ($row->status == "Completed") {
                                                $html.=" disabled >";
                                            } else {
                                                $html.=">";
                                            }
                                            
                                            $html.="    <i class='icon-remove'></i>
                                            </a>";
                                        }
						$html .= "      </div>
									</td>";
					$html .= "</tr>";
				}
			}
			$html .= "</tbody>
					</table>
				</div>
			</div>
		</div>";
            
			echo $html;
		}
	}
    
    public function previewJournalEntryBulkUpload() {
        if(isset($this->data['ACM_Bookkeeping_View_Journal_Entry_Bulk_Upload_Permissions'])) {
			
			$bulkUploadId = $this->db->escape_str($this->input->post('bulk_upload_id'));
			
			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
                <table class='table table-striped table-bordered JournalEntryBulkEntryListTable'style='margin-bottom:0;'>
					<thead>
						<tr>
							<th>{$this->lang->line('Date')}</th>
							<th>{$this->lang->line('Location')}</th>
							<th>{$this->lang->line('Prime Entry Book Name')}</th>
							<th>{$this->lang->line('Stakeholder Name')}</th>
                            <th>{$this->lang->line('Reference No')}</th>
                            <th>{$this->lang->line('Description')}</th>
							<th>{$this->lang->line('Debit Chart of Account')}</th>
                            <th>{$this->lang->line('Credit Chart of Account')}</th>
                            <th>{$this->lang->line('Amount')}</th>
                            <th>{$this->lang->line('Reference Transaction Reference No')}</th>
						</tr>
					</thead>
					<tbody>";

			$journalEntryBulkUploadEntries = $this->journal_entry_bulk_upload_model->getAllJournalEntryBulkUploadEntries($bulkUploadId);

			if ($journalEntryBulkUploadEntries && sizeof($journalEntryBulkUploadEntries) > 0) {
				foreach ($journalEntryBulkUploadEntries as $row) {

					if ($row->location_id != '0' && $row->location_id != '') {
                        $location = $this->locations_model->getById($row->location_id);
						$locationName = $location[0]->location_name;
					} else {
						$locationName = "";
					}
                    
                    if ($row->prime_entry_book_id != '0' && $row->prime_entry_book_id != '') {
                        $primeEntryBook = $this->prime_entry_book_model->getPrimeEntryBookById($row->prime_entry_book_id);
						$primeEntryBookName = $primeEntryBook[0]->prime_entry_book_name;
					} else {
						$primeEntryBookName = "";
					}
					
					if ($row->stakeholder_id != '0' && $row->stakeholder_id != '') {
						$people = $this->peoples_model->getById($row->stakeholder_id);
                        
                        if ($people && sizeof($people) > 0) {
                            $stakeholderName = $people[0]->people_name;
                        } else {
                            $stakeholderName = "";
                        }
					} else {
						$stakeholderName = "";
					}
                    
                    if ($row->debit_chart_of_account != '0' && $row->debit_chart_of_account != '') {
						$chartOfAccount = $this->chart_of_accounts_model->get($row->debit_chart_of_account);
                        $debitChartOfAccountName = $chartOfAccount[0]->text;
					} else {
						$debitChartOfAccountName = "";
					}
                    
                    if ($row->credit_chart_of_account != '0' && $row->credit_chart_of_account != '') {
						$chartOfAccount = $this->chart_of_accounts_model->get($row->credit_chart_of_account);
                        $creditChartOfAccountName = $chartOfAccount[0]->text;
					} else {
						$creditChartOfAccountName = "";
					}

					$html .= "<tr>";
					$html .= "  <td>" . $row->date . "</td>";
					$html .= "  <td>" . $locationName . "</td>";
					$html .= "  <td>" . $primeEntryBookName . "</td>";
					$html .= "  <td>" . $stakeholderName . "</td>";
					$html .= "  <td>" . $row->reference_no . "</td>";
                    $html .= "  <td>" . $row->description . "</td>";
                    $html .= "  <td>" . $debitChartOfAccountName . "</td>";
                    $html .= "  <td>" . $creditChartOfAccountName . "</td>";
                    $html .= "  <td>" . number_format($row->amount, 2) . "</td>";
                    $html .= "  <td>" . $row->referetnce_transaction_reference_no . "</td>";
					$html .= "</tr>";
				}
			}
			$html .= "</tbody>
					</table>
				</div>
			</div>
		</div>";
            
			echo $html;
		}
    }
    
    public function prePostJournalEntryBulkUpload() {
        
        if(isset($this->data['ACM_Bookkeeping_Edit_Journal_Entry_Bulk_Upload_Permissions'])) {
			
			$bulkUploadId = $this->db->escape_str($this->input->post('bulk_upload_id'));
            
            $journalEntryBulkUpload = $this->journal_entry_bulk_upload_model->getJournalEntryBulkUploadById($bulkUploadId);
            
            if ($journalEntryBulkUpload[0]->status == "Pending") {
            
                $journalEntryBulkUploadEntries = $this->journal_entry_bulk_upload_model->getAllJournalEntryBulkUploadEntries($bulkUploadId);

                if ($journalEntryBulkUploadEntries && sizeof($journalEntryBulkUploadEntries) > 0) {

                    foreach ($journalEntryBulkUploadEntries as $row) {

                        $payeePayerType = '';

                        if ($row->stakeholder_id != '' && $row->stakeholder_id != '0') {
                            $stakeholder = $this->peoples_model->getById($row->stakeholder_id);
                            $payeePayerType = $stakeholder[0]->people_type;
                        }

                        $shouldHaveAPaymentJournalEntry = "Yes";
                        $referenceJournalEntryId = 0;

                        if ($row->referetnce_transaction_reference_no != '') {
                            $shouldHaveAPaymentJournalEntry = "No";

                            $referenceJournalEntry = $this->journal_entries_model->getJournalEntryByReferenceNo($row->referetnce_transaction_reference_no);

                            if ($referenceJournalEntry && sizeof($referenceJournalEntry) > 0) {
                                $referenceJournalEntryId = $referenceJournalEntry[0]->journal_entry_id;
                            }
                        }

                        $data = array(
                            'bulk_upload_id' => $bulkUploadId,
                            'prime_entry_book_id' => $row->prime_entry_book_id,
                            'transaction_date' => $row->date,
                            'payee_payer_type' => $payeePayerType,
                            'payee_payer_id' => $row->stakeholder_id,
                            'reference_no' => $row->reference_no,
                            'should_have_a_payment_journal_entry' => $shouldHaveAPaymentJournalEntry,
                            'reference_journal_entry_id' => $referenceJournalEntryId,
                            'location_id' => $row->location_id,
                            'description' => $row->description,
                            'post_type' => "Direct",
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $journalEntryId = $this->journal_entries_model->addJournalEntry($data);

                        $debitChartOfAccountId = '';
                        $creditChartOfAccountId = '';

                        if ($row->prime_entry_book_id != '' && $row->prime_entry_book_id != '0') {
                            $primeEntryBookChartOfAccounts = $this->prime_entry_book_model->getPrimeEntryBookChartOfAccountsByPrimeEntryBookId($row->prime_entry_book_id);

                            if ($primeEntryBookChartOfAccounts && sizeof($primeEntryBookChartOfAccounts) > 0) {
                                foreach ($primeEntryBookChartOfAccounts as $primeEntryBookChartOfAccount) {

                                    if ($primeEntryBookChartOfAccount->debit_or_credit == "debit") {
                                        $debitChartOfAccountId = $primeEntryBookChartOfAccount->chart_of_account_id;
                                    } else if ($primeEntryBookChartOfAccount->debit_or_credit == "credit") {
                                        $creditChartOfAccountId = $primeEntryBookChartOfAccount->chart_of_account_id;
                                    }
                                }
                            }
                        } else {
                            $debitChartOfAccountId = $row->debit_chart_of_account;
                            $creditChartOfAccountId = $row->credit_chart_of_account;
                        }

                        $data = array(
                            'journal_entry_id' => $journalEntryId,
                            'prime_entry_book_id' => $row->prime_entry_book_id,
                            'transaction_date' => $row->date,
                            'chart_of_account_id' => $debitChartOfAccountId,
                            'debit_value' => $row->amount,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->journal_entries_model->addGeneralLedgerTransaction($data);

                        //Same time add the data to previous years record table.
                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);

                        $data = array(
                            'journal_entry_id' => $journalEntryId,
                            'prime_entry_book_id' => $row->prime_entry_book_id,
                            'transaction_date' => $row->date,
                            'chart_of_account_id' => $creditChartOfAccountId,
                            'credit_value' => $row->amount,
                            'actioned_user_id' => $this->user_id,
                            'action_date' => $this->date,
                            'last_action_status' => 'added'
                        );

                        $this->journal_entries_model->addGeneralLedgerTransaction($data);

                        //Same time add the data to previous years record table.
                        $this->journal_entries_model->addGeneralLedgerTransactionToPreviousYear($data);
                    }

                    $data = array(
                        'status' => 'Pre-posted',
                        'action_date' => $this->date,
                        'last_action_status' => 'edited'
                    );

                    $this->journal_entry_bulk_upload_model->editJournalEntryBulkUpload($bulkUploadId, $data);
                }

                echo 'ok';
            } else if ($journalEntryBulkUpload[0]->status == "Pre-posted") {
                echo 'already_pre_posted';
            }
        }
    }
    
    public function rollbackJournalEntryBulkUpload() {
        
        if(isset($this->data['ACM_Bookkeeping_Edit_Journal_Entry_Bulk_Upload_Permissions'])) {
			
			$bulkUploadId = $this->db->escape_str($this->input->post('bulk_upload_id'));
            
            $this->journal_entries_model->deleteJournalEntryBulkUploadEntries($bulkUploadId);
            
            $data = array(
                'status' => 'Pending',
                'action_date' => $this->date,
                'last_action_status' => 'edited'
            );

            $this->journal_entry_bulk_upload_model->editJournalEntryBulkUpload($bulkUploadId, $data);
            
            echo 'ok';
        }
    }
    
    public function postJournalEntryBulkUpload() {
        
        if(isset($this->data['ACM_Bookkeeping_Edit_Journal_Entry_Bulk_Upload_Permissions'])) {
			
			$bulkUploadId = $this->db->escape_str($this->input->post('bulk_upload_id'));
            
            $data = array(
                'status' => 'Completed',
                'action_date' => $this->date,
                'last_action_status' => 'edited'
            );

            $this->journal_entry_bulk_upload_model->editJournalEntryBulkUpload($bulkUploadId, $data);
            
            echo 'ok';
        }
    }

    public function isAccountsManagementForLocationsEnabled() {
		return $this->system_configurations_model->isAccountsManagementForLocationsEnabled();
	}
}
