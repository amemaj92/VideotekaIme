<?php
echo '

<div id="notif_block" style="width: 90%; margin: 15px auto; text-align: center; font-size: 100%;">'; 

$get_data="";
$get_data=$get_data."SoF=".$SoF;

if($SoF == "F"){
     $get_data=$get_data."&Kategoria=".$Kategoria."&Indeksi=".$Indeksi;
}
else if ($SoF == "S"){
     $get_data=$get_data."&Kategoria=".$Kategoria."&Indeksi=".$Indeksi."&Episodi=".$Episodi;
     if (!empty($Pjesa)) $get_data = $get_data."&Pjesa=".$Pjesa;
}

echo '</div>

<div id="stream_nav">
<ul>
	<li><a href="stream.php?'.$get_data.'"';
	if($Page_Id==1)echo ' class="current_nav" ';
	echo '>Stream 1</a></li>
	
	<li><a href="stream2.php?'.$get_data.'"';
	if($Page_Id==2)echo ' class="current_nav" ';
	echo '>Stream 2</a></li>

</ul>
</div>
';

?>