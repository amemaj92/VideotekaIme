<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//-------------------------DB CONN
$VID_MOVIES;  //--> Linku i databazes me informacionet per serialet. 
$host="localhost";
$username="videtmnv_admin";
$password="UoZ]8Pc.w.ov"; 
$VID_MOVIES = mysqli_connect($host, $username, $password, "videtmnv_MOVIES");

$table="filma_me_titra_shqip";

$data=array();	//Indeksi, Indeksi_per_Kerkim, Tituj_te_Tjere, Viti, Regjia, Aktoret, Nenkategorite, Orig, Pershkrimi, Data_Shtimit, Stream_1, Stream_2

/*----------------------------------KODI PER OPENLOAD--------------------------------------*/

$file_name="movies.csv";	//Emri i file-it
$source = fopen('movies.csv', 'r') or die("Problem open file");
while (($data = fgetcsv($source, 0, ",")) !== FALSE)
{
	$Indeksi = mysql_escape_string($data[0]);
	$Indeksi_per_Kerkim = $data[1];
	$Tituj_te_Tjere = $data[2];
	$Viti = $data[3];
	$Regjia = mysql_escape_string($data[4]);
	$Aktoret = mysql_escape_string($data[5]);
	$Nenkategorite = mysql_escape_string($data[6]);
	$Orig = mysql_escape_string($data[7]);
	$Pershkrimi = mysql_escape_string($data[8]);
	$Data_Shtimit=date("Y-m-d");
	$Stream_1 = $data[9];
	$Stream_2 = $data[10];
	$Host="http://videoteka-ime.com/video/";
	
	
	$query="INSERT INTO `$table`(`ID`, `Indeksi`, `Indeksi_per_Kerkim`, `Tituj_te_Tjere`, `Viti`, `Regjia`, `Aktoret`, `Nenkategorite`, `Orig`, `Pershkrimi`, `Data_Shtimit`, `Stream_1`, `Stream_2`, `Stream_2_mobile`, `Host`) VALUES (NULL, '$Indeksi', '$Indeksi_per_Kerkim', '$Tituj_te_Tjere', '$Viti', '$Regjia', '$Aktoret', '$Nenkategorite', '$Orig', '$Pershkrimi', '$Data_Shtimit', '$Stream_1', '$Stream_2', '', '$Host')";
	
	mysqli_query($VID_MOVIES,$query);
	
	echo "<p>$query</p><br>";
}

fclose($source);

