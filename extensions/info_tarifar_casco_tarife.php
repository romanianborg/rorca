
<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Cerere oferta">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<input type="hidden" name="tipoferta" value="casco">
<input type="hidden" name="tipplata" value="contact">

<?php
	require_once("extensions/process_offer_ws.php");
	$date=ws_process("InfoOferta",intval($_GET['offid']));
?>


<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name="emailclient" value="" class="validated" validate="if.telclient..required.email" size="20" type="email">
</div></div>

<div class="workstep"><div class="worklabel">Telefon:</div><div class=workfields><input name="telclient" value="" class="validated" validate="if.emailclient..required.phone" size="20" type="tel">
</div></div>

<div class="workstep"><div class="worklabel"><?php if($date['tipproprietar']['VALUE']=="pj" || $date['tipproprietar']['VALUE']=="leasing" && $date['tiputilizator']['VALUE']=="pj") echo "Denumire firma"; else echo "Nume";?>:</div><div class=workfields><input name="client" value="" class="validated" validate="required.yes" size="20" type="text">
</div></div>

