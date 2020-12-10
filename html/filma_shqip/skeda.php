<?php 

if(isset($_GET["ct"])) $Kategoria=$_GET["ct"]; 
else exit("GABIM: Ju nuk keni percaktuar asnje kategori filmash."); 
if(isset($_GET["mov"])) $Indeksi=$_GET["mov"]; 
else exit("GABIM: Ju nuk keni percaktuar asnje film."); 
/*----PHP Scripts And Variables----*/
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    //----Scripts   
    include_once("../uni/db_connect.php");
    //Declaring Varibales
    $user_agent=$_SERVER['HTTP_USER_AGENT'];
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();

session_start();

/*----------Setting Cookie for the PREMIUM OFFER------------------------*/
/*
$cookie_name = "offer_aware";
$cookie_value = 1;
if(!isset($_COOKIE[$cookie_name])) setcookie($cookie_name, $cookie_value, time() + 86400, "/"); // 86400 = 1 day
*/

//Extracting the Index
$Titulli= StringParser($Indeksi, 1);
if($Kategoria=="filma_me_titra_shqip") $me_titra_dubluar="_me_titra_shqip";
else if($Kategoria=="filma_te_dubluar_ne_shqip") $me_titra_dubluar="_dubluar_ne_shqip";
$me_titra_dubluar=""; 
$Window=1; 
//Getting the Data of the Movie to be used from the $Kategoria Table
$query="SELECT * FROM `$Kategoria` WHERE `Indeksi`='$Indeksi'";
$row=mysqli_fetch_assoc(mysqli_query($VID_MOVIES, $query));

echo '
<!DOCTYPE HTML>

<html lang="sq">
    <head>
        <meta charset="utf-8">
    	<!-- +++ Title and meta tags section +++ --> 

        <title>'.$Titulli.StringParser($me_titra_dubluar, 0).' - Videotekaime.net</title>				
	<meta name="description" content="Eja shiko falas filmin '.$Titulli.StringParser($me_titra_dubluar, 0).' me cilesi te larte! Ne ofrojme filma shqip te rinj, te vjeter por edhe filma shqip popullore, dhe perpiqemi t\'i perditesojme cdo dite. Eja, hidh nje sy dhe rehatohu!">
	<meta name="keywords" content="seriale me titra shqip">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Styling +++ -->
	<link rel="stylesheet" type="text/css" href="/uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="/filma_shqip/skeda_style_new.css">
	<link rel="stylesheet" type="text/css" href="/filma_shqip/oferta_style.css">
	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="/uni/Core.js"></script>
	<script type="text/javascript" src="/uni/UniLib.js"></script>
	<!-- +++ Defining variables for use +++ -->
	<script>
	var Indeksi="'.$Indeksi.'";
	var Curr_window="'.$Window.'";
	</script>
	<!-- +++ Outside Scripts +++ -->
	<script type="text/javascript" src="/uni/GoogleAnalytics.js"></script>
    </head>
    <body>';	 
  
