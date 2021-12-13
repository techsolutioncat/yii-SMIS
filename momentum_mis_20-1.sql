-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: momentum_mis
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `additional_category_section`
--

DROP TABLE IF EXISTS `additional_category_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additional_category_section` (
  `acs_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(7) DEFAULT NULL,
  `category_name` varchar(20) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `is_deducted` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `lifetime` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`acs_id`),
  KEY `FK_additional_category_section_employee_info` (`emp_id`),
  CONSTRAINT `FK_additional_category_section_employee_info` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_category_section`
--

LOCK TABLES `additional_category_section` WRITE;
/*!40000 ALTER TABLE `additional_category_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `additional_category_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance_main`
--

DROP TABLE IF EXISTS `attendance_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Din` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `checktype` varchar(8) DEFAULT NULL,
  `verifymode` tinyint(8) DEFAULT NULL COMMENT '1 for checkin and 2 for checkout',
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`fk_user_id`),
  CONSTRAINT `attendance_main_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_main`
--

LOCK TABLES `attendance_main` WRITE;
/*!40000 ALTER TABLE `attendance_main` DISABLE KEYS */;
INSERT INTO `attendance_main` VALUES (13,23,23,'2016-12-16 07:16:17','I',0),(14,23,23,'2016-12-16 07:17:40','O',0),(22,22,22,'2016-12-16 07:16:12','I',0),(23,22,22,'2016-12-16 07:17:33','O',0),(44,23,23,'2016-12-16 07:16:17','I',0),(45,23,23,'2016-12-16 07:17:40','O',0),(53,22,22,'2016-12-19 07:16:12','I',0),(54,22,22,'2016-12-19 07:17:33','O',0);
/*!40000 ALTER TABLE `attendance_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance_mode`
--

DROP TABLE IF EXISTS `attendance_mode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_mode`
--

LOCK TABLES `attendance_mode` WRITE;
/*!40000 ALTER TABLE `attendance_mode` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_mode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance_type`
--

DROP TABLE IF EXISTS `attendance_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_type`
--

LOCK TABLES `attendance_type` WRITE;
/*!40000 ALTER TABLE `attendance_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `fk_city_id` int(11) NOT NULL,
  `fk_district_id` int(11) NOT NULL,
  `fk_province_id` int(11) NOT NULL,
  `fk_country_id` int(11) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','deactivate') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `fk_city_id` (`fk_city_id`,`fk_district_id`,`fk_province_id`),
  KEY `fk_district_id` (`fk_district_id`),
  KEY `fk_province_id` (`fk_province_id`),
  KEY `country name` (`fk_country_id`),
  CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`fk_city_id`) REFERENCES `ref_cities` (`city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `branch_ibfk_2` FOREIGN KEY (`fk_district_id`) REFERENCES `ref_district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `branch_ibfk_3` FOREIGN KEY (`fk_province_id`) REFERENCES `ref_province` (`province_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `branch_ibfk_4` FOREIGN KEY (`fk_country_id`) REFERENCES `ref_countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch`
--

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
INSERT INTO `branch` VALUES (1,'Pips','descriptipon',NULL,NULL,1111,111,1,1,'3456',NULL,NULL,'salman@gmail.com','active'),(9,'test-branch','tst',NULL,'ad',1111,111,1,1,'232','','','ali@gmail.com','active'),(10,'Testing-Branch','This is a test branch',NULL,'abcdef',6111,611,6,1,'44000','0909090909','www.xyz.com','abc@xyz.com','active'),(17,'educators','educators',NULL,'Peshawar road',3745,374,3,1,'46000','','','educators@test.com','active');
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkinout`
--

DROP TABLE IF EXISTS `checkinout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkinout` (
  `USERID` int(11) DEFAULT NULL,
  `CHECKTIME` datetime DEFAULT NULL,
  `CHECKTYPE` varchar(1) DEFAULT NULL,
  `VERIFYCODE` int(11) DEFAULT NULL,
  `SENSORID` varchar(5) DEFAULT NULL,
  `Memoinfo` varchar(30) DEFAULT NULL,
  `WorkCode` varchar(24) DEFAULT NULL,
  `sn` varchar(20) DEFAULT NULL,
  `UserExtFmt` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkinout`
--

LOCK TABLES `checkinout` WRITE;
/*!40000 ALTER TABLE `checkinout` DISABLE KEYS */;
INSERT INTO `checkinout` VALUES (1,'2103-08-18 06:30:51','I',0,'101',NULL,'0','6414151500616',1),(1,'2103-08-18 06:30:57','O',0,'101',NULL,'0','6414151500616',1),(1,'2103-08-18 06:31:02','I',0,'101',NULL,'0','6414151500616',1),(1,'2103-08-18 06:31:07','O',0,'101',NULL,'0','6414151500616',1),(2,'2103-08-18 06:36:22','I',0,'101',NULL,'0','6414151500616',1),(2,'2103-08-18 06:37:17','O',0,'101',NULL,'0','6414151500616',1),(3,'1970-01-01 00:00:21','I',0,'101',NULL,'0','6414151500616',1),(3,'1970-01-01 00:00:27','O',0,'101',NULL,'0','6414151500616',1),(3,'1970-01-01 00:00:36','I',0,'101',NULL,'0','6414151500616',1),(3,'1970-01-01 00:00:48','O',0,'101',NULL,'0','6414151500616',1),(3,'2016-12-16 07:16:17','I',0,'101',NULL,'0','6414151500616',1),(3,'2016-12-16 07:17:40','O',0,'101',NULL,'0','6414151500616',1),(3,'2103-08-18 07:01:18','I',0,'101',NULL,'0','6414151500616',1),(3,'2103-08-18 07:01:29','O',0,'101',NULL,'0','6414151500616',1),(3,'2103-08-18 07:01:41','I',0,'101',NULL,'0','6414151500616',1),(3,'2103-08-18 07:01:45','O',0,'101',NULL,'0','6414151500616',1),(4,'1970-01-01 00:00:16','I',0,'101',NULL,'0','6414151500616',1),(4,'1970-01-01 00:00:31','O',0,'101',NULL,'0','6414151500616',1),(4,'1970-01-01 00:00:42','I',0,'101',NULL,'0','6414151500616',1),(4,'2016-12-16 07:16:12','I',0,'101',NULL,'0','6414151500616',1),(4,'2016-12-16 07:17:33','O',0,'101',NULL,'0','6414151500616',1),(4,'2103-08-18 07:01:23','I',0,'101',NULL,'0','6414151500616',1),(4,'2103-08-18 07:01:35','O',0,'101',NULL,'0','6414151500616',1),(4,'2103-08-18 07:01:48','I',0,'101',NULL,'0','6414151500616',1),(4,'2103-08-18 07:01:51','O',0,'101',NULL,'0','6414151500616',1);
/*!40000 ALTER TABLE `checkinout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `defult_salary_section`
--

DROP TABLE IF EXISTS `defult_salary_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `defult_salary_section` (
  `ss_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) NOT NULL,
  `id_deducted` tinyint(1) NOT NULL,
  PRIMARY KEY (`ss_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defult_salary_section`
--

LOCK TABLES `defult_salary_section` WRITE;
/*!40000 ALTER TABLE `defult_salary_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `defult_salary_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empl_educational_history_info`
--

DROP TABLE IF EXISTS `empl_educational_history_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empl_educational_history_info` (
  `edu_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `degree_name` varchar(50) NOT NULL,
  `degree_type_id` int(11) DEFAULT NULL,
  `Institute_name` varchar(50) NOT NULL,
  `institute_type_id` varchar(15) DEFAULT NULL,
  `grade` varchar(4) DEFAULT NULL,
  `total_marks` varchar(4) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `emp_id` int(11) NOT NULL,
  `marks_obtained` char(4) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`edu_history_id`),
  KEY `FK_empl_educational_history_info_ref_degree_type` (`degree_type_id`),
  KEY `FK_empl_educational_history_info_employee_info` (`emp_id`),
  KEY `branch id` (`fk_branch_id`),
  CONSTRAINT `FK_empl_educational_history_info_employee_info` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_empl_educational_history_info_ref_degree_type` FOREIGN KEY (`degree_type_id`) REFERENCES `ref_degree_type` (`degree_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_empl_educational_history_info_ref_institute_type` FOREIGN KEY (`degree_type_id`) REFERENCES `ref_institute_type` (`institute_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `empl_educational_history_info_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `empl_educational_history_info_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empl_educational_history_info`
--

LOCK TABLES `empl_educational_history_info` WRITE;
/*!40000 ALTER TABLE `empl_educational_history_info` DISABLE KEYS */;
INSERT INTO `empl_educational_history_info` VALUES (1,1,'HSSC',1,'ICB','1','A','1100','2016-12-01','2016-12-31',4,'950'),(2,1,'HSSC',1,'ICB','1','A','1100','2016-12-01','2016-12-31',2,'955'),(3,1,'BSC',NULL,'Arid Agriculture',NULL,'A','500','2016-12-16','2016-12-16',3,'450'),(4,1,'bachelor',NULL,'test',NULL,'b','100','2016-12-11','2016-12-22',8,'23'),(5,1,'tw',NULL,'asfasd',NULL,'b','100','2016-12-19','2016-12-18',9,'23'),(6,1,'A level',NULL,'Roots',NULL,'b','100','2016-12-01','2016-12-11',10,'78'),(7,1,'BA',NULL,'BBBB',NULL,'v','90','2016-12-07','2016-12-15',12,'67'),(8,1,'BSC',NULL,'PCC',NULL,'B','700','2009-03-19','2011-06-23',13,'500'),(9,1,'BBA',NULL,'LUMS',NULL,'A+','1000','2016-12-06','2016-12-07',23,'900'),(10,1,'mASTER',NULL,'PUNJAB UNIVERSITY',NULL,'','1100','2017-01-08','2017-02-23',32,''),(11,1,'MASTER',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',33,''),(12,1,'MASTER',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',34,''),(13,1,'MASTER',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',35,''),(14,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-01',36,''),(15,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',37,''),(16,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',38,''),(17,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',39,''),(18,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',40,''),(19,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',41,''),(20,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',42,''),(21,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',42,''),(22,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-01',43,''),(23,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',44,''),(24,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',45,''),(25,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',46,''),(26,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',47,''),(27,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',48,''),(28,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',49,''),(29,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',50,''),(30,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',51,''),(31,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',52,''),(32,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',53,''),(33,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',54,''),(34,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',55,''),(35,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',56,''),(36,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',57,''),(37,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',58,''),(38,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',58,''),(39,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',59,''),(40,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',60,''),(41,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',61,''),(42,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',62,''),(43,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',62,''),(44,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',63,''),(45,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',64,''),(46,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',65,''),(47,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',66,''),(48,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',67,''),(49,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',68,''),(50,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',69,''),(51,1,'PUNJAB',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',70,''),(52,1,'MASTER',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',71,''),(53,1,'MASTER',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',72,''),(54,1,'MASTER',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',73,''),(55,1,'MASTER',NULL,'PUNJAB',NULL,'','1100','2017-01-01','2017-01-31',74,'');
/*!40000 ALTER TABLE `empl_educational_history_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empl_job_history_info`
--

DROP TABLE IF EXISTS `empl_job_history_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empl_job_history_info` (
  `job_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(20) NOT NULL,
  `employer_name` varchar(50) NOT NULL,
  `designation` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_Salary` varchar(7) NOT NULL,
  `End_Salary` varchar(7) NOT NULL,
  `emp_id` int(11) NOT NULL,
  PRIMARY KEY (`job_history_id`),
  KEY `FK_empl_job_history_info_employee_info` (`emp_id`),
  CONSTRAINT `FK_empl_job_history_info_employee_info` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empl_job_history_info`
--

LOCK TABLES `empl_job_history_info` WRITE;
/*!40000 ALTER TABLE `empl_job_history_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `empl_job_history_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_attendance`
--

DROP TABLE IF EXISTS `employee_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_empl_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `leave_type` varchar(15) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empl_id` (`fk_empl_id`),
  CONSTRAINT `employee_attendance_ibfk_1` FOREIGN KEY (`fk_empl_id`) REFERENCES `employee_info` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_attendance`
--

LOCK TABLES `employee_attendance` WRITE;
/*!40000 ALTER TABLE `employee_attendance` DISABLE KEYS */;
INSERT INTO `employee_attendance` VALUES (1,1,'2017-01-19 11:23:04','absent',NULL),(2,2,'2017-01-19 11:23:04','absent',NULL),(3,3,'2017-01-19 11:23:04','absent',NULL),(4,4,'2017-01-19 11:23:04','absent',NULL),(5,5,'2017-01-19 11:23:04','absent',NULL),(6,6,'2017-01-19 11:23:04','absent',NULL),(7,7,'2017-01-19 11:23:04','absent',NULL),(8,8,'2017-01-19 11:23:04','absent',NULL),(9,9,'2017-01-19 11:23:04','absent',NULL),(10,10,'2017-01-19 11:23:04','absent',NULL),(11,11,'2017-01-19 11:23:04','absent',NULL),(12,12,'2017-01-19 11:23:04','absent',NULL),(13,13,'2017-01-19 11:23:04','absent',NULL),(14,14,'2017-01-19 11:23:04','absent',NULL),(15,15,'2017-01-19 11:23:04','absent',NULL),(16,16,'2017-01-19 11:23:04','absent',NULL),(17,17,'2017-01-19 11:23:04','absent',NULL),(18,18,'2017-01-19 11:23:04','absent',NULL),(19,19,'2017-01-19 11:23:04','absent',NULL),(20,20,'2017-01-19 11:23:04','absent',NULL),(21,21,'2017-01-19 11:23:04','absent',NULL),(22,22,'2017-01-19 11:23:04','absent',NULL),(23,23,'2017-01-19 11:23:04','absent',NULL),(24,24,'2017-01-19 11:23:04','absent',NULL),(25,25,'2017-01-19 11:23:04','absent',NULL),(26,26,'2017-01-19 11:23:04','absent',NULL),(27,27,'2017-01-19 11:23:04','absent',NULL),(28,28,'2017-01-19 11:23:04','absent',NULL),(29,29,'2017-01-19 11:23:04','absent',NULL),(30,30,'2017-01-19 11:23:04','absent',NULL),(31,31,'2017-01-19 11:23:04','absent',NULL),(32,32,'2017-01-19 11:23:04','absent',NULL),(33,33,'2017-01-19 11:23:04','absent',NULL),(34,34,'2017-01-19 11:23:04','absent',NULL),(35,35,'2017-01-19 11:23:04','absent',NULL),(36,36,'2017-01-19 11:23:04','absent',NULL),(37,37,'2017-01-19 11:23:04','absent',NULL),(38,38,'2017-01-19 11:23:04','absent',NULL),(39,39,'2017-01-19 11:23:04','absent',NULL),(40,40,'2017-01-19 11:23:04','absent',NULL),(41,41,'2017-01-19 11:23:04','absent',NULL),(42,42,'2017-01-19 11:23:04','absent',NULL),(43,43,'2017-01-19 11:23:04','absent',NULL),(44,44,'2017-01-19 11:23:04','absent',NULL),(45,45,'2017-01-19 11:23:04','absent',NULL),(46,46,'2017-01-19 11:23:04','absent',NULL),(47,47,'2017-01-19 11:23:04','absent',NULL),(48,48,'2017-01-19 11:23:04','absent',NULL),(49,49,'2017-01-19 11:23:04','absent',NULL),(50,50,'2017-01-19 11:23:04','absent',NULL),(51,51,'2017-01-19 11:23:04','absent',NULL),(52,52,'2017-01-19 11:23:04','absent',NULL),(53,53,'2017-01-19 11:23:04','absent',NULL),(54,54,'2017-01-19 11:23:04','absent',NULL),(55,55,'2017-01-19 11:23:04','absent',NULL),(56,56,'2017-01-19 11:23:04','absent',NULL),(57,57,'2017-01-19 11:23:04','absent',NULL),(58,58,'2017-01-19 11:23:04','absent',NULL),(59,59,'2017-01-19 11:23:04','absent',NULL),(60,60,'2017-01-19 11:23:04','absent',NULL),(61,61,'2017-01-19 11:23:04','absent',NULL),(62,62,'2017-01-19 11:23:04','absent',NULL),(63,63,'2017-01-19 11:23:04','absent',NULL),(64,64,'2017-01-19 11:23:04','absent',NULL),(65,65,'2017-01-19 11:23:04','absent',NULL),(66,66,'2017-01-19 11:23:04','absent',NULL),(67,67,'2017-01-19 11:23:04','absent',NULL),(68,68,'2017-01-19 11:23:04','absent',NULL),(69,69,'2017-01-19 11:23:04','absent',NULL),(70,70,'2017-01-19 11:23:04','absent',NULL),(71,71,'2017-01-19 11:23:04','absent',NULL),(72,72,'2017-01-19 11:23:04','absent',NULL),(73,73,'2017-01-19 11:23:04','absent',NULL),(74,74,'2017-01-19 11:23:04','absent',NULL);
/*!40000 ALTER TABLE `employee_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_info`
--

DROP TABLE IF EXISTS `employee_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_info` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Name_in_urdu` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `emergency_contact_no` varchar(30) DEFAULT NULL,
  `gender_type` tinyint(1) NOT NULL,
  `guardian_type_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `designation_id` int(11) NOT NULL,
  `marital_status` int(11) NOT NULL,
  `department_type_id` int(11) NOT NULL,
  `salary` bigint(20) DEFAULT NULL,
  `religion_type_id` int(11) NOT NULL,
  `location1` varchar(50) NOT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  `location2` char(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `cnic` varchar(15) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`emp_id`),
  KEY `FK_employee_info_ref_countries` (`country_id`),
  KEY `FK_employee_info_ref_Province` (`province_id`),
  KEY `FK_employee_info_ref_Cities` (`city_id`),
  KEY `FK_employee_info_ref_District` (`district_id`),
  KEY `FK_employee_info_ref_religion` (`religion_type_id`),
  KEY `FK_employee_info_ref_department` (`department_type_id`),
  KEY `FK_employee_info_ref_desigination` (`designation_id`),
  KEY `FK_employee_info_ref_gardian_type` (`guardian_type_id`),
  KEY `branch id` (`fk_branch_id`),
  KEY `user id` (`user_id`),
  KEY `employee_search_1_26122016` (`dob`,`contact_no`,`emergency_contact_no`,`cnic`),
  CONSTRAINT `FK_employee_info_ref_Cities` FOREIGN KEY (`city_id`) REFERENCES `ref_cities` (`city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_employee_info_ref_District` FOREIGN KEY (`district_id`) REFERENCES `ref_district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_employee_info_ref_Province` FOREIGN KEY (`province_id`) REFERENCES `ref_province` (`province_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_employee_info_ref_countries` FOREIGN KEY (`country_id`) REFERENCES `ref_countries` (`country_id`),
  CONSTRAINT `FK_employee_info_ref_department` FOREIGN KEY (`department_type_id`) REFERENCES `ref_department` (`department_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_employee_info_ref_desigination` FOREIGN KEY (`designation_id`) REFERENCES `ref_designation` (`designation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_employee_info_ref_gardian_type` FOREIGN KEY (`guardian_type_id`) REFERENCES `ref_gardian_type` (`gardian_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_employee_info_ref_religion` FOREIGN KEY (`religion_type_id`) REFERENCES `ref_religion` (`religion_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employee_info_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employee_info_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_info`
--

LOCK TABLES `employee_info` WRITE;
/*!40000 ALTER TABLE `employee_info` DISABLE KEYS */;
INSERT INTO `employee_info` VALUES (1,1,22,'','2016-12-20','343','',1,2,1,1,1311,'2016-12-20',4,1,4,NULL,2,'345345','','','33333-3333333-3',131,1),(2,1,23,'','2016-12-20','87574779897086','3534534534',1,2,1,6,6111,'2016-12-20',4,1,3,34534,2,'kjjfkjhg','hjhgj','hfkjh','87575-3677986-5',611,1),(3,1,24,'','2016-12-16','34534','345345',1,NULL,1,1,1311,'2016-12-16',4,2,4,4500,2,'tertert','pakistan','','34353-4534534-5',131,1),(4,1,25,'','1995-03-03','1212121212','2121212121',1,NULL,1,6,6111,'2016-02-24',3,1,4,5555,2,'hhh66h6h','Pakistani','','67856-4787976-7',611,1),(5,1,26,'','2016-12-02','1212121212','2121212121',1,NULL,1,1,1111,'2016-02-24',5,1,4,5555,2,'hhh66h6h','Pakistani','','33333-3333333-3',111,1),(6,1,27,'','1995-03-23','1212121212','2121212121',0,NULL,1,1,1311,'2011-07-28',3,2,3,5555,2,'hhh66h6h','Pakistani','','33333-3333333-3',131,1),(7,1,28,'','2016-12-02','1212121212','2121212121',1,NULL,1,3,3112,'2016-02-24',3,1,4,5555,2,'hhh66h6h','Pakistani','','76653-6689868-9',311,1),(8,1,36,'','2016-12-19','','',1,NULL,1,1,1111,'2016-12-19',3,1,3,NULL,2,'test','','','',111,1),(9,1,37,'','2016-12-19','','',1,NULL,NULL,NULL,NULL,'2016-12-19',3,1,3,NULL,2,'ete','','','',NULL,1),(10,1,38,'','2016-11-30','','',1,NULL,NULL,NULL,NULL,'2016-12-09',4,1,3,NULL,2,'jkhfjhdg','','','',NULL,1),(11,1,42,'','2016-12-20','','',1,NULL,1,1,1111,'2016-12-20',4,1,3,NULL,2,'hi','','','',111,1),(12,1,43,'','2016-12-20','','',1,NULL,1,1,1121,'2016-12-20',6,1,4,NULL,2,'jhgkjhljgk','','','',112,1),(13,1,44,'','2000-02-07','7666776767667','767676767667',1,NULL,1,4,8580,'2016-12-01',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','98977-6545778-9',415,1),(14,1,45,'','2000-02-07','7666776767667','767676767667',1,NULL,1,1,1221,'2016-12-01',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','',122,1),(15,1,46,'ÿ¨ÿßŸÜ','2016-12-20','034694454','',1,NULL,NULL,NULL,NULL,'2016-12-20',4,1,3,600006,2,'peshawar','pakistan','','23423-4234234-3',NULL,1),(16,1,47,NULL,'2016-12-21','','',1,NULL,NULL,NULL,NULL,'2016-12-21',4,1,3,NULL,2,'cgvncncv','','','',NULL,1),(17,1,48,NULL,'2016-12-21','7666776767667','767676767667',1,NULL,1,1,1221,'2016-12-21',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','00000-0098789-5',122,1),(18,1,49,NULL,'2000-02-07','7666776767667','767676767667',1,NULL,1,1,1221,'2016-12-01',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','00000-0098789-5',122,1),(19,1,50,NULL,'2016-12-21','','',1,NULL,NULL,NULL,NULL,'2016-12-21',4,1,3,NULL,2,'asdasd','','','',NULL,1),(20,1,52,NULL,'2000-02-07','7666776767667','767676767667',1,NULL,1,1,1221,'2016-12-01',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','00000-0098789-5',122,1),(21,1,54,NULL,'2016-12-22','03469475085','',1,NULL,NULL,NULL,NULL,'2016-12-22',3,1,3,600006,2,'peshawar','pakistan','','23423-4324234-2',NULL,1),(22,1,56,NULL,'2000-02-07','7666776767667','767676767667',1,NULL,1,1,1221,'2016-12-01',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','00000-0098789-5',122,1),(23,9,59,NULL,'2016-12-26','7666776767667','767676767667',1,NULL,1,1,1221,'2016-12-26',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','00000-0098789-5',122,1),(24,9,60,NULL,'2000-02-07','7666776767667','767676767667',1,NULL,1,1,1221,'2016-12-01',3,1,3,87878787,2,'bbggbbg','Pakistani','mmnbvv','00000-0098789-5',122,1),(25,9,65,NULL,'2000-02-07','766677676111','76767676766767',1,NULL,1,1,1221,'2016-12-01',3,1,3,8765,2,'bbggbbg','Pakistani','mmnbvv','00000-0098879-0',122,0),(26,9,66,NULL,'2016-12-31','345345','345345',1,NULL,1,1,1711,'2016-12-31',5,1,6,45000,2,'erterte','klsdjflsd','etrte','22222-2222222-2',171,0),(27,9,67,NULL,'2017-01-01','','',1,NULL,NULL,NULL,NULL,'2017-01-02',4,1,3,NULL,2,'tyggg','','','',NULL,0),(28,9,69,NULL,'2017-01-05','766677676100','7676767670000',1,NULL,1,1,1221,'2016-12-29',3,1,3,8765,2,'bbggbbg','Pakistani','mmnbvv','11100-0098879-0',122,0),(29,9,76,NULL,'2016-02-11','03005599689','',1,NULL,1,3,3745,'2016-08-20',5,1,3,NULL,2,'sjkdhaskhd','pakistan','','11111-1111111-1',374,0),(30,17,78,NULL,'2017-01-09','','',1,NULL,NULL,NULL,NULL,'2017-01-09',4,1,3,NULL,2,'ljlkj;lkj 8798 kl','','','61107-6666665-4',NULL,0),(31,17,80,NULL,'2017-01-09','4534534534534','',1,NULL,1,1,1311,'2017-01-09',3,1,3,NULL,2,'House 324 street 73','Pakistan','House 324 street 73','',131,0),(32,17,83,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-01',5,2,7,NULL,2,'412','','','00000-0000000-0',374,1),(33,17,84,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',11,2,7,NULL,2,'412','','','',374,1),(34,17,85,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',9,2,8,NULL,2,'PAKISTAN','','','',374,0),(35,17,86,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PAKISTAN','','','',374,1),(36,17,88,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',9,1,8,NULL,2,'PUNJAB','','','',374,1),(37,17,89,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',9,1,8,NULL,2,'PUNJAB','','','',374,1),(38,17,90,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(39,17,91,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(40,17,92,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(41,17,93,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(42,17,94,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(43,17,95,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(44,17,96,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(45,17,97,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(46,17,98,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(47,17,99,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(48,17,100,NULL,'2017-01-10','','',0,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(49,17,101,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(50,17,102,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(51,17,103,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(52,17,104,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(53,17,105,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(54,17,106,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(55,17,107,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(56,17,108,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(57,17,109,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(58,17,110,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','','',374,1),(59,17,111,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(60,17,112,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(61,17,113,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(62,17,114,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(63,17,115,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',6,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(64,17,116,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(65,17,117,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(66,17,118,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(67,17,119,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(68,17,120,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','PUNJAB','',374,1),(69,17,122,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',8,1,9,NULL,2,'PUNJAB','','','',374,1),(70,17,124,NULL,'2017-01-10','','',1,NULL,1,3,3745,'2017-01-10',12,1,10,NULL,2,'PUNJAB','','','',374,1),(71,9,141,NULL,'2017-01-19','','',0,NULL,1,3,3745,'2017-01-19',12,1,10,NULL,2,'RAWALPINDI','','','',374,1),(72,9,142,NULL,'2017-01-18','03358412456','',1,NULL,1,3,3745,'2017-01-18',13,1,10,NULL,2,'RAWALPINDI','','','',374,1),(73,9,143,NULL,'2017-01-19','','',0,NULL,1,3,3745,'2017-01-19',12,2,10,NULL,2,'RAWALPINDI','','','',374,1),(74,9,144,NULL,'2017-01-19','','',1,NULL,1,3,3745,'2017-01-19',13,2,10,NULL,2,'RAWALPINDI','','','',374,1);
/*!40000 ALTER TABLE `employee_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_monthly_section`
--

DROP TABLE IF EXISTS `employee_monthly_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_monthly_section` (
  `ems_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `net_salary` bigint(20) NOT NULL,
  `period` date NOT NULL,
  PRIMARY KEY (`ems_id`),
  KEY `FK_employee_monthly_section_employee_info` (`emp_id`),
  CONSTRAINT `FK_employee_monthly_section_employee_info` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_monthly_section`
--

LOCK TABLES `employee_monthly_section` WRITE;
/*!40000 ALTER TABLE `employee_monthly_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_monthly_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_parents_info`
--

DROP TABLE IF EXISTS `employee_parents_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_parents_info` (
  `emp_parent_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `cnic` bigint(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `profession` varchar(20) DEFAULT NULL,
  `contact_no2` varchar(200) DEFAULT NULL,
  `emp_id` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '1',
  `spouse_name` varchar(25) DEFAULT NULL,
  `no_of_children` int(11) DEFAULT NULL,
  PRIMARY KEY (`emp_parent_id`),
  KEY `FK_employee_parents_info_employee_info` (`emp_id`),
  KEY `branch id` (`fk_branch_id`),
  KEY `employee_search_2_26122016` (`first_name`,`middle_name`,`last_name`,`cnic`),
  CONSTRAINT `FK_employee_parents_info_employee_info` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `employee_parents_info_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_parents_info`
--

LOCK TABLES `employee_parents_info` WRITE;
/*!40000 ALTER TABLE `employee_parents_info` DISABLE KEYS */;
INSERT INTO `employee_parents_info` VALUES (1,1,'jhgjh','','hghjgjh',NULL,'','','teacher','',1,1,'',NULL),(2,1,'kjgkljhlk','hkjh','kjhkj',NULL,'asdasd@asdasd.com','7665675','jgjhj','6576886',2,1,'',NULL),(3,1,'test','test','test',NULL,'','343453','3435','3545',3,1,'53453',53453),(4,1,'Tasneem ','Khaliq','Niazi',NULL,'asdasd@asdasd.com','3423423','GS','234123423',4,1,'',NULL),(5,1,'Tasneem ','Khaliq','Niazi',NULL,'asdasd@asdasd.com','3423423','GS','234123423',5,1,'',NULL),(6,1,'Salman','Khan','',NULL,'asdasd@asdasd.com','3423423','GS','234123423',6,1,'Spouse',50),(7,1,'Tas','Kha','',NULL,'asdasd@asdasd.com','3423423','GS','234123423',7,1,'',NULL),(8,1,'test','','',NULL,'email@gmail.com','','','',8,1,'',NULL),(9,1,'test','','',NULL,'','','','',9,1,'',NULL),(10,1,'P123','','',NULL,'','','','',10,1,'',NULL),(11,1,'ffff','','',NULL,'','','','',11,1,'',NULL),(12,1,'bghggkh','','',NULL,'','','','',12,1,'',NULL),(13,1,'XYZ','ABC','BHU',NULL,'xyz@yhn.com','88986757','BH','687574378',13,1,'',NULL),(14,1,'XYZ','ABC','BHU',NULL,'xyz@yhnnn.com','88986757','BH','687574378',14,1,'',NULL),(15,1,'johns','','does',NULL,'johns@gmail.com','0345643','busnissman','',15,1,'',NULL),(16,9,'cvc6fv','','',NULL,'','','','',16,1,'',NULL),(17,9,'XYZ','ABC','BHU',NULL,'xyzi8@yhnnn.com','88986757','BH','687574378',17,1,'',NULL),(18,9,'XYZ','ABC','BHU',NULL,'xyz8@yhnnn.com','88986757','BH','687574378',18,1,'',NULL),(19,9,'wrsfs','','',NULL,'awd@sdf.com','','','',19,1,'',NULL),(20,9,'XYZ','ABC','BHU',NULL,'xyz9@yhnnn.com','88986757','BH','687574378',20,1,'',NULL),(21,9,'tests','','teste',NULL,'','','','',21,1,'',NULL),(22,9,'XYZ','ABC','BHU',NULL,'xyz9@yhddnnn.com','88986757','BH','687574378',22,1,'',NULL),(23,9,'XYZ','ABC','BHU',NULL,'xyz9@ymail.com','88986757','BH','687574378',23,1,'',NULL),(24,9,'XYZ','ABC','BHU',NULL,'xyzabbasi@ymail.com','88986757','BH','687574378',24,1,'',NULL),(25,9,'FATHER','ABC','NAME',NULL,'fathernameis@ymail.com','88986757','BH','687574378',25,1,'',NULL),(26,9,'sdfsfsfsdf','','sdfsf',NULL,'','234234234','','',26,1,'',NULL),(27,9,'','','',NULL,'','','','',27,1,'',NULL),(28,9,'FRED','ABC','BOND',NULL,'fredbond@ymail.com','88986777','BH','68757466',28,1,'',NULL),(29,9,'hgfyfygh','uhi','jklh',NULL,'test@test.com','','','',29,0,'',NULL),(30,17,'','','',NULL,'','','','',30,1,'',NULL),(31,17,'rwerwerwerwer','rwerwer','werwerwer',NULL,'a234234dfasdf@sdfsd.com','53453453','rwerwer','3453453',31,1,'',NULL),(32,17,'','','',NULL,'','','','',32,1,'',NULL),(33,17,'','','',NULL,'','','','',33,1,'',NULL),(34,17,'','','',NULL,'','','','',34,1,'',NULL),(35,17,'','','',NULL,'','','','',35,1,'',NULL),(36,17,'','','',NULL,'','','','',36,1,'',NULL),(37,17,'','','',NULL,'','','','',37,1,'',NULL),(38,17,'','','',NULL,'','','','',38,1,'',NULL),(39,17,'','','',NULL,'','','','',39,1,'',NULL),(40,17,'','','',NULL,'','','','',40,1,'',NULL),(41,17,'','','',NULL,'','','','',41,1,'',NULL),(42,17,'','','',NULL,'','','','',42,1,'',NULL),(43,17,'','','',NULL,'','','','',43,1,'',NULL),(44,17,'','','',NULL,'','','','',44,1,'',NULL),(45,17,'','','',NULL,'','','','',45,1,'',NULL),(46,17,'','','',NULL,'','','','',46,1,'',NULL),(47,17,'','','',NULL,'','','','',47,1,'',NULL),(48,17,'','','',NULL,'','','','',48,1,'',NULL),(49,17,'','','',NULL,'','','','',49,1,'',NULL),(50,17,'','','',NULL,'','','','',50,1,'',NULL),(51,17,'','','',NULL,'','','','',51,1,'',NULL),(52,17,'','','',NULL,'','','','',52,1,'',NULL),(53,17,'','','',NULL,'','','','',53,1,'',NULL),(54,17,'','','',NULL,'','','','',54,1,'',NULL),(55,17,'','','',NULL,'','','','',55,1,'',NULL),(56,17,'','','',NULL,'','','','',56,1,'',NULL),(57,17,'','','',NULL,'','','','',57,1,'',NULL),(58,17,'','','',NULL,'','','','',58,1,'',NULL),(59,17,'','','',NULL,'','','','',59,1,'',NULL),(60,17,'','','',NULL,'','','','',60,1,'',NULL),(61,17,'','','',NULL,'','','','',61,1,'',NULL),(62,17,'','','',NULL,'','','','',62,1,'',NULL),(63,17,'','','',NULL,'','','','',63,1,'',NULL),(64,17,'','','',NULL,'','','','',64,1,'',NULL),(65,17,'','','',NULL,'','','','',65,1,'',NULL),(66,17,'','','',NULL,'','','','',66,1,'',NULL),(67,17,'','','',NULL,'','','','',67,1,'',NULL),(68,17,'','','',NULL,'','','','',68,1,'',NULL),(69,17,'','','',NULL,'','','','',69,1,'',NULL),(70,17,'','','',NULL,'','','','',70,1,'',NULL),(71,9,'','','',NULL,'','','','',71,1,'',NULL),(72,9,'','','',NULL,'','','','',72,1,'',NULL),(73,9,'','','',NULL,'','','','',73,1,'',NULL),(74,9,'','','',NULL,'','','','',74,1,'',NULL);
/*!40000 ALTER TABLE `employee_parents_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `fk_group_id` int(11) DEFAULT NULL,
  `fk_subject_id` int(11) NOT NULL,
  `fk_section_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `total_marks` float NOT NULL,
  `fk_exam_type` int(11) NOT NULL,
  `passing_marks` int(11) DEFAULT NULL,
  `do_not_create` tinyint(4) NOT NULL DEFAULT '0',
  `fk_subject_division_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_id` (`fk_class_id`),
  KEY `fk_subject_id` (`fk_subject_id`),
  KEY `fk_group_id` (`fk_group_id`),
  KEY `fk_section_id` (`fk_section_id`),
  KEY `fk_exam_type_id` (`fk_exam_type`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `fk_subject_division_id` (`fk_subject_division_id`),
  CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`fk_class_id`) REFERENCES `ref_class` (`class_id`),
  CONSTRAINT `exam_ibfk_2` FOREIGN KEY (`fk_subject_id`) REFERENCES `subjects` (`id`),
  CONSTRAINT `exam_ibfk_3` FOREIGN KEY (`fk_group_id`) REFERENCES `ref_group` (`group_id`),
  CONSTRAINT `exam_ibfk_4` FOREIGN KEY (`fk_section_id`) REFERENCES `ref_section` (`section_id`),
  CONSTRAINT `exam_ibfk_5` FOREIGN KEY (`fk_exam_type`) REFERENCES `exam_type` (`id`),
  CONSTRAINT `exam_ibfk_6` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `exam_ibfk_7` FOREIGN KEY (`fk_subject_division_id`) REFERENCES `subject_division` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam`
--

LOCK TABLES `exam` WRITE;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
INSERT INTO `exam` VALUES (4,9,11,7,6,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',25,1,15,0,11),(5,9,11,7,6,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',75,1,40,0,12),(6,9,11,7,7,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',100,1,50,0,NULL),(7,9,11,7,8,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',25,1,15,0,6),(8,9,11,7,8,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',25,1,15,0,7),(9,9,11,7,8,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',50,1,25,0,8),(10,9,11,7,10,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',50,1,25,0,13),(11,9,11,7,10,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',25,1,15,0,14),(12,9,11,7,10,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 12:22:11',25,1,15,0,15),(13,9,16,NULL,9,22,'2016-12-26 00:00:00','2016-12-26 00:00:00','2016-12-23 12:39:59',20,1,30,0,9),(14,9,16,NULL,9,22,'2016-12-26 00:00:00','2016-12-27 00:00:00','2016-12-23 12:39:59',10,1,100,0,10),(15,9,11,7,6,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',25,2,10,0,11),(16,9,11,7,6,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',25,2,10,0,12),(17,9,11,7,7,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',50,2,25,0,NULL),(18,9,11,7,8,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',20,2,10,0,6),(19,9,11,7,8,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',20,2,10,0,7),(20,9,11,7,8,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',20,2,10,0,8),(21,9,11,7,10,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',50,2,25,0,13),(22,9,11,7,10,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',25,2,15,0,14),(23,9,11,7,10,16,'2016-12-23 00:00:00','2016-12-23 00:00:00','2016-12-23 13:58:35',25,2,15,0,15),(64,9,17,NULL,11,24,'2016-12-29 00:00:00','2016-12-29 00:00:00','2016-12-28 10:55:03',80,2,NULL,0,NULL),(65,9,17,NULL,12,24,'2016-12-30 00:00:00','2016-12-30 00:00:00','2016-12-28 10:55:03',80,2,NULL,0,NULL),(66,9,17,NULL,11,24,'2016-12-29 00:00:00','2016-12-29 00:00:00','2016-12-28 10:55:04',80,2,NULL,0,NULL),(67,9,17,NULL,12,24,'2016-12-30 00:00:00','2016-12-30 00:00:00','2016-12-28 10:55:04',80,2,NULL,0,NULL),(68,9,17,NULL,11,26,'2016-12-29 00:00:00','2016-12-29 00:00:00','2016-12-29 11:55:32',50,2,NULL,0,NULL),(69,9,17,NULL,12,26,'2016-12-29 00:00:00','2016-12-29 00:00:00','2016-12-29 11:55:32',50,2,NULL,0,NULL),(70,9,17,NULL,11,24,'2017-01-07 05:15:00','2017-01-07 15:15:00','2017-01-05 05:19:50',90,3,NULL,0,NULL),(71,9,17,NULL,12,24,'2017-01-08 01:05:00','2017-01-01 09:45:00','2017-01-05 05:19:50',90,3,NULL,0,NULL),(72,9,17,NULL,11,25,'2017-01-05 10:24:00','2017-01-05 10:24:00','2017-01-05 10:26:03',101,4,NULL,0,NULL),(73,9,17,NULL,12,25,'2017-01-05 10:24:00','2017-01-05 10:24:00','2017-01-05 10:26:03',102,4,NULL,0,NULL),(74,9,20,11,14,28,'2017-01-10 04:27:00','2017-01-10 04:27:00','2017-01-10 04:27:31',100,19,NULL,0,NULL),(75,9,20,11,15,28,'2017-01-10 04:27:00','2017-01-10 04:27:00','2017-01-10 04:27:31',100,19,NULL,0,NULL),(76,9,20,11,16,28,'2017-01-10 04:27:00','2017-01-10 04:27:00','2017-01-10 04:27:31',100,19,NULL,0,NULL),(77,9,20,11,17,28,'2017-01-10 04:27:00','2017-01-10 04:27:00','2017-01-10 04:27:31',100,19,NULL,0,NULL),(78,9,20,11,18,28,'2017-01-10 04:27:00','2017-01-10 04:27:00','2017-01-10 04:27:31',100,19,NULL,0,NULL),(79,9,20,11,19,28,'2017-01-10 04:27:00','2017-01-10 04:27:00','2017-01-10 04:27:31',100,19,NULL,0,NULL),(80,9,11,7,13,16,'2017-01-14 09:40:00','2017-01-13 09:40:00','2017-01-13 21:42:52',43,43,30,0,18),(81,9,17,NULL,11,25,'2017-01-17 01:46:00','2017-01-17 01:46:00','2017-01-17 13:47:40',100,44,50,0,11),(82,9,17,NULL,12,25,'2017-01-17 01:46:00','2017-01-17 01:46:00','2017-01-17 13:47:40',100,44,33,0,NULL);
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_type`
--

DROP TABLE IF EXISTS `exam_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `fk_branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_type_ibfk_1` (`fk_branch_id`),
  CONSTRAINT `exam_type_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_type`
--

LOCK TABLES `exam_type` WRITE;
/*!40000 ALTER TABLE `exam_type` DISABLE KEYS */;
INSERT INTO `exam_type` VALUES (1,'Annual',9),(2,'Monthly',9),(3,'Annual',9),(4,'Monthly',9),(5,'Monthly Test',9),(6,'PreMed',9),(7,'PreMed',9),(8,'PreMed',9),(9,'PreMed',9),(10,'PreMed',9),(11,'PreMed',9),(12,'PreMed',9),(13,'Pre-board',9),(14,'10',9),(15,'10',9),(16,'10',9),(17,'10',9),(18,'10',9),(19,'Pre-Board',9),(20,'cgh',9),(21,'wer',9),(22,'wer',9),(23,'wer',9),(24,'wer',9),(25,'wer',9),(26,'wer',9),(27,'wer',9),(28,'wer',9),(29,'wer',9),(30,'wer',9),(31,'wer',9),(32,'wer',9),(33,'wer',9),(34,'wer',9),(35,'wer',9),(36,'wer',9),(37,'wer',9),(38,'wer',9),(39,'wer',9),(40,'wer',9),(41,'tttttttt',9),(42,'tttttttt',9),(43,'3',9),(44,'1',9);
/*!40000 ALTER TABLE `exam_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_collection_particular`
--

DROP TABLE IF EXISTS `fee_collection_particular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_collection_particular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_stu_id` int(11) NOT NULL,
  `total_fee_amount` double NOT NULL,
  `fk_fine_id` int(11) DEFAULT NULL,
  `transport_fare` double DEFAULT NULL,
  `fk_fee_discount_id` int(11) DEFAULT NULL,
  `discount_amount` double DEFAULT NULL,
  `fee_payable` double DEFAULT NULL,
  `is_active` enum('yes','no') DEFAULT 'no',
  `due_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stu_id` (`fk_stu_id`),
  KEY `fk_fee_discount_id` (`fk_fee_discount_id`),
  KEY `fk_fine_id` (`fk_fine_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `fee_collection_particular_ibfk_2` FOREIGN KEY (`fk_stu_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `fee_collection_particular_ibfk_3` FOREIGN KEY (`fk_fee_discount_id`) REFERENCES `fee_discounts` (`id`),
  CONSTRAINT `fee_collection_particular_ibfk_4` FOREIGN KEY (`fk_fine_id`) REFERENCES `student_fine_detail` (`id`),
  CONSTRAINT `fee_collection_particular_ibfk_5` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_collection_particular`
--

LOCK TABLES `fee_collection_particular` WRITE;
/*!40000 ALTER TABLE `fee_collection_particular` DISABLE KEYS */;
INSERT INTO `fee_collection_particular` VALUES (1,9,21,14000,NULL,NULL,NULL,NULL,0,'yes','2017-01-18 00:00:00','2017-01-11 16:40:21'),(2,9,22,22000,NULL,NULL,NULL,NULL,22000,'yes','2017-01-19 00:00:00','2017-01-12 09:45:44'),(3,9,23,19000,NULL,NULL,NULL,NULL,19000,'yes','2017-01-19 00:00:00','2017-01-12 09:52:36'),(4,9,24,14000,NULL,NULL,NULL,NULL,14000,'yes','2017-01-19 00:00:00','2017-01-12 13:14:47'),(5,9,26,22000,NULL,100,NULL,884,21216,'yes','2017-01-20 00:00:00','2017-01-13 11:51:40'),(6,9,27,58000,NULL,100,NULL,2324,55776,'yes','2017-01-20 00:00:00','2017-01-13 11:54:57'),(7,9,28,14000,NULL,NULL,NULL,280,13720,'yes','2017-01-20 00:00:00','2017-01-13 12:19:31'),(8,9,29,14000,NULL,100,NULL,423,13677,'yes','2017-01-20 00:00:00','2017-01-13 13:01:45'),(9,9,30,14000,NULL,100,NULL,423,13677,'yes','2017-01-20 00:00:00','2017-01-13 13:10:09'),(10,9,31,14000,NULL,100,NULL,423,13677,'yes','2017-01-20 00:00:00','2017-01-13 13:11:18'),(11,9,32,14000,NULL,100,NULL,423,13677,'yes','2017-01-20 00:00:00','2017-01-13 13:12:38'),(12,9,33,14000,NULL,100,NULL,423,0,'yes','2017-01-20 00:00:00','2017-01-13 13:18:52'),(13,9,34,14000,NULL,100,NULL,282,13818,'yes','2017-01-20 00:00:00','2017-01-13 15:38:59'),(14,9,35,22000,NULL,NULL,NULL,NULL,22000,'yes','2017-01-21 00:00:00','2017-01-14 01:32:16'),(16,9,36,620000,NULL,500,NULL,NULL,620500,'yes','2017-01-27 00:00:00','2017-01-20 11:39:54'),(17,9,37,118000,NULL,NULL,NULL,NULL,118000,'yes','2017-01-27 00:00:00','2017-01-20 11:40:01'),(18,9,39,120000,NULL,NULL,NULL,NULL,120000,'yes','2017-01-27 00:00:00','2017-01-20 11:45:22'),(19,9,40,34000,NULL,NULL,NULL,NULL,34000,'yes','2017-01-27 00:00:00','2017-01-20 11:51:01'),(20,9,42,18000,NULL,NULL,NULL,NULL,18000,'yes','2017-01-27 00:00:00','2017-01-20 11:56:54'),(21,9,44,15333.333333333,NULL,NULL,NULL,NULL,15333.333333333,'yes','2017-01-27 00:00:00','2017-01-20 12:17:48'),(22,9,45,15333.333333333,NULL,NULL,NULL,NULL,15333.333333333,'yes','2017-01-27 00:00:00','2017-01-20 12:21:04'),(23,9,46,86666.666666667,NULL,NULL,NULL,NULL,86666.666666667,'yes','2017-01-27 00:00:00','2017-01-20 12:24:34');
/*!40000 ALTER TABLE `fee_collection_particular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_discount_types`
--

DROP TABLE IF EXISTS `fee_discount_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_discount_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_discount_types`
--

LOCK TABLES `fee_discount_types` WRITE;
/*!40000 ALTER TABLE `fee_discount_types` DISABLE KEYS */;
INSERT INTO `fee_discount_types` VALUES (1,9,'Poor','Poor students','2017-01-10 16:33:36',NULL,0),(2,9,'Talented Students 90%','Students having more than 90% marks','2017-01-10 16:34:25',NULL,0),(3,9,'Talented Students 75%','Students having more than 75% marks','2017-01-10 16:34:52',NULL,0),(4,9,'Reference','With reference to some body','2017-01-10 16:35:36',NULL,0);
/*!40000 ALTER TABLE `fee_discount_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_discounts`
--

DROP TABLE IF EXISTS `fee_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_discounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_stud_id` int(11) NOT NULL,
  `fk_fee_discounts_type_id` int(11) NOT NULL,
  `fk_fee_head_wise_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'no',
  `remarks` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fee_discounts_type_id` (`fk_fee_discounts_type_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `fk_stud_id` (`fk_stud_id`),
  KEY `fk_fee_head_wise_id` (`fk_fee_head_wise_id`),
  CONSTRAINT `fee_discounts_ibfk_1` FOREIGN KEY (`fk_fee_discounts_type_id`) REFERENCES `fee_discount_types` (`id`),
  CONSTRAINT `fee_discounts_ibfk_3` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fee_discounts_ibfk_4` FOREIGN KEY (`fk_stud_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `fee_discounts_ibfk_5` FOREIGN KEY (`fk_fee_head_wise_id`) REFERENCES `fee_head_wise` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_discounts`
--

LOCK TABLES `fee_discounts` WRITE;
/*!40000 ALTER TABLE `fee_discounts` DISABLE KEYS */;
INSERT INTO `fee_discounts` VALUES (1,9,44,1,1,0,'yes',NULL),(2,9,44,1,2,0,'yes',NULL),(3,9,45,1,3,0,'yes',NULL),(4,9,45,1,4,0,'yes',NULL),(5,9,46,1,5,0,'yes',NULL),(6,9,46,1,6,0,'yes',NULL);
/*!40000 ALTER TABLE `fee_discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_group`
--

DROP TABLE IF EXISTS `fee_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `fk_fee_head_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'no',
  `fk_group_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_id` (`fk_class_id`),
  KEY `fk_classification_id` (`fk_fee_head_id`),
  KEY `fk_group_id` (`fk_group_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `fee_group_ibfk_1` FOREIGN KEY (`fk_class_id`) REFERENCES `ref_class` (`class_id`),
  CONSTRAINT `fee_group_ibfk_2` FOREIGN KEY (`fk_fee_head_id`) REFERENCES `fee_heads` (`id`),
  CONSTRAINT `fee_group_ibfk_3` FOREIGN KEY (`fk_group_id`) REFERENCES `ref_group` (`group_id`),
  CONSTRAINT `fee_group_ibfk_4` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fee_group_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_group`
--

LOCK TABLES `fee_group` WRITE;
/*!40000 ALTER TABLE `fee_group` DISABLE KEYS */;
INSERT INTO `fee_group` VALUES (1,9,11,1,'2017-01-11 16:37:36',NULL,16,'yes',7,10000),(2,9,11,2,'2017-01-11 16:37:53',NULL,16,'yes',7,4000),(3,9,16,1,'2017-01-12 09:49:12',NULL,16,'yes',NULL,14000),(4,9,16,2,'2017-01-12 09:49:27',NULL,16,'yes',NULL,5000),(5,9,11,2,'2017-01-18 17:02:23','2017-01-18 17:02:40',16,'yes',10,2000),(7,9,22,1,'2017-01-20 09:47:02',NULL,16,'yes',14,20000),(8,9,22,2,'2017-01-20 09:47:52',NULL,16,'yes',14,50000),(9,9,19,1,'2017-01-20 11:21:54',NULL,16,'yes',8,600);
/*!40000 ALTER TABLE `fee_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_head_wise`
--

DROP TABLE IF EXISTS `fee_head_wise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_head_wise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_fee_head_id` int(11) NOT NULL,
  `fk_fee_plan_type` int(11) NOT NULL,
  `fk_stu_id` int(11) NOT NULL,
  `payment_received` double DEFAULT NULL,
  `is_paid` enum('yes','no') NOT NULL DEFAULT 'no',
  `fk_chalan_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stu_id` (`fk_stu_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `fk_chalan_id` (`fk_chalan_id`),
  KEY `updated_by` (`updated_by`),
  KEY `fk_fee_head_id` (`fk_fee_head_id`),
  KEY `fk_fee_plan_type` (`fk_fee_plan_type`),
  CONSTRAINT `fee_head_wise_ibfk_1` FOREIGN KEY (`fk_stu_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `fee_head_wise_ibfk_3` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fee_head_wise_ibfk_4` FOREIGN KEY (`fk_chalan_id`) REFERENCES `fee_transaction_details` (`id`),
  CONSTRAINT `fee_head_wise_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `fee_head_wise_ibfk_6` FOREIGN KEY (`fk_fee_head_id`) REFERENCES `fee_heads` (`id`),
  CONSTRAINT `fee_head_wise_ibfk_7` FOREIGN KEY (`fk_fee_plan_type`) REFERENCES `fee_plan_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_head_wise`
--

LOCK TABLES `fee_head_wise` WRITE;
/*!40000 ALTER TABLE `fee_head_wise` DISABLE KEYS */;
INSERT INTO `fee_head_wise` VALUES (1,9,1,5,44,NULL,'no',18,'2017-01-20 12:17:48',NULL,16),(2,9,2,5,44,NULL,'no',18,'2017-01-20 12:17:48',NULL,16),(3,9,1,5,45,NULL,'no',19,'2017-01-20 12:21:04',NULL,16),(4,9,2,5,45,NULL,'no',19,'2017-01-20 12:21:04',NULL,16),(5,9,1,5,46,NULL,'no',20,'2017-01-20 12:24:34',NULL,16),(6,9,2,5,46,NULL,'no',20,'2017-01-20 12:24:34',NULL,16);
/*!40000 ALTER TABLE `fee_head_wise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_heads`
--

DROP TABLE IF EXISTS `fee_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_heads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `fk_fee_method_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fee_class_payment_mode` (`fk_fee_method_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `fee_heads_ibfk_1` FOREIGN KEY (`fk_fee_method_id`) REFERENCES `fee_payment_mode` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_heads`
--

LOCK TABLES `fee_heads` WRITE;
/*!40000 ALTER TABLE `fee_heads` DISABLE KEYS */;
INSERT INTO `fee_heads` VALUES (1,9,'Admission','Admission Fee','2017-01-11 16:28:36',NULL,1),(2,9,'Tuition Fee','tuition fee','2017-01-11 16:28:49',NULL,2),(3,9,'Security Fee','awean','2017-01-18 17:00:56','2017-01-18 17:01:18',1),(4,9,'Promotion Fee','Next Class','2017-01-19 09:36:58',NULL,1);
/*!40000 ALTER TABLE `fee_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_payment_log`
--

DROP TABLE IF EXISTS `fee_payment_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_payment_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_fee_head_id` int(11) NOT NULL,
  `fk_fee_plan_type` int(11) NOT NULL,
  `fk_stu_id` int(11) NOT NULL,
  `fk_chalan_id` int(11) NOT NULL,
  `amount_paid` int(40) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fee_classification_id` (`fk_fee_head_id`),
  KEY `fk_stu_id` (`fk_stu_id`),
  KEY `fk_fee_plan_type` (`fk_fee_plan_type`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `fk_chalan_id` (`fk_chalan_id`),
  CONSTRAINT `fee_payment_log_ibfk_1` FOREIGN KEY (`fk_fee_head_id`) REFERENCES `fee_heads` (`id`),
  CONSTRAINT `fee_payment_log_ibfk_2` FOREIGN KEY (`fk_stu_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `fee_payment_log_ibfk_3` FOREIGN KEY (`fk_fee_plan_type`) REFERENCES `fee_plan_type` (`id`),
  CONSTRAINT `fee_payment_log_ibfk_4` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fee_payment_log_ibfk_5` FOREIGN KEY (`fk_chalan_id`) REFERENCES `fee_transaction_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_payment_log`
--

LOCK TABLES `fee_payment_log` WRITE;
/*!40000 ALTER TABLE `fee_payment_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee_payment_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_payment_mode`
--

DROP TABLE IF EXISTS `fee_payment_mode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_payment_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `time_span` enum('1','2','3','4','5','6','7','8','9','10','11','12') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `fee_payment_mode_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_payment_mode`
--

LOCK TABLES `fee_payment_mode` WRITE;
/*!40000 ALTER TABLE `fee_payment_mode` DISABLE KEYS */;
INSERT INTO `fee_payment_mode` VALUES (1,9,'Annually','1'),(2,9,'Monthly','12'),(3,9,'Bi-monthly','6');
/*!40000 ALTER TABLE `fee_payment_mode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_plan_type`
--

DROP TABLE IF EXISTS `fee_plan_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_plan_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `no_of_installments` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `fee_plan_type_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_plan_type`
--

LOCK TABLES `fee_plan_type` WRITE;
/*!40000 ALTER TABLE `fee_plan_type` DISABLE KEYS */;
INSERT INTO `fee_plan_type` VALUES (5,9,'Monthly [A]','Students who pays total fee in 9 installments and pays annual fee at time of admission',9),(6,9,'Bi-Monthly','Students who pay every 2- month',6),(7,9,'Quarterly','3-months interval',4),(8,9,'Plan Yearly','Plan one with 12 month Installments',1),(9,9,'two Installments','amount in two installments',2),(10,9,'Monthly [B]','students who pays total fee in 9 installments and do not pay annual full',9);
/*!40000 ALTER TABLE `fee_plan_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_transaction_details`
--

DROP TABLE IF EXISTS `fee_transaction_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_transaction_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challan_no` varchar(25) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `fk_fee_collection_particular` int(11) NOT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `opening_balance` double DEFAULT NULL,
  `transaction_amount` double DEFAULT NULL,
  `fk_branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stud_id` (`stud_id`),
  KEY `fk_fee_collection_particular` (`fk_fee_collection_particular`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `fee_transaction_details_ibfk_1` FOREIGN KEY (`stud_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `fee_transaction_details_ibfk_2` FOREIGN KEY (`fk_fee_collection_particular`) REFERENCES `fee_collection_particular` (`id`),
  CONSTRAINT `fee_transaction_details_ibfk_3` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_transaction_details`
--

LOCK TABLES `fee_transaction_details` WRITE;
/*!40000 ALTER TABLE `fee_transaction_details` DISABLE KEYS */;
INSERT INTO `fee_transaction_details` VALUES (1,'test-branch-ch-1',21,1,'2017-01-18 00:00:00',0,14000,9),(2,'test-branch-ch-2',22,2,'2017-01-19 00:00:00',22000,NULL,9),(3,'test-branch-ch-3',23,3,'2017-01-12 00:00:00',19000,20000,9),(4,'test-branch-ch-4',27,6,NULL,55776,NULL,9),(5,'test-branch-ch-5',28,7,NULL,13720,NULL,9),(6,'test-branch-ch-6',29,8,NULL,13677,NULL,9),(7,'test-branch-ch-7',30,9,NULL,13677,NULL,9),(8,'test-branch-ch-8',31,10,NULL,13677,NULL,9),(9,'test-branch-ch-9',32,11,NULL,13677,NULL,9),(10,'test-branch-ch-10',33,12,'2017-01-26 00:00:00',0,13677,9),(11,'test-branch-ch-11',34,13,NULL,13818,NULL,9),(12,'test-branch-ch-12',35,14,NULL,22000,NULL,9),(13,'test-branch-ch-13',36,16,NULL,620500,NULL,9),(14,'test-branch-ch-14',37,17,NULL,118000,NULL,9),(15,'test-branch-ch-15',39,18,NULL,120000,NULL,9),(16,'test-branch-ch-16',40,19,NULL,34000,NULL,9),(17,'test-branch-ch-17',42,20,NULL,18000,NULL,9),(18,'test-branch-ch-18',44,21,NULL,15333.333333333,NULL,9),(19,'test-branch-ch-19',45,22,NULL,15333.333333333,NULL,9),(20,'test-branch-ch-20',46,23,NULL,86666.666666667,NULL,9);
/*!40000 ALTER TABLE `fee_transaction_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fine_type`
--

DROP TABLE IF EXISTS `fine_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fine_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `fk_branch_id` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `updated_by` (`updated_by`),
  KEY `updated_by_2` (`updated_by`),
  CONSTRAINT `fine_type_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fine_type_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fine_type`
--

LOCK TABLES `fine_type` WRITE;
/*!40000 ALTER TABLE `fine_type` DISABLE KEYS */;
INSERT INTO `fine_type` VALUES (2,'Late Fee',9,'This will be charged on late fee','2017-01-10',NULL,16,'active'),(3,'Absent Fine',9,'Absentee Charges','2017-01-10',NULL,16,'active'),(4,'Disciplinary Action',9,'If any body violates discipline','2017-01-10',NULL,16,'active');
/*!40000 ALTER TABLE `fine_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel`
--

DROP TABLE IF EXISTS `hostel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `fk_warden_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_warden_id` (`fk_warden_id`),
  CONSTRAINT `hostel_ibfk_1` FOREIGN KEY (`fk_warden_id`) REFERENCES `employee_info` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel`
--

LOCK TABLES `hostel` WRITE;
/*!40000 ALTER TABLE `hostel` DISABLE KEYS */;
INSERT INTO `hostel` VALUES (1,'ghaznavi','test','21345',3),(3,'Ghauri','Phase 1','989898989',12),(4,'Main Building Hostel','Panj Pir Lar','0938280275',NULL),(5,'test mj','dfss','555',NULL),(6,'asdf','afsssda','fasdf',66),(7,'sdfadszx','aewsfzdasefdxz','234323423',28),(9,'Tarlai','Chak Shahzad','09909090',66);
/*!40000 ALTER TABLE `hostel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel_bed`
--

DROP TABLE IF EXISTS `hostel_bed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel_bed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `fk_room_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hostel_bed_ibfk_1` (`fk_room_id`),
  CONSTRAINT `hostel_bed_ibfk_1` FOREIGN KEY (`fk_room_id`) REFERENCES `hostel_room` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel_bed`
--

LOCK TABLES `hostel_bed` WRITE;
/*!40000 ALTER TABLE `hostel_bed` DISABLE KEYS */;
INSERT INTO `hostel_bed` VALUES (1,'b1',4),(2,'B1',1),(3,'b2',4),(4,'b3',4),(5,'bed3',1),(6,'bed3',7);
/*!40000 ALTER TABLE `hostel_bed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel_detail`
--

DROP TABLE IF EXISTS `hostel_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_hostel_id` int(11) NOT NULL,
  `fk_floor_id` int(11) DEFAULT NULL,
  `fk_room_id` int(11) DEFAULT NULL,
  `fk_bed_id` int(11) DEFAULT NULL,
  `is_booked` enum('1','0') DEFAULT '1',
  `fk_student_id` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_hostel_id` (`fk_hostel_id`),
  KEY `fk_floor_id` (`fk_floor_id`),
  KEY `fk_room_id` (`fk_room_id`),
  KEY `fk_bed_id` (`fk_bed_id`),
  KEY `fk_student_id` (`fk_student_id`),
  CONSTRAINT `hostel_detail_ibfk_1` FOREIGN KEY (`fk_hostel_id`) REFERENCES `hostel` (`id`),
  CONSTRAINT `hostel_detail_ibfk_2` FOREIGN KEY (`fk_floor_id`) REFERENCES `hostel_floor` (`id`),
  CONSTRAINT `hostel_detail_ibfk_3` FOREIGN KEY (`fk_room_id`) REFERENCES `hostel_room` (`id`),
  CONSTRAINT `hostel_detail_ibfk_4` FOREIGN KEY (`fk_bed_id`) REFERENCES `hostel_bed` (`id`),
  CONSTRAINT `hostel_detail_ibfk_5` FOREIGN KEY (`fk_student_id`) REFERENCES `student_info` (`stu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel_detail`
--

LOCK TABLES `hostel_detail` WRITE;
/*!40000 ALTER TABLE `hostel_detail` DISABLE KEYS */;
INSERT INTO `hostel_detail` VALUES (4,3,3,4,4,'1',26,'2017-01-18 00:00:00'),(9,3,3,4,1,'1',17,'2017-01-18 00:00:00'),(10,3,3,4,3,'1',NULL,'2017-01-18 00:00:00');
/*!40000 ALTER TABLE `hostel_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel_floor`
--

DROP TABLE IF EXISTS `hostel_floor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel_floor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `fk_hostel_info_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_hotel_info_id` (`fk_hostel_info_id`),
  CONSTRAINT `hostel_floor_ibfk_1` FOREIGN KEY (`fk_hostel_info_id`) REFERENCES `hostel` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel_floor`
--

LOCK TABLES `hostel_floor` WRITE;
/*!40000 ALTER TABLE `hostel_floor` DISABLE KEYS */;
INSERT INTO `hostel_floor` VALUES (1,'First Floor',1),(2,'second floor',1),(3,'First',3),(4,'3rd Floor',1),(5,'1st',4),(6,'test',5),(7,'top',6),(8,'floor topl',7),(9,'basement',9);
/*!40000 ALTER TABLE `hostel_floor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hostel_room`
--

DROP TABLE IF EXISTS `hostel_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hostel_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `fk_FLOOR_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_FLOOR_id` (`fk_FLOOR_id`),
  CONSTRAINT `hostel_room_ibfk_1` FOREIGN KEY (`fk_FLOOR_id`) REFERENCES `hostel_floor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hostel_room`
--

LOCK TABLES `hostel_room` WRITE;
/*!40000 ALTER TABLE `hostel_room` DISABLE KEYS */;
INSERT INTO `hostel_room` VALUES (1,'room1',1),(2,'room2',1),(3,'test',2),(4,'123',3),(5,'1211',4),(6,'sds',6),(7,'pet',7),(8,'ccc',7),(9,'1',9);
/*!40000 ALTER TABLE `hostel_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_type`
--

DROP TABLE IF EXISTS `leave_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_type`
--

LOCK TABLES `leave_type` WRITE;
/*!40000 ALTER TABLE `leave_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `leave_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main_salary_section`
--

DROP TABLE IF EXISTS `main_salary_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `main_salary_section` (
  `mss_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(7) DEFAULT NULL,
  `emp_id` int(11) NOT NULL,
  `ss_id` int(11) NOT NULL,
  PRIMARY KEY (`mss_id`),
  KEY `FK_main_salary_section_defult_salary_section` (`ss_id`),
  KEY `FK_main_salary_section_employee_info` (`emp_id`),
  CONSTRAINT `FK_main_salary_section_defult_salary_section` FOREIGN KEY (`ss_id`) REFERENCES `defult_salary_section` (`ss_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_main_salary_section_employee_info` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_salary_section`
--

LOCK TABLES `main_salary_section` WRITE;
/*!40000 ALTER TABLE `main_salary_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `main_salary_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profession`
--

DROP TABLE IF EXISTS `profession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profession`
--

LOCK TABLES `profession` WRITE;
/*!40000 ALTER TABLE `profession` DISABLE KEYS */;
INSERT INTO `profession` VALUES (1,'SALARY INCOME'),(2,'Legislative Officials'),(3,'Local Body Elected Persons'),(4,'Law & Justice'),(5,'Executives'),(6,'Defense'),(7,'Law Enforcement &Security Services'),(8,'Government Management/Administration'),(9,'General Office Assistants and Clerical Staff'),(10,'Stenographers, Typists and Data Entry Operator'),(11,'Aircraft and Ships related Staff/Crew'),(12,'Professional Technical Staff'),(13,'Insurance, Real Estate, Securities and Business Service'),(14,'Building, Caretakers and Cleaners related workers'),(15,'Metal Processors'),(16,'Bricklayers, Carpenters and other construction workers'),(17,'Spinners, Weavers, Knitters, Dyers related workers'),(18,'Service workers'),(19,'Broadcasting Station and Sound Equipment Operators'),(20,'Managers (Including Directors, working Proprietors)'),(21,'Engineering Professionals'),(22,'Life Science &Health Professionals'),(23,'Technicians (Health)'),(24,'Skilled Labour (Plumber, Welder, Goldsmith)'),(25,'Skilled Labour (Shoe and Leather Goods  makers )'),(26,'Skilled Labour(Electrical & Electronics workers)'),(27,'Skilled Labour (Tailors, Dress-makers)'),(28,'Skilled Labour(Carpenter)'),(29,'Skilled Labour (Blacksmith, Toolmakers/ Operators)'),(30,'Skilled Labour (Rubber and Plastics Products Makers)'),(31,'Skilled Labour (Press & Printing related workers)'),(32,'Skilled Labour (Painters)'),(33,'Skilled Labour (Production related workers)'),(34,'Skilled Labour (Glass Formers, Potters )'),(35,'Authors, Journalists'),(36,'Teaching'),(37,'Information Technology'),(38,'Finance/Accounts'),(39,'Economists, Statisticians/Mathematicians'),(40,'Arts/Entertainment & Media'),(41,'Skilled Agriculture Worker'),(42,'Skilled Forestry Worker'),(43,'Skilled Fishery worker'),(44,'Craft Trade Worker'),(45,'Marketing & Sale'),(46,'Restaurant & Hotel Worker'),(47,'Plant & Machine Operator'),(48,'Plant & Machine Assemblers'),(49,'Transport, & communication'),(50,'Community, Social & Personal Worker'),(51,'Industrial Workers (Miner, well driller)'),(52,'Food, Beverages & Tobacco worker'),(53,'Cleric (Religious Profession)'),(54,'Athletes And Sports related worker'),(55,'Student'),(56,'House Lady'),(57,'Retired'),(58,'Unemployed');
/*!40000 ALTER TABLE `profession` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_cities`
--

DROP TABLE IF EXISTS `ref_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `district_id` int(11) NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `FK_ref_cities_ref_District` (`district_id`),
  CONSTRAINT `FK_ref_cities_ref_District` FOREIGN KEY (`district_id`) REFERENCES `ref_district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_cities`
--

LOCK TABLES `ref_cities` WRITE;
/*!40000 ALTER TABLE `ref_cities` DISABLE KEYS */;
INSERT INTO `ref_cities` VALUES (1111,'BANNU',111),(1121,'LAKKI MARWAT',112),(1211,'D.I.KHAN',121),(1212,'KULACHI',121),(1213,'PAHARPUR',121),(1214,'DRABAN',121),(1221,'TANK',122),(1311,'ABBOTTABAD',131),(1321,'ALLAI',132),(1322,'BATAGRAM',132),(1331,'GHAZI',133),(1332,'HARIPUR',133),(1341,'DASSU',134),(1342,'PALAS',134),(1343,'PATTAN (KOHISTAN)',134),(1351,'BALA KOT',135),(1352,'F.R KALA DHAKA',135),(1353,'MANSEHRA',135),(1354,'OGHI',135),(1411,'HANGU',141),(1421,'BANDA DAUD SHAH',142),(1422,'KARAK',142),(1423,'TAKHAT NASRATI',142),(1431,'KOHAT',143),(1432,'LACHI',143),(1500,'DIR(DIR)',150),(1511,'DAGGAR',151),(1521,'CHITRAL',152),(1522,'MASTUJ',152),(1531,'JANDOOL',153),(1532,'TEMERGARA',153),(1533,'SAMARBAGH',153),(1534,'MUNDA',153),(1535,'LALQILA',153),(1536,'BALAMBAT',153),(1537,'ADENZAI',153),(1541,'SAM RANI ZAI',154),(1542,'SWAT RANI ZAI',154),(1551,'ALPURI',155),(1552,'BISHAM',155),(1553,'CHAKISAR',155),(1554,'MARTOONG',155),(1555,'PURAN',155),(1561,'MATTA',156),(1562,'SWAT',156),(1571,'DIR(UPPER DIR)',157),(1572,'WARI',157),(1573,'KAL KOAT (KOHISTAN)',157),(1574,'BARAWAL',157),(1575,'KHALL',157),(1611,'MARDAN',161),(1612,'TAKHT BHAI',161),(1621,'CHOTA LAHORE',162),(1622,'SWABI',162),(1711,'CHARSADDA',171),(1712,'TANGI',171),(1721,'NOWSHERA(NOWSHERA)',172),(1731,'PESHAWAR',173),(2111,'BAR CHAMER KAND',211),(2112,'BARANG',211),(2113,'KHAR BAJAUR',211),(2114,'MAMUND',211),(2115,'NAWAGAI',211),(2116,'SALARZAI',211),(2117,'UTMAN KHEL',211),(2121,'BARA',212),(2122,'JAMRUD',212),(2123,'LANDI KOTAL',212),(2124,'MULAGORI',212),(2131,'CENTRAL KURRAM',213),(2132,'LOWER KURRAM',213),(2133,'UPPER KURRAM',213),(2141,'AMBAR UTMAN KHEL',214),(2142,'HALIM ZAI',214),(2143,'PINDIALI',214),(2144,'PRANG GHAR',214),(2145,'SAFI',214),(2146,'UPPER MOHMAND',214),(2147,'YAKE GHUND',214),(2151,'DATTA KHEL',215),(2152,'DOSSALI',215),(2153,'GARYUM',215),(2154,'GHULAM KHAN',215),(2155,'MIR ALI',215),(2156,'MIRAN SHAH',215),(2157,'RAZMAK',215),(2158,'SHAWAL',215),(2159,'SPEEN WAM',215),(2161,'CENTRAL',216),(2162,'ISMAIL ZAI',216),(2163,'LOWER',216),(2164,'UPPER',216),(2171,'BIRMIL',217),(2172,'LADHA',217),(2173,'MAKIN',217),(2174,'SARAROGHA',217),(2175,'SERWEKAI',217),(2176,'TIARZA',217),(2177,'TOI KHULLA',217),(2178,'WANA',217),(2211,'T.A.ADJ.LAKKI MARWAT',221),(2221,'T A ADJ BANNU',222),(2231,'DRAZINDA',223),(2241,'T A ADJ KOHAT',224),(2251,'T A ADJ PESHAWAR',225),(2261,'JANDOLA',226),(3111,'BAHAWALNAGAR',311),(3112,'CHISHTIAN',311),(3113,'FORTABBAS',311),(3114,'HAROONABAD',311),(3115,'MINCHINABAD',311),(3121,'AHMADPUR EAST',312),(3122,'BAHAWALPUR',312),(3123,'HASILPUR',312),(3124,'KHAIRPUR TAMEWALI',312),(3125,'YAZMAN',312),(3131,'KHANPUR(RAHIM YAR KHAN)',313),(3132,'LIAQUAT PUR',313),(3133,'RAHIM YAR KHAN',313),(3134,'SADIQABAD',313),(3211,'DE-EXCLUDED AREA D.G KHAN',321),(3212,'DERA GHAZI KHAN',321),(3213,'TAUNSA',321),(3221,'CHOUBARA',322),(3222,'KAROR LAL ESAN',322),(3223,'LEIAH',322),(3231,'ALIPUR',323),(3232,'JATOI',323),(3233,'KOT ADDU',323),(3234,'MUZAFFARGARH',323),(3241,'DE-EXCLUDED AREA RAJANPUR',324),(3242,'JAMPUR',324),(3243,'RAJANPUR',324),(3244,'ROJHAN',324),(3310,'FAISALABAD',331),(3311,'CHAK JHUMRA',331),(3312,'FAISALABAD CITY',331),(3313,'FAISALABAD SADAR',331),(3314,'JARANWALA',331),(3315,'SUMMUNDRI',331),(3316,'TANDLIAN WALA',331),(3321,'CHINIOT',332),(3322,'JHANG',332),(3323,'SHORKOT',332),(3324,'AHMADPUR SIAL',332),(3331,'GOJRA',333),(3332,'KAMALIA',333),(3333,'TOBA TEK SINGH',333),(3411,'GUJRANWALA',341),(3412,'KAMOKE',341),(3413,'NOWSHERA VIRKAN',341),(3414,'WAZIRABAD',341),(3421,'GUJRAT',342),(3422,'KHARIAN',342),(3423,'SARAI ALAMGIR',342),(3431,'HAFIZABAD',343),(3432,'PINDI BHATTIAN',343),(3441,'MALAKWAL',344),(3442,'MANDI BAHAUDDIN',344),(3443,'PHALIA',344),(3451,'NAROWAL',345),(3452,'SHAKARGARH',345),(3461,'DASKA',346),(3462,'PASRUR',346),(3463,'SIALKOT',346),(3464,'SAMBRIAL',346),(3511,'CHUNIAN',351),(3512,'KASUR',351),(3513,'PATTOKI',351),(3514,'KOT RADHA KISHEN',351),(3520,'LAHORE',352),(3521,'LAHORE CANTT',352),(3522,'LAHORE CITY',352),(3531,'DEPALPUR',353),(3532,'OKARA',353),(3533,'RENALA KHURD',353),(3541,'FEROZEWALA',354),(3542,'SHARAK PUR',354),(3544,'SHEIKHUPURA',354),(3545,'MURIDKE',354),(3551,'NANKANA SAHIB',355),(3552,'SHAH KOT',355),(3553,'SANGLA HILL',355),(3554,'SAFDARABAD',355),(3611,'JAHANIAN',361),(3612,'KABIRWALA',361),(3613,'KHANEWAL',361),(3614,'MIAN CHANNU',361),(3621,'DUNYAPUR',362),(3622,'KAHROR PACCA',362),(3623,'LODHRAN',362),(3631,'JALALPUR PIRWALA',363),(3632,'MULTAN CITY',363),(3633,'MULTAN SADDAR',363),(3634,'SHUJABAD',363),(3641,'ARIF WALA',364),(3642,'PAKPATTAN',364),(3651,'CHICHAWATNI',365),(3652,'SAHIWAL (SAHIWAL)',365),(3661,'BUREWALA',366),(3662,'MAILSI',366),(3663,'VEHARI',366),(3711,'ATTOCK',371),(3712,'FATEH JANG',371),(3713,'HASAN ABDAL',371),(3714,'JAND',371),(3715,'PINDI GHEB',371),(3716,'HAZRO',371),(3721,'CHAKWAL',372),(3722,'CHOA SAIDAN SHAH',372),(3723,'TALA GANG',372),(3724,'KALLAR KAHAR',372),(3731,'JHELUM',373),(3732,'PIND DADAN KHAN',373),(3733,'SOHAWA',373),(3741,'GUJAR KHAN',374),(3742,'KAHUTA',374),(3743,'KOTLI SATTIAN',374),(3744,'MURREE',374),(3745,'RAWALPINDI',374),(3746,'TAXILA',374),(3747,'KALLAR SAYADDAN',374),(3811,'BHAKKAR',381),(3812,'DARYA KHAN',381),(3813,'KALUR KOT',381),(3814,'MANKERA',381),(3821,'KHUSHAB',382),(3822,'NOORPUR',382),(3831,'ISAKHEL',383),(3832,'MIANWALI',383),(3833,'PIPLAN',383),(3841,'BHALWAL',384),(3842,'SAHIWAL (SARGODHA)',384),(3843,'SARGODHA',384),(3844,'SHAHPUR',384),(3845,'SILLANWALI',384),(3846,'KOT MOMIN',384),(4111,'BADIN',411),(4112,'GOLARCHI',411),(4113,'MATLI',411),(4114,'TANDO BAGO',411),(4115,'TALHAR',411),(4121,'DADU',412),(4122,'JOHI',412),(4123,'KHAIRPUR NATHAN SHAH',412),(4125,'MEHAR',412),(4131,'HALA',413),(4132,'HYDERABAD CITY',413),(4133,'HYDERABAD',413),(4134,'LATIFABAD',413),(4135,'MATIARI',413),(4136,'QASIMABAD',413),(4137,'TANDO ALLAHYAR',413),(4138,'TANDO MUHAMMAD KHAN',413),(4139,'TANDO JAM',413),(4141,'GHORABARI',414),(4142,'JATI',414),(4143,'KETI BUNDER',414),(4144,'KHARO CHAN',414),(4145,'MIRPUR BATHORO',414),(4146,'MIRPUR SAKRO',414),(4147,'SHAH BUNDER',414),(4148,'SUJAWAL',414),(4149,'THATTA',414),(4154,'KOTRI',415),(4156,'SEHWAN SHARIF',415),(4157,'THANO BULA KHAN',415),(4200,'KARACHI',420),(4211,'KARACHI CENTRAL',421),(4221,'KARACHI EAST',422),(4231,'KARACHI SOUTH',423),(4241,'KARACHI WEST',424),(4251,'MALIR',425),(4311,'GARHI KHAIRO',431),(4312,'JACOBABAD',431),(4315,'THUL',431),(4321,'DOKRI',432),(4323,'LARKANA',432),(4325,'RATO DERO',432),(4326,'BAQRANI',432),(4331,'GARHI YASIN',433),(4332,'KHANPUR(SHIKARPUR)',433),(4333,'LAKHI',433),(4334,'SHIKARPUR',433),(4341,'SIJAWAL JUNEJO',434),(4342,'KAMBAR ALI KHAN',434),(4343,'NASIR ABAD',434),(4344,'MEERO KHAN',434),(4345,'QUBO SAEED KHAN',434),(4346,'SHAHDAD KOT',434),(4347,'WARAH',434),(4352,'TANGWANI',435),(4353,'KANDH KOT',435),(4354,'KASHMORE',435),(4411,'DIGRI',441),(4412,'KOT GHULAM MUHAMMAD',441),(4413,'MIRPUR KHAS',441),(4414,'KUNRI',441),(4415,'PITHORO',441),(4416,'SAMARO',441),(4417,'UMER KOT',441),(4421,'JAM NAWAZ ALI',442),(4422,'KHIPRO',442),(4423,'SANGHAR',442),(4424,'SHAHDADPUR',442),(4425,'SINJHORO',442),(4426,'TANDO ADAM',442),(4431,'CHACHRO',443),(4432,'DIPLO',443),(4433,'MITHI',443),(4434,'NAGAR PARKAR',443),(4511,'DAHARKI',451),(4512,'GHOTKI',451),(4513,'KHANGARH',451),(4514,'MIRPUR MATHELO',451),(4515,'UBAURO',451),(4521,'FAIZ GANJ',452),(4522,'GAMBAT',452),(4523,'KHAIRPUR',452),(4524,'KINGRI',452),(4525,'KOT DIJI',452),(4526,'THARI MEER WAH',452),(4527,'NARA',452),(4528,'SOBHO DERO',452),(4531,'BHIRIA',453),(4532,'KANDIARO',453),(4533,'MORO',453),(4534,'NAUSHAHRO FEROZE',453),(4535,'MEHRAB PUR',453),(4541,'DAULAT PUR',454),(4542,'NAWABSHAH',454),(4543,'SAKRAND',454),(4551,'PANO AQIL',455),(4552,'ROHRI',455),(4553,'SALEHPAT',455),(4554,'SUKKUR',455),(4555,'NEW SUKKUR',455),(5111,'AWARAN',511),(5112,'MASHKAI',511),(5113,'JHAL JHAO',511),(5121,'KALAT',512),(5122,'SURAB',512),(5123,'MANGOCHAR',512),(5131,'KHARAN',513),(5141,'KHUZDAR',514),(5142,'NAAL',514),(5143,'WADH',514),(5144,'ZEHRI',514),(5151,'BELA',515),(5152,'DUREJI',515),(5153,'HUB',515),(5154,'KANRAJ',515),(5155,'OTHAL',515),(5156,'LAKHARA',515),(5157,'SON MAINI',515),(5158,'GADDANI',515),(5161,'DASHT(MASTUNG)',516),(5162,'MASTUNG',516),(5171,'WASHUK',517),(5172,'MASHKHEL',517),(5173,'RAKHSHAN (BESIMA)',517),(5211,'GWADAR',521),(5212,'PASNI',521),(5213,'JIWANI',521),(5214,'ORMARA',521),(5221,'BULEDA',522),(5222,'DASHT(KECH)',522),(5223,'TURBAT',522),(5224,'TUMP',522),(5225,'MAND',522),(5231,'PANJGUR',523),(5232,'GAWARGO',523),(5233,'JAHEEN PROOM',523),(5311,'BHAG',531),(5312,'DHADAR',531),(5313,'MACH',531),(5314,'SANNI',531),(5321,'JHAT PAT',532),(5322,'USTA MOHAMMAD',532),(5323,'SOHBATPUR',532),(5324,'GANDAKHA',532),(5331,'GANDAWA',533),(5332,'JHAL MAGSI',533),(5341,'CHHATTAR',534),(5342,'DERA MURAD JAMALI',534),(5345,'TAMBOO',534),(5411,'DALBANDIN',541),(5413,'TAFTAN',541),(5414,'NOKKUNDI',541),(5421,'CHAMAN',542),(5422,'GULISTAN',542),(5423,'KILLA ABDULLAH',542),(5431,'BARSHORE',543),(5432,'KAREZAT',543),(5433,'PISHIN',543),(5440,'QUETTA',544),(5441,'QUETTA CITY',544),(5442,'QUETTA SADDAR',544),(5443,'DASHT(QUETTA)',544),(5451,'NUSHKI',545),(5511,'DERA BUGTI',551),(5512,'PHELAWAGH',551),(5513,'SUI',551),(5521,'KAHAN',552),(5522,'KOHLU',552),(5523,'MAWAND',552),(5531,'HARNAI',553),(5532,'SIBI',553),(5533,'LEHRI',553),(5541,'ZIARAT',554),(5542,'SINJAWI',554),(5611,'BARKHAN',561),(5621,'KILLA SAIFULLAH',562),(5622,'UPPER ZHOB',562),(5631,'DUKI',563),(5632,'LORALAI',563),(5641,'MUSAKHEL',564),(5651,'KAKAR KHURASAN',565),(5653,'ZHOB',565),(5661,'SHERANI',566),(6111,'ISLAMABAD',611),(7111,'KHARMANG',711),(7112,'SHIGAR',711),(7113,'SKARDU',711),(7114,'RONDU',711),(7121,'ASTORE',712),(7122,'CHILAS',712),(7123,'DAREL/TANGIR',712),(7131,'KHAPLU',713),(7132,'MASHABBRUM',713),(7141,'GUPIS',714),(7142,'PUNIAL',714),(7143,'YASIN',714),(7144,'ISHKOMAN',714),(7151,'GILGIT',715),(7152,'HUNZA',715),(7153,'NAGAR',715),(7154,'ALI ABAD',715),(7155,'GOJAL',715),(8111,'BARNALA',811),(8112,'BHIMBER',811),(8113,'SAMAHNI',811),(8121,'FATEHPUR THAKIALA',812),(8122,'KOTLI',812),(8123,'SEHNSA',812),(8131,'DUDYAL',813),(8132,'MIRPUR AJK',813),(8211,'BAGH',821),(8212,'DHIR KOT',821),(8213,'HAVELI(BAGH)',821),(8222,'HATTIAN',822),(8223,'MUZAFFARABAD',822),(8231,'ABBASPUR',823),(8232,'HAJIRA',823),(8233,'RAWALAKOT',823),(8241,'PALLANDARI',824),(8251,'ATHMUQAM',825),(8252,'SHARDA',825),(8311,'DODA',831),(8312,'BHADERWAH',831),(8313,'KISHTWAR',831),(8314,'RAMBAN',831),(8315,'BANIHAL',831),(8316,'THATHRI',831),(8317,'GANDOH',831),(8321,'JAMMU',832),(8322,'SAMBA',832),(8323,'RANBIR SINGH PUR',832),(8324,'AKHNOOR',832),(8325,'BISHNAH',832),(8331,'KATHUA',833),(8332,'HIRANAGAR',833),(8333,'BASHOLI',833),(8334,'BILLAWAR',833),(8341,'HAVELI(POONCH)',834),(8342,'MENDHAR',834),(8343,'SURANKOTE',834),(8351,'RAJOURI',835),(8352,'BUDHAL',835),(8353,'KALAKOTE',835),(8354,'THANAMANDI',835),(8355,'NOWSHERA(RAJOURI)',835),(8356,'SANDAR BANI',835),(8357,'KOTERANKA',835),(8361,'UDHAMPUR',836),(8362,'RAMNAGAR',836),(8363,'REASI',836),(8364,'CHENANI',836),(8365,'GOOL GULABGARH',836),(8411,'KARGIL',841),(8412,'ZANSKAR',841),(8421,'LEH',842),(8422,'NUBRA',842),(8423,'DURUBK',842),(8424,'KHALF',842),(8425,'KHARU',842),(8426,'NYOMA',842),(8511,'BARAMULLA',851),(8512,'PATTAN (BARAMULLA)',851),(8513,'SOPORE',851),(8514,'SONAWARI',851),(8515,'URI',851),(8516,'BANDIPORA',851),(8517,'TANGHMARG',851),(8518,'GUREZ¬†',851),(8521,'BUDGAM',852),(8522,'CHADOORA',852),(8523,'BEERWAH',852),(8531,'ANANTHNAG',853),(8532,'BIJBEHARA',853),(8533,'DORU',853),(8534,'KULGAM',853),(8535,'PAHALGAM',853),(8541,'PULWAMA',854),(8542,'SHOPIAN',854),(8543,'PAMPORE',854),(8544,'TRAL',854),(8551,'KUPWARA',855),(8552,'HANDWARA',855),(8553,'KARNAH',855),(8561,'SRINAGAR',856),(8562,'GANDERBAL',856),(8563,'KANGAN',856),(8564,'THARUSHA',453),(8565,'JAUHARABAD',382),(8566,'LASBELLA',544),(8567,'WAH CANTT',374),(8568,'QAZI AHMED',454),(8569,'PARACHINAR',121),(8570,'JAMSHORO',415),(8580,'TESTUSER',415),(8582,'TESTUSER2',415),(8583,'Noshki',541),(8584,'Jhat Phat',534),(8585,'MALAKAND',154);
/*!40000 ALTER TABLE `ref_cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_cityarea`
--

DROP TABLE IF EXISTS `ref_cityarea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_cityarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(20) NOT NULL,
  `fk_city_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_city_id` (`fk_city_id`),
  CONSTRAINT `ref_cityarea_ibfk_1` FOREIGN KEY (`fk_city_id`) REFERENCES `ref_cities` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_cityarea`
--

LOCK TABLES `ref_cityarea` WRITE;
/*!40000 ALTER TABLE `ref_cityarea` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_cityarea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_class`
--

DROP TABLE IF EXISTS `ref_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `fk_session_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`),
  KEY `branch id` (`fk_branch_id`),
  KEY `fk_session_id` (`fk_session_id`),
  CONSTRAINT `ref_class_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ref_class_ibfk_2` FOREIGN KEY (`fk_session_id`) REFERENCES `ref_session` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_class`
--

LOCK TABLES `ref_class` WRITE;
/*!40000 ALTER TABLE `ref_class` DISABLE KEYS */;
INSERT INTO `ref_class` VALUES (1,1,'9th',4),(2,1,'10th',4),(3,1,'8th',4),(5,1,'7th',4),(7,1,'6th',4),(9,1,'9th',12),(10,1,'9th',12),(11,9,'9th',12),(13,1,'10th',12),(14,1,'10th',12),(15,1,'10th',12),(16,9,'10th',12),(17,9,'8th',12),(19,9,'5th',12),(20,9,'1st year',12),(21,9,'2nd year',16),(22,9,'test class',16);
/*!40000 ALTER TABLE `ref_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_countries`
--

DROP TABLE IF EXISTS `ref_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_id` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_countries`
--

LOCK TABLES `ref_countries` WRITE;
/*!40000 ALTER TABLE `ref_countries` DISABLE KEYS */;
INSERT INTO `ref_countries` VALUES (1,'PAKISTAN'),(2,'Afghanistan'),(3,'Albania'),(4,'Algeria'),(5,'American Samoa'),(6,'Andorra'),(7,'Angola'),(8,'Anguilla'),(9,'Antarctica'),(10,'Antigua and Barbuda'),(11,'Argentina'),(12,'Armenia'),(13,'Aruba'),(14,'Australia'),(15,'Austria'),(16,'Azerbaijan'),(17,'Bahamas'),(18,'Bahrain'),(19,'Bangladesh'),(20,'Barbados'),(21,'Belarus'),(22,'Belgium'),(23,'Belize'),(24,'Benin'),(25,'Bermuda'),(26,'Bhutan'),(27,'Bolivia'),(28,'Bosnia and Herzegovina'),(29,'Botswana'),(30,'Bouvet Island'),(31,'Brazil'),(32,'British Indian Ocean Territory'),(33,'Brunei Darussalam'),(34,'Bulgaria'),(35,'Burkina Faso'),(36,'Burundi'),(37,'Cambodia'),(38,'Cameroon'),(39,'Canada'),(40,'Cape Verde'),(41,'Cayman Islands'),(42,'Central African Republic'),(43,'Chad'),(44,'Chile'),(45,'China'),(46,'Christmas Island'),(47,'Cocos(Keeling) Islands'),(48,'Colombia'),(49,'Comoros'),(50,'Congo'),(51,'Cook Islands'),(52,'Costa Rica'),(53,'Croatia(Hrvatska)'),(54,'Cuba'),(55,'Cyprus'),(56,'Czech Republic'),(57,'Denmark'),(58,'Djibouti'),(59,'Dominica'),(60,'Dominican Republic'),(61,'East Timor'),(62,'Ecuador'),(63,'Egypt'),(64,'El Salvador'),(65,'Equatorial Guinea'),(66,'Eritrea'),(67,'Estonia'),(68,'Ethiopia'),(69,'Falkland Islands(Malvinas)'),(70,'Faroe Islands'),(71,'Fiji'),(72,'Finland'),(73,'France'),(74,'France, Metropolitan'),(75,'French Guiana'),(76,'French Polynesia'),(77,'French Southern Territories'),(78,'Gabon'),(79,'Gambia'),(80,'Georgia'),(81,'Germany'),(82,'Ghana'),(83,'Gibraltar'),(84,'Guernsey'),(85,'Greece'),(86,'Greenland'),(87,'Grenada'),(88,'Guadeloupe'),(89,'Guam'),(90,'Guatemala'),(91,'Guinea'),(92,'Guinea-Bissau'),(93,'Guyana'),(94,'Haiti'),(95,'Heard and Mc Donald Islands'),(96,'Honduras'),(97,'Hong Kong'),(98,'Hungary'),(99,'Iceland'),(100,'India'),(101,'Isle of Man'),(102,'Indonesia'),(103,'Iran(Islamic Republic of)'),(104,'Iraq'),(105,'Ireland'),(106,'Israel'),(107,'Italy'),(108,'Ivory Coast'),(109,'Jersey'),(110,'Jamaica'),(111,'Japan'),(112,'Jordan'),(113,'Kazakhstan'),(114,'Kenya'),(115,'Kiribati'),(116,'Korea, Democratic People\'s Republic of'),(117,'Korea, Republic of'),(118,'Kosovo'),(119,'Kuwait'),(120,'Kyrgyzstan'),(121,'Lao People\'s Democratic Republic'),(122,'Latvia'),(123,'Lebanon'),(124,'Lesotho'),(125,'Liberia'),(126,'Libyan Arab Jamahiriya'),(127,'Liechtenstein'),(128,'Lithuania'),(129,'Luxembourg'),(130,'Macau'),(131,'Macedonia'),(132,'Madagascar'),(133,'Malawi'),(134,'Malaysia'),(135,'Maldives'),(136,'Mali'),(137,'Malta'),(138,'Marshall Islands'),(139,'Martinique'),(140,'Mauritania'),(141,'Mauritius'),(142,'Mayotte'),(143,'Mexico'),(144,'Micronesia, Federated States of'),(145,'Moldova, Republic of'),(146,'Monaco'),(147,'Mongolia'),(148,'Montenegro'),(149,'Montserrat'),(150,'Morocco'),(151,'Mozambique'),(152,'Myanmar'),(153,'Namibia'),(154,'Nauru'),(155,'Nepal'),(156,'Netherlands'),(157,'Netherlands Antilles'),(158,'New Caledonia'),(159,'New Zealand'),(160,'Nicaragua'),(161,'Niger'),(162,'Nigeria'),(163,'Niue'),(164,'Norfolk Island'),(165,'Northern Mariana Islands'),(166,'Norway'),(167,'Oman'),(169,'Palau'),(170,'Palestine'),(171,'Panama'),(172,'Papua New Guinea'),(173,'Paraguay'),(174,'Peru'),(175,'Philippines'),(176,'Pitcairn'),(177,'Poland'),(178,'Portugal'),(179,'Puerto Rico'),(180,'Qatar'),(181,'Reunion'),(182,'Romania'),(183,'Russian Federation'),(184,'Rwanda'),(185,'Saint Kitts and Nevis'),(186,'Saint Lucia'),(187,'Saint Vincent and the Grenadines'),(188,'Samoa'),(189,'San Marino'),(190,'Sao Tome and Principe'),(191,'Saudi Arabia'),(192,'Senegal'),(193,'Serbia'),(194,'Seychelles'),(195,'Sierra Leone'),(196,'Singapore'),(197,'Slovakia'),(198,'Slovenia'),(199,'Solomon Islands'),(200,'Somalia'),(201,'South Africa'),(202,'South Georgia South Sandwich Islands'),(203,'Spain'),(204,'Sri Lanka'),(205,'St. Helena'),(206,'St. Pierre and Miquelon'),(207,'Sudan'),(208,'Suriname'),(209,'Svalbard and Jan Mayen Islands'),(210,'Swaziland'),(211,'Sweden'),(212,'Switzerland'),(213,'Syrian Arab Republic'),(214,'Taiwan'),(215,'Tajikistan'),(216,'Tanzania, United Republic of'),(217,'Thailand'),(218,'Togo'),(219,'Tokelau'),(220,'Tonga'),(221,'Trinidad and Tobago'),(222,'Tunisia'),(223,'Turkey'),(224,'Turkmenistan'),(225,'Turks and Caicos Islands'),(226,'Tuvalu'),(227,'Uganda'),(228,'Ukraine'),(229,'United Arab Emirates'),(230,'United Kingdom'),(231,'United States'),(232,'United States minor outlying islands'),(233,'Uruguay'),(234,'Uzbekistan'),(235,'Vanuatu'),(236,'Vatican City State'),(237,'Venezuela'),(238,'Vietnam'),(239,'Virgin Islands(British)'),(240,'Virgin Islands(U.S.)'),(241,'Wallis and Futuna Islands'),(242,'Western Sahara'),(243,'Yemen'),(244,'Zaire'),(245,'Zambia'),(246,'Zimbabwe');
/*!40000 ALTER TABLE `ref_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_degree_type`
--

DROP TABLE IF EXISTS `ref_degree_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_degree_type` (
  `degree_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(20) NOT NULL,
  PRIMARY KEY (`degree_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_degree_type`
--

LOCK TABLES `ref_degree_type` WRITE;
/*!40000 ALTER TABLE `ref_degree_type` DISABLE KEYS */;
INSERT INTO `ref_degree_type` VALUES (1,'FSC');
/*!40000 ALTER TABLE `ref_degree_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_department`
--

DROP TABLE IF EXISTS `ref_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_department` (
  `department_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `Title` varchar(20) NOT NULL,
  PRIMARY KEY (`department_type_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `ref_department_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_department`
--

LOCK TABLES `ref_department` WRITE;
/*!40000 ALTER TABLE `ref_department` DISABLE KEYS */;
INSERT INTO `ref_department` VALUES (3,9,'Physics'),(4,9,'Chemistry'),(5,9,'genral'),(6,9,'urdu'),(7,9,'Administration'),(8,9,'Accounts'),(9,9,'Teaching'),(10,9,'Custodil Staff');
/*!40000 ALTER TABLE `ref_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_designation`
--

DROP TABLE IF EXISTS `ref_designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_designation` (
  `designation_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `Title` varchar(20) NOT NULL,
  PRIMARY KEY (`designation_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `ref_designation_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_designation`
--

LOCK TABLES `ref_designation` WRITE;
/*!40000 ALTER TABLE `ref_designation` DISABLE KEYS */;
INSERT INTO `ref_designation` VALUES (3,9,'Lecturer'),(4,9,'Assistant Professor'),(5,9,'Principal'),(6,9,'teacher'),(7,9,'driver'),(8,9,'Teacher'),(9,9,'Accountants'),(10,9,'Principal'),(11,9,'Vice Principal'),(12,9,'Staff Aaya'),(13,9,'Security Guard');
/*!40000 ALTER TABLE `ref_designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_district`
--

DROP TABLE IF EXISTS `ref_district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_district` (
  `district_id` int(11) NOT NULL,
  `District_Name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `province_id` int(11) NOT NULL,
  PRIMARY KEY (`district_id`),
  KEY `FK_ref_District_ref_province` (`province_id`),
  CONSTRAINT `FK_ref_District_ref_province` FOREIGN KEY (`province_id`) REFERENCES `ref_province` (`province_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_district`
--

LOCK TABLES `ref_district` WRITE;
/*!40000 ALTER TABLE `ref_district` DISABLE KEYS */;
INSERT INTO `ref_district` VALUES (111,'BANNU',1),(112,'LAKKI MARWAT',1),(121,'D. I. KHAN',1),(122,'TANK',1),(131,'ABBOTTABAD',1),(132,'BATAGRAM',1),(133,'HARIPUR',1),(134,'KOHISTAN',1),(135,'MANSEHRA',1),(141,'HANGU',1),(142,'KARAK',1),(143,'KOHAT',1),(150,'DIR',1),(151,'BUNER',1),(152,'CHITRAL',1),(153,'LOWER DIR',1),(154,'MALAKAND P AREA',1),(155,'SHANGLA',1),(156,'SWAT',1),(157,'UPPER DIR',1),(161,'MARDAN',1),(162,'SWABI',1),(171,'CHARSADDA',1),(172,'NOWSHERA',1),(173,'PESHAWAR',1),(211,'BAJAUR AGENCY',2),(212,'KHYBER AGENCY',2),(213,'KURRAM AGENCY',2),(214,'MOHMAND AGENCY',2),(215,'N WAZIRISTAN AGENCY',2),(216,'ORAKZAI AGENCY',2),(217,'S WAZIRISTAN AGENCY',2),(221,'T.A.ADJ.LAKKI MARWAT',2),(222,'T A ADJ BANNU',2),(223,'T A ADJ D.I.KHAN',2),(224,'T A ADJ KOHAT',2),(225,'T A ADJ PESHAWAR',2),(226,'T A ADJ TANK',2),(311,'BAHAWALNAGAR',3),(312,'BAHAWALPUR',3),(313,'RAHIM YAR KHAN',3),(321,'DERA GHAZI KHAN',3),(322,'LEIAH',3),(323,'MUZAFFARGARH',3),(324,'RAJANPUR',3),(331,'FAISALABAD',3),(332,'JHANG',3),(333,'TOBA TEK SINGH',3),(341,'GUJRANWALA',3),(342,'GUJRAT',3),(343,'HAFIZABAD',3),(344,'MANDI BAHAUDDIN',3),(345,'NAROWAL',3),(346,'SIALKOT',3),(351,'KASUR',3),(352,'LAHORE',3),(353,'OKARA',3),(354,'SHEIKHUPURA',3),(355,'NANKANA SAHIB',3),(361,'KHANEWAL',3),(362,'LODHRAN',3),(363,'MULTAN',3),(364,'PAKPATTAN',3),(365,'SAHIWAL',3),(366,'VEHARI',3),(371,'ATTOCK',3),(372,'CHAKWAL',3),(373,'JHELUM',3),(374,'RAWALPINDI',3),(381,'BHAKKAR',3),(382,'KHUSHAB',3),(383,'MIANWALI',3),(384,'SARGODHA',3),(411,'BADIN',4),(412,'DADU',4),(413,'HYDERABAD',4),(414,'THATTA',4),(415,'JAMSHORO',4),(420,'KARACHI',4),(421,'KARACHI CENTRAL',4),(422,'KARACHI EAST',4),(423,'KARACHI SOUTH',4),(424,'KARACHI WEST',4),(425,'MALIR',4),(431,'JACOBABAD',4),(432,'LARKANA',4),(433,'SHIKARPUR',4),(434,'KAMBAR SHAHDAD KOT',4),(435,'KASHMORE',4),(441,'MIRPUR KHAS',4),(442,'SANGHAR',4),(443,'THARPARKAR',4),(451,'GHOTKI',4),(452,'KHAIRPUR',4),(453,'NAUSHAHRO FEROZE',4),(454,'NAWAB SHAH',4),(455,'SUKKUR',4),(511,'AWARAN',5),(512,'KALAT',5),(513,'KHARAN',5),(514,'KHUZDAR',5),(515,'LASBELA',5),(516,'MASTUNG',5),(517,'WASHUK',5),(521,'GWADAR',5),(522,'KECH',5),(523,'PANJGUR',5),(531,'BOLAN',5),(532,'JAFFARABAD',5),(533,'JHAL MAGSI',5),(534,'NASIRABAD',5),(541,'CHAGAI',5),(542,'KILLA ABDULLAH',5),(543,'PISHIN',5),(544,'QUETTA',5),(545,'NUSHKI',5),(551,'DERA BUGTI',5),(552,'KOHLU',5),(553,'SIBBI',5),(554,'ZIARAT',5),(561,'BARKHAN',5),(562,'KILLA SAIFULLAH',5),(563,'LORALAI',5),(564,'MUSAKHEL',5),(565,'ZHOB',5),(566,'SHERANI',5),(611,'ISLAMABAD',6),(711,'BALTISTAN',7),(712,'DIAMIR',7),(713,'GHANCHE',7),(714,'GHIZER',7),(715,'GILGIT',7),(811,'BHIMBER',8),(812,'KOTLI',8),(813,'MIRPUR',8),(821,'BAGH',8),(822,'MUZAFFARABAD',8),(823,'POONCH',8),(824,'SUDHNOTI',8),(825,'NEELUM',8),(831,'DODA',8),(832,'JAMMU',8),(833,'KATHUA',8),(834,'POONCH',8),(835,'RAJOURI',8),(836,'UDHAMPUR',8),(841,'KARGIL',8),(842,'LEH',8),(851,'BARAMULLA',8),(852,'BUDGAM',8),(853,'ISLAMABAD (ANANTNAG)',8),(854,'PULWAMA',8),(855,'KUPWARA',8),(856,'SRINAGAR',8);
/*!40000 ALTER TABLE `ref_district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_gardian_type`
--

DROP TABLE IF EXISTS `ref_gardian_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_gardian_type` (
  `gardian_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(20) NOT NULL,
  PRIMARY KEY (`gardian_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_gardian_type`
--

LOCK TABLES `ref_gardian_type` WRITE;
/*!40000 ALTER TABLE `ref_gardian_type` DISABLE KEYS */;
INSERT INTO `ref_gardian_type` VALUES (2,'parent');
/*!40000 ALTER TABLE `ref_gardian_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_group`
--

DROP TABLE IF EXISTS `ref_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `branch id` (`fk_branch_id`),
  KEY `ref_group_ibfk_2` (`fk_class_id`),
  CONSTRAINT `ref_group_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ref_group_ibfk_2` FOREIGN KEY (`fk_class_id`) REFERENCES `ref_class` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_group`
--

LOCK TABLES `ref_group` WRITE;
/*!40000 ALTER TABLE `ref_group` DISABLE KEYS */;
INSERT INTO `ref_group` VALUES (1,1,'Science',1,'2016-12-15','2016-12-15','active'),(2,1,'Arts',2,'2016-12-15',NULL,'active'),(3,1,'Science',2,'2016-12-15',NULL,'active'),(4,1,'Arts',1,'2016-12-16',NULL,'active'),(5,1,'General',3,'2016-12-16','2016-12-16','active'),(7,9,'Medical',11,'2016-12-20','2017-01-13','active'),(8,9,'test',19,'2017-01-03',NULL,'active'),(9,9,'test2',19,'2017-01-03',NULL,'active'),(10,9,'Engineering',11,'2017-01-05',NULL,'active'),(11,9,'Medical',20,'2017-01-10',NULL,'active'),(12,9,'medical',21,'2017-01-19',NULL,'active'),(13,9,'engineering',21,'2017-01-19',NULL,'active'),(14,9,'Medical',22,'2017-01-20',NULL,'active');
/*!40000 ALTER TABLE `ref_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_institute_type`
--

DROP TABLE IF EXISTS `ref_institute_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_institute_type` (
  `institute_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(20) NOT NULL,
  PRIMARY KEY (`institute_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_institute_type`
--

LOCK TABLES `ref_institute_type` WRITE;
/*!40000 ALTER TABLE `ref_institute_type` DISABLE KEYS */;
INSERT INTO `ref_institute_type` VALUES (1,'Government');
/*!40000 ALTER TABLE `ref_institute_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_province`
--

DROP TABLE IF EXISTS `ref_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_province` (
  `province_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `province_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`province_id`),
  KEY `FK_ref_province_ref_countries` (`country_id`),
  CONSTRAINT `FK_ref_province_ref_countries` FOREIGN KEY (`country_id`) REFERENCES `ref_countries` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_province`
--

LOCK TABLES `ref_province` WRITE;
/*!40000 ALTER TABLE `ref_province` DISABLE KEYS */;
INSERT INTO `ref_province` VALUES (1,1,'NWFP'),(2,1,'FATA'),(3,1,'PUNJAB'),(4,1,'SINDH'),(5,1,'BALUCHISTAN'),(6,1,'CAPITAL TERRITORY'),(7,1,'NORTHERN AREAS'),(8,1,'AZAD KASHMIR');
/*!40000 ALTER TABLE `ref_province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_religion`
--

DROP TABLE IF EXISTS `ref_religion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_religion` (
  `religion_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(20) NOT NULL,
  PRIMARY KEY (`religion_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_religion`
--

LOCK TABLES `ref_religion` WRITE;
/*!40000 ALTER TABLE `ref_religion` DISABLE KEYS */;
INSERT INTO `ref_religion` VALUES (2,'Islam');
/*!40000 ALTER TABLE `ref_religion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_section`
--

DROP TABLE IF EXISTS `ref_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_section` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `fk_group_id` int(11) DEFAULT NULL,
  `created_date` date NOT NULL,
  `updated_date` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`section_id`),
  KEY `FK_ref_section_ref_class` (`class_id`),
  KEY `branch id` (`fk_branch_id`),
  KEY `ref_section_ibfk_2` (`fk_group_id`),
  CONSTRAINT `FK_ref_section_ref_class` FOREIGN KEY (`class_id`) REFERENCES `ref_class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ref_section_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ref_section_ibfk_2` FOREIGN KEY (`fk_group_id`) REFERENCES `ref_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_section`
--

LOCK TABLES `ref_section` WRITE;
/*!40000 ALTER TABLE `ref_section` DISABLE KEYS */;
INSERT INTO `ref_section` VALUES (1,1,'A',1,1,'2016-12-15','2016-12-19','active'),(2,1,'B',1,1,'2016-12-16',NULL,'active'),(3,1,'A',1,4,'2016-12-16',NULL,'active'),(4,1,'B',1,4,'2016-12-16',NULL,'active'),(5,1,'A',2,2,'2016-12-16',NULL,'active'),(6,1,'B',2,2,'2016-12-16',NULL,'active'),(7,1,'A',2,3,'2016-12-16',NULL,'active'),(8,1,'B',2,3,'2016-12-16',NULL,'active'),(9,1,'A',3,NULL,'2016-12-16',NULL,'active'),(10,1,'B',3,NULL,'2016-12-16',NULL,'active'),(13,1,'A',5,NULL,'2016-12-20',NULL,'active'),(14,9,'A',14,NULL,'2016-12-20','2016-12-22','active'),(15,9,'B',15,NULL,'2016-12-20','2016-12-22','active'),(16,9,'C',11,7,'2016-12-21',NULL,'active'),(17,9,'A',13,NULL,'2016-12-22',NULL,'active'),(18,9,'B',13,NULL,'2016-12-22',NULL,'active'),(19,9,'C',13,NULL,'2016-12-22',NULL,'active'),(20,9,'A',14,NULL,'2016-12-22',NULL,'active'),(21,9,'B',14,NULL,'2016-12-22',NULL,'active'),(22,9,'B',16,NULL,'2016-12-22',NULL,'active'),(23,9,'A',16,NULL,'2016-12-22',NULL,'active'),(24,9,'A',17,NULL,'2016-12-22',NULL,'active'),(25,9,'B',17,NULL,'2016-12-26',NULL,'active'),(26,9,'C',17,NULL,'2016-12-26',NULL,'active'),(28,9,'C',20,11,'2017-01-10',NULL,'active'),(29,9,'A',19,8,'2017-01-10',NULL,'active'),(30,9,'A',21,12,'2017-01-19',NULL,'active'),(31,9,'B',21,12,'2017-01-19',NULL,'active'),(32,9,'A',22,14,'2017-01-20',NULL,'active');
/*!40000 ALTER TABLE `ref_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_session`
--

DROP TABLE IF EXISTS `ref_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`session_id`),
  KEY `branch id` (`fk_branch_id`),
  CONSTRAINT `ref_session_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_session`
--

LOCK TABLES `ref_session` WRITE;
/*!40000 ALTER TABLE `ref_session` DISABLE KEYS */;
INSERT INTO `ref_session` VALUES (4,1,'2015','0000-00-00','0000-00-00'),(7,1,'2016','0000-00-00','0000-00-00'),(9,1,'2014','0000-00-00','0000-00-00'),(10,1,'2013','0000-00-00','0000-00-00'),(11,1,'2016','0000-00-00','0000-00-00'),(12,9,'2016','0000-00-00','0000-00-00'),(13,9,'2015','0000-00-00','0000-00-00'),(14,9,'2014',NULL,NULL),(16,9,'2017',NULL,NULL);
/*!40000 ALTER TABLE `ref_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_shift`
--

DROP TABLE IF EXISTS `ref_shift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_shift` (
  `shift_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  PRIMARY KEY (`shift_id`),
  KEY `branch id` (`fk_branch_id`),
  CONSTRAINT `ref_shift_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_shift`
--

LOCK TABLES `ref_shift` WRITE;
/*!40000 ALTER TABLE `ref_shift` DISABLE KEYS */;
INSERT INTO `ref_shift` VALUES (2,1,'Morning'),(3,1,'Evening'),(4,9,'Morning'),(5,9,'Evening');
/*!40000 ALTER TABLE `ref_shift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reg_log_association`
--

DROP TABLE IF EXISTS `reg_log_association`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reg_log_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_stu_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `promoted_date` datetime NOT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stu_id` (`fk_stu_id`),
  KEY `fk_user_id` (`fk_user_id`),
  KEY `fk_class_id` (`fk_class_id`),
  CONSTRAINT `reg_log_association_ibfk_1` FOREIGN KEY (`fk_stu_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `reg_log_association_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `student_info` (`user_id`),
  CONSTRAINT `reg_log_association_ibfk_3` FOREIGN KEY (`fk_class_id`) REFERENCES `student_info` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reg_log_association`
--

LOCK TABLES `reg_log_association` WRITE;
/*!40000 ALTER TABLE `reg_log_association` DISABLE KEYS */;
/*!40000 ALTER TABLE `reg_log_association` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `fk_zone_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_zone_id` (`fk_zone_id`),
  CONSTRAINT `route_ibfk_1` FOREIGN KEY (`fk_zone_id`) REFERENCES `zone` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route`
--

LOCK TABLES `route` WRITE;
/*!40000 ALTER TABLE `route` DISABLE KEYS */;
INSERT INTO `route` VALUES (2,'Route 1',2),(3,'Route 1',4),(5,'Route 2',2),(7,'Route 3',2),(8,'buner side',4);
/*!40000 ALTER TABLE `route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id` char(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fk_branch_id` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `data` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES ('03qpgv8pkvntf4lmlacdvvpir0',16,9,1484659814,'__flash|a:0:{}__id|i:16;__expire|i:1484744774;krajeeGridExportSalt|s:32:\"!á\⁄$\Zl˜íì˙öSZ¶†\'è•@˜@\ÔÄbõíñJ^\“\";'),('054b78ghjgo6ham470c2sqv0o3',16,9,1484816710,'__flash|a:0:{}__id|i:16;__expire|i:1484901670;krajeeGridExportSalt|s:32:\"5Wä!]F\\‘¥≠\’G\ ˘;Ö\Î\\—Ö\ﬁP4\· ù\Ë\";'),('07500tsiim7mgdh4jigu1pg2l6',16,9,1484340630,'__flash|a:0:{}__id|i:16;__expire|i:1484425590;'),('09csd4teqrejn5n5kng784e443',16,9,1484672685,'__flash|a:0:{}__id|i:16;__expire|i:1484757645;'),('0g02hvucffchdpvhq2d2isbnj0',16,9,1484294823,'__flash|a:0:{}__id|i:16;__expire|i:1484379783;krajeeGridExportSalt|s:32:\"\ŒF,§\⁄\ﬁ_óÜ[¢>¯\œ˝Hõ\√\«~ÛW|	¥√ì*\";'),('0o3mhhsctcpg9bcig114tbv2l3',16,9,1482384543,'__flash|a:0:{}__id|i:16;__expire|i:1482469503;'),('0osfsjpncsuok7hf0c12mdi3b7',35,10,1482390358,'__flash|a:0:{}__id|i:35;__expire|i:1482475318;'),('0uq43g5d51j7k7tv58n4t35882',16,9,1484055586,'__flash|a:0:{}__id|i:16;__expire|i:1484140546;krajeeGridExportSalt|s:32:\"\Ôö)ähÆr,¥ÍÆ´£HrÜß \0¯<˝\\[w\ƒC¡\·\";'),('10b7lp1nuf7b9n4nh75hqinus7',16,9,1483984128,'__flash|a:0:{}__id|i:16;__expire|i:1484069088;krajeeGridExportSalt|s:32:\"Ñ¨±]	]†5\"\Ê\“\Ï∏\‘\Zñ¬†A˙ˇIGØkEQ\ \";'),('11uiu81huitnlrbjg2rqjavmq3',16,9,1484055717,'__flash|a:0:{}__id|i:16;__expire|i:1484140677;'),('1d2rlq8ba4ufuvi0qoaatluc05',16,9,1483953984,'__flash|a:0:{}__id|i:16;__expire|i:1484038944;krajeeGridExportSalt|s:32:\"ÖSr»òª\ƒ\ÏZ\‘ŒÖ\Á\0X/i\'˝#\‚êZ\‰Ü	˙\";'),('1i586afqoqku4q4n6cj90h5qr2',16,9,1482328082,'__flash|a:0:{}__id|i:16;__expire|i:1482413042;'),('1qejjlghlg877askhhp9pnpvv0',16,9,1482757353,'__flash|a:0:{}__id|i:16;__expire|i:1482842313;krajeeGridExportSalt|s:32:\"\‚˛\Œ%\ÿ\Á\„!U\Óˇ\Õ\Ìµ`ﬁ∞\ÊVﬁÖ[ë©æ]\≈˘Q!\";'),('1sb6s165fdavb8p1regtcbgb94',16,9,1482567128,'__flash|a:0:{}__id|i:16;__expire|i:1482652088;krajeeGridExportSalt|s:32:\"tå9Ñ‹á|ò\Ë;,\◊Ωûâ\È9!		\Ì©\ÓÄOMç\";'),('1t2nbhn2qtbt3616l8p79l6gl1',16,9,1483940879,'__flash|a:0:{}__id|i:16;__expire|i:1484025839;krajeeGridExportSalt|s:32:\"£gå∂$,pÛ~\Ëıq≠\Ó\Ó}\Î–¶\÷fﬂé\\V\";'),('1ug1d6ttpb6o4ojpg6sqhlik67',16,9,1483333484,'__flash|a:0:{}__id|i:16;__expire|i:1483418443;krajeeGridExportSalt|s:32:\"<\…∫T\◊61\ÿTÕ≠,;≠9Cg˜ê\Ê;µØ\Á\n\";'),('1uvdulvfkd6q8ssqfefri9plv2',16,9,1483695822,'__flash|a:0:{}__id|i:16;__expire|i:1483780782;krajeeGridExportSalt|s:32:\"\√jx\0≤dA\‰>Güæ¬ñ©b\Ó&´\ƒHâ]”±&É\";'),('2091fiq6b57k2vo3ninogdsrs0',16,9,1482493613,'__flash|a:0:{}__id|i:16;__expire|i:1482578573;krajeeGridExportSalt|s:32:\"¶∞dñ∂/+c2∂3	Fõπ€ö`ô∞Å\«XV\Î£\‹\";'),('211nue0fo4fio3pd59no4ohc07',16,9,1483614010,'__flash|a:0:{}__id|i:16;__expire|i:1483698970;krajeeGridExportSalt|s:32:\"úeï∞]∑fddCr\√\Ôuâ“Ça}w£+\ÍA \„\Â\";'),('2g7ipptqes2jhhio7v6lp0uqc4',16,9,1482819360,'__flash|a:0:{}__id|i:16;__expire|i:1482904320;krajeeGridExportSalt|s:32:\"\Ã6\ÌÙ¥¥ù˜ã§\‚^•>\≈\√é©{\”6=¢[°’®z¯\";'),('2hs8l6tab4omprpplnr6d2gje5',16,9,1483424224,'__flash|a:0:{}__id|i:16;__expire|i:1483509184;krajeeGridExportSalt|s:32:\"CÛ\ËüXâtòh\Ÿ\¬Œ≥∑Q\ﬂt\0H}S8Ò˘o3~\";'),('2lr438tckk25fb3srviv8vl9f0',16,9,1482247623,'__flash|a:0:{}__id|i:16;__expire|i:1482332583;'),('2ou4970923jj09s1mgkuki8r90',16,9,1482248059,'__flash|a:0:{}__id|i:16;__expire|i:1482333018;'),('2rpp8ojmucp4c88d314mm6mjv7',16,9,1482245003,'__flash|a:0:{}__id|i:16;__expire|i:1482329963;'),('2surlb5463hpkum4o6ds38au76',16,9,1484752311,'__flash|a:0:{}__id|i:16;__expire|i:1484837271;krajeeGridExportSalt|s:32:\"D˘°ñßçºç4t\Ô≈∏5ıØÖ¥fı÷òjR\≈h+§\";'),('2suuoi22mt1f70hnu9fg9i1f67',16,9,1482729301,'__flash|a:0:{}__id|i:16;__expire|i:1482814261;krajeeGridExportSalt|s:32:\"¢Ù4\Î\ÿyß´©\Ôi\’gÆºü\“\ÀçÉı[\Á∂\‚ﬁ£\";'),('32k9ti88p0rqa9tjqjtdli19v6',16,9,1482737264,'__flash|a:0:{}__id|i:16;__expire|i:1482822224;'),('34dtaig86ja44lt5a7plmpsl94',16,9,1482382736,'__flash|a:0:{}__id|i:16;__expire|i:1482467696;'),('381oe1gak2igkl69gpqc7t6h80',16,9,1482320230,'__flash|a:0:{}__id|i:16;__expire|i:1482405190;'),('3hcmj3mbop9vo1j7lrldm4nq64',16,9,1483332990,'__flash|a:0:{}__id|i:16;__expire|i:1483417950;krajeeGridExportSalt|s:32:\"\ﬂıèê\Í\„˛Feb|U\‡\Â,º\‡{C™æJ\…\Œ\À\Ë\rU±\Ô\—\";'),('3hecdqi9jvh7jtvkjt83c7vmo6',16,9,1482269821,'__flash|a:0:{}__id|i:16;__expire|i:1482354781;'),('3ripmo0k7u393ft9p3p78khqm6',16,9,1482925399,'__flash|a:0:{}__id|i:16;__expire|i:1483010359;krajeeGridExportSalt|s:32:\"\ÌûŸª\Ã*/ŸäJ/DÜ\"˚q≠v¥∑Nô¸,\Ô/©\n0L5ì\";'),('40a4ksi9u5pbliklp38br2seo0',16,9,1482243911,'__flash|a:0:{}__id|i:16;__expire|i:1482328871;'),('423mmpk5904mmaketr2ctnvfi6',16,9,1482930935,'__flash|a:0:{}__id|i:16;__expire|i:1483015895;'),('47rp499vav3pqu5hkgfoi1toc7',16,9,1484757338,'__flash|a:0:{}__id|i:16;__expire|i:1484842298;'),('489gdl5j77mcib5qqc53ansea6',35,10,1482172213,'__flash|a:0:{}__id|i:35;__expire|i:1482257173;'),('4bam9379d9igbf3v358ku8o985',16,9,1483604325,'__flash|a:0:{}__id|i:16;__expire|i:1483689285;'),('4htiks2als5jfdlq7rs8jbl0i1',16,9,1482988146,'__flash|a:0:{}__id|i:16;__expire|i:1483073106;'),('4o25vba39ncnfl2n1jflecnid4',16,9,1484115402,'__flash|a:0:{}__id|i:16;__expire|i:1484200362;'),('4sl5ie7tgvffp0ig9pb2o5tev0',16,9,1482498458,'__flash|a:0:{}__id|i:16;__expire|i:1482583418;krajeeGridExportSalt|s:32:\"OÑã|˝∫±_ÕüEu∆ßù\ŒO>ª}±F(ô\n:;G\";'),('505uj83r2deto52euamt9hgkh6',16,9,1483136350,'__flash|a:0:{}__id|i:16;__expire|i:1483221310;'),('5369ugb1gomntl30pfh8ahvkb5',16,9,1482749144,'__flash|a:0:{}__id|i:16;__expire|i:1482834104;'),('5rfbipacimaejopiu16l04mqc0',16,9,1482388906,'__flash|a:0:{}__id|i:16;__expire|i:1482473866;'),('5sgne5inrvee7rbiq3nm5jj4d4',16,9,1482325901,'__flash|a:0:{}__id|i:16;__expire|i:1482410860;'),('5vrsm1aqrslt6uhr680ju4hcc4',16,9,1482926846,'__flash|a:0:{}__id|i:16;__expire|i:1483011806;'),('622s4euat0jat9d8ld87r0vph2',16,9,1483601714,'__flash|a:0:{}__id|i:16;__expire|i:1483686674;krajeeGridExportSalt|s:32:\"£úÆW\»\Œ16í\‘ﬁöH¢0éq¶ı∞õ≥TÚû\Á\÷\‡1\";'),('62h46iki1fc8nngj93p2ckacd3',16,9,1483724989,'__flash|a:0:{}__id|i:16;__expire|i:1483809949;'),('64k344os5lu1h6uq59qucg8n07',16,9,1483724970,'__flash|a:0:{}__id|i:16;__expire|i:1483809930;'),('64nicsf8up58vlsjb9lcoi41t3',16,9,1483772704,'__flash|a:0:{}__id|i:16;__expire|i:1483857664;'),('67693pjl0b85hk906ng383rkj5',16,9,1482929203,'__flash|a:0:{}__id|i:16;__expire|i:1483014163;krajeeGridExportSalt|s:32:\"è£]nTû\Ô*H\÷^\⁄\Á‹Ω`Ã¥m8àë\ÍÖ\'ú\ 8\";'),('6a31hcnv7p9lsfjqoccgeotqn6',16,9,1483185817,'__flash|a:0:{}__id|i:16;__expire|i:1483270777;'),('6a34fnenrvmmhh3tp7gqpahrb2',16,9,1482496733,'__flash|a:0:{}__id|i:16;__expire|i:1482581693;krajeeGridExportSalt|s:32:\"§D\∆—óìÅ^“π ´\Ÿ\Â¬ª_+IŒïª\«\Ï3\·£\";'),('6b96t07ue2sv9o090lrepo6ci1',16,9,1484798521,'__flash|a:0:{}__id|i:16;__expire|i:1484883481;krajeeGridExportSalt|s:32:\"oK∫&ñ9§º∫#UÚ`}}x\Õ˝∫\‰¥hW*∑$\√\";'),('6hkmd52l8e2s1hp4rqsvpbc0h4',16,9,1482923129,'__flash|a:0:{}__id|i:16;__expire|i:1483008089;krajeeGridExportSalt|s:32:\"†#+É\„iß\⁄;\”\–*Cé\ÿ+\√q≠ƒ´\nÃºt\‰Z\";'),('6i5gbg5vvrpp3iqr4bf16ru3j2',16,9,1482483725,'__flash|a:0:{}__id|i:16;__expire|i:1482568685;'),('6k388far1r49vj171bmamqag02',16,9,1483702659,'__flash|a:0:{}__id|i:16;__expire|i:1483787618;'),('6q0kvck9qkl601u08e3m28eor0',16,9,1482509252,'__flash|a:0:{}__id|i:16;__expire|i:1482594212;krajeeGridExportSalt|s:32:\"\Ÿ…µ,Pı@\È¿21ﬁû®(\n9[™H&tEçî%ÉV˛\";'),('6s2tg87ai1f7jq4kc4gfsg2di7',16,9,1484892832,'__flash|a:0:{}__id|i:16;__expire|i:1484977792;krajeeGridExportSalt|s:32:\"!Oô¿b\0¯i{\›R\≈Ù¯gLhd†#é.\Îa7\";'),('6stm946dma6verinst36mrfep0',16,9,1483896592,'__flash|a:0:{}__id|i:16;__expire|i:1483981552;krajeeGridExportSalt|s:32:\"\√3~\›wàˇÑ⁄π40Åí\'µ∂\€Nê\“m\ Ó¨ªR0<¿˝\";'),('6tqp83seol11h280qpsj8trgc4',16,9,1482245967,'__flash|a:0:{}__id|i:16;__expire|i:1482330927;'),('7dmmo2df5cqhapvhvq3rtk45l1',16,9,1482659431,'__flash|a:0:{}__id|i:16;__expire|i:1482744391;krajeeGridExportSalt|s:32:\"w\Ôá>íTlæñ∞\Óhæ\¬+\rPVe$ïîc\—lü•\";'),('7mbdkogu8dd0tshomvad84f6e3',16,9,1483188207,'__flash|a:0:{}__id|i:16;__expire|i:1483273167;krajeeGridExportSalt|s:32:\"Üˇ±B(Aq)\“cï\€2˙Û[è\Õ\›à\‘õ˘Å41Ä\";'),('7r9r68qtrk54ckig7m79pmpdj7',16,9,1483618736,'__flash|a:0:{}__id|i:16;__expire|i:1483703696;krajeeGridExportSalt|s:32:\"=˝N∫¢\nö\0Q≠´=—ìK&‹∑˛Öxc]ø»µi\‡\";'),('7toiic5ch0v6v75360v3fdami3',16,9,1482737605,'__flash|a:0:{}__id|i:16;__expire|i:1482822565;'),('7v1p157d84cl9knv80buds8f15',16,9,1484891138,'__flash|a:0:{}__id|i:16;__expire|i:1484976098;'),('96tq7oaqqfptlvndiltn9u69a4',16,9,1482755483,'__flash|a:0:{}__id|i:16;__expire|i:1482840443;krajeeGridExportSalt|s:32:\"\◊\ƒ(\÷\\2\Á(\„qı\⁄\Ë0.∂˛9õs)\–\Íõ|{ö\Ï\";'),('9bbhotg4f7c880lih26i033f61',16,9,1484752178,'__flash|a:0:{}__id|i:16;__expire|i:1484837138;'),('9ok5r6rfaq6c22qrus1gj0spb4',16,9,1483698994,'__flash|a:0:{}__id|i:16;__expire|i:1483783954;'),('9pr6cmm2s3vkl0fem5rcsmnb92',16,9,1482505733,'__flash|a:0:{}__id|i:16;__expire|i:1482590693;'),('9qtpdnan24s91la8laa9gvrno5',16,9,1484898839,'__flash|a:0:{}__id|i:16;__expire|i:1484983799;'),('a2g7ucp3tkmch0graohqamp924',16,9,1482815749,'__flash|a:0:{}__id|i:16;__expire|i:1482900709;krajeeGridExportSalt|s:32:\"ÆxWxÚXÙ§áíqÒØü\ÍØˆ˚@´yK\Ì#±!\Â\Îô\rØ\";'),('a55qld3ii0oi3eb6fgh6mri6h1',16,9,1483974649,'__flash|a:0:{}__id|i:16;__expire|i:1484059607;'),('a6b5dp43gtcjr21kuvde5niia0',16,9,1482473111,'__flash|a:0:{}__id|i:16;__expire|i:1482558070;'),('a6m8k69ljnqng434a686uosat4',16,9,1482385593,'__flash|a:0:{}__id|i:16;__expire|i:1482470553;'),('a9l21fff1jrmqk8lkaltvoi625',16,9,1484898643,'__flash|a:0:{}__id|i:16;__expire|i:1484983603;krajeeGridExportSalt|s:32:\"ò)[,∫\ÕZ%°òÖïπ˝Ú\‡}∏ÖUNUbAW7ﬁ≤\—\‘\";'),('aaueii0fevtllar72s0m4vgnt2',16,9,1482248024,'__flash|a:0:{}__id|i:16;__expire|i:1482332984;'),('adfhbv61pv0faks8mh8bv0eo06',16,9,1482850815,'__flash|a:0:{}__id|i:16;__expire|i:1482935775;krajeeGridExportSalt|s:32:\"bQÑ°\Z≥S(\‰à\‹Gˆ\€+FG\À˘ât/LäÄ≥\";'),('agakfphonjd1i7cq2oh088p5k4',16,9,1484830011,'__flash|a:0:{}__id|i:16;__expire|i:1484914971;krajeeGridExportSalt|s:32:\"I˛D]\–h5F\¬c”î$H\\\ÈW∆óH≤à°\Ï~éÚdèü\";'),('al2ordvtc7suuhftrgo88ge823',16,9,1484567942,'__flash|a:0:{}__id|i:16;__expire|i:1484652902;'),('araotdv14oe9gmto11tcllrju6',16,9,1484032694,'__flash|a:0:{}__id|i:16;__expire|i:1484117654;krajeeGridExportSalt|s:32:\"4js}oòôÒ–∞Ω\∆Úfá®∂X>Ñ Úu“§°¶;¯\";'),('b3b3m7a75a5pn6csnpe8v0vo24',16,9,1482405217,'__flash|a:0:{}__id|i:16;__expire|i:1482490177;'),('b5vtg1randvtb6jhq4ei40p5i7',16,9,1483536096,'__flash|a:0:{}__id|i:16;__expire|i:1483621056;'),('b782q2nq2qrfuric14or3v4ut3',16,9,1482325837,'__flash|a:0:{}__id|i:16;__expire|i:1482410797;'),('b8r4n0bllnvtecvjbuqpr736a2',16,9,1483771377,'__flash|a:0:{}__id|i:16;__expire|i:1483856337;krajeeGridExportSalt|s:32:\"dÙ?\Ô5j3ëTáPÆ˚\–\”ﬂò\Ï≥-}ÄU\…<\≈4ˇ\";'),('b8votand8qkpra4ju7f5c9cj91',16,9,1482270577,'__flash|a:0:{}__id|i:16;__expire|i:1482355537;'),('bkm3feo1gbob9i37gjhupaht52',16,9,1483971442,'__flash|a:0:{}__id|i:16;__expire|i:1484056402;krajeeGridExportSalt|s:32:\"h\ w≤:;ñj@û\’,˛F\¬FK\Ô˛6©•\Œˆ.ß∏U´˝\";'),('bopi6jsp0fn6tl46r20q125f72',16,9,1484112025,'__flash|a:0:{}__id|i:16;__expire|i:1484196985;'),('bq5ij64al134g55fitasqjemm4',16,9,1482327677,'__flash|a:0:{}__id|i:16;__expire|i:1482412637;'),('broifn172jbnrsgs7v8tg04vo1',16,9,1484509445,'__flash|a:0:{}__id|i:16;__expire|i:1484594405;krajeeGridExportSalt|s:32:\"@kÚT\›7Üì†c\‚\Ã\·ˇWºOIû¡˝≤Z\œ?!\";'),('btovt1vsiqthntr5j6sjhhh8q2',16,9,1484303826,'__flash|a:0:{}__id|i:16;__expire|i:1484388786;krajeeGridExportSalt|s:32:\"pJ∏ëIQ\Œwyw:˛u/\ƒ∞à\‘m\“w∞®>Ån\";'),('buadab5ahk1ntj7pkm16lfo5h2',16,9,1482473496,'__flash|a:0:{}__id|i:16;__expire|i:1482558455;'),('c405pnq3moqbqeqarq9s9q0ee0',16,9,1484711957,'__flash|a:0:{}__id|i:16;__expire|i:1484796917;krajeeGridExportSalt|s:32:\"\rêOUZi\·\‚\÷98\«N®ÆU\n°Fchp|\¬7µÖ\";'),('c751bhh3e6f7clk592etm9q6u3',16,9,1484283718,'__flash|a:0:{}__id|i:16;__expire|i:1484368678;krajeeGridExportSalt|s:32:\"ëªQ:É\ﬁxù\Z≤K2\Ã\‡ÙAqøå\Õ,2å\Ê1\›\‚Ü\ \";'),('c90d5poqnq0hdj8pcn999ema32',16,9,1483688944,'__flash|a:0:{}__id|i:16;__expire|i:1483773904;'),('ced95sh861iij355f9a75vauu4',16,9,1483599066,'__flash|a:0:{}__id|i:16;__expire|i:1483684026;'),('ckmjh3jv2b1gc65hm9ceh0qu60',16,9,1482390340,'__flash|a:0:{}__id|i:16;__expire|i:1482475299;'),('cn46kssjas1aq482b3pj6k3d91',16,9,1482323192,'__flash|a:0:{}__id|i:16;__expire|i:1482408152;'),('cpt7i96hsere2kjkovlkr3puv0',16,9,1484114076,'__flash|a:0:{}__id|i:16;__expire|i:1484199036;krajeeGridExportSalt|s:32:\"ı1\Õ\Î¢o\∆-\‚F\’qxM\÷≠ùÜ\È∆î\‹ñO\”\∆\";'),('dc5ksbujs4hepe6ilggoi9ee87',16,9,1484317414,'__flash|a:0:{}__id|i:16;__expire|i:1484402374;krajeeGridExportSalt|s:32:\"\„\÷\ÃBÆ†ó\‹é©±C\ŸÒm\ﬁ	ßOä++ª¶Ç˘ø[ˇ\";'),('dd64nk6d5ppqfvt9tnavs70nk0',16,9,1484122335,'__flash|a:0:{}__id|i:16;__expire|i:1484207295;krajeeGridExportSalt|s:32:\"/wDY$±\Î\ƒJ\…\Ÿ#\Ê;I\ÍÖOº\Ê\ÍÛ\Ã%lH\∆s.…é\";'),('dfeo0tqkge01pp1a14jc12ioo6',16,9,1482570560,'__flash|a:0:{}__id|i:16;__expire|i:1482655520;krajeeGridExportSalt|s:32:\"¶ë≠£æÕé¸Ω\∆1ã†[\¬˜îä	áäY%åòG\";'),('e2221lblsa51v3nsjufgcdpc15',16,9,1483554393,'__flash|a:0:{}__id|i:16;__expire|i:1483639353;krajeeGridExportSalt|s:32:\"V˘T\·%>©w5ˆ\Ã)(Üå<ük}ã\ #\€+πˇÆô\∆\";'),('e6opvnso5c8jsav33vrvsjjf52',16,9,1483080104,'__flash|a:0:{}__id|i:16;__expire|i:1483165064;'),('e9m8q48p6svthr25roapat20c6',16,9,1484053698,'__flash|a:0:{}__id|i:16;__expire|i:1484138658;krajeeGridExportSalt|s:32:\"/û‘∑\–V\∆˙~W£LòJ\◊\Ã_Ö\√t\‘\”s°Fâ±-ë\";'),('ea67c6ide477n7vi2e02v2vt87',16,9,1484340979,'__flash|a:0:{}__id|i:16;__expire|i:1484425938;'),('ek1ttjlqef247pbamirg9fduu2',16,9,1484198031,'__flash|a:0:{}__id|i:16;__expire|i:1484282991;'),('el27n94mf6f58r311eukkbq8m0',16,9,1482323234,'__flash|a:0:{}__id|i:16;__expire|i:1482408194;'),('end2p5rpm264knms4rn2ppgff6',16,9,1482328369,'__flash|a:0:{}__id|i:16;__expire|i:1482413329;'),('eq7fpthon6hmkp3n45586bv5u2',16,9,1483543832,'__flash|a:0:{}__id|i:16;__expire|i:1483628792;krajeeGridExportSalt|s:32:\"\‹7Œå}!‚úÆx\›._a\⁄\\{dN¿o.m¢ÙáÅâ\";'),('eqfa1dhg13g5tjlfm1geh38nt3',16,9,1484297061,'__flash|a:0:{}__id|i:16;__expire|i:1484382021;'),('es4gambf6d0vkso54h772d9k86',16,9,1484645286,'__flash|a:0:{}__id|i:16;__expire|i:1484730246;krajeeGridExportSalt|s:32:\"ƒ¨t\‘ZH\‚§\‰\ÿ\"Ic7WŸç˛\04\nïZ\Ïí\Ï\";'),('f8mq7f67eptla87lth7mdt0ae3',16,9,1482248283,'__flash|a:0:{}__id|i:16;__expire|i:1482333243;'),('fnn7bo85vhcl6jvg9gffoqtk91',16,9,1484897652,'__flash|a:0:{}__id|i:16;__expire|i:1484982611;'),('fujnp3dufs5c5frfatgpgrt7a4',16,9,1482390291,'__flash|a:0:{}__id|i:16;__expire|i:1482475251;'),('gd4t7oummg4g110ancte5h3ek0',16,9,1483725588,'__flash|a:0:{}__id|i:16;__expire|i:1483810542;'),('gmph2rii5199re59lns6f3s8t5',16,9,1483963211,'__flash|a:0:{}__id|i:16;__expire|i:1484048171;krajeeGridExportSalt|s:32:\"ïPl/é∫1™páWs2=N±£éx_∂ ≥´¢\";'),('gn7lgcatav98r63h1l8ea5qgc4',16,9,1484024456,'__flash|a:0:{}__id|i:16;__expire|i:1484109416;krajeeGridExportSalt|s:32:\"€£¸fë\ﬁ¢˚ñ.\ﬁT/o	1\ÏT†ö≠3ˆ`\ÂUY„å£\";'),('gne9q350e7nf9mkvuvdeom0q52',16,9,1482324675,'__flash|a:0:{}__id|i:16;__expire|i:1482409635;'),('gnmcqkcfv1e0obe7qb59lpgak6',16,9,1483948874,'__flash|a:0:{}__id|i:16;__expire|i:1484033834;krajeeGridExportSalt|s:32:\"y˙y\Ì™üöOß/ªâ°*ZgN˙≥˚DßèB\‚ˆ\€L\";'),('gt8f49o8m81u3tsso7b8p13g76',16,9,1483460648,'__flash|a:0:{}__id|i:16;__expire|i:1483545608;krajeeGridExportSalt|s:32:\"\Â\rˆ«≠\n•ê+Dî¡W*\…˝˛ˆaO\–ª\ÎI*ˇ\Î\";'),('gui6ubuoclf7bo3fdfd234hrc7',16,9,1484111704,'__flash|a:0:{}__id|i:16;__expire|i:1484196664;'),('gvgrcscutmo8a5sbreh1ckebb0',16,9,1484211564,'__flash|a:0:{}__id|i:16;__expire|i:1484296524;'),('h15ma6t2hb38rf1gv3egr87mh6',16,9,1484648157,'__flash|a:0:{}__id|i:16;__expire|i:1484733117;'),('ha1g548os0u66knl0vc0jj5i72',16,9,1484227371,'__flash|a:0:{}__id|i:16;__expire|i:1484312331;krajeeGridExportSalt|s:32:\"wë\Â\ÀnR?t@\ÏˆÜ´†ÑöG\‡∞Òìùπ¶˝I1!\";'),('hbgefs75j42dk4pqfahbp77j45',16,9,1482749607,'__flash|a:0:{}__id|i:16;__expire|i:1482834567;krajeeGridExportSalt|s:32:\"C Bèı\€^oôOö\Z5f5!¨\¬\Ô\»@˜kAòò\ÍÙ7P\";'),('hcmqfrbv0d8amc3kgkb87cmqp5',16,9,1483361676,'__flash|a:0:{}__id|i:16;__expire|i:1483446636;krajeeGridExportSalt|s:32:\"\‚*SÜ´ô1â†ù<ù\ﬁ\Ìï`ü û-\∆\\±™\0îÖ\Ì\";'),('heulji27qmpriak0fnj5lqj1o1',16,9,1482745230,'__flash|a:0:{}__id|i:16;__expire|i:1482830190;'),('hfjru3kd6qn4jhb874nsfdf243',16,9,1482256725,'__flash|a:0:{}__id|i:16;__expire|i:1482341685;'),('hgpk77c1mrbf1kaspj14qoa211',16,9,1483941392,'__flash|a:0:{}__id|i:16;__expire|i:1484026352;krajeeGridExportSalt|s:32:\"\⁄\–#æü5\Â\Â∫1∫b-^K\‚|U\ÕzGÿ≥\ÁT}\÷\";'),('hhpun997268spvcshmjutaf5g3',16,9,1482496622,'__flash|a:0:{}__id|i:16;__expire|i:1482581582;krajeeGridExportSalt|s:32:\"\›9ú\ﬁ\Â\ÈÅ‰æãü¸\‡Ú™dZí\Ë\ËS\Â\€\»©yª\";'),('hi5t6j9ufm93o5438ctm85tli1',16,9,1482247836,'__flash|a:0:{}__id|i:16;__expire|i:1482332796;'),('i4aljb0eonm0jdkgkpbh7iv6q3',16,9,1482739259,'__flash|a:0:{}__id|i:16;__expire|i:1482824219;'),('ibn8b6al9bmr81gnbgs7a43o95',16,9,1483947460,'__flash|a:0:{}__id|i:16;__expire|i:1484032420;krajeeGridExportSalt|s:32:\".<W\ÎSÏ¢ïz˘JY\ƒ\’ÿ≤\rã\¬O@±\ÔCá!≠\";'),('imtq49r6e0jnvhemc5mr8oqsd6',16,9,1482925605,'__flash|a:0:{}__id|i:16;__expire|i:1483010564;'),('irek6nh1v87rv82e6hmgfba272',16,9,1482664321,'__flash|a:0:{}__id|i:16;__expire|i:1482749281;'),('irmhbimsfas4fs8ucvg18lshl1',16,9,1484030934,'__flash|a:0:{}__id|i:16;__expire|i:1484115894;krajeeGridExportSalt|s:32:\"º#C\0<Úåïá\Zb\r\Õ\À˛\ÎDOH∑ex\n_\Ÿrì\‚\";'),('itcs16i7mbugnvva2q58mtd0h6',16,9,1484136672,'__flash|a:0:{}__id|i:16;__expire|i:1484221632;'),('j7pj2udc0moh5v4ibvh1o95t05',16,9,1482320476,'__flash|a:0:{}__id|i:16;__expire|i:1482405436;'),('jkq1mi1lrfqd7divhk1klur554',16,9,1482491665,'__flash|a:0:{}__id|i:16;__expire|i:1482576625;krajeeGridExportSalt|s:32:\"\∆uÛ~¢ZàëB\Î\ ›øRrFIûs©$Û\È\‡UWf\”\";'),('jmdqn946qi28opjntg38dc5ro6',16,9,1482390328,'__flash|a:0:{}__id|i:16;__expire|i:1482475288;'),('k7hk64mb0tiv98nclrfhtn3kl4',16,9,1482315956,'__flash|a:0:{}__id|i:16;__expire|i:1482400916;'),('ka6i04qf7upsgb3n7j1vc39595',16,9,1482732372,'__flash|a:0:{}__id|i:16;__expire|i:1482817331;'),('kdmurn74bmr7661mpvm93fj2a4',16,9,1482390295,'__flash|a:0:{}__id|i:16;__expire|i:1482475255;'),('kpnpnd1v9ajfrc9qs8lljqeo83',16,9,1482391754,'__flash|a:0:{}__id|i:16;__expire|i:1482476714;'),('l3o0g7j4dohk8qfc1sqrcpnop1',16,9,1482911933,'__flash|a:0:{}__id|i:16;__expire|i:1482996893;krajeeGridExportSalt|s:32:\"+PsE\ÕeëJÒwc£\'é\…Fö§}ö\ﬂX\‘[˘-û6á\";'),('l7cs2o7hb0pj7hdhjm1q519ah6',75,17,1483964147,'__flash|a:0:{}__id|i:75;__expire|i:1484049107;krajeeGridExportSalt|s:32:\"à=∞N\‰ì¡ƒ®mùc\Ê~v*ånò\ÍF0,ˆ¢-\√\ÁOÚπ\";'),('lcr3lsj7n3i0resbic43osg9o0',35,10,1482390295,'__flash|a:0:{}__id|i:35;__expire|i:1482475255;'),('lgb1s5gbfu4mq4mobfjjo096b2',16,9,1484747216,'__flash|a:0:{}__id|i:16;__expire|i:1484832176;krajeeGridExportSalt|s:32:\"ùIê∫\·\›?ß[ÃÆ§Æ∑`}\∆eÑΩ\‹Bï]Õ∏⁄ª\";'),('li64qaeaknh383pmv2r1rutol5',16,9,1484899049,'__flash|a:0:{}__id|i:16;__expire|i:1484984008;'),('lu8vpong54jgacf7mhbhcu64k6',16,9,1482999812,'__flash|a:0:{}__id|i:16;__expire|i:1483084772;'),('lul6ljii6ifmk04v479dguhou2',16,9,1482416768,'__flash|a:0:{}__id|i:16;__expire|i:1482501728;'),('m42h6vcfl5dkhhfc3sli4vbpo6',75,17,1484035542,'__flash|a:0:{}__id|i:75;__expire|i:1484120501;krajeeGridExportSalt|s:32:\"Ü¢ì\–aï\√\‹Iû“≠\„\„\€˘p©6\Ë\…\Z-≥\Ì:\Ïˇ\";'),('mbjo1o5cb8d5n8dqj0dc39cjd5',16,9,1482390294,'__flash|a:0:{}__id|i:16;__expire|i:1482475254;'),('moutm6f3a6ga4hmqnjonkti9r6',16,9,1484796419,'__flash|a:0:{}__id|i:16;__expire|i:1484881379;krajeeGridExportSalt|s:32:\"∞ygP¿™bâ†∂\”\‰õS\ﬁ`\ÁR\“z!Kß:¡∆ó†œêˇ\";'),('mq3duh34flqroljb2155601sl3',16,9,1482475597,'__flash|a:0:{}__id|i:16;__expire|i:1482560557;krajeeGridExportSalt|s:32:\"g#q&uı¯*\È+\ÿ?Ò∞úôi\÷KgXT-∞ßù=π\Â&(\";'),('muj0aavn2l9pbd942jroe7vke7',16,9,1483964043,'__flash|a:0:{}__id|i:16;__expire|i:1484049003;'),('n59fbojgiqsdtkavea97ilovf0',16,9,1482390320,'__flash|a:0:{}__id|i:16;__expire|i:1482475280;'),('n8i7drtentqg1pgistrd5ieth4',16,9,1482931866,'__flash|a:0:{}__id|i:16;__expire|i:1483016826;krajeeGridExportSalt|s:32:\"FöX⁄®a:\– »•}ôˇ©°\—†úÛ\À\ÍrQà\Á\“‹îp\";'),('nad0nrrrl4immnabjr92tjqio5',16,9,1484829663,'__flash|a:0:{}__id|i:16;__expire|i:1484914623;krajeeGridExportSalt|s:32:\"\Œ1äèòe≥´3\Õ\…»ã$\‘\€\‘uk\’7R\À¸˜˝\«b\";'),('nd5ntpaadnq56962ibjba8sv44',16,9,1483968195,'__flash|a:0:{}__id|i:16;__expire|i:1484053155;'),('nei2dj7e2l5253fk21m24qjai3',16,9,1483938840,'__flash|a:0:{}__id|i:16;__expire|i:1484023800;'),('nog1nis5nvrlpm0o6t978merq2',16,9,1483536979,'__flash|a:0:{}__id|i:16;__expire|i:1483621939;krajeeGridExportSalt|s:32:\"ó%ÖUæ|¯öP\¬\–:•M\ËY\\\”˜î°ıÙ\‹¸˝\";'),('nq45fes19445qs7e5cdnu9pcl1',16,9,1482473314,'__flash|a:0:{}__id|i:16;__expire|i:1482558273;'),('ob2su22bjdqkq2lefgtsica0a0',16,9,1482996990,'__flash|a:0:{}__id|i:16;__expire|i:1483081950;'),('oftqcendqnoe6qc325a1ocnfn3',16,9,1483440422,'__flash|a:0:{}__id|i:16;__expire|i:1483525382;'),('oo0a5k1u8qu0o3tno1lv3avo50',16,9,1484137487,'__flash|a:0:{}__id|i:16;__expire|i:1484222447;krajeeGridExportSalt|s:32:\"\0èP/®Ç±\'@\Ó\⁄!˛∑Ñ\Zì*(E~,w\Ô∂u©d¸\";'),('otap3er7gs7lktu699uj37can6',16,9,1482265238,'__flash|a:0:{}__id|i:16;__expire|i:1482350198;'),('p0c9spgae2bfs05j2u6duheh71',16,9,1484319303,'__flash|a:0:{}__id|i:16;__expire|i:1484404263;krajeeGridExportSalt|s:32:\"å0†=áú˜⁄ºR˜ûÑkı`ùu\—\ÔuIhçj\Õr∫/\";'),('p53novjkoabm5kqoc5n3nma542',16,9,1482238510,'__flash|a:0:{}__id|i:16;__expire|i:1482323470;'),('pcqgh05efg9qosdak7v3o7k9f6',16,9,1484640806,'__flash|a:0:{}__id|i:16;__expire|i:1484725766;'),('pe500n8qogfkh49u9qgp1u5dt0',75,17,1484035527,'__flash|a:0:{}__id|i:75;__expire|i:1484120487;krajeeGridExportSalt|s:32:\"+\È(˚}ô@;§\‘ËãØ\Ã.y\Î´W¨ó¿\≈\œ\Ë\ﬂ°¡aí\";'),('pkr8clc3sr207666rsuht3o222',16,9,1484051563,'__flash|a:0:{}__id|i:16;__expire|i:1484136523;'),('pls6uhcirenrgcfj6qb3q1gld2',16,9,1484665569,'__flash|a:0:{}__id|i:16;__expire|i:1484750529;'),('poa3m2472hs9doep1gqd6554e6',16,9,1482729050,'__flash|a:0:{}__id|i:16;__expire|i:1482814010;krajeeGridExportSalt|s:32:\"\‡Ò7\—xW¡P3òÑE\ÏÇ\Ÿcxx8\“sà\rTÇ¶=H\";'),('q09g23vjdtgv2q1rfmlpuovrp3',16,9,1483983758,'__flash|a:0:{}__id|i:16;__expire|i:1484068718;krajeeGridExportSalt|s:32:\"öåÜ1+èÉ•,∂\“\Ô+˙\Èç\ﬂ\Ê\⁄5\≈s§¿\ÁZ\";'),('q0e3104kq6mved7tl2co3t16o3',16,9,1482390314,'__flash|a:0:{}__id|i:16;__expire|i:1482475274;'),('q5k9t0g2eq0tia3nfnbdd0a6r6',16,9,1484891446,'__flash|a:0:{}__id|i:16;__expire|i:1484976406;'),('qkm7lrjm9p7jttqfeppm3g4v27',16,9,1483715478,'__flash|a:0:{}__id|i:16;__expire|i:1483800438;'),('qn5cuoobfbs4i745gn5am3cpb0',16,9,1483970477,'__flash|a:0:{}__id|i:16;__expire|i:1484055436;'),('qop7l8np9jg8cfd43tlk3gqi86',16,9,1482925260,'__flash|a:0:{}__id|i:16;__expire|i:1483010219;'),('r07p2sg169b2m9hpfll7pqfkh3',16,9,1484059077,'__flash|a:0:{}__id|i:16;__expire|i:1484144037;'),('r2uhmng01a8q3t5s4q63j9rq23',16,9,1483622775,'__flash|a:0:{}__id|i:16;__expire|i:1483707735;krajeeGridExportSalt|s:32:\"#ë\"X\€,o≤]\‰\'dπ\‘ˇD\Ë6é?¶vö\rx1%\€br\";'),('rj0hldg2iuoa9g6tk4n28fomd7',16,9,1484032248,'__flash|a:0:{}__id|i:16;__expire|i:1484117208;'),('rl7vvtq1a8c59hj8i0m3p9lf15',16,9,1483599328,'__flash|a:0:{}__id|i:16;__expire|i:1483684288;'),('rqbrbnrriot5dk2pssms6g46u3',16,9,1484553158,'__flash|a:0:{}__id|i:16;__expire|i:1484638118;'),('s283cm4sqg0nga133skt2kvhk2',16,9,1482328484,'__flash|a:0:{}__id|i:16;__expire|i:1482413444;'),('s31jn9c6fv5anddcavt6ukpcg6',16,9,1482245462,'__flash|a:0:{}__id|i:16;__expire|i:1482330422;'),('sb0mec3npqs6rs85qkk8hdpli3',16,9,1484145765,'__flash|a:0:{}__id|i:16;__expire|i:1484230725;krajeeGridExportSalt|s:32:\"∑Ω a/?\Í◊µuµèæ,ù}\‹jk¥\Z\÷˛owsπ\";'),('sb14jtcth88fpsa1se03iq9g05',16,9,1484729731,'__flash|a:0:{}__id|i:16;__expire|i:1484814691;'),('seh209dsicslr22he8dnmlajo5',16,9,1484294970,''),('spbmkn61c7mmki7lfmtugp19o6',16,9,1483938107,'__flash|a:0:{}__id|i:16;__expire|i:1484023067;krajeeGridExportSalt|s:32:\"B<`wúWÿø´=áq\Ë)íFFW2\·\≈˝p\ŸJÖ\‚E\À\";'),('t000d2jtd2uiamacg5h45cqeh7',16,9,1482306071,'__flash|a:0:{}__id|i:16;__expire|i:1482391031;'),('t724fbmblit3qhnjocfpelo2j1',16,9,1483969939,'__flash|a:0:{}__id|i:16;__expire|i:1484054898;'),('t7luc6aclrsfo6sc5abgivg2l5',16,9,1482408399,'__flash|a:0:{}__id|i:16;__expire|i:1482493359;'),('tb0405sbbj03bv1920minlckj5',16,9,1484293242,'__flash|a:0:{}__id|i:16;__expire|i:1484378202;'),('tfanhg3uqpjcogamki74j783u2',75,17,1484038873,'__flash|a:0:{}__id|i:75;__expire|i:1484123833;krajeeGridExportSalt|s:32:\"ùa\Ó7Ä\Ì¥\ \“o∑/u¡\'Gw≠Y\—\‡®˘Y\ÍÉ=_\";'),('tg06aopjbfjg2qicvot1l1qqk4',16,9,1484826301,'__flash|a:0:{}__id|i:16;__expire|i:1484911261;'),('tjirds421ro471r2v3hhugif30',16,9,1484055125,'__flash|a:0:{}__id|i:16;__expire|i:1484140085;'),('tl1aslqao2oopqkhnjglihcg03',16,9,1484550362,'__flash|a:0:{}__id|i:16;__expire|i:1484635322;krajeeGridExportSalt|s:32:\"*∂\ ˜Yê\Á*06öD6¡:goe9|ó©ˆ≥p¨C\";'),('tnha92i5e6ou59uv2ib326qnh1',16,9,1484747919,'__flash|a:0:{}__id|i:16;__expire|i:1484832878;'),('tosi2999o0vgj1mlcr761pgjh6',16,9,1482323882,'__flash|a:0:{}__id|i:16;__expire|i:1482408842;'),('u9ed836vci66ub8drf7aie62d5',16,9,1482420940,'__flash|a:0:{}__id|i:16;__expire|i:1482505900;krajeeGridExportSalt|s:32:\"|ò@¸∫¶ÒÆoë–ìÑ˛ÜÚl]dó∏ØØe˝\–\";'),('ua5p3ssb3rhv38e19jphj1jkp1',16,9,1482410658,'__flash|a:0:{}__id|i:16;__expire|i:1482495618;krajeeGridExportSalt|s:32:\"ÿÆrym•Æ\Œ|$Ωd8ç2µ¶≥º≠\ÏeW\√7w\«\∆\";'),('udl8k0cd2tje7626rcgehch3u7',16,9,1482323498,'__flash|a:0:{}__id|i:16;__expire|i:1482408458;'),('ueklfkrssovh4tqckj83un1vt5',16,9,1482473631,'__flash|a:0:{}__id|i:16;__expire|i:1482558591;'),('uj6q34tljq9bplolnqjqp638l0',16,9,1483362995,'__flash|a:0:{}__id|i:16;__expire|i:1483447955;krajeeGridExportSalt|s:32:\"≠Ä¥t˚é+Úà≠∞}Ω\”rëLtÛêr+Ø0ãºÖ\";'),('uve5g0852rpdkf0nfj5ahkuda4',16,9,1483099828,'__flash|a:0:{}__id|i:16;__expire|i:1483184788;krajeeGridExportSalt|s:32:\"ë\”\÷˚A|\Àr9lú∏\Ïà\·Æ\“®Úó<}”Æ(ï§\";'),('v4i3535nhd5bhdtp9i78ltnqm6',16,9,1484735602,'__flash|a:0:{}__id|i:16;__expire|i:1484820562;'),('v5sbkrtgs740l33le2vjs511t3',16,9,1482390294,'__flash|a:0:{}__id|i:16;__expire|i:1482475254;'),('v77enbnhdshim804lk2tq119f0',16,9,1482259630,'__flash|a:0:{}__id|i:16;__expire|i:1482344590;'),('v967p5lt88klar2l39o8abrbg3',16,9,1484670135,'__flash|a:0:{}__id|i:16;__expire|i:1484755095;'),('vav658l13413os5etcm2cgbor6',16,9,1483599097,'__flash|a:0:{}__id|i:16;__expire|i:1483684056;'),('vb1f2ht9su4l8cco19ck94hes0',16,9,1482391914,'__flash|a:0:{}__id|i:16;__expire|i:1482476874;'),('vda2homqlvi3o9vg5gv78cimt7',16,9,1483014080,'__flash|a:0:{}__id|i:16;__expire|i:1483099040;krajeeGridExportSalt|s:32:\"˘†üP1πZü¢(ª[ù∑W\Ôd\Ë\·\ƒg±Ù2Ñ Ñ\Ó`b\ÍN\";'),('vfc6vsaur9k61rdd5q8qlruov7',16,9,1484054812,'__flash|a:0:{}__id|i:16;__expire|i:1484139772;'),('vmn6tkengq8venfgouilljkcn6',16,9,1484286736,'__flash|a:0:{}__id|i:16;__expire|i:1484371696;'),('vp974so7gfjv99l8sbiegrn5m2',16,9,1482660406,'__flash|a:0:{}__id|i:16;__expire|i:1482745366;krajeeGridExportSalt|s:32:\"∏còq^îˆç/f≥ıÇS\Ë\Ÿ BP&[FV@$\◊uì\∆h^\";'),('vrg1o82ipbo691cg3gbl1mikh7',16,9,1483101254,'__flash|a:0:{}__id|i:16;__expire|i:1483186214;krajeeGridExportSalt|s:32:\"˘ò˚qMôjq¥Wb4w$\Â|8Mè[W3Âñπ\◊\ﬂ\“N\";');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fee_due_date` int(20) NOT NULL,
  `school_time_in` time NOT NULL,
  `school_time_out` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,9,7,'05:19:28','08:30:43');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stop`
--

DROP TABLE IF EXISTS `stop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `fk_route_id` int(11) NOT NULL,
  `fare` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_route_id` (`fk_route_id`),
  CONSTRAINT `stop_ibfk_1` FOREIGN KEY (`fk_route_id`) REFERENCES `route` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stop`
--

LOCK TABLES `stop` WRITE;
/*!40000 ALTER TABLE `stop` DISABLE KEYS */;
INSERT INTO `stop` VALUES (2,'G-7',2,200),(3,'Faizabad',2,90),(4,'Karachi Company',3,120),(5,'Aabpara',2,90),(7,'23fg',7,123),(9,'adf',5,37),(10,'stop2',5,600),(11,'PALODAND',8,1000),(12,'SALIM KHAN',8,500);
/*!40000 ALTER TABLE `stop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_stu_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `leave_type` enum('absent','shortleave','leave','present') NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stu_id` (`fk_stu_id`),
  CONSTRAINT `student_attendance_ibfk_2` FOREIGN KEY (`fk_stu_id`) REFERENCES `student_info` (`stu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendance`
--

LOCK TABLES `student_attendance` WRITE;
/*!40000 ALTER TABLE `student_attendance` DISABLE KEYS */;
INSERT INTO `student_attendance` VALUES (1,12,'2017-01-03 15:45:14','absent','fsdfsdf'),(2,12,'2017-01-05 12:51:16','shortleave','xds'),(3,12,'2017-01-06 04:59:09','absent','asd'),(4,12,'2017-01-07 04:32:36','leave','oo'),(5,12,'2016-12-09 06:36:56','absent','test'),(6,25,'2017-01-13 15:34:29','absent','fg'),(7,18,'2016-11-18 15:56:44','absent','zxxc'),(8,18,'2017-01-13 15:57:41','shortleave','dd'),(9,20,'2017-01-13 17:15:50','present','qwerr'),(10,22,'2017-01-13 17:15:50','present','df'),(11,24,'2017-01-13 16:09:46','shortleave','df'),(12,26,'2017-01-13 17:04:28','shortleave','n'),(13,19,'2017-01-13 17:14:56','leave','qwerr');
/*!40000 ALTER TABLE `student_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_educational_history_info`
--

DROP TABLE IF EXISTS `student_educational_history_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_educational_history_info` (
  `edu_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `degree_name` varchar(50) DEFAULT NULL,
  `degree_type_id` int(11) DEFAULT NULL,
  `Institute_name` varchar(50) DEFAULT NULL,
  `institute_type_id` int(11) DEFAULT NULL,
  `grade` varchar(4) DEFAULT NULL,
  `total_marks` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `marks_obtained` int(11) DEFAULT NULL,
  PRIMARY KEY (`edu_history_id`),
  KEY `FK_student_educational_history_info_student_info` (`stu_id`),
  KEY `degree_type_id` (`degree_type_id`),
  KEY `institute_type_id` (`institute_type_id`),
  CONSTRAINT `FK_student_educational_history_info_student_info` FOREIGN KEY (`stu_id`) REFERENCES `student_info` (`stu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `student_educational_history_info_ibfk_1` FOREIGN KEY (`degree_type_id`) REFERENCES `ref_degree_type` (`degree_type_id`),
  CONSTRAINT `student_educational_history_info_ibfk_2` FOREIGN KEY (`institute_type_id`) REFERENCES `ref_institute_type` (`institute_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_educational_history_info`
--

LOCK TABLES `student_educational_history_info` WRITE;
/*!40000 ALTER TABLE `student_educational_history_info` DISABLE KEYS */;
INSERT INTO `student_educational_history_info` VALUES (1,'PreMed',1,'ICB',1,'b+',100,'2016-12-01','2016-12-18',6,80),(2,'bsc',1,'adsf',1,'A',23,'2017-01-12','2017-01-20',24,23),(3,'Fsc',1,'FG',NULL,'B',1100,'2000-07-05','2017-01-05',25,600),(4,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',26,NULL),(5,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',27,NULL),(6,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',28,NULL),(7,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',29,NULL),(8,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',30,NULL),(9,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',31,NULL),(10,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',32,NULL),(11,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',33,NULL),(12,'',NULL,'',NULL,'',NULL,'2017-01-13','2017-01-13',34,NULL),(13,'qweqe',1,'werqwer',NULL,'a',423,'2017-01-12','2017-01-14',35,234),(14,'FSC',1,'TSS',NULL,'a1',250,'2017-01-20','2017-01-20',36,300),(15,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',37,NULL),(16,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',38,NULL),(17,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',39,NULL),(18,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',40,NULL),(19,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',41,NULL),(20,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',42,NULL),(21,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',43,NULL),(22,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',44,NULL),(23,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',45,NULL),(24,'',NULL,'',NULL,'',NULL,'2017-01-20','2017-01-20',46,NULL);
/*!40000 ALTER TABLE `student_educational_history_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_fee_section`
--

DROP TABLE IF EXISTS `student_fee_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_fee_section` (
  `stdfs_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) NOT NULL,
  `value` int(11) DEFAULT NULL,
  `stu_id` int(11) NOT NULL,
  PRIMARY KEY (`stdfs_id`),
  KEY `FK_student_fee_section_student_info` (`stu_id`),
  CONSTRAINT `FK_student_fee_section_student_info` FOREIGN KEY (`stu_id`) REFERENCES `student_info` (`stu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_fee_section`
--

LOCK TABLES `student_fee_section` WRITE;
/*!40000 ALTER TABLE `student_fee_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_fee_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_fee_status`
--

DROP TABLE IF EXISTS `student_fee_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_fee_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_stu_id` int(11) NOT NULL,
  `fk_fee_collection_particular_id` int(11) NOT NULL,
  `amount_paid` int(11) DEFAULT NULL,
  `amount_payable_refundable` int(11) DEFAULT NULL,
  `fee_paid_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stu_id` (`fk_stu_id`),
  KEY `fk_fee_collection_particular_id` (`fk_fee_collection_particular_id`),
  CONSTRAINT `student_fee_status_ibfk_1` FOREIGN KEY (`fk_stu_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `student_fee_status_ibfk_2` FOREIGN KEY (`fk_fee_collection_particular_id`) REFERENCES `fee_collection_particular` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_fee_status`
--

LOCK TABLES `student_fee_status` WRITE;
/*!40000 ALTER TABLE `student_fee_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_fee_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_fine_detail`
--

DROP TABLE IF EXISTS `student_fine_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_fine_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_fine_typ_id` int(11) NOT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'no',
  `fk_stu_id` int(11) NOT NULL,
  `payment_received` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fine_typ_id` (`fk_fine_typ_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `fk_stu_id` (`fk_stu_id`),
  CONSTRAINT `student_fine_detail_ibfk_1` FOREIGN KEY (`fk_fine_typ_id`) REFERENCES `fine_type` (`id`),
  CONSTRAINT `student_fine_detail_ibfk_2` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `student_fine_detail_ibfk_3` FOREIGN KEY (`fk_stu_id`) REFERENCES `student_info` (`stu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_fine_detail`
--

LOCK TABLES `student_fine_detail` WRITE;
/*!40000 ALTER TABLE `student_fine_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_fine_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_info`
--

DROP TABLE IF EXISTS `student_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_info` (
  `stu_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fk_branch_id` int(11) NOT NULL,
  `dob` date NOT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `emergency_contact_no` varchar(30) DEFAULT NULL,
  `gender_type` tinyint(1) NOT NULL,
  `guardian_type_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `shift_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `cnic` char(15) CHARACTER SET utf8mb4 DEFAULT NULL,
  `location1` varchar(50) DEFAULT NULL,
  `location2` varchar(50) DEFAULT NULL,
  `withdrawl_no` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `religion_id` int(11) NOT NULL,
  `parent_status` bit(1) DEFAULT b'1',
  `is_hostel_avail` tinyint(2) DEFAULT '0',
  `fk_stop_id` int(11) DEFAULT NULL,
  `fk_fee_plan_type` int(11) DEFAULT NULL,
  `is_active` tinyint(2) DEFAULT '0',
  `fk_ref_country_id2` int(11) DEFAULT NULL,
  `fk_ref_province_id2` int(11) DEFAULT NULL,
  `fk_ref_district_id2` int(11) DEFAULT NULL,
  `fk_ref_city_id2` int(11) DEFAULT NULL,
  PRIMARY KEY (`stu_id`),
  KEY `FK_student_info_ref_session` (`session_id`),
  KEY `FK_student_info_ref_shift` (`shift_id`),
  KEY `FK_student_info_ref_group` (`group_id`),
  KEY `FK_student_info_ref_class` (`class_id`),
  KEY `FK_student_info_ref_section` (`section_id`),
  KEY `FK_student_info_ref_countries` (`country_id`),
  KEY `FK_student_info_ref_cities` (`city_id`),
  KEY `FK_student_info_ref_province` (`province_id`),
  KEY `FK_student_info_ref_District` (`district_id`),
  KEY `FK_student_info_ref_gardian_type` (`guardian_type_id`),
  KEY `FK_student_info_ref_religion` (`religion_id`),
  KEY `branch id` (`fk_branch_id`),
  KEY `user_id` (`user_id`),
  KEY `fk_hostel_detail_id` (`is_hostel_avail`),
  KEY `fk_stop_id` (`fk_stop_id`),
  KEY `fk_fee_plan_type` (`fk_fee_plan_type`),
  CONSTRAINT `FK_student_info_ref_District` FOREIGN KEY (`district_id`) REFERENCES `ref_district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_cities` FOREIGN KEY (`city_id`) REFERENCES `ref_cities` (`city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_class` FOREIGN KEY (`class_id`) REFERENCES `ref_class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_countries` FOREIGN KEY (`country_id`) REFERENCES `ref_countries` (`country_id`),
  CONSTRAINT `FK_student_info_ref_gardian_type` FOREIGN KEY (`guardian_type_id`) REFERENCES `ref_gardian_type` (`gardian_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_group` FOREIGN KEY (`group_id`) REFERENCES `ref_group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_province` FOREIGN KEY (`province_id`) REFERENCES `ref_province` (`province_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_religion` FOREIGN KEY (`religion_id`) REFERENCES `ref_religion` (`religion_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_section` FOREIGN KEY (`section_id`) REFERENCES `ref_section` (`section_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_session` FOREIGN KEY (`session_id`) REFERENCES `ref_session` (`session_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_student_info_ref_shift` FOREIGN KEY (`shift_id`) REFERENCES `ref_shift` (`shift_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `student_info_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `student_info_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_info_ibfk_4` FOREIGN KEY (`fk_stop_id`) REFERENCES `stop` (`id`),
  CONSTRAINT `student_info_ibfk_5` FOREIGN KEY (`fk_fee_plan_type`) REFERENCES `fee_plan_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_info`
--

LOCK TABLES `student_info` WRITE;
/*!40000 ALTER TABLE `student_info` DISABLE KEYS */;
INSERT INTO `student_info` VALUES (1,29,1,'2016-12-19','23432443','34534255',1,NULL,1,6,6111,'2016-12-19',4,1,2,11,1,'61101-0909886-4','sasdasdasd','asdasdasd',12345,611,2,'',NULL,NULL,NULL,1,0,0,0,0),(2,30,1,'2015-02-12','3453453','3452345',0,NULL,1,2,2144,'2016-12-01',4,1,2,1,1,'34234-2342342-2','dtyhdths','srtyhrh',2345,214,2,'',NULL,NULL,NULL,1,0,0,0,0),(3,31,1,'2016-12-19','3453453','3452345',0,NULL,1,2,2113,'2016-12-19',4,3,2,2,8,'34564-5757845-3','dtyhdths','srtyhrh',2345,211,2,'',NULL,NULL,NULL,1,0,0,0,0),(5,33,1,'2016-12-19','2343453423','4234464576',1,NULL,1,1,1121,'2016-12-19',4,4,3,1,4,'56765-8789766-5','qawsdas','dasd',2343432,112,2,'',NULL,NULL,NULL,1,0,0,0,0),(6,39,1,'2016-12-19','234234234','',1,NULL,1,7,7143,'2016-12-19',4,2,2,2,5,'76453-2323456-7','','',565656,714,2,'',NULL,NULL,NULL,1,0,0,0,0),(7,40,1,'2001-11-14','2343453423','4234464576',1,NULL,1,4,4133,'2016-12-01',4,2,2,2,5,'36585-6456346-5','qawsdas','dasd',2343432,413,2,'',NULL,NULL,NULL,1,0,0,0,0),(8,41,1,'2016-12-16','2343453423','4234464576',1,NULL,1,2,2133,'2016-12-19',4,2,2,2,5,'45658-4657556-4','qawsdas','dasd',2343432,213,2,'',NULL,NULL,NULL,1,0,0,0,0),(9,51,1,'2016-12-21','96785','',1,NULL,1,1,1221,'2016-12-21',7,7,2,11,14,'','','',NULL,122,2,'',NULL,NULL,NULL,1,0,0,0,0),(10,53,1,'2016-12-22','876','',1,NULL,1,1,1221,'2016-12-22',7,7,2,11,14,'','','',NULL,122,2,'',NULL,NULL,NULL,1,0,0,0,0),(11,55,9,'2016-12-22','54353`','',1,NULL,1,1,1111,'2016-12-22',13,NULL,2,16,23,'','','',NULL,111,2,'',NULL,NULL,NULL,0,0,0,0,0),(12,57,9,'2016-12-23','44444','444',1,NULL,1,1,1211,'2016-12-23',12,7,4,11,16,'33333-3333333-3','tertert','',NULL,121,2,'',0,NULL,NULL,0,0,0,0,0),(13,58,9,'2016-12-23','555555','',1,NULL,1,1,1311,'2016-12-23',12,7,2,11,16,'','','',NULL,131,2,'',NULL,NULL,NULL,0,0,0,0,0),(14,61,9,'2016-12-26','123','',1,NULL,1,6,6111,'2016-12-26',12,NULL,2,17,24,'','','',NULL,611,2,'',NULL,NULL,NULL,0,0,0,0,0),(15,62,9,'2016-12-26','77777777','',1,NULL,1,1,1221,'2016-12-26',12,NULL,2,17,25,'','','',NULL,122,2,'',NULL,NULL,NULL,0,0,0,0,0),(16,63,9,'2016-12-26','777','',1,NULL,1,3,3520,'2016-12-26',12,NULL,2,17,26,'','','',NULL,352,2,'',NULL,NULL,NULL,0,0,0,0,0),(17,68,9,'2017-01-12','123','321',1,NULL,1,1,1311,'2017-01-05',12,NULL,4,15,15,'','','',NULL,131,2,'\0',1,NULL,NULL,0,0,0,0,0),(18,121,9,'2017-01-10','334234234',NULL,1,NULL,1,1,1111,NULL,12,7,5,11,16,'34233-4324234-3','asdfads','',23423423,111,2,'',0,NULL,NULL,0,1,1,111,1111),(19,123,9,'2017-01-10','234536',NULL,1,NULL,1,5,5142,NULL,12,7,4,11,16,'33454-6734434-6','sdfgdfgd','',NULL,514,2,'',1,2,NULL,1,1,5,514,5142),(20,125,9,'2017-01-11','werwer',NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,'23423-4234232-3','','',NULL,NULL,2,'',0,NULL,5,1,NULL,NULL,NULL,NULL),(21,126,9,'2017-01-11','23423423423',NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,'23423-4234234-_','','',NULL,NULL,2,'',0,NULL,5,1,NULL,NULL,NULL,NULL),(22,127,9,'2017-01-12','234234234',NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,'23234-2342342-3','','',NULL,NULL,2,'',0,NULL,7,1,NULL,NULL,NULL,NULL),(23,128,9,'2017-01-12','234324234',NULL,1,NULL,NULL,NULL,NULL,NULL,12,NULL,4,16,23,'23423-4232434-2','','',NULL,NULL,2,'',0,NULL,5,1,NULL,NULL,NULL,NULL),(24,129,9,'2017-01-12',NULL,NULL,1,NULL,1,1,1111,NULL,12,7,4,11,16,'32342-3434324-2','sdf','sdf',3423342,111,2,'',0,NULL,5,0,1,1,111,1111),(25,130,9,'2015-12-03',NULL,NULL,1,NULL,1,6,6111,NULL,12,7,4,11,16,NULL,'H76 S32','',999,611,2,'',1,4,5,1,1,6,611,6111),(26,131,9,'2017-01-03',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',1,2,7,1,1,4,411,4111),(27,132,9,'2017-01-02',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,2,8,1,NULL,NULL,NULL,NULL),(28,133,9,'2017-01-13',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',234,NULL,2,'',0,NULL,5,0,NULL,NULL,NULL,NULL),(29,134,9,'2017-01-13',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,2,5,0,NULL,NULL,NULL,NULL),(30,135,9,'2017-01-13',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',23424,NULL,2,'',0,2,5,0,NULL,NULL,NULL,NULL),(31,136,9,'2017-01-13',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',2342,NULL,2,'',0,2,5,0,NULL,NULL,NULL,NULL),(32,137,9,'2017-01-13',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',234234,NULL,2,'',0,2,5,0,NULL,NULL,NULL,NULL),(33,138,9,'2017-01-13',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',234,NULL,2,'',0,2,5,1,NULL,NULL,NULL,NULL),(34,139,9,'2017-01-13',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,'','','',NULL,NULL,2,'',0,2,5,1,NULL,NULL,NULL,NULL),(35,140,9,'2017-01-14',NULL,NULL,1,NULL,1,5,5154,NULL,12,7,4,11,16,NULL,'234234','',322342344,515,2,'',0,NULL,7,0,NULL,NULL,NULL,NULL),(36,147,9,'2017-01-20',NULL,NULL,1,NULL,1,1,1621,NULL,12,14,4,22,32,NULL,'SWABI','',NULL,162,2,'',0,12,8,0,1,1,162,1621),(37,148,9,'2017-01-20',NULL,NULL,1,NULL,1,1,8569,NULL,12,7,4,11,16,NULL,'','',NULL,121,2,'',0,NULL,6,0,NULL,1,NULL,NULL),(38,149,9,'2017-01-20',NULL,NULL,1,NULL,1,1,1111,NULL,12,7,4,11,16,NULL,'aaaaa','',NULL,111,2,'',0,2,5,0,1,1,111,1111),(39,150,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,14,4,22,32,NULL,'','',NULL,NULL,2,'',0,NULL,6,0,NULL,1,NULL,NULL),(40,151,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,NULL,9,0,NULL,NULL,NULL,NULL),(41,152,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,NULL,5,0,NULL,NULL,NULL,NULL),(42,153,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,NULL,6,0,NULL,NULL,NULL,NULL),(43,154,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,NULL,5,0,NULL,NULL,NULL,NULL),(44,155,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,NULL,5,0,NULL,NULL,NULL,NULL),(45,156,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,7,4,11,16,NULL,'','',NULL,NULL,2,'',0,NULL,5,0,NULL,NULL,NULL,NULL),(46,157,9,'2017-01-20',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12,14,4,22,32,NULL,'','',NULL,NULL,2,'',0,NULL,5,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `student_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_marks`
--

DROP TABLE IF EXISTS `student_marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marks_obtained` float NOT NULL,
  `fk_exam_id` int(11) NOT NULL,
  `fk_student_id` int(11) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_exam_id` (`fk_exam_id`),
  KEY `fk_student_id` (`fk_student_id`),
  CONSTRAINT `student_marks_ibfk_2` FOREIGN KEY (`fk_student_id`) REFERENCES `student_info` (`stu_id`),
  CONSTRAINT `student_marks_ibfk_3` FOREIGN KEY (`fk_exam_id`) REFERENCES `exam` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_marks`
--

LOCK TABLES `student_marks` WRITE;
/*!40000 ALTER TABLE `student_marks` DISABLE KEYS */;
INSERT INTO `student_marks` VALUES (37,23,4,12,''),(38,2,4,13,''),(39,44,5,12,''),(40,0,5,13,''),(41,43,6,12,''),(42,0,6,13,''),(43,34,7,12,''),(44,0,7,13,''),(45,54,8,12,''),(46,45,8,13,''),(47,32,9,12,''),(48,0,9,13,''),(49,54,10,12,''),(50,0,10,13,''),(51,23,11,12,''),(52,0,11,13,''),(53,45,12,12,''),(54,0,12,13,''),(55,80,68,16,'uuu');
/*!40000 ALTER TABLE `student_marks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_parents_info`
--

DROP TABLE IF EXISTS `student_parents_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_parents_info` (
  `stu_parent_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `cnic` char(15) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `contact_no` varchar(20) NOT NULL,
  `profession` varchar(20) NOT NULL,
  `contact_no2` varchar(20) DEFAULT NULL,
  `stu_id` int(11) NOT NULL,
  `gender_type` tinyint(1) DEFAULT NULL COMMENT ' 1= male, 0 = female',
  `guardian_name` varbinary(50) DEFAULT NULL,
  `relation` varchar(20) DEFAULT NULL,
  `guardian_cnic` char(15) DEFAULT NULL,
  `guardian_contact_no` tinyint(3) unsigned DEFAULT NULL,
  `organisation` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `office_no` varchar(20) DEFAULT NULL,
  `facebook_id` varchar(50) DEFAULT NULL,
  `twitter_id` varchar(50) DEFAULT NULL,
  `linkdin_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`stu_parent_id`),
  KEY `FK_student_parents_info_student_info` (`stu_id`),
  KEY `student_search_3_26122016` (`first_name`,`middle_name`,`last_name`,`cnic`,`contact_no`,`contact_no2`),
  CONSTRAINT `FK_student_parents_info_student_info` FOREIGN KEY (`stu_id`) REFERENCES `student_info` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_parents_info`
--

LOCK TABLES `student_parents_info` WRITE;
/*!40000 ALTER TABLE `student_parents_info` DISABLE KEYS */;
INSERT INTO `student_parents_info` VALUES (1,'Dad','','','61101-8768757-4','dad@gmail.com','45665465','GS','76465889',1,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'a','a','a','12343-4564578-8','dfdf@yh.com','45265474','GF','1234563758',2,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'a','a','a','45645-6456456-4','dfdf@yh.com','45265474','GF','1234563758',3,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'jjjj','','hhhh','22342-3423433-4','ddd@hh.com','86875768','GDR','879785889',5,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'P123','','','57665-3525558-9','','','','',6,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'jjjj','','hhhh','53453-6576856-6','ddd@hh.com','86875768','GDR','879785889',7,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'jjjj','','hhhh','76986-7868768-6','ddd@hh.com','86875768','GDR','879785889',8,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'xfgdfg','','','45645-4566645-6','','','','',9,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'ghgh','','','78567-8956896-7','','','','',10,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'test','','','22222-2222222-2','','','','',11,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'test','','te3','44444-4444444-4','','','','',12,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'test','','','11111-1111111-1','','','','',13,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'hhh','','','67676-7677777-0','','','','',14,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'hhjjkkk','','','00099-8889009-9','','','','',15,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'ggghhh','','','66566-5665666-6','','','','',16,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,'Fred','','Bond','','','','','',17,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'father name','adfd','adsf','32432-4234234-2','fa@gmail.com','324234234','2',NULL,18,NULL,NULL,NULL,NULL,NULL,'fasdf','asdf',NULL,'fb','t','l'),(19,'mother name','','adfasdsf','23423-4324324-3','mothersssdfsdss@gmail.com','234234','2',NULL,18,NULL,NULL,NULL,NULL,NULL,'adf','adfs',NULL,'fbm','tm','lm'),(20,'father','','asdfasdf','23423-4234342-3','','09','5',NULL,19,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(21,'mother','','asdfasdfasd','23123-1231231-2','','09','56',NULL,19,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(22,'Anderson','','Rodrigas','23423-4234234-2','','34234234','1',NULL,20,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(23,'Dena','','RODRIGAS','32342-4234234-3','','23423423','1',NULL,20,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(24,'asdf','','asdf','23423-4234234-2','','23423423','2',NULL,21,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(25,'asdf','','asdf','23423-4232342-3','','4234234243','1',NULL,21,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(26,'Anderson','','ROdrigas','23423-4234234-2','','23423','1',NULL,22,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(27,'Anne','','Rodrigas','23423-4234324-3','','23423','1',NULL,22,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(28,'fsdaf','','asdf','23423-4234234-2','','234234','1',NULL,23,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(29,'asdf','','asdf','23423-4234234-2','','23423','1',NULL,23,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(30,'asdf','adsf','adsf','23232-2312321-3','','234234','2',NULL,24,NULL,NULL,NULL,NULL,NULL,'asdf','adf',NULL,'','',''),(31,'asdf','adf','adf','12312-2321231-2','','23432','1',NULL,24,NULL,NULL,NULL,NULL,NULL,'adf','af',NULL,'','',''),(32,'dadi',NULL,NULL,'1','','09090909','4',NULL,25,NULL,NULL,NULL,NULL,NULL,'cc','bb',NULL,'','',''),(33,'momi',NULL,NULL,'1','','989008','56',NULL,25,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(34,'qew',NULL,NULL,'4','','23445','6',NULL,26,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(35,'rwe',NULL,NULL,'5','','453','4',NULL,26,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(36,'etuf',NULL,NULL,'7','','0000000','5',NULL,27,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(37,'fgdv',NULL,NULL,'6','','000000','6',NULL,27,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(38,'asdf',NULL,NULL,'1','','23423','4',NULL,28,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(39,'asdf',NULL,NULL,'1','','23424','4',NULL,28,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(40,'asdf',NULL,NULL,'1','','23423','1',NULL,29,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(41,'asdf',NULL,NULL,'1','','23423','2',NULL,29,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(42,'asdf',NULL,NULL,'1','','234','1',NULL,30,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(43,'asdf',NULL,NULL,'1','','234','1',NULL,30,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(44,'asdf',NULL,NULL,'2','','234','2',NULL,31,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(45,'asdf',NULL,NULL,'2','','234','2',NULL,31,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(46,'asdf',NULL,NULL,'2','','23423','2',NULL,32,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(47,'asdf',NULL,NULL,'2','','234234','1',NULL,32,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(48,'Muhammad Jan',NULL,NULL,'1','','234234','1',NULL,33,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(49,'MUHAMMAD JAN',NULL,NULL,'1','','23423','2',NULL,33,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(50,'Chan',NULL,NULL,'5','','0990','4',NULL,34,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(51,'Ler',NULL,NULL,'6','','9090','3',NULL,34,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(52,'qweqwe',NULL,NULL,'4','qweqwe@gmail.com','234234234','1',NULL,35,NULL,NULL,NULL,NULL,NULL,'qwe','qwe',NULL,'','',''),(53,'qweqwe',NULL,NULL,'5','sadqweqwe@gmail.com','234234','3',NULL,35,NULL,NULL,NULL,NULL,NULL,'qwe','qweq',NULL,'','',''),(54,'MUQEEM ALI ',NULL,NULL,'6','','03009080574','6',NULL,36,NULL,NULL,NULL,NULL,NULL,'PAF','AIR MAN',NULL,'','',''),(55,'',NULL,NULL,'2','','','',NULL,36,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(56,'ytrtyryt',NULL,NULL,'7','','67757','2',NULL,37,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(57,'',NULL,NULL,'7','','','',NULL,37,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(58,'wett',NULL,NULL,'7','','23423','6',NULL,38,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(59,'ertewee',NULL,NULL,'7','','123452','6',NULL,38,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(60,'aaaaa',NULL,NULL,'1','','123','1',NULL,39,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(61,'',NULL,NULL,'1','','','',NULL,39,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(62,'asdewq',NULL,NULL,'1','','1233445','5',NULL,40,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(63,'',NULL,NULL,'1','','','',NULL,40,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(64,'asdfasd',NULL,NULL,'1','','12342','6',NULL,41,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(65,'',NULL,NULL,'1','','','',NULL,41,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(66,'asdfds',NULL,NULL,'2','','2324','2',NULL,42,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(67,'',NULL,NULL,'2','','','',NULL,42,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(68,'adafd',NULL,NULL,'2','','234','1',NULL,43,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(69,'',NULL,NULL,'2','','','',NULL,43,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(70,'test',NULL,NULL,'2','','342342','1',NULL,44,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(71,'',NULL,NULL,'2','','','',NULL,44,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(72,'asdf',NULL,NULL,'2','','234324','1',NULL,45,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(73,'',NULL,NULL,'2','','','',NULL,45,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(74,'asdfa',NULL,NULL,'2','','23424','2',NULL,46,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','',''),(75,'',NULL,NULL,'2','','','',NULL,46,NULL,NULL,NULL,NULL,NULL,'','',NULL,'','','');
/*!40000 ALTER TABLE `student_parents_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_transport_fare_detail`
--

DROP TABLE IF EXISTS `student_transport_fare_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_transport_fare_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_stu_id` int(11) NOT NULL,
  `fk_transport_id` int(11) DEFAULT NULL,
  `payment_received` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_transport_fare_detail`
--

LOCK TABLES `student_transport_fare_detail` WRITE;
/*!40000 ALTER TABLE `student_transport_fare_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_transport_fare_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_allocation`
--

DROP TABLE IF EXISTS `subject_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_emp_id` int(11) NOT NULL,
  `fk_session_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `fk_group_id` int(11) DEFAULT NULL,
  `fk_section_id` int(11) DEFAULT NULL,
  `fk_subject_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_emp_id` (`fk_emp_id`),
  KEY `fk_session_id` (`fk_session_id`),
  KEY `fk_class_id` (`fk_class_id`),
  KEY `fk_group_id` (`fk_group_id`),
  KEY `fk_section_id` (`fk_section_id`),
  KEY `fk_subject_id` (`fk_subject_id`),
  CONSTRAINT `subject_allocation_ibfk_1` FOREIGN KEY (`fk_emp_id`) REFERENCES `employee_info` (`emp_id`),
  CONSTRAINT `subject_allocation_ibfk_2` FOREIGN KEY (`fk_session_id`) REFERENCES `ref_session` (`session_id`),
  CONSTRAINT `subject_allocation_ibfk_3` FOREIGN KEY (`fk_class_id`) REFERENCES `ref_class` (`class_id`),
  CONSTRAINT `subject_allocation_ibfk_4` FOREIGN KEY (`fk_group_id`) REFERENCES `ref_group` (`group_id`),
  CONSTRAINT `subject_allocation_ibfk_5` FOREIGN KEY (`fk_section_id`) REFERENCES `ref_section` (`section_id`),
  CONSTRAINT `subject_allocation_ibfk_6` FOREIGN KEY (`fk_subject_id`) REFERENCES `subjects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_allocation`
--

LOCK TABLES `subject_allocation` WRITE;
/*!40000 ALTER TABLE `subject_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject_allocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_division`
--

DROP TABLE IF EXISTS `subject_division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject_division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_subject_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subject_id` (`fk_subject_id`),
  CONSTRAINT `subject_division_ibfk_1` FOREIGN KEY (`fk_subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_division`
--

LOCK TABLES `subject_division` WRITE;
/*!40000 ALTER TABLE `subject_division` DISABLE KEYS */;
INSERT INTO `subject_division` VALUES (1,1,'Theory','active','2016-12-19 07:13:50'),(2,1,'Practical','active','2016-12-19 07:14:06'),(3,1,'Oral','active','2016-12-20 16:32:42'),(4,4,'Practical','active','2016-12-20 21:23:56'),(5,5,'theory','active','2016-12-20 21:24:05'),(6,8,'Oral','active','2016-12-21 11:50:36'),(7,8,'Verbal Communication','active','2016-12-21 11:50:50'),(8,8,'Demo','active','2016-12-21 11:51:04'),(9,9,'Theory','active','2016-12-22 05:04:02'),(10,9,'Practical','active','2016-12-22 05:04:07'),(11,11,'Practicaliy','active','2016-12-22 11:06:06'),(12,6,'Theory','active','2016-12-22 11:11:00'),(13,10,'Theory','active','2016-12-23 17:04:06'),(14,10,'Varbal','active','2016-12-23 17:04:26'),(15,10,'Oral','active','2016-12-23 17:04:41'),(16,16,'Theory','active','2017-01-05 15:32:49'),(17,17,'Practical','active','2017-01-09 12:19:20'),(18,13,'Theo','active','2017-01-09 12:19:40'),(19,24,'Theory','active','2017-01-19 13:27:21'),(20,24,'Practical','active','2017-01-19 13:27:30'),(21,25,'Theory','active','2017-01-19 13:28:04'),(22,25,'Practical','active','2017-01-19 13:28:12');
/*!40000 ALTER TABLE `subject_division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_class_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `is_division` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => false , 1=> true',
  `status` enum('active','inactive') NOT NULL,
  `created_date` datetime NOT NULL,
  `fk_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_id` (`fk_class_id`),
  KEY `branch` (`fk_branch_id`),
  KEY `fk_group_id` (`fk_group_id`),
  CONSTRAINT `fk_class_id` FOREIGN KEY (`fk_class_id`) REFERENCES `ref_class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`fk_group_id`) REFERENCES `ref_group` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,1,1,'Physics','P9S',1,'active','2016-12-19 05:53:34',NULL),(3,1,1,'Urdu','HUM124',0,'inactive','2016-12-19 07:20:22',NULL),(4,1,1,'English','HUM123',0,'active','2016-12-19 07:21:31',1),(5,1,1,'Islamiat','HUM123',0,'active','2016-12-19 07:22:02',1),(6,9,11,'Physics','Phy-09',1,'active','2016-12-20 21:23:19',7),(7,9,11,'Chemistry','chem-01',1,'active','2016-12-20 21:23:42',7),(8,9,11,'Urdu','urdu',1,'active','2016-12-21 11:50:18',NULL),(9,9,16,'Biology','B1',1,'active','2016-12-22 05:03:47',NULL),(10,9,11,'Mathematics','Mats',1,'active','2016-12-23 17:03:45',NULL),(11,9,17,'English','66yyy',0,'active','2016-12-26 09:34:57',NULL),(12,9,17,'Matematics','mth54',0,'active','2016-12-26 09:35:13',NULL),(13,9,11,'Biology','Bio',1,'active','2017-01-09 12:17:40',7),(14,9,20,'English','eng',0,'active','2017-01-10 09:25:22',11),(15,9,20,'Urdu','UR',0,'active','2017-01-10 09:25:41',11),(16,9,20,'Islamiat','ISL',0,'active','2017-01-10 09:26:01',11),(17,9,20,'Biology','Bio',0,'active','2017-01-10 09:26:17',11),(18,9,20,'Physics','Phy',0,'active','2017-01-10 09:26:31',11),(19,9,20,'Chemistry','Che',0,'active','2017-01-10 09:26:49',11),(20,9,21,'English','eng',0,'active','2017-01-19 13:24:25',12),(21,9,21,'Urdu','uru',0,'active','2017-01-19 13:24:47',12),(22,9,21,'Pak Study','ps',0,'active','2017-01-19 13:25:11',12),(23,9,21,'Physics','phy',0,'active','2017-01-19 13:25:24',12),(24,9,21,'Biology','Bio',1,'active','2017-01-19 13:25:45',12),(25,9,21,'Chemistry','Ch',1,'active','2017-01-19 13:26:01',12),(26,9,21,'Maths','Math',0,'active','2017-01-19 13:26:33',13);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysdiagrams`
--

DROP TABLE IF EXISTS `sysdiagrams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sysdiagrams` (
  `name` varchar(160) NOT NULL,
  `principal_id` int(11) NOT NULL,
  `diagram_id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) DEFAULT NULL,
  `definition` longblob,
  PRIMARY KEY (`diagram_id`),
  UNIQUE KEY `UK_principal_name` (`principal_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sysdiagrams`
--

LOCK TABLES `sysdiagrams` WRITE;
/*!40000 ALTER TABLE `sysdiagrams` DISABLE KEYS */;
/*!40000 ALTER TABLE `sysdiagrams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transport_main`
--

DROP TABLE IF EXISTS `transport_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `fk_route_id` int(11) NOT NULL,
  `fk_driver_id` int(11) NOT NULL,
  `fk_vechicle_info_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_route_id` (`fk_route_id`),
  KEY `fk_driver_id` (`fk_driver_id`),
  KEY `fk_vechicle_info_id` (`fk_vechicle_info_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `transport_main_ibfk_1` FOREIGN KEY (`fk_route_id`) REFERENCES `route` (`id`),
  CONSTRAINT `transport_main_ibfk_2` FOREIGN KEY (`fk_driver_id`) REFERENCES `employee_info` (`emp_id`),
  CONSTRAINT `transport_main_ibfk_3` FOREIGN KEY (`fk_vechicle_info_id`) REFERENCES `vehicle_info` (`id`),
  CONSTRAINT `transport_main_ibfk_4` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_main`
--

LOCK TABLES `transport_main` WRITE;
/*!40000 ALTER TABLE `transport_main` DISABLE KEYS */;
INSERT INTO `transport_main` VALUES (1,9,3,55,3),(2,9,8,54,4);
/*!40000 ALTER TABLE `transport_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `first_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `fk_role_id` int(11) NOT NULL,
  `last_ip_address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `name_in_urdu` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role_id` (`fk_role_id`),
  KEY `branch id` (`fk_branch_id`),
  KEY `student_search_126122016` (`id`,`username`,`first_name`,`middle_name`,`last_name`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`fk_role_id`) REFERENCES `user_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (16,9,'branch',NULL,'admin','test-branch','ali@gmail.com','WcLWvFKYUJzKTBmvmBnBbOaEANuiawUY','$2y$13$6iElTRICi5cbTh.rhKHMe.q6vErX/f6XNBira.VdSmm9vrnVuz8B2',NULL,'','active',1,'',NULL,'2016-12-12 05:36:56','2016-12-21 00:00:00',NULL,NULL),(20,1,'noor','','khan','121','ssfssdfsf@sfsdf.com','x6TL5gOGubqYdJTPLVQ3oC_vukS9Sx1n','$2y$13$l6tx9DU/tPGuVCYP.I3E7.8m2TJ/xAFIRgb0wVG/RydBZe1KE30Pq',NULL,NULL,'active',4,NULL,NULL,'2016-12-15 13:37:36',NULL,NULL,NULL),(21,1,'Ahsan','Khan','Niazi','1234','akn133@gmail.com','NSKxExAz1rAAPnKxJ_VVeCJzQ04oXcep','$2y$13$Jl8yFmup3QyhZzgg5nvZBOuegEcomglwIW/ys8AUTgAmI1ustGZgq',NULL,NULL,'active',4,NULL,NULL,'2016-12-15 13:42:30',NULL,NULL,NULL),(22,1,'ŸÜŸàÿ±','','khan','erter22','sdfsdf@fsdfsdf.com','CbO3cZUqIvWbHQ_GE9FjKm_dILprbsk3','$2y$13$s7Br1xxHHJQpvLuyoP6mLuuhNrigUDADx9PM5/6JsTN2MXieQIK06',NULL,NULL,'active',4,NULL,NULL,'2016-12-15 13:46:25','2016-12-20 14:37:19',NULL,NULL),(23,1,'ÿßÿ≠ÿ≥ŸÜ','Khan','ÿÆÿßŸÜ ','50','ajk@jlk.com','YtGEWH61AVIL2yvwABu7eC_Bcx2g3TMn','$2y$13$l9sGz4qagGZtKyGLBNvoleaKf1VOZ1J6/5pbjEtlszlpEN/wOU2Si',NULL,NULL,'active',4,NULL,NULL,'2016-12-15 13:52:17','2016-12-20 14:39:18',NULL,NULL),(24,1,'Noor','Muhammad','Khan','345','test@test.com','ZtbiMeu7zg83Ea-ZoAp5NoYHDdLs3e-K','$2y$13$FexaQqIE7f/76mKjk0ALCuQ66m081pyjeBOYPxHUQETILDnhSDAV6',NULL,NULL,'active',4,NULL,NULL,'2016-12-16 05:36:02',NULL,NULL,NULL),(25,1,'Ahsan','Khan','Niazi','111','akn13@gmail.com','h0A_-zzt6-k2jn_LCbQ2hwppPS_IlkoO','$2y$13$MX/IzqURcLUx40qx1GNOeeia7eIhhlMG3KZlGEt6IKo59NePANYpS',NULL,NULL,'active',4,NULL,NULL,'2016-12-16 05:42:26',NULL,NULL,NULL),(26,1,'Ali','','Abdullah','222','ali1234@gmail.com','AXZsK0_GeBmqNP3ai3kDpajdM6OipQpw','$2y$13$Xj63t8SyBl5HrQstTQp5s.0JMT9/834ZGWSPrQ1Jej.ZZ0irMtDrm',NULL,NULL,'active',4,NULL,NULL,'2016-12-16 06:31:26',NULL,NULL,NULL),(27,1,'Salma','','Khan','333','salman@gmail.com','aS_CowzCTojmuMzTl6FeYiu7llgsc4nT','$2y$13$s1o1Ulz05anix3y07m8vcOC0Qf0Ym9xnVx.Gg2cNAnt4BJ4wpVE7W',NULL,NULL,'active',4,NULL,NULL,'2016-12-16 06:48:33',NULL,NULL,NULL),(28,1,'Salman','','Khan','444','salmank@gmail.com','Nd_E1tM0_hBMQOg69Fm-5dj7CrurCrzU','$2y$13$bh8ROcibOI4jlF2mQz/umegxRb6mTJ.Cr1/cxSmy47yiQmelyxtum',NULL,NULL,'active',4,NULL,NULL,'2016-12-16 07:07:29',NULL,NULL,NULL),(29,1,'Ahsan','Khan','Niazi','S1','asdf@gmail.com','SfVhFkyf6ESQntpIvB-LiEslsulPfaDL','$2y$13$Bndk5uLU6H2yPLdqgXdDX.R4oCBP06lt1Th7V5xgEGfgJP2ho30QW',NULL,NULL,'active',3,NULL,NULL,'2016-12-16 10:12:43','2016-12-19 11:04:50',NULL,NULL),(30,1,'Ali','Abdullah','Abdullah','S2','asd@yh.com','CKXzpk-nx0ATyACvpDojyDnMI2SUoopG','$2y$13$87N.K67CCTdYaw2MK7ulJu5TUt3AuqJolmxFbsiqe6G1njSv3S07m',NULL,NULL,'active',3,NULL,NULL,'2016-12-16 11:18:06',NULL,NULL,NULL),(31,1,'Ali','','Abdullah','S3','asd@ygh.com','5jyNqrAaqmNXA5921PnKGitYoM8jLp3s','$2y$13$/yrzEZhqDsD98DAZhWEKJOrKJvH82oGoUt.KOJgsiRn3bxqRYCGay',NULL,NULL,'active',3,NULL,NULL,'2016-12-16 11:30:51','2016-12-19 11:05:53',NULL,NULL),(33,1,'Jamal','','Khan','S5','jamal@gmail.com','kMnqwwKHcplFTOLk5-qHPv5M6bAbQpJA','$2y$13$Qu/38Uw65j5bREU5/RRsSO9UKP5NNpDlfLV9GPIc7yGCndZka2mlu',NULL,NULL,'active',3,NULL,NULL,'2016-12-16 13:04:53','2016-12-19 11:06:45',NULL,NULL),(34,9,'branch',NULL,'manager','branch-manager','ali@gmail.com','WcLWvFKYUJzKTBmvmBnBbOaEANuiawUY','$2y$13$6iElTRICi5cbTh.rhKHMe.q6vErX/f6XNBira.VdSmm9vrnVuz8B2',NULL,'','active',2,'',NULL,'2016-12-12 05:36:56','2016-12-19 00:00:00',NULL,NULL),(35,10,'branch',NULL,'admin','Testing-Branch','abc@xyz.com','WiEmPv5C2EZ3XcGeNi_Pk_dNun_AVxkf','$2y$13$gRYu9Jl0CEqz5fleNrXB2OVH.o2ZciQIFM01DnFW0wRpCNSKBYKMa',NULL,NULL,'active',1,NULL,NULL,'2016-12-19 06:08:42',NULL,NULL,NULL),(36,1,'test','','test last name','test_user3234453','assssdmin@gmail.com','sCz7EE0jsdRc2byghl956xCZjEPYK5q6','$2y$13$X0daojJwF9Yv.XOY.XpeqehVid/gPyzDJ6Y5/xScoxyygRKL66VT2',NULL,NULL,'active',4,NULL,NULL,'2016-12-19 07:40:27',NULL,NULL,NULL),(37,1,'test','','test last name','test_userwerew234','admisdfsdfs32343n@gmail.com','iO3Vhn9R0Xem9ff95HgjgwXphMzUOygh','$2y$13$NmzCNCyIRG2FVvdzoWJMeOUQ5a4gMzxyi4K3t93TrOseqfafe3fCy',NULL,NULL,'active',4,NULL,NULL,'2016-12-19 07:45:19',NULL,NULL,NULL),(38,1,'E122','','344','E1','E1@fm.com','mGCgC0DbFY_naEKZ1LAuvxc1zDhuJgFn','$2y$13$1rEBiZm7QF9pTYjkEF4PzuxkonirzcF1lUqkMUPXR4.AOyimt3cma',NULL,NULL,'active',4,NULL,NULL,'2016-12-19 07:56:38',NULL,NULL,NULL),(39,1,'S6','','78','S6','S6@sm.com','Vl-d1G8Q6a3EnefA2XXXTTbvE3o71qwo','$2y$13$YFGCtB2ee7tPYyADzbQmqOHKDhZMkTBRoIOHyj32yDTMp7pupATCG',NULL,NULL,'active',3,NULL,NULL,'2016-12-19 07:59:18','2016-12-19 11:08:22',NULL,NULL),(40,1,'Jamali','','Khan','S7','man@gmail.com','8Hjiba6vnaMjc4eFli5uxB2bG9Jfw9Yn','$2y$13$.P9kTkAHmZCeJKJXr53VGOqqDZnv.XhO6yZcKzwd905mH8C9h60q2',NULL,NULL,'active',3,NULL,NULL,'2016-12-19 11:21:14',NULL,NULL,NULL),(41,1,'ŸÖŸÖÿ™ÿßÿ≤ ','','ŸÖŸÖÿ™ÿßÿ≤ ','S8','ma444n@gmail.com','0wVzPRvp1dUhHU-2-yP97P1fDM8ZjsRI','$2y$13$X.7G9BPgIMWlBCa3wrfTWuWAndEELImzrSqYSVYqtv8yx6gMBGy/S',NULL,NULL,'active',3,NULL,NULL,'2016-12-19 12:54:36',NULL,NULL,NULL),(42,1,'ahmad','','khan','24','ahmadk@hhg.vom','6xdsfJjo2DIMel_UCCtr0gbcSDxvLW43','$2y$13$LWcP10jRcu7R9axXj/bpjuZEyYeCVDii2kT8dMw/wmvkHaELeds8O',NULL,NULL,'active',4,NULL,NULL,'2016-12-20 13:49:23',NULL,NULL,NULL),(43,1,'ahmad','','khan','244343','ahmadk@hhg.vombb','RQngKqIsSxM8ktfvbVXRg1SldX5mELOJ','$2y$13$A8SoJ45QoMrM6gV3GsWl4..tdt8uhddWfMvksSmJnlx9P3VSohQrG',NULL,NULL,'active',4,NULL,NULL,'2016-12-20 13:49:59',NULL,NULL,NULL),(44,1,'Arslan','Khan','Niazi','889900','akn@yahoo.com','-wyr_K8JCPr8HasvR5iD7mh_yGn_mRos','$2y$13$WkfBfmunkTgta9WloX7fIOCAYPy3CH47lSZK0asNSHMStImmOS6.O',NULL,NULL,'active',4,NULL,NULL,'2016-12-20 14:16:50',NULL,NULL,NULL),(45,1,'Arslan','Khan','Niazi','889901','aknakn@yahoo.com','GQAHqTz01m3E_C3WqiBraqF0HYZq8p-l','$2y$13$2SwY2FEfbPr3eJ8morcqrePKAbZF6IwRPqKGd9n41D2fxLcnabNnO',NULL,NULL,'active',4,NULL,NULL,'2016-12-20 15:14:03',NULL,NULL,NULL),(46,1,'john','','doe','2016-10-76','john@gmail.com','QOpGq0th88owr7LrqlC5aX34p5bIBx5p','$2y$13$P5FM59thjOAOIswk/OkZuuRyN8Oz3soAAIeBCtRtSwrEh0AafWPai',NULL,NULL,'active',4,NULL,NULL,'2016-12-20 19:56:26',NULL,NULL,'Jellyfish.jpg'),(47,1,'sdf','','sdtghfd','xft44','xcgxf@GDF.COM','wRB2UnDcJxXOGkmpLDgArNp8euLlvWmu','$2y$13$LHJlTPsEqCIaltIyfVnFf.jgiRnuTxGy5gHdc6uA.QYSGxxsayz2i',NULL,NULL,'active',4,NULL,NULL,'2016-12-21 11:47:58','2016-12-21 11:52:02','','Penguins.jpg'),(48,1,'hammad','Khan','Niazi','88556','hammad@yahoo.com','CrBYTvNR2Fs4TEINRH5thx0xf2wjwENQ','$2y$13$G5KUcg6Sz.nVxUClMldl0O6pcy9rPP.OVXW467363gYzTwD2eI1c2',NULL,NULL,'active',4,NULL,NULL,'2016-12-21 12:27:15','2016-12-21 12:39:46','','Chrysanthemum.jpg'),(49,1,'Hamza','','Khan','88557','hamza@yahoo.com','EQibd5O9E1DTPR5AeWJYQOYxPJ_wwhd-','$2y$13$bgu2cUuz0VqDNdRQ6rDs7eFUqfskBuGJfGzPuE3TR6Aiqu2r6VoZ6',NULL,NULL,'active',4,NULL,NULL,'2016-12-21 12:46:37',NULL,'','585a71fcfb28147525ea438c.jpg'),(50,1,'asdfdf','s','sdf','345ert345','sdf@sdfs.cokm','m1-GlqcEpxMW2dv93LOMfERjv_9NsPz5','$2y$13$ii3zlI3GvhOW3mDHwtUiguK0zi/dMM5b5408L3fI.Xrs4MDzeNWKm',NULL,NULL,'active',4,NULL,NULL,'2016-12-21 12:54:58',NULL,'','Desert.jpg'),(51,1,'asad','','asdas','S9','asd@hg.dfg','3vgG2prC7f_PG5LF8at6PgFJu_BPYSnR','$2y$13$9HGM00LRvLWKgWV2X2X47eNDkuQStTrlaF7aYGDwZryonnW2frmu2',NULL,NULL,'active',3,NULL,NULL,'2016-12-21 13:05:17','2016-12-21 13:14:17','','Tulips.jpg'),(52,1,'Hamza1','','Khan','88558','hamza1@yahoo.com','k776Xm6uDO7AIvHdACVhuiEzs7IHucXM','$2y$13$dIwEHfcadwZUsR2.gQ0pweGPq00zLkSBFcRm3LqBXMJ5jVYEzXviS',NULL,NULL,'active',4,NULL,NULL,'2016-12-21 13:28:49',NULL,'','585a71fcfb28147525ea438c.jpg'),(53,1,'Agdd','','asfg','S10','','hd7PlgcPcPYXp6YJ4IpspRL-0PMUPhO8','$2y$13$FRT1z0ZjY.07VGdav4HXduMD.zs.DK3ymkkomez6jFb6ByoBGgyoO',NULL,NULL,'active',3,NULL,NULL,'2016-12-22 07:07:53',NULL,'','Jellyfish.jpg'),(54,9,'test','','test','test1-1','test@gmail.com','rCpE20Tl-lBT4PnAOnq_OUTBkOy9HK9C','$2y$13$79Gs3GFC56uPnKVv0ZUlQOGWGO0VgALr7mOwemrWD9hAlGPnaxml.',NULL,NULL,'active',4,NULL,NULL,'2016-12-22 11:24:49',NULL,'ÿßÿ±ÿØŸà','apple-logo.png'),(55,9,'testa','','terteq','test332','','w2LVL_D2z0Bddh3wIXNBAi5PBWIzeT1b','$2y$13$x2s61TQ76f8n7EhmPoKC9.uPpqGLuewH0DoO68KpJaRb/xWMwJpcC',NULL,NULL,'active',3,NULL,NULL,'2016-12-22 11:42:38',NULL,'','download.jpg'),(56,9,'Hamzakh','','Khan','SOSAAD','hamzakhan@yahoo.com','qy1c36OhNpw43JtLbi6KE8UTHlKk5xlS','$2y$13$AgITWgY5w0ZPdeAxV9GsW.iZaj67cUrIEqhYeKp18nA9JZCm1TJ7.',NULL,NULL,'active',4,NULL,NULL,'2016-12-23 10:49:51',NULL,'','585a71fcfb28147525ea438c.jpg'),(57,9,'noor','','Muhammad','test1','','N7Mr78tIdFs0C2usHeBjZnHF-hJh6FhR','$2y$13$/N1TzFEbHZysL5iA1t8Ay.RmSck5xRkCqxsAg282Zt7Mlh7noJ20S',NULL,NULL,'active',3,NULL,NULL,'2016-12-23 16:56:44','2017-01-05 17:33:29','','Tulips.jpg'),(58,9,'Asad','','','asad','','cq3Sn6CZq8RAEhrPVkOjKQg_cpIU7e3x','$2y$13$7pdp9AdMAheNiXfPaGnsXe/nEH8BEiO3ficHdkM9gpagn087C6J8i',NULL,NULL,'active',3,NULL,NULL,'2016-12-23 17:00:48',NULL,'','Tulips.jpg'),(59,9,'Hamzakh','','Khan','EMP 1','hamzakhan12345@yahoo.com','PXFeWa_qPhAfG-bl-zNTV_qU16lQ1zba','$2y$13$oecjBPZGvmI9NoLxoYX1O.bioJPnkkWmZFr05AvHHbVsPjperBwlG',NULL,NULL,'active',4,NULL,NULL,'2016-12-26 12:09:25','2016-12-26 12:29:31','','585a71fcfb28147525ea438c.jpg'),(60,9,'Hamza','Ali','Abbasi','EMP 2','hamzaabbasi@yahoo.com','YWCFKmjXj0ahtpCgkKRTrTIUB1s3nBnV','$2y$13$/EHIl0g9pO7VcfENZHma1enNNmmgo0NEiLFVELakbmyp3on8ArU5i',NULL,NULL,'active',4,NULL,NULL,'2016-12-26 12:36:59',NULL,'','585a71fcfb28147525ea438c.jpg'),(61,9,'qqq','wwwe','eee','STD1','','qO_YrEV8lZLopASU8oQFrMdOHlLhcJJT','$2y$13$ppl2hddLyaK.Fi0wKq/Ev.iO5tdy6CaNE.aPagsuoqVAlO3Mbql3.',NULL,NULL,'active',3,NULL,NULL,'2016-12-26 12:50:51',NULL,'','Penguins.jpg'),(62,9,'yyyuuu','','uuuu','STD 2','','FR1aMBc9UaMuv2Q4gWRoxr4sfYllWYDR','$2y$13$6WfCuyH4iRoWg0aDKolR2uVCEhWvlR1BEE5shTLK30Zp8/6kHy80u',NULL,NULL,'active',3,NULL,NULL,'2016-12-26 12:52:24',NULL,'','Desert.jpg'),(63,9,'tttt','yy','yuyt','STD 3','','4H9RmTjzl_sFxk1iwFMa5pSURew-5x-7','$2y$13$kxAdVZzunQW8dhXVrGh9HOwOE8jD1F0xDEMi6gkvdHnHaJFe/io4y',NULL,NULL,'active',3,NULL,NULL,'2016-12-26 12:53:35',NULL,'','Koala.jpg'),(64,9,'ALI','ABDULLAH','KHAN ','EMP 3','Aliabdkhan@yahoo.com','EJ9yKHr8xXcIYnJ3w9MWWmP_TLIV7dKb','$2y$13$ZccpgeIE3GzQfkcKu6arvu6HobRA0rDOcrnejvIHwk7sPfLwi0FjK',NULL,NULL,'active',4,NULL,NULL,'2016-12-28 16:17:00',NULL,'','585a71fcfb28147525ea438c.jpg'),(65,9,'ALI','ABDULLAH','KHAN ','EMP 4','aliabdkhani@yahoo.com','VF5XM6xy2V_6NOygWaRScG-ykP5lmmIL','$2y$13$Pyo2bxxDGh2zpCbO0E1lAOlMOjyvD5MmrvYHlgDZmFH0Xgi0trpY.',NULL,NULL,'active',4,NULL,NULL,'2016-12-28 16:43:26',NULL,'','585a71fcfb28147525ea438c.jpg'),(66,9,'wrwrwr','','werwr','34345','wrwr@ertert.com','qfmEsbr9Qgk_fGYMIBKxebnHwv9ekwSM','$2y$13$x1D6Yp5AdLJFue15JLF2Ge.XZlT2F1mEaMTarNOQX7n9KVZ4Tfeai',NULL,NULL,'active',4,NULL,NULL,'2016-12-31 16:49:24',NULL,'rwewrew',NULL),(67,9,'454yygh','','','3434','','7zQ8ZZH4GXUUp5-3ienoS683FNErJcm4','$2y$13$8a10pxDytg9rwhAnckQX8e6sACTvxJ8SKNV4jczjTXD27MPfzbyBu',NULL,NULL,'active',4,NULL,NULL,'2017-01-02 17:45:59',NULL,'',NULL),(68,9,'James','','bond','std007','','k_A9uki7BE10XU3SHh3BOeJWVQZJm5NQ','$2y$13$XNnZOmRcHWRBgQG2DBsYw.jDQTP5y0ZJzDNmfNBBufFtbIdr08gvC',NULL,NULL,'active',3,NULL,NULL,'2017-01-05 09:33:10',NULL,'ÿ¨€åŸÖÿ≤ ÿ®ÿßŸÜ⁄à ','Penguins.jpg'),(69,9,'JAMES','','BOND','EMP 5','jamesbond@yahoo.com','Pw9MT2G4yWdicyZUYPW135OIodGLoCVq','$2y$13$RIbBOsuCcWC/6DCZTM4p2eEqSr3G4oD0odXRrohARmNSiwNmpUHVW',NULL,NULL,'active',4,NULL,NULL,'2017-01-05 11:31:28',NULL,'','585a71fcfb28147525ea438c.jpg'),(70,9,'4234','test','test','test123','test@teddst.com','JZGu8tUKJ-um2sml3DV8eCA0_hwnTocM','$2y$13$UrbpO.qp3ZOtC8FSzv9Aeuw6JFJyW0ondKdBsYhH0n/zKsb.gEfUW',NULL,NULL,'active',3,NULL,NULL,'2017-01-06 11:45:56',NULL,'',''),(71,9,'James Biond','','','stdjames','','Fn_z6KIKq3t1xmPqiGMfqZGud_Aa4Vxf','$2y$13$TCJ..2WIsDcAIKP21/qfJ.5pdZjaSjshTVBbTovBjLps/ZM39urzC',NULL,NULL,'active',3,NULL,NULL,'2017-01-06 12:20:08',NULL,'',''),(75,17,'branch',NULL,'admin','educators','educators@test.com','_liIe4rsUgtT8S5fY70PmoHL8kOm8syL','$2y$13$agBANHkmDfSrpmbALm1SGeEmV86uuhJD1OCHiiKeRK3xVZE2mMb0m',NULL,NULL,'active',1,NULL,NULL,'2017-01-09 12:17:30',NULL,NULL,NULL),(76,9,'MOHSIN','','TANOLI','003','great-tanoli@hotmail.com','pcVvj0_m7wrNB6Lxy5_aSWFtoTP2yDFn','$2y$13$3PX7PA5PpxMRTTxmXBKSZ.DRqN2TbwWWGlvj65CCe2oHqXuXvbCuO',NULL,NULL,'active',4,NULL,NULL,'2017-01-09 14:02:23',NULL,'',NULL),(77,17,'asd','','','test_user','sasssssdf@gmail.com','WIxF7C8zIP7t-T2oJioBoFkIqwkntf93','$2y$13$6Zrv3tcwlk8SaPor5exjZ.8RziI3lCwte334AmfdeOVyN20NBQTEu',NULL,NULL,'active',4,NULL,NULL,'2017-01-09 14:07:42',NULL,'',NULL),(78,17,'test','','','test_user_987','','8drg9dkrxdPwTxNPAFod_reAjC8o4KrG','$2y$13$0v9UY8zChodOl8bEVHIS7OZrGOadrNBWgkNc2k/63QEoGiXxqF6sS',NULL,NULL,'active',4,NULL,NULL,'2017-01-09 14:12:31',NULL,'',NULL),(79,17,'hello','this ','test','test124','tesdst@test.com','2l9pc_R_0gb7n8HKcTNEqasBl20XCbwL','$2y$13$XF9kHRom4Es4PYZ7zaPZr.jFwnQhFVOP35QIvYgrGzrIhPl2o3IFW',NULL,NULL,'active',4,NULL,NULL,'2017-01-09 16:33:05',NULL,'',NULL),(80,17,'hello','this ','test','tedfdfdfst124','tesdsfsdsdst@test.com','_rQCr93b4-p_akVa0m6f1W1s-zRMMXjV','$2y$13$Rf7SO6mfzA1Og/MciaMnEuUEmj7bF5WBwI1lmFdmFHiCYlhXJe4Ji',NULL,NULL,'active',4,NULL,NULL,'2017-01-09 16:35:19',NULL,'',NULL),(81,9,'ahsan','khan','niazi','STD11','aknaknnka@gmail.com','OSjezPsKT5LBARWobL7WfwQwTJgIh1IF','$2y$13$RzN7hjRaadgj1tHOx6gxHu2C1Sq5jX8wle9CB/SlpUkeya423RGVe',NULL,NULL,'active',3,NULL,NULL,'2017-01-09 17:47:22',NULL,'ÿßÿ≠ÿ≥ŸÜ ','caricature-jimmy-fallon-tonight-show-cartoon-painting-drawing-american-television-nbc1.jpg'),(82,9,'ahsan','khan','niazi','STD12','aknaknnka2@gmail.com','L2DxgaU4H-xra9LEXdMjTJDHR4SIwNv-','$2y$13$vw7PjpWlV2L2jdtqcnlQfOawzP.5ZK26TvPfygbXqkjwL1yO1RIGG',NULL,NULL,'active',3,NULL,NULL,'2017-01-09 18:37:17',NULL,'ÿßÿ≠ÿ≥ŸÜ ','caricature-jimmy-fallon-tonight-show-cartoon-painting-drawing-american-television-nbc1.jpg'),(83,17,'SHAFAQ','','NAVEED','001','','H1I4szkZyU3XYN0RbM0lrwdurcqVovWC','$2y$13$cbiv367TZ7333My8LIhN2ulSX9twQNkkv2CziiCJR8qZvGxwFOR9G',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:24:51',NULL,'',NULL),(84,17,'GHIYAS AHMED MALIK','','','002','','lgGACcSm6P1NVXOuRdrGxnzj7hQ2-Lss','$2y$13$GcblpmR6hnTFt8wsQ1t86OMTrrceqH.TetOFluAw6fI6jitgQHcme',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:27:30',NULL,'',NULL),(85,17,'','','','SULTAN MUHAMMAD ','','-7VZDnw_pvCsWchaXFhiRKZR3oJRCJxj','$2y$13$aXghCe4Kp9GM/1M3JyKK0ux/NIcdqm7hFLZJtAJUhSLjQd8OhCSkW',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:29:31',NULL,'',NULL),(86,17,'ATIYA TABASSUM','','','004','','gua9aZxpkQ81DgPe8Ivu_-BD5WTvuqpq','$2y$13$c/hZTzMy7sWA5r/WUz3FBuPo2pNpunyeLs2P.f.nh/9ClFljWGd.G',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:31:39',NULL,'',NULL),(87,9,'Muhammad','karim','khan','102','','AdEHnetbzOW_FkkE6CwM6fVq1Pd0Sles','$2y$13$7asqs.JROsw66BQI83e5Mu0KlNE7fqGKdtI35kD/Sj9qqBUP7QM9W',NULL,NULL,'active',3,NULL,NULL,'2017-01-10 09:32:52',NULL,'ŸÖÿ≠ŸÖÿØ ⁄©ÿ±€åŸÖ ÿÆÿßŸÜ','15318005_201901683549903_2138202879314270523_n.jpg'),(88,17,'SULTAN MUHAMMAD','','','006','','bfU5E0Iy1trWqxsarP--pcaTcDJclFT5','$2y$13$bNt13JEkxHxEnZtA3K5SN.bZ59KeCLAYEtRcMUjK5tfyngutibP2O',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:35:19',NULL,'',NULL),(89,17,'MOHSIN TANOLI','','','005','','VuGIQZnGFxT6r0S6K7HNNszBbXxZbIQ8','$2y$13$jR8W.LEA25ByYnQSTOV7BOoLg7kEPUp2UUcc5Q0Yf5tkdtel.EiDe',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:36:33',NULL,'',NULL),(90,17,'ROBINA NAZIR','','','007','','jLo6VLiU-d4j613qYQCyd3iRHb6AeQ_w','$2y$13$5bcHrL4k2nmIThMhhptXyu7YEMgn3c9STCcoYuihQB2rIgcOMphK.',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:38:16',NULL,'',NULL),(91,17,'MEHREEN','','','008','','Jha4g3QpCHSYb2mpapvdeb1ZI0NJbHa3','$2y$13$EtLHuMoYOydwg4B6qJrY2O/bvDPRqQB6pPDEs60io6BHM27rfprxy',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:39:45',NULL,'',NULL),(92,17,'NAZIA','','','009','','_1R5f6AUfEkkTeltW-0DhjOUKD3T6wzp','$2y$13$z.FYbh0yAr2ZwaSrN.y55O2mr15FfpFMp5ZZ6yd7bKatSc6CTUyDS',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:41:12',NULL,'',NULL),(93,17,'BUSHRA NAZ','','','010','','sMBvpTRNcul-_JiWNNrNMxDr7abPLU7Z','$2y$13$vnBHndXNkcoAoF/IxzbpX.cQMTx7ea1NtL2nB9xaKkXk9UuzQExYu',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:42:15',NULL,'',NULL),(94,17,'SAIMA BIBI','','','011','','e5pz8qEzflHCGC7yeuiNxkpIHJOMKtXl','$2y$13$yPQqacunl5gRayGJKV52WeMBBrfBojUbRm.KyuIrGKOeLGeQpJaq.',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:43:20',NULL,'',NULL),(95,17,'ASMA RUBAB','','','012','','vKDYcolPi4tBHzB3YLoqA3013rBT_AX5','$2y$13$opTrfnX4FSDdWhYeJHykgecUQb0jW7MYP68JkU8/zZcp00HenALQO',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 09:44:28',NULL,'',NULL),(96,17,'MUJAHID RAZA','','','013','','Z2PLqPTLwy9-WuFNSx-urddpOp5n8xmI','$2y$13$ENgy.Ir1CEA.xcLPLOffDOdIzrYCbVmiUd.YJq6v1hHDQ/eqB61bm',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:01:44',NULL,'',NULL),(97,17,'SADIA MEHJABEEN','','','014','','esaChHY6k8eE_h_oRfHcyW4zBygZvFBu','$2y$13$WXYBw.92b6bsECw2kRPwduFI.4cgMLPewnYpC6y0/KtyvgKFrcpCS',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:12:27',NULL,'',NULL),(98,17,'SHUMAILA NASIR','','','015','','MATNLKi61BtxAQQfReXuFZS-U0BGwcGL','$2y$13$/Dv.oUaL/NjyAapt/aVaeOoBZxenl2IzI8cGRCqA2pwi9QeF3O4iK',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:13:21',NULL,'',NULL),(99,17,'SABA PERWAIZ','','','016','','WD3AsbV0G7p-drsjP9LlJUkcjkgn6p4t','$2y$13$hGCdyljHFuhIaqRffVVPpeU.wadspSB3RoxCdLwB2Iat/ZvWFSEPu',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:14:51',NULL,'',NULL),(100,17,'','','','SOBIA MUKHTAR','','EbAtThjWbRW-_nEEpJlxCGccer41SaXn','$2y$13$Ave4xPrzOQzQIGE8EhOZQOuYfpLhq0o5WVkM5cowICjtFUnC1nU1y',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:15:48',NULL,'',NULL),(101,17,'LUBNA ANWAR','','','019','','QKJhGSnSJ_gCEXRJ-laxsUUh-MWGusGw','$2y$13$6lTRaunlKR5dxDqjzGGUKuYOMGSVh3/MCq97.Q7pVDlxBNdfZfdS.',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:25:27',NULL,'',NULL),(102,17,'JAVERIA ZAIN','','','20','','xao7OD1lrn0rf0rZMmkuhNyT4Gc14gtx','$2y$13$op3ztp5B6yalsLw45fl/DOQLXHlxjmtkLAZslXo43bInIrc4hms7C',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:26:25',NULL,'',NULL),(103,17,'SUMEERA SHAHBAZ','','','21','','rqtkpflpwDon2BIImQmezeMY8LssSNnA','$2y$13$eNkVDqXO7TevlVxJCUwTmus7NO1KiTSaGUORS.WIAqPBYmHaAFDTC',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:29:11',NULL,'',NULL),(104,17,'SUMEERA SHAHBAZ','','','22','','gRP-YvHoGbhjiX4u1_B_9Jj0xpw3cpcq','$2y$13$9qT2xnrjyL/34KFC8e9jn.3EHwsGaCytEDzaMDsWDMmTr5dyDUz.K',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:40:33',NULL,'',NULL),(105,17,'MADIHA ASGHAR','','','23','','Drjz221YHFv2dGUGyQ2Db6yFDw-mNsoF','$2y$13$6AJkI.GjW4cllPTqS4NTle51mqWcNudfRBnxso7LTO2v5wEtXT6TC',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:41:35',NULL,'',NULL),(106,17,'AMBREEN SOHAIB','','','28','','p9yqO-N7ZoL04Whtewx5wUlE7Z6bFf11','$2y$13$nDbRWC9VNF3gksl8i4NSoO4LG/5dCit7m3HejjG0TQtJKzPscCdW2',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:49:47',NULL,'',NULL),(107,17,'ABDUL QADIR','','','29','','8WIktSzjv6sHCGoVf6Jl6RLs2eoOZA1A','$2y$13$r7CmaT/l3BwdkEydveKIR.3Gs/ZPCsXGqGzh1kNsHceBq65CdznxS',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 10:50:47',NULL,'',NULL),(108,17,'RAJA REHAN','','','31','','k0bPmTiTQbwO1BBTCoOUvvHvJdrNjLAy','$2y$13$c52DgqfDaPizFOh1MkuDieJk64uELubonXwH/SV3dpE34HkTY1sam',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:03:56',NULL,'',NULL),(109,17,'RIMSHA SHERAZ','','','32','','Wcm1w_uX1-IO8T_P0vX-hYyZzguRlMFi','$2y$13$TtdtDopB4S8VItzv.lNidegRjnEhOhdk3eTvKyZ24gzqRJbzZrlYy',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:04:45',NULL,'',NULL),(110,17,'UME HABIBA','','','33','','ov-CvDFa2xmBgHM6gtfzKBT9VqMV5qou','$2y$13$FT0HBL.eENioRzSb5fbqwuZMvfQnvfgfFH28ikBRuTHYTU07iSJtq',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:05:32',NULL,'',NULL),(111,17,'RABIA AKBAR','','','35','','j2WXUAAsTkCeQnF5VbILwuoPcvlrOpTA','$2y$13$h3SGV4UHo4Ta0zWtdPhuGeN6wc8PzM2K44iB27bKUNwQc1wWNB0EK',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:07:34',NULL,'',NULL),(112,17,'FARKHANDA','','','36','','jKDtX_cp_2Jha6iSi1x_CrpAi9tpOqBD','$2y$13$OPXhbzS/KHo7Ex8UqVAIQe6mc/5IW7xJl5TI/wciFPA7H.MvLm0IC',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:08:24',NULL,'',NULL),(113,17,'MEHWISH NAZ','','','37','','R6zgGzjWbzIg0xY_PH68oYDEivrMSHwN','$2y$13$0o3KqkIjf3Mpy6m/463g5uAyHQYCFxhI2ewmj8ISywei6ZgQrFMw.',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:09:15',NULL,'',NULL),(114,17,'MUNEEZA KALEEM','','','38','','xSL3TGmrbHIgYrDbouNulOOMsdidqZu4','$2y$13$yBDtBdrQoBBMBFTHLzsQKu42.eEWtDOVtbSGsXuJs35t1.SjSzTUm',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:10:08',NULL,'',NULL),(115,17,'ANEELA SIDDIQUE','','','39','','1szNtr7raIok3mulkmDVr3KYmeKYckTR','$2y$13$/9xMFkb30Id08xmstJxmb.D8Y6CEjJYUKwxbupz4EjKuCZaqT2.nO',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:11:01',NULL,'',NULL),(116,17,'JAVERIA SHAUKAT','','','41','','zZpc75G-S1UVXrOjBjYPQtKW9Wawn-Cl','$2y$13$CQ5yVN8MdssWSKhDVi7RNOJVOkit5DMieCTaur3xI9mroU.M8hli2',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:11:56',NULL,'',NULL),(117,17,'NIDA INTIZAR','','','42','','zPjSqhDHzcXL3LbtjQPD8p3RCOkGDDSO','$2y$13$yAc5KYJusLa6datxtkGytuPrTBV0FijIjOxmg1qkP45jrTaa29aRu',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:12:49',NULL,'',NULL),(118,17,'SAEED AKHTAR','','','43','','Cd-E5OOUcA_PPhpc3uxIxh8VU9VLHbtU','$2y$13$rAmopPz.tMyiDeq4L5XaauiZgU5kfPsZYROmnEcbELMl65lHKw1xS',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:13:37',NULL,'',NULL),(119,17,'ABIDA BIBI','','','45','','jTp7kjQzhOPLEz91SpEZSKKNyMpUekdZ','$2y$13$Ef17GYHdf4oNPAwd/ufnOOcQIvmBi4Qofo1zIa5Te9z/7QFCKMaMm',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:14:22',NULL,'',NULL),(120,17,'ASAD ABBAS','','','47','','Bn6bKBIxp9SygMij9HQGdouuXBvpQIho','$2y$13$deGJo4k0ktH4udHJPJVDA.byuDR9u0tEnXo8eEUyg7YiYQi39cxzO',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:15:17',NULL,'',NULL),(121,9,'nametheere','','adsf','styureg2016','','PjPjl8d--ZVtALCeze4mRd96MQHjRFCK','$2y$13$ipyECTRULb8Fwe7bpGHVd.F0sAKxKHV0X0eLXyJjpqR.NPL7MU3uu',NULL,NULL,'active',3,NULL,NULL,'2017-01-10 11:32:16','2017-01-13 15:37:32','ÿßÿ±ÿØŸà','Chrysanthemum.jpg'),(122,17,'RUKHSANA','','','51','','q1yaEWDnER8s2L80FmpKErsJPSK_wY3f','$2y$13$ywIDOVstmSuT6LPLbshJbOJmDpz6vr9SjWXo2z0l8ItOFL/nZe5c6',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:43:51',NULL,'',NULL),(123,9,'Salmana','','Khan','STD122','','nYxfnVN5LzLH42-FzHYpH3nHNc4FHCZ6','$2y$13$ogGj2TpgZFqsxr6X.T.TVe26cMJBx0MDUHMnD2duvRrzNA4iAC8oS',NULL,NULL,'active',3,NULL,NULL,'2017-01-10 11:44:23','2017-01-13 18:08:23','','caricature-jimmy-fallon-tonight-show-cartoon-painting-drawing-american-television-nbc1.jpg'),(124,17,'SOBIA','','','52','','IwgP3hN6mK4wHjBfV1PdcOPrtxioxFtC','$2y$13$QbVgGneGstxEjsKkh2ku/unVeMLfIgoZqTsa8Ne824WCcaGhOyd0G',NULL,NULL,'active',4,NULL,NULL,'2017-01-10 11:49:02',NULL,'',NULL),(125,9,'Daniel','','Anderson','STD-TTR-1334','','BjGr4dYmKNXVqPbAtvW1JeEjN0oNq6iE','$2y$13$s.NmqvrVxPuHEEThSBewkOLcQSGw/jPMmhwOodL7KfULoBNv6nbwO',NULL,NULL,'active',3,NULL,NULL,'2017-01-11 16:38:04',NULL,'',''),(126,9,'asdf','','asdfad','STD-TTR-4355','','7cJaF6M5L29_KafGS4-3M-_jUasKXGmt','$2y$13$1ZccAN5WH8G0fWS8nmZ4pe1ruczmOXZASp/wA9JQxXGjZjSCn1gF6',NULL,NULL,'active',3,NULL,NULL,'2017-01-11 16:40:21',NULL,'',''),(127,9,'Daniel','','Anderson','STU-TRR-454','','d00XTeaLV5KEy8B_ys4VElz-FldhXqlV','$2y$13$8JWULCyFoUxogzVigVLedeFTE4Qqer0K7vwQ7Gsb297zuY274EtWi',NULL,NULL,'active',3,NULL,NULL,'2017-01-12 09:45:44',NULL,'',''),(128,9,'AHSAN','','Niazi','STD-TRR-123421','','ulq5aJ45KS6J_2-3ZCuw6Fj8Gcb7fluz','$2y$13$7l8mbZjFhmL580StTTafV.zbUV6jcUzhtPDSfJdTwkpoWxCseSlFq',NULL,NULL,'active',3,NULL,NULL,'2017-01-12 09:52:36',NULL,'',''),(129,9,'aeerweerafds','asdfa','adfadsf','3432434dfsef',NULL,'OxuONWcnEg87Zl0a9cwoAWzzk7mKteM2','$2y$13$PfHzvWMCapeZKQ/73DywqO4enykwJ4Dr0Cf8lv88l.6MzyrjWa19i',NULL,NULL,'active',3,NULL,NULL,'2017-01-12 13:14:47',NULL,'','Tulips.jpg'),(130,9,'Joey','','Tribbiani','STDMIS1',NULL,'fXZmtoeyIdVTcLhBaBw6wtialaIKfH5i','$2y$13$PWe5jqGbo.8d1x31PEOUyOG3Evg6kAWRdOeRl2/yX.hSIcZNTWQpm',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 11:44:23',NULL,'','caricature-jimmy-fallon-tonight-show-cartoon-painting-drawing-american-television-nbc1.jpg'),(131,9,'abdbsbs','','','STDmis4444444444',NULL,'W6ThBa4cY-bKYPlB4ZEt6fSxtd_Z31gb','$2y$13$spE.KfQibxBv6sHm42xmcu2xoFAWYclkFuEr.JJ2W08f5OxCDii8y',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 11:51:40',NULL,'',''),(132,9,'bhbhb','','','STDmis456789',NULL,'16xB-p76yI-0a4m5J-npDNWC0TW1wzix','$2y$13$6nSdjYzXoErU2snS3SabLe12mf9z0iJI2UYVJplW1sG2pBIBNz/kC',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 11:54:57',NULL,'',''),(133,9,'asdf','','','25test',NULL,'jq-I6I9viO3bx1EIGMfuo_BIyfNkqiKK','$2y$13$2.YRISbEgs/TP2/Jf46Oy.UGjcO71I/H3QGwPDUYKceBijxW1Ga/u',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 12:19:31',NULL,'',''),(134,9,'asdf','','','Ali-Trr-12',NULL,'P2AbXBZY4URViiiRqXqF5qwva-0hMR1L','$2y$13$anFgGinBZXy/srZ/3aa7z.WW0YhIw/lAQzzxgdBlhwI1MCEV16Ymq',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 13:01:45',NULL,'',''),(135,9,'asdf','','','Ali-Trr-22',NULL,'507NyX-AqET2UmmGGzyGdDgCWunsxjjU','$2y$13$CUaO0im2A7pCUGYWEnCARuGYj8pafCPzeg2t0L2c5IDdLgsqB0VZ6',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 13:10:09',NULL,'',''),(136,9,'asdf','','','Ali-Trr-234',NULL,'1GOsSueqVKBdKw051AhPmX1YC_GA2k03','$2y$13$1NMljA7cxjXwPJNkzD0OI.ASlsjczuoS/GoLcpdcanLBVhGNIIqyW',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 13:11:18',NULL,'',''),(137,9,'asdf','','','Ali-Trr_Branch-9',NULL,'4ocjA5J9y67jpPvXUdnlWdf2ynLsxrRF','$2y$13$JAkasFlymEzNFWnSJKCoB.3W8UMpSGulfVLR/SyhmQHdcs38YvDBa',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 13:12:38',NULL,'',''),(138,9,'Noor Muhammad','','','Ali_trr_branch_89',NULL,'2xNGcU4AA486kn6Gzp_FA5Jg_-MAy-Hv','$2y$13$eQeA55POw8kr3a2W0UU1J.UlkcfhRAej/ZpQAmFBBI/rb8jlQBS.e',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 13:18:52',NULL,'',''),(139,9,'chandler','','','STDMIS5','','K5xl9EwXnRNanCBy3ZP_DE0qbmUKudX0','$2y$13$WvnvshBDjHQ039mLc5N/9ukjFs9BRxFcY7JtgDcZ6nvdto9zC/i4m',NULL,NULL,'active',3,NULL,NULL,'2017-01-13 15:38:59','2017-01-13 15:46:06','',''),(140,9,'qewrwer','','qwerqwer','234234',NULL,'L2auQBNMBrBO6MCuuq9vegFQ0ExgC0a9','$2y$13$55egJ6RWL6wpSZH0PDM3kO7Z7GDnX7C2sb/I3S2KPtmiZy9H44bAm',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-14 01:32:16',NULL,'',''),(141,9,' AAYA G SHUGUFTA SHAHNAZ','','','125','','ZjXIhVQf-2l_Hk7MOczVPvHuKHONrTe2','$2y$13$QppuIy6p9W3refCBNoEHTeO5NgxzJlrreTMJQJIBQZE6zTN5NWYOe',NULL,NULL,'active',4,NULL,NULL,'2017-01-18 07:58:09','2017-01-19 07:58:08','',NULL),(142,9,'MUNEER AHMED','','','126','','qdTPPOfzvBf--4xzjgiFjg4HmLrptng7','$2y$13$FoDZHPLLqUM3ypIIRNqxpeCMDCRL/nuCSnTYLMCfY58d6XSFoA00K',NULL,NULL,'active',4,NULL,NULL,'2017-01-18 08:32:09',NULL,'',NULL),(143,9,'AAYA G SOBIA JAN','','','145','','eXvthZmtggd8rSI43BZU8hn8caTU18j2','$2y$13$4aMVxlh.M1uRQMnGJlFvmuhecCTnhyehvWY9/Qn686gzW3hKRFia2',NULL,NULL,'active',4,NULL,NULL,'2017-01-19 08:00:32',NULL,'',NULL),(144,9,'NADEEM','','','146','','0LdHSMUS-e88etsyWiW1xqkDfeuZWCUT','$2y$13$KM6G8BmlWmkJYUrMXlAp1O1tAh1sKo.ZKYzOWAclIyeEMp8Bet1w2',NULL,NULL,'active',4,NULL,NULL,'2017-01-19 08:02:32',NULL,'',NULL),(145,9,'Muhammad','Salman','Khan','15',NULL,'iv1HE0le8lA2HtOlJ5g8KoOpnUWOwyaQ','$2y$13$Fc2fS7cINxmtioTUOYjFd.BTqF8HJ/Pptzg1htVHYfgxxfrfuyCJi',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:33:52',NULL,'ÿ≥ŸÑŸÖÿßŸÜ',''),(146,9,'noor','etertet','te','234234234',NULL,'_0uyIME2AuIQ5bLA3TEKgq1mYRTZeeot','$2y$13$3uk9O64.CcPUiI4bO6SX1uap9aEP8xwjLbJddnrCLzxspghl4Tjm6',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:36:38',NULL,'',''),(147,9,'Muhammad','Salman','KHAN','16',NULL,'fFY3mrRfSXnsS0QmPtNJjHxFjx6teNJZ','$2y$13$EwGS4EJDqqyl/DGlovAifOhlHk1pBU8g9AB.kKRBDsqRBl84.dOjC',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:39:54',NULL,'',''),(148,9,'yutyutu','','','65667',NULL,'y7ncbslN8jesP_xo64PNzMokVmLyCPdT','$2y$13$eoXQ/2fkx3RwOJJtlg5hKOCVnwQ.JRuAE9F07kUEPsQ3BRjGGn3Pa',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:40:01',NULL,'',''),(149,9,'ROSS','','r','STDNT122112',NULL,'Gk0NTneEaQV9fXKrL_pkX3tPyrOIIvEd','$2y$13$1QIISE.mqwd1nxQ8KkgHZuQRgq/hErF7AGjga.CJve/nJj5W5XYqS',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:42:22',NULL,'',''),(150,9,'asd','','','wer456',NULL,'ssErZnCgVtV_sZZ1858RHMh3bsWXW-P-','$2y$13$HmGCoGfsnFxNSy.g4yMode600S21dJKRaW6k9XYlbGCUf.1RnVVx2',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:45:22',NULL,'',''),(151,9,'asder','','','asd-876',NULL,'96SBctKhzXmSVQ5Ny0JwaEtylZQNQhjg','$2y$13$M1cjSaYnwOYPz0GnkdVdWeFp6Nepkw8LZhc7PMTQlIFd2FDQx/DX2',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:51:01',NULL,'',''),(152,9,'asdf','','','232-2323',NULL,'z5rtR_eVW8fhJB3cEUY0V53idZN60mPL','$2y$13$ax.Ogu6rO6RMNejx4NMBfumUaB9e0vpE3ixaE9OF42jV9JSxugdaK',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:54:08',NULL,'',''),(153,9,'asdf','','','test_user_987654',NULL,'jgazDqlcYK9uvuyu-xSlPxb3Hs7s5pog','$2y$13$kmcRAoOMdNs25PBSJH.F2OH5NFJ0704dVB1kL7BzBPbogMW.lBc5m',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 11:56:54',NULL,'',''),(154,9,'Ali','','','test-branch-ch-116',NULL,'1hygt4ZnLc1oMSjbR0VUTrMmzt-pyo7x','$2y$13$WJImh1/fbeOyvAUJLTGPnunPzcQdjL5g9933UaOdukFoKuF0CZcnq',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 12:01:45',NULL,'',''),(155,9,'adsfasd','','','test-branch-al-01',NULL,'wEWk6UiPfwhugNnwqKFu6jV-x0D3p68F','$2y$13$aVvQa5Q38kjKjHx3LxbnxuofNcGiHCxGBF5YjWS9bCfTAULPB6SRK',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 12:17:48',NULL,'',''),(156,9,'Ali Abdullah 01','','','test-branch-ali-01',NULL,'vL_BNrp5ODAmZbZ1V78jJS_y_BGzIjP6','$2y$13$RRJdAsPKJ1itceQw9P5.VeR8.LMg3dBqcvzDDogTUtqWbgkKOwkrW',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 12:21:04',NULL,'',''),(157,9,'ali 09','','','test-branch-al-10',NULL,'NKXzfHI9R_GQjgBUXhsyiNFfUAK5d9DC','$2y$13$uvjR.y1Dj8hVrria4ppe5OA2qTwzHpQvs8wCETm3BFe7.GWn5GgSK',NULL,NULL,'inactive',3,NULL,NULL,'2017-01-20 12:24:34',NULL,'','');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','inactive','','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,'Super Admin','2016-12-07 05:15:32','active'),(2,'Branch Manager','2016-12-07 05:15:32','active'),(3,'Student','2016-12-07 05:15:57','active'),(4,'employer','2016-12-07 05:15:57','active');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userinfo` (
  `USERID` int(11) DEFAULT NULL,
  `Badgenumber` varchar(24) DEFAULT NULL,
  `SSN` varchar(20) DEFAULT NULL,
  `Name` varchar(40) DEFAULT NULL,
  `Gender` varchar(8) DEFAULT NULL,
  `TITLE` varchar(20) DEFAULT NULL,
  `PAGER` varchar(20) DEFAULT NULL,
  `BIRTHDAY` datetime DEFAULT NULL,
  `HIREDDAY` datetime DEFAULT NULL,
  `street` varchar(80) DEFAULT NULL,
  `CITY` varchar(2) DEFAULT NULL,
  `STATE` varchar(2) DEFAULT NULL,
  `ZIP` varchar(12) DEFAULT NULL,
  `OPHONE` varchar(20) DEFAULT NULL,
  `FPHONE` varchar(20) DEFAULT NULL,
  `VERIFICATIONMETHOD` smallint(6) DEFAULT NULL,
  `DEFAULTDEPTID` smallint(6) DEFAULT NULL,
  `SECURITYFLAGS` smallint(6) DEFAULT NULL,
  `ATT` smallint(6) DEFAULT NULL,
  `INLATE` smallint(6) DEFAULT NULL,
  `OUTEARLY` smallint(6) DEFAULT NULL,
  `OVERTIME` smallint(6) DEFAULT NULL,
  `SEP` smallint(6) DEFAULT NULL,
  `HOLIDAY` smallint(6) DEFAULT NULL,
  `MINZU` varchar(8) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `LUNCHDURATION` smallint(6) DEFAULT NULL,
  `PHOTO` mediumblob,
  `mverifypass` varchar(10) DEFAULT NULL,
  `Notes` mediumblob,
  `privilege` int(11) DEFAULT NULL,
  `InheritDeptSch` smallint(6) DEFAULT NULL,
  `InheritDeptSchClass` smallint(6) DEFAULT NULL,
  `AutoSchPlan` smallint(6) DEFAULT NULL,
  `MinAutoSchInterval` int(11) DEFAULT NULL,
  `RegisterOT` smallint(6) DEFAULT NULL,
  `InheritDeptRule` smallint(6) DEFAULT NULL,
  `EMPRIVILEGE` smallint(6) DEFAULT NULL,
  `CardNo` varchar(20) DEFAULT NULL,
  `FaceGroup` int(11) DEFAULT NULL,
  `AccGroup` int(11) DEFAULT NULL,
  `UseAccGroupTZ` int(11) DEFAULT NULL,
  `VerifyCode` int(11) DEFAULT NULL,
  `Expires` int(11) DEFAULT NULL,
  `ValidCount` int(11) DEFAULT NULL,
  `ValidTimeBegin` datetime DEFAULT NULL,
  `ValidTimeEnd` datetime DEFAULT NULL,
  `TimeZone1` int(11) DEFAULT NULL,
  `TimeZone2` int(11) DEFAULT NULL,
  `TimeZone3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userinfo`
--

LOCK TABLES `userinfo` WRITE;
/*!40000 ALTER TABLE `userinfo` DISABLE KEYS */;
INSERT INTO `userinfo` VALUES (1,'1',NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,1,1,1,1,1,1,NULL,NULL,1,NULL,NULL,NULL,0,1,1,1,24,1,1,0,NULL,0,1,1,0,0,0,NULL,NULL,1,0,0),(2,'2',NULL,'2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,1,1,1,1,1,1,NULL,NULL,1,NULL,NULL,NULL,0,1,1,1,24,1,1,0,NULL,0,1,1,0,0,0,NULL,NULL,1,0,0),(3,'23',NULL,'23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,1,1,1,1,1,1,NULL,NULL,1,NULL,NULL,NULL,0,1,1,1,24,1,1,0,NULL,0,1,1,0,0,0,NULL,NULL,1,0,0),(4,'22',NULL,'22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,1,1,1,1,1,1,NULL,NULL,1,NULL,NULL,NULL,0,1,1,1,24,1,1,0,NULL,0,1,1,0,0,0,NULL,NULL,1,0,0);
/*!40000 ALTER TABLE `userinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_info`
--

DROP TABLE IF EXISTS `vehicle_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `registration_no` varchar(20) NOT NULL,
  `model` varchar(10) NOT NULL,
  `no_of_seats` int(11) NOT NULL,
  `vehicle_make` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `vehicle_info_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_info`
--

LOCK TABLES `vehicle_info` WRITE;
/*!40000 ALTER TABLE `vehicle_info` DISABLE KEYS */;
INSERT INTO `vehicle_info` VALUES (3,9,'Bus 1','87976','2015',70,'Hyundai'),(4,9,'totali bus','54654','2016',54,'aa');
/*!40000 ALTER TABLE `vehicle_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_advertisement_medium`
--

DROP TABLE IF EXISTS `visitor_advertisement_medium`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_advertisement_medium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_advertisement_medium`
--

LOCK TABLES `visitor_advertisement_medium` WRITE;
/*!40000 ALTER TABLE `visitor_advertisement_medium` DISABLE KEYS */;
INSERT INTO `visitor_advertisement_medium` VALUES (1,'Pamphlets'),(2,'TVC'),(3,'Bill Boards'),(4,'pamphlets');
/*!40000 ALTER TABLE `visitor_advertisement_medium` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_info`
--

DROP TABLE IF EXISTS `visitor_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `cnic` varchar(15) DEFAULT NULL,
  `contact_no` varchar(25) DEFAULT NULL,
  `fk_adv_med_id` int(11) DEFAULT NULL,
  `fk_class_id` int(11) DEFAULT NULL,
  `date_of_visit` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `fk_vistor_category` int(11) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_description` varchar(300) DEFAULT NULL,
  `last_degree` varchar(255) DEFAULT NULL,
  `experiance` varchar(255) DEFAULT NULL,
  `last_organization` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `designation` int(11) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `coordinator_comments` varchar(22) DEFAULT NULL,
  `mode_advertisement` int(11) DEFAULT NULL,
  `admin_personel_observation` varchar(255) DEFAULT NULL,
  `is_admitted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `fk_adv_med_id` (`fk_adv_med_id`),
  KEY `fk_class_id` (`fk_class_id`),
  CONSTRAINT `visitor_info_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `visitor_info_ibfk_2` FOREIGN KEY (`fk_adv_med_id`) REFERENCES `visitor_advertisement_medium` (`id`),
  CONSTRAINT `visitor_info_ibfk_3` FOREIGN KEY (`fk_class_id`) REFERENCES `ref_class` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_info`
--

LOCK TABLES `visitor_info` WRITE;
/*!40000 ALTER TABLE `visitor_info` DISABLE KEYS */;
INSERT INTO `visitor_info` VALUES (7,9,'jobs','45','456',1,NULL,NULL,1,1,'','','BSC','4 yrs','dfg','dsdsd',NULL,6,'','fgh','',NULL,NULL,0),(9,9,'df','45','45',1,NULL,NULL,1,1,'df','df','','','','',NULL,NULL,'df','df','',NULL,NULL,0),(11,9,'a','0099','56',1,NULL,NULL,1,1,'','','tyty','qwe','tyty','qqwwee',NULL,7,'','ytyty','',NULL,NULL,0),(12,9,'b','0099','7878787',1,NULL,NULL,1,2,'jjkjjkjk','jjkjk','','','','',NULL,NULL,'uiuiuiuiuui','yuyuyuyuyuyu','',NULL,NULL,0),(13,9,'new vistirs','423234234','234234234',1,16,NULL,1,3,'','','','','','',NULL,NULL,'','asdf','asdf',NULL,NULL,0),(14,9,'asdfavczasdf','34345345','2342342323234',1,NULL,NULL,1,3,'','','','','','',NULL,NULL,'','asdf','asdf',NULL,NULL,0),(15,9,'erwerwerwerwer','345','44444444444',1,17,NULL,1,3,'','','','','','',NULL,NULL,'','sdfgsfhgfjdfgsdgsf','sdfgsdfgsdf',NULL,NULL,0),(17,9,'aqds','2323232','232323232323',2,NULL,NULL,1,2,'sdfg','sdfg','','','','',NULL,NULL,'wewrtetr','dfgsf','',NULL,NULL,0),(19,9,'fred','45646','456456456454',1,NULL,NULL,1,1,'','','sdfsf','sdfs','sdfsd','sdsff',NULL,6,'','sdfsdf','',NULL,NULL,0),(20,9,'fred','45646','456456456454',1,NULL,NULL,1,1,'','','sdfsf','sdfs','sdfsd','sdsff',NULL,4,'','sdfsdf','',NULL,NULL,0),(21,9,'abvcc','1233211','12312312312',1,16,NULL,1,3,'','','','','','',NULL,NULL,'','asr','sedr',NULL,NULL,0),(22,9,'ahsan shahzad','1310123295387','03479799009',1,19,NULL,1,3,'','','','','','',NULL,NULL,'','C-B 500, Jhangi Syedan','was almost satisfied',NULL,NULL,0),(23,9,'beenish taj','1330203822172','03105520336',2,19,NULL,1,3,'','','','','','',NULL,NULL,'','C-B 500, Jhangi Syedan','',NULL,'0',1),(27,9,'ahsan','','0345818668',3,19,'2017-01-18 11:05:07',1,3,'','','','','','',NULL,NULL,'','mdsnfsdnfdmsf','fhdjfhgdjghdfsgj',NULL,NULL,0),(29,9,'ahsan shahzad','1310123295387','03479799009',2,19,'2017-01-18 19:43:02',1,3,'','','','','','',NULL,NULL,'','C-B 500, Jhangi Syedan',NULL,NULL,'looked needy',0),(31,9,'test','345345345','45345345',4,21,'2017-01-20 12:28:00',1,3,'','','','','','',NULL,NULL,'','qerqwerqwer','',NULL,'seemed from some school,were fishy,were arguing,0',1);
/*!40000 ALTER TABLE `visitor_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_info2`
--

DROP TABLE IF EXISTS `visitor_info2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_info2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `cnic` varchar(15) DEFAULT NULL,
  `contact_no` int(11) DEFAULT NULL,
  `fk_country_id` int(11) NOT NULL,
  `fk_province_id` int(11) NOT NULL,
  `fk_district_id` int(11) NOT NULL,
  `fk_city_id` int(11) NOT NULL,
  `fk_adv_med_id` int(11) DEFAULT NULL,
  `fk_class_id` int(11) DEFAULT NULL,
  `fk_group_id` int(11) DEFAULT NULL,
  `fd_section_id` int(11) DEFAULT NULL,
  `date_of_visit` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `fk_vistor_category` int(11) NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_description` varchar(300) DEFAULT NULL,
  `last_degree` varchar(255) DEFAULT NULL,
  `experiance` varchar(255) DEFAULT NULL,
  `last_organization` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `designation` int(11) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `coordinator_comments` varchar(255) DEFAULT NULL,
  `mode_advertisement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_country_id` (`fk_country_id`),
  KEY `fk_province_id` (`fk_province_id`),
  KEY `fk_district_id` (`fk_district_id`),
  KEY `fk_city_id` (`fk_city_id`),
  KEY `fk_adv_med_id` (`fk_adv_med_id`),
  KEY `fk_class_id` (`fk_class_id`),
  KEY `fk_group_id` (`fk_group_id`),
  KEY `designation` (`designation`),
  KEY `fd_section_id` (`fd_section_id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  KEY `fk_vistor_category` (`fk_vistor_category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_info2`
--

LOCK TABLES `visitor_info2` WRITE;
/*!40000 ALTER TABLE `visitor_info2` DISABLE KEYS */;
/*!40000 ALTER TABLE `visitor_info2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_response_info`
--

DROP TABLE IF EXISTS `visitor_response_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_response_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_admission_vistor_id` int(11) NOT NULL,
  `first_attempt_date` datetime DEFAULT NULL,
  `second_attempt_date` datetime DEFAULT NULL,
  `third_attempt_date` datetime DEFAULT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_response_info_ibfk_1` (`fk_admission_vistor_id`),
  CONSTRAINT `visitor_response_info_ibfk_1` FOREIGN KEY (`fk_admission_vistor_id`) REFERENCES `visitor_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_response_info`
--

LOCK TABLES `visitor_response_info` WRITE;
/*!40000 ALTER TABLE `visitor_response_info` DISABLE KEYS */;
INSERT INTO `visitor_response_info` VALUES (14,7,'2017-01-18 00:00:00','2017-01-25 00:00:00','2017-02-01 00:00:00',NULL),(16,9,'2017-01-18 00:00:00','2017-01-25 00:00:00','2017-02-01 00:00:00',NULL),(18,11,'2017-01-18 00:00:00','2017-01-25 00:00:00','2017-02-01 00:00:00',NULL),(19,12,'2017-01-18 00:00:00','2017-01-25 00:00:00','2017-02-01 00:00:00',NULL),(20,13,'2017-01-18 00:00:00','2017-01-25 00:00:00','2017-02-01 00:00:00',NULL),(21,14,'2017-01-18 00:00:00','2017-01-25 00:00:00','2017-02-01 00:00:00',NULL),(22,15,'2017-01-18 00:00:00','2017-01-25 00:00:00','2017-02-01 00:00:00',NULL),(24,17,'2017-01-19 00:00:00','2017-01-26 00:00:00','2017-02-02 00:00:00',NULL),(26,19,'2017-01-19 00:00:00','2017-01-26 00:00:00','2017-02-02 00:00:00',NULL),(27,20,'2017-01-19 00:00:00','2017-01-26 00:00:00','2017-02-02 00:00:00',NULL),(28,21,'2017-01-19 00:00:00','2017-01-26 00:00:00','2017-02-02 00:00:00',NULL),(29,22,'2017-02-07 00:00:00','2017-02-10 00:00:00','2017-02-14 00:00:00',NULL),(30,23,'2017-01-24 00:00:00','2017-01-31 00:00:00','2017-02-07 00:00:00',NULL),(34,27,'2017-01-25 00:00:00','2017-02-01 00:00:00','2017-02-08 00:00:00',NULL),(36,29,'2017-01-22 00:00:00','2017-01-26 00:00:00','2017-01-30 00:00:00',NULL),(38,31,'2017-01-20 00:00:00','2017-01-28 00:00:00','2017-02-01 00:00:00',NULL);
/*!40000 ALTER TABLE `visitor_response_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vistor_category`
--

DROP TABLE IF EXISTS `vistor_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vistor_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vistor_category`
--

LOCK TABLES `vistor_category` WRITE;
/*!40000 ALTER TABLE `vistor_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `vistor_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `working_days`
--

DROP TABLE IF EXISTS `working_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `working_days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `working_days`
--

LOCK TABLES `working_days` WRITE;
/*!40000 ALTER TABLE `working_days` DISABLE KEYS */;
INSERT INTO `working_days` VALUES (1,'Monday',1),(2,'Tuesday',1),(3,'Wensday',1),(4,'Thursday',1),(5,'Friday',1),(6,'Saturday',1),(7,'Sunday',1);
/*!40000 ALTER TABLE `working_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zone`
--

DROP TABLE IF EXISTS `zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_branch_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`fk_branch_id`),
  CONSTRAINT `zone_ibfk_1` FOREIGN KEY (`fk_branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zone`
--

LOCK TABLES `zone` WRITE;
/*!40000 ALTER TABLE `zone` DISABLE KEYS */;
INSERT INTO `zone` VALUES (2,9,'West'),(4,9,'East');
/*!40000 ALTER TABLE `zone` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-20 12:33:33
