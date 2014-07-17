<div class="control-group">
  <?php echo $form->labelEx($model_personal,'birthdate',array('class'=>'control-label')); ?>
  <div class="controls">
    <?php echo $form->dropDownList($model_personal,'dob_month',array(
      '01'=>'January',
      '02'=>'February',
      '03'=>'March',
      '04'=>'April',
      '05'=>'May',
      '06'=>'June',
      '07'=>'July',
      '08'=>'August',
      '09'=>'September',
      '10'=>'October',
      '11'=>'November',
      '12'=>'December',
    ),array('class'=>'input-medium','empty'=>'Month')); ?>
    <?php echo $form->error($model_personal,'dob_month'); ?>
    <?php
      $days = array();
      for($i=1 ; $i <= 31 ; $i++){$j = ($i<10) ? '0'.$i : $i;  $days[$j] = $j; }
      echo $form->dropDownList($model_personal,'dob_day',$days,array('class'=>'input-small','empty'=>'Day'));
      echo $form->error($model_personal,'dob_day');
      $years = array();
      $curr_year = date('Y');
      for($i=1901 ; $i <= $curr_year ; $i++) $years[$i] = $i;
      echo ' '.$form->dropDownList($model_personal,'dob_year',$years,array('value'=>$curr_year,'class'=>'input-medium','empty'=>'Year'));
      echo $form->error($model_personal,'dob_year');

    ?>
    <span id="EmployeePersonalInfo_dob_year_em_" class="help-inline error" style="display: none"></span>
  </div>
</div>



<?php //echo $form->textFieldRow($model_personal,'gender',array('class'=>'span5','maxlength'=>8)); ?>
<?php echo $form->radioButtonListRow($model_personal, 'gender', array('Male'=>'Male','Female'=>'Female'),array('checked')); ?>

<?php //echo $form->textFieldRow($model_personal,'marital_status',array('class'=>'span5','maxlength'=>16)); ?>
<?php echo $form->dropDownListRow($model_personal,'marital_status',array(
      'Single'=>'Single',
      'Married'=>'Married',
      'Separated'=>'Separated',
      'Divorced'=>'Divorced',
      'Widowed'=>'Widowed',
      //"Complicated"=>'Complicated',
    ),array('class'=>'input-medium')); ?>

<?php echo $form->textFieldRow($model_personal,'SSN',array('class'=>'span5','maxlength'=>128)); ?>
</fieldset>

<fieldset><legend>Contact</legend>
<?php echo $form->textFieldRow($model_personal,'building',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model_personal,'street',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model_personal,'city',array('class'=>'span5')); ?>

<?php echo $form->textFieldRow($model_personal,'state',array('class'=>'span5')); ?>

<?php echo $form->textFieldRow($model_personal,'zip_code',array('class'=>'span5')); ?>

<?php echo $form->textFieldRow($model_personal,'telephone',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model_personal,'cellphone',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model_personal,'email',array('class'=>'span5','maxlength'=>128)); ?>

