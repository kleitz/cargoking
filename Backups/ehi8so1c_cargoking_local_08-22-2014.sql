# SQL Manager 2007 for MySQL 4.3.4.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : ehi8so1c_cargoking


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS `ehi8so1c_cargoking`;

CREATE DATABASE `ehi8so1c_cargoking`
    CHARACTER SET 'latin1'
    COLLATE 'latin1_swedish_ci';

USE `ehi8so1c_cargoking`;

#
# Structure for the `arr` table : 
#

DROP TABLE IF EXISTS `arr`;

CREATE TABLE `arr` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `bookid` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `tyship` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `qun` INTEGER(55) NOT NULL,
  `length` INTEGER(11) NOT NULL,
  `width` INTEGER(11) NOT NULL,
  `height` INTEGER(11) NOT NULL,
  `weight` INTEGER(11) NOT NULL,
  `total_weight` INTEGER(11) NOT NULL,
  `tot` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `at` VARCHAR(255) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=90 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `booking` table : 
#

DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `prefix` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `book_no` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `receiver_name` VARCHAR(100) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `receiver_address` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `receiver_phone` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `customer_code` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `sender_name` VARCHAR(100) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `sender_address` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `sender_city` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `sender_phone` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `satellite_office_id` INTEGER(11) NOT NULL,
  `payment_mode_id` INTEGER(11) NOT NULL,
  `identification_number` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `origin` INTEGER(11) NOT NULL,
  `destination` INTEGER(11) NOT NULL,
  `movement_type_id` INTEGER(11) NOT NULL,
  `service_mode_id` INTEGER(11) NOT NULL,
  `hawb_date` DATETIME NOT NULL,
  `hawb_status` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT NULL,
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  `no_of_items` INTEGER(11) NOT NULL,
  `total_weight` DECIMAL(11,2) NOT NULL,
  `total_price` DECIMAL(11,2) NOT NULL,
  `discounted_price` DECIMAL(11,2) DEFAULT NULL,
  `weight_ref_id` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1040 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `booking_item_details` table : 
#

DROP TABLE IF EXISTS `booking_item_details`;

CREATE TABLE `booking_item_details` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `booking_id` INTEGER(11) NOT NULL,
  `booking_code` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `shipment_type_id` INTEGER(11) NOT NULL,
  `quantity` INTEGER(11) NOT NULL,
  `container_length` DECIMAL(11,2) DEFAULT NULL,
  `container_width` DECIMAL(11,2) DEFAULT NULL,
  `container_height` DECIMAL(11,2) DEFAULT NULL,
  `dimension_total` DECIMAL(11,2) DEFAULT NULL,
  `dimension_weight` DECIMAL(11,2) DEFAULT NULL,
  `actual_weight` DECIMAL(11,2) DEFAULT NULL,
  `preferred_weight` DECIMAL(11,2) DEFAULT NULL,
  `declared_value` DECIMAL(11,2) DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT NULL,
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `bplace` table : 
#

DROP TABLE IF EXISTS `bplace`;

CREATE TABLE `bplace` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `address` VARCHAR(500) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=19 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `branch` table : 
#

DROP TABLE IF EXISTS `branch`;

CREATE TABLE `branch` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `pfx` VARCHAR(1) COLLATE latin1_swedish_ci NOT NULL DEFAULT 'B',
  `branch_id` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `branch_username` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `cont_person` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `address` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `city` VARCHAR(23) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `phone` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `email` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `status` VARCHAR(10) COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Active',
  `rand` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `customer` table : 
#

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `last_name` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `middle_name` VARCHAR(50) COLLATE latin1_swedish_ci DEFAULT NULL,
  `address` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `station_id` INTEGER(11) NOT NULL,
  `satellite_office_id` INTEGER(11) DEFAULT NULL,
  `phone` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `email_address` VARCHAR(100) COLLATE latin1_swedish_ci DEFAULT NULL,
  `identification_type` INTEGER(11) DEFAULT NULL,
  `identification_number` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `percentage_discount` DECIMAL(11,2) DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT NULL,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=2197 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `deliveryarea` table : 
#

DROP TABLE IF EXISTS `deliveryarea`;

CREATE TABLE `deliveryarea` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `city` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `station` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `delarea` INTEGER(11) NOT NULL,
  `station_hawb_prefix` VARCHAR(20) COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT NULL,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=267 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `destinations` table : 
#

DROP TABLE IF EXISTS `destinations`;

CREATE TABLE `destinations` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `driver` table : 
#

DROP TABLE IF EXISTS `driver`;

CREATE TABLE `driver` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `invoice` table : 
#

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `inv_id` VARCHAR(155) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `bookingpl` VARCHAR(155) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `vec` VARCHAR(155) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `driver` VARCHAR(255) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `rand` VARCHAR(155) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `date` DATE NOT NULL,
  `postby` VARCHAR(35) COLLATE latin1_swedish_ci NOT NULL DEFAULT 'admin',
  `status` VARCHAR(55) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `invoice_arr` table : 
#

DROP TABLE IF EXISTS `invoice_arr`;

CREATE TABLE `invoice_arr` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `inv_id` VARCHAR(155) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `bookid` VARCHAR(155) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `mop` table : 
#

DROP TABLE IF EXISTS `mop`;

CREATE TABLE `mop` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=9 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `movement` table : 
#

DROP TABLE IF EXISTS `movement`;

CREATE TABLE `movement` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=6 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `permissions` table : 
#

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `name` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `servicemode` table : 
#

DROP TABLE IF EXISTS `servicemode`;

CREATE TABLE `servicemode` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=6 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `status` table : 
#

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=10 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `ty_ship` table : 
#

DROP TABLE IF EXISTS `ty_ship`;

CREATE TABLE `ty_ship` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=4 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `upstatus` table : 
#

DROP TABLE IF EXISTS `booking_status`;

CREATE TABLE `booking_status` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `hawb_code` VARCHAR(50) COLLATE latin1_general_ci DEFAULT NULL,
  `date` VARCHAR(50) COLLATE latin1_general_ci DEFAULT NULL,
  `time` VARCHAR(50) COLLATE latin1_general_ci DEFAULT NULL,
  `location` VARCHAR(50) COLLATE latin1_general_ci DEFAULT NULL,
  `status` VARCHAR(50) COLLATE latin1_general_ci DEFAULT NULL,
  `comments` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1221 CHARACTER SET 'latin1' COLLATE 'latin1_general_ci';

#
# Structure for the `user_type_permissions` table : 
#

DROP TABLE IF EXISTS `user_type_permissions`;

CREATE TABLE `user_type_permissions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` INTEGER(11) NOT NULL,
  `permission_id` INTEGER(11) NOT NULL,
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `user_types` table : 
#

DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `user_types` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `type_code` VARCHAR(20) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `type_name` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `type_description` TEXT COLLATE latin1_swedish_ci,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `type_name` (`type_name`),
  UNIQUE KEY `type_code` (`type_code`)
)ENGINE=InnoDB
AUTO_INCREMENT=8 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `users` table : 
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` INTEGER(11) NOT NULL,
  `code` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT '',
  `identification_type` TINYINT(4) NOT NULL DEFAULT '-1',
  `identification_no` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `username` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `name` VARCHAR(100) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `password` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `address` TEXT COLLATE latin1_swedish_ci,
  `station_id` INTEGER(11) DEFAULT NULL,
  `phone` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` VARCHAR(100) COLLATE latin1_swedish_ci DEFAULT NULL,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_date` VARCHAR(20) COLLATE latin1_swedish_ci DEFAULT NULL,
  `satellite_office_id` INTEGER(11) DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `username_2` (`username`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `code_2` (`code`),
  UNIQUE KEY `code_3` (`code`)
)ENGINE=InnoDB
AUTO_INCREMENT=25 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `vec` table : 
#

DROP TABLE IF EXISTS `vec`;

CREATE TABLE `vec` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `station_id` MEDIUMINT(9) DEFAULT NULL,
  `model_year` TEXT COLLATE latin1_swedish_ci,
  `plate_no` VARCHAR(10) COLLATE latin1_swedish_ci DEFAULT NULL,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Structure for the `weight` table : 
#

DROP TABLE IF EXISTS `weight`;

CREATE TABLE `weight` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `weightvalue` VARCHAR(10) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `delarea` FLOAT NOT NULL,
  `fcharge` FLOAT NOT NULL,
  `vat` FLOAT NOT NULL,
  `rate` FLOAT NOT NULL,
  `commission` FLOAT NOT NULL,
  `duecar` FLOAT NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=202 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

#
# Definition for the `vw_loginusers` view : 
#

DROP VIEW IF EXISTS `vw_loginusers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_loginusers` AS 
  select 
    `u`.`id` AS `id`,
    `ut`.`type_code` AS `type_code`,
    `ut`.`type_name` AS `type_name`,
    `u`.`username` AS `username`,
    `u`.`name` AS `name`,
    `u`.`password` AS `password`,
    `u`.`email` AS `email`,
    `u`.`station_id` AS `station_id`,
    `u`.`satellite_office_id` AS `satellite_office_id`,
    `so`.`station_hawb_prefix` AS `hawb_booking_prefix` 
  from 
    ((`users` `u` join `user_types` `ut` on((`ut`.`id` = `u`.`user_type_id`))) left join `deliveryarea` `so` on((`so`.`id` = `u`.`satellite_office_id`)));

#
# Definition for the `vw_booking_details` view : 
#

DROP VIEW IF EXISTS `vw_booking_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_details` AS 
  select 
    `b`.`id` AS `id`,
    `u`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    concat(ifnull(`u`.`hawb_booking_prefix`,''),convert(if((`u`.`hawb_booking_prefix` is not null),'-','') using latin1),`b`.`id`) AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    date_format(`b`.`hawb_date`,'%m-%d-%Y') AS `formatted_date`,
    `b`.`hawb_status` AS `hawb_status_id`,
    `st`.`category` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin` AS `origin_id`,
    `o`.`category` AS `origin`,
    `so`.`city` AS `so_branch`,
    `b`.`destination` AS `destination_id`,
    `s`.`category` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `mop`.`category` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `mov`.`category` AS `movement_type`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `srv`.`category` AS `service_mode`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `w`.`rate` AS `rate`,
    if((`b`.`total_weight` < 50),`w`.`rate`,(`b`.`total_weight` * `w`.`rate`)) AS `computed_rate`,
    round(if((`b`.`total_weight` < 50),`w`.`commission`,((`b`.`total_weight` * `w`.`rate`) * 0.25)),2) AS `commission`,
    round(if((`b`.`total_weight` < 50),`w`.`duecar`,((`b`.`total_weight` * `w`.`rate`) - ((`b`.`total_weight` * `w`.`rate`) * 0.25))),2) AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    `b`.`remarks` AS `remarks`,
    `b`.`created_by` AS `agent_id`,
    `u`.`name` AS `agent_name` 
  from 
    (((((((((`booking` `b` left join `vw_loginusers` `u` on((`u`.`id` = `b`.`created_by`))) left join `bplace` `o` on((`o`.`id` = `b`.`origin`))) left join `bplace` `s` on((`s`.`id` = `b`.`destination`))) left join `weight` `w` on((`w`.`id` = `b`.`weight_ref_id`))) left join `mop` on((`mop`.`id` = `b`.`payment_mode_id`))) left join `movement` `mov` on((`mov`.`id` = `b`.`movement_type_id`))) left join `servicemode` `srv` on((`srv`.`id` = `b`.`service_mode_id`))) left join `status` `st` on((`st`.`id` = `b`.`hawb_status`))) left join `deliveryarea` `so` on((`so`.`id` = `b`.`satellite_office_id`)));

#
# Definition for the `vw_booking_previous_month` view : 
#

DROP VIEW IF EXISTS `vw_booking_previous_month`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_previous_month` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    `b`.`booking_code` AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`formatted_date` AS `formatted_date`,
    `b`.`hawb_status_id` AS `hawb_status_id`,
    `b`.`hawb_status` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`destination_id` AS `destination_id`,
    `b`.`destination` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `b`.`payment_mode` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `b`.`rate` AS `rate`,
    `b`.`computed_rate` AS `computed_rate`,
    `b`.`commission` AS `commission`,
    `b`.`amount_due` AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    (`b`.`total_price` - `b`.`discounted_price`) AS `discount`,
    (`b`.`total_price` - `b`.`computed_rate`) AS `declared_value_insurance`,
    `b`.`remarks` AS `remarks`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name` 
  from 
    `vw_booking_details` `b` 
  where 
    (`b`.`hawb_date` between date_format(now(),'%Y-%m-01') and last_day(now()));

#
# Definition for the `vw_agent_chart_monthly_booking_counts` view : 
#

DROP VIEW IF EXISTS `vw_agent_chart_monthly_booking_counts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_agent_chart_monthly_booking_counts` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    count(`b`.`id`) AS `tx_count` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;

#
# Definition for the `vw_booking_daily` view : 
#

DROP VIEW IF EXISTS `vw_booking_daily`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_daily` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    `b`.`booking_code` AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`formatted_date` AS `formatted_date`,
    `b`.`hawb_status_id` AS `hawb_status_id`,
    `b`.`hawb_status` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`destination_id` AS `destination_id`,
    `b`.`destination` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `b`.`payment_mode` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `b`.`rate` AS `rate`,
    `b`.`computed_rate` AS `computed_rate`,
    `b`.`commission` AS `commission`,
    `b`.`amount_due` AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    (`b`.`total_price` - `b`.`discounted_price`) AS `discount`,
    (`b`.`total_price` - `b`.`computed_rate`) AS `declared_value_insurance`,
    `b`.`remarks` AS `remarks`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name` 
  from 
    `vw_booking_details` `b` 
  where 
    (`b`.`formatted_date` = date_format(now(),'%m-%d-%Y'));

#
# Definition for the `vw_booking_agent_chart_daily` view : 
#

DROP VIEW IF EXISTS `vw_booking_agent_chart_daily`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_chart_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;

#
# Definition for the `vw_booking_agent_chart_monthly` view : 
#

DROP VIEW IF EXISTS `vw_booking_agent_chart_monthly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_chart_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;

#
# Definition for the `vw_booking_previous_week` view : 
#

DROP VIEW IF EXISTS `vw_booking_previous_week`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_previous_week` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`hawb_booking_prefix` AS `hawb_booking_prefix`,
    `b`.`booking_code` AS `booking_code`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`formatted_date` AS `formatted_date`,
    `b`.`hawb_status_id` AS `hawb_status_id`,
    `b`.`hawb_status` AS `hawb_status`,
    `b`.`customer_code` AS `customer_code`,
    `b`.`sender_name` AS `sender_name`,
    `b`.`sender_address` AS `sender_address`,
    `b`.`sender_city` AS `sender_city`,
    `b`.`sender_phone` AS `sender_phone`,
    `b`.`identification_number` AS `identification_number`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`destination_id` AS `destination_id`,
    `b`.`destination` AS `destination`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`receiver_address` AS `receiver_address`,
    `b`.`receiver_phone` AS `receiver_phone`,
    `b`.`payment_mode_id` AS `payment_mode_id`,
    `b`.`payment_mode` AS `payment_mode`,
    `b`.`movement_type_id` AS `movement_type_id`,
    `b`.`service_mode_id` AS `service_mode_id`,
    `b`.`no_of_items` AS `no_of_items`,
    `b`.`weight_ref_id` AS `weight_ref_id`,
    `b`.`rate` AS `rate`,
    `b`.`computed_rate` AS `computed_rate`,
    `b`.`commission` AS `commission`,
    `b`.`amount_due` AS `amount_due`,
    `b`.`total_weight` AS `total_weight`,
    `b`.`total_price` AS `total_price`,
    `b`.`discounted_price` AS `discounted_price`,
    (`b`.`total_price` - `b`.`discounted_price`) AS `discount`,
    (`b`.`total_price` - `b`.`computed_rate`) AS `declared_value_insurance`,
    `b`.`remarks` AS `remarks`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name` 
  from 
    `vw_booking_details` `b` 
  where 
    (`b`.`hawb_date` between date_format((now() - interval weekday(now()) day),'%Y-%m-%d') and cast((now() + interval (6 - weekday(now())) day) as date));

#
# Definition for the `vw_booking_agent_chart_weekly` view : 
#

DROP VIEW IF EXISTS `vw_booking_agent_chart_weekly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_chart_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`,`b`.`agent_id`,`b`.`agent_name`;

#
# Definition for the `vw_booking_agent_totals_daily` view : 
#

DROP VIEW IF EXISTS `vw_booking_agent_totals_daily`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_totals_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`agent_id`,`b`.`agent_name`;

#
# Definition for the `vw_booking_agent_totals_monthly` view : 
#

DROP VIEW IF EXISTS `vw_booking_agent_totals_monthly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_totals_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`agent_id`,`b`.`agent_name`;

#
# Definition for the `vw_booking_agent_totals_weekly` view : 
#

DROP VIEW IF EXISTS `vw_booking_agent_totals_weekly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_agent_totals_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`agent_id` AS `agent_id`,
    `b`.`agent_name` AS `agent_name`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`agent_id`,`b`.`agent_name`;

#
# Definition for the `vw_booking_branch_totals_daily` view : 
#

DROP VIEW IF EXISTS `vw_booking_branch_totals_daily`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_branch_totals_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`,`b`.`satellite_office_id`,`b`.`so_branch`;

#
# Definition for the `vw_booking_branch_totals_monthly` view : 
#

DROP VIEW IF EXISTS `vw_booking_branch_totals_monthly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_branch_totals_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`,`b`.`satellite_office_id`,`b`.`so_branch`;

