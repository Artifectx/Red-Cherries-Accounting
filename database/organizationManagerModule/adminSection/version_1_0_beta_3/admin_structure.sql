
/*From ERP Version 9.0 Beta 1 */
/*Alter `ogm_admin_external_institutes` Table*/
ALTER TABLE `ogm_admin_external_institutes`
    ADD COLUMN `has_purchased_tlds` varchar(10) DEFAULT 'No' AFTER `service_status`;

/*Alter `ogm_admin_external_institutes_history` Table*/
ALTER TABLE `ogm_admin_external_institutes_history`
    ADD COLUMN `has_purchased_tlds` varchar(10) DEFAULT 'No' AFTER `service_status`;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `field_neutron_requested` varchar(10) DEFAULT 'No' AFTER `field_extremity_eye_requested`,
    ADD COLUMN `loyalty_customer` varchar(10) DEFAULT 'No' AFTER `people_address`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `field_neutron_requested` varchar(10) DEFAULT 'No' AFTER `field_extremity_eye_requested`,
    ADD COLUMN `loyalty_customer` varchar(10) DEFAULT 'No' AFTER `people_address`;

/*From ERP Version 9.0 Beta 2 */
/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `background_tld` varchar(10) DEFAULT 'No' AFTER `job_title`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `background_tld` varchar(10) DEFAULT 'No' AFTER `job_title`;

/*Table structure for table `ogm_admin_welfare_company_credit_periods` */
DROP TABLE IF EXISTS `ogm_admin_welfare_company_credit_periods`;

CREATE TABLE `ogm_admin_welfare_company_credit_periods` (
  `credit_period_id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(50) NOT NULL,
  `month` varchar(50) NOT NULL,
  `credit_period_start_date` date NOT NULL,
  `status` varchar(50) DEFAULT 'Open',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`credit_period_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Alter `ogm_admin_welfare_company_credit_accounts` Table*/
ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
   DROP COLUMN `year`,
   DROP COLUMN `month`;

/*Alter `ogm_admin_welfare_company_credit_accounts` Table*/
ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
    ADD COLUMN `credit_period_id` int(11) NOT NULL AFTER `people_id`;

ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
   ADD FOREIGN KEY (credit_period_id) REFERENCES ogm_admin_welfare_company_credit_periods(credit_period_id) ON DELETE CASCADE;

/*From ERP Version 9.0 Beta 4 */
/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `status` varchar(20) DEFAULT 'Active' AFTER `authorized`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `status` varchar(20) DEFAULT 'Active' AFTER `authorized`;

/*From ERP Version 9.0 Beta 16 */
/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `terminated` varchar(20) DEFAULT 'No' AFTER `status`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `terminated` varchar(20) DEFAULT 'No' AFTER `status`;

/*Alter `ogm_admin_welfare_company_credit_accounts` Table*/
ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
    ADD COLUMN `status` varchar(20) DEFAULT 'Active' AFTER `cash_payment`;

/*From ERP Version 9.0 Beta 21 */
/*Alter `ogm_admin_external_institutes` Table*/
ALTER TABLE `ogm_admin_external_institutes`
    ADD COLUMN `web_portal_registration_email` varchar(255) DEFAULT '' AFTER `distribution_frequency`,
    ADD COLUMN `web_portal_username` varchar(25) DEFAULT '' AFTER `web_portal_registration_email`,
    ADD COLUMN `web_portal_password` varchar(255) DEFAULT '' AFTER `web_portal_username`,
    ADD COLUMN `web_portal_password_salt` varchar(255) DEFAULT '' AFTER `web_portal_password`;

/*Alter `ogm_admin_external_institutes_history` Table*/
ALTER TABLE `ogm_admin_external_institutes_history`
    ADD COLUMN `web_portal_registration_email` varchar(255) DEFAULT '' AFTER `distribution_frequency`,
    ADD COLUMN `web_portal_username` varchar(25) DEFAULT '' AFTER `web_portal_registration_email`,
    ADD COLUMN `web_portal_password` varchar(255) DEFAULT '' AFTER `web_portal_username`,
    ADD COLUMN `web_portal_password_salt` varchar(255) DEFAULT '' AFTER `web_portal_password`;

/*From ERP Version 10.0 Beta 1 */
/*Alter `ogm_admin_welfare_company_credit_accounts` Table*/
ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
    ADD COLUMN `received_credit_payment` decimal(20,2) DEFAULT '0.00' AFTER `cash_payment`,
    ADD COLUMN `balance_credit_amount` decimal(20,2) DEFAULT '0.00' AFTER `received_credit_payment`,
    ADD COLUMN `taken_for_payment` varchar(10) DEFAULT 'No' AFTER `balance_credit_amount`;

/*Table structure for table `ogm_admin_welfare_company_cheque_payments` */
DROP TABLE IF EXISTS `ogm_admin_welfare_company_cheque_payments`;

CREATE TABLE `ogm_admin_welfare_company_cheque_payments` (
  `welfare_company_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_period_id` int(11) NOT NULL,
  `welfare_company_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `location_id` int(11) NOT NULL,
  `cheque_number` int(11) NOT NULL,
  `cheque_date` date NOT NULL,
  `bank_id` int(11) NOT NULL,
  `cheque_amount` decimal(20,2) DEFAULT '0.00',
  `crossed_cheque` varchar(10) DEFAULT NULL,
  `cheque_deposit_prime_entry_book_id` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`welfare_company_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_welfare_company_bills_for_cheque_payment` */
DROP TABLE IF EXISTS `ogm_admin_welfare_company_bills_for_cheque_payment`;

CREATE TABLE `ogm_admin_welfare_company_bills_for_cheque_payment` (
  `bill_for_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `credit_period_id` int(11) NOT NULL,
  `welfare_company_payment_id` int(11) DEFAULT NULL,
  `sales_invoice_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'Open',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`bill_for_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ogm_admin_external_institute_registrations` */
DROP TABLE IF EXISTS `ogm_admin_external_institute_registrations`;

CREATE TABLE `ogm_admin_external_institute_registrations` (
  `registration_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_number` varchar(50) NOT NULL,
  `external_institute_id` int(11) NOT NULL,
  `external_institute_name` text DEFAULT NULL,
  `registration_type` varchar(50) DEFAULT NULL,
  `application_file_name` varchar(50) NOT NULL,
  `received_date` date NOT NULL,
  `completed_date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Pending',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`registration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;