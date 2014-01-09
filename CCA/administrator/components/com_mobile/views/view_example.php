<?php
defined("_JEXEC") or die("Restricted access");
jimport("joomla.application.component.view");


class latestNewsUrlsViewList extends JView{
	
	public function latestNewsList(){
		try{
		JToolBarHelper::title("Latest News URLS",'generic.png');
		JToolBarHelper::addNewX();
		JToolBarHelper::editListX();
		JToolBarHelper::deleteList();
		$model = $this->getModel();
		$latestNewsUrls = $model->getLatestNewsUrls();
		$this->assignRef("latestNewsUrls",$latestNewsUrls);
		parent::display();
		}catch(Exception $ex){
			JError::raiseError("Error in View".$ex->getMessage());
		}
		
		
	}

}
