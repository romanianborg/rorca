<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Vezi tarife">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="malpraxis">
<input name="sa_moneda" value="EURO" type="hidden">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE ASIGURAT</div>
</div>

<div class="workstep"><div class="worklabel">Tip asigurare</div><div class=workfields><select name="profesie" class="validated validateatention" validate="for.MalpraxisMedical.show.id.nrpaturirand~for.MalpraxisMedical.show.class.doarmedical~for.Avocat|ContabilExpert.show.class.doaravocati~required.yes"><option value="">Selectati profesia...</option>
	<option value="MalpraxisMedical">Doctor/Malpraxis Medical</option>
	<option value="ContabilAutorizat">Contabil Autorizat</option>
	<option value="ContabilExpert">Expert Contabil</option>
	<option value="Evaluator">Evaluator</option>
	<option value="PracticianInsolventa">Practician Insolventa</option>
	<option value="Avocat">Avocat</option>
	<option value="Notar">Notar</option>
	<option value="ExecutorJudecatoresc">Executor Judecatoresc</option>
	<option value="Veterinar">Veterinar</option>
	<option value="Brokeri">Brokeri</option>
	<option value="AgentiPJ">Agenti PJ</option>
	<option value="AgentiPF">Agenti PF</option>
	<option value="Cadastru">Cadastristi, Geodezi</option>
</select>
</div></div>

<div class="workstep"><div class="worklabel">Suma asigurata EURO</div><div class=workfields><input type=number name="sa" value="" class="validated validateatention" validate="required.yes" size="6">
</div></div>

<div class="workstep"><div class="worklabel">Daune morale:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="daunemorale" value="1" checked style="width:60px;text-align:left;">
</div></div>

<div class="workstep"><div class="worklabel">Tip asigurat</div><div class=workfields><select name="tipproprietar" class="validated validateatention" validators="change" validate="for.pf.show.id.tarifarofertapf~for.pf.revalidate.pf_judet~for.pj.show.id.tarifarofertapj~for.pj.revalidate.pj_judet~required.yes~revalidate.utilizator">
	<option class="option0" value="">--Selectati--</option>
	<option class="option0" value="pf">Fizica</option>
	<option class="option0" value="pj">Juridica</option>
</select>
</div></div>

</div>

<div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE PERSONALE</div>
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


<!-- tarifarofertapf --><div id=tarifarofertapf>


<div class="workstep"><div class="worklabel">CNP:</div><div class="workfields"><input type="number" validate="extract.varsta.varsta~required.cnp" validators="change.keyup" class="validated validateatention" value="" size="15" name="pf_cnp"><input type="hidden" value="" name="varsta">
</div></div>

<div class="workstep"><div class="worklabel">Judet:</div><div class="workfields"><select name="pf_judet" type="text" class="validated" validate="notfor.bucuresti.show.id.pf_locspan~for.bucuresti.show.id.pf_sectspan~call.pregatesteAutocomplete.pf_judet.pf_localitate.pf_sector~required.yes" title="Conform talon">
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

<div id=pf_locspan>
<div class="workstep"><div class="worklabel">Localitate:</div><div class="workfields"><input name="pf_localitate" id="pf_localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pf_localitate&lkjudet=[pf_judet]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18 title="Conform talon">
</div></div>
</div>

<div id=pf_sectspan>
<div class="workstep"><div class="worklabel">Sector:</div><div class="workfields"><select id="pf_sector" name="pf_sector" class="validated pf_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pf_adresa');" title="Conform talon"><option value=""> Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select>
</div></div>
</div>

<div class="workstep"><div class="worklabel">Studii:</div><div class="workfields"><select name="studii">
	<option value="NA">Nespecificat</option>
	<option value="Medii">Studii Medii</option>
	<option value="Superioare">Studii Superioare</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Stagiar:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="stagiar" value="1" checked style="width:60px;text-align:left;">
</div></div>

