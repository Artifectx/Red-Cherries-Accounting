
/*Update version number*/
UPDATE `system_common_configurations` SET `config_filed_value` =  '1.2' WHERE id = 1;
UPDATE `system_common_configurations` SET `config_filed_value` =  '10.0 Beta 6' WHERE id = 2;

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('The financial year of the transaction you are trying to edit is already closed!', 'message', '7', 'Journal Entries Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','The financial year of the transaction you are trying to edit is already closed!');

DELETE FROM `system_language_strings` WHERE `language_string` = 'TLD Distribution Dispatches';
DELETE FROM `system_language_translations` WHERE `translated_string` = 'TLD Distribution Dispatches';
UPDATE `system_language_strings` SET `language_string` = 'PMSL Dispatches' WHERE `language_string` = 'TLD Distribution Dispatch';
UPDATE `system_language_translations` SET `translated_string` = 'PMSL Dispatches' WHERE `translated_string` = 'TLD Distribution Dispatch';
UPDATE `system_language_strings` SET `language_string` = 'PMSL Dispatch Details' WHERE `language_string` = 'TLD Distribution Dispatch Details';
UPDATE `system_language_translations` SET `translated_string` = 'PMSL Dispatch Details' WHERE `translated_string` = 'TLD Distribution Dispatch Details';
UPDATE `system_language_strings` SET `language_string` = 'Add New PMSL Dispatch' WHERE `language_string_id` = 'Add New TLD Distribution Dispatch';
UPDATE `system_language_translations` SET `translated_string` = 'Add New PMSL Dispatch' WHERE `translated_string` = 'Add New TLD Distribution Dispatch';
UPDATE `system_language_strings` SET `language_string` = 'pmsl dispatch' WHERE `language_string_id` = 'distribution dispatch';
UPDATE `system_language_translations` SET `translated_string` = 'pmsl dispatch' WHERE `translated_string` = 'distribution dispatch';
UPDATE `system_language_strings` SET `language_string` = 'Search PMSL Dispatches' WHERE `language_string_id` = 'Search TLD Distribution Dispatches';
UPDATE `system_language_translations` SET `translated_string` = 'Search PMSL Dispatches' WHERE `translated_string` = 'Search TLD Distribution Dispatches';

UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'TLD Distribution Dispatch';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'TLD Distribution Dispatch Details';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'Add New TLD Distribution Dispatch';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'Dispatch No';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'Dispatch Date';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'Dispatch Method';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'Dispatch Reference';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'distribution dispatch';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Dispatch Screen' WHERE `language_string` = 'Search TLD Distribution Dispatches';

DELETE FROM `system_language_strings` WHERE `language_string_id` = 'Receive TLD Returns';
DELETE FROM `system_language_translations` WHERE `translated_string` = 'Receive TLD Returns';
UPDATE `system_language_strings` SET `language_string` = 'PMSL Collections' WHERE `language_string` = 'Receive TLD Returns';
UPDATE `system_language_translations` SET `translated_string` = 'PMSL Collections' WHERE `translated_string` = 'Receive TLD Returns';
UPDATE `system_language_strings` SET `language_string` = 'PMSL Collection Details' WHERE `language_string` = 'Receive TLD Return Details';
UPDATE `system_language_translations` SET `translated_string` = 'PMSL Collection Details' WHERE `translated_string` = 'Receive TLD Return Details';
UPDATE `system_language_strings` SET `language_string` = 'Add New PMSL Collection' WHERE `language_string` = 'Add New Receive TLD Return';
UPDATE `system_language_translations` SET `translated_string` = 'Add New PMSL Collection' WHERE `translated_string` = 'Add New Receive TLD Return';
UPDATE `system_language_strings` SET `language_string` = 'pmsl collection' WHERE `language_string` = 'receive TLD return';
UPDATE `system_language_translations` SET `translated_string` = 'pmsl collection' WHERE `translated_string` = 'receive TLD return';
UPDATE `system_language_strings` SET `language_string` = 'Search PMSL Collections' WHERE `language_string` = 'Search Receive TLD Returns';
UPDATE `system_language_translations` SET `translated_string` = 'Search PMSL Collections' WHERE `translated_string` = 'Search Receive TLD Returns';

UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Receive TLD Returns';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Receive TLD Return Details';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Add New Receive TLD Return';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Receive No';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Receive Date';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Receive Method';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Receive Reference';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'receive TLD return';
UPDATE `system_language_strings` SET `screen_name` = 'PMSL Collection Screen' WHERE `language_string` = 'Search Receive TLD Returns';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatch Type', 'display_string', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatch Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Dispatch', 'display_string', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Dispatch');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatch Period', 'display_string', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatch Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Already added', 'display_string', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Already added');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Period', 'display_string', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatched TLD Distribution', 'display_string', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatched TLD Distribution');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dispatched Dose Report', 'display_string', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dispatched Dose Report');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Selecting a TLD distribution or a dose report is mandatory to complete the dispatch', 'message', '6', 'PMSL Dispatch Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Selecting a TLD distribution or a dose report is mandatory to complete the dispatch');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Period', 'display_string', '6', 'PMSL Collection Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Number of Cards', 'display_string', '6', 'PMSL Collection Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Number of Cards');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Received Credit Payment Amount', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Received Credit Payment Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Partial Payment', 'display_string', '1', 'Welfare Company Credit Accounts Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Partial Payment');

UPDATE `system_language_strings` SET `language_string` = 'Bulk Print Dose Report Envelopes (A5)' WHERE `language_string` = 'Bulk Print Dose Report Envelopes (A4)';
UPDATE `system_language_translations` SET `translated_string` = 'Bulk Print Dose Report Envelopes (A5)' WHERE `translated_string` = 'Bulk Print Dose Report Envelopes (A4)';

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report Discarded', 'display_string', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report Discarded');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report as discarded', 'message', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report as discarded');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report successfully discarded', 'message', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report successfully discarded');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report as not discarded', 'message', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report as not discarded');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dose Report successfully marked as not discarded', 'message', '6', 'Dose Reports Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dose Report successfully marked as not discarded');