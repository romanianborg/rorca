
<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Plateste online">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<input type="hidden" name="tipoferta" value="pad">
<input type="hidden" name="p_soc" value="">
<input type="hidden" name="p_per" value="">
<?php
	require_once("extensions/process_offer_ws.php");
	$date=ws_process("InfoOferta",intval($_GET['offid']));
?>
<div class="work_col1">
<div class="biglabel"><img src="images/tarife.png" border=0> ALEGE UN PRET</div>

<div class="workstep"><div class=workfields style="width:295px;"><div id="loadingtarifeimg"><img src="images/ajax-loader.gif">Acum caut tarife</div>
<div id="loadingtarifemesaj" style="display:none;"></div>
<div id="soctarife"><a class="incarcatarife" href="site.php?TarifeOferta=<?php echo intval($_GET['offid']);?>"></a></div>
<div id="wakeupcall" style="display:none;"><a class="wakeupcall" href="site.php?WakeupCall=<?php echo intval($_GET['offid']);?>"></a></div>
</div></div>


</div>

<div class="work_col2">
<div class="biglabel"><img src="images/ok.png" border=0> Asigurator ales</div>

<div class="workstep"><div class="worklabel">Tarif ales:</div><div class=workfields>
<input name="tarif" value="" class="validated" validate="required.yes" size="6" type="text" readonly=readonly> RON
</div></div>
<div id="myremedy""></div>

<div class="biglabel"><img src="images/email.png" border=0> DATE CONTACT</div>

<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name="emailclient" value="" class="validated" validate="if.telclient..required.email" size="20" type="email">
</div></div>

<div class="workstep"><div class="worklabel">Telefon:</div><div class=workfields><input name="telclient" value="" class="validated" validate="if.emailclient..required.phone" size="20" type="tel">
</div></div>

<div class="workstep"><div class="worklabel"><?php if($date['tipproprietar']['VALUE']=="pj" || $date['tipproprietar']['VALUE']=="leasing" && $date['tiputilizator']['VALUE']=="pj") echo "Denumire firma"; else echo "Nume";?>:</div><div class=workfields><input name="client" value="" class="validated" validate="required.yes" size="20" type="text">
</div></div>


<div class="workstep"><div class="worklabel">Mod Plata:</div><div class=workfields>
<select name="tipplata" class="validated validateundo" validate="for.libra|ramburs|op.show.id.emiteredate~for.libra.set.textbutton.Plateste online~for.ramburs.set.textbutton.Comanda asigurarea~for.op.set.textbutton.Trimite decont~for.contact.set.textbutton.Trimite mail~for.libra.show.id.infolibrapay~required.yes">
	<option value="contact" selected>Vreau sa fiu contactat</option>
<?php
	if(getUserConfig("platalibra")=="yes"){
?>
	<option value="libra">Plata online cu cardul</option>
<?php
	}
?>
	<option value="op">Plata cu OP</option>
	<option value="ramburs">Plata ramburs</option>
</select>
</div></div>


<?php
	if(getUserConfig("platalibra")=="yes"){
?>
<div id="infolibrapay" style="display:none;">
<div class="workstep"><div class=workfields style="width:295px;">
	<img src="images/cards.jpg" border="0" height=29 width=295>
	<img src="images/librapay.png" border="0" height=79 width=295>
	<br>Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.
</div></div>
</div>
<?php
	}
?>

<div id="emiteredate" style="display:none;">

<?php
	if(getUserConfig("platalibra")=="yes"){
?>
<div class="workstep"><div class="worklabel">Serie CI/Buletin</div><div class=workfields><input type="text" name="pf_ciserie" value="" size="2">-<input type="number" name="pf_cinumar" value="" size="7" style="width:110px;">
</div></div>

<?php
	}
?>

<div class="workstep"><div class="worklabel">Adresa de Corespondenta</div><div class=workfields><select name="adresalivrare" class="validated validateundo" validate="for.alta.show.id.adresalivrare">
<option value="prop">Aceeasi adresa</option>
<option value="alta">Alta adresa</option>
</select>
</div></div>


<div id="adresalivrare" style="display:none;">
<div class="workstep"><div class="worklabel">Adresa Livrare</div><div class=workfields><textarea name="obslivrare" cols=18 rows=2 class="validate" validate="require.yes"></textarea>
</div></div>
</div>

</div>

</div><!-- col2-->

