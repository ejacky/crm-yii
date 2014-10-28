<?php

/**
 *
 * @author sam sam@ozzyad.com
 *
 */
class  NoCalendar
{
	private $start ;
	private $end ;
	private $calendar ;
	private $beforeColor ;
	private $endColor ;
	private $daySecond = 86400 ;
	private $weekSecond = 604800 ;

	public function __construct($start, $end)
	{
		$this->start = $start;
		$this->end = $end;
	}

	public function getAllCalendarArray($type)
	{
		if ($type=='all'){
			$arrSys = $this->getNoRepeatCalendar('sys');
			$arrNoRepeat = $this->getNoRepeatCalendar('null');
			$arrRepeat = $this->getRepeatCalendar('sys');
			$arr = array_merge($arrSys, $arrNoRepeat, $arrRepeat);
		}
		if ($type=='sys'){
			$arr = $this->getNoRepeatCalendar('sys');
		}
		if ($type=='schedule'){
			$arrNoRepeat = $this->getNoRepeatCalendar('schedule');
			$arrRepeat = $this->getRepeatCalendar('schedule');
			$arr = array_merge($arrNoRepeat, $arrRepeat);
		}
                if ($type=='inbox') {
                        $arrNoRepeat = $this->getNoRepeatCalendar('inbox');;
                        $arrRepeat = $this->getRepeatCalendar('inbox');
                        $arr = array_merge($arrNoRepeat, $arrRepeat); 
                }
		return $arr;
	}

	public function getNoRepeatCalendar($type)
	{
		$criteria=new CDbCriteria;
		if ($type=='sys'){
			$criteria->addCondition("startTime>='".date("Y-m-d", $this->start)."' and '".date("Y-m-d", $this->end)."'>endTime and dataType='$type'");
		}
     		if ($type=='null'){
			$criteria->addCondition("startTime>='".date("Y-m-d", $this->start)."' and '".date("Y-m-d", $this->end)."'>endTime and repeatType='$type' and dataType<>'sys'");
		}
		if ($type=='schedule'){
			$criteria->addCondition("startTime>='".date("Y-m-d", $this->start)."' and '".date("Y-m-d", $this->end)."'>endTime and repeatType='null' and dataType='$type'");
		}
		if ($type=='inbox'){
			$criteria->addCondition("startTime>='".date("Y-m-d", $this->start)."' and '".date("Y-m-d", $this->end)."'>endTime and repeatType='null' and dataType='$type'");
		}
		$arrObject = Calendar::model()->findAll($criteria);
                //$arrObject = Calendar::model()->findAll();
               
		if ($arrObject){
                        $allName = '';
			foreach ($arrObject as $this->calendar){                            
				$arr[] = $this->buildArray($this->calendar->startTime, $this->calendar->endTime);
                                if ($type == 'sys')
                                {
                                    $allName .= $this->calendar->title;
                                }
			}
                        $arr[] = array('allName' => $allName);
                        return $arr;
		}
		return array();
	}

	private function buildArray( $startTime, $endTime )
	{
		$color = $this->getColor($endTime);
		$id = $this->calendar->repeatType == 'null' ? 'id' : 'repeatID' ;
		$arr = array(
		$id => $this->calendar->id,
				'title' => $this->calendar->title,
				'start' => $startTime,
    			'end' 	=> $endTime,
				'allday'=> (boolean)$this->calendar->allday,
				'description'=> $this->calendar->description,
				'color'=> $color,
                                'dataType' => $this->calendar->dataType,
		);
		return $arr ;
	}

