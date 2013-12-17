var deviceLocalStorage = (function() {
    var F = function(){};
    F.prototype.getValue = function(key){
        return window.localStorage.getItem(key);
    }
    F.prototype.setValue = function(key,value){
        window.localStorage.setItem(key, value);
    }
    return new F();
}());
var localDevice = (function() {
    var F = function(){};
    F.prototype.getUuid = function(){
    	return device.uuid;
    }
    F.prototype.getPlatform = function(){
        //return device.platform+","+device.version;
        return navigator.userAgent;
    }
    F.prototype.localStorage = deviceLocalStorage;
    return new F();
}());

var isBrowser = false;