<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_of_account_tree_node {
    
	public $chartOfAccountId;
	public $child;
	public $parallelNode;
    public $previous;
    public $childBranchAlreadyTraversed = false;
    public $parallelBranchAlreadyTraversed = false;

	public function __construct() {
		$this->CI =& get_instance();
		$this->child = null;
		$this->previous = null;
		$this->parallelNode = null;
	}

	public function setChartOfAccountId($chartOfAccountId) {
		return $this->chartOfAccountId = $chartOfAccountId;
	}

	public function getChartOfAccountId() {
		return $this->chartOfAccountId;
	}
}
