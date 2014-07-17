<?php
$this->breadcrumbs=array(
	'Employee Employments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeEmployment','url'=>array('index')),
	array('label'=>'Create EmployeeEmployment','url'=>array('create')),
	array('label'=>'Update EmployeeEmployment','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete EmployeeEmployment','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeEmployment','url'=>array('admin')),
);
?>

<h1>View EmployeeEmployment #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'emp_id',
		'status',
		'date_of_hire',
		'date_of_termination',
		'department_code',
		'position_code',
		'start_date',
		'end_date',
		'contract_file',
		'reports_to',
		'is_approved',
		'timestamp',
	),
)); ?>
