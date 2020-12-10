var request=new XMLHttpRequest();
setTimeout(function()
{
    request.open("GET", "/uni/fill_stats.php?tokeni="+videoteka_tokeni+"&Streami="+videoteka_Streami+"&DoMi="+videoteka_DoMi, true);
    request.send();
}, 300000); 

