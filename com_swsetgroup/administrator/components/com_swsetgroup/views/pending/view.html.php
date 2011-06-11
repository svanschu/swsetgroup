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

jimport('joomla.application.component.view');

class SwsetgroupViewPending extends JView
{
    /**
     * default function to display pending requests
     *
     * @param null $tpl
     * @return bool
     */
	function display($tpl = null){
		JToolBarHelper::title(JText::_( 'COM_SWSETGROUP' ), 'generic.png');
        JToolBarHelper::custom('pending.approve', 'apply.png', 'apply_f2.png', 'COM_SWSETGROUP_APPROVE');
        JToolBarHelper::deleteList('', 'pending.remove');

        $this->items		= $this->get('Items');

        // Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		parent::display($tpl);
	}
}
