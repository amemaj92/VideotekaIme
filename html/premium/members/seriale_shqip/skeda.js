function Send_AJAX_Request()
{
/*-------------------THE AJAX RESPONSE HANDLING----------------*/
	var xhttp = new XMLHttpRequest();
	var params = "Indeksi="+Indeksi;
	xhttp.onreadystatechange = function() 
	{
	    if (this.readyState == 4 && this.status == 200) 
	    {
		var number_response=parseInt(this.responseText,10); 
		if(number_response==-1) {alert(this.responseText); return; }
		else 
		{	
			var Response_Text=this.responseText.substring(this.responseText.indexOf("<li"));
			//Getting Windows_total_number
			List_Manager.windows_total_number=parseInt(this.responseText,10); 	
	
			//Updating the Lista Episodeve InnerHTML		
			List_Manager.lista.innerHTML=Response_Text;
			//Updating the Classes of Bottom Nav
			List_Manager.Bottom_Nav_Updater();
	    	}
	    }
	}
	
	//Sending the Right Request Depending on the set Flags
	if(Search_Form_Manager.search_flag=="active") 
	{
		//Setting the Requested Episode
		params+="&Episodi="+Search_Form_Manager.episodi;
	}
	//If Advanced Search Flag is set to active add advanced search params from the Advanced_Search_Form_Manager Object
	else 
	{
		//Setting the Requested Window
		params+="&Window="+Curr_window;
	}

	//Send the request with the necessary params 
	/*-------------THE AJAX PARAMETERS SETTING AND REQUEST SENDING--------------*/
	xhttp.open("GET", "/premium/members/seriale_shqip/scripts/script_2.php?"+params, false);
	xhttp.send(params);	
};

var List_Manager = 
{
	init: function() 
	{		
		/*--------------------LISTA SERIALE-------------------*/
		List_Manager.lista=document.getElementById("lista_episodeve");
		List_Manager.windows_total_number=0;								
		/*----------------------BOTTOM NAV------------------*/
		//Percaktimi i elementeve te bottom_navit
		List_Manager.bottom_nav=document.getElementById("bottom_nav");
		List_Manager.bottom_nav_elements=List_Manager.bottom_nav.getElementsByTagName("LI");	

		/*--------------THE EVENT LISTENERS--------------*/
		Core.addEventListener(List_Manager.bottom_nav, "click", List_Manager.Bottom_Nav_Manager);
		Send_AJAX_Request();
	},
	
	Bottom_Nav_Manager: function(event)
	{
		if(event.target.nodeName=="LI") 
		{
			//---------Checking that no grey button was clicked
			if(event.target.className=="greyed") return;
			
			//---------Previous Button was clicked (and it is not grey) and the current window is beyound the first 5
			else if(event.target.innerHTML=="&lt;&lt;" && parseInt(List_Manager.bottom_nav_elements[5].innerHTML)>5)  //"&lt;&lt;"==="<<"
			{
				//Changing the current Window to the new value
				Curr_window=parseInt(List_Manager.bottom_nav_elements[1].innerHTML)-1;
				//Changing all the buttons' InnerHTML by adding 5 more
				for(i=1; i<=5; i++)
				{
					List_Manager.bottom_nav_elements[i].innerHTML=parseInt(List_Manager.bottom_nav_elements[i].innerHTML)-5;
				}
			}
			
			//---------Next Button was clicked (and it is not grey)
			else if(event.target.innerHTML=="&gt;&gt;") //&gt;&gt;===">>"
			{
				//Changing the current Window to the new value
				Curr_window=parseInt(List_Manager.bottom_nav_elements[5].innerHTML)+1;
				//Changing all the buttons' InnerHTML by adding 5 more
				for(i=1; i<=5; i++)
				{
					List_Manager.bottom_nav_elements[i].innerHTML=parseInt(List_Manager.bottom_nav_elements[i].innerHTML)+5;
				}
			}
			
			//-------------One number Button is clicked (and of course, it's not grey
			else
			{
				if(Curr_window!=parseInt(event.target.innerHTML)) Curr_window=parseInt(event.target.innerHTML);
			}
			
			//Sending the Ajax Request();
			Send_AJAX_Request();
		}
		
	}, 
			/*-----------------BOTTOM NAV CLASS CHANGING CODE----------------*/
	Bottom_Nav_Updater: function() 
	{	
		var j=0;	
		//Greying outor resetting Prev and Next
		//PREV
		if(List_Manager.bottom_nav_elements[1].innerHTML==1) List_Manager.bottom_nav_elements[0].className="greyed"; //Greying Prev when first element is 1
		else List_Manager.bottom_nav_elements[0].className="";
		if(parseInt(List_Manager.bottom_nav_elements[5].innerHTML)>=List_Manager.windows_total_number) List_Manager.bottom_nav_elements[6].className="greyed"; 
		else List_Manager.bottom_nav_elements[6].className="";
		//Greying out elements out of range / reseting those that are within range / setting the current button (always)
		for(j=1; j<=5; j++)
		{
			if(parseInt(List_Manager.bottom_nav_elements[j].innerHTML)==Curr_window) List_Manager.bottom_nav_elements[j].className="current";
			else if(parseInt(List_Manager.bottom_nav_elements[j].innerHTML)<=List_Manager.windows_total_number) 
			{
				List_Manager.bottom_nav_elements[j].className="";
			}
			else if(parseInt(List_Manager.bottom_nav_elements[j].innerHTML)>List_Manager.windows_total_number)
			{
				List_Manager.bottom_nav_elements[j].className="greyed";
			}
		}		
		
	},
};

