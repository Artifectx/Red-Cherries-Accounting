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

class Tax_multiway_tree {
	public $root;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('tax_processor_library/tax_tree_node');
		$this->root = null;
	}

	public function insertTaxTreeNode($taxTypeId, $percentage, $taxAmount, $dependencyTaxId=null) {
		$newTaxTreeNode = new Tax_tree_node();
		$newTaxTreeNode->setTaxTypeId($taxTypeId);
		$newTaxTreeNode->setTaxPercentage($percentage);
		$newTaxTreeNode->setTaxAmount($taxAmount);

		if($this->root == null) {
			$this->root = $newTaxTreeNode;
			return "inserted";
		} else {
			$current = $this->root;
			$stopPointCount = 0;
			$stopPoint = array();

			if ($dependencyTaxId == '') {
				while ($current->parallelNode != null) {
					$current = $current->parallelNode;
				}
				$current->parallelNode = $newTaxTreeNode;
				return "inserted";
			}

			while(true) {
				if($dependencyTaxId == $current->getTaxTypeId()) {
					if($current->child == null) {
						$current->child = $newTaxTreeNode;
						$newTaxTreeNode->previous = $current;
						return "inserted";
					} else {
						$current = $current->child;
						while(true) {
							if ($current->parallelNode == null) {
								$current->parallelNode = $newTaxTreeNode;
								return "inserted";
							} else {
								$current = $current->parallelNode;
							}
						}
					}
				} else {
					if ($current->parallelNode != null) {
						if ($current->child != null) {
							$stopPointCount++;
							$stopPoint[$stopPointCount] = $current;
						}
						$current = $current->parallelNode;
					} else {
						if($current->child != null) {
							$current = $current->child;
						} else {
							$current = $stopPoint[$stopPointCount];
							$current = $current->child;
							$stopPointCount--;
						}
					}                    
				}
			}
		}
	}

	public function calculateTaxForTaxTreeNodes($amount) {

		$taxArray = array();

		if($this->root != null) {
			$rootParallelLevelTreeNode = $this->root;
			$sumPointCount = 0;
			$sumPoint = array();
			$current = $this->root;

			$taxSum = 0;
			$traverseParallelTreeBranch = false;
			$treeBranchAlreadyTraversed = false;
			while(true) {
				while ($current->child != null && !$treeBranchAlreadyTraversed) {
					$current = $current->child;
				}

				$taxAmount = $this->calculateTaxForATaxNode($amount + $taxSum, $current->getTaxPercentage());
				$current->setTaxAmount($taxAmount);
				$taxArray[$current->getTaxTypeId()] = $taxAmount;

				if ($current->parallelNode != null) {
					$taxSum = 0;
					$sumPointCount++;
					$sumPoint[$sumPointCount] = $current;
					$traverseParallelTreeBranch = true;
					$treeBranchAlreadyTraversed = false;
					if ($current == $this->root) {
						$rootParallelLevelTreeNode = $current->parallelNode;
					}
					$current = $current->parallelNode;

				} else {
					$treeBranchAlreadyTraversed = true;
					if ($current->previous != null) {
						$taxSum = $taxSum + $current->getTaxAmount();
						$current = $current->previous;
					} else {
						if ($current == $rootParallelLevelTreeNode) {
							break;
						}
						$taxSum = 0;
						$current = $sumPoint[$sumPointCount];
						while ($current != null) {
							$taxSum = $taxSum + $current->getTaxAmount();
							$current = $current->parallelNode;
						}
						$current = $sumPoint[$sumPointCount]->previous;
						$sumPointCount--;
					}
				}
			}
		}

		return $taxArray;
	}

	public function calculateTaxForATaxNode($amount, $percentage) {
		return $taxAmount = ($amount * $percentage) / 100;
	}
}
