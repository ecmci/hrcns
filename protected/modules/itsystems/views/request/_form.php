<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'request-form',
  'type'=>'horizontal',
	'enableAjaxValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>



	<?php echo $form->dropDownListRow($model,'employee_id',Employee::getList(),array('empty'=>'', 'class'=>'span5')); ?>

  <?php echo $form->dropDownListRow($model,'type',ZHtml::enumItem($model,'type'),array('empty'=>'', 'class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'system_id',System::getList(),array('hint'=>'<strong>Tip:</strong> To multi-select items, hold down the CTRL key while clicking on each item or click one item and drag.', 'style'=>'height:150px;', 'multiple'=>true, 'class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>25, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php echo $form->errorSummary($model); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Submit' : 'Save',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
      'url'=>array('admin'),
			'label'=>'Cancel',
		)); ?>
	</div>

<?php $this->endWidget(); ?>    
