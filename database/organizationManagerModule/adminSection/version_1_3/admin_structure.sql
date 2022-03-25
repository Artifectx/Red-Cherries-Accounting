
/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `salutation` varchar(10) DEFAULT '' AFTER `employee_id`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `salutation` varchar(10) DEFAULT '' AFTER `employee_id`;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `epf_no` varchar(100) DEFAULT '' AFTER `guardian_telephone_number`,
    ADD COLUMN `branch_id` int(11) DEFAULT '0' AFTER `epf_no`,
    ADD COLUMN `center_id` int(11) DEFAULT '0' AFTER `branch_id`,
    ADD COLUMN `group_id` int(11) DEFAULT '0' AFTER `center_id`,
    ADD COLUMN `husband_full_name` varchar(255) DEFAULT '' AFTER `group_id`,
    ADD COLUMN `husband_mobile_no` varchar(25) DEFAULT '' AFTER `husband_full_name`,
    ADD COLUMN `business_category` varchar(10) DEFAULT '' AFTER `husband_mobile_no`,
    ADD COLUMN `business_name` varchar(255) DEFAULT '' AFTER `business_category`,
    ADD COLUMN `business_address` varchar(255) DEFAULT '' AFTER `business_name`,
    ADD COLUMN `working_place` varchar(255) DEFAULT '' AFTER `business_address`,
    ADD COLUMN `job_position` varchar(100) DEFAULT '' AFTER `working_place`,
    ADD COLUMN `working_place_address` varchar(255) DEFAULT '' AFTER `job_position`,
    ADD COLUMN `co_borrower_full_name` varchar(255) DEFAULT '' AFTER `working_place_address`,
    ADD COLUMN `co_borrower_nic` varchar(25) DEFAULT '' AFTER `co_borrower_full_name`,
    ADD COLUMN `co_borrower_birthday` date DEFAULT '0000-00-00' AFTER `co_borrower_nic`,
    ADD COLUMN `co_borrower_phone_no` varchar(25) DEFAULT '' AFTER `co_borrower_birthday`,
    ADD COLUMN `co_borrower_relationship` varchar(15) DEFAULT '' AFTER `co_borrower_phone_no`,
    ADD COLUMN `co_borrower_address` varchar(255) DEFAULT '' AFTER `co_borrower_relationship`,
    ADD COLUMN `bank_id` int(11) DEFAULT '0' AFTER `co_borrower_address`,
    ADD COLUMN `bank_branch_id` int(11) DEFAULT '0' AFTER `bank_id`,
    ADD COLUMN `bank_account_no` varchar(100) DEFAULT '' AFTER `bank_branch_id`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `epf_no` varchar(100) DEFAULT '' AFTER `guardian_telephone_number`,
    ADD COLUMN `branch_id` int(11) DEFAULT '0' AFTER `epf_no`,
    ADD COLUMN `center_id` int(11) DEFAULT '0' AFTER `branch_id`,
    ADD COLUMN `group_id` int(11) DEFAULT '0' AFTER `center_id`,
    ADD COLUMN `husband_full_name` varchar(255) DEFAULT '' AFTER `group_id`,
    ADD COLUMN `husband_mobile_no` varchar(25) DEFAULT '' AFTER `husband_full_name`,
    ADD COLUMN `business_category` varchar(10) DEFAULT '' AFTER `husband_mobile_no`,
    ADD COLUMN `business_name` varchar(255) DEFAULT '' AFTER `business_category`,
    ADD COLUMN `business_address` varchar(255) DEFAULT '' AFTER `business_name`,
    ADD COLUMN `working_place` varchar(255) DEFAULT '' AFTER `business_address`,
    ADD COLUMN `job_position` varchar(100) DEFAULT '' AFTER `working_place`,
    ADD COLUMN `working_place_address` varchar(255) DEFAULT '' AFTER `job_position`,
    ADD COLUMN `co_borrower_full_name` varchar(255) DEFAULT '' AFTER `working_place_address`,
    ADD COLUMN `co_borrower_nic` varchar(25) DEFAULT '' AFTER `co_borrower_full_name`,
    ADD COLUMN `co_borrower_birthday` date DEFAULT '0000-00-00' AFTER `co_borrower_nic`,
    ADD COLUMN `co_borrower_phone_no` varchar(25) DEFAULT '' AFTER `co_borrower_birthday`,
    ADD COLUMN `co_borrower_relationship` varchar(15) DEFAULT '' AFTER `co_borrower_phone_no`,
    ADD COLUMN `co_borrower_address` varchar(255) DEFAULT '' AFTER `co_borrower_relationship`,
    ADD COLUMN `bank_id` int(11) DEFAULT '0' AFTER `co_borrower_address`,
    ADD COLUMN `bank_branch_id` int(11) DEFAULT '0' AFTER `bank_id`,
    ADD COLUMN `bank_account_no` varchar(100) DEFAULT '' AFTER `bank_branch_id`;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `operating_currency` int(11) DEFAULT '0' AFTER `bank_account_no`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `operating_currency` int(11) DEFAULT '0' AFTER `bank_account_no`;