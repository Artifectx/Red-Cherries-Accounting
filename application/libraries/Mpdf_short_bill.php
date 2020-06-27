<?php

class Mpdf_short_bill {

	function Mpdf_short_bill() {
		$CI = & get_instance();
		log_message('Debug', 'mPDF class is loaded.');
	}

	function load($mode=null, $format=null, $defaultFontSize=null, $defaultFont=null, $mgl=null, $mgr=null, $mgt=null, $mgb=null, $mgh=null, $mgf=null, $orientation=null) {
		require_once dirname(__FILE__).'/mpdf/mpdf.php';

		if ($mode == null && $format == null && $defaultFontSize == null && $defaultFont == null && $mgl == null && $mgr == null && $mgt == null && $mgb == null && $mgh == null && $mgf == null && $orientation == null) {
			$param = "'mode' => 'utf-8', '', 0, '', 0, 0, 0, 0, 0, 0";
			return new mPDF($param);
		} else {
			return new mPDF($mode, $format, $defaultFontSize, $defaultFont, $mgl, $mgr, $mgt, $mgb, $mgh, $mgf, $orientation);
		}
	}
}