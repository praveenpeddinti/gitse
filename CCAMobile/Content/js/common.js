
var serverURL = "http://10.10.73.107:6060/CCA/index.php/";

function ajaxRequest(requestURL,queryString,callback){	
    if (deviceAgent != "PC" && (navigator.connection.type == Connection.UNKNOWN || navigator.connection.type == Connection.NONE)) {
        hideLoadingIndicator();
        showAlert("Please check your network connection..!");
        return;
    } else{
        var data = "option=com_mobile&task="+requestURL+"&"+queryString+"&isMobile=true";
        $.ajax({
            dataType:"json",
            type: "POST",
            url: serverURL,
            async:true,
            data: data,
            success : function(data){
                callback(data);
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                hideLoadingIndicator();
                showAlert("Sorry! Unable to process the request.!");
            }
        });
    }
}

function trimstring(str){
    return $.trim(str);
}

function enterKeyFunction(event,buttonId)
{
    var key;
    if(window.event)
        key = window.event.keyCode;
    else
        key = event.which;

    if(key == 13 || key == 10)
    {
        $("#"+buttonId).click();
        $("#"+buttonId).focus();
        return false;
    }
    else
        return true;
}

function evaluateObject(userInfoObject){
    return eval('(' + userInfoObject + ')');
}

function saveJSONData(keyValue, JSONData){
    localStorage.setItem(keyValue, JSON.stringify(JSONData));
}

function getJSONData(keyValue){
    return JSON.parse(localStorage.getItem(keyValue));
}

function getTodaysDate(){
     var todaysFullDate=new Date();      
     var todaysTwoDigitMonth = (todaysFullDate.getMonth() < '10')? '0' + (todaysFullDate.getMonth()+1):(todaysFullDate.getMonth()+1);
     var todaysTwoDigitDay = (todaysFullDate.getDate() < '10')? '0' + (todaysFullDate.getDate()):(todaysFullDate.getDate()) ;
     var formattedDate=todaysFullDate.getFullYear()+'-'+todaysTwoDigitMonth+'-'+todaysTwoDigitDay;
     return formattedDate;
}

//For fetching all selected values of drop down list
function fetchDropDownListSelectedValues(id){    
    var selectedValues = "";    
    var obj = document.getElementById(''+id);
    for (var i = 0; i < obj.options.length; i++){
        if (obj.options[ i ].selected){ 
            if(i==0){
                selectedValues = obj.options[ i ].value;
            }else{
                selectedValues += ','+obj.options[ i ].value;
            }
        }
    } 
    return selectedValues;
}

function showLoadingIndicator(){ 
    $("#loadingWidget").show();
}

function hideLoadingIndicator(){
    $("#loadingWidget").hide();
}

var my = my || {};

my.utils = new function () {
    this.getPath = function (name) {
        return name;
    };
    this.renderExtTemplate = function (item) {
        var file = this.getPath(item.name);
        $.ajax({
            url: file,
            async: false,
            dataType: 'text',
            success: function (tmplData) {
                $.templates({ tmpl: tmplData });
                $('#' + item.selector).html($.render.tmpl(item.data));
                if (item.oncomplete)
                    item.oncomplete();
            }
        });
    };
    
    this.renderViewTo = function (viewName, jsondata, targetId, callbackfunc, append) {
        $.ajax({
            url: viewName,
            async: false,
            dataType: 'text',
            success: function (tmplData) {
                $.templates({ tmpl: tmplData });
                var renderedhtml = $.render.tmpl(jsondata);
                if (append == true) {
                    $('#' + targetId).append(renderedhtml);
                } else {
                    $('#' + targetId).html(renderedhtml);
                }

                if (callbackfunc != null && callbackfunc != "") {
                    callbackfunc();
                }
            },
            error: function () {

            }
        });
    };
    this.renderView = function (viewName, jsondata, callbackfunc) {
        $.ajax({
            url: viewName,
            async: false,
            dataType: 'text',
            success: function (tmplData) {
                $.templates({ tmpl: tmplData });
                callbackfunc($.render.tmpl(jsondata));
            },
            error: function () {

            }
        });
    };
    this.renderViewAndReplaceWith = function (viewName, jsondata, targetId, callbackfunc)
    {
        $.ajax({
            url: viewName,
            async: false,
            dataType: 'text',
            success: function (tmplData)
            {
                $.templates({ tmpl: tmplData });
                var renderedhtml = $.render.tmpl(jsondata);
                $('#' + targetId).replaceWith(renderedhtml);
            
                if (callbackfunc != null && callbackfunc != "") {
                    callbackfunc();
                }
            },
            error: function ()
            {

            }
        });
    };
};

function ShowMessage(modalDivId,title,message,showOk,showCancel,okCallback,cancelCallback){
    document.getElementById(modalDivId+"Label").innerHTML = title;
    document.getElementById(modalDivId+"Body").innerHTML = message;
    
    if(showOk==true) {
        document.getElementById(modalDivId+"Ok").style.display = '';
        document.getElementById(modalDivId+"Ok").onclick = function () {
            closePopupModel(modalDivId);
            if (okCallback) { okCallback(); }
        }
    }
    else{
        document.getElementById(modalDivId+"Ok").style.display = 'none';
    }
    
    if(showCancel==true) {
        document.getElementById(modalDivId+"Cancel").style.display = '';
        document.getElementById(modalDivId+"Cancel").onclick = function () {
            closePopupModel(modalDivId);
            if(cancelCallback) cancelCallback();
        }
    }
    else{
        document.getElementById(modalDivId+"Cancel").style.display = 'none';
    }
    
    $("#"+modalDivId).modal('show');
}

function openPopupModel(divid)
{
    $('#'+divid).modal('show');
}

