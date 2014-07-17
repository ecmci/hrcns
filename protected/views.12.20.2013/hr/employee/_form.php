<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'employee-form',
	'type'=>'horizontal',
  'enableClientValidation'=>true,
  'enableAjaxValidation'=>true,
  'focus'=>array($model,'last_name'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
  'htmlOptions'=>array(
    'enctype'=>'multipart/form-data',
  ),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'middle_name',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->fileFieldRow($model,'photo',array('class'=>'span5','maxlength'=>128)); ?>
  
  <?php echo $form->textAreaRow($model,'update_reason',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Create' : 'Update',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
