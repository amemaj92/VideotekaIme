<?php 
        /*----PHP Scripts And Variables----*/
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
    //----Scripts   
    include_once("../uni/db_connect.php");
    //Declaring Varibales
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
    $Page_Id=3;
    session_start();
?>

<!DOCTYPE HTML>

<html lang="sq">
    <head>
        <meta charset="utf-8"/>
    	<!-- +++ Title and meta tags section +++ --> 
        <title>Stream - Videotekaime.net</title>	
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		echo '
		<!-- +++ Basic small screen style up to 960px +++ -->
		<link rel="stylesheet" type="text/css" href="/uni/uni_style.css">
		<link rel="stylesheet" type="text/css" href="/stream/alt_stream_style_new.css">
		
		<!-- +++ Own Scripts +++ -->
		<script type="text/javascript" src="/uni/Core.js"></script>
		<script type="text/javascript" src="/uni/UniLib.js"></script>
		<script> var SubCategory="";</script>
		';
	?>
    </head>
	
    <body>	    
        <!-- +++ Universal Header and Nav  ++ Serving SubCategory as Input to Scripts+++ -->
        <?php HeaderAndNavEcho("",""); ?>
     
	<div id="content">
	    <div id="content_wrapper">
	        
    	    <div id="videotekaime_banner_1"></div>
    	    
    	    <div id="video_wrapper">
    	        
    	        <div id="video_wrapper_no_ad">
    	            
	    <?php
	    
		if(isset($_SESSION["videoteka_Token_alt"]))	   
	        {
		        $Token=$_SESSION["videoteka_Token_alt"];
		      	//Query per te nxjerre te gjitha informacionet e duhura.
		      	$query="SELECT * FROM `Tokens` WHERE `Token`='$Token'";
		        $row=mysqli_fetch_assoc(mysqli_query($VID_STATS, $query));
		        //Film
		        if($row["SoF"]=="F")
		        {
		            $Kategoria=$row["Kategoria"];
		            $Indeksi=$row["Indeksi"];
		            $Header=StringParser($row["Indeksi"], true);
		        	$inner_query="SELECT * FROM `$row[Kategoria]` WHERE `Indeksi`='$row[Indeksi]'";
		        	$inner_row=mysqli_fetch_assoc(mysqli_query($VID_MOVIES, $inner_query));
		        	$HostPlatform=$inner_row["Host"];
		        	$Streamlink=$HostPlatform."filma_shqip/$Kategoria/$Indeksi.mp4";
		        }
		        //Serial
		        else if($row["SoF"]=="S")
		        {	
		        	if($row["Episodi"]==0) exit("Episodi 0 nuk ekziston.");
		        	$Indeksi=$row["Indeksi"];
		        	$Episodi=$row["Episodi"];
		        	$inner_query="SELECT * FROM `$row[Indeksi]` WHERE `Episodi`='$row[Episodi]'";
		        	$Header=StringParser($row["Indeksi"]." - Episodi ".$row["Episodi"], true);
		        	//Ndrysho gjerat nese Seriali eshte me pjese.
		        	if($row["Pjesa"]!=0 AND $row["Pjesa"]!=NULL)
		        	{$Pjesa=$row["Pjesa"]; $inner_query=$inner_query." AND `Pjesa`='$Pjesa'"; $Header=$Header." $Pjesa";}
		        	
		        	$inner_row=mysqli_fetch_assoc(mysqli_query($VID_SERIES, $inner_query));
		        	$temp=mysqli_fetch_assoc(mysqli_query($VID_SERIES, "SELECT `Host` FROM `Main` WHERE `Indeksi`='$Indeksi'"));
		        	$HostPlatform=$temp["Host"];
		        	$Streamlink=$HostPlatform;
		        	$Streamlink=$Streamlink."seriale_shqip/$Indeksi/$Indeksi-$Episodi";
		        	if(!empty($Pjesa)) $Streamlink=$Streamlink."_$Pjesa";
		        	$Streamlink=$Streamlink.".mp4";		        	
		        	
		        }
		        //Gabim ne SoF
		        else exit("Gabim ne vleren e SoF");
	        }

        echo '
                <div id="video_div"><h1>'.$Header.'</h1>';
			        
			        echo '<div id="video_container">
			            <video controls oncontextmenu="return false;">
			        	    <source src="'.$Streamlink.'" type="video/mp4">
			       		</video>';
			       		echo '</div>
			        
			      </div>
                </div>
                
            <div id="videotekaime_banner_2" style="display: none; !important"></div>';   
    ?>
    
  <?php //Propelerads and Revenue Script ?>
        <script type="text/javascript" src="//deloplen.com/apu.php?zoneid=1671127" async></script>
        <script data-cfasync='false' type='text/javascript' src='//p92948.clksite.com/adServe/banners?tid=92948_423119_6&tagid=2'></script>

    
        <script type="text/javascript">
    //Banner_1
        //Script for flexible changes depending on the screen width
        var bn_1 = document.createElement("script");
        var bn_1_container=document.getElementById("videotekaime_banner_1");
        
        bn_1.type = "text/javascript";
        
        if (bn_1_container.offsetWidth < 155)
        {
           bn_1.src = "//p92948.clksite.com/adServe/banners?tid=92948_423119_10";  
        }
        else 
        {
            bn_1.src="//p92948.clksite.com/adServe/banners?tid=92948_423119_9";
        }
        bn_1_container.appendChild(bn_1);
    
    //Banner_2
        //Script for flexible changes depending on the screen width
        var bn_2_container=document.getElementById("videotekaime_banner_2");

        if (bn_2_container.offsetWidth > 155)
        {
           bn_2_container.innerHTML = '';  
        }
        else 
        {
            bn_2_container.innerHTML="";
        }
        
    </script>

	<?php 
	//Echoing variables to be used for stats.
	//Echoing variables to be used for stats.
	echo "<script>var videoteka_tokeni='$Token'; var videoteka_Streami=$Page_Id;";
	if($IsMobile) echo "var videoteka_DoMi='M';";
	else echo "var videoteka_DoMi='D';";
	echo "</script>";
	echo '<script type="text/javascript" src="/stream/stream.js"></script>';?>
	
   
    </body>	
</html>


	
