<?php

//Percaktimi i Variablave $Sort_Col dhe $Sort_ASC_DESC 
if(isset($Sort)) 
{
	//We do it this way to not show the name of the columns in DB for security reasons
	if ($Sort=="default") {$Sort_Col="Rendi"; $Sort_ASC_DESC="DESC"; }
	else if($Sort=="def") {$Sort_Col="Rendi"; $Sort_ASC_DESC="DESC"; }
	else if($Sort=="a_z") {$Sort_Col="Indeksi"; $Sort_ASC_DESC="ASC"; }
	else if($Sort=="z_a") {$Sort_Col="Indeksi"; $Sort_ASC_DESC="DESC";}
	else if($Sort=="n_o") {$Sort_Col="Viti2"; $Sort_ASC_DESC="DESC"; $Sort_Col2="Indeksi"; $Sort_ASC_DESC2="ASC";} //n_o="New to Old"
	else if($Sort=="o_n") {$Sort_Col="Viti2"; $Sort_ASC_DESC="ASC"; $Sort_Col2="Indeksi"; $Sort_ASC_DESC2="ASC";} //o_n="Old to New"
}
else {$Sort_Col="Rendi"; $Sort_ASC_DESC="DESC";} //Percaktimi i variablave per Sort kur ato nuk jane percaktuar

//Madhesia fikse e Dritares (Sa elemente do te shfaqen per cdo dritare)
$Window_Size=24;
$query=""; 

//Ne varesi te flamujve te ngritur, krijohet querija dhe pastaj vazhdohet ne printimin e rezultateve 
if(isset($_POST["Req_Type"]))
{
	//-----------------------Kerkim i thjeshte-------------------------//
	if($_POST["Req_Type"]=="simple_search") 
	{
		$search_string=""; 
		if(isset($_POST["search_string"]) && !empty($_POST["search_string"])) $search_string=$_POST["search_string"];
		else {return("Ti nuk ke futur asnje te dhene per kerkimin. Fut te pakten nje te dhene dhe provoje perseri.");}
		
		//Fshirja e hapesirave rrotull presjes dhe copetimi i stringut te kerkimit me baze presjen. 
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
			if($search_words_array[$i]==date("Y")) $search_string=$search_string."+(".$search_words_array[$i]." 3000) ";
			else if(strlen($search_words_array[$i])<4) {$search_string=$search_string."+".$search_words_array[$i]." ";}
			else $search_string=$search_string."+".$search_words_array[$i]."* ";
		}
			
		$query=$query."SELECT * FROM `Main` WHERE MATCH(`Indeksi_per_Kerkim`, `Tituj_te_Tjere`, `Nenkategorite`, `Viti1`, `Viti2`, `Regjia`, `Aktoret`) AGAINST('$search_string' IN BOOLEAN MODE)";
		$query=$query." ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC;
		if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
		$result=mysqli_query($VID_SERIES, $query); 
	} 
	
	//-------------------------------Kerkimi i avancuar----------------------------//
	//Pershtatja e stringeve te kerkimit per kerkimin
	else if($_POST["Req_Type"]=="advanced_search") 
	{
		$i=0; 
		$j=0; 
		$counter=0; 
		//------------Marrja e inputeve dhe pastrimi i tyre nga hapesirat boshe rrotull presjes. -------------------//
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
		
		if(isset($_POST["Vitet"]) && !empty($_POST["Vitet"])) {
			$temp=$_POST["Vitet"];
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
			$Vitet_search_string=$search_string; 
			$counter++; 
		}
		else $Vitet_search_string="";
		
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
		
		if($counter==0) {return("Ti nuk ke futur asnje te dhene per kerkimin. Fut te pakten nje te dhene dhe provoje perseri.");};
		
		//Krijimi i Querrise
		
		$query=$query."SELECT * FROM `Main` WHERE";
				
		if($Titulli_search_string!="")
		$query=$query." (MATCH(`Indeksi_per_Kerkim`, `Tituj_te_Tjere`) AGAINST('$Titulli_search_string' IN BOOLEAN MODE)) AND";
		
		if($Regjia_search_string!="")
		$query=$query." (MATCH(`Regjia`) AGAINST('$Regjia_search_string' IN BOOLEAN MODE)) AND";
		
		if($Vitet_search_string!="")
		$query=$query." (MATCH(`Viti1`, `Viti2`) AGAINST('$Vitet_search_string' IN BOOLEAN MODE)) AND";
		
		if($Aktoret_search_string!="")
		$query=$query." (MATCH(`Aktoret`) AGAINST('$Aktoret_search_string' IN BOOLEAN MODE)) AND";
		
		if($Zhanri_search_string!="")
		$query=$query." (MATCH(`Nenkategorite`) AGAINST('$Zhanri_search_string' IN BOOLEAN MODE)) AND";
		
		//Mbyllja e Querise
		$query=$query." 1"; //AND 1 per ta mbyllur
		$query=$query." ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC;
		if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
		$result=mysqli_query($VID_SERIES, $query); 	
	}
		
	//-------------------------------Kerkimi sipas nenkategorive------------------------------//
	else if($_POST["Req_Type"]=="subcategories_filter") 
	{
		$i=0; 
		
		if(isset($_POST["subcategories"])) $checkboxes_array=$_POST["subcategories"];
		else {return("Ti nuk ke perzgjedhur asnje nenkategori. Perzgjidh te pakten nje nenkategori dhe provoje perseri.");}
		
		$query=$query."SELECT * FROM `Main` WHERE `Kategoria`='$Kategoria' AND (`Nenkategorite` ";
		for($i=0; $i<count($checkboxes_array); $i++)
		{
			$query=$query."LIKE '%".$checkboxes_array[$i]."%' "; 
			if($i<count($checkboxes_array)-1)  $query=$query." AND `Nenkategorite` ";
		}
		$query=$query.")";
		$query=$query." ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC;
		if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
		$result=mysqli_query($VID_SERIES, $query); 
	}
}

