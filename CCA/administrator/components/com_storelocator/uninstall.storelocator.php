<?php //no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * Store Locator uninstallation script
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

	function com_uninstall()
	{
		// Keep Data on Uninstall?
		$params = &JComponentHelper::getParams( 'com_storelocator' );
		$keep_data = $params->get( 'keep_data', 1 );
		
		if (!$keep_data)
		{
			echo "Removing Database Tables";
			
			$db = &JFactory::getDBO();
			
			$db->setQuery("DROP TABLE IF EXISTS `#__storelocator`");
			$db->query();
			
			$db->setQuery("DROP TABLE IF EXISTS `#__storelocator_cat`");
			$db->query();
			
			$db->setQuery("DROP TABLE IF EXISTS `#__storelocator_marker_types`");
			$db->query();
			
			$db->setQuery("DROP TABLE IF EXISTS `#__storelocator_tag_map`");
			$db->query();
			
			$db->setQuery("DROP TABLE IF EXISTS `#__storelocator_tags`");
			$db->query();
			
			$db->setQuery("DROP TABLE IF EXISTS `#__storelocator_log_search`");
			$db->query();			
		
		}
		
		echo '<h4>Thank you for using the Store Locator Joomla Component, developed by <a href="http://www.sysgenmedia.com" target="_blank">Sysgen Media LLC</a> - <em>Joomla Web Design, Hosting and Custom Component Development</em></h4>';
	}

?>