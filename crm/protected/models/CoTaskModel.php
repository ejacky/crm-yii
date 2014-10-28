<?php
class CoTaskModel extends AdminModel
{
	/**
	 *
	 * @return CoTaskModel
	 */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'co_task';
    }
	
	public function saveData()
	{
		if ($this->isNew())
		{
			if (!self::model()->findByAttributes(array('name' => $_POST['form']['name']))){
				$model = new CoTaskModel();
				$model->name = $_POST['form']['name'];
				$model->displayName = $_POST['form']['displayName'];
				$model->description = $_POST['form']['description'];
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
