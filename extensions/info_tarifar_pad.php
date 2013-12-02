<div id="worksteps">
<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Vezi tarife">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="pad">
<input type="hidden" name="pf_cota" value="100">
<input type="hidden" name="pj_cota" value="100">
<input type="hidden" value="pj" name="pj_tippersoana">
<input type="hidden" value="pf" name="pf_tippersoana">

<?php
	require_once("config/dateutils.php");
?>
<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/casa.png" border=0> DATE IMOBIL</div>
</div>

<div class="workstep"><div class=workfields style="text-align:center;height:106px;"><textarea name="im_adresa" style="display:none;"></textarea>
Strada: <input type="text" onchange="javascript:textareaImplode('im_adresa');" label="str" class="im_adresa_implode validated" validators="change.click" validate="required.yes" name="im_adresa_str" size="20" value="">
<br>
nr&nbsp;<input type="number" onchange="javascript:textareaImplode('im_adresa');" label="nr" class="im_adresa_implode validated" validators="change.click" validate="required.yes" name="im_adresa_nr" size="4" value="" style="width:50px;">
,bl&nbsp;<input type="text" onchange="javascript:textareaImplode('im_adresa');" label="bl" class="im_adresa_implode" name="im_adresa_bl" size="1" value="" style="width:30px;">
, sc&nbsp;<input type="text" onchange="javascript:textareaImplode('im_adresa');" label="sc" class="im_adresa_implode" name="im_adresa_sc" size="1" value="" style="width:30px;">
, et&nbsp;<input type="text" onchange="javascript:textareaImplode('im_adresa');" label="et" class="im_adresa_implode" name="im_adresa_et" size="1" value="" style="width:30px;">
<br>ap&nbsp;<input type="text" onchange="javascript:textareaImplode('im_adresa');" label="ap" class="im_adresa_implode" name="im_adresa_ap" size="1" value="" style="width:30px;">
cod postal&nbsp;<input type="number" onchange="javascript:textareaImplode('im_adresa');" label="zip" class="im_implode validated" name="im_adresa_zip" size="6" value="" validate="required.size.6" style="width:70px;">
</div></div>

<div class="workstep"><div class=worklabel>Judet:</div><div class=workfields><select name="im_judet" class="validated" validate="notfor.bucuresti.show.id.im_locspan~for.bucuresti.show.id.im_sectspan~call.pregatesteAutocomplete.im_judet.im_localitate.im_sector~required.yes">
	<option value="">--Selectati--</option>
	<option value="bucuresti">BUCURESTI</option>
<option value="ilfov">Ilfov</option>
<option value="alba">Alba</option>
<option value="arad">Arad</option>
<option value="arges">Arges</option>
<option value="bacau">Bacau</option>
<option value="bihor">Bihor</option>
<option value="bistrita">Bistrita-Nasaud</option>
<option value="botosani">Botosani</option>
<option value="braila">Braila</option>
<option value="brasov">Brasov</option>
<option value="buzau">Buzau</option>
<option value="calarasi">Calarasi</option>
<option value="caras">Caras-Severin</option>
<option value="cluj">Cluj</option>
<option value="constanta">Constanta</option>
<option value="covasna">Covasna</option>
<option value="dambovita">Dambovita</option>
<option value="dolj">Dolj</option>
<option value="galati">Galati</option>
<option value="giurgiu">Giurgiu</option>
<option value="gorj">Gorj</option>
<option value="harghita">Harghita</option>
<option value="hunedoara">Hunedoara</option>
<option value="ialomita">Ialomita</option>
<option value="iasi">Iasi</option>
<option value="maramures">Maramures</option>
<option value="mehedinti">Mehedinti</option>
<option value="mures">Mures</option>
<option value="neamt">Neamt</option>
<option value="olt">Olt</option>
<option value="prahova">Prahova</option>
<option value="salaj">Salaj</option>
<option value="satu">Satu Mare</option>
<option value="sibiu">Sibiu</option>
<option value="suceava">Suceava</option>
<option value="teleorman">Teleorman</option>
<option value="timis">Timis</option>
<option value="tulcea">Tulcea</option>
<option value="valcea">Valcea</option>
<option value="vaslui">Vaslui</option>
<option value="vrancea">Vrancea</option>
	</select>
</div></div>

