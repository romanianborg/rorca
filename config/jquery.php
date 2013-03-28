<?php ob_start();
if(!function_exists("jQueryPluginRequired"))
{
?><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
		<script type="text/javascript" src="js/<?php echo $plugin;?>.js"></script>
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
}
?>
