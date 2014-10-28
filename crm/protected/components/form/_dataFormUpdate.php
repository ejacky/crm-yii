<div id="tabs">
	<ul><li><a href="#setForm">新建字段</a></li></ul><br/>
<?php echo formTemplate::$allTemplate ; ?>
                
<div id="createForm">
<?php
$form=$this->beginWidget('CActiveForm',array(
	'id' => 'form',
	'htmlOptions' => array(
		'class' => 'form',
	),
));

	if (isset($formName))
	{
		$formFields = PaForm::model()->findByAttributes(array('name' => $formName))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => $formName))->fields ;
	}

    $formFields = ArraySort($formFields,'orderId','desc','num'); //sort 

    function ArraySort($List, $by, $order='', $type='') {
            
        if (empty($List))
            return $List;
        foreach ($List as $key => $row) {                      
            foreach ($row as $subKey => $subRow) {  
                    if ($subKey == 'field_id_cover') {  
                    $jValue = json_decode($subRow);
                    if (isset($jValue->$by))
                    {
                            $sortby[$jValue->name] = $jValue->$by;
                    }
                    else
                    {
                            $sortby[$jValue->name] = '';
                    }
                    }   
            }                                   
        }

        if ($order == "DESC") {
            if ($type == "num") {
                array_multisort($sortby, SORT_DESC, SORT_NUMERIC, $List);
            } else {
                array_multisort($sortby, SORT_DESC, SORT_STRING, $List);
            }
        } else {
            if ($type == "num") {
                array_multisort($sortby, SORT_ASC, SORT_NUMERIC, $List);
            } else {
                array_multisort($sortby, SORT_ASC, SORT_STRING, $List);
            }
        }
        return $List;
    }

echo '<table>';
foreach ($formFields as $subFormField)
{
        $formView = new NewInputUpdate($subFormField, $model);  
        $type = $formView->getCoverage('type');
        
        if ($formView->getCoverage('name')) //need to refactory
        {
                echo '<tr id="' . $formView->getCoverage('name') . '">';
                echo '<td width="20%">';
                echo '<label id="field_label_' . $formView->getCoverage('name') . '">' . $formView->getCoverage('label') . '</label>';
                echo '<span style="color:red" class="span2-' . $formView->getCoverage('name') . '"></span>';
                echo '</td>';
                echo '<td id="field_content_' . $formView->getCoverage('name') . '" >' . $formView->$type() . '</td>';
                echo '<td><span class="span-' . $formView->getCoverage('name') . '"></span></td>';
                echo '<td width="20%">' . $formView->getCoverage('explain') . '</td>';
                echo '</tr>';
        } 
}
echo '</table>';

?>
<input type="hidden" name="isNew" value="<?php echo @$model->isNewRecord; ?>"/>
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm" class="saveForm"></td></tr></table>
<?php  $this->endWidget(); ?>	 
</div>
</div>
