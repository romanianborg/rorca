<script>
function reloadCalendar()
{
	$("a.cdateselect").each(function(){
		var link=$(this);
		$(this).prev().one("click",function(){
			link.click();
		});
	});
}
function calendar_finished(y,m,d)
{
	CP_tmpReturnFunction(y,m,d);
	$(window.CP_targetInput).change();
}
var steper_lastid=1;
function clickPlataInRate(tarif,btn)
{
	$("#tab_platainrate").click();
	$("input[name=tarif]").val(tarif).change();

	$("input[name=p_soc]").val($(btn).attr("socid"));
	$("input[name=p_per]").val($(btn).attr("per"));
	
	$("#soctarife").hide(1000,function(){
		$("input[name=tarif]").focus();
	});
	$("#tab_plataonline").parent().hide();
	$("#tarifalesspan").html("Plata in rate");

	$("option.fararate").hide();
	$("option.doarrate").show();

	if($("select[name=tipplata]").length) $("select[name=tipplata]")[0].selectedIndex=0;
	$("select[name=tipplata]").change().focus();

	if($("select[name=ce_rate]").length) $("select[name=ce_rate]")[0].selectedIndex=1;
	if($("select[name=optrate]").length) $("select[name=optrate]")[0].selectedIndex=1;
	if($("select[name=uni_rate]").length) $("select[name=uni_rate]")[0].selectedIndex=1;
	$("input[name=tipplata]").focus();

	if($(btn).attr("per")=="6")
	{
		$("option.doarintegral").hide();
	}
	else
	{
		$("option.doarintegral").show();
	}


	return false;
}
function clickPlataIntegral(tarif,btn)
{
	$("#tab_plataonline").click();

	$("input[name=tarif]").val(tarif).change();

	$("input[name=p_soc]").val($(btn).attr("socid"));
	$("input[name=p_per]").val($(btn).attr("per"));

	$("#soctarife").hide(1000,function(){
		$("input[name=tarif]").focus();
	});
	$("#tab_platainrate").parent().hide();
	$("#tarifalesspan").html("Plata cu reducere");

	$("option.fararate").show();
	$("option.doarrate").hide();

	if($("select[name=tipplata]").length) $("select[name=tipplata]")[0].selectedIndex=0;
	$("select[name=tipplata]").change();

	if($("select[name=ce_rate]").length) $("select[name=ce_rate]")[0].selectedIndex=0;
	if($("select[name=optrate]").length) $("select[name=optrate]")[0].selectedIndex=0;
	if($("select[name=uni_rate]").length) $("select[name=uni_rate]")[0].selectedIndex=0;
	

	$("input[name=tipplata]").focus();

	return false;
}
function alegeTarifIar()
{
	$("input[name=tarif]").val('').change();

	$("#soctarife").show("fast");

	$("#tab_platainrate").parent().show();
	$("#tab_plataonline").parent().show();
	$("#tarifalesspan").html("Tarif ales");
}

function reloadSteperTarife()
{
	if(!$("a.incarcatarife").length)
	{
		$("#loadingtarifeimg").hide();
		$("#loadingtarifemesaj").show();
	}
	else
	{
		$("#loadingtarifeimg").show();
		$("#loadingtarifemesaj").hide();
	}
	$("#work td.worktarif a").unbind('click').click(function(){
		$("#work td.worktarif").css("background-color","white");
		$(this).parent().css("background-color","<?php echo getUserConfig("current_color");?>");
		$("input[name=tarif]").val($(this).attr("tarif")).change();
		$("input[name=p_soc]").val($(this).attr("socid"));
		$("input[name=p_per]").val($(this).attr("per"));
		return false;
	})
}
function reloadSteperPolita()
{
	if($("a.incarcapolitaeroare").length)
	{
		$("#loadingpolitaimg").hide();
		$("#loadingpolitamesaj").hide();
		$("#loadingpolitaeroare").show();
	}
	else
	if(!$("a.incarcapolita").length)
	{
		$("#loadingpolitaimg").hide();
		$("#loadingpolitamesaj").show();
		$("#loadingpolitaeroare").hide();
	}
	else
	{
		$("#loadingpolitaimg").show();
		$("#loadingpolitamesaj").hide();
		$("#loadingpolitaeroare").hide();
	}
}

