<?php

if(isset($_GET["orig"])) 	//The site that has redirected the user here due to adblock. 
{
	//Echo Adblock is active. Please deactivate it and echo redirect link in a button to be pressed after deactivation.
	echo '
	<html lang="sq">
    <head>
        <meta charset="utf-8">
    	<!-- +++ Title and meta tags section +++ --> 
        <title>Keni Aktivizuar ADBLOCK</title>	
	<meta name="description" content="Ju keni aktiv nje program qe bllokon reklamat.">
	<meta name="author" content="Videotekaime.net"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- +++ Links and Scripts Section +++ -->		

	<!-- +++ Styling Rules +++ -->
	<style>
				
	    body {
		background: url("images/background.jpg");
		margin: 0;
		min-width: 320px;
		font-family: Arial, sans-serif; 
	    }

	    #wrapper {
		min-width: 300px;
		min-height: 90%;
		margin: 10px;
		padding: 1%;
		background: white;
		overflow: hidden;
	    }
	
 	    #mesazhi {
		width: 90%; 
		margin: 0 auto; 
		text-align: center;
		font-size: 115%;
		padding-bottom: 15px;
		border-bottom: 2px dashed #222480;
	    }

  	     #procedura {
	 	margin: 0 2%;
		width: 40%; 
		min-width: 290px;
		float: left; 
	    }

 	    #procedura h2 {
		font-size: 120%; 
		text-align: center;
	    }

    	    #procedura ul {
		list-style: none;
		margin-left: 0;
		padding-left: 15px;
	    }

 	     #procedura ul li {
		margin: 10px;
	    }

  	    #procedura ul li span {
		margin-right: 20px; 
		font-weight: bold; 
	    }

  	    #procedura ul img {
		float: right;
	    }

  	    #procedura a {
		display: block;
		margin: 5px auto 20px auto;
		padding: 10px; 
		width: 120px; 
		text-align: center;
		text-decoration: none; 
		font-weight: bold;
		color: white;
		background: #222480; 
		border: 1px solid black; 
		border-radius: 10px;
	    }

  	    #procedura a:hover {
    		text-decoration: underline; 
	    }

  	    #foto_procedura {
		margin: 0; 
		width: 55%; 
		min-width: 300px;
		float: left; 
		overflow: hidden;
		text-align: center;
	    }

    	    #foto_procedura div {
		width: 49%; 
		min-width: 300px;
		float: left; 
	    }

	    #foto_procedura div img {
		display: block;
		margin: 0 auto;
		width: 280px;
		height: auto; 
	    }	
	</style>
	
    </head>
	
    <body>	
        <div id="wrapper">
        <div id="mesazhi">    
        <h1>Ti ke aktiv nje program qe bllokon reklamat (ADBLOCK)</h1>
        <p>Po, edhe ne e kuptojme se reklamat jane te bezdisshme, por jane e vetmja menyre qe ne ta mbajme aktive kete faqe pa kerkuar pagese aksesi per te gjithe vizitoret. Prandaj te lutemi ta ç\'aktivizosh ADBLOCK-un qe edhe ti te vazhdosh te shijosh FALAS gjithçka qe ne ofrojme, por edhe ne te fitojme prej punes sone dhe te mundemi ta mbajme aktive dhe ta zgjerojme faqen tone. 
        <br><br>Te faleminderit dhe shikim te kendshem! Stafi i www.videotekaime.net</p>
        </div>
        <div id="procedura">
        <h2>Ti mund ta ç\'aktivizosh ADBLOCK-un duke ndjekur udhezimet e meposhtme:</h2>
        
                     
            <ul>
        	<li><span>1.</span> <img src="images/abl_thumb.jpg">Gjej figuren e ADBLOCK-ut dhe kliko mbi te. Zakonisht gjendet djathtas lart. </li>
        	<li><span>2.</span> Ne dritaren qe shfaqet kerko dhe kliko opsionin e ç\'aktivizimit ne faqen "www.videotekaime.net". 
        	Zakonisht do ta gjesh te shkruar si <b>"Disable on videotekaime.net"</b> ose <b>"Don\'t run on pages on this domain"</b></li>
        	<li><span>3.</span> <img src="images/abl_inactive_thumb.jpg">Nese ke klikuar opsionin e duhur, ADBLOCK-u do te ndryshoje ngjyre, qe tregon se ai eshte ç\'aktivizuar. Nese ndjek udhezimet hap pas hapi, ADBLOCK do te jete inaktiv ne faqen tone dhe ky mesazh nuk do te te shfaqet me serish. </li>
        	<li><span>4.</span> Per t\'u kthyer ne faqen e meparshme kliko butonin e meposhtem. </li>
            </ul>
            
            <a href="'.$_GET["orig"].'">Kthehu Pas</a>
        </div>
        <div id="foto_procedura">
                <div><h3>Shembulli 1: ADBLOCK</h3> <img src="images/full_abl_procedure_1.jpg"> </div>
                <div><h3>Shembulli 2: ADBLOCK PLUS</h3> <img src="images/full_abl_procedure_2.jpg"> </div>
        </div>    
        
        </div>
        
    </body>	
</html>
	
	';
}

else header("Location: http://videotekaime.net");

?>