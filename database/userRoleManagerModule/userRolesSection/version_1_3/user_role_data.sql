
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(630,81, 'Advanced', 'HRM_Pim_Edit_Supervisor_Details_Permissions', 'Edit Supervisor Details'),
(631,81, 'Advanced', 'HRM_Pim_View_Supervisor_Details_Permissions', 'View Supervisor Details'),
(632,81, 'Advanced', 'HRM_Pim_Delete_Supervisor_Details_Permissions', 'Delete Supervisor Details');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(250,630),
(250,631),
(250,632);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,630),
(1,631),
(1,632),

(2,630),
(2,631),
(2,632);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(633, 185, 'Add', 'HRM_Admin_Add_Workflow_Permissions', 'Add Workflows'),
(634, 185, 'Edit', 'HRM_Admin_Edit_Workflow_Permissions', 'Edit Workflows'),
(635, 185, 'Delete', 'HRM_Admin_Delete_Workflow_Permissions', 'Delete Workflows'),
(636, 185, 'View', 'HRM_Admin_View_Workflow_Permissions', 'View Workflows');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,633),
(1,634),
(1,635),
(1,636),

(2,633),
(2,634),
(2,635),
(2,636);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(637, 186, 'Add', 'ACM_Bookkeeping_Add_Journal_Entry_Bulk_Upload_Permissions', 'Add Journal Entry Bulk Upload'),
(638, 186, 'Edit', 'ACM_Bookkeeping_Edit_Journal_Entry_Bulk_Upload_Permissions', 'Edit Journal Entry Bulk Upload'),
(639, 186, 'Delete', 'ACM_Bookkeeping_Delete_Journal_Entry_Bulk_Upload_Permissions', 'Delete Journal Entry Bulk Upload'),
(640, 186, 'View', 'ACM_Bookkeeping_View_Journal_Entry_Bulk_Upload_Permissions', 'View Journal Entry Bulk Upload');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,637),
(1,638),
(1,639),
(1,640),

(2,637),
(2,638),
(2,639),
(2,640);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(641, 38, 'Advanced', 'STM_Sales_Reports_Welfare_Credit_Vs_Sales_Report_Permissions', 'View Welfare Credit Vs Sales Report');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(186, 641);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 641),

(2, 641),

(3, 641);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(642, 188, 'Add', 'SVM_MFM_Admin_Add_Banks_Permissions', 'Add Banks'),
(643, 188, 'Edit', 'SVM_MFM_Admin_Edit_Banks_Permissions', 'Edit Banks'),
(644, 188, 'Delete', 'SVM_MFM_Admin_Delete_Banks_Permissions', 'Delete Banks'),
(645, 188, 'View', 'SVM_MFM_Admin_View_Banks_Permissions', 'View Banks'),

(646, 189, 'Add', 'SVM_MFM_Admin_Add_Loan_Types_Permissions', 'Add Loan Types'),
(647, 189, 'Edit', 'SVM_MFM_Admin_Edit_Loan_Types_Permissions', 'Edit Loan Types'),
(648, 189, 'Delete', 'SVM_MFM_Admin_Delete_Loan_Types_Permissions', 'Delete Loan Types'),
(649, 189, 'View', 'SVM_MFM_Admin_View_Loan_Types_Permissions', 'View Loan Types'),

(650, 190, 'Edit', 'SVM_MFM_Admin_Edit_System_Configurations_Permissions', 'Edit System Configurations'),
(651, 190, 'View', 'SVM_MFM_Admin_View_System_Configurations_Permissions', 'View System Configurations'),

(652, 191, 'Add', 'SVM_MFM_Micro_Loans_Add_Loan_Assignments_Permissions', 'Add Loan Assignments'),
(653, 191, 'Edit', 'SVM_MFM_Micro_Loans_Edit_Loan_Assignments_Permissions', 'Edit Loan Assignments'),
(654, 191, 'Delete', 'SVM_MFM_Micro_Loans_Delete_Loan_Assignments_Permissions', 'Delete Loan Assignments'),
(655, 191, 'View', 'SVM_MFM_Micro_Loans_View_Loan_Assignments_Permissions', 'View Loan Assignments'),

(656, 192, 'Add', 'SVM_MFM_Micro_Loans_Add_Collections_Permissions', 'Add Collections'),
(657, 192, 'Edit', 'SVM_MFM_Micro_Loans_Edit_Collections_Permissions', 'Edit Collections'),
(658, 192, 'Delete', 'SVM_MFM_Micro_Loans_Delete_Collections_Permissions', 'Delete Collections'),
(659, 192, 'View', 'SVM_MFM_Micro_Loans_View_Collections_Permissions', 'View Collections'),

