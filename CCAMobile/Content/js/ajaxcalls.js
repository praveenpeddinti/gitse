function showIndexPage() {
    showLoadingIndicator();
    my.utils.renderViewTo('Views/index.html', null, 'mainContentDiv', showIndexPageResponseHandler);
}

function showIndexPageResponseHandler(){
    refreshBodyScroll();
    hideLoadingIndicator();
}

/* Display Clinics Starts Here */

function searchClinicsInCurrentLocation(position){
    showLoadingIndicator();
    globalspace.currentLatitude = position.coords.latitude;
    globalspace.currentLongitude = position.coords.longitude;
    queryString = "distance="+distance+"&lat="+position.coords.latitude+"&lng="+position.coords.longitude;
    ajaxRequest("getClinicsDetails", queryString, loadClinicsOnMapResponseHandler);
}

function searchClinics(){
    var searchKeyword = $("#searchClinicsKeyword").val().trim();
    if(searchKeyword == ""){
        ShowMessage('errorModal', 'Search Clinics Status', "<li class='error'>Please enter either zip code or location name.</li>" , true, false);
        return false;
    } else{
        getClinicsForZipOrLocation(searchKeyword)
    }
}

function getClinicsForZipOrLocation(searchKeyword){
    showLoadingIndicator();
    queryString = "distance="+distance+"&zip="+searchKeyword;
    ajaxRequest("getClinicsDetailForZipandLocation", queryString, loadClinicsOnMapResponseHandler);
}

function loadClinics(target){
    $("#clinicsTab").addClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#clinics_Map_Switch").removeAttr('checked');
    $("#clinics_List_Switch").removeAttr('checked');
    if(target == "Map"){
        $("#clinics_Map_Switch").attr('checked', true);
        $('#backButton').attr('onclick',"loadClinics('Map')");
        getCurrentLocationLatLong();
    } else if(target == "List"){
        $("#clinics_List_Switch").attr('checked', true);
        $('#backButton').attr('onclick',"loadClinics('List')");
        loadClinicsAsList(true);
    }
}

function loadClinicsOnMapResponseHandler(loadClinicsOnMapResponse){
    if(loadClinicsOnMapResponse.status == "success"){
        $("body").removeClass("body");
        $("#header").show();
        $("#backButton").hide();
        $("#clinicsSwitchDiv").show();
        $("#shareIcon").hide();
        $("#headerLogo").hide();
        $("#footer").show();
        
        my.utils.renderViewTo('Views/clinicsOnMap.html', loadClinicsOnMapResponse, 'mainContentDiv', function(){
            if(loadClinicsOnMapResponse.searchKeyword!=undefined)
                $("#searchClinicsKeyword").val(loadClinicsOnMapResponse.searchKeyword);
            
            showMap("map_canvas", loadClinicsOnMapResponse.data);
            refreshBodyScroll();
        });
        
        hideLoadingIndicator();
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Search Clinics Status', "<li class='error'>Unable to get clinics.</li>" , true, false);
    }
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
        queryString = "startpage="+pageNumber+"&endpage="+pageSize;
        ajaxRequest("getClinicsDetailList", queryString, loadClinicsAsListResponseHandler); 
    }
}

function loadClinicsAsListResponseHandler(loadClinicsAsListResponse){
    if(loadClinicsAsListResponse.status == "success"){
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
            $("#headerLogo").hide();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").show();
            $("#shareIcon").hide();
            
            if(loadClinicsAsListResponse.pageNumber == 0 && loadClinicsAsListResponse.resultSize == 0){
                $("#noClinicsFoundDiv").show();
                $("#existingClinicsList").hide();
            } else{
                $("#existingClinicsList").show();
                $("#noClinicsFoundDiv").hide();
            }
            
            if(loadClinicsAsListResponse.pageNumber == 0){
                initializeBodyScroll(null, loadClinicsAsList);
            } else{
                refreshBodyScroll();
            }
            
            if(loadClinicsAsListResponse.resultSize < loadClinicsAsListResponse.pageSize){
                globalspace.isClinicsReachedEnd = true;
            }
            
            $('#clinicsLoading').hide();
            hideLoadingIndicator();
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
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").addClass("active");
    $("#aboutCCATab").removeClass("active");
    ajaxRequest("getPartners", "", loadPartnersResponseHandler);
}

function loadPartnersResponseHandler(loadPartnersResponse){
    if(loadPartnersResponse.status == "success"){
        loadPartnersResponse.site_base_ur = site_base_ur;
        my.utils.renderViewTo('Views/partners.html', loadPartnersResponse, 'mainContentDiv', function(){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
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
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").addClass("active");
    ajaxRequest("getAboutUs", "", loadAboutCCAResponseHandler);
}

function loadAboutCCAResponseHandler(loadAboutCCAResponse){
    if(loadAboutCCAResponse.status == "success"){
        my.utils.renderViewTo('Views/aboutCCA.html', loadAboutCCAResponse, 'mainContentDiv', function(data){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'About CCA', "<li class='error'>Unable to get about cca.</li>", true, false);
    }
}

/* Display About CCA Ends Here */