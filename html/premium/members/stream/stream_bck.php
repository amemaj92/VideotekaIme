<?php 
    /*----PHP Scripts And Variables----*/
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
       //Login Scripts
    include_once ('/var/www/html/premium/db_connect_premium.php');
    sec_session_start();
    
    //Series and Movies scripts
    include_once("/var/www/html/premium/members/uni/db_connect.php");  
    
    //Declaring Varibales
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
?>

<!DOCTYPE HTML>

<html lang="sq">
    <head>
        <meta charset="utf-8"/>
        <meta name=”robots” content=”noindex, follow”>
    	<!-- +++ Title and meta tags section +++ --> 
        <title>Stream - Videotekaime.net</title>	
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		echo '
		<!-- +++ Basic small screen style up to 960px +++ -->
		<link rel="stylesheet" type="text/css" href="/premium/members/uni/uni_style.css">
		<link rel="stylesheet" type="text/css" href="stream_style.css">
		
		<!-- +++ Own Scripts +++ -->
		<script type="text/javascript" src="/premium/members/uni/Core.js"></script>
		<script type="text/javascript" src="/premium/members/uni/UniLib.js"></script>
		';
	?>
    </head>
	
    <body>	    
        <!-- +++ Universal Header and Nav  ++ Serving SubCategory as Input to Scripts+++ -->
        <?php HeaderAndNavEcho("",""); ?>
        <script> var SubCategory="";</script>
        
	<div id="content">
	
	<?php if(login_check($mysqli) == true): ?>	    
	
	    <?php
	    
	    
	    //Checks if user has come from videotekaime.net , from another site, or if it has no referer.
		if(isset($_SERVER["HTTP_REFERER"])) $referer=$_SERVER["HTTP_REFERER"];
		else $referer="http://videotekaime.net";

		//Keshtu eleminohen kerkesat qe mund te vijne nga faqe te tjera me referer te percaktuar, te ndryshem nga videotekaime.net
		if(strpos($referer, "videotekaime.net") OR strpos($referer, "178.17.171.72")) 
		{
			if(isset($_GET["SoF"]))
			{
			    if(isset($_GET["Kategoria"]))
			    {
			        if(isset($_GET["Indeksi"]))
			        {
			             $SoF=$_GET["SoF"];
			             $Kategoria=$_GET["Kategoria"];
			             $Indeksi=$_GET["Indeksi"];
			             $Episodi="";
			             $Pjesa="";
			             //Degezimi: Nese eshte film vazhdo.     
			             //Nese eshte serial kontrollo nese jane dhene dhe variablat e tjere, pastaj vazhdo.          
			             if($SoF=="S")
			             {
			             	if(isset($_GET["Episodi"])) 
			             	{
			             		$Episodi=$_GET["Episodi"];
			             		$query="SELECT * FROM `$Indeksi`";
			             		$row=mysqli_fetch_assoc(mysqli_query($VID_SERIES, $query));
			             		//Kontrollo per pjesen vetem nese ajo duhet (pra nese ekziston) 
			             		if(isset($row["Pjesa"])) 
			             		{
			             		    if(isset($_GET["Pjesa"])) 
			             		    {
			             		    	$Pjesa=$_GET["Pjesa"];
			             		    }
			             		    else exit("Gabim ne te dhena #05."); 
			             		}
			                 }
			             	 else exit("Gabim ne te dhena #04.");  
			              }
			        }
			        else  exit("Gabim ne te dhena #03.");               
			    }
			    else exit("Gabim ne te dhena #02.");	     
			}     	 
			else exit("Gabim ne te dhena #01.");
		}
		else exit("Gabim ne ardhje. Shikoni tutorialin ne faqen kryesore per te ndjekur proceduren e sakte.");

		        //Film
		        if($SoF=="F")
		        {
		        	$Header=StringParser($Indeksi, true);
		        	//Creating the Streamlink
		        	$inner_query="SELECT * FROM `$Kategoria` WHERE `Indeksi`='$Indeksi'";
		        	$inner_row=mysqli_fetch_assoc(mysqli_query($VID_MOVIES, $inner_query));
		        	$HostPlatform=$inner_row["Host"];
		        	$Streamlink=$HostPlatform."filma_shqip/$Kategoria/$Indeksi.mp4";
		        }
		        //Serial
		        else if($SoF=="S")
		        {	
		        	$Header=StringParser(($Indeksi." - Episodi ".$Episodi." ".$Pjesa), true);
		        	//Creating the Streamlink
		        	$temp=mysqli_fetch_assoc(mysqli_query($VID_SERIES, "SELECT `Host` FROM `Main` WHERE `Indeksi`='$Indeksi'"));
		        	$HostPlatform=$temp["Host"];
		        	$Streamlink=$HostPlatform;
		        	$Streamlink=$Streamlink."seriale_shqip/$Indeksi/$Indeksi-$Episodi";
		        	if(!empty($Pjesa)) $Streamlink=$Streamlink."_$Pjesa";
		        	$Streamlink=$Streamlink.".mp4";		        	
		        }
		       
		        //Gabim ne SoF
		        else exit("Gabim ne vleren e SoF");
  	 
		        if(!isset($_SESSION["Videot_e_Hapura"])) $_SESSION["Videot_e_Hapura"]=array();
		        $opened=in_array($Streamlink, $_SESSION["Videot_e_Hapura"]); 
		       			
	        	$user_id=$_SESSION["user_id"];
	        	$username=$_SESSION["username"];
	        	
	        	$query="SELECT *  FROM `payments` WHERE `user_id`='$user_id' AND `username`='$username' ORDER BY `Data_e_Skadences` DESC LIMIT 1";
	        	$row=mysqli_fetch_assoc(mysqli_query($mysqli, $query));
	        	$ID=$row["ID"];
	        	$Kredite_te_Mbetura=intval($row["Kredite_te_Mbetura"]);
	        	$Statusi_i_Aprovimit=$row["Statusi_i_Aprovimit"];
	        	$Data_e_Skadences=$row["Data_e_Skadences"];
	        	
	        	$rightToWatch=user_has_right_to_watch($Statusi_i_Aprovimit,$Kredite_te_Mbetura,$Data_e_Skadences);
	        	if($rightToWatch>0)
		        {

				echo '<div id="video_div">';
			        echo '
			        <h1>'.$Header.'</h1>';
			        echo '<div id="video_container"><video controls autoplay oncontextmenu="return false;">
			        	<source src="'.$Streamlink.'" type="video/mp4">
			       		</video>';
			       		echo '</div>';	
				if($opened==false) 
			       	{
			        	$Kredite_te_Mbetura--; 
			        	$query="UPDATE `payments` SET `Kredite_te_Mbetura`='$Kredite_te_Mbetura' WHERE `ID`='$ID' AND `user_id`='$user_id' AND `username`='$username'";
			        	mysqli_query($mysqli, $query);
			        	array_push($_SESSION["Videot_e_Hapura"],$Streamlink);
		        	}
		        }
		        else echo  '<h1>Ti nuk ke te drejte te shohesh video sepse llogaria jote nuk ka kredite, abonimi ka skaduar, ose eshte duke u aprovuar.</h1>';				        		       
	?>
        </div>
	<?php 
	//Echoing variables to be used for stats.
	echo '<script type="text/javascript"> 
	
	var request=new XMLHttpRequest();
	setTimeout(function()
	{
	    request.open("GET", "/premium/members/uni/fill_stats.php?SoF='.$SoF.'&Kategoria='.$Kategoria.'&Indeksi='.$Indeksi.'", true);
	    request.send();
	}, 300000); 
 	</script>';?>
 	
 	 <?php else: ?>
         <script>alert("Vetem perdoriesit qe kane abonim kane te drejte ta aksesojne sherbimin premium kete faqe. Nese ke nje llogari premium, te lutemi te kycesh.");
         window.location.href="/premium/info.php";
         </script>
    
         <?php endif; ?>
	
    </body>	
</html>


	
