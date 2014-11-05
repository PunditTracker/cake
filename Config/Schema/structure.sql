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
);


INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(24, 1, NULL, NULL, 'Pundits', 52, 71),
(36, 32, NULL, NULL, 'SuggestedPundits::admin_edit', 79, 80),
(14, 11, NULL, NULL, 'Categories::admin_edit', 31, 32),
(38, 32, NULL, NULL, 'SuggestedPundits::index', 83, 84),
(1, NULL, NULL, NULL, 'ALL', 1, 152),
(23, 19, NULL, NULL, 'Outcomes::admin_index', 49, 50),
(8, 3, NULL, NULL, 'Calls::admin_edit', 13, 14),
(37, 32, NULL, NULL, 'SuggestedPundits::admin_index', 81, 82),
(76, 24, NULL, NULL, 'Pundits::admin_delete', 69, 70),
(2, 1, NULL, NULL, 'Acm', 2, 3),
(45, 40, NULL, NULL, 'Users::admin_user_view', 99, 100),
(73, 24, NULL, NULL, 'Pundits::punditList', 67, 68),
(74, 3, NULL, NULL, 'Calls::admin_upload_csv', 21, 22),
(9, 3, NULL, NULL, 'Calls::admin_index', 15, 16),
(55, 40, NULL, NULL, 'Users::live_call', 119, 120),
(6, 3, NULL, NULL, 'Calls::admin_approve', 9, 10),
(69, 68, NULL, NULL, 'Pages::display', 149, 150),
(64, 1, NULL, NULL, 'Votes', 142, 147),
(21, 19, NULL, NULL, 'Outcomes::admin_delete', 45, 46),
(68, 1, NULL, NULL, 'Pages', 148, 151),
(53, 40, NULL, NULL, 'Users::home', 115, 116),
(62, 40, NULL, NULL, 'Users::signup', 133, 134),
(15, 11, NULL, NULL, 'Categories::admin_index', 33, 34),
(42, 40, NULL, NULL, 'Users::admin_delete', 93, 94),
(16, 11, NULL, NULL, 'Categories::archive_call', 35, 36),
(61, 40, NULL, NULL, 'Users::reset_password', 131, 132),
(26, 24, NULL, NULL, 'Pundits::archive_call', 55, 56),
(13, 11, NULL, NULL, 'Categories::admin_delete', 29, 30),
(60, 40, NULL, NULL, 'Users::reset_new', 129, 130),
(44, 40, NULL, NULL, 'Users::admin_index', 97, 98),
(17, 11, NULL, NULL, 'Categories::live_call', 37, 38),
(72, 64, NULL, NULL, 'Votes::saveVote', 145, 146),
(10, 3, NULL, NULL, 'Calls::history', 17, 18),
(12, 11, NULL, NULL, 'Categories::admin_add', 27, 28),
(57, 40, NULL, NULL, 'Users::logout', 123, 124),
(27, 24, NULL, NULL, 'Pundits::categoryList', 57, 58),
(70, 3, NULL, NULL, 'Calls::admin_add', 19, 20),
(4, 3, NULL, NULL, 'Calls::add', 5, 6),
(34, 32, NULL, NULL, 'SuggestedPundits::admin_approve', 75, 76),
(20, 19, NULL, NULL, 'Outcomes::admin_add', 43, 44),
(18, 11, NULL, NULL, 'Categories::view', 39, 40),
(25, 24, NULL, NULL, 'Pundits::admin_edit_info', 53, 54),
(11, 1, NULL, NULL, 'Categories', 26, 41),
(28, 24, NULL, NULL, 'Pundits::history', 59, 60),
(71, 32, NULL, NULL, 'SuggestedPundits::admin_add', 87, 88),
(35, 32, NULL, NULL, 'SuggestedPundits::admin_delete', 77, 78),
(30, 24, NULL, NULL, 'Pundits::live_call', 63, 64),
(65, 64, NULL, NULL, 'Votes::add', 143, 144),
(75, 3, NULL, NULL, 'Calls::search', 23, 24),
(47, 40, NULL, NULL, 'Users::archive_call', 103, 104),
(31, 24, NULL, NULL, 'Pundits::profile', 65, 66),
(22, 19, NULL, NULL, 'Outcomes::admin_edit', 47, 48),
(51, 40, NULL, NULL, 'Users::edit_info', 111, 112),
(3, 1, NULL, NULL, 'Calls', 4, 25),
(7, 3, NULL, NULL, 'Calls::admin_delete', 11, 12),
(40, 1, NULL, NULL, 'Users', 90, 141),
(59, 40, NULL, NULL, 'Users::profile', 127, 128),
(33, 32, NULL, NULL, 'SuggestedPundits::add', 73, 74),
(29, 24, NULL, NULL, 'Pundits::index', 61, 62),
(56, 40, NULL, NULL, 'Users::login', 121, 122),
(43, 40, NULL, NULL, 'Users::admin_edit', 95, 96),
(52, 40, NULL, NULL, 'Users::forgot_password', 113, 114),
(32, 1, NULL, NULL, 'SuggestedPundits', 72, 89),
(19, 1, NULL, NULL, 'Outcomes', 42, 51);


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
);

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'Admin', 1, 10),
(2, NULL, NULL, NULL, 'Anonymous', 11, 74),
(3, 2, NULL, NULL, 'Pundit', 12, 13),
(4, 2, NULL, NULL, 'General', 14, 67),
(5, 2, NULL, NULL, 'Future-use', 68, 73),
(6, 1, NULL, 1, 'User::1', 2, 3);
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
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`) USING BTREE
);


INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(24, 2, 52, '1', '1', '1', '1'),
(36, 2, 55, '1', '1', '1', '1'),
(14, 4, 38, '-1', '-1', '-1', '-1'),
(38, 2, 60, '1', '1', '1', '1'),
(1, 1, 1, '1', '1', '1', '1'),
(23, 4, 65, '1', '1', '1', '1'),
(8, 4, 26, '1', '1', '1', '1'),
(37, 2, 47, '1', '1', '1', '1'),
(2, 4, 4, '1', '1', '1', '1'),
(45, 2, 75, '1', '1', '1', '1'),
(9, 4, 27, '1', '1', '1', '1'),
(6, 4, 18, '1', '1', '1', '1'),
(21, 4, 55, '1', '1', '1', '1'),
(42, 2, 68, '1', '1', '1', '1'),
(16, 4, 59, '1', '1', '1', '1'),
(39, 2, 61, '1', '1', '1', '1'),
(26, 2, 31, '1', '1', '1', '1'),
(13, 4, 33, '1', '1', '1', '1'),
(44, 4, 73, '1', '1', '1', '1'),
(17, 4, 61, '1', '1', '1', '1'),
(10, 4, 28, '1', '1', '1', '1'),
(12, 4, 30, '1', '1', '1', '1'),
(27, 2, 62, '1', '1', '1', '1'),
(4, 4, 16, '1', '1', '1', '1'),
(34, 2, 17, '1', '1', '1', '1'),
(20, 4, 47, '1', '1', '1', '1'),
(18, 4, 60, '1', '1', '1', '1'),
(25, 2, 56, '1', '1', '1', '1'),
(5, 4, 17, '1', '1', '1', '1'),
(11, 4, 29, '1', '1', '1', '1'),
(28, 2, 30, '1', '1', '1', '1'),
(35, 2, 59, '1', '1', '1', '1'),
(30, 2, 28, '1', '1', '1', '1'),
(31, 2, 18, '1', '1', '1', '1'),
(22, 4, 57, '1', '1', '1', '1'),
(3, 4, 10, '1', '1', '1', '1'),
(7, 4, 31, '1', '1', '1', '1'),
(33, 2, 16, '1', '1', '1', '1'),
(29, 2, 26, '1', '1', '1', '1'),
(43, 2, 24, '1', '1', '1', '1'),
(32, 2, 10, '1', '1', '1', '1'),
(19, 4, 51, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE IF NOT EXISTS `calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'pundit id or general user id',
  `suggested_by_user_id` int(11) NOT NULL,
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
  KEY `sectionId` (`user_id`) USING BTREE
);

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
  `slug` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);


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
);

