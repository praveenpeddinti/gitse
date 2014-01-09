<?php
//echo "Welcome to greetings";
defined("_JEXEC") or die("Restricted access");

require_once(JPATH_COMPONENT.DS.'controller.php');
try{
$controller = new mobileController();
$controller->execute(JRequest::getVar('task'));

$controller->redirect();
}catch(Exception $ex){
	JError::raiseError("Error in Reading component entrance".$ex->getMessage());
}
?>
