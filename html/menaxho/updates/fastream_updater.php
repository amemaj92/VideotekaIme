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
$password="endri&keta4992"; 
$VID_SERIES = mysqli_connect($host, $username, $password, "videtmnv_SERIES");

$data_array=array();	//Identifier, Indeksi, Episodi, Pjesa, Stream_1, Stream_2, Stream_2_mobile

/*-----------------------------------KODI PER FASTSTREAM-------------------------------------*/

echo "<br><p> LINKET E FASTREAM</p><br>";
$file_name="fastream_links.txt";	//Emri i file-it
$file_handle=fopen($file_name, "r"); 	//Indeksi per file-in
while (!feof($file_handle))
{
	$rreshti=fgets($file_handle); 	//Rresht me linket e videove
	if(!empty($rreshti))
	{
		$rreshti_array=explode("\t", $rreshti, 2);
		$raw_streamlink=$rreshti_array[0]; 
		$last_delimiter=strrpos($raw_streamlink,"/"); 	//finds the pos of the '/' preceeding the hash
		//Refining the link into embed form		'/'embed-'the hash'.html
		$refined_streamlink=substr($raw_streamlink,0,$last_delimiter+1)."embed-".substr($raw_streamlink,$last_delimiter+1).".html";
		
		$raw_episode=$rreshti_array[1];
		$refined_episode=str_replace(" ","_", $raw_episode);
		$delimiter=strrpos($refined_episode,"-"); 	//finds the pos of the '-' to 
		//extract the index
		$Indeksi=substr($refined_episode,0,$delimiter);
		//extract the episode and the pjesa if it exists
		$pjesa=-1;
		$episode_str=substr($refined_episode,$delimiter+1);
		$next_delimiter=strpos($episode_str,"_");
		if($next_delimiter) {$episode=(int)substr($episode_str,0, $next_delimiter); $pjesa=(int)substr($episode_str, $next_delimiter+1);}
		else {$episode=(int)$episode_str;}
		
		//Update Streamlink within Array
		$Identifier=$Indeksi."-".$episode."_".$pjesa; 
		
		$temp_array=array($Identifier, $Indeksi, $episode, $pjesa, "", "", $refined_streamlink);
		array_push($data_array,$temp_array);		
		
		echo "$rreshti <br>$refined_streamlink  ---------  $Indeksi  --------- $episode "; if($pjesa>0) echo "--------------- $pjesa"; echo " <br>"; 
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
	$query="UPDATE `$Indeksi` SET `Stream_2_mobile` =  '$Stream_2_mobile' WHERE  `Episodi` = '$Episodi' ";
	//Kodi per pjesen
	if($Pjesa>0) $query=$query. "AND `Pjesa` = '$Pjesa'"; 
	
	echo "$query<br>";
	mysqli_query($VID_SERIES,$query);	
}

?>