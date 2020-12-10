<?php 

 /*----PHP Scripts And Variables----*/
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
    //----Scripts   
    session_start();
    include_once("../uni/db_connect.php"); 
    //Declaring Varibales
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
    $Prefix_Index=0; 
           
    if (isset($_GET["ct"]))
    {
        $ct=$_GET["ct"];
        //Nxjerrja nga psh: "seriale_turke_me_titra_shqip" e "seriale_turke" dhe "Seriale turke me titra shqip"
        $needle="_";
        $index=strpos($ct, $needle);
        $index2=strpos($ct, $needle, $index+1);
        $Kategoria=substr($ct, 0, $index2); //Nxjerrja e "seriale_turke"
        $Titulli=StringParser($ct, true);
        $Prefix_Index++; 
        //Cler the SESSION POST array saved values when clicking on the Subcategory link. 
        if(!isset($_GET["Sort"]) && !isset($_GET["Wind"])) {unset($_SESSION['post']);}
        
        //Variabli Sort per radhitjen e rezultatit
        if(isset($_GET["Sort"])) {$Sort=$_GET["Sort"];}
        else {$Sort="default";}
        
        //Dritarja per kuantizimin e listes se serialeve
        if(isset($_GET["Wind"])) {$Window=intval($_GET["Wind"]);}
  	else $Window=1; 
    }
    
    //Updating the $_SESSION['post'] superglobal for the next or previous nav clicks (specific post variables should be deleted with functions)
    if(isset($_POST) && count($_POST)) {$_SESSION['post'] = $_POST;}
    if(isset($_SESSION['post']) && count($_SESSION['post'])) {$_POST = $_SESSION['post'];}

echo '
<!DOCTYPE HTML>

