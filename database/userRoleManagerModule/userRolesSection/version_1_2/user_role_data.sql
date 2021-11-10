
/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(585,174, 'Add', 'HRM_Employee_Leave_Add_Leave_Rules_Permissions', 'Add Leave Rules'),
(586,174, 'Edit', 'HRM_Employee_Leave_Edit_Leave_Rules_Permissions', 'Edit Leave Rules'),
(587,174, 'Delete', 'HRM_Employee_Leave_Delete_Leave_Rules_Permissions', 'Delete Leave Rules'),
(588,174, 'View', 'HRM_Employee_Leave_View_Leave_Rules_Permissions', 'View Leave Rules');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1,585),
(1,586),
(1,587),
(1,588),

(2,585),
(2,586),
(2,587),
(2,588);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(589, 19, 'Advanced', 'OGM_Admin_View_Student_Advanced_List', 'Allow to View Student List');

/*Data for the table `urm_user_roles_permissions_advanced` */
INSERT  INTO `urm_user_roles_permissions_advanced` (`permission_id`,`child_permission_id`) VALUES
(76, 589);

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 589),

(2, 589),

(3, 589);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(591, 176, 'Add', 'SVM_SSM_Admin_Add_Grades_Permissions', 'Add Grades'),
(592, 176, 'Edit', 'SVM_SSM_Admin_Edit_Grades_Permissions', 'Edit Grades'),
(593, 176, 'Delete', 'SVM_SSM_Admin_Delete_Grades_Permissions', 'Delete Grades'),
(594, 176, 'View', 'SVM_SSM_Admin_View_Grades_Permissions', 'View Grades'),

(595, 177, 'Add', 'SVM_SSM_Admin_Add_Teaching_Mediums_Permissions', 'Add Teaching Mediums'),
(596, 177, 'Edit', 'SVM_SSM_Admin_Edit_Teaching_Mediums_Permissions', 'Edit Teaching Mediums'),
(597, 177, 'Delete', 'SVM_SSM_Admin_Delete_Teaching_Mediums_Permissions', 'Delete Teaching Mediums'),
(598, 177, 'View', 'SVM_SSM_Admin_View_Teaching_Mediums_Permissions', 'View Teaching Mediums'),

(599, 178, 'Add', 'SVM_SSM_Admin_Add_Main_Subjects_Permissions', 'Add Main Subjects'),
(600, 178, 'Edit', 'SVM_SSM_Admin_Edit_Main_Subjects_Permissions', 'Edit Main Subjects'),
(601, 178, 'Delete', 'SVM_SSM_Admin_Delete_Main_Subjects_Permissions', 'Delete Main Subjects'),
(602, 178, 'View', 'SVM_SSM_Admin_View_Main_Subjects_Permissions', 'View Main Subjects'),

(603, 179, 'Add', 'SVM_SSM_Admin_Add_Subject_Buckets_Permissions', 'Add Subject Buckets'),
(604, 179, 'Edit', 'SVM_SSM_Admin_Edit_Subject_Buckets_Permissions', 'Edit Subject Buckets'),
(605, 179, 'Delete', 'SVM_SSM_Admin_Delete_Subject_Buckets_Permissions', 'Delete Subject Buckets'),
(606, 179, 'View', 'SVM_SSM_Admin_View_Subject_Buckets_Permissions', 'View Subject Buckets'),

(607, 180, 'Add', 'SVM_SSM_Admin_Add_Bucket_Subjects_Permissions', 'Add Bucket Subjects'),
(608, 180, 'Edit', 'SVM_SSM_Admin_Edit_Bucket_Subjects_Permissions', 'Edit Bucket Subjects'),
(609, 180, 'Delete', 'SVM_SSM_Admin_Delete_Bucket_Subjects_Permissions', 'Delete Bucket Subjects'),
(610, 180, 'View', 'SVM_SSM_Admin_View_Bucket_Subjects_Permissions', 'View Bucket Subjects'),

(611, 181, 'Edit', 'SVM_SSM_Admin_Edit_System_Configurations_Permissions', 'Edit System Configurations'),
(612, 181, 'View', 'SVM_SSM_Admin_View_System_Configurations_Permissions', 'View System Configurations'),

