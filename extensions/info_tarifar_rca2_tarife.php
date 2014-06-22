<input type="hidden" name="action" value="TarifeOferta">
<input type="hidden" name="textbutton" value="Plateste online">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<input type="hidden" name="tipoferta" value="rca">
<input type="hidden" name="p_soc" value="">
<input type="hidden" name="p_per" value="">

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
<style>
td.worktarif
{
height:80px;
}
span.tarifjos
{
font-size:14px;
}
</style>
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
				<a class="step-2" href="#" onclick="return false;" title="Alege oferta">
					<span>Alege</span><br />   oferta
				</a>
				<a class="step-3" href="#" onclick="return false;" title="Cumpara RCA" style="opacity: 0.3; ">
					<span>Cumpara</span><br />   RCA
				</a>
				
			</div>
</div>
</div>



<div class="row">
<div class="span12">
			<h3 class="box-title">Alege asigurarea</h3>
			
			<div class="box" id="box-tarife">
				<div class="icon">&nbsp;</div>

<div class="row">
	<div class="span10">
<div id="loadingtarifeimg"><img src="images/ajax-loader.gif">Acum caut tarife</div>
<div id="loadingtarifemesaj" style="display:none;"></div>
<div id="soctarife"><a class="incarcatarife" href="site.php?TarifeOferta=<?php echo intval($_GET['offid']);?>"></a></div>
<div id="wakeupcall" style="display:none;"><a class="wakeupcall" href="site.php?WakeupCall=<?php echo intval($_GET['offid']);?>"></a></div>
	</div>
</div>

<div class="row">
	<div class="span6 offset3">
		<div class="input-prepend input-append">
			<span class="add-on" id="tarifalesspan" style="width:160px;">Tarif ales</span>
			<input name="tarif" value="" class="span1 validated" validate="required.yes" size="16" type="text" readonly=readonly style="width:77px;">
			<span class="add-on">RON</span>
			<button href="#" onclick="alegeTarifIar();return false;" class="btn btn-success">Alege alt tarif</button>
		</div>
		<div class="input-prepend input-append">
			<span class="add-on" id="tarifalesspan" style="width:200px;">Mod plata</span>

<select name="tipplata" class="validated validateundo" validate="for.euplatesc|mobilpay|unicredit|crediteurope|libra|ramburs|op.show.id.emiteredate~for.euplatesc|libra|crediteurope|unicredit|mobilpay.set.textbutton.Plateste online~for.ramburs.set.textbutton.Comanda asigurarea~for.op.set.textbutton.Trimite decont~for.contact.set.textbutton.Trimite mail~for.euplatesc.show.id.infoeuplatesc~for.crediteurope.show.id.infocrediteurope~for.unicredit.show.id.infounicredit~for.libra.show.id.infolibrapay~for.mobilpay.show.id.infomobilpay~required.yes" style="width:200px;">
	<option value="" selected>-- Selectati mod plata</option>
	<option value="contact" selected class="fararate">Vreau sa fiu contactat</option>
<?php
	if(getUserConfig("platalibra")=="yes") {
?>
	<option value="libra" class="fararate">Plata online prin LibraPay</option>
<?php
	}
	if(getUserConfig("crediteurope")=="yes")
	{
	?>
	<option value="crediteurope" class="doarrate">Plata in rate Card Avantaj</option>
	<option value="crediteurope" class="fararate">Plata online prin Credit Europe</option>
	<?php
	}
	if(getUserConfig("euplatesc")=="yes")
	{
	?>
	<option value="euplatesc" class="doarrate">Plata in rate Card BCR prin euplatesc.ro</option>
	<option value="euplatesc" class="fararate">Plata online prin euplatesc.ro</option>
	<?php
	}
	if(getUserConfig("unicredit")=="yes")
	{
	?>
	<option value="unicredit" class="doarrate">Plata in rate Banca Transilvania</option>
	<option value="unicredit" class="fararate">Plata online prin Banca transilvania</option>
	<?php
	}
