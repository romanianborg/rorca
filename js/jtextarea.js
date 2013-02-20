// $Id: textarea.js,v 1.11 2006/09/07 08:05:31 dries Exp $
var Jtextarea = Jtextarea || {};

Jtextarea.mousePosition = function(e) {
  return { x: e.clientX + document.documentElement.scrollLeft, y: e.clientY + document.documentElement.scrollTop };
};

Jtextarea.textareaAttach = function() {
  $('textarea.resizable:not(.processed)').each(function() {
    var textarea = $(this).addClass('processed'), staticOffset = null;

    $(this).wrap('<div class="resizable-textarea"></div>')
      .parent().append($('<div class="grippie"></div>').mousedown(startDrag));

    var grippie = $('div.grippie', $(this).parent())[0];
    grippie.style.marginRight = (grippie.offsetWidth - $(this)[0].offsetWidth) +'px';

    function startDrag(e) {
      staticOffset = textarea.height() - Jtextarea.mousePosition(e).y;
      textarea.css('opacity', 0.25);
      $(document).mousemove(performDrag).mouseup(endDrag);
      return false;
    }

    function performDrag(e) {
      textarea.height(Math.max(32, staticOffset + Jtextarea.mousePosition(e).y) + 'px');
      return false;
    }

    function endDrag(e) {
      $(document).unbind("mousemove",performDrag).unbind("mouseup",endDrag);
      textarea.css('opacity', 1);
    }
  });
}

$(document).ready(Jtextarea.textareaAttach);

function textareaImplode(name)
{
	var alltxt='';
	var allfi=true;
	$('.'+name+'_implode').each(function()
	{
		if($(this).val()!='')
		{
			if(!allfi) alltxt+=', ';
			allfi=false;
			alltxt+=$(this).attr('label')+'. '+$(this).val();
		}
	});
	alltxt=alltxt.toUpperCase();
	$('textarea[name='+name+']').html(alltxt);
	$('textarea[name='+name+']').val(alltxt);
}

