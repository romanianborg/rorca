<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Trimite cerere">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="casco">

<input type="hidden" checked name="comp_casco" class="validated" value="1">
<input type="hidden" checked name="comp_acc" class="validated" value="">
<input type="hidden" checked name="comp_bag" class="validated" value="">
<input type="hidden" checked name="comp_rca" class="validated" value="">


<?php
	require_once("config/dateutils.php");
?>
<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/masina.png" border=0> DATE AUTOVEHICUL</div>
</div>

<div class="workstep"><div class="worklabel">Vehiculul este:</div><div class=workfields>
			<select validate="for.inmatriculate|inregistrate.show.id.spanciv~required.yes" class="validated" name="inmatriculare">
			<option value="inmatriculate">Inmatriculat la POLITIE</option>
			<option value="urmeazainmatriculate">- Urmeaza la POLITIE</option>
			<option value="inregistrate">Inregistrat la PRIMARIE</option>
			<option value="urmeazainregistrate">- Urmeaza la PRIMARIE</option>
			</select>
</div></div>

<div class="workstep"><div class="worklabel">Categorie Talon</div><div class=workfields><input type="hidden" name="codcateg" value="">
			<select validate="get.cod.categ" validators="change" class="validated" name="categorie">
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

<div class="workstep"><div class="worklabel">Marca:</div><div class="workfields"><input type="text" validate="uppercase~required.yes" class="autocompletefield validated ac_input validateatention" lk="coduri/code.php?soc=allianz&amp;grupa=marci&amp;valoare=&amp;lookupfor=marca" name="marca" size="15" id="marca" value="" autocomplete="off" title="Talon nou: D.1, Total vechi: 7">
</div></div>

<div class="workstep"><div class="worklabel">Model:</div><div class="workfields"><input type="text" validate="uppercase~required.yes" class="validated validateatention" name="model" size="15" value="" title="Talon nou: D.3, Talon vechi: 9">
</div></div>

<div class="workstep"><div class="worklabel">Varianta:</div><div class=workfields><input type="text" value="" id="modelvarianta" name="modelvarianta" size=15>
</div></div>

<div class="workstep"><div class="worklabel">An fabricatie:</div><div class=workfields><select name="anfabricatie" class="validated" validate="required.yes" title="Masinile mai vechi nu se asigura"><option value="">An fabricatie</option>
<?php
for($i=date('Y')+1;$i>(intval(date('Y'))-9);$i--){
?><option value="<?php echo $i?>"><?php echo $i?></option><?php
}
?></select>
</div></div>

<div class="workstep"><div class="worklabel">Cilindree:</div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="cilindree" value="" style="width:65px;" title="Talon nou: P.1, Talon vechi: 17"> (cmc)
	</div></div>

<div class="workstep"><div class="worklabel">Masa maxima total autorizata:</div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="kg" value="" style="width:65px;" title="Talon nou: P.2, Talon vechi: 17"> (kg)
	</div></div>

<div class="workstep"><div class="worklabel">Putere: </div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="cp" id="cp" value="" style="width:65px;" title="Talon nou: F.1, Talon vechi: 11"> (kw)
	</div></div>

<div class="workstep"><div class="worklabel">Nr. locuri:</div><div class="workfields"><input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="locuri" id="locuri" value="" style="width:65px;" title="Talon nou: S.1, Talon vechi: 13"> (loc)
	</div></div>

<div class="workstep"><div class="worklabel">Sursa</div><div class="workfields"><select validate="required.yes" class="validated" name="propulsie" title="Talon nou: P.3, Talon vechi: 17">
	<option value="">Selectati</option>
	<option value="Gasoline">Benzina</option>
	<option value="Diesel">Motorina</option>
	<option value="GPL">Gaz</option>
	<option value="ElectricHybrid">Electric-hibrid</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel"> Nr. Usi</div><div class=workfields><select name="usi"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5" selected>5</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Numar inmatriculare:</div><div class="workfields"><input type="text" validate="uppercase~if.inmatriculare.inmatriculate.required.yes~if.inmatriculare.inregistrate.required.yes~if.inmatriculare.urmeazainmatriculate.required.no~if.inmatriculare.urmeazainregistrate.required.no~replace.-.. ../." class="validated validateatention" size="10" name="nrinm" value="" title="Talon nou: A, Talon vechi: 1">
</div></div>

<div id=spanciv style="display:none;">
<div class="workstep"><div class="worklabel">seria CIV</div><div class="workfields"><input type="text" class="validated" name="serieciv" size=10 <?php if(getUserConfig("platalibra")=="yes") echo 'validate="require.yes"';?> title="Talon nou: X, Talon vechi: 4">
</div></div></div>

