<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2015
//check post action
if(isset($_GET['plationlineipn']) && $_GET['plationlineipn'])
{
	require_once("extern/clspo.php");

	$my_class = new PO3();
	$my_class->LoginID = $lid;
	$my_class->KeyEnc = $ke;
	$my_class->KeyMod = $km;

	// If you select ITSN POST Method in merchant secure interface
	$vF_Message=$_POST["F_MESSAGE_ITSN"];
	$vF_Crypt_Message= $_POST["F_CRYPT_MESSAGE_ITSN"];
	$vF_ORDER_NUMBER = $_POST["F_ORDER_NUMBER"];
	$vF_Amount= $_POST["F_AMOUNT"];
	$vF_Currency= $_POST["F_CURRENCY"];
	$vX_Trans_ID = $_POST["X_TRANS_ID"];
	$vMy_F_Message=strtoupper($my_class->VerifyFRM(strval($vF_Message)));

	if($vF_Crypt_Message!=$vMy_F_Message)
		die("ERROR!!!<hr>hacking attempt.[Relay Message]");

	$vA= explode("^", $vF_Message);

	$vCurrencyMessage= $vA[4];

	if($vCurrencyMessage!=$vF_Currency)
		die("ERROR!!!<hr>Hacking attempt.[Currency Relay Message]");

	$vAmountMessage= $vA[3];
	if($vAmountMessage!=$vF_Amount)	
		die("ERROR!!!<hr>Hacking attempt.[Amount Relay Message]");

	$vX_Trans_ID_Message= $vA[5];

	if($vX_Trans_ID!=$vX_Trans_ID_Message)
		die("ERROR!!!<hr>Hacking attempt.[Response Code Relay Message]");

	$vReponseStamp= $vA[2];

	$my_class->OrderNumber = $vF_ORDER_NUMBER;
	$my_class->TransID = $vX_Trans_ID;		
	$my_class->action = "0"; //interogare

	$rez = $my_class->InsertHash_Interog();	

	//pentru fiecare case actualizati statusul comenzii in magazinul dvs.

	/* Verify X_STARE_FIN1 status */		
	$stare1='<f_response_code>1</f_response_code>';
		switch ($rez["X_STARE_FIN1"])
		{
			case '13':
				$starefin = 'In proces de verificare';
				break;		
			case '2':
				$starefin = 'Autorizata';
				break;
			case '8':
				$starefin = 'Refuzata';
				break;
			case '3':
				$starefin = 'In curs de incasare';
				break;
			case '5':
				/* Verify X_STARE_FIN2 status*/
				switch ($rez["X_STARE_FIN2"]){
					case '1':
						$starefin='In curs de creditare';
						break;
					case '2':
						$starefin='Creditata';
						break;
					case '3':
						$starefin='Refuz la plata';
						break;
					case '4':
						$starefin='Incasata';
						break;
				}
				break;
			case '6':
				$starefin= 'In curs de anulare';
				break;
			case '7':
				$starefin='Anulata';
				break;
			case '9':
				$starefin='Expirata 30 zile';
				break;
			case '10':
				$starefin='Eroare';
				break;
			case '1':
				$starefin='In curs de autorizare';
				break;
			default:
				$stare1='<f_response_code>0</f_response_code>';			
		}


/* trimit raspuns */		
	$raspuns_xml = '<?xml version="1.0" encoding="UTF-8" ?>';
	$raspuns_xml .= '<itsn>';
	$raspuns_xml .= '<x_trans_id>'.$vX_Trans_ID.'</x_trans_id>';
	$raspuns_xml .= '<merchServerStamp>'.date("Y-m-d H:m:s").'</merchServerStamp>';
	$raspuns_xml .= $stare1;
	$raspuns_xml .= '</itsn>';

	echo $raspuns_xml;
	die();
}
if(isset($_GET['crediteuropeipn']) && $_GET['crediteuropeipn'])
{
	$storekey=getUserConfig("crediteurope_storekey");

	$hashparams = $_POST["HASHPARAMS"];
	$hashparamsval = $_POST["HASHPARAMSVAL"];
	$hashparam = $_POST["HASH"];
	$paramsval="";
	$index1=0;
	$index2=0;
	$mdStatus=$_POST['mdStatus'];

	while($index1 < strlen($hashparams))
	{
		$index2 = strpos($hashparams,":",$index1);
		$vl = $_POST[substr($hashparams,$index1,$index2- $index1)];
		if($vl == null)
		$vl = "";
		$paramsval = $paramsval . $vl; 
		$index1 = $index2 + 1;
	}
	$hashval = $paramsval.$storekey;

	$hash = base64_encode(pack('H*',sha1($hashval)));
	$offid=intval($_POST['oid']);
	if ($hashparams != null)
	{
		if($paramsval != $hashparamsval || $hashparam != $hash)
		{
			header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=Security warning. Hash values mismatch.");
		}
		else
		{
			if($mdStatus =="1" || $mdStatus == "2" || $mdStatus == "3" || $mdStatus == "4")
			{
				//ok
				require_once("extensions/process_offer_ws.php");
				$offid=intval($_POST['oid']);
				if(intval($offid))
				{
					//force approved
					$_POST['offid']=intval($offid);
					$_POST['ipnmessage']="Approved";
					$_POST['ipnamount']=$_POST['amount'];
					$_POST['ipnrrn']=$_POST["TransId"];
					$_POST['ipnref']=$_POST["TransId"];
					$off=ws_process('DateOferta');
					if($off===false)
					{
						header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=O eroare neastepta nu permite inreg platii. Va rugam sa incercati mai tarziu sau sa ne contactati. Un operator va face verificarile necesare.");
					}
					else
					{
						if($_POST['Response']=="Approved")
						{
							header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=thankyou&offid=".$offid);
						}
						else
						{
							header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=".$_POST['Responde']);
						}
					}
				}
			}
			else
			{
				header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=3D authentication unsuccesful");
			}
		}
	}
	else
	{
		header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=Hash values error. Please check parameters posted to 3D secure page");
	}
	die();
}
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
		'TERMINAL' => getUserConfig("uni_merch_terminal"),
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
	$p_sign_calculat = strtoupper(unicredit_mac($dataAll,getUserConfig("uni_merch_key")));
	if($_GET['TRTYPE']=="21" || $_GET['TRTYPE']=="24")
	{
		header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=".$_GET['MESSAGE']);
		die();
	}

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
					header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error="."O eroare neastepta nu permite inreg platii. Va rugam sa incercati mai tarziu sau sa ne contactati. Un operator va face verificarile necesare.");
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
			header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=".$_GET['MESSAGE']);
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
	if(isset($_GET['message']))
		$_POST=array_merge($_POST,$_GET);
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
		if(true || $zcrsp['action']=="0")
		{
			require_once("extensions/process_offer_ws.php");
			$offid=intval($_POST['invoice_id']);
			if(intval($offid))
			{
				//force approved
				$_POST['offid']=intval($offid);
				$_POST['ipnmessage']=$_POST['message'];
				$_POST['ipnamount']=$_POST["amount"];
				$_POST['ipnrrn']=$_POST["ep_id"];
				$_POST['ipnref']=$_POST["ep_id"];
				$off=ws_process('DateOferta');
				if($_GET['euplatescipn_post']==true)
				{
					echo "ok";
					die();
				}
				if($off===false)
				{
					echo "O eroare neastepta nu permite inreg platii. Va rugam sa incercati mai tarziu sau sa ne contactati. Un operator va face verificarile necesare.";
				}
				else
				{
					if($_GET['euplatescipn_post']==true)
					{
						echo "ok";
						die();
					}
					if($_POST['message']=="Approved")
					{
						header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=thankyou&offid=".$offid);
					}
					else
					{
						header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=".$_POST['message']);
					}
				}
			}
		}
		else {
			if($_GET['euplatescipn_post']==true)
			{
				echo "ok";
				die();
			}
			//echo "O eroare neastepta nu permite inreg platii ".$zcrsp['message'];
			header("Location: ".getUserConfig('ws_merch_kiturl')."site.php?t=error&offid=".$offid."&error=".$_POST['message']);
		}
	// end facem update in baza de date
	}
	else {
		echo "Nu am putut calcula ultima zecimala a lui PI.";
	}
	echo "ok";
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
<textarea>location.href='site.php?t=unicredit&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?><?php if($_GET['aproba']=="yes") echo '&aproba=yes';?><?php if($_GET['anulare']=="yes") echo '&anulare=yes';?>';</textarea>
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
			case 'crediteurope':
	?>
