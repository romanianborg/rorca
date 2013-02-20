<?php

if(!function_exists("create_db_connection"))
{
function create_db_connection()
{
	$conn=new db_conn_dummy();
	return $conn;
}
}

global $siteface_id;
global $siteface_sid;
$siteface_id=0;
$siteface_sid=0;

if(!function_exists("addconfigurlparas"))
{
function addConfigUrlParas($slot,$url)
{
	global $_GET;
	global $siteface_id;
	global $siteface_sid;

	$id=$siteface_id;
	$sid=$siteface_sid;
	
	if($slot!="info" && $siteface_id!=0)
		$url=$url."&id=".$siteface_id;
	if($slot!="info" && $siteface_sid!=0)
		$url=$url."&sid=".$siteface_sid;
	return $url;
}
}

global $_CONFIG;
$_CONFIG['mesaj_multumire']='Multumim pentru plata. Un operator va verifica emiterea.';
$_CONFIG['mesaj_eroare']='Multumim pentru comanda, un operator va prelua comanda imediat ce e posibil.';

$_CONFIG['nume_broker']='asiguram.ro';
$_CONFIG['tarifarcomplet']='yes';
$_CONFIG['datepicker']='yes';

$_CONFIG['theme_color1']='#E7FFCF';
$_CONFIG['theme_color2']='#EEFFFF';
$_CONFIG['theme_color3']='#DBF1E4';
$_CONFIG['theme_color4']='#677A81';
$_CONFIG['theme_color5']='#BAE46E';
?>
