
/*Update version number*/
UPDATE `system_common_configurations` SET `config_filed_value` =  '1.1' WHERE id = 1;
UPDATE `system_common_configurations` SET `config_filed_value` =  '10.0 Beta 2' WHERE id = 2;

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('tld_rentals_distribute_tld_reference_no_auto_increment', 'No'),
('tld_rentals_distribute_tld_reference_no_starting_code', ''),
('tld_rentals_distribute_tld_reference_no_separator', ''),
('tld_rentals_distribute_tld_reference_no_starting_number', ''),
('tld_rentals_collect_tld_returns_reference_no_auto_increment', 'No'),
('tld_rentals_collect_tld_returns_reference_no_starting_code', ''),
('tld_rentals_collect_tld_returns_reference_no_separator', ''),
('tld_rentals_collect_tld_returns_reference_no_starting_number', ''),
('rm_raw_material_show_rm_description_wh_stock_balance_table', ''),
('customer_purchase_percentage_for_point_calculation', ''),
('si_allow_to_hold_wholesales_sales_invoice', 'No'),
('si_do_not_allow_to_login_or_logout_when_there_are_onhold_wholesales_sales_invoice', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('si_disable_item_wise_discount_feature_in_pos', 'No'),
('si_print_additional_copy_of_sales_invoice_short_bill', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('si_cashier_should_balance_with_system_cashier_balance_to_login_to_pos', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('fg_show_product_name_translation', 'No'),
('fg_allow_to_enable_disable_products', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('allow_to_add_a_collect_tld_return_for_a_partially_returned_tld_distribution', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('tld_rentals_dose_reports_reference_no_auto_increment', 'No'),
('tld_rentals_dose_reports_reference_no_starting_code', ''),
('tld_rentals_dose_reports_reference_no_separator', ''),
('tld_rentals_dose_reports_reference_no_starting_number', '');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('tld_rentals_tld_invoices_reference_no_auto_increment', 'No'),
('tld_rentals_tld_invoices_reference_no_starting_code', ''),
('tld_rentals_tld_invoices_reference_no_separator', ''),
('tld_rentals_tld_invoices_reference_no_starting_number', '');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('maximum_allowed_product_opening_stock_value', '1000.00'),
('maximum_allowed_product_stock_update_physical_stock_value', '1000.00');

/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features`(`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(169, 29, 'TLD Reader Machines', 'Yes');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('si_round_off_pos_sales_invoice_due_payment', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('process_dose_reports_after_import_tld_readings', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('si_restrict_pos_credit_invoicing_for_default_customer', 'No'),

('singletld_dose_investigation_limit_lower_margin', '0.06'),
('twotld_dose_investigation_limit_lower_margin', '0.06'),
('fieldextremityring_dose_investigation_limit_lower_margin', '0.06'),
('fieldextremityeye_dose_investigation_limit_lower_margin', '0.06'),

('singletld_onemonth_period_dose_investigation_limit', '1.30'),
('singletld_twomonth_period_dose_investigation_limit', '2.60'),
('singletld_threemonth_period_dose_investigation_limit', '3.90'),

('twotld_onemonth_period_dose_investigation_limit', '1.47'),
('twotld_twomonth_period_dose_investigation_limit', '2.93'),
('twotld_threemonth_period_dose_investigation_limit', '4.45'),

('fieldextremityring_onemonth_period_dose_investigation_limit', '0.06'),
('fieldextremityring_twomonth_period_dose_investigation_limit', '2.60'),
('fieldextremityring_threemonth_period_dose_investigation_limit', '3.90'),

('fieldextremityeye_onemonth_period_dose_investigation_limit', '0.06'),
('fieldextremityeye_twomonth_period_dose_investigation_limit', '2.93'),
('fieldextremityeye_threemonth_period_dose_investigation_limit', '4.45');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('mail_server_name', ''),
('mail_server_username', ''),
('mail_server_password', ''),

('pmsl_portal_company_registered_email', ''),
('pmsl_portal_company_username', ''),
('pmsl_portal_company_password', ''),

('pmsl_portal_audit_firm_registered_email', ''),
('pmsl_portal_audit_firm_username', ''),
('pmsl_portal_audit_firm_password', ''),
('fg_show_serial_product_column_in_product_list', 'No'),

('pmsl_dose_report_containing_folder_name_in_server', '');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('si_print_sales_unit_on_sales_invoice_detail_bill', 'No'),
('si_print_markup_price_on_sales_invoice_detail_bill', 'No');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('parent_liabilities_chart_of_account', ''),
('parent_assets_chart_of_account', ''),
('retained_earnings_chart_of_account', ''),
('trade_debtor_chart_of_account', ''),
('parent_expense_chart_of_account', '');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Status change updated successfully!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Status change updated successfully!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Purpose change updated successfully!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Purpose change updated successfully!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Status change from ', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Status change from ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Status change from ', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Status change from ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
(' to ', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English',' to ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
(' is not allowed!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English',' is not allowed!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Purpose change from ', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Purpose change from ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Purchase TLDs', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Purchase TLDs');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Selected TLD belongs to another institute!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Selected TLD belongs to another institute!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Selected TLD already assigned to this worker or another worker!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Selected TLD already assigned to this worker or another worker!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Selected TLD already assigned to this worker and status is ', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Selected TLD already assigned to this worker and status is ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD not found in the system!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD not found in the system!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('3 TLDs already assigned!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','3 TLDs already assigned!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
(' cannot be assigned!', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English',' cannot be assigned!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD with the purpose ', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD with the purpose ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
(' and the status ', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English',' and the status ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Please select Distribution Method and TLD Type', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please select Distribution Method and TLD Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Please select a worker', 'message', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please select a worker');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD is not assigned to a worker of the selected institute or it is already given to the field!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD is not assigned to a worker of the selected institute or it is already given to the field!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Please select Distribution Method!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please select Distribution Method!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribute TLD already in use. ', 'message', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribute TLD already in use. ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Auto Increment Distribute TLD Reference Number', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Auto Increment Distribute TLD Reference Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reference No Code is required', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reference No Code is required');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reference No Start Number is required', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reference No Start Number is required');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reference No Start Number should be a number', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reference No Start Number should be a number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Status', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Status');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Verify Distribution', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Verify Distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Distribution', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Envelope', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Envelope');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Complete Distribution', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Complete Distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search TLD Distributions', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search TLD Distributions');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bulk Print TLD Distributions', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bulk Print TLD Distributions');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bulk Print TLD Distribution Envelopes', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bulk Print TLD Distribution Envelopes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Verify TLD Distribution Information', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Verify TLD Distribution Information');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Serial Number or ID Number Search', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Serial Number or ID Number Search');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Serial Number or ID Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Serial Number or ID Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reset for Verification', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reset for Verification');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tld_distribution_marked_as_completed', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD distribution completed successfully');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('no_tld_added_for_distribution', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','There are no TLDs added for this distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to mark this', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to mark this');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Distribution as completed', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Distribution as completed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tld_added_are_not_verified', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution TLDs are not verified');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Single TLD', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Single TLD');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Two TLD', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Two TLD');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Field Extremity Ring', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Field Extremity Ring');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Field Extremity Eye', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Field Extremity Eye');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Field Neutron', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Field Neutron');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Auto Increment Collect TLD Returns Reference Number', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Auto Increment Collect TLD Returns Reference Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribute TLD already in use. Therefore, the configuration option is disabled.', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribute TLD already in use. Therefore, the configuration option is disabled.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collect TLD Return already in use. Therefore, the configuration option is disabled.', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collect TLD Return already in use. Therefore, the configuration option is disabled.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD is not assigned to a worker of the selected institute or it is not given to the field yet!', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD is not assigned to a worker of the selected institute or it is not given to the field yet!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Return already added with Reference No : ', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Return already added with Reference No : ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tld_return_marked_as_completed', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Return completed successfully');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('no_tld_added_for_return', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','There are no TLDs added for this return');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Return as completed', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Return as completed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show TLD List', 'display_string', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show TLD List');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide TLD List', 'display_string', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide TLD List');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reminder Letters', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reminder Letters');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('There are no new TLD readings to import', 'message', '6', 'Import TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','There are no new TLD readings to import');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD data successfuly imported and processed', 'message', '6', 'Import TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD data successfuly imported and processed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search Workers', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search Workers');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('At least one TLD Type should be selected for Worker Requested TLD!', 'message', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','At least one TLD Type should be selected for Worker Requested TLD!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bulk Print Dose Reports', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bulk Print Dose Reports');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bulk Print Dose Report Envelopes', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bulk Print Dose Report Envelopes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Process Dose Reports', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Process Dose Reports');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Reports successfully processed', 'message', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Reports successfully processed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Raw Material Description in Warehouse Stock Balance Table', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Raw Material Description in Warehouse Stock Balance Table');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Customer Purchase Points', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Customer Purchase Points');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Customer Purchase Point Details', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Customer Purchase Point Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Points Grand Total', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Points Grand Total');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Customer Purchase Percentage For Point Calculation', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Customer Purchase Percentage For Point Calculation');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Customer Purchase Percentage For Point Calculation should be a decimal number', 'message', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Customer Purchase Percentage For Point Calculation should be a decimal number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Please note that Excel sheet name should be named as TLD_Readings', 'message', '6', 'Import TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please note that Excel sheet name should be named as TLD_Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hold The Sales Invoice', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hold The Sales Invoice');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Unhold The Sales Invoice', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Unhold The Sales Invoice');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Allow to Hold Wholesales Sales Invoice', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Allow to Hold Wholesales Sales Invoice');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You have onhold wholesales invoices. Please complete onhold wholesales invoices before logout. If you do not complete those onhold wholesales invoices and logout properly, system will not allow you to login to the system.', 'message', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You have onhold wholesales invoices. Please complete onhold wholesales invoices before logout. If you do not complete those onhold wholesales invoices and logout properly, system will not allow you to login to the system.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You have improperly logged out from the system without properly closing your onhold wholesales invoices. Please contact Administrator to correct your login issue.', 'message', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You have improperly logged out from the system without properly closing your onhold wholesales invoices. Please contact Administrator to correct your login issue.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Do Not Allow to Login or Logout When There Are Onhold Wholesales Sales Invoice', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Do Not Allow to Login or Logout When There Are Onhold Wholesales Sales Invoice');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Added By', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Added By');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Loyalty Customer', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Loyalty Customer');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Red Cherries ERP POS Sales Invoice', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Red Cherries ERP POS Sales Invoice');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Background TLD', 'message', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Background TLD');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reload', 'display_string', '6', 'Manage TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reload');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You have entered a history date for the Anneal Date!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You have entered a history date for the Anneal Date!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You have entered a history date for the Distribution Period From Date! Distribution got delayed from customer side?', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You have entered a history date for the Distribution Period From Date! Distribution got delayed from customer side?');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You have entered a history date for the Distribution Period From Date! Distribution got delayed from your side?', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You have entered a history date for the Distribution Period From Date! Distribution got delayed from your side?');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You should tell the system the reason for the delayed distribution! Distribution save aborted!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You should tell the system the reason for the delayed distribution! Distribution save aborted!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Delayed TLD Distribution Notice', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Delayed TLD Distribution Notice');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reason for Delayed TLD Distribution', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reason for Delayed TLD Distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Yes', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Period From cannot be greater than Distribution Period To!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Period From cannot be greater than Distribution Period To!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Type', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Reference No', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Reference No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Verify TLD Return Information', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Verify TLD Return Information');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Manual TLD Count', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Manual TLD Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Manual TLD count does not match verified TLD count!', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Manual TLD count does not match verified TLD count!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('That TLD is not returned from the field!', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','That TLD is not returned from the field!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('return_tlds_are_not_verified', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Returned TLDs are not verified');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Current credit period is active and cannot generate next credit period!', 'message', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Current credit period is active and cannot generate next credit period!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Credit Period Start Date', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Credit Period Start Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Credit Amount Total', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Credit Amount Total');

