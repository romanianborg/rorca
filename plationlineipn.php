<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2014
require_once("config/rights.php");
require_once("config/language.php");
require_once("config/db.php");

//specific for this site
getSiteConfigs();
global $conn;
global $_CONFIG;


$_GET['plationlineipn']=true;
$_GET['plationlineipn_post']=true;

require_once("extensions/process_offer_ws.php");



?>
