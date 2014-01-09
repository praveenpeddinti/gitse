<?php
defined("_JEXEC") or die("Restricted access");

jimport("joomla.application.component.model");
jimport( 'joomla.html.pagination' );
class mobileModelLatestNews extends JModel{
	public $pagination;
	public $total;	
	public function getLatestNewsUrls(){
		try{
			$db = $this->getDBO();
			$mainframe = JFactory::getApplication();
 		        // Get pagination request variables
		        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		        $limitstart = JRequest::getVar('limitstart',0);
			error_log("limit value is============".$limit);
			//$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
			error_log("===============limit start value is==================".$limitstart);
			$db->setQuery("select * from ".$db->getPrefix()."users limit ".$limitstart.",$limit");
			//error_log("query is======================"."select * from #_latestnews order by id desc");
			$latestNewsUrls = $db->loadObjectList();
			$db->setQuery("select count(*) from ".$db->getPrefix()."users");
			$total=$db->loadResult();
			/*if($latestNewsUrls == null)
			{
				JError::raiseError(500,"Error in Reading db");
			}*/			
			return array('data'=>$latestNewsUrls,'total'=>$total);			
		}catch(Exception $ex){
			JError::raiseError(500,"Error in Reading db");
		}
	}
	
	public function saveLatestNewsUrl($latestNewsUrl){
		$returnValue = "success";
		try{
		$db = $this->getDBO();		
		if(!$this->getLatestNewsUrlByDescription($latestNewsUrl)){
		$db->setQuery("insert into ".$db->getPrefix()."latestnews(url,description,target,startPublishTime,endPublishTime,priority) values('".addslashes($latestNewsUrl['newsUrl'])."','".addslashes($latestNewsUrl['newsUrlDesc'])."','".addslashes($latestNewsUrl['newsUrlTarget'])."','".addslashes($latestNewsUrl['startDate'])."','".addslashes($latestNewsUrl['endDate'])."','1')");
		//error_log("insert into #_latestnews(url,description,target,startPublishTime,endPublishTime,priority) values('".addslashes($latestNewsUrl['newsUrl'])."','".addslashes($latestNewsUrl['newsUrlDesc'])."','".addslashes($latestNewsUrl['newsUrlTarget'])."','".addslashes($latestNewsUrl['startDate'])."','".addslashes($latestNewsUrl['endDate'])."','1')");
			if($db->query()){
				
			}else{
				$returnValue = "failure";
			}
		}else{
				$returnValue = "existed";
		}
			
		}catch(Exception $ex){
			error_log("Error Occured here is===============".$ex->getMessage());
			$returnValue = "failure";
		}
		return $returnValue;
		
	}

	public function getLatestNewsUrlByDescription($obj,$id){
		try{
			$db = $this->getDBO();
			$query="";
			if(!empty($id)){
				$query="select * from ".$db->getPrefix()."latestnews where description='".addslashes($obj['newsUrlDesc'])."' and id!='".addslashes($id)."'";				
			}else{
				$query="select * from ".$db->getPrefix()."latestnews where description='".addslashes($obj['newsUrlDesc'])."'";
			}
			$db->setQuery($query);
			error_log("query is=============".$query);
			$result =  $db->loadObjectList();
			$data;	
			foreach($result as $row){
				if(!empty($row->id)){
					return true;
				}
			}			
			return false;
		}catch(Exception $ex){
		}
	}
	
	public function getLatestNewsUrlsById($id){
		try{
			$db = $this->getDBO();
			$db->setQuery("select * from ".$db->getPrefix()."latestnews where id=".addslashes($id));
			$result =  $db->loadObjectList();
			if($result != null){
				error_log("value is not null");
				return $result;
			}
			return false;
		}catch(Exception $ex){
		}
	}

	public function updateLatestNewsUrl($obj){
			$returnValue = "success";
		try{
			$db = $this->getDBO();
			if(!$this->getLatestNewsUrlByDescription($obj,$obj['newsId'])){
			$db->setQuery("update ".$db->getPrefix()."latestnews set url='".addslashes($obj['newsUrl'])."',description='".addslashes($obj['newsUrlDesc'])."',target='".addslashes($obj['newsUrlTarget'])."',startPublishTime='".addslashes($obj['startDate'])."',endPublishTime='".addslashes($obj['endDate'])."',priority=1 where id='".$obj['newsId']."'");	
			error_log("update status is===================="."update ".$db->getPrefix()."latestnews set url='".addslashes($obj['newsUrl'])."',description='".addslashes($obj['newsUrlDesc'])."',target='".addslashes($obj['newsUrlTarget'])."',startPublishTime='".addslashes($obj['startDate'])."',endPublishTime='".addslashes($obj['endDate'])."',priority=1 where id='".$obj['newsId']."'");	
			if($db->query()){
				
			}else{
				$returnValue = "failure";
			}
			}else{
				$returnValue = "existed";
			}
		}catch(Exception $ex){
			JError::raiseError(500,"Error Occured in updating into database");
			$returnValue = "failure";
		}
			error_log("update status is====================".$returnValue);
			return $returnValue;
	}

