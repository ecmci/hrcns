<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tar-user-form',
	'enableAjaxValidation'=>true,
  //'enableClientValidation'=>true,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo BHtml::dropDownList($model,'id',User::getList(),array('class'=>'span5','empty'=>''),$form); ?>

	<?php echo BHtml::dropDownList($model,'group_id',TarGroup::getList(),array('class'=>'span5'),$form); ?>
  
  <?php echo BHtml::dropDownList($model,'facilities_handled',Facility::getList(),array('class'=>'span5','multiple'=>true,'style'=>'min-height:200px;'),$form); ?>
  
  <?php echo BHtml::checkBox($model,'is_active',array('class'=>''),$form); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
