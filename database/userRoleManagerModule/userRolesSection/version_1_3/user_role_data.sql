
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