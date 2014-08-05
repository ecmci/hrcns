	<?php echo $form->dropDownListRow($model,'facility_id',Facility::getList(),array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'status',ZHtml::enumItem($model,'status'),array('empty'=>'-select-', 'class'=>'span5','maxlength'=>29)); ?>

	<div id="doh"><?php echo $form->textFieldRow($model,'date_of_hire',array('class'=>'span5 datepicker')); ?></div>

	<div id="dot"><?php echo $form->textFieldRow($model,'date_of_termination',array('class'=>'span5 datepicker')); ?></div>

	<?php echo $form->hiddenField($model,'department_code',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'position_code',Position::getList(),array('empty'=>'-select-', 'class'=>'span5')); ?>

	<?php echo $form->hiddenField($model,'start_date',array('class'=>'span5')); ?>

	<?php echo $form->hiddenField($model,'end_date',array('class'=>'span5')); ?>

	<?php echo $form->hiddenField($model,'contract_file',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->checkBoxRow($model,'has_union',array('hint'=>'Check if this employee is a union member.')); ?>
	
	<div id="unionSubForm">
		<?php echo $form->textFieldRow($model,'years_in_union',array('append'=>'Years', 'class'=>'span5')); ?>
	</div>
	
<?php
Yii::app()->clientScript->registerScript('',"
function toggleYearsInUnion(){
	var has_union = $('#".CHtml::activeId($model,'has_union')."');
	var years_in_union = $('#".CHtml::activeId($model,'years_in_union')."');
	if(has_union.is(':checked')){
		$('#unionSubForm').show();
	}else{
		$('#unionSubForm').hide();
	}
}
",CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScript('',"
toggleYearsInUnion();
$('#".CHtml::activeId($model,'has_union')."').on('change',toggleYearsInUnion);
",CClientScript::POS_READY);
?>
