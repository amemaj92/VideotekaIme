<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$ov_flag = TRUE;
$data_array2= array();
mixdrop_updater($ov_flag);

function mixdrop_updater($ov_flag) {
  //-------------------------DB CONN
  $VID_SERIES;  //--> Linku i databazes me informacionet per serialet.
  $host="localhost";
  
  $username="videtmnv_admin";
  $password="UoZ]8Pc.w.ov";

  $VID_SERIES = mysqli_connect($host, $username, $password, "videtmnv_SERIES");

  global $data_array2;		//Identifier, Indeksi, Episodi, Pjesa, Stream_1, Stream_2, Stream_2_mobile
  $querries_array= array();  	//Querries array.
  $counter=0;

  /*----------------------------------KODI PER OPENLOAD--------------------------------------*/
  echo "<p>MIXDROP LINKS </p><br>";
  $file_name="mixdrop_links.txt";	//Emri i file-it
  $file_handle=fopen($file_name, "r"); 	//Indeksi per file-in
  while (!feof($file_handle))
  {
    $file_row=fgets($file_handle); 	//Rresht me linket e videove
  	if(!empty($file_row)) //empty("") -> TRUE
  	{
      if(strpos($file_row, ".mp4", 0)!=false) { //Rresht me emrin e episodit
        $raw_episode=substr($file_row,0,strpos($file_row,".mp4"));
        $delimiter=strrpos($raw_episode,"-"); 	//finds the pos of the '-' to
        //extract the index
        $Indeksi=substr($raw_episode,0,$delimiter);
        //extract the episode and the pjesa if it exists
        $Pjesa=-1;
        $episode_str=substr($raw_episode,$delimiter+1);
        $next_delimiter=strpos($episode_str,"_");
        if($next_delimiter) {$Episode=(int)substr($episode_str,0, $next_delimiter); $Pjesa=(int)substr($episode_str, $next_delimiter+1);}
        else {$Episode=(int)$episode_str;}
        //get the Streamlink
        $Stream_link = fgets($file_handle);

        $check_query = "SELECT * FROM `$Indeksi` WHERE `Episodi` = '$Episode' ";
     		if($Pjesa>0) $query=$query. "AND `Pjesa` = '$Pjesa'";
    		$exists=FALSE;
    		if(mysqli_num_rows(mysqli_query($VID_SERIES,$check_query))>0) $exists=TRUE;

    		if($exists) {
          if($ov_flag) {
    			  $query = "UPDATE `$Indeksi` SET `Stream_2` =  '$Stream_link' WHERE  `Episodi` = '$Episode' ";
    			  if($Pjesa>0) $query=$query. "AND `Pjesa` = '$Pjesa'";
            echo "$file_row <br>$query <br>";
            array_push($querries_array,$query);
          }
        }
    		else {
    			$query = "INSERT INTO `$Indeksi` (`ID`, `Episodi`, ";
    			if($Pjesa>0) $query=$query. "`Pjesa`, '";
    			$query = $query."`Stream_1`, `Stream_2`, `Stream_3`) VALUES (NULL, $Episode, ";
    			if($Pjesa>0) $query=$query. " Pjesa, ";
    			$query = $query. "'' , '$Stream_link', '')";
          echo "$file_row <br>$query <br>";
          array_push($querries_array,$query);
	  array_push($data_array2, array($Indeksi,$Episode,$Pjesa));
	}
      }
      else {  //Rresht bosh
        continue;
      }
    }
  }
  /*----------------------------Execute the Queries---------------------------*/
  for($i=0; $i<count($querries_array); $i++)
  {
  	  mysqli_query($VID_SERIES,$querries_array[$i]);
  }
}

?>
