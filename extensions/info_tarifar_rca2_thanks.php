
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
ob_start();
?>
<link href="extern/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script scr="extern/bootstrap/js/bootstrap.min.js"></script>
<script>

var validatorivehicul={};

punemarcaje=function(ctrl,valid)
{
	$(ctrl).css('border-color','lightblue');
	$(ctrl).parent().find('i').remove();
	if(!valid)
	{
		$(ctrl).css('border-color','red');
		$(ctrl).parent().find('span').slice(0,1).prepend('<i class="icon-question-sign" />');
	}
	validatorivehicul[$(ctrl).attr("name")]=valid;
	var maxa=0;
	var maxg=0;
	for(var a in validatorivehicul)
	{
		if(!isElementVisible($("[name="+a+"]"))) continue;
		if(validatorivehicul[a]) maxg++;
		maxa++;
	}
	$(".bar").css("width",maxg/maxa*100+'%');
	
	if(typeof(Storage)!=="undefined")
	{
		if(valid)
		{
			localStorage['t_'+$(ctrl).attr("name")]=$(ctrl).val();
		}
	}

};
</script>
<?php
include("extensions/info_css_base2.php");
cache_addvalue("finalhead",ob_get_contents());ob_end_clean();
?>

<div class="container">
<div class="row">
<div class="span12">

			<div id="steps">
				
				<a class="step-1" href="#" onclick="return false;" title="Completeaza formularul" style="opacity: 0.3; ">
					<span>Completeaza</span><br />  formularul
				</a>
				<a class="step-2" href="#" onclick="return false;" title="Alege oferta" style="opacity: 0.3; ">
					<span>Alege</span><br />   oferta
				</a>
				<a class="step-3" href="#" onclick="return false;" title="Cumpara RCA" >
					<span>Cumpara</span><br />   RCA
				</a>
				
			</div>
</div>
</div>

<div class="row">
<div class="span12">
			<h3 class="box-title">Mesaje utile</h3>
			
			<div class="box" id="box-proprietar">
				<div class="icon">&nbsp;</div>

<?php 
	if(isset($date['ipnamount']['VALUE']) && $date['ipnamount']['VALUE']!="")
	{
?><div class="row"><div class="span10">
	<span class="text-success">
Plata dumneavoastra a fost inregistrata
<br><br>
Valoare: <b><?php echo $date['ipnamount']['VALUE'];?></b><br>
Oferta: <b><?php echo intval($_GET['offid']);?></b><br>
Mesaj: <b><?php echo $date['ipnmessage']['VALUE'];?></b><br><br>
<?php
		echo getUserConfig("mesaj_multumire");
		?></span></div></div><?php
	}
?>

<?php 
	if(isset($date['politafinalizata']['VALUE']) && $date['politafinalizata']['VALUE']=="true")
	{
		if(isset($date['politaid']['VALUE']) && intval($date['politaid']['VALUE']))
		{
			//polite
?><div class="row"><div class="span10 offset1">
	<span class="text-success">
	Polita dumneavoastra este emisa. Puteti descarca o copie de aici: <a href="site.php?t=polita&offid=<?php echo intval($_GET['offid']);?>">Polita</a>
	</span>
</div></div>
<?php
		}
		else
		{
?><div class="row"><div class="span10 offset1">
	<span class="text-info">
<?php
			if(isset($date['ipnamount']['VALUE']) && $date['ipnamount']['VALUE']!="")
				echo getUserConfig("mesaj_plata");
			else
				echo getUserConfig("mesaj_eroare");
?></span>
</div></div><?php
		}
	}
	else
	{
		//wait for more
?>
<div class="row"><div class="span9 offset1">
<span id="loadingpolitaimg"><img src="images/ajax-loader.gif">Acum incerc sa emit polita</span>
<br>
<span id="loadingpolitamesaj" style="display:none;">
Polita dumneavoastra s-a emisa. Puteti descarca o copie de aici: <a href="site.php?t=polita&offid=<?php echo intval($_GET['offid']);?>">Polita</a>
</span>
<span id="loadingpolitaeroare" style="display:none;"><?php
		if(isset($date['ipnamount']['VALUE']) && $date['ipnamount']['VALUE']!="")
			echo getUserConfig("mesaj_plata");
		else
			echo getUserConfig("mesaj_eroare");
	?></span>
	<div style="height:1px;"><div id="offpolita"><a class="incarcapolita" href="site.php?PolitaOferta=<?php echo intval($_GET['offid']);?>"></a></div></div>
</div></div>
<?php
	}
?>
		</div><!-- box -->
			<div class="box-footer"  style="margin-bottom:50px;">&nbsp;</div>

</div>
</div>

</div><!-- container -->


