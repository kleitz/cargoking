DROP DATABASE IF EXISTS `ehi8so1c_cargoking`;

CREATE DATABASE `ehi8so1c_cargoking`
    CHARACTER SET 'latin1'
    COLLATE 'latin1_swedish_ci';

USE `ehi8so1c_cargoking`;



DROP TABLE IF EXISTS `area_location`;

CREATE TABLE `area_location` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `area_name` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `area_code` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `address` VARCHAR(500) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=20 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `prefix` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
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
  `hawb_status` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
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
  `created_by` INTEGER(11) DEFAULT '1',
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `booking_status`;

CREATE TABLE `booking_status` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `hawb_id` INTEGER(11) DEFAULT NULL,
  `hawb_code` VARCHAR(50) COLLATE latin1_general_ci DEFAULT NULL,
  `status_date` DATE DEFAULT NULL,
  `status_time` TIME DEFAULT NULL,
  `location_id` INTEGER(11) DEFAULT NULL,
  `satellite_office_id` INTEGER(11) DEFAULT NULL,
  `status_id` INTEGER(11) DEFAULT NULL,
  `comments` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT '1',
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1227 CHARACTER SET 'latin1' COLLATE 'latin1_general_ci';



DROP TABLE IF EXISTS `bplace`;

CREATE TABLE `bplace` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `category` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `address` VARCHAR(500) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=19 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `branch`;

CREATE TABLE `branch` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `branch_name` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `branch_description` TEXT COLLATE latin1_swedish_ci,
  `branch_code` VARCHAR(15) COLLATE latin1_swedish_ci DEFAULT NULL,
  `contact_person` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `address1` TEXT COLLATE latin1_swedish_ci,
  `address2` TEXT COLLATE latin1_swedish_ci,
  `city` VARCHAR(23) COLLATE latin1_swedish_ci DEFAULT NULL,
  `business_no` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `fax_no` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `station_id` INTEGER(11) NOT NULL,
  `latitude` DECIMAL(10,0) NOT NULL DEFAULT '0',
  `longitude` DECIMAL(10,0) NOT NULL DEFAULT '0',
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



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
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=2197 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `delivery_area`;

CREATE TABLE `delivery_area` (
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
AUTO_INCREMENT=268 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `movement_type`;

CREATE TABLE `movement_type` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `movement_type` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=7 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `payment_mode`;

CREATE TABLE `payment_mode` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `payment_mode` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=10 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `name` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `description` VARCHAR(100) COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `service_mode`;

CREATE TABLE `service_mode` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `service_mode` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=7 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `shipment_type`;

CREATE TABLE `shipment_type` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `type_of_shipment` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `code` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=5 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `station`;

CREATE TABLE `station` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `station_name` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `station_description` TEXT COLLATE latin1_swedish_ci,
  `station_code` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `station_remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `status_code` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `description` TEXT COLLATE latin1_swedish_ci,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=12 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `user_type_permissions`;

CREATE TABLE `user_type_permissions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` INTEGER(11) NOT NULL,
  `permission_id` INTEGER(11) NOT NULL,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `user_types` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `type_code` VARCHAR(20) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `type_name` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `type_description` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `type_name` (`type_name`),
  UNIQUE KEY `type_code` (`type_code`)
)ENGINE=InnoDB
AUTO_INCREMENT=8 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` INTEGER(11) NOT NULL,
  `code` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT '',
  `identification_type` TINYINT(4) NOT NULL DEFAULT '-1',
  `identification_no` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `username` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `firstname` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N/A',
  `lastname` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N/A',
  `middlename` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N/A',
  `password` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `address` TEXT COLLATE latin1_swedish_ci,
  `station_id` INTEGER(11) DEFAULT NULL,
  `phone` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` VARCHAR(100) COLLATE latin1_swedish_ci DEFAULT NULL,
  `satellite_office_id` INTEGER(11) DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`)
)ENGINE=InnoDB
AUTO_INCREMENT=34 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `vec`;

CREATE TABLE `vec` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `station_id` MEDIUMINT(9) DEFAULT NULL,
  `model_year` TEXT COLLATE latin1_swedish_ci,
  `plate_no` VARCHAR(10) COLLATE latin1_swedish_ci DEFAULT NULL,
  `vehicle_infos` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=2 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



DROP TABLE IF EXISTS `weight_category`;

