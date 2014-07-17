<fieldset><legend>Rate</legend>

<?php echo $form->dropDownListRow($model_payroll,'rate_type',ZHtml::enumItem($model_payroll,'rate_type'),array('class'=>'span5','maxlength'=>6)); ?>

<?php echo $form->textFieldRow($model_payroll,'rate_proposed',array('prepend'=>'$','hint'=>'Input Example: 13.55','class'=>'span5','maxlength'=>10)); ?>

<?php //echo $form->textFieldRow($model_payroll,'rate_recommended',array('prepend'=>'$','hint'=>'Input Example: 13.55','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model_payroll,'rate_approved',array('prepend'=>'$','hint'=>'Input Example: 13.55. To be filled up by HR','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model_payroll,'rate_effective_date',array('class'=>'span5 datepicker')); ?>
</fieldset>

<?php if(Yii::app()->user->getState('hr_group') != 'BOM'){ ?>
<fieldset><legend>Deductions</legend>
<?php echo $form->textFieldRow($model_payroll,'deduc_health_code',array('class'=>'span5','maxlength'=>32)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_health_amt',array('hint'=>'Input Example: 13.55', 'prepend'=>'$','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_dental_code',array('class'=>'span5','maxlength'=>32)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_dental_amt',array('hint'=>'Input Example: 13.55', 'prepend'=>'$','class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_other_code',array('class'=>'span5','maxlength'=>32)); ?>

<?php echo $form->textFieldRow($model_payroll,'deduc_other_amt',array('hint'=>'Input Example: 13.55', 'prepend'=>'$','class'=>'span5','maxlength'=>10)); ?>
</fieldset>
<?php } ?>


<fieldset><legend>PTO</legend>
<?php //echo $form->radioButtonListRow($model_payroll, 'is_pto_eligible', array('1'=>'Yes','0'=>'No')); ?>
<div class="control-group">
  <label class="control-label required" for="EmployeePayroll_state_add">Is Eligible for PTO? <span class="required">*</span></label>
  <div class="controls">
  <?php echo $form->radioButtonList($model_payroll,'is_pto_eligible',array('1'=>'Yes','0'=>'No')); ?>
  <?php echo $form->error($model_payroll,'is_pto_eligible'); ?>
  </div>
</div>

<div class="control-group">
  <label for="EmployeePayroll_pto_effective_date" class="control-label">PTO Effective Date <span class="required">*</span></label>
  <div class="controls">
  <?php echo $form->textField($model_payroll,'pto_effective_date',array('class'=>'span5 datepicker')); ?>  
  <?php echo $form->error($model_payroll,'pto_effective_date'); ?>
  </div>
</div>

<?php //echo $form->textFieldRow($model_payroll,'pto_effective_date',array('class'=>'span5 datepicker')); ?>
</fieldset>