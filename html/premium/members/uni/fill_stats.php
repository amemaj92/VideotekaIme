<?php
if(isset($_GET["SoF"]) AND isset($_GET["Kategoria"]) AND isset($_GET["Indeksi"]))
{
    /*----PHP Scripts And Variables----*/
    //----Scripts   
    include_once("db_connect.php");
    //Declaring Varibales
    
    
    //Percaktimi i Dates dhe i Tabeles
    date_default_timezone_set("Europe/Tirane");
    $data=date("Y-m-d"); 
    $Indeksi=$_GET["Indeksi"];
    $Kategoria=$_GET["Kategoria"];
    
    if($_GET["SoF"]=="S") {$Table="Series_Premium";}
    else if($_GET["SoF"]=="F") {$Table="Movies_Premium";}	
    else exit("Gabim ne te dhena. As Film as Serial i Perzgjedhur.");
    	
    	
	//Getting number of rows and columns if something will be added later.
	$temp_q=mysqli_query($VID_STATS, "SELECT * FROM `$Table`");
	$cols=mysqli_num_fields($temp_q)-3;	//ID, Indeksi, Kategoria
	$rows=mysqli_num_rows($temp_q);
	$SelectQuery="SELECT * FROM `$Table` WHERE `Indeksi`='$Indeksi'";
	$result=mysqli_query($VID_STATS, $SelectQuery); 
	$i=0;
	//Securing the Existence of Series Row
	if(mysqli_num_rows($result)==0) 
	{//Seriali nuk ekziston ne tabelen e statistikave. Duhet shtuar si resht me vlerat 0 (defalt) per cdo kolone.
	    $AddQuery="INSERT INTO `$Table` VALUES (NULL, '$Indeksi', '$Kategoria'"; 
	    for($i=0; $i<$cols; $i++) {$AddQuery=$AddQuery.", '0'";}
	    $AddQuery=$AddQuery." )";
	    
	    echo "<p>$AddQuery</p>";
	    
	    mysqli_query($VID_STATS, $AddQuery); 		 			
	    $result=mysqli_query($VID_STATS, $SelectQuery); //Jemi ne Querine e Selektimit pas perditesimit
	}
	
	//----------------Seriali Ekziston. Tani kontrollo nese ekziston data apo eshte hera e pare qe behet perditesimi sot. (Ne kete rast shto kolone me te gjitha vlerat default)
	$row_2=mysqli_fetch_assoc($result); 
	if(!isset($row_2[$data])) //----------------Data nuk ekziston. Shto colonen e Dates
	{
		$AddColQuery="ALTER TABLE `$Table` ADD `$data` TEXT NOT NULL"; 
		mysqli_query($VID_STATS, $AddColQuery); 
		
		echo "<p>$AddColQuery</p>";
		 
		$UpdColQuery="UPDATE `$Table` SET `$data`='0' WHERE 1";
		mysqli_query($VID_STATS, $UpdColQuery); 
		
		echo "<p>$UpdColQuery</p>";
		
		$result=mysqli_query($VID_STATS, $SelectQuery); //Jami ne Querine e Selektimit pas perditesimit
		$row_2=mysqli_fetch_assoc($result); 
	}
		
	$updated_views=$row_2[$data]+1;
	//Me ne fund perditeso vleren e statistikave ne databaze
	$UpdQuery="UPDATE `$Table` SET `$data`='$updated_views' WHERE `Indeksi`='$Indeksi'"; 
	mysqli_query($VID_STATS, $UpdQuery); 
	
	echo "<p>$UpdQuery</p>";
}
    
else exit("Te dhenat tuaja jane te pasakta.");
?>