<?php
class CompanyForm extends CFormModel
{
    public $staff_id;
    public $name;
    public $trade;
    public $address;
    public $phone;
    public $email;
    public $incomePerYear;
    public $peopleNumber;
    public $date;

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name','checkName','on' => 'add','message' => '该公司名已经存在'),
            array('phone', 'length', 'min' => 6,'max' => 11 ),
            array('phone', 'checkPhone', 'on' => 'add','message' => '该电话号已经存在'),
            array('incomePerYear,peopleNumber', 'numerical'),
            array('email', 'email'),
            array('email', 'checkEmail', 'on' => 'add','message' => '该邮箱已存在'),
        );
    }
    
        public function checkName($attribute,$params)
        {
        if ($this->findByAttributes(array('name' => $this->name)))
        {
            $this->addError($attribute, $params['message']); 
        }
    }
    
    public function checkEmail($attribute,$params)
    {
        if ($this->findByAttributes(array('email' => $this->email)))
        {
            $this->addError($attribute, $params['message']); 
        }
    }
    
    public function checkPhone($attribute,$params)
    {
        if ($this->findByAttributes(array('phone' => $this->phone)))
        {
            $this->addError($attribute, $params['message']);
        }
    }
    
}