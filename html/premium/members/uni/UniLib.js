var SubTrigger =
{
    init: function()
    {
		//Marrja e linkeve te navit kryesor ("Kreu", "Seriale", "Filma");
        SubTrigger.MainNavAnchors=document.getElementById("main_nav").getElementsByTagName("A");
		//Linku i subnaveve per "Seriale" dhe "Filma";
		SubTrigger.SeriesSubnav=document.getElementById("seriale_subnav");
		SubTrigger.FilmsSubnav=document.getElementById("filma_subnav");
		SubTrigger.HideTimer;
		SubTrigger.PermaSubnav;
		/*Setting PermaSubnav
		Variabli SubCategory do te jete gjeneruar nga PHP ne faqet dinamike dhe do te tregoje se 
		cila nenkategori duhet te jete permanente. Nese ai eshte null, atehere asnjera prej kategorive 
		nuk do te shfaqet ne menyre permanente*/
		if(SubCategory=="seriale_subnav") {
			SubTrigger.PermaSubnav=SubTrigger.SeriesSubnav;
			SubTrigger.SHOW(SubTrigger.SeriesSubnav);
		}
		else if(SubCategory=="filma_subnav") {
			SubTrigger.PermaSubnav=SubTrigger.FilmsSubnav;
			SubTrigger.SHOW(SubTrigger.FilmsSubnav);
		}
		else SubTrigger.PermaSubnav=null;
		
		//Adding Event Listeners on the Main Series Anchor
		//SHOW Event Listener
		Core.addEventListener(SubTrigger.MainNavAnchors[2],"mouseover", function()
		{
			SubTrigger.HIDE(SubTrigger.FilmsSubnav, false);
			SubTrigger.SHOW(SubTrigger.SeriesSubnav);
		});
		//HIDE Event Listener
		Core.addEventListener(SubTrigger.MainNavAnchors[2],"mouseout", function()
		{
			SubTrigger.HideTimer=setTimeout(function(){SubTrigger.HIDE(SubTrigger.SeriesSubnav, true);}, 6000)
		});
		
		//Adding Event Listeners on the Main Films Anchor
		//SHOW Event Listener
		Core.addEventListener(SubTrigger.MainNavAnchors[3],"mouseover", function()
		{
			SubTrigger.HIDE(SubTrigger.SeriesSubnav, false);
			SubTrigger.SHOW(SubTrigger.FilmsSubnav);
		});
		//HIDE Event Listener
		Core.addEventListener(SubTrigger.MainNavAnchors[3],"mouseout", function()
		{
			SubTrigger.HideTimer=setTimeout(function(){SubTrigger.HIDE(SubTrigger.FilmsSubnav, true);}, 6000)
		});
		
		//Adding Event Listeners on the Series Subnav
		//SHOW Event Listener
		Core.addEventListener(SubTrigger.SeriesSubnav,"mouseover", function()
		{
			SubTrigger.SHOW(SubTrigger.SeriesSubnav);
		});
		//HIDE Event Listener
		Core.addEventListener(SubTrigger.SeriesSubnav,"mouseout", function()
		{
			SubTrigger.HideTimer=setTimeout(function(){SubTrigger.HIDE(SubTrigger.SeriesSubnav, true);}, 6000)
		});
		
		//Adding Event Listeners on the Films Subnav
		//SHOW Event Listener
		Core.addEventListener(SubTrigger.FilmsSubnav,"mouseover", function()
		{
			SubTrigger.SHOW(SubTrigger.FilmsSubnav);
		});
		//HIDE Event Listener
		Core.addEventListener(SubTrigger.FilmsSubnav,"mouseout", function()
		{
			SubTrigger.HideTimer=setTimeout(function(){SubTrigger.HIDE(SubTrigger.FilmsSubnav, true);}, 6000)
		});
			
		},
	
    HIDE: function(TargetSubnav, ConsiderPermaSubnav) //Hides given subnav while considering if it is Permanent or not.
    {
        TargetSubnav.style.display="none";
        clearTimeout(SubTrigger.HideTimer);
        SubTrigger.HideTimer=false;
        if((SubTrigger.PermaSubnav!=null && ConsiderPermaSubnav==true)) SubTrigger.SHOW(SubTrigger.PermaSubnav);
    },

    SHOW: function(TargetSubnav)
    {
        TargetSubnav.style.display="block";
        clearTimeout(SubTrigger.HideTimer);
        SubTrigger.HideTimer=false;
    },	
	 	
};
	 		 		
Core.start(SubTrigger);
	 
				
				