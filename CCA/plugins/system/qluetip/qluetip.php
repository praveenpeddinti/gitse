<?php

/**
 * Qlue ToolTip - Content Plugin
 *
 * @author Aaron Harding 
 * @package Qlue ToolTip
 * @license GNU/GPL
 * @version 1.5.2
 *
 * This plugin will convert a basic syntax of {qlueTip title=[tooltip]}Tool Tip Text{/qlueTip} into a valid tooltip.
 * The user can add extra parameters to the syntax to match their needs. For further information visit http://www.Qlue.co.uk.
 */
// Prevent users accessing this file directly
defined("_JEXEC") or die("Restricted Access");
// Import some needed classes if they are not already
JLoader::import( 'joomla.environment.response' );
JLoader::import( 'joomla.document.document' );
JLoader::import( 'joomla.plugin.helper' );
JLoader::import( 'joomla.plugin.plugin' );
JLoader::import( 'joomla.html');
class plgSystemQlueTip extends JPlugin {
	function __construct(&$subject, $config) {
		// Construct parent class (JPlugin)
		parent::__construct($subject, $config);
		
		// Get JApplication object
		$this->mainframe =& JFactory::getApplication();
	}
	public function onAfterDispatch() {
			
		// Check if admin section of site
		if($this->mainframe->isAdmin()) {
			return;
		}
		
		// Get the document object
		$document =& JFactory::getDocument();

		// Add our tooltip javascript to the header
    	$document->addScript( JURI::base(true) .'/plugins/system/qluetip/qluetip/js/qluetip-1_4.js');

    	// Add our tooltip css to the header
    	$document->addStyleSheet( JURI::base(true) .'/plugins/system/qluetip/qluetip/css/tip.css');
	}
	
	public function onAfterRender() {
		
		// Get body of site
		$body =& JResponse::getBody();

	  	// Check if body contains part of the qluetip syntax and is not in administrator section of site
	    if(!JString::strpos($body, 'qluetip') || $this->mainframe->isAdmin()){
	     return;
	    }	

	    // Regular expression to find the syntax for tooltip
	    $regex = "#{qluetip\s*(.*?)}(.*?){/qluetip}#s";   
	    
	    // Search for all tooltip syntax
	    preg_match_all($regex, $body, $matches);

	    // If any instances been found create the tooltip
 	    if ( !empty($matches[0])) {
 	      // Create the tooltip and return true
 	      $this->_build($body, $matches);
 	      return true;
	    }
		
		// Return false by default
		return false;
	}
	private function _build( $body, $matches ){
			
		$descriptions = array();	
		
		// Loop to generate the tooltip instances		for( $i = 0; $i < count($matches[0]); $i++ ){
			//find params string in tooltip syntax
			$tipParams = $matches[1][$i];
			 
			// Get the tooltip values from syntax
			$tooltip    = "";
			
			// Create options array
			$opt = array();
			
			// Get the content for the tooltip
			$content    = $matches[2][$i];
			
			// Get tooltip options
			$opt['Class']    = $this->_params( $tipParams, "class", $this->params->get( "class", "default" ));
			$opt['position'] = $this->_params( $tipParams, "position", $this->params->get( "position", "cursor" ));
			$opt['width']    = $this->_params( $tipParams, "width", $this->params->get( "width", 300 ));
			$opt['duration'] = $this->_params( $tipParams, "duration", $this->params->get( "duration", 300 ));
			$opt['sticky']   = $this->_params( $tipParams, "sticky", $this->params->get( "sticky", 0 )) ? '\\true' : '\\false';
			// Convert our options array into a javascript object
			$options = $this->_getJSObject($opt);
			// Get output options
			$element    = $this->_params( $tipParams, "element", $this->params->get( "element", "span"));
			$title      = $this->_params( $tipParams, "title", false );
			$module     = $this->_params( $tipParams, "mod", false );
			/* 
			 * Although this tooltip can use the {loadposition} plugin inside of the content, I have kept this function here
			 * for those users using the mod=[] attribute for my older versions of my tooltip.
			 * This will be removed after a few versions as the {loadposition} is a better solution for loading modules
			 */
			// If a module has been set try to load it
			if($module) {
				// Get the contents of our module
				$module  = $this->_getModule($module);
				// Create the output
				$module  = '<div class="tooltip_module">'. $module .'</div>';
				// Add our module to the beginning of our content
				$content = $module . $content;
			}
			// Create the div for the tool tip with the parameters gathered
			$tooltip  .= '<'. $element .' id="qtip'. (int)$i .'" class="toggle" >';
			$tooltip  .= $title;
			$tooltip  .= '</'. $element .'>';
			$tooltip  .= '<script type="text/javascript">';
			$tooltip  .= 'window.addEvent("domready", function() { ';
		    $tooltip  .= 'new QlueTip( "qtip'. (int)$i .'", "tipcont'. (int)$i .'", '. $options .');';
			$tooltip  .= '});';
			$tooltip  .= '</script>';
			
			$descriptions[] = '<div id="tipcont'. (int)$i .'" class="QTip-content" style="display: none;">'. $content .'</div>';
			// Replace the plugin syntax with the tooltip
			$body = str_replace($matches[0][$i], $tooltip, $body);
		}
		//set the new body
		JResponse::setBody($body);
		
		$descriptions = implode('', $descriptions);
		JResponse::appendBody($descriptions);
	}
	private function _params( $TipParams, $param, $default = false ){
		// Regular expression to find the param from string $TipParams
		$regex = "/". $param ."=(\s*\[.*?\])/s";
		// Put params into the variable $options
		preg_match_all( $regex, $TipParams, $options );
		// If there is an option found remove any whitespace and return, if none are found return default value
		$value = !empty($options[1][0]) ? JString::trim( $options[1][0], '[]' ) : trim($default);
		// Return the value
		return $value;
	}
	private function _getModule( $position ){
		// Get the document object
		$document	= &JFactory::getDocument();
	    $renderer	= $document->loadRenderer('module');	  
		// Create a blank variable to push module into		$contents = '';
		// Get the module from specified position
	    foreach( JModuleHelper::getModules($position) as $mod ){
	     // Render the module and push onto the variable $contents
		   $contents .= $renderer->render($mod);		}
		// Return the module contents
	    return $contents;
	}
	
	private static function _getJSObject($array=array()) {
    
	    // Initialize variables
	    $object = '{';
	
	    // Iterate over array to build objects
	    foreach ((array)$array as $k => $v) {
	        
	      // If value is null, skip this step
	      if (is_null($v)) {
	        continue;
	      }
	      
	      // If item is not array or object, create option
	      if (!is_array($v) && !is_object($v)) {
	        $object .= ' '.$k.': ';
	        $object .= (is_numeric($v) || strpos($v, '\\') === 0) ? (is_numeric($v)) ? $v : substr($v, 1) : "'".$v."'";
	        $object .= ',';
	      } else {
	        // item is an object/ array, get their options
	        $object .= ' '.$k.': '. self::_getJSObject($v).',';
	      }
	    }
	    
	    // If our object end's with a , remove it
	    if (substr($object, -1) == ',') {
	      $object = substr($object, 0, -1);
	    }
	    
	    // close our object
	    $object .= '}';
	    
	    // Return our object
	    return $object;
  }

}
?>