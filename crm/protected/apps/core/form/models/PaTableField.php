<?php
class PaTableField extends CActiveRecord
{

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pa_table_Field';
	}

// 	public function relations()
// 	{
// 		return array(
//             'fields' =>array(self::MANY_MANY, 'PaField', 'pa_form_field(form_id,field_id)'),
// 		    'formfields' =>array(self::HAS_MANY, 'FormField', 'form_id'),
// 		);
// 	}

	public function saveTableInfo($tableValueInfo)
	{
		$this->sqlneeded = $tableValueInfo;
// 		$this->title = $tableValueInfo['title'];		
// 		$this->num_per_page = $tableValueInfo['numperpage'];
		return $this->save();
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '16',

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
