<?php
	if($_GET['tt']=="parola")
	{
		?>
		<div class="formdata" formtype="work" style="display:none;">{textbutton:"Schimba parola"}</div>
		<div class="workstep"><div class="biglabel">Schimba parola</div></div>
		<div class="workstep"><div class=worklabel>Parola veche</div><div class=workfields><input type=password name=oldparola value=""></div></div>
		<div class="workstep"><div class=worklabel>Parola noua</div><div class=workfields><input type=password name=newparola value="" class="validated" validate="required.yes"></div></div>
		<div class="workstep"><div class=worklabel>Verifica parola noua</div><div class=workfields><input type=password name=verfica value=""></div></div>
		<?php
	}
	else
	if($_GET['tt']=="adaugaflota")
	{
		?>
		<div class="formdata" formtype="work" style="display:none;">{nrinm:"",seriesasiu:"",categorie:"",marca:"",model:""
			,culoare:"",locuri:"",cilindree:"",kg:"",putere:"",anfab:"",valoarenou:"",ITP:"",ROVI:"",textbutton:"Adauga vehicul"}</div>
		<div class="workstep"><div class="biglabel">Date vehicul</div></div>
		<?php include("extensions/info_vehicul.php");?>
		<?php
	}
	else
	if($_GET['tt']=="adaugaalerta")
	{
		?>
		<div class="formdata" formtype="work" style="display:none;">{logdata:"",seriesasiu:"",logmesaj:"",textbutton:"Adauga alerta",masinaid:"<?php echo intval($_GET['masinaid']);?>"}</div>
		<div class="workstep"><div class="biglabel">Adauga alerta</div></div>
		<?php include("extensions/info_alerta.php");?>
		<?php
	}
	else
	{
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
		<Portofoliu xmlns="http://asiguram.ro/ws">
			<clientid>'.session_getvalue("login_clientid").'</clientid>
			<module>'.$_GET['tt'].'</module>
			<moduleview>'.$_GET['view'].'</moduleview>
			<moduleid>'.$_GET['viewid'].'</moduleid>';
		$xml.='
		</Portofoliu>
	  </soap:Body>
	</soap:Envelope>';
			$data=ws_request(getUserConfig("ws_brokerurl"),$xml,'Portofoliu');
			$r=$data['soap:Envelope']['soap:Body'];
			global $_local_error;
			$_local_error='';
			//print_r($r);
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
			if(isset($r['pdf']))
			{
				header('Content-Type: application/pdf');
				if(headers_sent())
					$this->Error('Some data has already been output, can\'t send PDF file');
				header('Content-Length: '.strlen(base64_decode($r['pdf']['VALUE'])));
				header('Content-Disposition: inline; filename="'.$r['pdfname']['VALUE'].'.pdf"');
				header('Cache-Control: private, max-age=0, must-revalidate');
				echo base64_decode($r['pdf']['VALUE']);
				die();
			}
			if(isset($r['oferte']))
			{
				//oferte
				if(isset($r['oferte']['oferta'][0]))
				{
					?><div class="workstep"><div class="biglabel">Oferte (<?php echo count($r['oferte']['oferta'])-1;?>)</div></div><?php
					foreach($r['oferte']['oferta'] as $_kk=>$_vv)
					{
						if(!isset($_vv['tipoferta'])) continue;
						?><div class="workstep"><div class="worklabel" style="width:190px;">Oferta <?php echo $_vv['tipoferta']['VALUE']." ";echo $_vv['id']['VALUE'];?> <?php echo $_vv['obiect']['VALUE'];?></div><div class="workfields"><!-- <a href="?t=client&tt=oferte&viewid=<?php echo $_vv['id']['VALUE'];?>"><img src="images/pencil.png" alt="Vezi oferta" title="Vezi oferta" style="vertical-align:middle"></a>-->
							<a href="?t=client&tt=oferte&view=pdf&viewid=<?php echo $_vv['id']['VALUE'];?>"><img src="images/ebook.png" alt="Oferta" title="Oferta" style="vertical-align:middle"></a>
							<?php if($_vv['p_soc']['VALUE']!="") {?><a href="?t=client&tt=oferte&view=decont&viewid=<?php echo $_vv['id']['VALUE'];?>"><img src="images/wallet.png" alt="Decont" title="Decont" style="vertical-align:middle"></a><?php }?>
							</div></div><?php
					}
				}
				else
				{
					?><div class="workstep"><div class="biglabel">Nu am gasit nici o oferta.</div></div><?php
				}
			}
			if(isset($r['oferta']))
			{
				?><div class="workstep"><div class="biglabel">Oferta <?php echo $r['oferta']['id']['VALUE'];?> <a href="?t=client&tt=oferte&view=pdf&viewid=<?php echo $r['oferta']['id']['VALUE'];?>"><img src="images/ebook.png" alt=PDF title=PDF style="vertical-align:middle"></a> <?php if($r['oferta']['p_soc']['VALUE']!="") {?><a href="?t=client&tt=oferte&view=decont&viewid=<?php echo $r['oferta']['id']['VALUE'];?>"><img src="images/wallet.png" alt=Decont title=Decont style="vertical-align:middle"></a><?php }?></div></div><?php
				//show offer
				switch($r['oferta']['tipoferta']['VALUE'])
				{
					case 'rca':
					?>
					<div class="workstep"><div class="worklabel">RCA valabil din:</div><div class="workfields"><?php echo $r['oferta']['datavalabilitate']['VALUE'];?></div></div>
					<div class="workstep"><div class="worklabel">Nr Inmatriculare</div><div class="workfields"><?php echo $r['oferta']['nrinm']['VALUE'];?></div></div>
					<div class="workstep"><div class="worklabel">Serie Sasiu</div><div class="workfields"><?php echo '*****'.substr($r['oferta']['seriesasiu']['VALUE'],-6);?></div></div>
					<?php
					break;
					case 'casco':
					?>
					<div class="workstep"><div class="worklabel">CASCO valabil din:</div><div class="workfields"><?php echo $r['oferta']['datavalabilitate']['VALUE'];?></div></div>
					<div class="workstep"><div class="worklabel">Nr Inmatriculare</div><div class="workfields"><?php echo $r['oferta']['nrinm']['VALUE'];?></div></div>
					<div class="workstep"><div class="worklabel">Serie Sasiu</div><div class="workfields"><?php echo '*****'.substr($r['oferta']['seriesasiu']['VALUE'],-6);?></div></div>
					<?php
					break;
					default:
					?>
					<div class="workstep"><div class="worklabel"><?php echo $r['oferta']['tipoferta']['VALUE'];?></div><div class="workfields"></div></div>
					<?php
					break;
				}
			}
			if(isset($r['polite']))
			{
				//oferte
				if(isset($r['polite']['polita'][0]))
				{
					?><div class="workstep"><div class="biglabel">Polite de asigurare (<?php echo count($r['polite']['polita'])-1;?>)</div></div><?php
					foreach($r['polite']['polita'] as $_kk=>$_vv)
					{
						if(!isset($_vv['numar'])) continue;
						?><div class="workstep"><div class="worklabel" style="width:220px;">Polite <?php echo $_vv['serie']['VALUE'].' '.$_vv['numar']['VALUE']." ";echo $_vv['id']['VALUE'];?><br><?php echo $_vv['obiect']['VALUE'];?></div><div class="workfields"><a href="?t=client&tt=polite&viewid=<?php echo $_vv['id']['VALUE'];?>"><img src="images/pencil.png" alt="Vezi polita" title="Vezi polita" style="vertical-align:middle"></a>
							<a href="?t=client&tt=polite&view=pdf&viewid=<?php echo $_vv['id']['VALUE'];?>"><img src="images/ebook.png" alt=PDF title=PDF style="vertical-align:middle"></a>
							</div></div><?php
					}
				}
				else
				{
					?><div class="workstep"><div class="biglabel">Nu am gasit nici o polita de asigurare.</div></div><?php
				}
			}
			if(isset($r['polita']))
			{
				?><div class="workstep"><div class="biglabel">Polita <?php echo $r['polita']['serie']['VALUE'].' '.$r['polita']['numar']['VALUE'];?> <a href="?t=client&tt=polite&view=pdf&viewid=<?php echo $r['polita']['id']['VALUE'];?>"><img src="images/ebook.png" alt=PDF title=PDF style="vertical-align:middle"></a> </div></div><?php
				//show offer
				?>
				<div class="workstep"><div class="worklabel">Valabila din:</div><div class="workfields"><?php echo showDate($r['polita']['perioada']['VALUE'],getLT('dateformat'));?></div></div>
				<div class="workstep"><div class="worklabel">Expira:</div><div class="workfields"><?php echo showDate($r['polita']['perioada_panala']['VALUE'],getLT('dateformat'));?></div></div>
				<?php
			}
			if(isset($r['scadente']))
			{
				?>
				<div class="workstep">
					<a href="?t=client&tt=adaugaalerta" class="biglink"><img src="images/notification.png" alt=Alerta title=Alerta style="vertical-align:middle"> Adauga Alerta</a>
				</div>
				<?php
				$toatealertele=array();
				//rate
				if(isset($r['scadente']['rata'][0]))
				{
					foreach($r['scadente']['rata'] as $_kk=>$_vv)
					{
						if(!isset($_vv['scadenta'])) continue;
						$_vv['label']='Rata <a href="?t=client&tt=polite&viewid='.$_vv['pid']['VALUE'].'">'.$_vv['serie']['VALUE'].' '.$_vv['numar']['VALUE']."</a>, Rata: ".$_vv['rata']['VALUE'].", ".$_vv['valoare']['VALUE'].' '.$_vv['moneda']['VALUE'];
						$_vv['link']='<a href="?t=client&tt=polite&view=decont&viewid='.$_vv['pid']['VALUE'].'"><img src="images/wallet.png" alt=Decont title=Decont style="vertical-align:middle"></a>';
						$toatealertele[$_vv['scadenta']['VALUE']]=$_vv;
					}
				}
				//expirari
				if(isset($r['scadente']['expirare'][0]))
				{
					foreach($r['scadente']['expirare'] as $_kk=>$_vv)
					{
						if(!isset($_vv['scadenta'])) continue;
						$_vv['label']='Expirare <a href="?t=client&tt=polite&viewid='.$_vv['id']['VALUE'].'">'.$_vv['serie']['VALUE'].' '.$_vv['numar']['VALUE']."</a>";
						$toatealertele[$_vv['scadenta']['VALUE']]=$_vv;
					}
				}
				//expirari
				if(isset($r['scadente']['alerta'][0]))
				{
					foreach($r['scadente']['alerta'] as $_kk=>$_vv)
					{
						if(!isset($_vv['scadenta'])) continue;
						$_vv['label']='Alerta: '.$_vv['logcoments']['VALUE'];
						if(intval($_vv['masinaid']['VALUE'])) $_vv['label'].='<br><a href="?t=client&tt=flota&viewid='.$_vv['masinaid']['VALUE'].'">'.$_vv['masina_nrinm']['VALUE']." - ".$_vv['masina_seriesasiu']['VALUE'].'</a>';
						$toatealertele[$_vv['scadenta']['VALUE']]=$_vv;
					}
				}
				?><div class="workstep"><div class="biglabel">Trecute</div></div><?php
				ksort($toatealertele);
				foreach($toatealertele as $ak=>$av)
				{
					if($ak>=date('Y-m-d')) continue;
					?><div class="workstep"><div class="worklabel" style="width:185px;height:auto;"><?php echo $av['label'];?></div><div class="workfields">
						<?php echo showDate($av['scadenta']['VALUE'],getLT('dateformat'))." ".$av['link'];?>
						</div></div><?php
				}
				?><div class="workstep"><div class="biglabel">In viitor</div></div><?php
				foreach($toatealertele as $ak=>$av)
				{
					if($ak<date('Y-m-d')) continue;
					?><div class="workstep"><div class="worklabel" style="width:185px;height:auto;"><?php echo $av['label'];?></div><div class="workfields">
						<?php echo showDate($av['scadenta']['VALUE'],getLT('dateformat'))." ".$av['link'];?>
						</div></div><?php
				}
			}
			if(isset($r['client']))
			{
				//date client, for edit
				?>
				<div class="formdata" formtype="work" style="display:none;">{tip:"<?php echo getValueForJs(substr($r['client']['tippersoana']['VALUE'],0,2));?>",tippersoana:"<?php echo getValueForJs($r['client']['tippersoana']['VALUE']);?>",persoanacontact:"<?php echo getValueForJs($r['client']['persoanacontact']['VALUE']);?>",calitatecontact:"<?php echo getValueForJs($r['client']['calitatecontact']['VALUE']);?>",telmobilcontact:"<?php echo getValueForJs($r['client']['telmobilcontact']['VALUE']);?>",nume:"<?php echo getValueForJs($r['client']['nume']['VALUE']);?>",codidentitate:"<?php echo getValueForJs($r['client']['codidentitate']['VALUE']);?>",codinregistrare:"<?php echo getValueForJs($r['client']['codinregistrare']['VALUE']);?>"
,iban:"<?php echo getValueForJs($r['client']['iban']['VALUE']);?>",banca:"<?php echo getValueForJs($r['client']['banca']['VALUE']);?>"
,studii:"<?php echo getValueForJs($r['client']['studii']['VALUE']);?>",ocupatie:"<?php echo getValueForJs($r['client']['ocupatie']['VALUE']);?>",starecivila:"<?php echo getValueForJs($r['client']['starecivila']['VALUE']);?>",copiiminori:"<?php echo getValueForJs($r['client']['copiiminori']['VALUE']);?>"
,telmobil:"<?php echo getValueForJs($r['client']['telmobil']['VALUE']);?>",telfix:"<?php echo getValueForJs($r['client']['telfix']['VALUE']);?>",fax:"<?php echo getValueForJs($r['client']['fax']['VALUE']);?>",email:"<?php echo getValueForJs($r['client']['email']['VALUE']);?>"
,adresa:"<?php echo getValueForJs($r['client']['adresa']['VALUE']);?>",adresa_str:"<?php echo getValueForJs($r['client']['adresa_str']['VALUE']);?>",adresa_nr:"<?php echo getValueForJs($r['client']['adresa_nr']['VALUE']);?>",adresa_et:"<?php echo getValueForJs($r['client']['adresa_et']['VALUE']);?>",adresa_sc:"<?php echo getValueForJs($r['client']['adresa_sc']['VALUE']);?>",adresa_bl:"<?php echo getValueForJs($r['client']['adresa_bl']['VALUE']);?>",adresa_ap:"<?php echo getValueForJs($r['client']['adresa_ap']['VALUE']);?>",adresa_zip:"<?php echo getValueForJs($r['client']['adresa_zip']['VALUE']);?>"
,adresa_sector:"<?php echo getValueForJs($r['client']['adresa_sector']['VALUE']);?>",judet:"<?php echo getValueForJs($r['client']['judet']['VALUE']);?>",localitate:"<?php echo getValueForJs($r['client']['localitate']['VALUE']);?>"
,textbutton:"Salveaza datele"
					}</div>
				<div class="workstep"><div class="biglabel">Identificare</div></div>
				<div class="workstep"><div class=worklabel><span class=doarpf>Nume Prenume</span><span class=doarpj>Denumire</span></div><div class=workfields><input type=text name=nume value=""></div></div>
				<div class="workstep"><div class=worklabel>Tip persoana</div><div class=workfields><select name="tip" class="validated" validate="for.pf.show.class.doarpf~for.pj.show.class.doarpj" disabled>
					<option value="pf">Persoana fizica</option>
					<option value="pj">Persoana juridica</option>
				</select></div></div>
				<div class="workstep"><div class=worklabel>Categorie</div><div class=workfields><select name="tippersoana" class="validated" validate="required.yes">
					<option class="doarpf" value="pf">Fizica</option>
					<option class="doarpf" value="pf,pensionar">Pensionar</option>
					<option class="doarpf" value="pf,bugetar">Bugetar</option>
					<option class="doarpf" value="pf,veteran">Veteran</option>
					<option class="doarpf" value="pf,handicapt">Cu handicat locomotor</option>
					<option class="doarpj" value="pj">Juridica</option>
					<option class="doarpj" value="pj,fa">PFA</option>
					<option class="doarpj" value="pj,institutii">Institutii</option>
					<option class="doarpj" value="pj,sanitar">Unitati Sanitare</option>
					<option class="doarpj" value="pj,cultur,invatamant">Cultura, Invatamant</option>
					<option class="doarpj" value="pj,regii autonome">Regii autonome</option>
					<option class="doarpj" value="pj,corp,institutii">Ambasade</option>
				</select></div></div>
				<div class="workstep"><div class=worklabel><span class=doarpf>CNP</span><span class=doarpj>CUI</span></div><div class=workfields><input type=text name=codidentitate value="" disabled></div></div>
				<div class="workstep"><div class=worklabel><span class=doarpf>CI</span><span class=doarpj>J-ul</span></div><div class=workfields><input type=text name=codinregistrare value=""></div></div>
				<div class="workstep"><div class=worklabel>Email</div><div class=workfields><input type=text name=email value=""></div></div>
				<div class="workstep"><div class=worklabel>Tel mobil</div><div class=workfields><input type=text name=telmobil value=""></div></div>
				<div class="workstep"><div class=worklabel>Tel fix</div><div class=workfields><input type=text name=telfix value=""></div></div>
				<div class="workstep"><div class=worklabel>Fax</div><div class=workfields><input type=text name=fax value=""></div></div>
				<div class="workstep"><div class="biglabel">Adresa</div></div>

<div class="workstep"><div class=workfields style="text-align:center;height:110px;"><textarea name="adresa" style="display:none;"></textarea>
Strada: <input type="text" onchange="javascript:textareaImplode('adresa');" label="str" class="adresa_implode validated" validators="change.click" validate="required.yes" name="adresa_str" size="20" value="">
<br>
nr&nbsp;<input type="number" onchange="javascript:textareaImplode('adresa');" label="nr" class="adresa_implode validated" validators="change.click" validate="required.yes" name="adresa_nr" size="4" value="" style="width:50px;">
,bl&nbsp;<input type="text" onchange="javascript:textareaImplode('adresa');" label="bl" class="adresa_implode" name="adresa_bl" size="1" value="" style="width:30px;">
, sc&nbsp;<input type="text" onchange="javascript:textareaImplode('adresa');" label="sc" class="adresa_implode" name="adresa_sc" size="1" value="" style="width:30px;">
, et&nbsp;<input type="text" onchange="javascript:textareaImplode('adresa');" label="et" class="adresa_implode" name="adresa_et" size="1" value="" style="width:30px;">
<br>ap&nbsp;<input type="text" onchange="javascript:textareaImplode('adresa');" label="ap" class="adresa_implode" name="adresa_ap" size="1" value="" style="width:30px;">
cod postal&nbsp;<input type="number" onchange="javascript:textareaImplode('adresa');" label="zip" class="adresa_implode validated" name="adresa_zip" size="6" value="" validate="required.size.6" style="width:70px;">
</div></div>

<div class="workstep"><div class=worklabel>Judet:</div><div class=workfields><select name="judet" class="validated" validate="notfor.bucuresti.show.id.im_locspan~for.bucuresti.show.id.im_sectspan~call.pregatesteAutocomplete.judet.localitate.sector~required.yes">
	<option value="">--Selectati--</option>
	<option value="bucuresti">BUCURESTI</option>
<option value="ilfov">Ilfov</option>
<option value="alba">Alba</option>
<option value="arad">Arad</option>
<option value="arges">Arges</option>
<option value="bacau">Bacau</option>
<option value="bihor">Bihor</option>
<option value="bistrita">Bistrita-Nasaud</option>
<option value="botosani">Botosani</option>
<option value="braila">Braila</option>
<option value="brasov">Brasov</option>
<option value="buzau">Buzau</option>
<option value="calarasi">Calarasi</option>
<option value="caras">Caras-Severin</option>
<option value="cluj">Cluj</option>
<option value="constanta">Constanta</option>
<option value="covasna">Covasna</option>
<option value="dambovita">Dambovita</option>
<option value="dolj">Dolj</option>
<option value="galati">Galati</option>
<option value="giurgiu">Giurgiu</option>
<option value="gorj">Gorj</option>
<option value="harghita">Harghita</option>
<option value="hunedoara">Hunedoara</option>
<option value="ialomita">Ialomita</option>
<option value="iasi">Iasi</option>
<option value="maramures">Maramures</option>
<option value="mehedinti">Mehedinti</option>
<option value="mures">Mures</option>
<option value="neamt">Neamt</option>
<option value="olt">Olt</option>
<option value="prahova">Prahova</option>
<option value="salaj">Salaj</option>
<option value="satu">Satu Mare</option>
<option value="sibiu">Sibiu</option>
<option value="suceava">Suceava</option>
<option value="teleorman">Teleorman</option>
<option value="timis">Timis</option>
<option value="tulcea">Tulcea</option>
<option value="valcea">Valcea</option>
<option value="vaslui">Vaslui</option>
<option value="vrancea">Vrancea</option>
	</select>
</div></div>

<div id="im_locspan" style="display:none;">
<div class="workstep"><div class=worklabel>Localitate:</div><div class=workfields><input name="localitate" id="localitate" type=text value="" lk="coduri/code.php?soc=allianz&grupa=localitati&valoare=&lookupfor=localitate&lkjudet=[judet]" class="autocompletefield validated" mustmatch=yes validate="required.yes" size=18>
</div></div>
</div>

<div id="im_sectspan" style="display:none;">
<div class="workstep"><div class=worklabel>Sector</div><div class=workfields><select id="adresa_sector" name="adresa_sector" class="validated adresa_implode" validators="change" validate="required.yes" label="sector" onchange="javascript:textareaImplode('adresa');"><option value=""> Sector...</option>
	<option value="1">Sector 1</option><option value="2">Sector 2</option><option value="3">Sector 3</option>
	<option value="4">Sector 4</option><option value="5">Sector 5</option><option value="6">Sector 6</option>
	</select>
</div></div>
</div>

				<div class=doarpj>
				<div class="workstep"><div class="biglabel">Persoana contact</div></div>
				<div class="workstep"><div class=worklabel>Nume</div><div class=workfields><input type=text name=persoanacontact value=""></div></div>
				<div class="workstep"><div class=worklabel>Telefon</div><div class=workfields><input type=text name=telmobilcontact value=""></div></div>
				<div class="workstep"><div class=worklabel>Calitate</div><div class=workfields><input type=text name=calitatecontact value=""></div></div>
				</div>
				<div class="workstep"><div class="biglabel">Alte informatii</div></div>
				<div class="workstep"><div class=worklabel>IBAN</div><div class=workfields><input type=text name=iban value=""></div></div>
				<div class="workstep"><div class=worklabel>BANCA</div><div class=workfields><input type=text name=banca value=""></div></div>
				<div class=doarpf>
				<div class="workstep"><div class=worklabel>Studii</div><div class=workfields><select name="studii">
<option value="">Nespecificat</option>
<option value="facultate">Facultate</option>
<option value="doctorat">Doctorat</option>
<option value="masterat">Masterat</option>
<option value="liceu">Liceu</option>
<option value="fara">Fara</option>
</select></div></div>
				<div class="workstep"><div class=worklabel>Ocupatie</div><div class=workfields><input type=text name=ocupatie value=""></div></div>
				<div class="workstep"><div class=worklabel>Stare civila</div><div class=workfields><select name="starecivila">
<option value="">Nespecificata</option>
<option value="casatorit">Casatorit</option>
<option value="necasatorit">Necasatorit</option>
<option value="divortat">Divortat</option>
<option value="Vaduv">Vaduv</option>
</select></div></div>
				<div class="workstep"><div class=worklabel>Copii Minori</div><div class=workfields><select name=copiiminori>
					<option value="0">Nespecificat</option>
					<option value="1">Un copil</option>
					<option value="2">Doi copii</option>
					<option value="3">3 sau mai multi</option>
				</select></div></div>
				</div>
				<?php
			}
			if(isset($r['masini']))
			{
				?>
				<div class="workstep">
					<a href="?t=client&tt=adaugaflota" class="biglink"><img src="images/clipboard.png" alt=Vehicul title=Vehicul style="vertical-align:middle"> Adauga Vehicul</a>
				</div>
				<?php
				foreach($r['masini']['masina'] as $_kk=>$_vv)
				{
					if(!isset($_vv['id'])) continue;
					?>
					<div class="workstep"><div class=worklabel style="width:220px;"><?php echo $_vv['nrinm']['VALUE'];?> - <?php echo $_vv['seriesasiu']['VALUE'];?></div>
					<div class=workfields><a href="?t=client&tt=adaugaalerta&masinaid=<?php echo $_vv['id']['VALUE'];?>"><img src="images/notification.png" alt=Alerta title=Alerta style="vertical-align:middle"></a></div>
					<div class=workfields><a href="?t=client&tt=flota&viewid=<?php echo $_vv['id']['VALUE'];?>"><img src="images/pencil.png" alt="Detalii" title="Detalii" style="vertical-align:middle"></a></div>
					</div>
					<?php
				}
			}
			if(isset($r['masina']))
			{
				?>
				<div class="formdata" formtype="work" style="display:none;">{nrinm:"<?php echo getValueForJs($r['masina']['nrinm']['VALUE'])?>",seriesasiu:"<?php echo getValueForJs($r['masina']['seriesasiu']['VALUE'])?>",categorie:"<?php echo getValueForJs($r['masina']['categorie']['VALUE'])?>",marca:"<?php echo getValueForJs($r['masina']['marca']['VALUE'])?>",model:"<?php echo getValueForJs($r['masina']['model']['VALUE'])?>"
,culoare:"<?php echo getValueForJs($r['masina']['culoare']['VALUE'])?>",locuri:"<?php echo getValueForJs($r['masina']['locuri']['VALUE'])?>",cilindree:"<?php echo getValueForJs($r['masina']['cilindree']['VALUE'])?>",kg:"<?php echo getValueForJs($r['masina']['kg']['VALUE'])?>",putere:"<?php echo getValueForJs($r['masina']['putere']['VALUE'])?>",anfab:"<?php echo getValueForJs($r['masina']['anfab']['VALUE'])?>"
,valoarenou:"<?php echo getValueForJs($r['masina']['valoarenou']['VALUE'])?>",ITP:"<?php echo getValueForJs(showDate($r['masina']['itp']['VALUE'],getLT('dateformat')))?>",ROVI:"<?php echo getValueForJs(showDate($r['masina']['rovi']['VALUE'],getLT('dateformat')))?>"
,textbutton:"Salveaza datele"
					}</div>
				<div class="workstep"><div class="biglabel">Vehicul</div></div>
				<?php
				include("extensions/info_vehicul.php");
			}
			return true;
		}
?>
