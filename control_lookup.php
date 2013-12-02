<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2009

function lookup_build_menus(&$designer,$action,$my_url,$slot)
{
	$designer->setSelected($action);
	$designer->setSlot($slot);
}

function lookup($action,$slot) {
	global $_GET;
	global $_POST;
	global $_CONFIG;

	if(!isset($action))
		$action="";
	global $conn;

	$quick_template_call=false;
	//check if action is a template callback name.field
	if(strstr($action,".") || strstr($action,"ecall"))
	{
		$quick_template_call=true;
	}
	else
	if(strstr($action,"=ocall"))
	{
		$quick_template_call=true;
		$action=strtok($action,"=");
	}
	//set default view
	if($action=="")
		$action="";
	$found=false;
	if(strstr($action,"_listunfilter"))
	{
	}
	else
	{
	}
	if(!$found)
	{
	}

	$control_name="lookup";
	$_design=getUserConfig('designer','lookup','');

	require_once(getFilePathFor('control',$_design));
	$_design=$_design.'_design';
	$control_designer=new $_design();
	$control_table="issues";
	$control_id="id";

	//check for rights
	if(getUserConfig('dinsec_lookup_cando',$action)=='no') return 0;
	if(session_getvalue("blockaccess_lookup")=="yes") {return 0;}
	if(session_getvalue("blockaccess_issues")=="yes") {return 0;}

	$control_filter="";
	global $my_url;
	$my_url=build_URL_for_me($slot);
	if(!$quick_template_call)
	{
		//set default filter

		$control_designer->setTexts(getLT(''),session_getvalue($slot.'_info'),session_getvalue($slot.'_error'));
		session_setvalue($slot.'_error',"");
		session_setvalue($slot.'_info',"");

		?><a name="<?php  echo $slot;?>" href=""></a><?php
		//build menus for action
		lookup_build_menus($control_designer,$action,build_URL_for_me(''),$slot);
	}
	else
	{
		$control_designer=new control_design();
	}

	//load templates
	if(file_exists("extensions/templates.php"))
		require_once("extensions/templates.php");
	else
		require_once("templates/default.php");
	if(file_exists("extensions/lookup.php"))
		require_once("extensions/lookup.php");

	if(file_exists("extensions/switch_lookup.php"))
	{
		include("extensions/switch_lookup.php");
	}
	else
	switch($action)
	{
		default:
			setSlotView($slot,"");
			break;
	}
}

function lookup_execute($action,$slot) {
	global $_POST;
	global $_GET;
	global $_CONFIG;
	require_once("config/db.php");
	global $conn;
	global $_local_error;
	$_local_error="";
	global $_local_reloadform;
	$_local_reloadform="";
	global $render_current_slot;
	global $current_slots;

	//mark slot on execution stack
	$render_current_slot++;
	$current_slots[$render_current_slot]=$slot;
	
	if(getUserConfig("pageprotection")=="yes")
	{
		if(isset($_POST['fprotection']) && $_POST['fprotection']!="")
		{
			if(isset($_GET['ajax']) && $_GET['ajax']==1)
			{
				if(intval(session_getvalue("protection_page"))!=intval($_POST['fprotection']))
				{
					$_local_error=getLT("protectionerror");
				}
			}
			else
			{
				if(intval(session_getvalue("protection_page"))!=(intval($_POST['fprotection'])+1))
				{
					$_local_error=getLT("protectionerror");
				}
			}
		}
	}

	//set default filter
	$control_filter="";

	$control_name="lookup";
	$control_table="issues";
	$control_id="id";

	//check for rights
	if(getUserConfig('dinsec_lookup_cando',$action)=='no') {$_local_error=getLT('nopermissions');}
	if(getUserConfig('dinsec_lookup_canpost',$action)=='no') {$_local_error=getLT('nopermissions');}
	if(session_getvalue("blockaccess_lookup")=="yes") {$_local_error=getLT('nopermissions');}
	if(session_getvalue("blockaccess_issues")=="yes") {$_local_error=getLT('nopermissions');}


	if($_local_error=="")
	{
	switch($action)
	{
				case 'info':
			if(isset($_POST['cancel_button']) && $_POST['cancel_button']==getLT('cancel'))
			{
				$_local_error='usercanceled';
				break;
			}

			if($_local_error=="")
			{
				require_once("config/utils.php");$_control_replace_sql="parseAndReplaceAll";
			 if(file_exists("extensions/process_lookup.php")) include("extensions/process_lookup.php");

			}
			break;

				case 'siteoffer':
			if(isset($_POST['cancel_button']) && $_POST['cancel_button']==getLT('cancel'))
			{
				$_local_error='usercanceled';
				break;
			}

			if($_local_error=="")
			{
				require_once("config/utils.php");$_control_replace_sql="parseAndReplaceAll";
			 if(file_exists("extensions/process_siteoffer.php")) include("extensions/process_siteoffer.php");

			}
			break;

		default:
			//$_local_error="slot:".$slot." unknown post action: ".$action;
			setSlotView($slot,"");
		break;
	}
	}

	if(isset($_POST['cancel_button']) && $_POST['cancel_button']==getLT('cancel'))
	{
		//if($_local_error!="") session_addvalue($slot.'_error',getLT($_local_error));
		$_local_error='';
	}
	else
	if(($_local_reloadform !="" || $_local_error!="" || $action=="justreloadform")
//	&& (!isset($_GET['ajax']) || $_GET['ajax']!=1)
)
	{
		//save post for later use
		foreach($_POST as $key=>$val)
		{
			if(is_array($val))
				session_setvalue('savedpost_lookup_'.$key,correctPostValue(implode(",",str_replace(',',' ',$_POST[$key]))));
			else
				session_setvalue('savedpost_lookup_'.$key,correctPostValue($val));
		}
		if($_local_error!="") session_addvalue($slot.'_error',$_local_error);
	}
	
	$render_current_slot--;
	return $_local_error;
}

?>
