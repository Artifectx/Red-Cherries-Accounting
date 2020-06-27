<?php
class Common_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$session_data = $this->session->userdata('logged_in_stock');
		$this->user_id = $session_data['user_id'];
	}

	public function getNationalityList($order_field,$order_type) {
		$this->db->order_by($order_field, $order_type);
		$query = $this->db->get('hrm_admin_nationality');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getNationalityDropDown() {
		$data=$this->getNationalityList('name','asc');

		foreach($data as $dataElement) {
			$nationalityList[$dataElement->nationality_id] = $dataElement->name;
		}

		$this->optionList = '<option value="0">' . $this->lang->line('-- Select --'). '</option>';

		foreach($nationalityList as $key => $nationality) {
			$this->optionList .= '<option value=' . $key . '>' . $nationality . '</option>';
		}

		$html = "<div class='col-sm-6 controls'>
					<label class='control-label col-sm-4'>{$this->lang->line('Nationality')}</label>
					<div class='col-sm-8 controls'>
						<select class='select2 form-control' id='nationality'>
							{$this->optionList}
						</select>
					</div>
				</div>";

		echo $html;
	}

	public function prepareNationalityList($nationality) {
		$data=$this->getNationalityList('name','asc');

		foreach($data as $dataElement) {
			$nationalityList[$dataElement->nationality_id] = $dataElement->name;
		}

		$this->optionList = '<option value="0">' . $this->lang->line('-- Select --'). '</option>';

		foreach($nationalityList as $key => $name) {
			if ($key == $nationality) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $name . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $name . '</option>';
			}
		}

		return $this->optionList;
	}


	public function getCountryList($order_field, $order_type) {
		$this->db->order_by($order_field, $order_type);
		$query = $this->db->get('system_country');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCountryByName($countryName) {
		$this->db->where('country_name', $countryName);
		$this->db->limit(1);
		$query = $this->db->get('system_country');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getCountryByCode($countryCode) {
		$this->db->where('country_code', $countryCode);
		$this->db->limit(1);
		$query = $this->db->get('system_country');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getNationalityById($nationalityId) {
		$this->db->where('nationality_id', $nationalityId);
		$this->db->limit(1);
		$query = $this->db->get('hrm_admin_nationality');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getCountryAsOptionList() {
		$data = $this->getCountryList('name', 'asc');

		$countryList = array('0' => $this->lang->line('-- Select --'));

		if ($data != null) {
			foreach($data as $dataElement) {
				$countryList[$dataElement->country_code] = $dataElement->country_name;
			}
		}

		$this->optionList = '';

		foreach($countryList as $key => $country) {
			$this->optionList .= '<option value=' . $key . '>' . $country . '</option>';
		}

		$optionList = $this->optionList;

		return $optionList;
	}
	
	public function getCountryDropDown() {
		$data=$this->getCountryList('name','asc');

		foreach($data as $dataElement) {
			$countryList[$dataElement->country_code] = $dataElement->country_name;
		}

		$this->optionList = '<option value="0">' . $this->lang->line('-- Select --'). '</option>';

		foreach($countryList as $key => $country) {
			$this->optionList .= '<option value=' . $key . '>' . $country . '</option>';
		}

		$html = "<select class='select2 form-control' id='country_id'>
					{$this->optionList}
				 </select>";

		echo $html;
	}

	public function getCountryDropDownWithSavedOption($selectedIndex) {
		$data=$this->getCountryList('name','asc');

		foreach($data as $dataElement) {
			$countryList[$dataElement->country_code] = $dataElement->country_name;
		}

		$this->optionList = '<option value="0">' . $this->lang->line('-- Select --'). '</option>';

		foreach($countryList as $key => $country) {
			$this->optionList .= '<option value=' . $key . '>' . $country . '</option>';
		}

		foreach($countryList as $key => $country) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $country . '</option>';
			} else {
				$this->optionList .= '<option value=' . $key . '>' . $country . '</option>';
			}
		}

		return $this->optionList;
	}

	public function getSelectedCountryList($selectedIndex){
		$data=$this->getCountryList('name','asc');

		foreach($data as $dataElement) {
			$countryList[$dataElement->country_code] = $dataElement->country_name;
		}

		$this->optionList = '';
		//print_r($countryList);die();
		$this->optionList .= '<option value="">' . $this->lang->line("-- Select Country --") . '</option>';
		foreach($countryList as $key => $country) {
			if($key == $selectedIndex) {
				$this->optionList .= '<option value=' . $key . ' selected="selected">' . $country . '</option>';
			}else {
				$this->optionList .= '<option value=' . $key . '>' . $country . '</option>';
			}

		}
		return $this->optionList;
	}

	/* public function getWebSettings($id) {
		 $this->db->where('id', $id);
		 $this->db->limit(1);
		 $query = $this->db->get('system_common_web_settings');
		 if ($query->num_rows() == 1) {
			 return $query->result();
		 } else {
			 return false;
		 }
	 }*/

	public function getWebSettings($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->select('main_nav_btn');
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function chanageNavOption($id,$data){
		$this->db->where('user_id', $id);
		$this->db->set('main_nav_btn', $data);
		$this->db->update('urm_user_roles_user');
		$this->db->limit(1);
		return true;
	}

	public function getSerialNumberList($addedFrom, $referenceNo, $productId) {
		$this->db->where('added_from', $addedFrom);
		$this->db->where('reference_no', $referenceNo);
		$this->db->where('product_id', $productId);
		$this->db->limit(10000);
		$query = $this->db->get('stm_fg_product_warehouse_serial_numbers');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getSystemModulesHeaderTitle($userId=null){
		if ($userId == '') {
			$this->db->where('user_id', $this->user_id);
		} else {
			$this->db->where('user_id', $userId);
		}
		$query = $this->db->get('system_common_web_settings');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function addSystemModulesHeaderTitle($data){
		$this->db->insert('system_common_web_settings', $data);
		$this->db->limit(1);
		return true;
	}

	public function setSystemModulesHeaderTitle($user_id, $data) {
		$this->db->where('user_id', $user_id);
		$this->db->update('system_common_web_settings', $data);
		$this->db->limit(1);
		return true;
	}
	
	public function getSystemSubModule($subModuleId=null){
		$this->db->where('system_sub_module_id', $subModuleId);
		$query = $this->db->get('system_sub_modules');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getSystemModuleById($moduleId=null){
		$this->db->where('system_module_id', $moduleId);
		$query = $this->db->get('system_modules');
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}