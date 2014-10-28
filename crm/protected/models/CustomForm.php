<?php
class CustomForm extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_custom_form';
    }
    
    public function saveCustomForm($info)
    {
        $this->name = $info['name'];
        $this->category = $info['category'];
        return $this->save();
    }
}
