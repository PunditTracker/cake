--
-- Date : 06/20/2012
--
ALTER TABLE  `calls` CHANGE  `approved`  `approved` TINYINT( 1 ) NULL DEFAULT  '0';

--
-- Date : 06/21/2012
--
ALTER TABLE  `pundits` ADD  `category_id` INT NOT NULL AFTER  `user_id`;

--
-- Date : 06/21/2012
--
ALTER TABLE  `users` ADD  `reset_password_code` VARCHAR( 255 ) NULL AFTER  `score` ,
ADD  `reset_password_date` DATETIME NULL AFTER  `reset_password_code`;


--
-- Date : 07/04/2012
--
ALTER TABLE  `pundits` DROP  `category_id`;


--
-- Date : 07/05/2012
--
ALTER TABLE  `votes` CHANGE  `rate`  `rate` DOUBLE NOT NULL;


--
-- Date : 07/06/2012
--
ALTER TABLE  `users` CHANGE  `score`  `score` INT( 11 ) NULL DEFAULT  '0' COMMENT  'how much correct votes you do';


--
-- Date : 07/09/2012
--
ALTER TABLE  `outcomes` CHANGE  `rating`  `rating` DOUBLE NOT NULL;

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
);

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'ALL', 1, 152),
(2, 1, NULL, NULL, 'Acm', 2, 3),
(3, 1, NULL, NULL, 'Calls', 4, 25),
(4, 3, NULL, NULL, 'Calls::add', 5, 6),
(6, 3, NULL, NULL, 'Calls::admin_approve', 9, 10),
(7, 3, NULL, NULL, 'Calls::admin_delete', 11, 12),
(8, 3, NULL, NULL, 'Calls::admin_edit', 13, 14),
(9, 3, NULL, NULL, 'Calls::admin_index', 15, 16),
(10, 3, NULL, NULL, 'Calls::history', 17, 18),
(11, 1, NULL, NULL, 'Categories', 26, 41),
(12, 11, NULL, NULL, 'Categories::admin_add', 27, 28),
(13, 11, NULL, NULL, 'Categories::admin_delete', 29, 30),
(14, 11, NULL, NULL, 'Categories::admin_edit', 31, 32),
(15, 11, NULL, NULL, 'Categories::admin_index', 33, 34),
(16, 11, NULL, NULL, 'Categories::archive_call', 35, 36),
(17, 11, NULL, NULL, 'Categories::live_call', 37, 38),
(18, 11, NULL, NULL, 'Categories::view', 39, 40),
(19, 1, NULL, NULL, 'Outcomes', 42, 51),
(20, 19, NULL, NULL, 'Outcomes::admin_add', 43, 44),
(21, 19, NULL, NULL, 'Outcomes::admin_delete', 45, 46),
(22, 19, NULL, NULL, 'Outcomes::admin_edit', 47, 48),
(23, 19, NULL, NULL, 'Outcomes::admin_index', 49, 50),
(24, 1, NULL, NULL, 'Pundits', 52, 71),
(25, 24, NULL, NULL, 'Pundits::admin_edit_info', 53, 54),
(26, 24, NULL, NULL, 'Pundits::archive_call', 55, 56),
(27, 24, NULL, NULL, 'Pundits::categoryList', 57, 58),
(28, 24, NULL, NULL, 'Pundits::history', 59, 60),
(29, 24, NULL, NULL, 'Pundits::index', 61, 62),
(30, 24, NULL, NULL, 'Pundits::live_call', 63, 64),
(31, 24, NULL, NULL, 'Pundits::profile', 65, 66),
(32, 1, NULL, NULL, 'SuggestedPundits', 72, 89),
(33, 32, NULL, NULL, 'SuggestedPundits::add', 73, 74),
(34, 32, NULL, NULL, 'SuggestedPundits::admin_approve', 75, 76),
(35, 32, NULL, NULL, 'SuggestedPundits::admin_delete', 77, 78),
(36, 32, NULL, NULL, 'SuggestedPundits::admin_edit', 79, 80),
(37, 32, NULL, NULL, 'SuggestedPundits::admin_index', 81, 82),
(38, 32, NULL, NULL, 'SuggestedPundits::index', 83, 84),
(40, 1, NULL, NULL, 'Users', 90, 141),
(42, 40, NULL, NULL, 'Users::admin_delete', 93, 94),
(43, 40, NULL, NULL, 'Users::admin_edit', 95, 96),
(44, 40, NULL, NULL, 'Users::admin_index', 97, 98),
(45, 40, NULL, NULL, 'Users::admin_user_view', 99, 100),
(47, 40, NULL, NULL, 'Users::archive_call', 103, 104),
(51, 40, NULL, NULL, 'Users::edit_info', 111, 112),
(52, 40, NULL, NULL, 'Users::forgot_password', 113, 114),
(53, 40, NULL, NULL, 'Users::home', 115, 116),
(55, 40, NULL, NULL, 'Users::live_call', 119, 120),
(56, 40, NULL, NULL, 'Users::login', 121, 122),
(57, 40, NULL, NULL, 'Users::logout', 123, 124),
(59, 40, NULL, NULL, 'Users::profile', 127, 128),
(60, 40, NULL, NULL, 'Users::reset_new', 129, 130),
(61, 40, NULL, NULL, 'Users::reset_password', 131, 132),
(62, 40, NULL, NULL, 'Users::signup', 133, 134),
(64, 1, NULL, NULL, 'Votes', 142, 147),
(65, 64, NULL, NULL, 'Votes::add', 143, 144),
(68, 1, NULL, NULL, 'Pages', 148, 151),
(69, 68, NULL, NULL, 'Pages::display', 149, 150),
(70, 3, NULL, NULL, 'Calls::admin_add', 19, 20),
(71, 32, NULL, NULL, 'SuggestedPundits::admin_add', 87, 88),
(72, 64, NULL, NULL, 'Votes::saveVote', 145, 146),
(73, 24, NULL, NULL, 'Pundits::punditList', 67, 68),
(74, 3, NULL, NULL, 'Calls::admin_upload_csv', 21, 22),
(75, 3, NULL, NULL, 'Calls::search', 23, 24),
(76, 24, NULL, NULL, 'Pundits::admin_delete', 69, 70);


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
);

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
(45, 2, 75, '1', '1', '1', '1'),
(42, 2, 68, '1', '1', '1', '1'),
(43, 2, 24, '1', '1', '1', '1'),
(44, 4, 73, '1', '1', '1', '1');

