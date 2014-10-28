<?php
class JsonConvert{

	private static $instance;
	public static function getInstance($newInstance = false)
	{
		if($newInstance || self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function decode($json)
	{
		return json_decode($json);
	}

	public function encode($array)
	{
		return json_encode($array);
	}

	/**
	 *
	 * @param json $key
	 */
	public function getDataByKey($json, $key )
	{
		$obj = $this->decode($json);
		return isset($obj->$key) ? $obj->$key : null ;
	}
}