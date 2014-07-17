<?php
 Yii::app()->clientScript->registerCss('prepend',"
 .input-prepend { margin-right:10px; } 
 ");
?>
<div class="control-group">
  <?php echo $form->labelEx($personal,'birthdate',array('class'=>'control-label')); ?>
  <div class="controls">
    <?php 
      $days = array();
      $months = array(
        '01'=>'January',
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
      );
      $year  = array();
      for ($i = 1; $i <= 31 ; $i++ ) { $tmp = $i < 10 ? '0'.$i : $i; $days[$tmp] = $tmp;}
      for ($i = date('Y',time()); $i >= 1900 ; $i-- ) { $tmp = $i < 10 ? '0'.$i : $i; $year[$tmp] = $tmp;}               
    ?>
    <div class="input-prepend input-append"> 
      <span class="add-on">Month</span>
      <?php echo $form->dropDownList($personal,'month',$months,array('hint'=>'', 'empty'=>'', 'class'=>'span8') ); ?>
    </div>
    <div class="input-prepend input-append"> 
      <span class="add-on">Day</span>
      <?php echo $form->dropDownList($personal,'day',$days,array('empty'=>'', 'class'=>'span8') ); ?>
    </div>
    <div class="input-prepend input-append"> 
      <span class="add-on">Year</span>
      <?php echo $form->dropDownList($personal,'year',$year,array('empty'=>'', 'class'=>'span8') ); ?>
    </div>
    <?php echo $form->error($personal,'birthdate'); ?> 
  </div> 
</div>

<?php echo $form->radioButtonListRow($personal, 'gender', array('Male'=>'Male','Female'=>'Female'),array('checked')); ?>

<?php echo $form->dropDownListRow($personal,'marital_status',array(
      'Single'=>'Single',
      'Married'=>'Married',
      'Separated'=>'Separated',
      'Divorced'=>'Divorced',
      'Widowed'=>'Widowed',
      //"Complicated"=>'Complicated',
    ),array('class'=>'span5')); ?>

<?php echo $form->textFieldRow($personal,'SSN',array('class'=>'span5','maxlength'=>128)); ?>

<fieldset><legend>Contact</legend>
<div class="control-group">
    <?php echo $form->labelEx($personal,'state',array('class'=>'control-label')); ?>
    <div class="controls">
    <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
    'name'=>'typeahead0',
    'model'=>$personal,
    'attribute'=>'state',
    'options'=>array(
        'source'=>State::getList(),
        'items'=>15,
        'matcher'=>"js:function(item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase());
        }",
    ),
    'htmlOptions'=>array('class'=>'span5'),
)); ?> 
    </div>   
</div>

<div class="control-group">
    <?php echo $form->labelEx($personal,'zip_code',array('class'=>'control-label')); ?>
    <div class="controls">
    <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
    'name'=>'typeahead1',
    'model'=>$personal,
    'attribute'=>'zip_code',
    'options'=>array(
        'source'=>ZipCode::getZipCodeList(),
        'items'=>15,
        'matcher'=>"js:function(item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase());
        }",
    ),
    'htmlOptions'=>array('class'=>'span5'),
)); ?> 
    </div>   
</div>

<div class="control-group">
    <?php echo $form->labelEx($personal,'city',array('class'=>'control-label')); ?>
    <div class="controls">
    <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
    'name'=>'typeahead2',
    'model'=>$personal,
    'attribute'=>'city',
    'options'=>array(
        'source'=>ZipCode::getCityList(),
        'items'=>15,
        'matcher'=>"js:function(item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase());
        }",
    ),
    'htmlOptions'=>array('class'=>'span5'),
)); ?> 
    </div>   
</div>

<?php echo $form->textFieldRow($personal,'street',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($personal,'telephone',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($personal,'cellphone',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($personal,'email',array('class'=>'span5','maxlength'=>128)); ?>
</fieldset>
