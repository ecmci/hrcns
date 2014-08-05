<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'emp_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'birthdate',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'gender',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'marital_status',array('class'=>'span5','maxlength'=>16)); ?>

	<?php echo $form->textFieldRow($model,'SSN',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'number',array('class'=>'span5','maxlength'=>16)); ?>

	<?php echo $form->textFieldRow($model,'building',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'street',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'city',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'state',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'zip_code',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'telephone',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'cellphone',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>

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