/*Update language strings*/
UPDATE `system_language_strings` SET `language_string` =  'Red Cherries ERP POS Sign In' WHERE `language_string_id` = '419';
UPDATE `system_language_strings` SET `language_string` =  'Red Cherries ERP POS Quick Sign In' WHERE `language_string_id` = '462';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '1351';
UPDATE `system_language_strings` SET `language_string` =  'Red Cherries ERP POS Sales Invoice List' WHERE `language_string_id` = '1374';

UPDATE `system_language_translations` SET `translated_string` =  'Red Cherries ERP POS Sign In' WHERE `language_translation_id` = '423';
UPDATE `system_language_translations` SET `translated_string` =  'Red Cherries ERP POS Quick Sign In' WHERE `language_translation_id` = '466';
DELETE FROM `system_language_translations` WHERE `language_translation_id` = '1355';
UPDATE `system_language_translations` SET `translated_string` =  'Red Cherries ERP POS Sales Invoice List' WHERE `language_translation_id` = '1378';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Disable Item Wise Discount Feature in POS', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Disable Item Wise Discount Feature in POS');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Additional Copy of Sales Invoice Short Bill', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Additional Copy of Sales Invoice Short Bill');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Customer Credit Balance', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Customer Credit Balance');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Red Cherries ERP POS Sales Invoice', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Red Cherries ERP POS Sales Invoice');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('POS Sales Returns', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','POS Sales Returns');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Please make sure that TLD data format is correct', 'message', '6', 'Import TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please make sure that TLD data format is correct');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Reference No', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Reference No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cashier Should Balance With System Cashier Balance to Login to POS', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cashier Should Balance With System Cashier Balance to Login to POS');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Previous Day Cashier Cash Varience', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Previous Day Cashier Cash Varience');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cashier Cash Varience', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cashier Cash Varience');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cashier Cash Varience Details', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cashier Cash Varience Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cash Arrears', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cash Arrears');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cash Excess', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cash Excess');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cashier Cash Varience Summary Details', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cashier Cash Varience Summary Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cash Arrears Grand Total', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cash Arrears Grand Total');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cash Excess Grand Total', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cash Excess Grand Total');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Finish good sales return cash refund', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Finish good sales return cash refund');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal entry for finish good sales return number : ', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal entry for finish good sales return number : ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Journal entry for raw material sales return number : ', 'display_string', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Journal entry for raw material sales return number : ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Product Name Translation', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Product Name Translation');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Product Name Translation', 'display_string', '2', 'Products Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Product Name Translation');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Allow to Enable and Disable Products', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Allow to Enable and Disable Products');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Deactivate the Product', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Deactivate the Product');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Deactivate the Customer', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Deactivate the Customer');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Preparation Date', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Preparation Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Anneal Date cannot be greater than Preparation Date!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Anneal Date cannot be greater than Preparation Date!');

/*Update language strings*/
UPDATE `system_language_strings` SET `language_string` =  'The Anneal Date you entered is too old! Do you want to proceed?' WHERE `language_string` = 'You have entered a history date for the Anneal Date!';

UPDATE `system_language_translations` SET `translated_string` =  'The Anneal Date you entered is too old! Do you want to proceed?' WHERE `translated_string` = 'You have entered a history date for the Anneal Date!';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution TLD Count', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution TLD Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Verified TLD Count', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Verified TLD Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('All TLDs are verified successfully', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','All TLDs are verified successfully');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
(' not belongs to the selected distribution!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English',' not belongs to the selected distribution!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('no_background_tld_selected_for_distribution', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Backgorund TLD is not selected for the distribution!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Backgorund TLD is not selected for the distribution!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Backgorund TLD is not selected for the distribution!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Get Background Card From Distribution No', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Get Background Card From Distribution No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Refer Background Card in Another Distribution', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Refer Background Card in Another Distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reference Background TLD', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reference Background TLD');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bigger physical quantity! Are you sure to proceed?', 'message', '2', 'Warehouse Stock Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bigger physical quantity! Are you sure to proceed?');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bigger opening stock quantity! Are you sure to proceed?', 'message', '2', 'Warehouse Opening Stock Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bigger opening stock quantity! Are you sure to proceed?');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Allow to Add a Collect TLD Return for a Partially Returned TLD Distribution', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Allow to Add a Collect TLD Return for a Partially Returned TLD Distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Already a TLD is selected for this worker in this return!', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Already a TLD is selected for this worker in this return!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Selected TLD belongs to a later distribution!', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Selected TLD belongs to a later distribution!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Already a TLD is selected for this worker in this distribution!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Already a TLD is selected for this worker in this distribution!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Exposure End Date', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Exposure End Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Period From Date', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Period From Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Period To Date', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Period To Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Period From Date updated sucessfully.', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Period From Date updated sucessfully.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invalid Exposure Period From Date.', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invalid Exposure Period From Date.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Prepared Date', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Prepared Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Period : ', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Period : ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('To : ', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','To : ');

INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('From : ', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','From : ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Attention', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Attention');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Ref. Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Ref. Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Card Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Card Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Remarks', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Remarks');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLDs Distribution For Workers', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLDs Distribution For Workers');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Return Date', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Return Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No. of TLD cards sent by SLAEB :', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No. of TLD cards sent by SLAEB :');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Signature of Prepared Officer :', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Signature of Prepared Officer :');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Date :', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Date :');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Checked by :', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Checked by :');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Ref.No', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Ref.No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Card No.', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Card No.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Relevent Distribution Period', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Relevent Distribution Period');

/*Update language strings*/
UPDATE `system_language_strings` SET `language_string` =  'Bulk Print TLD Distribution Envelopes (A4)' WHERE `language_string_id` = '3514';

UPDATE `system_language_translations` SET `translated_string` =  'Bulk Print TLD Distribution Envelopes (A4)' WHERE `language_translation_id` = '3518';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bulk Print TLD Distribution Envelopes (A5)', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bulk Print TLD Distribution Envelopes (A5)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Late Cards', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Late Cards');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Period : ', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Period : ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Whole Body TLD Card Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Whole Body TLD Card Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collar Dose TLD Card Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collar Dose TLD Card Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('distributions_are_different', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please select distributions only for one distribution method');

/*Update language strings*/
UPDATE `system_language_strings` SET `language_string` =  'Secondary Phone Number' WHERE `language_string_id` = '166';

UPDATE `system_language_translations` SET `translated_string` =  'Secondary Phone Number' WHERE `language_translation_id` = '170';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Tertiary Phone Number', 'display_string', '1', 'Company Information Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Tertiary Phone Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Preview', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Preview');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Notes', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Notes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(10) Dose (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(10) Dose (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(0.07) Dose (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(0.07) Dose (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(10) Dose Level', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(10) Dose Level');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(0.07) Dose Level', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(0.07) Dose Level');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Chip Number', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Chip Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Monitoring Period : ', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Monitoring Period : ');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Report Number', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Report Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Generated Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Generated Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Annealed Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Annealed Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Sent Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Sent Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receipt Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receipt Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Read Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Read Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Processed Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Processed Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(10) DOSE (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(10) DOSE (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(0.07) DOSE (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(0.07) DOSE (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Notes', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Notes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report already in use. Therefore, the configuration option is disabled.', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report already in use. Therefore, the configuration option is disabled.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Method Used : ', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Method Used : ');

/*Update language strings*/
UPDATE `system_language_strings` SET `language_string` =  'Bulk Print Dose Report Envelopes (A5)' WHERE `language_string_id` = '3545';

UPDATE `system_language_translations` SET `translated_string` =  'Bulk Print Dose Report Envelopes (A5)' WHERE `language_translation_id` = '3549';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Method', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Method');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Monitoring Period', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Monitoring Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Investigation Limit (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Investigation Limit (mSv)');

/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features`(`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(168, 29, 'TLD Readings', 'Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Radiation Protection Officer', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Radiation Protection Officer');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('invalid_monitored_period', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Monitoring period is not correct!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search Dose Reports', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search Dose Reports');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Readings', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Imported Date', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Imported Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reading Date', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reading Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reading Time', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reading Time');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Number', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Two RCF', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Two RCF');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Two ECC', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Two ECC');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Two Original Reading', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Two Original Reading');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Two Calculated Reading (uSv)', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Two Calculated Reading (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Three RCF', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Three RCF');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Three ECC', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Three ECC');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Three Original Reading', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Three Original Reading');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Three Calculated Reading (uSv)', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Three Calculated Reading (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Read Unit', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Read Unit');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Processing Status', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Processing Status');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Worker Code', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Worker Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report No', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search TLD Readings', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search TLD Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Invoice already in use. Therefore, the configuration option is disabled.', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Invoice already in use. Therefore, the configuration option is disabled.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Auto Increment Dose Reports Reference Number', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Auto Increment Dose Reports Reference Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Auto Increment TLD Invoices Reference Number', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Auto Increment TLD Invoices Reference Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invoice Calculation Rates', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invoice Calculation Rates');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Service Type', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Service Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Distribution Frequency', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Distribution Frequency');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Rate should be a double value', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Rate should be a double value');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invoice Number', 'display_string', '6', 'TLD Invoices Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invoice Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('distributions_not_selected_for_bulk_print', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distributions not selected for bulk print!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('dose_reports_not_selected_for_bulk_print', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Reports not selected for bulk print!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('reminder_successfully_generated', 'message', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reminder letter successfully generated!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Status', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Status');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Date', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reminder Date', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reminder Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reminder Count', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reminder Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Previous Reminder Dates', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Previous Reminder Dates');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reminder Letter', 'message', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reminder Letter');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Code', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Updated Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Updated Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Updated User', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Updated User');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Worker Status', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Worker Status');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Work Period', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Work Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Worker Institute', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Worker Institute');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Display Chip Two and Chip Three Readings', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Display Chip Two and Chip Three Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Display Chip One and Chip Four Readings', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Display Chip One and Chip Four Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip One RCF', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip One RCF');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip One ECC', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip One ECC');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip One Original Reading', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip One Original Reading');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip One Calculated Reading (uSv)', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip One Calculated Reading (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Four RCF', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Four RCF');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Four ECC', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Four ECC');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Four Original Reading', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Four Original Reading');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Chip Four Calculated Reading (uSv)', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Chip Four Calculated Reading (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Ring Dose (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Ring Dose (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Ring Dose Level', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Ring Dose Level');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Eye Dose (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Eye Dose (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Eye Dose Level', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Eye Dose Level');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('EXTREMITY RING DOSE (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','EXTREMITY RING DOSE (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('EXTREMITY EYE DOSE (mSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','EXTREMITY EYE DOSE (mSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Original Background Reading (uSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Original Background Reading (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Recalculate Dose Report', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Recalculate Dose Report');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Background Reading (uSv)', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Background Reading (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(10) Dose', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(10) Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(0.07) Dose', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(0.07) Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Dose', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Hp(10) Dose', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Hp(10) Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Hp(0.07) Dose', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Hp(0.07) Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Extremity Dose', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Extremity Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report successfully recalculated', 'message', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report successfully recalculated');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution No', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Background Hp(10) Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Background Hp(10) Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Background Hp(0.07) Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Background Hp(0.07) Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Background Extremity Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Background Extremity Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Per Day Hp(10) Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Per Day Hp(10) Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Per Day Hp(0.07) Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Per Day Hp(0.07) Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Per Day Extremity Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Per Day Extremity Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Average Per Day Hp(10) Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Average Per Day Hp(10) Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Average Per Day Hp(0.07) Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Average Per Day Hp(0.07) Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Average Per Day Extremity Dose (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Average Per Day Extremity Dose (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(10) Dose Standard Deviation (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(10) Dose Standard Deviation (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hp(0.07) Dose Standard Deviation (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hp(0.07) Dose Standard Deviation (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Dose Standard Deviation (uSv)', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Dose Standard Deviation (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Average Per Day Dose Graph', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Average Per Day Dose Graph');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Average Per Day Dose Variation', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Average Per Day Dose Variation');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Field Whole Body TLD', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Field Whole Body TLD');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Field Collar Dose TLD', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Field Collar Dose TLD');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Field Extremity TLD', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Field Extremity TLD');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Selected TLD is not valid under selected distribution method!', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Selected TLD is not valid under selected distribution method!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No.of TLD cards returned:', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No.of TLD cards returned:');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Name & Signature of the RPO/Authorized Person :', 'display_string', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Name & Signature of the RPO/Authorized Person :');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Return No', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Return No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invoice Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invoice Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assigned Worker Code', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assigned Worker Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assigned Worker Name', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assigned Worker Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Not Return No', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Not Return No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Period', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Returned Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Returned Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Monitored Period', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Monitored Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cumulated Hp(10) Dose', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cumulated Hp(10) Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cumulated Hp(0.07) Dose', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cumulated Hp(0.07) Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cumulated Extremity Ring Dose', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cumulated Extremity Ring Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cumulated Extremity Eye Dose', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cumulated Extremity Eye Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Ring Dose', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Ring Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Eye Dose', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Eye Dose');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Start Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Start Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure End Date', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure End Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Maximum Allowed Product Opening Stock Value', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Maximum Allowed Product Opening Stock Value');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Maximum Allowed Product Stock Update Physical Stock Value', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Maximum Allowed Product Stock Update Physical Stock Value');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Opening Stock Quantity you entered is exceeding maximum allowed opening stock quantity!', 'message', '2', 'Warehouse Opening Stock Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Opening Stock Quantity you entered is exceeding maximum allowed opening stock quantity!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Physical Quantity you entered is exceeding maximum allowed product stock update physical stock quantity!', 'message', '2', 'Warehouse Stock Update Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Physical Quantity you entered is exceeding maximum allowed product stock update physical stock quantity!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('reminder_already_generated', 'message', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reminders already generated for today!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD card was used by worker', 'display_string', '6', 'Not Returned TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD card was used by worker');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tld_distribution_marked_as_pending', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribition successfully marked as Pending!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Current TLD Assignment Data', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Current TLD Assignment Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Assignment History Data', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Assignment History Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Reader Machines', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Reader Machines');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search TLD Reader Machine Records', 'display_string', '6', 'TLD Reader Machines Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search TLD Reader Machine Records');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Reader Machine', 'display_string', '6', 'TLD Reader Machines Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Reader Machine');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Edit TLD Reading Data', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Edit TLD Reading Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Force and Prepare Dose Report', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Force and Prepare Dose Report');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tld_return_marked_as_pending', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collect TLD Return successfully marked as Pending!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invalid Exposure Period To Date.', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invalid Exposure Period To Date.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Period To Date updated sucessfully.', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Period To Date updated sucessfully.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Name', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD A', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD A');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD B', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD B');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD C', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD C');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Reading', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Reading');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tld_reading_already_processed_for_a_dose_report', 'message', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Reading already processed for a dose report!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Reading File', 'display_string', '6', 'Import TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Reading File');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tld_readings_already_processed_for_dose_reports', 'message', '6', 'TLD Readings Screen');
  
SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Readings already processed for dose reports!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Used Period', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Used Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bulk Edit', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bulk Edit');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('People Bulk Edit', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','People Bulk Edit');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Summary', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Summary');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Returns Pending TLD Distributions', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Returns Pending TLD Distributions');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reading Pending TLD Returns', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reading Pending TLD Returns');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Pending Dose Report Generations', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Pending Dose Report Generations');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Pending Invoice Generations', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Pending Invoice Generations');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Returns Pending After Third Reminder', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Returns Pending After Third Reminder');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Not Returned TLD Information', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Not Returned TLD Information');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Generation Count of Users', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Generation Count of Users');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Count', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Reading Count', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Reading Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invoice Generation Count of Users', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invoice Generation Count of Users');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invoice Count', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invoice Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Attendance data not imported successfully. Please make sure that attendance data formats are correct.', 'message', '4', 'Employee Attendance Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Attendance data not imported successfully. Please make sure that attendance data formats are correct.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Round Off Sales Invoice Due Payment in POS', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Round Off Sales Invoice Due Payment in POS');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Activate All Inactive Customers', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Activate All Inactive Customers');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('All inactive customers activated successfully', 'message', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','All inactive customers activated successfully');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Permanently Deactivate the Customer', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Permanently Deactivate the Customer');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Termination', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Termination');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to activate all inactive customers', 'message', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to activate all inactive customers');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Rental Service Income', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Rental Service Income');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Rental Period', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Rental Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('This Year Monthly Rentals', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','This Year Monthly Rentals');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Year Monthly Rentals', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Year Monthly Rentals');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Current Month Weekly Rentals', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Current Month Weekly Rentals');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Month Weekly Rentals', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Month Weekly Rentals');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Two Months Weekly Rentals', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Two Months Weekly Rentals');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Three Months Monthly Rentals', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Three Months Monthly Rentals');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Six Months Monthly Rentals', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Six Months Monthly Rentals');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Period From date cannot be greater than Exposure Period To date', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Period From date cannot be greater than Exposure Period To date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Exposure Period To date cannot be lesser than Exposure Period From date', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Exposure Period To date cannot be lesser than Exposure Period From date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Process Dose Reports After Import TLD Readings', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Process Dose Reports After Import TLD Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Delete Selected TLD Readings', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Delete Selected TLD Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to delete selected TLD Readings', 'message', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to delete selected TLD Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('tlds_not_selected_to_delete', 'message', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD readings not selected to delete!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Return TLDs verified successfully', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Return TLDs verified successfully');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TNLR', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TNLR');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You have selected workers to mark as TNLR. Are you sure to proceed', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You have selected workers to mark as TNLR. Are you sure to proceed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invoice Person', 'display_string', '6', 'TLD Invoices Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invoice Person');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Return Number', 'display_string', '6', 'TLD Invoices Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Return Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Completed', 'display_string', '6', 'TLD Invoices Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Completed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Invoice as completed', 'message', '6', 'TLD Invoices Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Invoice as completed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Printed', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Printed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report as printed', 'message', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report as printed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Progress', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Progress');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collection Progress', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collection Progress');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Overall Progress', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Overall Progress');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('As At Date', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','As At Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institutes Do Not Obtain Proper Service', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institutes Do Not Obtain Proper Service');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute No', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('RPO Name', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','RPO Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Distribution No', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Distribution No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Distribution Date', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Distribution Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Collection No', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Collection No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Last Collection Date', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Last Collection Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('User Service Performance', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','User Service Performance');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distributions Prepared', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distributions Prepared');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distributions Verified', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distributions Verified');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Collections', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Collections');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collected TLD Count', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collected TLD Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Reports Prepared', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Reports Prepared');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Worker Count', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Worker Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Invoices Prepared', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Invoices Prepared');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Summary', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Summary');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Card Summary', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Card Summary');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Extremity Summary', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Extremity Summary');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show All Readings', 'display_string', '6', 'TLD Readings Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show All Readings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Wise Worker Service Registrations', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Wise Worker Service Registrations');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No of Workers Obtain Single TLD Service', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No of Workers Obtain Single TLD Service');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No of Workers Obtain Two TLD Service', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No of Workers Obtain Two TLD Service');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No of Workers Obtain Extremity Eye Service', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No of Workers Obtain Extremity Eye Service');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No of Workers Obtain Extremity Ring Service', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No of Workers Obtain Extremity Ring Service');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Wise Worker TLD Assignments', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Wise Worker TLD Assignments');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No Of Single TLD Assigned', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No Of Single TLD Assigned');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No Of Two TLD Assigned', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No Of Two TLD Assigned');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No Of Extremity Eye Assigned', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No Of Extremity Eye Assigned');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('No Of Extremity Ring Assigned', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','No Of Extremity Ring Assigned');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Movements', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Movements');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Not Used TLD Summary', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Not Used TLD Summary');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Distribution Data', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Distribution Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Wise Distribution Count Data', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Wise Distribution Count Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institutes Which Has No Distributions', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institutes Which Has No Distributions');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Distribution Count', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Distribution Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collection Number', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collection Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Distribution Number', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Distribution Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Collection Number', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Collection Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Anneal Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Anneal Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Prepared Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Prepared Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Distribution Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Distribution Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Collection Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Collection Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Read Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Read Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Processed Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Processed Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Exposure Period', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Exposure Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Distribution Type', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Distribution Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Distribution Method', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Distribution Method');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Dose Monitored Period', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Dose Monitored Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collection Date', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collection Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Collection No', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Collection No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Ring', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Ring');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Extremity Eye', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Extremity Eye');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Late Return', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Late Return');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Dose Report Taken Success Rate', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Dose Report Taken Success Rate');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Expected Dose Report Count', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Expected Dose Report Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Taken Dose Report Count', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Taken Dose Report Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Taken Success Rate', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Taken Success Rate');




/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Period', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('12 Months', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','12 Months');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('24 Months', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','24 Months');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('36 Months', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','36 Months');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('48 Months', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','48 Months');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('60 Months', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','60 Months');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Items Sold', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Items Sold');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Item Sales Income', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Item Sales Income');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Stock Value Based on Product Movement', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Stock Value Based on Product Movement');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Stock Value', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Stock Value');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assignment Type', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assignment Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Institute Wise TLD Return Count Data', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Institute Wise TLD Return Count Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Return Count', 'display_string', '6', 'PMSL Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Return Count');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Sales Invoice Gross Profit Total', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Sales Invoice Gross Profit Total');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Daily Sales Summary', 'display_string', '2', 'Sales Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Daily Sales Summary');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Restrict POS Credit Invoicing for Default Sales Invoice Issue Customer', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Restrict POS Credit Invoicing for Default Sales Invoice Issue Customer');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('You are not allowed to add a credit invoice for Cash Sale default customer. Please select a valid customer.', 'message', '2', 'Sales Invoice Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','You are not allowed to add a credit invoice for Cash Sale default customer. Please select a valid customer.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Calculation Investigation Limits', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Calculation Investigation Limits');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Investigation Limit Name', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Investigation Limit Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Investigation Limit (uSv)', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Investigation Limit (uSv)');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Investigation Limit should be a double value', 'message', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Investigation Limit should be a double value');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Web Portal Registration Email', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Web Portal Registration Email');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Web Portal Username', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Web Portal Username');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Web Portal Password', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Web Portal Password');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Web Portal Confirm Password', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Web Portal Confirm Password');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reset Password and Email New Password to Portal User', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reset Password and Email New Password to Portal User');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to reset the password and email the new password to portal user?', 'message', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to reset the password and email the new password to portal user?');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Password Reset Details', 'message', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Password Reset Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Your account password has been reset and you can now login to your account area using the details below.', 'message', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Your account password has been reset and you can now login to your account area using the details below.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Portal user password reset and new password emailed to the user successfully.', 'message', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Portal user password reset and new password emailed to the user successfully.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Mail Server', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Mail Server');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Mail Server Details', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Mail Server Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Mail Server Name', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Mail Server Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Mail Server Username', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Mail Server Username');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Mail Server Password', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Mail Server Password');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Customer Web Portal', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Customer Web Portal');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Registered Email', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Registered Email');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Company Login Account Details', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Company Login Account Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Audit Firm Login Account Details', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Audit Firm Login Account Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Return Date should be greater than Exposure Period To date!', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Return Date should be greater than Exposure Period To date!');

/*Update language strings*/
UPDATE `system_language_strings` SET `language_string` =  'Bulk Print Dose Report Envelopes (A4)' WHERE `language_string_id` = '3545';

