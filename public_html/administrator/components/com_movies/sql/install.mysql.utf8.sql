CREATE TABLE IF NOT EXISTS `#__movies_movie` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`description` TEXT NOT NULL ,
`release_date` DATE NOT NULL ,
`review` TEXT NOT NULL ,
`rating` VARCHAR(255)  NOT NULL ,
`director` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

