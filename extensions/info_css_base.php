<style>
.backbody {background-color:white;}
#work form {}
del {color:red;}
#worksteps td label,#worksteps td
{
font-size: 12px;
}
#workinsider
{
position:absolute;
left:-5500px;
top:-5500px;
}
#worknext
{
height:30px;
display:block;
border:solid 1px <?php echo $_CONFIG['button_border']; ?>;
background-color:<?php echo $_CONFIG['button_bg']; ?>;
}
#workprogress_step
{
width:30%;
height:5px;
background-color:<?php echo $_CONFIG['button_border']; ?>;
display:block;
color:<?php echo $_CONFIG['button_color']; ?>;
z-index:1;
border:solid 1px <?php echo $_CONFIG['button_border']; ?>;
}


#worknext a
{
display:inline-block;
padding:2px;
text-align:center;
font-weight:bold;
font-size:15px;
width:96%;
height:18px;
color: <?php echo $_CONFIG['button_color']; ?>;
z-index:2;
}
div.workstep th
{
	width:130px;
	padding-bottom: 4px;
	font-size:12px;
	border:solid 1px white;
}
div.workstep td
{
	padding:2px;
}
div.workfields td
{
	border:solid 1px #eee;
}
#work table.worktarife
{
	border-collapse:collapse;
}
#work table.worktarife td
{
	padding:0px;
	font-size:14px;
}
#worksteps table
{
	width:100%;
}
#worksteps table td
{
	text-align:left;
	background-color:white;
}
#work td.worktarif
{
	background-color:white;
}
#work td.worktarif a
{
	display:block;
	font-size:14px;
	color:<?php echo getUserConfig("tarif_color");?>;
	text-align: right;
	padding-right:2px;
	line-height:40px;
}
span.tarifjos
{
font-size: 8px;
}

#work input[type="text"],
#work input[type="number"],
#work input[type="tel"],
#work input[type="email"],
#work input[type="password"],
#work textarea,
#work select
{
    font-family: Arial, Sans-Serif;
    font-size: 13px;
    margin-bottom: 5px;
    display: inline-block;
    padding: 4px;
    z-index:100;
    background-color:white;
    border: solid 1px <?php echo $_CONFIG['button_border']; ?>;
}

div.sidebarbutton
{
clear:both;
display:block;
background-color:<?php echo $_CONFIG['tarifar_bg']; ?>;
padding:5px;
border: solid 1px <?php echo $_CONFIG['button_border']; ?>;
}
a.sidebarlink
{
display:block;
color:<?php echo $_CONFIG['tarifar_color']; ?>;
}
#sidebarload
{
display:none;
position:fixed;
right:0px;
top:50px;
z-index:1000;
}
#sidebarload:hover
{
position:fixed;
right:0px;
top:50px;
}
.workstep,#workstep
{
clear:both;
display:block;
padding:0px;
border-top: solid 1px #eee;
float:left;
}

#worksteps
{
border:solid 1px <?php echo $_CONFIG['tarifar_border']; ?>;
background-color:<?php echo $_CONFIG['tarifar_bg']; ?>;
width:600px;
float:left;
}
#workstep
{
padding:2px;

}
div.workstep select
{
	width: 170px;
}
<?php 
if($_GET['t']!="all" && $_GET['t']!="brokers")
{
?>
div.workstep
{
	display:none;
}
<?php } else {?>
div.workstep
{

}
<?php }?>
#work
{
color:black;
}
div.worklabel
{
font-weight:bold;
width:100px;
float:left;
padding:5px;
padding-top:auto;
padding-left:5px;
background-color:<?php echo $_CONFIG['tarifar_bg']; ?>;
text-align:left;
vertical-align:middle;
font-size:11px;
}
div.workfields
{
font-weight:bold;
float:left;
padding:0px;
padding-top:4px;
background-color:<?php echo $_CONFIG['tarifar_bg']; ?>;
vertical-align:middle;
text-align:left;
height: 32px;
}

