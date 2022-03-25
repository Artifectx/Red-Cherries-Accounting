
/*Update version number*/
UPDATE `system_common_configurations` SET `config_filed_value` =  '1.3' WHERE id = 1;
UPDATE `system_common_configurations` SET `config_filed_value` =  '10.0 Beta 13' WHERE id = 2;

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('ogm_people_salutations_list', ''),
('fg_minus_stocks_should_be_authorized_before_update_stock', 'No'),
('fg_minus_stock_update_authorizer_id', '0'),
('minus_stock_update_authorization_validity_period_in_days', '0'),
('microfinance_loan_documentation_charge_percentage', '0.00'),
('microfinance_loan_new_member_fee_for_weekly_repayment_plan', '0.00'),
('ogm_hide_country_field_from_customer_people_type', 'No'),
('ogm_hide_location_field_from_customer_people_type', 'No'),
('ogm_hide_loyalty_customer_field_from_customer_people_type', 'No'),
('ogm_hide_customer_delivery_route_field_from_customer_people_type', 'No'),
('ogm_hide_tax_number_field_from_customer_people_type', 'No'),
('ogm_hide_sales_credit_limit_field_from_customer_people_type', 'No'),
('ogm_hide_immediate_contact_field_from_customer_people_type', 'No'),
('ogm_enable_microfinance_fields_for_customer_people_type', 'No'),
('ogm_enable_bank_details_tab_in_people_screen', 'No'),
('enable_multicurrency_feature', '');

/*Data for the table `system_sub_modules` */
INSERT  INTO `system_sub_modules`(`system_sub_module_id`,`system_module_id`,`system_sub_module`,`system_sub_modules_status`,`status_change_option`,`system_sub_module_image_url`,`system_sub_module_dashboard_url`) values
(6, 6, 'Microfinance Manager', 1, 0,'microfinance_manager.png', 'systemManagerModule/dashboard_controller/dashboardMicrofinanceManager');

/*Data for the table `system_module_sections` */
INSERT  INTO `system_module_sections`(`module_section_name`,`module_section_status`,`status_change_option`,`system_module_id` ,`system_sub_module_id`) VALUES
('Administration', 1, 0, 6, 6),
('Micro Loans', 1, 0, 6, 6),
('Micro Investments', 1, 0, 6, 6),
('Reports', 1, 0, 6, 6);

/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features`(`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(187, 37, 'Administration Section', 'No'),
(188, 37, 'Banks', 'Yes'),
(189, 37, 'Loan Types', 'Yes'),
(190, 37, 'System Configurations', 'Yes'),
(191, 38, 'Loan Assignments', 'Yes'),
(192, 38, 'Collections', 'Yes'),
(193, 39, 'Fixed Deposits', 'Yes'),
(194, 40, 'Microfinance Reports', 'Yes'),
(195, 37, 'Branches', 'Yes'),
(196, 37, 'Centers', 'Yes'),
(197, 14, 'Banks', 'Yes'),
(198, 7, 'Multicurrencies', 'Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Voucher', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Voucher');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Detailed Voucher', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Detailed Voucher');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Short Voucher', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Short Voucher');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Payment No', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Payment No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Paid To', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Paid To');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('GRN No', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','GRN No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Balance', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Balance');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Outstanding Balance', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Outstanding Balance');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Payment Voucher', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Payment Voucher');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Payment for GRNs', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Payment for GRNs');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Payment Details', 'display_string', '7', 'Make Payment Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Payment Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Salutations', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Salutations');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Salutation', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Salutation');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Separate with a comma', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Separate with a comma');