<div class="workstep"><div class="worklabel">Servicii medicale:</div><div class="workfields"><select name="pf_serviciimedicale">
	<option value="NA">Fara</option>
	<option value="PFMediciFamilieSiMedicinaGenerala">Medici Familie Si Medicina Generala</option>
	<option value="PFMediciSpecialisti">Medici Specialisti</option>
	<option value="PFMediciSpecialistiChirurgi">Medici Specialisti Chirurgi</option>
	<option value="PFMediciDentisti">Medici Dentisti</option>
	<option value="PFFarmacisti">Farmacisti</option>
	<option value="PFFarmacistiAsistenti">Farmacisti Asistenti</option>
	<option value="PFBiochimistiBiologiSiSpecialitatiParaclinice">Biochimisti/Biologi si Specialitati Paraclinice</option>
	<option value="PFAsistentiMedicaliInUnitatiSanitareCuPaturi">Asistenti Medicali in Unitati sanitare cu paturi</option>
	<option value="PFAsistentiMedicaliMedicinaPrimaraAmbulatorieCabineteIndividuale">Asistenti Medicali cabinete ind./medicina primara</option>
	</select>
</div></div>


<!-- tarifarofertapf --></div>

<!-- tarifarofertapj --><div id=tarifarofertapj>


<div class="workstep"><div class="worklabel">CUI (fara RO):</div><div class="workfields"><input type="text" validate="required.cui" validators="change.keyup" class="validated validateatention" value="" size="12" name="pj_cui">
</div></div>

<div class="workstep"><div class="worklabel">Judet:</div><div class="workfields"><select name="pj_judet"  class="validated" validate="notfor.bucuresti.show.id.pj_locspan~for.bucuresti.show.id.pj_sectspan~call.pregatesteAutocomplete.pj_judet.pj_localitate.pj_sector~required.yes" title="Conform talon">
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
<div class="workstep"><div class="worklabel">Localitate: </div><div class="workfields"><input name="pj_localitate"  type="text" id="pj_localitate" value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pj_localitate&lkjudet=[pj_judet]" class="autocompletefield validated " mustmatch=yes validate="required.yes" title="Conform talon">
</div></div>
</div>

<div  id="pj_sectspan" style="display:none;">
<div class="workstep"><div class="worklabel">Sector: </div><div class="workfields"><select id="pj_sector" name="pj_sector" class="validated pj_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pj_adresa');" title="Conform talon"><option value="">Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select></span>
</div></div>
</div>

<div class="workstep"><div class="worklabel">Servicii medicale:</div><div class="workfields"><select name="pj_serviciimedicale">
	<option value="NA">Fara</option>
	<option value="PJUnitatiSpitalicestiComunaleOrasanesti">Unitati Spitalicesti Comunale Orasanesti</option>
	<option value="PJUnitatiSpitalicestiJudeteneRegionaleUniversitare">Unitati Spitalicesti Judetene Regionale Universitare</option>
	<option value="PJUnitatiSpitalicestiMunicipale">Unitati Spitalicesti Municipale</option>
	<option value="PJUnitatiSpitalicestiPrivate">Unitati Spitalicesti Private</option>
	<option value="PJUnitatiSpecializateTransportSanitar">Unitati Specializate Transport Sanitar</option>
	<option value="PJFurnizoriDispozitiveMedicale">Furnizori Dispozitive Medicale</option>
	<option value="PJFarmacii">Farmacii</option>
	<option value="PJSanatoriiPreventoriiSiUnitatiSanitare">Sanatorii Preventorii Si Unitati Sanitare</option>
	<option value="PJServiciiDeUrgentaSiTransport">Servicii De Urgenta Si Transport</option>
	<option value="PJIngrijiriLaDomiciliu">Ingrijiri La Domiciliu</option>
	<option value="PJServiciiDeUrgentaSiTransport">Servicii De Urgenta Si Transport</option>
	<option value="PJServiciiMedicaleAmbulatoriiDeSpecialitateaSpitalelor">Servicii Medicale Ambulatorii De Specialitatea Spitalelor</option>
	</select>
</div></div>


<!-- tarifarofertapj --></div>

<div class="workstep"><div class="worklabel" style="width:215px;">Declar ca: am citit si sunt de acord cu termenele si conditiile de folosire a acestui site, am peste 18 ani, datele si informatiile furnizate sunt reale la momentul completarii cererii.</div><div class="workfields"  style="width:55px;"><select  style="width:50px;" class=validated validate="required.yes" name="acord" title="Acord termene si conditii"><option value=''>?</option><option value=''>Nu</option><option value='da'>Da</option></select>
</div></div>


</div>

</div>

