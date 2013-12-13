<?php
/**
 * Store Locator default view
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

jimport( 'joomla.application.component.view');

/**
 * HTML StoreLocator class for the Store Locator Component
 *
 * @package		SysgenMedia.StoreLocator
 * @subpackage	Components
 */
class LocatePlacesViewMap extends JView
{
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option'); 

		
		if(!(StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()))
			$params = &JComponentHelper::getParams( 'com_storelocator' );
		else
		{
			$app = JFactory::getApplication('site');
			$params =  & $app->getParams('com_storelocator');
		}
		
		
		// Get the parameters of the active menu item
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menus = &JSite::getMenu();
			$menu    = $menus->getActive();
			$menuparams = $menus->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
		
		// Optional Key
		$googleKey = $params->get( 'google_maps_v3_api_key' );
		
		if (empty($googleKey) )
		{
			JHTML::script('maps/api/js?v=3.9&amp;sensor=false', 'https://maps.googleapis.com/'); // Load v3 API
		} else {
			JHTML::script('maps/api/js?v=3.9&amp;sensor=false&amp;key='.$googleKey, 'https://maps.googleapis.com/'); // Load v3 API with Key
	
		}
		
		// Implement Cluster Scripts
		$cluster_method = $params->get( 'map_cluster_method', 0 );
		
		if ( $cluster_method == 'MarkerCluster')
			JHTML::script('markercluster.min.js', 'components/com_storelocator/assets/'); // Load Google MarkerClusterPlus
			
		if ( $cluster_method == 'Spiderfier')
			JHTML::script('ows.min.js', 'components/com_storelocator/assets/'); // Spider Script
		
		
		$catReq = array();
		
		if (!$params->get('show_all', 1))
		{
			if ($catid = $params->get( 'categories', 0 ))
				if (is_array($catid))	
					$catReq = $catid;
				else
					$catReq[] = $catid;
		}

		$categories = implode('-', $catReq);
	
		//gather categories
		$model	= &$this->getModel( 'locateplaces' );
		
		$catResult = $model->getCategories();
		$filterCats = array();	

		// Filter out non existant cats only if requesting cats.. Bug Fix for no menu items
		if (!$params->get('show_all', 1))
		{
			foreach($catResult as $obj)
				if(array_search($obj->value,$catReq) !== false)
					$filterCats[] = $obj;
			
		} else {
			$filterCats = $catResult;
		}

		
		$mod_cat = JRequest::getVar('catid', '-1', 'post','INT');
		
		if ((bool)$params->get('cat_mode', 1))
		{
			array_unshift($filterCats, (object)array('value'=>-1,'text'=>JText::_('ALL_CATEGORIES')));
			$catsearchHTML = JHTML::_('select.genericlist',   $filterCats, 'catid', 'class="inputbox" size="1" onchange="searchLocations()"', 'value', 'text', $mod_cat );
		}
		else
		{
			$catsearchHTML = '';
			foreach($filterCats as $obj)
				$catsearchHTML .= "<input type=\"checkbox\" name=\"catid\" value=\"$obj->value\" ".(($mod_cat == -1 || $mod_cat == $obj->value)?"checked=\"checked\"":"")." id=\"catid_$obj->value\" onchange=\"searchLocations()\" /> <label for=\"catid_$obj->value\">$obj->text</label> &nbsp;"; 	
			
		}
		
		
		
		
		// Tag Filter
		$tagReq = array();
		$filterTags = array();
		$tagResult = $model->getTags();		
		
		
		if (!$params->get('show_all_tags', 1))
		{
			if ($tagid = $params->get( 'tags', 0 ))
			{
				if (is_array($tagid))	
					$tagReq = $tagid;
				else
					$tagReq[] = $tagid;
			}
					
			$tags = implode('-', $tagReq);
			
			// Filter out non existant tags only if requesting tags.. Bug Fix for no menu items

			foreach($tagResult as $obj)
				if(array_search($obj->value,$tagReq) !== false)
					$filterTags[] = $obj;
					
		} else {
			$filterTags = $tagResult;
		}
		
		
		// Decide on Display Options
		$tagsearchHTML = '';
		$tagmode = intval($params->get('tag_mode', 2));
		
