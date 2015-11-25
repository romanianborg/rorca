<div id="worksteps">

<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Plateste online">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<input type="hidden" name="tipoferta" value="rca">
<input type="hidden" name="p_soc" value="">
<input type="hidden" name="p_per" value="">
<?php
	require_once("extensions/process_offer_ws.php");
	$date=ws_process("InfoOferta",intval($_GET['offid']));

?>
<div class="work_col1">
<div class="biglabel"><img src="images/tarife.png" border=0> ALEGE UN PRET</div>

<div class="workstep"><div class=workfields style="width:295px;height:auto;"><div id="loadingtarifeimg"><img src="images/ajax-loader.gif">Acum caut tarife</div>
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

<div class="workstep"><div class="worklabel"><?php if($date['tipproprietar']['VALUE']=="pj" || $date['tipproprietar']['VALUE']=="leasing" && $date['tiputilizator']['VALUE']=="pj") echo "Denumire firma"; else echo "Nume si Prenume";?>:</div><div class=workfields><input name="client" value="" class="validated" validate="required.yes" size="20" type="text">
</div></div>


<div class="workstep"><div class="worklabel">Mod Plata:</div><div class=workfields>
<select name="tipplata" class="validated validateundo" validate="for.libra|mobilpay|unicredit|euplatesc|crediteurope|ramburs|op.show.id.emiteredate~for.libra|euplatesc|unicredit|crediteurope|mobilpay.set.textbutton.Plateste online~for.ramburs.set.textbutton.Comanda asigurarea~for.op.set.textbutton.Trimite decont~for.contact.set.textbutton.Trimite mail~for.libra.show.id.infolibrapay~for.euplatesc.show.id.infoeuplatesc~for.unicredit.show.id.infounicredit~for.mobilpay.show.id.infomobilpay~for.crediteurope.show.id.infocrediteurope~required.yes">
	<option value="contact" selected>Vreau sa fiu contactat</option>
<?php
	if(getUserConfig("unicredit")=="yes"){?>
	<option value="unicredit">Plata Card prin Banca Transilvania</option>
<?php	}
	if(getUserConfig("platalibra")=="yes"){?>
	<option value="libra">Plata Card prin LibraPay</option>
<?php	}
	if(getUserConfig("euplatesc")=="yes"){?>
	<option value="euplatesc">Plata Card prin EuPlatesc.ro</option>
<?php	}
	if(getUserConfig("mobilpay")=="yes"){?>
	<option value="mobilpay">Plata Card prin Mobilpay</option>
<?php	}
	if(getUserConfig("crediteurope")=="yes"){?>
	<option value="crediteurope">Plata Card prin Credit Europe</option>
<?php	}

?>
	<option value="op">Plata pe site-ul bancii cu token</option>
	<option value="ramburs">Plata ramburs</option>
</select>
</div></div>

<?php
	if(getUserConfig("unicredit")=="yes"){
?>
<div id="infounicredit" style="display:none;">
<div class="workstep"><div class=workfields style="width:295px;height:auto;text-align:center;">
	<!--<img src="images/unicreditcl.jpeg" border="0">-->
	<br>Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.
</div></div>
</div>
<?php
	}
?>
<?php
	if(getUserConfig("platalibra")=="yes"){
?>
<div id="infolibrapay" style="display:none;">
<div class="workstep"><div class=workfields style="width:295px;height:auto;text-align:center;">
	<img src="images/cards.jpg" border="0" height=29 width=295>
	<img src="images/librapay.png" border="0" height=79 width=295>
	<br>Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.
</div></div>
</div>
<?php
	}
?>
<?php
	if(getUserConfig("mobilpay")=="yes"){
?>
<div id="infomobilpay" style="display:none;">
<div class="workstep"><div class=workfields style="width:295px;height:auto;">
	<img src="images/mobilpay.gif" border="0">
	<br>Dupa ce introduceti si emailul veti fi redirect pe site-ul MobilPay.ro pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.
</div></div>
</div>
<?php
	}
?>
<?php
	if(getUserConfig("crediteurope")=="yes"){
?>
<div id="infocrediteurope" style="display:none;">
<div class="workstep"><div class=workfields style="width:295px;height:auto;">

<img src="images/crediteurope.png" border="0"><br>
Optiune plata in rate: 
<select name="ce_rate">
	<option value="" selected>Integral</option>
	<option value="2">2 rate fara dobanda</option>
	<option value="3">3 rate fara dobanda</option>
	<option value="4">4 rate fara dobanda</option>
	<option value="6">6 rate fara dobanda</option>
	<option value="12">12 rate fara dobanda</option>
</select>
<br>
	Dupa ce introduceti si emailul veti fi redirect pe site-ul Credit Europe pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.<br>


</div></div>
</div>
<?php
	}
