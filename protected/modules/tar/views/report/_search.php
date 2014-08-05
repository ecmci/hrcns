<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

  <div class="row-fluid">
   <div class="span4">
    <?php echo $form->textFieldRow($model,'resident',array('class'=>'span12','maxlength'=>45)); ?>
    <?php echo $form->textFieldRow($model,'control_num',array('class'=>'span12','maxlength'=>45)); ?>
    <?php echo $form->textFieldRow($model,'medical_num',array('class'=>'span12','maxlength'=>45)); ?>    
    <?php echo $form->dropDownListRow($model,'facility_id',TarUser::getFacilityList(true),array('class'=>'span12','empty'=>'All')); ?>
   </div>
   <div class="span4">
    <?php echo $form->textFieldRow($model,'requested_dos_date_from',array('class'=>'span12 datepicker')); ?>
    <?php echo $form->textFieldRow($model,'requested_dos_date_thru',array('class'=>'span12 datepicker')); ?>    
    <?php echo $form->dropDownListRow($model,'status_id',TarStatus::getList(),array('class'=>'span12','multiple'=>true)); ?>
    <?php echo $form->dropDownListRow($model,'is_closed',array('0'=>'Open','1'=>'Closed'),array('class'=>'span12','empty'=>'All')); ?>
   </div>
  </div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
      'size'=>'large',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
			'label'=>'Reset',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
