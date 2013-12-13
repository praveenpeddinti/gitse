<?php
/**
 * Store Locator JS feed view
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

jimport( 'joomla.application.component.view');

/**
 * JS StoreLocator class for the Store Locator Component
 *
 * @package		SysgenMedia.StoreLocator
 * @subpackage	Components
 */
class LocatePlacesViewMap extends JView
{

	function display()
	{
	
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option'); 

		if(!(StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17()))
			$params = &JComponentHelper::getParams( 'com_storelocator' );
		else
		{
			$app = JFactory::getApplication('site');
			$params =  & $app->getParams('com_storelocator');
		}
		
		// Get the parameters of the active menu item
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menus = &JSite::getMenu();
			$menu    = $menus->getActive();
			$menuparams = $menus->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
		
		function printJSVar($jsname, $s)
		{
			printf("\tvar %s = '%s';\n", $jsname, $s);			
		}
		
	
		$this->assignRef('params',			$params);
		$this->assignRef('menuitemid',		$menuitemid);

		parent::display('js');
	}
	
}