<?php
/**
 *
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
     * @return  bool    true on success
     */
    public function onBeforeStoreUser( $user, $isnew ) {
        //get the config
        $conf = $this->param->get( 'preg', array() );
        //perform the preg_match
        foreach ($conf as $v) {
            if ($isnew) {
                // The user is new

                // Add to the group if the regular expression matches
                if (preg_match('#'.$v['preg'].'#', $user['email'])) {
                    $user['groups'][] = $v['group'];
                }
            } else {
                // The user already exists

                if (preg_match('#'.$v['preg'].'#', $user['email'])) {
                    // Send verification e-mail from here
                } else {
                    // Remove user from group.
                    $k = array_search($v['group'], $user['groups']);
                    if ($k !== FALSE) {
                        unset ($user['groups'][$k]);
                    }
                }
            }
        }


        //$user['email'] get the user email adress
        //$this->param->get(preg, array); get the regular expressions from backend
        return true;
    }
}