UPDATE `system_language_translations` SET `translated_string` =  'Bulk Print Dose Report Envelopes (A4)' WHERE `language_translation_id` = '3549';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('success_updated_but_worker_cannot_terminate', 'message', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Data successfully saved! However, worker cannot terminate as the worker has active TLD assignments.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Serial Product Column in Product List', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Serial Product Column in Product List');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Rentals Help', 'display_string', '6', 'TLD Rentals Help Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Rentals Help');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Download TLD Rentals Help User Guide', 'display_string', '6', 'TLD Rentals Help Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Download TLD Rentals Help User Guide');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('PMSL Reports Help', 'display_string', '6', 'PMSL Reports Help Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','PMSL Reports Help');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Download PMSL Reports Help User Guide', 'display_string', '6', 'PMSL Reports Help Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Download PMSL Reports Help User Guide');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Containing Folder Name in Server', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Containing Folder Name in Server');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Received Credit Payment', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Received Credit Payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Balance Credit Amount', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Balance Credit Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Welfare Company Payment', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Welfare Company Payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Welfare Company Payment Details', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Welfare Company Payment Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Outstanding Credit Amount', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Outstanding Credit Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Credit Payment Amount', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Credit Payment Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Total Payment', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Total Payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Cheque Number should be a number', 'message', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Cheque Number should be a number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Save Payment', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Save Payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Complete Payment', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Complete Payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select Credit Bills for Payment', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select Credit Bills for Payment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Distribution Dispatch', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Distribution Dispatch');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receive TLD Returns', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receive TLD Returns');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Distribution Dispatches', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Distribution Dispatches');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('TLD Distribution Dispatch Details', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','TLD Distribution Dispatch Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New TLD Distribution Dispatch', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New TLD Distribution Dispatch');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatch No', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatch No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatch Date', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatch Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatch Method', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatch Method');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatch Reference', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatch Reference');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('distribution dispatch', 'message', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','distribution dispatch');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search TLD Distribution Dispatches', 'display_string', '6', 'TLD Distribution Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search TLD Distribution Dispatches');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receive TLD Returns', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receive TLD Returns');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receive TLD Return Details', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receive TLD Return Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Receive TLD Return', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Receive TLD Return');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receive No', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receive No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receive Date', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receive Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receive Method', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receive Method');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Receive Reference', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Receive Reference');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('receive TLD return', 'message', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','receive TLD return');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search Receive TLD Returns', 'display_string', '6', 'Receive TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search Receive TLD Returns');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Registration Applications', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Registration Applications');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('New Registration Application', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','New Registration Application');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Application Number', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Application Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Registration Type', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Registration Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Application Received Date', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Application Received Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Application Completed Date', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Application Completed Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Application Status', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Application Status');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Registration Application', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Registration Application');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Received Date', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Received Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Completed Date', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Completed Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('application_number', 'message', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Application Number is already in use');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('application', 'message', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','application');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Received From Date', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Received From Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Received To Date', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Received To Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Application File', 'display_string', '1', 'External Institutes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Application File');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show All Pendings', 'display_string', '1', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show All Pendings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Show Old Pendings', 'display_string', '1', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Show Old Pendings');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Sales Unit On Sales Invoice Detail Bill', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Sales Unit On Sales Invoice Detail Bill');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Print Markup Price On Sales Invoice Detail Bill', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Print Markup Price On Sales Invoice Detail Bill');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Markup Price', 'display_string', '2', 'Products Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Markup Price');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to deactivate the selected person', 'message', '2', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to deactivate the selected person');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to permanently deactivate the selected person', 'message', '2', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to permanently deactivate the selected person');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Financial Year Ends', 'display_string', '7', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Financial Year Ends');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Financial Year', 'display_string', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Financial Year');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Financial Year Start Date', 'display_string', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Financial Year Start Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Financial Year End Date', 'display_string', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Financial Year End Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Year End Process Status', 'display_string', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Year End Process Status');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Year End Processed By', 'display_string', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Year End Processed By');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Process Year End', 'display_string', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Process Year End');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Previous financial year is not closed! Please close the previous financal year before add transactions.', 'message', '7', 'Journal Entries Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Previous financial year is not closed! Please close the previous financal year before add transactions.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('The financial year of the transaction you are trying to delete is already closed!', 'message', '7', 'Journal Entries Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','The financial year of the transaction you are trying to delete is already closed!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to process the year end now', 'message', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to process the year end now');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('year_end_successfuly_processed', 'message', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Year end successefully processed and account balances brought forward to next financial year.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select parent liabilities chart of account', 'display_string', '7', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select parent liabilities chart of account');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select parent assets chart of account', 'display_string', '7', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select parent assets chart of account');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select retained earnings chart of account', 'display_string', '7', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select retained earnings chart of account');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Financial year end processing chart of accounts are not configured', 'message', '7', 'Financial Year Ends Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Financial year end processing chart of accounts are not configured');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Available Opening Balances', 'display_string', '7', 'Opening Balances Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Available Opening Balances');

UPDATE `system_language_strings` SET `language_string` = 'This module consists of five sections called Administration, Finished Good Inventory, Raw Material Inventory, Sales and Reports. The Administration section allows to manage warehouses, unit and unit conversions, tax details, vehicles, delivery' WHERE `language_string_id` = '1251';
UPDATE `system_language_strings` SET `language_string` = 'Enter the Email Address associated with your account and click Submit to receive a password.' WHERE `language_string_id` = '1510';
UPDATE `system_language_translations` SET `translated_string` = 'Enter the Email Address associated with your account and click Submit to receive a password.' WHERE `language_translation_id` = '1510';
UPDATE `system_language_translations` SET `translated_string` = 'Data not found for search criterias to generate a chart. Select search filters and click on Search button to generate a chart.' WHERE `language_translation_id` = '2717';
UPDATE `system_language_translations` SET `translated_string` = 'Sales Invoice No not specified. Please specify a Sales Invoice No before close the sales invoice.' WHERE `language_translation_id` = '2783';
UPDATE `system_language_translations` SET `translated_string` = 'Data import workbook has errors. Please click on Download Data Import Workbook Error Log File button to see errors and take required actions before re-upload.' WHERE `language_translation_id` = '2860';
UPDATE `system_language_translations` SET `translated_string` = 'There are errors with data import. Please click on Download Data Import Error Log File button to see errors and take required actions before import again.' WHERE `language_translation_id` = '2862';
UPDATE `system_language_strings` SET `language_string` = 'Punch time already exists and is marked as deleted. Click on Reuse Existing Attendance Record button to reuse the deleted attendance record' WHERE `language_string_id` = '2893';
UPDATE `system_language_translations` SET `translated_string` = 'Punch time already exists and is marked as deleted. Click on Reuse Existing Attendance Record button to reuse the deleted attendance record' WHERE `language_translation_id` = '2893';
UPDATE `system_language_strings` SET `language_string` = 'Report is not selected/created to add fields. Please select or create a report in Step 1 first.' WHERE `language_string_id` = '2901';
UPDATE `system_language_translations` SET `translated_string` = 'Report is not selected/created to add fields. Please select or create a report in Step 1 first.' WHERE `language_translation_id` = '2901';

DELETE FROM `system_language_strings` WHERE `language_string_id` = '2730';
DELETE FROM `system_language_translations` WHERE `language_translation_id` = '2730';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '2731';
DELETE FROM `system_language_translations` WHERE `language_translation_id` = '2731';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select trade debtor chart of account', 'display_string', '7', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select trade debtor chart of account');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select parent expense chart of account', 'display_string', '7', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select parent expense chart of account');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Import Opening Balances', 'display_string', '7', 'Opening Balances Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Import Opening Balances');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Select Opening Balance Excel File To Import Data', 'display_string', '7', 'Opening Balances Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Select Opening Balance Excel File To Import Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Load Data', 'display_string', '7', 'Opening Balances Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Load Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Data successfully loaded to import opening balances. Reveiw the balance details and then save opening balances.', 'message', '7', 'Opening Balances Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Data successfully loaded to import opening balances. Reveiw the balance details and then save opening balances.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Too much data to save! Please use opening balance import feature to update changes.', 'message', '7', 'Opening Balances Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Too much data to save! Please use opening balance import feature to update changes.');

UPDATE `system_language_strings` SET `language_string` = 'Allows to manage company locations, people, company basic information and company structure. The information adding under this module is common to the other modules of Red Cherries ERP.' WHERE `language_string_id` = '1250';
UPDATE `system_language_translations` SET `translated_string` = 'Allows to manage company locations, people, company basic information and company structure. The information adding under this module is common to the other modules of Red Cherries ERP.' WHERE `language_string_id` = '1250';

UPDATE `system_language_strings` SET `language_string` = 'This module consists of five sections called Administration, Finished Good Inventory, Raw Material Inventory, Sales and Reports. The Administration section allows to manage warehouses, unit and unit conversions, tax details, vehicles, delivery routes and system configurations. System configurations allow to configure the system for different behaviors. Finished Good Inventory and Raw Material Inventory allows to manage finished good and raw material stock respectively. System allows to manage warehouse and lorry stock with different transactions. Sales section allows to manage sales invoices and sales returns. Reports section allows to generate different types of reports for stock balances, transactions, sales and sales returns.' WHERE `language_string_id` = '1251';
UPDATE `system_language_translations` SET `translated_string` = 'This module consists of five sections called Administration, Finished Good Inventory, Raw Material Inventory, Sales and Reports. The Administration section allows to manage warehouses, unit and unit conversions, tax details, vehicles, delivery routes and system configurations. System configurations allow to configure the system for different behaviors. Finished Good Inventory and Raw Material Inventory allows to manage finished good and raw material stock respectively. System allows to manage warehouse and lorry stock with different transactions. Sales section allows to manage sales invoices and sales returns. Reports section allows to generate different types of reports for stock balances, transactions, sales and sales returns.' WHERE `language_string_id` = '1251';

UPDATE `system_language_strings` SET `language_string` = 'Allows to manage the process of producing finished goods in a production line. Careful monitoring of raw materials issued to production line and exact usage and calculate final product cost considering other costing parameters is handled in this module. Module provides variation reports to evaluate the efficiency of production line thereby adjusting parameters to fine tune the efficiency and minimize loses. Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.' WHERE `language_string_id` = '1252';
UPDATE `system_language_translations` SET `translated_string` = 'Allows to manage the process of producing finished goods in a production line. Careful monitoring of raw materials issued to production line and exact usage and calculate final product cost considering other costing parameters is handled in this module. Module provides variation reports to evaluate the efficiency of production line thereby adjusting parameters to fine tune the efficiency and minimize loses. Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.' WHERE `language_string_id` = '1252';

UPDATE `system_language_strings` SET `language_string` = 'Employee salary details can be maintained in this module. Different types of earnings and deductions can be added and payroll process can be done by generating a salary payment detail script for banks. Module implementation is pending and will be available in a future version.' WHERE `language_string_id` = '1257';
UPDATE `system_language_translations` SET `translated_string` = 'Employee salary details can be maintained in this module. Different types of earnings and deductions can be added and payroll process can be done by generating a salary payment detail script for banks. Module implementation is pending and will be available in a future version.' WHERE `language_string_id` = '1257';

UPDATE `system_language_strings` SET `language_string` = 'Admin and a normal user roles available with default user role permissions. New users can be created for type of admin or normal user. When required additional user roles can be created with custom permissions and can be assigned to users.' WHERE `language_string_id` = '1256';
UPDATE `system_language_translations` SET `translated_string` = 'Admin and a normal user roles available with default user role permissions. New users can be created for type of admin or normal user. When required additional user roles can be created with custom permissions and can be assigned to users.' WHERE `language_string_id` = '1256';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Best online accounting management solution from Artifectx Solutions.', 'display_string', '', '');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Best online accounting management solution from Artifectx Solutions.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reinstall Language Pack To Solve Language Translation Issues', 'display_string', '8', 'System Language Pack Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reinstall Language Pack To Solve Language Translation Issues');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Language pack successfully reinstalled', 'message', '8', 'System Language Pack Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Language pack successfully reinstalled');

