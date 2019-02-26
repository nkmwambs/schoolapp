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
-- Table structure for table `crud`
--

DROP TABLE IF EXISTS `crud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crud` (
  `crud_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_access` varchar(20) NOT NULL,
  `feature` varchar(20) NOT NULL,
  `operation` varchar(20) NOT NULL,
  PRIMARY KEY (`crud_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crud`
--

LOCK TABLES `crud` WRITE;
/*!40000 ALTER TABLE `crud` DISABLE KEYS */;
INSERT INTO `crud` VALUES (2,'super','student','create'),(3,'super','student','read'),(4,'super','student','update'),(5,'super','student','delete'),(6,'super','parent','create'),(7,'super','parent','read'),(8,'super','parent','update'),(9,'super','parent','delete'),(10,'super','activity','create'),(11,'super','activity','read'),(12,'super','activity','update'),(13,'super','activity','delete'),(14,'super','student','create'),(15,'super','student','read'),(16,'super','student','update'),(17,'super','student','delete'),(18,'super','parent','create'),(19,'super','parent','read'),(20,'super','parent','update'),(21,'super','parent','delete'),(22,'super','activity','create'),(23,'super','activity','read'),(24,'super','activity','update'),(25,'super','activity','delete'),(26,'super','class','read'),(27,'super','class','delete'),(28,'super','section','read'),(29,'super','subject','create'),(30,'super','class_routine','create'),(31,'super','class_routine','update'),(32,'super','attendance','delete'),(33,'super','student','create'),(34,'super','student','read'),(35,'super','student','update'),(36,'super','student','delete'),(37,'super','parent','create'),(38,'super','parent','read'),(39,'super','parent','update'),(40,'super','parent','delete'),(41,'super','activity','create'),(42,'super','activity','read'),(43,'super','activity','update'),(44,'super','activity','delete'),(45,'super','teacher','create'),(46,'super','teacher','read'),(47,'super','teacher','update'),(48,'super','teacher','delete'),(49,'super','class','create'),(50,'super','class','read'),(51,'super','class','update'),(52,'super','class','delete'),(53,'super','section','create'),(54,'super','section','read'),(55,'super','section','update'),(56,'super','section','delete'),(57,'super','subject','create'),(58,'super','subject','read'),(59,'super','subject','update'),(60,'super','subject','delete'),(61,'super','class_routine','create'),(62,'super','class_routine','read'),(63,'super','class_routine','update'),(64,'super','class_routine','delete'),(65,'super','attendance','create'),(66,'super','attendance','read'),(67,'super','attendance','update'),(68,'super','attendance','delete'),(69,'super','exam','create'),(70,'super','exam','read'),(71,'super','exam','update'),(72,'super','exam','delete'),(73,'super','grade','create'),(74,'super','grade','read'),(75,'super','grade','update'),(76,'super','grade','delete'),(77,'super','fees_structure','create'),(78,'super','fees_structure','read'),(79,'super','fees_structure','update'),(80,'super','fees_structure','delete'),(81,'super','expense','create'),(82,'super','expense','read'),(83,'super','expense','update'),(84,'super','expense','delete'),(85,'super','payment','create'),(86,'super','payment','read'),(87,'super','payment','update'),(88,'super','payment','delete'),(89,'super','contras','create'),(90,'super','contras','read'),(91,'super','contras','update'),(92,'super','contras','delete'),(93,'super','invoice','create'),(94,'super','invoice','read'),(95,'super','invoice','update'),(96,'super','invoice','delete'),(97,'super','budget','create'),(98,'super','budget','read'),(99,'super','budget','update'),(100,'super','budget','delete');
/*!40000 ALTER TABLE `crud` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-20 12:51:11