function reloadSteper(slot)
{
	//bind calendar
	global_cal.setReturnFunction("calendar_finished");
	//$("#workprogress_step").animate({width:"20%"});
	if(slot) $("div.workstep").hide();

	loadOneStep();
	//check load link
	if($("input[name=offid]").length)
	{
		if(typeof(Storage)!=="undefined")
		{
			localStorage['link_'+$("input[name=tipoferta]").val()+'_'+$("input[name=offid]").val()]=location.href;
		}
	}
	$("a.incarcatarife").each(function(){
		$("#soctarife").load($(this).attr("href"),function(){
			//save offer for later usage
			setTimeout("reloadSteper()",3300);
			setTimeout("reloadSteperTarife()",100);
		});
	});
	$("a.incarcapolita").each(function(){
		$("#offpolita").load($(this).attr("href"),function(){

			setTimeout("reloadSteper()",3300);
			setTimeout("reloadSteperPolita()",100);
		});
	});
	$("a.wakeupcall").each(function(){
		$("#wakeupcall").load($(this).attr("href"),function(){
		});
	});
	$("form.autosubmitform").each(function(){
		$(this).submit();
	});
}
var formularecomplete=<?php echo (getUserConfig("tarifarcomplet")=="yes")?'true':'false';?>;

function loadOneStep(buttonclick)
{
	var ret=true;
	var allvalid=true;
	var nextstep;
	var foundone=false;

	$("div.workstep").each(function(){
		if($(this).attr("chvalid") && $(this).attr("chvalid")=="yes")
		{
			//ignore
			return true;
		}
		if($(this).parent().attr("id") && !isElementVisible($(this).parent()))
		{
			//ignore
			return true;
		}
		if(!isElementVisible($(this)) && $(this).css("display")!="block")
		{
			nextstep=this;
			foundone=true;
			return false;
		}
		var valid=true;
		$(this).find(".validated").each(function(){
			if(!validateFieldRule($(this),{},$(this).attr("validate")))
			{
				$(this).css("background-color", "<?php echo getUserConfig("alert_color");?>");
				ret=false;
				valid=false;
				allvalid=false;
			}
			else
			{
				$(this).css("background-color", "white");
				valid=true;
			}
		});
		if(valid)
		{
			//save all
			$(this).attr("chvalid","yes");
			if(typeof(Storage)!=="undefined")
			{
				$(this).find("input[type!=hidden]").add("select",this).each(function(){
					if($(this).attr("name")=="tarif") return true;
					localStorage['t_'+$(this).attr("name")]=$(this).val();
				});
			}
		}
		if(!valid && !formularecomplete)
		{
			nextstep=this;
			foundone=true;
			return false;
		}
	});

	if($("#worknext a").html()==$("input[name=textbutton]").val())
	{
		if(ret)
		{
			if($("input[name=automaticsubmit]").val()=="true" || buttonclick=="button")
			{
				$("form[name=work]").submit();
				$("#worksteps").hide();
				$("#workloading").show();
				return false;
			}
		}
		else
		{
			if(buttonclick=="button")
			{
				alert("Va rugam sa verificati toate campurile. Cele marcate au probleme de completare.");
				return false;
			}
		}
	}

	if(nextstep)
	{
		var mustreload=false;
		if(!isElementVisible($(nextstep)))
		{
			$(nextstep).show().each(function(){

				if($(this).is(":visible"))
				{
					$(this).find("input").focus().unbind("change").bind("change",function(){
						$(nextstep).attr("chvalid","");
						loadOneStep();
					});
					$(this).find("select").focus().unbind("change").bind("change",function(){
						$(nextstep).attr("chvalid","");
						loadOneStep();
					});
				}
			});
		}
		if(formularecomplete)
			mustreload=true;
		if(mustreload)
		{
			setTimeout("loadOneStep()",10);
		}
	}

	if(!foundone)
	{
		$("#worknext").show();
		$("#worknext a").html($("input[name=textbutton]").val());
		if(allvalid && $("#worknext").length) $.scrollTo($("#worknext")[0],1000);
		$("#myremedy").remove();//solves a weird chrome bug

		if($("input[name=action]").val()=="PlataOk")
		{
			$("#worknext a").attr("onclick","return false;");
		}
		return false;
	}
	return false;
}
function reloadTips()
{
	$("[title]").tipsy({gravity:'sw',opacity:0.8});
}
function slotLoadingCreateWindow(slot){
	$("#loading").show();
}
function reloadSideLinks()
{
	if(typeof(Storage)!=="undefined")
	{
		var a;
		for(a in localStorage)
		{
			if(a.substr(0,4)=="link" && localStorage[a]!='no')
			{
				var arr=a.split("_");
				var mya;
				mya="site.php?t="+arr[1]+"&offid="+arr[2];
				$("div.sidebarbutton_"+arr[1]).append('<a href="'+localStorage[a]+'">'+arr[2]+'&nbsp;</a><a href="#" onclick="localStorage['+"'"+a+"'"+']='+"'"+'no'+"'"+';$(this).prev().remove();$(this).next().remove();$(this).remove();return false;"><img width=12 src="images/x.png" border=0></a><br>');
				//localStorage[a]='no';
			}
		}
	}
	<?php if(getUserConfig("notificare_plecare")!="")
	{?>
		$("body").mouseleave(function(){
			$("#notificare_plecare").show();
			var pos=$("#work").position();
			$("#notificare_plecare").css("left",""+pos.left+"px");
		});
		$("body").mouseenter(function(){
			$("#notificare_plecare").hide();
		});
		<?php
	}
	?>
}
function remoteAllLinks()
{
	if(typeof(Storage)!=="undefined")
	{
		var a;
		for(a in localStorage)
		{
			if(a.substr(0,4)=="link" && localStorage[a]!='no')
			{
				localStorage[a]='no';
			}
		}
	}
}