?>
	<option value="op" class="fararate">Plata cu Internet Banking/OP/Token</option>
	<option value="ramburs" class="fararate">Plata ramburs</option>
</select>
		</div>

	</div>
	<div class="span6 offset3" style="font-size: 16px;">

		Website-ul este certificat 3D Secure de catre VISA si MasterCard, prin Bancile Partenere, pentru tranzactii online cu orice card bancar emis de catre orice banca. Plata cu card bancar reprezinta o optiune simpla si sigura de efectuare a platilor online

	</div>
</div>
			</div>

			<div class="box-footer"  style="margin-bottom:50px;">&nbsp;</div>
</div>
</div>


<div class="row">
<div class="span12">
			<h3 class="box-title">Informatii pentru plata si emitere polita</h3>

			<div class="box" id="box-proprietar">
				<div class="icon">&nbsp;</div>

<div id="infolibrapay" style="display:none;">
	<div class="row">
		<div class=span5>
			<img src="images/cards.jpg" border="0" height=29 width=295>
		</div>
		<div class=span5>
			<span class="text-info">Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.</span>
		</div>
	</div>
	<div class="row">
		<div class=span5>
			<img src="images/librapay.png" border="0" height=79 width=295>
		</div>
	</div>
</div>

<div id="infoeuplatesc" style="display:none;">
	<div class="row">
		<div class=span3>
			<img src="images/euplatesc.gif" border="0">
		</div>
		<div class=span5>

Optiune plata in rate:<br>
<select name="optrate">
	<option value="" selected class="fararate">Fara rate</option>
<?php
	if(getUserConfig("euplatesc_ratebcr")=="yes")
	{?>
<option value="bcr-2" class="doarrate">BCR 2 rate fara dobanda</option>
<option value="bcr-3" class="doarrate">BCR 3 rate fara dobanda</option>
<option value="bcr-4" class="doarrate">BCR 4 rate fara dobanda</option>
<option value="bcr-5" class="doarrate">BCR 5 rate fara dobanda</option>
<option value="bcr-6" class="doarrate">BCR 6 rate fara dobanda</option>
<option value="bcr-7" class="doarrate doarintegral">BCR 7 rate fara dobanda</option>
<option value="bcr-8" class="doarrate doarintegral">BCR 8 rate fara dobanda</option>
<option value="bcr-9" class="doarrate doarintegral">BCR 9 rate fara dobanda</option>
<option selected value="bcr-10" class="doarrate doarintegral">BCR 10 rate fara dobanda</option>
<?php
	}
	if(getUserConfig("euplatesc_rateapb")=="yes")
	{?>
<option value="apb-2" class="doarrate">Alpa Bank 2 rate fara dobanda</option>
<option value="apb-3" class="doarrate">Alpa Bank 3 rate fara dobanda</option>
<option value="apb-4" class="doarrate">Alpa Bank 4 rate fara dobanda</option>
<option value="apb-5" class="doarrate">Alpa Bank 5 rate fara dobanda</option>
<option value="apb-6" class="doarrate">Alpa Bank 6 rate fara dobanda</option>
<option value="apb-7" class="doarrate doarintegral">Alpa Bank 7 rate fara dobanda</option>
<option value="apb-8" class="doarrate doarintegral">Alpa Bank 8 rate fara dobanda</option>
<option value="apb-9" class="doarrate doarintegral">Alpa Bank 9 rate fara dobanda</option>
<option selected value="apb-10" class="doarrate doarintegral">Alpa Bank 10 rate fara dobanda</option>
<?php
	}
	if(getUserConfig("euplatesc_ratebtrl")=="yes")
	{?>
<option value="btrl-2" class="doarrate">BTRL 2 rate fara dobanda</option>
<option value="btrl-3" class="doarrate">BTRL 3 rate fara dobanda</option>
<option value="btrl-4" class="doarrate">BTRL 4 rate fara dobanda</option>
<option value="btrl-5" class="doarrate">BTRL 5 rate fara dobanda</option>
<option value="btrl-6" class="doarrate">BTRL 6 rate fara dobanda</option>
<option value="btrl-7" class="doarrate doarintegral">BTRL 7 rate fara dobanda</option>
<option value="btrl-8" class="doarrate doarintegral">BTRL 8 rate fara dobanda</option>
<option value="btrl-9" class="doarrate doarintegral">BTRL 9 rate fara dobanda</option>
<option selected value="btrl-10" class="doarrate doarintegral">BTRL 10 rate fara dobanda</option>
<?php
	}
