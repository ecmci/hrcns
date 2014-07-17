<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 
Helper::includeJui();
Helper::renderDatePickers();

Yii::app()->clientScript->registerScript('search-fxns',"
$('#btn-print-report').click(function(){
  var data = $('.search-form form').serialize();
  var url = '".Yii::app()->createUrl('/itsystems/request/report')."';
  window.open(url + '?' + data);
});
");
?>

  <div class="row-fluid">
   <div class="span6">
	 <?php echo $form->textFieldRow($model,'id',array('class'=>'span8')); ?>
   </div>
   <div class="span6">
	<?php echo $form->dropDownListRow($model,'employee_id',Employee::getList(),array('empty'=>'ALL', 'class'=>'span8')); ?>  
   </div>
  </div>
  
 
  <div class="row-fluid">
  <div class="span4">
	 <?php echo $form->dropDownListRow($model,'system_id',System::getList(),array('hint'=>'<strong>Tip:</strong> To multi-select items, hold down the CTRL key while clicking on each item or click one item and drag.', 'style'=>'height:150px;', 'multiple'=>true, 'class'=>'span8')); ?>
   </div>
   <div class="span4">
	 <?php echo $form->dropDownListRow($model,'type',ZHtml::enumItem($model,'type'),array('hint'=>'<strong>Tip:</strong> To multi-select items, hold down the CTRL key while clicking on each item or click one item and drag.', 'style'=>'height:150px;', 'multiple'=>true, 'class'=>'span8')); ?>
   </div>
   <div class="span4">
	 <?php echo $form->dropDownListRow($model,'status',ZHtml::enumItem($model,'status'),array('hint'=>'<strong>Tip:</strong> To multi-select items, hold down the CTRL key while clicking on each item or click one item and drag.', 'style'=>'height:150px;', 'multiple'=>true, 'class'=>'span8')); ?>  
   </div>   
  </div>
  
  <div class="row-fluid">
   <div class="span6">
	 <?php echo $form->textFieldRow($model,'from',array('class'=>'span8 datepicker')); ?>
   </div>
   <div class="span6">
	 <?php echo $form->textFieldRow($model,'to',array('class'=>'span8 datepicker')); ?>  
   </div>
  </div>
  
  <div class="row-fluid">
   <div class="span12">
	 <?php echo $form->checkBoxRow($model,'show_inactive',array('class'=>'')); ?>  
   </div>
  </div>
  
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
			'label'=>'Reset',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>'Print Report',
      'url'=>'#',
      'htmlOptions'=>array('id'=>'btn-print-report'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
