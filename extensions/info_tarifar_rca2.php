

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Afiseaza tarife">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="rca">

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
<?php
include("extensions/info_css_base2.php");
cache_addvalue("finalhead",ob_get_contents());ob_end_clean();
?>

<div class="container">
<div class="row">
<div class="span12">

			<div id="steps">
				
				<a class="step-1" href="#" onclick="return false;" title="Completeaza formularul">
					<span>Completeaza</span><br />  formularul
				</a>
				<a class="step-2" href="#" onclick="return false;" title="Alege oferta" style="opacity: 0.3; ">
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
			<h3 class="box-title">Informatii despre masina</h3>
			<div class="box" id="box-vehicul">
				<div class="icon">&nbsp;</div>

<div class="row">
					<div class="span5">

<div class="input-append input-prepend">
 <span class="add-on indicatie" style="width:190px;">Data intrarii in valabilitate</span>
<input class="span2 input-small"  type="text" value="<?php echo date('d.m.Y',time()+60*60*24);?>" size="9" id="datavalabilitate" name="datavalabilitate" validate="required.date" validators="change" class="validated">
<span class="add-on"><a href="#" onclick="global_cal.select(document.forms['work'].datavalabilitate,'datavalabilitate_sel','dd.MM.yyyy'); return false;" name="datavalabilitate_sel" id="datavalabilitate_sel"><img src="images/calendar.png" border="0" alt="Calendar"></a></span>
</div>

					</div>

<div class="span3">

<div class="input-prepend">
 <span class="add-on indicatie">Categorie</span>
			<select validate="get.cod.categ" validators="change" class="validated span2" name="categorie" title="Talon nou: J, Talon vechi: 6">
<option categ="autoturism" value="autoturism">autoturism</option>
<option categ="autoturism" value="autoturism de teren">autoturism de teren</option>
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
</div>

</div>
</div>


					<div class="row">
					<div class="span3">


<div class="input-prepend">
 <span class="add-on indicatie">Marca</span>
<input type="text" validate="uppercase~required.yes" class="span2 input-small autocompletefield validated ac_input validateatention" lk="coduri/code.php?soc=allianz&amp;grupa=marci&amp;valoare=&amp;lookupfor=marca" name="marca" mustmatch="yes" size="20" id="marca" value="" autocomplete="off" title="Talon nou: D.1, Talon vechi: 8">
</div>


					</div>
					<div class="span3">


<div class="input-prepend">
 <span class="add-on indicatie">Model</span>
<input type="text" validate="uppercase~required.yes" class="span2 input-small validated validateatention" name="model" size="20" value="" title="Talon nou: D.3, Talon vechi: 9">
</div>


					</div>

					</div>

					<div class="row">
					<div class="span3">

<div class="input-prepend">
 <span class="add-on indicatie">An fabricatie</span>
<select validate="required.yes" class="span2 validated validateatention" name="anfabricatie" title="Talon nou: B, Talon vechi: 15"><option value="">An fabr.</option>
<?php for($i=intval(date('Y'))+1;$i>=1970;$i--)
{
?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php
}
?>
</select>
</div>
					</div>

					<div class="span4">
<div class="input-prepend">
 <span class="add-on indicatie">Serie sasiu</span>
<input type="text" size="20" validate="uppercase~nokeys.73.79~required.yes~required.minmax.4.17~required.correct.17.6~replace.o.0.i.1" validators="change.keyup.keydown" class="span3 validated validateatention" name="seriesasiu" value="" title="Talon nou: E, Talon vechi: 3">
</div>
					</div>
					</div>

					<div class="row">
					<div class="span3">

<div class="input-prepend input-append">
 <span class="add-on indicatie">Cilindree</span>
<input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class=" span1 validated validateatention" size="6" name="cilindree" value="" style="width:65px;" title="Talon nou: P.1, Talon vechi: 17"> (cmc)
 <span class="add-on">CMC</span>
</div>

					</div>
					<div class="span3">

<div class="input-prepend input-append">
 <span class="add-on indicatie">Putere Motor</span>
<input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="span1 validated validateatention" size="6" name="cp" id="cp" value="" style="width:65px;" title="Talon nou: P.12, Talon vechi: 17">
 <span class="add-on">Kw</span>
</div>

					</div>
					<div class="span4">

<div class="input-prepend input-append">
 <span class="add-on">Masa maxima total autorizata</span>
<input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="validated validateatention" size="6" name="kg" value="" style="width:65px;" title="Talon nou: F.1, Talon vechi: 11">
 <span class="add-on">Kg</span>
</div>

					</div>
					</div>

					<div class="row">
					<div class="span3">

