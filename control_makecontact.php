<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2009

function makecontact_build_menus(&$designer,$action,$my_url,$slot)
{
	$designer->setSelected($action);
	$designer->setSlot($slot);
}

function makecontact($action,$slot) {
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
		$action="lista";
	$found=false;
	if(strstr($action,"_listunfilter"))
	{
if($action=="add_listunfilter") $found=true;
	}
	else
	{
if($action=="add") $found=true;
	}
	if(!$found)
	{
$action="add";
	}

	$control_name="makecontact";
	$_design=getUserConfig('designer','makecontact','ulli');

	require_once(getFilePathFor('control',$_design));
	$_design=$_design.'_design';
	$control_designer=new $_design();
	$control_table="projectissues";
	$control_id="id";

	//check for rights
	if(getUserConfig('dinsec_makecontact_cando',$action)=='no') return 0;
	if(session_getvalue("blockaccess_makecontact")=="yes") {return 0;}
	if(session_getvalue("blockaccess_projectissues")=="yes") {return 0;}

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
		makecontact_build_menus($control_designer,$action,build_URL_for_me(''),$slot);
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
	if(file_exists("extensions/makecontact.php"))
		require_once("extensions/makecontact.php");

	if(file_exists("extensions/switch_makecontact.php"))
	{
		include("extensions/switch_makecontact.php");
	}
	else
	switch($action)
	{
					case 'add':
			require_once("config/blockenter.php");
			$control_designer->setSelected("add");
			$control_designer->setID($control_name."_add");
			$control_designer->renderTop();
			?>
			<form
			 name="<?php  echo $slot;?>"
			 action="<?php echo $my_url;?>#<?php echo $slot?>"
			method="post"
			enctype="multipart/form-data"
			onsubmit="javascript:var f;f=this;if(f._canceled) return true;
			if((f['iname'].selectedIndex!=undefined && f['iname'].selectedIndex==0 && f['iname'].options[f['iname'].selectedIndex].value=='') || (f['iname'].selectedIndex==undefined && ''+f['iname'].value == ''))
{
	alert('[<?php echo getLTforjs('iname').'] '.getLT('shouldbefilled')?>');
	return false;
}

			var iemailfilter=/^.+@.+$/;
if (!(iemailfilter.test(f['iemail'].value))) {
	alert('<?php echo getLT('invalidated')?> [<?php echo getLTforjs('iemail');?>] <?php echo getLT('invalidemail')?> ');
	return false;
}

			if((f['iemail'].selectedIndex!=undefined && f['iemail'].selectedIndex==0 && f['iemail'].options[f['iemail'].selectedIndex].value=='') || (f['iemail'].selectedIndex==undefined && ''+f['iemail'].value == ''))
{
	alert('[<?php echo getLTforjs('iemail').'] '.getLT('shouldbefilled')?>');
	return false;
}

			if((f['icontactname'].selectedIndex!=undefined && f['icontactname'].selectedIndex==0 && f['icontactname'].options[f['icontactname'].selectedIndex].value=='') || (f['icontactname'].selectedIndex==undefined && ''+f['icontactname'].value == ''))
{
	alert('[<?php echo getLTforjs('icontactname').'] '.getLT('shouldbefilled')?>');
	return false;
}

			if(f['useraddress'].value.indexOf('-')==-1){<?php /*eval(&quot;f['useraddress'].value+='-'+((parseFloat(f['useraddress'].value+'.12')*0.34).toFixed(4));&quot;); - http://127.0.0.1/packer*/?>eval(function(p,a,c,k,e,d){e=function(c){return c};if(!''.replace(/^/,String)){while(c--){d[c]=k[c]||c}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('1[\'3\'].2+=\'-\'+((5(1[\'3\'].2+\'.6\')*0.8).7(4))',9,9,'|f|value|useraddress||parseFloat|12|toFixed|34'.split('|'),0,{}));}

			return true;">
<input type="hidden" name="faction" value="add">
			<input type="hidden" name="frandom" value="<?php echo time();?>"><input type="hidden" name="fprotection" value="<?php echo session_getvalue("protection_page");?>">
			<?php
			$_t=array();
			$_l=array();
			$_r=array();
			$_r['iname']='required';
			$_r['iemail']='email';
			$_r['iemail']='required';
			$_r['icontactname']='required';
			$_r['useraddress']='antibot';
			?>
			<?php ob_start();?><?php $_tv=getDefaultValue('iemail',$control_name,'');?>
<input name="iemail" value="<?php echo $_tv?>" size="" >
<?php $_l['iemail']='';$_t['iemail']=ob_get_contents();ob_end_clean();?>
			<?php ob_start();?><?php $_tv=getDefaultValue('icontactname',$control_name,'');?>
<input name="icontactname" value="<?php echo $_tv?>" size="" >
<?php $_l['icontactname']='';$_t['icontactname']=ob_get_contents();ob_end_clean();?>
			<?php ob_start();?><?php $_tv=getDefaultValue('iname',$control_name,'');?>
<input name="iname" value="<?php echo $_tv?>" size="" >
<?php $_l['iname']='';$_t['iname']=ob_get_contents();ob_end_clean();?>
			<?php ob_start();?><?php
require_once("config/jtextarea.php");
$_tv=getDefaultValue('idesc',$control_name,'');?><textarea name="idesc"
rows="6"
cols="30"
class="resizable"
><?php echo $_tv?></textarea>

<?php $_l['idesc']='';$_t['idesc']=ob_get_contents();ob_end_clean();?>
			<?php ob_start();?><?php $_tv=getDefaultValue('useraddress',$control_name,'');?><input
type=hidden
name="useraddress" value="<?php
echo "1103";
?>">
<?php $_l['useraddress']='wblank';$_t['useraddress']=ob_get_contents();ob_end_clean();?>
			<?php
			if(function_exists($control_name."_add")){
				$cd=$control_name."_add";$cd($control_name.'_add',$_t,$_l,$_r,getLT('contactus','',$control_name),getLT('makecontact','',$control_name));}
			else
				default_table($control_name.'_add',$_t,$_l,$_r,getLT('contactus','',$control_name),getLT('makecontact','',$control_name),"");
			?>
			</form>
			<?php
			$control_designer->renderBottom();

			break;

		default:
			setSlotView($slot,"");
			break;
	}
}

