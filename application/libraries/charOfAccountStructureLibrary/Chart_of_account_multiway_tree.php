<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_of_account_multiway_tree {
	public $root;
    public $leafChartOfAccountIds;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('charOfAccountStructureLibrary/chart_of_account_tree_node');
		$this->root = null;
        $this->leafChartOfAccountIds = array();
	}

	public function insertChartOfAccountTreeNode($chartOfAccountId, $parentChartOfAccountId=null) {
		$newChartOfAccountTreeNode = new Chart_of_account_tree_node();
		$newChartOfAccountTreeNode->setChartOfAccountId($chartOfAccountId);

		if($this->root == null) {
			$this->root = $newChartOfAccountTreeNode;
			return "inserted";
		} else {
			$current = $this->root;
			$stopPointCount = 0;
			$stopPoint = array();

			if ($parentChartOfAccountId == '') {
				while ($current->parallelNode != null) {
					$current = $current->parallelNode;
				}
				$current->parallelNode = $newChartOfAccountTreeNode;
				return "inserted";
			}

			while(true) {
				if($parentChartOfAccountId == $current->getChartOfAccountId()) {
					if($current->child == null) {
						$current->child = $newChartOfAccountTreeNode;
						$newChartOfAccountTreeNode->previous = $current;
						return "inserted";
					} else {
						$current = $current->child;
						while(true) {
							if ($current->parallelNode == null) {
								$current->parallelNode = $newChartOfAccountTreeNode;
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
    
    public function getLeafChartOfAccountIds($current) {
        
        if ($current->child != null) {
            $childNode = $current->child;
            $this->getLeafChartOfAccountIds($childNode);
            $parallelNode = $current->parallelNode;
            
            if ($parallelNode != '') {
                $this->getLeafChartOfAccountIds($parallelNode);
            }
        } else if ($current->parallelNode != null) {
            $childNode = $current->child;
            
            if ($childNode != '') {
                $this->getLeafChartOfAccountIds($childNode);
            } else {
                $this->leafChartOfAccountIds[] = $current->chartOfAccountId;
            }
            
            $parallelNode = $current->parallelNode;
            $this->getLeafChartOfAccountIds($parallelNode);
        } else {
            $this->leafChartOfAccountIds[] = $current->chartOfAccountId;
        }
        
        return $this->leafChartOfAccountIds;
    }
}
