//Doing the Sort with javascript saves the post data from being erased. Leave it with javascript. 

var Sort_Form_Manager = 
{
	init: function() 
	{		
		/*--------------------SORT FORM-------------------*/
		Sort_Form_Manager.sort_form=document.getElementById("sort_form").getElementsByTagName("form")[0];
		Sort_Form_Manager.sort_form_select=Sort_Form_Manager.sort_form.getElementsByTagName("SELECT")[0]
		Core.addEventListener(Sort_Form_Manager.sort_form, "click", Sort_Form_Manager.Submit_Rewrite); 
	},
	
	Submit_Rewrite: function(event)
	{
		Core.preventDefault(event); 
		if(event.target.nodeName=="INPUT") 
		{
		    var current_url="/premium/members/seriale_shqip/"+ct;
		    var new_url=current_url+"/"+Sort_Form_Manager.sort_form_select.options[Sort_Form_Manager.sort_form_select.selectedIndex].value
		    window.location.href=new_url; 
		}
	},
};

Core.start(Sort_Form_Manager); 

//Just the toggle-ing functions
var Avdanced_Search_Form_Manager = 
{
	init: function()
	{
		/*--------------------------ADVANCED SEARCH FORM--------------------*/
		Avdanced_Search_Form_Manager.toggle_button= document.getElementById("avd_search_toggler");
		Avdanced_Search_Form_Manager.avdanced_search_form=document.getElementById("adv_search_form").getElementsByTagName("FORM")[0];
		Core.addEventListener(Avdanced_Search_Form_Manager.toggle_button, "click", Avdanced_Search_Form_Manager.Toggle);		
	},
	
	Toggle: function(event)
	{
		Core.preventDefault(event); 
		if(Avdanced_Search_Form_Manager.avdanced_search_form.parentNode.style.display=="none" || Avdanced_Search_Form_Manager.avdanced_search_form.parentNode.style.display=="" || Avdanced_Search_Form_Manager.avdanced_search_form.parentNode.style.display==undefined) 
		Avdanced_Search_Form_Manager.avdanced_search_form.parentNode.style.display="block"; 
		else 
		{
			Avdanced_Search_Form_Manager.avdanced_search_form.parentNode.style.display="none";
		}
	},
};

Core.start(Avdanced_Search_Form_Manager); 


//Just the styling onclick of the list elements and the setting of the input checkbox value to active. 
var CheckboxSubcategoriesMenager =
{
	init: function()
	{
		CheckboxSubcategoriesMenager.formulari=document.getElementById("nenkategorite").getElementsByTagName("form")[0];
		Core.addEventListener(CheckboxSubcategoriesMenager.formulari.getElementsByTagName("ul")[0], "click", CheckboxSubcategoriesMenager.ClickManager);
		CheckboxSubcategoriesMenager.formulari_inputs=CheckboxSubcategoriesMenager.formulari.getElementsByTagName("INPUT");
	},
	
	ClickManager: function(event)
	{ 
		if(event.target.nodeName=="LI")	//Eshte shtypur elementi i listes. Beje checked checkboxin dhe ndryshoji klasen elementit te listes. 
		{
			var input_element=event.target.getElementsByTagName("INPUT")[0];
			var li_element=event.target;
		}
		else if(event.target.parentNode.nodeName=="LI")
		{
			var input_element=event.target.parentNode.getElementsByTagName("INPUT")[0];
			var li_element=event.target.parentNode;
			if(event.target.nodeName=="INPUT") {input_element.checked=!input_element.checked}
		}
		if(input_element.checked==false) //Unchecked->Checked
		{input_element.checked=true; li_element.className="checked";}
		else 
		{input_element.checked=false; li_element.className="";}  //Checked->Unchecked
	},
	
};

Core.start(CheckboxSubcategoriesMenager); 


//Styling and Equalizing the list elements. 
var List_Manager = 
{
	init: function() 
	{		
		/*--------------------LISTA SERIALE-------------------*/
		List_Manager.lista=document.getElementById("lista_seriale");
		List_Manager.Height_Setting();		
	},
		
	Height_Setting: function()
	{
		//Setting the heights of the list elements to maximum height of the largest element		
		List_Manager.lista_items=List_Manager.lista.getElementsByTagName("LI");
		var i=0; 
		max_height=0;
		var p_height, calculated_img_height, temp_max_height;			
		for(i=0; i<List_Manager.lista_items.length; i++)
		{
			p_height=parseInt(Core.getComputedStyle(List_Manager.lista_items[i].getElementsByTagName("p")[0], "height"),10);
			if(parseInt(Core.getComputedStyle(List_Manager.lista.parentNode, "width"), 10)>480)
			{calculated_img_height=parseInt(parseInt(Core.getComputedStyle(List_Manager.lista_items[i], "width"),10)/400*225); padding_correction=16;}
			else {calculated_img_height=0; padding_correction=0;}
			temp_max_height= p_height+ calculated_img_height+16; //padding of p is 16px
		        if(temp_max_height>max_height) max_height=temp_max_height;
		}

		for(i=0; i<List_Manager.lista_items.length; i++)
		{
		    List_Manager.lista_items[i].style.height=max_height+"px";
		}
		
	},
};

Core.start(List_Manager); 

