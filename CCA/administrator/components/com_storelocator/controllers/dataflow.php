<?php
/**
 * LocatePlace Controller for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * LocatePlaces Controller
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
 
class LocatePlacesControllerDataFlow extends LocatePlacesController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{ 
		parent::__construct();
		JRequest::setVar( 'view', 'dataflow' );
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function import()
	{
		$params = &JComponentHelper::getParams( 'com_storelocator' );
		$auto_detect_line_endings = $params->get( 'auto_detect_line_endings', 1 );
		
		ini_set("auto_detect_line_endings", $auto_detect_line_endings);
		
		$model = $this->getModel('dataflow');
		$locationModel = $this->getModel('locateplace');
		$msg = $model->importCSV($locationModel);

		$link = 'index.php?option=com_storelocator&controller=dataflow';
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function export()
	{
		$model = $this->getModel('dataflow');
		$locationsModel = $this->getModel('locateplaces');
		$msg = $model->exportCSV($locationsModel);
		
		$link = 'index.php?option=com_storelocator&controller=dataflow';
		$this->setRedirect($link, $msg);
	}
	
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function exportlogs()
	{
		$model = $this->getModel('dataflow');
		$logs = $this->getModel('searchlogs');
		$msg = $model->exportLogs($logs);
		
		$link = 'index.php?option=com_storelocator&controller=dataflow';
		$this->setRedirect($link, $msg);
	}
	
	
	/**
	 * Clear search logs
	 * @return void
	 */
	function clearlogs()
	{
		$model = $this->getModel('searchlogs');
		$rows = $model->clearLogs();
		
		$msg = 'Logs Purged. Deleted Logs: '.$rows;
		
		$link = 'index.php?option=com_storelocator&controller=dataflow';
		$this->setRedirect($link, $msg);
	}
	
	function upgrade()
	{
		$db =& JFactory::getDBO();
		$msg = '';
		
		// Check for Missing markerid Field
		$query = "SHOW COLUMNS FROM #__storelocator_cat WHERE Field = 'markerid'";
		$db->setQuery($query);
		$columns = $db->loadResult();
		
		if(!$columns) // Need to add the new Column
		{
			$query = "ALTER TABLE #__storelocator_cat ADD markerid int(11) NOT NULL DEFAULT '1' AFTER name";
			@$db->setQuery($query);
			@$db->loadResult();
			$msg .= "Marker Column Support Updated... ";
		}
		
		// Check for Missing published Field
		$query = "SHOW COLUMNS FROM #__storelocator WHERE Field = 'published'";
		$db->setQuery($query);
		$columns = $db->loadResult();
		
		if(!$columns) // Need to add the new Columns
		{
			$query = "ALTER TABLE #__storelocator ADD fulladdress text NOT NULL DEFAULT '' AFTER website";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD facebook varchar(500) NOT NULL DEFAULT '' AFTER fulladdress";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD twitter varchar(64) NOT NULL DEFAULT '' AFTER facebook";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD email varchar(200) NOT NULL DEFAULT '' AFTER twitter";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD cust1 text NOT NULL DEFAULT '' AFTER email";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD cust2 text NOT NULL DEFAULT '' AFTER cust1";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD cust3 text NOT NULL DEFAULT '' AFTER cust2";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD cust4 text NOT NULL DEFAULT '' AFTER cust3";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD cust5 text NOT NULL DEFAULT '' AFTER cust4";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD featured int(11) NOT NULL DEFAULT '0' AFTER cust5";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD access int(11) NOT NULL DEFAULT '0' AFTER featured";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE #__storelocator ADD published int(11) NOT NULL DEFAULT '1' AFTER access";
			@$db->setQuery($query);
			@$db->loadResult();		
			
			$msg .= "Locations Column Support Updated... ";
		}
		
		
		// 1.7.1 - Check for Missing tags table
		$query = "show tables like '%storelocator_tags'";
		$db->setQuery($query);
		$columns = $db->loadResult();
		
		if(!$columns) // Need to add the new Column
		{
			
			
			$query = "CREATE TABLE IF NOT EXISTS `#__storelocator_tags` (
				  `id` int(11) NOT NULL auto_increment,
				  `name` varchar(500) NOT NULL,
				  `marker_id` int(11) NOT NULL DEFAULT '1' ,
  				  `feature_marker_id` int(11) NOT NULL DEFAULT '1' ,
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
				
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "CREATE TABLE IF NOT EXISTS `#__storelocator_tag_map` (
				  `tag_id` int(11) NOT NULL,
				  `location_id` int(11) NOT NULL,
				   UNIQUE (`tag_id`, `location_id`)
				) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
			
			@$db->setQuery($query);
			@$db->loadResult();
			$msg .= "..Database Schema Updated to v1.7.1.";
		}
		
		
		// 1.8.1 - Added published_up/down and indexes
		$query = "SHOW COLUMNS FROM #__storelocator WHERE Field = 'publish_up'";
		$db->setQuery($query);
		$columns = $db->loadResult();
		
		if(!$columns) // Need to add the new Column
		{
			$query = "ALTER TABLE `#__storelocator` ADD `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `published`";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE `#__storelocator` ADD `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `publish_up`";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE `#__storelocator` ADD INDEX idx_access(access)";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE `#__storelocator` ADD INDEX idx_featured(featured)";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE `#__storelocator` ADD INDEX idx_catid(catid)";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE `#__storelocator` ADD INDEX idx_lat(lat)";
			@$db->setQuery($query);
			@$db->loadResult();
			
			$query = "ALTER TABLE `#__storelocator` ADD INDEX idx_lng(lng)";
			@$db->setQuery($query);
			@$db->loadResult();
			
			
			$msg .= "..Database Schema Updated to DB v1.8.1. ";
		}
		
		
		// 1.8.2 - Check for Missing Search Log table
		$query = "show tables like '%storelocator_log_search'";
		$db->setQuery($query);
		$columns = $db->loadResult();
		
		if(!$columns) // Need to add the new Column
		{
			
			
			$query = "CREATE TABLE IF NOT EXISTS `#__storelocator_log_search` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `ipaddress` varchar(45) NOT NULL,
					  `query` varchar(2000) NOT NULL,
					  `lat` decimal(10,0) DEFAULT NULL,
					  `long` decimal(10,0) DEFAULT NULL,
					  `limited` int(11) DEFAULT NULL,
					  `search_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`),
					  KEY `IDX_LAT` (`lat`),
					  KEY `IDX_LONG` (`long`),
					  KEY `IDX_IP` (`ipaddress`),
					  KEY `IDX_LIMIT` (`limited`),
					  KEY `IDX_TIME` (`search_time`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
				
			@$db->setQuery($query);
			@$db->loadResult();
			$msg .= "..Database Schema Updated to v1.8.2.";
		}
		
		$link = 'index.php?option=com_storelocator';
		$this->setRedirect($link, $msg);
		$this->redirect();
		
	}

}