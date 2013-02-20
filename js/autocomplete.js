var selectControl=null;
var selectIndex=-1;
function selectComboHandler() {
if(SeltimerID)
{
	clearTimeout(SeltimerID);
	SeltimerID=0;
}
selectControl.selectedIndex = selectIndex;
}
function completefield (event,field, select, hid, property) {
	if(!event)
	{
		evt=window.event;//IE
	}
	else
	{
		evt=event;
	}
	var cursorKeys ="13;8;46;37;38;39;40;33;34;35;36;45;";
	if (cursorKeys.indexOf(evt.keyCode+";") != -1) {return;}

	var found = false;
	for (var i = 0; i < select.options.length; i++) {
	if (select.options[i][property].toUpperCase().indexOf(field.value.toUpperCase()) == 0) {
		found=true; break;
		}
	}

	selectControl=select;
	if(!SeltimerID)
		SeltimerID=setTimeout("selectComboHandler()",1);


	if (found) { selectIndex = i; }
	else { selectIndex=-1; }

	if (found){
			if(select.options[i].value!="")
			{
			var oldValue = field.value;
			var newValue = found ? select.options[i][property] : oldValue;
			if (newValue != field.value) {
				field.value = newValue;
				if( field.createTextRange )
				{
					rNew = field.createTextRange()
					rNew.moveStart('character', oldValue.length) ;
					rNew.select()
				}
				else
				{
					field.setSelectionRange( oldValue.length, newValue.length )
				}

				}
			}
		}
	hid.value=field.value;
	}
var autocompleteLastLen=0;
function completeDatefield (event,field,dformat) {
	if(!event)
	{
		evt=window.event;//IE
	}
	else
	{
		evt=event;
	}
	//alert(evt.keyCode);
	var cursorKeys ="16;13;8;46;37;38;40;39;33;34;35;36;45;";
	if (cursorKeys.indexOf(evt.keyCode+";") != -1) {return;}

	var d=new Date();
	var oldValue=field.value;
	//alert(autocompleteLastLen);alert(oldValue);
	if(autocompleteLastLen+2<oldValue.length) return;
	var catChar=".";
	switch(dformat)
	{
		case '%m/%e/%Y':
		case 'MM/dd/yyyy':
		{
			catChar="/";
			var oldPos=0;
			var nextPos=oldValue.indexOf(catChar);
			if(nextPos>=0)
			{
				//get first junk
				oldPos=nextPos+1;
				var nextText=oldValue.substr(nextPos+1);
				if(nextText.length==0)
				{
					field.value+=(d.getDate()+1)+catChar+d.getFullYear();
				}
				else
				{
					nextPos=nextText.indexOf(catChar);
					nextText=nextText.substr(nextPos+1);
					if(nextPos<=0)
					{
						//we have no year
						field.value+=catChar;
						nextText="";
					}
					if(nextText.length==0)
					{
						field.value+=d.getFullYear();
					}
				}
			}
			else
			{
				//we have no day
				field.value+=catChar+(d.getDate()+1)+catChar+d.getFullYear();
			}
		}
		break;
	
		case '%e/%m/%Y':
		case 'au':
		case 'dd/MM/yyyy':
			catChar="/";
		case '%e.%m.%Y':
		case 'dd.MM.yyyy':
		{
			var oldPos=0;
			var nextPos=oldValue.indexOf(catChar);
			if(nextPos>=0)
			{
				//get first junk
				oldPos=nextPos+1;
				var nextText=oldValue.substr(nextPos+1);
				if(nextText.length==0)
				{
					field.value+=(d.getMonth()+1)+catChar+d.getFullYear();
				}
				else
				{
					nextPos=nextText.indexOf(catChar);
					nextText=nextText.substr(nextPos+1);
					if(nextPos<=0)
					{
						//we have no year
						field.value+=catChar;
						nextText="";
					}
					if(nextText.length==0)
					{
						field.value+=d.getFullYear();
					}
				}
			}
			else
			{
				//we have no day
				field.value+=catChar+(d.getMonth()+1)+catChar+d.getFullYear();
			}
		}
		break;
	}
	
	autocompleteLastLen=oldValue.length;
	//alert(autocompleteLastLen);
	if(field.createTextRange)
	{
		rNew = field.createTextRange()
		rNew.moveStart('character', oldValue.length) ;
		rNew.select()
	}
	else
	{
		field.setSelectionRange( oldValue.length, field.value.length )
	}
}
