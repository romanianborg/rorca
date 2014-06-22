<?php
// Copyright AI Software Ltd Bucharest, Romania 2001
ob_start();
if(getUserConfig("datepicker")=="yes")
{
	?><script type="text/javascript" src="js/datepicker.js?1"></script>
	<script>
		var calendar_ret="calendar_finished";
		var global_cal={};
		global_cal.setReturnFunction=function(n){calendar_ret=n;};
		global_cal.select=function(val,camp,format)
		{
			var lang;
			if(format=='MM/dd/yyyy') format='m/d/Y';
			if(format=='dd.MM.yyyy') {format='d.m.Y';lang={
					days: ["Duminica", "Luni", "Marti", "Miercuri", "Joi", "Vineri", "Sambata", "Duminica"],
					daysShort: ["Dum", "Lun", "Mar", "Mie", "Joi", "Vin", "Sam", "Dum"],
					daysMin: ["Du", "Lu", "Ma", "Mie", "Joi", "Vi", "Sa", "Du"],
					months: ["Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie", "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"],
					monthsShort: ["Ian", "Feb", "Mar", "Apr", "Mai", "Iun", "Iul", "Aug", "Sep", "Oct", "Noi", "Dec"],
					weekMin: 'W'
				};}
			$(val).DatePicker({
				mode:'single',
				date: $(val).val(),
				current: $(val).val(),
				format:format,
				calendars:2,
				locale: lang,
				onChange:function(f,d){
					$(val).DatePickerHide();
					var ds=f.split(",");
					$(val).val(ds[0]).change();
				},
				onRender: function(date) {
					var n=new Date();
					return {
						//disabled: (date.valueOf() < now.valueOf()),
						className: date.getDate()==n.getDate() && date.getMonth()==n.getMonth() && date.getFullYear()==n.getFullYear() ? 'datepickerSpecial' : false
					}
				}
			});
			$(val).DatePickerShow();
		};
		global_cal.selectdays=function(val,val2,format)
		{
			var lang;
			if(format=='MM/dd/yyyy') format='m/d/Y';
			if(format=='dd.MM.yyyy') {format='d.m.Y';lang={
					days: ["Duminica", "Luni", "Marti", "Miercuri", "Joi", "Vineri", "Sambata", "Duminica"],
					daysShort: ["Dum", "Lun", "Mar", "Mie", "Joi", "Vin", "Sam", "Dum"],
					daysMin: ["Du", "Lu", "Ma", "Mie", "Joi", "Vi", "Sa", "Du"],
					months: ["Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie", "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"],
					monthsShort: ["Ian", "Feb", "Mar", "Apr", "Mai", "Iun", "Iul", "Aug", "Sep", "Oct", "Noi", "Dec"],
					weekMin: 'W'
				};}
			$(val).DatePicker({
				mode:'single',
				date: [$(val).val(),$(val2).val()],
				current: $(val).val(),
				format:format,
				calendars:3,
				locale: lang,
				onChange:function(f,d){
					$(val).DatePickerHide();
					var ds=f.split(",");
					$(val).val(ds[0]).change();
					$(val2).val(ds[1]).change();
				},
				onRender: function(date) {
					var n=new Date();
					return {
						//disabled: (date.valueOf() < now.valueOf()),
						className: date.getDate()==n.getDate() && date.getMonth()==n.getMonth() && date.getFullYear()==n.getFullYear() ? 'datepickerSpecial' : false
					}
				}
			});
			$(val).DatePickerShow();
		};
		</script>
	<?php
}
else
{
	require_once("layers.php");
	?><SCRIPT LANGUAGE="JavaScript" SRC="js/CalendarPopup.js?1"></SCRIPT><?php
}
?>
<script>
function showNumberWith2Degits(n)
{
	if(n<10) return "0"+n;
	return n;
}
function calendarAutomaticCalculateEndDate(data1,months,dateformat)
{
	if(data1=="") return "";
	if(months=="") return "";
	var d;
	var date2="";
	var arr;
	months=parseInt(months);
	switch(dateformat)
	{
		case '%e/%m/%Y':
		case 'au':
		case 'dd/MM/yyyy':
			arr=data1.split('/');
			d = new Date(arr[2], parseFloat(arr[1])-1, arr[0]);
			d.setMonth(d.getMonth()+months);
			d.setDate(d.getDate()-1);
			date2=""+showNumberWith2Degits(d.getDate())+"/"+showNumberWith2Degits(d.getMonth()+1)+"/"+d.getFullYear();
			break;
		case '%m/%e/%Y':
		case 'monthly':
		case 'mm':
		case 'en':
		case 'MM/dd/yyyy':
			arr=data1.split('/');
			d = new Date(arr[2], parseFloat(arr[0])-1, arr[1]);
			d.setMonth(d.getMonth()+months);
			d.setDate(d.getDate()-1);
			date2=""+showNumberWith2Degits(d.getMonth()+1)+"/"+showNumberWith2Degits(d.getDate())+"/"+d.getFullYear();
			break;
		case '%e.%m.%Y':
		case 'daily':
		case 'dd':
		case 'ro':
		case 'dd.MM.yyyy':
			arr=data1.split('.');
			d = new Date(arr[2], parseFloat(arr[1])-1, arr[0]);
			d.setMonth(d.getMonth()+months);
			d.setDate(d.getDate()-1);
			date2=""+showNumberWith2Degits(d.getDate())+"."+showNumberWith2Degits(d.getMonth()+1)+"."+d.getFullYear();
			break;
	}
	return date2;
}
function calendarAutomaticDays(data1,days,dateformat)
{
	if(data1=="") return "";
	if(days=="") return data1;
	if(isNaN(parseInt(days)) || parseInt(days)<1) return data1;
	var d;
	var date2="";
	var arr;
	days=parseInt(days);
	if(days==0) return data1;
	switch(dateformat)
	{
		case '%e/%m/%Y':
		case 'au':
		case 'dd/MM/yyyy':
			arr=data1.split('/');
			d = new Date(arr[2], parseFloat(arr[1])-1, arr[0]);
			d.setDate(d.getDate()+days-1);
			date2=""+showNumberWith2Degits(d.getDate())+"/"+showNumberWith2Degits(d.getMonth()+1)+"/"+d.getFullYear();
			break;
		case '%m/%e/%Y':
		case 'monthly':
		case 'mm':
		case 'en':
		case 'MM/dd/yyyy':
			arr=data1.split('/');
			d = new Date(arr[2], parseFloat(arr[0])-1, arr[1]);
			d.setDate(d.getDate()+days-1);
			date2=""+showNumberWith2Degits(d.getMonth()+1)+"/"+showNumberWith2Degits(d.getDate())+"/"+d.getFullYear();
			break;
		case '%e.%m.%Y':
		case 'daily':
		case 'dd':
		case 'ro':
		case 'dd.MM.yyyy':
			arr=data1.split('.');
			d = new Date(arr[2], parseFloat(arr[1])-1, arr[0]);
			d.setDate(d.getDate()+days-1);
			date2=""+showNumberWith2Degits(d.getDate())+"."+showNumberWith2Degits(d.getMonth()+1)+"."+d.getFullYear();
			break;
	}
	return date2;
}
</script>
<STYLE>
	a.cpCurrentMonthDate,a.cpCurrentDate,a.cpOtherMonthDate
	{
		display:block;padding:3px;
	}
	a.cpCurrentMonthDate
	{
		color:black;
	}
	a.cpCurrentDate
	{
		color:white;
	}
	td.cpCurrentMonthDate,td.cpOtherMonthDate
	{
		border:solid thin #EEDDDD;text-align: center;
	}
	TD.cpCurrentDate
	{
		color:#FFFFFF;
		background-color: #6677DD;
		border-width:1;
		border:solid thin #000000;text-align: center;
	}
	td.cpDayColumnHeader
	{
		text-align:center;padding:7px;
		background-color:#6677DD;
	}
	.cpYearNavigation,
	.cpMonthNavigation
	{
		background-color:#6677DD;
		text-align:center;
		vertical-align:middle;
		text-decoration:none;
		color:#FFFFFF;
		font-weight:bold;
	}
	.cpCurrentMonthDateDisabled,
	.cpOtherMonthDateDisabled,
	.cpCurrentDateDisabled
	{
		color:#D0D0D0;
		text-align:right;
		text-decoration:line-through;
	}
	
