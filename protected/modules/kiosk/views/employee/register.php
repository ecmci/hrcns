<?php
$this->pageTitle = 'Kiosk - New Employee Registration';
$this->layout = '//layouts/column1';
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Self-Service Registration',
);
Helper::uploadifyFileFields();
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'employee-kiosk-form',
	'enableAjaxValidation'=>true,
  'type'=>'horizontal',
)); ?>

<div class="row-fluid">
 <div class="span12">
 <?php echo $form->errorSummary(array($employee,$personal,$employment)); ?>
 <fieldset>
  <legend>Employment</legend>
  <?php $this->renderPartial('_employment',array('employment'=>$employment,'form'=>$form) ); ?>
 </fieldset>
 <fieldset>
  <legend>Basic Information</legend>
  <?php $this->renderPartial('_employee',array('employee'=>$employee,'form'=>$form) ); ?>
  <?php $this->renderPartial('_personal',array('personal'=>$personal,'form'=>$form) ); ?>
 </fieldset> 
 </div>
</div>

<div class="form-actions">
  <?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
    'size'=>'large',
		'label'=>'Submit',
	)); ?>
</div>

<?php $this->endWidget(); ?>