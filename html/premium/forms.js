function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";

    // Finally submit the form. 
    form.submit();
}

function regformhash(form, uid, email, paypal_email, password, conf) {
     // Check each field has a value
    ErrorHandler.current_err_alert=document.getElementById("signup_error_alert"); 
    if (uid.value == '' 	|| 
	  email.value == '' 	|| 
	  paypal_email.value == '' 	|| 
	  password.value == '' 	|| 
	  conf.value == '') {

        error_alert(ErrorHandler.current_err_alert, "Ti duhet te japesh te gjitha te dhenat e kerkuara. Te lutemi ta provosh serish.");
        return false;
    }
    else {error_alert_dismis(ErrorHandler.current_err_alert);}
    
    // Check the username
    ErrorHandler.current_err_alert=ErrorHandler.err_alerts_container[1];
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
    	error_alert(ErrorHandler.current_err_alert, "Pseudonimi mund te kete vetem shkronja, numra dhe nenvizime. Te lutemi ta provosh serish."); 
        form.username.focus();
        return false; 
    }
    else {error_alert_dismis(ErrorHandler.current_err_alert);}
    
    //Check the email adress.
    ErrorHandler.current_err_alert=ErrorHandler.err_alerts_container[2];
    re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(form.email.value)) { 
    	error_alert(ErrorHandler.current_err_alert, "Emaili nuk eshte i vlefshem. Te lutemi ta provosh serish."); 
        form.email.focus();
        return false; 
    }
    else {error_alert_dismis(ErrorHandler.current_err_alert);}
    
    //Check the email adress.
    ErrorHandler.current_err_alert=ErrorHandler.err_alerts_container[3];
    re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(form.paypal_email.value)) { 
    	error_alert(ErrorHandler.current_err_alert, "Emaili i Paypalit nuk eshte i vlefshem. Te lutemi ta provosh serish."); 
        form.paypal_email.focus();
        return false; 
    }
    else {error_alert_dismis(ErrorHandler.current_err_alert);}
    
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    ErrorHandler.current_err_alert=ErrorHandler.err_alerts_container[5];
    if (password.value.length < 6) {
        error_alert(ErrorHandler.current_err_alert,"Fjalekalimi duhet te jete i gjate te pakten 6 shkronja. Te lutemi ta provosh serish.");
        form.password.focus();
        return false;
    }
    else {error_alert_dismis(ErrorHandler.current_err_alert);}
    
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    ErrorHandler.current_err_alert=ErrorHandler.err_alerts_container[5];
    if (!re.test(password.value)) {
        error_alert(ErrorHandler.current_err_alert,"Fjalekalimi duhet te permbushe kushtet e mesiperme per sigurine tende. Te lutemi ta provosh serish.");
        return false;
    }
    else {error_alert_dismis(ErrorHandler.current_err_alert);}
    
    // Check password and confirmation are the same
    ErrorHandler.current_err_alert=ErrorHandler.err_alerts_container[6];
    if (password.value != conf.value) {
        error_alert(ErrorHandler.current_err_alert,'Fjalekalimet duhet te perputhen. Te lutemi ta provosh serish.');
        form.password.focus();
        return false;
    }
    else {error_alert_dismis(ErrorHandler.current_err_alert);}
        
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";

    // Finally submit the form. 
    form.submit();
    return true;
}

function error_alert(alert_container, alert_message) {
    var i=0; 
    for (i=0; i<ErrorHandler.err_alerts_container.length; i++)
    {    
    	if(ErrorHandler.err_alerts_container[i]==alert_container) 
    	    {
    	    	alert_container.style.display="block"; 
    	    	if(alert_message!="") ErrorHandler.err_alerts_container[i].innerHTML=alert_message;
    	    }
    }
    
}

function error_alert_dismis(alert_container) {
    var i=0; 
    for (i=0; i<ErrorHandler.err_alerts_container.length; i++)
    {    
    	if(ErrorHandler.err_alerts_container[i]==alert_container) 
    	    {
    	    	alert_container.style.display="none"; 
                ErrorHandler.err_alerts_container[i].innerHTML="";
    	    }
    }
}

var ErrorHandler =
{
	init: function()
	{
		ErrorHandler.err_alerts_container=document.getElementById("signup").getElementsByTagName("p");
		ErrorHandler.current_err_alert="";
	},
};

Core.start(ErrorHandler);