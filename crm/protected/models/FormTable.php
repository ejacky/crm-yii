<?php
class FormTable extends CActiveRecord 
{
    public static function model($className = __CLASS__)
    {
        
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_table';
    }
    
    public function saveTable($tableInfo)
    {
        $selectedField = '';
        foreach ($tableInfo as $name => $value)
        {
            if ($name != 'tableName')
            {
                $selectedField = $value . ',' . $selectedField;
            }     
        }
        
        $this->tableName = $tableInfo['tableName'];
        $this->selectedField = $selectedField;
        $this->staff_id = Yii::app()->user->id;
        return $this->save();          
    }
}