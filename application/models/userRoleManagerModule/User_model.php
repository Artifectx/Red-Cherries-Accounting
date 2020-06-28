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

class User_model extends CI_model {

	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		$this->db->insert('urm_user_roles_user', $data);
		$this->db->limit(1);
		return $this->db->insert_id();
	}
	
	public function addAccessibleWarehouse($data) {
		$this->db->insert('urm_user_roles_user_accessible_warehouses', $data);
		$this->db->limit(1);
		$this->db->insert_id();
	}
	
	public function addNotAccessiblePrimeEntryBook($data) {
		$this->db->insert('urm_user_roles_user_not_accessible_prime_entry_books', $data);
		$this->db->limit(1);
		$this->db->insert_id();
	}

	public function edit($id, $data) {
		$this->db->where('user_id', $id);
		$this->db->update('urm_user_roles_user', $data);
		$this->db->limit(1);
		return true;
	}

	public function delete($id, $status) {
		$this->db->where('user_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->update('urm_user_roles_user');

		$this->db->limit(1);
		return true;
	}
	
	public function deleteAccessibleWarehouse($id) {
		$this->db->where('user_id', $id);
		$this->db->delete('urm_user_roles_user_accessible_warehouses');

		return true;
	}
	
	public function deleteNotAccessiblePrimeEntryBook($id) {
		$this->db->where('user_id', $id);
		$this->db->delete('urm_user_roles_user_not_accessible_prime_entry_books');

		return true;
	}

	public function disableUser($code) {
		$this->db->where('people_id', $code);
		$this->db->set('status', 0);
		$this->db->update('urm_user_roles_user');
		$this->db->limit(1);
		return true;
	}

	public function login($userName) {
		$this -> db -> where('user_name', $userName);
		$this -> db -> where('status', 1);
		$this -> db -> limit(1);
		$query = $this -> db -> get('urm_user_roles_user');

		if($query -> num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_pass($userName) {
		$this -> db -> where('user_name', $userName);
		$this -> db -> where('last_action_status!=', "deleted");
		$this -> db -> limit(1);
		$query = $this -> db -> get('urm_user_roles_user');

		if($query -> num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getUserTheme($id) {
		$this->db->where('user_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function setUserTheme($id, $data) {
		$this->db->where('user_id', $id);
		$this->db->set('theme', $data);
		$this->db->update('urm_user_roles_user');
		$this->db->limit(1);
	}

	public function getUserLanguage($id) {
		$this->db->where('user_id', $id);
		$this->db->limit(1);
		$query = $this->db->select('language');
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function setUserLanguage($id, $data) {
		$this->db->where('user_id', $id);
		$this->db->set('language', $data);
		$this->db->update('urm_user_roles_user');
		$this->db->limit(1);
	}

	public function addUserRole($data) {
		$this->db->insert('urm_user_roles_user_roles', $data);
		$this->db->limit(1);
		return true;
	}

	public function getUserByUserName($userName) {
		$this->db->where('user_name', $userName);
		$this->db->where('urm_user_roles_user.last_action_status !=', 'deleted');
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getUserByPeopleId($peopleId) {
		$this->db->where('people_id', $peopleId);
		$this->db->where('urm_user_roles_user.last_action_status !=', 'deleted');
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getUserRole($id) {
		$this->db->where('user_id', $id);
		$this->db->join('urm_user_roles_user','urm_user_roles_user.role_id=urm_user_roles_user_roles.role_id');
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user_roles');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getUserPermission($roleId, $permissionId=null) {
		$this->db->where('role_id', $roleId);
		if($permissionId) {
			$this->db->where('urm_user_roles_default_user_role_permissions.permission_id',$permissionId);
		}
		$this->db->join('urm_user_roles_permissions','urm_user_roles_default_user_role_permissions.permission_id=urm_user_roles_permissions.permission_id');
		$query = $this->db->get('urm_user_roles_default_user_role_permissions');

		if ($query->num_rows() >0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getDeriveUserRolePermission($deriveUserRoleId, $permissionId=null) {
		$this->db->where('derive_user_role_id', $deriveUserRoleId);
		if($permissionId) {
			$this->db->where('urm_user_roles_derive_user_role_permissions.permission_id',$permissionId);
		}
		$this->db->join('urm_user_roles_permissions','urm_user_roles_derive_user_role_permissions.permission_id=urm_user_roles_permissions.permission_id');
		$query = $this->db->get('urm_user_roles_derive_user_role_permissions');

		if ($query->num_rows() >0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function changePassword($id, $newPass, $salt) {
		$this->db->where('user_id', $id);
		$this->db->set('user_password', $newPass);
		$this->db->set('salt', $salt);
		$this->db->update('urm_user_roles_user');
		$this->db->limit(1);
	}


	public function getUserLanguageUsername($userName) {
		$this->db->where('user_name', $userName);
		$this->db->limit(1);
		$query = $this->db->select('language');
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getUserById($id) {
		$this->db->where('urm_user_roles_user.last_action_status !=', 'deleted');
		$this->db->where('user_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getById($id) {
		$this->db->join('ogm_admin_people', 'ogm_admin_people.people_id=urm_user_roles_user.people_id',"LEFT");
		//$this->db->join('urm_user_roles_user_roles','urm_user_roles_user_roles.role_id=urm_user_roles_user.role_id',"LEFT");
		//$this->db->join('urm_user_roles_derive_user_roles','urm_user_roles_derive_user_roles.derive_user_role_id=urm_user_roles_user.derive_user_role_id',"LEFT");
		$this->db->where('urm_user_roles_user.last_action_status !=', 'deleted');
		$this->db->where('user_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function checkExisting($peopleId) {
		$this->db->where('people_id', $peopleId);
		$this->db->where('last_action_status !=', 'deleted');
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	//------------user roles-----------------------------------

	public function getAllUserRoles($orderField, $orderType) {
		$this->db->order_by($orderField, $orderType);
		$this->db->where('last_action_status !=', 'deleted');
		$this->db->where('user_role_name !=', 'Super Admin');
		$query = $this->db->get('urm_user_roles_user_roles');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	//--------------derive user roles-----------------------------------------------------------------------------------

	public function addDeriveUserRoles($data) {
		$this->db->insert('urm_user_roles_derive_user_roles', $data);
		$this->db->limit(1);

		return true;
	}

	public function editDeriveUserRoles($id, $data) {
		$this->db->where('derive_user_role_id', $id);
		$this->db->update('urm_user_roles_derive_user_roles', $data);
		$this->db->limit(1);

		return true;
	}

	public function deleteDeriveUserRoles($id, $status) {
		$this->db->where('derive_user_role_id', $id);
		$this->db->set('last_action_status', $status);
		$this->db->update('urm_user_roles_derive_user_roles');
		$this->db->limit(1);

		return true;
	}

	public function getAllDeriveUserRolesData($orderField, $orderType) {
		$this->db->order_by('urm_user_roles_derive_user_roles.'.$orderField, $orderType);
		$this->db->join('urm_user_roles_user_roles','urm_user_roles_user_roles.role_id=urm_user_roles_derive_user_roles.role_id');
		$this->db->where('urm_user_roles_derive_user_roles.last_action_status !=', 'deleted');
		$query = $this->db->get('urm_user_roles_derive_user_roles');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getByIdDeriveUserRoles($id) {
		$this->db->where('urm_user_roles_derive_user_roles.derive_user_role_id', $id);
		$this->db->join('urm_user_roles_user_roles','urm_user_roles_user_roles.role_id=urm_user_roles_derive_user_roles.role_id');
		$this->db->limit(1);
		$query = $this->db->get('urm_user_roles_derive_user_roles');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	//--------------module sections----------------------------------------------------------------------------------------

	public function addModuleSection($data) {
		$this->db->insert('system_module_sections', $data);
		$this->db->limit(1);

		return $this->db->insert_id();
	}

	public function editModuleSection($id, $data) {
		$this->db->where('module_section_id', $id);
		$this->db->update('system_module_sections', $data);
		$this->db->limit(1);

		return true;
	}

	public function deleteModuleSection($id) {
		// $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('module_section_id', $id);
		$this->db->delete('system_module_sections');
		$this->db->limit(1);
		// $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
		return true;
	}

	public function changeStatus($moduleSectionId, $moduleSectionStatus) {
		$this->db->where('module_section_id', $moduleSectionId);
		$this->db->set('module_section_status', $moduleSectionStatus);
		$this->db->update('system_module_sections');
		$this->db->limit(1);

		return true;
	}

	public function getAllModuleSections($orderField, $orderType) {
		$this->db->order_by($orderField, $orderType);
		$this->db->join('system_modules','system_module_sections.system_module_id=system_modules.system_module_id');
		$this->db->limit(100);
		$query = $this->db->get('system_module_sections');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllModuleSectionsBySystemModuleName($systemModuleName, $orderField, $orderType) {
		$this->db->order_by($orderField, $orderType);
		$this->db->join('system_modules','system_module_sections.system_module_id=system_modules.system_module_id');
		$this->db->where('system_module', $systemModuleName);
		$this->db->limit(100);
		$query = $this->db->get('system_module_sections');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAllSubModuleSectionsBySystemModuleName($systemModuleName, $systemSubModuleName, $orderField, $orderType) {
		$this->db->order_by($orderField, $orderType);
		$this->db->join('system_modules','system_module_sections.system_module_id=system_modules.system_module_id');
		$this->db->join('system_sub_modules','system_module_sections.system_sub_module_id=system_sub_modules.system_sub_module_id');
		$this->db->where('system_module', $systemModuleName);
		$this->db->where('system_sub_module', $systemSubModuleName);
		$this->db->limit(100);
		$query = $this->db->get('system_module_sections');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getModuleSectionById($id) {
		$this->db->where('module_section_id', $id);
		$this->db->limit(1);
		$query = $this->db->get('system_module_sections');

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	//--------------module section features---------------------------------------------------------------------------------------------

	public function addModuleSectionFeature($data) {
		$this->db->insert('system_module_section_features', $data);
		$this->db->limit(1);

		return $this->db->insert_id();
	}

	public function editModuleSectionFeature($id, $data) {
		$this->db->where('module_section_id', $id);
		$this->db->update('system_module_section_features', $data);
		$this->db->limit(1);

		return true;
	}

	public function deleteModuleSectionFeature($id) {
		$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('module_section_id', $id);
		$this->db->delete('system_module_section_features');
		$this->db->limit(1);
		$this->db->query("SET FOREIGN_KEY_CHECKS = 1");

		return true;
	}

//    public function getModuleSectionFeaturesByModuleSectionId($id) {
//        $this->db->join('system_module_sections', 'system_module_sections.module_section_id=system_module_section_features.module_section_id');
//        $this->db->where('module_section_id', $id);
//        $this->db->limit(1);
//        $query = $this->db->get('system_module_section_features');
//        
//        if ($query->num_rows() == 1) {
//            return $query->result();
//        } else {
//            return false;
//        }
//    }

	public function getAllModuleSectionFeatures($orderField, $orderType) {
		$this->db->order_by($orderField, $orderType);
		$this->db->join('system_module_sections', 'system_module_sections.module_section_id=system_module_section_features.module_section_id');
		$query = $this->db->get('system_module_section_features');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getModuleSectionFeaturesByModuleSectionId($id) {
		$this->db->join('system_module_sections', 'system_module_sections.module_section_id=system_module_section_features.module_section_id', 'LEFT');
		$this->db->where('system_module_section_features.module_section_id', $id);
		$query = $this->db->get('system_module_section_features');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	//-------------admin permissions--------------------------------------------------------------------------

	public function addAdminPermissions($data) {
		$this->db->insert('urm_user_roles_permissions', $data);
		$this->db->limit(1);

		return true;
	}

	public function deleteAdminPermissions($id) {
		$this->db->where('module_section_id', $id);
		$this->db->delete('urm_user_roles_permissions');

		return true;
	}

	public function getAllAdminPermissions($orderField, $orderType) {
		$this->db->order_by($orderField, $orderType);
		$this->db->join('system_module_section_features', 'system_module_section_features.module_section_id=urm_user_roles_permissions.module_section_id');
		$this->db->join('system_module_sections', 'system_module_sections.module_section_id=system_module_section_features.module_section_id');
		$this->db->where('urm_user_roles_permissions.last_action_status !=', 'deleted');
		$query = $this->db->get('urm_user_roles_permissions');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getPermissionsByModuleSectionFeatureId($id) {
		$this->db->join('system_module_section_features', 'system_module_section_features.module_section_feature_id=urm_user_roles_permissions.module_section_feature_id');
		$this->db->where('urm_user_roles_permissions.module_section_feature_id', $id);
		$query = $this->db->get('urm_user_roles_permissions');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getPermissionByPermissionId($id) {
		$this->db->where('permission_id', $id);
		$query = $this->db->get('urm_user_roles_permissions');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	//-------------admin derive user role permissions--------------------------------------------------------------------------

	public function getDeriveUserRolePermissions($deriveUserRoleId, $permission_id=null) {
		$this->db->where('derive_user_role_id', $deriveUserRoleId);
        
		if($permission_id) {
			$this->db->where('urm_user_roles_derive_user_role_permissions.permission_id', $permission_id);
		}
        
		$this->db->join('urm_user_roles_permissions', 'urm_user_roles_derive_user_role_permissions.permission_id=urm_user_roles_permissions.permission_id');
		$query = $this->db->get('urm_user_roles_derive_user_role_permissions');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getDeriveUserRolePermissionsByModuleSectionId($deriveUserRoleId, $module_section_id) {
		$this->db->where('derive_user_role_id', $deriveUserRoleId);
		$this->db->where('system_module_section_features.module_section_id', $module_section_id);
		$this->db->join('urm_user_roles_permissions', 'urm_user_roles_derive_user_role_permissions.permission_id=urm_user_roles_permissions.permission_id');
		$this->db->join('system_module_section_features', 'system_module_section_features.module_section_feature_id=urm_user_roles_permissions.module_section_feature_id');
		$query = $this->db->get('urm_user_roles_derive_user_role_permissions');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function addDeriveUserRolePermission($data) {
		$this->db->insert('urm_user_roles_derive_user_role_permissions', $data);
		$this->db->limit(1);
		return true;
	}

	public function deleteDeriveUserRolePermission($deriveUserRoleId) {
		#Create where clause
		$this->db->select('permission_id');
		$this->db->from('urm_user_roles_permissions');
		$this->db->where('urm_user_roles_permissions.permission_type = ', "Advanced");
		$whereClause = $this->db->get_compiled_select();

		#Create main query
		$this->db->where('derive_user_role_id', $deriveUserRoleId); 
		$this->db->where("`permission_id` NOT IN ($whereClause)", NULL, FALSE);
		$this->db->delete('urm_user_roles_derive_user_role_permissions'); 

		return true;
	}

	public function deleteDeriveUserRoleSinglePermission($deriveUserRoleId, $permissionId) {
		$this->db->where('derive_user_role_id', $deriveUserRoleId);
		$this->db->where('permission_id', $permissionId);
		$this->db->delete('urm_user_roles_derive_user_role_permissions');

		return true;
	}

	public function check_email($email) {
		$this->db->join('ogm_admin_people', 'ogm_admin_people.people_id=urm_user_roles_user.people_id','LEFT');
		$this->db->where('email', $email);
		$this -> db -> where('status', 1);
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	//---------------Users--------------------------

	public function getAll($orderField, $orderType) {
		$this->db->order_by($orderField, $orderType);
		$this->db->join('ogm_admin_people', 'ogm_admin_people.people_id=urm_user_roles_user.people_id','LEFT');
		$this->db->join('urm_user_roles_user_roles', 'urm_user_roles_user_roles.role_id=urm_user_roles_user.role_id','LEFT');
		$this->db->join('urm_user_roles_derive_user_roles', 'urm_user_roles_derive_user_roles.derive_user_role_id=urm_user_roles_user.derive_user_role_id','LEFT');
		//$this->db->where('people_type', 'Employee');
		//$this -> db -> where('status', 1);
		$this->db->where('urm_user_roles_user.last_action_status !=', 'deleted');
		$query = $this->db->get('urm_user_roles_user');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getSystemVersionNumber() {
		$this->db->where('config_filed_name', 'red_cherries_os_version_number');
		$query = $this->db->get('system_common_configurations');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	//System module
	public function getAllSystemModules($orderField, $orderType){
		$this->db->order_by('system_modules.'.$orderField, $orderType);
		$this->db->where('system_modules_status !=', '0');
		$this->db->limit(1000);
		$query = $this->db->get('system_modules');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	//System sub module
	public function getAllSystemSubModules($orderField, $orderType, $system_module_id){
		$this->db->order_by($orderField, $orderType);
		$this->db->where('system_sub_modules_status !=', '0');
		$this->db->where('system_module_id', $system_module_id);
		$this->db->limit(1000);
		$query = $this->db->get('system_sub_modules');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getModuleSectionBySystemModuleId($id) {
		$this->db->join('system_modules', 'system_module_sections.system_module_id=system_modules.system_module_id', 'LEFT');
		$this->db->where('system_module_sections.system_module_id', $id);
		$query = $this->db->get('system_module_sections');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function setUserDefaultSystemModule($id, $data) {
		$this->db->where('user_id', $id);
		$this->db->update('urm_user_roles_user', $data);
		$this->db->limit(1);
		return true;
	}

	public function getUserDefaultSystemModule($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->get('urm_user_roles_user');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getAdvancedPermissionsForAPermission($permissionId) {
		$this->db->where('permission_id', $permissionId);
		$query = $this->db->get('urm_user_roles_permissions_advanced');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getAccessibleWarehousesOfAUser($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->get('urm_user_roles_user_accessible_warehouses');

		if ($query->num_rows() > 0) {
			$selectedWarehouses = $query->result();
			
			$accessibleWarehouses = array();
			foreach ($selectedWarehouses as $selectedWarehouse) {
				$accessibleWarehouses[] = $selectedWarehouse->warehouse_id;
			}
			
			return $accessibleWarehouses;
		} else {
			return false;
		}
	}
	
	public function getNotAccessiblePrimeEntryBooksOfAUser($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->get('urm_user_roles_user_not_accessible_prime_entry_books');

		if ($query->num_rows() > 0) {
			$selectedPrimeEntryBooks = $query->result();
			
			$notAccessiblePrimeEntryBooks = array();
			foreach ($selectedPrimeEntryBooks as $selectedPrimeEntryBook) {
				$notAccessiblePrimeEntryBooks[] = $selectedPrimeEntryBook->prime_entry_book_id;
			}
			
			return $notAccessiblePrimeEntryBooks;
		} else {
			return false;
		}
	}
}
