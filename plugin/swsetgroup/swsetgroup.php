<?php
/**
 * @version $Id: $
 * SW SetGroup User Plugin
 *
 * @package        SW SetGroup
 * @Copyright (C) 2011 Benjamin Berg & Sven Schultschik All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.schultschik.de
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.user.user');
jimport('joomla.user.helper');
jimport('joomla.mail.mail');

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

        $activation_key = false;
        //perform the preg_match
        foreach ($group_preg as $group => $preg) {
            if ($isnew) {
                // The user is new
                // Add to the group if the regular expression matches
                if (preg_match('#'.$preg.'#', $user['email'])) {
                    JUserHelper::addUserToGroup($user['id'], $group);
                }
            } else {
                // The user already exists
                if (preg_match('#'.$preg.'#', $user['email'])) {
                    $user['new_groups'][] = $group;
                    $db = JFactory::getDbo();

                    // Remove any existing activations for the user
                    $query = $db->getQuery(true);
                    $query->delete('#__swsetgroup_pending');
                    $query->where('uid=' . $user['id']);
                    $db->setQuery($query);
                    if (!$db->query()) {
                        $e = new JException(JText::_('PLG_USER_SWSETGROUP_ERROR_SAVE_REQUEST', $db->getErrorMsg()));
                        $this->setError($e);
                        return false;
                    }

                    //Create Key if not exist
                    if ($activation_key === false) {
                        $activation_key = JUserHelper::genRandomPassword();
                    }

                    //save information about the request
                    $query = $db->getQuery(true);
                    $query->insert('#__swsetgroup_pending');
                    $set = array('uid=' . $user['id'],
                                 'activation=\'' . $activation_key . '\'',
                                 'gid=' . $group);
                    $query->set($set);
                    $db->setQuery($query);
                    if (!$db->query()) {
                        $e = new JException(JText::_('PLG_USER_SWSETGROUP_ERROR_SAVE_REQUEST', $db->getErrorMsg()));
                                    $this->setError($e);
                            return false;
                    }
                } else {
                    // Remove user from group.
                    JUserHelper::removeUserFromGroup($user['id'], $group);
                }
            }
        }


        if ($activation_key !== false) {
            $config = JFactory::getConfig();
            $sitename   = $config->get('sitename');
            //load the language file
            $user_lang = JUser::getInstance($user['id'])->getParam('language');
            if (empty($user_lang)) {
                $user_lang = $config->get('language');
            }
            $lang = JLanguage::getInstance($user_lang);
            $lang->load('plg_user_swsetgroup');

            //Prepare the e-mail
            $mail = JMail::getInstance();
            $mail->addRecipient($user['email']);
            $mail->setSubject(sprintf($lang->_('PLG_USER_SWSETGROUP_EMAIL_SUBJECT'), $user['name'], $sitename));
            $mail->setBody(sprintf($lang->_('PLG_USER_SWSETGROUP_EMAIL_BODY'), $user['name'], $sitename,
                           JURI::root().'index.php?option=com_swsetgroup&task=activate&token='.$activation_key));
            $mail->setSender($config->get('mailfrom'));
            $return = $mail->send();
            if ($return !== true) {
                //TODO richtig?
                $this->setError(JText::_('PLG_USER_SWSETGROUP_EMAIL_SEND_FAILED'));
                // Send a system message to administrators receiving system mails
                $query = $db->getQuery(true);
                //TODO query prüfen ob correct
                $query->select('id');
                $query->from('#__users');
                $query->where('block=`0`');
                $query->where('sendEmail=`1`');
                $db->setQuery($query);
                $sendEmail = $db->loadResultArray();
                if (count($sendEmail) > 0) {
                    $jdate = new JDate();
                    // Build the query to add the messages
                    $q = "INSERT INTO `#__messages` (`user_id_from`, `user_id_to`, `date_time`, `subject`, `message`)
                        VALUES ";
                    $messages = array();
                    foreach ($sendEmail as $userid) {
                        $messages[] = "(".$userid.", ".$userid.", '".$jdate->toMySQL()."', '"
                                      .JText::_('PLG_USER_SWSETGROUP_MAIL_SEND_FAILURE_SUBJECT')."', '"
                                      .JText::sprintf('PLG_USER_SWSETGROUP_MAIL_SEND_FAILURE_BODY',
                                                      $return, $user['username'])."')";
                    }
                    $q .= implode(',', $messages);
                    $db->setQuery($q);
                    $db->query();
                }
                return false;
            }
        }

        $this->updating_user = false;
        return true;
    }
}
