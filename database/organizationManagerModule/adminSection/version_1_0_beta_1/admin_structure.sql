
/*Table structure for table ogm_admin_locations*/
DROP TABLE IF EXISTS `ogm_admin_locations`;

CREATE TABLE `ogm_admin_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(255) NOT NULL,
  `location_name` text NOT NULL,
  `company_id` int(11) DEFAULT '0',
  `country_id` char(2) DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `state` text,
  `city` text,
  `address` text,
  `ptn_country_code` varchar(10) DEFAULT NULL,
  `primary_telephone_number` varchar(25) DEFAULT NULL,
  `stn_country_code` varchar(10) DEFAULT NULL,
  `secondary_telephone_number` varchar(25) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(255) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table ogm_admin_people*/
DROP TABLE IF EXISTS `ogm_admin_people`;

CREATE TABLE `ogm_admin_people` (
  `people_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_category` varchar(100) DEFAULT NULL,
  `people_code` varchar(100) NOT NULL,
  `employee_id` int(11) DEFAULT '0',
  `people_name` varchar(255) NOT NULL,
  `people_short_name` varchar(255) DEFAULT '',
  `nic` varchar(25) DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `country_id` char(2) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `people_address` varchar(255) DEFAULT NULL,
  `people_ptn_country_code` varchar(10) DEFAULT NULL,
  `people_primary_telephone_number` varchar(25) DEFAULT NULL,
  `people_stn_country_code` varchar(10) DEFAULT NULL,
  `people_secondory_telephone_number` varchar(25) DEFAULT NULL,
  `people_email` varchar(255) DEFAULT NULL,
  `people_fax_country_code` varchar(10) DEFAULT NULL,
  `people_fax_no` varchar(255) DEFAULT NULL,
  `people_type` varchar(100) DEFAULT NULL,
  `login_status` int(2) DEFAULT NULL,
  `immediate_contact_person` varchar(255) DEFAULT '',
  `immediate_contact_telephone_number` varchar(25) DEFAULT '',
  `authorized` varchar(50) DEFAULT 'Yes',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`people_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `admin_people_locations` */
DROP TABLE IF EXISTS `admin_people_locations`;

