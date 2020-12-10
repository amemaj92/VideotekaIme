<?php 

if(isset($_GET["ct"])) $Kategoria=$_GET["ct"]; 
else exit("GABIM: Ju nuk keni percaktuar asnje kategori filmash."); 
if(isset($_GET["mov"])) $Indeksi=$_GET["mov"]; 
else exit("GABIM: Ju nuk keni percaktuar asnje film."); 
/*----PHP Scripts And Variables----*/
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    
    //Login Scripts
    include_once ('/var/www/html/premium/db_connect_premium.php');
    sec_session_start();
    
    //Series and Movies scripts
    include_once("/var/www/html/premium/members/uni/db_connect.php"); 
    //Declaring Varibales
    $user_agent=$_SERVER['HTTP_USER_AGENT'];
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();

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
        <meta charset="windows-1252">
    	<!-- +++ Title and meta tags section +++ --> 

        <title>'.$Titulli.StringParser($me_titra_dubluar, 0).' - Videotekaime.net</title>
        <meta name=”robots” content=”noindex, follow”>
	<meta name="description" content="Eja shiko falas filmin '.$Titulli.StringParser($me_titra_dubluar, 0).' me cilesi te larte! Ne ofrojme filma shqip te rinj, te vjeter por edhe filma shqip popullore, dhe perpiqemi t\'i perditesojme cdo dite. Eja, hidh nje sy dhe rehatohu!">
	<meta name="keywords" content="seriale me titra shqip">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Styling +++ -->
	<link rel="stylesheet" type="text/css" href="/premium/members/uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="/premium/members/filma_shqip/skeda_style.css">
	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="/premium/members/uni/Core.js"></script>
	<script type="text/javascript" src="/premium/members/uni/UniLib.js"></script>
	<!-- +++ Defining variables for use +++ -->
	<script>
	var Indeksi="'.$Indeksi.'";
	var Curr_window="'.$Window.'";
	</script>
	<!-- +++ Outside Scripts +++ -->
    </head>
    <body>
    ';
    
    if(login_check($mysqli) == true)  
    {
    	echo '	 	    
        <!-- +++ Universal Header and Nav  ++ Serving SubCategory as Input to Scripts+++ -->';
        HeaderAndNavEcho("Filma",$Kategoria); 
        echo '<script> var SubCategory="filma_subnav";</script>
        <!-- +++ Facebook Snippet +++ -->	
        <div id="fb-root"></div><script type="text/javascript" src="/uni/FacebookSnippet.js"></script>
	      
	<div id="content">
	    <div id="info">
	        <div id="basic_info" itemscope itemtype="http://schema.org/TVSeries">
		<h1 itemprop="name"><span>'.$Titulli.StringParser($me_titra_dubluar, 0);
		$LinkHref="/premium/members/stream/stream.php?SoF=F&Kategoria=$Kategoria&Indeksi=$Indeksi";
		echo '</span><a href="'.$LinkHref.'" id="movie_link" target="_blank">Kliko ketu per ta pare filmin!</a>
		</h1>';
		
		echo '<h2>Traileri i filmit</h2>';
		/*-----Nxjerra e gjithe te dhenave qe do te shfaqen.-----*/	

		/*-----Shfaqja e te dhenave-----*/
		echo '
		<div id="video_container"><video controls poster="/filma_shqip/foto/'.$row["Indeksi"].'.jpg'.'">
  			<source src="'.$row["Host"].'trailers/filma_shqip/'.$Kategoria.'/'.$Indeksi.'.mp4" type="video/mp4">
	  		Browseri yt nuk suporton HMTL5 :(.
  			</video>
		<div></div>';
		FcbMoviesEcho(""); echo '</div>';		
		
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
		
				
		echo '<div id="description"><p itemprop="description"><span>Pershkrim i shkurter:</span><br> '.$row["Pershkrimi"].'</p></div>		
		</div> 		
		</div>';
	    }
	    else 
    	    {
	    	echo '<script>alert("Vetem perdoriesit qe kane abonim kane te drejte ta aksesojne sherbimin premium kete faqe. Nese ke nje llogari premium, te lutemi te kycesh."); window.location.href="/premium/info.php"; </script>';
    	    }
    	    
    	    echo '		
       </body>	
</html>';
?>   
