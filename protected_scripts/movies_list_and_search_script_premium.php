<?php

if(isset($Sort)) 
{
	//We do it this way to not show the name of the columns in DB for security reasons
	if ($Sort=="default") {$Sort_Col="Data_Shtimit"; $Sort_ASC_DESC="DESC"; }
	else if($Sort=="def") {$Sort_Col="Data_Shtimit"; $Sort_ASC_DESC="DESC";}
	else if($Sort=="a_z") {$Sort_Col="Indeksi"; $Sort_ASC_DESC="ASC"; }
	else if($Sort=="z_a") {$Sort_Col="Indeksi"; $Sort_ASC_DESC="DESC"; }
	else if($Sort=="n_o") {$Sort_Col="Viti"; $Sort_ASC_DESC="DESC"; $Sort_Col2="Data_Shtimit"; $Sort_ASC_DESC2="DESC";} //n_o="New to Old"
	else if($Sort=="o_n") {$Sort_Col="Viti"; $Sort_ASC_DESC="ASC";} //o_n="Old to New"
}
else {$Sort_Col="Data_Shtimit"; $Sort_ASC_DESC="DESC";} //Percaktimi i variablave per Sort kur ato nuk jane percaktuar


//Madhesia fikse e Dritares (Sa elemente do te shfaqen per cdo dritare)
$Window_Size=24;
$query=""; 

