<div id="worksteps">

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
	$platacard='';
	if(getUserConfig("unicredit")=="yes"){$platacard='unicredit';}
	if(getUserConfig("platalibra")=="yes"){$platacard='libra';}
	if(getUserConfig("euplatesc")=="yes"){$platacard='euplatesc';}
	if(getUserConfig("mobilpay")=="yes"){$platacard='mobilpay';}

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

<div class="workstep"><div class="worklabel"><?php if($date['tipproprietar']['VALUE']=="pj" || $date['tipproprietar']['VALUE']=="leasing" && $date['tiputilizator']['VALUE']=="pj") echo "Denumire firma"; else echo "Nume si Prenume";?>:</div><div class=workfields><input name="client" value="" class="validated" validate="required.yes" size="20" type="text">
</div></div>


<div class="workstep"><div class="worklabel">Mod Plata:</div><div class=workfields>
<select name="tipplata" class="validated validateundo" validate="for.libra|mobilpay|unicredit|euplatesc|ramburs|op.show.id.emiteredate~for.libra|euplatesc|unicredit|mobilpay.set.textbutton.Plateste online~for.ramburs.set.textbutton.Comanda asigurarea~for.op.set.textbutton.Trimite decont~for.contact.set.textbutton.Trimite mail~for.libra.show.id.infolibrapay~for.euplatesc.show.id.infoeuplatesc~for.unicredit.show.id.infounicredit~for.mobilpay.show.id.infomobilpay~required.yes">
	<option value="contact" selected>Vreau sa fiu contactat</option>
<?php
	if($platacard!=""){
?>
	<option value="<?php echo $platacard;?>">Plata online cu cardul</option>
<?php
	}
?>
	<option value="op">Plata cu OP</option>
	<option value="ramburs">Plata ramburs</option>
</select>
</div></div>

<?php
	if(getUserConfig("unicredit")=="yes"){
?>
<div id="infounicredit" style="display:none;">
<div class="workstep"><div class=workfields style="width:295px;height:auto;text-align:center;">
	<img src="images/unicreditcl.jpeg" border="0">
	<br>Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.
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
	if(getUserConfig("euplatesc_ratebcr")=="yes")
	{?>
<option value="bcr-2">BCR 2 rate fara dobanda</option>
<option value="bcr-3">BCR 3 rate fara dobanda</option>
<option value="bcr-4">BCR 4 rate fara dobanda</option>
<option value="bcr-5">BCR 5 rate fara dobanda</option>
<option value="bcr-6">BCR 6 rate fara dobanda</option>
<option value="bcr-7">BCR 7 rate fara dobanda</option>
<option value="bcr-8">BCR 8 rate fara dobanda</option>
<option value="bcr-9">BCR 9 rate fara dobanda</option>
<option value="bcr-10">BCR 10 rate fara dobanda</option>
<option value="bcr-11">BCR 11 rate fara dobanda</option>
<option selected value="bcr-12">BCR 12 rate fara dobanda</option>
<?php
	}
	if(getUserConfig("euplatesc_rateapb")=="yes")
	{?>
<option value="apb-2">Alpa Bank 2 rate fara dobanda</option>
<option value="apb-3">Alpa Bank 3 rate fara dobanda</option>
<option value="apb-4">Alpa Bank 4 rate fara dobanda</option>
<option value="apb-5">Alpa Bank 5 rate fara dobanda</option>
<option value="apb-6">Alpa Bank 6 rate fara dobanda</option>
<option value="apb-7">Alpa Bank 7 rate fara dobanda</option>
<option value="apb-8">Alpa Bank 8 rate fara dobanda</option>
<option value="apb-9">Alpa Bank 9 rate fara dobanda</option>
<option value="apb-10">Alpa Bank 10 rate fara dobanda</option>
<option value="apb-11">Alpa Bank 11 rate fara dobanda</option>
<option selected value="apb-12">Alpa Bank 12 rate fara dobanda</option>
<?php
	}
	if(getUserConfig("euplatesc_ratebtrl")=="yes")
	{?>
<option value="btrl-2">BTRL 2 rate fara dobanda</option>
<option value="btrl-3">BTRL 3 rate fara dobanda</option>
<option value="btrl-4">BTRL 4 rate fara dobanda</option>
<option value="btrl-5">BTRL 5 rate fara dobanda</option>
<option value="btrl-6">BTRL 6 rate fara dobanda</option>
<option value="btrl-7">BTRL 7 rate fara dobanda</option>
<option value="btrl-8">BTRL 8 rate fara dobanda</option>
<option value="btrl-9">BTRL 9 rate fara dobanda</option>
<option value="btrl-10">BTRL 10 rate fara dobanda</option>
<option value="btrl-11">BTRL 11 rate fara dobanda</option>
<option selected value="btrl-12">BTRL 12 rate fara dobanda</option>
<?php
	}
?>
</select>


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
<div class="workstep"><div class="worklabel">Adresa Livrare</div><div class=workfields style="height:56px;"><textarea name="obslivrare" cols=18 rows=2 class="validate" validate="require.yes"></textarea>
</div></div>
</div>

</div>

</div><!-- col2-->

</div>

