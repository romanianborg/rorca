<?php

class PO3{

	public  $KeyEnc=null;
	public  $KeyMod=null;
	public  $LoginID=null;
	public  $amount=null;
	public  $currency=null;
	public  $OrderNumber=null;
	public  $action=null;
	public  $TransID=null;
	public  $shipping="-";
	public  $awb="-";
	public  $ret;
	public  $version="3.0.3";
	public	$msg;
	public	$sEncoded;
	public  $rates;
	//public  $url= "https://secure2.plationline.ro/relay_response.asp";
	public  $url= "https://secure2.plationline.ro/trans30.asp";
	public  $return_url = "";


	var $strMult;
	var $sTemp;
	var $sAsci;
	var $iAsci;
	var $decSt;

	var $rep;
	var $hex;
	var $tot;
	var $encSt;
	

	function PO3(){
		$this->version="3.0.3";
	}

	function Mult($x){
		$y=1;
		$pg=$this->KeyEnc;
		$m=$this->KeyMod;
		while ($pg > 0){
			while (($pg / 2)==intval($pg / 2)){
				$x=$this->nMod(($x*$x),$m);
				$pg=$pg / 2;			
			}
			$y=$this->nMod(($x*$y),$m);
			$pg=$pg-1;
		}
		return ($y);
	}

	function nMod($x,$y){
		$bInt=0;
		if($y==0){
			return;
		};
		$bInt=$x-(intval($x/$y)*$y);	
		return($bInt);
	}

	////////////////// GCEncode/////////////////////////
	//metoda de codificare pe baza cheilor
	////////////////////////////////////////////////////
	function GCEncode($tIp){
		$this->encSt ="";
		for($z=0;$z < strlen($tIp);$z++){
			$this->sTemp = substr($tIp,$z,1);
			$this->sAsci = ord($this->sTemp);
			$this->iAsci = intval($this->sAsci);			
			$this->encSt=$this->encSt.$this->NumberToHex($this->Mult($this->iAsci),8);
		}
		return strtoupper($this->encSt);
	}


	////////////////// NumberToHex////////////////////////////
	//metoda de conversie a unui numar din zecimal in hexa 
	//////////////////////////////////////////////////////////
	function NumberToHex($pLngNumber,$pLngLength){
		$this->rep = str_repeat("0",$pLngLength);	
		$this->hex = dechex($pLngNumber);
		$this->tot = $this->rep.$this->hex;	
		return(substr($this->tot,strlen($this->tot) - $pLngLength,strlen($this->tot)));
	}


	////////////////// HexToNumber/////////////////////////
	//metoda de conversie a unui numar hexa in zecimal
	///////////////////////////////////////////////////////
	function HexToNumber($pStrHex){
		$this->ret = intval(hexdec("&h".$pStrHex));	
		return($this->ret);
	}

	/////////////////// hex2str/////////////////////////
	//metoda de conversie a unui numar hexa in string
	////////////////////////////////////////////////////
	function hex2str($hex){
		$str="";
		for($i=0;$i<strlen($hex);$i+=2){
			$str.=chr(hexdec(substr($hex,$i,2)));
		}
		return $str;
	}


	//key is a hexadecimal number
	////////////////// POEncode/////////////////////////
	//metoda de codificare pe baza cheilor
	////////////////////////////////////////////////////
	function POEncode($key, $data) {
		$key=$this->hex2str($key);
		$blocksize=64;
		$hashfunc='sha1';
		if (strlen($key)>$blocksize)
		$key=pack('H*', $hashfunc($key));
		$key=str_pad($key, $blocksize, chr(0x00));
		$ipad=str_repeat(chr(0x36),$blocksize);
		$opad=str_repeat(chr(0x5c),$blocksize);
		$hmac = pack(
			'H*',$hashfunc(
				($key^$opad).pack(
					'H*',$hashfunc(
						($key^$ipad).$data
					)
				)
			)
		);
		return bin2hex($hmac);
	}

