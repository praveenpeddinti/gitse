<?php
/**
 * Categories View for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Markers View
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesViewMarkers extends JView
{
	/**
	 * LocatePlaces view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Marker Manager' ), 'marker.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::help('help', true);


		// Get data from the model
		$items		= & $this->get( 'Data');

		$this->assignRef('items',		$items);

		parent::display($tpl);
	}
}