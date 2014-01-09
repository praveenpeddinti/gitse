<?php
/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 joocode. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

$document = JFactory::getDocument();

if (JVersion::isCompatible('3.0')) {
  JHtml::_('jquery.framework');
} else {
  $document->addScript(JURI::root().'media/com_maplocations/jui/js/jquery.min.js');
  $document->addScript(JURI::root().'media/com_maplocations/jui/js/jquery-noconflict.js');
  $document->addScript(JURI::root().'media/com_maplocations/jui/js/bootstrap.js');
  $document->addStyleSheet(JURI::root().'media/com_maplocations/jui/css/bootstrap.css');
}

$app = JFactory::getApplication();
$app->JComponentTitle = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/handlebars.runtime.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/ember.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/ember-rest.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/bootstrap-tooltip.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/ember-console-utils.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/redactor.min.js');
  $document->addScript('http://maps.google.com/maps/api/js?sensor=true');
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/gmaps.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/lib/jquery-ui.min.js');

  $document->addScript(JURI::root().'media/com_maplocations/js/admin/templates.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/app.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/router.js');

  $document->addScript(JURI::root().'media/com_maplocations/js/admin/models/common-model.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/models/setting.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/models/map.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/models/place.js');

  $document->addScript(JURI::root().'media/com_maplocations/js/admin/controllers/common.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/controllers/settings.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/controllers/maps.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/controllers/places.js');

  $document->addScript(JURI::root().'media/com_maplocations/js/admin/helpers/printFeaturedIcon.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/helpers/printStatusIcon.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/helpers/deferredHelper.js');

  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/common.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/common__form.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/common__index.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/map__form.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/map__edit.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/map__new.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/maps__index.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/maps__index__single-item.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/place__form.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/place__edit.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/place__new.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/places__index.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/places__index__single-item.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/settings__clusters.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/settings__controls.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/settings__general.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/settings__index.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/settings__markers.js');
  $document->addScript(JURI::root().'media/com_maplocations/js/admin/views/settings__zoom.js');

  $document->addStyleSheet(JURI::root().'media/com_maplocations/css/admin/main.css');
  if (!JVersion::isCompatible('3.0')) {
    $document->addStyleSheet(JURI::root().'media/com_maplocations/css/admin/joomla-2.5.css');
    $document->addStyleSheet(JURI::root().'media/com_maplocations/jui/css/icomoon.css');
  }

  $document->addStyleSheet(JURI::root().'media/com_maplocations/css/admin/jquery-ui.css');
  $document->addStyleSheet(JURI::root().'media/com_maplocations/css/redactor.css');
  JToolBarHelper::title('', 'maplocations');
}

$controller = JControllerLegacy::getInstance('MapLocations');
$task = JFactory::getApplication()->input->getCmd('task');
if (!JVersion::isCompatible('3.0')) {
  if (strpos($task, '.') !== false) {
    list($type, $task) = explode('.', $task);
  }
}

$controller->execute($task);
$controller->redirect();
