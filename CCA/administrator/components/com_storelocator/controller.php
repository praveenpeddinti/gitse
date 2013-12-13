<?php
/**
 * Store Locator default admin Controller
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Store Locator Component Controller
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
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

		// Load the submenu.
		StorelocatorHelper::addSubmenu(JRequest::getCmd('view', 'locateplaces'));
		
		
			//Upgrade? - Check for Missing publish_up Field
			$db		=& JFactory::getDBO();
			$query = "show tables like '%storelocator_log_search'";
			$db->setQuery($query);
			$tables = $db->loadResult();
					
			if(!$tables) // Need to add the new Column
			{
				$link = 'index.php?option=com_storelocator&controller=dataflow&task=upgrade';
				$this->setRedirect($link);
				$this->redirect();
			}
		
		
		parent::display();
	}
}