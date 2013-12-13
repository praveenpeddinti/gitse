<?php

/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 JOOCODE. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');

class MapLocationsControllerPlace extends JControllerAdmin
{
  public function save() {
    $app = JFactory::getApplication();
    $item = $app->input->get('item', '', 'ARRAY');

    // ob_start();
    // var_dump($item);
    // $contents = ob_get_contents();
    // ob_end_clean();
    // error_log($contents);

    $db = JFactory::getDBO();
    $query = $db->getQuery(true);

    if ($item['id']) {
      //update
      $alias = JApplication::stringURLSafe($item['alias']);
      if (!$alias) $alias = JApplication::stringURLSafe($item['title']);

      $query->update('#__maplocations_places');
      if (isset($item['title'])) $query->set($db->quoteName('title') . ' = ' . $db->Quote($item['title']));
      if (isset($item['description'])) $query->set($db->quoteName('description') . ' = ' . $db->Quote($item['description']));
      if (isset($item['status'])) $query->set($db->quoteName('status') . ' = ' . $db->Quote($item['status']));
      if (isset($item['address'])) $query->set($db->quoteName('address') . ' = ' . $db->Quote($item['address']));
      if (isset($item['latitude'])) $query->set($db->quoteName('latitude') . ' = ' . $db->Quote($item['latitude']));
      if (isset($item['longitude'])) $query->set($db->quoteName('longitude') . ' = ' . $db->Quote($item['longitude']));
      if (isset($item['params'])) $query->set($db->quoteName('params') . ' = ' . $db->Quote($item['params']));
      if (isset($item['map_id'])) $query->set($db->quoteName('map_id') . ' = ' . $db->Quote($item['map_id']));
      $query->where('id='.$db->quote($item['id']));
    } else {
      //insert
      $query->insert('#__maplocations_places');

      $query->columns(array(
        $db->quoteName('title'),
        $db->quoteName('description'),
        $db->quoteName('status'),
        $db->quoteName('address'),
        $db->quoteName('latitude'),
        $db->quoteName('longitude'),
        $db->quoteName('params'),
        $db->quoteName('map_id')
      ));

      $query->values(
        $db->Quote($item['title']) .', '.
        $db->Quote($item['description']) .', '.
        $db->Quote($item['status']) .', '.
        $db->Quote($item['address']) .', '.
        $db->Quote($item['latitude']) .', '.
        $db->Quote($item['longitude']) .', '.
        $db->Quote($item['params']) .', '.
        $db->Quote($item['map_id'])
      );
    }

    $db->setQuery((string) $query);

    try
    {
      $db->execute();
    }
    catch (RuntimeException $e)
    {
      error_log($e->getMessage());
    }

    $item_id = $db->insertid();
    echo $item_id; exit();
  }

  public function delete() {
    $app = JFactory::getApplication();
    $id = $app->input->get('id', '', 'INT');

    $db = JFactory::getDBO();
    $query = $db->getQuery(true);

    if ($id) {
      $query->delete('#__maplocations_places');
      $query->where('id='.$db->quote($id));
    }

    $db->setQuery((string) $query);

    try {
      $db->execute();
    } catch (RuntimeException $e) {
      error_log($e->getMessage());
    }
  }
}
