<?php

/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 JOOCODE. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');

class MapLocationsControllerMaps extends JControllerAdmin
{
  public function getModel($name = 'Maps', $prefix = 'MapLocationsModel')
  {
    $model = parent::getModel($name, $prefix, array('ignore_request' => true));
    return $model;
  }
}
