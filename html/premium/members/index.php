<?php 
    /*----PHP Scripts And Variables----*/
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
    //----Scripts  
    include("../db_connect_premium.php"); 
    sec_session_start();
    
    include_once("uni/db_connect.php"); 
    
    //Declaring Varibales
    $user_agent=$_SERVER['HTTP_USER_AGENT'];
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
?>


<!DOCTYPE HTML>
<html lang="sq">    
    <head>
        <meta charset="utf-8">
        <meta name=”robots” content=”noindex, follow”>
    	<!-- +++ Title and meta tags section +++ --> 
        <title>Shiko seriale dhe filma shqip - Videotekaime.net</title>	
	<meta name="description" content="Shiko falas seriale me titra shqip (turke, italiane, amerikane, spanjolle, etj) si dhe filma me titra shqip, filma te dubluar ne shqip, filma shqiptar, etj me cilesi te larte! Eja ne videoteken tende virtuale, hidh nje sy dhe rehatohu!">
	<meta name="keywords" content="seriale me titra shqip, filma me titra shqip, filma te dubluar ne shqip, filma vizatimor">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Stylesheets for all screens +++ -->
	<link rel="stylesheet" type="text/css" href="uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="home_style.css">

	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="uni/Core.js"></script>
	<script type="text/javascript" src="uni/UniLib.js"></script>
	<script type="text/javascript" src="home.js"></script>
	
	<!-- +++ Outside Scripts +++ -->

    </head>
	
    <body>
    <?php if(login_check($mysqli) == true): ?>	    
        <!-- +++ Universal Header and Nav +++ -->
        <?php HeaderAndNavEcho("Kreu",""); ?>
        <script> var SubCategory="";</script>
        <!-- +++ Facebook Snippet +++ -->	
        <div id="fb-root"></div><script type="text/javascript" src="uni/FacebookSnippet.js"></script>
	
        <div id="introduction">
            <div id="intro_wrapper">
            <div id="offered_categories">
	        <h1>Çfare ofrojme:</h1>
	        <div>	        
	            <h2>Seriale me titra shqip</h2>
	            <!--Nenkategorite e serialeve-->
		    <ul>
			<?php  
			for($i=0; $i<count($SeriesArray)-1; $i++) {
			    echo '<li>'; echo StringParser($SeriesArray[$i], true); echo'</li>';
			}
			echo '<li>'; echo StringParser($SeriesArray[$i], true); echo'</li>';
			?>
	 	     </ul>
	  	</div>	
	  	
	  	<div>      
	  	     <!--Nenkategorite e filmave-->		
	 	     <h2>Shiko filma shqip:</h2>
		     <ul>
	                <?php   
		        for($i=0; $i<count($FilmsArray)-1; $i++) {
		            echo '<li>'; echo StringParser($FilmsArray[$i], true); echo'</li>';
		        }
		        echo '<li>'; echo StringParser($FilmsArray[$i], true); echo'</li>';
		        ?>
		      </ul>
		 </div>
	    </div>
	    
	    <div id="tutorial_and_videos_section">
	        <h1>Tutorial: Si te shohesh videot</h1>
	        <ul>
	             <li>Suport edhe per celulare dhe tablet</li>	
		     <li>Video dhe stream me cilesi te larte</li>		
		     <li>Falas, dedikuar gjithe shqiptareve</li>
		     <li>Perditesime ditore</li>		
	        </ul>
	        <div id="frame_wrapper">
	        <div id="frame_container">
	        	<iframe id="tutoriali" src="http://www.dailymotion.com/embed/video/x4zzvij"></iframe>
	        </div>
	        </div>
	    </div>
	    </div>
        </div>  
       
	<div id="content">
	    <!--Divizionet me tekst prezantues-->
	    <div id="text_divs_wrapper">
	    <div id="left_col_text_div">
		<h2>Shiko seriale me titra shqip</h2>
		<p>A deshiron te ndjekesh seriale me titra shqip te bukur dhe terheqes?
		Atehere eja dhe rehatohu! Videotekaime.net synon te ofroje seriale me titra shqip te bukur, terheqes, 
		popullore dhe te vecante, nga disa kategori te ndryshme: </p>
	  	<ul>
 		    <?php  
		    for($i=0; $i<count($SeriesArray)-1; $i++) {
		    echo '<li>'; echo StringParser($SeriesArray[$i], true); echo'</li>';
		    }
		    echo '<li>'; echo StringParser($SeriesArray[$i], true); echo'</li>';
		    ?>
	 	</ul>
		
		<h2>Suport per  mobile</h2>
		<p>Videotekaime.net ofron akses nga cdo pajisje mobile, smartfon apo tablet, si per serialet, ashtu edhe per filmat.
		Mjafton te klikosh butonin e filmit apo serialit per te shijuar filmin apo serialin e zgjedhur. Shikim te kendshem!
		</p>
	    </div>
		    
	   <div id="right_col_text_div">	
    	        <h2>Shiko filma shqip</h2>
	        <p>Videotekaime.net ofron filma shqip te shumellojshem dhe filma te rinj shtohen cdo dite.  
	        Kategorite kryesore te filmave jane:</p>	
	        <ul>
		    <?php  
		    for($i=0; $i<count($FilmsArray)-1; $i++) {
		    echo '<li>'; echo StringParser($FilmsArray[$i], true); echo'</li>';
		    }
		    echo '<li>'; echo StringParser($FilmsArray[$i], true); echo'</li>';
		    ?>
		</ul>
					
		<h2>Videoteka jote virtuale</h2>
		<p>Videotekaime.net synon te behet nje videoteke virtuale, qe do te mund te shfletohet nga cdo pajisje (kompjuter, celular apo tablet)! Filma dhe seriale te rinj shtohen vazhdimisht, duke shpresuar qe faqja jone te behet sa me shpejt nje videoteke personale me filma dhe seriale te ndryshme! Eja dhe bashkohu edhe ti me ne! Shikim te kendshem!
		</p>
	    </div>		
	    </div>
	       				
	    <!--Divizionet me te rejat e fundit-->
	    <div id="news_wrapper">
	    <div id="new_series">
		<?php FcbSeriesEcho(""); ?>
		<h2>Te reja nga serialet</h2>
		<!--- Navigator for new series -->
		<ul id="new_series_nav"><li class="current">1</li><li>2</li><li>3</li></ul>
		<ul id="lista_seriale">
		    <?php 
			$query="SELECT * FROM `Main_Premium` ORDER BY `Data_Perditesimit` DESC, `Rendi` DESC LIMIT 24"; 
			$result=mysqli_query($VID_SERIES, $query);
			while($row=mysqli_fetch_assoc($result)) {
			    $Last_Episode_Part_array=array();
			    $Last_Episode_Part_array=SeriesLastEpisodeParser($row["Episodi_i_fundit"]);
			    $title_str=SeriesNameParser($row["Indeksi"], $row["Dubluar_Titruar"], $Last_Episode_Part_array[0], $Last_Episode_Part_array[1]);
			    //Shtimi i episodit te fundit dhe i dates se perditesimit ne titull
			    $anchor_href="/premium/members/seriale_shqip/skeda/$row[Indeksi]$row[Dubluar_Titruar]";
			    $img_src="/seriale_shqip/foto/thumbs/".$row["Indeksi"].".jpg";
			    echo '<li>
			        <a href="'.$anchor_href.'">
			            <img src="'.$img_src.'" alt="" /><p>'.$title_str.'</p><p><span>Perditesuar me:</span> '.date_format(date_create($row["Data_Perditesimit"]), "d.m.Y").'</p>
			        </a>
			    </li>';
			}
		    ?>
		</ul>
	    </div>
					
	    <div id="new_movies">
	        <?php FcbMoviesEcho(""); ?>		
	        <h2>Te reja nga filmat</h2>
	        <ul id="new_movies_nav"><li class="current">1</li><li>2</li><li>3</li></ul>
	        <ul id="lista_filma">
	        <?php 
	            $query="SHOW TABLES";
	            $result=mysqli_query($VID_MOVIES, $query);
	            $limit=6;
	            $inner_query="";
	            $i=0;
	            while ($row=mysqli_fetch_array($result)) {
		        if($i==0) $inner_query=$inner_query."SELECT `Indeksi`,`Viti`,`Data_Shtimit`, '".$row[0]."' as Burimi  FROM `$row[0]`"; 
		        else $inner_query=$inner_query." UNION SELECT `Indeksi`,`Viti`,`Data_Shtimit`, '".$row[0]."' as Burimi FROM `$row[0]`";
		        $i++;
		    }
		    $inner_query=$inner_query." ORDER BY `Data_Shtimit` DESC LIMIT 24";
		    $inner_result=mysqli_query($VID_MOVIES, $inner_query);
		    //echo $inner_query;
		    while($inner_row=mysqli_fetch_assoc($inner_result)){
		    /*------------- Krijimi i stringut te titullit dhe rregullimi i linkut direkt-------------------*/
			$title_str=StringParser($inner_row["Indeksi"],"")." ($inner_row[Viti])";
			//Transformimi i emrit te tabeles ne nje konstante qe do te futet si kolona Burimi ne resultatet e querise
			
		        if($inner_row["Burimi"]=="filma_me_titra_shqip") $temp="_me_titra_shqip";
		        else if($inner_row["Burimi"]=="filma_te_dubluar_ne_shqip") $temp="_dubluar_ne_shqip";
		        else if($inner_row["Burimi"]=="filma_shqiptar") $temp="_shqiptar";
		        $title_str=$title_str.StringParser($temp, "");
		        
			$anchor_href="/premium/members/filma_shqip/skeda/$inner_row[Burimi]/$inner_row[Indeksi]"; 
			$img_src="/filma_shqip/foto/thumbs/$inner_row[Indeksi].jpg";
			echo '<li>
			<a href="'.$anchor_href.'">
			    <img src="'.$img_src.'" alt="" /><p>'.$title_str.'</p><p><span>Shtuar me:</span> '.date_format(date_create($inner_row["Data_Shtimit"]), "d.m.Y").'</p>
			</a>';
			echo '</li>';
		        }
		?>
	    	</ul>
	    </div>	
	</div>
    </div>
    </div>
    
    <?php else : ?>
    <script>alert("Vetem perdoriesit qe kane abonim kane te drejte ta aksesojne sherbimin premium kete faqe. Nese ke nje llogari premium, te lutemi te kycesh.");
    window.location.href="/premium/info.php";
    </script>
    
    
     <?php endif; ?>
    </body>
    	
</html>


        
