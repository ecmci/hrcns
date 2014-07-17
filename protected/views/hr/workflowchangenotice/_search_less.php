<fieldset><legend>Define Your Search...</legend>
<?php
Helper::includeJui();
Helper::renderDatepickers();
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'search-change-notice',
  'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="row-fluid">   
    <div class="span3">
    <?php echo $form->textFieldRow($model,'id',array('class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'facility',Facility::getList(),array('empty'=>'ALL', 'class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'processing_group',ZHtml::enumItem($model,'processing_group'),array('empty'=>'ALL', 'class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'processing_user',User::getList(),array('empty'=>'','class'=>'span12')); ?>
    </div>
  </div>
  <div class="row-fluid">    
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'notice_type',ZHtml::enumItem($model,'notice_type'),array('empty'=>'ALL', 'class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'status',ZHtml::enumItem($model,'status'),array('class'=>'span12','multiple'=>true,'hint'=>'To select multiple statuses, hold down the CTRL key and click an item.')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'notice_sub_type',ZHtml::enumItem($model,'notice_sub_type'),array('class'=>'span12', 'empty'=>'' ,'hint'=>'To select multiple statuses, hold down the CTRL key and click an item.')); ?>
    </div>
  </div>
  <div class="row-fluid">   
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'reason',EmployeePayroll::getReasonList(),array('empty'=>'ALL','class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->textFieldRow($model,'effective_from',array('empty'=>'','class'=>'datepicker span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->textFieldRow($model,'effective_to',array('empty'=>'','class'=>'datepicker span12')); ?>
    </div>    
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'initiated_by',User::getList(),array('empty'=>'','class'=>'span12')); ?>
    </div>
    <?php /*
    <div class="span3">
  	<?php echo $form->textFieldRow($model,'timestamp',array('hint'=>'You may use >,<,>=,<= to specify ranges.','class'=>'span12','placeholder'=>'yyy-mm-dd')); ?>
    </div
    */ ?>
  </div>
  <div class="row-fluid">
     <div class="span3">
  	<?php echo $form->dropDownListRow($model,'bom_id',User::getList(),array('empty'=>'','class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'fac_adm_id',User::getList(),array('empty'=>'','class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'mnl_id',User::getList(),array('empty'=>'','class'=>'span12')); ?>
    </div>
    <div class="span3">
  	<?php echo $form->dropDownListRow($model,'corp_id',User::getList(),array('empty'=>'','class'=>'span12')); ?>
    </div>
  </div>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
      'size'=>'large',
      'icon'=>'icon-search icon-white'
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'',
      'size'=>'medium',
			'label'=>'Print Preview',
      'htmlOptions'=>array('id'=>'btn-print-preview'),
      'url'=>'#',
      'icon'=>'icon-print'
		)); ?>
	</div>

<?php $this->endWidget(); ?>
</fieldset>