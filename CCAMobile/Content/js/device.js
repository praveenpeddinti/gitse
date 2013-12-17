var deviceLocalStorage = (function () {
    var F = function(){};
    F.prototype.getValue = function(key){
        return F[key];
    }
    F.prototype.setValue = function(key,value){
        F[key] = value;
    }
    return new F();
}());
var localDevice = (function () {
    var F = function () { };
    F.prototype.getUuid = function () {
        return "10.10.73.70";
    }
    F.prototype.getPlatform = function () {
        return navigator.userAgent;
    }
    F.prototype.localStorage = deviceLocalStorage;
    return new F();
} ());

var isBrowser = true;
