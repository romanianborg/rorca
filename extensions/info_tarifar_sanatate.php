
<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Afiseaza tarife">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="sanatate">

<input type=hidden name=rudenie_1 value="Sot_Sotie">
<input type=hidden name=as_nume_1 value="Oferta Site">
<input type=hidden name=as_ocupatia_1 value="Nespecificat">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE ASIGURAT</div>
</div>

<?php
$gi=1;
?>
<div class="workstep"><div class="worklabel">Cetatenie:</div><div class="workfields"><select name="as_cetatean_<?php echo $gi;?>"><option value="true">Romana</option><option value="false">Straina</option></select>
</div></div>

<div class="workstep"><div class="worklabel">Ocupatia:</div><div class="workfields"><select name="as_munca_<?php echo $gi;?>"><option value="">Nu se aplica</option>
<option value="0">Profesii liberale</option>
<option value="1">Personal administrativ (functionari)</option>
<option value="2">Personal de executie (calificat)</option>
<option value="3">Personal necalificat</option>
<option value="4">Personal ce activeaza în conditii de munca speciale</option>
<option value="5">Somer</option>
</select>
</div></div>

<div class="workstep"><div class="worklabel">Judet:</div><div class="workfields"><select name="as_judet_<?php echo $gi;?>" type="text" class="validated" validate="notfor.bucuresti.show.id.pf_locspan~for.bucuresti.show.id.pf_sectspan~call.pregatesteAutocomplete.as_judet_<?php echo $gi;?>.as_localitate_<?php echo $gi;?>.as_sector_<?php echo $gi;?>~required.yes">
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
<div class="workstep"><div class="worklabel">Localitate:</div><div class="workfields"><input name="as_localitate_<?php echo $gi;?>" id="as_localitate_<?php echo $gi;?>" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=as_localitate_<?php echo $gi;?>&lkjudet=[as_judet_<?php echo $gi;?>]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18 title="Conform talon">
</div></div>
</div>

<div id=pf_sectspan>
<div class="workstep"><div class="worklabel">Sector:</div><div class="workfields"><select id="as_sector_<?php echo $gi;?>" name="as_sector_<?php echo $gi;?>" class="validated as_adresa_<?php echo $gi;?>_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('as_adresa_<?php echo $gi;?>');" title="Conform talon"><option value=""> Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select>
</div></div>
</div>

<div class="workstep"><div class="worklabel">CNP:</div><div class="workfields"><input type="number" validate="extract.varsta.as_varsta_<?php echo $gi;?>~required.cnp" validators="change.keyup" class="validated validateatention" value="" size="15" name="as_cnp_<?php echo $gi;?>"><input type="hidden" value="" name="as_varsta_<?php echo $gi;?>">
</div></div>

<div class="workstep"><div class="biglabel"><img src="images/ok.png" border=0> CLAUZE DORITE</div>
</div>

<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Preventiv:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="preventiv_<?php echo $gi;?>" value="1" checked style="width:60px;text-align:left;">
</div></div>
<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Spitalizare:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="spitalizare_<?php echo $gi;?>" value="1" style="width:60px;text-align:left;">
</div></div>
<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Interventii chirurgicale:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="interventii_<?php echo $gi;?>" value="1" style="width:60px;text-align:left;">
</div></div>
<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Tratament dentar:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="dentar_<?php echo $gi;?>" value="1" style="width:60px;text-align:left;">
</div></div>
<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Servicii ambulanta 24h:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="ambulanta_<?php echo $gi;?>" value="1" style="width:60px;text-align:left;">
</div></div>
<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Asistenta medicala completa:</div><div class="workfields" style="width:60px;text-align:left;">
	 <input type="checkbox" name="completa_<?php echo $gi;?>" value="1" style="width:60px;text-align:left;">
</div></div>


<div class="workstep"><div class="biglabel"><img src="images/individ.png" border=0> STARE SANATATE</div></div>


<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Fumati?</div><div class="workfields" style="width:60px;text-align:left;"><select name="usetutun" style="width:60px;text-align:left;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Luati medicamente?</div><div class="workfields" style="width:60px;text-align:left;"><select name="usemed" style="width:60px;text-align:left;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:200px;text-align:right;">Consumati Alcool?</div><div class="workfields" style="width:60px;text-align:left;"><select name="usealcol" style="width:60px;text-align:left;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

