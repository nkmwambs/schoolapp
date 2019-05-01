-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `schoolapp` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `schoolapp`;

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

INSERT INTO `access` (`access_id`, `entitlement_id`, `profile_id`) VALUES
(21,	366,	1),
(22,	367,	1),
(23,	370,	1),
(24,	371,	1),
(25,	373,	1),
(26,	374,	1),
(27,	375,	1),
(28,	376,	1),
(29,	377,	1),
(30,	379,	1),
(31,	380,	1),
(32,	381,	1),
(33,	382,	1),
(34,	383,	1),
(35,	385,	1),
(36,	386,	1),
(37,	387,	1),
(38,	388,	1),
(39,	389,	1),
(40,	390,	1),
(41,	391,	1),
(42,	392,	1),
(43,	396,	1),
(44,	395,	1),
(47,	394,	1),
(48,	393,	1),
(49,	397,	1),
(50,	399,	1),
(51,	400,	1),
(52,	401,	1),
(53,	402,	1),
(54,	403,	1),
(55,	404,	1),
(56,	405,	1),
(57,	363,	1),
(58,	406,	1),
(59,	407,	1),
(60,	408,	1),
(61,	409,	1),
(62,	410,	1),
(63,	411,	1),
(64,	412,	1),
(65,	413,	1),
(66,	414,	1),
(67,	415,	1),
(68,	416,	1),
(69,	417,	1),
(70,	418,	1),
(71,	419,	1),
(72,	420,	1),
(74,	422,	1),
(75,	421,	1),
(77,	365,	1),
(78,	368,	1),
(79,	423,	1),
(80,	424,	1),
(81,	425,	1),
(82,	426,	1),
(83,	427,	1);