div.datepicker
{
position:absolute;
top:30px;
left:0px;
z-index: 999;
}

div.biglabel
{
	width:298px;
	vertical-align:middle;
	text-align:center;
	font-weight:bold;
	background-color:<?php echo $_CONFIG['tarifar_border']; ?>;
	height:30px;
	padding-top:6px;
	display:inline-block;
}
div.workstep a.biglink
{
	display:block;
	padding:4px;
	font-size: 1.2em;
	color:black;
	height:30px;
	text-align: left;
}
div.workstep a.bigselectedlink
{
background-color:<?php echo $_CONFIG['tarifar_border']; ?>;
}
div.workstep a.alegebroker
{
	display:block;
	padding:4px;
	padding-top:12px;
	height:25px;
	width:140px;
	margin-left: 20px;
	font-size: 16px;
	color:black;
	text-align:center;
	background-color:<?php echo $_CONFIG['tarifar_border']; ?>;
	border: solid 1px red;
}
div.workstep div.bigbrokers
{
	display:block;
	padding:4px;
	font-size: 1.2em;
	color:black;
	min-height:150px;
}
div.workstep div.bigbrokers:hover
{
	background-color:<?php echo $_CONFIG['tarifar_border']; ?>;
}
div.listdescription h1
{
	padding:0px;
	margin:0px;
}
div.bigbrokers .listicon
{
	float:left;
	width:82px;
}
div.bigbrokers .listdescription
{
	float:left;
	width:85%;
	color:black;
	display:inline-block;
}
div.bigbrokers .listdescription i
{
	color:blue;
}


#worknext
{
	width:298px;
	vertical-align:middle;
	text-align:center;
	font-weight:bold;
	background-color:<?php echo $_CONFIG['tarifar_border']; ?>;
	height:28px;
	font-size: 1.2em;
}
#worknext a
{
	padding-top:6px;
	color:black;
}

div.ac_results li
{
font-size:1.4em;
}
div.ac_results ul
{
}

#worknext
{
clear:both;
}

#spacer
{
	height:100px;
	display:block;
}
div.work_col1,div.work_col2
{
width: 299px;
float: left;
}
div.biglabel,div.workstep
{
width: 100%;
}


#worksteps div.workfields input
{
	width: 140px;
	height: 20px;
}

#worksteps div.linkstep a.biglink
{
	color:blue;
}

</style>

<style media="(max-device-width: 599px)">
div.worklabel
{
width:90%;
}
#worknext
{
width:100%;
}

div.workfields
{
text-align:center;
width: 180px;
}
div.worklabel
{
text-align:center;
}
#worksteps
{
width: 180px;
}
div.biglabel,div.workstep,div.workstep a.biglink
{
width: 178;
}
div.work_col1,div.work_col2
{
width: 180px;
}

</style>

<style media="(min-device-width: 600px)">

#worksteps
{
width:600px;
border:solid 1px <?php echo $_CONFIG['tarifar_border']; ?>;
background-color:<?php echo $_CONFIG['tarifar_bg']; ?>;
}
div.work_col2
{
float:left;
border-left:solid 1px <?php echo $_CONFIG['tarifar_border']; ?>;
width:299px;
}
div.work_col1
{
float:left;
border-right:solid 1px <?php echo $_CONFIG['tarifar_border']; ?>;
width:299px;
}
<?php if(getUserConfig("tarifarcomplet")!="yes") {?>
div.workstep
{
	display:none;
}
<?php } ?>

#worknext
{
	margin-left: 150px;
}

</style>
<style media="(min-device-width: 800px)">
#sidebarload
{
display:block;
}
</style>

<style media="screen and (-webkit-min-device-pixel-ratio: 2) and (min-device-width: 768px)">
#worksteps
{
width:1200px;
}
#sidebarload
{
display:none;
}
div.workfields
{
width: 370px;
}
div.worklabel
{
width: 200px;
}

</style>

<?php if(getUserConfig("nosidebar")=="yes"){?>
<style>
#sidebarload
{
display:none;
}
</style>
<?php } ?>

