-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2017 at 03:50 PM
-- Server version: 5.6.33-log
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_teamhax`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `userName` varchar(255) NOT NULL DEFAULT 'Player',
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gameSave` longtext,
  `mod` int(11) NOT NULL DEFAULT '0' COMMENT 'Have a moderator access (2.02/2.1)',
  `admin` int(11) NOT NULL DEFAULT '0',
  `disabled` int(11) NOT NULL DEFAULT '0' COMMENT 'Is account disabled',
  `banned` int(11) NOT NULL DEFAULT '0' COMMENT 'Is global banned',
  `cBlocked` int(11) NOT NULL DEFAULT '0',
  `accountID` int(11) NOT NULL AUTO_INCREMENT,
  `msgAllowed` int(11) NOT NULL DEFAULT '0',
  `frAllowed` int(11) NOT NULL DEFAULT '0',
  `ytLink` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `twitch` varchar(255) DEFAULT NULL,
  `actHash` varchar(255) DEFAULT NULL,
  `actSent` varchar(255) DEFAULT NULL,
  `levelsMade` int(11) NOT NULL DEFAULT '0',
  `lastLevelTime` int(11) NOT NULL DEFAULT '0',
  `commentsSent` int(11) NOT NULL DEFAULT '0',
  `lastCommentTime` int(11) NOT NULL DEFAULT '0',
  `accSent` int(11) NOT NULL DEFAULT '0',
  `lastAccTime` int(11) NOT NULL DEFAULT '0',
  `messageSent` int(11) NOT NULL DEFAULT '0',
  `lastMessageSent` int(11) NOT NULL DEFAULT '0',
  `accDate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`accountID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16353 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocked`
--

CREATE TABLE IF NOT EXISTS `blocked` (
  `accountID` int(11) NOT NULL,
  `targetID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `userID` int(11) NOT NULL DEFAULT '0',
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) DEFAULT NULL,
  `uploadTime` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `accountComment` int(11) NOT NULL DEFAULT '0',
  `accountID` int(11) NOT NULL DEFAULT '0',
  `levelID` int(11) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3290 ;

-- --------------------------------------------------------

--
-- Table structure for table `dailyLevels`
--

