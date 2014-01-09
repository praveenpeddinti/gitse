DROP TABLE IF EXISTS `#__spupgrade_tables`;
CREATE TABLE IF NOT EXISTS `#__spupgrade_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `extension_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'Name of the extension''s table',
  PRIMARY KEY (`id`),
  UNIQUE KEY `extension_name` (`extension_name`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `#__spupgrade_tables` (`id`, `extension_name`, `name`) VALUES
(1, 'com_users', 'users'),
(3, 'com_content', 'sections'),
(4, 'com_content', 'categories'),
(5, 'com_content', 'content'),
(6, 'com_contact', 'categories'),
(7, 'com_contact', 'contact_details'),
(8, 'com_weblinks', 'categories'),
(9, 'com_weblinks', 'weblinks'),
(10, 'com_newsfeeds', 'categories'),
(11, 'com_newsfeeds', 'newsfeeds'),
(12, 'com_banners', 'categories'),
(13, 'com_banners', 'banner_clients'),
(14, 'com_banners', 'banners'),
(15, 'com_menus', 'menu_types'),
(16, 'com_menus', 'menu'),
(17, 'com_modules', 'modules'),
(18, 'com_media', 'images'),
(19, 'com_media', 'template');

DROP TABLE IF EXISTS `#__spupgrade_log`;
CREATE TABLE IF NOT EXISTS `#__spupgrade_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tables_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__spupgrade_tables',
  `note` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `source_id` int(10) unsigned NOT NULL DEFAULT '0',
  `destination_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;