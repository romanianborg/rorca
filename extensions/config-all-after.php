<?php
global $_CONFIG;
global $conn;

$conn=create_db_connection();

$_CONFIG['current_align']='H';
$_CONFIG['designer']="simple";
$_CONFIG['language']="ro";

if(isset($_GET["af"]) && $_GET["af"]!='')
{
	//save affiliate
	cookie_setvalue("affiliate","af",substr($_GET["af"],0,20));
	setcookie("af",substr($_GET["af"],0,20),time()+366*24*60*60);
}

if(session_getvalue("current_language")=='')
{
	session_setvalue("current_language",cookie_getvalue("settings","language"));
}

//detect browser accept language
$acceptlangs=$_SERVER['HTTP_ACCEPT_LANGUAGE'];

$acceptro=false;
$accepten=false;

if(isset($acceptlangs) && $acceptlangs!="")
{
	$acclangs=explode(',',$acceptlangs);
	foreach($acclangs as $lk=>$lv)
	{
		$lvs=explode(';',$lv);
		foreach($lvs as $lki=>$lvi)	
		{
			if(substr(trim($lvi),0,2)=='ro')
			{
				$acceptro=true;
			}
			if(substr(trim($lvi),0,2)=='en')
			{
				$accepten=true;
			}
		}
	}
}
if(session_getvalue("current_language")=='ro')
{
	$acceptro=true;
	$accepten=false;
}
if(session_getvalue("current_language")=='en')
{
	$acceptro=false;
	$accepten=true;
}
$_CONFIG['projectthumb']="thumb";

//get parameters
if(isset($_GET['s']) && $_GET['s']=='info' && isset($_GET['id']) && $_GET['id']!='')
{
	$siteface_id=intval($_GET['id']);
	session_setvalue("siteface_".getUserConfig('projectid')."_id",intval($_GET['id']));
	session_setvalue("siteface_".getUserConfig('projectid')."_sid",0);
}
else
{
	$siteface_id=session_getvalue("siteface_".getUserConfig('projectid')."_id");
}
if(isset($_GET['s']) && $_GET['s']=='info' && isset($_GET['sid']) && $_GET['sid']!='')
{
	$siteface_sid=intval($_GET['sid']);
	session_setvalue("siteface_".getUserConfig('projectid')."_sid",intval($_GET['sid']));
}
else
{
	$siteface_sid=session_getvalue("siteface_".getUserConfig('projectid')."_sid");
}

//rights
$_CONFIG['dinsec_'.getLT("contracts").'_cando_user']='no';
$_CONFIG['dinsec_'.getLT("clients").'_cando_user']='no';
$_CONFIG['dinsec_'.getLT("propertiesorders").'_cando_user']='no';


?>
