<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sven
 * Date: 28.05.11
 * Time: 14:14
 * To change this template use File | Settings | File Templates.
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgUserSwsetgroup extends JPlugin
{
    /**
     * This event is triggered before an update of a user record.
     * Password in $user array is already hashed at this point.
     * @param  $user An associative array of the columns in the user table (current values).
     * @param  $isnew Boolean to identify if this is a new user (true - insert) or an existing one (false - update)
     * @return true
     */
    public function onBeforeStoreUser( $user, $isnew ){

        //$user['email'] get the user email adress
        //$this->param->get(preg, array); get the regular expressions from backend
        return true;
    }
}
