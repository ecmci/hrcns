<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'hr-documents-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

  <p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->dropDownListRow($model,'notice_type',ZHtml::enumItem(new WorkflowChangeNotice,'notice_type'),array('empty'=>'', 'class'=>'span5','maxlength'=>128)); ?>

  	<?php echo $form->dropDownListRow($model,'notice_sub_type',ZHtml::enumItem(new WorkflowChangeNotice,'notice_sub_type'),array('empty'=>'', 'class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'document',array('class'=>'span5','maxlength'=>256)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
