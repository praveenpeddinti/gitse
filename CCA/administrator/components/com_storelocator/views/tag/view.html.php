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
class LocatePlacesViewTag extends JView
{
	/**
	 * display method of Locate Place view
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get the category
		$tag		=& $this->get('Data');
		$isNew		= ($tag->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Tag' ).': <small><small>[ ' . $text.' ]</small></small>', 'category.png' );
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
		$feature_markers = '';
		foreach($result as $marker)
		{
			$markers .= sprintf("<div class=\"markericon\"><input type=\"radio\" name=\"marker_id\" id=\"marker_id_%d\" value=\"%d\"  %s /> <label for=\"marker_id_%d\"><img src=\"%s\" align=\"absmiddle\" /> %s</label></div>"  ,
								$marker->value,
								$marker->value,
								$tag->marker_id == $marker->value?' checked="checked"':'',
								$marker->value,
								$marker->image_url,
								$marker->text
								);
								
			$feature_markers .= sprintf("<div class=\"markericon\"><input type=\"radio\" name=\"feature_marker_id\" id=\"feature_marker_id_%d\" value=\"%d\"  %s /> <label for=\"feature_marker_id_%d\"><img src=\"%s\" align=\"absmiddle\" /> %s</label></div>"  ,
								$marker->value,
								$marker->value,
								$tag->feature_marker_id == $marker->value?' checked="checked"':'',
								$marker->value,
								$marker->image_url,
								$marker->text
								);
		}
	
		
		$this->assignRef('markers',				$markers);
		$this->assignRef('feature_markers',		$feature_markers);
		$this->assignRef('tag',					$tag);

		parent::display($tpl);
	}
}