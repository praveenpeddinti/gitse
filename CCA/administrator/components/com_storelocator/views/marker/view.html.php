<?php
/**
 * Category View for Store Locator Component
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
 * Category View
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesViewMarker extends JView
{
	/**
	 * display method of Locate Place view
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get the marker
		$marker		=& $this->get('Data');
		$isNew		= ($marker->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Marker' ).': <small><small>[ ' . $text.' ]</small></small>', 'marker.png' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
			
		$this->assignRef('marker',		$marker);

		parent::display($tpl);
	}
}