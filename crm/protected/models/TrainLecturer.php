<?php
class TrainLecturer extends CActiveRecord 
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'in_tra_lecturer';
    }
    
    public function saveLecturerInfo($info)
    {
        $this->lecturerName = $info['lecturerName'];
        if (isset($info['avatar']))
        {
            $this->avatar = $info['avatar'];
        }
        $this->introduction = $info['introduction'];
        $this->specialty = $info['specialty'];
        $this->email = $info['email'];
        $this->mobilePhone = $info['mobilePhone'];
        $this->qq = $info['qq'];
        $this->Msn = $info['msn'];
        return $this->save();
    }
    
    public function search()
    {
        $criteria = new CDbCriteria();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '20',
                ),
        ));
    }
    
    public function attributeLabels()
    {
        
        $defaultArray = Tools::getTableTitles();
        $defaultArray['id'] = '讲师序列号';
        $defaultArray['email'] = '邮箱';
        $defaultArray['introduction'] = '简介';
        return $defaultArray;
    }
}