/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features`(`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(185, 11, 'HR Workflows', 'Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Entitlement rules are not selected for the leave type. Please check in system configurations.', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Entitlement rules are not selected for the leave type. Please check in system configurations.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Apply restriction rules are not selected for the leave type. Please check in system configurations.', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Apply restriction rules are not selected for the leave type. Please check in system configurations.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Supervisor Details', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Supervisor Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('First Level Supervisor', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','First Level Supervisor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Second Level Supervisor', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Second Level Supervisor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Third Level Supervisor', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Third Level Supervisor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Previous Supervisors', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Previous Supervisors');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Supervisor Name', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Supervisor Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Supervisor Type', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Supervisor Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Supervisor History Details', 'display_string', '4', 'Supervisor Details Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Supervisor History Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('HR Workflows', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','HR Workflows');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Workflow Details', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Workflow Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Workflows', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Workflows');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Workflow Name', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Workflow Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Workflow', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Workflow');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Supervisor Levels', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Supervisor Levels');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Level', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Level');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Clear', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Clear');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Current Level', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Current Level');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Workflow', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Workflow');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Workflow Design', 'display_string', '4', 'HR Workflows Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Workflow Design');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Leave Entitlements', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Leave Entitlements');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Leave Approval Workflows', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Leave Approval Workflows');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Entitlement Amount', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Entitlement Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select Gift Vouchers', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select Gift Vouchers');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Gift Vouchers', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Gift Vouchers');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Sales invoice gift voucher payment for finish good', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Sales invoice gift voucher payment for finish good');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
(' for sales invoice gift voucher payment', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English',' for sales invoice gift voucher payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('POS Gift Voucher Payment', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','POS Gift Voucher Payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Duplicate leave entitlement filter combination identified!', 'message', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Duplicate leave entitlement filter combination identified!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Duplicate leave approval workflow filter combination identified!', 'message', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Duplicate leave approval workflow filter combination identified!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Leave Approval Workflow', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Leave Approval Workflow');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Check Ability To Do Stock Update', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Check Ability To Do Stock Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Check Ability to Update Stock', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Check Ability to Update Stock');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Authorize Stock Update', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Authorize Stock Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Authorizer Username', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Authorizer Username');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Authorizer Password', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Authorizer Password');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Authorize', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Authorize');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Stock has minus stock for following items. Minus stocks must be authorized before update the stock.', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Stock has minus stock for following items. Minus stocks must be authorized before update the stock.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Stock does not have minus stock for any item. User can proceed and do the stock update.', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Stock does not have minus stock for any item. User can proceed and do the stock update.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Stock has minus stock for some items. Minus stocks must be authorized before update the stock.', 'display_string', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Stock has minus stock for some items. Minus stocks must be authorized before update the stock.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Minus stocks should be authorized before do a stock update', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Minus stocks should be authorized before do a stock update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Stock Update Authorizor', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Stock Update Authorizor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Minus Stock Update Authorization Validity Period in Days', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Minus Stock Update Authorization Validity Period in Days');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('successfully_authorized', 'message', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Successfully authorized');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('unauthorized_user', 'message', '2', 'Warehouse Stock Balance Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','This user is not allowed to authorize the stock update');

/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features`(`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(186, 8, 'Journal Entry Bulk Upload', 'Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search Journal Entries', 'display_string', '7', 'Journal Entries Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search Journal Entries');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Distribution Print Status', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Distribution Print Status');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal Entry Bulk Upload', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal Entry Bulk Upload');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select Journal Entries File To Import Data', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select Journal Entries File To Import Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Journal Entry Bulk Upload', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Journal Entry Bulk Upload');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('journal entry bulk upload', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','journal entry bulk upload');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Uploaded User', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Uploaded User');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Uploaded Date', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Uploaded Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Posted User', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Posted User');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Posted Date', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Posted Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Pre-post', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Pre-post');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Rollback', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Rollback');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Post', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Post');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal Entry Bulk Upload Preview', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal Entry Bulk Upload Preview');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Data successfully loaded to import journal entries. Reveiw the entries and complete journal entry post.', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Data successfully loaded to import journal entries. Reveiw the entries and complete journal entry post.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Stakeholder Name', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Stakeholder Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reference Transaction Reference No', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reference Transaction Reference No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal entry pre-post is successfully done. Please review reports and post if everything is ok. Othervise rollback the action and re-check the journal entry bulk upload.', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal entry pre-post is successfully done. Please review reports and post if everything is ok. Othervise rollback the action and re-check the journal entry bulk upload.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal entry pre-post rollback is successful.', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal entry pre-post rollback is successful.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal entry bulk upload already pre-posted.', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal entry bulk upload already pre-posted.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal entry bulk upload already pre-posted. Please rollback before try to delete.', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal entry bulk upload already pre-posted. Please rollback before try to delete.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal entry bulk upload successfully posted.', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal entry bulk upload successfully posted.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to complete journal entry bulk post? Please note that after posting you cannot rollback.', 'message', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to complete journal entry bulk post? Please note that after posting you cannot rollback.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Import Journal Entries', 'display_string', '7', 'Journal Entry Bulk Upload Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Import Journal Entries');