	public function deleteNews($cids){
		$returnValue = "success";
		try{
			$ids = implode(',',$cids);
			$db = $this->getDBO();
			$query = "delete from ".$db->getPrefix()."latestnews where id in (".$ids.")";
			error_log("==========".$query);
			$db->setQuery($query);
			if($db->query()){
			}else{
				$returnValue = "failure";
			}
		}catch(Exception $ex){
			error_log("======Error Occured in deleting news".$ex->getMessage());
		}
		return $returnValue;
	}

	public function updateNewsUrlStatus($data){
		$returnValue="success";
		try{
			$db = $this->getDBO();
			$query = "update ".$db->getPrefix()."latestnews set status='".$data['status']."' where id='".$data['id']."'";
			$db->setQuery($query);
			if($db->query()){
			}else{
				$returnValue = 'failure';
			}
		}catch(Exception $ex){
			JError::raiseError("Error Occured in Database reading");
			$returnValue = 'failure';
		}
		error_log("eturn value is==================".$returnValue);
		return $returnValue;
	}
	
	public function saveNewsDetails($objects){
		$returnValue = "success";
		try{
			$db = $this->getDBO();	
			$dataArray = array();
			for($i=0;$i<count($objects['newsDesc']);$i++){
				$dataArray[] = "('".addslashes($objects['newsUrl'][$i])."','".addslashes($objects['newsDesc'][$i])."','".addslashes($objects['newsTarget'][$i])."','".addslashes($objects['newsStatus'][$i])."','".addslashes($objects['newsSequence'][$i])."')";
				error_log("============".$dataArray[$i]);
			}
			$query = "insert into ".$db->getPrefix()."latestnews(url,description,target,status,sequence) values".implode(",",$dataArray);
			$db->setQuery($query);
			if($db->query()){
			}else{
				$returnValue = 'failure';
			}
			
		}catch(Exception $ex){
		}
		return $returnValue;
	}

	public function getnewsUrlsByIds($ids){
		$returnValue;
		try{
			$db = $this->getDBO();
			if(!empty($ids)){
				$query="select * from ".$db->getPrefix()."latestnews where id in (".implode(',',$ids).")";				
			}else{
				$start = JRequest::getVar('pageStartId');
				$end = JRequest::getVar('pageEndId');
				$query="select * from ".$db->getPrefix()."latestnews where id>=$start and id<=$end ";
			}
			error_log("select query is==========".$query);
			$db->setQuery($query);
			$returnValue = $db->loadObjectList();
		}catch(Exception $ex){
		}
		return $returnValue;
	}

	public function updateNewsUrls($objects){
		$returnValue = "success";
		try{
			$db = $this->getDBO();
			$query="";
			for($i=0;$i<count($objects['newsDesc']);$i++){
				if(!empty($objects['newsId'][$i])){
					if((int)$objects['newsId'][$i]){
						$query="update ".$db->getPrefix()."latestnews set url='".addslashes($objects['newsUrl'][$i])."',description='".addslashes($objects['newsDesc'][$i])."',target='".addslashes($objects['newsTarget'][$i])."',sequence='".addslashes($objects['newsSequence'][$i])."' where id='".$objects['newsId'][$i]."'";
					}else{
						$returnValue='invalid';
						break;
					}
				}else{
					$query="insert into ".$db->getPrefix()."latestnews(url,description,target,status,sequence) values('".addslashes($objects['newsUrl'][$i])."','".addslashes($objects['newsDesc'][$i])."','".addslashes($objects['newsTarget'][$i])."','".addslashes($objects['newsStatus'][$i])."','".addslashes($objects['newsSequence'][$i])."')";
				}
				if(!empty($query)){
					$db->setQuery($query);
					if($db->query()){
						
					}else{
						$returnValue = 'failure';
					}
				}
			}
		}catch(Exception $ex){
		}
		return $returnValue;
	}


        public function latestNewsList(){
		$returnValue;
		try{
			$db = $this->getDBO();

				//$query="select name,username,email from ".$db->getPrefix()."users";
                                $query = "select name,address,lat,lng,phone,email,website from ".$db->getPrefix()."storelocator where published=1";
			error_log("select query is==========".$query);
			$db->setQuery($query);
			$returnValue = $db->loadObjectList();
		}catch(Exception $ex){
		}
		return $returnValue;
	}

        public function contentDetails(){
		$returnValue;
		try{
			$db = $this->getDBO();

				$query="select title,introtext from ".$db->getPrefix()."content where id=71";

			error_log("select query is==========".$query);
			$db->setQuery($query);
			$returnValue = $db->loadObject();
		}catch(Exception $ex){
		}
		return $returnValue;
	}
}
