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


/* Add To Contacts Starts Here */

function addPhoneNumberToContacts(){
    var contactOptions = new ContactFindOptions();
    clinicName = $("#clinicName").html();
    contactOptions.filter = clinicName;
    var contactFields = ["*"];
    
    navigator.contacts.find(contactFields, function(contacts){
        if(contacts.length == 0){
            addPhoneNoToContacts();
        } else{
            showConfirmation("Another contact(s) is existed with "+ clinicName +". Do you want to update it?", function(){
                contacts[0].remove( function(){ addPhoneNoToContacts(); }, contactSaveError );
            });
        }
    }, contactSaveError, contactOptions);
}

function addPhoneNoToContacts(){
    if(deviceAgent != "PC"){
        clinicName = $("#clinicName").html();
        var contact = navigator.contacts.create();
        contact.displayName = clinicName;
        contact.nickname = clinicName;
        
        var name = new ContactName();
        name.givenName = clinicName; //First Name
        name.familyName = ""; //Last Name
        contact.name = name;
        
        var phoneNumbers = [];
        phoneNumbers[0] = new ContactField('mobile', $.trim($("#clinicPhoneNo").text()), true);
        contact.phoneNumbers = phoneNumbers;
        
        contact.note = $("#clinicAddress").html() + " Category: " + $("#clinicCategory").html();
        
        contact.save(contactSaveSuccess, function(error){
            contactSaveFail(error, clinicName);
        });
    } else{
        showAlert("Sorry! You can add clinic details to your contacts from mobile app only.!");
    }
}

function contactSaveSuccess(contact){
    ShowMessage('successModal', 'Add Clinic Details Status', "<li class='success'>Clinic details added successfully to your contacts.</li>" , true, false);
}

function contactSaveFail(contactError, clinicName){
    if(contactError.code == 0){
        var contactOptions = new ContactFindOptions();
        contactOptions.filter = clinicName;
        var contactFields = ["*"];
	    
        navigator.contacts.find(contactFields, function(contacts){
            if(contacts.length == 0){
                contactSaveError();
            } else{
                contactSaveSuccess();
            }
        }, contactSaveError, contactOptions);
		
    } else{
        contactSaveError(contactError);
    }
}

function contactSaveError(contactError){
    ShowMessage('errorModal', 'Add Clinic Details Status', "<li class='error'>Adding clinic details to your contacts failed.</li>" , true, false);
}

/* Add To Contacts Ends Here */