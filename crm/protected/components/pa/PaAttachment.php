<?php

class PaAttachment extends CoBase
{
	public $allowFileType = array('txt', 'docx', 'doc', 'png', 'jpg', 'xlsx', 'TXT', 'DOCX', 'DOC', 'PNG', 'JPG', 'XLSX');

	public $maxFileSize = 10485760; // 10M

	public $errors = array(
	1 => '上传了不允许的扩展名',
	2 => '上传文件过大',
	);

	public function save($file, $allowFileType = null, $maxFileSize = null)
	{
		$pathinfo = pathinfo($file['name']);
		$extension = strtolower($pathinfo['extension']);
		
		/*if ($allowFileType !== null)
		{
			$this->allowFileType = $allowFileType;
		}else{
			$this->allowFileType = explode(',', NoSetting::getInstance()->getOneSetting('file', 'fileType'));
		}
		if ($maxFileSize !== null)
		{
			$this->maxFileSize = $maxFileSize;
		}else{
			$this->maxFileSize = NoSetting::getInstance()->getOneSetting('file', 'fileSize')*1024*1024;
		}
		if (!in_array($extension, $this->allowFileType))
		{
			return $this->error(1, array('uploadType' => $extension, 'allowType' => $this->allowFileType));
		}
		if ($file['size'] > $this->maxFileSize)
		{
			return $this->error(2, array('maxSize' => $this->maxFileSize));
		}*/

		$dir =  "upload" . DIRECTORY_SEPARATOR . "attachment" . DIRECTORY_SEPARATOR;  //文件路径, 文件夹
		if (!is_dir($dir)) {
			@mkdir($dir, 0755);
		}

		$user_id = Yii::app()->user->id;
		$systemName =  md5(time() . $user_id).'.'.$extension;
		move_uploaded_file( $file["tmp_name"],     $dir . $systemName);

		$attachment = new Attachment();
		$attachment->user_id = $user_id;
		$attachment->uploadName = $file['name'];
		$attachment->systemName = $systemName;
		$attachment->type = $file['type'];
		$attachment->extension = $extension;
		$attachment->size = $file['size'];
		$attachment->path = $dir . $systemName;
		$attachment->uploadTime = date('Y-m-d H:i:s');
		$attachment->save();

		return $this->success('附件上传成功', array('id' => $attachment->id, 'extension'=>$extension, 'name'=> $attachment->uploadName, 'url'=> $attachment->path));
	}

	public function getModelById($id)
	{
		return Attachment::model()->findByPk($id);
	}

	public function deleteById($id)
	{
		Attachment::model()->deleteByPk($id);
	}
}
?>
