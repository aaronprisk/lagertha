CREATE DATABASE IF NOT EXISTS `login`;
CREATE DATABASE IF NOT EXISTS `lagertha`;

USE lagertha;
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

INSERT INTO `settings` (`settings_id`, `check_freq`, `name_scheme`) VALUES
(1, 300, 'PC-');

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

use login;
CREATE TABLE IF NOT EXISTS `login`.`users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

INSERT INTO users (user_name, user_password_hash, user_email) VALUES("lagertha", "$2y$10$t/ah4VLdqLHnPghrwhXO/.UVKme9jsg0nPrLY1Up6JOJgPorzF5Sy", "admin@localhost.local");

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'lagertha'@'%' IDENTIFIED BY PASSWORD '*sword';
GRANT UPDATE (status, pending) ON `lagertha`.`tasks` TO 'lagertha'@'%';
GRANT UPDATE (last_check) ON `lagertha`.`hosts` TO 'lagertha'@'%';
GRANT SELECT ON *.* TO 'register'@'%' IDENTIFIED BY PASSWORD 'addnewhost!';
GRANT SELECT, INSERT ON `lagertha`.`hosts` TO 'register'@'%';

GRANT USAGE ON *.* TO 'auth'@'%' IDENTIFIED BY PASSWORD 'valhalla';
GRANT ALL PRIVILEGES ON `login`.* TO 'auth'@'%';
