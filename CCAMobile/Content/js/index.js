var globalspace = new Object();
var deviceAgent = '';
var bodyScroll,modalScroll;
var notificationTitle = "CCA";
var timeInterval = 30 *1000; // Splash screen sleep out time = 30 sec
var childBrowser;
var distance = 25;
var splashIntervalId;
var index = 0; // To controll multiple spinners

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
    	
    	//to avoid double tap in droid 4.3 version
    	var ver=parseFloat(device.version);
		if(ver>=4.1 && ver < 4.4){ 
		 var last_click_time = new Date().getTime();
			document.addEventListener('click', function (e) {
			try{
			click_time = e['timeStamp'];
			if (click_time && (click_time - last_click_time) < 1000) {
			e.stopImmediatePropagation();
			e.preventDefault();
			return false;
			}
			last_click_time = click_time;
			}catch(err){alert(err)}
			}, true); 
		}
    	
    	
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