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

jimport('joomla.application.component.modelform');
/**
 * model for sw set group
 *
 * @package		Joomla.Site
 * @subpackage	com_swsetgroup
 * @since		1.0
 */
class SwsetgroupModelSwsetgroup extends JModelForm
{
    /**
	 * Method to activate a Group for a user
	 *
	 * @param	$token string		The activation token.
	 * @return	mixed		False on failure.
	 * @since	1.0
	 */
	public function activate($token)
	{
        $db		= $this->getDbo();
        $query  = $db->getQuery(true);
        //Get the data for adding group
        $query->select('*');
        $query->from('#__swsetgroup_pending');
        $query->where('activation='.$db->quote($token));
        $db->setQuery($query);

        $res    = $db->loadObject();

        jimport('joomla.user.helper');
        $suc = JUserHelper::addUserToGroup($res->uid, $res->gid);
        if ($suc !== true){
            $this->setError($res);
            return false;
        }

        $query = $db->getQuery(true);
        $query->delete();
        $query->from('#__swsetgroup_pending');
        $query->where('id='.$db->quote($res->id));
        $db->setQuery($query);

        if (!$db->query()) {
			$e = new JException(JText::_('COM_SWSETGROUP_ERROR_DELETE_FAILED', $db->getErrorMsg()));
			$this->setError($e);
			return false;
		}

        return true;
    }
}