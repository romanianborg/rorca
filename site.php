<?php
require_once("config/rights.php");
require_once("config/language.php");
require_once("config/db.php");

//specific for this site
getSiteConfigs();
global $conn;
global $_CONFIG;

require_once("control_lookup.php");lookup_execute('siteoffer','none');
?>