<div id="im_locspan" style="display:none;">
<div class="workstep"><div class=worklabel>Localitate:</div><div class=workfields><input name="im_localitate" id="im_localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=im_localitate&lkjudet=[im_judet]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18>
</div></div>
</div>

<div id="im_sectspan" style="display:none;">
<div class="workstep"><div class=worklabel>Sector</div><div class=workfields><select id="im_sector" name="im_sector" class="validated im_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('im_adresa');"><option value=""> Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select>
</div></div>
</div>


<div class="workstep"><div class=worklabel>Valoare imobil:</div><div class=workfields>
	<select name="tipcladire" class="validated" validate="if.tipcladire.A.if.sumaasigurata.10000.get..sumaasigurata.rezistenta~if.tipcladire.B.get..sumaasigurata.rezistenta~call.calculatetarife_pad~required.yes">
	<option value="">Selectati...</option>
	<option value="A" sumaasigurata="20000" rezistenta="betan,armat">A (>20.000 EURO)</option>
	<option value="B" sumaasigurata="10000" rezistenta="chirpici">B (10.000 EURO)</option>
	</select>
</div></div>

<div class="workstep"><div class=worklabel>Tip adresa</div><div class=workfields>
	<select name="tipadresa" class="validated" validate="required.yes">
	<option value="">Selectati...</option>
	<option value="urban,bloc">Urban BLOC</option>
	<option value="urban,casa">Urban CASA</option>
	<option value="rural,bloc">Rural BLOC</option>
	<option value="rural,casa">Rural CASA</option>
	</select>
</div></div>

<div class="workstep"><div class=worklabel>Suprafata</div><div class=workfields><input type="number" name="suprafata" class="validated" validators="change.keydown" validate="required.integer~required.yes" size="5">
</div></div>

<div class="workstep"><div class=worklabel>Numar camere</div><div class=workfields><input type="number" name="nrcamere" value="" size=5>
</div></div>

<div class="workstep"><div class=worklabel>Numar etaje</div><div class=workfields><input type="number" name="nretaje" value="" size=5>
</div></div>

<div class="workstep"><div class=worklabel>Tip constructie</div><div class=workfields><select name="tipconstructie"><option value="1">Apartament/Casa</option><option value="2">Vila</option></select>
</div></div>

<div class="workstep"><div class=worklabel>An constructie</div><div class=workfields><input type="number" name="anconstructie" value="" size=6 class="validated" validate="required.yes">
</div></div>

<div class="workstep"><div class=worklabel>Tip locuinta</div><div class=workfields><select name="tiplocuinta"><option value="1">Permanenta</option><option value="2">Temporara</option></select>
</div></div>

<div class="workstep"><div class=worklabel>Structura de rezistenta</div><div class=workfields><select name="rezistenta" class="validated" validate="revalidate.sumaasigurata">
<option value="betan,armat">beton armat cu plansee din beton armat</option>
<option value="betan,zidarie">zidarie cu plansee din beton armat sau lemn</option>
<option value="metal">metal</option>
<option value="chirpici">material combinate (paianta, chirpici, caramida, bca)</option>
<option value="lemn">integral din lemn sau alte material combustibile</option>
<option value="zidarie,lemn">parter din zidarie (caramida, bca), etaj/acoperis din lemn</option>
</select>
</div></div>

<div class="workstep"><div class=worklabel>Cesionare in favoarea</div><div class=workfields><input type="text" name="cesiune" value="" size=20>
</div></div>

<div class="workstep"><div class=worklabel>Comentarii</div><div class=workfields><input type="text" size=20 value="" name="mentiuni">
</div></div>


</div><div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/ok.png" border=0> CE ASIGURI</div>
</div>

<div class="workstep"><div class=worklabel>Suma asigurata</div><div class=workfields><input type="hidden" name="politasupliment" value="1"><input type="number" name="sumaasigurata" value="20000" size=6 class="validated" validate="call.valideazapad" style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Rasp. Civila</div><div class=workfields><input type="number" name="sa_rc" value="" size=6 style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Furt</div><div class=workfields><input type="number" name="sa_furt" value="" size=6 style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Centrala/Conducta</div><div class=workfields><input type="number" name="sa_apa" value="" size=6 style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Bunuri</div><div class=workfields><input type="number" name="sa_bunuri" value="" size=6 style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Obiecte casabile</div><div class=workfields><input type="number" name="sa_bc" value="" size=6 style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Accidente:</div><div class=workfields><input type="number" name="sa_acc" value="" size=6 style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Fenomene Electrice:</div><div class=workfields><input type="number" name="sa_fe" value="" size=6 style="width:100px;"> EURO
</div></div>

