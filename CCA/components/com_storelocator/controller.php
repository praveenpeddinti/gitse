<?php
/**
 * Store Locator default controller
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */
 
jimport('joomla.application.component.controller');

/**
 * Store Locator Component Controller
 *
 * @package		SysgenMedia.StoreLocator
 */
class LocatePlacesController extends JController
{
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	function display()
	{
		$document =& JFactory::getDocument();		
		$viewType	= $document->getType();
		
		// Set the default view name from the Request
		$view = &$this->getView('map', $viewType);
		
		// Push a model into the view
		$model	= &$this->getModel( 'locateplaces' );

		if (!JError::isError( $model )) {
			$view->setModel( $model, true );
		}

		// Display the view
		$view->display();
		$model->finalize();
	}

}
?>
