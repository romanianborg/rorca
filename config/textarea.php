<?php 
require_once("jquery.php");
ob_start();?>
<script type="text/javascript" src="extern/niceditor/nicEdit.js"></script>
<?php
cache_addvalue("beginhead",ob_get_contents());ob_end_clean();
ob_start();?>
<script type="text/javascript">
$(document).ready(function(){
myNicEditor = new nicEditor({iconsPath:'extern/niceditor/nicEditorIcons.gif',buttonList : ['fontSize','fontFamily','forecolor','bold','italic','underline','link','unlink','removeformat','xhtml']});
$('textarea.mceEditor').each(function(){myNicEditor.panelInstance($(this).attr("id"));});});
</script><?php
cache_addvalue("finalhead",ob_get_contents());ob_end_clean();?>