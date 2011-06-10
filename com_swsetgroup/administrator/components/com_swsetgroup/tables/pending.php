<?php
/**
 * @version
 * @package             Joomla.Administrator
 * @subpackage  com_swsetgroup
 * @copyright   Copyright (C) 2011 Benjamin Berg & Sven Schultschik. All rights reserved.
 * @license             GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	pending
 */
class SwsetgroupTablePending extends JTable
{
	/**
	 * @param	JDatabase	A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__swsetgroup_pending', 'id', $db);
	}
}