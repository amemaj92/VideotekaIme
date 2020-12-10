<?php 

if(isset($_GET["seriali"])) $seriali=$_GET["seriali"]; 
else exit("GABIM: Ju nuk keni percaktuar asnje serial."); 

/*----PHP Scripts And Variables----*/
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    //----Scripts   
   include_once("../uni/db_connect.php"); 
    //Declaring Varibales
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
/*----Start the Session----*/
session_start();

/*----------Setting Cookie for the PREMIUM OFFER------------------------*/
/*
$cookie_name = "offer_aware";
$cookie_value = 1;
if(!isset($_COOKIE[$cookie_name])) setcookie($cookie_name, $cookie_value, time() + 86400, "/"); // 86400 = 1 day
*/

//--------------Extracting the Index and findin the category through the Database. 
//Finding the position of me_titra_dubluar_pos to extract the Index. 
$me_titra_dubluar_pos=-1; 
if(strpos($seriali, "_me_titra_shqip")) $me_titra_dubluar_pos=strpos($seriali, "_me_titra_shqip"); 
else if(strpos($seriali, "_dubluar_ne_shqip"))  $me_titra_dubluar_pos=strpos($seriali, "_dubluar_ne_shqip");
else exit("Ka nje gabim ne te dhenat tuaja. Provojeni perseri"); 

//Extracting the Index
$Indeksi=substr($seriali, 0, $me_titra_dubluar_pos); 
$Titulli= StringParser($Indeksi, 1);
$me_titra_dubluar=StringParser(substr($seriali, $me_titra_dubluar_pos), 0); 
$Window=1; 
//Getting the Data of the Series to be used from the Main Table
$query="SELECT * FROM `Main` WHERE `Indeksi`='$Indeksi'";
$row=mysqli_fetch_assoc(mysqli_query($VID_SERIES, $query));
$LastSeasonEpisodeArray=LastSeasonEpisodeArray($row["Sezonet"]);
$Kategoria=$row["Kategoria"]; 

echo '
<!DOCTYPE HTML>