		if ($tagmode == 1)
		{
			array_unshift($tags, (object)array('value'=>-1,'text'=>JText::_('ALL_TAGS')));
			$tagsearchHTML = JHTML::_('select.genericlist',   $filterTags, 'tagid', 'class="inputbox" size="1" onchange="searchLocations()" ', 'value', 'text');
		}
		else if ($tagmode == 2)
		{
			$tagsearchHTML = "<ul class=\"sl_tags\">\n";
				foreach($filterTags as $obj)
								$tagsearchHTML .= "<li><input type=\"checkbox\" name=\"tagid\" value=\"$obj->value\" id=\"tagid_$obj->value\" onchange=\"searchLocations()\" /> <label for=\"tagid_$obj->value\">$obj->text</label></li>\n";
								
			$tagsearchHTML .= "</ul>\n"; 	

		}
	
		
		

		// Featured Filter		
		$featstate = array();
		$featstate[] = (object)array('value'=>0,'text'=>JText::_('ALL_LOCATIONS'));
		$featstate[] = (object)array('value'=>1,'text'=>JText::_('ONLY_FEATURED'));
		
		$featstateHTML = JHTML::_('select.genericlist',   $featstate, 'featstate', 'class="inputbox" size="1" onchange="searchLocations()" ', 'value', 'text', (bool)JRequest::getVar('featstate', 0, 'post','BOOLEAN'));

				
		// Module Support
		$addressInput = JRequest::getVar('mod_addressInput', '', 'post');
		$this->assignRef('addressInput',		$addressInput);
		
		$name_search = JRequest::getVar('mod_name_search', '', 'post');
		$this->assignRef('name_search',		$name_search);
		
		$radiusSelect = JRequest::getVar('radiusselect', $params->get( 'default_radius', '25'), 'post','INT');
		$this->assignRef('radiusSelect',		$radiusSelect);
		
		$isModSearch = (bool)JRequest::getVar('mod_storelocator_search', 0, 'post','BOOLEAN');  
		$this->assignRef('isModSearch',			$isModSearch);
		
		
		// Gather Needed Parameters
		
		$this->assignRef('include_mootools',	$params->get( 'include_mootools', 1 ));
		$this->assignRef('include_css',			$params->get( 'include_css', 1 ));
		$this->assignRef('fix_jquery',			$params->get( 'fix_jquery', 0 ));		
		$this->assignRef('categories',			$categories);
		$this->assignRef('map_width',			$params->get( 'map_width', 400 ));
		$this->assignRef('map_height',			$params->get( 'map_height', 400 ));
		$this->assignRef('search_enabled',		$params->get( 'search_enabled', 1 ));
		$this->assignRef('list_enabled',		$params->get( 'list_enabled', 1 ));
		$this->assignRef('hide_list_onload',	$params->get( 'hide_list_onload', 0 ));
	
		$this->assignRef('catsearch_enabled',	$params->get( 'catsearch_enabled', 1 ));
		$this->assignRef('catsearch',			$catsearchHTML);
		
		$this->assignRef('tagsearch_enabled',	$tagmode);
		$this->assignRef('tagsearch',			$tagsearchHTML);
		
		$this->assignRef('featsearch_enabled',	$params->get( 'featsearch_enabled', 1 ));
		$this->assignRef('featsearch',			$featstateHTML);
		
		$this->assignRef('map_units',	 		$params->get( 'map_units', 1 ));
		
		// 1.5 - Additions
		$radius_list = explode(',',$params->get( 'radius_list', "25,50,100"));
		$this->assignRef('radius_list',			$radius_list);
		$this->assignRef('menuitemid',			$menuitemid);
		
		$this->assignRef('params' ,	 $params);
		
		parent::display($tpl);
		
	}
}
?>
