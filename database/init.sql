-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 05, 2016 at 07:59 PM
-- Server version: 5.5.52
-- PHP Version: 5.4.45-0+deb7u5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `santa`
--

-- --------------------------------------------------------

--
-- Table structure for table `santa_book`
--

CREATE TABLE IF NOT EXISTS `santa_book` (
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `booked_by_id` int(11) NOT NULL,
  `booked_by_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `santa_configuration`
--

CREATE TABLE IF NOT EXISTS `santa_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `santa_configuration`
--

INSERT INTO `santa_configuration` (`id`, `name`, `value`) VALUES
(1, 'website_name', 'SantaLetter'),
(2, 'website_url', 'localhost/'),
(3, 'email', 'noreply@santa.com'),
(4, 'activation', 'false'),
(5, 'resend_activation_threshold', '0'),
(6, 'language', '/models/languages/en.php'),
(7, 'template', '/models/site-templates/default.css');

-- --------------------------------------------------------

--
-- Table structure for table `santa_groups`
--

CREATE TABLE IF NOT EXISTS `santa_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `santa_groups`
--

INSERT INTO `santa_groups` (`id`, `name`, `description`) VALUES
(1, 'Elves', 'The santa team s group');

-- --------------------------------------------------------

--
-- Table structure for table `santa_group_member`
--

CREATE TABLE IF NOT EXISTS `santa_group_member` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permissions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `santa_group_member`
--

INSERT INTO `santa_group_member` (`group_id`, `user_id`, `permissions_id`) VALUES
(1, 1, 2),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `santa_list`
--

CREATE TABLE IF NOT EXISTS `santa_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` text,
  `name` text NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `second_hand` tinyint(1) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `santa_list`
--

INSERT INTO `santa_list` (`id`, `user_id`, `type`, `name`, `price`, `second_hand`, `description`) VALUES
(1, 1, 'other', 'Reindeer', 200, 1, 'A great and beautiful reindeer for my sled.'),
(2, 2, 'game', 'Ball', 5, 1, 'A foot ball to play with all the elves.'),
(3, 3, 'game', 'Wooden puppet', 15, 1, 'A tiny wooden puppet'),
(4, 4, 'clothes', 'Knitted Sweater', 20, 0, 'Knitted Sweater in green and red =)');

-- --------------------------------------------------------

--
-- Table structure for table `santa_pages`
--

CREATE TABLE IF NOT EXISTS `santa_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=531 ;

--
-- Dumping data for table `santa_pages`
--

INSERT INTO `santa_pages` (`id`, `page`, `private`) VALUES
(510, '/activate-account.php', 0),
(511, '/forgot-password.php', 0),
(512, '/index.php', 0),
(513, '/login.php', 0),
(514, '/register.php', 0),
(515, '/resend-activation.php', 0),
(516, '/admin/configuration.php', 0),
(517, '/admin/page.php', 0),
(518, '/admin/pages.php', 0),
(519, '/admin/permission.php', 0),
(520, '/admin/permissions.php', 0),
(521, '/admin/user.php', 0),
(522, '/admin/users.php', 0),
(523, '/user/create_group.php', 0),
(524, '/user/group_list.php', 0),
(525, '/user/group_members.php', 0),
(526, '/user/groups.php', 0),
(527, '/user/index.php', 0),
(528, '/user/list.php', 0),
(529, '/user/logout.php', 0),
(530, '/user/settings.php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `santa_permissions`
--

CREATE TABLE IF NOT EXISTS `santa_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `santa_permissions`
--

INSERT INTO `santa_permissions` (`id`, `name`) VALUES
(1, 'Member'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `santa_permission_page_matches`
--

CREATE TABLE IF NOT EXISTS `santa_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `santa_users`
--

CREATE TABLE IF NOT EXISTS `santa_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `santa_users`
--

-- Passwords:
-- Santa:  santa123
-- Happy:  happy123
-- Dopey:  dopey123
-- Sleepy: sleepy123

INSERT INTO `santa_users` (`id`, `user_name`, `display_name`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`) VALUES
(1, 'santa', 'Santa', 'e75efcbe7d11786d403d4b8bd329403e10b2047fc92c7c5e67c7319c4d83cd3b5', 'santa@santa.com', '5b7cc788f44927e22e8f9c892b215538', 1451331309, 0, 1, 'The Master', 1451331309, 1476039903),
(2, 'happy', 'Happy', 'ee4c6d69a87bf69206bc0bd9d59f25ffc6c25666b764c455ff02afdbadf2b95af', 'happy@santa.com', '5b7cc788f44927e22e8f9c892b215538', 1451331309, 0, 1, 'New Member', 1451331309, 1476039903),
(3, 'dopey', 'Dopey', 'ce37128b38da2d1a1cbafe8537ab3f5dd2f1d44b240b9b1f0038e80e10f549655', 'dopey@santa.com', '5b7cc788f44927e22e8f9c892b215538', 1451331309, 0, 1, 'New Member', 1451331309, 1476039903),
(4, 'sleepy', 'Sleepy', 'fc19a346eb61a286a5f8c5a601e83c60ee45a3b0e9931c3f724681c6128c43b58', 'sleepy@santa.com', '5b7cc788f44927e22e8f9c892b215538', 1451331309, 0, 1, 'New Member', 1451331309, 1476039903);


-- --------------------------------------------------------

--
-- Table structure for table `santa_user_permission_matches`
--

CREATE TABLE IF NOT EXISTS `santa_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `santa_user_permission_matches`
--

INSERT INTO `santa_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
