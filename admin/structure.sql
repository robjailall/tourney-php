-- phpMyAdmin SQL Dump
-- version 2.11.2deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 14, 2007 at 04:27 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3-1ubuntu6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `best_scores`
--

DROP TABLE IF EXISTS `best_scores`;
CREATE TABLE `best_scores` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL auto_increment,
  `title` tinytext NOT NULL,
  `subtitle` tinytext NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brackets`
--

DROP TABLE IF EXISTS `brackets`;
CREATE TABLE `brackets` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `tiebreaker` int(3) NOT NULL,
  `paid` tinyint(1) NOT NULL default 0 COMMENT '1=paid,0=unpaid,2=exempted',
  `1` varchar(32) NOT NULL,
  `2` varchar(32) NOT NULL,
  `3` varchar(32) NOT NULL,
  `4` varchar(32) NOT NULL,
  `5` varchar(32) NOT NULL,
  `6` varchar(32) NOT NULL,
  `7` varchar(32) NOT NULL,
  `8` varchar(32) NOT NULL,
  `9` varchar(32) NOT NULL,
  `10` varchar(32) NOT NULL,
  `11` varchar(32) NOT NULL,
  `12` varchar(32) NOT NULL,
  `13` varchar(32) NOT NULL,
  `14` varchar(32) NOT NULL,
  `15` varchar(32) NOT NULL,
  `16` varchar(32) NOT NULL,
  `17` varchar(32) NOT NULL,
  `18` varchar(32) NOT NULL,
  `19` varchar(32) NOT NULL,
  `20` varchar(32) NOT NULL,
  `21` varchar(32) NOT NULL,
  `22` varchar(32) NOT NULL,
  `23` varchar(32) NOT NULL,
  `24` varchar(32) NOT NULL,
  `25` varchar(32) NOT NULL,
  `26` varchar(32) NOT NULL,
  `27` varchar(32) NOT NULL,
  `28` varchar(32) NOT NULL,
  `29` varchar(32) NOT NULL,
  `30` varchar(32) NOT NULL,
  `31` varchar(32) NOT NULL,
  `32` varchar(32) NOT NULL,
  `33` varchar(32) NOT NULL,
  `34` varchar(32) NOT NULL,
  `35` varchar(32) NOT NULL,
  `36` varchar(32) NOT NULL,
  `37` varchar(32) NOT NULL,
  `38` varchar(32) NOT NULL,
  `39` varchar(32) NOT NULL,
  `40` varchar(32) NOT NULL,
  `41` varchar(32) NOT NULL,
  `42` varchar(32) NOT NULL,
  `43` varchar(32) NOT NULL,
  `44` varchar(32) NOT NULL,
  `45` varchar(32) NOT NULL,
  `46` varchar(32) NOT NULL,
  `47` varchar(32) NOT NULL,
  `48` varchar(32) NOT NULL,
  `49` varchar(32) NOT NULL,
  `50` varchar(32) NOT NULL,
  `51` varchar(32) NOT NULL,
  `52` varchar(32) NOT NULL,
  `53` varchar(32) NOT NULL,
  `54` varchar(32) NOT NULL,
  `55` varchar(32) NOT NULL,
  `56` varchar(32) NOT NULL,
  `57` varchar(32) NOT NULL,
  `58` varchar(32) NOT NULL,
  `59` varchar(32) NOT NULL,
  `60` varchar(32) NOT NULL,
  `61` varchar(32) NOT NULL,
  `62` varchar(32) NOT NULL,
  `63` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master`
--

DROP TABLE IF EXISTS `master`;
CREATE TABLE `master` (
  `id` int(11) NOT NULL auto_increment,
  `1` varchar(32) NOT NULL,
  `2` varchar(32) NOT NULL,
  `3` varchar(32) NOT NULL,
  `4` varchar(32) NOT NULL,
  `5` varchar(32) NOT NULL,
  `6` varchar(32) NOT NULL,
  `7` varchar(32) NOT NULL,
  `8` varchar(32) NOT NULL,
  `9` varchar(32) NOT NULL,
  `10` varchar(32) NOT NULL,
  `11` varchar(32) NOT NULL,
  `12` varchar(32) NOT NULL,
  `13` varchar(32) NOT NULL,
  `14` varchar(32) NOT NULL,
  `15` varchar(32) NOT NULL,
  `16` varchar(32) NOT NULL,
  `17` varchar(32) NOT NULL,
  `18` varchar(32) NOT NULL,
  `19` varchar(32) NOT NULL,
  `20` varchar(32) NOT NULL,
  `21` varchar(32) NOT NULL,
  `22` varchar(32) NOT NULL,
  `23` varchar(32) NOT NULL,
  `24` varchar(32) NOT NULL,
  `25` varchar(32) NOT NULL,
  `26` varchar(32) NOT NULL,
  `27` varchar(32) NOT NULL,
  `28` varchar(32) NOT NULL,
  `29` varchar(32) NOT NULL,
  `30` varchar(32) NOT NULL,
  `31` varchar(32) NOT NULL,
  `32` varchar(32) NOT NULL,
  `33` varchar(32) NOT NULL,
  `34` varchar(32) NOT NULL,
  `35` varchar(32) NOT NULL,
  `36` varchar(32) NOT NULL,
  `37` varchar(32) NOT NULL,
  `38` varchar(32) NOT NULL,
  `39` varchar(32) NOT NULL,
  `40` varchar(32) NOT NULL,
  `41` varchar(32) NOT NULL,
  `42` varchar(32) NOT NULL,
  `43` varchar(32) NOT NULL,
  `44` varchar(32) NOT NULL,
  `45` varchar(32) NOT NULL,
  `46` varchar(32) NOT NULL,
  `47` varchar(32) NOT NULL,
  `48` varchar(32) NOT NULL,
  `49` varchar(32) NOT NULL,
  `50` varchar(32) NOT NULL,
  `51` varchar(32) NOT NULL,
  `52` varchar(32) NOT NULL,
  `53` varchar(32) NOT NULL,
  `54` varchar(32) NOT NULL,
  `55` varchar(32) NOT NULL,
  `56` varchar(32) NOT NULL,
  `57` varchar(32) NOT NULL,
  `58` varchar(32) NOT NULL,
  `59` varchar(32) NOT NULL,
  `60` varchar(32) NOT NULL,
  `61` varchar(32) NOT NULL,
  `62` varchar(32) NOT NULL,
  `63` varchar(32) NOT NULL,
  `64` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(64) NOT NULL,
  `subtitle` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `cost` double NOT NULL,
  `cut` double NOT NULL,
  `cutType` int(1) NOT NULL COMMENT '1=percent, 0=dollars',
  `closed` tinyint(1) NOT NULL COMMENT '1=submission is closed',
  `sweet16` tinyint(1) NOT NULL COMMENT '1=sweet 16 has started',
  `round64Value` int(11) NOT NULL,
  `round32Value` int(11) NOT NULL,
  `sweet16Value` int(11) NOT NULL,
  `elite8Value` int(11) NOT NULL,
  `final4Value` int(11) NOT NULL,
  `champValue` int(11) NOT NULL,
  `rules` text NOT NULL,
  `mail` int(1) NOT NULL,
  `tiebreaker` int(3),
  `region1` varchar(64) NOT NULL,
  `region2` varchar(64) NOT NULL,
  `region3` varchar(64) NOT NULL,
  `region4` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



