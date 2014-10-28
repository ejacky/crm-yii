<?php
class CommonInterfaceController extends Controller
{
        public function actionSpecialSelect() {
                
                $options = '';
                $groupNames = PaForm::model()->findByAttributes(array('name' => $_POST['formName']))->groupName;
                $groupNamesArray = explode(',', $groupNames);
                if (!empty($groupNamesArray[0])) {
                        foreach ($groupNamesArray as $name => $value) {
                                echo $options .= '<option value="' . $value . '">' . $value . '</option>';
                        }     
                } else {
                        echo $options = '<option value="default">default</option>'; 
                }              
        }
        
	public function actionAddOption()
	{
		if(isset($_POST['form'])){
			if (isset($_POST['form']['update'])){
				foreach ($_POST['form']['update'] as $key=>$val){
					$model = SingleCategory::model()->findByPk($key);
					$model->nameSpace = $_POST['nameSpace'];
					$model->name = $_POST['formName'];
					$model->key = $val['key'];
					$model->value = $val['value'];
					$model->sequence = $val['sequence'];
					$model->update();
				}
			}
			if (isset($_POST['form']['add'])){
				foreach ($_POST['form']['add'] as $key=>$val){
					$model = new SingleCategory();
					$model->nameSpace = $_POST['nameSpace'];
					$model->name = $_POST['formName'];
					$model->key = $val['key'];
					$model->value = $val['value'];
					$model->sequence = $val['sequence'];
					$model->save();
				}
			}
			echo json_encode(array('code'=>0,'nameSpace'=>$_POST['nameSpace'],'name'=>$_POST['formName']));
		}else
		echo json_encode(array('code'=>1,'message'=>'系统繁忙'));
	}

	public function actionGetDate()
	{
		$formView = new FormViewUpdate(new $_POST['nameSpace']());
		$ret = $formView->SingleAndCanAddOptionSelect(null, $_POST['name'], $_POST['label'] );
		echo "<table>".$ret."</table>";
	}

	public function actionDeleteOption()
	{
		if(SingleCategory::model()->deleteByPk( $_POST['id']))
		echo json_encode(array('code'=>1));
		else
		echo json_encode(array('code'=>0));
	}

	public function actionUploadPic()
	{
		if (isset($_POST)){
			if ($_FILES['file']['error']==4){
				$this->redirect(CHttpRequest::getUrlReferrer());
			}
			$attachment = new PaAttachment();
			$result = $attachment->save($_FILES['file']);
			echo $result['url'];
		}
	}

	public function actionUploadAvatar()
	{
		if (isset($_POST)){
			$targ_w = $targ_h = 100;
			$jpeg_quality = 90;
			$src = $_POST['pictureSrc'];
			$size=getimagesize($src);
			switch($size["mime"]){
				case "image/jpeg": $img_r = imagecreatefromjpeg($src);  break;
				case "image/gif": $img_r = imagecreatefromgif($src); break;
				case "image/png": $img_r = imagecreatefrompng($src); break;
				default: $img_r = false; break;
			}
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
			$img = substr($src,strrpos($src, '/')+1);
			$imgName = 'thumb_'.$img;
			$pathName = "upload/attachment/".$imgName ;
			imagejpeg($dst_r, $pathName);
			$attachment = new Attachment();
			$attachment->user_id = Yii::app()->user->id;
			$attachment->uploadName = $imgName;
			$attachment->path = $pathName;
			$attachment->type = 'Avatar';
			$attachment->uploadTime = date('Y-m-d H:i:s');
			$attachment->save();
			echo json_encode(array('src'=>"/".$pathName));
		}
	}

	public function actionGetAvatar()
	{
		$avatar = Attachment::model()->find('user_id=:id and type=:type ORDER BY id desc', array(':id'=>Yii::app()->user->id, ':type'=>'Avatar'));
		if ($avatar)
		echo json_encode(array('code'=>1, 'src'=>$avatar->path));
		else
		echo json_encode(array('code'=>0));
	}

	public function actionUploadAttach()
	{
		if (isset($_POST)){
			$attachment = new PaAttachment();
			$result = $attachment->save($_FILES['Filedata']);
			if ($result['error']==0){
				echo $result['id'];
			}else{
				echo '系统繁忙';
			}
		}
	}

	public function actionfileDelete()
	{
		if (isset($_POST)){
			$attachment = new PaAttachment();
			$result = $attachment->deleteById($_POST['id']);
			echo $result;
		}
	}

}