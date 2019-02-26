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
-- Table structure for table `entitlement`
--

DROP TABLE IF EXISTS `entitlement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entitlement` (
  `entitlement_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `login_type_id` int(10) NOT NULL,
  `derivative_id` int(100) NOT NULL,
  PRIMARY KEY (`entitlement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entitlement`
--

LOCK TABLES `entitlement` WRITE;
/*!40000 ALTER TABLE `entitlement` DISABLE KEYS */;
INSERT INTO `entitlement` VALUES (1,'dashboard',1,0),(2,'student',1,0),(3,'student_admission',1,2),(4,'student_bulk_admission',1,2),(5,'all_student_information',1,2),(17,'teacher',1,0),(18,'parent',1,0),(19,'view_parents',1,18),(20,'parents_activity',1,18),(21,'classes',1,0),(22,'manage_classes',1,21),(23,'manage_sections',1,21),(24,'subject',1,0),(36,'class_routine',1,0),(37,'manage_attendance',1,0),(38,'exams',1,0),(39,'exam_list',1,38),(40,'exam_grades',1,38),(41,'manage_marks',1,38),(42,'send_marks_by_sms',1,38),(43,'tabulation_sheet',1,38),(44,'accounting',1,0),(45,'fees_structure',1,44),(46,'create_invoice',1,44),(47,'students_income',1,44),(48,'other_income',1,44),(49,'school_expenses',1,44),(50,'cash_book',1,44),(51,'budget',1,44),(52,'monthly_reconciliation',1,44),(53,'financial_report',1,44),(54,'library',1,0),(55,'transport',1,0),(56,'dormitory',1,0),(57,'noticeboard',1,0),(58,'messages',1,0),(59,'settings',1,0),(60,'general_settings',1,59),(61,'sms_settings',1,59),(62,'language_settings',1,59),(63,'school_settings',1,59),(64,'user_profiles',1,59),(65,'administrator',1,0),(66,'manage_accounts',1,0),(67,'add_subject',1,24),(68,'edit_student',1,2),(69,'promote_student',1,2),(70,'demote_student',1,2),(71,'suspend_student',1,2),(72,'unsuspend_student',1,2),(73,'delete_student',1,2),(74,'add_teacher',1,17),(75,'edit_teacher',1,17),(76,'delete_teacher',1,17),(77,'add_parent',1,18),(78,'edit_parent',1,18),(79,'assign_beneficiary',1,18),(80,'delete_parent',1,18),(81,'add_activity',1,18),(82,'edit_activity',1,18),(83,'mark_targeted_participants',1,18),(84,'mark_attendance',1,18),(85,'print_activty_attendance',1,18),(86,'add_class',1,21),(87,'edit_class',1,21),(88,'delete_class',1,21),(89,'add_section',1,21),(90,'edit_section',1,21),(91,'delete_section',1,21),(92,'add_subject',1,24),(93,'edit_subject',1,24),(94,'delete_subject',1,24),(95,'add_class_routine',1,36),(96,'delete_class_routine',1,36),(97,'mark_routine_attended',1,36),(98,'edit_class_routine',1,36),(99,'update_class_attendance',1,37),(100,'show_class_attendance',1,37),(101,'add_exam',1,38),(102,'edit_exam',1,38),(103,'delete_exam',1,38),(104,'add_grade',1,38),(105,'edit_grade',1,38),(106,'delete_grade',1,38),(107,'add_fees_structure',1,44),(108,'edit_fee_structure',1,44),(109,'add_fee_structure_item',1,44),(110,'delete_fee_structure',1,44),(111,'take_student_payment',1,44),(112,'edit_invoice',1,44),(113,'delete_or_cancel_invoice',1,44),(114,'add_over_note',1,44),(115,'reclaim_cancelled_invoice',1,44),(116,'add_none_student_income',1,44),(117,'reverse_none_student_income',1,44),(118,'add_expense',1,44),(119,'reverse_expense',1,44),(120,'add_contra_entry',1,44),(121,'create_bank_reconciliation_statement',1,44),(122,'create_budget_item',1,44),(123,'edit_reconciliation',1,44),(124,'edit_book',1,54),(125,'delete_book',1,54),(126,'add_book',1,54),(127,'add_transport',1,55),(128,'delete_transport',1,55),(129,'edit_transport',1,55),(130,'add_dormitory',1,56),(131,'edit_dormitory',1,56),(132,'delete_dormitory',1,56),(133,'show_dormitory',1,56),(134,'show_books',1,54),(135,'show_transport',1,55),(136,'show_events',1,57),(137,'edit_event',1,57),(138,'add_event',1,57),(139,'delete_event',1,57),(140,'delete_profile',1,59),(141,'edit_profile',1,59),(142,'show_teacher',1,17),(143,'show_subject',1,24),(144,'show_class_routine',1,36),(145,'set_up_entitlement',1,59),(146,'promote_teacher_to_user',1,17),(147,'reset_password',1,66),(148,'assign_profile',1,66),(149,'dashboard',2,0),(152,'student',2,0),(157,'student_admission',2,152),(158,'all_student_information',2,152),(159,'edit_student',2,152),(160,'promote_student',2,152),(161,'demote_student',2,152),(162,'suspend_student',2,152),(163,'unsuspend_student',2,152),(164,'delete_student',2,152),(165,'teacher',2,0),(166,'parent',2,0),(167,'view_parents',2,166),(168,'parents_activity',2,166),(169,'add_parent',2,166),(170,'edit_parent',2,166),(171,'delete_parent',2,166),(172,'assign_beneficiary',2,166);
/*!40000 ALTER TABLE `entitlement` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-20 12:51:08