//Ne varesi te flamujve te ngritur, krijohet querija dhe pastaj vazhdohet ne printimin e rezultateve 
if(isset($_POST["Req_Type"]))
{
	//-----------------------Kerkim i thjeshte-------------------------//
	if($_POST["Req_Type"]=="simple_search") 
	{
		$i=0; 
		$search_string=""; 
		if(isset($_POST["search_string"]) AND !empty($_POST["search_string"])) $search_string=$_POST["search_string"];
		else {return("Ti nuk ke futur asnje te dhene per kerkimin. Fut te pakten nje te dhene dhe provoje perseri.");}
		
		//Fshirja e hapesirave rrotull presjes dhe copetimi i stringut te kermimit me baze presjen. 
		$clean_search_string = trim(preg_replace('/\s\s+/', ' ', $search_string));
		if(substr_count($clean_search_string, ',')!=0) 
		{
			$clean_search_string=str_replace(" , ", ",", $clean_search_string);	
			$clean_search_string=str_replace(", ", ",", $clean_search_string);	
			$clean_search_string=str_replace(" ,", ",", $clean_search_string);	
			$clean_search_string=str_replace(",", " ", $clean_search_string);	
		}
		
		$search_words_array=explode(" ", $clean_search_string);
		//Kujdes, viti 3000 duhet te behen me or
		$search_string=""; 
		for($i=0; $i<count($search_words_array); $i++)
		{
			if(strlen($search_words_array[$i])<4) {$search_string=$search_string."+".$search_words_array[$i]." ";}
			else $search_string=$search_string."+".$search_words_array[$i]."* ";
		}
		
		//Elemente te queri-se do te ndryshojne ne varesi te kategorise ku po behet kerkimi, 
		//pasi kolonat nuk jane te njejta ne te gjitha tabelat e filmave. 
		
		if($Kategoria=="filma_me_titra_shqip" OR $Kategoria=="filma_per_femije")
		{$query=$query."SELECT * FROM `$Kategoria` WHERE MATCH(`Indeksi_per_Kerkim`, `Tituj_te_Tjere`, `Viti`, `Regjia`, `Aktoret`, `Nenkategorite`, `Orig`) AGAINST('$search_string' IN BOOLEAN MODE)";}
		
		else if($Kategoria=="filma_shqiptar")
		{
		//Filmat shqiptare kane vetem nje titull. Ata nuk e kane kolonen e Titujve te tjere
		$query=$query."SELECT * FROM `$Kategoria` WHERE MATCH(`Indeksi_per_Kerkim`, `Viti`, `Regjia`, `Aktoret`, `Nenkategorite`) AGAINST('$search_string' IN BOOLEAN MODE)";
		}
		
		else if($Kategoria=="filma_te_dubluar_ne_shqip")
		{$query=$query."SELECT * FROM `$Kategoria` WHERE MATCH(`Indeksi_per_Kerkim`, `Tituj_te_Tjere`, `Viti`, `Studio`, `Nenkategorite`) AGAINST('$search_string' IN BOOLEAN MODE)";}
		
		$query=$query."ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC;
		if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
		$result=mysqli_query($VID_MOVIES, $query); 
	} 
	
	//-------------------------------Kerkimi i avancuar----------------------------//
	else if($_POST["Req_Type"]=="advanced_search") //Advanced Search Request
	{
		$i=0; 
		$j=0; 
		$counter=0; 
		if(isset($_POST["Titulli"]) && !empty($_POST["Titulli"])) {
			$temp=$_POST["Titulli"];
			$temp = trim(preg_replace('/\s\s+/', ' ', $temp));
			if(substr_count($temp, ',')!=0) 
			{
				$temp=str_replace(" , ", ",", $temp);	
				$temp=str_replace(", ", ",", $temp);	
				$temp=str_replace(" ,", ",", $temp);	
				$temp=str_replace(",", " ", $temp);
			}
			$temp_array=explode(" ", $temp);
			$search_string="";
			for($i=0; $i<count($temp_array); $i++)
			{
				//if($temp_array[$i]==date("Y")) $search_string=$search_string."+(".$temp_array[$i]." 3000) ";
				if(strlen($temp_array[$i])<4) {$search_string=$search_string."+".$temp_array[$i]." ";}
				else $search_string=$search_string."+".$temp_array[$i]."* ";
			} 
			$Titulli_search_string=$search_string;
			$counter++;
		} 
		else $Titulli_search_string="";
		
		if(isset($_POST["Regjia"]) && !empty($_POST["Regjia"])) {
			$temp=$_POST["Regjia"];
			$temp = trim(preg_replace('/\s\s+/', ' ', $temp));
			if(substr_count($temp, ',')!=0) 
			{
				$temp=str_replace(" , ", ",", $temp);	
				$temp=str_replace(", ", ",", $temp);	
				$temp=str_replace(" ,", ",", $temp);	
				$temp=str_replace(",", " ", $temp);
			}
			$temp_array=explode(" ", $temp);
			$search_string="";
			for($i=0; $i<count($temp_array); $i++)
			{
				//if($temp_array[$i]==date("Y")) $search_string=$search_string."+(".$temp_array[$i]." 3000) ";
				if(strlen($temp_array[$i])<4) {$search_string=$search_string."+".$temp_array[$i]." ";}
				else $search_string=$search_string."+".$temp_array[$i]."* ";
			} 
			$Regjia_search_string=$search_string;
			$counter++;
		}
		else $Regjia_search_string="";
		
		if(isset($_POST["Studio"]) && !empty($_POST["Studio"])) {
			$temp=$_POST["Studio"];
			$temp = trim(preg_replace('/\s\s+/', ' ', $temp));
			if(substr_count($temp, ',')!=0) 
			{
				$temp=str_replace(" , ", ",", $temp);	
				$temp=str_replace(", ", ",", $temp);	
				$temp=str_replace(" ,", ",", $temp);	
				$temp=str_replace(",", " ", $temp);
			}
			$temp_array=explode(" ", $temp);
			$search_string="";
			for($i=0; $i<count($temp_array); $i++)
			{
				//if($temp_array[$i]==date("Y")) $search_string=$search_string."+(".$temp_array[$i]." 3000) ";
				if(strlen($temp_array[$i])<4) {$search_string=$search_string."+".$temp_array[$i]." ";}
				else $search_string=$search_string."+".$temp_array[$i]."* ";
			} 
			$Studio_search_string=$search_string;
			$counter++;
		}
		else $Studio_search_string="";
		
		if(isset($_POST["Viti"]) && !empty($_POST["Viti"])) {
			$temp=$_POST["Viti"];
			$temp = trim(preg_replace('/\s\s+/', ' ', $temp));
			if(substr_count($temp, ',')!=0) 
			{
				$temp=str_replace(" , ", ",", $temp);	
				$temp=str_replace(", ", ",", $temp);	
				$temp=str_replace(" ,", ",", $temp);	
				$temp=str_replace(",", " ", $temp);
			}
			$temp_array=explode(" ", $temp);
			$search_string="";
			$search_string=$search_string."+(";
			for($i=0; $i<count($temp_array); $i++)
			{
				if($temp_array[$i]==date("Y")) $search_string=$search_string.$temp_array[$i]." 3000 ";
				else $search_string=$search_string.$temp_array[$i]." ";
			} 
			$search_string=$search_string.")";
			$Viti_search_string=$search_string; 	
			$counter++;
		}
		else $Viti_search_string="";
		
		if(isset($_POST["Aktoret"]) && !empty($_POST["Aktoret"])) {
			$temp=$_POST["Aktoret"];
			$temp = trim(preg_replace('/\s\s+/', ' ', $temp));
			if(substr_count($temp, ',')!=0) 
			{
				$temp=str_replace(" , ", ",", $temp);	
				$temp=str_replace(", ", ",", $temp);	
				$temp=str_replace(" ,", ",", $temp);	
				$temp=str_replace(",", " ", $temp);
			}
			$temp_array=explode(" ", $temp);
			$search_string="";
			for($i=0; $i<count($temp_array); $i++)
			{
				//if($temp_array[$i]==date("Y")) $search_string=$search_string."+(".$temp_array[$i]." 3000) ";
				if(strlen($temp_array[$i])<4) {$search_string=$search_string."+".$temp_array[$i]." ";}
				else $search_string=$search_string."+".$temp_array[$i]."* ";
			} 
			$Aktoret_search_string=$search_string; 
			$counter++;
		}
		else $Aktoret_search_string="";
		
		if(isset($_POST["Zhanri"]) && !empty($_POST["Zhanri"])) { 
			$temp=$_POST["Zhanri"];
			$temp = trim(preg_replace('/\s\s+/', ' ', $temp));
			if(substr_count($temp, ',')!=0) 
			{
				$temp=str_replace(" , ", ",", $temp);	
				$temp=str_replace(", ", ",", $temp);	
				$temp=str_replace(" ,", ",", $temp);	
				$temp=str_replace(",", " ", $temp);
			}
			$temp_array=explode(" ", $temp);
			$search_string="";
			for($i=0; $i<count($temp_array); $i++)
			{
				//if($temp_array[$i]==date("Y")) $search_string=$search_string."+(".$temp_array[$i]." 3000) ";
				if(strlen($temp_array[$i])<4) {$search_string=$search_string."+".$temp_array[$i]." ";}
				else $search_string=$search_string."+".$temp_array[$i]."* ";
			} 
			$Zhanri_search_string=$search_string;
			$counter++;
		}
		else $Zhanri_search_string="";
		
		if($counter==0) {return("Ti nuk ke futur asnje te dhene per kerkimin. Fut te pakten nje te dhene dhe provoje perseri.");}
		
		$query=$query."SELECT * FROM `$Kategoria` WHERE";
		
		//Krijimi i Querrise
		if($Titulli_search_string!="")
		{
			if($Kategoria=="filma_shqiptar")
			{$query=$query." (MATCH(`Indeksi_per_Kerkim`) AGAINST('$Titulli_search_string' IN BOOLEAN MODE)) AND";}
			else {$query=$query." (MATCH(`Indeksi_per_Kerkim`, `Tituj_te_Tjere`) AGAINST('$Titulli_search_string' IN BOOLEAN MODE)) AND";}
		}
		
		if($Kategoria!="filma_te_dubluar_ne_shqip")
		{
			if($Regjia_search_string!="")
			$query=$query." (MATCH(`Regjia`) AGAINST('$Regjia_search_string' IN BOOLEAN MODE)) AND";
		}
		else 
		{
			if($Studio_search_string!="")
			$query=$query." (MATCH(`Studio`) AGAINST('$Studio_search_string' IN BOOLEAN MODE)) AND";
		}
		
		if($Viti_search_string!="")
		$query=$query." (MATCH(`Viti`) AGAINST('$Viti_search_string' IN BOOLEAN MODE)) AND";
		
		if($Aktoret_search_string!="")
		$query=$query." (MATCH(`Aktoret`) AGAINST('$Aktoret_search_string' IN BOOLEAN MODE)) AND";
		
		if($Zhanri_search_string!="")
		$query=$query." (MATCH(`Nenkategorite`, `Orig`) AGAINST('$Zhanri_search_string' IN BOOLEAN MODE)) AND";
		
		//Mbyllja e Querise
		$query=$query." 1"; //AND 1 per ta mbyllur
		$query=$query." ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC;
		if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
		$result=mysqli_query($VID_MOVIES, $query); 	
	}
	
	//-------------------------------Kerkimi sipas nenkategorive------------------------------//
	else if($_POST["Req_Type"]=="subcategories_filter") //Subcategories filter Request
	{
		$i=0; 
		
		if(isset($_POST["subcategories"]) OR isset($_POST["origs"]))
		{
			if(isset($_POST["subcategories"]))
			{
				$checkboxes_array=$_POST["subcategories"];
				$query=$query."SELECT * FROM `$Kategoria` WHERE (`Nenkategorite` ";
				for($i=0; $i<count($checkboxes_array); $i++)
				{
					$query=$query."LIKE '%".$checkboxes_array[$i]."%' "; 
					if($i<count($checkboxes_array)-1)  $query=$query." AND `Nenkategorite` ";
				}
				
				$query=$query.")";
			}
			//Checking for the specific Origs
			if(isset($_POST["origs"])) 
			{
				$origs_array=$_POST["origs"];
				if(isset($_POST["subcategories"])){for($i=0; $i<count($origs_array); $i++){$query=$query." AND `Orig`='$origs_array[$i]' ";}}
				else {
					$query="SELECT * FROM `$Kategoria` WHERE "; 
					for($i=0; $i<count($origs_array); $i++) {
					if($i==0)$query=$query." `Orig`='$origs_array[$i]' ";
					else $query=$query." AND `Orig`='$origs_array[$i]' ";
					}
				}
			
			}
			
			$query=$query." ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC;
			if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
			$result=mysqli_query($VID_MOVIES, $query); 
		}
		else {return("Ti nuk ke perzgjedhur asnje nenkategori. Perzgjidh te pakten nje nenkategori dhe provoje perseri.");}
	}
}

