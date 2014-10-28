<?php
class PaField extends CActiveRecord
{
	public $formTypeName;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pa_field';
	}

	public function relations()
	{
		return array(
                        'forms' => array(self::MANY_MANY, 'Staff', 'pa_form_field(form_id,field_id)'),
			'formType' => array(self::BELONGS_TO, 'SingleCategory', '', 'on' => 'formType.name="type" and t.type=formType.key' ), //  and name=formType.key
                        'form' => array(self::BELONGS_TO, 'PaForm','form_id'),
		);
	}

	public function saveData($formInfo)
	{
		$info = $formInfo;
		/*
		 foreach ($formInfo as $name => $value)
		 {
		 $name = explode('udf_', $name);
		 $info[$name[1]] = $value;
		 }
		 *
		 */

		$this->label = $info['label'];
		$this->form_id = $info['formId'];
		$this->name = $info['name'];
		$this->type = $info['type'];
		if (isset($info['nameSpace']))
		{
			$this->nameSpace = $info['nameSpace'];
		}

		if (isset($info['category']))
		{
			$this->category = $info['category'];
		}
		if (isset($info['attr']))
		{
			$this->attr = $info['attr'];
		}
		if (isset($info['isMust']))
		{
			$isMust = '';

			foreach ($info['isMust'] as $name => $value)
			{
				$isMust = $value . ','. $isMust;
			}
			$this->isMust = $isMust;
		}
		if (isset($info['orderId']))
		{
			$this->orderId = $info['orderId'];
		}
		if (isset($info['defaultValue']))
		{
			$this->defaultValue = $info['defaultValue'];
		}
		$this->explain = $info['explain'];
		$isSave = $this->save();

		$this->saveFormField($this->id, $info['formId']);
		return $isSave;
	}

	public function saveFormField($fieldId, $formId)
	{
		$model = new FormField();
		$model->saveFormFieldInfo($fieldId, $formId);
	}

	public function findFormByKey($key)
	{
		$name = array();
		$fields = parent::model(__CLASS__)->findAll('nameSpace = :nameSpace', array(':nameSpace' => $key));

		foreach ($fields as $field)
		{
			$name[] = $field['name'];
		}

		return $name;
	}

	public function search($formId)
	{
		$criteria=new CDbCriteria;
		$criteria->condition = 'form_id = :formId';
		$criteria->with = array('formType');
		$criteria->params = array(':formId' => $formId);
		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
		));
	}

	public function attributeLabels()
	{
		$defaultArray = Tools::getTableTitles();
		return $defaultArray;
	}

	public function cover($fieldId, $formId)
	{
		if ($fieldId && $fileIdCover){
			foreach ($fileIdCover as $field){
				
			}
			return $this;
		}else{
			return $this;
		}
	}
}