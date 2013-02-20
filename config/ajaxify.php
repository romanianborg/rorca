<?php
//require_once("config/textarea.php");
require_once("config/layers.php");
require_once("config/calendar.php");
require_once("config/blockenter.php");
require_once("config/autocomplete.php");
require_once("config/jquery.php");
require_once("config/sheet.php");
ob_start();?><script>
document.globalSlotReloaded="";
document.globalSlotLoading="";
var ajaxifyHistory=false;
var ajaxifyHistoryTimer=false;
var ajaxifyHistoryUrls=new Array();
var ajaxifyHistorySlots=new Array();
var ajaxifyHistoryCurrent=0;
var ajaxifyHistoryBase=0;
var ajaxifyHistoryMax=20;
var ajaxifyHistorySkip=0;
var ajaxifyEnableFocus=1;
document.ajaxifyDefaultSlot="work";
function getDivName(url)
{
	if(!url) return '';
	if(url.indexOf("?")>=0)
	{
		pos=url.indexOf("s=");
		if(pos>=0)
		{
			url=url.slice(pos+2);

			pos=url.indexOf("&");
			if(pos>=0)
			{
				url=url.slice(0,pos);
				return url;
			}
			pos=url.indexOf("#");
			if(pos>=0)
			{
				url=url.slice(0,pos);
				return url;
			}

			return url;
		}
		pos=url.indexOf("change=");
		if(pos>=0)
		{
			url=url.slice(pos+7);
			pos=url.indexOf("&");
			if(pos>=0)
			{
				url=url.slice(0,pos);
				return url;
			}
			pos=url.indexOf("#");
			if(pos>=0)
			{
				url=url.slice(0,pos);
				return url;
			}
			return url;
		}
	}
	return document.ajaxifyDefaultSlot;

}
function getAjaxParameters()
{
	return "&ajax=1&protection="+currentPageProtection;
}
function getUrlNoDie(url)
{
	if(url.indexOf("#")>=0)
	{
		url=url.substr(0,url.indexOf("#"));
		return url+getAjaxParameters();
	}
	if(url.indexOf("?")>=0)
		return url+getAjaxParameters();
	return url+'?s='+document.ajaxifyDefaultSlot+getAjaxParameters();
}
function getUrlNoParas(url)
{
	var firstone=-1;
	if(url.indexOf("?")>=0)
	{
		firstone=url.indexOf("?");
	}
	if(url.indexOf("#")>=0)
	{
		if(firstone>=0 && url.indexOf("#")>firstone)
			return url.substr(0,url.indexOf("?"));
		return url.substr(0,url.indexOf("#"));
	}
	if(firstone>=0)
	{
		return url.substr(0,url.indexOf("?"));
	}
	return url;
}
function getUrlNoAnchor(url)
{
	if(url.indexOf("#")>=0)
	{
		url=url.substr(0,url.indexOf("#"));
		return url;
	}
	return url;
}
function getUrlAnchorName(url)
{
	if(url.indexOf("#")>=0)
	{
		url=url.substr(url.indexOf("#")+1);
		return url;
	}
	return "";
}
function getUrlForSlotAndAjax(oldurl)
{
	var newurl=getUrlNoAnchor(oldurl);
	var slot=getDivName(oldurl);
	if(newurl.indexOf("?")>=0)
	{
		if(newurl.indexOf("change=")>=0 || newurl.indexOf("s=")>=0)
		{
			newurl=getUrlNoParas(location.href);
			newurl+="?s="+slot+getAjaxParameters();
		}
		else
			newurl+="&s="+slot+getAjaxParameters();
	}
	else
	{
		newurl+="?s="+slot+getAjaxParameters();
	}
	return newurl;
}
function toAjaxHistoryBack()
{
	var newposition=parseInt(getUrlAnchorName(location.href))-1;
	if(newposition>0 && ajaxifyHistorySkip==0)
	{
		location.href=getUrlNoAnchor(location.href)+"#"+newposition;
		checkForAjaxifyBackForwardButtons();
	}
	else
	{
		if(ajaxifyHistorySkip) ajaxifyHistorySkip--;
	}
}
function checkForAjaxifyBackForwardButtons()
{
	if(getUrlAnchorName(location.href)!="")
	{
		var newposition=parseInt(getUrlAnchorName(location.href));
		if((newposition+1)!=ajaxifyHistoryCurrent)
		{
			if((newposition-ajaxifyHistoryBase)>=0 && (newposition-ajaxifyHistoryBase)<ajaxifyHistorySlots.length)
			{
				var slot=ajaxifyHistorySlots[newposition-ajaxifyHistoryBase];
				if(document.globalSlotLoading!="") eval(""+document.globalSlotLoading+"('"+slot+"');");
				else $("div[id="+slot+"]").prepend('<img src="images/loading.gif">');
				ajaxifyHistoryCurrent=newposition+1;
				$.get(ajaxifyHistoryUrls[newposition-ajaxifyHistoryBase],function(data){
					if(data.substr(0,9)=="redirect:")
					{
						parent.location.href=data.substr(9);
						return;
					}
					if(data.substr(0,6)=="error:")
					{
						showGlobalError(data.substr(6));
						return;
					}
					if(data.substr(0,5)=="slot:")
					{
						var arr=data.indexOf("$");
						slot=data.substr(5,arr-5);
						$("div[id="+slot+"]").html(data.substr(arr+1));
					}
					else
					{
						$("div[id="+slot+"]").html(data);
					}
					reloadLinks(slot);
					if(document.globalSlotReloaded!="") eval(""+document.globalSlotReloaded+"('"+slot+"');");
				});
			}
		}
	}
	setTimeout("checkForAjaxifyBackForwardButtons();",300);
}
function initAjaxifyHistory()
{
	ajaxifyHistory=true;
	if(history.pushState)
	{
		$(window).bind('popstate', function (event)
		{
			var myurl = event.originalEvent.state;
			if(!myurl) return;
				var slot=getDivName(myurl);
				if(document.globalSlotLoading!="") eval(""+document.globalSlotLoading+"('"+slot+"');");
				else $("div[id="+slot+"]").prepend('<img src="images/loading.gif">');
				$.get(myurl,function(data){
					if(data.substr(0,9)=="redirect:")
					{
						parent.location.href=data.substr(9);
						return;
					}
					if(data.substr(0,6)=="error:")
					{
						showGlobalError(data.substr(6));
						return;
					}
					if(data.substr(0,5)=="slot:")
					{
						var arr=data.indexOf("$");
						slot=data.substr(5,arr-5);
						$("div[id="+slot+"]").html(data.substr(arr+1));
					}
					else
					{
						$("div[id="+slot+"]").html(data);
					}

					reloadLinks(slot);
					if(document.globalSlotReloaded!="") eval(""+document.globalSlotReloaded+"('"+slot+"');");
				});
		});
		//addEvent(window, 'hashchange', function (event) {});
		//addEvent(window, 'pageshow', function (event) {});
		//addEvent(window, 'pagehide', function (event) {});

	}
}
function reajaxifyHistory()
{
	if((ajaxifyHistoryCurrent-ajaxifyHistoryBase)>ajaxifyHistoryMax)
	{
		for(i=0;i<ajaxifyHistoryMax;i++)
		{
			ajaxifyHistoryUrls[i]=ajaxifyHistoryUrls[i+1];
			ajaxifyHistorySlots[i]=ajaxifyHistorySlots[i+1];
		}
		ajaxifyHistoryBase++;
	}
}
function redirectClick(alink)
{
	var slot;
	slot=getDivName(alink.attr("href"));
	$("a.option").removeClass("selected");alink.addClass("selected");
	if(ajaxifyHistory)
	{
		if(history.pushState && !window.nocopylink)
		{
			history.pushState(getUrlNoDie(alink.attr("href")),null,alink.attr("href"));
		}
		else
		{
			if(!ajaxifyHistoryTimer) setTimeout("checkForAjaxifyBackForwardButtons();",200);
			ajaxifyHistoryTimer=true;
			reajaxifyHistory();
			ajaxifyHistoryUrls[ajaxifyHistoryCurrent-ajaxifyHistoryBase]=getUrlNoDie(alink.attr("href"));
			ajaxifyHistorySlots[ajaxifyHistoryCurrent-ajaxifyHistoryBase]=slot;
			location.href=getUrlNoAnchor(location.href)+"#"+ajaxifyHistoryCurrent+(window.nocopylink?'':'-go-'+alink.attr("href"));
			ajaxifyHistoryCurrent++;
		}
	}
	else
	{
		location.href=getUrlNoAnchor(location.href)+"#"+slot+(window.nocopylink?'':'-go-'+alink.attr("href"));
	}
	if(document.globalSlotLoading!="") eval(""+document.globalSlotLoading+"('"+slot+"');");
	else $("div[id="+slot+"]").prepend('<img src="images/loading.gif">');
	$.get(getUrlNoDie(alink.attr("href")),function(data){
		if(data.substr(0,9)=="redirect:")
		{
			parent.location.href=data.substr(9);
			return;
		}
		if(data.substr(0,6)=="error:")
		{
			showGlobalError(data.substr(6));
			return;
		}
		if(data.substr(0,5)=="slot:")
		{
			var arr=data.indexOf("$");
			slot=data.substr(5,arr-5);
			$("div[id="+slot+"]").html(data.substr(arr+1));
		}
		else
		{
			$("div[id="+slot+"]").html(data);
		}
		reloadLinks(slot);
		if(document.globalSlotReloaded!="") eval(""+document.globalSlotReloaded+"('"+slot+"');");
	})
	return false;
}
document.GlobalReloadSlot="";
function checkSlots()
{
	var slot;
	if(document.GlobalReloadSlot!="")
	{
		var pos=document.GlobalReloadSlot.indexOf("$");
		while(pos>=0)
		{
			slot=document.GlobalReloadSlot.substring(1,pos);
			if(document.GlobalReloadSlot==document.GlobalReloadSlot.replace(RegExp(","+slot+"\\$","gi"), ""))
			{
				//error
			}
			else
			{
				document.GlobalReloadSlot=document.GlobalReloadSlot.replace(RegExp(","+slot+"\\$","gi"), "");
				var newurl;
				newurl=getUrlNoParas(location.href);
				newurl+="?s="+slot+getAjaxParameters();

				$.get(newurl,function(data){
					if(data.substr(0,9)=="redirect:")
					{
						parent.location.href=data.substr(9);
						return;
					}
					if(data.substr(0,6)=="error:")
					{
						showGlobalError(data.substr(6));
						return;
					}
					if(data.substr(0,5)=="slot:")
					{
						var arr=data.indexOf("$");
						slot=data.substr(5,arr-5);
						$("div[id="+slot+"]").html(data.substr(arr+1));
					}
					else
					{
						$("div[id="+slot+"]").html(data);
					}
					reloadLinks(slot);
					if(document.globalSlotReloaded!="") eval(""+document.globalSlotReloaded+"('"+slot+"');");
					});
			}
			pos=document.GlobalReloadSlot.indexOf("$");
		}
	}
	else
	{
		//wait for more
		//setTimeout("checkSlots()",100);
	}
}
//setTimeout("checkSlots()",200);
function reloadSlot(slot)
{
	document.GlobalReloadSlot+=","+slot+"$";
	checkSlots();
}
function iframeLoadedStep1()
{
	$("iframe.loaditin").each(function(){
		if(frames[$(this).attr("name")].document.getElementsByTagName('textarea')[0])
		{
			$(this).attr("class","freeloaditin");
			data=frames[$(this).attr("name")].document.getElementsByTagName('textarea')[0].value;
			eval(data);
		}
		else
		{
			setTimeout("iframeLoadedStep1()",200);
		}
	});
}
function iframeLoaded() {
	setTimeout("iframeLoadedStep1()",0);
}
function showGlobalError(error)
{
	if(alerterror) alerterror(error);
	else alert(error);
}
function redirectSubmits(fo)
{
	var slot;
	if(fo.attr("callmefirst") && fo.attr("callmefirst")!="")
	{
		var ret=window[fo.attr("callmefirst")](fo);
		if(!ret) return false;
	}
	if(fo.attr("action")=="" || fo.attr("action")==undefined)
		fo.attr("action",location.href);
	slot=getDivName(fo.attr("action"));
	if(fo.attr("target")!=undefined && fo.attr("target")!='')
	{
		if($("iframe[name="+fo.attr("target")+"]").attr("class")=="loaditin")
		{
			//we need another iframe here
		}
		else
		{
			$("iframe[name="+fo.attr("target")+"]").attr("class","loaditin");
			if(tinyMCE) tinyMCE.triggerSave();
			return true;
		}
	}
	if(slot!="")
	{
		//ajaxify
		//loding progress
		if(document.globalSlotLoading!="") eval(""+document.globalSlotLoading+"('"+slot+"');");
		else $("div[id="+slot+"]").prepend('<img src="images/loading.gif">');
		//create new target
		if(tinyMCE) tinyMCE.triggerSave();
		var newaction_=getUrlForSlotAndAjax(fo.attr("action"));
		fo.attr("action",newaction_);

		//check for a free iframe;
		if($("iframe.freeloaditin").size()>0)
		{
			$("iframe.freeloaditin").slice(0,1).each(function(){
				$(this).attr("class","loaditin");
				fo.attr("target",$(this).attr("name"));
			});
		}
		else{
			ourDate = new Date();
			id='iframehidden'+ourDate.getTime();
			fo.attr("target",id);

			//create iframe and get load event
			var $io = $('<iframe slotname="'+slot+'" class="loaditin" id="' + id + '" name="' + id + '" />');
			var io = $io[0];
			var op8 = $.browser.opera && window.opera.version() < 9;
			if ($.browser.msie || op8) io.src = 'javascript:false;document.write("");';
			$io.css({ position: 'absolute', top: '-1000px', left: '-1000px' });
			$io.appendTo('body');
			io.attachEvent ? io.attachEvent('onload', iframeLoaded) : io.addEventListener('load', iframeLoaded, false);
		};
		return true;
	}
	if(tinyMCE) tinyMCE.triggerSave();
	return true;
}
function reloadLinks(slot)
{
	if(slot=="")
	{
		$("a.option").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("a.listorder").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("a.menu").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("a.selmenu").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("form").each(function(){
				if($(this).hasClass("freeform")) return true;
				var funt=undefined;
				if($(this).attr("onsubmit")!=undefined)
				if($(this).attr("onsubmit").substr(0,24)=="javascript:var f;f=this;")
				{
					eval("funt=function(f){"+$(this).attr("onsubmit").substr(24)+"return true;}");
					$(this).attr("onsubmit","");
				}
				$(this).unbind("submit").submit(function(){
					if((funt==undefined) || funt($(this)[0]))
						return redirectSubmits($(this));
					return false;
				})
			});
		$("table.sheet").each(function(){
			var elname=$(this).attr("id");
			$("#"+$(this).attr("id")+" tr td input").unbind("keydown").bind("keydown",function(){
				$(this).autoGrowInput({comfortZone:20});
				checkSheetBounderies($(this),elname);
			});
		});
	}
	else
	{
		$("#"+slot+" a.option").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("#"+slot+" a.listorder").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("#"+slot+" a.menu").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("#"+slot+" a.selmenu").unbind("click").click(function(){
			return redirectClick($(this));
			});
		$("#"+slot+" form").each(function(){
				if($(this).hasClass("freeform")) return true;
				var funt=undefined;
				if($(this).attr("onsubmit")!=undefined)
				if($(this).attr("onsubmit").substr(0,24)=="javascript:var f;f=this;")
				{
					eval("funt=function(f){"+$(this).attr("onsubmit").substr(24)+"return true;}");
					$(this).attr("onsubmit","");
				}
				$(this).unbind("submit").submit(function(){
					if((funt==undefined) || funt($(this)[0]))
						return redirectSubmits($(this));
					return false;
				})
			});
		$("#"+slot+" table.sheet").each(function(){
			var elname=$(this).attr("id");
			$("#"+$(this).attr("id")+" tr td input").unbind("keydown").bind("keydown",function(){
				$(this).autoGrowInput({comfortZone:20});
				checkSheetBounderies($(this),elname);
			});
		});
	}

	if(ajaxifyEnableFocus) loadAllHandler();
	if(slot!="")
	{
		if(tinyMCE)
		{
			tinyMCE.idCounter=0;
			$("textarea[mce_editable=true]").each(function(){
				tinyMCE.execCommand('mceAddControl', false, $(this).attr("id"));
				$(this).attr("mce_editable","false");
				});
		}
		if(myNicEditor)
		{
			$("textarea[mce_editable=true]").each(function(){
				myNicEditor.panelInstance($(this).attr("id"));
				$(this).attr("mce_editable","false");
			});
		}
	}

}
function reloadImages()
{
	$("img.imgonover").hover(function(){
		if($(this).attr("offsrc")==undefined)
			$(this).attr("offsrc",$(this).attr("src"));
		$(this).attr("src",$(this).attr("onsrc"));
	},function(){
		$(this).attr("src",$(this).attr("offsrc"));
	});
}
function reloadGmaps(fromdiv)
{
	$(""+fromdiv).each(function(){
		eval("loadMap"+$(this).attr("mapname")+"()");
	});
}
function reloadAutocomplete()
{
	var mm="no";
	$("input.autocompletefield").each(function(){
		$(this).autocomplete("blank.php?lk=no", {
		minChars: $(this).attr("minChars")==""?1:$(this).attr("minChars"),
		width: 310,
		matchContains: "word",
		autoFill: true,
		selectFirst: false,
		mustMatch: $(this).attr("mustmatch")=="yes"?true:false,
		formatItem: function(row, i, max) {
			if(!row.faravaloare) row.showText=row.name.replace("&amp;","&");else row.showText='';
			return row.name;
		},
		formatResult: function(row) {
			if(row && !row.faravaloare)
			{
				return row.name;
			}
			return '';
		}
		}).unbind("result").bind("result",function(input,cl){
			if($(this).val()=='') return true;
			var f=$(this)[0].form;
			var shouldBlank=false;
			var doubleItem=false;
			if(cl && cl.fields)
			{
				$.each(cl.fields, function(i,item){
					if(f[item.field]) 
					switch(item.value)
					{
						case 'checked': f[item.field].checked=true;
						break;
						case 'unchecked': f[item.field].checked=false;
						break;
						default:
							$(f[item.field]).val(item.value);
							var nextdel=false;
							$("input.autocompletecase").each(function(){
								var rlk=$(this).attr("lk");
								if($(this).attr("lk"+item.field) && $(this).attr("lk"+item.field)!="") rlk=$(this).attr("lk"+item.field);
								else $(this).attr("lk"+item.field,rlk);
								rlk=rlk.replace("["+item.field+"]",""+item.value);
								$(this).attr("lk",rlk);
								if(nextdel && $("input.autocompletefield[lk"+$(this).attr("name")+"]").length)
								{
									$(this).val('');
									$("input.autocompletefield[lk"+$(this).attr("name")+"]").attr("lk"+$(this).attr("name"),"");
								}
								if($(this).attr("name")==item.field)
								{
									nextdel=true;
								}
							});
						break;
					}
				});
			}
			if(cl && cl.add)
			{
				$.each(cl.add, function(i,item){
					if(f[item.field])
					{
						var toadd;
						var tocheck=$(f[item.field]).val();
						var arr=tocheck.split(",");
						var i;
						for(i in arr)
						{
							if(arr[i]==item.value) doubleItem=true;
						}
						if(!doubleItem)
						{
							toadd='';
							if($(f[item.field]).val()!='') toadd=',';
							toadd+=''+item.value;
							$(f[item.field]).val($(f[item.field]).val()+toadd);
						}
					}
					shouldBlank=true;
				});
			}
			if(cl && cl.append && !doubleItem)
			{
				$.each(cl.append, function(i,item){
					if(item.id) $('#'+item.id).append(item.value+"<br>");
					if(item.other) $(item.other).append(item.value+"<br>");
				});
			}
			if(cl && cl.html)
			{
				$.each(cl.html, function(i,item){
					if(item.id) $('#'+item.id).html(item.value);
					if(item.other) $(item.other).html(item.value);
				});
			}
			if(shouldBlank) {$(this).val('');}
	});
	});
}
function alerterror(err){
alert(err);
$("#loading").hide();
}
</script>
<?php cache_addvalue("head",ob_get_contents());ob_end_clean();
ob_start()
?><img src='images/loading.gif' style="position:absolute;top:-500px;"><?php
cache_addvalue("afterbody",ob_get_contents());ob_end_clean();
?>
