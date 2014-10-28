<?php
class CustomFormController extends Controller {
	public $layout = '//layouts/column2';

	public function actionPaFormList() {
                $this->render('paFormList', array('name' => 'formTable') );
	}

	public function actionPaFormCreate() {
		$model = new PaForm();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'newForm'))->formfields;
                
		$fields = PaForm::model()->findByAttributes(array('name' => 'newForm'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveData($_POST['form'])) {
				$this->redirect('paFormList');
			}
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
	}

	public function actionPaFormEdit() {
		$model = PaForm::model()->findByAttributes(array('name' => $_GET['name']));
		$formfields = PaForm::model()->findByAttributes(array('name' => 'newForm'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'newForm'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveData($_POST['form'])) {
				$this->redirect('paFormList');
			}
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
	}

	public function actionDeleteForm() {
		PaForm::model()->findByPk($_GET['formId'])->delete();
		$this->redirect('paFormList');
	}

	public function actionPaFieldList() 
        {
                 $this->render('paFieldList', array('name' => 'formFieldTable') );
                
	}
        
        public function actionPaFieldCreate() {
		$model = new FormField();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'newField'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'newField'))->fields ;
                
		if ($_POST){
			$model->insertData();
		}
		$this->render('application.apps.core.form.components._displayFieldForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
	}

	public function actionPaFieldEdit() {
		$model = FormField::model()->findByPk($_GET['fieldId']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'newField'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'newField'))->fields ;
		if ($_POST){
			$model->updateData();
		}
		$this->render('application.apps.core.form.components._newFieldFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
	}
        


	public function actionDeleteField() {
               // var_dump($_GET['fieldId']);exit;
		if (isset($_GET['fieldId'])) {
			PaField::model()->findByPk($_GET['fieldId'])->delete();
			$this->redirect(array('paFieldList', 'formId' => $_GET['formId']));
		}
	}

	public function actionGroupIndex() {
		$this->render('groupIndex', array(
		));
	}

	public function actionAddGroup() {
		$model = new SingleCategory();
		//$fieldModel = PaForm::model()->findByPk(12)->fields;
                $fieldModel = PaForm::model()->findByAttributes(array('name' => 'group'))->fields;
		if (isset($_POST['form'])) {
			$model->saveSingleCategoryInfo($_POST['form']);
		}
		$this->render('addGroup', array(
			'editModel' => $model,
			'fieldModel' => $fieldModel,
		));
	}

	public function actionDeleteGroup() {
		FieldGroup::model()->deleteByPk($_GET['groupId']);
		$this->redirect('addGroup');
	}

	public function actionAutoMapping() {
		FieldGroup::model()->deleteByPk($_GET['groupId']);
		$this->redirect('addGroup');
	}

}