<?php
defined("_JEXEC") or die("Restricted access");
jimport("joomla.application.component.view");


class latestNewsUrlsViewList extends JView{
	function __construct(){
		parent::__construct();
	}
	public function latestNewsList(){
		JToolBarHelper::title("Latest News URLS",'generic.png');
		JToolBarHelper::addNewX('add');
		JToolBarHelper::editListX('editnews');
		JToolBarHelper::deleteList("Are You sure want to delete news");
		$model = $this->getModel();
		$latestNewsUrls = $model->getLatestNewsUrls();
		$total=$latestNewsUrls['total'];
		$items = $latestNewsUrls;
		jimport('joomla.html.pagination');
		$mainframe = JFactory::getApplication();
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = JRequest::getVar('limitstart',0);
		error_log("====================".JRequest::getVar('limitstart'));
		//$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$pageNav = new JPagination($total , $limitstart, $limit );
                error_log("count is===============".count($latestNewsUrls));
		error_log("===================".$this->getLayout());		
		$this->assignRef("latestNewsUrls",$latestNewsUrls['data']);		
		$this->assignRef("pagination",$pageNav);		
		parent::display();
		
		
	}

}
