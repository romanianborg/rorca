<?php ob_start();if(file_exists(cache_getvalue('temp_default'))) include cache_getvalue('temp_default');$context=ob_get_contents();ob_end_clean();?>
<html>
<HEAD>
<?php if(cache_getvalue("title")!=""){?><TITLE><?php echo cache_getvalue("title");cache_setvalue("title","");?></TITLE><?php }?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<META NAME="Rating" CONTENT="<?php echo cache_getvalue("rating");cache_setvalue("rating","");?>" />
<meta name="robots" content="all" />
<meta name="AUTHOR" type="email" content="<?php echo cache_getvalue("author");cache_setvalue("author","");?>" />
<meta name="COPYRIGHT" content="<?php echo cache_getvalue("copyright");cache_setvalue("copyright","");?>" />
<meta NAME="revisit-after" CONTENT="10 days" />
<meta name="LASTUPDATE" content="<?php echo date('F j, Y, g:i a')?>" />
<meta name="SECURITY" content="Public" />
<meta name="keywords" content="<?php echo cache_getvalue("keywords");cache_setvalue("keywords","");?>">
<meta name="description" content="<?php echo cache_getvalue("description");cache_setvalue("description","");?>" />
<META name="verify-v1" content="<?php echo cache_getvalue("verify-v1");cache_setvalue("verify-v1","");?>" />
<meta id="testViewport" name="viewport" content="width=device-width,initial-scale=1"/>

<script type="text/javascript">
var tinyMCE;tinyMCE=false;var myNicEditor;myNicEditor=false;var currentPageProtection;currentPageProtection=<?php echo 0+intval(session_getvalue("protection_page"));?>;
</script>
<?php echo cache_getvalue("beginhead");cache_setvalue("beginhead","");?>
<?php echo cache_getvalue("head");cache_setvalue("head","");?>
<?php if(file_exists("extensions/user.js")){?><script language="javascript"><?php include "extensions/user.js";?></script><?php }?>
<style type="text/css" media="screen"><?php if(cache_getvalue("css_default")!=""){include cache_getvalue("css_default");} else if(file_exists("extensions/user.css")){include "extensions/user.css";} else {$stl='styles/style_orange.css'; if(session_getvalue('current_style')!='') $stl='styles/style_'.session_getvalue('current_style').'.css';include $stl;}?></style>
<style type="text/css" media="print"><?php if(file_exists("extensions/print.css")){include "extensions/print.css";} ?></style>
<?php echo cache_getvalue("finalhead");cache_setvalue("finalhead","");?>
</head>
<body class=backbody><?php
echo cache_getvalue("body");cache_setvalue("body","");
echo $context;?>
<?php
echo cache_getvalue("afterbody");cache_setvalue("afterbody","");
?>
</body>
</html>
