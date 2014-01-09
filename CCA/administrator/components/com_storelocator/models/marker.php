<?php
/**
 * Category Model for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');
jimport('joomla.client.helper');
jimport('joomla.filesystem.file');

/**
 * Marker Model
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesModelMarker extends JModel
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
	 * Method to set the identifier
	 *
	 * @access	public
	 * @param	int identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a category
	 * @return object with data
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__storelocator_marker_types '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = null;
			$this->_data->image_url = '';
			$this->_data->shadow_url = '';
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{	
		$row =& $this->getTable();

		$data = JRequest::get( 'post' );

		// Bind the form fields to the category table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// 1.5 Image Upload
		JClientHelper::setCredentialsFromRequest('ftp');
   
		$file =& JRequest::getVar('image_upload', '', 'files', 'array' );//Get File name, tmp_name
			  
		$filename = JPath::clean(strtolower(date('dmyHisu').$file['name']));//Make the filename unique
		error_reporting(E_ALL);
		ini_set('display_errors',1);
		
		//JPATH_ROOT is root of your path such as c:\wamp\www\yourwebsite
		//JPATH_BASE is path of current path such as when you access admin component will be c:\\wamp\www\yourwebsite\administrator
		
		$filepath = JPATH_ROOT.'/media/com_storelocator/markers/'.$filename;//specific path of the file
			  
		$allowed = array('image/png');
			  
		if (!in_array($file['type'], $allowed)) //To check if the file are image file
		{
			$this->setError('The file you are trying to upload is not supported. The file must be a 24-bit PNG image.');
			return false;
		}
		else
		{
			   if(JFile::upload($file['tmp_name'], $filepath))//first param is src file, second param is destination
					$row->image_url = JURI::root( true ).'/media/com_storelocator/markers/'.$filename;
				else
					$this->setError('Error Saving Image');
		}

		// Make sure the marker record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the marker to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

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

		$row =& $this->getTable();

		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}

}