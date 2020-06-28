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