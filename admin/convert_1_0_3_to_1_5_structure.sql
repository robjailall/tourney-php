# Dump of table brackets
# ------------------------------------------------------------


RENAME TABLE `brackets` TO `brackets_old`;

CREATE TABLE `brackets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person` text NOT NULL,
  `name` varchar(128) NOT NULL DEFAULT '',
  `email` text NOT NULL,
  `tiebreaker` int(3) NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=paid,0=unpaid,2=exempted',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time bracket was submitted',
  `1` varchar(32) NOT NULL DEFAULT '',
  `2` varchar(32) NOT NULL DEFAULT '',
  `3` varchar(32) NOT NULL DEFAULT '',
  `4` varchar(32) NOT NULL DEFAULT '',
  `5` varchar(32) NOT NULL DEFAULT '',
  `6` varchar(32) NOT NULL DEFAULT '',
  `7` varchar(32) NOT NULL DEFAULT '',
  `8` varchar(32) NOT NULL DEFAULT '',
  `9` varchar(32) NOT NULL DEFAULT '',
  `10` varchar(32) NOT NULL DEFAULT '',
  `11` varchar(32) NOT NULL DEFAULT '',
  `12` varchar(32) NOT NULL DEFAULT '',
  `13` varchar(32) NOT NULL DEFAULT '',
  `14` varchar(32) NOT NULL DEFAULT '',
  `15` varchar(32) NOT NULL DEFAULT '',
  `16` varchar(32) NOT NULL DEFAULT '',
  `17` varchar(32) NOT NULL DEFAULT '',
  `18` varchar(32) NOT NULL DEFAULT '',
  `19` varchar(32) NOT NULL DEFAULT '',
  `20` varchar(32) NOT NULL DEFAULT '',
  `21` varchar(32) NOT NULL DEFAULT '',
  `22` varchar(32) NOT NULL DEFAULT '',
  `23` varchar(32) NOT NULL DEFAULT '',
  `24` varchar(32) NOT NULL DEFAULT '',
  `25` varchar(32) NOT NULL DEFAULT '',
  `26` varchar(32) NOT NULL DEFAULT '',
  `27` varchar(32) NOT NULL DEFAULT '',
  `28` varchar(32) NOT NULL DEFAULT '',
  `29` varchar(32) NOT NULL DEFAULT '',
  `30` varchar(32) NOT NULL DEFAULT '',
  `31` varchar(32) NOT NULL DEFAULT '',
  `32` varchar(32) NOT NULL DEFAULT '',
  `33` varchar(32) NOT NULL DEFAULT '',
  `34` varchar(32) NOT NULL DEFAULT '',
  `35` varchar(32) NOT NULL DEFAULT '',
  `36` varchar(32) NOT NULL DEFAULT '',
  `37` varchar(32) NOT NULL DEFAULT '',
  `38` varchar(32) NOT NULL DEFAULT '',
  `39` varchar(32) NOT NULL DEFAULT '',
  `40` varchar(32) NOT NULL DEFAULT '',
  `41` varchar(32) NOT NULL DEFAULT '',
  `42` varchar(32) NOT NULL DEFAULT '',
  `43` varchar(32) NOT NULL DEFAULT '',
  `44` varchar(32) NOT NULL DEFAULT '',
  `45` varchar(32) NOT NULL DEFAULT '',
  `46` varchar(32) NOT NULL DEFAULT '',
  `47` varchar(32) NOT NULL DEFAULT '',
  `48` varchar(32) NOT NULL DEFAULT '',
  `49` varchar(32) NOT NULL DEFAULT '',
  `50` varchar(32) NOT NULL DEFAULT '',
  `51` varchar(32) NOT NULL DEFAULT '',
  `52` varchar(32) NOT NULL DEFAULT '',
  `53` varchar(32) NOT NULL DEFAULT '',
  `54` varchar(32) NOT NULL DEFAULT '',
  `55` varchar(32) NOT NULL DEFAULT '',
  `56` varchar(32) NOT NULL DEFAULT '',
  `57` varchar(32) NOT NULL DEFAULT '',
  `58` varchar(32) NOT NULL DEFAULT '',
  `59` varchar(32) NOT NULL DEFAULT '',
  `60` varchar(32) NOT NULL DEFAULT '',
  `61` varchar(32) NOT NULL DEFAULT '',
  `62` varchar(32) NOT NULL DEFAULT '',
  `63` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `brackets` (`person`,`name`,`email`,`tiebreaker`,`paid`,`1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63`)