<textarea>location.href='site.php?t=crediteurope&offid=<?php echo intval($_POST['offid']);?>&pret=<?php echo floatval(number_format(getNumberFromPost($_POST['tarif'],2),2,'.',''));?>';</textarea>
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

	if($off['ipnrrn']['VALUE']!="")
	{
		$dataAll = array(
			'ORDER'  => str_pad(intval($_GET['offid']),6,'0',STR_PAD_LEFT),
			'AMOUNT'      => number_format(getNumberFromPost($_GET['pret'],2),2,'.',''),
			'CURRENCY'        => 'RON',
			'RRN'  => $off['ipnrrn']['VALUE'],
			'INT_REF'  => $off['ipnref']['VALUE'],
			"TRTYPE" => ($_GET['anulare']=="yes"?'24':'21'),
			'TERMINAL' => getUserConfig("uni_merch_terminal"),
			'TIMESTAMP'   => gmdate("YmdHis"),
			'NONCE'       => md5(microtime() . mt_rand()),
			'BACKREF'       => getUserConfig("uni_merch_backurl"),
		); 
	}
	else
	{
		$dataAll = array(
			'AMOUNT'      => number_format(getNumberFromPost($_GET['pret'],2),2,'.',''),
			'CURRENCY'        => 'RON',
			'ORDER'  => str_pad(intval($_GET['offid']),6,'0',STR_PAD_LEFT),
			'DESC'  => 'Plata decont prima conform oferta '. intval($_GET['offid']),
			'MERCH_NAME'    => getUserConfig("uni_merch_name"),
			'MERCH_URL'    => getUserConfig("uni_merch_url"),
			'MERCHANT'    => getUserConfig("uni_merchant"),
			'TERMINAL' => getUserConfig("uni_merch_terminal"),
			"EMAIL" => getUserConfig("uni_merch_email"),
			"TRTYPE" => ($_GET['aproba']=="yes"?'21':($_GET['anulare']=="yes"?'24':'0')),
			"COUNTRY" => '',
			"MERCH_GMT" => '',
			'TIMESTAMP'   => gmdate("YmdHis"),
			'NONCE'       => md5(microtime() . mt_rand()),
			'BACKREF'       => getUserConfig("uni_merch_backurl"),
		); 
		if(intval($off['uni_rate'])>1)
		{
			$dataAll['RAMBURSARE']=intval($off['uni_rate']);
		}
	}

	$p_sign = strtoupper(unicredit_mac($dataAll,getUserConfig("uni_merch_key")));

