<?php
defined("_JEXEC") or die("Restricted access");
jimport("joomla.application.component.model");
jimport('joomla.html.pagination');

class mobileModelMobileData extends JModel {
    //1 Partners Details------------
    public function contentDetails() {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query = "select title,introtext from #__content where id=15";
            $db->setQuery($query);
            $returnValue = $db->loadObject();
        } catch (Exception $ex) {
            $returnValue = "error";
        }
        return $returnValue;
    }

    //2 About Us Details------------
    public function contentAboutUsDetails() {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query = "select title,introtext from #__content where id=4";
            $db->setQuery($query);
            $returnValue = $db->loadObject();
        } catch (Exception $ex) {
            $returnValue = "error";
        }
        return $returnValue;
    }

    //3 Clinics Details for Lat and Lng------------6 Clinics Details for Zip code and Location List------------
    public function contentClinicsDetailsForLatandLng($lat, $lng,$distance) {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query = "SELECT lp.id,lp.name,lp.address,lp.lat,lp.lng,trim(lp.phone) as phone,c.name as Category, round(( 3959 * acos( cos( radians('$lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( lat ) ) ) ),2) AS distance
                                    FROM #__storelocator as lp, #__storelocator_cat as c WHERE lp.published = 1 AND lp.access <= 1 AND lp.catId=c.id
                                    HAVING distance < $distance ORDER BY distance ASC";
            $db->setQuery($query);
            $returnValue = $db->loadObjectList();
        } catch (Exception $ex) {
            $returnValue = "error";
        }
        return $returnValue;
    }

    //4 Clinics Detail for Id------------
    public function contentClinicsDetailForId($id) {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query = "SELECT lp.id,lp.name,lp.address,lp.lat,lp.lng,trim(lp.phone) as phone,c.name as Category,website
                                    FROM #__storelocator as lp, #__storelocator_cat as c WHERE lp.id=$id AND lp.published = 1 AND lp.access <= 1 AND lp.catId=c.id";
            $db->setQuery($query);
            $returnValue = $db->loadObjectList();
        } catch (Exception $ex) {
             $returnValue = "error";
        }
        return $returnValue;
    }

    //5 Clinics Details for List pages------------
    public function contentClinicsDetailForList($startPage, $endPage) {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query = "SELECT lp.id,lp.name,lp.address,lp.lat,lp.lng,trim(lp.phone) as phone,c.name as Category
                                    FROM #__storelocator as lp, #__storelocator_cat as c WHERE lp.published = 1 AND lp.access <= 1 AND lp.catId=c.id
                                        ORDER BY lp.id LIMIT $startPage,$endPage";
            $db->setQuery($query);
            $returnValue = $db->loadObjectList();
        } catch (Exception $ex) {
            $returnValue = "error";
        }
        return $returnValue;
    }
    //6 Total Clinics========
    public function getTotalClinics() {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query = "SELECT count(*) as totalClinics FROM #__storelocator as lp WHERE lp.published = 1 AND lp.access <= 1";
            $db->setQuery($query);
            $returnValue = $db->loadObject();
        } catch (Exception $ex) {
            $returnValue = "error";
        }
        return $returnValue;
    }

    /*
     * @praveen New Functionality to Maps
     */
    
    public function getLatAndLonFromDB($zip) {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query = "SELECT * from #__get_latitude_longitude where address='$zip' limit 1";
            
            $db->setQuery($query);
            $returnValue = $db->loadObjectList();
            
        } catch (Exception $ex) {
            $returnValue = "error";
        }
        return $returnValue;
    }

    public function storeLatAndLonInDB($userLatitude,$userLongitude,$zip) {
        $returnValue = "failure";
        try {
            $db = $this->getDBO();
            $query= "insert into #__get_latitude_longitude(lat,lng,address) values('".addslashes($userLatitude)."','".addslashes($userLongitude)."','".addslashes($zip)."')";
            $db->setQuery($query);
	    $db->query();          

        } catch (Exception $ex) {
            $returnValue = "error";
        }
        return $returnValue;
    }

}
