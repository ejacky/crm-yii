<?php
class InsertRelationRecord
{
    public static function insertStaff()
    {    
        $sql = "INSERT INTO `pa_form_field` (`id`, `orderId`, `defaultValue`, `type`, `nameSpace`, `name`, `attr`, `category`, `label`, `isMust`, `time`) VALUES
        (22, 0, '', 'select', 'client', 'staff_id', :staffId, 'basic', '负责员工', 'must', '')"; 
        $params = array(':staffId' => self::fetchStaffId());
        Yii::app()->db->createCommand($sql)->execute($params);
    }
    
    public static function fetchStaffId()
    {
        $str = '';
        $staffModel = Staff::model()->findAll(); 
        foreach ($staffModel as $subStaffModel)
        {
            $str = $subStaffModel->id . ',' . $str;
        }
        return $str;
    }
    
    public static function insertCategory()
    {
        $sql = "INSERT INTO `pa_form_field` (`orderId`, `defaultValue`, `type`, `nameSpace`, `name`, `attr`, `category`, `label`, `isMust`, `time`) VALUES
        (0, '', 'select', 'customForm', 'category', :category, '', '分组', '', '')"; 
        $params = array(':category' => self::fetchCategory());
        Yii::app()->db->createCommand($sql)->execute($params);
    }
    
    public static function fetchCategory()
    {
        $str = '';
        $categoryModel = FieldGroup::model()->findAll(); 
        foreach ($categoryModel as $subCategoryModel)
        {
            $str = $subCategoryModel->name . ',' . $str;
        }
        return $str;
    }
}