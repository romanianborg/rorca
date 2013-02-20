<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Afiseaza tarife">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="rca">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/masina.png" border=0> DATE AUTOVEHICUL</div>
</div>

<div class="workstep"><div class="worklabel">Categorie Vehicul</div>
	<div class=workfields><input type="hidden" value="autoturism" name="codcateg">
			<select validate="get.cod.categ" validators="change" class="validated" name="categorie" title="Talon nou: J, Talon vechi: 6">
<option categ="autoturism" value="autoturism">autoturism</option>
<option categ="autoturism" value="autoturism de teren">autoturism de teren</option>
<option categ="autoturism" value="automobil mixt">automobil mixt</option>
<option categ="autoutilitara" value="autoutilitara">autoutilitara</option>
<option categ="remorca" value="atas">atas</option>
<option categ="motociclu" value="atv">atv</option>
<option categ="alte" value="autobasculanta">autobasculanta</option>
<option categ="alte" value="autobetoniera">autobetoniera</option>
<option categ="autocar" value="autobuz">autobuz</option>
<option categ="autocar" value="autobuz articulat">autobuz articulat</option>
<option categ="autocar" value="autobuz interurban">autobuz interurban</option>
<option categ="autocar" value="autobuz special">autobuz special</option>
<option categ="autocar" value="autobuz urban">autobuz urban</option>
<option categ="alte" value="autocamion">autocamion</option>
<option categ="alte" value="autocamionete pick-up">autocamionete pick-up</option>
<option categ="alte" value="autocisterna">autocisterna</option>
<option categ="autocar" value="autocar">autocar</option>
<option categ="alte" value="autofurgoneta">autofurgoneta</option>
<option categ="alte" value="automacara">automacara</option>
<option categ="alte" value="alte autovehicule">alte autovehicule</option>
<option categ="autoturism" value="autorulota">autorulota</option>
<option categ="autoturism" value="autosanitara">autosanitara</option>
<option categ="autoutilitara" value="autospeciala">autospeciala</option>
<option categ="autoturism" value="autoatelier">autoatelier</option>
<option categ="alte" value="autotractor">autotractor</option>
<option categ="alte" value="autotractor cu sa">autotractor cu sa</option>
<option categ="alte" value="buldozer">buldozer</option>
<option categ="alte" value="camion">camion</option>
<option categ="alte" value="cap tractor">cap tractor</option>
<option categ="alte" value="combina">combina</option>
<option categ="alte" value="compactor">compactor</option>
<option categ="alte" value="excavator">excavator</option>
<option categ="alte" value="buldoexcavator">buldoexcavator</option>
<option categ="alte" value="greder">greder</option>
<option categ="alte" value="incarcator">incarcator</option>
<option categ="autocar" value="microbuz">microbuz</option>
<option categ="motociclu" value="motocicleta">motocicleta</option>
<option categ="motociclu" value="moped">moped</option>
<option categ="motociclu" value="motoreta">motoreta</option>
<option categ="motociclu" value="motocositoare">motocositoare</option>
<option categ="remorca" value="remorca">remorca</option>
<option categ="remorca" value="rulota">rulota</option>
<option categ="motociclu" value="scuter">scuter</option>
<option categ="remorca" value="semiremorca">semiremorca</option>
<option categ="alte" value="stivuitor">stivuitor</option>
<option categ="tractor" value="tractor">tractor</option>
<option categ="tramvai" value="tramvai">tramvai</option>
<option categ="tramvai" value="troleibuz">troleibuz</option>
<option categ="alte" value="utilaje">utilaje</option>
<option categ="alte" value="utilaje cu senile">utilaje cu senile</option>
<option categ="alte" value="utilaje pe pneuri">utilaje pe pneuri</option>
			</select>
</div></div>

<div class="workstep"><div class="worklabel">Marca:</div><div class="workfields"><input type="text" validate="uppercase~required.yes" class="autocompletefield validated ac_input validateatention" lk="coduri/code.php?soc=allianz&amp;grupa=marci&amp;valoare=&amp;lookupfor=marca" name="marca" size="20" id="marca" value="" autocomplete="off" title="Talon nou: D.1, Talon vechi: 8">
</div></div>

<div class="workstep"><div class="worklabel">Model:</div><div class="workfields"><input type="text" validate="uppercase~required.yes" class="validated validateatention" name="model" size="20" value="" title="Talon nou: D.3, Talon vechi: 9">
</div></div>

