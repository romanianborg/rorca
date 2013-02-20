<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2006

//user rights
function canDoSomething($login,$oper)
{
	if($login=="")
		return false;

	if($login=="admin")
		return true;

	if($login==$oper)
		return true;

	if($oper=="admin" && $login=="") return true;
	if($oper=="nobody" && $login=="") return true;
	if($oper=="gestionar" && $login=="") return true;
	if($oper=="operator" && $login=="") return true;
	if($oper=="asigurator" && $login=="") return true;
	if($oper=="broker" && $login=="") return true;

	return false;
}

//get my home
function getMyHome($login)
{
	if($login=="admin") return "admin.php";
	if($login=="nobody") return "index.php";
	if($login=="gestionar") return "gestionar.php";
	if($login=="operator") return "operator.php";
	if($login=="asigurator") return "asigurator.php";
	if($login=="broker") return "broker.php";
}

//server time
function getMyTime()
{
	Global $_CONFIG;
	if(isset($_CONFIG['servertime']))
		return time()+$_CONFIG['servertime'];
	return time();
}

//redirect utility
function redirect($newlink)
{
	if(isset($_GET['ajax']) && $_GET['ajax']=='1')
	{
		if(isset($_POST['faction']) && $_POST['faction']!="")
		{
			?><textarea>location.href="<?php echo $newlink;?>";</textarea><?php
			return;
		}
		?>redirect:<?php echo $newlink; 
		return;
	}
	Header("Location: ".$newlink);
}

//fastest way to cach data
function cache_setvalue($name,$value)
{
	global $_CACHE;
	if(!isset($_CACHE)) $_CACHE=array();
	$_CACHE[$name]=$value;
}
function cache_addvalue($name,$value)
{
	global $_CACHE;
	if(!isset($_CACHE)) $_CACHE=array();
	if(!isset($_CACHE[$name]))
		$_CACHE[$name]=$value;
	else
		$_CACHE[$name].=$value;
}
function cache_getvalue($name)
{
	global $_CACHE;
	if(isset($_CACHE) && isset($_CACHE[$name]))
	{
		return $_CACHE[$name];
	}
	return "";
}

//this can be done using db or cookies
function session_setvalue($name,$value)
{
	global $_SESSION;
	$name="asi".$name;
	$_SESSION[$name]=$value;
	if($value=='') unset($_SESSION[$name]);

	return $value;
}
function session_addvalue($name,$value,$nosep=false)
{
	global $_SESSION;
	$name="asi".$name;
	if(!isset($_SESSION[$name]))
		$_SESSION[$name]=$value;
	else
	{
		if($nosep) $_SESSION[$name].=$value;
		else $_SESSION[$name].=' '.$value;
	}

	return $value;
}
function session_getvalue($name)
{
	global $_SESSION;
	$name="asi".$name;
	if(isset($_SESSION[$name]))
		return $_SESSION[$name];

	return "";
}
//this can be done using db or cookies
require_once("upload.php");
function build_str($arr)
{
	$value="";
	$first=true;
	foreach($arr as $key=>$val)
	{
		if(!$first) $value.="&";
		$value.=$key."=".urlencode($val);
		$first=false;
	}
	return $value;
}
function cookie_setvalue($name,$iname,$value)
{
	global $_COOKIE;
	$name="".$name;
	if(isset($_COOKIE[$name]))
		$oldvalue=getUniqueValue($_COOKIE[$name],$name);
	else
		$oldvalue='';
	if(isset($_COOKIE[$name]) && ($oldvalue!=""))
	{
		$oldvalue=html_entity_decode($oldvalue);
		$md5=$_COOKIE[$name];
		parse_str($oldvalue,$arr);
		$arr[$iname]=$value;
		$value=build_str($arr);
		resetUniqueValue($md5,$value,$name);
	}
	else
	{
		$arr=array();
		$arr[$iname]=$value;
		$value=build_str($arr);
		$md5=setUniqueValue($value,$name);
	}
	setcookie($name,$md5,time()+366*24*60*60);

	return $value;
}
function cookie_addvalue($name,$iname,$value)
{
	$valueold=cookie_getvalue($name,$iname);
	$valueold.=$value;
	return cookie_setvalue($name,$iname,$valueold);
}
function cookie_getvalue($name,$iname)
{
	global $_COOKIE;
	$name="".$name;
	if(isset($_COOKIE[$name]))
	{
		$value=html_entity_decode(getUniqueValue($_COOKIE[$name],$name));
		parse_str($value,$arr);
		if(isset($arr[$iname])) return $arr[$iname];
	}

	return "";
}

