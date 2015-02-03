<?php
if(!intval($_GET['offid']))
{
?>
<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Trimite Petitie">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="petitie">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE PETENT</div>
</div>

<div class="workstep"><div class="worklabel">Nume:</div><div class=workfields><input name=petnume size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Telefon:</div><div class=workfields><input name=petmobil size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name=petemail size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Adresa:</div><div class=workfields><input name=petcontact size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> PROVENIENTA PETITIE</div>
</div>

<div class="workstep"><div class=worklabel>Solicitant petitie:</div><div class=workfields><input name=petprovnume size=20 type=text>
</div></div>

<div class="workstep"><div class=worklabel>Nr. Provenienta</div><div class=workfields><input name=petprovnr size=20 type=text>
</div></div>


<div class="workstep"><div class="worklabel">Data Provenienta</div><div class=workfields><input type="text" value="<?php echo date('d.m.Y',time()+60*60*24);?>" size="9" id="petprovdate" name="petprovdate" validate="required.date" validators="change" class="validated">&nbsp;<a class="cdateselect" href="#" onclick="global_cal.select(document.forms['work'].petprovdate,'petprovdate_sel','dd.MM.yyyy'); return false;" name="petprovdate_sel" id="petprovdate_sel"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>


</div>

<div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE PETITIE</div>
</div>

<div class="workstep"><div class=worklabel>Nr. Dosar:</div><div class=workfields><input name=petdosar size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class=worklabel>Nr. Polita</div><div class=workfields><input name=petpolita size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class=worklabel>Obiect</div><div class=workfields><input name=petobiect size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class=worklabel>Comentarii</div><div class=workfields style="height:60px;"><textarea name=petcomments></textarea>
</div></div>



</div>

<?php
}
else
{
?>
<div id="worksteps">

<input type="hidden" name="action" value="PlataOk">
<input type="hidden" name="textbutton" value="Multumim!">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="offid" value="<?php echo intval($_GET['offid']);?>">
<input type="hidden" name="tipoferta" value="<?php echo $date['tipoferta']['VALUE'];?>">

<div class="biglabel"><img src="images/ok.png" border=0> Petitie</div>

<div class="workstep"><div class=workfields style="width:295px;height:120px;">
Petitia dumneavoastra a fost inregistrata
<br><br>
Numar inregistrare: <b><?php echo intval($_GET['offid']);?></b><br>
</div></div>

</div>

<?php
}
?>
