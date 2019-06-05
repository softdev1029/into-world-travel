

CREATE TABLE IF NOT EXISTS `#__travel_gr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gr` int(11) NOT NULL,
  `proc` varchar(50) NOT NULL,
  `ordering` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `alias` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

 
CREATE TABLE IF NOT EXISTS `#__travel_hash` (
  `hash` varchar(50) NOT NULL,
  `file` varchar(300) NOT NULL,
  `data` int(11) NOT NULL,
  `t` int(11) NOT NULL,
  `tip` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 
CREATE TABLE IF NOT EXISTS `#__travel_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordering` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `alias` varchar(300) NOT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

 
CREATE TABLE IF NOT EXISTS `#__travel_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordering` int(11) NOT NULL,
  `first` varchar(300) NOT NULL,
  `alias` varchar(300) NOT NULL,
  `published` int(11) NOT NULL,
  `status` varchar(300) NOT NULL,
  `bronid` int(11) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `last` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `komm` text NOT NULL,
  `data` text NOT NULL,
  `roomid` varchar(50) NOT NULL,
  `title` varchar(5) NOT NULL,
  `created` date NOT NULL,
  `region` int(11) NOT NULL,
  `otel` int(11) NOT NULL,
  `data_start` date NOT NULL,
  `data_end` date NOT NULL,
  `mann` int(11) NOT NULL,
  `kind` int(11) NOT NULL,
  `age1` int(11) NOT NULL,
  `age2` int(11) NOT NULL,
  `age3` int(11) NOT NULL,
  `age4` int(11) NOT NULL,
  `users` int(11) NOT NULL,
  `xml` text NOT NULL,
  `summa` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

 
CREATE TABLE IF NOT EXISTS `#__travel_otel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(300) NOT NULL,
  `cityId` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `alias` varchar(300) NOT NULL,
  `published` int(11) NOT NULL,
  `state` varchar(5) NOT NULL,
  `vid` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `region_id` int(11) NOT NULL,
  `stars` float NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `rank` int(11) NOT NULL,
  `address` text NOT NULL,
  `photo` text NOT NULL,
  `description` text NOT NULL,
  `amenity` text NOT NULL,
  `rating` varchar(1200) NOT NULL,
  `proc` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

 

CREATE TABLE IF NOT EXISTS `#__travel_proc` (
  `type` varchar(10) NOT NULL,
  `proc` varchar(50) NOT NULL,
  `vid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 

CREATE TABLE IF NOT EXISTS `#__travel_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordering` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `alias` varchar(300) NOT NULL,
  `published` int(11) NOT NULL,
  `state` varchar(5) NOT NULL,
  `country` int(11) NOT NULL,
  `country_title` varchar(255) NOT NULL,
  `proc` varchar(50) NOT NULL,
  `proc_strana` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
