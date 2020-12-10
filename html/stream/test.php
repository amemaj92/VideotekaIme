<?php
    /*----PHP Scripts And Variables----*/
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    //----Scripts
    include_once("../uni/db_connect.php");
    //Declaring Varibales
    $OS_Platform=GetOS();
    $IsMobile=IsMobile();
    $Page_Id=1;
    session_start();

echo "SO FAR SO GOOD \n"; 

$queryf= "SELECT * FROM `filma_shqiptar` WHERE `Indeksi`='Apasionata'";
echo $queryf; 

print_r(mysqli_fetch_assoc(mysqli_query($VID_MOVIES,"SELECT * FROM `filma_me_titra_shqip` WHERE `Indeksi`='Mrekulli_ne_qeline_nr_7'"))); 

$querys= "SELECT * FROM `Kara_Sevda`";
print_r(mysqli_fetch_assoc(mysqli_query($VID_SERIES,$querys)));
?>


