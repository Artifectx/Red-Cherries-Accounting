/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  sampath
 * Created: Oct 1, 2018
 */

DROP PROCEDURE IF EXISTS DebugMSG;
DROP PROCEDURE IF EXISTS ChartOfAccountUpdate;
DELIMITER ;;

CREATE PROCEDURE DebugMSG(enabled INTEGER, msg VARCHAR(255))
BEGIN
  IF enabled THEN
    select concat("** ", msg) AS '** DEBUG:';
  END IF;
END ;;

CREATE PROCEDURE ChartOfAccountUpdate()
BEGIN

DECLARE rowCount INT DEFAULT 0;
DECLARE countNo INT DEFAULT 0;
DECLARE chartOfAccountId INT DEFAULT 0;
DECLARE parentId INT DEFAULT 0;
DECLARE accountLevel INT DEFAULT 0;
DECLARE accountLevelCheck INT DEFAULT 0;

SELECT MAX(`chart_of_account_id`) INTO rowCount FROM `acm_admin_chart_of_accounts`;
SET countNo = 2;
WHILE countNo <= rowCount DO 
    CALL DebugMSG(TRUE, (select concat_ws('',"Count No:", countNo)));
    SET chartOfAccountId = countNo;
    SELECT `parent_id` INTO parentId FROM `acm_admin_chart_of_accounts` WHERE `chart_of_account_id` = countNo;
    SELECT `level` INTO accountLevel FROM `acm_admin_chart_of_accounts` WHERE `chart_of_account_id` = countNo;
    SET accountLevelCheck = accountLevel;
    WHILE accountLevelCheck >= 2 DO
        SET chartOfAccountId = parentId;
        SELECT `parent_id` INTO parentId FROM `acm_admin_chart_of_accounts` WHERE `chart_of_account_id` = chartOfAccountId;
        SELECT `level` INTO accountLevel FROM `acm_admin_chart_of_accounts` WHERE `chart_of_account_id` = chartOfAccountId;
        SET accountLevelCheck = accountLevel;
    END WHILE;

    UPDATE `acm_admin_chart_of_accounts` SET `account_type` = chartOfAccountId WHERE `chart_of_account_id` = countNo;

    SET countNo = countNo + 1;
END WHILE;
END ;;

DELIMITER ;

CALL ChartOfAccountUpdate();

