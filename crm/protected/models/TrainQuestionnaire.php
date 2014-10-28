<?php
class TrainQuestionnaire extends CActiveRecord 
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'in_tra_questionnaire';
    }
    
    public function saveQuestionnaireInfo($info)
    {
        $this->question = $info['question'];
        $this->answer = $info['answer'];
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
        $defaultArray['id'] = '问题序号';
        return $defaultArray;
    }
}