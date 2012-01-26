<?php
/**
 * @version $Id: $
 * SW SetGroup Component
 *
 * @package	SW SetGroup
 * @Copyright (C) 2011 Benjamin Berg & Sven Schultschik All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.schultschik.de
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * SW set group component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_swsetgroup
 * @since		1.0
 */
class SwsetgroupHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	$vName	The name of the active view.
	 *
	 * @return	void
	 * @since	0.0.0
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_SWSETGROUP_PENDING'),
			'index.php?option=com_swsetgroup&view=pending',
			$vName == 'pending'
        );
	}
}