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
class LocatePlacesModelTags extends JModel
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
		$query =  ' SELECT tag.*, mt.name as marker_name, mt.image_url as marker_url, mtf.name as feature_marker_name, mtf.image_url as feature_marker_url '
				. ' FROM #__storelocator_tags as tag '
				. ' LEFT JOIN #__storelocator_marker_types as mt ON tag.marker_id = mt.id'
				. ' LEFT JOIN #__storelocator_marker_types as mtf ON tag.feature_marker_id = mtf.id';

		return $query;
	}

	/**
	 * Retrieves the data
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
}