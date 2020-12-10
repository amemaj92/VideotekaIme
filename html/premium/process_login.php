<?php
include 'db_connect_premium.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
    $login_result=login($email, $password, $mysqli);

    if($login_result == -3){
        // Login failed 
        header('Location: info.php?login_error=-3');
    }
    else if($login_result == -2){
        // Login failed 
        header('Location: info.php?login_error=-2');
    }
    else if($login_result == -1){
        // Login failed 
        header('Location: info.php?login_error=-1');
    }
    else if($login_result == 0){
        // Login failed 
        header('Location: info.php?login_error=0');
    }
    else if ($login_result == 1) {
        // Login success but check if account was confirmed or not
        header('Location: members/profile.php');
    }
    else {
    // The correct POST variables were not sent to this page. 
    echo 'Kerkesa eshte e pavlefshme.';
    }
}
?>