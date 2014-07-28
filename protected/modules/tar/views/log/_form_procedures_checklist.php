<?php
$procedures = empty($model->data_struct_checklists) ? CJSON::decode($model->procedures->data) : $model->data_struct_checklists;
?>

<div id="procedures-checklist">
  <?php foreach($procedures as $i=>$procedure): ?>
    <h5><?php echo $procedure['name']; ?></h5>
    <?php echo $form->hiddenField($model,"data_struct_checklists[$i][name]",array('value'=>$procedure['name'])); ?>
    <section>
      <p>
        <?php echo $procedure['instruction']; ?>
        <?php echo $form->hiddenField($model,"data_struct_checklists[$i][instruction]",array('value'=>$procedure['instruction'])); ?>            
      </p>
      <ul>
      <?php foreach($procedure['checklists'] as $j=>$checklist): ?>
          <li>
            <?php $op = $checklist['is_done'] == '1' ? array('checked'=>'checked') : array(); ?>
            <?php echo $form->checkBox($model,"data_struct_checklists[$i][checklists][$j][is_done]",$op).' '.$checklist['todo']; ?>                
            <?php echo $form->hiddenField($model,"data_struct_checklists[$i][checklists][$j][todo]",array('value'=>$checklist['todo'])); ?>
            <?php echo $form->hiddenField($model,"data_struct_checklists[$i][checklists][$j][date_done]",array('value'=>$checklist['date_done'])); ?>
          </li>
      <?php endforeach; ?>
      </ul>
    </section>
  <?php endforeach; ?> 
</div>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.steps.css');
Yii::app()->clientScript->registerCss('steps-css',"

");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.steps.min.js');
Yii::app()->clientScript->registerScript('steps-js',"
$('#procedures-checklist').steps({
    headerTag: 'h5',
    bodyTag: 'section',
    transitionEffect: 'slide'
});
",CClientScript::POS_READY);
?>