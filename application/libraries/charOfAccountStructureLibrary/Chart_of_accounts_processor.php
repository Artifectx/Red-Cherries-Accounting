<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_of_accounts_processor {
    
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('accountsManagerModule/adminSection/chart_of_accounts_model', '', TRUE);

		$this->CI->load->library('charOfAccountStructureLibrary/chart_of_account_multiway_tree');
	}

	public function prepareChartOfAccountsMultiwayTree($chartOfAccountId) {
		$childChartOfAccounts = $this->CI->chart_of_accounts_model->getChildren($chartOfAccountId);
		$childChartOfAccountIds = array();

        if ($childChartOfAccounts && sizeof($childChartOfAccounts) > 0) {
            foreach ($childChartOfAccounts as $childChartOfAccount) {
                $childChartOfAccountIds[] = $childChartOfAccount['chart_of_account_id'];
            }
        }

        $alreadyInsertedChartOfAccountsToChartOfAccountsProcessor = array();
        
		$chartOfAccountMultiwayTree = new Chart_of_account_multiway_tree();
        
        $message = $chartOfAccountMultiwayTree->insertChartOfAccountTreeNode($chartOfAccountId);
        if ($message == "inserted") {
            $alreadyInsertedChartOfAccountsToChartOfAccountsProcessor[] = $chartOfAccountId;
        }

		$thereAreChartOfAccountsToBeInsertedToChartOfAccountsProcessor = true;
		$chartOfAccountCount = 0;
        
		while($thereAreChartOfAccountsToBeInsertedToChartOfAccountsProcessor) {

            if (sizeof($childChartOfAccountIds) > 0) {
                
                $nextChartOfAccountId = $childChartOfAccountIds[$chartOfAccountCount];

                $nextChartOfAccount = $this->CI->chart_of_accounts_model->get($nextChartOfAccountId);
                $nextChartOfAccountParentId = $nextChartOfAccount[0]->parent_id;

                $message = $chartOfAccountMultiwayTree->insertChartOfAccountTreeNode($nextChartOfAccountId, $nextChartOfAccountParentId);
                if ($message == "inserted") {
                    $alreadyInsertedChartOfAccountsToChartOfAccountsProcessor[] = $nextChartOfAccountId;
                }

                $childChartOfAccounts = $this->CI->chart_of_accounts_model->getChildren($nextChartOfAccountId);

                if ($childChartOfAccounts && sizeof($childChartOfAccounts) > 0) {
                    foreach ($childChartOfAccounts as $childChartOfAccount) {
                        $childChartOfAccountIds[] = $childChartOfAccount['chart_of_account_id'];
                    }
                }

                unset($childChartOfAccountIds[$chartOfAccountCount]);

                if (sizeof($childChartOfAccountIds) == 0) {
                    $thereAreChartOfAccountsToBeInsertedToChartOfAccountsProcessor = false;
                }

                $chartOfAccountCount++;
            } else {
                $thereAreChartOfAccountsToBeInsertedToChartOfAccountsProcessor = false;
            }
		}
        
        return $chartOfAccountMultiwayTree;
	}

    public function depthFirstTraversalAndFindLeafChartOfAccounts($chartOfAccountMultiwayTree) {
        
        $leafChartOfAccountIds = $chartOfAccountMultiwayTree->getLeafChartOfAccountIds($chartOfAccountMultiwayTree->root);
        
        return $leafChartOfAccountIds;
    }
}
