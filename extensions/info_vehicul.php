				<div class="workstep"><div class=worklabel>Nr inmatriculare</div><div class=workfields><input type=text name=nrinm value=""></div></div>
				<div class="workstep"><div class=worklabel>Culoare</div><div class=workfields><select name="culoare" class="validated" validate="required.yes">
<option value="">Selectati</option>
<option value="Alb">Alb</option>
<option value="Albastru">Albastru</option>
<option value="Albastru deschis">Albastru deschis</option>
<option value="Albastru electric">Albastru electric</option>
<option value="Albastru inchis">Albastru inchis</option>
<option value="Albastru turcia">Albastru turcia</option>
<option value="Bej">Bej</option>
<option value="Bordo">Bordo</option>
<option value="Galben">Galben</option>
<option value="Galben lamaie">Galben lamaie</option>
<option value="Gri">Gri</option>
<option value="Gri deschis">Gri deschis</option>
<option value="Gri inchis">Gri inchis</option>
<option value="Maro">Maro</option>
<option value="Negru">Negru</option>
<option value="Portocaliu">Portocaliu</option>
<option value="Rosu">Rosu</option>
<option value="Rosu deschis">Rosu deschis</option>
<option value="Rosu inchis">Rosu inchis</option>
<option value="Verde">Verde</option>
<option value="Violet">Violet</option>
</select></div></div>
				<div class="workstep"><div class="biglabel">Alerte</div></div>
<div class="workstep"><div class="worklabel">ITP</div><div class=workfields><input type="text" value="" size="9" id="ITP" name="ITP" class="validated">&nbsp;<a href="#" onclick="global_cal.select(document.forms['work'].ITP,'ITP_sel','dd.MM.yyyy'); return false;" name="ITP_sel" id="ITP_sel"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>
<div class="workstep"><div class="worklabel">Rovinieta</div><div class=workfields><input type="text" value="" size="9" id="ROVI" name="ROVI" class="validated">&nbsp;<a href="#" onclick="global_cal.select(document.forms['work'].ROVI,'ROVI_sel','dd.MM.yyyy'); return false;" name="ROVI_sel" id="ROVI_sel"><img src="images/calendar.png" border="0" alt="Calendar"></a>
</div></div>
				<div class="workstep"><div class="biglabel">Date tehnice</div></div>
				<div class="workstep"><div class=worklabel>Serie Sasiu</div><div class=workfields><input type=text name=seriesasiu value=""></div></div>
				<div class="workstep"><div class=worklabel>Marca</div><div class=workfields><input type=text name=marca value=""></div></div>
				<div class="workstep"><div class=worklabel>Model</div><div class=workfields><input type=text name=model value=""></div></div>
				<div class="workstep"><div class=worklabel>Categorie</div><div class=workfields><input type=hidden name=codcateg value=""><select name="categorie" class="validated" validators="change" validate="get.cod.categ~required.yes">
			<option value="">--Selectati categoria</option>
			<option value="autoturism" categ="autoturism">autoturism</option>
<option value="autoturism de teren" categ="autoturism">autoturism de teren</option>
<option value="autoutilitara" categ="autoutilitara">autoutilitara</option>
<option value="atas" categ="remorca">atas</option>
<option value="atv" categ="motociclu">atv</option>
<option value="autobasculanta" categ="alte">autobasculanta</option>
<option value="autobetoniera" categ="alte">autobetoniera</option>
<option value="autobuz" categ="autocar">autobuz</option>
<option value="autobuz articulat" categ="autocar">autobuz articulat</option>
<option value="autobuz interurban" categ="autocar">autobuz interurban</option>
<option value="autobuz special" categ="autocar">autobuz special</option>
<option value="autobuz urban" categ="autocar">autobuz urban</option>
<option value="autocamion" categ="alte">autocamion</option>
<option value="autocamionete pick-up" categ="alte">autocamionete pick-up</option>
<option value="autocisterna" categ="alte">autocisterna</option>
<option value="auto pentru stingere incendii" categ="alte">auto pentru stingere incendii</option>
<option value="autocar" categ="autocar">autocar</option>
<option value="autofurgoneta" categ="alte">autofurgoneta</option>
<option value="automacara" categ="alte">automacara</option>
<option value="alte autovehicule" categ="alte">alte autovehicule</option>
<option value="autorulota" categ="autoturism">autorulota</option>
<option value="autosanitara" categ="autoturism">autosanitara</option>
<option value="autospeciala" categ="autoutilitara">autospeciala</option>
<option value="autoatelier" categ="autoturism">autoatelier</option>
<option value="autotractor" categ="alte">autotractor</option>
<option value="autotractor cu sa" categ="alte">autotractor cu sa</option>
<option value="buldozer" categ="alte">buldozer</option>
<option value="camion" categ="alte">camion</option>
<option value="cap tractor" categ="alte">cap tractor</option>
<option value="autovehicule transport in comun" categ="tramvai">autovehicule transport in comun</option>
<option value="autovehicule sau autospecializate pentru transport persoane" categ="alte">autov.sau autosp. ptr tr. pers</option>
<option value="combina" categ="alte">combina</option>
<option value="compactor" categ="alte">compactor</option>
<option value="excavator" categ="alte">excavator</option>
<option value="buldoexcavator" categ="alte">buldoexcavator</option>
<option value="greder" categ="alte">greder</option>
<option value="incarcator" categ="alte">incarcator</option>
<option value="microbuz" categ="autocar">microbuz</option>
<option value="motocicleta" categ="motociclu">motocicleta</option>
<option value="moped" categ="motociclu">moped</option>
<option value="motoreta" categ="motociclu">motoreta</option>
<option value="motocositoare" categ="motociclu">motocositoare</option>
<option value="remorca" categ="remorca">remorca</option>
<option value="rulota" categ="remorca">rulota</option>
<option value="scuter" categ="motociclu">scuter</option>
<option value="semiremorca" categ="remorca">semiremorca</option>
<option value="stivuitor" categ="alte">stivuitor</option>
<option value="tractor" categ="tractor">tractor</option>
<option value="autovehicul similar cu tractorul" categ="tractor">autovehicul similar cu tractorul</option>
<option value="tramvai" categ="tramvai">tramvai</option>
<option value="troleibuz" categ="tramvai">troleibuz</option>
<option value="utilaje" categ="alte">utilaje</option>
<option value="utilaje cu senile" categ="alte">utilaje cu senile</option>
<option value="utilaje pe pneuri" categ="alte">utilaje pe pneuri</option>
			</select></div></div>
				<div class="workstep"><div class=worklabel>Cilindree</div><div class=workfields><input type=text name=cilindree value=""></div></div>
				<div class="workstep"><div class=worklabel>Putere</div><div class=workfields><input type=text name=putere value=""></div></div>
				<div class="workstep"><div class=worklabel>Locuri</div><div class=workfields><input type=text name=locuri value=""></div></div>
				<div class="workstep"><div class=worklabel>Kg</div><div class=workfields><input type=text name=kg value=""></div></div>
				<div class="workstep"><div class=worklabel>An fabricatie</div><div class=workfields><input type=text name=anfab value=""></div></div>
				<div class="workstep"><div class=worklabel>Valoare nou</div><div class=workfields><input type=text name=valoarenou value=""></div></div>