/*-----------------COOKIE FOR DISPLAYING PREMIUM OFFER AD
    if(!isset($_COOKIE[$cookie_name])) {
        if(!isset($_SESSION["offer_seen"])) {$_SESSION["offer_seen"]=time(); $offer_seen=false;}
        else {if(time()-$_SESSION["offer_seen"]<86400)  $offer_seen=true; else {$offer_seen=false; $_SESSION["offer_seen"]=time();}}
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
                    <li style="margin-top: 0px !important;"><a href="/premium/info.php" class="button_yes"></a></li>
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

-------------------------*/    
    
    echo "<script async type='text/javascript' src='//p92948.clksite.com/adServe/banners?tid=92948_423119_6&tagid=2&pop_dl=false'></script>";

    echo'
    
    
        <!-- +++ Universal Header and Nav  ++ Serving SubCategory as Input to Scripts+++ -->';
        HeaderAndNavEcho("Filma",$Kategoria); 
        echo '<script> var SubCategory="filma_subnav";</script>
        <!-- +++ Facebook Snippet +++ -->	
        <div id="fb-root"></div><script type="text/javascript" src="/uni/FacebookSnippet.js"></script>
	      
	<div id="content">
	    <div id="info">
	        <div id="basic_info" itemscope itemtype="http://schema.org/TVSeries">
		<h1 itemprop="name"><span>'.$Titulli.StringParser($me_titra_dubluar, 0);
		$LinkHref="/uni/find_stream.php?SoF=F&Kategoria=$Kategoria&Indeksi=$Indeksi";
		echo '</span><a href="'.$LinkHref.'" id="movie_link" target="_blank">Kliko ketu per ta pare filmin!</a>
		</h1>';
		
		echo '<div id="videotekaime_banner_1" style="display:none; !important"></div>';
		
		echo '<h2>Traileri i filmit</h2>';
		/*-----Nxjerra e gjithe te dhenave qe do te shfaqen.-----*/	

		/*-----Shfaqja e te dhenave-----*/
		echo '
		<div id="video_container"><video controls poster="/filma_shqip/foto/'.$row["Indeksi"].'.jpg'.'">
  			<source src="/filma_shqip/trailers/'.$Kategoria.'/'.$Indeksi.'.mp4" type="video/mp4">
	  		Browseri yt nuk suporton HMTL5 :(.
  			</video>
		<div></div>';
		FcbMoviesEcho(""); echo '</div>';		
			
		/****------------Banner nr.1,2-------------****/
		echo '<div id="videotekaime_banner_2" style="display:none; !important"></div>';	
		
		/****-------------------------****/
		echo '<div id="skeda_info">
		<ul>';
		    if($Kategoria!="filma_shqiptar") {echo '<li><span>Tituj te Tjere:</span> <i itemprop="alternateName">'.str_replace(",", ", ", $row["Tituj_te_Tjere"]).'</i></li>';}
		    echo'<li><span>Zhanri:</span> <i>'.str_replace(",", ", ", $row["Nenkategorite"]).'</i></li>
		    <li><span>Prodhuar ne vitin:</span> <i>'.$row["Viti"].'</i></li>
		    <li><span>Shtuar me:</span> <i>'.date_format(date_create($row["Data_Shtimit"]), "d.m.Y").'</i></li>';
		    if($Kategoria!="filma_te_dubluar_ne_shqip") {echo '<li><span>Regjia:</span> <i itemprop="director">'.str_replace(",", ", ", $row["Regjia"]).'</i></li>';}
		    else {echo '<li><span>Studio/Regjia:</span> <i itemprop="production_studio">'.str_replace(",", ", ", $row["Studio"]).'</i></li>';}
		    if($Kategoria!="filma_te_dubluar_ne_shqip") {echo '<li><span>Aktoret:</span> <i itemprop="actor">'.str_replace(",", ", ", $row["Aktoret"]).'</i></li>';}
		echo '
		</ul>
		</div>';
		
			
		/****-------------------------****/
		
		echo '<div id="description"><p itemprop="description"><span>Pershkrim i shkurter:</span><br> '.$row["Pershkrimi"].'</p></div>		
		</div> 		
		</div>
		
	    <script type="text/javascript">
	    
        //Script for flexible changes depending on the screen width
        var bn_1_container=document.getElementById("videotekaime_banner_1");
        
        if (screen.width<730)
        {
            var bn_1 = document.createElement("script");
            bn_1.type = "text/javascript";
            bn_1.src="//p92948.clksite.com/adServe/banners?tid=92948_423119_1";
            bn_1_container.appendChild(bn_1);
        }
        else 
        {
        }

        
        //Script for flexible changes depending on the screen width
        var bn_2_container=document.getElementById("videotekaime_banner_2");
        
        if (bn_2_container.offsetWidth > 750) {}
        else {}
        
        </script>
        
        
       </body>	
</html>';
 
