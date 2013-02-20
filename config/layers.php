<?php ob_start();?><script type="text/javascript" src="js/layers.js"></script>
<?php cache_addvalue("head",ob_get_contents());ob_end_clean();?>