	////////////////// InsertHash /////////////////////////
	//metoda de codificare a mesajului - Cerere de Autorizare card
	////////////////////////////////////////////////////
	public function InsertHash_Auth(){
		$sequence = rand(1, 1000);
		$tstamp = date("m")."/".date("d")."/".date("Y")." ".date("h:i:s a");                         
		$msg = $sequence."^".$this->LoginID."^".$tstamp."^".$this->amount."^".$this->currency."^".$this->OrderNumber."^".$this->action;
		$stringRSA=$this->GCEncode(strval($msg));
		$cheie = strval($this->KeyEnc).strval($this->KeyMod);
		$sEncoded= $this->POEncode($cheie, $stringRSA);
		$ret='';
		$ret.= "<input type = hidden name = \"f_message\" value=\"".$msg."\">";
		$ret.= "<input type = hidden name = \"f_crypt_message\" value=\"".$sEncoded."\">";
		$ret.= "<input type = hidden name = \"f_action\" value = \"".$this->action."\" >";
		return $ret;
	}

	////////////////// InsertHash /////////////////////////
	//metoda de codificare a mesajului - Cerere de Autorizare card RZB
	////////////////////////////////////////////////////
	public function InsertHash_AuthRate_RZB(){
		$sequence = rand(1, 1000);
		$tstamp = date("m")."/".date("d")."/".date("Y")." ".date("h:i:s a");                         
		$msg = $sequence."^".$this->LoginID."^".$tstamp."^".$this->amount."^".$this->currency."^".$this->OrderNumber."^".$this->action."^".$this->rates;
		$stringRSA=$this->GCEncode(strval($msg));
		$cheie = strval($this->KeyEnc).strval($this->KeyMod);
		$sEncoded= $this->POEncode($cheie, $stringRSA);
		$ret='';
		$ret.= "<input type = hidden name = \"f_message\" value=\"".$msg."\">";
		$ret.= "<input type = hidden name = \"f_crypt_message\" value=\"".$sEncoded."\">";
		$ret.= "<input type = hidden name = \"f_action\" value = \"".$this->action."\" >";
		return $ret;
	}

	////////////////// InsertHash_Interog/////////////////////////
	//metoda de interogare
	////////////////////////////////////////////////////////////////
	public function InsertHash_Interog(){
		global $mesajeEroare;
		$sequence = rand(1, 1000);
		$tstamp = date("m")."/".date("d")."/".date("Y")." ".date("h:i:s a");                         
		$this->msg = $sequence."^".$this->LoginID."^".$tstamp."^".$this->TransID."^".$this->OrderNumber."^".$this->action;
		$stringRSA=$this->GCEncode(strval($this->msg));
		$cheie = strval($this->KeyEnc).strval($this->KeyMod);
		$this->sEncoded= $this->POEncode($cheie, $stringRSA);

		$ret = 	"F_Login="				. urlencode($this->LoginID)
				. "&f_message="			. urlencode($this->msg)
				. "&f_crypt_message="	. urlencode($this->sEncoded)
				. "&f_action="			. urlencode($this->action)
				. "&f_order_number="	. urlencode($this->OrderNumber)
				. "&x_trans_id=" 		. urlencode($this->TransID)
				. "&f_xml=0"
				;

		if (isset($this->LoginID) && !empty($this->LoginID))
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->LoginID</strong>: <br />' . $this->LoginID . '</p>';
		if (isset($this->url) && !empty($this->url)) {
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->url</strong>: <br />' . $this->url . '</p>';
		}
		if (isset($ret) && !empty($ret))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - ret</strong>: <br />' . $ret . '</p>';

		$result = $this->POCommunication($this->url, $ret);
		parse_str($result, $arrayRezultat);

		if (isset($result) && !empty($result))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - result</strong>: <br />' . $result . '</p>';
		if (isset($arrayRezultat) && !is_array($arrayRezultat) && count($arrayRezultat) > 0)
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - parse_str(result)</strong>: <br />' . parse_str($result) . '</p>';

		return $arrayRezultat;
	}


