<?php
class DepartmentModel extends AdminModel
{
	public $tempFathers = array();
	/**
	 *
	 * @return DepartmentModel
	 */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'co_department';
    }
	
	public function saveData()
	{
		$_POST['form']['departmentPosition'] = implode(',', $_POST['form']['departmentPosition']);
		if ($this->isNew())
		{
			if (!self::model()->findByAttributes(array('name' => $_POST['form']['name']))){
				$model = new DepartmentModel();
				$model->name = $_POST['form']['name'];
				$model->fatherId = $_POST['form']['fatherName'];
				$model->displayName = $_POST['form']['displayName'];
				$model->order = $_POST['form']['order'];
				$model->departmentPosition = $_POST['form']['departmentPosition'];
				$model->save();
			}
		}
		else
		{
			$model = self::model()->findByAttributes(array('name' => $_POST['form']['name']));
			$model->saveAttributes($_POST['form']);
		}
	}

	public function findAllFather($id)
	{
		$this->tempFathers = array();
		$this->findByIdRecursion($id);

		return array_reverse($this->tempFathers);
	}
	
	public function findByIdRecursion($id)
	{
		$self = self::model()->findByPk($id);
		$this->tempFathers[] = $self;
		if ($self['fatherId'])
		{
			self::model()->findByIdRecursion($self['fatherId']);
		}
	}
}
