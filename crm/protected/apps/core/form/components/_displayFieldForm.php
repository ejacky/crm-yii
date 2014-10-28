<?php echo formTemplate::$allTemplate ; ?>
<?php
 /*
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

/*
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
                foreach ($fieldNameCoverJsonValue as $sub => $value)
                {
                        if (isset($fieldNameCoverJsonValue->orderId))
                        {
                                $sortArray[$fieldNameCoverJsonValue->name] = $fieldNameCoverJsonValue->orderId;
                        }
                        else
                        {
                                $sortArray[$fieldNameCoverJsonValue->name] = '';
                        }
                }
        }
                
        return $sortArray;
}
?>

<div id="tabs">
<ul>
<?php $groupList = array(0=>'默认',1=>'情况一',2=>'情况二',3=>'情况三')?>
<?php foreach ($groupList as $key=>$val) : ?>
<li><a href="#<?php echo $val;?>"><?php echo $val;?></a></li>
<?php endforeach; ?>
</ul>
<?php foreach ($groupList as $key=>$val) : ?>
<div id="<?php echo $val;?>" class="<?php echo 'condition'.$key;?>">
<?php
$form=$this->beginWidget('CActiveForm',array(
	'id' => 'customform',
	'htmlOptions' => array(
		'class' => 'form',
	),
));

$formFields = getArraySortBySortedArray(getArrayByOrderId($formFields),'ASC','num', $formFields);


//need to refactory

if ($key==1 || $key==2 || $key==3){
	echo '<input type="hidden" name="condition[index]" value="'.($key-1).'">';
	echo "<div class='parameter'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>模块</label></td><td>
			<select name="condition[module]">
			<option value="/index.php">前台</option>
			<option value="/admin.php">后台</option>
			<option value="null">不使用</option>
			</select></td></tr></tbody>';
	echo "</table>","</div>";
	
	echo "<div class='parameter'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>条件controller</label></td><td><input value="'.$formView->getCondition($model, 'controller', $key-1).'" type="text" name="condition[controller]"></td></tr></tbody>';
	echo "</table>","</div>";
	
	echo "<div class='parameter'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>条件action</label></td><td><input value="'.$formView->getCondition($model, 'action', $key-1).'" type="text" name="condition[action]"></td></tr></tbody>';
	echo "</table>","</div>";
	
	echo "<div class='parameter' style='border-bottom: 1px solid #C9E0ED;'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>条件parameter</label></td><td><input value="'.$formView->getCondition($model, 'parameter', $key-1).'" type="text" name="condition[parameter]"></td></tr></tbody>';
	echo "</table>","</div><br/>";
	
}

echo '<table>';
foreach ($formFields as $subFormField)
{
        $formView = new FetchInputHtml($subFormField);  
        $name = $formView->getCoverage('name');
        $type = $formView->getCoverage('type');
        $fillValue = $formView->getFillValue($name, $model);
        $label = $formView->getCoverage('label');
        $isMust = $formView->getCoverage('isMust');
        $attr = $formView->getCoverage('attr');
        $tableModelName = $formView->getCoverage('tableModelName');
        $key = $formView->getCoverage('key');
        $condition = $formView->getCoverage('condition');
        $rules = $formView->getCoverage('rules');
        $category = $formView->getCoverage('category');
        $formName = $formView->isUDF($name, $category);
        
        $checkMust = $formView->checkMust($isMust,$name, $label);
        $checkRules = $formView->addRules($rules,$formName);
       // var_dump($checkRules);
        $checkAttr = $checkMust . $checkRules; 
        
        $extraAttr = array(
            'attr' => $attr,
            'tableModelName' => $tableModelName,
            'condition' => $condition,
            'key' => $key,
            'checkAttr' => $checkAttr
        );
        $htmlOptions = array(
            'id' => 'field_item_' . $name,
            'class' => $name,
            'label' => $type,
        );
        
        if ($formView->getCoverage('name')) //need to refactory
        {
                echo '<tr id="' . $formView->getCoverage('name') . '" class="' . $formView->getCoverage('name') . '">';
                echo '<td width="20%">';
                echo '<label id="field_label_' . $formView->getCoverage('name') . '">' . $formView->getCoverage('label') . '</label>';
                echo '<span style="color:red" class="span2-' . $formView->getCoverage('name') . '"></span>';
                echo '</td>';
                echo '<td id="field_content_' . $formView->getCoverage('name') . '" >' . $formView->$type($formName, $fillValue, $htmlOptions, $extraAttr) .'</td>';
                echo '<td><span class="span-' . $formView->getCoverage('name') . '"></span></td>';
                echo '<td width="20%">' . $formView->getCoverage('explain') . '</td>';
                echo '</tr>';
        } 
}
echo '</table>';
?>
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm" class="saveForm"></td></tr></table>
<?php  $this->endWidget(); ?>	 
</div>
<?php endforeach; ?>
</div>
