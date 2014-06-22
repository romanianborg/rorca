<?php
function process_sort_series($row1,$row2)
{
	if($row1['date']>$row2['date']) return 1;
	if($row1['date']<$row2['date']) return -1;
	if($row1['dir']>$row2['dir']) return -1;
	return 0;
}
function process_series(&$series)
{
	$ret=true;
	$_checks=array();
	$_checkssameday=array();
	$_finals=array();
	$failfor=false;
	$failfor_up=false;
	if(isset($GLOBALS['process_series_failfor'])) $failfor_up=$failfor=$GLOBALS['process_series_failfor'];
	if(isset($GLOBALS['process_series_failfor_up'])) $failfor_up=$GLOBALS['process_series_failfor_up'];

	foreach($series as $info=>$value)
	{
		if(!isset($_checks[$info]))
		{
			$_checks[$info]=array();
		}
		if(!isset($_finals[$info]))
		{
			$_finals[$info]=array();
		}
		if(!isset($_checkssameday[$info]))
		{
			$_checkssameday[$info]=array();
		}
		$lasterrors=0;
		while(count($_checkssameday[$info]) || count($value))
		{
			$fromerrors=false;
			if($itemch=array_shift($_checkssameday[$info]))
			{
				$fromerrors=true;
			}
			else
			{
				$itemch=array_shift($value);
			}
			
			//check direction
			if($itemch['dir']==1)
			{
				//check for allready in finals
				$found=false;
				foreach($_finals[$info] as $finals_key=>$finals_val)
				{
					if(bccomp($finals_val['to'],$itemch['from'])<0
					|| bccomp($finals_val['from'],$itemch['to'])>0)
					{
						//ok
					}
					else
					{
						$found=true;
						array_push($_checkssameday[$info],$itemch);
						//error
						if($fromerrors)
						{
							$lasterrors--;
							if($lasterrors<=0)
							{
								if($ret) session_addvalue("error",getLT("serieserror").": ".$itemch['from']."-".$itemch['to'].".");
								$ret=false;
								$_checkssameday[$info]=array();
							}
						}
						else
						{
							//get all next for this date.. and try again.. if none good dump error
							while(($getone=array_shift($value)))
							{
								if($getone['date']==$itemch['date'])
								{
									array_unshift($_checkssameday[$info],$getone);
								}
								else
								{
									array_unshift($value,$getone);
									break;
								}
							}

							$lasterrors=count($_checkssameday[$info]);
							if($lasterrors<=1)
							{
								//error
								if($ret) session_addvalue("error",getLT("serieserror").": ".$itemch['from']."-".$itemch['to'].".");
								$ret=false;
								$_checkssameday[$info]=array();
							}
						}
						
						break;
					}
				}
				if(!$found)
				{
					array_push($_finals[$info],$itemch);
					if($fromerrors)
					{
						$lasterrors=count($_checkssameday[$info]);
					}
				}
			}
			else
			{
				array_push($_checks[$info],$itemch);
				//process
				$count1=sizeof($_checks[$info]);
				while($count1 && ($itemch=array_shift($_checks[$info])))
				{
					$count1--;

					$count=sizeof($_finals[$info]);
					$found=false;
					while($count && ($item=array_shift($_finals[$info])))
					{
						$count--;
						if(bccomp($itemch['to'],$item['from'])<0 || bccomp($itemch['from'],$item['to'])>0)
						{
							//no impact
							array_push($_finals[$info],$item);
						}
						else
						{
							$found=true;
							if(bccomp($item['from'],$itemch['from'])<0)
							{
								if(bccomp($item['from'],bcsub($itemch['from'],"1"))<=0)
								{
									$items=$item;
									$items["from"]=$item['from'];
									$items["to"]=bcsub($itemch['from'],"1");
									$items["date"]=$item["date"];
									$items["dir"]=$item["dir"];
									$items["utils"]=$item["utils"];
									array_push($_finals[$info],$items);
									$count++;
								}
							}
							else
							{
								if(bccomp($itemch['from'],bcsub($item['from'],"1"))<=0)
								{
									$itemc=array();
									$itemc["from"]=$itemch['from'];
									$itemc["to"]=bcsub($item['from'],"1");
									$itemc["date"]=$itemch["date"];
									$itemc["dir"]=$itemch["dir"];
									$itemc["utils"]=$itemch["utils"];
									array_push($_checks[$info],$itemc);
									$count1++;
								}
							}
							if(bccomp($item['to'],$itemch['to'])>0)
							{
								if(bccomp(bcadd($itemch['to'],"1"),$item['to'])<=0)
								{
									$items=$item;
									$items["from"]=bcadd($itemch['to'],"1");
									$items["to"]=$item['to'];
									$items["date"]=$item["date"];
									$items["dir"]=$item["dir"];
									$items["utils"]=$item["utils"];
									array_push($_finals[$info],$items);
									$count++;
								}
							}
							else
							{
								if(bccomp(bcadd($item['to'],"1"),$itemch['to'])<=0)
								{
									$itemc=array();
									$itemc["from"]=bcadd($item['to'],"1");
									$itemc["to"]=$itemch['to'];
									$itemc["date"]=$itemch["date"];
									$itemc["dir"]=$itemch["dir"];
									$itemc["utils"]=$itemch["utils"];
									array_push($_checks[$info],$itemc);
									$count1++;
								}
							}
							break;
						}
					}
					if($found)
					{
						//ok
						if($fromerrors)
						{
							$lasterrors=count($_checkssameday[$info]);
						}
					}
					else
					{
						if(isset($itemch['ignore']) && $itemch['ignore'])
						{
							//just ignore
							continue;
						}
						array_push($_checkssameday[$info],$itemch);
						//get all for that day
						if($fromerrors)
						{
							$lasterrors--;
							if($lasterrors<=0)
							{
								$_checkssameday[$info]=array();
								if($failfor!==false)
								{
									if(bccomp($failfor,$itemch['from'])>=0 && bccomp($failfor,$itemch['to'])<=0)
									{
										//we have an error
										if($ret) session_addvalue("error",getLT("serieserror").": ".$itemch['from']."-".$itemch['to'].".");
										$ret=false;
										break;
									}
								}
								else
								{
									if($ret) session_addvalue("error",getLT("serieserror").": ".$itemch['from']."-".$itemch['to'].".");
									$ret=false;
									break;
								}
							}
						}
						else
						{
							//add all on that day
							while(($getone=array_shift($value)))
							{
								if($getone['date']==$itemch['date'])
								{
									array_unshift($_checkssameday[$info],$getone);
								}
								else
								{
									array_unshift($value,$getone);
									break;
								}
							}
							$lasterrors=count($_checkssameday[$info]);
							if($lasterrors==1)
							{
								$_checkssameday[$info]=array();
								if($failfor!==false)
								{
									if(bccomp($failfor,$itemch['from'])>=0 && bccomp($failfor,$itemch['to'])<=0)
									{
										//we have an error
										if($ret) session_addvalue("error",getLT("serieserror").": ".$itemch['from']."-".$itemch['to'].".");
										$ret=false;
										break;
									}
								}
								else
								{
									if($ret) session_addvalue("error",getLT("serieserror").": ".$itemch['from']."-".$itemch['to'].".");
									$ret=false;
									break;
								}
							}
						}
					}
				}
			}
		}
	}
	$series=$_finals;
	if(isset($GLOBALS['process_series_failfor'])) unset($GLOBALS['process_series_failfor']);
	if(isset($GLOBALS['process_series_failfor_up'])) unset($GLOBALS['process_series_failfor_up']);
	return $ret;
}

