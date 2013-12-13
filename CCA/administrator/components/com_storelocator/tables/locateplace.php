<?php
/**
 * LocatePlace Table Class for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * locatePlace Table class
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class TablelocatePlace extends JTable
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
	var $address = null;
	
	/**
	 * @var double
	 */
	var $lat = null;
	
	/**
	 * @var double
	 */
	var $lng = null;
	
	/**
	 * @var double
	 */
	var $catid = null;
	
	/**
	 * @var string
	 */
	var $phone = null;
	
	/**
	 * @var string
	 */
	var $website = null;
	
	
	
	var $fulladdress = null;
	var $facebook = null;
	var $twitter = null;
	var $email = null;
	var $cust1 = null;
	var $cust2 = null;
	var $cust3 = null;
	var $cust4 = null;
	var $cust5 = null;
	var $featured = 0;
	var $access = 0;
	var $published = 1;
	
	var $publish_up = null;
	var $publish_down = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TablelocatePlace(& $db) {
		parent::__construct('#__storelocator', 'id', $db);
	}
}