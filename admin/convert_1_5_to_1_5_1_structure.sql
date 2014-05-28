# Dump of table end_games
# ------------------------------------------------------------

RENAME TABLE `end_games` TO `end_games_old`;

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
  `eliminated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `end_games` (`round`,`eliminated`,`49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63`)
SELECT `round`,false,`49`, `50`, `51`, `52`, `53`, `54`, `55`, `56`, `57`, `58`, `59`, `60`, `61`, `62`, `63` FROM end_games_old;

DROP TABLE IF EXISTS `end_games_old`;


DROP TABLE IF EXISTS `possible_scores_old`;

RENAME TABLE `possible_scores` TO `possible_scores_old`;

CREATE TABLE `possible_scores` (
  `outcome_id` int(11) DEFAULT NULL,
  `bracket_id` int(11) DEFAULT NULL,
  `score` double DEFAULT NULL,
  `type` char(32) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `eliminated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `possible_scores` (`outcome_id`,`bracket_id`,`score`, `type`,`rank`,`eliminated`)
SELECT `outcome_id`,`bracket_id`,`score`, `type`,`rank`,false from `possible_scores_old`;

DROP TABLE IF EXISTS `possible_scores_old`;


DROP TABLE IF EXISTS `possible_scores_eliminated`;

CREATE TABLE `possible_scores_eliminated` (
  `outcome_id` int(11) DEFAULT NULL,
  `bracket_id` int(11) DEFAULT NULL,
  `score` double DEFAULT NULL,
  `type` char(32) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `eliminated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `meta` ADD COLUMN `db_version` varchar(255) NOT NULL DEFAULT '0';
UPDATE `meta` SET `db_version`='1.5.1';

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `bracket` int(11) NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `from` tinytext NOT NULL,
  `subject` tinytext NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `brackets` ADD `eliminated` BOOL NOT NULL DEFAULT '0' COMMENT 'Equals 1 when eliminated' AFTER `time`;


CREATE TABLE IF NOT EXISTS `probability_of_winning` (
  `id` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `probability_win` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



