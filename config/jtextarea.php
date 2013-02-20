<?php
require_once("config/jquery.php");
ob_start();?>
<script language="javascript" type="text/javascript" src="js/jtextarea.js"></script>
<style>
.resizable-textarea .grippie
{
height: 9px;
overflow-x: hidden;
overflow-y: hidden;
background-color: #eeeeee;
background-repeat: no-repeat;
background-attachment: scroll;
background-position: 50% 2px;
border-right-width: 1px;
border-bottom-width: 1px;
border-left-width: 1px;
border-top-style: solid;
border-right-style: solid;
border-bottom-style: solid;
border-left-style: solid;
border-top-color: #dddddd;
border-right-color: #dddddd;
border-bottom-color: #dddddd;
border-left-color: #dddddd;
border-top-width: 0pt;
cursor: s-resize;
}
</style>
<?php
cache_addvalue("head",ob_get_contents());ob_end_clean();?>