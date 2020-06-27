<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_processor {
    
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('stockManagerModule/adminSection/tax_types_model', '', TRUE);
		$this->CI->load->model('stockManagerModule/adminSection/tax_chains_model', '', TRUE);

		$this->CI->load->library('tax_processor_library/tax_multiway_tree');
	}

	public function processTax($amount, $taxChainId) {

		$taxTree = $this->prepareTaxTree($taxChainId);
		$taxArray = $taxTree->calculateTaxForTaxTreeNodes($amount);

		return $taxArray;
	}

	public function prepareTaxTree($taxChainId) {
		$taxChain = $this->CI->tax_chains_model->getById($taxChainId);
		$taxTypesInTaxChain = $this->CI->tax_chains_model->getTaxTypesForATaxChain($taxChainId);
		$taxTypeIdsInTaxChain = array();

		foreach ($taxTypesInTaxChain as $taxType) {
			$taxTypeIdsInTaxChain[] = $taxType->tax_type_id;
		}

		$taxTree = new Tax_multiway_tree();

		$thereAreTaxTypesToBeInsertedToTaxProcessor = true;
		$alreadyInsertedTaxTypesToTaxProcessor = array(0);

		while($thereAreTaxTypesToBeInsertedToTaxProcessor) {

			$taxTypesWithNoParentTaxTypeAndWithNoPrerequisiteTaxTypes = array();
			$taxTypesWithNoParentTaxTypeAndWithPrerequisiteTaxTypes = array();
			$taxTypesWithParentTaxTypeAndWithPrerequisiteTaxTypes = array();
			$taxTypesWithParentTaxTypeAndWithNoPrerequisiteTaxTypes = array();

			if ($taxTypesInTaxChain && sizeof($taxTypesInTaxChain) > 0) {

				$thereIsAParentTaxType = "Yes";
				$thereArePrerequisiteTaxTypes = "No";
				$alreadyInserted = false;

				foreach ($taxTypesInTaxChain as $taxType) {

					$alreadyInserted = in_array($taxType->tax_type_id, $alreadyInsertedTaxTypesToTaxProcessor);
					if (!$alreadyInserted) {

						$allParentTaxTypes = $this->CI->tax_types_model->getPrerequisiteTaxTypesByPrerequisiteTaxTypeId($taxType->tax_type_id);
						$allPrerequisiteTaxTypes = $this->CI->tax_types_model->getPrerequisiteTaxTypesForATaxType($taxType->tax_type_id);

						$applicableParentTaxTypes = array();
						if ($allParentTaxTypes && sizeof($allParentTaxTypes) > 0) {
							foreach ($allParentTaxTypes as $parentTaxType) {
								if (in_array($parentTaxType->tax_type_id, $taxTypeIdsInTaxChain)) {
									$applicableParentTaxTypes[] = $parentTaxType;
								}
							}
						}

						$applicablePrerequisiteTaxTypes = array();
						if ($allPrerequisiteTaxTypes && sizeof($allPrerequisiteTaxTypes) > 0) {
							foreach ($allPrerequisiteTaxTypes as $prerequisiteTaxType) {
								if (in_array($prerequisiteTaxType->tax_type_id, $taxTypeIdsInTaxChain)) {
									$applicablePrerequisiteTaxTypes[] = $prerequisiteTaxType;
								}
							}
						}

						if (sizeof($applicableParentTaxTypes) > 0) {
							$hasParentTaxType = true;
						} else {
							$hasParentTaxType = false;
						}

						if (sizeof($applicablePrerequisiteTaxTypes) > 0) {
							$hasPrerequisiteTaxTypes = true;
						} else {
							$hasPrerequisiteTaxTypes = false;
						}

						$parentTaxTypeId = '';
						if ($hasParentTaxType != false) {
							$parentTaxTypeId = $this->getImmediateParentForATaxType($applicableParentTaxTypes);
						}

						if ($hasParentTaxType == false && $hasPrerequisiteTaxTypes == false) {
							$taxTypesWithNoParentTaxTypeAndWithNoPrerequisiteTaxTypes[$parentTaxTypeId . "-" . $taxType->tax_type_id] = $taxType->tax_type_id;
						} else if ($hasParentTaxType == false && $hasPrerequisiteTaxTypes != false) {
							$taxTypesWithNoParentTaxTypeAndWithPrerequisiteTaxTypes[$parentTaxTypeId . "-" . $taxType->tax_type_id] = $taxType->tax_type_id;
						} else if ($hasParentTaxType != false && $hasPrerequisiteTaxTypes != false) {
							$parentAlreadyInserted = in_array($parentTaxTypeId, $alreadyInsertedTaxTypesToTaxProcessor);
							if ($parentAlreadyInserted) {
								$taxTypesWithNoParentTaxTypeAndWithPrerequisiteTaxTypes[$parentTaxTypeId . "-" . $taxType->tax_type_id] = $taxType->tax_type_id;
							} else {
								$taxTypesWithParentTaxTypeAndWithPrerequisiteTaxTypes[$parentTaxTypeId . "-" . $taxType->tax_type_id] = $taxType->tax_type_id;
							}
						} else if ($hasParentTaxType != false && $hasPrerequisiteTaxTypes == false) {
							$taxTypesWithParentTaxTypeAndWithNoPrerequisiteTaxTypes[$parentTaxTypeId . "-" . $taxType->tax_type_id] = $taxType->tax_type_id;
						}
					}
				}
			}

			if (sizeof($taxTypesWithNoParentTaxTypeAndWithPrerequisiteTaxTypes) > 0) {
				foreach ($taxTypesWithNoParentTaxTypeAndWithPrerequisiteTaxTypes as $key => $taxTypeId) {
					$taxType = $this->CI->tax_types_model->getById($taxTypeId);
					$keyData = explode("-", $key);
					$message = $taxTree->insertTaxTreeNode($taxTypeId, $taxType[0]->tax_percentage, '0', trim($keyData[0]));
					if ($message == "inserted") {
						$alreadyInsertedTaxTypesToTaxProcessor[] = $taxTypeId;
					}
				}
				unset($taxTypesWithNoParentTaxTypeAndWithNoPrerequisiteTaxTypes);
				unset($taxTypesWithNoParentTaxTypeAndWithPrerequisiteTaxTypes);
				unset($taxTypesWithParentTaxTypeAndWithPrerequisiteTaxTypes);
				unset($taxTypesWithParentTaxTypeAndWithNoPrerequisiteTaxTypes);
			} else if (sizeof($taxTypesWithNoParentTaxTypeAndWithNoPrerequisiteTaxTypes) > 0) {
				foreach ($taxTypesWithNoParentTaxTypeAndWithNoPrerequisiteTaxTypes as $key => $taxTypeId) {
					$taxType = $this->CI->tax_types_model->getById($taxTypeId);
					$keyData = explode("-", $key);
					$message = $taxTree->insertTaxTreeNode($taxTypeId, $taxType[0]->tax_percentage, '0', trim($keyData[0]));
					if ($message == "inserted") {
						$alreadyInsertedTaxTypesToTaxProcessor[] = $taxTypeId;
					}
				}
				unset($taxTypesWithNoParentTaxTypeAndWithNoPrerequisiteTaxTypes);
				unset($taxTypesWithNoParentTaxTypeAndWithPrerequisiteTaxTypes);
				unset($taxTypesWithParentTaxTypeAndWithPrerequisiteTaxTypes);
				unset($taxTypesWithParentTaxTypeAndWithNoPrerequisiteTaxTypes);
			} else {
				$thereAreTaxTypesToBeInsertedToTaxProcessor = false;

				if (sizeof($taxTypesWithParentTaxTypeAndWithNoPrerequisiteTaxTypes) > 0) {
					foreach ($taxTypesWithParentTaxTypeAndWithNoPrerequisiteTaxTypes as $key => $taxTypeId) {
						$taxType = $this->CI->tax_types_model->getById($taxTypeId);
						$keyData = explode("-", $key);
						$message = $taxTree->insertTaxTreeNode($taxTypeId, $taxType[0]->tax_percentage, '0', trim($keyData[0]));
						if ($message == "inserted") {
							$alreadyInsertedTaxTypesToTaxProcessor[] = $taxTypeId;
						}
					}
				}
			}
		}

		return $taxTree;
	}

	public function getImmediateParentForATaxType($parentTaxTypes) {

		$taxIDToVerify = array();
		foreach ($parentTaxTypes as $taxType) {
			$taxIDToVerify[] = $taxType->tax_type_id;
		}

		$immediateTaxID = 0;
		foreach ($parentTaxTypes as $taxType) {
			$prerequisiteTaxIDsForTaxType = array();
			$hasPrerequisiteTaxTypes = $this->CI->tax_types_model->getPrerequisiteTaxTypesForATaxType($taxType->tax_type_id);

			foreach ($hasPrerequisiteTaxTypes as $prerequisiteTaxType) {
				$result = in_array($prerequisiteTaxType->prerequisite_tax_type_id, $taxIDToVerify);
				if ($result) {
					$prerequisiteTaxIDsForTaxType[] = $prerequisiteTaxType->tax_type_id;
				}
			}

			if (empty($prerequisiteTaxIDsForTaxType)) {
				$immediateTaxID = $taxType->tax_type_id;
			}
		}

		return $immediateTaxID;
	}
}
