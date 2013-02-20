{
	if(!el) return 0;
	var idx=0;
	var i=0;
	var s=n.toLowerCase();
	el.children("option").each(function(){
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
function validateRule(el,ev,rule,start,rev)
{
	var i;
	if(start>=rule.length) return true;
	switch(rule[start])
	{
		case 'get':
			var allru=rule[start+1];
			for(i=start+2;i<rule.length;i++)
			{
				$("[name="+allru+rule[i]+"]").each(function(){
					var aprule=$(el[0].options[el[0].selectedIndex]).attr(rule[i]);
					if(aprule && aprule!="")
					{
						if($(this)[0].tagName.toLowerCase()=="select")
						{
							$(this)[0].selectedIndex=select_findIndex($(this),aprule);
						}
						else
						{
							$(this).val(aprule);
						}
					}
				});
			}
			break;
		case 'copy':
			if(el.is(":visible"))
			{
				var newel=$("[name="+rule[start+1]+"]");
				newel.val(el.val());
			}
			break;
		case 'same':
			if(el.is(":visible"))
			{
				var newel=$("[name="+rule[start+1]+"]");
				el.val(newel.val());
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
			if(!el.is(":visible")) break;
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
					if(curmon<parseFloat(mm) || (curmon==parseFloat(mm) && curday<parseFloat(dd)))
					{
						plusone=1;
					}
					varsta=curyear%100-parseInt(yy)%100;
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
			if(newel.is(":visible"))
			{
				if(!validateFieldRule(newel,ev,newel.attr("validate")))
					return false;
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
		case 'replace':
			var v=el.val();
			for(i=start+1;i<rule.length;i++,i++)
			{
				var re=new RegExp(rule[i],"gi");
				el.val(v.replace(re,rule[i+1]));
				v=el.val();
			}
		break;
		case 'call':
			eval(''+rule[start+1]+'()');
		break;
		case 'addmonths':
			$("#"+rule[start+1]).val(calendarAutomaticCalculateEndDate($("#"+rule[start+2]).val(),el.val(),'dd.MM.yyyy'));
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
							if(el.is(":visible") && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'max':
						if(el.val().length>parseFloat(rule[start+2]))
						{
							bck=true;
							if(el.is(":visible") && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'minmax':
						if(el.val().length>parseFloat(rule[start+3]) || el.val().length<parseFloat(rule[start+2]))
						{
							bck=true;
							if(el.is(":visible") && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'min':
						if(el.val().length<parseFloat(rule[start+2]))
						{
							bck=true;
							if(el.is(":visible") && (!ev || !ev.keyCode)) ret=false;
						}
					break;
					case 'cnp':
						var cnp=el.val();
						if(cnp.length!=13) {bck=true;if(el.is(":visible")) ret=false;}
						if(cnp=="0000000000000") {bck=true;if(el.is(":visible")) ret=false;}

						var sum;
						sum=parseInt(cnp.substr(0,1))*2 + parseInt(cnp.substr(1,1))*7 + parseInt(cnp.substr(2,1))*9 + parseInt(cnp.substr(3,1))*1 + parseInt(cnp.substr(4,1))*4 + parseInt(cnp.substr(5,1))*6 + 
							 parseInt(cnp.substr(6,1))*3 + parseInt(cnp.substr(7,1))*5 + parseInt(cnp.substr(8,1))*8 + parseInt(cnp.substr(9,1))*2 + parseInt(cnp.substr(10,1))*7 +parseInt(cnp.substr(11,1))*9;

						var control = sum % 11;
						if(control == 10) control = 1;
						if (control != parseInt(cnp.substr(12,1))) {bck=true;if(el.is(":visible") && (!ev || !ev.keyCode)) ret=false;}
					break;
					case 'cui':
						var cnp=el.val();
						if(cnp.length>10) {bck=true;if(el.is(":visible")) ret=false;}
						if(cnp.length<2) {bck=true;if(el.is(":visible")) ret=false;}
						if(parseInt(cnp)==0) {bck=true;if(el.is(":visible")) ret=false;}

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
						if (control != parseInt(cnp.substr(cnp.length-1,1))) {bck=true;if(el.is(":visible") && (!ev || !ev.keyCode)) ret=false;}
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
							if(el.is(":visible") && (!ev || !ev.keyCode)) ret=false;
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
