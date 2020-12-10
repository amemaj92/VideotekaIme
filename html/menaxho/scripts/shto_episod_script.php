<?php 
	session_start();
	$Page_Id="shto_film";
			
	include("../../uni/db_connect.php");
	//nese nuk eshte bere login perjashtoje

	if(!isset($_SESSION["username"]) && !isset($_SESSION["password"]))
	{
		header("Location: ../index.php");
	}
	
	$Prefix='../../';

	//Useri eshte bere login dhe te dhenat jane dhene me submit.
	if(!isset($_POST["seriali"])) exit("Mungojne te dhenat e nevojshme per te vazhduar.");
	
	$Indeksi=$_POST["seriali"];
	$query="SHOW COLUMNS FROM `$Indeksi`";
	$result=mysqli_query($VID_SERIES, $query);
	$i=0;
	$input_data_array=array();
	$query="INSERT INTO `$Indeksi` (`ID`,";
	while($row=mysqli_fetch_array($result))
	{
		array_push($input_data_array , $_POST[$row[0]]);
		if($row[0]=="Episodi") $Episodi=$_POST[$row[0]];
		if($row[0]=="Pjesa") $Pjesa=$_POST[$row[0]];
		if($i==0) {$i++; continue;}
		else if($i<mysqli_num_rows($result)-1) $query=$query." `$row[0]`,";
		else $query=$query." `$row[0]`)";
		$i++;		
	}
		
	$query=$query." VALUES (NULL,";

	for($i=1; $i<count($input_data_array); $i++)
	{
		if($i<count($input_data_array)-1) $query=$query."'$input_data_array[$i]',";
		else $query=$query."'$input_data_array[$i]')";
	}
	
	if(!mysqli_query($VID_SERIES,$query)) echo "Gabim! Queria u ekzekutua me sukses. Error: ".mysqli_error($VID_MOVIES);
	else {echo "<p>U Ekzekutua me sukses ky query: <br> $query;</p>";}
	
	//Second Query
	$Episodi_i_fundit=$Episodi; 
	if(isset($Pjesa)) $Episodi_i_fundit=$Episodi_i_fundit."-".$Pjesa; 
	$data_perditesimit=date("Y-m-d");
	
	$query="UPDATE `Main` SET `Data_Perditesimit`='$data_perditesimit',`Episodi_i_fundit`='$Episodi_i_fundit' WHERE `Indeksi`='$Indeksi'"; 
	if(!mysqli_query($VID_SERIES,$query)) echo "Gabim! Queria u ekzekutua me sukses. Error: ".mysqli_error($VID_SERIES);
	else {echo "<p>U Ekzekutua me sukses edhe ky query: <br> $query;</p>";}
	echo "<p><a href='../shto_serial.php'>Kthehu pas</a></p>'";
?>
