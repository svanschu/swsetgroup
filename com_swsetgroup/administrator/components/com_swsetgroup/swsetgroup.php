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

// Include dependencies
jimport('joomla.application.component.controller');

// Create the controller
$controller     = JController::getInstance('Swsetgroup');
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
// Redirect if set by the controller
$controller->redirect();
