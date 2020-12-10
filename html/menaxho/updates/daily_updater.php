<?php
include_once 'unlimited_updater.php';
include_once 'mixdrop_updater.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

//-------------------------DB CONN
$VID_SERIES;  //--> Linku i databazes me informacionet per serialet.
$host="localhost";

$username="videtmnv_admin";
$password="UoZ]8Pc.w.ov";

$VID_SERIES = mysqli_connect($host, $username, $password, "videtmnv_SERIES");

$ov_flag = TRUE;
$querries_array = array();

if(count($data_array1)>count($data_array2))  $added_array=$data_array1;
else  $added_array= $data_array2;

/*----------------------------Creating and Executing the Queries-----------------------------------*/

for($i=0; $i<count($added_array); $i++)
{
	echo "<br>";
	$Indeksi=$added_array[$i][0];
	$Episodi=$added_array[$i][1];
	$Pjesa=$added_array[$i][2];

  	//Second Query per daten e perditesimit
  	$Episodi_i_fundit=$Episodi;
  	if($Pjesa>0) $Episodi_i_fundit=$Episodi_i_fundit."-".$Pjesa;
  	$data_perditesimit=date("Y-m-d");

    $query="UPDATE `Main` SET `Data_Perditesimit`='$data_perditesimit',`Episodi_i_fundit`='$Episodi_i_fundit' WHERE `Indeksi`='$Indeksi'";
    mysqli_query($VID_SERIES,$query);
    $query="UPDATE `Main_Premium` SET `Data_Perditesimit`='$data_perditesimit',`Episodi_i_fundit`='$Episodi_i_fundit' WHERE `Indeksi`='$Indeksi'";
    mysqli_query($VID_SERIES,$query);
}

/*-----------------Deleting the Old Tokens------------------------*/

$VID_STATS = mysqli_connect($host, $username, $password, "videtmnv_STATS");
//Declaring Varibales

$result=mysqli_query($VID_STATS, "SELECT * FROM `Tokens`");

$i=0;
while($row=mysqli_fetch_assoc($result))
{
	$ID=$row["ID"];
	$Timestamp=$row["Timestamp"];
	$Current_timestamp=time();

	$Difference=$Current_timestamp-$Timestamp;

	if($Difference>3600)
	{
		$inner_query="DELETE FROM `Tokens` WHERE `ID`='$ID'";
		mysqli_query($VID_STATS, $inner_query);
		$i++;
	}
	if($i>100000) break;
}

echo "<p>Deleted $i Tokens</p>";
?>
