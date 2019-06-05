CREATE TABLE IF NOT EXISTS `#__yandex_maps_datetimes` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT  'ID',
`object_id` INT UNSIGNED NOT NULL COMMENT  'Объект',
`date_value` DATE NOT NULL COMMENT  'Дата',
`time_value` TIME NOT NULL COMMENT  'Время',
INDEX (`object_id` ,  `date_value` ,  `time_value` )
) COMMENT =  'Таблица показа объекта на карте. Используется в плагине plg_system_yandex_maps_arendator';
ALTER TABLE  `#__yandex_maps_datetimes` ADD  `status` TINYINT(1) NOT NULL DEFAULT  '0' COMMENT  'Статус времени',
ADD INDEX (`status`);
ALTER TABLE  `#__yandex_maps_datetimes` ADD  `book_user` INT UNSIGNED NULL DEFAULT NULL COMMENT  'Забронировавший пользователь',
ADD INDEX (`book_user`);
ALTER TABLE  `#__yandex_maps_datetimes` ADD  `params` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT  'Данные брони';
ALTER TABLE  `#__yandex_maps_datetimes` ADD  `price` DECIMAL(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT  'Цена часа' AFTER  `time_value` ,
ADD INDEX (`price`);

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