	////////////////// InsertHash_Incasare/////////////////////////
	//metoda Cerere de incasare
	////////////////////////////////////////////////////////////////
	public function InsertHash_Incasare(){
		global $mesajeEroare;
		$sequence = rand(1, 1000);
		$tstamp = date("m")."/".date("d")."/".date("Y")." ".date("h:i:s a");                         
		$msg = $sequence."^".$this->LoginID."^".$tstamp."^".$this->TransID."^".$this->OrderNumber."^".$this->awb."^".$this->shipping."^".$this->action;
		$stringRSA=$this->GCEncode(strval($msg));
		$cheie = strval($this->KeyEnc).strval($this->KeyMod);
		$sEncoded= $this->POEncode($cheie, $stringRSA);

		$ret = 	"F_Login="				. urlencode($this->LoginID)
				. "&f_message="			. urlencode($msg)
				. "&f_crypt_message="	. urlencode($sEncoded)
				. "&f_action="			. urlencode($this->action)
				. "&x_trans_id=" 		. urlencode($this->TransID)
				. "&f_order_number="	. urlencode($this->OrderNumber)
				. "&f_awb="				. urlencode($this->awb)				
				. "&F_Shipping_Company=". urlencode($this->shipping)
				. "&f_xml=0"
				;

		if (isset($this->LoginID) && !empty($this->LoginID))
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->LoginID</strong>: <br />' . $this->LoginID . '</p>';
		if (isset($this->url) && !empty($this->url)) {
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->url</strong>: <br />' . $this->url . '</p>';
		}
		if (isset($ret) && !empty($ret))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - ret</strong>: <br />' . $ret . '</p>';

		$result = $this->POCommunication($this->url, $ret);
		parse_str($result, $arrayRezultat);

		if (isset($result) && !empty($result))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - result</strong>: <br />' . $result . '</p>';
		if (isset($arrayRezultat) && !is_array($arrayRezultat) && count($arrayRezultat) > 0)
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - parse_str(result)</strong>: <br />' . parse_str($result) . '</p>';


		return $arrayRezultat;
	}


	////////////////// InsertHash_Void//////////////////////////////
	//metoda de anulare
	////////////////////////////////////////////////////////////////
	public function InsertHash_Void(){
		global $mesajeEroare;
		$sequence = rand(1, 1000);
		$tstamp = date("m")."/".date("d")."/".date("Y")." ".date("h:i:s a");                         
		$msg = $sequence."^".$this->LoginID."^".$tstamp."^".$this->TransID."^".$this->OrderNumber."^".$this->action;
		$stringRSA=$this->GCEncode(strval($msg));
		$cheie = strval($this->KeyEnc).strval($this->KeyMod);
		$sEncoded= $this->POEncode($cheie, $stringRSA);

		$ret = 	"F_Login="				. urlencode($this->LoginID)
				. "&f_message="			. urlencode($msg)
				. "&f_crypt_message="	. urlencode($sEncoded)
				. "&f_action="			. urlencode($this->action)
				. "&x_trans_id=" 		. urlencode($this->TransID)
				. "&f_order_number="	. urlencode($this->OrderNumber)
				. "&f_awb="				. urlencode($this->awb)				
				. "&F_Shipping_Company=". urlencode($this->shipping)
				. "&f_xml=0"
				;

		if (isset($this->LoginID) && !empty($this->LoginID))
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->LoginID</strong>: <br />' . $this->LoginID . '</p>';
		if (isset($this->url) && !empty($this->url)) {
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->url</strong>: <br />' . $this->url . '</p>';
		}
		if (isset($ret) && !empty($ret))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - ret</strong>: <br />' . $ret . '</p>';

		$result = $this->POCommunication($this->url, $ret);
		parse_str($result, $arrayRezultat);

		if (isset($result) && !empty($result))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - result</strong>: <br />' . $result . '</p>';
		if (isset($arrayRezultat) && !is_array($arrayRezultat) && count($arrayRezultat) > 0)
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - parse_str(result)</strong>: <br />' . parse_str($result) . '</p>';

		return $arrayRezultat;
	}


