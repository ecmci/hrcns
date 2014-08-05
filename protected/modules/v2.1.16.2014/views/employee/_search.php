<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'emp_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'middle_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->dropDownListRow($model,'facility_id',Facility::getList(),array('multiple'=>true,  'class'=>'span5')); ?>
	<p class="label label-info">Tip: To facilitate your search, type the first letter of the last name.</p>
	
	<?php echo $form->dropDownListRow($model,'position_code',Position::getList(),array('empty'=>'','class'=>'span5')); ?>
	
	<?php echo $form->dropDownListRow($model,'department_code',Department::getList(),array('multiple'=>true,'class'=>'span5','maxlength'=>128)); ?>
	<p class="label label-info">Tip: To facilitate your search, type the first letter of the last name.</p>
	
	<?php echo $form->dropDownListRow($model,'status',App::enumItem(new Employment,'status'),array('multiple'=>true,'class'=>'span5','maxlength'=>128)); ?>
	<p class="label label-info">Tip: To facilitate your search, type the first letter of the last name.</p>

	<?php echo $form->checkBoxRow($model,'include_terminated_employees',App::enumItem(new Employment,'status'),array('multiple'=>true,'class'=>'span5','maxlength'=>128)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
			'size'=>'large',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>'Print Preview',
			'htmlOptions'=>array('id'=>'print-notices'),
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
			'label'=>'Reset',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
App::renderDatePickers();
Yii::app()->clientScript->registerScript('search-employee-js',"
$('#print-notices').on('click',function(){
	var url = '".Yii::app()->createUrl('/v2/employee/printreport')."';
	var params = $('.search-form form').serialize();
	var title = prompt('Title of this report?');
	window.open(url + '?' + params + '&t=' + title);
	$.preventDefault();
});
",CClientScript::POS_READY);
?>