<div class="input-prepend input-append">
 <span class="add-on indicatie">Nr. locuri</span>
<input type="number" validate="required.integer~nokeys.32.190.188.109~required.yes" validators="change.keydown" class="span1 validated validateatention" size="6" name="locuri" id="locuri" value="" style="width:65px;" title="Talon nou: S.1, Talon vechi: 13">
 <span class="add-on">loc</span>
</div>

					</div>
										<div class="span3">


<div class="input-prepend">
 <span class="add-on indicatie">Sursa energie</span>
<select validate="required.yes" class="span2 validated" name="propulsie" title="Talon nou: P.3, Talon vechi: 17">
	<option value="">Selectati</option>
	<option value="Gasoline">Benzina</option>
	<option value="Diesel">Motorina</option>
	<option value="GPL">Gaz</option>
	<option value="ElectricHybrid">Electric-hibrid</option>
	</select>
</div>


					</div>
				</div>

				<div class="row">
					<div class="span5">
<div class="input-prepend">
 <span class="add-on indicatie">Documentatie</span>
			<select validate="for.inmatriculate|inregistrate.show.id.spanciv~required.yes" class="span3 validated" name="inmatriculare">
			<option value="inmatriculate">Inmatriculata la POLITIE</option>
			<option value="urmeazainmatriculate">- Urmeaza la POLITIE</option>
			<option value="inregistrate">Inregistrata la PRIMARIE</option>
			<option value="urmeazainregistrate">- Urmeaza la PRIMARIE</option>
			</select>
</div>
					</div>
<div id="spanciv">
					<div class="span5">
<div class="input-prepend">
 <span class="add-on span3">Nr Inmatriculare</span>
<input type="text" validate="uppercase~if.inmatriculare.inmatriculate.required.yes~if.inmatriculare.inregistrate.required.yes~if.inmatriculare.urmeazainmatriculate.required.no~if.inmatriculare.urmeazainregistrate.required.no~replace.-.. ../." class="span2 input-small validated validateatention" size="20" name="nrinm" value="" title="Talon nou: A, Talon vechi: 1">
</div>
					</div>
</div>


					</div>

<div class="row">
<div class="span8 offset1">% procent completare date
	<br><div class="progress"><div class="bar" style="width: 10%;"></div></div>
</div>
</div>

			</div>
			<div class="box-footer"  style="margin-bottom:50px;">&nbsp;</div>
</div>
</div>

<div class="row">
<div class="span12">
			<h3 class="box-title">Informatii despre proprietar</h3>

			<div class="box" id="box-proprietar">
				<div class="icon">&nbsp;</div>
				
				<div class="row">
					<div class="span10">
<ul class="nav nav-tabs" id=proprietarmeniu>
	<li class="span1">&nbsp;</li>
	<li class="active"><a href="#" onclick="$('#proprietarmeniu li').removeClass('active');$(this).parent().addClass('active');$('select[name=tipproprietar]').val('pf').change();return false;">Persoana Fizica (PF)</a></li>
	<li><a href="#" onclick="$('#proprietarmeniu li').removeClass('active');$(this).parent().addClass('active');$('select[name=tipproprietar]').val('pj').change();return false;">Persoana Juridica (PJ)</a></li>
	<li><a href="#" onclick="$('#proprietarmeniu li').removeClass('active');$(this).parent().addClass('active');$('select[name=tipproprietar]').val('leasing').change();$('#utilizatormeniu li').removeClass('active');return false;">Masina e in leasing</a></li>
</ul>
<select validate="for.leasing.show.id.tarifarofertaleasing~revalidate.tiputilizator~for.pf.show.id.tarifarofertapf~for.pj.show.id.tarifarofertapj~for.pf|pj.show.id.utilizatorvehicul~required.yes" validators="change" class="validated validateundo" name="tipproprietar" style="position:absolute;left:-1500px;">
	<option value="pf">Persoana Fizica</option>
	<option value="pj">Persoana Juridica</option>
	<option value="leasing">Masina e in Leasing</option>
</select>
					</div>
				</div>

				<div class="row">
					<div class=span10>

<!-- tarifarofertaleasing--><div id="tarifarofertaleasing" style="display:none;">

<div class="row">
<div class="span6">
	<div class="input-prepend">
	 <span class="add-on indicatie">Firma leasing</span>
	<input type="text" validate="uppercase" class="span5 validation doaremitere" size="20" value="" name="leasingname">
	</div>
</div>
<div class="span4">
	<div class="input-prepend">
	 <span class="add-on indicatie">CUI Leasing</span>
	<input type="number" validators="change.keyup" validate="required.cui" class="span2 validated validateatention" value="" name="leasingcui" size="10">
	</div>
