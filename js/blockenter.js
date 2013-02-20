<!--
var activeElement = null;
var NexttimerID=0;
var PrevtimerID=0;
var SeltimerID=0;

function blurAllHandler(evt) {
	activeElement = null;
}
function focusAllHandler(evt) {
	var e = evt ? evt : window.event;
	if (!e) return;
	if (e.target)
		activeElement = e.target;
	else if(e.srcElement) activeElement = e.srcElement;

}
function loadAllHandler() {
	var i, j;

	for (i = 0; i < document.forms.length; i++)
		for (j = 0; j < document.forms[i].elements.length; j++) {
			document.forms[i].elements[j].onfocus = focusAllHandler
			document.forms[i].elements[j].onblur  = blurAllHandler
		}

	if(document.forms["work"])
	{
		for(i in document.forms["work"].elements)
		{
			activeElement=document.forms["work"].elements[i];
		}
		focusNextHandler();
	}
}
function focusPrevHandler() {
if(PrevtimerID)
{
clearTimeout(PrevtimerID);
PrevtimerID=0;
}
var i, j;
var last,last_j,last_i;

for (i = 0; i < document.forms.length; i++)
for (j = 0; j < document.forms[i].elements.length; j++) {

if(activeElement && document.forms[i].elements[j]==activeElement && j)
{
j=last_j;
while(j>=0)
{
try
{
	if(""+document.forms[i].elements[j+1].type=="submit")
	{
		//document.forms[i].submit(); return;
	}
	if(""+document.forms[i].elements[j+1].type!="undefined")
	{

		if(document.forms[i].elements[j].type=="text")
		{
			if(document.forms[i].elements[j].createTextRange)
			{
				rNew = document.forms[i].elements[j].createTextRange();
				rNew.select();
			}
			else
			{
				document.forms[i].elements[j].setSelectionRange( 0, 200);
			}
		}

		document.forms[i].elements[j].focus();
		if(activeElement)
		{
			return;
		}
	}
}
catch(e)
{}

if(j)
j--;
else
return;
}
}

last=document.forms[i].elements[j];
last_i=i;
last_j=j;
}//end for j

}
function focusNextHandler() {
if(NexttimerID)
{
clearTimeout(NexttimerID);
NexttimerID=0;
}
var i, j;

for (i = 0; i < document.forms.length; i++)
for (j = 0; j < document.forms[i].elements.length; j++) {
if(activeElement && document.forms[i].elements[j]==activeElement)
{
while(j < document.forms[i].elements.length)
{
if(j+1 < document.forms[i].elements.length)
{
try
{
	if(""+document.forms[i].elements[j+1].type=="submit")
	{
		//document.forms[i].submit(); return;
	}
	if(""+document.forms[i].elements[j+1].type!="undefined")
	{
	if(document.forms[i].elements[j+1].type=="text")
	{
		if(document.forms[i].elements[j+1].createTextRange)
		{
			rNew = document.forms[i].elements[j+1].createTextRange();
			rNew.select();
		}
		else
		{
			document.forms[i].elements[j+1].setSelectionRange( 0, 200);
		}
	}
	document.forms[i].elements[j+1].focus();
	if(activeElement)
	{
		return;
	}

	}
}
catch(e)
{

}
}
j++;
}
}
}//end for j
}
function doKeyboardRemapEvents(event)
{
	if(!event)
	{
		evt=window.event;//IE
	}
	else
	{
		evt=event;
	}

	if(evt.keyCode==13)
	{
		if(evt.shiftKey)
		{
			if(!PrevtimerID)
				PrevtimerID=setTimeout("focusPrevHandler()",1);
			if(!activeElement || !activeElement.type) return true;
			return false;
		}
		if(!evt.ctrlKey)
		{
			if(typeof(activeElement)=="function") return true;
			if(activeElement && activeElement.type=="submit") return true;
			if(activeElement && activeElement.type=="button") return true;
			if(activeElement && activeElement.type=="textarea") return true;
			if(activeElement && activeElement.type=="file") return true;
			if(activeElement && activeElement.type=="hidden") return true;
			if(!activeElement || !activeElement.type) return true;
		}
		if(!NexttimerID)
		{
			NexttimerID=setTimeout("focusNextHandler()",1);
		}
		if($ && (activeElement || activeElement.type))
		{
			$(activeElement).change();
		}
		return false;
	}
	return true;
}

function formatNumberJS(nStr, inD, outD, sep)
{
	nStr += '';
	var dpos = nStr.indexOf(inD);
	var nStrEnd = '';
	if (dpos != -1) {
		nStrEnd = outD + nStr.substring(dpos + 1, nStr.length);
		nStr = nStr.substring(0, dpos);
	}
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(nStr)) {
		nStr = nStr.replace(rgx, '$1' + sep + '$2');
	}
	return nStr + nStrEnd;
}

//add keydownevents
if (typeof jQuery != 'undefined')
{
	$(document).ready(function(){
		$(document).keydown(function(ev){
			return doKeyboardRemapEvents(ev);
		});
		loadAllHandler();
	});
}
else
{
	//add onload events
	if( window.attachEvent )
	{
		window.attachEvent( 'onload', loadAllHandler );
	}
	else if( window.addEventListener )
	{
		window.addEventListener( 'load', loadAllHandler, false )
	}

	document.onkeydown = doKeyboardRemapEvents;
}
-->
