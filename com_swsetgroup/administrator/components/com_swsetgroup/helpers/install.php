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

jimport ( 'joomla.filesystem' );
/**
 * SW set group install helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_swsetgroup
 * @since		1.0.0
 */
class SwsetgroupInstallHelper
{
    /**
     * Install the plugin
     * @return bool
     */
    static function installPlugin()
    {
        //plugins folder exist?
        $path = JPATH_ADMINISTRATOR.'/components/com_swsetgroup/plugins/plg_swsetgroup_1.1.0beta1_b37_20110805.zip';
        //plugin zip exist?
        if (!JFile::exists($path)) {
            JLog::add(JText::sprintf('COM_SWSETGROUP_INSTALL_PLUGIN_NOT_FOUND', $path), JLog::ERROR);
            return false;
        }
        //extract the zip
        $extpath = JPATH_ROOT.'/tmp/';
        if (!JArchive::extract($path, $extpath)) {
            JLog::add(JText::_('COM_SWSETGROUP_INSTALL_PLUGIN_UNZIP_FAIL'), JLog::ERROR);
            return false;
        }
        //get installer instance
        $installer = new JInstaller();
        //install the plugin
        if (!$installer->install($extpath.'swsetgroup')) {
            return false;
        }
        //delete the temp folder
        JFolder::delete($extpath.'/swsetgroup');

        return true;
    }

    static function uninstallPlugin()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('extension_id');
        $query->from('#__extensions');
        $query->where('type=\'plugin\'');
        $query->where('folder=\'user\'');
        $query->where('element=\'swsetgroup\'');
        $db->setQuery($query);
        $id = $db->loadResult();
        if ($id) {
            $installer = new JInstaller();
            $installer->uninstall('plugin', $id);
        }

    }
}