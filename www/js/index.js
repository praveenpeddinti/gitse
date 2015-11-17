//var globalspace = new Object();
//var deviceAgent = '';
//var bodyScroll,modalScroll;
//var notificationTitle = "CCA";
//var timeInterval = 30 *1000; // Splash screen sleep out time = 30 sec
//var childBrowser;
//var distance = 25;
//var splashIntervalId;
//var index = 0; // To controll multiple spinners
//
//var app = { 
//    initialize: function () {                  
//    	findDevice(screen.width, screen.height);
//    	if(deviceAgent == "PC"){
//            onDeviceReady(); //this is web browser
//    	} else if (navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry)/)) {   //            
//            document.addEventListener("deviceready", onDeviceReady, false);           
//        } else{
//            onDeviceReady(); //this is web browser
//        } 
//    }
//};
//
//function onDeviceReady() {
//    if (deviceAgent != "PC") {
//    	
//    	//to avoid double tap in droid 4.3 version
//    	var ver=parseFloat(device.version);
//		if(ver>=4.1 && ver < 4.4){ 
//		 var last_click_time = new Date().getTime();
//			document.addEventListener('click', function (e) {
//			try{
//			click_time = e['timeStamp'];
//			if (click_time && (click_time - last_click_time) < 1000) {
//			e.stopImmediatePropagation();
//			e.preventDefault();
//			return false;
//			}
//			last_click_time = click_time;
//			}catch(err){alert(err)}
//			}, true); 
//		}
//    	
//    	
//        if (navigator.connection.type == Connection.UNKNOWN || navigator.connection.type == Connection.NONE) {
//            showAlert("Please check your network connection..!");
//            return;
//        }
//        
//        document.addEventListener("resume", onResume, false);
//        
//        if(deviceAgent == "androidPhone" || deviceAgent == "androidTablet"){
//            document.addEventListener("backbutton", disableBackButon, false);
//        }
//       
//        childBrowser = window.plugins.childBrowser; //Child Browser Initilization
//       
//    }
//    
//    window.onorientationchange = doOnOrientationChange; 
//    
//    initializeBodyScroll();
//    
//    showIndexPage();
//}
//
//function onResume(){
//    //setTimeout(doAutoLogin, 0);
//}

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

var globalspace = new Object();
var deviceAgent = '';
var bodyScroll,modalScroll;
var notificationTitle = "CCA";
var timeInterval = 30 *1000; // Splash screen sleep out time = 30 sec
var inAppBrowser;
var distance = 25;
var splashIntervalId;
var index = 0; // To controll multiple spinners

var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        //document.addEventListener('deviceready', this.onDeviceReady, false);        
        
        findDevice(screen.width, screen.height);
    	if(deviceAgent == "PC"){
            onDeviceReady(); //this is web browser
    	} else if (navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry)/)) {               
            document.addEventListener("deviceready", this.onDeviceReady, false);           
        } else{
            onDeviceReady(); //this is web browser
        } 
        
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        //app.receivedEvent('deviceready');                
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
        //childBrowser = window.plugins.childBrowser; //Child Browser Initilization
        inAppBrowser = cordova.InAppBrowser.open; //In App Browser Initilization       
       
    }
    
    window.onorientationchange = doOnOrientationChange; 
    
    initializeBodyScroll();
    
    showIndexPage();
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
//        var parentElement = document.getElementById(id);
//        var listeningElement = parentElement.querySelector('.listening');
//        var receivedElement = parentElement.querySelector('.received');
//
//        listeningElement.setAttribute('style', 'display:none;');
//        receivedElement.setAttribute('style', 'display:block;');
//
//        console.log('Received Event: ' + id);
    }
    
};

function onResume(){   
    //setTimeout(doAutoLogin, 0);
}

//app.initialize();