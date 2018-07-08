CREATE TABLE IF NOT EXISTS `#__guitar_songs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `album` varchar(250) NOT NULL DEFAULT '',
  `song` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT IGNORE INTO `#__guitar_songs` (`id`,`album`,`song`) VALUES
	(1, 'Skunk Funk', 'Near You'),
	(2, 'Dolphin Dance', 'Joy Spring');