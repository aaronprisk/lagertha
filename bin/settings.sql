use lagertha;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `settings` (
  `settings_id` int(11) NOT NULL,
  `check_freq` int(11) NOT NULL,
  `name_scheme` varchar(30) NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`settings_id`, `check_freq`, `name_scheme`) VALUES
(1, 300, 'PC-');