UPDATE `system_language_translations` SET `translated_string` =  "Data import workbook has errors. Please click on Download Data Import Workbook Error Log File button to see errors and take required actions before re-upload." WHERE `language_string_id` = '2860';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Welfare Credit Vs Sales', 'display_string', '2', 'Sales Report Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Welfare Credit Vs Sales');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Welfare Credit Vs Sales Details', 'display_string', '2', 'Sales Report Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Welfare Credit Vs Sales Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Welfare Credit Balance', 'display_string', '2', 'Sales Report Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Welfare Credit Balance');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Difference', 'display_string', '2', 'Sales Report Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Difference');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Filter Only Printed Reports', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Filter Only Printed Reports');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Filter Only Not Printed Reports', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Filter Only Not Printed Reports');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Next Recent Distribution Date', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Next Recent Distribution Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dashboard - Microfinance Manager', 'display_string', '6', '');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dashboard - Microfinance Manager');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Microfinance Manager Dashboard', 'display_string', '6', '');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Microfinance Manager Dashboard');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Microfinance Manager', 'display_string', '6', '');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Microfinance Manager');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Banks', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Banks');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan Types', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan Types');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Micro Loans', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Micro Loans');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Micro Loans', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Micro Loans');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan Assignments', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan Assignments');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collections', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collections');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Micro Investments', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Micro Investments');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Fixed Deposits', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Fixed Deposits');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Microfinance Reports', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Microfinance Reports');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Branches', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Branches');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Centers', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Centers');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Branch Details', 'display_string', '6', 'Branches Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Branch Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Branch Code', 'display_string', '6', 'Branches Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Branch Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Branch', 'display_string', '6', 'Branches Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Branch');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Branch already added', 'message', '6', 'Branches Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Branch already added');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('branch', 'message', '6', 'Branches Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','branch');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Branch Address', 'display_string', '6', 'Branches Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Branch Address');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Phone Number', 'display_string', '6', 'Branches Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Phone Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Details', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Center', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Center');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Code', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Name', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Address', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Address');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Leader', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Leader');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Date', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Time', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Time');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Credit Officer', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Credit Officer');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Province', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Province');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('District', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','District');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('DS Office', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','DS Office');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('GS Division', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','GS Division');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Loan Type', 'display_string', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Loan Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan Name', 'display_string', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Interest Rate', 'display_string', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Interest Rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Installment Plan', 'display_string', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Installment Plan');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Default Loan Amount', 'display_string', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Default Loan Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Insurance Amount', 'display_string', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Insurance Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Document Charge', 'display_string', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Document Charge');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Insurance Amount Calculation Loan Value Limits', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Insurance Amount Calculation Loan Value Limits');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan Documentation Charge % From Loan Amount', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan Documentation Charge % From Loan Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Member Fee For Weekly Repayment Plan', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Member Fee For Weekly Repayment Plan');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Lower Limit', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Lower Limit');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Upper Limit', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Upper Limit');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan No', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan Type', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Customer Full Name', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Customer Full Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Business Category', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Business Category');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan Amount', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Installment', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Installment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Total Interest', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Total Interest');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loan Balance', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loan Balance');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Marketing Officer', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Marketing Officer');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Loan Assignment', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Loan Assignment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add Guarantors', 'display_string', '6', 'Loan Assignments Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add Guarantors');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Details', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Other Details', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Other Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Country Field from Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Country Field from Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Location Field from Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Location Field from Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Loyalty Customer Field from Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Loyalty Customer Field from Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Customer in Delivery Route Field from Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Customer in Delivery Route Field from Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Tax Number Field from Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Tax Number Field from Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Sales Credit Limit Field from Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Sales Credit Limit Field from Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Immediate Contact Field from Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Immediate Contact Field from Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Enable Microfinance Fields for Customer People Type', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Enable Microfinance Fields for Customer People Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('EPF No', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','EPF No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Group', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Group');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Husband Full Name', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Husband Full Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Husband Mobile No', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Husband Mobile No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Business Name', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Business Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Business Address', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Business Address');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Working Place', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Working Place');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Job Position', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Job Position');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Working Place Address', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Working Place Address');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Co-Borrower Full Name', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Co-Borrower Full Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Co-Borrower NIC', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Co-Borrower NIC');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Co-Borrower Birthday', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Co-Borrower Birthday');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Co-Borrower Phone No', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Co-Borrower Phone No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Co-Borrower Relationship', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Co-Borrower Relationship');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Co-Borrower Address', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Co-Borrower Address');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Groups', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Groups');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Group Details', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Group Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Group Code', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Group Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Group Name', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Group Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Center Group', 'display_string', '6', 'Centers Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Center Group');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('loan type', 'message', '6', 'Loan Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','loan type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Account Number', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Account Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Enable Bank Details Tab in People Screen', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Enable Bank Details Tab in People Screen');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Enable Multicurrency Feature', 'display_string', '7', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Enable Multicurrency Feature');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Multicurrency', 'display_string', '7', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Multicurrency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Multicurrency Details', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Multicurrency Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Currency Details', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Currency Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Currency Name', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Currency Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Currency Symbol', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Currency Symbol');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Base Currency', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Base Currency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Currency', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Currency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('currency', 'message', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','currency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Currency', 'message', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Currency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Base currency already added!', 'message', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Base currency already added!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Currency Daily Rates', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Currency Daily Rates');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Currency Monthly Average', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Currency Monthly Average');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Daily Rate Details', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Daily Rate Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('From Currency', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','From Currency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('To Currency', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','To Currency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Daily Rate', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Daily Rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Currency Daily Rate', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Currency Daily Rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('currency rate', 'message', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','currency rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Daily rate already added!', 'message', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Daily rate already added!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Currency Monthly Average Rates', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Currency Monthly Average Rates');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Monthly Average Rate Details', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Monthly Average Rate Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Monthly Average Rate', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Monthly Average Rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Currency Monthly Average Rate', 'display_string', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Currency Monthly Average Rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('monthly average rate', 'message', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','monthly average rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Monthly average rate already added!', 'message', '7', 'Multicurrency Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Monthly average rate already added!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Operating Currency', 'display_string', '7', 'Chart of Account Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Operating Currency');