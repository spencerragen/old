SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `empires` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `independent` tinyint(1) NOT NULL,
  `name` varchar(32) NOT NULL,
  `alternate` varchar(128) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

INSERT INTO `empires` (`id`, `independent`, `name`, `alternate`) VALUES
(1, 0, 'French Empire', 'France'),
(2, 0, 'British Empire', 'England,Britain,UK'),
(3, 0, 'Russian Empire', 'Russia,Soviet Union,CCCP,USSR,Mother'),
(4, 0, 'German Empire', 'Germany,Fatherland'),
(5, 0, 'Ottoman Empire', ''),
(6, 0, 'Austrian Empire', 'Austria'),
(7, 1, 'Italy', 'Independent'),
(8, 1, 'Spain', 'Independent'),
(9, 1, 'Scandinavia', 'Independent');

CREATE TABLE IF NOT EXISTS `territories` (
  `empire` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `color` varchar(6) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `territories` (`empire`, `name`, `color`) VALUES
(8, 'Barcelona', '66ff33'),
(4, 'Bavaria', 'ff9900'),
(4, 'Berlin', 'ff9900'),
(6, 'Bohemia', 'ffff33'),
(1, 'Brittany', 'ff99ff'),
(5, 'Bulgaria', '009999'),
(1, 'Burgundy', 'ff99ff'),
(9, 'Denmark', '66ff33'),
(9, 'Finland', '66ff33'),
(6, 'Galicia', 'ffff33'),
(1, 'Gascony', 'ff99ff'),
(5, 'Greece', '009999'),
(6, 'Hungary', 'ffff33'),
(2, 'Ireland', 'cc00ff'),
(3, 'Livonia', 'cc0000'),
(2, 'London', 'cc00ff'),
(8, 'Madrid', '66ff33'),
(1, 'Marseille', 'ff99ff'),
(5, 'Montenegro', '009999'),
(3, 'Moscow', 'cc0000'),
(7, 'Naples', '66ff33'),
(1, 'Netherlands', 'ff99ff'),
(9, 'Norway', '66ff33'),
(1, 'Paris', 'ff99ff'),
(3, 'Poland', 'cc0000'),
(8, 'Portugal', '66ff33'),
(4, 'Prussia', 'ff9900'),
(4, 'Rhine', 'ff9900'),
(5, 'Romania', '009999'),
(7, 'Rome', '66ff33'),
(3, 'Saint Petersburg', 'cc0000'),
(4, 'Saxony', 'ff9900'),
(2, 'Scotland', 'cc00ff'),
(5, 'Serbia', '009999'),
(3, 'Smolensk', 'cc0000'),
(9, 'Sweden', '66ff33'),
(7, 'Switzerland', '66ff33'),
(6, 'Trieste', 'ffff33'),
(5, 'Turkey', '009999'),
(3, 'Ukraine', 'cc0000'),
(7, 'Venice', '66ff33'),
(6, 'Vienna', 'ffff33'),
(2, 'Wales', 'cc00ff'),
(2, 'Yorkshire', 'cc00ff');
