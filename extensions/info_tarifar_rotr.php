<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Vezi tarife">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="rotr">
<input name="tipproprietar" value="pj" type="hidden">
<input name="samoneda" value="EURO" type="hidden">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/masina.png" border=0> DATE ASIGURARE</div>
</div>

<div class="workstep"><div class="worklabel">Produs dorit:</div><div class=workfields><select name="tipasig" class="validated" validate="for.cmr.show.class.tippolitacmr~for.rotr.show.class.tippolitarotr">
<option value="rotr">ROTR</option><option value="cmr">CMR</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Suma asigurata:</div><div class=workfields><input name="sumasig" size="10" value="" class="validated validateatention" validate="replace.(pt)..,.~required.yes" type="text">&euro;
</div></div>

<div class="workstep"><div class="worklabel">Tip trafic:</div><div class=workfields><select name="trafic" class="validated" validate="required.yes"><option value="intern">Intern</option><option value="extern">Extern</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Cota:</div><div class=workfields><input name="cota" value="1" size="2" type="text">
</div></div>

<div class="workstep"><div class="worklabel">Numar Masini:</div><div class=workfields><input name="nrmasini" size="5" value="1" class="validated" validate="duplicate._1~required.yes" type="text">
</div></div>

<div class="tippolitacmr" style="display:none;">
<div class="workstep"><div class="worklabel">Locuri Totale:</div><div class=workfields><input name="locuri" size="5" value="" class="validated" validate="if.tipasig.cmr.required.yes" type="text">
</div></div>
</div>

<div class="tippolitacmr" style="display:none;">
<div class="workstep"><div class="worklabel">Tip vehicul:</div><div class=workfields><select name="tiphevicul" class="validated" validate="required.yes"><option value="vechicul">VEHICUL</option><option value="nava">NAVA</option><option value="transp_cablu_aerian">TRANSP CABLU AERIAN</option></select>
</div></div>
</div>

<div class="tippolitacmr" style="display:none;">
<div class="workstep"><div class="worklabel">Plecare din:</div><div class=workfields><input name="punctplecare" type="text">
</div></div>
</div>

<div class="tippolitacmr" style="display:none;">
<div class="workstep"><div class="worklabel">Sosire in:</div><div class=workfields><input name="punctsosire" type="text">
</div></div>
</div>


<div class="tippolitacmr" style="display:none;">
<div class="workstep"><div class="worklabel">Data plecare:</div><div class=workfields>
	<input name="datatrasp" value="" id="datatrasp" class="validated validateatention" validate="required.yes" size="10" type="text">
	<a class="cdateselect" id="datatrasp_sel" name="datatrasp_sel" onclick="global_cal.select(document.forms['work'].datatrasp,'datatrasp_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>
</div>

<div class="tippolitacmr" style="display:none;">
<div class="workstep"><div class="worklabel">Data sosire:</div><div class=workfields>
	<input name="datatrasp_final" value="" id="datatrasp_final" class="validated validateatention" validate="required.yes" size="10" type="text">
	<a class="cdateselect" id="datatrasp_selpanala" name="datatrasp_selpanala" onclick="global_cal.select(document.forms['work'].datatrasp_final,'datatrasp_selpanala','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>
</div>

<div class="tippolitacmr" style="display:none;">
<div class="workstep"><div class="worklabel">Bunuri transportate:</div><div class=workfields>
<select name="bunuri">
		<option value="1">Bunuri generale (altele decat cele mentionate mai jos si in conditiile de asigurare)</option>
		<option value="2">Fructe si legume, produse alimentare fara acoperirea riscului de defectare a agregatelor frigorifice</option>
		<option value="3">Marfa in vrac, seminte, cereale, leguminoase, faina, zahar,sare si similare, ciment, ipsos si similare</option>
		<option value="4">Mobila, cherestea, pal, placaj si similare</option>
		<option value="5">Alte bunuri</option>
		</select></div></div>
</div>



</div>

<div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE ASIGURAT</div>
</div>


<div class="workstep"><div class=worklabel>CUI (fara RO):</div><div class=workfields><input type="number" name="pj_cui" size=12 value="" class="validated" validators="change.keyup" validate="if.pj_cetatean.true.required.cui">
</div></div>

<div class="workstep"><div class=worklabel>Firma</div><div class=workfields><select name="pj_cetatean"><option value="true">Romaneasca</option><option value="false">Straina</option></select>
</div></div>


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

<div class="workstep"><div class=worklabel>CAEN (4 cifre):</div><div class=workfields><input type=text name="caen" value="" class="validated validateatention" validate="required.yes">
</div></div>

<div class="workstep"><div class=worklabel>Cod Reg. Comert:</div><div class=workfields><input type=text  name="codj" value="" class="validated validateatention" validate="required.yes">
</div></div>

<div class="workstep"><div class=worklabel>Licenta transport:</div><div class=workfields><input type=text name="licenta" value="">
</div></div>

<div class="workstep"><div class=worklabel>Cifra de afacere:</div><div class=workfields><input name="pj_capital" class="validated validateatention" validate="required.yes" value="" size="10">
</div></div>

<div class="workstep"><div class="worklabel" style="width:215px;">Declar ca: am citit si sunt de acord cu termenele si conditiile de folosire a acestui site, am peste 18 ani, datele si informatiile furnizate sunt reale la momentul completarii cererii.</div><div class="workfields"  style="width:55px;"><select  style="width:50px;" class=validated validate="required.yes" name="acord" title="Acord termene si conditii"><option value=''>?</option><option value=''>Nu</option><option value='da'>Da</option></select>
</div></div>

</div>
</div>