	////////////////// InsertHash_Credit/////////////////////////
	//metoda de creditare
	////////////////////////////////////////////////////////////////
	public function InsertHash_Credit(){
		global $mesajeEroare;
		$sequence = rand(1, 1000);
		$tstamp = date("m")."/".date("d")."/".date("Y")." ".date("h:i:s a");                         
		$msg = $sequence."^".$this->LoginID."^".$tstamp."^".$this->TransID."^".$this->OrderNumber."^".$this->amount."^".$this->action;
		$stringRSA=$this->GCEncode(strval($msg));
		$cheie = strval($this->KeyEnc).strval($this->KeyMod);
		$sEncoded= $this->POEncode($cheie, $stringRSA);
		$ret = 	"f_login=" 			. urlencode($this->LoginID)
				. "&f_message="			. urlencode($msg)
				. "&f_crypt_message="	. urlencode($sEncoded)
				. "&x_trans_id=" 		. urlencode($this->TransID)
				. "&f_order_number="	. urlencode($this->OrderNumber)
				. "&f_amount="			. urlencode($this->amount)
				. "&f_action="			. urlencode($this->action)
				. "&f_xml=0"	
				;

		if (isset($this->LoginID) && !empty($this->LoginID))
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->LoginID</strong>: <br />' . $this->LoginID . '</p>';
		if (isset($this->url) && !empty($this->url)) {
			$mesajeEroare .= '<p class="mesaj-ok"><strong>clspo.php - this->url</strong>: <br />' . $this->url . '</p>';
		}
		if (isset($ret) && !empty($ret))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - ret</strong>: <br />' . $ret . '</p>';

		$result = $this->POCommunication($this->url, $ret);
		parse_str($result, $arrayRezultat);

		if (isset($result) && !empty($result))
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - result</strong>: <br />' . $result . '</p>';
		if (isset($arrayRezultat) && !is_array($arrayRezultat) && count($arrayRezultat) > 0)
			$mesajeEroare .= '<p class="eroare"><strong>clspo.php - parse_str(result)</strong>: <br />' . parse_str($result) . '</p>';

		return $arrayRezultat;
	}


	public function VerifyFRM($msg){
		$stringRSA=$this->GCEncode(strval($msg));
		$cheie = strval($this->KeyEnc).strval($this->KeyMod);
		$sEncoded=$this->POEncode($cheie, $stringRSA);
		return $sEncoded;
	}


	function POCommunication( $url, $postData='') {
		global $mesajeEroare;

		$urlParts = parse_url( $url );
		if( !isset( $urlParts['port'] )) $urlParts['port'] = 80;
		if( !isset( $urlParts['scheme'] )) $urlParts['scheme'] = 'http';
		if( isset( $urlParts['query'] )) $urlParts['query'] = '?'.$urlParts['query'];

		$proxyURL = '';

		if( function_exists( "curl_init" ) && function_exists( 'curl_exec' ) ) {

			$CR = curl_init();
			curl_setopt($CR, CURLOPT_URL, $url);

			curl_setopt($CR, CURLOPT_TIMEOUT, 30 );
			curl_setopt($CR, CURLOPT_FAILONERROR, true);
			if( $postData ) {
				curl_setopt($CR, CURLOPT_POSTFIELDS, $postData );
				curl_setopt($CR, CURLOPT_POST, 1);
			}
			curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);


			if( $urlParts['scheme'] == 'https') {
				curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
			}
			$result = curl_exec( $CR );
			//echo 'result: <pre>'; var_dump($result); echo '</pre><br />';
			$error = curl_error( $CR );
			curl_close( $CR );

			if( !empty( $error )) {
				$mesajeEroare .= '<p class="eroare"><strong>clspo.php - error</strong>: <br />' . $error . '</p>';
				$mesajeEroare .= '<p class="eroare"><strong>clspo.php - result</strong>: <br />' . $result . '</p>';
				$mesajeEroare .= '<p class="eroare"><strong>clspo.php - url</strong>: <br />' . $url . '</p>';
				$mesajeEroare .= '<p class="eroare"><strong>clspo.php - postData</strong>: <br />' . $postData . '</p>';
				return false;
			} else {
				return $result;
			}
		} else {
			echo "No CURL";
		}
	}
}
?>
