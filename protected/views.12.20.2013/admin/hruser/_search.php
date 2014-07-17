<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->dropDownListRow($model,'user_id',User::getList(),array('empty'=>'-ALL-','class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'group',ZHtml::enumItem($model,'group'),array('empty'=>'-ALL-','class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'facility_handled_ids',Facility::getFullList(),array('empty'=>'-ALL-','class'=>'span5')); ?>

  <?php echo $form->checkBoxRow($model,'can_override_routing'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
