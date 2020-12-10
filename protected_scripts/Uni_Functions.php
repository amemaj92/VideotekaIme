<?php


/*----GetOS Function and IsMobile Function----*/
/*Keto funksione gjejne sistemin operativ te vizitorit dhe nese ai eshte apo jo 
perdorues i nje pajisjeje mobile. Ne varesi te ketyre dy te dhenave, te shpetuara ne 
variablat: $OS_Platform, $IsMobile*/
/*----GetOs Function----*/

function GetOS() { 
    global $user_agent;
    $os_platform="Unknown OS Platform";
    $os_array=array(
        '/windows nt 10/i'     =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile');
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

/*----IsMobile Function----*/
function IsMobile()  {
    global $user_agent;
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$user_agent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($user_agent,0,4)))
    return 1; 
    else return 0;
}

/*----Function NavEcho----*/
/*Ky funksion do te krijoje ne menyre dinamike seksionin e Navigacionit ne te gjitha 
faqet. Ai merr si te dhena 
    $Category:(Kreu, Filma, Seriale) -> Pergjegjese per t'i dhene klasen "current" elementit perkates <li>;
	$SubCategory: (Nenkategorite e Serialeve dhe Filmave, sipas vektoreve $FilmsArray dhe $SeriesArray ne linjat 23:27)
	-> Pergjegjese per t'i dhene klasen "current" elementit perkates <li>;
*/
function HeaderAndNavEcho($Category, $SubCategory){
	/*Pjesa e dy skripteve qe ben kontrollin per ADBLOKUN dhe inaktivizimin e tij.*/
	echo '<div id="header">
	
			
			<script src="/uni/popunder.js" type="text/javascript"></script>
			<script type="text/javascript">
			if(typeof ad_permission == "null" || typeof ad_permission== "undefined") {
				var orig=window.location.href; 
				window.location="/uni/adpower.php?orig="+orig;}
			</script>';
	
	echo '
			<div id="header_upper_strip">
			<div id="header_main">
			<img id="logo" src="/uni/images/logo.png" alt="Videotekaime.com logo">
		            <div id="main_nav">';
	echo '  	        <a href="/index.php" '; if($Category=="Kreu") echo 'class="current"'; echo'>Kreu</a>';
	echo '    	        <a href="#" '; if($Category=="Seriale")  echo 'class="current"'; echo '>Seriale</a>';
	echo '    	        <a href="#" '; if($Category=="Filma") echo 'class="current"'; echo'>Filma</a>';
	echo ' 			<a href="/premium/info.php" '; if($Category=="Premium") echo 'class="current"'; echo'>Premium</a>';
	echo '              </div>
	                </div>
	                </div>';	
	echo ' 	<div id="subnavs">
		        <ul id="seriale_subnav">';
	/*----Series and Films Subcategories-----*/
	/*Njerrja e kategorive kryesore te filmave dhe serialeve nga vektoret ne linjat (23:27) */
	global $SeriesArray;
	for($i=0; $i<count($SeriesArray); $i++) {
		echo '        <li'; if($SubCategory==$SeriesArray[$i]) echo ' class="current"'; echo'>';
		/*Linku per cdo kategori merr prapashtesen "_me_titra_shqip", perjashto serialet vizatimor. 
		Per serialet vizatimor prapashtesa eshte "_me_titra_dhe_te_dubluar_shqip". */
		if ($SeriesArray[$i]!="seriale_vizatimor") echo '<a href="/seriale_shqip/'.$SeriesArray[$i].'_me_titra_shqip">'; 
		else echo '<a href="/seriale_shqip/'.$SeriesArray[$i].'_me_titra_dhe_te_dubluar_shqip">'; 
		/*Teksti qe do te shfaqet per vizitorin brenda elementit <a></a> do te formohet nga perpunimi 
		i kategorise se serialeve me funksionin StringParser */
		echo StringParser($SeriesArray[$i], true); echo'</a></li>';
	}
	
	echo '		</ul>';
	
	echo '		<ul id="filma_subnav">';
	global $FilmsArray;
	for($i=0; $i<count($FilmsArray); $i++) {
		echo '        <li'; if($SubCategory==$FilmsArray[$i]) echo ' class="current"'; echo'>';
		echo '<a href="/filma_shqip/'.$FilmsArray[$i].'">'; 
		echo StringParser($FilmsArray[$i], true); echo'</a></li>';
	}
	
	echo '		 </ul>';
	echo '	<div id="premium_login_and_signup">
	
		</div>
			 </div>
	      </div>'; 
}

