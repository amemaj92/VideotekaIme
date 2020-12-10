<?php
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

//-------------------------DB CONN
$VID_SERIES;  //--> Linku i databazes me informacionet per serialet. 
$host="localhost";
$username="videtmnv_admin";
$password="UoZ]8Pc.w.ov"; 
$VID_STATS = mysqli_connect($host, $username, $password, "videtmnv_STATS");

echo "Connection sucessful!<br>"; 

//Connecting to the Stats database. Reading first row from the table of series. 

$query=mysqli_query($VID_STATS, "SELECT * FROM `Series`");

$day = 1; 
$month = 6; 
$year= "2019";
$date=""; 

function fold_views($s) {
	$pos= strpos($s, "-M");
	$desk_str= substr($s,2, $pos-3);
	$pos2= strpos($s,")",$pos);
	$mob_str= substr($s,$pos+3,$pos2-$pos-3);
	
	$arrd=explode(",", $desk_str);
	$arrm=explode(",", $mob_str);
	$sum=0; 
	for($i=0; $i<3; $i++) {$sum+=intval($arrd[$i]);}
	for($i=0; $i<3; $i++) {$sum+=intval($arrm[$i]);}  
	return $sum; 	 
}

while ($row = mysqli_fetch_assoc($query)) {
	$month=6;
	echo "$row[Indeksi]";
	while ($month<12)
	{
		$day=1; 
		$sum=0; 
		while($day<32)
		{
			$date="$year-";
			if($month<10) $date=$date."0$month-";
			else $date=$date."$month-"; 
			if($day<10) $date=$date."0$day";
			else $date=$date."$day"; 
			
			if(isset($row["$date"])) {$sum+=fold_views($row[$date]);} 
			$day++;
		}
		echo ", $month , $sum";
		$month++;
	}
	echo "<br>";
}

//print_r($row);  
?>
