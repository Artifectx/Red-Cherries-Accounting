
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions` VALUES 
(504, 152, 'View', 'STM_Sales_View_Cashier_Turn_Details_Permissions', 'View Cashier Turn Details');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT INTO `urm_user_roles_default_user_role_permissions` VALUES 
(1, 504),

(2, 504);

/*Data for the table `urm_user_roles_permissions` */
INSERT  INTO `urm_user_roles_permissions` (`permission_id`, `module_section_feature_id`, `permission_type`, `permission`, `permission_description`) VALUES
(505, 153, 'Add', 'OGM_Admin_Add_External_Institute_Permissions', 'Add External Institute'),
(506, 153, 'Edit', 'OGM_Admin_Edit_External_Institute_Permissions', 'Edit External Institute'),
(507, 153, 'Delete', 'OGM_Admin_Delete_External_Institute_Permissions', 'Delete External Institute'),
(508, 153, 'View', 'OGM_Admin_View_External_Institute_Permissions', 'View External Institute');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,505),
(1,506),
(1,507),
(1,508),

(2,505),
(2,506),
(2,507),
(2,508);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(509, 19, 'Advanced', 'OGM_Admin_View_Worker_Advanced_List', 'Allow to View Worker List');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(76, 509);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 509),

(2, 509),

(3, 509);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(510, 158, 'View', 'SVM_PMSLTLD_View_Module_Permissions', 'View PMSL TLD Card Manager Module'),

(511, 154, 'Edit', 'SVM_PMSLTLD_Admin_Edit_Manage_TLD_Permissions', 'Edit TLDs'),
(512, 154, 'View', 'SVM_PMSLTLD_Admin_View_Manage_TLD_Permissions', 'View TLDs'),

(513, 155, 'Add', 'SVM_PMSLTLD_TLDRentals_Add_Distribute_TLDs_Permissions', 'Add TLD Distributions'),
(514, 155, 'Edit', 'SVM_PMSLTLD_TLDRentals_Edit_Distribute_TLDs_Permissions', 'Edit TLD Distributions'),
(515, 155, 'Delete', 'SVM_PMSLTLD_TLDRentals_Delete_Distribute_TLDs_Permissions', 'Delete TLD Distributions'),
(516, 155, 'View', 'SVM_PMSLTLD_TLDRentals_View_Distribute_TLDs_Permissions', 'View TLD Distributions'),

(517, 156, 'Add', 'SVM_PMSLTLD_TLDRentals_Add_Collect_TLD_Returns_Permissions', 'Add Collect TLD Returns'),
(518, 156, 'Edit', 'SVM_PMSLTLD_TLDRentals_Edit_Collect_TLD_Returns_Permissions', 'Edit Collect TLD Returns'),
(519, 156, 'Delete', 'SVM_PMSLTLD_TLDRentals_Delete_Collect_TLD_Returns_Permissions', 'Delete Collect TLD Returns'),
(520, 156, 'View', 'SVM_PMSLTLD_TLDRentals_View_Collect_TLD_Returns_Permissions', 'View Collect TLD Returns'),

(521, 157, 'View', 'SVM_PMSLTLD_Reports_View_PMSL_Report_Permissions', 'View PMSL Reports'),

(522, 159, 'Add', 'SVM_PMSLTLD_Admin_Add_Import_Tld_Readings_Permissions', 'Add TLD Readings'),
(523, 159, 'Add', 'SVM_PMSLTLD_Admin_Delete_Import_Tld_Readings_Permissions', 'Delete TLD Readings'),
(524, 159, 'View', 'SVM_PMSLTLD_Admin_View_Import_Tld_Readings_Permissions', 'View TLD Readings'),

(525, 160, 'Add', 'SVM_PMSLTLD_TLDRentals_Add_TLD_Invoices_Permissions', 'Add TLD Invoices'),
(526, 160, 'Edit', 'SVM_PMSLTLD_TLDRentals_Edit_TLD_Invoices_Permissions', 'Edit TLD Invoices'),
(527, 160, 'Delete', 'SVM_PMSLTLD_TLDRentals_Delete_TLD_Invoices_Permissions', 'Delete TLD Invoices'),
(528, 160, 'View', 'SVM_PMSLTLD_TLDRentals_View_TLD_Invoices_Permissions', 'View TLD Invoices'),

(529, 161, 'View', 'SVM_PMSLTLD_TLDRentals_View_Dose_Reports_Permissions', 'View Dose Reports'),
(530, 162, 'View', 'SVM_PMSLTLD_TLDRentals_View_Not_Returned_TLD_Permissions', 'View Not Returned TLDs');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 510),
(2, 510),

(1, 511),
(1, 512),

(2, 511),
(2, 512),

(1, 513),
(1, 514),
(1, 515),
(1, 516),

(2, 513),
(2, 514),
(2, 515),
(2, 516),

(1, 517),
(1, 518),
(1, 519),
(1, 520),

(2, 517),
(2, 518),
(2, 519),
(2, 520),

(1, 521),
(2, 521),

(1, 522),
(1, 523),
(1, 524),

(2, 522),
(2, 523),
(2, 524),

(1, 525),
(1, 526),
(1, 527),
(1, 528),

(2, 525),
(2, 526),
(2, 527),
(2, 528),

(1, 529),

(2, 529),

(1, 530),

(2, 530);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(531, 167, 'View', 'SVM_Apartment_Complex_View_Module_Permissions', 'View Apartment Complex Manager Module'),

(532, 163, 'Edit', 'SVM_Apartment_Complex_Admin_Edit_System_Configurations_Permissions', 'Edit System Configurations'),
(533, 163, 'View', 'SVM_Apartment_Complex_Admin_View_System_Configurations_Permissions', 'View System Configurations'),

(534, 164, 'Add', 'SVM_Apartment_Complex_Admin_Add_Apartment_Complex_Bill_Permissions', 'Add Apartment Complex Bills'),
(535, 164, 'Edit', 'SVM_Apartment_Complex_Admin_Edit_Apartment_Complex_Bill_Permissions', 'Edit Apartment Complex Bills'),
(536, 164, 'Delete', 'SVM_Apartment_Complex_Admin_Delete_Apartment_Complex_Bill_Permissions', 'Delete Apartment Complex Bills'),
(537, 164, 'View', 'SVM_Apartment_Complex_Admin_View_Apartment_Complex_Bill_Permissions', 'View Apartment Complex Bills'),

(538, 165, 'Add', 'SVM_Apartment_Complex_Resident_Payments_Add_Resident_Bill_Payments_Permissions', 'Add Resident Bill Payments'),
(539, 165, 'Edit', 'SVM_Apartment_Complex_Resident_Payments_Edit_Resident_Bill_Payments_Permissions', 'Edit Resident Bill Payments'),
(540, 165, 'Delete', 'SVM_Apartment_Complex_Resident_Payments_Delete_Resident_Bill_Payments_Permissions', 'Delete Resident Bill Payments'),
(541, 165, 'View', 'SVM_Apartment_Complex_Resident_Payments_View_Resident_Bill_Payments_Permissions', 'View Resident Bill Payments'),

(542, 166, 'View', 'SVM_Apartment_Complex_Reports_View_Bill_Payments_Reports_Permissions', 'View Bill Payment Reports');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 531),
(2, 531),

(1, 532),
(1, 533),

(2, 532),
(2, 533),

(1, 534),
(1, 535),
(1, 536),
(1, 537),

(2, 534),
(2, 535),
(2, 536),
(2, 537),

(1, 538),
(1, 539),
(1, 540),
(1, 541),

(2, 538),
(2, 539),
(2, 540),
(2, 541),

(1, 542),
(2, 542);