<?php

defined("_JEXEC") or die("Restricted access");

jimport("joomla.application.component.view");

class latestNewsUrlsViewEditnews extends JView{
	public function loadEditForm($ids){
		JToolBarHelper::title("Edit News URL",'generic.png');
		JToolBarHelper::save("saveNews");
		JToolBarHelper::cancel();
		$model = $this->getModel();
		//$newsUrls = $model->getLatestNewsUrlsById($id);
		$newsUrls = $model->getnewsUrlsByIds($ids);
		error_log("count is===============".count($newsUrls));
		$this->assignRef("newsUrls",$newsUrls);
		parent::display();
	}
}
