<?php
/**
 * Store Locator entry point file for Store Locatio Component
 * 
 * @package     SysgenMedia.StoreLocator
 * @subpackage  Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * @param	array
 * @return	array
 */
function storelocatorBuildRoute(&$query)
{
	$segments = array();
	
	if(isset($query['view']))
	{
		unset( $query['view'] );
	}
	
	if(isset($query['format']))
	{
		$segments[] = $query['format'];
		unset( $query['format'] );
	}
	
	return $segments;
}

/**
 * @param	array
 * @return	array
 */
function storelocatorParseRoute($segments)
{
	$vars = array();
	
	if (count($segments))
	{
		switch($segments[0])
		{
		   case 'js':
				   $document =& JFactory::getDocument();		
				   $document->setType('js');
				   break;
		}
		
	}
	
	return $vars;
}
