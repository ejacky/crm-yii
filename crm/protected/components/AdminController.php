<?php

class AdminController extends Controller
{
	public $layout='//layouts/column2';
	
	protected function isPost()
	{
		return isset($_POST['form']);
	}
}