SELECT `email`,`name`,`email`,`tiebreaker`,`paid`,`1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63` FROM `brackets_old`;

DROP TABLE IF EXISTS `brackets_old`;


# Dump of table end_games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `end_games`;

CREATE TABLE `end_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `49` varchar(32) DEFAULT NULL,
  `50` varchar(32) DEFAULT NULL,
  `51` varchar(32) DEFAULT NULL,
  `52` varchar(32) DEFAULT NULL,
  `53` varchar(32) DEFAULT NULL,
  `54` varchar(32) DEFAULT NULL,
  `55` varchar(32) DEFAULT NULL,
  `56` varchar(32) DEFAULT NULL,
  `57` varchar(32) DEFAULT NULL,
  `58` varchar(32) DEFAULT NULL,
  `59` varchar(32) DEFAULT NULL,
  `60` varchar(32) DEFAULT NULL,
  `61` varchar(32) DEFAULT NULL,
  `62` varchar(32) DEFAULT NULL,
  `63` varchar(32) DEFAULT NULL,
  `round` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table master
# ------------------------------------------------------------

RENAME TABLE `master` TO `master_old`;

CREATE TABLE `master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `1` varchar(32) NOT NULL DEFAULT '',
  `2` varchar(32) NOT NULL DEFAULT '',
  `3` varchar(32) NOT NULL DEFAULT '',
  `4` varchar(32) NOT NULL DEFAULT '',
  `5` varchar(32) NOT NULL DEFAULT '',
  `6` varchar(32) NOT NULL DEFAULT '',
  `7` varchar(32) NOT NULL DEFAULT '',
  `8` varchar(32) NOT NULL DEFAULT '',
  `9` varchar(32) NOT NULL DEFAULT '',
  `10` varchar(32) NOT NULL DEFAULT '',
  `11` varchar(32) NOT NULL DEFAULT '',
  `12` varchar(32) NOT NULL DEFAULT '',
  `13` varchar(32) NOT NULL DEFAULT '',
  `14` varchar(32) NOT NULL DEFAULT '',
  `15` varchar(32) NOT NULL DEFAULT '',
  `16` varchar(32) NOT NULL DEFAULT '',
  `17` varchar(32) NOT NULL DEFAULT '',
  `18` varchar(32) NOT NULL DEFAULT '',
  `19` varchar(32) NOT NULL DEFAULT '',
  `20` varchar(32) NOT NULL DEFAULT '',
  `21` varchar(32) NOT NULL DEFAULT '',
  `22` varchar(32) NOT NULL DEFAULT '',
  `23` varchar(32) NOT NULL DEFAULT '',
  `24` varchar(32) NOT NULL DEFAULT '',
  `25` varchar(32) NOT NULL DEFAULT '',
  `26` varchar(32) NOT NULL DEFAULT '',
  `27` varchar(32) NOT NULL DEFAULT '',
  `28` varchar(32) NOT NULL DEFAULT '',
  `29` varchar(32) NOT NULL DEFAULT '',
  `30` varchar(32) NOT NULL DEFAULT '',
  `31` varchar(32) NOT NULL DEFAULT '',
  `32` varchar(32) NOT NULL DEFAULT '',
  `33` varchar(32) NOT NULL DEFAULT '',
  `34` varchar(32) NOT NULL DEFAULT '',
  `35` varchar(32) NOT NULL DEFAULT '',
  `36` varchar(32) NOT NULL DEFAULT '',
  `37` varchar(32) NOT NULL DEFAULT '',
  `38` varchar(32) NOT NULL DEFAULT '',
  `39` varchar(32) NOT NULL DEFAULT '',
  `40` varchar(32) NOT NULL DEFAULT '',
  `41` varchar(32) NOT NULL DEFAULT '',
  `42` varchar(32) NOT NULL DEFAULT '',
  `43` varchar(32) NOT NULL DEFAULT '',
  `44` varchar(32) NOT NULL DEFAULT '',
  `45` varchar(32) NOT NULL DEFAULT '',
  `46` varchar(32) NOT NULL DEFAULT '',
  `47` varchar(32) NOT NULL DEFAULT '',
  `48` varchar(32) NOT NULL DEFAULT '',
  `49` varchar(32) NOT NULL DEFAULT '',
  `50` varchar(32) NOT NULL DEFAULT '',
  `51` varchar(32) NOT NULL DEFAULT '',
  `52` varchar(32) NOT NULL DEFAULT '',
  `53` varchar(32) NOT NULL DEFAULT '',
  `54` varchar(32) NOT NULL DEFAULT '',
  `55` varchar(32) NOT NULL DEFAULT '',
  `56` varchar(32) NOT NULL DEFAULT '',
  `57` varchar(32) NOT NULL DEFAULT '',
  `58` varchar(32) NOT NULL DEFAULT '',
  `59` varchar(32) NOT NULL DEFAULT '',
  `60` varchar(32) NOT NULL DEFAULT '',
  `61` varchar(32) NOT NULL DEFAULT '',
  `62` varchar(32) NOT NULL DEFAULT '',
  `63` varchar(32) NOT NULL DEFAULT '',
  `64` varchar(32) NOT NULL DEFAULT '',
  `type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `master` (`id`,`type`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63`, `64`) VALUES