<div class="workstep"><div class="worklabel">Serie sasiu:</div><div class="workfields"><input type="text" size="19" validate="uppercase~nokeys.73.79~required.yes~required.minmax.4.17~required.correct.17.6~replace.o.0.i.1" validators="change.keyup.keydown" class="validated validateatention" name="seriesasiu" value="" title="Talon nou: E, Talon vechi: 3">
</div></div>

</div>
<div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/masina.png" border=0> DATE ASIGURARE</div>
</div>

<div class="workstep"><div class="worklabel">Km la bord:</div><div class=workfields><input type="number" name="kmparcursi" size=5 value="" class="validated" validate="required.yes">
</div></div>

<div class="workstep"><div class="worklabel">KM estimati/an:</div><div class=workfields><input name="kmanuali" type="number" size=5 value="">
</div></div>

<div class="workstep"><div class="worklabel">Soferi:</div><div class=workfields><select name="soferi" class="validated" validate="for.1.show.id.sofer1"><option value="">Nespecificat</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3" selected>3 sau multi</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Culoare:</div><div class=workfields><select name="culoare" class="validated doaremitere" validate="required.yes">
<option value="">Selectati</option>
<option value="Alb">Alb</option>
<option value="Albastru">Albastru</option>
<option value="Albastru deschis">Albastru deschis</option>
<option value="Albastru electric">Albastru electric</option>
<option value="Albastru inchis">Albastru inchis</option>
<option value="Albastru turcia">Albastru turcia</option>
<option value="Bej">Bej</option>
<option value="Bordo">Bordo</option>
<option value="Galben">Galben</option>
<option value="Galben lamaie">Galben lamaie</option>
<option value="Gri">Gri</option>
<option value="Gri deschis">Gri deschis</option>
<option value="Gri inchis">Gri inchis</option>
<option value="Maro">Maro</option>
<option value="Negru">Negru</option>
<option value="Portocaliu">Portocaliu</option>
<option value="Rosu">Rosu</option>
<option value="Rosu deschis">Rosu deschis</option>
<option value="Rosu inchis">Rosu inchis</option>
<option value="Verde">Verde</option>
<option value="Violet">Violet</option>
</select>
</div></div>

<div class="workstep"><div class="worklabel">Vopsea:</div><div class=workfields><select name="metalizata"><option value="">Simpla</option><option value="1">Metalizata</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Stare:</div><div class=workfields><select name="stareint"><option value="Buna">Buna</option><option value="FoarteBuna">FoarteBuna</option><option value="Medie">Medie</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Data prima inmatriculare:</div><div class=workfields><input type=text name="dataachiz" id="dataachiz" size="9" value="" class="validated" validate="required.date"><a class="cdateselect" id="dataachiz_sel" name="dataachiz_sel" onclick="global_cal.select(document.forms['work'].dataachiz,'dataachiz_sel','dd.MM.yyyy'); return false;" href="#work"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Mod achizitie</div><div class=workfields><select name="modachizitie"><option value="dealerromania">Dealer din Romania</option><option value="dealerstrainatate">Dealer din strainatate</option><option value="tertapersoana">Terta persoana</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Valoare Factura:</div><div class=workfields><input type="number" name="valfactura" size=6 value="" class="validated" validate="required.number" style="width:100px;"> EURO 
</div></div>

<div class="workstep"><div class="worklabel">Dotari optionale din fabrica</div><div class=workfields><select name="dotarifabrica" class="validated" validate="for.da.show.id.pooptionalevaloare"><option value="">Fara</option><option value="da">Da</option></select>
</div></div>

<div id="pooptionalevaloare">
<div class="workstep"><div class="worklabel">Valoare optionale</div><div class=workfields><input type="text" name="dotaritotal" value="0" size=4> EURO
</div></div>
</div>

<div class="workstep"><div class="worklabel">CASCO valabil din</div><div class=workfields><input class="validated" validators="change" validate="required.date" type=text name="datavalabilitate" id="datavalabilitate" size="9" value="<?php echo date('d.m.Y',time()+60*60*24);?>">
	<a class="cdateselect" id="datavalabilitate_sel" name="datavalabilitate_sel" onclick="global_cal.select(document.forms['work'].datavalabilitate,'datavalabilitate_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>


<div class="workstep"><div class="worklabel">Polita veche casco:</div><div class=workfields><select name="po_veche" class="validated" validate="for..hide.id.numarpolveche"><option value="">Nu are</option>
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