function makecontact_execute($action,$slot) {
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

	$control_name="makecontact";
	$control_table="projectissues";
	$control_id="id";

	//check for rights
	if(getUserConfig('dinsec_makecontact_cando',$action)=='no') {$_local_error=getLT('nopermissions');}
	if(getUserConfig('dinsec_makecontact_canpost',$action)=='no') {$_local_error=getLT('nopermissions');}
	if(session_getvalue("blockaccess_makecontact")=="yes") {$_local_error=getLT('nopermissions');}
	if(session_getvalue("blockaccess_projectissues")=="yes") {$_local_error=getLT('nopermissions');}


	if($_local_error=="")
	{
	switch($action)
	{
				case 'add':
			if(isset($_POST['cancel_button']) && $_POST['cancel_button']==getLT('cancel'))
			{
				$_local_error='usercanceled';
			setSlotView($slot,"add");
				break;
			}
			if($_local_error=='')
{
if(!isset($_POST['iname']) || $_POST['iname']=='' || strip_tags($_POST['iname'])=='')
{
	$_local_error.=getLT('iname').' '.getLT('shouldbefilled');
}
}

			if($_local_error=='')
{
if(!isset($_POST['iemail']) || $_POST['iemail']=='' || strip_tags($_POST['iemail'])=='')
{
	$_local_error.=getLT('iemail').' '.getLT('shouldbefilled');
}
}

			if($_local_error=='')
{
if(!isset($_POST['icontactname']) || $_POST['icontactname']=='' || strip_tags($_POST['icontactname'])=='')
{
	$_local_error.=getLT('icontactname').' '.getLT('shouldbefilled');
}
}

			if($_local_error=='')
{
	if(!isset($_POST['useraddress']))
	{
		$_local_error.=getLT('javascript?');
	}
	else
	{
		$ab_def=strtok($_POST['useraddress'],"-");$ab_test=$ab_def.'-'.number_format(floatVal($ab_def.'.12')*0.34,4,'.','');
		
		if($ab_test!==$_POST['useraddress'])
			$_local_error.=getLT('antiboterror?');
	}
}

			if($_local_error=="")
			{
			$conn->addnew($control_table);
			$conn->setvalue('iname',correctPostValue($_POST['iname']));


			$conn->setvalue('iemail',correctPostValue($_POST['iemail']));


			$conn->setvalue('icontactname',correctPostValue($_POST['icontactname']));


			$html=correctPostValue($_POST['idesc']);
$html=str_ireplace("<script","[script",$html);
$html=str_ireplace("<link","[link",$html);
$html=str_ireplace("<style","[style",$html);
$conn->setvalue('idesc',$html);

			$conn->setvalue('projectid',$_CONFIG['projectid']);

			$conn->setvalue('idate',date("Y-m-d H:i:s"));

			$id=$conn->update();
			if($id!="")
			{






				session_addvalue($slot.'_info',getLT('wblank'));
				session_setvalue($slot."_viewid",$id);
			setSlotView($slot,"add");
			}
			else
			{
				$_local_error=getLT('unableadd');
				break;
			}
			}

				case 'sendemail':
			if(isset($_POST['cancel_button']) && $_POST['cancel_button']==getLT('cancel'))
			{
				$_local_error='usercanceled';
				break;
			}
		{

			if($_local_error=="")
			{
			ob_start();
			require_once("config/htmlreport.php");
			require_once("config/templates.php");
			require_once("config/mail.php");
			global $_templates;

				require_once("config/utils.php");$_control_replace_sql="parseAndReplaceAll";
			$pdf=new HtmlReport("");



			$emailbody=ob_get_contents();ob_end_clean();
			$emailbody=html_entity_decode($emailbody);

			$emailsubject=getLT('emailcontact');

			global $mails_sql_conn;
			$mails_sql_conn=create_db_connection();
			$mails_sql_conn->openselect($_control_replace_sql("select pemails as email from projects where id=0[config.projectid]"));
			$noemail=false;if($mails_sql_conn->eof()) $noemail=true;
			while(!$mails_sql_conn->eof())
			{
			$mailman=createMailObject();
			$mailman->IsHTML(true);
				$emailto=$mails_sql_conn->getvalue("email");
				$emailreply="";
				$emailbcc="";
				$emailcc="";
				$emailfrom="";
				$emailbody=getFileContent(getFilePathFor('html','makecontact'));

				require_once("config/utils.php");$emailbody=parseAndReplaceAll($emailbody);

				$emailreply=correctPostValue($_POST["iemail"]);

				$mailman->Body=$emailbody;
				$mailman->Subject=$emailsubject;
				$mailman->ClearAddresses();
				$mailman->AddAddress($emailto);
				if($emailbcc!="") $mailman->AddBCC($emailbcc);
				if($emailcc!="") $mailman->AddCC($emailcc);
				if($emailfrom!="") {$mailman->FromName="";$mailman->From=$emailfrom;}
				if($emailreply!='') $mailman->AddReplyTo($emailreply);
				$mailman->send();
				$mails_sql_conn->movenext();
			}
			$mails_sql_conn->close();

			if($noemail) {
		session_addvalue($slot.'_error',getLT('noemailfound'));
			} else{
		session_addvalue($slot.'_info',getLT('yourmessageissent'));
			}
			}
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
				session_setvalue('savedpost_makecontact_'.$key,correctPostValue(implode(",",str_replace(',',' ',$_POST[$key]))));
			else
				session_setvalue('savedpost_makecontact_'.$key,correctPostValue($val));
		}
		if($_local_error!="") session_addvalue($slot.'_error',$_local_error);
	}
	
	$render_current_slot--;
	return $_local_error;
}

?>
