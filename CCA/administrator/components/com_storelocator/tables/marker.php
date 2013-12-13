<?php
/**
 * Marker Table Class for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2010 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Marker Table class
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class TableMarker extends JTable 
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $name = null;
	
	/**
	 * @var string
	 */
	var $image_url = null;
	
	/**
	 * @var string
	 */
	var $shadow_url = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableMarker(& $db) {
		parent::__construct('#__storelocator_marker_types', 'id', $db);
	}
}