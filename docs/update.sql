
--
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `year` smallint(4) unsigned NOT NULL,
  `desc` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year` (`year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `audio`
--

DROP TABLE IF EXISTS `audio`;
CREATE TABLE IF NOT EXISTS `audio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `concert`
--

DROP TABLE IF EXISTS `concert`;
CREATE TABLE IF NOT EXISTS `concert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title` varchar(1024) NOT NULL,
  `link` varchar(1024) NOT NULL,
  `place` varchar(1024) NOT NULL,
  `time` time DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `guestbook`
--

DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE IF NOT EXISTS `guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(100) NOT NULL,
  `date_publish` datetime NOT NULL,
  `email` varchar(150) NOT NULL,
  `city` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_publish` (`date_publish`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_publish` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_publish` (`date_publish`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_code` text NOT NULL,
  `desc` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audio`
--
ALTER TABLE `audio`
  ADD CONSTRAINT `audio_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`);
