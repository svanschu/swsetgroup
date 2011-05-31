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
     * @return  bool    true on success
     */
    public function onBeforeStoreUser( $user, $isnew ){
        //get the config
        $conf = $this->param->get( 'preg', array() );
        //perform the preg_match
        foreach ( $conf as $v){
            //put him into the group when e-mail is correct
            if( preg_match('#'.$v['preg'].'#', $user['email'] ) && $isnew){
                $user['groups'][] = $v['group'];
            }elseif ( preg_match('#'.$v['preg'].'#', $user['email'] ) && !$isnew){
                //find a way to put him after a mail verification into the group

            }//remove the group if the mail-address get changed back
            elseif ( !preg_match('#'.$v['preg'].'#', $user['email'] ) && !$isnew){
                foreach ( $user['groups'] as $k => $vg){
                    if ( $vg == $v['group'] ){
                        unset ( $user['groups'][$k] );
                    }
                }
            }
        }


        //$user['email'] get the user email adress
        //$this->param->get(preg, array); get the regular expressions from backend
        return true;
    }
}
