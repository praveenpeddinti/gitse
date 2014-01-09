<?php defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( dirname(__FILE__).'/helper.php' );
$helper = new modMapLocationsHelper();
$places = $helper->getPlaces($params);
$settings = json_decode(json_decode(JComponentHelper::getParams('com_maplocations'))->settings);
$pageParams = JFactory::getApplication()->getMenu()->getActive();


$document = Jfactory::getDocument();
JHtml::_('script', 'jui/jquery.min.js', false, true, false, false, false);
$document->addScript('http://maps.google.com/maps/api/js?v=3&sensor=false');
$document->addScript(JURI::base() . 'components/com_maplocations/assets/js/markerclustererV3.js');

require(JModuleHelper::getLayoutPath('mod_maplocations'));
?>
