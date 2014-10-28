//#addOption come from application.views.form.formTemplate
$(function () {
	$("#addOption").dialog({
		autoOpen : false,
		resizable : false,
		modal : true,
		open : function (event, ui) {
			//$(".ui-dialog-titlebar", $(this).parent()).hide();
		},
		width : 670,
		height : 370,
		zIndex : 1000
	})
	
	$('.rePassword').live('blur', function () {
		checkPassword(this);
	})
	
	/**
	 * 时间选择
	 */
	$("input[label='datePicker']").datepicker({
		dateFormat : 'yy-mm-dd',
		changeMonth : true,
		changeYear : true,
		monthNames : ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
		dayNamesShort : ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
		monthNamesShort : ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
		dayNamesMin : ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
		yearRange : "1970:2012",
		beforeShow : function (input, inst) {
			setTimeout("$('.ui-datepicker-calendar').show()", 1)
		},
		onChangeMonthYear : function (year, month, inst) {
			setTimeout("$('.ui-datepicker-calendar').show()", 1)
		},
	})
	
	$("input[label='monthPicker']").datepicker({
		changeMonth : true,
		changeYear : true,
		dateFormat : 'yy-mm',
		showButtonPanel : true,
		currentText : '本月',
		closeText : '确定',
		monthNamesShort : ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
		onClose : function (dateText, inst) {
			var month = $(".ui-datepicker-month").find("option:selected").val()
				var year = $(".ui-datepicker-year").find("option:selected").val()
				$(this).val(year + '-' + (parseInt(month) + 1));
		},
	});
	
	/**
	 *  添加选项组件
	 */
	var filterCount = 0
		$(".hidden input").attr({
			disabled : true
		})
		$(".addOption").live('click', function () {
			$('#ui-dialog-title-addOption').text('添加选项')
			$('.tipOption').html('')
			$("#addOption").html('<form id="addoptionForm">' + $('.popoption.' + $(this).attr('class').split(' ')[1]).html() + '</form>').dialog("open")
		//	$('div').data('ColumnClass', $(this).attr('class').split(' ')[1])
			$("#addoptionForm input").attr({
				disabled : false
			})
		})
		
		$('.addOptionButton').live('click', function () {
			filterCount++
			$('.template.optionModel').clone().removeClass('template').addClass('newOption').show().appendTo($('.tipOption')).trigger('adjustName')
		})
		
		$('.newOption').live('adjustName', function () {
			$('.newOption input[name="form[add][sequence]"]').attr({
				'name' : 'form[add]' + '[' + filterCount + '][sequence]]',
				disabled : false
			});
			$('.newOption input[name="form[add][key]"]').attr({
				'name' : 'form[add]' + '[' + filterCount + '][key]',
				disabled : false
			})
			$('.newOption input[name="form[add][value]"]').attr({
				'name' : 'form[add]' + '[' + filterCount + '][value]',
				disabled : false
			})
		})
		
		$('#addOption .submitOption').live('click', function () {
			$.post('/index.php/CommonInterface/addOption', $('#addoptionForm').serializeArray(), function (response) {
				if (response.code == 0) {
					$("#addOption").dialog('close')
					$('.' + $('div').data('ColumnClass')).load('/index.php/CommonInterface/GetDate', {
						nameSpace : $('input[name="nameSpace"]').val(),
						name : $('div').data('ColumnClass'),
						label : $('.' + $('div').data('ColumnClass') + ' table label').text()
					})
				} else {
					alert(response.message)
				}
			}, 'json');
		})
		
		$('.deleteOption').live('click', function () {
			if ($(this).attr('class').split(' ')[1] == undefined) {
				$(this).closest('.newOption').remove()
			} else {
				$.post('/index.php/CommonInterface/deleteOption', {
					id : $(this).attr('class').split(' ')[1]
				}, function (response) {
					if (response.code == 1) {
						$('div.' + $('div').data('ColumnClass')).load('/index.php/CommonInterface/GetDate', {
							nameSpace : $('input[name="nameSpace"]').val(),
							name : $('div').data('ColumnClass'),
							label : $('.' + $('div').data('ColumnClass') + ' table label').text()
						}, function (ret) {
							$("#addOption").html('<form id="addoptionForm">' + $('.popoption.' + $('div').data('ColumnClass')).html() + '</form>')
						});
					} else {
						alert(response.message)
					}
				}, 'json')
			}
		})
		
		/**
		 *  上传头像
		 */
		$('.uploadPic').live('click', function () {
			$('#ui-dialog-title-addOption').text('上传头像')
			$('#addOption').html('<form id="imageUpload" name="photo" enctype="multipart/form-data" action="/index.php/CommonInterface/uploadPic" method="post">' + $('.template.uploadPic').clone().removeClass('template').html() + '<form>')
                        $("#addOption").dialog('open')
		})
		
		$('#imageSelect div form .save_thumb').live('click', function () {
			$.post('/index.php/CommonInterface/UploadAvatar', $('#imageSelect div form').serializeArray(), function (response) {
				$("#imageSelect").dialog('close')
				$('.pictrueLoad').html($("<img/>").attr("src", 'http://www.crm.com/' + response.src))
				$('.pictrueLoad').append($('#imageSelect input[class="src"]').clone().attr({
						name : 'form[avatar]',
						value : response.src
					}))
			}, 'json');
		})
		
		/**
		 * 上传附件
		 */
		$('.postAttach1').live('click', function () {
			$('#ui-dialog-title-addOption').text('上传图片')
			$('#addOption').html($('.template.uploadPic').clone().removeClass('template').html())
			$("#addOption").dialog('open')
		})
                
                
		
		/**
		 * author jacky
		 * begin
		 */
		$('#tabs').tabs();
	
	$("#dialog:ui-dialog").dialog("destroy");
	
	var name = $("#name"),
	email = $("#email"),
	password = $("#password"),
	allFields = $([]).add(name).add(email).add(password),
	tips = $(".validateTips");
	
	function updateTips(t) {
		tips
		.text(t)
		.addClass("ui-state-highlight");
		setTimeout(function () {
			tips.removeClass("ui-state-highlight", 1500);
		}, 500);
	}
	
	function checkLength(o, n, min, max) {
		if (o.val().length > max || o.val().length < min) {
			o.addClass("ui-state-error");
			updateTips("Length of " + n + " must be between " +
				min + " and " + max + ".");
			return false;
		} else {
			return true;
		}
	}
	
	function checkRegexp(o, regexp, n) {
		if (!(regexp.test(o.val()))) {
			o.addClass("ui-state-error");
			updateTips(n);
			return false;
		} else {
			return true;
		}
	}
	
	$("#dialog-form").dialog({
		autoOpen : false,
		height : 300,
		width : 350,
		modal : true,
		buttons : {
			"提交显示" : function () {
				$('#columnDisplay').submit();
				
			},
			"撤销" : function () {
				$(this).dialog("close");
			}
		},
		close : function () {
			allFields.val("").removeClass("ui-state-error");
		}
	});
	
	$("#create-user")
	.button()
	.click(function () {
		$("#dialog-form").dialog("open");
	});
	
	//for clientCompany
	$("textarea[name='form[span-test1]']").blur(function () {
		alert($(this).text());
	});
	$('#tabs').tabs();
	$('#saveForm').click(function () {
		var canSubmit = true;
		$('input[type="text"]').each(function () {
			inputValue = $(this).val();
			name = $(this).attr('label');
			
			if (inputValue != '' && $(this).closest('td').next().html() != '') {
				switch (name) {
				case 'username':
					$(this).val() != '' ? '' : canSubmit = false;
					break;
				case 'email':
					checkEmail(this) ? '' : canSubmit = false;
					break;
				case 'IDCard':
					checkIDCard(this) ? '' : canSubmit = false;
					break;
				case 'MSN':
					checkEmail(this, 'msn') ? '' : canSubmit = false;
					break;
				case 'mobilePhone':
					checkMobilePhone(this) ? '' : canSubmit = false;
					break;
				case 'rePassword':
					checkPassword($('.rePassword')) ? '' : canSubmit = false;
					break;
				}
			}
		});
		
		if (canSubmit) {
			$('#company-form').submit();
		} else {
			alert('填写信息有误, 请确认')
		}
	});
	
	$('.form').submit(function () {
		var canSubmit;
		canSubmit = true;
		$('input[type="text"]').each(function () {
			inputValue = $(this).val();
			nameArray = $(this).attr('name');
			name = $(this).attr('label');
			if ($('.span2-' + name).text() == '*') {
				if (inputValue == '') {
					canSubmit = false;
					$('.span-' + name).text('不能为空！').css('color', 'red');
				}
			}
		});
		if (canSubmit != true) {
			return false;
		}
	});
	
	// chosen
	$(".chzn-select").chosen();
	/**
	 *end
	 */
})

