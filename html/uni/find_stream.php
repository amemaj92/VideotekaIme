<?php
/*----PHP Scripts And Variables----*/
//----Scripts   
include_once("db_connect.php");
//Declaring Varibales
$OS_Platform=GetOS();
$IsMobile=IsMobile();
session_start();

function getShortLink($Rotacioni){
	$shortlink="";
	global $IsMobile;

    $adfly_short_link= "http://vaugette.com/17143607/stream-shortlink";
    $shorte_short_link=	"http://ceesty.com/wMujE3";
    $miniurl_short_link= "https://miniurl.pw/5KZUfm";    

	if($Rotacioni==1)  $shortlink=$adfly_short_link;
	else if($Rotacioni==2) $shortlink=$shorte_short_link;
	else $shortlink=$adfly_short_link;

	return $shortlink;
}

//Checks if user has come from videotekaime.net , from another site, or if it has no referer.
if(isset($_SERVER["HTTP_REFERER"])) $referer=$_SERVER["HTTP_REFERER"];
else $referer="http://videotekaime.net";

//Keshtu eleminohen kerkesat qe mund te vijne nga faqe te tjera me referer te percaktuar, te ndryshem nga videotekaime.net
if(strpos($referer, "videotekaime.net") or strpos($referer, "videotekaime.com") or strpos($referer, "178.17.171.72") ) 
{
	if(isset($_GET["SoF"]))
	{
	    if(isset($_GET["Kategoria"]))
	    {
	        if(isset($_GET["Indeksi"]))
	        {
	             $SoF=$_GET["SoF"];
	             $Kategoria=$_GET["Kategoria"];
	             $Indeksi=$_GET["Indeksi"];
	             $Episodi="0";
	             $Pjesa="0";
	             $Token=uniqid("", true);
	             $Timestamp=time();
	             //Degezimi: Nese eshte film vazhdo.     
	             //Nese eshte serial kontrollo nese jane dhene dhe variablat e tjere, pastaj vazhdo.          
	             if($SoF=="S")
	             {
	             	if(isset($_GET["Episodi"])) 
	             	{
	             		$Episodi=$_GET["Episodi"];
	             		$query="SELECT * FROM `$Indeksi`";
	             		$row=mysqli_fetch_assoc(mysqli_query($VID_SERIES, $query));
	             		//Kontrollo per pjesen vetem nese ajo duhet (pra nese ekziston) 
	             		if(isset($row["Pjesa"])) 
	             		{
	             		    if(isset($_GET["Pjesa"])) 
	             		    {
	             		    	$Pjesa=$_GET["Pjesa"];
	             		    }
	             		    else exit("Gabim ne te dhena #05."); 
	             		}
	                 }
	             	 else exit("Gabim ne te dhena #04.");  
	              }
	              
	              //Vazhdo me Proceduren (#Gjenero Tokenin dhe timestampen dhe futi te gjitha te dhenat ne databaze.        
	              $query="INSERT INTO `Tokens`(`ID`, `Token`, `Timestamp`, `SoF`, `Kategoria`, `Indeksi`, `Episodi`, `Pjesa`) VALUES (NULL, '$Token', '$Timestamp', '$SoF', '$Kategoria', '$Indeksi', '$Episodi', '$Pjesa')";
	    	      mysqli_query($VID_STATS, $query);
	    	      /*----------------Variabli i Rotacionit ne SESSION------------------------*/
	    	      
	    	      //Beji set Rotacionit per here te pare. 
	    	      if(!isset($_SESSION["Rotacioni"])) $_SESSION["Rotacioni"]=0;
	    	      //Bej rotacion ne varesi te seksionit te userit, i cili do te ndryshoje vetem ne findstream.
    		      if(isset($_SESSION["Rotacioni"])) 
    		      {	
    		      	  $Rotacioni=$_SESSION["Rotacioni"]+1;
    			      if($Rotacioni>2) $Rotacioni=1;
    		      }
    		      else $Rotacioni=rand(1,2);

    		      //Perditesimi i variablit te rotacionit
    		      $_SESSION["Rotacioni"]=$Rotacioni;
    	    	  
    	    	  
    	    	  /*-----------------Variabli i Tokenit ne SESSION---------------------------*/
    	    	  //Beji set Rotacionit per here te pare. 
	    	      $_SESSION["videoteka_Token"]=$Token;

    	     	  $shortlink=getShortLink($Rotacioni);
    	      	  header("Location:  $shortlink"); 
    	      	  exit();
	        }
	        else  exit("Gabim ne te dhena #03.");               
	    }
	    else exit("Gabim ne te dhena #02.");	     
	}     	 
	else exit("Gabim ne te dhena #01.");
}
else exit("Gabim ne ardhje. Shikoni tutorialin ne faqen kryesore per te ndjekur proceduren e sakte.");

?>
