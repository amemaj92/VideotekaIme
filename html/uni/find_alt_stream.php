<?php
/*----PHP Scripts And Variables----*/
	//error_reporting(E_ALL);
    	//ini_set('display_errors', 1);
//----Scripts   
include_once("db_connect.php");
//Declaring Varibales
$OS_Platform=GetOS();
$IsMobile=IsMobile();
session_start();


//Checks if user has come from videotekaime.net , from another site, or if it has no referer.
if(isset($_SERVER["HTTP_REFERER"])) $referer=$_SERVER["HTTP_REFERER"];
else $referer="http://videotekaime.net";

//Keshtu eleminohen kerkesat qe mund te vijne nga faqe te tjera me referer te percaktuar, te ndryshem nga videotekaime.net
if(strpos($referer, "videotekaime.net") or strpos($referer, "videotekaime.com") or strpos($referer, "178.17.171.72") )
{
	if(isset($_SESSION["videoteka_Token"]))	  
	{
	    $Token=$_SESSION["videoteka_Token"];
	    $query="SELECT * FROM `Tokens` WHERE `Token`='$Token'";
        $row=mysqli_fetch_assoc(mysqli_query($VID_STATS, $query));
        //Film
        if($row["SoF"]=="F") {$SoF="F";}

        //Serial
        else if($row["SoF"]=="S") {$SoF="S";}

        //Gabim ne SoF
        else exit("Gabim ne te dhena #02");
	    
	     /*-----------------Variabli i Tokenit ne SESSION---------------------------*/
    	 //Beji set Rotacionit per here te pare. 
	     $_SESSION["videoteka_Token_alt"]=$Token;
	    
	     $shortlink= "https://miniurl.pw/Stream2";
	     header("Location:  $shortlink");  
	     exit();
	}
	else exit("Gabim ne te dhena #01.");  
}
else exit("Gabim ne ardhje.");

?>
