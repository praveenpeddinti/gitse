function showIndexPage() {
    showLoadingIndicator();
    my.utils.renderViewTo('Views/index.html', null, 'mainContentDiv', showIndexPageResponseHandler);
}

function showIndexPageResponseHandler(){
    refreshBodyScroll();
    hideLoadingIndicator();
}

/* Display Clinics Starts Here */

function searchClinicsInCurrentLocation(){
    
}

function searchClinics(){
    var searchKeyword = $("#searchClinicsKeyword").val().trim();
    
    if(searchKeyword == ""){
        ShowMessage('errorModal', 'Search Clinics Status', "<li class='error'>Please enter either zip code or location name.</li>" , true, false);
        return false;
    } else{
        
    }
}

function loadClinics(target){
    showLoadingIndicator();
    $("#clinicsTab").addClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").removeClass("active");
    $("#clinics_Map_Switch").removeAttr('checked');
    $("#clinics_List_Switch").removeAttr('checked');
    if(target == "Map"){
        $("#clinics_Map_Switch").attr('checked', true);
        $('#backButton').attr('onclick',"loadClinics('Map')");
        my.utils.renderViewTo('Views/clinicsOnMap.html', null, 'mainContentDiv', loadClinicsOnMapResponseHandler);
        //ajaxRequest("parents", "", loadClinicsOnMapResponseHandler);
    } else if(target == "List"){
        $("#clinics_List_Switch").attr('checked', true);
        $('#backButton').attr('onclick',"loadClinics('List')");
        my.utils.renderViewTo('Views/clinicsList.html', null, 'mainContentDiv', loadClinicsListResponseHandler);
    }
}

function loadClinicsOnMapResponseHandler(loadClinicsOnMapResponse){
    //my.utils.renderViewTo('Views/clinicsOnMap.html', loadClinicsOnMapResponse, 'mainContentDiv', function(){});
    $("body").removeClass("body");
    $("#header").show();
    $("#backButton").hide();
    $("#clinicsSwitchDiv").show();
    $("#shareIcon").hide();
    $("#headerLogo").hide();
    $("#footer").show();              
    showMap("map_canvas");    
    refreshBodyScroll();
    hideLoadingIndicator();
}

function loadClinicsListResponseHandler(){
    $("#headerLogo").hide();
    $("#backButton").hide();
    $("#clinicsSwitchDiv").show();
    $("#shareIcon").hide();
    refreshBodyScroll();
    hideLoadingIndicator();
}

function loadClinicDetailPage(){
    showLoadingIndicator();
    my.utils.renderViewTo('Views/clinicDetailPage.html', null, 'mainContentDiv', loadClinicDetailPageResponseHandler);
}

function loadClinicDetailPageResponseHandler(){
    $("#backButton").show();
    $("#clinicsSwitchDiv").hide();
    $("#headerLogo").show();
    $("#shareIcon").show();
    refreshBodyScroll();
    hideLoadingIndicator();
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
        my.utils.renderViewTo('Views/partners.html', null, 'mainContentDiv', function(){
            $("#headerLogo").show();
            $("#backButton").hide();
            $("#clinicsSwitchDiv").hide();
            $("#shareIcon").hide();
            refreshBodyScroll();
            hideLoadingIndicator();
        });
    } else{
        hideLoadingIndicator();
        ShowMessage('errorModal', 'Partners', "<li class='error'>Unable to get partners.</li>", true, false);
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