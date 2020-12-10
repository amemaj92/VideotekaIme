<?php
echo '

<div id="notif_block" style="width: 90%; margin: 15px auto; text-align: center; font-size: 100%;">'; 


echo '</div>

<div id="stream_nav">
<ul>
	<li><a href="../stream/stream_1.php"';
	if($Page_Id==1)echo ' class="current_nav" ';
	echo '>Stream 1</a></li>
	
	<li><a href="../stream/stream_2.php"';
	if($Page_Id==2)echo ' class="current_nav" ';
	echo '>Stream 2</a></li>

</ul>
</div>
';

?>