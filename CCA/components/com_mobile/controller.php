<?php

defined("_JEXEC") or die;
jimport("joomla.application.component.controller");

class mobileController extends JControllerLegacy {
    
    //1 Partners Details------------
    public function getPartners() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {

                $partnerLogos = array();

                $doc = new DOMDocument();
                $doc->loadHTML($responseData->introtext);
                $doc->preserveWhiteSpace = false;
                $partnerLogosSrc = $doc->getElementsByTagName('img');

                $i = 0;
                foreach ($partnerLogosSrc as $partnerLogo) {
                    $partnerLogostt[$i] = $partnerLogo->getAttribute('src');
                    $i++;
                }

                $partnerUrlsSrc = $doc->getElementsByTagName('a');

                $j = 0;
                foreach ($partnerUrlsSrc as $partnerUrl) {
                    $partnerLogos[$j]['logo'] = $partnerLogostt[$j];
                    $partnerLogos[$j]['url'] = $partnerUrl->getAttribute('href');
                    $j++;
                }

                $returnValue['data'] = $partnerLogos;
		$returnValue['membersLogo'] = $this->getMembers();
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in Publish news");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }

    //2 About Us Details------------
    public function getAboutUs() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel('mobileData');
            $responseData = $model->contentAboutUsDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $responseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    $introtext = $responseData->introtext;
                } else {
                    $doc = new DOMDocument();
                    $doc->loadHTML($responseData->introtext);
                    $doc->preserveWhiteSpace = false;

                    foreach ($doc->getElementsByTagName('a') as $anchor) {
                        $link = $anchor->getAttribute('href');
                        $anchor->setAttribute('href', '#');
                        $anchor->setAttribute('onclick', 'openInChildBrowser("' . $link . '")');
                        $anchor->removeAttribute('target');
                    }
                    
                    $introtext = $doc->saveHTML();
                }


