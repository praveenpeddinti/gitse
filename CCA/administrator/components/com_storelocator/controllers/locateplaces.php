<?php
/**
 * LocatePlace Controller for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * LocatePlaces Controller
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesControllerLocatePlaces extends LocatePlacesController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{ 
		
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'unpublish',	'publish' );
		$this->registerTask('accessregistered','access');
		$this->registerTask('accessspecial','access');
		$this->registerTask('accesspublic','access');
		$this->registerTask('toggle_featured','featured');			
		
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'locateplace' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('locateplace');
		

		if ($model->store()) {
			$msg = JText::_( 'Location Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Location' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_storelocator';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('locateplace');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Locations Could not be Deleted' );
		} else {
			$msg = JText::_( 'Locations(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_storelocator', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_storelocator', $msg );
	}
	
	function publish()
	{
		// Check for request forgeries

		$this->setRedirect( 'index.php?option=com_storelocator' );
		

		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		
		$publish	= ($task == 'publish');
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__storelocator'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids.'  )';
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setMessage( JText::sprintf( $publish ? 'Items published' : 'Items unpublished', $n ) );
	}
	
	
	/**
	* changes the access level of a record
	* @param integer The increment to reorder by
	*/
	function access()
	{

		// Check for request forgeries

	
		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$access		= JRequest::getCmd( 'task' );
		
		switch($access){
			case 'accessregistered':
				$accessNumber = 1;
			break;
			case 'accessspecial':
				$accessNumber = 2;
			break;
			case 'accesspublic':
			default:
				$accessNumber = 0;
		}
		
		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );
		//die ($access);
		$query = 'UPDATE #__storelocator'
		. ' SET access = ' . (int) $accessNumber
		. ' WHERE id IN ( '. $cids.'  )';
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}	
		$this->setRedirect( 'index.php?option=com_storelocator' );
	}
	
	function featured()
	{
		// Check for request forgeries

		$this->setRedirect( 'index.php?option=com_storelocator' );
		

		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__storelocator'
		. ' SET featured = NOT featured'
		. ' WHERE id IN ( '. $cids.'  )';
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
		$this->setMessage( JText::sprintf( '%d Items Featured or Unfeatured', $n ) );
	}
	
}