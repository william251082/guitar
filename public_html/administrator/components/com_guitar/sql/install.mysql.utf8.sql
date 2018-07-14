INSERT INTO `ymfgb_categories` (`id`, `asset_id`, `parent_id`, `lft`, `rgt`, `level`, `path`, `extension`, `title`, `alias`, `note`, `description`, `published`, `checked_out`, `checked_out_time`, `access`, `params`, `metadesc`, `metakey`, `metadata`, `created_user_id`, `created_time`, `modified_user_id`, `modified_time`, `hits`, `language`, `version`) VALUES
(NULL, 106, 1, 35, 36, 1, 'jazz', 'com_guitar', 'Jazz', 'jazz', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":""}', '', '', '{"author":"","robots":""}', 43, '2013-01-27 16:44:05', 0, '0000-00-00 00:00:00', 0, '*', 1),
(NULL, 107, 1, 37, 38, 1, 'classical', 'com_guitar', 'Classical', 'classical', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":""}', '', '', '{"author":"","robots":""}', 43, '2013-01-27 16:44:15', 0, '0000-00-00 00:00:00', 0, '*', 1);

DROP TABLE IF EXISTS `ymfgb_guitar_songs`;
CREATE TABLE IF NOT EXISTS `ymfgb_guitar_songs` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
`catid` int(10) unsigned NOT NULL DEFAULT '0',

`song_title` varchar(250) NOT NULL DEFAULT '',
`song_info` text NOT NULL,

`alias` varchar(255) DEFAULT NULL,
`metadesc` varchar(1024) DEFAULT NULL,
`metakey` varchar(1024) DEFAULT NULL,

`created_by` int(10) unsigned NOT NULL DEFAULT '0',
`created_by_alias` varchar(255) NULL,
`modified_by` INT(11)  NOT NULL ,

`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`published` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

`publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL,

PRIMARY KEY (`id`),
KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ymfgb_guitar_guitarists`;
CREATE TABLE `ymfgb_guitar_guitarists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `genre_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `catid` (`catid`)
);

DROP TABLE IF EXISTS `ymfgb_guitar_bands`;
CREATE TABLE `ymfgb_guitar_bands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_id` int(11) DEFAULT NULL,
  `band_name` varchar(255) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `fk_subject_id` (`genre_id`)
);

DROP TABLE IF EXISTS `ymfgb_guitar_albums`;
CREATE TABLE `ymfgb_guitar_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_id` int(11) DEFAULT NULL,
  `album_title` varchar(250) NOT NULL DEFAULT '',
  `album_info` text NOT NULL,
PRIMARY KEY (`id`),
KEY `fk_subject_id` (`genre_id`)
);




INSERT IGNORE INTO `ymfgb_guitar_songs` (`id`,`song_title`,`song_info`, `catid`) VALUES
	(1, 'Skunk Funk', 'Near You', (SELECT id FROM ymfgb_categories WHERE extension = 'com_guitar' and title = 'Jazz' LIMIT 1)),
	(2, 'Dolphin Dance', 'Joy Spring', (SELECT id FROM ymfgb_categories WHERE extension = 'com_guitar' and title = 'Classical' LIMIT 1));