<div class="workstep"><div class="worklabel">Numar inmatriculare:</div><div class="workfields"><input type="text" validate="uppercase~if.inmatriculare.inmatriculate.required.yes~if.inmatriculare.inregistrate.required.yes~if.inmatriculare.urmeazainmatriculate.required.no~if.inmatriculare.urmeazainregistrate.required.no~replace.-.. ../." class="validated validateatention" size="20" name="nrinm" value="" title="Talon nou: A, Talon vechi: 1">
</div></div>

<div class="workstep"><div class="worklabel">Serie sasiu:</div><div class="workfields"><input type="text" size="20" validate="uppercase~nokeys.73.79~required.yes~required.minmax.4.17~required.correct.17.6~replace.o.0.i.1" validators="change.keyup.keydown" class="validated validateatention" name="seriesasiu" value="" title="Talon nou: E, Talon vechi: 3">
</div></div>

<div class="workstep"><div class="worklabel">Sursa de energie</div><div class="workfields"><select validate="required.yes" class="validated" name="propulsie" title="Talon nou: P.3, Talon vechi: 17">
	<option value="">Selectati</option>
	<option value="Gasoline">Benzina</option>
	<option value="Diesel">Motorina</option>
	<option value="GPL">Gaz</option>
	<option value="ElectricHybrid">Electric-hibrid</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel">Cilindree:</div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="cilindree" value="" style="width:65px;" title="Talon nou: P.1, Talon vechi: 17"> (cmc)
	</div></div>

<div class="workstep"><div class="worklabel">Putere motor: </div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="cp" id="cp" value="" style="width:65px;" title="Talon nou: P.12, Talon vechi: 17"> (kw)
	</div></div>

<div class="workstep"><div class="worklabel">Masa maxima total autorizata:</div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="kg" value="" style="width:65px;" title="Talon nou: F.1, Talon vechi: 11"> (kg)
	</div></div>

<div class="workstep"><div class="worklabel">Nr. locuri:</div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="locuri" id="locuri" value="" style="width:65px;" title="Talon nou: S.1, Talon vechi: 13"> (loc)
	</div></div>

<div class="workstep"><div class="worklabel">An fabricatie:</div><div class="workfields"><select validate="required.yes" class="validated validateatention" name="anfabricatie" title="Talon nou: B, Talon vechi: 15"><option value="">An fabr.</option>
<?php for($i=intval(date('Y'))+1;$i>=1970;$i--)
{
?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php
}
?>
</select>
</div></div>

<div class="workstep"><div class="worklabel">Rca valabil din</div><div class=workfields><input type="text" value="<?php echo date('d.m.Y',time()+60*60*24);?>" size="9" id="datavalabilitate" name="datavalabilitate" validate="required.date" validators="change" class="validated">&nbsp;<a href="#" onclick="global_cal.select(document.forms['work'].datavalabilitate,'datavalabilitate_sel','dd.MM.yyyy'); return false;" name="datavalabilitate_sel" id="datavalabilitate_sel"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Vehiculul este:</div><div class=workfields>
			<select validate="for.inmatriculate|inregistrate.show.id.spanciv~required.yes" class="validated" name="inmatriculare">
			<option value="inmatriculate">Inmatriculat la POLITIE</option>
			<option value="urmeazainmatriculate">- Urmeaza la POLITIE</option>
			<option value="inregistrate">Inregistrat la PRIMARIE</option>
			<option value="urmeazainregistrate">- Urmeaza la PRIMARIE</option>
			</select>
</div></div>

</div><div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/individ.png" border=0> DATE PROPRIETAR</div></div>


<div class="workstep"><div class="worklabel">Proprietar Vehicul</div><div class="workfields"><select validate="for.leasing.show.id.tarifarofertaleasing~revalidate.tiputilizator~for.pf.show.id.tarifarofertapf~for.pj.show.id.tarifarofertapj~for.pf|pj.show.id.utilizatorvehicul~required.yes" validators="change" class="validated validateundo" name="tipproprietar">
	<option value="">--Selectati--</option>
	<option value="pf">Persoana Fizica</option>
	<option value="pj">Persoana Juridica</option>
	<option value="leasing">Masina e in Leasing</option>
</select>
</div></div>

<!-- tarifarofertaleasing--><div id="tarifarofertaleasing">

<div class="workstep"><div class="worklabel">Firma leasing:</div><div class="workfields"><input type="text" validate="uppercase" class="validation doaremitere" size="20" value="" name="leasingname">
</div></div>

