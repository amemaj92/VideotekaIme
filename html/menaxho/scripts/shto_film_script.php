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
	if(!isset($_POST["table"])) exit("Mungojne te dhenat e nevojshme per te vazhduar.");
	
	$movies_table=$_POST["table"];
	$query="SHOW COLUMNS FROM `$movies_table`";
	$result=mysqli_query($VID_MOVIES, $query);
	$i=0;
	$input_data_array=array();
	$query="INSERT INTO `$movies_table` (`ID`,";
	while($row=mysqli_fetch_array($result))
	{
		array_push($input_data_array , $_POST[$row[0]]);
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
	
	if(!mysqli_query($VID_MOVIES,$query)) echo "Gabim! Queria u ekzekutua me sukses. Error: ".mysqli_error($VID_MOVIES);
	else {echo "<p>U Ekzekutua me sukses ky query: <br> $query;</p>";}
	echo "<p><a href='../shto_film.php'>Kthehu pas</a></p>'";
	
?>
