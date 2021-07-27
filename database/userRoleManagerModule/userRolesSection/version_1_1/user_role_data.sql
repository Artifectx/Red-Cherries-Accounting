
/*From ERP Version 9.0 Beta 1 */
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`, `module_section_feature_id`, `permission_type`, `permission`, `permission_description`) VALUES
(543, 158, 'View', 'SVM_PMSLTLD_Admin_View_System_Configurations_Permissions', 'View System Configurations'),
(544, 158, 'Edit', 'SVM_PMSLTLD_Admin_Edit_System_Configurations_Permissions', 'Edit System Configurations');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,543),
(1,544),

(2,543),
(2,544);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(545, 38, 'Advanced', 'STM_Sales_Reports_Customer_Purchase_Points_Report_Permissions', 'View Customer Purchase Points Report');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(186, 545);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 545),

(2, 545),

(3, 545);

/*From ERP Version 9.0 Beta 3 */
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(546, 38, 'Advanced', 'STM_Sales_Reports_Cashier_Cash_Varience_Report_Permissions', 'View Cashier Cash Varience Report');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(186, 546);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 546),

(2, 546),

(3, 546);

/*From ERP Version 9.0 Beta 4 */
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES 
(547, 39, 'Advanced', 'STM_POS_Sales_Invoice_Cash_Refund_Permissions', 'Allow Cash Refund for POS Sales Invoice');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(181, 547);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 547),

(2, 547),

(3, 547);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES 
(548, 39, 'Advanced', 'STM_POS_Sales_Invoice_Credit_Refund_Permissions', 'Allow Credit Refund for POS Sales Invoice');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(181, 548);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 548),

(2, 548),

(3, 548);

/*From ERP Version 9.0 Beta 9 */
DELETE FROM `urm_user_roles_permissions` WHERE `permission_id` = '523';
DELETE FROM `urm_user_roles_default_user_role_permissions` WHERE `permission_id` = '523';

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(549, 168, 'View', 'SVM_PMSLTLD_Admin_View_Tld_Readings_Permissions', 'View TLD Readings'),
(550, 162, 'View', 'SVM_PMSLTLD_TLDRentals_Delete_Not_Returned_TLD_Permissions', 'Delete Not Returned TLDs');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 549),
(2, 549),

(1, 550),
(2, 550);

/*From ERP Version 9.0 Beta 14 */
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(551, 169, 'View', 'SVM_PMSLTLD_Admin_View_Tld_Reader_Machine_Permissions', 'View TLD Reader Machines');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 551),

(2, 551);

/*From ERP Version 9.0 Beta 16 */
/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features` (`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(170, 29, 'PMSL TLD Card Manager Dashboard', 'Yes');

INSERT  INTO `urm_user_roles_permissions` (`permission_id`, `module_section_feature_id`, `permission_type`, `permission`, `permission_description`) VALUES
(552, 170, 'View', 'SVM_PMSLTLD_Admin_View_Dashboard_Permissions', 'View Dashboard');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,552),
(2,552);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(553, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Summary_of_TLD_Information_Permissions', 'View Summary of TLD Information'),
(554, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLD_Return_Pending_Distributions_Permissions', 'View TLD Return Pending Distributions'),
(555, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLD_Reading_Pending_TLD_Returns_Permissions', 'View TLD Reading Pending TLD Returns'),
(556, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Pending_Dose_Report_Generations_Permissions', 'View Pending Dose Report Generations'),
(557, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Pending_Invoice_Generations_Permissions', 'View Pending Invoice Generations'),
(558, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLD_Returns_Pending_After_Third_Reminder_Letter_Permissions', 'View TLD Returns Pending After Third Reminder Letter'),
(559, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Not_Returned_TLD_Information_Permissions', 'View Not Returned TLD Information'),
(560, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Dose_Report_Generation_Count_of_Users_Permissions', 'View Dose Report Generation Count of Users'),
(561, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLD_Reading_Count_Information_Permissions', 'View TLD Reading Count Information'),
(562, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Invoice_Generation_Count_of_Users_Permissions', 'View Invoice Generation Count of Users'),
(563, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLD_Rental_Service_Income_Chart_Permissions', 'View TLD Rental Service Income Chart'),
(564, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLDs_Sold_Within_a_Time_Period_Permissions', 'View TLDs Sold Within a Time Period'),
(565, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Dose_Report_Taken_Success_Rate_of_External_Institutes_Permissions', 'View Dose Report Taken Success Rate of External Institutes');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(552, 553),
(552, 554),
(552, 555),
(552, 556),
(552, 557),
(552, 558),
(552, 559),
(552, 560),
(552, 561),
(552, 562),
(552, 563),
(552, 564),
(552, 565);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 553),
(1, 554),
(1, 555),
(1, 556),
(1, 557),
(1, 558),
(1, 559),
(1, 560),
(1, 561),
(1, 562),
(1, 563),
(1, 564),
(1, 565),

(2, 553),
(2, 554),
(2, 555),
(2, 556),
(2, 557),
(2, 558),
(2, 559),
(2, 560),
(2, 561),
(2, 562),
(2, 563),
(2, 564),
(2, 565);

/*From ERP Version 9.0 Beta 18 */
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(566, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Service_Status_Permissions', 'View Service Status Information'),
(567, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_User_Service_Performance_Permissions', 'View User Service Performance'),
(568, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Institute_Summary_Permissions', 'View Institute Summary'),
(569, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLD_Card_Summary_Information_Permissions', 'View TLD Card Summary'),
(570, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLD_Extremity_Summary_Information_Permissions', 'View TLD Extremity Summary');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(552, 566),
(552, 567),
(552, 568),
(552, 569),
(552, 570);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 566),
(1, 567),
(1, 568),
(1, 569),
(1, 570),

(2, 566),
(2, 567),
(2, 568),
(2, 569),
(2, 570);

DELETE FROM `urm_user_roles_permissions` WHERE `permission_id`='560';
DELETE FROM `urm_user_roles_permissions_advanced` WHERE `child_permission_id`='560';
DELETE FROM `urm_user_roles_default_user_role_permissions` WHERE `permission_id`='560';

DELETE FROM `urm_user_roles_permissions` WHERE `permission_id`='562';
DELETE FROM `urm_user_roles_permissions_advanced` WHERE `child_permission_id`='562';
DELETE FROM `urm_user_roles_default_user_role_permissions` WHERE `permission_id`='562';

/*From ERP Version 9.0 Beta 19 */
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(571, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_Summary_of_Not_Used_TLD_Information_Permissions', 'View Not Used TLD Card Summary'),
(572, 170, 'Advanced', 'SVM_PMSLTLD_Dashboard_View_TLDs_Sales_Income_Within_a_Time_Period_Permissions', 'View TLD Sales Income Within a Time Period');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(552, 571),
(552, 572);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 571),
(1, 572),

(2, 571),
(2, 572);

/*From ERP Version 10.0 Beta 1 */
/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features` (`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(171, 30, 'TLD Distribution Dispatch', 'Yes'),
(172, 30, 'Receive TLD Return', 'Yes');

/*Data for the table `urm_user_roles_permissions` */
INSERT  INTO `urm_user_roles_permissions` (`permission_id`, `module_section_feature_id`, `permission_type`, `permission`, `permission_description`) VALUES
(573, 171, 'Add', 'SVM_PMSLTLD_TLDRentals_Add_Distribute_Dispatch_Permissions', 'Add TLD Distribution Dispatch'),
(574, 171, 'Edit', 'SVM_PMSLTLD_TLDRentals_Edit_Distribute_Dispatch_Permissions', 'Edit TLD Distribution Dispatch'),
(575, 171, 'Delete', 'SVM_PMSLTLD_TLDRentals_Delete_Distribute_Dispatch_Permissions', 'Delete TLD Distribution Dispatch'),
(576, 171, 'View', 'SVM_PMSLTLD_TLDRentals_View_Distribute_Dispatch_Permissions', 'View TLD Distribution Dispatch'),

(577, 172, 'Add', 'SVM_PMSLTLD_TLDRentals_Add_Collect_TLD_Returns_Receive_Permissions', 'Add Receive TLD Return'),
(578, 172, 'Edit', 'SVM_PMSLTLD_TLDRentals_Edit_Collect_TLD_Returns_Receive_Permissions', 'Edit Receive TLD Return'),
(579, 172, 'Delete', 'SVM_PMSLTLD_TLDRentals_Delete_Collect_TLD_Returns_Receive_Permissions', 'Delete Receive TLD Return'),
(580, 172, 'View', 'SVM_PMSLTLD_TLDRentals_View_Collect_TLD_Returns_Receive_Permissions', 'View Receive TLD Return');

INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,573),
(1,574),
(1,575),
(1,576),

(2,573),
(2,574),
(2,575),
(2,576),

(1,577),
(1,578),
(1,579),
(1,580),

(2,577),
(2,578),
(2,579),
(2,580);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES 
(581, 154, 'Advanced', 'SVM_PMSLTLD_Admin_Manage_TLD_Update_TLD_Purpose_Permissions', 'Allow to Update TLD Purpose in Manage TLD'),
(582, 154, 'Advanced', 'SVM_PMSLTLD_Admin_Manage_TLD_Update_TLD_Status_Permissions', 'Allow to Update TLD Status in Manage TLD');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(511, 581),
(511, 582);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 581),
(1, 582),

(2, 581),
(2, 582),

(3, 581),
(3, 582);

/*From ERP Version 10.0 Beta 2 */
/*Data for the table `system_module_section_features` */
INSERT  INTO `system_module_section_features` (`module_section_feature_id`, `module_section_id`, `module_section_feature_name`, `showing_status`) VALUES
(173, 7, 'Financial Year Ends', 'Yes');

/*Data for the table `urm_user_roles_permissions` */
INSERT  INTO `urm_user_roles_permissions` (`permission_id`, `module_section_feature_id`, `permission_type`, `permission`, `permission_description`) VALUES
(583, 173, 'Edit', 'ACM_Admin_Edit_Financial_Year_Ends_Permissions', 'Edit Financial Year Ends'),
(584, 173, 'View', 'ACM_Admin_View_Financial_Year_Ends_Permissions', 'View Financial Year Ends');

INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,583),
(1,584),

(2,583),
(2,584),

(3,583),
(3,584);