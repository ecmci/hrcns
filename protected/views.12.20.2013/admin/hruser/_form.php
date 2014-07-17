<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'hr-user-form',
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

  <?php
    $disabled = !$model->isNewRecord ? true : false;
  ?>
	
  <?php echo $form->dropDownListRow($model,'user_id',User::getList(),array('empty'=>'-select-','class'=>'span5','disabled'=>$disabled)); ?>

	<?php echo $form->dropDownListRow($model,'group',ZHtml::enumItem($model,'group'),array('class'=>'span5')); ?>

  <?php echo $form->dropDownListRow($model, 'facility_handled_ids', Facility::getFullList() , array('hint'=>'Tip: Hold CTRL and select multiple items. You can also click one and drag up/down.','multiple'=>true,'style'=>'height:200px;')); ?>

  <?php echo $form->checkBoxRow($model,'can_override_routing',array('hint'=>'(Check if this user can override the workflow routing or status.)')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