//S rendering
function slot_getparentid()
{
	global $render_current_slot;
	global $current_slots;
	
	if(isset($current_slots[$render_current_slot-1]) && $current_slots[$render_current_slot-1]!="")
		return session_getvalue($current_slots[$render_current_slot-1]."_viewid");

	return 0;
}
function slot_getcurrent()
{
	global $render_current_slot;
	global $current_slots;
	
	return $current_slots[$render_current_slot];
}
function slot_render($name,$align='H',$div=true)
{
	global $render_current_slot;
	global $current_slots;
	
	$render_current_slot++;
	$current_slots[$render_current_slot]=$name;

	$callme=session_getvalue('s_'.$name);
	if($callme=="")
	{
		if(file_exists("control_".$name.".php"))
		{
			session_setvalue('s_'.$name,$name);
			$callme=$name;
		}
	}
	$callact=session_getvalue('s_'.$name.'_action');
	if($callme!="")
	{
		global $_CONFIG;
		$_CONFIG['current_align']=$align;
		require_once("control_".$callme.".php");
		if($div){?><div id="<?php echo $name;?>"><?php }
		$callme($callact,$name);
		if($div){?></div><?php }
	}
	$render_current_slot--;
}
function other_render($slot,$name,$action,$relative='')
{
	require_once($relative.'control_'.$name.'.php');
	$name($action.'=ocall',$slot);
}
function quickslot_render($name,$action,$relative='')
{
	global $render_current_slot;
	global $current_slots;
	
	$render_current_slot++;
	$current_slots[$render_current_slot]=$name;
	
	require_once($relative.'control_'.$name.'.php');
	$name($action,$name);
	
	$render_current_slot--;
}

//control URL
function build_URL_for_me($slot)
{
	if(isset($_SERVER['HTTPS']) && ''.$_SERVER['HTTPS']!='')
		$url='https://';
	else
		$url='http://';

	$url.=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	if($slot!="")
		$url.="?s=".$slot;
	else
		$url.="?sa=1";

	if(function_exists("addConfigUrlParas"))
	{
		$url=addConfigUrlParas($slot,$url);
	}

	return $url;
}

function setSlotView($slot,$action)
{
	session_setvalue('s_'.$slot.'_action',$action);
}

function buildUserList($name,$current)
{
?>
<select name="<?php echo $name;?>">
<option value=""><?php echo getLT('norights')?></option>
<option value="admin" <?php if($current=="admin") echo "selected";?>>admin</option>
<option value="nobody" <?php if($current=="nobody") echo "selected";?>>nobody</option>
<option value="gestionar" <?php if($current=="gestionar") echo "selected";?>>gestionar</option>
<option value="operator" <?php if($current=="operator") echo "selected";?>>operator</option>
<option value="asigurator" <?php if($current=="asigurator") echo "selected";?>>asigurator</option>
<option value="broker" <?php if($current=="broker") echo "selected";?>>broker</option>
</select>
<?php
}
function getDefaultUserType()
{
	return "nobody";
}

