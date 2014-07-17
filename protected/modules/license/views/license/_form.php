<?php
 Helper::uploadifyFileFields();
 Helper::includeJui();
 Helper::renderDatePickers();
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'license-form',
  'type'=>'horizontal',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'emp_id',Employee::getList(),array('empty'=>'', 'class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'serial_number',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'date_issued',array('class'=>'span5 datepicker')); ?>

	<?php echo $form->textFieldRow($model,'date_of_expiration',array('class'=>'span5 datepicker')); ?>

	<?php echo $form->fileFieldRow($model,'attachments',array( 'readonly'=>'readonly', 'class'=>'span5','maxlength'=>128)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Submit' : 'Save',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>'Cancel',
      'url'=>array('admin'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
