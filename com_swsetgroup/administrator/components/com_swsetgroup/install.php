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

/**
 * Manage the 
 */
class com_swsetgroupInstallerScript
{
    function install($parent)
    {
        require_once JPATH_ADMINISTRATOR.'/components/com_swsetgroup/helpers/install.php';
        if (SwsetgroupInstallHelper::installPlugin()) {
            echo '<p>'.JText::_('COM_SWSETGROUP_INSTALL_PLUGIN_SUCCESS').'</p>';
        }
    }

    function update($parent)
    {
        self::install($parent);
    }

    function uninstall($parent)
    {
        require_once JPATH_ADMINISTRATOR.'/components/com_swsetgroup/helpers/install.php';
        SwsetgroupInstallHelper::uninstallPlugin();
    }
}