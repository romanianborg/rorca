<div id="worksteps">
<input type="hidden" name="action" value="Reincarca">
<input type="hidden" name="textbutton" value="Reincarca date">
<input type="hidden" name="automaticsubmit" value="false">
<?php if($_GET['tt']=="") $_GET['tt']="scadente";?>
<?php if($_GET['view']=="") $_GET['view']="lista";?>
<input type="hidden" name="module" value="<?php echo $_GET['tt'];?>">
<input type="hidden" name="moduleview" value="<?php echo $_GET['view'];?>">
<input type="hidden" name="moduleid" value="<?php echo intval($_GET['viewid']);?>">

<div class="work_col1">

<div class="workstep">
	<a href="site.php?t=client&tt=scadente" class="biglink<?php if($_GET['tt']=="scadente") echo " bigselectedlink";?>"><img src="images/alert.png" border=0 style="vertical-align:middle"> <span style="">Alerte</span></a>
</div>

<div class="workstep">
	<a href="site.php?t=client&tt=oferte" class="biglink<?php if($_GET['tt']=="oferte") echo " bigselectedlink";?>"><img src="images/text.png" border=0 style="vertical-align:middle"> <span style="">Oferte</span></a>
</div>

<div class="workstep">
	<a href="site.php?t=client&tt=polite" class="biglink<?php if($_GET['tt']=="polite") echo " bigselectedlink";?>"><img src="images/newspaper.png" border=0 style="vertical-align:middle"> <span style=""> Polite de asigurare</span></a>
</div>

<div class="workstep">
	<a href="site.php?t=client&tt=flota" class="biglink<?php if($_GET['tt']=="flota") echo " bigselectedlink";?>"><img src="images/stoplight.png" border=0 style="vertical-align:middle"> <span style="">Flota</span></a>
</div>

<div class="workstep">
	<a href="site.php?t=client&tt=contact" class="biglink<?php if($_GET['tt']=="contact") echo " bigselectedlink";?>"><img src="images/user.png" border=0 style="vertical-align:middle"> <span style="">  Date contact</span></a>
</div>

<div class="workstep">
	<a href="site.php?t=client&tt=parola" class="biglink<?php if($_GET['tt']=="parola") echo " bigselectedlink";?>"><img src="images/lock.png" border=0 style="vertical-align:middle"> <span style="">  Schimba parola</span></a>
</div>

<div class="workstep">
	<a href="site.php?t=client&tt=logout" class="biglink<?php if($_GET['tt']=="logout") echo " bigselectedlink";?>"><img src="images/stop.png" border=0 style="vertical-align:middle"> <span style=""> Deconectare</span></a>
</div>

</div><!-- col1 -->

<div class="work_col2">

<?php
// switch tt
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('Portofoliu');

?>

</div><!-- col2-->

</div><!-- worksteps -->
