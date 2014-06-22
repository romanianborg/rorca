<?php ob_start();
if(getUserConfig("use_locale_jquery")=="yes")
{
?><script type="text/javascript" src="js/jquery.js?1"></script><?php
}
else
{
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<?php
}
?>
<script type="text/javascript">
function textareaImplode(name)
{
	var alltxt='';
	var allfi=true;
	$('.'+name+'_implode').each(function()
	{
		if($(this).val()!='')
		{
			if(!allfi) alltxt+=', ';
			allfi=false;
			alltxt+=$(this).attr('label')+'. '+$(this).val();
		}
	});
	alltxt=alltxt.toUpperCase();
	$('textarea[name='+name+']').html(alltxt);
	$('textarea[name='+name+']').val(alltxt);
}
</script>
<?php
cache_addvalue("beginhead",ob_get_contents());ob_end_clean();
function jQueryPluginRequired($plugin)
{
	//protect against double inclusions
	if(cache_getvalue("jquery_plugin_".$plugin)=='')
	{
		cache_addvalue("jquery_plugin_".$plugin,"loaded");
		ob_start();?>
		<script type="text/javascript" src="js/<?php echo $plugin;?>.js?1"></script>
		<?php
		cache_addvalue("head",ob_get_contents());ob_end_clean();
		if(file_exists("js/".$plugin.".css"))
		{
			ob_start();?>
			<style><?php include("js/".$plugin.".css");?></style>
			<?php
			cache_addvalue("finalhead",ob_get_contents());ob_end_clean();
		}
	}
}
?>