	private function getRepeatCalendar($type)
	{
		$criteria=new CDbCriteria;
                if ($type == 'sys')
                {
                    $criteria->addCondition("repeatType<>'null' and startDate<'".date("Y-m-d", $this->end)."'");
                }
                else
                {
                    $criteria->addCondition("repeatType<>'null' and startDate<'".date("Y-m-d", $this->end)."' and dataType='$type'");
                }
		
		$arrObject = Calendar::model()->findAll($criteria);
		$arrDay = $arrWeek = $arrMonth = $arrYear = array();
		foreach ($arrObject as $this->calendar){
			$arrayRepeat = $this->getRepeatArray();
			if ($this->calendar->repeatType == 'day'){
				$arrDay = array_merge($arrDay, $this->getDayRepeat( $arrayRepeat ));
			}
			if ($this->calendar->repeatType == 'week'){
				$arrWeek = array_merge($arrWeek, $this->getWeekRepeat( $arrayRepeat ));
			}
			if ($this->calendar->repeatType == 'month'){
				$arrMonth = array_merge($arrMonth, $this->getMonthRepeat( $arrayRepeat ));
			}
			if ($this->calendar->repeatType == 'year'){
				$arrYear = array_merge($arrYear, $this->getYearRepeat( $arrayRepeat ));
			}
		}
		return array_merge($arrDay, $arrWeek, $arrMonth, $arrYear) ;
	}

	private function getRepeatArray()
	{
		$arrayRepeat = array();
		$Repeat = Calendar::model()->findAll('belongID=:id', array(':id'=>$this->calendar->id));
		if ($Repeat){
			foreach ($Repeat as $var){
				array_push($arrayRepeat, $var->originalTime);
			}
		}
		return $arrayRepeat;
	}

	/**
	 * 获取每天重复数据
	 */
	private function getDayRepeat( $arrayRepeat )
	{
		if (strtotime($this->calendar->startDate) > ($this->start)){
			$date = strtotime($this->calendar->startDate);
		}else{
			$day = (($this->start) - strtotime($this->calendar->startDate)) / $this->daySecond % $this->calendar->frequency;
			$date = ($this->start)+ $this->daySecond * ($day<=0 ? 0 : $this->calendar->frequency-$day);
		}
		$date1 = getdate($date);
		$date2 = getdate(strtotime($this->calendar->startTime));
		$date3 = getdate(strtotime($this->calendar->endTime));
		$time1 = mktime($date2['hours'], $date2['minutes'], $date2['seconds'], $date1['mon'], $date1['mday'], $date1['year'] );
		$time2 = mktime($date3['hours'], $date3['minutes'], $date3['seconds'], $date1['mon'], $date1['mday'], $date1['year'] );
		$arrDay = array();
		for( $i = 0; $i<($this->setEndDate() - $date)/$this->daySecond/$this->calendar->frequency; $i++){
			$startTime = date('Y-m-d H:i:s', $time1 + $this->daySecond*$i*$this->calendar->frequency);
			if (!in_array($startTime, $arrayRepeat)){
				$endTime = date('Y-m-d H:i:s', $time2 + $this->daySecond*$i*$this->calendar->frequency);
				$arrDay[] = $this->buildArray($startTime, $endTime);
			}
		}
		return $arrDay;
	}

	/**
	 * 周
	 */
	private function getWeekRepeat( $arrayRepeat )
	{
		$repeatWeek = explode(',', $this->calendar->repeatWeek);
		if (strtotime($this->calendar->startDate) > ($this->start)){
			$date = strtotime($this->calendar->startDate);
		}else{
			$day = (($this->start) - strtotime($this->calendar->startDate))/$this->weekSecond;
			$date = ($this->start)+ $this->weekSecond * ($day<=0 ? 0 : $this->calendar->frequency - $day );
		}
		$date1 = getdate($date);
		$date2 = getdate(strtotime($this->calendar->startTime));
		$date3 = getdate(strtotime($this->calendar->endTime));
		$time1 = mktime($date2['hours'], $date2['minutes'], $date2['seconds'], $date1['mon'], $date1['mday'], $date1['year'] );
		$time2 = mktime($date3['hours'], $date3['minutes'], $date3['seconds'], $date1['mon'], $date1['mday'], $date1['year'] );
		$arrweek = array();
		if ($repeatWeek){
			$j = $this->calendar->frequency ;
			for( $i = 0; $i<($this->setEndDate() - $date)/$this->daySecond; $i++){
				if ($i!=0 && $i%7==0){
					$j++;
				}
				if ($j%$this->calendar->frequency==0){
					if(in_array(idate('w', $time1 + $this->daySecond*$i), $repeatWeek)){
						$startTime = date('Y-m-d H:i:s', $time1 + $this->daySecond*$i);
						if (!in_array($startTime, $arrayRepeat)){
							$endTime = date('Y-m-d H:i:s', $time2 + $this->daySecond*$i);
							$arrweek[] = $this->buildArray($startTime, $endTime);
						}
					}
				}
			}
		}
		return $arrweek;
	}