CREATE TABLE `accounts` (
  `accounts_id` int(10) NOT NULL AUTO_INCREMENT,
  `numeric_code` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `opening_balance` decimal(10,2) NOT NULL,
  `opening_date` date DEFAULT NULL,
  PRIMARY KEY (`accounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `accounts` (`accounts_id`, `numeric_code`, `name`, `opening_balance`, `opening_date`) VALUES
(1,	1,	'cash',	65000.00,	'2017-03-01'),
(2,	2,	'bank',	342870.23,	'2017-03-01');

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
  `parent_id` int(100) NOT NULL,
  `expected` tinyint(5) NOT NULL,
  `attendance` int(5) NOT NULL COMMENT '0=Absent,1=Not Attending, 2=Attended',
  PRIMARY KEY (`activity_attendance_id`),
  KEY `activity_id` (`activity_id`),
  CONSTRAINT `activity_attendance_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `birthday` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sex` longtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext COLLATE utf8_unicode_ci NOT NULL,
  `level` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `admin` (`admin_id`, `name`, `email`, `birthday`, `sex`, `phone`, `level`) VALUES
(1,	'Nicodemus Karisa',	'nkmwambs@gmail.com',	'10/12/1980',	'male',	'0711808078',	'super');

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL COMMENT '0 undefined , 1 present , 2  absent',
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
  `qty` decimal(10,2) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `often` int(10) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `smtp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_id`),
  KEY `expense_category_id` (`expense_category_id`),
  CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_category` (`expense_category_id`)
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

INSERT INTO `entitlement` (`entitlement_id`, `name`, `login_type_id`, `derivative_id`, `visibility`) VALUES
(363,	'dashboard',	1,	0,	1),
(364,	'student',	1,	0,	1),
(365,	'student_admission',	1,	364,	1),
(366,	'bulk_student_admission',	1,	364,	1),
(367,	'all_student_information',	1,	364,	1),
(368,	'teacher',	1,	0,	1),
(369,	'parent',	1,	0,	1),
(370,	'view_parents',	1,	369,	1),
(371,	'parents_activity',	1,	369,	1),
(372,	'classes',	1,	0,	1),
(373,	'manage_classes',	1,	372,	1),
(374,	'manage_sections',	1,	372,	1),
(375,	'subject',	1,	0,	1),
(376,	'class_routine',	1,	0,	1),
(377,	'manage_attendance',	1,	0,	1),
(378,	'examination',	1,	0,	1),
(379,	'examination_list',	1,	378,	1),
(380,	'examination_grades',	1,	378,	1),
(381,	'manage_marks',	1,	378,	1),
(382,	'send_marks_by_sms',	1,	378,	1),
(383,	'tabulation_sheet',	1,	378,	1),
(384,	'accounting',	1,	0,	1),
(385,	'fees_structure',	1,	384,	1),
(386,	'cash_book',	1,	384,	1),
(387,	'budget',	1,	384,	1),
(388,	'monthly_reconciliation',	1,	384,	1),
(389,	'financial_report',	1,	384,	1),
(390,	'fund_balance_report',	1,	384,	1),
(391,	'expense_variance_report',	1,	384,	1),
(392,	'income_variance_report',	1,	384,	1),
(393,	'library',	1,	0,	1),
(394,	'transport',	1,	0,	1),
(395,	'dormitory',	1,	0,	1),
(396,	'noticeboard',	1,	0,	1),
(397,	'messages',	1,	0,	1),
(398,	'settings',	1,	0,	1),
(399,	'general_settings',	1,	398,	1),
(400,	'sms_settings',	1,	398,	1),
(401,	'language_settings',	1,	398,	1),
(402,	'school_settings',	1,	398,	1),
(403,	'user_profiles',	1,	398,	1),
(404,	'administrator',	1,	0,	1),
(405,	'manage_accounts',	1,	0,	1),
(406,	'create_transaction',	1,	363,	1),
(407,	'student_count',	1,	363,	1),
(408,	'teachers_count',	1,	363,	1),
(409,	'parents_count',	1,	363,	1),
(410,	'today_students_attendance',	1,	363,	1),
(411,	'unpaid_invoices_count',	1,	363,	1),
(412,	'total_fees_balance',	1,	363,	1),
(413,	'total_fees_received',	1,	363,	1),
(414,	'total_invoices_cleared',	1,	363,	1),
(415,	'years_expense_to_date',	1,	363,	1),
(416,	'budget_to_date',	1,	363,	1),
(417,	'percent_class_attendance',	1,	363,	1),
(418,	'percent_lesson_covered',	1,	363,	1),
(419,	'event_schedule',	1,	363,	1),
(420,	'edit_student',	1,	364,	1),
(421,	'promote_student',	1,	364,	1),
(422,	'suspend_student',	1,	364,	1),
(423,	'promote_teacher_to_user',	1,	368,	1),
(424,	'reset_teacher_password',	1,	368,	1),
(425,	'assign_profile',	1,	368,	1),
(426,	'edit_teacher',	1,	368,	1),
(427,	'delete_teacher',	1,	368,	1),
(428,	'add_parent',	1,	369,	1),
(429,	'edit_parent',	1,	369,	1),
(430,	'delete_parent',	1,	369,	1),
(431,	'assign_beneficiary',	1,	369,	1);

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` longtext COLLATE utf8_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `expense` (
  `expense_id` int(200) NOT NULL AUTO_INCREMENT,
  `batch_number` int(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `payee` varchar(200) NOT NULL,
  `t_date` date NOT NULL,
  `method` varchar(20) NOT NULL,
  `cheque_no` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `cleared` tinyint(5) NOT NULL COMMENT '0-oustanding,1-cleared',
  `clearedMonth` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `expense_category` (
  `expense_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `income_category_id` int(100) NOT NULL,
  PRIMARY KEY (`expense_category_id`),
  KEY `income_category_id` (`income_category_id`),
  CONSTRAINT `expense_category_ibfk_1` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `expense_details` (
  `expense_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `expense_id` int(200) NOT NULL,
  `qty` int(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  PRIMARY KEY (`expense_details_id`),
  KEY `expense_id` (`expense_id`),
  KEY `expense_category_id` (`expense_category_id`),
  CONSTRAINT `expense_details_ibfk_1` FOREIGN KEY (`expense_id`) REFERENCES `expense` (`expense_id`),
  CONSTRAINT `expense_details_ibfk_2` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_category` (`expense_category_id`)
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
  PRIMARY KEY (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `yr` longtext COLLATE utf8_unicode_ci NOT NULL,
  `term` longtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL COMMENT 'fees structure amount less transport',
  `amount_due` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'amount liable to pay plus transport',
  `amount_paid` int(100) NOT NULL,
  `balance` int(100) NOT NULL,
  `creation_timestamp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'paid, excess, unpaid or cancelled',
  `carry_forward` int(11) NOT NULL DEFAULT '0' COMMENT '0',
  `transitioned` int(11) NOT NULL COMMENT '0',
  PRIMARY KEY (`invoice_id`),
  KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `invoice_details` (
  `invoice_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `detail_id` int(10) NOT NULL,
  `amount_due` int(200) NOT NULL,
  `amount_paid` int(100) NOT NULL,
  `balance` int(100) NOT NULL,
  `last_payment_id` int(100) NOT NULL,
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

INSERT INTO `login_type` (`login_type_id`, `name`) VALUES
(1,	'admin'),
(2,	'teacher'),
(3,	'student'),
(4,	'parent');

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


CREATE TABLE `opening_balance` (
  `opening_balance_id` int(50) NOT NULL AUTO_INCREMENT,
  `income_category_id` int(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`opening_balance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `other_payment_details` (
  `other_payment_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `qty` int(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `income_category_id` int(100) NOT NULL,
  PRIMARY KEY (`other_payment_details_id`),
  KEY `payment_id` (`payment_id`),
  KEY `income_category_id` (`income_category_id`),
  CONSTRAINT `other_payment_details_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`),
  CONSTRAINT `other_payment_details_ibfk_2` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `overpay` (
  `overpay_id` int(100) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `income_id` int(11) NOT NULL,
  `amount` int(10) NOT NULL,
  `amount_due` int(10) NOT NULL,
  `description` longtext NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active' COMMENT 'active,cleared',
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`overpay_id`),
  KEY `student_id` (`student_id`),
  KEY `income_id` (`income_id`),
  CONSTRAINT `overpay_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  CONSTRAINT `overpay_ibfk_2` FOREIGN KEY (`income_id`) REFERENCES `payment` (`payment_id`)
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
  PRIMARY KEY (`parent_id`),
  KEY `relationship_id` (`relationship_id`),
  CONSTRAINT `parent_ibfk_1` FOREIGN KEY (`relationship_id`) REFERENCES `relationship` (`relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_date` date NOT NULL,
  `batch_number` int(10) NOT NULL,
  `serial` int(10) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payee` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `method` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '1-Cash,2-Bank',
  `payment_type` int(5) NOT NULL COMMENT '1-student fees income,2-other incomes',
  `amount` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cleared` tinyint(5) NOT NULL COMMENT '0-Uncleared,1-Cleared',
  `clearedMonth` date NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `profile` (
  `profile_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `login_type_id` int(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `profile` (`profile_id`, `name`, `login_type_id`, `description`) VALUES
(1,	'Super Admin',	1,	'System Main Administrator'),
(2,	'None Class Teachers',	2,	'None Class Teachers'),
(3,	'Secretary',	1,	'Admin Sec');

CREATE TABLE `reconcile` (
  `reconcile_id` int(100) NOT NULL AUTO_INCREMENT,
  `statement_amount` decimal(10,2) NOT NULL,
  `month` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reconcile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `relationship` (
  `relationship_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`relationship_id`)
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

INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES
(1,	'system_name',	'School Management System'),
(2,	'system_title',	'KPV Academy'),
(3,	'address',	'80-80200 Malindi'),
(4,	'phone',	'254764837462'),
(5,	'paypal_email',	'admin@techsys.com'),
(6,	'currency',	'Kes.'),
(7,	'system_email',	'mwambirenicodemus2017@gmail.com'),
(20,	'active_sms_service',	'disabled'),
(11,	'language',	'english'),
(12,	'text_align',	'left-to-right'),
(13,	'clickatell_user',	''),
(14,	'clickatell_password',	''),
(15,	'clickatell_api_id',	''),
(16,	'skin_colour',	'red'),
(17,	'twilio_account_sid',	''),
(18,	'twilio_auth_token',	''),
(19,	'twilio_sender_phone_number',	''),
(21,	'system_start_date',	'2019-04-01'),
(22,	'version',	'2019040100'),
(23,	'sidebar-collapsed',	'no');

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `birthday` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sex` longtext COLLATE utf8_unicode_ci NOT NULL,
  `religion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `blood_group` longtext COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `father_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `mother_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(10) NOT NULL,
  `parent_id` int(100) NOT NULL,
  `roll` longtext COLLATE utf8_unicode_ci NOT NULL,
  `upi_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `transport_id` int(10) NOT NULL,
  `dormitory_id` int(50) NOT NULL,
  `dormitory_room_number` longtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`student_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `student_payment_details` (
  `student_payment_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `detail_id` int(10) NOT NULL,
  `amount` int(100) NOT NULL,
  `t_date` date NOT NULL,
  PRIMARY KEY (`student_payment_details_id`),
  KEY `payment_id` (`payment_id`),
  KEY `detail_id` (`detail_id`),
  CONSTRAINT `student_payment_details_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`),
  CONSTRAINT `student_payment_details_ibfk_2` FOREIGN KEY (`detail_id`) REFERENCES `fees_structure_details` (`detail_id`)
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

INSERT INTO `terms` (`terms_id`, `term_number`, `name`, `start_month`, `end_month`) VALUES
(1,	1,	'One',	1,	4),
(2,	2,	'Two',	5,	8),
(3,	3,	'Three',	9,	12);

CREATE TABLE `transition` (
  `transition_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`transition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `transition` (`transition_id`, `name`) VALUES
(1,	'transfer'),
(2,	'completion'),
(3,	'suspend');

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
  `auth` tinyint(5) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `email`, `password`, `phone`, `login_type_id`, `profile_id`, `type_user_id`, `auth`) VALUES
(1,	'Nicodemus',	'Karisa',	'nkmwambs@gmail.com',	'compassion12',	'254711808071',	1,	1,	1,	1);

-- 2019-04-29 21:37:57
