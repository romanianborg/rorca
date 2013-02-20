<?php 
require_once("jquery.php");

ob_start();?>

<style>
.sheet td input {width:100%;border:none;background:none;}
.sheet td {width:70px;}
table.sheet,table.sheetview {border:solid 1px #ccc; border-collapse: collapse;}
</style>

<script>

(function($){

	// jQuery autoGrowInput plugin by James Padolsey
	// See related thread: http://stackoverflow.com/questions/931207/is-there-a-jquery-autogrow-plugin-for-text-fields
	$.fn.autoGrowInput = function(o) {
		o = $.extend({
		maxWidth: 1000,
		minWidth: 0,
		comfortZone: 70,
		updateparent: false
	}, o);

	this.filter('input:text').each(function(){
		var input = $(this);
		var testSubject;
		if(!($("#sheettester").length)){
			testSubject = $('<p id="sheettester"/>').css({
			position: 'absolute',
			top: -9999,
			left: -9999,
			width: 'auto',
			fontSize: input.css('fontSize'),
			fontFamily: input.css('fontFamily'),
			fontWeight: input.css('fontWeight'),
			letterSpacing: input.css('letterSpacing'),
			whiteSpace: 'nowrap'
			});
			$("body").append(testSubject);
		}else {testSubject=$("#sheettester");}
		var minWidth = o.minWidth || $(this).width(),
		val = '',
		check = function() {
			if (val === (val = input.val())) {return;}
			testSubject.html(val);
			// Calculate new width + whether to change
			var testerWidth = testSubject.width(),
			newWidth = (testerWidth + o.comfortZone) >= minWidth ? testerWidth + o.comfortZone : minWidth,
			currentWidth = input.parent().width(),
			isValidWidthChange = (newWidth < currentWidth && newWidth >= minWidth) || (newWidth > minWidth && newWidth < o.maxWidth);
			// Animate width
			if(o.updateparent && isValidWidthChange)
			{
				var masterw;
				masterw=o.updateparent.width();
				masterw-=currentWidth;
				masterw+=newWidth;
				o.updateparent.width(masterw);
			}
			if (isValidWidthChange) {
				input.parent().width(newWidth);
			}
			return true;
		};
		$(this).unbind('keyup blur update').bind('keyup blur update', check);
		return this;
	});
	};
	})(jQuery);

function checkSheetBounderies(el,elname)
{
	//check for termination
	var x;
	var y;
	var ref=false;
	x=parseInt(el.attr("posx"));
	y=parseInt(el.attr("posy"));

	if(!$("#"+elname+" input.sheet_"+(x+1)+'_'+y).length)
	{
		$("#"+elname+" tr").each(function(){
			var y;
			y=parseInt($(this).attr("posy"));
			$(this).append('<td><input type="text" class="sheet_'+(x+1)+'_'+y+'" name="'+elname+'_'+(x+1)+'_'+y+'" value="" posx="'+(x+1)+'" posy="'+y+'">');
		});
		ref=true;
	}
	if(!$("#"+elname+" tr.sheet_"+(y+1)).length)
	{
		var st='<tr class="sheet_'+(y+1)+'" posy="'+(y+1)+'">';
		$("#"+elname+" tr.sheet_"+y+' td input').each(function(){
			var x;
			x=parseInt($(this).attr("posx"));
			st=st+'<td><input type="text" class="sheet_'+x+'_'+(y+1)+'" name="'+elname+'_'+x+'_'+(y+1)+'" value="" posx="'+x+'" posy="'+(y+1)+'">';
		});
		el.parent().parent().parent().append(st);
		ref=true;
	}
	if(ref)
	{
		$("#"+elname+" tr td input").unbind("keydown").bind("keydown",function(){
			$(this).autoGrowInput({comfortZone:20,updateparent:$("#"+elname)});
			checkSheetBounderies($(this),elname);
			return true;
		});
	}
	
	return true;
}
</script>
<?php
cache_addvalue("head",ob_get_contents());ob_end_clean();?>