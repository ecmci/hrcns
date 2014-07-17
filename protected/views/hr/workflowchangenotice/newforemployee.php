<?php
$this->layout = 'column1';
$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	'Select Employee',
);
Yii::app()->clientScript->registerScript("newforemployee","
$('#emp-list').change(function(){
  var url = '".Yii::app()->createUrl('hr/workflowchangenotice/new')."';
  var params = 'id=' + $('#emp-list').val();
  window.location = url + '?' + params;  
});
");
?>

<h1 class="page-header">Select An Employee:</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workflow-change-notice-form',
  'type'=>'horizontal',
	'action'=>array('hr/workflowchangenotice/new/?id='),
  'method'=>'get',
)); ?> 

<?php echo $form->dropDownListRow(new Employee,'emp_id',Employee::getList(),array('required', 'description'=>'id', 'id'=>'emp-list', 'empty'=>'- select -','class'=>'span5','hint'=>'<strong>Tip:</strong> Narrow down your search by typing the first letter of the employee\'s last name.<br /><small><strong>Note:</strong> This employee list is limited to: '.HrUser::getMyFacilities(true).'</small>')); ?>

<?php $this->endWidget(); ?>