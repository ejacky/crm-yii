<?php
class Staff extends CActiveRecord
{
	public $position;

	/**
	 *
	 * @param type $className
	 * @return Category
	 */
	public static function model($className=__class__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'co_staff';
	}

	public function relations()
	{
		return array(
			'fields' =>array(self::MANY_MANY, 'PaField',
			'fu_crm_form_relation(staff_id,field_id)'),
		);
	}

	public function saveStaffInfo($staffInfo)
	{
		$this->username = $staffInfo['username'];
		$this->password = md5($staffInfo['password']);
		$this->email = $staffInfo['email'];
		$isNew = $this->isNewRecord;
		$hasSave = $this->save();
		if ($isNew)
		{
			$this->saveFormRelation($this->id);
		}
		return $hasSave;
	}

	public function saveAllStaffInfo($staffInfo)
	{
		$staffInfo['password'] = md5($staffInfo['password']);
		
		foreach ($staffInfo as $k=>$v){
			$this->$k = $v;
		}
		$hasSave = $this->save();
		return $hasSave;
	}

	public function saveFormRelation($staffId)
	{
		$fieldModel = PaField::model()->findByAttributes(array('name' => 'staff_id'));
		$relationModel = new FormRelation();
		$relationModel->field_id = $fieldModel->id;
		$relationModel->staff_id = $staffId;
		$relationModel->save();
	}

	public function getStaffInfo()
	{
		return parent::model(__CLASS__)->findAll();
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
				'pagination' => array(
				'pageSize' => '20',
			),
		));
	}

	public function attributeLabels()
	{
		$defaultArray = Tools::getTableTitles();
		$defaultArray['email'] = '邮箱';
		$defaultArray['name'] = '姓名';
		$defaultArray['ename'] = '英文名';
		$defaultArray['birthday'] = '生日';
		return $defaultArray;
	}
}