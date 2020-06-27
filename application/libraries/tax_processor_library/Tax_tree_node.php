<?php
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
