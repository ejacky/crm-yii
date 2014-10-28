<?php
class CalendarController extends Controller
{
	public $layout='//layouts/column2';
	public function actionIndex()
	{
		$staff = Staff::model()->findByPk(Yii::app()->user->id);
		$this->render('index', array('staff' => $staff));
	}

	public function actionUpdateTheme()
	{
		if ($_POST['theme']){
			Staff::model()->updateByPk(Yii::app()->user->id, array('calendarTheme'=>$_POST['theme']));
		}
	}

	//返回日程数据
	public function actionJson()
	{
		$start = $_GET['start'];
		$end  = $_GET['end'];
		$type = $_GET['type'];
                
		$calendar = new NoCalendar($start, $end);
		$arr = $calendar->getAllCalendarArray($type);
		echo json_encode($arr);
	}

	public function actionAdd()
	{   
		if ($_POST['data']) {
			$data = $_POST['data'];
			foreach ($data as $val){
				$arrData[$val['name']] = $val['value'];
			}
			$model = new Calendar();
			$model->user_id = Yii::app()->user->id;
			$model->title = strip_tags($arrData['title']);
                        $model->dataType = $arrData['Environment'];
			$model->startDate = $arrData['hideDate'];
			$model->repeatType  =  $arrData['repeatType'];
			$model->description  = $arrData['title'];
			$model->frequency  = $arrData['repeatFrequency'];
			$allday = $this->booleanConvertInt($arrData['allday']);
			$model->allday  =  $allday;
			if(!$allday){
				if($arrData['startTime']-$arrData['endTime']>0){
					$model->endTime  =  date("Y-m-d",strtotime($arrData['hideDate'])+86400).' '.$arrData['endTime'].':00';
				}else{
					$model->endTime  =  $arrData['hideDate'].' '.$arrData['endTime'].':00';
				}
				$model->startTime = $arrData['hideDate'].' '.$arrData['startTime'].':00';
			}else{
				$model->startTime = $arrData['hideDate'];
				$model->endTime  =  $arrData['hideDate'];
			}
			$strWeek = array();
			if ($arrData['repeatType']=='week'){
				for ($i=1; $i<=7; $i++){
					if(isset($arrData['repeatWeeks'.$i]) && $arrData['repeatWeeks'.$i]=='on'){
						array_push($strWeek, $i);
					};
				}
				$result = implode(",", $strWeek);
				$model->repeatWeek  = $result;
			}
			if ($arrData['repeatType']=='month'){
				$model->repeatMonth  = $arrData['repeatMonth'];
			}
			$model->save();
			echo json_encode(array('code'=>1,'Environment'=>$arrData['Environment']));
		}
	}

	public function actionEventDrop()
	{
		if ($_POST['data']) {
			$data = $_POST['data'];
			$data['end'] = $data['end'] ? $data['end'] : $data['start'];
			if(isset($data['id'])){
				Calendar::model()->updateByPk( $data['id'], array('startTime'=>$data['start'], 'endTime'=>$data['end'], 'allday' => $this->booleanConvertInt($data['allday'])) );
			}else{
				$time = strtotime($data['start']);
				$time = $time - $data['dayDelta']*86400 - $data['minuteDelta']*60 ;

				$model = new Calendar();
				$model->user_id = Yii::app()->user->id;
				$model->title = strip_tags($data['title']);
				$model->startTime = $data['start'];
				$model->endTime  =  $data['end'];
				$model->allday  =  $this->booleanConvertInt($data['allday']);
				$model->belongID  =  $data['repeatID'];
				$model->repeatType  =  'null';
				$model->description  = $data['title'];
				$model->originalTime  =  date('Y-m-d H:i:s',$time);
				$model->save();
			}
			echo json_encode(array(0=>1));
		}
	}

