<?php 
    /*----PHP Scripts And Variables----*/
    	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
    //----Scripts   
    //Login Scripts
    include_once ('../db_connect_premium.php');
    sec_session_start();
    
    //Series and Movies scripts
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
        <title>Shiko seriale dhe filma shqip - Videotekaime.net Premium</title>	
	<meta name="description" content="Shiko seriale me titra shqip (turke, italiane, amerikane, spanjolle, etj) si dhe filma me titra shqip, filma te dubluar ne shqip, filma shqiptar, etj pa mungesa, pa reklama dhe me cilesi te larte! Abonohu ne videoteken tende virtuale, dhe shiko gjithcka ke deshire!">
	<meta name="keywords" content="seriale me titra shqip, filma me titra shqip, filma te dubluar ne shqip, filma vizatimor">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Stylesheets for all screens +++ -->
	<link rel="stylesheet" type="text/css" href="uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="profile_style.css">

	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="uni/Core.js"></script>
	<script type="text/javascript" src="uni/UniLib.js"></script>
	
	<!-- +++ Outside Scripts +++ -->
	<script src="https://www.paypalobjects.com/api/checkout.js"></script>

    </head>
	
    <body>
    
    <?php if(login_check($mysqli) == true): ?>	    
    	    
        <!-- +++ Universal Header and Nav +++ -->
        <?php HeaderAndNavEcho("Profile",""); ?>
        <?php echo'<script> var SubCategory=""; var videoteka_uid="'.$_SESSION["user_id"].'"; var videoteka_username="'.$_SESSION["username"].'"; var videoteka_abonimi_pagesa=0;</script>' ?>
        <!-- +++ Facebook Snippet +++ -->	
        <div id="fb-root"></div><script type="text/javascript" src="uni/FacebookSnippet.js"></script>
	
        <div id="introduction">
            <div id="intro_wrapper">
            <div id="profile_info">
	        <h1>Profili i <?php echo $_SESSION["username"]?><a href="logout.php" id="logout_button">Log out</a></h1>
	        <ul>
	        <?php 
	        $query="SELECT Paypal_Email,Email FROM `members` WHERE `ID`='$_SESSION[user_id]' AND `Username`='$_SESSION[username]'";
	        $row=mysqli_fetch_assoc(mysqli_query($mysqli,$query));
	        $email=$row["Email"];
	        $paypal_email=$row["Paypal_Email"];
	        
	        $query="SELECT * FROM `payments` WHERE `user_id`='$_SESSION[user_id]' AND `username`='$_SESSION[username]' AND `paypal_email`='$paypal_email' ORDER BY `Data_e_Skadences` DESC LIMIT 1";	
	        $result=mysqli_query($mysqli,$query);
	        if(mysqli_num_rows($result)>0)
	        {
		        $row=mysqli_fetch_assoc($result);
		        
		        $data_e_pageses=$row["Data_e_Pageses"];
		        $shuma_e_paguar=$row["Shuma_e_Paguar"];
		        $kredite_te_blera=$row["Kredite_te_Blera"];
		        $kredite_te_mbetura=$row["Kredite_te_Mbetura"];
		        $data_e_skadences=$row["Data_e_Skadences"];
		        $statusi_i_aprovimit=$row["Statusi_i_Aprovimit"];
	        }        
	        echo '<li><span>E-maili i llogarise: </span>'.$email.'</li>';
	        echo '<li><span>E-maili i Paypalit: </span>'.$paypal_email.'</li>';
	        echo '<li><span>Krediti te Mbetura: </span>'; if(isset($kredite_te_mbetura)) echo $kredite_te_mbetura; else echo ' 0'; echo '</li>';	        
	        ?>
	        </ul>
	   </div>     
	        <div id="kreditet_abonimet">	        
	            <h1>Kreditet dhe Abonimi</h1>
	            
		    <?php 
		    	if(!isset($data_e_pageses)) echo "<p>Ti nuk ke asnje abonim aktiv. Bli nje nga paketat me poshte.</p>";
		    	else 
		    	{
		    	    echo "<ul>";
		    	    echo "<li><span>Data e Abonimit:</span>$data_e_pageses</li>";
		    	    echo "<li><span>Data e Skadences:</span>$data_e_skadences</li>";
		    	    echo "<li><span>Shuma e Paguar:</span>$shuma_e_paguar</li>";
		    	    echo "<li><span>Kreditet e Blera:</span>$kredite_te_blera</li>";
		    	    echo "<li><span>Kreditet e Mbetura:</span>$kredite_te_mbetura</li>";		    	   
		    	    echo "<li><span>Statusi i Aprovimit:</span>$statusi_i_aprovimit</li>";
		    	    echo "</ul>";
		    	}
		    ?>	
		</div>
	    </div>
	    </div>
	    <div id="content">
	    	<div id="text_divs_wrapper">
	    <!--Divizionet me tekst prezantues-->
	    
	
     		<?php if(abonimi_ne_skadim($_SESSION["user_id"],$_SESSION["username"]) == true): ?> 
	 	     <div id="bli_kredite">
	 	     
	 	     <h2>Bli Kredite</h2>
		 	     <form action="" method="GET" id="formulari_abonimit">
				 <input type=radio value="12muaj" name="abonimi" id="abonimi_12_muaj">12 Muaj (7200 Kredite per $10.00)<br>
			     </form>
		 	     
		 	     
			    <div id="paypal-button-container"></div>
	
			    <script>
			        paypal.Button.render({
			
			            env: 'production', // sandbox | production
			
			            // PayPal Client IDs - replace with your own
			            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
			            client: {
			                sandbox:    'ARlcdDJsL5JSTdPZ1KfoaZ_Ey5GMDh_f0QJf0_eanXq7pnRQqRfpxLF_m6VigowDkjJXSvv_RIjH0nAA',
			                production: 'AdQTBkyl2bje2hhDDFZi6f_GIJs8Y8aPyZEcdYWDOY53qHliTKGlnMl06K6DGA_0YkBeEnhnoZKEnVwh',
			            },
			
			            // Show the buyer a 'Pay Now' button in the checkout flow
			            commit: true,
			
			            // payment() is called when the button is clicked
			            payment: function(data, actions) {
					
    					if(document.getElementById("abonimi_12_muaj").checked == true)
    			                {
    			                			                // Make a call to the REST api to create the payment
    				                return actions.payment.create({
    				                    payment: {
    				                        transactions: [
    				                            {
    				                                amount: { total: '10.00', currency: 'USD' }
    				                            }
    				                        ]
    				                    }
    				                });
    			                }
    			                
    			            },
			
			            // onAuthorize() is called when the buyer approves the payment
			            onAuthorize: function(data, actions) {
			
			                // Make a call to the REST api to execute the payment
			                return actions.payment.execute().then(function() {
                        if(document.getElementById("abonimi_12_muaj").checked == true) videoteka_abonimi_pagesa=10.00;

			                    var request=new XMLHttpRequest();
					    request.open("GET", "/premium/members/payment_validator.php?uid="+videoteka_uid+"&usr="+videoteka_username+"&pagesa="+videoteka_abonimi_pagesa, false);
					    request.send();
						
								window.alert('Pagesa u krye me sukses! Llogaria juaj do te kreditohet brenda 24 oreve. Faleminderit!');
		                    		
	                    	    window.location.reload();
			                });
			            }
			
			        }, '#paypal-button-container');
			
			    </script>
		</div>
    		<?php endif; ?>	
	    
	    <div id="info">  
	    <h2>Duke bere nje abonim, ti pranon se ke lexuar dhe je dakort me gjithcka eshte shkruar me poshte.</h2>  
	    	<ul>
	    		<li><h2>A mund ta anuloj nje abonim?</h2><p>Jo, abonimet nuk mund te anulohen. Nese je ne medyshje per sherbimin, te sugjerojme te besh nje abonim mujor per ta provuar.</p></li>
	    		<li><h2>Cfare jane kreditet?</h2><p>Kreditet jane te njevlefshme me numrin maksimal te videove qe mund te shohe nje perdorues.</p></li>
	    		<li><h2>Perse jane te nevojshme kreditet?</h2><p>Kreditet jane te nevojshme per te ulur mundesine qe nje llogari te perdoret nga nje numer i pakufizuar perdoruesish.</p></li>
	    		<li><h2>Kur ulen kreditet?</h2><p>Kreditet ulen sapo perdoruesi hap nje video ne stream per ta pare. Nese e njejta video hapet serish gjate kohes qe perdoruesi eshte ende i loguar, ajo nuk do te quhet serish. Pra perdoruesit do ti ulet vetem nje kredit per sa kohe qe ai hap te njejten video nderkohe qe eshte ende i loguar.</p></li>
	    		<li><h2>A humbas kredite nese hap disa video te ngarkohen?</h2><p>Po, kreditet ulen sapo perdoruesi ta hape videon per stream, prandaj te rekomandojme t'i shohesh videot njera pas tjetres dhe jo te hapesh disa te ngarkohen, pasi mund te humbasesh kredite per videot qe ke hapur por qe nuk do t'i shohesh me vone. Shpejtesia e ngarkimit eshte e mjaftueshme qe videoja te luhet pa ngecur.</p></li>
	    		<li><h2>A mund te ble disa paketa njekohesisht?</h2><p>Jo. Kreditet jepen per pakete dhe skadojne me mbarimin e paketes. Ato nuk mbivendosen apo kalohen ne paketat e ardhsme. Ne te rekomandojme te blesh pakete te re vetem kur paketa qe ke ne perdorim te jete prane dates se skadimit, ose kur te kesh mbaruar kreditet. Ne kete rast faqja do te ta ofroje vete mundesine per te blere nje pakete te re.</p></li>
	    	</ul>
	    </div>
	    </div>
	    
	    </div>


    <?php else: ?>
    <script>alert("Vetem perdoriesit qe kane abonim kane te drejte ta aksesojne sherbimin premium kete faqe. Nese ke nje llogari premium, te lutemi te kycesh.");
    window.location.href="/premium/info.php";
    </script>
    
    
     <?php endif; ?>

    </body>	
</html>