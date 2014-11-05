-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 24, 2012 at 05:44 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.3-1ubuntu9.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pundit_tracker_fixture`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'ALL', 1, 144),
(2, 1, NULL, NULL, 'Acm', 2, 3),
(3, 1, NULL, NULL, 'Calls', 4, 21),
(4, 3, NULL, NULL, 'Calls::add', 5, 6),
(5, 3, NULL, NULL, 'Calls::admin_all', 7, 8),
(6, 3, NULL, NULL, 'Calls::admin_approve', 9, 10),
(7, 3, NULL, NULL, 'Calls::admin_delete', 11, 12),
(8, 3, NULL, NULL, 'Calls::admin_edit', 13, 14),
(9, 3, NULL, NULL, 'Calls::admin_index', 15, 16),
(10, 3, NULL, NULL, 'Calls::history', 17, 18),
(11, 1, NULL, NULL, 'Categories', 22, 37),
(12, 11, NULL, NULL, 'Categories::admin_add', 23, 24),
(13, 11, NULL, NULL, 'Categories::admin_delete', 25, 26),
(14, 11, NULL, NULL, 'Categories::admin_edit', 27, 28),
(15, 11, NULL, NULL, 'Categories::admin_index', 29, 30),
(16, 11, NULL, NULL, 'Categories::archive_call', 31, 32),
(17, 11, NULL, NULL, 'Categories::live_call', 33, 34),
(18, 11, NULL, NULL, 'Categories::view', 35, 36),
(19, 1, NULL, NULL, 'Outcomes', 38, 47),
(20, 19, NULL, NULL, 'Outcomes::admin_add', 39, 40),
(21, 19, NULL, NULL, 'Outcomes::admin_delete', 41, 42),
(22, 19, NULL, NULL, 'Outcomes::admin_edit', 43, 44),
(23, 19, NULL, NULL, 'Outcomes::admin_index', 45, 46),
(24, 1, NULL, NULL, 'Pundits', 48, 63),
(25, 24, NULL, NULL, 'Pundits::admin_edit_info', 49, 50),
(26, 24, NULL, NULL, 'Pundits::archive_call', 51, 52),
(27, 24, NULL, NULL, 'Pundits::categoryList', 53, 54),
(28, 24, NULL, NULL, 'Pundits::history', 55, 56),
(29, 24, NULL, NULL, 'Pundits::index', 57, 58),
(30, 24, NULL, NULL, 'Pundits::live_call', 59, 60),
(31, 24, NULL, NULL, 'Pundits::profile', 61, 62),
(32, 1, NULL, NULL, 'SuggestedPundits', 64, 81),
(33, 32, NULL, NULL, 'SuggestedPundits::add', 65, 66),
(34, 32, NULL, NULL, 'SuggestedPundits::admin_approve', 67, 68),
(35, 32, NULL, NULL, 'SuggestedPundits::admin_delete', 69, 70),
(36, 32, NULL, NULL, 'SuggestedPundits::admin_edit', 71, 72),
(37, 32, NULL, NULL, 'SuggestedPundits::admin_index', 73, 74),
(38, 32, NULL, NULL, 'SuggestedPundits::index', 75, 76),
(39, 32, NULL, NULL, 'SuggestedPundits::view', 77, 78),
(40, 1, NULL, NULL, 'Users', 82, 133),
(41, 40, NULL, NULL, 'Users::add', 83, 84),
(42, 40, NULL, NULL, 'Users::admin_delete', 85, 86),
(43, 40, NULL, NULL, 'Users::admin_edit', 87, 88),
(44, 40, NULL, NULL, 'Users::admin_index', 89, 90),
(45, 40, NULL, NULL, 'Users::admin_user_view', 91, 92),
(66, 40, NULL, NULL, 'Users::sahi_end', 129, 130),
(47, 40, NULL, NULL, 'Users::archive_call', 95, 96),
(48, 40, NULL, NULL, 'Users::cmp', 97, 98),
(49, 40, NULL, NULL, 'Users::delete', 99, 100),
(50, 40, NULL, NULL, 'Users::edit', 101, 102),
(51, 40, NULL, NULL, 'Users::edit_info', 103, 104),
(52, 40, NULL, NULL, 'Users::forgot_password', 105, 106),
(53, 40, NULL, NULL, 'Users::home', 107, 108),
(54, 40, NULL, NULL, 'Users::index', 109, 110),
(55, 40, NULL, NULL, 'Users::live_call', 111, 112),
(56, 40, NULL, NULL, 'Users::login', 113, 114),
(57, 40, NULL, NULL, 'Users::logout', 115, 116),
(58, 40, NULL, NULL, 'Users::pmp', 117, 118),
(59, 40, NULL, NULL, 'Users::profile', 119, 120),
(60, 40, NULL, NULL, 'Users::reset_new', 121, 122),
(61, 40, NULL, NULL, 'Users::reset_password', 123, 124),
(62, 40, NULL, NULL, 'Users::signup', 125, 126),
(63, 40, NULL, NULL, 'Users::view', 127, 128),
(64, 1, NULL, NULL, 'Votes', 134, 139),
(65, 64, NULL, NULL, 'Votes::add', 135, 136),
(67, 40, NULL, NULL, 'Users::sahi_start', 131, 132),
(68, 1, NULL, NULL, 'Pages', 140, 143),
(69, 68, NULL, NULL, 'Pages::display', 141, 142),
(70, 3, NULL, NULL, 'Calls::admin_add', 19, 20),
(71, 32, NULL, NULL, 'SuggestedPundits::admin_add', 79, 80),
(72, 64, NULL, NULL, 'Votes::saveVote', 137, 138);

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=676 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'Admin', 1, 10),
(2, NULL, NULL, NULL, 'Anonymous', 11, 1412),
(3, 2, NULL, NULL, 'Pundit', 12, 301),
(4, 2, NULL, NULL, 'General', 302, 1405),
(5, 2, NULL, NULL, 'Future-use', 1406, 1411),
(6, 1, NULL, 1, 'User::1', 2, 3),
(7, 4, NULL, 2, 'User::2', 355, 356),
(674, 4, NULL, 3, 'User::3', 1401, 1402),
(9, 3, NULL, 4, 'User::4', 13, 14),
(10, 3, NULL, 5, 'User::5', 15, 16),
(675, 4, NULL, 6, 'User::6', 1403, 1404),
(406, 3, NULL, 7, 'User::7', 299, 300);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 4, 4, '1', '1', '1', '1'),
(3, 4, 10, '1', '1', '1', '1'),
(4, 4, 16, '1', '1', '1', '1'),
(5, 4, 17, '1', '1', '1', '1'),
(6, 4, 18, '1', '1', '1', '1'),
(7, 4, 31, '1', '1', '1', '1'),
(8, 4, 26, '1', '1', '1', '1'),
(9, 4, 27, '1', '1', '1', '1'),
(10, 4, 28, '1', '1', '1', '1'),
(11, 4, 29, '1', '1', '1', '1'),
(12, 4, 30, '1', '1', '1', '1'),
(13, 4, 33, '1', '1', '1', '1'),
(14, 4, 38, '-1', '-1', '-1', '-1'),
(15, 4, 39, '-1', '-1', '-1', '-1'),
(16, 4, 59, '1', '1', '1', '1'),
(17, 4, 61, '1', '1', '1', '1'),
(18, 4, 60, '1', '1', '1', '1'),
(19, 4, 51, '1', '1', '1', '1'),
(20, 4, 47, '1', '1', '1', '1'),
(21, 4, 55, '1', '1', '1', '1'),
(22, 4, 57, '1', '1', '1', '1'),
(23, 4, 65, '1', '1', '1', '1'),
(24, 2, 52, '1', '1', '1', '1'),
(25, 2, 56, '1', '1', '1', '1'),
(26, 2, 31, '1', '1', '1', '1'),
(27, 2, 62, '1', '1', '1', '1'),
(28, 2, 30, '1', '1', '1', '1'),
(29, 2, 26, '1', '1', '1', '1'),
(30, 2, 28, '1', '1', '1', '1'),
(31, 2, 18, '1', '1', '1', '1'),
(32, 2, 10, '1', '1', '1', '1'),
(33, 2, 16, '1', '1', '1', '1'),
(34, 2, 17, '1', '1', '1', '1'),
(35, 2, 59, '1', '1', '1', '1'),
(36, 2, 55, '1', '1', '1', '1'),
(37, 2, 47, '1', '1', '1', '1'),
(38, 2, 60, '1', '1', '1', '1'),
(39, 2, 61, '1', '1', '1', '1'),
(40, 2, 67, '1', '1', '1', '1'),
(41, 2, 66, '1', '1', '1', '1'),
(42, 2, 68, '1', '1', '1', '1'),
(43, 2, 24, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE IF NOT EXISTS `calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'pundit id',
  `suggested_by_user_id` int(11) NOT NULL COMMENT 'general user id',
  `category_id` int(11) NOT NULL,
  `prediction` varchar(255) NOT NULL,
  `content` text,
  `source` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `outcome_id` int(11) DEFAULT NULL COMMENT 'provided by admin',
  `approved` tinyint(1) DEFAULT '0',
  `approval_time` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `vote_start_date` datetime DEFAULT NULL,
  `vote_end_date` datetime DEFAULT NULL,
  `ptvariable` float(8,1) DEFAULT NULL,
  `yield` float(8,2) DEFAULT NULL,
  `boldness` float(8,2) DEFAULT NULL,
  `is_calculated` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sectionId` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `calls`
--

INSERT INTO `calls` (`id`, `user_id`, `suggested_by_user_id`, `category_id`, `prediction`, `content`, `source`, `featured`, `outcome_id`, `approved`, `approval_time`, `due_date`, `vote_start_date`, `vote_end_date`, `ptvariable`, `yield`, `boldness`, `is_calculated`, `created`, `modified`) VALUES
(1, 5, 3, 3, 'will win summer slam next year', NULL, 'summer slam', 1, NULL, 1, '2012-08-21 21:32:39', '2012-11-30 00:00:00', NULL, '2012-09-02 00:00:00', 0.0, NULL, NULL, 0, '2012-08-23 00:00:00', '2012-08-21 21:32:39'),
(2, 5, 3, 3, 'The gr8 body', NULL, 'wwe', 1, NULL, 1, '2012-08-22 00:19:30', '2014-12-31 00:00:00', NULL, '2012-11-16 00:00:00', 1.0, NULL, NULL, 1, '2012-08-22 00:00:00', '2012-08-22 00:19:30'),
(3, 4, 1, 2, 'this is going to archive', NULL, 'money', 0, 4, 1, '2012-08-22 04:03:07', '2020-08-25 00:00:00', NULL, '2013-05-27 00:00:00', 1.0, NULL, NULL, 1, '2012-08-06 00:00:00', '2012-08-22 04:03:07'),
(4, 4, 2, 2, 'Bill gates will open microsoft in Moon', NULL, 'Moon', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2012-08-31 00:00:00', '2012-08-22 04:34:17'),
(5, 5, 2, 3, 'Triple H will marry with Stepni', NULL, 'WWE', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2012-08-22 00:00:00', '2012-08-22 04:35:14'),
(6, 5, 2, 3, 'He is dashing and dashing + 1', NULL, 'WWF', 0, NULL, 0, NULL, '2013-12-31 00:00:00', NULL, '2012-10-12 00:00:00', 0.0, NULL, NULL, 0, '2012-08-23 00:00:00', '2012-08-22 23:22:37'),
(7, 4, 1, 2, 'MS can down his bottom line ', NULL, 'MAHI', 1, 5, 1, '2012-08-23 04:48:42', '2013-12-31 00:00:00', NULL, '2012-10-12 00:00:00', 1.0, 1.00, 0.00, 1, '2012-08-23 00:00:00', '2012-08-23 04:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `flag`, `featured`, `lft`, `rght`, `created`, `modified`) VALUES
(1, 0, 'FINANCE', 1, 1, 1, 2, '2012-06-22 02:57:20', '2012-06-22 02:57:20'),
(2, 0, 'POLITICS', 1, 1, 3, 4, '2012-06-22 02:57:37', '2012-06-22 02:57:37'),
(3, 0, 'SPORTS', 1, 1, 5, 6, '2012-06-22 02:57:47', '2012-06-22 02:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `outcomes`
--

CREATE TABLE IF NOT EXISTS `outcomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `rating` double NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `outcomes`
--