function getNextNumber($number)
{
	$str=$number;
	$newstr='';
	$lenstr=strlen($str);
	$shouldinc=true;
	$lastzero=false;
	for($i=0;$i<$lenstr;$i++)
	{
		$chr=substr($str,-$i-1,1);
		if($shouldinc)
		{
			switch($chr)
			{
				case '9':
					$chr='0';
					$lastzero=true;
					break;
				case '8':
				case '7':
				case '6':
				case '5':
				case '4':
				case '3':
				case '2':
				case '1':
				case '0':
					$chr=$chr+1;
					$shouldinc=false;
					break;
			}
		}

		$newstr=$chr.$newstr;
	}

	if($shouldinc)
	{
		if($lastzero)
		{
			$zeropos=strpos($newstr,'0');
			if($zeropos>=0)
			{
				$newstr2=substr($newstr,0,$zeropos).'1'.substr($newstr,$zeropos);
				$newstr=$newstr2;
			}
			else
			{
				$newstr.='1';
			}

		}
		else
		{
			$newstr.='1';
		}
	}

	return $newstr;
}
function getNextNumberFromSql($sql,$field,$starting='')
{
	$newconn=create_db_connection();
	$newconn->openselect(parseAndReplaceAll($sql));
	$maxvalue=$starting;
	if(!$newconn->eof())

	{
		$maxvalue=$newconn->getvalue($field);
		$newconn->close();
	}

	return getNextNumber($maxvalue);
}

