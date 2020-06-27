<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_short_bill extends TCPDF {
    
	function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
		parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);

		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_TOP);
		$this->SetAutoPageBreak(True, PDF_MARGIN_HEADER);
		$this->SetAutoPageBreak(True, PDF_MARGIN_FOOTER);
		$this->setHeaderTemplateAutoreset(True);

		$this->CI =& get_instance();
		$this->CI->load->model('organizationManagerModule/organizationSection/company_information_model', '', TRUE);
	}

	//Page header
	public function Header() {
		// Logo
//        $image_file = K_PATH_IMAGES.'logo_example.jpg';
//        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 12);

		$company = $this->CI->company_information_model->getAll();

		$licenseProperties = ioncube_license_properties();

		$companyName = '';
		$companyAddress = '';
		$telephone = '';
		if($company != null){

			if ($licenseProperties && sizeof($licenseProperties) > 0) {
				if (array_key_exists("licensedTo", $licenseProperties)) {
					$companyName = $licenseProperties['licensedTo']['value'];
				} else {
					$companyName = $company[0]->company_name;
				}
			} else {
				$companyName = $company[0]->company_name;
			}     

			$companyAddress = $company[0]->address;
			$telephone = $company[0]->primary_telephone_number;
		}
		// Title
		$this->Cell(0, 15, $companyName, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->Ln(4);

		$this->SetFont('helvetica', 'B', 8);

		$this->Cell(0, 15, $companyAddress, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->Ln(4);
		$this->Cell(0, 15, "TP : "  . $telephone, 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-18);
		// Set font
		$this->SetFont('helvetica', '', 8);
		// Page number
		$this->Cell(0, 10, 'Software By Artifectx Solutions (Pvt) Ltd.', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Ln(4);
		$this->SetFont('helvetica', '', 7);
		$this->Cell(0, 10, 'Tel : +94779738068 / +94779089655', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Ln(3);
		$this->Cell(0, 10, 'Web : www.artifectx.com', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Ln(3);
		$this->Cell(0, 10, 'Email : info@artifectx.com', 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}


