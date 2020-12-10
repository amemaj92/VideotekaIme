<?php

$user_agent=$_SERVER['HTTP_USER_AGENT'];

/** These are the database login details*/
define("HOST", "localhost");                    // The host you want to connect to.
define("USER1", "videtmnv_vizitor");            // The database users.
define("PASSWORD1", "Zo6jSBPq#2LlIrV80");        // The users password.
define("DATABASE1", "videtmnv_SERIES");         // The databases name.
define("DATABASE2", "videtmnv_MOVIES");         // The databases name.
define("DATABASE3", "videtmnv_STATS");          // The databases name.

/*-----Films and Series Categories Short and Long-----*/
/*Ketu vendoset nje korrespondence 1:1 mes kategorive kryesore te filmave dhe serialeve
dhe shkurtimeve te tyre qe do te perdoren ne vende te ndryshme.*/

$FilmsArray=array("filma_me_titra_shqip", "filma_te_dubluar_ne_shqip", "filma_shqiptar", "filma_per_femije");
$FilmsArrayShort=array("ftr", "fdb", "fsh", "fpf");

$SeriesArray=array("seriale_turke", "seriale_indiane", "seriale_spanjolle", "seriale_italiane", "seriale_amerikane", "seriale_vizatimor", "seriale_gjermane");
$SeriesArrayShort=array("stu", "sin", "ssp", "sit", "sam", "svi", "sgj");

