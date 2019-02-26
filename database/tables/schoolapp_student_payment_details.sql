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
-- Table structure for table `student_payment_details`
--

DROP TABLE IF EXISTS `student_payment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_payment_details` (
  `student_payment_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `payment_id` int(100) NOT NULL,
  `detail_id` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `t_date` date NOT NULL,
  PRIMARY KEY (`student_payment_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_payment_details`
--

LOCK TABLES `student_payment_details` WRITE;
/*!40000 ALTER TABLE `student_payment_details` DISABLE KEYS */;
INSERT INTO `student_payment_details` VALUES (1,1,1,1600,'2018-01-09'),(2,1,2,500,'2018-01-09'),(3,1,3,200,'2018-01-09'),(4,2,1,6500,'2018-01-09'),(5,2,2,2000,'2018-01-09'),(6,2,3,1800,'2018-01-09'),(7,2,4,7500,'2018-01-09'),(8,2,5,2400,'2018-01-09'),(9,2,6,1200,'2018-01-09'),(10,3,7,3400,'2018-01-31'),(11,4,7,5100,'2018-01-31'),(12,4,8,2500,'2018-01-31'),(13,4,9,1800,'2018-01-31'),(14,4,11,2400,'2018-01-31'),(15,4,12,1200,'2018-01-31');
/*!40000 ALTER TABLE `student_payment_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-20 12:51:07
