
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;


CREATE TABLE `category`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(20)  NOT NULL,
	`slug` VARCHAR(20)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `category_U_1` (`name`),
	UNIQUE KEY `category_U_2` (`slug`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- person
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `person`;


CREATE TABLE `person`
(
	`id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`website` VARCHAR(255)  NOT NULL,
	`email` VARCHAR(255)  NOT NULL,
	`image` VARCHAR(255),
	`validated_at` DATETIME,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `person_U_1` (`website`),
	UNIQUE KEY `person_U_2` (`email`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- person_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `person_category`;


CREATE TABLE `person_category`
(
	`person_id` INTEGER(11)  NOT NULL,
	`category_id` INTEGER(11)  NOT NULL,
	PRIMARY KEY (`person_id`,`category_id`),
	UNIQUE KEY `category_slug` (`person_id`, `category_id`),
	CONSTRAINT `person_category_FK_1`
		FOREIGN KEY (`person_id`)
		REFERENCES `person` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `person_category_FI_2` (`category_id`),
	CONSTRAINT `person_category_FK_2`
		FOREIGN KEY (`category_id`)
		REFERENCES `category` (`id`)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- person_hash
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `person_hash`;


CREATE TABLE `person_hash`
(
	`person_id` INTEGER(11)  NOT NULL,
	`hash` VARCHAR(255)  NOT NULL,
	`used` TINYINT default 0 NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`person_id`,`hash`),
	UNIQUE KEY `person_hash_U_1` (`hash`),
	CONSTRAINT `person_hash_FK_1`
		FOREIGN KEY (`person_id`)
		REFERENCES `person` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
