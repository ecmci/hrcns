<?php
 Yii::app()->clientScript->registerScript('check-reset-pw',"
 $('#".CHtml::activeId($model,'reset_password')."').click(function(){
  $('#".CHtml::activeId($model,'password')."').val('');
 });
 ");
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>100)); ?>

  <?php echo $form->checkBoxRow($model,'reset_password'); ?>

	<?php echo $form->textFieldRow($model,'f_name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'l_name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'m_name',array('class'=>'span5','maxlength'=>45)); ?>

  <?php echo $form->dropDownListRow($model,'role',ZHtml::enumItem($model,'role'),array('class'=>'span5')); ?>



	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
