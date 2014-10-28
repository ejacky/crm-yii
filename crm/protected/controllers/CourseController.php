<?php
class CourseController extends Controller 
{
    public $layout = '//layouts/column2';
    
    	public function actionAddOption()
	{
		if(isset($_POST['form'])){
			if (isset($_POST['form']['update'])){
				foreach ($_POST['form']['update'] as $key=>$val){
					$model = SingleCategory::model()->findByPk($key);
					$model->nameSpace = $_POST['nameSpace'];
					$model->name = $_POST['formName'];
					$model->value = $val[$_POST['formName']];
					$model->sequence = $val['sequence'];
					$model->update();
				}
			}
			if (isset($_POST['form']['add'])){
				foreach ($_POST['form']['add'] as $key=>$val){
					$model = new SingleCategory();
					$model->nameSpace = $_POST['nameSpace'];
					$model->name = $_POST['formName'];
					$model->value = $val[$_POST['formName']];
					$model->sequence = $val['sequence'];
					$model->save();
				}
			}
			echo json_encode(array('code'=>0,'nameSpace'=>$_POST['nameSpace'],'name'=>$_POST['formName']));
		}else
		echo json_encode(array('code'=>1,'message'=>'系统繁忙'));
	}

	public function actionGetDate()
	{
		$formView = new FormView(new $_POST['nameSpace']());
		$ret = $formView->getaddOption( $_POST['name'], $_POST['label'] );
		echo "<table>".$ret."</table>";
	}

	public function actionDeleteOption()
	{
		if(SingleCategory::model()->deleteByPk( $_POST['id']))
			echo json_encode(array('code'=>1));
		else
			echo json_encode(array('code'=>0));
	}

	public function actionUploadPic()
	{
		if (isset($_POST)){
			if ($_FILES['file']['error']==4){
				$this->redirect(CHttpRequest::getUrlReferrer());
			}
			$attachment = new PaAttachment();
			$result = $attachment->save($_FILES['file']);
			echo $result['url'];
		}
	}

	public function actionUploadAvatar()
	{
		if (isset($_POST)){
			$targ_w = $targ_h = 100;
			$jpeg_quality = 90;
			$src = $_POST['pictureSrc'];
			$size=getimagesize($src);
			switch($size["mime"]){
				case "image/jpeg": $img_r = imagecreatefromjpeg($src);  break;
				case "image/gif": $img_r = imagecreatefromgif($src); break;
				case "image/png": $img_r = imagecreatefrompng($src); break;
				default: $img_r = false; break;
			}
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
			$img = substr($src,strrpos($src, '/')+1);
			$imgName = 'thumb_'.$img;
			imagejpeg($dst_r, "upload/attachment/".$imgName);
			$attachment = new Attachment();
			$attachment->user_id = Yii::app()->user->id;
			$attachment->uploadName = $imgName;
			$attachment->path = "upload/".$imgName;
			$attachment->type = 'Avatar';
			$attachment->uploadTime = date('Y-m-d H:i:s');
			$attachment->save();
			echo json_encode(array('src'=>'upload/attachment/'.$imgName));
		}
	}

	public function actionGetAvatar()
	{
		$avatar = Attachment::model()->find('user_id=:id and type=:type', array(':id'=>Yii::app()->user->id, ':type'=>'Avatar'));
		if ($avatar)
		echo json_encode(array('code'=>1, 'src'=>$avatar->path));
		else
		echo json_encode(array('code'=>0));
	}

	public function actionUploadAttach()
	{
		if (isset($_POST)){
			if ($_FILES['Filedata']['error']==4){
				//$this->redirect(CHttpRequest::getUrlReferrer());
			}
			$attachment = new PaAttachment();
			$result = $attachment->save($_FILES['Filedata']);
			echo $result['id'];
		}
	}

	public function actionfileDelete()
	{
		if (isset($_POST)){
			$attachment = new PaAttachment();
			$result = $attachment->deleteById($_POST['id']);
			echo $result;
		}
	}
    
    public function actionIndex()
    {
                 $this->render('index', array('name' => 'courseTable') );    
    }
    