?>

<form ACTION="<?php echo getUserConfig("uni_merch_action");?>" METHOD="POST" name="gateway"  target="_parent">

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
if($_GET['t']=="plationline")
{
	require_once("extern/clspo.php");
	$my_class = new PO3();

	$my_class->LoginID = $lid;
	$my_class->KeyEnc = $ke;
	$my_class->KeyMod = $km;

	$my_class->amount = "1.00";
	$my_class->currency = "RON";
	$my_class->OrderNumber = "1";
	$my_class->action = "2";
	$ret = $my_class->InsertHash_Auth();

	$_CONFIG['plationline']="yes";
$_CONFIG['plationline_loginid']="44840979095";
$_CONFIG['plationline_key']="C4B43BB7B7627F93DB0A89CF69D053CA7D16D03D";
$_CONFIG['plationline_mod']="C4B43BB7B7627F93DB0A89CF69D053CA7D16D03D";
$_CONFIG['']="yes";
$_CONFIG['plationline_ratebt']="yes";

	
	//Pt. Rate RZB
	if(getUserConfig("plationline_raterz")=="yes")
	{
		$my_class->rate = "6";
		$my_class->action = "10";
		$ret = $my_class->InsertHash_AuthRate_RZB();
	}

	//Pt. Rate BT
	if(getUserConfig("plationline_ratebt")=="yes")
	{
		$my_class->rate = "6";
		$my_class->action = "16";
		$ret = $my_class->InsertHash_AuthRate_RZB();
	}

	$vOrderString= "<start_string>"; 
	$vOrderString.= "<item>";
	$vOrderString.= "<ProdID>1</ProdID>";
	$vOrderString.= "<qty>1</qty>";
	$vOrderString.= "<itemprice>0.81</itemprice>";
	$vOrderString.= "<name>Produs de test 1</name>";
	$vOrderString.= "<period></period><rec_id>0</rec_id>";
	$vOrderString.= "<description>Descriere produs</description>";
	$vOrderString.= "<pimg></pimg><rec_price>0</rec_price>";
	$vOrderString.= "<vat>0.19</vat>";
	$vOrderString.= "<lang_id></lang_id><stamp>".htmlspecialchars(date("F j, Y, g:i a")). "</stamp><on_stoc>1</on_stoc>";
	$vOrderString.= "<prodtype_id></prodtype_id><categ_id>0</categ_id><merchLoginID>0</merchLoginID>";
	$vOrderString.= "</item>";

	//cupon
	//$vOrderString .= "<coupon><key>cod</key><value>".abs(round(0.05,2))."</value><percent>1</percent><workingname>Nume cupon</workingname><type>0</type><scop>0</scop><vat>0</vat></coupon>";

	//shipping
	$vOrderString .= "<shipping><type>Denumire shipping</type><price>1.00</price><pimg></pimg><vat>0</vat></shipping>";
	$vOrderString .= "</start_string>";

?>

	<form id="registerForm" autocomplete="off" method="post" action="https://secure2.plationline.ro/">
		<?php echo $ret;?>
		<input type="hidden" name="f_login" value="<?php echo $my_class->LoginID;?>">
		<input type="hidden" name="f_show_form" value="1">
		<input type="hidden" name="f_amount" value="<?php echo $my_class->amount;?>">
		<input type="hidden" name="f_currency" value="<?php echo $my_class->currency;?>">
		<input type="hidden" name="f_order_number" value="<?php echo $my_class->OrderNumber;?>">
		<input type="hidden" name="F_Language" value="ro" >
		<input type="hidden" name="F_Lang" value="ro">
		<input type="hidden" name="f_order_string" value="<?php echo $vOrderString ?>">
		<input type="hidden" name="f_first_name" id="f_first_name" value="Prenume">
		<input type="hidden" name="f_last_name" id="f_last_name" value="Nume">
		<input type="hidden" name="f_cnp" value="-">
		<input type="hidden" name="f_address" id="f_address" value="Adresa facturare">
		<input type="hidden" name="f_city" id="f_city" value="Bucuresti">
		<input type="hidden" name="f_state" id="f_state" value="Bucuresti">
		<input type="hidden" name="f_zip" id="f_zip" value="800000">
		<input type="hidden" name="f_country" id="f_country" value="RO">
		<input type="hidden" name="f_phone" id="f_phone" value="0700000000">
		<input type="hidden" name="f_email" id="f_email" value="adrian@plationline.eu">
		<input type="hidden" name="f_company" value="-">
		<input type="hidden" name="f_reg_com" value="-">
		<input type="hidden" name="f_cui" value="-">
		<input type="hidden" name="f_ship_to_first_name" value="Prenume livrare" />
		<input type="hidden" name="f_ship_to_last_name" value="Nume livrare" />
		<input type="hidden" name="f_ship_to_phone" value="0700000001" />
		<input type="hidden" name="f_ship_to_address" value="Adresa livrare" />
		<input type="hidden" name="f_ship_to_city" value="Bucuresti" />
		<input type="hidden" name="f_ship_to_state" value="Bucuresti" />
		<input type="hidden" name="f_ship_to_zipcode" value="800001" />
		<input type="hidden" name="f_ship_to_country" value="RO" />

<!-- daca e test mode START here -->
		<input type="hidden" name="f_Test_Request" value="1">
<!-- daca e test mode END here -->
		<input type="submit" value="Plateste" />
	</form>
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

<form ACTION="https://secure.euplatesc.ro/tdsprocess/tranzactd.php" METHOD="POST" name="gateway"  target="_parent">

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

<input type="hidden" name="ExtraData[rate]" value="<?php echo $off['optrate']['VALUE']?>">

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
if($_GET['t']=="crediteurope")
{
	$amount=getNumberFromPost($_GET['pret'],2);
	$transactionType="Auth";
	$rnd=microtime();
	$oid=intval($_GET['offid']);
	$instalment="";
	//get offer info
	 if(intval($off['ce_rate']['VALUE'])>1)
	 	$instalment=intval($off['ce_rate']['VALUE']);
	require_once("extensions/process_offer_ws.php");
	$off=ws_process("InfoOferta",$oid);

	$currencyVal = getUserConfig('crediteurope_currency');

	$hashstr = getUserConfig("crediteurope_clientid") . $oid . $amount . $_CONFIG['crediteurope_ipn'] . $_CONFIG['crediteurope_ipn'] .$transactionType. $instalment .$rnd . getUserConfig('crediteurope_storekey');

	$hash = base64_encode(pack('H*',sha1($hashstr)));

	//prod https://paysafe.crediteurope.ro/fim/est3Dgate
	//test https://testsanalpos.est.com.tr/servlet/est3Dgate
	?><html><body onload="document.forms[0].submit();">
	<form method="post" action="https://paysafe.crediteurope.ro/fim/est3Dgate" target="_parent">
	<input type="hidden" name="clientid" value="<?php echo getUserConfig("crediteurope_clientid");?>" />
	<input type="hidden" name="amount" value="<?php echo $amount; ?>" />
	<input type="hidden" name="islemtipi" value="<?php echo $transactionType; ?>" />
	<input type="hidden" name="taksit" value="<?php echo $instalment; ?>" />
	<input type="hidden" name="oid" value="<?php echo $oid; ?>" />
	<input type="hidden" name="okUrl" value="<?php echo getUserConfig('crediteurope_ipn'); ?>" />
	<input type="hidden" name="failUrl" value="<?php echo getUserConfig('crediteurope_ipn'); ?>" />
	<input type="hidden" name="rnd" value="<?php echo $rnd; ?>" />
	<input type="hidden" name="hash" value="<?php echo $hash; ?>" />
	<input type="hidden" name="storetype" value="<?php echo getUserConfig("crediteurope_type");?>" />
	<input type="hidden" name="lang" value="ro" />
	<input type="hidden" name="currency" value="<?php echo $currencyVal; ?>" />
	<input type="hidden" name="refreshtime" value="10" />
	<input type="hidden" name="BillToName" value="<?php echo $off['nume']['VALUE'].' '.$off['prenume']['VALUE'];?>">
	<input type="hidden" name="BillToAddress1" value="<?php echo $off['adresa']['VALUE'].', '.$off['localitate']['VALUE'].', jud. '.$off['judet']['VALUE'];?>">
	<input type="hidden" name="encoding" value="UTF-8">
	</form>

	</body></html><?php
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
	<form name="frmPaymentRedirect" method="post" action="<?php echo $paymentUrl;?>"  target="_parent">
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
if($_GET['t']=="oferta")
{
	//call ws
	require_once("extensions/process_offer_ws.php");
	$off=ws_process('OfertaPDF');

	//return a PDF from ws
	if($off!='')
	{
		header("Content-type: application/pdf");
		header("Content-length: ".strlen($off));
		echo $off;
	}
	else
	{
		echo "Oferta PDF nu a putut fi gasita. Un operator o va trimite pe mail sau o sa fiti contactat.";
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
if(getUserConfig("datepicker")=="pick")
{
?>
<script src="js/pickadate/picker.js"></script>
<script src="js/pickadate/picker.date.js"></script>
<script src="js/pickadate/legacy.js"></script>
<link rel="stylesheet" href="js/pickadate/themes/default.css" id="theme_base">
<link rel="stylesheet" href="js/pickadate/themes/default.date.css" id="theme_date">
<?php
}

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
<?php if(isset($_GET['affiliateid'])) {?>
<input type="hidden" name="affiliateid" value="<?php echo str_replace(" ","",$_GET['affiliateid']);?>">
<?php } ?>
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
case 'petitie':
	include("extensions/info_tarifar_petitie.php");
break;
case 'contact':
	include("extensions/info_tarifar_contact.php");
break;
case 'sanatate':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_sanatate_tarife.php");
	else
		include("extensions/info_tarifar_sanatate.php");
break;
case 'malpraxis':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_sanatate_tarife.php");
	else
		include("extensions/info_tarifar_malpraxis.php");
break;
case 'rotr':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_sanatate_tarife.php");
	else
		include("extensions/info_tarifar_rotr.php");
break;
case 'rezervare':
	if(isset($_GET['offid']) && intval($_GET['offid'])>0)
		include("extensions/info_tarifar_rezervare_tarife.php");
	else
		include("extensions/info_tarifar_rezervare.php");
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
</script>
<div id="notificare_plecare"><?php echo getUserConfig("notificare_plecare");?></div>
<?php
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
<div class="sidebarbutton sidebarbutton_sanatate"><a href="site.php?t=sanatate" class="sidebarlink">SANATATE</a></div>
<div class="sidebarbutton sidebarbutton_malpraxis"><a href="site.php?t=malpraxis" class="sidebarlink">MALPRAXIS</a></div>
<div class="sidebarbutton sidebarbutton_rotr"><a href="site.php?t=rotr" class="sidebarlink">ROTR/CMR</a></div>
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