                $response['introtext'] = $introtext;
                $returnValue['data'] = $response;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }

    //3 Clinics Details for Lat and Lng------------
    public function getClinicsDetails() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            //$_REQUEST['lat'] =, $_REQUEST['lng'], $_REQUEST['distance']
            //$responseData = $model->contentClinicsDetailsForLatandLng('32.2858637', '-110.9785714', 25);
            $responseData = $model->contentClinicsDetailsForLatandLng($_REQUEST['lat'], $_REQUEST['lng'], $_REQUEST['distance']);
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $returnValue['latitude'] = $_REQUEST['lat'];
                $returnValue['longitude'] = $_REQUEST['lng'];
                $returnValue['data'] = $responseData;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in Clinics Data");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }

    //4 Clinics Detail for Id------------
    public function getClinicDetailsById() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentClinicsDetailForId($_REQUEST['id']);
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $returnValue['data'] = $responseData;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in Clinic Data");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }

    //5 Clinics Details for List pages------------
    public function getClinicsDetailList() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $pageNumber = $_REQUEST['startpage'];
            $pageSize = $_REQUEST['endpage'];

            $model = $this->getModel("mobileData");
            $totalClinics = count($model->getTotalClinics($_REQUEST['givenLatitude'], $_REQUEST['givenLongitude'], $_REQUEST['distance']));            
            $responseData = $model->contentClinicsDetailForList(($pageNumber * $pageSize), $pageSize, $_REQUEST['givenLatitude'], $_REQUEST['givenLongitude'], $_REQUEST['distance']);
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $returnValue['data'] = $responseData;
                $returnValue['resultSize'] = count($responseData);
                $returnValue['totalClinics'] = $totalClinics;
                $returnValue['pageNumber'] = $pageNumber;
                $returnValue['pageSize'] = $pageSize;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in Clinics Data List");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }

    //6 Clinics Details for Zip code and Location List------------
    public function getClinicsDetailForZipandLocation() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        $responseData = "failure";

        try {
            $model = $this->getModel("mobileData");
            $zip = $_REQUEST['zip'];

            if (!empty($_REQUEST['givenLatitude']) && !empty($_REQUEST['givenLongitude'])) {
                $userLatitude = $_REQUEST['givenLatitude'];
                $userLongitude = $_REQUEST['givenLongitude'];
            } else {
                $savedLatLongDetails = $model->getLatAndLonFromDB($zip);

                if (empty($savedLatLongDetails)) { //Not stored in db previously
                    /* $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $zip . '&sensor=false';
                      $parser = simplexml_load_file($url);
                      $userLatitude = $parser->{'result'}->{'geometry'}->{'location'}->{'lat'};
                      $userLongitude = $parser->{'result'}->{'geometry'}->{'location'}->{'lng'}; */

                    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $zip . '&sensor=false';
                    $geocodeResponse = file_get_contents($url);
                    $geoCodeDetails = json_decode($geocodeResponse);                    

                    if ($geoCodeDetails->status == "OK") {
                        $userLatitude = $geoCodeDetails->results[0]->geometry->location->lat;
                        $userLongitude = $geoCodeDetails->results[0]->geometry->location->lng;

                        $storeLocationDetails = $model->storeLatAndLonInDB($userLatitude, $userLongitude, $zip); //Store in db table for future purpose    
                    }
                } else {
                    $userLatitude = $savedLatLongDetails[0]->lat;
                    $userLongitude = $savedLatLongDetails[0]->lng;
                }
            }

            $responseData = $model->contentClinicsDetailsForLatandLng($userLatitude, $userLongitude, $_REQUEST['distance']);

            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $returnValue['latitude'] = $userLatitude;
                $returnValue['longitude'] = $userLongitude;
                $returnValue['data'] = $responseData;
                $returnValue['searchKeyword'] = $zip;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in Publish news");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }
    
    //7 About Us Details for Landing Page------------
   /* public function getAboutUsforIndexPage() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentAboutUsDetails();
            $membersResponseData = $model->contentMembersDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $responseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    $string = $responseData->introtext;
                    $string = substr($string,0, strpos($string, "</p>")+4);
                    $introtext = str_replace("<p>", "", str_replace("<p/>", "", $string));
        
                } else {
                    $doc = new DOMDocument();
                    
                    $string = $responseData->introtext;
                    $string = substr($string,0, strpos($string, "</p>")+4);
                    $introtext = str_replace("<p>", "", str_replace("<p/>", "", $string));
                    
                    $doc->loadHTML($introtext);
                    $doc->preserveWhiteSpace = false;

                    foreach ($doc->getElementsByTagName('a') as $anchor) {
                        $link = $anchor->getAttribute('href');
                        $anchor->setAttribute('href', '#');
                        $anchor->setAttribute('onclick', 'openInChildBrowser("' . $link . '")');
                        $anchor->removeAttribute('target');
                    }
                    
                    $introtext = $doc->saveHTML();
                }


                $response['introtext'] = $introtext;
                $returnValue['data'] = $response;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }
    */
    
    
    /* public function getIntroContentforIndexPage() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentAboutUsDetails();
            $membersResponseData = $model->contentMembersDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
               // $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $responseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    $string = $responseData->introtext;
                    $string = substr($string,0, strpos($string, "</p>")+4);
                    $introtext = str_replace("<p>", "", str_replace("<p/>", "", $string));
        
                } else {
                    $doc = new DOMDocument();
                    
                    $string = $responseData->introtext;
                    $string = substr($string,0, strpos($string, "</p>")+4);
                    $introtext = str_replace("<p>", "", str_replace("<p/>", "", $string));
                    
                    $doc->loadHTML($introtext);
                    $doc->preserveWhiteSpace = false;

                    foreach ($doc->getElementsByTagName('a') as $anchor) {
                        $link = $anchor->getAttribute('href');
                        $anchor->setAttribute('href', '#');
                        $anchor->setAttribute('onclick', 'openInChildBrowser("' . $link . '")');
                        $anchor->removeAttribute('target');
                    }
                    
                    $introtext = $doc->saveHTML();
                }


            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        return $introtext;
        //echo json_encode($returnValue);
        $mainframe->close();
    }
    */

//7 About Us Details for Landing Page------------
     public function getIntroContentforIndexPage() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentHomeDetails();
            //$membersResponseData = $model->contentMembersDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
               // $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $responseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    //$string = $responseData->introtext;
                    //$string = substr($string,0, strpos($string, "</p>")+4);
                    //$introtext = str_replace("<p>", "", str_replace("<p/>", "", $string));
                    $introtext = $responseData->introtext;
        
                } else {
                    $doc = new DOMDocument();
                    
                    //$string = $responseData->introtext;
                    //$string = substr($string,0, strpos($string, "</p>")+4);
                    //$introtext = str_replace("<p>", "", str_replace("<p/>", "", $string));
                    $introtext = $responseData->introtext;
                    $doc->loadHTML($introtext);
                    $doc->preserveWhiteSpace = false;

                    foreach ($doc->getElementsByTagName('a') as $anchor) {
                        $link = $anchor->getAttribute('href');
                        $anchor->setAttribute('href', '#');
                        $anchor->setAttribute('onclick', 'openInChildBrowser("' . $link . '")');
                        $anchor->removeAttribute('target');
                    }
                    
                    $introtext = $doc->saveHTML();
                }


            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        
        $response['introtext'] = $introtext;
        $returnValue['data'] = $response;
        $returnValue['status'] = "success";
        
        //return $returnValue;
        echo json_encode($returnValue);
        $mainframe->close();
    } 

