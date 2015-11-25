<?php
if(!intval($_GET['offid']))
{
?>
<div id="worksteps">

<input type="hidden" name="action" value="AdaugaOferta">
<input type="hidden" name="textbutton" value="Trimite Cerere">
<input type="hidden" name="automaticsubmit" value="false">
<input type="hidden" name="tipoferta" value="decont">

<div class="work_col1">
<div class="workstep"><div class="biglabel"><img src="images/ochelari.png" border=0> DATE CONTACT</div>
</div>

<div class="workstep"><div class="worklabel">Nume:</div><div class=workfields><input name=client size=20 type=text class=validated validate="required.yes">
</div></div>

<div class="workstep"><div class="worklabel">Email:</div><div class=workfields><input name=emailclient size=20 type=text class=validated validate="required.yes">
</div></div>


</div>

<div class="work_col2">
<div class="workstep"><div class="biglabel"><img src="images/ok.png" border=0> CERERE</div>
</div>

<div class="workstep"><div class="worklabel">Subiect:</div><div class=workfields><input name=subiect size=20 type=text>
</div></div>


<div class="workstep"><div class=worklabel>Descriere</div><div class=workfields style="height:60px;"><textarea name=descriere></textarea>
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
<input type="hidden" name="tipoferta" value="decont">

<div class="biglabel"><img src="images/ok.png" border=0> Cerere contact</div>

<div class="workstep"><div class=workfields style="width:295px;height:120px;">
Cererea a fost inregistrata
<br><br>
Numar inregistrare: <b><?php echo intval($_GET['offid']);?></b><br>
</div></div>

</div>

<?php
}
?>