<div class="workstep"><div class="worklabel">Cui leasing:</div><div class="workfields"><input type="number" validators="change.keyup" validate="required.cui" class="validated validateatention" value="" name="leasingcui" size="10">
</div></div>

<div class="workstep"><div class="worklabel">Judet:</div><div class="workfields"><select name="leasingjudet" class="validated" validate="notfor.bucuresti.show.id.leas_locspan~for.bucuresti.show.id.leas_sectspan~call.pregatesteAutocomplete.leasingjudet.leasinglocalitate.leas_sector~required.yes">
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

<div id="leas_locspan" style="display:none;">
<div class="workstep"><div class="worklabel">Localitate:</div><div class="workfields"><input type="text" name="leasinglocalitate" value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=leasinglocalitate&lkjudet=[leasingjudet]" class="autocompletefield validated" validate="required.yes">
</div></div>
</div>

<div id="leas_sectspan" style="display:none;">
<div class="workstep"><div class="worklabel">Sector</div><div class="workfields"><select id="leas_sector" name="leas_sector" class="validated leas_adresa_implode" validators="change" validate="if.leasingjudet.bucuresti.required.yes" label="sector" onchange="javascript:textareaImplode('leas_adresa');"><option value=""></option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select></span>
</div></div>
</div>

<div class="workstep"><div class="worklabel">Tip Utilizator</div><div class="workfields"><select validate="for.pf.show.id.tarifarofertapf~for.pj.show.id.tarifarofertapj~required.yes" validators="change" class="validated validateatention validateundo" name="tiputilizator">
	<option value="" class="option0">--Selectati--</option>
	<option value="pf" class="option0">Persoana Fizica</option>
	<option value="pj" class="option0">Persoana Juridica</option>
</select>
</div></div>

<!-- tarifarofertaleasing--></div>

<!-- tarifarofertapf --><div id=tarifarofertapf>

<div class="workstep"><div class="worklabel">Tip persoana:</div><div class="workfields"><select name=pf_tippersoana>
	<option value="pf">PF</option>
	<option value="pf,bugetar">Bugetar</option>
	<option value="pf,familieb">Familie bugetari</option>
	<option value="pf,pensionar">Pensionar</option>
	<option value="pf,veteran">Veteran</option>
	<option value="pf,handicap">Handicap Locomotor</option>
</select>
</div></div>

<div class="workstep"><div class="worklabel">CNP:</div><div class="workfields"><input type="number" validate="extract.varsta.varsta~required.cnp" validators="change.keyup" class="validated validateatention" value="" size="15" name="pf_cnp"><input type="hidden" value="" name="varsta">
</div></div>

<div class="workstep"><div class="worklabel">Judet:</div><div class="workfields"><select name="pf_judet" type="text" class="validated" validate="notfor.bucuresti.show.id.pf_locspan~for.bucuresti.show.id.pf_sectspan~call.pregatesteAutocomplete.pf_judet.pf_localitate.pf_sector~required.yes">
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
<div class="workstep"><div class="worklabel">Localitate:</div><div class="workfields"><input name="pf_localitate" id="pf_localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pf_localitate&lkjudet=[pf_judet]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18>
</div></div>
</div>

<div id=pf_sectspan>
<div class="workstep"><div class="worklabel">Sector:</div><div class="workfields"><select id="pf_sector" name="pf_sector" class="validated pf_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pf_adresa');"><option value=""> Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select>
</div></div>
</div>

<div class="workstep"><div class="worklabel">Permis din anul:</div><div class="workfields">
<select name="pf_permisan">
<option value="">Nespecificat</option>
<?php for($i=intval(date('Y'));$i>=1970;$i--)
{
?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php
}
?>
</select>
<input type=hidden name="pf_permisluna" value=1>
</div></div>

<div class="workstep"><div class="worklabel">Copii minori</div><div class="workfields"><select class="validated" name="pf_copii"><option value="">Nespecificat</option><option value="1">Un copil</option><option value="2">Doi copii</option><option value="3">3 sau mai multi</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Destinatie vehicul:</div><div class="workfields"><select class="validated" name="pf_destinatie">
		<option value="">Uz personal</option>
		<option value="taxi">Taxi</option>
		<option value="rent">Rent a car</option>
		<option value="paza">Paza</option>
		<option value="interventie">Interventie</option>
		<option value="curierat">Curierat</option>
		<option value="scoala">Scoala soferi</option>
		<option value="distributie">Distributie</option>
		<option value="construct">Constructii</option>
		<option value="agric">In Agricultura</option>
		<option value="forest">Uz Forestier</option>
		<option value="transport,internat">Transport International</option>
		<option value="transport,urban">Transport Urban</option>
		<option value="transport,persoan">Transport Persoane</option>
	</select>
	</div></div>

