<?php
    /*----PHP Scripts And Variables----*/
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
    //----Scripts
    include_once("../uni/db_connect.php");
    //Declaring Varibales
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
    $Page_Id=1;
    session_start();
?>

<!DOCTYPE HTML>

<html lang="sq">
    <head>
        <!--<meta charset="utf-8"/>-->
    	<!-- +++ Title and meta tags section +++ -->
        <title>Stream - Videotekaime.net</title>
	<meta name="author" content="Videotekaime.net">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		echo '
		<!-- +++ Basic small screen style up to 960px +++ -->
		<link rel="stylesheet" type="text/css" href="/uni/uni_style.css">
		<link rel="stylesheet" type="text/css" href="/stream/stream_style.css">

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

	    <?php
	    include_once("stream_nav.php");
	    ?>

    	    <div id="video_wrapper">
    	        <div id="video_wrapper_no_ad">
        	    <?php
        	        if(isset($_SESSION["videoteka_Token"]))
        	        {
        		        $Token=$_SESSION["videoteka_Token"];
        		      	//Query per te nxjerre te gjitha informacionet e duhura.
        		      	$query="SELECT * FROM `Tokens` WHERE `Token`='$Token'";
        		        $row=mysqli_fetch_assoc(mysqli_query($VID_STATS, $query));
        		        //Film
        		        if($row["SoF"]=="F")
        		        {
        		        	$inner_query="SELECT * FROM `$row[Kategoria]` WHERE `Indeksi`='$row[Indeksi]'";
        		        	$inner_row=mysqli_fetch_assoc(mysqli_query($VID_MOVIES, $inner_query));
        		        	//Checking if Stream_1 Exists and getting streamlink accordingly
        		        	$result = mysqli_query($VID_MOVIES,"SHOW COLUMNS FROM `$row[Kategoria]` LIKE 'Stream_1'");
                            		$Stream_1_exists = (mysqli_num_rows($result))?TRUE:FALSE;
                            		$Streamlink=$inner_row["Stream_1"];
        		        	$Header=StringParser($row["Indeksi"], true);
/*					
					echo "<p style='display:none;'>";
if ($VID_MOVIES -> connect_errno) {
  echo "Failed to connect to MySQL: " . $VID_MOVIES -> connect_error;
  exit();
}
					print_r(mysqli_fetch_assoc(mysqli_query($VID_MOVIES,"SELECT * FROM `filma_shqiptar` WHERE `Indeksi`='Apasionata'")));
					echo "$inner_query$ </p>";
*/ 
        		        }
        		        //Serial
        		        else if($row["SoF"]=="S")
        		        {
        		        	if($row["Episodi"]==0) exit("Episodi 0 nuk ekziston.");
        		        	$inner_query="SELECT * FROM `$row[Indeksi]` WHERE `Episodi`='$row[Episodi]'";
        		        	$Header=StringParser($row["Indeksi"]." - Episodi ".$row["Episodi"], true);
        		        	//Ndrysho gjerat nese Seriali eshte me pjese.
        		        	if($row["Pjesa"]!=0 AND $row["Pjesa"]!=NULL)
        		        	{$inner_query=$inner_query." AND `Pjesa`='$row[Pjesa]'"; $Header=$Header." $row[Pjesa]";}
        		        	//Checking if Stream_1 Exists and getting streamlink accordingly
        		        	$inner_row=mysqli_fetch_assoc(mysqli_query($VID_SERIES, $inner_query));
        		            	$result = mysqli_query($VID_SERIES,"SHOW COLUMNS FROM `$row[Indeksi]` LIKE 'Stream_1'");
                            		$Stream_1_exists = (mysqli_num_rows($result))?TRUE:FALSE;
                            		$Streamlink=str_replace("/view", "/preview", $inner_row["Stream_1"]);
        		        }
        		        //Gabim ne SoF
        		        else exit("Gabim ne vleren e SoF");
        		        //Pjesa per futjen e videos (iframe)
        		        echo '<div id="video_div">
        		        <h1>'.$Header.'</h1>';

        		        /**---------------------------------------*/

        		        echo ' <div id="video_container">
        		        <iframe id="video_stream" scrolling="no"  src="'.$Streamlink.'" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"></iframe></div>
        		        </div>';

        		}
        	        else exit("Gabim ne procedure. Shiko Tutorialin ne faqen kreyesore per te mesuar proceduren e duhur."); //Mungon Tokeni
        	    ?>
    	        </div>
        </div>
    </div>

	<?php //Propelerads and Revenue Script ?>
        <script type="text/javascript" src="//deloplen.com/apu.php?zoneid=1671127" async></script>
	<script data-cfasync='false' type='text/javascript' src='//p92948.clksite.com/adServe/banners?tid=92948_423119_6&tagid=2'></script>


    </body>
</html>
