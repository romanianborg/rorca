<script>
function select_findIndex(el,n)
{
	if(!el) return 0;
	var idx=0;
	var i=0;
	var s=n.toLowerCase();
	el.children("option").each(function(){
		if(!$(this).attr("value")) {i++;return true;}
		var v=$(this).attr("value").toLowerCase();
		if(v && v!="")
		{
			if(v==s) {idx=i;return false;}
		}
		i++;
	});
	return idx;
}
function validateValueTest(v,values)
{
	var arr=values.split("|");
	var i;
	for(i in arr)
	{
		if(v==arr[i]) return true;
	}
	return false;
}
function isElementVisible(el)
{
	if(el.is(":hidden")) return false;
	var ret=true;
	return ret;
}
function validateRule(el,ev,rule,start,rev)
{
	var i;
	if(start>=rule.length) return true;
	switch(rule[start])
	{
		case 'get':
		case 'fget':
			var allru=rule[start+1];
			var allruend='';
			if(rule[start]=="fget") {allru='';allruend=$("[name="+rule[start+1]+"]").val();}
			for(i=start+2;i<rule.length;i++)
			{
				$("[name="+allru+rule[i]+"]").each(function(){
					if(el[0].selectedIndex==-1) return false;
					var aprule=$(el[0].options[el[0].selectedIndex]).attr(rule[i]+allruend);
					if(aprule)// && aprule!=""
					{
						if($(this)[0].tagName.toLowerCase()=="select")
						{
							$(this)[0].selectedIndex=select_findIndex($(this),aprule);
						}
						else
						if($(this)[0].tagName.toLowerCase()=="input" && $(this)[0].type.toLowerCase()=="checkbox")
						{
							$(this)[0].checked=(aprule=="1"?true:false);
						}
						else
						{
							$(this).val(aprule);
						}
					}
				});
			}
			break;
		case 'invget':
			//$("select[name="+rule[start+1]+"] option["+rule[start+2]+"="+rule[start+3]+"]").each(function(){
			//	$(this).attr(rule[start+2],el.val());
			//});
			break;
		case 'filter':
			 if (!$.browser.webkit) {
			var tosel=el[0].options[el[0].selectedIndex].value;
			if(el[0].selectedIndex!=-1)
			{
				var tosel=el[0].options[el[0].selectedIndex].value;
				if(tosel=="")
				{
					$("select[name="+rule[start+1]+"] option").show();
				}
				else
				{
					var allsel=rule[start+1].split("|");
					for(var ii=0;ii<allsel.length;ii++)
					{
						$("select[name="+allsel[ii]+"] option").each(function(){
							if(!$(this).attr(rule[start+2])) return true;
							if($(this).attr(rule[start+2])==tosel || $(this).attr(rule[start+2])=="0")
								$(this).show();
							else
								$(this).hide();
						});
					}
				}
			}
			else
			{
				$("select[name="+rule[start+1]+"] option").show();
			}
			}
			break;
		case 'copy':
			if(isElementVisible(el))
			{
				var newel=$("[name="+rule[start+1]+"]");
				newel.val(el.val());
			}
			break;
		case 'same':
			if(isElementVisible(el))
			{
				var newel=$("[name="+rule[start+1]+"]");
				el.val(newel.val());
			}
			break;
		case 'set':
			if(isElementVisible(el) && !rev)
			{
				var newel=$("[name="+rule[start+1]+"]");
				newel.val(rule[start+2]);
			}
			break;
		case 'reset':
			if(rule[start+1]=="id")
			{
				$("#"+rule[start+2]).val('').change();
			}
			else
				if(rule[start+1]=="name")
				{
					$("[name="+rule[start+2]+"]").val('').change();
				}
			break;
		case 'check':
			var newel=$("[name="+rule[start+1]+"]");
			if(newel.length)
			{
				newel[0].checked=true;
			}
		break;
		case 'uncheck':
			var newel=$("[name="+rule[start+1]+"]");
			if(newel.length)
			{
				newel[0].checked=false;
			}
		break;
		case 'ifchecked':
			var v=el[0].checked;
			if(v)
			{
				if(!validateRule(el,ev,rule,start+1))
				{
					return false;
				}
			}
			else
			{
				if(!validateRule(el,ev,rule,start+1,true))
				{
					return false;
				}
			}
			break;
		case 'if':
			//strict
			var v=$("[name="+rule[start+1]+"]").val();
			if(validateValueTest(v,rule[start+2]))
			{
				if(!validateRule(el,ev,rule,start+3))
				{
					return false;
				}
			}
			break;
		case 'nif':
			//strict not
			var v=$("[name="+rule[start+1]+"]").val();
			if(!validateValueTest(v,rule[start+2]))
			{
				if(!validateRule(el,ev,rule,start+3))
				{
					return false;
				}
			}
			break;
		case 'for':
			//lejer if
			if(el[0].type.toLowerCase()=="checkbox")
			{
				if(el[0].checked)
				{
					validateRule(el,ev,rule,start+2)
				}
				else
				{
					validateRule(el,ev,rule,start+2,!rev)
				}
			}
			else
			if(validateValueTest(el.val(),rule[start+1]))
			{
				validateRule(el,ev,rule,start+2)
			}
			else
			{
				validateRule(el,ev,rule,start+2,!rev)
			}
		break;
		case 'notfor':
			//lejer nif
			if(el[0].type.toLowerCase()=="checkbox")
			{
				if(!el[0].checked)
				{
					validateRule(el,ev,rule,start+2)
				}
				else
				{
					validateRule(el,ev,rule,start+2,!rev)
				}
			}
			else
			if(!validateValueTest(el.val(),rule[start+1]))
			{
				validateRule(el,ev,rule,start+2)
			}
			else
			{
				validateRule(el,ev,rule,start+2,!rev)
			}
		break;
		case 'hide':
			rev=!rev;
		case 'show':
			if(!isElementVisible(el)) break;
		case 'forceshow':
			for(i=start+2;i<rule.length;i++)
			{
				if(rev)
				{
					if(rule[start+1]=="id")
					{
						$("#"+rule[i]).hide();
					}
					else
					if(rule[start+1]=="class")
					{
						$("."+rule[i]).hide();
					}
					else
					if(rule[start+1]=="name")
					{
						$("[name="+rule[i]+"]").hide();
					}
				}
				else
				{
					if(rule[start+1]=="id")
					{
						$("#"+rule[i]).show();
					}
					else
					if(rule[start+1]=="class")
					{
						$("."+rule[i]).show();
					}
					else
					if(rule[start+1]=="name")
					{
						$("[name="+rule[i]+"]").show();
					}
				}
			}
			if(el && /chrome/.test(navigator.userAgent.toLowerCase()))
			{
				$('<div></div>').appendTo(el.parent()).remove();
			}
		break;
		case 'extract':
			switch(rule[start+1])
			{
				case 'varsta':
					var varsta="";
					var v=el.val();
					if(v.length<7) break;
					var yy=v.substr(1,2);
					var mm=v.substr(3,2);
					var dd=v.substr(5,2);
					var dat = new Date();
					var curday = dat.getDate();
					var curmon = dat.getMonth()+1;
					var curyear = dat.getFullYear();
					var plusone=0;
					if(curmon<parseInt(mm,10) || (curmon==parseInt(mm,10) && curday<parseInt(dd,10)))
					{
						plusone=1;
					}
					varsta=curyear%100-parseInt(yy,10)%100;
					varsta-=plusone;
					if(varsta<0) {varsta+=100};
					if(varsta>100) {varsta%=100};
					$("input[name="+rule[start+2]+"]").val(varsta);
				break;
				case 'sum':
					var sum=0;
					for(i=start+1;i<rule.length;i++)
					{
						var vvv=parseFloat($("input[name="+rule[i]+"]").val());
						if(!isNaN(vvv)) sum+=vvv;
					}
					el.val(sum);
				break;
			}
		break;
		case 'revalidate':
			var newel=$("[name="+rule[start+1]+"]");
			if(isElementVisible(newel))
			{
				if(!validateFieldRule(newel,ev,newel.attr("validate")))
				{
					//do not failed this because it is already validated
				}
			}
		break;
		case 'nokeys':
			if(ev && ev.keyCode)
			{
				for(i=start+1;i<rule.length;i++)
				{
					if(ev.keyCode==rule[i]) return false;
				}
			}
		break;
		case 'numberkeys':
			if(ev && ev.keyCode)
			{
				if(ev.keyCode<48 || ev.keyCode>57) return false;
			}
		break;
		case 'alfakeys':
			if(ev && ev.keyCode)
			{
				if(ev.keyCode<48 || ev.keyCode>57)
				if(ev.keyCode<65 || ev.keyCode>90)
					return false;
			}
		break;
		case 'replace':
			var v=el.val();
			for(i=start+1;i<rule.length;i++,i++)
			{
				var re=new RegExp(rule[i].replace("\\","\\\\"),"gi");
				if(rule[i+1]=="(pt)")
				{
					el.val(v.replace(re,"."));
				}
				else
				{
					el.val(v.replace(re,rule[i+1]));
				}
				v=el.val();
			}
		break;
		case 'call':
			eval(''+rule[start+1]+'(el,"'+rule[start+2]+'","'+rule[start+3]+'","'+rule[start+4]+'")');
		break;
		case 'addmonths':
			$("#"+rule[start+1]).val(calendarAutomaticCalculateEndDate($("#"+rule[start+2]).val(),el.val(),'dd.MM.yyyy'));
		break;
		case 'adddays':
			$("#"+rule[start+1]).val(calendarAutomaticDays($("#"+rule[start+2]).val(),el.val(),'dd.MM.yyyy'));
		break;
		case 'nodays':
			var daystoex=el.val().split(".");
			for(i=start+1;i<rule.length;i++)
			{
				if(daystoex.length && daystoex[0]==rule[i])
				{
					el.val(calendarAutomaticDays(el.val(),2,'dd.MM.yyyy'));
					daystoex=el.val().split(".");
				}
			}
		break;
		case 'uppercase':
			if(!ev || !ev.keyCode)
			{
				el.val(el.val().toUpperCase());
			}
		break;
		case 'required':
			var bck=false;
			var ret=true;
			if(ret)
			{
				switch(rule[start+1])
				{
					case 'correct':
						var onefound=false;
						for(i=start+2;i<rule.length;i++)
						{
							if(el.val().length==parseInt(rule[i]))
							{
								onefound=true;break;
							}
						}
						if(!onefound)
						{
							bck=true;
						}
					break;
					case 'size':
						var onefound=false;
						for(i=start+2;i<rule.length;i++)
						{
							if(el.val().length==parseInt(rule[i]))
							{
								onefound=true;break;
							}
						}
						if(!onefound)
						{
							bck=true;
							if(isElementVisible(el) && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'max':
						if(el.val().length>parseFloat(rule[start+2]))
						{
							bck=true;
							if(isElementVisible(el) && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'minmax':
						if(el.val().length>parseFloat(rule[start+3]) || el.val().length<parseFloat(rule[start+2]))
						{
							bck=true;
							if(isElementVisible(el) && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'min':
						if(el.val().length<parseFloat(rule[start+2]))
						{
							bck=true;
							if(isElementVisible(el) && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'date':
						var da=el.val();
						if(da!="")
						{
							da=da.replace(/\//gi,".");
							da=da.replace(/\\/gi,".");
							el.val(da);
							var arr=da.split(".");
							if(da.length!=10) {bck=true;if(isElementVisible(el)) ret=false;}
						}
						else
						{
							bck=true;if(isElementVisible(el)) ret=false;
						}
					break;
					case 'cnp':
						var cnp=el.val();
						if(cnp.length!=13) {bck=true;if(isElementVisible(el)) ret=false;}
						if(cnp=="0000000000000") {bck=true;if(isElementVisible(el)) ret=false;}

						var sum;
						sum=parseInt(cnp.substr(0,1))*2 + parseInt(cnp.substr(1,1))*7 + parseInt(cnp.substr(2,1))*9 + parseInt(cnp.substr(3,1))*1 + parseInt(cnp.substr(4,1))*4 + parseInt(cnp.substr(5,1))*6 + 
							 parseInt(cnp.substr(6,1))*3 + parseInt(cnp.substr(7,1))*5 + parseInt(cnp.substr(8,1))*8 + parseInt(cnp.substr(9,1))*2 + parseInt(cnp.substr(10,1))*7 +parseInt(cnp.substr(11,1))*9;

						var control = sum % 11;
						if(control == 10) control = 1;
						if (control != parseInt(cnp.substr(12,1))) {bck=true;if(isElementVisible(el) && (!ev || !ev.keyCode)) ret=false;}
					break;
					case 'cui':
						var cnp=el.val();
						if(cnp.length>10) {bck=true;if(isElementVisible(el)) ret=false;}
						if(cnp.length<2) {bck=true;if(isElementVisible(el)) ret=false;}
						if(parseInt(cnp)==0) {bck=true;if(isElementVisible(el)) ret=false;}

						var sum;
						var i;var j;
						sum=0;
						var ctr;
						ctr='753217532';
						j=8;
						for(i=cnp.length-2;i>=0;i--)
						{
							sum+=parseInt(cnp.substr(i,1))*parseInt(ctr.substr(j,1));
							j--;
						}
						var control = sum*10 % 11;
						if(control == 10) control = 0;
						if (control != parseInt(cnp.substr(cnp.length-1,1))) {bck=true;if(isElementVisible(el) && (!ev || !ev.keyCode)) ret=false;}
					break;
					case 'integer':
						if(ev && ev.ctrlKey)
						{
						}
						else
						if(ev && ev.keyCode && (ev.keyCode>=65 && ev.keyCode<=90 || ev.keyCode==32 || ev.keyCode==110 || ev.keyCode==188 || ev.keyCode==190))
						{
							ret=false;
						}
					break;
					case 'zeros':
						var nm=el.val();
						if(nm.length>0 && nm.length<=parseInt(rule[start+2]))
						{
							var add=parseInt(rule[start+2])-el.val().length;
							for(i=0;i<add;i++)
								nm="0"+nm;
							el.val(nm);
						}
					break;
					case 'no':
					break;
					case 'attention':
						bck=false;
						if(el.attr("attention")!="yes")
						{
							if(ev && ev.type) el.attr("attention","yes");
							else if(el.val()=="") bck=true;
						}
					break;
					case 'email':
						if(!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(el.val())))
						{
							//not ok
							bck=true;
							ret=false;
						}
					break;
					case 'phone':
						var st = el.val().replace(/[\(\)\.\-\ ]/g, '');
						if(st.length!=10)
						{
							//not ok
							bck=true;
							ret=false;
						}
					break;
					case 'yes':
					default:
						if(el.val()=="")
						{
							bck=true;
							if(isElementVisible(el) && (!ev || !ev.keyCode)) ret=false;
						}
					break;
				}
				if(bck) el.addClass("validateatention");
				else el.removeClass("validateatention");
				if(ret==false) return false;
			}
		break;
	}
	return true;
}

function validateFieldRule(el,ev,validate)
{
	var rules;
	var i;
	var ret=true;
	if(!validate) return true;
	if(el.val()!="")
	{
		//remove diacritics
		var newval=el.val();
		newval=encodeURIComponent(newval);
		newval=newval.replace(new RegExp("%C4%83","gi"),"a");
		newval=newval.replace(new RegExp("%C4%82","gi"),"A");
		newval=newval.replace(new RegExp("%C3%A2","gi"),"A");
		newval=newval.replace(new RegExp("%C3%82","gi"),"a");
		newval=newval.replace(new RegExp("%C3%82","gi"),"a");
		newval=newval.replace(new RegExp("%C3%AE","gi"),"i");
		newval=newval.replace(new RegExp("%C3%8E","gi"),"I");
		newval=newval.replace(new RegExp("%C8%99","gi"),"s");
		newval=newval.replace(new RegExp("%C8%98","gi"),"S");
		newval=newval.replace(new RegExp("%C8%9B","gi"),"t");
		newval=newval.replace(new RegExp("%C8%9A","gi"),"T");
		newval=newval.replace(new RegExp("%C5%9E","gi"),"S");
		newval=newval.replace(new RegExp("%C5%9F","gi"),"s");
		newval=newval.replace(new RegExp("%C5%A2","gi"),"T");
		newval=newval.replace(new RegExp("%C5%A3","gi"),"t");
		el.val(decodeURIComponent(newval));
	}

	if(el.length && el[0].type.toLowerCase()=="radio")
	{
		if(!el[0].checked) return true;
	}
	rules=validate.split("~");
	for(i in rules)
	{
		var tokens;
		tokens=rules[i].split(".");
		if(!validateRule(el,ev,tokens,0))
		{
			ret=false;
		}
	}
	return ret;
}
function calendar_finished(y,m,d)
{
	CP_tmpReturnFunction(y,m,d);
	$(window.CP_targetInput).change();
}

function calculatetarife_pad()
{
	if($("select[name=tipcladire]")[0].selectedIndex==1)
	{
		$("b.tarifpad").html($("div.tarifA").html());
		$("input.tarifpad_text").val($("div.tarifA").html());
	}
	if($("select[name=tipcladire]")[0].selectedIndex==2)
	{
		$("b.tarifpad").html($("div.tarifB").html());
		$("input.tarifpad_text").val($("div.tarifB").html());
	}
	return true;
}
function getcotafromstring(s)
{
	var ret=parseFloat(s);
	if(isNaN(ret)) ret=0;
	return Math.round(ret);
}
function valideazaDoarForma(f,valideaza)
{
	var slot="#workstep";
	var ret=true;
	$(slot).find(".validated").each(function(){
		if(!$(this).hasClass("doaremitere") && isElementVisible($(this)))
		{
			if(!validateFieldRule($(this),{},$(this).attr("validate")))
			{
				ret=false;
				if(valideaza)
					valideaza(this,false);
				else
					$(this).css("background-color","<?php echo getUserConfig("alert_color");?>");
			}
			else
			{
				valideaza(this,true);
			}
		}
	});
	return ret;
}
function valideazaFormaPentruSalvare(f,valideaza)
{
	var slot="#work";
	var ret=true;
	$(slot).find(".validated").each(function(){
		if(isElementVisible($(this)))
		{
			if(!validateFieldRule($(this),{},$(this).attr("validate")))
			{
				if(valideaza)
					valideaza(this,false);
				else
					$(this).css("background-color","<?php echo getUserConfig("alert_color");?>");
				ret=false;
			}
			else
			{
				if(valideaza) valideaza(this,true);
			}
		}
	});
	var allok=true;
	if(isElementVisible($("#pastarife")))
	{
		$(slot).find("input[name=selectiesoc]").each(function(){
			if($(this)[0].checked)
			{
				allok=true;return false;
			}
			else
			{
				allok=false;
			}
		});
		$("#work input[name=refreshslot]").val("work");
	}
	else
	{
		$("#work input[name=refreshslot]").val("dummy");
	}
	if(!allok)
	{
		ret=false;
		setTimeout('alert("Va rugam selectati tariful dorit.");',100);
	}
	else
	if(ret==false)
	{
		setTimeout('alert("Nu pot sa salvez, sunt date gresite sau necompletate. Verificati marcajele.");',100);
	}
	else
	{
		//$("#savebutton").attr("disabled","yes");
	}
	return ret;
}
var punemarcaje;
function reloadValidators(slot)
{
	if(typeof(Storage)!=="undefined")
	{
		$("input[type!=hidden]").add("select").each(function(){
			if($(this).attr("name")=="tarif") return true;
			if(localStorage['t_'+$(this).attr("name")]!="")
			{
				$(this).val(localStorage['t_'+$(this).attr("name")]);
			}
		});
	}

	var one=false;
	$(slot).find(".validated").each(function(){
		var arr;
		if($(this).attr("validators")) arr=""+$(this).attr("validators");
		else arr="change";

		arr=arr.split(".");
		var i;
		for(i in arr)
		{
			if($(this).hasClass("doaremitere"))
			{
				$(this).unbind(arr[i]).bind(arr[i],function(ev){
					ret=validateFieldRule($(this),ev,$(this).attr("validate"));
					if(punemarcaje) punemarcaje(this,ret);
					return ret;
				});
			}
			else
			{
				$(this).unbind(arr[i]).bind(arr[i],function(ev){
					//sterge tarife
					var ret=validateFieldRule($(this),ev,$(this).attr("validate"));
					if(punemarcaje) punemarcaje(this,ret);
					return ret;
				});
			}
		}
		var ret=validateFieldRule($(this),{},$(this).attr("validate"));
		if(punemarcaje)
		{
			punemarcaje(this,ret);
		}
		one=true;
	});
	
	if(one)
	{
		$("form[name=work]").attr("callmefirst","valideazaFormaPentruSalvare");
	}
	//bind calendar
	global_cal.setReturnFunction("calendar_finished");
}

function valideazapad()
{
	if($("select[name=tipcladire]")[0].selectedIndex==2)
	{
		var ret=true;
		if($("input[name=sumaasigurata]").val()!="10000")
		{
			$("input[name=sumaasigurata]").val("10000");
			ret=false;
		}
		return ret;
	}
	var cotafinala=0;
	//cota1
	if($("select[name=tipproprietar]")[0].selectedIndex==1)
		cotafinala+=getcotafromstring(''+$("input[name=pf_cota]").val());
	else
	if($("select[name=tipproprietar]")[0].selectedIndex==2)
		cotafinala+=getcotafromstring($("input[name=pj_cota]").val());

	//cota2
	if($("select[name=tipproprietar2]").length)
	{
	if($("select[name=tipproprietar2]")[0].selectedIndex==1)
		cotafinala+=getcotafromstring($("input[name=pf2_cota]").val());
	else
	if($("select[name=tipproprietar2]")[0].selectedIndex==2)
		cotafinala+=getcotafromstring($("input[name=pj2_cota]").val());
	}

	if(cotafinala!=100)
	{
		var cota1=0;
		if($("select[name=tipproprietar]")[0].selectedIndex==1)
		{
			cota1+=getcotafromstring($("input[name=pf_cota]").val());
			$("input[name=pf_cota]").val(cota1+100-cotafinala);
		}
		else
		if($("select[name=tipproprietar]")[0].selectedIndex==2)
		{
			cota1+=getcotafromstring($("input[name=pj_cota]").val());
			$("input[name=pj_cota]").val(cota1+100-cotafinala);
		}
		return false;
	}
}

function calculeazaNrZile()
{
	if($("input[name=panalavalabilitate]").val()=="") {$("input[name=nrzile]").val('');return;}
	if($("input[name=datavalabilitate]").val()=="") {$("input[name=nrzile]").val('');return;}
	var arr=$("input[name=panalavalabilitate]").val().split('.');
	var d1 = new Date(arr[2], parseFloat(arr[1])-1, arr[0]);

	arr=$("input[name=datavalabilitate]").val().split('.');
	var d2 = new Date(arr[2], parseFloat(arr[1])-1, arr[0]);

	var one_day=6*6*24;
	days=Math.round((d1.getTime()/100000-d2.getTime()/100000)/(one_day))+1;
	$("input[name=nrzile]").val(days);
}

function clienticalculeazascore()
{
	var score=0;
	var options = document.forms['work'];
	for(i = 0; i < options.length; i++)
	{
		var opt = options[i];
		if(opt.type=="radio")
		{
			if(opt.checked)
			{
				score+=parseInt(opt.value);
			}
		}
	}
	$("input[name=clscore]").val(score);
}

function pregatesteAutocomplete(el,nume,lknume,lksector)
{
	var loc="";
	var torepl='';
	if(el.val()=="bucuresti")
	{
		loc='BUCURESTI';
	}
	else
	{
		if(lksector!="" && $("select[name="+lksector+"]").length)
		{
			$("select[name="+lksector+"]")[0].selectedIndex=0;
		}
	}
	el=$("[name="+lknume+"]");
	if(el.attr("lk"+lknume))
	{
		torepl=el.attr("lk"+lknume).replace("["+nume+"]",$("[name="+nume+"]").val());
		if(torepl!=el.attr("lk"))
		{
			el.val(loc);
		}
		el.attr("lk",torepl);
	}
	else
	{
		el.attr("lk"+lknume,el.attr("lk"));
		torepl=el.attr("lk"+lknume).replace("["+nume+"]",$("[name="+nume+"]").val());
		el.attr("lk",torepl);
	}
}

function reloadViewport()
{
<?php if(getUserConfig("mobilewidth")!=""){?>
		var mvp = document.getElementById('testViewport');
		if(mvp) mvp.setAttribute('content','width=<?php echo getUserConfig("mobilewidth");?>,initial-scale='+$(window).width()/<?php echo getUserConfig("mobilewidth");?>);
<?php } else { ?>

		if($(window).width()<600)
		{
			//alert($(window).width());
			var mvp = document.getElementById('testViewport');
			if(mvp) mvp.setAttribute('content','width=189,initial-scale='+$(window).width()/189);
		}
		else
		{
			var mvp = document.getElementById('testViewport');
			if(mvp) mvp.setAttribute('content','width=598,initial-scale='+$(window).width()/598);
		}

<?php }?>

}

$(document).bind('slotReloaded',function(event,data){
	reloadValidators("#"+data);
});

$(document).ready(function(){

	setTimeout("reloadViewport()",500);
<?php if(getUserConfig("mobilewidth")==""){?>
	if($(window).width()<600)
	{
		formularecomplete=false;
		$("#sidebarload").hide();
	}
<?php }?>

	$("#savebutton").removeAttr("disabled");
	reloadValidators("#work");


});

function updateCells()
{
	var SA=parseFloat($("input[name=sumaasigurata]").val());
	var AC=parseFloat($("input[name=anconstructie]").val());
	$("*[crule]").each(function(){
		var afrule=0;
		eval($(this).attr("crule"));
		afrule=afrule.toFixed(0);
		$(this).html(""+afrule+" EURO");
	});
}
</script>
<?php
	if(getUserConfig('projectid')!="")
	{
		?>
<?php
function getColorFromParameter($p,$d)
{
	$valret=session_getvalue("colors_".$p);
	if($valret=="") $valret=$d;
	if(isset($_GET[$p]) && $_GET[$p]!="")
		$valret='#'.substr($_GET[$p],0,6);
	session_setvalue("colors_".$p,$valret);
	return $valret;
}
?>
<style>
#ofertatarife * {text-shadow:none;}

.backbody
{
background-color:<?php echo getColorFromParameter('f',"white");?>
}

#ofertatarife
{
}

#ofertatarife input,#ofertatarife select,#ofertatarife button,#ofertatarife .option0
{
	color: <?php echo getColorFromParameter('c_c',"black");?>;
	background-color:<?php echo getColorFromParameter('c_f',"white");?>;
}

#ofertatarife td
{
	padding: 2px;
	font-size: 12px;
	color:<?php echo getColorFromParameter('t_c',"black");?>;
}
#ofertatarife th
{
	padding: 2px;
	font-size: 12px;
	font-weight: bold;
	color:<?php echo getColorFromParameter('t_c',"black");?>;
}
#ofertatarife td.ofertatarifoptiuni
{
	font-size: 12px;
}

#ofertatarife tr.ofertaheader th
{
	background-color: <?php echo getColorFromParameter('i_f',"ddd");?>;
	color:<?php echo getColorFromParameter('i_c',"black");?>;
}

#ofertatarife b.ofertatarifactive
{
	color: blue;
}
#ofertatarife a.option
{
	width: 55px;
	display: inline-block;
	text-align:center;
	height:15px;
}

#tarifaroffer
{
	padding-bottom: 10px;
}

#ofertatarife,table.tarifarofertarca
{
	width:700px;
}

#ofertatarife .validateatention
{
	color: <?php echo getColorFromParameter('a_c',"black");?>;
	background-color: <?php echo getColorFromParameter('a_f',"yellow");?>;
}
</style><?php
}
?>