function html_entity_decode2($str)
{
	$str=str_replace("&nbsp;",' ',$str);
	if (version_compare(PHP_VERSION, '5.4.0') >= 0)
	{
		return html_entity_decode($str,ENT_COMPAT, 'WINDOWS-1252');
	}

	return html_entity_decode($str);
}

function parseAndReplaceAll($text,$slotback='')
{
	global $directdump;
	$directdump=false;
	//[sql.s1.field1.type]
	//[var.name.type]
	//[para.name]
	$newstring="";
	$oldpos=0;
	$pos=strpos($text,"[",$oldpos);
	$ifs=array();
	$cif=0;
	$ifs[$cif]=false;
	while($pos!==false)
	{
		//search for close
		$pos2=strpos($text,"]",$pos);
		if($pos2!==false)
		{
			if($ifs[$cif])
			{
				//ignore only for an [endif]  [fi]
				$token=substr($text,$pos+1,$pos2-$pos-1);
				$arr=explode(".",$token);
				if($arr[0]=='if' || $arr[0]=='!if' || $arr[0]=='nif')
				{
					$cif++;
					$ifs[$cif]=true;
				}
				if($arr[0]=="endif" || $arr[0]=="fi")
				{
					$ifs[$cif]=false;
					$cif--;
				}
				$oldpos=$pos2+1;
			}
			else
			{
				if($directdump)
					echo substr($text,$oldpos,$pos-$oldpos);
				else
					$newstring.=substr($text,$oldpos,$pos-$oldpos);
				$oldpos=$pos;
				//we have a token.. anallys
				$token=substr($text,$pos+1,$pos2-$pos-1);
				if(strlen($token))
				{
					$displaytype="";
					$displaypara="";
					$displayvalue="";
					$arr=explode(".",$token);
					
					$iftest=false;
					$ifnegative=false;
					if(isset($arr[0]) && ($arr[0]=='if' || $arr[0]=='!if' || $arr[0]=='nif'))
					{
						$iftest=true;
						if($arr[0]=='!if' || $arr[0]=='nif') {$ifnegative=true;}
						$iftestvalue="";
						if(isset($arr[1])) $iftestvalue=$arr[1];
						for($i=2;$i<count($arr);$i++)
						{
							$arr[$i-2]=$arr[$i];
						}
						if(count($arr)) unset($arr[count($arr)-1]);
						if(count($arr)) unset($arr[count($arr)-1]);
					}

					if(isset($arr[1]) || $token=="fi" || $token=="endif")
					switch($arr[0])
					{
					case 'endif':
					case 'fi':
						$oldpos=$pos2+1;
						$ifs[$cif]=false;
						$cif--;
						break;
					case 'sql':
						//valid
						$oldpos=$pos2+1;
						if(isset($arr[3])) $displaytype=$arr[3];
						if(isset($arr[4])) $displaypara=$arr[4];
						//get value
						if(isset($arr[1]) && isset($GLOBALS[$arr[1].'_sql_conn']))
						{
							if(isset($arr[2])) $displayvalue=$GLOBALS[$arr[1].'_sql_conn']->getvalue($arr[2]);
							if($displaytype=="fast" && isset($arr[2]))
							{
								$displayvalue=$GLOBALS[$arr[1].'_sql_conn']->getvaluefast($arr[2]);
								if(isset($arr[4])) $displaytype=$arr[4];
								if(isset($arr[5])) $displaypara=$arr[5];
							}
							if($displaytype=="mins")
							{
								$displaypara=$GLOBALS[$arr[1].'_sql_conn']->getvalue($arr[2]."_panala");
								require_once("config/dateutils.php");
								$diff=timediff($displayvalue,$displaypara,getLT("dateformat"));
								$secs=intval(timediffsecs($diff)/60);
								$displayvalue=$secs;
								$displaypara=$arr[5];
							}
						}
						else
						if($arr[1]=="conn")
						{
							if(isset($arr[2])) $displayvalue=$GLOBALS[$arr[1]]->getvalue($arr[2]);
							if($displaytype=="fast" && isset($arr[2]))
							{
								$displayvalue=$GLOBALS[$arr[1]]->getvaluefast($arr[2]);
								if(isset($arr[4])) $displaytype=$arr[4];
								if(isset($arr[5])) $displaypara=$arr[5];
							}
							if($displaytype=="mins")
							{
								$displaypara=$GLOBALS[$arr[1]]->getvalue($arr[2]."_panala");
								require_once("config/dateutils.php");
								$diff=timediff($displayvalue,$displaypara,getLT("dateformat"));
								$secs=intval(timediffsecs($diff)/60);
								$displayvalue=$secs;
								$displaypara=$arr[5];
							}
						}
						break;
					case 'var':
					case 'g':
						//valid
						$oldpos=$pos2+1;
						if(isset($arr[1])) $displayvalue=$GLOBALS[$arr[1]];
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						//get value
						break;
					case 'cache':
						$oldpos=$pos2+1;
						if(isset($arr[1])) $displayvalue=cache_getvalue($arr[1]);
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						//get value
						break;
					case 'para':
						//valid
						$oldpos=$pos2+1;
						global $_control_replace_sql;
						if(isset($arr[1])) $displayvalue=$_control_replace_sql('@'.$arr[1]);
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						break;
					case 'post':
						//valid
						$oldpos=$pos2+1;
						global $_POST;
						if(isset($arr[1]) && $_POST[$arr[1]]!="") $displayvalue=''.correctPostValue($_POST[$arr[1]]);
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						break;
					case 'posttags':
						//valid
						$oldpos=$pos2+1;
						global $_POST;
						if(isset($arr[1]) && $_POST[$arr[1]]!="") $displayvalue=''.correctPostValue(implode(",",$_POST[$arr[1]]));
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						break;
					case 'get':
						//valid
						$oldpos=$pos2+1;
						global $_GET;
						if(isset($arr[1]) && $_GET[$arr[1]]!="") $displayvalue=''.correctPostValue($_GET[$arr[1]]);
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						break;
					case 'config':
					case 'c':
						//valid
						$oldpos=$pos2+1;
						if(isset($arr[1])) $displayvalue=getUserConfig($arr[1]);
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						break;
					case 'cookie':
						$oldpos=$pos2+1;
						if(isset($arr[1]) && isset($arr[2])) $displayvalue=cookie_getvalue($arr[1],$arr[2]);
						if(isset($arr[3])) $displaytype=$arr[3];
						if(isset($arr[4])) $displaypara=$arr[4];
						break;
					case 'session':
					case 's':
						//valid
						$oldpos=$pos2+1;
						if(isset($arr[1])) $displayvalue=session_getvalue($arr[1]);
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						break;
					case 'utils':
						//valid
						$oldpos=$pos2+1;
						if(isset($arr[1])) $displayvalue=$arr[1];
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						break;
					case 'slot':
						//we have a callback
						$oldpos=$pos2+1;
						if(isset($arr[1])) $displayvalue=$arr[1];
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						if($slotback!='')
						{
							$displayvalue=$slotback($displayvalue,$displaytype,$displaypara);
							$displaytype='';
							$displaypara='';
						}
						break;
					case 'call':
						//we have a callback
						$oldpos=$pos2+1;
						if(isset($arr[1])) $displayvalue=$arr[1];
						if(isset($arr[2])) $displaytype=$arr[2];
						if(isset($arr[3])) $displaypara=$arr[3];
						$fn=$displayvalue;
						if(function_exists($fn))
						{
							$displayvalue=$fn($displaytype,$displaypara);
						}
						else
						{
							$displayvalue='';
						}
						break;
					}
					$displaypara=str_replace('^','.',$displaypara);
					if($iftest)
					{
						//we have an ok
						$cif++;
						$iftestvalue=str_replace('^','.',$iftestvalue);
						if($ifnegative)
						{
							if($displayvalue!=$iftestvalue)
							{
								$ifs[$cif]=false;
							}
							else
							{
								$ifs[$cif]=true;
							}
						}
						else
						{
							if($displayvalue==$iftestvalue)
							{
								$ifs[$cif]=false;
							}
							else
							{
								$ifs[$cif]=true;
							}
						}
					}
					else
					{
						$oldnewstring=$newstring;
						if($directdump) $newstring='';
						switch($displaytype)
						{
						case 'lb':
							$newstring.='[';
							break;
						case 'rb':
							$newstring.=']';
							break;
						case 'now':
							require_once("config/dateutils.php");
							if($displayvalue!="")
								$newstring.=date($displayvalue);
							else
								$newstring.=showDate(date("Y-m-d"),getLT("dateformat"));
							break;
						case 'date':
							require_once("config/dateutils.php");
							if($displaypara!="")
							{
								if($displayvalue!="0000-00-00")
									$newstring.=date(str_replace("~",".",$displaypara),showDate($displayvalue,"time"));
							}
							else
							{
								$newstring.=showDate($displayvalue,getLT("dateformat"));
							}
							break;
						case 'sqldate':
							require_once("config/dateutils.php");
							$newstring.=getDateForMysql($displayvalue,getLT("dateformat"));
							break;
						case 'time':
							require_once("config/dateutils.php");
							$newstring.=showTime($displayvalue);
							break;
						case 'intval':
							if($displaypara!="")
								$newstring.=bcadd($displayvalue,'0');
							else
								$newstring.=intval($displayvalue);
							break;
						case 'number':
							$newstring.=showNumber($displayvalue,$displaypara);
							break;
						case 'exnumber':
							$newstring.=number_format(floatval($displayvalue),$displaypara,'.','');
							break;
						case 'zeronumber':
							if(abs(round($displayvalue)-$displayvalue)<=0.01)
								$newstring.=showNumber(round($displayvalue),$displaypara);
							else
								$newstring.=showNumber($displayvalue,$displaypara);
							break;
						case 'zeros':
							$newstring.=str_pad($displayvalue,$displaypara, "0", STR_PAD_LEFT);
							break;
						case 'spell':
							require_once("extern/numberspell.php");
							if(isset($GLOBALS[$displaypara]))
							{
								$newstring.=spellNumber($displayvalue,$GLOBALS[$displaypara]);
							}
							else
							{
								$newstring.=spellNumber($displayvalue,getCurrentLang());
							}
							break;
						case 'sqlescape':
							global $conn;
							if($displaypara!="")
							{
								$newstring.=$conn->escape(substr($displayvalue,0,intval($displaypara)));
							}
							else
							{
								$newstring.=$conn->escape($displayvalue);
							}
							break;
						case 'sqlvalues':
							global $conn;
							$myvalues='';
							$myarr=explode(",",$displayvalue);
							foreach($myarr as $kkmk=>$kkmv)
							{
								if($myvalues!="") $myvalues.=",";
								$myvalues.="'".$conn->escape($kkmv)."'";
							}
							if($myvalues=="") $myvalues="''";
							$newstring.=$myvalues;
							break;
						case 'split':
							$sparr=explode(".",trim($displayvalue));
							$newstring.=$sparr[intval($displaypara)];
							break;
						case 'explode':
							$sparr=explode(" ",trim($displayvalue));
							$newstring.=$sparr[intval($displaypara)];
							break;
						case 'substr':
							if(intval($displaypara)<0)
							{
								$newstring.=substr($displayvalue,intval($displaypara));
							}
							else
							{
								$newstring.=substr($displayvalue,0,intval($displaypara));
							}
							break;
						case 'trim':
							$displayvalue=str_replace(" ","",trim($displayvalue));
							$displayvalue=str_replace(".","",$displayvalue);
							$displayvalue=str_replace("-","",$displayvalue);
							$displayvalue=str_replace("=","",$displayvalue);
							$newstring.=$displayvalue;
							break;
						case 'html':
							$newstring.=str_replace("\n","<br>",$displayvalue);
							break;
						case 'nohtml':
							$newstring.=strip_tags(html_entity_decode2($displayvalue));
							break;
						case 'pin':
							$newstring.=substr(md5($displayvalue),intval($displaypara));
							break;
						case 'lang':
							$newstring.=getLT($displayvalue);
							break;
						case 'upper':
							$newstring.=strtoupper($displayvalue);
							break;
						case 'caps':
							$newstring.=strtoupper(substr(getLT($displayvalue),0,1)).strtolower(substr(getLT($displayvalue),1));
							break;
						case 'lower':
							$newstring.=strtolower($displayvalue);
							break;
						case 'adresa':
							$newstring.=strtoupper(str_ireplace("zip","cod postal",$displayvalue));
							break;
						case 'full':
							$newstring.=parseAndReplaceAll($displayvalue,$slotback);
							break;
						case 'easyread':
							$newstring.=strrev(join(str_split(strrev($displayvalue),3),"."));
							break;
						case 'phone':
							$displayvalue=str_replace("-","",$displayvalue);
							$displayvalue=str_replace("/","",$displayvalue);
							$displayvalue=str_replace(" ","",$displayvalue);
							$displayvalue=str_replace(".","",$displayvalue);
							$displayvalue=str_replace(",","",$displayvalue);
							$displayvalue=str_replace(",","",$displayvalue);
							$displayvalue=substr($displayvalue,0,10);
							$newstring.=$displayvalue;
							break;
						case 'seo':
							$newstring.=buildSeoLink($displayvalue);
							break;
						default:
							$newstring.=$displayvalue;
							break;
						}
						if($directdump)
						{
							echo $newstring;
							$newstring=$oldnewstring;
						}
					}
				}
			}
		}
		
		$pos=strpos($text,"[",$pos+1);
	}
	$newstring.=substr($text,$oldpos);
	return $newstring;
}
function solveToken($texp)
{
	$oexp='';
	switch($texp)
	{
		default:
			if($texp!='')
			{
				if(strpos($texp,'.')===false)
						$oexp.='$'.$texp;
				else
					if(substr($texp,0,2)=='s.')
						$oexp.='session_getvalue("'.substr($texp,2).'")';
					else
					if(substr($texp,0,2)=='g.')
					{
						$varname=substr($texp,2);
						if(strstr($varname,'[')!==false)
						{
							$oexp.='$GLOBALS["'.strtok($varname,'[').'"]['.solveToken(strtok(']')).']';
						}
						else
						{
							$oexp.='$GLOBALS["'.$varname.'"]';
						}
					}
					else
					if(substr($texp,0,2)=='q.')
					{
						$arr=explode(".",substr($texp,2),2);
						if($arr[0]=='conn')
						{
							$oexp.='$GLOBALS["conn"]->getvalue(parseAndReplaceAll("'.$arr[1].'"))';
						}
						else
						{
							$oexp.='$GLOBALS["'.$arr[0].'_sql_conn"]->getvalue(parseAndReplaceAll("'.$arr[1].'"))';
						}
					}
					else
					if(substr($texp,0,2)=='c.')
					{
						$oexp.='$GLOBALS["_CONFIG"]["'.substr($texp,2).'"]';
					}
					else
						$oexp.='$'.str_replace('.','->',$texp);
			}
		break;
	}

	return $oexp;
}
function evalPartOptimize(&$texp)
{
	$oexp='';
	$maxitems=count($texp);
	for($i=0;$i<$maxitems;$i++)
	{
		if(substr($texp[$i],0,1)=="'")
		{
			$oexp.='parseAndReplaceAll('.$texp[$i].')';
		}
		else
		if(is_numeric($texp[$i]))
		{
			$oexp.=$texp[$i];
		}
		else
		{
			$found=false;
			if($i+1<$maxitems)
			{
				switch($texp[$i+1])
				{
				case '(':
					//we have a call no change or control
					switch($texp[$i])
					{
						case 'and':
							$oexp.=" && ";
							break;
						case 'or':
							$oexp.=" || ";
							break;
						default:
							if(strpos($texp[$i],'.')===false)
								$oexp.=$texp[$i];
							else
							{
								if(substr($texp[$i],0,3)=='fn.')
								{
									$oexp.='$'.str_replace('.','->',substr($texp[$i],3));
								}
								else
								{
									$oexp.='$'.str_replace('.','->',$texp[$i]);
								}
							}
						break;
					}
					$found=true;
					break;
				}
			}
			
			if(!$found)
			{
				switch($texp[$i])
				{
				case '=':
				case '>':
				case '<':
				case '+':
				case '-':
				case '*':
				case '/':
				case '(':
				case ')':
				case ',':
				case '!':
				case '%':
					$oexp.=$texp[$i];
					break;
				case ';':
				case '}':
				case ':':
					$oexp.=$texp[$i]."\n";
					break;
				case '{':
					$oexp.="\n".$texp[$i]."\n";
					break;
				case 'function':
				case 'case':
				case 'for':
				case 'return':
				case 'break':
				case 'else':
				case 'var':
					$oexp.=$texp[$i]." ";
					break;
				case 'and':
					$oexp.=" && ";
					break;
				case 'or':
					$oexp.=" || ";
					break;
				case 'not':
					$oexp.="!";
					break;
				case 'diff':
					$oexp.="!=";
					break;
				case 'class':
					$oexp.="class ".str_replace("."," extends ",$texp[$i+1])."";
					$i++;
					break;
				default:
					$oexp.=solveToken($texp[$i]);
					break;
				}
			}
		}
	}
	$oexp.=";";
	//echo $oexp;
	return $oexp;
}

