<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Trimite cerere">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="rezervare">
<input name="tipproprietar" value="pf" type="hidden">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/globe.png" border=0> DATE REZERVARE</div>
</div>

<div class="workstep"><div class="worklabel">Pleci in data de</div><div class=workfields><input class="validated" validators="change" validate="call.calculeazaNrZile~required.date" type=text name="datavalabilitate" id="datavalabilitate" size="9" value="<?php echo date('d.m.Y',time()+60*60*24);?>">
	<a class="cdateselect" id="datavalabilitate_sel" name="datavalabilitate_sel" onclick="global_cal.select(document.forms['work'].datavalabilitate,'datavalabilitate_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Pana la</div><div class=workfields><input class="validated" validators="change" validate="call.calculeazaNrZile~required.date" type=text name="panalavalabilitate" id="panalavalabilitate" size="9" value="">
	<a class="cdateselect" id="panalavalabilitate_sel" name="panalavalabilitate_sel" onclick="global_cal.select(document.forms['work'].panalavalabilitate,'panalavalabilitate_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Numar de zile</div><div class=workfields><input type="number" name="nrzile" value="" size=4 class="validated" validate="adddays.panalavalabilitate.datavalabilitate~required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Numar adulti</div><div class=workfields><input type="number" name="nradulti" value="" size=4 class="validated" validate="required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Numar copii minori</div><div class=workfields><input type="number" name="nrcopii" value="0" size=4 class="validated" validate="required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Zona de destinatie:</div><div class=workfields><input size=14 type="text" name="zona" class="validated" validate="required.yes" value="" >
</div></div>

<div class="workstep"><div class="worklabel">Hotel dorit:</div><div class=workfields><input size=14 type="text" name="hotel" class="validated" validate="required.yes" value="" >
</div></div>

</div>

<div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/individ.png" border=0> DATE TURIST</div></div>

<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name="emailclient" value="" class="validated" validate="if.telclient..required.email" size="20" type="email">
</div></div>

<div class="workstep"><div class="worklabel">Telefon:</div><div class=workfields><input name="telclient" value="" class="validated" validate="if.emailclient..required.phone" size="20" type="tel">
</div></div>

<div class="workstep"><div class="worklabel">Tip</div><div class="workfields"><select validate="for.pf.show.class.doarpf~for.pf.show.id.tarifarofertapf~for.pj.show.id.tarifarofertapj~for.pj.show.class.doarpj~required.yes" validators="change" class="validated validateundo" name="tipproprietar">
	<option value="">--Selectati--</option>
	<option value="pf">Persoana Fizica</option>
	<option value="pj">Persoana Juridica</option>
</select>
</div></div>

<div class="workstep"><div class="worklabel"><span class="doarpj">Denumire firma</span><span class="doarpf">Nume si Prenume</span>:</div><div class=workfields><input name="client" value="" class="validated" validate="required.yes" size="20" type="text">
</div></div>

<!-- tarifarofertapf --><div id=tarifarofertapf>

<!-- tarifarofertapf --></div>

<!-- tarifarofertapj --><div id=tarifarofertapj>

<div class="workstep"><div class="worklabel">CUI (fara RO):</div><div class="workfields"><input type="text" validate="required.cui" validators="change.keyup" class="validated validateatention" value="" size="12" name="pj_cui">
</div></div>

<div class="workstep"><div class="worklabel">Reg. Com (J):</div><div class="workfields"><input type="text" value="" size="12" name="pj_j">
</div></div>

<div class="workstep"><div class="worklabel">Persoana contact:</div><div class="workfields"><input type="text" value="" size="12" name="persoanacontact">
</div></div>

<!-- tarifarofertapj --></div>

</div>


</div>

