<?php ob_start();?><script type="text/javascript" src="js/autocomplete.js"></script>
<?php cache_addvalue("head",ob_get_contents());ob_end_clean();?>