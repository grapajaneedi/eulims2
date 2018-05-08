/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.16-log : Database - eulims_lab
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `eulims_lab`;

/*Table structure for table `tbl_analysis` */

DROP TABLE IF EXISTS `tbl_analysis`;

CREATE TABLE `tbl_analysis` (
  `analysis_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_analysis` date NOT NULL,
  `rstl_id` int(11) NOT NULL,
  `pstcanalysis_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `sample_id` int(11) NOT NULL,
  `sample_code` varchar(20) CHARACTER SET latin1 NOT NULL,
  `testname` varchar(200) CHARACTER SET latin1 NOT NULL,
  `method` varchar(150) CHARACTER SET latin1 NOT NULL,
  `references` varchar(100) CHARACTER SET latin1 NOT NULL,
  `quantity` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `test_id` int(11) NOT NULL,
  `cancelled` tinyint(1) NOT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`analysis_id`),
  KEY `sample_id` (`sample_id`),
  KEY `request_id` (`request_id`),
  KEY `test_id` (`test_id`),
  CONSTRAINT `tbl_analysis_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `tbl_test` (`test_id`),
  CONSTRAINT `tbl_analysis_ibfk_3` FOREIGN KEY (`sample_id`) REFERENCES `tbl_sample` (`sample_id`),
  CONSTRAINT `tbl_analysis_ibfk_4` FOREIGN KEY (`request_id`) REFERENCES `tbl_request` (`request_id`),
  CONSTRAINT `tbl_analysis_ibfk_5` FOREIGN KEY (`test_id`) REFERENCES `tbl_test` (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_analysis` */

/*Table structure for table `tbl_businessnature` */

DROP TABLE IF EXISTS `tbl_businessnature`;

CREATE TABLE `tbl_businessnature` (
  `business_nature_id` int(11) NOT NULL AUTO_INCREMENT,
  `nature` varchar(200) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`business_nature_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_businessnature` */

insert  into `tbl_businessnature`(`business_nature_id`,`nature`) values (1,'Raw and Processed Food'),(2,'Marine Products'),(3,'Canned / Bottled Fish'),(4,'Fishmeal'),(5,'Seaweads'),(6,'Petroleum Products / Haulers'),(7,'Mining'),(8,'Hospitals'),(9,'Academe / Students'),(10,'Beverage and Juices'),(11,'Government / LGUs'),(12,'Construction'),(13,'Water Refilling / Bottled Water'),(14,'Students'),(15,'Private Individual'),(16,'Others');

/*Table structure for table `tbl_cancelledrequest` */

DROP TABLE IF EXISTS `tbl_cancelledrequest`;

CREATE TABLE `tbl_cancelledrequest` (
  `canceledrequest_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `request_ref_num` varchar(50) CHARACTER SET latin1 NOT NULL,
  `reason` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cancel_date` date NOT NULL,
  `cancelledby` int(11) NOT NULL,
  PRIMARY KEY (`canceledrequest_id`),
  KEY `request_id` (`request_id`),
  CONSTRAINT `tbl_cancelledrequest_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `tbl_request` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_cancelledrequest` */

/*Table structure for table `tbl_configlab` */

DROP TABLE IF EXISTS `tbl_configlab`;

CREATE TABLE `tbl_configlab` (
  `configlab_id` int(11) NOT NULL AUTO_INCREMENT,
  `rstl_id` int(11) NOT NULL,
  `lab` varchar(25) CHARACTER SET latin1 NOT NULL DEFAULT '1,2,3',
  PRIMARY KEY (`configlab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_configlab` */

insert  into `tbl_configlab`(`configlab_id`,`rstl_id`,`lab`) values (1,11,'1,2,3');

/*Table structure for table `tbl_counter` */

DROP TABLE IF EXISTS `tbl_counter`;

CREATE TABLE `tbl_counter` (
  `counter_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`counter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_counter` */

/*Table structure for table `tbl_customer` */

DROP TABLE IF EXISTS `tbl_customer`;

CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `rstl_id` int(11) NOT NULL,
  `customer_code` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `customer_name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `head` varchar(100) CHARACTER SET latin1 NOT NULL,
  `municipalitycity_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `district` int(11) NOT NULL,
  `address` varchar(200) CHARACTER SET latin1 NOT NULL,
  `tel` varchar(50) CHARACTER SET latin1 NOT NULL,
  `fax` varchar(50) CHARACTER SET latin1 NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `customer_type_id` int(11) NOT NULL,
  `business_nature_id` int(11) NOT NULL,
  `industrytype_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customerName` (`customer_name`),
  KEY `customer_type_id` (`customer_type_id`),
  KEY `business_nature_id` (`business_nature_id`),
  KEY `industrytype_id` (`industrytype_id`),
  CONSTRAINT `tbl_customer_ibfk_1` FOREIGN KEY (`customer_type_id`) REFERENCES `tbl_customertype` (`customertype_id`),
  CONSTRAINT `tbl_customer_ibfk_2` FOREIGN KEY (`business_nature_id`) REFERENCES `tbl_businessnature` (`business_nature_id`),
  CONSTRAINT `tbl_customer_ibfk_3` FOREIGN KEY (`industrytype_id`) REFERENCES `tbl_industrytype` (`industrytype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_customer` */

insert  into `tbl_customer`(`customer_id`,`rstl_id`,`customer_code`,`customer_name`,`head`,`municipalitycity_id`,`barangay_id`,`district`,`address`,`tel`,`fax`,`email`,`customer_type_id`,`business_nature_id`,`industrytype_id`,`created_at`) values (2,11,'232323','Tester','eerere',1,1,1,'e4545','','','test@gmail.com',2,7,6,0);

/*Table structure for table `tbl_customertype` */

DROP TABLE IF EXISTS `tbl_customertype`;

CREATE TABLE `tbl_customertype` (
  `customertype_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`customertype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_customertype` */

insert  into `tbl_customertype`(`customertype_id`,`type`) values (1,'SETUP CORE'),(2,'NON SETUP'),(3,'SETUP NON-CORE');

/*Table structure for table `tbl_discount` */

DROP TABLE IF EXISTS `tbl_discount`;

CREATE TABLE `tbl_discount` (
  `discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) CHARACTER SET latin1 NOT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_discount` */

insert  into `tbl_discount`(`discount_id`,`type`,`rate`,`status`) values (0,'No Discount','0.00',1),(1,'Students / Researchers ','25.00',1),(2,'In-House','20.00',1),(3,'Senior Citizen','20.00',0),(4,'Person with Disability','20.00',0),(5,'Promo Rate (Rubber Lab)','50.00',1),(6,'NSTW 2016 Promo','50.00',1),(7,'Employee','50.00',1);

/*Table structure for table `tbl_fee` */

DROP TABLE IF EXISTS `tbl_fee`;

CREATE TABLE `tbl_fee` (
  `fee_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `code` varchar(12) CHARACTER SET latin1 NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_fee` */

insert  into `tbl_fee`(`fee_id`,`name`,`code`,`unit_cost`) values (1,'Additional Test Point(s)','TP','400.00'),(2,'Additional Setting(s)','S','500.00'),(3,'In-Plant Calibration Charge (50 km radius)','CC50','3000.00'),(4,'In-Plant Calibration Charge  (>50 km radius)','CC50+','5500.00');

/*Table structure for table `tbl_generatedrequest` */

DROP TABLE IF EXISTS `tbl_generatedrequest`;

CREATE TABLE `tbl_generatedrequest` (
  `generatedrequest_id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) DEFAULT NULL,
  `request_id` int(11) DEFAULT NULL,
  `lab_id` tinyint(1) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `number` int(1) NOT NULL,
  PRIMARY KEY (`generatedrequest_id`),
  KEY `request_id` (`request_id`),
  CONSTRAINT `tbl_generatedrequest_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `tbl_request` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_generatedrequest` */

/*Table structure for table `tbl_industrytype` */

DROP TABLE IF EXISTS `tbl_industrytype`;

CREATE TABLE `tbl_industrytype` (
  `industrytype_id` int(11) NOT NULL AUTO_INCREMENT,
  `industry` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`industrytype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_industrytype` */

insert  into `tbl_industrytype`(`industrytype_id`,`industry`) values (1,'Food Processing'),(2,'Furniture'),(3,'GTHD'),(4,'Aquatic and Marine'),(5,'Horticulture'),(6,'Metals and Engineering'),(7,'Information and Communcations Technology'),(8,'Health Products and Services'),(9,'Others');

/*Table structure for table `tbl_initializecode` */

DROP TABLE IF EXISTS `tbl_initializecode`;

CREATE TABLE `tbl_initializecode` (
  `initializecode_id` int(11) NOT NULL AUTO_INCREMENT,
  `rstl_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `code_type` int(11) NOT NULL,
  `start_code` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`initializecode_id`),
  KEY `lab_id` (`lab_id`),
  CONSTRAINT `tbl_initializecode_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `tbl_lab` (`lab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_initializecode` */

/*Table structure for table `tbl_lab` */

DROP TABLE IF EXISTS `tbl_lab`;

CREATE TABLE `tbl_lab` (
  `lab_id` int(11) NOT NULL AUTO_INCREMENT,
  `labname` varchar(50) CHARACTER SET latin1 NOT NULL,
  `labcode` varchar(10) CHARACTER SET latin1 NOT NULL,
  `labcount` int(11) NOT NULL,
  `nextrequestcode` varchar(50) CHARACTER SET latin1 NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`lab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_lab` */

insert  into `tbl_lab`(`lab_id`,`labname`,`labcode`,`labcount`,`nextrequestcode`,`active`) values (1,'Chemical Laboratory','CHE',1,'455555',1),(2,'Microbiological Laboratory','MIC',0,'',1),(3,'Metrology Laboratory','MET',0,'',1),(4,'Physical Laboratory','PHY',0,'',1),(5,'Formula of Manufacture','FOC',0,'',1),(6,'Shelf Life Testing','SHL',0,'',0);

/*Table structure for table `tbl_modeofrelease` */

DROP TABLE IF EXISTS `tbl_modeofrelease`;

CREATE TABLE `tbl_modeofrelease` (
  `modeofrelease_id` int(11) NOT NULL,
  `mode` varchar(25) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`modeofrelease_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_modeofrelease` */

insert  into `tbl_modeofrelease`(`modeofrelease_id`,`mode`,`status`) values (1,'Pick up',1),(2,'Mail',1),(3,'Fax',1),(4,'Email',1);

/*Table structure for table `tbl_packagelist` */

DROP TABLE IF EXISTS `tbl_packagelist`;

CREATE TABLE `tbl_packagelist` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `rstl_id` int(11) NOT NULL,
  `testcategory_id` int(11) NOT NULL,
  `sampletype_id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tests` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`package_id`),
  KEY `testcategory_id` (`testcategory_id`),
  KEY `sampletype_id` (`sampletype_id`),
  CONSTRAINT `tbl_packagelist_ibfk_1` FOREIGN KEY (`testcategory_id`) REFERENCES `tbl_testcategory` (`test_category_id`),
  CONSTRAINT `tbl_packagelist_ibfk_2` FOREIGN KEY (`sampletype_id`) REFERENCES `tbl_sample` (`sample_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_packagelist` */

/*Table structure for table `tbl_paymenttype` */

DROP TABLE IF EXISTS `tbl_paymenttype`;

CREATE TABLE `tbl_paymenttype` (
  `payment_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`payment_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_paymenttype` */

insert  into `tbl_paymenttype`(`payment_type_id`,`type`) values (0,'Unpaid'),(1,'Paid'),(2,'Fully Subsidized');

/*Table structure for table `tbl_purpose` */

DROP TABLE IF EXISTS `tbl_purpose`;

CREATE TABLE `tbl_purpose` (
  `purpose_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`purpose_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_purpose` */

insert  into `tbl_purpose`(`purpose_id`,`name`,`active`) values (1,'Academic',1),(2,'Research and Development',1),(3,'Tariff / Registration',1),(4,'Nutrition Labelling',1),(5,'Bidding',1),(6,'Quality Evaluation',1),(7,'RA 9242 Certification',1),(8,'Regulatory',1),(9,'Export',1),(10,'Others',1);

/*Table structure for table `tbl_request` */

DROP TABLE IF EXISTS `tbl_request`;

CREATE TABLE `tbl_request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_ref_num` varchar(50) CHARACTER SET latin1 NOT NULL,
  `request_datetime` int(11) NOT NULL,
  `rstl_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `modeofrelease_id` int(11) NOT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `discount_id` int(11) NOT NULL,
  `purpose_id` int(11) NOT NULL,
  `or_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `report_due` date NOT NULL,
  `conforme` varchar(50) CHARACTER SET latin1 NOT NULL,
  `receivedBy` varchar(50) CHARACTER SET latin1 NOT NULL,
  `created_at` int(11) NOT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`request_id`),
  UNIQUE KEY `requestRefNum` (`request_ref_num`),
  KEY `lab_id` (`lab_id`),
  KEY `discount_id` (`discount_id`),
  KEY `purpose_id` (`purpose_id`),
  KEY `status_id` (`status_id`),
  KEY `customer_id` (`customer_id`),
  KEY `modeofrelease_id` (`modeofrelease_id`),
  KEY `payment_type_id` (`payment_type_id`),
  CONSTRAINT `tbl_request_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `tbl_lab` (`lab_id`),
  CONSTRAINT `tbl_request_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`),
  CONSTRAINT `tbl_request_ibfk_3` FOREIGN KEY (`discount_id`) REFERENCES `tbl_discount` (`discount_id`),
  CONSTRAINT `tbl_request_ibfk_4` FOREIGN KEY (`purpose_id`) REFERENCES `tbl_purpose` (`purpose_id`),
  CONSTRAINT `tbl_request_ibfk_5` FOREIGN KEY (`status_id`) REFERENCES `tbl_status` (`status_id`),
  CONSTRAINT `tbl_request_ibfk_6` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`),
  CONSTRAINT `tbl_request_ibfk_7` FOREIGN KEY (`modeofrelease_id`) REFERENCES `tbl_modeofrelease` (`modeofrelease_id`),
  CONSTRAINT `tbl_request_ibfk_8` FOREIGN KEY (`payment_type_id`) REFERENCES `tbl_paymenttype` (`payment_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs ROW_FORMAT=DYNAMIC;

/*Data for the table `tbl_request` */

/*Table structure for table `tbl_requestcode` */

DROP TABLE IF EXISTS `tbl_requestcode`;

CREATE TABLE `tbl_requestcode` (
  `requestcode_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_ref_num` varchar(50) CHARACTER SET latin1 NOT NULL,
  `rstl_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `cancelled` tinyint(1) NOT NULL,
  PRIMARY KEY (`requestcode_id`),
  KEY `lab_id` (`lab_id`),
  CONSTRAINT `tbl_requestcode_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `tbl_lab` (`lab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_requestcode` */

/*Table structure for table `tbl_sample` */

DROP TABLE IF EXISTS `tbl_sample`;

CREATE TABLE `tbl_sample` (
  `sample_id` int(11) NOT NULL AUTO_INCREMENT,
  `rstl_id` int(11) NOT NULL,
  `pstcsample_id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `sample_type_id` int(11) NOT NULL,
  `sample_code` varchar(20) CHARACTER SET latin1 NOT NULL,
  `samplename` varchar(50) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `sampling_date` date NOT NULL,
  `remarks` varchar(150) CHARACTER SET latin1 NOT NULL,
  `request_id` int(11) NOT NULL,
  `sample_month` int(11) NOT NULL,
  `sample_year` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sample_id`),
  KEY `sample_type_id` (`sample_type_id`),
  KEY `request_id` (`request_id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `tbl_sample_ibfk_1` FOREIGN KEY (`sample_type_id`) REFERENCES `tbl_sampletype` (`sample_type_id`),
  CONSTRAINT `tbl_sample_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `tbl_request` (`request_id`),
  CONSTRAINT `tbl_sample_ibfk_3` FOREIGN KEY (`package_id`) REFERENCES `tbl_packagelist` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_sample` */

/*Table structure for table `tbl_sample_name` */

DROP TABLE IF EXISTS `tbl_sample_name`;

CREATE TABLE `tbl_sample_name` (
  `sample_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_name` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`sample_name_id`),
  UNIQUE KEY `sample_name` (`sample_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_sample_name` */

/*Table structure for table `tbl_sampletype` */

DROP TABLE IF EXISTS `tbl_sampletype`;

CREATE TABLE `tbl_sampletype` (
  `sample_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_type` varchar(75) CHARACTER SET latin1 NOT NULL,
  `test_category_id` int(11) NOT NULL,
  PRIMARY KEY (`sample_type_id`),
  KEY `test_category_id` (`test_category_id`),
  CONSTRAINT `tbl_sampletype_ibfk_1` FOREIGN KEY (`test_category_id`) REFERENCES `tbl_testcategory` (`test_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_sampletype` */

insert  into `tbl_sampletype`(`sample_type_id`,`sample_type`,`test_category_id`) values (1,'Fish and Marine Products',1),(2,'Meat and Meat Products',1),(3,'Milk (powder)',1),(4,'Milk (liquid)',1),(5,'Baked Products',1),(6,'Coffee, Tea and Cacao',1),(7,'Flour',1),(8,'Infant Formula',1),(9,'Sugar and Sugar-based Products, and Juices',1),(10,'Other Analyses of Food Products and Raw Materials',2),(11,'Fruit and Processed Fruit Products',3),(12,'Feeds / Fishmeal and Dried Fish',4),(13,'Vinegar',5),(14,'Soy Sauce',5),(15,'Salt',5),(16,'Minerals in Food Samples',6),(17,'Trace Metals in Food Samples',7),(18,'Fats and Oils',8),(19,'Plants',9),(20,'Seaweeds',10),(21,'Fertilizer',11),(22,'Coal / Charcoal',12),(23,'Food Products',13),(24,'Water',13),(31,'Water',17),(32,'Seawater',17),(33,'Wastewater',17),(38,'Swab Sample',13),(39,'Others',18),(40,'Natural Rubber',19),(51,'Electrical (Multitester)',20),(52,'Electrical (Multimeter)',20),(66,'Electrical (Panel Meter)',20),(67,'Electrical (pH Meter)',20),(69,'Volume (Volumetric Apparatus v1)',15),(73,'Mass (Mass Standard, 25 - 50 kg)',14),(74,'Mass (Mass Standard, 10 - 20 kg)',14),(75,'Mass (Mass Standard, Up to 5 kg)',14),(76,'Mass (Balance, Class I)',14),(77,'Mass (Balance, Class II)',14),(78,'Mass (Balance, Class III)',14),(79,'Mass (Balance, Class IIII)',14),(80,'Temperature (Chamber, 4 TP)',21),(81,'Temperature (Chamber, 1 TP)',21),(82,'Temperature (Chamber, 2 TP)',21),(83,'Temperature (Chamber, 3 TP)',21),(84,'Temperature (Chamber, 5 TP)',21),(85,'Temperature (Chamber, 6 TP)',21),(86,'Temperature (Thermometer, 5 TP, 12 Ch)',21),(87,'Pressure (Pressure Gauge, 8 TP)',22),(92,'Temperature (Thermometer, 5 TP, 1 Ch)',21),(93,'Volume (Test Measure, Vol, 10 L)',15),(94,'Volume (Test Measure, Grav, 10 L)',15),(95,'Volume (Test Measure, Vol, 20 L)',15),(96,'Volume (Test Measure, Grav, 20 L)',15),(97,'Volume (Proving Tank, 100 L to 400 L)',15),(98,'Volume (Proving Tank, 500 L to 2,000 L)',15),(99,'Volume (Proving Tank, 2,500 L to 4,000 L)',15),(100,'Volume (Flowmeter)',15),(101,'Volume (Road Tanker, 5,000 L and below)',15),(102,'Volume (Road Tanker, 6,000 L to 10,000 L)',15),(103,'Volume (Road Tanker, 11,000 L to 15,000 L)',15),(104,'Volume (Road Tanker, 16,000 L to 20,000 L)',15),(105,'Volume (Road Tanker, 21,000 L to 25,000 L)',15),(106,'Volume (Road Tanker, 26,000 L to 30,000 L)',15),(107,'Volume (Road Tanker, 31,000 L to 35,000 L)',15),(108,'Volume (Road Tanker, 36,000 L to 40,000 L)',15),(109,'Volume (Road Tanker, 41,000 L to 45,000 L)',15),(110,'Volume (Road Tanker, 46,000 L to 50,000 L)',15),(111,'Volume (FCD)',15),(112,'Within 50 km (1 Day)',23),(113,'More Than 50 km (1 Day)',23),(114,'Volume (Volumetric Apparatus v2)',15),(115,'Temperature (Thermometer, 5 TP, 2 Ch)',21);

/*Table structure for table `tbl_status` */

DROP TABLE IF EXISTS `tbl_status`;

CREATE TABLE `tbl_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_status` */

insert  into `tbl_status`(`status_id`,`status`) values (-1,'Deleted'),(1,'Active'),(2,'Cancelled'),(3,'Completed');

/*Table structure for table `tbl_tagging` */

DROP TABLE IF EXISTS `tbl_tagging`;

CREATE TABLE `tbl_tagging` (
  `tagging_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `tagging_status_id` int(1) NOT NULL DEFAULT '1',
  `cancel_date` date DEFAULT NULL,
  `reason` varchar(100) CHARACTER SET latin1 NOT NULL,
  `cancelled_by` int(20) NOT NULL,
  `disposed_date` date NOT NULL,
  `iso_accredited` tinyint(1) NOT NULL,
  PRIMARY KEY (`tagging_id`),
  KEY `analysis_id` (`analysis_id`),
  KEY `tagging_status_id` (`tagging_status_id`),
  CONSTRAINT `tbl_tagging_ibfk_1` FOREIGN KEY (`analysis_id`) REFERENCES `tbl_analysis` (`analysis_id`),
  CONSTRAINT `tbl_tagging_ibfk_2` FOREIGN KEY (`tagging_status_id`) REFERENCES `tbl_tagging_status` (`tagging_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_tagging` */

/*Table structure for table `tbl_tagging_status` */

DROP TABLE IF EXISTS `tbl_tagging_status`;

CREATE TABLE `tbl_tagging_status` (
  `tagging_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `tagging_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tagging_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_tagging_status` */

insert  into `tbl_tagging_status`(`tagging_status_id`,`tagging_status`) values (1,'Pending'),(2,'Ongoing'),(3,'Completed'),(4,'Assigned'),(5,'Cancelled');

/*Table structure for table `tbl_test` */

DROP TABLE IF EXISTS `tbl_test`;

CREATE TABLE `tbl_test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `testname` varchar(200) CHARACTER SET latin1 NOT NULL,
  `method` varchar(150) CHARACTER SET latin1 NOT NULL,
  `references` varchar(100) CHARACTER SET latin1 NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `duration` int(11) NOT NULL,
  `test_category_id` int(11) NOT NULL,
  `sample_type_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  PRIMARY KEY (`test_id`),
  KEY `lab_id` (`lab_id`),
  KEY `test_category_id` (`test_category_id`),
  KEY `sample_type_id` (`sample_type_id`),
  CONSTRAINT `tbl_test_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `tbl_lab` (`lab_id`),
  CONSTRAINT `tbl_test_ibfk_2` FOREIGN KEY (`test_category_id`) REFERENCES `tbl_testcategory` (`test_category_id`),
  CONSTRAINT `tbl_test_ibfk_3` FOREIGN KEY (`sample_type_id`) REFERENCES `tbl_sampletype` (`sample_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_test` */

/*Table structure for table `tbl_testcategory` */

DROP TABLE IF EXISTS `tbl_testcategory`;

CREATE TABLE `tbl_testcategory` (
  `test_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `lab_id` int(11) NOT NULL,
  PRIMARY KEY (`test_category_id`),
  KEY `lab_id` (`lab_id`),
  CONSTRAINT `tbl_testcategory_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `tbl_lab` (`lab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_testcategory` */

insert  into `tbl_testcategory`(`test_category_id`,`category_name`,`lab_id`) values (1,'Proximate Analyses of Food Products and Raw Materials',1),(2,'Other Analyses of Food Products and Raw Materials',1),(3,'Fruit and Processed Fruit Products',1),(4,'Feeds / Fishmeal / Dried Fish',1),(5,'Spices and Other Condiments',1),(6,'Minerals in Food Samples',1),(7,'Trace Metals in Food Samples',1),(8,'Fats and Oils',1),(9,'Plants',1),(10,'Seaweeds',1),(11,'Fertilizer',1),(12,'Coal / Charcoal',1),(13,'Microbiological Analyses',2),(14,'Mass Calibration',3),(15,'Volume Calibration',3),(17,'Water and Wastewater',1),(18,'Others',1),(19,'Rubber Testing',1),(20,'Electrical Calibration',3),(21,'Temperature Calibration',3),(22,'Pressure Calibration',3),(23,'On-Site Calibration',3);

/*Table structure for table `tbl_testreport` */

DROP TABLE IF EXISTS `tbl_testreport`;

CREATE TABLE `tbl_testreport` (
  `testreport_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `report_num` varchar(50) CHARACTER SET latin1 NOT NULL,
  `report_date` date NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `release_date` date NOT NULL,
  `reissue` tinyint(1) NOT NULL,
  `previous_id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL,
  PRIMARY KEY (`testreport_id`),
  KEY `lab_id` (`lab_id`),
  KEY `request_id` (`request_id`),
  KEY `status_id` (`status_id`),
  KEY `previous_id` (`previous_id`),
  KEY `new_id` (`new_id`),
  CONSTRAINT `tbl_testreport_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `tbl_lab` (`lab_id`),
  CONSTRAINT `tbl_testreport_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `tbl_request` (`request_id`),
  CONSTRAINT `tbl_testreport_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `tbl_status` (`status_id`),
  CONSTRAINT `tbl_testreport_ibfk_4` FOREIGN KEY (`new_id`) REFERENCES `tbl_testreport` (`previous_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_testreport` */

/*Table structure for table `tbl_testreport_sample` */

DROP TABLE IF EXISTS `tbl_testreport_sample`;

CREATE TABLE `tbl_testreport_sample` (
  `testreport_sample_id` int(11) NOT NULL AUTO_INCREMENT,
  `testreport_id` int(11) NOT NULL,
  `sample_id` int(11) NOT NULL,
  PRIMARY KEY (`testreport_sample_id`),
  KEY `sample_id` (`sample_id`),
  KEY `testreport_id` (`testreport_id`),
  CONSTRAINT `tbl_testreport_sample_ibfk_1` FOREIGN KEY (`sample_id`) REFERENCES `tbl_sample` (`sample_id`),
  CONSTRAINT `tbl_testreport_sample_ibfk_2` FOREIGN KEY (`testreport_id`) REFERENCES `tbl_testreport` (`testreport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_testreport_sample` */

/*Table structure for table `tbl_testreportconfig` */

DROP TABLE IF EXISTS `tbl_testreportconfig`;

CREATE TABLE `tbl_testreportconfig` (
  `testreportconfig_id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `config_year` year(4) NOT NULL,
  PRIMARY KEY (`testreportconfig_id`),
  KEY `lab_id` (`lab_id`),
  CONSTRAINT `tbl_testreportconfig_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `tbl_lab` (`lab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_testreportconfig` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
