<?php
/**
 * LocatePlaces Model for Store Locator Component
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
	
	var $_cats;
	
	/**
	 * total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;
	
	function __construct()
	{
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		
		parent::__construct();
			
		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	 
	}
	
	function _buildContentOrderBy()
	{		
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');

		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'lp.id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );

		if ($filter_order == 'lp.id'){
			$orderby 	= ' ORDER BY category, lp.id '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , category, lp.id ';
		}

		return $orderby;
	}

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildQuery()
	{		
		if( StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()  )
			$query = 'SELECT lp.*, cat.name as category, g.title as groupname '
			. ' FROM #__storelocator as lp'
			. ' LEFT JOIN #__storelocator_cat as cat ON lp.catid = cat.id '
			. ' LEFT JOIN #__viewlevels AS g ON g.id = lp.access ';
		else
			$query = 'SELECT lp.*, cat.name as category, g.name as groupname '
			. ' FROM #__storelocator as lp'
			. ' LEFT JOIN #__storelocator_cat as cat ON lp.catid = cat.id '
			. ' LEFT JOIN #__groups AS g ON g.id = lp.access ';

		return $query;
	}

	/**
	 * Retrieves the location data
	 * @return array Array of objects containing the data from the database
	 */
	function getData()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$query = $this->_buildQuery();
			
			$this->_data = $this->_getList( $query.$this->_buildContentWhere().' GROUP BY lp.id '.$this->_buildContentOrderBy(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_data;
	}
	
	/**
	 * Method to get the total number of location items
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$results = $this->_getList( $query.$this->_buildContentWhere().' GROUP BY lp.id '.$this->_buildContentOrderBy() );
			
			if(!$results)
				$this->_total = 0;
			else
				$this->_total = count($results); 
		}

		return $this->_total;
	}
	
	/**
	 * Method to get a pagination object for the locations
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	
	function _buildContentWhere()
	{
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$db					=& JFactory::getDBO();
		$filter_featured	= $mainframe->getUserStateFromRequest( $option.'filter_featured',	'filter_featured',		'',		'word' );
		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state',		'filter_state',		'',				'word' );
		$filter_catid		= $mainframe->getUserStateFromRequest( $option.'filter_catid',		'filter_catid',		0,				'int' );
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );

		$where = array();

		if ($filter_catid > 0) {
			$where[] = 'lp.catid = '.(int) $filter_catid;
		}
		if ($search) {
			$where[] = '(LOWER(lp.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).
			' OR LOWER(lp.address) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false ).')';
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 'lp.published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'lp.published = 0';
			}
		}
		
		if ( $filter_featured ) {
			if ( $filter_featured == 'F' ) {
				$where[] = 'lp.featured = 1';
			} else if ($filter_featured == 'U' ) {
				$where[] = 'lp.featured = 0';
			}
		}

		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

		return $where;
	}

	
	function getDataByCat($catids = array())
	{
		$query = $this->_buildQuery();
		$addWhere = ' WHERE cat.id IN ('.implode(',',$catids).')';
		return $this->_getList( $query.$addWhere.' GROUP BY lp.id ' );
	}
	
	function getNonCodedLocations()
	{
		$query = $this->_buildQuery();
		$addWhere = ' WHERE lp.lat IS NULL or lp.lng IS NULL or lp.lat = 0 or lp.lng = 0';
		return $this->_getList( $query.$addWhere.' GROUP BY lp.id ' );
	}
	
	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildCatsQuery()
	{
		$query = ' SELECT * FROM #__storelocator_cat ORDER BY name DESC ';

		return $query;
	}

	/**
	 * Retrieves the data
	 * @return array Array of objects containing the data from the database
	 */
	function getCategories()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_cats ))
		{
			$query = $this->_buildCatsQuery();
			$this->_cats = $this->_getList( $query );
		}

		return $this->_cats;
	}
	
	function getTagMap()
	{
		$query = "	SELECT location_id, GROUP_CONCAT(DISTINCT tag.name SEPARATOR ', ') tags
					FROM joom_storelocator_tag_map as map_filter
					LEFT JOIN joom_storelocator_tags as tag ON tag.id = map_filter.tag_id 
					GROUP BY location_id ";
		 
		$maps = $this->_getList( $query );
		
		$tagmap = array();
		
		foreach($maps as $map)
			$tagmap[$map->location_id] = $map->tags;
		
		return $tagmap;
		
	}
	
		
}