<?php
defined("_JEXEC") or die("Restricted access");
jimport("joomla.application.component.controller");

class mobileController extends JController {

    //1 Partners Details------------
    public function getPartners() {
        $returnValue = array();
        $returnValue['status'] = "failure";
        global $mainframe;
        $mainframe = JFactory::getApplication();
        try {
            $model = $this->getModel("mobileData");
            $responseData = $model->contentDetails();
            if($responseData=='failure' || $responseData=='error'){
                $returnValue['status'] = "failure";
            } else{
                $partnerLogos = array();

                $doc = new DOMDocument();
                $doc->loadHTML($responseData->introtext);
                $doc->preserveWhiteSpace = false;
                $partnerLogosSrc = $doc->getElementsByTagName('img');

                foreach ($partnerLogosSrc as $partnerLogo) {
                    $partnerLogos[]['logo'] = $partnerLogo->getAttribute('src');
                }
                $returnValue['data'] = $partnerLogos;
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
            $model = $this->getModel("mobileData");
            $responseData = $model->contentAboutUsDetails();
            if($responseData=='failure' || $responseData=='error'){
                $returnValue['status'] = "failure";
            } else{
                $returnValue['data'] = $responseData;
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
            $responseData = $model->contentClinicsDetailsForLatandLng($_REQUEST['lat'], $_REQUEST['lng'], $_REQUEST['distance']);
            if($responseData=='failure' || $responseData=='error'){
                $returnValue['status'] = "failure";
            } else{
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
            if($responseData=='failure' || $responseData=='error'){
                $returnValue['status'] = "failure";
            } else{
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
            $totalClinics = $model->getTotalClinics();
            $responseData = $model->contentClinicsDetailForList(($pageNumber * $pageSize), $pageSize);
            if($responseData=='failure' || $responseData=='error'){
                $returnValue['status'] = "failure";
            } else{
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
        try {
            $zip = $_REQUEST['zip'];
            $url = 'http://maps.googleapis.com/maps/api/geocode/xml?address=' . $zip . '&sensor=false';

            $parser = simplexml_load_file($url);
            $userLatitude = $parser->{'result'}->{'geometry'}->{'location'}->{'lat'};
            $userLongitude = $parser->{'result'}->{'geometry'}->{'location'}->{'lng'};
            $model = $this->getModel("mobileData");
            $responseData = $model->contentClinicsDetailsForLatandLng($userLatitude, $userLongitude, $_REQUEST['distance']);
            if($responseData=='failure' || $responseData=='error'){
                $returnValue['status'] = "failure";
            } else{
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

}
?>