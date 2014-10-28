<?php
class PaForm extends CActiveRecord
{

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pa_form';
	}

	public function relations()
	{
		return array(
            'fields' =>array(self::MANY_MANY, 'PaField', 'pa_form_field(form_name,fieldName)'), //多对多关系
		    'formfields' =>array(self::HAS_MANY, 'FormField', array('form_name'=>'name')),
		);
	}

	public function saveData($formValueInfo)
	{
		$this->name = $formValueInfo['name'];
		$this->label = $formValueInfo['label'];
		$this->isEdit = $formValueInfo['isEdit'];
                $this->groupName = $formValueInfo['groupName'];
		return $this->save();
	}

	public function search()
	{
		$criteria=new CDbCriteria;
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
        $defaultArray['name'] = '列表名';
        $defaultArray['label'] = '显示名称';
        return $defaultArray;
    }

}
