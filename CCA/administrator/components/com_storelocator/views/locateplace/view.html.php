<?php
/**
 * Locate Place default view
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
 * Locate Place View
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesViewLocatePlace extends JView
{
	/**
	 * display method of Locate Place view
	 * @return void
	 **/
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		
		$location		=& $this->get('Data');
		$isNew			= ($location->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Location' ).': <small><small>[ ' . $text.' ]</small></small>', 'sysgen.png' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		
		$params = &JComponentHelper::getParams( 'com_storelocator' );
		
		//gather categories
		
		$query = "SELECT id as value, name as text FROM #__storelocator_cat ORDER BY name DESC";
		$db = &JFactory::getDBO();
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$categories = JHTML::_('select.genericlist',   $result, 'catid', 'class="inputbox" size="1" ', 'value', 'text', $location->catid);
		
		//gather tags
		
		$query = "SELECT id as value, name as text FROM #__storelocator_tags ORDER BY name DESC";
		$db = &JFactory::getDBO();
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$tags = JHTML::_('select.genericlist',   $result, 'tags[]', 'class="inputbox" size="5" multiple="multiple" ', 'value', 'text', $location->tags);
		
		// Optional Key
		$googleKey = $params->get( 'google_maps_v3_api_key' );
		
		if (empty($googleKey) )
		{
			JHTML::script('maps/api/js?v=3.9&sensor=false', 'https://maps.googleapis.com/'); // Load v3 API
		} else {
			JHTML::script('maps/api/js?v=3.9&sensor=false&key='.$googleKey, 'https://maps.googleapis.com/'); // Load v3 API with Key
	
		}
			
		$lists = array();
		$lists['access'] 			= JHTML::_('list.accesslevel',  $location );
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', '', $location->published );
		$lists['featured'] 			= JHTML::_('select.booleanlist',  'featured', '', $location->featured );

		$editor =& JFactory::getEditor();
		$editorFullAddress = $editor->display( 'fulladdress', $location->fulladdress , '500', '225', '5', '30' );
		


		$this->assignRef('locateplace',		$location);
		$this->assignRef('categories',		$categories);
		$this->assignRef('tags',			$tags);
		$this->assignRef('googleKey',	  	$googleKey);
		$this->assignRef('lists',			$lists);
		$this->assignRef('editorFullAddress',			$editorFullAddress);

		parent::display($tpl);
	}
}