drop table `#__yandex_maps_periods_object`;
CREATE TABLE IF NOT EXISTS `#__yandex_maps_periods_object` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `period_start` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Время начала периода',
  `period_end` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT 'Время конца периода',
  `day1` tinyint(1) unsigned DEFAULT NULL COMMENT 'Понедельник',
  `day2` tinyint(1) unsigned DEFAULT NULL COMMENT 'Вторник',
  `day3` tinyint(1) unsigned DEFAULT NULL COMMENT 'Среда',
  `day4` tinyint(1) unsigned DEFAULT NULL COMMENT 'Четверг',
  `day5` tinyint(1) unsigned DEFAULT NULL COMMENT 'Пятница',
  `day6` tinyint(1) unsigned DEFAULT NULL COMMENT 'Суббота',
  `day7` tinyint(1) unsigned DEFAULT NULL COMMENT 'Воскресение',
  `object_id` int(10) unsigned NOT NULL COMMENT 'Объект',
  PRIMARY KEY (`id`),
  KEY `pn` (`day1`,`object_id`),
  KEY `vt` (`day2`),
  KEY `sr` (`day3`),
  KEY `cht` (`day4`),
  KEY `pt` (`day5`),
  KEY `sb` (`day6`),
  KEY `vsk` (`day7`),
  KEY `period_start` (`period_end`),
  KEY `period_end` (`period_start`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица показа объекта на карте по графику. Используется в плагине Яндекс Карты - Арендатор' AUTO_INCREMENT=1;
