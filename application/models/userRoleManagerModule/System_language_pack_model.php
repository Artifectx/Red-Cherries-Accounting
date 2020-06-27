<?php

class System_language_pack_model extends CI_model {

	public function __construct() {
		parent::__construct();
	}

	public function addLanguageString($data) {
		$this->db->insert('system_language_strings', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}

	public function editLanguageString($id, $data) {
		$this->db->where('language_string_id', $id);
		$this->db->update('system_language_strings', $data);
		$this->db->limit(1);
		return true;
	}
	
	public function addLanguageTranslation($data) {
		$this->db->insert('system_language_translations', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}

	public function editLanguageTranslation($id, $data) {
		$this->db->where('language_translation_id', $id);
		$this->db->update('system_language_translations', $data);
		$this->db->limit(1);
		return true;
	}
	
	public function addTranslationGenerationStatus($data) {
		$this->db->insert('system_language_translations_generation_status', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}
	
	public function editTranslationGenerationStatus($id, $data) {
		$this->db->where('translation_generation_id', $id);
		$this->db->update('system_language_translations_generation_status', $data);
		$this->db->limit(1);
		return true;
	}
	
	public function getLanguageStringByName($stringName) {
		$this->db->where('language_string', $stringName);
		$query = $this->db->get('system_language_strings');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getLanguageStringByLanguageStringId($languageStringId) {
		$this->db->where('language_string_id', $languageStringId);
		$query = $this->db->get('system_language_strings');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getLanguageStringByProductCode($productCode) {
		$this->db->where('product_code', $productCode);
		$query = $this->db->get('system_language_strings');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getLanguageTranslationByLanguageStringId($languageStringId) {
		$this->db->where('language_string_id', $languageStringId);
		$query = $this->db->get('system_language_translations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getLanguageStrings($moduleId, $stringType, $screen, $language) {
		
		$this->db->join('system_language_translations', 'system_language_translations.language_string_id=system_language_strings.language_string_id','left');
		
		if ($moduleId != '') {
			$this->db->where('system_module_id', $moduleId);
		}
		
		if ($stringType != '') {
			$this->db->where('language_string_type', $stringType);
		}
		
		if ($screen != '') {
			$this->db->where('screen_name', $screen);
		}
		
		$this->db->where('language_name', $language);

		$this->db->select('system_language_strings.language_string_id, system_module_id, language_translation_id, screen_name, language_string_type, language_string, translated_string');
		$query = $this->db->get('system_language_strings');
		
		if ($query->num_rows() > 0) {
			$translatedStrings = $query->result();
			
			$translatedStringSearch = array();
			foreach($translatedStrings as $translatedString) {
				$translatedStringSearch[] = (array)$translatedString;
			}
			
			if ($moduleId != '') {
				$this->db->where('system_module_id', $moduleId);
			}

			if ($stringType != '') {
				$this->db->where('language_string_type', $stringType);
			}

			if ($screen != '') {
				$this->db->where('screen_name', $screen);
			}

			$this->db->select('language_string_id, system_module_id, "" AS language_translation_id, screen_name, language_string_type, language_string, "" AS translated_string');
			$query = $this->db->get('system_language_strings');
			
			$languageStrings = $query->result();
			
			foreach($languageStrings as $languageString) {
				$referenceArray = array_column($translatedStringSearch, 'language_string');
				$key = in_array($languageString->language_string, $referenceArray);
				if (!$key) {
					$translatedStrings[] = $languageString;
				}
			}
			
			return $translatedStrings;
		} else {
			if ($moduleId != '') {
				$this->db->where('system_module_id', $moduleId);
			}

			if ($stringType != '') {
				$this->db->where('language_string_type', $stringType);
			}

			if ($screen != '') {
				$this->db->where('screen_name', $screen);
			}

			$this->db->select('language_string_id, system_module_id, "" AS language_translation_id, screen_name, language_string_type, language_string, "" AS translated_string');
			$query = $this->db->get('system_language_strings');
			
			return $query->result();
		}
	}

	public function getLanguageOptionList() {

		$this->optionList = '';
		$this->optionList .= '<option value="english">English</option>';
		$this->optionList .= '<option value="french">French</option>';
		$this->optionList .= '<option value="german">German</option>';
		$this->optionList .= '<option value="chinese">Chinese</option>';
		$this->optionList .= '<option value="japanes">Japanes</option>';
		$this->optionList .= '<option value="sinhala">Sinhala</option>';

		return $this->optionList;
	}
	
	public function getScreenListOfSelectedModule($moduleId) {
		
		$this->db->distinct("screen_name");
		$this->db->select("screen_name");
		
		if ($moduleId != '') {
			$this->db->where('system_module_id', $moduleId);
		}
		
		$query = $this->db->get('system_language_strings');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getTranslationGenerationStatus($languageName) {
		$this->db->where('language_name', $languageName);
		$query = $this->db->get('system_language_translations_generation_status');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
