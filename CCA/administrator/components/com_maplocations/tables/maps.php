<?php
/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 JOOCODE. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.database.table');

class MapLocationsTableMaps extends JTable {
  function __construct(&$db) {
    parent::__construct('#__maplocations_maps', 'id', $db);
  }
}