//8 Members Details for Landing Page------------
    public function getMembers() {
        //$returnValue = array();
        //$returnValue['status'] = "failure";
        $returnValue = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            //$responseData = $model->contentAboutUsDetails();
            $membersResponseData = $model->contentMembersDetails();
            if ($membersResponseData == 'failure' || $membersResponseData == 'error') {
                $returnValue = "failure";
            } else {
                $response = array();
                $response['title'] = $membersResponseData->title;

                /*if ($_REQUEST['deviceAgent'] == 'PC') {
                    $finalValue = $membersResponseData->introtext;
                } else {*/

                    $doc = new DOMDocument();

                    preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $membersResponseData->introtext, $matches, PREG_SET_ORDER);

                    $finalValue="";
                    $m=0;    
                    foreach ($matches as $val) {
                        
                        if($val[2]=="h3"){
                            if(strip_tags($val[3])){
                            $padding = "";
                            if($m!=0){$finalValue .= "</ul></div>"; $padding = "style='padding-top:30px;'"; }
                            
                            $finalValue .= "<div class='span12' ".$padding."><div class='members_title'><label>".strip_tags($val[3])."</label></div><ul class='members_list'>";
                           }
                           
                            $m++;
                        }else if($val[2]=="p"){
                            
                            $doc->loadHTML($val[0]);
                            $doc->preserveWhiteSpace = false;
                    
                            $link = "";
                            $params2 = $doc->getElementsByTagName('img');
                            $params3 = $doc->getElementsByTagName('a');

                            $j = 0;
                            foreach ($params3 as $param3) {
                                if ($param3 && $j == 0) {
                                    $link = $param3->getAttribute('href');
                                    $j++;
                                }
                            }


                            $jj = 0;
                            foreach ($params2 as $param2) {
                                $imgPath = $param2->getAttribute('src');
                                $altText = $param2->getAttribute('alt');
                                if ($param2 && $jj == 0 && $imgPath != "plugins/editors/jce/tiny_mce/plugins/filemanager/img/ext/pdf_small.gif") {


                                    if($link){
                                        $link = str_replace("/", "\/", $link);
                                        $anchor1="<a href='#' onclick='openInChildBrowser(\"$link\")'>"; $anchor2="</a>";
                                    }else{
                                        $anchor1=""; $anchor2="";
                                    }

                                    $finalValue .= "<li>".$anchor1."<img src='" . JURI::base() . $imgPath . "' alt='".$altText."' align='absmiddle' width='75px' height='30px'>".$anchor2."</li>";

                                    $jj++;
                                }
                            }                            
                        }                        
                    }
                //}

                //$response['introtext1']=$finalValue;
                //$response['introtext']=$this->getIntroContentforIndexPage();
                
                //$response['memberlogos'] = $finalValue."</ul>";
                
                $returnValue = $finalValue."</ul>";
                //$returnValue['status'] = "success";
                
                //$teest = $finalValue."</ul>";
                //$teest = "dddddd";
                //cho json_encode($teest);
                
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        return $returnValue;
        //echo json_encode($returnValue);
        $mainframe->close();
    }
    
    public function getAboutUsforIndexPage() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentAboutUsDetails();
            $membersResponseData = $model->contentMembersDetails();
            if ($membersResponseData == 'failure' || $membersResponseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $membersResponseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    $finalValue = $responseData->introtext;
                } else {

                    $doc = new DOMDocument();
                  
                    $finalValue = "";

                    preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $membersResponseData->introtext, $matches, PREG_SET_ORDER);

                    $finalValue="";
                    $m=0;    
                    foreach ($matches as $val) {
                        
                        if($val[2]=="h3"){
                            if(strip_tags($val[3])){
                            $padding = "";
                            if($m!=0){$finalValue .= "</ul></div>"; $padding = "style='padding-top:30px;'"; }
                            
                            $finalValue .= "<div class='span12' ".$padding."><div class='members_title'><label>".strip_tags($val[3])."</label></div><ul class='members_list'>";
                           }
                           
                            $m++;
                        }else if($val[2]=="p"){
                            
                            $doc->loadHTML($val[0]);
                            $doc->preserveWhiteSpace = false;
                    
                                $link = "";
                                $params2 = $doc->getElementsByTagName('img');
                                $params3 = $doc->getElementsByTagName('a');

                                $j = 0;
                                foreach ($params3 as $param3) {
                                    if ($param3 && $j == 0) {
                                        $link = $param3->getAttribute('href');
                                        $j++;
                                    }
                                }


                                $jj = 0;
                                foreach ($params2 as $param2) {
                                    $imgPath = $param2->getAttribute('src');
                                    $altText = $param2->getAttribute('alt');
                                    if ($param2 && $jj == 0 && $imgPath != "plugins/editors/jce/tiny_mce/plugins/filemanager/img/ext/pdf_small.gif") {


                                        if($link){
                                            $link = str_replace("/", "\/", $link);
                                            $anchor1="<a href='#' onclick='openInChildBrowser(\"$link\")'>"; $anchor2="</a>";
                                        }else{
                                            $anchor1=""; $anchor2="";
                                        }

                                        $finalValue .= "<li>".$anchor1."<img src='" . JURI::base() . $imgPath . "' alt='".$altText."' align='absmiddle' width='75px' height='30px'>".$anchor2."</li>";

                                        $jj++;
                                    }
                                }


                            
                        }
                        //$x .= "matched: " . $val[0] . "------";
                       // echo "part 1: " . $val[1] . "\n";
                       // $x .= "part 2: " . $val[2] . "--";
                      //  echo "part 3: " . $val[3] . "\n";
                       // echo "part 4: " . $val[4] . "\n\n";
                        
                       
                    }


                }

                //$response['introtext1']=$finalValue;
                $response['introtext']=$this->getIntroContentforIndexPage();
                $response['memberlogos'] = $finalValue."</ul>";
                
                $returnValue['data'] = $response;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }
    
    //8 About Our Clinics Details------------
    public function getAboutOurClinics() {       
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentAboutOurClinicsDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $responseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    $introtext = $responseData->introtext;
                } else {
                    $doc = new DOMDocument();
                    $doc->loadHTML($responseData->introtext);
                    $doc->preserveWhiteSpace = false;

                    foreach ($doc->getElementsByTagName('a') as $anchor) {
                        $link = $anchor->getAttribute('href');
                        $anchor->setAttribute('href', '#');
                        $anchor->setAttribute('onclick', 'openInChildBrowser("' . $link . '")');
                        $anchor->removeAttribute('target');
                    }
                    
                    $introtext = $doc->saveHTML();
                }


                $response['introtext'] = $introtext;
                $returnValue['data'] = $response;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }
    
    
    //9 FAQs Details------------
    public function getFAQs() {       
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentFAQsDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $responseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    $introtext = $responseData->introtext;
                } else {
                    $doc = new DOMDocument();
                    $doc->loadHTML($responseData->introtext);
                    $doc->preserveWhiteSpace = false;
                    
                    $out = "";
                    $params = $doc->getElementsByTagName('dl'); // Find dl tag
                    $k=0;
                    foreach ($params as $param) //go to each dl tag 1 by 1
                    {
                        $params2 = $params->item($k)->getElementsByTagName('dt'); //dig dt with in dl
                        $params3 = $params->item($k)->getElementsByTagName('dd'); //dig dd with in dl
                          
                        $i=0; // values is used to iterate dt 
                        foreach ($params2 as $p) {
                            $out .= "<a onclick='displayAnswer(".$k.");'>Q: ".$params2->item($i)->nodeValue."</a><br />"; //get dt Value
                            $out .= "<span id='A".$k."' style='display:none;'><br />A: ".$params3->item($i)->nodeValue."<br /><br /></span><br />"; //get dd Value
                            $i++;
                        }
                           
                        $k++;
                    }
                 
                    
                     $introtext = $out;
                    
                   // $introtext = $doc->saveHTML();
                }


                $response['introtext'] = $introtext;
                $returnValue['data'] = $response;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }
    
    
    //2 About Us Details------------
    public function getVirtualTour() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentVirtualTourDetails();
            if ($responseData == 'failure' || $responseData == 'error') {
                $returnValue['status'] = "failure";
            } else {
                $response = array();
                $response['title'] = $responseData->title;

                if ($_REQUEST['deviceAgent'] == 'PC') {
                    $app = JFactory::getApplication();
                    $templateDir = JURI::base() . 'templates/' . $app->getTemplate();
           
                    $introtext = '<div><a onclick="virtualTourImages(\'virtual_tour_ext\');">Tour the Waiting Room | </a> | <a onclick="virtualTourImages(\'virtual_tour\');">Tour the Exam Room</a></div><div><div id="virtual_tour_ext"><div class="virtualimages">
                                                    <div class="tourinfo circle circle1" onclick="popoverText(\'circle1\');" 
data-container="body" data-toggle="popover" data-placement="right" data-content="This is Popover." 

><img src="'.$templateDir.'/images/info.png"></div>
                                                    <div class="tourinfo circle circle2"><img src="'.$templateDir.'/images/info_arrow.png"></div>
                                                    <div class="tourinfo circle circle3" onclick="popoverText(\'circle3\');" rel="popover"
   data-content="This is the body of Popover This is the body of Popover This is the body of Popover" data-placement="left"><img src="'.$templateDir.'/images/info.png"></div><img src="'.$templateDir.'/images/waitingroom.jpg"/></div>
       </div></div>
       
<div><div id="virtual_tour" style="display:none;"><div class="virtualimages">
                                                    <div class="tourinfo circle circle4" onclick="popoverText(\'circle4\');" rel="popover"
   data-content="This is the body of Popover This is the body of PopoverThis is the body of PopoverThis is the body of PopoverThis is the body of PopoverThis is the body of PopoverThis is the body of PopoverThis is the body of PopoverThis is the body of Popover"
   data-original-title="Creativity Tuts" data-placement="top"><img src="'.$templateDir.'/images/info.png"></div>
                                                    <div class="tourinfo circle circle5"><img src="'.$templateDir.'/images/info.png"></div>
                                                    <div class="tourinfo circle circle6" onclick="popoverText(\'circle3\');" rel="popover"
   data-content="This is the body of Popover This is the body of Popover This is the body of Popover" data-placement="left"><img src="'.$templateDir.'/images/info.png"></div><img src="'.$templateDir.'/images/examroom.jpg"/></div>
       </div></div>';
           
                } else {
                    $doc = new DOMDocument();
                    $doc->loadHTML($responseData->introtext);
                    $doc->preserveWhiteSpace = false;
                    
                    $app = JFactory::getApplication();
                    $templateDir = JURI::base() . 'templates/' . $app->getTemplate();                    
              
                    
                    $out = ""; $out1 = "";
                    $kk=0;
                    foreach ($doc->getElementsByTagName('h4') as $param) {
                        
                        if($kk<2){
                            
                           $params2 = $param->getElementsByTagName('a');
                           
                           $j=0;
                           $anchorId = "";
                           foreach ($params2 as $anchor) {                             
                               
                               if($j==0){$anchorId="virtual_tour_ext";$anchor->setAttribute('style', 'font-style:italic');}
                               else if($j==1){$anchorId="virtual_tour";}

                                $link = $anchor->removeAttribute('href');
                                $anchor->setAttribute('href', '#');
                                $anchor->setAttribute('class', $anchorId);
                                $anchor->setAttribute("onclick", "virtualTourImages('$anchorId')");
                            $j++;    
                            }
                            
                            $params3 = $param->getElementsByTagName('img');
                           
                            foreach ($params3 as $image) {
                                $path = $image->getAttribute('src');   
                                $image->setAttribute('src', JURI::base() . $path);                                
                                
                            }
                            
                            $val="";
                            if($kk==0){
                                $out .= strip_tags($param->c14n(), "<a>");
                            }else if($kk==1){
                                $out .= "<br /><br />".strip_tags($param->c14n(), "<img>")."<br /><br />";
                            }
                            
                        }
                        $kk++;
                    }
                    
                    $out .= $out1;
                    foreach ($doc->getElementsByTagName('div') as $divTag) {
                        
                        $info_checkin = ""; $info_door1 = ""; $info_monitor = "";
                        $info_wall = ""; $info_computer = ""; $info_floor = "";
                        foreach ($divTag->getElementsByTagName('div') as $divTagInner) {
                            
                            if($divTagInner->getAttribute('id')=="info_checkin"){  
                                $Pvalue = explode("<p>", $divTagInner->c14n());
                                $Pvalue1 = explode("</p>", $Pvalue[1]);
                                $info_checkin = $Pvalue1[0];
                            }
                            
                           
                            if($divTagInner->getAttribute('id')=="info_door1"){
                                $Pvalue = explode("<p>", $divTagInner->c14n());
                                $Pvalue1 = explode("</p>", $Pvalue[1]);
                               $info_door1 = $Pvalue1[0];
                            }
                            if($divTagInner->getAttribute('id')=="info_monitor"){
                                $Pvalue = explode("<p>", $divTagInner->c14n());
                                $Pvalue1 = explode("</p>", $Pvalue[1]);
                               $info_monitor = $Pvalue1[0];
                            }
                            
                            if($divTagInner->getAttribute('id')=="info_wall"){   
                                $Pvalue = explode("<p>", $divTagInner->c14n());
                                $Pvalue1 = explode("</p>", $Pvalue[1]);
                               $info_wall = $Pvalue1[0];
                            }
                            if($divTagInner->getAttribute('id')=="info_computer"){
                                $Pvalue = explode("<p>", $divTagInner->c14n());
                                $Pvalue1 = explode("</p>", $Pvalue[1]);
                               $info_computer = $Pvalue1[0];
                            }
                            if($divTagInner->getAttribute('id')=="info_floor"){
                                $Pvalue = explode("<p>", $divTagInner->c14n());
                                $Pvalue1 = explode("</p>", $Pvalue[1]);
                               $info_floor = $Pvalue1[0];
                            }
                            
                            
                        }
                      
                        $divTagText = $divTag->getAttribute('id');
                        
                        if($divTagText=="virtual_tour_ext" || $divTagText=="virtual_tour"){
                            
                             if($divTagText=="virtual_tour_ext"){
                                 
                                 $addInfoImages = '<div class="virtualimages">
                                                    <div class="tourinfo circle circle1"  
                                                    data-content="'.$info_checkin.'" data-placement="top"><img src="'.$templateDir.'/images/info.png"></div>
                                                    <div class="tourinfo circle circle2"
                                                    data-content="'.$info_door1.'" data-placement="top"><img src="'.$templateDir.'/images/info_arrow.png"></div>
                                                    <div class="tourinfo circle circle3" 
                                                    data-content="'.$info_monitor.'" data-placement="left"><img src="'.$templateDir.'/images/info.png"></div>';
                                 
                                 $imgPath = $templateDir."/images/waitingroom.jpg";
                                 $style="style='padding : 0px; position:relative;'";
                             } else if($divTagText=="virtual_tour"){
                                 
                                 $addInfoImages = '<div class="virtualimages">
                                                    <div class="tourinfo circle circle4"
                                                    data-content="'.$info_floor.'" data-placement="top"><img src="'.$templateDir.'/images/info.png"></div>
                                                    <div class="tourinfo circle circle5" 
                                                    data-content="'.$info_computer.'" data-placement="top"><img src="'.$templateDir.'/images/info.png"></div>
                                                    <div class="tourinfo circle circle6" 
   data-content="'.$info_wall.'" data-placement="top"><img src="'.$templateDir.'/images/info.png"></div>';
                                 
                                 $imgPath = $templateDir."/images/examroom.jpg";
                                 $style="style='padding : 0px; position:relative; display:none;'";
                             }
                             
                            $out.="<div id='".$divTagText."' ".$style.">".$addInfoImages."<img src='". $imgPath."'></div></div>";                          
                        }                        
                        
                    }                 
                    
                    $introtext=$out;
                }
                
                $introtext = str_replace("Roll your mouse over the", "Tap on", $introtext);

                $response['introtext'] = $introtext;
                $returnValue['data'] = $response;
                $returnValue['status'] = "success";
            }
        } catch (Exception $ex) {
            JError::raiseError(500, "Error Occured in About Us");
            $returnValue['status'] = "failure";
        }
        echo json_encode($returnValue);
        $mainframe->close();
    }

}

?>
