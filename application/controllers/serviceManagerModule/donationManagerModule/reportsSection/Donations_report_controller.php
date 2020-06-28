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

require_once dirname(__FILE__) . '/../../../../libraries/SVGGraph/SVGGraph.php';
require_once dirname(__FILE__) . '/../../../../../application/libraries/PHPExcelLibrary/PHPExcel.php';

class Donations_report_controller extends CI_Controller {
    
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
		$this->load->model('organizationManagerModule/organizationSection/company_structure_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/peoples_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/locations_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/adminSection/programs_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/donationSection/donations_model', '', TRUE);
		$this->load->model('serviceManagerModule/donationManagerModule/donationSection/program_activities_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->helper('download');
		$this->load->helper('url');

		$this->load->library('common_library/common_functions');

		$this->load->library('Pdf_reports');

		$this->export=true;

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
	}

	public function index() {
		//set selected menu

		$data_cls['ul_class_report_section'] = 'in nav nav-stacked';
		$data_cls['li_class_donation_report'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_donation_manager', $data_cls);

		if(isset($this->data['SVM_DSM_Reports_View_Donation_Report_Permissions'])) {
			$this->load->view('web/serviceManagerModule/donationManagerModule/reportsSection/donationReport/index');
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function printReport() {
		$report = $this->db->escape_str($this->input->post('report'));
		$programId = $this->db->escape_str($this->input->post('programId'));
		$locationId = $this->db->escape_str($this->input->post('locationId'));
		$fromDate = $this->db->escape_str($this->input->post('fromDate'));
		$toDate = $this->db->escape_str($this->input->post('toDate'));
		
		if ($report == "DonationDetails") {
			$this->printDonationDetailsTable($fromDate, $toDate, $programId, $locationId);
		} else if ($report == "ProgramDetails") {
			$this->printProgramDetailsTable($programId, $locationId);
		}
	}

	// Donation Details Report  //////////////////////////////////////////////////////////////////////////////////////
	public function getDonationDetailsDetailsTable() {
		$html = "";

		$fromDate = $this->db->escape_str($this->input->post('from_date'));
		$toDate = $this->db->escape_str($this->input->post('to_date'));
		$programId = $this->db->escape_str($this->input->post('program_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));

		$date = date("Y-m-d h:i:sa");
		
		$displayString = "";

		if($programId != '0'){
			$dataProgram = $this->programs_model->getById($programId);
			if ($dataProgram && sizeof($dataProgram) > 0) {
				$displayString .= "{$this->lang->line('For ')} {$this->lang->line('Program')} : {$dataProgram[0]->program_name } ";
			}

			if ($locationId != '0') {
				$dataLocation = $this->locations_model->getById($locationId);
				if ($dataLocation && sizeof($dataLocation) > 0) {
					$displayString .= "{$this->lang->line('And For ')} {$this->lang->line('Location')} : {$dataLocation[0]->location_name } ";
				}
			}
		} else if ($locationId != '0') {
			$dataLocation = $this->locations_model->getById($locationId);
			if ($dataLocation && sizeof($dataLocation) > 0) {
				$displayString .= "{$this->lang->line('For ')} {$this->lang->line('Location')} : {$dataLocation[0]->location_name } ";
			}
		}

		if ($fromDate != "" && $toDate != "") {
			$displayString .= $this->lang->line(' For Date Range From ') . $fromDate . $this->lang->line(' To ') . $toDate;
		} else {
			$displayString .= $this->lang->line(' As Of ') . $date;
		}

		$html .= "<br><p class='text-info'><strong>{$this->lang->line('Donation Details')} : </strong>{$displayString}</p>";

		$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered donationDataTable'style='margin-bottom:0;'>
					<thead>
						<tr>";
							$html.="<th>{$this->lang->line('Donor')}</th>";
							if ($programId == '0') {
								$html.="<th>{$this->lang->line('Program Name')}</th>";
							}
							if ($locationId == '0') {
								$html.="<th>{$this->lang->line('Location')}</th>";
							}
							$html.="<th>{$this->lang->line('Reference Number')}</th>";
							$html.="<th>{$this->lang->line('Date')}</th>";
							$html.="<th>{$this->lang->line('Amount')}</th>";
				$html.="</tr>
					</thead>
					<tbody>";
		
		$donationData = $this->getDonationDetailsDataFromDB($fromDate, $toDate, $programId, $locationId);

		$html.= $donationData['0'];

		$html .= "		</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
		";

		echo json_encode(array('html' => $html, 'donationGrandTotal' => number_format($donationData['1'], 2)));
	}

	public function printDonationDetailsTable($fromDate, $toDate, $programId, $locationId) {
		$pdf = new Pdf_reports(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(30);
		$pdf->SetPrintHeader(true);

		$date = date("Y-m-d h:i:sa");

		$html = "";
		$pdf->SetFont('Helvetica', 'B', 11);

		$html .= "<u><strong>{$this->lang->line('Donation Details')}</strong></u><br><br>";
		$displayString = '';

		if($programId != '0'){
			$dataProgram = $this->programs_model->getById($programId);
			if ($dataProgram && sizeof($dataProgram) > 0) {
				$displayString .= "<strong>{$this->lang->line('For ')} {$this->lang->line('Program')} :</strong> {$dataProgram[0]->program_name } ";
			}

			if ($locationId != '0') {
				$dataLocation = $this->locations_model->getById($locationId);
				if ($dataLocation && sizeof($dataLocation) > 0) {
					$displayString .= "<strong>{$this->lang->line('And For ')} {$this->lang->line('Location')} :</strong> {$dataLocation[0]->location_name } ";
				}
			}
		} else if ($locationId != '0') {
			$dataLocation = $this->locations_model->getById($locationId);
			if ($dataLocation && sizeof($dataLocation) > 0) {
				$displayString .= "<strong>{$this->lang->line('For ')} {$this->lang->line('Location')} :</strong> {$dataLocation[0]->location_name } ";
			}
		}

		if ($fromDate != "" && $toDate != "") {
			$displayString .= "<strong>{$this->lang->line(' For Date Range From ')}</strong>" . $fromDate . "<strong>{$this->lang->line(' To ')}</strong>" . $toDate;
		} else {
			$displayString .= "<strong>{$this->lang->line(' As Of ')}</strong>" . $date;
		}

		$html .= $displayString . "<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table border="0.5" style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';

		$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Donor").'</span></th>';
		if ($programId == '0') {
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
						.$this->lang->line("Program Name").'</span></th>';
		}
		if ($locationId == '0') {
			$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
						.$this->lang->line("Location").'</span></th>';
		}
		$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Reference Number").'</span></th>';
		$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Date").'</span></th>';
		$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
					.$this->lang->line("Amount").'</span></th>';

		$html.="</tr>
		   </thead>";

		$donationData = $this->getDonationDetailsDataFromDB($fromDate, $toDate, $programId, $locationId, true);

		$html.= $donationData['0'];

		$html.="</table>";
		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->lastPage();
		$pdf_file_name = 'DonationDetailsReport.pdf';
		$pdf->Output($pdf_file_name, 'I');
	}

	public function getDonationDetailsDataFromDB($fromDate, $toDate, $programId, $locationId, $print=null) {
		
		$html='';
		$donationTotal = 0;

		$donationDetails = $this->donations_model->getAllDonationsDetailForDateRangeProgramAndLocation($fromDate, $toDate, $programId, $locationId);
		
		if ($donationDetails && sizeof($donationDetails) > 0) {
			$this->arraySortByColumn($donationDetails, 'date');
		}

		if ($donationDetails != null) {

			$rowCount = 1;
			$colspan = 0;
			foreach ($donationDetails as $row) {

				$html .= '<tr style="line-height:15px;">';

				if ($rowCount == 1) {
					$colspan++;
				}

				if ($print) {
					$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['donor_name'] . '</span></td>';
				} else {
					$html .= '<td>' . $row['donor_name'] . '</td>';
				}

				if($programId == '0'){
					if ($rowCount == 1) {
						$colspan++;
					}

					if ($print) {
						$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['program_name'] . '</span></td>';
					} else {
						$html .= '<td>' . $row['program_name'] . '</td>';
					}
				}

				if ($locationId == '0') {
					if ($rowCount == 1) {
						$colspan++;
					}

					if ($print) {
						$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['location_name'] . '</span></td>';
					} else {
						$html .= '<td>' . $row['location_name'] . '</td>';
					}
				}

				if ($rowCount == 1) {
					$colspan++;
				}
				
				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $row['reference_no'] . '</span></td>';
				} else {
					$html .= '<td style="text-align:right;">' . $row['reference_no'] . '</td>';
				}

				if ($rowCount == 1) {
					$colspan++;
				}
				
				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $row['date'] . '</span></td>';
				} else {
					$html .= '<td style="text-align:right;">' . $row['date'] . '</td>';
				}

				if ($print) {
					$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($row['amount'], 2) . '</span></td>';
				} else {
					$html .= '<td style="text-align:right;">' . number_format($row['amount'], 2) . '</td>';
				}

				$html .= "</tr>";

				$rowCount++;
				$donationTotal = $donationTotal + $row['amount'];
			}
			
			if ($print) {
				$html .= '<tr style="line-height:15px;">';
				$html .= '    <td style="text-align:right;" colspan="' . $colspan . '"><span style="font-weight:bold; font-size:8px">' . $this->lang->line("Donation Total") . '</span></td>';
				$html .= '    <td style="text-align:right;"><span style="font-size:8px">' . number_format($donationTotal, 2) . '</span></td>';
				$html .= "</tr>";
			}
		}

		return array($html, $donationTotal);
	}
	//  End of Program Details Report  ///////////////////////////////////////////////////////////////////////////////////
	
	// Program Details Report  ////////////////////////////////////////////////////////////////////////////////////////////
	public function getProgramDetailsTable() {
		$html = "";

		$programId = $this->db->escape_str($this->input->post('program_id'));
		$locationId = $this->db->escape_str($this->input->post('location_id'));

		$date = date("Y-m-d h:i:sa");
		
		$displayString = "";

		if($programId != '0'){
			$dataProgram = $this->programs_model->getById($programId);
			if ($dataProgram && sizeof($dataProgram) > 0) {
				$displayString .= "{$this->lang->line('For ')} {$this->lang->line('Program')} : {$dataProgram[0]->program_name } ";
			}

			if ($locationId != '0') {
				$dataLocation = $this->locations_model->getById($locationId);
				if ($dataLocation && sizeof($dataLocation) > 0) {
					$displayString .= "{$this->lang->line('And For ')} {$this->lang->line('Location')} : {$dataLocation[0]->location_name } ";
				}
			}
		} else if ($locationId != '0') {
			$dataLocation = $this->locations_model->getById($locationId);
			if ($dataLocation && sizeof($dataLocation) > 0) {
				$displayString .= "{$this->lang->line('For ')} {$this->lang->line('Location')} : {$dataLocation[0]->location_name } ";
			}
		} else {
			$displayString .= "{$this->lang->line('All Programs of All Locations ')} ";
		}

		$html .= "<br><p class='text-info'><strong>{$this->lang->line('Program Details')} : </strong>{$displayString}</p>";

		$html .= "<div class='box-content box-no-padding out-table'>
		<div class='table-responsive table_data'>
			<div class='scrollable-area1'>
				<table class='table table-striped table-bordered programDataTable'style='margin-bottom:0;'>
					<thead>
						<tr>";
							if ($programId == "0") {
								$html.="<th>{$this->lang->line('Program Name')}</th>";
								if ($locationId == '0') {
									$html.="<th>{$this->lang->line('Location')}</th>";
								}
								$html.="<th>{$this->lang->line('Fund Available')}</th>";
								$html.="<th>{$this->lang->line('Budget Estimated')}</th>";
								$html.="<th>{$this->lang->line('Budget Deficiency')}</th>";
								$html.="<th>{$this->lang->line('Activity Cost Total')}</th>";
								$html.="<th>{$this->lang->line('Overall Budget Varience')}</th>";
							} else {
								$html.="<th>{$this->lang->line('Activity Name')}</th>";
								$html.="<th>{$this->lang->line('Start Date')}</th>";
								$html.="<th>{$this->lang->line('Finish Date')}</th>";
								$html.="<th>{$this->lang->line('Activity Owner')}</th>";
								$html.="<th>{$this->lang->line('Activity Budget')}</th>";
								$html.="<th>{$this->lang->line('Activity Completion')}</th>";
								$html.="<th>{$this->lang->line('Actual Start Date')}</th>";
								$html.="<th>{$this->lang->line('Actual Finished Date')}</th>";
								$html.="<th>{$this->lang->line('Activity Cost')}</th>";
								$html.="<th>{$this->lang->line('Budget Varience')}</th>";
							}
				$html.="</tr>
					</thead>
					<tbody>";
		
		$programData = $this->getProgramDetailsDataFromDB($programId, $locationId);

		$html.= $programData['0'];

		$html .= "		</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
		";

		if ($programId == "0") {
			echo json_encode(array('html' => $html, 'budgetAvailableGrandTotal' => number_format($programData['1'], 2), 'budgetEstimatedGrandTotal' => number_format($programData['2'], 2), 'budgetDeficiencyGrandTotal' => number_format($programData['3'], 2), 'activityCostGrandTotal' => number_format($programData['4'], 2), 'budgetVarienceGrandTotal' => number_format($programData['5'], 2)));
		} else {
			echo json_encode(array('html' => $html, 'budgetAvailable' => number_format($programData['1'], 2), 'budgetEstimated' => number_format($programData['2'], 2), 'budgetDeficiency' => number_format($programData['3'], 2), 'activityCost' => number_format($programData['4'], 2), 'budgetVarience' => number_format($programData['5'], 2), 'budgetProgress' => $programData['6'], 'activityProgress' => $programData['7']));
		}
	}

	public function printProgramDetailsTable($programId, $locationId) {
		$pdf = new Pdf_reports(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->AddPage();
		$pdf->SetX(15);
		$pdf->SetY(30);
		$pdf->SetPrintHeader(true);

		$date = date("Y-m-d h:i:sa");

		$html = "";
		$pdf->SetFont('Helvetica', 'B', 11);

		$html .= "<u><strong>{$this->lang->line('Program Details')}</strong></u><br><br>";
		$displayString = '';

		if($programId != '0'){
			$dataProgram = $this->programs_model->getById($programId);
			if ($dataProgram && sizeof($dataProgram) > 0) {
				$displayString .= "<strong>{$this->lang->line('For ')} {$this->lang->line('Program')} :</strong> {$dataProgram[0]->program_name } ";
			}

			if ($locationId != '0') {
				$dataLocation = $this->locations_model->getById($locationId);
				if ($dataLocation && sizeof($dataLocation) > 0) {
					$displayString .= "<strong>{$this->lang->line('And For ')} {$this->lang->line('Location')} :</strong> {$dataLocation[0]->location_name } ";
				}
			}
		} else if ($locationId != '0') {
			$dataLocation = $this->locations_model->getById($locationId);
			if ($dataLocation && sizeof($dataLocation) > 0) {
				$displayString .= "<strong>{$this->lang->line('For ')} {$this->lang->line('Location')} :</strong> {$dataLocation[0]->location_name } ";
			}
		} else {
			$displayString .= "{$this->lang->line('All Programs of All Locations ')} ";
		}

		$html .= $displayString . "<br><br>";

		$pdf->SetFont('Helvetica', '', 9);
		$html .= '<table border="0.5" style="margin-bottom:0;">';
		$html .="<thead>";
		$html .='<tr style="color:#000000; line-height:15px;">';

			if ($programId == "0") {
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Program Name").'</span></th>';
				if ($locationId == '0') {
					$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
								.$this->lang->line("Location").'</span></th>';
				}
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Fund Available").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Budget Estimated").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Budget Deficiency").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Activity Cost Total").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Overall Budget Varience").'</span></th>';
			} else {
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Activity Name").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Start Date").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Finish Date").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Activity Owner").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Activity Budget").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center; width: 11%"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Activity Completion").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Actual Start Date").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Actual Finished Date").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Activity Cost").'</span></th>';
				$html.='<th style="vertical-align:bottom; text-align:center;"><span style="font-weight:bold; font-size:9px">'
							.$this->lang->line("Budget Varience").'</span></th>';
			}
			
