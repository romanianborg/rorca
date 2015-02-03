<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Trimite Expirari">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="decont">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/x.png" border=0> EXPIRARI</div>
</div>

<div class="workstep"><div class="worklabel">Expira RCA-ul?</div><div class=workfields><input type=text name="datarca" id="datarca" size="9" value="">
	<a id="datarca_sel" class=cdateselect name="datarca_sel" onclick="global_cal.select(document.forms['work'].datarca,'datarca_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Asigurarea locuintei?</div><div class=workfields><input type=text name="datapad" id="datapad" size="9" value="">
	<a id="datapad_sel" class=cdateselect name="datapad_sel" onclick="global_cal.select(document.forms['work'].datapad,'datapad_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>


<div class="workstep"><div class="worklabel">Expira CASCO-ul?</div><div class=workfields><input type=text name="datacasco" id="datacasco" size="9" value="">
	<a id="datacasco_sel" class=cdateselect name="datacasco_sel" onclick="global_cal.select(document.forms['work'].datacasco,'datacasco_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>

<div class="workstep"><div class="worklabel">Alta asigurare?</div><div class=workfields><input type="text" name="numealta1" value="" size=20>
</div></div>

<div class="workstep"><div class="worklabel">In ce data?</div><div class=workfields><input type=text name="dataalta1" id="dataalta1" size="9" value=""> <a id="dataalta1_sel" name="dataalta1_sel" onclick="global_cal.select(document.forms['work'].dataalta1,'dataalta1_sel','dd.MM.yyyy'); return false;" href="#"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>


</div><div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/individ.png" border=0> DATE PROPRIETAR</div></div>


<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name="emailclient" value="" class="validated" validate="if.telclient..required.email" size="20" type="email">
</div></div>

<div class="workstep"><div class="worklabel">Telefon:</div><div class=workfields><input name="telclient" value="" class="validated" validate="if.emailclient..required.phone" size="20" type="tel">
</div></div>


<div class="workstep"><div class="worklabel">Nume</div><div class=workfields><input name="client" value="" class="validated" validate="required.yes" size="20" type="text">
</div></div>

</div>

</div>

