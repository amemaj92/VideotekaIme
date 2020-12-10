//Handling the News Navigators

var NewsNavs =
{
	init: function()
	{
		//Getting the navigators links for the series as well as for the movies. 
		NewsNavs.series=document.getElementById("new_series_nav");
		NewsNavs.series_navbuttons=NewsNavs.series.getElementsByTagName("li");
		NewsNavs.movies=document.getElementById("new_movies_nav");
		NewsNavs.movies_navbuttons=NewsNavs.movies.getElementsByTagName("li");
		
		//Getting the lists with series and movies. 
		NewsNavs.series_list=document.getElementById("lista_seriale");
		NewsNavs.movies_list=document.getElementById("lista_filma");
		
		//Setting the window_size (series and movies to display per window) 
		NewsNavs.window_size=8;
		Core.addEventListener(NewsNavs.series, "click", NewsNavs.ManageSeriesClick); 
		Core.addEventListener(NewsNavs.movies, "click", NewsNavs.ManageMoviesClick); 
		
		//Making the first update on movies and series list
		NewsNavs.UpdateList(NewsNavs.series_navbuttons, NewsNavs.series_list, 0);
		NewsNavs.UpdateList(NewsNavs.movies_navbuttons, NewsNavs.movies_list, 0);
	},
	
	ManageSeriesClick: function(event) 
	{
		var i=0; 		
		if(event.target.nodeName=="LI") 
		{
			//Was clicked a nav button. Find which one was clicked, changed needed variable to pass to UpdateList function.
			for(i=0; i<NewsNavs.series_navbuttons.length; i++) {if(NewsNavs.series_navbuttons[i]==event.target) break; }
			NewsNavs.UpdateList(NewsNavs.series_navbuttons, NewsNavs.series_list, i);		
		}
	},
	
	ManageMoviesClick: function(event) 
	{
		var i=0; 		
		if(event.target.nodeName=="LI") 
		{
			for(i=0; i<NewsNavs.movies_navbuttons.length; i++) {if(NewsNavs.movies_navbuttons[i]==event.target) break; }
			NewsNavs.UpdateList(NewsNavs.movies_navbuttons, NewsNavs.movies_list, i);
		}	
	},
	
	UpdateList: function(nav_buttons, list, window_index) 
	{
		var list_items=list.getElementsByTagName("li");
		var i=0; 
		//Changing the current Class. 
		for(i=0; i<nav_buttons.length; i++)
		{
			if (i!=window_index) nav_buttons[i].className=""; 
			else nav_buttons[i].className="current"; 
		}
		
		//Updating visible items in the list
		for (i=0; i<list_items.length; i++)
		{
			if(i>=(window_index)*NewsNavs.window_size && i<=((window_index+1)*NewsNavs.window_size-1)) list_items[i].style.display="block"; 
			else list_items[i].style.display="none";			
		}
	},
};

Core.start(NewsNavs);

