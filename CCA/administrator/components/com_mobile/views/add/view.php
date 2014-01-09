<?php

defined("_JEXEC") or die("Restricted access");
jimport("joomla.application.component.view");

class latestNewsUrlsViewAdd extends JView{
	public function loadAddForm(){
		try{
			$status = "AddForm Loading";
			JToolBarHelper::title("Latest News Add Form","generic.png");
			JToolBarHelper::save();
			JToolBarHelper::cancel();
			$model = $this->getModel();
			//$latestNewsComponentSettings = $model->getLatestNewsComponentSettings();			
			$this->assignRef("status",$status);
			parent::display();
		}catch(Exception $ex){
			JError::raiseError("Error in load add form view".$ex->getMessage());
		}
	}
}
