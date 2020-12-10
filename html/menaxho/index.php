<?php 	
	session_start();
	$Page_Id="menaxho";
	
	include("../uni/db_connect.php");
	//kontrolli nese eshte bere submit formulari i logimit.
	if(!isset($_SESSION["username"]) AND !isset($_SESSION["password"]))
	{
		if(isset($_GET["usr"]) AND isset($_GET["pass"]))
		{
			$usr=$_GET["usr"];
			$pass=$_GET["pass"];
			
			//Kontrollo nese useri ka dhene te dhenat sakte. 
			if($usr=="endri&keta" && md5($pass."endri&keta")=="e1bd97f8f15a61858194f49a7894b8d4")
			{
					$_SESSION["username"]=$usr;
					$_SESSION["password"]=md5($pass."endri&keta");
					echo "<p>Te dhenat jane te sakta! Mirese erdhe Admin!</p>";
					echo "<script type='text/javascript'>window.location.href='shto_film.php'</script>";
			}
			else echo "<p>Te dhenat jane gabim!</p>";
		}
	}
	else 
	{
		if($_SESSION["username"]=="endri&keta" && $_SESSION["password"]=="e1bd97f8f15a61858194f49a7894b8d4")
		{
			echo "<p>Te dhenat jane te sakta! Mirese erdhe Admin!</p>";
			echo "<script type='text/javascript'>window.location.href='shto_film.php'</script>";
		}
		else echo "<p>Te dhenat jane gabim!</p>";
		
	}
?>

<!DOCTYPE HTML>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Menaxho faqen</title>
	</head>
	<body>
		<div id="wrapper">
			<form method="GET" action="index.php">
				<fieldset>
					<legend>Username</legend>
					<input name="usr" type="textarea" value="">
				</fieldset>
				<fieldset>
					<legend>Password</legend>
					<input name="pass" type="password" value="">
				</fieldset>
				<input type="Submit" value="Log In">
			</form>
		</div>
	</body>
</html>