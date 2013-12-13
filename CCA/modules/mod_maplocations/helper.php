<?php defined( '_JEXEC' ) or die( 'Restricted access' );

$com_path = JPATH_SITE.'/components/com_maplocations/';
JModelLegacy::addIncludePath($com_path . '/models', 'MapLocationsModel');

class modMapLocationsHelper
{
  function getPlaces($params) {
    $places = JModelLegacy::getInstance('Places', 'MapLocationsModel', array());;
    $places = $places->getItems($params->get('mapId'));
    return $places;
  }
}
?>