#
# Definition for the `vw_booking_branch_totals_weekly` view : 
#

DROP VIEW IF EXISTS `vw_booking_branch_totals_weekly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_branch_totals_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`,`b`.`satellite_office_id`,`b`.`so_branch`;

#
# Definition for the `vw_booking_chart_daily` view : 
#

DROP VIEW IF EXISTS `vw_booking_chart_daily`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_chart_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`;

#
# Definition for the `vw_booking_chart_monthly` view : 
#

DROP VIEW IF EXISTS `vw_booking_chart_monthly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_chart_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`;

#
# Definition for the `vw_booking_chart_weekly` view : 
#

DROP VIEW IF EXISTS `vw_booking_chart_weekly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_chart_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    `b`.`satellite_office_id` AS `satellite_office_id`,
    `b`.`so_branch` AS `so_branch`,
    sum((`b`.`commission` - `b`.`discount`)) AS `sales` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`satellite_office_id`,`b`.`so_branch`;

#
# Definition for the `vw_booking_station_totals_daily` view : 
#

DROP VIEW IF EXISTS `vw_booking_station_totals_daily`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_station_totals_daily` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_daily` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`;

#
# Definition for the `vw_booking_station_totals_monthly` view : 
#

DROP VIEW IF EXISTS `vw_booking_station_totals_monthly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_station_totals_monthly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_month` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`;

#
# Definition for the `vw_booking_station_totals_weekly` view : 
#

DROP VIEW IF EXISTS `vw_booking_station_totals_weekly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_station_totals_weekly` AS 
  select 
    `b`.`origin_id` AS `origin_id`,
    `b`.`origin` AS `origin`,
    sum(`b`.`computed_rate`) AS `total_rate`,
    sum(`b`.`total_price`) AS `insured_rate`,
    sum(`b`.`discounted_price`) AS `discounted_total`,
    sum(`b`.`declared_value_insurance`) AS `total_insurance`,
    sum(`b`.`commission`) AS `total_commission`,
    sum(`b`.`amount_due`) AS `total_due_to_ck`,
    sum((`b`.`amount_due` + `b`.`declared_value_insurance`)) AS `total_insured_ckdue`,
    sum((`b`.`commission` - `b`.`discount`)) AS `total_commission_net` 
  from 
    `vw_booking_previous_week` `b` 
  group by 
    `b`.`origin_id`,`b`.`origin`;

#
# Definition for the `vw_booking_totals` view : 
#

DROP VIEW IF EXISTS `vw_booking_totals`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_totals` AS 
  select 
    `b`.`id` AS `id`,
    `b`.`book_no` AS `book_no`,
    `b`.`hawb_date` AS `hawb_date`,
    `b`.`origin` AS `origin_id`,
    `ogn`.`category` AS `origin`,
    `b`.`receiver_name` AS `receiver_name`,
    `b`.`destination` AS `destination_id`,
    `dest`.`category` AS `destination`,
    sum(`ar`.`tot`) AS `total_amount` 
  from 
    (((`booking` `b` join `bplace` `ogn` on((`ogn`.`id` = `b`.`origin`))) join `bplace` `dest` on((`dest`.`id` = `b`.`destination`))) left join `arr` `ar` on((`ar`.`bookid` = `b`.`book_no`))) 
  group by 
    `b`.`book_no`;

#
# Definition for the `vw_customers` view : 
#

DROP VIEW IF EXISTS `vw_customers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_customers` AS 
  select 
    `c`.`id` AS `id`,
    concat('C',`c`.`id`) AS `cust_id`,
    concat(ifnull(`c`.`first_name`,''),' ',ifnull(`c`.`last_name`,'')) AS `cust_name`,
    `c`.`address` AS `address`,
    `c`.`station_id` AS `station_id`,
    `st`.`category` AS `station_name`,
    `c`.`satellite_office_id` AS `satellite_office_id`,
    `so`.`city` AS `satellite_office_name`,
    `c`.`phone` AS `phone`,
    `c`.`email_address` AS `email_address`,
    `c`.`identification_type` AS `identification_type`,
    `c`.`identification_number` AS `identification_number`,
    `c`.`percentage_discount` AS `percentage_discount`,
    `c`.`created_by` AS `created_by` 
  from 
    ((`customer` `c` join `bplace` `st` on((`st`.`id` = `c`.`station_id`))) left join `deliveryarea` `so` on((`so`.`id` = `c`.`satellite_office_id`)));

#
# Definition for the `vw_hawb_items` view : 
#

DROP VIEW IF EXISTS `vw_hawb_items`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_hawb_items` AS 
  select 
    `bd`.`id` AS `id`,
    `bd`.`booking_id` AS `booking_id`,
    `bd`.`booking_code` AS `booking_code`,
    `bd`.`shipment_type_id` AS `shipment_type_id`,
    ifnull(`st`.`category`,'N/A') AS `shipment_type`,
    `bd`.`quantity` AS `quantity`,
    `bd`.`container_length` AS `container_length`,
    `bd`.`container_width` AS `container_width`,
    `bd`.`container_height` AS `container_height`,
    `bd`.`dimension_total` AS `dimension_total`,
    `bd`.`dimension_weight` AS `dimension_weight`,
    `bd`.`actual_weight` AS `actual_weight`,
    `bd`.`preferred_weight` AS `preferred_weight`,
    `bd`.`declared_value` AS `declared_value` 
  from 
    (`booking_item_details` `bd` left join `ty_ship` `st` on((`st`.`id` = `bd`.`shipment_type_id`)));

#
# Definition for the `vw_satellite_office_agents` view : 
#

