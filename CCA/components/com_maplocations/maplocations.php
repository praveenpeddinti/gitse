<?php

/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 JOOCODE. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('MapLocations');

if (!JFactory::getApplication()->input->getCmd('view')) {
  JFactory::getApplication()->input->set('view', 'places');
}

$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();
