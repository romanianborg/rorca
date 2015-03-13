<?php
	require_once("extern/gc_xmlparser.php");
	require_once("config/dateutils.php");

	function ws_request($url,$xml,$action)
	{
		$header = array ("Content-Type: text/xml; charset=utf-8" );
		$header [] = 'SOAPAction: "'.$action.'"';
		$header [] = "Content-Length: ".strlen($xml);
		$header [] = 'Connection: close';
		$header [] = 'Cache-Control: no-cache';
		$header [] = 'User-agent: asiguram/tarifar 1.0';
		$header [] = 'Expect:';

		// Set the POST options.
		$session=curl_init();
		curl_setopt($session, CURLOPT_URL, $url);
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_HTTPHEADER, $header);
		curl_setopt($session, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($session, CURLOPT_TIMEOUT, ( int ) 60 );
		curl_setopt($session, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

		// Do the POST and then close the session
		$response = curl_exec($session);
		//echo $response;die();
		if (curl_errno($session)) {
			//echo curl_errno($session);die();
			return false;
		}
		$xml_parser = new gc_xmlparser($response);
		$data = $xml_parser->GetData();
		return $data;
	}
	function sort12luni($a,$b)
	{
		if($a['12']>$b['12']) return 1;
		if($a['12']==$b['12']) return 0;
		return -1;
	}
	function ws_process($action,$para='')
	{
		switch($action)
		{
			case 'AdaugaOferta':
			$tipoferta=$_POST['tipoferta'];
			$xml='<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		 <CredentialHeader xmlns="http://asiguram.ro/ws">
		   <Username>'.getUserConfig("ws_username").'</Username>
		   <Password>'.getUserConfig("ws_parola").'</Password>
		 </CredentialHeader>
	  </soap:Header>
	  <soap:Body>
		 <AdaugaOferta xmlns="http://asiguram.ro/ws">
		   <tipoferta>'.$tipoferta.'</tipoferta>
		   <datavalabilitate>'.getDateForMysql($_POST['datavalabilitate'],getLT('dateformat')).'</datavalabilitate>
		   <tipcontract>'.correctPostValue($_POST['tipproprietar']).'</tipcontract>
		   ';
		  switch($_POST['tipoferta'])
		  {
		  case 'pad':
		  	foreach($_POST as $wk=>$wv)
		  	{
		  		if($wk=="tipoferta" || $wk=="datavalabilitate")
		  		{
		  			continue;
		  		}
		  		else
		  		if($wk=="produsdorit")
		  		{
		  			switch($wv)
		  			{
		  				case 'pad+fac':
		  					$xml.='<emitepad>astrapaid</emitepad>';
		  					$xml.='<emite>bonusold</emite>';
		  				break;
		  				case 'pad':
		  					$xml.='<emitepad>astrapaid</emitepad>';
		  					$xml.='<emite>fara</emite>';
		  				break;
		  				case 'fac':
		  					$xml.='<emitepad>fara</emitepad>';
		  					$xml.='<emite>doarbonus</emite>';
		  				break;
		  			}
					$xml.='<'.$wk.'>'.correctPostValue($_POST[$wk]).'</'.$wk.'>';
		  		}
		  		else
		  		if($wk=="panalavalabilitate")
		  		{
					$xml.='<'.$wk.'>'.getDateForMysql($_POST['panalavalabilitate'],getLT('dateformat')).'</'.$wk.'>';
		  		}
		  		else
		  		{
					$xml.='<'.$wk.'>'.correctPostValue($_POST[$wk]).'</'.$wk.'>';
				}
		  	}
		  break;
		  case 'casco':
		  	foreach($_POST as $wk=>$wv)
		  	{
		  		if($wk=="tipoferta" || $wk=="datavalabilitate")
		  		{
		  			continue;
		  		}
		  		else
		  		if($wk=="panalavalabilitate")
		  		{
					$xml.='<'.$wk.'>'.getDateForMysql($_POST['panalavalabilitate'],getLT('dateformat')).'</'.$wk.'>';
		  		}
		  		else
		  		{
					$xml.='<'.$wk.'>'.correctPostValue($_POST[$wk]).'</'.$wk.'>';
				}
		  	}
		  break;
		  case 'decont':
		  	foreach($_POST as $wk=>$wv)
		  	{
		  		if($wk=="tipoferta" || $wk=="datavalabilitate")
		  		{
		  			continue;
		  		}
		  		else
		  		{
					$xml.='<'.$wk.'>'.correctPostValue($_POST[$wk]).'</'.$wk.'>';
				}
		  	}
		  break;
		  case 'sanatate':
		  case 'malpraxis':
		  case 'rotr':
		  	foreach($_POST as $wk=>$wv)
		  	{
		  		if($wk=="tipoferta" || $wk=="datavalabilitate")
		  		{
		  			continue;
		  		}
		  		else
		  		{
					$xml.='<'.$wk.'>'.correctPostValue($_POST[$wk]).'</'.$wk.'>';
				}
		  	}
		  break;
		  case 'medicale':
		  $xml.='
				<nrzile>'.correctPostValue($_POST['nrzile']).'</nrzile>
				<panalavalabilitate>'.getDateForMysql($_POST['panalavalabilitate'],getLT('dateformat')).'</panalavalabilitate>
				<tipproprietar>'.correctPostValue($_POST['tipproprietar']).'</tipproprietar>
				<pf_tippersoana>'.correctPostValue($_POST['pf_tippersoana']).'</pf_tippersoana>
				<pf_cnp>'.correctPostValue($_POST['pf_cnp']).'</pf_cnp>
				<varsta>'.correctPostValue($_POST['varsta']).'</varsta>
				<pj_tippersoana>'.correctPostValue($_POST['pj_tippersoana']).'</pj_tippersoana>
				<pj_cui>'.correctPostValue($_POST['pj_cui']).'</pj_cui>
				<teritoriu>'.correctPostValue($_POST['teritoriu']).'</teritoriu>
				<scop>'.correctPostValue($_POST['scop']).'</scop>
				<activitate>'.correctPostValue($_POST['activitate']).'</activitate>
				<boli>'.correctPostValue($_POST['boli']).'</boli>
				<grupuri>'.correctPostValue($_POST['grupuri']).'</grupuri>
				<sporturi>'.correctPostValue($_POST['sporturi']).'</sporturi>
				<taridest>'.correctPostValue($_POST['taridest']).'</taridest>
				<taridest2>'.correctPostValue($_POST['taridest2']).'</taridest2>
				<taridest3>'.correctPostValue($_POST['taridest3']).'</taridest3>
				<taritranzit>'.correctPostValue($_POST['taritranzit']).'</taritranzit>
				<acoperire>'.correctPostValue($_POST['acoperire']).'</acoperire>
				<pretcalatorie>'.correctPostValue($_POST['pretcalatorie']).'</pretcalatorie>
				<bagaje>'.correctPostValue($_POST['bagaje']).'</bagaje>
				<storno>'.correctPostValue($_POST['storno']).'</storno>
';
		  break;
		  case 'rezervare':
		  case 'petitie':
		  	foreach($_POST as $wk=>$wv)
		  	{
		  		if($wk=="tipoferta" || $wk=="datavalabilitate"  || $wk=="emailclient")
		  		{
		  			continue;
		  		}
		  		else
		  		{
					$xml.='<'.$wk.'>'.correctPostValue($_POST[$wk]).'</'.$wk.'>';
				}
		  	}
		  break;
		  case 'rca':
		  default:
			switch($_POST['tipproprietar'])
			{
			case 'pf':
		   $xml.='
		   <asigurat>
		     <tippersoana>'.correctPostValue($_POST['pf_tippersoana']).'</tippersoana>
		     <cnpcui>'.correctPostValue($_POST['pf_cnp']).'</cnpcui>
		     <localitate>'.correctPostValue($_POST['pf_localitate']).'</localitate>
		     <judet>'.correctPostValue($_POST['pf_judet']).'</judet>
		     <sector>'.correctPostValue($_POST['pf_sector']).'</sector>
		     <permisan>'.correctPostValue($_POST['pf_permisan']).'</permisan>
		     <permisluna>'.correctPostValue($_POST['pf_permisluna']).'</permisluna>
		     <copii>'.correctPostValue($_POST['pf_copii']).'</copii>
		     <casco>'.correctPostValue($_POST['pf_casco']).'</casco>
		     <destinatie>'.correctPostValue($_POST['pf_destinatie']).'</destinatie>
		   </asigurat>
		   ';
			break;
			case 'pj':
		   $xml.='
		   <asigurat>
		     <tippersoana>'.correctPostValue($_POST['pj_tippersoana']).'</tippersoana>
		     <cnpcui>'.correctPostValue($_POST['pj_cui']).'</cnpcui>
		     <localitate>'.correctPostValue($_POST['pj_localitate']).'</localitate>
		     <judet>'.correctPostValue($_POST['pj_judet']).'</judet>
		     <sector>'.correctPostValue($_POST['pj_sector']).'</sector>
		     <casco>'.correctPostValue($_POST['pj_casco']).'</casco>
		     <rca>'.correctPostValue($_POST['pj_rca']).'</rca>
		     <daune>'.correctPostValue($_POST['pj_daune']).'</daune>
		     <destinatie>'.correctPostValue($_POST['pj_destinatie']).'</destinatie>
		   </asigurat>
		   ';
			break;
			case 'leasing':
		   $xml.='
		   <asigurat>
		     <nume>'.correctPostValue($_POST['leasingname']).'</nume>
		     <cnpcui>'.correctPostValue($_POST['leasingcui']).'</cnpcui>
		     <localitate>'.correctPostValue($_POST['leasinglocalitate']).'</localitate>
		     <judet>'.correctPostValue($_POST['leasingjudet']).'</judet>
		     <sector>'.correctPostValue($_POST['leas_sector']).'</sector>
		   </asigurat>
		   ';
				switch($_POST['tiputilizator'])
				{
					case 'pf':
		   $xml.='
		   <utilizator>
		     <tippersoana>'.correctPostValue($_POST['pf_tippersoana']).'</tippersoana>
		     <cnpcui>'.correctPostValue($_POST['pf_cnp']).'</cnpcui>
		     <localitate>'.correctPostValue($_POST['pf_localitate']).'</localitate>
		     <judet>'.correctPostValue($_POST['pf_judet']).'</judet>
		     <sector>'.correctPostValue($_POST['pf_sector']).'</sector>
		     <permisan>'.correctPostValue($_POST['pf_permisan']).'</permisan>
		     <permisluna>'.correctPostValue($_POST['pf_permisluna']).'</permisluna>
		     <copii>'.correctPostValue($_POST['pf_copii']).'</copii>
		     <casco>'.correctPostValue($_POST['pf_casco']).'</casco>
		     <destinatie>'.correctPostValue($_POST['pf_destinatie']).'</destinatie>
		   </utilizator>
		   ';
					break;
					case 'pj':
		   $xml.='
		   <utilizator>
		     <tippersoana>'.correctPostValue($_POST['pj_tippersoana']).'</tippersoana>
		     <cnpcui>'.correctPostValue($_POST['pj_cui']).'</cnpcui>
		     <localitate>'.correctPostValue($_POST['pj_localitate']).'</localitate>
		     <judet>'.correctPostValue($_POST['pj_judet']).'</judet>
		     <sector>'.correctPostValue($_POST['pj_sector']).'</sector>
		     <casco>'.correctPostValue($_POST['pj_casco']).'</casco>
		     <rca>'.correctPostValue($_POST['pj_rca']).'</rca>
		     <daune>'.correctPostValue($_POST['pj_daune']).'</daune>
		     <destinatie>'.correctPostValue($_POST['pj_destinatie']).'</destinatie>
		   </utilizator>
		   ';
			break;
					break;
				}
			break;
			}

		$codpromo=correctPostValue($_POST['codpromotional']);
		   $xml.='
		   <vehicul>
		     <inmatriculare>'.correctPostValue($_POST['inmatriculare']).'</inmatriculare>
		     <categorie>'.correctPostValue($_POST['categorie']).'</categorie>
		     <marca>'.correctPostValue($_POST['marca']).'</marca>
		     <model>'.correctPostValue($_POST['model']).'</model>
		     <anfabricatie>'.correctPostValue($_POST['anfabricatie']).'</anfabricatie>
		     <nrinm>'.correctPostValue($_POST['nrinm']).'</nrinm>
		     <seriesasiu>'.correctPostValue($_POST['seriesasiu']).'</seriesasiu>
		     <serieciv>'.correctPostValue($_POST['serieciv']).'</serieciv>
		     <cilindree>'.intval($_POST['cilindree']).'</cilindree>
		     <propulsie>'.correctPostValue($_POST['propulsie']).'</propulsie>
		     <cp>'.intval($_POST['cp']).'</cp>
		     <kg>'.intval($_POST['kg']).'</kg>
		     <locuri>'.intval($_POST['locuri']).'</locuri>
		     <parcauto>0</parcauto>
		     <codpromotional>'.$codpromo.'</codpromotional>
		   </vehicul>';
		   break;
		 }
		$xml.='
		<emailclient>'.correctPostValue($_POST['emailclient']).'</emailclient>
		 </AdaugaOferta>
	  </soap:Body>
	</soap:Envelope>';
			//echo $xml;die();
			$data=ws_request(getUserConfig("ws_brokerurl"),$xml,'AdaugaOferta');
			$r=$data['soap:Envelope']['soap:Body'];
			//print_r($r);die();
			if(isset($r['soap:Fault']))
			{
				return false;
			}
			if(isset($r['AdaugaOfertaResponse']['idoferta']))
			{
				if(intval($r['AdaugaOfertaResponse']['idoferta']['VALUE']))
				{
					return intval($r['AdaugaOfertaResponse']['idoferta']['VALUE']);
				}
			}
			return false;
		case 'InfoOferta':
			$xml='<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		 <CredentialHeader xmlns="http://asiguram.ro/ws">
		   <Username>'.getUserConfig("ws_username").'</Username>
		   <Password>'.getUserConfig("ws_parola").'</Password>
		 </CredentialHeader>
	  </soap:Header>
	  <soap:Body>
	 <InfoOferta xmlns="http://asiguram.ro/ws">
		   <idoferta>'.intval($para).'</idoferta>
		 </InfoOferta>
	  </soap:Body>
	</soap:Envelope>';
			$data=ws_request(getUserConfig("ws_brokerurl"),$xml,'InfoOferta');
			$r=$data['soap:Envelope']['soap:Body'];
			//print_r($data);
			if(isset($r['soap:Fault']))
			{
				return false;
			}
			if(isset($r['InfoOfertaResponse']['idoferta']))
			{
				if(intval($r['InfoOfertaResponse']['idoferta']['VALUE']))
				{
					return $r['InfoOfertaResponse'];
				}
			}
			return true;

		case 'PolitaOferta':
			if($action=='PolitaOferta') $_GET['TarifeOferta']=$_GET['PolitaOferta'];
		case 'PDFOferta':
			if($action=='PDFOferta') $_GET['TarifeOferta']=$_GET['offid'];
		case 'TarifeOferta':
			$xml='<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		 <CredentialHeader xmlns="http://asiguram.ro/ws">
		   <Username>'.getUserConfig("ws_username").'</Username>
		   <Password>'.getUserConfig("ws_parola").'</Password>
		 </CredentialHeader>
	  </soap:Header>
	  <soap:Body>
	 <TarifeOferta xmlns="http://asiguram.ro/ws">
		   <idoferta>'.intval($_GET['TarifeOferta']).'</idoferta>
		   '.($action=='PDFOferta'?'<politaPDF>true</politaPDF>':'').'
		 </TarifeOferta>
	  </soap:Body>
	</soap:Envelope>';
			$data=ws_request(getUserConfig("ws_brokerurl"),$xml,'TarifeOferta');
			//print_r($data);die();
			$r=$data['soap:Envelope']['soap:Body'];
			if(isset($r['soap:Fault']))
			{
				return false;
			}
			if(isset($r['TarifeOfertaResponse']['idoferta']))
			{
				$tipoferta=$r['TarifeOfertaResponse']['tipoferta']['VALUE'];
				if(intval($r['TarifeOfertaResponse']['idoferta']['VALUE']))
				{
					if($action=="TarifeOferta")
					{
						$soc=array();
						//check tarifs
						if(isset($r['TarifeOfertaResponse']['tarif']['societate']))
						{
							//we have one
							$v=$r['TarifeOfertaResponse']['tarif'];
							$soc[$v['societate']['VALUE']]=array();
							$soc[$v['societate']['VALUE']]['soc']=$v['societate']['VALUE'];
							$soc[$v['societate']['VALUE']]['6']=floatval($v['tarif6']['VALUE']);
							$soc[$v['societate']['VALUE']]['12']=floatval($v['tarif12']['VALUE']);
							$soc[$v['societate']['VALUE']]['1']=floatval($v['tarif1']['VALUE']);
							$soc[$v['societate']['VALUE']]['bm']=floatval($v['bm12']['VALUE']);
						}
						else
						if(isset($r['TarifeOfertaResponse']['tarif']))
						{
							foreach($r['TarifeOfertaResponse']['tarif'] as $k=>$v)
							{
								$soc[$v['societate']['VALUE']]=array();
								$soc[$v['societate']['VALUE']]['soc']=$v['societate']['VALUE'];
								$soc[$v['societate']['VALUE']]['6']=floatval($v['tarif6']['VALUE']);
								$soc[$v['societate']['VALUE']]['12']=floatval($v['tarif12']['VALUE']);
								$soc[$v['societate']['VALUE']]['1']=floatval($v['tarif1']['VALUE']);
								$soc[$v['societate']['VALUE']]['bm']=floatval($v['bm12']['VALUE']);
								$soc[$v['societate']['VALUE']]['com']=floatval($v['com']['VALUE']);
							}
						}
						usort($soc,sort12luni);

						//set logos
						global $_LANG_;
						$_LANG_['carpatica']='<img src="images/carpatica.png" alt="'.getLT('carpatica').'">';
						$_LANG_['ardaf']='<img src="images/ardaf.png" alt="'.getLT('ardaf').'">';
						$_LANG_['astra']='<img src="images/astra.png" alt="'.getLT('astra').'">';
						$_LANG_['allianz']='<img src="images/allianz.png" alt="'.getLT('allianz').'">';
						$_LANG_['city']='<img src="images/city.png" alt="'.getLT('city').'">';
						$_LANG_['abc']='<img src="images/abc.png" alt="'.getLT('abc').'">';
						$_LANG_['omniasig']='<img src="images/omniasig.png" alt="'.getLT('omniasig').'">';
						$_LANG_['generali']='<img src="images/generali.png" alt="'.getLT('generali').'">';
						$_LANG_['grupama']='<img src="images/groupama.png" alt="'.getLT('grupama').'">';
						$_LANG_['uniqa']='<img src="images/uniqa.png" alt="'.getLT('uniqa').'">';
						$_LANG_['euroins']='<img src="images/euroins.png" alt="'.getLT('euroins').'">';
						$_LANG_['asirom']='<img src="images/asirom.png" alt="'.getLT('asirom').'">';
						$_LANG_['crediteurope']='<img src="images/crediteurope.png" alt="'.getLT('crediteurope').'">';
						$_LANG_['platinum']='<img src="images/gothaer.png" alt="Gothaer">';
						$_LANG_['mondial']='<img src="images/mondial.png" alt="Mondial">';

						switch($tipoferta)
						{
							case 'medicale':
								//print_r($soc);
								?><table class="worktarife" cellpadding=0 cellspacing=0 border="1">
								<tr><th align=right>Asigurator<th align=right>Prima RON
								<?php
								foreach($soc as $k=>$v)
								{
									if($v['12']<2) continue;
									?>
									<tr><td align=center><?php echo getLT($v['soc']);?><td align=right class="worktarif"><a href="#" per="12" socid="<?php echo $v['soc'];?>" tarif="<?php echo showNumber($v['12'],2);?>"><?php $tt=showNumber($v['12'],2);$tt=explode(",",$tt);echo $tt[0].'<span class="tarifjos">,'.$tt[1].'</span>';?></a>
									<?php
								}
								?></table>
								<?php
								if(!isset($r['TarifeOfertaResponse']['ofertafinalizata']) || $r['TarifeOfertaResponse']['ofertafinalizata']['VALUE']=="false")
								{
									?>
									<a class="incarcatarife" href="site.php?TarifeOferta=<?php echo intval($_GET['TarifeOferta']);?>"></a>
									<?php
								}
							break;
							case 'pad':
							case 'casco':
							case 'sanatate':
							case 'malpraxis':
							case 'rotr':
								//print_r($soc);
								?><table class="worktarife" cellpadding=0 cellspacing=0 border="1">
								<tr><th align=right>Asigurator<th align=right>Prima EURO
								<?php
								foreach($soc as $k=>$v)
								{
									if($v['12']<2) continue;
									?>
									<tr><td align=center><?php echo getLT($v['soc']);?><td align=right class="worktarif"><a href="#" per="12" socid="<?php echo $v['soc'];?>" tarif="<?php echo showNumber($v['12'],2);?>"><?php $tt=showNumber($v['12'],2);$tt=explode(",",$tt);echo $tt[0].'<span class="tarifjos">,'.$tt[1].'</span>';?></a>
									<?php
								}
								?></table>
								<?php
								if(!isset($r['TarifeOfertaResponse']['ofertafinalizata']) || $r['TarifeOfertaResponse']['ofertafinalizata']['VALUE']=="false")
								{
									?>
									<a class="incarcatarife" href="site.php?TarifeOferta=<?php echo intval($_GET['TarifeOferta']);?>"></a>
									<?php
								}
							break;
							case 'rca':
							default:

								//print_r($soc);
								if(getUserConfig('color_design')=="2")
								{
								?><table class="worktarife" cellpadding=0 cellspacing=0 border="1">
								<tr><th align=right style="font-size: 16px;color:black;" rowspan=2>Asigurator<th align=right style="font-size: 16px;color:black;" colspan=2>6 luni<th align=right style="font-size: 16px;color:black;"  colspan=2>1 an
								<tr><th align=right style="font-size: 16px;color:black;">In rate
									<th align=right style="font-size: 16px;color:black;">Integral
									<th align=right style="font-size: 16px;color:black;border-left: solid 2px #eee;">In rate
									<th align=right style="font-size: 16px;color:black;">Integral
								<?php
								foreach($soc as $k=>$v)
								{
									if($v['6']<2) continue;
									if($v['12']<2) continue;

									$oldtarif6='';
									$oldtarif12='';
										$oldv6=floatval($v[6]);
										$oldv12=floatval($v[12]);
									if(false && (getUserConfig("reduceretarife")!="" || getUserConfig("reduceretarife_".$v['soc'])!=""))
									{
										$red=getUserConfig("reduceretarife");
										if(getUserConfig("reduceretarife_".$v['soc'])!="")
										{
											$red=getUserConfig("reduceretarife_".$v['soc']);
										}
										$oldv6=floatval($v[6]);
										$oldv12=floatval($v[12]);
										$v[6]=floatval($v[6])*(100-floatval($red))/100;
										$v[12]=floatval($v[12])*(100-floatval($red))/100;
										$oldtarif6='<span class="tarifjos"> * '.showNumber($oldv6,2).'</span>';
										$oldtarif12='<span class="tarifjos"> * '.showNumber($oldv12,2).'</span>';
									}
									?>
									<tr><td align=center style="text-align:center;"><?php echo getLT($v['soc']);?>
										<td align=center class="worktarif"><button socid="<?php echo $v['soc'];?>" per="6" onclick="return clickPlataInRate('<?php echo showNumber($oldv6,2);?>',this);" class="btn btn-success">In rate <?php echo showNumber($oldv6,2);?></button><br>&nbsp;
										<td align=center class="worktarif"><button socid="<?php echo $v['soc'];?>" per="6" onclick="return clickPlataIntegral('<?php echo showNumber($v[6],2);?>',this);" class="btn btn-success">Integral <?php echo showNumber($v[6],2);?></button><br><?php echo $oldtarif6;?>
										<td align=center class="worktarif" style="border-left: solid 2px #eee;"><button socid="<?php echo $v['soc'];?>" per="12" onclick="return clickPlataInRate('<?php echo showNumber($oldv12,2);?>',this);" class="btn btn-success">In rate <?php echo showNumber($oldv12,2);?></button><br>&nbsp;
										<td align=center class="worktarif"><button socid="<?php echo $v['soc'];?>" per="12" onclick="return clickPlataIntegral('<?php echo showNumber($v[12],2);?>',this);" class="btn btn-success">Integral <?php echo showNumber($v[12],2);?></button><br><?php echo $oldtarif12;?>
									<?php
								}
								?><tr><td colspan=5> * Comisionul platit brokerului, calculat ca procent din prima totala afisata in tabel, inclus in prima totala.</table>
								<?php
								}
								else
								{

								if(false && getUserConfig('codpromotional')=="Card Cheque")
								{
									//validate cod promo
									if(strlen(trim($v['codpromotional']['VALUE']))==13 && intval(substr(trim($v['codpromotional']['VALUE']),0,7))==6426174)
									{
										//ok
										global $_CONFIG;
										//$_CONFIG['reduceretarife']=10;
									}
								}

								?><table class="worktarife" cellpadding=0 cellspacing=0 border="1">
								<tr><th align=right>Asigurator<th align=right>6 luni<th align=right>1 an
								<?php
								foreach($soc as $k=>$v)
								{
									if($v['6']<2) continue;
									if($v['12']<2) continue;

									$oldtarif6='';
									$oldtarif12='';
									if(false && (getUserConfig("reduceretarife")!="" || getUserConfig("reduceretarife_".$v['soc'])!=""))
									{
										$red=getUserConfig("reduceretarife");
										if(getUserConfig("reduceretarife_".$v['soc'])!="")
										{
											$red=getUserConfig("reduceretarife_".$v['soc']);
										}
										$oldv6=floatval($v[6]);
										$oldv12=floatval($v[12]);
										$v[6]=floatval($v[6])*(100-floatval($red))/100;
										$v[12]=floatval($v[12])*(100-floatval($red))/100;
										$oldtarif6='<del><span class="tarifjos">'.showNumber($oldv6,2).'</span></del><br>';
										$oldtarif12='<del><span class="tarifjos">'.showNumber($oldv12,2).'</span></del><br>';
									}
									$oldtarif6='<br><span class="tarifjos" style="color:gray">*'.$v['com'].'% '.showNumber($v[6]*$v['com']/100,2).'</span>';
									$oldtarif12='<br><span class="tarifjos" style="color:gray">*'.$v['com'].'% '.showNumber($v[12]*$v['com']/100,2).'</span>';
									?>
									<tr><td align=center style="text-align:center;"><?php echo getLT($v['soc']);?><td align=right class="worktarif">
									<a href="#" socid="<?php echo $v['soc'];?>" per="6" tarif="<?php echo showNumber($v['6'],2);?>"><?php $tt=showNumber($v['6'],2);$tt=explode(",",$tt);echo $tt[0].'<span class="tarifjos">,'.$tt[1].'</span>'; echo $oldtarif6;?></a><td align=right class="worktarif"><a href="#"  socid="<?php echo $v['soc'];?>" per="12" tarif="<?php echo showNumber($v['12'],2);?>"><?php $tt=showNumber($v['12'],2);$tt=explode(",",$tt);echo $tt[0].'<span class="tarifjos">,'.$tt[1].'</span>';echo $oldtarif12;?></a>
									<?php
								}
								?>
								<tr><td colspan=3 style="color:gray;font-size:0.3em;">* Comisionul platit brokerului, inclus in prima totala, calculat ca procent din prima totala afisata in tabel.
								</table>
								<?php
								}
								if(!isset($r['TarifeOfertaResponse']['ofertafinalizata']) || $r['TarifeOfertaResponse']['ofertafinalizata']['VALUE']=="false")
								{
									?>
									<a class="incarcatarife" href="site.php?TarifeOferta=<?php echo intval($_GET['TarifeOferta']);?>"></a>
									<?php
								}
							break;
						}
					}
					if($action=="PolitaOferta")
					{
						if(!isset($r['TarifeOfertaResponse']['politafinalizata']) || $r['TarifeOfertaResponse']['politafinalizata']['VALUE']=="false")
						{
							?>
							<a class="incarcapolita" href="site.php?PolitaOferta=<?php echo intval($_GET['PolitaOferta']);?>"></a>
							<?php
						}
						else
						if(!isset($r['TarifeOfertaResponse']['politaid']['VALUE']) || !intval($r['TarifeOfertaResponse']['politaid']['VALUE']))
						{
							?>
							<a class="incarcapolitaeroare" href="site.php?PolitaOferta=<?php echo intval($_GET['PolitaOferta']);?>"></a>
							<?php
						}
					}
					if($action=="PDFOferta")
					{
						header('Content-Disposition: attachment; filename="Polita-'.intval($_GET['offid']).'.pdf";');
						return base64_decode($r['TarifeOfertaResponse']['politaPDF']['VALUE']);
					}
				}
			}
			return false;
		break;
		case 'DateOferta':
			$xml='<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		 <CredentialHeader xmlns="http://asiguram.ro/ws">
		   <Username>'.getUserConfig("ws_username").'</Username>
		   <Password>'.getUserConfig("ws_parola").'</Password>
		 </CredentialHeader>
	  </soap:Header>
	  <soap:Body>
	 <ModificaOferta xmlns="http://asiguram.ro/ws">
		   <idoferta>'.intval($_POST['offid']).'</idoferta>
		   ';
		foreach($_POST as $k=>$v)
		{
			switch($k)
			{
				case 'tarif':
				case 'tipplata':
				case 'action':
				break;
				default:
$xml.='<'.$k.'>'.$v.'</'.$k.'>';
				break;
			}
		}
		$xml.='
		 </ModificaOferta>
	  </soap:Body>
	</soap:Envelope>';
			$data=ws_request(getUserConfig("ws_brokerurl"),$xml,'ModificaOferta');
			$r=$data['soap:Envelope']['soap:Body'];
			if(isset($r['soap:Fault']))
			{
				return false;
			}
			return true;
		break;
		case 'WakeupCall':
			$xml='<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		 <CredentialHeader xmlns="http://asiguram.ro/ws">
		   <Username>'.getUserConfig("ws_username").'</Username>
		   <Password>'.getUserConfig("ws_parola").'</Password>
		 </CredentialHeader>
	  </soap:Header>
	  <soap:Body>
		<WakeupCall xmlns="http://asiguram.ro/ws">
			<idoferta>'.intval($_GET['WakeupCall']).'</idoferta>
		</WakeupCall>
	  </soap:Body>
	</soap:Envelope>';
			$data=ws_request(getUserConfig("ws_brokerurl"),$xml,'WakeupCall');
			$r=$data['soap:Envelope']['soap:Body'];
			if(isset($r['soap:Fault']))
			{
				return false;
			}
			return true;
		break;
		case 'ContulNou':
		case 'ParolaUitata':
		case 'ContulTau':
		case 'Reincarca':
			$xml='<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	  xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		 <CredentialHeader xmlns="http://asiguram.ro/ws">
		   <Username>'.getUserConfig("ws_username").'</Username>
		   <Password>'.getUserConfig("ws_parola").'</Password>
		 </CredentialHeader>
	  </soap:Header>
	  <soap:Body>
		<'.$action.' xmlns="http://asiguram.ro/ws">
			<clientid>'.session_getvalue("login_clientid").'</clientid>
			';
			foreach($_POST as $k=>$v)
			{
				if($k=="frandom") continue;
				if($k=="action") continue;
				if($k=="textbutton") continue;
				if($k=="automaticsubmit") continue;
				$xml.='<'.$k.'>'.$v.'</'.$k.'>';
			}
		$xml.='
		</'.$action.'>
	  </soap:Body>
	</soap:Envelope>';
			$data=ws_request(getUserConfig("ws_brokerurl"),$xml,$action);
			$r=$data['soap:Envelope']['soap:Body'];
			global $_local_error;
			$_local_error='';
			if(isset($r['soap:Fault']))
			{
				$_local_error=$r['soap:Fault']['faultstring']['VALUE'];
				return false;
			}
			if(isset($r['Client']['id']['VALUE']))
			{
				if(intval($r['Client']['id']['VALUE']))
				{
					session_setvalue("login_clientid",intval($r['Client']['id']['VALUE']));
				}
			}
			if(isset($r['Redirect']['screen']['VALUE']))
			{
				?>
<textarea><?php if(isset($r['Redirect']['message']['VALUE'])) {?>alert("<?php echo $r['Redirect']['message']['VALUE'];?>");<?php } ?>location.href='site.php?t=<?php echo $r['Redirect']['screen']['VALUE'];?>';</textarea>
				<?php
				die();
			}
			return true;
		break;
		case 'Portofoliu':
			include("extensions/process_offer_ws_client.php");
		break;
		}
	}


?>