div.datepicker {
	position: relative;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 196px;
	height: 147px;
	position: absolute;
	cursor: default;
	top: 0;
	left: 0;
	display: none;
}
.datepickerContainer {
	background: <?php echo getUserConfig("theme_color2");?>;
	border:solid 1px <?php echo getUserConfig("theme_color4");?>;
	position: absolute;
	top: 10px;
	left: 10px;
	padding:4px;
}
.datepickerBorderT {
	position: absolute;
	left: 10px;
	top: 0;
	right: 10px;
	height: 10px;
}
.datepickerBorderB {
	position: absolute;
	left: 10px;
	bottom: 0;
	right: 10px;
	height: 10px;
}
.datepickerBorderL {
	position: absolute;
	left: 0;
	bottom: 10px;
	top: 10px;
	width: 10px;
}
.datepickerBorderR {
	position: absolute;
	right: 0;
	bottom: 10px;
	top: 10px;
	width: 10px;
}
.datepickerBorderTL {
	position: absolute;
	top: 0;
	left: 0;
	width: 10px;
	height: 10px;
}
.datepickerBorderTR {
	position: absolute;
	top: 0;
	right: 0;
	width: 10px;
	height: 10px;
}
.datepickerBorderBL {
	position: absolute;
	bottom: 0;
	left: 0;
	width: 10px;
	height: 10px;
}
.datepickerBorderBR {
	position: absolute;
	bottom: 0;
	right: 0;
	width: 10px;
	height: 10px;
}
.datepickerHidden {
	display: none;
}
div.datepicker table {
	border-collapse:collapse;
}
div.datepicker a {
	color: #222;
	text-decoration: none;
	cursor: default;
	outline: none;
}
div.datepicker span
{
	font-size:13px;
}
div.datepicker table td {
	text-align: right;
	padding: 0;
	margin: 0;
}
div.datepicker th {
	text-align: center;
	color: <?php echo getUserConfig("theme_color4");?>;
	font-weight: normal;
}
div.datepicker tbody th {
	text-align: left;
}
div.datepicker tbody a {
	display: block;
}
.datepickerDays a {
	width: 20px;
	line-height: 16px;
	height: 16px;
	padding-right: 2px;
}
.datepickerYears a,
.datepickerMonths a{
	width: 44px;
	line-height: 36px;
	height: 36px;
	text-align: center;
}

