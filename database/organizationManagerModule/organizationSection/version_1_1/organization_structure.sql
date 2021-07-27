
/*From ERP Version 9.0 Beta 7 */
/*Alter `ogm_organization_company_information` Table*/
ALTER TABLE `ogm_organization_company_information`
    CHANGE COLUMN `secendory_telephone_number` `secondary_telephone_number` varchar(25);

/*Alter `ogm_organization_company_information` Table*/
ALTER TABLE `ogm_organization_company_information`
   ADD COLUMN `ttn_country_code` varchar(10) DEFAULT '' AFTER `secondary_telephone_number`,
   ADD COLUMN `tertiary_telephone_number` varchar(25) DEFAULT '' AFTER `ttn_country_code`;