(613, 182, 'Edit', 'SVM_SSM_Academics_Edit_Classes_Permissions', 'Edit Classes'),
(614, 182, 'View', 'SVM_SSM_Academics_View_Classes_Permissions', 'View Classes'),

(615, 183, 'View', 'SVM_SSM_Reports_View_Academic_Report_Permissions', 'View Academic Reports');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 591),
(1, 592),
(1, 593),
(1, 594),

(2, 591),
(2, 592),
(2, 593),
(2, 594),

(1, 595),
(1, 596),
(1, 597),
(1, 598),

(2, 595),
(2, 596),
(2, 597),
(2, 598),

(1, 599),
(1, 600),
(1, 601),
(1, 602),

(2, 599),
(2, 600),
(2, 601),
(2, 602),

(1, 603),
(1, 604),
(1, 605),
(1, 606),

(2, 603),
(2, 604),
(2, 605),
(2, 606),

(1, 607),
(1, 608),
(1, 609),
(1, 610),

(2, 607),
(2, 608),
(2, 609),
(2, 610),

(1, 611),
(1, 612),

(2, 611),
(2, 612),

(1, 613),
(1, 614),

(2, 613),
(2, 614),

(1, 615),

(2, 615);

/*Data for the table `urm_user_roles_permissions` */
INSERT INTO `urm_user_roles_permissions`(`permission_id`,`module_section_feature_id`,`permission_type`,`permission`,`permission_description`) VALUES
(616, 182, 'Edit', 'SVM_SSM_Academics_Edit_Student_Details_Permissions', 'Edit Student Details'),
(617, 182, 'Edit', 'SVM_SSM_Academics_Edit_Student_Academic_Details_Permissions', 'Edit Student Academic Details'),
(618, 184, 'Add', 'SVM_SSM_Admin_Add_Athletics_Events_Permissions', 'Add Athletics Events'),
(619, 184, 'Edit', 'SVM_SSM_Admin_Edit_Athletics_Events_Permissions', 'Edit Athletics Events'),
(620, 184, 'Delete', 'SVM_SSM_Admin_Delete_Athletics_Events_Permissions', 'Delete Athletics Events'),
(621, 184, 'View', 'SVM_SSM_Admin_View_Athletics_Events_Permissions', 'View Athletics Events'),
(622, 182, 'Edit', 'SVM_SSM_Academics_Edit_Student_Athletics_Details_Permissions', 'Edit Student Athletics Details'),
(623, 182, 'Delete', 'SVM_SSM_Academics_Delete_Student_Athletics_Details_Permissions', 'Delete Student Athletics Details'),
(624, 182, 'Edit', 'SVM_SSM_Academics_Edit_Student_Assessment_Details_Permissions', 'Edit Student Assessment Details'),
(625, 182, 'Delete', 'SVM_SSM_Academics_Delete_Student_Assessment_Details_Permissions', 'Delete Student Assessment Details'),
(626, 182, 'Edit', 'SVM_SSM_Academics_Edit_Student_Term_Test_Details_Permissions', 'Edit Student Term Test Details'),
(627, 182, 'Delete', 'SVM_SSM_Academics_Delete_Student_Term_Test_Details_Permissions', 'Delete Student Term Test Details'),
(628, 182, 'Edit', 'SVM_SSM_Academics_Edit_Student_General_Examination_Details_Permissions', 'Edit Student General Examination Details'),
(629, 182, 'Delete', 'SVM_SSM_Academics_Delete_Student_General_Examination_Details_Permissions', 'Delete Student General Examination Details');

/*Data for the table `urm_user_roles_default_user_role_permissions` */
INSERT  INTO `urm_user_roles_default_user_role_permissions` (`role_id`,`permission_id`) VALUES
(1, 616),
(1, 617),

(2, 616),
(2, 617),

(1, 618),
(1, 619),
(1, 620),
(1, 621),

(2, 616),
(2, 617),

(2, 618),
(2, 619),
(2, 620),
(2, 621),

(1, 622),
(1, 623),
(1, 624),
(1, 625),
(1, 626),
(1, 627),
(1, 628),
(1, 629),

(2, 622),
(2, 623),
(2, 624),
(2, 625),
(2, 626),
(2, 627),
(2, 628),
(2, 629);