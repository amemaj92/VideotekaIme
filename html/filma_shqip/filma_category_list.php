<?php 

 /*----PHP Scripts And Variables----*/
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
    //----Scripts   
    session_start();
    include_once("../uni/db_connect.php");
    //Declaring Varibales
    $user_agent=$_SERVER['HTTP_USER_AGENT'];
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
    
    if (isset($_GET["ct"]))
    {
        $ct=$_GET["ct"];
        $Titulli=StringParser($ct, true);
        $Kategoria=$ct;
        
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
    if(isset($_POST) && count($_POST)) { $_SESSION['post'] = $_POST; }
    if(isset($_SESSION['post']) && count($_SESSION['post'])) { $_POST = $_SESSION['post']; }


echo '
<!DOCTYPE HTML>

<html lang="sq">
    <head>
        <meta charset="utf-8">
    	<!-- +++ Title and meta tags section +++ --> 

        <title>'.$Titulli.' - Videotekaime.net</title>				
	<meta name="description" content="Eja shiko falas '.$Titulli.' me cilesi te larte dhe pa mungesa! Ne ofrojme filma te rinj por edhe filma popullore, dhe perpiqemi te shtojme cdo dite filma te rinj nga te gjitha kategorite. Eja, hidh nje sy dhe rehatohu!">
	<meta name="keywords" content="filma shqip">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Basic small screen style up to 960px +++ -->
	<link rel="stylesheet" type="text/css" href="/uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="/filma_shqip/filma_category_list_style.css">
	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="/uni/Core.js"></script>
	<script type="text/javascript" src="/uni/UniLib.js"></script>
	<script type="text/javascript" src="/filma_shqip/filma_category_list_new.js"></script>
	<!-- +++ Defining variables for use +++ -->
	<script>
	var Cat="'.$Kategoria.'";
	var Curr_window="'.$Window.'";
	var Sort="'.$Sort.'";
	var ct="'.$ct.'";
	</script>
	<!-- +++ Outside Scripts +++ -->
	<script type="text/javascript" src="/uni/GoogleAnalytics.js"></script>
	
	<script type="text/javascript" src="//deloplen.com/apu.php?zoneid=1671127" async></script>
    </head>
    <body>	    
        <!-- +++ Universal Header and Nav  ++ Serving SubCategory as Input to Scripts+++ -->';
        HeaderAndNavEcho("Filma",$Kategoria); 
        echo '<script> var SubCategory="filma_subnav";</script>
             
	<div id="content">
	    <!--Divizionet me Listen e Filmave sipas kategorise-->
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
			<form  action="/filma_shqip/'.$ct.'/'.$Sort.'" method="POST">
				<input type="hidden" name="Req_Type" value="simple_search">
				<input type="text" name="search_string" placeholder="Titulli,viti,zhanri">
				<input type="submit" value="Kerko">
			</form>
			<a href="#" id="avd_search_toggler">Kerkim i Detajuar...</a> 
		</div>
		<div id="adv_search_form">			
			<form action="/filma_shqip/'.$ct.'/'.$Sort.'" method="POST">
			<input type="hidden" name="Req_Type" value="advanced_search">
			<fieldset><legend>Kerkim i Detajuar</legend>
				<p>Shenim: Ne fushat ku mund te futesh disa te dhena, ndaji ato me presje.</p>
				<ul>';
					/*---------------Nga nje formular per cdo kategori sepse secila duhet te kete si shembull nje film specifik. -------*/
					if($Kategoria=="filma_te_dubluar_ne_shqip")
					{
						echo '
						<li>
						<label for="titulli">Titulli:</label>
						<input type="text" id="titulli" name="Titulli" placeholder="Mbreteresha e Debores" >
						</li>
						
						<li>
						<label for="studio">Studioja:</label>
						<input type="text" id="studio" name="Studio" placeholder="Walt Disney">
						</li>
						
						<li>
						<label for="viti">Viti:</label>
						<input type="text" id="viti" name="Viti" placeholder="2013">
						</li>
									
						<li>
						<label for="zhanri">Zhanri:</label>
						<input type="text" id="zhanri" name="Zhanri" placeholder="vizatimor,animacion,aventure,komedi">
						</li>';									
					}
					
					else if($Kategoria=="filma_me_titra_shqip" OR $Kategoria=="filma_per_femije")
					{
						echo '
						<li>
						<label for="titulli">Titulli:</label>
						<input type="text" id="titulli" name="Titulli" placeholder="A Beautiful Mind">
						</li>
						
						
						<li>
						<label for="regjia">Regjia:</label>
						<input type="text" id="regjia" name="Regjia" placeholder="Ron Howard">
						</li>
						
						<li>
						<label for="viti">Viti:</label>
						<input type="text" id="viti" name="Viti" placeholder="2001">
						</li>
						
						<li>
						<label for="aktoret">Aktoret:</label>
						<input type="text" id="aktoret" name="Aktoret" placeholder="Russell Crowe,Ed Harris">
						</li>
						
						<li>
						<label for="zhanri">Zhanri:</label>
						<input type="text" id="zhanri" name="Zhanri" placeholder="Amerikan,drame,biografi">
						</li>';
					}
					
					else if($Kategoria=="filma_shqiptar")
					{
						echo '
						<li>
						<label for="titulli">Titulli:</label>
						<input type="text" id="titulli" name="Titulli" placeholder="Zonja_nga_Qyteti">
						</li>
						
						
						<li>
						<label for="regjia">Regjia:</label>
						<input type="text" id="regjia" name="Regjia" placeholder="Pirro Milkani">
						</li>
						
						<li>
						<label for="viti">Viti:</label>
						<input type="text" id="viti" name="Viti" placeholder="1976">
						</li>
						
						<li>
						<label for="aktoret">Aktoret:</label>
						<input type="text" id="aktoret" name="Aktoret" placeholder="Violeta Manushi,Rajmonda Bulku">
						</li>
						
						<li>
						<label for="zhanri">Zhanri:</label>
						<input type="text" id="zhanri" name="Zhanri" placeholder="koemdi,familjar">
						</li>';
					}
					
					echo '					
					<li>
					<input type="submit" value="Kerko">
					</li>					
				</ul>				
			</form>
		</div>
		';
		echo '<div id="nenkategorite">';
		echo '<form action="/filma_shqip/'.$ct.'/'.$Sort.'" method="POST"> <input type="hidden" name="Req_Type" value="subcategories_filter">';
		
		if($Kategoria=="filma_me_titra_shqip" OR $Kategoria=="filma_per_femije")
		{		
			echo '<fieldset><ul id="lista_origs">';	
			if($Kategoria=="filma_me_titra_shqip") $origs_array=MoviesOrigsEcho("filma_me_titra_shqip");
			else $origs_array=MoviesOrigsEcho("filma_per_femije");
			
			$selected_origs=array();
			if(isset($_POST["origs"]))  $selected_origs=$_POST["origs"];
			for($i=0; $i<count($origs_array); $i++) {
				$checked=""; //make checked if checked. 
				$class="";  //change li class to "checked" if checked
				
				for($j=0; $j<count($selected_origs); $j++) {
					if($origs_array[$i]==$selected_origs[$j]) {$checked="checked"; $class="checked"; break;} 
					else continue;
				}
				echo "<li class='$class'><input type='checkbox' name='origs[]' id='checkbox".$i."' value='$origs_array[$i]' $checked><span>$origs_array[$i]</span></li>";
			}				
			echo '</ul></fieldset>';
		}
		
		echo '<fieldset><ul id="lista_nenkategorive">';	
		$subcategories_array=MoviesSubcategoriesArrayEcho($Kategoria);		
		$selected_subcategories_array=array(); 		
		if(isset($_POST["subcategories"]))  $selected_subcategories_array=$_POST["subcategories"];
		
		for($i=1; $i<count($subcategories_array); $i++) {
			$checked=""; //make checked if checked. 
			$class="";  //change li class to "checked" if checked
			
			for($j=0; $j<count($selected_subcategories_array); $j++) {
				if($subcategories_array[$i]==$selected_subcategories_array[$j]) {$checked="checked"; $class="checked"; break;} 
				else continue;
			}
			echo "<li class='$class'><input type='checkbox' name='subcategories[]' id='checkbox".$i."' value='$subcategories_array[$i]' $checked><span>$subcategories_array[$i]</span></li>";
		}	
		
		echo '</ul></fieldset>';
		echo '<div><input type="submit" name="submit" value="Perzgjidh"> 
		<a href="/filma_shqip/'.$ct.'">Anulo</a></div></form></div>';
		
		echo '<div id="filmat"> <div id="videoteka_bn_1">';
                	echo "<h3>Ti mund te blesh <span>5 filma per vetem $5</span>  ose <span>10 filma per vetem $10</span>!<br><br>Nese je i/e interesuar na kontakto ne e-mailin: <a href='mailto:videotekaime@gmail.com'>videotekaime@gmail.com</a>.</h3>";
		echo '</div>';
	  	echo '<ul id="lista_filmave_1">';	  	
	  	
		//Scripti qe gjeneron listen e filmave.
		$incl_return=include('/var/www/protected_scripts/movies_list_and_search_script.php');
				
		//Llogaritja e Range te dritares. 
		if($Window%5==0) $window_range=intval($Window/5);
		else $window_range=intval($Window/5)+1;
		
	 	echo '</ul></div>';
	 	
	 	echo '<ul id="bottom_nav"><li><a href="';
	 	//Numrat e navigacionit do te varen nga Current Window.
	 	if($window_range>1) echo '/filma_shqip/'.$ct.'/'.(($window_range-1)*5).'">';
	 	else {echo '#" class="greyed">';}
	 	echo '&lt;&lt;</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+1)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/filma_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+1).'"'; if(((($window_range-1)*5)+1)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+1).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+2)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/filma_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+2).'"'; if(((($window_range-1)*5)+2)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+2).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+3)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/filma_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+3).'"'; if(((($window_range-1)*5)+3)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+3).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+4)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/filma_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+4).'"'; if(((($window_range-1)*5)+4)==$Window) echo ' class="current"';}
	 	echo '>'.((($window_range-1)*5)+4).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+5)>$num_windows) echo '#" class="greyed"';
	 	else {echo '/filma_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+5).'"'; if(((($window_range-1)*5)+5)==$Window) echo ' class="current"';}
	 	echo '">'.((($window_range-1)*5)+5).'</a></li>
	 	
	 	<li><a href="';
	 	//Check if window is within range
	 	if(((($window_range-1)*5)+6)>$num_windows) echo '#" class="greyed"';
	 	else echo '/filma_shqip/'.$ct.'/'.$Sort.'/'.((($window_range-1)*5)+6);
	 	echo '">&gt;&gt;</a></li>
	 	
	 	</ul>
		</div>';
		
		//Kontrolli nese eshte futur manualisht nje dritare ne url. 
	    if($incl_return!=1) echo "<p>$incl_return</p>";
	    else if ($num_windows==0) echo "<p>Gabim - Nuk u gjend asnje rezultat qe perputhet me te dhenat e kerkuara.</p>";
	    else if($Window>$num_windows) echo "<p>Gabim - Kjo dritare eshte shume e madhe. Ka me pak filma se kaq.</p>";
    	    
    	    echo "</div>
    </body>	
</html>";
