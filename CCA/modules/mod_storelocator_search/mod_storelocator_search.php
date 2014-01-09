<?php
/**
 * Store Locator Search Module for Store Locator Component
 * 
 * @package    SysgenMedia Store Locator Search Module
 * @subpackage Modules
 * @copyright	Copyright (c)2010 Sysgen Media LLC. All Rights Reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * Visit unmp3.com for more details about this program.
 */
defined('_JEXEC') or die('Direct Access is not allowed');

global $mainframe;

if (!file_exists(JPATH_SITE.'/administrator/components/com_storelocator/')) {
	echo "<div style=\"border:1px solid #c30;color:#c30;margin: 0 0 5px 0;padding: 5px;font-weight: bold;text-align:left;text-align:center;\">The Store Locator component is not installed, you can not use this module.</div>"; return;
}

// Module Params
$mod_sl_itemid 	    	= (int)$params->get( 'mod_sl_itemid', '0');
$search_text 	    	= $params->get( 'search_text', null);
$search_text_before 	= $params->get( 'search_text_before', null);
$search_text_after 		= $params->get( 'search_text_after', null);

$catsearch_enabled 		= $params->get( 'catsearch_enabled', 0);
$featsearch_enabled 	= $params->get( 'featsearch_enabled', 0);


// 1.5 Use Component Parameters
$com_params = &JComponentHelper::getParams( 'com_storelocator' );
$radius_list 		= explode(',',$com_params->get( 'radius_list', "25,50,100"));
$default_radius 	= $com_params->get( 'default_radius', 25);
$map_units			= (int)$com_params->get( 'map_units', 1);


//gather categories
$db = JFactory::getDBO();

$query = "SELECT id as value, name as text FROM #__storelocator_cat ORDER BY text Asc";
$db->setQuery($query);
$catResult = $db->loadAssocList();

array_unshift($catResult, (object)array('value'=>-1,'text'=>JText::_('ALL_CATEGORIES')));
$catsearch = JHTML::_('select.genericlist',   $catResult, 'catid', 'class="inputbox" size="1"', 'value', 'text');

// Feature Filter
$featstate = array();
$featstate[] = (object)array('value'=>0,'text'=>JText::_('ALL_LOCATIONS'));
$featstate[] = (object)array('value'=>1,'text'=>JText::_('ONLY_FEATURED'));
$featsearch = JHTML::_('select.genericlist',   $featstate, 'featstate', 'class="inputbox" size="1"', 'value', 'text', 0);


if ($mod_sl_itemid == 0) {
	//$mod_sl_itemid = generateValidItemid();
}

if ( empty($search_text) || $search_text == '' || !isset($search_text) ) {
	$search_text = "Search Locations...";
} 

if ( empty($search_text_before) || $search_text_before == '' || !isset($search_text_before) )
	$search_text_before = '';
else
	$search_text_before = $search_text_before.'<br />';
	
if ( empty($search_text_after) || $search_text_after == '' || !isset($search_text_after) )
	$search_text_after = '';
else
	$search_text_after = '<br />'.$search_text_after;
?>
<div id="sl_search">
<?php echo $search_text_before?>
<form action="<?php echo JRoute::_('index.php?option=com_storelocator&view=map&Itemid='.$mod_sl_itemid); ?>" id="sl_search" method="post">
  <strong><?php echo JText::_( 'ADDRESS' ); ?>:</strong>
  <input type="text" id="sl_search_address" name="mod_addressInput" value="<?php echo $search_text?>" onfocus="if(this.value=='<?php echo $search_text?>')this.value=''" onblur="if(this.value=='')this.value='<?php echo $search_text?>'" />
  <br /><strong><?php echo JText::_( 'RADIUS' ); ?>: &nbsp; </strong>
  <select id="sl_search_radiusSelect" name="radiusselect">
      	<?php
			foreach( $radius_list as $radius )
			printf("<option value=\"%d\" %s>%d %s</option>",
					$radius,
					($default_radius==$radius)?'selected':'',
					$radius,
		 			($map_units?JText::_( 'MILES' ):JText::_( 'KILOMETERS' ))
					);
		?>
      </select><br />
      
       <?php if($featsearch_enabled) echo '<strong>'.JText::_('FEATURED').':</strong> '. $featsearch . '<br />'; ?>
       <?php if($catsearch_enabled) : ?>
           <strong><?php echo JText::_('CATEGORY'); ?>:</strong> <?php echo $catsearch; ?><br />
       <?php endif; ?>
      
  <input type="submit" class="buttonlink_small" value="<?php echo JText::_( 'SEARCH' ); ?>"/>
  <input type="hidden" name="mod_storelocator_search" value="true" />
<?php echo $search_text_after?>
</form>
</div>

