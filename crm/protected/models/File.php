<?php
class File extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'no_file';
	}

	public function relations()
	{
		return array(
            'attachment' =>array(self::BELONGS_TO, 'Attachment', 'attachment_id'),
		);
	}

	public function getAllFile()
	{
		
	}

	public function rules()
	{
		return array();
	}

	public function search($condition='')
	{
		$criteria=new CDbCriteria;
		if ($condition){
			$criteria->addSearchCondition('fileName_re', $condition);
		}
		return new CActiveDataProvider($this, array( 'criteria'=>$criteria, ));
	}

	public function attributeLabels()
	{
		$defaultArray = Tools::getTableTitles();
		$defaultArray['time'] = '上传时间';
		return $defaultArray;
	}
}