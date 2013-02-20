<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2006

require_once("config/language.php");
global $unique_id;
function default_table($ident,$values,$lang,$required,$title,$action=0,$colsno=0)
{
	if($title) {?><FIELDSET id="<?php echo $ident;?>_fs"><legend><?php echo $title?></legend><?php }?>
	<?php $path=getFilePathFor('help',$ident);
	if($path!='' && file_exists($path)){global $unique_id;++$unique_id;require_once("config/layers.php");?>
	<input type=image class=helpbutton onclick="javascript:toggleLayer('div_<?php echo $unique_id?>');return false;" src="images/ask.png">
	<DIV ID="div_<?php echo $unique_id?>" STYLE="display:none;position:relative;visibility:hidden;" class=helptext><table border=0><tr><td><?php include($path);?></table></div>
	<?php }
	$titles=0;
	$cols=0+$colsno;
	$tablestarted2=false;
	$tablestarted=false;$fieldsetstarted=false;
	foreach($values as $key=>$val)
	{
		if(strtok($val,"\n\r\t ")=="__title__")
		{
			if($cols && !$tablestarted2) {?><table><?php $tablestarted2=true;}
			if($tablestarted) {?></table><?php $tablestarted=false;}
			if($fieldsetstarted) {?></FIELDSET><?php $fieldsetstarted=false;}
			if($cols && $titles%$colsno==0) {?><tr><?php }
			$titles++;
			if($cols) {?><td valign=top><?php }
		?><FIELDSET id="<?php echo $key;?>_fs">
		<legend><?php  if(isset($lang[$key]) && $lang[$key]!="") echo getLT($lang[$key]); else echo getLT($key,'',$ident);?></legend>
		<table width=100% height=100%>
		<?php $tablestarted=true;$fieldsetstarted=true;}else{ if(!$tablestarted) {?><table><?php $tablestarted=true;}
	?>
		<tr><th align=right valign=top width="50%"><?php  if(isset($lang[$key]) && $lang[$key]!="") echo getLT($lang[$key]); else echo getLT($key,'',$ident);if($lang[$key]!="wblank" && isset($required[$key])) {?><span class=requ> (*)</span><?php }?><td align=left><?php echo $val?>
	<?php }
	}
	if($tablestarted) {?></table><?php $tablestarted=false;}
	if($fieldsetstarted) {?></FIELDSET><?php $fieldsetstarted=false;}
	?><table>
	<?php
	if($action) {?><tr><td colspan="<?php if($colsno==0) echo "2";else echo 2*$colsno;?>"><input type=submit class="formaction" value="<?php echo $action?>">&nbsp;<input type=submit onclick="this.form._canceled=true;" name=cancel_button class="formaction" value="<?php echo getLT('cancel','',$ident);?>"><?php }?>
	<?php
	if($cols && $tablestarted2) {?></table><?php }
	?>
	</table>
	<?php
	if($title) {?></FIELDSET><?php }
}
function default_externtable($ident,$values,$lang,$required,$title,$action=0)
{?>	<table >
<?php
	foreach($values as $key=>$val)
	{
		if(strtok($val,"\n\r\t ")=="__title__")
		{?>
		<tr><th><th align=left><?php  if(isset($lang[$key]) && $lang[$key]!="") echo getLT($lang[$key]); else echo getLT($key,'',$ident);?>
		<?php }else{
	?>
		<tr><th align=right width=30%><?php  if(isset($lang[$key]) && $lang[$key]!="") echo getLT($lang[$key]); else echo getLT($key,'',$ident);if(isset($required[$key])) {?><span class=requ> (*)</span><?php }?><td><?php echo $val?>
	<?php }
	}
?></table><?php
}

function default_listitem($ident,$values,$lang,$number=0)
{
?>
	<tr>
	<?php
	foreach($values as $key=>$val)
	{
	?>
		<td class="td<?php echo $number%2+1?>"><?php echo $val?>
	<?php
	}
	?>
<?php
}
function default_treeitem($ident,$values,$lang,$number=0,$level=0)
{
?>
	<tr><?php
	$first=1;
	foreach($values as $key=>$val)
	{
		?><td class="td<?php echo $number%2+1?>">
		<?php if($first && $key!="selection") {$first=0;
		echo str_repeat("&nbsp;--&gt;",$level);} echo $val;
	}
}
function default_menu($values,$lang)
{
	$first=true;
	foreach($values as $key=>$val)
	{
		if($val!="")
		{
			if(!$first)
			{
				echo " | ";
			}
			echo $val;
			$first=false;
		}
	}
}
function default_vmenu($values,$lang)
{
	$first=true;
	foreach($values as $key=>$val)
	{
		if($val!="")
		{
			if(!$first)
			{
				echo "<br />";
			}
			echo $val;
			$first=false;
		}
	}
}
?>
