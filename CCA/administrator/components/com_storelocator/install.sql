CREATE TABLE IF NOT EXISTS `#__storelocator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `address` text NOT NULL,
  `lat` double NOT NULL DEFAULT '0',
  `lng` double NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '1',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `website` text NOT NULL,
  `fulladdress` text NOT NULL,
  `facebook` varchar(500) NOT NULL,
  `twitter` varchar(64) NOT NULL,
  `email` varchar(200) NOT NULL,
  `cust1` text NOT NULL,
  `cust2` text NOT NULL,
  `cust3` text NOT NULL,
  `cust4` text NOT NULL,
  `cust5` text NOT NULL,
  `featured` int(11) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_featured` (`featured`),
  KEY `idx_catid` (`catid`),
  KEY `idx_lat` (`lat`),
  KEY `idx_lng` (`lng`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__storelocator_cat` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(500) NOT NULL,
  `markerid` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

REPLACE INTO `#__storelocator_cat` (`id`,`name`) VALUES (1,'General');

CREATE TABLE IF NOT EXISTS `#__storelocator_tags` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(500) NOT NULL,
  `marker_id` int(11) NOT NULL DEFAULT '1',
  `feature_marker_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__storelocator_tag_map` (
  `tag_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
   UNIQUE (`tag_id`, `location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__storelocator_marker_types` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(1000) NOT NULL,
  `shadow_url` varchar(1000) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__storelocator_log_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(45) NOT NULL,
  `query` varchar(2000) NOT NULL,
  `lat` decimal(10,0) DEFAULT NULL,
  `long` decimal(10,0) DEFAULT NULL,
  `limited` int(11) DEFAULT NULL,
  `search_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IDX_LAT` (`lat`),
  KEY `IDX_LONG` (`long`),
  KEY `IDX_IP` (`ipaddress`),
  KEY `IDX_LIMIT` (`limited`),
  KEY `IDX_TIME` (`search_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('1', 'blue-dot', 'http://maps.google.com/mapfiles/ms/micons/blue-dot.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('2', 'red-dot', 'http://maps.google.com/mapfiles/ms/micons/red-dot.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('3', 'green-dot', 'http://maps.google.com/mapfiles/ms/micons/green-dot.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('4', 'ltblue-dot', 'http://maps.google.com/mapfiles/ms/micons/ltblue-dot.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('5', 'yellow-dot', 'http://maps.google.com/mapfiles/ms/micons/yellow-dot.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('6', 'purple-dot', 'http://maps.google.com/mapfiles/ms/micons/purple-dot.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('7', 'pink-dot', 'http://maps.google.com/mapfiles/ms/micons/pink-dot.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('8', 'blue', 'http://maps.google.com/mapfiles/ms/micons/blue.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('9', 'red', 'http://maps.google.com/mapfiles/ms/micons/red.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('10', 'green', 'http://maps.google.com/mapfiles/ms/micons/green.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('11', 'lightblue', 'http://maps.google.com/mapfiles/ms/micons/lightblue.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('12', 'yellow', 'http://maps.google.com/mapfiles/ms/micons/yellow.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('13', 'purple', 'http://maps.google.com/mapfiles/ms/micons/purple.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('14', 'pink', 'http://maps.google.com/mapfiles/ms/micons/pink.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('15', 'blue-pushpin', 'http://maps.google.com/mapfiles/ms/micons/blue-pushpin.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('16', 'red-pushpin', 'http://maps.google.com/mapfiles/ms/micons/red-pushpin.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('17', 'grn-pushpin', 'http://maps.google.com/mapfiles/ms/micons/grn-pushpin.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('18', 'ltblu-pushpin', 'http://maps.google.com/mapfiles/ms/micons/ltblu-pushpin.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('19', 'ylw-pushpin', 'http://maps.google.com/mapfiles/ms/micons/ylw-pushpin.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('20', 'purple-pushpin', 'http://maps.google.com/mapfiles/ms/micons/purple-pushpin.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('21', 'pink-pushpin', 'http://maps.google.com/mapfiles/ms/micons/pink-pushpin.png', 'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('22', 'restaurant', 'http://maps.google.com/mapfiles/ms/micons/restaurant.png', 'http://maps.google.com/mapfiles/ms/micons/restaurant.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('23', 'coffeehouse', 'http://maps.google.com/mapfiles/ms/micons/coffeehouse.png', 'http://maps.google.com/mapfiles/ms/micons/coffeehouse.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('24', 'bar', 'http://maps.google.com/mapfiles/ms/micons/bar.png', 'http://maps.google.com/mapfiles/ms/micons/bar.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('25', 'snack_bar', 'http://maps.google.com/mapfiles/ms/micons/snack_bar.png', 'http://maps.google.com/mapfiles/ms/micons/snack_bar.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('26', 'man', 'http://maps.google.com/mapfiles/ms/micons/man.png', 'http://maps.google.com/mapfiles/ms/micons/man.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('27', 'woman', 'http://maps.google.com/mapfiles/ms/micons/woman.png', 'http://maps.google.com/mapfiles/ms/micons/woman.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('28', 'wheel_chair_accessible', 'http://maps.google.com/mapfiles/ms/micons/wheel_chair_accessible.png', 'http://maps.google.com/mapfiles/ms/micons/wheel_chair_accessible.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('29', 'parkinglot', 'http://maps.google.com/mapfiles/ms/micons/parkinglot.png', 'http://maps.google.com/mapfiles/ms/micons/parkinglot.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('30', 'cabs', 'http://maps.google.com/mapfiles/ms/micons/cabs.png', 'http://maps.google.com/mapfiles/ms/micons/cabs.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('31', 'bus', 'http://maps.google.com/mapfiles/ms/micons/bus.png', 'http://maps.google.com/mapfiles/ms/micons/bus.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('32', 'truck', 'http://maps.google.com/mapfiles/ms/micons/truck.png', 'http://maps.google.com/mapfiles/ms/micons/truck.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('33', 'rail', 'http://maps.google.com/mapfiles/ms/micons/rail.png', 'http://maps.google.com/mapfiles/ms/micons/rail.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('34', 'plane', 'http://maps.google.com/mapfiles/ms/micons/plane.png', 'http://maps.google.com/mapfiles/ms/micons/plane.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('35', 'ferry', 'http://maps.google.com/mapfiles/ms/micons/ferry.png', 'http://maps.google.com/mapfiles/ms/micons/ferry.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('36', 'helicopter', 'http://maps.google.com/mapfiles/ms/micons/helicopter.png', 'http://maps.google.com/mapfiles/ms/micons/helicopter.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('37', 'subway', 'http://maps.google.com/mapfiles/ms/micons/subway.png', 'http://maps.google.com/mapfiles/ms/micons/subway.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('38', 'tram', 'http://maps.google.com/mapfiles/ms/micons/tram.png', 'http://maps.google.com/mapfiles/ms/micons/tram.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('39', 'info', 'http://maps.google.com/mapfiles/ms/micons/info.png', 'http://maps.google.com/mapfiles/ms/micons/info.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('40', 'info_circle', 'http://maps.google.com/mapfiles/ms/micons/info_circle.png', 'http://maps.google.com/mapfiles/ms/micons/info_circle.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('41', 'flag', 'http://maps.google.com/mapfiles/ms/micons/flag.png', 'http://maps.google.com/mapfiles/ms/micons/flag.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('42', 'rainy', 'http://maps.google.com/mapfiles/ms/micons/rainy.png', 'http://maps.google.com/mapfiles/ms/micons/rainy.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('43', 'water', 'http://maps.google.com/mapfiles/ms/micons/water.png', 'http://maps.google.com/mapfiles/ms/micons/water.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('44', 'snowflake_simple', 'http://maps.google.com/mapfiles/ms/micons/snowflake_simple.png', 'http://maps.google.com/mapfiles/ms/micons/snowflake_simple.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('45', 'marina', 'http://maps.google.com/mapfiles/ms/micons/marina.png', 'http://maps.google.com/mapfiles/ms/micons/marina.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('46', 'fishing', 'http://maps.google.com/mapfiles/ms/micons/fishing.png', 'http://maps.google.com/mapfiles/ms/micons/fishing.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('47', 'sailing', 'http://maps.google.com/mapfiles/ms/micons/sailing.png', 'http://maps.google.com/mapfiles/ms/micons/sailing.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('48', 'swimming', 'http://maps.google.com/mapfiles/ms/micons/swimming.png', 'http://maps.google.com/mapfiles/ms/micons/swimming.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('49', 'ski', 'http://maps.google.com/mapfiles/ms/micons/ski.png', 'http://maps.google.com/mapfiles/ms/micons/ski.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('50', 'tree', 'http://maps.google.com/mapfiles/ms/micons/tree.png', 'http://maps.google.com/mapfiles/ms/micons/tree.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('51', 'campfire', 'http://maps.google.com/mapfiles/ms/micons/campfire.png', 'http://maps.google.com/mapfiles/ms/micons/campfire.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('52', 'picnic', 'http://maps.google.com/mapfiles/ms/micons/picnic.png', 'http://maps.google.com/mapfiles/ms/micons/picnic.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('53', 'campground', 'http://maps.google.com/mapfiles/ms/micons/campground.png', 'http://maps.google.com/mapfiles/ms/micons/campground.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('54', 'rangerstation', 'http://maps.google.com/mapfiles/ms/micons/rangerstation.png', 'http://maps.google.com/mapfiles/ms/micons/rangerstation.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('55', 'toilets', 'http://maps.google.com/mapfiles/ms/micons/toilets.png', 'http://maps.google.com/mapfiles/ms/micons/toilets.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('56', 'POI', 'http://maps.google.com/mapfiles/ms/micons/POI.png', 'http://maps.google.com/mapfiles/ms/micons/POI.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('57', 'hiker', 'http://maps.google.com/mapfiles/ms/micons/hiker.png', 'http://maps.google.com/mapfiles/ms/micons/hiker.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('58', 'cycling', 'http://maps.google.com/mapfiles/ms/micons/cycling.png', 'http://maps.google.com/mapfiles/ms/micons/cycling.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('59', 'motorcycling', 'http://maps.google.com/mapfiles/ms/micons/motorcycling.png', 'http://maps.google.com/mapfiles/ms/micons/motorcycling.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('60', 'horsebackriding', 'http://maps.google.com/mapfiles/ms/micons/horsebackriding.png', 'http://maps.google.com/mapfiles/ms/micons/horsebackriding.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('61', 'sportvenue', 'http://maps.google.com/mapfiles/ms/micons/sportvenue.png', 'http://maps.google.com/mapfiles/ms/micons/sportvenue.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('62', 'golfer', 'http://maps.google.com/mapfiles/ms/micons/golfer.png', 'http://maps.google.com/mapfiles/ms/micons/golfer.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('63', 'trail', 'http://maps.google.com/mapfiles/ms/micons/trail.png', 'http://maps.google.com/mapfiles/ms/micons/trail.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('64', 'shopping', 'http://maps.google.com/mapfiles/ms/micons/shopping.png', 'http://maps.google.com/mapfiles/ms/micons/shopping.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('65', 'movies', 'http://maps.google.com/mapfiles/ms/micons/movies.png', 'http://maps.google.com/mapfiles/ms/micons/movies.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('66', 'grocerystore', 'http://maps.google.com/mapfiles/ms/micons/grocerystore.png', 'http://maps.google.com/mapfiles/ms/micons/grocerystore.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('67', 'convienancestore', 'http://maps.google.com/mapfiles/ms/micons/convienancestore.png', 'http://maps.google.com/mapfiles/ms/micons/convienancestore.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('68', 'arts', 'http://maps.google.com/mapfiles/ms/micons/arts.png', 'http://maps.google.com/mapfiles/ms/micons/arts.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('69', 'homegardenbusiness', 'http://maps.google.com/mapfiles/ms/micons/homegardenbusiness.png', 'http://maps.google.com/mapfiles/ms/micons/homegardenbusiness.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('70', 'electronics', 'http://maps.google.com/mapfiles/ms/micons/electronics.png', 'http://maps.google.com/mapfiles/ms/micons/electronics.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('71', 'mechanic', 'http://maps.google.com/mapfiles/ms/micons/mechanic.png', 'http://maps.google.com/mapfiles/ms/micons/mechanic.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('72', 'gas', 'http://maps.google.com/mapfiles/ms/micons/gas.png', 'http://maps.google.com/mapfiles/ms/micons/gas.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('73', 'realestate', 'http://maps.google.com/mapfiles/ms/micons/realestate.png', 'http://maps.google.com/mapfiles/ms/micons/realestate.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('74', 'salon', 'http://maps.google.com/mapfiles/ms/micons/salon.png', 'http://maps.google.com/mapfiles/ms/micons/salon.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('75', 'dollar', 'http://maps.google.com/mapfiles/ms/micons/dollar.png', 'http://maps.google.com/mapfiles/ms/micons/dollar.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('76', 'euro', 'http://maps.google.com/mapfiles/ms/micons/euro.png', 'http://maps.google.com/mapfiles/ms/micons/euro.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('77', 'yen', 'http://maps.google.com/mapfiles/ms/micons/yen.png', 'http://maps.google.com/mapfiles/ms/micons/yen.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('78', 'firedept', 'http://maps.google.com/mapfiles/ms/micons/firedept.png', 'http://maps.google.com/mapfiles/ms/micons/firedept.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('79', 'hospitals', 'http://maps.google.com/mapfiles/ms/micons/hospitals.png', 'http://maps.google.com/mapfiles/ms/micons/hospitals.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('80', 'lodging', 'http://maps.google.com/mapfiles/ms/micons/lodging.png', 'http://maps.google.com/mapfiles/ms/micons/lodging.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('81', 'phone', 'http://maps.google.com/mapfiles/ms/micons/phone.png', 'http://maps.google.com/mapfiles/ms/micons/phone.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('82', 'caution', 'http://maps.google.com/mapfiles/ms/micons/caution.png', 'http://maps.google.com/mapfiles/ms/micons/caution.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('83', 'earthquake', 'http://maps.google.com/mapfiles/ms/micons/earthquake.png', 'http://maps.google.com/mapfiles/ms/micons/earthquake.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('84', 'fallingrocks', 'http://maps.google.com/mapfiles/ms/micons/fallingrocks.png', 'http://maps.google.com/mapfiles/ms/micons/fallingrocks.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('85', 'postoffice-us', 'http://maps.google.com/mapfiles/ms/micons/postoffice-us.png', 'http://maps.google.com/mapfiles/ms/micons/postoffice-us.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('86', 'police', 'http://maps.google.com/mapfiles/ms/micons/police.png', 'http://maps.google.com/mapfiles/ms/micons/police.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('87', 'sunny', 'http://maps.google.com/mapfiles/ms/micons/sunny.png', 'http://maps.google.com/mapfiles/ms/micons/sunny.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('88', 'partly_cloudy', 'http://maps.google.com/mapfiles/ms/micons/partly_cloudy.png', 'http://maps.google.com/mapfiles/ms/micons/partly_cloudy.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('89', 'volcano', 'http://maps.google.com/mapfiles/ms/micons/volcano.png', 'http://maps.google.com/mapfiles/ms/micons/volcano.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('90', 'camera', 'http://maps.google.com/mapfiles/ms/micons/camera.png', 'http://maps.google.com/mapfiles/ms/micons/camera.shadow.png');
REPLACE INTO `#__storelocator_marker_types` (`id`,`name`,`image_url`,`shadow_url`) VALUES ('91', 'webcam', 'http://maps.google.com/mapfiles/ms/micons/webcam.png', 'http://maps.google.com/mapfiles/ms/micons/webcam.shadow.png');