</div><div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/individ.png" border=0> ISTORIC MEDICAL</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Rudele de gradul I (parinti, frati, surori) au suferit de una din urmatoarele: cardiopatie ischemica, infarct miocardic, accident vascular cerebral, diabet zaharat, cancer mamar, cancer al colonului, boala polichistica renala? </div><div class="workfields" style="width:50px;"><select name="bo_Question0" style="width:50px;" ><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">In ultimii 5 ani, ati fost diagnosticat/ tratat/ investigat sau supravegheat urmatoarele afectiuni medicale: Afectiuni cardiovasculare: infarct miocardic / accident vascular cerebral?  </div><div class="workfields" style="width:50px;"><select name="bo_Question1" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni respiratorii: tuberculoza activa, astm bronsic, insuficienta respiratorie, bronsita cronica, emfizem pulmonar?  </div><div class="workfields" style="width:50px;"><select name="bo_Question2" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni digestive: ciroza hepatica, hepatita cronica, reflux gastroesofagian, ulcer gastric, ulcer duodenal, litiaza biliara, pancreatita cronica,rectocolita ulcero-hemoragica, boala Crohn, diverticuloza colonica? </div><div class="workfields" style="width:50px;"><select name="bo_Question3" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Boli metabolice si de nutritie? </div><div class="workfields" style="width:50px;"><select name="bo_Question4" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni endocrine: hipertiroidie (boala Basedow-Graves), tiroidita cronica, gusa nodulara, sindrom Cushing, boala Addison? </div><div class="workfields" style="width:50px;"><select name="bo_Question5" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni ereditare: fibroza chistica, boala Wilson? </div><div class="workfields" style="width:50px;"><select name="bo_Question6" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni hematologice/ale sangelui:hemofilie, anemie hemolitica,trombofilie, leucemie?  </div><div class="workfields" style="width:50px;"><select name="bo_Question7" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Tumori maligne/cancer (diagnosticat in ultimii 5 ani)?  </div><div class="workfields" style="width:50px;"><select name="bo_Question8" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Boli infectioase: infectie HIV/ SIDA, tuberculoza activa?  </div><div class="workfields" style="width:50px;"><select name="bo_Question9" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni neurologice: encefalopatie cronica infantila, parapareza,tetrapareza, epilepsie, migrena, boala Parkinson, scleroza multipla?  </div><div class="workfields" style="width:50px;"><select name="bo_Question10" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni psihice: schizofrenie, tulburare afectiva bipolara, tulburare somatoforma, depresie? </div><div class="workfields" style="width:50px;"><select name="bo_Question11" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni O.R.L: otita cronica, sinuzita cronica?  </div><div class="workfields" style="width:50px;"><select name="bo_Question12" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni oftalmologice: glaucom, retinopatie pigmentara, cataracta? </div><div class="workfields" style="width:50px;"><select name="bo_Question13" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni reumatice si osteoarticulare: poliartrita reumatoida,lupus eritematos sistemic, spondilodiscopatie, hernie de disc, osteoartrita, osteopenie/osteoporoza?  </div><div class="workfields" style="width:50px;"><select name="bo_Question14" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni renale si ale cailor urinare: insuficienta renala cronica, litiaza renala, pielonefrita cronica, glomerulonefrita, sindrom nefrotic,ureterohidronefroza, stenoza uretrala?  </div><div class="workfields" style="width:50px;"><select name="bo_Question15" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni ale prostatei: adenom al prostatei? </div><div class="workfields" style="width:50px;"><select name="bo_Question16" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>

<div class="workstep"><div class="worklabel" style="width:230px;">Afectiuni ginecologice: infectie HPV, cervicita cronica, fibromatoza uterina, endometrioza, mastopatie fibrochistica, nodul mamar, boala inflamatorie pelvina, anexita cronica?</div><div class="workfields" style="width:50px;"><select name="bo_Question17" style="width:50px;"><option value="">Nu</option><option value="1">Da</option></select>
</div></div>


<?php if(getUserConfig("emaildinprima")=="yes") {?>
<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name="emailclient" value="" class="validated" validate="required.email" size="20" type="email">
</div></div>
<?php }?>

<?php if(getUserConfig("codpromotional")!="") {?>
<div class="workstep"><div class="worklabel"><?php echo getUserConfig("codpromotional");?>:</div><div class=workfields><input name="codpromotional" value="" size="20" type="text">
</div></div>
<?php }?>

<div class="workstep"><div class="worklabel" style="width:215px;">Declar ca: am citit si sunt de acord cu termenele si conditiile de folosire a acestui site, am peste 18 ani, datele si informatiile furnizate sunt reale la momentul completarii cererii.</div><div class="workfields"  style="width:55px;"><select  style="width:50px;" class=validated validate="required.yes" name="acord" title="Acord termene si conditii"><option value=''>?</option><option value=''>Nu</option><option value='da'>Da</option></select>
</div></div>

</div>

<!-- worksteps--></div>

