<?php
/**
 * Description of CoBase
 *
 * @author Marvin
 */
class CoBase {
	protected function error($errorNumber, $info = array())
	{
		return array('error' => $errorNumber, 'message' => $this->errors[$errorNumber]) + $info;
	}
	
	protected function success($message, $info = array())
	{
		return array('error' => 0, 'message' => $message) + $info;
	}
}

?>