--
--Date 09/AUG/2012
--
ALTER TABLE  `pundits` ADD  `featured` BOOL NULL AFTER  `hit_rate`;



--
--Date 13/AUG/2012
--
ALTER TABLE  `calls` ADD  `ptvariable` FLOAT( 8, 2 ) NOT NULL AFTER  `vote_end_date` ,
ADD  `yield` FLOAT( 8, 2 ) NOT NULL AFTER  `ptvariable` ,
ADD  `boldness` FLOAT( 8, 2 ) NOT NULL AFTER  `yield`;


--
--Date 14/AUG/2012
--
ALTER TABLE  `calls` ADD  `is_calculated` BOOL NOT NULL DEFAULT  '0' AFTER  `boldness`;

ALTER TABLE  `pundits` CHANGE  `score`  `score` FLOAT( 8, 2 ) NULL DEFAULT  '0';

ALTER TABLE  `pundits` ADD  `avg_boldness` FLOAT( 8, 2 ) NOT NULL DEFAULT  '0.0' AFTER  `featured` ,
ADD  `calls_graded` INT NOT NULL DEFAULT  '0' AFTER  `avg_boldness` ,
ADD  `calls_correct` INT NOT NULL DEFAULT  '0' AFTER  `calls_graded`;
  
  
ALTER TABLE  `calls` CHANGE  `ptvariable`  `ptvariable` FLOAT( 8, 1 ) NULL DEFAULT NULL;


--
--Date 16/AUG/2012
--
ALTER TABLE  `votes` ADD  `ptvariable` FLOAT( 8, 1 ) NULL AFTER  `rate` ,
ADD  `yield` FLOAT( 8, 2 ) NULL AFTER  `ptvariable` ,
ADD  `boldness` FLOAT( 8, 2 ) NULL AFTER  `yield`;

ALTER TABLE  `votes` ADD  `is_calculated` BOOL NOT NULL DEFAULT  '0' AFTER  `boldness`;

--
--Date 17/AUG/2012
--
ALTER TABLE  `users` ADD  `avg_boldness` FLOAT( 8, 2 ) NOT NULL DEFAULT  '0.0' AFTER  `reset_password_date` ,
ADD  `calls_graded` INT NOT NULL DEFAULT  '0' AFTER  `avg_boldness` ,
ADD  `calls_correct` INT NOT NULL DEFAULT  '0' AFTER  `calls_graded`;

ALTER TABLE  `users` CHANGE  `score`  `score` FLOAT( 8, 2 ) NULL DEFAULT  '0' COMMENT  'user score';

--
--Date 20/AUG/2012
--
ALTER TABLE  `calls` CHANGE  `ptvariable`  `ptvariable` FLOAT( 8, 1 ) NULL ,
CHANGE  `yield`  `yield` FLOAT( 8, 2 ) NULL ,
CHANGE  `boldness`  `boldness` FLOAT( 8, 2 ) NULL;


--
--Date 01/NOV/2012
--
ALTER TABLE  `categories` ADD  `slug` VARCHAR( 255 ) NOT NULL AFTER  `name`;

ALTER TABLE  `users` ADD  `slug` VARCHAR( 255 ) NOT NULL AFTER  `last_name`;


--
--Date 28/NOV/2012
--
ALTER TABLE  `calls` ADD  `slug` VARCHAR( 255 ) NOT NULL AFTER  `prediction`;


--
--Date 19/FEB/2013
--
ALTER TABLE  `users` ADD  `private` TINYINT( 1 ) NOT NULL AFTER  `calls_correct`;