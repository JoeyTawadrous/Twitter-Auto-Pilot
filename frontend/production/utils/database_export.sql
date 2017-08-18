-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2017 at 02:05 PM
-- Server version: 5.5.54
-- PHP Version: 5.3.10-1ubuntu3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tweetpal`
--

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `code` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`code`, `type`) VALUES
('SDFRHASEFASFDASDGASGD', 'Test'),
('SDAFHSDFHSDGHSDGHDSDF', 'Test'),
('SAGADSFHADFHDAFAD', 'Test'),
('FGHFGDSFVERGDGDFG', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `fullName` varchar(128) NOT NULL,
  `runsPerDay` int(1) NOT NULL,
  `jobJSON` longtext NOT NULL,
  `plan` varchar(128) NOT NULL,
  `planExpiryDate` varchar(128) NOT NULL,
  `customerID` varchar(128) NOT NULL,
  `created` datetime NOT NULL,
  `lastLogin` datetime NOT NULL,
  `totalLogins` int(5) NOT NULL,
  `lastJobJSONChange` datetime NOT NULL,
  `totalJobJSONChanges` int(5) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `fullName`, `runsPerDay`, `jobJSON`, `plan`, `planExpiryDate`, `customerID`, `created`, `lastLogin`, `totalLogins`, `lastJobJSONChange`, `totalJobJSONChanges`) VALUES
('demo@gmail.com', '$2y$10$c4/I3.ZNyVd1U4/q518rdOIFqr66r6nxTh3mjp2vWh.TgT2GT6I3i', 'Demo', 0, '{"consumerKey":"","consumerSecret":"","oauthToken":"","oauthSecret":"","followScript":"false","followbackScript":"false","unfollowScript":"false","users":"GrowthHackers, Engadget","maxFollow":50,"maxUnfollow":100,"minUserFollowers":1000,"minUserTweets":250,"favouriteScript":"false","searchQueryToFavourite":"@joeytawadrous","maxTweetsToFavourite":10,"sendReplyScript":"false","tweetReplyMessage":"Thanks for the share, ","searchQueryToReply":"@joeytawadrous","maxTweetsToReply":10,"sendMessageScript":"false","directMessage":"Focus. Make money. Achieve. I can show you how - http://www.joeyt.net/blog","maxMessagesToSend":50}', 'Basic', '', '', '2017-08-18 01:56:13', '2017-08-18 01:56:13', 0, '2017-08-18 01:56:13', 0),

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
