-- MySQL dump 10.13  Distrib 5.5.16, for Win64 (x86)
--
-- Host: localhost    Database: salon
-- ------------------------------------------------------
-- Server version	5.5.16-log

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
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'customer id',
  `saloon_id` int(11) NOT NULL COMMENT 'saloon id',
  `slot_id` int(11) NOT NULL COMMENT 'available slot id',
  `slot_start_time` varchar(50) NOT NULL COMMENT 'user appointment slot start time',
  `service_type` text COMMENT 'services user request for',
  `status` enum('R','D','C') NOT NULL DEFAULT 'R' COMMENT 'R for request for service D for service done C for appointment cancle',
  `slot_end_time` varchar(50) NOT NULL COMMENT 'user appointment slot end time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `available_slot`
--

DROP TABLE IF EXISTS `available_slot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `available_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `saloon_id` int(11) NOT NULL COMMENT 'saloon id',
  `start_time` varchar(50) NOT NULL COMMENT 'slot start time',
  `end_time` varchar(50) NOT NULL COMMENT 'slot end time',
  `cal_start_time` varchar(50) NOT NULL COMMENT 'start time for calander',
  `cal_end_time` varchar(50) NOT NULL COMMENT 'end time for calander',
  `status` enum('A','D') NOT NULL DEFAULT 'A' COMMENT 'A for active D for deleted',
  `slot_id` int(11) NOT NULL COMMENT 'client slot id',
  `slot_title` varchar(70) NOT NULL COMMENT 'client slot title',
  `all_day` varchar(70) DEFAULT NULL COMMENT 'slot all day event',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `available_slot`
--

LOCK TABLES `available_slot` WRITE;
/*!40000 ALTER TABLE `available_slot` DISABLE KEYS */;
INSERT INTO `available_slot` VALUES (1,1,'1366959600','1366975800','1366939800','1366956000','A',1,'hello','false'),(2,1,'1367395200','1367429400','1367375400','1367409600','A',2,'Mohit','false'),(3,1,'1367404200','1367436600','1367384400','1367416800','A',3,'bbbbb','false');
/*!40000 ALTER TABLE `available_slot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saloon_master`
--

DROP TABLE IF EXISTS `saloon_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saloon_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id for saloon',
  `saloon_name` varchar(60) NOT NULL COMMENT 'saloon name',
  `address` text COMMENT 'saloon address',
  `owner_id` int(11) NOT NULL COMMENT 'saloon owner id',
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last update by saloon owner',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saloon_master`
--

LOCK TABLES `saloon_master` WRITE;
/*!40000 ALTER TABLE `saloon_master` DISABLE KEYS */;
INSERT INTO `saloon_master` VALUES (1,'Good Will','Delhi ',1,'2013-04-26 16:54:06');
/*!40000 ALTER TABLE `saloon_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saloon_services`
--

DROP TABLE IF EXISTS `saloon_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saloon_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service` varchar(50) NOT NULL COMMENT 'service provide by saloon',
  `saloon_id` int(11) NOT NULL COMMENT 'saloon id',
  `duration` int(11) DEFAULT '30' COMMENT 'duration for service',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saloon_services`
--

LOCK TABLES `saloon_services` WRITE;
/*!40000 ALTER TABLE `saloon_services` DISABLE KEYS */;
INSERT INTO `saloon_services` VALUES (1,'hairCutting',1,30),(2,'massage',1,30),(3,'coloring',1,30);
/*!40000 ALTER TABLE `saloon_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_master`
--

DROP TABLE IF EXISTS `users_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `user_name` varchar(50) NOT NULL COMMENT 'user name for login',
  `password` text NOT NULL COMMENT 'user password for login',
  `first_name` varchar(30) NOT NULL COMMENT 'user first name',
  `last_name` varchar(30) DEFAULT NULL COMMENT 'user last name',
  `user_type` enum('A','C','O') NOT NULL DEFAULT 'C' COMMENT 'A for admin C for customer and O for owner',
  `status` enum('A','D','I') NOT NULL DEFAULT 'A' COMMENT 'user status A for active and D for Deleted and I for inactive',
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last updated by user',
  `created_on` date NOT NULL COMMENT 'time of creation user account',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_master`
--

LOCK TABLES `users_master` WRITE;
/*!40000 ALTER TABLE `users_master` DISABLE KEYS */;
INSERT INTO `users_master` VALUES (1,'lookforward007@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','Mohit','Singh','O','A','2013-04-26 16:53:03','2013-04-26'),(2,'saz@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','Saz','Singh','C','A','2013-04-26 16:53:40','2013-04-26');
/*!40000 ALTER TABLE `users_master` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-01 21:39:35