Core.start(List_Manager); 

var Search_Form_Manager = 
{
	init: function() 
	{		
		Search_Form_Manager.search_flag="";
		/*--------------------Simple Search Form-------------------*/
		Search_Form_Manager.search_form=document.getElementById("episodet").getElementsByTagName("FORM")[0];
		Search_Form_Manager.search_form_inputs=Search_Form_Manager.search_form.getElementsByTagName("INPUT"); 
		//input[0]-> Episodi text Area
		//input[1]-> Submit
		//input[2]-> Reset
		Search_Form_Manager.episodi="";
		Core.addEventListener(Search_Form_Manager.search_form, "click", Search_Form_Manager.Submit_Rewrite); 
	},
	
	Submit_Rewrite: function(event)
	{
		Core.preventDefault(event); 
		if(event.target.nodeName=="INPUT" && event.target.value=="Kerko") //Submit is clicked
		{
		    //Get The Values
		    Search_Form_Manager.episodi=Search_Form_Manager.search_form_inputs[0].value; 
		    //Set the Flag to active
		    Search_Form_Manager.search_flag="active"; 
		    Curr_window=0; 
		    //Send the Request
		    //Sending the Ajax Request();
		    Send_AJAX_Request();	    
		}
		
		else if(event.target.nodeName=="INPUT" && event.target.value=="Anulo") //Reset is clicked
		{
		    //Set the Flag to inactive (null)
		    Search_Form_Manager.search_flag=""; 
		    //Change Curr_window back to defult
		    Curr_window=1; 
		    //Send the Request
		    //Sending the Ajax Request();
		    Send_AJAX_Request();	    
		}
	},
};

Core.start(Search_Form_Manager); 

var Info_Toggler = 
{
	init: function() 
	{
		Info_Toggler.Toggler=document.getElementById("info_toggle");
		Info_Toggler.more_info_div=document.getElementById("more_info"); 
		Core.addEventListener(Info_Toggler.Toggler, "click", Info_Toggler.Toggle_Manager); 
	},
	
	Toggle_Manager: function(event)
	{
		Core.preventDefault(event); 
		if(Info_Toggler.more_info_div.className!="toggled") {Info_Toggler.more_info_div.className="toggled"; Info_Toggler.Toggler.innerHTML="Lexo me pak...";}
		else {Info_Toggler.more_info_div.className="untoggled"; Info_Toggler.Toggler.innerHTML="Lexo me shume...";}
	},
};

Core.start(Info_Toggler); 
