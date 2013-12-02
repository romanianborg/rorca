<div id="worksteps">
<input type="hidden" name="action" value="ContulNou">
<input type="hidden" name="textbutton" value="Creaza cont nou">
<input type="hidden" name="automaticsubmit" value="false">

<div class="work_col1">

<div class="workstep"><div class="biglabel"><img src="images/casa.png" border=0> IDENTIFICARE UTILIZATOR</div>
</div>

<div class="workstep"><div class=worklabel>Email</div><div class=workfields><input type=text name=utilizator value="" class="validated" validate="required.yes">
</div></div>

<div class="workstep"><div class=worklabel>Tip persoana</div><div class=workfields><select name="tippersoana" class="validated" validate="for.pf.show.id.pf_datepf~for.pj.show.id.pj_datepj"><option value="pf">Persoana Fizica</option><option value="pj">Persoana Juridica</option></select>
</div></div>

<div id="pf_datepf">
<div class="workstep"><div class=worklabel>CNP</div><div class=workfields><input type=text name=pf_cnp value="" class=validated validate="required.cnp">
</div></div>
</div>

<div id="pj_datepj">
<div class="workstep"><div class=worklabel>CUI</div><div class=workfields><input type=text name=pj_cui value="" class=validated validate="required.cui">
</div></div>
</div>

</div>

<div class="work_col1">

<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> PAROLA</div>
</div>
<div class="workstep"><div class=worklabel>Parola</div><div class=workfields><input type=password name=parola value="" class="validated" validate="required.yes">
</div></div>
<div class="workstep"><div class=worklabel>Verifica parola</div><div class=workfields><input type=password name=verifica value="">
</div></div>

<div class="workstep">
	<a href="site.php?t=client" class="biglink"><img src="images/casa.png" border=0> Intra in contul tau</a>
</div>

</div>

</div>
