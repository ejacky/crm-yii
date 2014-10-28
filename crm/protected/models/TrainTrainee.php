<?php
class TrainTrainee extends CActiveRecord 
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'in_tra_trainee';
    }
    
    public function relations()
    {
        return array(
            'questionnaire' => array(self::BELONGS_TO, 'TrainQuestionnaire', 'questionnaire_id'),
        );
    }
    
    public function saveTraineeInfo($info)
    {
        $this->traineeName = $info['traineeName'];
//        $this->questionnaire_id = $info['questionnaire_id'];
        $this->client_id = $info['client_id'];
        $this->department = $info['department'];
        $this->position = $info['position'];
        $this->workingYears = $info['workingYears'];
        $this->serviceYears = $info['serviceYears'];
        $this->remark = $info['remark'];
        return $this->save();
    }
    
    public function search()
    {
        $criteria=new CDbCriteria;
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
        $defaultArray['id'] = '学员编号';
        return $defaultArray;
    }
}