<?php

Yii::app()->clientScript->registerScript('dept_code_ready',"

$('#dept_preloader').hide();

setDeptCode($('#".CHtml::activeId($model_employment,'position_code')."').val());

",CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('position_code_change',"

$('#".CHtml::activeId($model_employment,'position_code')."').change(function(){

var pos_code = $(this).val();

setDeptCode(pos_code)

});

function setDeptCode(pos_code){

  $('#dept_preloader').fadeIn();

  var url = '".Yii::app()->createUrl("/hr/workflowchangenotice/getdeptcode")."';

  $.get(url,'poscode='+pos_code,function(response){

    var r = $.parseJSON(response);

    $('#".CHtml::activeId($model_employment,'department_code')."').val(r.dept_code); 

    $('#dept_preloader').fadeOut();  

  });

}

");

?>



<fieldset><legend>Employment</legend>



<?php 

$facility = Yii::app()->user->getState('hr_facility_handled_ids'); 

$facility = !empty($facility) ? $facility[0] : '';

$model_employment->facility_id = !empty($model_employment->facility_id) ? $model_employment->facility_id : $facility;

echo $form->dropDownListRow($model_employment,'facility_id',Facility::getList(),array('empty'=>'-select-','class'=>'span5','value'=>$facility)); ?>



<?php echo $form->dropDownListRow($model_employment, 'status', ZHtml::enumItem($model_employment,'status'),array('class'=>'span5')); ?>  



<?php /* if($notice->notice_type == 'NEW_HIRE') */ echo $form->textFieldRow($model_employment,'date_of_hire',array('class'=>'span5 datepicker')); ?>

<?php /* if($notice->notice_type != 'NEW_HIRE') */ echo $form->textFieldRow($model_employment,'end_date',array('class'=>'span5 datepicker')); ?>

<?php /* if($notice->notice_type != 'NEW_HIRE') */ echo $form->textFieldRow($model_employment,'date_of_termination',array('class'=>'span5 datepicker')); ?>



<?php echo $form->dropDownListRow($model_employment,'position_code',Position::getList(),array('hint'=>'Position Name - Department', 'empty'=>'-select-','class'=>'span5')); ?>



<?php echo $form->dropDownListRow($model_employment,'department_code',Department::getList(),array( 'readonly'=>'readonly', 'hint'=>'This field is automatically set. Do not modify!', 'empty'=>'(auto selected)','class'=>'span5')); ?>



<div id="dept_preloader" class="control-group">

<div class="controls">

<img src="<?php echo Yii::app()->baseUrl; ?>/images/preloader.GIF" style="width:25px;"/><small class="muted"> Auto-setting department code...</small> 

</div>

</div>



<?php echo $form->textFieldRow($model_employment,'start_date',array('class'=>'span5 datepicker')); ?>



<?php //echo $form->textFieldRow($model_employment,'end_date',array('class'=>'span5 datepicker')); ?>



<?php //echo $form->fileFieldRow($model_employment,'contract_file',array('class'=>'span5','readonly'=>'readonly')); ?>

                                      

<?php echo $form->checkBoxRow($model_employment,'has_union',array('hint'=>'Check if this employee is a member of a union.')); ?>



</fieldset>

