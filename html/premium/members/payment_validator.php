<?php 

include_once("../db_connect_premium.php");
require_once('/var/www/protected_scripts/PHPMailer/PHPMailerAutoload.php');

if(isset($_GET["uid"]) AND isset($_GET["usr"]) AND isset($_GET["pagesa"]) AND ($_GET["pagesa"]==5 OR $_GET["pagesa"]==10 OR $_GET["pagesa"]==25 OR $_GET["pagesa"]==50))
{
	$user_id=filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_STRING);
	$username=filter_input(INPUT_GET, 'usr', FILTER_SANITIZE_STRING);
	$pagesa=filter_input(INPUT_GET, 'pagesa', FILTER_SANITIZE_NUMBER_INT);
	$abonimi=0;
	if($pagesa==5) {$abonimi=1; $kreditet=600;}
	else if ($pagesa==10) {$abonimi=12; $kreditet=7200;}    //Special Offer
	else if ($pagesa==25) {$abonimi=6; $kreditet=3600;}
	else if ($pagesa==50) {$abonimi=12; $kreditet=7200;}
	
	$row=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `Paypal_Email` FROM `members` WHERE `ID`='$user_id' AND `Username`='$username'")); 
	$paypal_email=$row["Paypal_Email"];
	
	date_default_timezone_set("Europe/Tirane");
	$data_abonimit=date("Y-m-d H:i:s"); 
	$data_e_skadimit=date_format(date_add(date_create($data_abonimit),date_interval_create_from_date_string("$abonimi months")),"Y-m-d H:i:s");
	$statusi="Ne Approvim";
	
	$query="INSERT INTO `payments`(`ID`, `user_id`, `paypal_email`, `username`, `Data_e_Pageses`, `Shuma_e_Paguar`, `Kredite_te_Blera`, `Kredite_te_Mbetura`, `Data_e_Skadences`, `Statusi_i_Aprovimit`) VALUES (NULL, '$user_id','$paypal_email','$username','$data_abonimit','$pagesa','$kreditet','$kreditet','$data_e_skadimit','$statusi')";
		
	mysqli_query($mysqli, $query);	
	
	echo $query;
	
	//Send Email
	$mail = new PHPMailer;
	
	$mail->SMTPDebug = 3;                               // Enable verbose debug output
	
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.privateemail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'admin@videotekaime.com';                 // SMTP username
	$mail->Password = '*jn8gO5f9auc8';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to
	
	$mail->setFrom("admin@videotekaime.com", "Abonim");
	$mail->addAddress("admin@videotekaime.com", 'Shitesi');     // Add a recipient
	
	$mail->isHTML(true);                                  // Set email format to HTML
	
	$mail->Subject = 'Regjistrimi ne Videotekaime.net Premium';
	
	$mail->Body    = '<p>Abonim prej:&#9;'.$pagesa.' USD<br>Nga perdoruesi:&#9;'.$username.'<br>Me paypal email:&#9; '.$paypal_email.'<br>Me date:&#9;'.$data_abonimit.'.</p>!';
	
	$mail->send();

}

?>