<div class="workstep"><div class="worklabel">Asigurat Casco la:</div><div class="workfields"><select class="validated" name="pf_casco">
			<option value="">Fara casco</option>
			<option value="allianz">Allianz</option>
<option value="uniqa">Uniqa</option>
<option value="ardaf">Ardaf</option>
<option value="asirom">Asirom</option>
<option value="generali">Generali</option>
<option value="euroins">Euroins</option>
<option value="astra">Astra</option>
<option value="omniasig">Omniasig</option>
<option value="grupama">Groupama</option>
<option value="carpatica">Carpatica</option>
<option value="abc">Abc</option>
<option value="city">City</option>
			</select>
</div></div>

<!-- tarifarofertapf --></div>

<!-- tarifarofertapj --><div id=tarifarofertapj>
<div class="workstep"><div class="worklabel">Tip persoana:</div><div class="workfields"><select name=pj_tippersoana>
	<option value="pj">PJ</option>
	<option value="pj,fa">PFA</option>
	<option value="pj,bancare">Banci-Finante</option>
	<option value="pj,institutii">Institutii de stat</option>
	<option value="pj,sanitar">Unitati sanitare</option>
	<option value="pj,cultur,invatamant">Cultura, invatamant</option>
	<option value="pj,regii autonome">Regii autonome</option>
	<option value="pj,fundatii">Fundatii umanitare</option>
	<option value="pj,corp,institutii">Corp Diplomatic</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel">CUI (fara RO):</div><div class="workfields"><input type="text" validate="required.cui" validators="change.keyup" class="validated validateatention" value="" size="12" name="pj_cui">
</div></div>

<div class="workstep"><div class="worklabel">Judet:</div><div class="workfields"><select name="pj_judet"  class="validated" validate="notfor.bucuresti.show.id.pj_locspan~for.bucuresti.show.id.pj_sectspan~call.pregatesteAutocomplete.pj_judet.pj_localitate.pj_sector~required.yes">
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
<div class="workstep"><div class="worklabel">Localitate: </div><div class="workfields"><input name="pj_localitate"  type="text" id="pj_localitate" value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pj_localitate&lkjudet=[pj_judet]" class="autocompletefield validated " mustmatch=yes validate="required.yes">
</div></div>
</div>

<div  id="pj_sectspan" style="display:none;">
<div class="workstep"><div class="worklabel">Sector: </div><div class="workfields"><select id="pj_sector" name="pj_sector" class="validated pj_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pj_adresa');"><option value="">Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select></span>
</div></div>
</div>

<div class="workstep"><div class="worklabel">Destinatie:</div><div class="workfields"><select class="validated" name="pj_destinatie">
		<option value="">Uz personal</option>
		<option value="taxi">Taxi</option>
		<option value="rent">Rent a car</option>
		<option value="paza">Paza</option>
		<option value="interventie">Interventie</option>
		<option value="curierat">Curierat</option>
		<option value="scoala">Scoala soferi</option>
		<option value="distributie">Distributie</option>
		<option value="construct">Constructii</option>
		<option value="agric">In Agricultura</option>
		<option value="forest">Uz Forestier</option>
		<option value="transport,internat">Transport International</option>
		<option value="transport,urban">Transport Urban</option>
		<option value="transport,persoan">Transport Persoane</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel">Am Casco la:</div><div class="workfields"><select class="validated" name="pj_casco">
			<option value="">Fara casco</option>
<option value="allianz">Allianz</option>
<option value="uniqa">Uniqa</option>
<option value="ardaf">Ardaf</option>
<option value="asirom">Asirom</option>
<option value="generali">Generali</option>
<option value="euroins">Euroins</option>
<option value="astra">Astra</option>
<option value="omniasig">Omniasig</option>
<option value="grupama">Groupama</option>
<option value="carpatica">Carpatica</option>
<option value="abc">Abc</option>
<option value="city">City</option>
			</select>
</div></div>

<div class="workstep"><div class="worklabel">Parc auto:</div><div class="workfields"><input type="number" class="validated" value="" size="4" name="parcauto"><input type=hidden name="pj_rate" value="1">
</div></div>

<!-- tarifarofertapj --></div>

<?php if(getUserConfig("emaildinprima")=="yes") {?>
<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name="emailclient" value="" class="validated" validate="required.email" size="20" type="email">
</div></div>
<?php }?>

</div>

