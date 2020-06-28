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

class System_language_pack_controller extends CI_Controller {

	public function  __construct() {

		parent::__construct();
		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//current date time
		$this->date = date("Y-m-d H:i");

		//load language
		$language = $this->userManagement->getUserLanguage($this->user_id);

		$this->lang->load('form_lang', $language);
		$this->lang->load('message', $language);

		//get user theme
		$this->data['theme'] = $this->userManagement->getUserTheme($this->user_id);

		//get user permission
		$this->data = $this->userManagement->getUserPermissions($this->data);

		//Load version number
		$this->data['version_no'] = $this->userManagement->getSystemVersionNumber();

		$this->data['show_footer'] = true;

		//load models
		$this->load->model('userRoleManagerModule/system_language_pack_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);

		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();

		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
	}

	public function index() {

		//set selected menu
		$data_cls['ul_class_administration_section'] = 'in nav nav-stacked';
		$data_cls['li_class_system_language_pack'] = 'active';

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_user_roles_manager', $data_cls);

		$data['language_list'] = $this->system_language_pack_model->getLanguageOptionList();
		
        $moduleArray = array();
        $allModules = $this->user_model->getAllSystemModules('system_module_id', 'asc');

        foreach($allModules as $module) {
            $moduleArray[$module->system_module_id] = $module->system_module;
        }

		$this->optionList = '<option value="">All</option>';
		foreach($moduleArray as $key => $module) {
			$this->optionList .= '<option value="' . $key . '">' . $module . '</option>';
		}
		
		$data['system_module_list'] = $this->optionList;
			
		if(isset($this->data['URM_Product_Info_View_Language_Pack_Permissions'])) {
			$this->load->view('web/userRoleManagerModule/productInformationSection/systemLanguagePack/index', $data);
		}

		$this->load->view('web/systemManagerModule/footer/footer', $this->data);
	}

	public function getTranslations() {
		
		$moduleId = $this->db->escape_str($this->input->post('module_id'));
		$stringType = $this->db->escape_str($this->input->post('string_type'));
		$screen = $this->db->escape_str($this->input->post('screen'));
		$language = $this->db->escape_str($this->input->post('language'));

		if(isset($this->data['URM_Product_Info_View_Language_Pack_Permissions'])) {

			$html = "";
			$html .= "<div class='box-content box-no-padding out-table'>
						<div class='table-responsive table_data'>
							<div class='scrollable-area1'>
								<table class='table table-striped table-bordered'style='margin-bottom:0;' id='languageTranslationDataTable'>
									<thead>
										<tr>
											<th style='width:10%'>{$this->lang->line('System Module')}</th>
											<th style='width:10%'>{$this->lang->line('Screen')}</th>
											<th style='width:10%'>{$this->lang->line('String Type')}</th>
											<th style='width:20%'>{$this->lang->line('String')}</th>
											<th style='width:50%'>{$this->lang->line('Translation')}</th>
										</tr>
									</thead>
									<tbody>";

			$languageStrings = $this->system_language_pack_model->getLanguageStrings($moduleId, $stringType, $screen, $language);

			//$moduleArray = array('1' => 'Organization', '2' => 'Stock Manager', '3' => 'Production Manager', '4' => 'HR Manager', '5' => 'Payroll Manager', '6' => 'Service Manager', '7' => 'Accounts Manager', '8' => 'User Role Manager');
            
            $moduleArray = array();
            $allModules = $this->user_model->getAllSystemModules('system_module_id', 'asc');
            
            foreach($allModules as $module) {
                $moduleArray[$module->system_module_id] = $module->system_module;
            }

			if ($languageStrings && sizeof($languageStrings) > 0) {

				foreach ($languageStrings as $row) {
					
					if ($row->system_module_id != '0' && $row->system_module_id != '') {
                        if (array_key_exists($row->system_module_id, $moduleArray)) {
                            $systemModuleName = $moduleArray[$row->system_module_id];
                        }
					} else {
						$systemModuleName = '';
					}
					
                    if (array_key_exists($row->system_module_id, $moduleArray)) {
                        $html .= "<tr>";

                        if ($row->translated_string != '') {
                            $html .= "	<input class='form-control'   id='language_translation_id_" . $row->language_translation_id . "' name='language_translation_id_" . $row->language_translation_id . "' type='hidden' value='{$row->language_translation_id}'>";
                            $html .= "	<input class='form-control'   id='language_string_id_" . $row->language_translation_id . "' name='language_string_id_" . $row->language_translation_id . "' type='hidden' value='{$row->language_string_id}'>";
                        } else {
                            $html .= "	<input class='form-control'   id='language_translation_id_" . $row->language_string_id . "' name='language_translation_id_" . $row->language_string_id . "' type='hidden' value=''>";
                            $html .= "	<input class='form-control'   id='language_string_id_" . $row->language_string_id . "' name='language_string_id_" . $row->language_string_id . "' type='hidden' value='{$row->language_string_id}'>";
                        }

                        $html .= "	<td style='width:10%'>" . $systemModuleName . "</td>";
                        $html .= "	<td style='width:10%'>" . $row->screen_name . "</td>";
                        $html .= "	<td style='width:10%'>" . ucwords(str_replace("_", " ", $row->language_string_type)) . "</td>";
                        $html .= "	<td style='width:20%'>" . $row->language_string . "</td>";

                        if ($row->translated_string != '') {
                            $translation = "<textarea class='form-control' id='translation_edit_" . $row->language_translation_id . "' name='translation_edit_" . $row->language_translation_id . "' placeholder='{$this->lang->line('Translation')}' onblur='editTranslation(this.id);'>{$row->translated_string}</textarea>";
                        } else {
                            $translation = "<textarea class='form-control' id='translation_edit_" . $row->language_string_id . "' name='translation_edit_" . $row->language_string_id . "' placeholder='{$this->lang->line('Translation')}' onblur='editTranslation(this.id);'>{$row->language_string}</textarea>";
                        }

                        $html .= "	<td style='width:50%'>" . $translation . "</td>";
                        $html .= "</tr>";
                    }
				}
			}

			$html .= "				</tbody>
								</table>
							</div>
						</div>
					</div>";

			echo $html;
		}
	}

	public function editTranslation() {

		if(isset($this->data['URM_Product_Info_Edit_Language_Pack_Permissions'])) {

			$languageTranslationId = $this->db->escape_str($this->input->post('language_translation_id'));
			$languageStringId = $this->db->escape_str($this->input->post('language_string_id'));
			$languageName = $this->db->escape_str($this->input->post('language_name'));
			$translatedString = $this->db->escape_str($this->input->post('translated_string'));
			
			$languageString = $this->system_language_pack_model->getLanguageStringByLanguageStringId($languageStringId);
			$productCode = $languageString[0]->product_code;

			if($languageTranslationId != '') {
				$data = array(
					'translated_string' => $translatedString,
					'product_code' => $productCode,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$this->system_language_pack_model->editLanguageTranslation($languageTranslationId, $data);
			} else {
				$data = array(
					'language_string_id' => $languageStringId,
					'language_name' => $languageName,
					'translated_string' => $translatedString,
					'product_code' => $productCode,
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$languageTranslationId = $this->system_language_pack_model->addLanguageTranslation($data);
			}
			
			$languageGenerationStatus = $this->system_language_pack_model->getTranslationGenerationStatus($languageName);
			
			if ($languageGenerationStatus) {
				$data = array(
					'generation_status' => "Pending",
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$this->system_language_pack_model->editTranslationGenerationStatus($languageGenerationStatus[0]->translation_generation_id, $data);
			} else {
				$data = array(
					'language_name' => $languageName,
					'generation_status' => "Pending",
					'actioned_user_id' => $this->user_id,
					'action_date' => $this->date,
					'last_action_status' => 'added'
				);
				
				$this->system_language_pack_model->addTranslationGenerationStatus($data);
			}
			
			echo $languageTranslationId;
		}
	}
	
	public function getScreenListOfSelectedModule() {
		
		$moduleId = $this->db->escape_str($this->input->post('module_id'));
		
		$screenList = $this->system_language_pack_model->getScreenListOfSelectedModule($moduleId);
		
		$this->optionList = '<option value="">All</option>';
		foreach($screenList as $screen) {
			if ($screen->screen_name != '') {
				$this->optionList .= '<option value="' . $screen->screen_name . '">' . $screen->screen_name . '</option>';
			}
		}
		
		echo $this->optionList;
	}
	
	public function getTranslationGenerationStatus() {
		
		$languageName = $this->db->escape_str($this->input->post('language'));
		
		$languageGeneration = $this->system_language_pack_model->getTranslationGenerationStatus($languageName);
		
		$languageGenerationStatus = '';
		if ($languageGeneration) {
			$languageGenerationStatus = $languageGeneration[0]->generation_status;
		}
		
		echo $languageGenerationStatus;
	}
	
	public function generateTranslations() {
		
		$languageName = $this->db->escape_str($this->input->post('language'));

		$languageFile = fopen(dirname(__FILE__) . "/../../../language/" . $languageName . "/form_lang.php", "w+") or die("Unable to open file!");
		
		$content = "<?php \n"
					. "//This language file is auto generated by the system. Do not add language translations to this file manually. Please follow developer guidelines.\n\n";
		
		$displayStrings = $this->system_language_pack_model->getLanguageStrings('', 'display_string', '', $languageName);	
		
		if ($displayStrings && sizeof($displayStrings) > 0) {
			foreach($displayStrings as $languageString) {
				$string = "'" . $languageString->language_string . "'";
				$translation = "'" . $languageString->translated_string . "'";
				
				if ($translation == "''") {
					$translation = $string;
				}
				
				$content .= '$lang[' . $string . '] = ' . $translation . ';';
			}
		}
		
		$productNameStrings = $this->system_language_pack_model->getLanguageStrings('', 'product_name', '', $languageName);	
		
		if ($productNameStrings && sizeof($productNameStrings) > 0) {
			foreach($productNameStrings as $languageString) {
				$string = "'" . $languageString->language_string . "'";
				$translation = "'" . $languageString->translated_string . "'";
				
				if ($translation == "''") {
					$translation = $string;
				}
				
				$content .= '$lang[' . $string . '] = ' . $translation . ';';
			}
		}
		
		fwrite($languageFile, $content);

		$languageFile = fopen(dirname(__FILE__) . "/../../../language/" . $languageName . "/message_lang.php", "w+") or die("Unable to open file!");
		
		$content = "<?php \n"
					. "//This language file is auto generated by the system. Do not add language translations to this file manually. Please follow developer guidelines.\n\n";
		
		$messageStrings = $this->system_language_pack_model->getLanguageStrings('', 'message', '', $languageName);	
		
		if ($messageStrings && sizeof($messageStrings) > 0) {
			foreach($messageStrings as $languageString) {
				$string = "'" . $languageString->language_string . "'";
				$translation = "'" . $languageString->translated_string . "'";
				
				if ($translation == "''") {
					$translation = $string;
				}
				
				$content .= '$lang[' . $string . '] = ' . $translation . ';';
			}
		}
		
		fwrite($languageFile, $content);
		
		$languageGenerationStatus = $this->system_language_pack_model->getTranslationGenerationStatus($languageName);
		
		$data = array(
			'generation_status' => "Completed",
			'actioned_user_id' => $this->user_id,
			'action_date' => $this->date,
			'last_action_status' => 'added'
		);

		$this->system_language_pack_model->editTranslationGenerationStatus($languageGenerationStatus[0]->translation_generation_id, $data);
		
		echo 'ok';
	}
}