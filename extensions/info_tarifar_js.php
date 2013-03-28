<script>
function reloadCalendar()
{
	$("a.calendarsel").unbind("click").click(function(){
		global_cal.select($(this).prev()[0].form[$(this).attr("forelem")],$(this).attr("forelem"),'<?php echo getLT("dateformat");?>');
		return false;
	});
}
function calendar_finished(y,m,d)
{
	CP_tmpReturnFunction(y,m,d);
	$(window.CP_targetInput).change();
}
var steper_lastid=1;
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
		$(this).parent().css("background-color","<?php echo getUserConfig("active_color");?>");
		$("input[name=tarif]").val($(this).attr("tarif"));
		$("input[name=p_soc]").val($(this).attr("socid"));
		$("input[name=p_per]").val($(this).attr("per"));
		return false;
	});
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
<?php
if(file_exists("extensions/info_tarifar_rca.php") && $_GET['t']=="rca" && $_GET['nd']=="yes")
{
	?>return true;<?php
}
?>
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
				if(typeof(Storage)!=="undefined")
				{
					$(this).add("input[type!=hidden]",this).add("select",this).each(function(){
						if($(this).attr("name")=="tarif") return true;
						if(localStorage['t_'+$(this).attr("name")]!="")
						{
							$(this).val(localStorage['t_'+$(this).attr("name")]);
							mustreload=true;
						}
					});
				}

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
	$("[title]").tipsy({gravity:'n',opacity:0.8});
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
			if(a.substr(0,4)=="link")
			{
				var arr=a.split("_");
				var mya;
				mya="site.php?t="+arr[1]+"&offid="+arr[2];
				$("div.sidebarbutton_"+arr[1]).append('<a href="'+localStorage[a]+'">'+arr[2]+'&nbsp;</a><br>');
			}
		}
	}

}

function slotLoadedUpdateWindow(slot){
	$("#loading").hide();
	$(document).trigger('slotReloaded',slot);
	reloadCalendar();
	reloadAutocomplete();
	reloadSteper(true);
	reloadTips();
	reloadSideLinks();
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
	reloadSteper(true);
	reloadTips();
	reloadSideLinks();



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
