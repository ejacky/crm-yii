/**
 *  日历页面函数
 */
function repeatChange(type) {
	var data = $('div').data('data');
	data.type = type
		$.post($('div').data('eventType'), {
			data : data
		}, function (doc) {
			if (doc[0] == 1) {
				$('#calendar').fullCalendar('refetchEvents')
			}
		}, 'json');
	$("#chose").dialog("close");
}

function dataType(type) {
	$('#hideType').val(type)
	$('input[name="Environment"]').val(type)
	$('.date-chose').removeClass('ui-state-active')
	$('#' + type).closest('span.fc-button').addClass('ui-state-active')
    $('#calendar').fullCalendar('refetchEvents')
}

//eventClick事件弹窗
function eventClickPopup(event) {
	$('#dialog').html('');
	$('div.template.date').children().clone().appendTo($('<div>').addClass('row date').appendTo('#dialog'))
	$('div.date span').text($.fullCalendar.formatDate(event.start, "MM月dd日") + " (周" + "日一二三四五六".charAt(new Date(event.start).getDay()) + '), ' + $.fullCalendar.formatDate(event.start, "HH:mm") + ' – ' + $.fullCalendar.formatDate(event.end, "HH:mm"))
	$('div.template.title').children().clone().appendTo($('<div>').addClass('row title').appendTo('#dialog'))
	$('.row.title span').html(event.description)
        
}
/**
 * jacky
 * begin
 */
function eventClickPopup2(event) {
        $('#test_dialog').html('<a href="#">' + event.title + '</a>');  
       // $('div.template.dataCollect').children().clone().append($('<div>').addClass('dataCollect').appendTo('#test_dialog'));
        
}
/**
 * end
 */
//select事件弹窗
function setDayClickPopup(date, end, allday) {
	$('input[name="Environment"]').val($('#hideType').val())
	$('#dialog').html('');
	$('div.template.date').children().clone().appendTo($('<div>').addClass('row date').appendTo('#dialog'))
	$('div.date span').text($.fullCalendar.formatDate(date, "MM月dd日") + " (周" + "日一二三四五六".charAt(new Date(date).getDay()) + ')')
	$('div.date [name="hideDate"]').val($.fullCalendar.formatDate(date, "yyyy-MM-dd"))
	$('div.date [name="allday"]').val(allday)
	$('div.template.title').children().clone().appendTo($('<div>').addClass('row title').appendTo('#dialog'))
	
	if (!allday) {
		$('div').data('timeDiff', date - end)
		$('div').data('dateStart', date)
		$('div.template.timepicker').children().clone().appendTo($('<div>').addClass('row time').appendTo('#dialog')).attr('name', 'startTime')
		$('input[name="startTime"]').val($.fullCalendar.formatDate(date, "HH:mm"))
		$('div.template.timepicker').children().clone().appendTo($('<div>').addClass('row time').appendTo('#dialog')).attr('name', 'endTime')
		$('input[name="endTime"]').val($.fullCalendar.formatDate(end, "HH:mm"))
		
		$('div.time input').timepicker({
			timeOnlyTitle : '选择时间',
			timeText : '时间',
			hourText : '小时',
			minuteText : '分钟',
			secondText : '秒数',
			currentText : '当前时间',
			closeText : '确定'
		});
	}
	$('div.template.repeat').children().clone().appendTo($('<div>').addClass('row repeat').appendTo('#dialog'))
	$('div.template.repeatMonthDate').children().clone().appendTo($('<div>').addClass('row repeatMonthDate').appendTo('#dialog').hide())
	$('div.template.repeatWeek').children().clone().appendTo($('<div>').addClass('row repeatWeek').appendTo('#dialog').hide())
	$('div.template.repeatFrequency').children().clone().appendTo($('<div>').addClass('row repeatFrequency').appendTo('#dialog').hide())
	$('select[name="repeatType"]').live('change', function () {
		$('div.repeatFrequency span').text($(':selected', this).attr('rel'))
		if ($(':selected', this).val() == 'week') {
			setShow('repeatWeek')
		} else if ($(':selected', this).val() == 'month') {
			setShow('repeatMonthDate')
		} else if ($(':selected', this).val() == 'day' || $(':selected', this).val() == 'year') {
			setShow('repeatDay')
		} else {
			setShow()
		}
	});
}