var regex = {
	mobile : /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/,
	phone : /^(\d{3,4}-?)?\d{7,9}$/,
	email : /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/,
	zipcode : /^[0-9]{6}$/,
	age : /^[1-9]{1}\d?$/,
	IDCard : /(^\d{15}$)|(^\d{17}([0-9]|X|x)$)/
};

function fileDelete(obj) {
	
	$.post('/index.php/CommonInterface/fileDelete', {
		id : obj
	}, function () {
		//$('div').trigger('click1')
	})
}

/**
 * 前端验证函数
 *
 */

function checkRules(obj, regexObj) {
	if (!$(obj).val().match(regexObj)) {
		$(obj).closest('td').next().html('<span style="color:red;">' + $(obj).closest('td').prev().children().html() + '格式不正确！</span>');
		return false;
	} else {
		$(obj).closest('td').next().html('')
		return true;
	}
}

function checkPassword(obj) {
	if ($('input[name="form[password]"]').val() != $(obj).val()) {
		$(obj).closest('td').next().html('<span style="color:red;">两次输入密码不一致,请重新输入！</span>')
		return false;
	}
	pwd = $(obj).val().replace(/\s+/gm, '');
	if (pwd.length == 0 || pwd.length < 6 || pwd.length > 12) {
		$(obj).closest('td').next().html('<span style="color:red;">密码6-12 位，由数字或字母组成！</span>')
		return false;
	}
	$(obj).closest('td').next().html('')
	return true;
}

