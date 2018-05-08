/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.16-log : Database - eulims_address
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `eulims_address`;

/*Table structure for table `tbl_barangay` */

DROP TABLE IF EXISTS `tbl_barangay`;

CREATE TABLE `tbl_barangay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `municipalityCityId` int(11) NOT NULL,
  `district` int(11) DEFAULT NULL,
  `barangay` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `municipalityCityId` (`municipalityCityId`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barangay` */

insert  into `tbl_barangay`(`id`,`municipalityCityId`,`district`,`barangay`) values (1,1,1,'Ayala'),(2,1,1,'Baliwasan'),(3,1,1,'Baluno'),(4,1,1,'Cabatangan'),(5,1,1,'Calarian'),(6,1,1,'Camino Nuevo'),(7,1,1,'Campo Islam'),(8,1,1,'Canelar'),(9,1,1,'Capisan'),(10,1,1,'Cawit'),(11,1,1,'Dulian (Upper Pasonanca)'),(12,1,1,'La Paz'),(13,1,1,'Labuan'),(14,1,1,'Limpapa'),(15,1,1,'Maasin'),(16,1,1,'Malagutay'),(17,1,1,'Mariki'),(18,1,1,'Pamucutan'),(19,1,1,'Pasonanca'),(20,1,1,'Patalon'),(21,1,1,'Recodo'),(22,1,1,'Rio Hondo'),(23,1,1,'San Jose Cawa-Cawa'),(24,1,1,'San Jose Gusu'),(25,1,1,'San Roque'),(26,1,1,'Sta. Barbara'),(27,1,1,'Sta. Maria'),(28,1,1,'Sto. Niño'),(29,1,1,'Sinubung'),(30,1,1,'Sinunuc'),(31,1,1,'Talisayan'),(32,1,1,'Tulungatung'),(33,1,1,'Tumaga'),(34,1,1,'Zone 1'),(35,1,1,'Zone 2'),(36,1,1,'Zone 3'),(37,1,1,'Zone 4'),(38,1,2,'Arena Blanco'),(39,1,2,'Boalan'),(40,1,2,'Bolong'),(41,1,2,'Buenavista'),(42,1,2,'Bunguiao'),(43,1,2,'Busay'),(44,1,2,'Cabaluay'),(45,1,2,'Cacao'),(46,1,2,'Calabasa'),(47,1,2,'Culianan'),(48,1,2,'Curuan'),(49,1,2,'Dita'),(50,1,2,'Divisoria'),(51,1,2,'Dulian (Upper Bunguiao)'),(52,1,2,'Guisao'),(53,1,2,'Guiwan'),(54,1,2,'Kasanyangan'),(55,1,2,'Lamisahan'),(56,1,2,'Landang Gua'),(57,1,2,'Landang Laum'),(58,1,2,'Lanzones'),(59,1,2,'Lapakan'),(60,1,2,'Latuan'),(61,1,2,'Licomo'),(62,1,2,'Limaong'),(63,1,2,'Lubigan'),(64,1,2,'Lumayang'),(65,1,2,'Lumbangan'),(66,1,2,'Lunzuran'),(67,1,2,'Mampang'),(68,1,2,'Manalipa'),(69,1,2,'Mangusu'),(70,1,2,'Manicahan'),(71,1,2,'Mercedes'),(72,1,2,'Muti'),(73,1,2,'Pangapuyan'),(74,1,2,'Panubigan'),(75,1,2,'Pasilmanta'),(76,1,2,'Pasobolong'),(77,1,2,'Putik'),(78,1,2,'Quiniput'),(79,1,2,'Salaan'),(80,1,2,'Sangali'),(81,1,2,'Sta. Catalina'),(82,1,2,'Sibulao'),(83,1,2,'Tagasilay'),(84,1,2,'Taguiti'),(85,1,2,'Talabaan'),(86,1,2,'Talon-Talon'),(87,1,2,'Taluksangay'),(88,1,2,'Tetuan'),(89,1,2,'Tictapul'),(90,1,2,'Tigbalabag'),(91,1,2,'Tictabon'),(92,1,2,'Tolosa'),(93,1,2,'Tugbungan'),(94,1,2,'Tumalutap'),(95,1,2,'Tumitus'),(96,1,2,'Victoria'),(97,1,2,'Vitali'),(98,1,2,'Zambowood');

