<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->dropDownListRow($model,'notice_type',ZHtml::enumItem(new WorkflowChangeNotice,'notice_type'),array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'document',array('class'=>'span5','maxlength'=>256)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
