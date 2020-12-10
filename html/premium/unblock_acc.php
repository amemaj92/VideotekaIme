<?php
include_once('db_connect_premium.php');

if(isset($_GET["key"]))
{
	$key=filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
	$result=mysqli_query($mysqli, "SELECT ID, confirm_hash, status, Email FROM `members` WHERE `confirm_hash`='$key'");
	if(mysqli_num_rows($result)>0)
	{
		$row=mysqli_fetch_assoc($result);
		if($row["status"]=="Blocked")
		{
			mysqli_query($mysqli, "UPDATE `members` SET `status` = 'Approved' WHERE `confirm_hash` = '$key'");
			mysqli_query($mysqli, "UPDATE `login_attempts` SET `user_id`='-1' WHERE `user_id` = '$row[ID]'");
			header("Location: info.php?conf=$row[Email]");
		}
		else {header("Location: info.php");}
	}
	else 
	{header("Location: info.php");}
}
else 
{
	header("Location: info.php");
}
?>