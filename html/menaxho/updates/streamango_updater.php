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
$VID_SERIES = mysqli_connect($host, $username, $password, "videtmnv_SERIES");

$data_array=array();	//Identifier, Indeksi, Episodi, Pjesa, Stream_1, Stream_2, Stream_2_mobile

/*-----------------------------------KODI PER STREAMANGO-------------------------------------*/
echo "<br><p> LINKET E STREAMANGO </p><br>";
$file_name="streamango_links.txt";	//Emri i file-it
$file_handle=fopen($file_name, "r"); 	//Indeksi per file-in
while (!feof($file_handle))
{
	$rreshti=fgets($file_handle); 	//Rresht me linket e videove
	if(!empty($rreshti))
	{
		$streamlink=$rreshti; 
		$last_delimiter=strrpos($streamlink,"/"); 	//finds the pos of the '/' preceeding the name

		$raw_episode=urldecode(substr($streamlink,$last_delimiter+1));
		$delimiter=strrpos($raw_episode,"-"); 	//finds the pos of the '-' to 
		//extract the index
		$Indeksi=substr($raw_episode,0,$delimiter);
		//extract the episode and the pjesa if it exists
		$pjesa=-1;
		$episode_str=substr($raw_episode,$delimiter+1);
		$next_delimiter=strpos($episode_str,"_");
		if($next_delimiter) {$episode=(int)substr($episode_str,0, $next_delimiter); $pjesa=(int)substr($episode_str, $next_delimiter+1);}
		else {$episode=(int)$episode_str;}
		
		//Update Streamlink within Array
		//Rasti per Trimi_Xhesuri_dhe_e_Bukura
		if($Indeksi=="Trimi_Xhesuri_dhe_e_Bukura") $Indeksi="Trimi_(Xhesuri)_dhe_e_Bukura";
		$Identifier=$Indeksi."-".$episode."_".$pjesa; 
				
		$temp_array=array($Identifier, $Indeksi, $episode, $pjesa, "", $streamlink, "");
		array_push($data_array,$temp_array);		
		
		echo "$rreshti <br>$streamlink  ---------  $Indeksi  --------- $episode ";  if($pjesa>0) echo "--------------- $pjesa"; echo " <br>"; 
	}
}

echo "<br><br>"; print_r($data_array);

echo "<br><br>";

/*----------------------------Creating and Executing the Queries-----------------------------------*/
for($i=0; $i<count($data_array); $i++)
{
	echo "<br>";
	$Indeksi=$data_array[$i][1];
	$Episodi=$data_array[$i][2];
	$Pjesa=$data_array[$i][3];
	$Stream_1=$data_array[$i][4];
	$Stream_2=$data_array[$i][5];
	$Stream_2_mobile=$data_array[$i][6];
	//$data_array structure------------>> Identifier, Indeksi, Episodi, Pjesa, Stream_1, Stream_2, Stream_2_mobile
	//First query per futjen e episodeve
	$query="UPDATE `$Indeksi` SET `Stream_2` =  '$Stream_2' WHERE  `Episodi` = '$Episodi' ";
	//Kodi per pjesen
	if($Pjesa>0) $query=$query. "AND `Pjesa` = '$Pjesa'"; 
	
	mysqli_query($VID_SERIES,$query);	
}

?>