<?php
class FieldGroup extends CActiveRecord 
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_field_group';
    }
    
    public function saveGroup($info)
    {
        $this->nameSpace = $info['nameSpace'];
        $this->groupName = $info['groupName'];
        return $this->save();
    }
    
    public function modelToArray()
    {
        $arr = array();
        
        foreach ($this->findAll() as $subList)
        {
            $arr[$subList->name] = $subList->name;
        }
        
        return $arr;
    }
}
