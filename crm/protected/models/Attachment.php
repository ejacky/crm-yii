<?php
class Attachment extends CActiveRecord
{
	public $image;
	public static function model($className=__class__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pa_attachment';
	}

	public function rules()
	{
		return array(
		//array('image','file','types'=>'jpg,gif,png,txt,php'),
		);
	}

	public function attributeLabels()
	{
		$defaultArray = Tools::getTableTitles();
		$defaultArray['id'] = 'ID号';
		$defaultArray['type'] = '相册';
		return $defaultArray;
	}

	public function saveAttachment($type)
	{
		$this->image = CUploadedFile::getInstance($this,'image');
		$this->uploadName = $this->image->name;
		$this->systemName = md5($this->image->name);
		$this->type = $_POST['type'];
		$this->userId = Yii::app()->user->id;
		//$this->orgId = Yii::app()->user->orgId;
		$this->extension = $this->image->extensionName;
		$this->uploadTime = date('y-m-d h:m:s');

		if($this->save())
		{
			$url = 'upload/images/' . $this->system_name . '.' . $this->image->extensionname;
			$this->image->saveAS($url);
		}
	}

	public function returnPhotosInfo($id)
	{
		return parent::model('photos')->findAll();  //this is wrong
	}

}
