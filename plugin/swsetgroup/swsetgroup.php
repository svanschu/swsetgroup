<?php
/**
 * @version $Id: $
 * SW SetGroup User Plugin
 *
 * @package	SW SetGroup
 * @Copyright (C) 2011 Benjamin Berg & Sven Schultschik All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.schultschik.de
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.user.user');

class plgUserSwsetgroup extends JPlugin
{

    private $updating_user = false;

    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function onUserAfterSave($user, $isnew, $success, $msg)
    {
        if ($this->updating_user)
            return true;

        if (!$success)
            return false;

        $this->updating_user = true;

        //get the config
        $config = $this->params->toArray();

        $all_keys = array_keys($config);
        $group_preg = array();
        foreach ($all_keys as $key) {
            if (preg_match('/^preg_([0-9]+)_preg$/', $key, $matches)) {
                // Ignore any empty regular expression
                if ($config[$key] != "") {
                    // check whether there is a _group variable (maybe do not
                    // do this and throw an PHP error in this case?
                    if (array_key_exists("preg_{$matches[1]}_group", $config)) {
                        $group_preg[$config["preg_{$matches[1]}_group"]] = $config[$key];
                    }
                }
            }
        }

        //perform the preg_match
        foreach ($group_preg as $group => $preg) {
            if ($isnew) {
                // The user is new

                // Add to the group if the regular expression matches
                if (preg_match('#'.$preg.'#', $user['email'])) {
                    $real_user = new JUser($user['id']);
                    $real_user->groups[] = $group;
                    $real_user->save();
                }
            } else {
                // The user already exists

                if (preg_match('#'.$preg.'#', $user['email'])) {
                    // Send verification e-mail from here
                } else {
                    $real_user = new JUser($user['id']);

                    // Remove user from group.
                    $k = array_search($group, $real_user->groups);
                    if ($k !== FALSE) {
                        unset($real_user->groups[$k]);
                    }

                    $real_user->save();
                }
            }
        }

        $this->updating_user = false;
        return true;
    }
}
