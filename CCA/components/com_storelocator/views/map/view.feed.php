<?php
/**
 * Store Locator XML feed view
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

jimport( 'joomla.application.component.view');

/**
 * XML StoreLocator class for the Store Locator Component
 *
 * @package		SysgenMedia.StoreLocator
 * @subpackage	Components
 */
class LocatePlacesViewMap extends JView
{

	function display()
	{	
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$model	= &$this->getModel( 'locateplaces' );


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
		
		// Get System / Menu Params
		$max_search_results = max($params->get('max_search_results', 100), 1);
		$map_units = $params->get( 'map_units', 1 );
		$load_order = $params->get('load_order', 'lp.name');
		$search_order = $params->get('search_order', 'distance');
		$load_dir = $params->get('load_dir', 'ASC');
		$search_dir = $params->get('search_dir', 'ASC');
		$tagModeAND = (int)$params->get('tagmode_and', 0);
		$nameSearchMode  = (int)$params->get('namesearchmode', 0);
						
		// Get parameters from URL
		$searchall = 	(bool)JRequest::getVar('searchall', 0, 'get');
		$center_lat = 	JRequest::getVar('lat', '0', 'get');
		$center_lng = 	JRequest::getVar('lng', '0', 'get');
		$radius = 		JRequest::getVar('radius', '25', 'get');
		$catid = 		JRequest::getVar('catid', '-1', 'get');
		$tagid = 		JRequest::getVar('tagid', '-1', 'get');
		$featstate = 	JRequest::getVar('featstate', '0', 'get');
		$query = 		JRequest::getVar('query', '', 'get');
		$name_search =	JRequest::getVar('name_search', '', 'get');
		
		if ($tagid == -1)
			$tagModeAND = 0;
		

		// Get Searchable Categories
		$catReq = array();
		
		if (!$params->get('show_all', 1))
		{
			if ($allowcats = $params->get( 'categories', 0 ))
			{
				if (is_array($allowcats))	
					$catReq = $allowcats;
				else
					$catReq[] = $allowcats;
			}
		}

		// Cat Search Filter
		if (is_numeric($catid) && $catid > 0)
			$categories = array($catid);
		else if (stripos($catid,'_')!==false)
			$categories = explode('_',$catid);
		else
			$categories = $catReq;
			
			
			
			
		// Tag Filter
		$tagReq = array();		
		if (!$params->get('show_all_tags', 1))
		{
			if ($tagallow = $params->get( 'tags', 0 ))
			{
				if (is_array($tagallow))	
					$tagReq = $tagallow;
				else
					$tagReq[] = $tagallow;
			}
		}
		
			
		// Tag Search Filter
		if (is_numeric($tagid) && $tagid > 0)
			$tags = array($tagid);
		else if (stripos($tagid,'_')!==false)
			$tags = explode('_',$tagid);
		else
			$tags = $tagReq;
		
		
		// Array Prep
		$tagData = array();
		if ($tagsdat = $model->getTags())
			foreach($tagsdat as $tag)
				$tagData[$tag->text] = $tag;
		
			
		
		
		// Load Tag Map
		$tagMap = $model->getTagMap();
		
		
		// If Logging Enabled, Save Search to Log
		$searchlog_enabled = (int)$params->get('searchlog_enabled', 0);
		$search_limit = (int)$params->get('search_limit', 0);
		$search_limit_period = $params->get('search_limit_period', '-1 Day');
		$limited = false;
		
		if($searchlog_enabled && !$searchall && $search_limit > 0)
		{
			$limited = $model->logSearch(  	$search_limit, 
											$search_limit_period, 
											$center_lat, 
											$center_lng,
											array( 	'center_lat' => $center_lat, 
													'center_lng' => $center_lng, 
													'radius' => $radius, 
													'categories' => $categories, 
													'tags' => $tags, 
													'featstate' => $featstate, 
													'name_search' => $name_search));	
		}
		
		
		
		if(!$limited)
		{
			if($searchall)
				$results = &$model->getAllDataByCat($categories, $tags, $map_units, $max_search_results, $load_order, $load_dir, $featstate, $tagModeAND);
			else if (!empty($name_search) && $center_lat == '0' && $center_lng == '0')
				$results = &$model->getAllDataByName($name_search, $categories, $tags, $map_units, $max_search_results, $search_order, $search_dir, $featstate, $tagModeAND, $nameSearchMode);
			else
				$results = &$model->getDataByLocation($center_lat, $center_lng, $radius, $categories, $tags, $map_units, $max_search_results, $search_order, $search_dir, $featstate, $name_search, $tagModeAND, $nameSearchMode);
		} 
				
		header( "Content-type: text/xml; charset=utf-8" );
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
				
		echo "\n\t<markers>";
		
		if ($limited)
			echo "\n\t<limited>1</limited>";				
		else
			echo "\n\t\t<limited>0</limited>";
		
		if( count( $results ) ) {
			
			foreach( $results as $item ) {
				
				$markertype = $item->markertype;
				$marker_pref = $params->get('marker_pref', 'tags');
				
				if ($marker_pref == 'tags' && !empty($tagMap[$item->id]) )
				{
					$item_tags = explode(',', $tagMap[$item->id]);
					
					if (count($tags)) // Searched by Tags
					{
							
						foreach($item_tags as $tag)
						{
							if (isset($tagData[$tag]) && in_array($tagData[$tag]->value,$tags))
							{
								$markertype = $item->featured?$tagData[$tag]->feature_marker_url:$tagData[$tag]->marker_url;	
							}
						}
					} else {  // Not Searching by tags, but stil lwant first tag icon
					
						$markertype = $item->featured?$tagData[$item_tags[0]]->feature_marker_url:$tagData[$item_tags[0]]->marker_url;
					}
				}
							
				echo "\n\t\t<marker>";
				
				echo "\n\t\t\t<name>".$this->XMLClean($item->name)."</name>";
				echo "\n\t\t\t<category>".$this->XMLClean($item->categories_name)."</category>";
				echo "\n\t\t\t<markertype>".$this->XMLClean( $markertype )."</markertype>";
				echo "\n\t\t\t<featured>".($item->featured?'true':'false')."</featured>";


				echo "\n\t\t\t<address>".$this->XMLClean($item->address)."</address>";
				echo "\n\t\t\t<lat>".doubleval($item->lat)."</lat>";
				echo "\n\t\t\t<lng>".doubleval($item->lng)."</lng>";
				echo "\n\t\t\t<distance>".doubleval($item->distance)."</distance>";
				
				echo "\n\t\t\t<fulladdress><![CDATA[".$item->fulladdress."]]></fulladdress>";
				echo "\n\t\t\t<phone>".$this->XMLClean($item->phone)."</phone>";
				echo "\n\t\t\t<url>".$this->XMLClean($item->website)."</url>";
				echo "\n\t\t\t<email>".$this->XMLClean($item->email)."</email>";



				echo "\n\t\t\t<facebook>".$this->XMLClean($item->facebook)."</facebook>";
				echo "\n\t\t\t<twitter>".$this->XMLClean($item->twitter)."</twitter>";
				
				$tagline = ( isset($tagMap) && isset($tagMap[$item->id]) )?$tagMap[$item->id]:'';
								
				echo "\n\t\t\t<tags><![CDATA[".$this->XMLClean($tagline)."]]></tags>";
				
				echo "\n\t\t\t<custom1 name=\"".$params->get( 'cust1_label' )."\"><![CDATA[".$this->XMLClean($item->cust1)."]]></custom1>";
				echo "\n\t\t\t<custom2 name=\"".$params->get( 'cust2_label' )."\"><![CDATA[".$this->XMLClean($item->cust2)."]]></custom2>";
				echo "\n\t\t\t<custom3 name=\"".$params->get( 'cust3_label' )."\"><![CDATA[".$this->XMLClean($item->cust3)."]]></custom3>";
				echo "\n\t\t\t<custom4 name=\"".$params->get( 'cust4_label' )."\"><![CDATA[".$this->XMLClean($item->cust4)."]]></custom4>";
				echo "\n\t\t\t<custom5 name=\"".$params->get( 'cust5_label' )."\"><![CDATA[".$this->XMLClean($item->cust5)."]]></custom5>";
			
	
				
				echo "\n\t\t</marker>";
			}
		}

		echo "\n\t</markers>";

		exit;
	}
	
	function XMLClean($strin) 
	{
        $strout = null;

		for ($i = 0; $i < strlen($strin); $i++) {
				$ord = ord($strin[$i]);

				if (($ord > 0 && $ord < 32)) {
						$strout .= "&amp;#{$ord};";
				}
				else {
						switch ($strin[$i]) {
								case '<':
										$strout .= '&lt;';
										break;
								case '>':
										$strout .= '&gt;';
										break;
								case '&':
										$strout .= '&amp;';
										break;
								case '"':
										$strout .= '&quot;';
										break;
								default:
										$strout .= $strin[$i];
						}
				}
		}

		return $strout;
	}
}
?>
