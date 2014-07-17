<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'emailer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'from',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'to',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'subject',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textAreaRow($model,'message',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'sent',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sent_timestamp',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'queued_timestamp',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
