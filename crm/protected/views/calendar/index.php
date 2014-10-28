<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/cupertino/theme.css' />
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/fullcalendar/fullcalendar.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/calendar.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-ui-timepicker-addon.js'></script>
<script type='text/javascript'>
	$('div').data('theme', <?php echo $staff->calendarTheme ? "'".$staff->calendarTheme."'" : '"agendaWeek"' ?>)
</script>
	<div id='calendar'></div>
	<form id="dialog" style="display:none;" ></form>
        <form id="test_dialog"></form>
	<div id="chose" style="display:none;">
		<div class=""><div class="calendar-repeat-edit">
		<span class="calendar-repeat-edit-title">编辑周期性活动</span>
		<span class=""></span></div>
		<div class="calendar-repeat-edit"><div class="">
		<p>您是要仅更改此活动，或是更改该系列中的所有活动，还是同时更改此活动及该系列中的所有后续活动？</p>
		<table><tbody>
		<tr><td class="calendar-repeat-edit-left-td" >
		<div class="only-this-activity"><button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
		<span class="ui-button-text">仅此活动</span></button></div></td>
		<td class=""><p>该系列中的其他所有活动都将保持不变。</p></td>
		</tr>
		<tr><td class="calendar-repeat-edit-left-td">
		<div class="follow-up-activities" ><button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
		<span class="ui-button-text">后续活动</span></button></div></td>
		<td class=""><p>此活动及其相关的所有后续活动均会发生更改。</p><p class="">对将来活动进行的任何更改都会丢失。</p></td>
		</tr>
		<tr><td class="calendar-repeat-edit-left-td" ><div class="all-activities">
		<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
		<span class="ui-button-text">所有活动</span></button></div></td>
		<td class=""><p>此系列中的所有活动均会发生更改。</p>
		<p class="">j对其他活动进行的任何更改均会保留。</p></td></tr>
		</tbody></table>
		<div class="calendar-repeat-edit-cancel">
		<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
		<span class="ui-button-text">取消此更改</span></button>
		</div></div></div></div>
	</div>
	
        <div class="template dataCollect">
            <label>各数据：</label><span></span>
        </div>
        
	<div class="template date">
        <label>日期:</label><span></span><input type="hidden" name="hideDate"/><input type="hidden" name="allday"/>
    </div>
        
    <div class="template title">
        <label>标题:</label><span><input name="title" type="text"/></span><span class="tip"> 请输入标题</span>
        <input type="hidden" name="Environment" />
    </div>
    <div class="template repeat">
        <label>重复:</label>
		<select name="repeatType">
			<option value="null" selected="selected">不重复</option>
			<option value="day"   rel="天">每天</option>
			<option value="week"  rel="周">每周</option>
			<option value="month" rel="月">每月</option>
			<option value="year"  rel="年">每年</option>
		</select>    
    </div>
    <div class="template repeatWeek">
    	<label>重复时间：</label>
    	<span><input name="repeatWeeks1" type="checkbox" />一</span>
    	<span><input name="repeatWeeks2" type="checkbox" />二</span>
    	<span><input name="repeatWeeks3" type="checkbox" />三</span>
    	<span><input name="repeatWeeks4" type="checkbox" />四</span>
    	<span><input name="repeatWeeks5" type="checkbox" />五</span>
    	<span><input name="repeatWeeks6" type="checkbox" />六</span>
    	<span><input name="repeatWeeks0" type="checkbox" />日</span>
    </div>
    <div class="template repeatFrequency">
    	<label>重复频率:</label>
    	<select name="repeatFrequency">
	    	<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>
	    	<option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option>
	    	<option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
	    	<option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option>
	    	<option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option>
	    	<option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option>
	    	<option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option>
	    	<option value="29">29</option><option value="30">30</option>
    	</select>
    	<span> 天</span>
    </div>
    <div class="template description">
         <label>描述</label><span><textarea name="description"></textarea></span>
    </div>
    <div class="template timepicker">
         <label>时间</label><input name="time" type="text"/>
    </div>
    <div class="template repeatMonthDate">
    	<label>重复日期：</label>
    	<span><input name="repeatMonth" type="radio"  checked="checked" value="1"/>一月的某天</span>
    	<span><input name="repeatMonth" type="radio" value="2"/>一周的某天</span>
    </div>
    <input type="hidden" id="hideType" value="all"/>