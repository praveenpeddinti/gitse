function showIndexPage() {
    showSplashScreenLoadingIndicator();
    
    //ajaxRequest("getAboutUsforIndexPage", "deviceAgent="+deviceAgent, showIndexPageResponseHandler);
    ajaxRequest("getIntroContentforIndexPage", "deviceAgent="+deviceAgent, showIndexPageResponseHandler);    
}

function showIndexPageResponseHandler(showIndexPageResponse){    
    if(showIndexPageResponse.status == "success"){
        //my.utils.renderViewTo('Views/members.html', showIndexPageResponse, 'mainContentDiv', function(data){
        my.utils.renderViewTo('Views/index.html', showIndexPageResponse, 'mainContentDiv', function(data){
            
            refreshBodyScroll();            
            splashIntervalId = setTimeout( loadDashboard, timeInterval);
            hideSplashScreenLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
         ShowMessage('errorModal', 'Home', "<li class='error'>Unable to get Index Page Content.</li>", true, false);
    }  
    
    
}

function loadDashboard(){    
    clearInterval(splashIntervalId);
    loadClinics('Map');
}

/* Display Clinics Starts Here */

function searchClinicsInCurrentLocation(position){
    globalspace.listLatitude = position.coords.latitude;
    globalspace.listLongitude = position.coords.longitude;   
    queryString = "distance="+distance+"&lat="+position.coords.latitude+"&lng="+position.coords.longitude;
    ajaxRequest("getClinicsDetails", queryString, loadClinicsOnMapResponseHandler);
}

function searchClinics(keyword){
    var searchKeyword;
    if(keyword != undefined)
        searchKeyword = keyword;
    else
        searchKeyword = $("#searchClinicsKeyword").val().trim();
    
    if(searchKeyword == ""){
        ShowMessage('errorModal', 'Search Clinics Status', "<li class='error'>Please enter either zip code or location name.</li>" , true, false);
        return false;
    } else{
        geoCodeGivenAddress(searchKeyword, getClinicsForZipOrLocationHandler);
    }
}

function getClinicsForZipOrLocationHandler(searchKeyword, getClinicsForZipOrLocationResponse){
    showLoadingIndicator();    
    if(getClinicsForZipOrLocationResponse != ""){
      
        globalspace.listLatitude = getClinicsForZipOrLocationResponse.lat();
        globalspace.listLongitude = getClinicsForZipOrLocationResponse.lng();
        
        globalspace.searchKeyword = searchKeyword;
        
        queryString = "distance="+ distance +"&zip="+searchKeyword+"&givenLatitude="+ getClinicsForZipOrLocationResponse.lat() +"&givenLongitude="+ getClinicsForZipOrLocationResponse.lng();        
        ajaxRequest("getClinicsDetailForZipandLocation", queryString, loadClinicsOnMapResponseHandler);
    } else{      
        queryString = "distance="+distance+"&zip="+searchKeyword;
        ajaxRequest("getClinicsDetailForZipandLocation", queryString, loadClinicsOnMapResponseHandler);
    }
    
    $('#backButton').attr('onclick',"loadMapWithSearchResults()");
}

function loadClinics(target){    
    $("#clinicsTab").addClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#faqsTab").removeClass("active");
    $("#aboutClinicsTab").removeClass("active");    
    $("#virtualTourTab").removeClass("active");
    $("#webinarsTab").removeClass("active");
    
    $("#clinics_Map_Switch").removeAttr('checked');
    $("#clinics_List_Switch").removeAttr('checked');
    $("#backButton").hide();
    $("#shareIcon").hide();
    if(target == "Map"){
        $("#clinics_Map_Switch").attr('checked', true);
        $('#backButton').attr('onclick',"loadClinics('Map')");
        if(index == 0){
            showSplashScreenLoadingIndicator();
        } else{
            showLoadingIndicator();
            
        }
        //alert(index+"====="+globalspace.searchClinicsKeyword);
        if(globalspace.searchClinicsKeyword)
        {
            searchClinics(globalspace.searchClinicsKeyword);
        }else{         
            getCurrentLocationLatLong();
        }
        
    } else if(target == "List"){
        $("#clinics_List_Switch").attr('checked', true);
        $('#backButton').attr('onclick',"loadClinics('List')");
        loadClinicsAsList(true);
    }
}

function loadClinicsOnMapResponseHandler(loadClinicsOnMapResponse){
    if(loadClinicsOnMapResponse.status == "success"){
        if(index == 0){
            $("#splash_header").hide();
            $("#wrapper").removeClass("splash_header_top");
            $("#wrapper").addClass("wrapper_top");
            $("#header").show();
            $("#footer").show();            
            hideSplashScreenLoadingIndicator();
        }
        
        if(loadClinicsOnMapResponse.latitude == null || loadClinicsOnMapResponse.longitude == null){
            ShowMessage('errorModal', 'Search Clinics Status', "<li class='error'>Sorry! Unable to get given zip / location details.</li>" , true, false);
            //getCurrentLocationLatLong();
        } else{
            my.utils.renderViewTo('Views/clinicsOnMap.html', loadClinicsOnMapResponse, 'mainContentDiv', function(){
                if(loadClinicsOnMapResponse.searchKeyword != undefined){
                    $("#searchClinicsKeyword").val(loadClinicsOnMapResponse.searchKeyword);
                    globalspace.searchClinicsKeyword = loadClinicsOnMapResponse.searchKeyword;
                }            
            
                showMap("map_canvas", loadClinicsOnMapResponse.data, loadClinicsOnMapResponse.latitude, loadClinicsOnMapResponse.longitude);
                scrollToTop();
                refreshBodyScroll();
            });
        }
        
        if(index == 1){
            hideLoadingIndicator();
        }
        
        index = 1; //To handle header & footer for every request.
            
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Search Clinics Status', "<li class='error'>Unable to get clinics.</li>" , true, false);
    }
}

function loadMapWithSearchResults(){
    $("#shareIcon").hide();
    $("#backButton").hide();
    showLoadingIndicator();
    searchClinics(globalspace.searchClinicsKeyword);
}

function loadClinicsAsList(reset){
    var pageNumber = 0;
    var pageSize = getPageSize("clinics");
    if(reset == true){
        pageNumber = 0;
        globalspace.isClinicsReachedEnd = false;
        $("#existingClinicsListDiv").empty();
    } else {
        pageNumber = parseInt(globalspace.clinicsCurrentPageNumber) + 1;    
    }
    
    if(globalspace.isClinicsCurrentlyLoading != true && globalspace.isClinicsReachedEnd != true){
        globalspace.isClinicsCurrentlyLoading = true;
        showLoadingIndicator();
        queryString = "startpage="+pageNumber+"&endpage="+pageSize+"&distance="+ distance+"&givenLatitude="+ globalspace.listLatitude +"&givenLongitude="+ globalspace.listLongitude;
        ajaxRequest("getClinicsDetailList", queryString, loadClinicsAsListResponseHandler); 
    }
}

function loadClinicsAsListResponseHandler(loadClinicsAsListResponse){
    if(loadClinicsAsListResponse.status == "success"){
    	if(index == 0){
            $("#splash_header").hide();
            $("#wrapper").removeClass("splash_header_top");
            $("#wrapper").addClass("wrapper_top");
            $("#header").show();
            $("#footer").show();
            hideSplashScreenLoadingIndicator();
        }
        
        globalspace.clinicsCurrentPageNumber = loadClinicsAsListResponse.pageNumber;        
        var targetDiv = '', append = '';
        
        if (loadClinicsAsListResponse.pageNumber == 0){
            targetDiv = 'mainContentDiv'
            append = false;
        } else{
            targetDiv = 'existingClinicsListDiv';
            append = true;
        }
        
        my.utils.renderViewTo('Views/clinicsList.html', loadClinicsAsListResponse, targetDiv, function(){
            
            if(loadClinicsAsListResponse.pageNumber == 0 && loadClinicsAsListResponse.resultSize == 0){
                $("#noClinicsFoundDiv").show();
                $("#existingClinicsList").hide();
            } else{
                $("#existingClinicsList").show();
                $("#noClinicsFoundDiv").hide();
            }
            
            if(loadClinicsAsListResponse.pageNumber == 0){
                initializeBodyScroll(null, loadClinicsAsList);
            } else{//initializeBodyScroll
                scrollToTop();
                refreshBodyScroll();
            }
            
            if(loadClinicsAsListResponse.resultSize < loadClinicsAsListResponse.pageSize){
                globalspace.isClinicsReachedEnd = true;
            }
            
            $('#clinicsLoading').hide();
            
            hideLoadingIndicator();        
            index = 1; //To handle header & footer for every request.
            
        }, append);
        
        globalspace.isClinicsCurrentlyLoading = false;
        
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Get Clinics List Status', "<li class='error'>Unable to get clinics list.</li>" , true, false);
    }
}

function loadClinicDetailPage(clinicId){
    showLoadingIndicator();
    globalspace.isClinicsReachedEnd = true; //To prevent clinics loading while scrolling and clicking at a time.
    queryString = "id="+clinicId;
    ajaxRequest("getClinicDetailsById", queryString, loadClinicDetailPageResponseHandler);
}

function loadClinicDetailPageResponseHandler(loadClinicDetailPageResponse){
    if(loadClinicDetailPageResponse.status == "success"){
        my.utils.renderViewTo('Views/clinicDetailPage.html', loadClinicDetailPageResponse, 'mainContentDiv', function(){
            $("#backButton").show();
            $("#clinicsSwitchDiv").hide();
            $("#headerLogo").show();
            $("#shareIcon").show();
            refreshBodyScroll();
            hideLoadingIndicator();
        });        
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Clinic Detail Page Status', "<li class='error'>Unable to navigate to clinic detail page.</li>" , true, false);
    }
}

function showShareActionsModal(){
    $('#shareActionsModal').modal('show');
}

function closeShareActionsModal(){
    $('#shareActionsModal').modal('hide');
}

/* Display Clinics Ends Here */

/* Display Partners Starts Here */

function loadPartners(){
    globalspace.searchClinicsKeyword="";
    $("#searchClinicsKeyword").val('');
    
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").addClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#faqsTab").removeClass("active");
    $("#aboutClinicsTab").removeClass("active");    
    $("#virtualTourTab").removeClass("active");
    $("#webinarsTab").removeClass("active");
    
    ajaxRequest("getPartners", "", loadPartnersResponseHandler);
}

function loadPartnersResponseHandler(loadPartnersResponse){
    //alert(loadPartnersResponse.membersLogo);
    if(loadPartnersResponse.status == "success"){
        loadPartnersResponse.site_base_url = site_base_ur;
        loadPartnersResponse.deviceAgent = deviceAgent;
        my.utils.renderViewTo('Views/members.html', loadPartnersResponse, 'mainContentDiv', function(){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            scrollToTop();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Partners', "<li class='error'>Unable to get partners list.</li>", true, false);
    }
}

/* Display Partners Ends Here */

/* Display About CCA Starts Here */

function loadAboutCCA(){
    globalspace.searchClinicsKeyword="";
    $("#searchClinicsKeyword").val('');
    
    showLoadingIndicator();   
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").addClass("active");
    $("#faqsTab").removeClass("active");
    $("#aboutClinicsTab").removeClass("active");    
    $("#virtualTourTab").removeClass("active");
    $("#webinarsTab").removeClass("active");
    
    
    ajaxRequest("getAboutUs", "deviceAgent="+deviceAgent, loadAboutCCAResponseHandler);
}

function loadAboutCCAResponseHandler(loadAboutCCAResponse){
    if(loadAboutCCAResponse.status == "success"){
        my.utils.renderViewTo('Views/aboutCCA.html', loadAboutCCAResponse, 'mainContentDiv', function(data){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            scrollToTop();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'About CCA', "<li class='error'>Unable to get about cca.</li>", true, false);
    }
}

/* Display About CCA Ends Here */

function loadHomePage(){
    globalspace.searchClinicsKeyword="";
    $("#searchClinicsKeyword").val('');
    showLoadingIndicator();    
    //ajaxRequest("getAboutUsforIndexPage", "deviceAgent="+deviceAgent, loadMembersResponseHandler);
    ajaxRequest("getIntroContentforIndexPage", "deviceAgent="+deviceAgent, loadHomePageResponseHandler);    
}

function loadHomePageResponseHandler(loadHomePageResponse){  
    if(loadHomePageResponse.status == "success"){
        //my.utils.renderViewTo('Views/members.html', loadMembersResponse, 'mainContentDiv', function(data){
        my.utils.renderViewTo('Views/index.html', loadHomePageResponse, 'mainContentDiv', function(data){
            
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();

            $("#clinicsTab").removeClass("active");
            $("#partnersTab").removeClass("active");
            $("#aboutCCATab").removeClass("active");            
            $("#faqsTab").removeClass("active");
            $("#aboutClinicsTab").removeClass("active");    
            $("#virtualTourTab").removeClass("active");
            $("#webinarsTab").removeClass("active");
            
            scrollToTop();
            refreshBodyScroll();
            hideLoadingIndicator();
            
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Home', "<li class='error'>Unable to get Index Page Content.</li>", true, false);
    }
}
    
/* Display About Our Clinics Starts Here */

function loadAboutOurClinics(){
    globalspace.searchClinicsKeyword="";
    $("#searchClinicsKeyword").val('');
    
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#faqsTab").removeClass("active");
    $("#aboutClinicsTab").addClass("active");    
    $("#virtualTourTab").removeClass("active");
    $("#webinarsTab").removeClass("active");
    
    ajaxRequest("getAboutOurClinics", "deviceAgent="+deviceAgent, loadAboutOurClinicsResponseHandler);
}

function loadAboutOurClinicsResponseHandler(loadAboutOurClinicsResponse){
    if(loadAboutOurClinicsResponse.status == "success"){
        my.utils.renderViewTo('Views/aboutOurClinics.html', loadAboutOurClinicsResponse, 'mainContentDiv', function(data){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            scrollToTop();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'About Our Clinics', "<li class='error'>Unable to get about our clinics.</li>", true, false);
    }
}

/* Display About Our Clinics Ends Here */


/* Display FAQs Starts Here */

function loadFAQs(){
    globalspace.searchClinicsKeyword="";
    $("#searchClinicsKeyword").val('');
    
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#faqsTab").addClass("active");
    $("#aboutClinicsTab").removeClass("active");    
    $("#virtualTourTab").removeClass("active");
    $("#webinarsTab").removeClass("active");
    
    ajaxRequest("getFAQs", "deviceAgent="+deviceAgent, loadFAQsResponseHandler);
}

function loadFAQsResponseHandler(loadFAQsResponse){  
    if(loadFAQsResponse.status == "success"){
        my.utils.renderViewTo('Views/faqs.html', loadFAQsResponse, 'mainContentDiv', function(data){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            scrollToTop();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'FAQs', "<li class='error'>Unable to get FAQs.</li>", true, false);
    }
}

/* Display FAQs Ends Here */


/* Display Answer Starts Here */
function displayAnswer(k){
    $("#A"+k).toggle();
    refreshBodyScroll();
}
/* Display Answer Ends Here */


/* Display Virtual Tour Starts Here */

function loadVirtualTour(){
    globalspace.searchClinicsKeyword="";
    $("#searchClinicsKeyword").val('');
    
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#faqsTab").removeClass("active");
    $("#aboutClinicsTab").removeClass("active");    
    $("#virtualTourTab").addClass("active");
    $("#webinarsTab").removeClass("active");
    
    ajaxRequest("getVirtualTour", "deviceAgent="+deviceAgent, loadVirtualTourResponseHandler);
}

function loadVirtualTourResponseHandler(loadVirtualTourResponse){
    if(loadVirtualTourResponse.status == "success"){       
        my.utils.renderViewTo('Views/virtualTour.html', loadVirtualTourResponse, 'mainContentDiv', function(data){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            scrollToTop();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Virtual Tour', "<li class='error'>Unable to get virtual tour.</li>", true, false);
    }
}

/* Display Virtual Tour Ends Here */


function virtualTourImages(id){
    scrollToTop();
    refreshBodyScroll();
    if(id=="virtual_tour_ext"){
        $("#virtual_tour").hide('slow');
        $("#virtual_tour_ext").show('slow');
        
        $("#virtual_tour_ext").css('overflow', 'visible');
        $(".virtual_tour_ext").css('font-style', 'italic');
        $(".virtual_tour").css('font-style', 'normal');
       
        $(".circle1").show(700);
        $(".circle2").show(700);
        $(".circle3").show(700);
        $(".circle4").hide();
        $(".circle5").hide();
        $(".circle6").hide();

    }

    else if(id=="virtual_tour"){
        $("#virtual_tour_ext").hide('slow');
        $("#virtual_tour").show('slow');
        
        $("#virtual_tour").css('overflow', 'visible');
        $(".virtual_tour").css('font-style', 'italic');
        $(".virtual_tour_ext").css('font-style', 'normal');
       
        $(".circle1").hide();
        $(".circle2").hide();
        $(".circle3").hide();
        $(".circle4").show(700);
        $(".circle5").show(700);
        $(".circle6").show(700);
        
    }

}

/* Display Webinars Starts Here */

function loadWebinars(){
    globalspace.searchClinicsKeyword="";
    $("#searchClinicsKeyword").val('');
    
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#faqsTab").removeClass("active");
    $("#aboutClinicsTab").removeClass("active");    
    $("#virtualTourTab").removeClass("active");
    $("#webinarsTab").addClass("active");
    
    ajaxRequest("getWebinars", "deviceAgent="+deviceAgent, loadWebinarsResponseHandler);
}

function loadWebinarsResponseHandler(loadWebinarsResponse){
    if(loadWebinarsResponse.status == "success"){       
        my.utils.renderViewTo('Views/webinars.html', loadWebinarsResponse, 'mainContentDiv', function(data){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            scrollToTop();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Webinars', "<li class='error'>Unable to get webinars.</li>", true, false);
    }
}

/* Display Webinars Ends Here */