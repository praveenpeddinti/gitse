<?php
/**
 * @package   com_maplocations
 * @copyright Copyright (C) 2013 JOOCODE. All rights reserved.
 * @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link      http://www.joocode.com
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class MapLocationsViewPlaces extends JViewLegacy
{
  function display($tpl = null)
  {
    $this->msg = $this->get('Msg');
    $this->settings = json_decode(json_decode(JComponentHelper::getParams('com_maplocations'))->settings);
    $this->pageParams = JFactory::getApplication()->getMenu()->getActive();

    $document = Jfactory::getDocument();
    JHtml::_('script', 'jui/jquery.min.js', false, true, false, false, false);
    $document->addScript('http://maps.google.com/maps/api/js?v=3&sensor=false');
    $document->addScript(JURI::base() . 'components/com_maplocations/assets/js/markerclustererV3.js');
    $document->addStyleSheet(JURI::root().'components/com_maplocations/assets/css/style.css');

    $model = $this->getModel();

    if ($this->pageParams) {
      $this->places = $model->getItems($this->pageParams->params->get('mapId'));
    } else{
      $this->places = $model->getItems();
    }

    // Check for errors.
    if (count($errors = $this->get('Errors')))
    {
      JLog::add($errors, JLog::ERROR);
      //throw new Exception($errors);
      return false;
    }

    // Display the view
    parent::display($tpl);
  }
}
