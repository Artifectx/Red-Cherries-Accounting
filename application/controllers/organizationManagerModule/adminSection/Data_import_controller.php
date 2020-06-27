<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/../../../libraries/PHPExcelLibrary/PHPExcel.php';

class Data_import_controller extends CI_Controller {

	public function  __construct() {
		parent::__construct();
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
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->helper('download');
		$this->load->helper('url');

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
		$data_cls['ul_class_administration_section']='in nav nav-stacked';
		$data_cls['li_class_data_import']='active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$this->load->view('web/organizationManagerModule/adminSection/dataImport/index');
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function handleDataImport() {
		//set selected menu
		$data_cls['ul_class_administration_section']='in nav nav-stacked';
		$data_cls['li_class_data_import']='active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		if($this->input->post('data_import') == "download_people_data_template") { 

			$this->downloadPeopleDataImportWorkbook();
		} else if($this->input->post('data_import') == "download_user_guide") { 

			$this->downloadOrganizationDataImportWorkbookUserGuide();
		} else if ($this->input->post('data_import') == "upload") {

			$uploadResult = $this->uploadDataImportWorkbook();
			$uploadMessage = $uploadResult[1];
			$validateResult = false;

			if ($uploadResult[0] == 'success') {
				$validateResult = $this->validateDataImportWorkbook();

				if (!$validateResult) {
					$msg = "Data_import_workbook_errors";
					$validateMessage['message'] = '<div class="alert alert-danger alert-dismissable">
									<a class="close" href="#" data-dismiss="alert">× </a>
									<h4><i class="icon-ok-sign"></i>'.
									$this->lang->line('error').'</h4>'.
									$this->lang->line($msg).
									'</div>';

					$this->load->view('web/systemManagerModule/header/header', $this->data);
					$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

					$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $validateMessage);
					$this->load->view('web/systemManagerModule/footer/footer', $this->data);
				} else {
					$msg = "Data_import_workbook_successfully_uploaded";
					$validateMessage['message'] = '<div class="alert alert-success alert-dismissable">
									<a class="close" href="#" data-dismiss="alert">× </a>
									<h4><i class="icon-ok-sign"></i>'.
									$this->lang->line('success').'</h4>'.
									$this->lang->line($msg).
									'</div>';

					$this->load->view('web/systemManagerModule/header/header', $this->data);
					$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

					$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $validateMessage);
					$this->load->view('web/systemManagerModule/footer/footer', $this->data);
				}
			} else {
				$this->load->view('web/systemManagerModule/header/header', $this->data);
				$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

				$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $uploadMessage);
				$this->load->view('web/systemManagerModule/footer/footer', $this->data);
			}
		} else if ($this->input->post('data_import') == "download_data_validation_error_file") {

			$this->downloadDataValidationErrorFile();
		} else if ($this->input->post('data_import') == "import") {
			$dataImportOptions = array();
			
			$value = $this->input->post('supplier_info');
			if ($value != "0"){$dataImportOptions[] = $value;}
			
			$value = $this->input->post('agent_info');
			if ($value != "0"){$dataImportOptions[] = $value;}
			
			$value = $this->input->post('customer_info');
			if ($value != "0"){$dataImportOptions[] = $value;}
			
			$value = $this->input->post('sales_rep_info');
			if ($value != "0"){$dataImportOptions[] = $value;}
			
			$value = $this->input->post('driver_info');
			if ($value != "0"){$dataImportOptions[] = $value;}
			
			$value = $this->input->post('employee_info');
			if ($value != "0"){$dataImportOptions[] = $value;}
			//echo "<pre>";print_r($dataImportOptions);die;

			if (sizeof($dataImportOptions) == 0) {
				$msg = "Select a data import option to proceed";
				$data['message'] = '<div class="alert alert-danger alert-dismissable">
								<a class="close" href="#" data-dismiss="alert">× </a>
								<h4><i class="icon-ok-sign"></i>'.
								$this->lang->line('error').'</h4>'.
								$this->lang->line($msg).
								'</div>';

				$this->load->view('web/systemManagerModule/header/header', $this->data);
				$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

				$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer', $this->data);
			} else if (sizeof($dataImportOptions) > 1) {
				$msg = "Select only one import option";
				$data['message'] = '<div class="alert alert-danger alert-dismissable">
								<a class="close" href="#" data-dismiss="alert">× </a>
								<h4><i class="icon-ok-sign"></i>'.
								$this->lang->line('error').'</h4>'.
								$this->lang->line($msg).
								'</div>';

				$this->load->view('web/systemManagerModule/header/header', $this->data);
				$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

				$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $data);
				$this->load->view('web/systemManagerModule/footer/footer', $this->data);
			} else {
				$importErrors = false;
				if ($dataImportOptions[0] == 'supplier_info') {
					$this->importPeopleInformationData("Supplier");
					$this->refreshScreenAfterDataImport($importErrors);
				}
				
				if ($dataImportOptions[0] == 'agent_info') {
					$this->importPeopleInformationData("Agent");
					$this->refreshScreenAfterDataImport($importErrors);
				}
				
				if ($dataImportOptions[0] == 'customer_info') {
					$this->importPeopleInformationData("Customer");
					$this->refreshScreenAfterDataImport($importErrors);
				}
				
				if ($dataImportOptions[0] == 'sales_rep_info') {
					$this->importPeopleInformationData("Sales Rep");
					$this->refreshScreenAfterDataImport($importErrors);
				}
				
				if ($dataImportOptions[0] == 'driver_info') {
					$this->importPeopleInformationData("Driver");
					$this->refreshScreenAfterDataImport($importErrors);
				}
				
				if ($dataImportOptions[0] == 'employee_info') {
					$this->importPeopleInformationData("Employee");
					$this->refreshScreenAfterDataImport($importErrors);
				}
			}
		} else if ($this->input->post('data_import') == "download_data_import_error_file") {

			$this->createDataImportErrorPDF();
			$this->downloadDataImportErrorFile();
		}
	}

	public function downloadPeopleDataImportWorkbook() {

		$data = file_get_contents(base_url() . "/dataUpload/dataTemplates/Templates/Organization_Manager_Data_Template.xlsx"); // Read the file's contents
		$name = 'Organization_Manager_Data_Template.xlsx';

		force_download($name, $data);
	}

	public function downloadOrganizationDataImportWorkbookUserGuide() {

		$data = file_get_contents(base_url() . "dataUpload/dataTemplates/userGuides/Organization_Data_Import_Workbook_User_Guide.pdf"); // Read the file's contents
		$name = 'Organization_Data_Import_Workbook_User_Guide.pdf';

		force_download($name, $data);
	}

	public function downloadDataImportErrorFile() {
		//set selected menu
		$data_cls['ul_class_administration_section']='in nav nav-stacked';
		$data_cls['li_class_data_import']='active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();
		
		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.pdf')) {
			$data = file_get_contents(base_url() . "/dataUpload/importData/Data_Import_Errors.pdf"); // Read the file's contents
			$name = 'Data_Import_Errors.pdf';
			
			force_download($name, $data);
		} else {
			$msg = "There are no data import errors";
			$data['message'] = '<div class="alert alert-warning alert-dismissable">
							<a class="close" href="#" data-dismiss="alert">× </a>
							<h4><i class="icon-ok-sign"></i>'.
							$this->lang->line('warning').'</h4>'.
							$this->lang->line($msg).
							'</div>';

			$this->load->view('web/systemManagerModule/header/header', $this->data);
			$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

			$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $data);
			$this->load->view('web/systemManagerModule/footer/footer', $this->data);
		}
	}

	public function downloadDataValidationErrorFile() {
		//set selected menu
		$data_cls['ul_class_administration_section']='in nav nav-stacked';
		$data_cls['li_class_data_import']='active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf')) {
			$data = file_get_contents(base_url() . "/dataUpload/importData/Data_Import_Validation_Errors.pdf"); // Read the file's contents
			$name = 'Data_Import_Validation_Errors.pdf';

			force_download($name, $data);
		} else {
			$msg = "There are no workbook errors";
			$data['message'] = '<div class="alert alert-warning alert-dismissable">
							<a class="close" href="#" data-dismiss="alert">× </a>
							<h4><i class="icon-ok-sign"></i>'.
							$this->lang->line('warning').'</h4>'.
							$this->lang->line($msg).
							'</div>';

			$this->load->view('web/systemManagerModule/header/header', $this->data);
			$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

			$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $data);
			$this->load->view('web/systemManagerModule/footer/footer', $this->data);
		}
	}

	public function uploadDataImportWorkbook() {

		$status = "";
		$data = "";
		$msg = "";
		$fileElementName = 'file_to_upload';

		$config['upload_path'] = './dataUpload/importData';
		$config['allowed_types'] = 'xlsx|csv|xls|ods';
		$config['max_size'] = 1024 * 100;
		$config['encrypt_name'] = FALSE;
		$config['overwrite'] = 'TRUE';

		$this->load->library('upload', $config);


		/*if ($_FILES['file_to_upload']['name'] != "") {
			if($this->handle_upload() == TRUE){
				echo 'come';die();
				$data['assignment_file']=$this->handle_upload();
				$status = "success";
				$msg = "Data_import_workbook_successfully_uploaded";
				$data['message'] = '<div class="alert alert-success alert-dismissable">
								<a class="close" href="#" data-dismiss="alert">× </a>
								<h4><i class="icon-ok-sign"></i>'.
					$this->lang->line('success').'</h4>'.
					$this->lang->line($msg).
					'</div>';
			}else{
				echo 'come err';die();
				$status = 'error';
			}
		}else{
			echo 'dddd';die();
		}*/

		if (!$this->upload->do_upload($fileElementName)) {
			$status = 'error';
			$msg = $this->upload->display_errors('', '');
			$data['message'] = '<div class="alert alert-danger alert-dismissable">
								<a class="close" href="#" data-dismiss="alert">× </a>
								<h4><i class="icon-ok-sign"></i>'.
								$this->lang->line('error').'</h4>'.
								$this->lang->line($msg).
								'</div>';
		} else {
			$uploadedData = array('upload_data' => $this->upload->data()); // get data
			$uploadedFilePath = $uploadedData['upload_data']['full_path']; // get file path
			//echo $uploadedFilePath;die;
			chmod($uploadedFilePath,0755); // CHMOD file

			$status = "success";
			$msg = "Data_import_workbook_successfully_uploaded";
			$data['message'] = '<div class="alert alert-success alert-dismissable">
								<a class="close" href="#" data-dismiss="alert">× </a>
								<h4><i class="icon-ok-sign"></i>'.
								$this->lang->line('success').'</h4>'.
								$this->lang->line($msg).
								'</div>';

		}

		return array($status, $data);
	}

	public function validateDataImportWorkbook() {

		$noWorkbookErrors = true;
		$inputFileType = 'Excel2007';
		$inputFileName = '';

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Organization_Manager_Data_Template.csv')) {
			$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/Organization_Manager_Data_Template.csv';
		} else if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Organization_Manager_Data_Template.xlsx')) {
			$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/Organization_Manager_Data_Template.xlsx';
		}

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);

		$workbookResult['People'] = $this->validatePeopleInformation($objPHPExcel->setActiveSheetIndexbyName('People'),
														 $objPHPExcel->setActiveSheetIndexbyName('TP_Country_Codes'));

		$dataWorkbookErrors = FALSE;

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx');
		}

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.pdf');
		}

		$this->createDataImportValidationErrorExcelFile();

		//Handle people.
		if ($workbookResult['People']['People_Errors'] == '') {

			$this->writePeopleToAFileToImport($workbookResult);
		} else {
			$dataWorkbookErrors = TRUE;
			$this->writeDataImportValidationErrorsToAFile('People_Errors', $workbookResult['People']['People_Errors']);
		}

		//Create data error PDF document.
		if ($dataWorkbookErrors) {
			$noWorkbookErrors = false;
			$this->createDataWorkbookErrorPDF();
			return $noWorkbookErrors;
		} else {
			return $noWorkbookErrors;
		}
	}

	public function validatePeopleInformation($peopleInformationWorksheet, $tpCountryCodes) {
		
		$tpCountryCodesWorksheetData = $tpCountryCodes->toArray(null,true,true,true);

		$count = 2;
		$peopleCodes = '';
		while ($peopleInformationWorksheet->getCell('A' . $count)->getValue() != '') {
			$peopleCodes[$count] = $peopleInformationWorksheet->getCell('A' . $count)->getValue();
			$peopleNames[$count] = $peopleInformationWorksheet->getCell('B' . $count)->getValue();
			$addresses[$count] = $peopleInformationWorksheet->getCell('C' . $count)->getValue();
			$primaryPhoneCountries[$count] = $peopleInformationWorksheet->getCell('D' . $count)->getValue();
			$primaryPhoneNumbers[$count] = $peopleInformationWorksheet->getCell('E' . $count)->getValue();
			$secondaryPhoneCountries[$count] = $peopleInformationWorksheet->getCell('F' . $count)->getValue();
			$secondaryPhoneNumbers[$count] = $peopleInformationWorksheet->getCell('G' . $count)->getValue();
			$emails[$count] = $peopleInformationWorksheet->getCell('H' . $count)->getValue();
			$count++;
		}
		
		$count = 2;
		$errorsFound = false;
		$peopleSheetErrors = null;
		$peopleList = '';
		if ($peopleCodes != '') {
			foreach ($peopleCodes as $peopleCode) {
				if ($peopleCode == '') {
					$peopleSheetErrors[$count] = '"People Code" is a mandatory field and cannot be empty';
					$errorsFound = true;
				} elseif (strlen($peopleCode) > 100) {
					$peopleSheetErrors[$count] = '"People Code" data length cannot exceed 100 characters';
					$errorsFound = true;
				} 

				if ($peopleNames[$count] == '') {
					$peopleSheetErrors[$count] = '"People Name" is a mandatory field and cannot be empty';
					$errorsFound = true;
				} else if (strlen($peopleNames[$count]) > 255) {
					$peopleSheetErrors[$count] = '"People Name" data length cannot exceed 255 characters';
					$errorsFound = true;
				}

				if (strlen($addresses[$count]) > 255) {
					$peopleSheetErrors[$count] = '"Address" data length cannot exceed 255 characters';
					$errorsFound = true;
				}
				
				if ($emails[$count] != '') {
					if (strlen($emails[$count]) > 255) {
						$peopleSheetErrors[$count] = '"Email" data length cannot exceed 255 characters';
						$errorsFound = true;
					} else if (!filter_var($emails[$count], FILTER_VALIDATE_EMAIL)) {
						$peopleSheetErrors[$count] = '"Email" address given [' .  $emails[$count] . ' ] is not valid';
						$errorsFound = true;
					}
				}
				
				if (!$errorsFound) {
					$primaryTPNumberCountryCode = '';
					foreach ($tpCountryCodesWorksheetData as $tpCountryCode) {
						if ($tpCountryCode['A'] == $primaryPhoneCountries[$count]) {
							$primaryTPNumberCountryCode = $tpCountryCode['C'];
							break;
						}
					}

					$secondaryTPNumberCountryCode = '';
					foreach ($tpCountryCodesWorksheetData as $tpCountryCode) {
						if ($tpCountryCode['A'] == $secondaryPhoneCountries[$count]) {
							$secondaryTPNumberCountryCode = $tpCountryCode['C'];
							break;
						}
					}
					
					$peopleList[] = array($peopleCodes[$count], $peopleNames[$count], $addresses[$count], 
									 $primaryTPNumberCountryCode, $primaryPhoneNumbers[$count],
									 $secondaryTPNumberCountryCode, $secondaryPhoneNumbers[$count], $emails[$count]);
				}

				$count++;
			}
		}

		return array('People_Errors' => $peopleSheetErrors, 'People' => $peopleList);
	}

	public function writePeopleToAFileToImport($workbookResult) {

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/People.xlsx')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/People.xlsx');
		}

		if ($workbookResult['People']['People'] != '') {
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setTitle('People');

			$objPHPExcel->getActiveSheet()->fromArray($workbookResult['People']['People'], null, 'A1');

			// Do your stuff here
			$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/People.xlsx';

			$writer->save($filePath);
			chmod($filePath,0755); // CHMOD file
		}
	}

	public function importPeopleInformationData ($peopleType) {
                
		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/People.xlsx')) {
			$inputFileType = 'Excel2007';
			$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/People.xlsx';
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			$peopleWorksheet = $objPHPExcel->setActiveSheetIndexbyName('People');

			$sheetData = $peopleWorksheet->toArray(null,true,true,true);

			foreach ($sheetData as $people) {
				$peopleCode = $people['A'];
				$peopleName = $people['B'];
				
				if (array_key_exists('C', $people)) {
					$address = $people['C'];
				} else {
					$address = "";
				}
				
				if (array_key_exists('D', $people)) {
					$peoplePTNCountryCode = $people['D'];
				} else {
					$peoplePTNCountryCode = "";
				}
				
				if (array_key_exists('E', $people)) {
					$peoplePrimaryTelephoneNumber = $people['E'];
				} else {
					$peoplePrimaryTelephoneNumber = "";
				}
				
				if (array_key_exists('F', $people)) {
					$peopleSTNCountryCode = $people['F'];
				} else {
					$peopleSTNCountryCode = "";
				}
				
				if (array_key_exists('G', $people)) {
					$peopleSecondaryTelephoneNumber = $people['G'];
				} else {
					$peopleSecondaryTelephoneNumber = "";
				}
				
				if (array_key_exists('H', $people)) {
					$email = $people['H'];
				} else {
					$email = "";
				}
				
				$data = array(
					'people_code' => $peopleCode,
					'people_name' => $peopleName,
					'people_address' => $address,
					'people_ptn_country_code' => $peoplePTNCountryCode,
					'people_primary_telephone_number' => $peoplePrimaryTelephoneNumber,
					'people_stn_country_code' => $peopleSTNCountryCode,
					'people_secondory_telephone_number' => $peopleSecondaryTelephoneNumber,
					'people_email' => $email,
					'people_type' => $peopleType,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'imported'
				);

				$existingPeople = $this->peoples_model->getPeopleByCode($peopleCode);
				if (!$existingPeople) {
					$this->peoples_model->add($data);
				} else {
					$this->peoples_model->edit($existingPeople[0]->people_id, $data);
				}
			}
		}
	}

	public function refreshScreenAfterDataImport($importErrors) {
		//set selected menu
		$data_cls['ul_class_administration_section']='in nav nav-stacked';
		$data_cls['li_class_data_import']='active';
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		if (!$importErrors) {
			$msg = "Data_imported_successfully";
			$data['message'] = '<div class="alert alert-success alert-dismissable">
								<a class="close" href="#" data-dismiss="alert">× </a>
								<h4><i class="icon-ok-sign"></i>'.
								$this->lang->line('success').'</h4>'.
								$this->lang->line($msg).
								'</div>';
		} else {
			$msg = "Data_import_identified_errors";
			$data['message'] = '<div class="alert alert-danger alert-dismissable">
								<a class="close" href="#" data-dismiss="alert">× </a>
								<h4><i class="icon-ok-sign"></i>'.
								$this->lang->line('error').'</h4>'.
								$this->lang->line($msg).
								'</div>';
		}

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);

		$this->load->view('web/organizationManagerModule/adminSection/dataImport/index', $data);
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
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

		if ($errorPage == 'People_Errors') {

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

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, '"People" Sheet Errors');

			$errorCount = 0;

			foreach($errorList as $key => $error) {

				$count++;
				$errorCount++;
				$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, ' ' . $errorCount . '. [Row Number - ' . $key . '] ' . $error);
			}

			$objPHPExcel->getActiveSheet()->getStyle('A' . $highestRow . ':A' . $count)->applyFromArray($styleThinBlackBorderOutline);

			// Do your stuff here
			$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Validation_Errors.xlsx';

			$writer->save($filePath);
			chmod($filePath,0755); // CHMOD file
		}    
	}

	public function writeDataImportErrorsToAFile($errorList) {

		$styleThinBlackBorderOutline = array(
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('argb' => 'FF000000'),
						),
				),
		);

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.xlsx')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.xlsx');
		}

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.pdf');
		}

		$this->createDataImportErrorExcelFile();

		$inputFileType = 'Excel2007';
		$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.xlsx';
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

		$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, 'Data Import Errors');

		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$errorCount = 0;

		foreach($errorList as $error) {

			$count++;
			$errorCount++;
			$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFont()->setSize(10);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, ' ' . $errorCount . '. ' . $error);
		}

		$objPHPExcel->getActiveSheet()->getStyle('A4:A' . $count)->applyFromArray($styleThinBlackBorderOutline);

		// Do your stuff here
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.xlsx';

		$writer->save($filePath);
		chmod($filePath,0755); // CHMOD file
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

	public function createDataImportErrorExcelFile() {

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Data Import Errors');
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

		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data import has encountered the following issues. Please correct the '.
															'issues and import again.');

		// Do your stuff here
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.xlsx';

		$writer->save($filePath);
		chmod($filePath,0755); // CHMOD file
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

	public function createDataImportErrorPDF() {

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.pdf')) {
			unlink(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.pdf');
		}

		if (file_exists(dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.xlsx')) {
			$inputFileType = 'Excel2007';
			$inputFileName = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.xlsx';
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
			$filePath = dirname(__FILE__) . '/../../../../dataUpload/importData/Data_Import_Errors.pdf';

			$objWriter->save($filePath);
			chmod($filePath,0755); // CHMOD file
		}
	}

	//check user permission
	public function hasPermission($user_roles, $data) {
		foreach ($user_roles as $row) {
			$data[$row->permission] = $row->permission;
		}
		return $data;
	}

	public function validateDate($date, $format = 'Y-m-d H:i:s') {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
}