function closePopupModel(divid)
{
    $('#'+divid).modal('hide');
}

function confirmation(modalDivId, title, messageBody, okCallback, cancelCallback){
    document.getElementById(modalDivId+"Label").innerHTML = title;
    document.getElementById(modalDivId+"Body").innerHTML = messageBody;
    
    document.getElementById(modalDivId+"Ok").onclick = function () {
        closePopupModel(modalDivId);
        if (okCallback) { okCallback(); }
    }

    document.getElementById(modalDivId+"Cancel").onclick = function () {
        closePopupModel(modalDivId);
        if(cancelCallback) cancelCallback();
    }

    $("#"+modalDivId).modal('show');
}

function findDevice(sWidth, sHeight) {
    userAgent = navigator.userAgent;
    if (userAgent.search("iPhone") != -1) {
        deviceAgent = "iPhone";
    } else if (userAgent.search("iPad") != -1) {
        deviceAgent = "iPad";
    } else if (userAgent.search("iPod") != -1) {
        deviceAgent = "iPod";
    } else if (navigator.userAgent.match(/LG-P705/i) == "LG-P705" && userAgent.search("Android") != -1) {
        deviceAgent = "androidPhone";
    } else if ((sWidth > 400 && sHeight > 800) && userAgent.search("Android") != -1) {
        deviceAgent = "androidTablet";
    } else if (((sWidth == 480 || sWidth == 800 || sWidth <= 400) && sHeight <= 800) && userAgent.search("Android") != -1) {
        deviceAgent = "androidPhone";
    } else {
        deviceAgent = "PC";
    }
    
    globalspace.deviceAgent = deviceAgent;
}

function showAlert(message){
    if(deviceAgent == "PC")
        alert(message);
    else
        navigator.notification.alert(message, null, notificationTitle);
}

function showConfirmation(message, confirmCallback){
    if(deviceAgent == "PC"){
        if(confirm(message) && confirmCallback)
            confirmCallback();
    } else{
        navigator.notification.confirm(message, function(buttonIndex){ if(buttonIndex == 2 && confirmCallback){ confirmCallback(); } }, notificationTitle, 'Cancel,Ok');
    }
}

function doOnOrientationChange(){
    var wrapperHeight = document.getElementById("wrapper").offsetHeight;
    if(popUpModalBody){
        if(deviceAgent == "iPad" || deviceAgent == "androidTablet")
            document.getElementById("model_wrapper_body").style.height = (wrapperHeight-180)+"px";
        else
            document.getElementById("model_wrapper_body").style.height = (wrapperHeight-70)+"px";
    }
}

function getPageSize(context) {
    pageSize = '';
    switch (context) {
        case "clinics":
            if(deviceAgent == "iPad" || deviceAgent == "androidTablet")
                pageSize = 20;
            else
                pageSize = 10;
            break;
        default:
            if (deviceAgent == "iPad" || deviceAgent == "androidTablet")
                pageSize = 20;
            else
                pageSize = 10;
            break;
    }
    return pageSize;
}

function openInChildBrowser(url){
    childBrowser.showWebPage(url);
}

function identifyLinks(inputText) {
    var replacedText, replacePattern1, replacePattern2, replacePattern3;

    //URLs starting with http://, https://, or ftp://
    replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    if(deviceAgent == "PC")
        replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');
    else
        replacedText = inputText.replace(replacePattern1, '<a href="#" onclick="openInChildBrowser(\'$1\')">$1</a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    if(deviceAgent == "PC")
        replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');
    else
        replacedText = replacedText.replace(replacePattern2, '$1<a href="#" onclick="openInChildBrowser(\'http://$2\')">$2</a>');
    
    return replacedText;
}

/* Map Display Starts Here */

function showMap(divId){
    var mapOptions = {
        zoom: 10,
        minZoom :0,
        maxZoom :15,        
        center: new google.maps.LatLng(-33.92, 151.25),
        size: new google.maps.Size(100,100),
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };    
    
    var map = new google.maps.Map(document.getElementById(divId),mapOptions);
    
    var locations = [
        ['Bondi Beach', -33.890542, 151.274856, '<div id="clinic_1" onclick="loadClinicDetailPage()">Bondi Beach'],
        ['Coogee Beach', -33.923036, 151.259052, '<div id="clinic_2" onclick="loadClinicDetailPage()">Coogee Beach'],
        ['Cronulla Beach', -34.028249, 151.157507, '<div id="clinic_3" onclick="loadClinicDetailPage()">Cronulla Beach'],
        ['Manly Beach', -33.80010128657071, 151.28747820854187, '<div id="clinic_4" onclick="loadClinicDetailPage()">Manly Beach'],
        ['Maroubra Beach', -33.950198, 151.259302, '<div id="clinic_5" onclick="loadClinicDetailPage()"><p><span class="marker_name">MinuteClinic</span><span>(9.2 mi)</span><br/> 1361 Hylan Blvd Staten Island NY 10305-1902<br/> 866-389-2727 <br/> Category: CCA Locations</p><p><a target="_blank" href="http://www.minuteclinic.com/">Visit Site >></a></p></div>'],
        ['MinuteClinic', 17.427698500000, 78.45319020000, '<div id="clinic_6" onclick="loadClinicDetailPage()"><p><span class="marker_name">MinuteClinic</span><span>(9.2 mi)</span><br/> 1361 Hylan Blvd Staten Island NY 10305-1902<br/> 866-389-2727 <br/> Category: CCA Locations</p><p><a target="_blank" href="http://www.minuteclinic.com/">Visit Site >></a></p></div>']
    ];
    
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    
    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            title: locations[i][0]
        });
        
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function(){
                infowindow.setContent(locations[i][3]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }
}

/* Map Display Ends Here */