function slotLoadedUpdateWindow(slot){
	$("#loading").hide();
	$(document).trigger('slotReloaded',slot);
	reloadCalendar();
	reloadAutocomplete();
	reloadTips();
	reloadSideLinks();
}
function initializeForElements(it)
{
	var d;
	for(d in it)
	{
		if(document.forms['work'][''+d]==undefined) continue;
		if(document.forms['work'][''+d].type && document.forms['work'][''+d].type.toLowerCase()=="checkbox")
		{
			if(it[''+d]=="1")
			{
				document.forms['work'][''+d].checked=true;
			}
			else
			{
				document.forms['work'][''+d].checked=false;
			}
		}
		else
		if(document.forms['work'][''+d].type==undefined)
		{
			var ii;
			for(ii=0;ii<document.forms['work'][''+d].length;ii++)
			{
				
				if(document.forms['work'][''+d][ii].value==it[''+d])
				{
					document.forms['work'][''+d][ii].checked=true;
				}
			}
		}
		else
		if(document.forms['work'][''+d].type=="select-one")
		{
			var idx=select_findIndex($(document.forms['work'][''+d]),it[''+d]);
			document.forms['work'][''+d].selectedIndex=idx;
		}
		else
		{
			$(document.forms['work'][''+d]).val(it[''+d]).change();
		}
	}
}
function correctHtmlDataForJS(s)
{
	return s.replace(/&amp;/gi, "&").replace(/&gt;/gi, ">").replace(/&lt;/gi, "<").replace(/&quot;/gi, "\"");
}
function reloadForDatas()
{
	$("div.formdata").each(function(){
		if($(this).attr("loadedonce")!="yes")
		{
			$(this).attr("loadedonce","yes");
				eval("initializeForElements("+correctHtmlDataForJS($(this).html())+")");
		}
	});
}

document.globalSlotLoading="slotLoadingCreateWindow";
document.globalSlotReloaded="slotLoadedUpdateWindow";
document.ajaxifyDefaultSlot="work";
$(document).ready(function(){

	reloadLinks("");
	$("a.option").unbind("click");
	initAjaxifyHistory();
	reloadCalendar();
	reloadAutocomplete();
	reloadTips();
	reloadSideLinks();
	reloadForDatas();

$.fn.extend({ 
	showAndScroll: function() { 
	//	$(this).show(); 
	//	if( $(this).position()['top'] ) 
	//	window.scrollTo(0, $(this).position()['top']);
		return $(this).show(); 
	} 
}); 

});


</script>
