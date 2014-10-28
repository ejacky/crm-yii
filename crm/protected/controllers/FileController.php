<?php
class FileController extends Controller
{
	public $layout='//layouts/column2';
	public function actionIndex()
	{
		$model = new File();
		$columns = TableView::fetchFileColumns($model);
		$this->render('index', array('model' => $model, 'columns' => $columns));
	}

	/**
	 *
	 * 文件上传
	 */
	public function actionUpload()
	{
		if (isset($_POST['form'])){
			foreach ($_POST['form'] as $form){
				$f = new File();
				$f->user_id = Yii::app()->user->id;
				$name = Staff::model()->findByPk(Yii::app()->user->id);
				$f->userName_re = $name ? $name->username : 'null';
				$f->attachment_id = $form['id'];
				$f->fileName_re = $form['name'];
				$f->time = date("Y-m-d H:i:s");
				$f->save();
			}
			$this->redirect(array('index'));
		}else{
			$model1 = PaField::model()->findAllByAttributes(array('nameSpace' => 'file'));
			$this->render('_form',array(
	            'model' => null,
	            'model1' => $model1,
	            'groupList' => FieldGroup::model()->findAllByAttributes(array('nameSpace' => 'file')),       
			));
		}
	}
	
	/**
	 * 
	 * 上传设置页面
	 */
	public function actionSetting()
	{
		$setting = NoSetting::getInstance()->getAllSetting('file');
		if (isset($_POST['form'])){
			foreach ($_POST['form'] as $key=>$value) {
				foreach ($setting as $val) {
					if ($key==$val->key){
						$val->nameSpace = Yii::app()->controller->id;
						$val->key = $key;
						$val->value = $value;
						$val->update();
					}
				}
			}
			$this->redirect(array('index'));
		}else{
			$model = new File();
			$model1 = PaField::model()->findAllByAttributes(array('nameSpace' => 'setting'));
			$this->render('_form',array(
	            'model' => $setting,
	            'model1' => $model1,
	            'groupList' => FieldGroup::model()->findAllByAttributes(array('nameSpace' => 'setting')),       
			));
		}
	}

	/**
	 *
	 * 文件下载
	 */
	public function actionDownload()
	{
		if (isset($_GET['id'])){
			$arr = explode(",", $_GET['id']);
			if (count($arr)==1){
				$coUpload = new PaUpload($arr[0]);
				$attachment = $coUpload->getAttachmentById($arr[0]);
				$fileRealName = mb_convert_encoding($attachment->uploadName, 'GBK', 'UTF-8');
				if (file_exists($attachment->path)){
					$filename =  $attachment->path;
				}else {
					Yii::app()->user->setFlash('errorInfo',  '该文件不存在!');
					$this->redirect(CHttpRequest::getUrlReferrer());
				}
			}else{
				$zip = new ZipArchive();
				$fileRealName = time().".zip";
				$filename =  'upload/attachment/'.$fileRealName;
				if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
					exit("cannot open <$filename>\n");
				}
				foreach ($arr as $val){
					//todo 应当使用file表id
					$coUpload = new PaUpload($val);
					$attachment = $coUpload->getAttachmentById($val);
					if (file_exists($attachment->path)){
						$zip->addFile($attachment->path, mb_convert_encoding($attachment->uploadName, 'GBK', 'UTF-8'));
					}
				}
				$zip->close();
			}
			header('Content-Type: application/octet-stream');
			header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($filename));
			header('Content-Disposition: attachment; filename="'.$fileRealName.'"');
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: no-cache');
			@readfile($filename);
			//unlink($filename);
		}else{
			$this->redirect(array('index'));
		}
	}

	/**
	 * 删除文件
	 */

	public function actionDelete()
	{
		if (isset($_GET['id'])){
			$arr = explode(",", $_GET['id']);
			foreach ($arr as $val){
				$count = File::model()->deleteAll('id=:id',array(':id'=>$val));
			}
			if($count>0){
				Yii::app()->user->setFlash('pageInfo', '文件删除成功');
				$this->redirect(array('index'));
			}else{
				Yii::app()->user->setFlash('pageInfo', '文件删除失败');
				$this->redirect(array('index'));
			}
		}else{
			$this->redirect(array('index'));
		}
	}
}
