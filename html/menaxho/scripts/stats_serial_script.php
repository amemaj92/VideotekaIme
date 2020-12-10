<?php
 
		session_start();
		$tier=2; 
		$Page_Id="seriale_stats_script";
		$main_category="none";
		$category="none";
		
		function homeFromTier($tier)
		{
			$string="";
			while($tier>0)
			{
				$tier--; 
				$string=$string."../";
			}
			return $string;
		}
				
		$Addendum=homeFromTier($tier);
		
		include($Addendum."universal/connect.php");
		//nese nuk eshte bere login perjashtoje
		if(!isset($_SESSION["username"]) && !isset($_SESSION["password"]))
		{
				header("Location: $Addendum");
		}
		
		
		if(isset($_GET["kategoria_serialeve"])) $kategoria=$_GET["kategoria_serialeve"];
		
		$query="SHOW COLUMNS FROM serialet_statistikat"; 
		$result=mysqli_query($serialet_db, $query);
		$i=1; 
		$indeksi=0; 
		$all_column_names=array(); 
		while($row=mysqli_fetch_assoc($result)) 
		{
				if($row["Field"]=="Kategoria" OR $row["Field"]=="Seriali" OR $row["Field"]=="ID") continue; 
				if($i>mysqli_num_fields($result)-90)
				{
						$all_column_names[$indeksi]=$row["Field"];
						$indeksi++; 
				}
				$i++; 
		}												

		echo"<h2>Statistikat ditore</h2><table><tr><th>Seriali</th>";
		for($i=count($all_column_names)-15; $i<count($all_column_names);  $i++)
		{
			if($i<0) continue; 
			$day_column_names[]=$all_column_names[$i];
			echo "<th>$all_column_names[$i]</th>"; 
		 }
		 echo "</tr>";												
		 $query="SELECT * FROM serialet_statistikat WHERE Kategoria='$kategoria'"; 
		 $result=mysqli_query($serialet_db, $query); 
		 while($row=mysqli_fetch_assoc($result))
		 {
			 		echo "<tr>";
			 		$query_2="SELECT * FROM serialet WHERE Celesi='$row[Seriali]'"; 
					$result_2=mysqli_query($serialet_db, $query_2);
					$row_2=mysqli_fetch_assoc($result_2);
					$titulli=$row_2["Titulli"];
			 		echo "<td>$titulli</td>";
			 		
			 		foreach($day_column_names as $col_name) 
			 		{
				 			$temp=$row[$col_name];
				 			if(!$temp) $temp=0; 
				 			echo "<td>$temp</td>";
			 		}
			 		echo "</tr>";
		 }
		 
		 echo "</table>";
		 
		 echo "<h2>Statistikat javore</h2><table><tr><th>Seriali</th>";
		$week_column_names=array();
		for($i=count($all_column_names)-84; $i<count($all_column_names);  $i++)
		{
				if($i<0) continue; 
				$week_column_names[]=$all_column_names[$i];
				$treguesi_javor=1;
				$indeksi_javes=12;
				if($treguesi_javor<7)	//Mbledhja e te dhenave javore
	 			{
		 			$treguesi_javor++;
 				}		
 				else //I Barabarte me 7	//Reseto Javen
 				{
	 					echo "<th>Java $indeksi_javes</th>";	
	 					$treguesi_javor=1; 
	 					$indeksi_javes--;
 				}
		 }
		 if($treguesi_javor<7 AND $treguesi_javor!=1)	//Rasti kur ka me pak se nje jave
 		{
	 			echo "<th>Java 1</th>";	
		}
		 echo "</tr>";
			
		//Shkrimi i statistikave per cdo jave.		
		 $query="SELECT * FROM serialet_statistikat WHERE Kategoria='$kategoria'"; 
		 $result=mysqli_query($serialet_db, $query); 
		 while($row=mysqli_fetch_assoc($result))
		 {
			 		echo "<tr>";			 		
			 		$query_2="SELECT * FROM serialet WHERE Celesi='$row[Seriali]'"; 
					$result_2=mysqli_query($serialet_db, $query_2);
					$row_2=mysqli_fetch_assoc($result_2);
					$titulli=$row_2["Titulli"];
			 		echo "<th>$titulli</th>";
			 		
			 		$treguesi_javor=1;
			 		$temp_java=0; 
			 		$temp=0; 
			 		foreach($week_column_names as $col_name) 
			 		{
				 			if($treguesi_javor<7)	//Mbledhja e te dhenave javore
				 			{
					 				$temp=$row[$col_name];
					 				if(!$temp) $temp=0; 
					 				$temp_java+=$temp; 
					 				$treguesi_javor++;
			 				}		
			 				else //I Barabarte me 7	//Reseto Javen
			 				{
				 					echo "<td>$temp_java</td>";
				 					$temp_java=0; 	
				 					$treguesi_javor=1; 
			 				}
		 			}
		 			
		 	if($treguesi_javor<7 AND $treguesi_javor!=1)	//Rasti kur ka me pak se nje jave
	 		{
		 			echo "<td>$temp_java</td>";	
 			}	
		 																 			
			 }
			 echo "</tr></table>"; 
			 
			 echo "<h2>Statistikat Mujore</h2><table><tr><th>Seriali</th>";
			$month_column_names=array();
			for($i=count($all_column_names)-90; $i<count($all_column_names);  $i++)
			{
					if($i<0) continue; 
					$month_column_names[]=$all_column_names[$i];
					$treguesi_mujor=1;
					$indeksi_mujor=3;
					if($treguesi_mujor<30)	//Mbledhja e te dhenave javore
		 			{
			 			$treguesi_mujor++;
	 				}		
	 				else //I Barabarte me 30	//Reseto Muajin
	 				{
		 					echo "<th>Muaji $indeksi_mujor</th>";	
		 					$treguesi_mujor=1; 
		 					$indeksi_mujor--;
	 				}
			 }
			 if($treguesi_javor<30 AND $treguesi_javor!=1)	//Rasti kur ka me pak se nje muaj
	 		{
		 			echo "<th>Muaji 1</th>";	
			}
			echo "</tr>";								 			
 			//Shkrimi i statistikave per cdo muaj.		
		 	$query="SELECT * FROM serialet_statistikat WHERE Kategoria='$kategoria'"; 
			 $result=mysqli_query($serialet_db, $query); 
			 while($row=mysqli_fetch_assoc($result))
			 {
				 	echo "<tr>";
				 	$query_2="SELECT * FROM serialet WHERE Celesi='$row[Seriali]'"; 
					$result_2=mysqli_query($serialet_db, $query_2);
					$row_2=mysqli_fetch_assoc($result_2);
					$titulli=$row_2["Titulli"];
			 		echo "<th>$titulli</th>";
				 	
		 			$treguesi_mujor=1;
			 		$temp_mujor=0; 
			 		$temp=0; 
			 		foreach($month_column_names as $col_name) 
			 		{
				 			if($treguesi_mujor<30)	//Mbledhja e te dhenave mujore
				 			{
					 				$temp=$row[$col_name];
					 				if(!$temp) $temp=0; 
					 				$temp_mujor+=$temp; 
					 				$treguesi_mujor++;
			 				}		
			 				else //I Barabarte me 30	//Reseto Muajin
			 				{
				 					echo "<td>$temp_mujor</td>";
				 					$temp_mujor=0; 	
				 					$treguesi_mujor=1; 
			 				}
		 			}
		 			
		 	if($treguesi_mujor<30 AND $treguesi_mujor!=1)	//Rasti kur ka me pak se nje muaj
	 		{
		 			echo "<td>$temp_mujor</td>";	
 			}	
	}
	echo "</tr></table>";