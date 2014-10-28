<?php echo formTemplate::$allTemplate ; ?>
<?php 
 /**
  * @needSortedArray Must
  * 获取以orderId升序排列的fieldForms
  */
function getArraySortBySortedArray($hasSortedArray, $sortOrder, $sortType, $needSortedArray)
{
        if (empty($hasSortedArray))
                return;
        if ($sortType == 'DESC')
        {
                if ($sortType == 'num')
                {
                        array_multisort($hasSortedArray, SORT_DESC, SORT_NUMERIC, $needSortedArray);
                }
                else
                {
                        array_multisort($hasSortedArray, SORT_DESC, SORT_STRING, $needSortedArray);
                }
        }
        else
        {
                if ($sortType == 'num')
                {
                        array_multisort($hasSortedArray, SORT_ASC, SORT_NUMERIC, $needSortedArray);
                }
                else
                {
                        array_multisort($hasSortedArray, SORT_ASC, SORT_STRING, $needSortedArray);
                }
        }
        $sortedArray = $needSortedArray;
        return $sortedArray;
}

/**
 * 获取以orderId 排序的数组 sortArray
 */
function getArrayByOrderId($fieldForm)
{
        if (empty($fieldForm))
        {
                return;
        }
        
        foreach ($fieldForm as $subFieldForm)
        {
                $getInstance = new FetchInputHtml($subFieldForm);
                $conditionId = $getInstance->setEnv($subFieldForm);
                $conditionField = 'fieldNameCover' . $conditionId;
                $fieldNameCoverJsonValue = json_decode($subFieldForm->$conditionField); 
               // var_dump($fieldNameCoverJsonValue);exit;
                if (!isset($fieldNameCoverJsonValue->name))
                {
                        var_dump('name doesnt exist');exit;
                }
                if (isset($fieldNameCoverJsonValue->orderId))
                {
                        $sortArray[$fieldNameCoverJsonValue->name] = $fieldNameCoverJsonValue->orderId;
                }
                else
                {
                        $sortArray[$fieldNameCoverJsonValue->name] = '';
                }
        }
              
        return $sortArray;
}

function printHtml($name, $label, $explain, $fieldContent)
{
        if ($name) //need to refactory
        {
                echo '<tr id="' . $name . '">';
                echo '<td width="20%">';
                echo '<label id="field_label_' . $name . '">' . $label . '</label>';
                echo '<span style="color:red" class="span2-' . $name . '"></span>';
                echo '</td>';
                echo '<td id="field_content_' . $name . '" >' . $fieldContent .'</td>';
                echo '<td><span class="span-' . $name . '"></span></td>';
                echo '<td width="20%">' . $explain . '</td>';
                echo '</tr>';
        }
}

// 将数组$formFields按照$groupName分组
// 现在未被使用
function getGroup($formFields, $groupName) {
        $groupArray = array();
        foreach ($formFields as $subFormField) {
                $getInstance = new FetchInputHtml($subFormField);
                $conditionId = $getInstance->setEnv($subFormField);
                $conditionField = 'fieldNameCover' . $conditionId;
                $fieldNameCoverJsonValue = json_decode($subFormField->$conditionField);
                if ($fieldNameCoverJsonValue->groupName == $groupName) {
                        $groupArray[] = $subFormField;
                }
        }
        return $groupArray;
}
?>

<?php 
/**
 * 
 */
$groupNamesArray = array();
if (get_class($model) != 'stdClass') {
        $formName = Tools::getModel2FormName(get_class($model)); 
        $formModel = PaForm::model()->findByAttributes(array('name' => $formName));

        if (isset($formModel)) {
                $groupNames = $formModel->groupName;
                $defaultGroupName = array('default'); //增加默认为空；
                $groupNamesArray = explode(',', $groupNames);
                $groupNamesArray = array_merge($defaultGroupName, $groupNamesArray);        
} 
} else {
        $groupNamesArray = array('default');
}
?>

<div id="tabs">
	<ul>
                <?php foreach ($groupNamesArray as $subGroupName => $subGroupValue) :?>
                <li><a href="#<?php echo $subGroupValue; ?>"><?php echo $subGroupValue; ?></a></li>
                <?php endforeach; ?>
        </ul>
        

<?php
$formFields = getArraySortBySortedArray(getArrayByOrderId($formFields),'ASC','num', $formFields); //sort 
$form = $this->beginWidget('CActiveForm',array(
	'id' => 'form',
	'htmlOptions' => array(
		'class' => 'form',
	),
));
?>

<?php foreach ($groupNamesArray as $subGroupName => $subGroupValue) :?>

<div id="<?php echo $subGroupValue; ?>">
<?php echo '<table>';?>       
<?php        
foreach ($formFields as $subFormField)
{
        $formView = new FetchInputHtml($subFormField);  
        $name = $formView->getCoverage('name');
        $type = $formView->getCoverage('type');
        if ($type == 'uploadPic')
        {
                $fillValue = $formView->getFillValue('avatar', $model);
        }
        else
        {
                $fillValue = $formView->getFillValue($name, $model);
        }
        
        $label = $formView->getCoverage('label');
        $isMust = $formView->getCoverage('isMust');
        $attr = $formView->getCoverage('attr');
        $explain = $formView->getCoverage('explain');
        $groupName = $formView->getCoverage('groupName');
        $tableModelName = $formView->getCoverage('tableModelName');
        $key = $formView->getCoverage('key');
        $condition = $formView->getCoverage('condition');
        $rules = $formView->getCoverage('rules');
        $category = $formView->getCoverage('category');
        $customValidator = $formView->getCoverage('customCheck');
        $formName = $formView->isUDF($name, $category);
        
        $checkMust = $formView->checkMust($isMust,$name, $label);
        $checkRules = $formView->addRules($rules,$formName);
        $checkAttr = $checkMust . $checkRules;
        
        
        $extraAttr = array(
            'attr' => $attr,
            'tableModelName' => $tableModelName,
            'condition' => $condition,
            'key' => $key,
            'checkAttr' => $checkAttr,
            'customValidator' => $customValidator,
        );
        $htmlOptions = array(
            'id' => 'field_item_' . $name,
            'class' => $name,
            'label' => $type,
        );
        $fieldContent = $formView->$type($formName, $fillValue, $htmlOptions, $extraAttr);
        
       if ($groupName == $subGroupValue || $subGroupName == 'default')
        {
                printHtml($name, $label, $explain, $fieldContent);    
        }
            
}
?>

<!--  判断是编辑状态或是创建 -->
<!--<input type="hidden" name="form[isNew]" value="<?php echo @$model->isNewRecord; ?>"/>-->
<?php echo '</table>'; ?>
</div> <!-- <?php echo $subGroupValue; ?>-->
<?php endforeach; ?>
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm" class="saveForm"></td></tr></table>
<?php  $this->endWidget(); ?>
</div>  <!-- tabs -->