	/**
	 * 月
	 */
	private function getMonthRepeat( $arrayRepeat)
	{
		$monthArray = $this->getMonth();
		$arrMonth = array();
		$day = idate('d',  strtotime($this->calendar->startDate));
		for( $i = 0; $i<($this->setEndDate() - $this->start)/$this->daySecond; $i++){
			$date = $this->start + $this->daySecond*$i ;
			foreach ($monthArray as $val){
				if($date >= strtotime($this->calendar->startDate) && idate('d', $date) == $day && idate('m', $date)==$val['month'] && idate('Y', $date)==$val['year']){
					$arrMonth[] = $this->handleCalendarArray($date, $arrayRepeat);
				}
			}
		}
		return $arrMonth;
	}

	/**
	 * 年
	 */
	private function getYearRepeat( $arrayRepeat)
	{
		$arrYear = array();
		$startDate = getdate(strtotime($this->calendar->startDate));
		for( $i = 0; $i<($this->setEndDate() - $this->start)/$this->daySecond; $i++){
			$date = $this->start + $this->daySecond*$i ;
			if( idate('d', $date) == $startDate['mday'] &&  idate('m', $date) == $startDate['mon']){
				for ($j=idate('Y', $date); $j<=idate('Y', $date); ($j+=$this->calendar->frequency)){
					if( 0 == ($j-$startDate['year'])%$this->calendar->frequency ){
						$arrYear[] = $this->handleCalendarArray($date, $arrayRepeat);
					}
				}
			}
		}
		return $arrYear;
	}

	private function handleCalendarArray($date, $arrayRepeat)
	{
		$arrCalendar = array();
		$date1 = getdate($date);
		$date2 = getdate(strtotime($this->calendar->startTime));
		$date3 = getdate(strtotime($this->calendar->endTime));
		$startTime = date('Y-m-d H:i:s', mktime($date2['hours'], $date2['minutes'], $date2['seconds'], $date1['mon'], $date1['mday'], $date1['year']));
		if (!in_array($startTime, $arrayRepeat)){
			$endTime = date('Y-m-d H:i:s', mktime($date3['hours'], $date3['minutes'], $date3['seconds'], $date1['mon'], $date1['mday'], $date1['year']));
			$arrCalendar = $this->buildArray($startTime, $endTime);
		}
		return $arrCalendar;
	}

	/**
	 *
	 * 获取循环月份 年份
	 */
	private function getMonth()
	{
		$month = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$startYear = idate('Y',  strtotime($this->calendar->startDate));
		$year = array($startYear=>$month);
		for($i=0; $i<(idate('Y', $this->setEndDate()) - $startYear); $i++){
			$year += array($startYear+$i+1=>$month);
		}
		$i = - idate('m',  strtotime($this->calendar->startDate)) ;
		$j = 1;
		$yearArr = array();
		foreach ($year as $key=>$val){
			foreach ($val as $v) {
				$i++ ;
				if ($i % $this->calendar->frequency == 0){
					$yearArr += array($j++ => array('year'=>$key, 'month'=>$v));
				}
			}
		}
		return $yearArr ;
	}

	private function setEndDate()
	{
		return ($this->calendar->endDate != '0000-00-00' && strtotime($this->calendar->endDate)<$this->end ) ? strtotime($this->calendar->endDate) : $this->end;
	}

	private function getColor($endTime)
	{
		return ($endTime > date('Y-m-d H:i:s')) ? '#3366cc' : '#B6C8EC' ;
	}
}