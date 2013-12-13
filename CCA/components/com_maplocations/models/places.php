<?php
/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 JOOCODE. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');

class MapLocationsModelPlaces extends JModelList
{
  var $mapId = null;

  protected function _getListQuery($mapId = null)
  {
    // Capture the last store id used.
    static $lastStoreId;

    // Compute the current store id.
    $currentStoreId = $this->getStoreId();

    // If the last store id is different from the current, refresh the query.
    if ($lastStoreId != $currentStoreId || empty($this->query))
    {
      $lastStoreId = $currentStoreId;
      $this->query = $this->getListQuery($mapId);
    }

    return $this->query;
  }

  public function getItems($mapId = null)
  {
    // Get a storage key.
    $store = $this->getStoreId();

    // Try to load the data from internal storage.
    if (isset($this->cache[$store]))
    {
      return $this->cache[$store];
    }

    // Load the list items.
    $query = $this->_getListQuery($mapId);

    try
    {
      $items = $this->_getList($query, $this->getStart(), $this->getState('list.limit'));
    }
    catch (RuntimeException $e)
    {
      $this->setError($e->getMessage());
      return false;
    }

    // Add the items to the internal cache.
    $this->cache[$store] = $items;

    return $this->cache[$store];
  }

  protected function getListQuery($mapId = null)
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from($db->quoteName('#__maplocations_places').' AS a');

    if ($mapId) {
      $query->where('map_id='.$db->quote($mapId));
    }

    return $query;
  }

  protected function populateState($ordering = null, $direction = null)
  {
    parent::populateState();
    $this->setState('list.limit', 99999);
  }
}
