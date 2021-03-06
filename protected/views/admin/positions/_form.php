<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'position-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropdownListRow($model,'dept_code',Department::getList(),array('empty'=>'', 'class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'job_code',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'job_description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
