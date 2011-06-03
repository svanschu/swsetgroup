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

// Require specific controller if requested
$controller = JRequest::getWord('controller');

if($controller){
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)){
        require_once $path;
    }else{
        $controller = '';
    }
}

// Create the controller
$classname      = 'SwsetgroupController'.$controller;
$controller     = new $classname();

$task = JRequest::getCmd('task', null);
// Perform the Request task
$controller->execute($task);
// Redirect if set by the controller
$controller->redirect();
