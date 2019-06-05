DROP TABLE IF EXISTS `#__dacatalog_excursions`;
DROP TABLE IF EXISTS `#__dacatalog_flights`;
DROP TABLE IF EXISTS `#__dacatalog_hotels`;
DROP TABLE IF EXISTS `#__dacatalog_main`;
DROP TABLE IF EXISTS `#__dacatalog_trains`;
DROP TABLE IF EXISTS `#__dacatalog_visa`;

CREATE TABLE IF NOT EXISTS `#__dacatalog_excursions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `currency` varchar(3) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dacatalog_flights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `date1` date NOT NULL,
  `city1From` varchar(3) NOT NULL,
  `city1To` varchar(3) NOT NULL,
  `date2` date NOT NULL,
  `city2From` varchar(3) NOT NULL,
  `city2To` varchar(3) NOT NULL,
  `price` double NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dacatalog_hotels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `stars` tinyint(1) NOT NULL,
  `roomTitle` varchar(255) NOT NULL,
  `price` text NOT NULL,
  `currency` varchar(3) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dacatalog_main` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL,
  `flightId` varchar(255) NOT NULL,
  `hotels` text NOT NULL,
  `excursionId` varchar(255) NOT NULL,
  `trainId` varchar(255) NOT NULL,
  `visaId` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `currency` varchar(3) NOT NULL,
  `tax` double NOT NULL,
  `commission` varchar(50) NOT NULL,
  `discount` tinyint(4) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid_published` (`catid`,`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dacatalog_trains` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `cityFrom` varchar(255) NOT NULL,
  `codeFrom` int(11) NOT NULL,
  `cityTo` varchar(255) NOT NULL,
  `codeTo` int(11) NOT NULL,
  `number` varchar(15) NOT NULL,
  `type` varchar(15) NOT NULL,
  `price` double NOT NULL,
  `currency` varchar(3) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__dacatalog_visa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `currency` varchar(3) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;