CREATE TABLE `ogm_admin_people_locations` (
  `people_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`people_location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_google_analytic` */
DROP TABLE IF EXISTS `ogm_admin_google_analytic`;

CREATE TABLE `ogm_admin_google_analytic` (
  `analytic_id` int(11) NOT NULL,
  `analytic_code` text,
  `enable_in_login` tinyint(2) DEFAULT NULL,
  `enable_in_dashboard` tinyint(2) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`analytic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_people_documents` */
DROP TABLE IF EXISTS `ogm_admin_people_documents`;

CREATE TABLE `ogm_admin_people_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `people_id` (`people_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ogm_admin_people_documents`
   ADD FOREIGN KEY (people_id) REFERENCES ogm_admin_people(people_id) ON DELETE CASCADE;

/*Table structure for table `ogm_admin_territories` */
DROP TABLE IF EXISTS `ogm_admin_territories`;

CREATE TABLE `ogm_admin_territories` (
  `territory_id` int(11) NOT NULL AUTO_INCREMENT,
  `territory_code` varchar(255) NOT NULL,
  `territory_name` text NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(255) NOT NULL,
  PRIMARY KEY (`territory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table ogm_organization_company_information*/
DROP TABLE IF EXISTS `ogm_organization_company_information`;

CREATE TABLE `ogm_organization_company_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `company_short_name` varchar(255) DEFAULT '',
  `web` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ptn_country_code` varchar(10) DEFAULT NULL,
  `primary_telephone_number` varchar(25) DEFAULT NULL,
  `stn_country_code` varchar(10) DEFAULT NULL,
  `secendory_telephone_number` varchar(25) DEFAULT NULL,
  `fax_country_code` varchar(10) DEFAULT NULL,
  `fax_number` varchar(25) DEFAULT NULL,
  `address` text DEFAULT '',
  `short_address` text DEFAULT '',
  `company_logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table ogm_organization_company_structure*/
DROP TABLE IF EXISTS `ogm_organization_company_structure`;

CREATE TABLE `ogm_organization_company_structure` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_calendar_day_types` */
DROP TABLE IF EXISTS `ogm_admin_calendar_day_types`;

CREATE TABLE `ogm_admin_calendar_day_types` (
  `day_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `day_type_code` varchar(50),
  `day_type_name` varchar(100),
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`day_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_organization_calendar` */
DROP TABLE IF EXISTS `ogm_admin_organization_calendar`;

CREATE TABLE `ogm_admin_organization_calendar` (
  `calendar_day_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(20),
  `company_id` int(11),
  `day_type_id` int(11),
  `calendar_date` date DEFAULT NULL,
  `notes` varchar(255),
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`calendar_day_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ogm_admin_organization_calendar`
   ADD FOREIGN KEY (company_id) REFERENCES ogm_organization_company_structure(company_id) ON DELETE CASCADE,
   ADD FOREIGN KEY (day_type_id) REFERENCES ogm_admin_calendar_day_types(day_type_id) ON DELETE CASCADE;

/*Table structure for table `ogm_admin_default_calendar_populate_settings` */
DROP TABLE IF EXISTS `ogm_admin_default_calendar_populate_settings`;

CREATE TABLE `ogm_admin_default_calendar_populate_settings` (
  `calendar_populate_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(50),
  `company_id` varchar(100),
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`calendar_populate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
   ADD COLUMN `vehicle_id` int(11) DEFAULT NULL AFTER `location_id`;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `delivery_route_id` varchar(100) DEFAULT '0' AFTER `people_fax_no`,
    ADD COLUMN `tax_number` varchar(100) DEFAULT '' AFTER `people_fax_no`;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `welfare_company_id` int(11) DEFAULT '0' AFTER `location_id`,
    ADD COLUMN `welfare_company_department_id` int(11) DEFAULT '0' AFTER `welfare_company_id`,
    ADD COLUMN `welfare_company_job_category_id` int(11) DEFAULT '0' AFTER `welfare_company_department_id`,
    ADD COLUMN `purchasing_credit_limit_of_employee` decimal(20,2) Default '0.00' AFTER `welfare_company_job_category_id`;

/*Table structure for table `ogm_admin_welfare_companies` */
DROP TABLE IF EXISTS `ogm_admin_welfare_companies`;

CREATE TABLE `ogm_admin_welfare_companies` (
  `welfare_company_id` int(11) NOT NULL AUTO_INCREMENT,
  `welfare_company_code` varchar(255) NOT NULL,
  `welfare_company_name` text NOT NULL,
  `country_id` char(2) DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `state` text,
  `city` text,
  `address` text,
  `ptn_country_code` varchar(10) DEFAULT NULL,
  `primary_telephone_number` varchar(25) DEFAULT NULL,
  `stn_country_code` varchar(10) DEFAULT NULL,
  `secondary_telephone_number` varchar(25) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(255) NOT NULL,
  PRIMARY KEY (`welfare_company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_welfare_company_departments` */
DROP TABLE IF EXISTS `ogm_admin_welfare_company_departments`;

CREATE TABLE `ogm_admin_welfare_company_departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `welfare_company_id` int(11) NOT NULL,
  `department_code` varchar(255) NOT NULL,
  `department_name` text NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(255) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ogm_admin_welfare_company_departments`
   ADD FOREIGN KEY (welfare_company_id) REFERENCES ogm_admin_welfare_companies(welfare_company_id) ON DELETE CASCADE;

/*Table structure for table `ogm_admin_welfare_company_job_categories` */
DROP TABLE IF EXISTS `ogm_admin_welfare_company_job_categories`;

CREATE TABLE `ogm_admin_welfare_company_job_categories` (
  `job_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `welfare_company_id` int(11) NOT NULL,
  `job_category_code` varchar(255) NOT NULL,
  `job_category_name` text NOT NULL,
  `purchasing_credit_limit_of_employee` decimal(20,2) Default '0.00',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(255) NOT NULL,
  PRIMARY KEY (`job_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ogm_admin_welfare_company_job_categories`
   ADD FOREIGN KEY (welfare_company_id) REFERENCES ogm_admin_welfare_companies(welfare_company_id) ON DELETE CASCADE;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `is_also_a_sales_rep` varchar(10) DEFAULT 'No' AFTER `people_name`,
    ADD COLUMN `sales_rep_id` int(11) DEFAULT '0' AFTER `is_also_a_sales_rep`;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `is_also_a_cashier` varchar(10) DEFAULT 'No' AFTER `sales_rep_id`,
    ADD COLUMN `cashier_id` int(11) DEFAULT '0' AFTER `is_also_a_cashier`,
    ADD COLUMN `cashier_cash_varience` decimal(20,2) Default '0.00' AFTER `purchasing_credit_limit_of_employee`;

/*Table structure for table `ogm_admin_cashier_sales_performance` */
DROP TABLE IF EXISTS `ogm_admin_cashier_sales_performance`;

CREATE TABLE `ogm_admin_cashier_sales_performance` (
  `sales_performance_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `sales_target` decimal(20,2) DEFAULT '0.00',
  `sales_achivement` decimal(20,2) DEFAULT '0.00',
  `sales_achivement_percentage` decimal(20,2) DEFAULT '0.00',
  `last_action_status` varchar(255) NOT NULL,
  PRIMARY KEY (`sales_performance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ogm_admin_cashier_sales_performance`
   ADD FOREIGN KEY (people_id) REFERENCES ogm_admin_people(people_id) ON DELETE CASCADE;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `sales_credit_limit` decimal(20,2) DEFAULT '0.00' AFTER `cashier_cash_varience`,
    ADD COLUMN `current_sales_credit_amount` decimal(20,2) DEFAULT '0.00' AFTER `sales_credit_limit`;

/*Table structure for table `ogm_admin_welfare_company_credit_accounts` */
DROP TABLE IF EXISTS `ogm_admin_welfare_company_credit_accounts`;

CREATE TABLE `ogm_admin_welfare_company_credit_accounts` (
  `credit_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `welfare_company_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `year` varchar(50),
  `month` varchar(50),
  `credit_limit` decimal(20,2) NOT NULL,
  `credit_amount` decimal(20,2) NOT NULL,
  `cash_payment` decimal(20,2) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`credit_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
   ADD FOREIGN KEY (welfare_company_id) REFERENCES ogm_admin_welfare_companies(welfare_company_id) ON DELETE CASCADE;

ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
   ADD FOREIGN KEY (people_id) REFERENCES ogm_admin_people(people_id) ON DELETE CASCADE;




