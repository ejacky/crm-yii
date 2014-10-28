<?php
class CoRoleTaskModel extends AdminModel
{
	/**
	 *
	 * @return CoRoleTaskModel
	 */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'co_role_task';
    }
}
