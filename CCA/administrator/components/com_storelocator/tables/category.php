<?php
/**
 * Category Table Class for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Category Table class
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class TableCategory extends JTable 
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
	 * @var int
	 */
	var $markerid = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableCategory(& $db) {
		parent::__construct('#__storelocator_cat', 'id', $db);
	}
}