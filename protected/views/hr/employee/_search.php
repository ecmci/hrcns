<?php 
Yii::app()->clientScript->registerScript('print-preview-employee-report',"
$('#btn-print-preview').click(function(){
  var params = $('#employee-search-form').serialize();
  window.open('".Yii::app()->createAbsoluteUrl('hr/employee/printreport')."?' + params);
  return false;
});
");
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
  'id'=>'employee-search-form',
)); ?>
  <div class="row-fluid">
  
	<div class="span4"><?php echo $form->textFieldRow($model,'last_name',array('class'=>'span12')); ?></div>
  
  <div class="span4"><?php echo $form->textFieldRow($model,'first_name',array('class'=>'span12')); ?></div>
  
  <div class="span4"><?php echo $form->textFieldRow($model,'emp_id',array('class'=>'span12')); ?></div>

  
  </div>
  
  <div class="row-fluid">

  <div class="span4"><?php echo $form->dropDownListRow($model,'status',ZHtml::enumItem(new EmployeeEmployment,'status'),array('empty'=>'ALL','class'=>'span12')); ?></div>
  
  <div class="span4"><?php echo $form->dropDownListRow($model,'position_code',Position::getList(),array('empty'=>'ALL','class'=>'span12')); ?></div>
  
  <div class="span4"><?php echo $form->dropDownListRow($model,'facility_id',Facility::getList(),array('empty'=>'ALL','class'=>'span12')); ?></div>
  
  </div>
  
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
      'icon'=>'icon-white icon-search',
			'label'=>'Search',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'',
      'size'=>'medium',
			'label'=>'Print Preview',
      'htmlOptions'=>array('id'=>'btn-print-preview'),
      'url'=>'#',
      'icon'=>'icon-print',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