</div>
</div>

<div class="row">
	<div class="span4">
		<div class="input-prepend">
	 <span class="add-on indicatie">Judet</span>
	<select name="leasingjudet" class="span2 validated" validate="notfor.bucuresti.show.id.leas_locspan~for.bucuresti.show.id.leas_sectspan~call.pregatesteAutocomplete.leasingjudet.leasinglocalitate.leas_sector~required.yes">
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
		</div>
	</div>


	<div id="leas_locspan" style="display:none;">
		<div class="span4">
			<div class="input-prepend">
				<span class="add-on indicatie">Localitate</span>
				<input type="text" name="leasinglocalitate" value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=leasinglocalitate&lkjudet=[leasingjudet]" class="span3 autocompletefield validated" validate="required.yes">
			</div>
		</div>
	</div>

	<div id="leas_sectspan" style="display:none;">
		<div class="span4">
			<div class="input-prepend">
				<span class="add-on indicatie">Sector</span>
				<select id="leas_sector" name="leas_sector" class="span2 validated leas_adresa_implode" validators="change" validate="if.leasingjudet.bucuresti.required.yes" label="sector" onchange="javascript:textareaImplode('leas_adresa');"><option value=""></option>
				<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
				<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
				</select>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="span10">
		<ul class="nav nav-tabs" id=utilizatormeniu>
			<li class="span1">&nbsp;</li>
			<li><a href="#" onclick="$('#utilizatormeniu li').removeClass('active');$(this).parent().addClass('active');$('select[name=tiputilizator]').val('pf').change();return false;">Utilizator Persoana Fizica</a></li>
			<li><a href="#" onclick="$('#utilizatormeniu li').removeClass('active');$(this).parent().addClass('active');$('select[name=tiputilizator]').val('pj').change();return false;">Utilizator Persoana Juridica</a></li>
		</ul>
		<select validate="for.pf.show.id.tarifarofertapf~for.pj.show.id.tarifarofertapj~required.yes" validators="change" class="validated validateatention validateundo" name="tiputilizator"  style="position:absolute;left:-1500px;">
			<option value="pf" class="option0">Persoana Fizica</option>
			<option value="pj" class="option0">Persoana Juridica</option>
		</select>
	</div>
</div>

<!-- tarifarofertaleasing--></div>

					</div>
				</div><!-- row prop -->

<!-- tarifarofertapf --><div id=tarifarofertapf>
			<div class="row">
				<div class="span4">
					<div class="input-prepend">
						<span class="add-on indicatie">Tip PF</span>
						<select name=pf_tippersoana class=span2>
							<option value="pf">PF</option>
							<option value="pf,bugetar">Bugetar</option>
							<option value="pf,familieb">Familie bugetari</option>
							<option value="pf,pensionar">Pensionar</option>
							<option value="pf,veteran">Veteran</option>
							<option value="pf,handicap">Handicap Locomotor</option>
						</select>
					</div>
				</div>
				<div class="span3">
					<div class="input-prepend">
						<span class="add-on indicatie">CNP</span>
						<input type="number" validate="extract.varsta.varsta~required.cnp" validators="change.keyup" class="span2 validated validateatention" value="" size="15" name="pf_cnp"><input type="hidden" value="" name="varsta">
					</div>
				</div>
			</div>
			<div class="row">
				<div class=span4>
					<div class="input-prepend">
						<span class="add-on indicatie">Judet</span>
<select name="pf_judet" type="text" class="span2 validated" validate="notfor.bucuresti.show.id.pf_locspan~for.bucuresti.show.id.pf_sectspan~call.pregatesteAutocomplete.pf_judet.pf_localitate.pf_sector~required.yes" title="Conform talon">
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
					</div>
				</div>

<div id=pf_locspan style="display:none;">
				<div class=span3>
					<div class="input-prepend">
						<span class="add-on indicatie">Localitate</span>
						<input name="pf_localitate" id="pf_localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pf_localitate&lkjudet=[pf_judet]" class="span2 autocompletefield validated" mustmatch=yes validate="required.yes" size=18 title="Conform talon">
					</div>
				</div>
</div>

<div id=pf_sectspan style="display:none;">
				<div class=span3>
					<div class="input-prepend">
						<span class="add-on indicatie">Sector</span>
<select id="pf_sector" name="pf_sector" class="span2 validated pf_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pf_adresa');" title="Conform talon"><option value=""> Sector...</option>
<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
</select>
					</div>
				</div>
</div>

			</div>

			<div class=row>

				<div class=span4>
					<div class="input-prepend">
						<span class="add-on indicatie">Permis</span>
