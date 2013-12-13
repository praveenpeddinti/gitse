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
class LocatePlacesControllerCategories extends LocatePlacesController
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
		JRequest::setVar( 'view', 'categories' );
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'category' );
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
		$model = $this->getModel('category');

		if ($model->store()) {
			$msg = JText::_( 'Category Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Category' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_storelocator&controller=categories';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('category');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Categories Could not be Deleted' );
		} else {
			$msg = JText::_( 'Categories Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_storelocator&controller=categories', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_storelocator&controller=categories', $msg );
	}
}