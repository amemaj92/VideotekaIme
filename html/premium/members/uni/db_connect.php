<?php 

include('/var/www/protected_scripts/Uni_Globals.php');   
include('/var/www/protected_scripts/Uni_Functions_premium.php'); 

$VID_SERIES = new mysqli(HOST, USER1, PASSWORD1, DATABASE1);
$VID_MOVIES = new mysqli(HOST, USER1, PASSWORD1, DATABASE2);
$VID_STATS = new mysqli(HOST, USER1, PASSWORD1, DATABASE3);

?>
