<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'system-position-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



	<?php echo $form->dropDownListRow($model,'position_id',Position::getList(),array('empty'=>'-',  'class'=>'span5')); ?>

  <?php echo $form->dropDownListRow($model,'system_id',System::getList(),array('multiple'=>true, 'class'=>'span5', 'style'=>'height:150px;' )); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Map' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
