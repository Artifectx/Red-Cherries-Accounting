
/*Update version number*/
UPDATE `system_common_configurations` SET `config_filed_value` =  '1.3' WHERE id = 1;
UPDATE `system_common_configurations` SET `config_filed_value` =  '10.0 Beta 7' WHERE id = 2;

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