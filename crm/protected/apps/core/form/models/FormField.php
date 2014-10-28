<?php
class FormField extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pa_form_field';
	}

	public function relations()
	{
		return array(
			'forms' =>array(self::BELONGS_TO, 'PaForm', 'form_name'),
                        'fields' =>array(self::BELONGS_TO, 'PaField', 'fieldName'),
		);
	}

	public function insertData()
	{
		$index = null;
		if (isset($_POST['condition'])){
			foreach ($_POST['condition'] as $k=>$val){
				$arr[$k] = $val;
			}
                        
			$index = $_POST['condition']['index'];   
			$key = 'fieldNameCondition'.$index;
			$this->$key = json_encode($arr);
		}
		if (isset($_POST['form'])) {
			if ($_POST['form']['type']){
				$pafield = PaField::model()->findByAttributes(array('type'=>$_POST['form']['type']));
				$fieldName = 'fieldName'.$index ;
				$this->$fieldName = $pafield->name ;
			}
			if ($_POST['form']['form_name']){
				$this->form_name = $_POST['form']['form_name'] ;
			}
			foreach ($_POST['form'] as $key=>$val){
				$arrCover[$key] = $val;
			}
			$cover = 'fieldNameCover'.$index ;
			$this->$cover = json_encode($arrCover);
		}
		return $this->save();
	}

	public function updateInfo()
	{
		$index = null;
		if (isset($_POST['condition'])){
			foreach ($_POST['condition'] as $k=>$val){
				$arr[$k] = $val;
			}
			$index = $_POST['condition']['index'];
			$key = 'field_id_condition'.$index;
			$this->$key = json_encode($arr);
		}
		if (isset($_POST['form'])) {
			if ($_POST['form']['type']){
				$pafield = PaField::model()->findByAttributes(array('type'=>$_POST['form']['type']));
				$fieldId = 'field_id'.$index ;
				$this->$fieldId = $pafield->id ;
			}
			if ($_POST['form']['form_name']){
				$this->form_name = $_POST['form']['form_name'] ;
			}
			foreach ($_POST['form'] as $key=>$val){
				$arrCover[$key] = $val;
			}
			$cover = 'field_id_cover'.$index ;
			$this->$cover = json_encode($arrCover);
		}
		return $this->update();
	}

	public function search($formId)
	{
		$criteria=new CDbCriteria;
		$criteria->condition = 'form_name = :formId';
		$criteria->params = array(':formId' => $formId);
		//$criteria->with = array('formType');
		return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
		));
	}

}