<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workflow-change-notice-form',
	'enableAjaxValidation'=>false,
)); ?>                               

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'initiated_by',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'notice_type',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'processing_group',array('class'=>'span5','maxlength'=>7)); ?>

	<?php echo $form->textFieldRow($model,'processing_user',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'profile_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'personal_profile_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'employment_profile_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'payroll_profile_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'bom_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fac_adm_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'mnl_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'corp_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'timestamp_bom_signed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'timestamp_fac_adm_signed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'timestamp_mnl_signed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'timestamp_corp_signed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'decision_bom',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'decision_fac_adm',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'decision_mnl',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'decision_corp',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'comment_bom',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'comment_fac_adm',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'comment_mnl',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'comment_corp',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'attachment_bom',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'attachment_fac_adm',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'attachment_mnl',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'attachment_corp',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'timestamp',array('class'=>'span5')); ?>

  <div class="form-actions">
    <?php echo $form->errorSummary(array($model,$model_personal,$model_employment,$model_payroll));?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Override','size'=>'large')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
  </div>


<?php $this->endWidget(); ?>
