
/*Alter `system_language_strings` Table*/
ALTER TABLE `system_language_strings`
    MODIFY `language_string` varchar(1000) COLLATE utf8_unicode_ci;

/*Alter `system_language_translations` Table*/
ALTER TABLE `system_language_translations`
    MODIFY `translated_string` varchar(1000) COLLATE utf8_unicode_ci;