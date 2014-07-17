<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'carbon-copy-form',
  'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'workflow_notice_status',ZHtml::enumItem(new WorkflowChangeNotice,'status'),array('class'=>'span5','empty'=>'')); ?>

	<?php echo $form->textFieldRow($model,'recipient_email',array('class'=>'span5','maxlength'=>128)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
			'label'=>'Reset',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
