<?php
/**
 * Categories Model for Store Locator Component
 * 
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 * @copyright	Copyright (c)2009 Sysgen Media LLC. All Rights Reserved.
 * @license		GNU/GPLv3
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


/**
 * Categories Model
 *
 * @package    SysgenMedia.StoreLocator
 * @subpackage Components
 */
class LocatePlacesModelDataFlow extends JModel
{
	/**
	 * LocatePlaces data array
	 *
	 * @var array
	 */
	var $_cats;


	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildCatsQuery()
	{
		$query = ' SELECT * FROM #__storelocator_cat ORDER BY name DESC ';

		return $query;
	}

	/**
	 * Retrieves the data
	 * @return array Array of objects containing the data from the database
	 */
	function getCategories()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_cats ))
		{
			$query = $this->_buildCatsQuery();
			$this->_cats = $this->_getList( $query );
		}

		return $this->_cats;
	}
	
	
	function importCSV($locationModel)
	{
		@ini_set('memory_limit', '512M');
		
		
		$importParams = JRequest::get( 'post' );
		$csvfile = JRequest::get( 'files' );
		
		$skipfirst = array_key_exists('skipfirst', $importParams);
		
		
		// Error Check Basic PHP issues
		if ($csvfile['csvfile']['error'] !=0)
			return $this->file_upload_error_message($csvfile['csvfile']['error']);

		// Import CSV File to an Array
		$row = 0;
		$locations = array();
		if (($handle = fopen($csvfile['csvfile']['tmp_name'], "r")) !== FALSE) {
			
			setlocale(LC_ALL, 'en_US.UTF-8');

			if ($skipfirst)
				$data = fgetcsv($handle, 0, ","); // Skip First Line of Data
				
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
				$data = preg_replace ('/([\x80-\xff])/se', "pack (\"C*\", (ord ($1) >> 6) | 0xc0, (ord ($1) & 0x3f) | 0x80)", $data);
				$locations[] = $data;
				$row++;
			}
			fclose($handle);
		}
		
		$rowCount = 0;
		$importErrors = array();
		
		// Foreach Line, Store an Entry...
		foreach($locations as $location)
		{
						
			$rowCount++;
			
			if(count($location) < 18) // Must have at least 18 columns
			{
				$importErrors[] = "Error Importing Row: $rowCount - Incorrect number of columns. Make sure you Have 18+ Columns";
				continue;
			}
			
			// Translate the Columns into Fields
			$data = array();
			$data['name'] 		= $location[0];
			$data['address'] 	= $location[1];
			$data['phone'] 		= $location[2]; 
			$data['website'] 	= $location[3];
			$data['lat'] 		= $location[4];
			$data['lng']		= $location[5];
			$data['catid'] 		= $this->_getImportCat($location[6]);
			$data['email'] 		= $location[7];
			$data['facebook'] 	= $location[8];
			$data['twitter'] 	= $location[9];
			$data['cust1'] 		= $location[10];
			$data['cust2'] 		= $location[11];
			$data['cust3'] 		= $location[12];
			$data['cust4'] 		= $location[13];
			$data['cust5'] 		= $location[14];
			$data['featured']	= intval($location[16]) ? 1 : 0;
			$data['published'] 	= intval($location[17]) ? 1 : 0;
			
			$data['access'] = (StorelocatorHelper::isVersion16()||StorelocatorHelper::isVersion17())?1:0; // Import as Public			
			
			if (isset($location[18]) && !empty($location[18]) )
				$data['publish_up'] = $location[18];
			
			if (isset($location[19]) && !empty($location[19]) )
				$data['publish_down'] = $location[19];
			
			if (isset($location[20]))
				$data['fulladdress'] = $location[20];
			else
				$data['fulladdress'] = '';
			
			if ($data['catid'] == -1)
			{
				$importErrors[] = "Error Importing Row: $rowCount - Category Not Specified or Could Not Be Created.";
				continue;
			}
	
			if (!$locationModel->store($data)) 
			{
				$importErrors[] = "Error Importing Row: $rowCount - Could Not Save Row to DB.";
			} else {
				$this->_importTags($locationModel->getId(), $location[15]);
			}
		}

		$goodImports = $row - count($importErrors);
		
		$msg = "Found: $row locations. Imported: $goodImports locations. Errors: ".count($importErrors)." locations.";
		
		if (count($importErrors) > 0)
			$msg .= '</li><li>'. implode('</li><li>',$importErrors);
		
		return $msg;
	
	}
	
	function _getImportCat($cat)
	{
		$db =& JFactory::getDBO();
		
		if (empty($cat))
			return -1;
		
		if(is_numeric($cat))
		{
			$query = 'SELECT count(*) FROM #__storelocator_cat WHERE id = '.intval($cat);
			$db->setQuery($query);
			$result = $db->loadResult();
			
			if($result)
				return intval($cat);
		} else {
			$query = 'SELECT id FROM #__storelocator_cat WHERE name = '.$db->quote($cat).' limit 1';
			$db->setQuery($query);
			$result = $db->loadResult();
			
			if($result)
				return intval($result);
			
			// No String Found...  Insert New Cat and return ID
			$query = 'INSERT INTO #__storelocator_cat SET name = '.$db->quote(trim($cat));
			$db->setQuery($query);
			$db->query();
			$newid = $db->insertid();

			if($newid)
				return intval($newid);
			
		}
		// Cant find vaild Cat, so error
		return -1;
	}
	
	function _importTags($location_id,$tags)
	{
		$db =& JFactory::getDBO();
		
		if (empty($tags) || intval($location_id) == 0)
			return;
			
		$taglist = explode(',',$tags);
		
		if(count($taglist)>0)
		{
			
			foreach($taglist as $tag)
			{
				$tag = trim($tag);
				$query = 'SELECT id FROM #__storelocator_tags WHERE name = '.$db->quote($tag).' limit 1';
				$db->setQuery($query);
				$tag_id = $db->loadResult();
				
				if(intval($tag_id) == 0) // Tag Does not Exist, Creat it First
				{ 
					$query = 'INSERT INTO #__storelocator_tags SET name = '.$db->quote(trim($tag));
					$db->setQuery($query);
					$db->query();
					$tag_id = $db->insertid();
				}
				
				$query = 'INSERT INTO #__storelocator_tag_map SET tag_id = '.intval($tag_id).', location_id = '.intval($location_id);
				$db->setQuery($query);
				$db->query();
			}
		}
	}
	
	function exportCSV($locationsModel)
	{

		$post = JRequest::get( 'post' );
		if(!isset($post['exportcats']) || count($post['exportcats'])==0)
			return 'Error: You must choose which categories to export';
		
		$exportcats = $post['exportcats'];
		
		$locations = $locationsModel->getDataByCat($exportcats);
		$tagMap = $locationsModel->getTagMap();
			
		setlocale(LC_ALL, 'en_US.UTF-8');	
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=export.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		fputcsv($output, array('Name','Address','Phone','Website','Latitude','Longitude','Category','Email','Facebook',
								'Twitter','Custom1','Custom2','Custom3','Custom4','Custom5','Tags','Featured','Published','Start Publishing','End Publishing','Description'));
		
						
		foreach($locations as $location)
		{
			$tags = isset($tagMap[$location->id])?$tagMap[$location->id]:'';
			
			$row = array(	$location->name, $location->address, $location->phone, $location->website, $location->lat, $location->lng, $location->category, 
							$location->email, $location->facebook, $location->twitter, $location->cust1, $location->cust2, $location->cust3, $location->cust4, 
							$location->cust5, $tags, intval($location->featured), intval($location->published), $location->publish_up, $location->publish_down, $location->fulladdress );
			
			fputcsv($output, $row);
		}
		
		exit;
	}
	
	function exportLogs($logsModel)
	{

		$post = JRequest::get( 'post' );
		
		$logs = $logsModel->getData();
			
		setlocale(LC_ALL, 'en_US.UTF-8');	
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=logs.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		fputcsv($output, array('ipaddress','lat','long','limited','search_time','query'));
		
		foreach($logs as $log)
		{			
			$row = array(	$log->ipaddress, $log->lat, $log->long, $log->limited, $log->search_time, $log->query  );
			
			fputcsv($output, $row);
		}
		
		exit;
	}
	
	function file_upload_error_message($error_code) {
		switch ($error_code) {
			case UPLOAD_ERR_INI_SIZE:
				return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			case UPLOAD_ERR_FORM_SIZE:
				return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			case UPLOAD_ERR_PARTIAL:
				return 'The uploaded file was only partially uploaded';
			case UPLOAD_ERR_NO_FILE:
				return 'No file was uploaded';
			case UPLOAD_ERR_NO_TMP_DIR:
				return 'Missing a temporary folder';
			case UPLOAD_ERR_CANT_WRITE:
				return 'Failed to write file to disk';
			case UPLOAD_ERR_EXTENSION:
				return 'File upload stopped by extension';
			default:
				return 'Unknown upload error';
		}
	}

}
