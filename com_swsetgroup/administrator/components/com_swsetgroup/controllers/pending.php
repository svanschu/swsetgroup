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

jimport('joomla.application.component.controlleradmin');

/**
 * Pending list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_swsetgroup
 * @since	0.0
 */
class SwsetgroupControllerPending extends JControllerAdmin
{
    /**
     * Approve a request to join a group by verifying the e-mail
     *
     * @return void
     */
    function approve()
    {
        // Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        //get the Request ID
        $input = new JInput();
        $cid    = $input->get('cid', null, '');

        $model = $this->getModel('pending');

        if (!$model->approve($cid)) {
            JLog::add($model->getError(), JLog::WARNING);
        }

        $this->setRedirect('index.php?option=com_swsetgroup&view=pending');
    }

    function remove()
    {
        $input = new JInput();
        // Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        //get the Request ID
        $cid    = $input->get('cid', null, '');
        $model = $this->getModel('pending');

        if (!$model->remove($cid)) {
            JLog::add($model->getError(), JLog::WARNING);
        }

        $this->setRedirect('index.php?option=com_swsetgroup&view=pending');
    }
}