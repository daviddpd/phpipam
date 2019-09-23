CREATE TABLE `dpdMeta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref` varchar(64) DEFAULT NULL,
  `refid` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `key` varchar(64) DEFAULT NULL,
  `value` blob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ipID` (`refid`),
  KEY `name` (`name`),
  KEY `key` (`key`),
  KEY `name-key` (`name`,`key`),
  KEY `ref` (`ref`),
  KEY `id-ref` (`ref`,`refid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