function evaluateSmartExpression($exp)
{
	$texp=array();
	$mexp=0;
	$texpid=0;
	$marks="=*-+/(),'\r\n\t ;:><{}!%";
	$fc=strcspn($exp,$marks);
	while($fc>=0 && strlen($exp))
	{
		if($fc==0)
		{
			if(trim(substr($exp,0,1))=="'")
			{
				//extract string
				$strend=strpos($exp,"'",1);
				if($strend===false)
				{
					$texp[$mexp]=substr($exp,1);++$mexp;
					$exp='';
				}
				else
				{
					$texp[$mexp]=substr($exp,0,$strend+1);++$mexp;
					$exp=substr($exp,$strend+1);
				}
			}
			else
			{
				$op=trim(substr($exp,0,1));
				$exp=substr($exp,1);
				if($op!='')
				{
					$texp[$mexp]=$op;++$mexp;
				}
			}
		}
		else
		{
			$op=trim(substr($exp,0,$fc));
			if($op!='')
			{
				$texp[$mexp]=$op;++$mexp;
			}
			$exp=substr($exp,$fc);
		}

		$fc=strcspn($exp,$marks);
	}
	
	//evaluate
	return evalPartOptimize($texp);
}

function getCodeFromNomenclator($soc,$grupa,$valoare,$type=0,$paras=array())
{
	$resp="0";
	$url=getUserConfig("nomenclator_url");
	if($url=='')
	{
		global $localcodecall;
		$localcodecall=array();
		$localcodecall['soc']=$soc;
		$localcodecall['grupa']=$grupa;
		$localcodecall['valoare']=$valoare;
		foreach($paras as $kk=>$vv)
		{
			$localcodecall[$kk]=$vv;
		}

		ob_start();
		include("coduri/code.php");
		$resp=ob_get_contents();
		ob_end_clean();
	}
	else
	{
		$newurl=$url."?soc=".urlencode($soc)."&grupa=".urlencode($grupa)."&valoare=".urlencode($valoare);
		foreach($paras as $kk=>$vv)
		{
			$newurl.='&'.$kk.'='.$vv;
		}
		$resp=file_get_contents($newurl);
	}

	if($type!==false)
	{
		$r=explode("*",$resp);
		if(isset($r[$type])) return $r[$type];
	}

	return $resp;
}

