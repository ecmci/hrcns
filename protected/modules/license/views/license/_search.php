<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); 
 Helper::includeJui();
 Helper::renderDatePickers();
?>

  <div class="row-fluid">
   <div class="span4">
	 <?php echo $form->textFieldRow($model,'emp_id',array('class'=>'span12','maxlength'=>128)); ?>  
   </div>
   <div class="span4">
   <?php echo $form->textFieldRow($model,'name',array('class'=>'span12','maxlength'=>128)); ?> 
   </div>
   <div class="span4">
	<?php echo $form->textFieldRow($model,'serial_number',array('class'=>'span12')); ?>
   </div>
  </div>
                            
  <div class="row-fluid">
   <div class="span4">
	<?php echo $form->textFieldRow($model,'date_issued',array('class'=>'span12 datepicker')); ?>
   </div>
   <div class="span4">
	<?php echo $form->textFieldRow($model,'expiring_from',array('class'=>'span12 datepicker')); ?>
   </div>
   <div class="span4">
  <?php echo $form->textFieldRow($model,'expiring_until',array('class'=>'span12 datepicker')); ?>  
   </div>
  </div>
  
  <div class="row-fluid">
   <div class="span4">
	<?php echo $form->dropDownListRow($model,'due_weeks_from_now',array('1'=>'Next Week','2'=>'2','3'=>'3','4'=>'4'),array('empty'=>'', 'class'=>'span12')); ?>
   </div>
   <div class="span4">
	<?php echo $form->dropDownListRow($model,'due_months_from_now',array('1'=>'Next Month','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6'),array('empty'=>'', 'class'=>'span12')); ?>
   </div>
   <div class="span4">
    
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
	</div>

<?php $this->endWidget(); ?>
