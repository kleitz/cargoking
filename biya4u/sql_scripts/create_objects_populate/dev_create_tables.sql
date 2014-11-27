use ehi8so1c_cargoking;

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
  `hawb_status` VARCHAR(25) COLLATE latin1_swedish_ci,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT 1,
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
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
  `created_by` INTEGER(11) DEFAULT 1,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=3 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

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
  `created_by` INTEGER(11) DEFAULT 1,
  `create_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=1227 CHARACTER SET 'latin1' COLLATE 'latin1_general_ci';

CREATE TABLE `area_location` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `area_name` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `area_code` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL,
  `address` VARCHAR(500) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=19 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `station` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `station_name` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL,
  `station_description` TEXT COLLATE latin1_swedish_ci,
  `station_code` VARCHAR(25) COLLATE latin1_swedish_ci,
  `station_remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=19 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `branch` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `branch_name` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `branch_description` TEXT COLLATE latin1_swedish_ci DEFAULT NULL,
  `branch_code` VARCHAR(15) COLLATE latin1_swedish_ci DEFAULT NULL,
  `contact_person` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `address1` TEXT COLLATE latin1_swedish_ci DEFAULT NULL,
  `address2` TEXT COLLATE latin1_swedish_ci DEFAULT NULL,
  `city` VARCHAR(23) COLLATE latin1_swedish_ci DEFAULT NULL,
  `business_no` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `fax_no` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `station_id` INTEGER(11) COLLATE latin1_swedish_ci NOT NULL,
  `latitude` DECIMAL COLLATE latin1_swedish_ci NOT NULL DEFAULT 0,
  `longitude` DECIMAL COLLATE latin1_swedish_ci NOT NULL DEFAULT 0,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

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
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=2197 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `delivery_area` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `area` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `station` TEXT COLLATE latin1_swedish_ci NOT NULL,
  `delarea` INTEGER(11) NOT NULL,
  `station_hawb_prefix` VARCHAR(20) COLLATE latin1_swedish_ci DEFAULT NULL,
  `branch_name` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `address1` TEXT COLLATE latin1_swedish_ci,
  `address2` TEXT COLLATE latin1_swedish_ci,
  `business_number` VARCHAR(15) COLLATE latin1_swedish_ci DEFAULT NULL,
  `fax_number` VARCHAR(15) COLLATE latin1_swedish_ci DEFAULT NULL,
  `mobile_number` VARCHAR(15) COLLATE latin1_swedish_ci DEFAULT NULL,
  `contact_person` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `latitude` DECIMAL(11,5) DEFAULT NULL,
  `longitude` DECIMAL(11,5) DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=267 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `payment_mode` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `payment_mode` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=9 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `movement_type` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `movement_type` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=6 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `service_mode` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `service_mode` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `remarks` TEXT COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=6 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `status` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `status_code` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `description` TEXT COLLATE latin1_swedish_ci,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=11 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `shipment_type` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `type_of_shipment` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `code` VARCHAR(25) COLLATE latin1_swedish_ci DEFAULT NULL,
  `remarks` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=4 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `weight_category` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `weightvalue` VARCHAR(10) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `delarea` FLOAT NOT NULL,
  `fcharge` FLOAT NOT NULL,
  `vat` FLOAT NOT NULL,
  `rate` FLOAT NOT NULL,
  `commission` FLOAT NOT NULL,
  `duecar` FLOAT NOT NULL,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=MyISAM
AUTO_INCREMENT=204 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `vec` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `station_id` MEDIUMINT(9) DEFAULT NULL,
  `model_year` TEXT COLLATE latin1_swedish_ci,
  `plate_no` VARCHAR(10) COLLATE latin1_swedish_ci DEFAULT NULL,
  `vehicle_infos` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';



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
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`)
)ENGINE=InnoDB
AUTO_INCREMENT=28 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `user_types` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `type_code` VARCHAR(20) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `type_name` VARCHAR(25) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `type_description` TEXT COLLATE latin1_swedish_ci,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `type_name` (`type_name`),
  UNIQUE KEY `type_code` (`type_code`)
)ENGINE=InnoDB
AUTO_INCREMENT=8 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `permissions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `name` VARCHAR(50) COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `description` VARCHAR(100) COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';

CREATE TABLE `user_type_permissions` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` INTEGER(11) NOT NULL,
  `permission_id` INTEGER(11) NOT NULL,
  `created_by` INTEGER(11) DEFAULT 1,
  `creation_date` DATETIME DEFAULT NULL,
  `last_modified_by` INTEGER(11) DEFAULT 1,
  `last_modified_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'latin1' COLLATE 'latin1_swedish_ci';