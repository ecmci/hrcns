<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'from_user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'to_user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'message',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'is_seen',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'seen_datetime',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'timestamp',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
