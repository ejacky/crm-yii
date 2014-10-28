<?php
class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $re_password;
	public $email;
	
	public function rules()
	{
		return array(
		        array('username,password,re_password,email','required'),
                        array('password','compare','compareAttribute'=>'re_password'),
	//	  array('email','email '),
		  );
	}

	public function attributeLabels()
	{
	
		$defaultArray = Tools::getTableTitles();
		$defaultArray['email'] = '邮箱';
		return $defaultArray;
	}
	
	
	
}