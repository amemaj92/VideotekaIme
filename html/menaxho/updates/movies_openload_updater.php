<?php
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

//-------------------------DB CONN
$VID_MOVIES;  //--> Linku i databazes me informacionet per serialet. 
$host="localhost";
$username="videtmnv_admin";
$password="UoZ]8Pc.w.ov"; 
$VID_MOVIES = mysqli_connect($host, $username, $password, "videtmnv_MOVIES");
$movies_table="filma_te_dubluar_ne_shqip";
$data_array=array();	//Identifier, Indeksi, Episodi, Pjesa, Stream_1, Stream_2, Stream_2_mobile

/*-----------------------------------KODI PER STREAMANGO-------------------------------------*/
echo "<br><p>LINKET E OPENLOAD </p><br>";
$file_name="movies_openload_links.txt";	//Emri i file-it
$file_handle=fopen($file_name, "r"); 	//Indeksi per file-in
while (!feof($file_handle))
{
	$rreshti=fgets($file_handle); 	//Rresht me linket e videove
	if(!empty($rreshti))
	{
		$streamlink=$rreshti; 
		$last_delimiter=strrpos($streamlink,"/"); 	//finds the pos of the '/' preceeding the name

		$raw_streamlink=urldecode(substr($streamlink,$last_delimiter+1));
		$delimiter=strrpos($raw_streamlink,".mp4"); 	//finds the pos of the '-' to 
		//extract the index
		$Indeksi=substr($raw_streamlink,0,$delimiter);
		
		//Update Streamlink within Array
				
		$temp_array=array($Indeksi, $streamlink);
		array_push($data_array,$temp_array);		
		
		echo "$rreshti <br>Indeksi ---- $Indeksi<br>"; 
	}
}

echo "<br><br>"; //print_r($data_array);

echo "<br><br>";


/*------------------------Zeroing the current links (Blank Sheet strategy) ----------------------*/
mysqli_query($VID_MOVIES,"UPDATE `$movies_table` SET `Stream_1` =  '' ");	

/*----------------------------Creating and Executing the Queries-----------------------------------*/
for($i=0; $i<count($data_array); $i++)
{
	$Indeksi=$data_array[$i][0];
	$Stream_1=$data_array[$i][1];
	//$data_array structure------------>> Indeksi,Stream_2
	//First query per futjen e episodeve
	$query="UPDATE `$movies_table` SET `Stream_1` =  '$Stream_1' WHERE  `Indeksi` = '$Indeksi' ";
	//Kodi per pjesen
	mysqli_query($VID_MOVIES,$query);	
}

$result=mysqli_query($VID_MOVIES,"SELECT * FROM `$movies_table` WHERE `Stream_1` = '' ORDER BY `Indeksi` ASC ");
echo "<br><br>FILMAT ME MUNGESE NE $movies_table NE OPENLOAD";

while($row=mysqli_fetch_assoc($result))
{
	echo "<br> $row[Indeksi].mp4";
}

?>