/*Table structure for table `tbl_municipality_city` */

DROP TABLE IF EXISTS `tbl_municipality_city`;

CREATE TABLE `tbl_municipality_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regionId` int(11) NOT NULL,
  `provinceId` int(11) NOT NULL,
  `municipality` varchar(100) NOT NULL,
  `district` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provinceId` (`provinceId`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_municipality_city` */

insert  into `tbl_municipality_city`(`id`,`regionId`,`provinceId`,`municipality`,`district`) values (1,12,1,'Zamboanga City',NULL),(2,12,2,'Pagadian City',1),(3,12,2,'Aurora',1),(4,12,2,'Dumingag',1),(5,12,2,'Josefina',1),(6,12,2,'Labangan',1),(7,12,2,'Mahayag',1),(8,12,2,'Midsalip',1),(9,12,2,'Molave',1),(10,12,2,'Ramon Magsaysay',1),(11,12,2,'Sominot',1),(12,12,2,'Tambulig',1),(13,12,2,'Tukuran',1),(14,12,2,'Bayog',2),(15,12,2,'Dimataling',2),(16,12,2,'Dinas',2),(17,12,2,'Dumalinao',2),(18,12,2,'Guipos',2),(19,12,2,'Kumalarang',2),(20,12,2,'Lakewood',2),(21,12,2,'Lapuyan',2),(22,12,2,'Margosatubig',2),(23,12,2,'Pitogo',2),(24,12,2,'San Miguel',2),(25,12,2,'San Pablo',2),(26,12,2,'Tabina',2),(27,12,2,'Tigbao',2),(28,12,2,'Vincenzo A. Sagun',2),(29,12,3,'Dapitan City',1),(30,12,3,'La Libertad',1),(31,12,3,'Mutia',1),(32,12,3,'Piñan',1),(33,12,3,'Polanco',1),(34,12,3,'Rizal',1),(35,12,3,'Sergio Osmeña Sr.',1),(36,12,3,'Sibutad',1),(37,12,3,'Dipolog City',2),(38,12,3,'Jose Dalman',2),(39,12,3,'Katipunan',2),(40,12,3,'Manukan',2),(41,12,3,'Pres. Manuel A. Roxas',2),(42,12,3,'Siayan',2),(43,12,3,'Sindangan',2),(44,12,3,'Baliguian',3),(45,12,3,'Godod',3),(46,12,3,'Gutalac',3),(47,12,3,'Kalawit',3),(48,12,3,'Labason',3),(49,12,3,'Leon B. Postigo',3),(50,12,3,'Liloy',3),(51,12,3,'Salug',3),(52,12,3,'Sibuco',3),(53,12,3,'Siocon',3),(54,12,3,'Sirawai',3),(55,12,3,'Tampilisan',3),(56,12,4,'Alicia',1),(57,12,4,'Buug',1),(58,12,4,'Diplahan',1),(59,12,4,'Imelda',1),(60,12,4,'Mabuhay',1),(61,12,4,'Malangas',1),(62,12,4,'Olutanga',1),(63,12,4,'Payao',1),(64,12,4,'Talusan',1),(65,12,4,'Ipil',2),(66,12,4,'Kabasalan',2),(67,12,4,'Naga',2),(68,12,4,'Roseller Lim',2),(69,12,4,'Siay',2),(70,12,4,'Titay',2),(71,12,4,'Tungawan',2),(72,12,5,'Isabela City',1),(73,17,5,'Lamitan City',1),(74,17,5,'Akbar',1),(75,17,5,'Al-Barka',1),(76,17,5,'Hadji Mohammad Ajul',1),(77,17,5,'Hadji Muhtamad',1),(78,17,5,'Lantawan',1),(79,17,5,'Maluso',1),(80,17,5,'Sumisip',1),(81,17,5,'Tabuan-Lasa',1),(82,17,5,'Tipo-Tipo',1),(83,17,5,'Tuburan',1),(84,17,5,'Ungkaya Pukan',1),(85,17,6,'Hadji Panglima Tahil',1),(86,17,6,'Indanan',1),(87,17,6,' Jolo',1),(88,17,6,'Maimbung',1),(89,17,6,'Pangutaran',1),(91,17,6,'Parang',1),(92,17,6,'Patikul',1),(93,17,6,'Banguingui',2),(94,17,6,'Kalingalan Caluang',2),(95,17,6,'Lugus',2),(96,17,6,'Luuk',2),(97,17,6,'Old Panamao',2),(98,17,6,'Omar',2),(99,17,6,'Pandami',2),(100,17,6,'Panglima Estino',2),(101,17,6,'Pata',2),(102,17,6,'Siasi',2),(103,17,6,'Tapul',2),(104,17,6,'Talipao',1),(105,17,7,'Bongao',1),(106,17,7,'Languyan',1),(107,17,7,'Mapun',1),(108,17,7,'Panglima Sugala',1),(109,17,7,'Sapa-Sapa',1),(110,17,7,'Sibutu',1),(111,17,7,'Simunul',1),(112,17,7,'Sitangkai',1),(113,17,7,'South Ubian',1),(114,17,7,'Tandubas',1),(115,17,7,'Turtle Islands',1),(116,16,8,'Butuan City',1),(117,16,9,'Las Nieves',1),(118,16,9,'Cabadbaran City',2),(119,16,9,'Buenavista',2),(120,16,9,'Carmen',2),(121,16,9,'Jabonga',2),(122,16,9,'Kitcharao',2),(123,16,9,'Magallanes',2),(124,16,9,'Nasipit',2),(125,16,9,'Remedios T. Romualdez',2),(126,16,9,'Santiago',2),(127,16,9,'Tubay',2),(128,16,10,'Bayugan City',1),(129,16,10,'Esperanza',1),(130,16,10,'Properidad',1),(131,16,10,'San Luis',1),(132,16,10,'Sibagat',1),(133,16,10,'Talacogon',1),(134,16,10,'Bunawan',2),(135,16,10,'La Paz',2),(136,16,10,'Loreto',2),(137,16,10,'San Francisco',2),(138,16,10,'Santa Josefa',2),(139,16,10,'Trento',2),(140,16,10,'Veruela',2),(141,13,14,'Oroquieta City',1);

