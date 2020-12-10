<!DOCTYPE HTML>

<?php 
    /*----PHP Scripts And Variables----*/
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    //----Scripts   
    include_once("db_connect_premium.php"); 
    include_once("../uni/db_connect.php"); 
    require_once('/var/www/protected_scripts/PHPMailer/PHPMailerAutoload.php');
    //Declaring Varibales
    $user_agent=$_SERVER['HTTP_USER_AGENT'];
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
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
	<link rel="stylesheet" type="text/css" href="info_style.css">

	<!-- +++ Own Scripts +++ -->
	<script type="text/javascript" src="/uni/Core.js"></script>
	<script type="text/javascript" src="/uni/UniLib.js"></script>
	
	<!--	<script type="text/javascript" src="info.js"></script>    -->
	
	<!--Login Scipts-->
	<script type="text/JavaScript" src="sha512.js"></script> 
	<script type="text/JavaScript" src="forms.js"></script> 
	
	
	<!-- +++ Outside Scripts +++ -->

    </head>
	
    <body>	    
        <!-- +++ Universal Header and Nav +++ -->
        <?php HeaderAndNavEcho("Premium",""); ?>
        <script> var SubCategory="";</script>
        
        <!-- +++ Facebook Snippet +++ -->	
        <!--<div id="fb-root"></div><script type="text/javascript" src="uni/FacebookSnippet.js"></script>-->
	
        <div id="forms">
            <div id="intro_wrapper">
            <div id="login">
	        <h1>Je i regjistruar? Logohu ketu.</h1>
	        <div>	        
			
			<?php 
			if(isset($_GET['login_error'])) { 
				
			if($_GET['login_error']==-1) echo '<p class="error_alert" style="display:block;">Ti je regjistruar, por nuk e ke konfirmuar ende emailin. Kontrollo emailin tend per ta aktivizuar llogarine dhe pastaj mund te kycesh.</p>'; 
			else if($_GET['login_error']==-2) echo '<p class="error_alert" style="display:block;">Ti je regjistruar, por llogaria jote eshte bllokuar pas shume provash te gabuara me fjalekalimin. Kontrollo emailin tend per ta riaktivizuar llogarine dhe pastaj mund te kycesh.</p>';
			else echo '<p class="error_alert" style="display:block;">Gabim ne te dhena! Fjalekalimi ose emaili nuk eshte i sakte.</p>'; 
			
			}
			
			if(isset($_GET['conf']))
			{
				echo '<p class="error_alert" style="display:block;">Veprimi u konfirmua me sukses per llogarine me email: "'.$_GET['conf'].'". Tani mund te logohesh me poshte.</p>';
			}
			
		?> 
		<form action="process_login.php" method="post" name="login_form"> 			
			<ul>
			<li><label for="email">Email:</label><input type="text" name="email"></li>
			<li><label for="password">Password:</label><input type="password" name="password" id="password"></li>
			</ul>
			<input type="button" value="Logohu" onclick="formhash(this.form, this.form.password);"> 
			
		</form>
		
		<div id="pass_reset"><p>Nese ke harruar fjalekalimin kliko linkun e meposhtem per te kerkuar risetimin e tij.<br><a href="pass_reset.php">Kliko ketu per te risetuar fjalekalimin.</a></p></div>	
			
	  	</div>	
	  	
	    </div>