function parseForAddress($address,$toup=true)
{
	$address=strtolower($address);
	require_once("config/utils.php");
	$ret=array();
	$ret['str']='';
	$ret['nr']='';
	$ret['bl']='';
	$ret['sc']='';
	$ret['et']='';
	$ret['ap']='';
	$ret['zip']='';
	$ret['raw']=$address;
	
	$delm=" :,.\r\n\t";

	$activ='str';
	$word=strtok($address,$delm);
	while($word)
	{
		$word=strtolower(trim($word));
		$nwords=strtok('');
		switch($word)
		{
		case 'numar':
		case 'numarul':
		case 'nr':
			$activ='nr';
			break;
		case 'bloc':
		case 'blocul':
		case 'bl':
			$activ='bl';
			break;
		case 'apartament':
		case 'apart':
		case 'ap':
			$activ='ap';
			break;
		case 'sc':
		case 'scara':
			$activ='sc';
			break;
		case 'etaj':
		case 'et':
			$activ='et';
			break;
		case 'cod':
		case 'posta':
		case 'postal':
		case 'cp':
		case 'codpostal':
			$activ='zip';
			break;
		case 'romania':
			break;
		case 'piata':
		case 'bulevard';
		case 'bulevardul';
		case 'bld':
		case 'b-dul':
		case 'alee':
		case 'alea':
		case 'al':
		case 'calea':
		case 'cale':
		case 'catun':
		case 'cartier':
			$ret['str'].=$word.' ';
			break;
		case 'sector':
		case 'sect':
			$activ='sector';
			break;
		case 'str':
		case 'strada':
			$activ="str";
			break;
		default:
			if(floatval($word)>0)
			{
				if($activ!="") $ret[$activ]=$word;
				else
				if(strlen($word)==6 || $ret['nr']!="")
					{$ret['zip']=$word;$activ="";}
				else
					{$ret['nr']=$word;$activ="";}
			}
			else
			{
				if($activ=='') $activ='str';
				$ret[$activ].=$word.' ';
				$activ='';
				break;
			}
			//echo "-<br>";
			break;
		}
		$word=strtok($nwords,$delm);
	}
	foreach($ret as $k=>$v)
	{
		$ret[$k]=trim($v);
		if($toup)
		{
			$ret[$k]=strtoupper($v);
		}
	}
	return $ret;
}

