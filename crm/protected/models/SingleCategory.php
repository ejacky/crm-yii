<?php
class SingleCategory extends CActiveRecord
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
		return 'pa_category';
	}
	
	public function relations()
	{
	    return array();
	}
        
        public function saveSingleCategoryInfo($info)
        {
            $this->nameSpace = $info['nameSpace'];
            $this->value = $info['value'];
            return $this->save();
        }
}

