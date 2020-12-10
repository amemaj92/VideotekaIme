<?php

include_once("../../uni/db_connect.php");
//Declaring Varibales
$user_agent=$_SERVER['HTTP_USER_AGENT'];
$OS_Platform=GetOS();
$IsMobile=IsMobile();

$Window_Size=20;
if(isset($_GET["Indeksi"]))
{
	$Indeksi=$_GET["Indeksi"]; 
	$Titulli= StringParser($Indeksi, 1);
	$outer_query="SELECT * FROM `Main_Premium` WHERE `Indeksi`='$Indeksi'";
	$outer_row=mysqli_fetch_assoc(mysqli_query($VID_SERIES, $outer_query));
	$LastSeasonEpisodeArray=LastSeasonEpisodeArray($outer_row["Sezonet"]);
	//--Kerkim Normal nga Bottom Navi i Dritares $Window
	if(isset($_GET["Window"]))
	{
		$Window=$_GET["Window"]; 
		$query="SELECT * FROM `$Indeksi` ORDER BY Episodi DESC";
		$result=mysqli_query($VID_SERIES, $query);
		$row=mysqli_fetch_assoc($result);
		if(isset($row["Pjesa"])) $query=$query.",Pjesa DESC"; 
		$result=mysqli_query($VID_SERIES, $query);
		//*------------Percaktimi i dritareve maksimale: 
		if(mysqli_num_rows($result)%$Window_Size!=0) $num_windows=(int)(mysqli_num_rows($result)/$Window_Size+1);
		else $num_windows=(int)(mysqli_num_rows($result)/$Window_Size);
		echo "$num_windows ";
		
		//*------------Printimi i listes se episodeve
		$i=0;
		while($row=mysqli_fetch_assoc($result))
		{	
			if($i==0) 	//Behet vetem per iteracionin e pare. 
			{
			    $Sezoni=0;
			    $j=count($LastSeasonEpisodeArray)-1; //Last Season Episode Array mban episodet e fundit te cdo Sezoni.
			    while($j>=0)
			    {
			        if($row["Episodi"]==$LastSeasonEpisodeArray[$j]) {$Sezoni=$j; break;}	//Inicializojme variablin Sezoni me te fundit nese Episodi i fundit eshte i barabarte me Episodin e fundit te sezonit te fundit, pra nese seriali eshte i perfunduar. 
			        else if($row["Episodi"]>$LastSeasonEpisodeArray[$j]) {$Sezoni=$j+1; break;}	//Perndryshe e ulim sezonin derisa episodi te jete nje mbi vleren e Sezonit, pastaj variablin $Sezoni e inicializojme me Sezonin e episodit te fundit, qe eshte  $j+1 
			        $j--;
			        //Kjo procedure siguron qe nese episodi eshte me i vogel se Episodi i Sezonit te fundit (pra seriali eshte ne vazhdim, ose aktiv), s$Seriali te marre vleren e duhur kur te arrihet pika qe episodi eshte me i madh ose i barabarte me episodin e fundit te nje nga Sezoneve te meparshme 			    		
			   }
		   	}
			//E zbresim vleren fillestare te Sezonit kur Episodi i radhes arrin vleren e Episodit te fundit te nje sezoni me poshte.
			if(($Sezoni>0) AND ($row["Episodi"]==($LastSeasonEpisodeArray[$Sezoni-1]))) $Sezoni--;
			
			if($i>=(($Window-1)*$Window_Size) AND $i<=($Window*$Window_Size-1))  // Is Inside Window
			{	        
			    echo '<li itemscope itemtype="http://schema.org/Episode">'; 
			    echo '<a itemprop="url" ';
			    if($row["Episodi"]<=$LastSeasonEpisodeArray[$Sezoni]) echo 'class="sezoni'.($Sezoni+1).'" ';
			    $LinkHref="/premium/members/stream/stream.php?SoF=S&Kategoria=$outer_row[Kategoria]&Indeksi=$Indeksi&Episodi=$row[Episodi]"; 
			    if(isset($row["Pjesa"])) $LinkHref=$LinkHref."&Pjesa=$row[Pjesa]";
			    $LinkHref=$LinkHref;
			    echo 'href="'.$LinkHref.'" target="blank"><span></span>'.$Titulli.' Episodi '.$row["Episodi"];		
			   if(isset($row["Pjesa"])) echo '-'.$row["Pjesa"]; 
			   echo '</a>';				
			   echo '</li>
			   ';
			}
			$i++;
		}
	}
	//--Kerkim i nje episodi Specifik prej formularit perkates
	else if(isset($_GET["Episodi"]))
	{
		$Episodi=$_GET["Episodi"]; 
		$query="SELECT * FROM `$Indeksi` WHERE `Episodi`='".$Episodi."'";
		$result=mysqli_query($VID_SERIES, $query);
		//Echo 0 max windows: 
		echo "0 "; 
		if(mysqli_num_rows($result)>0) 
		{
			while($row=mysqli_fetch_assoc($result))
			{		        
				echo '<li itemscope itemtype="http://schema.org/Episode">'; 
				echo '<a itemprop="url" ';
				$LinkHref="/premium/members/stream/stream.php?SoF=S&Kategoria=$outer_row[Kategoria]&Indeksi=$Indeksi&Episodi=$row[Episodi]"; 
			   	if(isset($row["Pjesa"])) $LinkHref=$LinkHref."&Pjesa=$row[Pjesa]";
			   	$LinkHref=$LinkHref;
				echo 'href="'.$LinkHref.'" target="blank"><span></span>'.$Titulli.' Episodi '.$row["Episodi"];		
			   	if(isset($row["Pjesa"])) echo '-'.$row["Pjesa"]; 
				echo '</a>';				
				echo '</li>
				   ';
			}
		}
		else {echo '0 <li>Nuk u gjend asnje episod me kete numer. Provo me nje numer tjeter.</li>';} 
	}
	else {exit("-1 GABIM NE TE DHENA");}
}
else {exit("-1 GABIM: NUK ESHTE PERCAKTUAR ASNJE SERIAL");}
?>