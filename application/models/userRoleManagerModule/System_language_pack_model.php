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

		$this->optionList = '<option value="0">' . $this->lang->line('-- Select --') . '</option>';
        $this->optionList .= '<option value="chinesesimplified">Chinese (Simplified)</option>';
        $this->optionList .= '<option value="chinesetraditional">Chinese (Traditional)</option>';
        $this->optionList .= '<option value="english">English</option>';
        $this->optionList .= '<option value="french">French</option>';
        $this->optionList .= '<option value="german">German</option>';
        $this->optionList .= '<option value="hindi">Hindi</option>';
        $this->optionList .= '<option value="hungarian">Hungarian</option>';
        $this->optionList .= '<option value="italian">Italian</option>';
        $this->optionList .= '<option value="indonesian">Indonesian</option>';
        $this->optionList .= '<option value="japanese">Japanese</option>';
        $this->optionList .= '<option value="korean">Korean</option>';
        $this->optionList .= '<option value="nepali">Nepali</option>';
        $this->optionList .= '<option value="portuguese">Portuguese</option>';
        $this->optionList .= '<option value="polish">Polish</option>';
        $this->optionList .= '<option value="russian">Russian</option>';
        $this->optionList .= '<option value="romanian">Romanian</option>';
        $this->optionList .= '<option value="sinhala">Sinhala</option>';
        $this->optionList .= '<option value="spanish">Spanish</option>';
        $this->optionList .= '<option value="tamil">Tamil</option>';
        $this->optionList .= '<option value="thai">Thai</option>';
        $this->optionList .= '<option value="turkish">Turkish</option>';
        $this->optionList .= '<option value="ukrainian">Ukrainian</option>';
        $this->optionList .= '<option value="vietnamese">Vietnamese</option>';

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
    
    public function getEnglishTranslationForLanguageString($languageStringId) {
        $this->db->where('language_name', "English");
        $this->db->where('language_string_id', $languageStringId);
		$query = $this->db->get('system_language_translations');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
    }
}
