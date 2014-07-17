<?php
Yii::app()->clientScript->registerScript('auto-calc-percent-increase',"
$(document).ready(function(){
  calcIncrease();
  showReasonOther();
});
$('#EmployeePayroll_rate_proposed').bind('keypress keydown keyup change',function(){
  calcIncrease(); 
});
$('#WorkflowChangeNotice_reason').change(function(){
  showReasonOther();  
});

function showReasonOther(){
  if($('#WorkflowChangeNotice_reason').val() == 'Other'){
    $('#WorkflowChangeNotice_reason_other').show();  
  }else{
    $('#WorkflowChangeNotice_reason_other').hide();
  }
}

function calcIncrease(){
  var last = parseFloat($('#EmployeePayroll_last_rate_proposed').val());
  var current = parseFloat($('#EmployeePayroll_rate_proposed').val());
  var ans = 0;
  if(!isNaN(last) && !isNaN(current)){
    ans = ((current - last) / last) * 100;
  }else{
    ans = 0;
  }
  $('#EmployeePayroll_increase').val(ans);
}
");
?>
                                           
<fieldset><legend>Rate</legend>

<?php echo $form->dropDownListRow($notice,'reason',EmployeePayroll::getReasonList(),array('empty'=>'- select -','class'=>'span5')); ?>

<?php echo $form->textAreaRow($notice,'reason_other',array('class'=>'span5')); ?>

<?php echo $form->dropDownListRow($model_payroll,'rate_type',ZHtml::enumItem($model_payroll,'rate_type'),array('class'=>'span5','maxlength'=>6)); ?>

<?php echo $form->textFieldRow($model_payroll,'last_rate_proposed',array('prepend'=>'$','disabled'=>'disabled')); ?>

<?php echo $form->textFieldRow($model_payroll,'rate_proposed',array('prepend'=>'$','hint'=>'','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model_payroll,'increase',array('class'=>'span5', 'disabled'=>'disabled' , 'append'=>'%',)); ?>

<?php echo $form->textFieldRow($model_payroll,'last_rate_recommended',array('prepend'=>'$','disabled'=>'disabled')); ?>

<?php echo $form->textFieldRow($model_payroll,'rate_recommended',array('prepend'=>'$','hint'=>'','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->uneditableRow($model_payroll,'last_rate_approved',array('prepend'=>'$',)); ?>

<?php echo $form->textFieldRow($model_payroll,'rate_approved',array('prepend'=>'$','hint'=>'To be filled up by HR','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->uneditableRow($model_payroll,'last_wage_increase_date'); ?>

<?php echo $form->textFieldRow($model_payroll,'rate_effective_date',array('class'=>'span5 datepicker')); ?>
</fieldset>

<?php if(Yii::app()->user->getState('hr_group') != 'BOM'){ ?>
<fieldset><legend>Deductions</legend>
<?php echo $form->textFieldRow($model_payroll,'deduc_health_code',array('class'=>'span5','maxlength'=>32)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_health_amt',array('prepend'=>'$','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_dental_code',array('class'=>'span5','maxlength'=>32)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_dental_amt',array('prepend'=>'$','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_other_code',array('class'=>'span5','maxlength'=>32)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_other_amt',array('prepend'=>'$','class'=>'span5','maxlength'=>10)); ?>
</fieldset>
<?php } ?>

<fieldset><legend>PTO</legend>
<?php echo $form->radioButtonListRow($model_payroll, 'is_pto_eligible', array('1'=>'Yes','0'=>'No')); ?>

<?php echo $form->textFieldRow($model_payroll,'pto_effective_date',array('class'=>'span5 datepicker')); ?>
</fieldset>