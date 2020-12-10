var Selection_Change=
{
		init: function()
		{
		 		Selection_Change.kategoria_serialeve=document.getElementById("stat_serial").getElementsByTagName("select")[0];
				Selection_Change.stat_container=document.getElementById("stat_serial").getElementsByTagName("span")[0];
				
		 		Core.addEventListener(Selection_Change.kategoria_serialeve, "change", Selection_Change.UpdateStats);		
		 		Selection_Change.UpdateStats(); 
		},
		
		UpdateStats: function()
		{
				Selection_Change.stat_container.innerHTML="<option>LOADING</option>"; 
				var selection=Selection_Change.kategoria_serialeve.options[Selection_Change.kategoria_serialeve.selectedIndex].value;
				request.open("GET", "script/stats_serial_script.php?kategoria_serialeve="+selection, true);
				request.send(); 	
		},
};

var request=new XMLHttpRequest(); 
request.onreadystatechange = function() 
{
	 	if (request.readyState == 4 && request.status == 200) 
	 	{
		 		Selection_Change.stat_container.innerHTML = request.responseText
		 }
};

Core.start(Selection_Change); 