function getDefaultValue($name,$control_name,$default,$reset=true)
{
	global $_GET;
	if(isset($_GET['d_'.$control_name.'_'.$name]) && ''.$_GET['d_'.$control_name.'_'.$name]!='')
	{
		return $_GET['d_'.$control_name.'_'.$name];
	}
	if(isset($_GET['d_'.$name]) && ''.$_GET['d_'.$name]!='')
	{
		return $_GET['d_'.$name];
	}
	$sess='savedpost_'.$control_name.'_'.$name;
	if(session_getvalue($sess)=='')
	{
		$sess=session_getvalue('d_'.$control_name.'_'.$name);
		if($sess!='')
		{
			return $sess;
		}

		if(strpos($default,"cache.")!==false)
		{
			strtok($default,".");
			$sess=strtok(".");

			return cache_getvalue($sess);
		}

		if(strpos($default,"session.")!==false)
		{
			strtok($default,".");
			$sess=strtok(".");

			return session_getvalue($sess);
		}

		$filename='extensions/defaults.php';
		if(file_exists($filename))
		{
			require_once($filename);

			$filedefault="def_".$control_name;

			if(function_exists($filedefault))
			{
				$retvalue=$filedefault($name);
				if($retvalue!='')
					return $retvalue;
			}
		}

		return $default;
	}

	$ret=html_entity_decode(session_getvalue($sess));
	if($reset) session_setvalue($sess,'');
	return $ret;
}
function correctPostValue($value)
{
	if (get_magic_quotes_gpc()) {
		return stripslashes($value);
	}
	return $value;
}
function getValueForJS($value)
{
	$value=str_replace(array("\\","\r","\n","\"","'",">","<"),array("\\\\","\\r","\\n","\\\"","\\'","+","-"),$value);
	$value = preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $value);
	return $value;
}
function getValueForFieldName($value)
{
	$value=str_replace(" ","_",$value);
	return $value;
}
function getNumberFromPost($number,$decimals="0")
{
	if($decimals=="") $decimals="0";
	if(strstr($number,getLT('numberpoint'))===false)
	{
		$numb=str_replace(getLT('numbergroup'),".",$number);
	}
	else
	{
		$numb=str_replace(getLT('numbergroup'),"",$number);
		$numb=str_replace(getLT('numberpoint'),".",$numb);
	}
	if(getUserConfig("rotunjirecontabila")!="yes")
	{
		if(intval($decimals)>0) {$p=pow(10,intval($decimals));$numb=floor(0.00001+$numb*$p)/$p;}
	}
	return number_format(floatval($numb),$decimals,".","");
}
function showNumber($number,$decimals="0",$editing=false)
{
	if($decimals=="") $decimals="0";
	if($number=="") $number="0";
	if($decimals=="0" && $editing)
		return $number;
	if(getUserConfig("rotunjirecontabila")!="yes")
	{
		if(intval($decimals)>0) {$p=pow(10,intval($decimals));$number=floor(0.00001+$number*$p)/$p;}
	}
	return number_format($number,$decimals,getLT('numberpoint'),getLT('numbergroup'));
}
function isTempCompatible($temp)
{
	$d=cache_getvalue('temp_default');
	if($d=='design/temp_clasic.php'
	|| $d=='design/temp_clasic2.php'
	)
	if($temp=='design/temp_clasic.php'
	|| $temp=='design/temp_clasic2.php')
	{
		return true;
	}

	return false;
}

