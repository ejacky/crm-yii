<?php

class MiniAttachment extends MiniBase
{
    public $allowFileType = array('txt', 'docx', 'doc', 'png', 'jpg', 'xlsx');
    
    public $maxFileSize = 10485760; // 10M
	
	public $errors = array(
		1 => '上传了不允许的扩展名',
		2 => '上传文件过大',
	);
    
    public function save($file, $allowFileType = null, $maxFileSize = null)
    {
		if ($allowFileType !== null)
		{
			$this->allowFileType = $allowFileType;
		}
		
		if ($maxFileSize !== null)
		{
			$this->maxFileSize = $maxFileSize;
		}
		
		$pathinfo = pathinfo($file['name']);
		$extension = $pathinfo['extension'];
		
		if (!in_array($extension, $this->allowFileType))
		{
			return $this->error(1, array('uploadType' => $extension, 'allowType' => $this->allowFileType));
		}
		
		if ($file['size'] > $this->maxFileSize)
		{
			return $this->error(2, array('maxSize' => $this->maxFileSize));
		}

		$dir =  "upload" . DIRECTORY_SEPARATOR . "attachment" . DIRECTORY_SEPARATOR;  //文件路径, 文件夹
		if (!is_dir($dir)) {
			@mkdir($dir, 0755);
		}

		$userId = Yii::app()->user->id;
		$systemName =  md5(time() . $userId).'.'.$extension;
     
		move_uploaded_file($_FILES["file"]["tmp_name"],     $dir . $systemName);
    
		$attachment = new Attachment();
		$attachment->user_id = $userId;
		$attachment->upload_name = $file['name'];
		$attachment->system_name = $systemName;
		$attachment->type = $file['type'];
		$attachment->extension = $extension;
		$attachment->size = $file['size'];
		$attachment->path = $dir . $systemName;
		$attachment->upload_time = date('Y-m-d H:i:s');
		$attachment->save();
		
		return $this->success('附件上传成功', array('id' => $attachment->id, 'name'=> $attachment->upload_name));
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