(4, 'seeds','1', '16', '8', '9', '5', '12', '4', '13', '6', '11', '3', '14', '7', '10', '2', '15', '1', '16', '8', '9', '5', '12', '4', '13', '6', '11', '3', '14', '7', '10', '2', '15', '1', '16', '8', '9', '5', '12', '4', '13', '6', '11', '3', '14', '7', '10', '2', '15', '1', '16', '8', '9', '5', '12', '4', '13', '6', '11', '3', '14', '7', '10', '2', '15');

INSERT INTO `master` (`id`,`type`,`1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63`,`64`)
SELECT '1','teams',`1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `39`, `40`, `41`, `42`, `43`, `44`, `45`, `46`, `47`, `48`, `49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63`,`64` FROM `master_old` WHERE `id` = 1;

DROP TABLE IF EXISTS `master_old`;


# Dump of table meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meta`;

CREATE TABLE `meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '',
  `subtitle` varchar(128) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `cost` double NOT NULL DEFAULT '0',
  `cut` double NOT NULL DEFAULT '0',
  `cutType` int(1) NOT NULL DEFAULT '0' COMMENT '1=percent, 0=dollars',
  `closed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=submission is closed',
  `sweet16` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=sweet 16 has started',
  `rules` text NOT NULL,
  `mail` int(1) NOT NULL DEFAULT '0',
  `tiebreaker` int(3) NOT NULL DEFAULT '0',
   `region1` varchar(64) NOT NULL, 
   `region2` varchar(64) NOT NULL, 
   `region3` varchar(64) NOT NULL, 
   `region4` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table passwords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `passwords`;

