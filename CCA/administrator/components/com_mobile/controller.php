<?php
defined("_JEXEC") or die("Restricted access");
jimport("joomla.application.component.controller");

class mobileController extends JController{
	public function display(){
		try{
			$viewName = JRequest::getVar("view","list");
			$viewLayout = JRequest::getVar('layout','default');
			$view = & $this->getView($viewName);
			if($model = & $this->getModel('latestNews')){
				$view->setModel($model,true);
			}			
//			$view->setLayout($viewLayout);
			error_log("===============================fffffffff==");
			$view->latestNewsList();
			error_log("=================================");
		}catch(Exception $ex){
			JError::raiseError("Error in Reading controller".$ex->getMessage());		
		}
	}
	
	public function add(){
		try{
			$viewName = JRequest::getVar('view','add');
			$viewLayout = JRequest::getVar('layout','default');
			$view = &$this->getView($viewName);
			if($model = & $this->getModel('latestNews')){
				$view->setModel($model,true);
			}
			$view->setLayout($viewLayout);
			$view->loadAddForm();
		}catch(Exception $ex){
			JError::raiseError("Error in Controller Add Function".$ex->getMessage());
		}
	}

	public function save(){		
		try{
			$newsObjects = JRequest::get( 'POST' );  
			error_log("count of no of news count is=======".count($newsObjects['newsDesc'])."======================");
			$model = & $this->getModel('latestNews');
			$returnValue = $model->saveNewsDetails($newsObjects);
			if($returnValue == 'success'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'News Saved Successfully.');
			}elseif($returnValue == 'existed'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'News Already existed with this Description.','error');
			}else{
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'Internal Error Occured.','error');
			}
			/*if(!empty($latestNewsUrl['newsUrlDesc'])){    
		        $model = & $this->getModel('latestNews');
		        $returnValue = $model->saveLatestNewsUrl($latestNewsUrl);
			if($returnValue == 'success'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'News Saved Successfully.');
			}elseif($returnValue == 'existed'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'News Already existed with this Description.','error');
			}else{
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'Internal Error Occured.','error');
			}}*/
      		        
		}catch(Exception $ex){
			JError::raiseError(500,"Error in Controller save Function".$ex->getMessage());
		}
	}

	public function editnews(){
		try{
			$cids = JRequest::getVar('cid',null,'default','array');
			$startId = (int)JRequest::getVar('pageStartId','','','int');
			$endId = (int)JRequest::getVar('pageEndId','','','int');
			if(($cids===null) && (empty($startId) && empty($endId))){
				JError::raiseError(500,"Invalid Data");
			}
			$viewName = JRequest::getVar('view','editnews');
			$viewLayout = JRequest::getVar('layout','default');
			$view = &$this->getView($viewName);
			if($model = & $this->getModel('latestNews')){
				$view->setModel($model,true);
			}
			$view->setLayout($viewLayout);
			$view->loadEditForm($cids);
		}catch(Exception $ex){
			JError::raiseError(500,"Error Occured in EditNews function".$ex->getMessage());
		}
		
	}

	public function saveNews(){		
		try{
			$newsUrl = JRequest::get( 'POST' );
			$model = & $this->getModel('latestNews');
		        $returnValue = $model->updateNewsUrls($newsUrl);
			if($returnValue == 'success'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'News Saved Successfully.');
			}elseif($returnValue == 'invalid'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'Invalid Data Given.','error');
			}else{
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'Internal Error Occured.','error');
			} 
		}catch(Exception $ex){
			error_log("Error Occured in saveNews");
		}
	}
	
	public function remove(){
		try{
			$cids = JRequest::getVar('cid',null,'default','array');
			if($cids === null){
				JError::raiseError(500,"Invalid Data");
			}
			$model = & $this->getModel('latestNews');			
			$returnValue = $model->deleteNews($cids);
			if($returnValue == 'success'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'News Deleted Successfully.');
			}elseif($returnValue == 'existed'){
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'News Already existed with this Description.','error');
			}else{
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		        	$this->setRedirect($redirectTo, 'Internal Error Occured.','error');
			} 
		}catch(Exception $ex){
			JError::raiseError(500,"Error Occured in delete news urls");
		}
		
	}

	public function dopublish(){
		error_log("hi in ajax call");
		try{
			$data = JRequest::get( 'POST' );
			$model = &$this->getModel("latestNews");
			$returnValue = $model->updateNewsUrlStatus($data);
			$data['status'] = $returnValue;
			echo $data['status'];			
		}catch(Exception $ex){
			JError::raiseError(500,"Error Occured in Publish news");
		}		
		
	}

}
?>