/*----Function StringParser----*/
/*Ky funksion heq nga stringu karakteret '_' dhe i zevendeson me hapesira boshe, si dhe ben 
shkronje te madhe fillimin e stringut nese argumenti $uc_first eshte 1. */
function StringParser($string, $uc_first){
    $temp=str_replace("_"," ",$string);
    if($uc_first) $temp=ucfirst($temp); 
    return $temp;
}

/*----Function SeriesCategSaL----*/
/*Ky funksion ka per detyre konvertimin e kategorive te serialeve ne versionet e 
tyre te shkurtuara dhe anasjelltas, siç jane percaktuar ne vektoret ne linjat (23:27). */
function SeriesCategSaL($InpCateg, $SaL) {	//SaL=1 for Short to Long and SaL=2 for Long to Short
    global $SeriesArray;
    global $SeriesArrayShort;
    if($SaL==1) {
    	for($i=0; $i<count($SeriesArrayShort); $i++) {if($SeriesArrayShort[$i]==$InpCateg) break;}
    	if($i<count($SeriesArrayShort)) return $SeriesArray[$i];
    	else return false;
    }
    
    else if($SaL==2) {
        for($i=0; $i<count($SeriesArray); $i++) {if($SeriesArray[$i]==$InpCateg) break;}
    	if($i<count($SeriesArray)) return $SeriesArrayShort[$i];
    	else return false;
    }
    else return false;
}

/*----Function SeriesCategSaL----*/
/*Ky funksion ka per detyre konvertimin e kategorive te filmave ne versionet e 
tyre te shkurtuara dhe anasjelltas, siç jane percaktuar ne vektoret ne linjat (23:27). */
function FilmsCategSaL($InpCateg, $SaL) {	//SaL=1 for Short to Long and SaL=2 for Long to Short
    global $FilmsArray;
    global $FilmsArrayShort;
    if($SaL==1) {
    	for($i=0; $i<count($FilmsArrayShort); $i++) {if($FilmsArrayShort[$i]==$InpCateg) break;}
    	if($i<count($FilmsArrayShort)) return $FilmsArray[$i];
    	else return false;
    }
    
    else if($SaL==2) {
        for($i=0; $i<count($FilmsArray); $i++) {if($FilmsArray[$i]==$InpCateg) break;}
    	if($i<count($FilmsArray)) return $FilmsArrayShort[$i];
    	else return false;
    }
    else return false;
}

/*----Function FcbSeriesEcho----*/
//Printon div-in me linkun e faqes se facebookut per serialet. 
function FcbSeriesEcho($serial_category){
    echo '<div id="fcb_ser"><p>Na ndiq ne Facebook per te mos humbur asnje te re nga <i>serialet '.$serial_category.'me titra shqip</i>!</p>';
    echo '<div class="fb-like" data-href="https://www.facebook.com/serialemetitrashqip" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div></div>';
}

/*----Function FcbFilmssEcho----*/
//Printon div-in me linkun e faqes se facebookut per filmat.
function FcbMoviesEcho($film_category) {
    echo '<div id="fcb_films"><p>Na ndiq ne Facebook per te mos humbur asnje te re nga <i>filmat'.$film_category.'</i> ne shqip!</p>';						
    echo '<div class="fb-like" data-href="https://www.facebook.com/videotekaimefilmashqip/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div></div>';
}	

/*Ky funksion merr si te dhene nje string me episodin dhe pjesen dhe i nxjerr ato si nje vektor me dy elemente, perkatesisht episodin [0] dhe pjesen [1]
shembull: input: "54-4" -> output vek{54, 4}*/
function SeriesLastEpisodeParser($episode_part_string) {
    $temp_array=array();
    if(strpos($episode_part_string, "-")) $temp_array=explode("-", $episode_part_string);
    else {$temp_array[0]=$episode_part_string; $temp_array[1]="";}
    return $temp_array;
}