?>
</select>
<br>
			<span class="text-info">Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.<br><br></span>
		</div>
	</div>
</div>

<div id="infounicredit" style="display:none;">
	<div class="row">
		<div class="span3 text-right">
			<!-- <img src="images/unicreditcl.jpeg" border="0">-->
		</div>
		<div class=span4>
<select name="uni_rate">
	<option value=""  class="fararate">Fara rate</option>
	<option value="2"  class="doarrate">2 rate fara dobanda</option>
	<option value="3" class="doarrate">3 rate fara dobanda</option>
	<option value="4" class="doarrate">4 rate fara dobanda</option>
	<option value="6" class="doarrate">6 rate fara dobanda</option>
	<option value="10" class="doarrate doarintegral">10 rate fara dobanda</option>
</select><br>
			<span class="text-info">Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.<br><br></span>
		</div>
	</div>
</div>

<div id="infocrediteurope" style="display:none;">
	<div class="row">
		<div class="span3 text-right">
		<a href="credit-europe" class="option">
			<img src="images/crediteuropecard.jpg" border="0"></a>
		</div>
		<div class=span4>
Optiune plata in rate:<br>
<select name="ce_rate">
	<option value=""  class="fararate">Fara rate</option>
	<option value="2"  class="doarrate">2 rate fara dobanda</option>
	<option value="3" class="doarrate">3 rate fara dobanda</option>
	<option value="4" class="doarrate">4 rate fara dobanda</option>
	<option value="6" class="doarrate">6 rate fara dobanda</option>
	<option value="10" class="doarrate doarintegral">10 rate fara dobanda</option>
</select><br>
			<span class="text-info">Dupa ce introduceti si emailul veti fi redirect pe site-ul bancii pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.<br><br></span>
		</div>
	</div>
</div>

<div id="infomobilpay" style="display:none;">
	<div class="row">
		<div class="span3 text-right">
			<img src="images/mobilpay.gif" border="0">
		</div>
		<div class=span4>
			<span class="text-info">Dupa ce introduceti si emailul veti fi redirect pe site-ul MobilPay.ro pentru a face plata cu cardul. Comisioanele sunt suportate de broker. Platiti doar pretul asigurarii.<br><br></span>
		</div>
	</div>
</div>

	<div class="row">
		<div class="span6">
		&nbsp;
		</div>
	</div>

	<div class="row">
		<div class="span12">
			<div class="input-prepend">
				<span class="add-on" style="width:200px;"><?php if($date['tipproprietar']['VALUE']=="pj" || $date['tipproprietar']['VALUE']=="leasing" && $date['tiputilizator']['VALUE']=="pj") echo "Denumire firma"; else echo "Nume si Prenume";?></span>
				<input name="client" value="" class="span4 validated" validate="required.yes" size="40" type="text" style="width:425px;">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="span5">
			<div class="input-prepend input-append">
				<span class="add-on indicatie">Email</span>
				<input name="emailclient" value="" class="span3 validated" validate="if.telclient..required.email" size="20" type="email">
				<span class="add-on">@</span>
			</div>
		</div>
		<div class="span3">
			<div class="input-prepend">
				<span class="add-on indicatie">Telefon</span>
				<input name="telclient" value="" class="span2 validated" validate="if.emailclient..required.phone" size="20" type="tel">
			</div>
		</div>
	</div>


<div id="emiteredate" style="display:none;">

	<div class="row">
		<div class="span10">
			<div class="input-prepend">
				<textarea name="prop_adresa" style="display:none;"></textarea>
				<span class="add-on indicatie">Adresa</span>
