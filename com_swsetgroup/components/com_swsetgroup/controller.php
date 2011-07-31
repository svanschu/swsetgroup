<?php
/**
 * @version $Id: $
 * SW SetGroup Component
 *
 * @package    SW SetGroup
 * @Copyright (C) 2011 Benjamin Berg & Sven Schultschik All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.schultschik.de
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Base controller class for SW Set Group.
 *
 * @package        Joomla.Site
 * @subpackage    com_swsetgroup
 * @since        1.0
 */
class SwsetgroupController extends JController
{
    public function activate()
    {
        $token = JRequest::getVar('token');

        // Check that the token is in a valid format.
        if ($token === null) {
            JError::raiseError(403, JText::_('JINVALID_TOKEN'));
            return false;
        }

        $model = $this->getModel();

        if (!$model->activate($token)) {
            // Redirect back to the homepage.
            $this->setMessage(JText::sprintf('COM_SWSETGROUP_GROUP_ACTIVATION_FAILED', $model->getError()));
            $this->setRedirect('index.php');
            return false;
        }

        $this->setMessage(JText::_('COM_SWSETGROUP_GROUP_ACTIVATION_SUCCESS'));
        $this->setRedirect('index.php');
    }
}
