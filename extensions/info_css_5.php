<?php
	global $_CONFIG;
	$_CONFIG['button_bg']="#3045FF";
	$_CONFIG['button_border']="#3045FF";
	$_CONFIG['button_color']="white";
	$_CONFIG['tarifar_border']="#aaaaff";
	$_CONFIG['tarifar_bg']="white";
	$_CONFIG['tarifar_color']="black";

	$_CONFIG['alert_color']="#FFD800";
	$_CONFIG['current_color']="#F6E5C7";
	$_CONFIG['active_color']="#F6E5C7";

	$_CONFIG['tarif_bg']="white";
	include("extensions/info_css_base.php");

?>
<style>
#workprogress_step
{
	background-color:<?php echo $_CONFIG['alert_color']; ?>;
}
#work input[type="text"], #work textarea, #work select
{
	border:solid 1px #3045FF;
}
</style>

