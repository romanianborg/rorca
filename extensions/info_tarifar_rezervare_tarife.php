<div id="worksteps">

<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<input type="hidden" name="tipoferta" value="rezervare">
<?php
	require_once("extensions/process_offer_ws.php");
	$date=ws_process("InfoOferta",intval($_GET['offid']));
	$pin=md5(getUserConfig("sitepin")."-".intval($_GET['offid']));

	if(isset($_GET['motiv']) && $_GET['motiv']=="neconfirmare")
	{
		if($pin!=$_GET["pin"])
		{
		?>
<input type="hidden" name="action" value="PlataOk">
<input type="hidden" name="textbutton" value="Eroare pin">
<div class="work_col1">

<div class="biglabel"><img src="images/x.png" border=0> Eroare Pin</div>

<div class="workstep"><div class=workfields style="width:295px;height:auto;">Linkul nu este valabil, va rugam sa raportati eroarea.
</div></div>

</div>
		<?php
		}
		else
		{
		?>
<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Nu avem camere libere">
<input type="hidden" name="ofertastatus" value="2">

<div class="work_col1">

<div class="biglabel"><img src="images/x.png" border=0> REZERVARE</div>

<div class="workstep"><div class=workfields style="width:295px;height:auto;">Va rugam sa specificati motivul.
</div></div>


</div>

<div class="work_col2">
<div class="biglabel"><img src="images/x.png" border=0> NECONFIRMARE</div>

<div class="workstep"><div class="worklabel">Motiv:</div><div class=workfields style="height:auto;"><textarea name="mentiuni_host"></textarea>
</div></div>

</div><!-- col2-->

		<?php
		}
	}
	else
	if(isset($_GET['motiv']) && $_GET['motiv']=="confirmare")
	{
		if($pin!=$_GET["pin"])
		{
		?>
<input type="hidden" name="action" value="PlataOk">
<input type="hidden" name="textbutton" value="Eroare pin">
<div class="work_col1">

<div class="biglabel"><img src="images/x.png" border=0> Eroare Pin</div>

<div class="workstep"><div class=workfields style="width:295px;height:auto;">Linkul nu este valabil, va rugam sa raportati eroarea.
</div></div>

</div>
		<?php
		}
		else
		{
		?>
<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Confirma">
<input type="hidden" name="ofertastatus" value="1">

<div class="work_col1">

<div class="biglabel"><img src="images/ok.png" border=0> REZERVARE</div>

<div class="workstep"><div class=workfields style="width:295px;height:auto;">Va rugam sa completati numarul rezervarii. Daca vreti sa dati indicatii pentru turist va rugam sa le specificati, daca nu lasati liber.
</div></div>


</div>

<div class="work_col2">
<div class="biglabel"><img src="images/ok.png" border=0> CONFIRMARE</div>

<div class="workstep"><div class="worklabel">Nr. rezervare:</div><div class=workfields><input size=14 type="text" name="confirmare" class="validated" validate="required.yes" value="" >
</div></div>

<div class="workstep"><div class="worklabel">Pret total:</div><div class=workfields><input size=14 type="text" name="pret" class="validated" validate="required.yes" value="" >
</div></div>

<div class="workstep"><div class="worklabel">Comentarii:</div><div class=workfields style="height:auto;"><textarea name="mentiuni_host"></textarea>
</div></div>

</div><!-- col2-->

		<?php
		}
	}
	else
	{
?>
<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Multumim!">

<div class="work_col1">
<div class="biglabel"><img src="images/ok.png" border=0> IN CURS DE PROCESARE</div>

<div class="workstep"><div class=workfields style="width:295px;height:auto;"><div id="loadingtarifeimg"><img src="images/ajax-loader.gif">Un operator va prelua comanda</div>
</div></div>

</div>

<div class="work_col2">
<div class="biglabel"><img src="images/ok.png" border=0> REZERVARE</div>

<div class="workstep"><div class=workfields style="width:295px;height:auto;">Rezervarea se face direct la hotel. Imediat ce se confirma veti primi un mail cu voucherul rezervarii.
</div></div>

</div><!-- col2-->

<?php
	}
?>
</div>