<div class="workstep"><div class="worklabel">Polita RCA:</div><div class=workfields><select name="po_rca" class="validated" validate="for..hide.id.numarpolrca"><option value="">Nu are</option>
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

<div class="workstep"><div class="worklabel">Daune:</div><div class=workfields>
		<select name="daune" class="validated" validate="for.M01|M02|M03.show.id.podaunevaloare">
			<option value="">Fara istoric</option>
			<option value="B01">Un an fara daune</option>
			<option value="B02">Doi ani fara daune</option>
			<option value="B03">Trei ani fara daune</option>
			<option value="B04">Patru ani fara daune</option>
			<option value="B05">Cinci ani fara daune</option>
			<option value="M01">O dauna in anul anterior</option>
			<option value="M02">Doua daune in anul anterior</option>
			<option value="M03">Trei sau mai multe daune</option>
		</select>
</div></div>

<div id="podaunevaloare">
<div class="workstep"><div class="worklabel">Valoare daune</div><div class=workfields><input type="number" name="daunevaloare" value="" size="5">
</div></div></div>

</div>

<div class="workstep"><div class="biglabel"><img src="images/ok.png" border=0> CE ASIGURI</div>
</div>

<div class="workstep"><div class="worklabel">Dotari suplimentare</div><div class=workfields style="width:450px;"><select name="dotari" class="validated" validate="for.da.show.id.dotari"><option value="">Fara</option><option value="da">Da</option></select>
</div></div>

<div id="dotari">
<div class="workstep"><div class="worklabel">Montate pe autovehicul</div><div class=workfields style="width:450px;">
<?php
	global $def;
	include("coduri/id.casco.suplimente.php");
	$allv="";
	foreach($def as $k=>$v)
	{
		if($allv!="") $allv.=".";
		$allv.="dotari_".$v;
	}
?>
	Total <input type="text" name="totaldotari" value="0" readonly="" size="6" class="validated" validate="extract.sum.<?php echo $allv;?>"> EURO<br>
	<table border=1 style="background-color:white;border:solid 1px #ccc;border-collapse:collapse;">
	<?php
	$cnt=0;
	foreach($def as $k=>$v)
	{
		?><tr><td><label for="supl_<?php echo $v;?>"><?php echo $k;?></label><td><input name="dotari_<?php echo $v;?>" value="0" id="supl_<?php echo $v;?>" size="6" class="validated" validate="revalidate.totaldotari"> Euro<?php
		$cnt++;
	}
	if($cv['dotarioptionale']!="")
	{
		$def=explode(",",$cv['dotarioptionale']);
		foreach($def as $k=>$v)
		{
			$arr=explode("=",$v);
			?><tr><th>cod dotare <?php echo $arr[0];?><td align="right"><?php echo $arr[1];?> Euro<?php
			$cnt++;
		}
	}

	?>
	</table>
</div></div>
</div>

<div class="workstep"><div class="worklabel">Dispozitive de siguranta</div><div class=workfields><select name="siguranta" class="validated" validate="for.da.show.id.siguranta"><option value="">Fara</option><option value="da">Da</option></select>
</div></div>

<div id="siguranta">
<div class="workstep"><div class="worklabel"></div><div class=workfields style="width:450px;">
	<table border=1 style="background-color:white;border:solid 1px #ccc;border-collapse:collapse;">
	<?php
	global $def;
	include("coduri/id.casco.siguranta.php");
	$cnt=0;
	foreach($def as $k=>$v)
	{
		?>
		<tr>
			<td><label for="sig_<?php echo $v;?>"><?php echo $k;?></label>
			<td><input type="checkbox" value="1" name="siguranta_<?php echo $v;?>" id="sig_<?php echo $v;?>"><input type="hidden" value="0" name="_siguranta_<?php echo $v;?>">
		<?php
	}
	?>
	</table>
</div></div>
</div>

<div class="workstep"><div class="worklabel">Riscuri:</div><div class=workfields style="width:450px;">
	<table border=1 style="background-color:white;border:solid 1px #ccc;border-collapse:collapse;">
		<tr>
		<td><input type="checkbox" value="1" name="risc_01" id="risc_01" class="validated" validate="for.1.show.class.i_bifa_01" checked><input type="hidden" value="0" name="_risc_01"><td><label for="risc_01">avarii - ciocniri, coliziuni, rasturnari, incendiu, explozie, fen. naturale</label>
		<tr>
		<td><input type="checkbox" value="1" name="risc_02" id="risc_02" class="validated" validate="for.1.show.class.i_bifa_02" checked><input type="hidden" value="0" name="_risc_02"><td><label for="risc_02">furt - total si partial, avarii ca urmare a tentativei de furt</label>
	</table>
