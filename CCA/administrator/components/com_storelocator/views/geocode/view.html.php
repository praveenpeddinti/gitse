<?php
/**
 * Store Locator default view Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */
 

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );


class LocatePlacesViewGeocode extends JView
{
	/**
	 * LocatePlaces view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Batch Geocoder' ), 'geocode.png' );
		JToolBarHelper::help('help', true);
		
		$model =&	$this->getModel();	

		$nonCodedCount = count($model->getNonCodedLocations());
		$this->assignRef('nonCodedCount',		$nonCodedCount);

		parent::display($tpl);
	}
}