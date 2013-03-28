<?php

//check post action
if(isset($_GET['librapayipn']) && $_GET['librapayipn'])
{
/*
	require_once("extensions/process_offer_ws.php");
	$_POST['offid']=intval($_GET['offid']);
	$_POST['ipnmessage']=$_GET['ipnmessage'];
	$_POST['ipnamount']=$_GET["ipnamount"];
	$_POST['ipnrrn']=$_GET["ipnrrn"];
	$_POST['ipnref']=$_GET["ipnref"];
	$off=ws_process('DateOferta');
	die();
*/

	require_once("extern/payment_shop.php");
	$payment = new Payment;

	$data = $_GET;
	if($_GET['librapayipn_post'])
		$data = $_POST;
	else
		$data = $_GET;

	$payment->terminal = $data["TERMINAL"];
	$payment->trtype = $data["TRTYPE"];
	$payment->order = $data["ORDER"];
	$payment->amount = $data["AMOUNT"];
	$payment->currency = $data["CURRENCY"];
	$payment->desc = $data["DESC"];
	$payment->action = $data["ACTION"];
	$payment->rc = $data["RC"];
	$payment->message = $data["MESSAGE"];
	$payment->rrn = $data["RRN"];
	$payment->int_ref = $data["INT_REF"];
	$payment->approval = $data["APPROVAL"];
	$payment->timestamp = $data["TIMESTAMP"];
	$payment->nonce = $data["NONCE"];
	$payment->key=getUserConfig('ws_merch_key');

	$payment->getString("preAuthResponse");
	$payment->getHexKey();
	$payment->getPsign();
//	echo $payment->string;echo "<br>";
//	echo $_GET['STRING'];echo "<br>";
	// validare psign
//	echo $data["P_SIGN"];echo "<br>";
//	echo $payment->psign;echo "<br>";

	if($data["P_SIGN"] != $payment->psign)
	{
		if($_GET['librapayipn_post'])
		{
			echo "0";
		}
		else
		{
			echo "Nu am putut calcula ultima zecimala a lui PI.";
		}
	}
	else
	{
		// mesajul e bun, aici puteti sa va actualizati statusul comenzii "platita"
		//register payment
		require_once("extensions/process_offer_ws.php");
		$orderid=$_GET['ORDER'];
		$testorder=substr($orderid,1,-3);
		$no=intval(substr($_GET['ORDER'],0,1));
		$offid=substr($testorder,0,strlen($testorder)/$no);
		if(intval($offid))
		{
			$_POST['offid']=intval($offid);
			$_POST['ipnmessage']=$_GET['MESSAGE'];
			$_POST['ipnamount']=$_GET["AMOUNT"];
			$_POST['ipnrrn']=$_GET["RRN"];
			$_POST['ipnref']=$_GET["INT_REF"];
			$off=ws_process('DateOferta');
			if($off===false)
			{
				if($_GET['librapayipn_post'])
				{
					echo "0";
				}
				else
				{
					echo "O eroare neastepta nu permite inreg platii. Va rugam sa incercati mai tarziu sau sa ne contactati. Un operator va face verificarile necesare.";
				}
			}
			else
			{
				if($_GET['librapayipn_post'])
				{
					echo "1";
				}
				else
				{
					if($_GET['MESSAGE']=="Approved")
					{
						header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=thankyou&offid=".$offid);
					}
					else
					{
						header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=".$_GET['MESSAGE']);
					}
				}
			}
		}
	}

	die();

}
if(isset($_GET['WakeupCall']) && intval($_GET['WakeupCall'])>0)
{
	@session_write_close();
	//call ws
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('WakeupCall');

	die();
}
if(isset($_GET['TarifeOferta']) && intval($_GET['TarifeOferta'])>0)
{
	//call ws
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('TarifeOferta');

	die();
}
if(isset($_GET['PolitaOferta']) && intval($_GET['PolitaOferta'])>0)
{
	//call ws
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('PolitaOferta');

	die();
}
if(isset($_POST['action']) && $_POST['action']=="TarifeOferta")
{
	//call ws
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('DateOferta');
	if($off===false)
	{
	?><textarea>
alert('O eroare neastepta nu permite salvarea. Va rugam sa incercati mai tarziu sau sa ne contactati.');
$("#worksteps").show();
$("#workloading").hide();
</textarea>
	<?php
	}
	else
	{
		switch($_POST['tipplata'])
		{
			case 'libra':
	?>
<textarea>location.href='site.php?t=librapay&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
			case 'ramburs':
	?>
<textarea>location.href='site.php?t=thankyou&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
			case 'contact':
	?>
<textarea>location.href='site.php?t=thankyou&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
		}
	}

	die();
}
if(isset($_POST['action']) && $_POST['action']=="AdaugaOferta")
{
	//call ws

	require_once("extensions/process_offer_ws.php");
	$off=ws_process($_POST['action']);
	if($off===false)
	{
	?><textarea>
alert('O eroare neastepta nu permite tarifarea. Va rugam sa incercati mai tarziu sau sa ne contactati.');
$("#worksteps").show();
$("#workloading").hide();
</textarea>
	<?php
	}
	else
	{
	?>
<textarea>location.href='site.php?t=<?php echo $_POST['tipoferta'];?>&offid=<?php echo $off;?>';</textarea>
	<?php
	}

	die();
}
if($_GET['t']=="librapay")
{
	?><html><body onload="document.forms[0].submit();"><?php
	require_once("extern/payment_shop.php");
	$payment = new Payment;

	$payment->merch_name = getUserConfig("ws_merch_name");
	$payment->merch_url = getUserConfig("ws_merch_url");
	$payment->merchant = getUserConfig("ws_merchant");
	$payment->terminal = getUserConfig("ws_merch_terminal");
	$payment->email = getUserConfig("ws_merch_email");
	$payment->key = getUserConfig("ws_merch_key");
	$payment->postAction = getUserConfig("ws_merch_action");

	$payment->amount = number_format(getNumberFromPost($_GET['pret'],2),2,'.','');
	$builorder=''.intval($_GET['offid']);
	$buildcount=1;
	while(strlen($builorder)<6)
	{
		$builorder.=$builorder;
		$buildcount*=2;
	}
	$builorder=$buildcount.$builorder;
	$payment->order = $builorder.rand(100,999);
	$payment->desc = "Decont de prima";

	//get offer info
	require_once("extensions/process_offer_ws.php");
	$off=ws_process("InfoOferta",$_GET['offid']);

	$data_custom = array(
		"ProductsData" => array(
			0 => array(
				"ItemName" => "Plata decont de prima",
				"ItemDesc" => "comisioane suportate de broker",
				"Categ"    => "Asigurari",
				"Subcateg" => "RCA",
				"Quantity" => "1",
				"Price"	   => $payment->amount
			)
		),
		"UserData" => array(
			"LoginName" => intval($_GET['offid']),
			"Email"     => $off['emailclient']['VALUE'],
			"Name"	    => $off['nume']['VALUE'],
			"Surname"	=> $off['prenume']['VALUE'],
			"Cnp"		=> $off['cnpcui']['VALUE'],
			"Phone"		=> $off['telclient']['VALUE'],

			// Date de Livrare

			"ShippingName"		=> $off['nume']['VALUE'], 					// varchar(100)
			"ShippingSurname"	=> $off['prenume']['VALUE'], 					// varchar(100)
			"ShippingID"		=> $off['ciserie']['VALUE'], 					// varchar(15)
			"ShippingIDNumber"	=> $off['cinumar']['VALUE'], 					// varchar(10)
			"ShippingIssuedBy"	=> $off['localitate']['VALUE'], 				// varchar(100)
			"ShippingEmail"		=> $off['emailclient']['VALUE'], 			// varchar(100)
			"ShippingPhone"		=> $off['telclient']['VALUE'],				// varchar(50)
			"ShippingAddress"	=> $off['adresa']['VALUE'], 			// varchar(255)
			"ShippingCity"		=> $off['localitate']['VALUE'], 					// varchar(50)
			"ShippingPostalCode"	=> $off['zip']['VALUE'],	 				// varchar(50)
			"ShippingDistrict"	=> $off['judet']['VALUE'], 					// varchar(50)
			"ShippingCountry"	=> "Romania", 					// varchar(50)


			// Date de Facturare

			"BillingName"		=> $off['nume']['VALUE'], 					// varchar(100)
			"BillingSurname"	=> $off['prenume']['VALUE'], 					// varchar(100)
			"BillingID"		=> $off['ciserie']['VALUE'],			 		// varchar(15)
			"BillingIDNumber"	=> $off['cinumar']['VALUE'],	 				// varchar(10)
			"BillingIssuedBy"	=> $off['localitate']['VALUE'], 				// varchar(100)
			"BillingEmail"		=> $off['emailclient']['VALUE'], 			// varchar(100)
			"BillingPhone"		=> $off['telclient']['VALUE'], 				// varchar(50)
			"BillingAddress"	=> $off['adresa']['VALUE'], 			// varchar(255)
			"BillingCity"		=> $off['localitate']['VALUE'], 					// varchar(50)
			"BillingPostalCode"	=> $off['zip']['VALUE'], 					// varchar(50)
			"BillingDistrict"	=> $off['judet']['VALUE'], 					// varchar(50)
			"BillingCountry"	=> "Romania" 					// varchar(50)

		)
	);

	$payment->dataProducts = base64_encode(serialize($data_custom));
	$payment->generateForm();

	echo $payment->form;
	//echo $payment->string;
	//echo '<pre>';print_r($data_custom);echo '</pre>';
	?></body></html><?php
	die();
}
if($_GET['t']=="polita")
{
	//call ws
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('PDFOferta');

	//return a PDF from ws
	if($off!='')
	{
		header("Content-type: application/pdf");
		header("Content-length: ".strlen($off));
		echo $off;
	}
	else
	{
		echo "Polita PDF nu a putut fi gasita. Un operator o va trimite pe mail sau o sa fiti contactat.";
	}
	die();
}