/*Other Language Translations */
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'chinesesimplified','财政年度结束');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'chinesesimplified','财政年度');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'chinesesimplified','财政年度开始日期');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'chinesesimplified','财政年度结束日期');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'chinesesimplified','年终流程状态');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'chinesesimplified','年终处理人');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'chinesesimplified','处理年终');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'chinesesimplified','上一个财政年度没有关闭！请在添加交易之前关闭上一个财政年度。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'chinesesimplified','您尝试删除的交易的财政年度已经结束！');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'chinesesimplified','您确定现在要处理年末吗');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'chinesesimplified','年终成功处理，账户余额结转至下一个财政年度。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'chinesesimplified','选择母负债科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'chinesesimplified','选择母资产科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'chinesesimplified','选择留存收益科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'chinesesimplified','财政年度结束处理科目表未配置');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'chinesesimplified','可用期初余额');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'chinesesimplified','选择贸易债务人会计科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'chinesesimplified','选择父费用科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'chinesesimplified','导入期初余额');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'chinesesimplified','选择期初余额 Excel 文件以导入数据');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'chinesesimplified','加载数据');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'chinesesimplified','数据已成功加载以导入期初余额。查看余额详细信息，然后保存期初余额。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'chinesesimplified','太多数据无法保存！请使用期初余额导入功能更新更改。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'chinesesimplified','Artifectx Solutions 的最佳在线会计管理解决方案。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'chinesesimplified','重新安装语言包以解决语言翻​​译问题');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'chinesesimplified','语言包重新安装成功');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1304,'chinesesimplified','银行');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(246,'chinesesimplified','系统配置');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(212,'chinesesimplified','行政');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(369,'chinesesimplified','分析期');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(214,'chinesesimplified','地点');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(173,'chinesesimplified','统计数据');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(174,'chinesesimplified','快速链接');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1866,'chinesesimplified','数据导入');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(224,'chinesesimplified','谷歌分析设置');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(657,'chinesesimplified','供应商');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(784,'chinesesimplified','代理人');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(785,'chinesesimplified','顾客');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1413,'chinesesimplified','出纳员');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(663,'chinesesimplified','司机');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1885,'chinesesimplified','下载');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1886,'chinesesimplified','下载数据导入工作簿用户指南');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1898,'chinesesimplified','上传');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1900,'chinesesimplified','下载数据导入工作簿错误日志文件');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1897,'chinesesimplified','进口');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(1899,'chinesesimplified','下载数据导入错误日志文件');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(529,'chinesesimplified','谷歌分析代码');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(530,'chinesesimplified','在登录中启用');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(531,'chinesesimplified','在仪表板中启用');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(508,'chinesesimplified','管理员帮助');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(509,'chinesesimplified','下载管理员帮助用户指南');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(3004,'chinesesimplified','短地址');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(328,'chinesesimplified','帐户主要入口簿');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(639,'chinesesimplified','日期');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(636,'chinesesimplified','参考编号');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(788,'chinesesimplified','数量');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(640,'chinesesimplified','地位');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(3513,'chinesesimplified','翻译生成待处理');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(213,'chinesesimplified','地点');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(903,'chinesesimplified','报告');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(293,'chinesesimplified','一般');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'chinesetraditional','財政年度結束');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'chinesetraditional','財政年度');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'chinesetraditional','財政年度開始日期');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'chinesetraditional','財政年度結束日期');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'chinesetraditional','年終流程狀態');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'chinesetraditional','年終處理人');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'chinesetraditional','處理年終');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'chinesetraditional','上一個財政年度沒有關閉！請在添加交易之前關閉上一個財政年度。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'chinesetraditional','您嘗試刪除的交易的財政年度已經結束！');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'chinesetraditional','您確定現在要處理年末嗎');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'chinesetraditional','年終成功處理，賬戶餘額結轉至下一個財政年度。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'chinesetraditional','選擇母負債科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'chinesetraditional','選擇母資產科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'chinesetraditional','選擇留存收益科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'chinesetraditional','財政年度結束處理科目表未配置');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'chinesetraditional','可用期初餘額');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'chinesetraditional','選擇貿易債務人會計科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'chinesetraditional','選擇父費用科目表');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'chinesetraditional','導入期初餘額');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'chinesetraditional','選擇期初餘額 Excel 文件以導入數據');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'chinesetraditional','加載數據');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'chinesetraditional','數據已成功加載以導入期初餘額。查看餘額詳細信息，然後保存期初餘額。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'chinesetraditional','太多數據無法保存！請使用期初餘額導入功能更新更改。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'chinesetraditional','Artifectx Solutions 的最佳在線會計管理解決方案。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'chinesetraditional','重新安裝語言包以解決語言翻譯問題');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'chinesetraditional','語言包重新安裝成功');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'french',"Fin de l'exercice");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'french',"Année financière");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'french',"Date de début de l'exercice");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'french',"Date de fin d'exercice");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'french',"Statut du processus de fin d'année");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'french',"Fin d'année traitée par");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'french',"Processus de fin d'année");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'french',"L'exercice précédent n'est pas clos ! Veuillez clôturer l'exercice précédent avant d'ajouter des transactions.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'french',"L'exercice de la transaction que vous essayez de supprimer est déjà clôturé !");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'french',"Êtes-vous sûr de vouloir traiter la fin de l'année maintenant");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'french',"Fin d'année traitée avec succès et soldes des comptes reportés à l'exercice suivant.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'french',"Sélectionner le plan comptable du passif de la société mère");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'french',"Sélectionner le plan comptable des actifs de la société mère");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'french',"Sélectionnez le plan comptable des bénéfices non répartis");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'french',"Le plan comptable de traitement de fin d'exercice n'est pas configuré");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'french',"Soldes d'ouverture disponibles");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'french',"Sélectionner le plan comptable du débiteur commercial");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'french',"Sélectionnez le plan comptable des dépenses des parents");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'french',"Importer les soldes d'ouverture");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'french',"Sélectionnez le fichier Excel de solde d'ouverture pour importer des données");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'french',"Charger les données");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'french',"Les données ont été chargées avec succès pour importer les soldes d'ouverture. Vérifiez les détails du solde, puis enregistrez les soldes d'ouverture.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'french',"Trop de données à enregistrer ! Veuillez utiliser la fonction d'importation du solde d'ouverture pour mettre à jour les modifications.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'french',"Meilleure solution de gestion comptable en ligne d'Artifectx Solutions.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'french',"Réinstallez le module linguistique pour résoudre les problèmes de traduction linguistique");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'french',"Pack de langue réinstallé avec succès");

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'german','Geschäftsjahr endet');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'german','Geschäftsjahr');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'german','Beginn des Geschäftsjahres');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'german','Enddatum des Geschäftsjahres');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'german','Prozessstatus zum Jahresende');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'german','Jahresende verarbeitet von');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'german','Jahresende verarbeiten');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'german','Das vergangene Geschäftsjahr ist nicht abgeschlossen! Bitte schließen Sie das vorherige Geschäftsjahr, bevor Sie Transaktionen hinzufügen.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'german','Das Geschäftsjahr der Transaktion, die Sie löschen möchten, ist bereits abgeschlossen!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'german','Möchten Sie das Jahresende jetzt wirklich bearbeiten');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'german','Jahresende erfolgreich verarbeitet und Kontosalden auf das nächste Geschäftsjahr vorgezogen.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'german','Wählen Sie den Kontenplan für die übergeordneten Verbindlichkeiten aus');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'german','Wählen Sie den Kontenplan des übergeordneten Vermögens aus');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'german','Wählen Sie den Kontenplan für einbehaltene Einnahmen aus');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'german','Der Kontenplan zum Ende des Geschäftsjahres ist nicht konfiguriert');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'german','Verfügbare Eröffnungssalden');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'german','Wählen Sie einen Debitorenplan aus Lieferungen und Leistungen');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'german','Wählen Sie den übergeordneten Kostenplan des Kontos');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'german','Eröffnungssalden importieren');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'german','Wählen Sie die Excel-Datei für den Eröffnungssaldo aus, um Daten zu importieren');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'german','Lade Daten');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'german','Daten erfolgreich geladen, um Eröffnungssalden zu importieren. Überprüfen Sie die Saldendetails und speichern Sie dann die Eröffnungssalden.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'german','Zu viele Daten zum Speichern! Bitte verwenden Sie die Eröffnungssaldo-Importfunktion, um Änderungen zu aktualisieren.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'german','Beste Online-Buchhaltungsmanagementlösung von Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'german','Installieren Sie das Sprachpaket neu, um Probleme mit der Sprachübersetzung zu lösen');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'german','Sprachpaket erfolgreich neu installiert');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'hindi','वित्तीय वर्ष समाप्त');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'hindi','वित्तीय वर्ष');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'hindi','वित्तीय वर्ष प्रारंभ तिथि');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'hindi','वित्तीय वर्ष की समाप्ति तिथि');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'hindi','वर्ष के अंत की प्रक्रिया की स्थिति');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'hindi','वर्ष के अंत द्वारा संसाधित');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'hindi','प्रक्रिया वर्ष समाप्ति');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'hindi','पिछला वित्तीय वर्ष बंद नहीं है! कृपया लेन-देन जोड़ने से पहले पिछले वित्तीय वर्ष को बंद कर दें।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'hindi','जिस लेन-देन को आप मिटाने का प्रयास कर रहे हैं उसका वित्तीय वर्ष पहले ही बंद हो चुका है!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'hindi','क्या आप वाकई वर्ष के अंत को अभी संसाधित करना चाहते हैं');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'hindi','वर्ष के अंत को सफलतापूर्वक संसाधित किया गया और खाते की शेष राशि को अगले वित्तीय वर्ष के लिए आगे लाया गया।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'hindi','खाते का मूल देयता चार्ट चुनें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'hindi','खाते का मूल संपत्ति चार्ट चुनें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'hindi','खाते के बनाए रखा आय चार्ट का चयन करें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'hindi','वित्तीय वर्ष के अंत में खातों का प्रसंस्करण चार्ट कॉन्फ़िगर नहीं किया गया है');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'hindi','उपलब्ध प्रारंभिक शेष राशि');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'hindi','खाते के व्यापार देनदार चार्ट का चयन करें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'hindi','खाते का मूल व्यय चार्ट चुनें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'hindi','प्रारंभिक शेष आयात करें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'hindi','डेटा आयात करने के लिए ओपनिंग बैलेंस एक्सेल फ़ाइल का चयन करें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'hindi','लोड डेटा');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'hindi','प्रारंभिक शेष राशि आयात करने के लिए डेटा सफलतापूर्वक लोड किया गया। शेष विवरण की समीक्षा करें और फिर प्रारंभिक शेष राशि सहेजें।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'hindi','बचाने के लिए बहुत अधिक डेटा! परिवर्तनों को अद्यतन करने के लिए कृपया प्रारंभिक शेष राशि आयात सुविधा का उपयोग करें।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'hindi','Artifectx Solutions से सर्वश्रेष्ठ ऑनलाइन लेखा प्रबंधन समाधान।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'hindi','भाषा अनुवाद के मुद्दों को हल करने के लिए भाषा पैक को पुनर्स्थापित करें');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'hindi','भाषा पैक सफलतापूर्वक पुनः स्थापित किया गया');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'hungarian','A pénzügyi év véget ér');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'hungarian','Pénzügyi év');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'hungarian','Pénzügyi év kezdő dátuma');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'hungarian','Pénzügyi év záró dátuma');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'hungarian','Év végi folyamat állapota');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'hungarian','Év vége feldolgozta');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'hungarian','Folyamat év vége');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'hungarian','Az előző pénzügyi év nincs lezárva! Kérjük, zárja be az előző pénzügyi évet a tranzakciók hozzáadása előtt.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'hungarian','A törlendő tranzakció pénzügyi éve már lezárult!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'hungarian','Biztosan most szeretné feldolgozni az év végét?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'hungarian','Az év végét sikeresen feldolgozták, és a számlaegyenlegeket átvitték a következő pénzügyi évre.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'hungarian','Válassza ki a szülői kötelezettségek számlát');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'hungarian','Válassza ki a szülői eszközök fióktábláját');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'hungarian','Válassza ki a felhalmozott eredmény számlaszámláját');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'hungarian','A pénzügyi év végi feldolgozási számlák nincsenek konfigurálva');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'hungarian','Rendelkezésre álló nyitómérlegek');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'hungarian','Válassza ki a kereskedelmi adós számlatervét');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'hungarian','Válassza ki a szülői költségtérképet');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'hungarian','Nyitó egyenlegek importálása');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'hungarian','Válassza a Nyitómérleg Excel fájl lehetőséget az adatok importálásához');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'hungarian','Adat betöltés');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'hungarian','Az adatok sikeresen betöltődtek a nyitó egyenlegek importálásához. Tekintse át az egyenleg részleteit, majd mentse a nyitó egyenlegeket.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'hungarian','Túl sok adat menthető! A módosítások frissítéséhez használja a nyitóegyenleg importálás funkciót.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'hungarian','Az Artifectx Solutions legjobb online számviteli menedzsment megoldása.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'hungarian','Telepítse újra a nyelvi csomagot a nyelvfordítási problémák megoldásához');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'hungarian','A nyelvi csomag sikeresen újratelepítve');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'italian',"Fine anno finanziario");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'italian',"Anno finanziario");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'italian',"Data di inizio dell'esercizio finanziario");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'italian',"Data di fine anno finanziario");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'italian',"Stato del processo di fine anno");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'italian',"Fine anno Elaborato da");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'italian',"Processo di fine anno");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'italian',"L'anno finanziario precedente non è chiuso! Si prega di chiudere l'anno finanziario precedente prima di aggiungere transazioni.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'italian',"L'anno finanziario della transazione che stai cercando di eliminare è già chiuso!");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'italian',"Sei sicuro di voler elaborare la fine dell'anno ora?");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'italian',"Fine anno elaborato con successo e saldi del conto anticipati all'anno finanziario successivo.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'italian',"Seleziona il piano contabile delle passività madri parent");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'italian',"Seleziona il piano dei conti delle attività principali");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'italian',"Seleziona il piano del conto degli utili non distribuiti");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'italian',"Il piano dei conti dell'elaborazione di fine anno finanziario non è configurato");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'italian',"Saldi di apertura disponibili");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'italian',"Seleziona il piano dei conti del debitore commerciale");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'italian',"Seleziona la tabella dei conti delle spese dei genitori");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'italian',"Importa saldi iniziali");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'italian',"Seleziona Apertura file Excel saldo per importare i dati");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'italian',"Caricamento dati");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'italian',"Dati caricati correttamente per importare i saldi di apertura. Rivedere i dettagli del saldo e quindi salvare i saldi di apertura.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'italian',"Troppi dati da salvare! Utilizza la funzione di importazione del saldo di apertura per aggiornare le modifiche.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'italian',"La migliore soluzione di gestione della contabilità online di Artifectx Solutions.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'italian',"Reinstallare il Language Pack per risolvere i problemi di traduzione linguistica");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'italian',"Language pack reinstallato con successo");

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'indonesian','Tahun Keuangan Berakhir');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'indonesian','Tahun Keuangan');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'indonesian','Tanggal Mulai Tahun Keuangan');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'indonesian','Tanggal Akhir Tahun Keuangan');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'indonesian','Status Proses Akhir Tahun');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'indonesian','Akhir Tahun Diproses Oleh');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'indonesian','Proses Akhir Tahun');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'indonesian','Tahun keuangan sebelumnya tidak ditutup! Harap tutup tahun anggaran sebelumnya sebelum menambah transaksi.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'indonesian','Tahun keuangan transaksi yang Anda coba hapus sudah ditutup!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'indonesian','Apakah Anda yakin ingin memproses akhir tahun sekarang?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'indonesian','Akhir tahun berhasil diproses dan saldo akun dibawa ke tahun anggaran berikutnya.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'indonesian','Pilih bagan akun kewajiban induk');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'indonesian','Pilih bagan akun aset induk');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'indonesian','Pilih bagan akun laba ditahan');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'indonesian','Bagan akun pemrosesan akhir tahun keuangan tidak dikonfigurasi');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'indonesian','Saldo Pembukaan yang Tersedia');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'indonesian','Pilih bagan akun debitur perdagangan');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'indonesian','Pilih bagan akun pengeluaran induk');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'indonesian','Impor Saldo Pembukaan');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'indonesian','Pilih Opening Balance File Excel Untuk Mengimpor Data');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'indonesian','Muat Data');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'indonesian','Data berhasil dimuat untuk mengimpor saldo awal. Tinjau detail saldo dan simpan saldo awal.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'indonesian','Terlalu banyak data untuk disimpan! Silakan gunakan fitur impor saldo awal untuk memperbarui perubahan.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'indonesian','Solusi manajemen akuntansi online terbaik dari Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'indonesian','Instal Ulang Paket Bahasa Untuk Memecahkan Masalah Terjemahan Bahasa');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'indonesian','Paket bahasa berhasil diinstal ulang');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'japanese','会計年度末');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'japanese','会計年度');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'japanese','会計年度の開始日');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'japanese','会計年度末日');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'japanese','年末のプロセスステータス');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'japanese','年末の処理者');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'japanese','年末の処理');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'japanese','前年度は休業していません！トランザクションを追加する前に、前の会計年度を閉じてください。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'japanese','削除しようとしている取引の会計年度はすでに終了しています。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'japanese','今年末を処理してもよろしいですか');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'japanese','年末は正常に処理され、口座残高は次の会計年度に繰り越されました。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'japanese','親負債勘定科目表を選択します');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'japanese','親資産勘定科目表を選択します');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'japanese','利益剰余金勘定科目表を選択します');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'japanese','会計年度末処理勘定コード表が構成されていません');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'japanese','利用可能な期首残高');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'japanese','貿易債務者勘定科目表を選択します');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'japanese','親の経費勘定表を選択します');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'japanese','期首残高のインポート');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'japanese','データをインポートするには、Opening BalanceExcelファイルを選択します');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'japanese','データを読み込む');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'japanese','期首残高をインポートするためにデータが正常にロードされました。残高の詳細を確認してから、期首残高を保存します。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'japanese','保存するデータが多すぎます！変更を更新するには、期首残高のインポート機能を使用してください。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'japanese','ArtifectxSolutionsの最高のオンライン会計管理ソリューション。');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'japanese','言語翻訳の問題を解決するために言語パックを再インストールする');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'japanese','言語パックが正常に再インストールされました');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'korean','회계연도 종료');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'korean','회계 연도');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'korean','회계 연도 시작 날짜');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'korean','회계연도 종료일');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'korean','연말 처리 현황');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'korean','연말 처리자');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'korean','프로세스 연말');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'korean','이전 회계 연도는 마감되지 않습니다! 거래를 추가하기 전에 이전 회계 연도를 마감하십시오.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'korean','삭제하려는 거래의 회계 연도가 이미 마감되었습니다!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'korean','지금 연말정산을 하시겠습니까?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'korean','연말이 성공적으로 처리되고 계정 잔액이 다음 회계 연도로 이월되었습니다.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'korean','모체 부채 계정과목표 선택');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'korean','상위 자산 계정과목표 선택');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'korean','이익잉여금 계정과목표 선택');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'korean','회계연도 말 처리 계정과목표가 구성되지 않았습니다.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'korean','사용 가능한 기초 잔액');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'korean','거래 채무자 계정과목표 선택');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'korean','상위 비용 계정과목표 선택');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'korean','기초 잔액 가져오기');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'korean','데이터를 가져올 기초 잔액 Excel 파일 선택');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'korean','데이터 로드');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'korean','기초 잔액을 가져오기 위해 데이터가 성공적으로 로드되었습니다. 잔액 세부 정보를 검토한 다음 기초 잔액을 저장합니다.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'korean','저장할 데이터가 너무 많습니다! 변경 사항을 업데이트하려면 기초 잔액 가져오기 기능을 사용하십시오.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'korean','Artifectx Solutions의 최고의 온라인 회계 관리 솔루션.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'korean','언어 번역 문제를 해결하기 위해 언어 팩 다시 설치');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'korean','언어 팩이 성공적으로 다시 설치되었습니다.');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'nepali','आर्थिक बर्ष समाप्त हुन्छ');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'nepali','आर्थिक वर्ष');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'nepali','वित्तीय वर्ष सुरू मिति');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'nepali','वित्तीय वर्षको अन्त्य मिति');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'nepali','वर्षको अन्त्य प्रक्रिया स्थिति');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'nepali','वर्ष अन्त द्वारा संसाधित');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'nepali','प्रक्रिया वर्षको अन्त्य');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'nepali','अघिल्लो वित्तीय वर्ष बन्द छैन! कृपया लेनदेन जोड्नु अघि अघिल्लो वित्तीय वर्ष बन्द गर्नुहोस्।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'nepali','लेनदेन को वित्तीय वर्ष तपाइँ मेटाउन को लागी कोशिश गरीरहनुभएको छ पहिले नै बन्द छ!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'nepali','के तपाइँ पक्का हुनुहुन्छ कि तपाइँ अब वर्षको अन्त्य प्रक्रिया गर्न चाहानुहुन्छ?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'nepali','वर्षको अन्त्य सफलतापूर्वक प्रशोधन गरीएको छ र खाता ब्यालेन्स अर्को वित्तीय वर्ष को लागी अगाडि ल्याईयो।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'nepali','खाताको अभिभावक दायित्व चार्ट चयन गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'nepali','खाताको अभिभावक सम्पत्ति चार्ट चयन गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'nepali','खाता को बरकरार आय चार्ट चयन गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'nepali','लेखा को वित्तीय वर्ष अन्त प्रशोधन चार्ट कन्फिगर गरीएको छैन');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'nepali','उपलब्ध खुल्ला ब्यालेन्स');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'nepali','खाताको ट्रेड torणकर्ता चार्ट चयन गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'nepali','खाताको अभिभावक व्यय चार्ट चयन गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'nepali','खुल्ला ब्यालेन्स आयात गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'nepali','डाटा आयात गर्न ब्यालेन्स एक्सेल फाइल खोल्ने चयन गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'nepali','डाटा लोड गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'nepali','डाटा सफलतापूर्वक लोडिंग ब्यालेन्सहरू आयात गर्न लोड भयो। ब्यालेन्स विवरण पत्ता लगाउनुहोस् र त्यसपछि खोल्ने ब्यालेन्सहरू बचत गर्नुहोस्।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'nepali','धेरै डाटा बचत गर्न को लागी! कृपया परिवर्तन अपडेट गर्न ब्यालेन्स आयात सुविधा खोल्ने प्रयोग गर्नुहोस्।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'nepali','Artifectx समाधान बाट सर्वश्रेष्ठ अनलाइन लेखा व्यवस्थापन समाधान।');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'nepali','भाषा अनुवाद मुद्दाहरु लाई हल गर्न को लागी भाषा प्याक पुनर्स्थापित गर्नुहोस्');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'nepali','भाषा प्याक सफलतापूर्वक पुनर्स्थापित');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'portuguese','Fim do ano financeiro');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'portuguese','Ano financeiro');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'portuguese','Data de início do ano financeiro');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'portuguese','Data Final do Ano Financeiro');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'portuguese','Status do processo de final de ano');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'portuguese','Fim do ano processado por');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'portuguese','Fim do ano do processo');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'portuguese','O exercício anterior não está fechado! Feche o ano financeiro anterior antes de adicionar transações.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'portuguese','O exercício financeiro da transação que você está tentando excluir já está fechado!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'portuguese','Tem certeza de que deseja processar o final do ano agora');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'portuguese','Final de ano processado com sucesso e saldos de contas antecipados para o próximo ano financeiro.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'portuguese','Selecione o plano de contas do passivo pai');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'portuguese','Selecione o plano de contas dos ativos principais');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'portuguese','Selecione o gráfico de contas de lucros retidos');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'portuguese','O plano de contas de processamento de final de ano financeiro não está configurado');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'portuguese','Saldos de abertura disponíveis');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'portuguese','Selecione o plano de contas do devedor comercial');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'portuguese','Selecione o plano de contas de despesas dos pais');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'portuguese','Importar Saldos de Abertura');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'portuguese','Selecione Arquivo Excel de Balanço de Abertura para Importar Dados');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'portuguese','Carregar dados');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'portuguese','Dados carregados com sucesso para importar saldos iniciais. Reveja os detalhes do saldo e, em seguida, salve os saldos iniciais.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'portuguese','Muitos dados para salvar! Use o recurso de importação de saldo inicial para atualizar as alterações.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'portuguese','Melhor solução de gerenciamento de contabilidade online da Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'portuguese','Reinstale o pacote de idiomas para resolver problemas de tradução de idiomas');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'portuguese','Pacote de idiomas reinstalado com sucesso');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'polish','Koniec roku obrotowego');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'polish','Rok budżetowy');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'polish','Data rozpoczęcia roku obrotowego');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'polish','Data zakończenia roku obrotowego');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'polish','Status procesu na koniec roku');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'polish','Koniec roku przetworzony przez');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'polish','Proces Koniec roku');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'polish','Poprzedni rok obrotowy nie jest zamknięty! Przed dodaniem transakcji zamknij poprzedni rok budżetowy.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'polish','Rok finansowy transakcji, którą próbujesz usunąć, jest już zamknięty!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'polish','Czy na pewno chcesz teraz przetworzyć koniec roku?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'polish','Pomyślnie przetworzono koniec roku, a salda kont przeniesiono na następny rok finansowy.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'polish','Wybierz plan kont pasywów macierzystych');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'polish','Wybierz plan kont aktywów nadrzędnych');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'polish','Wybierz plan kont zatrzymanych dochodów');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'polish','Plan kont przetwarzania na koniec roku obrotowego nie jest skonfigurowany');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'polish','Dostępne salda początkowe');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'polish','Wybierz plan kont dłużników handlowych');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'polish','Wybierz plan kont wydatków rodzicielskich');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'polish','Importuj salda początkowe');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'polish','Wybierz plik Excel bilansu otwarcia, aby zaimportować dane');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'polish','Załaduj dane');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'polish','Pomyślnie załadowano dane do importu bilansów otwarcia. Sprawdź szczegóły salda, a następnie zapisz salda otwarcia.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'polish','Za dużo danych do zapisania! Użyj funkcji importu salda otwarcia, aby zaktualizować zmiany.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'polish','Najlepsze rozwiązanie do zarządzania księgowością online od Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'polish','Zainstaluj ponownie pakiet językowy, aby rozwiązać problemy z tłumaczeniem języka Language');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'polish','Pakiet językowy został pomyślnie ponownie zainstalowany');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'russian','Окончание финансового года');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'russian','Финансовый год');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'russian','Дата начала финансового года');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'russian','Дата окончания финансового года');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'russian','Статус процесса на конец года');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'russian','Конец года Обработано');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'russian','Конец года процесса');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'russian','Предыдущий финансовый год не закрывается! Пожалуйста, закройте предыдущий финансовый год, прежде чем добавлять транзакции.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'russian','Финансовый год транзакции, которую вы пытаетесь удалить, уже закрыт!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'russian','Вы уверены, что хотите обработать конец года сейчас?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'russian','Конец года успешно обработан, и остатки на счетах перенесены на следующий финансовый год.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'russian','Выберите план счетов материнских обязательств');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'russian','Выберите план родительских активов для счета');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'russian','Выберите план нераспределенной прибыли для счета');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'chinesesimplified','План обработки счетов на конец финансового года не настроен');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'russian','Доступный начальный баланс');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'russian','Выберите план счета торгового дебитора');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'russian','Выберите родительский план расходов для счета');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'russian','Импорт начальных сальдо');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'russian','Выберите файл Excel начального баланса для импорта данных');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'chinesesimplified','Загрузить данные');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'russian','Данные успешно загружены для импорта начальных балансов. Просмотрите сведения о балансе, а затем сохраните начальные балансы.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'russian','Слишком много данных для сохранения! Пожалуйста, используйте функцию импорта начального баланса, чтобы обновить изменения.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'russian','Лучшее решение для управления бухгалтерским учетом онлайн от Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'russian','Переустановите языковой пакет для решения проблем с языковым переводом');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'russian','Языковой пакет успешно переустановлен');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'romanian','Anul financiar se încheie');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'romanian','An financiar');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'romanian','Data de începere a exercițiului financiar');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'romanian','Data de încheiere a exercițiului financiar');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'romanian','Starea procesului de sfârșit de an');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'romanian','Sfârșitul anului procesat de');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'romanian','Procesul Sfârșitul anului');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'romanian','Anul financiar anterior nu este închis! Vă rugăm să închideți anul financiar anterior înainte de a adăuga tranzacții.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'romanian','Anul financiar al tranzacției pe care încercați să îl ștergeți este deja închis!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'romanian','Sigur doriți să procesați sfârșitul anului acum');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'romanian','Sfârșitul anului este procesat cu succes și soldurile contului sunt reportate pentru exercițiul financiar următor.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'romanian','Selectați planul de cont al pasivelor părinte');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'romanian','Selectați planul de cont al activelor părinte');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'romanian','Selectați planul de cont al veniturilor reportate');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'romanian','Planul de conturi de procesare la sfârșitul exercițiului financiar nu este configurat');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'romanian','Solduri de deschidere disponibile');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'romanian','Selectați planul de cont al debitorului comercial');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'romanian','Selectați planul de cont al cheltuielilor părinte');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'romanian','Importați solduri de deschidere');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'romanian','Selectați Opening Balance Excel File Pentru a importa date');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'romanian','Incarca date');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'romanian','Datele au fost încărcate cu succes pentru a importa soldurile de deschidere. Revizuiți detaliile soldului și apoi salvați soldurile de deschidere.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'romanian','Prea multe date de salvat! Vă rugăm să utilizați funcția de import a soldului de deschidere pentru a actualiza modificările.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'romanian','Cea mai bună soluție de gestionare a contabilității online de la Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'romanian','Reinstalați pachetul lingvistic pentru a rezolva problemele legate de traducerea limbii');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'romanian','Pachetul lingvistic reinstalat cu succes');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'sinhala','මූල්‍ය වර්ෂ අවසානයන්');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'sinhala','මූල්‍ය වර්ෂය');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'sinhala','මූල්‍ය වර්ෂය ආරම්භක දිනය');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'sinhala','මූල්‍ය වර්ෂය අවසන් දිනය');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'sinhala','වසර අවසාන ක්‍රියාවලි තත්ත්වය');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'sinhala','වසර අවසානය සකසන ලද්දේ');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'sinhala','වසර අවසානය ක්‍රියාත්මක කරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'sinhala','පෙර මූල්‍ය වර්ෂය වසා නැත! ගනුදෙනු එකතු කිරීමට පෙර කරුණාකර පසුගිය මූල්‍ය වර්ෂය වසා දමන්න.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'sinhala','ඔබ මැකීමට උත්සාහ කරන ගනුදෙනුවේ මූල්‍ය වර්ෂය දැනටමත් වසා ඇත!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'sinhala','ඔබට විශ්වාසද ඔබට දැන් වසර අවසානය සැකසීමට අවශ්‍ය බව');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'sinhala','වසර අවසානය සාර්ථකව සැකසූ අතර ගිණුම් ශේෂයන් ඉදිරි මූල්‍ය වර්ෂය සඳහා ගෙන එන ලදී');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'sinhala','මව් වගකීම් ගිණුම් සටහන තෝරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'sinhala','මව් වත්කම් ගිණුම් සටහන තෝරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'sinhala','රඳවා තබා ගත් ඉපැයීම් ගිණුමේ සටහන තෝරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'sinhala','මූල්‍ය වර්ෂය අවසානයේ ගිණුම් සැකසුම් සටහන සැකසී නොමැත');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'sinhala','පවතින ආරම්භක ශේෂයන්');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'sinhala','වෙළඳ ණයකරුගේ ගිණුම් සටහන තෝරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'sinhala','මව් වියදම් ගිණුම සටහන තෝරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'sinhala','ආරම්භක ශේෂ දත්ත ආයාත කරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'sinhala','දත්ත ආයාත කිරීම සඳහා ශේෂය එක්සෙල් ගොනුව විවෘත කිරීම තෝරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'sinhala','දත්ත පූරණය කරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'sinhala','ආරම්භක ශේෂයන් ආයාත කිරීම සඳහා දත්ත සාර්ථකව පූරණය විය. ශේෂ විස්තර විමසා බලා විවෘත ශේෂයන් සුරකින්න.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'sinhala','සුරැකීමට පමණට වඩා වඩා දත්ත ඇත! වෙනස්කම් යාවත්කාලීන කිරීම සඳහා කරුණාකර විවෘත ශේෂ ආනයන විශේෂාංගය භාවිතා කරන්න.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'sinhala','Artifectx Solutions වෙතින් හොඳම මාර්ගගත ගිණුම්කරණ කළමනාකරණ විසඳුම.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'sinhala','භාෂා පරිවර්‍තන ගැටලු විසඳීම සඳහා භාෂා ඇසුරුම නැවත ස්ථාපනය කරන්න');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'sinhala','භාෂා පරිවර්තනයන් සාර්ථකව නැවත ස්ථාපනය කරන ලදි');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'spanish','Fin del ejercicio financiero');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'spanish','Año financiero');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'spanish','Fecha de inicio del año financiero');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'spanish','Fecha de finalización del ejercicio financiero');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'spanish','Estado del proceso de fin de año');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'spanish','Fin de año procesado por');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'spanish','Fin del año del proceso');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'spanish','¡El ejercicio anterior no está cerrado! Cierre el año financiero anterior antes de agregar transacciones.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'spanish','¡El año financiero de la transacción que está intentando eliminar ya está cerrado!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'spanish','¿Está seguro de que desea procesar el fin de año ahora?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'spanish','El final del año se procesó con éxito y los saldos de las cuentas se adelantaron al próximo año financiero.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'spanish','Seleccionar plan de cuentas de pasivos de los padres');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'spanish','Seleccione el plan de cuentas de los activos principales');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'spanish','Seleccionar plan de cuenta de ganancias retenidas');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'spanish','El plan de cuentas de procesamiento de fin de año fiscal no está configurado');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'spanish','Saldos de apertura disponibles');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'spanish','Seleccione el plan de cuentas de deudor comercial');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'spanish','Seleccione el cuadro de cuenta de gastos de los padres');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'spanish','Importar saldos iniciales');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'spanish','Seleccione Abrir archivo de balance de Excel para importar datos');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'spanish','Cargar datos');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'spanish','Datos cargados correctamente para importar saldos iniciales. Vea los detalles del saldo y luego guarde los saldos iniciales.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'spanish','¡Demasiados datos para guardar! Utilice la función de importación de saldo inicial para actualizar los cambios.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'spanish','La mejor solución de gestión contable online de Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'spanish','Reinstale el paquete de idioma para resolver problemas de traducción de idiomas');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'spanish','Paquete de idioma reinstalado correctamente');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'tamil','நிதி ஆண்டு முடிவடைகிறது');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'tamil','நிதி ஆண்டு');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'tamil','நிதி ஆண்டு தொடக்க தேதி');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'tamil','நிதி ஆண்டு இறுதி தேதி');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'tamil','ஆண்டு இறுதி செயல்முறை நிலை');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'tamil','ஆண்டின் இறுதியில் செயலாக்கப்பட்டது');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'tamil','செயல்முறை ஆண்டு முடிவு');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'tamil','முந்தைய நிதியாண்டு மூடப்படவில்லை! பரிவர்த்தனைகளைச் சேர்ப்பதற்கு முன் முந்தைய நிதி ஆண்டை மூடுக.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'tamil','நீங்கள் நீக்க முயற்சிக்கும் பரிவர்த்தனையின் நிதி ஆண்டு ஏற்கனவே மூடப்பட்டுள்ளது!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'tamil','நீங்கள் நிச்சயமாக ஆண்டு முடிவை செயலாக்க விரும்புகிறீர்களா?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'tamil','ஆண்டு இறுதி வெற்றிகரமாக செயலாக்கப்பட்டது மற்றும் கணக்கு நிலுவைகள் அடுத்த நிதியாண்டுக்கு கொண்டு வரப்படும்.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'tamil','கணக்கின் பெற்றோர் பொறுப்புகள் விளக்கப்படத்தைத் தேர்ந்தெடுக்கவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'tamil','கணக்கின் பெற்றோர் சொத்து விளக்கப்படத்தைத் தேர்ந்தெடுக்கவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'tamil','கணக்கின் தக்க வருவாய் விளக்கப்படத்தைத் தேர்ந்தெடுக்கவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'tamil','கணக்குகளின் நிதி ஆண்டு இறுதி செயலாக்க விளக்கப்படம் கட்டமைக்கப்படவில்லை');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'tamil','கிடைக்கும் திறந்த நிலுவைகள்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'tamil','வர்த்தக கடனாளர் கணக்கைத் தேர்ந்தெடுக்கவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'tamil','கணக்கின் பெற்றோர் செலவு விளக்கப்படத்தைத் தேர்ந்தெடுக்கவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'tamil','திறப்பு நிலுவைகளை இறக்குமதி செய்க');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'tamil','தரவை இறக்குமதி செய்ய இருப்பு எக்செல் கோப்பைத் திற என்பதைத் தேர்ந்தெடுக்கவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'tamil','தரவை ஏற்றவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'tamil','தொடக்க நிலுவைகளை இறக்குமதி செய்ய தரவு வெற்றிகரமாக ஏற்றப்பட்டது. இருப்பு விவரங்களை வெளிப்படுத்தவும், பின்னர் தொடக்க நிலுவைகளை சேமிக்கவும்.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'tamil','சேமிக்க அதிக தரவு! மாற்றங்களைப் புதுப்பிக்க தொடக்க இருப்பு இறக்குமதி அம்சத்தைப் பயன்படுத்தவும்.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'tamil','ஆர்டிஃபெக்ட்ஸ் தீர்வுகளிலிருந்து சிறந்த ஆன்லைன் கணக்கியல் மேலாண்மை தீர்வு.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'tamil','மொழி மொழிபெயர்ப்பு சிக்கல்களைத் தீர்க்க மொழிப் பொதியை மீண்டும் நிறுவவும்');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'tamil','மொழி பேக் வெற்றிகரமாக மீண்டும் நிறுவப்பட்டது');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'thai','สิ้นปีการเงิน');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'thai','ปีการเงิน');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'thai','วันที่เริ่มต้นปีงบการเงิน');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'thai','วันที่สิ้นสุดปีการเงิน');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'thai','สถานะกระบวนการสิ้นปี');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'thai','สิ้นปี ประมวลผลโดย');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'thai','ดำเนินการสิ้นปี');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'thai','งวดที่แล้วไม่ปิด! กรุณาปิดปีการเงินก่อนหน้าก่อนที่จะเพิ่มธุรกรรม');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'thai','ปีการเงินของธุรกรรมที่คุณพยายามลบปิดแล้ว!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'thai','คุณแน่ใจหรือว่าต้องการดำเนินการสิ้นปีนี้');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'thai','ประมวลผลสิ้นปีได้สำเร็จและยกยอดคงเหลือในบัญชีไปยังปีการเงินถัดไป');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'thai','เลือกผังหนี้สินหลักของบัญชี');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'thai','เลือกผังสินทรัพย์หลักของบัญชี');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'thai','เลือกผังบัญชีกำไรสะสม');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'thai','ไม่ได้กำหนดค่าผังการประมวลผลสิ้นปีการเงินของบัญชี');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'thai','ยอดคงเหลือต้นงวดที่มีอยู่');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'thai','เลือกผังบัญชีลูกหนี้การค้า');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'thai','เลือกผังค่าใช้จ่ายหลักของบัญชี');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'thai','นำเข้ายอดดุลยกมา');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'thai','เลือกไฟล์ Excel การเปิดยอดดุลเพื่อนำเข้าข้อมูล');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'thai','โหลดข้อมูล');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'thai','โหลดข้อมูลเพื่อนำเข้ายอดดุลยกมาเรียบร้อยแล้ว ตรวจสอบรายละเอียดยอดดุลแล้วบันทึกยอดดุลยกมา');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'thai','ข้อมูลมากเกินไปที่จะบันทึก! โปรดใช้คุณลักษณะการนำเข้ายอดคงเหลือเปิดเพื่ออัปเดตการเปลี่ยนแปลง');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'thai','โซลูชันการจัดการบัญชีออนไลน์ที่ดีที่สุดจาก Artifectx Solutions');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'thai','ติดตั้งชุดภาษาใหม่เพื่อแก้ไขปัญหาการแปลภาษา');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'thai','ติดตั้งชุดภาษาใหม่สำเร็จแล้ว');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'turkish','Mali Yıl Bitiyor');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'turkish','Mali yıl');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'turkish','Mali Yıl Başlangıç ​​Tarihi');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'turkish','Mali Yıl Bitiş Tarihi');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'turkish','Yıl Sonu İşlem Durumu');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'turkish','Yıl Sonu İşlenen');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'turkish','Süreç Yıl Sonu');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'turkish','Önceki mali yıl kapanmadı! Lütfen işlem eklemeden önce önceki mali yılı kapatın.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'turkish','Silmeye çalıştığınız işlemin mali yılı zaten kapalı!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'turkish','Yıl sonunu şimdi işlemek istediğinizden emin misiniz?');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'turkish','Yıl sonu başarıyla işlendi ve hesap bakiyeleri bir sonraki mali yıla aktarıldı.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'turkish','Ana borç hesap planını seçin');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'turkish','Ana varlıklar hesap planını seçin');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'turkish','Birikmiş kazançlar hesap planını seçin');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'turkish','Mali yıl sonu işleme hesap planı yapılandırılmamış');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'turkish','Mevcut Açılış Bakiyeleri');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'turkish','Ticari borçlu hesap planını seçin');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'turkish','Ana gider hesap planını seçin');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'turkish','İthalat Açılış Bakiyeleri');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'turkish','Verileri İçe Aktarmak İçin Bakiye Excel Dosyasını Açmayı Seçin');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'turkish','Veri yükle');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'turkish','Açılış bakiyelerini içe aktarmak için veriler başarıyla yüklendi. Bakiye ayrıntılarını gözden geçirin ve ardından açılış bakiyelerini kaydedin.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'turkish','Kaydedilecek çok fazla veri var! Değişiklikleri güncellemek için lütfen açılış bakiyesi içe aktarma özelliğini kullanın.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'turkish',"Artifectx Solutions'dan en iyi çevrimiçi muhasebe yönetimi çözümü.");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'turkish','Dil Çevirisi Sorunlarını Çözmek için Dil Paketini Yeniden Yükleyin');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'turkish','Dil paketi başarıyla yeniden yüklendi');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'ukrainian','Закінчується фінансовий рік');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'ukrainian','Фінансовий рік');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'ukrainian','Дата початку фінансового року');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'ukrainian','Дата закінчення фінансового року');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'ukrainian','Стан процесу в кінці року');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'ukrainian','Кінець року оброблено');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'ukrainian','Кінець робочого року');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'ukrainian','Попередній фінансовий рік не закритий! Будь ласка, закрийте попередній фінансовий рік перед додаванням транзакцій.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'ukrainian','Фінансовий рік транзакції, яку ви намагаєтесь видалити, уже закрито!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'ukrainian','Ви впевнені, що хочете обмежити кінець року зараз');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'ukrainian','Кінець року успішно оброблено, а залишки на рахунках перенесено на наступний фінансовий рік.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'ukrainian',"Виберіть план рахунків обліку зобов'язань батьків");
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'ukrainian','Виберіть план рахунків материнських активів');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'ukrainian','Виберіть план рахунків нерозподіленого прибутку');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'ukrainian','План рахунків обробки на кінець фінансового року не налаштований');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'ukrainian','Доступні залишки відкриття');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'ukrainian','Виберіть план рахунку торгового боржника');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'ukrainian','Виберіть схему рахунків батьківських витрат');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'ukrainian','Імпорт початкових залишків');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'ukrainian','Виберіть файл відкриття балансу Excel для імпорту даних');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'ukrainian','Завантажити дані');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'ukrainian','Дані успішно завантажено для імпорту початкового балансу. Оновіть дані балансу, а потім збережіть початкові залишки.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'ukrainian','Забагато даних для збереження! Будь ласка, використовуйте функцію імпорту початкового балансу, щоб оновити зміни.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'ukrainian','Найкраще рішення для ведення бухгалтерського обліку в Інтернеті від Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'ukrainian','Перевстановіть мовний пакет, щоб вирішити проблеми перекладу мови');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'ukrainian','Мовний пакет успішно перевстановлено');

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4085,'vietnamese','Kết thúc năm tài chính');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4086,'vietnamese','Năm tài chính');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4087,'vietnamese','Ngày bắt đầu năm tài chính');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4088,'vietnamese','Ngày kết thúc năm tài chính');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4089,'vietnamese','Trạng thái quy trình cuối năm');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4090,'vietnamese','Cuối năm được xử lý bởi');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4091,'vietnamese','Xử lý cuối năm');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4092,'vietnamese','Năm tài chính trước chưa đóng! Vui lòng đóng năm tài chính trước đó trước khi thêm giao dịch.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4093,'vietnamese','Năm tài chính của giao dịch bạn đang cố gắng xóa đã đóng!');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4094,'vietnamese','Bạn có chắc chắn muốn xử lý ngày cuối năm ngay bây giờ không');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4095,'vietnamese','Cuối năm được xử lý thành công và số dư tài khoản được chuyển sang năm tài chính tiếp theo.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4096,'vietnamese','Chọn biểu đồ nợ phải trả của tài khoản mẹ');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4097,'vietnamese','Chọn biểu đồ tài sản mẹ của tài khoản');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4098,'vietnamese','Chọn biểu đồ thu nhập giữ lại của tài khoản');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4099,'vietnamese','Biểu đồ xử lý cuối năm tài chính của các tài khoản không được định cấu hình');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4100,'vietnamese','Số dư đầu kỳ có sẵn');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4101,'vietnamese','Chọn biểu đồ tài khoản con nợ thương mại');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4102,'vietnamese','Chọn biểu đồ chi phí của tài khoản mẹ');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4103,'vietnamese','Nhập số dư đầu kỳ');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4104,'vietnamese','Chọn số dư mở tệp Excel để nhập dữ liệu');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4105,'vietnamese','Tải dữ liệu');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4106,'vietnamese','Dữ liệu được tải thành công để nhập số dư đầu kỳ. Xem lại chi tiết số dư và sau đó lưu số dư đầu kỳ.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4107,'vietnamese','Quá nhiều dữ liệu để tiết kiệm! Vui lòng sử dụng tính năng nhập số dư đầu kỳ để cập nhật các thay đổi.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4108,'vietnamese','Giải pháp quản lý kế toán trực tuyến tốt nhất từ ​​Artifectx Solutions.');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4109,'vietnamese','Cài đặt lại Gói ngôn ngữ để giải quyết các vấn đề về dịch ngôn ngữ');
INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(4110,'vietnamese','Gói ngôn ngữ đã được cài đặt lại thành công');

DELETE FROM `system_language_strings` WHERE `language_string_id` = '3510';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3501';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3502';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3508';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3509';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3506';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3507';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3503';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3505';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3533';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3537';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3524';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3525';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3531';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3515';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3532';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3534';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3511';
DELETE FROM `system_language_strings` WHERE `language_string_id` = '3528';

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(3513,'English','Translation Generation is Pending');