function unserialize_startparsing()
{
	global $unser_str;
	if(substr($unser_str,0,1)=="N")
	{
		$unser_str=substr($unser_str,2);
		return '';
	}
	$type=strtok($unser_str,":");
	$ret=false;
	switch($type)
	{
		case 'a':
			$ret=array();
			$count=intval(strtok(':'));
			$unser_str=strtok('');
			$unser_str=substr($unser_str,1);
			for($i=0;$i<$count;$i++)
			{
				$t=unserialize_startparsing();
				$v=unserialize_startparsing();
				$ret[$t]=$v;
			}
		break;
		case 's':
			$ret='';
			$count=intval(strtok(':'));
			$unser_str=strtok('');
			//check bounds
			if(substr($unser_str,0,1)=='"' && substr($unser_str,$count+1,1)=='"')
			{
				//ok
				$ret=substr($unser_str,1,$count);
				$unser_str=substr($unser_str,$count+2);
			}
			else
			{
				//try to recover, search end
				$sp=strpos($unser_str,'";');
				if($sp!==false)
				{
					$ret=substr($unser_str,1,$sp-1);
					$unser_str=substr($unser_str,$sp+1);
				}
				else
				{
				}
			}
		break;
		case 'i':
			$ret=0;
			$ret=intval(strtok(';'));
			$unser_str=strtok('');
		break;
		case 'd':
			$ret=0;
			$ret=floatval(strtok(';'));
			$unser_str=strtok('');
		break;
		case 'N':
			$ret='';
			$unser_str=strtok('');
			break;
	}
	if(substr($unser_str,0,1)==';')
		$unser_str=substr($unser_str,1);
	return $ret;
}

function unserialize_recover($str)
{
	global $unser_str;
	if($str=="") return  false;
	$unser_str=$str;
	//start parsing
	return unserialize_startparsing();
}

?>
