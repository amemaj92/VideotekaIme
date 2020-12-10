<?php
    include_once('/var/www/protected_scripts/sec_login-config.php');
    require_once('/var/www/protected_scripts/PHPMailer/PHPMailerAutoload.php');
    
//------------------------THE SECURE SESSION CODE---------------------
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name 
    $secure = false;
    
    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    ini_set('session.use_only_cookies', 1);

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], 
					$cookieParams["path"], 
					$cookieParams["domain"], 
					$secure, 
					$httponly);

    // Sets the session name to the one set above.
    session_name($session_name);

    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

//-------------HANDLING THE LOGIN DATA----------------------

function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
				  		FROM members 
                                  	WHERE email = ? 
						LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            
            //-3 -->User does not exist 
            //-2 -->User exists but his status is blocked
            //-1 -->User exists but has yet to confirm email
            //0 --> User exists but password is NOT correct
            //1 --> User exists and password is correct
            
          if (checkconfimation($user_id, $mysqli, $email) == true){
            	//User has registered, but has yet to confirm the account through email link.
            	return -1;
          }
            
          else if (checkbrute($user_id, $mysqli, $email) == true) {
            	
            
                // Account is locked 
                // Send an email to user saying their account is locked 
                return -2;
            }            
            else {
                // Check if the password in the database matches 
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    
                    // Login successful. 
                    return 1;
                } else {
                    // Password is not correct 
                    // We record this attempt in the database 
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(ID, user_id, time) 
                                    VALUES (NULL,'$user_id', '$now')");

                    return 0;
                }
            }
        } else {
            // No user exists. 
            return -3;
        }
    }
}

//*--------------------------CHECKING AGAINST BRUTE FORCE ATTACKS
function checkbrute($user_id, $mysqli, $email) {
    // Get timestamp of current time 
    $now = time();
    
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
    
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows == 5) {
	        $stmt = $mysqli->prepare("UPDATE `members` SET status = 'Blocked' WHERE id = ? LIMIT 1"); 
	        $stmt->bind_param('i', $user_id);
	        $stmt->execute();   // Execute the prepared query.
	        $unblock_hash=md5($user_id);
	        
	        $stmt = $mysqli->prepare("UPDATE `members` SET confirm_hash = '$unblock_hash' WHERE id = ? LIMIT 1"); 
	        $stmt->bind_param('i', $user_id);
	        $stmt->execute();   // Execute the prepared query.
	        
	        $unblock_link="http://videotekaime.net/premium/unblock_acc.php?key=".$unblock_hash;
		$mail = new PHPMailer;
		
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'mail.privateemail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'admin@videotekaime.com';                 // SMTP username
		$mail->Password = '*jn8gO5f9auc8';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		
		$mail->setFrom('admin@videotekaime.com', 'Videotekaime.com');
		$mail->addAddress("$email", 'Abonenti');     // Add a recipient
		
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = 'Llogaria juaj Premium ne Videotekaime.com eshte bllokuar';
		
		$mail->Body = '<p>Pershendetje! Juve ju ka ardhur ky email sepse ne faqen www.videotekaime.net, llogaria premium qe mban emailin tuaj eshte bllokuar, pasi ka patur shume prova te deshtuara kycjeje (pra me fjalekalim te pasakte). Nese nuk keni qene ju, ju lutemi ta aktivizoni llogarine tuaj duke klikuar linkun e meposhtem. Nese keni harruar fjalekalimin, kerkoni nje resetim te fjalekalimit ne faqen e kycjes.  Ju faleminderit!</p>
		<p><a href='.$unblock_link.'>Klikoni ketu per ta riaktivizuar llogarine tuaj tuaj.</a></p>
		<p>Nese nuk e klikoni dot linkun, kopjojeni kete ne shfletuesin tuaj dhe shtypni enter: '.$unblock_link.'</p>!';
		
		$mail->AltBody = 'Pershendetje! Juve ju ka ardhur ky email  sepse ne faqen www.videotekaime.net, llogaria premium qe mban emailin tuaj eshte bllokuar, pasi ka patur shume prova te deshtuara kycjeje (pra me fjalekalim te pasakte). Nese nuk keni qene ju, ju lutemi ta aktivizoni llogarine tuaj duke hapur kete link: '.$unblock_link.'. Ju faleminderit!';
		
		$mail->send();
		
		return true; 
    
        }
        else if ($stmt->num_rows > 5) {
             return true;
        } else {
            return false;
        }
    }
}

//*--------------------------CHECKING AGAINST BRUTE FORCE ATTACKS
function checkconfimation($user_id, $mysqli, $email) {
    
    // All login attempts are counted from the past 2 hours.  
    if ($stmt = $mysqli->prepare("SELECT id, status FROM members 
     	                         	WHERE ID = ? AND status = 'Pending_Approval'
						LIMIT 1")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            return true;	//Has not confirmed yet
        } else {
            return false;
        }
    }
}

//*--------------------CHECKING THE LOGIN

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
			$_SESSION['username'], 
			$_SESSION['login_string'])) {
	
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        
        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM members 
				      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
                
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

/*---------------------Kontrollon nese useri ka abonim dhe nese ky i fundit eshte ne skadim. Duhet per te nxjerre opsionin per t'u abonuar*/
function abonimi_ne_skadim($uid, $usr) 
{
	global $mysqli; 
	if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {	
	        $user_id = $_SESSION['user_id'];
	        $username = $_SESSION['username'];
	        	        
	        $query="SELECT * FROM `payments`";
		$result=mysqli_query($mysqli, $query); 		

		//Vazhdo me kushtet e tjera.
	        
	        $query="SELECT * FROM `payments` WHERE `user_id`='$user_id' AND `username`='$username' ORDER BY `Data_e_Skadences` DESC LIMIT 1";
		$result=mysqli_query($mysqli, $query); 
		
		if(mysqli_num_rows($result)>0)
		{
			$row=mysqli_fetch_assoc($result);
			//Nese i kane mbetur 2 % e krediteve te blera, propozo blerje te re.
			$perq_e_kr_mbetura=$row["Kredite_te_Blera"]*100/$row["Kredite_te_Mbetura"];
			if($perq_e_kr_mbetura<=2) return true; 
			
			else {
				//Nese abonimi i skadon per 3 ditet ne vijim, propozo blerje te re. 
				date_default_timezone_set("Europe/Tirane");
				$data_e_skadimit=$row["Data_e_Skadences"];
				$data_tani=date("Y-m-d H:i:s"); 			
				
				$ts1 = strtotime($data_e_skadimit);
				$ts2 = strtotime($data_tani);
	
				$days_diff = ($ts2 - $ts1)/86400;
				if($days_diff>=-3) return true;
				
				return false;
			}
		}
		
		else return true; 
        }
        else return false;
}
?>
