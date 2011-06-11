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
 * Content component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class ContentHelper
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
		JSubMenuHelper::addEntry( JText::_('COM_SWSETGROUP_PENDING'), 'index.php?option=com_swsetgroup&view=pending',
                                  $vName == 'pending'
        );
		/*JSubMenuHelper::addEntry( JText::_('COM_SWSETGROUP_REGULAR_EXPRESSION_CONFIG'),
                                  'index.php?option=com_swsetgroup&view=config', $vName == 'categories'
        );*/
	}
}