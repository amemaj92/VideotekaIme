<?php 
		
		ini_set("session.save_path", "/home/videotekaime2/session_storage"); 
		session_start();
		$tier=1; 
		$Page_Id="filma_stats";
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
		?>
		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			
		<title>Statistikat e filmave</title>
		
		
		<link type="text/css" rel="stylesheet" href="style.css"/>
		<script type="text/javascript" src=<?php echo "'$Addendum"."universal/Core.js'";?>></script>
		<script type="text/javascript" src="stats_select.js"></script>
		</head>
		
		<body>
				<div id="wrapper">
						<ul id="sidenav">
								<li>
										<span>Shto video te reja</span>
												<ul>
														<li><a href="shto_film.php">Shto Filma</a></li>
														<li><a href="shto_serial.php">Shto Seriale</a></li>
												</ul>
								</li>
								<li>
										<span>Kontrollo videot e raportuara</span>
												<ul>
														<li><a href="check_film.php">Kontrollo Filmat</a></li>
														<li><a href="check_serial.php">Kontrollo Serialet</a></li>
												</ul>
								</li>
								<li>
										<span>Shiko statistikat e shikimeve</span>
												<ul>
														<li><a href="filma_stats.php"  class="current">Statistikat e Filmave</a></li>
														<li><a href="seriale_stats.php">Statistikat e Serialeve</a></li>
												</ul>
								</li>
								
						</ul>
						<div id="stats_filma">
								<h1>Statistikat e filmave sipas kategorive</h1>
									<?php
												$query="SHOW COLUMNS FROM filmat_statistikat"; 
												$result=mysqli_query($filmat_db, $query);
												$i=1; 
												$indeksi=0; 
												$all_column_names=array(); 
												while($row=mysqli_fetch_assoc($result)) 
												{
														if($row["Field"]=="Kategoria" OR $row["Field"]=="ID") continue; 
														if($i>mysqli_num_fields($result)-90)
														{
																$all_column_names[$indeksi]=$row["Field"];
																$indeksi++; 
														}
														$i++; 
												}												
										?>	
								<h2>Statistikat ditore</h2>		
								<table>
										<tr>
												<th>Kategoria</th>
												<?php 
														for($i=count($all_column_names)-15; $i<count($all_column_names);  $i++)
														{
															if($i<0) continue; 
															$day_column_names[]=$all_column_names[$i];
															echo "<th>$all_column_names[$i]</th>"; 
														 }
														 echo "</tr>";												
														 $query="SELECT * FROM filmat_statistikat"; 
														 $result=mysqli_query($filmat_db, $query); 
														 while($row=mysqli_fetch_assoc($result))
														 {
															 		echo "<tr>";
															 		echo "<td>$row[Kategoria]</td>";
															 		foreach($day_column_names as $col_name) 
															 		{
																 			$temp=$row[$col_name];
																 			if(!$temp) $temp=0; 
																 			echo "<td>$temp</td>";
															 		}
															 		echo "</tr>";
														 }
												?>
								</table>
																
								<h2>Statistikat javore</h2>		
								<table>
										<tr>
												<th>Kategoria</th>
												<?php 
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
														 $query="SELECT * FROM filmat_statistikat"; 
														 $result=mysqli_query($filmat_db, $query); 
														 while($row=mysqli_fetch_assoc($result))
														 {
															 		echo "<tr>";
															 		echo "<td>$row[Kategoria]</td>";
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
															 		echo "</tr>";
													?>
										</tr>
								</table>
								
								<h2>Statistikat Mujore</h2>		
								<table>
										<tr>
												<th>Kategoria</th>
												<?php 
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
														 $query="SELECT * FROM filmat_statistikat"; 
														 $result=mysqli_query($filmat_db, $query); 
														 while($row=mysqli_fetch_assoc($result))
														 {
															 		echo "<tr>";
															 		echo "<td>$row[Kategoria]</td>";
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
															 		echo "</tr>";
													?>
										</tr>
								</table>
																							
				</div><!--Mbaron divizioni i statistikave -->
						
			</div><!--Mbaron divizioni i wrapperit -->
			
			<script>
			var sidenav=document.getElementById("sidenav");
			var form_div=document.getElementsByTagName("div")[1];
			if(form_div.clientHeight<sidenav.clientHeight) form_div.style.height= sidenav.clientHeight+"px"; 
			else sidenav.style.height=form_div.clientHeight+"px"; 
			</script>
		
		</body>
		
</html>