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
-- Table structure for table `cashbook`
--

DROP TABLE IF EXISTS `cashbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashbook` (
  `cashbook_id` int(200) NOT NULL AUTO_INCREMENT,
  `batch_number` int(200) NOT NULL,
  `t_date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `transaction_type` int(10) NOT NULL COMMENT '1=income,2=expense,3=to_bank,4=to_cash',
  `account` int(10) NOT NULL COMMENT '1=cash,2=bank',
  `amount` decimal(10,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cashbook_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashbook`
--

LOCK TABLES `cashbook` WRITE;
/*!40000 ALTER TABLE `cashbook` DISABLE KEYS */;
INSERT INTO `cashbook` VALUES (1,180101,'2018-01-09','Student Payment - James Mulandi',1,2,2300.00,'2018-07-10 19:02:24'),(2,180102,'2018-01-09','Student Payment - Joyce Ted',1,1,21400.00,'2018-07-10 20:39:00'),(3,180103,'2018-01-10','School Stationery',2,1,465.00,'2018-07-10 22:04:43'),(4,180104,'2018-01-31','Student Payment - Beatrice Maina',1,1,3400.00,'2018-07-23 10:52:58'),(5,180105,'2018-01-31','Student Payment - Beatrice Maina',1,1,13000.00,'2018-07-23 10:54:59'),(6,180106,'2018-01-31','Over Pay Term 2',1,1,7000.00,'2018-07-23 10:56:02');
/*!40000 ALTER TABLE `cashbook` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-20 12:51:14
