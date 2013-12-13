<?php
/**
 * Categories Element for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementCategories extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Categories';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();

		$query = "SELECT id, name FROM #__storelocator_cat ORDER BY name ASC";
		$db->setQuery( $query );
		$options = $db->loadObjectList();

		array_unshift($options, JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -', 'id', 'name'));

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.'][]', 'class="inputbox" size="10" multiple="multiple"', 'id', 'name', $value, $control_name.$name );
	}
}
