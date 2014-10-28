<?php
class TableDisplay
{
	public static function display($value, $row, $result)
	{
		return $value;
	}

	public static function displayDepartmentName($value, $row, $result)
	{
		$allFathers = DepartmentModel::model()->findAllFather($row['id']);
		$dosplayArray = array();
		foreach ($allFathers as $father)
		{
			$dosplayArray[] = $father['displayName'];
		}
		return implode(' - ', $dosplayArray);
	}
        
        public static function displayFormToField($value, $row, $result)
        {
                return '<a href="./fieldIndex?formname=' .$row['name'].'">' .$value. '</a>';
        }
        
        public static function displayCourseToBrowse($value, $row, $result)
        {
                return '<a href="./courseBrowse?courseId='.$row['id'].'">' .$value. '</a>';
        }
        public static function displayContactName()
        {
                $contactName = Contact::model()->findByPk($value)->name;
		return $contactName;                
        }
        
        public static function displayTaskName($value, $row, $result)
        {
                if (!$value)
                {
                        return '<a href="./addTask?clientId='. $row['id'] .'">录入</a>';
                }
        }
        
        public static function displayMoreContact($value)
        {
                
        }
}
