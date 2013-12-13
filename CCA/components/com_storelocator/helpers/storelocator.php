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
	
	public static function isVersionGT15()
	{
		return (StorelocatorHelper::isVersion16() || StorelocatorHelper::isVersion17());
	}
	
	public function getArticle($articleid) {
		
		$articleid = (int)$articleid;

        //  Make sure parameter is set and is greater than zero
        if ($articleid > 0) {

            //  Build Query
            $query = "SELECT * FROM #__content WHERE id = $articleid";

            //  Load query into an object
            $db = JFactory::getDBO();
            $db->setQuery($query);
            return $db->loadObject();
        }

        //
        return null;
    }
	
	
}

