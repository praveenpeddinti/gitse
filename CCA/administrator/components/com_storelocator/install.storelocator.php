<?php //no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * Store Locator Installation Script
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

jimport( 'joomla.filesystem.file' );

	function com_install()
	{
		//media/com_storelocator/markers/
		
		//First we set up parameters
		$searchpath = JPATH_SITE . "/media";
		 
		//Then we create the subfolder called jpg
		if ( !JFolder::create($searchpath . "/com_storelocator/markers", 0777) ) {
		   echo '<p style="color:red;"><strong>Media folder not writable!</strong> Failed to create marker image folder. Please create a writable folder with the following path inside your joomla site: <em><strong>/media/com_storelocator/markers/</strong></em> <br /> Your full file path should be: <em>'.JPATH_SITE.'<strong>/media/com_storelocator/markers/</strong></em></p>';
		}

	
		if (file_exists(JPATH_SITE . '/administrator/components/com_joomfish/config.xml'))
		{		
			echo '<p style="color:green;"><strong>Joom!Fish Found! - Installing Content Elements!</strong></p>';
					 
			if(!JFile::copy(JPATH_SITE . "/administrator/components/com_storelocator/contentelements/storelocator_cat.xml", 
							JPATH_SITE . "/administrator/components/com_joomfish/contentelements/storelocator_cat.xml"))
			{
				echo '<p style="color:red;">Failed to Install Joom!Fish Category Content Element. Please copy the file manually if you wan to use Joom!Fish</p>';
			}
			
			if(!JFile::copy(JPATH_SITE . "/administrator/components/com_storelocator/contentelements/storelocator.xml", 
							JPATH_SITE . "/administrator/components/com_joomfish/contentelements/storelocator.xml"))
			{
				echo '<p style="color:red;">Failed to Install Joom!Fish Locations Content Element. Please copy the file manually if you wan to use Joom!Fish</p>';
			}
		} 
		
		?>
            <hr />
            <h2><a href="http://www.sysgenmedia.com/?ref=storelocator" title="Sysgen Media LLC"><img src="https://www.sysgenmedia.com/images/sysgen_logo.jpg" alt="Sysgen Media LLC" /></a></h2>
            <h3>Sysgen Media Joomla! Store Locator v1.8.1.0.</h3>
            <p style="color:#C00"><strong>Basic Setup: The Store Locator is a Component. To use the this component, you must create at lease one new Menu Item that points to the Store Locator. </strong>            </p>
            <p><em>To begin adding locations:</em></p>
            <ol>
              <li>Navigate to <a href="?option=com_storelocator">Components -&gt; Store Locator</a>. </li>
              <li>Click the &quot;New&quot; button and fill out the Location Details. </li>
              <li>Click &quot;calculate coordinates&quot; to determine the Latitude and Longitude for the Location.<br />
            You also have the option of manually specifying the coordinates.</li>
            </ol>
<p>The Store Locator Joomla! Component is developed by <a href="http://www.sysgenmedia.com" target="_blank">Sysgen Media LLC</a>.<br />
              For support inquires please check our <a href="https://www.sysgenmedia.com/forum">Forums</a> or if you have an active subscription <a href="https://www.sysgenmedia.com/submit-a-ticket">Submit a Ticket</a></p>
              
<?php
	
	
	}
?>
