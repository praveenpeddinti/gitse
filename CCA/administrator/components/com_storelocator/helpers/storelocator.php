<?php
/**
 * @version		$Id: banners.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * StoreLocator component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class StorelocatorHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('Location Manager'),
			'index.php?option=com_storelocator&view=locateplaces',
			$vName == 'locateplaces'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Category Manager'),
			'index.php?option=com_storelocator&view=categories',
			$vName == 'categories'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Tags'),
			'index.php?option=com_storelocator&view=tags',
			$vName == 'tags'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Import / Export'),
			'index.php?option=com_storelocator&view=dataflow',
			$vName == 'dataflow'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Batch Geocoder'),
			'index.php?option=com_storelocator&view=geocode',
			$vName == 'geocode'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Marker Manager'),
			'index.php?option=com_storelocator&view=markers',
			$vName == 'markers'
		);
	}
	
	public static function isVersion16()
	{
		$version = new JVersion;
    	$joomla = $version->getShortVersion();
    	if(substr($joomla,0,3) == '1.6')
        	return true;
       	
    	return false;
	}
	
	public static function isVersion17()
	{
		$version = new JVersion;
    	$joomla = $version->getShortVersion();
    	if(doubleval(substr($joomla,0,3)) >= 1.7)
        	return true;
       	
    	return false;
	}
	
}

