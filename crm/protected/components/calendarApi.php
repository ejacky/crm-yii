<?php
class calendarApi
{    
         public function saveBirthdayInCalendar($name, $birthday, $user_id)
         {
                $cal = new Calendar();
		$cal->user_id = $user_id;
		$cal->title = $name . '\' birsthday';
		$cal->allday = 1;
		$cal->startTime = $birthday;
		$cal->startDate = $birthday;
		$cal->dataType = 'inbox';
		$cal->frequency = 1;
		$cal->repeatType = 'year';
		$cal->save();
	}
	
	public function saveCreateInfoInCalendar($name, $user_id, $modelType)
	{
	        $cal = new Calendar();
		$cal->user_id = $user_id;
		$cal->title = $modelType . ': '. $name;
		$cal->startTime = date('y-m-d H:i:s');
		$cal->dataType = 'sys';
		$cal->repeatType = 'null';
		 return $cal->save();
	}
	
}