//Nje kerkese normale pa asnje flamur. (Per kete mjafton te jete percaktuar vetem Kategoria dhe dritarja.
else {
	$query="SELECT * FROM `Main` WHERE `Kategoria`='".$Kategoria."' ORDER BY `".$Sort_Col."` ".$Sort_ASC_DESC; 
	if(isset($Sort_Col2) AND isset($Sort_ASC_DESC2)) $query=$query.", `".$Sort_Col2."` ".$Sort_ASC_DESC2;
	$result=mysqli_query($VID_SERIES, $query);
}

if(empty($result) OR !isset($result)) {return("Gabim papercaktimi");};
	
//Printimi i Elementeve te Dritares se Kerkuar
$i=0; 
$k=0;
$kategorite_jashte=array(); 
$kategorite_jashte[0]="";
$kategorite_jashte_counter=0;

while($row=mysqli_fetch_assoc($result))
{	
	//E vlefshme vetem kur behet search dhe gjenden seriale jashte kategorise
	//Nuk ka nevoje per te pare nese ka flamuj kerkimi apo jo pasi kjo mund te ndodhe vetem nga kerkimet. 
	if($row["Kategoria"]!=$Kategoria) 
	{
		for($j=0; $j<=$kategorite_jashte_counter; $j++)
		{
			if($kategorite_jashte[$j]==$row["Kategoria"]) break; 
			else {$kategorite_jashte[$kategorite_jashte_counter]=$row["Kategoria"]; $kategorite_jashte_counter++; break;}
		}
	}

	else if($i>=(($Window-1)*$Window_Size) AND $i<=($Window*$Window_Size-1))
	{
	    //
	    if($k==12) {
    	    echo '</ul> <div id="videoteka_bn_2">
    	    <script type="text/javascript">
            //Script for flexible changes depending on the screen width
            var bn_2 = document.createElement("script");
            var bn_2_container=document.getElementById("videoteka_bn_2");
            
            bn_2.type = "text/javascript";
            
            if (screen.width < 801)
            {
                bn_2.src = "//p92948.clksite.com/adServe/banners?tid=92948_423119_1";  //300x250 banner
            }
            else
            {
                bn_2.src = "//p92948.clksite.com/adServe/banners?tid=92948_423119_4";  //mobile banner
            }
            
            bn_2_container.appendChild(bn_2);
            </script>
    	    </div> <ul id="lista_seriale_2">';
	    }
	    
		$Last_Episode=intval($row["Episodi_i_fundit"]);		
		echo '<li>';
		echo '<a href="/seriale_shqip/skeda/'.$row["Indeksi"].$row["Dubluar_Titruar"].'" target="_blank">';
		$viti_2_temp=$row["Viti2"];
		if($row["Viti2"]==3000) $viti_2_temp=date("Y");
		echo '<img src="/seriale_shqip/foto/thumbs/'.$row["Indeksi"].'.jpg" alt="">
		<p><i>'.StringParser($row["Indeksi"].'</i>'.$row["Dubluar_Titruar"], true).' ('.$row["Viti1"].'-'.$viti_2_temp.')';	
		echo '<span><u>Zhanri:</u> <i>'.$row["Nenkategorite"].'</i></span>
		<span><u>Statusi/Ep. i fundit:</u><br> <i>'.SeriesStatusEcho($row["Sezonet"], $Last_Episode, $row["Data_Perditesimit"])." / Ep. ".$row["Episodi_i_fundit"];
		echo '</i></span></p></a></li>';
		$i++;
		$k++;   //Counter responsible for the banner_ad in the middle of the list. (that equals to: after 12 items)
	}
	
	else {$i++; continue;} 
}

if($kategorite_jashte_counter>0 && $Window==1)
{
	echo "<script>alert(\"U gjeten edhe seriale te tjera ne kategorite e meposhtme: \\n ";
	for($i=0; $i<$kategorite_jashte_counter; $i++) {if($i!=$kategorite_jashte_counter-1) echo "'$kategorite_jashte[$i]', "; else echo "'$kategorite_jashte[$i]'"; }
	echo "\");</script>"; 
}

//Llogaritja e numrit total te dritareve dhe nxjerrja e tij 
if((mysqli_num_rows($result)-$kategorite_jashte_counter)%$Window_Size!=0) $num_windows=intval((mysqli_num_rows($result)-$kategorite_jashte_counter)/$Window_Size)+1;
else $num_windows=intval((mysqli_num_rows($result)-$kategorite_jashte_counter)/$Window_Size);


?>