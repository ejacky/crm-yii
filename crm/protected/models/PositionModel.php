<?php
class PositionModel extends AdminModel
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'co_position';
    }
	
	public function saveData()
	{
		if ($this->isNew())
		{
			if (!self::model()->findByAttributes(array('name' => $_POST['form']['name'])))
			{
				$model = new PositionModel();
				$model->name = $_POST['form']['name'];
				$model->displayName = $_POST['form']['displayName'];
				$model->save();
			}
		}
		else
		{
			$model = self::model()->findByAttributes(array('name' => $_POST['form']['name']));
			$model->saveAttributes($_POST['form']);
		}
	}

}
