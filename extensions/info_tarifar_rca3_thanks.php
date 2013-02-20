<input type="hidden" name="action" value="PlataOk">
<input type="hidden" name="textbutton" value="Multumim!">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<?php
	require_once("extensions/process_offer_ws.php");
	$date=ws_process("InfoOferta",intval($_GET['offid']));
?>
<input type="hidden" name="tipoferta" value="<?php echo $date['tipoferta']['VALUE'];?>">
<?php 
	if(isset($date['ipnamount']['VALUE']) && $date['ipnamount']['VALUE']!="")
	{
?><div class="workstep"><div class=workfields style="width:295px;">
Plata dumneavoastra a fost inregistrata
<br><br>
Valoare: <b><?php echo $date['ipnamount']['VALUE'];?></b><br>
Oferta: <b><?php echo intval($_GET['offid']);?></b><br>
Mesaj: <b><?php echo $date['ipnmessage']['VALUE'];?></b><br><br>
<?php
		echo getUserConfig("mesaj_multumire");
		?></div></div><?php
	}
?>

<?php 
	if(isset($date['politafinalizata']['VALUE']) && $date['politafinalizata']['VALUE']=="true")
	{
		if(isset($date['politaid']['VALUE']) && intval($date['politaid']['VALUE']))
		{
			//polite
?><div class="workstep"><div class=workfields style="width:295px;">
Polita dumneavoastra este emisa. Puteti descarca o copie de aici: <a href="site.php?t=polita&offid=<?php echo intval($_GET['offid']);?>">Polita</a>
</div></div>
<?php
		}
		else
		{
?><div class="workstep"><div class=workfields style="width:295px;"><?php
			echo getUserConfig("mesaj_eroare");
?></div></div><?php
		}
	}
	else
	{
		//wait for more
?>
<div class="workstep"><div class=workfields style="width:295px;">
<span id="loadingpolitaimg"><img src="images/ajax-loader.gif">Acum incerc sa emit polita</span>
<br>
<span id="loadingpolitamesaj" style="display:none;">
Polita dumneavoastra s-a emisa. Puteti descarca o copie de aici: <a href="site.php?t=polita&offid=<?php echo intval($_GET['offid']);?>">Polita</a>
</span>
<span id="loadingpolitaeroare" style="display:none;"><?php
	echo getUserConfig("mesaj_eroare");
	?></span>
	<div style="height:1px;"><div id="offpolita"><a class="incarcapolita" href="site.php?PolitaOferta=<?php echo intval($_GET['offid']);?>"></a></div></div>
</div></div>
<?php
	}
?>