/* 前端验证结束 */

//上传头像组件 函数
//recall from application.views.form.formTemplate
function UploadFile() {
	if ($('input[name="file"]').val() != " ") {
		$("#addOption").dialog('close');
		$('#imageUpload').ajaxSubmit({
			success : function (html, status) {
				var result = html.replace("<pre>", "");
				result = result.replace("</pre>", "");
				var b = /\\/gi;
				var c = result.replace(b, "\/");
				$("<img/>").attr("src", 'http://www.crm.com/' + c).load(function () {
					imgWidth = this.width;
					imgHeight = this.height;
					$("#imageSelect").dialog({
						resizable : true,
						modal : true,
						width : imgWidth,
						zIndex : 1000,
						position : 'center',
					})
				});
				$('#imageSelect').html($('.template.templateThumbnail').clone().html())
				$('#imageSelect div div img').addClass('preview')
				$('#imageSelect div img').addClass('thumbnail')
				$('#imageSelect .preview,#imageSelect .thumbnail').attr({
					src : 'http://www.crm.com/' + c
				})
				$('#imageSelect div form .src').val(c)
				
				var jcrop_api,
				boundx,
				boundy;                            
				$('.thumbnail').Jcrop({
					onChange : updatePreview,
					onSelect : updatePreview,
					aspectRatio : 1
				}, function () {
					var bounds = this.getBounds();
					boundx = bounds[0];
					boundy = bounds[1];
					jcrop_api = this;
				});
				
				function updatePreview(c) {
					if (parseInt(c.w) > 0) {
						var rx = 100 / c.w;
						var ry = 100 / c.h;
						$('.preview').css({
							width : Math.round(rx * boundx) + 'px',
							height : Math.round(ry * boundy) + 'px',
							marginLeft : '-' + Math.round(rx * c.x) + 'px',
							marginTop : '-' + Math.round(ry * c.y) + 'px'
						});
					}
					$('.x').val(c.x);
					$('.y').val(c.y);
					$('.w').val(c.w);
					$('.h').val(c.h);
				};
			}
		});
	}
}

function selectToUrl(url) {
	window.location.href = url;
}

//from _newFieldForm
function displayField(type) {                       
        		switch (type) {
			case 'text': $('.textType, .defaultValue,.isMust,.rules,.category,.explain').show();	break;
			case 'textarea': $('.defaultValue, .isMust, .category, .explain').show();		break;
			case 'singleOutsideSelect': $('.tableModelName, .key, .defaultValue, .category, .condition').show();		break;

			case 'singleInnerSelect': $('.attr, .defaultValue, .category').show();		break;
			case 'innerRadio': $('.attr, .defaultValue, .category').show();		break;
			case 'innerCheckbox': $('.attr, .defaultValue, .category').show();		break;
			
			case 'outsideRadio': $('.tableModelName, .key, .defaultValue, .category, .condition').show();		break;
			case 'outsideCheckbox': $('.tableModelName, .key, .defaultValue, .category, .condition').show();		break;
			case 'multipleOutsideSelect': $('.nameSpace, .defaultValue, .category, .condition').show();		break;
			
			case 'SingleAndCanAddOptionSelect': $('.defaultValue, .category').show();		break;
			case 'provincePicker': $('.defaultValue, .category').show();		break;
			case 'monthPicker': $('.defaultValue').show();		break;
			case 'datePicker': $('.defaultValue').show();		break;
			case 'uploadPic': $('.defaultValue').show();		break;
                        case 'label':     $('.label, .attr, .tableModelName, .key').show();          break;
						case 'emptyLabel':     $('.emptyLabel').show();          break;
			case 'postAttach':		break;
			case 'password':		break;			
			default : $('.textType, .defaultValue,.isMust,.rules,.category,.explain').show(); break;
		}
}

$(function () {
        var type = '';
        $('.condition, .nameSpace, .key, .tableModelName, .attr, .explain, .rules,.isMust,.category,.defaultValue,.textType').hide();
        type = $('.FormFieldtype').val();
        displayField(type);
	$('.FormFieldtype').change(function(){
        $('.condition, .nameSpace, .key, .tableModelName, .attr, .explain, .rules,.isMust,.category,.defaultValue,.textType').hide();        
		 type = $(this).val();               
                 displayField(type);
                });	
	$('.hidden').hide();
})

displayTable = function(name, page, orderBy, condition)
{
	$.get('/admin.php/tableSet/render', {'name' : name, 'page' : page, 'orderBy' : orderBy, 'condition' : condition}, function(data){
		$('#tableContent').replaceWith(data);
	});
}

$(function () {
        formName = 'client';    //设置默认的表格名称为client
        displayGroupName(formName);
        $("#form_form_name").live("change", function () {
                var formName;
                formName = $(this).val();
                $("#form_groupName").find("option").remove().end();
                displayGroupName(formName);
        });
})
displayGroupName = function (formName) {
        $.post("/index.php/CommonInterface/specialSelect", { formName : formName}, function (data) {
                $("#form_groupName").append(data);

                });
}