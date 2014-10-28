<?php
class TableModel extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'pa_table';
    }
    
    public function getContactInfo()
    {
        return parent::model(__CLASS__)->findAll();
    }
    
    public function updateFormInfo()
    {
		$tableName = $_POST['form']['name'];
		$tableModel = TableModel::model()->findByAttributes(array('name' => $tableName));
		$tableModel->label = $_POST['form']['label'];
		$tableModel->sql  = $_POST['form']['sql'];
		$tableModel->numPerPage = $_POST['form']['numPerPage'];
		$tableModel->save();
		$id = $tableModel->getPrimaryKey();

		TableItemModel::model()->deleteAllByAttributes(array('table_name' => $tableName));

		foreach ($_POST['item'] as $item)
		{
			$model = new TableItemModel;
			$model->table_name = $tableName;
			$model->itemName = $item['name'];
			$model->title = $item['title'];
			$model->itemDisplayMethod = isset($item['displayMethod']) ? $item['displayMethod'] : '';
			$model->html = isset($item['html']) ? $item['html'] : '';
			$model->itemOrder = isset($item['order']) ? $item['order'] : false;
			$model->enable = $item['enable'];
			$model->save();
		}

		return $tableName;
    }
	
	public function insertFormInfo()
	{
		$tableModel = new TableModel;
		$tableModel->label = $_POST['form']['label'];
		$tableModel->sql = $_POST['form']['sql'];
		$tableModel->name = $_POST['form']['name'];
		$tableModel->numPerPage = $_POST['form']['numPerPage'];
		$tableModel->save();

		TableItemModel::model()->deleteAllByAttributes(array('table_name' => $tableModel->name));

		foreach ($_POST['item'] as $item)
		{
			$model = new TableItemModel;
			$model->table_name = $tableModel->name;
			$model->itemName = $item['name'];
			$model->title = $item['title'];
			$model->itemDisplayMethod = isset($item['displayMethod']) ? $item['displayMethod'] : '';
			$model->html = isset($item['html']) ? $item['html'] : '';
			$model->itemOrder = isset($item['order']) ? $item['order'] : false;
			$model->enable = $item['enable'];
			$model->save();
		}
		
		return $tableModel->name;
	}

}
