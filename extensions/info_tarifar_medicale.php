<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Vezi tarife">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="medicale">
<input name="tipproprietar" value="pf" type="hidden">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/globe.png" border=0> DATE CALATORIE</div>
</div>

<div class="workstep"><div class="worklabel">Pleci in data de</div><div class=workfields><input class="validated" validators="change" validate="call.calculeazaNrZile~required.date" type=text name="datavalabilitate" id="datavalabilitate" size="9" value="<?php echo date('d.m.Y',time()+60*60*24);?>">
	<a class="cdateselect" id="datavalabilitate_sel" name="datavalabilitate_sel" onclick="global_cal.select(document.forms['work'].datavalabilitate,'datavalabilitate_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Pana la</div><div class=workfields><input class="validated" validators="change" validate="call.calculeazaNrZile~required.date" type=text name="panalavalabilitate" id="panalavalabilitate" size="9" value="">
	<a class="cdateselect" id="panalavalabilitate_sel" name="panalavalabilitate_sel" onclick="global_cal.select(document.forms['work'].panalavalabilitate,'panalavalabilitate_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Numar de zile</div><div class=workfields><input type="number" name="nrzile" value="" size=4 class="validated" validate="adddays.panalavalabilitate.datavalabilitate~required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Unde pleci?:</div><div class=workfields><input size=14 type="text" name="taridest" class="autocompletefield validated"  mustmatch="yes" validate="required.yes" value="" lk="coduri/code.php?soc=tari&grupa=tari&valoare=&lookupfor=taridest">
</div></div>

<div class="workstep"><div class="worklabel">Scop calatorie:</div><div class=workfields><select name="scop">
		<option value="turist">Turist</option>
		<option value="afaceri">Afaceri</option>
		<option value="sofer">Sofer profesionist</option>
		<option value="studii">Studii, cercetare...</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel">Sport/Ski:</div><div class=workfields><select name="sporturi">
	<option value="">nu</option>
	<option value="da">da</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel">Asigurare bagaje:</div><div class=workfields>
	<select name="bagaje">
		<option value="1">Da, cu electronice</option>
		<option value="2" selected>Da, fara electronice</option>
		<option value="0">Nu</option>
	</select>
</div></div>

</div>

<div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE CALATOR</div>
</div>

<div class="workstep"><div class="worklabel">Tip persoana:</div><div class=workfields><select name=pf_tippersoana>
	<option value="pf">PF</option>
	<option value="pf,bugetar">Bugetar</option>
	<option value="pf,familieb">Familie bugetari</option>
	<option value="pf,pensionar">Pensionar</option>
	<option value="pf,veteran">Veteran</option>
	<option value="pf,handicap">Cu handicap</option>
</select>
</div></div>

<div class="workstep"><div class="worklabel">CNP:</div><div class=workfields><input type="number" name="pf_cnp" size=12 value="" class="validated" validators="change.keyup" validate="extract.varsta.varsta~required.cnp"> <input type="hidden" name="varsta">
</div></div>

<div class="workstep"><div class="worklabel">Judet:</div><div class=workfields><select name="pf_judet" class="validated" validate="notfor.bucuresti.show.id.pf_locspan~for.bucuresti.show.id.pf_sectspan~call.pregatesteAutocomplete.pf_judet.pf_localitate.pf_sector~required.yes">
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

<div id="pf_locspan" style="display:none;">
<div class="workstep"><div class="worklabel">Localitate:</div><div class=workfields><input name="pf_localitate" id="pf_localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pf_localitate&lkjudet=[pf_judet]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18>
</div></div>
</div>

<div id="pf_sectspan" style="display:none;">
<div class="workstep"><div class="worklabel">Sector:</div><div class=workfields><select id="pf_sector" name="pf_sector" class="validated pf_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pf_adresa');"><option value=""> Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select>
</div></div>
</div>


<div class="workstep"><div class="worklabel">Grup:</div><div class=workfields><select name="grupuri">
	<option value="1">nu</option>
	<option value="2">familie</option>
	<option value="3">tineri/minori</option>
	<option value="10">peste 10 persoane</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel">Limita acoperire:</div><div class=workfields>
	<select name="acoperire">
		<option value="10000">10000 EUR</option><option value="30000">30000 EUR</option><option value="50000">50000 EUR</option>
	</select>
</div></div>


</div>

</div>

