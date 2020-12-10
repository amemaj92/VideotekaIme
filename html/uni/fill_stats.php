<?php
if(isset($_GET["tokeni"]) AND isset($_GET["Streami"]) AND isset($_GET["DoMi"]))
{
    /*----PHP Scripts And Variables----*/
    //----Scripts   
    include_once("db_connect.php");
    //Declaring Varibales
    
    //Marrja e Informacionit nga linku
    $Token=$_GET["tokeni"];
    $Stream=$_GET["Streami"];
    $DoM=$_GET["DoMi"];
    
    //Query per te nxjerre te gjitha informacionet e duhura.
    $query="SELECT * FROM `Tokens` WHERE `Token`='$Token'";
    $row=mysqli_fetch_assoc(mysqli_query($VID_STATS, $query));
    
    //Percaktimi i Dates dhe i Tabeles
    date_default_timezone_set("Europe/Tirane");
    $data=date("Y-m-d"); 
    $Indeksi=$row["Indeksi"];
    $Kategoria=$row["Kategoria"];
    
    if($row["SoF"]=="S") {$Table="Series";}
    else if($row["SoF"]=="F") {$Table="Movies";}	
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
	    $Kategoria=$row["Kategoria"];
	    $AddQuery="INSERT INTO `$Table` VALUES (NULL, '$Indeksi', '$Kategoria'"; 
	    for($i=0; $i<$cols; $i++) {$AddQuery=$AddQuery.", 'D(0,0,0)-M(0,0,0)'";}
	    $AddQuery=$AddQuery." )";
	    
	    mysqli_query($VID_STATS, $AddQuery); 		 			
	    $result=mysqli_query($VID_STATS, $SelectQuery); //Jami ne Querine e Selektimit pas perditesimit
	}
	
	//----------------Seriali Ekziston. Tani kontrollo nese ekziston data apo eshte hera e pare qe behet perditesimi sot. (Ne kete rast shto kolone me te gjitha vlerat default)
	$row_2=mysqli_fetch_assoc($result); 
	
	if(!isset($row_2["$data"])) //----------------Data nuk ekziston. Shto colonen e Dates
	{
		$AddColQuery="ALTER TABLE `$Table` ADD `$data` TEXT NOT NULL"; 
		mysqli_query($VID_STATS, $AddColQuery); 
		
		$UpdColQuery="UPDATE `$Table` SET `$data`='D(0,0,0)-M(0,0,0)' WHERE 1";
		mysqli_query($VID_STATS, $UpdColQuery); 
		
		$result=mysqli_query($VID_STATS, $SelectQuery); //Jami ne Querine e Selektimit pas perditesimit
		$row_2=mysqli_fetch_assoc($result); 
	}
	
	if(!isset($row_2["$data"])) 	$row_2_data_stats='D(0,0,0)-M(0,0,0)';
	else $row_2_data_stats=$row_2["$data"];
	
	$updated_views=UpdateStats($row_2_data_stats, $DoM, $Stream);
	//Me ne fund perditeso vleren e statistikave ne databaze
	$UpdQuery="UPDATE `$Table` SET `$data`='$updated_views' WHERE `Indeksi`='$Indeksi'"; 
	mysqli_query($VID_STATS, $UpdQuery); 
	
	echo "<p>$UpdQuery</p>";
}
    
else exit("Te dhenat tuaja jane te pasakta.");
?>