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

jimport('joomla.application.component.controller');
jimport('joomla.application.input');

class SwsetgroupController extends JController
{
	function __construct($config = array())
    {
		parent::__construct($config);
	}

	function display()
    {
        require_once JPATH_COMPONENT.'/helpers/swsetgroup.php';
        $input = new JInput();
        $vName = $input->get('view', null, 'cmd');
        if (empty($vName)) {
            $input->set('view', 'pending');
            $vName = 'pending';
        }
		// Load the submenu.
		SwsetgroupHelper::addSubmenu($vName);

		parent::display();
	}
}
