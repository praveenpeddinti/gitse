<?php
/**
 * LocatePlace Model for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * LocatePlace Model
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesModelLocatePlace extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the location identifier
	 *
	 * @access	public
	 * @param	int Location identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}
	
	/**
	 * Method to get the location identifier
	 *
	 * @access	public
	 * @return	int
	 */
	function getId()
	{
		return $this->_id;
	}

	/**
	 * Method to get a location
	 * @return object with data
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__storelocator WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
			
			if ($this->_data)
			{	
				$query = ' SELECT tag_id FROM #__storelocator_tag_map WHERE location_id = '.$this->_id;
				$this->_db->setQuery( $query );
				$this->_data->tags = $this->_db->loadResultArray();
			}
			
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = null;
			$this->_data->address = null;
			$this->_data->lat = null;
			$this->_data->lng = null;
			$this->_data->catid = 0;
			$this->_data->phone = null;
			$this->_data->website = null;	
			
			$this->_data->fulladdress = null;
			$this->_data->facebook = null;
			$this->_data->twitter = null;
			$this->_data->email = null;
			$this->_data->cust1 = null;
			$this->_data->cust2 = null;
			$this->_data->cust3 = null;
			$this->_data->cust4 = null;
			$this->_data->cust5 = null;
			$this->_data->featured = 0;
			$this->_data->access = 0;
			$this->_data->published = 1;
			$this->_data->publish_up = null;
			$this->_data->publish_down = null;
			$this->_data->tags = array();

		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store($data=NULL)
	{	
		$row =& $this->getTable();
		
		if ($data==NULL)
		{
			$data = JRequest::get( 'post' );
  			$data['fulladdress']=JRequest::getVar( 'fulladdress', '', 'post', 'string', JREQUEST_ALLOWHTML );
		}
		
		// Bind the form fields to the location table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the location record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		
		if (is_array($data) )
		{
			// Clear Tag Table (None selected)
			$clearquery = "DELETE FROM `#__storelocator_tag_map` WHERE `location_id` = " . $row->id;
			$this->_db->setQuery($clearquery);
			$this->_db->query();
		}
		
		if (is_array($data) && isset($data['tags'])) // Update Tag Table
		{
			foreach($data['tags'] as $tag)
			{
				$insertQuery = "INSERT INTO `#__storelocator_tag_map` (`tag_id`,`location_id`) VALUES (".intval($tag)."," . $row->id .")";
				$this->_db->setQuery($insertQuery);
				$this->_db->query();					
			}			
		}
		
		$this->_id = $row->id;

		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (count( $cids )) {
			$query = ' DELETE FROM #__storelocator WHERE id IN (' . implode(',',$cids) . ')';
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError( $row->getErrorMsg() );
				return false;
			}
			
			$tagQuery = 'DELETE FROM `#__storelocator_tag_map` WHERE location_id IN (' . implode(',',$cids) . ')';
			$this->_db->setQuery($tagQuery);
			$this->_db->query();
	
		}
		return true;
	}

}