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

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define("Version", "1.0 Beta 1");

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_reports extends TCPDF {
	function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
		parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);

		$this->SetMargins('15', '30', '10');
		$this->SetHeaderMargin('8');
		$this->SetFooterMargin('10');
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_TOP);
		$this->SetAutoPageBreak(True, PDF_MARGIN_HEADER);
		$this->SetAutoPageBreak(True, PDF_MARGIN_FOOTER);
		$this->setHeaderTemplateAutoreset(True);
		
		$this->CI =& get_instance();
		$this->CI->load->model('organizationManagerModule/organizationSection/company_information_model', '', TRUE);
	}

	public function Header() {
		$headerdata = $this->getHeaderData();
		$company = $this->CI->company_information_model->getAll();

		if($company != null){
			if($company[0]->company_logo !=''){
				$image_file = base_url().$company[0]->company_logo;
				$this->Image($image_file,'','',30,20);
			}

			$companyName = $company[0]->company_name;
			
			$this->SetFont('Helvetica','B',15);
			$this->Cell(0, 0, $companyName, 0, 0, 'C');
			$this->SetFont('Helvetica','',8);
			$this->Ln(4);
			$this->Cell(0,10, "Address : " . $company[0]->address, 0, false, 'C');
			$this->Ln(4);
			if ($company[0]->web != '') {
				$this->Cell(0,10, "Web : " . $company[0]->web.' - TP : '.$company[0]->primary_telephone_number.' - E-mail : '.$company[0]->email, 0, false, 'C');
			} else {
				$this->Cell(0,10, 'TP : '.$company[0]->primary_telephone_number.' - E-mail : '.$company[0]->email, 0, false, 'C');
			}
		}

		$this->Ln(8);
		$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
		$imgy = $this->getImageRBY();
		$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
		if ($this->rtl) {
				$this->SetX($this->original_rMargin);
		} else {
				$this->SetX($this->original_lMargin);
		}
		$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
		$this->Ln(5);
	}


	// Page footer
	public function Footer() {
		$this->SetFont('Helvetica','',8);
		$this->Cell(0, 0, 'Red Cherries Accounting Version ' . Version . ' ', 0, 0, 'C');
		$this->Ln(5);
		$this->SetFont('Helvetica','',7);
		$this->Cell(0, 0, 'Copyright  2020 Red Cherries Accounting By Artifectx - www.artifectx.com - T : +94-77-973-80-68 - E : contact.artifectx@gmail.com', 0, 0, 'C');
		$this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Ln(5);
	}

	public function pageFormat($format, $orientation) {
		$this->setPageFormat($format, $orientation);
	}
}