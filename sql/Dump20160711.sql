CREATE DATABASE  IF NOT EXISTS `salary` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `salary`;
-- MySQL dump 10.13  Distrib 5.7.13, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: salary
-- ------------------------------------------------------
-- Server version	5.7.13

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
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(225) NOT NULL,
  `lastname` varchar(225) NOT NULL,
  `inn` int(11) NOT NULL,
  `started_from` datetime NOT NULL,
  `last_worked_date` datetime DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_working_now` tinyint(4) NOT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `fk_employee_1_idx` (`position_id`),
  CONSTRAINT `fk_employee_1` FOREIGN KEY (`position_id`) REFERENCES `position` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'Ivan','Sidorov',456123789,'2016-01-15 00:00:00',NULL,NULL,1,'2016-07-11 06:20:45',1),(2,'Peter','Great',789456123,'2016-02-20 00:00:00',NULL,NULL,2,'2016-07-11 06:20:45',1),(3,'Ivan','Petrov',123456789,'2016-05-30 00:00:00',NULL,NULL,3,'2016-07-11 06:20:45',1),(4,'Kate','Serova',456258147,'2016-07-15 00:00:00',NULL,NULL,2,'2016-07-11 07:29:19',1);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `rate_per_day` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (1,'director',100.00),(2,'developer',70.00),(3,'accountant',50.00);
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary`
--

DROP TABLE IF EXISTS `salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary` (
  `salary_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `date_given` date DEFAULT NULL,
  `sum_main` decimal(12,2) DEFAULT NULL,
  `sum_add` decimal(12,2) DEFAULT NULL,
  `tax` decimal(12,2) DEFAULT NULL,
  `sum_to_pay` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`salary_id`),
  KEY `fk_salary_1_idx` (`employee_id`),
  CONSTRAINT `fk_salary_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary`
--

LOCK TABLES `salary` WRITE;
/*!40000 ALTER TABLE `salary` DISABLE KEYS */;
INSERT INTO `salary` VALUES (1,1,'2016-06-05',1800.00,NULL,150.00,1650.00),(2,2,'2016-06-05',1500.00,505.00,150.00,1855.00),(3,3,'2016-06-05',1000.00,NULL,150.00,850.00),(4,1,'2016-05-10',1900.00,NULL,150.00,1750.00),(5,2,'2016-05-10',1600.00,400.00,150.00,1850.00),(6,3,'2016-05-10',1000.00,NULL,150.00,850.00);
/*!40000 ALTER TABLE `salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_time_record`
--

DROP TABLE IF EXISTS `work_time_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_time_record` (
  `work_time_record_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `month_id` int(11) DEFAULT NULL,
  `work_day_plan` int(11) DEFAULT NULL,
  `sick_day` int(11) DEFAULT NULL,
  `vacation` int(11) DEFAULT NULL,
  `worked_fact` int(11) DEFAULT NULL,
  PRIMARY KEY (`work_time_record_id`),
  KEY `fk_work_time_record_1_idx` (`employee_id`),
  CONSTRAINT `fk_work_time_record_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_time_record`
--

LOCK TABLES `work_time_record` WRITE;
/*!40000 ALTER TABLE `work_time_record` DISABLE KEYS */;
INSERT INTO `work_time_record` VALUES (1,1,2016,5,15,3,NULL,15),(2,2,2016,5,18,NULL,NULL,18),(3,3,2016,5,18,NULL,NULL,18);
/*!40000 ALTER TABLE `work_time_record` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-11 12:26:26
