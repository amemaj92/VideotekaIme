<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//-------------------------DB CONN
$VID_SERIES;  //--> Linku i databazes me informacionet per serialet.
$host="localhost";

$username="videtmnv_admin";
$password="UoZ]8Pc.w.ov";

$VID_SERIES = mysqli_connect($host, $username, $password, "videtmnv_SERIES");

$query = "SELECT * FROM `Main`";
$result = mysqli_query($VID_SERIES, $query);

while($row=mysqli_fetch_assoc($result)) {
$Indeksi = $row["Indeksi"]; 

$query = "SELECT * FROM `$Indeksi`";
$interm_result = mysqli_query($VID_SERIES, $query);
$nm_cols = mysqli_num_fields($interm_result);
$row=mysqli_fetch_assoc($interm_result);
if(isset($row["Pjesa"])) $nm_cols = $nm_cols - 1;
//echo "UPDATE `$Indeksi` SET `Stream_1`='' WHERE 1;"."<br>";
if ($nm_cols == 4) echo "ALTER TABLE `$Indeksi` ADD `Stream_3` TEXT NOT NULL AFTER `Stream_1`;"."<br>";
}
?>
