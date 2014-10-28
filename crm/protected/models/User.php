<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class User extends CActiveRecord
{
	public $role_display_name;
	public $task_display_name;
	public $department_full_name;
	public $position;
	public $projectName;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		$model = parent::model($className);
		//$model->setTableAlias('user');
		return $model;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		
		return 'co_staff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
	
			array('username, password', 'safe', 'on'=>'search'),
			array('email','email'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'role' => array(self::MANY_MANY, 'Role', 'co_user_role(user_id, role_id)'),
			'task' => array(self::MANY_MANY, 'Task', 'co_user_task(user_id, task_id)'),
			'department' => array(self::MANY_MANY, 'Category', 'co_user_department_position(user_id, department_id)'),
			'position' => array(self::HAS_MANY, 'UserDepartmentPosition', 'user_id'),
			'project' => array(self::MANY_MANY, 'Category', '2014_user_project(user_id, project_id)'),
		    'recruit' => array(self::MANY_MANY,'Recruit','user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$defaultArray = Tools::getTableTitles();
		$defaultArray['id'] = 'ID号';
		$defaultArray['email'] = '邮箱';
		return $defaultArray;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}
	
	public function generateSalt()
	{
		return uniqid('',true);
	}
	
	
}
