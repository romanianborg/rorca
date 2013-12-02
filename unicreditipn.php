<?php

// Copyright AI Software Ltd Bucharest, Romania 2001-2011
require_once("config/rights.php");
require_once("config/language.php");
require_once("config/db.php");

//specific for this site
getSiteConfigs();
global $conn;
global $_CONFIG;

/*
$f=fopen("log.txt","a+");
ob_start();print_r($_POST);$all=ob_get_contents();ob_end_clean();
fwrite($f,$all);
fclose($f);
*/

$_GET['unicreditipn']=true;
$_GET['unicreditipn_post']=false;
include("extensions/process_siteoffer.php");

?>