/*----Function SeriesNameParser----*/
function SeriesNameParser($indeksi, $dubl_titr, $Episodi, $Pjesa) {
    $temp=StringParser($indeksi, true); /*Shembull 'kara_sevda'->'Kara sevda', qe do te thote se indekset 
	duhet te permbajne shkronja te medha nese emrat e tyre do te kene shkronja te medha te tjera pervec shkronjes se pare.;*/
    if($dubl_titr) $temp=$temp.StringParser($dubl_titr, false);	//Shembull '_me_titra_shqip'->' me titra shqip'. Per me shume shiko funks. StringParser
    if($Episodi) $temp=$temp." Episodi $Episodi";
    if($Pjesa) $temp=$temp."-$Pjesa";
    return $temp;
}

/*-----Function for SeasonLastEpisodeArray-----*/
/*Ky funksion hedh ne vektor episodet e fundit te çdo sezoni duke perpunuar argumentin string $Seasons_string, 
i cili mund te merret nga rreshti i Databazes per serialet. */
function LastSeasonEpisodeArray($Seasons_string){
    /*-----Hedhja e episodeve te fundit te sezoneve ne array*/
    $LastSeasonEpisodeArray=array();
    $temp_seas_array=array();
    $temp_seas_array=explode(",", $Seasons_string);

    for($i=0; $i<count($temp_seas_array); $i++) {
		$temp_start=strpos($temp_seas_array[$i], "-")+1;
		$temp_stop=strpos($temp_seas_array[$i], "]")-1;
		$LastSeasonEpisodeArray[$i]=intval(substr($temp_seas_array[$i],$temp_start, $temp_stop));
    }
    return $LastSeasonEpisodeArray;
}

/*-----Function for SeriesStatusEcho-----*/
/*Duke marre si input vektorin me episodet e fundit te çdo sezoni, ky funksion perllogarit dhe nxjerr statusin 
e serialit te dhene, duke perdorur daten e fundit te perditesimit ($Data_Perditesimit) dhe daten e dites kur behet perllogaritja.
Nderkohe $Seasons_string jepet si argument, dhe mund te merret lehte nga rreshti perkates ne databaze.*/
function SeriesStatusEcho($Seasons_string, $Last_Episode, $Data_Perditesimit){
    $LastSeasonEpisodeArray=LastSeasonEpisodeArray($Seasons_string);
    /*-----Date Difference-----*/
    $date1 = $Data_Perditesimit;
    $date2 = date("Y-m-d");
    $diff = abs(strtotime($date2) - strtotime($date1));
    
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    $DaysDiff=$days+$months*30+$years*365;
    
    /*-----Calculating Status Output-----*/
	
    for($i=0; $i<count($LastSeasonEpisodeArray); $i++) 
    {
        if($Last_Episode==$LastSeasonEpisodeArray[$i]) 
        {
            if($i<(count($LastSeasonEpisodeArray)-1)) return "Sez. ".($i+1)." - I Perfunduar";
    	    else if($i==count($LastSeasonEpisodeArray)-1) return "I Perfunduar"; //Sez. i fundit ka perfunduar, pra seriali ka perfunduar.
        }
    }

    if($DaysDiff>=7) { //Nese kane kaluar =>7 dite nga perditesimi i fundit kontrollo nese ka mbaruar ndonje sezon nga seriali. 
        return "Ne Pauze";
    }
    else return "Aktiv";
}

/*-----Function MoviesSubcategoriesEcho----*/
/*Duke marre si input tablen e filmave ne databazen e filmave, ky funksion nxjerr nenkategorite e vecanta te regjistruara ne gjithe tabelen. ----*/
function MoviesSubcategoriesArrayEcho($movies_table) {
    global $VID_MOVIES;
    $result=mysqli_query($VID_MOVIES, "SELECT DISTINCT `Nenkategorite` FROM `$movies_table`");
    $i; $j; 
    $raw_results_array=array(); 
    $polished_results_array=array(""); 
    while($row=mysqli_fetch_assoc($result)) 
    {
    	$temp_array=explode(",", $row["Nenkategorite"]);  //Nxjerrja e nenkategorive si elemente menjane dhe futja e tyre ne vektorin e paperpunuar.
    	for($i=0; $i<count($temp_array); $i++){array_push($raw_results_array, $temp_array[$i]);}
    }
    //Eleminimi i nenkategorive te perseritura dhe futja vetem e nenkategorive te paparseritura ne vektorin perfundimtar
    for($i=0; $i<count($raw_results_array); $i++)
    {
    	$already_exists=false; 
    	for($j=0; $j<count($polished_results_array); $j++)
    	{
    	    if($raw_results_array[$i]==$polished_results_array[$j]) {$already_exists=true; break;} 
    	}
    	if(!$already_exists) {array_push($polished_results_array, $raw_results_array[$i]);}
    }
    sort($polished_results_array);
    return  $polished_results_array;
}

