	<?php echo $form->hiddenField($model,'fed_expt',array('class'=>'span5','maxlength'=>3)); ?>

	<?php echo $form->hiddenField($model,'fed_add',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->hiddenField($model,'state_expt',array('class'=>'span5','maxlength'=>3)); ?>

	<?php echo $form->hiddenField($model,'state_add',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->dropDownListRow($model,'rate_type',array('Hourly'=>'Hourly','Salary'=>'Salary'),array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->dropDownListRow($model,'w4_status',ZHtml::enumItem($model,'w4_status'),array('class'=>'span5','maxlength'=>39)); ?>

	<?php echo $form->textFieldRow($model,'rate_proposed',array('prepend'=>'$', 'class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->hiddenField($model,'rate_recommended',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'rate_approved',array('prepend'=>'$', 'hint'=>'To be finalized by HR', 'class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->hiddenField($model,'rate_effective_date',array('class'=>'span5')); ?>

	<?php echo $form->hiddenField($model,'deduc_health_code',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->hiddenField($model,'deduc_health_amt',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->hiddenField($model,'deduc_dental_code',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->hiddenField($model,'deduc_dental_amt',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->hiddenField($model,'deduc_other_code',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->hiddenField($model,'deduc_other_amt',array('class'=>'span5','maxlength'=>10)); ?>
	
	<div id="ptoSubForm">
	<?php echo $form->checkBoxRow($model,'is_pto_eligible',array('hint'=>'Note: Only full time employees are eiligible for PTO.')); ?>
	
	<div id="ptoDate">
		<?php echo $form->textFieldRow($model,'pto_effective_date',array('class'=>'span5 datepicker')); ?>
	</div>
	</div>
	
<?php
Yii::app()->clientScript->registerScript('payroll-js-begin',"
",CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScript('payroll-js-ready',"
$('#".CHtml::activeId($model,'rate_proposed')."').on('keyup',function(){
	$('#".CHtml::activeId($model,'rate_approved')."').val($(this).val());
});
",CClientScript::POS_READY);
?>
