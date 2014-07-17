<?php
$this->layout = 'column1';
$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WorkflowChangeNotice','url'=>array('index')),
	array('label'=>'Manage WorkflowChangeNotice','url'=>array('admin')),
);

Helper::includeJui();
Helper::renderDatePickers();
Yii::app()->clientScript->registerScript('niceOne',"
$(document).ready(function(){
  /*$('#btn-submit').attr('disabled','disabled');  
  var windowHeight = $(window).height()-500;
  $('.tab-content').height(windowHeight); */ 
});
$('#EmployeePayroll_state_add').focus(function(){
  /*$('#btn-submit').removeAttr('disabled');*/    
});
");
?>

<h1 class="page-header">New Change Notice Form - <?php echo $emp_basic->getFullName(); ?></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workflow-change-notice-form',
  'type'=>'horizontal',
  'enableClientValidation'=>true,
  'enableAjaxValidation'=>true,
  'focus'=>array($model,'notice_type'),
  'clientOptions'=>array(
    'validateOnSubmit'=>false,
  ),
  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>


  
  <?php //echo $form->errorSummary($emp_basic,'Basic Information Section Errors:');?>  
  <?php //echo $form->errorSummary($emp_personal,'Personal Data Section Errors:');?>
  <?php //echo $form->errorSummary($emp_employment,'Employment Details Section Errors:');?>
  <?php //echo $form->errorSummary($emp_payroll,'Payroll Specifications Section Errors:');?>
 

  <fieldset><legend>1. Select Change Notice Type</legend>
  <?php echo $this->renderPartial('_new', array('model'=>$model,'form'=>$form)); ?>
  </fieldset>
  
  <fieldset><legend>2. Update Basic, Personal, Employment and Payroll Details <small>(as needed)</small></legend>
  <?php echo $this->renderPartial('_new_details', array(
    'model'=>$model,
    'emp_basic'=>$emp_basic,
    'emp_personal'=>$emp_personal,
    'emp_employment'=>$emp_employment,
    'emp_payroll'=>$emp_payroll,
    'form'=>$form
  )); ?>
  </fieldset>
  
  <fieldset><legend>3. Comment <small>(Optional)</small></legend>
  <?php echo $form->textAreaRow($model,'comment',array('class'=>'span5')); ?>
  </fieldset>
  
  <fieldset><legend>4. Submit</legend>
  <div class="form-actions">
    <?php echo $form->errorSummary($model);?>
    <?php echo $form->errorSummary($emp_basic);?>  
    <?php echo $form->errorSummary($emp_personal);?>
    <?php echo $form->errorSummary($emp_employment);?>
    <?php echo $form->errorSummary($emp_payroll);?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit','size'=>'large')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
  </div>
  </fieldset>

<?php $this->endWidget(); ?>     