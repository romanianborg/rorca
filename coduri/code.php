<?php
//search for a specific code
$codroot="";
global $cachind_codes;

if(file_exists("authentification.php")) {require_once("authentification.php");}
else if(file_exists("coduri/authentification.php")) {$codroot="coduri/";require_once("coduri/authentification.php");}

if(canUse())
{
	global $localcodecall;
	if($localcodecall && isset($localcodecall['soc']))
	{
		$socname=$localcodecall['soc'];
		$grupa=$localcodecall['grupa'];
		$val=$localcodecall['valoare'];
		$cauta=$localcodecall['cauta'];
		$criteriu=$localcodecall['criteriu'];
		$extratest=$localcodecall['extratest'];
		$prag=$localcodecall['prag'];
		$searchid=$localcodecall['searchid'];
		$lookupfor=$localcodecall['lookupfor'];
		$lookupfor2=$localcodecall['lookupfor2'];
		$lookupvalue=$localcodecall['lkvalue'];
	}
	else
	{
		$socname=$_GET['soc'];
		$grupa=$_GET['grupa'];
		$val=$_GET['valoare'];
		$cauta=$_GET['cauta'];
		$criteriu=$_GET['criteriu'];
		$extratest=$_GET['extratest'];
		$prag=$_GET['prag'];
		$searchid=$_GET['searchid'];
		$lookupfor=$_GET['lookupfor'];
		$lookupfor2=$_GET['lookupfor2'];
		$lookupvalue=$_GET['lkvalue'];
	}
	global $def;
	$def=array();
	$prag=floatval($prag);
	if($prag<=1) $prag=75;
	
	$ok=false;
	switch($socname)
	{
	case 'bcr':
		switch($grupa)
		{
			case 'grupa':
			case 'categorie':
			case 'subcategorie':
			case 'inmatriculare':
			case 'judete':
			case 'marci':
			case 'tippf':
			case 'tippfa':
			case 'tippj':
				$ok=true;
				break;
		}
	break;
	case 'allianz':
		switch($grupa)
		{
			case 'grupa':
			case 'categorie':
			case 'judete':
			case 'marci':
			case 'localitati':
				$ok=true;
			break;
		}
	break;
	case 'carpatica':
		switch($grupa)
		{
			case 'categorie':
			case 'marci':
			case 'tarife':
				$ok=true;
			break;
		}
	break;
	case 'euroins':
		switch($grupa)
		{
			case 'sucursale':
			case 'clasebm':
			case 'categorie':
			case 'tippersoana':
				$ok=true;
			break;
		}
	break;
	case 'tari':
		switch($grupa)
		{
			case 'tari':
				$ok=true;
			break;
		}
	break;
	}
if($ok || $lookupfor!="")
{
	if($lookupfor!="")
	{
		$lookupvalue=strtolower($lookupvalue);
		//search within
		switch($grupa)
		{
			case 'localitati':
				if($lookupvalue!="" && intval(substr($lookupvalue,0,1))==0)
				{
					$l=strlen($lookupvalue);
					$judet=$_GET['lkjudet'];
					$first=true;
					$count=0;
					echo $_GET['jsoncallback'];?>({generator:'coduri',items:[<?php
					if($judet!="")
					{
						include("id.siruta.judete.php");
						$jud=trim(strtolower($judet));
						$judet='';
						$jid=0;
						if($jud=="valcea") $jud="vilcea";
						if($jud=="dambovita") $jud="dimbovita";
						if(isset($codjudet[$jud]))
						{
							$judet=$codjudet[$jud];
							$jid=$judetid[$jud];
						}
						else
						foreach($codjudet as $k=>$v)
						{
							if(strpos($k,$jud)!==false)
							{
								$judet=$v;
								$jid=$judetid[$k];
							}
						}
						include('id.siruta.localitati.'.$jid.'.php');
						foreach($loc as $k=>$siruta)
						{
							if(substr($k,0,$l)==$lookupvalue)
							{
								if(!$first) echo ",";
								echo '{name:"'.trim($k).'",fields:[{field:"'.$lookupfor.'",value:"'.trim(strtoupper($k)).'"}';
								echo ']}';
								$first=false;
								$count++;
								if($count==20) break;
							}
						}
						?>]});<?php
						die();
					}

					include($codroot.'id.allianz.localitati.'.substr($lookupvalue,0,1).'.php');
					if(isset($def[$lookupvalue]))
					{
						$arr=explode("*",$def[$lookupvalue]);
						if($judet=="" || $judet!="" && $arr[1]==$judet)
						{
							if(!$first) echo ",";
							echo '{name:"'.trim($lookupvalue).'",fields:[{field:"'.$lookupfor.'",value:"'.trim(strtoupper($lookupvalue)).'"}';
							if($lookupfor2!="" && $judet=="")
							{
								echo ',{field:"'.$lookupfor2.'",value:"'.trim($arr[0]).'"}';
							}
							echo ']}';
							$first=false;
							$arr=explode("*",$def[$lookupvalue." "]);
							if(isset($def[$lookupvalue." "]) && ($judet=="" || $judet!="" && $arr[1]==$judet))
							{
								if(!$first) echo ",";
								echo '{name:"'.trim($lookupvalue).'",fields:[{field:"'.$lookupfor.'",value:"'.trim(strtoupper($lookupvalue)).'"}';
								if($lookupfor2!="" && $judet=="")
								{
									echo ',{field:"'.$lookupfor2.'",value:"'.trim($arr[0]).'"}';
								}
								echo ']}';
								$arr=explode("*",$def[$lookupvalue."  "]);
								$first=false;
								if(isset($def[$lookupvalue."  "]) && ($judet=="" || $judet!="" && $arr[1]==$judet))
								{
									if(!$first) echo ",";
									echo '{name:"'.trim($lookupvalue).'",fields:[{field:"'.$lookupfor.'",value:"'.trim(strtoupper($lookupvalue)).'"}';
									if($lookupfor2!="" && $judet=="")
									{
										echo ',{field:"'.$lookupfor2.'",value:"'.trim($arr[0]).'"}';
									}
									echo ']}';
									$first=false;
								}
							}
						}
					}
					foreach($def as $k=>$v)
					{
						$arr=explode("*",$v);
						if($judet!="" && $arr[1]!=$judet) continue;
						if(substr($k,0,$l)==$lookupvalue)
						{
							if(!$first) echo ",";
							echo '{name:"'.trim($k).'",fields:[{field:"'.$lookupfor.'",value:"'.trim(strtoupper($k)).'"}';
							if($lookupfor2!="" && $judet=="")
							{
								echo ',{field:"'.$lookupfor2.'",value:"'.trim($arr[0]).'"}';
							}
							echo ']}';
							$first=false;
							$count++;
							if($count==20) break;
						}
					}
					?>]});<?php
				}
			break;
			case 'marci':
				include($codroot.'id.allianz.marci.php');
				echo $_GET['jsoncallback'];?>({generator:'coduri',items:[<?php
				$l=strlen($lookupvalue);
				$first=true;
				$count=0;
				foreach($def as $k=>$v)
				{
					if(substr($k,0,$l)==$lookupvalue)
					{
						if(!$first) echo ",";
						echo '{name:"'.$k.'",fields:[{field:"'.$lookupfor.'",value:"'.strtoupper($k).'"}]}';
						$first=false;
						$count++;
						if($count==10) break;
					}
				}
				if($count<10 && $extratest!="")
				{
					//open db connection
					chdir("..");
					require_once("config/rights.php");
					require_once("config/language.php");
					require_once("config/db.php");

					//specific for this site
					getSiteConfigs();
					global $conn;
					global $_CONFIG;
					$m=create_db_connection();
					$m->openselect("select svalue from settings where suser='marci' and svalue like '".$m->escape($lookupvalue)."%' limit ".(10-$count));
					while(!$m->eof())
					{
						if(!$first) echo ",";
						echo '{name:"'.$m->getvalue("svalue").'",fields:[{field:"'.$lookupfor.'",value:"'.strtoupper($m->getvalue("svalue")).'"}]}';
						$m->movenext();
					}
				}
				?>]});<?php
			break;
			case 'grupa':
				include($codroot.'id.bcr.grupa.php');
				echo $_GET['jsoncallback'];?>({generator:'coduri',items:[<?php
				$l=strlen($lookupvalue);
				$first=true;
				$count=0;
				foreach($def as $k=>$v)
				{
					if(strstr($k,$lookupvalue)!==false)
					{
						if(!$first) echo ",";
						echo '{name:"'.$k.'",fields:[{field:"'.$lookupfor.'",value:"'.strtoupper($k).'"},{field:"codcaen",value:"'.strtoupper($v).'"}]}';
						$first=false;
						$count++;
						if($count==10) break;
					}
				}
				?>]});<?php
			break;
			case 'tari':
				include($codroot.'id.allianz.tari.php');
				echo $_GET['jsoncallback'];?>({generator:'coduri',items:[<?php
				$l=strlen($lookupvalue);
				$first=true;
				$count=0;
				foreach($tari as $k=>$v)
				{
					if(substr($k,0,strlen($lookupvalue))==$lookupvalue)
					{
						if(!$first) echo ",";
						echo '{name:"'.$k.'",fields:[{field:"'.$lookupfor.'",value:"'.strtoupper($k).'"}]}';
						$first=false;
						$count++;
						if($count==10) break;
					}
				}
				?>]});<?php
			break;
		}
	}
	else
	if($searchid!="")
	{
		if(isset($cachind_codes[$codroot.'id.'.$socname.'.'.$grupa]))
		{
			$def=$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa];
		}
		else
		{
			include($codroot.'id.'.$socname.'.'.$grupa.'.php');
			$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa]=$def;
		}
		foreach ($def as $word=>$vvv) {
			$arr=strtok($vvv,"*");
			if($arr==$searchid)
			{
				echo $word;break;
			}
		}
	}
	else
	if($cauta!='')
	{
		if(isset($cachind_codes[$codroot.'id.'.$socname.'.'.$grupa]))
		{
			$def=$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa];
		}
		else
		{
			include($codroot.'id.'.$socname.'.'.$grupa.'.php');
			$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa]=$def;
		}
		$cauta=floatval(trim($cauta));
		foreach ($def as $word=>$vvv) {
			if(strstr($word,$val)!==false && ($criteriu=='' || strstr($word,$criteriu)!==false))
			{
				//echo $word.'<br>';
				$number1='0';
				$number2='0';
				$number3='0';
				$all=array();
				$_v=strtok($word,' -;.,"()[]{}');
				while($_v)
				{
					$all[]=$_v;
					$_v=strtok(' -;.,"()[]{}');
				}
				$peste=false;
				$pana=false;
				foreach($all as $nk=>$nv)
				{
					//echo $nk."<br>";
					if(is_numeric(trim($nv)))
					{
						if($number1=='0') $number1=trim($nv);
						else if($number2=='0') $number2=trim($nv);
						else if($number3=='0') $number3=trim($nv);
					}
					else
					if(trim($nv)=='peste' || trim($nv)=='mare')
					{
						$peste=true;
					}
					else
					if(trim($nv)=='pina' || trim($nv)=='pana' || trim($nv)=='mica')
					{
						$pana=true;
					}
				}
				$number1=floatval($number1);
				$number2=floatval($number2);
				$number3=floatval($number3);
				//echo $cauta.' '.$number1.' '.$number2."<br>";
				$found='';
				if($cauta>0)
				{
					if($peste && $cauta>$number1)
					{
						$found=$vvv;
					}
					else
					if($pana && $cauta<=$number1)
					{
						$found=$vvv;
					}
					else
					if($number1<=$cauta && $cauta<=$number2)
					{
						$found=$vvv;
					}
				}
				else
				{
					$found=$vvv;
				}
				if($found!='')
				{
					if($extratest!='' && $found!='')
					{
						$arr=explode('*',$found);
						if($arr[0]!=$extratest)
						{
							$found='';
						}
						else
						{
							echo $found;break;
						}
					}
					else
					{
						echo $found;break;
					}
				}
			}
		}
	}
	else
	if(strlen($val))
	{
		//check for letter group
		if(file_exists($codroot.'id.'.$socname.'.'.$grupa.'.'.strtolower(substr($val,0,1)).'.php'))
		{
			if(isset($cachind_codes[$codroot.'id.'.$socname.'.'.$grupa.'.'.strtolower(substr($val,0,1))]))
			{
				$def=$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa.'.'.strtolower(substr($val,0,1))];
			}
			else
			{
				include($codroot.'id.'.$socname.'.'.$grupa.'.'.strtolower(substr($val,0,1)).'.php');
				$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa.'.'.strtolower(substr($val,0,1))]=$def;
			}
		}
		else
		{
			if(isset($cachind_codes[$codroot.'id.'.$socname.'.'.$grupa]))
			{
				$def=$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa];
			}
			else
			{
				include($codroot.'id.'.$socname.'.'.$grupa.'.php');
				$cachind_codes[$codroot.'id.'.$socname.'.'.$grupa]=$def;
			}
		}
		if(isset($def[$val]))
		{
			echo $def[$val];
		}
		else
		{
			//search a similar one
			$input = $val;
			$shortest = -1;
			foreach ($def as $word=>$vvv) {
				 $lev = similar_text($input, $word,$proc);
				 if ($proc >= 99.99) {//100%
					$closest = $word;
					$shortest = 0;
					break;
				 }
				 if ($proc >= $shortest && $proc>=$prag) {
					$closest  = $word;
					$shortest = $proc;
				}
			}
			if($shortest>=$prag)
			{
				if(isset($def[$closest]))
				{
					echo $def[$closest];
				}
				else
				{
					if(isset($def['altele']))
					{
						echo $def['altele'];
					}
				}
			}
			else
			{
				if(isset($def['altele']))
				{
					echo $def['altele'];
				}
			}
		}
	}
	else echo "0";
}
else echo "0";
}
else echo "0";
?>
