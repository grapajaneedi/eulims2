/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.16-log : Database - eulims_inventory
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `eulims_inventory`;

/*Table structure for table `tbl_categorytype` */

DROP TABLE IF EXISTS `tbl_categorytype`;

CREATE TABLE `tbl_categorytype` (
  `categorytype_id` int(11) NOT NULL AUTO_INCREMENT,
  `categorytype` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`categorytype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_categorytype` */

insert  into `tbl_categorytype`(`categorytype_id`,`categorytype`,`description`) values (1,'Solids',''),(2,'Acids',NULL),(3,'Organic Solvents',NULL),(4,'Buffer Solutions',NULL),(5,'Media',NULL),(6,'Reagents',NULL),(7,'Rapid Test Kits',NULL);

/*Table structure for table `tbl_equipmentservice` */

DROP TABLE IF EXISTS `tbl_equipmentservice`;

CREATE TABLE `tbl_equipmentservice` (
  `equipmentservice_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_transactions_id` int(11) NOT NULL,
  `servicetype_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL,
  `startdate` int(11) DEFAULT NULL,
  `enddate` int(11) DEFAULT NULL,
  `request_status` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`equipmentservice_id`),
  KEY `servicetype_id` (`servicetype_id`),
  KEY `inventory_transactions_id` (`inventory_transactions_id`),
  CONSTRAINT `tbl_equipmentservice_ibfk_1` FOREIGN KEY (`servicetype_id`) REFERENCES `tbl_servicetype` (`servicetype_id`),
  CONSTRAINT `tbl_equipmentservice_ibfk_2` FOREIGN KEY (`inventory_transactions_id`) REFERENCES `tbl_inventory_entries` (`inventory_transactions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_equipmentservice` */

/*Table structure for table `tbl_equipmentstatus` */

DROP TABLE IF EXISTS `tbl_equipmentstatus`;

CREATE TABLE `tbl_equipmentstatus` (
  `equipmentstatus_id` int(11) NOT NULL AUTO_INCREMENT,
  `equipmentstatus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`equipmentstatus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_equipmentstatus` */

insert  into `tbl_equipmentstatus`(`equipmentstatus_id`,`equipmentstatus`) values (1,'Serviceable'),(2,'Non-Serviceable');

/*Table structure for table `tbl_equipmentstatus_entry` */

DROP TABLE IF EXISTS `tbl_equipmentstatus_entry`;

CREATE TABLE `tbl_equipmentstatus_entry` (
  `equipmentstatusentry_id` int(11) NOT NULL AUTO_INCREMENT,
  `equipmentstatus_id` int(11) NOT NULL,
  `inventory_transactions_id` int(11) NOT NULL,
  PRIMARY KEY (`equipmentstatusentry_id`),
  KEY `equipmentstatus_id` (`equipmentstatus_id`),
  KEY `inventory_transactions_id` (`inventory_transactions_id`),
  CONSTRAINT `tbl_equipmentstatus_entry_ibfk_1` FOREIGN KEY (`equipmentstatus_id`) REFERENCES `tbl_equipmentstatus` (`equipmentstatus_id`),
  CONSTRAINT `tbl_equipmentstatus_entry_ibfk_2` FOREIGN KEY (`inventory_transactions_id`) REFERENCES `tbl_inventory_entries` (`inventory_transactions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_equipmentstatus_entry` */

insert  into `tbl_equipmentstatus_entry`(`equipmentstatusentry_id`,`equipmentstatus_id`,`inventory_transactions_id`) values (1,1,3);

/*Table structure for table `tbl_inventory_entries` */

DROP TABLE IF EXISTS `tbl_inventory_entries`;

CREATE TABLE `tbl_inventory_entries` (
  `inventory_transactions_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type_id` int(11) NOT NULL,
  `rstl_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `suppliers_id` int(11) NOT NULL,
  `po_number` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Image1` varchar(100) DEFAULT NULL,
  `Image2` varchar(100) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`inventory_transactions_id`),
  KEY `supply_id` (`suppliers_id`),
  KEY `product_id` (`product_id`),
  KEY `transaction_type_id` (`transaction_type_id`),
  CONSTRAINT `tbl_inventory_entries_ibfk_1` FOREIGN KEY (`suppliers_id`) REFERENCES `tbl_suppliers` (`suppliers_id`),
  CONSTRAINT `tbl_inventory_entries_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`),
  CONSTRAINT `tbl_inventory_entries_ibfk_3` FOREIGN KEY (`transaction_type_id`) REFERENCES `tbl_transactiontype` (`transactiontype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_inventory_entries` */

/*Table structure for table `tbl_inventory_status` */

DROP TABLE IF EXISTS `tbl_inventory_status`;

CREATE TABLE `tbl_inventory_status` (
  `inventory_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`inventory_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_inventory_status` */

insert  into `tbl_inventory_status`(`inventory_status_id`,`inventory_status`) values (1,'Open'),(2,'Restricted'),(3,'Hold'),(4,'Rejected');

/*Table structure for table `tbl_inventory_withdrawal` */

DROP TABLE IF EXISTS `tbl_inventory_withdrawal`;

CREATE TABLE `tbl_inventory_withdrawal` (
  `inventory_withdrawal_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `withdrawal_datetime` datetime NOT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `total_qty` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remarks` text,
  `inventory_status_id` int(11) NOT NULL,
  PRIMARY KEY (`inventory_withdrawal_id`),
  KEY `inventory_status_id` (`inventory_status_id`),
  CONSTRAINT `tbl_inventory_withdrawal_ibfk_1` FOREIGN KEY (`inventory_status_id`) REFERENCES `tbl_inventory_status` (`inventory_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_inventory_withdrawal` */

/*Table structure for table `tbl_inventory_withdrawaldetails` */

DROP TABLE IF EXISTS `tbl_inventory_withdrawaldetails`;

CREATE TABLE `tbl_inventory_withdrawaldetails` (
  `inventory_withdrawaldetails_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_withdrawal_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `withdarawal_status_id` int(11) NOT NULL,
  PRIMARY KEY (`inventory_withdrawaldetails_id`),
  KEY `inventory_withdrawal_id` (`inventory_withdrawal_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_inventory_withdrawaldetails_ibfk_1` FOREIGN KEY (`inventory_withdrawal_id`) REFERENCES `tbl_inventory_withdrawal` (`inventory_withdrawal_id`),
  CONSTRAINT `tbl_inventory_withdrawaldetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_inventory_withdrawaldetails` */

/*Table structure for table `tbl_products` */

DROP TABLE IF EXISTS `tbl_products`;

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(100) DEFAULT NULL,
  `product_name` varchar(50) NOT NULL,
  `producttype_id` int(11) NOT NULL DEFAULT '1',
  `categorytype_id` int(11) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `srp` decimal(10,2) NOT NULL DEFAULT '0.00',
  `qty_reorder` int(11) NOT NULL,
  `qty_onhand` int(11) NOT NULL,
  `qty_min_reorder` int(11) NOT NULL,
  `qty_per_unit` varchar(50) NOT NULL,
  `discontinued` tinyint(1) NOT NULL DEFAULT '0',
  `suppliers_ids` longtext,
  `created_by` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `categorytype_id` (`categorytype_id`),
  CONSTRAINT `tbl_products_ibfk_1` FOREIGN KEY (`categorytype_id`) REFERENCES `tbl_categorytype` (`categorytype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_products` */

insert  into `tbl_products`(`product_id`,`product_code`,`product_name`,`producttype_id`,`categorytype_id`,`description`,`price`,`srp`,`qty_reorder`,`qty_onhand`,`qty_min_reorder`,`qty_per_unit`,`discontinued`,`suppliers_ids`,`created_by`,`created_at`,`updated_at`) values (1,'AAA','acetyline',1,1,NULL,'10.00','10.00',5,12,5,'12 bottles x Box',0,'1,2,3',1,1512923120,1512923120),(2,'AAB','Laminator',2,1,NULL,'5000.00','5000.00',1,1,1,'1 Piece',0,'1',1,1512923120,1512923120);

/*Table structure for table `tbl_producttype` */

DROP TABLE IF EXISTS `tbl_producttype`;

CREATE TABLE `tbl_producttype` (
  `producttype_id` int(11) NOT NULL AUTO_INCREMENT,
  `producttype` varchar(100) NOT NULL,
  PRIMARY KEY (`producttype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_producttype` */

insert  into `tbl_producttype`(`producttype_id`,`producttype`) values (1,'Consumable'),(2,'Non-Consumable');

/*Table structure for table `tbl_servicetype` */

DROP TABLE IF EXISTS `tbl_servicetype`;

CREATE TABLE `tbl_servicetype` (
  `servicetype_id` int(11) NOT NULL AUTO_INCREMENT,
  `servicetype` varchar(100) NOT NULL,
  PRIMARY KEY (`servicetype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_servicetype` */

insert  into `tbl_servicetype`(`servicetype_id`,`servicetype`) values (1,'Calibration'),(2,'Maintenance'),(3,'Usage');

/*Table structure for table `tbl_suppliers` */

DROP TABLE IF EXISTS `tbl_suppliers`;

CREATE TABLE `tbl_suppliers` (
  `suppliers_id` int(11) NOT NULL AUTO_INCREMENT,
  `suppliers` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `fax_number` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`suppliers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_suppliers` */

insert  into `tbl_suppliers`(`suppliers_id`,`suppliers`,`description`,`address`,`contact_person`,`phone_number`,`fax_number`,`email`) values (1,'Hamburg Inc.',NULL,NULL,NULL,NULL,NULL,NULL),(2,'Pyrex',NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_transactiontype` */

DROP TABLE IF EXISTS `tbl_transactiontype`;

CREATE TABLE `tbl_transactiontype` (
  `transactiontype_id` int(11) NOT NULL AUTO_INCREMENT,
  `transactiontype` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`transactiontype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_transactiontype` */

insert  into `tbl_transactiontype`(`transactiontype_id`,`transactiontype`) values (1,'Entry'),(2,'Withdrawal');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
