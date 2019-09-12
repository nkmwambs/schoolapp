-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

CREATE TABLE `access` (
  `access_id` int(100) NOT NULL AUTO_INCREMENT,
  `entitlement_id` int(100) NOT NULL,
  `profile_id` int(100) NOT NULL,
  PRIMARY KEY (`access_id`),
  KEY `entitlement_id` (`entitlement_id`),
  KEY `profile_id` (`profile_id`),
  CONSTRAINT `access_ibfk_1` FOREIGN KEY (`entitlement_id`) REFERENCES `entitlement` (`entitlement_id`),
  CONSTRAINT `access_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `accounts` (
  `accounts_id` int(10) NOT NULL AUTO_INCREMENT,
  `numeric_code` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `opening_balance` decimal(10,2) NOT NULL,
  `opening_date` date DEFAULT NULL,
  PRIMARY KEY (`accounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `activity` (
  `activity_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `stmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `activity_attendance` (
  `activity_attendance_id` int(100) NOT NULL AUTO_INCREMENT,
  `activity_id` int(100) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `expected` tinyint(5) NOT NULL,
  `attendance` int(5) NOT NULL COMMENT '0=Absent,1=Not Attending, 2=Attended',
  PRIMARY KEY (`activity_attendance_id`),
  KEY `activity_id` (`activity_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `activity_attendance_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`),
  CONSTRAINT `activity_attendance_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`),
  CONSTRAINT `activity_attendance_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sex` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_approver` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`(100))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `app` (
  `app_id` int(100) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(20) NOT NULL,
  `dsn` varchar(20) NOT NULL,
  `hostname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `database` varchar(20) NOT NULL,
  `dbdriver` varchar(20) NOT NULL,
  `dbprefix` varchar(20) NOT NULL,
  `pconnect` varchar(20) NOT NULL,
  `db_debug` varchar(20) NOT NULL,
  `cache_on` varchar(20) NOT NULL,
  `cachedir` varchar(20) NOT NULL,
  `char_set` varchar(20) NOT NULL,
  `dbcollat` varchar(20) NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `approval` (
  `approval_id` int(100) NOT NULL AUTO_INCREMENT,
  `affected_table_name` varchar(50) NOT NULL,
  `affected_record_id` int(100) NOT NULL,
  `affected_table_field` varchar(50) NOT NULL,
  `affected_table_field_value` varchar(20) NOT NULL,
  `action_to_approve` varchar(20) NOT NULL,
  `approval_detail` longtext NOT NULL,
  `approval_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=new,1=approved,2=effected',
  `createdby` int(100) NOT NULL,
  `lastmodifiedby` int(100) NOT NULL,
  `createddate` date NOT NULL,
  `lastmodifieddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`approval_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `approval_request` (
  `approval_request_id` int(100) NOT NULL AUTO_INCREMENT,
  `record_type_id` int(100) NOT NULL COMMENT 'Table that originates the request e.g. Invoice',
  `record_type_primary_id` int(100) NOT NULL,
  `request_type_id` int(100) NOT NULL COMMENT '1-Create, 2-Update, 3-Delete, 4- Reverse/ Cancel, 5 - Reinstate',
  `status` int(5) NOT NULL DEFAULT '0' COMMENT '0-new,1-approved,2-declined,3-reinstated, 4-implemented',
  `created_date` date NOT NULL,
  `last_modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(100) NOT NULL,
  `last_modified_by` int(100) NOT NULL,
  `approved_by` int(100) NOT NULL,
  PRIMARY KEY (`approval_request_id`),
  KEY `record_type_id` (`record_type_id`),
  KEY `request_type_id` (`request_type_id`),
  CONSTRAINT `approval_request_ibfk_1` FOREIGN KEY (`record_type_id`) REFERENCES `record_type` (`record_type_id`),
  CONSTRAINT `approval_request_ibfk_2` FOREIGN KEY (`request_type_id`) REFERENCES `request_type` (`request_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `approval_request_messaging` (
  `approval_request_messaging_id` int(100) NOT NULL AUTO_INCREMENT,
  `approval_request_id` int(100) NOT NULL,
  `sender_id` int(100) NOT NULL,
  `recipient_id` int(100) NOT NULL,
  `message` longtext NOT NULL,
  `created_date` date NOT NULL,
  `last_modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`approval_request_messaging_id`),
  KEY `approval_request_id` (`approval_request_id`),
  CONSTRAINT `approval_request_messaging_ibfk_1` FOREIGN KEY (`approval_request_id`) REFERENCES `approval_request` (`approval_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `morning` int(11) NOT NULL COMMENT '0 undefined , 1 present , 2  absent',
  `afternoon` int(11) NOT NULL COMMENT '	0 undefined , 1 present , 2 absent',
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `author` longtext COLLATE utf8_unicode_ci NOT NULL,
  `class_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `budget` (
  `budget_id` int(100) NOT NULL AUTO_INCREMENT,
  `expense_category_id` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `fy` int(5) NOT NULL,
  `terms_id` int(100) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `often` int(10) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `smtp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_id`),
  KEY `expense_category_id` (`expense_category_id`),
  KEY `terms_id` (`terms_id`),
  CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_category` (`expense_category_id`),
  CONSTRAINT `budget_ibfk_2` FOREIGN KEY (`terms_id`) REFERENCES `terms` (`terms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `budget_schedule` (
  `budget_schedule_id` int(100) NOT NULL AUTO_INCREMENT,
  `budget_id` int(100) NOT NULL,
  `month` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `stmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_schedule_id`),
  KEY `budget_id` (`budget_id`),
  CONSTRAINT `budget_schedule_ibfk_1` FOREIGN KEY (`budget_id`) REFERENCES `budget` (`budget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `caregiver` (
  `caregiver_id` int(100) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`caregiver_id`),
  KEY `student_id` (`student_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `caregiver_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  CONSTRAINT `caregiver_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `name_numeric` tinyint(4) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `class_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `class_routine` (
  `class_routine_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `time_start` int(11) NOT NULL,
  `time_end` int(11) NOT NULL,
  `time_start_min` int(11) NOT NULL,
  `time_end_min` int(11) NOT NULL,
  `day` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`class_routine_id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `class_routine_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  CONSTRAINT `class_routine_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `class_routine_attendance` (
  `class_routine_attendance_id` int(100) NOT NULL AUTO_INCREMENT,
  `class_routine_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`class_routine_attendance_id`),
  KEY `class_routine_id` (`class_routine_id`),
  CONSTRAINT `class_routine_attendance_ibfk_1` FOREIGN KEY (`class_routine_id`) REFERENCES `class_routine` (`class_routine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `crud` (
  `crud_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_access` varchar(20) NOT NULL,
  `feature` varchar(20) NOT NULL,
  `operation` varchar(20) NOT NULL,
  PRIMARY KEY (`crud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `document` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `file_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `file_type` longtext COLLATE utf8_unicode_ci NOT NULL,
  `class_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `dormitory` (
  `dormitory_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `number_of_room` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`dormitory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `entitlement` (
  `entitlement_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `login_type_id` int(10) NOT NULL,
  `derivative_id` int(100) NOT NULL,
  `visibility` int(100) NOT NULL DEFAULT '1',
  PRIMARY KEY (`entitlement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` longtext COLLATE utf8_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `expense_category` (
  `expense_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `income_category_id` int(100) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`expense_category_id`),
  KEY `income_category_id` (`income_category_id`),
  CONSTRAINT `expense_category_ibfk_1` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `expense_variance_note` (
  `expense_variance_note_id` int(100) NOT NULL AUTO_INCREMENT,
  `month` date NOT NULL,
  `income_category_id` int(100) NOT NULL,
  `note` longtext NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`expense_variance_note_id`),
  KEY `income_category_id` (`income_category_id`),
  CONSTRAINT `expense_variance_note_ibfk_1` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `fees_structure` (
  `fees_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `class_id` int(10) NOT NULL,
  `yr` int(10) NOT NULL,
  `term` int(10) NOT NULL,
  PRIMARY KEY (`fees_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `fees_structure_details` (
  `detail_id` int(10) NOT NULL AUTO_INCREMENT,
  `pay_order` int(50) NOT NULL DEFAULT '0',
  `name` longtext NOT NULL,
  `fees_id` int(10) NOT NULL,
  `income_category_id` int(100) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `income_category_id` (`income_category_id`),
  KEY `fees_id` (`fees_id`),
  CONSTRAINT `fees_structure_details_ibfk_1` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`income_category_id`),
  CONSTRAINT `fees_structure_details_ibfk_2` FOREIGN KEY (`fees_id`) REFERENCES `fees_structure` (`fees_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `grade` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `grade_point` longtext COLLATE utf8_unicode_ci NOT NULL,
  `mark_from` int(11) NOT NULL,
  `mark_upto` int(11) NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `income_categories` (
  `income_category_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `opening_balance` decimal(10,2) NOT NULL,
  `default_category` int(5) NOT NULL DEFAULT '0',
  `status` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `yr` longtext COLLATE utf8_unicode_ci NOT NULL,
  `term` longtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL COMMENT 'fees structure amount less transport',
  `amount_due` int(11) NOT NULL COMMENT 'amount liable to pay plus transport',
  `creation_timestamp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'paid, excess, unpaid or cancelled',
  `carry_forward` int(11) NOT NULL DEFAULT '0',
  `transitioned` int(11) NOT NULL DEFAULT '0',
  `last_approval_request_id` int(100) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `invoice_details` (
  `invoice_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(200) NOT NULL,
  `detail_id` int(200) NOT NULL,
  `amount_due` int(200) NOT NULL,
  PRIMARY KEY (`invoice_details_id`),
  KEY `detail_id` (`detail_id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `invoice_details_ibfk_1` FOREIGN KEY (`detail_id`) REFERENCES `fees_structure_details` (`detail_id`),
  CONSTRAINT `invoice_details_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `language` (
  `phrase_id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` longtext COLLATE utf8_unicode_ci NOT NULL,
  `english` longtext COLLATE utf8_unicode_ci NOT NULL,
  `bengali` longtext COLLATE utf8_unicode_ci NOT NULL,
  `spanish` longtext COLLATE utf8_unicode_ci NOT NULL,
  `arabic` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dutch` longtext COLLATE utf8_unicode_ci NOT NULL,
  `russian` longtext COLLATE utf8_unicode_ci NOT NULL,
  `chinese` longtext COLLATE utf8_unicode_ci NOT NULL,
  `turkish` longtext COLLATE utf8_unicode_ci NOT NULL,
  `portuguese` longtext COLLATE utf8_unicode_ci NOT NULL,
  `hungarian` longtext COLLATE utf8_unicode_ci NOT NULL,
  `french` longtext COLLATE utf8_unicode_ci NOT NULL,
  `greek` longtext COLLATE utf8_unicode_ci NOT NULL,
  `german` longtext COLLATE utf8_unicode_ci NOT NULL,
  `italian` longtext COLLATE utf8_unicode_ci NOT NULL,
  `thai` longtext COLLATE utf8_unicode_ci NOT NULL,
  `urdu` longtext COLLATE utf8_unicode_ci NOT NULL,
  `hindi` longtext COLLATE utf8_unicode_ci NOT NULL,
  `latin` longtext COLLATE utf8_unicode_ci NOT NULL,
  `indonesian` longtext COLLATE utf8_unicode_ci NOT NULL,
  `japanese` longtext COLLATE utf8_unicode_ci NOT NULL,
  `korean` longtext COLLATE utf8_unicode_ci NOT NULL,
  `swahili` longtext COLLATE utf8_unicode_ci,
  `Kikuyu` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`phrase_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `lesson_plan` (
  `lesson_plan_id` int(100) NOT NULL AUTO_INCREMENT,
  `scheme_id` int(100) NOT NULL,
  `planned_date` date NOT NULL,
  `attendance_date` date DEFAULT NULL,
  `class_routine_id` int(11) DEFAULT NULL,
  `roll` int(100) NOT NULL,
  `core_competencies` longtext NOT NULL,
  `introduction` longtext NOT NULL,
  `lesson_development` longtext NOT NULL,
  `conclusion` longtext NOT NULL,
  `summary` longtext NOT NULL,
  `reflection` longtext,
  `signed_off_by` int(100) DEFAULT NULL,
  `signed_off_date` date DEFAULT NULL,
  `createdby` int(100) NOT NULL,
  `lastmodifiedby` int(100) NOT NULL,
  `createddate` datetime NOT NULL,
  `lastmodifieddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lesson_plan_id`),
  KEY `scheme_id` (`scheme_id`),
  KEY `createdby` (`createdby`),
  KEY `lastmodifiedby` (`lastmodifiedby`),
  KEY `signed_off_by` (`signed_off_by`),
  CONSTRAINT `lesson_plan_ibfk_1` FOREIGN KEY (`scheme_id`) REFERENCES `scheme` (`scheme_id`),
  CONSTRAINT `lesson_plan_ibfk_4` FOREIGN KEY (`createdby`) REFERENCES `user` (`user_id`),
  CONSTRAINT `lesson_plan_ibfk_5` FOREIGN KEY (`lastmodifiedby`) REFERENCES `user` (`user_id`),
  CONSTRAINT `lesson_plan_ibfk_6` FOREIGN KEY (`signed_off_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `login_type` (
  `login_type_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`login_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `mark` (
  `mark_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `mark_obtained` int(11) NOT NULL DEFAULT '0',
  `mark_total` int(11) NOT NULL DEFAULT '100',
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mark_id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  KEY `class_id` (`class_id`),
  KEY `exam_id` (`exam_id`),
  CONSTRAINT `mark_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  CONSTRAINT `mark_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  CONSTRAINT `mark_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  CONSTRAINT `mark_ibfk_4` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext NOT NULL,
  `message` longtext NOT NULL,
  `sender` longtext NOT NULL,
  `timestamp` longtext NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 unread 1 read',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `message_thread` (
  `message_thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sender` longtext COLLATE utf8_unicode_ci NOT NULL,
  `reciever` longtext COLLATE utf8_unicode_ci NOT NULL,
  `last_message_timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`message_thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `noticeboard` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `notice` longtext COLLATE utf8_unicode_ci NOT NULL,
  `create_timestamp` int(11) NOT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `overpay` (
  `overpay_id` int(100) NOT NULL AUTO_INCREMENT,
  `student_id` int(100) NOT NULL,
  `transaction_id` int(100) NOT NULL,
  `amount` int(10) NOT NULL,
  `amount_due` int(10) NOT NULL,
  `description` longtext NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active' COMMENT 'active,cleared',
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`overpay_id`),
  KEY `student_id` (`student_id`),
  KEY `income_id` (`transaction_id`),
  CONSTRAINT `overpay_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  CONSTRAINT `overpay_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `overpay_charge_detail` (
  `overpay_detail_id` int(100) NOT NULL AUTO_INCREMENT,
  `overpay_id` int(100) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `amount_redeemed` int(100) NOT NULL,
  `createddate` date NOT NULL,
  `createdby` int(100) NOT NULL,
  `lastmodifieddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastmodifiedby` int(100) NOT NULL,
  PRIMARY KEY (`overpay_detail_id`),
  KEY `overpay_id` (`overpay_id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `overpay_charge_detail_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`),
  CONSTRAINT `overpay_charge_detail_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `parent` (
  `parent_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `relationship_id` int(100) NOT NULL,
  `care_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `profession` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`parent_id`),
  KEY `relationship_id` (`relationship_id`),
  CONSTRAINT `parent_ibfk_1` FOREIGN KEY (`relationship_id`) REFERENCES `relationship` (`relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `profile` (
  `profile_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `login_type_id` int(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `reconcile` (
  `reconcile_id` int(100) NOT NULL AUTO_INCREMENT,
  `statement_amount` decimal(10,2) NOT NULL,
  `suspense_balance` decimal(10,2) NOT NULL,
  `month` date NOT NULL,
  `creator_notes` longtext NOT NULL,
  `approver_notes` longtext NOT NULL,
  `alert_sent_to_approver` int(5) NOT NULL DEFAULT '0' COMMENT '0=not sent, 1=sent',
  `status` int(5) NOT NULL DEFAULT '0' COMMENT '0=submitted,1=declined,2=approved',
  `created_by` int(100) NOT NULL,
  `last_modified_by` int(100) NOT NULL,
  `last_modified_date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reconcile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `record_type` (
  `record_type_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `reference_field` varchar(100) NOT NULL,
  PRIMARY KEY (`record_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `relationship` (
  `relationship_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `request_type` (
  `request_type_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`request_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `scheme` (
  `scheme_id` int(100) NOT NULL AUTO_INCREMENT,
  `scheme_header_id` int(100) NOT NULL,
  `week` int(10) NOT NULL,
  `lesson` int(10) NOT NULL,
  `strand` longtext NOT NULL,
  `sub_strand` longtext NOT NULL,
  `learning_outcomes` longtext NOT NULL,
  `inquiry_question` longtext NOT NULL,
  `learning_experiences` longtext NOT NULL,
  `learning_resources` longtext NOT NULL,
  `assessment` longtext NOT NULL,
  `createdby` int(100) NOT NULL,
  `lastmodifiedby` int(100) NOT NULL,
  `createddate` datetime NOT NULL,
  `lastmodifieddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`scheme_id`),
  KEY `scheme_header_id` (`scheme_header_id`),
  KEY `createdby` (`createdby`),
  KEY `lastmodifiedby` (`lastmodifiedby`),
  CONSTRAINT `scheme_ibfk_1` FOREIGN KEY (`scheme_header_id`) REFERENCES `scheme_header` (`scheme_header_id`),
  CONSTRAINT `scheme_ibfk_2` FOREIGN KEY (`createdby`) REFERENCES `user` (`user_id`),
  CONSTRAINT `scheme_ibfk_3` FOREIGN KEY (`lastmodifiedby`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `scheme_header` (
  `scheme_header_id` int(100) NOT NULL AUTO_INCREMENT,
  `class_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `term_id` int(100) NOT NULL,
  `year` int(4) NOT NULL,
  `createdby` int(100) NOT NULL,
  `lastmodifiedby` int(100) NOT NULL,
  `createddate` datetime NOT NULL,
  `lastmodifieddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`scheme_header_id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  KEY `term_id` (`term_id`),
  KEY `createdby` (`createdby`),
  KEY `lastmodifiedby` (`lastmodifiedby`),
  CONSTRAINT `scheme_header_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  CONSTRAINT `scheme_header_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  CONSTRAINT `scheme_header_ibfk_3` FOREIGN KEY (`term_id`) REFERENCES `terms` (`terms_id`),
  CONSTRAINT `scheme_header_ibfk_4` FOREIGN KEY (`createdby`) REFERENCES `user` (`user_id`),
  CONSTRAINT `scheme_header_ibfk_5` FOREIGN KEY (`lastmodifiedby`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `section` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `nick_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`section_id`),
  KEY `class_id` (`class_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `section_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  CONSTRAINT `section_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `sms_delivery` (
  `sms_delivery_id` int(100) NOT NULL AUTO_INCREMENT,
  `message_id` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `networkCode` varchar(50) NOT NULL,
  `failureReason` varchar(50) NOT NULL,
  `retryCount` int(50) NOT NULL,
  PRIMARY KEY (`sms_delivery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `religion` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `blood_group` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(10) NOT NULL,
  `parent_id` int(100) NOT NULL,
  `roll` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `upi_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `transport_id` int(10) NOT NULL,
  `dormitory_id` int(50) NOT NULL,
  `dormitory_room_number` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `roll` (`roll`(20)),
  KEY `class_id` (`class_id`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `birthday` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sex` longtext COLLATE utf8_unicode_ci NOT NULL,
  `religion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `blood_group` longtext COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `terms` (
  `terms_id` int(100) NOT NULL AUTO_INCREMENT,
  `term_number` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_month` int(2) NOT NULL,
  `end_month` int(2) NOT NULL,
  PRIMARY KEY (`terms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transaction` (
  `transaction_id` int(100) NOT NULL AUTO_INCREMENT,
  `t_date` date NOT NULL,
  `batch_number` varchar(20) NOT NULL,
  `invoice_id` int(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `payee` varchar(100) NOT NULL,
  `transaction_type_id` int(20) NOT NULL,
  `transaction_method_id` int(20) NOT NULL COMMENT '1-Cash, 2-Bank',
  `cheque_no` varchar(100) NOT NULL COMMENT 'Cheque number or any reference number',
  `amount` decimal(10,2) NOT NULL,
  `cleared` int(5) NOT NULL COMMENT '0-oustanding,1-cleared',
  `clearedMonth` date NOT NULL,
  `is_cancelled` int(5) NOT NULL DEFAULT '0',
  `reversing_batch_number` varchar(20) NOT NULL,
  `createddate` datetime NOT NULL,
  `createdby` int(100) NOT NULL,
  `lastmodifieddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastmodifiedby` int(100) NOT NULL,
  `last_approval_request_id` int(100) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `transaction_type_id` (`transaction_type_id`),
  KEY `transaction_method_id` (`transaction_method_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_type` (`transaction_type_id`),
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`transaction_method_id`) REFERENCES `transaction_method` (`transaction_method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transaction_detail` (
  `transaction_detail_id` int(100) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(100) NOT NULL,
  `invoice_details_id` int(200) NOT NULL,
  `expense_category_id` int(100) NOT NULL,
  `income_category_id` int(100) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `detail_description` varchar(100) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`transaction_detail_id`),
  KEY `transaction_id` (`transaction_id`),
  CONSTRAINT `transaction_detail_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transaction_method` (
  `transaction_method_id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `can_be_selected` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`transaction_method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transaction_type` (
  `transaction_type_id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `can_be_cancelled` int(5) NOT NULL DEFAULT '1' COMMENT '1=can be cancelled, 0= can''t be cancelled',
  PRIMARY KEY (`transaction_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transition` (
  `transition_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`transition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transition_detail` (
  `transition_detail_id` int(100) NOT NULL AUTO_INCREMENT,
  `transition_id` int(100) NOT NULL,
  `student_id` int(11) NOT NULL,
  `transition_date` date NOT NULL,
  `reason` varchar(200) NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`transition_detail_id`),
  KEY `transition_id` (`transition_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `transition_detail_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  CONSTRAINT `transition_detail_ibfk_2` FOREIGN KEY (`transition_id`) REFERENCES `transition` (`transition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transport` (
  `transport_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `number_of_vehicle` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `route_fare` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`transport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `user` (
  `user_id` int(100) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `login_type_id` tinyint(10) NOT NULL,
  `profile_id` tinyint(5) NOT NULL,
  `type_user_id` int(100) NOT NULL,
  `app_id` int(100) NOT NULL DEFAULT '2',
  `auth` tinyint(5) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2019-09-12 06:44:33
