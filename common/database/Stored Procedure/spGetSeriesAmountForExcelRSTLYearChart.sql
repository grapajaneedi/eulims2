DELIMITER $$

USE `toplevel`$$

DROP PROCEDURE IF EXISTS `spGetSeriesAmountForExcelRSTLYearChart`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetSeriesAmountForExcelRSTLYearChart`(
	mRSTLID INT(11),
	mStartYear INT(11),
	mEndYear INT(11),
	mLabID INT(11),
	mPaymentTypeID INT(11),
	mFeeTypeID TINYINT(1))
    READS SQL DATA
BEGIN
	-- Stored Prodecure created by Eng'r Nolan F. Sunico
	-- October 30, 2017 11:40 PM
	-- This Procedure generates Series Amount for Income Analytics
	DECLARE mCurrentYear INT(11);
	DROP TABLE IF EXISTS `tmp_chartyears`;
	CREATE TEMPORARY TABLE `tmp_chartyears` (
	  `TMPYearsID` INT(11) NOT NULL AUTO_INCREMENT,
	  `IntYear` INT(11),
	  PRIMARY KEY (`TMPYearsID`)
	)ENGINE=MEMORY;
	-- Insert Years
	SET counter=mStartYear;
	myloop: LOOP
	   IF counter>mEndYear THEN
              LEAVE myloop;
	   END IF;
	   -- Insert to tmp_years
	   INSERT INTO tmp_chartyears(IntYear) 
	   VALUES (counter);
	   SET counter=counter+1;
        END LOOP myloop;
	-- Query 
	SET @SQL="SELECT DISTINCTROW `tbl_region`.`code` AS `Region`";
	SET mCurrentYear=mStartYear;
	WHILE(mCurrentYear <= mEndYear) DO
	   SET @SQL=CONCAT(@SQL,", fnGetFeeByRSTLYear(`onelab.ph`.`tbl_agency`.`id`,",mCurrentYear,",",mLabID,",",mPaymentTypeID,",",mFeeTypeID,") AS '",mCurrentYear,"' ");
	   SET mCurrentYear=mCurrentYear+1;
	END WHILE;
	SET @SQL=CONCAT(@SQL," FROM `api.onelab.gov.ph`.`tbl_region`"); 
	SET @SQL=CONCAT(@SQL," INNER JOIN `onelab.ph`.`tbl_agency` ON(`onelab.ph`.`tbl_agency`.`region_id`=`api.onelab.gov.ph`.`tbl_region`.`region_id`)");
        SET @SQL=CONCAT(@SQL," WHERE `api.onelab.gov.ph`.`tbl_region`.`region_id`>0;"); 	
	-- execute prepared statement
	PREPARE stmt FROM @SQL;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	-- select @SQL;
    END$$

DELIMITER ;