/*
SQLyog Ultimate v9.63 
MySQL - 5.1.50-community : Database - jobjapthai
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jobjapthai` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `jobjapthai`;

/*Table structure for table `ics_employer_package` */

DROP TABLE IF EXISTS `ics_employer_package`;

CREATE TABLE `ics_employer_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT '1' COMMENT '1=package, 2=time',
  `position` int(11) DEFAULT NULL,
  `name` varchar(120) DEFAULT NULL,
  `title` varchar(120) DEFAULT NULL,
  `text` varchar(120) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `description` text,
  `require` int(1) DEFAULT '0',
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `publish` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `ics_employer_package` */

insert  into `ics_employer_package`(`id`,`type`,`position`,`name`,`title`,`text`,`price`,`description`,`require`,`create_datetime`,`update_datetime`,`publish`) values (1,1,1,'employerCalPositionAmount','จำนวนตำแหน่ง','Business Package : 1 ตำแหน่งงาน','600.00',NULL,1,'2014-12-15 21:08:37',NULL,1),(2,1,1,'employerCalPositionAmount','จำนวนตำแหน่ง','Business Package : 3 ตำแหน่งงาน','800.00',NULL,1,'2014-12-15 21:08:39',NULL,1),(3,2,1,'employerCalDuration','ระยะเวลา','2 สัปดาห์','1.00',NULL,1,'2014-12-15 21:08:39',NULL,1),(4,2,1,'employerCalDuration','ระยะเวลา','1 เดือน','2.00',NULL,1,'2014-12-15 21:08:39',NULL,1),(5,2,1,'employerCalDuration','ระยะเวลา','2 เดือน','4.00',NULL,1,'2014-12-15 21:08:39',NULL,1),(6,1,2,'employerCalSuperHotJobDuration','ระยะเวลา','--------------------','0.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(7,1,2,'employerCalSuperHotJobDuration','ระยะเวลา','3 วัน','1500.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(8,1,2,'employerCalSuperHotJobDuration','ระยะเวลา','6 วัน','1800.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(9,1,3,'employerCalHotJobType','ประเภท','--------------------','0.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(10,1,3,'employerCalHotJobType','ประเภท','Business Package : 1 ตำแหน่งงาน','600.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(11,1,3,'employerCalHotJobType','ประเภท','Business Package : 3 ตำแหน่งงาน','800.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(12,2,3,'employerCalHotJobDuration','ระยะเวลา','2 สัปดาห์','1.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(13,2,3,'employerCalHotJobDuration','ระยะเวลา','1 เดือน','2.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(14,2,3,'employerCalHotJobDuration','ระยะเวลา','2 เดือน','4.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(15,1,4,'employerCalUrgentDuration','ระยะเวลา','2 สัปดาห์','300.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(16,1,4,'employerCalUrgentDuration','ระยะเวลา','1 เดือน','600.00',NULL,0,'2014-12-15 21:08:39',NULL,1),(17,1,4,'employerCalUrgentDuration','ระยะเวลา','2 เดือน','1200.00',NULL,0,'2014-12-15 21:08:39',NULL,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
