<?php
if (Yii::app()->user->isGuest)
    $this->redirect('/admin.php/login');
?>
<style>
table { table-layout:fixed; width:100% }
</style>
<form method="get" action="/index.php/file/index">
<input name="name" type="text"/><input type="submit" value="查询"/>
</form>
<div style="overflow:auto;overflow-y:hidden;"> 
<?php
$name = isset($_GET['name']) ? $_GET['name'] : '';
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'file-grid',
	'dataProvider'=>$model->search($name),
	'template'=>'<div align=center>文件表单</div>{items}{summary}{pager}',
	'columns'=>$columns,
)); ?>
</div>
<button onclick="download();">下载选中</button>
<button onclick="deleteFile()">删除选中</button>

<script>
//下载文件
function download(){
	var id = $.cookie("id");
	if(id==null || id.length==0){
		alert('请选择文件');return false;
	}
	window.open("<?php echo Yii::app()->createUrl('file/download').'?id=' ?>"+id);
}

//删除文件
function deleteFile(){
	var id = $.cookie("id");
	if(id==null || id.length==0){
		alert('请选择文件');return false;
	}
	$.cookie('id','');
	window.location.href = ("<?php echo Yii::app()->createUrl('file/delete').'?id=' ?>"+id);
}

Array.prototype.indexOf = function(val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) return i;
    }
    return -1;
};

Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};

Array.prototype.del = function(n){
	var delLength = this.join(",").split(","+n)[0].split(",").length;
	if(delLength == this.length)
		return this.splice(0,1);
	else
		return this.splice(delLength,1);
}

$(document).ready(function(){
	var mycars=new Array();
	//页面初始, cookie有值, 则选择框被选
	$("input[name='file-grid_ccheckbox[]']").each(function () {
		if($.cookie('id')!=null && $.cookie('id')!=''){
			mycars = $.cookie('id').split(',');
			for (var i = 0; i <= mycars.length; i++) {
				if($(this).val() == mycars[i]){
					this.checked = true;
				}
		    }
		}else{
			$("input[name='file-grid_ccheckbox[]']").each(function () {
				this.checked = false;
			});
		}
	});

	$("#file-grid_ccheckbox_all").click( function () {
		if (this.checked) {
			$("input[name='file-grid_ccheckbox[]']").each(function () {
				if(this.checked==false){
					mycars.push( $(this).val());
				}
				this.checked = true;
			});
		} else {
			$("input[name='file-grid_ccheckbox[]']").each(function () {
				if(this.checked==true){
					mycars.del( $(this).val());
				}
				this.checked = false;
			});
		}
		$.cookie('id', mycars);	
	});

	$("input[name='file-grid_ccheckbox[]']").click(function () {
		if(this.checked == true){
			mycars.push( $(this).val());
			$.cookie('id', mycars);	
		}else{
			mycars.del($(this).val());
			$.cookie('id', mycars);
		}
	});
});
</script>