<html lang="sq">
    <head>
        <meta charset="utf-8">
    	<!-- +++ Title and meta tags section +++ --> 

        <title>'.$Titulli.' - Videotekaime.net</title>				
	<meta name="description" content="Eja shiko falas '.$Titulli.' me cilesi te larte, me episode te plota dhe pa mungesa! Ne ofrojme seriale te reja por edhe seriale popullore, dhe perpiqemi t\'i perditesojme cdo dite me episode te reja. Eja, hidh nje sy dhe rehatohu!">
	<meta name="keywords" content="seriale me titra shqip">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Basic small screen style up to 960px +++ -->
	<link rel="stylesheet" type="text/css" href="/uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="/seriale_shqip/seriale_category_list_style_new.css">
	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="/uni/Core.js"></script>
	<script type="text/javascript" src="/uni/UniLib.js"></script>	
	<script type="text/javascript" src="/seriale_shqip/seriale_category_list_new.js"></script>
	
	<!-- +++ Defining variables for use +++ -->
	<script>
	var ct="'.$ct.'";
	</script>
	<!-- +++ Outside Scripts +++ -->
	<script async type="text/javascript" src="/uni/GoogleAnalytics.js"></script>
	
    <script type="text/javascript" src="//deloplen.com/apu.php?zoneid=1671127" async></script>
	
    </head>
    <body>	    
        <!-- +++ Universal Header and Nav  ++ Serving SubCategory as Input to Scripts+++ -->';
        HeaderAndNavEcho("Seriale",$Kategoria); 
        echo '<script> var SubCategory="seriale_subnav";</script>
             
	<div id="content">
	    <!--Divizionet me Listen e Serialeve sipas kategorise-->
	    <div id="wrapper">
		<h1>'.$Titulli.'</h1>';
		
		/*The Sort and search section*/
		echo '
		<div id="sort_form">
			<h2>Zgjidh nje menyre Renditjeje:</h2>
			<form action="" method="GET">
				<select>
				  <option value="def"';if($Sort=="def") echo'selected="selected"'; echo'>Default</option>
				  <option value="a_z"';if($Sort=="a_z") echo'selected="selected"'; echo'>Alfabetike(A-Z)</option>
				  <option value="z_a"';if($Sort=="z_a") echo'selected="selected"'; echo'>Alfabetike Inv (Z-A)</option>
				  <option value="n_o"';if($Sort=="n_o") echo'selected="selected"'; echo'>Sipas Vitit(Te rejat ne fillim)</option>
				  <option value="o_n"';if($Sort=="o_n") echo'selected="selected"'; echo'>Sipas Vitit(Te vjetrat ne fillim)</option>
				</select>
				<input type="submit" value="Renditi">
			</form>
		</div>
		
		<div id="simple_search_form">
			<h2>Kerko per dicka ne vecanti:</h2>
			<form  action="/seriale_shqip/'.$ct.'/'.$Sort.'" method="POST">
				<input type="hidden" name="Req_Type" value="simple_search">
				<input type="text" name="search_string" placeholder="Titulli, aktori, regjizori">
				<input type="submit" value="Kerko">
			</form>
			<a href="#" id="avd_search_toggler">Kerkim i Detajuar...</a> 
		</div>
		<div id="adv_search_form">			
			<form action="/seriale_shqip/'.$ct.'/'.$Sort.'" method="POST">
			<input type="hidden" name="Req_Type" value="advanced_search">
			<fieldset><legend>Kerkim i Detajuar</legend>
				<p>Shenim: Ne fushat ku mund te futesh disa te dhena, ndaji ato me presje.</p>
				<ul>
					<li>
					<label for="titulli">Titulli:</label>
					<input type="text" id="titulli" name="Titulli" placeholder="Kara Sevda">
					</li>
					
					<li>
					<label for="regjia">Regjia:</label>
					<input type="text" id="regjia" name="Regjia" placeholder="Hilal Saral">
					</li>
					
					<li>
					<label for="vitet">Vitet:</label>
					<input type="text" id="vitet" name="Vitet" placeholder="2016,2017">
					</li>
					
					<li>
					<label for="aktoret">Aktoret:</label>
					<input type="text" id="aktoret" name="Aktoret" placeholder="Burak Ozcivit,Neslihan Atagul">
					</li>
					
					<li>
					<label for="zhanri">Zhanri:</label>
					<input type="text" id="zhanri" name="Zhanri" placeholder="drame, romance">
					</li>
					
					<li>
					<input type="submit" value="Kerko">
					</li>					
				</ul>				
			</form>
		</div>
		';	
		
		echo '<div id="nenkategorite">';
		echo '<form action="/seriale_shqip/'.$ct.'/'.$Sort.'" method="POST"> <input type="hidden" name="Req_Type" value="subcategories_filter">';		
		echo '<ul id="lista_nenkategorive">';	
		$subcategories_array=SeriesSubcategoriesArrayEcho($Kategoria);
		$selected_subcategories_array=array(); 
		if(isset($_POST["subcategories"]))  $selected_subcategories_array=$_POST["subcategories"];
		for($i=1; $i<count($subcategories_array); $i++) {
		$checked=""; //make checked if checked. 
		$class="";  //change li class to "checked" if checked
		
		for($j=0; $j<count($selected_subcategories_array); $j++) {if($subcategories_array[$i]==$_POST["subcategories"][$j]) {$checked="checked"; $class="checked"; break;} else continue;}
		echo "<li class='$class'><input type='checkbox' name='subcategories[]' id='checkbox".$i."' value='$subcategories_array[$i]' $checked><span>$subcategories_array[$i]</span></li>";}	
		
		echo '</ul>';
		echo '<div><input type="submit" name="submit" value="Perzgjidh"> 
		<a href="/seriale_shqip/'.$ct.'">Anulo</a></div></form></div>';

        echo '<div id="videoteka_bn_1"><a href="//turkishseriesandmovies.com">Turkish Series with English Subtitles</a></div>';

	  	echo '<ul id="lista_seriale_1">';

		//Scripti qe gjeneron listen e serialeve.
		$incl_return=include('/var/www/protected_scripts/series_list_and_search_script.php');
		
		//Llogaritja e Range te dritares. 
		if($Window%5==0) $window_range=intval($Window/5);
		else $window_range=intval($Window/5)+1;
	 	echo '</ul>';
	 	
	 	echo '
	 	<ul id="bottom_nav"><li><a href="';
	 	//Numrat e navigacionit do te varen nga Current Window.
	 	if($window_range>1) echo '/seriale_shqip/'.$ct.'/'.(($window_range-1)*5).'">';
	 	else {echo '#" class="greyed">';}
	 	echo '&lt;&lt;</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+1)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/seriale_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+1).'"'; if(((($window_range-1)*5)+1)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+1).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+2)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/seriale_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+2).'"'; if(((($window_range-1)*5)+2)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+2).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+3)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/seriale_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+3).'"'; if(((($window_range-1)*5)+3)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+3).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+4)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/seriale_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+4).'"'; if(((($window_range-1)*5)+4)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+4).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+5)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/seriale_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+5).'"'; if(((($window_range-1)*5)+5)==$Window) echo ' class="current"';}
	 	echo '">'.((($window_range-1)*5)+5).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+6)>$num_windows) echo '#" class="greyed"';
	 	else echo '/seriale_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+6);
	 	echo '">&gt;&gt;</a></li>
	 	
	 	</ul>
	 	
		</div>';
		
	    //Kontrolli nese eshte futur manualisht nje dritare ne url. 
	    if($incl_return!=1) echo "<p>$incl_return</p>";
	    else if ($num_windows==0) echo "<p>Gabim - Nuk u gjend asnje rezultat qe perputhet me te dhenat e kerkuara.</p>";
	    else if($Window>$num_windows) echo "<p>Gabim - Kjo dritare eshte shume e madhe. Ka me pak seriale se kaq.</p>";
		
    	    echo '</div>';
    	    
    	?>
    </body>	
</html>
