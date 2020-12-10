<?php
include ('/var/www/protected_scripts/sec_login-config.php');   // Needed because functions.php is not included
include ('/var/www/protected_scripts/functions_premium.php');

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

$mysqli_e = new mysqli(HOST, USER2, PASSWORD2, DATABASE);