</div></div>

<div class="workstep"><div class="worklabel">Clauze:</div><div class=workfields style="width:450px;">
	<table border=1 style="background-color:white;border:solid 1px #ccc;border-collapse:collapse;width:100%;">
	<tr><td colspan=2>
	<?php
	$cols='';
	$asiguratori=array("asirom","astra","generali","omniasig","euroins","allianz","platinum");
	foreach($asiguratori as $k=>$v)
	{
		?><td style="height:50px;width:20px;line-height:.9em;" align="center" valign=top><?php echo implode('<br>',str_split(strtoupper($v),1));
		$cols.="<td>";
	}
	echo "<tr>";
	global $def;
	global $legs;
	include("coduri/id.casco.riscuri.php");
	foreach($def as $v=>$k)
	{
		$adit="";$aditclass='';
		if($k=="01") continue;
		if($k=="02") continue;
		if($k=="03" || $k=="07" || $k=="11" || $k=="12")
		{
			$adit="checked";
		}
		if($k=="10" || $k=="14")
		{
			$aditclass="aratadoarpj";
		}
		if($k=="13")
		{
			$aditclass="aratadoarpf";
		}
		?><tr class="<?php echo $aditclass;?>"><td align="right"><label for="<?php echo $k;?>"><?php echo $v;?></label><td><input type="checkbox" value="1" name="risc_<?php echo $k;?>" id="risc_<?php echo $k;?>" class="validated" validate="for.1.show.class.i_bifa_<?php echo $k;?>" <?php echo $adit;?>><input type="hidden" value="0" name="_risc_<?php echo $k;?>">
		<?php
		$cols='';
		foreach($asiguratori as $kk=>$vv)
		{
			$cols.='<td><img src="images/ok.jpeg" border=0 style="display:none;" class="'.$legs[$vv][$k].'">';
		}
		echo $cols;
	}
	?>
	</table>
</div></div>

<div class="workstep"><div class="worklabel">Mod plata:</div><div class=workfields>
	<select name="nrrate">
	<option value="1">Integral</option>
	<option value="2">Semestrial</option>
	<option value="4">Trimestrial</option>
	<option value="12">Lunar</option>
	</select>
</div></div>

<div class="workstep"><div class="worklabel">Fransiza pe eveniment</div><div class=workfields style="width:450px;">
	<select name="franciza_01"><option value="">Nu</option><option value="">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Fransiza furt total</div><div class=workfields style="width:450px;">
	<select name="franciza_04"><option value="">Nu</option><option value="">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Fransiza dauna totala</div><div class=workfields style="width:450px;">
	<select name="franciza_05"><option value="">Nu</option><option value="">Da</option></select>
</div></div>

<div class="workstep"><div class="biglabel"><img src="images/individ.png" border=0> DATE PROPRIETAR</div></div>

<div class="workstep"><div class="worklabel">Proprietar Vehicul</div><div class=workfields><select name="tipproprietar" class="validated validateundo" validators="change" validate="for.pj.show.class.aratadoarpj~for.pf.show.class.aratadoarpf~for.pf.show.id.tarifarofertapf~for.pj.show.id.tarifarofertapj~revalidate.dotarifabrica~revalidate.dotari~revalidate.siguranta~required.yes">
	<option class="option0" value="">--Selectati--</option>
	<option class="option0" value="pf">Fizica</option>
	<option class="option0" value="pj">Juridica</option>
</select>
</div></div>


<!-- tarifarofertapf --><div id=tarifarofertapf>
<div class="workstep"><div class="worklabel">Tip persoana:</div><div class="workfields"><select name=pf_tippersoana>
	<option value="pf">PF</option>
	<option value="pf,bugetar">Bugetar</option>
	<option value="pf,familieb">Familie bugetari</option>
	<option value="pf,pensionar">Pensionar</option>
	<option value="pf,veteran">Veteran</option>
	<option value="pf,handicap">Cu handicap</option>
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

<div class="workstep"><div class="worklabel">Destinatie:</div><div class="workfields"><select class="validated" name="pf_destinatie">
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

<div class="workstep"><div class="worklabel">Copii minori</div><div class="workfields"><select class="validated" name="pf_copii"><option value="">Nespecificat</option><option value="0">Nici unu</option><option value="1">Un copil</option><option value="2">Doi copii</option><option value="3">3 sau mai multi</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Amenzi (3 ani): </div><div class="workfields"><select name="pf_amenzi"><option value="nu">Nu</option><option value="da">Da</option></select>
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



