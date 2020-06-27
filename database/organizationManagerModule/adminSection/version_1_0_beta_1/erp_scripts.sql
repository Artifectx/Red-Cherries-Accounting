
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
