var globalspace = new Object();
var deviceAgent = '';
var bodyScroll,modalScroll;
var notificationTitle = "CCA";
var timeInterval = 5 *1000;
var childBrowser;
var distance = 25;

var app = { 
    initialize: function () {         
    	findDevice(screen.width, screen.height);
    	if(deviceAgent == "PC"){
            onDeviceReady(); //this is web browser
    	} else if (navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry)/)) {
            document.addEventListener("deviceready", onDeviceReady, false);
        } else{
            onDeviceReady(); //this is web browser
        } 
    }
};

function onDeviceReady() {
    if (deviceAgent != "PC") {
        if (navigator.connection.type == Connection.UNKNOWN || navigator.connection.type == Connection.NONE) {
            showAlert("Please check your network connection..!");
            return;
        }
        
        document.addEventListener("resume", onResume, false);
        
        if(deviceAgent == "androidPhone" || deviceAgent == "androidTablet"){
            document.addEventListener("backbutton", disableBackButon, false);
        }
        
        childBrowser = window.plugins.childBrowser; //Child Browser Initilization
    }
    
    window.onorientationchange = doOnOrientationChange; 
    
    initializeBodyScroll();
    
    showIndexPage();
}

function onResume(){
    //setTimeout(doAutoLogin, 0);
}