function setShow(where) {
	$('div.row.repeatFrequency').show()
	switch (where) {
	case 'repeatWeek':
		$('div.row.repeatWeek').show();
		$('div.row.repeatMonthDate').hide();
		break
	case 'repeatMonthDate':
		$('div.row.repeatMonthDate').show();
		$('div.row.repeatWeek').hide();
		break
	case 'repeatDay':
		$('div.row.repeatWeek').hide();
		$('div.row.repeatMonthDate').hide();
		break
	default:
		$('div.row.repeatWeek').hide();
		$('div.row.repeatMonthDate').hide();
		$('div.row.repeatFrequency').hide();
		break
	}
}

function setTime() {
	var d = new Date()
		var h = d.getHours()
		var m = parseInt((d.getMinutes() + h * 60) / (1440 / 1007))
		$('#tgnowmarker').css('top', (m - 21))
		$('#calendar').fullCalendar('refetchEvents')
}

function setOnceTime() {
	$('.tg-col-overlaywrapper').remove()
	if ($('.fc-button-today').attr('class').split(' ')[5] == undefined) {
		return
	}
	var weekWidth
	var width
	var postion
	if ($('.fc-view-agendaDay').is(':visible')) {
		postion = 'fc-view-agendaDay'
			width = $('.fc-view-agendaDay .fc-today').width()
			weekWidth = 0
	}
	if ($('.fc-view-agendaWeek').is(':visible')) {
		postion = 'fc-view-agendaWeek'
			width = $('.fc-view-agendaWeek .fc-today').width()
			switch ($('.fc-today').attr('class').split(' ')[0]) {
			case 'fc-sun':
				weekWidth = 6;
				break
			case 'fc-mon':
				weekWidth = 0;
				break
			case 'fc-tue':
				weekWidth = 1;
				break
			case 'fc-wed':
				weekWidth = 2;
				break
			case 'fc-thu':
				weekWidth = 3;
				break
			case 'fc-fri':
				weekWidth = 4;
				break
			case 'fc-sat':
				weekWidth = 5;
				break
			default:
				break
			}
	}
	var d = new Date()
		var h = d.getHours()
		var m = parseInt((d.getMinutes() + h * 60) / (1440 / 1007))
		$('.' + postion + ' .fc-slot0>.ui-widget-content').append('<span class="tg-col-overlaywrapper" >' +
			'<div id="tgnowmarker" class="tg-hourmarker tg-nowmarker" style="left:' +
			weekWidth * (width + 1) + 'px;z-index:99;width:' + (width + 1) + 'px;top:' + (m - 21) + 'px;"> </div></span>');
}

