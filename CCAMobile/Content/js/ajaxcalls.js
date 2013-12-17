function showIndexPage() {
    showLoadingIndicator();
    my.utils.renderViewTo('Views/index.html', null, 'mainContentDiv', showIndexPageResponseHandler);
}

function showIndexPageResponseHandler(){
    refreshBodyScroll();
    hideLoadingIndicator();
}

/* Display Clinics Starts Here */

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
    my.utils.renderViewTo('Views/partners.html', null, 'mainContentDiv', loadPartnersResponseHandler);
}

function loadPartnersResponseHandler(){
    $("#headerLogo").show();
    $("#backButton").hide();
    $("#clinicsSwitchDiv").hide();
    $("#shareIcon").hide();
    refreshBodyScroll();
    hideLoadingIndicator();
}

/* Display Partners Ends Here */

/* Display About CCA Starts Here */

function loadAboutCCA(){
    showLoadingIndicator();
    $("#clinicsTab").removeClass("active");
    $("#partnersTab").removeClass("active");
    $("#aboutCCATab").addClass("active");
    my.utils.renderViewTo('Views/aboutCCA.html', null, 'mainContentDiv', loadAboutCCAResponseHandler);
}

function loadAboutCCAResponseHandler(){
    $("#headerLogo").show();
    $("#backButton").hide();
    $("#clinicsSwitchDiv").hide();
    $("#shareIcon").hide();
    refreshBodyScroll();
    hideLoadingIndicator();
}

/* Display About CCA Ends Here */