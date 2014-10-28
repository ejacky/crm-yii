<?php
class AdminModel extends CActiveRecord
{
    public function isNew()
    {
        return $_POST['isNew'];
    }
}
