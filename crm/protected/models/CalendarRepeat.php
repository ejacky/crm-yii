<?php
class CalendarRepeat extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'no_calendar_repeat_change';
	}
}