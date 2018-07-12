-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `access`;
CREATE TABLE `access` (
  `access_id` int(100) NOT NULL AUTO_INCREMENT,
  `entitlement_id` int(100) NOT NULL,
  `profile_id` int(100) NOT NULL,
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `access` (`access_id`, `entitlement_id`, `profile_id`) VALUES
(1,	64,	1);

DROP TABLE IF EXISTS `accounts`;
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

DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `activity_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `stmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `activity` (`activity_id`, `name`, `description`, `start_date`, `end_date`, `stmp`) VALUES
(5,	'Parents Meeting',	'For all parents and classes',	'2017-11-12',	'2017-11-12',	'2017-11-12 12:33:04'),
(6,	'Prize Giving Day',	'Academic Day',	'2018-04-30',	'2018-04-30',	'2018-04-04 13:43:07'),
(7,	'Fundraising Day',	'For purchasing a school bus',	'2018-06-28',	'2018-06-28',	'2018-06-15 13:57:47'),
(8,	'Closing Day',	'Closing Day',	'2018-06-29',	'2018-06-29',	'2018-06-15 16:33:39');

DROP TABLE IF EXISTS `activity_attendance`;
CREATE TABLE `activity_attendance` (
  `activity_attendance_id` int(100) NOT NULL AUTO_INCREMENT,
  `activity_id` int(100) NOT NULL,
  `parent_id` int(100) NOT NULL,
  `expected` tinyint(5) NOT NULL,
  `attendance` int(5) NOT NULL COMMENT '0=Absent,1=Not Attending, 2=Attended',
  PRIMARY KEY (`activity_attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `activity_attendance` (`activity_attendance_id`, `activity_id`, `parent_id`, `expected`, `attendance`) VALUES
(25,	7,	1,	1,	0),
(26,	7,	3,	1,	1),
(27,	7,	4,	1,	1),
(28,	6,	1,	1,	0),
(29,	6,	4,	1,	1),
(30,	8,	4,	1,	1),
(31,	8,	2,	1,	0);

DROP TABLE IF EXISTS `admin`;
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
(1,	'Nicodemus Karisa',	'mwambirekarisa2017@gmail.com',	'',	'',	'',	'super'),
(2,	'Betty Kanze',	'BYeri@gmail.com',	'03/14/1989',	'female',	'0711909076',	'manager'),
(4,	'James Mulandi',	'JMulandi@gmail.com',	'06/11/1980',	'',	'0711909076',	'manager');

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL COMMENT '0 undefined , 1 present , 2  absent',
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `attendance` (`attendance_id`, `status`, `student_id`, `date`) VALUES
(1,	1,	4,	'2018-04-04'),
(2,	0,	4,	'2018-04-05'),
(3,	1,	1,	'2018-04-20'),
(4,	1,	2,	'2018-04-20'),
(5,	2,	3,	'2018-04-20'),
(6,	1,	4,	'2018-06-14'),
(7,	2,	11,	'2018-06-14'),
(8,	1,	12,	'2018-06-14'),
(9,	1,	13,	'2018-06-14'),
(10,	0,	11,	'2018-07-12'),
(11,	0,	13,	'2018-07-12');

DROP TABLE IF EXISTS `book`;
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


DROP TABLE IF EXISTS `budget`;
CREATE TABLE `budget` (
  `budget_id` int(100) NOT NULL AUTO_INCREMENT,
  `expense_category_id` int(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `fy` int(5) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `often` int(10) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `smtp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `budget_schedule`;
CREATE TABLE `budget_schedule` (
  `budget_schedule_id` int(100) NOT NULL AUTO_INCREMENT,
  `budget_id` int(100) NOT NULL,
  `month` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `stmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `caregiver`;
CREATE TABLE `caregiver` (
  `caregiver_id` int(100) NOT NULL AUTO_INCREMENT,
  `parent_id` int(100) NOT NULL,
  `student_id` int(100) NOT NULL,
  PRIMARY KEY (`caregiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `caregiver` (`caregiver_id`, `parent_id`, `student_id`) VALUES
(12,	5,	11),
(13,	6,	11),
(14,	5,	12),
(15,	6,	12),
(20,	7,	2),
(21,	7,	11),
(25,	3,	4),
(26,	7,	4),
(27,	5,	13);

DROP TABLE IF EXISTS `cashbook`;
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

INSERT INTO `cashbook` (`cashbook_id`, `batch_number`, `t_date`, `description`, `transaction_type`, `account`, `amount`, `timestamp`) VALUES
(1,	180101,	'2018-01-09',	'Student Payment - James Mulandi',	1,	2,	2300.00,	'2018-07-10 19:02:24'),
(2,	180102,	'2018-01-09',	'Student Payment - Joyce Ted',	1,	1,	21400.00,	'2018-07-10 20:39:00'),
(3,	180103,	'2018-01-10',	'School Stationery',	2,	1,	465.00,	'2018-07-10 22:04:43');

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('09b879c5d24645d61a8f9130ef8b939f67652357',	'::1',	1531434387,	'__ci_last_regenerate|i:1531434109;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:9:\"dormitory\";'),
('10f6260e292a88834343052205f7440634d7cfea',	'::1',	1531432272,	'__ci_last_regenerate|i:1531431975;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:4:\"exam\";'),
('1234e0118e2689d72208bc94f199c7b3dcd5fec9',	'::1',	1531433342,	'__ci_last_regenerate|i:1531433075;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"finance\";'),
('199d5f0c56560796df2995c579187050fba4d10f',	'::1',	1531431572,	'__ci_last_regenerate|i:1531431299;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:10:\"attendance\";'),
('19c09ddbe7a7e5a673762f2c17d9ae981a701013',	'::1',	1531335182,	'__ci_last_regenerate|i:1531334884;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('21e1ff29b2080cf562044799fc8aa02ac606b786',	'::1',	1531333112,	'__ci_last_regenerate|i:1531333052;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('24817e0fbe7d506ec2a1c7498720f88e746fc907',	'::1',	1531427338,	'__ci_last_regenerate|i:1531427059;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('25183a301563e41381325d46d935e2a0ab9d1b00',	'::1',	1531425240,	'__ci_last_regenerate|i:1531425029;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('378146caf4f3457893af18a71eaca5afb3670870',	'::1',	1531428972,	'__ci_last_regenerate|i:1531428773;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"student\";'),
('3f691e2ca14e86ca926272c50d2fad77df34c838',	'::1',	1531425903,	'__ci_last_regenerate|i:1531425766;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('4b9b1edf64be747280cb901df528221db93ee40b',	'::1',	1531431918,	'__ci_last_regenerate|i:1531431666;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:4:\"exam\";'),
('4b9ff7db66a96a73bcb9c682dec78b172657f5db',	'::1',	1531368998,	'__ci_last_regenerate|i:1531368822;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('4e6ccc690e3efd1754f1edf470022c432b862a4a',	'::1',	1531428738,	'__ci_last_regenerate|i:1531428464;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('50451ea6192d5c33673dfbb1c1c5ffc049170906',	'::1',	1531428108,	'__ci_last_regenerate|i:1531427838;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"subject\";'),
('53a26b4ed60c9999f6e98e01d8e70ad81b2ba0d4',	'::1',	1531425674,	'__ci_last_regenerate|i:1531425456;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('5c948f5b8757a79ac428881a9382e4201d2d2bf9',	'::1',	1531435912,	'__ci_last_regenerate|i:1531435659;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('611f6ef592de751e89b69dca4a9ad9929745437c',	'::1',	1531432586,	'__ci_last_regenerate|i:1531432303;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"finance\";'),
('67631491b0d5f5fb7fc2e65fd1da90bd0a312a37',	'::1',	1531430968,	'__ci_last_regenerate|i:1531430655;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:5:\"class\";'),
('6fc1ffde283e43e0ea2f8b7983f35872609cb7cc',	'::1',	1531430592,	'__ci_last_regenerate|i:1531430208;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:6:\"parent\";'),
('797135666e59fcb8dbf7e2c7cfb4927c39d173ae',	'::1',	1531333049,	'__ci_last_regenerate|i:1531332750;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('7bc905c0de555854c4eb0475b863587b70e740c8',	'::1',	1531434792,	'__ci_last_regenerate|i:1531434514;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('7e0580d1ff8d07527a09da4feb4b6b35b5a4f6a7',	'::1',	1531335291,	'__ci_last_regenerate|i:1531335192;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('84d692947645b75f207c0aceb735555e6ab0cfae',	'::1',	1531424892,	'__ci_last_regenerate|i:1531424697;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('8519dcf286149fe34248135b42bedf24cf6043e3',	'::1',	1531427833,	'__ci_last_regenerate|i:1531427510;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('8628b11aa27518282d4599b6626b75de0e0488f5',	'::1',	1531435438,	'__ci_last_regenerate|i:1531435143;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('9f8d3b3b5bda4c013e9fcf5a9ae2b69196a0aa04',	'::1',	1531334095,	'__ci_last_regenerate|i:1531333832;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('a570ac576ac6a695aa6f56004ad3f0b0f65504ff',	'::1',	1531423719,	'__ci_last_regenerate|i:1531423676;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('b7b9cebac81f7ffdcf3630ba22cfe71af1ae5aba',	'::1',	1531426417,	'__ci_last_regenerate|i:1531426136;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('ba0c8b37f0dae450caa95ba19e3004e7aa923cba',	'::1',	1531426536,	'__ci_last_regenerate|i:1531426512;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('bd1497e2adb05e6e0aae0427c2a716426125e45f',	'::1',	1531334592,	'__ci_last_regenerate|i:1531334345;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('bed11bfb47685f29c7829b41cd1b2dca1dd0561c',	'::1',	1531333495,	'__ci_last_regenerate|i:1531333494;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('c2975f95cc34401af9a46606e89267f5f4767d06',	'::1',	1531432943,	'__ci_last_regenerate|i:1531432647;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"finance\";'),
('cccfa1adf466403de09105154ab04a892209c021',	'::1',	1531332381,	'__ci_last_regenerate|i:1531332332;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('d08329da9daae723af61be39376d092b94c153ed',	'::1',	1531431228,	'__ci_last_regenerate|i:1531430970;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"subject\";'),
('d388905a7672a8f8b92a5c6143f155e01b00affc',	'::1',	1531435140,	'__ci_last_regenerate|i:1531434840;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('d9f37f0f5d61e1f77ef773eab6931f4ecf058aee',	'::1',	1531434106,	'__ci_last_regenerate|i:1531433739;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('db5b0caf0a3794758845b2f7f8d95db83b82ea68',	'::1',	1531429438,	'__ci_last_regenerate|i:1531429103;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"student\";'),
('df8865e6809c737822a96d40efe175c29947edd6',	'::1',	1531424002,	'__ci_last_regenerate|i:1531424002;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('dffe9242bf3a2d2887ed408e6f10d3e531936855',	'::1',	1531430201,	'__ci_last_regenerate|i:1531429907;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:6:\"parent\";'),
('eaa0b92042814a8acd699f5b94129457b9815c58',	'::1',	1531424469,	'__ci_last_regenerate|i:1531424333;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:8:\"settings\";'),
('ee06209bcbc56d448f262f3dbc0254156526c309',	'::1',	1531429732,	'__ci_last_regenerate|i:1531429440;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"teacher\";'),
('ef2592b519c5a86cd7361c76653d6599f19e5794',	'::1',	1531428449,	'__ci_last_regenerate|i:1531428151;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"student\";'),
('f5f2c6b89757708d5950ee778ec836886342a23f',	'::1',	1531433734,	'__ci_last_regenerate|i:1531433388;active_login|s:1:\"1\";login_user_id|s:1:\"2\";login_firstname|s:5:\"Betty\";login_lastname|s:5:\"Kanze\";login_email|s:21:\"betty.kanze@gmail.com\";login_type_id|s:1:\"1\";login_profile|s:1:\"1\";login_type|s:5:\"admin\";profile_id|s:1:\"1\";page_type|s:7:\"finance\";');

DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `name_numeric` tinyint(4) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `class` (`class_id`, `name`, `name_numeric`, `teacher_id`) VALUES
(1,	'Class Two',	5,	2),
(2,	'Class Three',	6,	1),
(4,	'Class Four',	7,	2),
(5,	'Play Group',	1,	1),
(6,	'Kindergaten',	2,	2),
(7,	'Pre-School',	3,	1),
(8,	'Class One',	4,	1),
(9,	'Class Five',	8,	2),
(10,	'Class Six',	9,	2),
(11,	'Class Seven',	10,	1),
(12,	'Class Eight',	11,	2);

DROP TABLE IF EXISTS `class_routine`;
CREATE TABLE `class_routine` (
  `class_routine_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `time_start` int(11) NOT NULL,
  `time_end` int(11) NOT NULL,
  `time_start_min` int(11) NOT NULL,
  `time_end_min` int(11) NOT NULL,
  `day` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`class_routine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `class_routine` (`class_routine_id`, `class_id`, `subject_id`, `time_start`, `time_end`, `time_start_min`, `time_end_min`, `day`) VALUES
(1,	2,	1,	12,	12,	0,	40,	'monday'),
(2,	1,	3,	10,	10,	0,	40,	'tuesday'),
(3,	1,	2,	14,	14,	0,	40,	'tuesday'),
(4,	1,	2,	9,	9,	0,	45,	'monday'),
(5,	1,	4,	10,	11,	40,	20,	'tuesday'),
(6,	1,	4,	9,	9,	0,	40,	'wednesday'),
(7,	1,	3,	10,	11,	20,	0,	'thursday'),
(8,	1,	2,	9,	9,	0,	45,	'thursday'),
(9,	0,	0,	24,	13,	15,	0,	'thursday'),
(10,	1,	4,	24,	13,	15,	0,	'friday'),
(11,	2,	7,	10,	11,	25,	0,	'wednesday');

DROP TABLE IF EXISTS `class_routine_attendance`;
CREATE TABLE `class_routine_attendance` (
  `class_routine_attendance_id` int(100) NOT NULL AUTO_INCREMENT,
  `class_routine_id` int(10) NOT NULL,
  `attendance_date` date NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`class_routine_attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `class_routine_attendance` (`class_routine_attendance_id`, `class_routine_id`, `attendance_date`, `notes`) VALUES
(6,	5,	'2018-04-28',	'This is okay'),
(7,	7,	'2018-04-26',	'Tested and works'),
(8,	6,	'2018-04-25',	'This is working'),
(9,	5,	'2018-04-24',	'Well done'),
(10,	2,	'2018-04-10',	'Hey. This is cool'),
(11,	3,	'2018-04-10',	'Good work'),
(12,	5,	'2018-04-10',	'Tested well'),
(13,	8,	'2018-04-12',	'Hello Hello');

DROP TABLE IF EXISTS `crud`;
CREATE TABLE `crud` (
  `crud_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_access` varchar(20) NOT NULL,
  `feature` varchar(20) NOT NULL,
  `operation` varchar(20) NOT NULL,
  PRIMARY KEY (`crud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `crud` (`crud_id`, `user_access`, `feature`, `operation`) VALUES
(2,	'super',	'student',	'create'),
(3,	'super',	'student',	'read'),
(4,	'super',	'student',	'update'),
(5,	'super',	'student',	'delete'),
(6,	'super',	'parent',	'create'),
(7,	'super',	'parent',	'read'),
(8,	'super',	'parent',	'update'),
(9,	'super',	'parent',	'delete'),
(10,	'super',	'activity',	'create'),
(11,	'super',	'activity',	'read'),
(12,	'super',	'activity',	'update'),
(13,	'super',	'activity',	'delete'),
(14,	'super',	'student',	'create'),
(15,	'super',	'student',	'read'),
(16,	'super',	'student',	'update'),
(17,	'super',	'student',	'delete'),
(18,	'super',	'parent',	'create'),
(19,	'super',	'parent',	'read'),
(20,	'super',	'parent',	'update'),
(21,	'super',	'parent',	'delete'),
(22,	'super',	'activity',	'create'),
(23,	'super',	'activity',	'read'),
(24,	'super',	'activity',	'update'),
(25,	'super',	'activity',	'delete'),
(26,	'super',	'class',	'read'),
(27,	'super',	'class',	'delete'),
(28,	'super',	'section',	'read'),
(29,	'super',	'subject',	'create'),
(30,	'super',	'class_routine',	'create'),
(31,	'super',	'class_routine',	'update'),
(32,	'super',	'attendance',	'delete'),
(33,	'super',	'student',	'create'),
(34,	'super',	'student',	'read'),
(35,	'super',	'student',	'update'),
(36,	'super',	'student',	'delete'),
(37,	'super',	'parent',	'create'),
(38,	'super',	'parent',	'read'),
(39,	'super',	'parent',	'update'),
(40,	'super',	'parent',	'delete'),
(41,	'super',	'activity',	'create'),
(42,	'super',	'activity',	'read'),
(43,	'super',	'activity',	'update'),
(44,	'super',	'activity',	'delete'),
(45,	'super',	'teacher',	'create'),
(46,	'super',	'teacher',	'read'),
(47,	'super',	'teacher',	'update'),
(48,	'super',	'teacher',	'delete'),
(49,	'super',	'class',	'create'),
(50,	'super',	'class',	'read'),
(51,	'super',	'class',	'update'),
(52,	'super',	'class',	'delete'),
(53,	'super',	'section',	'create'),
(54,	'super',	'section',	'read'),
(55,	'super',	'section',	'update'),
(56,	'super',	'section',	'delete'),
(57,	'super',	'subject',	'create'),
(58,	'super',	'subject',	'read'),
(59,	'super',	'subject',	'update'),
(60,	'super',	'subject',	'delete'),
(61,	'super',	'class_routine',	'create'),
(62,	'super',	'class_routine',	'read'),
(63,	'super',	'class_routine',	'update'),
(64,	'super',	'class_routine',	'delete'),
(65,	'super',	'attendance',	'create'),
(66,	'super',	'attendance',	'read'),
(67,	'super',	'attendance',	'update'),
(68,	'super',	'attendance',	'delete'),
(69,	'super',	'exam',	'create'),
(70,	'super',	'exam',	'read'),
(71,	'super',	'exam',	'update'),
(72,	'super',	'exam',	'delete'),
(73,	'super',	'grade',	'create'),
(74,	'super',	'grade',	'read'),
(75,	'super',	'grade',	'update'),
(76,	'super',	'grade',	'delete'),
(77,	'super',	'fees_structure',	'create'),
(78,	'super',	'fees_structure',	'read'),
(79,	'super',	'fees_structure',	'update'),
(80,	'super',	'fees_structure',	'delete'),
(81,	'super',	'expense',	'create'),
(82,	'super',	'expense',	'read'),
(83,	'super',	'expense',	'update'),
(84,	'super',	'expense',	'delete'),
(85,	'super',	'payment',	'create'),
(86,	'super',	'payment',	'read'),
(87,	'super',	'payment',	'update'),
(88,	'super',	'payment',	'delete'),
(89,	'super',	'contras',	'create'),
(90,	'super',	'contras',	'read'),
(91,	'super',	'contras',	'update'),
(92,	'super',	'contras',	'delete'),
(93,	'super',	'invoice',	'create'),
(94,	'super',	'invoice',	'read'),
(95,	'super',	'invoice',	'update'),
(96,	'super',	'invoice',	'delete'),
(97,	'super',	'budget',	'create'),
(98,	'super',	'budget',	'read'),
(99,	'super',	'budget',	'update'),
(100,	'super',	'budget',	'delete');

DROP TABLE IF EXISTS `document`;
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


DROP TABLE IF EXISTS `dormitory`;
CREATE TABLE `dormitory` (
  `dormitory_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `number_of_room` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`dormitory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `entitlement`;
CREATE TABLE `entitlement` (
  `entitlement_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `derivative_id` int(100) NOT NULL,
  PRIMARY KEY (`entitlement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `entitlement` (`entitlement_id`, `name`, `derivative_id`) VALUES
(1,	'dashboard',	0),
(2,	'student',	0),
(3,	'student_admission',	2),
(4,	'student_bulk_admission',	2),
(5,	'all_student_information',	2),
(6,	'class_1_students_information',	2),
(7,	'class_2_students_information',	2),
(8,	'class_3_students_information',	2),
(9,	'class_4_students_information',	2),
(10,	'class_5_students_information',	2),
(11,	'class_6_students_information',	2),
(12,	'class_7_students_information',	2),
(13,	'class_8_students_information',	2),
(14,	'class_9_students_information',	2),
(15,	'class_10_students_information',	2),
(16,	'class_11_students_information',	2),
(17,	'teacher',	0),
(18,	'parent',	0),
(19,	'view_parents',	18),
(20,	'parents_activity',	18),
(21,	'classes',	0),
(22,	'manage_classes',	21),
(23,	'manage_sections',	21),
(24,	'subject',	0),
(25,	'subjects_class_numeric_1',	24),
(26,	'subjects_class_numeric_2',	24),
(27,	'subjects_class_numeric_3',	24),
(28,	'subjects_class_numeric_4',	24),
(29,	'subjects_class_numeric_5',	24),
(30,	'subjects_class_numeric_6',	24),
(31,	'subjects_class_numeric_7',	24),
(32,	'subjects_class_numeric_8',	24),
(33,	'subjects_class_numeric_9',	24),
(34,	'subjects_class_numeric_10',	24),
(35,	'subjects_class_numeric_11',	24),
(36,	'class_routine',	0),
(37,	'manage_attendance',	0),
(38,	'exams',	0),
(39,	'exam_list',	38),
(40,	'exam_grades',	38),
(41,	'manage_marks',	38),
(42,	'send_marks_by_sms',	38),
(43,	'tabulation_sheet',	38),
(44,	'accounting',	0),
(45,	'fees_structure',	44),
(46,	'create_invoice',	44),
(47,	'students_income',	44),
(48,	'other_income',	44),
(49,	'school_expenses',	44),
(50,	'cash_book',	44),
(51,	'budget',	44),
(52,	'monthly_reconciliation',	44),
(53,	'financial_report',	44),
(54,	'library',	0),
(55,	'transport',	0),
(56,	'dormitory',	0),
(57,	'noticeboard',	0),
(58,	'messages',	0),
(59,	'settings',	0),
(60,	'general_settings',	59),
(61,	'sms_settings',	59),
(62,	'language_settings',	59),
(63,	'school_settings',	59),
(64,	'user_profiles',	59),
(65,	'administrator',	0),
(66,	'manage_accounts',	0),
(67,	'add_subject',	24),
(68,	'edit_student',	2),
(69,	'promote_student',	2),
(70,	'demote_student',	2),
(71,	'suspend_student',	2),
(72,	'unsuspend_student',	2),
(73,	'delete_student',	2),
(74,	'add_teacher',	17),
(75,	'edit_teacher',	17),
(76,	'delete_teacher',	17),
(77,	'add_parent',	18),
(78,	'edit_parent',	18),
(79,	'assign_beneficiary',	18),
(80,	'delete_parent',	18),
(81,	'add_activity',	18),
(82,	'edit_activity',	18),
(83,	'mark_targeted_participants',	18),
(84,	'mark_attendance',	18),
(85,	'print_activty_attendance',	18),
(86,	'add_class',	21),
(87,	'edit_class',	21),
(88,	'delete_class',	21),
(89,	'add_section',	21),
(90,	'edit_section',	21),
(91,	'delete_section',	21),
(92,	'add_subject',	24),
(93,	'edit_subject',	24),
(94,	'delete_subject',	24),
(95,	'add_class_routine',	36),
(96,	'delete_class_routine',	36),
(97,	'mark_routine_attended',	36),
(98,	'edit_class_routine',	36),
(99,	'update_class_attendance',	37),
(100,	'show_class_attendance',	37),
(101,	'add_exam',	38),
(102,	'edit_exam',	38),
(103,	'delete_exam',	38),
(104,	'add_grade',	38),
(105,	'edit_grade',	38),
(106,	'delete_grade',	38),
(107,	'add_fees_structure',	44),
(108,	'edit_fee_structure',	44),
(109,	'add_fee_structure_item',	44),
(110,	'delete_fee_structure',	44),
(111,	'take_student_payment',	44),
(112,	'edit_invoice',	44),
(113,	'delete_or_cancel_invoice',	44),
(114,	'add_over_note',	44),
(115,	'reclaim_cancelled_invoice',	44),
(116,	'add_none_student_income',	44),
(117,	'reverse_none_student_income',	44),
(118,	'add_expense',	44),
(119,	'reverse_expense',	44),
(120,	'add_contra_entry',	44),
(121,	'create_bank_reconciliation_statement',	44),
(122,	'create_budget_item',	44),
(123,	'edit_reconciliation',	44),
(124,	'edit_book',	54),
(125,	'delete_book',	54),
(126,	'add_book',	54),
(127,	'add_transport',	55),
(128,	'delete_transport',	55),
(129,	'edit_transport',	55),
(130,	'add_dormitory',	56),
(131,	'edit_dormitory',	56),
(132,	'delete_dormitory',	56),
(133,	'show_dormitory',	56),
(134,	'show_books',	54),
(135,	'show_transport',	55),
(136,	'show_events',	57),
(137,	'edit_event',	57),
(138,	'add_event',	57),
(139,	'delete_event',	57),
(140,	'delete_profile',	0),
(141,	'edit_profile',	0);

DROP TABLE IF EXISTS `exam`;
CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` longtext COLLATE utf8_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `exam` (`exam_id`, `name`, `date`, `comment`) VALUES
(1,	'Mid Term Term one',	'04/30/2018',	'Exam');

DROP TABLE IF EXISTS `expense`;
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

INSERT INTO `expense` (`expense_id`, `batch_number`, `description`, `payee`, `t_date`, `method`, `cheque_no`, `amount`, `cleared`, `clearedMonth`, `timestamp`) VALUES
(1,	180103,	'School Stationery',	'Stationery',	'2018-01-10',	'1',	0,	465.00,	0,	'0000-00-00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `expense_category`;
CREATE TABLE `expense_category` (
  `expense_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `income_category_id` int(10) NOT NULL,
  PRIMARY KEY (`expense_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `expense_category` (`expense_category_id`, `name`, `income_category_id`) VALUES
(1,	'Transport Expenses',	1),
(2,	'Administration',	6),
(3,	'Examination',	2),
(4,	'Maintainance',	3),
(5,	'Salaries',	6);

DROP TABLE IF EXISTS `expense_details`;
CREATE TABLE `expense_details` (
  `expense_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `expense_id` int(200) NOT NULL,
  `qty` int(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `expense_category_id` int(200) NOT NULL,
  PRIMARY KEY (`expense_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `expense_details` (`expense_details_id`, `expense_id`, `qty`, `description`, `unitcost`, `cost`, `expense_category_id`) VALUES
(1,	1,	2,	'boxes of chalk',	120.00,	240.00,	2),
(2,	1,	5,	'ex. books',	45.00,	225.00,	1);

DROP TABLE IF EXISTS `fees_structure`;
CREATE TABLE `fees_structure` (
  `fees_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `class_id` int(10) NOT NULL,
  `yr` int(10) NOT NULL,
  `term` int(10) NOT NULL,
  PRIMARY KEY (`fees_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `fees_structure` (`fees_id`, `name`, `class_id`, `yr`, `term`) VALUES
(1,	'class_Class_Two_term_One_year_2018',	1,	2018,	1),
(2,	'class_Class_Three_term_One_year_2018',	2,	2018,	1);

DROP TABLE IF EXISTS `fees_structure_details`;
CREATE TABLE `fees_structure_details` (
  `detail_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `fees_id` int(10) NOT NULL,
  `income_category_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `fees_structure_details` (`detail_id`, `name`, `fees_id`, `income_category_id`, `amount`) VALUES
(1,	'Tuition',	1,	6,	8500),
(2,	'Academic Trips',	1,	4,	2500),
(3,	'Examinations',	1,	2,	1800),
(4,	'Transport',	1,	1,	0),
(5,	'Bus Mantainance',	1,	5,	2400),
(6,	'Sundry ',	1,	3,	1200);

DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `grade_point` longtext COLLATE utf8_unicode_ci NOT NULL,
  `mark_from` int(11) NOT NULL,
  `mark_upto` int(11) NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `grade` (`grade_id`, `name`, `grade_point`, `mark_from`, `mark_upto`, `comment`) VALUES
(1,	'Excellent ',	'A',	80,	100,	''),
(2,	'Good',	'B',	60,	79,	''),
(3,	'Fair',	'C',	40,	59,	'');

DROP TABLE IF EXISTS `income_categories`;
CREATE TABLE `income_categories` (
  `income_category_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `income_categories` (`income_category_id`, `name`) VALUES
(1,	'Transport Revenue'),
(2,	'Examinations'),
(3,	'Miscellaneous'),
(4,	'Academic Trips'),
(5,	'Maintainance'),
(6,	'Tuition');

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` tinyint(10) NOT NULL,
  `yr` longtext COLLATE utf8_unicode_ci NOT NULL,
  `term` longtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL COMMENT 'fees structure amount less transport',
  `amount_due` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'amount liable to pay plus transport',
  `amount_paid` int(100) NOT NULL,
  `balance` int(100) NOT NULL,
  `creation_timestamp` int(11) NOT NULL,
  `status` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'paid, excess, unpaid or cancelled',
  PRIMARY KEY (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `invoice` (`invoice_id`, `student_id`, `class_id`, `yr`, `term`, `amount`, `amount_due`, `amount_paid`, `balance`, `creation_timestamp`, `status`) VALUES
(1,	1,	1,	'2018',	'1',	16400,	'16000',	2300,	13700,	1522447200,	'unpaid'),
(2,	3,	1,	'2018',	'1',	16400,	'21400',	21400,	0,	1522447200,	'paid');

DROP TABLE IF EXISTS `invoice_details`;
CREATE TABLE `invoice_details` (
  `invoice_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(200) NOT NULL,
  `detail_id` int(200) NOT NULL,
  `amount_due` int(200) NOT NULL,
  `amount_paid` int(100) NOT NULL,
  `balance` int(100) NOT NULL,
  `last_payment_id` int(100) NOT NULL,
  PRIMARY KEY (`invoice_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `invoice_details` (`invoice_details_id`, `invoice_id`, `detail_id`, `amount_due`, `amount_paid`, `balance`, `last_payment_id`) VALUES
(1,	1,	1,	8100,	1600,	6900,	1),
(2,	1,	2,	2500,	500,	2000,	1),
(3,	1,	3,	1800,	200,	1600,	1),
(4,	1,	5,	2400,	0,	2400,	0),
(5,	1,	6,	1200,	0,	1200,	0),
(6,	2,	1,	6500,	8100,	0,	2),
(7,	2,	2,	2000,	2500,	0,	2),
(8,	2,	3,	1800,	2000,	-200,	2),
(9,	2,	4,	7500,	7500,	0,	2),
(10,	2,	5,	2400,	2400,	0,	2),
(11,	2,	6,	1200,	1200,	0,	2);

DROP TABLE IF EXISTS `language`;
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

INSERT INTO `language` (`phrase_id`, `phrase`, `english`, `bengali`, `spanish`, `arabic`, `dutch`, `russian`, `chinese`, `turkish`, `portuguese`, `hungarian`, `french`, `greek`, `german`, `italian`, `thai`, `urdu`, `hindi`, `latin`, `indonesian`, `japanese`, `korean`, `swahili`, `Kikuyu`) VALUES
(1,	'login',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(2,	'forgot_your_password',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(3,	'admin_dashboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(4,	'dashboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(5,	'student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(6,	'admit_student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(7,	'admit_bulk_student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(8,	'student_information',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(9,	'teacher',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(10,	'parents',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(11,	'class',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(12,	'manage_classes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(13,	'manage_sections',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(14,	'subject',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(15,	'class_routine',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(16,	'daily_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(17,	'exam',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(18,	'exam_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(19,	'exam_grades',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(20,	'manage_marks',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(21,	'send_marks_by_sms',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(22,	'tabulation_sheet',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(23,	'accounting',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(24,	'fees_structure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(25,	'create_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(26,	'student_payments',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(27,	'school_expenses',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(28,	'cash_book',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(29,	'budget',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(30,	'library',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(31,	'transport',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(32,	'dormitory',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(33,	'noticeboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(34,	'message',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(35,	'settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(36,	'general_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(37,	'sms_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(38,	'language_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(39,	'school_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(40,	'account',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(41,	'edit_profile',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(42,	'change_password',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(43,	'event_schedule',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(44,	'parent',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	'Muciari'),
(45,	'attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(46,	'delete',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(47,	'cancel',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(48,	'Ok',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(49,	'school_budget',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(50,	'new_budget_item',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(51,	'budget_summary',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(52,	'budget_schedules',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(53,	'account_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(54,	'select',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(55,	'description_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(56,	'financial_year',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(57,	'quantity_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(58,	'unit_cost',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(59,	'how_often',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(60,	'total_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(61,	'monthly_spread',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(62,	'January',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(63,	'February',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(64,	'March',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(65,	'April',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(66,	'May',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(67,	'June',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(68,	'July',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(69,	'August',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(70,	'September',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(71,	'October',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(72,	'November',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(73,	'December',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(74,	'create',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(75,	'clear_spread',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(76,	'error:_account_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(77,	'error:_description_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(78,	'error:_financial_year_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(79,	'error:_quantity_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(80,	'error:_unit_cost_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(81,	'error:_frequency_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(82,	'error:_total_cost_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(83,	'error:_spread_missing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(84,	'error:_spread_incorrect',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(85,	'unpaid_invoices',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(86,	'cleared_invoices',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(87,	'payment_history',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(88,	'year',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(89,	'fee_structure_total',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(90,	'payable_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(91,	'balance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(92,	'date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(93,	'options',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(94,	'action',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(95,	'term',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(96,	'method',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(97,	'amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(98,	'expenses',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(99,	'add_new_expense',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(100,	'title',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(101,	'category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(102,	'add_expense',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(103,	'value_required',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(104,	'select_expense_category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(105,	'description',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(106,	'cash',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(107,	'check',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(108,	'card',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(109,	'School_terms',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(110,	'add',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(111,	'term_number',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(112,	'terms',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(113,	'income_categories',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(114,	'add_new_income_category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(115,	'name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(116,	'expense_categories',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(117,	'add_new_expense_category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(118,	'income_category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(119,	'add_expense_category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(120,	'data_added_successfully',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(121,	'expense_category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(122,	'edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(123,	'action_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(124,	'qty',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(125,	'unitcost',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(126,	'often',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(127,	'total',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(128,	'Jan',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(129,	'Feb',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(130,	'Mar',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(131,	'Apr',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(132,	'Jun',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(133,	'Jul',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(134,	'Aug',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(135,	'Sep',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(136,	'Oct',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(137,	'Nov',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(138,	'Dec',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(139,	'edit_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(140,	'delete_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(141,	'edit_budget',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(142,	'quantity',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(143,	'create_single_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(144,	'create_mass_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(145,	'invoice_informations',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(146,	'select_class',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(147,	'select_class_first',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(148,	'payment_informations',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(149,	'total_payable',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(150,	'enter_total_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(151,	'fee_items',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(152,	'full_payment',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(153,	'item',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(154,	'fee_structure_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(155,	'amount_payable',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(156,	'due_payment',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(157,	'enter_payable_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(158,	'enter_payment_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(159,	'edit_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(160,	'add_new_fees_structure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(161,	'add_fees_structure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(162,	'add_student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(163,	'addmission_form',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(164,	'section',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(165,	'roll',	'Admission Number',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(166,	'birthday',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(167,	'gender',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(168,	'male',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(169,	'female',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(170,	'address',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(171,	'phone',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(172,	'email',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(173,	'password',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(174,	'transport_route',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(175,	'photo',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(176,	'all_parents',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(177,	'add_new_parent',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(178,	'profession',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(179,	'add_parent',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(180,	'manage_class',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(181,	'class_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(182,	'add_class',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(183,	'class_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(184,	'numeric_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(185,	'name_numeric',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(186,	'manage_teacher',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(187,	'add_new_teacher',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(188,	'add_teacher',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(189,	'add_new_section',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(190,	'section_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(191,	'nick_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(192,	'add_section',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(193,	'add_new_student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(194,	'all_students',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(195,	'suspended_students',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(196,	'mark_sheet',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(197,	'profile',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(198,	'suspend',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(199,	'manage_daily_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(200,	'select_date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(201,	'select_month',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(202,	'select_year',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(203,	'manage_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(204,	'manage_transport',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(205,	'transport_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(206,	'add_transport',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(207,	'route_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(208,	'number_of_vehicle',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(209,	'route_fare',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(210,	'record_already_exists',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(211,	'view_fees_structure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(212,	'clone_fees_structure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(213,	'add_item',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(214,	'system_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(215,	'system_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(216,	'system_title',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(217,	'paypal_email',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(218,	'currency',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(219,	'system_email',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(220,	'language',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(221,	'text_align',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(222,	'save',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(223,	'update_product',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(224,	'file',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(225,	'install_update',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(226,	'theme_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(227,	'default',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(228,	'select_theme',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(229,	'select_a_theme_to_make_changes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(230,	'upload_logo',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(231,	'upload',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(232,	'add_term',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(233,	'term_title',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(234,	'add_income_category',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(235,	'invoice_created_successfully',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(236,	'invoice_editted_successfully',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(237,	'take_payment',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(238,	'view_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(239,	'delete_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(240,	'payment',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(241,	'paid',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(242,	'payment_successfull',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(243,	'creation_date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(244,	'status',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(245,	'payment_to',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(246,	'bill_to',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(247,	'total_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(248,	'paid_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(249,	'due',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(250,	'invoice_breakdown',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(251,	'payee',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(252,	'cost',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(253,	'add_row',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(254,	'student_payment',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(255,	'bank',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(256,	'reference',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(257,	'transaction_type',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(258,	'income',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(259,	'expense',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(260,	'balance_brought_forward',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(261,	'contra_entries',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(262,	'new_contra_entry',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(263,	'entry_type',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(264,	'to_bank',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(265,	'to_cash',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(266,	'transact',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(267,	'Choose',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(268,	'edit_expense',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(269,	'update',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(270,	'data_updated',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(271,	'account_balances',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(272,	'account_opening_balances',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(273,	'add/_Edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(274,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(275,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(276,	'view_history',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(277,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(278,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(279,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(280,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(281,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(282,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(283,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(284,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(285,	'add/_edit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(286,	'batch_number',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(287,	'view',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(288,	'reverse',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(289,	'view_expense_batch',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(290,	'expense_reversed_successful',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(291,	'expense_reversal:_batch',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(292,	'reversal:_batch',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(293,	'record_reversed_successful',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(294,	'actual_incomes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(295,	'receipt',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(296,	'serial',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(297,	'payment_receipt',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(298,	'student_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(299,	'admission_number',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(300,	'receipt_number',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(301,	'total_amount_due',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(302,	'previously_paid',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(303,	'amount_due',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(304,	'reciept_total',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(305,	'fees_balance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(306,	'receipt_total',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(307,	'fees_due',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(308,	'fees_paid_to_date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(309,	'view_receipt',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(310,	'download_receipt',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(311,	'manage_library_books',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(312,	'book_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(313,	'add_book',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(314,	'book_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(315,	'author',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(316,	'price',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(317,	'available',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(318,	'unavailable',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(319,	'print_receipt',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(320,	'manage_noticeboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(321,	'noticeboard_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(322,	'add_noticeboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(323,	'notice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(324,	'add_notice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(325,	'send_sms_to_all',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(326,	'yes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(327,	'no',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(328,	'sms_service_not_activated',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(329,	'private_messaging',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(330,	'messages',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(331,	'new_message',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(332,	'manage_profile',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(333,	'update_profile',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(334,	'current_password',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(335,	'new_password',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(336,	'confirm_new_password',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(337,	'manage_class_routine',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(338,	'class_routine_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(339,	'add_class_routine',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(340,	'day',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(341,	'starting_time',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(342,	'hour',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(343,	'minutes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(344,	'ending_time',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(345,	'manage_subject',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(346,	'subject_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(347,	'add_subject',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(348,	'subject_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(349,	'financial_report',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(350,	'revenue_report',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(351,	'opening_balance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(352,	'month_income',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(353,	'month_expense',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(354,	'ending_balance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(355,	'revenue_report_for',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(356,	'summary_by_expense_categories',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(357,	'summary_by_income_categories',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(358,	'theme_selected',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(359,	'teacher_dashboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(360,	'study_material',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(361,	'student_dashboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(362,	'exam_marks',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(363,	'school_budget_for_year',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(364,	'school_budget_for_year_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(365,	'students',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(366,	'edit_transport',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(367,	'edit_student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(368,	'edit_class',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(369,	'beneficiaries',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(370,	'beneficiary_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(371,	'edit_fees_structure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(372,	'data_deleted',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(373,	'select_a_student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(374,	'cheque',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(375,	'cheque_number',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(376,	'view_parent',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(377,	'parent_activity',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(378,	'parents_activity',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(379,	'add_activity',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(380,	'activity_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(381,	'start_date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(382,	'end_date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(383,	'add_parents',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(384,	'search_parents_by',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(385,	'All',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(386,	'go',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(387,	'activity_details',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(388,	'manage_language',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(389,	'language_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(390,	'add_phrase',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(391,	'add_language',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(392,	'option',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(393,	'edit_phrase',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(394,	'delete_language',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(395,	'phrase',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(396,	'update_phrase',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(397,	'add_bulk_student',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(398,	'student_bulk_add_form',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(399,	'select_excel_file',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(400,	'upload_and_import',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(401,	'service_is_disabled',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(402,	'present',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(403,	'manage_exam',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(404,	'add_exam',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(405,	'exam_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(406,	'comment',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(407,	'manage_grade',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(408,	'grade_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(409,	'add_grade',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(410,	'grade_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(411,	'grade_point',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(412,	'mark_from',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(413,	'mark_upto',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(414,	'edit_grade',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(415,	'manage_exam_marks',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(416,	'select_exam',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(417,	'select_subject',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(418,	'select_an_exam',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(419,	'select_a_class',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(420,	'mark_obtained',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(421,	'update_marks',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(422,	'send_marks',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(423,	'select_receiver',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(424,	'view_tabulation_sheet',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(425,	'subjects',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(426,	'average_grade_point',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(427,	'print_tabulation_sheet',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(428,	'select_all',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(429,	'select_none',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(430,	'manage_dormitory',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(431,	'dormitory_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(432,	'add_dormitory',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(433,	'dormitory_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(434,	'number_of_room',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(435,	'on',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(436,	'write_new_message',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(437,	'recipient',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(438,	'select_a_user',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(439,	'write_your_message',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(440,	'send',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(441,	'message_sent!',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(442,	'reply_message',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(443,	'select_a_service',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(444,	'not_selected',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(445,	'disabled',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(446,	'clickatell_username',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(447,	'clickatell_password',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(448,	'clickatell_api_id',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(449,	'twilio_account',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(450,	'authentication_token',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(451,	'registered_phone_number',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(452,	'settings_updated',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	''),
(453,	'download',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(454,	'marksheet_for',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(455,	'total_marks',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(456,	'print_marksheet',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(457,	'manage_invoice/payment',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(458,	'invoice/payment_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(459,	'mark_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(460,	'parent_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(461,	'mark',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(462,	'attended',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(463,	'absent',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(464,	'not_attending',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(465,	'show/mark_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(466,	'show_or_mark_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(467,	'teacher_list',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(468,	'student_marksheet',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(469,	'add_study_material',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(470,	'file_type',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(471,	'select_file_type',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(472,	'image',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(473,	'doc',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(474,	'pdf',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(475,	'excel',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(476,	'other',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(477,	'show_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(478,	'parent_dashboard',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(479,	'total_mark',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(480,	'edit_subject',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(481,	'mark_attended',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(482,	'class_routine_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(483,	'attendance_date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(484,	'notes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(485,	'attendance_created',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(486,	'attendance_exists',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(487,	'attendance_updated',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(488,	'routine_date',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(489,	'search_routine',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(490,	'session(s)_attended_today',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(491,	'no_session_attended_today',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(492,	'edit_class_routine',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(493,	'edit_teacher',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(494,	'sex',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(495,	'administrators',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(496,	'manage_administrator',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(497,	'add_new_administrator',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(498,	'add_administrator',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(499,	'relationship',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(500,	'care_type',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(501,	'primary',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(502,	'secondary',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(503,	'care_relationship',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(504,	'add_relationship',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(505,	'record_added',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(506,	'duplicate_name',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(507,	'record_deleted',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(508,	'edit_relationship',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(509,	'duplicate_record',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(510,	'record_edited',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(511,	'none',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(512,	'other_caregivers',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(513,	'edit_parent',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(514,	'assign_beneficiary',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(515,	'assign_beneficiaries',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(680,	'add_profile',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(679,	'entitlement',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(678,	'user_profiles',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(519,	'user_access',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(520,	'feature',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(521,	'read',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(522,	'super_administrator',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(523,	'manager',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(677,	'active',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(526,	'super_admin',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(676,	'reconciliation_reports',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(675,	'cashbook',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(674,	'monthly_reconciliation',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(673,	'month_editted_successfully',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(672,	'month_closed_successfully',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(671,	'reconciliation_statement',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(670,	'other_income',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(669,	'students_income',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(668,	'cleared_outstanding',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(667,	'outstanding_cheques',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(666,	'cleared_in_transit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(665,	'deposit_in_transit',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(664,	'bank_reconciliation',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(549,	'activity',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(550,	'grade',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(551,	'contras',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(552,	'invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(556,	'record',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(663,	'view_batch',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(567,	'admin',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(662,	'crud_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(584,	'settings_saved',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(606,	'level',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(607,	'edit_administrator',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(608,	'super',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(661,	'CRUD_settings',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(613,	'no_items_found',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(614,	'process_failure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(615,	'student_suspended',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(616,	'unsuspend_',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(617,	'success',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(618,	'targeted_participants',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(619,	'back',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(620,	'print_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(621,	'activity_register',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(622,	'print_activty_attendance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(623,	'edit_exam',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(624,	'promote_students',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(625,	'promote',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(626,	'demote',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(627,	'invoices_created_successfully',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(628,	'failed:_some_invoices_exists',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(629,	'cancel_invoices',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(630,	'cancelled_invoices',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(631,	'cancel_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(632,	'invoice_cancelled',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(633,	'reclaim_invoice',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(634,	'invoice_reclaimed',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(635,	'invoice_information',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(636,	'adjusted_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(637,	'invoice_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(638,	'amount_lesser_than_paid',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(639,	'force_overpay',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(640,	'edit_successful',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(641,	'overpaid_invoices',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(642,	'no_student_found',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(643,	'add_new_income',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(644,	'add_income',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(645,	'view_income_batch',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(646,	'overpay_notes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(647,	'add_note',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(648,	'batch_number_not_existing',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(649,	'checking...',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(650,	'error_occurred',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(651,	'details',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(652,	'failure',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(653,	'note_created',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(654,	'paying_more_than_balance',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(655,	'overpay',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(656,	'invoice_amount_greater_than_to_pay_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(657,	'structure_payable',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(658,	'structure_total_amount',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(659,	'charge_overpay',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL),
(660,	'cleared_overpay_notes',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL);

DROP TABLE IF EXISTS `login_type`;
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

DROP TABLE IF EXISTS `mark`;
CREATE TABLE `mark` (
  `mark_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `mark_obtained` int(11) NOT NULL DEFAULT '0',
  `mark_total` int(11) NOT NULL DEFAULT '100',
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mark_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mark` (`mark_id`, `student_id`, `subject_id`, `class_id`, `exam_id`, `mark_obtained`, `mark_total`, `comment`) VALUES
(1,	4,	1,	2,	1,	72,	100,	'Good Work'),
(2,	1,	2,	1,	1,	0,	100,	''),
(3,	2,	2,	1,	1,	0,	100,	''),
(4,	3,	2,	1,	1,	0,	100,	''),
(5,	4,	7,	2,	1,	60,	100,	'Good'),
(6,	11,	7,	2,	1,	65,	100,	'Good'),
(7,	12,	7,	2,	1,	82,	100,	'Excellent'),
(8,	13,	7,	2,	1,	71,	100,	'Very Good'),
(9,	11,	1,	2,	1,	0,	100,	''),
(10,	12,	1,	2,	1,	0,	100,	''),
(11,	13,	1,	2,	1,	0,	100,	''),
(12,	14,	2,	1,	1,	0,	100,	''),
(13,	15,	2,	1,	1,	0,	100,	'');

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext NOT NULL,
  `message` longtext NOT NULL,
  `sender` longtext NOT NULL,
  `timestamp` longtext NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 unread 1 read',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `message` (`message_id`, `message_thread_code`, `message`, `sender`, `timestamp`, `read_status`) VALUES
(1,	'8cbce2aa38abde1',	'Hey',	'admin-1',	'1522852035',	0);

DROP TABLE IF EXISTS `message_thread`;
CREATE TABLE `message_thread` (
  `message_thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sender` longtext COLLATE utf8_unicode_ci NOT NULL,
  `reciever` longtext COLLATE utf8_unicode_ci NOT NULL,
  `last_message_timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`message_thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `message_thread` (`message_thread_id`, `message_thread_code`, `sender`, `reciever`, `last_message_timestamp`) VALUES
(1,	'8cbce2aa38abde1',	'admin-1',	'parent-3',	'');

DROP TABLE IF EXISTS `noticeboard`;
CREATE TABLE `noticeboard` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `notice` longtext COLLATE utf8_unicode_ci NOT NULL,
  `create_timestamp` int(11) NOT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `noticeboard` (`notice_id`, `notice_title`, `notice`, `create_timestamp`) VALUES
(1,	'Academic Day',	'Academic Day',	1524002400);

DROP TABLE IF EXISTS `opening_balance`;
CREATE TABLE `opening_balance` (
  `opening_balance_id` int(50) NOT NULL AUTO_INCREMENT,
  `income_category_id` int(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`opening_balance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `opening_balance` (`opening_balance_id`, `income_category_id`, `amount`) VALUES
(1,	1,	407870.23),
(2,	5,	543765.10);

DROP TABLE IF EXISTS `other_payment_details`;
CREATE TABLE `other_payment_details` (
  `other_payment_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `payment_id` int(100) NOT NULL,
  `qty` int(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `income_category_id` int(200) NOT NULL,
  PRIMARY KEY (`other_payment_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `overpay`;
CREATE TABLE `overpay` (
  `overpay_id` int(100) NOT NULL AUTO_INCREMENT,
  `student_id` int(100) NOT NULL,
  `income_id` int(100) NOT NULL,
  `amount` int(10) NOT NULL,
  `amount_due` int(10) NOT NULL,
  `description` longtext NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'active,cleared',
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`overpay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `parent`;
CREATE TABLE `parent` (
  `parent_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `relationship_id` int(5) NOT NULL,
  `care_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `profession` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `parent` (`parent_id`, `name`, `email`, `phone`, `address`, `relationship_id`, `care_type`, `profession`) VALUES
(1,	'Mulandi Kyalo',	'JMulandi1@gmail.com',	'0711808071',	'Nairobi',	1,	'primary',	'Businessman'),
(2,	'Mwambire Karisa',	'mwambire2017@gmail.com',	'072267525',	'Kiserian',	5,	'primary',	'Teacher'),
(3,	'Maina Maina',	'MEgelan@gmail.com',	'07124345654',	'80 Ngong',	3,	'secondary',	'Teacher'),
(4,	'John Njugo',	'JNjugo2017@gmail.com',	'0711876542',	'1056 Karen Nairobi',	1,	'primary',	'Driver'),
(5,	'Mary Otieno',	'MOtieno12@gmail.com',	'0711909076',	'54 Malindi',	2,	'secondary',	'Business Woman'),
(6,	'Hellen Kamau',	'HKamau@yahoo.com',	'0711876542',	'45 Nairobi',	6,	'secondary',	'Air Hostess'),
(7,	'Bitange Joseph',	'BJosey@gmail.com',	'',	'',	5,	'secondary',	'Journalist'),
(8,	'Martina Chengo Garama',	'machess@gmail.com',	'075787578',	'80788',	2,	'primary',	'Air Hostess');

DROP TABLE IF EXISTS `payment`;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment` (`payment_id`, `t_date`, `batch_number`, `serial`, `invoice_id`, `payee`, `description`, `method`, `payment_type`, `amount`, `cleared`, `clearedMonth`, `timestamp`) VALUES
(1,	'2018-01-09',	180101,	1,	1,	'Mulandi Kyalo',	'School Fees Payment for James Mulandi',	'2',	1,	'2300',	0,	'0000-00-00',	'1515452400'),
(2,	'2018-01-09',	180102,	2,	2,	'Joyce ',	'Fees Payment for Joyce',	'1',	1,	'21400',	0,	'0000-00-00',	'1515452400');

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `profile_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `profile` (`profile_id`, `name`, `description`) VALUES
(1,	'Super Admin',	'System Main Administrator'),
(2,	'STD One Class Teacher',	'STD One Class Teacher');

DROP TABLE IF EXISTS `reconcile`;
CREATE TABLE `reconcile` (
  `reconcile_id` int(100) NOT NULL AUTO_INCREMENT,
  `statement_amount` decimal(10,2) NOT NULL,
  `month` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reconcile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `relationship`;
CREATE TABLE `relationship` (
  `relationship_id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `relationship` (`relationship_id`, `name`) VALUES
(1,	'Father'),
(2,	'Mother'),
(3,	'Brother'),
(4,	'Sister'),
(5,	'Uncle'),
(6,	'Aunt');

DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `nick_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `section` (`section_id`, `name`, `nick_name`, `class_id`, `teacher_id`) VALUES
(1,	'Judah',	'Judah',	2,	1),
(2,	'Siloam',	'Siloam',	2,	1),
(3,	'Eastern',	'E',	1,	2),
(5,	'West',	'W',	1,	1);

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES
(1,	'system_name',	'School Management System'),
(2,	'system_title',	'School Management System'),
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
(21,	'system_start_date',	'2018-01-01');

DROP TABLE IF EXISTS `student`;
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
  `class_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `section_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `roll` longtext COLLATE utf8_unicode_ci NOT NULL,
  `transport_id` int(11) NOT NULL,
  `dormitory_id` int(11) NOT NULL,
  `dormitory_room_number` longtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `student` (`student_id`, `name`, `birthday`, `sex`, `religion`, `blood_group`, `address`, `phone`, `email`, `father_name`, `mother_name`, `class_id`, `section_id`, `parent_id`, `roll`, `transport_id`, `dormitory_id`, `dormitory_room_number`, `active`) VALUES
(1,	'James Mulandi',	'10/25/2005',	'male',	'',	'',	'Nairobi',	'',	'nkmwambs@gmail.com',	'',	'',	'1',	0,	1,	'VGS/01/2017',	0,	0,	'',	1),
(2,	'Nicodemus Karisa',	'06/22/2009',	'male',	'',	'',	'Kiserian',	'0722654372',	'mwambirekarisa@gmail.com',	'',	'',	'1',	0,	2,	'VGC/24/2017',	1,	0,	'',	1),
(3,	'Joyce Ted',	'02/02/2009',	'',	'',	'',	'2',	'0722654376',	'nkmwambs@gmail.com',	'',	'',	'1',	0,	1,	'VGS/242/2017',	0,	0,	'',	1),
(4,	'Beatrice Maina',	'01/30/2014',	'female',	'',	'',	'50',	'0770978233',	'MEgelan@gmail.com',	'',	'',	'4',	1,	3,	'BM/12/2018',	1,	0,	'',	1),
(11,	'Ben Karanja',	'03/11/2010',	'male',	'',	'',	'',	'',	'',	'',	'',	'2',	1,	4,	'34242',	0,	0,	'',	0),
(12,	'Brian Njogu',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'4',	2,	4,	'32423',	0,	0,	'',	1),
(13,	'Blessing Mvera',	'06/04/2009',	'female',	'',	'',	'1945 Karen Nairobi',	'0711909076',	'nkmwambs@gmail.com',	'',	'',	'2',	2,	2,	'24542',	0,	0,	'',	1),
(14,	'Mapenzi Karani',	'40211',	'female',	'',	'',	'7672',	'711897242',	'm.karani@gmail.com',	'',	'',	'1',	0,	0,	'543342',	0,	0,	'',	0),
(15,	'James Baya',	'40731',	'male',	'',	'',	'542',	'723447845',	'j.baya@gmail.com',	'',	'',	'1',	0,	0,	'533234',	0,	0,	'',	0);

DROP TABLE IF EXISTS `student_payment_details`;
CREATE TABLE `student_payment_details` (
  `student_payment_details_id` int(200) NOT NULL AUTO_INCREMENT,
  `payment_id` int(100) NOT NULL,
  `detail_id` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `t_date` date NOT NULL,
  PRIMARY KEY (`student_payment_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `student_payment_details` (`student_payment_details_id`, `payment_id`, `detail_id`, `amount`, `t_date`) VALUES
(1,	1,	1,	1600,	'2018-01-09'),
(2,	1,	2,	500,	'2018-01-09'),
(3,	1,	3,	200,	'2018-01-09'),
(4,	2,	1,	6500,	'2018-01-09'),
(5,	2,	2,	2000,	'2018-01-09'),
(6,	2,	3,	1800,	'2018-01-09'),
(7,	2,	4,	7500,	'2018-01-09'),
(8,	2,	5,	2400,	'2018-01-09'),
(9,	2,	6,	1200,	'2018-01-09');

DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `subject` (`subject_id`, `name`, `class_id`, `teacher_id`) VALUES
(1,	'English',	2,	1),
(2,	'Maths',	1,	1),
(3,	'English',	1,	2),
(4,	'Science',	1,	2),
(6,	'Swahili',	1,	1),
(7,	'Swahili',	2,	1);

DROP TABLE IF EXISTS `teacher`;
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
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teacher` (`teacher_id`, `name`, `birthday`, `sex`, `religion`, `blood_group`, `address`, `phone`, `email`) VALUES
(1,	'Patty Kamau Karanja',	'02/23/1981',	'female',	'',	'',	'Nairobi',	'07206876543',	'purityKamau2018@gmail.com'),
(2,	'Macmillan Ben ',	'06/12/1979',	'male',	'',	'',	'122 Nairobi',	'0728367826',	'macben@gmail.com');

DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `terms_id` int(100) NOT NULL AUTO_INCREMENT,
  `term_number` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`terms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `terms` (`terms_id`, `term_number`, `name`) VALUES
(1,	1,	'One'),
(2,	2,	'Two'),
(3,	3,	'Three');

DROP TABLE IF EXISTS `transport`;
CREATE TABLE `transport` (
  `transport_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `number_of_vehicle` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `route_fare` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`transport_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(100) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `login_type_id` tinyint(10) NOT NULL,
  `type_table_id` tinyint(100) NOT NULL,
  `profile_id` tinyint(5) NOT NULL,
  `auth` tinyint(5) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `email`, `password`, `phone`, `login_type_id`, `type_table_id`, `profile_id`, `auth`) VALUES
(1,	'Nicodemus',	'Karisa',	'nkmwambs@gmail.com',	'compassion12',	'254711808071',	1,	1,	1,	1),
(2,	'Betty',	'Kanze',	'betty.kanze@gmail.com',	'compassion12',	'254711808071',	1,	2,	1,	1);

-- 2018-07-12 22:54:39
