SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; START TRANSACTION;
SET time_zone = "+04:00";

CREATE TABLE `user_data` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`ip_address` varchar(255),
	`user_agent` varchar(255),
	`view_date` DATETIME NOT NULL,
	`page_url` varchar(255) NOT NULL,
	`views_count` INT(255) NOT NULL,
	PRIMARY KEY (`id`)
);
