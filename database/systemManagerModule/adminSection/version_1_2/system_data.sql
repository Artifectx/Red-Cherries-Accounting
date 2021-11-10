
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

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('ogm_people_hide_student_list', 'No');

/*Data for the table `system_module_section_features` */
INSERT INTO `system_module_section_features` (`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(174, 28, 'Leave Rules', 'Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Leave Rules', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Leave Rules');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Leave Rule Details', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Leave Rule Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Leave Type', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Leave Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Entitlement Rules', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Entitlement Rules');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Apply Restriction Rules', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Apply Restriction Rules');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Eligible Job Categories', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Eligible Job Categories');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Eligible Departments', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Eligible Departments');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Eligible Job Titles', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Eligible Job Titles');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Eligible Employment Statuses', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Eligible Employment Statuses');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Accrual Available', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Accrual Available');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Carry Forward to Next Leave Period Available', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Carry Forward to Next Leave Period Available');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Maximum Allowed Carry Forward Leave Amount', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Maximum Allowed Carry Forward Leave Amount');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Eligible If Available Dependants', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Eligible If Available Dependants');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Entitlement Start Point', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Entitlement Start Point');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Direct Supervisor Can Assign Leave', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Direct Supervisor Can Assign Leave');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Direct Supervisor Can Approve Leave', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Direct Supervisor Can Approve Leave');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Indirect Supervisor Can Assign Leave', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Indirect Supervisor Can Assign Leave');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Indirect Supervisor Can Approve Leave', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Indirect Supervisor Can Approve Leave');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Admin Can Assign Leave', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Admin Can Assign Leave');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Admin Can Approve Leave', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Admin Can Approve Leave');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Carried Forward Leave Should Apply First', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Carried Forward Leave Should Apply First');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Carried Forward Leave Validity Period', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Carried Forward Leave Validity Period');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Consecutive Leave Days Allowed', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Consecutive Leave Days Allowed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Maximum Consecutive Leave Days Allowed', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Maximum Consecutive Leave Days Allowed');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Allow Apply Above Leave Balance', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Allow Apply Above Leave Balance');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assign Automatically When There Are No Attendance Records for a Working Day Which Has a Working Shift Assigned', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assign Automatically When There Are No Attendance Records for a Working Day Which Has a Working Shift Assigned');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Proof Document Required', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Proof Document Required');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Proof Document Mandatory Apply Threshold', 'display_string', '4', 'Leave Rules Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Proof Document Mandatory Apply Threshold');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide Student List', 'display_string', '1', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide Student List');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Grade', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Grade');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Class', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Class');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Guardian Name', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Guardian Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Guardian Phone No', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Guardian Phone No');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Deactivate the Supplier', 'display_string', '1', 'People Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Deactivate the Supplier');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Import Student Information', 'display_string', '1', 'Data Import Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Import Student Information');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Leave type code is already in use', 'message', '4', 'Leave Types Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Leave type code is already in use');

INSERT INTO `system_common_configurations`(`config_filed_name`, `config_filed_value`) VALUES
('enable_school_manager_subject_buckets_feature', 'No'),
('enable_school_manager_male_female_class_monitor_feature', 'No'),
('fg_reinitiallize_product_search_upon_editing_product_data', 'No');

/*Data for the table `system_module_sections` */
INSERT  INTO `system_module_sections`(`module_section_name`,`module_section_status`,`status_change_option`,`system_module_id` ,`system_sub_module_id`) VALUES
('Academics', 1, 0, 6, 2),
('Reports', 1, 0, 6, 2);

/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features`(`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(176, 20, 'Grades', 'Yes'),
(177, 20, 'Teaching Mediums', 'Yes'),
(178, 20, 'Main Subjects', 'Yes'),
(179, 20, 'Subject Buckets', 'Yes'),
(180, 20, 'Bucket Subjects', 'Yes'),
(181, 20, 'System Configurations', 'Yes'),
(182, 35, 'Classes', 'Yes'),
(183, 36, 'Academic Reports', 'Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('School Manager Dashboard', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','School Manager Dashboard');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Dashboard - School Manager', 'display_string', '6', '');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Dashboard - School Manager');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Grades', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Grades');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Teaching Mediums', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Teaching Mediums');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Subjects', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Subjects');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Buckets', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Buckets');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bucket Subjects', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bucket Subjects');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Academic Details', 'display_string', '6', '');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Academic Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Classes', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Classes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Academic Reports', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Academic Reports');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Grade Details', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Grade Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Grade Code', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Grade Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Grade Name', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Grade Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Grade', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Grade');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('grade details', 'message', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','grade details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add Classes', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add Classes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Class Details', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Class Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Class Code', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Class Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Class Name', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Class Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Class', 'display_string', '6', 'Grades Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Class');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Teaching Medium Details', 'display_string', '6', 'Teaching Mediums Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Teaching Medium Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Teaching Medium', 'display_string', '6', 'Teaching Mediums Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Teaching Medium');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Teaching Medium', 'display_string', '6', 'Teaching Mediums Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Teaching Medium');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('teaching medium', 'message', '6', 'Teaching Mediums Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','teaching medium');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Subject Details', 'display_string', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Subject Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Subject Code', 'display_string', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Subject Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Subject Name', 'display_string', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Subject Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Main Subject', 'display_string', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Main Subject');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('main subject', 'message', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','main subject');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Available Grades', 'display_string', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Available Grades');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Available Teaching Mediums', 'display_string', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Available Teaching Mediums');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Please select at least one grade.', 'message', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please select at least one grade.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Please select at least one teaching medium.', 'message', '6', 'Main Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Please select at least one teaching medium.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Bucket Details', 'display_string', '6', 'Subject Buckets Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Bucket Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Bucket Code', 'display_string', '6', 'Subject Buckets Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Bucket Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Bucket Name', 'display_string', '6', 'Subject Buckets Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Bucket Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Subject Bucket', 'display_string', '6', 'Subject Buckets Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Subject Bucket');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('subject bucket details', 'message', '6', 'Subject Buckets Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','subject bucket details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Bucket', 'display_string', '6', 'Subject Buckets Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Bucket');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bucket Subject Details', 'display_string', '6', 'Bucket Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bucket Subject Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bucket Subject Code', 'display_string', '6', 'Bucket Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bucket Subject Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bucket Subject Name', 'display_string', '6', 'Bucket Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bucket Subject Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Bucket Subject', 'display_string', '6', 'Bucket Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Bucket Subject');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('bucket subject details', 'message', '6', 'Bucket Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','bucket subject details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bucket Subject', 'display_string', '6', 'Bucket Subjects Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bucket Subject');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to mark the TLD return status as pending', 'message', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to mark the TLD return status as pending');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reset TLD Selection', 'display_string', '6', 'Collect TLD Returns Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reset TLD Selection');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Are you sure you want to mark the TLD distribution status as pending', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Are you sure you want to mark the TLD distribution status as pending');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Import Grade Information', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Import Grade Information');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Import Class Information', 'message', '6', 'Distribute TLDs Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Import Class Information');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Subject', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Subject');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Medium', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Medium');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Bucket', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Bucket');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bucket Subject', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bucket Subject');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Classes Detail', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Classes Detail');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Search Classes', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Search Classes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Medium Bulk Update', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Medium Bulk Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Bucket Subject Bulk Update', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Bucket Subject Bulk Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Subject Bulk Update', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Subject Bulk Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Students for Main Subject Bulk Update', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Students for Main Subject Bulk Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Save Main Subject Data', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Save Main Subject Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Students for Medium Bulk Update', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Students for Medium Bulk Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Save Medium Data', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Save Medium Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Code', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Students for Bucket Subject Bulk Update', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Students for Bucket Subject Bulk Update');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Save Bulk Subject Data', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Save Bulk Subject Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Head Class Teacher', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Head Class Teacher');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assistant Class Teacher', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assistant Class Teacher');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Class Monitor', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Class Monitor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assistant Class Monitor', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assistant Class Monitor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Male Class Monitor', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Male Class Monitor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Female Class Monitor', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Female Class Monitor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assistant Male Class Monitor', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assistant Male Class Monitor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assistant Female Class Monitor', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assistant Female Class Monitor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Hide', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Hide');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Students', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Students');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Enable Subject Buckets Feature', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Enable Subject Buckets Feature');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Enable Male and Female Class Monitor Feature', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Enable Male and Female Class Monitor Feature');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Reinitiallize Product Search Upon Editing Product Data', 'display_string', '2', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Reinitiallize Product Search Upon Editing Product Data');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Head Class Teacher and Assistant Class Teacher are same.', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Head Class Teacher and Assistant Class Teacher are same.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Class Monitor and Assistant Class Monitor are same.', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Class Monitor and Assistant Class Monitor are same.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Male Class Monitor and Assistant Male Class Monitor are same.', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Male Class Monitor and Assistant Male Class Monitor are same.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Female Class Monitor and Assistant Female Class Monitor are same.', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Female Class Monitor and Assistant Female Class Monitor are same.');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Monitor', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Monitor');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Identification Number', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Identification Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Admission Number', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Admission Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Date of Admission', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Date of Admission');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Profile', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Profile');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Academic Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Academic Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Athletic Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Athletic Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Previous School', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Previous School');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Previous School Admission Number', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Previous School Admission Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Full Name', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Full Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Guardian Email', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Guardian Email');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Guardian Address', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Guardian Address');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Junior Prefect', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Junior Prefect');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Senior Prefect', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Senior Prefect');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Prefect', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Prefect');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Head Prefect', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Head Prefect');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('End Date', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','End Date');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('History', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','History');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Prefect History Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Prefect History Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Prefect Type', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Prefect Type');

/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features`(`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(184, 20, 'Athletics Events', 'Yes');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Events', 'display_string', '6', 'Menus');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Events');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Event Details', 'display_string', '6', 'Athletics Events Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Event Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Event Code', 'display_string', '6', 'Athletics Events Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Event Code');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Event Name', 'display_string', '6', 'Athletics Events Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Event Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Athletics Event', 'display_string', '6', 'Athletics Events Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Athletics Event');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('athletics event details', 'message', '6', 'Athletics Events Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','athletics event details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Event', 'display_string', '6', 'Athletics Events Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Event');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('House', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','House');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athlete', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athlete');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Prefect', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Prefect');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Prefect History Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Prefect History Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Main Events', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Main Events');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Other Events', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Other Events');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Event already selected as a main event for the student!', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Event already selected as a main event for the student!');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Athletics Achievements', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Athletics Achievements');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Athletics Achievement Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Athletics Achievement Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Talent', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Talent');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Achievement', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Achievement');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Athletics Achievements - Main Event', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Athletics Achievements - Main Event');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Athletics Achievements - Other Event', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Athletics Achievements - Other Event');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Event Type of Student', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Event Type of Student');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Athletics Achievement', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Athletics Achievement');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assessments', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assessments');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Term Tests', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Term Tests');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('General Examinations', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','General Examinations');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Assessment Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Assessment Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assessment Name', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assessment Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Marks', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Marks');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Assessment', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Assessment');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Type', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Type');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Assessment details', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Assessment details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student Term Test Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student Term Test Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Term', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Term');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New Term Test', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New Term Test');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Term Test details', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Term Test details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('General Examinations List', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','General Examinations List');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('General Examination Name', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','General Examination Name');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Wise Results Available', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Wise Results Available');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('District Rank Available', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','District Rank Available');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Island Rank Available', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Island Rank Available');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Z Score Available', 'display_string', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Z Score Available');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('General Examination', 'message', '6', 'System Configurations Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','General Examination');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student General Examination Details', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student General Examination Details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add General Examination Results', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add General Examination Results');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('District Rank', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','District Rank');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Island Rank', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Island Rank');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Z Score', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Z Score');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('School Number', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','School Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Center Number', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Center Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Index Number', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Index Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('General Examination details', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','General Examination details');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student General Examination Subject Results', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student General Examination Subject Results');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Student General Examination Subject Results Detail', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Student General Examination Subject Results Detail');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Subject Number', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Subject Number');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Symbol', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Symbol');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('Add New General Examination Subject Result', 'display_string', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','Add New General Examination Subject Result');

/*Data for the table `system_language_strings` */
INSERT INTO `system_language_strings`(`language_string`,`language_string_type`,`system_module_id`,`screen_name`) VALUES
('General Examination Result details', 'message', '6', 'Classes Screen');

SET @languageStringId = LAST_INSERT_ID();

INSERT INTO `system_language_translations`(`language_string_id`,`language_name`,`translated_string`) VALUES
(@languageStringId,'English','General Examination Result details');