$(document).ready(function () {
	var calendar = $('#calendar').fullCalendar({
			monthNames : ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
			dayNamesShort : ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
			monthNamesShort : ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
			dayNames : ["周一", "周二", "周三", "周四", "周五", "周六","周日"],
			today : ["今天"],
			firstDay: 1,
			buttonText : {
				today : "今天",
				prev : "上一月",
				next : "下一月",
				month : "月",
				agendaWeek : "周",
				agendaDay : "天"
			},
                          
                        
			header : {
				left : 'prev,next today',
				center : 'title',
				right : 'month,agendaWeek,agendaDay'
			},
                        
			titleFormat : {
				month : 'yyyy年 MMMM',
				week : "yyyy年MMMd日{ '&#8212; '[yyyy年][MMM]d日}",
				day : 'yyyy年MMMd日, dddd'
			},
			columnFormat : {
				month : 'ddd',
				week : 'M月d日 ddd',
				day : 'M月d日 dddd'
			},
			timeFormat : {
				'' : 'h(:mm)t'
			},
			selectable : true,
			selectHelper : true,
			theme : true,
			editable : true,
			defaultView :  $('div').data('theme') ,
                        
                       /*
                        viewDisplay: function (view) {
                            alert(view.name);    
                        },
                        */
			events : function (start, end, callback) {
				$.ajax({
					url : 'Json',
					dataType : 'json',
					data : {
						start : Math.round(start.getTime() / 1000),
						end : Math.round(end.getTime() / 1000),
						type : $('#hideType').val()                                                                                                                                                                                                                                         
					},
					success : function (doc) {
						if (doc != null) {
							var events = [];
							for (var i = 0; i < doc.length; i++) {
                                                                if (i == doc.length-1) {
                                                                 //   alert(doc[i].allName);
                                                                }
								events.push({
									id : doc[i].id,
									title : doc[i].title,
									start : doc[i].start,
									end : doc[i].end,
									allDay : doc[i].allday,
									repeatID : doc[i].repeatID,
									description : doc[i].description,
									color : doc[i].color,
									url : doc[i].url,
                                                                        dataType : doc[i].dataType                                                                     								
								});
							};
                                                        
							callback(events);
						}
					}
				});
			},
			
			eventResize : function (event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
				var data = new Object();
				data.id = event.id
					data.title = event.title
					data.repeatID = event.repeatID
					data.start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss")
					data.end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss")
					if (typeof(event.id) == 'undefined') {
						$('div').data('data', data);
						$('div').data('eventType', 'EventResize')
						$("#chose").dialog("open");
						return;
					}
					$.post("EventResize/", {
						data : data
					})
					$('#calendar').fullCalendar('refetchEvents')
			},
			
			eventDrop : function (event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
				var data = new Object()
					data.id = event.id
					data.title = event.title
					data.repeatID = event.repeatID
					data.allday = allDay
					data.dayDelta = dayDelta
					data.minuteDelta = minuteDelta
					data.start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss")
					data.end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss")
					$.post("EventDrop/", {
						data : data
					})
					$('#calendar').fullCalendar('refetchEvents')
			},
			
			select : function (start, end, allDay) {
				setDayClickPopup(start, end, allDay)
				$("#dialog").dialog({
					autoOpen : false, //设置对话框打开的方式 不是自动打开
					show : "blind", //打开时的动画效果
					hide : "explode", //关闭是的动画效果
					//modal:true,		//true代表运用遮罩效果
					buttons : [{
							text : "确定",
							click : function () {
								if ($.trim($('.row.title input').val()) == '') {
									$('.row.title .tip').show();
									return
								}
								$.post("add/", {
									data : $('#dialog').serializeArray()
								}, function (doc) {
									if (doc.code == 1) {
										if(doc.Environment=='sys'){
											dataType('sys');
										}else if (doc.Environment == 'inbox') {
										    dataType('inbox');
										} else{
											$('#calendar').fullCalendar('refetchEvents')
										}
									}
								}, 'json');
								$(this).dialog("close"); //关闭对话框
								calendar.fullCalendar('unselect');
							}
						}, {
							text : "取消",
							click : function () {
								$(this).dialog("close");
							}
						}
					],
					draggable : true, //是否可以拖动的效果true可以拖动默认值是true	，false代表不可以拖动
					closeOnEscape : false, //是否采用esc键退出对话框，如果为false则不采用 ，true则采用
					title : "添加行程日历", //对话框的标题
					width : 410, //设置对话框的宽度
					height : 360, //设置对话框的高度
					zIndex : 1000 //层叠效果
				});
				$("#dialog").dialog("open");
			},
			
			eventClick : function (calEvent, jsEvent, view) {
				if (calEvent.url) {
					window.open(calEvent.url);
					return false;
				}
				
                                if (calEvent.dataType == 'sys')
                                {
                                
                                eventClickPopup2(calEvent);
                                $("#test_dialog").dialog({
                                    buttons : [
                                        {
                                            text : '确定',
                                            click : function () 
                                            {
                                                var data = new Object;
                                                data.id = calEvent.id;
                                                $.post('EventClickSys/',{
                                                    data :data
                                                },function (data) {
                                                    alert(data);
                                                },'json');
                                               // alert(calEvent.dataType);   
                                            }
                                        },
                                        {
                                            text : '取消',
                                            click : function () {
                                                
                                                $(this).dialog('close');
                                            }
                                        }
                                    ]
                                });  
                                
                                }
                                else
                                {
                                    
                                eventClickPopup(calEvent);
				$("#dialog").dialog({
                                   
					buttons : [{
							text : "编辑",
							click : function () {
                                                                
								if ($('#dialog~.ui-dialog-buttonpane div.ui-dialog-buttonset button .ui-button-text:first').html() == '确定') {
									var data = new Object()
										data.id = calEvent.id
										data.start = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm")
										data.end = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm")
										data.repeatID = calEvent.repeatID
										data.title = $('.row.title textarea').val()
										if (typeof(calEvent.id) == 'undefined') {
											$('div').data('data', data);
											$('div').data('eventType', 'EventClick')
											$("#chose").dialog("open");
											$(this).dialog("close");
											return;
										}
										$.post("EventClick/", {
											data : data
										}, function (doc) {
											if (doc[0] == 1) {
												$('#calendar').fullCalendar('refetchEvents')
											}
										}, 'json');
									$(this).dialog("close");
									return;
								}
								$('#dialog~.ui-dialog-buttonpane div.ui-dialog-buttonset button .ui-button-text:first').html("确定")
								$('.row.title span:first').html($('textarea').clone().css({
										width : '230',
										height : '130'
									}).val(calEvent.description))
							}
						}, {
							text : "删除",
							click : function () {
								var data = new Object()
									data.id = calEvent.id
									data.start = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm")
									data.end = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm")
									data.repeatID = calEvent.repeatID
									data.title = $('.row.title textarea').val()
									if (typeof(calEvent.id) == 'undefined') {
										$('div').data('data', data);
										$('div').data('eventType', 'EventDelete')
										$("#chose").dialog("open");
										$(this).dialog("close");
										return
									}
									$.post("EventDelete/", {
										data : data
									}, function (doc) {
										if (doc[0] == 1) {
											$('#calendar').fullCalendar('refetchEvents')
										}
									}, 'json');
								$(this).dialog("close");
							}
						}, {
							text : "取消",
							click : function () {
								$(this).dialog("close");
							}
						}
					],
					title : "修改行程日历",
					width : 410,
					height : 310,
					zIndex : 1000
				});
                                
                                }
				$("#dialog").dialog("open");

			}
		});
      
	
	$("#chose").dialog({
		autoOpen : false,
		resizable : false,
		modal : true,
		open : function (event, ui) {
			$(".ui-dialog-titlebar", $(this).parent()).hide();
		},
		title : "编辑周期性活动",
		width : 720,
		height : 450,
		zIndex : 1000,
	});
	$('.row.title span input').live('focus', function (event) {
		$('.row.title .tip').hide();
	})
	$('.fc-button-month').live('click', function (event) {
		$.post("updateTheme", {
			theme : 'month'
		})
	})
	$('.fc-button-agendaWeek').live('click', function (event) {
		setTimeout('setOnceTime()', 100)
		$.post("updateTheme", {
			theme : 'agendaWeek'
		})
	})
	$('.fc-button-agendaDay').live('click', function (event) {
		setTimeout('setOnceTime()', 100)
		$.post("updateTheme", {
			theme : 'agendaDay'
		})
	})
	$('.fc-button-prev').live('click', function (event) {
		setTimeout('setOnceTime()', 100)
	})
	$('.fc-button-next').live('click', function (event) {
		setTimeout('setOnceTime()', 100)
	})
	$('.fc-button-today').live('click', function (event) {
		setTimeout('setOnceTime()', 100)
	})
	setTimeout('setOnceTime()', 500);
	setInterval('setTime()', 1440 / 1007 * 60000);
	$('td.fc-header-right').prepend(
	    '<span class="date-chose fc-button ui-state-default ui-corner-left"><span class="fc-button-inner">' +
		'<span class="fc-button-content" id="sys">系统数据</span><span class="fc-button-effect"><span></span></span></span></span>' +
		'<span class="date-chose fc-button ui-state-default"><span class="fc-button-inner">' +
		'<span class="fc-button-content" id="inbox">消息提醒</span><span class="fc-button-effect"><span></span></span></span></span>' +
		'<span class="date-chose fc-button ui-state-default"><span class="fc-button-inner">' +
		'<span class="fc-button-content" id="schedule">日程安排</span><span class="fc-button-effect"><span></span></span></span></span>' +
		'<span class="date-chose fc-button ui-state-default ui-corner-right"><span class="fc-button-inner">' +
		'<span class="fc-button-content" id="all">全部</span><span class="fc-button-effect"><span></span></span></span></span><span>&nbsp;&nbsp;&nbsp;</span>'
		);
	
	// 数据显示选择 右上系统, 日程安排
	$('#sys').click(function () {
		dataType('sys')
	});
	$('#schedule').click(function () {
		dataType('schedule')
	});
	$('#inbox').click(function () {
		dataType('inbox')
	});
	$('#all').click(function () {
		dataType('all')
	});
	$('#' + $('#hideType').val()).closest('span.fc-button').addClass('ui-state-active')
	// 弹窗选择
	$('.calendar-repeat-edit-cancel button').click(function () {
		$("#chose").dialog("close");
	})
	
	$('.only-this-activity button').click(function () {
		repeatChange('only')
	})
	$('.follow-up-activities button').click(function () {
		repeatChange('follow')
	})
	$('.all-activities button').click(function () {
		repeatChange('all')
	})
	
	$('input[name="startTime"]').live('change', function () {
		var date1 = new Date()
			var s = $('input[name="hideDate"]').val() + ' ' + $('input[name="startTime"]').val() //"2005-12-15   09:41:30";
			var d = new Date(Date.parse(s.replace(/-/g, "/")));
		date1.setTime(d.getTime() - $('div').data('timeDiff'))
		$('input[name="endTime"]').val($.fullCalendar.formatDate(date1, "HH:mm"))
	});
});