/*Table structure for table `tbl_province` */

DROP TABLE IF EXISTS `tbl_province`;

CREATE TABLE `tbl_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regionId` int(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_province` */

insert  into `tbl_province`(`id`,`regionId`,`province`,`code`) values (1,12,'Zamboanga City','ZAM'),(2,12,'Zamboanga del Sur','ZDS'),(3,12,'Zamboanga del Norte','ZDN'),(4,12,'Zamboanga Sibugay','ZSIB'),(5,17,'Basilan','BAS'),(6,17,'Sulu','SUL'),(7,17,'Tawi-Tawi','TAW'),(8,16,'Butuan City','BXU'),(9,16,'Agusan del Norte','ADN'),(10,16,'Agusan del Sur','ADS'),(11,16,'Dinagat Islands','DIN'),(12,16,'Surigao del Norte','SDN'),(13,16,'Surigao del Sur','SDS'),(14,13,'Misamis Occidental','MIS-OC');

/*Table structure for table `tbl_region` */

DROP TABLE IF EXISTS `tbl_region`;

CREATE TABLE `tbl_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `region` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_region` */

insert  into `tbl_region`(`id`,`code`,`region`) values (1,'NCR','National Capital Region'),(2,'CAR','Cordillera Administrative Region'),(3,'Region I','Ilocos Region'),(4,'Region II','Cagayan Valley'),(5,'Region III','Central Luzon'),(6,'Region IV-A','CALABARZON'),(7,'Region IV-B','MIMAROPA'),(8,'Region V','Bicol Region'),(9,'Region VI','Western Visayas'),(10,'Region VII','Central Visayas'),(11,'Region VIII','Eastern Visayas'),(12,'Region IX','Zamboanga Peninsula'),(13,'Region X','Northern Mindanao'),(14,'Region XI','Davao Region'),(15,'Region XII','SOCCSKSARGEN'),(16,'CARAGA','Caraga Region'),(17,'ARMM','Autonomous Region in Muslim Mindanao');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
