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