INSERT INTO `#__categories` (`id`, `asset_id`, `parent_id`, `lft`, `rgt`, `level`, `path`, `extension`, `title`, `alias`, `note`, `description`, `published`, `checked_out`, `checked_out_time`, `access`, `params`, `metadesc`, `metakey`, `metadata`, `created_user_id`, `created_time`, `modified_user_id`, `modified_time`, `hits`, `language`, `version`) VALUES
(NULL, 106, 1, 35, 36, 1, 'jazz', 'com_guitar', 'Jazz', 'jazz', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":""}', '', '', '{"author":"","robots":""}', 43, '2013-01-27 16:44:05', 0, '0000-00-00 00:00:00', 0, '*', 1),
(NULL, 107, 1, 37, 38, 1, 'classical', 'com_guitar', 'Classical', 'classical', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":""}', '', '', '{"author":"","robots":""}', 43, '2013-01-27 16:44:15', 0, '0000-00-00 00:00:00', 0, '*', 1);

DROP TABLE IF EXISTS `#__guitar_songs`;

CREATE TABLE IF NOT EXISTS `#__guitar_songs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `album` varchar(250) NOT NULL DEFAULT '',
  `song` text NOT NULL,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(255) DEFAULT NULL,
  `metadesc` varchar(1024) DEFAULT NULL,
  `metakey` varchar(1024) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NULL,
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT IGNORE INTO `#__guitar_songs` (`id`,`album`,`song`, `catid`) VALUES
	(1, 'Skunk Funk', 'Near You', (SELECT id FROM #__categories WHERE extension = 'com_guitar' and title = 'Jazz' LIMIT 1),
	(2, 'Dolphin Dance', 'Joy Spring', (SELECT id FROM #__categories WHERE extension = 'com_guitar' and title = 'Classical' LIMIT 1));