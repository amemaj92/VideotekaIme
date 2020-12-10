var Selection_Change=
{
		init: function()
		{
		 		Selection_Change.kategoria_serialeve=document.getElementById("shto_serial").getElementsByTagName("select")[0];
				Selection_Change.seriali=document.getElementById("shto_serial").getElementsByTagName("select")[1];
				Selection_Change.fieldset=document.getElementById("shto_serial").getElementsByTagName("fieldset")[1];
				
		 		Core.addEventListener(Selection_Change.kategoria_serialeve, "change", Selection_Change.UpdateSeriesList);		 		
		 		Core.addEventListener(Selection_Change.seriali, "change", Selection_Change.UpdateSerialFieldset);
		 		Selection_Change.UpdateSeriesList(); 
		},
		
		UpdateSeriesList: function()
		{
				Selection_Change.seriali.innerHTML="<option>LOADING</option>"; 
				var selection=Selection_Change.kategoria_serialeve.options[Selection_Change.kategoria_serialeve.selectedIndex].value;
				request.open("GET", "script/shto_serial_script.php?kategoria_serialeve="+selection, true);
				request.send(); 	
				
		},
		
		UpdateSerialFieldset: function()
		{
				Selection_Change.fieldset.innerHTML="LOADING";
				var selection=Selection_Change.seriali.options[Selection_Change.seriali.selectedIndex].value;
				request.open("GET", "script/shto_serial_script.php?seriali="+selection, true);
				request.send(); 	
		},
};

var request=new XMLHttpRequest(); 
request.onreadystatechange = function() 
{
	 	if (request.readyState == 4 && request.status == 200) 
	 	{
		 		var return_code=parseInt(request.responseText);
		 		if(return_code==0)	{Selection_Change.seriali.innerHTML = request.responseText.substring(1, request.responseText.length); Selection_Change.UpdateSerialFieldset();}
		 		else if(return_code==1) Selection_Change.fieldset.innerHTML =request.responseText.substring(1, request.responseText.length); 
 		}
};

Core.start(Selection_Change); 