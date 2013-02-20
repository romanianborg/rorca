<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2011
if(!function_exists("includeTimeline"))
{
require_once("extern/adodb-time.php");

function includeTimeline()
{?>
<link rel='stylesheet' href='extern/timeline/styles.css' type='text/css' />
<script src="extern/timeline/api/timeline-api.js" type="text/javascript"></script>
<?php
}
function showDate($date,$format='')
{
	if($format=='') $format=getLT("dateformat");
	if($date!="")
	if($date!="0000-00-00")
	{
		if($date!="0000-00-00 00:00:00")
		{
			if(substr($date,4,1)!="-")
			{
				$date=substr($date,0,4)."-".substr($date,4,2)."-".substr($date,6,2);
			}
			
			if($format=='')
				$format='daily';
			switch($format)
			{
				case '%e/%m/%Y':
				case 'au':
				case 'dd/MM/yyyy':
					$ra=explode(" ", $date);
					$ta=explode("-", $ra[0]);
					return $ta[2]."/".$ta[1]."/".$ta[0];
				break;
				case '%m/%e/%Y':
				case 'monthly':
				case 'mm':
				case 'en':
				case 'MM/dd/yyyy':
					$ra=explode(" ", $date);
					$ta=explode("-", $ra[0]);
					return $ta[1]."/".$ta[2]."/".$ta[0];
				break;
				case '%e.%m.%Y':
				case 'daily':
				case 'dd':
				case 'ro':
				case 'dd.MM.yyyy':
					$ra=explode(" ", $date);
					$ta=explode("-", $ra[0]);
					return $ta[2].".".$ta[1].".".$ta[0];
				case 'time':
					if($date!="")
					{
						$ra=explode(" ", $date);
						$ta=explode("-", $ra[0]);
						if(isset($ra[1]))
						{
							$ma=explode(":", $ra[1]);
							$time=adodb_mktime($ma[0],$ma[1],$ma[2],$ta[1],$ta[2],$ta[0]);
						}
						else
						$time=adodb_mktime(0,0,0,$ta[1],$ta[2],$ta[0]);
						return $time;
					}
					return 0;

					break;
				default:
					echo "Date format not inplemented: ".$format;
					exit();
				break;
			}
		}
	}
	if($format=="time")
		return 0;

	return '';
}

function showTime($date,$nosecs='',$pm='')
{
	$indate=explode(" ", $date);
	if($nosecs=='')
	{
		$hourArr=explode(":", $indate[1]);
		if($pm!="")
		{
			if(intval($hourArr[0])>12)
				$ret=(intval($hourArr[0])-12).":".$hourArr[1]." PM";
			else
				$ret=$hourArr[0].":".$hourArr[1]." AM";
		}
		else
		{
			$ret=$hourArr[0].":".$hourArr[1];
		}
	}
	else
	{
		$ret=$indate[1];
	}
	return $ret;
}
function showDateTime($date,$format,$nosecs='')
{
	if($date!="")
	if($date!="0000-00-00")
	{
		if($date!="0000-00-00 00:00:00")
		{
			if(substr($date,4,1)!="-")
			{
				$date=substr($date,0,4)."-".substr($date,4,2)."-".substr($date,6,2)." ".substr($date,8,2).":".substr($date,10,2).":".substr($date,12,2);
			}
			if($format=='')
				$format='daily';
			switch($format)
			{
				case '%e/%m/%Y':
				case 'au':
				case 'dd/MM/yyyy':
					$indate=explode(" ", $date);
					$dateArr=explode("-", $indate[0]);
					$ret=$dateArr[2]."/".$dateArr[1]."/".$dateArr[0];
					if($nosecs=='')
					{
						$hourArr=explode(":", $indate[1]);
						$ret.=" ".$hourArr[0].":".$hourArr[1];
					}
					else
					{
						$ret.=" ".$indate[1];
					}
					return $ret;
				break;				
				case '%m/%e/%Y':
				case 'monthly':
				case 'MM/dd/yyyy':
					$indate=explode(" ", $date);
					$dateArr=explode("-", $indate[0]);
					$ret=$dateArr[1]."/".$dateArr[2]."/".$dateArr[0];
					if($nosecs=='')
					{
						$hourArr=explode(":", $indate[1]);
						$ret.=" ".$hourArr[0].":".$hourArr[1];
					}
					else
					{
						$ret.=" ".$indate[1];
					}
					return $ret;
				break;
				case '%e.%m.%Y':
				case 'daily':
				case 'dd.MM.yyyy':
					$indate=explode(" ", $date);
					$dateArr=explode("-", $indate[0]);
					$ret=$dateArr[2].".".$dateArr[1].".".$dateArr[0];
					if(isset($indate[1]))
					{
						if($nosecs=='')
						{
							$hourArr=explode(":", $indate[1]);
							$ret.=" ".$hourArr[0].":".$hourArr[1];
						}
						else
						{
							$ret.=" ".$indate[1];
						}
					}
					return $ret;
				break;
				case 'time':
					$indate=explode(" ", $date);
					$minArr=explode(":", $indate[1]);
					if(isset($indate[0]) && $indate[0]=='0000-00-00')
					{
						$time=adodb_mktime($minArr[0],$minArr[1],$minArr[2],1,1,2000) - adodb_mktime(0,0,0,1,1,2000);
						return $time;
					}
					$dateArr=explode("-", $indate[0]);
					if(!isset($minArr[2])) $minArr[2]=0;
					$time=adodb_mktime($minArr[0],$minArr[1],$minArr[2],$dateArr[1],$dateArr[2],$dateArr[0]);
					return $time;
					break;
				case 'gregorian':
					$indate=explode(" ", $date);
					$dateArr=explode("-", $indate[0]);
					$minArr=explode(":", $indate[1]);
					$time=adodb_mktime($minArr[0],$minArr[1],$minArr[2],$dateArr[1],$dateArr[2],$dateArr[0]);
					return adodb_date("r",$time);
				break;
				default:
					session_addvalue("error","Unknown date format: ".$format);
				break;
			}
		}
	}
	return '';
}

function getDateForMysql($date,$format)
{
	$date=trim($date);
	if(''.$date!='')
	{
		switch($format)
		{
			case '%e/%m/%Y':
			case 'au':
			case 'dd/MM/yyyy':
				$ta=explode("/", $date);
				if(intval(trim($ta[2]))<100) $ta[2]="".(2000+trim($ta[2]));
				return str_pad(trim(substr($ta[2],0,4)),4,"0",STR_PAD_LEFT)."-".str_pad(trim($ta[1]),2,"0",STR_PAD_LEFT)."-".str_pad(trim($ta[0]),2,"0",STR_PAD_LEFT);
			break;
			case '%m/%e/%Y':
			case 'MM/dd/yyyy':
				$ta=explode("/", $date);
				if(intval(trim($ta[2]))<100) $ta[2]="".(2000+trim($ta[2]));
				return str_pad(trim(substr($ta[2],0,4)),4,"0",STR_PAD_LEFT)."-".str_pad(trim($ta[0]),2,"0",STR_PAD_LEFT)."-".str_pad(trim($ta[1]),2,"0",STR_PAD_LEFT);
			break;
			case '%e.%m.%Y':
			case 'dd.MM.yyyy':
				$ta=explode(".", $date);
				if(intval(trim($ta[2]))<100) $ta[2]="".(2000+trim($ta[2]));
				return str_pad(trim(substr($ta[2],0,4)),4,"0",STR_PAD_LEFT)."-".str_pad(trim($ta[1]),2,"0",STR_PAD_LEFT)."-".str_pad(trim($ta[0]),2,"0",STR_PAD_LEFT);
			break;
			case 'time':
				return adodb_date("Y-m-d",$date);
			break;
			default:
				session_addvalue("error","Unknown date format: ".$format);
			break;
		}
	}
	return '';
}
function getDateTimeForMysql($date,$format)
{
	$date=trim($date);
	switch($format)
	{
		case '%e/%m/%Y':
		case 'dd/MM/yyyy':
			$t=explode(" ", $date);
			$ta=explode("/", $t[0]);
			$ret=trim($ta[2])."-".trim($ta[1])."-".trim($ta[0])." ".trim($t[1]);
			return $ret;
		break;
		case '%m/%e/%Y':
		case 'MM/dd/yyyy':
			$t=explode(" ", $date);
			$ta=explode("/", $t[0]);
			$ret=trim($ta[2])."-".trim($ta[0])."-".trim($ta[1])." ".trim($t[1]);
			return $ret;
		break;
		case '%e.%m.%Y':
		case 'dd.MM.yyyy':
			$t=explode(" ", $date);
			$ta=explode(".", $t[0]);
			$ret=trim($ta[2])."-".trim($ta[1])."-".trim($ta[0])." ".trim($t[1]);
			return $ret;
		break;
		case 'time':
			return adodb_date("Y-m-d H:i:s",intval($date));
		default:
			echo "Unknown date format: ".$format;
		break;
	}
	return '';
}
function days_between($fyear, $fmonth, $fday, $tyear, $tmonth, $tday)
{
  return round((adodb_mktime( 0, 0, 0, $fmonth, $fday, $fyear) - adodb_mktime( 0, 0, 0, $tmonth, $tday, $tyear))/(60*60*24));
}
function add_days($date,$days,$format)
{
	$timeday=0;
	switch($format)
	{
		case '%e/%m/%Y':
		case 'dd/MM/yyyy':
			if($date=="") return "00/00/0000";
			$ta=explode("/", $date);
			$timeday=adodb_mktime(0,0,0,$ta[1],$ta[0],$ta[2]);
			if(!$timeday) return "00/00/0000";
			$timeday+=$days*24*60*60+60*60;
			return strftime("%d/%m/%Y",$timeday);
		break;
		case '%m/%e/%Y':
		case 'MM/dd/yyyy':
			if($date=="") return "00/00/0000";
			$ta=explode("/", $date);
			$timeday=adodb_mktime(0,0,0,$ta[0],$ta[1],$ta[2]);
			if(!$timeday) return "00/00/0000";
			$timeday+=$days*24*60*60+60*60;
			return strftime("%m/%d/%Y",$timeday);
		break;
		case '%e.%m.%Y':
		case 'dd.MM.yyyy':
			if($date=="") return "00.00.0000";
			$ta=explode(".", $date);
			$timeday=adodb_mktime(0,0,0,$ta[1],$ta[0],$ta[2]);
			if(!$timeday) return "00/00/0000";
			$timeday+=$days*24*60*60+60*60;
			return strftime("%d.%m.%Y",$timeday);
		break;
		case 'db':
			if($date=="") return "0000-00-00";
			$ta=explode("-", $date);
			$timeday=adodb_mktime(0,0,0,$ta[1],$ta[2],$ta[0]);
			if(!$timeday) return "0000-00-00";
			$timeday+=$days*24*60*60+60*60;
			return strftime("%Y-%m-%d",$timeday);
		break;
		default:
			echo "Unknown date format: ".$format;
			exit();
	}
}
function timediff($date1,$date2,$format,$nosecs='')
{
	$indate1=explode(" ", $date1);
	$dateArr1=explode("-", $indate1[0]);
	if(!isset($indate1[1])) $indate1[1]="00:00:00";
	$hourArr1=explode(":", $indate1[1]);

	$indate2=explode(" ", $date2);
	$dateArr2=explode("-", $indate2[0]);
	if(!isset($indate2[1])) $indate2[1]="00:00:00";
	$hourArr2=explode(":", $indate2[1]);

	if(isset($hourArr2[0]) && isset($hourArr1[0]))
		$ret['hours']=(Int)$hourArr2[0]-(Int)$hourArr1[0];
	else
		$ret['hours']=0;
	if(isset($hourArr2[1]) && isset($hourArr1[1]))
		$ret['mins']=(Int)$hourArr2[1]-(Int)$hourArr1[1];
	else
		$ret['mins']=0;
	if(isset($hourArr2[2]) && isset($hourArr1[2]))
		$ret['secs']=(Int)$hourArr2[2]-(Int)$hourArr1[2];
	else
		$ret['secs']=0;

	$ret['days']=days_between((Int)$dateArr2[0],(Int)$dateArr2[1],(Int)$dateArr2[2],(Int)$dateArr1[0],(Int)$dateArr1[1],(Int)$dateArr1[2]);

	if($ret['secs']<0 && ($ret['mins'] || $ret['hours'] || $ret['days'])) {$ret['mins']--;$ret['secs']+=60;}
	if($ret['mins']<0 && ($ret['hours'] || $ret['days'])) {$ret['hours']--;$ret['mins']+=60;}
	if($ret['hours']<0 && $ret['days']) {$ret['days']--;$ret['hours']+=24;}

	if($ret['secs']>=60) {$ret['mins']++;$ret['secs']-=60;}
	if($ret['mins']>=60) {$ret['hours']++;$ret['mins']-=60;}
	if($ret['hours']>=24) {$ret['days']++;$ret['hours']-=24;}

	return $ret;
}
function timediffsecs($ret)
{
	$secs=0;
	$secs+=$ret['days']*24*60*60;
	$secs+=$ret['hours']*60*60;
	$secs+=$ret['mins']*60;
	$secs+=$ret['secs'];
	return $secs;
}

function showTimeInterval($date1,$date2,$format,$nosecs='')
{
	$diff=timediff($date1,$date2,$format,$nosecs);
	$ret="";
	if($diff['hours']) $ret.=" ".$diff['hours'].' '.getLT('hours');
	if($diff['mins']) $ret.=" ".$diff['mins'].' '.getLT('minutes');
	if($diff['secs'] && $nosecs=="") $ret.=" ".$diff['secs'].' '.getLT('seconds');

	$ret2=showTime($date1,$nosecs)."-".showTime($date2,$nosecs)." (".$ret.")";

	return $ret2;
}
function showInterval($date1,$date2,$format,$nosecs='')
{
	$diff=timediff($date1,$date2,$format,$nosecs);

	$ret="";
	if($diff['days']) $ret=$diff['days'].' '.getLT('days');
	if($diff['hours']) $ret.=" ".$diff['hours'].' '.getLT('hours');
	if($diff['mins']) $ret.=" ".$diff['mins'].' '.getLT('minutes');
	if($diff['secs'] && $nosecs=="yes") $ret.=" ".$diff['secs'].' '.getLT('seconds');

	$indate1=explode(" ", $date1);
	$dateArr1=explode("-", $indate1[0]);
	$hourArr1=explode(":", $indate1[1]);

	$indate2=explode(" ", $date2);
	$dateArr2=explode("-", $indate2[0]);
	$hourArr2=explode(":", $indate2[1]);

	if($date2=='0000-00-00 00:00:00') $ret="";
	if($date1=='0000-00-00 00:00:00') $ret="";
	if($ret=="")
		$ret=getLT('amoment');

	$ret2="";
	if($indate1[0]==$indate2[0] && $indate1[0]!="0000-00-00")
	{
		$ret2=showDate($indate1[0],$format);
		if($nosecs=='')
		{
			$ret2.=" ".$hourArr1[0].":".$hourArr1[1]."-".$hourArr2[0].":".$hourArr2[1];
		}
		else
		{
			$ret2.=" ".$indate1[1]."-".$indate2[1];
		}
	}
	else
	{
		$t1=showDateTime($date1,$format,$nosecs);
		$t2=showDateTime($date2,$format,$nosecs);
		$ret2.=$t1;
		if($t1!="" && $t2!="") $ret2.="[-]";
		$ret2.=$t2;
	}

	$ret2.=" (".$ret.")";

	return $ret2;
}
function showDays($date1,$date2,$format)
{
	$dateArr1=explode("-", $date1);
	$dateArr2=explode("-", $date2);

	$days=days_between((Int)$dateArr2[0],(Int)$dateArr2[1],(Int)$dateArr2[2],(Int)$dateArr1[0],(Int)$dateArr1[1],(Int)$dateArr1[2]);

	$ret=showDate($date1,$format);
	$ret.='[-]'.showDate($date2,$format);

	$ret.=' ('.($days+1).' '.getLT('days').')';

	return $ret;
}
}
?>
