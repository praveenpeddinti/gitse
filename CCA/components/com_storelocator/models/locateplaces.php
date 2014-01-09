<?php
/**
 * Locateplaces model for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * LocatePlaces Model
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesModelLocatePlaces extends JModel
{
	/**
	 * LocatePlaces data array
	 *
	 * @var array
	 */
	var $_data;
	

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildQuery()
	{
		$this->setGroupLimits();
		
		$query = ' SELECT lp.*, cat.name as category, mt.image_url as markertype, GROUP_CONCAT(map.tag_id) tag_ids, GROUP_CONCAT(DISTINCT tag.name) tags' .
			' FROM #__storelocator as lp ' .
			' LEFT JOIN #__storelocator_tag_map as map ON lp.id = map.location_id'.
			' LEFT JOIN #__storelocator_tag_map as map2 ON lp.id = map2.location_id '.
			' LEFT JOIN #__storelocator_tags as tag ON tag.id = map2.tag_id'.
			' LEFT JOIN #__storelocator_cat as cat ON lp.catid = cat.id '.
			' LEFT JOIN #__storelocator_marker_types as mt ON mt.id = cat.markerid ' .
			' GROUP BY lp.id';
error_log("---1----".$query);
		return $query;
	}

	/**
	 * Retrieves the data
	 * @return array Array of objects containing the data from the database
	 */
	function getData($categories = array(), $tags = array())
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$query = $this->_buildQuery();
			$query .= $this->_AddWhere($categories, $tags);
                        error_log("---2----".$query);
			
			$this->_data = $this->_getList( $query );
		}

		return $this->_data;
	}
	
	function _AddWhere($categories, $tags, $featstate = 0, $text_query = '', $nameSearchMode = 0)
	{	
		$db =& $this->getDBO();
		$where = array();
		
		// Published
		$where[] = 'lp.published = 1';
		
		// Published Date
		$jnow		=& JFactory::getDate();
		$now		= $jnow->toMySQL();
		$nullDate	= $this->_db->getNullDate();
		$where[] = '( lp.publish_up = '.$this->_db->Quote($nullDate).' OR lp.publish_up <= '.$this->_db->Quote($now).' )';
		$where[] = '( lp.publish_down = '.$this->_db->Quote($nullDate).' OR lp.publish_down >= '.$this->_db->Quote($now).' )';
		
		// Categories
		if( is_array($categories) && count($categories) > 0)
		{
			// clean up
			for($i=0;$i<count($categories);$i++)
				$categories[$i] = intval($categories[$i]);
				
			// make category array into a string
			$catstr = implode(', ',$categories);
			
			$where[] = "cat.id IN ($catstr)";
		}
		
		// Tags
		if( is_array($tags) && count($tags) > 0)
		{
			// clean up
			for($i=0;$i<count($tags);$i++)
				$tags[$i] = intval($tags[$i]);
                       
			// make category array into a string			
			/*$where[] = "lp.id IN (	SELECT lp.id
									FROM #__storelocator as lp 
									LEFT JOIN #__storelocator_tag_map as map_filter ON lp.id = map_filter.location_id 
									WHERE map_filter.tag_id IN (".implode(', ',$tags).") GROUP by lp.id HAVING COUNT(*) = ".count($tags).") ";
				*/					
			$where[] = "map_filter.tag_id IN (".implode(', ',$tags).")";

		}
		
		//Access Level
		$user = JFactory::getUser();
		$aid = (StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17())?max($user->getAuthorisedViewLevels()):((int) $user->get('aid', 0));
		$where[] = 'lp.access <= '.$aid;

		//Featured
		if ($featstate)
			$where[] = 'lp.featured = 1';
			
		// Text Query
		if(!empty($text_query))
		{
			$text_query = $db->quote( '%' . $db->getEscaped( $text_query, true ) . '%', false );
						
			switch($nameSearchMode)
			{
				case 0:
					$where[] = "lp.name LIKE " . $text_query;
					break;
				case 1:
					$where[] = "(lp.cust1 LIKE " . $text_query . " OR lp.cust2 LIKE " . $text_query . " OR lp.cust3 LIKE " . $text_query . " OR lp.cust4 LIKE " . $text_query . " OR lp.cust5 LIKE ". $text_query . ")";
					break;
				case 2:
					$where[] = "(lp.cust1 LIKE " . $text_query . " OR lp.cust2 LIKE " . $text_query . " OR lp.cust3 LIKE " . $text_query . " OR lp.cust4 LIKE " .
								$text_query . " OR lp.cust5 LIKE ". $text_query . " OR lp.name LIKE " . $text_query . ")"; 			
					break;
			}
		}
		
		$query = " WHERE ".implode(' AND ', $where);
						
		return $query;
	
	
	}
	
	
	function _addHaving($tags, $tagModeAND, $distance)
	{
		$having = array();
		
		// Tags
		if( $tagModeAND && is_array($tags) && count($tags) > 0)
			$having[] = "COUNT(lp.id) = " . count($tags);
			
		// Distance
		if (intval($distance) > 0)
			$having[] = "distance < " . intval($distance);
			
		$query = (!count($having))?'':" HAVING ".implode(' AND ', $having);
		return $query;
	}
	
	function getDataByLocation(	$lat, $lng, $radius, $categories = array(), $tags = array(), $map_units = 1, $max_search_results = 100, 
								$search_order = 'distance', $search_dir = 'ASC', $featstate = 0, $name_search = '', $tagModeAND = 0, $nameSearchMode = 0)
	{
            
            $this->setGroupLimits();
					
		$multiFactor = $map_units == 1 ? 3959 : 6371;
		
		// Search the rows in the table
		$query = sprintf("SELECT lp.*, 
							( %s * acos( cos( radians('%s') ) * 
							cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + 
							sin( radians('%s') ) * sin( radians( lat ) ) ) ) 
							AS distance, mt.image_url as markertype, cat.name as categories_name  
							FROM #__storelocator as lp 
							LEFT JOIN #__storelocator_cat as cat ON lp.catid = cat.id 
							LEFT JOIN #__storelocator_marker_types as mt ON mt.id = cat.markerid 
							".((count($tags))?'JOIN #__storelocator_tag_map as map_filter ON lp.id = map_filter.location_id':'')."
							%s  
							GROUP BY lp.id 
							%s 
							ORDER BY %s %s". ' LIMIT %d',
		  $multiFactor,
		  doubleval($lat),
		  doubleval($lng),
		  doubleval($lat),
		  $this->_AddWhere($categories, $tags, $featstate, $name_search, $nameSearchMode),
		  $this->_addHaving($tags, $tagModeAND, doubleval($radius)),
		  $search_order,
		  $search_dir,
		  intval($max_search_results)  
		  );
		  error_log("======query mile78====".$query);
		  $this->_results = $this->_getList( $query );
		  
		  return $this->_results;
	}
	
	function getAllDataByCat($categories = array(), $tags = array(), $map_units = 1, $max_search_results = 100, $load_order = 'lp.name', $load_dir = 'ASC', $featstate = 0, $tagModeAND = 0)
	{
	
		$this->setGroupLimits();
		
		// Search the rows in the table
		$query = "SELECT lp.*, 0 AS distance, mt.image_url as markertype, cat.name as categories_name  
					FROM #__storelocator as lp 
					LEFT JOIN #__storelocator_cat as cat ON lp.catid = cat.id 
					LEFT JOIN #__storelocator_marker_types as mt ON mt.id = cat.markerid 
					".((count($tags))?'JOIN #__storelocator_tag_map as map_filter ON lp.id = map_filter.location_id':''). 
					$this->_AddWhere($categories, $tags, $featstate) . 
					' GROUP BY lp.id '.
					$this->_addHaving($tags, $tagModeAND, 0).
					" ORDER BY $load_order $load_dir " . 
					' LIMIT '. (int)$max_search_results;
					
			//print str_replace('#_', 'joom',$query); die();	
		  
		  $this->_results = $this->_getList( $query );
		  return $this->_results;
	}
	
	function getAllDataByName($text_query, $categories = array(), $tags = array(), $map_units = 1, $max_search_results = 100, $load_order = 'lp.name', $load_dir = 'ASC', $featstate = 0, $tagModeAND = 0, $nameSearchMode = 0)
	{
		$this->setGroupLimits();
		
		// Search the rows in the table
		$query = "SELECT lp.*, 0 AS distance, mt.image_url as markertype, cat.name as categories_name  
					FROM #__storelocator as lp 
					LEFT JOIN #__storelocator_cat as cat ON lp.catid = cat.id 
					LEFT JOIN #__storelocator_marker_types as mt ON mt.id = cat.markerid 
					".((count($tags))?'JOIN #__storelocator_tag_map as map_filter ON lp.id = map_filter.location_id':'').
					$this->_AddWhere($categories, $tags, $featstate, $text_query, $nameSearchMode) .
					' GROUP BY lp.id '.
					$this->_addHaving($tags, $tagModeAND, 0) .
					" ORDER BY $load_order $load_dir"  .
					" LIMIT ". (int)$max_search_results;
					
			//print str_replace('#_', 'jos',$query); die();
		  		  
		  $this->_results = $this->_getList( $query );
		  
		  return $this->_results;
	}
	
	function getCategories()
	{
		$query = "SELECT id as value, name as text FROM #__storelocator_cat ORDER BY text Asc";
		return $this->_getList( $query );
	}
	
	function getTags()
	{
		$query = "SELECT tag.id as value, tag.name as text, mt.image_url as marker_url, mtf.image_url as feature_marker_url "
				."FROM #__storelocator_tags as tag "
				."LEFT JOIN #__storelocator_marker_types as mt ON mt.id = tag.marker_id "
				."LEFT JOIN #__storelocator_marker_types as mtf ON mtf.id = tag.feature_marker_id "
				."ORDER BY text Asc";
		 
		return $this->_getList( $query );
	}
	
	
	function getTagMap()
	{
		$query = "	SELECT location_id, GROUP_CONCAT(DISTINCT tag.name SEPARATOR ', ') tags
					FROM #__storelocator_tag_map as map_filter
					LEFT JOIN #__storelocator_tags as tag ON tag.id = map_filter.tag_id 
					GROUP BY location_id ";
		 
		$maps = $this->_getList( $query );
		
		$tagmap = array();
		
		if ($maps)
			foreach($maps as $map)
				$tagmap[$map->location_id] = $map->tags;
		
		return $tagmap;
		
	}
	
	function setGroupLimits()
	{
		$db =& $this->getDBO();
		$db->setQuery('SET SESSION group_concat_max_len=15000');
		$db->query();	
	}
	
	function logSearch( $search_limit, $search_limit_period, $center_lat, $center_lng, $search_data )
	{
		$db =& $this->getDBO();
		$logCount = 0;
		$limited = false;
		
		// Check count of searches by IP within Search Limit Period
		if ($search_limit>0)
		{
			$period = strtotime($search_limit_period);
			
			$logquery = sprintf(	"SELECT COUNT(*) FROM #__storelocator_log_search WHERE `limited` = 0 AND `ipaddress` = '%s' AND UNIX_TIMESTAMP(`search_time`) > '%s'",
								$_SERVER['REMOTE_ADDR'],
								$period
								);
			$db->setQuery($logquery);								
			$logCount = $db->loadResult($logquery);
						
			if ($logCount >= $search_limit)
				$limited = true;
		}
		
		$search_data['log_count'] = $logCount;
		
		$loggingq = sprintf(	"INSERT INTO #__storelocator_log_search (`ipaddress`, `query`, `lat`, `long`, `limited`) VALUES ( '%s', %s, %s, %s, %d  )",
								$_SERVER['REMOTE_ADDR'],
								$this->_db->Quote(json_encode($search_data)),
								doubleval($center_lat),
								doubleval($center_lng),
								$limited?1:0);
								
		$db->setQuery( $loggingq );
		$db->query();
		
		return $limited;		
	}
	
		
	function finalize()
	{
		echo base64_decode("PCEtLSBKb29tbGEhIFN0b3JlIExvY2F0b3IgdjEuOCsgLSBDb3B5cmlnaHQgMjAxMiBTeXNnZW4gTWVkaWEgTExDIC0gaHR0cDovL3d3dy5zeXNnZW5tZWRpYS5jb20gLS0+");
	}

}