<html lang="sq">
    <head>
        <meta charset="windows-1252">
    	<!-- +++ Title and meta tags section +++ --> 

        <title>'.$Titulli.' - Videotekaime.net</title>				
	<meta name="description" content="Eja shiko falas serialin '.$Titulli.' me cilesi te larte, me episode te plota dhe pa mungesa! Ne ofrojme seriale te reja por edhe seriale popullore, dhe perpiqemi t\'i perditesojme cdo dite me episode te reja. Eja, hidh nje sy dhe rehatohu!">
	<meta name="keywords" content="seriale me titra shqip">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Styling +++ -->
	<link rel="stylesheet" type="text/css" href="/uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="/seriale_shqip/skeda_style_new.css">
	<link rel="stylesheet" type="text/css" href="/seriale_shqip/oferta_style.css">
	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="/uni/Core.js"></script>
	<script type="text/javascript" src="/uni/UniLib.js"></script>
	<script type="text/javascript" src="/seriale_shqip/skeda_new.js"></script>
	<!-- +++ Defining variables for use +++ -->
	<script>
	var Indeksi="'.$Indeksi.'";
	var Curr_window="'.$Window.'";
	</script>
	
	<!-- +++ Outside Scripts +++ -->
	<script type="text/javascript" src="/uni/GoogleAnalytics.js"></script>
    </head>
    <body>';

   /*--------------------------COOKIE FOR DISPLAYING PREMIUM OFFER AD-------------
    
    if(!isset($_COOKIE[$cookie_name])) {
        if(!isset($_SESSION["offer_seen"])) {$_SESSION["offer_seen"]=time(); $offer_seen=false;}
        else {if(time()-$_SESSION["offer_seen"]<10)  $offer_seen=true; else {$offer_seen=false; $_SESSION["offer_seen"]=time();}}
    }else{
        $offer_seen=true;
    }
    
    if(!$offer_seen)
    {
        echo '
        <!--Blloku i Ofertes Verore-->
        <div id="black_background">
            <div id="offer_plakat">
                <img src="/uni/images/Oferta/bck.png" style="width: 100%; height: 100%;">
                <ul id="butonat_oferta">
                    <li style="margin-top: 0px !important;"><a href="/NEW/premium/info.php" class="button_yes"></a></li>
                    <li><a href="" class="button_no" id="no_button"></a></li>
                </ul>
            </div>
        </div>
        <script>
            document.getElementById("no_button").addEventListener("click", function(event){
                event.preventDefault();
                document.getElementById("black_background").style.display="none";
            });
        </script>';
    }
    
    //Pop Ad
    if ($offer_seen){echo "<script async type='text/javascript' src='//p92948.clksite.com/adServe/banners?tid=92948_423119_6&tagid=2&pop_dl=false'></script>";}
    ---------------------*/

    echo "<script async type='text/javascript' src='//p92948.clksite.com/adServe/banners?tid=92948_423119_6&tagid=2&pop_dl=false'></script>";

    echo'
        <!-- +++ Universal Header and Nav  ++ Serving SubCategory as Input to Scripts+++ -->';
        HeaderAndNavEcho("Seriale",$Kategoria); 
        echo '<script> var SubCategory="seriale_subnav";</script>
        <!-- +++ Facebook Snippet +++ -->	
        <div id="fb-root"></div><script type="text/javascript" src="/uni/FacebookSnippet.js"></script>
	      
	<div id="content">
	    <div id="info">
	        <div id="basic_info" itemscope itemtype="http://schema.org/TVSeries">';
		        
		/*-----------------Problematic Series with DMCA -----------------------
	        if($Indeksi=="Enderr_Luleshtrydhesh" or $Indeksi=="Stina_e_Qershive" or  $Indeksi=="Nusja_nga_Stambolli" or $Indeksi=="Dashuri_me_Qira" or $Indeksi=="Mos_ma_lesho_doren" or $Indeksi=="Hakmarrje_e_embel")
	        
	        {
	            echo '<h1>Ky serial eshte hequr me kerkese te kompanise Tring per shkelje se te Drejtes se Autorit.</h1><br><h4>Per me shume informacion na kontaktoni ne <a href="https://www.facebook.com/serialemetitrashqip/">Facebook<a/>.</h4>';
	            echo '</div>
		        </div></body></html>';
		        
		        exit();
	        }
	        *------------------------------------*/
	        
	    echo '     
		<h1 itemprop="name">'.StringParser($seriali, 1).'</h1>';
		/*-----Nxjerra e gjithe te dhenave qe do te shfaqen.-----*/	
		$inner_query="SELECT * FROM `$row[Indeksi]` ORDER BY `Episodi` DESC";
		$inner_row=mysqli_fetch_assoc(mysqli_query($VID_SERIES, $inner_query));
		$Last_Episode=$inner_row["Episodi"];
		
		/*-----Shfaqja e te dhenave-----*/
		echo '
		<img itemprop="image" src="/seriale_shqip/foto/'.$row["Indeksi"].'.jpg" />';	

		/****-------------------------****/
			
		FcbSeriesEcho("");	
		
		//****------------------Adnow Code for big screens
		echo '
		<div id="videotekaime_banner_1" style="display: none; !important">
		   
		</div>
		';
		
		
		echo '<ul>';
		    if($row["Tituj_te_Tjere"]!="")
		    {
		    	if($row["Indeksi"]=="Poyraz_Karayel" OR $row["Indeksi"]=="Icerde" OR $row["Indeksi"]=="Kenga_e_Jetes")
		    	{echo "<li><span>Perkthyer nga:</span> <i>La Asi dhe Grupi Fluturat</i></li>";}
		    	else echo '<li><span>Tituj te Tjere:</span> <i itemprop="alternateName">'.str_replace(",", ", ", $row["Tituj_te_Tjere"]).'</i></li>';
		    }
		echo '
		    <li><span>Zhanri:</span> <i>'.str_replace(",", ", ", $row["Nenkategorite"]).'</i></li>
		    <li><span>Prodhuar ne vitet:</span> <i>'.$row["Viti1"].'-'; 
		    if($row["Viti2"]==3000) echo date("Y");
		    else echo $row["Viti2"];
		    echo '</i></li>
		    <li><span>Sezonet:</span> <i>'.str_replace(",", ", ", $row["Sezonet"]).'</i></li>
		    <li><span>Perditesimi i fundit:</span> <i>'.date_format(date_create($row["Data_Perditesimit"]), "d.m.Y").'</i></li>
		    <li><span>Statusi:</span> <i>'.SeriesStatusEcho($row["Sezonet"], $Last_Episode, $row["Data_Perditesimit"]).'</i></li>
		</ul>
		</div>';
		
		echo '
		<div id="more_info" class="untoggled">';
		echo '
		<p><span>Regjia:</span> <i itemprop="director">'.str_replace(",", ", ", $row["Regjia"]).'</i></p>
		<p><span>Aktoret:</span> <i itemprop="actor">'.str_replace(",", ", ", $row["Aktoret"]).'</i></p>
		<p itemprop="description"><span>Pershkrim i shkurter:</span><br> '.$row["Pershkrimi"].'</p>
		</div>
		<a href="#" id="info_toggle">Lexo me shume...</a>
		</div> ';
		
		
		
		echo '
		<div id="episodet">';
		
				   /****------------Banner nr.1-------------****/
		echo '<div id="videotekaime_banner_2" style="display: none; !important">';

        //First Visit ----->  AdMaven
        echo '
        <script type="text/javascript">
            //Script for flexible changes depending on the screen width
            var bn_2_container=document.getElementById("videotekaime_banner_2");
           
            /*--Code Snippet
            if (screen.width>480){}
            else {} */
            
        </script></div>';

	$buy_option=10; 
	$rreshti=""; 
	
	//Kontrollo nese Seriali eshte i gjate. Nese po ndrysho vleren e blerjes. 
	$file_name="Buy_Prices.txt";        	//Emri i file-it
	$file_handle=fopen($file_name, "r");    //Objekti per file-in
	while (!feof($file_handle))
	{
        	$rreshti=preg_replace('/\s/', '', fgets($file_handle));   //Indeksi i serialit nga file
        	if($rreshti==$Indeksi) $buy_option=20;
	}

		//echo "<h3 style='border-bottom: 2px solid blue; margin: 10px 5%; padding: 3%; font-size:90%; color: orangered; '>Ti mund ta blesh kete serial per vetem <span style='font-size: 100%; font-weight: bold;'>\$$buy_option</span>!<br><br>Nese je i/e interesuar na kontakto ne e-mailin: <a href='mailto:videotekaime@gmail.com'>videotekaime@gmail.com</a>.</h3>";
	
		
		echo '<h2>'.StringParser($seriali, 1).' Episodi ...</h2>';
		    
		echo '<form method="POST" action="">
		            <label for="episodi">Nr. i Episodit qe kerkon</label>
		            <input type="text" name="episodi" id="ep_inp">
		            <input type="submit" value="Kerko" id="kerko">
		            <input type="reset" value="Anulo" id="anulo">
		        </form>';
		        
		/****-------------------------****/
		

		echo '<ul id="lista_episodeve">';
		    
		$query2="SELECT * FROM `$Indeksi` ORDER BY `Episodi` DESC";
		$result2=mysqli_query($VID_SERIES, $query2);
		$row2=mysqli_fetch_assoc($result2);
		
		if(isset($row2["Pjesa"])) $query2=$query2.",`Pjesa` DESC"; 
		$result2=mysqli_query($VID_SERIES, $query2);
				
		//*------------Printimi i listes se episodeve
		$i=0;
		while($row2=mysqli_fetch_assoc($result2))
		{	
			if($i==0) 	//Behet vetem per iteracionin e pare. 
			{
			    $Sezoni=0;
			    $j=count($LastSeasonEpisodeArray)-1; //Last Season Episode Array mban episodet e fundit te cdo Sezoni.
			    while($j>=0)
			    {
			        if($row2["Episodi"]==$LastSeasonEpisodeArray[$j]) {$Sezoni=$j; break;}	//Inicializojme variablin Sezoni me te fundit nese Episodi i fundit eshte i barabarte me Episodin e fundit te sezonit te fundit, pra nese seriali eshte i perfunduar. 
			        else if($row2["Episodi"]>$LastSeasonEpisodeArray[$j]) {$Sezoni=$j+1; break;}	//Perndryshe e ulim sezonin derisa episodi te jete nje mbi vleren e Sezonit, pastaj variablin $Sezoni e inicializojme me Sezonin e episodit te fundit, qe eshte  $j+1 
			        $j--;
			        //Kjo procedure siguron qe nese episodi eshte me i vogel se Episodi i Sezonit te fundit (pra seriali eshte ne vazhdim, ose aktiv), s$Seriali te marre vleren e duhur kur te arrihet pika qe episodi eshte me i madh ose i barabarte me episodin e fundit te nje nga Sezoneve te meparshme 			    		
			   }
		   	}
			//E zbresim vleren fillestare te Sezonit kur Episodi i radhes arrin vleren e Episodit te fundit te nje sezoni me poshte.
			if(($Sezoni>0) AND ($row2["Episodi"]==($LastSeasonEpisodeArray[$Sezoni-1]))) $Sezoni--;	        
			    echo '<li itemscope itemtype="http://schema.org/Episode">'; 
			    echo '<a itemprop="url" ';
			    if($row2["Episodi"]<=$LastSeasonEpisodeArray[$Sezoni]) echo 'class="sezoni'.($Sezoni+1).'" ';
			    $LinkHref="/uni/find_stream.php?SoF=S&Kategoria=$row[Kategoria]&Indeksi=$Indeksi&Episodi=$row2[Episodi]"; 
			    if(isset($row2["Pjesa"])) $LinkHref=$LinkHref."&Pjesa=$row2[Pjesa]";
			    $LinkHref=$LinkHref;
			    echo 'href="'.$LinkHref.'" target="blank"><span></span>'.$Titulli.' Episodi '.$row2["Episodi"];		
			   if(isset($row2["Pjesa"])) echo '-'.$row2["Pjesa"]; 
			   echo '</a>';				
			   echo '</li>
			   ';
			$i++;
		}
		    
		    echo '</ul>
	 	    <ul id="bottom_nav"><li><<</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>>></li></ul>';
	        echo '</div>
		    </div>';
		    
		    
		 ?>
		 
       </body>	
</html>
