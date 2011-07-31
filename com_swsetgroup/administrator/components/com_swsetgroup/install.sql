-- @version
-- @package             Joomla.Administrator
-- @subpackage  com_swsetgroup
-- @copyright   Copyright (C) 2011 Benjamin Berg & Sven Schultschik. All rights reserved.
-- @license             GNU General Public License version 2 or later

CREATE TABLE IF NOT EXISTS `#__swsetgroup_pending` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `uid` int(11) NOT NULL COMMENT '#__users',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
);