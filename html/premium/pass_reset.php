<!DOCTYPE HTML>

<?php 
    /*----PHP Scripts And Variables----*/
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    //----Scripts   
    include_once("db_connect_premium.php"); 
    include_once("../uni/db_connect.php");
    require_once('/var/www/protected_scripts/PHPMailer/PHPMailerAutoload.php');
?>

<html lang="sq">
    <head>
        <meta charset="utf-8">
        <meta name=”robots” content=”noindex, follow”>
    	<!-- +++ Title and meta tags section +++ --> 
        <title>Sherbimi premium - Videotekaime.net</title>	
	<meta name="description" content="Kundrejt nje pagese modeste mujore eja shiko gjithçka te ofron videotekaime.net, pa reklama, pa mungesa dhe me shpejtesi te larte!  Eja hidh nje sy dhe shiko te gjitha avantazhet qe te ofrojme!">
	<meta name="keywords" content="videotekaime premium, videoteka ime premium">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Stylesheets for all screens +++ -->
	<link rel="stylesheet" type="text/css" href="/uni/uni_style.css">
	<link rel="stylesheet" type="text/css" href="pass_reset_style.css">

	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="/uni/Core.js"></script>
	<script type="text/javascript" src="/uni/UniLib.js"></script>
	
	<!--	    -->
	
	<!--Login Scipts-->
	<script type="text/JavaScript" src="sha512.js"></script> 
	<script type="text/javascript" src="pass_reset.js"></script>
	
    </head>
	
    <body>	    
        <!-- +++ Universal Header and Nav +++ -->
        <?php HeaderAndNavEcho("",""); ?>
        <script> var SubCategory="";</script>
        
        <!-- +++ Facebook Snippet +++ -->	
        <!--<div id="fb-root"></div><script type="text/javascript" src="uni/FacebookSnippet.js"></script>-->
	
        <div id="forms">
            <div id="intro_wrapper">
            <div id="forms">
	        <h1>Ke harruar fjalekalimin? Kerko ketu risetimin e tij.</h1>       
			
			<?php 
			$error_msg="";
			if(!isset($_POST['email']) AND !isset($_GET['key'])) 
			{
			    echo '
			    <div id="ask_pass_reset">
			    <form action="'.htmlentities($_SERVER['PHP_SELF']).'" method="post" name="ask_reset"> 			
				<ul><li><label for="email">Email:</label><input type="text" name="email"></li></ul>
				<input type="submit" value="Kerko Risetim"> 
			    </form>		
		  	    </div>';
		  	}		  	
				
			else if(isset($_POST['email']))
			{ 
			    
			    $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
			    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
		    	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		    	    {
		        	// Not a valid email
		        	$error_msg .= 'Adresa e emailit nuk eshte e vlefshme.<br>';
		      	    }
		      	    else 
		      	    {
		      	    	
		      	        $prep_stmt = "SELECT Email,status FROM members WHERE Email = ? LIMIT 1";
			        $stmt = $mysqli->prepare($prep_stmt);	
			           
			        if ($stmt) 
			        {
			     	    $stmt->bind_param('s', $email);
			            $stmt->execute();
			            $stmt->store_result();	
			            if ($stmt->num_rows == 1) 
			            {
			            	//If user has already asked for reset print out an error message. 
			            	$prep_stmt = "SELECT Email,status FROM members WHERE email = ? AND status='Asked_for_Reset' LIMIT 1";
				        $stmt = $mysqli->prepare($prep_stmt);			    
				        if ($stmt) 
				        {
				     	    $stmt->bind_param('s', $email);
				            $stmt->execute();
				            $stmt->store_result();
				            
				            if ($stmt->num_rows == 1) 
				            {
				                echo "<p>Ti ke kerkuar tashme nje risetim te fjalekalimit. Kontrollo emailin per te mesuar si te veprosh. </p>";
				            }
				            else 
				            {	
				                          		
				            	$confirm_hash=md5(date("Y-m-d h:i:s").$email);
				                // A user with this email address exists. Chage status and confirm hash, and send email with link key link. 
				                $prep_stmt = "UPDATE members SET status='Asked_for_Reset', confirm_hash='$confirm_hash' WHERE email = ? LIMIT 1";
					    	$stmt = $mysqli->prepare($prep_stmt);
					     
						if ($stmt) 
						{
						    $stmt->bind_param('s', $email);
						    $stmt->execute();
						    $confirm_link="http://videotekaime.net/premium/pass_reset.php?key=".$confirm_hash;						
						    $mail = new PHPMailer;						
						    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
						
						    $mail->isSMTP();                                      // Set mailer to use SMTP
						    $mail->Host = 'mail.privateemail.com';  // Specify main and backup SMTP servers
						    $mail->SMTPAuth = true;                               // Enable SMTP authentication
						    $mail->Username = 'admin@videotekaime.com';                 // SMTP username
						    $mail->Password = '*jn8gO5f9auc8';                           // SMTP password
						    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
						    $mail->Port = 587;                                    // TCP port to connect to
						
						    $mail->setFrom('admin@videotekaime.com', 'Videotekaime.net');
						    $mail->addAddress("$email", 'Abonenti');     // Add a recipient
						
						    $mail->isHTML(true);                                  // Set email format to HTML
						
						    $mail->Subject = 'Kerkese per Risetim te fjalekalimit ne Videotekaime.net Premium';
						
						    $mail->Body = '<p>Pershendetje! Juve ju ka ardhur ky email sepse ne faqen www.videotekaime.net, eshte kerkuar risetimi i fjalekalimit per llogarine qe mbart emailin tuaj. Nese e keni kerkuar ju kete, konfirmojeni duke klikuar linkun e meposhtem. Nese jo mund ta injoroni kere email, por ne ju rekomandojme ta ndryshoni fjalekalimin sepse dikush mund te jete duke u perpjekur te aksesoje llogarine tuaj pa leje. Ju faleminderit!</p>
						<p><a href='.$confirm_link.'>Klikoni ketu per ta risetuar fjalekalimin.</a></p>
						<p>Nese nuk e klikoni dot linkun, kopjojeni kete ne shfletuesin tuaj dhe shtypni enter: '.$confirm_link.'</p>!';
						
						    $mail->AltBody = '>Pershendetje! Juve ju ka ardhur ky email sepse ne faqen www.videotekaime.net, eshte kerkuar risetimi i fjalekalimit per llogarine qe mbart emailin tuaj. Nese e keni kerkuar ju kete, konfirmojeni duke hapur kete link: '.$confirm_link.'. Nese jo mund ta injoroni kere email, por ne ju rekomandojme ta ndryshoni fjalekalimin sepse dikush mund te jete duke u perpjekur te aksesoje llogarine tuaj pa leje. Ju faleminderit';
						
						    if(!$mail->send()) 
						    {
						        $error_msg.='Emaili nuk u dergua dot. Mailer Error: ' . $mail->ErrorInfo;
						    } 
						
						    else 
						    {
						        echo '<p>Emaili u dergua me sukses. Ndiq hapat ne emailin e marre per te mesuar si te veprosh.</p>';
						    }
					        }
					    }
					}
					else {$error_msg.="Gabim i papercaktuar.<br>";}
				    }
				    else {$error_msg.="Nuk ekziston ndonje perdorues i regjistruar me kete email.<br>";}			                
			        }        	     
		      	    }
		      	    //Shfaq mesazhin e gabimit dhe kerko rifutjen e emailit.
		      	    if(!empty($error_msg))
		      	    {
		      	    echo '
				<div id="ask_pass_reset">
				    <form action="'.htmlentities($_SERVER['PHP_SELF']).'" method="post" name="ask_reset"> 			
				    <p class="error_alert">'.$error_msg.'</p>
				    <ul><li><label for="email">Email:</label><input type="text" name="email"></li></ul>
				    <input type="submit" value="Kerko Risetim"> 
				    </form>		
		  		</div>';
		  	    }
		      	}
		      	
			else if(isset($_GET['key'])) 
			{
				$gkey=filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
				$prep_stmt = "SELECT * FROM members WHERE confirm_hash = ? AND status='Asked_for_Reset' LIMIT 1";
				$stmt = $mysqli->prepare($prep_stmt);			    
		     	        $stmt->bind_param('s', $gkey);
		                $stmt->execute();
		                $stmt->store_result();            
		                if ($stmt->num_rows == 1) 
		                {
		            		$error_msg ="";
					if (isset($_POST['key'], $_POST['p'])) 
					{
					    $key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);
					    $password = $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
					
					    if (strlen($password) != 128) {
					        // The hashed pwd should be 128 characters long.
					        // If it's not, something really odd has happened
					        $error_msg .= '<br>Passwordi nuk eshte i vlefshem.';
					    }    
					    
					    if (empty($error_msg)) 
					    {
						// Create a random salt
						$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
						
						// Create salted password 
						$password = hash('sha512', $password.$random_salt);
						$status="Approved";
						$confirm_hash=md5(date("Y-m-d h:i:ss"));
						
						
						// Insert the new user into the database 
						if ($update_stmt = $mysqli->prepare("UPDATE `members` SET password = ? , salt = ? , status= ? , confirm_hash= ? WHERE confirm_hash='$gkey' AND status='Asked_for_Reset'")) 
						{
						
						    $update_stmt->bind_param('ssss', $password, $random_salt,$status, $confirm_hash);
						
						    // Execute the prepared query.
						    $update_stmt->execute();				
						}
						
						echo "<p>Risetimi i fjalekalimit u krye me sukses! Tani ti mund te logohesh ne llogarine tende me fjalekalimin e ri. </p>";
					    } 
					}
					else 
				        {			
					    echo '			
					    <div id="pass_reset">
				            <h1>Fut fjalekalimin e ri.</h1>				
					        <form action="'.htmlentities($_SERVER['PHP_SELF']).'?key='.$gkey.'" method="post" name="reset_password_form">		        
					         <ul>
					            <li>
					                <p class="error_alert" id="reset_error_alert">'.$error_msg.'.</p>
					            	<input type="hidden" name="key" id="key" value="'.$gkey.'">
					            </li>
					            <li>
					            	<p class="form_info">Fjalekalimi duhet te permbaje te pakten:</p>
					                <ul id="pass_requirements_info">
					                    <li>Nje shkronje te madhe(A..Z)</li>
					                    <li>Nje shkronje te vogel (a..z)</li>
					                    <li>Nje numer (0..9)</li>
					                </ul>
					                <p class="error_alert">Fjalekalimi duhet te jete te pakten 6 germa i gjate.</p>
					            	<label for="password">Fjalekalimi: </label><input type="password" name="password" id="password">
					            </li>
					            <li>
					            	 <p class="error_alert">Fjalekalimet duhet te perputhen identikisht.</p>
					                 <label for="confirmpwd">Konfirmo Fjalekalimin: </label><input type="password" name="confirmpwd" id="confirmpwd">
					            </li>
					        </ul>
			
					        <input type="button" value="Riseto" onclick="return regformhash(this.form, this.form.key, this.form.password, this.form.confirmpwd);"> 			        
					        </form>';			
		    			    echo '</div>';
	    			        }
					
				    }
				    else {echo "<p>Ti nuk ke kerkuar risetim te fjalekalimit, ose kerkesa ka skaduar.</p>";}
			}			
    			
    			else echo '<p>Kerkesa juaj eshte e pavlefshme</p>';
    			echo '
    	</div>
    </body>	
</html>';
