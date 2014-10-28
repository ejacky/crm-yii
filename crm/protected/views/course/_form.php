<div id="tabs">
<ul>                          
<li><a href="#addCourse">创建表单</a></li>
</ul> 
    
 
<div id="createForm">
<?php $form=$this->beginWidget('CActiveForm',array(
    'id' => 'company-form',
)); ?>
  
    
 <?php 
foreach ($model as $sub)
{
    $isMust = $sub->isMust;
    echo "<table>";
    echo FormView::getInstance()->showForm($sub->type, $sub->label, $sub->name, $sub->category, $sub->attr, $sub->isMust);
    echo "</table>";
}
?>   
<input type="submit" value="提交"/>
<?php  $this->endWidget(); ?> 
        
</div>
               
</div>





        