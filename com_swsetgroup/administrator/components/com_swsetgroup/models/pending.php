<?php
/**
 * @version
 * @package             Joomla.Administrator
 * @subpackage  com_swsetgroup
 * @copyright   Copyright (C) 2011 Benjamin Berg & Sven Schultschik. All rights reserved.
 * @license             GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * Methods supporting a list of article records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_swsetgroup
 */
class SwsetgroupModelPending extends JModelList
{
    /**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.0
	 */
	protected function getListQuery()
	{
        // Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('a.id, a.uid, a.time');
        $query->from('#__swsetgroup_pending AS a');

        //Join from user table
        $query->select('u.username');
        $query->join('LEFT', '#__users AS u ON u.id = a.uid');

        return $query;
    }

    /**
     * Approve a request to join a group by verifying the e-mail
     *
     * @param  array $id  primary key of the request
     * @return bool true on success. else false with setting error
     * @since 1.0
     */
    public function approve($cid = array())
    {
        $table  = $this->getTable('pending', 'SwsetgroupTable');
        if (!$table->load($cid[0])) {
            $this->setError($table->getError());
            return false;
        }

        jimport('joomla.user.helper');

        $res = JUserHelper::addUserToGroup($table->uid, $table->gid);
        if ($res != true) {
            $this->setError($res);
            return false;
        }

        if (!self::remove($cid))
            return false;

        return true;
    }

    /**
     * Remove requests
     *
     * @param  array $cid array of id to delete
     * @return bool
     * @since 1.0
     */
    public function remove($cid = array())
    {
        $table  = $this->getTable('pending', 'SwsetgroupTable');
        foreach ($cid as $id) {
            if (!$table->delete($id)) {
                $this->setError($table->getError());
                return false;
            }
        }

        return true;
    }
}