//require_once("config/textarea.php");
require_once("config/ajaxify.php");
jQueryPluginRequired("jquery.autocomplete");

//head
ob_start();
require_once("extensions/info_commonoferta.php");
require_once("extensions/info_css.php");
?>
	<script src="js/jquery.tipsy.js"></script>
	<link rel="stylesheet" href="js/jquery.tipsy.css" type="text/css" />
	<script src="js/jquery.scrollTo.js"></script>
<?php
cache_addvalue("finalhead",ob_get_contents());ob_end_clean();

//body
ob_start();

if($_GET['t']=="all")
{
	include("info_tarifar_all.php");
}
else
if($_GET['t']=="brokers")
{
	include("info_tarifar_brokers.php");
}else
{

?>
<form enctype="multipart/form-data" method="post" action="?s=work" name="work">
<input type="hidden" name="frandom" value="<?php echo time();?>">
<div id=work>
<div id="worksteps">
<?php
switch($_GET['t'])
{
case 'rca':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
	{
		if(file_exists("extensions/info_tarifar_rca_tarife.php") && $_GET['nd']=="yes")
			include("extensions/info_tarifar_rca_tarife.php");
		else
			include("extensions/info_tarifar_rca3_tarife.php");
	}
	else
	{
		if(file_exists("extensions/info_tarifar_rca.php") && $_GET['nd']=="yes")
			include("extensions/info_tarifar_rca.php");
		else
			include("extensions/info_tarifar_rca3.php");
	}
break;
case 'medicale':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_medicale_tarife.php");
	else
		include("extensions/info_tarifar_medicale.php");
break;
case 'pad':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_pad_tarife.php");
	else
		include("extensions/info_tarifar_pad.php");
break;
case 'casco':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_casco_tarife.php");
	else
		include("extensions/info_tarifar_casco.php");
break;
case 'decont':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_rca3_thanks.php");
	else
		include("extensions/info_tarifar_decont.php");
break;
case 'thankyou':
		include("extensions/info_tarifar_rca3_thanks.php");
break;
case 'error':
		include("extensions/info_tarifar_rca3_error.php");
break;
}
?>
	<div id="worknext"><a href="#workstep" onclick="return loadOneStep('button')"><img src="images/creion.png" border=0>   Urmatorul&nbsp;pas</a></div>
</div>
</div>
</form>
<div id=spacer></div>
<div id="sidebarload">
<div class="sidebarbutton sidebarbutton_rca"><a href="site.php?t=rca" class="sidebarlink">RCA</a></div>
<div class="sidebarbutton sidebarbutton_casco"><a href="site.php?t=casco" class="sidebarlink">CASCO</a></div>
<div class="sidebarbutton sidebarbutton_pad"><a href="site.php?t=pad" class="sidebarlink">LOCUINTE</a></div>
<div class="sidebarbutton sidebarbutton_medicale"><a href="site.php?t=medicale" class="sidebarlink">MEDICALE</a></div>
<div class="sidebarbutton sidebarbutton_decont"><a href="site.php?t=decont" class="sidebarlink">ALTE</a></div>
</div>
<div id="workloading" style="display:none;"><img src="images/ajax-loader.gif" border="0"> Se incarca...</div>
<?php require_once("extensions/info_tarifar_js.php");?>
<a class="option" id="ajaxifyloader" href="#" style="display:none;">redirect</a>
<?php
}
cache_addvalue("body",ob_get_contents());ob_end_clean();

ob_start();
if(cache_getvalue("load_in_template")!="")
{
	include(cache_getvalue("load_in_template"));
}
cache_addvalue("body",ob_get_contents());ob_end_clean();

if(cache_getvalue("load_in_css")!="")
{
	ob_start();
	?><style>
	<?php include(cache_getvalue("load_in_css"));?>
	</style>
	<?php
	cache_addvalue("finalhead",ob_get_contents());ob_end_clean();
}

global $mycheader;
global $mycbody;
if($mycheader!="")
{
	cache_addvalue("finalhead",$mycheader);
}
if($mycbody!="")
{
	$myb=str_replace("[body]",cache_getvalue("body"),$mycbody);
	cache_setvalue("body",$myb);
}

//html
if(file_exists("extensions/justhtml.php"))
	include("extensions/justhtml.php");
else
	include("design/justhtml.php");


?>
