<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'emp_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'is_pto_eligible',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pto_effective_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fed_expt',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'fed_add',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'state_expt',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'rate_type',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textFieldRow($model,'rate_proposed',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'rate_recommended',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'rate_approved',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'rate_effective_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'deduc_health_code',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'deduc_health_amt',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'deduc_dental_code',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'deduc_dental_amt',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'deduc_other_code',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'deduc_other_amt',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'is_approved',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'timestamp',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
