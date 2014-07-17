<?php
$this->pageTitle = Yii::app()->name.' | Applicant Self Service';
$this->layout = 'column1';
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Applicant Self Service',
);

?>
<div class="row-fluid">
  <h1>Self-Service New Hire Form</h1>
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  	  'id'=>'self-service-form',
      'type'=>'horizontal',
   	  'enableClientValidation'=>true,
      'enableAjaxValidation'=>true,
      'focus'=>array($model,'last_name'),
    	'clientOptions'=>array(
    		'validateOnSubmit'=>true,
    	),
      'htmlOptions'=>array(
    		'enctype'=>'multipart/form-data',
    	),
  )); ?>
  <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php require_once '_form_basic.php';  ?>


    <?php require_once '_form_personal.php';  ?>

  
  <fieldset><legend>Facility</legend>
    <?php echo $form->dropDownListRow($model_employment,'facility_id',Facility::getList(),array('empty'=>'-select-','class'=>'span5')); ?>
  </fieldset>
  
  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit','size'=>'large')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
  </div>
  
<?php $this->endWidget(); ?>
</div>
<br/><br/><br/>