//Nje kerkese normale pa asnje flamur. (Per kete mjafton te jete percaktuar vetem Kategoria dhe dritarja.
else 
{
	$query="SELECT * FROM `$Kategoria` ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC; 
	if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
	$result=mysqli_query($VID_MOVIES, $query);
}	

//Llogaritja e numrit total te dritareve dhe nxjerrja e tij per t'u marre nga funksioni perditesues ne javascript.
if(mysqli_num_rows($result)%$Window_Size!=0) $num_windows=intval(mysqli_num_rows($result)/$Window_Size+1);
else $num_windows=intval(mysqli_num_rows($result)/$Window_Size);


//Echo per TEstim **************************************************************************
//echo "<li>$query</li>";

//Printimi i Elementeve te Dritares se Kerkuar
$i=0;
while($row=mysqli_fetch_assoc($result))
{	
	if($i>=(($Window-1)*$Window_Size) AND $i<=($Window*$Window_Size-1))
	{
		echo '<li>';
		echo '<a href="/premium/members/filma_shqip/skeda/'.$Kategoria.'/'.$row["Indeksi"].'" target="_blank">';
		echo '<img src="/filma_shqip/foto/thumbs/'.$row["Indeksi"].'.jpg" alt="">
		<p><i>'.StringParser($row["Indeksi"].'</i>',false).' ('.$row["Viti"].')';
		if($Kategoria=="filma_me_titra_shqip" OR $Kategoria=="filma_per_femije") echo '<span><u>Zhanri:</u> <i>'.$row["Orig"].', '.$row["Nenkategorite"].'</i></span>';
		else echo '<span><u>Zhanri:</u> <i>'.$row["Nenkategorite"].'</i></span>';	
		echo '<span><u>Shtuar me:</u> <i>'.date_format(date_create($row["Data_Shtimit"]), "d/m/Y");
		echo '</i></span></p></a></li>';
		$i++;
	}
	else {$i++; continue;} 
}

?>