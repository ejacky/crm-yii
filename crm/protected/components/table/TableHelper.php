<?php
class TableHelper
{
	public static function connect()
	{
		mysql_connect('localhost:3306', 'root', '') or die("Could not connect: " . mysql_error());
		mysql_query("SET NAMES 'utf8'");
		mysql_select_db("crm");
	}
	
	public static function executeSql($sql)
	{
		self::connect();
		return mysql_query($sql);
	}
	
	public static function getFieldArray($sql)
	{
		self::connect();
		$result = mysql_query($sql);
		$i = 0;
		while ($i < mysql_num_fields($result))
		{
			$field = mysql_fetch_field($result, $i);
			$fieldArray[] = $field->name;
			$i++;
		}
		
		return $fieldArray;
	}
	
	public static function getResultArray($sql)
	{
		self::connect();
		$resourse = mysql_query($sql);
		$result = array();
		while ($row = mysql_fetch_assoc($resourse))
		{
			$result[]= $row;
        }
		return $result;
	}
}