function getFilePathFor($sys,$ident)
{
	$filename=getLT($sys.'_'.$ident);
	$path='extensions/'.$filename.'.php';
	if(file_exists($path))
	{
		return $path;
	}
	$path='design/'.$filename.'.php';
	if(file_exists($path))
	{
		return $path;
	}

	return '';
}
function getFileContent($path,$def='')
{
	if($path!='')
	if(file_exists($path))
	{
		ob_start();
		include($path);
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
	return $def;
}

function getSiteConfigs()
{
	global $_SERVER;

	if(file_exists("extensions/config-all.php"))
	{
		require_once("extensions/config-all.php");
	}
	$nowww=$_SERVER['HTTP_HOST'];
	if(substr($_SERVER['HTTP_HOST'],0,4)=="www.")
		$nowww=substr($_SERVER['HTTP_HOST'],4);

	if(file_exists("configs/config.".$_SERVER['HTTP_HOST'].".php"))
		require_once("configs/config.".$_SERVER['HTTP_HOST'].".php");
	else
	if(file_exists("configs/config.".$nowww.".php"))
		require_once("configs/config.".$nowww.".php");
	else
	if(file_exists("extensions/config.".$_SERVER['HTTP_HOST'].".php"))
		require_once("extensions/config.".$_SERVER['HTTP_HOST'].".php");
	else
	if(file_exists("extensions/config.".$nowww.".php"))
		require_once("extensions/config.".$nowww.".php");
	else
	{
		$head=strtok($nowww,".");
		if(file_exists("configs/config.".$head.".php"))
			require_once("configs/config.".$head.".php");
		else
		if(file_exists("extensions/config.".$head.".php"))
			require_once("extensions/config.".$head.".php");
		else
		if(file_exists("configs/config.php"))
			require_once("configs/config.php");
		else
		if(file_exists("extensions/config.php"))
			require_once("extensions/config.php");
		else
			require_once("config.php");
	}

	if(file_exists("extensions/config-all-after.php"))
	{
		require_once("extensions/config-all-after.php");
	}

	if(isset($_GET['saction']) && $_GET['saction']=="lang")
	{
		session_setvalue("current_language",$_GET['l']);
		cookie_setvalue("settings","language",$_GET['l']);
	}

	//set today
	switch(getLT("dateformat"))
	{
		case 'dd.MM.yyyy':
			cache_setvalue('today',date('d.m.Y'));
		break;
		case 'MM/dd/yyyy':
			cache_setvalue('today',date('m/d/Y'));
		break;
	}

	global $render_current_slot;
	global $current_slots;
	$render_current_slot=-1;
	$current_slots=array();
}

function enterCriticalSection($f)
{
	$fp = fopen($f, 'a');
	if(!$fp) return $fp;
	//prevent race conditions
	global $active_locks;
	global $active_locksids;
	if(!is_array($active_locks))
		$active_locks=array();
	if(isset($active_locks[$f]) && $active_locks[$f]) return 0;

	$canWrite = false;
	$maxwait=0;
	//Waiting until file will be locked for writing
	while (!$canWrite) {
		$canWrite = flock($fp, LOCK_EX);
		if(!$canWrite)
		{
			//Sleep for 0 - 2000 miliseconds, to avoid colision
			$miliSeconds = rand(1, 10); //1 u = 100 miliseconds
			$maxwait+=$miliSeconds;
			//if($maxwait>400) break;
			usleep(round($miliSeconds*100000));
		}
	}
	$active_locks[$f]=$fp;
	return $fp;
}
function exitCriticalSection($fp)
{
	if(!$fp) return;
	global $active_locks;
	foreach($active_locks as $k=>$v)
	{
		if($fp==$v)
		{
			$active_locks[$k]=0;
			unset($active_locks[$k]);
		}
	}
	fclose($fp);
}
//getUserConfig 'designer' 'slot' 'default'
function getUserConfig($ident,$name='',$defvalue='')
{
	if($defvalue!='')
	{
		return $defvalue;
	}

	global $_CONFIG;

	$value='';
	if(isset($_CONFIG[$ident])) $value=$_CONFIG[$ident];
	if(session_getvalue($ident)!="") $value=session_getvalue($ident);
	
	if($name!='')
	{
		if(isset($_CONFIG[$ident.'_'.$name])) $value=$_CONFIG[$ident.'_'.$name];
		if(session_getvalue($ident.'_'.$name)!="") $value=session_getvalue($ident.'_'.$name);
	}

	return $value;
}

function buildSeoLink($info)
{
	$all=array(
	 "\r","\n","="
	,"+","*","{"
	,"}","(",")"
	,"@"," ","_"
	,"/","\\",";"
	,"&","\""
	);
	$allnone=array("&amp;","?","$","%");
	$info=str_replace($allnone,"",$info);
	$info=str_replace($all,"-",$info);
	return strtolower($info);
}
function buildSeoTitle($info)
{
	$all=array(
	 "\r","\n"
	,"/","\\","\""
	);
	$info=str_replace($all," ",$info);
	return $info;
}

function limitTextToChars($text,$limit)
{
	$_text=strip_tags($text);
	if(strlen($_text)>$limit)
	{
		$_cutpos=@strpos($_text," ",$limit);
		if($_cutpos!==false && $_cutpos>0)
			return substr($_text,0,$_cutpos)."...";
	}
	return $text;
}
function strcontains($mare,$caut)
{
	if(!isset($caut)) return false;
	if($caut=="") return false;
	if(function_exists("stristr"))
	{
		if(stristr($mare,$caut)===false)
			return false;
		return true;
	}
	if(strstr($mare,$caut)===false)
		return false;
	return true;
}

if(!function_exists('str_ireplace')) {
   function str_ireplace($search, $replacement, $string){
       $delimiters = array(1,2,3,4,5,6,7,8,14,15,16,17,18,19,20,21,22,23,24,25,
       26,27,28,29,30,31,33,247,215,191,190,189,188,187,186,
       185,184,183,182,180,177,176,175,174,173,172,171,169,
       168,167,166,165,164,163,162,161,157,155,153,152,151,
       150,149,148,147,146,145,144,143,141,139,137,136,135,
       134,133,132,130,129,128,127,126,125,124,123,96,95,94,
       63,62,61,60,59,58,47,46,45,44,38,37,36,35,34);
       foreach ($delimiters as $d) {
           if (strpos($string, chr($d))===false){
               $delimiter = chr($d);
               break;
           }
       }
       if (!empty($delimiter)) {
           return preg_replace($delimiter.quotemeta($search).$delimiter.'i', $replacement, $string);
       }
       else {
       }
   }
}

//home user specifics
global $GLADIUS_DB_ROOT;
global $CURRENT_OS_UNIX;
global $CURRENT_OS_WIN;
function getUserHomePathFor($path="")
{
	Global $CURRENT_OS_UNIX;
	Global $CURRENT_OS_WIN;
	if($CURRENT_OS_UNIX)
	{
		//macos/linux
		if(isset($_ENV['HOME']))
			return @realpath($_ENV['HOME'])."/".$path;
	}
	return $path;
}

//detect os
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { $CURRENT_OS_UNIX=false;$CURRENT_OS_WIN=true;} else { $CURRENT_OS_UNIX=true;$CURRENT_OS_WIN=false;}
$GLADIUS_DB_ROOT = getUserHomePathFor();

if(function_exists("bcscale")) bcscale(0);
@session_start();

?>
