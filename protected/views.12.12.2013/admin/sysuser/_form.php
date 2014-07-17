<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sys-user-form',
  'type'=>'horizontal',
	'enableAjaxValidation'=>false,
));

Yii::app()->clientScript->registerScript('user',"
if($('#SysUser_hr_access').is('checked')){
  $('#form-hr-user').show();  
}else{
  $('#form-hr-user').hide();  
}
$('#SysUser_hr_access').click(function () {
    $('#form-hr-user').slideToggle(this.checked);
});
$('#SysUser_req_access').click(function () {
    $('#form-req-user').slideToggle(this.checked);
});
",CClientScript::POS_READY);
?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'f_name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'l_name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'m_name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->checkBoxRow($model,'active',array('class'=>'')); ?>

  <?php echo $form->checkBoxRow($model,'hr_access',array('class'=>'')); ?>
  <div id="form-hr-user"><?php echo $this->renderPartial('_form_hr_user',array('form'=>$form,'model_hr'=>$model_hr)); ?></div> 
  
  <?php echo $form->checkBoxRow($model,'req_access',array('class'=>'')); ?>
  <div id="form-req-user"><?php $this->renderPartial('_form_req_user',array('form'=>$form,'model_req'=>$model_req)); ?></div>

	<div class="form-actions">
		<?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($model_hr); ?>
    <?php echo $form->errorSummary($model_req); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
