<div class="form wide">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'requisition-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'FACILITY_idFACILITY'); ?>
		<?php echo $form->dropDownList($model, 'FACILITY_idFACILITY', GxHtml::listDataEx(Facility::model()->findAllAttributes(null, true)),array('empty'=>'-')); ?>
		<?php echo $form->error($model,'FACILITY_idFACILITY'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PRIORITY_idPRIORITY'); ?>
		<?php echo $form->dropDownList($model, 'PRIORITY_idPRIORITY', GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true)),array('empty'=>'-')); ?>
		<?php echo $form->error($model,'PRIORITY_idPRIORITY'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'priority_reason'); ?>
		<?php echo $form->textField($model, 'priority_reason', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'priority_reason'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'preferred_vendor'); ?>
		<?php echo $form->textField($model, 'preferred_vendor', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'preferred_vendor'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'project_name'); ?>
		<?php echo $form->textField($model, 'project_name', array('maxlength' => 250)); ?>
		<?php echo $form->error($model,'project_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'service_description'); ?>
		<?php echo $form->textArea($model, 'service_description'); ?>
		<?php echo $form->error($model,'service_description'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'),array('class'=>'button'));
$this->endWidget();
?>
</div><!-- form -->