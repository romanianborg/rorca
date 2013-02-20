
<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Plateste online">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<input type="hidden" name="tipoferta" value="medicale">

<?php
	require_once("extensions/process_offer_ws.php");
	$date=ws_process("InfoOferta",intval($_GET['offid']));
?>
<div class="work_col1">

<div class="workstep"><div class=workfields style="width:295px;"><span id="loadingtarifeimg"><img src="images/ajax-loader.gif">Acum caut tarife</span>
<span id="loadingtarifemesaj" style="display:none;">Alegeti un tarif</span><br>
<div id="soctarife"><a class="incarcatarife" href="site.php?TarifeOferta=<?php echo intval($_GET['offid']);?>"></a></div>
<div id="wakeupcall" style="display:none;"><a class="wakeupcall" href="site.php?WakeupCall=<?php echo intval($_GET['offid']);?>"></a></div>
</div></div>


</div>

<div class="work_col2">
<div class="biglabel"><img src="images/ok.png" border=0> Asigurator ales</div>

<div class="workstep"><div class="worklabel">Tarif ales:</div><div class=workfields>
<input name="tarif" value="" class="validated" validate="required.yes" size="6" readonly=yes type="text"> RON
<input type="hidden" name="p_soc" value=""><input type="hidden" name="p_per" value="">
</div></div>

<div class="workstep"><div class="worklabel">Plata:</div><div class=workfields>
<select name="tipplata" class="validated validateundo" validate="for.libra|ramburs|op.show.id.emiteredate~for.libra.set.textbutton.Plateste online~for.ramburs.set.textbutton.Trimite asigurarea~for.contact.set.textbutton.Trimite mail~for.op.set.textbutton.Trimite decont~for.libra.show.id.infolibrapay~required.yes">
	<option value="contact">Vreau sa fiu contactat</option>
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
<div id="infolibrapay">
<div class="workstep" style="display:none;"><div class=workfields style="width:295px;">
	<span >
	<img src="images/cards.jpg" border="0" style="width:295px;">
	<img src="images/librapay.png" border="0" style="width:295px;">
	<br>Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.</span>
</div></div>
</div>
<?php
	}
?>

<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name="emailclient" value="" class="validated" validate="if.telclient..required.email" size="20" type="email">
</div></div>

<div class="workstep"><div class="worklabel">Telefon:</div><div class=workfields><input name="telclient" value="" class="validated" validate="if.emailclient..required.phone" size="20" type="tel">
</div></div>


<div class="workstep"><div class="worklabel"><?php if($date['tipproprietar']['VALUE']=="pj" || $date['tipproprietar']['VALUE']=="leasing" && $date['tiputilizator']['VALUE']=="pj") echo "Denumire firma"; else echo "Nume";?>:</div><div class=workfields><input name="client" value="" class="validated" validate="required.yes" size="20" type="text">
</div></div>

<div id="emiteredate">
<div class="workstep"><div class=workfields style="text-align:right;"><textarea name="prop_adresa" style="display:none;"></textarea>
Strada: <input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="str" class="prop_adresa_implode validated" validators="change.click" validate="required.yes" name="prop_adresa_str" size="28" value=""><br>
nr&nbsp;<input type="number" onchange="javascript:textareaImplode('prop_adresa');" label="nr" class="prop_adresa_implode validated" validators="change.click" validate="required.yes" name="prop_adresa_nr" size="1" value="">
,bl&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="bl" class="prop_adresa_implode" name="prop_adresa_bl" size="1" value="">
,sc&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="sc" class="prop_adresa_implode" name="prop_adresa_sc" size="1" value="">
,et&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="et" class="prop_adresa_implode" name="prop_adresa_et" size="1" value="">
<br>ap&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="ap" class="prop_adresa_implode" name="prop_adresa_ap" size="1" value="">
cod postal&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="zip" class="adresa_implode" name="prop_adresa_zip" size="6" value="">
</div></div>

<?php
	if(getUserConfig("platalibra")=="yes"){
?>
<div class="workstep"><div class="worklabel">CI/Buletin</div><div class=workfields> serie <input type="text" name="pf_ciserie" value="" size="2"> numar <input type="number" name="pf_cinumar" value="" size="7"> (pentru livrare)
</div></div>
<?php
	}
?>

<div class="workstep"><div class="worklabel">Corespondenta</div><div class=workfields><select name="adresalivrare" class="validated validateundo" validate="for.alta.show.id.adresalivrare">
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

