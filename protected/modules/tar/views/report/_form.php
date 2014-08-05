<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tar-log-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'control_num',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'resident',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'medical_num',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'dx_code',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'admit_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'type',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'requested_dos_date_from',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'requested_dos_date_thru',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'applied_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'denied_deferred_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'approved_modified_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'backbill_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'aging_amount',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'notes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'is_closed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'reason_for_closing',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'created_timestamp',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'approved_care_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'created_by_user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'facility_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'resident_status',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'condition',array('class'=>'span5','maxlength'=>100)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
