/* iScroll initilization strats here */

function initializeBodyScroll(onScrollMoveCallback, onScrollEndCallback) {
    
    if(bodyScroll){bodyScroll.destroy(); bodyScroll = null; }
    
    bodyScroll = new iScroll('wrapper',{
        zoom:false,
        //useTransform: false,
        onBeforeScrollStart: function (e) {
            var target = e.target;

            if (target.tagName == "INPUT") { }

            while (target.nodeType != 1) target = target.parentNode;

            if (e.target.tagName != "DIV" && target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
                e.preventDefault();
        },
        onScrollMove: function () { if (onScrollMoveCallback) { onScrollMoveCallback(); } },
        onScrollEnd: function () { if (onScrollEndCallback) { if (this.maxScrollY - this.y >= -50) { onScrollEndCallback(); } } }
    });
    
    document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
}

function refreshBodyScroll(){
    setTimeout(function (){ bodyScroll.refresh(); },500);
}

/* iScroll initilization ends here */

/* Android Handling Back Button Starts Here */

function disableBackButon(){   
    showConfirmation("Are you sure you want to exit app?", exitApp);
}

function enableBackButon(){
    document.addEventListener("backbutton", function(e){
        navigator.app.exitApp();
    }, false);
}

function exitApp(){
    navigator.app.exitApp();
}

/* Android Handling Back Button Ends Here */

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
        ['Bondi Beach', -33.890542, 151.274856, 'Bondi Beach'],
        ['Coogee Beach', -33.923036, 151.259052, 'Coogee Beach'],
        ['Cronulla Beach', -34.028249, 151.157507, 'Cronulla Beach'],
        ['Manly Beach', -33.80010128657071, 151.28747820854187, 'Manly Beach'],
        ['Maroubra Beach', -33.950198, 151.259302, 'Maroubra Beach'],
        ['MinuteClinic', 17.427698500000, 78.45319020000, '<div id="clinic_1" onclick="loadClinicDetailPage()"><p><span class="marker_name">MinuteClinic</span><span>(9.2 mi)</span><br/> 1361 Hylan Blvd Staten Island NY 10305-1902<br/> 866-389-2727 <br/> Category: CCA Locations</p><p><a target="_blank" href="http://www.minuteclinic.com/">Visit Site >></a></p></div>']
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