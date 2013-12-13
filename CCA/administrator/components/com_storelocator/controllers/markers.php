<?php
/**
 * Categories Controller for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2010 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Markers Controller
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesControllerMarkers extends LocatePlacesController
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
		JRequest::setVar( 'view', 'markers' );
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'marker' );
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
		$model = $this->getModel('marker');

		if ($model->store()) {
			$error = '';
			$msg = JText::_( 'Marker Saved!' );
		} else {
			$error = 'error';
			$msg = JText::_( 'Error Saving Marker' );
			
			$errmsg = $model->getError();
			
			if(!empty($errmsg) )
				$msg .= ': '.$model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_storelocator&controller=markers';
		$this->setRedirect($link, $msg, $error);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('marker');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Markers Could not be Deleted' );
		} else {
			$msg = JText::_( 'Markers Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_storelocator&controller=markers', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_storelocator&controller=markers', $msg );
	}
}