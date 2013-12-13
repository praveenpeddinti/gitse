<?php
/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');

class com_maplocationsInstallerScript
{
  function get_version()
  {
    $db = & JFactory::getDBO();
    $table =& JTable::getInstance('extension');
    $db->setQuery('SELECT extension_id FROM #__extensions WHERE type="component" AND element="com_maplocations"');
    $table->load($db->loadResult());
    $version = json_decode($table->manifest_cache)->version;
    return $version;
  }

  function preflight($type, $parent)
  {
    // $parent is the class calling this method
    // $type is the type of change (install, update or discover_install)

    if (!JVersion::isCompatible('2.5')) {
      echo 'Sorry, only Joomla 2.5 and above is supported at the moment';
      exit();
    }


    //migration
    if ($type == 'update') {

      $version = $this->get_version();

      if ($version) {
        if (version_compare($version, '2013.0.0', '<')) {
          //upgrading from old version
          $db = & JFactory::getDBO();
          $query = "CREATE TABLE IF NOT EXISTS `#__maplocations_maps` (
                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `title` varchar(300) NOT NULL,
                    `created_by` int(11) NOT NULL,
                    `created_on` datetime NOT NULL,
                    `status` tinyint(1) NOT NULL DEFAULT '1',
                    `params` text NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
          $db->setQuery($query);
          $db->query();

          $query = "INSERT INTO #__maplocations_maps (`title`) values ('Default map')";
          $db->setQuery($query);
          $db->query();
          $query = "ALTER TABLE #__maplocations_places CHANGE text description text";
          $db->setQuery($query);
          $db->query();
          $query = "ALTER TABLE #__maplocations_places CHANGE state status tinyint(1)";
          $db->setQuery($query);
          $db->query();
          $query = "ALTER TABLE #__maplocations_places CHANGE enabled status tinyint(1)";
          $db->setQuery($query);
          $db->query();
          $query = "ALTER TABLE #__maplocations_places CHANGE maplocations_place_id id int(11)";
          $db->setQuery($query);
          $db->query();
          $query = "ALTER TABLE #__maplocations_places DROP COLUMN timezone";
          $db->setQuery($query);
          $db->query();
          $query = "ALTER TABLE #__maplocations_places ADD COLUMN params text";
          $db->setQuery($query);
          $db->query();
          $query = "ALTER TABLE #__maplocations_places ADD COLUMN map_id int(11)";
          $db->setQuery($query);
          $db->query();
          $query = "UPDATE #__maplocations_places SET `map_id` = 1 WHERE 1";
          $db->setQuery($query);
          $db->query();
        }
      }

    }

    //echo '<style>.adminform {width: 100%;}</style><div style="margin: 0 auto; text-align: center"><a href="index.php?option=com_maplocations"><img src="../media/com_maplocations/img/install.png" /></a></div>';
  }
}
