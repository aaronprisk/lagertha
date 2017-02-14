use lagertha;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `groups` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` text NOT NULL,
  `owner` varchar(30) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `group_members` (
  `group_mem_num` int(11) NOT NULL AUTO_INCREMENT,
  `hostid` int(11) NOT NULL,
  `mac` varchar(30) NOT NULL,
  `hostname` varchar(30) NOT NULL,
  `groupid` int(11) NOT NULL,
  PRIMARY KEY (`group_mem_num`),
  UNIQUE KEY `mac` (`mac`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=186 ;

CREATE TABLE IF NOT EXISTS `hosts` (
  `hostid` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(25) NOT NULL,
  `hostname` varchar(30) NOT NULL,
  `os` varchar(30) NOT NULL,
  `details` text NOT NULL,
  `last_check` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`hostid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=736 ;

CREATE TABLE IF NOT EXISTS `settings` (
  `settings_id` int(11) NOT NULL,
  `check_freq` int(11) NOT NULL,
  `name_scheme` varchar(30) NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tasks` (
  `taskid` int(11) NOT NULL AUTO_INCREMENT,
  `host` varchar(20) NOT NULL,
  `mac` varchar(30) NOT NULL,
  `hostid` int(11) NOT NULL,
  `tasktype` int(11) NOT NULL,
  `pending` int(11) NOT NULL,
  `package` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `info` text NOT NULL,
  `user` varchar(50) NOT NULL,
  `log` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`taskid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
