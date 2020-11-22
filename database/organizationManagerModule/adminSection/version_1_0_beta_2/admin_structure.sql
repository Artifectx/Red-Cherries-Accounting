
/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `surname` varchar(255) DEFAULT '' AFTER `employee_id`,
    ADD COLUMN `initials` varchar(25) DEFAULT '' AFTER `surname`,
    ADD COLUMN `works_for_welfare_shops` varchar(10) DEFAULT 'No' AFTER `current_sales_credit_amount`;

/*Table structure for table `ogm_admin_people_welfare_companies` */
DROP TABLE IF EXISTS `ogm_admin_people_welfare_companies`;

CREATE TABLE `ogm_admin_people_welfare_companies` (
  `people_welfare_company_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `welfare_company_id` int(11) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`people_welfare_company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_external_institutes` */
DROP TABLE IF EXISTS `ogm_admin_external_institutes`;

CREATE TABLE `ogm_admin_external_institutes` (
  `external_institute_id` int(11) NOT NULL AUTO_INCREMENT,
  `external_institute_code` varchar(255) NOT NULL,
  `external_institute_name` text NOT NULL,
  `registered_date` date DEFAULT NULL,
  `institute_type` varchar(100) NOT NULL,
  `service_method` varchar(100) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `service_status` varchar(100) NOT NULL,
  `head_of_the_institute` varchar(255) DEFAULT NULL,
  `institute_address` text DEFAULT NULL,
  `institute_contact_no_country_code` varchar(10) DEFAULT NULL,
  `institute_contact_no` varchar(25) DEFAULT NULL,
  `radiation_protection_officer` varchar(255) DEFAULT NULL,
  `rpo_contact_no_country_code` varchar(10) DEFAULT NULL,
  `rpo_contact_no` varchar(25) DEFAULT NULL,
  `tld_distribution_address` text DEFAULT NULL,
  `invoice_person_name` varchar(255) DEFAULT NULL,
  `invoice_person_address` text DEFAULT NULL,
  `invoice_person_contact_no_country_code` varchar(10) DEFAULT NULL,
  `invoice_person_contact_no` varchar(25) DEFAULT NULL,
  `distribution_frequency` varchar(100) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`external_institute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_external_institutes_history` */
DROP TABLE IF EXISTS `ogm_admin_external_institutes_history`;

CREATE TABLE `ogm_admin_external_institutes_history` (
  `external_institute_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `external_institute_id` int(11) NOT NULL,
  `external_institute_code` varchar(255) NOT NULL,
  `external_institute_name` text NOT NULL,
  `registered_date` date DEFAULT NULL,
  `institute_type` varchar(100) NOT NULL,
  `service_method` varchar(100) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `service_status` varchar(100) NOT NULL,
  `head_of_the_institute` varchar(255) DEFAULT NULL,
  `institute_address` text DEFAULT NULL,
  `institute_contact_no_country_code` varchar(10) DEFAULT NULL,
  `institute_contact_no` varchar(25) DEFAULT NULL,
  `radiation_protection_officer` varchar(255) DEFAULT NULL,
  `rpo_contact_no_country_code` varchar(10) DEFAULT NULL,
  `rpo_contact_no` varchar(25) DEFAULT NULL,
  `tld_distribution_address` text DEFAULT NULL,
  `invoice_person_name` varchar(255) DEFAULT NULL,
  `invoice_person_address` text DEFAULT NULL,
  `invoice_person_contact_no_country_code` varchar(10) DEFAULT NULL,
  `invoice_person_contact_no` varchar(25) DEFAULT NULL,
  `distribution_frequency` varchar(100) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`external_institute_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `job_title` varchar(255) DEFAULT '' AFTER `nic`,
    ADD COLUMN `single_tld_requested` varchar(10) DEFAULT 'No' AFTER `job_title`,
    ADD COLUMN `two_tld_requested` varchar(10) DEFAULT 'No' AFTER `single_tld_requested`,
    ADD COLUMN `field_extremity_ring_requested` varchar(10) DEFAULT 'No' AFTER `two_tld_requested`,
    ADD COLUMN `field_extremity_eye_requested` varchar(10) DEFAULT 'No' AFTER `field_extremity_ring_requested`,
    ADD COLUMN `external_institute_id` int(11) DEFAULT '0' AFTER `immediate_contact_telephone_number`,
    ADD COLUMN `worker_registered_date` date DEFAULT NULL AFTER `external_institute_id`,
    ADD COLUMN `worker_terminated_date` date DEFAULT NULL AFTER `worker_registered_date`;

/*Table structure for table `ogm_admin_people_history` */
DROP TABLE IF EXISTS `ogm_admin_people_history`;

CREATE TABLE `ogm_admin_people_history` (
  `people_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `people_category` varchar(100) DEFAULT NULL,
  `people_code` varchar(100) NOT NULL,
  `employee_id` int(11) DEFAULT '0',
  `surname` varchar(255) DEFAULT '',
  `initials` varchar(25) DEFAULT '',
  `people_name` varchar(255) DEFAULT NULL,
  `people_short_name` varchar(255) DEFAULT '',
  `is_also_a_sales_rep` varchar(10) DEFAULT 'No',
  `sales_rep_id` int(11) DEFAULT '0',
  `is_also_a_cashier` varchar(10) DEFAULT 'No',
  `cashier_id` int(11) DEFAULT '0',
  `nic` varchar(25) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT '',
  `single_tld_requested` varchar(10) DEFAULT 'No',
  `two_tld_requested` varchar(10) DEFAULT 'No',
  `field_extremity_ring_requested` varchar(10) DEFAULT 'No',
  `field_extremity_eye_requested` varchar(10) DEFAULT 'No',
  `birth_day` date DEFAULT NULL,
  `country_id` char(2) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `welfare_company_id` int(11) DEFAULT '0',
  `welfare_company_department_id` int(11) DEFAULT '0',
  `welfare_company_job_category_id` int(11) DEFAULT '0',
  `purchasing_credit_limit_of_employee` decimal(20,2) DEFAULT '0.00',
  `cashier_cash_varience` decimal(20,2) DEFAULT '0.00',
  `sales_credit_limit` decimal(20,2) DEFAULT '0.00',
  `current_sales_credit_amount` decimal(20,2) DEFAULT '0.00',
  `works_for_welfare_shops` varchar(10) DEFAULT 'No',
  `vehicle_id` int(11) DEFAULT NULL,
  `people_address` varchar(255) DEFAULT NULL,
  `people_ptn_country_code` varchar(10) DEFAULT NULL,
  `people_primary_telephone_number` varchar(25) DEFAULT NULL,
  `people_stn_country_code` varchar(10) DEFAULT NULL,
  `people_secondory_telephone_number` varchar(25) DEFAULT NULL,
  `people_email` varchar(255) DEFAULT NULL,
  `people_fax_country_code` varchar(10) DEFAULT NULL,
  `people_fax_no` varchar(255) DEFAULT NULL,
  `tax_number` varchar(100) DEFAULT '',
  `delivery_route_id` varchar(100) DEFAULT '0',
  `people_type` varchar(100) DEFAULT NULL,
  `login_status` int(2) DEFAULT NULL,
  `immediate_contact_person` varchar(255) DEFAULT '',
  `immediate_contact_telephone_number` varchar(25) DEFAULT '',
  `external_institute_id` int(11) DEFAULT '0',
  `worker_registered_date` date DEFAULT NULL,
  `worker_terminated_date` date DEFAULT NULL,
  `authorized` varchar(50) DEFAULT 'Yes',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`people_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