?>
<?php
	if(getUserConfig("euplatesc")=="yes"){
?>
<div id="infoeuplatesc" style="display:none;">
<div class="workstep"><div class=workfields style="width:295px;height:auto;text-align:center;">
	<img src="images/euplatesc.gif" border="0">
<br>
Optiune plata in rate:<br>
<select name="optrate">
	<option value="" selected>Integral</option>
<?php
	global $_CONFIG;
	if(getUserConfig("euplatesc_ratebcr")=="yes")
		$_CONFIG["euplatesc_ratebcr"]=12;
	if(intval(getUserConfig("euplatesc_ratebcr")))
	{
		for($ratai=2;$ratai<=intval(getUserConfig("euplatesc_ratebcr"));$ratai++)
		{
			?>
<option value="bcr-<?php echo $ratai;?>">BCR <?php echo $ratai;?> rate fara dobanda</option>
			<?php
		}
	}
	if(getUserConfig("euplatesc_rateapb")=="yes")
		$_CONFIG["euplatesc_rateapb"]=12;
	if(intval(getUserConfig("euplatesc_rateapb")))
	{
		for($ratai=2;$ratai<=intval(getUserConfig("euplatesc_rateapb"));$ratai++)
		{
			?>
<option value="apb-<?php echo $ratai;?>">Alpha Bank <?php echo $ratai;?> rate fara dobanda</option>
			<?php
		}
	}
	if(getUserConfig("euplatesc_ratebtrl")=="yes")
			$_CONFIG["euplatesc_ratebtrl"]=12;
	if(intval(getUserConfig("euplatesc_ratebtrl")))
	{
		for($ratai=2;$ratai<=intval(getUserConfig("euplatesc_ratebtrl"));$ratai++)
		{
			?>
<option value="btrl-<?php echo $ratai;?>">BTRL <?php echo $ratai;?> rate fara dobanda</option>
			<?php
		}
	}
?>
</select>

	<br>Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.
</div></div>
</div>
<?php
	}
?>
<div id="emiteredate" style="display:none;">

<div class="workstep"><div class=workfields style="text-align:right;height:110px;"><textarea name="prop_adresa" style="display:none;"></textarea>
Strada: <input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="str" class="prop_adresa_implode validated" validators="change.click" validate="required.yes" name="prop_adresa_str" size="28" value="" title="Asa cum apare in talon"><br>
nr&nbsp;<input type="number" onchange="javascript:textareaImplode('prop_adresa');" label="nr" class="prop_adresa_implode validated" validators="change.click" validate="required.yes" name="prop_adresa_nr" size="3" value="" style="width:40px;">
,bl&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="bl" class="prop_adresa_implode" name="prop_adresa_bl" size="1" value="" style="width:30px;">
,sc&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="sc" class="prop_adresa_implode" name="prop_adresa_sc" size="1" value="" style="width:30px;">
,et&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="et" class="prop_adresa_implode" name="prop_adresa_et" size="1" value="" style="width:30px;">
<br>ap&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="ap" class="prop_adresa_implode" name="prop_adresa_ap" size="1" value="" style="width:30px;">
cod postal&nbsp;<input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="zip" class="adresa_implode" name="prop_adresa_zip" size="6" value="" style="width:60px;">
</div></div>

<?php
	if(getUserConfig("platalibra")=="yes"){
?>
<div class="workstep"><div class="worklabel">Serie CI/Buletin</div><div class=workfields><input type="text" name="pf_ciserie" value="" size="2" style="width:34px;">-<input type="number" name="pf_cinumar" value="" size="7" style="width:90px;">
</div></div>

<?php
	}
?>

<div class="workstep"><div class="worklabel">Carte identitate vehicul</div><div class="workfields"><input type="text" class="validated" name="serieciv" size=10 <?php if(getUserConfig("platalibra")=="yes") echo 'validate="required.yes"';?> title="Talon nou: X, Talon vechi: 4">
</div></div>


<div class="workstep"><div class="worklabel">Adresa de Corespondenta</div><div class=workfields><select name="adresalivrare" class="validated validateundo" validate="for.alta.show.id.adresalivrare">
<option value="prop">Aceeasi adresa</option>
<option value="alta">Alta adresa</option>
</select>
</div></div>


<div id="adresalivrare" style="display:none;">
<div class="workstep"><div class="worklabel">Adresa Livrare</div><div class=workfields style="height:56px;"><textarea name="obslivrare" cols=18 rows=2 class="validate" validate="require.yes"></textarea>
</div></div>
</div>

</div>

</div><!-- col2-->

</div>

