<?php
/**
 *
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgUserSwsetgroup extends JPlugin
{

    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function onUserBeforeSave($user, $isnew, $new)
    {
        //get the config
        print("HELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\nHELLO\n");
        $config = $this->param->toArray();

        $all_keys = array_keys($config);
        $group_preg = array();
        foreach ($all_keys as $key) {
            if (preg_match('^preg_([0-9]+)_preg$', $key, $matches)) {
                if (array_key_exists("preg_{$matches[1]}_group")) {
                    $group_preg["preg_{$matches[1]}_group"] = $config[$key];
                }
            }
        }

        //perform the preg_match
        foreach ($group_preg as $group => $preg) {
            if ($isnew) {
                // The user is new

                // Add to the group if the regular expression matches
                if (preg_match('#'.$preg.'#', $new['email'])) {
                    $new['groups'][] = $group;
                }
                print_r($new);
            } else {
                // The user already exists

                if (preg_match('#'.$preg.'#', $new['email'])) {
                    // Send verification e-mail from here
                } else {
                    // Remove user from group.
                    $k = array_search($group, $new['groups']);
                    if ($k !== FALSE) {
                        unset ($new['groups'][$k]);
                    }
                }
            }
        }


        //$user['email'] get the user email adress
        //$this->param->get(preg, array); get the regular expressions from backend
        return true;
    }
}
