<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$ov_flag = TRUE;
$data_array1 = array();
unlimited_updater($ov_flag);


function unlimited_updater ($ov_flag) {
  //-------------------------DB CONN
  $VID_SERIES;  //--> Linku i databazes me informacionet per serialet.
  $host="localhost";

  $username="videtmnv_admin";
  $password="UoZ]8Pc.w.ov";

  $VID_SERIES = mysqli_connect($host, $username, $password, "videtmnv_SERIES");

  global $data_array1;		//Identifier, Indeksi, Episodi, Pjesa, Stream_1, Stream_2, Stream_2_mobile
  $querries_array= array();  	//Querries array.
  /*----------------------------------KODI PER OPENLOAD--------------------------------------*/
  echo "<p>UNLIMITED LINKS </p><br>";
  $file_name="unlimited_links.txt";	//Emri i file-it
  $file_handle=fopen($file_name, "r"); 	//Indeksi per file-in
  while (!feof($file_handle))
  {
  	$file_row=fgets($file_handle); 	//Rresht me linket e videove
  	if(!empty($file_row))
  	{
  		$streamlink=$file_row;
  		$last_delimiter=strrpos($streamlink,"/"); 	//finds the pos of the '/' preceeding the name

  		$raw_episode=urldecode(substr($streamlink,$last_delimiter+1));
  		$delimiter=strrpos($raw_episode,"-"); 	//finds the pos of the '-' to
  		//extract the index
  		$Indeksi=substr($raw_episode,0,$delimiter);
  		//extract the episode and the pjesa if it exists
  		$Pjesa=-1;
  		$episode_str=substr($raw_episode,$delimiter+1);
  		$next_delimiter=strpos($episode_str,"_");
  		if($next_delimiter) {$Episode=(int)substr($episode_str,0, $next_delimiter); $Pjesa=(int)substr($episode_str, $next_delimiter+1);}
  		else {$Episode=(int)$episode_str;}

  		//Transform $streamlink to appropriate embed link format
  		$encoded_start_index=strrpos(substr($streamlink,0, $last_delimiter-1), "/");
  		$encoded_code=substr($streamlink, $encoded_start_index+1, 12);
  		$encoded_code_final="https://gounlimited.to/embed-".$encoded_code.".html";
  		$Stream_link=$encoded_code_final;
  		//add data to query array

  		$check_query = "SELECT * FROM `$Indeksi` WHERE `Episodi` = '$Episode' ";
   		if($Pjesa>0) $query=$query. "AND `Pjesa` = '$Pjesa'";
  		$exists=FALSE;
  		if(mysqli_num_rows(mysqli_query($VID_SERIES,$check_query))>0) $exists=TRUE;

  		if($exists) {
        if($ov_flag) {
  			  $query = "UPDATE `$Indeksi` SET `Stream_1` =  '$Stream_link' WHERE  `Episodi` = '$Episode' ";
  			  if($Pjesa>0) $query=$query. "AND `Pjesa` = '$Pjesa'";
          echo "$file_row <br>$query <br>";
          array_push($querries_array,$query);
        }
      }
  		else {
  			$query = "INSERT INTO `$Indeksi` (`ID`, `Episodi`, ";
  			if($Pjesa>0) $query=$query. "`Pjesa`, '";
  			$query = $query."`Stream_1`, `Stream_2`, `Stream_3`) VALUES (NULL, $Episode, ";
  			if($Pjesa>0) $query=$query. " $Pjesa, ";
  			$query = $query. "'$Stream_link' , '', '')";
        echo "$file_row <br>$query <br>";
        array_push($querries_array,$query);
	array_push($data_array1, array($Indeksi,$Episode,$Pjesa));
  		}
  	}
  }

  /*----------------------------Execute the Queries-----------------------------------*/
  for($i=0; $i<count($querries_array); $i++)
  {
  	  mysqli_query($VID_SERIES,$querries_array[$i]);
  }
}
?>