<?php //Kodi per signup Form 
/*
	    <div id="signup">
	        <h1>Deshiron te regjistrohesh? Regjistrohu ketu. </h1>
	         <div>	     
	         
 		<?php
		
		$error_msg = "";
		
		if (isset($_POST['username'], $_POST['email'], $_POST['paypal_email'], $_POST['p'])) {
		    // Sanitize and validate the data passed in
		    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		        // Not a valid email
		        $error_msg .= 'Adresa e emailit nuk eshte e vlefshme.';
		    }
		    
		    $paypal_email = filter_input(INPUT_POST, 'paypal_email', FILTER_SANITIZE_EMAIL);
		    $paypal_email = filter_var($paypal_email, FILTER_VALIDATE_EMAIL);
		    if (!filter_var($paypal_email, FILTER_VALIDATE_EMAIL)) {
		        // Not a valid email
		        $error_msg .= 'Adresa e emailit te Paypalit nuk eshte e vlefshme.';
		    }
		    
		    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
		    if (strlen($password) != 128) {
		        // The hashed pwd should be 128 characters long.
		        // If it's not, something really odd has happened
		        $error_msg .= '<br>Passwordi nuk eshte i vlefshem.';
		    }
		
		    // Username validity and password validity have been checked client side.
		    // This should should be adequate as nobody gains any advantage from
		    // breaking these rules.
		    //
		    
		    $prep_stmt = "SELECT Status FROM `members` WHERE Email = ? LIMIT 1";
		    $stmt = $mysqli->prepare($prep_stmt);
		    
		    if ($stmt) {
		        $stmt->bind_param('s', $email);
		        $stmt->execute();
		        $stmt->store_result();
		        
		        if ($stmt->num_rows > 0) {
		            // A user with this email address already exists
		            $error_msg .= '<br>Ekziston tashme nje perdorues i regjistruar me kete email. Nese ke harruar fjalekalimin resetoje ate. Nese nuk e ke aktivizuar ende llogarine tende, kontrollo email-in per ta aktivizuar.';
		        }
		    }	    
		    		
		    if (empty($error_msg)) {
		        // Create a random salt
		        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
		
		        // Create salted password 
		        $password = hash('sha512', $password.$random_salt);
		        $status="Pending_Approval";
		        $confirm_hash=md5($email.date("Y-m-d h:i:s"));
		        
		
		        // Insert the new user into the database 
		        if ($insert_stmt = $mysqli->prepare("INSERT INTO `members` (username, email, paypal_email, password, salt, status, confirm_hash) VALUES (?, ?, ?, ?, ?, ?, ?)")) 
		        {
		            $insert_stmt->bind_param('sssssss', 
								$username, 
								$email, 
								$paypal_email,
								$password, 
								$random_salt,
								$status, 
								$confirm_hash);
		
		            // Execute the prepared query.
		            $insert_stmt->execute();		            			
		    	}
		    	
		    	//Sending the Activation Email
		        
			$confirm_link="http://videotekaime.net/premium/signup_confirmation.php?key=".$confirm_hash;
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
			
			$mail->Subject = 'Regjistrimi ne Videotekaime.net Premium';
			
			$mail->Body = '<p>Pershendetje! Juve ju ka ardhur ky email sepse ne faqen www.videotekaime.net eshte regjistruar nje user me kete email per sherbimin premium. Nese e keni bere ju kete regjistrim, konfirmojeni duke klikuar linkun e meposhtem. Nese jo, injorojeni kete email. Ju faleminderit!</p>
			<p><a href='.$confirm_link.'>Klikoni ketu per ta konfirmuar regjistrimin tuaj.</a></p>
			<p>Nese nuk e klikoni dot linkun, kopjojeni kete ne shfletuesin tuaj dhe shtypni enter: '.$confirm_link.'</p>!';
			
			$mail->AltBody = 'Pershendetje! Juve ju ka ardhur ky email sepse ne faqen www.videotekaime.net eshte regjistruar nje user me kete email per sherbimin premium. Nese e keni bere ju kete regjistrim, konfirmojeni duke hapur kete link: '.$confirm_link.'. Nese jo, injorojeni kete email. Ju faleminderit!';
			
			if(!$mail->send()) {$error_msg.='Mesazhi nuk u dergua dot.'.' Mailer Error: ' . $mail->ErrorInfo;} 
			else {$succ_msg.="Regjistrimi u krye me sukses! Ne te derguam nje email konfirmimi. Te lutemi te kontrollosh emailin per ta konfirmuar regjistrimin ne faqen tone. Faleminderit!";}		    	
		    }
		}
				
		?>
	        
	        <?php if(empty($error_msg) AND !empty($succ_msg)): ?>
	        	<p class="alert_succes"><?php echo "$succ_msg"; ?></p>
	        <?php else: ?> 
	         	<p id='signup_error_alert' class="error_alert" style="display:block;"><?php if(!empty($error_msg)) {echo "Nga perpunimi i te dhenave qe futet dolen keto gabime: <br>$error_msg <br> Te lutemi ta provosh perseri.";}?></p>
			
		        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">		        
		         <ul>
		            <li>
		            	<p class="error_alert">Pseudonimi mund te permbaje vetem numra, shkronja te medha ose te vogla dhe nenvizime.</p>
		            	<label for="username">Pseudonimi: </label><input type='text' name='username' id='username'>
		            </li>
		            <li>
				<p class='error_alert'></p>
		            	<label for="email">E-mail: </label> <input type="text" name="email" id="email">
		            </li>
		            <li>
				<p class='error_alert'></p>
		            	<label for="paypal_email">E-maili i Paypalit: </label> <input type="text" name="paypal_email" id="paypal_email">
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

		        <input type="button" value="Regjistrohu" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.paypal_email, this.form.password, this.form.confirmpwd);"> 
		        
		        </form>
		<?php endif; ?>
		
	  	</div>
	    </div>
	    
	    */?>
	    </div>
        </div>  
       
	<div id="content">
	    <!--Divizionet me tekst prezantues-->
	    <div id="text_divs_wrapper">
		<h2>Cfare ofron sherbimi premium?</h2>
		<p>Sherbimi premium eshte nje sherbim i ri qe faqja jone ka filluar te ofroje. Per vetem 10 USD ne vit, ti mund te shijosh gjithe filmat dhe serialet qe ofron faqja jone pa reklama, pa mungesa dhe me shpejtesi me te larte. Per momentin ky eshte i vetmi sherbim qe ofrojme, por me vone ka mundesi te shtojme sherbime te reja, si p.sh. mundesine per te votuar per seriale apo filma qe deshironi te perkthehen prej nesh, apo te tjera sherbime qe mund te kerkohen prej perdoruesve, por kjo ne varesi interesit qe do te kete per kete sherbim.</p>
		
		<div id="video_div">
		    <h2>Video Demonstrim</h1>
		    <div id="video_container">
		        <video controls oncontextmenu="return false;">
			    <source src="Tutorial_Premium.mp4" type="video/mp4">
			</video>
		    </div>
                </div>
		
		<p><br>Se fundmi te lutemi ta shikosh kete edhe si nje vleresim per punen dhe seriozitetin tone te deritanishem, dhe si nje ndihme per ne per te vazhduar ta mbajme aktive faqen tone dhe ta zgjerojme sa me shume dhe sa me shpejt te mundemi me filma dhe seriale te reja! Te faleminderit per interesimin! Si gjithmone, te urojme shikim te kendshem!</p>
	    </div>		
	    </div>
	    
	</div>
    </div>
    </div>
    </body>	
</html>
