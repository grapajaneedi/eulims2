/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.11 : Database - eulims
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`eulims` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `eulims`;

/*Table structure for table `tbl_package` */

DROP TABLE IF EXISTS `tbl_package`;

CREATE TABLE `tbl_package` (
  `PackageID` int(11) NOT NULL AUTO_INCREMENT,
  `PackageName` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`PackageID`),
  UNIQUE KEY `PackageName` (`PackageName`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_package` */

insert  into `tbl_package`(`PackageID`,`PackageName`,`icon`,`created_at`,`updated_at`) values (21,'lab','fa fa-bookmark',1515397499,1515634107),(22,'inventory','fa fa-assistive-listening-systems',1515398542,1515575300),(24,'finance','fa fa-credit-card',1522048795,1522897198),(25,'tagging',NULL,1523954222,1523954222),(26,'services','fa fa-server',1523954885,1523955450);

/*Table structure for table `tbl_package_details` */

DROP TABLE IF EXISTS `tbl_package_details`;

CREATE TABLE `tbl_package_details` (
  `Package_DetailID` int(11) NOT NULL AUTO_INCREMENT,
  `PackageID` int(11) NOT NULL,
  `Package_Detail` varchar(100) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`Package_DetailID`),
  UNIQUE KEY `Package_Detail` (`Package_Detail`),
  KEY `PackageID` (`PackageID`),
  CONSTRAINT `tbl_package_details_ibfk_1` FOREIGN KEY (`PackageID`) REFERENCES `tbl_package` (`PackageID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_package_details` */

insert  into `tbl_package_details`(`Package_DetailID`,`PackageID`,`Package_Detail`,`url`,`icon`,`created_at`,`updated_at`) values (1,21,'Tester','tester','fa fa-amazon',1522745698,1522745698),(2,24,'Customer Wallet','/finance/customerwallet','fa fa-money',1522896543,1523415052),(3,26,'Tests/ Calibration','/services/tests','fa fa-laptop',1523955063,1523955092);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
