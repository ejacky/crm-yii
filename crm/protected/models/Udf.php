<?php



class Udf extends CActiveRecord
{
/**
     *
     * @param type $className
     * @return Udf
     */    
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_udf';
    }
    
    public function saveUdf($name, $value, $formPrimaryIndex, $distinguishForm)
    {
            $this->distinguishForm = $distinguishForm;
            $this->formPrimaryIndex = $formPrimaryIndex;
            $this->name = $name;
            $this->value = serialize($value);
            $this->date = date('y-m-d h:i:s');
            $this->save();   
    }
}