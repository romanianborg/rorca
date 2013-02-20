<?php
global $_CONFIG; 

$_CONFIG['dbhost']="localhost";
$_CONFIG['dbuser']="root";
$_CONFIG['dbdb']="crm";
$_CONFIG['dbpass']="root";
$_CONFIG['adminpath']="admin.saleclan.com";

//webservice
$_CONFIG['ws_username']='webservice';
$_CONFIG['ws_parola']='webservice';
$_CONFIG['ws_brokerurl']='http://demo.asiguram.ro/webservice.php';

$_CONFIG['color_profile']="2";

$_CONFIG['mesaj_multumire']='Multumim pentru plata. Un operator va verifica emiterea.';
$_CONFIG['mesaj_eroare']='Multumim pentru comanda, un operator va prelua comanda imediat ce e posibil.';
$_CONFIG['datepicker']="yes";
//$_CONFIG['emaildinprima']="yes";

//cache_setvalue("load_in_template","../cache/temp2_31.php");
//cache_setvalue("load_in_css","../cache/css_31.php");

//se include in template:  echo cache_getvalue("body");cache_setvalue("body","");
?>
