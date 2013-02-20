<?php
/**
* English number speller (PHP 4 or greater)
*
* @param string $number a string representing a positive, integral number with 15 digits or less
* @return string|false the spelled out number in English, or false if the number is invalid
* @author {@link http://www.lesantoso.com Lucky E. Santoso} <lesantoso@yahoo.com>
* @copyright Copyright (c) 2006 Lucky E. Santoso
* @license http://opensource.org/licenses/gpl-license.php The GNU General Public License (GPL)
*/  
function spellNumberInEnglish ($number) {
	$number = strval($number);
	$ones = array("", "one", "two", "three", "four", 
		"five", "six", "seven", "eight", "nine");
	$teens = array("ten", "eleven", "twelve", "thirteen", "fourteen", 
		"fifteen", "sixteen", "seventeen", "eighteen", "nineteen");
	$tens = array("", "", "twenty", "thirty", "forty", 
		"fifty", "sixty", "seventy", "eighty", "ninety");
	$majorUnits = array("", "thousand", "million", "billion", "trillion");
	$result = "";
	$isAnyMajorUnit = false;
	$length = strlen($number);
	for ($i = 0, $pos = $length - 1; $i < $length; $i++, $pos--) {
		if ($number{$i} != '0') {
			if ($pos % 3 == 0)
				$result .= $ones[$number{$i}] . ' ';
			else if ($pos % 3 == 1) {
			if ($number{$i} == '1') {
				$result .= $teens[$number{$i + 1}] . ' ';
				$i++; $pos--;
			} else {
				$result .= $tens[$number{$i}];
				$result .= $number{$i + 1} == '0'? ' ' : '-';
				}
			} else 
			$result .= $ones[$number{$i}] . " hundred ";
			$isAnyMajorUnit = true;
		}
		if ($pos % 3 == 0 && $isAnyMajorUnit) {
			$result .= $majorUnits[$pos / 3] . ' ';
			$isAnyMajorUnit = false;
		}
	}
	trim($result);
	if ($result == "") $result = "zero";
	return($result);
}

function spellNumberInRomanian ($number) {
	$number = strval($number);
	if(strpos($number,".")>0)
	{
		$zecimale=substr($number,strpos($number,".")+1);
		$number=substr($number,0,strpos($number,"."));
		if(strlen($zecimale)<2) $zecimale.='0';
		if(strlen($zecimale)<2) $zecimale.='0';
		if(strlen($zecimale)<2) $zecimale.='0';
	}
	$result = "";
	$length = strlen($number);
	$ones = array("", "unu", "doi", "trei", "patru", 
		"cinci", "sase", "sapte", "opt", "noua");
	$onesf = array("", "o", "doua", "trei", "patru", 
		"cinci", "sase", "sapte", "opt", "noua");
	$zeci = array("", "o", "douazeci", "treizeci", "patruzeci", 
		"cincizeci", "saizeci", "saptezeci", "optzeci", "nouazeci");
	$spre = array("zece", "unsprezece", "doisprezece", "treisprezece", "paisprezece", 
		"cincisprezece", "saisprezece", "saptesprezece", "optsprezece", "nouasprezece");
	$gr = array("", "mii", "milioane", "miliarde", "trilioane");
	$grsing = array("", "omie", "unmilion", "unmiliard", "untrilion");
	//echo $length;echo "<br>";
	$grpos=0;
	$grcur=ceil($length/3)-1;
	$grupari=array();
	for($pos=$length-1;$pos>=0;$pos--)
	{
		$grupari[$grcur]=substr($number,$pos,1).$grupari[$grcur];

		$grpos++;
		if($grpos>2){$grpos=0;$grcur--;}
	}
	$grs=ceil($length/3);
	for($i=0;$i<$grs;$i++)
	{
		if(strlen($grupari[$i])<3) $grupari[$i]="0".$grupari[$i];
		if(strlen($grupari[$i])<3) $grupari[$i]="0".$grupari[$i];
		$val=intval($grupari[$i]);
		switch($val)
		{
		case '0':
			break;
		case '1':
			$result.=$grsing[$grs-$i-1];
			break;
		default:
			if(intval(substr($grupari[$i],0,1))>0)
			{
				$result.=$onesf[intval(substr($grupari[$i],0,1))];
				if(intval(substr($grupari[$i],0,1))==1)
				{
					$result.="suta";
				}
				else
				{
					$result.="sute";
				}
			}
			if(intval(substr($grupari[$i],1,1))>1)
			{
				$result.=$zeci[intval(substr($grupari[$i],1,1))];
				if(intval(substr($grupari[$i],2,1))>0)
				{
					$result.='si'.$ones[intval(substr($grupari[$i],2,1))];
				}
			}
			else
			if(intval(substr($grupari[$i],1,1))>0)
			{
				$result.=$spre[intval(substr($grupari[$i],2,1))];
			}
			else
			{
				if(intval(substr($grupari[$i],2,1))>0)
				{
					$result.=$ones[intval(substr($grupari[$i],2,1))];
				}
			}
			$result.=$gr[$grs-$i-1];
			break;
		}
	}
	trim($result);
	if ($result == "") $result = "zero";
	
	if(intval($number)==0)
	{
		$result = "zerolei";
	}
	else
	if(intval($number)==1)
	{
		$result = "unleu";
	}
	else
	{
		$result .= "lei";
	}
	if(intval($zecimale)>0)
	{
		if(intval($zecimale)==1)
		{
			$result.="si1ban";
		}
		else
		if(intval($zecimale)==0)
		{
		}
		else
		{
			$result.="si".$zecimale."bani";
		}
	}
	return($result);
}

function spellNumber($number,$lang='en')
{
	switch($lang)
	{
		case 'ro':
			return spellNumberInRomanian($number);
	}
	return spellNumberInEnglish($number);
}
?>
