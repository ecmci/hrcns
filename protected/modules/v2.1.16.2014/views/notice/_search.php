<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>
	
	<?php echo $form->dropDownListRow($model,'employee',Employee::getList(),array('empty'=>'' , 'class'=>'span5','maxlength'=>10)); ?>
	<p class="label label-info">Tip: To facilitate your search, type the first letter of the last name.</p>

	<?php echo $form->dropDownListRow($model,'facility',Facility::getList(),array('multiple'=>true,  'class'=>'span5','maxlength'=>10)); ?>
	<p class="label label-info">Tip: Hold down the CTRL key to select multiple items.</p>

	<?php echo $form->dropDownListRow($model,'notice_type',App::enumItem($model,'notice_type'),array('multiple'=>true,  'class'=>'span5','maxlength'=>10)); ?>
	<p class="label label-info">Tip: Hold down the CTRL key to select multiple items.</p>
	
	<?php echo $form->dropDownListRow($model,'notice_sub_type',App::enumItem($model,'notice_sub_type'),array('multiple'=>true,'class'=>'span5','maxlength'=>20)); ?>
	<p class="label label-info">Tip: Hold down the CTRL key to select multiple items.</p>
	
	<?php echo $form->dropDownListRow($model,'status',App::enumItem($model,'status'),array('multiple'=>true,'class'=>'span5','maxlength'=>10)); ?>
	<p class="label label-info">Tip: Hold down the CTRL key to select multiple items.</p>
	
	<?php echo $form->dropDownListRow($model,'processing_group',App::enumItem($model,'processing_group'),array('multiple'=>true,'class'=>'span5','maxlength'=>7)); ?>
	<p class="label label-info">Tip: Hold down the CTRL key to select multiple items.</p>

	<?php echo $form->textFieldRow($model,'effective_from',array('class'=>'span5 datepicker')); ?>
	
	<?php echo $form->textFieldRow($model,'effective_to',array('class'=>'span5 datepicker')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
			'size'=>'large',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>'Print Preview',
			'htmlOptions'=>array('id'=>'print-notices'),
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
			'label'=>'Reset',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
App::renderDatePickers();
Yii::app()->clientScript->registerScript('search-notices-js',"
$('#print-notices').on('click',function(){
	var url = '".Yii::app()->createUrl('/v2/notice/printreport')."';
	var params = $('.search-form form').serialize();
	var title = prompt('Title of this report?');
	window.open(url + '?' + params + '&t=' + title);
	$.preventDefault();
});
",CClientScript::POS_READY);
?>
