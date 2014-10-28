<?php
class MiniWebUser extends CWebUser
{
    public function getOrgId()
	{
		//$key=$this->getStateKeyPrefix().$key;
		return $this->getState('__orgId');
	}
	
	public function setOrgId($value)
	{		
		$this->setState('__orgId',$value);
	}
} 