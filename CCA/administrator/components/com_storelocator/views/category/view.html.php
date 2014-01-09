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
class LocatePlacesViewCategory extends JView
{
	/**
	 * display method of Locate Place view
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get the category
		$category		=& $this->get('Data');
		$isNew		= ($category->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Category' ).': <small><small>[ ' . $text.' ]</small></small>', 'category.png' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		
		$params = &JComponentHelper::getParams( 'com_storelocator' );
		
		//gather Markers
		
		$query = "SELECT id as value, name as text, image_url FROM #__storelocator_marker_types ORDER BY id ASC";
		$db = &JFactory::getDBO();
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		$markers = '';
		foreach($result as $marker)
		{
			$markers .= sprintf("<div class=\"markericon\"><input type=\"radio\" name=\"markerid\" id=\"markerid_%d\" value=\"%d\"  %s /> <label for=\"markerid_%d\"><img src=\"%s\" align=\"absmiddle\" /> %s</label></div>"  ,
								$marker->value,
								$marker->value,
								$category->markerid == $marker->value?' checked="checked"':'',
								$marker->value,
								$marker->image_url,
								$marker->text
								);
		}
	
		
		$this->assignRef('markers',			$markers);
		$this->assignRef('category',		$category);

		parent::display($tpl);
	}
}