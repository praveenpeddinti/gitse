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
  
class LocatePlacesControllerGeocode extends LocatePlacesController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{ 
		parent::__construct();
		JRequest::setVar( 'view', 'geocode' );
	}
	
	function geocode()
	{
		set_time_limit(180);
		
		// Check URL allow fopen
		if (!ini_get('allow_url_fopen'))
		{
			$msg = "You have disabled 'allow_url_fopen' in your PHP Settings. This is required for the Geocoding function to contact Google. </li>
					<li>For more information see: http://www.php.net/manual/en/filesystem.configuration.php";
							
			$mainframe = JFactory::getApplication();
			$mainframe->enqueueMessage($msg, 'error');
			return;
		}

		// Load Locations Model
		$locationsModel =& $this->getModel('locateplaces');
		$localBatch = $locationsModel->getNonCodedLocations();
		
		// Initialize delay in geocode speed
		$delay = 0;
		$base_url = "http://maps.google.com/maps/api/geocode/json";
		
		
		//Init some stats
		$good_encode = 0;
		$error_encode = array();
		
		// Iterate through the rows, geocoding each address
		foreach($localBatch as $location)
		{
			$address = $location->address;
			$id = $location->id;

			$request_url = $base_url . "?sensor=false&address=" . urlencode($address);
			
			$dataResponse = file_get_contents($request_url); // TODO Error Check
			$data = json_decode($dataResponse);
			
			switch($data->status) // Check that its Good to Go
			{
				case "OK": // Good Result, Save Results
					$this->_storeLocation($id, $data->results[0]->geometry->location->lat, $data->results[0]->geometry->location->lng);
					$good_encode++;
					break;
	
				case "ZERO_RESULTS": // Nothing Found
					$error_encode[] = array('location' => $location, 'error' => 'No Results Found for Address');
					break;
				case "REQUEST_DENIED": // Why?
					$error_encode[] = array('location' => $location, 'error' => 'Request Denied');
					break;
				case "INVALID_REQUEST": // Prob Missing Address
					$error_encode[] = array('location' => $location, 'error' => 'Invalid Address');
					break;
				
				case "OVER_QUERY_LIMIT": 
					$msg = "You are over your Daily Quota of 2,500 Geocode Requests. "
							."( <a href=\"http://code.google.com/apis/maps/faq.html#geocoder_limit\" target=\"_blank\">See Google Geocoding Web Service Terms of Use</a> )";
					$mainframe = JFactory::getApplication();
					$mainframe->enqueueMessage($msg, 'error');
					
					$link = 'index.php?option=com_storelocator&controller=geocode';
					$msg2 .= "Processed: $good_encode locations. &nbsp; Errors: ".count($error_encode)." locations.";
					if (count($error_encode))
						foreach($error_encode as $error)
							$msg2 .= sprintf("</li><li>Error: %s - Location ID: %d / Name: %s ", $error['error'], $error['location']->id, $error['location']->name);
					$this->setRedirect($link, $msg2, count($error_encode)>0?'notice':'message');
					return;
			}
			
			if ($good_encode + count($error_encode) > 500) // Max Batch Size
			{
				$msg = "Maximum Batch Size of 500 Requestes Reached, Please Run Again to Complete Geocoding";
				$mainframe = JFactory::getApplication();
				$mainframe->enqueueMessage($msg, 'error');
				
				$link = 'index.php?option=com_storelocator&controller=geocode';
				$msg2 .= "Processed: $good_encode locations. &nbsp; Errors: ".count($error_encode)." locations.";
				if (count($error_encode))
					foreach($error_encode as $error)
						$msg2 .= sprintf("</li><li>Error: %s - Location ID: %d / Name: %s ", $error['error'], $error['location']->id, $error['location']->name);
				$this->setRedirect($link, $msg2, count($error_encode)>0?'notice':'message');
				return;
			
			}
			
			usleep(150000);
		}
		
		$msg = "Geocoding Complete! Processed: $good_encode locations. &nbsp; Errors: ".count($error_encode)." locations.";
		
		if (count($error_encode))
			foreach($error_encode as $error)
				$msg .= sprintf("</li><li>Error: %s - Location ID: %d / Name: %s ", $error['error'], $error['location']->id, $error['location']->name);
		
		$link = 'index.php?option=com_storelocator&controller=geocode';
		$this->setRedirect($link, $msg, count($error_encode)>0?'notice':'message');
		
	}
	
	function _storeLocation($id, $lat, $lng)
	{
		$location =& $this->getModel('locateplace');
		$location->setId($id);
		$data = $location->getData();
		$data->lat = $lat;
		$data->lng = $lng;
		$location->store($data);
	}

}