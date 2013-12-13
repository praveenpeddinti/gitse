<?php
/**
 * Categories Model for Store Locator Component
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
 * Categories Model
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesModelGeocode extends JModel
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
		$query = ' SELECT lp.*, cat.name as category '
			. ' FROM #__storelocator as lp'.
			' LEFT JOIN #__storelocator_cat as cat ON lp.catid = cat.id '
		;

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
			$this->_data = $this->_getList( $query );
		}

		return $this->_data;
	}
	
	function getNonCodedLocations()
	{
		$query = $this->_buildQuery();
		$addWhere = 'WHERE lp.lat IS NULL or lp.lng IS NULL or lp.lat = 0 or lp.lng = 0';
		return $this->_getList( $query.$addWhere );
	}
	
}