<div class="workstep"><div class=worklabel>Nr rate</div><div class=workfields><select name="nrrate"><option value="1">1</option><option value="2">2</option><option value="4">4</option></select>
</div></div>

<div class="workstep"><div class=worklabel>Nr ani</div><div class=workfields><select name="nrani"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
</div></div>

<div class="workstep"><div class=worklabel>Valabil din</div><div class=workfields><input class="validated" validators="change" validate="revalidate.p_per~required.date" type=text name="datavalabilitate" id="datavalabilitate" size="9" value="<?php echo showDate(date("Y-m-d",time()+24*60*60));?>">
	<a id="datavalabilitate_sel" name="datavalabilitate_sel" onclick="global_cal.select(document.forms['work'].datavalabilitate,'datavalabilitate_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

</div><div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/individ.png" border=0> DATE PROPRIETAR</div></div>

<div class="workstep"><div class=worklabel>Proprietar</div><div class=workfields><select name="tipproprietar" class="validated validateundo " validators="change" validate="for.pf.show.id.tarifarofertapf~for.pj.show.id.tarifarofertapj~required.yes">
	<option class="option0" value="">--Selectati--</option>
	<option class="option0" value="pf">Persoana Fizica</option>
	<option class="option0" value="pj">Persoana Juridica</option>
</select>
</div></div>

<div id="tarifarofertapf" style="display:none">


<div class="workstep"><div class=worklabel>CNP:</div><div class=workfields><input type="number" name="pf_cnp" size=12 value="" class="validated" validators="change.keyup" validate="extract.varsta.varsta~if.pf_cetatean.true.required.cnp"><input type="hidden"name="varsta" value="">
</div></div>

<div class="workstep"><div class=worklabel>Cetatenie</div><div class=workfields><select name="pf_cetatean"><option value="true">Romana</option><option value="false">Straina</option></select>
</div></div>

<div class="workstep"><div class=worklabel>Adresa</div><div class=workfields><select name="adresaasigurat" class="validated validateundo" validators="change" validate="for.alta.show.id.pf_adresaraw.id.prop_adresa~required.yes">
	<option class="option0" value="">--Selectati--</option>
	<option class="option0" value="prop" selected>Aceeasi adresa</option>
	<option class="option0" value="alta">Alta adresa</option>
</select>
</div></div>

<div id="pf_adresaraw" style="display:none;">
<div class="workstep"><div class=workfields style="text-align:right;height:110px;"><textarea name="pf_adresa" style="display:none;"></textarea>
Strada: <input type="text" onchange="javascript:textareaImplode('pf_adresa');" label="str" class="pf_adresa_implode validated" validators="change.click" validate="required.attention" name="pf_adresa_str" size="28" value="">
<br>
nr&nbsp;<input type="number" onchange="javascript:textareaImplode('pf_adresa');" label="nr" class="pf_adresa_implode validated" validators="change.click" validate="required.attention" name="pf_adresa_nr" size="1" value="" style="width:40px;">
,bl&nbsp;<input type="text" onchange="javascript:textareaImplode('pf_adresa');" label="bl" class="pf_adresa_implode" name="pf_adresa_bl" size="1" value="" style="width:30px;">
,sc&nbsp;<input type="text" onchange="javascript:textareaImplode('pf_adresa');" label="sc" class="pf_adresa_implode" name="pf_adresa_sc" size="1" value="" style="width:30px;">
,et&nbsp;<input type="text" onchange="javascript:textareaImplode('pf_adresa');" label="et" class="pf_adresa_implode" name="pf_adresa_et" size="1" value="" style="width:30px;">
<br>
ap&nbsp;<input type="text" onchange="javascript:textareaImplode('pf_adresa');" label="ap" class="pf_adresa_implode" name="pf_adresa_ap" size="1" value="" style="width:30px;">
, cod postal&nbsp;<input type="number" onchange="javascript:textareaImplode('pf_adresa');" label="zip" class="adresa_implode validated" name="pf_adresa_zip" size="3" value="" validate="if.p_soc.omniasig.required.size.6" style="width:70px;">
</div></div>
</div>