/*-----Function MoviesOrigsEcho----*/
/*Duke marre si input tablen e filmave me titra ne databazen e filmave, ky funksion nxjerr kolonen Orig si Array. ----*/
function MoviesOrigsEcho($movies_table) {
    global $VID_MOVIES;
    $result=mysqli_query($VID_MOVIES, "SELECT DISTINCT `Orig` FROM `$movies_table`");
    $results_array=array(); 
    while($row=mysqli_fetch_assoc($result)) 
    {
    	array_push($results_array, $row["Orig"]);
    }
        
    sort($results_array);
    return  $results_array;
}



/*-----Function SeriesSubcategoriesEcho----*/
/*Duke marre si input tablen e filmave ne databazen e filmave, ky funksion nxjerr nenkategorite e vecanta te regjistruara ne gjithe tabelen. ----*/
function SeriesSubcategoriesArrayEcho($series_category) {
    global $VID_SERIES;
    $result=mysqli_query($VID_SERIES, "SELECT DISTINCT `Nenkategorite` FROM `Main` WHERE `Kategoria`='$series_category' ");
    $i; $j; 
    $raw_results_array=array(); 
    $polished_results_array=array(""); 
    while($row=mysqli_fetch_assoc($result)) 
    {
    	$temp_array=explode(",", $row["Nenkategorite"]);  //Nxjerrja e nenkategorive si elemente menjane dhe futja e tyre ne vektorin e paperpunuar.
    	for($i=0; $i<count($temp_array); $i++){array_push($raw_results_array, $temp_array[$i]);}
    }
    //Eleminimi i nenkategorive te perseritura dhe futja vetem e nenkategorive te paparseritura ne vektorin perfundimtar
    for($i=0; $i<count($raw_results_array); $i++)
    {
    	$already_exists=false; 
    	for($j=0; $j<count($polished_results_array); $j++)
    	{
    	    if($raw_results_array[$i]==$polished_results_array[$j]) {$already_exists=true; break;} 
    	}
    	if(!$already_exists) array_push($polished_results_array, $raw_results_array[$i]);
    }
    
    sort($polished_results_array);
    return  $polished_results_array;
}

function UpdateStats($original_value, $DoM, $Stream) //Per $DoM=2 dhe $Stream=2 dhe $original_value='D(0,0,2)-M(1,2,3)' --> return 'D(0,1,2)-M(1,2,3)'
{
	$desk_array=array();
	$mob_array=array();
	
	$desk_str=substr($original_value,0,strpos($original_value,'-'));
	$mob_str=substr($original_value,strpos($original_value,'-')+1);
		
	$desk_str=substr($desk_str,2,strlen($desk_str)-3);
	$mob_str=substr($mob_str,2,strlen($mob_str)-3);
	
	$desk_array=explode(',',$desk_str);
	$mob_array=explode(',',$mob_str);
	
	//Ndryshimi i vleres
	if($DoM=="D") {$desk_array[$Stream-1]=intval($desk_array[$Stream-1])+1;}	
	else if($DoM=="M") {$mob_array[$Stream-1]=intval($mob_array[$Stream-1])+1;}
	
	//Rindertimi i Stringut
	$return_string="D(".$desk_array[0].",".$desk_array[1].",".$desk_array[2].")-M(".$mob_array[0].",".$mob_array[1].",".$mob_array[2].")";
	return $return_string;
}


function user_has_right_to_watch($Statusi_i_Aprovimit,$Kredite_te_Mbetura,$Data_e_Skadences)
{
	if($Statusi_i_Aprovimit=="Approved") 
	{
		if($Kredite_te_Mbetura>0) 
		{
			if(strtotime(date("Y-m-d h:i:s"))<strtotime($Data_e_Skadences))
			{return true;}
			else return false; 
		}
		else return false; 
	}
	else return false;  
}
?>
