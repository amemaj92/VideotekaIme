<?php
/*----PHP Scripts And Variables----*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

//-------------------------DB CONN
$VID_SERIES;  //--> Linku i databazes me informacionet per serialet. 
$host="localhost";
$username="videtmnv_admin";
$password="UoZ]8Pc.w.ov"; 
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

echo "<p>Deleted $i Entries</p>";

//mysqli_query($mysqli_e, "DELETE * FROM `login_attempts` WHERE `user_id`='-1'");

?>