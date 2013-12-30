/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Gal Cohen

 * Original code from: 
 * Daniel Shookowsky - android: https://github.com/phonegap/phonegap-plugins/tree/5cf45fcade4989668e95a6d34630d2021c45291a/Android/SMSPlugin
 * Randy McMillan - ios and js: https://github.com/phonegap/phonegap-plugins/blob/5cf45fcade4989668e95a6d34630d2021c45291a/iOS/SMSComposer/SMSComposer.js
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 * SMS Composer plugin for PhoneGap/Cordova
 * window.plugins.SMSComposer
 *
 * Unified and updated API to be cross-platform by Gal Cohen in 2013.
 * galcohen26@gmail.com
 * https://github.com/GalCohen
 *
 */


/*
 * Temporary Scope to contain the plugin.
 */
(function() {
     
     /* Get local ref to global PhoneGap/Cordova/cordova object for exec function.
      - This increases the compatibility of the plugin. */
     var cordovaRef = window.PhoneGap || window.Cordova || window.cordova; // old to new fallbacks
     
     function SMSComposer(){
        this.resultCallback = null;
     }
     
     SMSComposer.ComposeResultType = {
         Cancelled:0,
         Sent:1,
         Failed:2,
         NotSent:3
     }
     
     SMSComposer.prototype.showSMSComposer = function(toRecipients, body) {
         
         var args = {};
         
         /* if(toRecipients)
          args.toRecipients = toRecipients;
          
          if(body)
          args.body = body;
          */
         args.body = body ? body : "";
         args.toRecipients = toRecipients ? toRecipients : [""];
         console.log(args.length);
         console.log(args);
         //cordovaRef.exec("SMSComposer.showSMSComposer",[args]);
         cordovaRef.exec(null, null, "SMSComposer", "showSMSComposer", [args]);
     }
     
     SMSComposer.prototype.showSMSComposerWithCB = function(cbFunction,toRecipients,body) {
        this.resultCallback = cbFunction;
        this.showSMSComposer.apply(this,[toRecipients,body]);
     }
     
     SMSComposer.prototype._didFinishWithResult = function(res) {
        this.resultCallback(res);
     }
     
     cordovaRef.addConstructor(function() {
       
       if(!window.plugins) {
            window.plugins = {};
       }
       
       if (!window.plugins.smsComposer){
            window.plugins.smsComposer = new SMSComposer();
            console.log("**************************** SMS Composer ready *************************");
       }
    });
 })();/* End of Temporary Scope. */