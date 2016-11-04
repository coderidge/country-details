
A Symfony 3 project 

1/ To install run - 'Composer update' from command line 

2/ Database schema included further down

TODO 

Different language formats causing problems inserting in some cases, needs to be investigated. I don't have experience with dealing with this syntax. 

Creating the apis from the database requires more work.  To create a tree of json returned for countries and the data from related tables.  Currently just returned main details.


Schema 

############################################################################


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `samknows`
--

-- --------------------------------------------------------

--
-- Table structure for table `border_countries`
--

CREATE TABLE IF NOT EXISTS `border_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `border_country` varchar(50) CHARACTER SET utf8 NOT NULL,
  `country_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `country_id_2` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1363 ;

-- --------------------------------------------------------

--
-- Table structure for table `country_details`
--

CREATE TABLE IF NOT EXISTS `country_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `domain_tld` varchar(50) CHARACTER SET utf8 NOT NULL,
  `lat` varchar(50) CHARACTER SET utf8 NOT NULL,
  `lng` varchar(50) NOT NULL,
  `ISO2` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ISO3` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1071 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) CHARACTER SET utf8 NOT NULL,
  `country_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=766 ;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translation` varchar(50) CHARACTER SET utf8 NOT NULL,
  `country_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `border_countries`
--
ALTER TABLE `border_countries`
  ADD CONSTRAINT `border_countries_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