INSERT INTO `outcomes` (`id`, `title`, `rating`, `created`, `modified`) VALUES
(1, 'didn''t come true', -1, '2012-06-05 11:28:06', '2012-06-05 11:28:10'),
(2, 'mostly didn''t come true', -0.5, '2012-06-05 11:28:14', '2012-06-05 11:28:16'),
(3, 'kinda did, kinda didn''t', 0, '2012-06-05 11:28:19', '2012-06-05 11:28:22'),
(4, 'mostly did come true', 0.5, '2012-06-05 11:28:25', '2012-06-05 11:28:28'),
(5, 'definitely came true', 1, '2012-06-05 11:28:31', '2012-06-05 11:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `pundits`
--

CREATE TABLE IF NOT EXISTS `pundits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `score` float(8,2) DEFAULT '0.00',
  `hit_rate` int(11) DEFAULT '0',
  `featured` tinyint(1) DEFAULT NULL,
  `avg_boldness` float(8,2) NOT NULL DEFAULT '0.00',
  `calls_graded` int(11) NOT NULL DEFAULT '0',
  `calls_correct` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pundits`
--

INSERT INTO `pundits` (`id`, `user_id`, `score`, `hit_rate`, `featured`, `avg_boldness`, `calls_graded`, `calls_correct`, `created`, `modified`) VALUES
(1, 4, 1.00, 0, 1, 0.00, 2, 2, '2012-08-21 21:29:48', '2012-08-23 04:50:52'),
(2, 5, NULL, 0, 1, 0.00, 0, 0, '2012-08-21 21:30:12', '2012-08-22 23:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `pundit_categories`
--

CREATE TABLE IF NOT EXISTS `pundit_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pundit_id` int(11) NOT NULL COMMENT 'pundit id or being pundit id',
  `category_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pundit_categories`
--

INSERT INTO `pundit_categories` (`id`, `pundit_id`, `category_id`, `created`, `modified`) VALUES
(1, 1, 2, '2012-08-21 21:29:48', '2012-08-21 21:29:48'),
(2, 2, 3, '2012-08-21 21:30:12', '2012-08-21 21:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `suggested_pundits`
--

CREATE TABLE IF NOT EXISTS `suggested_pundits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pundit_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'existing user',
  `category_id` int(11) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `approval_time` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `suggested_pundits`
--

INSERT INTO `suggested_pundits` (`id`, `pundit_name`, `user_id`, `category_id`, `approve`, `approval_time`, `created`, `modified`) VALUES
(1, 'Triple H', 3, 3, 1, '2012-08-21 21:30:12', '2012-08-21 21:28:43', '2012-08-21 21:30:12'),
(2, 'Bill Gates', 3, 2, 1, '2012-08-21 21:29:48', '2012-08-21 21:29:05', '2012-08-21 21:29:48'),
(5, 'Pundit NotApprove', 3, 3, 0, NULL, '2012-08-22 05:49:15', '2012-08-22 05:49:15'),
(6, 'Pundit NotApprove2', 3, 3, 0, NULL, '2012-08-22 20:40:29', '2012-08-22 20:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_id` varchar(255) DEFAULT NULL,
  `fb_access_token` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `biography` text,
  `score` float(8,2) DEFAULT '0.00' COMMENT 'user score',
  `reset_password_code` varchar(255) DEFAULT NULL,
  `reset_password_date` datetime DEFAULT NULL,
  `avg_boldness` float(8,2) NOT NULL DEFAULT '0.00',
  `calls_graded` int(11) NOT NULL DEFAULT '0',
  `calls_correct` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fb_id`, `fb_access_token`, `first_name`, `last_name`, `email`, `password`, `avatar`, `biography`, `score`, `reset_password_code`, `reset_password_date`, `avg_boldness`, `calls_graded`, `calls_correct`, `created`, `modified`) VALUES
(1, '', '', 'admin', 'admin', 'admin@pundittracker.com', '95d13c2be10b81837a5276f8b23d7e42b7b0ef3f', '', '', NULL, NULL, NULL, 0.00, 0, 0, '2012-06-20 23:42:06', '2012-06-29 00:14:45'),
(2, '', NULL, 'User2', 'General2', 'user_general2@perfectspace.com', '95d13c2be10b81837a5276f8b23d7e42b7b0ef3f', '', 'Hi .....\r\nI am JITz, Your friend ......ok sorry....I am your very gooood friend.', 0.00, NULL, NULL, 0.00, 0, 0, '2012-08-21 21:21:45', '2012-08-21 21:24:02'),
(3, NULL, NULL, 'User1', 'General1', 'user_general1@perfectspace.com', '95d13c2be10b81837a5276f8b23d7e42b7b0ef3f', NULL, NULL, 0.00, '982c42bd8671fd5e784d530ec4290069', '2012-08-23 00:31:10', 0.00, 0, 0, '2012-08-21 21:28:19', '2012-08-23 00:31:10'),
(4, NULL, NULL, 'Bill', 'Gates', '', '76842e65226cc92759c49cb0860a1a312851e8e0', NULL, 'I m money maker', 0.00, NULL, NULL, 0.00, 0, 0, '2012-08-21 21:29:48', '2012-08-21 21:29:48'),
(5, NULL, NULL, 'Triple', 'H', '', '26dbfadb62fa26b770e038abe79ba15e928c95f5', NULL, 'i m the best', 0.00, NULL, NULL, 0.00, 0, 0, '2012-08-21 21:30:12', '2012-08-21 21:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `call_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'voter id',
  `rate` double NOT NULL,
  `ptvariable` float(8,1) DEFAULT NULL,
  `yield` float(8,2) DEFAULT NULL,
  `boldness` float(8,2) DEFAULT NULL,
  `is_calculated` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `call_id_user_id` (`call_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `call_id`, `user_id`, `rate`, `ptvariable`, `yield`, `boldness`, `is_calculated`, `created`, `modified`) VALUES
(1, 2, 3, 0.5, NULL, NULL, NULL, 0, '2012-08-22 00:19:59', '2012-08-22 01:42:20'),
(2, 7, 2, 0.5, NULL, NULL, NULL, 0, '2012-08-23 04:49:58', '2012-08-23 04:49:58'),
(3, 3, 2, -0.5, NULL, NULL, NULL, 0, '2012-08-24 12:08:42', '2012-08-24 12:08:45');
