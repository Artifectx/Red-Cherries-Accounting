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

class Tax_tree_node {
    
	public $taxTypeId;
	public $percentage;
	public $taxAmount;
	public $child;
	public $previous;
	public $parallelNode;

	public function __construct() {
		$this->CI =& get_instance();
		$this->child = null;
		$this->previous = null;
		$this->parallelNode = null;
	}

	public function setTaxTypeId($taxTypeId) {
		return $this->taxTypeId = $taxTypeId;
	}

	public function setTaxPercentage($percentage) {
		return $this->percentage = $percentage;
	}

	public function setTaxAmount($taxAmount) {
		return $this->taxAmount = $taxAmount;
	}

	public function getTaxTypeId() {
		return $this->taxTypeId;
	}

	public function getTaxPercentage() {
		return $this->percentage;
	}

	public function getTaxAmount() {
		return $this->taxAmount;
	}
}