	public function actionEventResize()
	{
		if ($_POST['data']) {
			$data = $_POST['data'];
			if(isset($data['id'])){
				Calendar::model()->updateByPk( $data['id'], array('endTime'=>$data['end'] ));
			}else{
				if ($data['type']=='only'){
					$model = new Calendar();
					$model->user_id = Yii::app()->user->id;
					$model->title = strip_tags($data['title']);
					$model->startTime = $data['start'];
					$model->endTime  =  $data['end'];
					$model->belongID  =  $data['repeatID'];
					$model->repeatType  =  'null';
					$model->description  = $data['title'];
					$model->originalTime  =  $data['start'];
					$model->save();
				}elseif ($data['type']=='follow'){
					$repeatCalendar = Calendar::model()->findByPk($data['repeatID']);
					
					$model = new Calendar() ;
					$model->user_id = $repeatCalendar->user_id  ;
					$model->startTime = $data['start'] ;
					$model->endTime  =  $data['end'] ;
					$model->startDate  =  $data['start'] ;
					$model->endDate  =  $repeatCalendar->endDate  ;
					$model->repeatType  =  $repeatCalendar->repeatType ;
					$model->title = $repeatCalendar->title ;
					$model->frequency = $repeatCalendar->frequency ;
					$model->description  = $repeatCalendar->description ;
					$model->save();
					$repeatCalendar->endDate = $data['start'];
					$repeatCalendar->update();
				}elseif ($data['type']=='all'){
					Calendar::model()->updateByPk( $data['repeatID'], array('endTime'=>$data['end'] ));
				}
			}
			echo json_encode(array(0=>1));
		}
	}

	public function actionEventClick()
	{
		if ($_POST['data']) {
			$data = $_POST['data'];
			if(isset($data['id'])){
				Calendar::model()->updateByPk($data['id'], array(
					'title'=>strip_tags($data['title']),
					'description'=>$data['title'],
				));
			}else{
				if ($data['type']=='only'){
					$model = new Calendar();
					$model->user_id = Yii::app()->user->id;
					$model->title = strip_tags($data['title']);
					$model->startTime = $data['start'];
					$model->endTime  =  $data['end'];
					$model->belongID  =  $data['repeatID'];
					$model->repeatType  =  'null';
					$model->description  = $data['title'];
					$model->originalTime  =  $data['start'];
					$model->save();
				}elseif ($data['type']=='follow'){
					$repeatCalendar = Calendar::model()->findByPk($data['repeatID']);
					$model = new Calendar() ;
					$model->user_id = $repeatCalendar->user_id  ;
					$model->startTime = $data['start'] ;
					$model->endTime  =  $data['end'] ;
					$model->startDate  =  $data['start'] ;
					$model->endDate  =  $repeatCalendar->endDate  ;
					$model->repeatType  =  $repeatCalendar->repeatType ;
					$model->title = strip_tags($data['title']);
					$model->frequency = $repeatCalendar->frequency ;
					$model->description  = $data['title'];
					$model->save();
					
					$repeatCalendar->endDate = $data['start'];
					$repeatCalendar->update();
				}elseif ($data['type']=='all'){
					Calendar::model()->updateByPk( $data['repeatID'], array('title'=>strip_tags($data['title']), 'description'=>$data['title'] ));
				}
			}
			echo json_encode(array(0=>1));
		}
	}
        
        public function actionEventClickSys()
        {
            if ($_POST['data'])
            {
                echo json_encode();
            }
        }

	private function booleanConvertInt($str)
	{
		return $str=='true'? 1 : 0 ;
	}
	
	public function actionEventDelete()
	{
		$data = $_POST['data'];
		if(isset($data['id'])){
			Calendar::model()->deleteByPk($data['id']);
		}
		if (isset($data['type']) && $data['type']=='all'){
			Calendar::model()->deleteByPk($data['repeatID']);
		}
		if (isset($data['type']) && $data['type']=='only'){
			$model = new Calendar();
			$model->user_id = Yii::app()->user->id;
			$model->belongID  =  $data['repeatID'];
			$model->repeatType  =  'null';
			$model->originalTime  =  $data['start'];
			$model->save();
		}
		if (isset($data['type']) && $data['type']=='follow'){
			$repeatCalendar = Calendar::model()->findByPk($data['repeatID']);
			$repeatCalendar->endDate = $data['start'];
			$repeatCalendar->update();
		}
		echo json_encode(array(0=>1));
	}
        
        public function actionDisplayCalendar()
        {
        $model = new Calendar();
        $notice = '';
        foreach ($model->findAll() as $sub)
        {
            if ($sub->startTime == date('y-m-d H:i:s'))
            {
                $notice .= $sub->title . '';
            }
        }
        echo $notice;
        }
}