DROP VIEW IF EXISTS `vw_satellite_office_agents`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_satellite_office_agents` AS 
  select 
    `u`.`id` AS `id`,
    `u`.`user_type_id` AS `user_type_id`,
    `u`.`code` AS `code`,
    `u`.`identification_type` AS `identification_type`,
    `u`.`identification_no` AS `identification_no`,
    `u`.`username` AS `username`,
    `u`.`name` AS `name`,
    `u`.`password` AS `password`,
    `u`.`address` AS `address`,
    `u`.`station_id` AS `station_id`,
    `u`.`satellite_office_id` AS `satellite_office_id`,
    `u`.`phone` AS `phone`,
    `u`.`email` AS `email`,
    `u`.`creation_date` AS `creation_date`,
    `u`.`last_modified_date` AS `last_modified_date`,
    `da`.`city` AS `satellite_office` 
  from 
    (`users` `u` left join `deliveryarea` `da` on((`da`.`id` = `u`.`satellite_office_id`))) 
  where 
    (`u`.`user_type_id` = 7);

#
# Data for the `arr` table  (LIMIT 0,500)
#

INSERT INTO `arr` (`id`, `bookid`, `tyship`, `qun`, `length`, `width`, `height`, `weight`, `total_weight`, `tot`, `at`) VALUES 
  (7,'LR4','1',2,50,100,50,5,0,'','500'),
  (8,'LR4','',0,0,0,0,0,0,'0',''),
  (9,'CK1000','1',2,0,0,0,30,0,'','400'),
  (10,'CK1000','',0,0,0,0,0,30,'0',''),
  (11,'CK1001','1',4,100,50,50,0,0,'','300'),
  (12,'CK1001','',0,0,0,0,0,0,'0',''),
  (13,'CK1002','1',5,80,80,90,0,0,'','600'),
  (14,'CK1002','',0,0,0,0,0,0,'0',''),
  (15,'CK1003','1',3,0,0,0,1,0,'','900'),
  (16,'CK1003','',0,0,0,0,0,1,'0',''),
  (17,'CK1004','1',1,0,0,0,1,0,'','100'),
  (18,'CK1004','',0,0,0,0,0,1,'0',''),
  (19,'CK1005','1',5,0,0,0,40,0,'','1000'),
  (20,'CK1005','',0,0,0,0,0,40,'0',''),
  (21,'CK1006','1',4,0,0,0,30,0,'','500'),
  (22,'CK1006','',0,0,0,0,0,30,'0',''),
  (23,'CK1007','1',2,0,0,0,33,0,'','1333'),
  (24,'CK1007','1',4,0,0,0,20,0,'','700'),
  (25,'CK1007','',0,0,0,0,0,53,'0',''),
  (26,'CK1008','1',5,10,5,6,12,0,'','800'),
  (27,'CK1008','',0,0,0,0,0,12,'940',''),
  (28,'CK1009','1',10,0,0,0,30,0,'','500'),
  (29,'CK1009','',0,0,0,0,0,30,'2110',''),
  (30,'CK1010','1',5,0,0,0,10,0,'','500'),
  (31,'CK1010','',0,0,0,0,0,10,'750',''),
  (32,'CK1011','1',6,0,0,0,2,0,'','200'),
  (33,'CK1011','',0,0,0,0,0,2,'190.4',''),
  (34,'CK1012','1',54,45,45,45,26,0,'','45'),
  (35,'CK1012','',0,0,0,0,0,26,'1790',''),
  (36,'CK1013','1',5,0,0,0,39,0,'','500'),
  (37,'CK1013','',0,0,0,0,0,39,'2635',''),
  (38,'CK1014','1',4,0,0,0,40,0,'','500'),
  (39,'CK1014','',0,0,0,0,0,40,'2700',''),
  (40,'CK1015','1',2,0,0,0,32,0,'','500'),
  (41,'CK1015','',0,0,0,0,0,32,'2180',''),
  (42,'CK1016','1',9,0,0,0,60,0,'','300'),
  (43,'CK1016','',0,0,0,0,0,60,'2280',''),
  (44,'CK1017','1',2,0,0,0,48,0,'','900'),
  (45,'CK1017','',0,0,0,0,0,48,'3220',''),
  (46,'CK1018','1',4,0,0,0,30,0,'','500'),
  (47,'CK1018','',0,0,0,0,0,30,'',''),
  (48,'CK1019','1',2,0,0,0,45,0,'','500'),
  (49,'CK1019','',0,0,0,0,0,45,'3025',''),
  (50,'CK1020','1',3,0,0,0,24,0,'','500'),
  (51,'CK1020','',0,0,0,0,0,24,'1660',''),
  (52,'CK1021','1',3,0,0,0,18,0,'','100'),
  (53,'CK1021','',0,0,0,0,0,18,'1270',''),
  (54,'CK1022','1',2,0,0,0,20,0,'','200'),
  (55,'CK1022','',0,0,0,0,0,20,'1400',''),
  (56,'CK1023','1',5,0,0,0,47,0,'','1000'),
  (57,'CK1023','',0,0,0,0,0,47,'3155',''),
  (58,'CK000001','1',2,0,0,0,33,0,'','1000'),
  (59,'CK000001','',0,0,0,0,0,33,'2245',''),
  (60,'DVOCK13','1',3,0,0,0,28,0,'','1000'),
  (61,'DVOCK13','',0,0,0,0,0,28,'1920',''),
  (62,'MNLTEST2','1',4,0,0,0,22,0,'','500'),
  (63,'MNLTEST2','',0,0,0,0,0,22,'1530',''),
  (64,'DVOCK14','1',5,0,0,0,40,0,'','500'),
  (65,'DVOCK14','',0,0,0,0,0,40,'2700',''),
  (66,'CKDVOCTR1','1',3,0,0,0,10,0,'','500'),
  (67,'CKDVOCTR1','',0,0,0,0,0,10,'810',''),
  (68,'CK1029','1',2,0,0,0,4,0,'','100'),
  (69,'CK1029','',0,0,0,0,0,4,'380',''),
  (70,'CKDVOCTR2','1',8,0,0,0,6,0,'','1000'),
  (71,'CKDVOCTR2','',0,0,0,0,0,6,'750',''),
  (72,'CK1031','1',2,0,0,0,30,0,'','100'),
  (73,'CK1031','',0,0,0,0,0,30,'2050',''),
  (74,'CK1032','1',3,0,0,0,20,0,'','500'),
  (75,'CK1032','',0,0,0,0,0,20,'1400',''),
  (76,'CK1033','1',2,0,0,0,5,0,'','1000'),
  (77,'CK1033','',0,0,0,0,0,5,'380',''),
  (78,'CKDVOCTR4','1',2,0,0,0,5,0,'','1000'),
  (79,'CKDVOCTR4','',0,0,0,0,0,5,'380',''),
  (80,'CKDVOCTR5','1',1,20,20,30,3,0,'','1500'),
  (81,'CKDVOCTR5','',0,0,0,0,0,3,'245',''),
  (82,'CK1036','1',2,0,0,0,11,0,'','500'),
  (83,'CK1036','',0,0,0,0,0,11,'1045',''),
  (84,'CK1037','2',25,25,55,15,6,0,'','1250'),
  (85,'CK1037','1',1,35,45,25,11,0,'','2575'),
  (86,'CK1037','1',1,0,0,0,25,0,'','15000'),
  (87,'CK1037','',0,0,0,0,0,42,'2890',''),
  (88,'DVOCK15','2',15,0,0,0,25,0,'','1500'),
  (89,'DVOCK15','',0,0,0,0,0,25,'1725','');
COMMIT;

#
# Data for the `booking` table  (LIMIT 0,500)
#

INSERT INTO `booking` (`id`, `prefix`, `book_no`, `receiver_name`, `receiver_address`, `receiver_phone`, `customer_code`, `sender_name`, `sender_address`, `sender_city`, `sender_phone`, `satellite_office_id`, `payment_mode_id`, `identification_number`, `origin`, `destination`, `movement_type_id`, `service_mode_id`, `hawb_date`, `hawb_status`, `remarks`, `created_by`, `create_date`, `last_modified_by`, `last_modified_date`, `no_of_items`, `total_weight`, `total_price`, `discounted_price`, `weight_ref_id`) VALUES 
  (1039,'CK-DVO-BUHANGIN','','Rowena D. Makapugong','Talisay Punuan Subdivision, Talisay Cebu','(032) 566-7754','C2196','Borgy Manotoy','NHA Bangkal','Davao','(082) 355-4214',215,3,'2-16177-67',8,7,1,2,'2014-06-02 00:00:00','1','...',21,'2014-06-02 06:23:12',21,'2014-06-02 06:23:12',2,81.00,3218.00,2896.20,129);
COMMIT;

#
# Data for the `booking_item_details` table  (LIMIT 0,500)
#

INSERT INTO `booking_item_details` (`id`, `booking_id`, `booking_code`, `shipment_type_id`, `quantity`, `container_length`, `container_width`, `container_height`, `dimension_total`, `dimension_weight`, `actual_weight`, `preferred_weight`, `declared_value`, `created_by`, `last_modified_by`, `create_date`, `last_modified_date`) VALUES 
  (1,1039,'CK-DVO-BUHANGIN-1039',1,1,100.00,50.00,50.00,250000.00,71.00,70.00,71.00,10000.00,21,21,'2014-06-02 06:23:12','2014-06-02 06:23:12'),
  (2,1039,'CK-DVO-BUHANGIN-1039',1,1,50.00,25.00,20.00,25000.00,7.00,10.00,10.00,5000.00,21,21,'2014-06-02 06:23:12','2014-06-02 06:23:12');
COMMIT;

#
# Data for the `bplace` table  (LIMIT 0,500)
#

INSERT INTO `bplace` (`id`, `category`, `address`) VALUES 
  (6,'Manila','Domestic Airport Compound Old Domestic Road, Pasay City - (02)5778017 (02)4785624'),
  (7,'Cebu',''),
  (8,'Davao','Cargo Terminal Building1, Davao International Airport, Cabatian Road, Buhangin, Davao City Tele/Fax 082 232-8008'),
  (9,'Tagbilaran',''),
  (10,'Bacolod',''),
  (11,'Iloilo',''),
  (12,'Caticlan (Boracay)',''),
  (13,'Puerto Princesa',''),
  (14,'Cagayan De Oro',''),
  (15,'Butuan',''),
  (16,'Zamboanga',''),
  (17,'General Santos',''),
  (18,'Manila (Divisoria)','1005 MTM Building Riena Regente Cor. Soler Street Binondo, Manila - (02)9989774 (02)9989774');
COMMIT;

#
# Data for the `customer` table  (LIMIT 0,500)
#

INSERT INTO `customer` (`id`, `first_name`, `last_name`, `middle_name`, `address`, `station_id`, `satellite_office_id`, `phone`, `email_address`, `identification_type`, `identification_number`, `percentage_discount`, `created_by`, `creation_date`, `last_modified_date`) VALUES 
  (2195,'Frederick John','Bayuok','Escamado','Lanzona Subd., Matina',8,215,'(082) 655-5473','fjbayuok@gmail.com',1,'7-0007-007',10.00,21,'2014-06-02 05:43:37','2014-06-02 05:43:37'),
  (2196,'Borgy','Manotoy','Dimausap','NHA Bangkal',8,215,'(082) 355-4214','bmanotoy@gmail.com',1,'2-16177-67',10.00,21,'2014-06-02 06:14:46','2014-06-02 06:14:46');
COMMIT;

#
# Data for the `deliveryarea` table  (LIMIT 0,500)
#

INSERT INTO `deliveryarea` (`id`, `city`, `station`, `delarea`, `station_hawb_prefix`, `created_by`, `creation_date`, `last_modified_date`) VALUES 
  (1,'Bajada','8',1,'CK-DVO-BAJADA',15,NULL,'2014-05-30 06:31:57'),
  (2,'Toril','8',2,NULL,NULL,NULL,NULL),
  (3,'Pasay','6',1,NULL,NULL,NULL,NULL),
  (4,'Paranaque','6',1,NULL,NULL,NULL,NULL),
  (5,'Antipolo','6',2,NULL,NULL,NULL,NULL),
  (6,'Laguna','6',2,NULL,NULL,NULL,NULL),
  (7,'Las-Pinas','6',1,NULL,NULL,NULL,NULL),
  (8,'Alabang','6',1,NULL,NULL,NULL,NULL),
  (9,'Manila','6',1,NULL,NULL,NULL,NULL),
  (10,'Paco','6',1,NULL,NULL,NULL,NULL),
  (11,'Sta. Ana','6',1,NULL,NULL,NULL,NULL),
  (12,'Bonie','6',1,NULL,NULL,NULL,NULL),
  (13,'Mandalyong','6',1,NULL,NULL,NULL,NULL),
  (14,'Ortigas','6',1,NULL,NULL,NULL,NULL),
  (16,'Cubao','6',1,NULL,NULL,NULL,NULL),
  (17,'Malabon','6',1,NULL,NULL,NULL,NULL),
  (18,'San Juan','6',1,NULL,NULL,NULL,NULL),
  (19,'Makati','6',1,NULL,NULL,NULL,NULL),
  (20,'Muntinlupa','6',1,NULL,NULL,NULL,NULL),
  (21,'Taguig','6',1,NULL,NULL,NULL,NULL),
  (22,'Pasig','6',1,NULL,NULL,NULL,NULL),
  (23,'Valenzuela','6',1,NULL,NULL,NULL,NULL),
  (24,'Fairview','6',1,NULL,NULL,NULL,NULL),
  (25,'Novaliches','6',1,NULL,NULL,NULL,NULL),
  (26,'Caloocan','6',1,NULL,NULL,NULL,NULL),
  (27,'Marikina','6',1,NULL,NULL,NULL,NULL),
  (28,'Mabolo','7',1,NULL,NULL,NULL,NULL),
  (29,'Reclamacion Area','7',1,NULL,NULL,NULL,NULL),
  (30,'Colon','6',1,NULL,NULL,NULL,NULL),
  (31,'Mandaue','7',1,NULL,NULL,NULL,NULL),
  (32,'Cebu City Proper','7',1,NULL,NULL,NULL,NULL),
  (33,'Lapu - Lapu','7',1,NULL,NULL,NULL,NULL),
  (34,'Banilad','7',1,NULL,NULL,NULL,NULL),
  (35,'Talamban','7',1,NULL,NULL,NULL,NULL),
  (36,'Lahug','7',1,NULL,NULL,NULL,NULL),
  (37,'Pardo','7',1,NULL,NULL,NULL,NULL),
  (38,'Marigondon','7',1,NULL,NULL,NULL,NULL),
  (39,'Maribago','7',1,NULL,NULL,NULL,NULL),
  (40,'Mactan','7',1,NULL,NULL,NULL,NULL),
  (41,'Cardova','7',1,NULL,NULL,NULL,NULL),
  (42,'Mabolo','7',1,NULL,NULL,NULL,NULL),
  (43,'Consolacion','7',2,NULL,NULL,NULL,NULL),
  (44,'Liloan','7',2,NULL,NULL,NULL,NULL),
  (45,'Talisay City','7',2,NULL,NULL,NULL,NULL),
  (46,'Naga','7',2,NULL,NULL,NULL,NULL),
  (47,'Minglanilla','7',2,NULL,NULL,NULL,NULL),
  (48,'Danao','7',2,NULL,NULL,NULL,NULL),
  (49,'Albuquerque','9',1,NULL,NULL,NULL,NULL),
  (50,'Antequera','9',2,NULL,NULL,NULL,NULL),
  (51,'Antequera','9',1,NULL,NULL,NULL,NULL),
  (52,'Baclayon','9',1,NULL,NULL,NULL,NULL),
  (53,'Corella','9',1,NULL,NULL,NULL,NULL),
  (54,'Cortes','9',1,NULL,NULL,NULL,NULL),
  (55,'Dauis','9',1,NULL,NULL,NULL,NULL),
  (56,'Tagbilaran City','9',1,NULL,NULL,NULL,NULL),
  (57,'Balilihan','9',2,NULL,NULL,NULL,NULL),
  (58,'Catigbian','9',2,NULL,NULL,NULL,NULL),
  (59,'Dimiao','9',2,NULL,NULL,NULL,NULL),
  (60,'Lila','9',2,NULL,NULL,NULL,NULL),
  (61,'Loay','9',2,NULL,NULL,NULL,NULL),
  (62,'Loboc','9',2,NULL,NULL,NULL,NULL),
  (63,'Loon','9',2,NULL,NULL,NULL,NULL),
  (64,'Maribojoc','9',2,NULL,NULL,NULL,NULL),
  (65,'Panglao','9',2,NULL,NULL,NULL,NULL),
  (66,'Sikatuna','9',2,NULL,NULL,NULL,NULL),
  (67,'Aluba','14',1,NULL,NULL,NULL,NULL),
  (68,'Agora','14',1,NULL,NULL,NULL,NULL),
  (69,'Bonbon','14',1,NULL,NULL,NULL,NULL),
  (70,'Bulua','14',1,NULL,NULL,NULL,NULL),
  (71,'Canitoan','14',1,NULL,NULL,NULL,NULL),
  (72,'Carmen','14',1,NULL,NULL,NULL,NULL),
  (73,'Cogon','14',1,NULL,NULL,NULL,NULL),
  (74,'Cugman','14',1,NULL,NULL,NULL,NULL),
  (75,'Divisoria','14',1,NULL,NULL,NULL,NULL),
  (76,'Kauswagan','14',1,NULL,NULL,NULL,NULL),
  (77,'Lapasan','14',1,NULL,NULL,NULL,NULL),
  (78,'LandFill','14',1,NULL,NULL,NULL,NULL),
  (79,'Patag','14',1,NULL,NULL,NULL,NULL),
  (80,'Taguanao','14',1,NULL,NULL,NULL,NULL),
  (81,'Lumbia','14',1,NULL,NULL,NULL,NULL),
  (82,'Baloy','14',1,NULL,NULL,NULL,NULL),
  (83,'Velez','14',1,NULL,NULL,NULL,NULL),
  (84,'Puerto','14',1,NULL,NULL,NULL,NULL),
  (85,'Xavier Heights','14',1,NULL,NULL,NULL,NULL),
  (86,'Zayas','14',1,NULL,NULL,NULL,NULL),
  (87,'San Simon','14',1,NULL,NULL,NULL,NULL),
  (88,'San Agustin','14',1,NULL,NULL,NULL,NULL),
  (89,'Nazareth','14',2,NULL,NULL,NULL,NULL),
  (90,'Balongis','14',2,NULL,NULL,NULL,NULL),
  (91,'Maasin','14',2,NULL,NULL,NULL,NULL),
  (92,'PN Roa','14',2,NULL,NULL,NULL,NULL),
  (93,'Indahag','14',2,NULL,NULL,NULL,NULL),
  (94,'Agap','15',1,NULL,NULL,NULL,NULL),
  (95,'Agusan Pequeno','15',1,NULL,NULL,NULL,NULL),
  (96,'Ambago','15',1,NULL,NULL,NULL,NULL),
  (97,'Baan Km.3','15',1,NULL,NULL,NULL,NULL),
  (98,'Baan Riverside','15',1,NULL,NULL,NULL,NULL),
  (99,'Bading','15',1,NULL,NULL,NULL,NULL),
  (100,'Bancasi','15',1,NULL,NULL,NULL,NULL),
  (101,'Banza','15',1,NULL,NULL,NULL,NULL),
  (102,'Bayanihan','15',1,NULL,NULL,NULL,NULL),
  (103,'Bit-os','15',1,NULL,NULL,NULL,NULL),
  (104,'Bonbon','15',1,NULL,NULL,NULL,NULL),
  (105,'Buhangin','15',1,NULL,NULL,NULL,NULL),
  (106,'Dagohoy','15',1,NULL,NULL,NULL,NULL),
  (107,'Diego Silang','15',1,NULL,NULL,NULL,NULL),
  (108,'Doongan','15',1,NULL,NULL,NULL,NULL),
  (109,'Golden Ribbon','15',1,NULL,NULL,NULL,NULL),
  (110,'Holy Redeemer','15',1,NULL,NULL,NULL,NULL),
  (111,'Humabon','15',1,NULL,NULL,NULL,NULL),
  (112,'Imadejas','15',1,NULL,NULL,NULL,NULL),
  (113,'Jose P. Rizal','15',1,NULL,NULL,NULL,NULL),
  (114,'Lapu - Lapu','15',1,NULL,NULL,NULL,NULL),
  (115,'Leon Kilat','15',1,NULL,NULL,NULL,NULL),
  (116,'Libertad','15',1,NULL,NULL,NULL,NULL),
  (117,'Limaha','15',1,NULL,NULL,NULL,NULL),
  (118,'Lumbocan','15',1,NULL,NULL,NULL,NULL),
  (119,'Mahay','15',1,NULL,NULL,NULL,NULL),
  (120,'Mahogany','15',1,NULL,NULL,NULL,NULL),
  (121,'Maon','15',1,NULL,NULL,NULL,NULL),
  (122,'New Society Village','15',1,NULL,NULL,NULL,NULL),
  (123,'Obrero','15',1,NULL,NULL,NULL,NULL),
  (124,'Ong Yiu','15',1,NULL,NULL,NULL,NULL),
  (125,'Pagatpatan','15',1,NULL,NULL,NULL,NULL),
  (126,'Pangabugan','15',1,NULL,NULL,NULL,NULL),
  (127,'Port Poyohan','15',1,NULL,NULL,NULL,NULL),
  (128,'Rajah Soliman, Vllage Kanga','15',1,NULL,NULL,NULL,NULL),
  (129,'San Ignacio, San Vicente, Silongan','15',1,NULL,NULL,NULL,NULL),
  (130,'Sto. Nino, Tandang Sora, Urduja','15',1,NULL,NULL,NULL,NULL),
  (131,'Ampayon','15',2,NULL,NULL,NULL,NULL),
  (132,'Babag','15',2,NULL,NULL,NULL,NULL),
  (133,'Cabcabon','15',2,NULL,NULL,NULL,NULL),
  (134,'Dumalagan','15',2,NULL,NULL,NULL,NULL),
  (135,'Kinamlutan','15',2,NULL,NULL,NULL,NULL),
  (136,'Lemon','15',2,NULL,NULL,NULL,NULL),
  (137,'Masao','15',2,NULL,NULL,NULL,NULL),
  (138,'Maug','15',2,NULL,NULL,NULL,NULL),
  (139,'Pigdaulan','15',2,NULL,NULL,NULL,NULL),
  (140,'Pinamanculan','15',2,NULL,NULL,NULL,NULL),
  (141,'Tagabaca','15',2,NULL,NULL,NULL,NULL),
  (142,'Tiniwisan','15',2,NULL,NULL,NULL,NULL),
  (143,'Amparo','15',2,NULL,NULL,NULL,NULL),
  (144,'Antongalon','15',2,NULL,NULL,NULL,NULL),
  (145,'Aupagan','15',2,NULL,NULL,NULL,NULL),
  (146,'Bobon','15',2,NULL,NULL,NULL,NULL),
  (147,'Bitan-Agan','15',2,NULL,NULL,NULL,NULL),
  (148,'Camayahan','15',2,NULL,NULL,NULL,NULL),
  (149,'Don Francisco','15',2,NULL,NULL,NULL,NULL),
  (150,'De Oro','15',2,NULL,NULL,NULL,NULL),
  (151,'Los Angeles','15',2,NULL,NULL,NULL,NULL),
  (152,'Pianing','15',2,NULL,NULL,NULL,NULL),
  (153,'Salvacion','15',2,NULL,NULL,NULL,NULL),
  (154,'Sumilihon','15',2,NULL,NULL,NULL,NULL),
  (155,'Taguibo','15',2,NULL,NULL,NULL,NULL),
  (156,'Taligaman','15',2,NULL,NULL,NULL,NULL),
  (157,'Baliwasan','16',1,NULL,NULL,NULL,NULL),
  (158,'San Jose','16',1,NULL,NULL,NULL,NULL),
  (159,'Calarian','16',1,NULL,NULL,NULL,NULL),
  (160,'Southcom Village','16',1,NULL,NULL,NULL,NULL),
  (161,'Sinunuc','16',1,NULL,NULL,NULL,NULL),
  (162,'Suterville','16',1,NULL,NULL,NULL,NULL),
  (163,'Canelar Moret','16',1,NULL,NULL,NULL,NULL),
  (164,'Buena Vista','16',1,NULL,NULL,NULL,NULL),
  (165,'Sucabon','16',1,NULL,NULL,NULL,NULL),
  (166,'Mayor Jaldon','16',1,NULL,NULL,NULL,NULL),
  (167,'Pilar Street','16',1,NULL,NULL,NULL,NULL),
  (168,'Tugbungan','16',1,NULL,NULL,NULL,NULL),
  (169,'Tetuan','16',1,NULL,NULL,NULL,NULL),
  (170,'Guiwan','16',1,NULL,NULL,NULL,NULL),
  (171,'Putik','16',1,NULL,NULL,NULL,NULL),
  (172,'Divisoria','16',1,NULL,NULL,NULL,NULL),
  (173,'Boalan','16',1,NULL,NULL,NULL,NULL),
  (174,'Zambowood','16',1,NULL,NULL,NULL,NULL),
  (175,'Luyahan','16',1,NULL,NULL,NULL,NULL),
  (176,'Tumaga','16',1,NULL,NULL,NULL,NULL),
  (177,'Pasonanca','16',1,NULL,NULL,NULL,NULL),
  (178,'Sta. Maria','16',1,NULL,NULL,NULL,NULL),
  (179,'San Roque','16',1,NULL,NULL,NULL,NULL),
  (180,'Ayala','16',2,NULL,NULL,NULL,NULL),
  (181,'Labuan','16',2,NULL,NULL,NULL,NULL),
  (182,'Culianan','16',2,NULL,NULL,NULL,NULL),
  (183,'Mercedez','16',2,NULL,NULL,NULL,NULL),
  (184,'Cabaluay','16',2,NULL,NULL,NULL,NULL),
  (185,'Victoria','16',2,NULL,NULL,NULL,NULL),
  (186,'Bolong','16',2,NULL,NULL,NULL,NULL),
  (187,'Manicahan','16',2,NULL,NULL,NULL,NULL),
  (188,'Sanggali','16',2,NULL,NULL,NULL,NULL),
  (189,'Eroreco','10',1,NULL,NULL,NULL,NULL),
  (190,'Sum Ag','10',1,NULL,NULL,NULL,NULL),
  (191,'Villa Monte','10',1,NULL,NULL,NULL,NULL),
  (192,'Singcang Airport','10',1,NULL,NULL,NULL,NULL),
  (193,'Mansilingan','10',1,NULL,NULL,NULL,NULL),
  (194,'Taculing','10',1,NULL,NULL,NULL,NULL),
  (195,'Mandalagan','10',1,NULL,NULL,NULL,NULL),
  (196,'Banago','10',1,NULL,NULL,NULL,NULL),
  (197,'Bata','10',1,NULL,NULL,NULL,NULL),
  (198,'Talisay','10',2,NULL,NULL,NULL,NULL),
  (199,'Silay','10',2,NULL,NULL,NULL,NULL),
  (200,'E B Magalona','10',2,NULL,NULL,NULL,NULL),
  (201,'J.P. Laurel','8',1,NULL,NULL,NULL,NULL),
  (202,'Mapa','8',1,NULL,NULL,NULL,NULL),
  (203,'Obrero','8',1,NULL,NULL,NULL,NULL),
  (204,'Garcia Heights','8',1,NULL,NULL,NULL,NULL),
  (205,'Quirino','8',1,NULL,NULL,NULL,NULL),
  (206,'Guzman St.','8',1,NULL,NULL,NULL,NULL),
  (207,'Sta. Ana Ave.','8',1,NULL,NULL,NULL,NULL),
  (208,'Claveria','8',1,NULL,NULL,NULL,NULL),
  (209,'Uyanguren','8',1,NULL,NULL,NULL,NULL),
  (210,'Agdao','8',1,'CK-DVO-AGDAO',15,NULL,'2014-05-30 06:32:23'),
  (211,'San Pedro','8',1,NULL,NULL,NULL,NULL),
  (212,'Rizal','8',1,NULL,NULL,NULL,NULL),
  (213,'Damosa','8',1,NULL,NULL,NULL,NULL),
  (214,'Lanang','8',1,NULL,NULL,NULL,NULL),
  (215,'Buhangin','8',1,'CK-DVO-BUHANGIN',15,NULL,'2014-05-30 07:26:03'),
  (216,'Cabantian','8',1,NULL,NULL,NULL,NULL),
  (217,'Milan','8',1,NULL,NULL,NULL,NULL),
  (218,'R. Castillo','8',1,NULL,NULL,NULL,NULL),
  (219,'Sasa','8',1,NULL,NULL,NULL,NULL),
  (220,'Magallanes','8',1,NULL,NULL,NULL,NULL),
  (221,'Bankerohan','8',1,'CK-DVO-BNKRHN',15,NULL,'2014-05-30 06:32:31'),
  (222,'Boulevard','8',1,'CK-DVO-BLVD',15,NULL,'2014-05-30 06:32:44'),
  (223,'Mt. Apo','8',1,NULL,NULL,NULL,NULL),
  (224,'Malvar','8',1,NULL,NULL,NULL,NULL),
  (225,'Bunawan','8',2,NULL,NULL,NULL,NULL),
  (226,'Tibungco','8',2,NULL,NULL,NULL,NULL),
  (227,'Panacan','8',2,NULL,NULL,NULL,NULL),
  (228,'Ilang','8',2,NULL,NULL,NULL,NULL),
  (229,'Ulas','8',2,NULL,NULL,NULL,NULL),
  (230,'Mintal','8',2,NULL,NULL,NULL,NULL),
  (231,'Calinan','8',2,NULL,NULL,NULL,NULL),
  (232,'Catalunan','8',2,NULL,NULL,NULL,NULL),
  (233,'Iwa','8',2,NULL,NULL,NULL,NULL),
  (234,'Mulig','8',2,NULL,NULL,NULL,NULL),
  (235,'Lubogan','8',2,NULL,NULL,NULL,NULL),
  (236,'Daliao','8',2,NULL,NULL,NULL,NULL),
  (237,'Matina','8',2,NULL,NULL,NULL,NULL),
  (238,'Tigatto','8',2,NULL,NULL,NULL,NULL),
  (239,'Bangkal','8',1,'CK-DVO-BANGKAL',15,NULL,'2014-05-30 06:32:12'),
  (240,'Talomo','8',2,NULL,NULL,NULL,NULL),
  (261,'EXCESS P2P','6',3,NULL,NULL,NULL,NULL),
  (262,'EXCESS P2P','7',3,NULL,NULL,NULL,NULL),
  (263,'EXCESS P2P','8',3,NULL,NULL,NULL,NULL),
  (264,'EXCESS D2D','6',4,NULL,NULL,NULL,NULL),
  (265,'EXCESS D2D','7',4,NULL,NULL,NULL,NULL),
  (266,'EXCESS D2D','8',4,NULL,NULL,NULL,NULL);
COMMIT;

#
# Data for the `mop` table  (LIMIT 0,500)
#

INSERT INTO `mop` (`id`, `category`) VALUES 
  (3,'Prepaid'),
  (4,'Freight Collect'),
  (8,'Service Cargo');
COMMIT;

#
# Data for the `movement` table  (LIMIT 0,500)
#

INSERT INTO `movement` (`id`, `category`) VALUES 
  (1,'Air'),
  (2,'Land'),
  (3,'Sea');
COMMIT;

#
# Data for the `servicemode` table  (LIMIT 0,500)
#

INSERT INTO `servicemode` (`id`, `category`) VALUES 
  (1,'Pier - Pier '),
  (2,'Door - Door'),
  (4,'Airport - Airport'),
  (5,'Airport - Door');
COMMIT;

#
# Data for the `status` table  (LIMIT 0,500)
#

INSERT INTO `status` (`id`, `category`) VALUES 
  (1,'In Transit'),
  (2,'Scheduled'),
  (3,'DELIVERED'),
  (4,'Connecting Route'),
  (5,'For Pick-Up'),
  (6,'For Delivery'),
  (7,'Arrived at Destination'),
  (8,'Offloaded'),
  (9,'Connecting Route Via Manila');
COMMIT;

#
# Data for the `ty_ship` table  (LIMIT 0,500)
#

INSERT INTO `ty_ship` (`id`, `code`, `category`, `remarks`, `creation_date`, `last_modified_date`, `created_by`) VALUES 
  (1,NULL,'General Cargo',NULL,NULL,NULL,0),
  (2,NULL,'Perishable',NULL,NULL,NULL,0),
  (3,NULL,'Valuable Item',NULL,NULL,NULL,0);
COMMIT;

#
# Data for the `user_types` table  (LIMIT 0,500)
#

INSERT INTO `user_types` (`id`, `type_code`, `type_name`, `type_description`, `creation_date`, `last_modified_date`) VALUES 
  (1,'ADMIN','Admin','Super Admin','2014-04-30 22:08:50','2014-04-30 22:08:50'),
  (2,'STATION_ADMIN','Station Admin','Station Admin','2014-04-30 22:08:38','2014-04-30 22:08:38'),
  (3,'MANAGER','Station Manager','Branch Manager','2014-04-30 22:08:39','2014-04-30 22:08:39'),
  (4,'CARGO','Cargo','Cargo Forwarder','2014-04-30 22:08:39','2014-04-30 22:08:39'),
  (5,'EXCESS_BAGGAGE','Excess Baggage','Excess Baggage','2014-04-30 22:08:39','2014-04-30 22:08:39'),
  (6,'SORTER','Sorter','Sorter','2014-04-30 22:08:39','2014-04-30 22:08:39'),
  (7,'SO_AGENT','Satellite Office Agent','Satellite Office Agent or Staff','2014-04-30 22:08:39','2014-04-30 22:08:39');
COMMIT;

#
# Data for the `users` table  (LIMIT 0,500)
#

INSERT INTO `users` (`id`, `user_type_id`, `code`, `identification_type`, `identification_no`, `username`, `name`, `password`, `address`, `station_id`, `phone`, `email`, `creation_date`, `last_modified_date`, `satellite_office_id`, `created_by`) VALUES 
  (1,1,'ADMIN',-1,NULL,'admin','Administrator','administrator123!@#',NULL,NULL,NULL,'admin@cargoking.com.ph','2014-04-30 23:22:20','2014-04-30 23:22:20',NULL,0),
  (15,2,'STATION-ADM-DVO',-1,'','stationadmindavao','Station Administrator Davao','asdf1234',NULL,8,'(82) 305-2116','stationadmindavao@cargoking.com.ph','2014-05-12 04:29:14','2014-05-12 04:29:14',NULL,0),
  (16,2,'STATION-ADM-MNL',-1,'','stationadminmla','Station Administrator Metro Manila','asdf1234',NULL,6,'(2) 713-1256','stationadminmnl@cargoking.com.ph','2014-05-13 22:51:04','2014-05-13 22:51:04',NULL,0),
  (17,3,'MANAGER-DVO',-1,'asdf1234','stationmgrdvo','Station Manager Davao City','asdf1234',NULL,8,'(082) 305 - 0299','stationmgrdvo@cargoking.com.ph','2014-05-14 00:22:05','2014-05-30 07:25:43',NULL,15),
  (18,2,'STATION-ADM-CEBU',-1,'','stationadmincebu','Station Administrator Cebu City','asdf1234',NULL,7,'(032) 211-2561','stationadmincebu@cargoking.com.ph','2014-05-14 01:26:44','2014-05-14 01:26:44',NULL,0),
  (19,3,'MANAGER-MNL',-1,'asdf1234','stationmgrmnl','Station Manager Manila','asdf1234',NULL,6,'(02) 766-1261','stationmgrmnl@cargoking.com.ph','2014-05-14 01:27:50','2014-05-14 01:27:50',NULL,0),
  (20,6,'STATION-SORTER-DVO01',1,'6-73378-9','stationsorterdvo01','Station Sorter Davao City 01','asdf1234',NULL,8,'(082) 245-1511','stationsorterdvo01@cargoking.com.ph','2014-05-30 06:35:02','2014-05-30 07:27:34',NULL,15),
  (21,7,'CK-DVO-BUHANGIN-01',1,'8-9349-88','ckdvobuhangin01','Cargo King Davao Buhangin','qwer1234',NULL,8,'(082) 221-0091','ckdvobuhangin01@cargoking.com.ph','2014-05-30 07:23:12','2014-05-30 07:28:48',215,15),
  (22,6,'STATION-SORTER-DVO02',1,'123-4566-78','stationsorterdvo02','Station Sorter Davao City 02','asdf1234',NULL,8,'(082) 245-1511','stationsorterdvo02@cargoking.com.ph','2014-05-30 07:26:57','2014-05-30 07:26:57',NULL,NULL),
  (23,5,'STATION-DVO-EXS-BAGGAGE',1,'3-8888-6','stationexcessbaggagedvo','Davao Station Excess Baggage','asdf1234',NULL,8,'(082) 305-0926','stationexcessbaggagedvo@cargoking.com.ph','2014-05-30 07:28:25','2014-05-30 07:28:33',NULL,15),
  (24,7,'CK-SO-AGENT-CBU-TLSY-01',1,'5-457574-88','cksoagenttalisaycebu','CK SO Agent Talisay Cebu 01','qwer1234',NULL,7,'(032) 516-6435','cksoagenttalisaycebu01@cargoking.com.ph','2014-06-02 06:29:20','2014-06-02 06:29:20',45,NULL);
COMMIT;

#
# Data for the `weight` table  (LIMIT 0,500)
#

INSERT INTO `weight` (`id`, `weightvalue`, `delarea`, `fcharge`, `vat`, `rate`, `commission`, `duecar`) VALUES 
  (19,'1',1,98.21,11.79,110,24.55,85.45),
  (20,'1',2,155,18.6,173.6,38.75,134.85),
  (21,'0.5',1,80.36,9.64,90,20.09,69.91),
  (22,'2',1,107.14,12.86,120,26.79,93.21),
  (23,'3',1,245,0,245,61.25,183.75),
  (24,'4',1,380,0,380,95,285),
  (25,'5',1,380,0,380,95,285),
  (26,'6',1,750,0,750,187.5,562.5),
  (27,'7',1,750,0,750,187.5,562.5),
  (28,'8',1,750,0,750,187.5,562.5),
  (29,'9',1,750,0,750,187.5,562.5),
  (30,'10',1,750,0,750,187.5,562.5),
  (31,'11',1,815,0,815,203.75,611.25),
  (32,'12',1,880,0,880,220,660),
  (33,'13',1,945,0,945,236.25,708.75),
  (34,'14',1,1010,0,1010,252.5,757.5),
  (35,'15',1,1075,0,1075,268.75,806.25),
  (36,'16',1,1140,0,1140,285,855),
  (37,'17',1,1205,0,1205,301.25,903.75),
  (38,'18',1,1270,0,1270,317.5,952.5),
  (39,'19',1,1335,0,1335,333.75,1001.25),
  (40,'20',1,1400,0,1400,350,1050),
  (41,'21',1,1465,0,1465,366.25,1098.75),
  (42,'22',1,1530,0,1530,382.5,1147.5),
  (43,'23',1,1595,0,1595,398.75,1196.25),
  (44,'24',1,1660,0,1660,415,1245),
  (45,'25',1,1725,0,1725,431.25,1293.75),
  (46,'26',1,1790,0,1790,447.5,1342.5),
  (47,'27',1,1855,0,1855,463.75,1391.25),
  (48,'28',1,1920,0,1920,480,1440),
  (49,'29',1,1985,0,1985,496.25,1488.75),
  (50,'30',1,2050,0,2050,512.5,1537.5),
  (51,'31',1,2115,0,2115,528.75,1586.25),
  (52,'32',1,2180,0,2180,545,1635),
  (53,'33',1,2245,0,2245,561.25,1683.75),
  (54,'34',1,0,0,2310,577.5,0),
  (55,'35',1,2375,0,2375,593.75,1781.25),
  (56,'36',1,2440,0,2440,610,1830),
  (57,'37',1,2505,0,2505,626.25,1878.75),
  (58,'38',1,2570,0,2570,642.5,1927.5),
  (59,'39',1,2635,0,2635,658.75,1976.25),
  (60,'40',1,2700,0,2700,675,2025),
  (61,'41',1,2765,0,2765,691.25,2073.75),
  (62,'42',1,2830,0,2830,707.5,2122.5),
  (63,'43',1,2895,0,2895,723.75,2171.25),
  (64,'44',1,2960,0,2960,740,2220),
  (65,'45',1,0,0,3025,756.25,0),
  (66,'46',1,3090,0,3090,772.5,2317.5),
  (67,'47',1,3155,0,3155,788.75,2366.25),
  (68,'48',1,3220,0,3220,805,2415),
  (69,'49',1,3285,0,3285,821.25,2463.75),
  (70,'0.5',2,109,13.08,122.08,27.25,94.83),
  (71,'2',2,170,20.4,190.4,42.5,147.9),
  (72,'3',2,295,0,295,73.75,221.25),
  (73,'4',2,430,0,430,107.5,322.5),
  (74,'5',2,430,0,430,107.5,322.5),
  (75,'6',2,810,0,810,202.5,607.5),
  (76,'7',2,810,0,810,202.5,607.5),
  (77,'8',2,810,0,810,202.5,607.5),
  (78,'9',2,810,0,810,202.5,607.5),
  (79,'10',2,810,0,810,202.5,607.5),
  (80,'11',2,875,0,875,218.75,656.25),
  (81,'12',2,940,0,940,235,705),
  (82,'13',2,1005,0,1005,251.25,753.75),
  (83,'14',2,1070,0,1070,267.5,802.5),
  (84,'15',2,1135,0,1135,283.75,851.25),
  (85,'16',2,1200,0,1200,300,900),
  (86,'17',2,1265,0,1265,316.25,948.75),
  (87,'18',2,1330,0,1330,332.5,997.5),
  (88,'19',2,1395,0,1395,348.75,1046.25),
  (89,'20',2,1460,0,1460,365,1095),
  (90,'21',2,1525,0,1525,381.25,1143.75),
  (91,'22',2,1590,0,1590,397.5,1192.5),
  (92,'23',2,1655,0,1655,413.75,1241.25),
  (93,'24',2,1720,0,1720,430,1290),
  (94,'25',2,1785,0,1785,446.25,1338.75),
  (95,'26',2,1850,0,1850,462.5,1387.5),
  (96,'27',2,1915,0,1915,478.75,1436.25),
  (97,'28',2,1980,0,1980,495,1485),
  (98,'29',2,2045,0,2045,511.25,1533.75),
  (99,'30',2,2110,0,2110,527.5,1582.5),
  (100,'31',2,2175,0,2175,543.75,1631.25),
  (101,'32',2,2240,0,2240,560,1680),
  (102,'33',2,2305,0,2305,576.25,1728.75),
  (103,'34',2,2370,0,2370,592.5,1777.5),
  (104,'35',2,2435,0,2435,608.75,1826.25),
  (105,'36',2,2500,0,2500,625,1875),
  (106,'37',2,2565,0,2565,641.25,1923.75),
  (107,'38',2,2630,0,2630,657.5,1972.5),
  (108,'39',2,2695,0,2695,673.75,2021.25),
  (109,'40',2,2768,0,2768,692,2076),
  (110,'41',2,2825,0,2825,706.25,2118.75),
  (111,'42',2,2890,0,2890,722.5,2167.5),
  (112,'43',2,2955,0,2955,738.75,2216.25),
  (113,'44',2,3020,0,3020,755,2265),
  (114,'45',2,3085,0,3085,771.25,2313.75),
  (115,'46',2,3150,0,3150,787.5,2362.5),
  (116,'47',2,3215,0,3215,803.75,2411.25),
  (117,'48',2,3280,0,3280,820,2460),
  (118,'49',2,3345,0,3345,836.25,2508.75),
  (125,'50',2,1900,0,1900,475,1425),
  (126,'51',2,1938,0,1938,484.5,1453.5),
  (127,'52',2,1976,0,1976,494,1482),
  (128,'50-1000',1,38,0,38,0,0),
  (129,'50-1000',2,38,0,38,0,0),
  (130,'1001--',1,25,0,25,0,0),
  (131,'1001--',2,25,0,25,0,0),
  (132,'3.1',1,380,0,380,95,285),
  (133,'3.2',1,380,0,380,95,285),
  (134,'3.3',1,380,0,380,95,285),
  (135,'3.4',1,380,0,380,95,285),
  (136,'3.5',1,380,0,380,95,285),
  (137,'3.6',1,380,0,380,95,285),
  (138,'3.7',1,380,0,380,95,285),
  (139,'3.8',1,380,0,380,95,285),
  (140,'3.9',1,380,0,380,95,285),
  (141,'4.1',1,380,0,380,95,285),
  (142,'4.2',1,380,0,380,95,285),
  (143,'4.3',1,380,0,380,95,285),
  (144,'4.4',1,380,0,380,95,285),
  (145,'4.5',1,380,0,380,95,285),
  (146,'4.6',1,380,0,380,95,285),
  (147,'4.7',1,380,0,380,95,285),
  (148,'4.8',1,380,0,380,95,285),
  (149,'4.9',1,380,0,380,95,285),
  (150,'5.1',1,750,0,750,187.5,562.5),
  (151,'5.2',1,750,0,750,187.5,562.5),
  (152,'5.3',1,750,0,750,187.5,562.5),
  (153,'5.4',1,750,0,750,187.5,562.5),
  (154,'5.5',1,750,0,750,187.5,562.5),
  (155,'5.6',1,750,0,750,187.5,562.5),
  (156,'5.7',1,750,0,750,187.5,562.5),
  (157,'5.8',1,750,0,750,187.5,562.5),
  (158,'5.9',1,750,0,750,187.5,562.5),
  (159,'6.1',1,750,0,750,187.5,562.5),
  (160,'6.2',1,750,0,750,187.5,562.5),
  (161,'6.3',1,750,0,750,187.5,562.5),
  (162,'6.4',1,750,0,750,187.5,562.5),
  (163,'6.5',1,750,0,750,187.5,562.5),
  (164,'6.6',1,750,0,750,187.5,562.5),
  (165,'6.7',1,750,0,750,187.5,562.5),
  (166,'6.8',1,750,0,750,187.5,562.5),
  (167,'6.9',1,750,0,750,187.5,562.5),
  (196,'1',3,400,0,400,0,400),
  (197,'5',3,400,0,400,0,400),
  (198,'1',4,950,0,950,0,950),
  (199,'10',4,950,0,950,0,950),
  (200,'6',3,450,0,450,0,450),
  (201,'11',4,1045,0,1045,0,1045);
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;