INSERT INTO `outcomes` (`id`, `title`, `rating`, `created`, `modified`) VALUES
(1, 'didn''t come true', -1, '2012-06-05 11:28:06', '2012-06-05 11:28:10'),
(2, 'mostly didn''t come true', -0.5, '2012-06-05 11:28:14', '2012-06-05 11:28:16'),

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
);

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
);

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
);

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
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `biography` text,
  `score` float(8,2) DEFAULT '0.00' COMMENT 'how much votes you do',
  `reset_password_code` varchar(255) DEFAULT NULL,
  `reset_password_date` datetime DEFAULT NULL,
  `avg_boldness` float(8,2) NOT NULL DEFAULT '0.00',
  `calls_graded` int(11) NOT NULL DEFAULT '0',
  `calls_correct` int(11) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `users` (`id`, `fb_id`, `fb_access_token`, `first_name`, `last_name`, `slug`, `email`, `password`, `avatar`, `biography`, `score`, `reset_password_code`, `reset_password_date`, `created`, `modified`) VALUES
(1, '', '', 'admin', 'admin', 'admin', 'admin@pundittracker.com', '95d13c2be10b81837a5276f8b23d7e42b7b0ef3f', '', '', NULL, NULL, NULL, '2012-06-20 23:42:06', '2012-06-29 00:14:45');


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
  PRIMARY KEY (`id`)
);