CREATE TABLE IF NOT EXISTS `dailyLevels` (
  `dailyID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`dailyID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `accountID` int(11) NOT NULL,
  `targetID` int(11) NOT NULL,
  `new` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frRequests`
--

CREATE TABLE IF NOT EXISTS `frRequests` (
  `requestID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `targetID` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `uploadTime` int(11) NOT NULL,
  PRIMARY KEY (`requestID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=984 ;

-- --------------------------------------------------------

--
-- Table structure for table `gauntlets`
--

CREATE TABLE IF NOT EXISTS `gauntlets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `levels` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `levelRatings`
--

CREATE TABLE IF NOT EXISTS `levelRatings` (
  `levelID` int(11) NOT NULL,
  `stars` int(11) NOT NULL DEFAULT '0',
  `featured` int(11) NOT NULL DEFAULT '0',
  `byMod` int(11) NOT NULL DEFAULT '0',
  `demonType` int(11) NOT NULL DEFAULT '0',
  `nStars` int(11) NOT NULL DEFAULT '0',
  `nCount` int(11) NOT NULL DEFAULT '0',
  `diff` int(11) NOT NULL DEFAULT '0',
  `auto` int(11) NOT NULL DEFAULT '0',
  `demon` int(11) NOT NULL DEFAULT '0',
  `vCoins` int(11) NOT NULL DEFAULT '0',
  `ratingID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ratingID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=797 ;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `levelID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'Unnamed',
  `desc` varchar(255) DEFAULT NULL,
  `stars` int(11) NOT NULL DEFAULT '0',
  `featured` int(11) NOT NULL DEFAULT '0',
  `coins` int(11) NOT NULL DEFAULT '0',
  `verifiedCoins` int(11) NOT NULL DEFAULT '0',
  `diff` int(11) NOT NULL DEFAULT '0',
  `demon` int(11) NOT NULL DEFAULT '0',
  `auto` int(11) NOT NULL DEFAULT '0',
  `twoPlayer` int(11) NOT NULL DEFAULT '0',
  `songID` int(11) NOT NULL DEFAULT '0',
  `song` int(11) NOT NULL DEFAULT '0',
  `string` longtext,
  `extra` longtext,
  `password` int(11) NOT NULL DEFAULT '0',
  `length` int(11) NOT NULL DEFAULT '0',
  `info` longtext,
  `version` int(11) NOT NULL DEFAULT '0',
  `original` int(11) NOT NULL DEFAULT '0',
  `objects` int(11) NOT NULL DEFAULT '0',
  `requestedStars` int(11) NOT NULL DEFAULT '0',
  `game` int(11) NOT NULL DEFAULT '20',
  `downloads` int(11) NOT NULL DEFAULT '0',
  `likes` int(11) NOT NULL DEFAULT '0',
  `uploadTime` int(11) NOT NULL,
  `updateTime` int(11) NOT NULL,
  `epic` int(11) NOT NULL DEFAULT '0',
  `fame` int(11) NOT NULL DEFAULT '0',
  `unlisted` int(11) NOT NULL DEFAULT '0',
  `demonType` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`levelID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1512 ;

-- --------------------------------------------------------

--
-- Table structure for table `mappacks`
--

CREATE TABLE IF NOT EXISTS `mappacks` (
  `name` varchar(255) NOT NULL DEFAULT 'New mappack',
  `diff` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `rgb` varchar(255) NOT NULL COMMENT 'R,G,B',
  `levels` varchar(255) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `targetID` int(11) NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `body` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `uploadTime` int(11) NOT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=700 ;

-- --------------------------------------------------------

--
-- Table structure for table `percentageInfo`
--

CREATE TABLE IF NOT EXISTS `percentageInfo` (
  `userID` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `updateTime` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE IF NOT EXISTS `rewards` (
  `chestOrbs` int(11) NOT NULL,
  `chestDiamonds` int(11) NOT NULL,
  `chestShards` int(11) NOT NULL,
  `chestSpecial` int(11) NOT NULL,
  `bigOrbs` int(11) NOT NULL,
  `bigDiamonds` int(11) NOT NULL,
  `bigShards` int(11) NOT NULL,
  `bigSpecial` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE IF NOT EXISTS `server` (
  `maintenance` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) NOT NULL DEFAULT 'Player',
  `registered` int(11) NOT NULL DEFAULT '0',
  `accountID` int(11) NOT NULL DEFAULT '0',
  `iconType` int(11) NOT NULL DEFAULT '0',
  `icon` int(11) NOT NULL DEFAULT '0',
  `ship` int(11) NOT NULL DEFAULT '0',
  `ball` int(11) NOT NULL DEFAULT '0',
  `ufo` int(11) NOT NULL DEFAULT '0',
  `wave` int(11) NOT NULL DEFAULT '0',
  `robot` int(11) NOT NULL DEFAULT '0',
  `spider` int(11) NOT NULL DEFAULT '0',
  `stars` int(11) NOT NULL DEFAULT '0',
  `coins` int(11) NOT NULL DEFAULT '0',
  `userCoins` int(11) NOT NULL DEFAULT '0',
  `demons` int(11) NOT NULL DEFAULT '0',
  `pColor` int(11) NOT NULL DEFAULT '0',
  `diamonds` int(11) NOT NULL DEFAULT '0',
  `sColor` int(11) NOT NULL DEFAULT '0',
  `cp` int(11) NOT NULL DEFAULT '0',
  `special` int(11) NOT NULL DEFAULT '0',
  `glow` int(11) NOT NULL DEFAULT '0',
  `udid` varchar(255) NOT NULL DEFAULT '0',
  `explosion` int(11) NOT NULL DEFAULT '0',
  `shareIcon` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1034 ;

-- --------------------------------------------------------

--
-- Table structure for table `userStuff`
--

CREATE TABLE IF NOT EXISTS `userStuff` (
  `accountID` int(11) NOT NULL,
  `questTime` int(11) NOT NULL DEFAULT '0',
  `chestTime` int(11) NOT NULL DEFAULT '0',
  `bigChestTime` int(11) NOT NULL DEFAULT '0',
  `chestCount` int(11) NOT NULL DEFAULT '0',
  `bigCount` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
