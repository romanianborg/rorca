<?php

if(intval(session_getvalue("login_clientid")))
{
	if($_GET['tt']=="logout")
	{
		session_setvalue("login_clientid",0);
		include("extensions/info_client_login.php");
	}
	else
	{
		//verifica client
		include("extensions/info_client_portofoliu.php");
	}
}
else
{
	//intra in cont
	include("extensions/info_client_login.php");
}

?>
