<?php ob_start();?><script type="text/javascript" src="js/blockenter.js"></script>
<?php cache_addvalue("head",ob_get_contents());ob_end_clean();?>