Strada: <input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="str" class="input-big prop_adresa_implode validated" validators="change.click" validate="required.yes" name="prop_adresa_str" size="28" value="" title="Asa cum apare in talon" placeholder="Strada">
<span class="add-on">nr&nbsp;</span><input type="number" onchange="javascript:textareaImplode('prop_adresa');" label="nr" class="input-mini prop_adresa_implode validated" validators="change.click" validate="required.yes" name="prop_adresa_nr" size="3" value="" style="width:40px;">
<span class="add-on">bl&nbsp;</span><input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="bl" class="input-mini prop_adresa_implode" name="prop_adresa_bl" size="1" value="">
<span class="add-on">sc&nbsp;</span><input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="sc" class="input-mini prop_adresa_implode" name="prop_adresa_sc" size="1" value="">
<span class="add-on">ap&nbsp;</span><input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="ap" class="input-mini prop_adresa_implode" name="prop_adresa_ap" size="1" value="">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span10 offset4">
			<div class="input-prepend">
<span class="add-on">et&nbsp;</span><input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="et" class="input-mini prop_adresa_implode" name="prop_adresa_et" size="1" value="">
<span class="add-on indicatie">Cod postal&nbsp;</span><input type="text" onchange="javascript:textareaImplode('prop_adresa');" label="zip" class="input-mini adresa_implode" name="prop_adresa_zip" size="6" value="">
			</div>
		</div>
	</div>

<?php
	if(getUserConfig("platalibra")=="yes"){
?>
	<div class="row">
		<div class="span10">
			<div class="input-prepend">
				<span class="add-on indicatie" style="width:200px;">Serie CI/Buletin</span>
				<input type="text" name="pf_ciserie" value="" size="2" class="text-small" style="width:30px;">-<input type="number" name="pf_cinumar" value="" size="7" style="width:110px;" class="text-small">
			</div>
		</div>
	</div>
<?php
	}
?>

	<div class="row">
		<div class="span10">
			<div class="input-prepend">
				<span class="add-on" style="width:200px;">Carte identitate vehicul</span>
				<input type="text" class="span2 validated" name="serieciv" size=10 <?php if(getUserConfig("platalibra")=="yes") echo 'validate="require.yes"';?> title="Talon nou: X, Talon vechi: 4">
			</div>
		</div>
	</div>


	<div class="row">
		<div class="span10">
			<div class="input-prepend">
				<span class="add-on" style="width:200px;">Adresa de Corespondenta</span>
				<select name="adresalivrare" class="span2 validated validateundo" validate="for.alta.show.id.adresalivrare">
				<option value="prop">Aceeasi adresa</option>
				<option value="alta">Alta adresa</option>
				</select>
			</div>
		</div>
	</div>

<div id="adresalivrare" style="display:none;">
	<div class="row">
		<div class="span10">
			<div class="input-prepend" style="width:200px;">
				<span class="add-on">Adresa Livrare</span>
				<textarea name="obslivrare" cols=18 rows=1 class="span5 validate" validate="require.yes"></textarea>
			</div>
		</div>
	</div>
</div>

</div>

<div class="row">
<div class="span8 offset1">
<br>% procent completare date
    <div class="progress">
    <div class="bar" style="width: 10%;"></div>
    </div>
</div>
</div>

			</div><!-- box -->
			<div class="box-footer"  style="margin-bottom:50px;">&nbsp;</div>
			
</div>
</div>



<div class="row">
<div class="span4 offset5">
			<button class="btn btn-large btn-primary" onclick="if(valideazaFormaPentruSalvare($('form[name=work]'),punemarcaje)) if(confirm('Atentie! Odata ce validati plata nu va mai puteti intoarce la meniul anterior, iar polita dumneavoastra se va emite in mod automat. Continuarea acestui proces reprezinta confirmarea datelor introduse de catre dumneavoastra. POLITELE EMISE NU MAI POT FI ANULATE, doar modificate partial! OK?')) $('form[name=work]').submit();return false;"><i class="icon-ok icon-white">&nbsp;</i> Valideaza</button>
</div>
</div>


</div> <!-- container -->