CREATE TABLE `passwords` (
  `label` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Used for user login validation';



# Dump of table possible_scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `possible_scores`;

CREATE TABLE `possible_scores` (
  `outcome_id` int(11) DEFAULT NULL,
  `bracket_id` int(11) DEFAULT NULL,
  `score` double DEFAULT NULL,
  `type` char(32) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `scores`;

CREATE TABLE `scores` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '',
  `score` double NOT NULL DEFAULT '0',
  `scoring_type` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`scoring_type`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table scoring
# ------------------------------------------------------------

DROP TABLE IF EXISTS `scoring`;

CREATE TABLE `scoring` (
  `seed` int(11) NOT NULL DEFAULT '0',
  `1` double DEFAULT NULL,
  `2` double DEFAULT NULL,
  `3` double DEFAULT NULL,
  `4` double DEFAULT NULL,
  `5` double DEFAULT NULL,
  `6` double DEFAULT NULL,
  `type` char(255) DEFAULT NULL,
  KEY `system` (`type`,`seed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table scoring_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `scoring_info`;

CREATE TABLE `scoring_info` (
  `type` varchar(255) NOT NULL DEFAULT '',
  `display_name` varchar(255) DEFAULT NULL,
  `description` blob,
  PRIMARY KEY (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `scoring` (`seed`, `1`, `2`, `3`, `4`, `5`, `6`, `type`) VALUES
(2, 1, 2, 4, 8, 16, 32, 'geometric'),
(3, 1, 2, 4, 8, 16, 32, 'geometric'),
(4, 1, 2, 4, 8, 16, 32, 'geometric'),
(5, 1, 2, 4, 8, 16, 32, 'geometric'),
(6, 1, 2, 4, 8, 16, 32, 'geometric'),
(7, 1, 2, 4, 8, 16, 32, 'geometric'),
(8, 1, 2, 4, 8, 16, 32, 'geometric'),
(9, 1, 2, 4, 8, 16, 32, 'geometric'),
(10, 1, 2, 4, 8, 16, 32, 'geometric'),
(11, 1, 2, 4, 8, 16, 32, 'geometric'),
(12, 1, 2, 4, 8, 16, 32, 'geometric'),
(13, 1, 2, 4, 8, 16, 32, 'geometric'),
(14, 1, 2, 4, 8, 16, 32, 'geometric'),
(15, 1, 2, 4, 8, 16, 32, 'geometric'),
(16, 1, 2, 4, 8, 16, 32, 'geometric'),
(1, 1, 2, 4, 8, 16, 32, 'geometric'),
(16, 10, 20, 40, 80, 120, 160, 'espn'),
(15, 10, 20, 40, 80, 120, 160, 'espn'),
(14, 10, 20, 40, 80, 120, 160, 'espn'),
(13, 10, 20, 40, 80, 120, 160, 'espn'),
(12, 10, 20, 40, 80, 120, 160, 'espn'),
(11, 10, 20, 40, 80, 120, 160, 'espn'),
(10, 10, 20, 40, 80, 120, 160, 'espn'),
(9, 10, 20, 40, 80, 120, 160, 'espn'),
(8, 10, 20, 40, 80, 120, 160, 'espn'),
(7, 10, 20, 40, 80, 120, 160, 'espn'),
(6, 10, 20, 40, 80, 120, 160, 'espn'),
(5, 10, 20, 40, 80, 120, 160, 'espn'),
(4, 10, 20, 40, 80, 120, 160, 'espn'),
(3, 10, 20, 40, 80, 120, 160, 'espn'),
(2, 10, 20, 40, 80, 120, 160, 'espn'),
(1, 10, 20, 40, 80, 120, 160, 'espn'),
(1, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(2, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(3, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(4, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(5, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(6, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(7, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(8, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(9, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(10, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(11, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(12, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(13, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(14, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(15, 2, 3, 5, 8, 13, 21, 'fibonacci'),
(16, 2, 3, 5, 8, 13, 21, 'fibonacci');

-- --------------------------------------------------------

--
-- Table structure for table `scoring_info`
--

DROP TABLE IF EXISTS `scoring_info`;
CREATE TABLE IF NOT EXISTS `scoring_info` (
  `type` varchar(255) NOT NULL default '',
  `display_name` varchar(255) default NULL,
  `description` blob,
  PRIMARY KEY  (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoring_info`
--

INSERT INTO `scoring_info` (`type`, `display_name`, `description`) VALUES
('espn', 'ESPN', 0x3c7461626c6520626f726465723d2731273e3c747220616c69676e3d2763656e746572273e3c746420636f6c7370616e3d2737273e4553504e3c2f74643e3c2f74723e3c747220616c69676e3d2763656e746572273e3c74643e53656564733c2f74643e3c746420636f6c7370616e3d2736273e526f756e64733c2f74643e3c2f74723e3c74723e3c74643e266e6273703b3c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e333c2f74643e3c74643e343c2f74643e3c74643e353c2f74643e3c74643e363c2f74643e3c2f74723e3c74723e3c74643e313c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e323c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e333c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e343c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e353c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e363c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e373c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e383c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e393c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e31303c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e31313c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e31323c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e31333c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e31343c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e31353c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c74723e3c74643e31363c2f74643e3c74643e31303c2f74643e3c74643e32303c2f74643e3c74643e34303c2f74643e3c74643e38303c2f74643e3c74643e3132303c2f74643e3c74643e3136303c2f74643e3c74723e3c2f7461626c653e),
('geometric', 'Geometric', 0x3c7461626c6520626f726465723d2731273e3c747220616c69676e3d2763656e746572273e3c746420636f6c7370616e3d2737273e47656f6d65747269633c2f74643e3c2f74723e3c747220616c69676e3d2763656e746572273e3c74643e53656564733c2f74643e3c746420636f6c7370616e3d2736273e526f756e64733c2f74643e3c2f74723e3c74723e3c74643e266e6273703b3c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e333c2f74643e3c74643e343c2f74643e3c74643e353c2f74643e3c74643e363c2f74643e3c2f74723e3c74723e3c74643e313c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e323c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e333c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e343c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e353c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e363c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e373c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e383c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e393c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e31303c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e31313c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e31323c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e31333c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e31343c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e31353c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c74723e3c74643e31363c2f74643e3c74643e313c2f74643e3c74643e323c2f74643e3c74643e343c2f74643e3c74643e383c2f74643e3c74643e31363c2f74643e3c74643e33323c2f74643e3c74723e3c2f7461626c653e);



