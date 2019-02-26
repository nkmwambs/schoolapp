CREATE DATABASE  IF NOT EXISTS `schoolapp` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `schoolapp`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: schoolapp
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.32-MariaDB

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
-- Table structure for table `fees_structure_details`
--

DROP TABLE IF EXISTS `fees_structure_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees_structure_details` (
  `detail_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `fees_id` int(10) NOT NULL,
  `income_category_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees_structure_details`
--

LOCK TABLES `fees_structure_details` WRITE;
/*!40000 ALTER TABLE `fees_structure_details` DISABLE KEYS */;
INSERT INTO `fees_structure_details` VALUES (1,'Tuition',1,6,8500),(2,'Academic Trips',1,4,2500),(3,'Examinations',1,2,1800),(4,'Transport',1,1,0),(5,'Bus Mantainance',1,5,2400),(6,'Sundry ',1,3,1200),(7,'Tuition',3,6,8500),(8,'Academic Trips',3,4,2500),(9,'Examinations',3,2,1800),(10,'Transport',3,1,0),(11,'Bus Mantainance',3,5,2400),(12,'Sundry ',3,3,1200),(13,'Tuition',4,6,8500),(14,'Academic Trips',4,4,2500),(15,'Examinations',4,2,1800),(16,'Transport',4,1,0),(17,'Bus Mantainance',4,5,2400),(18,'Sundry ',4,3,1200);
/*!40000 ALTER TABLE `fees_structure_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-20 12:51:13