<div id="prop_adresa" style="display:none;">
<div class="workstep"><div class=worklabel>Judet:</div><div class=workfields><select name="pf_judet" class="validated" validate="notfor.bucuresti.show.id.pf_locspan~for.bucuresti.show.id.pf_sectspan~call.pregatesteAutocomplete.pf_judet.pf_localitate.pf_sector~required.yes">
	<option value="">--Selectati--</option>
<option value="bucuresti">BUCURESTI</option>
<option value="ilfov">Ilfov</option>
<option value="alba">Alba</option>
<option value="arad">Arad</option>
<option value="arges">Arges</option>
<option value="bacau">Bacau</option>
<option value="bihor">Bihor</option>
<option value="bistrita">Bistrita-Nasaud</option>
<option value="botosani">Botosani</option>
<option value="braila">Braila</option>
<option value="brasov">Brasov</option>
<option value="buzau">Buzau</option>
<option value="calarasi">Calarasi</option>
<option value="caras">Caras-Severin</option>
<option value="cluj">Cluj</option>
<option value="constanta">Constanta</option>
<option value="covasna">Covasna</option>
<option value="dambovita">Dambovita</option>
<option value="dolj">Dolj</option>
<option value="galati">Galati</option>
<option value="giurgiu">Giurgiu</option>
<option value="gorj">Gorj</option>
<option value="harghita">Harghita</option>
<option value="hunedoara">Hunedoara</option>
<option value="ialomita">Ialomita</option>
<option value="iasi">Iasi</option>
<option value="maramures">Maramures</option>
<option value="mehedinti">Mehedinti</option>
<option value="mures">Mures</option>
<option value="neamt">Neamt</option>
<option value="olt">Olt</option>
<option value="prahova">Prahova</option>
<option value="salaj">Salaj</option>
<option value="satu">Satu Mare</option>
<option value="sibiu">Sibiu</option>
<option value="suceava">Suceava</option>
<option value="teleorman">Teleorman</option>
<option value="timis">Timis</option>
<option value="tulcea">Tulcea</option>
<option value="valcea">Valcea</option>
<option value="vaslui">Vaslui</option>
<option value="vrancea">Vrancea</option>
	</select>
</div></div>
</div>

<div id="pf_locspan" style="display:none;">
	<div class="workstep"><div class=worklabel>Localitate:</div><div class=workfields><input name="pf_localitate" id="pf_localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pf_localitate&lkjudet=[pf_judet]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18>
	</div></div>
</div>

<div id="pf_sectspan" style="display:none;">
	<div class="workstep"><div class=worklabel>Sector:</div><div class=workfields><select id="pf_sector" name="pf_sector" class="validated pf_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pf_adresa');"><option value=""> Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select>
	</div></div>
</div>

</div><!-- pf -->

<div id="tarifarofertapj" style="display:none">

<div class="workstep"><div class=worklabel>CUI (fara RO):</div><div class=workfields><input type="number" name="pj_cui" size=12 value="" class="validated" validators="change.keyup" validate="if.pj_cetatean.true.required.cui">
</div></div>

<div class="workstep"><div class=worklabel>Firma</div><div class=workfields><select name="pj_cetatean"><option value="true">Romaneasca</option><option value="false">Straina</option></select>
</div></div>

<div class="workstep"><div class=worklabel>Adresa</div><div class=workfields><select name="adresapj" class="validated validateundo" validators="change" validate="for.alta.show.id.pj_adresaraw.prop_pj_adresa~required.yes">
	<option class="option0" value="">--Selectati--</option>
	<option class="option0" value="prop" selected>Aceeasi adresa</option>
	<option class="option0" value="alta">Alta adresa</option>
</select>
</div></div>