CREATE TABLE `weight_category` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `weightvalue` VARCHAR(10) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `delarea` FLOAT NOT NULL,
  `fcharge` FLOAT NOT NULL,
  `vat` FLOAT NOT NULL,
  `rate` FLOAT NOT NULL,
  `commission` FLOAT NOT NULL,
  `duecar` FLOAT NOT NULL,
  `created_by` INTEGER(11) DEFAULT '1',
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT '1',
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=205 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



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
    (((((((((`booking` `b` left join `vw_loginusers` `u` on((`u`.`id` = `b`.`created_by`))) left join `bplace` `o` on((`o`.`id` = `b`.`origin`))) left join `bplace` `s` on((`s`.`id` = `b`.`destination`))) left join `weight` `w` on((`w`.`id` = `b`.`weight_ref_id`))) left join `mop` on((`mop`.`id` = `b`.`payment_mode_id`))) left join `movement` `mov` on((`mov`.`id` = `b`.`movement_type_id`))) left join `servicemode` `srv` on((`srv`.`id` = `b`.`service_mode_id`))) left join `status` `st` on((`st`.`id` = `b`.`hawb_status`))) left join `delivery_area` `so` on((`so`.`id` = `b`.`satellite_office_id`)));



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



DROP VIEW IF EXISTS `vw_booking_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_status` AS 
  select 
    `booking_status`.`hawb_id` AS `hawb_id`,
    max(concat(`booking_status`.`status_date`,' ',`booking_status`.`status_time`)) AS `status_datetime` 
  from 
    `booking_status` 
  group by 
    `booking_status`.`hawb_id`;



DROP VIEW IF EXISTS `vw_booking_status_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_booking_status_details` AS 
  select 
    `bs`.`id` AS `id`,
    `bs`.`hawb_id` AS `hawb_id`,
    `bs`.`hawb_code` AS `hawb_code`,
    `a`.`status_datetime` AS `status_datetime`,
    `bs`.`location_id` AS `location_id`,
    `bs`.`status_id` AS `status_id`,
    `bs`.`created_by` AS `updated_by` 
  from 
    (`booking_status` `bs` join `vw_booking_status` `a` on((`a`.`status_datetime` = concat(`bs`.`status_date`,' ',`bs`.`status_time`))));



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
    ((`customer` `c` join `bplace` `st` on((`st`.`id` = `c`.`station_id`))) left join `delivery_area` `so` on((`so`.`id` = `c`.`satellite_office_id`)));



DROP VIEW IF EXISTS `vw_hawb_items`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_hawb_items` AS 
  select 
    `bd`.`id` AS `id`,
    `bd`.`booking_id` AS `booking_id`,
    `bd`.`booking_code` AS `booking_code`,
    `bd`.`shipment_type_id` AS `shipment_type_id`,
    ifnull(`st`.`type_of_shipment`,'N/A') AS `shipment_type`,
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
    (`booking_item_details` `bd` left join `shipment_type` `st` on((`st`.`id` = `bd`.`shipment_type_id`)));



DROP VIEW IF EXISTS `vw_loginusers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_loginusers` AS 
  select 
    `u`.`id` AS `id`,
    `u`.`user_type_id` AS `user_type_id`,
    `ut`.`type_code` AS `type_code`,
    `ut`.`type_name` AS `type_name`,
    `u`.`username` AS `username`,
    `u`.`firstname` AS `firstname`,
    `u`.`lastname` AS `lastname`,
    `u`.`middlename` AS `middlename`,
    concat(ifnull(`u`.`firstname`,''),' ',ifnull(`u`.`lastname`,'')) AS `full_name`,
    `u`.`password` AS `password`,
    ifnull(`u`.`address`,'N/A') AS `address`,
    `u`.`email` AS `email`,
    ifnull(`u`.`phone`,'N/A') AS `contact_number`,
    `u`.`station_id` AS `station_id`,
    `u`.`satellite_office_id` AS `satellite_office_id`,
    `so`.`station_hawb_prefix` AS `hawb_booking_prefix` 
  from 
    ((`users` `u` join `user_types` `ut` on((`ut`.`id` = `u`.`user_type_id`))) left join `delivery_area` `so` on((`so`.`id` = `u`.`satellite_office_id`)));



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
    (`users` `u` left join `delivery_area` `da` on((`da`.`id` = `u`.`satellite_office_id`))) 
  where 
    (`u`.`user_type_id` = 7);



DROP VIEW IF EXISTS `vw_track_booking`;

CREATE ALGORITHM=UNDEFINED VIEW `vw_track_booking`
AS;
