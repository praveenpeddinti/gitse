<?php
/**
 * Categories Controller for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Categories Controller
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesControllerTags extends LocatePlacesController
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
		JRequest::setVar( 'view', 'tags' );
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'tag' );
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
		$model = $this->getModel('tag');

		if ($model->store()) {
			$msg = JText::_( 'Tag Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Tag' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_storelocator&controller=tags';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('tag');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Tags Could not be Deleted' );
		} else {
			$msg = JText::_( 'Tags Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_storelocator&controller=tags', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_storelocator&controller=tags', $msg );
	}
}