<div id="pj_adresaraw" style="display:none;">
<div class="workstep"><div class=workfields style="text-align:right;height:110px;"><textarea name="pj_adresa" style="display:none;"></textarea>
Strada: <input type="text" onchange="javascript:textareaImplode('pj_adresa');" label="str" class="pj_adresa_implode validated" validators="change.click" validate="required.attention" name="pj_adresa_str" size="28" value="">
<br>
nr&nbsp;<input type="text" onchange="javascript:textareaImplode('pj_adresa');" label="nr" class="pj_adresa_implode validated" validators="change.click" validate="required.attention" name="pj_adresa_nr" size="1" value="" style="width:30px;">
,bl&nbsp;<input type="text" onchange="javascript:textareaImplode('pj_adresa');" label="bl" class="pj_adresa_implode" name="pj_adresa_bl" size="1" value="" style="width:30px;">
,sc&nbsp;<input type="text" onchange="javascript:textareaImplode('pj_adresa');" label="sc" class="pj_adresa_implode" name="pj_adresa_sc" size="1" value="" style="width:30px;">
,et&nbsp;<input type="text" onchange="javascript:textareaImplode('pj_adresa');" label="et" class="pj_adresa_implode" name="pj_adresa_et" size="1" value="" style="width:30px;">
<br>
ap&nbsp;<input type="text" onchange="javascript:textareaImplode('pj_adresa');" label="ap" class="pj_adresa_implode" name="pj_adresa_ap" size="1" value="" style="width:30px;">
, cod postal&nbsp;<input type="number" onchange="javascript:textareaImplode('pj_adresa');" label="zip" class="adresa_implode validated" name="pj_adresa_zip" size="3" value="" validate="if.p_soc.omniasig.required.size.6"  style="width:40px;">
</div></div>
</div>

<div id="prop_pj_adresa" style="display:none;">
<div class="workstep"><div class=worklabel>Judet:</div><div class=workfields><select name="pj_judet" class="validated" validate="notfor.bucuresti.show.id.pj_locspan~for.bucuresti.show.id.pj_sectspan~call.pregatesteAutocomplete.pj_judet.pj_localitate.pj_sector~required.yes">
<option value="">--Selectati--</option>
<option value="bucuresti">BUCURESTI</option>
<option value="ilfov">Ilfov</option>
<option value="alba">Alba</option>
<option value="arad">Arad</option>
<option value="arges">Arges</option>
<option value="bacau">Bacau</option>
<option value="bihor">Bihor</option>
<option value="bistrita">Bistrita-Nasaud</option>
<option value="botosani">Botosani</option>
<option value="braila">Braila</option>
<option value="brasov">Brasov</option>
<option value="buzau">Buzau</option>
<option value="calarasi">Calarasi</option>
<option value="caras">Caras-Severin</option>
<option value="cluj">Cluj</option>
<option value="constanta">Constanta</option>
<option value="covasna">Covasna</option>
<option value="dambovita">Dambovita</option>
<option value="dolj">Dolj</option>
<option value="galati">Galati</option>
<option value="giurgiu">Giurgiu</option>
<option value="gorj">Gorj</option>
<option value="harghita">Harghita</option>
<option value="hunedoara">Hunedoara</option>
<option value="ialomita">Ialomita</option>
<option value="iasi">Iasi</option>
<option value="maramures">Maramures</option>
<option value="mehedinti">Mehedinti</option>
<option value="mures">Mures</option>
<option value="neamt">Neamt</option>
<option value="olt">Olt</option>
<option value="prahova">Prahova</option>
<option value="salaj">Salaj</option>
<option value="satu">Satu Mare</option>
<option value="sibiu">Sibiu</option>
<option value="suceava">Suceava</option>
<option value="teleorman">Teleorman</option>
<option value="timis">Timis</option>
<option value="tulcea">Tulcea</option>
<option value="valcea">Valcea</option>
<option value="vaslui">Vaslui</option>
<option value="vrancea">Vrancea</option>
	</select>
</div></div>
</div>

<div id="pj_locspan" style="display:none;">
	<div class="workstep"><div class=worklabel>Localitate:</div><div class=workfields><input name="pj_localitate" id="pj_localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pj_localitate&lkjudet=[pj_judet]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18>
	</div></div>
</div>

<div id="pj_sectspan" style="display:none;">
	<div class="workstep"><div class=worklabel>Sector:</div><div class=workfields><select id="pj_sector" name="pj_sector" class="validated pj_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pj_adresa');"><option value=""> Sector...</option>
		<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
		<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
		</select>
	</div></div>
</div>

</div><!-- pj -->
</div><!-- col2 -->

<input type=hidden name="p_per" value="12" class="validated" validate="addmonths.panalavalabilitate.datavalabilitate">
<input type=hidden name="panalavalabilitate" id="panalavalabilitate" value="">
<input type=hidden name="emite"  value="bonus">

</div>

