<?php
//print_r($_POST);

// Copyright AI Software Ltd Bucharest, Romania 2001-2011
require_once("config/rights.php");
require_once("config/language.php");
require_once("config/db.php");

//specific for this site
getSiteConfigs();
global $conn;
global $_CONFIG;

$_GET['crediteuropeipn']=true;
include("extensions/process_siteoffer.php");


?>

