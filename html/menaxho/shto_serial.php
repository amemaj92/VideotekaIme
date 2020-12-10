<?php 
	session_start();
	$Page_Id="shto_series";
			
	include("../uni/db_connect.php");
	//nese nuk eshte bere login perjashtoje
	if(!isset($_SESSION["username"]) && !isset($_SESSION["password"]))
	{
		header("Location: index.php");
	}
	$Prefix='../';
	
	$indeksi_fillestar="";
	
	function GenerateSelections($Kategoria)
	{
		global $VID_SERIES;
		global $indeksi_fillestar;
		$query="SELECT * FROM `Main` WHERE `Kategoria`='$Kategoria' ORDER BY `Indeksi` ASC";
		$result=mysqli_query($VID_SERIES, $query);
		$i=0;
		echo '<select name="serialet_sel" id="$Kategoria" onchange="UpdateSerialiIndeks(event)" >';
		while ($row=mysqli_fetch_assoc($result)) 
		{
			if($Kategoria=="seriale_turke" AND $i==0) $indeksi_fillestar=$row["Indeksi"];
			$data_perditesimit=$row["Data_Perditesimit"];
			$sezonet=$row["Sezonet"];
			$last_episode=intval($row["Episodi_i_fundit"]);
			if(SeriesStatusEcho($sezonet, $last_episode, $data_perditesimit)!="I Perfunduar") echo "<option value='$row[Indeksi]'>$row[Indeksi]</option>";
			else {continue; $i++;}
			$i++;
		}
		echo '</select>';
	}
	
?>
		
<!DOCTYPE HTML>

<html>

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Shto Episod te Ri</title>
		<link type="text/css" rel="stylesheet" href="style.css"/>
	</head>
		
	<body>
		<div id="wrapper">
			<ul id="sidenav">
				<li><span>Shto video te reja</span>
					<ul>
						<li><a href="shto_film.php" >Shto Filma</a></li>
						<li><a href="shto_serial.php" class="current">Shto Episode</a></li>
					</ul>
				</li>
				<li><span>Shiko statistikat e shikimeve</span>
					<ul>
						<li><a href="filma_stats.php">Statistikat e Filmave</a></li>
						<li><a href="seriale_stats.php">Statistikat e Serialeve</a></li>
					</ul>
				</li>
						
			</ul>
		<div id="shto_episod">
			<h1>Shto Episode te reja</h1>
						
			<form>
				<fieldset>
					<legend>Kategoria</legend>
					<select name="series_category" onchange = "showSelects()" id="seloptions_1">
					
					<?php						
						$query="SELECT DISTINCT `Kategoria` FROM `Main`";
	           				$result=mysqli_query($VID_SERIES, $query);
	           				$i=0;
	           				while ($row=mysqli_fetch_array($result)) 
	           				{
						        echo "<option value='$i'>$row[0]</option>";
						        $i++;
			    			}
			    		?>
					</select>
				</fieldset>
				
				<fieldset>
				<?php
					$query="SELECT DISTINCT `Kategoria` FROM `Main`";
	   				$result=mysqli_query($VID_SERIES, $query);
	   				$i=0;
	   				while ($row=mysqli_fetch_array($result)) 
	   				{
		   				 GenerateSelections($row[0]);
		    			}
		    		?>
	    			</fieldset>	
				
			</form>
			
			<script> var Indekset=new Object();
	    		<?php
	    			$query="SELECT * FROM `Main`";
   				$result=mysqli_query($VID_SERIES, $query);
   				$i=0;
   				while ($row=mysqli_fetch_array($result)) 
   				{
				        if($row["Indeksi"]=="Trimi_(Xhesuri)_dhe_e_Bukura") echo "Indekset.Trimi_dhe_e_Bukura=\"".$row["Episodi_i_fundit"]."\"; \n";
				        else if($row["Indeksi"]=="1992") echo "Indekset.s1992=\"".$row["Episodi_i_fundit"]."\"; \n";
				        else echo "Indekset.".$row["Indeksi"]."=\"".$row["Episodi_i_fundit"]."\"; \n";
				        
				        $i++;
	    			}
			?>
			</script>
			
			<div id="formulari">
			<?php
			
			echo '<form action="scripts/shto_episod_script.php" method="POST">	<fieldset> <legend>Episodi i Fundit: <span id="mbajtesi_episodit"></span></legend> ';
			$form_query="SHOW COLUMNS FROM `Diamante_dhe_Dashuri`";
			$form_result=mysqli_query($VID_SERIES, $form_query);
			$form_i=0;
	
			echo '<input type="text" name="seriali" value="'.$indeksi_fillestar.'" id="indeksi_i_serialit">';
			while($form_row=mysqli_fetch_array($form_result))
			{
				if($form_row[0]=="ID") echo '<input type="hidden" name="ID" value="">';
				else echo "<label>$form_row[0]</label><textarea name='$form_row[0]'></textarea>";
			}			
			echo '</fieldset><input type="Submit" value="Submit"></form>';
			
			?>
						
			</div>							
							
			</div><!--Mbaron divizioni i shtimit -->
					
		</div><!--Mbaron divizioni i wrapperit -->
			
		<script type = "text/javascript">

		function showSelects()
		{
			var temp=document.getElementById("shto_episod").getElementsByTagName("form")[0].getElementsByTagName("fieldset")[1].getElementsByTagName("select");
			var i=temp.length;
			var selopt = document.getElementById("seloptions_1").value;
			var mbajtesi=document.getElementById("indeksi_i_serialit");
			for(j=0; j<i; j++)
			{
				if (selopt == j) {temp[j].style.display="block"; mbajtesi.value=temp[j].value;}
				else {temp[j].style.display="none"}
			}
		}
		
		function UpdateSerialiIndeks(event)
		{
			var mbajtesi=document.getElementById("indeksi_i_serialit");
			mbajtesi.value=event.target.value;
			var property=event.target.value;
			var episod_i_fundit=document.getElementById("mbajtesi_episodit");
			episod_i_fundit.innerHTML=Indekset[property];
		}
		
		showSelects();
		</script>
	</body>	
</html>