<select name="pf_permisan" class=span2>
<option value="">Nespecificat</option>
<?php for($i=intval(date('Y'));$i>=1970;$i--)
{
?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php
}
?>
</select>
<input type=hidden name="pf_permisluna" value=1>
					</div>
				</div>
				<div class=span3>
					<div class="input-prepend">
						<span class="add-on indicatie">Copii minori</span>
<select class="span2 validated" name="pf_copii"><option value="">Nespecificat</option><option value="1">Un copil</option><option value="2">Doi copii</option><option value="3">3 sau mai multi</option></select>
					</div>
				</div>
			</div>
			
			<div class=row>
				<div class=span4>
					<div class="input-prepend">
						<span class="add-on indicatie">Destinatie</span>
<select class="span2 validated" name="pf_destinatie">
		<option value="uz">Uz personal</option>
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
					</div>
				</div>
				<div class=span3>
					<div class="input-prepend">
						<span class="add-on indicatie">Casco</span>
<select class="span2 validated" name="pf_casco">
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
					</div>
				</div>


			</div>
<!-- tarifarofertapf --></div>
<!-- tarifarofertapj --><div id=tarifarofertapj  style="display:none;">
			<div class=row>
				<div class=span4>
					<div class="input-prepend">
						<span class="add-on indicatie">Tip PJ</span>
						<select name=pj_tippersoana class="span2">
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
					</div>
				</div>
				<div class=span3>
					<div class="input-prepend">
						<span class="add-on indicatie">CUI</span>
						<input type="text" validate="required.cui" validators="change.keyup" class="span2 validated validateatention" value="" size="12" name="pj_cui">
					</div>
				</div>
			</div>
			<div class=row>
				<div class=span4>
					<div class="input-prepend">
						<span class="add-on indicatie">Judet</span>
<select name="pj_judet"  class="span2 validated" validate="notfor.bucuresti.show.id.pj_locspan~for.bucuresti.show.id.pj_sectspan~call.pregatesteAutocomplete.pj_judet.pj_localitate.pj_sector~required.yes" title="Conform talon">
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
						</div>
				</div>
				<div id="pj_locspan" style="display:none;">
					<div class=span4>
						<div class="input-prepend">
							<span class="add-on indicatie">Localitate</span>
							<input name="pj_localitate"  type="text" id="pj_localitate" value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=pj_localitate&lkjudet=[pj_judet]" class="span2 autocompletefield validated " mustmatch=yes validate="required.yes" title="Conform talon">
						</div>
					</div>
				</div>
				<div  id="pj_sectspan" style="display:none;">
					<div class=span3>
						<div class="input-prepend">
							<span class="add-on indicatie">Sector</span>
							<select id="pj_sector" name="pj_sector" class="span2 validated pj_adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('pj_adresa');" title="Conform talon"><option value="">Sector...</option>
							<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
							<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class=row>
				<div class=span4>
					<div class="input-prepend">
						<span class="add-on indicatie">Destinatie</span>
						<select class="span2 validated" name="pj_destinatie">
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
					</div>
				</div>
				<div class=span3>
					<div class="input-prepend">
					<span class="add-on indicatie">Am Casco la</span>
					<select class="span2 validated" name="pj_casco">
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
					</div>
				</div>
				<div class="span2 offset1">
					<div class="input-prepend">
					<span class="add-on indicatie">Parc auto</span>
					<input type="number" class="span1 validated" value="" size="4" name="parcauto"><input type=hidden name="pj_rate" value="1">
					</div>
				</div>
			</div>

<!-- tarifarofertapj --></div>
<?php if(getUserConfig("emaildinprima")=="yes") {?>
			<div class="row">
				<div class="span3">
					<div class="input-prepend">
					<span class="add-on indicatie">Email</span>
<input name="emailclient" value="" class="span3 validated" validate="required.email" size="20" type="email">
					</div>
				</div>
			</div>
<?php }?>

			</div><!-- box -->
			<div class="box-footer"  style="margin-bottom:50px;">&nbsp;</div>
			
</div>
</div>


<div class="row">
<div class="span4 offset5">
			<button class="btn btn-large btn-primary" onclick="if(valideazaFormaPentruSalvare($('form[name=work]'),punemarcaje)) if(confirm('Atentie! Pentru ca polita dumneavoastra sa fie valabila, toate datele introduse trebuie sa fie corecte si conform cu talonul sau cartea masinii. Va rugam verificati inca o data inainte de a trece la pasul urmator. OK?')) $('form[name=work]').submit();return false;"><i class="icon-ok icon-white">&nbsp;</i> Vezi tarifele</button>
</div>
</div>


</div> <!-- container -->