(660, 193, 'Add', 'SVM_MFM_Micro_Investments_Add_Fixed_Deposits_Permissions', 'Add Fixed Deposits'),
(661, 193, 'Edit', 'SVM_MFM_Micro_Investments_Edit_Fixed_Deposits_Permissions', 'Edit Fixed Deposits'),
(662, 193, 'Delete', 'SVM_MFM_Micro_Investments_Delete_Fixed_Deposits_Permissions', 'Delete Fixed Deposits'),
(663, 193, 'View', 'SVM_MFM_Micro_Investments_View_Fixed_Deposits_Permissions', 'View Fixed Deposits'),

(664, 194, 'View', 'SVM_MFM_Reports_View_Microfinance_Report_Permissions', 'View Microfinance Reports');

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(665, 187, 'View', 'SVM_MFM_View_Module_Permissions', 'View Microfinance Manager Module');

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(666, 195, 'Add', 'SVM_MFM_Admin_Add_Branches_Permissions', 'Add Branches'),
(667, 195, 'Edit', 'SVM_MFM_Admin_Edit_Branches_Permissions', 'Edit Branches'),
(668, 195, 'Delete', 'SVM_MFM_Admin_Delete_Branches_Permissions', 'Delete Branches'),
(669, 195, 'View', 'SVM_MFM_Admin_View_Branches_Permissions', 'View Branches'),

(670, 196, 'Add', 'SVM_MFM_Admin_Add_Centers_Permissions', 'Add Centers'),
(671, 196, 'Edit', 'SVM_MFM_Admin_Edit_Centers_Permissions', 'Edit Centers'),
(672, 196, 'Delete', 'SVM_MFM_Admin_Delete_Centers_Permissions', 'Delete Centers'),
(673, 196, 'View', 'SVM_MFM_Admin_View_Centers_Permissions', 'View Centers'),

(674, 197, 'Add', 'OGM_Admin_Add_Banks_Permissions', 'Add Banks'),
(675, 197, 'Edit', 'OGM_Admin_Edit_Banks_Permissions', 'Edit Banks'),
(676, 197, 'Delete', 'OGM_Admin_Delete_Banks_Permissions', 'Delete Banks'),
(677, 197, 'View', 'OGM_Admin_View_Banks_Permissions', 'View Banks');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 642),
(1, 643),
(1, 644),
(1, 645),

(2, 642),
(2, 643),
(2, 644),
(2, 645),

(1, 646),
(1, 647),
(1, 648),
(1, 649),

(2, 646),
(2, 647),
(2, 648),
(2, 649),

(1, 650),
(1, 651),

(2, 650),
(2, 651),

(1, 652),
(1, 653),
(1, 654),
(1, 655),

(2, 652),
(2, 653),
(2, 654),
(2, 655),

(1, 656),
(1, 657),
(1, 658),
(1, 659),

(2, 656),
(2, 657),
(2, 658),
(2, 659),

(1, 660),
(1, 661),
(1, 662),
(1, 663),

(2, 660),
(2, 661),
(2, 662),
(2, 663),

(1, 664),

(2, 664),

(1, 665),
(2, 665);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 666),
(1, 667),
(1, 668),
(1, 669),

(2, 666),
(2, 667),
(2, 668),
(2, 669),

(1, 670),
(1, 671),
(1, 672),
(1, 673),

(2, 670),
(2, 671),
(2, 672),
(2, 673),

(1, 674),
(1, 675),
(1, 676),
(1, 677),

(2, 674),
(2, 675),
(2, 676),
(2, 677);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(678, 198, 'Add', 'ACM_Admin_Add_Multicurrencies_Permissions', 'Add Multicurrencies'),
(679, 198, 'Edit', 'ACM_Admin_Edit_Multicurrencies_Permissions', 'Edit Multicurrencies'),
(680, 198, 'Delete', 'ACM_Admin_Delete_Multicurrencies_Permissions', 'Delete Multicurrencies'),
(681, 198, 'View', 'ACM_Admin_View_Multicurrencies_Permissions', 'View Multicurrencies');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,678),
(1,679),
(1,680),
(1,681),

(2,678),
(2,679),
(2,680),
(2,681);