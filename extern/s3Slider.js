/* ------------------------------------------------------------------------
	s3Slider
	
	Developped By: Boban Karišik -> http://www.serie3.info/
				CSS Help: Mészáros Róbert -> http://www.perspectived.com/
	Version: 1.0
	
	Copyright: Feel free to redistribute the script/modify it, as
				long as you leave my infos at the top.
------------------------------------------------------------------------- */


(function($){

	 $.fn.s3Slider = function(vars) {
				if($(this).attr("isalreadys3slider")=="yes") return;
				if(!this.length) return;
				$(this).attr("isalreadys3slider","yes");
				var element = this;
				var elementHtml = this[0];
				var timeOut = (vars.timeOut != undefined) ? vars.timeOut : 4000;
				var timeOutFn = null;
				var faderStat = 0;
				var mOver = false;
				var items = $("#" + element[0].id + "Content ." + element[0].id + "Image");
				var itemsSpan = $("#" + element[0].id + "Content ." + element[0].id + "Image div");
				var itemsImg = $("#" + element[0].id + "Content ." + element[0].id + "Image img");
				var currNo=0;
				
				var citem=0;
				itemsImg.each(function(){
					element.prepend('<a id="s3overview'+citem+'" relid="'+citem+'" class="s3overview" href="#"><img src="'+$(this).attr('thumbsrc')+'" width=40></a>');
					citem++;
				});
				
				
				citem=1;
				items.each(function(i) {
				citem++;$(this).attr("orderid",citem);
				
				$(items[i]).mouseover(function() {
					mOver=true;
				});
				
				$(items[i]).mouseout(function() {
					mOver=false;
					if(timeOutFn==null) fadeElement();
				});
				
				});
				
				var triggerElement=function(){
					if(elementHtml!=null) element.trigger("mytimeout2");
				}
				$("#" + element[0].id).unbind("mytimeout2").bind("mytimeout2",function(e){makeSlider();});
				var fadeElement = function() {
					if(faderStat==2 || faderStat==3) return;
					thisTimeOut = (faderStat==0) ? 10 : timeOut;
					if(items.length > 0) {
						if(timeOutFn!=null) {clearTimeout(timeOutFn);timeOutFn=null;}
						if(timeOutFn==null) timeOutFn=setTimeout(triggerElement, thisTimeOut);
					}
				}
				
				var makeSlider = function() {
					
					if(timeOutFn!=null) {clearTimeout(timeOutFn);timeOutFn=null;}
					if(faderStat==0)
					{
						faderStat=2;
						currNo=(vars.startWith!=undefined)?vars.startWith:currNo+1;vars.startWith=null;
						currNo=(currNo >= items.length)?0:currNo;
						$("#"+element[0].id+" a.s3overview").removeClass("s3overviewcurr").unbind("click").click(function(){
							vars.startWith=parseInt($(this).attr("relid"));
							if(timeOutFn!=null) {clearTimeout(timeOutFn);timeOutFn=null;}
							timeOutFn = setTimeout(triggerElement, 10);
							return false;
						});
					}

					if(faderStat == 2) {
					
						$("#"+element[0].id+" #s3overview"+currNo).addClass("s3overviewcurr");
						$(items[currNo]).fadeIn(140, function() {
							if($(itemsSpan[currNo]).css('bottom') == 0) {
								 $(itemsSpan[currNo]).slideUp(800, function() {
											faderStat = 1;
											if(!mOver) fadeElement();
								 });
							} else {
								 $(itemsSpan[currNo]).slideDown(800, function() {
											faderStat = 1;
											if(!mOver) fadeElement();
								 });
							}
						});
					} else if(faderStat == 1){
						 if(!mOver) {
						 	faderStat == 3;
							if($(itemsSpan[currNo]).css('bottom') == 0) {
								$(itemsSpan[currNo]).slideDown(200, function() {
									 $(items[currNo]).fadeOut(140, function() {
												faderStat = 0;
												fadeElement();
									 });
								});
								} else {
								$(itemsSpan[currNo]).slideUp(200, function() {
								$(items[currNo]).fadeOut(140, function() {
												faderStat = 0;
												fadeElement();
									 });
								});
							}
						 }
					}
				}
				setTimeout(triggerElement, 10);

	 };		

})(jQuery);		
