<?php 
	session_start();
	$Page_Id="shto_film";
			
	include("../uni/db_connect.php");
	//nese nuk eshte bere login perjashtoje
	if(!isset($_SESSION["username"]) && !isset($_SESSION["password"]))
	{
		header("Location: index.php");
	}
	$Prefix='../';
	
	function Generate_Form($movies_table)
	{
		global $VID_MOVIES;
		echo '<form action="scripts/shto_film_script.php" method="POST">	<fieldset> <legend>Te dhenat:</legend> ';
		$form_query="SHOW COLUMNS FROM `$movies_table`";
		$form_result=mysqli_query($VID_MOVIES, $form_query);
		$form_i=0;

		echo '<input type="hidden" name="table" value="'.$movies_table.'">';
		while($form_row=mysqli_fetch_array($form_result))
		{
			if($form_row[0]=="ID") echo '<input type="hidden" name="ID" value="">';
			else if($form_row[0]=="Data_Shtimit") {echo "<label>$form_row[0]</label><textarea name='$form_row[0]'>"; echo date("Y-m-d"); echo "</textarea>";}
			else if($form_row[0]=="Host") {echo "<label>$form_row[0]</label><textarea name='$form_row[0]'>http://videoteka-ime.com/video/</textarea>";}
			else echo "<label>$form_row[0]</label><textarea name='$form_row[0]'></textarea>";
		}
		
		echo '</fieldset><input type="Submit" value="Submit"></form>';
	}
?>
		
<!DOCTYPE HTML>

<html>

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Shto Film te Ri</title>
		<link type="text/css" rel="stylesheet" href="style.css"/>
	</head>
		
	<body>
		<div id="wrapper">
			<ul id="sidenav">
				<li><span>Shto video te reja</span>
					<ul>
						<li><a href="shto_film.php" class="current">Shto Filma</a></li>
						<li><a href="shto_serial.php">Shto Episode</a></li>
					</ul>
				</li>
				<li><span>Shiko statistikat e shikimeve</span>
					<ul>
						<li><a href="filma_stats.php">Statistikat e Filmave</a></li>
						<li><a href="seriale_stats.php">Statistikat e Serialeve</a></li>
					</ul>
				</li>
						
			</ul>
		<div id="shto_film">
			<h1>Shto Filma te rinj</h1>
						
			<form>
				<fieldset>
					<legend>Kategoria</legend>
					<select name="movies_category" onchange = "showForm()" id="seloptions">
					<?php						
						$query="SHOW TABLES";
	           				$result=mysqli_query($VID_MOVIES, $query);
	           				$i=0;
	           				while ($row=mysqli_fetch_array($result)) 
	           				{
						        echo "<option value='$i'>$row[0]</option>";
						        $i++;
			    			}
					?>
					</select>
				</fieldset>
			</form>
			
			<div id="formularet">
			<?php						
				$query="SHOW TABLES";
   				$result=mysqli_query($VID_MOVIES, $query);
   				$i=0;
   				while ($row=mysqli_fetch_array($result)) 
   				{
   					 Generate_Form($row[0]);
	    			}
			?>
						
			</div>
							
							
			</div><!--Mbaron divizioni i shtimit -->
					
		</div><!--Mbaron divizioni i wrapperit -->
			
		<script type = "text/javascript">
		function showForm()
		{
			var i=document.getElementById("seloptions").getElementsByTagName("option").length;
			var selopt = document.getElementById("seloptions").value;
			var temp=document.getElementById("formularet").getElementsByTagName("form");
			for(j=0; j<i; j++)
			{
				if (selopt == j) {temp[j].style.display="block";}
				else {temp[j].style.display="none"}
			}
		}
		
		showForm();
		</script>
	</body>	
</html>