td.datepickerNotInMonth a {
	color: <?php echo getUserConfig("theme_color3");?>;
}
tbody.datepickerDays td.datepickerSelected{
	background: <?php echo getUserConfig("theme_color4");?>;
}
tbody.datepickerDays td.datepickerNotInMonth.datepickerSelected {
	background:<?php echo getUserConfig("theme_color4");?>;
}
tbody.datepickerYears td.datepickerSelected,
tbody.datepickerMonths td.datepickerSelected{
	background: <?php echo getUserConfig("theme_color4");?>;
}
div.datepicker a:hover,
div.datepicker a:hover {
	color: black;
	background: <?php echo getUserConfig("theme_color1");?>;
}
div.datepicker td.datepickerNotInMonth a:hover {
	color: #222;
}
div.datepicker tbody th {
	text-align: left;
}
.datepickerSpace div {
	width: 20px;
}
.datepickerGoNext a,
.datepickerGoPrev a,
.datepickerMonth a {
	text-align: center;
	height: 20px;
	line-height: 20px;
}
.datepickerGoNext a {
	float: right;
	width: 20px;
}
.datepickerGoPrev a {
	float: left;
	width: 20px;
}
table.datepickerViewDays tbody.datepickerMonths,
table.datepickerViewDays tbody.datepickerYears {
	display: none;
}
table.datepickerViewMonths tbody.datepickerDays,
table.datepickerViewMonths tbody.datepickerYears,
table.datepickerViewMonths tr.datepickerDoW {
	display: none;
}
table.datepickerViewYears tbody.datepickerDays,
table.datepickerViewYears tbody.datepickerMonths,
table.datepickerViewYears tr.datepickerDoW {
	display: none;
}
td.datepickerDisabled a,
td.datepickerDisabled.datepickerNotInMonth a{
	color: #444;
}
td.datepickerDisabled a:hover {
	color: <?php echo getUserConfig("theme_color2");?>;
}
td.datepickerSpecial a {
	background: <?php echo getUserConfig("theme_color1");?>;
}
td.datepickerSpecial.datepickerSelected a {
	background: <?php echo getUserConfig("theme_color3");?>;
}
th.datepickerWeek span
{
	color: <?php echo getUserConfig("theme_color4");?>;
}
</STYLE>
<?php
cache_addvalue("head",ob_get_contents());
ob_end_clean();
ob_start();
if(getUserConfig("datepicker")!="yes")
{
?>
<DIV ID="calendardiv" STYLE="position:absolute;visibility:hidden;background-color:white;z-index:100;"></DIV>
<script>
var global_cal = new CalendarPopup("calendardiv");
//global_cal.showNavigationDropdowns();
global_cal.setCssPrefix("");
global_cal.setMonthNames(<?php echo getLT('months')?>);
global_cal.setDayHeaders(<?php echo getLT('shortdays')?>);
global_cal.setWeekStartDay(<?php echo getLT('startingday')?>);
global_cal.setTodayText("<?php echo getLT('today')?>");
global_cal.showYearNavigation();
global_cal.showYearNavigationInput();
</script>
<?php
}
require_once("dateutils.php");
cache_addvalue("body",ob_get_contents());
ob_end_clean();
?>
