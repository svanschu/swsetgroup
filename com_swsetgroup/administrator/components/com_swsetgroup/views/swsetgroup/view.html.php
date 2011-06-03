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

class SwsetgroupViewSwsetgroup extends JView
{
	function display($tpl = null){
		JToolBarHelper::title( JText::_( 'COM_SWSETGROUP' ), 'generic.png' );
		
		parent::display($tpl);
	}
}