		$html.="</tr>
		   </thead>";

		$programData = $this->getProgramDetailsDataFromDB($programId, $locationId, true);

		$html.= $programData['0'];

		$html.="</table>";
		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->lastPage();
		$pdf_file_name = 'ProgramDetailsReport.pdf';
		$pdf->Output($pdf_file_name, 'I');
	}

	public function getProgramDetailsDataFromDB($programId, $locationId, $print=null) {
		
		$html='';
		$totalBudgetAvailable = 0;
		$totalBudgetEstimated = 0;
		$budgetDeficiencyTotal = 0;
		$activityCostTotal = 0;
		$budgetVarienceTotal = 0;
		
		$budgetAvailable = 0;
		$budgetEstimated = 0;
		$budgetDeficiency = 0;
		$activityCost = 0;
		$budgetVarience = 0;

		if ($programId == "0") {
			$programDetails = $this->program_activities_model->getAllProgramsDetailForProgramAndLocation($programId, $locationId);
			
			if ($programDetails && sizeof($programDetails) > 0) {
				$this->arraySortByColumn($programDetails, 'program_name');
			}
		} else {
			$programDetails = $this->program_activities_model->getAllActivitiesForAProgram('program_activity_id', 'asc', $programId);
		}
		
		if ($programDetails != null) {

			if ($programId == "0") {
				foreach ($programDetails as $row) {

					$html .= '<tr style="line-height:15px;">';

					if ($print) {
						$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['program_name'] . '</span></td>';
					} else {
						$html .= '<td>' . $row['program_name'] . '</td>';
					}

					if ($locationId == '0') {
						
						if ($print) {
							$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row['location_name'] . '</span></td>';
						} else {
							$html .= '<td>' . $row['location_name'] . '</td>';
						}
					}

					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($row['budget_available'], 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($row['budget_available'], 2) . '</td>';
					}

					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($row['budget_estimated'], 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($row['budget_estimated'], 2) . '</td>';
					}

					$budgetDeficiency = $row['budget_available'] - $row['budget_estimated'];
					if ($budgetDeficiency < 0) {
						$budgetDeficiency = -($budgetDeficiency);
					} else {
						$budgetDeficiency = 0.00;
					}

					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($budgetDeficiency, 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($budgetDeficiency, 2) . '</td>';
					}

					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($row['activity_cost_total'], 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($row['activity_cost_total'], 2) . '</td>';
					}

					$budgetVarience = $row['activity_cost_total'] - $row['budget_estimated'];
					if ($budgetVarience < 0) {
						$budgetVarience = 0.00;
					}

					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($budgetVarience, 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($budgetVarience, 2) . '</td>';
					}

					$html .= "</tr>";

					$totalBudgetAvailable = $totalBudgetAvailable + $row['budget_available'];
					$totalBudgetEstimated = $totalBudgetEstimated + $row['budget_estimated'];
					$budgetDeficiencyTotal = $budgetDeficiencyTotal + $budgetDeficiency;
					$activityCostTotal = $activityCostTotal + $row['activity_cost_total'];
					$budgetVarienceTotal = $budgetVarienceTotal + $budgetVarience;
				}

				if ($print) {
					$html .= "<br><br>";
					$html .= '<table width= "100%" border="0.5">'
							. "<thead>"
							. "<tr>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Total Fund Available") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Total Budget Estimated") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Budget Deficiency Total") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Activity Cost Total") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Budget Varience Total") . "</span></th>"
							. "</tr>"
							. "</thead>"
							. "<tbody>"
							. "<tr>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom; height: 15px;">'. number_format($totalBudgetAvailable, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($totalBudgetEstimated, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($budgetDeficiencyTotal, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($activityCostTotal, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($budgetVarienceTotal, 2). "</td>"
							. "</tr>"
							. "</tbody>"
							. "</table>";
				}
				
				return array($html, $totalBudgetAvailable, $totalBudgetEstimated, $budgetDeficiencyTotal, $activityCostTotal, $budgetVarienceTotal);
			} else {
				$activityCount = 0;
				$activityCompletionTotal = 0;
				$programData = $this->programs_model->getById($programId);
				$budgetAvailable = $programData[0]->fund_available;
				
				foreach ($programDetails as $row) {

					$html .= '<tr style="line-height:15px;">';

					if ($print) {
						$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row->activity_name . '</span></td>';
					} else {
						$html .= '<td>' . $row->activity_name . '</td>';
					}

					if ($print) {
						$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $row->start_date . '</span></td>';
					} else {
						$html .= '<td>' . $row->start_date . '</td>';
					}
			
					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $row->finish_date . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . $row->finish_date . '</td>';
					}

					$activityOwnerId = $row->owner_id;
					$activityOwner = $this->peoples_model->getById($activityOwnerId);
					$activityOwnerName = $activityOwner[0]->people_name;
					
					if ($print) {
						$html .= '<td style="text-align:center;"><span style="font-size:8px">' . $activityOwnerName . '</span></td>';
					} else {
						$html .= '<td style="text-align:center;">' . $activityOwnerName . '</td>';
					}

					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($row->activity_budget, 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($row->activity_budget, 2) . '</td>';
					}

					$activityCompletionTotal = $activityCompletionTotal + ($row->activity_completion)/100;
					
					if ($print) {
						$html .= '<td style="text-align:center; width: 11%"><span style="font-size:8px">' . number_format($row->activity_completion) . '%</span></td>';
					} else {
						$html .= '<td style="text-align:center;">' . number_format($row->activity_completion) . '%</td>';
					}

					if ($row->actual_start_date != "0000-00-00") {
						$actualStartDate = $row->actual_start_date;
					} else {
						$actualStartDate = "";
					}
					
					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $actualStartDate . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . $actualStartDate . '</td>';
					}
					
					if ($row->actual_finished_date != "0000-00-00") {
						$actualFinishedDate = $row->actual_finished_date;
					} else {
						$actualFinishedDate = "";
					}
					
					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . $actualFinishedDate . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . $actualFinishedDate . '</td>';
					}
					
					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($row->activity_cost, 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($row->activity_cost, 2) . '</td>';
					}
					
					if ($print) {
						$html .= '<td style="text-align:right;"><span style="font-size:8px">' . number_format($row->budget_varience, 2) . '</span></td>';
					} else {
						$html .= '<td style="text-align:right;">' . number_format($row->budget_varience, 2) . '</td>';
					}

					$html .= "</tr>";

					$budgetEstimated = $budgetEstimated + $row->activity_budget;
					$activityCost = $activityCost + $row->activity_cost;
					$budgetVarience = $budgetVarience + $row->budget_varience;
					
					$activityCount++;
				}

				$budgetProgress = number_format(($activityCost/$budgetEstimated) * 100) . "%";
				
				$activityProgress = number_format(($activityCompletionTotal/$activityCount) * 100) . "%";
				
				if ($print) {
					$html .= "<br><br>";
					$html .= '<table width= "100%" border="0.5">'
							. "<thead>"
							. "<tr>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Fund Available") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Budget Estimated") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Budget Deficiency") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Activity Cost") . "</span></th>"
								. '<th style="vertical-align:bottom; text-align:center; height: 20px;"><span style="font-weight:bold; font-size:9px">' . $this->lang->line("Budget Varience") . "</span></th>"
							. "</tr>"
							. "</thead>"
							. "<tbody>"
							. "<tr>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom; height: 15px;">'. number_format($budgetAvailable, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($budgetEstimated, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($budgetDeficiency, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($activityCost, 2). "</td>"
								. '<td style="text-align:center; font-size:8px; vertical-align:bottom;">'. number_format($budgetVarience, 2). "</td>"
							. "</tr>"
							. "</tbody>"
							. "</table><br><br><br><br>";
					
					$html .='<table width= "100%" border="">'
							. "<tbody>"
							. "<tr>"
								. '<td style="text-align:center; font-size:10px; vertical-align:bottom; height: 15px;">'. $this->lang->line("Program Progress in Terms of Budget") . "</td>"
								. '<td style="text-align:center; font-size:10px; vertical-align:bottom; height: 15px;">'. $this->lang->line("Program Progress in Terms of Activity Completion") . "</td>"
							. "</tr>"
							. "<tr>"
								. '<td style="text-align:center; font-size:25px; vertical-align:bottom; height: 15px; color: blue;">'. $budgetProgress . "</td>"
								. '<td style="text-align:center; font-size:25px; vertical-align:bottom; height: 15px; color: orange;">'. $activityProgress . "</td>"
							. "</tr>"
							. "</tbody>"
							. "</table>";
				}
				
				if (($budgetEstimated - $budgetAvailable) > 0) {
					$budgetDeficiency = $budgetEstimated - $budgetAvailable;
				} else {
					$budgetDeficiency = 0.00;
				}
				
				return array($html, $budgetAvailable, $budgetEstimated, $budgetDeficiency, $activityCost, $budgetVarience, $budgetProgress, $activityProgress);
			}
		}
	}
	//  End of Program Details Report  ///////////////////////////////////////////////////////////////////////////////////
	
	public function getLocationOfAProgram() {
		$programId = $this->db->escape_str($this->input->post('program_id'));
		$programData = $this->programs_model->getById($programId);
		
		echo $programData[0]->location_id;
	}
			
	function arraySortByColumn(&$array, $column, $direction = SORT_DESC) {
		$sort_col = array();
		foreach ($array as $key=> $row) {
			$sort_col[$key] = $row[$column];
		}

		array_multisort($sort_col, $direction, $array);
	}
}

