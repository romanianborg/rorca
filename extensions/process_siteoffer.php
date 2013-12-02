<?php

//check post action
if(isset($_GET['unicreditipn']) && $_GET['unicreditipn'])
{
	function unicredit_mac($data, $key)
	{
		$str = NULL;

		foreach($data as $d)
		{
			if($d === NULL || strlen($d) == 0)
			$str .= '-'; // valorile nule sunt inlocuite cu -
			else
			$str .= strlen($d) . $d;
		}

		return bin2hex (mhash(MHASH_SHA1, $str, pack('H*' , $key)));
	}
	//$_GET=;
	$_POST=$_GET;

	$dataAll = array(
		'TERMINAL' => getUserConfig("ws_merch_terminal"),
		'TRTYPE'  => addslashes(trim(@$_GET['TRTYPE'])),
		'ORDER'    => addslashes(trim(@$_GET['ORDER'])),
		'AMOUNT'    => addslashes(trim(@$_GET['AMOUNT'])),
		'CURRENCY'    => addslashes(trim(@$_GET['CURRENCY'])),
		'DESC'    => addslashes(trim(@$_GET['DESC'])),
		'ACTION'    => addslashes(trim(@$_GET['ACTION'])),
		'RC'    => addslashes(trim(@$_GET['RC'])),
		'MESSAGE'    => addslashes(trim(@$_GET['MESSAGE'])),
		'RRN'    => addslashes(trim(@$_GET['RRN'])),
		'INT_REF'    => addslashes(trim(@$_GET['INT_REF'])),
		'APPROVAL'    => addslashes(trim(@$_GET['APPROVAL'])),
		'TIMESTAMP'    => addslashes(trim(@$_GET['TIMESTAMP'])),
		'NONCE'    => addslashes(trim(@$_GET['NONCE']))
	); 

	$P_SIGN=addslashes(trim(@$_GET['P_SIGN']));
	$p_sign_calculat = strtoupper(unicredit_mac($dataAll,getUserConfig("ws_merch_key")));

	if($P_SIGN==$p_sign_calculat)
	{
		// start facem update in baza de date
		if($dataAll['ACTION']=="0")
		{
			require_once("extensions/process_offer_ws.php");
			$offid=intval($_GET['ORDER']);
			if(intval($offid))
			{
				//force approved
				$_POST['offid']=intval($offid);
				$_POST['ipnmessage']=$_GET['MESSAGE'];
				$_POST['ipnamount']=$_GET["AMOUNT"];
				$_POST['ipnrrn']=$_GET["RRN"];
				$_POST['ipnref']=$_GET["INT_REF"];
				$off=ws_process('DateOferta');
				if($off===false)
				{
					echo "O eroare neastepta nu permite inreg platii. Va rugam sa incercati mai tarziu sau sa ne contactati. Un operator va face verificarile necesare.";
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
		else {
			echo "O eroare neastepta nu permite inreg platii ".$_GET['MESSAGE'];
		}
	// end facem update in baza de date
	}
	else {
		echo "Nu am putut calcula ultima zecimala a lui PI. ";
	}

	die();
}
if(isset($_GET['euplatescipn']) && $_GET['euplatescipn'])
{
	function hmacsha1($key,$data) {
		$blocksize = 64;
		$hashfunc  = 'md5';

		if(strlen($key) > $blocksize)
		$key = pack('H*', $hashfunc($key));

		$key  = str_pad($key, $blocksize, chr(0x00));
		$ipad = str_repeat(chr(0x36), $blocksize);
		$opad = str_repeat(chr(0x5c), $blocksize);

		$hmac = pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $data))));
		return bin2hex($hmac);
	}
	function euplatesc_mac($data, $key = NULL)
	{
		$str = NULL;

		foreach($data as $d)
		{
			if($d === NULL || strlen($d) == 0)
			$str .= '-'; // valorile nule sunt inlocuite cu -
			else
			$str .= strlen($d) . $d;
		}

		$key = pack('H*', $key); 

		return hmacsha1($key, $str);
	}
	$_GET=$_POST;
	$key=getUserConfig("euplatesc_key");
	$zcrsp =  array (
	'amount'     => addslashes(trim(@$_POST['amount'])),  //original amount
	'curr'       => addslashes(trim(@$_POST['curr'])),    //original currency
	'invoice_id' => addslashes(trim(@$_POST['invoice_id'])),//original invoice id
	'ep_id'      => addslashes(trim(@$_POST['ep_id'])), //Euplatesc.ro unique id
	'merch_id'   => addslashes(trim(@$_POST['merch_id'])), //your merchant id
	'action'     => addslashes(trim(@$_POST['action'])), // if action ==0 transaction ok
	'message'    => addslashes(trim(@$_POST['message'])),// transaction responce message
	'approval'   => addslashes(trim(@$_POST['approval'])),// if action!=0 empty
	'timestamp'  => addslashes(trim(@$_POST['timestamp'])),// meesage timestamp
	'nonce'      => addslashes(trim(@$_POST['nonce'])),
	);
	$zcrsp['fp_hash'] = strtoupper(euplatesc_mac($zcrsp, $key));

	$fp_hash=addslashes(trim(@$_POST['fp_hash']));
	if($zcrsp['fp_hash']===$fp_hash)
	{
		// start facem update in baza de date
		if($zcrsp['action']=="0")
		{
			require_once("extensions/process_offer_ws.php");
			$offid=intval($_GET['invoice_id']);
			if(intval($offid))
			{
				//force approved
				$_POST['offid']=intval($offid);
				$_POST['ipnmessage']=$_GET['message'];
				$_POST['ipnamount']=$_GET["amount"];
				$_POST['ipnrrn']=$_GET["ep_id"];
				$_POST['ipnref']=$_GET["ep_id"];
				$off=ws_process('DateOferta');
				if($off===false)
				{
					echo "O eroare neastepta nu permite inreg platii. Va rugam sa incercati mai tarziu sau sa ne contactati. Un operator va face verificarile necesare.";
				}
				else
				{
					if($_GET['message']=="Approved")
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
		else {
			echo "O eroare neastepta nu permite inreg platii ".$zcrsp['message'];
		}
	// end facem update in baza de date
	}
	else {
		echo "Nu am putut calcula ultima zecimala a lui PI.";
	}

	die();
}
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
if($_GET['view']=="pdf" || $_GET['view']=="decont")
{
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('Portofoliu');
	die();
}
if(isset($_POST['action']) && ($_POST['action']=="ContulNou" || $_POST['action']=="ParolaUitata" || $_POST['action']=="ContulTau"  || $_POST['action']=="Reincarca"))
{
	require_once("extensions/process_offer_ws.php");
	$off=ws_process($_POST['action']);
	if($off===false)
	{
	?><textarea>
$("#worksteps").show();
$("#workloading").hide();
	<?php
		if($_local_error!="Voi implementa")
		{
		?>
alert('Info: <?php global $_local_error;echo $_local_error;?>');
		<?php
		}
	?>
</textarea>
	<?php
	}
	else
	{
	?>
<textarea>location.href='site.php?t=client';</textarea>
	<?php
	}

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
$("#worksteps").show();
$("#workloading").hide();
alert('O eroare neastepta nu permite salvarea. Va rugam sa incercati mai tarziu sau sa ne contactati.');
</textarea>
	<?php
	}
	else
	{
		switch($_POST['tipplata'])
		{
			case 'unicredit':
	?>
<textarea>location.href='site.php?t=unicredit&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
			case 'euplatesc':
	?>
<textarea>location.href='site.php?t=euplatesc&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
			case 'libra':
	?>
<textarea>location.href='site.php?t=librapay&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
			case 'mobilpay':
	?>
<textarea>location.href='site.php?t=mobilpay&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
			case 'contact':
	?>
<textarea>location.href='site.php?t=thankyou&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
	<?php
			break;
			case 'ramburs':
			case 'op':
			default:
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
$("#worksteps").show();
$("#workloading").hide();
alert('O eroare neastepta nu permite tarifarea. Va rugam sa incercati mai tarziu sau sa ne contactati.');
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
if($_GET['t']=="unicredit")
{
	?><html><body onload="document.forms[0].submit();"><?php
	//get offer info
	require_once("extensions/process_offer_ws.php");
	$off=ws_process("InfoOferta",$_GET['offid']);

	function unicredit_mac($data, $key)
	{
		$str = NULL;

		foreach($data as $d)
		{
			if($d === NULL || strlen($d) == 0)
			$str .= '-'; // valorile nule sunt inlocuite cu -
			else
			$str .= strlen($d) . $d;
		}

		return bin2hex (mhash(MHASH_SHA1, $str, pack('H*' , $key)));
	}

	$dataAll = array(
		'AMOUNT'      => number_format(getNumberFromPost($_GET['pret'],2),2,'.',''),
		'CURRENCY'        => 'RON',
		'ORDER'  => str_pad(intval($_GET['offid']),6,'0',STR_PAD_LEFT),
		'DESC'  => 'Plata decont prima conform oferta '. intval($_GET['offid']),
		'MERCH_NAME'    => getUserConfig("ws_merch_name"),
		'MERCH_URL'    => getUserConfig("ws_merch_url"),
		'MERCHANT'    => getUserConfig("ws_merchant"),
		'TERMINAL' => getUserConfig("ws_merch_terminal"),
		"EMAIL" => getUserConfig("ws_merch_email"),
		"TRTYPE" => '0',
		"COUNTRY" => '',
		"MERCH_GMT" => '',
		'TIMESTAMP'   => gmdate("YmdHis"),
		'NONCE'       => md5(microtime() . mt_rand()),
		'BACKREF'       => getUserConfig("ws_merch_backurl")
	); 

	$p_sign = strtoupper(unicredit_mac($dataAll,getUserConfig("ws_merch_key")));

?>

<form ACTION="<?php echo getUserConfig("ws_merch_action");?>" METHOD="POST" name="gateway" target="_self">

<?php
foreach($dataAll as $k=>$v)
{
?>
<input type="hidden" NAME="<?php echo $k;?>" VALUE="<?php echo  $v; ?>" />
<?php
}
?>
<input type="hidden" NAME="P_SIGN" VALUE="<?php echo  $p_sign; ?>" />

<input type=submit value="Plateste">
</form></body></html>
<?php
	die();
}
if($_GET['t']=="euplatesc")
{
	?><html><body onload="document.forms[0].submit();"><?php
	$mid=getUserConfig('euplatesc_mid');
	$key=getUserConfig("euplatesc_key");
	//get offer info
	require_once("extensions/process_offer_ws.php");
	$off=ws_process("InfoOferta",$_GET['offid']);

	function hmacsha1($key,$data) {
		$blocksize = 64;
		$hashfunc  = 'md5';

		if(strlen($key) > $blocksize)
		$key = pack('H*', $hashfunc($key));

		$key  = str_pad($key, $blocksize, chr(0x00));
		$ipad = str_repeat(chr(0x36), $blocksize);
		$opad = str_repeat(chr(0x5c), $blocksize);

		$hmac = pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $data))));
		return bin2hex($hmac);
	}

	function euplatesc_mac($data, $key)
	{
		$str = NULL;

		foreach($data as $d)
		{
			if($d === NULL || strlen($d) == 0)
			$str .= '-'; // valorile nule sunt inlocuite cu -
			else
			$str .= strlen($d) . $d;
		}
		$key = pack('H*', $key); // convertim codul secret intr-un string binar
		return hmacsha1($key, $str);
	}


	$dataAll = array(
		'amount'      => number_format(getNumberFromPost($_GET['pret'],2),2,'.',''),                                                   //suma de plata
		'curr'        => 'RON',                                                   // moneda de plata
		'invoice_id'  => intval($_GET['offid']),
		'order_desc'  => 'Plata decont prima conform oferta '. intval($_GET['offid']),                                            //descrierea comenzii
		'merch_id'    => $mid,                                                    // nu modificati
		'timestamp'   => gmdate("YmdHis"),                                        // nu modificati
		'nonce'       => md5(microtime() . mt_rand()),                            //nu modificati
	); 

	$dataAll['fp_hash'] = strtoupper(euplatesc_mac($dataAll,$key));

	$dataBill = array(
		'fname'	   => $off['nume']['VALUE'],      // nume
		'lname'	   => $off['prenume']['VALUE'],   // prenume
		'country'  => 'Romania',      // tara
		'company'  => '',   // firma
		'city'	   => $off['localitate']['VALUE'],      // oras
		'add'	   => $off['adresa']['VALUE'],    // adresa
		'email'	   => $off['emailclient']['VALUE'],     // email
		'phone'	   => $off['telclient']['VALUE'],   // telefon
		'fax'	   => '',       // fax
	);
	$dataShip = array(
		'sfname'       => $off['nume']['VALUE'],     // nume
		'slname'       => $off['prenume']['VALUE'],  // prenume
		'scountry'     => 'Romania',     // tara
		'scompany'     => '',  // firma
		'scity'	       => $off['localitate']['VALUE'],     // oras
		'sadd'         => $off['adresa']['VALUE'],      // adresa
		'semail'       => $off['emailclient']['VALUE'],    // email
		'sphone'       => $off['telclient']['VALUE'],  // telefon
		'sfax'	       => '',      // fax
	);

?>

<form ACTION="https://secure.euplatesc.ro/tdsprocess/tranzactd.php" METHOD="POST" name="gateway" target="_self">

<!-- begin billing details -->
    <input name="fname" type="hidden" value="<?php echo $dataBill['fname'];?>" />
    <input name="lname" type="hidden" value="<?php echo $dataBill['lname'];?>" />
    <input name="country" type="hidden" value="<?php echo $dataBill['country'];?>" />
    <input name="company" type="hidden" value="<?php echo $dataBill['company'];?>" />
    <input name="city" type="hidden" value="<?php echo $dataBill['city'];?>" />
    <input name="add" type="hidden" value="<?php echo $dataBill['add'];?>" />
    <input name="email" type="hidden" value="<?php echo $dataBill['email'];?>" />
    <input name="phone" type="hidden" value="<?php echo $dataBill['phone'];?>" />
    <input name="fax" type="hidden" value="<?php echo $dataBill['fax'];?>" />
<!-- snd billing details -->

<!-- daca detaliile de shipping difera -->
<!-- begin shipping details -->
    <input name="sfname" type="hidden" value="<?php echo $dataShip['sfname'];?>" />
    <input name="slname" type="hidden" value="<?php echo $dataShip['slname'];?>" />
    <input name="scountry" type="hidden" value="<?php echo $dataShip['scountry'];?>" />
    <input name="scompany" type="hidden" value="<?php echo $dataShip['scompany'];?>" />
    <input name="scity" type="hidden" value="<?php echo $dataShip['scity'];?>" />
    <input name="sadd" type="hidden" value="<?php echo $dataShip['sadd'];?>" />
    <input name="semail" type="hidden" value="<?php echo $dataShip['semail'];?>" />
    <input name="sphone" type="hidden" value="<?php echo $dataShip['sphone'];?>" />
    <input name="sfax" type="hidden" value="<?php echo $dataShip['sfax'];?>" />

<!-- end shipping details -->

<input type="hidden" NAME="amount" VALUE="<?php echo  $dataAll['amount'] ?>" SIZE="12" MAXLENGTH="12" />
<input TYPE="hidden" NAME="curr" VALUE="<?php echo  $dataAll['curr'] ?>" SIZE="5" MAXLENGTH="3" />
<input type="hidden" NAME="invoice_id" VALUE="<?php echo  $dataAll['invoice_id'] ?>" SIZE="32" MAXLENGTH="32" />
<input type="hidden" NAME="order_desc" VALUE="<?php echo  $dataAll['order_desc'] ?>" SIZE="32" MAXLENGTH="50" />
<input TYPE="hidden" NAME="merch_id" SIZE="15" VALUE="<?php echo  $dataAll['merch_id'] ?>" />
<input TYPE="hidden" NAME="timestamp" SIZE="15" VALUE="<?php echo  $dataAll['timestamp'] ?>" />
<input TYPE="hidden" NAME="nonce" SIZE="35" VALUE="<?php echo  $dataAll['nonce'] ?>" />
<input TYPE="hidden" NAME="fp_hash" SIZE="40" VALUE="<?php echo  $dataAll['fp_hash'] ?>" />

<input type="hidden" name="ExtraData[rate]" value="<?php echo $off['optrate']?>">

<input type=submit value="Plateste">
</form></body></html>
<?php
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
	$payment->desc = "Plata decont de prima conform oferta nr. ".intval($_GET['offid']);

	//get offer info
	require_once("extensions/process_offer_ws.php");
	$off=ws_process("InfoOferta",$_GET['offid']);

	$data_custom = array(
		"ProductsData" => array(
			0 => array(
				"ItemName" => "Plata decont ".intval($_GET['offid']),
				"ItemDesc" => "Comisioane sunt suportate de broker",
				"Categ"    => "Asigurari",
				"Subcateg" => "Polita",
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
if($_GET['t']=="mobilpay")
{
	?><html><body onload="document.forms[0].submit();"><?php
	require_once 'extern/Mobilpay/Payment/Request/Abstract.php';
	require_once 'extern/Mobilpay/Payment/Request/Card.php';
	require_once 'extern/Mobilpay/Payment/Invoice.php';
	require_once 'extern/Mobilpay/Payment/Address.php';

	#for testing purposes, all payment requests will be sent to the sandbox server. Once your account will be active you must switch back to the live server https://secure.mobilpay.ro
	#in order to display the payment form in a different language, simply add the language identifier to the end of the paymentUrl, i.e https://secure.mobilpay.ro/en for English
	$paymentUrl = 'http://sandboxsecure.mobilpay.ro';
	//$paymentUrl = 'https://secure.mobilpay.ro';
	// this is the path on your server to the public certificate. You may download this from Admin -> Conturi de comerciant -> Detalii -> Setari securitate
	$x509FilePath 	= getUserConfig('mobilpay_cert');
	try
	{
		srand((double) microtime() * 1000000);
		$objPmReqCard 						= new Mobilpay_Payment_Request_Card();
		#merchant account signature - generated by mobilpay.ro for every merchant account
		#semnatura contului de comerciant - mergi pe www.mobilpay.ro Admin -> Conturi de comerciant -> Detalii -> Setari securitate
		$objPmReqCard->signature 			= getUserConfig("mobilpay_mid");
		$objPmReqCard->orderId 				= intval($_GET['offid']);
		$objPmReqCard->confirmUrl 			= getUserConfig("mobilpay_confirmUrl"); 
		$objPmReqCard->returnUrl 			= getUserConfig('mobilpay_returnUrl'); 
	
		#detalii cu privire la plata: moneda, suma, descrierea
		#payment details: currency, amount, description
		$objPmReqCard->invoice = new Mobilpay_Payment_Invoice();
		#payment currency in ISO Code format; permitted values are RON, EUR, USD, MDL; please note that unless you have mobilPay permission to 
		#process a currency different from RON, a currency exchange will occur from your currency to RON, using the official BNR exchange rate from that moment
		#and the customer will be presented with the payment amount in a dual currency in the payment page, i.e N.NN RON (e.ee EUR)
		$objPmReqCard->invoice->currency	= 'RON';
		$objPmReqCard->invoice->amount		= getNumberFromPost($_GET['pret'],2);
		#available installments number; if this parameter is present, only its value(s) will be available
		//$objPmReqCard->invoice->installments= '2,3';
		#selected installments number; its value should be within the available installments defined above
		//$objPmReqCard->invoice->selectedInstallments= '3';
		$objPmReqCard->invoice->details		=  "Plata decont de prima conform oferta nr. ".intval($_GET['offid']);

		#detalii cu privire la adresa posesorului cardului
		#details on the cardholder address (optional)
		$billingAddress 				= new Mobilpay_Payment_Address();
		$billingAddress->type			= 'person'; //should be "person"
		$billingAddress->firstName		= $off['nume']['VALUE'];
		$billingAddress->lastName		= $off['prenume']['VALUE'];
		$billingAddress->address		= $off['adresa']['VALUE'].', '.$off['localitate']['VALUE'].', jud. '.$off['judet']['VALUE'];
		$billingAddress->email			= $off['emailclient']['VALUE'];
		$billingAddress->mobilePhone		= $off['telclient']['VALUE'];
		
		$objPmReqCard->invoice->setBillingAddress($billingAddress);
		$objPmReqCard->invoice->setShippingAddress($billingAddress);

		#uncomment the line below in order to see the content of the request
		//echo "<pre>";print_r($objPmReqCard);echo "</pre>";
		$objPmReqCard->encrypt($x509FilePath);
	}
	catch(Exception $e)
	{
	}
	?>
	<form name="frmPaymentRedirect" method="post" action="<?php echo $paymentUrl;?>">
	<input type="hidden" name="env_key" value="<?php echo $objPmReqCard->getEnvKey();?>"/>
	<input type="hidden" name="data" value="<?php echo $objPmReqCard->getEncData();?>"/>
	</form>
	</body></html><?php
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
<?php
$loadsteper=true;
switch($_GET['t'])
{
case 'rca':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
	{
		if(getUserConfig("color_design")=="2" && file_exists("extensions/info_tarifar_rca2_tarife.php"))
		{
			include("extensions/info_tarifar_rca2_tarife.php");
			$loadsteper=false;
		}
		else
			include("extensions/info_tarifar_rca1_tarife.php");
	}
	else
	{
		if(getUserConfig("color_design")=="2" && file_exists("extensions/info_tarifar_rca2.php"))
		{
			include("extensions/info_tarifar_rca2.php");
			$loadsteper=false;
		}
		else
			include("extensions/info_tarifar_rca1.php");
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
		include("extensions/info_tarifar_rca1_thanks.php");
	else
		include("extensions/info_tarifar_decont.php");
break;
case 'thankyou':
	if(getUserConfig("color_design")=="2" && file_exists("extensions/info_tarifar_rca2_thanks.php"))
	{
		include("extensions/info_tarifar_rca2_thanks.php");
	}
	else
	{
		include("extensions/info_tarifar_rca1_thanks.php");
	}
break;
case 'error':
	include("extensions/info_tarifar_rca1_error.php");
break;
case 'client':
	include("extensions/info_client.php");
break;
case 'clientnou':
	include("extensions/info_client_register.php");
break;
case 'clientforgot':
	include("extensions/info_client_forgot.php");
break;
}

ob_start();?>
<script>
$(document).bind('slotReloaded',function(event,data){reloadSteper(true);});
$(document).ready(function(){reloadSteper(true);});
</script><?php
cache_addvalue("afterbody",ob_get_contents());ob_end_clean();

	if($loadsteper) {
	?>
	<div id="worknext"><a href="#workstep" onclick="return loadOneStep('button')"><img src="images/creion.png" border=0>   Urmatorul&nbsp;pas</a></div>
	<?php } ?>
</div>
</form>
<div id=spacer></div>
<div id="sidebarload">
<div class="sidebarbutton sidebarbutton_rca"><a href="site.php?t=rca" class="sidebarlink">RCA</a></div>
<div class="sidebarbutton sidebarbutton_casco"><a href="site.php?t=casco" class="sidebarlink">CASCO</a></div>
<div class="sidebarbutton sidebarbutton_pad"><a href="site.php?t=pad" class="sidebarlink">LOCUINTE</a></div>
<div class="sidebarbutton sidebarbutton_medicale"><a href="site.php?t=medicale" class="sidebarlink">MEDICALE</a></div>
<div class="sidebarbutton sidebarbutton_decont"><a href="site.php?t=decont" class="sidebarlink">ALTE</a></div>
<div class="sidebarbutton sidebarbutton_client"><a href="site.php?t=client" class="sidebarlink">CONT</a></div>
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
