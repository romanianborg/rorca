<?php
/**
 * LIBRAPAY
 *
 * @Libra Bank SA - 2011
 * librapay@librabank.ro
 *
 * handler procesare plati online 3DSecure cu cardul
 *
*/
class Payment {	
	var $amount = "0.00"; // totalul comenzii
	var $currency = "RON"; 
	var $order = ""; // order_id unic (6-19 caractere numerice) !!!
	var $desc = "";
	var $trtype = 0;
	var $country = "-";
	var $merch_gmt = "-";
	var $backref = "";
	var $merch_name = ''; //TBD - date comerciant din fisa inrolare
	var $merch_url = ''; //TBD - date site din fisa inrolare
	var $merchant = ''; // Valoare asignata de catre banca. Se compune din: 0000000+TERMINAL
	var $terminal = ''; // TBD - from LIBRA
	var $email = ''; // TDB - from MERCHANT
	var $key = ''; // TBD - from LIBRA
	var $postAction = '';

	var $hex_key = ""; // se va calcula
	var $psign = ""; // se va calcula
	var $string = ""; // se va calcula
	var $form = ""; // se va afisa in front

	var $trimite = '<input type="submit" name="trimite" value="Plateste" />';
	var $userId = -1;
	var $dataProducts = array(); // produsele din comanda - se va completa

	function Payment(){
		$this->backref = getUserConfig("ws_merch_backurl"); // TDB - from MERCHANT
	}

	function getString($type="preAuthPost"){
		 switch ($type){
			 case 'preAuthPost':
				$this->string = strlen($this->amount).$this->amount .
					strlen($this->currency).$this->currency . strlen($this->order).$this->order .
					strlen($this->desc).$this->desc . strlen($this->merch_name).$this->merch_name .
					strlen($this->merch_url).$this->merch_url . strlen($this->merchant).$this->merchant .
					strlen($this->terminal).$this->terminal . strlen($this->email).$this->email .
					strlen($this->trtype).$this->trtype . $this->country .
					 $this->merch_gmt . strlen($this->timestamp).$this->timestamp .
					strlen($this->nonce).$this->nonce . strlen($this->backref).$this->backref;
					//echo $this->string;die();
			break;
			case 'preAuthResponse':
				if(trim($this->approval) == '') {
					$txt_approval = "-";
				} else {
					$txt_approval = strlen($this->approval).$this->approval;
				}
				if(trim($this->rrn) == '') {
					$txt_rrn = "-";
				} else {
					$txt_rrn = strlen($this->rrn).$this->rrn;
				}
				if(trim($this->int_ref) == '') {
					$txt_int_ref = "-";
				} else {
					$txt_int_ref = strlen($this->int_ref).$this->int_ref;
				}
				$this->string = strlen($this->terminal).$this->terminal .
				strlen($this->trtype).$this->trtype . strlen($this->order).$this->order .
				strlen($this->amount).$this->amount .strlen($this->currency).$this->currency .
				strlen($this->desc).$this->desc .strlen($this->action).$this->action .
				strlen($this->rc).$this->rc .strlen($this->message).$this->message .
				$txt_rrn .$txt_int_ref .
				$txt_approval .
				strlen($this->timestamp).$this->timestamp .
				strlen($this->nonce).$this->nonce; 
			break;
		 }
	}
	
	function getHexKey() {		
		$this->hex_key = pack('H*', $this->key);		
	}
	
	function getPsign() {		
		$this->psign = strtoupper(hash_hmac('sha1', $this->string, $this->hex_key));
	}

	function updateVars() {
		$this->timestamp = gmdate("YmdHis");
		$this->nonce = md5("librapayaction_".rand(99999,9999999));
		$this->getString();
		$this->getHexKey();
		$this->getPsign();
	}
	
	function generateForm($type="pay_auth", $partial=false) {
		switch ($type){
			case "pay_auth":
				$this->updateVars();
				$this->form = '
		<form id="PaymentForm" name="PaymentForm" method="post" action="'. $this->postAction .'" class="freeform autosubmitform">
		<input type="hidden" name="AMOUNT" value="'. $this->amount .'" />
		<input type="hidden" name="CURRENCY" value="'. $this->currency .'" />
		<input type="hidden" name="ORDER" value="'. $this->order .'" />
		<input type="hidden" name="DESC" value="'. $this->desc .'" />
		<input type="hidden" name="TERMINAL" value="'. $this->terminal .'" />
		<input type="hidden" name="TIMESTAMP" value="'. $this->timestamp .'" />
		<input type="hidden" name="NONCE" value="'. $this->nonce .'" />
		<input type="hidden" name="BACKREF" value="'. $this->backref .'" />
		<input type="hidden" name="DATA_CUSTOM" value="'. $this->dataProducts .'" />
		<input type="hidden" name="P_SIGN" value="'. $this->psign .'" />
		'. $this->trimite .'
		</form>
				';
			break;
		}
	}
}
?>
