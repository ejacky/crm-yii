<?php
class LoginController extends CController
{
	public $layout = '//layouts/columnlogin';

	public function actionDefault()
	{
		$this->render('index');
	}

	public function actionIndex()
	{
		if(!(Yii::app()->user->isGuest))
		{
			$this->redirect(array('assist/index'));
		}
		$model=new LoginForm;
		if(isset($_POST['loginForm']))
		{
                        
			$model->attributes=$_POST['loginForm'];
                        
			if($model->validate() && $model->login())
			{
				$this->redirect("/index.php",array('isGuest'=>true));
			}
		}
		$this->render('index',array('model'=>$model));
	}

	public function actionRegister()
	{
		$model = new RegisterForm('register');
		$adduser = new User;
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes=$_POST['RegisterForm'];
			if($model->validate())
			{
				$adduser->username = $model->username;
				$adduser->password = md5($model->password);
				if($adduser->save())
				{
					$this->redirect(array('account/index'));
				}
			}
		}
		$this->render('register',array('model'=>$model));
	}

	public function actionLogOut()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeurl);
	}

}