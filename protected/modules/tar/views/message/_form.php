<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tar-messaging-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'from_user_id',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'to_user_id',User::getList(),array('class'=>'span5','empty'=>'')); ?>

	<?php echo $form->textAreaRow($model,'message',array('class'=>'span5','style'=>'height:200px;')); ?>

	<?php //echo $form->textFieldRow($model,'is_seen',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'seen_datetime',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'timestamp',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'htmlOptions'=>array(
        'class'=>'btn btn-primary btn-large'
      ),
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
