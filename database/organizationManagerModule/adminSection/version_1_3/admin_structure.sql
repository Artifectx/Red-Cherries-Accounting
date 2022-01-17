
/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `salutation` varchar(10) DEFAULT '' AFTER `employee_id`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `salutation` varchar(10) DEFAULT '' AFTER `employee_id`;