    public function actionAddCourse()
    {
        	$model = new TrainCourse();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'course'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'course'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveCourseInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));	
    }
    
    public function actionEditCourse()
    {
                $model = TrainCourse::model()->findByPk($_GET['courseId']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'course'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'course'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveCourseInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
    }
    
    public function actionDeleteCourse()
    {
        TrainCourse::model()->findByPk($_GET['courseId'])->delete();
        $this->redirect('index');
    }
    
     public function actioncourseBrowse()
     {
             //echo $_SERVER['HTTP_REFERER'];
             $courseId = isset($_GET['courseId'])?$_GET['courseId']:1;
     	 $detailCourseModel = TrainCourse::model()->findByPk($courseId);
         $courseType = isset($_GET['courseHistoryType'])? $_GET['courseHistoryType'] : '<>';
         if (isset($_GET['courseId']))
         {
             $criteria = new CDbCriteria();
             $criteria->condition = 'course_id = :courseId and type = :type order by date desc';
             $criteria->params = array(
                 ':courseId'=>$_GET['courseId'],':type' => $courseType,
                 );           
             $item_count = CourseHistory::model()->count($criteria);
             $pages = new CPagination($item_count);
             $pages->setPageSize(2);
             $pages->applyLimit($criteria);
             $getcourseHistorys = CourseHistory::model()->findAll($criteria);
         }
         
         if (strpos($_SERVER['HTTP_REFERER'], 'index'))
         {
                 $initHtml = CourseHistory::model()->showCourseHistoryInfo($courseId, 'all');
         }
         else 
         {
                 $initHtml = '';
         }

         $this->render('courseBrowse',array(
             'detailCourseModel' => $detailCourseModel, 
             'getcourseHistorys' => $getcourseHistorys,
             'pages' => $pages,
             'courseId' => $_GET['courseId'],
             'returnType' => $courseType,
             'returnCourse' => TrainCourse::model()->findByPk($_GET['courseId'])->courseName,
             
             'initHtml' => $initHtml,
             'name' => 'traineeTable',
         ));
     }
     
     public function actionShowHistoryAjax()
     {
         if ($_POST['courseId'])
         {
                 echo CourseHistory::model()->showCourseHistoryInfo($_POST['courseId'], $_POST['courseHistoryType']);
         }
     }
     
     
    
    public function actionLecturerIndex()
    {
                 $this->render('lecturerIndex', array('name' => 'lecturerTable') );
    }
    
    public function actionAddLecturer()
    {
        	$model = new TrainLecturer();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'lecturer'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'lecturer'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveLecturerInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.modules.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));	
    }
    
    public function actionEditLecturer()
    {
                $model = TrainLecturer::model()->findByPk($_GET['lecturerId']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'lecturer'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'lecturer'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveLecturerInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
                
		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
    }
    
    public function actionDeleteLecturer()
    {
        TrainLecturer::model()->findByPk($_GET['lecturerId'])->delete();
        $this->redirect('lecturerIndex');
    }
    
    public function actionAddTrainee()
    {
        	$model = new TrainTrainee();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'trainee'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'trainee'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveTraineeInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));	
    }
    
    public function actionEditTrainee()
    {
                $model = TrainTrainee::model()->findByPk($_GET['traineeId']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'trainee'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'trainee'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveTraineeInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
    }
    
    public function actionDeleteTrainee()
    {
        TrainTrainee::model()->findByPk($_GET['traineeId'])->delete();
        $this->redirect(array('account/courseBrowse', 'courseId' => 1));
    }
    
    public function actionQuestionnaireIndex()
    {
        $model = new TrainQuestionnaire();
        $columns = TableView::fetchQuestionnaireColumns();
        $this->render('questionnaireIndex', array(
            'model' => $model,
            'columns' => $columns,
        ));
    }
    public function actionAddQuestionnaire()
    {
        	$model = new TrainQuestionnaire();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'questionnaire'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'questionnaire'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveQuestionnaireInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));	
    }
    
    public function actionEditQuestionnaire()
    {
                $model = TrainQuestionnaire::model()->findByPk($_GET['courseId']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'questionnaire'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'questionnaire'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveQuestionnaireInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
    }
    
    public function actionDeleteQuestionnaire()
    {
        TrainQuestionnaire::model()->findByPk($_GET['quesId'])->delete();
        $this->redirect('questionnaireIndex');
    }
}
